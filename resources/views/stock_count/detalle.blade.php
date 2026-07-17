@extends('layouts.app')

@section('content')

@php
    // ── Todo calculado desde las variables que ya tienes ─────────────────
    $totalProductos   = $detalles->count();
    $exactos          = $detalles->filter(fn($d) => $d->diferencia === 0 || $d->diferencia === null)->count();
    $exactitud        = $totalProductos > 0 ? round(($exactos / $totalProductos) * 100, 1) : 0;
    $sobrante_abs     = $detalles->filter(fn($d) => $d->diferencia > 0)->sum('diferencia');
    $faltante_abs     = abs($detalles->filter(fn($d) => $d->diferencia < 0)->sum('diferencia'));
    $exactitudColor   = $exactitud >= 95 ? '#15803d' : ($exactitud >= 80 ? '#b45309' : '#b91c1c');
    $exactitudBg      = $exactitud >= 95 ? '#dcfce7' : ($exactitud >= 80 ? '#fef3c7' : '#fee2e2');
@endphp

<style>
*{box-sizing:border-box;}

/* ── ERP Shell ── */
.erp-bar{
    background:#1e3a5f;
    height:40px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;
    margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}
.erp-sep{width:1px;height:18px;background:#334155;}
.pg{padding:1.1rem;background:#eef1f5;min-height:100vh;font-family:'Segoe UI',-apple-system,sans-serif;}

/* ── Header del documento ── */
.doc-header{
    background:#fff;
    border:1px solid #dde2ea;
    border-top:4px solid #1e3a5f;
    border-radius:4px;
    padding:1rem 1.25rem;
    margin-bottom:.85rem;
    display:flex;align-items:flex-start;justify-content:space-between;
    flex-wrap:wrap;gap:10px;
}
.doc-id{font-size:20px;font-weight:800;color:#1e3a5f;letter-spacing:.5px;font-family:'Consolas',monospace;}
.doc-meta{font-size:11px;color:#64748b;margin-top:4px;display:flex;flex-wrap:wrap;gap:12px;}
.doc-meta span{display:flex;align-items:center;gap:4px;}
.doc-badge{
    padding:5px 14px;border-radius:3px;
    font-size:11px;font-weight:700;
    letter-spacing:.05em;text-transform:uppercase;
    background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe;
}

/* ── KPIs ── */
.kpis{display:grid;grid-template-columns:repeat(6,1fr);gap:8px;margin-bottom:.85rem;}
@media(max-width:900px){.kpis{grid-template-columns:repeat(3,1fr);}}
@media(max-width:500px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{
    background:#fff;border:1px solid #dde2ea;border-radius:4px;
    padding:.7rem .9rem;border-left:4px solid;
    position:relative;overflow:hidden;
}
.kpi-icon{position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.08;}
.kpi-label{font-size:9px;color:#5b6b7d;text-transform:uppercase;letter-spacing:.07em;font-weight:700;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;line-height:1;color:#1e293b;}
.kpi-sub{font-size:9px;color:#94a3b8;margin-top:2px;}

/* ── Panel ── */
.panel{background:#fff;border:1px solid #dde2ea;border-radius:4px;overflow:hidden;margin-bottom:.85rem;}
.panel-hdr{
    background:#f4f6f9;border-bottom:1px solid #dde2ea;
    padding:.6rem 1rem;
    display:flex;align-items:center;justify-content:space-between;
}
.panel-title{font-size:11px;font-weight:700;color:#1e3a5f;text-transform:uppercase;letter-spacing:.06em;}

/* ── Exactitud visual ── */
.exactitud-bar{height:8px;background:#e5e7eb;border-radius:99px;overflow:hidden;margin-top:4px;}
.exactitud-fill{height:100%;border-radius:99px;transition:width .4s;}

/* ── Tabla ── */
.erp-table{width:100%;border-collapse:collapse;font-size:12px;}
.erp-table thead th{
    background:#f4f6f9;color:#5b6b7d;
    font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;
    padding:8px 12px;border-bottom:2px solid #dde2ea;
    white-space:nowrap;
}
.erp-table thead th:not(:first-child){text-align:center;}
.erp-table tbody tr{border-bottom:1px solid #f4f6f9;transition:background .1s;}
.erp-table tbody tr:hover{background:#f8fafc;}
.erp-table tbody td{padding:9px 12px;color:#1e293b;vertical-align:middle;}
.erp-table tbody td:not(:first-child){text-align:center;}

/* Chips de diferencia */
.chip{
    display:inline-flex;align-items:center;gap:3px;
    padding:3px 9px;border-radius:3px;
    font-size:11px;font-weight:700;
    white-space:nowrap;
}
.chip-ok     {background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
.chip-over   {background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
.chip-under  {background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;}
.chip-neutral{background:#f8fafc;color:#94a3b8;border:1px solid #e2e8f0;}

/* Barra mini de exactitud por fila */
.row-bar{width:50px;height:4px;background:#e5e7eb;border-radius:99px;overflow:hidden;display:inline-block;vertical-align:middle;margin-left:4px;}
.row-fill{height:100%;border-radius:99px;}

/* Resumen lateral */
.resumen-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;padding:1rem;}
.resumen-item{text-align:center;padding:.75rem;border-radius:4px;border:1px solid #e5e7eb;}
.resumen-num{font-size:22px;font-weight:800;line-height:1;}
.resumen-label{font-size:10px;color:#64748b;margin-top:3px;text-transform:uppercase;letter-spacing:.05em;}

/* Print */
@media print{
    .erp-bar,.pg > *:not(.print-show){margin:0;}
    .erp-table tbody tr:nth-child(even) td{background:#f9fafb;}
}
</style>

{{-- ERP Bar --}}
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Control de Inventario</div>
    </div>
    <span class="erp-breadcrumb">Logística › Conteo Físico › {{ $conteo->codigo }}</span>
</div>

<div class="pg">

{{-- ── Cabecera del documento ── --}}
<div class="doc-header">
    <div>
        <div class="doc-id">📋 {{ $conteo->codigo }}</div>
        <div class="doc-meta">
            <span>📅 {{ \Carbon\Carbon::parse($conteo->fecha)->format('d M Y') }}</span>
            <span>👤 {{ $conteo->realizado_por ?? 'Sin asignar' }}</span>
            <span>🕒 Generado: {{ now()->format('H:i') }}</span>
        </div>
    </div>
    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <span class="doc-badge">Conteo Físico</span>
        <div style="text-align:center;background:{{ $exactitudBg }};border:1px solid;border-color:{{ $exactitudColor }}33;border-radius:4px;padding:5px 14px;">
            <div style="font-size:18px;font-weight:800;color:{{ $exactitudColor }};line-height:1;">{{ $exactitud }}%</div>
            <div style="font-size:9px;color:{{ $exactitudColor }};text-transform:uppercase;letter-spacing:.05em;margin-top:1px;">Exactitud</div>
        </div>
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#1e3a5f;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Total productos</div>
        <div class="kpi-val">{{ $totalProductos }}</div>
        <div class="kpi-sub">en el conteo</div>
    </div>
    <div class="kpi" style="border-left-color:#15803d;background:#f0fdf4;">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Exactos</div>
        <div class="kpi-val" style="color:#15803d;">{{ $exactos }}</div>
        <div class="kpi-sub">sin diferencia</div>
    </div>
    <div class="kpi" style="border-left-color:#ef4444;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Con diferencia</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $totalDiferencias }}</div>
        <div class="kpi-sub">requieren revisión</div>
    </div>
    <div class="kpi" style="border-left-color:#1D9E75;background:#eafaf0;">
        <div class="kpi-icon">📈</div>
        <div class="kpi-label">Sobrantes</div>
        <div class="kpi-val" style="color:#1D9E75;">+{{ $sobrantes }}</div>
        <div class="kpi-sub">unidades de más</div>
    </div>
    <div class="kpi" style="border-left-color:#D85A30;background:#faece7;">
        <div class="kpi-icon">📉</div>
        <div class="kpi-label">Faltantes</div>
        <div class="kpi-val" style="color:#D85A30;">{{ $faltantes }}</div>
        <div class="kpi-sub">unidades de menos</div>
    </div>
    <div class="kpi" style="border-left-color:{{ $exactitudColor }};background:{{ $exactitudBg }};">
        <div class="kpi-icon">🎯</div>
        <div class="kpi-label">Exactitud</div>
        <div class="kpi-val" style="color:{{ $exactitudColor }};">{{ $exactitud }}%</div>
        <div class="kpi-sub">
            <div class="exactitud-bar">
                <div class="exactitud-fill" style="width:{{ $exactitud }}%;background:{{ $exactitudColor }};"></div>
            </div>
        </div>
    </div>
</div>

{{-- ── Tabla de conteo ── --}}
<div class="panel">
    <div class="panel-hdr">
        <div class="panel-title">📋 Detalle del conteo físico</div>
        <span style="font-size:10px;color:#94a3b8;">{{ $totalProductos }} productos · {{ $totalDiferencias }} con diferencia</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="erp-table">
            <thead>
                <tr>
                    <th style="text-align:left;width:35%;">Producto</th>
                    <th>Stock sistema</th>
                    <th>Stock físico</th>
                    <th>Diferencia</th>
                    <th>Estado</th>
                    <th>Exactitud</th>
                </tr>
            </thead>
            <tbody>
            @foreach($detalles as $detalle)
            @php
                $dif    = $detalle->diferencia;
                $fisico = $detalle->stock_fisico;
                $sist   = $detalle->stock_sistema;
                $rowExact = ($sist > 0 && $fisico !== null)
                    ? min(100, round(($fisico / $sist) * 100))
                    : ($dif === 0 || $dif === null ? 100 : 0);
                $rowColor = $dif === null ? '#94a3b8'
                    : ($dif === 0 ? '#15803d' : ($dif > 0 ? '#1d4ed8' : '#b91c1c'));
                $rowBarColor = $dif === 0 || $dif === null ? '#15803d'
                    : ($dif > 0 ? '#1d4ed8' : '#ef4444');
            @endphp
            <tr>
                <td>
                    <span style="font-weight:600;color:#0f172a;">{{ $detalle->product->nombre }}</span>
                </td>
                <td>
                    <span style="font-family:monospace;font-weight:600;color:#475569;">
                        {{ $sist }}
                    </span>
                </td>
                <td>
                    <span style="font-family:monospace;font-weight:600;color:#1e293b;">
                        {{ $fisico ?? '—' }}
                    </span>
                </td>
                <td>
                    @if($dif === null)
                        <span class="chip chip-neutral">—</span>
                    @elseif($dif === 0)
                        <span class="chip chip-ok">✓ 0</span>
                    @elseif($dif > 0)
                        <span class="chip chip-over">▲ +{{ $dif }}</span>
                    @else
                        <span class="chip chip-under">▼ {{ $dif }}</span>
                    @endif
                </td>
                <td>
                    @if($dif === null)
                        <span style="font-size:10px;color:#94a3b8;">Sin datos</span>
                    @elseif($dif === 0)
                        <span style="font-size:10px;font-weight:700;color:#15803d;">✅ Exacto</span>
                    @elseif($dif > 0)
                        <span style="font-size:10px;font-weight:700;color:#1d4ed8;">📈 Sobrante</span>
                    @else
                        <span style="font-size:10px;font-weight:700;color:#b91c1c;">📉 Faltante</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <div class="row-bar">
                            <div class="row-fill" style="width:{{ $rowExact }}%;background:{{ $rowBarColor }};"></div>
                        </div>
                        <span style="font-size:10px;font-weight:700;color:{{ $rowBarColor }};">{{ $rowExact }}%</span>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Resumen al pie de la tabla --}}
    <div style="border-top:2px solid #f0f4f9;background:#f8fafc;">
        <div class="resumen-grid">
            <div class="resumen-item" style="background:#f0fdf4;border-color:#bbf7d0;">
                <div class="resumen-num" style="color:#15803d;">{{ $exactos }}</div>
                <div class="resumen-label">Exactos</div>
            </div>
            <div class="resumen-item" style="background:#eafaf0;border-color:#6ee7b7;">
                <div class="resumen-num" style="color:#1D9E75;">+{{ $sobrantes }}</div>
                <div class="resumen-label">Sobrantes</div>
            </div>
            <div class="resumen-item" style="background:#faece7;border-color:#fca5a5;">
                <div class="resumen-num" style="color:#D85A30;">{{ $faltantes }}</div>
                <div class="resumen-label">Faltantes</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Firma / cierre ── --}}
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;padding:.5rem 0;">
    <div style="font-size:10px;color:#94a3b8;">
        DISTAN ERP · Conteo físico {{ $conteo->codigo }} ·
        Generado {{ now()->format('d/m/Y H:i') }}
    </div>
    <div style="font-size:10px;color:#94a3b8;">
        Realizado por: <strong style="color:#475569;">{{ $conteo->realizado_por ?? 'Sin asignar' }}</strong>
    </div>
</div>

</div>
@endsection