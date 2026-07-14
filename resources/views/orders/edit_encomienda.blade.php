@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.1rem;background:#f1f5f9;min-height:100vh;}
.top-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.hdr-left h1{font-size:18px;font-weight:700;color:#0f172a;}
.hdr-left p{font-size:12px;color:#94a3b8;margin-top:2px;}
.hdr-right{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.estado-badge{padding:4px 12px;border-radius:99px;font-size:11px;font-weight:700;}
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.7rem .9rem;display:flex;align-items:center;gap:9px;}
.kpi-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.kpi-val{font-size:17px;font-weight:700;color:#1e293b;line-height:1;}
.kpi-label{font-size:10px;color:#94a3b8;margin-top:1px;text-transform:uppercase;letter-spacing:.05em;}
.prog-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:.9rem 1.1rem;margin-bottom:1rem;}
.prog-top{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:.5rem;}
.prog-pct{font-size:26px;font-weight:800;line-height:1;}
.prog-track{width:100%;height:14px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;transition:width .5s;}
.alert-box{padding:9px 14px;border-radius:8px;font-size:13px;font-weight:500;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
.alert-err{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.alert-ok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
.scanner-wrap{background:#0f172a;border-radius:10px;padding:.85rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:10px;}
.scanner-pulse{width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse 1.4s infinite;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.3;}}
.scanner-input{flex:1;padding:9px 14px;font-size:15px;border-radius:8px;border:2px solid #334155;background:#1e293b;color:#f8fafc;outline:none;letter-spacing:1px;transition:border-color .2s;}
.scanner-input:focus{border-color:#3b82f6;}
.scanner-input::placeholder{color:#475569;font-size:12px;letter-spacing:0;}
.layout{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}
.sec-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem 1.1rem;}
.sec-title{font-size:13px;font-weight:600;color:#1e293b;margin-bottom:.85rem;display:flex;align-items:center;justify-content:space-between;}
.sec-title-left{display:flex;align-items:center;gap:6px;}
.add-form-box{background:#f8fafc;border-radius:9px;padding:.75rem;margin-bottom:.85rem;border:1px solid #e2e8f0;}
.add-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:7px;align-items:end;}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.1);}
.prod-item{border:1px solid #e2e8f0;border-radius:10px;padding:.8rem 1rem;margin-bottom:8px;border-left:4px solid;transition:transform .15s;}
.prod-item:hover{transform:translateX(2px);}
.prod-item-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;}
.prod-name{font-size:13px;font-weight:600;color:#0f172a;}
.prod-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.prod-counter{font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;}
.mini-bar{width:100%;height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin:5px 0;}
.mini-fill{height:100%;border-radius:99px;transition:width .4s;}
.prod-meta{display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#64748b;}
.falt-tag{font-size:10px;font-weight:700;color:#b91c1c;background:#fee2e2;padding:1px 7px;border-radius:99px;}
.peso-highlight{font-size:10px;font-weight:700;color:#1d4ed8;background:#eff6ff;padding:1px 7px;border-radius:99px;}
.prod-inputs{display:flex;gap:6px;align-items:center;margin-top:6px;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:4px;padding:7px 12px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-green{background:#16a34a;color:#fff;}
.btn-blue{background:#2563eb;color:#fff;}
.btn-red{background:#dc2626;color:#fff;}
.btn-gray{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.bultos-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;}
.bulto-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:.9rem;border-top:4px solid #2563eb;display:flex;flex-direction:column;gap:.6rem;}
.bulto-hdr{display:flex;justify-content:space-between;align-items:center;}
.bulto-name{font-size:14px;font-weight:700;color:#0f172a;}
.peso-badge{display:flex;align-items:center;gap:4px;font-size:12px;font-weight:700;background:#eff6ff;color:#1d4ed8;padding:3px 9px;border-radius:99px;border:1px solid #bfdbfe;}
.peso-badge.heavy{background:#fef3c7;color:#b45309;border-color:#fde68a;}
.bulto-item{display:flex;justify-content:space-between;align-items:center;font-size:11px;padding:4px 6px;background:#f8fafc;border-radius:6px;}
.bulto-item-qty{font-weight:700;color:#1d4ed8;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}
.nuevo-bulto-btn{border:2px dashed #e2e8f0;border-radius:12px;display:flex;align-items:center;justify-content:center;min-height:100px;cursor:pointer;transition:border-color .2s;background:transparent;width:100%;color:#94a3b8;font-size:12px;flex-direction:column;gap:4px;}
.nuevo-bulto-btn:hover{border-color:#2563eb;color:#2563eb;}
.crear-bulto-row{display:flex;align-items:center;gap:8px;margin-bottom:.75rem;}
</style>

<div class="pg">

{{-- ── Alertas de sesión ── --}}
@if(session('error'))
<div class="alert-box alert-err">⚠️ {{ session('error') }}</div>
@endif
@if(session('success'))
<div class="alert-box alert-ok">✅ {{ session('success') }}</div>
@endif

{{-- ── Header ── --}}
@php
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d' : '#b45309';
    $estadoBg    = $order->estado === 'COMPLETO' ? '#dcfce7' : '#fef3c7';

    // Totales globales
    $totalUnidades = $order->details->sum('cantidad_solicitada');
    $totalEnBultos = 0;
    foreach($order->details as $item){
        foreach($order->bultos as $b){
            foreach($b->detalles as $d){
                if($d->product_id == $item->product_id)
                    $totalEnBultos += $d->cantidad;
            }
        }
    }
    $porcentajeGlobal = $totalUnidades > 0 ? ($totalEnBultos / $totalUnidades) * 100 : 0;
    $progColor = $porcentajeGlobal >= 100 ? '#22c55e' : ($porcentajeGlobal > 40 ? '#f59e0b' : '#ef4444');

    // Peso total de todos los bultos
    $pesoTotal = $order->bultos->sum('peso_total');

    // Conteos de estados de items
    $itemsCompletos = 0; $itemsParciales = 0; $itemsPendientes = 0;
    foreach($order->details as $item){
        $enB = 0;
        foreach($order->bultos as $b)
            foreach($b->detalles as $d)
                if($d->product_id == $item->product_id) $enB += $d->cantidad;
        if($enB >= $item->cantidad_solicitada) $itemsCompletos++;
        elseif($enB > 0) $itemsParciales++;
        else $itemsPendientes++;
    }
@endphp

<div class="top-hdr">
    <div class="hdr-left">
        <h1>🚚 Encomienda — {{ $order->numero_orden }}</h1>
        <p>Cliente: {{ $order->client->razon_social ?? '' }}</p>
    </div>
    <div class="hdr-right">
        <span class="estado-badge" style="color:{{ $estadoColor }};background:{{ $estadoBg }};">
            {{ $order->estado === 'COMPLETO' ? '✅' : '⏳' }} {{ $order->estado }}
        </span>
        @if($order->tipo_orden == 'ENCOMIENDA' && $order->estado != 'COMPLETO')
        <form method="POST" action="{{ route('orders.cerrar', $order) }}"
              onsubmit="return confirmarCierre()" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-green">✅ Cerrar Encomienda</button>
        </form>
        @endif
                <a
            href="{{ route('orders.pdfEncomienda',$order) }}"
            target="_blank"
            class="btn btn-red">

            📄 PDF Cliente

        </a>
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi">
        <div class="kpi-icon" style="background:#eff6ff;color:#2563eb;">📋</div>
        <div><div class="kpi-val">{{ $order->details->count() }}</div><div class="kpi-label">Productos</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#dcfce7;color:#15803d;">✅</div>
        <div><div class="kpi-val" style="color:#15803d;">{{ $itemsCompletos }}</div><div class="kpi-label">Embalados</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#fee2e2;color:#b91c1c;">⚠️</div>
        <div><div class="kpi-val" style="color:#b91c1c;">{{ $itemsPendientes + $itemsParciales }}</div><div class="kpi-label">Pendientes</div></div>
    </div>
    <div class="kpi">
        <div class="kpi-icon" style="background:#eff6ff;color:#1d4ed8;">📦</div>
        <div><div class="kpi-val">{{ $order->bultos->count() }}</div><div class="kpi-label">Bultos</div></div>
    </div>
    <div class="kpi" style="border-color:#bfdbfe;background:#eff6ff;">
        <div class="kpi-icon" style="background:#dbeafe;color:#1d4ed8;">⚖</div>
        <div><div class="kpi-val" style="color:#1d4ed8;">{{ number_format($pesoTotal,1) }} kg</div><div class="kpi-label">Peso total</div></div>
    </div>
</div>

{{-- ── Barra progreso global ── --}}
<div class="prog-card">
    <div class="prog-top">
        <div>
            <div class="prog-pct" style="color:{{ $progColor }};">{{ number_format($porcentajeGlobal,0) }}%</div>
            <div style="font-size:11px;color:#94a3b8;margin-top:1px;">Progreso de embalaje</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:15px;font-weight:700;color:#1e293b;">{{ $totalEnBultos }} / {{ $totalUnidades }}</div>
            <div style="font-size:11px;color:#64748b;">unidades en bultos</div>
        </div>
    </div>
    <div class="prog-track">
        <div class="prog-fill" style="width:{{ $porcentajeGlobal }}%;background:{{ $progColor }};"></div>
    </div>
    <div style="display:flex;justify-content:space-between;font-size:10px;color:#94a3b8;margin-top:4px;">
        <span>0%</span>
        <span style="color:{{ $progColor }};">● {{ $order->estado }}</span>
        <span>100%</span>
    </div>
</div>

@if($order->estado != 'COMPLETO')

{{-- ── Scanner ── --}}
<div class="scanner-wrap">
    <div class="scanner-pulse"></div>
    <input type="text" id="scanner" class="scanner-input"
           placeholder="📡 Escanea un producto para ver su estado en la orden..." autofocus>
    <span style="font-size:10px;color:#475569;white-space:nowrap;">Enter para<br>confirmar</span>
</div>

{{-- ── Layout 2 columnas ── --}}
<div class="layout">

    {{-- ── COLUMNA IZQUIERDA: Productos ── --}}
    <div class="sec-card">
        <div class="sec-title">
            <div class="sec-title-left">📋 Productos de la orden</div>
        </div>

        {{-- Agregar producto --}}
        <div class="add-form-box">
            <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.6rem;">➕ Agregar producto</div>
            <form method="POST" action="{{ route('orders.addProduct',$order) }}">
                @csrf
                <div class="add-grid">
                    <div>
                        <label class="flabel">Producto</label>
                        <select name="product_id" class="finput" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} (Stock: {{ $p->stock }})</option>
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
                    <button type="submit" class="btn btn-green" style="align-self:end;">+ Agregar</button>
                </div>
            </form>
        </div>

        {{-- Lista de productos --}}
        @foreach($order->details as $item)
        @php
            $enBultos = 0;
            $bultosUsados = [];
            foreach($order->bultos as $b){
                foreach($b->detalles as $d){
                    if($d->product_id == $item->product_id){
                        $enBultos += $d->cantidad;
                        $bultosUsados[] = $b->nombre;
                    }
                }
            }
            $faltante   = $item->cantidad_solicitada - $enBultos;
            $pct        = $item->cantidad_solicitada > 0 ? ($enBultos / $item->cantidad_solicitada) * 100 : 0;
            $lc         = $pct >= 100 ? '#22c55e' : ($pct > 0 ? '#f59e0b' : '#ef4444');
            $pesoItem   = isset($item->product->peso) ? ($item->product->peso / 1000) * $item->cantidad_solicitada : 0;
            $pesoEmb    = isset($item->product->peso) ? ($item->product->peso / 1000) * $enBultos : 0;
            $bultosStr  = count($bultosUsados) ? implode(', ', array_unique($bultosUsados)) : 'Sin bulto';
        @endphp

        <div class="prod-item" style="border-left-color:{{ $lc }};">
            <div class="prod-item-top">
                <div>
                    <div class="prod-name">{{ $item->product->nombre }}</div>
                    <div class="prod-sub">
                        ⚖ {{ number_format(($item->product->peso ?? 0)/1000,3) }} kg/u
                        · Bulto: <strong>{{ $bultosStr }}</strong>
                    </div>
                </div>
                <span class="prod-counter" style="
                    background:{{ $pct >= 100 ? '#dcfce7' : ($pct > 0 ? '#fef3c7' : '#fee2e2') }};
                    color:{{ $pct >= 100 ? '#15803d' : ($pct > 0 ? '#b45309' : '#b91c1c') }};">
                    {{ $enBultos }} / {{ $item->cantidad_solicitada }}
                    {{ $pct >= 100 ? '✅' : '' }}
                </span>
            </div>
            <div class="mini-bar"><div class="mini-fill" style="width:{{ $pct }}%;background:{{ $lc }};"></div></div>
            <div class="prod-meta">
                @if($faltante > 0)
                    <span class="falt-tag">Faltan {{ $faltante }}</span>
                @else
                    <span style="color:#15803d;font-weight:600;font-size:11px;">Completo</span>
                @endif
                <span class="peso-highlight {{ $pesoEmb > 15 ? 'heavy' : '' }}">
                    ⚖ {{ number_format($pesoEmb,2) }} kg embalados
                </span>
            </div>

            {{-- Inputs editar --}}
            <form method="POST" action="{{ route('orders.updateDetail',$item) }}" style="margin-top:6px;">
                @csrf @method('PUT')
                <div class="prod-inputs">
                    <input type="number" name="cantidad_solicitada" class="finput"
                           value="{{ $item->cantidad_solicitada }}" style="width:65px;text-align:center;">
                    <input type="number" name="cantidad_despachada" class="finput"
                           value="{{ $item->cantidad_despachada }}" style="width:65px;text-align:center;">
                    <input type="number" step="0.01" name="precio_unitario" class="finput"
                           value="{{ $item->precio_unitario }}" style="width:75px;" placeholder="Precio">
                    <button type="submit" class="btn btn-blue">💾</button>
                </div>
            </form>
        </div>
        @endforeach
    </div>

    {{-- ── COLUMNA DERECHA: Bultos ── --}}
    <div class="sec-card">
        <div class="sec-title">
            <div class="sec-title-left">📦 Bultos ({{ $order->bultos->count() }})</div>
        </div>

        {{-- Botón crear bulto --}}
        <div class="crear-bulto-row">
            <form method="POST" action="{{ route('bultos.crear',$order) }}">
                @csrf
                <button type="submit" class="btn btn-blue">📦 + Crear nuevo bulto</button>
            </form>
            <span style="font-size:11px;color:#94a3b8;">Peso total: <strong style="color:#1d4ed8;">{{ number_format($pesoTotal,2) }} kg</strong></span>
        </div>

        <div class="bultos-grid">

            @foreach($order->bultos as $bulto)
            @php
                $pesoB = $bulto->peso_total ?? 0;
                $isHeavy = $pesoB > 20;
            @endphp
            <div class="bulto-card">
                <div class="bulto-hdr">
                    <div class="bulto-name">📦 {{ $bulto->nombre }}</div>
                    <div class="peso-badge {{ $isHeavy ? 'heavy' : '' }}">
                        ⚖ {{ number_format($pesoB,2) }} kg
                        {{ $isHeavy ? '⚠' : '' }}
                    </div>
                </div>
                <div style="font-size:10px;color:#94a3b8;">
                    {{ $bulto->detalles->count() }} producto(s)
                </div>
                <hr class="dv">
                <div style="font-size:11px;font-weight:600;color:#64748b;margin-bottom:4px;">CONTENIDO:</div>

                @forelse($bulto->detalles as $det)
                <div class="bulto-item">
                    <span style="flex:1;">{{ $det->product->nombre }}</span>
                    <span class="bulto-item-qty">×{{ $det->cantidad }}</span>
                    <form method="POST" action="{{ route('bultos.eliminar',$det) }}"
                          onsubmit="return confirm('¿Eliminar del bulto?')" style="margin-left:4px;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#dc2626;font-size:12px;padding:0 2px;">🗑</button>
                    </form>
                </div>
                @empty
                <div style="font-size:11px;color:#94a3b8;text-align:center;padding:8px;">Bulto vacío</div>
                @endforelse

                <hr class="dv">

                {{-- Agregar al bulto --}}
                <form method="POST" action="{{ route('bultos.agregar',$bulto) }}">
                    @csrf
                    <select name="product_id" class="finput" style="font-size:11px;margin-bottom:4px;" required>
                        <option value="">+ Agregar producto</option>
                        @foreach($order->details as $d)
                            <option value="{{ $d->product->id }}">{{ $d->product->nombre }}</option>
                        @endforeach
                    </select>
                    <div style="display:flex;gap:5px;">
                        <input type="number" name="cantidad" class="finput" placeholder="Cant." style="flex:1;" required>
                        <button type="submit" class="btn btn-blue" style="font-size:11px;">+</button>
                    </div>
                </form>
            </div>
            @endforeach

            {{-- Placeholder nuevo bulto --}}
            <form method="POST" action="{{ route('bultos.crear',$order) }}">
                @csrf
                <button type="submit" class="nuevo-bulto-btn">
                    <span style="font-size:22px;">📦</span>
                    <span>+ Nuevo bulto</span>
                </button>
            </form>

        </div>
    </div>
</div>

@else

{{-- ── VISTA ORDEN COMPLETA ── --}}
<div class="sec-card" style="margin-top:1rem;">
    <div class="sec-title"><div class="sec-title-left">📦 Productos enviados</div></div>
    @foreach($order->bultos as $bulto)
        @foreach($bulto->detalles as $det)
        <div style="display:flex;justify-content:space-between;align-items:center;background:#f8fafc;padding:8px 12px;border-radius:8px;margin-bottom:5px;border-left:3px solid #22c55e;">
            <span style="font-size:13px;font-weight:500;color:#0f172a;">{{ $det->product->nombre }}</span>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:12px;color:#64748b;">×{{ $det->cantidad }}</span>
                <form method="POST" action="{{ route('bultos.eliminar',$det) }}"
                      onsubmit="return confirm('¿Eliminar?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-red" style="padding:4px 8px;font-size:11px;">🗑</button>
                </form>
            </div>
        </div>
        @endforeach
    @endforeach
</div>

@endif

</div>
<script>
let scanner = document.getElementById('scanner');
if(scanner){
    scanner.addEventListener('keydown', function(e){
        if(e.key !== 'Enter') return;
        e.preventDefault();
        const codigo = this.value.trim();
        if(!codigo) return;

        fetch(`/api/producto/${codigo}`)
        .then(r => r.json())
        .then(prod => {
            if(!prod){ alert('❌ Producto no encontrado'); this.value=''; return; }
            const items = document.querySelectorAll('.prod-item');
            let found = false;
            items.forEach(el => {
                if(el.textContent.includes(prod.nombre)){
                    el.scrollIntoView({behavior:'smooth',block:'center'});
                    el.style.boxShadow = '0 0 0 2px #2563eb';
                    setTimeout(()=>{ el.style.boxShadow=''; }, 1500);
                    found = true;
                }
            });
            if(!found) alert('⚠ Producto no está en esta orden');
        })
        .catch(()=>{ alert('❌ Error al buscar producto'); });

        this.value = '';
    });

    // ✅ CORREGIDO: solo devuelve el foco si el usuario NO está
    // interactuando con ningún input, select o button de la página
    const TAGS_INTERACTIVOS = ['INPUT', 'SELECT', 'TEXTAREA', 'BUTTON'];

    setInterval(() => {
        const activo = document.activeElement;
        const esScannerMismo = activo === scanner;
        const esInteractivo  = TAGS_INTERACTIVOS.includes(activo.tagName);

        if(!esScannerMismo && !esInteractivo){
            scanner.focus();
        }
    }, 1000);
}

function confirmarCierre(){
    @php
        $faltantesJs = $order->details->filter(function($item) use ($order){
            $enB = 0;
            foreach($order->bultos as $b)
                foreach($b->detalles as $d)
                    if($d->product_id == $item->product_id) $enB += $d->cantidad;
            return $enB < $item->cantidad_solicitada;
        })->map(function($item) use ($order){
            $enB = 0;
            foreach($order->bultos as $b)
                foreach($b->detalles as $d)
                    if($d->product_id == $item->product_id) $enB += $d->cantidad;
            return ['nombre' => $item->product->nombre, 'falta' => $item->cantidad_solicitada - $enB];
        });
    @endphp

    const faltantes = @json($faltantesJs);
    if(faltantes.length === 0)
        return confirm('✅ Todo embalado.\n\n¿Cerrar la encomienda?');
    const lista = faltantes.map(f => `• ${f.nombre} (faltan ${f.falta})`).join('\n');
    return confirm('⚠️ Productos sin embalaje completo:\n\n' + lista + '\n\n¿Cerrar encomienda de todas formas?');
}
</script>
@endsection