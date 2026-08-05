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
    }
    .barcode-wrap img {
        max-width: 100%;
        height: auto;
    }
    .sin-codigo {
        font-size: 10px;
        margin-top: 8px;
    }
    .info {
        margin-top: 8px;
        font-size: 11px;
        line-height: 1.7;
    }
</style>
</head>
<body>

    <div class="nombre">{{ $item->product->nombre }}</div>
    <div class="cpc">{{ $cantidadPorCaja }} unid. por caja</div>

    <div class="barcode-wrap">
        @if($barcode)
            <img src="{{ $barcode }}">
        @else
            <div class="sin-codigo">Sin código de caja registrado</div>
        @endif
    </div>

    <div class="info">
        <div>Lote: {{ $item->lote ?? '—' }}</div>
        <div>Fecha: {{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '—' }}</div>
        <div>Cajas: {{ $cajas }}</div>
        <div>Unidades: {{ $item->cantidad_despachada }}@if($sueltas > 0) ({{ $sueltas }} sueltas)@endif</div>
    </div>

</body>
</html>