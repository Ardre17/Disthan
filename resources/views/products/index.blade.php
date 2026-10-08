@extends('layouts.app')

@section('content')
@php
    $role    = auth()->user()->role;
    $perPage = 8; // filas por página

    // Octógonos de advertencia (mismos valores y URLs que ya usabas)
    $octogonos = [
        'AZUCAR' => ['https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png', 'Alto en azúcar'],
        'SODIO'  => ['https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png', 'Alto en sodio'],
        'GRASAS' => ['https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png', 'Alto en grasas saturadas'],
    ];

    // Icono + color de cada categoría (por palabra clave; el resto usa un color según su nombre)
    $catMeta = function ($nombre) {
        $k = \Illuminate\Support\Str::ascii(mb_strtolower(trim((string) $nombre)));
        $map = [
            'galleta'   => ['🍪', 0],
            'bebida'    => ['🥤', 1],
            'lacteo'    => ['🥛', 2],
            'conserva'  => ['🥫', 3],
            'snack'     => ['🍿', 4],
            'limpieza'  => ['🧴', 5],
            'higiene'   => ['🧼', 6],
        ];
        foreach ($map as $kw => $v) {
            if (str_contains($k, $kw)) return ['icon' => $v[0], 'cls' => 'pv-c'.$v[1]];
        }
        return ['icon' => '📦', 'cls' => 'pv-c'.(7 + (crc32($k) % 3))];
    };

    $catKey = fn ($n) => mb_strtolower(trim((string) $n));

    // KPIs y conteo por categoría
    $hoy        = now()->startOfDay();
    $total      = $products->count();
    $stockBajo  = 0;
    $sinStock   = 0;
    $porVencer  = 0;
    $conteoCat  = [];

    foreach ($products as $p) {
        $s = (int) $p->stock;
        $m = (int) $p->stock_minimo;
        if ($s <= 0)      { $sinStock++; }
        elseif ($s <= $m) { $stockBajo++; }

        if ($p->fecha_vencimiento) {
            $d = (int) $hoy->diffInDays(\Carbon\Carbon::parse($p->fecha_vencimiento)->startOfDay(), false);
            if ($d >= 0 && $d <= 30) $porVencer++;
        }

        $k = (string) $p->category_id;
        $conteoCat[$k] = ($conteoCat[$k] ?? 0) + 1;
    }

    // Pestaña activa si llega ?category_id=
    $catActiva = '';

    if (request()->filled('category_id')) {
        $catActiva = (string) request('category_id');
    }
@endphp

<style>
.pv-page{
    --blue:#1f6fff; --blue-d:#1558d6; --ink:#1b2437; --muted:#6b7689;
    --line:#e6eaf1; --bg:#f3f6fb; --card:#fff;
    --green:#16a34a; --orange:#f59e0b; --red:#ef4444;
    background:var(--bg);
    font-family:'Inter','Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    color:var(--ink);
    padding:20px 24px 32px;
    font-size:13px;
    min-height:100%;
}
.pv-page *{box-sizing:border-box}
.pv-i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
.pv-mono{font-family:'Consolas','SFMono-Regular',Menlo,monospace}
.pv-page [hidden]{display:none !important}

/* ---------- Cabecera + KPIs ---------- */
.pv-head{display:grid;grid-template-columns:auto 1fr auto;gap:16px;align-items:center;margin-bottom:16px}
.pv-title-wrap{display:flex;gap:12px;align-items:center}
.pv-logo{width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#2f7bff,#1558d6);display:grid;place-items:center;color:#fff}
.pv-logo .pv-i{width:24px;height:24px}
.pv-title{font-size:26px;font-weight:700;margin:0;line-height:1.1}
.pv-sub{color:var(--muted);font-size:13px;margin-top:3px}
.pv-kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}
.pv-kpi{display:flex;align-items:center;gap:12px;border-radius:14px;padding:12px 14px;border:1px solid transparent;min-width:0}
.pv-kpi .ic{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;flex-shrink:0}
.pv-kpi .ic .pv-i{width:20px;height:20px}
.pv-kpi b{display:block;font-size:22px;line-height:1.1}
.pv-kpi span{color:var(--muted);font-size:12px}
.k-blue{background:#eaf2ff;border-color:#d5e5ff}.k-blue .ic{background:#d3e4ff;color:var(--blue)}
.k-green{background:#eaf8ef;border-color:#d1f0dc}.k-green .ic{background:#cdeedb;color:var(--green)}
.k-orange{background:#fff3e3;border-color:#ffe2bb}.k-orange .ic{background:#ffe0b3;color:#d97706}
.k-red{background:#ffecec;border-color:#ffd3d3}.k-red .ic{background:#ffd0d0;color:var(--red)}
.pv-btn-new{background:var(--blue);color:#fff;padding:13px 20px;border-radius:12px;font-weight:600;text-decoration:none;white-space:nowrap;display:inline-flex;gap:8px;align-items:center;transition:background .15s}
.pv-btn-new:hover{background:var(--blue-d);color:#fff}

/* ---------- Pestañas de categorías ---------- */
.pv-tabs{display:flex;gap:6px;overflow-x:auto;background:var(--card);border:1px solid var(--line);border-radius:14px;padding:6px;margin-bottom:12px;scrollbar-width:thin;scroll-snap-type:x proximity}
.pv-tab{flex:1 0 auto;min-width:96px;display:flex;align-items:center;justify-content:center;gap:9px;padding:9px 14px;border:0;background:transparent;border-radius:10px;cursor:pointer;font-family:inherit;color:var(--ink);scroll-snap-align:start;transition:background .15s}
.pv-tab:hover{background:#eef3fb}
.pv-tab .em{font-size:20px;line-height:1}
.pv-tab .t{display:flex;flex-direction:column;align-items:flex-start;text-align:left}
.pv-tab .n{font-size:11px;font-weight:700;letter-spacing:.3px;text-transform:uppercase}
.pv-tab .c{font-size:12.5px;font-weight:600;color:var(--muted)}
.pv-tab.active{background:var(--blue);color:#fff}
.pv-tab.active .c{color:#fff}
.pv-tab.all{flex-direction:column;gap:0}
.pv-tab.all .t{align-items:center;text-align:center}

/* ---------- Panel / barra de herramientas ---------- */
.pv-panel{background:var(--card);border:1px solid var(--line);border-radius:16px;overflow:hidden}
.pv-toolbar{display:flex;gap:12px;align-items:center;padding:14px}
.pv-search{flex:1;position:relative;min-width:0}
.pv-search .pv-i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#8892a4}
.pv-search input{width:100%;padding:11px 12px 11px 38px;border:1px solid var(--line);border-radius:10px;font-size:13px;font-family:inherit;background:#fff;color:var(--ink)}
.pv-search input:focus,.pv-sort select:focus{outline:2px solid #bcd3ff;border-color:var(--blue)}
.pv-count{color:var(--muted);white-space:nowrap}
.pv-sort{position:relative}
.pv-sort .pv-i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#6b7689;pointer-events:none}
.pv-sort select{appearance:none;-webkit-appearance:none;padding:11px 30px 11px 34px;border:1px solid var(--line);border-radius:10px;background:#fff;font-family:inherit;font-size:13px;color:var(--ink);cursor:pointer}

/* ---------- Tabla ---------- */
.pv-scroll{overflow-x:auto}
.pv-table{width:100%;border-collapse:collapse;min-width:1280px}
.pv-table th{font-size:10.5px;text-transform:uppercase;letter-spacing:.5px;color:#7a8497;text-align:left;padding:10px;border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:#fafbfd;white-space:nowrap;font-weight:700}
.pv-table td{padding:8px 10px;border-bottom:1px solid #eef1f6;vertical-align:middle;white-space:nowrap}
.pv-row:hover td{background:#f8fbff}
.pv-thumb{width:44px;height:44px;border:1px solid var(--line);border-radius:8px;background:#fff;display:grid;place-items:center;overflow:hidden;font-size:20px}
.pv-thumb img{max-width:100%;max-height:100%;object-fit:contain;display:block}
.pv-pname{font-weight:700;font-size:13px;white-space:normal;max-width:220px;line-height:1.25}
.pv-psub{color:var(--muted);font-size:11.5px;margin-top:2px}
.pv-pill{display:inline-block;padding:4px 10px;border-radius:7px;font-size:11.5px;font-weight:600}
.pv-c0{background:#fff0dc;color:#b45309}.pv-c1{background:#dff0ff;color:#1d6fb8}
.pv-c2{background:#efe6ff;color:#6d3fc4}.pv-c3{background:#ffe3e3;color:#c0312b}
.pv-c4{background:#fff6cf;color:#a16207}.pv-c5{background:#d9f7ee;color:#0f8a6a}
.pv-c6{background:#ffe4f1;color:#c2307a}.pv-c7{background:#e8edf5;color:#475569}
.pv-c8{background:#e3f2e1;color:#2f7d32}.pv-c9{background:#e6e9ff;color:#4338ca}
.pv-stock{font-size:13px}.pv-stock.zero{color:var(--red)}
.pv-venc.bad{color:var(--red);font-weight:700}.pv-venc.soon{color:#d97706;font-weight:700}
.pv-rot{display:inline-block;padding:4px 10px;border-radius:7px;font-size:11px;font-weight:700;letter-spacing:.3px;text-transform:uppercase}
.r-top{background:#d9f7e4;color:#15803d}.r-high{background:#e3f6e1;color:#2f8f3a}
.r-mid{background:#fff3cf;color:#a16207}.r-low{background:#ffe0e0;color:#c0312b}.r-none{background:#eef1f6;color:#6b7689}
.pv-est{display:inline-flex;align-items:center;gap:6px;font-weight:600;font-size:12.5px}
.pv-est:before{content:"";width:8px;height:8px;border-radius:50%;background:currentColor}
.e-ok{color:var(--green)}.e-low{color:#d97706}.e-out{color:var(--red)}
.pv-oct{display:flex;gap:4px;align-items:center}
.pv-oct img{height:26px;width:auto;max-width:34px;object-fit:contain;display:block}
.pv-none{color:#a0a9b8}

/* Acciones */
.pv-act{display:flex;gap:6px;align-items:center}
.pv-ab{width:34px;height:34px;display:inline-grid;place-items:center;border:1px solid var(--line);border-radius:9px;background:#fff;color:var(--blue);cursor:pointer;text-decoration:none;transition:background .15s}
.pv-ab:hover{background:#eef4ff}
.pv-ab.gray{color:#475569}
.pv-menu{display:none;position:fixed;z-index:60;min-width:170px;background:#fff;border:1px solid var(--line);border-radius:10px;box-shadow:0 10px 28px rgba(15,23,42,.18);padding:6px}
.pv-menu.open{display:block}
.pv-menu a,.pv-menu button{display:flex;align-items:center;gap:8px;width:100%;padding:9px 10px;border:0;background:none;border-radius:7px;font:inherit;font-size:13px;color:var(--ink);text-decoration:none;cursor:pointer;text-align:left}
.pv-menu a:hover,.pv-menu button:hover{background:#f2f5fa}
.pv-menu .del{color:var(--red)}.pv-menu .del:hover{background:#fff0f0}
.pv-menu form{margin:0}

/* Pie / paginación */
.pv-foot{display:flex;justify-content:space-between;align-items:center;padding:12px 14px;gap:10px;flex-wrap:wrap}
.pv-info{color:var(--muted)}
.pv-pages{display:flex;gap:6px;flex-wrap:wrap}
.pv-pg{min-width:34px;height:34px;padding:0 8px;border:1px solid var(--line);border-radius:8px;background:#fff;color:var(--ink);font:inherit;cursor:pointer}
.pv-pg:hover:not(:disabled):not(.active){background:#eef4ff}
.pv-pg.active{background:var(--blue);border-color:var(--blue);color:#fff;font-weight:700}
.pv-pg:disabled{opacity:.45;cursor:default}
.pv-dots{display:grid;place-items:center;min-width:24px;color:var(--muted)}
.pv-empty{padding:50px 20px;text-align:center;color:var(--muted)}
.pv-empty h2{color:var(--ink);font-size:16px;margin:0 0 6px}

/* ---------- Modal detalle ---------- */
.pv-modal{display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);z-index:9999;align-items:center;justify-content:center;padding:1rem}
.pv-modal-box{background:#fff;border-radius:16px;width:100%;max-width:520px;max-height:88vh;overflow-y:auto;box-shadow:0 14px 40px rgba(0,0,0,.3)}
.pv-modal-head{background:var(--blue);color:#fff;padding:.95rem 1.1rem;display:flex;justify-content:space-between;align-items:flex-start;gap:10px;position:sticky;top:0;z-index:1}
.pv-modal-name{font-size:15px;font-weight:700}
.pv-modal-sku{font-size:11px;color:#d6e4ff;font-family:'Consolas',Menlo,monospace;margin-top:2px}
.pv-modal-head button{background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;padding:2px 6px;flex-shrink:0}
.pv-modal-body{padding:1.1rem}
.pv-modal-img{width:100%;max-height:180px;object-fit:contain;background:#fafbfd;border-radius:10px;border:1px solid var(--line);margin-bottom:12px;display:block}
.pv-modal-title{font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);margin:14px 0 6px;padding-bottom:4px;border-bottom:2px solid var(--line)}
.pv-modal-title:first-of-type{margin-top:0}
.pv-modal-row{display:flex;justify-content:space-between;gap:12px;padding:5px 0;border-bottom:1px dashed #ecf0f4;font-size:12.5px}
.pv-modal-row:last-child{border-bottom:none}
.pv-modal-row .k{color:var(--muted)}
.pv-modal-row .v{font-weight:600;color:var(--ink);text-align:right}
.pv-modal-note{font-size:12px;color:var(--muted);font-style:italic;padding:6px 0}
.pv-modal-warn{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:6px}
.pv-modal-warn img{height:38px;width:auto}

/* ---------- Tablet ---------- */
@media (max-width:1180px){
    .pv-head{grid-template-columns:1fr auto}
    .pv-kpis{grid-column:1 / -1;order:3}
}

/* ---------- Celular / tablet chica: la tabla pasa a tarjetas ---------- */
@media (max-width:860px){
    .pv-page{padding:14px 12px 28px}
    .pv-title{font-size:22px}
    .pv-btn-new{padding:11px 14px}
    .pv-kpis{grid-template-columns:repeat(2,minmax(0,1fr))}
    .pv-toolbar{flex-wrap:wrap}
    .pv-search{flex:1 1 100%}
    .pv-count{flex:1}
    .pv-scroll{overflow:visible}
    .pv-table{min-width:0;display:block}
    .pv-table thead{display:none}
    .pv-table tbody{display:block;padding:10px;background:var(--bg);border-top:1px solid var(--line)}
    .pv-row{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:8px;row-gap:10px;background:#fff;border:1px solid var(--line);border-radius:14px;padding:12px;margin-bottom:10px}
    .pv-row:last-child{margin-bottom:0}
    .pv-table .pv-row td{display:block;padding:0;border:0;white-space:normal;grid-column:span 3;background:none}
    .pv-table .pv-row td:before{content:attr(data-label);display:block;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#8892a4;margin-bottom:3px}
    .pv-table .pv-row td.c-check{display:none}
    .pv-table .pv-row td.c-img{order:1;grid-column:span 1}
    .pv-table .pv-row td.c-prod{order:2;grid-column:span 5}
    .pv-table .pv-row td.c-img:before,.pv-table .pv-row td.c-prod:before,.pv-table .pv-row td.c-act:before{display:none}
    .pv-table .pv-row td.c-est{order:3}.pv-table .pv-row td.c-stock{order:4}
    .pv-table .pv-row td.c-caja{order:5}.pv-table .pv-row td.c-venc{order:6}
    .pv-table .pv-row td.c-rot{order:7}.pv-table .pv-row td.c-cat{order:8}
    .pv-table .pv-row td.c-sku{order:9}.pv-table .pv-row td.c-cu{order:10}
    .pv-table .pv-row td.c-cc{order:11}
    .pv-table .pv-row td.c-oct{order:12;grid-column:1 / -1}
    .pv-table .pv-row td.c-act{order:13;grid-column:1 / -1;border-top:1px solid #eef1f6;padding-top:10px}
    .pv-act{justify-content:flex-end}
    .pv-thumb{width:100%;height:auto;aspect-ratio:1/1;max-width:56px}
    .pv-pname{max-width:none;font-size:14px}
    .pv-foot{flex-direction:column;align-items:stretch;text-align:center}
    .pv-pages{justify-content:center}
}
@media (min-width:600px) and (max-width:860px){
    .pv-table .pv-row td{grid-column:span 2}
    .pv-table .pv-row td.c-img{grid-column:span 1}
    .pv-table .pv-row td.c-prod{grid-column:span 5}
    .pv-table .pv-row td.c-oct,.pv-table .pv-row td.c-act{grid-column:1 / -1}
}
@media (max-width:420px){
    .pv-kpi{padding:10px;gap:9px}
    .pv-kpi .ic{width:36px;height:36px}
    .pv-kpi b{font-size:19px}
    .pv-tab{min-width:84px;padding:8px 10px}
}
</style>

{{-- Iconos (sprite SVG) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="i-box" viewBox="0 0 24 24"><path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3.3 7.5L12 12.5l8.7-5M12 22V12.5"/></symbol>
    <symbol id="i-trend" viewBox="0 0 24 24"><path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="i-xc" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M15 9l-6 6M9 9l6 6"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
    <symbol id="i-eye" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="i-pen" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></symbol>
    <symbol id="i-dots" viewBox="0 0 24 24"><circle cx="12" cy="5" r="1.7" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r="1.7" fill="currentColor" stroke="none"/><circle cx="12" cy="19" r="1.7" fill="currentColor" stroke="none"/></symbol>
    <symbol id="i-sort" viewBox="0 0 24 24"><path d="M7 4v16M7 4L3 8M7 4l4 4M17 20V4M17 20l-4-4M17 20l4-4"/></symbol>
    <symbol id="i-trash" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14"/></symbol>
    <symbol id="i-truck" viewBox="0 0 24 24"><path d="M1 6h13v10H1zM14 10h4l3 3v3h-7"/><circle cx="6" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></symbol>
</svg>

<div class="pv-page">

    {{-- ===== Cabecera + KPIs ===== --}}
    <div class="pv-head">
        <div class="pv-title-wrap">
            <div class="pv-logo"><svg class="pv-i"><use href="#i-box"/></svg></div>
            <div>
                <h1 class="pv-title">Productos</h1>
                <div class="pv-sub">Gestiona tu catálogo de productos</div>
            </div>
        </div>

        <div class="pv-kpis">
            <div class="pv-kpi k-blue">
                <div class="ic"><svg class="pv-i"><use href="#i-box"/></svg></div>
                <div><b>{{ $total }}</b><span>Productos totales</span></div>
            </div>
            <div class="pv-kpi k-green">
                <div class="ic"><svg class="pv-i"><use href="#i-trend"/></svg></div>
                <div><b>{{ $stockBajo }}</b><span>Stock bajo</span></div>
            </div>
            <div class="pv-kpi k-orange">
                <div class="ic"><svg class="pv-i"><use href="#i-clock"/></svg></div>
                <div><b>{{ $porVencer }}</b><span>Por vencer</span></div>
            </div>
            <div class="pv-kpi k-red">
                <div class="ic"><svg class="pv-i"><use href="#i-xc"/></svg></div>
                <div><b>{{ $sinStock }}</b><span>Sin stock</span></div>
            </div>
        </div>

        <a href="{{ route('products.create') }}" class="pv-btn-new">
            <svg class="pv-i"><use href="#i-plus"/></svg> Nuevo Producto
        </a>
    </div>

    {{-- ===== Pestañas de categorías ===== --}}
    <div class="pv-tabs" id="pvTabs">
        <button type="button" class="pv-tab all {{ $catActiva === '' ? 'active' : '' }}" data-cat="">
            <span class="t"><span class="n">Todos</span><span class="c">{{ $total }}</span></span>
        </button>

        @foreach($categories as $category)
            @php
                $key  = (string) $category->id;
                $meta = $catMeta($category->nombre);
            @endphp

            <button type="button" class="pv-tab {{ $catActiva === $key ? 'active' : '' }}" data-cat="{{ $key }}">
                <span class="em">{{ $meta['icon'] }}</span>
                <span class="t">
                    <span class="n">{{ $category->nombre }}</span>
                    <span class="c">{{ $conteoCat[$key] ?? 0 }}</span>
                </span>
            </button>
        @endforeach
    </div>

    {{-- ===== Panel principal ===== --}}
    <div class="pv-panel">

        <div class="pv-toolbar">
            <div class="pv-search">
                <svg class="pv-i"><use href="#i-search"/></svg>
                <input type="text" id="pvSearch" value="{{ request('search') }}"
                       placeholder="Buscar por nombre, SKU, código de barras, código de caja o lote..." autocomplete="off">
            </div>
            <div class="pv-count" id="pvCount">{{ $total }} productos</div>
            <div class="pv-sort">
                <svg class="pv-i"><use href="#i-sort"/></svg>
                <select id="pvSort" aria-label="Ordenar por">
                    <option value="">Ordenar por</option>
                    <option value="nombre-asc">Nombre (A-Z)</option>
                    <option value="stock-asc">Stock (menor a mayor)</option>
                    <option value="stock-desc">Stock (mayor a menor)</option>
                    <option value="venc-asc">Vencimiento más próximo</option>
                    <option value="rot-desc">Rotación (mayor a menor)</option>
                </select>
            </div>
        </div>

        @if($products->count())
        <div class="pv-scroll">
            <table class="pv-table">
                <thead>
                    <tr>
                        <th style="width:36px"><input type="checkbox" id="pvCheckAll" aria-label="Seleccionar todos"></th>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Código unidad</th>
                        <th>Código caja</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Caja</th>
                        <th>Vencimiento</th>
                        <th>Rotación</th>
                        <th>Estado</th>
                        <th>Octógonos</th>
                        <th style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="pvBody">
                @foreach($products as $product)
                    @php
                        $stk = (int) $product->stock;
                        $min = (int) $product->stock_minimo;

                        if ($stk <= 0)       { $estado = 'Sin stock';  $estCls = 'e-out'; }
                        elseif ($stk <= $min){ $estado = 'Stock bajo'; $estCls = 'e-low'; }
                        else                 { $estado = 'Activo';     $estCls = 'e-ok'; }

                        // Vencimiento
                        $vencTxt = '—'; $vencCls = ''; $vencTs = 0;
                        if ($product->fecha_vencimiento) {
                            $fv      = \Carbon\Carbon::parse($product->fecha_vencimiento)->startOfDay();
                            $vencTxt = $fv->format('d/m/Y');
                            $vencTs  = $fv->timestamp;
                            $dias    = (int) $hoy->diffInDays($fv, false);
                            if ($dias < 0)        { $vencCls = 'bad'; }
                            elseif ($dias <= 30)  { $vencCls = 'soon'; }
                        }

                        // Rotación
                        $rot = strtoupper((string) $product->rotacion);
                        $rotMap = [
                            'MUY_ALTA' => ['r-top', 4],
                            'ALTA'     => ['r-high', 3],
                            'MEDIA'    => ['r-mid', 2],
                        ];
                        if ($rot === '')              { $rotCls = 'r-none'; $rotRank = 0; }
                        else                          { $rotCls = $rotMap[$rot][0] ?? 'r-low'; $rotRank = $rotMap[$rot][1] ?? 1; }

                        // Octógonos
                        $adv = array_filter(array_map('trim', explode(',', strtoupper($product->advertencias ?? ''))));

                        $meta   = $catMeta($product->categoria);
                        $buscar = \Illuminate\Support\Str::ascii(mb_strtolower(
                            $product->nombre.' '.$product->sku.' '.$product->barcode.' '.$product->box_barcode.' '.$product->lote
                        ));

                        // Datos para el modal de detalle
                        $mdData = [
                            'sku' => $product->sku,
                            'nombre' => $product->nombre,
                            'categoria' => $product->categoria,
                            'imagen' => $product->imagen ? asset('storage/'.$product->imagen) : null,
                            'advertencias' => $product->advertencias,
                            'lote' => $product->lote,
                            'stock' => $product->stock,
                            'stock_minimo' => $product->stock_minimo,
                            'cantidad_por_caja' => $product->cantidad_por_caja,
                            'fecha_produccion' => $product->fecha_produccion,
                            'fecha_vencimiento' => $product->fecha_vencimiento,
                            'barcode' => $product->barcode,
                            'box_barcode' => $product->box_barcode,
                            'rotacion' => $product->rotacion,
                            'logistic' => null,
                        ];

                        if ($product->logistic) {
                            $mdData['logistic'] = [
                                'largo_cm' => $product->logistic->largo_cm,
                                'ancho_cm' => $product->logistic->ancho_cm,
                                'alto_cm' => $product->logistic->alto_cm,
                                'peso_caja' => $product->logistic->peso_caja,
                                'max_cajas_pallet' => $product->logistic->max_cajas_pallet,
                                'max_niveles' => $product->logistic->max_niveles,
                                'altura_maxima_pallet' => $product->logistic->altura_maxima_pallet,
                                'permite_mezcla' => $product->logistic->permite_mezcla,
                                'orientacion' => $product->logistic->orientacion,
                                'activo' => $product->logistic->activo,
                            ];
                        }
                    @endphp

                    <tr class="pv-row"
                        data-idx="{{ $loop->index }}"
                        data-cat="{{ (string) $product->category_id }}"
                        data-nombre="{{ \Illuminate\Support\Str::ascii(mb_strtolower($product->nombre)) }}"
                        data-stock="{{ $stk }}"
                        data-venc="{{ $vencTs }}"
                        data-rot="{{ $rotRank }}"
                        data-search="{{ $buscar }}"
                        @if($loop->index >= $perPage) hidden @endif>

                        <td class="c-check"><input type="checkbox" class="pv-chk" aria-label="Seleccionar"></td>

                        <td class="c-img" data-label="Imagen">
                            <div class="pv-thumb">
                                @if($product->imagen)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($product->imagen) }}"
                                        alt="{{ $product->nombre }}"
                                        loading="lazy"
                                        decoding="async"
                                        onerror="this.style.display='none'; this.parentElement.innerHTML='📦';">
                                    @else
                                    📦
                                @endif
                            </div>
                        </td>

                        <td class="c-prod" data-label="Producto">
                            <div class="pv-pname">{{ $product->nombre }}</div>
                            <div class="pv-psub">Lote: {{ $product->lote ?: '—' }}</div>
                        </td>

                        <td class="c-sku" data-label="SKU"><span class="pv-mono">{{ $product->sku }}</span></td>
                        <td class="c-cu" data-label="Código unidad"><span class="pv-mono">{{ $product->barcode ?: '—' }}</span></td>
                        <td class="c-cc" data-label="Código caja"><span class="pv-mono">{{ $product->box_barcode ?: '—' }}</span></td>

                        <td class="c-cat" data-label="Categoría">
                            <span class="pv-pill {{ $meta['cls'] }}">{{ $product->categoria }}</span>
                        </td>

                        <td class="c-stock" data-label="Stock">
                            <b class="pv-stock pv-mono {{ $stk <= 0 ? 'zero' : '' }}">{{ $stk }}</b>
                        </td>

                        <td class="c-caja" data-label="Caja"><span class="pv-mono">{{ $product->cantidad_por_caja }}</span></td>

                        <td class="c-venc" data-label="Vencimiento">
                            <span class="pv-venc pv-mono {{ $vencCls }}">{{ $vencTxt }}</span>
                        </td>

                        <td class="c-rot" data-label="Rotación">
                            <span class="pv-rot {{ $rotCls }}">{{ $rot !== '' ? str_replace('_', ' ', $rot) : '—' }}</span>
                        </td>

                        <td class="c-est" data-label="Estado">
                            <span class="pv-est {{ $estCls }}">{{ $estado }}</span>
                        </td>

                        <td class="c-oct" data-label="Octógonos">
                            @if(count($adv))
                                <div class="pv-oct">
                                    @foreach($octogonos as $clave => $oct)
                                        @if(in_array($clave, $adv))
                                            <img src="{{ $oct[0] }}" alt="{{ $oct[1] }}" title="{{ $oct[1] }}" loading="lazy">
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <span class="pv-none">—</span>
                            @endif
                        </td>

                        <td class="c-act">
                            <div class="pv-act">
                                <button type="button" class="pv-ab" title="Ver detalle"
                                        onclick='abrirDetalle(@json($mdData, JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG))'>
                                    <svg class="pv-i"><use href="#i-eye"/></svg>
                                </button>

                                @if($role == 'admin')
                                    <a href="{{ route('products.edit', $product) }}" class="pv-ab" title="Editar">
                                        <svg class="pv-i"><use href="#i-pen"/></svg>
                                    </a>

                                    <div>
                                        <button type="button" class="pv-ab gray pv-more" title="Más opciones">
                                            <svg class="pv-i"><use href="#i-dots"/></svg>
                                        </button>
                                        <div class="pv-menu">
                                            <a href="{{ route('products.logistic.edit', $product) }}">
                                                <svg class="pv-i"><use href="#i-truck"/></svg> Logística
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="del"
                                                        onclick="return confirm('¿Eliminar producto?')">
                                                    <svg class="pv-i"><use href="#i-trash"/></svg> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pv-empty" id="pvNoResults" hidden>
            <h2>Sin resultados</h2>
            <p>No se encontraron productos con ese filtro o búsqueda.</p>
        </div>

        <div class="pv-foot">
            <div class="pv-info" id="pvInfo">Mostrando 0 productos</div>
            <div class="pv-pages" id="pvPager"></div>
        </div>
        @else
        <div class="pv-empty">
            <h2>No existen productos registrados</h2>
            <p>Comienza creando tu primer producto.</p>
        </div>
        @endif
    </div>

    {{-- ===== Modal detalle de producto (compartido, se llena vía JS) ===== --}}
    <div id="modalDetalle" class="pv-modal">
        <div class="pv-modal-box">
            <div class="pv-modal-head">
                <div>
                    <div class="pv-modal-name" id="mdNombre">—</div>
                    <div class="pv-modal-sku" id="mdSku">SKU: —</div>
                </div>
                <button type="button" onclick="cerrarDetalle()">✕</button>
            </div>
            <div class="pv-modal-body">

                <img id="mdImagen" class="pv-modal-img" style="display:none;">

                <div class="pv-modal-warn" id="mdWarnings"></div>

                <div class="pv-modal-title">Información general</div>
                <div class="pv-modal-row"><span class="k">Categoría</span><span class="v" id="mdCategoria">—</span></div>
                <div class="pv-modal-row"><span class="k">Lote</span><span class="v" id="mdLote">—</span></div>
                <div class="pv-modal-row"><span class="k">Stock actual</span><span class="v" id="mdStock">—</span></div>
                <div class="pv-modal-row"><span class="k">Stock mínimo</span><span class="v" id="mdStockMin">—</span></div>
                <div class="pv-modal-row"><span class="k">Unidades por caja</span><span class="v" id="mdCaja">—</span></div>
                <div class="pv-modal-row"><span class="k">Rotación</span><span class="v" id="mdRotacion">—</span></div>

                <div class="pv-modal-title">Vencimiento</div>
                <div class="pv-modal-row"><span class="k">Fecha de producción</span><span class="v" id="mdFechaProd">—</span></div>
                <div class="pv-modal-row"><span class="k">Fecha de vencimiento</span><span class="v" id="mdFechaVenc">—</span></div>
                <div class="pv-modal-row"><span class="k">Estado</span><span class="v" id="mdEstadoVenc">—</span></div>

                <div class="pv-modal-title">Códigos</div>
                <div class="pv-modal-row"><span class="k">Código unidad</span><span class="v" id="mdBarcode">—</span></div>
                <div class="pv-modal-row"><span class="k">Código caja</span><span class="v" id="mdBoxBarcode">—</span></div>

                <div class="pv-modal-title">Logística</div>
                <div id="mdLogistica"></div>

            </div>
        </div>
    </div>

</div>

<script>
/* =========================================================
   Modal de detalle (funciones globales, llamadas desde onclick)
========================================================= */
function diasHasta(fechaStr){
    if(!fechaStr) return null;
    var hoy = new Date();
    hoy.setHours(0,0,0,0);
    var fecha = new Date(fechaStr);
    fecha.setHours(0,0,0,0);
    return Math.round((fecha - hoy) / (1000*60*60*24));
}

function fila(k, v){
    return '<div class="pv-modal-row"><span class="k">' + k + '</span><span class="v">' + v + '</span></div>';
}

function abrirDetalle(p){
    document.getElementById('mdNombre').textContent = p.nombre || '—';
    document.getElementById('mdSku').textContent = 'SKU: ' + (p.sku || '—');

    var img = document.getElementById('mdImagen');
    if(p.imagen){
        img.src = p.imagen;
        img.style.display = 'block';
    } else {
        img.style.display = 'none';
    }

    // Octógonos de advertencia
    var warnBox = document.getElementById('mdWarnings');
    warnBox.innerHTML = '';
    var advertencias = (p.advertencias || '').toUpperCase().split(',');
    var iconos = {
        'AZUCAR': 'https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png',
        'SODIO': 'https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png',
        'GRASAS': 'https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png'
    };
    advertencias.forEach(function(a){
        a = a.trim();
        if(iconos[a]){
            var im = document.createElement('img');
            im.src = iconos[a];
            warnBox.appendChild(im);
        }
    });

    document.getElementById('mdCategoria').textContent = p.categoria || '—';
    document.getElementById('mdLote').textContent = p.lote || '—';
    document.getElementById('mdStock').textContent = (p.stock ?? '—');
    document.getElementById('mdStockMin').textContent = (p.stock_minimo ?? '—');
    document.getElementById('mdCaja').textContent = (p.cantidad_por_caja ?? '—');
    document.getElementById('mdRotacion').textContent = p.rotacion ? p.rotacion.replace('_',' ') : '—';

    document.getElementById('mdFechaProd').textContent = p.fecha_produccion || '—';
    document.getElementById('mdFechaVenc').textContent = p.fecha_vencimiento || '—';

    var estadoEl = document.getElementById('mdEstadoVenc');
    if(p.fecha_vencimiento){
        var dias = diasHasta(p.fecha_vencimiento);
        if(dias < 0){
            estadoEl.innerHTML = '<span style="color:#c0312b;">🔴 Vencido</span>';
        } else if(dias <= 30){
            estadoEl.innerHTML = '<span style="color:#b9690e;">🟠 Próximo a vencer (' + dias + 'd)</span>';
        } else {
            estadoEl.innerHTML = '<span style="color:#1c7c4d;">🟢 Vigente (' + dias + 'd)</span>';
        }
    } else {
        estadoEl.textContent = '—';
    }

    document.getElementById('mdBarcode').textContent = p.barcode || '—';
    document.getElementById('mdBoxBarcode').textContent = p.box_barcode || '—';

    // Logística
    var logBox = document.getElementById('mdLogistica');
    if(p.logistic){
        var l = p.logistic;
        logBox.innerHTML =
            fila('Dimensiones (LxAxA cm)', (l.largo_cm ?? '—') + ' x ' + (l.ancho_cm ?? '—') + ' x ' + (l.alto_cm ?? '—')) +
            fila('Peso por caja', (l.peso_caja != null ? l.peso_caja + ' kg' : '—')) +
            fila('Máx. cajas por pallet', l.max_cajas_pallet ?? '—') +
            fila('Máx. niveles', l.max_niveles ?? '—') +
            fila('Altura máx. de pallet', (l.altura_maxima_pallet != null ? l.altura_maxima_pallet + ' cm' : '—')) +
            fila('Permite mezcla', l.permite_mezcla ? 'Sí' : 'No') +
            fila('Orientación', l.orientacion || '—') +
            fila('Activo', l.activo ? 'Sí' : 'No');
    } else {
        logBox.innerHTML = '<div class="pv-modal-note">Este producto aún no tiene datos de logística registrados.</div>';
    }

    document.getElementById('modalDetalle').style.display = 'flex';
}

function cerrarDetalle(){
    document.getElementById('modalDetalle').style.display = 'none';
}

document.getElementById('modalDetalle').addEventListener('click', function(e){
    if(e.target === this) cerrarDetalle();
});
document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') cerrarDetalle();
});

/* =========================================================
   Listado: pestañas, búsqueda, orden, paginación y menú ⋮
========================================================= */
(function(){
    var tbody = document.getElementById('pvBody');
    if(!tbody) return;

    var PER_PAGE = {{ $perPage }};
    var rows    = Array.prototype.slice.call(tbody.querySelectorAll('tr.pv-row'));
    var tabs    = document.querySelectorAll('.pv-tab');
    var search  = document.getElementById('pvSearch');
    var sortSel = document.getElementById('pvSort');
    var countEl = document.getElementById('pvCount');
    var infoEl  = document.getElementById('pvInfo');
    var pager   = document.getElementById('pvPager');
    var noRes   = document.getElementById('pvNoResults');
    var checkAll= document.getElementById('pvCheckAll');

    var activeTab = document.querySelector('.pv-tab.active');
    var state = { cat: activeTab ? activeTab.dataset.cat : '', page: 1, sort: '' };

    function norm(s){
        return (s || '').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function comparator(){
        switch(state.sort){
            case 'nombre-asc': return function(a,b){ return a.dataset.nombre.localeCompare(b.dataset.nombre, 'es'); };
            case 'stock-asc':  return function(a,b){ return a.dataset.stock - b.dataset.stock; };
            case 'stock-desc': return function(a,b){ return b.dataset.stock - a.dataset.stock; };
            case 'rot-desc':   return function(a,b){ return b.dataset.rot - a.dataset.rot; };
            case 'venc-asc':   return function(a,b){
                var x = +a.dataset.venc || Infinity, y = +b.dataset.venc || Infinity;
                return x === y ? 0 : (x < y ? -1 : 1);
            };
            default:           return function(a,b){ return a.dataset.idx - b.dataset.idx; };
        }
    }

    function pageList(cur, total, sib){
        var set = {}; set[1] = true; set[total] = true;
        for(var i = cur - sib; i <= cur + sib; i++){ if(i >= 1 && i <= total) set[i] = true; }
        var arr = Object.keys(set).map(Number).sort(function(a,b){ return a-b; });
        var out = [], prev = 0;
        arr.forEach(function(n){
            if(prev && n - prev > 1) out.push('…');
            out.push(n); prev = n;
        });
        return out;
    }

    function renderPager(pages){
        var sib = window.matchMedia('(max-width:600px)').matches ? 1 : 2;
        var h = '<button class="pv-pg" data-p="' + (state.page-1) + '"' + (state.page<=1 ? ' disabled' : '') + '>‹</button>';
        pageList(state.page, pages, sib).forEach(function(n){
            if(n === '…'){ h += '<span class="pv-dots">…</span>'; }
            else { h += '<button class="pv-pg' + (n === state.page ? ' active' : '') + '" data-p="' + n + '">' + n + '</button>'; }
        });
        h += '<button class="pv-pg" data-p="' + (state.page+1) + '"' + (state.page>=pages ? ' disabled' : '') + '>›</button>';
        pager.innerHTML = h;
    }

    function updateSelected(){
        var n = tbody.querySelectorAll('.pv-chk:checked').length;
        var base = infoEl.dataset.base || '';
        infoEl.textContent = base + (n ? '  ·  ' + n + ' seleccionado' + (n > 1 ? 's' : '') : '');
    }

    function apply(){
        var term = norm(search.value.trim());
        var list = rows.filter(function(r){
            return (!state.cat || r.dataset.cat === state.cat) &&
                   (!term || r.dataset.search.indexOf(term) !== -1);
        });
        list.sort(comparator());

        var pages = Math.max(1, Math.ceil(list.length / PER_PAGE));
        if(state.page > pages) state.page = pages;
        var start = (state.page - 1) * PER_PAGE;

        rows.forEach(function(r){ r.hidden = true; });
        list.forEach(function(r, i){
            tbody.appendChild(r);
            r.hidden = !(i >= start && i < start + PER_PAGE);
        });

        countEl.textContent = list.length + ' producto' + (list.length === 1 ? '' : 's');
        noRes.hidden = list.length > 0;
        pager.style.display = list.length ? '' : 'none';

        var desde = list.length ? start + 1 : 0;
        var hasta = Math.min(start + PER_PAGE, list.length);
        infoEl.dataset.base = 'Mostrando ' + desde + ' a ' + hasta + ' de ' + list.length + ' productos';
        if(checkAll) checkAll.checked = false;
        updateSelected();
        renderPager(pages);
    }

    tabs.forEach(function(t){
        t.addEventListener('click', function(){
            tabs.forEach(function(x){ x.classList.remove('active'); });
            t.classList.add('active');
            t.scrollIntoView({ block:'nearest', inline:'center', behavior:'smooth' });
            state.cat = t.dataset.cat;
            state.page = 1;
            apply();
        });
    });

    search.addEventListener('input', function(){ state.page = 1; apply(); });
    sortSel.addEventListener('change', function(){ state.sort = sortSel.value; state.page = 1; apply(); });

    pager.addEventListener('click', function(e){
        var b = e.target.closest('.pv-pg');
        if(!b || b.disabled) return;
        state.page = parseInt(b.dataset.p, 10);
        apply();
        var panel = document.querySelector('.pv-panel');
        if(panel) panel.scrollIntoView({ behavior:'smooth', block:'start' });
    });

    if(checkAll){
        checkAll.addEventListener('change', function(){
            rows.forEach(function(r){
                if(!r.hidden){ r.querySelector('.pv-chk').checked = checkAll.checked; }
            });
            updateSelected();
        });
    }
    tbody.addEventListener('change', function(e){
        if(e.target.classList.contains('pv-chk')) updateSelected();
    });

    /* Menú ⋮ (posición fija para que no lo recorte el scroll de la tabla) */
    function closeMenus(){
        document.querySelectorAll('.pv-menu.open').forEach(function(m){ m.classList.remove('open'); });
    }
    document.addEventListener('click', function(e){
        var btn = e.target.closest('.pv-more');
        if(!btn){
            if(!e.target.closest('.pv-menu')) closeMenus();
            return;
        }
        var menu = btn.parentElement.querySelector('.pv-menu');
        var wasOpen = menu.classList.contains('open');
        closeMenus();
        if(wasOpen) return;

        menu.classList.add('open');
        var r = btn.getBoundingClientRect();
        var left = Math.max(8, Math.min(r.right - menu.offsetWidth, window.innerWidth - menu.offsetWidth - 8));
        var top  = r.bottom + 4;
        if(top + menu.offsetHeight > window.innerHeight - 8){ top = r.top - menu.offsetHeight - 4; }
        menu.style.left = left + 'px';
        menu.style.top  = Math.max(8, top) + 'px';
    });
    window.addEventListener('scroll', closeMenus, true);
    window.addEventListener('resize', closeMenus);

    apply();
})();
</script>

@endsection