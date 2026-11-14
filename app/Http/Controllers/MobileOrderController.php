<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class MobileOrderController extends Controller
{
    public function home()
    {
        $pendingOrders = Order::whereNotIn(DB::raw("UPPER(COALESCE(estado, ''))"), ['COMPLETO', 'CANCELADO'])->count();
        return view('mobile.home', compact('pendingOrders'));
    }

    public function index(Request $request)
    {
        $query = Order::query()->with('client')->withCount('details');

        if ($request->filled('tipo') && $request->tipo !== 'TODOS') {
            $query->whereRaw('UPPER(TRIM(tipo_orden)) = ?', [strtoupper(trim($request->tipo))]);
        }
        if ($request->filled('estado') && $request->estado !== 'TODOS') {
            $query->whereRaw('UPPER(TRIM(estado)) = ?', [strtoupper(trim($request->estado))]);
        } elseif (!$request->boolean('incluir_completos')) {
            $query->whereNotIn(DB::raw("UPPER(COALESCE(estado, ''))"), ['COMPLETO', 'CANCELADO']);
        }
        if ($request->filled('q')) {
            $term = trim($request->q);
            $query->where(function ($q) use ($term) {
                $q->where('numero_orden', 'like', "%{$term}%")
                    ->orWhere('order_interna', 'like', "%{$term}%")
                    ->orWhereHas('client', fn ($client) => $client->where('razon_social', 'like', "%{$term}%"));
            });
        }

        $orders = $query->orderByDesc('fecha_pedido')->orderByDesc('id')->paginate(20)->withQueryString();
        $counts = Order::query()
            ->selectRaw("UPPER(TRIM(COALESCE(estado, 'SIN ESTADO'))) as estado_normalizado, COUNT(*) as total")
            ->groupBy('estado_normalizado')->pluck('total', 'estado_normalizado');

        return view('mobile.orders.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['client', 'details.product', 'bultos.detalles.product', 'pallets.detalles.product']);
        $detailIds = $order->details->pluck('id');
        $prepared = [];
        $preparationMeta = [];
        $preparationLogs = [];

        if (Schema::hasTable('mobile_order_preparations')) {
            $preparedRows = DB::table('mobile_order_preparations')
                ->whereIn('order_detail_id', $detailIds)
                ->get();

            foreach ($preparedRows as $row) {
                $prepared[$row->order_detail_id] = (float) $row->prepared_quantity;
                $preparationMeta[$row->order_detail_id] = $row;
            }
        }

        if (Schema::hasTable('mobile_order_preparation_logs')) {
            $preparationLogs = DB::table('mobile_order_preparation_logs as logs')
                ->leftJoin('users', 'users.id', '=', 'logs.user_id')
                ->whereIn('logs.order_detail_id', $detailIds)
                ->orderByDesc('logs.created_at')
                ->select('logs.*', 'users.name as user_name')
                ->get()
                ->groupBy('order_detail_id');
        }

        $userNames = [];
        if (Schema::hasTable('users')) {
            $userIds = collect($preparationMeta)->pluck('updated_by')->filter()->unique();
            if ($userIds->isNotEmpty()) {
                $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name', 'id')->all();
            }
        }

        return view('mobile.orders.show', compact('order', 'prepared', 'preparationMeta', 'preparationLogs', 'userNames'));
    }

    /** Registra un avance acumulado y un evento histórico. No modifica despacho ni stock. */
    public function savePreparation(Request $request, Order $order, OrderDetail $detail)
    {
        abort_unless((int) $detail->order_id === (int) $order->id, 404);

        if (!Schema::hasTable('mobile_order_preparations')) {
            return back()->withErrors(['preparacion' => 'Falta ejecutar la migración de preparación móvil.']);
        }

        $data = $request->validate([
            'cantidad_armada' => ['required', 'numeric', 'gt:0'],
        ]);

        $solicitado = (float) ($detail->cantidad_solicitada ?? 0);
        $stockDisponible = (float) ($detail->product?->stock ?? 0);
        $limiteArmable = min($solicitado, $stockDisponible);

        if ($stockDisponible <= 0) {
            throw ValidationException::withMessages([
                'cantidad_armada' => 'Este producto no tiene stock disponible. Consulta con el encargado antes de continuar con el armado.',
            ]);
        }

        DB::transaction(function () use ($detail, $data, $solicitado, $limiteArmable) {
            $row = DB::table('mobile_order_preparations')
                ->where('order_detail_id', $detail->id)
                ->lockForUpdate()
                ->first();

            $actual = (float) ($row->prepared_quantity ?? 0);
            $cantidadNueva = (float) $data['cantidad_armada'];
            $nuevo = $actual + $cantidadNueva;

            if ($nuevo > $solicitado + 0.000001) {
                throw ValidationException::withMessages([
                    'cantidad_armada' => 'La cantidad armada acumulada no puede superar lo solicitado (' . $solicitado . '). Ya registrado: ' . $actual . '.',
                ]);
            }
            if ($nuevo > $limiteArmable + 0.000001) {
                throw ValidationException::withMessages([
                    'cantidad_armada' => 'El avance acumulado supera el stock disponible para este producto. Stock considerado: ' . $limiteArmable . '.',
                ]);
            }

            DB::table('mobile_order_preparations')->updateOrInsert(
                ['order_detail_id' => $detail->id],
                [
                    'prepared_quantity' => $nuevo,
                    'updated_by' => auth()->id(),
                    'updated_at' => now(),
                    'created_at' => $row->created_at ?? now(),
                ]
            );

            if (Schema::hasTable('mobile_order_preparation_logs')) {
                DB::table('mobile_order_preparation_logs')->insert([
                    'order_detail_id' => $detail->id,
                    'quantity' => $cantidadNueva,
                    'user_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('mobile.orders.show', $order)
            ->with('success', 'Avance de armado guardado y registrado en el historial. No se modificó el despacho ni el stock.');
    }
}
