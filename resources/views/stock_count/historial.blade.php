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
    --erp-accent-dark:#0a4eb3;
    --erp-ok:#1c7c4d;
    --erp-ok-bg:#e8f5ee;
    --erp-warn:#b9690e;
    --erp-warn-bg:#fdf1e2;
    --erp-danger:#c0312b;
    --erp-danger-bg:#fbe9e8;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    padding:0;
    min-height:100vh;
    font-size:13px;
}

/* ── Top bar ── */
.erp-bar{
    background:#1e3a5f;
    height:38px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;
    margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}

/* ── Page header ── */
.page-hdr{
    display:flex;justify-content:space-between;
    align-items:flex-start;margin-bottom:1rem;
    flex-wrap:wrap;gap:8px;
}
.page-title{
    font-size:17px;font-weight:700;color:#0f172a;
    display:flex;align-items:center;gap:8px;
}
.page-title:before{
    content:"";width:4px;height:20px;
    background:var(--erp-accent);border-radius:2px;display:inline-block;
}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}

/* Botón nuevo conteo */
.btn-new{
    background:var(--erp-ok);color:#fff;
    padding:8px 16px;border-radius:3px;
    font-size:12px;font-weight:600;
    border:none;cursor:pointer;
    display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
    font-family:var(--font-ui);
}
.btn-new:hover{background:#166534;}

/* ── KPIs ── */
.kpis{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:8px;margin-bottom:1rem;
}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:.75rem 1rem;
    border-left:4px solid;
    position:relative;overflow:hidden;
}
.kpi-icon{
    position:absolute;right:10px;top:50%;
    transform:translateY(-50%);
    font-size:26px;opacity:.1;
}
.kpi-label{
    font-size:10px;color:var(--erp-ink-muted);
    text-transform:uppercase;letter-spacing:.06em;
    font-weight:600;margin-bottom:3px;
}
.kpi-val{
    font-size:22px;font-weight:800;
    color:var(--erp-ink);line-height:1;
    font-family:var(--font-mono);
}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* ── Filtro bar ── */
.filter-bar{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:.75rem 1rem;
    margin-bottom:1rem;
    display:flex;gap:8px;align-items:center;flex-wrap:wrap;
}
.finput,.fselect{
    padding:7px 9px;
    border:1px solid var(--erp-border);
    border-radius:3px;
    font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;
    font-family:var(--font-ui);
    transition:border-color .15s;
}
.finput{flex:1;min-width:180px;}
.finput:focus,.fselect:focus{
    border-color:var(--erp-accent);
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}
.btn-search{
    padding:7px 16px;background:var(--erp-ink);color:#fff;
    border:none;border-radius:3px;
    font-size:12px;font-weight:600;cursor:pointer;
    font-family:var(--font-ui);
}
.btn-search:hover{background:#000;}

/* ── Tabla ── */
.table-wrap{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    overflow:hidden;
}
.result-bar{
    display:flex;justify-content:space-between;align-items:center;
    padding:.65rem 1rem;
    border-bottom:1px solid var(--erp-border);
    font-size:12px;color:var(--erp-ink-muted);
    flex-wrap:wrap;gap:6px;
}
.result-bar strong{color:var(--erp-ink);}

table{width:100%;border-collapse:collapse;font-size:12.5px;}
thead th{
    background:#f4f6f9;
    color:var(--erp-ink-muted);
    font-size:10.5px;font-weight:700;
    text-transform:uppercase;letter-spacing:.05em;
    padding:9px 12px;
    border-bottom:2px solid var(--erp-border);
    text-align:left;white-space:nowrap;
}
tbody tr{border-bottom:1px solid #f0f3f7;transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f7f9fc;}
tbody td{padding:9px 12px;vertical-align:middle;}

/* ── Celdas especiales ── */
.td-code{
    font-family:var(--font-mono);
    font-size:12px;font-weight:700;
    color:var(--erp-accent);
    letter-spacing:.3px;
}
.td-date{font-size:12px;color:var(--erp-ink-muted);}
.td-resp{font-size:12px;color:var(--erp-ink);}
.td-num{
    font-family:var(--font-mono);
    font-size:13px;font-weight:700;
    text-align:center;
}

/* ── Badges de estado ── */
.badge{
    display:inline-flex;align-items:center;gap:4px;
    padding:3px 9px;border-radius:3px;
    font-size:10.5px;font-weight:700;white-space:nowrap;
}
.badge-ok{
    background:var(--erp-ok-bg);color:var(--erp-ok);
    border:1px solid #b7dfca;
}
.badge-warn{
    background:var(--erp-warn-bg);color:var(--erp-warn);
    border:1px solid #f9d5a3;
}

/* ── Botones acción ── */
.btn-continuar{
    display:inline-flex;align-items:center;gap:4px;
    padding:5px 10px;border-radius:3px;
    font-size:11px;font-weight:700;
    text-decoration:none;white-space:nowrap;
    background:var(--erp-warn-bg);
    color:var(--erp-warn);
    border:1px solid var(--erp-warn);
    transition:background .15s;
}
.btn-continuar:hover{background:#fef3c7;}
.btn-ver{
    display:inline-flex;align-items:center;gap:4px;
    padding:5px 10px;border-radius:3px;
    font-size:11px;font-weight:700;
    text-decoration:none;white-space:nowrap;
    background:var(--erp-ok-bg);
    color:var(--erp-ok);
    border:1px solid #b7dfca;
    transition:background .15s;
}
.btn-ver:hover{background:#d1fae5;}

/* ── Empty state ── */
.empty-row td{
    padding:3rem;text-align:center;
    color:var(--erp-ink-muted);font-style:italic;
}

/* ── Info strip ── */
.info-strip{
    background:#eff6ff;border:1px solid #bfdbfe;
    border-left:4px solid var(--erp-accent);
    border-radius:4px;padding:.65rem 1rem;
    margin-bottom:1rem;
    font-size:11.5px;color:#1e40af;
    display:flex;align-items:center;gap:8px;
}

/* ── Paginación ── */
.pagination-wrap{
    margin-top:.85rem;
    display:flex;justify-content:flex-end;
}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Conteo Físico de Inventario</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Inventario › Conteo físico</span>
</div>

<div class="body">

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Conteo físico de inventario</div>
        <div class="page-sub">
            Historial de sesiones de conteo y diferencias detectadas
        </div>
    </div>
    <form method="POST" action="{{ route('stockcount.nuevo') }}">
        @csrf
        <button type="submit" class="btn-new">
            ＋ Nuevo conteo
        </button>
    </form>
</div>

{{-- ── KPIs ── --}}
@php
    $total      = $conteos->total();
    $enProceso  = $conteos->getCollection()->where('estado','EN_PROCESO')->count();
    $finalizados= $conteos->getCollection()->where('estado','FINALIZADO')->count();
    $totalProds = $conteos->getCollection()->sum('detalles_count');
@endphp

<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">📋</div>
        <div class="kpi-label">Total conteos</div>
        <div class="kpi-val">{{ $total }}</div>
        <div class="kpi-sub">registrados en sistema</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-warn);">
        <div class="kpi-icon">⏳</div>
        <div class="kpi-label">En proceso</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ $enProceso }}</div>
        <div class="kpi-sub">esta página</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);background:var(--erp-ok-bg);">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Finalizados</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ $finalizados }}</div>
        <div class="kpi-sub">esta página</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Productos contados</div>
        <div class="kpi-val" style="color:#7c3aed;">{{ number_format($totalProds) }}</div>
        <div class="kpi-sub">ítems esta página</div>
    </div>
</div>

{{-- ── Info strip ── --}}
<div class="info-strip">
    ℹ️ Los conteos <strong>En proceso</strong> pueden continuarse en cualquier momento.
    Una vez <strong>Finalizado</strong>, el conteo queda bloqueado y solo puede consultarse.
    Las diferencias detectadas se muestran en el reporte individual.
</div>

{{-- ── Filtro ── --}}
<div class="filter-bar">
    🔍
    <input
        type="text"
        class="finput"
        id="filtroTexto"
        placeholder="Buscar por código o responsable..."
        oninput="filtrarTabla(this.value)">
    <select class="fselect" id="filtroEstado" onchange="filtrarTabla()">
        <option value="">Todos los estados</option>
        <option value="en_proceso">⏳ En proceso</option>
        <option value="finalizado">✅ Finalizado</option>
    </select>
</div>

{{-- ── Tabla ── --}}
<div class="table-wrap">
    <div class="result-bar">
        <span>
            Mostrando
            <strong id="countVisible">{{ $conteos->count() }}</strong>
            de <strong>{{ $total }}</strong> conteos
        </span>
        <span style="font-size:11px;color:#94a3b8;">
            Ordenado por fecha descendente
        </span>
    </div>

    <div style="overflow-x:auto;">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th style="text-align:center;">Estado</th>
                <th style="text-align:center;">Productos</th>
                <th style="text-align:right;">Acción</th>
            </tr>
        </thead>
        <tbody id="tablaBody">

        @forelse($conteos as $conteo)
        <tr data-q="{{ strtolower($conteo->codigo . ' ' . ($conteo->realizado_por ?? '')) }}"
            data-estado="{{ strtolower(str_replace('_','',$conteo->estado)) }}">

            <td>
                <div class="td-code">{{ $conteo->codigo }}</div>
            </td>

            <td>
                <div class="td-date">
                    {{ \Carbon\Carbon::parse($conteo->fecha)->format('d M Y') }}
                </div>
                <div style="font-size:10px;color:#94a3b8;margin-top:1px;">
                    {{ \Carbon\Carbon::parse($conteo->fecha)->diffForHumans() }}
                </div>
            </td>

            <td>
                <div style="display:flex;align-items:center;gap:7px;">
                    <div style="
                        width:26px;height:26px;border-radius:50%;
                        background:#eaf0f9;border:1px solid #d7e4f6;
                        display:flex;align-items:center;justify-content:center;
                        font-size:11px;font-weight:700;color:#0a4eb3;
                        flex-shrink:0;
                    ">
                        {{ strtoupper(substr($conteo->realizado_por ?? '?', 0, 1)) }}
                    </div>
                    <span class="td-resp">{{ $conteo->realizado_por ?? '—' }}</span>
                </div>
            </td>

            <td style="text-align:center;">
                @if($conteo->estado === 'FINALIZADO')
                    <span class="badge badge-ok">✅ Finalizado</span>
                @else
                    <span class="badge badge-warn">⏳ En proceso</span>
                @endif
            </td>

            <td>
                <div class="td-num" style="
                    color:{{ $conteo->detalles_count > 0 ? 'var(--erp-ink)' : '#94a3b8' }};
                ">
                    {{ number_format($conteo->detalles_count) }}
                </div>
            </td>

            <td style="text-align:right;">
                @if($conteo->estado === 'EN_PROCESO')
                    <a href="{{ route('stockcount.captura', $conteo->id) }}"
                       class="btn-continuar">
                        ▶ Continuar
                    </a>
                @else
                    <a href="{{ route('stockcount.show', $conteo->id) }}"
                       class="btn-ver">
                        📊 Ver diferencias
                    </a>
                @endif
            </td>

        </tr>
        @empty
        <tr class="empty-row">
            <td colspan="6">
                <div style="font-size:32px;margin-bottom:8px;">📋</div>
                <div style="font-size:14px;font-weight:600;color:var(--erp-ink);margin-bottom:4px;">
                    Aún no hay conteos registrados
                </div>
                <div style="font-size:12px;">
                    Inicia un nuevo conteo físico para comenzar el registro.
                </div>
            </td>
        </tr>
        @endforelse

        </tbody>
    </table>
    </div>
</div>

{{-- Paginación --}}
@if($conteos->hasPages())
<div class="pagination-wrap">
    {{ $conteos->links() }}
</div>
@endif

</div>
</div>

<script>
function filtrarTabla(q) {
    var texto  = typeof q === 'string'
        ? q.toLowerCase()
        : document.getElementById('filtroTexto').value.toLowerCase();
    var estado = document.getElementById('filtroEstado').value.toLowerCase();
    var rows   = document.querySelectorAll('#tablaBody tr[data-q]');
    var visible = 0;

    rows.forEach(function(tr) {
        var mQ = !texto  || tr.dataset.q.includes(texto);
        var mE = !estado || tr.dataset.estado === estado;
        var show = mQ && mE;
        tr.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    var cnt = document.getElementById('countVisible');
    if (cnt) cnt.textContent = visible;
}
</script>

@endsection