<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function index(Request $request)
{
    $query = Product::query();

    if ($request->filled('search')) {

        $query->where(function($q) use ($request){

            $q->where('nombre', 'like', '%'.$request->search.'%')
              ->orWhere('sku', 'like', '%'.$request->search.'%')
              ->orWhere('barcode', 'like', '%'.$request->search.'%')
              ->orWhere('lote', 'like', '%'.$request->search.'%');

        });
    }

    if ($request->filled('category_id')) {

    $query->where(
        'category_id',
        $request->category_id
    );
}

    $products = $query
        ->latest()
        ->get();

$categories = Category::where('activo', true)
    ->orderBy('nombre')
    ->get();

    return view(
    'products.index',
    compact(
        'products',
        'categories'
    ));
}

    public function create()
{
    $categories = Category::where('activo', true)
        ->orderBy('nombre')
        ->get();

    return view(
        'products.create',
        compact('categories')
    );
}

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:products',
            'nombre' => 'required',
        ]);

        $imagePath = null;

        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')
                ->store('products', 'public');
        }

        Product::create([
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'category_id' => $request->category_id,
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'advertencias' => $request->advertencias
            ? implode(',', $request->advertencias)
            : null,
            'peso' => $request->peso ?? 0,
            'imagen' => $imagePath,

            'lote' => $request->lote,
            'fecha_produccion' => $request->fecha_produccion,
            'fecha_vencimiento' => $request->fecha_vencimiento,

            'cantidad_por_caja' => $request->cantidad_por_caja,

            'rotacion' => $request->rotacion,

            'stock' => $request->stock ?? 0,
            'stock_minimo' => $request->stock_minimo ?? 0,

            'activo' => true
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto registrado correctamente');
    }

    public function edit(Product $product)
{
    $categories = Category::where('activo', true)
        ->orderBy('nombre')
        ->get();

    return view(
        'products.edit',
        compact(
            'product',
            'categories'
        )
    );
}

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required',
            'nombre' => 'required',
        ]);

        $imagePath = $product->imagen;

        if ($request->hasFile('imagen')) {

            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }

            $imagePath = $request->file('imagen')
                ->store('products', 'public');
        }

        $product->update([

            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'category_id' => $request->category_id,
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,

            'advertencias' => $request->advertencias
                        ? implode(',', $request->advertencias)
                        : null,
            
            'peso' => $request->peso ?? 0,
            'imagen' => $imagePath,

            'lote' => $request->lote,
            'fecha_produccion' => $request->fecha_produccion,
            'fecha_vencimiento' => $request->fecha_vencimiento,

            'cantidad_por_caja' => $request->cantidad_por_caja,

            'rotacion' => $request->rotacion,

            'stock' => $request->stock,
            'stock_minimo' => $request->stock_minimo,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Product $product)
    {
        if ($product->imagen) {
            Storage::disk('public')->delete($product->imagen);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado correctamente');
    }
}
