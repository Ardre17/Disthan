@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.1rem;background:#f1f5f9;min-height:100vh;}
.erp-bar{background:#1e3a5f;padding:0 1.25rem;height:38px;display:flex;align-items:center;justify-content:space-between;margin:-20px -20px 1rem;}
.erp-bar-title{color:#7eb8f7;font-size:12px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}
.page-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:.85rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;}
.page-sub{font-size:11px;color:#94a3b8;margin-top:2px;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:.85rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:.75rem 1rem;border-left:4px solid;}
.kpi-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:700;color:#1e293b;line-height:1.1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:2px;}
.charts-row{display:grid;grid-template-columns:2fr 1fr;gap:10px;margin-bottom:.85rem;}
@media(max-width:800px){.charts-row{grid-template-columns:1fr;}}
.chart-card{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:.85rem 1rem;}
.chart-title{font-size:11px;font-weight:700;color:#1e293b;margin-bottom:.6rem;text-transform:uppercase;letter-spacing:.05em;}
.legend{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:6px;}
.leg-item{display:flex;align-items:center;gap:4px;font-size:11px;color:#64748b;}
.leg-dot{width:8px;height:8px;border-radius:2px;flex-shrink:0;}
.filter-card{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:.8rem 1rem;margin-bottom:.85rem;}
.filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:8px;align-items:end;}
@media(max-width:600px){.filter-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#16a34a;box-shadow:0 0 0 2px rgba(22,163,74,.1);}
.btn-search{padding:8px 16px;background:#15803d;color:#fff;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;}
.btn-search:hover{background:#166534;}
.cards-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:.65rem;}
.cards-title{font-size:13px;font-weight:600;color:#1e293b;}
.count-pill{font-size:11px;background:#dcfce7;color:#15803d;padding:2px 12px;border-radius:99px;font-weight:600;}
.cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:10px;}
.order-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:1rem;border-top:4px solid #22c55e;display:flex;flex-direction:column;gap:.6rem;transition:box-shadow .15s;}
.order-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.09);}
.card-top{display:flex;justify-content:space-between;align-items:flex-start;}
.order-num{font-size:13px;font-weight:700;color:#0f172a;}
.order-client{font-size:11px;color:#94a3b8;margin-top:1px;}
.badge-done{display:inline-flex;align-items:center;gap:3px;font-size:10px;padding:2px 9px;border-radius:99px;font-weight:700;background:#dcfce7;color:#15803d;white-space:nowrap;}
.meta-row{display:grid;grid-template-columns:1fr 1fr;gap:4px 8px;}
.meta-item{font-size:11px;color:#64748b;display:flex;align-items:center;gap:3px;}
.meta-val{font-weight:600;color:#374151;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}
.prog-bar{width:100%;height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.prog-done{height:100%;width:100%;background:#22c55e;border-radius:99px;}
.prog-sub{font-size:10px;color:#64748b;margin-top:2px;display:flex;justify-content:space-between;}
.btn-row{display:grid;grid-template-columns:1fr 1fr;gap:6px;}
.btn{display:flex;align-items:center;justify-content:center;gap:4px;padding:7px;border-radius:6px;font-size:11px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-blue{background:#eff6ff;color:#1d4ed8;}
.btn-green{background:#f0fdf4;color:#15803d;}
.btn-gray{background:#f8fafc;color:#475569;border:1px solid #e2e8f0;}
.empty-state{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:3rem;text-align:center;color:#94a3b8;}
</style>

<div class="erp-bar">
    <div class="erp-bar-title">JOYBER PERÚ · Sistema ERP</div>
    <span class="erp-breadcrumb">Ventas › Historial de órdenes completadas</span>
</div>

<div class="pg">

@php
    $allOrders  = $orders->getCollection();
    $totalCount = $orders->total();
    $facturado  = $allOrders->sum('total');
    $promedioT  = $totalCount > 0 ? $facturado / $totalCount : 0;
    $porTipo    = $allOrders->groupBy('tipo_orden')->map(fn($g) => $g->sum('total'));

    // Datos para gráficos — en producción pásalos desde el controlador
    $meses   = $meses   ?? ['Ene','Feb','Mar','Abr','May','Jun'];
    $montos  = $montos  ?? [12400, 8900, 15300, 11200, 9800, 14200];
    $cantOrd = $cantOrd ?? [5, 3, 7, 4, 4, 6];

    $tipoLabels = $porTipo->isNotEmpty() ? $porTipo->keys()   : collect(['EXPORTACION','LOCAL','ENCOMIENDA']);
    $tipoData   = $porTipo->isNotEmpty() ? $porTipo->values() : collect([42000, 28000, 14320]);
@endphp

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">✅ Historial de órdenes completadas</div>
        <div class="page-sub">Auditoría y consulta de pedidos cerrados · Solo estado COMPLETO</div>
    </div>
    <div style="font-size:11px;color:#94a3b8;background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:5px 12px;">
        📅 {{ now()->format('d M Y · H:i') }}
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#22c55e;background:#f0fdf4;">
        <div class="kpi-label">Órdenes completadas</div>
        <div class="kpi-val" style="color:#15803d;">{{ $totalCount }}</div>
        <div class="kpi-sub">en el período filtrado</div>
    </div>
    <div class="kpi" style="border-left-color:#2563eb;">
        <div class="kpi-label">Total facturado</div>
        <div class="kpi-val" style="font-size:15px;color:#2563eb;">S/ {{ number_format($facturado,2) }}</div>
        <div class="kpi-sub">suma de todas las órdenes</div>
    </div>
    <div class="kpi" style="border-left-color:#8b5cf6;">
        <div class="kpi-label">Ticket promedio</div>
        <div class="kpi-val" style="font-size:15px;color:#7c3aed;">S/ {{ number_format($promedioT,2) }}</div>
        <div class="kpi-sub">por orden cerrada</div>
    </div>
    <div class="kpi" style="border-left-color:#0ea5e9;">
        <div class="kpi-label">Tipos de orden</div>
        <div class="kpi-val" style="font-size:12px;color:#0284c7;line-height:1.6;">
            @foreach($porTipo as $tipo => $monto)
                <span style="display:block;">{{ $tipo }}: <strong>S/ {{ number_format($monto,0) }}</strong></span>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Gráficos ── --}}
<div class="charts-row">
    <div class="chart-card">
        <div class="chart-title">Facturación mensual (órdenes completas)</div>
        <div class="legend">
            <span class="leg-item"><span class="leg-dot" style="background:#22c55e;"></span>Monto S/</span>
            <span class="leg-item"><span class="leg-dot" style="background:#86efac;"></span>N° órdenes</span>
        </div>
        <div style="position:relative;height:160px;">
            <canvas id="chartMes" role="img" aria-label="Facturación mensual"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">Por tipo de orden</div>
        <div class="legend" id="legTipo"></div>
        <div style="position:relative;height:150px;">
            <canvas id="chartTipo" role="img" aria-label="Distribución por tipo de orden"></canvas>
        </div>
    </div>
</div>

{{-- ── Filtros ── --}}
<div class="filter-card">
    <form method="GET" id="filterForm">
        <div class="filter-grid">
            <div>
                <label class="flabel">Desde</label>
                <input type="date" name="fecha_inicio" class="finput"
                       value="{{ request('fecha_inicio') }}">
            </div>
            <div>
                <label class="flabel">Hasta</label>
                <input type="date" name="fecha_fin" class="finput"
                       value="{{ request('fecha_fin') }}">
            </div>
            <div>
                <label class="flabel">Cliente / N° Orden</label>
                <input type="text" name="cliente" class="finput"
                       placeholder="Buscar cliente u orden..."
                       value="{{ request('cliente') }}">
            </div>
            <button type="submit" class="btn-search">🔍 Buscar</button>
        </div>

        {{-- Filtro por tipo --}}
        <div style="display:flex;gap:8px;margin-top:8px;flex-wrap:wrap;align-items:center;">
            <span style="font-size:11px;color:#64748b;font-weight:600;">Tipo:</span>
            @foreach([''=>'Todos','EXPORTACION'=>'Exportación','LOCAL'=>'Local','ENCOMIENDA'=>'Encomienda'] as $val => $label)
            <button type="submit" name="tipo_orden" value="{{ $val }}"
                style="
                    padding:3px 12px;border-radius:99px;font-size:11px;font-weight:600;
                    cursor:pointer;border:1px solid {{ request('tipo_orden')===$val ? '#15803d' : '#e2e8f0' }};
                    background:{{ request('tipo_orden')===$val ? '#dcfce7' : '#f8fafc' }};
                    color:{{ request('tipo_orden')===$val ? '#15803d' : '#64748b' }};
                ">
                {{ $label }}
            </button>
            @endforeach

            <div style="margin-left:auto;display:flex;align-items:center;gap:6px;font-size:11px;color:#64748b;">
                Ordenar por:
                <select name="orden" class="finput"
                        style="width:auto;padding:3px 8px;font-size:11px;"
                        onchange="document.getElementById('filterForm').submit()">
                    <option value="fecha_desc" {{ request('orden','fecha_desc')==='fecha_desc' ? 'selected' : '' }}>Fecha ↓</option>
                    <option value="fecha_asc"  {{ request('orden')==='fecha_asc'  ? 'selected' : '' }}>Fecha ↑</option>
                    <option value="total_desc" {{ request('orden')==='total_desc' ? 'selected' : '' }}>Total ↓</option>
                    <option value="total_asc"  {{ request('orden')==='total_asc'  ? 'selected' : '' }}>Total ↑</option>
                </select>
            </div>
        </div>
    </form>
</div>

{{-- ── Cards ── --}}
<div class="cards-hdr">
    <div class="cards-title">Órdenes cerradas</div>
    <span class="count-pill">✅ {{ $totalCount }} registros</span>
</div>

@if($orders->isEmpty())
<div class="empty-state">
    <div style="font-size:36px;margin-bottom:8px;">📭</div>
    <div style="font-size:14px;font-weight:600;color:#64748b;">No se encontraron órdenes completadas</div>
    <div style="font-size:12px;margin-top:4px;">Ajusta los filtros de fecha o búsqueda</div>
</div>
@else
<div class="cards-grid">

@foreach($orders as $order)
@php
    $totalItems  = $order->details->count();
    $completados = $order->details->where('estado_item','COMPLETO')->count();
    $tipoColor   = match($order->tipo_orden) {
        'EXPORTACION' => '#2563eb',
        'LOCAL'       => '#8b5cf6',
        'ENCOMIENDA'  => '#0ea5e9',
        default       => '#64748b',
    };
@endphp

<div class="order-card">
    <div class="card-top">
        <div>
            <div class="order-num">{{ $order->numero_orden }}</div>
            <div class="order-client">{{ $order->client->razon_social ?? 'Sin cliente' }}</div>
        </div>
        <span class="badge-done">✅ COMPLETO</span>
    </div>

    <hr class="dv">

    <div class="meta-row">
        <div class="meta-item">
            <span style="width:6px;height:6px;border-radius:50%;background:{{ $tipoColor }};display:inline-block;flex-shrink:0;"></span>
            <span class="meta-val" style="color:{{ $tipoColor }};">{{ $order->tipo_orden }}</span>
        </div>
        <div class="meta-item">📅 <span class="meta-val">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}</span></div>
        <div class="meta-item">💰 <span class="meta-val" style="color:#15803d;">S/ {{ number_format($order->total,2) }}</span></div>
        <div class="meta-item">🗂 Items: <span class="meta-val">{{ $totalItems }}</span></div>
    </div>

    <hr class="dv">

    <div>
        <div class="prog-bar"><div class="prog-done"></div></div>
        <div class="prog-sub">
            <span>{{ $completados }} / {{ $totalItems }} productos</span>
            <span style="color:#15803d;font-weight:700;">100% ✓</span>
        </div>
    </div>

    <div class="btn-row">
        <a href="{{ route('orders.edit',$order) }}" class="btn btn-blue">✏️ Editar</a>
        <a href="{{ route('orders.operario',$order) }}" class="btn btn-green">🚀 Operario</a>
    </div>
    <a href="{{ route('orders.pdf',$order) }}" class="btn btn-gray" style="width:100%;">
        📄 Ver / Descargar PDF
    </a>
</div>

@endforeach

</div>
@endif

<div style="margin-top:1rem;">
    {{ $orders->links() }}
</div>

</div>
@php
    $chartMeses      = json_encode($meses);
    $chartMontos     = json_encode($montos);
    $chartCantOrd    = json_encode($cantOrd);
    $chartTipoLabels = json_encode($tipoLabels->values()->toArray());
    $chartTipoData   = json_encode($tipoData->values()->toArray());
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
var meses      = {!! $chartMeses !!};
var montos     = {!! $chartMontos !!};
var cantOrd    = {!! $chartCantOrd !!};
var tipoLabels = {!! $chartTipoLabels !!};
var tipoData   = {!! $chartTipoData !!};
var tipoColors = ['#2563eb','#8b5cf6','#0ea5e9','#f59e0b','#22c55e'];

new Chart(document.getElementById('chartMes'), {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [
            {
                label: 'Facturado S/',
                data: montos,
                backgroundColor: '#22c55e',
                borderRadius: 5,
                borderSkipped: false,
                yAxisID: 'y'
            },
            {
                label: 'N Ordenes',
                data: cantOrd,
                type: 'line',
                borderColor: '#86efac',
                backgroundColor: 'rgba(134,239,172,.15)',
                borderWidth: 2,
                pointBackgroundColor: '#86efac',
                pointRadius: 4,
                tension: .4,
                yAxisID: 'y2'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x:  { grid: { display: false }, ticks: { font: { size: 10 } } },
            y:  { position: 'left',  grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 }, callback: function(v){ return 'S/'+v.toLocaleString(); } } },
            y2: { position: 'right', grid: { display: false },   ticks: { font: { size: 10 } } }
        }
    }
});

new Chart(document.getElementById('chartTipo'), {
    type: 'doughnut',
    data: {
        labels: tipoLabels,
        datasets: [{
            data: tipoData,
            backgroundColor: tipoColors,
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '62%'
    }
});

var legTipo = document.getElementById('legTipo');
tipoLabels.forEach(function(l, i) {
    var span = document.createElement('span');
    span.style.cssText = 'display:flex;align-items:center;gap:4px;font-size:11px;color:#64748b;';
    span.innerHTML = '<span style="width:8px;height:8px;border-radius:2px;background:'+tipoColors[i]+';display:inline-block;"></span>'+l;
    legTipo.appendChild(span);
});
</script>

@endsection