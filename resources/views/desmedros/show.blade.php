@extends('layouts.app')

@section('title', 'Desmedro ' . $desmedro->codigo)


@section('content')
<style>
    :root {
        --dsm-navy: #1B2A4A;
        --dsm-bg: #F4F6F9;
        --dsm-card: #FFFFFF;
        --dsm-border: #E3E7EE;
        --dsm-red: #C0392B;
        --dsm-red-bg: #FDEDEB;
        --dsm-amber: #D97706;
        --dsm-amber-bg: #FEF3E2;
        --dsm-green: #15803D;
        --dsm-green-bg: #EAF7EF;
        --dsm-ink: #1F2937;
        --dsm-muted: #6B7280;
        --dsm-mono: 'JetBrains Mono', 'Roboto Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
    }

    .dsmd-wrap { background: var(--dsm-bg); min-height: 100%; padding: 24px; }

    .dsmd-breadcrumb { font-size: 12px; color: var(--dsm-muted); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
    .dsmd-breadcrumb a { color: var(--dsm-muted); text-decoration: none; }
    .dsmd-breadcrumb a:hover { color: var(--dsm-navy); }
    .dsmd-breadcrumb .sep { opacity: .5; }
    .dsmd-breadcrumb .current { color: var(--dsm-ink); font-weight: 600; }

    .dsmd-alert {
        border-radius: 10px; padding: 13px 16px; font-size: 13px; margin-bottom: 16px;
        display: flex; align-items: flex-start; gap: 10px; border: 1px solid transparent;
    }
    .dsmd-alert.success { background: var(--dsm-green-bg); color: #0F5C31; border-color: #BFE6CD; }
    .dsmd-alert.info { background: #EBF1FE; color: #1E3A73; border-color: #C8D8FA; }

    .dsmd-layout { display: grid; grid-template-columns: 1fr 300px; gap: 18px; align-items: start; }
    @media (max-width: 980px) { .dsmd-layout { grid-template-columns: 1fr; } }

    .dsmd-card {
        background: var(--dsm-card); border: 1px solid var(--dsm-border); border-radius: 16px;
        box-shadow: 0 1px 3px rgba(16,24,40,.06); position: relative; overflow: hidden;
    }

    .dsmd-head {
        background: var(--dsm-navy); color: #fff; padding: 26px 28px; position: relative;
        display: flex; justify-content: space-between; align-items: flex-start;
    }
    .dsmd-head .label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.2px; color: #97A6C4; }
    .dsmd-head .codigo { font-family: var(--dsm-mono); font-size: 26px; font-weight: 700; margin-top: 4px; letter-spacing: .5px; }
    .dsmd-head .meta { margin-top: 10px; font-size: 12.5px; color: #C4CEE0; }

    .dsmd-stamp {
        border: 3px solid #EF6E64; color: #EF6E64; border-radius: 10px;
        font-weight: 800; font-size: 13px; letter-spacing: 2px; padding: 8px 16px;
        transform: rotate(6deg); opacity: .9; text-transform: uppercase;
        font-family: var(--dsm-mono);
    }
    .dsmd-stamp.pendiente { border-color: #F5B342; color: #F5B342; }

    .dsmd-kpis { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--dsm-border); }
    .dsmd-kpi { background: #fff; padding: 18px 24px; border-left: 3px solid transparent; }
    .dsmd-kpi.red { border-left-color: var(--dsm-red); }
    .dsmd-kpi.navy { border-left-color: var(--dsm-navy); }
    .dsmd-kpi.green { border-left-color: var(--dsm-green); }
    .dsmd-kpi .k-label { font-size: 10.5px; text-transform: uppercase; letter-spacing: .6px; color: var(--dsm-muted); }
    .dsmd-kpi .k-value { font-family: var(--dsm-mono); font-size: 21px; font-weight: 700; color: var(--dsm-ink); margin-top: 4px; }

    .dsmd-section-title {
        padding: 18px 28px 4px; font-size: 12.5px; font-weight: 700; color: var(--dsm-ink);
        text-transform: uppercase; letter-spacing: .5px;
    }

    .dsmd-table-wrap { padding: 8px 0 4px; }
    table.dsmd-table { width: 100%; border-collapse: collapse; }
    table.dsmd-table thead th {
        text-align: left; font-size: 10.5px; text-transform: uppercase; letter-spacing: .6px;
        color: var(--dsm-muted); padding: 12px 28px; border-bottom: 1px solid var(--dsm-border);
    }
    table.dsmd-table tbody td { padding: 13px 28px; font-size: 13.5px; color: var(--dsm-ink); border-bottom: 1px solid #F1F3F7; }
    table.dsmd-table tbody tr:last-child td { border-bottom: none; }
    .dsmd-code-cell { font-family: var(--dsm-mono); color: var(--dsm-navy); font-weight: 600; }
    .dsmd-qty-cell { font-family: var(--dsm-mono); color: var(--dsm-red); font-weight: 700; }
    .dsmd-stock-cell { font-family: var(--dsm-mono); color: var(--dsm-muted); font-size: 12.5px; }
    .dsmd-stock-cell.zero { color: var(--dsm-red); font-weight: 700; }

    .dsmd-foot { padding: 18px 28px 24px; display: flex; justify-content: flex-end; gap: 10px; }
    .dsmd-btn {
        border-radius: 10px; padding: 10px 18px; font-size: 12.5px; font-weight: 600;
        border: 1px solid var(--dsm-border); background: #fff; color: var(--dsm-ink); cursor: pointer; text-decoration: none;
    }
    .dsmd-btn:hover { background: #F7F9FC; }

    /* Sidebar */
    .dsmd-side-card {
        background: var(--dsm-card); border: 1px solid var(--dsm-border); border-radius: 14px;
        padding: 18px 20px; box-shadow: 0 1px 3px rgba(16,24,40,.06); margin-bottom: 14px;
    }
    .dsmd-side-card h3 { font-size: 12.5px; font-weight: 700; color: var(--dsm-ink); margin: 0 0 12px; }
    .dsmd-side-card canvas { max-height: 220px; }

    .dsmd-meta-list { display: flex; flex-direction: column; gap: 10px; }
    .dsmd-meta-item { display: flex; justify-content: space-between; font-size: 12.5px; }
    .dsmd-meta-item .l { color: var(--dsm-muted); }
    .dsmd-meta-item .v { color: var(--dsm-ink); font-weight: 600; text-align: right; }

    @media print {
        .dsmd-breadcrumb, .dsmd-foot, .dsmd-layout > div:last-child { display: none; }
        .dsmd-wrap { background: #fff; padding: 0; }
        .dsmd-layout { grid-template-columns: 1fr; }
    }
</style>
<div class="dsmd-wrap">
    <div class="dsmd-breadcrumb">
        <a href="{{ url('/') }}">Inicio</a>
        <span class="sep">/</span>
        <a href="{{ route('desmedros.index') }}">Desmedros</a>
        <span class="sep">/</span>
        <span class="current">{{ $desmedro->codigo }}</span>
    </div>

    @if(session('success'))
        <div class="dsmd-alert success">
            <span>✓</span>
            <div><strong>Listo.</strong> {{ session('success') }}</div>
        </div>
    @endif

    @if($desmedro->estado === 'borrador')
        <div class="dsmd-alert info">
            <span>ℹ</span>
            <div>Esta caja todavía está <strong>en construcción</strong> y no ha descontado stock. Ve a <a href="{{ route('desmedros.index') }}">Desmedros</a> para seguir agregando productos o registrarla.</div>
        </div>
    @endif

    <div class="dsmd-layout">
        <div class="dsmd-card">
            <div class="dsmd-head">
                <div>
                    <div class="label">Caja de desmedro</div>
                    <div class="codigo">{{ $desmedro->codigo }}</div>
                    <div class="meta">
                        {{ optional($desmedro->registrado_at)->format('d/m/Y H:i') ?? 'Sin registrar' }}
                        &middot; Responsable: {{ $desmedro->usuario->name ?? '—' }}
                        @if($desmedro->motivo) &middot; {{ $desmedro->motivo }} @endif
                    </div>
                </div>
                @if($desmedro->estado === 'registrado')
                    <div class="dsmd-stamp">Desmedrado</div>
                @else
                    <div class="dsmd-stamp pendiente">Pendiente</div>
                @endif
            </div>

            <div class="dsmd-kpis">
                <div class="dsmd-kpi navy">
                    <div class="k-label">Productos distintos</div>
                    <div class="k-value">{{ $desmedro->detalles->count() }}</div>
                </div>
                <div class="dsmd-kpi red">
                    <div class="k-label">Cantidad total desmedrada</div>
                    <div class="k-value">{{ number_format($desmedro->detalles->sum('cantidad'), 2) }}</div>
                </div>
                <div class="dsmd-kpi green">
                    <div class="k-label">Estado</div>
                    <div class="k-value" style="font-size:15px; color: {{ $desmedro->estado === 'registrado' ? 'var(--dsm-green)' : 'var(--dsm-amber)' }};">
                        {{ $desmedro->estado === 'registrado' ? 'Registrado' : 'Borrador' }}
                    </div>
                </div>
            </div>

            <div class="dsmd-section-title">Detalle de productos</div>
            <div class="dsmd-table-wrap">
                <table class="dsmd-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Stock antes</th>
                            <th>Stock después</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desmedro->detalles as $d)
                            @php $stockDespues = $d->stock_antes !== null ? $d->stock_antes - $d->cantidad : null; @endphp
                            <tr>
                                <td class="dsmd-code-cell">{{ $d->producto->sku ?? '—' }}</td>
                                <td>{{ $d->producto->nombre ?? 'Producto eliminado' }}</td>
                                <td class="dsmd-qty-cell">{{ number_format($d->cantidad, 2) }}</td>
                                <td class="dsmd-stock-cell">{{ $d->stock_antes !== null ? number_format($d->stock_antes, 2) : '—' }}</td>
                                <td class="dsmd-stock-cell {{ $stockDespues !== null && $stockDespues <= 0 ? 'zero' : '' }}">
                                    {{ $stockDespues !== null ? number_format($stockDespues, 2) : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="dsmd-foot">
                <a href="{{ route('desmedros.index') }}" class="dsmd-btn">← Volver</a>
                <button class="dsmd-btn" onclick="window.print()">Imprimir manifiesto</button>
            </div>
        </div>

        <div>
            <div class="dsmd-side-card">
                <h3>Distribución por producto</h3>
                @if($desmedro->detalles->count())
                    <canvas id="dsmdDistChart"></canvas>
                @else
                    <p style="font-size:12px; color:var(--dsm-muted);">Sin productos aún.</p>
                @endif
            </div>

            <div class="dsmd-side-card">
                <h3>Datos de la caja</h3>
                <div class="dsmd-meta-list">
                    <div class="dsmd-meta-item"><span class="l">Código</span><span class="v">{{ $desmedro->codigo }}</span></div>
                    <div class="dsmd-meta-item"><span class="l">Creado</span><span class="v">{{ $desmedro->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="dsmd-meta-item"><span class="l">Registrado</span><span class="v">{{ optional($desmedro->registrado_at)->format('d/m/Y H:i') ?? '—' }}</span></div>
                    <div class="dsmd-meta-item"><span class="l">Responsable</span><span class="v">{{ $desmedro->usuario->name ?? '—' }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('dsmdDistChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($desmedro->detalles->pluck('producto.nombre')),
            datasets: [{
                data: @json($desmedro->detalles->pluck('cantidad')),
                backgroundColor: ['#C0392B', '#D97706', '#1B2A4A', '#2563EB', '#15803D', '#9333EA', '#0E7490', '#B91C1C'],
                borderWidth: 2,
                borderColor: '#fff',
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10.5 } } },
            },
        },
    });
});
</script>
@endsection
