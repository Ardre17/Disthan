@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#eef1f5;
    --erp-surface:#ffffff;
    --erp-border:#dde2ea;
    --erp-ink:#1c2733;
    --erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;}

/* Top bar */
.erp-bar{background:#1e3a5f;padding:0 1.5rem;height:44px;display:flex;align-items:center;justify-content:space-between;margin-bottom:0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{font-size:15px;font-weight:800;color:#fff;letter-spacing:.5px;}
.erp-sep{width:1px;height:20px;background:#334155;}
.erp-module{font-size:11px;color:#7eb8f7;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.erp-user{font-size:11px;color:#7eb8f7;background:#152d4d;padding:3px 10px;border-radius:4px;}

/* Body padding */
.dash-body{padding:1.25rem;}

/* KPI strip */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:6px;padding:.9rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:28px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:4px;}
.kpi-val{font-size:26px;font-weight:800;line-height:1;font-family:var(--font-mono);margin-bottom:3px;}
.kpi-sub{font-size:10px;color:#94a3b8;}

/* Section grids */
.section-row{display:grid;grid-template-columns:2fr 1fr;gap:12px;margin-bottom:1rem;}
@media(max-width:900px){.section-row{grid-template-columns:1fr;}}
.bottom-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:800px){.bottom-row{grid-template-columns:1fr;}}
.right-col{display:flex;flex-direction:column;gap:12px;}

/* Cards */
.chart-card,.stat-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:6px;padding:1rem 1.25rem;}
.chart-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.75rem;display:flex;align-items:center;gap:6px;}

/* Tabla recientes */
.recent-table{width:100%;border-collapse:collapse;font-size:12px;}
.recent-table th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.recent-table td{padding:7px 10px;border-bottom:1px solid #f8fafc;color:#374151;vertical-align:middle;}
.recent-table tbody tr:hover td{background:#f8fafc;}
.badge{display:inline-flex;align-items:center;font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}

/* Progreso tipos */
.prog-item{display:flex;flex-direction:column;gap:3px;padding:7px 0;border-bottom:1px solid #f1f5f9;}
.prog-item:last-child{border:none;padding-bottom:0;}
.prog-hdr{display:flex;justify-content:space-between;font-size:12px;color:#374151;}
.prog-bar{width:100%;height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}

/* Alertas */
.alert-strip{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:1rem;}
.alert-item{display:flex;align-items:center;gap:7px;padding:7px 12px;border-radius:6px;font-size:12px;font-weight:600;}
.alert-danger{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.alert-warn{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}

/* Legend */
.legend{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:8px;}
.leg-item{display:flex;align-items:center;gap:4px;font-size:11px;color:#64748b;}
.leg-dot{width:8px;height:8px;border-radius:2px;flex-shrink:0;}

#fano-container{

    position:fixed;

    right:20px;

    bottom:20px;

    z-index:9999;

}

#fano-img{
    width:200px;
    height:auto;
}

#fano-img:hover{

    transform:scale(1.05);

}

#fano-chat{

    position:absolute;

    bottom:260px;

    right:120px;

    width:250px;

    background:#fff;

    border-radius:18px;

    padding:18px;

    box-shadow:0 10px 30px rgba(0,0,0,.18);

    transition:.4s;

    z-index:10000;

}
#fano-chat::after{

    content:"";

    position:absolute;

    right:-14px;

    bottom:30px;

    border-top:12px solid transparent;

    border-bottom:12px solid transparent;

    border-left:16px solid white;

}

.fano-hidden{

    opacity:0;

    visibility:hidden;

}

.fano-show{

    opacity:1;

    visibility:visible;

}
#fano-btn{

    margin-top:15px;

    width:100%;

    border:none;

    background:#2563eb;

    color:white;

    padding:12px;

    border-radius:12px;

    cursor:pointer;

    font-weight:bold;

    transition:.3s;

}

#fano-btn:hover{

    background:#1d4ed8;

}
</style>

<div class="page">

{{-- ── ERP Top Bar ── --}}
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Dashboard principal</div>
    </div>
</div>

<div class="dash-body">

{{-- ── PHP vars ── --}}
@php
    $totalOrdenes   = \App\Models\Order::count();
    $incompletas    = \App\Models\Order::where('estado','INCOMPLETO')->count();
    $parciales      = \App\Models\Order::where('estado','PARCIAL')->count();
    $completas      = \App\Models\Order::where('estado','COMPLETO')->count();
    $pctCompletas   = $totalOrdenes > 0 ? number_format($completas / $totalOrdenes * 100, 1) : 0;

    $ordenesEsteMes = \App\Models\Order::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)->count();
    $facturadoMes   = \App\Models\Order::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)->sum('total');

    $clientesActivos = \App\Models\Order::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->distinct('client_id')->count('client_id');

    $sinStock = \App\Models\Product::whereColumn('stock','<=','stock_minimo')->count();

    $ordenesRecientes = \App\Models\Order::with('client')
                        ->orderByDesc('created_at')->take(6)->get();

    // Tipos de orden
    $tiposConteo = \App\Models\Order::selectRaw('tipo_orden, count(*) as total')
                    ->groupBy('tipo_orden')->pluck('total','tipo_orden');
    $maxTipo = $tiposConteo->max() ?: 1;

    // Datos gráfico clientes
    $topProductos = \App\Models\OrderDetail::selectRaw('product_id, SUM(cantidad_despachada) as total_vendido')
    ->with('product')
    ->groupBy('product_id')
    ->orderByDesc('total_vendido')
    ->take(10)
    ->get();

    // Facturación mensual últimos 6 meses
    $mesesLabels = [];
    $mesesData   = [];
    for($i = 5; $i >= 0; $i--){
        $m = now()->subMonths($i);
        $mesesLabels[] = $m->format('M');
        $mesesData[]   = \App\Models\Order::whereMonth('created_at',$m->month)
                            ->whereYear('created_at',$m->year)->sum('total');
    }
@endphp

{{-- ── Alertas dinámicas ── --}}
@if($incompletas > 0 || $sinStock > 0)
<div class="alert-strip">
    @if($incompletas > 0)
    <div class="alert-item alert-danger">
        ⚠️ {{ $incompletas }} orden(es) incompleta(s) requieren atención
    </div>
    @endif
    @if($sinStock > 0)
    <div class="alert-item alert-warn">
        📦 {{ $sinStock }} producto(s) con stock bajo o agotado
    </div>
    @endif
</div>
@endif

{{-- ── KPIs fila 1 ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#0b5ed7;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Total órdenes</div>
        <div class="kpi-val" style="color:#0b5ed7;">{{ $totalOrdenes }}</div>
        <div class="kpi-sub">acumulado histórico</div>
    </div>
    <div class="kpi" style="border-left-color:#b91c1c;">
        <div class="kpi-icon">⏳</div>
        <div class="kpi-label">Incompletas</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $incompletas }}</div>
        <div class="kpi-sub">requieren atención</div>
    </div>
    <div class="kpi" style="border-left-color:#b45309;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Parciales</div>
        <div class="kpi-val" style="color:#b45309;">{{ $parciales }}</div>
        <div class="kpi-sub">en progreso</div>
    </div>
    <div class="kpi" style="border-left-color:#15803d;background:#f0fdf4;">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Completadas</div>
        <div class="kpi-val" style="color:#15803d;">{{ $completas }}</div>
        <div class="kpi-sub">{{ $pctCompletas }}% del total</div>
    </div>
</div>

{{-- ── KPIs fila 2 ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">💰</div>
        <div class="kpi-label">Facturado este mes</div>
        <div class="kpi-val" style="font-size:18px;color:#7c3aed;">S/ {{ number_format($facturadoMes,0) }}</div>
        <div class="kpi-sub">{{ now()->format('F Y') }}</div>
    </div>
    <div class="kpi" style="border-left-color:#0ea5e9;">
        <div class="kpi-icon">📋</div>
        <div class="kpi-label">Órdenes este mes</div>
        <div class="kpi-val" style="color:#0284c7;">{{ $ordenesEsteMes }}</div>
        <div class="kpi-sub">mes en curso</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">👥</div>
        <div class="kpi-label">Clientes activos</div>
        <div class="kpi-val" style="color:#b45309;">{{ $clientesActivos }}</div>
        <div class="kpi-sub">con órdenes este mes</div>
    </div>
    <div class="kpi" style="border-left-color:#ef4444;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Productos s/ stock</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $sinStock }}</div>
        <div class="kpi-sub">stock ≤ mínimo</div>
    </div>
</div>

{{-- ── Gráficos principales ── --}}
<div class="section-row">

    {{-- Barra clientes --}}
    <div class="chart-card">
        <div class="chart-title">🏆 Top 10 productos más vendidos</div>
        <div style="position:relative;width:100%;height:220px;">
            <canvas id="clientesChart"></canvas>
        </div>
    </div>

    <div class="right-col">
        {{-- Donut estado --}}
        <div class="stat-card">
            <div class="chart-title">📈 Estado general</div>
            <div class="legend">
                <span class="leg-item"><span class="leg-dot" style="background:#22c55e;"></span>Completas</span>
                <span class="leg-item"><span class="leg-dot" style="background:#f59e0b;"></span>Parciales</span>
                <span class="leg-item"><span class="leg-dot" style="background:#ef4444;"></span>Incompletas</span>
            </div>
            <div style="position:relative;height:130px;">
                <canvas id="estadoChart"></canvas>
            </div>
        </div>

        {{-- Tipos de orden barras --}}
        <div class="stat-card">
            <div class="chart-title">🏷️ Tipos de orden</div>
            @foreach($tiposConteo as $tipo => $cnt)
            @php $pct = $maxTipo > 0 ? round($cnt / $maxTipo * 100) : 0; @endphp
            <div class="prog-item">
                <div class="prog-hdr">
                    <span>{{ $tipo }}</span>
                    <span style="font-weight:700;">{{ $cnt }}</span>
                </div>
                <div class="prog-bar">
                    <div class="prog-fill" style="width:{{ $pct }}%;background:#0b5ed7;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ── Fila inferior ── --}}
<div class="bottom-row">

    {{-- Línea facturación --}}
    <div class="chart-card">
        <div class="chart-title">📅 Facturación — últimos 6 meses</div>
        <div style="position:relative;height:160px;">
            <canvas id="facturacionChart"></canvas>
        </div>
    </div>

    {{-- Tabla recientes --}}
    <div class="chart-card" style="padding:0;overflow:hidden;">
        <div style="padding:.85rem 1.1rem;border-bottom:1px solid #f1f5f9;">
            <div class="chart-title" style="margin:0;">🕐 Órdenes recientes</div>
        </div>
        <div style="overflow-x:auto;">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ordenesRecientes as $ord)
                    @php
                        $badgeCls = $ord->estado === 'COMPLETO' ? 'bc'
                                  : ($ord->estado === 'PARCIAL'  ? 'bp' : 'bi');
                    @endphp
                    <tr>
                        <td style="font-weight:600;font-family:'Consolas',monospace;font-size:11px;">
                            {{ $ord->numero_orden }}
                        </td>
                        <td style="max-width:110px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $ord->client->razon_social ?? '—' }}
                        </td>
                        <td style="font-weight:600;color:#15803d;white-space:nowrap;">
                            S/ {{ number_format($ord->total,0) }}
                        </td>
                        <td>
                            <span class="badge {{ $badgeCls }}">{{ $ord->estado }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

</div>
</div>
<x-fano />
{{-- ── Scripts ── --}}
@php
    $labelsClientes = json_encode($topProductos->map(fn($d) => $d->product->nombre ?? '?')->values()->toArray());
    $valuesClientes = json_encode($topProductos->map(fn($d) => (int)$d->total_vendido)->values()->toArray());
    $mesesLabelsJ   = json_encode($mesesLabels);
    $mesesDataJ     = json_encode($mesesData);
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var labelsClientes = {!! $labelsClientes !!};
var valuesClientes = {!! $valuesClientes !!};
var mesesLabels    = {!! $mesesLabelsJ !!};
var mesesData      = {!! $mesesDataJ !!};

var colores = ['#0b5ed7','#7c3aed','#0ea5e9','#f59e0b','#22c55e','#ef4444','#ec4899','#14b8a6'];

new Chart(document.getElementById('clientesChart'), {
    type: 'bar',
    data: {
        labels: labelsClientes,
        datasets: [{
            label: 'Pedidos del mes',
            data: valuesClientes,
            backgroundColor: colores.slice(0, labelsClientes.length),
            borderRadius: 5,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } }
        }
    }
});

new Chart(document.getElementById('estadoChart'), {
    type: 'doughnut',
    data: {
        labels: ['Completas','Parciales','Incompletas'],
        datasets: [{
            data: [{{ $completas }}, {{ $parciales }}, {{ $incompletas }}],
            backgroundColor: ['#22c55e','#f59e0b','#ef4444'],
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

new Chart(document.getElementById('facturacionChart'), {
    type: 'line',
    data: {
        labels: mesesLabels,
        datasets: [{
            label: 'Facturación S/',
            data: mesesData,
            borderColor: '#0b5ed7',
            backgroundColor: 'rgba(11,94,215,.08)',
            borderWidth: 2,
            pointBackgroundColor: '#0b5ed7',
            pointRadius: 4,
            tension: .4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
            y: {
                grid: { color: '#f1f5f9' },
                ticks: {
                    font: { size: 10 },
                    callback: function(v){ return 'S/' + v.toLocaleString(); }
                }
            }
        }
    }
});
</script>
<script>

document.addEventListener("DOMContentLoaded", function () {

    const stock = {{ $stockBajo }};

    const chat = document.getElementById("fano-chat");
    const mensaje = document.getElementById("fano-message");
    const imagen = document.getElementById("fano-img");
    const boton = document.getElementById("fano-btn");

    const hora = new Date().getHours();

    let saludo = "";

    if (hora < 12) {
        saludo = "☀️ Buenos días";
    } else if (hora < 18) {
        saludo = "🌤️ Buenas tardes";
    } else {
        saludo = "🌙 Buenas noches";
    }

    function escribir(texto, velocidad = 25) {

        mensaje.innerHTML = "";

        let i = 0;

        return new Promise(resolve => {

            const intervalo = setInterval(() => {

                mensaje.innerHTML += texto.charAt(i);

                i++;

                if (i >= texto.length) {

                    clearInterval(intervalo);

                    resolve();

                }

            }, velocidad);

        });

    }

    async function iniciarFano() {

        clearTimeout(window.fanoOcultar);

        boton.style.display = "none";

        chat.classList.remove("fano-hidden");
        chat.classList.add("fano-show");

        imagen.src="/assets/fano/expresiones/invierno/Saludando.png";

        await escribir(
            saludo + "\nBienvenido a DISTAN 👋",
            22
        );

        await new Promise(r => setTimeout(r,700));

        imagen.src="/assets/fano/expresiones/invierno/Pensando.png";

        await escribir(
            "🔎 Revisando el almacén...",
            25
        );

        await new Promise(r => setTimeout(r,1000));

        if(stock==0){

            imagen.src="/assets/fano/expresiones/invierno/Saludando.png";

            await escribir(
                "✅ Todo está en orden.\nNo encontré productos con stock bajo.",
                22
            );

        }else{

            imagen.src="/assets/fano/expresiones/invierno/Pensando.png";

            await escribir(
                "⚠ Encontré "+stock+" productos con stock bajo.",
                22
            );

            boton.style.display="block";

        }

        window.fanoOcultar=setTimeout(function(){

            chat.classList.remove("fano-show");
            chat.classList.add("fano-hidden");

        },8000);

    }

    imagen.addEventListener("click",function(){

        iniciarFano();

    });

    boton.addEventListener("click",function(){

        window.location.href="{{ route('products.index') }}";

    });

    iniciarFano();

});

</script>

@endsection
