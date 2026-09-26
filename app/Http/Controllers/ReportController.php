<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function movimientos(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTROS
        |--------------------------------------------------------------------------
        */

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin    = $request->input('fecha_fin');
        $tipo        = $request->input('tipo');
        $busqueda    = trim($request->input('busqueda', ''));

        /*
        |--------------------------------------------------------------------------
        | MOVIMIENTOS
        |--------------------------------------------------------------------------
        */

        $movimientos = collect();

        /*
        |--------------------------------------------------------------------------
        | 1. INGRESOS DE MATERIA PRIMA
        |--------------------------------------------------------------------------
        */

        if (!$tipo || $tipo === 'MATERIA_PRIMA') {

            $query = DB::table('raw_material_entries')
                ->leftJoin(
                    'raw_materials',
                    'raw_material_entries.raw_material_id',
                    '=',
                    'raw_materials.id'
                )
                ->leftJoin(
                    'users',
                    'raw_material_entries.user_id',
                    '=',
                    'users.id'
                )
                ->select(
                    'raw_material_entries.id',
                    'raw_material_entries.created_at',
                    'raw_material_entries.quantity',
                    'raw_material_entries.supplier',
                    'raw_material_entries.observation',
                    'raw_materials.name as material_nombre',
                    'raw_materials.code as material_codigo',
                    'users.name as usuario'
                );

            if ($fechaInicio) {
                $query->whereDate(
                    'raw_material_entries.created_at',
                    '>=',
                    $fechaInicio
                );
            }

            if ($fechaFin) {
                $query->whereDate(
                    'raw_material_entries.created_at',
                    '<=',
                    $fechaFin
                );
            }

            if ($busqueda !== '') {
                $query->where(function ($q) use ($busqueda) {

                    $q->where(
                        'raw_materials.name',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'raw_materials.code',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'raw_material_entries.supplier',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'raw_material_entries.observation',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    );
                });
            }

            $entradas = $query
                ->orderByDesc('raw_material_entries.created_at')
                ->get();

            foreach ($entradas as $entrada) {

                $movimientos->push([
                    'tipo' => 'MATERIA_PRIMA',

                    'fecha' => $entrada->created_at,

                    'titulo' => 'Ingreso de materia prima',

                    'referencia' =>
                        $entrada->material_codigo
                        ?? '—',

                    'descripcion' =>
                        $entrada->material_nombre
                        ?? 'Materia prima',

                    'cantidad' =>
                        (float) $entrada->quantity,

                    'unidad' => '—',

                    'usuario' =>
                        $entrada->usuario
                        ?? '—',

                    'tercero' =>
                        $entrada->supplier
                        ?? '—',

                    'observacion' =>
                        $entrada->observation
                        ?? '—',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. PRODUCCIÓN TERMINADA
        |--------------------------------------------------------------------------
        */

        if (!$tipo || $tipo === 'PRODUCCION') {

            $query = DB::table('production_orders')
                ->leftJoin(
                    'products',
                    'production_orders.product_id',
                    '=',
                    'products.id'
                )
                ->leftJoin(
                    'raw_materials',
                    'production_orders.raw_material_id',
                    '=',
                    'raw_materials.id'
                )
                ->leftJoin(
                    'users',
                    'production_orders.user_id',
                    '=',
                    'users.id'
                )
                ->select(
                    'production_orders.id',
                    'production_orders.number',
                    'production_orders.produced_quantity',
                    'production_orders.consumed_quantity',
                    'production_orders.observation',
                    'production_orders.fecha_produccion',
                    'products.nombre as producto_nombre',
                    'raw_materials.name as material_nombre',
                    'users.name as usuario'
                )
                ->where(
                    'production_orders.status',
                    'FINALIZADA'
                )
                ->whereNotNull(
                    'production_orders.fecha_produccion'
                );

            if ($fechaInicio) {
                $query->whereDate(
                    'production_orders.fecha_produccion',
                    '>=',
                    $fechaInicio
                );
            }

            if ($fechaFin) {
                $query->whereDate(
                    'production_orders.fecha_produccion',
                    '<=',
                    $fechaFin
                );
            }

            if ($busqueda !== '') {
                $query->where(function ($q) use ($busqueda) {

                    $q->where(
                        'production_orders.number',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'products.nombre',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'raw_materials.name',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'production_orders.observation',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    );
                });
            }

            $producciones = $query
                ->orderByDesc(
                    'production_orders.fecha_produccion'
                )
                ->get();

            foreach ($producciones as $produccion) {

                $movimientos->push([
                    'tipo' => 'PRODUCCION',

                    'fecha' =>
                        $produccion->fecha_produccion,

                    'titulo' =>
                        'Producción terminada',

                    'referencia' =>
                        $produccion->number,

                    'descripcion' =>
                        $produccion->producto_nombre
                        ?? 'Producto terminado',

                    'cantidad' =>
                        (float) $produccion->produced_quantity,

                    'unidad' => '—',

                    'usuario' =>
                        $produccion->usuario
                        ?? '—',

                    'tercero' =>
                        $produccion->material_nombre
                        ?? '—',

                    'observacion' =>
                        $produccion->observation
                        ?? '—',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. PEDIDOS CERRADOS
        |--------------------------------------------------------------------------
        */

        if (!$tipo || $tipo === 'PEDIDO') {

            $query = DB::table('orders')
                ->leftJoin(
                    'clients',
                    'orders.client_id',
                    '=',
                    'clients.id'
                )
                ->select(
                    'orders.id',
                    'orders.numero_orden',
                    'orders.tipo_orden',
                    'orders.fecha_cierre',
                    'orders.total',
                    'orders.observaciones',
                    'clients.razon_social as cliente_nombre'
                )
                ->where(
                    'orders.estado',
                    'COMPLETO'
                )
                ->whereNotNull(
                    'orders.fecha_cierre'
                );

            if ($fechaInicio) {
                $query->whereDate(
                    'orders.fecha_cierre',
                    '>=',
                    $fechaInicio
                );
            }

            if ($fechaFin) {
                $query->whereDate(
                    'orders.fecha_cierre',
                    '<=',
                    $fechaFin
                );
            }

            if ($busqueda !== '') {
                $query->where(function ($q) use ($busqueda) {

                    $q->where(
                        'orders.numero_orden',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'clients.razon_social',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    )
                    ->orWhere(
                        'orders.tipo_orden',
                        'ILIKE',
                        '%' . $busqueda . '%'
                    );
                });
            }

            $pedidos = $query
                ->orderByDesc('orders.fecha_cierre')
                ->get();

            foreach ($pedidos as $pedido) {

                $movimientos->push([
                    'tipo' => 'PEDIDO',

                    'fecha' =>
                        $pedido->fecha_cierre,

                    'titulo' =>
                        'Pedido cerrado',

                    'referencia' =>
                        $pedido->numero_orden,

                    'descripcion' =>
                        $pedido->cliente_nombre
                        ?? 'Cliente no registrado',

                    'cantidad' => null,

                    'unidad' => null,

                    'usuario' => '—',

                    'tercero' =>
                        $pedido->tipo_orden
                        ?? '—',

                    'observacion' =>
                        $pedido->observaciones
                        ?? '—',

                    'total' =>
                        (float) ($pedido->total ?? 0),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ORDENAR TODOS LOS MOVIMIENTOS
        |--------------------------------------------------------------------------
        */

        $movimientos = $movimientos
            ->sortByDesc(function ($movimiento) {
                return $movimiento['fecha'];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | KPIs
        |--------------------------------------------------------------------------
        */

        $totalMovimientos = $movimientos->count();

        $totalMateriaPrima = $movimientos
            ->where('tipo', 'MATERIA_PRIMA')
            ->sum('cantidad');

        $totalProduccion = $movimientos
            ->where('tipo', 'PRODUCCION')
            ->sum('cantidad');

        $pedidosCerrados = $movimientos
            ->where('tipo', 'PEDIDO')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PAGINACIÓN
        |--------------------------------------------------------------------------
        */

        $porPagina = 20;

        $paginaActual = LengthAwarePaginator::resolveCurrentPage();

        $items = $movimientos
            ->slice(
                ($paginaActual - 1) * $porPagina,
                $porPagina
            )
            ->values();

        $movimientosPaginados = new LengthAwarePaginator(
            $items,
            $movimientos->count(),
            $porPagina,
            $paginaActual,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.movimientos',
            compact(
                'movimientosPaginados',
                'totalMovimientos',
                'totalMateriaPrima',
                'totalProduccion',
                'pedidosCerrados',
                'fechaInicio',
                'fechaFin',
                'tipo',
                'busqueda'
            )
        );
    }
}