<?php

namespace App\Http\Controllers;

use App\Services\InventoryService;
use App\Models\ProductionOrder;
use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $orders = ProductionOrder::with([
        'product',
        'rawMaterial',
        'user'
    ])
    ->latest()
    ->get();

    /*
    |--------------------------------------------------------------------------
    | Agrupar producción por producto
    |--------------------------------------------------------------------------
    */

    $productosProduccion = $orders
        ->groupBy('product_id')
        ->map(function ($producciones) {

            $primera = $producciones->first();

            $producto = $primera->product;

            $totalProducido = $producciones->sum(function ($orden) {
                return (float) ($orden->produced_quantity ?? 0);
            });

            $finalizadas = $producciones->filter(function ($orden) {
                return strtoupper($orden->status) === 'FINALIZADA';
            });

            $enProduccion = $producciones->filter(function ($orden) {
                return strtoupper($orden->status) === 'EN_PRODUCCION';
            });

            $ultimaProduccion = $producciones->sortByDesc('created_at')->first();

            return (object) [
                'product_id' => $producto?->id,

                'producto' => $producto,

                'total_producido' => $totalProducido,

                'cantidad_ordenes' => $producciones->count(),

                'finalizadas' => $finalizadas->count(),

                'en_produccion' => $enProduccion->count(),

                'ultima' => $ultimaProduccion,

                'ordenes' => $producciones->values(),

                'raw_materials' => $producciones
                    ->map(fn ($orden) => $orden->rawMaterial)
                    ->filter()
                    ->unique('id')
                    ->values(),
            ];
        })
        ->sortBy(function ($producto) {
            return strtolower($producto->producto?->nombre ?? '');
        })
        ->values();

    return view(
        'production_orders.index',
        compact(
            'orders',
            'productosProduccion'
        )
    );
}

    /**
     * Show the form for creating a new resource.
     */

public function create()
{
    return view('production_orders.create', [

        'products' => Product::orderBy('nombre')->get(),

        'materials' => RawMaterial::orderBy('name')->get(),

    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([

        'product_id'=>'required',

        'raw_material_id'=>'required',

        'produced_quantity'=>'required|numeric|min:0.01',

        'consumed_quantity'=>'required|numeric|min:0.01',

    ]);

    $ultimo = ProductionOrder::max('id') + 1;

    $numero = 'OP'.str_pad($ultimo,6,'0',STR_PAD_LEFT);

    $orden = ProductionOrder::create([

        'number'=>$numero,

        'product_id'=>$request->product_id,

        'raw_material_id'=>$request->raw_material_id,

        'produced_quantity'=>$request->produced_quantity,

        'consumed_quantity'=>$request->consumed_quantity,

        'observation'=>$request->observation,

        'user_id'=>auth()->id(),

        'status'=>'EN_PRODUCCION'

    ]);

    return redirect()

        ->route('production-orders.show',$orden)

        ->with('success','Producción iniciada.');

}

    /**
     * Display the specified resource.
     */
    public function show(ProductionOrder $production_order)
{
    $production_order->load([

        'product',

        'rawMaterial',

        'user'

    ]);

    return view(

        'production_orders.show',

        compact('production_order')

    );
}

    public function ver(ProductionOrder $production_order)
{
    $production_order->load([
        'product',
        'rawMaterial',
        'user',
    ]);

    return response()->json([
        'id' => $production_order->id,
        'number' => $production_order->number,
        'product' => $production_order->product?->nombre ?? '—',
        'raw_material' => $production_order->rawMaterial?->name ?? '—',
        'produced_quantity' => (float) $production_order->produced_quantity,
        'consumed_quantity' => (float) $production_order->consumed_quantity,
        'observation' => $production_order->observation ?? '—',
        'status' => $production_order->status,
        'user' => $production_order->user?->name ?? '—',
        'date' => $production_order->created_at
            ? $production_order->created_at->format('d/m/Y H:i')
            : '—',
    ]);
}


public function edit(ProductionOrder $production_order)
{
    $production_order->load([
        'product',
        'rawMaterial',
    ]);

    return response()->json([
        'id' => $production_order->id,
        'number' => $production_order->number,
        'product_id' => $production_order->product_id,
        'raw_material_id' => $production_order->raw_material_id,
        'produced_quantity' => (float) $production_order->produced_quantity,
        'consumed_quantity' => (float) $production_order->consumed_quantity,
        'observation' => $production_order->observation ?? '',
        'status' => $production_order->status,
        'product' => $production_order->product?->nombre ?? '—',
        'raw_material' => $production_order->rawMaterial?->name ?? '—',
    ]);
}


public function update(
    Request $request,
    ProductionOrder $production_order
) {
    $request->validate([
        'produced_quantity' => 'required|numeric|min:0.01',
        'consumed_quantity' => 'required|numeric|min:0.01',
        'observation' => 'nullable|string|max:1000',
    ]);

    /*
     * Si la producción ya está finalizada,
     * primero revertimos su efecto anterior.
     */
    DB::transaction(function () use ($request, $production_order) {

        $material = $production_order->rawMaterial;
        $producto = $production_order->product;

        if ($production_order->status === 'FINALIZADA') {

            // Devolver la materia prima que consumió la OP anterior
            $material->stock += $production_order->consumed_quantity;

            if ($material->stock <= 0) {
                $material->status = 'AGOTADO';
            } elseif ($material->stock <= $material->minimum_stock) {
                $material->status = 'STOCK_BAJO';
            } else {
                $material->status = 'DISPONIBLE';
            }

            $material->save();

            // Retirar del stock el producto terminado anterior
            $producto->stock -= $production_order->produced_quantity;

            if ($producto->stock < 0) {
                $producto->stock = 0;
            }

            $producto->save();
        }

        /*
         * Actualizamos las cantidades.
         */
        $production_order->produced_quantity =
            $request->produced_quantity;

        $production_order->consumed_quantity =
            $request->consumed_quantity;

        $production_order->observation =
            $request->observation;

        /*
         * Si estaba finalizada, aplicamos nuevamente
         * el efecto de la producción con los nuevos valores.
         */
        if ($production_order->status === 'FINALIZADA') {

            if ($material->stock < $request->consumed_quantity) {

                throw new \Exception(
                    'No hay suficiente materia prima para aplicar la modificación.'
                );
            }

            $material->stock -= $request->consumed_quantity;

            if ($material->stock <= 0) {
                $material->status = 'AGOTADO';
            } elseif ($material->stock <= $material->minimum_stock) {
                $material->status = 'STOCK_BAJO';
            } else {
                $material->status = 'DISPONIBLE';
            }

            $material->save();

            $producto->stock += $request->produced_quantity;

            $producto->save();
        }

        $production_order->save();
    });

    return back()->with(
        'success',
        'La orden de producción fue actualizada correctamente.'
    );
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionOrder $production_order)
{
    DB::transaction(function () use ($production_order) {

        // Si ya estaba finalizada, revertimos inventario
        if ($production_order->status === 'FINALIZADA') {

            $material = $production_order->rawMaterial;
            $producto = $production_order->product;

            // Devolver materia prima
            $material->stock += $production_order->consumed_quantity;

            // Recalcular estado
            if ($material->stock <= 0) {
                $material->status = 'AGOTADO';
            } elseif ($material->stock <= $material->minimum_stock) {
                $material->status = 'STOCK_BAJO';
            } else {
                $material->status = 'DISPONIBLE';
            }

            $material->save();

            // Restar producto terminado
            $producto->stock -= $production_order->produced_quantity;

            // Evitar stock negativo
            if ($producto->stock < 0) {
                $producto->stock = 0;
            }

            $producto->save();
        }

        // Eliminar la orden
        $production_order->delete();

    });

    return redirect()
        ->route('production-orders.index')
        ->with('success', 'La orden de producción fue eliminada y el inventario restaurado correctamente.');
}
    public function finish(ProductionOrder $production_order)
{
    if($production_order->status=='FINALIZADA'){

        return back()->with('error',
            'La producción ya fue finalizada.');

    }

    DB::transaction(function() use($production_order){

        $material=$production_order->rawMaterial;

        $producto=$production_order->product;

        // Validar stock

        if($material->stock < $production_order->consumed_quantity){

            throw new \Exception(
                'No hay suficiente materia prima.'
            );

        }
        
    // Descontar materia prima

$material->stock -= $production_order->consumed_quantity;

// Actualizar estado...

$material->save();

// Aumentar producto

$producto->stock += $production_order->produced_quantity;

$producto->save();
        // Cambiar estado

        $production_order->status='FINALIZADA';

        $production_order->save();

    });

    return redirect()

        ->route(
            'production-orders.show',
            $production_order
        )

        ->with(
            'success',
            'Producción finalizada correctamente.'
        );
}
}
