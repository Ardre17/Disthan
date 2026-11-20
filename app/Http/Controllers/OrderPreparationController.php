<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
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
                'dispatched' => (float) ($d->cantidad_despachada ?? 0),
                'pending' => max(0, (float) $d->cantidad_solicitada - (float) ($d->cantidad_preparada ?? 0)),
                'confirmed_at' => $d->informacion_confirmada_at,
                'confirmed_by' => $d->informacion_confirmada_por,
                'confirmed_lote' => $d->informacion_confirmada_lote,
                'confirmed_produccion' => $d->informacion_confirmada_produccion,
                'confirmed_vencimiento' => $d->informacion_confirmada_vencimiento,
                'migrated_at' => $d->informacion_migrada_at ?? null,
                'confirmed_user' => $d->informacion_confirmada_por ? DB::table('users')->where('id', $d->informacion_confirmada_por)->value('name') : null,
                'prepared_by' => $d->preparado_por,
                'prepared_user' => $d->preparado_por ? DB::table('users')->where('id', $d->preparado_por)->value('name') : null,
                'prepared_at' => $d->fecha_preparacion,
            ])->values(),
        ]);
    }

    /** Confirma que lote y fechas del detalle fueron revisados tras completar el armado. */
    public function confirmInformation(OrderDetail $detail)
    {
        $result = DB::transaction(function () use ($detail) {
            $locked = OrderDetail::query()->with('product')->whereKey($detail->id)->lockForUpdate()->firstOrFail();
            $requested = (float) ($locked->cantidad_solicitada ?? 0);
            $prepared = (float) ($locked->cantidad_preparada ?? 0);

            if ($requested <= 0 || $prepared + 0.000001 < $requested) {
                throw ValidationException::withMessages([
                    'confirmacion' => 'No se puede confirmar: el producto todavía no tiene el 100 % del armado registrado.',
                ]);
            }

            $lote = $locked->lote ?: ($locked->product?->lote ?? null);
            $produccion = $locked->fecha_produccion ?: ($locked->product?->fecha_produccion ?? null);
            $vencimiento = $locked->fecha_vencimiento ?: ($locked->product?->fecha_vencimiento ?? null);
            $now = now();

            $locked->forceFill([
                'informacion_confirmada_at' => $now,
                'informacion_confirmada_por' => Auth::id(),
                'informacion_confirmada_lote' => $lote,
                'informacion_confirmada_produccion' => $produccion,
                'informacion_confirmada_vencimiento' => $vencimiento,
                'informacion_confirmada_preparado_por' => $locked->preparado_por,
            ])->save();

            return [
                'success' => true,
                'confirmed_at' => $now->toIso8601String(),
                'confirmed_by' => Auth::id(),
                'confirmed_user' => Auth::user()?->name,
                'prepared_by' => $locked->preparado_por,
                'prepared_user' => $locked->preparado_por ? DB::table('users')->where('id', $locked->preparado_por)->value('name') : null,
                'prepared_at' => $locked->fecha_preparacion,
                'lote' => $lote,
                'fecha_produccion' => $produccion,
                'fecha_vencimiento' => $vencimiento,
            ];
        }, 3);

        return response()->json($result);
    }

    /**
     * Migra la información confirmada y registra el despacho de la cantidad realmente preparada.
     * Replica las reglas de stock, subtotal y estado utilizadas por updateDetail().
     */
    public function migrateConfirmedInformation(OrderDetail $detail)
    {
        $result = DB::transaction(function () use ($detail) {
            $locked = OrderDetail::query()->whereKey($detail->id)->lockForUpdate()->firstOrFail();

            if (!$locked->informacion_confirmada_at) {
                throw ValidationException::withMessages([
                    'confirmacion' => 'Primero debes confirmar el lote y las fechas del producto.',
                ]);
            }

            $requested = (float) ($locked->cantidad_solicitada ?? 0);
            $prepared = (float) ($locked->cantidad_preparada ?? 0);
            $dispatchedBefore = (float) ($locked->cantidad_despachada ?? 0);

            if ($requested <= 0 || $prepared <= 0 || $prepared > $requested + 0.000001) {
                throw ValidationException::withMessages([
                    'cantidad_preparada' => 'La cantidad preparada debe ser mayor que cero y no puede superar la cantidad solicitada.',
                ]);
            }

            if ($prepared + 0.000001 < $requested) {
                throw ValidationException::withMessages([
                    'cantidad_preparada' => 'El producto debe estar armado al 100 % antes de migrar la confirmación.',
                ]);
            }

            $product = Product::query()->whereKey($locked->product_id)->lockForUpdate()->firstOrFail();
            $delta = $prepared - $dispatchedBefore;
            $stock = (float) ($product->stock ?? 0);

            if ($delta > 0 && $stock < $delta) {
                throw ValidationException::withMessages([
                    'cantidad_despachada' => 'Stock insuficiente. Disponible: ' . $stock . ' | Requerido adicional: ' . $delta,
                ]);
            }

            // Aplicar únicamente la diferencia para evitar descontar dos veces si se reintenta.
            if ($delta > 0) {
                $product->stock = $stock - $delta;
                $product->save();
            } elseif ($delta < 0) {
                $product->stock = $stock + abs($delta);
                $product->save();
            }

            $estadoItem = $prepared <= 0
                ? 'INCOMPLETO'
                : ($prepared + 0.000001 < $requested ? 'PARCIAL' : 'COMPLETO');
            $migratedAt = now();

            $locked->forceFill([
                'lote' => $locked->informacion_confirmada_lote,
                'fecha_produccion' => $locked->informacion_confirmada_produccion,
                'fecha_vencimiento' => $locked->informacion_confirmada_vencimiento,
                'cantidad_despachada' => $prepared,
                'despacho_confirmado' => true,
                'subtotal' => round($prepared * (float) ($locked->precio_unitario ?? 0), 2),
                'estado_item' => $estadoItem,
                // El operario que armó se conserva desde el registro de preparación.
                'preparado_por' => $locked->informacion_confirmada_preparado_por ?? $locked->preparado_por,
                'informacion_migrada_at' => $migratedAt,
                'informacion_migrada_por' => Auth::id(),
            ])->save();

            $order = Order::query()->whereKey($locked->order_id)->lockForUpdate()->firstOrFail();
            $items = $order->details()->get();
            $order->subtotal = (float) $items->sum('subtotal');
            $order->igv = round($order->subtotal * 0.18, 2);
            $order->total = $order->subtotal + $order->igv;

            if ($order->tipo_orden != 'ENCOMIENDA') {
                $totalRequested = (float) $items->sum('cantidad_solicitada');
                $totalDispatched = (float) $items->sum('cantidad_despachada');
                $previousStatus = $order->estado;

                if ($totalDispatched <= 0) {
                    $order->estado = 'INCOMPLETO';
                } elseif ($totalDispatched + 0.000001 >= $totalRequested) {
                    $order->estado = 'COMPLETO';
                } else {
                    $order->estado = 'PARCIAL';
                }

                if ($order->estado === 'COMPLETO' && $previousStatus !== 'COMPLETO') {
                    $order->fecha_cierre = now();
                } elseif ($order->estado !== 'COMPLETO' && $previousStatus === 'COMPLETO') {
                    $order->fecha_cierre = null;
                }
            }

            $order->save();

            return [
                'success' => true,
                'cantidad_despachada' => $prepared,
                'subtotal' => round($prepared * (float) ($locked->precio_unitario ?? 0), 2),
                'estado_item' => $estadoItem,
                'stock' => (float) $product->fresh()->stock,
                'preparado_por' => $locked->preparado_por,
                'lote' => $locked->lote,
                'fecha_produccion' => $locked->fecha_produccion,
                'fecha_vencimiento' => $locked->fecha_vencimiento,
                'migrated_at' => $migratedAt->toIso8601String(),
            ];
        }, 3);

        return response()->json($result);
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