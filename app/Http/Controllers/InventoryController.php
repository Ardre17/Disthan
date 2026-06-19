<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{

    public function store(Request $request)
{
    $inv = \App\Models\Inventory::create([
        'product_id' => $request->product_id,
        'pais' => $request->pais,
        'zona' => $request->zona,
        'stock' => $request->cantidad
    ]);

    // 🔥 registrar movimiento inicial
    \App\Models\Movement::create([
        'product_id' => $request->product_id,
        'pais' => $request->pais,
        'tipo' => 'ENTRADA',
        'cantidad' => $request->cantidad,
        'motivo' => 'CREACIÓN ETIQUETA'
    ]);

    return back()->with('success', 'Etiqueta creada correctamente');
}
    public function add(Request $request, $id)
    {
        $inv = \App\Models\Inventory::findOrFail($id);

        $cantidad = (int) $request->cantidad;

        $inv->stock += $cantidad;
        $inv->save();

        \App\Models\Movement::create([
            'product_id' => $inv->product_id,
            'pais' => $inv->pais,
            'tipo' => 'ENTRADA',
            'cantidad' => $cantidad,
            'motivo' => 'INGRESO MANUAL'
        ]);

        return response()->json(['success' => true]);
    }


    public function show($id)
    {
        $inventory = \App\Models\Inventory::with('product')->findOrFail($id);

        $movements = \App\Models\Movement::where('product_id', $inventory->product_id)
            ->where('pais', $inventory->pais)
            ->latest()
            ->get();

        return response()->json([
            'inventory' => $inventory,
            'movements' => $movements
        ]);
    }

    public function index()
    {
        $inventories = Inventory::with('product')->get();

        return view('inventory.index', compact('inventories'));
    }
}

