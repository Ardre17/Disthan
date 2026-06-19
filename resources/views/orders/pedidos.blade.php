@extends('layouts.app')
@section('content')

{{-- ============================================================
     CONFIGURACIÓN DE ESTADOS (ajusta colores/labels aquí si tus
     valores de $order->estado son distintos)
============================================================ --}}
@php
    $estadoConfig = [
        'PENDIENTE'  => ['color' => '#2563eb', 'bg' => '#dbeafe', 'icono' => '📋', 'label' => 'Pendiente'],
        'PARCIAL'    => ['color' => '#f59e0b', 'bg' => '#fef3c7', 'icono' => '🔄', 'label' => 'Parcial'],
        'INCOMPLETO' => ['color' => '#dc2626', 'bg' => '#fee2e2', 'icono' => '⚠️', 'label' => 'Incompleto'],
    ];
    $configDefault = ['color' => '#64748b', 'bg' => '#f1f5f9', 'icono' => '📦', 'label' => 'Otro'];

    // 👉 AJUSTA: si "En proceso" en tu negocio es otro valor de estado, cámbialo aquí
    $totalPendientes = $orders->count();
    $enProceso       = $orders->where('estado', 'PARCIAL')->count();
    $conFaltantes    = $orders->where('estado', 'INCOMPLETO')->count();

    // 👉 AJUSTA: reemplaza 'monto_total' por el campo real de tu modelo Order
    $montoTotal = $orders->sum(function ($order) {
        return $order->monto_total ?? 0;
    });

    // Progreso de despacho por orden (para el gráfico de barras)
    $calcularProgreso = function ($order) {
        if (isset($order->porcentaje_despachado)) {
            return (int) $order->porcentaje_despachado;
        }
        if (!empty($order->items_totales) && isset($order->items_despachados)) {
            return (int) round(($order->items_despachados / $order->items_totales) * 100);
        }
        // 👉 AJUSTA: valor de ejemplo mientras no tengas el campo real de progreso
        return (crc32($order->numero_orden) % 70) + 15;
    };

    $progresoChart = $orders->map(function ($order) use ($calcularProgreso) {
        return [
            'numero'   => $order->numero_orden,
            'progreso' => $calcularProgreso($order),
        ];
    })->values();

    // Distribución de estados (para la dona)
    $estadosCount = $orders->groupBy('estado')->map(fn($g) => $g->count());

    // Lista de estados únicos (para el dropdown de filtro)
    $estadosUnicos = $orders->pluck('estado')->unique()->values();
@endphp

<style>
    .pd-page { background:#f8fafc; padding:4px; }
    .pd-card { background:white; border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.06); }
    .kpi-card { transition: transform .15s ease; }
    .kpi-card:hover { transform: translateY(-3px); }
    .pedido-card { transition: transform .18s ease, box-shadow .18s ease; }
    .pedido-card:hover { transform: translateY(-4px); box-shadow:0 8px 20px rgba(0,0,0,.12) !important; }
    #estadoFilter { appearance:none; -webkit-appearance:none; }
    @media (max-width: 900px) {
        .kpi-grid { grid-template-columns: repeat(2,1fr) !important; }
        .charts-grid { grid-template-columns: 1fr !important; }
    }
</style>

<div class="pd-page">

{{-- ============================================================
     HEADER
============================================================ --}}
<div class="pd-card" style="display:flex;align-items:center;justify-content:space-between;padding:18px 22px;margin-bottom:18px;">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="
            width:44px;height:44px;border-radius:12px;
            background:#dbeafe;display:flex;align-items:center;justify-content:center;
            font-size:20px;flex-shrink:0;
        ">🚚</div>
        <div>
            <h1 style="font-size:20px;font-weight:bold;margin:0;">Pedidos — Despacho</h1>
            <p style="color:#64748b;margin:2px 0 0;font-size:13px;">Solo órdenes pendientes o en proceso</p>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <span style="
            background:#f1f5f9;color:#64748b;font-size:12px;
            padding:8px 14px;border-radius:20px;white-space:nowrap;
        ">🕒 Actualizado: hoy {{ now()->format('h:i a') }}</span>
        <span style="color:#94a3b8;cursor:pointer;font-size:18px;padding:0 4px;">⋮</span>
    </div>
</div>

{{-- ============================================================
     KPIs
============================================================ --}}
<div class="kpi-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:18px;">

    <div class="kpi-card pd-card" style="padding:16px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">📋</div>
        <div>
            <p style="color:#64748b;font-size:11px;font-weight:600;letter-spacing:.04em;margin:0;text-transform:uppercase;">Pendientes</p>
            <p style="font-size:24px;font-weight:bold;margin:2px 0 0;color:#1e293b;">{{ $totalPendientes }}</p>
        </div>
    </div>

    <div class="kpi-card pd-card" style="padding:16px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">⏳</div>
        <div>
            <p style="color:#64748b;font-size:11px;font-weight:600;letter-spacing:.04em;margin:0;text-transform:uppercase;">En Proceso</p>
            <p style="font-size:24px;font-weight:bold;margin:2px 0 0;color:#f59e0b;">{{ $enProceso }}</p>
        </div>
    </div>

    <div class="kpi-card pd-card" style="padding:16px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">⚠️</div>
        <div>
            <p style="color:#64748b;font-size:11px;font-weight:600;letter-spacing:.04em;margin:0;text-transform:uppercase;">Con Faltantes</p>
            <p style="font-size:24px;font-weight:bold;margin:2px 0 0;color:#dc2626;">{{ $conFaltantes }}</p>
        </div>
    </div>

    <div class="kpi-card pd-card" style="padding:16px;display:flex;align-items:center;gap:14px;">
        <div style="width:42px;height:42px;border-radius:10px;background:#d1fae5;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">💰</div>
        <div>
            <p style="color:#64748b;font-size:11px;font-weight:600;letter-spacing:.04em;margin:0;text-transform:uppercase;">Monto Total</p>
            <p style="font-size:24px;font-weight:bold;margin:2px 0 0;color:#059669;">S/ {{ number_format($montoTotal, 0) }}</p>
        </div>
    </div>

</div>

{{-- ============================================================
     GRÁFICOS: Progreso por orden + Estado del lote
============================================================ --}}
<div class="charts-grid" style="display:grid;grid-template-columns:1.4fr 1fr;gap:18px;margin-bottom:18px;">

    <div class="pd-card" style="padding:18px;">
        <p style="font-weight:bold;font-size:14px;margin:0 0 4px;color:#1e293b;">Progreso por orden</p>
        <div style="display:flex;gap:14px;margin-bottom:10px;">
            <span style="font-size:12px;color:#64748b;"><span style="display:inline-block;width:9px;height:9px;background:#16a34a;border-radius:2px;margin-right:5px;"></span>Despachado</span>
            <span style="font-size:12px;color:#64748b;"><span style="display:inline-block;width:9px;height:9px;background:#e2e8f0;border-radius:2px;margin-right:5px;"></span>Pendiente</span>
        </div>
        <div style="height:240px;">
            <canvas id="progresoChart"></canvas>
        </div>
    </div>

    <div class="pd-card" style="padding:18px;display:flex;flex-direction:column;">
        <p style="font-weight:bold;font-size:14px;margin:0 0 4px;color:#1e293b;">Estado del lote</p>
        <div id="donutLegend" style="display:flex;gap:14px;flex-wrap:wrap;margin-bottom:10px;font-size:12px;color:#64748b;"></div>
        <div style="flex:1;display:flex;align-items:center;justify-content:center;min-height:200px;">
            <canvas id="estadoLoteChart" width="200" height="200"></canvas>
        </div>
    </div>

</div>

{{-- ============================================================
     BUSCADOR + FILTRO POR ESTADO
============================================================ --}}
<div class="pd-card" style="padding:16px;margin-bottom:18px;display:flex;flex-direction:column;gap:12px;">
    <div style="display:flex;align-items:center;gap:10px;border:1px solid #e2e8f0;border-radius:8px;padding:10px 14px;">
        <span style="color:#94a3b8;">🔻</span>
        <input
            id="searchInput"
            type="text"
            placeholder="Buscar orden o cliente"
            style="border:none;outline:none;flex:1;font-size:14px;background:transparent;"
        >
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;border:1px solid #e2e8f0;border-radius:8px;padding:10px 14px;">
        <select id="estadoFilter" style="border:none;outline:none;flex:1;font-size:14px;background:transparent;color:#1e293b;">
            <option value="ALL">Todos los estados</option>
            @foreach($estadosUnicos as $est)
                <option value="{{ $est }}">{{ $estadoConfig[$est]['label'] ?? ucfirst(strtolower($est)) }}</option>
            @endforeach
        </select>
        <span style="color:#94a3b8;">⌄</span>
    </div>
    <p id="resultCount" style="color:#94a3b8;font-size:12px;margin:0;">Mostrando {{ $totalPendientes }} de {{ $totalPendientes }} pedidos</p>
</div>

{{-- ============================================================
     GRID DE PEDIDOS (tu lógica original conservada)
============================================================ --}}
<div id="ordersGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;">
@forelse($orders as $order)
    @php
        $cfg = $estadoConfig[$order->estado] ?? $configDefault;
        $nombreCliente = $order->client->razon_social ?? 'Sin cliente';
    @endphp
    <div
        class="pedido-card pd-card"
        data-estado="{{ $order->estado }}"
        data-search="{{ \Illuminate\Support\Str::lower($order->numero_orden.' '.$nombreCliente) }}"
        style="padding:20px;"
    >
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <h3 style="margin:0;font-size:16px;">📋 {{ $order->numero_orden }}</h3>
            <span style="
                background:{{ $cfg['bg'] }};
                color:{{ $cfg['color'] }};
                font-size:12px;
                font-weight:bold;
                padding:4px 10px;
                border-radius:20px;
                white-space:nowrap;
            ">
                {{ $cfg['icono'] }} {{ $cfg['label'] ?? $order->estado }}
            </span>
        </div>
        <p style="margin:10px 0 0;color:#475569;">👤 {{ $nombreCliente }}</p>

        <a href="{{ route('orders.operario', $order) }}"
           style="
            display:block;margin-top:14px;background:#16a34a;color:white;
            padding:10px;text-align:center;border-radius:8px;text-decoration:none;
           ">
            🚀 Iniciar Despacho
        </a>
    </div>
@empty
    <div class="pd-card" style="grid-column:1/-1;text-align:center;padding:60px 20px;color:#94a3b8;">
        <p style="font-size:40px;margin:0;">✅</p>
        <p style="font-size:16px;margin-top:10px;">No hay pedidos pendientes o en proceso</p>
    </div>
@endforelse
</div>

<p id="emptyFilterMsg" style="display:none;text-align:center;color:#94a3b8;margin-top:20px;">
    No se encontraron pedidos con esos filtros 🔍
</p>

</div> {{-- /.pd-page --}}

{{-- ============================================================
     SCRIPTS
============================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---------- GRÁFICO DE BARRAS: Progreso por orden ----------
    const progresoData = @json($progresoChart);

    if (progresoData.length > 0) {
        const ctxBar = document.getElementById('progresoChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: progresoData.map(o => o.numero),
                datasets: [
                    {
                        label: 'Despachado',
                        data: progresoData.map(o => o.progreso),
                        backgroundColor: '#16a34a',
                        borderRadius: 4,
                        stack: 'stack1'
                    },
                    {
                        label: 'Pendiente',
                        data: progresoData.map(o => 100 - o.progreso),
                        backgroundColor: '#e2e8f0',
                        borderRadius: 4,
                        stack: 'stack1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        stacked: true,
                        min: 0,
                        max: 100,
                        ticks: { callback: v => v + '%' },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        stacked: true,
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // ---------- DONA: Estado del lote ----------
    const estadosData = @json($estadosCount);
    const estadoConfig = @json($estadoConfig);
    const defaultCfg = @json($configDefault);

    const labels = Object.keys(estadosData);
    const values = Object.values(estadosData);
    const colors = labels.map(l => (estadoConfig[l] && estadoConfig[l].color) || defaultCfg.color);
    const labelTexts = labels.map(l => (estadoConfig[l] && estadoConfig[l].label) || l);

    const legendEl = document.getElementById('donutLegend');
    labels.forEach((l, i) => {
        const span = document.createElement('span');
        span.innerHTML = `<span style="display:inline-block;width:9px;height:9px;background:${colors[i]};border-radius:50%;margin-right:5px;"></span>${labelTexts[i]} — ${values[i]}`;
        legendEl.appendChild(span);
    });

    if (labels.length > 0) {
        const ctxDonut = document.getElementById('estadoLoteChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: labelTexts,
                datasets: [{ data: values, backgroundColor: colors, borderWidth: 0 }]
            },
            options: {
                responsive: false,
                plugins: { legend: { display: false } },
                cutout: '60%'
            }
        });
    }

    // ---------- BUSCADOR + FILTRO ----------
    const searchInput  = document.getElementById('searchInput');
    const estadoFilter = document.getElementById('estadoFilter');
    const cards         = document.querySelectorAll('.pedido-card');
    const resultCount  = document.getElementById('resultCount');
    const emptyMsg      = document.getElementById('emptyFilterMsg');

    function applyFilters() {
        const term   = searchInput.value.trim().toLowerCase();
        const estado = estadoFilter.value;
        let visibleCount = 0;

        cards.forEach(card => {
            const matchesEstado = estado === 'ALL' || card.dataset.estado === estado;
            const matchesSearch = card.dataset.search.includes(term);
            const visible = matchesEstado && matchesSearch;
            card.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });

        resultCount.textContent = `Mostrando ${visibleCount} de ${cards.length} pedidos`;
        emptyMsg.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
    }

    searchInput?.addEventListener('input', applyFilters);
    estadoFilter?.addEventListener('change', applyFilters);
});
</script>

@endsection