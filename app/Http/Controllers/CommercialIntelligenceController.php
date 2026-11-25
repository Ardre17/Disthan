<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommercialIntelligenceController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(in_array(auth()->user()->role ?? '', ['admin', 'gerencia'], true), 403);

        $validated = $request->validate([
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date', 'after_or_equal:desde'],
            'tipo_cliente' => ['nullable', 'in:MAYORISTA,MINORISTA,SUPERMERCADOS'],
            'cliente' => ['nullable', 'integer'],
            'producto' => ['nullable', 'string', 'max:160'],
            'prioridad' => ['nullable', 'in:ALTA,MEDIA,SEGUIMIENTO,ATENDIDO'],
            'vista' => ['nullable', 'in:matriz,clientes,detalle'],
            'cliente_detalle' => ['nullable', 'integer'],
        ]);

        $desde = $validated['desde'] ?? null;
        $hasta = $validated['hasta'] ?? null;
        $tipoCliente = $validated['tipo_cliente'] ?? '';
        $vista = $validated['vista'] ?? 'matriz';

        // Base histórica doméstica. Se excluyen exportaciones y estados fuera del alcance acordado.
        $base = DB::table('orders as o')
            ->join('clients as c', 'c.id', '=', 'o.client_id')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->join('products as p', 'p.id', '=', 'od.product_id')
            ->whereIn(DB::raw("UPPER(COALESCE(o.estado, ''))"), ['COMPLETO', 'INCOMPLETO', 'PARCIAL'])
            ->whereRaw("UPPER(COALESCE(o.tipo_orden, '')) <> 'EXPORTACION'")
            ->whereRaw("COALESCE(c.razon_social, '') NOT ILIKE '%export%'")
            ->whereRaw("COALESCE(c.nombre_comercial, '') NOT ILIKE '%export%'")
            ->when($desde, fn ($q) => $q->whereDate('o.fecha_pedido', '>=', $desde))
            ->when($hasta, fn ($q) => $q->whereDate('o.fecha_pedido', '<=', $hasta))
            ->when($tipoCliente, fn ($q) => $q->whereRaw('UPPER(COALESCE(c.tipo_cliente, \'\')) = ?', [$tipoCliente]));

        $totales = (clone $base)->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('COALESCE(SUM(od.cantidad_solicitada), 0) AS solicitadas')
            ->selectRaw('COALESCE(SUM(od.cantidad_despachada), 0) AS despachadas')
            ->selectRaw('COALESCE(SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)), 0) AS faltantes')
            ->first();

        $solicitadas = (float) ($totales->solicitadas ?? 0);
        $despachadas = (float) ($totales->despachadas ?? 0);
        $faltantes = (float) ($totales->faltantes ?? 0);
        $atencion = $solicitadas > 0 ? ($despachadas / $solicitadas) * 100 : 0;

        $porTipo = (clone $base)->selectRaw("COALESCE(NULLIF(UPPER(c.tipo_cliente), ''), 'SIN CLASIFICAR') AS tipo")
            ->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('tipo')->orderByDesc('faltantes')->get();

        $topProductos = (clone $base)->select('p.sku', 'p.nombre')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('p.id', 'p.sku', 'p.nombre')->orderByDesc('faltantes')->limit(10)->get();

        // Opciones para los filtros, respetando período y tipo de cliente.
        $clientes = (clone $base)->select('c.id')
            ->selectRaw("COALESCE(NULLIF(c.nombre_comercial, ''), c.razon_social, 'Cliente sin nombre') AS nombre")
            ->groupBy('c.id', 'c.nombre_comercial', 'c.razon_social')->orderBy('nombre')->get();

        $productosFiltro = (clone $base)->select('p.sku', 'p.nombre')
            ->groupBy('p.id', 'p.sku', 'p.nombre')->orderBy('p.nombre')->get();

        // Matriz de prioridad para el tipo seleccionado (o todos los tipos si no se eligió uno).
        $matrix = (clone $base)->select('c.id as client_id')
            ->selectRaw("COALESCE(NULLIF(c.nombre_comercial, ''), c.razon_social, 'Cliente sin nombre') AS cliente")
            ->addSelect('p.sku', 'p.nombre as producto')
            ->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('c.id', 'c.nombre_comercial', 'c.razon_social', 'p.id', 'p.sku', 'p.nombre')->get();

        $maximos = $matrix->groupBy('client_id')->map(fn ($rows) => [
            'faltantes' => max(1, (float) $rows->max('faltantes')),
            'pedidos' => max(1, (float) $rows->max('pedidos')),
        ]);

        $matrix = $matrix->map(function ($row) use ($maximos) {
            $max = $maximos->get($row->client_id, ['faltantes' => 1, 'pedidos' => 1]);
            $sol = (float) $row->solicitadas;
            $des = (float) $row->despachadas;
            $fal = (float) $row->faltantes;
            $row->atencion = $sol > 0 ? ($des / $sol) * 100 : 0;
            $row->valor_faltante = $fal > 0 ? ($fal / $max['faltantes']) * 100 : 0;
            $row->brecha_atencion = max(0, 100 - $row->atencion);
            $row->frecuencia = ((float) $row->pedidos / $max['pedidos']) * 100;
            $row->indice = (0.40 * $row->valor_faltante) + (0.35 * $row->brecha_atencion) + (0.25 * $row->frecuencia);
            $row->prioridad = $fal <= 0 ? 'ATENDIDO' : ($row->indice >= 70 ? 'ALTA' : ($row->indice >= 45 ? 'MEDIA' : 'SEGUIMIENTO'));
            return $row;
        });

        $matrix = $matrix
            ->when(!empty($validated['cliente']), fn ($rows) => $rows->where('client_id', (int) $validated['cliente']))
            ->when(!empty($validated['producto']), function ($rows) use ($validated) {
                $term = mb_strtolower(trim($validated['producto']));
                return $rows->filter(fn ($r) => str_contains(mb_strtolower((string) $r->producto), $term)
                    || str_contains(mb_strtolower((string) $r->sku), $term));
            })
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

        // Pestaña de análisis: resumen de todos los clientes del segmento seleccionado.
        $resumenClientes = (clone $base)->select('c.id as client_id')
            ->selectRaw("COALESCE(NULLIF(c.nombre_comercial, ''), c.razon_social, 'Cliente sin nombre') AS cliente")
            ->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
            ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
            ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
            ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
            ->groupBy('c.id', 'c.nombre_comercial', 'c.razon_social')->orderBy('cliente')->get()
            ->map(function ($r) {
                $r->atencion = (float) $r->solicitadas > 0 ? ((float) $r->despachadas / (float) $r->solicitadas) * 100 : 0;
                return $r;
            });

        $clienteDetalle = null;
        $productosCliente = collect();
        if ($vista === 'detalle' && !empty($validated['cliente_detalle'])) {
            $clienteDetalle = $clientes->firstWhere('id', (int) $validated['cliente_detalle']);
            if ($clienteDetalle) {
                $productosCliente = (clone $base)->where('c.id', (int) $validated['cliente_detalle'])
                    ->select('p.sku', 'p.nombre as producto')
                    ->selectRaw('COUNT(DISTINCT o.id) AS pedidos')
                    ->selectRaw('SUM(od.cantidad_solicitada) AS solicitadas')
                    ->selectRaw('SUM(od.cantidad_despachada) AS despachadas')
                    ->selectRaw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) AS faltantes')
                    ->groupBy('p.id', 'p.sku', 'p.nombre')->orderByDesc('solicitadas')->orderBy('p.nombre')->get()
                    ->map(function ($r) {
                        $r->atencion = (float) $r->solicitadas > 0 ? ((float) $r->despachadas / (float) $r->solicitadas) * 100 : 0;
                        return $r;
                    });
            }
        }

        return view('commercial-intelligence.index', compact(
            'desde', 'hasta', 'validated', 'tipoCliente', 'vista', 'totales', 'solicitadas', 'despachadas', 'faltantes', 'atencion',
            'porTipo', 'topProductos', 'matrix', 'clientes', 'productosFiltro', 'matrixTotales',
            'resumenClientes', 'clienteDetalle', 'productosCliente'
        ));
    }
}
