@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.25rem;background:#f1f5f9;min-height:100vh;}
.top-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.1rem;flex-wrap:wrap;gap:10px;}
.hdr-left h1{font-size:20px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.hdr-left p{font-size:12px;color:#94a3b8;margin-top:2px;}
.hdr-right{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.badge-estado{padding:5px 14px;border-radius:99px;font-size:12px;font-weight:700;color:#fff;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1.1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.8rem 1rem;display:flex;align-items:center;gap:10px;}
.kpi-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.kpi-label{font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;}
.kpi-val{font-size:18px;font-weight:700;color:#1e293b;line-height:1.1;}
.main-layout{display:grid;grid-template-columns:1fr 290px;gap:16px;}
@media(max-width:900px){.main-layout{grid-template-columns:1fr;}}
.left-col{display:flex;flex-direction:column;gap:14px;}
.right-col{display:flex;flex-direction:column;gap:12px;}
.scanner-card{background:#0f172a;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:12px;}
.scanner-label{font-size:12px;color:#94a3b8;font-weight:600;margin-bottom:4px;}
.scanner-input{width:100%;padding:10px 14px;font-size:16px;border-radius:8px;border:none;background:#1e293b;color:#f8fafc;outline:none;letter-spacing:1px;}
.scanner-input::placeholder{color:#475569;}
.scanner-input:focus{box-shadow:0 0 0 2px #2563eb;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.3;}}
.section-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;}
.sec-title{font-size:13px;font-weight:600;color:#1e293b;margin-bottom:.85rem;display:flex;align-items:center;gap:7px;}
.import-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.file-label{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:1px dashed #e2e8f0;border-radius:8px;font-size:12px;color:#64748b;cursor:pointer;background:#f8fafc;flex:1;transition:border-color .15s;}
.file-label:hover{border-color:#2563eb;color:#2563eb;}
.add-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:8px;align-items:end;}
@media(max-width:600px){.add-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;}
.prod-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;display:flex;flex-direction:column;gap:.65rem;border-left:4px solid;transition:transform .15s;}
.prod-card:hover{transform:translateY(-2px);}
.prod-top{display:flex;justify-content:space-between;align-items:flex-start;}
.prod-name{font-size:13px;font-weight:700;color:#0f172a;}
.prod-sku{font-size:10px;color:#94a3b8;margin-top:1px;}
.prod-badge{font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}
.info-strip{display:grid;grid-template-columns:1fr 1fr;gap:5px;background:#f8fafc;border-radius:8px;padding:7px 9px;}
.info-item{font-size:11px;color:#64748b;display:flex;align-items:center;gap:4px;}
.info-val{font-weight:600;color:#374151;}
.prog-mini{width:100%;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-mini-fill{height:100%;border-radius:99px;}
.fields-box{background:#f8fafc;border-radius:8px;padding:9px 10px;display:flex;flex-direction:column;gap:7px;}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:7px;}
.paleta-input{width:100%;padding:10px 14px;font-size:17px;border:2px solid #2563eb;border-radius:9px;text-align:center;font-weight:700;letter-spacing:3px;outline:none;background:#fff;transition:box-shadow .15s;}
.paleta-input:focus{box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.subtotal-row{display:flex;justify-content:space-between;align-items:center;}
.subtotal-val{font-size:14px;font-weight:700;color:#0f172a;}
.btn-row-prod{display:grid;grid-template-columns:1fr auto;gap:7px;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:5px;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-green{background:#16a34a;color:#fff;}
.btn-blue{background:#2563eb;color:#fff;}
.btn-gray{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.btn-red{background:#dc2626;color:#fff;}
.resumen-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem;}
.resumen-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:#64748b;padding:5px 0;border-bottom:1px solid #f1f5f9;}
.resumen-row:last-child{border:none;}
.resumen-val{font-weight:600;color:#1e293b;}
.resumen-total-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;margin-top:4px;}
.prog-resumen{padding:10px;background:#f8fafc;border-radius:9px;}
.prog-label{display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;}
.prog-bar{width:100%;height:7px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}
.legend{display:flex;flex-direction:column;gap:5px;margin-top:4px;}
.leg-row{display:flex;justify-content:space-between;align-items:center;font-size:12px;}
.leg-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-right:5px;display:inline-block;}

/* ══════════════════════════════
   MAPA DE PALETAS
══════════════════════════════ */
.paleta-map-card {
    background:#fff; border:1px solid #e2e8f0;
    border-radius:12px; overflow:hidden;
}
.paleta-map-header {
    background:#0f172a; padding:10px 14px;
    display:flex; align-items:center; justify-content:space-between;
}
.paleta-map-title {
    font-size:12px; font-weight:700; color:#f8fafc;
    display:flex; align-items:center; gap:7px;
}
.paleta-map-body { padding:12px; }

.paleta-map-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(110px,1fr));
    gap:8px;
}

/* Cada caja de paleta en el mapa */
.paleta-box {
    border-radius:10px; border:2px solid transparent;
    padding:10px 8px; text-align:center;
    cursor:pointer; transition:transform .15s, box-shadow .15s;
    position:relative; user-select:none;
}
.paleta-box:hover {
    transform:translateY(-3px);
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}
.paleta-box.estado-completo { background:#dcfce7; border-color:#86efac; }
.paleta-box.estado-parcial { background:#fef3c7; border-color:#fde68a; }
.paleta-box.estado-incompleto{ background:#fee2e2; border-color:#fca5a5; }
.paleta-box.estado-vacia { background:#f8fafc; border-color:#e2e8f0; }

.paleta-box-icon { font-size:22px; margin-bottom:4px; }
.paleta-box-name { font-size:12px; font-weight:800; color:#0f172a; }
.paleta-box-items { font-size:10px; color:#64748b; margin-top:2px; }
.paleta-box-pct { font-size:11px; font-weight:700; margin-top:3px; }
.paleta-box-bar { height:4px; border-radius:99px; background:#e5e7eb; overflow:hidden; margin-top:5px; }
.paleta-box-fill { height:100%; border-radius:99px; }

/* Aviso de paleta llena */
.paleta-box.paleta-llena { opacity:.85; }
.paleta-box-full-badge {
    position:absolute; top:6px; right:6px;
    background:#dc2626; color:#fff; font-size:9px; font-weight:800;
    padding:1px 6px; border-radius:99px;
}

/* Sin paleta chip */
.no-paleta-chip {
    display:flex; align-items:center; justify-content:space-between;
    background:#fff8f0; border:1px dashed #fed7aa;
    border-radius:8px; padding:7px 10px; font-size:12px;
    color:#92400e; margin-top:8px; cursor:pointer;
    transition:background .15s;
}
.no-paleta-chip:hover { background:#fef3e2; }

/* ══════════════════════════════
   MODAL DE DETALLE
══════════════════════════════ */
.pm-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.45); z-index:1000;
    align-items:center; justify-content:center; padding:16px;
}
.pm-overlay.open { display:flex; }
.pm-modal {
    background:#fff; border-radius:14px;
    width:480px; max-width:100%; max-height:90vh;
    overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.2);
    animation:mIn .16s ease;
}
@keyframes mIn{from{transform:scale(.95);opacity:0}to{transform:scale(1);opacity:1}}
.pm-header {
    padding:14px 18px; display:flex; align-items:center;
    justify-content:space-between; border-bottom:1px solid #f1f5f9;
    position:sticky; top:0; background:#fff; z-index:1;
}
.pm-title { font-size:15px; font-weight:700; color:#0f172a; }
.pm-sub { font-size:11px; color:#94a3b8; margin-top:2px; }
.pm-body { padding:16px 18px; }
.pm-close { background:none; border:none; font-size:20px; cursor:pointer; color:#94a3b8; padding:2px 6px; }

.pm-kpis { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-bottom:14px; }
.pm-kpi {
    background:#f8fafc; border-radius:9px; padding:8px 10px;
    text-align:center; border:1px solid #e2e8f0;
}
.pm-kpi-label { font-size:10px; color:#94a3b8; font-weight:600; text-transform:uppercase; }
.pm-kpi-val { font-size:17px; font-weight:700; color:#1e293b; margin-top:2px; }

.pm-prog-wrap { background:#f8fafc; border-radius:9px; padding:10px 12px; margin-bottom:14px; }
.pm-prog-hdr { display:flex; justify-content:space-between; font-size:11px; color:#64748b; margin-bottom:5px; }
.pm-prog-bar { height:8px; background:#e5e7eb; border-radius:99px; overflow:hidden; }
.pm-prog-fill { height:100%; border-radius:99px; }

.pm-item {
    display:flex; align-items:center; gap:10px;
    padding:9px 0; border-bottom:1px solid #f1f5f9;
}
.pm-item:last-child { border-bottom:none; }
.pm-item-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
.pm-item-name { flex:1; font-size:12px; font-weight:500; color:#374151; }
.pm-item-right{ display:flex; align-items:center; gap:8px; flex-shrink:0; }
.pm-item-qty { font-size:12px; font-weight:700; color:#0f172a; }
.pm-item-badge{ font-size:10px; font-weight:700; padding:2px 7px; border-radius:99px; }

.et-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1001;align-items:center;justify-content:center;padding:16px;}
.et-overlay.open{display:flex;}
.et-modal{background:#fff;border:1px solid #000;padding:22px 18px;width:300px;max-width:100%;text-align:center;}
.et-label{display:flex;flex-direction:column;align-items:center;gap:6px;color:#000;}
.et-nombre{font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:.03em;}
.et-cpc{font-size:11px;}
.et-info{margin-top:6px;font-size:11px;line-height:1.7;text-align:center;}
.et-actions{margin-top:16px;display:flex;gap:8px;justify-content:center;}
/* =========================================================
   VISOR 3D DE PALETA
========================================================= */

.p3d-overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(2,6,23,.72);
    z-index:3000;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.p3d-overlay.open {
    display:flex;
}

.p3d-modal {
    width:min(1100px,96vw);
    height:min(760px,92vh);
    background:#f8fafc;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 25px 80px rgba(0,0,0,.35);
    display:flex;
    flex-direction:column;
}

.p3d-header {
    background:#0f172a;
    color:#fff;
    padding:13px 18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
}

.p3d-title {
    font-size:16px;
    font-weight:800;
}

.p3d-subtitle {
    font-size:10px;
    color:#94a3b8;
    margin-top:2px;
}

.p3d-close {
    border:0;
    background:#1e293b;
    color:#fff;
    width:34px;
    height:34px;
    border-radius:7px;
    cursor:pointer;
    font-size:18px;
}

.p3d-body {
    flex:1;
    display:grid;
    grid-template-columns:1fr 270px;
    min-height:0;
}

@media(max-width:800px) {
    .p3d-body {
        grid-template-columns:1fr;
    }

    .p3d-panel {
        max-height:240px;
    }
}

/* Área donde gira la paleta */

.p3d-stage {
    position:relative;
    overflow:hidden;
    background:
        radial-gradient(circle at center,#ffffff 0,#f1f5f9 55%,#e2e8f0 100%);
    cursor:grab;
    perspective:1000px;
}

.p3d-stage.dragging {
    cursor:grabbing;
}

/* Contenedor 3D */

.p3d-world {
    position:absolute;
    left:50%;
    top:50%;
    width:600px;
    height:500px;
    transform-style:preserve-3d;
    transform:
        translate(-50%,-50%)
        rotateX(58deg)
        rotateZ(-28deg)
        scale(.85);
    transition:transform .08s linear;
}

/* Base de la paleta */

.p3d-pallet {
    position:absolute;
    left:50%;
    top:50%;
    width:520px;
    height:330px;
    transform:
        translate(-50%,-50%)
        translateZ(0);
    transform-style:preserve-3d;
}

.p3d-pallet-top {
    position:absolute;
    inset:0;
    background:
        repeating-linear-gradient(
            90deg,
            #b9824b 0,
            #b9824b 22px,
            #9f6c3e 23px,
            #9f6c3e 27px
        );
    border:4px solid #704214;
    border-radius:5px;
    box-shadow:
        0 15px 0 #704214,
        0 20px 25px rgba(0,0,0,.25);
}

/* Patas de la paleta */

.p3d-pallet-leg {
    position:absolute;
    width:55px;
    height:35px;
    background:#704214;
    bottom:-45px;
    border-radius:2px;
}

.p3d-pallet-leg.l1 {
    left:35px;
}

.p3d-pallet-leg.l2 {
    left:50%;
    transform:translateX(-50%);
}

.p3d-pallet-leg.l3 {
    right:35px;
}

/* =========================================================
   GRUPOS Y CAJAS 3D
========================================================= */

.p3d-product-group {
    position:absolute;
    transform-style:preserve-3d;
    cursor:grab;
    user-select:none;
    transition:filter .15s;
}

.p3d-product-group.dragging {
    cursor:grabbing;
}

.p3d-product-group:hover {
    filter:brightness(1.05);
}

/* Caja */

.p3d-box {
    position:absolute;
    transform-style:preserve-3d;
}

/*
|--------------------------------------------------------------------------
| CARA FRONTAL
|--------------------------------------------------------------------------
*/

.p3d-box-front {
    position:absolute;
    inset:0;

    display:flex;
    align-items:center;
    justify-content:center;

    text-align:center;

    padding:5px;

    font-size:9px;
    font-weight:800;

    border:2px solid;

    border-radius:3px;

    overflow:hidden;

    backface-visibility:hidden;
}

/*
|--------------------------------------------------------------------------
| PARTE SUPERIOR
|--------------------------------------------------------------------------
*/

.p3d-box-top {
    position:absolute;

    left:0;
    top:0;

    transform-origin:bottom left;

    border:2px solid;

    border-radius:3px 3px 0 0;

    transform:
        rotateX(90deg);

    transform-style:preserve-3d;
}

/*
|--------------------------------------------------------------------------
| LATERAL DERECHA
|--------------------------------------------------------------------------
*/

.p3d-box-side {
    position:absolute;

    right:0;
    top:0;

    transform-origin:right center;

    border:2px solid;

    border-radius:0 3px 3px 0;

    transform:
        rotateY(90deg);

    transform-style:preserve-3d;
}


/*
|--------------------------------------------------------------------------
| PANEL DE EDICIÓN
|--------------------------------------------------------------------------
*/

.p3d-edit-box {
    margin-top:10px;

    padding:10px;

    background:#f8fafc;

    border:1px solid #dbe3ee;

    border-radius:8px;
}

.p3d-edit-title {
    font-size:10px;

    font-weight:800;

    color:#334155;

    margin-bottom:8px;

    text-transform:uppercase;
}

.p3d-edit-row {
    display:grid;

    grid-template-columns:1fr auto;

    gap:7px;

    align-items:center;

    margin-bottom:7px;
}

.p3d-edit-row label {
    font-size:10px;

    color:#64748b;
}

.p3d-edit-row strong {
    font-size:10px;

    color:#0f172a;
}

.p3d-edit-row input[type="range"] {
    grid-column:1 / -1;

    width:100%;
}

/* Panel lateral */

.p3d-panel {
    background:#fff;
    border-left:1px solid #e2e8f0;
    overflow-y:auto;
    padding:15px;
}

.p3d-panel-title {
    font-size:12px;
    font-weight:800;
    color:#334155;
    margin-bottom:10px;
}

.p3d-product-row {
    border:1px solid #e2e8f0;
    border-radius:8px;
    padding:9px;
    margin-bottom:7px;
    cursor:pointer;
    transition:.15s;
}

.p3d-product-row:hover,
.p3d-product-row.selected {
    border-color:#2563eb;
    background:#eff6ff;
}

.p3d-product-name {
    font-size:11px;
    font-weight:700;
    color:#1e293b;
}

.p3d-product-meta {
    font-size:10px;
    color:#64748b;
    margin-top:3px;
}

.p3d-controls {
    margin-top:14px;
    border-top:1px solid #e2e8f0;
    padding-top:12px;
}

.p3d-control-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:10px;
    color:#64748b;
    margin-bottom:7px;
}

.p3d-control-row strong {
    color:#1e293b;
}

.p3d-range {
    width:100%;
}

.p3d-help {
    margin-top:12px;
    padding:8px;
    background:#f8fafc;
    border:1px dashed #cbd5e1;
    border-radius:6px;
    font-size:9px;
    color:#64748b;
    line-height:1.5;
}
</style>

<div class="pg">

{{-- ── Header ── --}}
@php
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d'
        : ($order->estado === 'PARCIAL' ? '#b45309' : '#b91c1c');
    $totalItems = $order->details->count();
    $completados = $order->details->where('estado_item','COMPLETO')->count();
    $faltantes = $totalItems - $completados;
    $porcentaje = $totalItems > 0 ? round(($completados / $totalItems) * 100) : 0;
    $progColor = $porcentaje === 100 ? '#22c55e' : ($porcentaje > 40 ? '#f59e0b' : '#ef4444');

    // ── Preparar datos de paletas para el mapa ──────────────────────────
    $paletas = $order->details
        ->filter(fn($d) => !empty($d->paleta))
        ->groupBy('paleta')
        ->sortKeys();

    $sinPaleta = $order->details->filter(fn($d) => empty($d->paleta));

    // ── Límite de ítems por paleta ──────────────────────────────────────
    $paletaMax = 10;
    $paletaCounts = $paletas->map->count();
@endphp

<div class="top-hdr">
    <div class="hdr-left">
        <h1>📋 {{ $order->numero_orden }}</h1>
        <p>{{ $order->client?->razon_social }}</p>
    </div>
    <div class="hdr-right">
        <span class="badge-estado" style="background:{{ $estadoColor }};">{{ $order->estado }}</span>
        <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="btn btn-green">📄 Ver PDF</a>
        <a href="{{ route('orders.pdf',$order) }}" class="btn btn-blue">⬇ Descargar</a>
        <button
    type="button"
    class="btn"
    onclick="abrirResumenOrden()"
    style="
        background:#111827;
        color:#fff;
        border:1px solid #111827;
        display:inline-flex;
        align-items:center;
        gap:5px;
        cursor:pointer;
    ">
    📋 Ver orden
</button>
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi">
        <div class="kpi-icon" style="background:#eff6ff;color:#2563eb;">🗂</div>
        <div><div class="kpi-label">Productos</div><div class="kpi-val">{{ $totalItems }}</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#dcfce7;color:#15803d;">✅</div>
        <div><div class="kpi-label">Completados</div><div class="kpi-val" style="color:#15803d;">{{ $completados }}</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#fee2e2;color:#b91c1c;">⚠️</div>
        <div><div class="kpi-label">Faltantes</div><div class="kpi-val" style="color:#b91c1c;">{{ $faltantes }}</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#dcfce7;color:#15803d;">💰</div>
        <div><div class="kpi-label">Total</div><div class="kpi-val" style="font-size:14px;color:#15803d;">S/ {{ number_format($order->total,2) }}</div></div>
    </div>
</div>

{{-- ── Layout ── --}}
<div class="main-layout">
    <div class="left-col">

        {{-- Scanner --}}
        <div class="scanner-card">
            <div style="width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse 1.5s infinite;"></div>
            <div style="flex:1;">
                <div class="scanner-label">📡 Escanear código de barras</div>
                <input type="text" id="scanner" class="scanner-input" placeholder="Escanea o escribe el código...">
            </div>
            <div style="font-size:10px;color:#475569;text-align:right;white-space:nowrap;">Enter para<br>confirmar</div>
        </div>

        {{-- Importar CSV --}}
        <div class="section-card">
            <div class="sec-title">📄 Importar pedido CSV</div>
            <form action="{{ route('orders.import',$order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="import-row">
                    <label class="file-label">
                        📎 Seleccionar archivo .csv
                        <input type="file" name="archivo" accept=".csv" required style="display:none;">
                    </label>
                    <button type="submit" class="btn btn-green">Importar</button>
                </div>
            </form>
        </div>

        {{-- Agregar producto --}}
        <div class="section-card">
            <div class="sec-title">➕ Agregar producto</div>
            <form method="POST" action="{{ route('orders.addProduct',$order) }}">
                @csrf
                <div class="add-grid">
                    <div>
                        <label class="flabel">Producto</label>
                        <select name="product_id" class="finput" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="flabel">Cantidad</label>
                        <input type="number" name="cantidad_solicitada" class="finput" placeholder="0" required>
                    </div>
                    <div>
                        <label class="flabel">Precio</label>
                        <input type="number" step="0.01" name="precio_unitario" class="finput" placeholder="0.00" required>
                    </div>
                    <button type="submit" class="btn btn-red" style="align-self:end;">Agregar</button>
                </div>
            </form>
        </div>

        {{-- Productos --}}
        <div class="products-grid">
            @foreach($order->details as $detail)
                @php
                    $s = $detail->estado_item;
                    $bc = $s === 'COMPLETO' ? '#22c55e' : ($s === 'PARCIAL' ? '#f59e0b' : '#ef4444');
                    $sc = $s === 'COMPLETO' ? '#15803d' : ($s === 'PARCIAL' ? '#b45309' : '#b91c1c');
                    $bg = $s === 'COMPLETO' ? '#dcfce7' : ($s === 'PARCIAL' ? '#fef3c7' : '#fee2e2');
                    $badgeCls = $s === 'COMPLETO' ? 'bc' : ($s === 'PARCIAL' ? 'bp' : 'bi');
                    $pct = $detail->cantidad_solicitada > 0
                        ? round(($detail->cantidad_despachada / $detail->cantidad_solicitada) * 100)
                        : 0;
                @endphp

                <div class="prod-card"
                    id="producto-{{ $detail->product->barcode }}"
                    data-barcode="{{ $detail->product->barcode }}"
                    data-box-barcode="{{ $detail->product->box_barcode }}">
                    <div class="prod-top">
                        <div>
                            <div class="prod-name">📦 {{ $detail->product->nombre }}</div>
                            <div class="prod-sku">SKU: {{ $detail->product->sku }}</div>
                        </div>
                        <span class="prod-badge {{ $badgeCls }}">{{ $s }}</span>
                    </div>
                    @php
                        $cpc = $detail->product->cantidad_por_caja ?? 1;
                        $cajasDesp = $cpc > 0 ? floor($detail->cantidad_despachada / $cpc) : 0;
                        $cajasSol = $cpc > 0 ? ceil($detail->cantidad_solicitada / $cpc) : 0;
                        $unidSueltas = $cpc > 0 ? ($detail->cantidad_despachada % $cpc) : 0;
                    @endphp
                    <div class="info-strip" style="grid-template-columns:1fr 1fr;">
                        <div class="info-item">📦 Stock: <span class="info-val">{{ $detail->product->stock }}</span></div>
                        <div class="info-item">⚖ <span class="info-val">{{ number_format($detail->product->peso/1000,3) }} kg</span></div>

                        {{-- Cajas solicitadas --}}
                        <div class="info-item" style="grid-column:1/-1;">
                            🗃 Cajas solicitadas:
                            <span class="info-val" style="color:#2563eb;">
                                {{ $cajasSol }} caja{{ $cajasSol !== 1 ? 's' : '' }}
                            </span>
                            <span style="font-size:10px;color:#94a3b8;margin-left:3px;">
                                ({{ $detail->cantidad_solicitada }} u · {{ $cpc }} u/caja)
                            </span>
                        </div>

                        {{-- Cajas despachadas --}}
                        <div class="info-item" style="grid-column:1/-1;">
                            ✅ Cajas despachadas:
                            <span class="info-val" style="color:{{ $bc }};">
                                {{ $cajasDesp }} caja{{ $cajasDesp !== 1 ? 's' : '' }}
                            </span>
                            @if($unidSueltas > 0)
                                <span style="font-size:10px;color:#f59e0b;margin-left:3px;">
                                    + {{ $unidSueltas }} u. sueltas
                                </span>
                            @endif
                        </div>

                        {{-- Barra de progreso --}}
                        <div class="info-item" style="grid-column:1/-1;gap:6px;">
                            <span style="font-size:10px;color:#94a3b8;white-space:nowrap;">Despacho:</span>
                            <div class="prog-mini" style="flex:1;">
                                <div class="prog-mini-fill" style="width:{{ $pct }}%;background:{{ $bc }};"></div>
                            </div>
                            <span style="font-size:10px;font-weight:700;color:{{ $sc }};margin-left:2px;">{{ $pct }}%</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('orders.updateDetail',$detail) }}"
                        data-detail-form
                        data-original-paleta="{{ $detail->paleta }}">
                        @csrf @method('PUT')
                        <div class="fields-box">
                            <div class="field-row">
                                <div><label class="flabel">Solicitado</label>
                                    <input type="number" step="0.01" name="cantidad_solicitada" class="finput" value="{{ $detail->cantidad_solicitada }}"></div>
                                <div><label class="flabel">Despachado</label>
                                    <input type="number" step="0.01" name="cantidad_despachada" id="despachado-{{ $detail->product->barcode }}" class="finput" value="{{ $detail->cantidad_despachada }}"></div>
                            </div>
                            <div><label class="flabel">Precio</label>
                                <input type="number" step="0.01" name="precio_unitario" class="finput" value="{{ $detail->precio_unitario }}"></div>
                            <hr class="dv">
                            <div>
                                <label class="flabel">Lote</label>
                                <input
                                    type="text"
                                    name="lote"
                                    class="finput"
                                    value="{{ $detail->lote }}"
                                    placeholder="Lote">
                            </div>
                            <div><label class="flabel">Vencimiento</label>
                                <input type="date" name="fecha_vencimiento" class="finput" value="{{ $detail->fecha_vencimiento ?? $detail->product->fecha_vencimiento }}"></div>
                        </div>
                        <div style="margin-top:7px;">
                            <label class="flabel">Paleta</label>
                            <input type="text" name="paleta" class="paleta-input"
                                value="{{ $detail->paleta }}" placeholder="P01"
                                oninput="this.value=this.value.toUpperCase()">
                        </div>
                        <div class="subtotal-row" style="margin-top:7px;">
                            <span style="font-size:11px;color:#64748b;">Subtotal</span>
                            <span class="subtotal-val">S/ {{ number_format($detail->cantidad_despachada * $detail->precio_unitario,2) }}</span>
                        </div>
                        <div class="btn-row-prod" style="margin-top:7px;">
                            <button type="submit" class="btn btn-blue" style="width:100%;">💾 Guardar</button>
                        </div>
                    </form>
                    <button type="button" class="btn btn-gray" style="width:100%;margin-top:4px;"
                        onclick="abrirEtiqueta({
                            detailId: {{ $detail->id }},
                            nombre: {{ Js::from($detail->product->nombre) }},
                            cantidadPorCaja: {{ (int) ($detail->product->cantidad_por_caja ?? 1) }},
                            codigo: {{ Js::from(
                                in_array(strtoupper(trim($order->client->razon_social ?? '')), [
                                    'HIPERMERCADOS TOTTUS ORIENTE SAC',
                                    'HIPERMERCADOS TOTTUS S.A',
                                ], true)
                                    ? ($detail->product->barcode ?? '')
                                    : ($detail->product->box_barcode ?? '')
                            ) }},
                            lote: {{ Js::from($detail->lote ?? '') }},
                            fecha: {{ Js::from($detail->fecha_vencimiento
                                ? \Carbon\Carbon::parse($detail->fecha_vencimiento)->format('d/m/Y')
                                : ($detail->product->fecha_vencimiento
                                    ? \Carbon\Carbon::parse($detail->product->fecha_vencimiento)->format('d/m/Y')
                                    : '')) }},
                            cantidadDespachada: {{ (float) $detail->cantidad_despachada }}
                        })">
    🏷️ Generar etiqueta
</button>
                    <form method="POST" action="{{ route('orders.details.destroy',$detail) }}"
                        onsubmit="return confirm('¿Eliminar {{ $detail->product->nombre }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-red" style="width:100%;margin-top:4px;">🗑 Eliminar</button>
                    </form>
                </div>
            @endforeach
        </div>

    </div>{{-- /.left-col --}}

    {{-- ── Right col ── --}}
    <div class="right-col">

        {{-- ══════════════════════════════════════════
             MAPA DE PALETAS
        ══════════════════════════════════════════ --}}
        <div class="paleta-map-card">
            <div class="paleta-map-header">
                <div class="paleta-map-title">
                    🪵 Mapa de paletas
                    <span style="background:#1e293b;color:#94a3b8;font-size:10px;padding:2px 8px;border-radius:99px;">
                        {{ $paletas->count() }} paleta{{ $paletas->count() !== 1 ? 's' : '' }}
                    </span>
                </div>
                <span style="font-size:10px;color:#475569;">Clic para ver detalle</span>
            </div>

            <div class="paleta-map-body">

                @if($paletas->isEmpty() && $sinPaleta->isEmpty())
                    <div style="text-align:center;padding:24px 0;color:#94a3b8;font-size:12px;">
                        <div style="font-size:28px;margin-bottom:6px;">🪵</div>
                        Sin paletas asignadas aún
                    </div>
                @else

                    <div class="paleta-map-grid">
                        @foreach($paletas as $nombrePaleta => $items)
                            @php
                                $totUds = $items->sum('cantidad_solicitada');
                                $despUds = $items->sum('cantidad_despachada');
                                $pesoKg = $items->sum(fn($i) => ($i->product->peso ?? 0) * $i->cantidad_solicitada / 1000);
                                $pctP = $totUds > 0 ? round(($despUds / $totUds) * 100) : 0;
                                $todoC = $items->every(fn($i) => $i->estado_item === 'COMPLETO');
                                $algunP = $items->contains(fn($i) => $i->estado_item === 'PARCIAL');
                                $estClass = $todoC ? 'estado-completo' : ($algunP ? 'estado-parcial' : 'estado-incompleto');
                                $pctColor = $todoC ? '#15803d' : ($algunP ? '#b45309' : '#b91c1c');
                                $fillColor= $todoC ? '#22c55e' : ($algunP ? '#f59e0b' : '#ef4444');
                                $icon = $todoC ? '✅' : ($algunP ? '⏳' : '⚠️');
                                $llena = $items->count() >= $paletaMax;

                                // Serializar items para el modal
                                $itemsJson = $items->map(fn($i) => [
                                    'nombre' => $i->product->nombre ?? 'Producto',
                                    'sku' => $i->product->sku ?? '',
                                    'solicitada' => $i->cantidad_solicitada,
                                    'despachada' => $i->cantidad_despachada,
                                    'estado' => $i->estado_item,
                                    'precio' => $i->precio_unitario,
                                    'subtotal' => $i->subtotal,
                                    'peso' => number_format(($i->product->peso ?? 0) / 1000, 3),
                                    'cantidad_por_caja' => $i->product->cantidad_por_caja ?? 1,
                                    'barcode' => $i->product->barcode,
                                    'box_barcode' => $i->product->box_barcode,
                                ])->values()->toJson();
                            @endphp

                            <div class="paleta-box {{ $estClass }} {{ $llena ? 'paleta-llena' : '' }}"
                                onclick="abrirPaleta({{ json_encode($nombrePaleta) }}, {{ $items->count() }}, {{ $totUds }}, {{ $despUds }}, {{ round($pesoKg,1) }}, {{ $pctP }}, {{ json_encode($fillColor) }}, {{ $itemsJson }})">
                                @if($llena)
                                    <span class="paleta-box-full-badge">LLENA</span>
                                @endif
                                <div class="paleta-box-icon">🪵</div>
                                <div class="paleta-box-name">{{ $nombrePaleta }}</div>
                                <div class="paleta-box-items">{{ $items->count() }}/{{ $paletaMax }} ítem{{ $items->count() > 1 ? 's' : '' }}</div>
                                <div class="paleta-box-pct" style="color:{{ $pctColor }};">{{ $icon }} {{ $pctP }}%</div>
                                <div class="paleta-box-bar">
                                    <div class="paleta-box-fill" style="width:{{ $pctP }}%;background:{{ $fillColor }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Sin paleta --}}
                    @if($sinPaleta->count())
                        @php
                            $spJson = $sinPaleta->map(fn($i) => [
                                'nombre' => $i->product->nombre ?? 'Producto',
                                'sku' => $i->product->sku ?? '',
                                'solicitada' => $i->cantidad_solicitada,
                                'despachada' => $i->cantidad_despachada,
                                'estado' => $i->estado_item,
                                'precio' => $i->precio_unitario,
                                'subtotal' => $i->subtotal,
                                'peso' => number_format(($i->product->peso ?? 0) / 1000, 3),
                                'cantidad_por_caja' => $i->product->cantidad_por_caja ?? 1,
                                'barcode' => $i->product->barcode,
                                'box_barcode' => $i->product->box_barcode,
                            ])->values()->toJson();
                        @endphp
                        <div class="no-paleta-chip"
                            onclick="abrirPaleta('Sin paleta', {{ $sinPaleta->count() }}, {{ $sinPaleta->sum('cantidad_solicitada') }}, {{ $sinPaleta->sum('cantidad_despachada') }}, 0, 0, '#94a3b8', {{ $spJson }})">
                            <span>⚠️ Sin paleta asignada</span>
                            <span style="font-weight:700;">{{ $sinPaleta->count() }} ítem{{ $sinPaleta->count() > 1 ? 's' : '' }} →</span>
                        </div>
                    @endif

                @endif
            </div>
        </div>

        {{-- Resumen financiero --}}
        <div class="resumen-card">
            <div class="sec-title">📊 Resumen</div>
            <hr class="dv" style="margin-bottom:8px;">
            <div class="resumen-row"><span>Productos</span><span class="resumen-val">{{ $order->details->count() }}</span></div>
            <div class="resumen-row"><span>Subtotal</span><span class="resumen-val">S/ {{ number_format($order->subtotal,2) }}</span></div>
            <div class="resumen-row"><span>IGV (18%)</span><span class="resumen-val">S/ {{ number_format($order->igv,2) }}</span></div>
            <div class="resumen-total-row">
                <span style="font-size:14px;font-weight:700;color:#0f172a;">Total</span>
                <span style="font-size:18px;font-weight:700;color:#15803d;">S/ {{ number_format($order->total,2) }}</span>
            </div>
        </div>

        {{-- Progreso --}}
        <div class="resumen-card">
            <div class="sec-title">📈 Progreso de despacho</div>
            <div class="prog-resumen">
                <div class="prog-label"><span>Completado</span><span style="font-weight:700;color:{{ $progColor }};">{{ $porcentaje }}%</span></div>
                <div class="prog-bar"><div class="prog-fill" style="width:{{ $porcentaje }}%;background:{{ $progColor }};"></div></div>
                <div style="font-size:10px;color:#94a3b8;margin-top:3px;">{{ $completados }} de {{ $totalItems }} productos</div>
            </div>
            <hr class="dv" style="margin:8px 0;">
            @php
                $parciales2 = $order->details->where('estado_item','PARCIAL')->count();
                $incompletos2 = $order->details->where('estado_item','INCOMPLETO')->count();
            @endphp
            <div class="legend">
                <div class="leg-row"><div style="display:flex;align-items:center;"><span class="leg-dot" style="background:#22c55e;"></span><span style="font-size:12px;color:#64748b;">Completo</span></div><span style="font-size:12px;font-weight:700;color:#15803d;">{{ $completados }}</span></div>
                <div class="leg-row"><div style="display:flex;align-items:center;"><span class="leg-dot" style="background:#f59e0b;"></span><span style="font-size:12px;color:#64748b;">Parcial</span></div><span style="font-size:12px;font-weight:700;color:#b45309;">{{ $parciales2 }}</span></div>
                <div class="leg-row"><div style="display:flex;align-items:center;"><span class="leg-dot" style="background:#ef4444;"></span><span style="font-size:12px;color:#64748b;">Incompleto</span></div><span style="font-size:12px;font-weight:700;color:#b91c1c;">{{ $incompletos2 }}</span></div>
            </div>
        </div>

        {{-- Info orden --}}
        <div class="resumen-card">
            <div class="sec-title">ℹ️ Info de la orden</div>
            <div class="resumen-row"><span>Fecha</span><span class="resumen-val">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}</span></div>
            <div class="resumen-row"><span>Tipo</span><span class="resumen-val">{{ $order->tipo_orden }}</span></div>
            <div class="resumen-row"><span>Cliente</span><span class="resumen-val" style="font-size:11px;max-width:140px;text-align:right;">{{ $order->client?->razon_social }}</span></div>
            <div class="resumen-row"><span>Estado</span><span style="font-size:11px;font-weight:700;color:{{ $estadoColor }};">{{ $order->estado }}</span></div>
        </div>

    </div>{{-- /.right-col --}}
</div>{{-- /.main-layout --}}
</div>{{-- /.pg --}}

{{-- ══════════════════════════════
     MODAL DETALLE DE PALETA
══════════════════════════════ --}}
<div class="pm-overlay" id="pmOverlay" onclick="cerrarPaleta(event)">
    <div class="pm-modal">
        <div class="pm-header">
            <div>
                <div class="pm-title" id="pmTitle"></div>
                <div class="pm-sub" id="pmSub"></div>
            </div>
            <button class="pm-close" onclick="document.getElementById('pmOverlay').classList.remove('open')">✕</button>
        </div>
        <div class="pm-body">

            {{-- Mini KPIs --}}
            <div class="pm-kpis">
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Ítems</div>
                    <div class="pm-kpi-val" id="pmItems"></div>
                </div>
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Unidades</div>
                    <div class="pm-kpi-val" id="pmUds"></div>
                </div>
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Peso total</div>
                    <div class="pm-kpi-val" id="pmPeso"></div>
                </div>
            </div>

            {{-- Progreso --}}
            <div class="pm-prog-wrap">
                <div class="pm-prog-hdr">
                    <span>Progreso de despacho</span>
                    <span id="pmPct" style="font-weight:700;"></span>
                </div>
                <div class="pm-prog-bar">
                    <div class="pm-prog-fill" id="pmProgFill"></div>
                </div>
                <div style="font-size:10px;color:#94a3b8;margin-top:3px;" id="pmProgSub"></div>
            </div>

            {{-- Lista de productos --}}
            <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Productos en esta paleta</div>
            <div id="pmItemsList"></div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════
     MODAL ETIQUETA DE PRODUCTO
══════════════════════════════ --}}
<div class="et-overlay" id="etOverlay" onclick="cerrarEtiqueta(event)">
    <div class="et-modal" onclick="event.stopPropagation()">
        <div class="et-label" id="etLabel">
            <div class="et-nombre" id="etNombre"></div>
            <div class="et-cpc" id="etCpc"></div>
            <svg id="etBarcode"></svg>
            <div class="et-info">
                <div>Lote: <span id="etLote"></span></div>
                <div>Fecha: <span id="etFecha"></span></div>
                <div>Cajas: <span id="etCajas"></span></div>
                <div>Unidades: <span id="etUnidades"></span></div>
            </div>
        </div>
        <div class="et-actions" data-etiqueta-url-template="{{ route('orders.details.etiqueta', ['item' => '__ID__']) }}">
            <a id="etPdfLink" href="#" target="_blank" class="btn btn-gray">🖨 Generar PDF</a>
            <button type="button" class="btn btn-gray" onclick="document.getElementById('etOverlay').classList.remove('open')">Cerrar</button>
        </div>
    </div>
</div>
{{-- =========================================================
     VISOR 3D DE PALETA
========================================================= --}}

<div
    class="p3d-overlay"
    id="p3dOverlay"
    onclick="cerrarPaleta3D(event)"
>

    <div
        class="p3d-modal"
        onclick="event.stopPropagation()"
    >

        {{-- CABECERA --}}

        <div class="p3d-header">

            <div>

                <div
                    class="p3d-title"
                    id="p3dTitle"
                >
                    🧊 Paleta
                </div>

                <div
                    class="p3d-subtitle"
                    id="p3dSubtitle"
                >
                    Vista 3D
                </div>

            </div>

            <button
                type="button"
                class="p3d-close"
                onclick="cerrarPaleta3D()"
            >
                ✕
            </button>

        </div>


        {{-- CUERPO --}}

        <div class="p3d-body">


            {{-- ESCENARIO --}}

            <div
                class="p3d-stage"
                id="p3dStage"
            >

                <div
                    class="p3d-world"
                    id="p3dWorld"
                >

                    <div
                        class="p3d-pallet"
                        id="p3dPallet"
                    >

                        <div class="p3d-pallet-top"></div>

                        <div class="p3d-pallet-leg l1"></div>
                        <div class="p3d-pallet-leg l2"></div>
                        <div class="p3d-pallet-leg l3"></div>

                    </div>

                </div>

            </div>


            {{-- PANEL --}}

            <div class="p3d-panel">

                <div class="p3d-panel-title">
                    📦 Productos de la paleta
                </div>

                <div id="p3dProducts"></div>

                <div id="p3dEditor"></div>
                <div class="p3d-controls">

                    <div class="p3d-control-row">
                        <span>Zoom</span>
                        <strong id="p3dZoomValue">85%</strong>
                    </div>

                    <input
                        type="range"
                        id="p3dZoom"
                        class="p3d-range"
                        min="55"
                        max="125"
                        value="85"
                    >


                    <div class="p3d-control-row" style="margin-top:12px;">
                        <span>Rotación horizontal</span>
                        <strong id="p3dRotYValue">-28°</strong>
                    </div>

                    <input
                        type="range"
                        id="p3dRotY"
                        class="p3d-range"
                        min="-180"
                        max="180"
                        value="-28"
                    >


                    <div class="p3d-control-row" style="margin-top:12px;">
                        <span>Inclinación</span>
                        <strong id="p3dRotXValue">58°</strong>
                    </div>

                    <input
                        type="range"
                        id="p3dRotX"
                        class="p3d-range"
                        min="25"
                        max="75"
                        value="58"
                    >


                    <div class="p3d-help">

                        🖱️ Arrastra la paleta para girarla.<br>
                        🔍 Usa Zoom para acercar o alejar.<br>
                        📦 Selecciona un producto para resaltarlo.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
// ── Scanner ──────────────────────────────────────────────────────────────
let scanner = document.getElementById('scanner');
scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    let codigo = this.value.trim();
    if(!codigo) return;
    let card = document.querySelector(
        '[data-barcode="' + codigo + '"], [data-box-barcode="' + codigo + '"]');
    if(card){
        card.scrollIntoView({ behavior:'smooth', block:'center' });
        card.style.boxShadow = "0 0 0 3px #2563eb";
        setTimeout(() => { card.style.boxShadow = ""; }, 1500);
        let barcode = card.dataset.barcode;
        let input = document.getElementById('despachado-' + barcode);
        if(input){ input.focus(); input.select(); }
        this.value = '';
        return;
    }
    fetch(`/api/producto/${codigo}`)
        .then(res => res.json())
        .then(producto => {
            if(!producto){ alert('Producto no encontrado'); return; }
            let select = document.querySelector('[name=product_id]');
            select.value = producto.id;
            document.querySelector('[name=precio_unitario]').value = producto.precio ?? 0;
            document.querySelector('[name=cantidad_solicitada]').focus();
        });
    this.value = '';
});

// ── Límite de ítems por paleta ─────────────────────────────────────────
const paletaCounts = {!! $paletaCounts->toJson() !!};
const PALETA_MAX = {{ $paletaMax }};

document.querySelectorAll('form[data-detail-form]').forEach(form => {
    form.addEventListener('submit', function (e) {
        const paletaInput = form.querySelector('[name="paleta"]');
        if (!paletaInput) return;

        const nueva = paletaInput.value.trim().toUpperCase();
        const original = (form.dataset.originalPaleta || '').trim().toUpperCase();

        // Solo valida si está cambiando a una paleta distinta (o asignando una nueva)
        if (nueva && nueva !== original) {
            const countActual = paletaCounts[nueva] || 0;
            if (countActual >= PALETA_MAX) {
                e.preventDefault();
                alert(`⚠️ La paleta ${nueva} ya tiene ${countActual} ítems (máximo ${PALETA_MAX}). No se pueden agregar más productos a esta paleta.`);
            }
        }
    });
});

// ── Modal de paleta ──────────────────────────────────────────────────────
function abrirPaleta(nombre, nItems, totUds, despUds, pesoKg, pct, fillColor, items) {
    document.getElementById('pmTitle').textContent = '🪵 ' + nombre;
    document.getElementById('pmSub').textContent = 'Detalle de contenido · ' + nItems + ' ítem' + (nItems !== 1 ? 's' : '');
    document.getElementById('pmItems').textContent = nItems;
    document.getElementById('pmUds').textContent = totUds;
    document.getElementById('pmPeso').textContent = pesoKg + ' kg';
    document.getElementById('pmPct').textContent = pct + '%';
    document.getElementById('pmPct').style.color = fillColor;
    document.getElementById('pmProgFill').style.width = pct + '%';
    document.getElementById('pmProgFill').style.background = fillColor;
    document.getElementById('pmProgSub').textContent = despUds + ' de ' + totUds + ' unidades despachadas';

    const estadoColors = {
        'COMPLETO' : { bg:'#dcfce7', color:'#15803d', dot:'#22c55e' },
        'PARCIAL' : { bg:'#fef3c7', color:'#b45309', dot:'#f59e0b' },
        'INCOMPLETO': { bg:'#fee2e2', color:'#b91c1c', dot:'#ef4444' },
    };

    let html = '';
    items.forEach(item => {
        const ec = estadoColors[item.estado] ?? { bg:'#f1f5f9', color:'#64748b', dot:'#94a3b8' };
        const itemPct = item.solicitada > 0 ? Math.round((item.despachada / item.solicitada) * 100) : 0;

        // ── Cálculo de cajas ──
        const cpc = item.cantidad_por_caja > 0 ? item.cantidad_por_caja : 1;
        const cajasSol = Math.ceil(item.solicitada / cpc);
        const cajasDesp = Math.floor(item.despachada / cpc);
        const sueltas = item.despachada % cpc;
        const cajasLabel = cajasDesp + ' / ' + cajasSol + ' caja' + (cajasSol !== 1 ? 's' : '');
        const sueltasHtml = sueltas > 0
            ? `<span style="font-size:10px;color:#f59e0b;margin-left:4px;">+${sueltas} u. sueltas</span>`
            : '';

        html += `
        <div class="pm-item">
            <div class="pm-item-dot" style="background:${ec.dot};"></div>
            <div class="pm-item-name">
                <div style="font-weight:600;">${item.nombre}</div>
                <div style="font-size:10px;color:#94a3b8;">
                    ${item.sku ? 'SKU: '+item.sku+' · ' : ''}${item.peso} kg · S/ ${parseFloat(item.precio).toFixed(2)}
                </div>

                {{-- Línea de cajas --}}
                <div style="
                    display:inline-flex;align-items:center;gap:4px;
                    margin-top:3px;
                    background:#eff6ff;border:1px solid #bfdbfe;
                    border-radius:4px;padding:2px 7px;
                    font-size:10px;font-weight:700;color:#1d4ed8;
                ">
                    🗃 ${cajasLabel}
                </div>
                ${sueltasHtml}

                <div style="height:3px;background:#e5e7eb;border-radius:99px;margin-top:5px;overflow:hidden;">
                    <div style="height:100%;width:${itemPct}%;background:${ec.dot};border-radius:99px;"></div>
                </div>
            </div>
            <div class="pm-item-right">
                <div class="pm-item-qty">${item.despachada}/${item.solicitada}</div>
                <span class="pm-item-badge" style="background:${ec.bg};color:${ec.color};">${item.estado}</span>
            </div>
        </div>`;
    });

    // Número de la paleta
    let numeroPaleta = nombre.replace(/\D/g,'');
    if(numeroPaleta === '')
        numeroPaleta = '0';
    numeroPaleta = numeroPaleta.padStart(4,'0');

    // SSCC
    let sscc = '50000014373324' + numeroPaleta;

    // Tabla logística
    let tabla = `
    <hr style="margin:18px 0">
    <h4 style="margin-bottom:10px;">📋 Hoja logística</h4>
    <table style="width:100%;border-collapse:collapse;font-size:11px;">
        <thead>
            <tr style="background:#f1f5f9;">
                <th style="padding:6px;border:1px solid #ddd;">DUM13</th>
                <th style="padding:6px;border:1px solid #ddd;">DUM14</th>
                <th style="padding:6px;border:1px solid #ddd;">DESCRIPCIÓN</th>
                <th style="padding:6px;border:1px solid #ddd;">UXB</th>
                <th style="padding:6px;border:1px solid #ddd;">BULTOS</th>
            </tr>
        </thead>
        <tbody>
    `;

    items.forEach(item=>{
        let bultos = Math.ceil(item.despachada / item.cantidad_por_caja);
        tabla += `
        <tr>
            <td style="border:1px solid #ddd;padding:5px;">${item.barcode}</td>
            <td style="border:1px solid #ddd;padding:5px;">${item.box_barcode}</td>
            <td style="border:1px solid #ddd;padding:5px;">${item.nombre}</td>
            <td style="border:1px solid #ddd;padding:5px;text-align:center;">${item.cantidad_por_caja}</td>
            <td style="border:1px solid #ddd;padding:5px;text-align:center;">${bultos}</td>
        </tr>
        `;
    });

    tabla += `
        </tbody>
    </table>
    <div style="margin-top:18px;text-align:center;">
        <div style="font-size:13px;font-weight:bold;">SSCC</div>
        <div style="font-size:20px;font-weight:bold;letter-spacing:2px;margin-top:6px;">${sscc}</div>
        <div style="display:flex;justify-content:center;margin-top:15px;">
            <svg id="barcode"></svg>
        </div>
    </div>
    `;
    tabla += `
<div style="
    margin-top:20px;
    display:flex;
    flex-direction:column;
    gap:7px;
">

    <a
        href="/orders/{{ $order->id }}/pallet/${encodeURIComponent(nombre)}/pdf"
        target="_blank"
        class="btn btn-blue"
        style="width:100%;"
    >
        🖨 Generar Hoja Logística
    </a>

    <button
        type="button"
        class="btn"
        style="
            width:100%;
            background:#111827;
            color:#fff;
        "
        onclick='abrirPaleta3D(
            ${JSON.stringify(nombre)},
            ${JSON.stringify(items)}
        )'
    >
        🧊 Ver paleta en 3D
    </button>

</div>
`;

    document.getElementById('pmItemsList').innerHTML = html + tabla;

    JsBarcode("#barcode", sscc, {
        format:"CODE128",
        width:2,
        height:60,
        displayValue:true
    });

    document.getElementById('pmOverlay').classList.add('open');
}

function cerrarPaleta(e) {
    if (e.target.id === 'pmOverlay') {
        document.getElementById('pmOverlay').classList.remove('open');
    }
}
// =========================================================
// VISOR 3D DE PALETA
// =========================================================

let p3dData = [];
let p3dSelected = null;

let p3dZoom = 85;
let p3dRotX = 58;
let p3dRotY = -28;

let p3dDragging = false;
let p3dStartX = 0;
let p3dStartY = 0;


/**
 * Abrir visor 3D
 */
function abrirPaleta3D(nombre, items)
{
    p3dData = items || [];
    p3dSelected = null;

    document.getElementById('p3dTitle').textContent =
        '🧊 Paleta ' + nombre;

    document.getElementById('p3dSubtitle').textContent =
        p3dData.length +
        ' ítem' +
        (p3dData.length !== 1 ? 's' : '') +
        ' · máximo {{ $paletaMax }} productos';


    document.getElementById('p3dOverlay')
        .classList.add('open');


    document.body.style.overflow = 'hidden';


    p3dZoom = 85;
    p3dRotX = 58;
    p3dRotY = -28;


    document.getElementById('p3dZoom').value = p3dZoom;
    document.getElementById('p3dRotX').value = p3dRotX;
    document.getElementById('p3dRotY').value = p3dRotY;


    renderPaleta3D();

    renderP3dProducts();

    actualizarP3dTransform();
}


/**
 * Cerrar
 */
function cerrarPaleta3D(event)
{
    if (
        event &&
        event.target &&
        event.target.id !== 'p3dOverlay'
    ) {
        return;
    }

    document.getElementById('p3dOverlay')
        .classList.remove('open');

    document.body.style.overflow = '';
}


/**
 * Renderizar productos
 */
function renderP3dProducts()
{
    const contenedor =
        document.getElementById('p3dProducts');

    contenedor.innerHTML = '';

    p3dData.forEach((item, index) => {

        const cpc =
            Number(item.cantidad_por_caja) > 0
                ? Number(item.cantidad_por_caja)
                : 1;

        const unidades =
            Number(item.despachada || 0);

        const cajas =
            Math.ceil(unidades / cpc);

        const row =
            document.createElement('div');

        row.className =
            'p3d-product-row';

        row.dataset.index = index;

        row.innerHTML = `

            <div class="p3d-product-name">
                📦 ${item.nombre}
            </div>

            <div class="p3d-product-meta">
                ${cajas} cajas ·
                ${unidades} unidades
            </div>

            <div class="p3d-product-meta">
                ${item.sku ? 'SKU: ' + item.sku : ''}
            </div>

        `;

        row.addEventListener('click', function() {

            seleccionarProducto3D(index);

        });

        contenedor.appendChild(row);

    });
}
function renderPaleta3D()
{
    const pallet =
        document.getElementById('p3dPallet');

    pallet
        .querySelectorAll('.p3d-product-group')
        .forEach(el => el.remove());


    /*
    |--------------------------------------------------------------------------
    | Dimensiones visuales de la paleta
    |--------------------------------------------------------------------------
    */

    const palletWidth = 520;
    const palletDepth = 330;


    /*
    |--------------------------------------------------------------------------
    | Crear cada producto
    |--------------------------------------------------------------------------
    */

    p3dData.forEach((item, index) => {

        const cpc =
            Number(item.cantidad_por_caja) > 0
                ? Number(item.cantidad_por_caja)
                : 1;

        const unidades =
            Number(item.despachada || 0);

        const cajas =
            Math.max(
                1,
                Math.ceil(unidades / cpc)
            );


        /*
        |--------------------------------------------------------------------------
        | Configuración inicial
        |--------------------------------------------------------------------------
        */

        if (item.p3d === undefined) {

            const col =
                index % 3;

            const row =
                Math.floor(index / 3);

            item.p3d = {

                x: 30 + (col * 160),

                y: 30 + (row * 95),

                width: 75,

                depth: 55,

                height: 18,

                rotation: 0

            };

        }


        const config =
            item.p3d;


        /*
        |--------------------------------------------------------------------------
        | Grupo
        |--------------------------------------------------------------------------
        */

        const group =
            document.createElement('div');

        group.className =
            'p3d-product-group';

        group.dataset.index =
            index;


        group.style.left =
            config.x + 'px';

        group.style.top =
            config.y + 'px';

        group.style.width =
            config.width + 'px';

        group.style.height =
            config.depth + 'px';


        group.style.transform =
            `rotateZ(${config.rotation}deg)`;


        /*
        |--------------------------------------------------------------------------
        | Colores
        |--------------------------------------------------------------------------
        */

        const colores = [

            ['#dbeafe','#2563eb','#1e3a8a'],

            ['#dcfce7','#16a34a','#166534'],

            ['#fef3c7','#f59e0b','#92400e'],

            ['#fce7f3','#db2777','#9d174d'],

            ['#ede9fe','#7c3aed','#5b21b6'],

            ['#cffafe','#0891b2','#155e75']

        ];


        const color =
            colores[index % colores.length];


        /*
        |--------------------------------------------------------------------------
        | Número de cajas visibles
        |--------------------------------------------------------------------------
        |
        | No dibujamos cientos de divs.
        | Representamos las cajas como una pila.
        |
        */

        const cajasVisibles =
            Math.min(cajas, 12);


        for (
            let c = 0;
            c < cajasVisibles;
            c++
        ) {

            const caja =
                document.createElement('div');

            caja.className =
                'p3d-box';


            /*
            |--------------------------------------------------------------------------
            | Posición vertical
            |--------------------------------------------------------------------------
            */

            const z =
                c * config.height;


            caja.style.width =
                config.width + 'px';

            caja.style.height =
                config.depth + 'px';


            caja.style.transform =
                `translateZ(${z}px)`;


            /*
            |--------------------------------------------------------------------------
            | Cara frontal
            |--------------------------------------------------------------------------
            */

            const front =
                document.createElement('div');

            front.className =
                'p3d-box-front';

            front.style.background =
                color[0];

            front.style.borderColor =
                color[1];

            front.style.color =
                color[2];

            front.textContent =
                item.nombre;


            /*
            |--------------------------------------------------------------------------
            | Cara superior
            |--------------------------------------------------------------------------
            */

            const top =
                document.createElement('div');

            top.className =
                'p3d-box-top';

            top.style.width =
                config.width + 'px';

            top.style.height =
                config.depth + 'px';

            top.style.background =
                color[0];

            top.style.borderColor =
                color[1];


            /*
            |--------------------------------------------------------------------------
            | Cara lateral
            |--------------------------------------------------------------------------
            */

            const side =
                document.createElement('div');

            side.className =
                'p3d-box-side';

            side.style.width =
                config.depth + 'px';

            side.style.height =
                config.depth + 'px';

            side.style.background =
                color[1];

            side.style.borderColor =
                color[1];


            caja.appendChild(front);

            caja.appendChild(top);

            caja.appendChild(side);


            group.appendChild(caja);

        }


        /*
        |--------------------------------------------------------------------------
        | Arrastrar producto
        |--------------------------------------------------------------------------
        */

        configurarDragProducto(
            group,
            index
        );


        pallet.appendChild(group);

    });

}
function configurarDragProducto(group, index)
{
    let dragging = false;

    let startX = 0;
    let startY = 0;

    let originalX = 0;
    let originalY = 0;


    group.addEventListener(
        'mousedown',
        function(event)
        {
            event.stopPropagation();

            seleccionarProducto3D(index);


            dragging = true;

            group.classList.add(
                'dragging'
            );


            startX =
                event.clientX;

            startY =
                event.clientY;


            originalX =
                p3dData[index].p3d.x;

            originalY =
                p3dData[index].p3d.y;


            document.body.style.userSelect =
                'none';
        }
    );


    window.addEventListener(
        'mousemove',
        function(event)
        {
            if (!dragging) {
                return;
            }


            const dx =
                event.clientX - startX;

            const dy =
                event.clientY - startY;


            /*
            |--------------------------------------------------------------------------
            | Movimiento visual
            |--------------------------------------------------------------------------
            */

            let nuevoX =
                originalX + dx / (p3dZoom / 100);

            let nuevoY =
                originalY + dy / (p3dZoom / 100);


            /*
            |--------------------------------------------------------------------------
            | Límites de la paleta
            |--------------------------------------------------------------------------
            */

            const palletWidth =
                520;

            const palletDepth =
                330;


            const width =
                p3dData[index].p3d.width;

            const depth =
                p3dData[index].p3d.depth;


            nuevoX =
                Math.max(
                    0,
                    Math.min(
                        palletWidth - width,
                        nuevoX
                    )
                );


            nuevoY =
                Math.max(
                    0,
                    Math.min(
                        palletDepth - depth,
                        nuevoY
                    )
                );


            p3dData[index].p3d.x =
                nuevoX;

            p3dData[index].p3d.y =
                nuevoY;


            group.style.left =
                nuevoX + 'px';

            group.style.top =
                nuevoY + 'px';


            actualizarEstadoPosicion(
                index
            );


            actualizarEditor3D();

        }
    );


    window.addEventListener(
        'mouseup',
        function()
        {
            if (!dragging) {
                return;
            }


            dragging = false;

            group.classList.remove(
                'dragging'
            );


            document.body.style.userSelect =
                '';

        }
    );
}
function seleccionarProducto3D(index)
{
    p3dSelected = index;


    /*
    |--------------------------------------------------------------------------
    | Resaltar producto
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.p3d-product-row')
        .forEach(row => {

            row.classList.toggle(
                'selected',
                Number(row.dataset.index) === index
            );

        });


    document
        .querySelectorAll('.p3d-product-group')
        .forEach(group => {

            const seleccionado =
                Number(group.dataset.index) === index;


            group.style.filter =
                seleccionado

                    ? 'brightness(1.12) drop-shadow(0 0 12px rgba(37,99,235,.65))'

                    : '';

        });


    /*
    |--------------------------------------------------------------------------
    | Mostrar editor
    |--------------------------------------------------------------------------
    */

    actualizarEditor3D();
}
function actualizarEditor3D()
{
    const editor =
        document.getElementById(
            'p3dEditor'
        );

if (!editor) {
    console.error('No existe el elemento #p3dEditor');
    return;
}
    if (
        p3dSelected === null ||
        !p3dData[p3dSelected]
    ) {

        editor.innerHTML = '';

        return;

    }


    const item =
        p3dData[p3dSelected];

    const config =
        item.p3d;


    editor.innerHTML = `

        <div class="p3d-edit-box">

            <div class="p3d-edit-title">

                ⚙️ Ajustar ${item.nombre}

            </div>


            <div class="p3d-edit-row">

                <label>
                    Ancho
                </label>

                <strong>
                    ${Math.round(config.width)} px
                </strong>

                <input
                    type="range"
                    min="40"
                    max="180"
                    value="${config.width}"
                    oninput="editarP3D('width',this.value)"
                >

            </div>


            <div class="p3d-edit-row">

                <label>
                    Profundidad
                </label>

                <strong>
                    ${Math.round(config.depth)} px
                </strong>

                <input
                    type="range"
                    min="35"
                    max="150"
                    value="${config.depth}"
                    oninput="editarP3D('depth',this.value)"
                >

            </div>


            <div class="p3d-edit-row">

                <label>
                    Altura entre cajas
                </label>

                <strong>
                    ${Math.round(config.height)} px
                </strong>

                <input
                    type="range"
                    min="8"
                    max="40"
                    value="${config.height}"
                    oninput="editarP3D('height',this.value)"
                >

            </div>


            <div class="p3d-edit-row">

                <label>
                    Rotación
                </label>

                <strong>
                    ${Math.round(config.rotation)}°
                </strong>

                <input
                    type="range"
                    min="-45"
                    max="45"
                    value="${config.rotation}"
                    oninput="editarP3D('rotation',this.value)"
                >

            </div>


            <div
                id="p3dPositionStatus"
                style="
                    margin-top:8px;
                    font-size:9px;
                    text-align:center;
                    padding:5px;
                    border-radius:6px;
                "
            ></div>

        </div>

    `;


    actualizarEstadoPosicion(
        p3dSelected
    );
}
function editarP3D(propiedad, valor)
{
    if (
        p3dSelected === null ||
        !p3dData[p3dSelected]
    ) {
        return;
    }


    const item =
        p3dData[p3dSelected];

    const config =
        item.p3d;


    config[propiedad] =
        Number(valor);


    /*
    |--------------------------------------------------------------------------
    | Volvemos a dibujar solamente el visor
    |--------------------------------------------------------------------------
    */

    renderPaleta3D();


    /*
    | Mantener seleccionado
    */

    seleccionarProducto3D(
        p3dSelected
    );
}
function actualizarEstadoPosicion(index)
{
    const status =
        document.getElementById(
            'p3dPositionStatus'
        );


    if (
        !status ||
        !p3dData[index]
    ) {
        return;
    }


    const config =
        p3dData[index];


    const palletWidth =
        520;

    const palletDepth =
        330;


    const dentro =
        config.x >= 0 &&
        config.y >= 0 &&
        config.x + config.width <= palletWidth &&
        config.y + config.depth <= palletDepth;


    if (dentro) {

        status.textContent =
            '🟢 Producto dentro de la paleta';

        status.style.background =
            '#dcfce7';

        status.style.color =
            '#15803d';

    } else {

        status.textContent =
            '🔴 Producto fuera de la paleta';

        status.style.background =
            '#fee2e2';

        status.style.color =
            '#b91c1c';

    }
}
/**
 * Transformación de la cámara
 */
function actualizarP3dTransform()
{
    const world =
        document.getElementById('p3dWorld');

    world.style.transform = `
        translate(-50%,-50%)
        rotateX(${p3dRotX}deg)
        rotateZ(${p3dRotY}deg)
        scale(${p3dZoom / 100})
    `;


    document.getElementById(
        'p3dZoomValue'
    ).textContent =
        p3dZoom + '%';


    document.getElementById(
        'p3dRotXValue'
    ).textContent =
        p3dRotX + '°';


    document.getElementById(
        'p3dRotYValue'
    ).textContent =
        p3dRotY + '°';
}


/**
 * Controles
 */
document.getElementById('p3dZoom')
    ?.addEventListener('input', function() {

        p3dZoom =
            Number(this.value);

        actualizarP3dTransform();

    });


document.getElementById('p3dRotX')
    ?.addEventListener('input', function() {

        p3dRotX =
            Number(this.value);

        actualizarP3dTransform();

    });


document.getElementById('p3dRotY')
    ?.addEventListener('input', function() {

        p3dRotY =
            Number(this.value);

        actualizarP3dTransform();

    });


/**
 * Arrastrar para girar
 */
const p3dStage =
    document.getElementById('p3dStage');


p3dStage?.addEventListener(
    'mousedown',
    function(event) {

        if (
            event.target.closest(
                '.p3d-product-group'
            )
        ) {
            return;
        }

        p3dDragging = true;

        p3dStartX =
            event.clientX;

        p3dStartY =
            event.clientY;

        p3dStage.classList.add(
            'dragging'
        );

    }
);


window.addEventListener(
    'mousemove',
    function(event) {

        if (!p3dDragging) {
            return;
        }

        const dx =
            event.clientX - p3dStartX;

        const dy =
            event.clientY - p3dStartY;


        p3dRotY +=
            dx * .5;

        p3dRotX -=
            dy * .3;


        p3dRotX =
            Math.max(
                25,
                Math.min(75,p3dRotX)
            );


        p3dStartX =
            event.clientX;

        p3dStartY =
            event.clientY;


        document.getElementById(
            'p3dRotX'
        ).value = p3dRotX;


        document.getElementById(
            'p3dRotY'
        ).value = p3dRotY;


        actualizarP3dTransform();

    }
);


window.addEventListener(
    'mouseup',
    function() {

        p3dDragging = false;

        p3dStage?.classList.remove(
            'dragging'
        );

    }
);

/**
 * ESC para cerrar
 */
document.addEventListener(
    'keydown',
    function(event) {

        if(
            event.key === 'Escape' &&
            document
                .getElementById('p3dOverlay')
                ?.classList.contains('open')
        ) {
            cerrarPaleta3D();
        }

    }
);
// ── Modal de etiqueta de producto ─────────────────────────────────────────
function abrirEtiqueta(data) {
    document.getElementById('etNombre').textContent = data.nombre;
    document.getElementById('etCpc').textContent = data.cantidadPorCaja + ' unid. por caja';

    const cpc = data.cantidadPorCaja > 0 ? data.cantidadPorCaja : 1;
    const cajas = Math.floor(data.cantidadDespachada / cpc);
    const sueltas = data.cantidadDespachada % cpc;

    document.getElementById('etLote').textContent = data.lote || '—';
    document.getElementById('etFecha').textContent = data.fecha || '—';
    document.getElementById('etCajas').textContent = cajas;
    document.getElementById('etUnidades').textContent =
        data.cantidadDespachada + (sueltas > 0 ? ' (' + sueltas + ' sueltas)' : '');

    const barcodeEl = document.getElementById('etBarcode');
    barcodeEl.innerHTML = '';

    const codigo = (data.codigo || '').toString().trim();

    if (codigo) {
        try {
            JsBarcode(barcodeEl, codigo, {
                format: "CODE128",
                width: 2,
                height: 60,
                displayValue: true,
                lineColor: "#000",
                background: "#fff"
            });
        } catch (err) {
            console.error('Código inválido:', codigo, err);
            barcodeEl.outerHTML = '<div id="etBarcode" style="font-size:11px;color:#b91c1c;">Código no válido: ' + codigo + '</div>';
        }
    } else {
        barcodeEl.outerHTML = '<div id="etBarcode" style="font-size:11px;color:#b91c1c;">Sin código registrado</div>';
    }

    const urlTemplate = document.querySelector('.et-actions').dataset.etiquetaUrlTemplate;
    document.getElementById('etPdfLink').href = urlTemplate.replace('__ID__', data.detailId);

    document.getElementById('etOverlay').classList.add('open');
}
</script>
{{-- =========================================================
     MODAL RESUMEN DE ORDEN
========================================================= --}}

<div id="modalResumenOrden"
     style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.55);
        z-index:9999;
        align-items:center;
        justify-content:center;
        padding:20px;
     ">

    <div style="
        background:#fff;
        width:min(1000px, 95vw);
        max-height:90vh;
        border-radius:10px;
        box-shadow:0 20px 50px rgba(0,0,0,.25);
        display:flex;
        flex-direction:column;
        overflow:hidden;
    ">

        {{-- CABECERA --}}
        <div style="
            padding:15px 18px;
            border-bottom:1px solid #e5e7eb;
            display:flex;
            align-items:center;
            justify-content:space-between;
        ">

            <div>
                <div style="
                    font-size:17px;
                    font-weight:800;
                    color:#111827;
                ">
                    📋 Resumen de orden
                </div>

                <div style="
                    font-size:12px;
                    color:#6b7280;
                    margin-top:3px;
                ">
                    Orden #{{ $order->numero_orden }}
                </div>
            </div>

            <button
                type="button"
                onclick="cerrarResumenOrden()"
                style="
                    border:0;
                    background:#f3f4f6;
                    width:32px;
                    height:32px;
                    border-radius:6px;
                    font-size:18px;
                    cursor:pointer;
                ">
                ×
            </button>

        </div>


        {{-- TABLA --}}
        <div style="
            overflow:auto;
            padding:15px;
        ">

            <table style="
                width:100%;
                border-collapse:collapse;
                font-size:12px;
            ">

                <thead>

                    <tr style="
                        background:#f3f4f6;
                        color:#374151;
                    ">

                        <th style="padding:9px;text-align:left;">
                            Código
                        </th>

                        <th style="padding:9px;text-align:left;">
                            Descripción
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Solicitado
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Despachado
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Estado
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($order->details as $detalle)

                        @php
                            $solicitado = (float) ($detalle->cantidad_solicitada ?? 0);
                            $despachado = (float) ($detalle->cantidad_despachada ?? 0);

                            if ($despachado >= $solicitado && $solicitado > 0) {
                                $estado = 'ARMADO';
                                $estadoColor = '#166534';
                                $estadoBg = '#dcfce7';
                            } elseif ($despachado > 0) {
                                $estado = 'PARCIAL';
                                $estadoColor = '#92400e';
                                $estadoBg = '#fef3c7';
                            } else {
                                $estado = 'NO ARMADO';
                                $estadoColor = '#991b1b';
                                $estadoBg = '#fee2e2';
                            }
                        @endphp

                        <tr style="border-bottom:1px solid #e5e7eb;">

                            {{-- CÓDIGO --}}
                            <td style="
                                padding:9px;
                                font-family:monospace;
                                font-weight:700;
                            ">
                                {{ $detalle->product->sku
                                    ?? $detalle->product->barcode
                                    ?? '—' }}
                            </td>

                            {{-- DESCRIPCIÓN --}}
                            <td style="
                                padding:9px;
                                font-weight:600;
                            ">
                                {{ $detalle->product->nombre ?? 'Producto' }}
                            </td>

                            {{-- SOLICITADO --}}
                            <td style="
                                padding:9px;
                                text-align:center;
                                font-family:monospace;
                            ">
                                {{ number_format($solicitado, 0) }}
                            </td>

                            {{-- DESPACHADO --}}
                            <td style="
                                padding:9px;
                                text-align:center;
                                font-family:monospace;
                                font-weight:700;
                            ">
                                {{ number_format($despachado, 0) }}
                            </td>

                            {{-- ESTADO --}}
                            <td style="
                                padding:9px;
                                text-align:center;
                            ">

                                <span style="
                                    display:inline-block;
                                    padding:4px 8px;
                                    border-radius:999px;
                                    background:{{ $estadoBg }};
                                    color:{{ $estadoColor }};
                                    font-size:10px;
                                    font-weight:800;
                                ">
                                    {{ $estado }}
                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- PIE --}}
        <div style="
            padding:10px 15px;
            border-top:1px solid #e5e7eb;
            text-align:right;
        ">

            <button
                type="button"
                onclick="cerrarResumenOrden()"
                style="
                    padding:7px 14px;
                    border:1px solid #d1d5db;
                    background:#fff;
                    border-radius:6px;
                    cursor:pointer;
                ">
                Cerrar
            </button>

        </div>

    </div>

</div>
<script>
function abrirResumenOrden() {
    const modal = document.getElementById('modalResumenOrden');

    modal.style.display = 'flex';

    document.body.style.overflow = 'hidden';
}

function cerrarResumenOrden() {
    const modal = document.getElementById('modalResumenOrden');

    modal.style.display = 'none';

    document.body.style.overflow = '';
}

// Cerrar haciendo clic fuera de la ventana
document.getElementById('modalResumenOrden')?.addEventListener('click', function(e) {

    if (e.target === this) {
        cerrarResumenOrden();
    }

});
</script>
@endsection
