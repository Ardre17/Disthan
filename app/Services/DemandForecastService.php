<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductForecastSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DemandForecastService
{
    /**
     * Proyecta demanda con 180 días de historial usando cantidades realmente
     * despachadas: en DISTAN una orden COMPLETO puede cerrarse aunque algunos
     * productos solicitados finalmente no hayan salido.
     */
    public function products(?string $search = null, ?int $categoryId = null)
    {
        $today = Carbon::today();
        $recentStart = $today->copy()->subDays(27)->startOfDay();
        $historyStart = $today->copy()->subDays(179)->startOfDay();
        $recentEnd = $today->copy()->endOfDay();
        $historyEnd = $recentStart->copy()->subSecond();

        $products = Product::query()
            ->with(['category', 'forecastSetting'])
            ->where('activo', true)
            ->when($search, fn ($q) => $q->where(function ($w) use ($search) {
                $term = '%' . mb_strtolower($search) . '%';
                $w->whereRaw('LOWER(nombre) LIKE ?', [$term])
                    ->orWhereRaw("LOWER(COALESCE(sku, '')) LIKE ?", [$term]);
            }))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderBy('nombre')
            ->get();

        $productIds = $products->pluck('id');

        $historicalOrders = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->whereIn('od.product_id', $productIds)
            ->whereNotIn(DB::raw("UPPER(COALESCE(o.estado, ''))"), [
                'ANULADO', 'ANULADA', 'CANCELADO', 'CANCELADA', 'ELIMINADO',
            ])
            ->whereBetween('o.fecha_pedido', [$historyStart, $recentEnd]);

        // Demanda histórica real: cantidad despachada, no cantidad solicitada.
        $recent = (clone $historicalOrders)
            ->whereBetween('o.fecha_pedido', [$recentStart, $recentEnd])
            ->select('od.product_id', DB::raw('SUM(COALESCE(od.cantidad_despachada, 0)) as qty'))
            ->groupBy('od.product_id')
            ->pluck('qty', 'product_id');

        $previous = (clone $historicalOrders)
            ->whereBetween('o.fecha_pedido', [$historyStart, $historyEnd])
            ->select('od.product_id', DB::raw('SUM(COALESCE(od.cantidad_despachada, 0)) as qty'))
            ->groupBy('od.product_id')
            ->pluck('qty', 'product_id');

        // Compromisos futuros: únicamente órdenes todavía abiertas.
        $openPending = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->whereIn('od.product_id', $productIds)
            ->whereIn(DB::raw("UPPER(COALESCE(o.estado, ''))"), ['PARCIAL', 'INCOMPLETO'])
            ->select('od.product_id', DB::raw(
                'SUM(GREATEST(COALESCE(od.cantidad_solicitada, 0) - COALESCE(od.cantidad_despachada, 0), 0)) as pending'
            ))
            ->groupBy('od.product_id')
            ->pluck('pending', 'product_id');

        $production = DB::table('production_orders')
            ->whereIn('product_id', $productIds)
            ->where('status', 'EN_PRODUCCION')
            ->select('product_id', DB::raw('SUM(COALESCE(produced_quantity, 0)) as qty'))
            ->groupBy('product_id')
            ->pluck('qty', 'product_id');

        return $products->map(function (Product $product) use ($recent, $previous, $openPending, $production) {
            $recentDaily = (float) ($recent[$product->id] ?? 0) / 28;
            $previousDaily = (float) ($previous[$product->id] ?? 0) / 152;
            $daily = ($recentDaily * 0.60) + ($previousDaily * 0.40);

            $setting = $product->forecastSetting;
            $lead = (int) ($setting->lead_time_days ?? 3);
            $safety = (int) ($setting->safety_days ?? 3);
            $coverage = (int) ($setting->coverage_days ?? 15);
            $stock = (float) ($product->stock ?? 0);
            $pending = (float) ($openPending[$product->id] ?? 0);
            $inProduction = (float) ($production[$product->id] ?? 0);

            $securityStock = $daily * $safety;
            $calculatedMinimum = ($daily * $lead) + $securityStock;
            $approvedMinimum = $setting?->approved_min_stock !== null
                ? (float) $setting->approved_min_stock
                : null;
            $minimumToUse = $approvedMinimum ?? $calculatedMinimum;
            $availableStock = max(0, $stock - $pending);
            $coverageTarget = ($daily * $coverage) + $securityStock;
            $targetStock = max($coverageTarget, $minimumToUse);
            $toProduce = max(0, $targetStock - $availableStock);

            $product->forecast = [
                'recent_daily' => round($recentDaily, 2),
                'historical_daily' => round($previousDaily, 2),
                'daily_demand' => round($daily, 2),
                'demand_7d' => round($daily * 7, 2),
                'demand_15d' => round($daily * 15, 2),
                'demand_30d' => round($daily * 30, 2),
                'stock' => round($stock, 2),
                'pending' => round($pending, 2),
                'available_stock' => round($availableStock, 2),
                'in_production' => round($inProduction, 2),
                'security_stock' => round($securityStock, 2),
                'recommended_minimum' => round($calculatedMinimum, 2),
                'approved_minimum' => $approvedMinimum,
                'minimum_to_use' => round($minimumToUse, 2),
                'target_stock' => round($targetStock, 2),
                'coverage_days' => $daily > 0 ? round($stock / $daily, 1) : null,
                'to_produce' => round($toProduce, 2),
                'lead_time_days' => $lead,
                'safety_days' => $safety,
                'coverage_target_days' => $coverage,
                'has_history' => ($recentDaily + $previousDaily) > 0,
            ];

            return $product;
        });
    }

    /**
     * Resumen de clientes SUPERMERCADO y comportamiento por producto.
     * Usa cantidades despachadas para estimar consumo habitual y mantiene
     * los saldos de órdenes abiertas en un bloque separado.
     */
    public function supermarkets()
    {
        $today = Carbon::today();
        $historyStart = $today->copy()->subDays(179)->startOfDay();

        $orders = Order::query()
            ->with(['client', 'details.product'])
            ->whereRaw("UPPER(COALESCE(tipo_orden, '')) = ?", ['SUPERMERCADO'])
            ->whereNotIn(DB::raw("UPPER(COALESCE(estado, ''))"), [
                'ANULADO', 'ANULADA', 'CANCELADO', 'CANCELADA', 'ELIMINADO',
            ])
            ->whereDate('fecha_pedido', '>=', $historyStart->toDateString())
            ->orderBy('fecha_pedido')
            ->get();

        // Solo estas órdenes mantienen compromisos de preparación/despacho.
        $openOrders = Order::query()
            ->with(['client', 'details.product'])
            ->whereRaw("UPPER(COALESCE(tipo_orden, '')) = ?", ['SUPERMERCADO'])
            ->whereIn(DB::raw("UPPER(COALESCE(estado, ''))"), ['PARCIAL', 'INCOMPLETO'])
            ->get();

        $clientIds = $orders->pluck('client_id')
            ->merge($openOrders->pluck('client_id'))
            ->filter()->unique()->values();

        $clients = $clientIds->map(function ($clientId) use ($orders, $openOrders, $today) {
            $clientOrders = $orders->where('client_id', $clientId)->sortBy('fecha_pedido')->values();
            $clientOpenOrders = $openOrders->where('client_id', $clientId)->values();
            $client = $clientOrders->first()?->client ?? $clientOpenOrders->first()?->client;

            // Frecuencia general del cliente: días entre fechas distintas de pedido.
            $distinctDates = $clientOrders
                ->map(fn ($order) => Carbon::parse($order->fecha_pedido)->toDateString())
                ->unique()->sort()->values();
            $intervals = [];
            for ($i = 1; $i < $distinctDates->count(); $i++) {
                $intervals[] = Carbon::parse($distinctDates[$i - 1])->diffInDays(Carbon::parse($distinctDates[$i]));
            }
            $averageInterval = count($intervals) ? array_sum($intervals) / count($intervals) : null;
            $lastOrderDate = $distinctDates->last() ? Carbon::parse($distinctDates->last())->startOfDay() : null;
            $nextDate = ($lastOrderDate && $averageInterval !== null)
                ? $lastOrderDate->copy()->addDays((int) round($averageInterval))
                : null;

            // Historial por producto: solo unidades efectivamente despachadas.
            $productGroups = [];
            $totalDispatched = 0.0;
            foreach ($clientOrders as $order) {
                foreach ($order->details as $detail) {
                    $qty = (float) ($detail->cantidad_despachada ?? 0);
                    if (!$detail->product) continue;
                    $pid = $detail->product_id;
                    if (!isset($productGroups[$pid])) {
                        $productGroups[$pid] = [
                            'product_id' => $pid,
                            'name' => $detail->product->nombre,
                            'sku' => $detail->product->sku,
                            'order_ids' => [],
                            'total_dispatched' => 0.0,
                            'dates' => [],
                        ];
                    }
                    if ($qty > 0) {
                        $productGroups[$pid]['order_ids'][] = $order->id;
                        $productGroups[$pid]['total_dispatched'] += $qty;
                        $productGroups[$pid]['dates'][] = Carbon::parse($order->fecha_pedido)->toDateString();
                        $totalDispatched += $qty;
                    }
                }
            }

            // Añade productos que solo aparecen en órdenes abiertas, aunque no tengan historial despachado.
            $pendingUnits = 0.0;
            foreach ($clientOpenOrders as $order) {
                foreach ($order->details as $detail) {
                    if (!$detail->product) continue;
                    $pendingQty = max(0,
                        (float) ($detail->cantidad_solicitada ?? 0)
                        - (float) ($detail->cantidad_despachada ?? 0)
                    );
                    if ($pendingQty <= 0) continue;
                    $pid = $detail->product_id;
                    $pendingUnits += $pendingQty;
                    if (!isset($productGroups[$pid])) {
                        $productGroups[$pid] = [
                            'product_id' => $pid,
                            'name' => $detail->product->nombre,
                            'sku' => $detail->product->sku,
                            'order_ids' => [],
                            'total_dispatched' => 0.0,
                            'dates' => [],
                        ];
                    }
                }
            }

            $productRows = collect($productGroups)->map(function ($item) use ($clientOpenOrders) {
                $dates = collect($item['dates'])->unique()->sort()->values();
                $gaps = [];
                for ($i = 1; $i < $dates->count(); $i++) {
                    $gaps[] = Carbon::parse($dates[$i - 1])->diffInDays(Carbon::parse($dates[$i]));
                }
                $frequency = count($gaps) ? (int) round(array_sum($gaps) / count($gaps)) : null;
                $last = $dates->last() ? Carbon::parse($dates->last()) : null;
                $pending = 0.0;
                foreach ($clientOpenOrders as $openOrder) {
                    foreach ($openOrder->details as $detail) {
                        if ((int) $detail->product_id === (int) $item['product_id']) {
                            $pending += max(0,
                                (float) ($detail->cantidad_solicitada ?? 0)
                                - (float) ($detail->cantidad_despachada ?? 0)
                            );
                        }
                    }
                }
                $orderCount = count(array_unique($item['order_ids']));
                return [
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'sku' => $item['sku'],
                    'orders' => $orderCount,
                    'total_dispatched' => $item['total_dispatched'],
                    'average_quantity' => $orderCount > 0 ? $item['total_dispatched'] / $orderCount : 0,
                    'frequency_days' => $frequency,
                    'last_order' => $last,
                    'next_order' => ($last && $frequency) ? $last->copy()->addDays($frequency) : null,
                    'pending' => $pending,
                ];
            })->sortBy('name')->values();

            return [
                'client_id' => $clientId,
                'client_name' => $client?->nombre_comercial ?: ($client?->razon_social ?: 'Cliente #' . $clientId),
                'order_count' => $clientOrders->count(),
                'last_order' => $lastOrderDate,
                'average_interval' => $averageInterval !== null ? round($averageInterval, 1) : null,
                'next_order' => $nextDate,
                'days_until_next' => $nextDate ? (int) $today->diffInDays($nextDate, false) : null,
                'total_dispatched' => $totalDispatched,
                'average_order_quantity' => $clientOrders->count() ? $totalDispatched / $clientOrders->count() : 0,
                'pending_orders' => $clientOpenOrders->count(),
                'pending_units' => $pendingUnits,
                'products' => $productRows,
            ];
        })->sortBy('client_name')->values();

        return [
            'clients' => $clients,
            'summary' => [
                'clients' => $clients->count(),
                'orders' => $orders->count(),
                'pending_orders' => $openOrders->count(),
                'pending_units' => $clients->sum('pending_units'),
            ],
        ];
    }

    public function saveSettings(Product $product, array $data, ?int $userId): ProductForecastSetting
    {
        return ProductForecastSetting::updateOrCreate(
            ['product_id' => $product->id],
            [
                'lead_time_days' => $data['lead_time_days'] ?? 3,
                'safety_days' => $data['safety_days'] ?? 3,
                'coverage_days' => $data['coverage_days'] ?? 15,
                'approved_min_stock' => $data['approved_min_stock'] ?? null,
                'updated_by' => $userId,
            ]
        );
    }
}
