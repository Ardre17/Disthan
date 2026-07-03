<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseLocation;
use App\Models\Product;

class WarehouseController extends Controller
{
    // ── Vista principal ───────────────────────────────────────────────────
    public function index()
    {
        $locations = WarehouseLocation::with('product')->get();

        // Racks indexados por "nivel-fila-espacio-slot"
        $racks = $locations->where('tipo', 'RACK')
            ->keyBy(fn($l) => "{$l->nivel}-{$l->fila}-{$l->espacio}-{$l->slot}");

        // Zonas de rotación indexadas por "nivel-espacio"
        $rotacion = $locations->where('tipo', 'ROTACION')
            ->keyBy(fn($l) => "{$l->nivel}-{$l->espacio}");

        // Productos activos para el selector del modal
        $products = Product::where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'sku', 'stock', 'stock_minimo', 'lote', 'fecha_vencimiento', 'marca']);

        // KPIs
        $totalSlots    = $locations->count();
        $ocupados      = $locations->whereNotNull('product_id')->count();
        $libres        = $totalSlots - $ocupados;
        $productosDistintos = $locations->pluck('product_id')->filter()->unique()->count();

        return view('warehouse.index', compact(
            'racks', 'rotacion', 'products',
            'totalSlots', 'ocupados', 'libres', 'productosDistintos'
        ));
    }

    // ── Asignar / actualizar un slot ─────────────────────────────────────
    public function assign(Request $request, WarehouseLocation $location)
    {
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
            'success'      => true,
            'message'      => $request->product_id ? 'Producto asignado.' : 'Slot vaciado.',
            'color_estado' => $location->color_estado,
            'etiqueta'     => $location->etiqueta,
            'product'      => $location->product ? [
                'nombre'          => $location->product->nombre,
                'sku'             => $location->product->sku,
                'stock'           => $location->product->stock,
                'stock_minimo'    => $location->product->stock_minimo,
                'lote'            => $location->product->lote,
                'fecha_vencimiento'=> $location->product->fecha_vencimiento,
                'marca'           => $location->product->marca,
            ] : null,
        ]);
    }

    // ── Vaciar un slot ───────────────────────────────────────────────────
    public function clear(WarehouseLocation $location)
    {
        $location->update(['product_id' => null, 'cantidad' => 0, 'observaciones' => null]);
        return response()->json(['success' => true, 'message' => 'Slot vaciado.']);
    }
}