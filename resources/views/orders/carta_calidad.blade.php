<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

@page {
    margin: 55px 50px;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
    color: #1e293b;
    background: #fff;
    line-height: 1.5;
    padding: 0 6px;
}

/* ── Header ── */
.header-table {
    width: 100%;
    border-collapse: collapse;
    border-bottom: 3px solid #1e3a5f;
    padding-bottom: 12px;
    margin-bottom: 16px;
}
.logo-block {
    background: #1e3a5f;
    color: #fff;
    padding: 8px 14px;
    border-radius: 4px;
    display: inline-block;
}
.logo-name {
    font-size: 18px;
    font-weight: 900;
    letter-spacing: 2px;
}
.logo-sub {
    font-size: 8px;
    color: #93c5fd;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-top: 2px;
}
.doc-title {
    font-size: 16px;
    font-weight: 900;
    color: #1e3a5f;
    letter-spacing: .5px;
}
.doc-subtitle {
    font-size: 9px;
    color: #64748b;
    margin-top: 3px;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.doc-num {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-top: 4px;
}
.cert-badge {
    background: #7c3aed;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 8px 14px;
    border-radius: 4px;
    text-align: center;
    letter-spacing: .06em;
    text-transform: uppercase;
}

/* ── Info strip ── */
.info-strip {
    width: 100%;
    border-collapse: collapse;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    margin-bottom: 14px;
    border-radius: 4px;
}
.info-strip td {
    padding: 8px 12px;
    border-right: 1px solid #e2e8f0;
    vertical-align: top;
}
.info-strip td:last-child { border-right: none; }
.info-label {
    font-size: 8px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 2px;
}
.info-value {
    font-size: 11px;
    font-weight: 700;
    color: #1e293b;
}

/* ── Sección título ── */
.sec-title {
    font-size: 9px;
    font-weight: 800;
    color: #fff;
    background: #1e3a5f;
    padding: 5px 10px;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 0;
}

/* ── Declaración de calidad ── */
.declaracion {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-left: 4px solid #22c55e;
    padding: 10px 14px;
    margin-bottom: 14px;
    font-size: 10px;
    color: #166534;
    line-height: 1.7;
}
.declaracion strong {
    font-weight: 800;
    font-size: 11px;
}

/* ── Tabla de productos ── */
.tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: 9.5px;
    margin-bottom: 6px;
}
.tbl thead th {
    background: #1e3a5f;
    color: #fff;
    padding: 7px 9px;
    text-align: left;
    font-size: 8.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.tbl thead th.center { text-align: center; }
.tbl tbody td {
    padding: 7px 9px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.tbl tbody td.center { text-align: center; }
.tbl tbody tr:nth-child(even) td { background: #f8fafc; }
.tbl tfoot td {
    padding: 7px 9px;
    background: #1e3a5f;
    color: #fff;
    font-weight: 700;
    font-size: 10px;
}
.tbl tfoot td.center { text-align: center; }

/* Nota al pie de tabla */
.tbl-note {
    font-size: 8px;
    color: #94a3b8;
    font-style: italic;
    margin-bottom: 16px;
}

/* Badges estado */
.badge-completo { color: #166534; font-weight: 800; }
.badge-parcial  { color: #92400e; font-weight: 800; }

/* Fecha vencimiento colores */
.venc-ok   { color: #166534; font-weight: 700; }
.venc-prox { color: #92400e; font-weight: 700; }
.venc-venc { color: #b91c1c; font-weight: 700; }

/* ── Condiciones ── */
.condiciones {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
}
.condiciones td {
    width: 50%;
    padding: 6px 10px;
    vertical-align: top;
    font-size: 9px;
    color: #475569;
}
.condicion-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 4px;
}
.condicion-bullet {
    color: #22c55e;
    font-weight: 900;
    margin-right: 5px;
    flex-shrink: 0;
}

/* ── Firmas ── */
.firma-section {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
}
.firma-section td {
    width: 33.3%;
    text-align: center;
    padding-top: 32px;
    border-top: 1px solid #334155;
    font-size: 9px;
    color: #475569;
    font-weight: 600;
    padding-left: 10px;
    padding-right: 10px;
}
.firma-cargo {
    font-size: 8px;
    color: #94a3b8;
    margin-top: 2px;
    text-transform: uppercase;
    letter-spacing: .05em;
}

/* ── Sello de calidad ── */
.sello {
    border: 3px solid #7c3aed;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin: 0 auto;
}
.sello-inner {
    font-size: 8px;
    font-weight: 800;
    color: #7c3aed;
    text-transform: uppercase;
    letter-spacing: .04em;
    line-height: 1.3;
}

/* ── Footer ── */
.footer-table {
    width: 100%;
    border-collapse: collapse;
    border-top: 1px solid #e2e8f0;
    margin-top: 16px;
    padding-top: 8px;
}
.footer-table td {
    font-size: 8px;
    color: #94a3b8;
    padding-top: 6px;
}
.footer-table td:last-child { text-align: right; }

/* ── Número de documento ── */
.doc-number-box {
    background: #7c3aed;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 12px;
    border-radius: 3px;
    display: inline-block;
    margin-top: 4px;
    letter-spacing: 1px;
}

</style>
</head>
<body>

@php
    $detalles  = $order->details()->with('product')->where('cantidad_despachada', '>', 0)->get();

    // Hora/fecha reales de Perú (evita que salga la hora del servidor en UTC)
    $ahora        = \Carbon\Carbon::now('America/Lima');
    $fechaEmision = $ahora->format('d/m/Y');
    $horaEmision  = $ahora->format('H:i');

    $totalUds     = $detalles->sum('cantidad_despachada');
    $totalLineas  = $detalles->count();

    // Calcular estado de vencimientos
    $sinFecha  = 0;
    $vigentes  = 0;
    $proximos  = 0;
    $vencidos  = 0;
    foreach ($detalles as $d) {
        $fv = $d->fecha_vencimiento ?? $d->product->fecha_vencimiento;
        if (!$fv) { $sinFecha++; continue; }
        $dias = $ahora->diffInDays(\Carbon\Carbon::parse($fv), false);
        if ($dias < 0)       $vencidos++;
        elseif ($dias <= 30) $proximos++;
        else                 $vigentes++;
    }
@endphp

{{-- ══ HEADER ══ --}}
<table class="header-table" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:140px; vertical-align:middle;">
            <div class="logo-block">
                <div class="logo-name">DISTAN</div>
                <div class="logo-sub">Perú · Distribución</div>
            </div>
        </td>
        <td style="vertical-align:middle; padding-left:16px;">
            <div class="doc-title">Carta de Calidad</div>
            <div class="doc-subtitle">Certificado de despacho · Pedido Local</div>
            <div class="doc-num">Orden: {{ $order->numero_orden }}</div>
            <div class="doc-number-box">CC-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
        </td>
        <td style="width:110px; vertical-align:middle; text-align:right;">
            <div class="cert-badge">
                🏅 Cert.<br>Calidad
            </div>
        </td>
    </tr>
</table>

{{-- ══ INFO STRIP ══ --}}
<table class="info-strip" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:35%;">
            <div class="info-label">Cliente</div>
            <div class="info-value">{{ $order->client?->razon_social ?? '—' }}</div>
        </td>
        <td style="width:20%;">
            <div class="info-label">Fecha de emisión</div>
            <div class="info-value">{{ $fechaEmision }}</div>
        </td>
        <td style="width:20%;">
            <div class="info-label">Hora</div>
            <div class="info-value">{{ $horaEmision }}</div>
        </td>
        <td style="width:12%;">
            <div class="info-label">Líneas</div>
            <div class="info-value">{{ $totalLineas }}</div>
        </td>
        <td style="width:13%;">
            <div class="info-label">Total u.</div>
            <div class="info-value">{{ number_format($totalUds) }}</div>
        </td>
    </tr>
</table>

{{-- ══ DECLARACIÓN DE CALIDAD ══ --}}
<div class="declaracion">
    <strong>Valle Fertil S.A.C.</strong> declara que los productos descritos en el presente documento
    han sido inspeccionados, verificados y despachados bajo los estándares de calidad establecidos por la empresa,
    cumpliendo con las normas de manipulación, almacenamiento y trazabilidad vigentes.
    Este certificado acredita que los productos entregados al cliente
    <strong>{{ $order->client?->razon_social ?? '—' }}</strong>
    se encuentran en óptimas condiciones al momento del despacho,
    con sus respectivas fechas de vencimiento y lotes de producción debidamente registrados.
</div>

{{-- ══ TABLA DE PRODUCTOS ══ --}}
<div class="sec-title">📦 Detalle de productos despachados</div>
<table class="tbl" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="width:4%;" class="center">#</th>
            <th style="width:27%;">Producto</th>
            <th style="width:10%;" class="center">Lote</th>
            <th style="width:12%;" class="center">Fecha prod.</th>
            <th style="width:13%;" class="center">Vencimiento</th>
            <th style="width:10%;" class="center">Despachado</th>
            <th style="width:13%;" class="center">Peso total*</th>
            <th style="width:11%;" class="center">Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach($detalles as $i => $d)
    @php
        $fv       = $d->fecha_vencimiento ?? $d->product->fecha_vencimiento;
        $fp       = $d->product->fecha_produccion;
        $diasVenc = $fv ? (int) round($ahora->diffInDays(\Carbon\Carbon::parse($fv), false)) : null;
        $vencClass = '';
        $vencIcon  = '';
        if ($diasVenc !== null) {
            if ($diasVenc < 0)       { $vencClass = 'venc-venc'; $vencIcon = '🔴 '; }
            elseif ($diasVenc <= 30) { $vencClass = 'venc-prox'; $vencIcon = '🟡 '; }
            else                     { $vencClass = 'venc-ok';   $vencIcon = '🟢 '; }
        }
        $pesoTotal = ($d->product->peso ?? 0) * $d->cantidad_despachada / 1000;
        $estadoD   = $d->cantidad_despachada >= $d->cantidad_solicitada ? 'COMPLETO' : 'PARCIAL';
    @endphp
    <tr>
        <td class="center" style="color:#94a3b8;font-size:8px;">{{ $i + 1 }}</td>
        <td style="font-weight:600;color:#0f172a;">
            {{ $d->product->nombre }}
            @if($d->product->sku)
            <br><span style="font-size:8px;color:#94a3b8;font-weight:400;">SKU: {{ $d->product->sku }}</span>
            @endif
        </td>
        <td class="center" style="font-weight:700;font-size:9px;color:#1e3a5f;">
            {{ $d->product->lote ?? '—' }}
        </td>
        <td class="center" style="color:#475569;">
            {{ $fp ? \Carbon\Carbon::parse($fp)->format('d/m/Y') : '—' }}
        </td>
        <td class="center">
            <span class="{{ $vencClass }}">
                {{ $vencIcon }}{{ $fv ? \Carbon\Carbon::parse($fv)->format('d/m/Y') : '—' }}
            </span>
            @if($diasVenc !== null && $diasVenc >= 0)
            <br><span style="font-size:8px;color:#94a3b8;">({{ $diasVenc }} días)</span>
            @endif
        </td>
        <td class="center" style="font-weight:800;font-size:12px;color:#1e3a5f;">
            {{ number_format($d->cantidad_despachada, 0) }}
        </td>
        <td class="center" style="color:#0369a1;">
            {{ number_format($pesoTotal, 3) }} kg
        </td>
        <td class="center">
            <span class="{{ $estadoD === 'COMPLETO' ? 'badge-completo' : 'badge-parcial' }}">
                {{ $estadoD }}
            </span>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right;font-size:9px;">TOTALES</td>
            <td class="center">{{ number_format($totalUds, 0) }} u.</td>
            <td class="center">
                {{ number_format($detalles->sum(fn($d) => ($d->product->peso ?? 0) * $d->cantidad_despachada / 1000), 3) }} kg
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>
<div class="tbl-note">* El peso total es aproximado/referencial; puede variar ligeramente según el producto y no representa un valor exacto.</div>

{{-- ══ CONDICIONES DE CALIDAD ══ --}}
<div class="sec-title" style="margin-bottom:8px;">✅ Condiciones de calidad certificadas</div>
<table class="condiciones" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Productos inspeccionados previo al despacho</div>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Temperatura y almacenamiento controlados</div>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Embalaje íntegro y en buenas condiciones</div>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Lotes de producción verificados y registrados</div>
        </td>
        <td>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Fechas de vencimiento dentro del rango aceptable</div>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Pesos y cantidades verificados contra la orden</div>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Producto libre de daños físicos visibles</div>
            <div class="condicion-item"><span class="condicion-bullet">✓</span> Trazabilidad completa disponible en sistema ERP</div>
        </td>
    </tr>
</table>

{{-- ══ RESUMEN DE VENCIMIENTOS ══ --}}
@if($totalLineas > 0)
<table style="width:100%;border-collapse:collapse;margin-bottom:14px;">
    <tr>
        <td style="width:25%;padding:6px 10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:4px;text-align:center;">
            <div style="font-size:8px;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Vigentes</div>
            <div style="font-size:16px;font-weight:800;color:#15803d;">{{ $vigentes }}</div>
            <div style="font-size:8px;color:#94a3b8;">productos</div>
        </td>
        <td style="width:3%;"></td>
        <td style="width:25%;padding:6px 10px;background:#fef3c7;border:1px solid #fde68a;border-radius:4px;text-align:center;">
            <div style="font-size:8px;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Próx. a vencer</div>
            <div style="font-size:16px;font-weight:800;color:#b45309;">{{ $proximos }}</div>
            <div style="font-size:8px;color:#94a3b8;">≤ 30 días</div>
        </td>
        <td style="width:3%;"></td>
        <td style="width:25%;padding:6px 10px;background:#fee2e2;border:1px solid #fca5a5;border-radius:4px;text-align:center;">
            <div style="font-size:8px;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Vencidos</div>
            <div style="font-size:16px;font-weight:800;color:#b91c1c;">{{ $vencidos }}</div>
            <div style="font-size:8px;color:#94a3b8;">productos</div>
        </td>
        <td style="width:3%;"></td>
        <td style="width:16%;padding:6px 10px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:4px;text-align:center;">
            <div style="font-size:8px;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Sin fecha</div>
            <div style="font-size:16px;font-weight:800;color:#64748b;">{{ $sinFecha }}</div>
            <div style="font-size:8px;color:#94a3b8;">productos</div>
        </td>
    </tr>
</table>
@endif

{{-- ══ FIRMAS ══ --}}
<table class="firma-section" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="sello">
                <div class="sello-inner">CERT.<br>CALIDAD<br>✓</div>
            </div>
            <div style="margin-top:6px;font-size:9px;color:#7c3aed;font-weight:700;">Sello de calidad</div>
            <div class="firma-cargo">Control de calidad</div>
        </td>
        <td>
            <div style="font-size:9px;font-weight:700;color:#1e293b;">Responsable de despacho</div>
            <div class="firma-cargo">Almacén · Valle Fertil S.A.C</div>
        </td>
        <td>
            <div style="font-size:9px;font-weight:700;color:#1e293b;">Recibido conforme</div>
            <div class="firma-cargo">{{ $order->client?->razon_social ?? 'Cliente' }}</div>
        </td>
    </tr>
</table>

{{-- ══ FOOTER ══ --}}
<table class="footer-table" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            Valle Fertil S.A.C. · Carta de Calidad Nº CC-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            · Generado el {{ $ahora->format('d/m/Y \a \l\a\s H:i') }}
        </td>
        <td>
            {{ $order->numero_orden }} · Este documento detalla información de los productos
        </td>
    </tr>
</table>

</body>
</html>