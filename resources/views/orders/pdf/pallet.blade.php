<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
    color:#000;
}

h2{
    text-align:center;
    margin-bottom:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f2f2f2;
}

th,
td{
    border:1px solid #000;
    padding:6px;
    text-align:center;
    font-size:10px;
}

.info{
    width:100%;
    margin-bottom:15px;
}

.info td{
    border:none;
    padding:3px;
    text-align:left;
    font-size:11px;
}

.codigo{
    text-align:center;
    margin-top:20px;
}

.sscc{
    font-size:18px;
    font-weight:bold;
    letter-spacing:2px;
    margin-bottom:10px;
}

</style>

</head>

<body>

<h2>HOJA LOGÍSTICA DE PALETA</h2>

<table class="info">

<tr>

<td><strong>Cliente:</strong> {{ $order->client->razon_social }}</td>

<td><strong>Paleta:</strong> {{ $paleta }}</td>

</tr>

<tr>

<td><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</td>

<td><strong>SSCC:</strong> {{ $sscc }}</td>

</tr>

</table>

<table>

<thead>

<tr>

<th>DUM13</th>

<th>DUM14</th>

<th>DESCRIPCIÓN</th>

<th>UXB</th>

<th>BULTOS</th>

</tr>

</thead>

<tbody>

@foreach($items as $item)

<tr>

<td>{{ $item->product->barcode }}</td>

<td>{{ $item->product->box_barcode }}</td>

<td style="text-align:left;">
{{ $item->product->nombre }}
</td>

<td>

{{ $item->product->cantidad_por_caja }}

</td>

<td>

{{ ceil($item->cantidad_despachada / max(1,$item->product->cantidad_por_caja)) }}

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="codigo">

<div class="sscc">

{{ $sscc }}

</div>

<img src="{{ $barcode }}">

</div>

</body>

</html>