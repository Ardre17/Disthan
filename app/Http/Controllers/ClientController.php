<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('search')) {

            $query->where(function($q) use ($request){

                $q->where('ruc', 'like', '%'.$request->search.'%')
                  ->orWhere('razon_social', 'like', '%'.$request->search.'%')
                  ->orWhere('nombre_comercial', 'like', '%'.$request->search.'%');

            });
        }

        $clients = $query
            ->latest()
            ->get();

        return view(
            'clients.index',
            compact('clients')
        );
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'ruc' => 'required|unique:clients',
        'razon_social' => 'required',
    ]);

    Client::create([

        'ruc' => $request->ruc,
        'razon_social' => $request->razon_social,
        'nombre_comercial' => $request->nombre_comercial,

        'contacto' => $request->contacto,
        'telefono' => $request->telefono,
        'correo' => $request->correo,

        'direccion' => $request->direccion,
        'distrito' => $request->distrito,
        'ciudad' => $request->ciudad,

        // 🔥 SIEMPRE ACTIVO AL CREAR
        'activo' => true,

        'observaciones' => $request->observaciones,
    ]);

    return redirect()
        ->route('clients.index')
        ->with('success', 'Cliente registrado correctamente');
}

    public function edit(Client $client)
    {
        return view(
            'clients.edit',
            compact('client')
        );
    }

    public function update(
        Request $request,
        Client $client
    )
    {
        $request->validate([
            'ruc' => 'required',
            'razon_social' => 'required',
        ]);

        $client->update([

            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'nombre_comercial' => $request->nombre_comercial,

            'contacto' => $request->contacto,
            'telefono' => $request->telefono,
            'correo' => $request->correo,

            'direccion' => $request->direccion,
            'distrito' => $request->distrito,
            'ciudad' => $request->ciudad,

            'activo' => $request->activo ? true : false,

            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}