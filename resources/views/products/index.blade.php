@extends('layouts.app')

@section('content')

<style>

.page{
    padding:25px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.title{
    font-size:28px;
    font-weight:bold;
}

.btn-new{
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:8px;
    font-weight:bold;
}

.btn-new:hover{
    background:#1d4ed8;
}

.catalog{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:20px;
}

.product-card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,.10);
    transition:.3s;
}

.product-card:hover{
    transform:translateY(-5px);
}

.product-image{
    height:220px;
    background:#f3f4f6;
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
    font-size:70px;
    color:#9ca3af;
}

.product-body{
    padding:20px;
}

.sku{
    font-size:12px;
    color:#6b7280;
    margin-bottom:5px;
}

.name{
    font-size:22px;
    font-weight:bold;
    margin-bottom:10px;
}

.category{
    background:#e5e7eb;
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    margin-bottom:15px;
}

.info{
    margin-bottom:8px;
    color:#374151;
}

.rotation{
    color:white;
    padding:8px;
    text-align:center;
    border-radius:8px;
    font-weight:bold;
    margin-top:15px;
}

.rot-muy-alta{
    background:#dc2626;
}

.rot-alta{
    background:#f59e0b;
}

.rot-media{
    background:#2563eb;
}

.rot-baja{
    background:#16a34a;
}

.actions{
    display:flex;
    gap:10px;
    margin-top:15px;
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
    height:42px;
    box-sizing:border-box;
    font-weight:bold;
}

.btn-edit{
    flex:1;
    text-align:center;
    background:#f59e0b;
    color:white;
    padding:10px;
    border-radius:8px;
    text-decoration:none;
}

.btn-delete{
    background:#dc2626;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.empty{
    background:white;
    padding:40px;
    text-align:center;
    border-radius:15px;
}
.search-box{
    display:flex;
    gap:10px;
    margin-bottom:25px;
}

.search-box input{
    flex:1;
    padding:12px;
    border:1px solid #d1d5db;
    border-radius:8px;
}

.search-box button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}
.filters{
    display:flex;
    gap:10px;
    margin-bottom:25px;
}

.filters input{
    flex:1;
}

.filters input,
.filters select{
    padding:12px;
    border:1px solid #d1d5db;
    border-radius:8px;
}

.filters button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}
</style>

<div class="page">

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
            📦 Catálogo de Productos
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

                <div class="info">
                    🏷️ Lote:
                    {{ $product->lote }}
                </div>

                <div class="info">
                    📦 Stock:
                    {{ $product->stock }}
                    @if($product->stock <= $product->stock_minimo)

                <div style="
                background:#fee2e2;
                color:#991b1b;
                padding:8px;
                border-radius:8px;
                margin-top:10px;
                font-weight:bold;
                ">

                ⚠️ Stock Bajo

                </div>

                @endif
                </div>

                <div class="info">
                    📦 Caja:
                    {{ $product->cantidad_por_caja }}
                </div>

                <div class="info">
                    📅 Producción:
                    {{ $product->fecha_produccion }}
                </div>

                <div class="info">
                    ⏳ Vencimiento:
                    @php

$estadoVencimiento = '';

if($product->fecha_vencimiento){

    $dias = now()->diffInDays(
        $product->fecha_vencimiento,
        false
    );

    if($dias < 0){

        $estadoVencimiento =
        '<span style="color:red;font-weight:bold">
        🔴 Vencido
        </span>';

    }elseif($dias <= 30){

        $estadoVencimiento =
        '<span style="color:orange;font-weight:bold">
        🟠 Próximo a vencer
        </span>';

    }else{

        $estadoVencimiento =
        '<span style="color:green;font-weight:bold">
        🟢 Vigente
        </span>';
    }
}

@endphp

<div class="info">
    {!! $estadoVencimiento !!}
</div>

<div class="info">
    📅 {{ $product->fecha_vencimiento }}
</div>
                </div>

                <div class="info">
                    🔢 Código:
                    {{ $product->barcode }}
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