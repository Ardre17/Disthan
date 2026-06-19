<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Product::count();

        $stockTotal = Product::sum('stock');

        $stockBajo = Product::whereColumn(
            'stock',
            '<=',
            'stock_minimo'
        )->count();

        $rotacionAlta = Product::whereIn(
            'rotacion',
            ['MUY_ALTA','ALTA']
        )->count();

        $proximosVencer = Product::all()
            ->filter(function ($product) {

                if (!$product->fecha_vencimiento) {
                    return false;
                }

                return now()->diffInDays(
                    $product->fecha_vencimiento,
                    false
                ) <= 30;
            })
            ->count();

            $productosStockBajo = Product::whereColumn(
                'stock',
                '<=',
                'stock_minimo'
            )
            ->orderBy('stock')
            ->take(5)
            ->get();

            $productosPorVencer = Product::all()
                ->filter(function ($product) {

                    if (!$product->fecha_vencimiento) {
                        return false;
                    }

                    return now()->diffInDays(
                        $product->fecha_vencimiento,
                        false
                    ) <= 30;
                })
                ->take(5);

        return view(
            'dashboard',
            compact(
                'totalProductos',
                'stockTotal',
                'stockBajo',
                'rotacionAlta',
                'proximosVencer',
                'productosStockBajo',
                'productosPorVencer'
            )
        );
    }
}