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

    return view(
        'production_orders.index',
        compact('orders')
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionOrder $production_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionOrder $production_order)
    {
        //
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
