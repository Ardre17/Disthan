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
    --erp-ok:#1c7c4d;
    --erp-ok-bg:#e8f5ee;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    padding:0;min-height:100vh;font-size:13px;
}
.erp-bar{
    background:#1e3a5f;height:38px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}

/* Header */
.page-hdr{
    display:flex;justify-content:space-between;
    align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;
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
.btn-new:hover{background:var(--erp-accent-dark);color:#fff;}

/* KPIs */
.kpis{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:600px){.kpis{grid-template-columns:1fr;}}
.kpi{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;border-left:4px solid;
    position:relative;overflow:hidden;
}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:26px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:22px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Advertencias */
.warn-card{
    background:#fffbeb;border:1px solid #fde68a;
    border-left:4px solid #f59e0b;border-radius:4px;
    padding:1rem;margin-bottom:1rem;
}
.warn-title{
    display:flex;align-items:center;gap:7px;
    font-size:12px;font-weight:700;color:#b45309;
    text-transform:uppercase;letter-spacing:.06em;margin-bottom:.75rem;
}
.warn-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:8px;}
.warn-item{
    display:flex;align-items:flex-start;gap:8px;
    background:#fff;border:1px solid #fde68a;border-radius:3px;padding:8px 10px;
}
.warn-item-icon{font-size:16px;flex-shrink:0;margin-top:1px;}
.warn-item-text{font-size:11px;color:#7c4b00;line-height:1.55;}
.warn-item-text strong{color:#b45309;}

/* Filtro */
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

/* Result bar */
.result-bar{
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:.65rem;font-size:12px;color:var(--erp-ink-muted);flex-wrap:wrap;gap:6px;
}
.result-bar strong{color:var(--erp-ink);}

/* Client rows */
.client-row{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.85rem 1rem;margin-bottom:8px;
    display:flex;justify-content:space-between;align-items:center;gap:12px;
    transition:border-color .15s,box-shadow .15s;
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
    flex-shrink:0;
}
.client-info{flex:1;min-width:0;}
.client-name{font-size:13px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.client-ruc{font-size:11px;color:var(--erp-ink-muted);margin-top:1px;font-family:var(--font-mono);}
.client-meta{display:flex;gap:14px;margin-top:4px;flex-wrap:wrap;}
.meta-item{display:flex;align-items:center;gap:4px;font-size:11px;color:var(--erp-ink-muted);}
.meta-val{font-weight:600;color:#374151;}
.client-right{display:flex;gap:6px;align-items:center;flex-shrink:0;}
.btn-edit{
    background:#fff;color:var(--erp-warn);
    border:1px solid var(--erp-warn);
    padding:6px 12px;border-radius:3px;
    font-size:11px;font-weight:600;
    text-decoration:none;transition:background .15s;white-space:nowrap;
}
.btn-edit:hover{background:var(--erp-warn-bg);color:var(--erp-warn);}

/* Empty */
.empty-state{
    background:var(--erp-surface);border:1px dashed var(--erp-border);
    border-radius:4px;padding:3rem;text-align:center;color:var(--erp-ink-muted);
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
    <span style="font-size:11px;color:#5a8abf;">
        Ventas › Clientes
    </span>
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
@php
    $totalClientes = $clients->total();
@endphp
<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">👥</div>
        <div class="kpi-label">Total clientes</div>
        <div class="kpi-val">{{ $totalClientes }}</div>
        <div class="kpi-sub">registrados en sistema</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);">
        <div class="kpi-icon">📋</div>
        <div class="kpi-label">En esta página</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ $clients->count() }}</div>
        <div class="kpi-sub">mostrando ahora</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-warn);">
        <div class="kpi-icon">🔍</div>
        <div class="kpi-label">Búsqueda activa</div>
        <div class="kpi-val" style="font-size:14px;color:var(--erp-warn);">
            {{ request('search') ? '"'.request('search').'"' : '—' }}
        </div>
        <div class="kpi-sub">{{ request('search') ? 'filtro aplicado' : 'sin filtro' }}</div>
    </div>
</div>

{{-- ── Advertencias ── --}}
<div class="warn-card">
    <div class="warn-title">⚠️ Advertencias operativas</div>
    <div class="warn-grid">
        <div class="warn-item">
            <div class="warn-item-icon">✏️</div>
            <div class="warn-item-text">
                <strong>Datos críticos</strong><br>
                El RUC y la razón social deben coincidir exactamente con los documentos oficiales de la empresa. Un error puede afectar la facturación.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">🔗</div>
            <div class="warn-item-text">
                <strong>Clientes con órdenes</strong><br>
                Un cliente vinculado a órdenes activas no puede eliminarse directamente. Comunícate con el encargado si necesitas hacer cambios.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">📞</div>
            <div class="warn-item-text">
                <strong>Datos de contacto</strong><br>
                Mantén el teléfono y contacto actualizados. Son necesarios para coordinar entregas y resolver incidencias con los pedidos.
            </div>
        </div>
    </div>
</div>

{{-- ── Filtro ── --}}
<div class="filter-bar">
    🔍
    <form method="GET" style="display:flex;gap:8px;flex:1;flex-wrap:wrap;">
        <input
            type="text"
            name="search"
            class="finput"
            value="{{ request('search') }}"
            placeholder="Buscar por RUC o Razón Social...">
        <button type="submit" class="btn-search">Buscar</button>
        @if(request('search'))
            <a href="{{ request()->url() }}"
               style="font-size:11px;color:#94a3b8;text-decoration:none;display:flex;align-items:center;">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>

{{-- ── Result bar ── --}}
<div class="result-bar">
    <div>
        Mostrando <strong>{{ $clients->count() }}</strong>
        de <strong>{{ $totalClientes }}</strong> clientes
        @if(request('search'))
            — búsqueda: <em>"{{ request('search') }}"</em>
        @endif
    </div>
    <div style="font-size:11px;color:#94a3b8;">Ordenado por nombre</div>
</div>

{{-- ── Lista ── --}}
@forelse($clients as $client)
@php
    // Iniciales para avatar
    $partes    = explode(' ', trim($client->razon_social));
    $iniciales = strtoupper(
        substr($partes[0] ?? '?', 0, 1) .
        substr($partes[1] ?? '',  0, 1)
    );
@endphp

<div class="client-row">

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
            </div>
        </div>
    </div>

    <div class="client-right">
        <a href="{{ route('clients.edit', $client) }}" class="btn-edit">
            ✏️ Editar
        </a>
    </div>

</div>

@empty

<div class="empty-state">
    <div style="font-size:36px;margin-bottom:8px;">👥</div>
    <h3>No existen clientes registrados</h3>
    <p style="font-size:12px;margin:.5rem 0 1rem;">
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

{{-- Paginación --}}
@if($clients->hasPages())
<div style="margin-top:1rem;">
    {{ $clients->links() }}
</div>
@endif

</div>
</div>

@endsection