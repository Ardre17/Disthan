<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

@page { margin: 26px 28px; }
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9.5px;
    color: #1e293b;
    background: #fff;
    line-height: 1.35;
}

/* ── Colores base ── */
/* azul oscuro #0b4ea2 · azul marca #1d4ed8 · panel #eef5fd · borde #d6e4f5 */

/* HEADER */
.hdr { width:100%; border-collapse:collapse; margin-bottom:12px; }
.brand-name { font-size:21px; font-weight:900; color:#1d4ed8; letter-spacing:.5px; }
.brand-name span { color:#0f2d5c; }
.brand-sub { font-size:8px; color:#64748b; margin-top:1px; }
.doc-title { font-size:15px; font-weight:900; color:#0f2d5c; text-align:center; letter-spacing:.3px; }
.doc-tipo  { font-size:11px; font-weight:800; color:#1d4ed8; text-align:center; margin-top:3px; text-transform:uppercase; }
.doc-meta  { font-size:7.5px; color:#94a3b8; text-align:center; margin-top:4px; }
.ord-box   { background:#0b4ea2; color:#fff; border-radius:7px; padding:6px 10px 8px; text-align:center; }
.ord-lbl   { font-size:7.5px; letter-spacing:.12em; color:#bcd6fb; }
.ord-num   { font-size:15px; font-weight:900; letter-spacing:.5px; margin:1px 0 4px; }
.bc-wrap   { background:#fff; border-radius:4px; padding:4px 6px 2px; text-align:center; }
.bc-txt    { font-size:7px; color:#334155; margin-top:2px; }

/* TARJETAS */
.card { background:#fff; border:1px solid #d6e4f5; border-radius:7px; padding:8px 10px; }
.card-lbl { font-size:8.5px; font-weight:800; color:#0f2d5c; }
.card-name { font-size:10px; font-weight:900; color:#0f2d5c; margin:1px 0 3px; }
.card-line { font-size:8px; color:#475569; }
.card-line b { color:#64748b; font-weight:700; display:inline-block; width:44px; }

/* CHIPS DE DATOS */
.chips { width:100%; border-collapse:separate; border-spacing:5px 0; margin:0 -5px 10px; }
.chip { background:#f5f9ff; border:1px solid #d6e4f5; border-radius:7px; padding:6px 8px; }
.chip-lbl { font-size:7.5px; color:#64748b; }
.chip-val { font-size:9.5px; font-weight:800; color:#0f2d5c; margin-top:1px; }

/* SECCIONES */
.panel { background:#eef5fd; border:1px solid #dbe7f6; border-radius:8px; padding:8px 10px; margin-bottom:10px; }
.sec { font-size:10px; font-weight:900; color:#0f2d5c; margin-bottom:7px; }
.sec-ic { display:inline-block; width:14px; height:14px; background:#1d4ed8; color:#fff; border-radius:3px; text-align:center; font-size:8px; line-height:14px; margin-right:5px; }
.sec-ic.red { background:#dc2626; }
.sec-ic.amb { background:#f59e0b; }

/* KPIs */
.kpis { width:100%; border-collapse:collapse; }
.kpis td { text-align:center; padding:2px 3px; }
.kpi-n { font-size:15px; font-weight:900; color:#0f2d5c; line-height:1.1; }
.kpi-l { font-size:7.5px; color:#475569; line-height:1.2; }
.kpi-ic { display:inline-block; width:24px; height:24px; border-radius:6px; background:#dbe9fb; color:#1d4ed8; font-size:11px; line-height:24px; font-weight:900; }

/* TABLAS */
.tbl { width:100%; border-collapse:collapse; font-size:8.5px; background:#fff; }
.tbl thead th { background:#0b4ea2; color:#fff; padding:5px 5px; text-align:center; font-size:8px; font-weight:800; border-right:1px solid #2d6bbd; }
.tbl thead th:last-child { border-right:none; }
.tbl tbody td { padding:4.5px 5px; border-bottom:1px solid #e6eef9; text-align:center; vertical-align:middle; }
.tbl tbody td.l { text-align:left; }
.tbl tfoot td { padding:5px 5px; background:#e8f1fc; font-weight:900; color:#0f2d5c; text-align:center; border-top:2px solid #0b4ea2; }

/* ESTADOS */
.st { display:inline-block; padding:2px 7px; border-radius:9px; font-size:7.5px; font-weight:800; }
.st-ok  { background:#dcfce7; color:#15803d; }
.st-par { background:#fde9b3; color:#a16207; }
.st-no  { background:#fecaca; color:#b91c1c; }
.row-par td { background:#fff7dc !important; }
.row-no  td { background:#ffe3e3 !important; }

/* PALETAS */
.pcell { vertical-align:top; padding:0 5px 8px 0; }
.pcell-r { padding:0 0 8px 5px; }
.pcard { width:100%; border-collapse:collapse; page-break-inside:avoid; }
.pcard-h { background:#0b4ea2; color:#fff; padding:5px 8px; font-size:10px; font-weight:900; border-radius:6px 0 0 0; }
.pcard-hr { background:#0b4ea2; text-align:right; padding:4px 6px; border-radius:0 6px 0 0; }
.pchip { display:inline-block; padding:3px 12px; border-radius:6px; font-size:7.5px; font-weight:900; letter-spacing:.04em; }
.pc-ok { background:#16a34a; color:#fff; } .pc-par { background:#fbbf24; color:#422006; } .pc-no { background:#ef4444; color:#fff; }
.pbody { background:#f6f9fe; border:1px solid #d6e4f5; border-top:none; padding:6px 7px; }
.pstats { width:100%; border-collapse:collapse; }
.pstats td { text-align:center; font-size:7.5px; color:#475569; padding:0 2px; }
.pstats b { display:block; font-size:10.5px; color:#0f2d5c; font-weight:900; }
.ptbl { width:100%; border-collapse:collapse; font-size:7.5px; background:#fff; margin-top:6px; }
.ptbl thead th { background:#0b4ea2; color:#fff; padding:3.5px 3px; font-size:7px; text-align:center; border-right:1px solid #2d6bbd; }
.ptbl tbody td { padding:3.5px 3px; border-bottom:1px solid #e6eef9; text-align:center; }
.ptbl tbody td.l { text-align:left; }
.ptfoot { font-size:7.5px; color:#0b4ea2; font-weight:800; text-align:right; margin-top:3px; }

/* FALTANTES */
.fcell { vertical-align:top; }
.fbox-no  { background:#fff1f1; border:1px solid #fecaca; border-radius:7px; padding:7px 8px; }
.fbox-par { background:#fffaf0; border:1px solid #fde7b0; border-radius:7px; padding:7px 8px; }
.ftitle-no  { font-size:9px; font-weight:900; color:#b91c1c; margin-bottom:5px; }
.ftitle-par { font-size:9px; font-weight:900; color:#a16207; margin-bottom:5px; }
.ftbl { width:100%; border-collapse:collapse; font-size:7.5px; background:#fff; }
.ftbl thead th { padding:3.5px 3px; font-size:7px; text-align:center; color:#fff; }
.ftbl thead th.no  { background:#dc2626; }
.ftbl thead th.par { background:#d97706; }
.ftbl tbody td { padding:3.5px 3px; border-bottom:1px solid #f1f5f9; text-align:center; }
.ftbl tbody td.l { text-align:left; }

/* OBSERVACIONES + FIRMAS */
.obs-box { background:#eef5fd; border:1px solid #dbe7f6; border-radius:8px; padding:8px 10px; vertical-align:top; }
.obs-t { font-size:9.5px; font-weight:900; color:#0f2d5c; margin-bottom:4px; }
.obs-x { font-size:8.5px; color:#334155; line-height:1.5; }
.firma { text-align:center; vertical-align:bottom; padding:0 8px; }
.firma-line { border-top:1px solid #334155; padding-top:4px; font-size:8.5px; font-weight:800; color:#0f2d5c; }

/* RESUMEN GENERAL (original) */
.summary-table { width:100%; border-collapse:collapse; margin-top:10px; border:1.5px solid #0b4ea2; background:#fff; }
.summary-table td { padding:6px 12px; border-bottom:1px solid #e2e8f0; font-size:9.5px; }
.summary-table td:last-child { text-align:right; font-weight:800; color:#0f2d5c; font-size:10.5px; }
.summary-total td { background:#0b4ea2; color:#fff !important; font-weight:900; font-size:11.5px; padding:8px 12px; }
.summary-total td:last-child { color:#bcd6fb !important; font-size:13.5px; }

/* FOOTER */
.footer { margin-top:10px; border-top:1px solid #d6e4f5; padding-top:6px; width:100%; border-collapse:collapse; }
.footer td { font-size:7.5px; color:#94a3b8; }
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

{{-- ── Datos adicionales para el rediseño (solo lectura; no tocan las variables de arriba) ── --}}
@php
    // Datos de la empresa que despacha ("Proveedor"). Complétalos aquí o en la orden ($order->proveedor).
    $pdfProv = [
        'nombre'    => null,   // Ej: 'JOYBER PERÚ S.A.C.'
        'ruc'       => null,   // Ej: '20601234567'
        'direccion' => null,   // Ej: 'JR. LOS ALISOS 125 - LIMA'
    ];

    $n   = function ($v, $d = 0) {
        $s = number_format((float) $v, $d, '.', '');
        if (strpos($s, '.') !== false) { $s = rtrim(rtrim($s, '0'), '.'); }
        return $s === '' ? '0' : $s;
    };
    $f   = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m/Y') : '—';
    $cli = $order->client;
    $prv = $order->proveedor ?? null;
    $provNombre = (is_object($prv) ? ($prv->razon_social ?? $prv->nombre ?? null) : (is_string($prv) ? $prv : null)) ?: $pdfProv['nombre'];
    $provRuc    = (is_object($prv) ? ($prv->ruc ?? null) : null) ?: $pdfProv['ruc'];
    $provDir    = (is_object($prv) ? ($prv->direccion ?? null) : null) ?: $pdfProv['direccion'];

    $solTotal  = (float) $detalles->sum('cantidad_solicitada');
    $penTotal  = (float) $detalles->sum(fn($d) => max($d->cantidad_solicitada - $d->cantidad_despachada, 0));

    // Estado de cada línea
    $est = function ($d) {
        if ($d->cantidad_despachada == 0)                         return ['No despachado', 'st-no',  'row-no',  '✖'];
        if ($d->cantidad_despachada < $d->cantidad_solicitada)    return ['Parcial',       'st-par', 'row-par', '⚠'];
        return ['Completo', 'st-ok', '', '✔'];
    };
    $cajas = function ($d) {
        $c = (int) ($d->product->cantidad_por_caja ?? 0);
        return $c > 0 ? (int) ceil($d->cantidad_despachada / $c) : 0;
    };

    // Código de barras (Code 128) del número de pedido del cliente o, si no hay, de la orden
    $pedidoCli = $order->order_interna ?? null;
    $bcTexto   = trim((string) ($pedidoCli ?: $order->numero_orden));
    $c128 = [
    '11011001100',
    '11001101100',
    '11001100110',
    '10010011000',
    '10010001100',
    '10001001100',
    '10011001000',
    '10011000100',
    '10001100100',
    '11001001000',
    '11001000100',
    '11000100100',
    '10110011100',
    '10011011100',
    '10011001110',
    '10111001100',
    '10011101100',
    '10011100110',
    '11001110010',
    '11001011100',
    '11001001110',
    '11011100100',
    '11001110100',
    '11101101110',
    '11101001100',
    '11100101100',
    '11100100110',
    '11101100100',
    '11100110100',
    '11100110010',
    '11011011000',
    '11011000110',
    '11000110110',
    '10100011000',
    '10001011000',
    '10001000110',
    '10110001000',
    '10001101000',
    '10001100010',
    '11010001000',
    '11000101000',
    '11000100010',
    '10110111000',
    '10110001110',
    '10001101110',
    '10111011000',
    '10111000110',
    '10001110110',
    '11101110110',
    '11010001110',
    '11000101110',
    '11011101000',
    '11011100010',
    '11011101110',
    '11101011000',
    '11101000110',
    '11100010110',
    '11101101000',
    '11101100010',
    '11100011010',
    '11101111010',
    '11001000010',
    '11110001010',
    '10100110000',
    '10100001100',
    '10010110000',
    '10010000110',
    '10000101100',
    '10000100110',
    '10110010000',
    '10110000100',
    '10011010000',
    '10011000010',
    '10000110100',
    '10000110010',
    '11000010010',
    '11001010000',
    '11110111010',
    '11000010100',
    '10001111010',
    '10100111100',
    '10010111100',
    '10010011110',
    '10111100100',
    '10011110100',
    '10011110010',
    '11110100100',
    '11110010100',
    '11110010010',
    '11011011110',
    '11011110110',
    '11110110110',
    '10101111000',
    '10100011110',
    '10001011110',
    '10111101000',
    '10111100010',
    '11110101000',
    '11110100010',
    '10111011110',
    '10111101110',
    '11101011110',
    '11110101110',
    '11010000100',
    '11010010000',
    '11010011100'
];
    $c128stop = '1100011101011';
    $bcBits = '';
    if ($bcTexto !== '') {
        if (ctype_digit($bcTexto) && strlen($bcTexto) % 2 === 0) {
            $vals = [105];
            for ($k = 0; $k < strlen($bcTexto); $k += 2) { $vals[] = (int) substr($bcTexto, $k, 2); }
        } else {
            $vals = [104];
            foreach (str_split($bcTexto) as $ch) { $o = ord($ch); $vals[] = ($o < 32 || $o > 126 ? 63 : $o) - 32; }
        }
        $sum = $vals[0];
        for ($k = 1; $k < count($vals); $k++) { $sum += $vals[$k] * $k; }
        $vals[] = $sum % 103;
        foreach ($vals as $v) { $bcBits .= $c128[$v]; }
        $bcBits .= $c128stop;
    }
    $bcHtml = '';
    if ($bcBits !== '') {
        $mod = 0.9; $runs = []; $cur = $bcBits[0]; $len = 0;
        foreach (str_split($bcBits) as $b) {
            if ($b === $cur) { $len++; } else { $runs[] = [$cur, $len]; $cur = $b; $len = 1; }
        }
        $runs[] = [$cur, $len];
        $bcHtml = '<table cellpadding="0" cellspacing="0" style="margin:0 auto;border-collapse:collapse;"><tr>';
        foreach ($runs as $r) {
            $bcHtml .= '<td style="width:' . round($r[1] * $mod, 2) . 'px;height:20px;padding:0;font-size:0;line-height:0;background:' . ($r[0] === '1' ? '#000' : '#fff') . ';"></td>';
        }
        $bcHtml .= '</tr></table>';
    }

    $logoB64   = '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';
    $palletB64 = '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';

    // Resumen por paleta (se reutiliza abajo)
    $paletaInfo = [];
    foreach ($paletas as $nombre => $items) {
        $pStatus = 'pc-ok'; $pTxt = 'COMPLETA'; $pEst = ['Completa', 'st-ok', '✔'];
        if ($items->contains(fn($d) => $d->cantidad_despachada == 0))                       { $pStatus = 'pc-no';  $pTxt = 'CON INCIDENCIAS'; $pEst = ['Con incidencias', 'st-no', '✖']; }
        elseif ($items->contains(fn($d) => $d->cantidad_despachada < $d->cantidad_solicitada)) { $pStatus = 'pc-par'; $pTxt = 'PARCIAL';         $pEst = ['Parcial', 'st-par', '⚠']; }
        $paletaInfo[$nombre] = [
            'status' => $pStatus, 'txt' => $pTxt, 'est' => $pEst,
            'prods'  => $items->count(),
            'cajas'  => $items->sum(fn($d) => $cajas($d)),
            'uds'    => $items->sum('cantidad_despachada'),
            'peso'   => $items->sum(fn($d) => ($d->cantidad_despachada * ($d->product->peso ?? 0)) / 1000),
        ];
    }

    $noDesp  = $detalles->filter(fn($d) => $d->cantidad_despachada == 0)->values();
    $parcial = $detalles->filter(fn($d) => $d->cantidad_despachada > 0 && $d->cantidad_despachada < $d->cantidad_solicitada)->values();
@endphp

{{-- ═══════════════════════ PÁGINA 1 ═══════════════════════ --}}

{{-- HEADER --}}
<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:190px; vertical-align:middle;">
            <table cellpadding="0" cellspacing="0"><tr>
                <td style="vertical-align:middle; padding-right:7px;"><img src="data:image/png;base64,{{ $logoB64 }}" width="38" height="38" alt=""></td>
                <td style="vertical-align:middle;">
                    <div class="brand-name">DISTAN <span>ERP</span></div>
                    <div class="brand-sub">Sistema de Gestión</div>
                </td>
            </tr></table>
        </td>
        <td style="vertical-align:middle;">
            <div class="doc-title">ORDEN DE DESPACHO</div>
            <div class="doc-tipo">{{ $order->tipo_orden }}</div>
            <div class="doc-meta">Estado: {{ $order->estado }} · Generado: {{ now()->format('d/m/Y H:i') }}</div>
        </td>
        <td style="width:175px; vertical-align:middle;">
            <div class="ord-box">
                <div class="ord-lbl">N° ORDEN</div>
                <div class="ord-num">{{ $order->numero_orden }}</div>
                @if($bcHtml)
                <div class="bc-wrap">{!! $bcHtml !!}<div class="bc-txt">@if($pedidoCli)Pedido N° {{ $pedidoCli }}@else{{ $bcTexto }}@endif</div></div>
                @endif
            </div>
        </td>
    </tr>
</table>

{{-- CLIENTE / PROVEEDOR --}}
<table style="width:100%; border-collapse:separate; border-spacing:0; margin-bottom:8px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:50%; padding-right:4px; vertical-align:top;">
            <div class="card">
                <div class="card-lbl">Cliente</div>
                <div class="card-name">{{ $cli?->razon_social ?? '—' }}</div>
                <div class="card-line"><b>RUC:</b> {{ $cli->ruc ?? $cli->numero_documento ?? '—' }}</div>
                <div class="card-line"><b>Dirección:</b> {{ $cli->direccion ?? '—' }}</div>
            </div>
        </td>
        <td style="width:50%; padding-left:4px; vertical-align:top;">
            <div class="card">
                <div class="card-lbl">Proveedor</div>
                <div class="card-name">{{ $provNombre ?: '—' }}</div>
                <div class="card-line"><b>RUC:</b> {{ $provRuc ?: '—' }}</div>
                <div class="card-line"><b>Dirección:</b> {{ $provDir ?: '—' }}</div>
            </div>
        </td>
    </tr>
</table>

{{-- DATOS DE LA ORDEN --}}
<table class="chips" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Fecha de emisión</div><div class="chip-val">{{ $f($order->fecha_pedido) }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Fecha de entrega</div><div class="chip-val">{{ $f($order->fecha_entrega ?? null) }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Tienda / Destino</div><div class="chip-val">{{ $order->tienda ?? $order->destino ?? $cli->tienda ?? '—' }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Tipo de pedido</div><div class="chip-val">{{ ucfirst(strtolower((string) $order->tipo_orden)) }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">N° de guía / Ref.</div><div class="chip-val">{{ $order->guia_asociada ?? '—' }}</div>@if($order->factura_asociada ?? null)<div class="chip-lbl" style="margin-top:1px;">Fact. {{ $order->factura_asociada }}</div>@endif</div></td>
    </tr>
</table>

{{-- RESUMEN DE LA ORDEN --}}
<div class="panel">
    <div class="sec"><span class="sec-ic">≡</span>Resumen de la orden</div>
    <table class="kpis" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:16.6%;"><span class="kpi-ic">▣</span><div class="kpi-n">{{ $detalles->count() }}</div><div class="kpi-l">Productos<br>SKU diferentes</div></td>
            <td style="width:16.6%;"><span class="kpi-ic">≡</span><div class="kpi-n">{{ $n($solTotal) }}</div><div class="kpi-l">Unidades<br>solicitadas</div></td>
            <td style="width:16.6%;"><span class="kpi-ic" style="background:#d9f5e3;color:#15803d;">✔</span><div class="kpi-n">{{ $n($totalUds) }}</div><div class="kpi-l">Unidades<br>despachadas</div></td>
            <td style="width:16.6%;"><span class="kpi-ic" style="background:#fde0e0;color:#dc2626;">!</span><div class="kpi-n">{{ $n($penTotal) }}</div><div class="kpi-l">Unidades<br>pendientes</div></td>
            <td style="width:16.6%;"><span class="kpi-ic">▦</span><div class="kpi-n">{{ $paletasConNombre->count() }}</div><div class="kpi-l">Paletas<br>a despachar</div></td>
            <td style="width:16.6%;"><span class="kpi-ic">⚖</span><div class="kpi-n">{{ number_format($pesoTotal, 2) }} kg</div><div class="kpi-l">Peso total<br>despachado</div></td>
        </tr>
    </table>
</div>

{{-- DETALLE DE PRODUCTOS (ordenado por id) --}}
<div class="panel" style="padding-bottom:8px;">
    <div class="sec"><span class="sec-ic">▤</span>Detalle de productos</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width:4%;">#</th>
                <th style="width:10%;">Código</th>
                <th style="width:28%;">Producto</th>
                <th style="width:11%;">Presentación</th>
                <th style="width:9%;">Solicitado</th>
                <th style="width:9%;">Despacho</th>
                <th style="width:8%;">Faltante</th>
                <th style="width:10%;">Vencimiento</th>
                <th style="width:15%;">Estado</th>
            </tr>
        </thead>
        <tbody>
        @foreach($detalles as $i => $item)
        @php
            $fecha   = $item->fecha_vencimiento ?? $item->product->fecha_vencimiento;
            $cpc     = (int) ($item->product->cantidad_por_caja ?? 0);
            $pres    = $item->product->presentacion ?? ($cpc > 0 ? 'Caja x ' . $cpc : '—');
            $falt    = max($item->cantidad_solicitada - $item->cantidad_despachada, 0);
            [$eTxt, $eCls, $rCls, $eIc] = $est($item);
        @endphp
        <tr class="{{ $rCls }}">
            <td style="color:#64748b;">{{ $loop->iteration }}</td>
            <td style="color:#334155;">{{ $item->product->sku ?? '—' }}</td>
            <td class="l" style="font-weight:700;">{{ $item->product->nombre }}</td>
            <td>{{ $pres }}</td>
            <td>{{ $n($item->cantidad_solicitada, 2) }}</td>
            <td style="font-weight:800;">{{ $n($item->cantidad_despachada, 2) }}</td>
            <td style="font-weight:800;color:{{ $falt > 0 ? '#dc2626' : '#15803d' }};">{{ $n($falt, 2) }}</td>
            <td>{{ $f($fecha) }}</td>
            <td><span class="st {{ $eCls }}">{{ $eIc }} {{ $eTxt }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- OBSERVACIONES + FIRMAS --}}
<table style="width:100%; border-collapse:separate; border-spacing:0;" cellpadding="0" cellspacing="0">
    <tr>
        <td class="obs-box" style="width:46%;">
            <div class="obs-t">Observaciones</div>
            <div class="obs-x">{!! nl2br(e($order->observaciones ?: 'Sin observaciones registradas.')) !!}</div>
        </td>
        <td style="width:54%; padding-left:10px; vertical-align:bottom;">
            <table style="width:100%; border-collapse:collapse;" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="firma" style="width:33%;"><div style="height:32px;"></div><div class="firma-line">Preparado por</div></td>
                    <td class="firma" style="width:33%;"><div style="height:32px;"></div><div class="firma-line">Revisado por</div></td>
                    <td class="firma" style="width:34%;"><div style="height:32px;"></div><div class="firma-line">Recibido conforme</div></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ═══════════════════════ PÁGINA 2 ═══════════════════════ --}}
<div style="page-break-before:always;"></div>

<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:190px; vertical-align:middle;">
            <table cellpadding="0" cellspacing="0"><tr>
                <td style="vertical-align:middle; padding-right:7px;"><img src="data:image/png;base64,{{ $logoB64 }}" width="38" height="38" alt=""></td>
                <td style="vertical-align:middle;">
                    <div class="brand-name">DISTAN <span>ERP</span></div>
                    <div class="brand-sub">Sistema de Gestión</div>
                </td>
            </tr></table>
        </td>
        <td style="vertical-align:middle;">
            <div class="doc-title">ORDEN DE DESPACHO</div>
            <div class="doc-tipo">{{ $order->tipo_orden }}</div>
        </td>
        <td style="width:175px; vertical-align:middle;">
            <div class="ord-box">
                <div class="ord-lbl">N° ORDEN</div>
                <div class="ord-num">{{ $order->numero_orden }}</div>
                @if($bcHtml)
                <div class="bc-wrap">{!! $bcHtml !!}<div class="bc-txt">@if($pedidoCli)Pedido N° {{ $pedidoCli }}@else{{ $bcTexto }}@endif</div></div>
                @endif
            </div>
        </td>
    </tr>
</table>

{{-- DESGLOSE POR PALETAS (ordenadas P01→P02...) --}}
<div class="sec" style="margin-bottom:6px;"><span class="sec-ic">▦</span>Desglose por paletas</div>

<table style="width:100%; border-collapse:separate; border-spacing:0;" cellpadding="0" cellspacing="0">
@foreach($paletas->chunk(2) as $par)
    <tr>
    @foreach($par as $paleta => $items)
    @php $pi = $paletaInfo[$paleta]; $pesoPaletaAcum = 0; $totalPaletaAcum = 0; @endphp
        <td class="pcell {{ $loop->last && $loop->count == 2 ? 'pcell-r' : '' }}" style="width:50%;">
            <table class="pcard" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="pcard-h">{{ $paleta === 'SIN PALETA' ? 'Sin paleta' : 'Paleta ' . $paleta }}</td>
                    <td class="pcard-hr"><span class="pchip {{ $pi['status'] }}">{{ $pi['txt'] }}</span></td>
                </tr>
                <tr><td colspan="2" class="pbody">
                    <table class="pstats" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:36%; text-align:left;"><img src="data:image/png;base64,{{ $palletB64 }}" width="64" alt=""></td>
                            <td><b>{{ $pi['prods'] }}</b>Productos</td>
                            <td><b>{{ $pi['cajas'] }}</b>Cajas</td>
                            <td><b>{{ $n($pi['uds']) }}</b>Unidades</td>
                            <td><b>{{ number_format($pi['peso'], 2) }} kg</b>Peso</td>
                        </tr>
                    </table>
                    <table class="ptbl" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr><th style="width:5%;">#</th><th style="width:17%;">Código</th><th>Producto</th><th style="width:11%;">Cajas</th><th style="width:11%;">Unid.</th><th style="width:19%;">Vencimiento</th></tr>
                        </thead>
                        <tbody>
                        @foreach($items->sortBy('id') as $detail)
                        @php
                            $fecha2 = $detail->fecha_vencimiento ?? $detail->product->fecha_vencimiento;
                            $pesoD  = ($detail->cantidad_despachada * ($detail->product->peso ?? 0)) / 1000;
                            $pesoPaletaAcum  += $pesoD;
                            $totalPaletaAcum += $detail->cantidad_despachada;
                            [$dTxt, $dCls, $dRow, $dIc] = $est($detail);
                        @endphp
                        <tr class="{{ $dRow }}">
                            <td style="color:#64748b;">{{ $loop->iteration }}</td>
                            <td>{{ $detail->product->sku ?? '—' }}</td>
                            <td class="l" style="font-weight:700;">{{ $detail->product->nombre }}</td>
                            <td>{{ $cajas($detail) }}</td>
                            <td style="font-weight:800;">{{ $n($detail->cantidad_despachada) }}</td>
                            <td>{{ $f($fecha2) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- Totales originales de la paleta (unidades, peso y subtotal S/) --}}
                    <div class="ptfoot">Total paleta: {{ $n($totalPaletaAcum) }} u. · {{ number_format($pesoPaletaAcum, 3) }} kg · S/ {{ number_format($items->sum('subtotal'), 2) }}</div>
                </td></tr>
            </table>
        </td>
    @endforeach
    @if($par->count() < 2)
        <td style="width:50%;"></td>
    @endif
    </tr>
@endforeach
</table>

{{-- RESUMEN POR PALETAS --}}
<div class="panel" style="margin-top:2px;">
    <div class="sec"><span class="sec-ic">▤</span>Resumen por paletas</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead>
            <tr><th style="width:16%;">Paleta</th><th>Productos</th><th>Cajas</th><th>Unidades</th><th>Peso (kg)</th><th style="width:26%;">Estado</th></tr>
        </thead>
        <tbody>
        @foreach($paletas as $paleta => $items)
        @php $pi = $paletaInfo[$paleta]; @endphp
        <tr>
            <td style="font-weight:800;">{{ $paleta === 'SIN PALETA' ? 'Sin paleta' : 'Paleta ' . $paleta }}</td>
            <td>{{ $pi['prods'] }}</td>
            <td>{{ $pi['cajas'] }}</td>
            <td>{{ $n($pi['uds']) }}</td>
            <td>{{ number_format($pi['peso'], 2) }}</td>
            <td><span class="st {{ $pi['est'][1] }}">{{ $pi['est'][2] }} {{ $pi['est'][0] }}</span></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ collect($paletaInfo)->sum('prods') }}</td>
                <td>{{ collect($paletaInfo)->sum('cajas') }}</td>
                <td>{{ $n(collect($paletaInfo)->sum('uds')) }}</td>
                <td>{{ number_format(collect($paletaInfo)->sum('peso'), 2) }}</td>
                <td>—</td>
            </tr>
        </tfoot>
    </table>
</div>

{{-- PRODUCTOS NO DESPACHADOS / DESPACHADOS PARCIALMENTE --}}
@if($noDesp->count() || $parcial->count())
<table style="width:100%; border-collapse:separate; border-spacing:0;" cellpadding="0" cellspacing="0">
    <tr>
        @if($noDesp->count())
        <td class="fcell" style="width:{{ $parcial->count() ? '50%' : '100%' }}; {{ $parcial->count() ? 'padding-right:4px;' : '' }}">
            <div class="fbox-no">
                <div class="ftitle-no"><span class="sec-ic red">✖</span>Productos no despachados ({{ $noDesp->count() }})</div>
                <table class="ftbl" cellpadding="0" cellspacing="0">
                    <thead><tr><th class="no">Código</th><th class="no">Producto</th><th class="no">Solicitado</th><th class="no">Despacho</th><th class="no">Faltante</th><th class="no">Vencimiento</th></tr></thead>
                    <tbody>
                    @foreach($noDesp as $d)
                    <tr>
                        <td>{{ $d->product->sku ?? '—' }}</td>
                        <td class="l" style="font-weight:700;">{{ $d->product->nombre }}</td>
                        <td>{{ $n($d->cantidad_solicitada, 2) }}</td>
                        <td>{{ $n($d->cantidad_despachada, 2) }}</td>
                        <td style="font-weight:800;color:#b91c1c;">{{ $n($d->cantidad_solicitada - $d->cantidad_despachada, 2) }}</td>
                        <td>{{ $f($d->fecha_vencimiento ?? $d->product->fecha_vencimiento) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </td>
        @endif
        @if($parcial->count())
        <td class="fcell" style="width:{{ $noDesp->count() ? '50%' : '100%' }}; {{ $noDesp->count() ? 'padding-left:4px;' : '' }}">
            <div class="fbox-par">
                <div class="ftitle-par"><span class="sec-ic amb">⚠</span>Productos despachados parcialmente ({{ $parcial->count() }})</div>
                <table class="ftbl" cellpadding="0" cellspacing="0">
                    <thead><tr><th class="par">Código</th><th class="par">Producto</th><th class="par">Solicitado</th><th class="par">Despacho</th><th class="par">Faltante</th><th class="par">Vencimiento</th></tr></thead>
                    <tbody>
                    @foreach($parcial as $d)
                    <tr>
                        <td>{{ $d->product->sku ?? '—' }}</td>
                        <td class="l" style="font-weight:700;">{{ $d->product->nombre }}</td>
                        <td>{{ $n($d->cantidad_solicitada, 2) }}</td>
                        <td>{{ $n($d->cantidad_despachada, 2) }}</td>
                        <td style="font-weight:800;color:#a16207;">{{ $n($d->cantidad_solicitada - $d->cantidad_despachada, 2) }}</td>
                        <td>{{ $f($d->fecha_vencimiento ?? $d->product->fecha_vencimiento) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </td>
        @endif
    </tr>
</table>
@endif

{{-- FALTANTES (campos originales: producto, faltante) — respaldo si el detalle no los refleja --}}
@if(!empty($faltantes) && !$noDesp->count() && !$parcial->count())
<div class="panel" style="margin-top:8px;">
    <div class="sec"><span class="sec-ic red">✖</span>Productos no enviados</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead><tr><th style="text-align:left;">Producto</th><th>Cantidad faltante</th></tr></thead>
        <tbody>
        @foreach($faltantes as $fl)
        <tr>
            <td class="l">{{ $fl['producto'] }}</td>
            <td style="font-weight:800; color:#991b1b;">{{ $fl['faltante'] }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
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

{{-- FOOTER --}}
<table class="footer" cellpadding="0" cellspacing="0">
    <tr>
        <td>DISTAN ERP · Generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}</td>
        <td>{{ $order->numero_orden }}</td>
    </tr>
</table>

</body>
</html>
