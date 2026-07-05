<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseLocation;
use App\Models\Product;

class WarehouseController extends Controller
{
    public function index()
    {
        $locations = WarehouseLocation::with('product')->get();

        $racks = $locations->where('tipo', 'RACK')
            ->keyBy(fn($l) => "{$l->nivel}-{$l->fila}-{$l->espacio}-{$l->slot}");

        $rotacion = $locations->where('tipo', 'ROTACION')
            ->keyBy(fn($l) => "{$l->nivel}-{$l->espacio}");

        $products = Product::where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'sku', 'stock', 'stock_minimo', 'lote', 'fecha_vencimiento', 'marca']);

        $totalSlots        = $locations->count();
        $ocupados          = $locations->whereNotNull('product_id')->count();
        $libres            = $totalSlots - $ocupados;
        $productosDistintos = $locations->pluck('product_id')->filter()->unique()->count();

        return view('warehouse.index', compact(
            'racks', 'rotacion', 'products',
            'totalSlots', 'ocupados', 'libres', 'productosDistintos'
        ));
    }

    // Asignar producto — acepta form POST normal
    public function assign(Request $request, WarehouseLocation $location)
{
    try {

        $request->validate([
            'product_id'    => 'nullable|exists:products,id',
            'cantidad'      => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $location->update([
            'product_id'    => $request->product_id ?: null,
            'cantidad'      => $request->cantidad ?? 0,
            'observaciones' => $request->observaciones,
        ]);

        $location->load('product');

        return response()->json([
            'success' => true,
            'message' => 'Producto asignado correctamente.',
        ]);

    } catch (\Throwable $e) {

        dd($e);

    }
}

    // Vaciar slot — acepta DELETE desde form con _method
    public function clear(WarehouseLocation $location)
    {
        $location->update(['product_id' => null, 'cantidad' => 0, 'observaciones' => null]);

        return redirect()->route('warehouse.index')
            ->with('success', 'Slot vaciado correctamente.');
    }
}