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

        $total = $order->details->count();

        $preparados = $order->details
            ->where('preparado', true)
            ->count();

        $progreso = $total > 0
            ? round(($preparados / $total) * 100)
            : 0;

        return view(
            'orders.preparation.show',
            compact(
                'order',
                'total',
                'preparados',
                'progreso'
            )
        );

    }

}