<?php

namespace App\Http\Controllers;

use App\Services\SupplyMaterialService;
use App\Models\SupplyOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SupplyOrderController extends Controller
{
   public function create()
{
    return view('supply-orders.create');
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
    public function store(Request $request)
{
    $request->validate([
        'planta' => 'required|string|max:255',
        'fecha_solicitud' => 'required|date',
        'fecha_requerida' => 'nullable|date',
        'lote' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string',

        'materiales' => 'required|array|min:1',

        'materiales.*.tipo' => 'required|in:LABEL,STICKER,PRECINTO,CAJA',
        'materiales.*.id' => 'required|integer|min:1',
        'materiales.*.cantidad' => 'required|numeric|min:0.01',
    ]);

    try {

        DB::beginTransaction();

        /*
        |--------------------------------------------------------------------------
        | Generar número de orden
        |--------------------------------------------------------------------------
        */

        $ultimaOrden = SupplyOrder::orderByDesc('id')->first();

        $siguienteNumero = $ultimaOrden
            ? $ultimaOrden->id + 1
            : 1;

        $numeroOrden = 'AB-' . str_pad(
            $siguienteNumero,
            6,
            '0',
            STR_PAD_LEFT
        );


        /*
        |--------------------------------------------------------------------------
        | Crear orden
        |--------------------------------------------------------------------------
        */

        $orden = SupplyOrder::create([
            'numero_orden' => $numeroOrden,
            'planta' => $request->planta,
            'fecha_solicitud' => $request->fecha_solicitud,
            'fecha_requerida' => $request->fecha_requerida,
            'lote' => $request->lote,
            'estado' => 'PENDIENTE',
            'observaciones' => $request->observaciones,
            'user_id' => auth()->id(),

            // Estos campos quedan sin utilizar porque
            // una orden puede contener varios productos.
            'product_id' => null,
            'cantidad_produccion' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Guardar materiales
        |--------------------------------------------------------------------------
        */

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
                "La orden {$numeroOrden} fue creada correctamente."
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
public function index(Request $request)
{
    $query = SupplyOrder::with([
        'items.dispatchItems'
    ]);

    // Buscar por número de orden o planta
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('numero_orden', 'ILIKE', "%{$search}%")
              ->orWhere('planta', 'ILIKE', "%{$search}%");
        });
    }

    // Filtro por estado
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // Filtro por planta
    if ($request->filled('planta')) {
        $query->where('planta', $request->planta);
    }

    // Filtro fecha desde
    if ($request->filled('fecha_desde')) {
        $query->whereDate(
            'fecha_solicitud',
            '>=',
            $request->fecha_desde
        );
    }

    // Filtro fecha hasta
    if ($request->filled('fecha_hasta')) {
        $query->whereDate(
            'fecha_solicitud',
            '<=',
            $request->fecha_hasta
        );
    }

    $ordenes = $query
        ->orderByDesc('id')
        ->paginate(15)
        ->withQueryString();


    // KPIs
    $pendientes = SupplyOrder::where('estado', 'PENDIENTE')->count();

    $parciales = SupplyOrder::where('estado', 'PARCIAL')->count();

    $completadas = SupplyOrder::where('estado', 'COMPLETADA')->count();

    $salidasHoy = \App\Models\SupplyDispatch::whereDate(
        'fecha_salida',
        today()
    )->count();


    // Plantas para el filtro
    $plantas = SupplyOrder::query()
        ->whereNotNull('planta')
        ->select('planta')
        ->distinct()
        ->orderBy('planta')
        ->pluck('planta');


    return view('supply-orders.index', compact(
        'ordenes',
        'pendientes',
        'parciales',
        'completadas',
        'salidasHoy',
        'plantas'
    ));
}
}