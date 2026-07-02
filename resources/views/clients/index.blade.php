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
    --erp-warn:#b9690e;
    --erp-warn-bg:#fdf1e2;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
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
.erp-bar{
    background:#1e3a5f;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 1.25rem;
    margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.erp-user{color:#7eb8f7;font-size:11px;background:#152d4d;padding:3px 10px;border-radius:3px;}
.body{padding:1.1rem;}
.page-hdr{
    display:flex;justify-content:space-between;align-items:flex-start;
    margin-bottom:1rem;flex-wrap:wrap;gap:8px;
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
.btn-new{
    background:var(--erp-accent);color:#fff;
    padding:8px 16px;border-radius:3px;
    font-size:12px;font-weight:600;
    text-decoration:none;display:inline-flex;
    align-items:center;gap:5px;
    transition:background .15s;
}
.btn-new:hover{background:var(--erp-accent-dark);}

/* KPIs */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;border-left:4px solid;
    position:relative;overflow:hidden;
}
.kpi-icon{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    font-size:24px;opacity:.1;
}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Filtros */
.filter-bar{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;
    margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;
}
.finput{
    padding:7px 10px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;flex:1;min-width:200px;
    font-family:var(--font-ui);transition:border-color .15s;
}
.finput:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.btn-search{
    padding:7px 16px;background:var(--erp-ink);color:#fff;
    border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;
}
.btn-search:hover{background:#000;}
.result-bar{
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:.65rem;flex-wrap:wrap;gap:6px;
}
.result-count{font-size:12px;color:var(--erp-ink-muted);}
.result-count strong{color:var(--erp-ink);}

/* Filas cliente */
.client-row{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:.85rem 1rem;
    margin-bottom:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    transition:border-color .15s, box-shadow .15s;
}
.client-row:hover{
    border-color:#c2cbd8;
    box-shadow:0 2px 8px rgba(20,30,45,.07);
}
.client-left{display:flex;align-items:center;gap:12px;flex:1;min-width:0;}
.avatar{
    width:40px;height:40px;border-radius:50%;
    background:#eaf0f9;border:1px solid #d7e4f6;
    display:flex;align-items:center;justify-content:center;
    font-size:13px;font-weight:700;color:var(--erp-accent-dark);
    flex-shrink:0;font-family:var(--font-ui);
}
.client-info{flex:1;min-width:0;}
.client-name{font-size:13px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.client-ruc{font-size:11px;color:var(--erp-ink-muted);margin-top:1px;font-family:var(--font-mono);}
.client-meta{display:flex;gap:14px;margin-top:4px;flex-wrap:wrap;}
.meta-item{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--erp-ink-muted);}
.meta-val{font-weight:600;color:#374151;}
.client-right{display:flex;gap:6px;align-items:center;flex-shrink:0;}
.orders-badge{
    background:#eaf0f9;color:var(--erp-accent-dark);
    border:1px solid #d7e4f6;
    font-size:10px;font-weight:700;
    padding:3px 8px;border-radius:3px;white-space:nowrap;
}
.btn-edit{
    background:#fff;color:var(--erp-warn);
    border:1px solid var(--erp-warn);
    padding:6px 12px;border-radius:3px;
    font-size:11px;font-weight:600;
    text-decoration:none;transition:background .15s;white-space:nowrap;
}
.btn-edit:hover{background:var(--erp-warn-bg);}

/* Empty */
.empty-state{
    background:var(--erp-surface);
    border:1px dashed var(--erp-border);
    border-radius:4px;
    padding:3rem;text-align:center;
    color:var(--erp-ink-muted);
}
.empty-state h3{color:var(--erp-ink);font-size:15px;margin-bottom:6px;}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Clientes</div>
    </div>
    <div class="erp-user">👤 {{ auth()->user()->name ?? 'Administrador' }}</div>
</div>

<div class="body">

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Gestión de clientes</div>
        <div class="page-sub">Directorio de clientes registrados en el sistema</div>
    </div>
    <a href="{{ route('clients.create') }}" class="btn-new">
        ➕ Nuevo cliente
    </a>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#0b5ed7;">
        <div class="kpi-icon">👥</div>
        <div class="kpi-label">Total clientes</div>
        <div class="kpi-sub">registrados en el sistema</div>
    </div>
    <div class="kpi" style="border-left-color:#15803d;">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Activos este mes</div>
        <div class="kpi-sub">con órdenes en {{ now()->format('M Y') }}</div>
    </div>
    <div class="kpi" style="border-left-color:#b45309;">
        <div class="kpi-icon">📋</div>
        <div class="kpi-label">Órdenes activas</div>
        <div class="kpi-val" style="color:#b45309;">{{ $ordenesActivas }}</div>
        <div class="kpi-sub">incompletas o parciales</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">💰</div>
        <div class="kpi-label">Facturado total</div>
        <div class="kpi-val" style="font-size:15px;color:#7c3aed;">S/ {{ number_format($facturado,0) }}</div>
        <div class="kpi-sub">órdenes completadas</div>
    </div>
</div>

{{-- ── Filtro ── --}}
<div class="filter-bar">
    <form method="GET" style="display:flex;gap:8px;align-items:center;flex:1;flex-wrap:wrap;">
        🔍
        <input
            type="text"
            name="search"
            class="finput"
            value="{{ request('search') }}"
            placeholder="Buscar por RUC o razón social..."
            id="searchInput"
            oninput="filtrarLocal(this.value)">
        <button type="submit" class="btn-search">Buscar</button>
        @if(request('search'))
            <a href="{{ request()->url() }}"
               style="font-size:11px;color:#94a3b8;text-decoration:none;">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>




{{-- ── Lista ── --}}
<div id="clienteLista">

@forelse($clients as $client)
@php
    // Iniciales para avatar
    $palabras = explode(' ', $client->razon_social);
    $iniciales = strtoupper(substr($palabras[0] ?? '?', 0, 1) . substr($palabras[1] ?? '', 0, 1));

    // Órdenes del cliente
    $nOrdenes = $client->orders()->count();
@endphp

<div class="client-row"
     data-q="{{ strtolower($client->razon_social . ' ' . $client->ruc) }}">

    <div class="client-left">
        <div class="avatar">{{ $iniciales }}</div>
        <div class="client-info">
            <div class="client-name">{{ $client->razon_social }}</div>
            <div class="client-ruc">RUC: {{ $client->ruc }}</div>
            <div class="client-meta">
                @if($client->contacto)
                <div class="meta-item">
                    👤 <span class="meta-val">{{ $client->contacto }}</span>
                </div>
                @endif
                @if($client->telefono)
                <div class="meta-item">
                    📞 <span class="meta-val">{{ $client->telefono }}</span>
                </div>
                @endif
                @if($client->email)
                <div class="meta-item">
                    ✉️ <span class="meta-val">{{ $client->email }}</span>
                </div>
                @endif
                @if($client->direccion)
                <div class="meta-item">
                    📍 <span class="meta-val">{{ Str::limit($client->direccion, 40) }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="client-right">
        @if($nOrdenes > 0)
        <span class="orders-badge">{{ $nOrdenes }} orden(es)</span>
        @endif
        <a href="{{ route('clients.edit', $client) }}" class="btn-edit">
            ✏️ Editar
        </a>
    </div>

</div>

@empty

<div class="empty-state">
    <div style="font-size:36px;margin-bottom:8px;">👥</div>
    <h3>No hay clientes registrados</h3>
    <p style="font-size:12px;margin-bottom:1rem;">
        @if(request('search'))
            No se encontraron resultados para <strong>"{{ request('search') }}"</strong>.
        @else
            Comienza registrando tu primer cliente.
        @endif
    </p>
    <a href="{{ route('clients.create') }}" class="btn-new" style="display:inline-flex;">
        ➕ Registrar cliente
    </a>
</div>

@endforelse

</div>

{{-- Paginación --}}
@if($clients->hasPages())
<div style="margin-top:1rem;">
    {{ $clients->links() }}
</div>
@endif

</div>
</div>

<script>
function filtrarLocal(q) {
    var rows    = document.querySelectorAll('#clienteLista .client-row');
    var visible = 0;
    rows.forEach(function(r){
        var show = r.dataset.q.includes(q.toLowerCase());
        r.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    var cnt = document.getElementById('countVisible');
    if (cnt) cnt.textContent = visible;
}
</script>

@endsection