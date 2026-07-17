@extends('layouts.app')

@section('title', 'Desmedro ' . $desmedro->codigo)

@push('styles')
<style>
    :root {
        --dsm-navy: #1B2A4A;
        --dsm-bg: #F4F6F9;
        --dsm-card: #FFFFFF;
        --dsm-border: #E3E7EE;
        --dsm-red: #C0392B;
        --dsm-red-bg: #FDEDEB;
        --dsm-green: #15803D;
        --dsm-green-bg: #EAF7EF;
        --dsm-ink: #1F2937;
        --dsm-muted: #6B7280;
        --dsm-mono: 'JetBrains Mono', 'Roboto Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
    }

    .dsmd-wrap { background: var(--dsm-bg); min-height: 100%; padding: 24px; }
    .dsmd-back { font-size: 12.5px; color: var(--dsm-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 14px; }
    .dsmd-back:hover { color: var(--dsm-navy); }

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

    /* Sello "DESMEDRADO" al estilo timbre de almacén */
    .dsmd-stamp {
        border: 3px solid #EF6E64; color: #EF6E64; border-radius: 10px;
        font-weight: 800; font-size: 13px; letter-spacing: 2px; padding: 8px 16px;
        transform: rotate(6deg); opacity: .9; text-transform: uppercase;
        font-family: var(--dsm-mono);
    }

    .dsmd-kpis { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--dsm-border); }
    .dsmd-kpi { background: #fff; padding: 18px 24px; border-left: 3px solid transparent; }
    .dsmd-kpi.red { border-left-color: var(--dsm-red); }
    .dsmd-kpi.navy { border-left-color: var(--dsm-navy); }
    .dsmd-kpi.green { border-left-color: var(--dsm-green); }
    .dsmd-kpi .k-label { font-size: 10.5px; text-transform: uppercase; letter-spacing: .6px; color: var(--dsm-muted); }
    .dsmd-kpi .k-value { font-family: var(--dsm-mono); font-size: 21px; font-weight: 700; color: var(--dsm-ink); margin-top: 4px; }

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

    .dsmd-foot { padding: 18px 28px 24px; display: flex; justify-content: flex-end; gap: 10px; }
    .dsmd-btn {
        border-radius: 10px; padding: 10px 18px; font-size: 12.5px; font-weight: 600;
        border: 1px solid var(--dsm-border); background: #fff; color: var(--dsm-ink); cursor: pointer; text-decoration: none;
    }
    .dsmd-btn:hover { background: #F7F9FC; }
</style>
@endpush

@section('content')
<div class="dsmd-wrap">
    <a href="{{ route('desmedros.index') }}" class="dsmd-back">&larr; Volver a desmedros</a>

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
                <div class="k-value" style="font-size:15px; color: {{ $desmedro->estado === 'registrado' ? 'var(--dsm-green)' : 'var(--dsm-amber, #D97706)' }};">
                    {{ $desmedro->estado === 'registrado' ? 'Registrado — stock descontado' : 'Borrador' }}
                </div>
            </div>
        </div>

        <div class="dsmd-table-wrap">
            <table class="dsmd-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Stock antes</th>
                        <th>Stock después</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($desmedro->detalles as $d)
                        <tr>
                            <td class="dsmd-code-cell">{{ $d->producto->sku }}</td>
                            <td>{{ $d->producto->nombre }}</td>
                            <td class="dsmd-qty-cell">{{ number_format($d->cantidad, 2) }}</td>
                            <td class="dsmd-stock-cell">{{ $d->stock_antes !== null ? number_format($d->stock_antes, 2) : '—' }}</td>
                            <td class="dsmd-stock-cell">
                                {{ $d->stock_antes !== null ? number_format($d->stock_antes - $d->cantidad, 2) : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="dsmd-foot">
            <button class="dsmd-btn" onclick="window.print()">Imprimir manifiesto</button>
        </div>
    </div>
</div>
@endsection
