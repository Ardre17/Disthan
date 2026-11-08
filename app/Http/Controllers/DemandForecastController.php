<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\DemandForecastService;
use Illuminate\Http\Request;

class DemandForecastController extends Controller
{
    public function index(Request $request, DemandForecastService $forecast)
    {
        if ($request->input('section') === 'supermarkets') {
            $supermarketData = $forecast->supermarkets();
            return view('demand-forecast.index', compact('supermarketData'));
        }

        if ($request->input('section') === 'clients') {
            $clientData = $forecast->clients();
            return view('demand-forecast.index', compact('clientData'));
        }

        $products = $forecast->products($request->input('q'), $request->integer('category_id'));
        $categories = Category::orderBy('nombre')->get();

        $summary = [
            'products' => $products->count(),
            'critical' => $products->filter(fn ($p) => $p->forecast['coverage_days'] !== null && $p->forecast['coverage_days'] <= 7)->count(),
            'to_produce' => $products->filter(fn ($p) => $p->forecast['to_produce'] > 0)->count(),
            'pending' => $products->sum(fn ($p) => $p->forecast['pending']),
        ];

        return view('demand-forecast.index', compact('products', 'categories', 'summary'));
    }

    public function updateSettings(Request $request, Product $product, DemandForecastService $forecast)
    {
        $data = $request->validate([
            'lead_time_days' => ['required', 'integer', 'min:0', 'max:365'],
            'safety_days' => ['required', 'integer', 'min:0', 'max:365'],
            'coverage_days' => ['required', 'integer', 'min:1', 'max:365'],
            'approved_min_stock' => ['nullable', 'numeric', 'min:0', 'max:999999999'],
        ]);

        $forecast->saveSettings($product, $data, $request->user()?->id);

        return back()->with('success', 'Parámetros de proyección actualizados.');
    }
}
