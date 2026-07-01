<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\WarehouseLocation;
use App\Models\WarehouseRack;

class WarehouseMapController extends Controller
{
    public function index()
{
    $racks = WarehouseRack::where('active', true)
                ->orderByDesc('level')
                ->orderBy('rack')
                ->get();

    return view('warehouse.map', compact('racks'));
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
