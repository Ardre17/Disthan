<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo Comercial | DISTAN ERP</title>
    <style>
        :root{--navy:#142d52;--blue:#1769aa;--pale:#edf5fc;--ink:#203047;--muted:#718096;--line:#e2e8f0;--green:#16845b;--amber:#b7791f;--red:#c53030}
        *{box-sizing:border-box}body{margin:0;background:#f4f7fb;color:var(--ink);font:14px/1.45 Inter,system-ui,-apple-system,Segoe UI,Arial,sans-serif}.topbar{background:var(--navy);color:white;padding:17px 28px;display:flex;align-items:center;justify-content:space-between;gap:14px}.brand{font-weight:800;letter-spacing:.4px;font-size:19px}.brand span{color:#86c5ff}.topbar small{color:#d7e6f7}.wrap{max-width:1450px;margin:25px auto;padding:0 22px}.heading{display:flex;align-items:end;justify-content:space-between;gap:14px;margin-bottom:20px}.heading h1{font-size:27px;margin:0 0 4px;color:#17345d}.heading p{margin:0;color:var(--muted)}.stamp{font-size:12px;color:var(--muted);text-align:right}.kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-bottom:23px}.kpi{background:#fff;border:1px solid var(--line);border-radius:13px;padding:17px 19px;box-shadow:0 3px 12px #183b6010}.kpi .label{font-size:12px;color:var(--muted);font-weight:650}.kpi strong{display:block;font-size:27px;margin-top:6px;color:#18385f}.kpi .dot{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:7px;background:var(--blue)}.categories{display:flex;gap:9px;overflow-x:auto;padding:2px 0 12px;margin-bottom:8px}.cat{white-space:nowrap;text-decoration:none;color:#35506f;background:#fff;border:1px solid var(--line);border-radius:11px;padding:10px 14px;font-weight:650}.cat.active,.cat:hover{background:var(--pale);border-color:#7ab4e7;color:#145a95}.cat em{font-style:normal;font-size:11px;color:var(--muted);margin-left:6px}.toolbar{display:flex;gap:10px;align-items:center;margin:10px 0 15px;flex-wrap:wrap}.search{flex:1;min-width:220px;display:flex;gap:9px}.search input,.toolbar select{border:1px solid #d5deea;border-radius:9px;padding:12px 13px;background:#fff;color:var(--ink);font:inherit}.search input{width:100%}.btn{border:0;border-radius:9px;padding:11px 16px;background:var(--blue);color:#fff;text-decoration:none;font-weight:700;cursor:pointer}.btn.light{background:#eaf2fb;color:#24517f}.tablebox{background:#fff;border:1px solid var(--line);border-radius:13px;overflow:hidden;box-shadow:0 3px 12px #183b6008}.tablehead{display:flex;justify-content:space-between;align-items:center;padding:16px 18px;border-bottom:1px solid var(--line);gap:12px}.tablehead strong{font-size:16px}.tablehead span{font-size:12px;color:var(--muted)}.scroll{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:940px}th{text-align:left;background:#f8fafc;color:#687b92;font-size:11px;text-transform:uppercase;letter-spacing:.45px;padding:13px 15px;border-bottom:1px solid var(--line)}td{padding:14px 15px;border-bottom:1px solid #edf1f6;vertical-align:middle}tbody tr:hover{background:#fbfdff}.product{display:flex;align-items:center;gap:10px;min-width:220px}.icon{width:35px;height:35px;border-radius:9px;background:#edf5fc;display:grid;place-items:center;color:#2269a5;font-size:17px;flex-shrink:0}.pname{font-weight:750;color:#213d60}.sub{font-size:11px;color:var(--muted);margin-top:3px}.num{font-weight:750;font-variant-numeric:tabular-nums}.muted{color:var(--muted)}.status{display:inline-flex;padding:5px 8px;border-radius:20px;font-size:11px;font-weight:800;white-space:nowrap}.ok{background:#e4f7ed;color:var(--green)}.low{background:#fff4d8;color:var(--amber)}.out{background:#fde8e8;color:var(--red)}.detail{font-size:12px;font-weight:750;text-decoration:none;color:#1769aa;background:#edf5fc;padding:8px 10px;border-radius:8px;white-space:nowrap}.pagination{padding:15px}.pagination nav{display:flex;justify-content:center}.pagination svg{width:18px}.empty{text-align:center;padding:35px;color:var(--muted)}.foot{color:var(--muted);font-size:12px;margin:14px 2px 28px}@media(max-width:800px){.topbar{padding:14px 17px}.wrap{padding:0 12px;margin-top:18px}.heading{align-items:start;flex-direction:column}.stamp{text-align:left}.kpis{grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.kpi{padding:13px}.kpi strong{font-size:23px}.toolbar select{flex:1}.heading h1{font-size:23px}}
    </style>
</head>
<body>
<header class="topbar"><div class="brand">DISTAN <span>ERP</span> <small>· Catálogo Comercial</small></div><small>Consulta de productos e inventario</small></header>
<main class="wrap">
    <div class="heading"><div><h1>Catálogo Comercial</h1><p>Consulta de existencias, compromisos y disponibilidad para ventas.</p></div><div class="stamp">Información actualizada al consultar<br>Vista de solo lectura</div></div>
    <section class="kpis">
        <div class="kpi"><div class="label"><i class="dot"></i>PRODUCTOS ACTIVOS</div><strong>{{ number_format($totalActivos) }}</strong></div>
        <div class="kpi"><div class="label"><i class="dot" style="background:#16845b"></i>CON EXISTENCIAS</div><strong>{{ number_format($conStock) }}</strong></div>
        <div class="kpi"><div class="label"><i class="dot" style="background:#d69e2e"></i>STOCK BAJO</div><strong>{{ number_format($stockBajo) }}</strong></div>
        <div class="kpi"><div class="label"><i class="dot" style="background:#c53030"></i>AGOTADOS</div><strong>{{ number_format($agotados) }}</strong></div>
    </section>
    <nav class="categories">
        <a class="cat {{ !request('category_id') ? 'active' : '' }}" href="{{ route('catalogo.publico.index', request()->except('category_id','page')) }}">▦ Todos <em>{{ $totalActivos }}</em></a>
        @foreach($categories as $category)
            <a class="cat {{ (string)request('category_id') === (string)$category->id ? 'active' : '' }}" href="{{ route('catalogo.publico.index', array_merge(request()->except('page'), ['category_id'=>$category->id])) }}">◈ {{ $category->nombre }} <em>{{ $categoryCounts[$category->id] ?? 0 }}</em></a>
        @endforeach
    </nav>
    <form class="toolbar" method="GET" action="{{ route('catalogo.publico.index') }}">
        @if(request('category_id'))<input type="hidden" name="category_id" value="{{ request('category_id') }}">@endif
        <div class="search"><input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar por producto, marca, SKU o código de barras..."><button class="btn" type="submit">Buscar</button></div>
        <select name="estado" aria-label="Filtrar disponibilidad" onchange="this.form.submit()"><option value="">Todos los estados</option><option value="disponible" @selected(request('estado')==='disponible')>Disponible</option><option value="bajo" @selected(request('estado')==='bajo')>Stock bajo</option><option value="agotado" @selected(request('estado')==='agotado')>Agotado</option></select>
        @if(request()->hasAny(['q','estado','category_id']))<a class="btn light" href="{{ route('catalogo.publico.index') }}">Limpiar</a>@endif
    </form>
    <section class="tablebox"><div class="tablehead"><strong>Productos</strong><span>{{ $products->total() }} resultados · Página {{ $products->currentPage() }} de {{ max(1,$products->lastPage()) }}</span></div>
        <div class="scroll"><table><thead><tr><th>Producto</th><th>SKU / Código</th><th>Presentación</th><th>Stock físico</th><th>Comprometido</th><th>No comprometido</th><th>Estado</th><th></th></tr></thead><tbody>
        @forelse($products as $product)
            @php
                $stock = (float)($product->stock ?? 0);
                $min = (float)($product->stock_minimo ?? 0);
                $statusClass = $stock <= 0 ? 'out' : (($min > 0 && $stock <= $min) ? 'low' : 'ok');
                $statusText = $stock <= 0 ? 'AGOTADO' : (($min > 0 && $stock <= $min) ? 'STOCK BAJO' : 'DISPONIBLE');
            @endphp
            <tr>
                <td><div class="product"><div class="icon">▣</div><div><div class="pname">{{ $product->nombre }}</div><div class="sub">{{ $product->marca ?: 'Sin marca' }} · {{ optional($product->category)->nombre ?: 'Sin categoría' }}</div></div></div></td>
                <td><div class="num">{{ $product->sku ?: '—' }}</div><div class="sub">U: {{ $product->barcode ?: '—' }}</div><div class="sub">C: {{ $product->box_barcode ?: '—' }}</div></td>
                <td>{{ $product->peso ? rtrim(rtrim(number_format((float)$product->peso, 3, '.', ''), '0'), '.') : '—' }} {{ $product->peso ? 'g' : '' }}<div class="sub">{{ (int)($product->cantidad_por_caja ?? 0) }} unidades/caja</div></td>
                <td><span class="num">{{ number_format($stock, 0) }}</span></td>
                <td><span class="num">{{ number_format((float)$product->comprometido_catalogo, 0) }}</span></td>
                <td><span class="num">{{ number_format((float)$product->no_comprometido_catalogo, 0) }}</span></td>
                <td><span class="status {{ $statusClass }}">{{ $statusText }}</span></td>
                <td><a class="detail" href="{{ route('catalogo.publico.show', $product) }}">Detalle →</a></td>
            </tr>
        @empty<tr><td colspan="8" class="empty">No se encontraron productos con esos filtros.</td></tr>@endforelse
        </tbody></table></div><div class="pagination">{{ $products->links() }}</div>
    </section>
    <p class="foot">Los compromisos son informativos y no modifican el stock físico. La disponibilidad no comprometida es una referencia para apoyar decisiones comerciales.</p>
</main>
</body></html>
