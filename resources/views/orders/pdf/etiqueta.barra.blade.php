<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; }
    body {
        font-family: DejaVu Sans, sans-serif;
        color: #000;
        margin: 0;
        padding: 6mm;
        text-align: center;
    }
    .nombre {
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 3px;
    }
    .cpc {
        font-size: 10px;
        margin-bottom: 8px;
    }
    .barcode-wrap {
        margin: 6px 0;
    }
    .barcode-wrap img {
        max-width: 100%;
        height: auto;
    }
    .sin-codigo {
        font-size: 10px;
        color: #000;
        border: 1px dashed #000;
        padding: 10px;
        margin: 8px 0;
    }
    .info {
        margin-top: 8px;
        font-size: 10px;
        line-height: 1.6;
    }
    .info strong {
        font-weight: bold;
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
        <div><strong>Lote:</strong> {{ $item->lote ?? '—' }}</div>
        <div><strong>Fecha:</strong> {{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '—' }}</div>
        <div><strong>Cajas:</strong> {{ $cajas }}</div>
        <div><strong>Unidades:</strong> {{ $item->cantidad_despachada }}@if($sueltas > 0) ({{ $sueltas }} sueltas)@endif</div>
    </div>

</body>
</html>