@extends('layouts.app')

@section('content')
@php
    $role = auth()->user()->role;
@endphp
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

.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    padding:20px 24px 40px;
    font-size:13px;
}

/* ---------- Top bar ---------- */

.top-bar{
    display:flex;
    flex-wrap:wrap;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-left:4px solid var(--erp-accent);
    border-radius:4px;
    padding:14px 18px;
    margin-bottom:16px;
}

.title{
    font-size:18px;
    font-weight:700;
    letter-spacing:.2px;
    color:var(--erp-ink);
    display:flex;
    align-items:center;
    gap:8px;
    white-space:nowrap;
}

.title:before{
    content:"";
    width:8px;
    height:8px;
    background:var(--erp-accent);
    display:inline-block;
}

.btn-new{
    background:var(--erp-accent);
    color:white;
    text-decoration:none;
    padding:9px 16px;
    border-radius:3px;
    font-weight:600;
    font-size:12.5px;
    letter-spacing:.2px;
    white-space:nowrap;
    transition:background .15s;
}

.btn-new:hover{
    background:var(--erp-accent-dark);
}

/* ---------- Filters ---------- */

.filters{
    display:flex;
    flex:1;
    min-width:280px;
    gap:8px;
}

.filters input,
.filters select{
    padding:9px 11px;
    border:1px solid var(--erp-border);
    border-radius:3px;
    font-size:12.5px;
    font-family:var(--font-ui);
    background:#fbfcfe;
    color:var(--erp-ink);
}

.filters input{
    flex:1;
    min-width:140px;
}

.filters input:focus,
.filters select:focus{
    outline:2px solid #bcd6f7;
    outline-offset:0;
    border-color:var(--erp-accent);
}

.filters button{
    background:var(--erp-ink);
    color:white;
    border:none;
    padding:9px 18px;
    border-radius:3px;
    cursor:pointer;
    font-weight:600;
    font-size:12.5px;
}

.filters button:hover{
    background:#000;
}

/* ---------- KPI strip ---------- */

.kpi-strip{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:12px;
    margin-bottom:16px;
}

.kpi-card{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:14px 16px;
    position:relative;
    overflow:hidden;
}

.kpi-card .kpi-label{
    font-size:10.5px;
    text-transform:uppercase;
    letter-spacing:.6px;
    color:var(--erp-ink-muted);
    font-weight:600;
    margin-bottom:6px;
}

.kpi-card .kpi-value{
    font-family:var(--font-mono);
    font-size:24px;
    font-weight:700;
    color:var(--erp-ink);
    line-height:1;
}

.kpi-card .kpi-bar{
    position:absolute;
    left:0;
    top:0;
    bottom:0;
    width:4px;
}

.kpi-total .kpi-bar{background:var(--erp-accent);}
.kpi-low .kpi-bar{background:var(--erp-danger);}
.kpi-expiring .kpi-bar{background:var(--erp-warn);}
.kpi-ok .kpi-bar{background:var(--erp-ok);}

.kpi-low .kpi-value{color:var(--erp-danger);}
.kpi-expiring .kpi-value{color:var(--erp-warn);}
.kpi-ok .kpi-value{color:var(--erp-ok);}

/* ---------- Catalog ---------- */

.catalog{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:14px;
}

.product-card{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    overflow:hidden;
    transition:box-shadow .15s, border-color .15s;
}

.product-card:hover{
    border-color:#c2cbd8;
    box-shadow:0 2px 10px rgba(20,30,45,.08);
}

.product-image{
    height:140px;
    background:
        linear-gradient(135deg, #f4f6f9 25%, transparent 25%) -10px 0,
        linear-gradient(225deg, #f4f6f9 25%, transparent 25%) -10px 0,
        linear-gradient(315deg, #f4f6f9 25%, transparent 25%),
        linear-gradient(45deg, #f4f6f9 25%, transparent 25%);
    background-size:20px 20px;
    background-color:#fafbfc;
    border-bottom:1px solid var(--erp-border);
    display:flex;
    align-items:center;
    justify-content:center;
}

.product-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.no-image{
    font-size:46px;
    color:#b9c2cf;
}

.product-body{
    padding:14px 16px 16px;
}

.sku{
    font-family:var(--font-mono);
    font-size:11px;
    color:var(--erp-ink-muted);
    margin-bottom:4px;
    letter-spacing:.3px;
}

.name{
    font-size:15.5px;
    font-weight:700;
    margin-bottom:8px;
    color:var(--erp-ink);
}

.category{
    background:#eaf0f9;
    color:var(--erp-accent-dark);
    display:inline-block;
    padding:3px 10px;
    border-radius:3px;
    font-size:11px;
    font-weight:600;
    margin-bottom:12px;
    border:1px solid #d7e4f6;
}
/* ===========================
   OCTÓGONOS NUTRICIONALES
===========================*/

.warning-icons{
    display:flex;
    gap:6px;
    flex-wrap:wrap;
    margin-bottom:12px;
    margin-top:-4px;
}

.warning-icons img{
    height:42px;
    width:auto;
    transition:.2s;
}

.warning-icons img:hover{
    transform:scale(1.05);
}
.info{
    margin-bottom:6px;
    color:var(--erp-ink-muted);
    font-size:12.5px;
    display:flex;
    justify-content:space-between;
    border-bottom:1px dashed #ecf0f4;
    padding-bottom:5px;
}

.info:last-of-type{
    border-bottom:none;
}

.rotation{
    color:white;
    padding:7px;
    text-align:center;
    border-radius:3px;
    font-weight:700;
    font-size:11px;
    letter-spacing:.4px;
    text-transform:uppercase;
    margin-top:12px;
}

.rot-muy-alta{ background:var(--erp-danger); }
.rot-alta{ background:var(--erp-warn); }
.rot-media{ background:var(--erp-accent); }
.rot-baja{ background:var(--erp-ok); }

.actions{
    display:flex;
    gap:8px;
    margin-top:12px;
}

.actions a,
.actions form{
    flex:1;
}

.btn-edit,
.btn-delete{
    display:flex;
    align-items:center;
    justify-content:center;
    height:36px;
    box-sizing:border-box;
    font-weight:600;
    font-size:12px;
}

.btn-edit{
    flex:1;
    text-align:center;
    background:#fff;
    color:var(--erp-warn);
    border:1px solid var(--erp-warn);
    padding:8px;
    border-radius:3px;
    text-decoration:none;
}

.btn-edit:hover{
    background:var(--erp-warn-bg);
}

.btn-delete{
    background:#fff;
    color:var(--erp-danger);
    border:1px solid var(--erp-danger);
    border-radius:3px;
    cursor:pointer;
}

.btn-delete:hover{
    background:var(--erp-danger-bg);
}

.empty{
    background:var(--erp-surface);
    border:1px dashed var(--erp-border);
    padding:50px 20px;
    text-align:center;
    border-radius:4px;
    color:var(--erp-ink-muted);
}

.empty h2{
    color:var(--erp-ink);
    font-size:16px;
    margin-bottom:6px;
}

/* stock low banner inside card */
.stock-low-banner{
    background:var(--erp-danger-bg);
    color:var(--erp-danger);
    padding:7px 8px;
    border-radius:3px;
    margin-top:8px;
    font-weight:700;
    font-size:11.5px;
    border:1px solid #f3c7c4;
}
.btn-logistic{
    flex:1;
    text-align:center;
    background:#fff;
    color:#0d6efd;
    border:1px solid #0d6efd;
    padding:8px;
    border-radius:3px;
    text-decoration:none;
    display:flex;
    align-items:center;
    justify-content:center;
    height:36px;
    font-weight:600;
    font-size:12px;
}

.btn-logistic:hover{
    background:#eaf3ff;
}

/* ---------- Botón Ver detalle ---------- */
.btn-view{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    height:36px;
    margin-top:12px;
    background:var(--erp-ink);
    color:#fff;
    border:none;
    border-radius:3px;
    font-weight:600;
    font-size:12px;
    cursor:pointer;
    box-sizing:border-box;
}
.btn-view:hover{
    background:#000;
}

/* ---------- Modal detalle producto ---------- */
.modal-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.6);
    z-index:9999;
    align-items:center;
    justify-content:center;
    padding:1rem;
}
.modal-box{
    background:#fff;
    border-radius:6px;
    width:100%;
    max-width:520px;
    max-height:88vh;
    overflow-y:auto;
    box-shadow:0 12px 34px rgba(0,0,0,.28);
}
.modal-head{
    background:var(--erp-ink);
    color:#fff;
    padding:.9rem 1.1rem;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:10px;
    position:sticky;
    top:0;
    z-index:1;
}
.modal-head-name{
    font-size:15px;
    font-weight:700;
}
.modal-head-sku{
    font-size:11px;
    color:#aeb9c7;
    font-family:var(--font-mono);
    margin-top:2px;
}
.modal-head button{
    background:none;
    border:none;
    color:#aeb9c7;
    font-size:20px;
    cursor:pointer;
    line-height:1;
    padding:2px 4px;
    flex-shrink:0;
}
.modal-body{
    padding:1.1rem;
}
.modal-img{
    width:100%;
    max-height:170px;
    object-fit:cover;
    border-radius:4px;
    border:1px solid var(--erp-border);
    margin-bottom:12px;
    display:block;
}
.modal-section-title{
    font-size:10.5px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.6px;
    color:var(--erp-ink-muted);
    margin:14px 0 6px;
    padding-bottom:4px;
    border-bottom:2px solid var(--erp-border);
}
.modal-section-title:first-of-type{
    margin-top:0;
}
.modal-row{
    display:flex;
    justify-content:space-between;
    padding:5px 0;
    border-bottom:1px dashed #ecf0f4;
    font-size:12.5px;
}
.modal-row:last-child{ border-bottom:none; }
.modal-row .k{ color:var(--erp-ink-muted); }
.modal-row .v{ font-weight:600; color:var(--erp-ink); text-align:right; }
.modal-empty-note{
    font-size:12px;
    color:var(--erp-ink-muted);
    font-style:italic;
    padding:6px 0;
}
.modal-warnings{
    display:flex;
    gap:6px;
    flex-wrap:wrap;
    margin-bottom:6px;
}
.modal-warnings img{ height:38px; width:auto; }

</style>

<div class="page">

    @php
        $totalProductos = $products->count();
        $stockBajoCount = $products->where('stock', '<=', null)->count(); // placeholder, real calc below
        $stockBajoCount = 0;
        $proximosVencer = 0;
        $vigentes = 0;
        foreach($products as $p){
            if($p->stock <= $p->stock_minimo){
                $stockBajoCount++;
            }
            if($p->fecha_vencimiento){
                $dias = now()->diffInDays($p->fecha_vencimiento, false);
                if($dias <= 30 && $dias >= 0){
                    $proximosVencer++;
                }elseif($dias > 30){
                    $vigentes++;
                }
            }
        }
    @endphp

    <div class="kpi-strip">

        <div class="kpi-card kpi-total">
            <div class="kpi-bar"></div>
            <div class="kpi-label">Total Productos</div>
            <div class="kpi-value">{{ $totalProductos }}</div>
        </div>

        <div class="kpi-card kpi-low">
            <div class="kpi-bar"></div>
            <div class="kpi-label">Stock Bajo</div>
            <div class="kpi-value">{{ $stockBajoCount }}</div>
        </div>

        <div class="kpi-card kpi-expiring">
            <div class="kpi-bar"></div>
            <div class="kpi-label">Próximos a Vencer</div>
            <div class="kpi-value">{{ $proximosVencer }}</div>
        </div>

        <div class="kpi-card kpi-ok">
            <div class="kpi-bar"></div>
            <div class="kpi-label">Vigentes</div>
            <div class="kpi-value">{{ $vigentes }}</div>
        </div>

    </div>

    <div class="top-bar">

      <form method="GET"
      action="{{ route('products.index') }}"
      class="filters">

    <input
        type="text"
        name="search"
        placeholder="Buscar producto..."
        value="{{ request('search') }}">

   <select name="category_id">

    <option value="">
        Todas las categorías
    </option>

    @foreach($categories as $category)

        <option
            value="{{ $category->id }}"
            {{ request('category_id') == $category->id ? 'selected' : '' }}>

            {{ $category->nombre }}

        </option>

    @endforeach

</select>

    <button type="submit">
        Buscar
    </button>

</form>

        <div class="title">
            Catálogo de Productos
        </div>

        <a href="{{ route('products.create') }}"
           class="btn-new">
            + Nuevo Producto
        </a>

    </div>

    <div class="catalog">

        @forelse($products as $product)

        <div class="product-card">

            <div class="product-image">

                @if($product->imagen)

                    <img src="{{ asset('storage/'.$product->imagen) }}">

                @else

                    <div class="no-image">
                        📦
                    </div>

                @endif

            </div>

            <div class="product-body">

                <div class="sku">
                    SKU: {{ $product->sku }}
                </div>

                <div class="name">
                    {{ $product->nombre }}
                </div>

                <div class="category">
                    {{ $product->categoria }}
                </div>
                @php

            $advertencias = explode(',', strtoupper($product->advertencias ?? ''));
            
            @endphp
            
            @if(count($advertencias))
            
            <div class="warning-icons">
            
            @if(in_array('AZUCAR',$advertencias))
            
            <img src="https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png">
            
            @endif
            
            @if(in_array('SODIO',$advertencias))
            
            <img src="https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png">
            
            @endif
            
            @if(in_array('GRASAS',$advertencias))
            <img src="https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png">
            
            @endif
            
            </div>

            @endif
                <div class="info">
                    <span>Lote</span>
                    <span>{{ $product->lote }}</span>
                </div>

                <div class="info">
                    <span>Stock</span>
                    <span>{{ $product->stock }}</span>
                </div>

                @if($product->stock <= $product->stock_minimo)

                <div class="stock-low-banner">
                    ⚠️ Stock Bajo
                </div>

                @endif

                <div class="info">
                    <span>Caja</span>
                    <span>{{ $product->cantidad_por_caja }}</span>
                </div>

                <div class="info">
                    <span>Producción</span>
                    <span>{{ $product->fecha_produccion }}</span>
                </div>

                @php

$estadoVencimiento = '';

if($product->fecha_vencimiento){

    $dias = now()->diffInDays(
        $product->fecha_vencimiento,
        false
    );

    if($dias < 0){

        $estadoVencimiento =
        '<span style="color:#c0312b;font-weight:700">
        🔴 Vencido
        </span>';

    }elseif($dias <= 30){

        $estadoVencimiento =
        '<span style="color:#b9690e;font-weight:700">
        🟠 Próximo a vencer
        </span>';

    }else{

        $estadoVencimiento =
        '<span style="color:#1c7c4d;font-weight:700">
        🟢 Vigente
        </span>';
    }
}

@endphp

<div class="info">
    <span>Vencimiento</span>
    <span>{!! $estadoVencimiento !!}</span>
</div>

<div class="info">
    <span>Fecha</span>
    <span>{{ $product->fecha_vencimiento }}</span>
</div>

                <div class="info">
                    <span>Código Unidad</span>
                    <span>{{ $product->barcode }}</span>
                </div>

                <div class="info">
                    <span>Código Caja</span>
                    <span>{{ $product->box_barcode }}</span>
                </div>

                <div class="rotation

                    @if($product->rotacion=='MUY_ALTA')
                        rot-muy-alta
                    @elseif($product->rotacion=='ALTA')
                        rot-alta
                    @elseif($product->rotacion=='MEDIA')
                        rot-media
                    @else
                        rot-baja
                    @endif

                ">

                    {{ str_replace('_',' ',$product->rotacion) }}

                </div>

                {{-- ── Ver detalle completo (todos los roles) ── --}}
                @php
                    $mdData = [
                        'sku' => $product->sku,
                        'nombre' => $product->nombre,
                        'categoria' => $product->categoria,
                        'imagen' => $product->imagen ? asset('storage/'.$product->imagen) : null,
                        'advertencias' => $product->advertencias,
                        'lote' => $product->lote,
                        'stock' => $product->stock,
                        'stock_minimo' => $product->stock_minimo,
                        'cantidad_por_caja' => $product->cantidad_por_caja,
                        'fecha_produccion' => $product->fecha_produccion,
                        'fecha_vencimiento' => $product->fecha_vencimiento,
                        'barcode' => $product->barcode,
                        'box_barcode' => $product->box_barcode,
                        'rotacion' => $product->rotacion,
                        'logistic' => null,
                    ];

                    if ($product->logistic) {
                        $mdData['logistic'] = [
                            'largo_cm' => $product->logistic->largo_cm,
                            'ancho_cm' => $product->logistic->ancho_cm,
                            'alto_cm' => $product->logistic->alto_cm,
                            'peso_caja' => $product->logistic->peso_caja,
                            'max_cajas_pallet' => $product->logistic->max_cajas_pallet,
                            'max_niveles' => $product->logistic->max_niveles,
                            'altura_maxima_pallet' => $product->logistic->altura_maxima_pallet,
                            'permite_mezcla' => $product->logistic->permite_mezcla,
                            'orientacion' => $product->logistic->orientacion,
                            'activo' => $product->logistic->activo,
                        ];
                    }
                @endphp
                <button type="button" class="btn-view"
                    onclick='abrirDetalle(@json($mdData))'>
                    👁️ Ver detalle completo
                </button>

                @if($role == 'admin')
                <div class="actions">

                    <a href="{{ route('products.edit',$product) }}"
                    class="btn-edit">
                        ✏️ Editar
                    </a>

                    <a href="{{ route('products.logistic.edit',$product) }}"
                    class="btn-logistic">
                        📦 Logística
                    </a>

                    <form
                        action="{{ route('products.destroy',$product) }}"
                        method="POST"
                        style="flex:1;">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn-delete"
                            style="width:100%;"
                            onclick="return confirm('¿Eliminar producto?')">

                            🗑 Eliminar

                        </button>

                    </form>

                </div>
@endif
            </div>

        </div>

        @empty

        <div class="empty">

            <h2>No existen productos registrados</h2>

            <p>
                Comienza creando tu primer producto.
            </p>

        </div>

        @endforelse

    </div>

</div>

{{-- ── Modal detalle de producto (compartido, se llena vía JS) ── --}}
<div id="modalDetalle" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <div>
                <div class="modal-head-name" id="mdNombre">—</div>
                <div class="modal-head-sku" id="mdSku">SKU: —</div>
            </div>
            <button type="button" onclick="cerrarDetalle()">✕</button>
        </div>
        <div class="modal-body">

            <img id="mdImagen" class="modal-img" style="display:none;">

            <div class="modal-warnings" id="mdWarnings"></div>

            <div class="modal-section-title">Información general</div>
            <div class="modal-row"><span class="k">Categoría</span><span class="v" id="mdCategoria">—</span></div>
            <div class="modal-row"><span class="k">Lote</span><span class="v" id="mdLote">—</span></div>
            <div class="modal-row"><span class="k">Stock actual</span><span class="v" id="mdStock">—</span></div>
            <div class="modal-row"><span class="k">Stock mínimo</span><span class="v" id="mdStockMin">—</span></div>
            <div class="modal-row"><span class="k">Unidades por caja</span><span class="v" id="mdCaja">—</span></div>
            <div class="modal-row"><span class="k">Rotación</span><span class="v" id="mdRotacion">—</span></div>

            <div class="modal-section-title">Vencimiento</div>
            <div class="modal-row"><span class="k">Fecha de producción</span><span class="v" id="mdFechaProd">—</span></div>
            <div class="modal-row"><span class="k">Fecha de vencimiento</span><span class="v" id="mdFechaVenc">—</span></div>
            <div class="modal-row"><span class="k">Estado</span><span class="v" id="mdEstadoVenc">—</span></div>

            <div class="modal-section-title">Códigos</div>
            <div class="modal-row"><span class="k">Código unidad</span><span class="v" id="mdBarcode">—</span></div>
            <div class="modal-row"><span class="k">Código caja</span><span class="v" id="mdBoxBarcode">—</span></div>

            <div class="modal-section-title">Logística</div>
            <div id="mdLogistica"></div>

        </div>
    </div>
</div>

<script>
function diasHasta(fechaStr){
    if(!fechaStr) return null;
    var hoy = new Date();
    hoy.setHours(0,0,0,0);
    var fecha = new Date(fechaStr);
    fecha.setHours(0,0,0,0);
    return Math.round((fecha - hoy) / (1000*60*60*24));
}

function abrirDetalle(p){
    document.getElementById('mdNombre').textContent = p.nombre || '—';
    document.getElementById('mdSku').textContent = 'SKU: ' + (p.sku || '—');

    var img = document.getElementById('mdImagen');
    if(p.imagen){
        img.src = p.imagen;
        img.style.display = 'block';
    } else {
        img.style.display = 'none';
    }

    // Octógonos de advertencia
    var warnBox = document.getElementById('mdWarnings');
    warnBox.innerHTML = '';
    var advertencias = (p.advertencias || '').toUpperCase().split(',');
    var iconos = {
        'AZUCAR': 'https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png',
        'SODIO': 'https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png',
        'GRASAS': 'https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png'
    };
    advertencias.forEach(function(a){
        a = a.trim();
        if(iconos[a]){
            var im = document.createElement('img');
            im.src = iconos[a];
            warnBox.appendChild(im);
        }
    });

    document.getElementById('mdCategoria').textContent = p.categoria || '—';
    document.getElementById('mdLote').textContent = p.lote || '—';
    document.getElementById('mdStock').textContent = (p.stock ?? '—');
    document.getElementById('mdStockMin').textContent = (p.stock_minimo ?? '—');
    document.getElementById('mdCaja').textContent = (p.cantidad_por_caja ?? '—');
    document.getElementById('mdRotacion').textContent = p.rotacion ? p.rotacion.replace('_',' ') : '—';

    document.getElementById('mdFechaProd').textContent = p.fecha_produccion || '—';
    document.getElementById('mdFechaVenc').textContent = p.fecha_vencimiento || '—';

    var estadoEl = document.getElementById('mdEstadoVenc');
    if(p.fecha_vencimiento){
        var dias = diasHasta(p.fecha_vencimiento);
        if(dias < 0){
            estadoEl.innerHTML = '<span style="color:#c0312b;">🔴 Vencido</span>';
        } else if(dias <= 30){
            estadoEl.innerHTML = '<span style="color:#b9690e;">🟠 Próximo a vencer (' + dias + 'd)</span>';
        } else {
            estadoEl.innerHTML = '<span style="color:#1c7c4d;">🟢 Vigente (' + dias + 'd)</span>';
        }
    } else {
        estadoEl.textContent = '—';
    }

    document.getElementById('mdBarcode').textContent = p.barcode || '—';
    document.getElementById('mdBoxBarcode').textContent = p.box_barcode || '—';

    // Logística
    var logBox = document.getElementById('mdLogistica');
    if(p.logistic){
        var l = p.logistic;
        logBox.innerHTML =
            fila('Dimensiones (LxAxA cm)', (l.largo_cm ?? '—') + ' x ' + (l.ancho_cm ?? '—') + ' x ' + (l.alto_cm ?? '—')) +
            fila('Peso por caja', (l.peso_caja != null ? l.peso_caja + ' kg' : '—')) +
            fila('Máx. cajas por pallet', l.max_cajas_pallet ?? '—') +
            fila('Máx. niveles', l.max_niveles ?? '—') +
            fila('Altura máx. de pallet', (l.altura_maxima_pallet != null ? l.altura_maxima_pallet + ' cm' : '—')) +
            fila('Permite mezcla', l.permite_mezcla ? 'Sí' : 'No') +
            fila('Orientación', l.orientacion || '—') +
            fila('Activo', l.activo ? 'Sí' : 'No');
    } else {
        logBox.innerHTML = '<div class="modal-empty-note">Este producto aún no tiene datos de logística registrados.</div>';
    }

    document.getElementById('modalDetalle').style.display = 'flex';
}

function fila(k, v){
    return '<div class="modal-row"><span class="k">' + k + '</span><span class="v">' + v + '</span></div>';
}

function cerrarDetalle(){
    document.getElementById('modalDetalle').style.display = 'none';
}

document.getElementById('modalDetalle').addEventListener('click', function(e){
    if(e.target === this) cerrarDetalle();
});
</script>

@endsection