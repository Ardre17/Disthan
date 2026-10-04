<?php

namespace App\Http\Controllers;

use App\Services\SupplyMaterialService;
use Illuminate\Http\Request;

class SupplyOrderController extends Controller
{
    public function create()
{
    return view('supply-orders.create');
}

    public function materials(
        Request $request,
        SupplyMaterialService $materialService
    ) {
        $search = $request->input('search');

        $materials = $materialService->all($search);

        return response()->json([
            'success' => true,
            'data' => $materials,
        ]);
    }
}