<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pallet;
use App\Models\PalletDetail;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function actualizarCapacidadPallet(Request $request, Pallet $pallet)
{
    $request->validate([
        'capacidad_cajas' => 'required|integer|min:1|max:1000',
    ]);

    $cajasActuales = $pallet->detalles()->sum('cantidad');

    if ((int) $request->capacidad_cajas < $cajasActuales) {
        return back()->with(
            'error',
            "La capacidad no puede ser menor que las {$cajasActuales} cajas que ya tiene el pallet."
        );
    }

    $pallet->update([
        'capacidad_cajas' => $request->capacidad_cajas,
    ]);

    return back()->with(
        'success',
        "Capacidad del pallet {$pallet->codigo} actualizada correctamente."
    );
}
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
public function storePallet(Request $request, Order $order)
{
    $request->validate([
        'capacidad_cajas' => 'required|integer|min:1|max:1000',
    ]);

    $ultimo = Pallet::where('order_id', $order->id)
        ->max('orden');

    $orden = $ultimo ? $ultimo + 1 : 1;

    $ultimoCodigo = (Pallet::max('id') ?? 0) + 1;

    Pallet::create([
        'order_id'       => $order->id,
        'codigo'         => 'PLT-' . str_pad($ultimoCodigo, 6, '0', STR_PAD_LEFT),
        'capacidad_cajas'=> $request->capacidad_cajas,
        'orden'          => $orden,
        'estado'         => 'ABIERTO',
        'peso_neto'      => 0,
        'peso_bruto'     => 0,
        'cerrado'        => false,
    ]);

    return redirect()->back()->with(
        'success',
        "Pallet creado correctamente con capacidad de {$request->capacidad_cajas} cajas."
    );
}

    public function agregarProducto(Request $request, Pallet $pallet)
{
    $request->validate([
        'order_detail_id' => 'required|exists:order_details,id',
        'cantidad_cajas'  => 'required|integer|min:1',
    ]);

    $order = $pallet->order;

    $orderDetail = $order->details()
        ->with(['palletDetails', 'product'])
        ->findOrFail($request->order_detail_id);

    $producto = $orderDetail->product;

    /*
     * =========================================================
     * 1. DATOS DEL PRODUCTO
     * =========================================================
     */

    $porCaja = (int) ($producto->cantidad_por_caja ?? 1);

    if ($porCaja < 1) {
        $porCaja = 1;
    }

    $cajasSolicitadas = (int) $request->cantidad_cajas;

    /*
     * =========================================================
     * 2. CONVERTIR CAJAS A UNIDADES
     * =========================================================
     */

    $unidadesSolicitadas = $cajasSolicitadas * $porCaja;

    /*
     * =========================================================
     * 3. VALIDAR PENDIENTE DEL PRODUCTO
     * =========================================================
     */

    $unidadesEnPallets = $orderDetail->palletDetails
        ->sum('cantidad');

    $unidadesPendientes =
        $orderDetail->cantidad_solicitada - $unidadesEnPallets;

    if ($unidadesSolicitadas > $unidadesPendientes) {

        $cajasDisponibles = intdiv(
            max(0, (int) $unidadesPendientes),
            $porCaja
        );

        return back()->with(
            'error',
            "Solo puedes agregar {$cajasDisponibles} cajas de este producto."
        );
    }

    /*
     * =========================================================
     * 4. VALIDAR CAPACIDAD DEL PALLET
     * =========================================================
     */

    $capacidadPallet = (int) ($pallet->capacidad_cajas ?? 0);

    if ($capacidadPallet < 1) {
        $capacidadPallet = 1;
    }

    $cajasActuales = (int) $pallet->detalles()
        ->sum('cantidad_cajas');

    $nuevoTotalCajas = $cajasActuales + $cajasSolicitadas;

    if ($nuevoTotalCajas > $capacidadPallet) {

        $disponibles = max(
            0,
            $capacidadPallet - $cajasActuales
        );

        return back()->with(
            'error',
            "El pallet solo tiene espacio para {$disponibles} cajas."
        );
    }

    /*
     * =========================================================
     * 5. VALIDAR OBJETIVO GLOBAL
     * =========================================================
     */

    if ($order->cajas_objetivo) {

        $totalAsignado = PalletDetail::whereHas(
            'pallet',
            function ($query) use ($order) {
                $query->where('order_id', $order->id);
            }
        )->sum('cantidad_cajas');

        $nuevoTotal = $totalAsignado + $cajasSolicitadas;

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
     * =========================================================
     * 6. GUARDAR
     * =========================================================
     */

    PalletDetail::create([
        'pallet_id'       => $pallet->id,
        'order_detail_id' => $orderDetail->id,
        'product_id'      => $producto->id,

        // Unidades
        'cantidad'        => $unidadesSolicitadas,

        // Cajas
        'cantidad_cajas'  => $cajasSolicitadas,

        // Peso
        'peso'            => ($producto->peso * $unidadesSolicitadas) / 1000,
    ]);

    return back()->with(
        'success',
        "{$cajasSolicitadas} cajas agregadas al pallet correctamente."
    );
}
   
}