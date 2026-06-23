<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Movement;

class InventoryController extends Controller
{
    /**
     * 🔹 Vista de ingresos + historial
     */
    public function index()
    {
        $products = Product::all();

        $movements = Movement::with('product')
            ->where('tipo', 'ENTRADA')
            ->latest()
            ->get();

        return view('inventory.ingresos', compact('products','movements'));
    }

    /**
     * 🔹 Registrar ingreso manual (LO IMPORTANTE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'cantidad' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // 🔥 BUSCAR SI YA EXISTE INVENTARIO (por país)
        $inventory = Inventory::where('product_id', $product->id)
            ->where('pais', $request->pais)
            ->first();

        if ($inventory) {
            // 🔥 SI EXISTE → SUMAR
            $inventory->stock += $request->cantidad;
            $inventory->save();
        } else {
            // 🔥 SI NO EXISTE → CREAR
            $inventory = Inventory::create([
                'product_id' => $product->id,
                'pais' => $request->pais,
                'zona' => $request->zona,
                'stock' => $request->cantidad
            ]);
        }

        // 🔥 REGISTRAR MOVIMIENTO
        Movement::create([
            'product_id' => $product->id,
            'pais' => $request->pais,
            'tipo' => 'ENTRADA',
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo ?? 'INGRESO MANUAL'
        ]);

        return back()->with('success', 'Ingreso registrado correctamente');
    }

    /**
     * 🔹 Sumar stock rápido (AJAX)
     */
    public function add(Request $request, $id)
    {
        $inv = Inventory::findOrFail($id);

        $cantidad = (int) $request->cantidad;

        $inv->stock += $cantidad;
        $inv->save();

        Movement::create([
            'product_id' => $inv->product_id,
            'pais' => $inv->pais,
            'tipo' => 'ENTRADA',
            'cantidad' => $cantidad,
            'motivo' => 'INGRESO RÁPIDO'
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * 🔹 Ver detalle + historial (modal o API)
     */
    public function show($id)
    {
        $inventory = Inventory::with('product')->findOrFail($id);

        $movements = Movement::where('product_id', $inventory->product_id)
            ->where('pais', $inventory->pais)
            ->latest()
            ->get();

        return response()->json([
            'inventory' => $inventory,
            'movements' => $movements
        ]);
    }
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