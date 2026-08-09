<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<style>

@page {
    size: 100mm 70mm;
    margin: 2mm;
}

* {
    box-sizing: border-box;
}

html,
body {
    width: 100%;
    margin: 0;
    padding: 0;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 7px;
    color: #000;
}

/* =====================================================
   ETIQUETA
   ===================================================== */

.etiqueta {
    width: 100%;
    border: 1px solid #000;
    padding: 3px;
}


/* =====================================================
   CABECERA
   ===================================================== */

.cabecera {
    width: 100%;
    border-bottom: 1px solid #000;
    padding-bottom: 3px;
    margin-bottom: 4px;
}

.cabecera table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.cabecera td {
    padding: 0;
    border: none;
}

.empresa {
    width: 60%;
    font-size: 8px;
    font-weight: bold;
    text-align: left;
}

.orden {
    width: 40%;
    text-align: right;
    font-size: 6px;
    font-weight: bold;
    white-space: nowrap;
}


/* =====================================================
   CLIENTE
   ===================================================== */

.cliente-label {
    font-size: 5.5px;
    font-weight: bold;
    margin-bottom: 1px;
}

.cliente {
    width: 100%;
    font-size: 7px;
    font-weight: bold;
    margin-bottom: 4px;
    word-break: break-word;
}


/* =====================================================
   BULTO
   ===================================================== */

.bulto-box {
    width: 100%;
    border: 1px solid #000;
    text-align: center;
    padding: 4px;
    margin-bottom: 4px;
}

.bulto-nombre {
    font-size: 16px;
    font-weight: bold;
    line-height: 1;
}

.bulto-total {
    font-size: 6px;
    margin-top: 2px;
}


/* =====================================================
   PRODUCTOS
   ===================================================== */

.productos {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}

.productos th,
.productos td {
    padding: 2px 3px;
    line-height: 1.05;
}

.productos th {
    border-bottom: 1px solid #000;
    font-size: 5.5px;
    font-weight: bold;
    text-transform: uppercase;
}

.productos td {
    border-bottom: 0.5px solid #777;
    font-size: 6.5px;
    vertical-align: middle;
}

.productos .producto {
    width: 76%;
    text-align: left;
    font-weight: bold;
    white-space: normal;
    overflow-wrap: break-word;
    word-break: break-word;
}

.productos .cantidad {
    width: 24%;
    text-align: right;
    font-weight: bold;
    white-space: nowrap;
}


/* =====================================================
   RESUMEN
   ===================================================== */

.resumen {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    margin-top: 4px;
}

.resumen td {
    padding: 2px 3px;
    border-top: 1px solid #000;
    font-size: 6.5px;
}

.resumen .label {
    width: 70%;
    font-weight: bold;
}

.resumen .valor {
    width: 30%;
    text-align: right;
    font-weight: bold;
    white-space: nowrap;
}


/* =====================================================
   PIE
   ===================================================== */

.pie {
    margin-top: 3px;
    padding-top: 2px;
    border-top: 1px solid #000;
    text-align: center;
    font-size: 5px;
}

</style>

</head>

<body>

@php

    $order = $bulto->order;

    $cliente = $order->client?->razon_social ?? '—';

    $totalBultos = $order->bultos->count();

    /*
     * Obtener número del bulto.
     *
     * Ejemplo:
     * Bulto 1
     * Bulto 2
     */

    $numeroBulto = null;

    if (preg_match('/(\d+)/', $bulto->nombre, $matches)) {
        $numeroBulto = (int) $matches[1];
    }

    $numeroBulto = $numeroBulto ?? $bulto->id;

    $totalUnidades = $bulto->detalles->sum('cantidad');

@endphp


<div class="etiqueta">


    {{-- =================================================
         CABECERA
         ================================================= --}}

    <div class="cabecera">

        <table>

            <tr>

                <td class="empresa">
                    VALLE FERTIL SAC
                </td>

                <td class="orden">
                    ORDEN #{{ $order->numero_orden }}
                </td>

            </tr>

        </table>

    </div>


    {{-- =================================================
         CLIENTE
         ================================================= --}}

    <div class="cliente-label">
        CLIENTE
    </div>

    <div class="cliente">
        {{ $cliente }}
    </div>


    {{-- =================================================
         IDENTIFICACIÓN DEL BULTO
         ================================================= --}}

    <div class="bulto-box">

        <div class="bulto-nombre">
            BULTO {{ $numeroBulto }}
        </div>

        <div class="bulto-total">
            Bulto {{ $numeroBulto }} de {{ $totalBultos }}
        </div>

    </div>


    {{-- =================================================
         PRODUCTOS
         ================================================= --}}

    <table class="productos">

        <thead>

            <tr>

                <th class="producto">
                    PRODUCTO
                </th>

                <th class="cantidad">
                    CANT.
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($bulto->detalles as $detalle)

                <tr>

                    <td class="producto">
                        {{ $detalle->product->nombre ?? 'Producto' }}
                    </td>

                    <td class="cantidad">
                        {{ number_format($detalle->cantidad, 0) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="2" style="text-align:center;">
                        Sin productos
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =================================================
         RESUMEN
         ================================================= --}}

    <table class="resumen">

        <tr>

            <td class="label">
                TOTAL UNIDADES
            </td>

            <td class="valor">
                {{ number_format($totalUnidades, 0) }}
            </td>

        </tr>

        <tr>

            <td class="label">
                PESO
            </td>

            <td class="valor">
                {{ number_format($bulto->peso_total ?? 0, 3) }} kg
            </td>

        </tr>

    </table>


    {{-- =================================================
         PIE
         ================================================= --}}

    <div class="pie">
        Orden {{ $order->numero_orden }}
    </div>


</div>

</body>

</html>