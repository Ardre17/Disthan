<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogoComercialController extends Controller
{
    private const TIPOS_ORDEN = [
        'LOCAL', 'SUPERMERCADO', 'SUPERMERCADOS',
        'ENCOMIENDA', 'ENCOMIENDAS',
    ];

    private function compromisosPorProducto()
    {
        $details = OrderDetail::query()
            ->with('order:id,tipo_orden,estado')
            ->whereHas('order', function ($query) {
                $query->whereIn('tipo_orden', self::TIPOS_ORDEN)
                    ->whereNotIn(DB::raw('LOWER(COALESCE(estado, \'\'))'), ['completo', 'cancelado', 'cancelada', 'anulado', 'anulada']);
            })
            ->get(['product_id', 'order_id', 'cantidad_solicitada', 'cantidad_despachada']);

        return $details->groupBy('product_id')->map(function ($items) {
            return $items->sum(function ($item) {
                return max(0, (float) $item->cantidad_solicitada - (float) $item->cantidad_despachada);
            });
        });
    }

    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('nombre')->get();
        $base = Product::query()->where('activo', true);

        $totalActivos = (clone $base)->count();
        $conStock = (clone $base)->where('stock', '>', 0)->count();
        $stockBajo = (clone $base)->whereColumn('stock', '<=', 'stock_minimo')->where('stock', '>', 0)->count();
        $agotados = (clone $base)->where('stock', '<=', 0)->count();

        $query = Product::query()
            ->with('category')
            ->where('activo', true);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'agotado') {
                $query->where('stock', '<=', 0);
            } elseif ($request->estado === 'bajo') {
                $query->whereColumn('stock', '<=', 'stock_minimo')->where('stock', '>', 0);
            } elseif ($request->estado === 'disponible') {
                $query->where('stock', '>', 0)->where(function ($q) {
                    $q->whereNull('stock_minimo')->orWhereColumn('stock', '>', 'stock_minimo');
                });
            }
        }

        if ($request->filled('q')) {
            $term = trim($request->q);
            $query->where(function ($q) use ($term) {
                $like = '%' . $term . '%';
                $q->where('nombre', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhere('barcode', 'like', $like)
                    ->orWhere('box_barcode', 'like', $like)
                    ->orWhere('marca', 'like', $like);
            });
        }

        $products = $query->orderBy('nombre')->paginate(20)->withQueryString();
        $commitments = $this->compromisosPorProducto();
        $products->getCollection()->transform(function ($product) use ($commitments) {
            $product->comprometido_catalogo = (float) ($commitments[$product->id] ?? 0);
            $product->no_comprometido_catalogo = max(0, (float) ($product->stock ?? 0) - $product->comprometido_catalogo);
            return $product;
        });

        $categoryCounts = Product::query()->where('activo', true)
            ->select('category_id')->selectRaw('COUNT(*) AS total')
            ->groupBy('category_id')->pluck('total', 'category_id');

        return view('catalogo-comercial.index', compact(
            'categories', 'products', 'totalActivos', 'conStock', 'stockBajo', 'agotados', 'categoryCounts'
        ));
    }

    public function show(Product $product)
    {
        abort_unless($product->activo, 404);
        $product->load('category');

        $commitments = $this->compromisosPorProducto();
        $product->comprometido_catalogo = (float) ($commitments[$product->id] ?? 0);
        $product->no_comprometido_catalogo = max(0, (float) ($product->stock ?? 0) - $product->comprometido_catalogo);

        $start = now()->startOfMonth()->subMonths(5);
        $movementDetails = OrderDetail::query()
            ->with('order:id,fecha_pedido,tipo_orden,estado')
            ->where('product_id', $product->id)
            ->whereHas('order', function ($query) use ($start) {
                $query->whereIn('tipo_orden', self::TIPOS_ORDEN)
                    ->whereNotIn(DB::raw('LOWER(COALESCE(estado, \'\'))'), ['cancelado', 'cancelada', 'anulado', 'anulada'])
                    ->whereDate('fecha_pedido', '>=', $start->toDateString());
            })
            ->get(['order_id', 'cantidad_despachada']);

        $rows = $movementDetails->groupBy(function ($detail) {
            return $detail->order && $detail->order->fecha_pedido
                ? Carbon::parse($detail->order->fecha_pedido)->format('Y-m')
                : '';
        })->map(function ($items) {
            return $items->sum(fn ($item) => (float) $item->cantidad_despachada);
        });

        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $months[] = [
                'key' => $key,
                'label' => ucfirst($month->locale('es')->translatedFormat('M Y')),
                'cantidad' => (float) ($rows[$key] ?? 0),
            ];
        }

        $maxMovement = max(1, ...array_column($months, 'cantidad'));
        $previous = (float) ($months[4]['cantidad'] ?? 0);
        $current = (float) ($months[5]['cantidad'] ?? 0);
        $variation = $previous > 0 ? (($current - $previous) / $previous) * 100 : null;
        $totalMovement = array_sum(array_column($months, 'cantidad'));

        $categoryTotal = 0;
        if ($product->category_id) {
            $categoryDetails = OrderDetail::query()
                ->with('order:id,fecha_pedido,tipo_orden,estado')
                ->whereHas('product', fn ($q) => $q->where('category_id', $product->category_id))
                ->whereHas('order', function ($query) use ($start) {
                    $query->whereIn('tipo_orden', self::TIPOS_ORDEN)
                        ->whereNotIn(DB::raw('LOWER(COALESCE(estado, \'\'))'), ['cancelado', 'cancelada', 'anulado', 'anulada'])
                        ->whereDate('fecha_pedido', '>=', $start->toDateString());
                })
                ->get(['product_id', 'order_id', 'cantidad_despachada']);
            $categoryTotal = (float) $categoryDetails->sum(fn ($item) => (float) $item->cantidad_despachada);
        }
        $categoryShare = $categoryTotal > 0 ? ($totalMovement / $categoryTotal) * 100 : null;

        // Lotes y vencimientos conocidos en detalles de pedido, agrupados sin mostrar datos del cliente.
        $lots = OrderDetail::query()
            ->where('product_id', $product->id)
            ->where(function ($q) {
                $q->whereNotNull('lote')->orWhereNotNull('fecha_vencimiento');
            })
            ->select('lote', 'fecha_vencimiento')
            ->selectRaw('COUNT(*) AS referencias')
            ->groupBy('lote', 'fecha_vencimiento')
            ->orderBy('fecha_vencimiento')
            ->limit(20)
            ->get();

        return view('catalogo-comercial.show', compact(
            'product', 'months', 'maxMovement', 'variation', 'totalMovement', 'categoryShare', 'lots'
        ));
    }
}
