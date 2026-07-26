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

        $orden = $ultimo ? $ultimo + 1 : 1;

        Pallet::create([

            'order_id' => $order->id,

            'codigo' => 'PLT-' . str_pad($orden, 3, '0', STR_PAD_LEFT),

            'orden' => $orden,

            'estado' => 'ABIERTO',

            'peso_neto' => 0,

            'peso_bruto' => 0,

            'cerrado' => false,

        ]);

        return redirect()->back()->with('success', 'Pallet creado correctamente.');
    }
}