<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"><meta name="theme-color" content="#123a63">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/distan-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/distan-192.png') }}">
    <title>Editar producto · DISTAN Móvil</title>
    <style>
        :root{--navy:#123a63;--blue:#1769aa;--bg:#f2f5f9;--text:#172b4d;--muted:#64748b;--line:#dbe3ed}*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
        header{background:linear-gradient(135deg,var(--navy),#1769aa);color:#fff;padding:20px 16px 25px;border-radius:0 0 22px 22px}.wrap{max-width:680px;margin:auto}.back{color:#fff;text-decoration:none;font-size:13px;font-weight:700}.title{font-size:23px;font-weight:850;margin:14px 0 4px}.sub{font-size:13px;opacity:.85;overflow-wrap:anywhere}
        main{max-width:680px;margin:-12px auto 0;padding:0 12px 35px}.card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:16px;margin-bottom:12px;box-shadow:0 4px 14px #102a4308}.section-title{font-weight:850;font-size:15px;margin:0 0 14px}.field{margin-bottom:14px}.field:last-child{margin-bottom:0}label{display:block;font-size:12px;font-weight:800;color:#334155;margin-bottom:6px}input,select,textarea{width:100%;min-height:45px;border:1px solid #cbd5e1;border-radius:10px;padding:11px 12px;background:#fff;color:var(--text);font:inherit;font-size:15px}textarea{min-height:90px;resize:vertical}.grid{display:grid;grid-template-columns:1fr 1fr;gap:0 12px}.full{grid-column:1/-1}.help{font-size:11px;color:var(--muted);margin-top:5px}.readonly{background:#f1f5f9;color:#475569}.image{width:100px;height:100px;object-fit:cover;border-radius:12px;border:1px solid var(--line);display:block;margin-bottom:10px}.notice{padding:12px;border-radius:10px;background:#fff7df;color:#805b00;font-size:12px;line-height:1.45;margin-bottom:12px}.errors{padding:12px;background:#fff0f0;color:#a52828;border-radius:10px;margin-bottom:12px;font-size:13px}.actions{position:sticky;bottom:0;display:flex;gap:9px;padding:12px 0 calc(12px + env(safe-area-inset-bottom));background:#f2f5f9ed;backdrop-filter:blur(8px)}.save,.cancel{display:flex;align-items:center;justify-content:center;min-height:48px;border-radius:11px;padding:12px;text-decoration:none;font-weight:800;font-size:14px;flex:1;border:0}.save{background:var(--blue);color:#fff}.cancel{background:#e2e8f0;color:#334155}
        @media(max-width:420px){.grid{grid-template-columns:1fr}.full{grid-column:auto}.card{padding:14px}}
    </style>
</head>
<body>
<header><div class="wrap"><a class="back" href="{{ route('mobile.products.index', ['search' => request('search', $product->barcode ?: $product->sku)]) }}">← Volver a la consulta</a><div class="title">Editar producto</div><div class="sub">{{ $product->nombre }} · SKU {{ $product->sku }}</div></div></header>
<main>
    @if($errors->any())<div class="errors"><strong>Revisa estos datos:</strong><ul style="margin:7px 0 0;padding-left:18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="notice">Desde aquí puedes corregir el stock físico. Cada diferencia se registrará como movimiento de ENTRADA o SALIDA con el motivo «AJUSTE DE STOCK DESDE DISTAN MÓVIL». Verifica el conteo antes de guardar.</div>
    <form action="{{ route('mobile.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="search_return" value="{{ request('search', $product->barcode ?: $product->sku) }}">
        <section class="card"><h2 class="section-title">Identificación</h2><div class="grid">
            <div class="field"><label for="sku">SKU *</label><input id="sku" name="sku" value="{{ old('sku',$product->sku) }}" required></div>
            <div class="field"><label for="nombre">Nombre del producto *</label><input id="nombre" name="nombre" value="{{ old('nombre',$product->nombre) }}" required></div>
            <div class="field"><label for="barcode">Código de barras</label><input id="barcode" name="barcode" value="{{ old('barcode',$product->barcode) }}" inputmode="numeric"></div>
            <div class="field"><label for="box_barcode">Código de caja</label><input id="box_barcode" name="box_barcode" value="{{ old('box_barcode',$product->box_barcode) }}" inputmode="numeric"></div>
            <div class="field"><label for="marca">Marca</label><input id="marca" name="marca" value="{{ old('marca',$product->marca) }}"></div>
            <div class="field"><label for="category_id">Categoría</label><select id="category_id" name="category_id"><option value="">Sin categoría</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string)old('category_id',$product->category_id)===(string)$category->id)>{{ $category->nombre }}</option>@endforeach</select></div>
            <div class="field full"><label for="descripcion">Descripción</label><textarea id="descripcion" name="descripcion">{{ old('descripcion',$product->descripcion) }}</textarea></div>
        </div></section>
        <section class="card"><h2 class="section-title">Presentación y trazabilidad</h2><div class="grid">
            <div class="field"><label for="cantidad_por_caja">Unidades por caja</label><input id="cantidad_por_caja" type="number" min="0" step="1" name="cantidad_por_caja" value="{{ old('cantidad_por_caja',$product->cantidad_por_caja) }}" inputmode="numeric"></div>
            <div class="field"><label for="peso">Peso (gramos)</label><input id="peso" type="number" min="0" step="0.01" name="peso" value="{{ old('peso',$product->peso) }}" inputmode="decimal"></div>
            <div class="field"><label for="lote">Lote</label><input id="lote" name="lote" value="{{ old('lote',$product->lote) }}"></div>
            <div class="field"><label for="rotacion">Rotación</label><select id="rotacion" name="rotacion"><option value="">Sin definir</option>@foreach(['MUY_ALTA'=>'Muy alta','ALTA'=>'Alta','MEDIA'=>'Media','BAJA'=>'Baja'] as $value=>$label)<option value="{{ $value }}" @selected(old('rotacion',$product->rotacion)===$value)>{{ $label }}</option>@endforeach</select></div>
            <div class="field"><label for="fecha_produccion">Fecha de producción</label><input id="fecha_produccion" type="date" name="fecha_produccion" value="{{ old('fecha_produccion',$product->fecha_produccion ? \Illuminate\Support\Carbon::parse($product->fecha_produccion)->format('Y-m-d') : '') }}"></div>
            <div class="field"><label for="fecha_vencimiento">Fecha de vencimiento</label><input id="fecha_vencimiento" type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento',$product->fecha_vencimiento ? \Illuminate\Support\Carbon::parse($product->fecha_vencimiento)->format('Y-m-d') : '') }}"></div>
        </div></section>
        <section class="card"><h2 class="section-title">Ajuste de stock</h2><div class="field"><label>Stock registrado actualmente</label><input class="readonly" value="{{ number_format((float)$product->stock,2,'.','') }}" readonly></div><div class="field"><label for="stock">Cantidad física contada *</label><input id="stock" type="number" name="stock" min="0" step="0.01" value="{{ old('stock', number_format((float)$product->stock,2,'.','')) }}" inputmode="decimal" required><div class="help">Escribe el saldo total real que contaste, no la diferencia. Puedes ingresar 0 si el producto no tiene unidades.</div></div></section>
        <section class="card"><h2 class="section-title">Imagen</h2>@if($product->imagen)<img class="image" src="{{ asset('storage/'.$product->imagen) }}" alt="Imagen actual">@endif<div class="field"><label for="imagen">Cambiar imagen del producto</label><input id="imagen" type="file" name="imagen" accept="image/*" capture="environment"><div class="help">Opcional · JPG, PNG o WEBP · máximo 4 MB.</div></div></section>
        <div class="actions"><a class="cancel" href="{{ route('mobile.products.index') }}">Cancelar</a><button class="save" type="submit">Guardar cambios</button></div>
    </form>
</main>
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register("{{ asset('sw.js') }}", { scope: '/' }).catch(function (error) {
            console.warn('DISTAN PWA: no se pudo registrar el service worker.', error);
        });
    });
}
</script>
</body>
</html>
