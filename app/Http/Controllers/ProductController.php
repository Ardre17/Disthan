<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::latest()->get();

    return view('products.index', compact('products'));
}

public function create()
{
    return view('products.create');
}

public function store(Request $request)
{
    $request->validate([
        'codigo' => 'required|unique:products',
        'nombre' => 'required',
    ]);

    Product::create([
        'codigo' => $request->codigo,
        'nombre' => $request->nombre,
        'unidad' => $request->unidad,
        'stock' => $request->stock ?? 0,
    ]);

    return redirect()->route('products.index');
}
}
