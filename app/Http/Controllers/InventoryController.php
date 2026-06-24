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

    $inv = \App\Models\Inventory::findOrFail($id);

    $cantidad = (int) $request->cantidad;

    if ($cantidad > $inv->stock) {
        return response()->json([
            'success' => false,
            'message' => 'Stock insuficiente'
        ]);
    }

    // 🔥 RESTAR STOCK
    $inv->stock = $inv->stock - $cantidad;
    $inv->save();

    // 🔥 GUARDAR MOVIMIENTO
    \App\Models\Movement::create([
        'product_id' => $inv->product_id,
        'tipo' => 'SALIDA',
        'cantidad' => $cantidad,
        'motivo' => 'SALIDA MANUAL'
    ]);

    return response()->json([
        'success' => true,
        'nuevo_stock' => $inv->stock
    ]);
}
    
    public function controlEtiquetas()
{
    $products = \App\Models\Product::all();

    $inventories = \App\Models\Inventory::with(['product','movements'])->get();

    $movements = \App\Models\Movement::with('product')
        ->latest()
        ->get();

    return view('inventory.control_etiquetas', compact(
        'products',
        'inventories',
        'movements'
    ));
}
public function storeMovimiento(Request $request)
{
    $product = \App\Models\Product::findOrFail($request->product_id);

    if ($request->tipo == 'ENTRADA') {
        $product->stock += $request->cantidad;
    } else {
        if ($request->cantidad > $product->stock) {
            return response()->json(['error' => 'Stock insuficiente'], 400);
        }
        $product->stock -= $request->cantidad;
    }

    $product->save();

    \App\Models\Movement::create([
        'product_id' => $product->id,
        'tipo' => $request->tipo,
        'cantidad' => $request->cantidad,
        'motivo' => $request->motivo
    ]);

    return response()->json(['success' => true]);
}
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required',
        'idioma' => 'required',
        'zona' => 'required',
        'cantidad' => 'required|numeric|min:1'
    ]);

    $inv = \App\Models\Inventory::create([
        'product_id' => $request->product_id,
        'idioma' => $request->idioma,
        'zona' => $request->zona,
        'stock' => $request->cantidad
    ]);

    \App\Models\Movement::create([
        'product_id' => $request->product_id,
        'tipo' => 'ENTRADA',
        'cantidad' => $request->cantidad,
        'motivo' => 'CREACIÓN ETIQUETA'
    ]);

    return back()->with('success', 'Etiqueta creada');
}
public function add(Request $request, $id)
{
    $request->validate([
        'cantidad' => 'required|numeric|min:1'
    ]);

    $inv = \App\Models\Inventory::findOrFail($id);

    $cantidad = (int) $request->cantidad;

    // 🔥 SUMAR STOCK
    $inv->stock = $inv->stock + $cantidad;
    $inv->save();

    // 🔥 REGISTRAR MOVIMIENTO
    \App\Models\Movement::create([
        'product_id' => $inv->product_id,
        'tipo' => 'ENTRADA',
        'cantidad' => $cantidad,
        'motivo' => 'ENTRADA MANUAL'
    ]);

    return response()->json([
        'success' => true,
        'nuevo_stock' => $inv->stock
    ]);
}
}
