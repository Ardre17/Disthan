@extends('layouts.app')

@section('content')

<style>
    .kx-page  { background:#f0f2f5; min-height:100vh; padding:24px; }
    .kx-card  { background:white; border-radius:10px; box-shadow:0 1px 4px rgba(0,0,0,.07); }

    .kx-kpi-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:20px; }
    .kx-kpi { padding:16px 18px; border-radius:10px; background:white; box-shadow:0 1px 4px rgba(0,0,0,.07); border-top:3px solid transparent; transition:transform .15s; }
    .kx-kpi:hover { transform:translateY(-2px); }
    .kx-kpi-label { font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:#8c8c8c; margin:0; }
    .kx-kpi-value { font-size:22px; font-weight:700; margin:4px 0 0; color:#1a1a2e; }

    .kx-filter-bar { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; padding:16px 20px; }
    .kx-filter-group { display:flex; flex-direction:column; gap:5px; }
    .kx-filter-group label { font-size:11px; font-weight:600; color:#8c8c8c; text-transform:uppercase; letter-spacing:.04em; }
    .kx-filter-group select,
    .kx-filter-group input  { border:1px solid #e2e8f0; border-radius:7px; padding:8px 12px; font-size:13px; outline:none; color:#1a1a2e; background:white; min-width:160px; }
    .kx-filter-group select:focus,
    .kx-filter-group input:focus { border-color:#1890ff; }
    .kx-btn-filter { background:#1890ff; color:white; border:none; border-radius:7px; padding:9px 18px; font-size:13px; font-weight:600; cursor:pointer; align-self:flex-end; transition:opacity .15s; }
    .kx-btn-filter:hover { opacity:.85; }
    .kx-btn-reset  { background:#f0f0f0; color:#595959; border:none; border-radius:7px; padding:9px 14px; font-size:13px; cursor:pointer; align-self:flex-end; text-decoration:none; display:inline-block; }

    .kx-table { width:100%; border-collapse:collapse; font-size:13px; }
    .kx-table thead th { background:#fafafa; color:#595959; font-weight:600; padding:11px 14px; text-align:left; border-bottom:2px solid #f0f0f0; white-space:nowrap; }
    .kx-table tbody tr { border-bottom:1px solid #f5f5f5; transition:background .1s; }
    .kx-table tbody tr:hover { background:#f8faff; }
    .kx-table tbody td { padding:10px 14px; color:#1a1a2e; vertical-align:middle; }
    .kx-table tfoot td { padding:11px 14px; font-weight:700; background:#f0f7ff; color:#1890ff; border-top:2px solid #bae0ff; }

    .kx-badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
    .kx-estado { display:inline-block; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }

    .kx-inv-row { display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid #f5f5f5; gap:10px; }
    .kx-inv-row:last-child { border-bottom:none; }
    .kx-inv-bar  { height:5px; border-radius:3px; background:#e2e8f0; margin-top:4px; }
    .kx-inv-fill { height:5px; border-radius:3px; }

    @media (max-width:1100px) {
        .kx-kpi-grid  { grid-template-columns:repeat(3,1fr) !important; }
        .kx-main-grid { grid-template-columns:1fr !important; }
    }
    @media (max-width:640px) {
        .kx-kpi-grid { grid-template-columns:repeat(2,1fr) !important; }
    }
</style>

<div class="kx-page">

{{-- HEADER --}}
<div class="kx-card" style="padding:16px 22px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;border-left:5px solid #1890ff;flex-wrap:wrap;gap:10px;">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="width:48px;height:48px;border-radius:12px;background:#e6f0ff;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">📒</div>
        <div>
            <h1 style="font-size:20px;font-weight:700;margin:0;color:#1a1a2e;">Kardex de Inventario</h1>
            <p style="font-size:12px;color:#8c8c8c;margin:2px 0 0;">Historial de despachos · Entradas y salidas · Saldo por producto · {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('kardex.index') }}" style="font-size:12px;color:#1890ff;text-decoration:none;background:#e6f0ff;padding:7px 14px;border-radius:6px;">🔄 Actualizar</a>
</div>

{{-- KPIs --}}
<div class="kx-kpi-grid">
    <div class="kx-kpi" style="border-top-color:#1890ff;">
        <p class="kx-kpi-label">Movimientos</p>
        <p class="kx-kpi-value">{{ number_format($totalMovimientos) }}</p>
        <span style="font-size:16px;opacity:.35;">📋</span>
    </div>
    <div class="kx-kpi" style="border-top-color:#cf1322;">
        <p class="kx-kpi-label">Uds. Despachadas</p>
        <p class="kx-kpi-value" style="color:#cf1322;">{{ number_format($totalSalidas) }}</p>
        <span style="font-size:16px;opacity:.35;">📤</span>
    </div>
    <div class="kx-kpi" style="border-top-color:#08979c;">
        <p class="kx-kpi-label">Clientes Activos</p>
        <p class="kx-kpi-value" style="color:#08979c;">{{ $clientesActivos }}</p>
        <span style="font-size:16px;opacity:.35;">👥</span>
    </div>
    <div class="kx-kpi" style="border-top-color:#722ed1;">
        <p class="kx-kpi-label">Productos Movidos</p>
        <p class="kx-kpi-value" style="color:#722ed1;">{{ $productosMovidos }}</p>
        <span style="font-size:16px;opacity:.35;">📦</span>
    </div>
    <div class="kx-kpi" style="border-top-color:#389e0d;">
        <p class="kx-kpi-label">Total Facturado</p>
        <p class="kx-kpi-value" style="color:#389e0d;">S/ {{ number_format($totalFacturado, 2) }}</p>
        <span style="font-size:16px;opacity:.35;">💰</span>
    </div>
</div>

{{-- FILTROS --}}
<div class="kx-card" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('kardex.index') }}">
        <div class="kx-filter-bar">
            <div class="kx-filter-group">
                <label>Producto</label>
                <select name="product_id">
                    <option value="">Todos los productos</option>
                    @foreach($productos as $prod)
                        <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>
                            {{ $prod->nombre }} @if($prod->sku) · {{ $prod->sku }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="kx-filter-group">
                <label>Cliente</label>
                <select name="client_id">
                    <option value="">Todos los clientes</option>
                    @foreach($clientes as $cli)
                        <option value="{{ $cli->id }}" {{ $clientId == $cli->id ? 'selected' : '' }}>
                            {{ $cli->razon_social }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="kx-filter-group">
                <label>Desde</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}">
            </div>
            <div class="kx-filter-group">
                <label>Hasta</label>
                <input type="date" name="date_to" value="{{ $dateTo }}">
            </div>
            <button type="submit" class="kx-btn-filter">🔍 Filtrar</button>
            <a href="{{ route('kardex.index') }}" class="kx-btn-reset">✕ Limpiar</a>
        </div>
    </form>
</div>


{{-- ═══════════════════════════════════════════════════════
     GRÁFICO DE TENDENCIAS — solo visible al filtrar
═══════════════════════════════════════════════════════ --}}
@if(!is_null($chartData))
@php
    $chartTitle = $chartData['producto']
        ? '📈 Tendencia de despachos · ' . $chartData['producto']
        : ($chartData['cliente'] ? '📈 Tendencia de despachos · ' . $chartData['cliente'] : '📈 Tendencia');
    $totalDesp  = collect($chartData['despachado'])->sum();
    $totalSoli  = collect($chartData['solicitado'])->sum();
    $totalFact  = collect($chartData['subtotal'])->sum();
    $totalOrd   = collect($chartData['ordenes'])->sum();
    $eficiencia = $totalSoli > 0 ? round(($totalDesp / $totalSoli) * 100, 1) : 0;
@endphp

<div style="background:white;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">

    {{-- Header azul --}}
    <div style="background:#1890ff;padding:12px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <div style="font-size:13px;font-weight:700;color:white;">{{ $chartTitle }}</div>
        <span style="font-size:11px;color:rgba(255,255,255,.7);">Últimos 12 meses · agrupado por mes</span>
    </div>

    {{-- Mini KPIs del gráfico --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0;border-bottom:1px solid #f0f0f0;">
        <div style="padding:12px 18px;border-right:1px solid #f0f0f0;">
            <p style="font-size:10px;color:#8c8c8c;text-transform:uppercase;letter-spacing:.05em;margin:0;">Total despachado</p>
            <p style="font-size:20px;font-weight:700;color:#cf1322;margin:3px 0 0;">{{ number_format($totalDesp) }} u.</p>
        </div>
        <div style="padding:12px 18px;border-right:1px solid #f0f0f0;">
            <p style="font-size:10px;color:#8c8c8c;text-transform:uppercase;letter-spacing:.05em;margin:0;">Total solicitado</p>
            <p style="font-size:20px;font-weight:700;color:#595959;margin:3px 0 0;">{{ number_format($totalSoli) }} u.</p>
        </div>
        <div style="padding:12px 18px;border-right:1px solid #f0f0f0;">
            <p style="font-size:10px;color:#8c8c8c;text-transform:uppercase;letter-spacing:.05em;margin:0;">Facturado (filtro)</p>
            <p style="font-size:20px;font-weight:700;color:#389e0d;margin:3px 0 0;">S/ {{ number_format($totalFact, 2) }}</p>
        </div>
        <div style="padding:12px 18px;">
            <p style="font-size:10px;color:#8c8c8c;text-transform:uppercase;letter-spacing:.05em;margin:0;">Eficiencia despacho</p>
            <p style="font-size:20px;font-weight:700;margin:3px 0 0;
                color:{{ $eficiencia >= 90 ? '#389e0d' : ($eficiencia >= 60 ? '#d48806' : '#cf1322') }};">
                {{ $eficiencia }}%
            </p>
        </div>
    </div>

    {{-- Canvas --}}
    <div style="padding:16px 20px;">
        @if(count($chartData['labels']) === 0)
            <div style="text-align:center;padding:40px;color:#bfbfbf;">
                <p style="font-size:28px;margin:0;">📭</p>
                <p style="margin:8px 0 0;font-size:13px;">Sin movimientos en el período seleccionado</p>
            </div>
        @else
            <div style="height:240px;position:relative;">
                <canvas id="kardexChart"></canvas>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    const labels     = @json($chartData['labels']);
    const despachado = @json($chartData['despachado']);
    const solicitado = @json($chartData['solicitado']);
    const subtotales = @json($chartData['subtotal']);

    if (!labels.length) return;

    const ctx = document.getElementById('kardexChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Despachado',
                    data: despachado,
                    borderColor: '#cf1322',
                    backgroundColor: 'rgba(207,19,34,.07)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#cf1322',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.35,
                    fill: true,
                    yAxisID: 'y',
                },
                {
                    label: 'Solicitado',
                    data: solicitado,
                    borderColor: '#1890ff',
                    backgroundColor: 'rgba(24,144,255,.05)',
                    borderWidth: 2,
                    pointBackgroundColor: '#1890ff',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    tension: 0.35,
                    fill: false,
                    borderDash: [5,3],
                    yAxisID: 'y',
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font:{ size:11 }, boxWidth:12, padding:16 }
                },
                tooltip: {
                    callbacks: {
                        afterBody: function(items) {
                            const idx = items[0]?.dataIndex;
                            if (idx === undefined) return '';
                            const sub = subtotales[idx] ?? 0;
                            return ['', `💰 Facturado: S/ ${parseFloat(sub).toLocaleString('es-PE', {minimumFractionDigits:2})}`];
                        },
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString()} u.`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color:'#f5f5f5' },
                    ticks: { font:{ size:10 }, color:'#8c8c8c',
                        callback: v => v.toLocaleString() + ' u.'
                    }
                },
                x: {
                    grid: { display:false },
                    ticks: { font:{ size:10 }, color:'#8c8c8c' }
                }
            }
        }
    });
})();
</script>
@endif
{{-- ── FIN GRÁFICO ── --}}

{{-- GRID PRINCIPAL --}}
<div class="kx-main-grid" style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

    {{-- TABLA MOVIMIENTOS --}}
    <div class="kx-card" style="overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between;align-items:center;">
            <p style="font-weight:700;font-size:14px;margin:0;color:#1a1a2e;">📋 Movimientos de despacho</p>
            <span style="font-size:12px;color:#8c8c8c;">{{ $totalMovimientos }} registros · página {{ $movimientosPaginados->currentPage() }} de {{ $movimientosPaginados->lastPage() }}</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="kx-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>N° Orden</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th style="text-align:right;">Solicitado</th>
                        <th style="text-align:right;">Despachado</th>
                        <th style="text-align:right;">Precio U.</th>
                        <th style="text-align:right;">Subtotal</th>
                        <th>Estado ítem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movimientosPaginados as $i => $mov)
                    @php
                        $estadoItemColors = [
                            'COMPLETO'   => ['bg'=>'#f6ffed','color'=>'#389e0d'],
                            'PARCIAL'    => ['bg'=>'#fffbe6','color'=>'#d48806'],
                            'INCOMPLETO' => ['bg'=>'#fff1f0','color'=>'#cf1322'],
                        ];
                        $ec = $estadoItemColors[$mov['estado_item']] ?? ['bg'=>'#f5f5f5','color'=>'#595959'];
                        $pctDespachado = $mov['cantidad_solicitada'] > 0
                            ? round(($mov['cantidad_despachada'] / $mov['cantidad_solicitada']) * 100)
                            : 0;
                    @endphp
                    <tr>
                        <td style="color:#bfbfbf;font-size:12px;">{{ $i + 1 }}</td>
                        <td style="white-space:nowrap;color:#595959;font-size:12px;">
                            {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}
                        </td>
                        <td>
                            <span style="font-weight:600;color:#1890ff;">{{ $mov['numero_orden'] }}</span>
                        </td>
                        <td style="max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $mov['cliente'] }}
                        </td>
                        <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $mov['producto'] }}
                        </td>
                        <td style="text-align:right;color:#595959;">{{ number_format($mov['cantidad_solicitada']) }}</td>
                        <td style="text-align:right;">
                            <span style="font-weight:700;color:#cf1322;">{{ number_format($mov['cantidad_despachada']) }}</span>
                            <div style="height:4px;background:#f0f0f0;border-radius:3px;margin-top:3px;min-width:50px;">
                                <div style="height:4px;width:{{ $pctDespachado }}%;background:{{ $ec['color'] }};border-radius:3px;"></div>
                            </div>
                        </td>
                        <td style="text-align:right;color:#595959;">S/ {{ number_format($mov['precio_unitario'], 2) }}</td>
                        <td style="text-align:right;font-weight:600;">S/ {{ number_format($mov['subtotal'], 2) }}</td>
                        <td>
                            <span class="kx-estado" style="background:{{ $ec['bg'] }};color:{{ $ec['color'] }};">
                                {{ $mov['estado_item'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align:center;padding:48px;color:#bfbfbf;">
                            <p style="font-size:32px;margin:0;">📭</p>
                            <p style="margin:8px 0 0;">No hay movimientos con los filtros aplicados</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($movimientosPaginados->total() > 0)
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align:right;color:#595959;">TOTALES</td>
                        <td style="text-align:right;">{{ number_format($movimientosPaginados->sum('cantidad_solicitada')) }}</td>
                        <td style="text-align:right;">{{ number_format($totalSalidas) }}</td>
                        <td></td>
                        <td style="text-align:right;">S/ {{ number_format($totalFacturado, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        @if($movimientosPaginados->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <p style="font-size:12px;color:#8c8c8c;margin:0;">
                Mostrando {{ $movimientosPaginados->firstItem() }}–{{ $movimientosPaginados->lastItem() }} de {{ $movimientosPaginados->total() }} movimientos
            </p>
            <div style="display:flex;gap:4px;align-items:center;">
                {{-- Anterior --}}
                @if($movimientosPaginados->onFirstPage())
                    <span style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#d0d0d0;cursor:default;">‹ Ant.</span>
                @else
                    <a href="{{ $movimientosPaginados->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#1890ff;text-decoration:none;">‹ Ant.</a>
                @endif

                {{-- Páginas --}}
                @foreach($movimientosPaginados->getUrlRange(
                    max(1, $movimientosPaginados->currentPage() - 2),
                    min($movimientosPaginados->lastPage(), $movimientosPaginados->currentPage() + 2)
                ) as $page => $url)
                    @if($page == $movimientosPaginados->currentPage())
                        <span style="padding:6px 12px;border:1px solid #1890ff;border-radius:6px;font-size:12px;background:#1890ff;color:white;font-weight:600;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#595959;text-decoration:none;">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Siguiente --}}
                @if($movimientosPaginados->hasMorePages())
                    <a href="{{ $movimientosPaginados->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#1890ff;text-decoration:none;">Sig. ›</a>
                @else
                    <span style="padding:6px 12px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#d0d0d0;cursor:default;">Sig. ›</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- PANEL DERECHO --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Saldo actual de stock --}}
        <div class="kx-card" style="overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f0f0f0;">
                <p style="font-weight:700;font-size:14px;margin:0;color:#1a1a2e;">📦 Stock actual</p>
                <p style="font-size:11px;color:#8c8c8c;margin:3px 0 0;">Saldo por producto en inventario</p>
            </div>
            <div style="padding:12px 20px;max-height:320px;overflow-y:auto;">
                @php $maxStock = max($stockProductos->max('stock'), 1); @endphp
                @forelse($stockProductos as $prod)
                @php
                    $color = $prod->stock <= ($prod->stock_minimo ?? 5)
                        ? '#cf1322'
                        : ($prod->stock <= (($prod->stock_minimo ?? 5) * 2) ? '#d48806' : '#1890ff');
                @endphp
                <div class="kx-inv-row">
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;color:#1a1a2e;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500;">
                            {{ $prod->nombre }}
                        </p>
                        @if($prod->sku)
                        <p style="font-size:11px;color:#bfbfbf;margin:1px 0 0;">SKU: {{ $prod->sku }}</p>
                        @endif
                        <div class="kx-inv-bar">
                            <div class="kx-inv-fill" style="width:{{ $maxStock > 0 ? round(($prod->stock/$maxStock)*100) : 0 }}%;background:{{ $color }};"></div>
                        </div>
                    </div>
                    <div style="text-align:right;flex-shrink:0;margin-left:10px;">
                        <span style="font-size:15px;font-weight:700;color:{{ $color }};">{{ number_format($prod->stock) }}</span>
                        @if($prod->stock_minimo)
                        <p style="font-size:10px;color:#bfbfbf;margin:0;">mín: {{ $prod->stock_minimo }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <p style="text-align:center;color:#bfbfbf;font-size:13px;padding:20px 0;">Sin productos activos</p>
                @endforelse
            </div>
        </div>

        {{-- Top clientes --}}
        @if($movimientosPaginados->total() > 0)
        <div class="kx-card" style="overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f0f0f0;">
                <p style="font-weight:700;font-size:14px;margin:0;color:#1a1a2e;">👥 Top clientes</p>
                <p style="font-size:11px;color:#8c8c8c;margin:3px 0 0;">Por unidades despachadas</p>
            </div>
            <div style="padding:12px 20px;">
                @php
                    $topClientes = $movimientosPaginados->groupBy('cliente')
                        ->map(fn($g) => ['uds' => $g->sum('cantidad_despachada'), 'total' => $g->sum('subtotal')])
                        ->sortByDesc('uds')->take(5);
                    $maxCli = $topClientes->max('uds') ?: 1;
                @endphp
                @foreach($topClientes as $nombre => $data)
                <div class="kx-inv-row">
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;color:#1a1a2e;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500;">{{ $nombre }}</p>
                        <p style="font-size:11px;color:#bfbfbf;margin:1px 0 2px;">S/ {{ number_format($data['total'], 2) }}</p>
                        <div class="kx-inv-bar">
                            <div class="kx-inv-fill" style="width:{{ round(($data['uds']/$maxCli)*100) }}%;background:#722ed1;"></div>
                        </div>
                    </div>
                    <span style="font-size:14px;font-weight:700;color:#722ed1;margin-left:10px;flex-shrink:0;">{{ number_format($data['uds']) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

</div>
@endsection