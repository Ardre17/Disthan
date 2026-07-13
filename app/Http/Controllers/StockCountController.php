<?php
// app/Http/Controllers/StockCountController.php

namespace App\Http\Controllers;

use App\Models\StockCount;
use App\Models\StockCountDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockCountController extends Controller
{
    public function index()
    {
        $conteos = StockCount::withCount('detalles')
            ->orderByDesc('fecha')
            ->paginate(15);

        return view('stock_count.historial', compact('conteos'));
    }

    public function create()
    {
        $conteo = DB::transaction(function () {
            $codigo = 'CONT-' . now()->format('Y') . '-' . str_pad(StockCount::count() + 1, 3, '0', STR_PAD_LEFT);

            $conteo = StockCount::create([
                'codigo' => $codigo,
                'fecha' => now()->toDateString(),
                'realizado_por' => Auth::user()->name ?? null,
                'estado' => 'EN_PROCESO',
            ]);

            $productos = Product::where('activo', true)->get();

            foreach ($productos as $producto) {
                StockCountDetail::create([
                    'stock_count_id' => $conteo->id,
                    'product_id' => $producto->id,
                    'stock_sistema' => $producto->stock,
                ]);
            }

            return $conteo;
        });

        return redirect()->route('stockcount.captura', $conteo->id);
    }

    public function captura(StockCount $stockcount)
    {
        $detalles = $stockcount->detalles()->with('product')->get();
        return view('stock_count.captura', ['conteo' => $stockcount, 'detalles' => $detalles]);
    }

    public function guardarCaptura(Request $request, StockCount $stockcount)
    {
        $request->validate([
            'stock_fisico' => 'required|array',
            'stock_fisico.*' => 'nullable|integer|min:0',
        ]);

        foreach ($request->stock_fisico as $detalleId => $valor) {
            if ($valor === null || $valor === '') continue;

            $detalle = StockCountDetail::find($detalleId);
            if (!$detalle || $detalle->stock_count_id !== $stockcount->id) continue;

            $detalle->update([
                'stock_fisico' => $valor,
                'diferencia' => $valor - $detalle->stock_sistema,
            ]);
        }

        $stockcount->update([
            'estado' => 'FINALIZADO',
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('stockcount.show', $stockcount->id);
    }

    public function show(StockCount $stockcount)
    {
        $detalles = $stockcount->detalles()->with('product')
            ->orderByRaw('ABS(diferencia) DESC')
            ->get();

        $totalDiferencias = $detalles->where('diferencia', '<>', 0)->count();
        $sobrantes = $detalles->where('diferencia', '>', 0)->sum('diferencia');
        $faltantes = $detalles->where('diferencia', '<', 0)->sum('diferencia');

        return view('stock_count.detalle', [
            'conteo' => $stockcount,
            'detalles' => $detalles,
            'totalDiferencias' => $totalDiferencias,
            'sobrantes' => $sobrantes,
            'faltantes' => $faltantes,
        ]);
    }
}