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
.scanner-pulse{width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse 1.5s infinite;}
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

        <div class="prod-card" id="producto-{{ $detail->product->barcode }}"
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
                @csrf
                @method('PUT')

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
                    <span class="subtotal-val">S/ {{ number_format($detail->subtotal,2) }}</span>
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

</div>

{{-- ── Right col ── --}}
<div class="right-col">

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

</div>
</div>

</div>

<script>
let scanner = document.getElementById('scanner');

scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    let codigo = this.value.trim();
    if(!codigo) return;

    let card = document.getElementById('producto-' + codigo);
    if(card){
        card.scrollIntoView({ behavior:'smooth', block:'center' });
        card.style.boxShadow = "0 0 0 3px #2563eb";
        setTimeout(() => { card.style.boxShadow = ""; }, 1500);
        let input = document.getElementById('despachado-' + codigo);
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
</script>

@endsection