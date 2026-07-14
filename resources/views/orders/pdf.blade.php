<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

@page { margin: 35px 38px; }
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    color: #1e293b;
    background: #fff;
    line-height: 1.4;
}

/* HEADER */
.hdr { width:100%; border-collapse:collapse; border-bottom:3px solid #111827; padding-bottom:10px; margin-bottom:14px; }
.logo-box { background:#111827; color:#fff; font-size:17px; font-weight:900; letter-spacing:2px; padding:8px 14px; border-radius:4px; display:inline-block; }
.logo-sub { font-size:8px; color:#64748b; text-transform:uppercase; letter-spacing:.08em; margin-top:3px; }
.doc-title { font-size:15px; font-weight:900; color:#111827; }
.doc-num   { font-size:11px; color:#475569; font-weight:700; margin-top:2px; }
.doc-meta  { font-size:8px; color:#94a3b8; margin-top:3px; }
.tipo-badge { background:#111827; color:#fff; font-size:10px; font-weight:800; padding:6px 12px; border-radius:4px; text-align:center; letter-spacing:.06em; text-transform:uppercase; }

/* INFO STRIP */
.info-strip { width:100%; border-collapse:collapse; background:#f8fafc; border:1px solid #e2e8f0; margin-bottom:12px; }
.info-strip td { padding:7px 12px; border-right:1px solid #e2e8f0; vertical-align:top; }
.info-strip td:last-child { border-right:none; }
.info-label { font-size:8px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-bottom:2px; }
.info-value { font-size:11px; font-weight:700; color:#1e293b; }

/* KPIs */
.kpi-table { width:100%; border-collapse:collapse; margin-bottom:14px; }
.kpi-cell  { width:25%; border:1px solid #e2e8f0; padding:8px 10px; text-align:center; border-left:3px solid; background:#f8fafc; }
.kpi-label { font-size:8px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; }
.kpi-val   { font-size:17px; font-weight:900; margin-top:2px; line-height:1; }
.kpi-sub   { font-size:8px; color:#94a3b8; margin-top:2px; }

/* SECCIÓN */
.sec-title { font-size:9px; font-weight:800; color:#fff; background:#111827; padding:5px 10px; text-transform:uppercase; letter-spacing:.08em; margin-bottom:0; }
.sec-title-danger { background:#7f1d1d; }

/* TABLAS */
.tbl { width:100%; border-collapse:collapse; margin-bottom:14px; font-size:9.5px; }
.tbl thead th { background:#111827; color:#fff; padding:6px 8px; text-align:center; font-size:8.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
.tbl thead th:first-child { text-align:left; }
.tbl tbody td { padding:6px 8px; border-bottom:1px solid #f1f5f9; text-align:center; vertical-align:middle; }
.tbl tbody td:first-child { text-align:left; }
.tbl tbody tr:nth-child(even) td { background:#f8fafc; }

/* PALETA HEADER */
.paleta-hdr { width:100%; border-collapse:collapse; margin-top:10px; margin-bottom:0; }
.paleta-hdr-inner { background:#1e293b; color:#fff; padding:7px 12px; font-size:10px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; }
.paleta-hdr-right { background:#334155; color:#93c5fd; text-align:right; padding:7px 12px; font-size:9px; width:200px; }
.tbl-paleta { width:100%; border-collapse:collapse; margin-bottom:6px; font-size:9px; }
.tbl-paleta thead th { background:#334155; color:#e2e8f0; padding:5px 8px; font-size:8px; text-transform:uppercase; letter-spacing:.04em; text-align:center; }
.tbl-paleta thead th:first-child { text-align:left; }
.tbl-paleta tbody td { padding:5px 8px; border-bottom:1px solid #f1f5f9; text-align:center; }
.tbl-paleta tbody td:first-child { text-align:left; }
.tbl-paleta tbody tr:nth-child(even) td { background:#f8fafc; }
.paleta-footer td { background:#f0f9ff; border-top:2px solid #bae6fd; padding:5px 8px; font-size:9px; font-weight:700; color:#0369a1; text-align:right; }

/* FALTANTES */
.tbl-faltantes thead th { background:#7f1d1d; color:#fff; padding:5px 8px; font-size:8px; text-transform:uppercase; text-align:center; }
.tbl-faltantes thead th:first-child { text-align:left; }
.tbl-faltantes tbody td { padding:5px 8px; border-bottom:1px solid #fee2e2; font-size:9px; }
.tbl-faltantes tbody tr:nth-child(even) td { background:#fff5f5; }

/* ESTADOS */
.est-completo { color:#065f46; font-weight:800; }
.est-parcial  { color:#92400e; font-weight:800; }
.est-noenv    { color:#991b1b; font-weight:800; }

/* RESUMEN */
.summary-table { width:100%; border-collapse:collapse; margin-top:14px; border:2px solid #111827; }
.summary-table td { padding:7px 14px; border-bottom:1px solid #e2e8f0; font-size:10px; }
.summary-table td:last-child { text-align:right; font-weight:800; color:#111827; font-size:11px; }
.summary-total td { background:#111827; color:#fff; font-weight:900; font-size:12px; padding:9px 14px; }
.summary-total td:last-child { color:#93c5fd; font-size:14px; }

/* FIRMAS */
.firma-table { width:100%; border-collapse:collapse; margin-top:24px; }
.firma-table td { width:33%; text-align:center; padding-top:28px; border-top:1px solid #334155; font-size:9px; color:#475569; font-weight:600; }

/* FOOTER */
.footer { margin-top:14px; border-top:1px solid #e2e8f0; padding-top:8px; width:100%; border-collapse:collapse; }
.footer td { font-size:8px; color:#94a3b8; }
.footer td:last-child { text-align:right; }

</style>
</head>
<body>

@php
    // ── Ordenar por id (orden de guardado) ──────────────────────────────
    $detalles = $order->details->sortBy('id');

    // ── Paletas ordenadas alfanuméricamente P01→P02→... ─────────────────
    $paletas = $detalles
        ->groupBy(fn($i) => $i->paleta ?: 'SIN PALETA')
        ->sortKeys(SORT_NATURAL);

    // ── Solo paletas con nombre real (excluir SIN PALETA del conteo) ────
    $paletasConNombre = $paletas->filter(fn($items, $key) => $key !== 'SIN PALETA');

    // ── Peso desde cantidad_despachada ───────────────────────────────────
    $pesoTotal = $detalles->sum(fn($d) =>
        $d->cantidad_despachada * ($d->product->peso ?? 0) / 1000
    );
    $totalUds        = $detalles->sum('cantidad_despachada');
    $completados     = $detalles->filter(fn($d) =>
        $d->cantidad_despachada >= $d->cantidad_solicitada
    )->count();
    $porcentaje = $detalles->count() > 0
        ? round(($completados / $detalles->count()) * 100) : 0;
@endphp

{{-- HEADER --}}
<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:140px; vertical-align:middle;">
            <div class="logo-box">DISTAN</div>
            <div class="logo-sub">Warehouse &amp; Distribution ERP</div>
        </td>
        <td style="vertical-align:middle; padding-left:14px;">
            <div class="doc-title">Orden de Despacho</div>
            <div class="doc-num">{{ $order->numero_orden }}</div>
            <div class="doc-meta">Generado: {{ now()->format('d/m/Y H:i') }}</div>
        </td>
        <td style="width:120px; vertical-align:middle; text-align:right;">
            <div class="tipo-badge">{{ $order->tipo_orden }}</div>
        </td>
    </tr>
</table>

{{-- INFO STRIP --}}
<table class="info-strip" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:50%;">
            <div class="info-label">Cliente</div>
            <div class="info-value">{{ $order->client?->razon_social }}</div>
        </td>
        <td>
            <div class="info-label">Estado</div>
            <div class="info-value">{{ $order->estado }}</div>
        </td>
        <td>
            <div class="info-label">Paletas</div>
            <div class="info-value">{{ $paletasConNombre->count() }}</div>
        </td>
    </tr>
</table>

{{-- KPIs --}}
<table class="kpi-table" cellpadding="0" cellspacing="0">
    <tr>
        <td class="kpi-cell" style="border-left-color:#111827;">
            <div class="kpi-label">Productos</div>
            <div class="kpi-val" style="color:#111827;">{{ $detalles->count() }}</div>
            <div class="kpi-sub">ítems en la orden</div>
        </td>
        <td class="kpi-cell" style="border-left-color:#065f46;">
            <div class="kpi-label">Completados</div>
            <div class="kpi-val" style="color:#065f46;">{{ $completados }}</div>
            <div class="kpi-sub">{{ $porcentaje }}% de la orden</div>
        </td>
        <td class="kpi-cell" style="border-left-color:#0369a1;">
            <div class="kpi-label">Peso despachado</div>
            <div class="kpi-val" style="color:#0369a1;">{{ number_format($pesoTotal, 2) }}</div>
            <div class="kpi-sub">kg</div>
        </td>
        <td class="kpi-cell" style="border-left-color:#059669;">
            <div class="kpi-label">Total S/</div>
            <div class="kpi-val" style="color:#059669;">{{ number_format($order->total, 2) }}</div>
            <div class="kpi-sub">valor de la orden</div>
        </td>
    </tr>
</table>

{{-- TABLA RESUMEN ordenada por id --}}
<div class="sec-title">📋 Resumen de ítems</div>
<table class="tbl" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="width:4%; text-align:center;">#</th>
            <th>Producto</th>
            <th>Paleta</th>
            <th>Vencimiento</th>
            <th>Solicitado</th>
            <th>Despachado</th>
            <th>Peso desp.</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach($detalles as $i => $item)
    @php
        $fecha    = $item->fecha_vencimiento ?? $item->product->fecha_vencimiento;
        $pesoItem = ($item->cantidad_despachada * ($item->product->peso ?? 0)) / 1000;
        if ($item->cantidad_despachada == 0) {
            $estado = 'NO ENVIADO'; $estClass = 'est-noenv';
        } elseif ($item->cantidad_despachada < $item->cantidad_solicitada) {
            $estado = 'PARCIAL'; $estClass = 'est-parcial';
        } else {
            $estado = 'COMPLETO'; $estClass = 'est-completo';
        }
    @endphp
    <tr style="background:{{ $item->cantidad_despachada==0 ? '#fff5f5' : ($item->cantidad_despachada < $item->cantidad_solicitada ? '#fffbeb' : '#f0fdf4') }};">
        <td style="text-align:center; color:#94a3b8; font-size:8px;">{{ $i + 1 }}</td>
        <td style="font-weight:600;">{{ $item->product->nombre }}</td>
        <td style="text-align:center; font-weight:700; color:#111827; font-size:9px;">{{ $item->paleta ?: '—' }}</td>
        <td style="text-align:center; color:#0369a1;">
            {{ $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y') : '—' }}
        </td>
        <td style="text-align:center; color:#64748b;">{{ $item->cantidad_solicitada }}</td>
        <td style="text-align:center; font-weight:800;">{{ $item->cantidad_despachada }}</td>
        <td style="text-align:center; color:#0369a1;">{{ number_format($pesoItem, 3) }} kg</td>
        <td style="text-align:center;"><span class="{{ $estClass }}">{{ $estado }}</span></td>
    </tr>
    @endforeach
    </tbody>
</table>

{{-- PALETAS ordenadas P01→P02... --}}
<div class="sec-title" style="margin-top:4px;">🪵 Desglose por paleta</div>

@foreach($paletas as $paleta => $items)
@php
    $pesoPaleta  = $items->sum(fn($d) => ($d->cantidad_despachada * ($d->product->peso ?? 0)) / 1000);
    $totalPaleta = $items->sum('cantidad_despachada');
@endphp

<table class="paleta-hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td class="paleta-hdr-inner">
            🪵 {{ strtoupper($paleta) }}
            <span style="font-size:8px; font-weight:400; opacity:.8; margin-left:8px;">
                {{ $items->count() }} ítem{{ $items->count()>1?'s':'' }}
            </span>
        </td>
        <td class="paleta-hdr-right">
            {{ number_format($pesoPaleta,2) }} kg · {{ $totalPaleta }} u.
        </td>
    </tr>
</table>

<table class="tbl tbl-paleta" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="text-align:left;">Producto</th>
            <th>Vencimiento</th>
            <th>Solicitado</th>
            <th>Despachado</th>
            <th>Peso (kg)</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
    @php $pesoPaletaAcum = 0; $totalPaletaAcum = 0; @endphp
    @foreach($items->sortBy('id') as $detail)
    @php
        $fecha2  = $detail->fecha_vencimiento ?? $detail->product->fecha_vencimiento;
        $pesoD   = ($detail->cantidad_despachada * ($detail->product->peso ?? 0)) / 1000;
        $pesoPaletaAcum  += $pesoD;
        $totalPaletaAcum += $detail->cantidad_despachada;
    @endphp
    <tr>
        <td style="font-weight:600;">{{ $detail->product->nombre }}</td>
        <td style="color:#0369a1;">{{ $fecha2 ? \Carbon\Carbon::parse($fecha2)->format('d/m/Y') : '—' }}</td>
        <td style="color:#64748b;">{{ $detail->cantidad_solicitada }}</td>
        <td style="font-weight:800;">{{ $detail->cantidad_despachada }}</td>
        <td style="color:#0369a1;">{{ number_format($pesoD, 3) }}</td>
        <td>S/ {{ number_format($detail->subtotal, 2) }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr class="paleta-footer">
            <td colspan="2" style="text-align:right; font-size:8.5px;">TOTAL PALETA</td>
            <td></td>
            <td>{{ $totalPaletaAcum }} u.</td>
            <td>{{ number_format($pesoPaletaAcum, 3) }} kg</td>
            <td>S/ {{ number_format($items->sum('subtotal'), 2) }}</td>
        </tr>
    </tfoot>
</table>

@endforeach

{{-- FALTANTES (campos originales: producto, faltante) --}}
@if(!empty($faltantes))
<div class="sec-title sec-title-danger" style="margin-top:10px;">❌ Productos no enviados</div>
<table class="tbl tbl-faltantes" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="text-align:left;">Producto</th>
            <th>Cantidad faltante</th>
        </tr>
    </thead>
    <tbody>
    @foreach($faltantes as $f)
    <tr>
        <td>{{ $f['producto'] }}</td>
        <td style="text-align:center; font-weight:800; color:#991b1b;">{{ $f['faltante'] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif

{{-- RESUMEN GENERAL (campos originales) --}}
<table class="summary-table" cellpadding="0" cellspacing="0">
    <tr>
        <td style="color:#64748b;">Total unidades despachadas</td>
        <td>{{ number_format($totalUds) }} u.</td>
    </tr>
    <tr>
        <td style="color:#64748b;">Peso total despachado</td>
        <td>{{ number_format($pesoTotal, 2) }} kg</td>
    </tr>
    <tr>
        <td style="color:#64748b;">Total productos</td>
        <td>{{ $order->details->sum('cantidad_despachada') }}</td>
    </tr>
    <tr class="summary-total">
        <td>TOTAL S/</td>
        <td>S/ {{ number_format($order->total, 2) }}</td>
    </tr>
</table>

{{-- FIRMAS --}}
<table class="firma-table" cellpadding="0" cellspacing="0">
    <tr>
        <td>Preparado por</td>
        <td>Revisado por</td>
        <td>Recibido por (cliente)</td>
    </tr>
</table>

{{-- FOOTER --}}
<table class="footer" cellpadding="0" cellspacing="0">
    <tr>
        <td>DISTAN ERP · Generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}</td>
        <td>{{ $order->numero_orden }}</td>
    </tr>
</table>

</body>
</html>