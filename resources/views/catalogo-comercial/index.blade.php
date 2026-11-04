@php
    // Logo opcional de DISTAN para el ícono de la pestaña y la pantalla de carga.
    // Ej: $catLogo = asset('images/distan-logo.png');   (si es null se usa la marca "D" dibujada)
    $catLogo = null;

    $catMeses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
    $catStamp = now()->format('j') . ' ' . $catMeses[(int) now()->format('n') - 1] . ' ' . now()->format('Y, H:i');

    // Ícono según el nombre de la categoría (si no coincide, caja genérica)
    $catIcon = function ($name) {
        $n = mb_strtolower((string) $name);
        foreach ([['conserv','🥫'],['galleta','🍪'],['bebida','🥤'],['lácte','🥛'],['lacte','🥛'],['snack','🍿'],['cereal','🌾'],
                  ['limpie','🧴'],['salsa','🍅'],['aceite','🫒'],['pasta','🍝'],['dulce','🍬'],['carne','🥩'],['congel','🧊']] as $p) {
            if (str_contains($n, $p[0])) { return $p[1]; }
        }
        return '📦';
    };
    $catImg = function ($p) {
        $i = $p->imagen ?? $p->image ?? $p->foto ?? null;
        if ($i && is_string($i) && !preg_match('#^(https?:)?//#', $i)) { $i = asset('storage/' . ltrim($i, '/')); }
        return is_string($i) ? $i : null;
    };
    $catMarcas = $products->getCollection()->pluck('marca')->filter()->unique()->sort()->values();

    // Paginación numerada (mismos datos del paginador; conserva los filtros de la URL)
    $cp = $products->currentPage();
    $lp = max(1, $products->lastPage());
    $catPages = collect([1, $lp])->merge(range(max(1, $cp - 2), min($lp, $cp + 2)))->unique()->sort()->values();
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#142d52">
    <title>Catálogo Comercial | DISTAN ERP</title>

    {{-- Ícono de la pestaña --}}
    @if($catLogo)
        <link rel="icon" href="{{ $catLogo }}">
        <link rel="apple-touch-icon" href="{{ $catLogo }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0' stop-color='%233da0ff'/%3E%3Cstop offset='1' stop-color='%231257c9'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='64' height='64' rx='15' fill='url(%23g)'/%3E%3Ctext x='32' y='46' font-size='42' font-weight='900' text-anchor='middle' fill='white' font-family='Arial,Helvetica,sans-serif'%3ED%3C/text%3E%3C/svg%3E">
    @endif

    <style>
        :root{--navy:#142d52;--blue:#1769aa;--pale:#edf5fc;--ink:#203047;--muted:#718096;--line:#e2e8f0;--green:#16845b;--amber:#b7791f;--red:#c53030}
        *{box-sizing:border-box}
        body{margin:0;background:#f1f6fc;color:var(--ink);font:14px/1.45 Inter,system-ui,-apple-system,Segoe UI,Arial,sans-serif}
        .nums{font-variant-numeric:tabular-nums}

        /* ── Pantalla de carga (marca DISTAN) ── */
        .cl-loader{position:fixed;inset:0;z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;
            background:radial-gradient(circle at 30% 20%,#eaf3ff 0%,#f8fbff 45%,#fff 100%);
            transition:opacity .45s ease,visibility .45s ease;animation:clOut .5s ease 8s forwards}
        .cl-loader.hide{opacity:0;visibility:hidden;pointer-events:none}
        @keyframes clOut{to{opacity:0;visibility:hidden;pointer-events:none}}
        .cl-logo{position:relative;width:96px;height:96px;display:flex;align-items:center;justify-content:center}
        .cl-logo img,.cl-logo svg{width:64px;height:64px;position:relative;z-index:2;filter:drop-shadow(0 6px 14px rgba(29,127,242,.35));animation:clPulse 1.6s ease-in-out infinite}
        .cl-ring{position:absolute;inset:0;border-radius:50%;border:4px solid #dbe8fb;border-top-color:#1d7ff2;animation:clSpin .9s linear infinite}
        @keyframes clSpin{to{transform:rotate(360deg)}}
        @keyframes clPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.07)}}
        .cl-t{font-size:15px;font-weight:800;color:#1e3a5f;letter-spacing:.3px}
        .cl-s{font-size:12px;color:#64748b;margin-top:-8px}
        .cl-bar{width:180px;height:4px;border-radius:99px;background:#e2e8f0;overflow:hidden}
        .cl-bar i{display:block;height:100%;width:40%;border-radius:99px;background:linear-gradient(90deg,#1d7ff2,#5eb0ff);animation:clBar 1.2s ease-in-out infinite}
        @keyframes clBar{0%{transform:translateX(-100%)}100%{transform:translateX(350%)}}

        /* ── Encabezado ── */
        .topbar{background:linear-gradient(90deg,#0f2748,#17407a);color:#fff;padding:14px 26px;display:flex;align-items:center;justify-content:space-between;gap:14px;box-shadow:0 2px 12px rgba(10,30,60,.25)}
        .tb-l{display:flex;align-items:center;gap:14px;min-width:0}
        .burger{width:40px;height:40px;border:none;background:transparent;color:#fff;cursor:pointer;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .burger:hover{background:rgba(255,255,255,.12)}
        .burger svg{width:24px;height:24px}
        .tb-ic{width:46px;height:46px;border-radius:11px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .tb-ic svg{width:26px;height:26px}
        .tb-t h1{margin:0;font-size:23px;font-weight:800;letter-spacing:-.2px;line-height:1.15}
        .tb-t p{margin:2px 0 0;font-size:13px;color:#cfe0f5}
        .stamp{display:flex;align-items:center;gap:9px;border:1px solid rgba(255,255,255,.28);border-radius:10px;padding:9px 14px;font-size:12.5px;color:#e3eefb;white-space:nowrap}
        .stamp svg{width:17px;height:17px;flex-shrink:0}
        .stamp small{display:block;font-size:10.5px;color:#a9c3e3;margin-top:1px}

        .wrap{max-width:1450px;margin:20px auto;padding:0 22px}

        /* ── KPIs ── */
        .kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-bottom:18px}
        .kpi{display:flex;align-items:center;gap:14px;border-radius:14px;padding:15px 18px;border:1px solid var(--line)}
        .kpi .ki{width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .kpi .ki svg{width:26px;height:26px}
        .kpi .label{font-size:14px;font-weight:700;color:#24364f}
        .kpi strong{display:block;font-size:30px;line-height:1.1;margin-top:2px;font-weight:800}
        .kpi.blue{background:#e8f1fd;border-color:#c9defb}.kpi.blue .ki{background:#cfe2fb;color:#1f6fd1}.kpi.blue strong{color:#173f73}
        .kpi.green{background:#e6f6ed;border-color:#c5e8d2}.kpi.green .ki{background:#cdeedb;color:#16845b}.kpi.green strong{color:#14583e}
        .kpi.amber{background:#fff3d8;border-color:#f6dca0}.kpi.amber .ki{background:#fde6ae;color:#b7791f}.kpi.amber strong{color:#8a5a0c}
        .kpi.red{background:#fde8e8;border-color:#f6c4c4}.kpi.red .ki{background:#fbd0d0;color:#c53030}.kpi.red strong{color:#9b2222}

        /* ── Categorías ── */
        .categories{display:flex;gap:10px;overflow-x:auto;padding:2px 2px 12px;margin-bottom:6px}
        .cat{flex:0 0 auto;min-width:96px;display:flex;flex-direction:column;align-items:center;gap:3px;white-space:nowrap;text-decoration:none;color:#35506f;background:#fff;border:1px solid var(--line);border-radius:12px;padding:11px 16px;transition:transform .15s,box-shadow .15s,background .15s}
        .cat:hover{transform:translateY(-2px);box-shadow:0 6px 16px #183b6014;border-color:#9cc5ee}
        .cat .ci{font-size:22px;line-height:1.1;height:26px;display:flex;align-items:center}
        .cat .ci svg{width:22px;height:22px}
        .cat b{font-size:13.5px;font-weight:700}
        .cat em{font-style:normal;font-size:12px;color:var(--muted)}
        .cat.active{background:#1769cf;border-color:#1769cf;color:#fff;box-shadow:0 6px 16px rgba(23,105,207,.35)}
        .cat.active em{color:#d6e7fb}

        /* ── Barra de filtros ── */
        .toolbar{display:flex;gap:10px;align-items:center;margin:8px 0 16px;flex-wrap:wrap}
        .search{flex:1;min-width:260px;display:flex;gap:9px;position:relative}
        .search svg{position:absolute;left:13px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#64748b;pointer-events:none}
                .search input,.toolbar select{border:1px solid #d5deea;border-radius:10px;padding:12px 13px;background:#fff;color:var(--ink);font:inherit;outline:none}
        .search input{width:100%;padding-left:40px}
        .search input:focus,.toolbar select:focus{border-color:#4a95dc;box-shadow:0 0 0 3px rgba(74,149,220,.15)}
        .toolbar select{min-width:150px;cursor:pointer}
        .btn{border:0;border-radius:10px;padding:12px 18px;background:var(--blue);color:#fff;text-decoration:none;font-weight:700;cursor:pointer;font:inherit;font-weight:700}
        .btn.light{background:#eaf2fb;color:#24517f}

        /* ── Tabla ── */
        .tablebox{background:#fff;border:1px solid var(--line);border-radius:14px;overflow:hidden;box-shadow:0 4px 16px #183b6010}
        .scroll{overflow-x:auto}
        table{width:100%;border-collapse:collapse;min-width:1240px}
        th{text-align:left;background:linear-gradient(180deg,#1b3f78,#143262);color:#fff;font-size:12.5px;font-weight:700;padding:14px 15px;white-space:nowrap}
        th.c,td.c{text-align:center}
        td{padding:12px 15px;border-bottom:1px solid #edf1f6;vertical-align:middle}
        tbody tr:nth-child(even){background:#fafcff}
        tbody tr:hover{background:#f1f7fe}
        tbody tr.raw-material-row{background:#f4f8fc;border-top:2px solid #d7e5f4}
        tbody tr.raw-material-row .icon{background:#e5effa}
        .sku{font-weight:800;color:#213d60;font-variant-numeric:tabular-nums}
        .sub{font-size:11px;color:var(--muted);margin-top:2px;font-variant-numeric:tabular-nums}
        .product{display:flex;align-items:center;gap:11px;min-width:230px}
        .icon{width:38px;height:38px;border-radius:10px;background:#edf5fc;display:grid;place-items:center;font-size:20px;flex-shrink:0;overflow:hidden}
        .icon img{width:100%;height:100%;object-fit:cover}
        .pname{font-weight:800;color:#1c3558}
        .num{font-weight:800;font-variant-numeric:tabular-nums;font-size:15px}
        .muted{color:var(--muted)}
        .status{display:inline-flex;align-items:center;gap:7px;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;white-space:nowrap}
        .status i{width:8px;height:8px;border-radius:50%;background:currentColor}
        .ok{background:#dff4e8;color:var(--green)}.low{background:#fff0c9;color:var(--amber)}.out{background:#fde0e0;color:var(--red)}
        .detail{display:inline-flex;align-items:center;gap:7px;font-size:12.5px;font-weight:700;text-decoration:none;color:#1769aa;background:#fff;border:1px solid #8dbbe6;padding:7px 14px;border-radius:9px;white-space:nowrap}
        .detail:hover{background:#edf5fc}
        .detail svg{width:15px;height:15px}
        .empty{text-align:center;padding:35px;color:var(--muted)}
        .nomatch{display:none;text-align:center;padding:22px;color:var(--muted)}

        /* ── Pie de tabla + paginación ── */
        .tfoot{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:14px 18px;border-top:1px solid var(--line)}
        .tfoot .info{font-size:13px;color:#4a5b73}
        .pager{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
        .pg{min-width:34px;height:34px;border:1px solid #d5deea;border-radius:8px;background:#fff;color:#35506f;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-weight:700;font-size:13px;padding:0 8px}
        .pg:hover{background:#edf5fc}
        .pg.on{background:#1769cf;border-color:#1769cf;color:#fff}
        .pg.off{opacity:.4;pointer-events:none}
        .gap{color:#8a98ab;padding:0 4px}
        .foot{color:var(--muted);font-size:12px;margin:14px 2px 28px}

        @media(max-width:900px){.kpis{grid-template-columns:repeat(2,minmax(0,1fr))}.topbar{padding:12px 14px}.tb-t h1{font-size:19px}.tb-t p{display:none}.stamp{display:none}.wrap{padding:0 12px}}
        @media(max-width:520px){.kpi{padding:12px}.kpi strong{font-size:24px}.kpi .ki{width:42px;height:42px}.toolbar select{flex:1}}
        .categories.collapsed{display:none}
    </style>
</head>
<body>

{{-- Pantalla de carga --}}
<div class="cl-loader" id="clLoader">
    <div class="cl-logo">
        <div class="cl-ring"></div>
        @if($catLogo)
            <img src="{{ $catLogo }}" alt="DISTAN">
        @else
            <svg viewBox="0 0 64 64" aria-hidden="true">
                <defs><linearGradient id="clg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#3da0ff"/><stop offset="1" stop-color="#1257c9"/></linearGradient></defs>
                <rect width="64" height="64" rx="15" fill="url(#clg)"/>
                <text x="32" y="46" font-size="42" font-weight="900" text-anchor="middle" fill="#fff" font-family="Arial,Helvetica,sans-serif">D</text>
            </svg>
        @endif
    </div>
    <div class="cl-t">DISTAN ERP</div>
    <div class="cl-s">Cargando catálogo comercial…</div>
    <div class="cl-bar"><i></i></div>
</div>

<header class="topbar">
    <div class="tb-l">
        <button type="button" class="burger" id="clBurger" title="Mostrar u ocultar categorías" aria-label="Menú de categorías">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
        </button>
        <div class="tb-ic">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1.2-5h15.6L21 9"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M5 12v8h14v-8"/><path d="M10 20v-5h4v5"/></svg>
        </div>
        <div class="tb-t">
            <h1>Catálogo Comercial (Ventas)</h1>
            <p>Consulta de productos, existencias y pedidos comprometidos</p>
        </div>
    </div>
    <div class="stamp">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
        <div>Última actualización: {{ $catStamp }}<small>Vista de solo lectura</small></div>
    </div>
</header>

<main class="wrap">

    <section class="kpis">
        <div class="kpi blue">
            <div class="ki"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg></div>
            <div><div class="label">Productos activos</div><strong>{{ number_format($totalActivos) }}</strong></div>
        </div>
        <div class="kpi green">
            <div class="ki"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <div><div class="label">Con stock</div><strong>{{ number_format($conStock) }}</strong></div>
        </div>
        <div class="kpi amber">
            <div class="ki"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div><div class="label">Stock bajo</div><strong>{{ number_format($stockBajo) }}</strong></div>
        </div>
        <div class="kpi red">
            <div class="ki"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
            <div><div class="label">Agotados</div><strong>{{ number_format($agotados) }}</strong></div>
        </div>
    </section>
        {{-- Categorías --}}
    <section class="categories" id="clCategories">
        <a href="{{ request()->url() }}" class="cat {{ !request('categoria') ? 'active' : '' }}">
            <span class="ci">📦</span><b>Todos</b><em>Catálogo</em>
        </a>
        @foreach($catMarcas as $marca)
            <a href="{{ request()->fullUrlWithQuery(['categoria' => $marca]) }}" class="cat {{ request('categoria') === $marca ? 'active' : '' }}">
                <span class="ci">{{ $catIcon($marca) }}</span>
                <b>{{ $marca }}</b><em>Marca</em>
            </a>
        @endforeach
    </section>

    {{-- Filtros --}}
    <form class="toolbar" method="GET" action="{{ request()->url() }}">
        @if(request('categoria'))
            <input type="hidden" name="categoria" value="{{ request('categoria') }}">
        @endif
        <div class="search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por producto, SKU o código...">
        </div>
        <select name="estado">
            <option value="">Todos los estados</option>
            <option value="stock" {{ request('estado') === 'stock' ? 'selected' : '' }}>Con stock</option>
            <option value="bajo" {{ request('estado') === 'bajo' ? 'selected' : '' }}>Stock bajo</option>
            <option value="agotado" {{ request('estado') === 'agotado' ? 'selected' : '' }}>Agotados</option>
        </select>
        <button type="submit" class="btn">Filtrar</button>
        <a href="{{ request()->url() }}" class="btn light">Limpiar</a>
    </form>

    {{-- Tabla de productos e inventarios externos --}}
    <section class="tablebox">
        <div class="scroll">
            <table id="clTable">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Producto / Material</th>
                        <th class="c">Peso / Presentación</th>
                        <th class="c">Stock DISTAN</th>
                        <th class="c">Comprometido</th>
                        <th class="c">Dalsa</th>
                        <th class="c">Joselito</th>
                        <th class="c">Estado</th>
                        <th class="c">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        @php
                            $stock = (float) ($p->stock ?? 0);
                            $committed = (float) ($p->comprometido ?? $p->stock_comprometido ?? 0);
                            $available = max(0, $stock - $committed);
                            $threshold = (float) ($p->minimum_stock ?? $p->stock_minimo ?? 0);
                            $state = $stock <= 0 ? 'out' : (($threshold > 0 && $available <= $threshold) ? 'low' : 'ok');
                            $stateText = $state === 'out' ? 'Agotado' : ($state === 'low' ? 'Stock bajo' : 'Disponible');
                            $img = $catImg($p);

                            // Cantidades que el controlador asocia por coincidencia normalizada.
                            $dalsaQty = (float) ($p->dalsa_stock ?? 0);
                            $joselitoQty = (float) ($p->joselito_stock ?? 0);
                        @endphp
                        <tr>
                            <td>
                                <div class="sku">{{ $p->sku ?? $p->codigo ?? '—' }}</div>
                                <div class="sub">{{ $p->codigo_barras ?? $p->barcode ?? '' }}</div>
                            </td>
                            <td>
                                <div class="product">
                                    <div class="icon">
                                        @if($img)
                                            <img src="{{ $img }}" alt="{{ $p->nombre ?? $p->name ?? 'Producto' }}" loading="lazy">
                                        @else
                                            {{ $catIcon($p->categoria ?? $p->marca ?? '') }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="pname">{{ $p->nombre ?? $p->name ?? 'Producto sin nombre' }}</div>
                                        <div class="sub">{{ $p->marca ?? $p->categoria ?? 'Sin categoría' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="c">{{ $p->peso ?? $p->presentacion ?? $p->unidad ?? '—' }}</td>
                            <td class="c"><span class="num">{{ number_format($stock, 2) }}</span></td>
                            <td class="c"><span class="num">{{ number_format($committed, 2) }}</span></td>
                            <td class="c"><span class="num">{{ number_format($dalsaQty, 2) }}</span></td>
                            <td class="c"><span class="num">{{ number_format($joselitoQty, 2) }}</span></td>
                            <td class="c"><span class="status {{ $state }}"><i></i>{{ $stateText }}</span></td>
                            <td class="c">
                                <a href="{{ route('catalogo-comercial.show', $p->id) }}" class="detail">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="empty">No se encontraron productos con los filtros seleccionados.</td></tr>
                    @endforelse

                    {{-- Materia prima: registros en la misma tabla --}}
                    @if($products->currentPage() === $products->lastPage())
                        @foreach(($rawMaterials ?? collect()) as $material)
                            @php
                                $materialStock = (float) ($material->stock ?? 0);
                            @endphp
                            <tr class="raw-material-row">
                                <td>
                                    <div class="sku">{{ $material->code ?? '—' }}</div>
                                    <div class="sub">MATERIA PRIMA</div>
                                </td>
                                <td>
                                    <div class="product">
                                        <div class="icon">🧱</div>
                                        <div>
                                            <div class="pname">{{ $material->name }}</div>
                                            <div class="sub">Materia prima · {{ $material->category ?? 'Sin categoría' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="c">{{ $material->unit ?? '—' }}</td>
                                <td class="c"><span class="num">{{ number_format($materialStock, 2) }}</span></td>
                                <td class="c"><span class="muted">—</span></td>
                                <td class="c"><span class="muted">—</span></td>
                                <td class="c"><span class="muted">—</span></td>
                                <td class="c">
                                    @if($materialStock <= 0)
                                        <span class="status out"><i></i>Agotado</span>
                                    @elseif(isset($material->minimum_stock) && $materialStock <= (float) $material->minimum_stock)
                                        <span class="status low"><i></i>Stock bajo</span>
                                    @else
                                        <span class="status ok"><i></i>Disponible</span>
                                    @endif
                                </td>
                                <td class="c"><span class="muted">Materia prima</span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="tfoot">
            <div class="info">
                Mostrando {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
                de {{ $products->total() }} productos
                @if($products->currentPage() === $products->lastPage())
                    · {{ ($rawMaterials ?? collect())->count() }} materiales
                @endif
            </div>
            <nav class="pager" aria-label="Paginación">
                @if($products->onFirstPage())
                    <span class="pg off">‹</span>
                @else
                    <a class="pg" href="{{ $products->previousPageUrl() }}">‹</a>
                @endif

                @foreach($catPages as $page)
                    @if($loop->first && $page > 1)
                        <span class="gap">…</span>
                    @endif
                    <a class="pg {{ $page === $cp ? 'on' : '' }}" href="{{ $products->url($page) }}">{{ $page }}</a>
                    @if($loop->last && $page < $lp)
                        <span class="gap">…</span>
                    @endif
                @endforeach

                @if($products->hasMorePages())
                    <a class="pg" href="{{ $products->nextPageUrl() }}">›</a>
                @else
                    <span class="pg off">›</span>
                @endif
            </nav>
        </div>
    </section>

    <div class="foot">DISTAN ERP · Catálogo comercial · Información de consulta</div>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ocultar pantalla de carga cuando el contenido esté listo.
    const loader = document.getElementById('clLoader');

    function hideLoader() {
        if (loader) {
            loader.classList.add('hide');
        }
    }

    window.addEventListener('load', hideLoader);
    setTimeout(hideLoader, 2500);

    // Mostrar u ocultar categorías.
    const burger = document.getElementById('clBurger');
    const categories = document.getElementById('clCategories');

    if (burger && categories) {
        burger.addEventListener('click', function () {
            categories.classList.toggle('collapsed');
        });
    }

    // Búsqueda rápida dentro de los registros que ya están cargados.
    const searchInput = document.querySelector('input[name="buscar"]');
    const table = document.getElementById('clTable');

    if (searchInput && table) {
        searchInput.addEventListener('input', function () {
            const term = this.value.toLocaleLowerCase('es').trim();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(function (row) {
                const text = row.textContent.toLocaleLowerCase('es');
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }
});
</script>

</body>
</html>