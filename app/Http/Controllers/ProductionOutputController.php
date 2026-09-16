<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionOutputController extends Controller
{
    /**
     * Muestra la pantalla de registro de salidas de producción.
     */
    public function index()
    {
        return view('production_outputs.index');
    }
}