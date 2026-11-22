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


.image-panel{margin:22px 0;padding:18px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:13px}
.image-panel-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start;margin-bottom:14px}
.image-panel-head h3{margin:0 0 4px;font-size:15px;color:#0f172a}
.image-panel-head p{margin:0;color:#64748b;font-size:12px}
.image-format{font-size:10px;font-weight:700;color:#475569;background:#e2e8f0;padding:5px 8px;border-radius:6px;white-space:nowrap}
.image-upload-layout{display:grid;grid-template-columns:190px minmax(0,1fr);gap:18px;align-items:center}
.image-preview{width:190px;height:190px;border:1px solid #e2e8f0;border-radius:12px;background:#fff;overflow:hidden;display:flex;align-items:center;justify-content:center}
.image-preview img{width:100%;height:100%;object-fit:contain}
.image-empty{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;color:#94a3b8}
.image-empty span{font-size:42px}.image-empty small{font-size:11px}
.image-upload-actions{min-width:0}
.image-dropzone{min-height:125px;border:2px dashed #93c5fd;border-radius:11px;background:#eff6ff;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;color:#1d4ed8;cursor:pointer;text-align:center;padding:14px;transition:.15s}
.image-dropzone:hover,.image-dropzone.dragover{background:#dbeafe;border-color:#2563eb}
.image-dropzone strong{font-size:13px}.image-dropzone span:not(.upload-icon){font-size:11px;color:#475569}.image-dropzone small{font-size:10px;color:#64748b}
.upload-icon{width:28px;height:28px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800}
.image-file-info{font-size:11px;color:#64748b;margin-top:8px;overflow-wrap:anywhere}
.remove-image-option{display:flex;align-items:center;gap:7px;margin-top:10px;font-size:11px;color:#b91c1c;font-weight:600}
.remove-image-option input{width:auto}
.image-error{margin-top:8px;color:#b91c1c;font-size:12px;font-weight:600}
@media(max-width:600px){.image-upload-layout{grid-template-columns:1fr}.image-preview{width:100%;max-width:220px;margin:auto}.image-panel-head{flex-direction:column}}

</style>

<div class="page">

<div class="card">

<h2>✏️ Editar Producto</h2>

<form action="{{ route('products.update',$product) }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="image-panel">
    <div class="image-panel-head">
        <div>
            <h3>Imagen del producto</h3>
            <p>Sube una fotografía para identificar el producto en el inventario.</p>
        </div>
        <span class="image-format">JPG · PNG · WEBP</span>
    </div>

    <div class="image-upload-layout">
        <div class="image-preview" id="imagePreviewBox">
            @if($product->imagen)
                <img id="imagePreview"
                     src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($product->imagen) }}"
                     alt="{{ $product->nombre }}"
                     onerror="this.style.display='none'; document.getElementById('imagePreviewEmpty').style.display='flex';">
                <div id="imagePreviewEmpty" class="image-empty" style="display:none;">
                    <span>📦</span><small>Vista previa no disponible</small>
                </div>
            @else
                <img id="imagePreview" src="" alt="Vista previa" style="display:none;">
                <div id="imagePreviewEmpty" class="image-empty">
                    <span>📦</span><small>Sin imagen registrada</small>
                </div>
            @endif
        </div>

        <div class="image-upload-actions">
            <label for="imagen" class="image-dropzone" id="imageDropzone">
                <span class="upload-icon">↑</span>
                <strong>Seleccionar imagen</strong>
                <span>Haz clic o arrastra un archivo aquí</span>
                <small>Máximo 5 MB</small>
            </label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp" hidden>

            <div class="image-file-info" id="imageFileInfo">Se conservará la imagen actual si no seleccionas otra.</div>

            @if($product->imagen)
            <label class="remove-image-option">
                <input type="checkbox" name="eliminar_imagen" value="1" id="eliminarImagen">
                Eliminar imagen actual
            </label>
            @endif
        </div>
    </div>
    <div class="image-error" id="imageError" role="alert" style="display:none;"></div>
</div>

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
    <label class="form-label">Código de Caja</label>
    <input
        type="text"
        class="form-control"
        name="box_barcode"
        value="{{ old('box_barcode', $product->box_barcode ?? '') }}">
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
    


<div class="buttons">

<a href="{{ route('products.index') }}"
   class="btn-back">
   Volver
</a>

<button type="submit"
        class="btn-update">
    Actualizar Producto
</button>

</div>

</form>

</div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('imagen');
    const preview = document.getElementById('imagePreview');
    const empty = document.getElementById('imagePreviewEmpty');
    const info = document.getElementById('imageFileInfo');
    const error = document.getElementById('imageError');
    const dropzone = document.getElementById('imageDropzone');
    const remove = document.getElementById('eliminarImagen');
    if (!input || !preview || !empty) return;

    let currentObjectUrl = null;
    function showFile(file) {
        error.style.display = 'none';
        if (!file) return;
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            input.value = '';
            error.textContent = 'Formato no válido. Usa JPG, PNG o WEBP.';
            error.style.display = 'block';
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            input.value = '';
            error.textContent = 'La imagen supera el límite de 5 MB.';
            error.style.display = 'block';
            return;
        }
        if (currentObjectUrl) URL.revokeObjectURL(currentObjectUrl);
        currentObjectUrl = URL.createObjectURL(file);
        preview.src = currentObjectUrl;
        preview.style.display = 'block';
        empty.style.display = 'none';
        info.textContent = file.name + ' · ' + (file.size / 1024 / 1024).toFixed(2) + ' MB';
        if (remove) remove.checked = false;
    }
    input.addEventListener('change', () => showFile(input.files[0]));
    if (remove) {
        remove.addEventListener('change', function () {
            if (this.checked && !input.files.length) {
                preview.style.display = 'none';
                empty.style.display = 'flex';
                info.textContent = 'La imagen se eliminará al guardar los cambios.';
            } else if (!this.checked && !input.files.length) {
                preview.style.display = preview.src ? 'block' : 'none';
                empty.style.display = preview.src ? 'none' : 'flex';
                info.textContent = 'Se conservará la imagen actual si no seleccionas otra.';
            }
        });
    }
    if (dropzone) {
        ['dragenter','dragover'].forEach(evt => dropzone.addEventListener(evt, e => {
            e.preventDefault(); dropzone.classList.add('dragover');
        }));
        ['dragleave','drop'].forEach(evt => dropzone.addEventListener(evt, e => {
            e.preventDefault(); dropzone.classList.remove('dragover');
        }));
        dropzone.addEventListener('drop', e => {
            const file = e.dataTransfer.files && e.dataTransfer.files[0];
            if (!file) return;
            const transfer = new DataTransfer();
            transfer.items.add(file);
            input.files = transfer.files;
            showFile(file);
        });
    }
});
</script>

@endsection
