@extends('layouts.app')

@section('content')

<style>

.page{
    padding:30px;
}

.card{
    background:white;
    max-width:900px;
    margin:auto;
    padding:25px;
    border-radius:12px;
    box-shadow:0 3px 15px rgba(0,0,0,.1);
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

input,select,textarea{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
    box-sizing:border-box;
}

.btn-save{
    background:#16a34a;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:6px;
    cursor:pointer;
}

</style>

<div class="page">

<div class="card">

<h2>📦 Nuevo Producto</h2>

<form action="{{ route('products.store') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<div class="row">

<div class="form-group">
<label>SKU</label>
<input type="text" name="sku">
</div>

<div class="form-group">
<label>Código de Barras</label>
<input type="text" name="barcode">
</div>

<div class="form-group">
    <label class="form-label">Código de Caja</label>
    <input
        type="text"
        class="form-control"
        name="box_barcode"
        value="{{ old('box_barcode', $product->box_barcode ?? '') }}">
</div>

<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre">
</div>

<div class="form-group">
<label>Marca</label>
<input type="text" name="marca">
</div>

<div class="form-group">

    <label>Categoría</label>

    <select name="category_id" required>

        <option value="">
            Seleccionar Categoría
        </option>

        @foreach($categories as $category)

            <option value="{{ $category->id }}">

                {{ $category->nombre }}

            </option>

        @endforeach

    </select>

</div>

<div class="form-group">
<label>Cantidad por Caja</label>
<input type="number" name="cantidad_por_caja">
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
<input type="text" name="lote">
</div>

<div class="form-group">
<label>Rotación</label>
<select name="rotacion">
<option>MUY_ALTA</option>
<option>ALTA</option>
<option>MEDIA</option>
<option>BAJA</option>
</select>
</div>

<div class="form-group">
<label>Fecha Producción</label>
<input type="date" name="fecha_produccion">
</div>

<div class="form-group">
<label>Fecha Vencimiento</label>
<input type="date" name="fecha_vencimiento">
</div>

<div class="form-group">
<label>Stock</label>
<input type="number" step="0.01" name="stock">
</div>

<div class="form-group">
<label>Stock Mínimo</label>
<input type="number" step="0.01" name="stock_minimo">
</div>

</div>

<div class="form-group">
<label>Descripción</label>
<textarea name="descripcion"></textarea>
</div>

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
       value="AZUCAR">
 Alto en Azúcar
</label>

<label>
<input type="checkbox"
       name="advertencias[]"
       value="SODIO">
 Alto en Sodio
</label>

<label>
<input type="checkbox"
       name="advertencias[]"
       value="GRASAS">
 Alto en Grasas Saturadas
</label>

</div>

</div>
    
<div class="form-group">
<label>Imagen</label>
<input type="file" name="imagen">
</div>

<button type="submit" class="btn-save">
Guardar Producto
</button>

</form>

</div>

</div>

@endsection
