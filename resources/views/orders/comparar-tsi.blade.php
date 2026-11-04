@extends('layouts.app')

@section('content')
<style>
    .tsi-page{--tsi-blue:#1769d1;color:#172b45}
    .tsi-head{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:16px}
    .tsi-title{margin:0;font-size:clamp(20px,2vw,26px);font-weight:800;color:#17365d}
    .tsi-subtitle{margin:5px 0 0;color:#64748b;font-size:13px}
    .tsi-actions{display:flex;gap:8px;flex-wrap:wrap}
    .tsi-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:9px 13px;border-radius:9px;text-decoration:none;font-size:13px;font-weight:700;border:1px solid #cbd5e1;background:#fff;color:#24476d;cursor:pointer}
    .tsi-btn.primary{background:#1769d1;color:#fff;border-color:#1769d1}
    .tsi-layout{display:grid;grid-template-columns:minmax(280px, .82fr) minmax(0, 1.8fr);gap:14px;align-items:stretch}
    .tsi-panel{background:#fff;border:1px solid #dce5ef;border-radius:13px;overflow:hidden;min-width:0;box-shadow:0 3px 12px rgba(15,39,71,.06)}
    .tsi-panel-head{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:13px 15px;background:#f7faff;border-bottom:1px solid #e3eaf2}
    .tsi-panel-head strong{font-size:14px;color:#17365d}
    .tsi-count{font-size:11px;font-weight:700;color:#526b87;background:#e8f0fa;padding:4px 8px;border-radius:20px}
    .tsi-order-list{max-height:calc(100vh - 245px);min-height:540px;overflow:auto}
    .tsi-order{display:block;padding:13px 15px;border-bottom:1px solid #edf1f5;text-decoration:none;color:inherit}
    .tsi-order:hover{background:#f5f9ff}
    .tsi-order-top{display:flex;justify-content:space-between;gap:8px;align-items:center}
    .tsi-order-code{font-size:13px;font-weight:800;color:#1e4e83}
    .tsi-order-state{font-size:10px;font-weight:800;padding:4px 7px;border-radius:20px;background:#fff4d6;color:#936400}
    .tsi-order-meta{display:flex;justify-content:space-between;gap:8px;margin-top:7px;color:#64748b;font-size:11px;flex-wrap:wrap}
    .tsi-empty{padding:30px 18px;text-align:center;color:#64748b;font-size:13px}
    .tsi-frame-wrap{height:calc(100vh - 220px);min-height:600px;background:#eef2f7;position:relative}
    .tsi-frame{width:100%;height:100%;border:0;background:#fff}
    .tsi-frame-note{padding:9px 13px;background:#fff8e8;border-top:1px solid #f4dfaa;color:#795b18;font-size:11px;line-height:1.5}
    @media(max-width:900px){.tsi-layout{grid-template-columns:1fr}.tsi-order-list{max-height:330px;min-height:180px}.tsi-frame-wrap{height:75vh;min-height:520px}}
</style>

<div class="tsi-page">
    <div class="tsi-head">
        <div>
            <h1 class="tsi-title">Comparar pedidos TSI vs DISTAN</h1>
            <p class="tsi-subtitle">Consulta los pedidos pendientes en DISTAN mientras trabajas en el ERP de TSI.</p>
        </div>
        <div class="tsi-actions">
            <a class="tsi-btn" href="{{ route('pedidos.index') }}">Ver pedidos en DISTAN</a>
            <a class="tsi-btn primary" href="https://core.erp.gtsi.pe/login" target="_blank" rel="noopener noreferrer">Abrir TSI en otra pestaña ↗</a>
        </div>
    </div>

    <div class="tsi-layout">
        <section class="tsi-panel">
            <div class="tsi-panel-head">
                <strong>Pedidos pendientes · DISTAN</strong>
                <span class="tsi-count">{{ $orders->count() }} pedidos</span>
            </div>
            <div class="tsi-order-list">
                @forelse($orders as $order)
                    @php
                        $codigo = $order->numero_pedido ?? $order->codigo ?? $order->numero ?? ('Pedido #'.$order->id);
                        $estado = $order->estado ?? 'Pendiente';
                        $fecha = $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'Sin fecha';
                        $cliente = $order->cliente ?? $order->nombre_cliente ?? null;
                    @endphp
                    <a class="tsi-order" href="{{ url('/orders/'.$order->id) }}" target="_blank" rel="noopener">
                        <div class="tsi-order-top">
                            <span class="tsi-order-code">{{ $codigo }}</span>
                            <span class="tsi-order-state">{{ $estado }}</span>
                        </div>
                        <div class="tsi-order-meta">
                            <span>{{ $cliente ?: 'Cliente no especificado' }}</span>
                            <span>{{ $fecha }}</span>
                        </div>
                    </a>
                @empty
                    <div class="tsi-empty">No hay pedidos pendientes para mostrar.</div>
                @endforelse
            </div>
        </section>

        <section class="tsi-panel">
            <div class="tsi-panel-head">
                <strong>ERP TSI</strong>
                <span class="tsi-count">Sesión externa</span>
            </div>
            <div class="tsi-frame-wrap">
                <iframe
                    class="tsi-frame"
                    src="https://core.erp.gtsi.pe/login"
                    title="ERP TSI"
                    loading="eager"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allow="clipboard-read; clipboard-write"
                ></iframe>
            </div>
            <div class="tsi-frame-note">
                Si TSI no aparece, muestra un aviso de bloqueo o no permite iniciar sesión dentro del panel,
                usa «Abrir TSI en otra pestaña». Algunos sistemas bloquean la carga incrustada por seguridad
                o por restricciones de cookies. Inicia sesión directamente en TSI; DISTAN no solicita ni guarda
                tus credenciales.
            </div>
        </section>
    </div>
</div>
@endsection
