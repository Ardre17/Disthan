<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductionOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
                ->orWhere('box_barcode', 'like', '%'.$request->search.'%')
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

    // Materias primas registradas históricamente en órdenes de producción por producto.
    // No se interpreta como receta/BOM: cada orden registra una materia prima.
    $materiasPrimasPorProducto = [];
    $productIds = $products->pluck('id')->all();

    if (!empty($productIds)) {
        $ordenesProduccion = ProductionOrder::with('rawMaterial')
            ->whereIn('product_id', $productIds)
            ->whereNotNull('raw_material_id')
            ->get(['id', 'product_id', 'raw_material_id', 'produced_quantity', 'consumed_quantity', 'status', 'fecha_produccion']);

        foreach ($ordenesProduccion as $orden) {
            $mp = $orden->rawMaterial;
            if (!$mp) continue;

            $productoId = (string) $orden->product_id;
            $mpId = (string) $mp->id;

            if (!isset($materiasPrimasPorProducto[$productoId][$mpId])) {
                $materiasPrimasPorProducto[$productoId][$mpId] = [
                    'id' => $mp->id,
                    'code' => $mp->code,
                    'name' => $mp->name,
                    'category' => $mp->category,
                    'supplier' => $mp->supplier,
                    'unit' => $mp->unit,
                    'stock' => (float) ($mp->stock ?? 0),
                    'minimum_stock' => (float) ($mp->minimum_stock ?? 0),
                    'active' => (bool) ($mp->active ?? false),
                    'status' => $mp->status,
                    'ordenes' => 0,
                    'consumido_historico' => 0,
                ];
            }

            $materiasPrimasPorProducto[$productoId][$mpId]['ordenes']++;
            $materiasPrimasPorProducto[$productoId][$mpId]['consumido_historico'] += (float) ($orden->consumed_quantity ?? 0);
        }

        foreach ($materiasPrimasPorProducto as $id => $items) {
            $materiasPrimasPorProducto[$id] = array_values($items);
        }
    }

    // Análisis de rotación por frecuencia de pedidos con despacho real.
    // Se cuentan pedidos distintos por producto, no unidades despachadas.
    $rotacionAnalisis = [];
    $fechaAnalisis = now();
    $periodosRotacion = [30, 60, 90, 180];

    foreach ($periodosRotacion as $dias) {
        $desde = $fechaAnalisis->copy()->subDays($dias)->startOfDay();

        $salidas = DB::table('order_details')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id')
            ->selectRaw('COUNT(DISTINCT order_details.order_id) AS salidas')
            ->selectRaw('COALESCE(SUM(order_details.cantidad_despachada), 0) AS unidades')
            ->whereNotNull('order_details.product_id')
            ->where('order_details.cantidad_despachada', '>', 0)
            ->whereRaw('COALESCE(order_details.fecha_preparacion, orders.fecha_entrega, orders.fecha_pedido) >= ?', [$desde])
            ->whereRaw('COALESCE(order_details.fecha_preparacion, orders.fecha_entrega, orders.fecha_pedido) <= ?', [$fechaAnalisis])
            ->groupBy('order_details.product_id')
            ->get();

        foreach ($salidas as $fila) {
            $id = (string) $fila->product_id;
            $rotacionAnalisis[$id][$dias] = [
                'salidas' => (int) $fila->salidas,
                'unidades' => (float) $fila->unidades,
            ];
        }
    }


    return view(
    'products.index',
    compact(
        'products',
        'categories',
        'rotacionAnalisis',
        'materiasPrimasPorProducto'
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
            'box_barcode' => $request->box_barcode,
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
            'box_barcode' => $request->box_barcode,
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
    public function proyectado()
{
    $products = Product::with(['orderDetails' => function($q){
        $q->where('created_at', '>=', now()->subDays(60))
          ->whereHas('order', fn($o) => $o->where('estado','COMPLETO'));
    }])->orderBy('nombre')->get();

    $products = $products->map(function($p){
        $totalDespachado = $p->orderDetails->sum('cantidad_despachada');
        $ventasDiarias   = $totalDespachado / 60;

        $p->ventas_diarias   = round($ventasDiarias, 2);
        $p->proyectado_7d    = round($ventasDiarias * 7);
        $p->proyectado_30d   = round($ventasDiarias * 30);
        $p->cobertura_dias   = $ventasDiarias > 0
                                ? round($p->stock / $ventasDiarias)
                                : null;
        return $p;
    });

    $categories = \App\Models\Category::orderBy('nombre')->get();

    return view('products.proyectado', compact('products','categories'));
}
}
