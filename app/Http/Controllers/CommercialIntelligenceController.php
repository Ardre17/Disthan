<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommercialIntelligenceController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(in_array(auth()->user()->role ?? '', ['admin', 'gerencia'], true), 403);

        $validated = $request->validate([
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date', 'after_or_equal:desde'],
            'cliente' => ['nullable', 'string', 'max:160'],
            'sku' => ['nullable', 'string', 'max:80'],
            'prioridad' => ['nullable', 'in:ALTA,MEDIA,SEGUIMIENTO,ATENDIDO'],
        ]);

        $desde = $validated['desde'] ?? null;
        $hasta = $validated['hasta'] ?? null;

        // Base histórica: pedidos domésticos válidos, excluyendo exportaciones.
        $base = DB::table('orders as o')
            ->join('clients as c', 'c.id', '=', 'o.client_id')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->join('products as p', 'p.id', '=', 'od.product_id')
            ->whereIn(DB::raw("UPPER(COALESCE(o.estado, ''))"), ['COMPLETO', 'INCOMPLETO', 'PARCIAL'])
            ->whereRaw("UPPER(COALESCE(o.tipo_orden, '')) <> 'EXPORTACION'")
            ->whereRaw("COALESCE(c.razon_social, '') NOT ILIKE '%export%'")
            ->whereRaw("COALESCE(c.nombre_comercial, '') NOT ILIKE '%export%'")
            ->when($desde, fn ($q) => $q->whereDate('o.fecha_pedido', '>=', $desde))
            ->when($hasta, fn ($q) => $q->whereDate('o.fecha_pedido', '<=', $hasta));

        // Indicadores globales del período (todos los segmentos domésticos).
        $totales = (clone $base)->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('COALESCE(SUM(od.cantidad_solicitada), 0) AS solicitadas')
            ->selectRaw('COALESCE(SUM(od.cantidad_despachada), 0) AS despachadas')
            ->selectRaw('COALESCE(SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)), 0) AS faltantes')
            ->first();

        $solicitadas = (float) ($totales->solicitadas ?? 0);
        $despachadas = (float) ($totales->despachadas ?? 0);
        $faltantes = (float) ($totales->faltantes ?? 0);
        $atencion = $solicitadas > 0 ? ($despachadas / $solicitadas) * 100 : 0;

        // Resumen por tipo de cliente.
        $porTipo = (clone $base)->selectRaw("COALESCE(NULLIF(UPPER(c.tipo_cliente), ''), 'SIN CLASIFICAR') AS tipo")
            ->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('tipo')->orderByDesc('faltantes')->get();

        // Ranking de productos por faltante positivo de cada línea; no se compensan SKU.
        $topProductos = (clone $base)->select('p.sku', 'p.nombre')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('p.id', 'p.sku', 'p.nombre')->orderByDesc('faltantes')->limit(10)->get();

        // Matriz de prioridad: solo clientes clasificados como SUPERMERCADOS.
        $matrixQuery = (clone $base)->whereRaw("UPPER(COALESCE(c.tipo_cliente, '')) = 'SUPERMERCADOS'")
            ->select('c.id as client_id')
            ->selectRaw("COALESCE(NULLIF(c.nombre_comercial, ''), c.razon_social, 'Cliente sin nombre') AS cliente")
            ->addSelect('p.sku', 'p.nombre as producto')
            ->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('c.id', 'c.nombre_comercial', 'c.razon_social', 'p.id', 'p.sku', 'p.nombre');

        $matrix = $matrixQuery->get();

        // Escalas normalizadas dentro de cada cliente, según la matriz acordada.
        $maximos = $matrix->groupBy('client_id')->map(function ($rows) {
            return [
                'faltantes' => max(1, (float) $rows->max('faltantes')),
                'pedidos' => max(1, (float) $rows->max('pedidos')),
            ];
        });

        $matrix = $matrix->map(function ($row) use ($maximos) {
            $max = $maximos->get($row->client_id, ['faltantes' => 1, 'pedidos' => 1]);
            $sol = (float) $row->solicitadas;
            $des = (float) $row->despachadas;
            $fal = (float) $row->faltantes;
            $ped = (float) $row->pedidos;
            $row->atencion = $sol > 0 ? ($des / $sol) * 100 : 0;
            $row->valor_faltante = $fal > 0 ? ($fal / $max['faltantes']) * 100 : 0;
            $row->brecha_atencion = max(0, 100 - $row->atencion);
            $row->frecuencia = ($ped / $max['pedidos']) * 100;
            $row->indice = (0.40 * $row->valor_faltante) + (0.35 * $row->brecha_atencion) + (0.25 * $row->frecuencia);
            $row->prioridad = $fal <= 0 ? 'ATENDIDO' : ($row->indice >= 70 ? 'ALTA' : ($row->indice >= 45 ? 'MEDIA' : 'SEGUIMIENTO'));
            return $row;
        });

        $clientes = $matrix->map(fn ($r) => ['id' => $r->client_id, 'nombre' => $r->cliente])
            ->unique('id')->sortBy('nombre')->values();
        $matrix = $matrix
            ->when(!empty($validated['cliente']), fn ($rows) => $rows->filter(fn ($r) => (string) $r->client_id === (string) $validated['cliente']))
            ->when(!empty($validated['sku']), fn ($rows) => $rows->filter(fn ($r) => stripos((string) $r->sku, $validated['sku']) !== false || stripos((string) $r->producto, $validated['sku']) !== false))
            ->when(!empty($validated['prioridad']), fn ($rows) => $rows->where('prioridad', $validated['prioridad']))
            ->sortByDesc('indice')->values();

        $conteoPrioridad = $matrix->countBy('prioridad');
        $matrixTotales = [
            'filas' => $matrix->count(),
            'alta' => $conteoPrioridad->get('ALTA', 0),
            'media' => $conteoPrioridad->get('MEDIA', 0),
            'seguimiento' => $conteoPrioridad->get('SEGUIMIENTO', 0),
            'atendido' => $conteoPrioridad->get('ATENDIDO', 0),
        ];

        return view('commercial-intelligence.index', compact(
            'desde', 'hasta', 'validated', 'totales', 'solicitadas', 'despachadas', 'faltantes', 'atencion',
            'porTipo', 'topProductos', 'matrix', 'clientes', 'matrixTotales'
        ));
    }
}
