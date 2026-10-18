<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReconciliacionController extends Controller
{
    public function index()
    {
        return view('reconciliacion.index', [
            'productos' => Product::query()->orderBy('nombre')->get(['id', 'nombre', 'sku']),
            'historial' => DB::table('reconciliaciones')->orderByDesc('id')->limit(20)->get(),
        ]);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'archivo_csv' => ['required', 'file', 'mimes:csv,txt', 'max:20480'],
        ]);

        $handle = fopen($request->file('archivo_csv')->getRealPath(), 'r');
        if (!$handle) {
            return back()->withErrors(['archivo_csv' => 'No se pudo leer el archivo.'])->withInput();
        }
        $firstLine = fgets($handle);
        if ($firstLine === false) {
            fclose($handle);
            return back()->withErrors(['archivo_csv' => 'El archivo está vacío.'])->withInput();
        }

        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';
        rewind($handle);
        $headers = fgetcsv($handle, 0, $delimiter);
        if (!$headers) {
            fclose($handle);
            return back()->withErrors(['archivo_csv' => 'No se pudieron leer los encabezados.'])->withInput();
        }

        $normalize = static function ($value) {
            $value = preg_replace('/^\xEF\xBB\xBF/', '', (string) $value);
            $value = mb_strtolower(trim($value));
            $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
            return preg_replace('/[^a-z0-9]/', '', $value);
        };
        $normalized = array_map($normalize, $headers);
        $aliases = [
            'razonsocial' => ['razonsocial', 'razonsocialcliente', 'cliente'],
            'emision' => ['emision', 'fecha', 'fechamovimiento'],
            'ingresos' => ['ingresos', 'ingreso', 'entrada', 'entradas'],
            'salidas' => ['salidas', 'salida'],
        ];
        $indexes = [];
        foreach ($aliases as $field => $options) {
            foreach ($normalized as $i => $header) {
                if (in_array($header, $options, true)) {
                    $indexes[$field] = $i;
                    break;
                }
            }
        }
        $missing = array_values(array_diff(['razonsocial', 'emision', 'ingresos', 'salidas'], array_keys($indexes)));
        if ($missing) {
            fclose($handle);
            return back()->withErrors(['archivo_csv' => 'Faltan columnas necesarias: '.implode(', ', $missing).'. Se requieren Razón social, Emisión, Ingresos y Salidas.'])->withInput();
        }

        // Excluir solo columnas identificadas explícitamente como RUC.
        $visibleHeaders = [];
        foreach ($headers as $i => $header) {
            if (in_array($normalize($header), ['ruc', 'numeroruc', 'ruccliente', 'rucdelcliente', 'nroruc'], true)) {
                continue;
            }
            $visibleHeaders[$i] = trim((string) $header);
        }

        $rows = [];
        $line = 1;
        while (($record = fgetcsv($handle, 0, $delimiter)) !== false) {
            $line++;
            if (count(array_filter($record, fn($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }
            $values = [];
            foreach ($visibleHeaders as $i => $header) {
                $values[$header] = trim((string) ($record[$i] ?? ''));
            }
            $rows[] = [
                'fila' => $line,
                'razon_social' => trim((string) ($record[$indexes['razonsocial']] ?? '')),
                'fecha_movimiento' => $this->parseDate($record[$indexes['emision']] ?? ''),
                'ingresos' => $this->parseNumber($record[$indexes['ingresos']] ?? 0),
                'salidas' => $this->parseNumber($record[$indexes['salidas']] ?? 0),
                'valores' => $values,
            ];
        }
        fclose($handle);
        if (!$rows) {
            return back()->withErrors(['archivo_csv' => 'El archivo no contiene movimientos.'])->withInput();
        }

        $token = (string) Str::uuid();
        Storage::disk('local')->put('reconciliacion-temp/'.$token.'.json', json_encode([
            'product_id' => (int) $request->product_id,
            'archivo_nombre' => $request->file('archivo_csv')->getClientOriginalName(),
            'rows' => $rows,
        ], JSON_UNESCAPED_UNICODE));

        return view('reconciliacion.index', [
            'productos' => Product::query()->orderBy('nombre')->get(['id', 'nombre', 'sku']),
            'productoSeleccionado' => (int) $request->product_id,
            'previewRows' => $rows,
            'csvHeaders' => array_values($visibleHeaders),
            'archivoNombre' => $request->file('archivo_csv')->getClientOriginalName(),
            'previewCount' => count($rows),
            'previewToken' => $token,
            'historial' => DB::table('reconciliaciones')->orderByDesc('id')->limit(20)->get(),
        ]);
    }

    public function save(Request $request)
    {
        $request->validate(['preview_token' => ['required', 'uuid']]);
        $path = 'reconciliacion-temp/'.$request->preview_token.'.json';
        if (!Storage::disk('local')->exists($path)) {
            return redirect()->route('reconciliacion.index')->withErrors(['archivo_csv' => 'La vista previa venció o ya fue guardada. Vuelve a cargar el CSV.']);
        }
        $payload = json_decode(Storage::disk('local')->get($path), true);
        if (!is_array($payload) || empty($payload['rows']) || empty($payload['product_id'])) {
            Storage::disk('local')->delete($path);
            return redirect()->route('reconciliacion.index')->withErrors(['archivo_csv' => 'No se pudo recuperar la vista previa. Vuelve a cargar el CSV.']);
        }

        $product = Product::findOrFail($payload['product_id']);
        $count = count($payload['rows']);
        $id = DB::transaction(function () use ($payload, $product, $request, $count) {
            $dates = collect($payload['rows'])->pluck('fecha_movimiento')->filter()->sort()->values();
            $id = DB::table('reconciliaciones')->insertGetId([
                'nombre' => $product->nombre,
                'archivo_origen' => mb_substr((string) $payload['archivo_nombre'], 0, 255),
                'fecha_desde' => $dates->first(),
                'fecha_hasta' => $dates->last(),
                'estado' => 'pendiente',
                'total_movimientos' => $count,
                'total_coincidencias' => 0,
                'total_diferencias' => 0,
                'total_pendientes' => $count,
                'usuario_id' => $request->user()?->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach (array_chunk($payload['rows'], 300) as $chunk) {
                $insert = [];
                foreach ($chunk as $row) {
                    $insert[] = [
                        'reconciliacion_id' => $id,
                        'numero_fila' => $row['fila'] ?? null,
                        'razon_social' => $row['razon_social'] ?? null,
                        'fecha_movimiento' => $row['fecha_movimiento'] ?: null,
                        'ingresos' => $row['ingresos'] ?? 0,
                        'salidas' => $row['salidas'] ?? 0,
                        'datos_adicionales' => json_encode($row['valores'] ?? [], JSON_UNESCAPED_UNICODE),
                        'estado_conciliacion' => 'pendiente',
                        'movimiento_kardex_id' => null,
                        'observacion' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('reconciliacion_movimientos')->insert($insert);
            }
            return $id;
        });

        Storage::disk('local')->delete($path);
        return redirect()->route('reconciliacion.index')->with('success', "Se guardó la conciliación #{$id} con {$count} movimientos. El stock de DISTAN no fue modificado.");
    }

    private function parseNumber($value): float
    {
        $value = trim((string) $value);
        if ($value === '') return 0;
        if (str_contains($value, ',') && str_contains($value, '.')) {
            if (strrpos($value, ',') > strrpos($value, '.')) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
            } else {
                $value = str_replace(',', '', $value);
            }
        } elseif (str_contains($value, ',') && !str_contains($value, '.')) {
            $value = str_replace(',', '.', $value);
        }
        return is_numeric($value) ? (float) $value : 0;
    }

    private function parseDate($value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') return null;
        foreach (['d/m/Y', 'd-m-Y', 'Y-m-d', 'Y/m/d', 'd/m/y'] as $format) {
            try {
                $date = Carbon::createFromFormat('!'.$format, $value);
                if ($date && $date->format($format) === $value) return $date->format('Y-m-d');
            } catch (\Throwable $e) {}
        }
        try { return Carbon::parse($value)->format('Y-m-d'); } catch (\Throwable $e) { return null; }
    }
}
