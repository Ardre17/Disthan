<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Client;

class KardexController extends Controller
{
    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        $clientId  = $request->input('client_id');
        $dateFrom  = $request->input('date_from');
        $dateTo    = $request->input('date_to');

        // Órdenes con sus detalles y relaciones
        $query = Order::with(['client', 'details.product'])
            ->whereIn('estado', ['COMPLETO', 'PARCIAL', 'INCOMPLETO'])
            ->orderBy('fecha_pedido', 'desc');

        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        if ($dateFrom) {
            $query->whereDate('fecha_pedido', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('fecha_pedido', '<=', $dateTo);
        }

        if ($productId) {
            $query->whereHas('details', fn($q) => $q->where('product_id', $productId));
        }

        $orders = $query->get();

        // Construir movimientos: una fila por OrderDetail
        $movimientos = collect();

        foreach ($orders as $order) {
            foreach ($order->details as $detail) {
                if ($productId && $detail->product_id != $productId) {
                    continue;
                }

                $movimientos->push([
                    'fecha'              => $order->fecha_pedido,
                    'numero_orden'       => $order->numero_orden,
                    'cliente'            => optional($order->client)->razon_social ?? 'Sin cliente',
                    'client_id'          => $order->client_id,
                    'producto'           => optional($detail->product)->nombre ?? 'Sin producto',
                    'product_id'         => $detail->product_id,
                    'cantidad_solicitada'=> $detail->cantidad_solicitada,
                    'cantidad_despachada'=> $detail->cantidad_despachada,
                    'precio_unitario'    => $detail->precio_unitario,
                    'subtotal'           => $detail->subtotal,
                    'estado_item'        => $detail->estado_item,
                    'estado_orden'       => $order->estado,
                ]);
            }
        }

        // Stock actual directo desde Product
        $productosQuery = Product::where('activo', true)->orderBy('nombre');
        if ($productId) {
            $productosQuery->where('id', $productId);
        }
        $stockProductos = $productosQuery->get();

        // KPIs
        $totalSalidas         = $movimientos->sum('cantidad_despachada');
        $totalMovimientos     = $movimientos->count();
        $clientesActivos      = $movimientos->pluck('client_id')->unique()->count();
        $productosMovidos     = $movimientos->pluck('product_id')->unique()->count();
        $totalFacturado       = $movimientos->sum('subtotal');

        // Selectores de filtro
        $productos = Product::where('activo', true)->orderBy('nombre')->get();
        $clientes  = Client::orderBy('razon_social')->get();

        return view('kardex.index', compact(
            'movimientos',
            'stockProductos',
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
            'dateTo'
        ));
    }
}