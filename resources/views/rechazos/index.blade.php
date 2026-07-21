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
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-danger);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.btn-new{background:var(--erp-danger);color:#fff;padding:8px 16px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s;}
.btn-new:hover{background:#9b1e1a;color:#fff;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;color:var(--erp-ink);line-height:1;font-family:var(--font-mono);}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.filter-bar{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;font-family:var(--font-ui);transition:border-color .15s;}
.finput{flex:1;min-width:160px;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.btn-search{padding:7px 16px;background:var(--erp-ink);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;}
.table-wrap{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;}
.result-bar{display:flex;justify-content:space-between;align-items:center;padding:.65rem 1rem;border-bottom:1px solid var(--erp-border);font-size:12px;color:var(--erp-ink-muted);}
.result-bar strong{color:var(--erp-ink);}
table{width:100%;border-collapse:collapse;font-size:12.5px;}
thead th{background:#f4f6f9;color:var(--erp-ink-muted);font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:9px 12px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
tbody tr{border-bottom:1px solid #f0f3f7;transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f7f9fc;}
tbody td{padding:9px 12px;vertical-align:middle;}
.badge{display:inline-flex;align-items:center;gap:3px;padding:3px 8px;border-radius:3px;font-size:10.5px;font-weight:700;white-space:nowrap;}
.badge-danger{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}
.badge-warn{background:var(--erp-warn-bg);color:var(--erp-warn);border:1px solid #f9d5a3;}
.td-mono{font-family:var(--font-mono);font-weight:700;}
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
.empty-row td{padding:3rem;text-align:center;color:var(--erp-ink-muted);}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Control de Rechazos</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Ventas › Rechazos</span>
</div>

<div class="body">

@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

<div class="page-hdr">
    <div>
        <div class="page-title">Registro de rechazos</div>
        <div class="page-sub">Productos devueltos por clientes · Stock restituido automáticamente</div>
    </div>
    <a href="{{ route('rechazos.create') }}" class="btn-new">
        ↩ Registrar rechazo
    </a>
</div>

{{-- KPIs --}}
@php
    $totalRechazos   = \App\Models\Rechazo::count();
    $totalUnidades   = \App\Models\Rechazo::sum('cantidad_rechazada');
    $ordenesAfectadas= \App\Models\Rechazo::distinct('order_id')->count('order_id');
    $hoy             = \App\Models\Rechazo::whereDate('fecha_rechazo', today())->count();
@endphp

<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-danger);">
        <div class="kpi-icon">↩</div>
        <div class="kpi-label">Total rechazos</div>
        <div class="kpi-val" style="color:var(--erp-danger);">{{ $totalRechazos }}</div>
        <div class="kpi-sub">registros históricos</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-warn);">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Unidades devueltas</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ number_format($totalUnidades,0) }}</div>
        <div class="kpi-sub">restituidas al stock</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">📋</div>
        <div class="kpi-label">Órdenes afectadas</div>
        <div class="kpi-val" style="color:var(--erp-accent);">{{ $ordenesAfectadas }}</div>
        <div class="kpi-sub">con al menos 1 rechazo</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">📅</div>
        <div class="kpi-label">Hoy</div>
        <div class="kpi-val" style="color:#7c3aed;">{{ $hoy }}</div>
        <div class="kpi-sub">rechazos registrados hoy</div>
    </div>
</div>

{{-- Filtros --}}
<div class="filter-bar">
    <form method="GET" style="display:flex;gap:8px;flex:1;flex-wrap:wrap;">
        🔍
        <input type="text" name="search" class="finput"
               value="{{ request('search') }}"
               placeholder="Buscar por N° orden o cliente...">
        <select name="motivo" class="fselect" onchange="this.form.submit()">
            <option value="">Todos los motivos</option>
            @foreach($motivos as $m)
                <option value="{{ $m }}" @selected(request('motivo')===$m)>{{ $m }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-search">Buscar</button>
        @if(request()->hasAny(['search','motivo']))
            <a href="{{ route('rechazos.index') }}"
               style="font-size:11px;color:#94a3b8;text-decoration:none;display:flex;align-items:center;">
                ✕ Limpiar
            </a>
        @endif
    </form>
</div>

{{-- Tabla --}}
<div class="table-wrap">
    <div class="result-bar">
        <span>Mostrando <strong>{{ $rechazos->count() }}</strong> de <strong>{{ $rechazos->total() }}</strong> rechazos</span>
        <span style="font-size:11px;color:#94a3b8;">Más recientes primero</span>
    </div>
    <div style="overflow-x:auto;">
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>N° Orden</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th style="text-align:center;">Cant. rechazada</th>
                <th>Motivo</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($rechazos as $r)
        <tr>
            <td style="color:#94a3b8;white-space:nowrap;font-size:11px;">
                {{ \Carbon\Carbon::parse($r->fecha_rechazo)->format('d M Y') }}
            </td>
            <td>
                <span class="td-mono" style="color:var(--erp-accent);font-size:12px;">
                    {{ $r->order->numero_orden ?? '—' }}
                </span>
            </td>
            <td style="font-size:12px;color:var(--erp-ink);">
                {{ $r->order->client->razon_social ?? '—' }}
            </td>
            <td style="font-weight:600;color:var(--erp-ink);">
                {{ $r->detail->product->nombre ?? '—' }}
            </td>
            <td style="text-align:center;">
                <span class="badge badge-danger">
                    −{{ number_format($r->cantidad_rechazada,0) }} u.
                </span>
            </td>
            <td>
                <span class="badge badge-warn">{{ $r->motivo }}</span>
            </td>
            <td style="color:#64748b;font-size:11px;max-width:200px;">
                {{ $r->observaciones ?? '—' }}
            </td>
        </tr>
        @empty
        <tr class="empty-row">
            <td colspan="7">
                <div style="font-size:28px;margin-bottom:8px;">✅</div>
                <div style="font-weight:600;color:var(--erp-ink);margin-bottom:4px;">Sin rechazos registrados</div>
                <div style="font-size:12px;">Todos los pedidos fueron aceptados correctamente.</div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>

@if($rechazos->hasPages())
<div style="margin-top:1rem;">{{ $rechazos->links() }}</div>
@endif

</div>
</div>
@endsection