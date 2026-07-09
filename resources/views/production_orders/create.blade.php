@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;
    --erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;
    --erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;
    --erp-warn:#b9690e;--erp-warn-bg:#fdf1e2;
    --font-ui:'Segoe UI',sans-serif;--font-mono:'Consolas',monospace;
}
*{box-sizing:border-box;}
.page{
    background:var(--erp-bg);font-family:var(--font-ui);
    color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;
}
.erp-bar{
    background:#1e3a5f;height:38px;display:flex;
    align-items:center;justify-content:space-between;
    padding:0 1.25rem;margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
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
    background:var(--erp-ok);border-radius:2px;display:inline-block;
}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.breadcrumb-erp{font-size:11px;color:#94a3b8;}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Nueva Orden de Producción</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">
        Producción › Órdenes › Nueva
    </span>
</div>

<div class="body">

    <div class="page-hdr">
        <div>
            <div class="page-title">Nueva orden de producción</div>
            <div class="page-sub">Registrar una nueva producción en el sistema</div>
        </div>
        <span class="breadcrumb-erp">🏭 Producción › Nueva orden</span>
    </div>

    @include('production_orders.form')

</div>
</div>

@endsection