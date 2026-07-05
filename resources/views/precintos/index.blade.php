@extends('layouts.app')
@section('content')
<style>
/* Mismas variables ERP */
:root{--erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;--erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;--erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;--erp-danger:#c0312b;--erp-danger-bg:#fbe9e8;--erp-warn:#b9690e;--erp-warn-bg:#fdf1e2;--erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;--font-ui:'Segoe UI',sans-serif;--font-mono:'Consolas',monospace;}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.btn-new{background:var(--erp-accent);color:#fff;padding:8px 16px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s;}
.btn-new:hover{background:var(--erp-accent-dark);color:#fff;}
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:800px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.filter-bar{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;font-family:var(--font-ui);transition:border-color .15s;}
.finput{flex:1;min-width:160px;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);}
.btn-search{padding:7px 16px;background:var(--erp-ink);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;}
.catalog{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;margin-bottom:1.25rem;}
.prc-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .15s;border-top:3px solid;}
.prc-card:hover{box-shadow:0 2px 10px rgba(20,30,45,.08);}
.prc-hdr{padding:.7rem .9rem .5rem;border-bottom:1px solid var(--erp-border);display:flex;justify-content:space-between;align-items:flex-start;gap:6px;}
.prc-name{font-size:13px;font-weight:700;color:var(--erp-ink);}
.status-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:3px;white-space:nowrap;flex-shrink:0;}
.sb-ok  {background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.sb-warn{background:var(--erp-warn-bg);color:var(--erp-warn);border:1px solid #f9d5a3;}
.sb-low {background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}
.prc-body{padding:.7rem .9rem;flex:1;}
.prc-stock{font-size:24px;font-weight:800;line-height:1;font-family:var(--font-mono);}
.prc-sub{font-size:10px;color:var(--erp-ink-muted);margin-top:1px;margin-bottom:8px;}
.mini-bar{width:100%;height:4px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:8px;}
.mini-fill{height:100%;border-radius:99px;}
/* Dot de color precinto */
.color-dot{width:14px;height:14px;border-radius:50%;display:inline-block;border:2px solid rgba(0,0,0,.1);}
.color-tag{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;padding:3px 9px;border-radius:3px;background:#f1f5f9;color:#1c2733;}
.prc-footer{padding:.6rem .9rem;background:#f9fafb;border-top:1px solid var(--erp-border);display:flex;gap:5px;}
.btn-sm{flex:1;text-align:center;padding:6px;border-radius:3px;font-size:11px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:background .15s;}
.btn-edit-s{background:#fff;color:var(--erp-warn);border:1px solid var(--erp-warn);}
.btn-edit-s:hover{background:var(--erp-warn-bg);}
.btn-view-s{background:#fff;color:var(--erp-ok);border:1px solid var(--erp-ok);}
.btn-view-s:hover{background:var(--erp-ok-bg);}
.ht-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;}
.ht-hdr{padding:.85rem 1.1rem;border-bottom:1px solid var(--erp-border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;}
.ht table{width:100%;border-collapse:collapse;font-size:12px;}
.ht th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.ht td{padding:7px 10px;border-bottom:1px solid #f8fafc;vertical-align:middle;}
.ht tbody tr:hover td{background:#f8fafc;}
.tipo-e{background:var(--erp-ok-bg);color:var(--erp-ok);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;}
.tipo-s{background:var(--erp-danger-bg);color:var(--erp-danger);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;}
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Precintos</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Inventario › Precintos</span>
</div>

<div class="body">

@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

<div class="page-hdr">
    <div>
        <div class="page-title">Control de precintos</div>
        <div class="page-sub">Gestión de stock por color · Verde / Blanco / Negro</div>
    </div>
    <a href="{{ route('precintos.create') }}" class="btn-new">➕ Nuevo precinto</a>
</div>

<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">🔒</div>
        <div class="kpi-label">Total</div>
        <div class="kpi-val">{{ $total }}</div>
        <div class="kpi-sub">precintos activos</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);background:var(--erp-ok-bg);">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Disponibles</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ $disponibles }}</div>
        <div class="kpi-sub">stock OK</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Stock bajo</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ $stockBajo }}</div>
        <div class="kpi-sub">reponer pronto</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-danger);">
        <div class="kpi-icon">🔴</div>
        <div class="kpi-label">Agotados</div>
        <div class="kpi-val" style="color:var(--erp-danger);">{{ $agotados }}</div>
        <div class="kpi-sub">sin stock</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Stock total</div>
        <div class="kpi-val" style="font-size:16px;color:#7c3aed;">{{ number_format($totalStock,0) }}</div>
        <div class="kpi-sub">unidades</div>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" style="display:flex;gap:8px;flex:1;flex-wrap:wrap;">
        🔍
        <input type="text" name="search" class="finput"
               value="{{ request('search') }}" placeholder="Buscar precinto...">
        <select name="color" class="fselect" onchange="this.form.submit()">
            <option value="">Todos los colores</option>
            <option value="VERDE"  @selected(request('color')==='VERDE')>🟢 Verde</option>
            <option value="BLANCO" @selected(request('color')==='BLANCO')>⚪ Blanco</option>
            <option value="NEGRO"  @selected(request('color')==='NEGRO')>⚫ Negro</option>
        </select>
        <select name="estado" class="fselect" onchange="this.form.submit()">
            <option value="">Todos los estados</option>
            <option value="DISPONIBLE" @selected(request('estado')==='DISPONIBLE')>✅ Disponible</option>
            <option value="STOCK_BAJO" @selected(request('estado')==='STOCK_BAJO')>⚠️ Stock bajo</option>
            <option value="AGOTADO"    @selected(request('estado')==='AGOTADO')>🔴 Agotado</option>
        </select>
        <button type="submit" class="btn-search">Buscar</button>
        @if(request()->hasAny(['search','color','estado']))
            <a href="{{ route('precintos.index') }}" style="font-size:11px;color:#94a3b8;text-decoration:none;display:flex;align-items:center;">✕ Limpiar</a>
        @endif
    </form>
</div>

<div class="catalog">
@forelse($precintos as $prc)
@php
    $est   = $prc->estado;
    $topC  = match($est){ 'DISPONIBLE'=>'#22c55e','STOCK_BAJO'=>'#f59e0b',default=>'#ef4444' };
    $stkC  = match($est){ 'DISPONIBLE'=>'var(--erp-ok)','STOCK_BAJO'=>'var(--erp-warn)',default=>'var(--erp-danger)' };
    $sbCls = match($est){ 'DISPONIBLE'=>'sb-ok','STOCK_BAJO'=>'sb-warn',default=>'sb-low' };
    $sbLbl = match($est){ 'DISPONIBLE'=>'✅ OK','STOCK_BAJO'=>'⚠ Bajo',default=>'🔴 Agotado' };
    $pct   = $prc->stock_minimo > 0 ? min(100, round($prc->stock_actual / ($prc->stock_minimo * 3) * 100)) : 100;
    $colorDot = match($prc->color){ 'VERDE'=>'#22c55e','BLANCO'=>'#e2e8f0','NEGRO'=>'#1e293b',default=>'#94a3b8' };
    $colorLbl = match($prc->color){ 'VERDE'=>'🟢 Verde','BLANCO'=>'⚪ Blanco','NEGRO'=>'⚫ Negro',default=>$prc->color };
@endphp
<div class="prc-card" style="border-top-color:{{ $topC }};">
    <div class="prc-hdr">
        <div class="prc-name">{{ $prc->nombre }}</div>
        <span class="status-badge {{ $sbCls }}">{{ $sbLbl }}</span>
    </div>
    <div class="prc-body">
        <div class="prc-stock" style="color:{{ $stkC }};">{{ number_format($prc->stock_actual,0) }}</div>
        <div class="prc-sub">unidades disponibles</div>
        <div class="mini-bar"><div class="mini-fill" style="width:{{ $pct }}%;background:{{ $topC }};"></div></div>
        <span class="color-tag">
            <span class="color-dot" style="background:{{ $colorDot }};"></span>
            {{ $colorLbl }}
        </span>
    </div>
    <div class="prc-footer">
        <a href="{{ route('precintos.edit', $prc) }}" class="btn-sm btn-edit-s">✏️ Editar</a>
        <a href="{{ route('precintos.show', $prc) }}" class="btn-sm btn-view-s">📋 Kardex</a>
    </div>
</div>
@empty
<div style="grid-column:1/-1;background:var(--erp-surface);border:1px dashed var(--erp-border);border-radius:4px;padding:3rem;text-align:center;color:var(--erp-ink-muted);">
    <div style="font-size:32px;margin-bottom:8px;">🔒</div>
    <div style="font-size:14px;font-weight:600;color:var(--erp-ink);">No hay precintos registrados</div>
    <div style="margin:.5rem 0 1rem;font-size:12px;">Crea tu primer precinto.</div>
    <a href="{{ route('precintos.create') }}" class="btn-new">➕ Nuevo precinto</a>
</div>
@endforelse
</div>

<div class="ht-card">
    <div class="ht-hdr">
        <div style="font-size:13px;font-weight:700;color:var(--erp-ink);">📋 Últimos 50 movimientos</div>
        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <select class="fselect" onchange="filtrarHist(this.value,'tipo')">
                <option value="">Todos</option>
                <option value="ENTRADA">⬆ Entradas</option>
                <option value="SALIDA">⬇ Salidas</option>
            </select>
            <input class="finput" style="width:170px;" placeholder="Buscar precinto..."
                   oninput="filtrarHist(this.value,'nombre')">
        </div>
    </div>
    <div class="ht" style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th><th>Precinto</th><th>Color</th>
                    <th>Tipo</th><th>Cantidad</th><th>Saldo</th>
                    <th>Motivo</th><th>Referencia</th>
                </tr>
            </thead>
            <tbody id="histTbody">
            @forelse($movimientos as $mov)
            @php
                $cDot = match($mov->precinto->color ?? ''){ 'VERDE'=>'#22c55e','BLANCO'=>'#e2e8f0','NEGRO'=>'#1e293b',default=>'#94a3b8' };
                $cLbl = match($mov->precinto->color ?? ''){ 'VERDE'=>'Verde','BLANCO'=>'Blanco','NEGRO'=>'Negro',default=>'—' };
            @endphp
            <tr data-tipo="{{ $mov->tipo }}" data-nombre="{{ strtolower($mov->precinto->nombre ?? '') }}">
                <td style="color:#94a3b8;white-space:nowrap;font-size:11px;">{{ \Carbon\Carbon::parse($mov->created_at)->format('d M Y H:i') }}</td>
                <td style="font-weight:600;">{{ $mov->precinto->nombre ?? '—' }}</td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;">
                        <span style="width:10px;height:10px;border-radius:50%;background:{{ $cDot }};display:inline-block;border:1px solid rgba(0,0,0,.1);"></span>
                        {{ $cLbl }}
                    </span>
                </td>
                <td><span class="{{ $mov->tipo === 'ENTRADA' ? 'tipo-e' : 'tipo-s' }}">{{ $mov->tipo === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}</span></td>
                <td style="font-weight:700;font-family:var(--font-mono);color:{{ $mov->tipo === 'ENTRADA' ? 'var(--erp-ok)' : 'var(--erp-danger)' }};">{{ $mov->tipo === 'ENTRADA' ? '+' : '−' }}{{ number_format($mov->cantidad,0) }}</td>
                <td style="font-family:var(--font-mono);color:var(--erp-ink-muted);">{{ number_format($mov->saldo_post,0) }}</td>
                <td style="color:#475569;">{{ $mov->motivo ?? '—' }}</td>
                <td style="color:#94a3b8;font-size:11px;">{{ $mov->referencia ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:2rem;">Sin movimientos</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
</div>

<script>
var hFiltTipo='', hFiltNombre='';
function filtrarHist(val,campo){
    if(campo==='tipo')   hFiltTipo=val;
    if(campo==='nombre') hFiltNombre=val.toLowerCase();
    document.querySelectorAll('#histTbody tr[data-tipo]').forEach(function(tr){
        var mT=!hFiltTipo   || tr.dataset.tipo===hFiltTipo;
        var mN=!hFiltNombre || tr.dataset.nombre.includes(hFiltNombre);
        tr.style.display=(mT&&mN)?'':'none';
    });
}
</script>
@endsection