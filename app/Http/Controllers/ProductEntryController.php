<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductEntry;

class ProductEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductEntry::with('product', 'user')
            ->orderByDesc('created_at');

        // Filtro por producto
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filtro por fecha
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $entries  = $query->paginate(15)->withQueryString();
        $products = Product::where('activo', true)->orderBy('nombre')->get();

        // KPIs
        $totalEntradas   = ProductEntry::count();
        $totalUnidades   = ProductEntry::sum('quantity');
        $hoy             = ProductEntry::whereDate('created_at', today())->sum('quantity');
        $productosActivos= Product::where('activo', true)->count();

        return view('product_entries.index', compact(
            'entries',
            'products',
            'totalEntradas',
            'totalUnidades',
            'hoy',
            'productosActivos'
        ));
    }

    public function create()
    {
        $products = Product::where('activo', true)->orderBy('nombre')->get();
        return view('product_entries.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'quantity'         => 'required|numeric|min:0.01',
            'supplier'         => 'nullable|string|max:255',
            'lote'             => 'nullable|string|max:100',
            'fecha_vencimiento'=> 'nullable|date',
            'observation'      => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);
        $stockAntes = $product->stock;
        $stockDespues = $stockAntes + $request->quantity;

        // Registrar entrada en historial
        ProductEntry::create([
            'product_id'        => $product->id,
            'quantity'          => $request->quantity,
            'stock_before'      => $stockAntes,
            'stock_after'       => $stockDespues,
            'supplier'          => $request->supplier,
            'lote'              => $request->lote,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'observation'       => $request->observation,
            'user_id'           => auth()->id(),
        ]);

        // Actualizar stock del producto
        $product->stock = $stockDespues;

        // Si se provee lote o fecha de vencimiento, actualizar el producto también
        if ($request->filled('lote')) {
            $product->lote = $request->lote;
        }
        if ($request->filled('fecha_vencimiento')) {
            $product->fecha_vencimiento = $request->fecha_vencimiento;
        }

        $product->save();

        return redirect()->route('product-entries.index')
            ->with('success', "✅ Entrada registrada. +{$request->quantity} unidades de {$product->nombre}. Stock actual: {$stockDespues}.");
    }
}