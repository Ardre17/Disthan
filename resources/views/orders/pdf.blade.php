<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>

@page { margin:20px 25px; }

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
    color:#1f2937;
}

.header{
    display:flex;
    justify-content:space-between;
    border-bottom:4px solid #111827;
    margin-bottom:15px;
    padding-bottom:10px;
}

.title{
    font-size:20px;
    font-weight:bold;
}

.box{
    background:#111827;
    color:white;
    padding:8px 15px;
    border-radius:6px;
    text-align:center;
}

.section{
    margin-bottom:15px;
}

.products{
    width:100%;
    border-collapse:collapse;
}

.products th{
    background:#111827;
    color:white;
    padding:6px;
    font-size:10px;
}

.products td{
    padding:6px;
    border-bottom:1px solid #e5e7eb;
    font-size:10px;
}

.products td:first-child{
    text-align:left;
}

.paleta-header{
    background:#e2e8f0;
    font-weight:bold;
    padding:6px;
}

.summary{
    margin-top:20px;
    border:1px solid #ddd;
    padding:10px;
    border-radius:8px;
}

</style>

</head>

<body>

<!-- HEADER -->

<div class="header">

    <div>
        <div class="title">DISTAN</div>
        <div>Orden: {{ $order->numero_orden }}</div>
        <div>Cliente: {{ $order->client?->razon_social }}</div>
    </div>

    <div class="box">
        {{ $order->tipo_orden }}
    </div>

</div>
{{-- RESUMEN POR PALETA --}}
<div style="padding:0 20px; margin-bottom:15px;">

    <table style="width:100%; border-collapse:collapse;">

            <thead>
            <tr style="background:#1e3a8a; color:white;">
                <th>Paleta</th>
                <th>Producto</th>
                <th>Vencimiento</th> <!-- 👈 NUEVO -->
                <th>Solicitado</th>
                <th>Despachado</th>
                <th>Estado</th>
            </tr>
            </thead>

        <tbody>


@foreach($order->details as $item)
@php
    $fecha = $item->fecha_vencimiento ?? $item->product->fecha_vencimiento;
@endphp
@php
    if ($item->cantidad_despachada == 0) {
        $estado = 'NO ENVIADO';
        $color = '#dc2626';
        $bg = '#fee2e2';
    }
    elseif ($item->cantidad_despachada < $item->cantidad_solicitada) {
        $estado = 'PARCIAL';
        $color = '#d97706';
        $bg = '#fef3c7';
    }
    else {
        $estado = 'COMPLETO';
        $color = '#059669';
        $bg = '#ecfdf5';
    }
@endphp

<tr style="background:{{ $bg }};">
    <td>{{ $item->paleta }}</td>
    <td>{{ $item->product->nombre }}</td>
    <td style="color:#0369a1;">
    {{ $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y') : '—' }}</td>
    <td>{{ $item->cantidad_solicitada }}</td>
    <td>{{ $item->cantidad_despachada }}</td>
    <td style="color:{{ $color }}; font-weight:bold;">
        {{ $estado }}
    </td>
</tr>

@endforeach

</tbody>

    </table>

</div>

<!-- AGRUPACIÓN POR PALETAS -->

@php
$paletas = $order->details->groupBy(function($item){
    return $item->paleta ?: 'SIN PALETA';
});
@endphp

@foreach($paletas as $paleta => $items)

<!-- CABECERA PALETA -->

<div class="paleta-header">
    PALETA: {{ $paleta }}
</div>

<table class="products">

<thead>
    <tr style="background:#111827; color:white;">
    <th>Producto</th>
    <th>Solicitado</th>
    <th>Despachado</th>
    <th>Peso (kg)</th>
    <th>Subtotal</th>
</tr>
</thead>

<tbody>

@php
$pesoPaleta = 0;
$totalPaleta = 0;
@endphp

@foreach($items as $detail)

@php
$peso = $detail->cantidad_despachada * $detail->product->peso;
$pesoPaleta += $peso;
$totalPaleta += $detail->cantidad_despachada;
@endphp

<tr>

<td>{{ $detail->product?->nombre }}</td>

<td>{{ $detail->cantidad_solicitada }}</td>

<td>{{ $detail->cantidad_despachada }}</td>

<td>{{ number_format($peso / 1000,2) }}</td>

<td>S/ {{ number_format($detail->subtotal,2) }}</td>

</tr>

@endforeach

<!-- RESUMEN POR PALETA -->

<tr>
<td colspan="6" style="text-align:right; font-weight:bold;">

Total Paleta: 
{{ number_format($pesoPaleta / 1000,2) }} kg | 
Unidades: {{ $totalPaleta }}

</td>
</tr>

</tbody>

</table>

@endforeach

{{-- PRODUCTOS NO ENVIADOS --}}
@if(!empty($faltantes))

<div style="
    padding:0 20px;
    margin-top:10px;
    font-size:10px;
">

    <strong style="color:#dc2626;">
        ❌ Productos no enviados:
    </strong>

    <table style="
        width:100%;
        margin-top:5px;
        border-collapse:collapse;
    ">

        <thead>
            <tr style="background:#fecaca;">
                <th style="padding:5px; text-align:left;">Producto</th>
                <th style="padding:5px; text-align:center;">Cantidad faltante</th>
            </tr>
        </thead>

        <tbody>

        @foreach($faltantes as $f)

            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:5px;">
                    {{ $f['producto'] }}
                </td>

                <td style="padding:5px; text-align:center;">
                    {{ $f['faltante'] }}
                </td>
            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endif

<!-- RESUMEN GENERAL -->

<div class="summary">

@php
$pesoTotal = $order->details->sum(function($d){
    return $d->cantidad_despachada * $d->product->peso;
});
@endphp


<p><strong>Total Orden:</strong> {{ number_format($pesoTotal / 1000,2) }} kg</p>

<p><strong>Total Productos:</strong> {{ $order->details->sum('cantidad_despachada') }}</p>

<p><strong>Total S/:</strong> {{ number_format($order->total,2) }}</p>

</div>

</body>
</html>