<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;
use App\Models\Product;
use App\Models\Client;
use App\Models\ProductEntry;
use App\Models\ProductionOrder;
use App\Models\Movement;
use App\Models\Desmedro;

class KardexController extends Controller
{
    public function index(Request $request)
    {
        $productId = $request->input('product_id');
$clientId  = $request->input('client_id');
$dateFrom  = $request->input('date_from');
$dateTo    = $request->input('date_to');

$perPage = 20;

$movimientos = collect();

        /*
        |--------------------------------------------------------------------------
        | 1. INGRESOS DIRECTOS A TIENDA
        | ProductEntry ya actualiza el stock al registrar la entrada.
        | Aquí solo lo mostramos en el historial; no volvemos a modificar stock.
        |--------------------------------------------------------------------------
        */
        $entradasQuery = ProductEntry::with(['product', 'user'])
            ->orderBy('created_at', 'asc');

        if ($productId) $entradasQuery->where('product_id', $productId);
        if ($dateFrom) $entradasQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $entradasQuery->whereDate('created_at', '<=', $dateTo);

        foreach ($entradasQuery->get() as $entrada) {
            $movimientos->push([
                'fecha' => $entrada->created_at,
                'tipo' => 'ENTRADA',
                'numero_orden' => 'ING-' . $entrada->id,
                'cliente' => $entrada->supplier ?: 'Ingreso directo a tienda',
                'client_id' => null,
                'producto' => optional($entrada->product)->nombre ?? 'Sin producto',
                'product_id' => $entrada->product_id,
                'cantidad_solicitada' => 0,
                'cantidad_produccion' => 0,
                'cantidad_entrada' => (float) $entrada->quantity,
                'cantidad_despachada' => 0,
                'precio_unitario' => 0,
                'subtotal' => 0,
                'estado_orden' => 'INGRESO DIRECTO',
                'stock_before' => $entrada->stock_before,
                'stock_after' => $entrada->stock_after,
                'usuario' => optional($entrada->user)->name ?? 'Sistema',
                'origen_id' => $entrada->id,
            ]);
        }

        /*
|--------------------------------------------------------------------------
| 2. PRODUCCIÓN
|--------------------------------------------------------------------------
| La producción se registra al finalizar una ProductionOrder.
| Al finalizar:
| - se aumenta el stock del producto
| - la orden pasa a FINALIZADA
|--------------------------------------------------------------------------
*/

$produccionesQuery = ProductionOrder::with([
    'product',
    'user'
])
->where('status', 'FINALIZADA')
->orderBy('created_at', 'asc');

if ($productId) {
    $produccionesQuery->where('product_id', $productId);
}

if ($dateFrom) {
    $produccionesQuery->whereDate('created_at', '>=', $dateFrom);
}

if ($dateTo) {
    $produccionesQuery->whereDate('created_at', '<=', $dateTo);
}

$producciones = $produccionesQuery->get();

foreach ($producciones as $produccion) {

    $movimientos->push([
        'fecha'               => $produccion->created_at,
        'tipo'                => 'PRODUCCIÓN',

        'numero_orden'        => $produccion->number,

        'cliente'             => 'Producción',
        'client_id'           => null,

        'producto'            => optional($produccion->product)->nombre
            ?? 'Sin producto',

        'product_id'          => $produccion->product_id,

        'cantidad_solicitada' => 0,

        'cantidad_produccion' => (float) $produccion->produced_quantity,

        'cantidad_despachada' => 0,

        'precio_unitario'     => 0,

        'subtotal'            => 0,

        'estado_orden'        => $produccion->status,

        'stock_before'        => null,
        'stock_after'         => null,

        'usuario'             => optional($produccion->user)->name
            ?? 'Sistema',

        'origen_id'           => $produccion->id,
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

                $cantidadSolicitada = (float) $detail->cantidad_solicitada;

                // Se conserva el detalle aunque todavía no tenga despacho,
                // para que el pedido pendiente no desaparezca del análisis.
                $movimientos->push([
                    'fecha'               => $order->fecha_pedido,
                    'tipo'                => $cantidadDespachada > 0 ? 'SALIDA' : 'PEDIDO PENDIENTE',

                    'numero_orden'        => $order->numero_orden,

                    'cliente'            => optional($order->client)
                        ->razon_social
                        ?? 'Sin cliente',

                    'client_id'           => $order->client_id,

                    'producto'            => optional($detail->product)
                        ->nombre
                        ?? 'Sin producto',

                    'product_id'          => $detail->product_id,

                    'cantidad_solicitada' => $cantidadSolicitada,

                    'cantidad_produccion' => 0,
                    'cantidad_entrada' => 0,

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
        | 3. SALIDAS DE PRODUCCIÓN / MOVEMENTS
        |--------------------------------------------------------------------------
        | Aquí entran las salidas registradas desde:
        | Producción → Productos
        |
        | Estas salidas descuentan directamente Product->stock
        | y quedan registradas en la tabla movements.
        |--------------------------------------------------------------------------
        */

        $movimientosProduccion = Movement::with('product')
            ->where('tipo', 'SALIDA')
            ->whereNotNull('product_id')
            ->orderBy('created_at', 'asc');

        if ($productId) {
            $movimientosProduccion->where(
                'product_id',
                $productId
            );
        }

        if ($dateFrom) {
            $movimientosProduccion->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }

        if ($dateTo) {
            $movimientosProduccion->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }

        $salidasProduccion =
            $movimientosProduccion->get();

        foreach ($salidasProduccion as $movimiento) {

            $movimientos->push([

                'fecha' =>
                    $movimiento->created_at,

                'tipo' =>
                    'SALIDA',

                'numero_orden' =>
                    'PROD-' . $movimiento->id,

                'cliente' =>
                    'Producción',

                'client_id' =>
                    null,

                'producto' =>
                    optional($movimiento->product)->nombre
                    ?? 'Sin producto',

                'product_id' =>
                    $movimiento->product_id,

                'cantidad_solicitada' =>
                    0,

                'cantidad_produccion' =>
                    0,

                'cantidad_entrada' => 0,

                'cantidad_despachada' =>
                    (float) $movimiento->cantidad,

                'precio_unitario' =>
                    0,

                'subtotal' =>
                    0,

                'estado_orden' =>
                    'PRODUCCIÓN',

                'stock_before' =>
                    null,

                'stock_after' =>
                    null,

                'usuario' =>
                    $movimiento->motivo
                    ?? 'Producción',

                'origen_id' =>
                    $movimiento->id,

            ]);
        }
        /*
        |--------------------------------------------------------------------------
        | 4. DESMEDROS REGISTRADOS
        |--------------------------------------------------------------------------
        | El stock ya se descuenta al registrar el desmedro.
        | Aquí solo lo incorporamos al historial, sin modificar stock.
        */
        $desmedrosQuery = Desmedro::with(['detalles.producto', 'usuario'])
            ->where('estado', 'registrado')
            ->orderBy('registrado_at', 'asc');

        if ($dateFrom) {
            $desmedrosQuery->whereDate('registrado_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $desmedrosQuery->whereDate('registrado_at', '<=', $dateTo);
        }
        if ($productId) {
            $desmedrosQuery->whereHas('detalles', function ($q) use ($productId) {
                $q->where('producto_id', $productId);
            });
        }

        foreach ($desmedrosQuery->get() as $desmedro) {
            foreach ($desmedro->detalles as $detalle) {
                if ($productId && (int) $detalle->producto_id !== (int) $productId) {
                    continue;
                }

                $movimientos->push([
                    'fecha' => $desmedro->registrado_at ?? $desmedro->updated_at,
                    'tipo' => 'DESMEDRO',
                    'numero_orden' => $desmedro->codigo,
                    'cliente' => 'Desmedro' . ($desmedro->motivo ? ' · ' . $desmedro->motivo : ''),
                    'client_id' => null,
                    'producto' => optional($detalle->producto)->nombre ?? 'Sin producto',
                    'product_id' => $detalle->producto_id,
                    'cantidad_solicitada' => 0,
                    'cantidad_produccion' => 0,
                    'cantidad_entrada' => 0,
                    'cantidad_desmedro' => (float) $detalle->cantidad,
                    'cantidad_despachada' => 0,
                    'precio_unitario' => 0,
                    'subtotal' => 0,
                    'estado_orden' => 'REGISTRADO',
                    'stock_before' => $detalle->stock_antes,
                    'stock_after' => null,
                    'usuario' => optional($desmedro->usuario)->name ?? 'Sistema',
                    'origen_id' => $detalle->id,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. ORDENAR TODOS LOS MOVIMIENTOS
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

    $saldos[$productIdMovimiento] +=
        (float) ($mov['cantidad_entrada'] ?? 0);

    $saldos[$productIdMovimiento] +=
        (float) $mov['cantidad_produccion'];

    $saldos[$productIdMovimiento] -=
        (float) $mov['cantidad_despachada'];

    $saldos[$productIdMovimiento] -=
        (float) ($mov['cantidad_desmedro'] ?? 0);

    // Collection::put() permite modificar correctamente el elemento
    $mov['saldo'] = $saldos[$productIdMovimiento];

    $movimientos->put($index, $mov);
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
        $totalSolicitado = $movimientos->sum('cantidad_solicitada');
        $totalPendiente = $movimientos->sum(function ($mov) {
            return max(0, (float) $mov['cantidad_solicitada'] - (float) $mov['cantidad_despachada']);
        });
        $valorPendiente = $movimientos->sum(function ($mov) {
            $pendiente = max(0, (float) $mov['cantidad_solicitada'] - (float) $mov['cantidad_despachada']);
            return $pendiente * (float) $mov['precio_unitario'];
        });
        $cumplimiento = $totalSolicitado > 0
            ? round((($totalSolicitado - $totalPendiente) / $totalSolicitado) * 100, 1)
            : null;


        /*
        |--------------------------------------------------------------------------
        | 6. GRÁFICO
        |--------------------------------------------------------------------------
        */

        $chartData = null;

        // El gráfico diario se activa al filtrar por producto o cliente.
        if ($productId || $clientId) {
            $porDia = $movimientos
                ->groupBy(fn($m) => \Carbon\Carbon::parse($m['fecha'])->format('Y-m-d'))
                ->sortKeys()
                ->map(function ($grupo) {
                    $solicitado = $grupo->sum('cantidad_solicitada');
                    $despachado = $grupo->sum('cantidad_despachada');
                    $pendiente = $grupo->sum(function ($m) {
                        return max(0, (float) $m['cantidad_solicitada'] - (float) $m['cantidad_despachada']);
                    });
                    $valorPendienteDia = $grupo->sum(function ($m) {
                        return max(0, (float) $m['cantidad_solicitada'] - (float) $m['cantidad_despachada']) * (float) $m['precio_unitario'];
                    });
                    return [
                        'solicitado' => $solicitado,
                        'produccion' => $grupo->sum('cantidad_produccion'),
                        'entrada_directa' => $grupo->sum('cantidad_entrada'),
                        'desmedro' => $grupo->sum('cantidad_desmedro'),
                        'salidas' => $despachado,
                        'pendiente' => $pendiente,
                        'valor_pendiente' => $valorPendienteDia,
                        'subtotal' => $grupo->where('tipo', 'SALIDA')->sum('subtotal'),
                        'ordenes' => $grupo->whereIn('tipo', ['SALIDA', 'PEDIDO PENDIENTE'])->pluck('numero_orden')->unique()->count(),
                    ];
                });

            $chartData = [
                'labels' => $porDia->keys()->map(fn($k) => \Carbon\Carbon::parse($k)->format('d/m/Y'))->values(),
                'solicitado' => $porDia->pluck('solicitado')->values(),
                'produccion' => $porDia->pluck('produccion')->values(),
                'entrada_directa' => $porDia->pluck('entrada_directa')->values(),
                'desmedro' => $porDia->pluck('desmedro')->values(),
                'salidas' => $porDia->pluck('salidas')->values(),
                'pendiente' => $porDia->pluck('pendiente')->values(),
                'valor_pendiente' => $porDia->pluck('valor_pendiente')->values(),
                'subtotal' => $porDia->pluck('subtotal')->values(),
                'ordenes' => $porDia->pluck('ordenes')->values(),
                'producto' => $productId ? optional(Product::find($productId))->nombre : null,
                'cliente' => $clientId ? optional(Client::find($clientId))->razon_social : null,
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
                'totalSolicitado',
                'totalPendiente',
                'valorPendiente',
                'cumplimiento',

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