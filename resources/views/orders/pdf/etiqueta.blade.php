<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>

@page {
    size: 90mm 70mm;
    margin: 1mm;
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
    overflow: hidden;
}

/* CONTENEDOR PRINCIPAL */
.etiqueta {
    width: 100%;
    max-width: 100%;
    border: 1px solid #000;
    padding: 5px;
    overflow: hidden;
    text-align: center;
}

/* TODAS LAS TABLAS */
table {
    width: 100%;
    max-width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}

/* CABECERA */
.cabecera {
    width: 100%;
    border-bottom: 1px solid #000;
    padding-bottom: 4px;
    margin-bottom: 5px;
}

.cabecera td {
    vertical-align: middle;
    overflow: hidden;
    word-wrap: break-word;
}

.empresa {
    width: 55%;
    font-size: 9px;
    font-weight: bold;
    text-align: left;
}

.orden {
    width: 45%;
    text-align: right;
    font-size: 6.5px;
    font-weight: bold;
    white-space: normal;
    word-break: break-word;
}

/* PRODUCTO */
.producto {
    width: 100%;
    text-align: center;
    font-size: 11px;
    font-weight: bold;
    line-height: 1.2;
    margin-bottom: 2px;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* SKU */
.sku {
    width: 100%;
    text-align: center;
    font-size: 7px;
    margin-bottom: 5px;
    word-wrap: break-word;
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
    margin-top: 4px;
}

.info .campo {
    text-align: center;
    padding: 2px 0;
    border-bottom: 0.5px solid #e2e8f0;
}

.info .label {
    font-size: 6px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    font-weight: 700;
    text-align: center;
}

.info .valor {
    font-size: 8px;
    font-weight: 700;
    color: #0f172a;
    text-align: center;
    width: 100%;
    word-break: break-word;
    overflow-wrap: break-word;
}

/* CLIENTE (más grande que el resto de campos) */
.cliente-valor {
    font-size: 16px !important;
    font-weight: 800 !important;
}

.info td {
    border-bottom: 0.5px solid #999;
    padding: 3px 2px;
    vertical-align: middle;
    overflow: hidden;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.info tr:last-child td {
    border-bottom: none;
}

/* VENCIMIENTO */
.vencimiento {
    font-size: 10px !important;
    font-weight: 800 !important;
}

</style>
</head>

<body>

@php

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
        <td colspan="2" class="campo">

            <div class="label">
                CLIENTE
            </div>

            <div class="valor cliente-valor">
                {{ $cliente }}
            </div>

        </td>
    </tr>



</table>

</div>

</body>
</html>