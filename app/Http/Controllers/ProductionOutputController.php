<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionOutputController extends Controller
{
    /**
     * Muestra la pantalla de registro de salidas de producción.
     */
    public function index(Request $request, string $token)
    {
        $tokenCorrecto = config('app.production_output_token');

        if (!$tokenCorrecto || !hash_equals($tokenCorrecto, $token)) {
            abort(404);
        }

        return view('production_outputs.index');
    }
}