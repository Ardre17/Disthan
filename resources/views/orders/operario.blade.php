@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1rem;max-width:680px;margin:auto;background:#0f172a;min-height:100vh;}
.top-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.order-title{font-size:16px;font-weight:700;color:#f8fafc;display:flex;align-items:center;gap:8px;}
.order-client{font-size:11px;color:#64748b;margin-top:2px;}
.badge-estado{padding:4px 12px;border-radius:99px;font-size:11px;font-weight:700;color:#fff;}
.prog-card{background:#1e293b;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem;border:1px solid #334155;}
.prog-top{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:.6rem;}
.prog-pct{font-size:32px;font-weight:800;line-height:1;}
.prog-track{width:100%;height:18px;background:#0f172a;border-radius:99px;overflow:hidden;margin-bottom:.5rem;}
.prog-fill{height:100%;border-radius:99px;transition:width .5s ease;}
.prog-labels{display:flex;justify-content:space-between;font-size:11px;color:#475569;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
.kpi{background:#1e293b;border:1px solid #334155;border-radius:10px;padding:.65rem .75rem;text-align:center;}
.kpi-val{font-size:18px;font-weight:700;color:#f8fafc;line-height:1;}
.kpi-label{font-size:10px;color:#64748b;margin-top:2px;text-transform:uppercase;letter-spacing:.05em;}
.scanner-wrap{background:#1e293b;border:1px solid #334155;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem;}
.scanner-top{display:flex;align-items:center;gap:10px;margin-bottom:.6rem;}
.scanner-pulse{width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse 1.4s infinite;}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.3;transform:scale(.8);}}
.scanner-label{font-size:12px;color:#94a3b8;font-weight:600;}
.scanner-input{width:100%;padding:12px 16px;font-size:18px;border-radius:10px;border:2px solid #334155;background:#0f172a;color:#f8fafc;outline:none;letter-spacing:2px;transition:border-color .2s;}
.scanner-input:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.15);}
.scanner-input::placeholder{color:#334155;font-size:13px;letter-spacing:0;}
.scanner-hint{font-size:10px;color:#475569;margin-top:5px;display:flex;align-items:center;gap:4px;}
.activo-box{background:#1e293b;border:2px solid #3b82f6;border-radius:12px;padding:1rem;margin-bottom:1rem;display:none;}
.activo-name{font-size:15px;font-weight:700;color:#f8fafc;margin-bottom:4px;}
.activo-meta{font-size:11px;color:#64748b;margin-bottom:.75rem;display:flex;gap:12px;flex-wrap:wrap;}
.activo-fields{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:.75rem;}
.activo-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.activo-input{width:100%;padding:10px 12px;border-radius:8px;border:1px solid #334155;background:#0f172a;color:#f8fafc;font-size:15px;outline:none;transition:border-color .2s;}
.activo-input:focus{border-color:#3b82f6;}
.activo-input.big{font-size:22px;font-weight:700;text-align:center;padding:12px;}
.activo-bar-track{width:100%;height:8px;background:#0f172a;border-radius:99px;overflow:hidden;margin:.5rem 0;}
.toast{position:fixed;top:16px;right:16px;z-index:999;padding:10px 16px;border-radius:10px;font-size:13px;font-weight:600;display:none;align-items:center;gap:8px;box-shadow:0 4px 20px rgba(0,0,0,.4);}
.toast.show{display:flex;animation:toastIn .2s;}
@keyframes toastIn{from{opacity:0;transform:translateY(-10px);}to{opacity:1;transform:translateY(0);}}
.tok{background:#166534;color:#dcfce7;border:1px solid #22c55e;}
.twk{background:#854d0e;color:#fef3c7;border:1px solid #f59e0b;}
.ter{background:#991b1b;color:#fee2e2;border:1px solid #ef4444;}
.sec-title{font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.65rem;display:flex;align-items:center;gap:6px;}
.prod-list{display:flex;flex-direction:column;gap:8px;}
.prod-item{background:#1e293b;border:1px solid #334155;border-radius:10px;padding:.85rem 1rem;border-left:4px solid;transition:transform .15s;}
.prod-item:hover{transform:translateX(3px);}
.prod-item-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:5px;}
.prod-item-name{font-size:13px;font-weight:600;color:#f1f5f9;}
.prod-item-sku{font-size:10px;color:#475569;margin-top:2px;}
.prod-item-badge{font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;white-space:nowrap;}
.bc{background:#166534;color:#bbf7d0;}
.bp{background:#854d0e;color:#fde68a;}
.bi{background:#991b1b;color:#fecaca;}
.prod-item-meta{display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#64748b;margin-bottom:5px;}
.prod-mini-bar{width:100%;height:4px;background:#0f172a;border-radius:99px;overflow:hidden;}
.prod-mini-fill{height:100%;border-radius:99px;transition:width .4s;}
.btn-cerrar{width:100%;background:#16a34a;color:#fff;border:none;padding:14px;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;margin-top:1rem;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .15s;}
.btn-cerrar:hover{background:#15803d;}
hr.dv{border:none;border-top:1px solid #334155;margin:.75rem 0;}

@keyframes popup{

from{
transform:scale(.8);
opacity:0;
}
to{
transform:scale(1);
opacity:1;
}}
</style>

{{-- Fondo oscuro para toda la página --}}
<div style="background:#0f172a;min-height:100vh;margin:-20px;padding:20px;">
<div class="pg" style="background:transparent;">

{{-- Toast --}}
<div class="toast" id="toast"></div>

{{-- Header --}}
@php
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d'
                 : ($order->estado === 'PARCIAL'  ? '#b45309' : '#b91c1c');
    $totalUnidades = $order->details->sum('cantidad_solicitada');
    $doneUnidades  = $order->details->sum('cantidad_despachada');
    $porcentaje    = $totalUnidades > 0 ? ($doneUnidades / $totalUnidades) * 100 : 0;
    $progColor     = $porcentaje >= 100 ? '#22c55e' : ($porcentaje > 40 ? '#f59e0b' : '#ef4444');
    $totalItems    = $order->details->count();
    $compItems     = $order->details->where('estado_item','COMPLETO')->count();
    $parItems      = $order->details->where('estado_item','PARCIAL')->count();
    $incItems      = $order->details->where('estado_item','INCOMPLETO')->count();
@endphp

<div class="top-hdr">
    <div>
        <div class="order-title">📋 {{ $order->numero_orden }}</div>
        <div class="order-client">{{ $order->client?->razon_social }}</div>
    </div>
    <span class="badge-estado" style="background:{{ $estadoColor }};">{{ $order->estado }}</span>
</div>

{{-- Barra grande --}}
<div class="prog-card">
    <div class="prog-top">
        <div>
            <div class="prog-pct" id="pctNum" style="color:{{ $progColor }};">{{ number_format($porcentaje,0) }}%</div>
            <div style="font-size:11px;color:#64748b;margin-top:2px;">Progreso de despacho</div>
        </div>
        <div style="text-align:right;">
            <div id="pctDone" style="font-size:18px;font-weight:700;color:#f8fafc;">{{ $doneUnidades }} / {{ $totalUnidades }}</div>
            <div style="font-size:11px;color:#64748b;">unidades despachadas</div>
        </div>
    </div>
    <div class="prog-track">
        <div class="prog-fill" id="progFill" style="width:{{ $porcentaje }}%;background:{{ $progColor }};"></div>
    </div>
    <div class="prog-labels">
        <span>0%</span>
        <span id="progEstado" style="color:{{ $progColor }};">● {{ $order->estado }}</span>
        <span>100%</span>
    </div>
</div>

{{-- KPIs --}}
<div class="kpis">
    <div class="kpi">
        <div class="kpi-val" style="color:#3b82f6;">{{ $totalItems }}</div>
        <div class="kpi-label">Productos</div>
    </div>
    <div class="kpi">
        <div class="kpi-val" style="color:#22c55e;" id="kpiOk">{{ $compItems }}</div>
        <div class="kpi-label">Completos</div>
    </div>
    <div class="kpi">
        <div class="kpi-val" style="color:#f59e0b;" id="kpiPar">{{ $parItems }}</div>
        <div class="kpi-label">Parciales</div>
    </div>
    <div class="kpi">
        <div class="kpi-val" style="color:#ef4444;" id="kpiInc">{{ $incItems }}</div>
        <div class="kpi-label">Faltantes</div>
    </div>
</div>

{{-- Scanner --}}
<div class="scanner-wrap">
    <div class="scanner-top">
        <div class="scanner-pulse"></div>
        <div class="scanner-label">📡 Escanear código de barras</div>
    </div>
    <input type="text" id="scanner" class="scanner-input"
           placeholder="Escanea o escribe el código y presiona Enter..." autofocus>
    <div class="scanner-hint">⌨ Presiona <strong style="color:#94a3b8;">Enter</strong> para confirmar · El foco regresa automáticamente</div>
</div>

{{-- Producto activo --}}
<div class="activo-box" id="activoBox">
    <div class="activo-name" id="activoNombre">—</div>
    <div class="activo-meta">
        <span>SKU: <strong id="activoSku" style="color:#94a3b8;">—</strong></span>
        <span>Stock: <strong id="activoStock" style="color:#94a3b8;">—</strong></span>
        <span>Peso: <strong id="activoPeso" style="color:#94a3b8;">—</strong></span>
    </div>
    <div class="activo-fields">
        <div>
            <label class="activo-label">Solicitado</label>
            <input type="number" class="activo-input" id="activoSolicitado" readonly style="color:#64748b;">
        </div>
        <div>
            <label class="activo-label">Despachado ✏️</label>
            <input type="number" class="activo-input big" id="activoCantidad" id="cantidad" placeholder="0">
        </div>
    </div>
    <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:3px;">
        <span>Progreso ítem</span>
        <span id="activoPctLabel" style="font-weight:700;color:#94a3b8;">—</span>
    </div>
    <div class="activo-bar-track">
        <div id="activoBarFill" style="height:100%;border-radius:99px;background:#3b82f6;width:0%;transition:width .3s;"></div>
    </div>
    <div style="font-size:11px;color:#475569;margin-top:4px;">
        Paleta: <strong id="activoPaleta" style="color:#94a3b8;">—</strong>
        · Ubicación: <strong id="activoUbicacion" style="color:#94a3b8;">—</strong>
        · Vence: <strong id="activoVence" style="color:#94a3b8;">—</strong>
    </div>
</div>

{{-- Lista productos --}}
<div class="sec-title">📦 Productos de la orden</div>
<div class="prod-list">

@foreach($order->details as $item)
@php
    $pct2 = $item->cantidad_solicitada > 0
           ? ($item->cantidad_despachada / $item->cantidad_solicitada) * 100
           : 0;
    $lc  = $item->cantidad_despachada >= $item->cantidad_solicitada ? '#22c55e'
          : ($item->cantidad_despachada > 0 ? '#f59e0b' : '#ef4444');
    $badgeCls = $item->cantidad_despachada >= $item->cantidad_solicitada ? 'bc'
              : ($item->cantidad_despachada > 0 ? 'bp' : 'bi');
    $badgeLbl = $item->cantidad_despachada >= $item->cantidad_solicitada ? 'COMPLETO'
              : ($item->cantidad_despachada > 0 ? 'PARCIAL' : 'INCOMPLETO');
@endphp
<div class="prod-item" id="item-{{ $item->id }}" style="border-left-color:{{ $lc }};">
    <div class="prod-item-top">
        <div>
            <div class="prod-item-name">{{ $item->product->nombre }}</div>
            <div class="prod-item-sku">
                SKU: {{ $item->product->sku }}
                @if($item->paleta) · {{ $item->paleta }}@endif
                @if($item->ubicacion) · {{ $item->ubicacion }}@endif
            </div>
        </div>
        <span class="prod-item-badge {{ $badgeCls }}">{{ $badgeLbl }}</span>
    </div>
    <div class="prod-item-meta">
        <span>Solicitado: <strong style="color:#f1f5f9;">{{ $item->cantidad_solicitada }}</strong></span>
        <span>Despachado: <strong id="despachado-{{ $item->id }}" style="color:{{ $lc }};">{{ $item->cantidad_despachada }}</strong></span>
        <span style="font-weight:700;color:{{ $lc }};" id="pct-{{ $item->id }}">{{ number_format($pct2,0) }}%</span>
    </div>
    <div class="prod-mini-bar">
        <div class="prod-mini-fill" id="bar-{{ $item->id }}" style="width:{{ $pct2 }}%;background:{{ $lc }};"></div>
    </div>
</div>
@endforeach

</div>

{{-- Cerrar orden --}}
<form method="POST" action="{{ route('orders.cerrar', $order) }}" onsubmit="return confirmarCierre()">
    @csrf
    <button type="submit" class="btn-cerrar">✅ Cerrar orden (aunque esté incompleta)</button>
</form>

</div>
</div>
<!-- =========================================
     MODAL OCTÓGONOS
========================================= -->

<div id="modalOctogonos"
style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.65);
z-index:9999;
justify-content:center;
align-items:center;
">

<div style="
background:white;
width:420px;
max-width:92%;
border-radius:18px;
padding:25px;
text-align:center;
box-shadow:0 20px 40px rgba(0,0,0,.35);
animation:popup .25s;
">

<h2 style="
margin:0;
color:#dc2626;
font-size:24px;
">
⚠ Verificar Etiqueta
</h2>

<div
id="modalProducto"
style="
margin-top:12px;
font-size:18px;
font-weight:bold;
color:#0f172a;
">
Producto
</div>

<div
id="modalAdvertencias"
style="
margin:25px 0;
display:flex;
justify-content:center;
gap:12px;
flex-wrap:wrap;
">

</div>

<div style="
font-size:14px;
color:#475569;
margin-bottom:20px;
">

Verifique que el producto tenga correctamente
los octógonos nutricionales antes de continuar.

</div>

<button
id="btnEntendido"
style="
background:#16a34a;
color:white;
border:none;
padding:12px 35px;
font-size:16px;
border-radius:10px;
cursor:pointer;
font-weight:bold;
">

✔ Entendido

</button>

</div>

</div>


<script>
let detalles = @json($order->details->load('product'));
let scanner  = document.getElementById('scanner');
let activoActual = null;

function showToast(msg, tipo){
    const t = document.getElementById('toast');
    t.className = 'toast show ' + tipo;
    t.textContent = msg;
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.className = 'toast'; }, 2800);
}

function beep(){
    try {
        let ctx = new (window.AudioContext || window.webkitAudioContext)();
        let o = ctx.createOscillator();
        let g = ctx.createGain();
        o.connect(g); g.connect(ctx.destination);
        o.frequency.value = 880;
        o.type = 'sine';
        g.gain.setValueAtTime(0.3, ctx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.15);
        o.start(ctx.currentTime);
        o.stop(ctx.currentTime + 0.15);
    } catch(e){}
}

function actualizarBarra(){
    let total = 0, done = 0, ok = 0, par = 0, inc = 0;
    detalles.forEach(d => {
        total += parseFloat(d.cantidad_solicitada);
        done  += parseFloat(d.cantidad_despachada);
        const pct = parseFloat(d.cantidad_solicitada) > 0
            ? d.cantidad_despachada / d.cantidad_solicitada : 0;
        if(pct >= 1) ok++;
        else if(pct > 0) par++;
        else inc++;
    });
    const pct = total > 0 ? (done / total) * 100 : 0;
    const color = pct >= 100 ? '#22c55e' : (pct > 40 ? '#f59e0b' : '#ef4444');

    document.getElementById('progFill').style.width  = pct + '%';
    document.getElementById('progFill').style.background = color;
    document.getElementById('pctNum').textContent = Math.round(pct) + '%';
    document.getElementById('pctNum').style.color = color;
    document.getElementById('pctDone').textContent = Math.round(done) + ' / ' + Math.round(total);
    document.getElementById('kpiOk').textContent  = ok;
    document.getElementById('kpiPar').textContent = par;
    document.getElementById('kpiInc').textContent = inc;
}

function mostrarActivo(item){
    activoActual = item;
    const pct = item.cantidad_solicitada > 0
        ? (item.cantidad_despachada / item.cantidad_solicitada) * 100 : 0;
    const color = pct >= 100 ? '#22c55e' : (pct > 0 ? '#f59e0b' : '#ef4444');

    document.getElementById('activoNombre').textContent   = item.product.nombre;
    document.getElementById('activoSku').textContent      = item.product.sku ?? '—';
    document.getElementById('activoStock').textContent    = item.product.stock ?? '—';
    document.getElementById('activoPeso').textContent     = item.product.peso
        ? (item.product.peso / 1000).toFixed(3) + ' kg' : '—';
    document.getElementById('activoSolicitado').value     = item.cantidad_solicitada;
    document.getElementById('activoCantidad').value       = item.cantidad_despachada || '';
    document.getElementById('activoPaleta').textContent   = item.paleta    || '—';
    document.getElementById('activoUbicacion').textContent= item.ubicacion || '—';
    document.getElementById('activoVence').textContent    = item.fecha_vencimiento || item.product?.fecha_vencimiento || '—';
    document.getElementById('activoBarFill').style.width  = pct + '%';
    document.getElementById('activoBarFill').style.background = color;
    document.getElementById('activoPctLabel').textContent = Math.round(pct) + '%';
    document.getElementById('activoPctLabel').style.color = color;

    document.getElementById('activoBox').style.display = 'block';
    document.getElementById('activoCantidad').focus();
    document.getElementById('activoCantidad').select();
}

// Update mini bar en lista
function actualizarItemUI(item){
    const pct = item.cantidad_solicitada > 0
        ? (item.cantidad_despachada / item.cantidad_solicitada) * 100 : 0;
    const color = pct >= 100 ? '#22c55e' : (pct > 0 ? '#f59e0b' : '#ef4444');

    const card = document.getElementById('item-' + item.id);
    card.style.borderLeftColor = color;

    const span = document.getElementById('despachado-' + item.id);
    if(span){ span.textContent = item.cantidad_despachada; span.style.color = color; }

    const pctEl = document.getElementById('pct-' + item.id);
    if(pctEl){ pctEl.textContent = Math.round(pct) + '%'; pctEl.style.color = color; }

    const barEl = document.getElementById('bar-' + item.id);
    if(barEl){ barEl.style.width = pct + '%'; barEl.style.background = color; }

    const badge = card.querySelector('.prod-item-badge');
    if(badge){
        badge.className = 'prod-item-badge ' + (pct >= 100 ? 'bc' : (pct > 0 ? 'bp' : 'bi'));
        badge.textContent = pct >= 100 ? 'COMPLETO' : (pct > 0 ? 'PARCIAL' : 'INCOMPLETO');
    }
}

// Scanner principal
scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    const codigo = this.value.trim();
    if(!codigo) return;

    const item = detalles.find(d => d.product.barcode == codigo);
    if(!item){
        showToast('❌ Producto no pertenece a esta orden', 'ter');
        this.value = '';
        return;
    }

    const pct = item.cantidad_solicitada > 0
        ? (item.cantidad_despachada / item.cantidad_solicitada) * 100 : 0;
    if(pct >= 100){
        showToast('⚠ ' + item.product.nombre + ' ya está completo', 'twk');
        this.value = '';
        return;
    }

    // Scroll y highlight en lista
    const card = document.getElementById('item-' + item.id);
    card.scrollIntoView({ behavior:'smooth', block:'center' });
    card.style.boxShadow = '0 0 0 2px #3b82f6';
    setTimeout(() => { card.style.boxShadow = ''; }, 1500);

    mostrarActivo(item);
    showToast('✔ ' + item.product.nombre, 'tok');
    beep();
    this.value = '';
});

// Guardar desde campo cantidad
document.getElementById('activoCantidad').addEventListener('keydown', function(e){
    if(e.key !== 'Enter' || !activoActual) return;
    e.preventDefault();

    const cantidad = parseFloat(this.value);
    if(isNaN(cantidad) || cantidad < 0){
        showToast('⚠ Cantidad inválida', 'twk');
        return;
    }
    if(cantidad > activoActual.cantidad_solicitada){
        showToast('⚠ Supera la cantidad solicitada (' + activoActual.cantidad_solicitada + ')', 'twk');
        return;
    }

    const formData = new FormData();
    formData.append('cantidad_despachada', cantidad);
    formData.append('cantidad_solicitada', activoActual.cantidad_solicitada);
    formData.append('precio_unitario', activoActual.precio_unitario);
    formData.append('_method', 'PUT');
    formData.append('_token', '{{ csrf_token() }}');

    fetch(`/order-details/${activoActual.id}`, {
        method:'POST',
        headers:{ 'Accept':'application/json' },
        body: formData
    })
    .then(res => res.json())
    .then(() => {
        activoActual.cantidad_despachada = cantidad;
        actualizarItemUI(activoActual);
        actualizarBarra();

        const pct = activoActual.cantidad_solicitada > 0
            ? (cantidad / activoActual.cantidad_solicitada) * 100 : 0;

        if(pct >= 100){
            showToast('✅ ' + activoActual.product.nombre + ' completado!', 'tok');
            document.getElementById('activoBox').style.display = 'none';
        } else {
            showToast('💾 Guardado: ' + cantidad + ' de ' + activoActual.cantidad_solicitada, 'tok');
            const color = '#f59e0b';
            document.getElementById('activoBarFill').style.width  = pct + '%';
            document.getElementById('activoBarFill').style.background = color;
            document.getElementById('activoPctLabel').textContent = Math.round(pct) + '%';
        }

        beep();
        activoActual = null;
        scanner.focus();
    })
    .catch(() => {
        showToast('❌ Error al guardar', 'ter');
        scanner.focus();
    });
});

// Mantener foco
setInterval(() => {
    if(document.activeElement !== scanner &&
       document.activeElement !== document.getElementById('activoCantidad')){
        scanner.focus();
    }
}, 800);

function confirmarCierre(){
    const faltantes = detalles.filter(d =>
        parseFloat(d.cantidad_despachada) < parseFloat(d.cantidad_solicitada)
    );
    if(faltantes.length === 0){
        return confirm('✅ Todos los productos están completos.\n\n¿Deseas cerrar la orden?');
    }
    const lista = faltantes.map(d => {
        const f = d.cantidad_solicitada - d.cantidad_despachada;
        return `• ${d.product.nombre} (faltan ${f})`;
    }).join('\n');
    return confirm('⚠️ Hay productos incompletos:\n\n' + lista + '\n\n¿Deseas cerrar la orden de todas formas?');
}

window.onload = () => {
    scanner.focus();
    actualizarBarra();
};
</script>

@endsection
