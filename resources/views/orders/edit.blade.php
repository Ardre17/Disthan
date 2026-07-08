@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.25rem;background:#f1f5f9;min-height:100vh;}
.top-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.1rem;flex-wrap:wrap;gap:10px;}
.hdr-left h1{font-size:20px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.hdr-left p{font-size:12px;color:#94a3b8;margin-top:2px;}
.hdr-right{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.badge-estado{padding:5px 14px;border-radius:99px;font-size:12px;font-weight:700;color:#fff;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1.1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.8rem 1rem;display:flex;align-items:center;gap:10px;}
.kpi-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.kpi-label{font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;}
.kpi-val{font-size:18px;font-weight:700;color:#1e293b;line-height:1.1;}
.main-layout{display:grid;grid-template-columns:1fr 290px;gap:16px;}
@media(max-width:900px){.main-layout{grid-template-columns:1fr;}}
.left-col{display:flex;flex-direction:column;gap:14px;}
.right-col{display:flex;flex-direction:column;gap:12px;}
.scanner-card{background:#0f172a;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:12px;}
.scanner-label{font-size:12px;color:#94a3b8;font-weight:600;margin-bottom:4px;}
.scanner-input{width:100%;padding:10px 14px;font-size:16px;border-radius:8px;border:none;background:#1e293b;color:#f8fafc;outline:none;letter-spacing:1px;}
.scanner-input::placeholder{color:#475569;}
.scanner-input:focus{box-shadow:0 0 0 2px #2563eb;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.3;}}
.section-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;}
.sec-title{font-size:13px;font-weight:600;color:#1e293b;margin-bottom:.85rem;display:flex;align-items:center;gap:7px;}
.import-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.file-label{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:1px dashed #e2e8f0;border-radius:8px;font-size:12px;color:#64748b;cursor:pointer;background:#f8fafc;flex:1;transition:border-color .15s;}
.file-label:hover{border-color:#2563eb;color:#2563eb;}
.add-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:8px;align-items:end;}
@media(max-width:600px){.add-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;}
.prod-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;display:flex;flex-direction:column;gap:.65rem;border-left:4px solid;transition:transform .15s;}
.prod-card:hover{transform:translateY(-2px);}
.prod-top{display:flex;justify-content:space-between;align-items:flex-start;}
.prod-name{font-size:13px;font-weight:700;color:#0f172a;}
.prod-sku{font-size:10px;color:#94a3b8;margin-top:1px;}
.prod-badge{font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}
.info-strip{display:grid;grid-template-columns:1fr 1fr;gap:5px;background:#f8fafc;border-radius:8px;padding:7px 9px;}
.info-item{font-size:11px;color:#64748b;display:flex;align-items:center;gap:4px;}
.info-val{font-weight:600;color:#374151;}
.prog-mini{width:100%;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-mini-fill{height:100%;border-radius:99px;}
.fields-box{background:#f8fafc;border-radius:8px;padding:9px 10px;display:flex;flex-direction:column;gap:7px;}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:7px;}
.paleta-input{width:100%;padding:10px 14px;font-size:17px;border:2px solid #2563eb;border-radius:9px;text-align:center;font-weight:700;letter-spacing:3px;outline:none;background:#fff;transition:box-shadow .15s;}
.paleta-input:focus{box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.subtotal-row{display:flex;justify-content:space-between;align-items:center;}
.subtotal-val{font-size:14px;font-weight:700;color:#0f172a;}
.btn-row-prod{display:grid;grid-template-columns:1fr auto;gap:7px;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:5px;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-green{background:#16a34a;color:#fff;}
.btn-blue{background:#2563eb;color:#fff;}
.btn-gray{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.btn-red{background:#dc2626;color:#fff;}
.resumen-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem;}
.resumen-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:#64748b;padding:5px 0;border-bottom:1px solid #f1f5f9;}
.resumen-row:last-child{border:none;}
.resumen-val{font-weight:600;color:#1e293b;}
.resumen-total-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;margin-top:4px;}
.prog-resumen{padding:10px;background:#f8fafc;border-radius:9px;}
.prog-label{display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;}
.prog-bar{width:100%;height:7px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}
.legend{display:flex;flex-direction:column;gap:5px;margin-top:4px;}
.leg-row{display:flex;justify-content:space-between;align-items:center;font-size:12px;}
.leg-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-right:5px;display:inline-block;}

/* ══════════════════════════════
   MAPA DE PALETAS
══════════════════════════════ */
.paleta-map-card {
    background:#fff; border:1px solid #e2e8f0;
    border-radius:12px; overflow:hidden;
}
.paleta-map-header {
    background:#0f172a; padding:10px 14px;
    display:flex; align-items:center; justify-content:space-between;
}
.paleta-map-title {
    font-size:12px; font-weight:700; color:#f8fafc;
    display:flex; align-items:center; gap:7px;
}
.paleta-map-body { padding:12px; }

.paleta-map-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(110px,1fr));
    gap:8px;
}

/* Cada caja de paleta en el mapa */
.paleta-box {
    border-radius:10px; border:2px solid transparent;
    padding:10px 8px; text-align:center;
    cursor:pointer; transition:transform .15s, box-shadow .15s;
    position:relative; user-select:none;
}
.paleta-box:hover {
    transform:translateY(-3px);
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}
.paleta-box.estado-completo  { background:#dcfce7; border-color:#86efac; }
.paleta-box.estado-parcial   { background:#fef3c7; border-color:#fde68a; }
.paleta-box.estado-incompleto{ background:#fee2e2; border-color:#fca5a5; }
.paleta-box.estado-vacia     { background:#f8fafc; border-color:#e2e8f0; }

.paleta-box-icon  { font-size:22px; margin-bottom:4px; }
.paleta-box-name  { font-size:12px; font-weight:800; color:#0f172a; }
.paleta-box-items { font-size:10px; color:#64748b; margin-top:2px; }
.paleta-box-pct   { font-size:11px; font-weight:700; margin-top:3px; }
.paleta-box-bar   { height:4px; border-radius:99px; background:#e5e7eb; overflow:hidden; margin-top:5px; }
.paleta-box-fill  { height:100%; border-radius:99px; }

/* Sin paleta chip */
.no-paleta-chip {
    display:flex; align-items:center; justify-content:space-between;
    background:#fff8f0; border:1px dashed #fed7aa;
    border-radius:8px; padding:7px 10px; font-size:12px;
    color:#92400e; margin-top:8px; cursor:pointer;
    transition:background .15s;
}
.no-paleta-chip:hover { background:#fef3e2; }

/* ══════════════════════════════
   MODAL DE DETALLE
══════════════════════════════ */
.pm-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.45); z-index:1000;
    align-items:center; justify-content:center; padding:16px;
}
.pm-overlay.open { display:flex; }
.pm-modal {
    background:#fff; border-radius:14px;
    width:480px; max-width:100%; max-height:90vh;
    overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.2);
    animation:mIn .16s ease;
}
@keyframes mIn{from{transform:scale(.95);opacity:0}to{transform:scale(1);opacity:1}}
.pm-header {
    padding:14px 18px; display:flex; align-items:center;
    justify-content:space-between; border-bottom:1px solid #f1f5f9;
    position:sticky; top:0; background:#fff; z-index:1;
}
.pm-title  { font-size:15px; font-weight:700; color:#0f172a; }
.pm-sub    { font-size:11px; color:#94a3b8; margin-top:2px; }
.pm-body   { padding:16px 18px; }
.pm-close  { background:none; border:none; font-size:20px; cursor:pointer; color:#94a3b8; padding:2px 6px; }

.pm-kpis { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-bottom:14px; }
.pm-kpi  {
    background:#f8fafc; border-radius:9px; padding:8px 10px;
    text-align:center; border:1px solid #e2e8f0;
}
.pm-kpi-label { font-size:10px; color:#94a3b8; font-weight:600; text-transform:uppercase; }
.pm-kpi-val   { font-size:17px; font-weight:700; color:#1e293b; margin-top:2px; }

.pm-prog-wrap { background:#f8fafc; border-radius:9px; padding:10px 12px; margin-bottom:14px; }
.pm-prog-hdr  { display:flex; justify-content:space-between; font-size:11px; color:#64748b; margin-bottom:5px; }
.pm-prog-bar  { height:8px; background:#e5e7eb; border-radius:99px; overflow:hidden; }
.pm-prog-fill { height:100%; border-radius:99px; }

.pm-item {
    display:flex; align-items:center; gap:10px;
    padding:9px 0; border-bottom:1px solid #f1f5f9;
}
.pm-item:last-child { border-bottom:none; }
.pm-item-dot  { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
.pm-item-name { flex:1; font-size:12px; font-weight:500; color:#374151; }
.pm-item-right{ display:flex; align-items:center; gap:8px; flex-shrink:0; }
.pm-item-qty  { font-size:12px; font-weight:700; color:#0f172a; }
.pm-item-badge{ font-size:10px; font-weight:700; padding:2px 7px; border-radius:99px; }
</style>

<div class="pg">

{{-- ── Header ── --}}
@php
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d'
                 : ($order->estado === 'PARCIAL'  ? '#b45309' : '#b91c1c');
    $totalItems  = $order->details->count();
    $completados = $order->details->where('estado_item','COMPLETO')->count();
    $faltantes   = $totalItems - $completados;
    $porcentaje  = $totalItems > 0 ? round(($completados / $totalItems) * 100) : 0;
    $progColor   = $porcentaje === 100 ? '#22c55e' : ($porcentaje > 40 ? '#f59e0b' : '#ef4444');

    // ── Preparar datos de paletas para el mapa ──────────────────────────
    $paletas = $order->details
        ->filter(fn($d) => !empty($d->paleta))
        ->groupBy('paleta')
        ->sortKeys();

    $sinPaleta = $order->details->filter(fn($d) => empty($d->paleta));
@endphp

<div class="top-hdr">
    <div class="hdr-left">
        <h1>📋 {{ $order->numero_orden }}</h1>
        <p>{{ $order->client?->razon_social }}</p>
    </div>
    <div class="hdr-right">
        <span class="badge-estado" style="background:{{ $estadoColor }};">{{ $order->estado }}</span>
        <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="btn btn-green">📄 Ver PDF</a>
        <a href="{{ route('orders.pdf',$order) }}" class="btn btn-blue">⬇ Descargar</a>
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi">
        <div class="kpi-icon" style="background:#eff6ff;color:#2563eb;">🗂</div>
        <div><div class="kpi-label">Productos</div><div class="kpi-val">{{ $totalItems }}</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#dcfce7;color:#15803d;">✅</div>
        <div><div class="kpi-label">Completados</div><div class="kpi-val" style="color:#15803d;">{{ $completados }}</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#fee2e2;color:#b91c1c;">⚠️</div>
        <div><div class="kpi-label">Faltantes</div><div class="kpi-val" style="color:#b91c1c;">{{ $faltantes }}</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#dcfce7;color:#15803d;">💰</div>
        <div><div class="kpi-label">Total</div><div class="kpi-val" style="font-size:14px;color:#15803d;">S/ {{ number_format($order->total,2) }}</div></div>
    </div>
</div>

{{-- ── Layout ── --}}
<div class="main-layout">
<div class="left-col">

    {{-- Scanner --}}
    <div class="scanner-card">
        <div style="width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse 1.5s infinite;"></div>
        <div style="flex:1;">
            <div class="scanner-label">📡 Escanear código de barras</div>
            <input type="text" id="scanner" class="scanner-input" placeholder="Escanea o escribe el código..." autofocus>
        </div>
        <div style="font-size:10px;color:#475569;text-align:right;white-space:nowrap;">Enter para<br>confirmar</div>
    </div>

    {{-- Importar CSV --}}
    <div class="section-card">
        <div class="sec-title">📄 Importar pedido CSV</div>
        <form action="{{ route('orders.import',$order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="import-row">
                <label class="file-label">
                    📎 Seleccionar archivo .csv
                    <input type="file" name="archivo" accept=".csv" required style="display:none;">
                </label>
                <button type="submit" class="btn btn-green">Importar</button>
            </div>
        </form>
    </div>

    {{-- Agregar producto --}}
    <div class="section-card">
        <div class="sec-title">➕ Agregar producto</div>
        <form method="POST" action="{{ route('orders.addProduct',$order) }}">
            @csrf
            <div class="add-grid">
                <div>
                    <label class="flabel">Producto</label>
                    <select name="product_id" class="finput" required>
                        <option value="">Seleccionar producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="flabel">Cantidad</label>
                    <input type="number" name="cantidad_solicitada" class="finput" placeholder="0" required>
                </div>
                <div>
                    <label class="flabel">Precio</label>
                    <input type="number" step="0.01" name="precio_unitario" class="finput" placeholder="0.00" required>
                </div>
                <button type="submit" class="btn btn-red" style="align-self:end;">Agregar</button>
            </div>
        </form>
    </div>

    {{-- Productos --}}
    <div class="products-grid">
        @foreach($order->details as $detail)
        @php
            $s  = $detail->estado_item;
            $bc = $s === 'COMPLETO' ? '#22c55e' : ($s === 'PARCIAL' ? '#f59e0b' : '#ef4444');
            $sc = $s === 'COMPLETO' ? '#15803d' : ($s === 'PARCIAL' ? '#b45309' : '#b91c1c');
            $bg = $s === 'COMPLETO' ? '#dcfce7' : ($s === 'PARCIAL' ? '#fef3c7' : '#fee2e2');
            $badgeCls = $s === 'COMPLETO' ? 'bc' : ($s === 'PARCIAL' ? 'bp' : 'bi');
            $pct = $detail->cantidad_solicitada > 0
                 ? round(($detail->cantidad_despachada / $detail->cantidad_solicitada) * 100)
                 : 0;
        @endphp

        <div class="prod-card"
                id="producto-{{ $detail->product->barcode }}"
                data-barcode="{{ $detail->product->barcode }}"
                data-box-barcode="{{ $detail->product->box_barcode }}">
             style="border-left-color:{{ $bc }};">
            <div class="prod-top">
                <div>
                    <div class="prod-name">📦 {{ $detail->product->nombre }}</div>
                    <div class="prod-sku">SKU: {{ $detail->product->sku }}</div>
                </div>
                <span class="prod-badge {{ $badgeCls }}">{{ $s }}</span>
            </div>
            <div class="info-strip">
                <div class="info-item">📦 Stock: <span class="info-val">{{ $detail->product->stock }}</span></div>
                <div class="info-item">⚖ <span class="info-val">{{ number_format($detail->product->peso/1000,3) }} kg</span></div>
                <div class="info-item" style="grid-column:1/-1;gap:6px;">
                    <span style="font-size:10px;color:#94a3b8;white-space:nowrap;">Despacho:</span>
                    <div class="prog-mini" style="flex:1;"><div class="prog-mini-fill" style="width:{{ $pct }}%;background:{{ $bc }};"></div></div>
                    <span style="font-size:10px;font-weight:700;color:{{ $sc }};margin-left:2px;">{{ $pct }}%</span>
                </div>
            </div>
            <form method="POST" action="{{ route('orders.updateDetail',$detail) }}">
                @csrf @method('PUT')
                <div class="fields-box">
                    <div class="field-row">
                        <div><label class="flabel">Solicitado</label>
                            <input type="number" step="0.01" name="cantidad_solicitada" class="finput" value="{{ $detail->cantidad_solicitada }}"></div>
                        <div><label class="flabel">Despachado</label>
                            <input type="number" step="0.01" name="cantidad_despachada" id="despachado-{{ $detail->product->barcode }}" class="finput" value="{{ $detail->cantidad_despachada }}"></div>
                    </div>
                    <div><label class="flabel">Precio</label>
                        <input type="number" step="0.01" name="precio_unitario" class="finput" value="{{ $detail->precio_unitario }}"></div>
                    <hr class="dv">
                    <div><label class="flabel">Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="finput" value="{{ $detail->fecha_vencimiento ?? $detail->product->fecha_vencimiento }}"></div>
                    <div class="field-row">
                        <div><label class="flabel">Nivel</label>
                            <input type="number" name="nivel" class="finput" value="{{ $detail->nivel }}"></div>
                        <div><label class="flabel">Ubicación</label>
                            <input type="text" name="ubicacion" class="finput" value="{{ $detail->ubicacion }}"></div>
                    </div>
                </div>
                <div style="margin-top:7px;">
                    <label class="flabel">Paleta</label>
                    <input type="text" name="paleta" class="paleta-input"
                        value="{{ $detail->paleta }}" placeholder="P01"
                        oninput="this.value=this.value.toUpperCase()">
                </div>
                <div class="subtotal-row" style="margin-top:7px;">
                    <span style="font-size:11px;color:#64748b;">Subtotal</span>
                    <span class="subtotal-val">S/ {{ number_format($detail->cantidad_despachada * $detail->precio_unitario,2) }}</span>
                </div>
                <div class="btn-row-prod" style="margin-top:7px;">
                    <button type="submit" class="btn btn-blue" style="width:100%;">💾 Guardar</button>
                </div>
            </form>
            <form method="POST" action="{{ route('orders.details.destroy',$detail) }}"
                onsubmit="return confirm('¿Eliminar {{ $detail->product->nombre }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-red" style="width:100%;margin-top:4px;">🗑 Eliminar</button>
            </form>
        </div>
        @endforeach
    </div>

</div>{{-- /.left-col --}}

{{-- ── Right col ── --}}
<div class="right-col">

    {{-- ══════════════════════════════════════════
         MAPA DE PALETAS
    ══════════════════════════════════════════ --}}
    <div class="paleta-map-card">
        <div class="paleta-map-header">
            <div class="paleta-map-title">
                🪵 Mapa de paletas
                <span style="background:#1e293b;color:#94a3b8;font-size:10px;padding:2px 8px;border-radius:99px;">
                    {{ $paletas->count() }} paleta{{ $paletas->count() !== 1 ? 's' : '' }}
                </span>
            </div>
            <span style="font-size:10px;color:#475569;">Clic para ver detalle</span>
        </div>

        <div class="paleta-map-body">

            @if($paletas->isEmpty() && $sinPaleta->isEmpty())
                <div style="text-align:center;padding:24px 0;color:#94a3b8;font-size:12px;">
                    <div style="font-size:28px;margin-bottom:6px;">🪵</div>
                    Sin paletas asignadas aún
                </div>
            @else

            <div class="paleta-map-grid">
            @foreach($paletas as $nombrePaleta => $items)
            @php
                $totUds  = $items->sum('cantidad_solicitada');
                $despUds = $items->sum('cantidad_despachada');
                $pesoKg  = $items->sum(fn($i) => ($i->product->peso ?? 0) * $i->cantidad_solicitada / 1000);
                $pctP    = $totUds > 0 ? round(($despUds / $totUds) * 100) : 0;
                $todoC   = $items->every(fn($i) => $i->estado_item === 'COMPLETO');
                $algunP  = $items->contains(fn($i) => $i->estado_item === 'PARCIAL');
                $estClass = $todoC ? 'estado-completo' : ($algunP ? 'estado-parcial' : 'estado-incompleto');
                $pctColor = $todoC ? '#15803d' : ($algunP ? '#b45309' : '#b91c1c');
                $fillColor= $todoC ? '#22c55e' : ($algunP ? '#f59e0b' : '#ef4444');
                $icon     = $todoC ? '✅' : ($algunP ? '⏳' : '⚠️');

                // Serializar items para el modal
                $itemsJson = $items->map(fn($i) => [
                    'nombre'   => $i->product->nombre ?? 'Producto',
                    'sku'      => $i->product->sku ?? '',
                    'solicitada'=> $i->cantidad_solicitada,
                    'despachada'=> $i->cantidad_despachada,
                    'estado'   => $i->estado_item,
                    'precio'   => $i->precio_unitario,
                    'subtotal' => $i->subtotal,
                    'peso'     => number_format(($i->product->peso ?? 0) / 1000, 3),
                ])->values()->toJson();
            @endphp

            <div class="paleta-box {{ $estClass }}"
                onclick="abrirPaleta({{ json_encode($nombrePaleta) }}, {{ $items->count() }}, {{ $totUds }}, {{ $despUds }}, {{ round($pesoKg,1) }}, {{ $pctP }}, {{ json_encode($fillColor) }}, {{ $itemsJson }})">
                <div class="paleta-box-icon">🪵</div>
                <div class="paleta-box-name">{{ $nombrePaleta }}</div>
                <div class="paleta-box-items">{{ $items->count() }} ítem{{ $items->count() > 1 ? 's' : '' }}</div>
                <div class="paleta-box-pct" style="color:{{ $pctColor }};">{{ $icon }} {{ $pctP }}%</div>
                <div class="paleta-box-bar">
                    <div class="paleta-box-fill" style="width:{{ $pctP }}%;background:{{ $fillColor }};"></div>
                </div>
            </div>
            @endforeach
            </div>

            {{-- Sin paleta --}}
            @if($sinPaleta->count())
            @php
                $spJson = $sinPaleta->map(fn($i) => [
                    'nombre'    => $i->product->nombre ?? 'Producto',
                    'sku'       => $i->product->sku ?? '',
                    'solicitada'=> $i->cantidad_solicitada,
                    'despachada'=> $i->cantidad_despachada,
                    'estado'    => $i->estado_item,
                    'precio'    => $i->precio_unitario,
                    'subtotal'  => $i->subtotal,
                    'peso'      => number_format(($i->product->peso ?? 0) / 1000, 3),
                ])->values()->toJson();
            @endphp
            <div class="no-paleta-chip"
                onclick="abrirPaleta('Sin paleta', {{ $sinPaleta->count() }}, {{ $sinPaleta->sum('cantidad_solicitada') }}, {{ $sinPaleta->sum('cantidad_despachada') }}, 0, 0, '#94a3b8', {{ $spJson }})">
                <span>⚠️ Sin paleta asignada</span>
                <span style="font-weight:700;">{{ $sinPaleta->count() }} ítem{{ $sinPaleta->count() > 1 ? 's' : '' }} →</span>
            </div>
            @endif

            @endif
        </div>
    </div>

    {{-- Resumen financiero --}}
    <div class="resumen-card">
        <div class="sec-title">📊 Resumen</div>
        <hr class="dv" style="margin-bottom:8px;">
        <div class="resumen-row"><span>Productos</span><span class="resumen-val">{{ $order->details->count() }}</span></div>
        <div class="resumen-row"><span>Subtotal</span><span class="resumen-val">S/ {{ number_format($order->subtotal,2) }}</span></div>
        <div class="resumen-row"><span>IGV (18%)</span><span class="resumen-val">S/ {{ number_format($order->igv,2) }}</span></div>
        <div class="resumen-total-row">
            <span style="font-size:14px;font-weight:700;color:#0f172a;">Total</span>
            <span style="font-size:18px;font-weight:700;color:#15803d;">S/ {{ number_format($order->total,2) }}</span>
        </div>
    </div>

    {{-- Progreso --}}
    <div class="resumen-card">
        <div class="sec-title">📈 Progreso de despacho</div>
        <div class="prog-resumen">
            <div class="prog-label"><span>Completado</span><span style="font-weight:700;color:{{ $progColor }};">{{ $porcentaje }}%</span></div>
            <div class="prog-bar"><div class="prog-fill" style="width:{{ $porcentaje }}%;background:{{ $progColor }};"></div></div>
            <div style="font-size:10px;color:#94a3b8;margin-top:3px;">{{ $completados }} de {{ $totalItems }} productos</div>
        </div>
        <hr class="dv" style="margin:8px 0;">
        @php
            $parciales2   = $order->details->where('estado_item','PARCIAL')->count();
            $incompletos2 = $order->details->where('estado_item','INCOMPLETO')->count();
        @endphp
        <div class="legend">
            <div class="leg-row"><div style="display:flex;align-items:center;"><span class="leg-dot" style="background:#22c55e;"></span><span style="font-size:12px;color:#64748b;">Completo</span></div><span style="font-size:12px;font-weight:700;color:#15803d;">{{ $completados }}</span></div>
            <div class="leg-row"><div style="display:flex;align-items:center;"><span class="leg-dot" style="background:#f59e0b;"></span><span style="font-size:12px;color:#64748b;">Parcial</span></div><span style="font-size:12px;font-weight:700;color:#b45309;">{{ $parciales2 }}</span></div>
            <div class="leg-row"><div style="display:flex;align-items:center;"><span class="leg-dot" style="background:#ef4444;"></span><span style="font-size:12px;color:#64748b;">Incompleto</span></div><span style="font-size:12px;font-weight:700;color:#b91c1c;">{{ $incompletos2 }}</span></div>
        </div>
    </div>

    {{-- Info orden --}}
    <div class="resumen-card">
        <div class="sec-title">ℹ️ Info de la orden</div>
        <div class="resumen-row"><span>Fecha</span><span class="resumen-val">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}</span></div>
        <div class="resumen-row"><span>Tipo</span><span class="resumen-val">{{ $order->tipo_orden }}</span></div>
        <div class="resumen-row"><span>Cliente</span><span class="resumen-val" style="font-size:11px;max-width:140px;text-align:right;">{{ $order->client?->razon_social }}</span></div>
        <div class="resumen-row"><span>Estado</span><span style="font-size:11px;font-weight:700;color:{{ $estadoColor }};">{{ $order->estado }}</span></div>
    </div>

</div>{{-- /.right-col --}}
</div>{{-- /.main-layout --}}
</div>{{-- /.pg --}}

{{-- ══════════════════════════════
     MODAL DETALLE DE PALETA
══════════════════════════════ --}}
<div class="pm-overlay" id="pmOverlay" onclick="cerrarPaleta(event)">
    <div class="pm-modal">
        <div class="pm-header">
            <div>
                <div class="pm-title" id="pmTitle"></div>
                <div class="pm-sub"  id="pmSub"></div>
            </div>
            <button class="pm-close" onclick="document.getElementById('pmOverlay').classList.remove('open')">✕</button>
        </div>
        <div class="pm-body">

            {{-- Mini KPIs --}}
            <div class="pm-kpis">
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Ítems</div>
                    <div class="pm-kpi-val" id="pmItems"></div>
                </div>
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Unidades</div>
                    <div class="pm-kpi-val" id="pmUds"></div>
                </div>
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Peso total</div>
                    <div class="pm-kpi-val" id="pmPeso"></div>
                </div>
            </div>

            {{-- Progreso --}}
            <div class="pm-prog-wrap">
                <div class="pm-prog-hdr">
                    <span>Progreso de despacho</span>
                    <span id="pmPct" style="font-weight:700;"></span>
                </div>
                <div class="pm-prog-bar">
                    <div class="pm-prog-fill" id="pmProgFill"></div>
                </div>
                <div style="font-size:10px;color:#94a3b8;margin-top:3px;" id="pmProgSub"></div>
            </div>

            {{-- Lista de productos --}}
            <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Productos en esta paleta</div>
            <div id="pmItemsList"></div>

        </div>
    </div>
</div>

<script>
// ── Scanner ──────────────────────────────────────────────────────────────
let scanner = document.getElementById('scanner');
scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    let codigo = this.value.trim();
    if(!codigo) return;
    let card = document.querySelector(
    '[data-barcode="' + codigo + '"], [data-box-barcode="' + codigo + '"]');
    if(card){
        card.scrollIntoView({ behavior:'smooth', block:'center' });
        card.style.boxShadow = "0 0 0 3px #2563eb";
        setTimeout(() => { card.style.boxShadow = ""; }, 1500);
        let barcode = card.dataset.barcode;
        let input = document.getElementById('despachado-' + barcode);
        if(input){ input.focus(); input.select(); }
        this.value = '';
        return;
    }
    fetch(`/api/producto/${codigo}`)
    .then(res => res.json())
    .then(producto => {
        if(!producto){ alert('Producto no encontrado'); return; }
        let select = document.querySelector('[name=product_id]');
        select.value = producto.id;
        document.querySelector('[name=precio_unitario]').value = producto.precio ?? 0;
        document.querySelector('[name=cantidad_solicitada]').focus();
    });
    this.value = '';
});

// ── Modal de paleta ──────────────────────────────────────────────────────
function abrirPaleta(nombre, nItems, totUds, despUds, pesoKg, pct, fillColor, items) {
    document.getElementById('pmTitle').textContent   = '🪵 ' + nombre;
    document.getElementById('pmSub').textContent     = 'Detalle de contenido · ' + nItems + ' ítem' + (nItems !== 1 ? 's' : '');
    document.getElementById('pmItems').textContent   = nItems;
    document.getElementById('pmUds').textContent     = totUds;
    document.getElementById('pmPeso').textContent    = pesoKg + ' kg';
    document.getElementById('pmPct').textContent     = pct + '%';
    document.getElementById('pmPct').style.color     = fillColor;
    document.getElementById('pmProgFill').style.width      = pct + '%';
    document.getElementById('pmProgFill').style.background = fillColor;
    document.getElementById('pmProgSub').textContent = despUds + ' de ' + totUds + ' unidades despachadas';

    const estadoColors = {
        'COMPLETO'  : { bg:'#dcfce7', color:'#15803d', dot:'#22c55e' },
        'PARCIAL'   : { bg:'#fef3c7', color:'#b45309', dot:'#f59e0b' },
        'INCOMPLETO': { bg:'#fee2e2', color:'#b91c1c', dot:'#ef4444' },
    };

    let html = '';
    items.forEach(item => {
        const ec = estadoColors[item.estado] ?? { bg:'#f1f5f9', color:'#64748b', dot:'#94a3b8' };
        const itemPct = item.solicitada > 0 ? Math.round((item.despachada / item.solicitada) * 100) : 0;
        html += `
        <div class="pm-item">
            <div class="pm-item-dot" style="background:${ec.dot};"></div>
            <div class="pm-item-name">
                <div style="font-weight:600;">${item.nombre}</div>
                <div style="font-size:10px;color:#94a3b8;">${item.sku ? 'SKU: '+item.sku+' · ' : ''}${item.peso} kg · S/ ${parseFloat(item.precio).toFixed(2)}</div>
                <div style="height:3px;background:#e5e7eb;border-radius:99px;margin-top:4px;overflow:hidden;">
                    <div style="height:100%;width:${itemPct}%;background:${ec.dot};border-radius:99px;"></div>
                </div>
            </div>
            <div class="pm-item-right">
                <div class="pm-item-qty">${item.despachada}/${item.solicitada}</div>
                <span class="pm-item-badge" style="background:${ec.bg};color:${ec.color};">${item.estado}</span>
            </div>
        </div>`;
    });

    document.getElementById('pmItemsList').innerHTML = html;
    document.getElementById('pmOverlay').classList.add('open');
}

function cerrarPaleta(e) {
    if(e.target.id === 'pmOverlay')
        document.getElementById('pmOverlay').classList.remove('open');
}
</script>

@endsection