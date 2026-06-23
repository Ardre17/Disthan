<?php

namespace App\Http\Controllers;

use App\Models\Inventory;

class InventorydController extends Controller
{
public function salida(Request $request, $id)
{
    $inv = \App\Models\Inventory::findOrFail($id);

    $cantidad = (int) $request->cantidad;

    if ($cantidad > $inv->stock) {
        return response()->json(['error' => 'Stock insuficiente'], 400);
    }

    $inv->stock -= $cantidad;
    $inv->save();

    \App\Models\Movement::create([
        'product_id' => $inv->product_id,
        'pais' => $inv->pais,
        'tipo' => 'SALIDA',
        'cantidad' => $cantidad,
        'motivo' => 'SALIDA MANUAL'
    ]);

    return response()->json(['success' => true]);
}
}