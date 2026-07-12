<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PalletType;
use App\Services\PalletPlannerService;

class PalletController extends Controller
{

    public function generar(Order $order)
{
    $pallet = PalletType::where('activo', true)->first();

    $planner = new PalletPlannerService();

    $resultado = $planner->generar($order, $pallet);

    return view('pallets.resultado', compact('resultado'));
}

    public function index()
    {
        return view('pallets.index');
    }

    public function configuracion()
    {
        return view('pallets.configuracion');
    }

    public function simulador()
    {
        return view('pallets.simulador');
    }
}