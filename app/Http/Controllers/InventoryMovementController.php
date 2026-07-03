<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = InventoryMovement::with([
            'product',
            'rawMaterial',
            'client',
            'user'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'inventory_movements.index',
            compact('movements')
        );
    }
}