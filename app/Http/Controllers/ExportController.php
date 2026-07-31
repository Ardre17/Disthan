<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pallet;
use App\Models\PalletDetail;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Mostrar la vista de exportación.
     */
    public function show(Order $order)
    {
        return view('orders.edit_exportacion', compact('order'));
    }

    /**
     * Crear un nuevo pallet.
     */
    public function storePallet(Order $order)
    {
        $ultimo = Pallet::where('order_id', $order->id)
                        ->max('orden');

        $ultimoCodigo = Pallet::max('id') + 1;

        Pallet::create([
            'order_id'   => $order->id,
            'codigo'     => 'PLT-' . str_pad($ultimoCodigo, 6, '0', STR_PAD_LEFT),
            'orden'      => $orden,
            'estado'     => 'ABIERTO',
            'peso_neto'  => 0,
            'peso_bruto' => 0,
            'cerrado'    => false,
        ]);
        return redirect()->back()->with('success', 'Pallet creado correctamente.');
    }
    public function agregarProducto(Request $request, Pallet $pallet)
{
    $request->validate([
        'order_detail_id' => 'required|exists:order_details,id',
        'cantidad' => 'required|numeric|min:1',
    ]);

    $orderDetail = $pallet->order->details()
        ->with('palletDetails')
        ->findOrFail($request->order_detail_id);

    $cantidadEnPallets = $orderDetail->palletDetails->sum('cantidad');

    $pendiente = $orderDetail->cantidad_solicitada - $cantidadEnPallets;

    if ($request->cantidad > $pendiente) {
        return back()->with('error', 'La cantidad supera el pendiente del pedido.');
    }

    $producto = $orderDetail->product;

    PalletDetail::create([
        'pallet_id'       => $pallet->id,
        'order_detail_id' => $orderDetail->id,
        'product_id'      => $producto->id,
        'cantidad'        => $request->cantidad,
        'peso'            => ($producto->peso * $request->cantidad) / 1000,
    ]);

    return back()->with('success', 'Producto agregado al pallet.');
}
}