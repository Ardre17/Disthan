<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pallet;
use App\Models\PalletDetail;
use Illuminate\Http\Request;

class ExportController extends Controller
{

    /**
     * Mostrar la vista principal de exportación.
     */
    public function show(Order $order)
    {
        return view('orders.edit_exportacion', compact('order'));
    }

}
