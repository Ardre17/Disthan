<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseMapController extends Controller
{
    public function index()
    {
        return view('warehouse.map');
    }
}
