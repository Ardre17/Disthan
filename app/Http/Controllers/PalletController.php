<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PalletType;
use App\Services\PalletPlannerService;

class PalletController extends Controller
{
public function destroyDetalle($detalle)
{
    // Buscar el detalle del pallet
    $palletDetalle = \App\Models\PalletDetail::findOrFail($detalle);

    // Obtener el pallet
    $pallet = $palletDetalle->pallet;

    // Obtener la orden
    $order = $pallet->order;

    // No permitir modificaciones si la exportación está cerrada
    if ($order && $order->estado === 'COMPLETO') {
        return back()->with(
            'error',
            'No se puede modificar una exportación cerrada.'
        );
    }

    // Guardar información para el mensaje
    $producto = $palletDetalle->product
        ? $palletDetalle->product->nombre
        : 'Producto';

    $cantidad = $palletDetalle->cantidad_cajas;

    // Eliminar solamente la asignación del producto al pallet
    $palletDetalle->delete();

    return back()->with(
        'success',
        "Se eliminaron {$cantidad} cajas de {$producto} del Pallet {$pallet->orden}."
    );
}
    public function generar(Order $order)
{
    $pallet = PalletType::where('activo', true)->first();

    $planner = new PalletPlannerService();

    $resultado = $planner->generar($order, $pallet);

    return view('pallets.resultado', compact('resultado'));
}

    public function index()
    {
        return view('pallets.index');
    }

    public function configuracion()
    {
        return view('pallets.configuracion');
    }

    public function simulador()
    {
        return view('pallets.simulador');
    }
}