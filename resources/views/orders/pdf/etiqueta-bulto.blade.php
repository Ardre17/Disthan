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
            font-size: 7px;
            color: #000;
        }

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

        /* CLIENTE */

        .cliente-label {
            font-size: 6px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .cliente {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 5px;
            word-break: break-word;
        }

        /* BULT0 */

        .bulto-box {
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
            margin-bottom: 6px;
        }

        .bulto-nombre {
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
        }

        .bulto-total {
            font-size: 7px;
            margin-top: 3px;
        }

        /* PRODUCTOS */

        .productos {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .productos th {
            border-bottom: 1px solid #000;
            padding: 3px 2px;
            font-size: 6px;
            text-align: left;
        }

        .productos td {
            border-bottom: 0.5px solid #999;
            padding: 3px 2px;
            vertical-align: middle;
            word-break: break-word;
        }

        .productos .producto {
            width: 78%;
            font-weight: bold;
        }

        .productos .cantidad {
            width: 22%;
            text-align: right;
            font-weight: bold;
        }

        /* RESUMEN */

        .resumen {
            margin-top: 6px;
            width: 100%;
            border-collapse: collapse;
        }

        .resumen td {
            padding: 3px 2px;
            border-top: 1px solid #000;
        }

        .resumen .label {
            font-weight: bold;
        }

        .resumen .valor {
            text-align: right;
            font-weight: bold;
        }

        /* PIE */

        .pie {
            margin-top: 5px;
            padding-top: 3px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 6px;
        }
    </style>
</head>

<body>

@php

    $order = $bulto->order;

    $cliente = $order->client?->razon_social ?? '—';

    $totalBultos = $order->bultos->count();

    /*
     * Intentamos obtener el número desde:
     * Bulto 1
     * Bulto 2
     * etc.
     */
    $numeroBulto = null;

    if (preg_match('/(\d+)/', $bulto->nombre, $matches)) {
        $numeroBulto = (int) $matches[1];
    }

    $numeroBulto = $numeroBulto ?? $bulto->id;

    $totalUnidades = $bulto->detalles->sum('cantidad');

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
                    ORDEN #{{ $order->numero_orden }}
                </td>
            </tr>
        </table>

    </div>


    {{-- CLIENTE --}}

    <div class="cliente-label">
        CLIENTE
    </div>

    <div class="cliente">
        {{ $cliente }}
    </div>


    {{-- IDENTIFICACIÓN DEL BULTO --}}

    <div class="bulto-box">

        <div class="bulto-nombre">
            BULTO {{ $numeroBulto }}
        </div>

        <div class="bulto-total">
            Bulto {{ $numeroBulto }} de {{ $totalBultos }}
        </div>

    </div>


    {{-- PRODUCTOS --}}

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


    {{-- RESUMEN --}}

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


    {{-- PIE --}}

    <div class="pie">
        Orden {{ $order->numero_orden }}
    </div>

</div>

</body>
</html>