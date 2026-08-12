<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: DejaVu Sans, sans-serif;
        color: #000;
        background: #fff;
        width: 100%;
        text-align: center;
        padding: 4mm;
    }
    .nombre {
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .cpc {
        font-size: 11px;
        margin-top: 3px;
    }
    .barcode-wrap {
    margin-top: 8px;
    margin-bottom: 10px;
    width: 100%;
    text-align: center;
}
.barcode-wrap img {
    display: block;
    width: 85%;
    height: auto;
    margin: 0 auto;
}
.barcode-texto {
    font-size: 11px;
    letter-spacing: 1px;
    margin-top: 8px;
    clear: both;
}
    .sin-codigo {
        font-size: 10px;
        margin-top: 8px;
    }
    .info-table {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .info-table td {
        font-size: 10px;
        text-align: center;
        vertical-align: top;
        padding: 0 2px;
    }
    .info-table .label {
        font-size: 8px;
        color: #000;
        text-transform: uppercase;
        letter-spacing: .3px;
        padding-bottom: 2px;
    }
</style>
</head>
<body>

    <div class="nombre">{{ $item->product->nombre }}</div>
    <div class="cpc">{{ $cantidadPorCaja }} unid. por caja</div>

    <div class="barcode-wrap">
        @if($barcode)
            <img src="{{ $barcode }}">
            <div class="barcode-texto">{{ $codigoMostrado }}</div>
        @else
            <div class="sin-codigo">Sin código de caja registrado</div>
        @endif
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Lote</td>
            <td class="label">Fecha</td>
            <td class="label">Cajas</td>
            <td class="label">Unidades</td>
        </tr>
        <tr>
            <td>{{ $item->lote ?? '—' }}</td>
            <td>{{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '—' }}</td>
            <td>{{ $cajas }}</td>
            <td>{{ $item->cantidad_despachada }}@if($sueltas > 0)<br><span style="font-size:8px;">({{ $sueltas }} sueltas)</span>@endif</td>
        </tr>
    </table>

</body>
</html>