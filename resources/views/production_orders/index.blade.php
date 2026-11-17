@extends('layouts.app')

@section('content')


<style>
/* Compatibilidad visual de los modales existentes */
.finput{
    width:100%;padding:8px 10px;border:1px solid #d5deeb;border-radius:6px;
    font-size:12px;color:#26364d;background:#fff;outline:none;font-family:inherit;
}
.finput:focus{border-color:#7eabf5;box-shadow:0 0 0 3px rgba(7,94,232,.08);}
.flabel{display:block;font-size:11px;font-weight:700;color:#475569;margin-bottom:5px;}
.calendario-modal{
    display:none;position:fixed;inset:0;background:rgba(15,23,42,.60);
    z-index:11000;align-items:center;justify-content:center;padding:20px;
}
.calendario-box{
    background:#fff;width:min(950px,96vw);max-height:92vh;border-radius:8px;
    box-shadow:0 20px 50px rgba(0,0,0,.25);overflow:hidden;display:flex;flex-direction:column;
}
.calendario-header{
    padding:15px 18px;border-bottom:1px solid #e2e8f0;display:flex;
    justify-content:space-between;align-items:center;gap:10px;
}
.calendario-titulo{font-size:16px;font-weight:800;color:#0f172a;}
.calendario-subtitulo{font-size:11px;color:#94a3b8;margin-top:2px;}
.calendario-close{
    border:0;background:#f1f5f9;width:32px;height:32px;border-radius:5px;
    font-size:18px;cursor:pointer;
}
.calendario-body{padding:18px;overflow:auto;}
.calendario-navegacion{display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;}
.calendario-mes{font-size:17px;font-weight:800;color:#0f172a;text-transform:capitalize;}
.calendario-nav-btn{
    border:1px solid #cbd5e1;background:#fff;color:#334155;width:36px;height:34px;
    border-radius:5px;cursor:pointer;font-size:16px;
}
.calendario-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:5px;}
.calendario-dia-semana{text-align:center;font-size:10px;font-weight:800;color:#64748b;padding:6px 2px;text-transform:uppercase;}
.calendario-dia{
    min-height:65px;border:1px solid #e2e8f0;background:#fff;border-radius:5px;
    padding:7px;cursor:pointer;position:relative;
}
.calendario-dia.vacio{background:#f8fafc;cursor:default;}
.calendario-dia-numero{font-size:12px;font-weight:800;color:#334155;}
.calendario-dia.hoy{border-color:#0b5ed7;box-shadow:inset 0 0 0 1px #0b5ed7;}
.calendario-dia.hoy .calendario-dia-numero{color:#0b5ed7;}
.calendario-producciones{margin-top:7px;display:flex;flex-direction:column;gap:3px;}
.calendario-produccion-indicador{
    display:flex;align-items:center;gap:4px;background:#e8f5ee;color:#166534;
    border-radius:3px;padding:3px 5px;font-size:9px;font-weight:700;overflow:hidden;white-space:nowrap;
}
.calendario-produccion-indicador .punto{width:5px;height:5px;border-radius:50%;background:#1c7c4d;flex-shrink:0;}
.calendario-mas{font-size:9px;color:#64748b;font-weight:700;margin-top:2px;}
.producciones-dia{margin-top:18px;border-top:1px solid #e2e8f0;padding-top:15px;}
.producciones-dia-header{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:10px;}
.producciones-dia-titulo{font-size:14px;font-weight:800;color:#0f172a;}
.producciones-dia-resumen{display:flex;gap:6px;flex-wrap:wrap;}
.resumen-chip{background:#f1f5f9;border:1px solid #e2e8f0;border-radius:4px;padding:5px 8px;font-size:10px;color:#475569;font-weight:700;}
.produccion-dia-card{border:1px solid #e2e8f0;border-radius:5px;padding:10px;margin-bottom:7px;background:#fff;}
.produccion-dia-top{display:flex;justify-content:space-between;align-items:center;gap:8px;}
.produccion-dia-op{font-family:monospace;font-size:12px;font-weight:800;color:#0f172a;}
.produccion-dia-hora{font-size:10px;color:#64748b;}
.produccion-dia-producto{font-size:12px;font-weight:700;color:#334155;margin-top:6px;}
.produccion-dia-detalles{display:grid;grid-template-columns:repeat(3,1fr);gap:7px;margin-top:8px;}
.produccion-dia-detalle{background:#f8fafc;border:1px solid #eef2f7;border-radius:4px;padding:6px;}
.produccion-dia-detalle-label{font-size:9px;color:#94a3b8;text-transform:uppercase;font-weight:700;}
.produccion-dia-detalle-value{font-size:11px;color:#334155;font-weight:700;margin-top:2px;}
.btn-ver-produccion{margin-top:8px;border:1px solid #cbd5e1;background:#fff;color:#475569;border-radius:4px;padding:5px 9px;font-size:10px;font-weight:700;cursor:pointer;}
.calendario-sin-producciones{padding:25px 10px;text-align:center;color:#94a3b8;font-size:12px;border:1px dashed #dbe2ea;border-radius:5px;}
@media(max-width:700px){
    .calendario-modal{padding:8px;}
    .calendario-box{width:100%;max-height:96vh;}
    .calendario-body{padding:10px;}
    .calendario-dia{min-height:55px;padding:5px;}
    .produccion-dia-detalles{grid-template-columns:1fr;}
}
</style>

<style>
/* =========================================================
   DISTAN ERP · CONTROL DE PRODUCCIÓN
   Vista de tabla + calendario lateral
========================================================= */
.prod-dashboard{
    --pd-blue:#075ee8;
    --pd-blue-dark:#064fc4;
    --pd-ink:#172338;
    --pd-muted:#64748b;
    --pd-line:#dce4ef;
    --pd-bg:#f3f6fb;
    color:var(--pd-ink);
    font-family:var(--font-ui, "Segoe UI", Arial, sans-serif);
    padding:12px;
    background:var(--pd-bg);
    min-height:calc(100vh - 80px);
}
.prod-dashboard *{box-sizing:border-box;}
.pd-actions{
    display:flex;justify-content:flex-end;align-items:center;
    gap:9px;margin-bottom:13px;flex-wrap:wrap;
}
.pd-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:7px;
    min-height:37px;padding:8px 14px;border-radius:7px;
    border:1px solid #cbd7e7;background:#fff;color:#24334a;
    font-size:12px;font-weight:700;text-decoration:none;cursor:pointer;
    transition:.15s ease;
}
.pd-btn:hover{background:#f8fbff;border-color:#9eb5d5;color:#172338;}
.pd-btn-primary{background:var(--pd-blue);border-color:var(--pd-blue);color:#fff;}
.pd-btn-primary:hover{background:var(--pd-blue-dark);border-color:var(--pd-blue-dark);color:#fff;}
.pd-kpis{
    display:grid;grid-template-columns:repeat(4,minmax(0,1fr));
    gap:10px;margin-bottom:14px;
}
.pd-kpi{
    min-height:83px;background:#fff;border:1px solid var(--pd-line);
    border-left:4px solid var(--pd-blue);border-radius:9px;
    padding:13px 15px;display:flex;align-items:center;gap:12px;
    box-shadow:0 2px 7px rgba(15,35,65,.045);position:relative;overflow:hidden;
}
.pd-kpi:nth-child(2){border-left-color:#f59e0b;}
.pd-kpi:nth-child(3){border-left-color:#7955e8;}
.pd-kpi:nth-child(4){border-left-color:#16a765;}
.pd-kpi-icon{
    width:43px;height:43px;flex:0 0 43px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    background:#edf4ff;color:#1261df;font-size:21px;
}
.pd-kpi:nth-child(2) .pd-kpi-icon{background:#fff5e8;color:#e99013;}
.pd-kpi:nth-child(3) .pd-kpi-icon{background:#f2efff;color:#7955e8;}
.pd-kpi:nth-child(4) .pd-kpi-icon{background:#eaf9f1;color:#16a765;}
.pd-kpi-label{font-size:11px;color:#52627a;font-weight:600;margin-bottom:3px;}
.pd-kpi-value{font-size:23px;line-height:1.1;font-weight:800;letter-spacing:-.5px;color:#142238;}
.pd-kpi-sub{font-size:10px;color:#94a3b8;margin-top:3px;}
.pd-workspace{
    display:grid;grid-template-columns:minmax(0,1fr) 330px;
    gap:13px;align-items:start;
}
.pd-main{min-width:0;}
.pd-panel{
    background:#fff;border:1px solid var(--pd-line);border-radius:10px;
    box-shadow:0 2px 8px rgba(15,35,65,.045);overflow:hidden;
}
.pd-filter-panel{padding:10px;margin-bottom:12px;}
.pd-tabs{display:flex;gap:0;overflow-x:auto;margin-bottom:10px;}
.pd-tab{
    white-space:nowrap;border:1px solid #d5deeb;background:#fff;color:#26364d;
    padding:9px 14px;font-size:11px;font-weight:700;cursor:pointer;
    display:inline-flex;align-items:center;gap:7px;
}
.pd-tab:first-child{border-radius:7px 0 0 7px;}
.pd-tab:last-child{border-radius:0 7px 7px 0;}
.pd-tab+.pd-tab{border-left:0;}
.pd-tab.active{background:var(--pd-blue);border-color:var(--pd-blue);color:#fff;}
.pd-filter-row{display:flex;gap:10px;align-items:center;}
.pd-search-wrap{position:relative;flex:1;min-width:150px;}
.pd-search-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#718198;}
.pd-search{
    width:100%;height:39px;border:1px solid #d4deeb;border-radius:7px;
    padding:8px 12px 8px 35px;font-size:12px;color:#26364d;background:#fbfcfe;outline:none;
}
.pd-search:focus,.pd-select:focus{border-color:#7eabf5;box-shadow:0 0 0 3px rgba(7,94,232,.08);}
.pd-period{display:flex;align-items:center;gap:8px;white-space:nowrap;font-size:11px;color:#52627a;font-weight:600;}
.pd-select{
    height:39px;min-width:145px;border:1px solid #d4deeb;border-radius:7px;
    padding:7px 10px;background:#fbfcfe;color:#26364d;font-size:11px;outline:none;
}
.pd-table-head{
    padding:12px 14px;border-bottom:1px solid #e5ebf3;
    display:flex;align-items:center;justify-content:space-between;gap:10px;
}
.pd-table-title{font-size:15px;font-weight:800;display:flex;align-items:center;gap:9px;}
.pd-table-title-icon{color:var(--pd-blue);font-size:19px;}
.pd-table-meta{font-size:11px;color:#64748b;display:flex;align-items:center;gap:9px;}
.pd-sort-btn{
    width:31px;height:31px;border:1px solid #d5deeb;border-radius:7px;
    background:#fff;color:#475569;cursor:pointer;font-size:15px;
}
.pd-table-scroll{overflow-x:auto;}
.pd-table{width:100%;border-collapse:collapse;min-width:790px;font-size:11px;}
.pd-table thead th{
    background:#f5f7fb;color:#35445a;text-align:left;padding:11px 10px;
    font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.02em;
    border-bottom:1px solid #e1e7f0;white-space:nowrap;
}
.pd-table tbody tr{border-bottom:1px solid #e8edf4;transition:background .12s;}
.pd-table tbody tr:hover{background:#f8fbff;}
.pd-table tbody tr:last-child{border-bottom:0;}
.pd-table td{padding:10px 9px;vertical-align:middle;}
.pd-product{display:flex;align-items:center;gap:9px;min-width:190px;}
.pd-product-icon{
    width:34px;height:38px;border-radius:6px;background:#f3f6fa;
    display:flex;align-items:center;justify-content:center;font-size:19px;flex:0 0 34px;
}
.pd-product-name{font-size:11px;font-weight:800;color:#18263b;line-height:1.35;}
.pd-product-sku{font-size:10px;color:#77869a;margin-top:3px;}
.pd-quantity{font-size:12px;font-weight:800;color:#18263b;white-space:nowrap;}
.pd-progress-row{display:flex;align-items:center;gap:7px;margin-top:5px;}
.pd-progress{height:7px;width:88px;background:#e1e7f0;border-radius:99px;overflow:hidden;}
.pd-progress span{height:100%;display:block;background:var(--pd-blue);border-radius:99px;}
.pd-progress-pct{font-size:9px;color:#64748b;min-width:24px;}
.pd-center{text-align:center;white-space:nowrap;font-weight:700;color:#34445b;}
.pd-date{white-space:nowrap;color:#475569;font-size:10px;}
.pd-status{
    display:inline-flex;align-items:center;gap:5px;padding:6px 9px;
    border-radius:99px;font-size:10px;font-weight:700;white-space:nowrap;
}
.pd-status-progress{background:#e7f1ff;color:#0758cf;}
.pd-status-active{background:#e3f8ed;color:#13834b;}
.pd-status-pending{background:#fff4df;color:#a76505;}
.pd-status-idle{background:#eef2f7;color:#526174;}
.pd-row-actions{display:flex;align-items:center;gap:5px;white-space:nowrap;}
.pd-history{
    border:1px solid #cbd7e7;background:#fff;border-radius:6px;
    padding:6px 8px;font-size:10px;font-weight:700;color:#27374e;cursor:pointer;
}
.pd-history:hover{background:#f2f7ff;border-color:#9cb9e8;}
.pd-more{
    width:27px;height:27px;border:1px solid #cbd7e7;background:#fff;
    border-radius:6px;color:#475569;cursor:pointer;
}
.pd-empty{padding:35px 15px;text-align:center;color:#748399;font-size:12px;}
.pd-calendar{padding:13px;}
.pd-calendar-title{
    display:flex;align-items:center;gap:8px;font-size:14px;font-weight:800;
    padding-bottom:11px;border-bottom:1px solid #e4eaf2;
}
.pd-calendar-title span{color:var(--pd-blue);font-size:17px;}
.pd-cal-nav{display:flex;align-items:center;justify-content:space-between;margin:10px 2px;}
.pd-cal-nav button{
    width:27px;height:27px;border:0;background:transparent;color:#334155;
    font-size:20px;cursor:pointer;border-radius:5px;
}
.pd-cal-nav button:hover{background:#f1f5f9;}
.pd-cal-month{text-transform:capitalize;font-size:12px;font-weight:800;}
.pd-cal-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:2px;}
.pd-cal-weekday{text-align:center;padding:6px 0;font-size:9px;font-weight:800;color:#64748b;background:#f5f7fb;}
.pd-cal-day{
    min-height:36px;border:0;border-radius:5px;background:#fff;position:relative;
    font-size:10px;font-weight:700;color:#29384d;cursor:pointer;
}
.pd-cal-day:hover{background:#edf4ff;}
.pd-cal-day.muted{color:#aab4c2;font-weight:500;}
.pd-cal-day.selected{background:var(--pd-blue);color:#fff;}
.pd-cal-dot{
    width:5px;height:5px;border-radius:50%;background:#16a34a;
    position:absolute;bottom:4px;left:50%;transform:translateX(-50%);
}
.pd-cal-dot.planned{background:#1670ee;}
.pd-cal-day.selected .pd-cal-dot{background:#fff;}
.pd-cal-legend{display:flex;gap:14px;align-items:center;margin:10px 2px 13px;font-size:9px;color:#526174;}
.pd-legend-item{display:flex;align-items:center;gap:5px;}
.pd-legend-dot{width:7px;height:7px;border-radius:50%;background:#16a34a;}
.pd-legend-dot.planned{background:#1670ee;}
.pd-day-detail{border:1px solid #dce6f4;border-radius:8px;overflow:hidden;}
.pd-day-detail-head{
    background:#eaf2ff;padding:9px 10px;display:flex;align-items:center;
    justify-content:space-between;gap:7px;
}
.pd-day-detail-date{font-size:13px;font-weight:900;color:#173b78;}
.pd-day-detail-count{font-size:10px;color:#52627a;}
.pd-day-order{padding:9px 10px;border-top:1px solid #e8edf4;display:flex;gap:8px;align-items:flex-start;}
.pd-day-check{
    width:17px;height:17px;flex:0 0 17px;border-radius:50%;
    background:#e0f6e9;color:#159451;display:flex;align-items:center;justify-content:center;
    font-size:10px;margin-top:1px;
}
.pd-day-op{font-size:11px;font-weight:800;color:#1c2b40;}
.pd-day-product{font-size:10px;color:#66758a;margin-top:2px;line-height:1.35;}
.pd-day-empty{padding:15px 10px;text-align:center;color:#8a97a9;font-size:10px;}
.pd-calendar-footer{
    display:flex;align-items:center;justify-content:space-between;
    width:100%;padding:12px 1px 0;border:0;background:transparent;
    color:var(--pd-blue);font-size:11px;font-weight:800;cursor:pointer;
}
.pd-calendar-footer:hover{color:var(--pd-blue-dark);}
.pd-hidden-data{display:none;}
@media(max-width:1100px){
    .pd-workspace{grid-template-columns:minmax(0,1fr) 300px;}
}
@media(max-width:900px){
    .pd-workspace{grid-template-columns:1fr;}
    .pd-calendar{max-width:none;}
}
@media(max-width:650px){
    .prod-dashboard{padding:8px;}
    .pd-kpis{grid-template-columns:repeat(2,minmax(0,1fr));gap:7px;}
    .pd-kpi{padding:10px;min-height:72px;gap:8px;}
    .pd-kpi-icon{width:34px;height:34px;flex-basis:34px;font-size:17px;}
    .pd-kpi-value{font-size:19px;}
    .pd-filter-row{align-items:stretch;flex-direction:column;}
    .pd-period{justify-content:space-between;}
    .pd-select{flex:1;}
    .pd-tabs{padding-bottom:2px;}
    .pd-tab{padding:8px 10px;font-size:10px;}
    .pd-actions{justify-content:stretch;}
    .pd-actions .pd-btn{flex:1;}
    .pd-table-title{font-size:13px;}
}
</style>

@php
    $totalOrdenes = $orders->count();

    $normalizarEstado = function ($estado) {
        return strtoupper(str_replace([' ', '-'], '_', trim((string) $estado)));
    };

    $pendientes = $orders->filter(fn($o) => $normalizarEstado($o->status) === 'PENDIENTE')->count();

    $enProceso = $orders->filter(function ($o) use ($normalizarEstado) {
        return in_array($normalizarEstado($o->status), ['EN_PROCESO', 'PROCESO']);
    })->count();

    $unidadesProducidas = $productosProduccion->sum('total_producido');
@endphp

<div class="prod-dashboard">

    {{-- Acciones superiores: sin menú ni encabezado duplicado --}}
    <div class="pd-actions">
        <button type="button" class="pd-btn" onclick="abrirCalendarioProduccion()">
            <span>▦</span> Calendario
        </button>
        <a href="{{ route('production-orders.create') }}" class="pd-btn pd-btn-primary">
            <span style="font-size:17px;line-height:12px;">＋</span> Nueva producción
        </a>
    </div>

    {{-- Indicadores --}}
    <div class="pd-kpis">
        <div class="pd-kpi">
            <div class="pd-kpi-icon">▤</div>
            <div>
                <div class="pd-kpi-label">Órdenes registradas</div>
                <div class="pd-kpi-value">{{ number_format($totalOrdenes) }}</div>
                <div class="pd-kpi-sub">En el sistema</div>
            </div>
        </div>
        <div class="pd-kpi">
            <div class="pd-kpi-icon">⌛</div>
            <div>
                <div class="pd-kpi-label">Pendientes</div>
                <div class="pd-kpi-value">{{ str_pad($pendientes, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="pd-kpi-sub">Por iniciar</div>
            </div>
        </div>
        <div class="pd-kpi">
            <div class="pd-kpi-icon">⚙</div>
            <div>
                <div class="pd-kpi-label">En proceso</div>
                <div class="pd-kpi-value">{{ str_pad($enProceso, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="pd-kpi-sub">En ejecución</div>
            </div>
        </div>
        <div class="pd-kpi">
            <div class="pd-kpi-icon">▣</div>
            <div>
                <div class="pd-kpi-label">Unidades producidas</div>
                <div class="pd-kpi-value">{{ number_format($unidadesProducidas, 0) }}</div>
                <div class="pd-kpi-sub">Acumulado histórico</div>
            </div>
        </div>
    </div>

    <div class="pd-workspace">
        <main class="pd-main">

            {{-- Filtros y ordenamiento --}}
            <section class="pd-panel pd-filter-panel">
                <div class="pd-tabs">
                    <button type="button" class="pd-tab active" data-filter="all" onclick="cambiarFiltroProduccion('all', this)">☷ Todos</button>
                    <button type="button" class="pd-tab" data-filter="most" onclick="cambiarFiltroProduccion('most', this)">↗ Más producidos</button>
                    <button type="button" class="pd-tab" data-filter="least" onclick="cambiarFiltroProduccion('least', this)">↘ Menos producidos</button>
                    <button type="button" class="pd-tab" data-filter="pending" onclick="cambiarFiltroProduccion('pending', this)">◷ Pendientes de producción</button>
                </div>

                <div class="pd-filter-row">
                    <div class="pd-search-wrap">
                        <span class="pd-search-icon">⌕</span>
                        <input
                            type="search"
                            id="filtroTexto"
                            class="pd-search"
                            placeholder="Buscar producto o SKU..."
                            oninput="filtrarOrdenes()"
                        >
                    </div>

                    <label class="pd-period">
                        Período:
                        <select id="filtroPeriodo" class="pd-select" onchange="filtrarOrdenes()">
                            <option value="30">▦ Últimos 30 días</option>
                            <option value="7">Últimos 7 días</option>
                            <option value="90">Últimos 3 meses</option>
                            <option value="365">Últimos 12 meses</option>
                            <option value="all">Todo el historial</option>
                        </select>
                    </label>
                </div>
            </section>

            {{-- Tabla principal --}}
            <section class="pd-panel">
                <div class="pd-table-head">
                    <div class="pd-table-title">
                        <span class="pd-table-title-icon">▥</span>
                        Rendimiento por producto
                    </div>
                    <div class="pd-table-meta">
                        <span><strong id="countVisible">{{ $productosProduccion->count() }}</strong> productos</span>
                        <button type="button" class="pd-sort-btn" title="Cambiar orden" onclick="alternarOrdenTabla()">↕</button>
                    </div>
                </div>

                <div class="pd-table-scroll">
                    <table class="pd-table">
                        <thead>
                            <tr>
                                <th>Producto / SKU</th>
                                <th>Producción acumulada</th>
                                <th style="text-align:center;">Órdenes</th>
                                <th>Última producción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="catalogGrid">
                        @forelse($productosProduccion as $grupo)
                            @php
                                $producto = $grupo->producto;
                                $ultima = $grupo->ultima;

                                $textoBusqueda = strtolower(
                                    ($producto->nombre ?? '') . ' ' .
                                    ($producto->sku ?? '') . ' ' .
                                    ($producto->barcode ?? '')
                                );

                                $tienePendiente = $grupo->ordenes->contains(function ($orden) {
                                    return strtoupper($orden->status) === 'PENDIENTE';
                                });

                                $tieneProceso = $grupo->en_produccion > 0;
                                $tieneCompletado = $grupo->finalizadas > 0;

                                if ($tieneProceso) {
                                    $statusKey = 'progress';
                                    $statusLabel = '⚙ En producción';
                                    $statusClass = 'pd-status-progress';
                                } elseif ($tienePendiente && !$tieneCompletado) {
                                    $statusKey = 'pending';
                                    $statusLabel = '◷ Pendiente';
                                    $statusClass = 'pd-status-pending';
                                } elseif ($tieneCompletado || $grupo->cantidad_ordenes > 0) {
                                    $statusKey = 'active';
                                    $statusLabel = '✓ Activa';
                                    $statusClass = 'pd-status-active';
                                } else {
                                    $statusKey = 'idle';
                                    $statusLabel = '◷ Sin producción reciente';
                                    $statusClass = 'pd-status-idle';
                                }

                                $totalProducto = (float) $grupo->total_producido;
                                $maxProduccion = max(1, (float) $productosProduccion->max('total_producido'));
                                $porcentaje = min(100, ($totalProducto / $maxProduccion) * 100);
                            @endphp

                            <tr
                                class="pd-product-row"
                                data-q="{{ $textoBusqueda }}"
                                data-status="{{ $statusKey }}"
                                data-total="{{ $totalProducto }}"
                                data-name="{{ $producto->nombre ?? 'Producto' }}"
                                data-product-id="{{ $grupo->product_id }}"
                            >
                                <td>
                                    <div class="pd-product">
                                        <div class="pd-product-icon">📦</div>
                                        <div>
                                            <div class="pd-product-name">{{ $producto->nombre ?? 'Producto' }}</div>
                                            <div class="pd-product-sku">SKU: {{ $producto->sku ?? '—' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pd-quantity" data-alltime="{{ $totalProducto }}">
                                        {{ number_format($totalProducto, 2) }} un.
                                    </div>
                                    <div class="pd-progress-row">
                                        <div class="pd-progress"><span style="width:{{ $porcentaje }}%;"></span></div>
                                        <span class="pd-progress-pct">{{ number_format($porcentaje, 0) }}%</span>
                                    </div>
                                </td>
                                <td class="pd-center">{{ $grupo->cantidad_ordenes }}</td>
                                <td class="pd-date">
                                    @if($ultima && $ultima->fecha_produccion)
                                        ▦ {{ $ultima->fecha_produccion->format('d/m/Y') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td><span class="pd-status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>
                                    <div class="pd-row-actions">
                                        <button type="button" class="pd-history" onclick="mostrarProducciones({{ $grupo->product_id }})">Ver historial</button>
                                        <button type="button" class="pd-more" title="Ver historial" onclick="mostrarProducciones({{ $grupo->product_id }})">⋮</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="pd-hidden-data">
                                <td colspan="6">
                                    <div id="producciones-{{ $grupo->product_id }}">
                                        @foreach($grupo->ordenes as $orden)
                                            <div
                                                class="produccion-data"
                                                data-id="{{ $orden->id }}"
                                                data-number="{{ $orden->number }}"
                                                data-quantity="{{ number_format($orden->produced_quantity, 2, '.', '') }}"
                                                data-status="{{ $orden->status }}"
                                                data-date="{{ $orden->fecha_produccion ? $orden->fecha_produccion->format('d/m/Y H:i') : '—' }}"
                                                data-date-iso="{{ $orden->fecha_produccion ? $orden->fecha_produccion->format('Y-m-d') : '' }}"
                                                data-material="{{ $orden->rawMaterial->name ?? '—' }}"
                                            ></div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="pd-empty">
                                    <div style="font-size:28px;margin-bottom:7px;">🏭</div>
                                    No existen órdenes de producción.
                                    <div style="margin-top:10px;">
                                        <a href="{{ route('production-orders.create') }}" class="pd-btn pd-btn-primary">＋ Nueva producción</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="pdNoResults" class="pd-empty" style="display:none;">No se encontraron productos con los filtros seleccionados.</div>
            </section>
        </main>

        {{-- Calendario compacto siempre visible --}}
        <aside class="pd-panel pd-calendar">
            <div class="pd-calendar-title"><span>▦</span> Calendario de producción</div>

            <div class="pd-cal-nav">
                <button type="button" onclick="cambiarMesPanel(-1)" aria-label="Mes anterior">‹</button>
                <div id="pdCalMonth" class="pd-cal-month"></div>
                <button type="button" onclick="cambiarMesPanel(1)" aria-label="Mes siguiente">›</button>
            </div>

            <div id="pdCalGrid" class="pd-cal-grid"></div>

            <div class="pd-cal-legend">
                <span class="pd-legend-item"><i class="pd-legend-dot"></i> Realizada</span>
                
            </div>

            <div class="pd-day-detail">
                <div class="pd-day-detail-head">
                    <div class="pd-day-detail-date" id="pdDayTitle">HOY</div>
                    <div class="pd-day-detail-count" id="pdDayCount">0 órdenes</div>
                </div>
                <div id="pdDayOrders">
                    <div class="pd-day-empty">Selecciona un día para consultar la producción.</div>
                </div>
            </div>

            <button type="button" class="pd-calendar-footer" onclick="abrirCalendarioProduccion()">
                <span>▦ Ver calendario completo</span><span>›</span>
            </button>
        </aside>
    </div>
</div>

<script>
/* =========================================================
   FILTROS Y ORDENAMIENTO DE PRODUCTOS
========================================================= */
let filtroProduccionActual = 'all';
let ordenTablaDescendente = true;

function cambiarFiltroProduccion(tipo, boton) {
    filtroProduccionActual = tipo;
    document.querySelectorAll('.pd-tab').forEach(el => el.classList.remove('active'));
    if (boton) boton.classList.add('active');
    filtrarOrdenes();
}

function alternarOrdenTabla() {
    ordenTablaDescendente = !ordenTablaDescendente;
    const tbody = document.getElementById('catalogGrid');
    const filas = Array.from(tbody.querySelectorAll('tr.pd-product-row'));
    filas.sort((a, b) => {
        const diferencia = Number(a.dataset.total || 0) - Number(b.dataset.total || 0);
        return ordenTablaDescendente ? -diferencia : diferencia;
    });
    filas.forEach(fila => {
        const datos = tbody.querySelector('#producciones-' + fila.dataset.productId)?.closest('tr');
        tbody.appendChild(fila);
        if (datos) tbody.appendChild(datos);
    });
    filtrarOrdenes();
}

function fechaLimitePeriodo(dias) {
    const fecha = new Date();
    fecha.setHours(0, 0, 0, 0);
    fecha.setDate(fecha.getDate() - dias);
    return fecha;
}

function filtrarOrdenes() {
    const texto = (document.getElementById('filtroTexto')?.value || '').toLowerCase().trim();
    const periodo = document.getElementById('filtroPeriodo')?.value || '30';
    const limite = periodo === 'all' ? null : fechaLimitePeriodo(Number(periodo));
    const filas = Array.from(document.querySelectorAll('#catalogGrid tr.pd-product-row'));
    let visibles = 0;

    filas.forEach(fila => {
        const textoCoincide = !texto || (fila.dataset.q || '').includes(texto);
        const estado = fila.dataset.status || '';
        let estadoCoincide = true;

        if (filtroProduccionActual === 'pending') {
            estadoCoincide = estado === 'pending' || estado === 'idle';
        }

        const datos = document.getElementById('producciones-' + fila.dataset.productId);
        let cantidadPeriodo = 0;
        if (datos) {
            datos.querySelectorAll('.produccion-data').forEach(item => {
                if ((item.dataset.status || '').toUpperCase() !== 'FINALIZADA') return;
                const fecha = item.dataset.dateIso ? new Date(item.dataset.dateIso + 'T00:00:00') : null;
                if (!fecha || (limite && fecha < limite)) return;
                cantidadPeriodo += Number(item.dataset.quantity || 0);
            });
        }

        const cantidadMostrar = periodo === 'all'
            ? Number(fila.dataset.total || 0)
            : cantidadPeriodo;

        const cantidadCoincide = filtroProduccionActual !== 'pending' ||
            estadoCoincide;

        const mostrar = textoCoincide && estadoCoincide && cantidadCoincide;
        fila.style.display = mostrar ? '' : 'none';

        const datosFila = datos?.closest('tr');
        if (datosFila) datosFila.style.display = mostrar ? 'none' : 'none';

        const celdaCantidad = fila.querySelector('.pd-quantity');
        if (celdaCantidad) {
            celdaCantidad.textContent = Number(cantidadMostrar).toLocaleString('es-PE', {
                minimumFractionDigits: 0, maximumFractionDigits: 2
            }) + ' un.';
            celdaCantidad.dataset.periodTotal = cantidadMostrar;
        }

        if (mostrar) visibles++;
    });

    if (filtroProduccionActual === 'most' || filtroProduccionActual === 'least') {
        filas.sort((a, b) => {
            const av = Number(a.querySelector('.pd-quantity')?.dataset.periodTotal || 0);
            const bv = Number(b.querySelector('.pd-quantity')?.dataset.periodTotal || 0);
            return filtroProduccionActual === 'most' ? bv - av : av - bv;
        });
        const tbody = document.getElementById('catalogGrid');
        filas.forEach(fila => {
            const datosFila = document.getElementById('producciones-' + fila.dataset.productId)?.closest('tr');
            tbody.appendChild(fila);
            if (datosFila) tbody.appendChild(datosFila);
        });
    }

    const contador = document.getElementById('countVisible');
    if (contador) contador.textContent = visibles;
    const sinResultados = document.getElementById('pdNoResults');
    if (sinResultados) sinResultados.style.display = visibles ? 'none' : 'block';
}

/* =========================================================
   HISTORIAL DE PRODUCCIÓN
========================================================= */
function mostrarProducciones(productId) {
    const contenedor = document.getElementById('producciones-' + productId);
    if (!contenedor) return;

    const datos = contenedor.querySelectorAll('.produccion-data');
    const tabla = document.getElementById('tablaProducciones');
    const filaProducto = document.querySelector('.pd-product-row[data-product-id="' + productId + '"]');
    const nombreProducto = filaProducto?.dataset.name || 'Producto';

    document.getElementById('modalProductoNombre').textContent = nombreProducto;
    tabla.innerHTML = '';

    datos.forEach(dato => {
        const estado = (dato.dataset.status || '').toUpperCase();
        let color = '#64748b', fondo = '#f1f5f9', texto = estado || '—';

        if (estado === 'FINALIZADA') {
            color = '#166534'; fondo = '#dcfce7'; texto = '✓ Finalizada';
        } else if (estado === 'EN_PRODUCCION' || estado === 'EN PROCESO' || estado === 'PROCESO') {
            color = '#1d4ed8'; fondo = '#dbeafe'; texto = '⚙ En producción';
        } else if (estado === 'PENDIENTE') {
            color = '#a16207'; fondo = '#fef3c7'; texto = '◷ Pendiente';
        }

        const fila = document.createElement('tr');
        fila.style.borderBottom = '1px solid #f1f5f9';
        fila.innerHTML = `
            <td style="padding:9px;font-family:monospace;font-weight:700;">${dato.dataset.number || '—'}</td>
            <td style="padding:9px;text-align:center;font-family:monospace;font-weight:700;">${dato.dataset.quantity || '0'}</td>
            <td style="padding:9px;">${dato.dataset.material || '—'}</td>
            <td style="padding:9px;text-align:center;color:#64748b;">${dato.dataset.date || '—'}</td>
            <td style="padding:9px;text-align:center;">
                <span style="display:inline-block;padding:4px 8px;border-radius:4px;background:${fondo};color:${color};font-size:10px;font-weight:700;">${texto}</span>
            </td>
            <td style="padding:9px;text-align:center;white-space:nowrap;">
                <button type="button" onclick="verProduccion(${Number(dato.dataset.id)})" style="border:1px solid #cbd5e1;background:#fff;color:#475569;border-radius:5px;padding:5px 8px;cursor:pointer;font-size:11px;">Ver</button>
                <button type="button" onclick="editarProduccion(${Number(dato.dataset.id)})" style="border:1px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;border-radius:5px;padding:5px 8px;cursor:pointer;font-size:11px;">Editar</button>
            </td>`;
        tabla.appendChild(fila);
    });

    document.getElementById('modalProducciones').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
</script>

@php
    $produccionesCalendario = $orders
        ->filter(function ($orden) {
            return strtoupper($orden->status) === 'FINALIZADA'
                && $orden->fecha_produccion !== null;
        })
        ->map(function ($orden) {
            return [
                'id' => $orden->id,
                'number' => $orden->number,
                'product' => $orden->product?->nombre ?? '—',
                'quantity' => (float) $orden->produced_quantity,
                'material' => $orden->rawMaterial?->name ?? '—',
                'user' => $orden->user?->name ?? '—',
                'fecha' => $orden->fecha_produccion->format('Y-m-d'),
                'hora' => $orden->fecha_produccion->format('H:i'),
            ];
        })
        ->values();
@endphp

<script>
    const produccionesCalendario = @json($produccionesCalendario);
</script>
<script>

function filtrarOrdenes() {
    var texto  = document.getElementById('filtroTexto').value.toLowerCase();
    var estado = document.getElementById('filtroEstado').value.toLowerCase();
    var cards  = document.querySelectorAll('#catalogGrid .prod-card');
    var visible = 0;

    cards.forEach(function(card) {
        var mTexto  = !texto  || (card.dataset.q && card.dataset.q.includes(texto));
        var mEstado = !estado || (card.dataset.status && card.dataset.status.includes(estado));
        var show = mTexto && mEstado;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    var cnt = document.getElementById('countVisible');
    if (cnt) cnt.textContent = visible;
}
function mostrarProducciones(productId)
{
    const contenedor = document.getElementById(
        'producciones-' + productId
    );

    if (!contenedor) {
        return;
    }

    const datos = contenedor.querySelectorAll(
        '.produccion-data'
    );

    const tabla = document.getElementById(
        'tablaProducciones'
    );

    const nombreProducto = contenedor
        .closest('.prod-card')
        ?.querySelector('.prod-card-hdr div div')
        ?.textContent
        ?.trim() ?? 'Producto';

    document.getElementById(
        'modalProductoNombre'
    ).textContent = nombreProducto;


    tabla.innerHTML = '';


    datos.forEach(function (dato) {

        const estado = dato.dataset.status.toUpperCase();

        let color = '#64748b';
        let fondo = '#f1f5f9';
        let texto = estado;

        if (estado === 'FINALIZADA') {

            color = '#166534';
            fondo = '#dcfce7';
            texto = '✅ Finalizada';

        } else if (estado === 'EN_PRODUCCION') {

            color = '#1d4ed8';
            fondo = '#dbeafe';
            texto = '⚙️ En producción';

        }


        const fila = document.createElement('tr');

        fila.style.borderBottom =
            '1px solid #f1f5f9';


        fila.innerHTML = `

            <td style="
                padding:9px;
                font-family:monospace;
                font-weight:700;
            ">
                ${dato.dataset.number}
            </td>

            <td style="
                padding:9px;
                text-align:center;
                font-family:monospace;
                font-weight:700;
            ">
                ${dato.dataset.quantity}
            </td>

            <td style="
                padding:9px;
            ">
                ${dato.dataset.material}
            </td>

            <td style="
                padding:9px;
                text-align:center;
                color:#64748b;
            ">
                ${dato.dataset.date}
            </td>

            <td style="
                padding:9px;
                text-align:center;
            ">

                <span style="
                    display:inline-block;
                    padding:4px 8px;
                    border-radius:4px;
                    background:${fondo};
                    color:${color};
                    font-size:10px;
                    font-weight:700;
                ">
                    ${texto}
                </span>
            <td style="
    padding:9px;
    text-align:center;
    white-space:nowrap;
">

    <button
        type="button"
        onclick="verProduccion(${dato.dataset.id})"
        style="
            border:1px solid #cbd5e1;
            background:#fff;
            color:#475569;
            border-radius:5px;
            padding:5px 8px;
            cursor:pointer;
            font-size:11px;
        "
    >
        👁️ Ver
    </button>

    <button
        type="button"
        onclick="editarProduccion(${dato.dataset.id})"
        style="
            border:1px solid #bfdbfe;
            background:#eff6ff;
            color:#1d4ed8;
            border-radius:5px;
            padding:5px 8px;
            cursor:pointer;
            font-size:11px;
        "
    >
        ✏️ Editar
    </button>

            </td>

        `;

        tabla.appendChild(fila);

    });


    document.getElementById(
        'modalProducciones'
    ).style.display = 'flex';

    document.body.style.overflow = 'hidden';
}


function cerrarProducciones()
{
    document.getElementById(
        'modalProducciones'
    ).style.display = 'none';

    document.body.style.overflow = '';
}


document.getElementById('modalProducciones')
    ?.addEventListener('click', function(event) {

        if (event.target === this) {
            cerrarProducciones();
        }

    });
    function verProduccion(id)
{
    window.location.href =
        `/production-orders/${id}`;
}


async function editarProduccion(id)
{
    try {

        const response = await fetch(
            `/production-orders/${id}/edit`
        );

        if (!response.ok) {
            throw new Error('No se pudo obtener la producción.');
        }

        const data = await response.json();

        document.getElementById('editarNumeroOP').textContent =
            data.number;

        document.getElementById('editarCantidadProducida').value =
            data.produced_quantity;

        document.getElementById('editarCantidadConsumida').value =
            data.consumed_quantity;

        document.getElementById('editarObservacion').value =
            data.observation === '—'
                ? ''
                : data.observation;

        const form = document.getElementById(
            'formEditarProduccion'
        );

        form.action =
            `/production-orders/${id}`;


        const advertencia = document.getElementById(
            'advertenciaEditarProduccion'
        );

        if (data.status === 'FINALIZADA') {

            advertencia.style.display = 'block';

            advertencia.innerHTML =
                '⚠️ Esta producción ya está finalizada. ' +
                'Al guardar, Disthan ajustará automáticamente ' +
                'el inventario de materia prima y producto terminado.';

        } else {

            advertencia.style.display = 'none';

            advertencia.innerHTML = '';

        }


        document.getElementById(
            'modalEditarProduccion'
        ).style.display = 'flex';

        document.body.style.overflow = 'hidden';

    } catch (error) {

        console.error(error);

        alert(
            'No se pudo cargar la producción para editar.'
        );
    }
}

function cerrarEditarProduccion()
{
    document.getElementById(
        'modalEditarProduccion'
    ).style.display = 'none';

    document.body.style.overflow = '';
}


document.getElementById('modalEditarProduccion')
    ?.addEventListener('click', function(event) {

        if (event.target === this) {
            cerrarEditarProduccion();
        }

    });
</script>
{{-- =========================================================
     MODAL HISTORIAL DE PRODUCCIÓN
========================================================= --}}

<div
    id="modalProducciones"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.60);
        z-index:9999;
        align-items:center;
        justify-content:center;
        padding:20px;
    "
>

    <div style="
        background:#fff;
        width:min(850px,95vw);
        max-height:90vh;
        border-radius:8px;
        box-shadow:0 20px 50px rgba(0,0,0,.25);
        display:flex;
        flex-direction:column;
        overflow:hidden;
    ">


        {{-- CABECERA --}}

        <div style="
            padding:15px 18px;
            border-bottom:1px solid #e2e8f0;
            display:flex;
            justify-content:space-between;
            align-items:center;
        ">

            <div>

                <div
                    id="modalProductoNombre"
                    style="
                        font-size:16px;
                        font-weight:800;
                    "
                >
                    Producciones
                </div>

                <div style="
                    font-size:11px;
                    color:#94a3b8;
                    margin-top:2px;
                ">
                    Historial de producción del producto
                </div>

            </div>

            <button
                type="button"
                onclick="cerrarProducciones()"
                style="
                    border:0;
                    background:#f1f5f9;
                    width:32px;
                    height:32px;
                    border-radius:5px;
                    font-size:18px;
                    cursor:pointer;
                "
            >
                ×
            </button>

        </div>


        {{-- TABLA --}}

        <div style="
            padding:15px;
            overflow:auto;
        ">

            <table style="
                width:100%;
                border-collapse:collapse;
                font-size:12px;
            ">

                <thead>

                    <tr style="
                        background:#f8fafc;
                        border-bottom:1px solid #dbe2ea;
                    ">

                        <th style="padding:9px;text-align:left;">
                            Orden
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Cantidad producida
                        </th>

                        <th style="padding:9px;text-align:left;">
                            Materia prima
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Fecha
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Estado
                        </th>
                        <th style="padding:9px;text-align:center;">
                            Acciones
                        </th>
                    </tr>

                </thead>

                <tbody id="tablaProducciones">

                </tbody>

            </table>

        </div>


        {{-- PIE --}}

        <div style="
            padding:10px 15px;
            border-top:1px solid #e2e8f0;
            text-align:right;
        ">

            <button
                type="button"
                onclick="cerrarProducciones()"
                style="
                    padding:7px 14px;
                    border:1px solid #cbd5e1;
                    background:#fff;
                    border-radius:5px;
                    cursor:pointer;
                "
            >
                Cerrar
            </button>

        </div>

    </div>

</div>
<div
    id="modalEditarProduccion"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.60);
        z-index:10000;
        align-items:center;
        justify-content:center;
        padding:20px;
    "
>
    <div style="
        background:#fff;
        width:min(500px,95vw);
        border-radius:8px;
        box-shadow:0 20px 50px rgba(0,0,0,.25);
        overflow:hidden;
    ">

        <div style="
            padding:15px 18px;
            border-bottom:1px solid #e2e8f0;
            display:flex;
            justify-content:space-between;
            align-items:center;
        ">
            <div>
                <div style="font-size:16px;font-weight:800;">
                    ✏️ Editar producción
                </div>

                <div
                    id="editarNumeroOP"
                    style="
                        font-size:11px;
                        color:#94a3b8;
                        margin-top:2px;
                    "
                ></div>
            </div>

            <button
                type="button"
                onclick="cerrarEditarProduccion()"
                style="
                    border:0;
                    background:#f1f5f9;
                    width:32px;
                    height:32px;
                    border-radius:5px;
                    font-size:18px;
                    cursor:pointer;
                "
            >
                ×
            </button>
        </div>

        <form
            id="formEditarProduccion"
            method="POST"
            style="padding:18px;"
        >

            @csrf
            @method('PUT')

            <div style="margin-bottom:10px;">
                <label class="flabel">
                    Cantidad producida
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="produced_quantity"
                    id="editarCantidadProducida"
                    class="finput"
                    required
                >
            </div>

            <div style="margin-bottom:10px;">
                <label class="flabel">
                    Materia prima consumida
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="consumed_quantity"
                    id="editarCantidadConsumida"
                    class="finput"
                    required
                >
            </div>

            <div style="margin-bottom:10px;">
                <label class="flabel">
                    Observación
                </label>

                <textarea
                    name="observation"
                    id="editarObservacion"
                    class="finput"
                    rows="3"
                ></textarea>
            </div>

            <div
                id="advertenciaEditarProduccion"
                style="
                    display:none;
                    background:#fff7ed;
                    border:1px solid #fed7aa;
                    color:#9a3412;
                    padding:9px;
                    border-radius:5px;
                    font-size:11px;
                    margin-bottom:10px;
                "
            >
            </div>

            <div style="
                display:flex;
                justify-content:flex-end;
                gap:7px;
            ">

                <button
                    type="button"
                    onclick="cerrarEditarProduccion()"
                    style="
                        padding:8px 14px;
                        border:1px solid #cbd5e1;
                        background:#fff;
                        border-radius:5px;
                        cursor:pointer;
                    "
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="btn-new"
                >
                    💾 Guardar cambios
                </button>

            </div>

        </form>

    </div>
</div>
{{-- =========================================================
     MODAL CALENDARIO DE PRODUCCIÓN
========================================================= --}}

<div
    id="modalCalendarioProduccion"
    class="calendario-modal"
>

    <div class="calendario-box">

        {{-- CABECERA --}}
        <div class="calendario-header">

            <div>

                <div class="calendario-titulo">
                    📅 Calendario de producción
                </div>

                <div class="calendario-subtitulo">
                    Selecciona un día para consultar las producciones finalizadas
                </div>

            </div>

            <button
                type="button"
                class="calendario-close"
                onclick="cerrarCalendarioProduccion()"
            >
                ×
            </button>

        </div>


        {{-- CUERPO --}}
        <div class="calendario-body">

            {{-- NAVEGACIÓN DEL MES --}}
            <div class="calendario-navegacion">

                <button
                    type="button"
                    class="calendario-nav-btn"
                    onclick="cambiarMesCalendario(-1)"
                >
                    ‹
                </button>


                <div
                    id="calendarioMes"
                    class="calendario-mes"
                >
                    Septiembre 2026
                </div>


                <button
                    type="button"
                    class="calendario-nav-btn"
                    onclick="cambiarMesCalendario(1)"
                >
                    ›
                </button>

            </div>


            {{-- CALENDARIO --}}
            <div
                id="calendarioGrid"
                class="calendario-grid"
            ></div>


            {{-- PRODUCCIONES DEL DÍA --}}
            <div
                id="produccionesDia"
                class="producciones-dia"
                style="display:none;"
            >

                <div class="producciones-dia-header">

                    <div
                        id="produccionesDiaTitulo"
                        class="producciones-dia-titulo"
                    >
                    </div>


                    <div
                        id="produccionesDiaResumen"
                        class="producciones-dia-resumen"
                    >
                    </div>

                </div>


                <div
                    id="listaProduccionesDia"
                >
                </div>

            </div>

        </div>

    </div>

</div>
<script>
/* =========================================================
   CALENDARIO DE PRODUCCIÓN
========================================================= */

let fechaCalendario = new Date();

function abrirCalendarioProduccion()
{
    const modal = document.getElementById(
        'modalCalendarioProduccion'
    );

    if (!modal) {
        console.error('No se encontró el modal del calendario.');
        return;
    }

    modal.style.display = 'flex';

    document.body.style.overflow = 'hidden';

    fechaCalendario = new Date();

    renderizarCalendarioProduccion();
}


function cerrarCalendarioProduccion()
{
    const modal = document.getElementById(
        'modalCalendarioProduccion'
    );

    if (!modal) {
        return;
    }

    modal.style.display = 'none';

    document.body.style.overflow = '';
}


function cambiarMesCalendario(movimiento)
{
    fechaCalendario.setMonth(
        fechaCalendario.getMonth() + movimiento
    );

    renderizarCalendarioProduccion();
}


function formatearFechaCalendario(fecha)
{
    const anio = fecha.getFullYear();

    const mes = String(
        fecha.getMonth() + 1
    ).padStart(2, '0');

    const dia = String(
        fecha.getDate()
    ).padStart(2, '0');

    return `${anio}-${mes}-${dia}`;
}


function formatearFechaTexto(fecha)
{
    const partes = fecha.split('-');

    if (partes.length !== 3) {
        return fecha;
    }

    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}


function renderizarCalendarioProduccion()
{
    const grid = document.getElementById(
        'calendarioGrid'
    );

    const titulo = document.getElementById(
        'calendarioMes'
    );

    if (!grid || !titulo) {
        console.error(
            'No se encontraron los elementos del calendario.'
        );

        return;
    }

    const anio =
        fechaCalendario.getFullYear();

    const mes =
        fechaCalendario.getMonth();

    const nombresMeses = [
        'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre'
    ];

    titulo.textContent =
        nombresMeses[mes] + ' ' + anio;

    grid.innerHTML = '';

    const diasSemana = [
        'Lun',
        'Mar',
        'Mié',
        'Jue',
        'Vie',
        'Sáb',
        'Dom'
    ];

    diasSemana.forEach(function(dia) {

        const encabezado =
            document.createElement('div');

        encabezado.className =
            'calendario-dia-semana';

        encabezado.textContent =
            dia;

        grid.appendChild(encabezado);
    });


    const primerDia =
        new Date(
            anio,
            mes,
            1
        );

    let diaInicio =
        primerDia.getDay();

    /*
     * JavaScript:
     * Domingo = 0
     * Lunes = 1
     *
     * Convertimos para que lunes sea
     * el primer día del calendario.
     */
    diaInicio =
        diaInicio === 0
            ? 6
            : diaInicio - 1;


    const cantidadDias =
        new Date(
            anio,
            mes + 1,
            0
        ).getDate();


    /*
     * Espacios antes del primer día
     */
    for (
        let i = 0;
        i < diaInicio;
        i++
    ) {

        const vacio =
            document.createElement('div');

        vacio.className =
            'calendario-dia vacio';

        grid.appendChild(vacio);
    }


    /*
     * Días del mes
     */
    for (
        let dia = 1;
        dia <= cantidadDias;
        dia++
    ) {

        const fecha =
            new Date(
                anio,
                mes,
                dia
            );

        const fechaKey =
            formatearFechaCalendario(
                fecha
            );


        const producciones =
            Array.isArray(
                produccionesCalendario
            )
                ? produccionesCalendario.filter(
                    function(produccion) {

                        return produccion.fecha === fechaKey;

                    }
                )
                : [];


        const celda =
            document.createElement('div');

        celda.className =
            'calendario-dia';


        /*
         * Día actual
         */
        const hoy =
            new Date();

        if (
            dia === hoy.getDate() &&
            mes === hoy.getMonth() &&
            anio === hoy.getFullYear()
        ) {

            celda.classList.add('hoy');
        }


        let contenido = `
            <div class="calendario-dia-numero">
                ${dia}
            </div>
        `;


        /*
         * Mostrar producciones
         */
        if (producciones.length > 0) {

            contenido += `
                <div class="calendario-producciones">
            `;


            const limite =
                Math.min(
                    producciones.length,
                    2
                );


            for (
                let i = 0;
                i < limite;
                i++
            ) {

                const produccion =
                    producciones[i];

                contenido += `
                    <div class="calendario-produccion-indicador">
                        <span class="punto"></span>
                        ${produccion.number}
                    </div>
                `;
            }


            if (producciones.length > 2) {

                contenido += `
                    <div class="calendario-mas">
                        +${producciones.length - 2} más
                    </div>
                `;
            }


            contenido += `
                </div>
            `;
        }


        celda.innerHTML =
            contenido;


        celda.addEventListener(
            'click',
            function() {

                mostrarProduccionesDelDia(
                    fechaKey
                );

            }
        );


        grid.appendChild(celda);
    }
}


function mostrarProduccionesDelDia(fecha)
{
    const producciones =
        Array.isArray(
            produccionesCalendario
        )
            ? produccionesCalendario.filter(
                function(produccion) {

                    return produccion.fecha === fecha;

                }
            )
            : [];


    const contenedor =
        document.getElementById(
            'produccionesDia'
        );

    const titulo =
        document.getElementById(
            'produccionesDiaTitulo'
        );

    const resumen =
        document.getElementById(
            'produccionesDiaResumen'
        );

    const lista =
        document.getElementById(
            'listaProduccionesDia'
        );


    if (
        !contenedor ||
        !titulo ||
        !resumen ||
        !lista
    ) {

        return;
    }


    contenedor.style.display =
        'block';


    titulo.textContent =
        'Producciones del ' +
        formatearFechaTexto(fecha);


    /*
     * No hay producciones
     */
    if (producciones.length === 0) {

        resumen.innerHTML = '';

        lista.innerHTML = `
            <div class="calendario-sin-producciones">
                No hay producciones finalizadas en este día.
            </div>
        `;

        return;
    }


    /*
     * Total producido
     */
    const total =
        producciones.reduce(
            function(
                acumulado,
                produccion
            ) {

                return acumulado +
                    Number(
                        produccion.quantity || 0
                    );

            },
            0
        );


    resumen.innerHTML = `
        <span class="resumen-chip">
            🏭 ${producciones.length}
            producción${producciones.length !== 1 ? 'es' : ''}
        </span>

        <span class="resumen-chip">
            📦 ${total.toLocaleString(
                'es-PE',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            )} unidades
        </span>
    `;


    lista.innerHTML = '';


    /*
     * Ordenar por hora
     */
    producciones.sort(
        function(a, b) {

            return a.hora.localeCompare(
                b.hora
            );

        }
    );


    producciones.forEach(
        function(produccion) {

            const tarjeta =
                document.createElement('div');

            tarjeta.className =
                'produccion-dia-card';


            tarjeta.innerHTML = `
                <div class="produccion-dia-top">

                    <div class="produccion-dia-op">
                        ${produccion.number}
                    </div>

                    <div class="produccion-dia-hora">
                        🕐 ${produccion.hora}
                    </div>

                </div>

                <div class="produccion-dia-producto">
                    ${produccion.product}
                </div>

                <div class="produccion-dia-detalles">

                    <div class="produccion-dia-detalle">

                        <div class="produccion-dia-detalle-label">
                            Cantidad
                        </div>

                        <div class="produccion-dia-detalle-value">
                            ${Number(
                                produccion.quantity
                            ).toLocaleString(
                                'es-PE',
                                {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }
                            )}
                        </div>

                    </div>


                    <div class="produccion-dia-detalle">

                        <div class="produccion-dia-detalle-label">
                            Materia prima
                        </div>

                        <div class="produccion-dia-detalle-value">
                            ${produccion.material}
                        </div>

                    </div>


                    <div class="produccion-dia-detalle">

                        <div class="produccion-dia-detalle-label">
                            Responsable
                        </div>

                        <div class="produccion-dia-detalle-value">
                            ${produccion.user}
                        </div>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-ver-produccion"
                    onclick="verProduccion(${produccion.id})"
                >
                    👁️ Ver producción
                </button>
            `;


            lista.appendChild(
                tarjeta
            );

        }
    );
}


/*
 * Cerrar al hacer clic fuera
 */
document
    .getElementById(
        'modalCalendarioProduccion'
    )
    ?.addEventListener(
        'click',
        function(event) {

            if (
                event.target === this
            ) {

                cerrarCalendarioProduccion();

            }

        }
    );
</script>

<script>
/* =========================================================
   CALENDARIO LATERAL COMPACTO
========================================================= */
let pdPanelDate = new Date();
let pdPanelSelected = new Date();

function pdDateKey(date) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    return `${y}-${m}-${d}`;
}
function pdEscapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;'
    }[char]));
}
function renderPanelCalendario() {
    const grid = document.getElementById('pdCalGrid');
    const title = document.getElementById('pdCalMonth');
    if (!grid || !title) return;

    const year = pdPanelDate.getFullYear();
    const month = pdPanelDate.getMonth();
    title.textContent = new Intl.DateTimeFormat('es-PE', {month:'long', year:'numeric'}).format(pdPanelDate);

    const weekdays = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
    grid.innerHTML = weekdays.map(day => `<div class="pd-cal-weekday">${day}</div>`).join('');

    const firstDay = new Date(year, month, 1);
    const offset = (firstDay.getDay() + 6) % 7;
    const days = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < offset; i++) {
        const blank = document.createElement('div');
        grid.appendChild(blank);
    }

    for (let day = 1; day <= days; day++) {
        const date = new Date(year, month, day);
        const key = pdDateKey(date);
        const items = (produccionesCalendario || []).filter(item => item.fecha === key);
        const cell = document.createElement('button');
        cell.type = 'button';
        cell.className = 'pd-cal-day' + (pdDateKey(pdPanelSelected) === key ? ' selected' : '');
        cell.textContent = day;

        if (items.length) {
            const dot = document.createElement('i');
            dot.className = 'pd-cal-dot';
            cell.appendChild(dot);
        }

        cell.addEventListener('click', () => {
            pdPanelSelected = date;
            renderPanelCalendario();
            mostrarDiaPanel(key);
        });
        grid.appendChild(cell);
    }

    mostrarDiaPanel(pdDateKey(pdPanelSelected));
}
function cambiarMesPanel(delta) {
    pdPanelDate = new Date(pdPanelDate.getFullYear(), pdPanelDate.getMonth() + delta, 1);
    renderPanelCalendario();
}
function mostrarDiaPanel(key) {
    const items = (produccionesCalendario || []).filter(item => item.fecha === key)
        .sort((a,b) => (a.hora || '').localeCompare(b.hora || ''));

    const date = new Date(key + 'T00:00:00');
    const title = document.getElementById('pdDayTitle');
    const count = document.getElementById('pdDayCount');
    const list = document.getElementById('pdDayOrders');
    if (!title || !count || !list) return;

    title.textContent = new Intl.DateTimeFormat('es-PE', {day:'2-digit', month:'short'}).format(date).toUpperCase();
    count.textContent = `${items.length} ${items.length === 1 ? 'orden' : 'órdenes'}`;

    if (!items.length) {
        list.innerHTML = '<div class="pd-day-empty">No hay producciones finalizadas en este día.</div>';
        return;
    }

    list.innerHTML = items.slice(0, 4).map(item => `
        <div class="pd-day-order">
            <div class="pd-day-check">✓</div>
            <div>
                <div class="pd-day-op">${pdEscapeHtml(item.number)}</div>
                <div class="pd-day-product">${pdEscapeHtml(item.product)} · ${Number(item.quantity || 0).toLocaleString('es-PE')} un.</div>
            </div>
        </div>
    `).join('');
}
document.addEventListener('DOMContentLoaded', () => {
    pdPanelDate = new Date();
    pdPanelSelected = new Date();
    renderPanelCalendario();
    filtrarOrdenes();
});
</script>


<script>
/* Sobrescritura final para asegurar que la tabla moderna use los filtros nuevos. */
function filtrarOrdenes() {
    const texto = (document.getElementById('filtroTexto')?.value || '').toLowerCase().trim();
    const periodo = document.getElementById('filtroPeriodo')?.value || '30';
    const limite = periodo === 'all' ? null : fechaLimitePeriodo(Number(periodo));
    const filas = Array.from(document.querySelectorAll('#catalogGrid tr.pd-product-row'));
    let visibles = 0;

    filas.forEach(fila => {
        const textoCoincide = !texto || (fila.dataset.q || '').includes(texto);
        const estado = fila.dataset.status || '';
        let estadoCoincide = true;
        if (filtroProduccionActual === 'pending') {
            estadoCoincide = estado === 'pending' || estado === 'idle';
        }

        const datos = document.getElementById('producciones-' + fila.dataset.productId);
        let cantidadPeriodo = 0;
        if (datos) {
            datos.querySelectorAll('.produccion-data').forEach(item => {
                if ((item.dataset.status || '').toUpperCase() !== 'FINALIZADA') return;
                const fecha = item.dataset.dateIso ? new Date(item.dataset.dateIso + 'T00:00:00') : null;
                if (!fecha || (limite && fecha < limite)) return;
                cantidadPeriodo += Number(item.dataset.quantity || 0);
            });
        }

        const cantidadMostrar = periodo === 'all' ? Number(fila.dataset.total || 0) : cantidadPeriodo;
        const mostrar = textoCoincide && estadoCoincide;
        fila.style.display = mostrar ? '' : 'none';

        const celdaCantidad = fila.querySelector('.pd-quantity');
        if (celdaCantidad) {
            celdaCantidad.textContent = Number(cantidadMostrar).toLocaleString('es-PE', {
                minimumFractionDigits:0, maximumFractionDigits:2
            }) + ' un.';
            celdaCantidad.dataset.periodTotal = cantidadMostrar;
        }
        if (mostrar) visibles++;
    });

    if (filtroProduccionActual === 'most' || filtroProduccionActual === 'least') {
        filas.sort((a,b) => {
            const av = Number(a.querySelector('.pd-quantity')?.dataset.periodTotal || 0);
            const bv = Number(b.querySelector('.pd-quantity')?.dataset.periodTotal || 0);
            return filtroProduccionActual === 'most' ? bv-av : av-bv;
        });
        const tbody = document.getElementById('catalogGrid');
        filas.forEach(fila => {
            const hidden = document.getElementById('producciones-' + fila.dataset.productId)?.closest('tr');
            tbody.appendChild(fila);
            if (hidden) tbody.appendChild(hidden);
        });
    }

    const contador = document.getElementById('countVisible');
    if (contador) contador.textContent = visibles;
    const sinResultados = document.getElementById('pdNoResults');
    if (sinResultados) sinResultados.style.display = visibles ? 'none' : 'block';
}
</script>


<script>
function mostrarProducciones(productId) {
    const contenedor = document.getElementById('producciones-' + productId);
    if (!contenedor) return;

    const tabla = document.getElementById('tablaProducciones');
    const filaProducto = document.querySelector('.pd-product-row[data-product-id="' + productId + '"]');
    document.getElementById('modalProductoNombre').textContent = filaProducto?.dataset.name || 'Producto';
    tabla.innerHTML = '';

    contenedor.querySelectorAll('.produccion-data').forEach(dato => {
        const estado = (dato.dataset.status || '').toUpperCase();
        let color = '#64748b', fondo = '#f1f5f9', texto = estado || '—';

        if (estado === 'FINALIZADA') {
            color = '#166534'; fondo = '#dcfce7'; texto = '✓ Finalizada';
        } else if (['EN_PRODUCCION','EN PROCESO','PROCESO'].includes(estado)) {
            color = '#1d4ed8'; fondo = '#dbeafe'; texto = '⚙ En producción';
        } else if (estado === 'PENDIENTE') {
            color = '#a16207'; fondo = '#fef3c7'; texto = '◷ Pendiente';
        }

        const fila = document.createElement('tr');
        fila.style.borderBottom = '1px solid #f1f5f9';
        fila.innerHTML = `
            <td style="padding:9px;font-family:monospace;font-weight:700;">${dato.dataset.number || '—'}</td>
            <td style="padding:9px;text-align:center;font-family:monospace;font-weight:700;">${dato.dataset.quantity || '0'}</td>
            <td style="padding:9px;">${dato.dataset.material || '—'}</td>
            <td style="padding:9px;text-align:center;color:#64748b;">${dato.dataset.date || '—'}</td>
            <td style="padding:9px;text-align:center;">
                <span style="display:inline-block;padding:4px 8px;border-radius:4px;background:${fondo};color:${color};font-size:10px;font-weight:700;">${texto}</span>
            </td>
            <td style="padding:9px;text-align:center;white-space:nowrap;">
                <button type="button" onclick="verProduccion(${Number(dato.dataset.id)})" style="border:1px solid #cbd5e1;background:#fff;color:#475569;border-radius:5px;padding:5px 8px;cursor:pointer;font-size:11px;">Ver</button>
                <button type="button" onclick="editarProduccion(${Number(dato.dataset.id)})" style="border:1px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;border-radius:5px;padding:5px 8px;cursor:pointer;font-size:11px;">Editar</button>
            </td>`;
        tabla.appendChild(fila);
    });

    document.getElementById('modalProducciones').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
</script>

@endsection