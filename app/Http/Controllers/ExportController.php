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
        $order->load([
            'client',
            'details.product',
            'details.palletDetails',
            'pallets.detalles.product',
        ]);

        return view('orders.edit_exportacion', compact('order'));
    }

    /**
     * Guardar cantidad objetivo de cajas de la exportación.
     */
    public function actualizarCajasObjetivo(Request $request, Order $order)
    {
        $request->validate([
            'cajas_objetivo' => 'required|integer|min:1',
        ]);

        $order->update([
            'cajas_objetivo' => $request->cajas_objetivo,
        ]);

        return back()->with(
            'success',
            'Cantidad objetivo de cajas actualizada correctamente.'
        );
    }

    /**
     * Crear un nuevo pallet.
     */
    public function storePallet(Order $order)
    {
        $ultimo = Pallet::where('order_id', $order->id)
            ->max('orden');

        $orden = $ultimo ? $ultimo + 1 : 1;

        $ultimoCodigo = (Pallet::max('id') ?? 0) + 1;

        Pallet::create([
            'order_id'   => $order->id,
            'codigo'     => 'PLT-' . str_pad($ultimoCodigo, 6, '0', STR_PAD_LEFT),
            'orden'      => $orden,
            'estado'     => 'ABIERTO',
            'peso_neto'  => 0,
            'peso_bruto' => 0,
            'cerrado'    => false,
        ]);

        return redirect()->back()->with(
            'success',
            'Pallet creado correctamente.'
        );
    }

    /**
     * Agregar producto a un pallet.
     */
    public function agregarProducto(Request $request, Pallet $pallet)
    {
        $request->validate([
            'order_detail_id' => 'required|exists:order_details,id',
            'cantidad'        => 'required|numeric|min:1',
        ]);

        $order = $pallet->order;

        $orderDetail = $order->details()
            ->with('palletDetails')
            ->findOrFail($request->order_detail_id);

        /*
         * ---------------------------------------------------------
         * 1. Pendiente de este producto
         * ---------------------------------------------------------
         */

        $cantidadEnPallets = $orderDetail->palletDetails->sum('cantidad');

        $pendienteProducto =
            $orderDetail->cantidad_solicitada - $cantidadEnPallets;

        if ($request->cantidad > $pendienteProducto) {
            return back()->with(
                'error',
                'La cantidad supera el pendiente del producto.'
            );
        }

        /*
         * ---------------------------------------------------------
         * 2. Validar objetivo global de cajas
         * ---------------------------------------------------------
         */

        if ($order->cajas_objetivo) {

            $totalAsignado = PalletDetail::whereHas('pallet', function ($query) use ($order) {
                $query->where('order_id', $order->id);
            })->sum('cantidad');

            $nuevoTotal = $totalAsignado + $request->cantidad;

            if ($nuevoTotal > $order->cajas_objetivo) {

                $disponible = max(
                    0,
                    $order->cajas_objetivo - $totalAsignado
                );

                return back()->with(
                    'error',
                    "No puedes superar el objetivo de {$order->cajas_objetivo} cajas. " .
                    "Actualmente hay {$totalAsignado} asignadas y solo quedan {$disponible} disponibles."
                );
            }
        }

        /*
         * ---------------------------------------------------------
         * 3. Crear detalle del pallet
         * ---------------------------------------------------------
         */

        $producto = $orderDetail->product;

        PalletDetail::create([
            'pallet_id'       => $pallet->id,
            'order_detail_id' => $orderDetail->id,
            'product_id'      => $producto->id,
            'cantidad'        => $request->cantidad,
            'peso'            => ($producto->peso * $request->cantidad) / 1000,
        ]);

        return back()->with(
            'success',
            'Producto agregado al pallet.'
        );
    }
}