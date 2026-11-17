<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\ProductionOrder;
use App\Models\ProductionOrderShift;
use App\Models\ProductionShiftWorker;
use App\Models\ProductionShiftPause;
use App\Models\ProductionTimeStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductionCenterController extends Controller
{
    public function index()
    {
        $orders = ProductionOrder::with(['product', 'rawMaterial', 'shifts.workers', 'shifts.pauses'])
            ->latest()
            ->get();

        return view('production_center.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('activo', true)->orderBy('nombre')->get();
        $materials = RawMaterial::orderBy('name')->get();
        $standards = ProductionTimeStandard::where('active', true)->get()->keyBy('product_id');

        return view('production_center.create', compact('products', 'materials', 'standards'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'raw_material_id' => ['required', 'exists:raw_materials,id'],
            'target_quantity' => ['required', 'numeric', 'min:0.01'],
            'consumed_quantity' => ['required', 'numeric', 'min:0.01'],
            'standard_time_seconds' => ['required', 'numeric', 'gt:0'],
            'observation' => ['nullable', 'string', 'max:2000'],
            'workers' => ['required', 'array', 'min:1'],
            'workers.*' => ['required', 'string', 'max:150'],
        ]);

        $now = now();
        $plannedSeconds = (int) ceil((float) $data['target_quantity'] * (float) $data['standard_time_seconds']);

        $order = DB::transaction(function () use ($data, $now, $plannedSeconds) {
            $lastId = (int) ProductionOrder::max('id') + 1;
            $number = 'OP' . str_pad((string) $lastId, 6, '0', STR_PAD_LEFT);

            $order = ProductionOrder::create([
                'number' => $number,
                'product_id' => $data['product_id'],
                'raw_material_id' => $data['raw_material_id'],
                'target_quantity' => $data['target_quantity'],
                'produced_quantity' => 0,
                'consumed_quantity' => $data['consumed_quantity'],
                'standard_time_seconds' => $data['standard_time_seconds'],
                'planned_duration_seconds' => $plannedSeconds,
                'actual_duration_seconds' => 0,
                'observation' => $data['observation'] ?? null,
                'user_id' => auth()->id(),
                'status' => 'EN_PRODUCCION',
                'started_at' => $now,
            ]);

            $shift = $order->shifts()->create([
                'shift_number' => 1,
                'status' => 'EN_CURSO',
                'started_at' => $now,
                'started_by' => auth()->id(),
            ]);

            foreach ($data['workers'] as $name) {
                $name = trim($name);
                if ($name !== '') {
                    $shift->workers()->create(['name' => $name]);
                }
            }

            if ($shift->workers()->count() === 0) {
                throw ValidationException::withMessages([
                    'workers' => 'Agrega al menos una persona a la línea de producción.',
                ]);
            }

            return $order;
        });

        return redirect()->route('production-center.show', $order)
            ->with('success', 'Orden creada y primera jornada iniciada.');
    }

    public function show(ProductionOrder $production_order)
    {
        $production_order->load([
            'product', 'rawMaterial', 'user',
            'shifts.workers', 'shifts.pauses',
        ]);

        $activeShift = $production_order->shifts->firstWhere('status', 'EN_CURSO');
        $completedQuantity = (float) $production_order->shifts
            ->where('status', 'FINALIZADA')->sum('produced_quantity');

        return view('production_center.show', compact(
            'production_order', 'activeShift', 'completedQuantity'
        ));
    }

    public function startShift(Request $request, ProductionOrder $production_order)
    {
        $data = $request->validate([
            'workers' => ['required', 'array', 'min:1'],
            'workers.*' => ['required', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($production_order->status === 'FINALIZADA') {
            throw ValidationException::withMessages(['shift' => 'La orden ya está finalizada.']);
        }

        DB::transaction(function () use ($production_order, $data) {
            $lockedOrder = ProductionOrder::whereKey($production_order->id)->lockForUpdate()->firstOrFail();

            if ($lockedOrder->shifts()->where('status', 'EN_CURSO')->exists()) {
                throw ValidationException::withMessages(['shift' => 'Ya existe una jornada abierta para esta orden.']);
            }

            $number = ((int) $lockedOrder->shifts()->max('shift_number')) + 1;
            $shift = $lockedOrder->shifts()->create([
                'shift_number' => $number,
                'status' => 'EN_CURSO',
                'started_at' => now(),
                'started_by' => auth()->id(),
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['workers'] as $name) {
                $name = trim($name);
                if ($name !== '') $shift->workers()->create(['name' => $name]);
            }

            if (!$shift->workers()->exists()) {
                throw ValidationException::withMessages(['workers' => 'Agrega al menos una persona.']);
            }
        });

        return back()->with('success', 'Nueva jornada iniciada.');
    }

    public function pauseShift(Request $request, ProductionOrderShift $shift)
    {
        DB::transaction(function () use ($shift, $request) {
            $shift = ProductionOrderShift::whereKey($shift->id)->lockForUpdate()->firstOrFail();

            if ($shift->status !== 'EN_CURSO' || $shift->pauses()->whereNull('resumed_at')->exists()) {
                throw ValidationException::withMessages(['shift' => 'No se puede pausar esta jornada.']);
            }

            $shift->pauses()->create([
                'paused_at' => now(),
                'reason' => $request->input('reason'),
            ]);
        });

        return back()->with('success', 'Jornada pausada. El tiempo efectivo quedó detenido.');
    }

    public function resumeShift(ProductionOrderShift $shift)
    {
        DB::transaction(function () use ($shift) {
            $shift = ProductionOrderShift::whereKey($shift->id)->lockForUpdate()->firstOrFail();
            $pause = $shift->pauses()->whereNull('resumed_at')->latest('paused_at')->first();

            if ($shift->status !== 'EN_CURSO' || !$pause) {
                throw ValidationException::withMessages(['shift' => 'No existe una pausa abierta para reanudar.']);
            }

            $pause->update(['resumed_at' => now()]);
        });

        return back()->with('success', 'Jornada reanudada.');
    }

    public function closeShift(Request $request, ProductionOrderShift $shift)
    {
        $data = $request->validate([
            'produced_quantity' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($shift, $data) {
            $shift = ProductionOrderShift::with('pauses')->whereKey($shift->id)->lockForUpdate()->firstOrFail();

            if ($shift->status !== 'EN_CURSO') {
                throw ValidationException::withMessages(['shift' => 'La jornada ya está cerrada.']);
            }

            $openPause = $shift->pauses->firstWhere('resumed_at', null);
            if ($openPause) {
                throw ValidationException::withMessages(['shift' => 'Reanuda o cierra la pausa antes de cerrar la jornada.']);
            }

            $end = now();
            $elapsed = $shift->started_at->diffInSeconds($end);
            $paused = $shift->pauses->sum(function ($pause) {
                return $pause->paused_at->diffInSeconds($pause->resumed_at);
            });
            $effective = max(0, $elapsed - $paused);

            $shift->update([
                'status' => 'FINALIZADA',
                'ended_at' => $end,
                'produced_quantity' => $data['produced_quantity'],
                'actual_duration_seconds' => $effective,
                'notes' => $data['notes'] ?? $shift->notes,
                'closed_by' => auth()->id(),
            ]);

            $order = $shift->productionOrder;
            $order->actual_duration_seconds = (int) $order->shifts()
                ->where('status', 'FINALIZADA')->sum('actual_duration_seconds');
            $order->produced_quantity = (float) $order->shifts()
                ->where('status', 'FINALIZADA')->sum('produced_quantity');
            $order->save();
        });

        return back()->with('success', 'Jornada cerrada y sus resultados guardados. La orden sigue abierta.');
    }

    public function finishOrder(ProductionOrder $production_order)
    {
        DB::transaction(function () use ($production_order) {
            $order = ProductionOrder::whereKey($production_order->id)->lockForUpdate()->firstOrFail();

            if ($order->status === 'FINALIZADA') {
                throw ValidationException::withMessages(['order' => 'La orden ya está finalizada.']);
            }

            if ($order->shifts()->where('status', 'EN_CURSO')->exists()) {
                throw ValidationException::withMessages(['order' => 'Primero debes cerrar la jornada que está en curso.']);
            }

            $actualProduced = (float) $order->shifts()
                ->where('status', 'FINALIZADA')->sum('produced_quantity');

            if ($actualProduced <= 0) {
                throw ValidationException::withMessages(['order' => 'Registra la cantidad fabricada en al menos una jornada antes de finalizar.']);
            }

            $material = $order->rawMaterial()->lockForUpdate()->first();
            $product = $order->product()->lockForUpdate()->first();

            if (!$material || !$product) {
                throw ValidationException::withMessages(['order' => 'No se encontró el producto o la materia prima de esta orden.']);
            }

            if ((float) $material->stock < (float) $order->consumed_quantity) {
                throw ValidationException::withMessages(['inventory' => 'No hay suficiente materia prima para finalizar esta orden.']);
            }

            // Mantiene el comportamiento de inventario actual: el consumo de MP
            // se descuenta al finalizar y el producto terminado aumenta con la suma real.
            $material->stock = (float) $material->stock - (float) $order->consumed_quantity;
            if ($material->stock <= 0) {
                $material->status = 'AGOTADO';
            } elseif ($material->stock <= $material->minimum_stock) {
                $material->status = 'STOCK_BAJO';
            } else {
                $material->status = 'DISPONIBLE';
            }
            $material->save();

            $product->stock = (float) $product->stock + $actualProduced;
            $product->save();

            $order->produced_quantity = $actualProduced;
            $order->actual_duration_seconds = (int) $order->shifts()
                ->where('status', 'FINALIZADA')->sum('actual_duration_seconds');
            $order->status = 'FINALIZADA';
            $order->finished_at = now();
            $order->fecha_produccion = now();
            $order->save();
        });

        return redirect()->route('production-center.show', $production_order)
            ->with('success', 'Orden finalizada. El inventario se actualizó con la cantidad realmente fabricada.');
    }

    public function standards()
    {
        $products = Product::where('activo', true)->orderBy('nombre')->get();
        $standards = ProductionTimeStandard::with('product')->orderBy('product_id')->get();

        return view('production_center.standards', compact('products', 'standards'));
    }

    public function saveStandard(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'seconds_per_unit' => ['required', 'numeric', 'gt:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        ProductionTimeStandard::updateOrCreate(
            ['product_id' => $data['product_id']],
            [
                'seconds_per_unit' => $data['seconds_per_unit'],
                'notes' => $data['notes'] ?? null,
                'active' => true,
                'created_by' => auth()->id(),
            ]
        );

        return back()->with('success', 'Tiempo estándar guardado. Solo afectará a las órdenes nuevas.');
    }
}
