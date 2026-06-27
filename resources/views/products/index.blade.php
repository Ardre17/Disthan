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
                    <span>Código</span>
                    <span>{{ $product->barcode }}</span>
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

                <div class="actions">

                    <a href="{{ route('products.edit',$product) }}"
                       class="btn-edit">
                        Editar
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

                            Eliminar

                        </button>

                    </form>

                </div>

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

@endsection
