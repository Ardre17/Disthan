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

        return view('orders.preparation.index', compact('orders'));
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

        $total = $order->details->count();

        $preparados = $order->details
            ->where('preparado', true)
            ->count();

        $progreso = $total > 0
            ? round(($preparados / $total) * 100)
            : 0;

        $productoActual = $order->details()
            ->where('preparado', false)
            ->with('product')
            ->orderBy('orden_preparacion')
            ->first();

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

    /*
    |--------------------------------------------------------------------------
    | Guardar producto preparado
    |--------------------------------------------------------------------------
    */

    public function save(Request $request, OrderDetail $detail)
    {
        $detail->update([
            'cantidad_preparada'      => $request->cantidad_preparada,
            'preparado'               => true,
            'preparado_por'           => Auth::id(),
            'fecha_preparacion'       => now(),
            'observacion_preparacion' => $request->observacion,
        ]);

        return response()->json(
            $this->obtenerSiguienteProducto($detail->order)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Saltar producto
    |--------------------------------------------------------------------------
    */

    public function skip(OrderDetail $detail)
    {
        return response()->json(
            $this->obtenerSiguienteProducto($detail->order)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Producto no encontrado
    |--------------------------------------------------------------------------
    */

    public function notFound(OrderDetail $detail)
    {
        $detail->update([
            'observacion_preparacion' => 'PRODUCTO NO ENCONTRADO'
        ]);

        return response()->json(
            $this->obtenerSiguienteProducto($detail->order)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Finalizar pedido
    |--------------------------------------------------------------------------
    */

    public function finish(Order $order)
    {
        $order->estado_preparacion = 'ARMADO';

        $order->save();

        return response()->json([
            'success' => true
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener siguiente producto
    |--------------------------------------------------------------------------
    */

    private function obtenerSiguienteProducto(Order $order)
    {
        $siguiente = $order->details()
            ->where('preparado', false)
            ->with('product')
            ->orderBy('orden_preparacion')
            ->first();

        if (!$siguiente) {

            $order->estado_preparacion = 'ARMADO';
            $order->save();

            return [
                'finished' => true
            ];
        }

        return [

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

        ];
    }
}