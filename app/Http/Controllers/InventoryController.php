<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Movement;

class InventoryController extends Controller
{
    // 🔥 ESTE FALTABA (MUY IMPORTANTE)
    public function index()
    {
        $inventories = Inventory::with('product')->get();

        return view('inventory.index', compact('inventories'));
    }

    // 🔥 SALIDA CORREGIDA
    public function salida(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:1'
        ]);

        $inv = Inventory::findOrFail($id);

        $cantidad = (int) $request->cantidad;

        if ($cantidad > $inv->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuficiente'
            ], 400);
        }

        $inv->stock -= $cantidad;
        $inv->save();

        Movement::create([
            'product_id' => $inv->product_id,
            'pais' => $inv->pais,
            'tipo' => 'SALIDA',
            'cantidad' => $cantidad,
            'motivo' => $request->motivo ?? 'SALIDA MANUAL'
        ]);

        return response()->json([
            'success' => true,
            'stock_actual' => $inv->stock
        ]);
    }
}