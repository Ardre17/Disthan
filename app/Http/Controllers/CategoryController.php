<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where(
                'nombre',
                'like',
                '%'.$request->search.'%'
            );
        }

        $categories = $query
            ->latest()
            ->get();

        return view(
            'categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        Category::create([
            'nombre' => $request->nombre,
            'color' => $request->color,
            'activo' => $request->activo ? true : false,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría registrada');
    }

    public function edit(Category $category)
    {
        return view(
            'categories.edit',
            compact('category')
        );
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'nombre' => $request->nombre,
            'color' => $request->color,
            'activo' => $request->activo ? true : false,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría actualizada');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría eliminada');
    }
}