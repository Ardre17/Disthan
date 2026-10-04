<?php

namespace App\Http\Controllers;

use App\Services\SupplyMaterialService;
use App\Models\SupplyOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SupplyOrderController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'planta' => 'required|string|max:255',
        'fecha_solicitud' => 'required|date',
        'fecha_requerida' => 'nullable|date',
        'product_id' => 'nullable|exists:products,id',
        'cantidad_produccion' => 'nullable|numeric|min:0',
        'lote' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string',

        'materiales' => 'required|array|min:1',

        'materiales.*.tipo' => 'required|in:LABEL,STICKER,PRECINTO,CAJA',
        'materiales.*.id' => 'required|integer|min:1',
        'materiales.*.cantidad' => 'required|numeric|min:0.01',
    ]);

    DB::beginTransaction();

    try {

        // Generar número de orden
        $ultimaOrden = SupplyOrder::orderByDesc('id')->first();

        $numero = $ultimaOrden
            ? $ultimaOrden->id + 1
            : 1;

        $numeroOrden = 'AB-' . str_pad(
            $numero,
            6,
            '0',
            STR_PAD_LEFT
        );

        // Crear orden
        $orden = SupplyOrder::create([
            'numero_orden' => $numeroOrden,
            'planta' => $request->planta,
            'product_id' => $request->product_id,
            'cantidad_produccion' => $request->cantidad_produccion,
            'lote' => $request->lote,
            'fecha_solicitud' => $request->fecha_solicitud,
            'fecha_requerida' => $request->fecha_requerida,
            'estado' => 'PENDIENTE',
            'observaciones' => $request->observaciones,
            'user_id' => auth()->id(),
        ]);

        // Guardar materiales
        foreach ($request->materiales as $material) {

            $orden->items()->create([
                'tipo_material' => $material['tipo'],
                'material_id' => $material['id'],
                'cantidad_solicitada' => $material['cantidad'],
            ]);

        }

        DB::commit();

        return redirect()
            ->route('supply-orders.create')
            ->with(
                'success',
                "Orden {$numeroOrden} creada correctamente."
            );

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->withErrors([
                'error' => 'No se pudo crear la orden: ' . $e->getMessage()
            ]);
    }
}
    public function create()
{
    $products = \App\Models\Product::orderBy('nombre')->get();

    return view('supply-orders.create', compact('products'));
}

    public function materials(
        Request $request,
        SupplyMaterialService $materialService
    ) {
        $search = $request->input('search');

        $materials = $materialService->all($search);

        return response()->json([
            'success' => true,
            'data' => $materials,
        ]);
    }
}