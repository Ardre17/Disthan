@extends('layouts.app')

@section('content')

<div style="padding:30px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">
        <h1 style="font-size:28px;font-weight:bold;">
            👥 Clientes
        </h1>

        <a href="{{ route('clients.create') }}"
           style="
            background:#2563eb;
            color:white;
            padding:12px 20px;
            border-radius:8px;
            text-decoration:none;
           ">
            + Nuevo Cliente
        </a>
    </div>

    <div style="margin-bottom:20px;">

        <form method="GET">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por RUC o Razón Social..."
                style="
                    width:400px;
                    padding:10px;
                    border:1px solid #ddd;
                    border-radius:8px;
                ">

            <button type="submit"
                    style="
                        background:#2563eb;
                        color:white;
                        border:none;
                        padding:10px 20px;
                        border-radius:8px;
                        margin-left:5px;
                    ">
                Buscar
            </button>

        </form>

    </div>

    @forelse($clients as $client)

        <div style="
            background:white;
            padding:20px;
            border-radius:10px;
            margin-bottom:15px;
            box-shadow:0 2px 8px rgba(0,0,0,.08);
        ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            ">

                <div>

                    <h3 style="
                        font-size:18px;
                        font-weight:bold;
                        margin-bottom:5px;
                    ">
                        {{ $client->razon_social }}
                    </h3>

                    <div>
                        <strong>RUC:</strong>
                        {{ $client->ruc }}
                    </div>

                    <div>
                        <strong>Contacto:</strong>
                        {{ $client->contacto }}
                    </div>

                    <div>
                        <strong>Teléfono:</strong>
                        {{ $client->telefono }}
                    </div>

                </div>

                <div>

                    <a href="{{ route('clients.edit',$client) }}"
                       style="
                            background:#f59e0b;
                            color:white;
                            padding:10px 15px;
                            border-radius:8px;
                            text-decoration:none;
                       ">
                        Editar
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div style="
            background:white;
            padding:20px;
            border-radius:10px;
        ">
            No existen clientes registrados.
        </div>

    @endforelse

</div>

@endsection