<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductForecastSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DemandForecastService
{
    /**
     * Forecast demand from valid orders in the last 180 days.
     * Recent 28-day daily rate receives 60%; previous 152-day rate receives 40%.
     * Order quantities are used as demand; dispatched quantities are not substituted.
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
                $w->whereRaw('LOWER(nombre) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                  ->orWhereRaw("LOWER(COALESCE(sku, '')) LIKE ?", ['%' . mb_strtolower($search) . '%']);
            }))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderBy('nombre')->get();

        $productIds = $products->pluck('id');
        $base = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->whereIn('od.product_id', $productIds)
            ->whereNotIn(DB::raw('UPPER(COALESCE(o.estado, \'\'))'), ['ANULADO', 'CANCELADO', 'CANCELADA', 'ELIMINADO'])
            ->whereBetween('o.fecha_pedido', [$historyStart, $recentEnd]);

        $recent = (clone $base)->whereBetween('o.fecha_pedido', [$recentStart, $recentEnd])
            ->select('od.product_id', DB::raw('SUM(od.cantidad_solicitada) as qty'))
            ->groupBy('od.product_id')->pluck('qty', 'product_id');

        $previous = (clone $base)->whereBetween('o.fecha_pedido', [$historyStart, $historyEnd])
            ->select('od.product_id', DB::raw('SUM(od.cantidad_solicitada) as qty'))
            ->groupBy('od.product_id')->pluck('qty', 'product_id');

        $openPending = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->whereIn('od.product_id', $productIds)
            ->whereNotIn(DB::raw('UPPER(COALESCE(o.estado, \'\'))'), ['COMPLETO', 'ANULADO', 'CANCELADO', 'CANCELADA', 'ELIMINADO'])
            ->select('od.product_id', DB::raw('SUM(GREATEST(COALESCE(od.cantidad_solicitada,0) - COALESCE(od.cantidad_despachada,0),0)) as pending'))
            ->groupBy('od.product_id')->pluck('pending', 'product_id');

        $production = DB::table('production_orders')
            ->whereIn('product_id', $productIds)
            ->where('status', 'EN_PRODUCCION')
            ->select('product_id', DB::raw('SUM(produced_quantity) as qty'))
            ->groupBy('product_id')->pluck('qty', 'product_id');

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
            $recommendedMinimum = ($daily * $lead) + $securityStock;
            $targetStock = ($daily * $coverage) + $securityStock;
            $effectiveStock = max(0, $stock - $pending) + $inProduction;
            $toProduce = max(0, $targetStock - $effectiveStock);

            $product->forecast = [
                'recent_daily' => round($recentDaily, 2),
                'historical_daily' => round($previousDaily, 2),
                'daily_demand' => round($daily, 2),
                'demand_7d' => round($daily * 7, 2),
                'demand_15d' => round($daily * 15, 2),
                'demand_30d' => round($daily * 30, 2),
                'pending' => round($pending, 2),
                'in_production' => round($inProduction, 2),
                'security_stock' => round($securityStock, 2),
                'recommended_minimum' => round($recommendedMinimum, 2),
                'approved_minimum' => $setting?->approved_min_stock,
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
