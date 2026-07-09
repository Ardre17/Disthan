<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
// Reemplaza tu método show() en RawMaterialController
// También agrega el use de RawMaterialEntry al inicio del controlador si no lo tienes:
// use App\Models\RawMaterialEntry;
// use App\Models\ProductionOrder;

public function show(RawMaterial $raw_material)
{
    // Entradas registradas para esta materia prima
    // 👉 AJUSTA: si tu modelo se llama distinto cámbialo aquí
    $entradas = \App\Models\RawMaterialEntry::where('raw_material_id', $raw_material->id)
        ->orderByDesc('created_at')
        ->paginate(10);

    // Órdenes de producción donde se usó esta materia prima
    $produccionesUsadas = \App\Models\ProductionOrder::where('raw_material_id', $raw_material->id)
        ->orderByDesc('created_at')
        ->take(10)
        ->get();

    // Total entradas y total consumido
    $totalEntradas = \App\Models\RawMaterialEntry::where('raw_material_id', $raw_material->id)->sum('quantity');
    $totalConsumido = \App\Models\ProductionOrder::where('raw_material_id', $raw_material->id)
        ->where('status', 'FINALIZADA')
        ->sum('consumed_quantity');

    return view('raw_materials.show', compact(
        'raw_material',
        'entradas',
        'produccionesUsadas',
        'totalEntradas',
        'totalConsumido'
    ));
}
    public function index()
{
    $materials = RawMaterial::orderByRaw("
        CASE
            WHEN status='AGOTADO' THEN 1
            WHEN status='STOCK_BAJO' THEN 2
            ELSE 3
        END
    ")
    ->orderBy('name')
    ->get();

    $total = RawMaterial::count();

    $disponibles = RawMaterial::where('status','DISPONIBLE')->count();

    $stockBajo = RawMaterial::where('status','STOCK_BAJO')->count();

    $agotadas = RawMaterial::where('status','AGOTADO')->count();

    return view('raw_materials.index', compact(
        'materials',
        'total',
        'disponibles',
        'stockBajo',
        'agotadas'
    ));
}

    public function create()
    {
        return view('raw_materials.create');
    }

    public function store(Request $request)
{
    $request->validate([

        'name'=>'required',

        'unit'=>'required',

    ]);

    $ultimo=RawMaterial::max('id')+1;

    $codigo='MP'.str_pad($ultimo,6,'0',STR_PAD_LEFT);

    $estado='DISPONIBLE';

    if($request->stock<=$request->minimum_stock){

        $estado='STOCK_BAJO';

    }

    if($request->stock<=0){

        $estado='AGOTADO';

    }

    RawMaterial::create([

        'code'=>$codigo,

        'name'=>$request->name,

        'category'=>$request->category,

        'supplier'=>$request->supplier,

        'color'=>$request->color,

        'unit'=>$request->unit,

        'stock'=>$request->stock,

        'minimum_stock'=>$request->minimum_stock,

        'status'=>$estado,

        'active'=>$request->active,

        'notes'=>$request->notes

    ]);

    return redirect()

        ->route('raw-materials.index')

        ->with('success','Materia Prima registrada.');

}

    public function edit(RawMaterial $raw_material)
    {
        return view('raw_materials.edit', compact('raw_material'));
    }

    public function update(Request $request, RawMaterial $raw_material)
{
    $request->validate([

        'name'=>'required',

        'unit'=>'required',

    ]);

    $estado='DISPONIBLE';

    if($request->stock<=$request->minimum_stock){

        $estado='STOCK_BAJO';

    }

    if($request->stock<=0){

        $estado='AGOTADO';

    }

    $raw_material->update([

        'name'=>$request->name,

        'category'=>$request->category,

        'supplier'=>$request->supplier,

        'color'=>$request->color,

        'unit'=>$request->unit,

        'stock'=>$request->stock,

        'minimum_stock'=>$request->minimum_stock,

        'status'=>$estado,

        'active'=>$request->active,

        'notes'=>$request->notes

    ]);

    return redirect()

        ->route('raw-materials.index')

        ->with('success','Materia Prima actualizada.');

}

    public function destroy(RawMaterial $raw_material)
    {
        $raw_material->delete();

        return back();
    }
}