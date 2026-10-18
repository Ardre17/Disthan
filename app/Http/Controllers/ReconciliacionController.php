<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReconciliacionController extends Controller
{
    public function index()
    {
        $productos = Product::query()
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'sku']);

        return view('reconciliacion.index', compact('productos'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'archivo_csv' => ['required', 'file', 'mimes:csv,txt', 'max:20480'],
        ]);

        $path = $request->file('archivo_csv')->getRealPath();
        $handle = fopen($path, 'r');

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
            return back()->withErrors(['archivo_csv' => 'No se pudieron leer los encabezados del CSV.'])->withInput();
        }

        $normalize = static function ($value) {
            $value = preg_replace('/^\xEF\xBB\xBF/', '', (string) $value);
            $value = mb_strtolower(trim($value));
            $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
            return preg_replace('/[^a-z0-9]/', '', $value);
        };

        $normalizedHeaders = array_map($normalize, $headers);
        $aliases = [
            'razonsocial' => ['razonsocial', 'razonsocialcliente', 'cliente'],
            'emision' => ['emision', 'fecha', 'fechamovimiento'],
            'ingresos' => ['ingresos', 'entrada', 'entradas'],
            'salidas' => ['salidas', 'salida'],
            'ruc' => ['ruc', 'ccliente', 'documento', 'numerodocumento'],
        ];

        $indexes = [];
        foreach ($aliases as $field => $options) {
            foreach ($normalizedHeaders as $i => $header) {
                if (in_array($header, $options, true)) {
                    $indexes[$field] = $i;
                    break;
                }
            }
        }

        $required = ['razonsocial', 'emision', 'ingresos', 'salidas'];
        $missing = array_values(array_diff($required, array_keys($indexes)));
        if ($missing) {
            fclose($handle);
            return back()->withErrors([
                'archivo_csv' => 'Faltan columnas necesarias: ' . implode(', ', $missing) .
                    '. Usa Razón social, Emisión, Ingresos y Salidas; el RUC es opcional.',
            ])->withInput();
        }

        $rows = [];
        $line = 1;
        while (($record = fgetcsv($handle, 0, $delimiter)) !== false) {
            $line++;
            if (count(array_filter($record, fn($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }

            $rows[] = [
                'fila' => $line,
                'razon_social' => trim((string) ($record[$indexes['razonsocial']] ?? '')),
                'emision' => trim((string) ($record[$indexes['emision']] ?? '')),
                'ingresos' => $this->parseNumber($record[$indexes['ingresos']] ?? 0),
                'salidas' => $this->parseNumber($record[$indexes['salidas']] ?? 0),
                'ruc' => isset($indexes['ruc']) ? trim((string) ($record[$indexes['ruc']] ?? '')) : '',
            ];
        }
        fclose($handle);

        $producto = Product::findOrFail($request->product_id);

        return view('reconciliacion.index', [
            'productos' => Product::query()->orderBy('nombre')->get(['id', 'nombre', 'sku']),
            'productoSeleccionado' => $producto->id,
            'previewRows' => $rows,
            'archivoNombre' => $request->file('archivo_csv')->getClientOriginalName(),
            'previewCount' => count($rows),
        ]);
    }

    private function parseNumber($value): float
    {
        $value = trim((string) $value);
        if ($value === '') {
            return 0;
        }

        // Soporta formatos como 1,250.000 y 1.250,000.
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
}
