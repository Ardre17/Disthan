<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderPreparationController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Bandeja de preparación
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::with('client')
            ->where('estado', '!=', 'COMPLETO')
            ->latest()
            ->get();

        return view(
            'orders.preparation.index',
            compact('orders')
        );
    }
/*
|--------------------------------------------------------------------------
| Asistente de preparación
|--------------------------------------------------------------------------
*/

public function show(Order $order)
{
    $order->load([
        'client',
        'details.product'
    ]);

    // Total de productos del pedido
    $total = $order->details->count();

    // Productos preparados
    $preparados = $order->details
        ->where('preparado', true)
        ->count();

    // Porcentaje de avance
    $progreso = $total > 0
        ? round(($preparados / $total) * 100)
        : 0;

    // Buscar el siguiente producto pendiente
    $productoActual = $order->details()
        ->where('preparado', false)
        ->with('product')
        ->orderBy('orden_preparacion')
        ->first();

    // Posición del producto actual (1 de X)
    $numeroProducto = 0;

    if ($productoActual) {

        $numeroProducto = $order->details()
            ->where('orden_preparacion', '<=', $productoActual->orden_preparacion)
            ->count();

    }

    return view(
        'orders.preparation.show',
        compact(
            'order',
            'productoActual',
            'numeroProducto',
            'total',
            'preparados',
            'progreso'
        )
    );
}

public function save(Request $request, OrderDetail $detail)
{
    $detail->update([

        'cantidad_preparada'      => $request->cantidad_preparada,

        'preparado'               => true,

        'preparado_por'           => Auth::id(),

        'fecha_preparacion'       => now(),

        'observacion_preparacion' => $request->observacion

    ]);

    $order = $detail->order;

    $siguiente = $order->details()
        ->where('preparado', false)
        ->with('product')
        ->orderBy('orden_preparacion')
        ->first();

    if (!$siguiente) {

        $order->estado_preparacion = 'ARMADO';

        $order->save();

        return response()->json([

            'finished' => true

        ]);

    }

    return response()->json([

    'finished' => false,

    'next' => [

        'id' => $siguiente->id,

        'cantidad_solicitada' => $siguiente->cantidad_solicitada,

        'cantidad_preparada' => $siguiente->cantidad_preparada,

        'precio_unitario' => $siguiente->precio_unitario,

        'sku' => $siguiente->product->sku,

        'barcode' => $siguiente->product->barcode,

        'nombre' => $siguiente->product->nombre,

        'advertencias' => $siguiente->product->advertencias,

    ]

]);

}
public function skip(OrderDetail $detail)
{
    $order = $detail->order;

    $siguiente = $order->details()
        ->where('preparado', false)
        ->where('id', '!=', $detail->id)
        ->with('product')
        ->orderBy('orden_preparacion')
        ->first();

    return response()->json([

        'success' => true,

        'next' => $siguiente

    ]);
}
public function notFound(OrderDetail $detail)
{
    $detail->update([

        'observacion_preparacion' => 'PRODUCTO NO ENCONTRADO'

    ]);

    $order = $detail->order;

    $siguiente = $order->details()
        ->where('preparado', false)
        ->where('id', '!=', $detail->id)
        ->with('product')
        ->orderBy('orden_preparacion')
        ->first();

    return response()->json([

        'success' => true,

        'next' => $siguiente

    ]);
}
public function finish(Order $order)
{

    $order->estado_preparacion = 'ARMADO';

    $order->save();

    return response()->json([

        'success' => true

    ]);

}