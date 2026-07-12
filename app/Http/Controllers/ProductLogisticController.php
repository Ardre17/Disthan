<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductLogistic;
use Illuminate\Http\Request;

class ProductLogisticController extends Controller
{
    public function edit(Product $product)
    {
        $logistic = ProductLogistic::firstOrCreate(
            ['product_id' => $product->id],
            [
                'largo_cm' => 0,
                'ancho_cm' => 0,
                'alto_cm' => 0,
                'peso_caja' => 0,
                'max_cajas_pallet' => 0,
                'max_niveles' => 0,
                'altura_maxima_pallet' => 160,
                'permite_mezcla' => true,
                'orientacion' => 'NORMAL',
                'activo' => true,
                'prioridad_apilado' => 1,
                'grupo_logistico' => null,
                'apilable' => true,
                'peso_maximo_encima' => 0,
            ]
        );

        return view('products.logistic', compact('product', 'logistic'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'largo_cm' => 'required|numeric|min:0',
            'ancho_cm' => 'required|numeric|min:0',
            'alto_cm' => 'required|numeric|min:0',
            'peso_caja' => 'required|numeric|min:0',
            'max_cajas_pallet' => 'required|integer|min:0',
            'max_niveles' => 'required|integer|min:0',
            'altura_maxima_pallet' => 'required|numeric|min:0',
            'permite_mezcla' => 'required|boolean',
            'orientacion' => 'required|in:NORMAL,ACOSTADO,VERTICAL',
            'activo' => 'required|boolean',
            'prioridad_apilado' => 'required|integer|min:1',
            'grupo_logistico' => 'nullable|string|max:50',
            'apilable' => 'required|boolean',
            'peso_maximo_encima' => 'required|numeric|min:0',
        ]);

        ProductLogistic::updateOrCreate(
            ['product_id' => $product->id],
            [
                'largo_cm' => $request->largo_cm,
                'ancho_cm' => $request->ancho_cm,
                'alto_cm' => $request->alto_cm,
                'peso_caja' => $request->peso_caja,
                'max_cajas_pallet' => $request->max_cajas_pallet,
                'max_niveles' => $request->max_niveles,
                'altura_maxima_pallet' => $request->altura_maxima_pallet,
                'permite_mezcla' => $request->permite_mezcla,
                'orientacion' => $request->orientacion,
                'activo' => $request->activo,
                'prioridad_apilado' => 'required|integer|min:1',
                'grupo_logistico' => 'nullable|string|max:50',
                'apilable' => 'required|boolean',
                'peso_maximo_encima' => 'required|numeric|min:0',
            ]
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Información logística guardada correctamente.');
    }
}