<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

@page {
    margin: 30mm 25mm;
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
    line-height: 1.5;
    padding: 0 20px;
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
.doc-num-box {
    background: #7c3aed;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    padding: 6px 14px;
    border-radius: 3px;
    text-align: center;
}
.estado-chip {
    display: inline-block;
    margin-top: 6px;
    padding: 3px 10px;
    border-radius: 3px;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .05em;
}
.estado-completo { background: #dcfce7; color: #15803d; }
.estado-parcial  { background: #fef3c7; color: #b45309; }
.estado-incompleto { background: #fee2e2; color: #b91c1c; }

/* ── Info strip ── */
.info-strip {
    width: 100%;
    border-collapse: collapse;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    margin-bottom: 18px;
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

/* ── Tabla productos ── */
.tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: 9.5px;
    margin-bottom: 20px;
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
.mono { font-family: 'Courier New', monospace; }

/* ── Bultos ── */
.bulto-block {
    margin-bottom: 10px;
    break-inside: avoid;
}
.bulto-head {
    background: #1e3a5f;
    color: #fff;
    padding: 6px 10px;
    border-radius: 3px 3px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
    font-weight: 700;
}
.bulto-head .peso {
    background: rgba(255,255,255,.12);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 9px;
    font-family: 'Courier New', monospace;
}
.bulto-body {
    border: 1px solid #e2e8f0;
    border-top: none;
    border-radius: 0 0 3px 3px;
    padding: 8px 12px;
    font-size: 9.5px;
}
.bulto-item {
    display: flex;
    justify-content: space-between;
    padding: 3px 0;
    border-bottom: 1px dashed #f1f5f9;
}
.bulto-item:last-child { border-bottom: none; }
.bulto-item .cant {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    color: #1e3a5f;
}
.bulto-empty {
    color: #94a3b8;
    font-size: 9px;
    font-style: italic;
}

/* ── KPIs resumen ── */
.kpis {
    width: 100%;
    border-collapse: collapse;
    margin-top: 4px;
}
.kpis td {
    width: 25%;
    padding: 10px 12px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-left: 3px solid #1e3a5f;
}
.kpis td.blue   { border-left-color: #2563eb; }
.kpis td.purple { border-left-color: #7c3aed; }
.kpis td.green  { border-left-color: #15803d; }
.kpi-label {
    font-size: 8px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 3px;
}
.kpi-value {
    font-family: 'Courier New', monospace;
    font-size: 16px;
    font-weight: 800;
    color: #1e3a5f;
}

/* ── Footer ── */
.footer-table {
    width: 100%;
    border-collapse: collapse;
    border-top: 1px solid #e2e8f0;
    margin-top: 18px;
    padding-top: 8px;
}
.footer-table td {
    font-size: 8px;
    color: #94a3b8;
    padding-top: 6px;
}
.footer-table td:last-child { text-align: right; }

</style>
</head>
<body>

@php
    $ahora = \Carbon\Carbon::now('America/Lima');

    $totalPeso = 0;
    $totalUnidades = 0;

    // Bultos ordenados de forma correlativa (Bulto 1, 2, 3...) en vez del
    // orden que devuelva la relación por defecto (que puede salir por peso/insercion)
    $bultosOrdenados = $order->bultos->sortBy(function ($bulto) {
        return (int) preg_replace('/\D/', '', $bulto->nombre);
    })->values();

    $estadoClass = match($order->estado) {
        'COMPLETO'   => 'estado-completo',
        'PARCIAL'    => 'estado-parcial',
        default      => 'estado-incompleto',
    };
@endphp

{{-- ══ HEADER ══ --}}
<table class="header-table" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:140px; vertical-align:middle;">
            <div class="logo-block">
                <div class="logo-name">DISTHAN</div>
                <div class="logo-sub">Perú · Distribución</div>
            </div>
        </td>
        <td style="vertical-align:middle; padding-left:16px;">
            <div class="doc-title">Detalle de Encomienda</div>
            <div class="doc-subtitle">Orden: {{ $order->numero_orden }}</div>
        </td>
        <td style="width:130px; vertical-align:middle; text-align:right;">
            <div class="doc-num-box">📦 {{ $order->tipo_orden }}</div>
            <div class="estado-chip {{ $estadoClass }}">{{ $order->estado }}</div>
        </td>
    </tr>
</table>

{{-- ══ INFO STRIP ══ --}}
<table class="info-strip" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:28%;">
            <div class="info-label">Cliente</div>
            <div class="info-value">{{ $order->client->razon_social ?? '—' }}</div>
        </td>
        <td style="width:20%;">
            <div class="info-label">Fecha de pedido</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d/m/Y') }}</div>
        </td>
        <td style="width:20%;">
            <div class="info-label">Tipo de orden</div>
            <div class="info-value">{{ $order->tipo_orden }}</div>
        </td>
        <td style="width:16%;">
            <div class="info-label">Estado</div>
            <div class="info-value">{{ $order->estado }}</div>
        </td>
        <td style="width:16%;">
            <div class="info-label">Generado</div>
            <div class="info-value" style="font-size:9.5px;">{{ $ahora->format('d/m/Y H:i') }}</div>
        </td>
    </tr>
</table>

{{-- ══ PRODUCTOS ENVIADOS ══ --}}
<div class="sec-title">📦 1. Productos enviados</div>
<table class="tbl" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th style="width:46%;">Producto</th>
            <th style="width:18%;" class="center">Cantidad</th>
            <th style="width:18%;" class="center">Peso unit.</th>
            <th style="width:18%;" class="center">Peso total</th>
        </tr>
    </thead>
    <tbody>
    @foreach($order->details as $item)
        @php
            $pesoUnit = ($item->product->peso ?? 0) / 1000;
            $peso = $item->cantidad_despachada * $pesoUnit;
            $totalPeso += $peso;
            $totalUnidades += $item->cantidad_despachada;
        @endphp
        <tr>
            <td style="font-weight:600;color:#0f172a;">{{ $item->product->nombre }}</td>
            <td class="center mono" style="font-weight:700;">{{ number_format($item->cantidad_despachada, 0) }}</td>
            <td class="center mono">{{ number_format($pesoUnit, 3) }} kg</td>
            <td class="center mono" style="font-weight:700;color:#1e3a5f;">{{ number_format($peso, 2) }} kg</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>TOTALES</td>
            <td class="center">{{ number_format($totalUnidades, 0) }} u.</td>
            <td></td>
            <td class="center">{{ number_format($totalPeso, 2) }} kg</td>
        </tr>
    </tfoot>
</table>

{{-- ══ BULTOS ══ --}}
<div class="sec-title" style="margin-bottom:10px;">🧳 2. Bultos</div>

@forelse($bultosOrdenados as $bulto)
<div class="bulto-block">
    <div class="bulto-head">
        <span>{{ $bulto->nombre }}</span>
        <span class="peso">{{ number_format($bulto->peso_total, 2) }} kg</span>
    </div>
    <div class="bulto-body">
        @forelse($bulto->detalles as $detalle)
        <div class="bulto-item">
            <span>{{ $detalle->product->nombre ?? 'Producto eliminado' }}</span>
            <span class="cant">x {{ number_format($detalle->cantidad, 0) }}</span>
        </div>
        @empty
        <div class="bulto-empty">Sin productos asignados</div>
        @endforelse
    </div>
</div>
@empty
<div class="bulto-empty" style="margin-bottom:14px;">No hay bultos registrados para esta encomienda.</div>
@endforelse

{{-- ══ RESUMEN ══ --}}
<div class="sec-title" style="margin-bottom:10px;margin-top:6px;">📊 3. Resumen</div>
<table class="kpis" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="kpi-label">Productos diferentes</div>
            <div class="kpi-value">{{ $order->details->count() }}</div>
        </td>
        <td class="blue">
            <div class="kpi-label">Total unidades</div>
            <div class="kpi-value">{{ number_format($totalUnidades, 0) }}</div>
        </td>
        <td class="purple">
            <div class="kpi-label">Total bultos</div>
            <div class="kpi-value">{{ $order->bultos->count() }}</div>
        </td>
        <td class="green">
            <div class="kpi-label">Peso total</div>
            <div class="kpi-value">{{ number_format($totalPeso, 2) }} kg</div>
        </td>
    </tr>
</table>

{{-- ══ FOOTER ══ --}}
<table class="footer-table" cellpadding="0" cellspacing="0">
    <tr>
        <td>DISTHAN · Detalle de encomienda · Orden {{ $order->numero_orden }}</td>
        <td>Generado el {{ $ahora->format('d/m/Y \a \l\a\s H:i') }}</td>
    </tr>
</table>

</body>
</html>