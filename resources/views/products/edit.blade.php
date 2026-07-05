@extends('layouts.app')

@section('content')

<style>

.page{
    padding:30px;
}

.card{
    background:white;
    max-width:1000px;
    margin:auto;
    padding:25px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.10);
}

.row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.form-group{
    margin-bottom:15px;
}

label{
    display:block;
    font-weight:bold;
    margin-bottom:5px;
}

input,
select,
textarea{
    width:100%;
    padding:10px;
    border:1px solid #d1d5db;
    border-radius:8px;
    box-sizing:border-box;
}

textarea{
    min-height:100px;
}

.image-preview{
    margin-bottom:20px;
}

.image-preview img{
    width:200px;
    height:200px;
    object-fit:cover;
    border-radius:10px;
    border:1px solid #ddd;
}

.buttons{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.btn-back{
    background:#6b7280;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:8px;
}

.btn-update{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

</style>

<div class="page">

<div class="card">

<h2>✏️ Editar Producto</h2>

@if($product->imagen)

<div class="image-preview">
    <img src="{{ asset('storage/'.$product->imagen) }}">
</div>

@endif

<form action="{{ route('products.update',$product) }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

<div class="form-group">
<label>SKU</label>
<input type="text"
       name="sku"
       value="{{ $product->sku }}">
</div>

<div class="form-group">
<label>Código de Barras</label>
<input type="text"
       name="barcode"
       value="{{ $product->barcode }}">
</div>

<div class="form-group">
<label>Nombre</label>
<input type="text"
       name="nombre"
       value="{{ $product->nombre }}">
</div>

<div class="form-group">
<label>Marca</label>
<input type="text"
       name="marca"
       value="{{ $product->marca }}">
</div>

<div class="form-group">

    <label>Categoría</label>

    <select name="category_id" required>

        <option value="">
            Seleccionar Categoría
        </option>

        @foreach($categories as $category)

            <option
                value="{{ $category->id }}"
                {{ $product->category_id == $category->id ? 'selected' : '' }}>

                {{ $category->nombre }}

            </option>

        @endforeach

    </select>

</div>

<div class="form-group">
<label>Cantidad por Caja</label>
<input type="number"
       name="cantidad_por_caja"
       value="{{ $product->cantidad_por_caja }}">
</div>

<div style="margin-bottom:15px;">

    <label>Peso (gramos)</label>

    <input
        type="number"
        name="peso"
        value="{{ old('peso', $product->peso ?? '') }}"
        placeholder="Ej: 425"
        style="
            width:100%;
            padding:10px;
            border:1px solid #ddd;
            border-radius:8px;
        ">

</div>

<div class="form-group">
<label>Lote</label>
<input type="text"
       name="lote"
       value="{{ $product->lote }}">
</div>

<div class="form-group">
<label>Rotación</label>

<select name="rotacion">

<option value="MUY_ALTA"
{{ $product->rotacion=='MUY_ALTA' ? 'selected' : '' }}>
MUY ALTA
</option>

<option value="ALTA"
{{ $product->rotacion=='ALTA' ? 'selected' : '' }}>
ALTA
</option>

<option value="MEDIA"
{{ $product->rotacion=='MEDIA' ? 'selected' : '' }}>
MEDIA
</option>

<option value="BAJA"
{{ $product->rotacion=='BAJA' ? 'selected' : '' }}>
BAJA
</option>

</select>

</div>

<div class="form-group">
<label>Fecha Producción</label>
<input type="date"
       name="fecha_produccion"
       value="{{ $product->fecha_produccion }}">
</div>

<div class="form-group">
<label>Fecha Vencimiento</label>
<input type="date"
       name="fecha_vencimiento"
       value="{{ $product->fecha_vencimiento }}">
</div>

<div class="form-group">
<label>Stock</label>
<input type="number"
       step="0.01"
       name="stock"
       value="{{ $product->stock }}">
</div>

<div class="form-group">
<label>Stock Mínimo</label>
<input type="number"
       step="0.01"
       name="stock_minimo"
       value="{{ $product->stock_minimo }}">
</div>

</div>

<div class="form-group">
<label>Descripción</label>

<textarea name="descripcion">{{ $product->descripcion }}</textarea>
</div>

@php
$advertencias = explode(',', $product->advertencias ?? '');
@endphp

<div class="form-group">

<label>⚠ Advertencias Nutricionales</label>

<div style="
display:grid;
grid-template-columns:repeat(3,1fr);
gap:10px;
padding:12px;
background:#f8fafc;
border:1px solid #ddd;
border-radius:8px;
">

<label>

<input type="checkbox"
name="advertencias[]"
value="AZUCAR"
{{ in_array('AZUCAR',$advertencias) ? 'checked' : '' }}>

Alto en Azúcar

</label>

<label>

<input type="checkbox"
name="advertencias[]"
value="SODIO"
{{ in_array('SODIO',$advertencias) ? 'checked' : '' }}>

Alto en Sodio

</label>

<label>

<input type="checkbox"
name="advertencias[]"
value="GRASAS"
{{ in_array('GRASAS',$advertencias) ? 'checked' : '' }}>

Alto en Grasas Saturadas

</label>

</div>

</div>
    
<div class="form-group">
<label>Cambiar Imagen</label>
<input type="file" name="imagen">
</div>

<div class="buttons">

<a href="{{ route('products.index') }}"
   class="btn-back">
   Volver
</a>
@if($role == 'admin')
<button type="submit"
        class="btn-update">
    Actualizar Producto
</button>
@endif
</div>

</form>

</div>

</div>

@endsection
