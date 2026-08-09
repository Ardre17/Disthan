<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>

@page {
    size: 90mm 70mm;
    margin: 3mm;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html,
body {
    width: 100%;
    height: 100%;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 8px;
    color: #000;
    line-height: 1.25;
}

/* CONTENEDOR PRINCIPAL */
.etiqueta {
    width: 100%;
    border: 1px solid #000;
    padding: 5px;
}

/* CABECERA */
.cabecera {
    width: 100%;
    border-bottom: 1px solid #000;
    padding-bottom: 4px;
    margin-bottom: 5px;
}

.cabecera table {
    width: 100%;
    border-collapse: collapse;
}

.empresa {
    font-size: 9px;
    font-weight: bold;
}

.orden {
    text-align: right;
    font-size: 7px;
    font-weight: bold;
}

/* PRODUCTO */
.producto {
    text-align: center;
    font-size: 11px;
    font-weight: bold;
    line-height: 1.2;
    margin-bottom: 2px;
}

.sku {
    text-align: center;
    font-size: 7px;
    margin-bottom: 5px;
}

/* CANTIDAD */
.cantidad-box {
    width: 100%;
    border: 1px solid #000;
    text-align: center;
    padding: 5px 0;
    margin-bottom: 6px;
}

.cantidad {
    font-size: 22px;
    font-weight: bold;
    line-height: 1;
}

.cantidad-label {
    font-size: 7px;
    margin-top: 2px;
    text-transform: uppercase;
}

/* INFORMACIÓN */
.info {
    width: 100%;
    border-collapse: collapse;
}

.info td {
    border-bottom: 0.5px solid #999;
    padding: 3px 2px;
    vertical-align: middle;
}

.info tr:last-child td {
    border-bottom: none;
}

.info .label {
    width: 32%;
    font-weight: bold;
    font-size: 7px;
}

.info .valor {
    width: 68%;
    font-size: 8px;
    font-weight: bold;
    text-align: right;
}

/* VENCIMIENTO */
.vencimiento {
    font-size: 9px !important;
}

/* PIE */
.pie {
    border-top: 1px solid #000;
    margin-top: 5px;
    padding-top: 3px;
    text-align: center;
    font-size: 6px;
}

</style>
</head>

<body>

@php

    $ahora = \Carbon\Carbon::now('America/Lima');

    $cliente = $item->order->client?->razon_social ?? '—';

    $producto = $item->product->nombre ?? '—';

    $sku = $item->product->sku ?? '—';

    $cantidad = $item->cantidad_despachada ?? 0;

    $peso = (
        ($item->product->peso ?? 0) *
        $cantidad
    ) / 1000;

    /*
    |--------------------------------------------------------------------------
    | LOTE
    |--------------------------------------------------------------------------
    */

    $lote = $item->lote
        ?? $item->product->lote
        ?? '—';

    /*
    |--------------------------------------------------------------------------
    | FECHA DE VENCIMIENTO
    |--------------------------------------------------------------------------
    */

    $fv = $item->fecha_vencimiento
        ?? $item->product->fecha_vencimiento;

@endphp


<div class="etiqueta">

    {{-- CABECERA --}}
    <div class="cabecera">

        <table>

            <tr>

                <td class="empresa">
                    VALLE FERTIL SAC
                </td>

                <td class="orden">
                    ORDEN #{{ $item->order->numero_orden }}
                </td>

            </tr>

        </table>

    </div>


    {{-- PRODUCTO --}}
    <div class="producto">

        {{ $producto }}

    </div>


    {{-- SKU --}}
    <div class="sku">

        SKU:
        <strong>{{ $sku }}</strong>

    </div>


    {{-- CANTIDAD --}}
    <div class="cantidad-box">

        <div class="cantidad">

            {{ number_format($cantidad, 0) }}

        </div>

        <div class="cantidad-label">

            UNIDADES

        </div>

    </div>


    {{-- INFORMACIÓN --}}
    <table class="info">

        <tr>

            <td class="label">
                CLIENTE
            </td>

            <td class="valor">
                {{ $cliente }}
            </td>

        </tr>


        <tr>

            <td class="label">
                LOTE
            </td>

            <td class="valor">
                {{ $lote }}
            </td>

        </tr>


        <tr>

            <td class="label">
                VENCIMIENTO
            </td>

            <td class="valor vencimiento">

                {{ $fv
                    ? \Carbon\Carbon::parse($fv)->format('d/m/Y')
                    : '—'
                }}

            </td>

        </tr>


        <tr>

            <td class="label">
                PESO APROX.
            </td>

            <td class="valor">

                {{ number_format($peso, 3) }} kg

            </td>

        </tr>

    </table>


    {{-- PIE --}}
    <div class="pie">

        Generado:
        {{ $ahora->format('d/m/Y H:i') }}

    </div>

</div>

</body>
</html>