@extends('layouts.app')

@section('content')
<style>

.export-card{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
    margin-bottom:20px;
}

.export-title{
    font-size:28px;
    font-weight:700;
    color:#0f172a;
}

.export-section{
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:15px;
    margin-bottom:20px;
}

.pallet-card{
    border:1px solid #cbd5e1;
    border-radius:10px;
    padding:15px;
    margin-bottom:15px;
    background:#f8fafc;
}

</style>
<div class="container-fluid py-3">
<h2>🚢 Exportación</h2>

<hr>

<h4>Orden: {{ $order->numero_orden }}</h4>

<p>
    <strong>Cliente:</strong>
    {{ $order->client->razon_social }}
</p>

<p>
    <strong>Fecha:</strong>
    {{ $order->fecha_pedido }}
</p>

<p>
    <strong>Estado:</strong>
    {{ $order->estado }}
</p>

<hr>
<h3>Agregar producto</h3>

<form method="POST"
      action="{{ route('orders.addProduct',$order) }}">

    @csrf

    <p>

        Producto
    <select name="order_detail_id" required>

    <option value="">
        Seleccione un producto
    </option>

    @foreach($order->details as $detalle)

        @php
            $enPallets = $detalle->palletDetails->sum('cantidad');
            $pendiente = $detalle->cantidad_solicitada - $enPallets;
        @endphp

        @if($pendiente > 0)

            <option value="{{ $detalle->id }}">

                {{ $detalle->product->nombre }}
                ({{ $pendiente }} pendientes)

            </option>

        @endif

    @endforeach

</select>

    </p>

    <p>

        Cantidad

        <input
            type="number"
            name="cantidad_solicitada"
            required>

    </p>

    <p>

        Precio

        <input
            type="number"
            step="0.01"
            name="precio_unitario"
            required>

    </p>

    <button>

        Agregar

    </button>

</form>

<hr>
<h3>Productos</h3>

<table border="1" cellpadding="5">

<thead>

<tr>

<th>Producto</th>

<th>Solicitado</th>

<th>Despachado</th>

<th>Peso</th>

<th>Subtotal</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@foreach($order->details as $item)

<tr>

<td>

{{ $item->product->nombre }}

</td>

<td>

{{ $item->cantidad_solicitada }}

</td>

<td>

{{ $item->cantidad_despachada }}

</td>

<td>

{{ number_format(($item->product->peso ?? 0)/1000,3) }} kg

</td>

<td>

S/

{{ number_format($item->subtotal,2) }}

</td>

<td>

Editar

Eliminar

</td>

</tr>

@endforeach

</tbody>

</table>
<hr>

<h3>Resumen</h3>

<p>

Productos:

{{ $order->details->count() }}

</p>

<p>

Subtotal:

S/

{{ number_format($order->subtotal,2) }}

</p>

<p>

IGV:

S/

{{ number_format($order->igv,2) }}

</p>

<p>

Total:

S/

{{ number_format($order->total,2) }}

</p>
<hr>

<a
    href="{{ route('orders.pdf',$order) }}"
    target="_blank">

    Ver PDF

</a>

@if($order->estado!='COMPLETO')

<form
    method="POST"
    action="{{ route('orders.cerrar',$order) }}">

    @csrf

    <button>

        Cerrar Exportación

    </button>

</form>

@endif
<hr>

<h3>🟫 Pallets</h3>

<div>

    <p>
        Aquí se mostrarán los pallets creados para esta orden.
    </p>

    <form action="{{ route('exportacion.pallet.store', $order) }}" method="POST">

    @csrf

    <button type="submit">
        ➕ Crear Pallet
    </button>

</form>

</div>

@if($order->pallets->count())

    @foreach($order->pallets as $pallet)

        <fieldset style="margin-bottom:20px;">

            <legend>

                <strong>

                    {{ $pallet->codigo }}

                </strong>

            </legend>

            <table border="1" cellpadding="5" width="100%">

                <thead>

                    <tr>

                        <th>Producto</th>

                        <th>Cantidad</th>

                        <th>Peso</th>

                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pallet->detalles as $detalle)

                        <tr>

                            <td>

                                {{ $detalle->product->nombre }}

                            </td>

                            <td>

                                {{ $detalle->cantidad }}

                            </td>

                            <td>

                                {{ number_format(($detalle->product->peso * $detalle->cantidad)/1000,2) }} kg

                            </td>

                            <td>

                                Quitar

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                Este pallet aún no tiene productos.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <br>

           <form action="{{ route('exportacion.pallet.agregarProducto', $pallet) }}" method="POST">

    @csrf

    <select name="order_detail_id" required>

        <option value="">
            Seleccione un producto
        </option>

        @foreach($order->details as $detalle)

            @php

                $enPallets = $detalle->palletDetails->sum('cantidad');

                $pendiente = $detalle->cantidad_solicitada - $enPallets;

            @endphp

            @if($pendiente > 0)

                <option value="{{ $detalle->id }}">

                    {{ $detalle->product->nombre }}
                    ({{ $pendiente }} pendientes)

                </option>

            @endif

        @endforeach

    </select>

    <input
        type="number"
        name="cantidad"
        min="1"
        required
        placeholder="Cantidad">

    <button type="submit">

        Agregar

    </button>

</form>

        </fieldset>

    @endforeach

@else

    <p>

        No hay pallets creados.

    </p>

@endif
<h3>📦 Estado de Producción</h3>

<table border="1" cellpadding="5" width="100%">

    <thead>

        <tr>

            <th>Producto</th>

            <th>Solicitado</th>

            <th>En Pallets</th>

            <th>Pendiente</th>

            <th>Peso Total</th>

        </tr>

    </thead>

    <tbody>

        @foreach($order->details as $detalle)

            @php

                $enPallets = $detalle->cantidad_en_pallets ?? 0;

                $pendiente = $detalle->cantidad_solicitada - $enPallets;

                $peso = ($detalle->product->peso ?? 0) * $detalle->cantidad_solicitada;

            @endphp

            <tr>

                <td>{{ $detalle->product->nombre }}</td>

                <td align="center">

                    {{ $detalle->cantidad_solicitada }}

                </td>

                <td align="center">

                    {{ $enPallets }}

                </td>

                <td align="center">

                    {{ $pendiente }}

                </td>

                <td align="right">

                    {{ number_format($peso/1000,2) }} kg

                </td>

            </tr>

        @endforeach

    </tbody>

</table>
</div>

@endsection