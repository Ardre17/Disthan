<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;
use App\Models\Product;
use App\Models\Client;
use App\Models\ProductEntry;

class KardexController extends Controller
{
    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        $clientId  = $request->input('client_id');
        $dateFrom  = $request->input('date_from');
        $dateTo    = $request->input('date_to');

        $perPage = 20;

        /*
        |--------------------------------------------------------------------------
        | MOVIMIENTOS
        |--------------------------------------------------------------------------
        |
        | PRODUCCIÓN = ProductEntry
        | SALIDA     = OrderDetail.cantidad_despachada
        |
        */

        $movimientos = collect();

        /*
        |--------------------------------------------------------------------------
        | 1. ENTRADAS / PRODUCCIÓN
        |--------------------------------------------------------------------------
        */

        $entradasQuery = ProductEntry::with([
            'product',
            'user'
        ])->orderBy('created_at', 'asc');

        if ($productId) {
            $entradasQuery->where('product_id', $productId);
        }

        if ($dateFrom) {
            $entradasQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $entradasQuery->whereDate('created_at', '<=', $dateTo);
        }

        $entradas = $entradasQuery->get();

        foreach ($entradas as $entrada) {

            $movimientos->push([
                'fecha'               => $entrada->created_at,
                'tipo'                => 'PRODUCCIÓN',

                'numero_orden'        => null,
                'cliente'             => 'Producción',
                'client_id'           => null,

                'producto'            => optional($entrada->product)->nombre
                    ?? 'Sin producto',

                'product_id'          => $entrada->product_id,

                'cantidad_solicitada' => 0,
                'cantidad_produccion' => $entrada->quantity,
                'cantidad_despachada' => 0,

                'precio_unitario'     => 0,
                'subtotal'            => 0,

                'estado_orden'        => null,

                'stock_before'        => $entrada->stock_before,
                'stock_after'         => $entrada->stock_after,

                'usuario'             => optional($entrada->user)->name
                    ?? 'Sistema',

                'origen_id'           => $entrada->id,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 2. SALIDAS / DESPACHOS
        |--------------------------------------------------------------------------
        */

        $ordersQuery = Order::with([
            'client',
            'details.product'
        ])
        ->whereIn('estado', [
            'COMPLETO',
            'PARCIAL',
            'INCOMPLETO'
        ])
        ->orderBy('fecha_pedido', 'asc');

        if ($clientId) {
            $ordersQuery->where('client_id', $clientId);
        }

        if ($dateFrom) {
            $ordersQuery->whereDate(
                'fecha_pedido',
                '>=',
                $dateFrom
            );
        }

        if ($dateTo) {
            $ordersQuery->whereDate(
                'fecha_pedido',
                '<=',
                $dateTo
            );
        }

        if ($productId) {
            $ordersQuery->whereHas(
                'details',
                fn($q) => $q->where(
                    'product_id',
                    $productId
                )
            );
        }

        $orders = $ordersQuery->get();

        foreach ($orders as $order) {

            foreach ($order->details as $detail) {

                if (
                    $productId &&
                    $detail->product_id != $productId
                ) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Solo registrar una salida cuando realmente hubo despacho
                |--------------------------------------------------------------------------
                */

                $cantidadDespachada =
                    (float) $detail->cantidad_despachada;

                if ($cantidadDespachada <= 0) {
                    continue;
                }

                $movimientos->push([
                    'fecha'               => $order->fecha_pedido,
                    'tipo'                => 'SALIDA',

                    'numero_orden'        => $order->numero_orden,

                    'cliente'            => optional($order->client)
                        ->razon_social
                        ?? 'Sin cliente',

                    'client_id'           => $order->client_id,

                    'producto'            => optional($detail->product)
                        ->nombre
                        ?? 'Sin producto',

                    'product_id'          => $detail->product_id,

                    'cantidad_solicitada' => $detail->cantidad_solicitada,

                    'cantidad_produccion' => 0,

                    'cantidad_despachada' => $cantidadDespachada,

                    'precio_unitario'     => $detail->precio_unitario,

                    'subtotal'            => $detail->subtotal,

                    'estado_orden'        => $order->estado,

                    'stock_before'        => null,
                    'stock_after'         => null,

                    'usuario'             => null,

                    'origen_id'           => $detail->id,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 3. ORDENAR TODOS LOS MOVIMIENTOS
        |--------------------------------------------------------------------------
        */

        $movimientos = $movimientos
            ->sortBy(function ($mov) {

                return [
                    \Carbon\Carbon::parse($mov['fecha'])->timestamp,

                    /*
                    Producción antes que salida si ocurren
                    exactamente en el mismo momento.
                    */
                    $mov['tipo'] === 'PRODUCCIÓN' ? 0 : 1,
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | 4. CALCULAR SALDO ACUMULADO
        |--------------------------------------------------------------------------
        */

        $saldos = [];

        foreach ($movimientos as $index => $mov) {

            $productIdMovimiento = $mov['product_id'];

            if (!isset($saldos[$productIdMovimiento])) {
                $saldos[$productIdMovimiento] = 0;
            }

            /*
            Producción = entrada
            */

            $saldos[$productIdMovimiento] +=
                (float) $mov['cantidad_produccion'];

            /*
            Salida = resta
            */

            $saldos[$productIdMovimiento] -=
                (float) $mov['cantidad_despachada'];

            /*
            No permitir saldo negativo visual.
            */

            $saldos[$productIdMovimiento] =
                max(0, $saldos[$productIdMovimiento]);

            $movimientos[$index]['saldo'] =
                $saldos[$productIdMovimiento];
        }


        /*
        |--------------------------------------------------------------------------
        | 5. KPIs
        |--------------------------------------------------------------------------
        */

        $totalProduccion = $movimientos
            ->sum('cantidad_produccion');

        $totalSalidas = $movimientos
            ->sum('cantidad_despachada');

        $totalMovimientos =
            $movimientos->count();

        $clientesActivos = $movimientos
            ->where('tipo', 'SALIDA')
            ->pluck('client_id')
            ->filter()
            ->unique()
            ->count();

        $productosMovidos = $movimientos
            ->pluck('product_id')
            ->unique()
            ->count();

        $totalFacturado = $movimientos
            ->where('tipo', 'SALIDA')
            ->sum('subtotal');


        /*
        |--------------------------------------------------------------------------
        | 6. GRÁFICO
        |--------------------------------------------------------------------------
        */

        $chartData = null;

        if ($productId || $clientId) {

            $porMes = $movimientos
                ->groupBy(
                    fn($m) =>
                        \Carbon\Carbon::parse(
                            $m['fecha']
                        )->format('Y-m')
                )
                ->sortKeys()
                ->take(-12)
                ->map(function ($grupo) {

                    return [
                        'produccion' =>
                            $grupo->sum(
                                'cantidad_produccion'
                            ),

                        'salidas' =>
                            $grupo->sum(
                                'cantidad_despachada'
                            ),

                        'subtotal' =>
                            $grupo->sum('subtotal'),

                        'ordenes' =>
                            $grupo
                                ->where(
                                    'tipo',
                                    'SALIDA'
                                )
                                ->pluck(
                                    'numero_orden'
                                )
                                ->unique()
                                ->count(),
                    ];
                });

            $chartData = [

                'labels' =>
                    $porMes->keys()
                        ->map(
                            fn($k) =>
                                \Carbon\Carbon::parse(
                                    $k . '-01'
                                )->translatedFormat(
                                    'M Y'
                                )
                        )
                        ->values(),

                'produccion' =>
                    $porMes
                        ->pluck('produccion')
                        ->values(),

                'salidas' =>
                    $porMes
                        ->pluck('salidas')
                        ->values(),

                'subtotal' =>
                    $porMes
                        ->pluck('subtotal')
                        ->values(),

                'ordenes' =>
                    $porMes
                        ->pluck('ordenes')
                        ->values(),

                'producto' =>
                    $productId
                        ? optional(
                            Product::find($productId)
                        )->nombre
                        : null,

                'cliente' =>
                    $clientId
                        ? optional(
                            Client::find($clientId)
                        )->razon_social
                        : null,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 7. PAGINACIÓN
        |--------------------------------------------------------------------------
        */

        $currentPage =
            LengthAwarePaginator::resolveCurrentPage();

        $paginados = $movimientos
            ->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            )
            ->values();

        $movimientosPaginados =
            new LengthAwarePaginator(
                $paginados,
                $movimientos->count(),
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'query' => $request->query()
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | 8. STOCK ACTUAL
        |--------------------------------------------------------------------------
        */

        $productosQuery =
            Product::where(
                'activo',
                true
            )
            ->orderBy('nombre');

        if ($productId) {
            $productosQuery->where(
                'id',
                $productId
            );
        }

        $stockProductos =
            $productosQuery->get();


        /*
        |--------------------------------------------------------------------------
        | 9. LISTAS DE FILTROS
        |--------------------------------------------------------------------------
        */

        $productos =
            Product::where(
                'activo',
                true
            )
            ->orderBy('nombre')
            ->get();

        $clientes =
            Client::orderBy(
                'razon_social'
            )->get();


        /*
        |--------------------------------------------------------------------------
        | 10. VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'kardex.index',
            compact(
                'movimientosPaginados',
                'stockProductos',

                'totalProduccion',
                'totalSalidas',

                'totalMovimientos',
                'clientesActivos',
                'productosMovidos',
                'totalFacturado',

                'productos',
                'clientes',

                'productId',
                'clientId',
                'dateFrom',
                'dateTo',

                'chartData'
            )
        );
    }
}