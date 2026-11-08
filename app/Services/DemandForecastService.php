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
     * Proyecta demanda con 180 días de historial combinando cantidades solicitadas
     * (intención de compra) y despachadas (recepción efectiva). En DISTAN una orden
     * COMPLETO puede cerrarse aunque algunos productos solicitados finalmente no hayan salido.
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

    /** Atajo para mantener la sección independiente de supermercados. */
    public function supermarkets()
    {
        return $this->customerPlanning(['SUPERMERCADO']);
    }

    /** Planificación individual para clientes LOCAL y ENCOMIENDA. */
    public function clients()
    {
        return $this->customerPlanning(['LOCAL', 'ENCOMIENDA']);
    }

    /**
     * Analiza la frecuencia, demanda solicitada, despacho y pendientes por cliente.
     * Los compromisos futuros solo proceden de órdenes PARCIAL e INCOMPLETO.
     */
    private function customerPlanning(array $types)
    {
        $today = Carbon::today();
        $historyStart = $today->copy()->subDays(179)->startOfDay();

        $orders = Order::query()
            ->with(['client', 'details.product'])
            ->whereIn(DB::raw("UPPER(COALESCE(tipo_orden, ''))"), $types)
            ->whereNotIn(DB::raw("UPPER(COALESCE(estado, ''))"), [
                'ANULADO', 'ANULADA', 'CANCELADO', 'CANCELADA', 'ELIMINADO',
            ])
            ->whereDate('fecha_pedido', '>=', $historyStart->toDateString())
            ->orderBy('fecha_pedido')
            ->get();

        // Historial completo para localizar la última recepción aunque haya ocurrido
        // hace más de 180 días. Los promedios habituales siguen usando la ventana de 180 días.
        $allOrders = Order::query()
            ->with(['client', 'details.product'])
            ->whereIn(DB::raw("UPPER(COALESCE(tipo_orden, ''))"), $types)
            ->whereNotIn(DB::raw("UPPER(COALESCE(estado, ''))"), [
                'ANULADO', 'ANULADA', 'CANCELADO', 'CANCELADA', 'ELIMINADO',
            ])
            ->orderBy('fecha_pedido')
            ->get();

        // Solo estas órdenes mantienen compromisos de preparación/despacho.
        $openOrders = Order::query()
            ->with(['client', 'details.product'])
            ->whereIn(DB::raw("UPPER(COALESCE(tipo_orden, ''))"), $types)
            ->whereIn(DB::raw("UPPER(COALESCE(estado, ''))"), ['PARCIAL', 'INCOMPLETO'])
            ->get();

        $clientIds = $orders->pluck('client_id')
            ->merge($allOrders->pluck('client_id'))
            ->merge($openOrders->pluck('client_id'))
            ->filter()->unique()->values();

        $clients = $clientIds->map(function ($clientId) use ($orders, $allOrders, $openOrders, $today) {
            $clientOrders = $orders->where('client_id', $clientId)->sortBy('fecha_pedido')->values();
            $clientAllOrders = $allOrders->where('client_id', $clientId)->sortBy('fecha_pedido')->values();
            $clientOpenOrders = $openOrders->where('client_id', $clientId)->values();
            $client = $clientOrders->first()?->client ?? $clientOpenOrders->first()?->client ?? $clientAllOrders->first()?->client;

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
            // DISTAN no tiene un campo único de fecha_recepcion/despacho; usamos
            // fecha_preparacion del detalle y, como respaldo, fecha_entrega/fecha_pedido.
            $productGroups = [];
            $totalDispatched = 0.0;
            foreach ($clientOrders as $order) {
                foreach ($order->details as $detail) {
                    $requested = (float) ($detail->cantidad_solicitada ?? 0);
                    $qty = (float) ($detail->cantidad_despachada ?? 0);
                    if (!$detail->product || ($requested <= 0 && $qty <= 0)) continue;

                    $pid = (int) $detail->product_id;
                    $dateValue = $detail->fecha_preparacion
                        ?: ($order->fecha_entrega ?: $order->fecha_pedido);
                    $receivedDate = Carbon::parse($dateValue)->toDateString();
                    $orderDate = Carbon::parse($order->fecha_pedido)->toDateString();

                    if (!isset($productGroups[$pid])) {
                        $productGroups[$pid] = [
                            'product_id' => $pid,
                            'name' => $detail->product->nombre,
                            'sku' => $detail->product->sku,
                            'quantity_per_box' => (float) ($detail->product->cantidad_por_caja ?? 0),
                            'dispatches' => [],
                            'historical_dispatches' => [],
                            'request_orders' => [],
                            'historical_requests' => [],
                            'total_requested' => 0.0,
                            'total_dispatched' => 0.0,
                        ];
                    }

                    // La solicitud mide la demanda del cliente; el despacho mide lo que realmente recibió.
                    if (!isset($productGroups[$pid]['request_orders'][$order->id])) {
                        $productGroups[$pid]['request_orders'][$order->id] = [
                            'requested' => 0.0, 'dispatched' => 0.0, 'date' => $orderDate,
                        ];
                    }
                    $productGroups[$pid]['request_orders'][$order->id]['requested'] += $requested;
                    $productGroups[$pid]['request_orders'][$order->id]['dispatched'] += $qty;
                    $productGroups[$pid]['total_requested'] += $requested;

                    // Los despachos se conservan aparte para calcular la última recepción real estimada.
                    if ($qty > 0) {
                        if (!isset($productGroups[$pid]['dispatches'][$order->id])) {
                            $productGroups[$pid]['dispatches'][$order->id] = [
                                'quantity' => 0.0, 'date' => $receivedDate,
                            ];
                        }
                        $productGroups[$pid]['dispatches'][$order->id]['quantity'] += $qty;
                        $productGroups[$pid]['total_dispatched'] += $qty;
                        $totalDispatched += $qty;
                    }
                }
            }

            // Conserva también productos con despachos antiguos aunque no hayan salido
            // en las órdenes de los últimos 180 días ni tengan un pedido abierto.
            // Esto evita que desaparezcan del pronóstico o se muestren como cero.
            foreach ($clientAllOrders as $historicalOrder) {
                foreach ($historicalOrder->details as $historicalDetail) {
                    $historicalRequested = (float) ($historicalDetail->cantidad_solicitada ?? 0);
                    $historicalQty = (float) ($historicalDetail->cantidad_despachada ?? 0);
                    if (!$historicalDetail->product || ($historicalRequested <= 0 && $historicalQty <= 0)) continue;

                    $pid = (int) $historicalDetail->product_id;
                    $dateValue = $historicalDetail->fecha_preparacion
                        ?: ($historicalOrder->fecha_entrega ?: $historicalOrder->fecha_pedido);
                    $receivedDate = Carbon::parse($dateValue)->toDateString();
                    $orderDate = Carbon::parse($historicalOrder->fecha_pedido)->toDateString();

                    if (!isset($productGroups[$pid])) {
                        $productGroups[$pid] = [
                            'product_id' => $pid,
                            'name' => $historicalDetail->product->nombre,
                            'sku' => $historicalDetail->product->sku,
                            'quantity_per_box' => (float) ($historicalDetail->product->cantidad_por_caja ?? 0),
                            'dispatches' => [],
                            'historical_dispatches' => [],
                            'request_orders' => [],
                            'historical_requests' => [],
                            'total_requested' => 0.0,
                            'total_dispatched' => 0.0,
                        ];
                    }

                    if (!isset($productGroups[$pid]['historical_requests'][$historicalOrder->id])) {
                        $productGroups[$pid]['historical_requests'][$historicalOrder->id] = [
                            'requested' => 0.0, 'dispatched' => 0.0, 'date' => $orderDate,
                        ];
                    }
                    $productGroups[$pid]['historical_requests'][$historicalOrder->id]['requested'] += $historicalRequested;
                    $productGroups[$pid]['historical_requests'][$historicalOrder->id]['dispatched'] += $historicalQty;

                    if ($historicalQty > 0) {
                        if (!isset($productGroups[$pid]['historical_dispatches'][$historicalOrder->id])) {
                            $productGroups[$pid]['historical_dispatches'][$historicalOrder->id] = [
                                'quantity' => 0.0, 'date' => $receivedDate,
                            ];
                        }
                        $productGroups[$pid]['historical_dispatches'][$historicalOrder->id]['quantity'] += $historicalQty;
                        if ($receivedDate > $productGroups[$pid]['historical_dispatches'][$historicalOrder->id]['date']) {
                            $productGroups[$pid]['historical_dispatches'][$historicalOrder->id]['date'] = $receivedDate;
                        }
                    }
                }
            }

            // Añade productos que solo aparecen en órdenes abiertas.
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
                            'quantity_per_box' => (float) ($detail->product->cantidad_por_caja ?? 0),
                            'dispatches' => [],
                            'historical_dispatches' => [],
                            'request_orders' => [],
                            'historical_requests' => [],
                            'total_requested' => 0.0,
                            'total_dispatched' => 0.0,
                        ];
                    }
                }
            }

            // Última recepción estimada y cantidad entregada en esa recepción,
            // consultando todo el historial, aunque sea anterior a 180 días.
            // Se agrupan líneas del mismo producto dentro de la misma orden.
            $lastReceivedByProduct = [];
            foreach ($clientAllOrders as $historicalOrder) {
                $dispatchByProductInOrder = [];
                foreach ($historicalOrder->details as $historicalDetail) {
                    $qty = (float) ($historicalDetail->cantidad_despachada ?? 0);
                    if (!$historicalDetail->product || $qty <= 0) continue;

                    $dateValue = $historicalDetail->fecha_preparacion
                        ?: ($historicalOrder->fecha_entrega ?: $historicalOrder->fecha_pedido);
                    $date = Carbon::parse($dateValue)->toDateString();
                    $pid = (int) $historicalDetail->product_id;

                    if (!isset($dispatchByProductInOrder[$pid])) {
                        $dispatchByProductInOrder[$pid] = ['date' => $date, 'quantity' => 0.0];
                    }
                    $dispatchByProductInOrder[$pid]['quantity'] += $qty;
                    if ($date > $dispatchByProductInOrder[$pid]['date']) {
                        $dispatchByProductInOrder[$pid]['date'] = $date;
                    }
                }

                foreach ($dispatchByProductInOrder as $pid => $dispatch) {
                    $previous = $lastReceivedByProduct[$pid] ?? null;
                    if (!$previous || $dispatch['date'] >= $previous['date']) {
                        $lastReceivedByProduct[$pid] = $dispatch;
                    }
                }
            }

            // La frecuencia del supermercado representa el ciclo de compra incluso
            // cuando omite un producto en una semana. Usamos la mediana de intervalos
            // para que una demora aislada no cambie demasiado el patrón semanal.
            $typicalClientInterval = count($intervals) ? (int) round($this->medianValue($intervals)) : 7;
            $typicalClientInterval = max(1, $typicalClientInterval);

            $productRows = collect($productGroups)->map(function ($item) use ($clientOpenOrders, $clientAllOrders, $typicalClientInterval, $today, $lastReceivedByProduct) {
                $dispatches = collect($item['dispatches'])->sortBy('date')->values();
                $dates = $dispatches->pluck('date')->unique()->sort()->values();
                $gaps = [];
                for ($i = 1; $i < $dates->count(); $i++) {
                    $gaps[] = Carbon::parse($dates[$i - 1])->diffInDays(Carbon::parse($dates[$i]));
                }

                // Se usa la cadencia del supermercado, no los huecos entre despachos
                // de este producto: si lo omite una semana, esa semana también acumula
                // demanda potencial.
                $frequency = $typicalClientInterval;
                $lastReceipt = $lastReceivedByProduct[(int) $item['product_id']] ?? null;
                $lastReceivedValue = $lastReceipt['date'] ?? $dates->last();
                $lastReceived = $lastReceivedValue ? Carbon::parse($lastReceivedValue)->startOfDay() : null;
                $lastReceivedQuantity = (float) ($lastReceipt['quantity'] ?? 0);
                $daysSinceReceived = $lastReceived ? max(0, (int) $lastReceived->diffInDays($today)) : null;

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

                $recentRequestOrders = collect($item['request_orders'] ?? [])->values();
                $allRequestOrders = collect($item['historical_requests'] ?? [])->values();
                $requestObservations = $recentRequestOrders->isNotEmpty()
                    ? $recentRequestOrders
                    : $allRequestOrders;

                // El promedio se basa en lo que el supermercado pidió, no solo en lo que DISTAN logró despachar.
                // La cantidad despachada y la diferencia no atendida se muestran por separado.
                $requestedQuantities = $requestObservations
                    ->pluck('requested')->map(fn ($quantity) => (float) $quantity)
                    ->filter(fn ($quantity) => $quantity > 0)->values()->all();
                $averageQuantity = count($requestedQuantities) > 0
                    ? $this->medianValue($requestedQuantities)
                    : 0.0;
                if ($averageQuantity <= 0 && $lastReceivedQuantity > 0) {
                    $averageQuantity = $lastReceivedQuantity;
                }

                $totalRequested = (float) $allRequestOrders->sum('requested');
                $totalDispatchedAll = (float) $allRequestOrders->sum('dispatched');
                $totalUnfulfilled = max(0, $totalRequested - $totalDispatchedAll);
                $fulfillmentRate = $totalRequested > 0
                    ? min(100, ($totalDispatchedAll / $totalRequested) * 100)
                    : 0.0;
                $orderCount = $requestObservations->count();

                // Si la última orden pidió más de lo recibido, ese faltante se conserva como señal de demanda
                // potencial, pero nunca como compromiso operativo si la orden ya está COMPLETO.
                $latestRequest = $allRequestOrders->sortBy('date')->last();
                $lastRequestUnfulfilled = $latestRequest
                    ? max(0, (float) $latestRequest['requested'] - (float) $latestRequest['dispatched'])
                    : 0.0;

                // Cuenta los ciclos del cliente posteriores a la última recepción real.
                // Si nunca hubo recepción, parte de la primera solicitud registrada del producto.
                $firstRequestDate = $allRequestOrders->min('date');
                $referenceDate = $lastReceived ?: ($firstRequestDate ? Carbon::parse($firstRequestDate)->startOfDay() : null);
                $orderDatesAfterReference = $referenceDate
                    ? $clientAllOrders
                        ->filter(function ($order) use ($referenceDate, $lastReceived) {
                            $date = Carbon::parse($order->fecha_pedido)->startOfDay();
                            return $lastReceived ? $date->gt($referenceDate) : $date->gte($referenceDate);
                        })
                        ->map(fn ($order) => Carbon::parse($order->fecha_pedido)->toDateString())
                        ->unique()->count()
                    : 0;
                $calendarCycles = ($frequency && $referenceDate)
                    ? (int) floor(max(0, $referenceDate->diffInDays($today)) / max(1, $frequency))
                    : 0;
                $elapsedCycles = max($calendarCycles, $orderDatesAfterReference);
                if (!$lastReceived && $referenceDate) {
                    $elapsedCycles = max(1, $elapsedCycles);
                }

                // Una entrega extraordinaria puede moderar solo una parte de la proyección,
                // pero nunca reducirla por debajo de un ciclo habitual.
                $extraDeliveryCredit = min(
                    max(0, $lastReceivedQuantity - $averageQuantity),
                    $averageQuantity
                );
                $coveredCycles = $averageQuantity > 0 && $extraDeliveryCredit > 0 ? 1 : 0;
                $cyclesDue = $elapsedCycles + 1; // incluye la siguiente orden que todavía podría solicitarse.
                $expectedNextOrder = $averageQuantity > 0
                    ? max($averageQuantity, ($averageQuantity * $cyclesDue) - $extraDeliveryCredit) + $lastRequestUnfulfilled
                    : $lastRequestUnfulfilled;
                // Los pendientes abiertos se descuentan solo de la necesidad adicional; los saldos de órdenes
                // COMPLETO sirven como señal histórica, no como compromiso futuro.
                $expectedAdditional = max(0, $expectedNextOrder - $pending);
                $quantityPerBox = (float) ($item['quantity_per_box'] ?? 0);
                $expectedBoxes = $quantityPerBox > 0
                    ? (int) ceil($expectedNextOrder / $quantityPerBox)
                    : null;
                $additionalBoxes = $quantityPerBox > 0
                    ? (int) ceil($expectedAdditional / $quantityPerBox)
                    : null;

                return [
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'sku' => $item['sku'],
                    'orders' => $orderCount,
                    'total_requested' => $totalRequested,
                    'total_dispatched' => $totalDispatchedAll,
                    'total_unfulfilled' => $totalUnfulfilled,
                    'fulfillment_rate' => $fulfillmentRate,
                    'average_quantity' => $averageQuantity,
                    'frequency_days' => $frequency,
                    'last_received_quantity' => $lastReceivedQuantity,
                    'covered_cycles' => $coveredCycles,
                    'extra_delivery_credit' => $extraDeliveryCredit,
                    'cycles_due' => $cyclesDue,
                    'quantity_per_box' => $quantityPerBox,
                    'expected_boxes' => $expectedBoxes,
                    'additional_boxes' => $additionalBoxes,
                    'last_order' => $lastReceived,
                    'days_since_received' => $daysSinceReceived,
                    'elapsed_cycles' => $elapsedCycles,
                    'expected_next_order' => $expectedNextOrder,
                    'last_request_unfulfilled' => $lastRequestUnfulfilled,
                    'expected_additional' => $expectedAdditional,
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
                'total_requested' => $productRows->sum('total_requested'),
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

    /** Calcula la mediana de una lista numérica sin dejar que valores extremos dominen. */
    private function medianValue(array $values): float
    {
        $values = array_values(array_filter(array_map('floatval', $values), fn ($value) => is_finite($value)));
        if (!$values) return 0.0;

        sort($values, SORT_NUMERIC);
        $count = count($values);
        $middle = intdiv($count, 2);

        return $count % 2 === 1
            ? (float) $values[$middle]
            : ((float) $values[$middle - 1] + (float) $values[$middle]) / 2;
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
