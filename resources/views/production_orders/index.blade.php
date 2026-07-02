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
    --erp-danger:#c0312b;
    --erp-danger-bg:#fbe9e8;
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

/* ── Top bar ── */
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

/* ── Header ── */
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
    text-decoration:none;display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-new:hover{background:var(--erp-accent-dark);color:#fff;}

/* ── KPIs ── */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;border-left:4px solid;
    position:relative;overflow:hidden;
}
.kpi-icon{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    font-size:26px;opacity:.1;
}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:22px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* ── Advertencias ── */
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
.warn-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:8px;}
.warn-item{
    display:flex;align-items:flex-start;gap:8px;
    background:#fff;border:1px solid #fde68a;
    border-radius:3px;padding:8px 10px;
}
.warn-item-icon{font-size:16px;flex-shrink:0;margin-top:1px;}
.warn-item-text{font-size:11px;color:#7c4b00;line-height:1.55;}
.warn-item-text strong{color:#b45309;}

/* ── Info strip ── */
.info-strip{
    background:#eff6ff;border:1px solid #bfdbfe;
    border-left:4px solid var(--erp-accent);
    border-radius:4px;padding:.75rem 1rem;
    margin-bottom:1rem;
    display:flex;align-items:flex-start;gap:10px;
    font-size:11px;color:#1e40af;line-height:1.6;
}

/* ── Filter bar ── */
.filter-bar{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;
    margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;
}
.finput{
    padding:7px 10px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;flex:1;min-width:180px;
    font-family:var(--font-ui);transition:border-color .15s;
}
.finput:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.fselect{
    padding:7px 10px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;
    font-family:var(--font-ui);
}

/* ── Result bar ── */
.result-bar{
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:.65rem;font-size:12px;color:var(--erp-ink-muted);
    flex-wrap:wrap;gap:6px;
}
.result-bar strong{color:var(--erp-ink);}

/* ── Cards producción ── */
.catalog{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(290px,1fr));
    gap:12px;
}
.prod-card{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;overflow:hidden;
    display:flex;flex-direction:column;
    transition:box-shadow .15s,border-color .15s;
}
.prod-card:hover{
    border-color:#c2cbd8;
    box-shadow:0 2px 10px rgba(20,30,45,.08);
}
.prod-card.st-pending   {border-top:3px solid #f59e0b;}
.prod-card.st-progress  {border-top:3px solid var(--erp-accent);}
.prod-card.st-done      {border-top:3px solid var(--erp-ok);}
.prod-card.st-cancelled {border-top:3px solid #94a3b8;}

.prod-card-hdr{
    padding:.75rem 1rem .5rem;
    border-bottom:1px solid var(--erp-border);
    display:flex;justify-content:space-between;align-items:flex-start;gap:8px;
}
.prod-num{
    font-family:var(--font-mono);font-size:13px;
    font-weight:700;color:var(--erp-ink);
}
.status-badge{
    display:inline-flex;align-items:center;gap:3px;
    font-size:10px;font-weight:700;padding:3px 8px;
    border-radius:3px;white-space:nowrap;flex-shrink:0;
}
.sb-pending   {background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.sb-progress  {background:#dbeafe;color:var(--erp-accent-dark);border:1px solid #bfdbfe;}
.sb-done      {background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.sb-cancelled {background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;}

.prod-card-body{padding:.75rem 1rem;flex:1;display:flex;flex-direction:column;gap:0;}
.info-row{
    display:flex;justify-content:space-between;align-items:center;
    font-size:12px;padding:5px 0;
    border-bottom:1px dashed #ecf0f4;
    color:var(--erp-ink-muted);
}
.info-row:last-of-type{border-bottom:none;}
.info-val{font-weight:600;color:var(--erp-ink);max-width:60%;text-align:right;}

.mat-tag{
    display:inline-flex;align-items:center;gap:4px;
    background:#f4f6f9;border:1px solid var(--erp-border);
    border-radius:3px;padding:3px 8px;
    font-size:11px;font-weight:600;color:var(--erp-ink-muted);
    margin-top:6px;
}

.prod-card-footer{
    padding:.65rem 1rem;background:#f9fafb;
    border-top:1px solid var(--erp-border);
}
.btn-open{
    display:flex;align-items:center;justify-content:center;gap:5px;
    width:100%;padding:8px;
    background:var(--erp-ok);color:#fff;
    border:none;border-radius:3px;
    font-size:12px;font-weight:600;
    text-decoration:none;cursor:pointer;
    transition:background .15s;
}
.btn-open:hover{background:#166534;color:#fff;}

/* ── Empty ── */
.empty-state{
    background:var(--erp-surface);border:1px dashed var(--erp-border);
    border-radius:4px;padding:3rem;text-align:center;
    color:var(--erp-ink-muted);grid-column:1/-1;
}
.empty-state h3{color:var(--erp-ink);font-size:15px;margin-bottom:6px;}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Órdenes de Producción</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Producción › Órdenes</span>
</div>

<div class="body">

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Órdenes de producción</div>
        <div class="page-sub">Gestión y seguimiento de lotes de producción</div>
    </div>
    <a href="{{ route('production-orders.create') }}" class="btn-new">
        ➕ Nueva producción
    </a>
</div>

{{-- ── KPIs ── --}}
@php
    $total      = $orders->count();
    $pendientes = $orders->filter(fn($o) => strtoupper($o->status) === 'PENDIENTE')->count();
    $enProceso  = $orders->filter(fn($o) => in_array(strtoupper($o->status), ['EN_PROCESO','EN PROCESO','PROCESO']))->count();
    $completadas= $orders->filter(fn($o) => in_array(strtoupper($o->status), ['COMPLETADO','COMPLETADA','DONE','COMPLETO']))->count();
@endphp

<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">🏭</div>
        <div class="kpi-label">Total órdenes</div>
        <div class="kpi-val">{{ $total }}</div>
        <div class="kpi-sub">registradas en sistema</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">⏳</div>
        <div class="kpi-label">Pendientes</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ $pendientes }}</div>
        <div class="kpi-sub">por iniciar</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">⚙️</div>
        <div class="kpi-label">En proceso</div>
        <div class="kpi-val" style="color:var(--erp-accent);">{{ $enProceso }}</div>
        <div class="kpi-sub">en ejecución</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);background:var(--erp-ok-bg);">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Completadas</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ $completadas }}</div>
        <div class="kpi-sub">finalizadas</div>
    </div>
</div>

{{-- ── Panel advertencias ── --}}
<div class="warn-card">
    <div class="warn-title">⚠️ Advertencias operativas — leer antes de operar</div>
    <div class="warn-grid">
        <div class="warn-item">
            <div class="warn-item-icon">🚫</div>
            <div class="warn-item-text">
                <strong>No se puede eliminar</strong><br>
                Las órdenes de producción no pueden eliminarse una vez creadas. Si se cometió un error, comunícate con el encargado del sistema para una corrección.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">🎯</div>
            <div class="warn-item-text">
                <strong>Verificar materia prima</strong><br>
                Antes de iniciar, confirma que la materia prima seleccionada es la correcta en tipo, lote y cantidad. Un error afecta todo el lote de producción.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">⌨️</div>
            <div class="warn-item-text">
                <strong>Cuidado al digitar</strong><br>
                Revisa dos veces las cantidades antes de guardar. Los datos registrados impactan directamente el kardex de materia prima y el stock del producto.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">📋</div>
            <div class="warn-item-text">
                <strong>Actualizar el kardex</strong><br>
                Toda salida de materia prima debe quedar registrada. El inventario del sistema debe reflejar siempre el stock físico real del almacén.
            </div>
        </div>
    </div>
</div>

{{-- ── Info strip ── --}}
<div class="info-strip">
    <span style="font-size:18px;flex-shrink:0;">ℹ️</span>
    <div>
        <strong>¿Cómo funciona una orden de producción?</strong>
        Crea la orden → selecciona el producto a fabricar y la materia prima a consumir → registra las cantidades → el sistema descuenta el stock de materia prima automáticamente al completar la orden. Si necesitas corregir una orden cerrada, contacta al encargado.
    </div>
</div>

{{-- ── Filtros ── --}}
<div class="filter-bar">
    🔍
    <input
        type="text"
        class="finput"
        id="filtroTexto"
        placeholder="Buscar por número, producto o materia prima..."
        oninput="filtrarOrdenes()">
    <select class="fselect" id="filtroEstado" onchange="filtrarOrdenes()">
        <option value="">Todos los estados</option>
        <option value="pendiente">⏳ Pendiente</option>
        <option value="proceso">⚙️ En proceso</option>
        <option value="completo">✅ Completado</option>
    </select>
</div>

<div class="result-bar">
    <div>Mostrando <strong id="countVisible">{{ $orders->count() }}</strong> órdenes</div>
    <div style="font-size:11px;color:#94a3b8;">Más recientes primero</div>
</div>

{{-- ── Cards ── --}}
<div class="catalog" id="catalogGrid">

@forelse($orders as $order)
@php
    $statusUp = strtoupper($order->status);

    $statusKey = 'pending';
    if (in_array($statusUp, ['EN_PROCESO','EN PROCESO','PROCESO','IN_PROGRESS'])) {
        $statusKey = 'progress';
    } elseif (in_array($statusUp, ['COMPLETADO','COMPLETADA','DONE','COMPLETO'])) {
        $statusKey = 'done';
    } elseif (in_array($statusUp, ['CANCELADO','CANCELLED'])) {
        $statusKey = 'cancelled';
    }

    $cardClass = [
        'pending'   => 'st-pending',
        'progress'  => 'st-progress',
        'done'      => 'st-done',
        'cancelled' => 'st-cancelled',
    ][$statusKey];

    $badgeClass = [
        'pending'   => 'sb-pending',
        'progress'  => 'sb-progress',
        'done'      => 'sb-done',
        'cancelled' => 'sb-cancelled',
    ][$statusKey];

    $badgeLabel = [
        'pending'   => '⏳ Pendiente',
        'progress'  => '⚙️ En proceso',
        'done'      => '✅ Completado',
        'cancelled' => '✕ Cancelado',
    ][$statusKey];
@endphp

<div class="prod-card {{ $cardClass }}"
     data-q="{{ strtolower($order->number . ' ' . ($order->product->nombre ?? '') . ' ' . ($order->rawMaterial->name ?? '')) }}"
     data-status="{{ $statusKey }}">

    <div class="prod-card-hdr">
        <div>
            <div class="prod-num">{{ $order->number }}</div>
        </div>
        <span class="status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
    </div>

    <div class="prod-card-body">

        <div class="info-row">
            <span>Producto</span>
            <span class="info-val">{{ $order->product->nombre ?? '—' }}</span>
        </div>

        <div class="info-row">
            <span>Materia prima</span>
            <span class="info-val">{{ $order->rawMaterial->name ?? '—' }}</span>
        </div>

        @if(isset($order->quantity))
        <div class="info-row">
            <span>Cantidad</span>
            <span class="info-val" style="font-family:'Consolas',monospace;font-weight:700;">
                {{ number_format($order->quantity, 2) }}
            </span>
        </div>
        @endif

        @if(isset($order->created_at))
        <div class="info-row">
            <span>Fecha</span>
            <span class="info-val">
                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
            </span>
        </div>
        @endif

        <div style="margin-top:6px;display:flex;gap:5px;flex-wrap:wrap;">
            @if($order->rawMaterial)
            <span class="mat-tag">
                🧪 {{ $order->rawMaterial->name }}
                @if($order->rawMaterial->unit)
                    · {{ $order->rawMaterial->unit }}
                @endif
            </span>
            @endif
        </div>

    </div>

    <div class="prod-card-footer">
        <a href="{{ route('production-orders.show', $order) }}" class="btn-open">
            📂 Abrir orden
        </a>
    </div>

</div>

@empty

<div class="empty-state">
    <div style="font-size:36px;margin-bottom:8px;">🏭</div>
    <h3>No existen órdenes de producción</h3>
    <p style="font-size:12px;margin:.5rem 0 1rem;">
        Comienza creando tu primera orden de producción.
    </p>
    <a href="{{ route('production-orders.create') }}" class="btn-new">
        ➕ Nueva producción
    </a>
</div>

@endforelse

</div>

</div>
</div>

<script>
function filtrarOrdenes() {
    var texto  = document.getElementById('filtroTexto').value.toLowerCase();
    var estado = document.getElementById('filtroEstado').value.toLowerCase();
    var cards  = document.querySelectorAll('#catalogGrid .prod-card');
    var visible = 0;

    cards.forEach(function(card) {
        var mTexto  = !texto  || (card.dataset.q && card.dataset.q.includes(texto));
        var mEstado = !estado || (card.dataset.status && card.dataset.status.includes(estado));
        var show = mTexto && mEstado;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    var cnt = document.getElementById('countVisible');
    if (cnt) cnt.textContent = visible;
}
</script>

@endsection