@extends('layouts.app')

@section('content')

<div style="
    background:white;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
">

    <form method="GET">

        <div style="
            display:grid;
            grid-template-columns:1fr 1fr 1fr auto;
            gap:10px;
        ">

            <div>
                <label>Desde</label>

                <input
                    type="date"
                    name="fecha_inicio"
                    value="{{ request('fecha_inicio') }}"
                    style="
                        width:100%;
                        padding:10px;
                        border:1px solid #ddd;
                        border-radius:8px;
                    ">
            </div>

            <div>
                <label>Hasta</label>

                <input
                    type="date"
                    name="fecha_fin"
                    value="{{ request('fecha_fin') }}"
                    style="
                        width:100%;
                        padding:10px;
                        border:1px solid #ddd;
                        border-radius:8px;
                    ">
            </div>

                <input type="text" name="cliente"
					placeholder="Buscar cliente..."
					value="{{ request('cliente') }}">

            <div style="
                display:flex;
                align-items:flex-end;
            ">

                <button
                    type="submit"
                    style="
                        background:#2563eb;
                        color:white;
                        border:none;
                        padding:12px 20px;
                        border-radius:8px;
                        cursor:pointer;
                    ">
                    Buscar
                </button>

            </div>

        </div>

    </form>

</div>

<div style="padding:30px;">

    <h1>📚 Historial de Órdenes</h1>

   <div style="
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:20px;
">

@foreach($orders as $order)
@php
    $totalItems = $order->details->count();

    $completados = $order->details->where('estado_item', 'COMPLETO')->count();

    $porcentaje = $totalItems > 0 
        ? ($completados / $totalItems) * 100 
        : 0;
@endphp
<div style="
    background:white;
    padding:20px;
    border-radius:14px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    position:relative;
">

    <!-- ESTADO -->
    <div style="
        position:absolute;
        top:15px;
        right:15px;
        padding:5px 10px;
        border-radius:20px;
        font-size:12px;
        color:white;
        background:
        {{ $order->estado == 'COMPLETO' ? '#16a34a' :
           ($order->estado == 'PARCIAL' ? '#f59e0b' : '#dc2626') }};
    ">
        {{ $order->estado }}
    </div>

    <!-- NUMERO -->
    <h3 style="margin-bottom:5px;">
        📋 {{ $order->numero_orden }}
    </h3>

    <!-- CLIENTE -->
    <p style="color:#64748b;font-size:14px;">
        {{ $order->client->razon_social ?? 'Sin cliente' }}
    </p>

    <!-- INFO -->
    <div style="margin-top:10px;font-size:14px;">

        <p>📦 Tipo: {{ $order->tipo_orden }}</p>

        <p>📅 Fecha: {{ $order->fecha_pedido }}</p>

        <p>💰 Total: S/ {{ number_format($order->total,2) }}</p>

    </div>
    <div style="margin-top:15px;">

    <!-- TEXTO -->
    <div style="
        display:flex;
        justify-content:space-between;
        font-size:13px;
        margin-bottom:5px;
        color:#64748b;
    ">
        <span>Progreso</span>
        <span>{{ round($porcentaje) }}%</span>
    </div>

    <!-- BARRA -->
    <div style="
        width:100%;
        height:10px;
        background:#e5e7eb;
        border-radius:10px;
        overflow:hidden;
    ">

        <div style="
            width:{{ $porcentaje }}%;
            height:100%;
            background:
            {{ $porcentaje == 100 ? '#16a34a' :
               ($porcentaje > 40 ? '#f59e0b' : '#dc2626') }};
            transition:0.3s;
        ">
        </div>

    </div>

    <!-- DETALLE -->
    <div style="
        font-size:12px;
        margin-top:5px;
        color:#64748b;
    ">
        {{ $completados }} / {{ $totalItems }} productos completados
    </div>

</div>
    <!-- BOTONES -->
    <div style="
        display:flex;
        gap:10px;
        margin-top:15px;
    ">

        <a href="{{ route('orders.edit',$order) }}" style="
            flex:1;
            text-align:center;
            background:#2563eb;
            color:white;
            padding:8px;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
        ">
            ✏️ Editar
        </a>

        <a href="{{ route('orders.operario',$order) }}" style="
            flex:1;
            text-align:center;
            background:#16a34a;
            color:white;
            padding:8px;
            border-radius:8px;
            text-decoration:none;
            font-size:14px;
        ">
            🚀 Operario
        </a>

    </div>

    <!-- PDF -->
    <a href="{{ route('orders.pdf',$order) }}" style="
        display:block;
        margin-top:10px;
        text-align:center;
        background:#64748b;
        color:white;
        padding:8px;
        border-radius:8px;
        text-decoration:none;
        font-size:13px;
    ">
        📄 Ver PDF
    </a>

</div>

@endforeach

</div>
<div style="margin-top:20px;">
    {{ $orders->links() }}
</div>

@endsection