<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseLocation;
use Illuminate\Http\JsonResponse;


class WarehouseMapController extends Controller
{
    public function index()
    {
        return view('warehouse.map');
    }
    public function locations(): JsonResponse
    {
        $locations = WarehouseLocation::with('product')
            ->orderBy('level')
            ->orderBy('rack')
            ->orderBy('code')
            ->get();

        return response()->json($locations);
    }

}
