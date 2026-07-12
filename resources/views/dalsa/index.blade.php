@extends('layouts.app')
@section('content')

<style>
:root{
    --erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;
    --erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;
    --erp-danger:#c0312b;--erp-danger-bg:#fbe9e8;
    --erp-warn:#b9690e;--erp-warn-bg:#fdf1e2;
    --erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;
    --font-ui:'Segoe UI',sans-serif;--font-mono:'Consolas',monospace;
}
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
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.info-strip{background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid var(--erp-accent);border-radius:4px;padding:.75rem 1rem;margin-bottom:1rem;font-size:12px;color:#1e40af;display:flex;align-items:center;gap:8px;}
.filter-bar{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;font-family:var(--font-ui);transition:border-color .15s;}
.finput{flex:1;min-width:160px;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.btn-search{padding:7px 16px;background:var(--erp-ink);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;}
.catalog{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:10px;margin-bottom:1.25rem;}
.item-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .15s,transform .15s;border-top:3px solid;}
.item-card:hover{box-shadow:0 4px 14px rgba(20,30,45,.09);transform:translateY(-1px);}
.item-hdr{padding:.7rem .9rem .5rem;border-bottom:1px solid var(--erp-border);display:flex;justify-content:space-between;align-items:flex-start;gap:6px;}
.item-nombre{font-size:13px;font-weight:700;color:var(--erp-ink);line-height:1.3;}
.item-proveedor{font-size:10px;color:#94a3b8;margin-top:1px;}
.status-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:3px;white-space:nowrap;flex-shrink:0;}
.sb-ok  {background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.sb-warn{background:var(--erp-warn-bg);color:var(--erp-warn);border:1px solid #f9d5a3;}
.item-body{padding:.75rem .9rem;flex:1;}
.item-stock{font-size:28px;font-weight:900;font-family:var(--font-mono);line-height:1;}
.item-stock-sub{font-size:10px;color:var(--erp-ink-muted);margin-top:1px;margin-bottom:8px;}
.mini-bar{width:100%;height:4px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:8px;}
.mini-fill{height:100%;border-radius:99px;}
.meta-tags{display:flex;gap:4px;flex-wrap:wrap;}
.meta-tag{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:600;padding:2px 7px;border-radius:3px;}
.tag-origen{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
.tag-fecha{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.item-footer{padding:.6rem .9rem;background:#f9fafb;border-top:1px solid var(--erp-border);display:flex;gap:5px;}
.btn-sm{flex:1;text-align:center;padding:6px;border-radius:3px;font-size:11px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:background .15s;}
.btn-kardex{background:#fff;color:var(--erp-ok);border:1px solid var(--erp-ok);}
.btn-kardex:hover{background:var(--erp-ok-bg);}
.ht-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;}
.ht-hdr{padding:.85rem 1.1rem;border-bottom:1px solid var(--erp-border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;}
.ht table{width:100%;border-collapse:collapse;font-size:12px;}
.ht th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.ht td{padding:7px 10px;border-bottom:1px solid #f8fafc;vertical-align:middle;color:#374151;}
.ht tbody tr:hover td{background:#f8fafc;}
.tipo-e{background:var(--erp-ok-bg);color:var(--erp-ok);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;}
.tipo-s{background:var(--erp-danger-bg);color:var(--erp-danger);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;}
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
.empty-state{grid-column:1/-1;background:var(--erp-surface);border:1px dashed var(--erp-border);border-radius:4px;padding:3rem;text-align:center;color:var(--erp-ink-muted);}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Almacén Dalsa</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Logística › Dalsa</span>
</div>

<div class="body">

@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

<div class="page-hdr">
    <div>
        <div class="page-title">Almacén Dalsa</div>
        <div class="page-sub">Mercadería en tránsito · Solo ítems con stock activo</div>
    </div>
    <a href="{{ route('dalsa.create') }}" class="btn-new">
        📦 Registrar llegada
    </a>
</div>

<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Ítems en almacén</div>
        <div class="kpi-val">{{ $totalItems }}</div>
        <div class="kpi-sub">mercadería con stock</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);background:var(--erp-ok-bg);">
        <div class="kpi-icon">📫</div>
        <div class="kpi-label">Total cajas</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ number_format($totalCajas,0) }}</div>
        <div class="kpi-sub">cajas disponibles</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Stock bajo</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ $poco }}</div>
        <div class="kpi-sub">≤ 10 cajas</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">🗺️</div>
        <div class="kpi-label">Provincias activas</div>
        <div class="kpi-val" style="color:#7c3aed;">{{ $provincias->count() }}</div>
        <div class="kpi-sub">orígenes distintos</div>
    </div>
</div>

<div class="info-strip">
    ℹ️ Solo se muestran ítems con stock mayor a 0.
    Cuando una mercadería es despachada completamente desaparece de esta vista,
    pero su historial sigue disponible en el kardex individual.
</div>

<div class="filter-bar">
    🔍
    <input type="text" class="finput" id="filtQ"
           placeholder="Buscar por nombre, proveedor u origen..."
           oninput="filtrarCards(this.value)">
    <select class="fselect" id="filtOrigen" onchange="filtrarCards()">
        <option value="">Todas las provincias</option>
        @foreach($provincias as $p)
            <option value="{{ strtolower($p) }}">{{ $p }}</option>
        @endforeach
    </select>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.65rem;flex-wrap:wrap;gap:6px;">
    <span style="font-size:12px;color:var(--erp-ink-muted);">
        <strong id="countVisible" style="color:var(--erp-ink);">{{ $totalItems }}</strong>
        ítem(s) en almacén
    </span>
    <span style="font-size:11px;color:#94a3b8;">Ordenado por fecha de llegada</span>
</div>

<div class="catalog" id="catalogGrid">
@forelse($items as $item)
@php
    $est   = $item->estado;
    $topC  = $est === 'EN_ALMACEN' ? '#22c55e' : '#f59e0b';
    $stkC  = $est === 'EN_ALMACEN' ? 'var(--erp-ok)' : 'var(--erp-warn)';
    $sbCls = $est === 'EN_ALMACEN' ? 'sb-ok' : 'sb-warn';
    $sbLbl = $est === 'EN_ALMACEN' ? '✅ En almacén' : '⚠ Pocas cajas';
    $pct   = min(100, round($item->cantidad_actual / max($items->max('cantidad_actual'), 1) * 100));
@endphp
<div class="item-card"
     style="border-top-color:{{ $topC }};"
     data-q="{{ strtolower($item->nombre.' '.$item->proveedor.' '.$item->origen) }}"
     data-origen="{{ strtolower($item->origen) }}">
    <div class="item-hdr">
        <div>
            <div class="item-nombre">{{ $item->nombre }}</div>
            <div class="item-proveedor">{{ $item->proveedor }}</div>
        </div>
        <span class="status-badge {{ $sbCls }}">{{ $sbLbl }}</span>
    </div>
    <div class="item-body">
        <div class="item-stock" style="color:{{ $stkC }};">
            {{ number_format($item->cantidad_actual, 0) }}
        </div>
        <div class="item-stock-sub">cajas en almacén</div>
        <div class="mini-bar">
            <div class="mini-fill" style="width:{{ $pct }}%;background:{{ $topC }};"></div>
        </div>
        <div class="meta-tags">
            <span class="meta-tag tag-origen">🗺️ {{ $item->origen }}</span>
            <span class="meta-tag tag-fecha">
                📅 {{ \Carbon\Carbon::parse($item->fecha_llegada)->format('d M Y') }}
            </span>
        </div>
        @if($item->observaciones)
        <div style="font-size:11px;color:#94a3b8;margin-top:6px;font-style:italic;">
            "{{ $item->observaciones }}"
        </div>
        @endif
    </div>
    <div class="item-footer">
        <a href="{{ route('dalsa.show', $item) }}" class="btn-sm btn-kardex">
            📋 Kardex / Movimientos
        </a>
    </div>
</div>
@empty
<div class="empty-state">
    <div style="font-size:40px;margin-bottom:8px;">📭</div>
    <div style="font-size:14px;font-weight:600;color:var(--erp-ink);">
        No hay mercadería en almacén Dalsa
    </div>
    <div style="font-size:12px;margin:.5rem 0 1rem;">
        Toda la mercadería ha sido despachada o aún no ha llegado.
    </div>
    <a href="{{ route('dalsa.create') }}" class="btn-new">
        📦 Registrar llegada
    </a>
</div>
@endforelse
</div>

<div class="ht-card">
    <div class="ht-hdr">
        <div style="font-size:13px;font-weight:700;color:var(--erp-ink);">
            📋 Historial de movimientos
        </div>
        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <select class="fselect" onchange="filtrarHist(this.value,'tipo')">
                <option value="">Todos</option>
                <option value="ENTRADA">⬆ Entradas</option>
                <option value="SALIDA">⬇ Salidas</option>
            </select>
            <input class="finput" style="width:180px;"
                   placeholder="Buscar mercadería..."
                   oninput="filtrarHist(this.value,'nombre')">
        </div>
    </div>
    <div class="ht" style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Mercadería</th>
                    <th>Proveedor</th>
                    <th>Origen</th>
                    <th>Tipo</th>
                    <th>Cajas</th>
                    <th>Saldo</th>
                    <th>Motivo</th>
                    <th>Destino</th>
                </tr>
            </thead>
            <tbody id="histTbody">
            @forelse($movimientos as $mov)
            <tr data-tipo="{{ $mov->tipo }}"
                data-nombre="{{ strtolower($mov->item->nombre ?? '') }}">
                <td style="color:#94a3b8;white-space:nowrap;font-size:11px;">
                    {{ \Carbon\Carbon::parse($mov->created_at)->format('d M Y H:i') }}
                </td>
                <td style="font-weight:600;color:var(--erp-ink);">
                    {{ $mov->item->nombre ?? '—' }}
                </td>
                <td style="color:#64748b;font-size:11px;">
                    {{ $mov->item->proveedor ?? '—' }}
                </td>
                <td>
                    <span class="meta-tag tag-origen" style="font-size:10px;">
                        🗺️ {{ $mov->item->origen ?? '—' }}
                    </span>
                </td>
                <td>
                    <span class="{{ $mov->tipo === 'ENTRADA' ? 'tipo-e' : 'tipo-s' }}">
                        {{ $mov->tipo === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}
                    </span>
                </td>
                <td style="font-weight:700;font-family:var(--font-mono);
                    color:{{ $mov->tipo === 'ENTRADA' ? 'var(--erp-ok)' : 'var(--erp-danger)' }};">
                    {{ $mov->tipo === 'ENTRADA' ? '+' : '−' }}{{ number_format($mov->cantidad,0) }}
                </td>
                <td style="font-family:var(--font-mono);color:var(--erp-ink-muted);">
                    {{ number_format($mov->saldo_post,0) }}
                </td>
                <td style="color:#475569;">{{ $mov->motivo ?? '—' }}</td>
                <td style="color:#94a3b8;font-size:11px;">{{ $mov->destino ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;color:#94a3b8;padding:2rem;">
                    Sin movimientos registrados
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
</div>

<script>
var hFiltTipo='', hFiltNombre='';

function filtrarCards(q) {
    var texto  = typeof q === 'string' ? q.toLowerCase() : document.getElementById('filtQ').value.toLowerCase();
    var origen = document.getElementById('filtOrigen').value.toLowerCase();
    var cards  = document.querySelectorAll('#catalogGrid .item-card');
    var visible = 0;
    cards.forEach(function(c){
        var mQ = !texto  || c.dataset.q.includes(texto);
        var mO = !origen || c.dataset.origen === origen;
        c.style.display = (mQ && mO) ? '' : 'none';
        if (mQ && mO) visible++;
    });
    var cnt = document.getElementById('countVisible');
    if(cnt) cnt.textContent = visible;
}

function filtrarHist(val, campo) {
    if(campo === 'tipo')   hFiltTipo   = val;
    if(campo === 'nombre') hFiltNombre = val.toLowerCase();
    document.querySelectorAll('#histTbody tr[data-tipo]').forEach(function(tr){
        var mT = !hFiltTipo   || tr.dataset.tipo   === hFiltTipo;
        var mN = !hFiltNombre || tr.dataset.nombre.includes(hFiltNombre);
        tr.style.display = (mT && mN) ? '' : 'none';
    });
}
</script>

@endsection