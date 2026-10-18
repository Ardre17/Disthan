<?php

namespace App\Http\Controllers;

use App\Models\Desmedro;
use App\Models\Movement;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Models\ProductionOrder;
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
            'historial' => DB::table('reconciliaciones')->orderByDesc('id')->limit(30)->get(),
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
            $converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
            return preg_replace('/[^a-z0-9]/', '', $converted === false ? $value : $converted);
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

        $visibleHeaders = [];
        foreach ($headers as $i => $header) {
            if (in_array($normalize($header), ['ruc', 'numeroruc', 'ruccliente', 'rucdelcliente', 'nroruc'], true)) continue;
            $visibleHeaders[$i] = trim((string) $header);
        }

        $rows = [];
        $line = 1;
        while (($record = fgetcsv($handle, 0, $delimiter)) !== false) {
            $line++;
            if (count(array_filter($record, fn($v) => trim((string) $v) !== '')) === 0) continue;
            $values = [];
            foreach ($visibleHeaders as $i => $header) $values[$header] = trim((string) ($record[$i] ?? ''));
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
        if (!$rows) return back()->withErrors(['archivo_csv' => 'El archivo no contiene movimientos.'])->withInput();

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
            'historial' => DB::table('reconciliaciones')->orderByDesc('id')->limit(30)->get(),
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
                'product_id' => $product->id,
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


    /** Muestra el detalle comparativo guardado de una conciliación. */
    public function show(Request $request, $id)
    {
        $reconciliacion = DB::table('reconciliaciones')->where('id', $id)->first();
        abort_unless($reconciliacion, 404);

        $query = DB::table('reconciliacion_movimientos')
            ->where('reconciliacion_id', $id)
            ->orderBy('numero_fila');

        $estado = $request->query('estado');
        if (in_array($estado, ['coincidencia', 'diferencia', 'pendiente'], true)) {
            $query->where('estado_conciliacion', $estado);
        }

        $movimientos = $query->get()->map(function ($row) {
            $extra = json_decode($row->datos_adicionales ?: '{}', true);
            if (!is_array($extra)) $extra = [];
            $match = $extra['_conciliacion'] ?? [];
            $row->datos_csv = array_diff_key($extra, ['_conciliacion' => true]);
            $row->kardex = is_array($match) ? $match : [];
            $row->cantidad_csv = (float) ($row->ingresos > 0 ? $row->ingresos : $row->salidas);
            $row->tipo_csv = $row->ingresos > 0 ? 'Ingreso' : ($row->salidas > 0 ? 'Salida' : 'Sin tipo');
            $row->cantidad_kardex = isset($row->kardex['cantidad_kardex']) ? (float) $row->kardex['cantidad_kardex'] : null;
            $row->diferencia_cantidad = $row->cantidad_kardex !== null
                ? round($row->cantidad_csv - $row->cantidad_kardex, 3)
                : null;
            return $row;
        });

        $conteos = DB::table('reconciliacion_movimientos')
            ->where('reconciliacion_id', $id)
            ->selectRaw("COUNT(*) AS total")
            ->selectRaw("SUM(CASE WHEN estado_conciliacion = 'coincidencia' THEN 1 ELSE 0 END) AS coincidencias")
            ->selectRaw("SUM(CASE WHEN estado_conciliacion = 'diferencia' THEN 1 ELSE 0 END) AS diferencias")
            ->selectRaw("SUM(CASE WHEN estado_conciliacion = 'pendiente' THEN 1 ELSE 0 END) AS pendientes")
            ->first();

        return view('reconciliacion.show', [
            'reconciliacion' => $reconciliacion,
            'movimientos' => $movimientos,
            'estadoFiltro' => $estado,
            'conteos' => $conteos,
        ]);
    }

    /** Compara los movimientos importados contra las mismas fuentes del Kardex. Solo lectura. */
    public function compare($id)
    {
        $reconciliacion = DB::table('reconciliaciones')->where('id', $id)->first();
        abort_unless($reconciliacion, 404);
        if (empty($reconciliacion->product_id)) {
            return redirect()->route('reconciliacion.index')->withErrors(['comparacion' => 'Esta conciliación no tiene producto asociado. Ejecuta el SQL de actualización y vuelve a importar el CSV para guardar el producto.']);
        }

        $rows = DB::table('reconciliacion_movimientos')->where('reconciliacion_id', $id)->orderBy('numero_fila')->get();
        if ($rows->isEmpty()) return redirect()->route('reconciliacion.index')->withErrors(['comparacion' => 'La conciliación no contiene movimientos.']);

        $validDates = $rows->pluck('fecha_movimiento')->filter()->map(fn($d) => Carbon::parse($d));
        $minDate = $validDates->isNotEmpty() ? $validDates->min()->copy()->subDays(7)->startOfDay() : now()->subYears(10)->startOfDay();
        $maxDate = $validDates->isNotEmpty() ? $validDates->max()->copy()->addDays(7)->endOfDay() : now()->endOfDay();
        $productId = (int) $reconciliacion->product_id;
        $candidates = collect();

        $entries = ProductEntry::where('product_id', $productId)->whereBetween('created_at', [$minDate, $maxDate])->get();
        foreach ($entries as $m) $candidates->push($this->candidate('ProductEntry', $m->id, $m->created_at, 'ingreso', $m->quantity, 'Entrada directa', $m->supplier));

        $production = ProductionOrder::where('product_id', $productId)->where('status', 'FINALIZADA')->whereBetween('created_at', [$minDate, $maxDate])->get();
        foreach ($production as $m) $candidates->push($this->candidate('ProductionOrder', $m->id, $m->created_at, 'ingreso', $m->produced_quantity, 'Producción', $m->number));

        $orders = Order::with('details')->whereIn('estado', ['COMPLETO', 'PARCIAL', 'INCOMPLETO'])->whereBetween('fecha_pedido', [$minDate->toDateString(), $maxDate->toDateString()])->whereHas('details', fn($q) => $q->where('product_id', $productId))->get();
        foreach ($orders as $order) foreach ($order->details as $detail) {
            if ((int) $detail->product_id !== $productId || (float) $detail->cantidad_despachada <= 0) continue;
            $candidates->push($this->candidate('OrderDetail', $detail->id, $order->fecha_pedido, 'salida', $detail->cantidad_despachada, 'Despacho', $order->numero_orden));
        }

        $movements = Movement::where('product_id', $productId)->where('tipo', 'SALIDA')->whereBetween('created_at', [$minDate, $maxDate])->get();
        foreach ($movements as $m) $candidates->push($this->candidate('Movement', $m->id, $m->created_at, 'salida', $m->cantidad, 'Salida de producción', $m->motivo));

        $desmedros = Desmedro::with('detalles')->where('estado', 'registrado')->whereBetween('registrado_at', [$minDate, $maxDate])->whereHas('detalles', fn($q) => $q->where('producto_id', $productId))->get();
        foreach ($desmedros as $d) foreach ($d->detalles as $detail) {
            if ((int) $detail->producto_id !== $productId || (float) $detail->cantidad <= 0) continue;
            $candidates->push($this->candidate('DesmedroDetalle', $detail->id, $d->registrado_at ?? $d->updated_at, 'salida', $detail->cantidad, 'Desmedro', $d->codigo));
        }

        $used = [];
        $counts = ['coincidencia' => 0, 'diferencia' => 0, 'pendiente' => 0];
        DB::transaction(function () use ($rows, $candidates, &$used, &$counts, $id) {
            foreach ($rows as $row) {
                $externalDate = $row->fecha_movimiento ? Carbon::parse($row->fecha_movimiento) : null;
                $direction = (float) $row->ingresos > 0 ? 'ingreso' : ((float) $row->salidas > 0 ? 'salida' : null);
                $quantity = $direction === 'ingreso' ? (float) $row->ingresos : ($direction === 'salida' ? (float) $row->salidas : 0.0);
                $eligible = $candidates->filter(function ($candidate) use ($direction, $externalDate, $used) {
                    if (!$direction || $candidate['direction'] !== $direction || isset($used[$candidate['key']])) return false;
                    if (!$externalDate || !$candidate['date']) return false;
                    return abs($externalDate->diffInDays($candidate['date'], false)) <= 7;
                })->sortBy(fn($candidate) => abs($externalDate->diffInSeconds($candidate['date'])))->values();

                $exact = $eligible->first(fn($candidate) => abs($candidate['quantity'] - $quantity) < 0.001);
                $nearest = $exact ?: $eligible->first();
                $status = 'pendiente';
                $matchedId = null;
                $observation = 'No se encontró movimiento compatible en el Kardex dentro de ±7 días.';
                $extra = json_decode($row->datos_adicionales ?: '{}', true);
                if (!is_array($extra)) $extra = [];

                if ($exact) {
                    $status = 'coincidencia';
                    $used[$exact['key']] = true;
                    $matchedId = $exact['id'];
                    $observation = 'Coincide por tipo, cantidad y fecha dentro de ±7 días.';
                    $extra['_conciliacion'] = ['fuente' => $exact['source'], 'referencia' => $exact['reference'], 'fecha_kardex' => $exact['date']->toDateString(), 'cantidad_kardex' => $exact['quantity']];
                } elseif ($nearest) {
                    $status = 'diferencia';
                    $used[$nearest['key']] = true;
                    $matchedId = $nearest['id'];
                    $observation = 'Se encontró un movimiento del mismo tipo, pero la cantidad difiere. CSV: '.$quantity.'; Kardex: '.$nearest['quantity'].'.';
                    $extra['_conciliacion'] = ['fuente' => $nearest['source'], 'referencia' => $nearest['reference'], 'fecha_kardex' => $nearest['date']->toDateString(), 'cantidad_kardex' => $nearest['quantity']];
                }
                $counts[$status]++;
                DB::table('reconciliacion_movimientos')->where('id', $row->id)->update([
                    'estado_conciliacion' => $status,
                    'movimiento_kardex_id' => $matchedId,
                    'datos_adicionales' => json_encode($extra, JSON_UNESCAPED_UNICODE),
                    'observacion' => $observation,
                    'updated_at' => now(),
                ]);
            }
            DB::table('reconciliaciones')->where('id', $id)->update([
                'estado' => 'conciliada',
                'total_coincidencias' => $counts['coincidencia'],
                'total_diferencias' => $counts['diferencia'],
                'total_pendientes' => $counts['pendiente'],
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('reconciliacion.show', $id)->with('success', "Comparación #{$id} terminada: {$counts['coincidencia']} coincidencias, {$counts['diferencia']} diferencias y {$counts['pendiente']} pendientes. El stock no fue modificado.");
    }

    private function candidate(string $source, int $id, $date, string $direction, $quantity, string $label, ?string $reference): array
    {
        return [
            'key' => $source.':'.$id,
            'source' => $source,
            'id' => $id,
            'date' => $date ? Carbon::parse($date) : null,
            'direction' => $direction,
            'quantity' => (float) $quantity,
            'label' => $label,
            'reference' => $reference,
        ];
    }

    private function parseNumber($value): float
    {
        $value = trim((string) $value);
        if ($value === '') return 0;
        if (str_contains($value, ',') && str_contains($value, '.')) {
            if (strrpos($value, ',') > strrpos($value, '.')) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
            } else $value = str_replace(',', '', $value);
        } elseif (str_contains($value, ',') && !str_contains($value, '.')) $value = str_replace(',', '.', $value);
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
