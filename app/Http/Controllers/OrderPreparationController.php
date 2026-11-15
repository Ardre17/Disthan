<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class OrderPreparationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Bandeja de preparación
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::with('client')
            ->where('estado', '!=', 'COMPLETO')
            ->latest()
            ->get();

        return view('orders.preparation.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | Asistente de preparación
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        $order->load(['client', 'details.product']);
        $total = (float) $order->details->sum('cantidad_solicitada');
        $preparados = (float) $order->details->sum('cantidad_preparada');
        $progreso = $total > 0 ? round(($preparados / $total) * 100) : 0;

        $productoActual = $order->details()
            ->where('preparado', false)
            ->whereRaw('COALESCE(cantidad_preparada, 0) < COALESCE(cantidad_solicitada, 0)')
            ->with('product')->orderBy('orden_preparacion')->first();

        $numeroProducto = 0;
        if ($productoActual) {
            $numeroProducto = $order->details()
                ->where('orden_preparacion', '<=', $productoActual->orden_preparacion)->count();
        }

        return view('orders.preparation.show', compact(
            'order', 'productoActual', 'numeroProducto', 'total', 'preparados', 'progreso'
        ));
    }

    /** Avance de armado para polling desde las tres vistas de escritorio. */
    public function progress(Order $order)
    {
        $details = $order->details()->with('product')->get();
        $requested = (float) $details->sum('cantidad_solicitada');
        $prepared = (float) $details->sum('cantidad_preparada');

        return response()->json([
            'order_id' => $order->id,
            'requested' => $requested,
            'prepared' => $prepared,
            'pending' => max(0, $requested - $prepared),
            'percent' => $requested > 0 ? min(100, round(($prepared / $requested) * 100, 1)) : 0,
            'details' => $details->map(fn ($d) => [
                'id' => $d->id,
                'requested' => (float) $d->cantidad_solicitada,
                'prepared' => (float) ($d->cantidad_preparada ?? 0),
                'pending' => max(0, (float) $d->cantidad_solicitada - (float) ($d->cantidad_preparada ?? 0)),
            ])->values(),
        ]);
    }

    /** Guarda el total preparado indicado por el asistente de escritorio. */
    public function save(Request $request, OrderDetail $detail)
    {
        $data = $request->validate([
            'cantidad_preparada' => ['required', 'numeric', 'gte:0'],
            'observacion' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($detail, $data) {
            $locked = OrderDetail::query()->whereKey($detail->id)->lockForUpdate()->firstOrFail();
            $requested = (float) ($locked->cantidad_solicitada ?? 0);
            $before = (float) ($locked->cantidad_preparada ?? 0);
            $target = (float) $data['cantidad_preparada'];

            if ($target < $before - 0.000001 || $target > $requested + 0.000001) {
                throw ValidationException::withMessages([
                    'cantidad_preparada' => 'La cantidad preparada debe estar entre lo ya registrado y lo solicitado. No se permite reducir el acumulado desde esta pantalla.',
                ]);
            }

            $delta = max(0, $target - $before);
            $now = now();
            $complete = $requested > 0 && $target >= $requested - 0.000001;
            $changes = [
                'cantidad_preparada' => $target,
                'preparado' => $complete,
                'preparado_por' => Auth::id(),
                'fecha_preparacion' => $now,
                'observacion_preparacion' => $data['observacion'] ?? null,
            ];
            if (Schema::hasColumn('order_details', 'inicio_preparacion') && empty($locked->inicio_preparacion) && $delta > 0) {
                $changes['inicio_preparacion'] = $now;
            }
            if (Schema::hasColumn('order_details', 'fin_preparacion')) {
                $changes['fin_preparacion'] = $complete ? $now : null;
            }
            $locked->forceFill($changes)->save();

            if ($delta > 0 && Schema::hasTable('mobile_order_preparation_logs')) {
                DB::table('mobile_order_preparation_logs')->insert([
                    'order_detail_id' => $locked->id,
                    'quantity' => $delta,
                    'user_id' => Auth::id(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            if (Schema::hasTable('mobile_order_preparations')) {
                DB::table('mobile_order_preparations')->updateOrInsert(
                    ['order_detail_id' => $locked->id],
                    ['prepared_quantity' => $target, 'updated_by' => Auth::id(), 'updated_at' => $now, 'created_at' => $now]
                );
            }
        }, 3);

        return response()->json($this->obtenerSiguienteProducto($detail->order));
    }

    /*
    |--------------------------------------------------------------------------
    | Saltar producto
    |--------------------------------------------------------------------------
    */

    public function skip(OrderDetail $detail)
{
    $detail->update([
        'preparado' => true,
        'observacion_preparacion' => 'SALTADO'
    ]);

    return response()->json(
        $this->obtenerSiguienteProducto($detail->order)
    );
}

    /*
    |--------------------------------------------------------------------------
    | Producto no encontrado
    |--------------------------------------------------------------------------
    */

    public function notFound(OrderDetail $detail)
{
    $detail->update([
        'preparado' => true,
        'observacion_preparacion' => 'PRODUCTO NO ENCONTRADO'
    ]);

    return response()->json(
        $this->obtenerSiguienteProducto($detail->order)
    );
}

    /*
    |--------------------------------------------------------------------------
    | Finalizar pedido
    |--------------------------------------------------------------------------
    */

    public function finish(Order $order)
    {
        $order->estado_preparacion = 'ARMADO';

        $order->save();

        return response()->json([
            'success' => true
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener siguiente producto
    |--------------------------------------------------------------------------
    */

    private function obtenerSiguienteProducto(Order $order)
    {
        $siguiente = $order->details()
            ->where('preparado', false)
            ->with('product')
            ->orderBy('orden_preparacion')
            ->first();

        if (!$siguiente) {

            $order->estado_preparacion = 'ARMADO';
            $order->save();

            return [
                'finished' => true
            ];
        }

        return [

            'finished' => false,

            'next' => [

                'id' => $siguiente->id,

                'cantidad_solicitada' => $siguiente->cantidad_solicitada,

                'cantidad_preparada' => $siguiente->cantidad_preparada,

                'precio_unitario' => $siguiente->precio_unitario,

                'sku' => $siguiente->product->sku,

                'barcode' => $siguiente->product->barcode,

                'nombre' => $siguiente->product->nombre,

                'advertencias' => $siguiente->product->advertencias,

            ]

        ];
    }
}