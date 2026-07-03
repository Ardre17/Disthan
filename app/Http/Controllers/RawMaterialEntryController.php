<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\RawMaterialEntry;
use Illuminate\Http\Request;

class RawMaterialEntryController extends Controller
{
    public function create()
    {
        $materials = RawMaterial::orderBy('name')->get();

        return view(
            'raw_material_entries.create',
            compact('materials')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'raw_material_id' => 'required',

            'supplier' => 'required',

            'quantity' => 'required|numeric|min:0.01',

        ]);

        $material = RawMaterial::findOrFail(
            $request->raw_material_id
        );

        RawMaterialEntry::create([

            'raw_material_id' => $material->id,

            'supplier' => $request->supplier,

            'quantity' => $request->quantity,

            'observation' => $request->observation,

            'user_id' => auth()->id(),

        ]);

        // Actualizar stock

        $material->stock += $request->quantity;

        // Actualizar estado

        if($material->stock <= 0){

            $material->status='AGOTADO';

        }
        elseif($material->stock <= $material->minimum_stock){

            $material->status='STOCK_BAJO';

        }
        else{

            $material->status='DISPONIBLE';

        }

        $material->save();

        return redirect()

            ->route('raw-materials.index')

            ->with(
                'success',
                'Entrada registrada correctamente.'
            );

    }
}