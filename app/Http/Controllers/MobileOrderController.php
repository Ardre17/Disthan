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

    /**
     * La fuente compartida del avance de armado es order_details.cantidad_preparada.
     * mobile_order_preparations solo se consulta temporalmente para no perder avances
     * registrados antes de esta sincronización.
     */
    public function show(Order $order)
    {
        $order->load(['client', 'details.product', 'bultos.detalles.product', 'pallets.detalles.product']);

        $detailIds = $order->details->pluck('id');
        $prepared = [];
        $preparationMeta = [];
        $preparationLogs = collect();

        foreach ($order->details as $detail) {
            $cantidadPreparada = Schema::hasColumn('order_details', 'cantidad_preparada')
                ? (float) ($detail->cantidad_preparada ?? 0)
                : 0;

            $prepared[$detail->id] = $cantidadPreparada;
            $preparationMeta[$detail->id] = (object) [
                'updated_by' => $detail->preparado_por ?? null,
                'updated_at' => $detail->fecha_preparacion ?? null,
            ];
        }

        // Compatibilidad temporal: compara el acumulado móvil anterior sin sobrescribir
        // un avance mayor que ya exista en order_details.
        if (Schema::hasTable('mobile_order_preparations') && $detailIds->isNotEmpty()) {
            $legacyRows = DB::table('mobile_order_preparations')
                ->whereIn('order_detail_id', $detailIds)
                ->get()
                ->keyBy('order_detail_id');

            foreach ($legacyRows as $detailId => $legacy) {
                $legacyQty = (float) ($legacy->prepared_quantity ?? 0);
                $prepared[$detailId] = max((float) ($prepared[$detailId] ?? 0), $legacyQty);

                if (empty($preparationMeta[$detailId]->updated_by) && !empty($legacy->updated_by)) {
                    $preparationMeta[$detailId] = (object) [
                        'updated_by' => $legacy->updated_by,
                        'updated_at' => $legacy->updated_at ?? null,
                    ];
                }
            }
        }

        if (Schema::hasTable('mobile_order_preparation_logs') && $detailIds->isNotEmpty()) {
            $preparationLogs = DB::table('mobile_order_preparation_logs as logs')
                ->leftJoin('users', 'users.id', '=', 'logs.user_id')
                ->whereIn('logs.order_detail_id', $detailIds)
                ->orderByDesc('logs.created_at')
                ->select('logs.*', 'users.name as user_name')
                ->get()
                ->groupBy('order_detail_id');
        }

        $userIds = collect($preparationMeta)
            ->pluck('updated_by')
            ->filter(fn ($id) => is_numeric($id))
            ->unique()
            ->values();

        if ($preparationLogs->isNotEmpty()) {
            $logUserIds = $preparationLogs->flatten(1)->pluck('user_id')->filter()->unique();
            $userIds = $userIds->merge($logUserIds)->unique()->values();
        }

        $userNames = $userIds->isNotEmpty() && Schema::hasTable('users')
            ? DB::table('users')->whereIn('id', $userIds)->pluck('name', 'id')->all()
            : [];

        return view('mobile.orders.show', compact('order', 'prepared', 'preparationMeta', 'preparationLogs', 'userNames'));
    }

    /**
     * Registra el armado en order_details.cantidad_preparada, que es el campo
     * compartido con la preparación de escritorio. No modifica despacho ni stock.
     */
    public function savePreparation(Request $request, Order $order, OrderDetail $detail)
    {
        abort_unless((int) $detail->order_id === (int) $order->id, 404);

        if (!Schema::hasColumn('order_details', 'cantidad_preparada')) {
            return back()->withErrors([
                'preparacion' => 'La columna order_details.cantidad_preparada no existe. Verifica la estructura de la tabla antes de continuar.',
            ]);
        }

        $data = $request->validate([
            'cantidad_armada' => ['required', 'numeric', 'gt:0'],
        ]);

        DB::transaction(function () use ($detail, $data) {
            /** @var OrderDetail $lockedDetail */
            $lockedDetail = OrderDetail::query()
                ->whereKey($detail->id)
                ->lockForUpdate()
                ->firstOrFail();

            $solicitado = (float) ($lockedDetail->cantidad_solicitada ?? 0);
            $actual = (float) ($lockedDetail->cantidad_preparada ?? 0);
            $cantidadNueva = (float) $data['cantidad_armada'];
            $nuevo = $actual + $cantidadNueva;

            if ($nuevo > $solicitado + 0.000001) {
                throw ValidationException::withMessages([
                    'cantidad_armada' => 'La cantidad armada acumulada no puede superar lo solicitado (' . $solicitado . '). Ya registrado: ' . $actual . '.',
                ]);
            }

            $stock = (float) (DB::table('products')->where('id', $lockedDetail->product_id)->lockForUpdate()->value('stock') ?? 0);
            if ($stock <= 0 || $nuevo > $stock + 0.000001) {
                throw ValidationException::withMessages([
                    'cantidad_armada' => 'El avance acumulado supera el stock disponible para armado. Stock actual: ' . $stock . '. Consulta con el encargado si existe producto disponible.',
                ]);
            }

            $ahora = now();
            $completo = $solicitado > 0 && $nuevo >= $solicitado;
            $update = ['cantidad_preparada' => $nuevo];

            if (Schema::hasColumn('order_details', 'preparado')) {
                $tipoPreparado = Schema::getColumnType('order_details', 'preparado');
                if (in_array($tipoPreparado, ['boolean', 'integer', 'bigint', 'smallint'], true)) {
                    $update['preparado'] = $completo;
                }
            }
            if (Schema::hasColumn('order_details', 'preparado_por')) {
                $tipoResponsable = Schema::getColumnType('order_details', 'preparado_por');
                $update['preparado_por'] = in_array($tipoResponsable, ['integer', 'bigint', 'smallint'], true)
                    ? auth()->id()
                    : (auth()->user()->name ?? 'Usuario #' . auth()->id());
            }
            if (Schema::hasColumn('order_details', 'fecha_preparacion')) {
                $update['fecha_preparacion'] = $ahora;
            }
            if (Schema::hasColumn('order_details', 'inicio_preparacion') && empty($lockedDetail->inicio_preparacion)) {
                $update['inicio_preparacion'] = $ahora;
            }
            if (Schema::hasColumn('order_details', 'fin_preparacion')) {
                $update['fin_preparacion'] = $completo ? $ahora : null;
            }

            // Solo se actualizan campos de preparación; cantidad_despachada y stock no se tocan.
            $lockedDetail->forceFill($update)->save();

            if (Schema::hasTable('mobile_order_preparation_logs')) {
                DB::table('mobile_order_preparation_logs')->insert([
                    'order_detail_id' => $lockedDetail->id,
                    'quantity' => $cantidadNueva,
                    'user_id' => auth()->id(),
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ]);
            }

            // Mantener la tabla móvil antigua como espejo temporal, por compatibilidad.
            if (Schema::hasTable('mobile_order_preparations')) {
                DB::table('mobile_order_preparations')->updateOrInsert(
                    ['order_detail_id' => $lockedDetail->id],
                    [
                        'prepared_quantity' => $nuevo,
                        'updated_by' => auth()->id(),
                        'updated_at' => $ahora,
                        'created_at' => $ahora,
                    ]
                );
            }
        });

        return redirect()->route('mobile.orders.show', $order)
            ->with('success', 'Armado sincronizado con la vista de escritorio. El despacho y el stock no fueron modificados.');
    }
}
