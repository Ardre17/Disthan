<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:11px;
    color:#222;
}

h1{
    text-align:center;
    margin-bottom:5px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th{
    background:#1e3a8a;
    color:white;
    padding:6px;
    font-size:10px;
}

td{
    border:1px solid #ddd;
    padding:6px;
    font-size:10px;
}

.section{
    margin-top:18px;
}

</style>

</head>

<body>

<h1>DETALLE DE ENCOMIENDA</h1>

<table>

<tr>

<td><strong>Orden</strong></td>

<td>{{ $order->numero_orden }}</td>

<td><strong>Fecha</strong></td>

<td>{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d/m/Y') }}</td>

</tr>

<tr>

<td><strong>Cliente</strong></td>

<td colspan="3">

{{ $order->client->razon_social }}

</td>

</tr>

<tr>

<td><strong>Tipo</strong></td>

<td>{{ $order->tipo_orden }}</td>

<td><strong>Estado</strong></td>

<td>{{ $order->estado }}</td>

</tr>

</table>

<div class="section">

<h3>Productos enviados</h3>

<table>

<thead>

<tr>

<th>Producto</th>

<th>Cantidad</th>

<th>Peso Unit.</th>

<th>Peso Total</th>

</tr>

</thead>

<tbody>

@php

$totalPeso=0;

$totalUnidades=0;

@endphp

@foreach($order->details as $item)

@php

$peso=$item->cantidad_despachada*($item->product->peso/1000);

$totalPeso+=$peso;

$totalUnidades+=$item->cantidad_despachada;

@endphp

<tr>

<td>{{ $item->product->nombre }}</td>

<td align="center">{{ $item->cantidad_despachada }}</td>

<td align="center">

{{ number_format($item->product->peso/1000,3) }} kg

</td>

<td align="center">

{{ number_format($peso,2) }} kg

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="section">

<h3>Bultos</h3>

<table>

<thead>

<tr>

<th>Bulto</th>

<th>Contenido</th>

<th>Peso</th>

</tr>

</thead>

<tbody>

@foreach($order->bultos as $bulto)

<tr>

<td width="18%">

{{ $bulto->nombre }}

</td>

<td>

@foreach($bulto->detalles as $detalle)

• {{ $detalle->product->nombre }}

x {{ $detalle->cantidad }}

<br>

@endforeach

</td>

<td width="18%" align="center">

{{ number_format($bulto->peso_total,2) }} kg

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="section">

<table>

<tr>

<td><strong>Productos diferentes</strong></td>

<td>{{ $order->details->count() }}</td>

</tr>

<tr>

<td><strong>Total unidades</strong></td>

<td>{{ $totalUnidades }}</td>

</tr>

<tr>

<td><strong>Total bultos</strong></td>

<td>{{ $order->bultos->count() }}</td>

</tr>

<tr>

<td><strong>Peso total</strong></td>

<td>{{ number_format($totalPeso,2) }} kg</td>

</tr>

</table>

</div>

</body>

</html>