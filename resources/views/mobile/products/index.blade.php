<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#123a63">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/distan-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/distan-192.png') }}">
    <title>DISTAN Móvil · Productos</title>
    <style>
        :root{--navy:#123a63;--blue:#1769aa;--bg:#f2f5f9;--text:#172b4d;--muted:#64748b;--line:#e2e8f0;--green:#16845b}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif}
        header{background:linear-gradient(135deg,var(--navy),#1769aa);color:#fff;padding:22px 16px 24px;border-radius:0 0 22px 22px}
        .top{max-width:760px;margin:auto}.brand{font-size:12px;font-weight:800;letter-spacing:1.8px;opacity:.85}.title{font-size:25px;font-weight:800;margin:6px 0 4px}.subtitle{font-size:13px;opacity:.85}
        main{max-width:760px;margin:-12px auto 0;padding:0 12px 30px}.search{display:flex;gap:8px;background:#fff;padding:10px;border-radius:15px;box-shadow:0 5px 18px #102a4310;margin-bottom:15px}
        .search input{min-width:0;flex:1;border:1px solid var(--line);border-radius:10px;padding:12px;font-size:15px;outline-color:var(--blue)}button,.btn{border:0;background:var(--blue);color:#fff;border-radius:10px;padding:11px 14px;font-weight:750;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer}
        .count{font-size:12px;color:var(--muted);margin:8px 3px 12px}.product{background:#fff;border:1px solid var(--line);border-radius:16px;padding:14px;margin-bottom:10px;box-shadow:0 3px 12px #102a4307}
        .product-head{display:flex;gap:12px;align-items:flex-start}.photo{width:62px;height:62px;border-radius:12px;object-fit:cover;background:#e8eef5;flex-shrink:0}.placeholder{display:flex;align-items:center;justify-content:center;font-size:24px;color:#8ba0b8}
        .name{font-size:16px;line-height:1.3;font-weight:800;margin:1px 0 5px}.sku{font-size:12px;color:var(--muted);overflow-wrap:anywhere}.tag{display:inline-block;background:#eaf2ff;color:#1d4f91;border-radius:7px;padding:4px 7px;font-size:11px;font-weight:750;margin-top:6px}
        .details{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;margin:13px 0}.detail{background:#f7f9fc;border-radius:9px;padding:9px}.label{font-size:10px;text-transform:uppercase;letter-spacing:.4px;color:var(--muted)}.value{font-size:14px;font-weight:750;margin-top:3px;overflow-wrap:anywhere}
        .product-foot{display:flex;justify-content:space-between;align-items:center;gap:8px;border-top:1px solid #eef2f7;padding-top:11px}.stock{font-size:12px;color:var(--muted)}.stock strong{font-size:16px;color:var(--text)}.edit{min-height:42px}.notice{padding:12px 14px;border-radius:12px;background:#e7f8ef;color:#116443;margin-bottom:12px;font-size:14px}.error{padding:10px 12px;background:#fff0f0;color:#a52828;border-radius:10px;margin-bottom:10px}
        .pagination{display:flex;justify-content:center;gap:7px;flex-wrap:wrap;margin:18px 0}.pagination a,.pagination span{background:#fff;border:1px solid var(--line);padding:9px 12px;border-radius:9px;color:var(--text);text-decoration:none;font-size:13px}
        .empty{text-align:center;background:#fff;border:1px dashed #cbd5e1;border-radius:16px;padding:35px 15px;color:var(--muted)}.bottom{position:sticky;bottom:0;background:#ffffffed;border-top:1px solid var(--line);padding:10px 14px calc(10px + env(safe-area-inset-bottom));text-align:center;font-size:11px;color:var(--muted);backdrop-filter:blur(10px)}
    </style>
</head>
<body>
<nav style="display:flex;gap:8px;padding:10px 14px;max-width:760px;margin:auto"><a href="{{ route('mobile.products.index') }}" style="flex:1;text-align:center;padding:10px;border-radius:10px;background:#123a63;color:#fff;text-decoration:none;font-weight:800">Productos</a><a href="{{ route('mobile.orders.index') }}" style="flex:1;text-align:center;padding:10px;border-radius:10px;background:#fff;border:1px solid #dbe3ed;color:#123a63;text-decoration:none;font-weight:800">Pedidos</a></nav>
<header><div class="top"><div class="brand">DISTAN ERP</div><div class="title">Catálogo de productos</div><div class="subtitle">Escanea o escribe un código para consultar y ajustar stock</div></div></header>
<main>
    @if(session('success'))<div class="notice">✓ {{ session('success') }}</div>@endif
    @if($errors->any())<div class="error">No se pudo completar la operación. Revisa los datos del producto.</div>@endif
    <form class="search" method="GET" action="{{ route('mobile.products.index') }}">
        <input type="search" name="search" value="{{ $search }}" placeholder="Escanea o escribe el código del producto" aria-label="Código o nombre del producto" autofocus>
        <button type="submit">Consultar</button>
        @if($search !== '')<a class="btn" href="{{ route('mobile.products.index') }}" style="background:#64748b">✕</a>@endif
    </form>
    @if($search === '')
        <div class="empty"><div style="font-size:36px;margin-bottom:10px">▦</div><strong>Consulta un producto</strong><div style="font-size:13px;margin-top:7px">Escanea el código de barras o escríbelo arriba. Los productos aparecerán después de consultar.</div></div>
    @else
    <div class="count">{{ $products->total() }} resultado(s) para «{{ $search }}»</div>
    @forelse($products as $product)
        <article class="product">
            <div class="product-head">
                @if($product->imagen)<img class="photo" src="{{ asset('storage/'.$product->imagen) }}" alt="Imagen de {{ $product->nombre }}" loading="lazy">@else<div class="photo placeholder">▦</div>@endif
                <div style="min-width:0;flex:1"><div class="name">{{ $product->nombre }}</div><div class="sku">SKU: {{ $product->sku ?: '—' }}</div><div class="tag">{{ $product->category->nombre ?? 'Sin categoría' }}</div></div>
            </div>
            <div class="details">
                <div class="detail"><div class="label">Código de barras</div><div class="value">{{ $product->barcode ?: '—' }}</div></div>
                <div class="detail"><div class="label">Código de caja</div><div class="value">{{ $product->box_barcode ?: '—' }}</div></div>
                <div class="detail"><div class="label">Unidades por caja</div><div class="value">{{ $product->cantidad_por_caja ?? '—' }}</div></div>
                <div class="detail"><div class="label">Lote</div><div class="value">{{ $product->lote ?: '—' }}</div></div>
            </div>
            <div class="product-foot"><div class="stock">Stock actual<br><strong>{{ number_format((float)$product->stock, 2) }}</strong></div><a class="btn edit" href="{{ route('mobile.products.edit', $product) }}">Ver / ajustar →</a></div>
        </article>
    @empty
        <div class="empty"><div style="font-size:30px;margin-bottom:8px">⌕</div><strong>No se encontraron productos</strong><div style="font-size:13px;margin-top:5px">Prueba con otro nombre, SKU, código de barras o lote.</div></div>
    @endforelse
    @if($products->hasPages())<div class="pagination">{{ $products->links() }}</div>@endif
    @endif
</main>
<div class="bottom">DISTAN Móvil · Los cambios se guardan en la base de datos del ERP</div>
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
