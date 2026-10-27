<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MobileProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));

        $products = Product::query()
            ->with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%")
                      ->orWhere('box_barcode', 'like', "%{$search}%")
                      ->orWhere('lote', 'like', "%{$search}%");
                });
            })
            ->orderBy('nombre')
            ->when($search !== '', fn ($query) => $query->paginate(20)->withQueryString());

        // Sin búsqueda no consultamos ni mostramos el catálogo completo.
        if ($search === '') {
            $products = Product::query()->whereRaw('1 = 0')->paginate(20);
        }

        return view('mobile.products.index', compact('products', 'search'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('activo', true)->orderBy('nombre')->get();
        return view('mobile.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product->id)],
            'nombre' => ['required', 'string', 'max:255'],
            'barcode' => ['nullable', 'string', 'max:255'],
            'box_barcode' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'marca' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'lote' => ['nullable', 'string', 'max:255'],
            'fecha_produccion' => ['nullable', 'date'],
            'fecha_vencimiento' => ['nullable', 'date'],
            'cantidad_por_caja' => ['nullable', 'integer', 'min:0'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'rotacion' => ['nullable', Rule::in(['MUY_ALTA', 'ALTA', 'MEDIA', 'BAJA'])],
            'stock' => ['required', 'numeric', 'min:0'],
            'imagen' => ['nullable', 'image', 'max:4096'],
        ]);

        $stockNuevo = (float) $validated['stock'];
        unset($validated['stock'], $validated['imagen']);

        if ($request->hasFile('imagen')) {
            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        DB::transaction(function () use ($product, $validated, $stockNuevo) {
            $productBloqueado = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();
            $stockAnterior = (float) $productBloqueado->stock;
            $diferencia = round($stockNuevo - $stockAnterior, 2);

            $productBloqueado->fill($validated);
            $productBloqueado->stock = $stockNuevo;
            $productBloqueado->save();

            if (abs($diferencia) > 0.00001) {
                Movement::create([
                    'product_id' => $productBloqueado->id,
                    'tipo' => $diferencia > 0 ? 'ENTRADA' : 'SALIDA',
                    'cantidad' => abs($diferencia),
                    'motivo' => 'AJUSTE DE STOCK DESDE DISTAN MÓVIL',
                ]);
            }
        });

        return redirect()->route('mobile.products.index', ['search' => $request->input('search_return', $product->barcode ?: $product->sku)])
            ->with('success', 'Producto actualizado y ajuste de stock registrado.');
    }
}
