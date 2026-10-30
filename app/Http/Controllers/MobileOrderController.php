<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MobileOrderController extends Controller
{
    public function home()
    {
        $pendingOrders = Order::whereNotIn(DB::raw('UPPER(COALESCE(estado, \'\'))'), ['COMPLETO', 'CANCELADO'])->count();
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
            $query->whereNotIn(DB::raw('UPPER(COALESCE(estado, \'\'))'), ['COMPLETO', 'CANCELADO']);
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
        $counts = Order::query()->selectRaw("UPPER(TRIM(COALESCE(estado, 'SIN ESTADO'))) as estado_normalizado, COUNT(*) as total")
            ->groupBy('estado_normalizado')->pluck('total', 'estado_normalizado');
        return view('mobile.orders.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['client', 'details.product', 'bultos.detalles.product', 'pallets.detalles.product']);
        $prepared = [];
        if (Schema::hasTable('mobile_order_preparations')) {
            $prepared = DB::table('mobile_order_preparations')->whereIn('order_detail_id', $order->details->pluck('id'))
                ->pluck('prepared_quantity', 'order_detail_id')->all();
        }
        return view('mobile.orders.show', compact('order', 'prepared'));
    }

    /** Registra el avance armado en una tabla separada, sin modificar despacho ni stock. */
    public function savePreparation(Request $request, Order $order, OrderDetail $detail)
    {
        abort_unless((int) $detail->order_id === (int) $order->id, 404);
        if (!Schema::hasTable('mobile_order_preparations')) {
            return back()->withErrors(['preparacion' => 'Falta ejecutar la migración de preparación móvil.']);
        }
        $data = $request->validate(['cantidad_armada' => ['required', 'numeric', 'gt:0']]);
        $solicitado = (float) ($detail->cantidad_solicitada ?? 0);
        DB::transaction(function () use ($detail, $data, $solicitado, $request) {
            $row = DB::table('mobile_order_preparations')->where('order_detail_id', $detail->id)->lockForUpdate()->first();
            $actual = (float) ($row->prepared_quantity ?? 0);
            $nuevo = $actual + (float) $data['cantidad_armada'];
            if ($nuevo > $solicitado) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cantidad_armada' => 'La cantidad armada acumulada no puede superar lo solicitado (' . $solicitado . '). Ya registrado: ' . $actual . '.',
                ]);
            }
            DB::table('mobile_order_preparations')->updateOrInsert(
                ['order_detail_id' => $detail->id],
                ['prepared_quantity' => $nuevo, 'updated_by' => auth()->id(), 'updated_at' => now(), 'created_at' => $row->created_at ?? now()]
            );
        });
        return redirect()->route('mobile.orders.show', $order)->with('success', 'Avance de armado guardado. No se modificó el despacho ni el stock.');
    }
}
