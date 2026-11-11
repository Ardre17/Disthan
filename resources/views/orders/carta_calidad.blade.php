<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
@page { size: A4 portrait; margin: 15mm 14mm 16mm 14mm; }
* { box-sizing: border-box; }
body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #263445; background: #fff; line-height: 1.45; margin: 0; }
.header { width: 100%; border-collapse: collapse; border-bottom: 3px solid #17324d; margin-bottom: 15px; }
.header td { padding: 0 0 12px 0; vertical-align: middle; }
.brand { width: 118px; }
.brand-mark { background: #17324d; color: #fff; padding: 11px 12px; text-align: center; }
.brand-name { font-size: 19px; font-weight: bold; letter-spacing: 2px; }
.brand-caption { color: #c4d5e3; font-size: 7px; letter-spacing: 1px; text-transform: uppercase; }
.heading { padding-left: 17px !important; }
.eyebrow { color: #688096; font-size: 7px; font-weight: bold; letter-spacing: 1.3px; text-transform: uppercase; }
.doc-title { color: #17324d; font-size: 19px; font-weight: bold; margin-top: 3px; }
.doc-subtitle { color: #647789; font-size: 8px; margin-top: 3px; text-transform: uppercase; letter-spacing: .6px; }
.doc-code { color: #17324d; font-size: 9px; font-weight: bold; margin-top: 7px; }
.header-side { width: 105px; text-align: right; }
.status-box { display: inline-block; border: 1px solid #b7c8d5; color: #31536d; padding: 7px 9px; text-align: center; font-size: 7px; font-weight: bold; letter-spacing: .7px; text-transform: uppercase; }
.status-box strong { display: block; font-size: 10px; margin-top: 2px; }
.meta { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
.meta td { border: 1px solid #d9e1e8; background: #f5f8fa; padding: 8px 9px; vertical-align: top; }
.meta-label { color: #728496; font-size: 7px; font-weight: bold; text-transform: uppercase; letter-spacing: .7px; margin-bottom: 3px; }
.meta-value { color: #1f3448; font-size: 9px; font-weight: bold; }
.section-heading { background: #17324d; color: #fff; padding: 7px 10px; font-size: 8px; font-weight: bold; letter-spacing: .8px; text-transform: uppercase; margin: 14px 0 0 0; }
.declaration { border: 1px solid #d5e0e7; border-left: 3px solid #527b70; background: #f7faf9; padding: 11px 13px; color: #405365; font-size: 8.5px; line-height: 1.65; margin-bottom: 13px; }
.declaration strong { color: #17324d; }
.products { width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 7.5px; }
.products thead { display: table-header-group; }
.products thead th { background: #eaf0f4; color: #29445b; border-bottom: 1px solid #b9c8d3; padding: 8px 4px; text-align: center; font-size: 7px; font-weight: bold; text-transform: uppercase; }
.products tbody td { border-bottom: 1px solid #e1e7ec; padding: 8px 4px; vertical-align: middle; overflow-wrap: break-word; }
.products tbody tr:nth-child(even) td { background: #fafcfd; }
.products tfoot td { background: #17324d; color: #fff; padding: 8px 5px; font-weight: bold; font-size: 8px; }
.center { text-align: center; }
.product-name { color: #1e3448; font-weight: bold; font-size: 7.7px; }
.sku { color: #778999; font-size: 6.8px; margin-top: 3px; }
.lot { color: #294d69; font-weight: bold; }
.quantity { color: #17324d; font-weight: bold; font-size: 9px; }
.weight { color: #405f75; }
.badge-completo { color: #356c58; font-weight: bold; }
.badge-parcial { color: #9a6a2c; font-weight: bold; }
.venc-ok { color: #356c58; font-weight: bold; }
.venc-prox { color: #9a6a2c; font-weight: bold; }
.venc-venc { color: #a74646; font-weight: bold; }
.days { color: #7b8c99; font-size: 6.5px; }
.table-note { color: #7b8c99; font-size: 7px; font-style: italic; margin: 6px 0 13px; }
.summary { width: 100%; border-collapse: collapse; margin: 0 0 14px; }
.summary td { border: 1px solid #dce4e9; padding: 7px 9px; }
.summary-label { color: #718496; font-size: 7px; text-transform: uppercase; font-weight: bold; }
.summary-value { color: #17324d; font-size: 10px; font-weight: bold; margin-top: 2px; }
.conditions { width: 100%; border-collapse: collapse; margin: 0 0 14px; }
.conditions td { width: 50%; vertical-align: top; padding: 8px 10px; border: 1px solid #e0e7ec; color: #485d6e; font-size: 7.5px; line-height: 1.8; }
.check { color: #527b70; font-weight: bold; }
.signatures { width: 100%; border-collapse: collapse; margin-top: 22px; page-break-inside: avoid; }
.signatures td { width: 33.33%; text-align: center; vertical-align: bottom; padding: 0 8px; }
.signature-line { border-top: 1px solid #718392; padding-top: 7px; color: #29445b; font-size: 7.5px; font-weight: bold; }
.signature-role { color: #788a98; font-size: 6.5px; text-transform: uppercase; letter-spacing: .5px; margin-top: 3px; }
.quality-seal { border: 2px solid #527b70; color: #527b70; width: 66px; height: 66px; margin: 0 auto 8px; text-align: center; font-size: 7px; font-weight: bold; padding-top: 17px; line-height: 1.5; }
.footer { width: 100%; border-collapse: collapse; border-top: 1px solid #d8e1e7; margin-top: 17px; page-break-inside: avoid; }
.footer td { padding-top: 7px; color: #8393a0; font-size: 6.5px; vertical-align: top; }
.footer td:last-child { text-align: right; }
</style>
</head>
<body>

@php
    $detalles  = $order->details()->with('product')->where('cantidad_despachada', '>', 0)->get();
    $ahora        = \Carbon\Carbon::now('America/Lima');
    $fechaEmision = $ahora->format('d/m/Y');
    $horaEmision  = $ahora->format('H:i');
    $totalUds     = $detalles->sum('cantidad_despachada');
    $totalLineas  = $detalles->count();
    $sinFecha  = 0;
    $vigentes  = 0;
    $proximos  = 0;
    $vencidos  = 0;
    foreach ($detalles as $d) {
        $fv = $d->fecha_vencimiento;
        if (!$fv) { $sinFecha++; continue; }
        $dias = $ahora->diffInDays(\Carbon\Carbon::parse($fv), false);
        if ($dias < 0)       $vencidos++;
        elseif ($dias <= 30) $proximos++;
        else                 $vigentes++;
    }
    $pesoTotalGeneral = $detalles->sum(fn($d) => ($d->product->peso ?? 0) * $d->cantidad_despachada / 1000);
@endphp

<table class="header" cellpadding="0" cellspacing="0">
    <tr>
        <td class="brand">
            <div class="brand-mark">
                <div class="brand-name">DISTAN</div>
                <div class="brand-caption">Perú · Distribución</div>
            </div>
        </td>
        <td class="heading">
            <div class="eyebrow">Documento de aseguramiento y trazabilidad</div>
            <div class="doc-title">Carta de Calidad</div>
            <div class="doc-subtitle">Certificado de despacho · Pedido local</div>
            <div class="doc-code">ORDEN: {{ $order->numero_orden }} &nbsp; | &nbsp; CC-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
        </td>
        <td class="header-side">
            <div class="status-box">Control documental<strong>CALIDAD</strong></div>
        </td>
    </tr>
</table>

<table class="meta" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:40%;">
            <div class="meta-label">Cliente</div>
            <div class="meta-value">{{ $order->client?->razon_social ?? '—' }}</div>
        </td>
        <td style="width:20%;">
            <div class="meta-label">Fecha de emisión</div>
            <div class="meta-value">{{ $fechaEmision }}</div>
        </td>
        <td style="width:16%;">
            <div class="meta-label">Hora</div>
            <div class="meta-value">{{ $horaEmision }}</div>
        </td>
        <td style="width:12%;">
            <div class="meta-label">Líneas</div>
            <div class="meta-value">{{ $totalLineas }}</div>
        </td>
        <td style="width:12%;">
            <div class="meta-label">Total unidades</div>
            <div class="meta-value">{{ number_format($totalUds) }}</div>
        </td>
    </tr>
</table>

<div class="section-heading">Declaración de calidad</div>
<div class="declaration">
    <strong>VALLE FERTIL S.A.C.</strong> declara que los productos descritos en el presente documento
    han sido inspeccionados, verificados y despachados bajo los estándares de calidad establecidos por la empresa,
    cumpliendo con las normas de manipulación, almacenamiento y trazabilidad vigentes.
    Este certificado acredita que los productos entregados al cliente
    <strong>{{ $order->client?->razon_social ?? '—' }}</strong>
    se encuentran en óptimas condiciones al momento del despacho,
    con sus respectivas fechas de vencimiento y lotes de producción debidamente registrados.
</div>

<div class="section-heading">Detalle de productos despachados</div>
<table class="products" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="width:4%;">#</th>
            <th style="width:25%; text-align:left;">Producto</th>
            <th style="width:10%;">Lote</th>
            <th style="width:11%;">Fecha prod.</th>
            <th style="width:13%;">Vencimiento</th>
            <th style="width:11%;">Despachado</th>
            <th style="width:13%;">Peso total*</th>
            <th style="width:13%;">Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach($detalles as $i => $d)
    @php
        $fv       = $d->fecha_vencimiento;
        $fp       = $d->fecha_produccion;
        $diasVenc = $fv ? (int) round($ahora->diffInDays(\Carbon\Carbon::parse($fv), false)) : null;
        $vencClass = '';
        $vencIcon  = '';
        if ($diasVenc !== null) {
            if ($diasVenc < 0)       { $vencClass = 'venc-venc'; $vencIcon = 'VENC. '; }
            elseif ($diasVenc <= 30) { $vencClass = 'venc-prox'; $vencIcon = 'PRÓX. '; }
            else                     { $vencClass = 'venc-ok';   $vencIcon = ''; }
        }
        $pesoTotal = ($d->product->peso ?? 0) * $d->cantidad_despachada / 1000;
        $estadoD   = $d->cantidad_despachada >= $d->cantidad_solicitada ? 'COMPLETO' : 'PARCIAL';
    @endphp
    <tr>
        <td class="center" style="color:#8293a0;">{{ $i + 1 }}</td>
        <td>
            <div class="product-name">{{ $d->product->nombre }}</div>
            @if($d->product->sku)
                <div class="sku">SKU: {{ $d->product->sku }}</div>
            @endif
        </td>
        <td class="center lot">{{ $d->lote ?? '—' }}</td>
        <td class="center">{{ $fp ? \Carbon\Carbon::parse($fp)->format('d/m/Y') : '—' }}</td>
        <td class="center">
            <span class="{{ $vencClass }}">{{ $vencIcon }}{{ $fv ? \Carbon\Carbon::parse($fv)->format('d/m/Y') : '—' }}</span>
            @if($diasVenc !== null && $diasVenc >= 0)
                <br><span class="days">{{ $diasVenc }} días</span>
            @endif
        </td>
        <td class="center quantity">{{ number_format($d->cantidad_despachada, 0) }}</td>
        <td class="center weight">{{ number_format($pesoTotal, 3) }} kg</td>
        <td class="center"><span class="{{ $estadoD === 'COMPLETO' ? 'badge-completo' : 'badge-parcial' }}">{{ $estadoD }}</span></td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right;">TOTALES</td>
            <td class="center">{{ number_format($totalUds, 0) }} u.</td>
            <td class="center">{{ number_format($pesoTotalGeneral, 3) }} kg</td>
            <td></td>
        </tr>
    </tfoot>
</table>
<div class="table-note">* El peso total es aproximado/referencial; puede variar ligeramente según el producto y no representa un valor exacto.</div>



<div class="section-heading">Condiciones de calidad certificadas</div>
<table class="conditions" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <span class="check">✓</span> Productos inspeccionados previo al despacho<br>
            <span class="check">✓</span> Temperatura y almacenamiento controlados<br>
            <span class="check">✓</span> Embalaje íntegro y en buenas condiciones<br>
            <span class="check">✓</span> Lotes de producción verificados y registrados
        </td>
        <td>
            <span class="check">✓</span> Fechas de vencimiento dentro del rango aceptable<br>
            <span class="check">✓</span> Pesos y cantidades verificados contra la orden<br>
            <span class="check">✓</span> Producto libre de daños físicos visibles<br>
            <span class="check">✓</span> Trazabilidad completa disponible en sistema ERP
        </td>
    </tr>
</table>

<table class="signatures" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="quality-seal">CONTROL<br>DE CALIDAD<br>✓</div>
            <div class="signature-line">Sello de calidad</div>
            <div class="signature-role">Control de calidad</div>
        </td>
        <td>
            <div style="height:74px;"></div>
            <div class="signature-line">Responsable de despacho</div>
            <div class="signature-role">Almacén · VALLE FERTIL</div>
        </td>
        <td>
            <div style="height:74px;"></div>
            <div class="signature-line">Recibido conforme</div>
            <div class="signature-role">{{ $order->client?->razon_social ?? 'Cliente' }}</div>
        </td>
    </tr>
</table>

<table class="footer" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            VALLE FERTIL S.A.C. · Carta de Calidad Nº CC-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}<br>
            Generado el {{ $ahora->format('d/m/Y \\a \\l\\a\\s H:i') }}
        </td>
        <td>
            {{ $order->numero_orden }}<br>
            Documento de trazabilidad de productos despachados
        </td>
    </tr>
</table>

</body>
</html>
