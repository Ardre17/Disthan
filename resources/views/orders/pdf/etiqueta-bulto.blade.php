<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<style>
@page { size: 100mm 70mm; margin: 2mm; }
* { box-sizing: border-box; }
html, body { width: 100%; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, sans-serif; font-size: 7px; color: #172033; }
.etiqueta {
    width: 100%; border: 1.5px solid #22b86b; border-radius: 7px;
    padding: 5px 6px 4px; overflow: hidden;
}
.cabecera { width: 100%; margin-bottom: 3px; }
.cabecera table { width: 100%; border-collapse: collapse; }
.cabecera td { padding: 0; border: none; vertical-align: middle; }
.empresa { width: 58%; font-size: 7px; font-weight: bold; text-align: left; }
.orden { width: 42%; font-size: 6px; font-weight: bold; text-align: right; white-space: nowrap; color: #42516b; }
.cliente { width: 100%; margin: 0 0 4px; text-align: center; font-size: 7px; font-weight: bold; line-height: 1.1; overflow-wrap: break-word; }
.cliente-label { color: #52627a; font-size: 5px; font-weight: bold; }
.bulto-box { width: 100%; padding: 1px 2px 3px; margin-bottom: 2px; }
.bulto-cabecera { width: 100%; border-collapse: collapse; }
.bulto-cabecera td { border: none; padding: 0; vertical-align: middle; }
.bulto-indice { width: 16%; text-align: center; }
.bulto-numero { display: inline-block; min-width: 20px; padding: 4px 5px; border-radius: 5px; background: #ddf8e8; color: #16864b; font-size: 15px; font-weight: bold; line-height: 1; }
.bulto-nombre { text-align: left; font-size: 15px; font-weight: bold; color: #172033; line-height: 1; }
.bulto-total { text-align: right; color: #52627a; font-size: 5.5px; padding-top: 2px; }
.peso-box { text-align: center; margin: 1px 0 3px; }
.peso-numero { display: inline-block; min-width: 34mm; padding: 4px 7px; border-radius: 7px; background: #e0ecff; color: #2459d3; font-size: 17px; font-weight: bold; line-height: 1; }
.peso-unidad { font-size: 10px; font-weight: bold; }
.total-box { text-align: center; margin: 0 0 3px; color: #52627a; font-size: 6px; }
.productos { width: 100%; table-layout: fixed; border-collapse: collapse; margin-top: 1px; }
.productos th, .productos td { padding: 3px; line-height: 1.1; overflow: hidden; border: none; }
.productos thead { background: #eef2f8; }
.productos th { font-size: 6.5px; font-weight: bold; text-align: left; color: #52627a; }
.productos td { font-size: 7px; border-bottom: 1px solid #e4eaf2; vertical-align: middle; }
.productos .producto { width: 78%; text-align: left; font-weight: bold; white-space: normal; overflow-wrap: break-word; }
.productos .cantidad { width: 22%; text-align: right; font-weight: bold; white-space: nowrap; }
.codigo-barras { text-align: center; margin-top: 4px; padding-top: 1px; }
.barras { height: 13mm; width: 76%; margin: 0 auto 2px; white-space: nowrap; overflow: hidden; font-size: 0; line-height: 0; }
.barras span { display: inline-block; height: 13mm; background: #111; vertical-align: top; }
.codigo-texto { font-size: 7px; font-weight: bold; color: #42516b; text-align: center; overflow-wrap: break-word; }
.pie { display: none; }
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

    // Identificador impreso del bulto.
    $codigoBulto = 'ORD' . str_pad((string) $order->id, 6, '0', STR_PAD_LEFT) . '-B' . $numeroBulto;

    // Patrón gráfico de barras para acompañar al código impreso.
    $patronBarras = [];
    foreach (str_split($codigoBulto) as $caracter) {
        $valor = ord($caracter);
        $patronBarras[] = 1 + ($valor % 3);
        $patronBarras[] = 1;
        $patronBarras[] = 1 + (($valor >> 2) % 3);
        $patronBarras[] = 1;
    }

@endphp


<div class="etiqueta">

    <div class="cabecera">
        <table>
            <tr>
                <td class="empresa">VALLE FERTIL SAC</td>
                <td class="orden">ORDEN #{{ $order->numero_orden }}</td>
            </tr>
        </table>
    </div>

    <div class="cliente">
        <span class="cliente-label">CLIENTE: </span>{{ $cliente }}
    </div>

    <div class="bulto-box">
        <table class="bulto-cabecera">
            <tr>
                <td class="bulto-indice"><span class="bulto-numero">{{ $numeroBulto }}</span></td>
                <td class="bulto-nombre">Bulto {{ $numeroBulto }}</td>
            </tr>
        </table>
        <div class="bulto-total">Bulto {{ $numeroBulto }} de {{ $totalBultos }}</div>
    </div>

    <div class="peso-box">
        <span class="peso-numero">{{ number_format($bulto->peso_total ?? 0, 2) }} <span class="peso-unidad">kg</span></span>
    </div>

    <div class="total-box">
        {{ $bulto->detalles->count() }} {{ $bulto->detalles->count() == 1 ? 'producto' : 'productos' }}
    </div>

    <table class="productos">
        <thead>
            <tr>
                <th class="producto">Producto</th>
                <th class="cantidad">Cant.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bulto->detalles as $detalle)
                <tr>
                    <td class="producto">{{ $detalle->product->nombre ?? 'Producto' }}</td>
                    <td class="cantidad">x {{ number_format($detalle->cantidad, 0) }}</td>
                </tr>
            @empty
                <tr><td colspan="2" style="text-align:center;">Sin productos</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="codigo-barras">
        <div class="barras">
            @foreach($patronBarras as $ancho)
                <span style="width: {{ $ancho * 0.45 }}mm; margin-right: 0.25mm;"></span>
            @endforeach
        </div>
        <div class="codigo-texto">Código: {{ $codigoBulto }}</div>
    </div>

</div>

</body>

</html>