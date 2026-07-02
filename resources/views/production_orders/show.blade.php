@extends('layouts.app')

@section('content')

<style>
    .erp-page { background:#f0f2f5; min-height:100vh; padding:24px; }

    /* ---- Breadcrumb ---- */
    .erp-breadcrumb { font-size:12px; color:#8c8c8c; margin-bottom:16px; display:flex; align-items:center; gap:6px; }
    .erp-breadcrumb a { color:#1890ff; text-decoration:none; }
    .erp-breadcrumb a:hover { text-decoration:underline; }

    /* ---- Header ---- */
    .erp-header {
        background:white;
        border-radius:8px;
        border-left:5px solid #1890ff;
        padding:18px 24px;
        margin-bottom:18px;
        box-shadow:0 1px 4px rgba(0,0,0,.06);
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:12px;
    }
    .erp-header-left { display:flex; align-items:center; gap:16px; }
    .erp-header-icon {
        width:52px; height:52px; border-radius:12px;
        background:#e6f0ff; display:flex; align-items:center;
        justify-content:center; font-size:24px; flex-shrink:0;
    }
    .erp-doc-number { font-size:20px; font-weight:700; color:#1a1a2e; margin:0; }
    .erp-doc-sub    { font-size:12px; color:#8c8c8c; margin:2px 0 0; }

    /* ---- KPI Row ---- */
    .erp-kpi-row {
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:16px;
        margin-bottom:18px;
    }
    .erp-kpi {
        background:white;
        border-radius:8px;
        padding:16px 20px;
        box-shadow:0 1px 4px rgba(0,0,0,.06);
        border-top:3px solid transparent;
        transition:transform .15s;
    }
    .erp-kpi:hover { transform:translateY(-2px); }
    .erp-kpi-label { font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:#8c8c8c; margin:0; }
    .erp-kpi-value { font-size:26px; font-weight:700; margin:4px 0 0; color:#1a1a2e; }
    .erp-kpi-icon  { font-size:18px; float:right; margin-top:-28px; opacity:.5; }

    /* ---- Main Grid ---- */
    .erp-grid {
        display:grid;
        grid-template-columns:1fr 360px;
        gap:18px;
        align-items:start;
    }

    /* ---- Panels ---- */
    .erp-panel {
        background:white;
        border-radius:8px;
        box-shadow:0 1px 4px rgba(0,0,0,.06);
        overflow:hidden;
        margin-bottom:18px;
    }
    .erp-panel-header {
        background:#fafafa;
        border-bottom:1px solid #f0f0f0;
        padding:12px 20px;
        display:flex;
        align-items:center;
        gap:8px;
    }
    .erp-panel-title { font-size:13px; font-weight:600; color:#434343; margin:0; }
    .erp-panel-body  { padding:20px; }

    /* ---- Field rows ---- */
    .erp-field { display:flex; justify-content:space-between; align-items:center; padding:11px 0; border-bottom:1px solid #f5f5f5; }
    .erp-field:last-child { border-bottom:none; }
    .erp-field-label { font-size:12px; color:#8c8c8c; display:flex; align-items:center; gap:6px; }
    .erp-field-value { font-size:14px; font-weight:600; color:#1a1a2e; text-align:right; }

    /* ---- Progress bar ---- */
    .erp-progress-track { background:#f0f0f0; border-radius:20px; height:10px; overflow:hidden; margin-top:12px; }
    .erp-progress-fill  { height:100%; border-radius:20px; background:linear-gradient(90deg,#52c41a,#1890ff); transition:width .4s ease; }

    /* ---- Badge ---- */
    .erp-badge {
        display:inline-flex; align-items:center; gap:5px;
        padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;
    }

    /* ---- Action buttons ---- */
    .erp-btn {
        display:inline-flex; align-items:center; justify-content:center; gap:8px;
        padding:10px 20px; border-radius:6px; font-size:14px; font-weight:600;
        cursor:pointer; border:none; width:100%; margin-bottom:10px;
        text-decoration:none; transition:opacity .15s, transform .1s;
    }
    .erp-btn:hover { opacity:.88; transform:translateY(-1px); }
    .erp-btn:active { transform:translateY(0); }
    .erp-btn-success { background:#52c41a; color:white; }
    .erp-btn-danger  { background:#ff4d4f; color:white; }

    /* ---- Timeline ---- */
    .erp-timeline { list-style:none; padding:0; margin:0; }
    .erp-tl-item  { display:flex; gap:12px; padding-bottom:14px; position:relative; }
    .erp-tl-item:not(:last-child)::before {
        content:''; position:absolute; left:8px; top:18px;
        width:2px; height:calc(100% - 4px); background:#f0f0f0;
    }
    .erp-tl-dot   { width:18px; height:18px; border-radius:50%; flex-shrink:0; margin-top:2px; display:flex; align-items:center; justify-content:center; font-size:9px; }
    .erp-tl-text  { font-size:13px; color:#595959; }
    .erp-tl-time  { font-size:11px; color:#bfbfbf; }

    @media (max-width:900px) {
        .erp-kpi-row { grid-template-columns:repeat(2,1fr) !important; }
        .erp-grid    { grid-template-columns:1fr !important; }
    }
</style>

<div class="erp-page">

    {{-- Breadcrumb --}}
    <div class="erp-breadcrumb">
        <a href="#">Inicio</a> ›
        <a href="#">Producción</a> ›
        <span>{{ $production_order->number }}</span>
    </div>

    {{-- Header --}}
    <div class="erp-header">
        <div class="erp-header-left">
            <div class="erp-header-icon">🏭</div>
            <div>
                <p class="erp-doc-number">{{ $production_order->number }}</p>
                <p class="erp-doc-sub">Orden de Producción · {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div>
            {{-- Badge usa exactamente $production_order->status y status_color (tu código original) --}}
            <span class="badge bg-{{ $production_order->status_color }}" style="font-size:13px;padding:6px 14px;border-radius:20px;">
                {{ $production_order->status }}
            </span>
        </div>
    </div>

    {{-- ============================================================
         KPIs — calculados desde tus campos originales sin modificarlos
    ============================================================ --}}
    @php
        $consumido  = $production_order->consumed_quantity  ?? 0;
        $producido  = $production_order->produced_quantity  ?? 0;
        $rendimiento = $consumido > 0 ? round(($producido / $consumido) * 100, 1) : 0;
        // Progreso: si tienes un campo target_quantity úsalo; si no, usamos produced_quantity como referencia
        $target  = $production_order->target_quantity  ?? $producido;
        $pct     = $target > 0 ? min(100, round(($producido / $target) * 100)) : 100;
    @endphp

    <div class="erp-kpi-row">
        <div class="erp-kpi" style="border-top-color:#1890ff;">
            <p class="erp-kpi-label">Producción</p>
            <p class="erp-kpi-value">{{ number_format($producido, 0) }}</p>
            <span class="erp-kpi-icon">📦</span>
        </div>
        <div class="erp-kpi" style="border-top-color:#faad14;">
            <p class="erp-kpi-label">Consumo MP</p>
            <p class="erp-kpi-value">{{ number_format($consumido, 0) }}</p>
            <span class="erp-kpi-icon">🧱</span>
        </div>
        <div class="erp-kpi" style="border-top-color:#52c41a;">
            <p class="erp-kpi-label">Rendimiento</p>
            <p class="erp-kpi-value">{{ $rendimiento }}%</p>
            <span class="erp-kpi-icon">📈</span>
        </div>
        <div class="erp-kpi" style="border-top-color:#722ed1;">
            <p class="erp-kpi-label">Avance</p>
            <p class="erp-kpi-value">{{ $pct }}%</p>
            <span class="erp-kpi-icon">🎯</span>
        </div>
    </div>

    {{-- ============================================================
         GRID PRINCIPAL
    ============================================================ --}}
    <div class="erp-grid">

        {{-- COLUMNA IZQUIERDA --}}
        <div>

            {{-- Panel: Datos del documento --}}
            <div class="erp-panel">
                <div class="erp-panel-header">
                    <span>📄</span>
                    <p class="erp-panel-title">Datos del documento</p>
                </div>
                <div class="erp-panel-body">
                    {{-- TU CÓDIGO ORIGINAL: product, rawMaterial, produced_quantity, consumed_quantity, status --}}
                    <div class="erp-field">
                        <span class="erp-field-label">🏷️ Número de orden</span>
                        <span class="erp-field-value">{{ $production_order->number }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">📦 Producto</span>
                        <span class="erp-field-value">{{ $production_order->product->nombre }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">🧱 Materia Prima</span>
                        <span class="erp-field-value">{{ $production_order->rawMaterial->name }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">🏭 Cantidad Producida</span>
                        <span class="erp-field-value" style="color:#1890ff;">{{ $production_order->produced_quantity }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">🔽 Cantidad Consumida</span>
                        <span class="erp-field-value" style="color:#faad14;">{{ $production_order->consumed_quantity }}</span>
                    </div>
                    <div class="erp-field">
                        <span class="erp-field-label">🔖 Estado</span>
                        {{-- Tu badge original sin modificar --}}
                        <span class="badge bg-{{ $production_order->status_color }}">
                            {{ $production_order->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Panel: Progreso de avance --}}
            <div class="erp-panel">
                <div class="erp-panel-header">
                    <span>📊</span>
                    <p class="erp-panel-title">Progreso de producción</p>
                </div>
                <div class="erp-panel-body">
                    <div style="display:flex;justify-content:space-between;font-size:13px;color:#8c8c8c;margin-bottom:4px;">
                        <span>Avance de la orden</span>
                        <strong style="color:#1a1a2e;">{{ $pct }}%</strong>
                    </div>
                    <div class="erp-progress-track">
                        <div class="erp-progress-fill" style="width:{{ $pct }}%;"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#bfbfbf;margin-top:6px;">
                        <span>0</span>
                        <span>{{ $target }}</span>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:16px;">
                        <div style="background:#e6f4ff;border-radius:8px;padding:12px;text-align:center;">
                            <p style="font-size:11px;color:#1890ff;margin:0;font-weight:600;">PRODUCIDO</p>
                            <p style="font-size:22px;font-weight:700;color:#1890ff;margin:4px 0 0;">{{ $production_order->produced_quantity }}</p>
                        </div>
                        <div style="background:#fff7e6;border-radius:8px;padding:12px;text-align:center;">
                            <p style="font-size:11px;color:#faad14;margin:0;font-weight:600;">CONSUMIDO</p>
                            <p style="font-size:22px;font-weight:700;color:#faad14;margin:4px 0 0;">{{ $production_order->consumed_quantity }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- COLUMNA DERECHA --}}
        <div>

            {{-- Panel: Acciones (tu lógica original intacta) --}}
            <div class="erp-panel">
                <div class="erp-panel-header">
                    <span>⚙️</span>
                    <p class="erp-panel-title">Acciones</p>
                </div>
                <div class="erp-panel-body">
                    @if($production_order->status != 'FINALIZADA')

                        {{-- TU FORM ORIGINAL: route production-orders.finish --}}
                        <form method="POST" action="{{ route('production-orders.finish', $production_order) }}">
                            @csrf
                            <button class="erp-btn erp-btn-success">
                                🏁 FINALIZAR PRODUCCIÓN
                            </button>
                        </form>

                        {{-- TU FORM ORIGINAL: route production-orders.destroy (solo admin) --}}
                        @auth
                        @if(auth()->user()->role === 'admin')
                        <form method="POST"
                              action="{{ route('production-orders.destroy', $production_order) }}"
                              onsubmit="return confirm('¿Está seguro? Se restaurará el inventario y la orden será eliminada permanentemente.')"
                              class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button class="erp-btn erp-btn-danger">
                                🗑 Eliminar Producción
                            </button>
                        </form>
                        @endif
                        @endauth

                    @else

                        {{-- TU ALERT ORIGINAL --}}
                        <div class="alert alert-success" style="border-radius:8px;text-align:center;">
                            ✅ Producción finalizada.
                        </div>

                    @endif
                </div>
            </div>

            {{-- Panel: Timeline de estados (visual, no requiere datos extra) --}}
            <div class="erp-panel">
                <div class="erp-panel-header">
                    <span>🕒</span>
                    <p class="erp-panel-title">Flujo del proceso</p>
                </div>
                <div class="erp-panel-body">
                    @php
                        $pasos = [
                            ['label'=>'Orden creada',       'done'=>true,  'color'=>'#52c41a'],
                            ['label'=>'En producción',      'done'=>true,  'color'=>'#1890ff'],
                            ['label'=>'Producción finalizada','done'=> $production_order->status == 'FINALIZADA', 'color'=>'#722ed1'],
                        ];
                    @endphp
                    <ul class="erp-timeline">
                        @foreach($pasos as $paso)
                        <li class="erp-tl-item">
                            <div class="erp-tl-dot" style="background:{{ $paso['done'] ? $paso['color'] : '#d9d9d9' }};color:white;">
                                {{ $paso['done'] ? '✓' : '' }}
                            </div>
                            <div>
                                <p class="erp-tl-text" style="margin:0;font-weight:{{ $paso['done'] ? '600' : '400' }};color:{{ $paso['done'] ? '#1a1a2e' : '#bfbfbf' }};">
                                    {{ $paso['label'] }}
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Panel: Info adicional (visual, sin datos extra) --}}
            <div class="erp-panel">
                <div class="erp-panel-header">
                    <span>ℹ️</span>
                    <p class="erp-panel-title">Información del sistema</p>
                </div>
                <div class="erp-panel-body">
                    <div class="erp-field">
                        <span class="erp-field-label">📅 Fecha consulta</span>
                        <span class="erp-field-value" style="font-size:13px;">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    @if(isset($production_order->created_at))
                    <div class="erp-field">
                        <span class="erp-field-label">🗓️ Creado</span>
                        <span class="erp-field-value" style="font-size:13px;">{{ $production_order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    @if(isset($production_order->updated_at))
                    <div class="erp-field">
                        <span class="erp-field-label">✏️ Actualizado</span>
                        <span class="erp-field-value" style="font-size:13px;">{{ $production_order->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection