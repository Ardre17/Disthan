<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MobileOrderController extends Controller
{
    /** Lista móvil de pedidos existentes. No crea ni modifica pedidos/stock. */
    public function index(Request $request)
    {
        $query = Order::query()
            ->with('client')
            ->withCount('details');

        if ($request->filled('tipo') && $request->tipo !== 'TODOS') {
            $query->whereRaw('UPPER(TRIM(tipo_orden)) = ?', [strtoupper(trim($request->tipo))]);
        }

        if ($request->filled('estado') && $request->estado !== 'TODOS') {
            $query->whereRaw('UPPER(TRIM(estado)) = ?', [strtoupper(trim($request->estado))]);
        } elseif (!$request->boolean('incluir_completos')) {
            $query->where('estado', '!=', 'COMPLETO');
        }

        if ($request->filled('q')) {
            $term = trim($request->q);
            $query->where(function ($q) use ($term) {
                $q->where('numero_orden', 'like', "%{$term}%")
                  ->orWhere('order_interna', 'like', "%{$term}%")
                  ->orWhereHas('client', fn ($client) => $client->where('razon_social', 'like', "%{$term}%"));
            });
        }

        $orders = $query->orderByDesc('fecha_pedido')->orderByDesc('id')->paginate(20)->withQueryString();

        $counts = Order::query()
            ->selectRaw("UPPER(TRIM(COALESCE(estado, 'SIN ESTADO'))) as estado_normalizado, COUNT(*) as total")
            ->groupBy('estado_normalizado')->pluck('total', 'estado_normalizado');

        return view('mobile.orders.index', compact('orders', 'counts'));
    }

    /** Consulta el detalle usando las relaciones ya definidas en el modelo Order. */
    public function show(Order $order)
    {
        $order->load([
            'client',
            'details.product',
            'bultos.detalles.product',
            'pallets.detalles.product',
        ]);

        return view('mobile.orders.show', compact('order'));
    }
}
