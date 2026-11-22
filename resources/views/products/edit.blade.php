@extends('layouts.app')

@section('content')

<style>

:root{--erp-primary:#2563eb;--erp-ink:#172033;--erp-muted:#64748b;--erp-line:#e2e8f0;--erp-bg:#f3f6fb}
.page{padding:clamp(12px,2.5vw,30px);background:var(--erp-bg);min-height:100vh}
.card{max-width:1120px;margin:0 auto;background:#fff;border:1px solid #e8edf5;border-radius:18px;box-shadow:0 12px 35px rgba(15,23,42,.07);padding:clamp(16px,2.5vw,30px);color:var(--erp-ink)}
.product-heading{display:flex;align-items:center;justify-content:space-between;gap:16px;padding-bottom:20px;margin-bottom:22px;border-bottom:1px solid var(--erp-line)}
.heading-main{display:flex;align-items:center;gap:13px;min-width:0}
.heading-icon{width:46px;height:46px;flex:0 0 46px;border-radius:13px;background:#eff6ff;color:#2563eb;display:grid;place-items:center;font-size:22px}
.product-heading h1{font-size:clamp(19px,2.5vw,25px);line-height:1.2;margin:0 0 5px;font-weight:800;letter-spacing:-.4px}
.product-heading p{margin:0;color:var(--erp-muted);font-size:13px}
.product-code{font-size:11px;font-weight:700;color:#475569;background:#f1f5f9;border:1px solid var(--erp-line);padding:7px 10px;border-radius:8px;white-space:nowrap}
.form-section{margin:22px 0}
.section-title{display:flex;align-items:center;gap:9px;font-size:14px;font-weight:800;color:#24324a;margin:0 0 14px}
.section-title:before{content:"";width:4px;height:17px;background:#3b82f6;border-radius:5px}
.row{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 16px}
.form-group{margin:0 0 15px;min-width:0}
label{display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:7px}
input:not([type=checkbox]):not([type=file]),select,textarea{display:block;width:100%;min-height:43px;padding:10px 12px;border:1px solid #d7dfeb;border-radius:9px;background:#fff;color:#172033;font:inherit;font-size:13px;box-sizing:border-box;outline:none;transition:border-color .15s,box-shadow .15s}
input:focus,select:focus,textarea:focus{border-color:#60a5fa!important;box-shadow:0 0 0 3px rgba(59,130,246,.12);outline:none}
textarea{min-height:105px;resize:vertical}
.image-panel{margin:8px 0 24px;padding:18px;background:linear-gradient(135deg,#f8fbff,#f1f6ff);border:1px solid #dce8fb;border-radius:14px}
.image-panel-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start;margin-bottom:15px}
.image-panel-head h3{margin:0 0 4px;font-size:14px;color:#172033;font-weight:800}
.image-panel-head p{margin:0;color:#64748b;font-size:12px}
.image-format{font-size:10px;font-weight:800;color:#1d4ed8;background:#dbeafe;padding:6px 9px;border-radius:7px;white-space:nowrap}
.image-upload-layout{display:grid;grid-template-columns:170px minmax(0,1fr);gap:18px;align-items:center}
.image-preview{width:170px;height:170px;border:1px solid #dce4ef;border-radius:12px;background:#fff;overflow:hidden;display:flex;align-items:center;justify-content:center;margin:0}
.image-preview img{width:100%;height:100%;object-fit:contain}
.image-empty{width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;color:#94a3b8}
.image-empty span{font-size:38px}.image-empty small{font-size:11px}
.image-upload-actions{min-width:0}
.image-dropzone{min-height:115px;border:2px dashed #93c5fd;border-radius:11px;background:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;color:#1d4ed8;cursor:pointer;text-align:center;padding:14px;transition:.15s}
.image-dropzone:hover,.image-dropzone.dragover{background:#eff6ff;border-color:#2563eb}
.image-dropzone strong{font-size:13px}.image-dropzone span:not(.upload-icon){font-size:11px;color:#475569}.image-dropzone small{font-size:10px;color:#64748b}
.upload-icon{width:30px;height:30px;border-radius:9px;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800}
.image-file-info{font-size:11px;color:#64748b;margin-top:8px;overflow-wrap:anywhere}
.remove-image-option{display:flex;align-items:center;gap:7px;margin-top:10px;font-size:11px;color:#b91c1c;font-weight:700}
.remove-image-option input{width:auto}
.image-error{margin-top:8px;color:#b91c1c;font-size:12px;font-weight:700}
input[type=checkbox]{width:16px;height:16px;accent-color:#2563eb;vertical-align:middle}
.warning-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;padding:13px;background:#f8fafc;border:1px solid var(--erp-line);border-radius:10px}
.warning-grid label{display:flex;align-items:center;gap:8px;margin:0;font-size:12px;font-weight:600}
.buttons{display:flex;justify-content:flex-end;gap:10px;margin-top:25px;padding-top:18px;border-top:1px solid var(--erp-line)}
.btn-back,.btn-update{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:43px;padding:11px 18px;border-radius:9px;font-size:13px;font-weight:800;text-decoration:none;cursor:pointer;transition:.15s}
.btn-back{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0}
.btn-back:hover{background:#e2e8f0}
.btn-update{background:#2563eb;color:#fff;border:1px solid #2563eb;box-shadow:0 4px 10px rgba(37,99,235,.18)}
.btn-update:hover{background:#1d4ed8}
.loading-screen{position:fixed;inset:0;z-index:99999;background:rgba(15,23,42,.58);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;padding:20px}
.loading-screen.active{display:flex}
.loading-card{width:min(320px,100%);background:#fff;border-radius:18px;padding:28px 22px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.22)}
.loading-mark{width:58px;height:58px;margin:0 auto 15px;border-radius:16px;background:#eff6ff;color:#2563eb;display:grid;place-items:center;font-size:25px;font-weight:900}
.loading-spinner{width:27px;height:27px;border:3px solid #dbeafe;border-top-color:#2563eb;border-radius:50%;animation:erpSpin .8s linear infinite;margin:0 auto 12px}
.loading-card strong{display:block;color:#172033;font-size:14px}.loading-card span{display:block;color:#64748b;font-size:12px;margin-top:5px}
@keyframes erpSpin{to{transform:rotate(360deg)}}
@media(max-width:640px){.page{padding:10px}.card{padding:15px;border-radius:14px}.product-heading{align-items:flex-start;padding-bottom:15px;margin-bottom:17px}.heading-icon{width:40px;height:40px;flex-basis:40px}.product-code{display:none}.row{grid-template-columns:1fr;gap:0}.image-upload-layout{grid-template-columns:1fr}.image-preview{width:100%;max-width:220px;height:190px;margin:0 auto}.image-panel{padding:14px}.image-panel-head{flex-direction:column}.warning-grid{grid-template-columns:1fr}.buttons{display:grid;grid-template-columns:1fr 1fr}.btn-back,.btn-update{padding:10px 8px;font-size:12px}}

</style>

<div class="page">

<div class="card">

<div class="product-heading">
    <div class="heading-main">
        <div class="heading-icon">✎</div>
        <div>
            <h1>Editar producto</h1>
            <p>Actualiza la información, identificación e inventario del producto.</p>
        </div>
    </div>
    <span class="product-code">SKU: {{ $product->sku ?: 'Sin SKU' }}</span>
</div>

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

<div class="form-section">
<h3 class="section-title">Identificación y presentación</h3>
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
</div>

<div class="form-section">
<h3 class="section-title">Descripción y advertencias</h3>
<div class="form-group">
<label>Descripción</label>

<textarea name="descripcion">{{ $product->descripcion }}</textarea>
</div>

@php
$advertencias = explode(',', $product->advertencias ?? '');
@endphp

<div class="form-group">

<label>⚠ Advertencias Nutricionales</label>

<div class="warning-grid">

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


<div class="loading-screen" id="productLoading" aria-live="polite" aria-hidden="true">
    <div class="loading-card">
        <div class="loading-mark">D</div>
        <div class="loading-spinner"></div>
        <strong>Actualizando producto</strong>
        <span>Estamos guardando los cambios. No cierres esta ventana.</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Favicon DISTAN: se agrega desde esta vista sin depender de archivos externos.
    const faviconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="64" height="64" rx="15" fill="#2563eb"/><path d="M18 13h15c14 0 22 8 22 19S47 51 33 51H18V13zm12 10v18h4c7 0 11-3 11-9s-4-9-11-9h-4z" fill="#fff"/></svg>`;
    let favicon = document.querySelector('link[rel~="icon"]');
    if (!favicon) { favicon = document.createElement('link'); favicon.rel = 'icon'; document.head.appendChild(favicon); }
    favicon.type = 'image/svg+xml';
    favicon.href = 'data:image/svg+xml,' + encodeURIComponent(faviconSvg);
    document.title = 'Editar producto | DISTAN ERP';

    const productForm = document.querySelector('form[action*="products"]');
    const loading = document.getElementById('productLoading');
    if (productForm && loading) {
        productForm.addEventListener('submit', function () {
            if (!productForm.checkValidity()) return;
            loading.classList.add('active');
            loading.setAttribute('aria-hidden', 'false');
        });
    }
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
