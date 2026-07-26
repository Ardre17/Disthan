<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

/* Etiqueta rectangular 9cm x 7cm */
@page {
    size: 90mm 70mm;
    margin: 3mm;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
    width: 100%;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 7px;
    color: #0f172a;
    line-height: 1.3;
}

.box {
    border: 1px solid #1e3a5f;
    border-radius: 3px;
    padding: 4px 7px;
    /* sin height fija: deja que el contenido defina el alto real
       y evita que DomPDF genere una segunda página en blanco */
}

/* Header */
.head {
    background: #1e3a5f;
    color: #fff;
    padding: 3px 6px;
    border-radius: 2px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}
.head-name {
    font-size: 9px;
    font-weight: 900;
    letter-spacing: .5px;
}
.head-doc {
    font-size: 6px;
    font-weight: 700;
    color: #93c5fd;
}

/* Cuerpo: 2 columnas para aprovechar el ancho del rectángulo */
.cuerpo {
    display: flex;
    gap: 8px;
}
.col-izq {
    width: 46%;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.col-der {
    width: 54%;
}

/* Producto */
.producto {
    font-size: 8px;
    font-weight: 800;
    color: #1e3a5f;
    margin-bottom: 2px;
    line-height: 1.25;
    text-align: center;
    width: 100%;
}

/* SKU */
.sku {
    font-size: 6px;
    color: #94a3b8;
    margin-bottom: 4px;
    text-align: center;
    width: 100%;
}

/* Cantidad */
.cant-box {
    background: #f0f7ff;
    border: 1px solid #bfdbfe;
    border-radius: 2px;
    text-align: center;
    padding: 4px 0;
    width: 90%;
    margin-top: 4px;
}
.cant-num {
    font-size: 18px;
    font-weight: 900;
    color: #1e3a5f;
    line-height: 1;
}
.cant-lbl {
    font-size: 6px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-top: 1px;
}

/* Filas de datos */
.row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    border-bottom: 0.5px solid #e2e8f0;
    padding: 2px 0;
}
.row:last-child { border-bottom: none; }
.lbl {
    font-size: 6px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    font-weight: 700;
}
.val {
    font-size: 7px;
    font-weight: 700;
    color: #0f172a;
    text-align: right;
    max-width: 65%;
    word-break: break-word;
}

/* Vencimiento */
.venc-ok   { color: #166534; }
.venc-prox { color: #92400e; }
.venc-venc { color: #b91c1c; }

/* Footer */
.foot {
    margin-top: 4px;
    padding-top: 3px;
    border-top: 0.5px solid #e2e8f0;
    font-size: 5.5px;
    color: #94a3b8;
    text-align: center;
}

</style>
</head>
<body>

@php
    $ahora   = \Carbon\Carbon::now('America/Lima');
    $cliente = $item->order->client?->razon_social ?? '—';
    $peso    = ($item->product->peso ?? 0) * $item->cantidad_despachada / 1000;

    $lote = $item->lote ?? $item->product->lote ?? '—';
    $fv   = $item->fecha_vencimiento ?? $item->product->fecha_vencimiento;

    $vencClass = '';
    $diasVenc  = null;
    if ($fv) {
        $diasVenc = (int) round($ahora->diffInDays(\Carbon\Carbon::parse($fv), false));
        if ($diasVenc < 0)       $vencClass = 'venc-venc';
        elseif ($diasVenc <= 30) $vencClass = 'venc-prox';
        else                     $vencClass = 'venc-ok';
    }
@endphp

<div class="box">

    <div class="head">
        <span class="head-name">Valle Fertil SAC</span>
        <span class="head-doc">#{{ $item->order->numero_orden }}</span>
    </div>

    <div class="cuerpo">
        <div class="col-izq">
            <div class="producto">{{ $item->product->nombre }}</div>
            @if($item->product->sku)
            <div class="sku">SKU: {{ $item->product->sku }}</div>
            @endif

            <div class="cant-box">
                <div class="cant-num">{{ number_format($item->cantidad_despachada, 0) }}</div>
                <div class="cant-lbl">unidades</div>
            </div>
        </div>

        <div class="col-der">
            <div class="row">
                <span class="lbl">Cliente</span>
                <span class="val">{{ $cliente }}</span>
            </div>
            <div class="row">
                <span class="lbl">Lote</span>
                <span class="val">{{ $lote }}</span>
            </div>
            <div class="row">
                <span class="lbl">Vence</span>
                <span class="val {{ $vencClass }}">
                    {{ $fv ? \Carbon\Carbon::parse($fv)->format('d/m/Y') : '—' }}
                </span>
            </div>
            <div class="row">
                <span class="lbl">Peso aprox.</span>
                <span class="val">{{ number_format($peso, 3) }} kg</span>
            </div>
        </div>
    </div>

    <div class="foot">
        Generado {{ $ahora->format('d/m/Y H:i') }} · Peso referencial
    </div>

</div>

</body>
</html>