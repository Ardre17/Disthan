@php
$role = auth()->user()->role;
$url  = request()->path();

// Cantidad de notificaciones (campana). 0 = sin globo rojo.
$nvNotifCount = 0;

/* ─────────────────────────────────────────────
   ICONOS (SVG inline, 24x24, trazo)
   ───────────────────────────────────────────── */
$ico = [
    'home'      => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/>',
    'box'       => '<path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/>',
    'cube'      => '<path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/>',
    'grid'      => '<rect x="3" y="3" width="7" height="7" rx="1.6"/><rect x="14" y="3" width="7" height="7" rx="1.6"/><rect x="3" y="14" width="7" height="7" rx="1.6"/><rect x="14" y="14" width="7" height="7" rx="1.6"/>',
    'truck'     => '<path d="M2 6h11v10H2z"/><path d="M13 9h4l4 4v3h-8"/><circle cx="6.5" cy="17.5" r="2"/><circle cx="17.5" cy="17.5" r="2"/>',
    'users'     => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6"/><circle cx="17" cy="9" r="2.5"/><path d="M17 14c2.7 0 4.5 1.8 4.5 4.5"/>',
    'bars'      => '<path d="M5 21V11M12 21V4M19 21v-7"/>',
    'gear'      => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>',
    'flask'     => '<path d="M9 3h6M10 3v6L4.5 19a2 2 0 0 0 1.7 3h11.6a2 2 0 0 0 1.7-3L14 9V3"/>',
    'layers'    => '<path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/>',
    'swap'      => '<path d="M7 4 3 8l4 4M3 8h14M17 20l4-4-4-4M21 16H7"/>',
    'tag'       => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.2"/>',
    'lock'      => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>',
    'clipboard' => '<rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4h6v3H9zM9 12h6M9 16h6"/>',
    'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    'check'     => '<circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/>',
    'undo'      => '<path d="M9 14 4 9l5-5"/><path d="M4 9h10a6 6 0 0 1 0 12h-3"/>',
    'user'      => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6"/>',
    'building'  => '<path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/>',
    'factory'   => '<path d="M3 21V9l6 4V9l6 4V5h6v16z"/>',
    'ban'       => '<circle cx="12" cy="12" r="9"/><path d="m5.6 5.6 12.8 12.8"/>',
    'trend'     => '<path d="m3 17 6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
    'list'      => '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>',
    'search'    => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
    'dot'       => '<circle cx="12" cy="12" r="3"/>',
];
$svg = function ($name) use ($ico) {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
         . ($ico[$name] ?? $ico['dot'])
         . '</svg>';
};

/* ─────────────────────────────────────────────
   ESTRUCTURA DEL MENÚ (mismo orden que la imagen)
   - roles: null = todos | ['admin'] | ['operario']
   - route: nombre de ruta | href: ruta directa
   - paths / routes / not: para detectar el ítem activo
   - sep: separador visual antes del ítem
   ───────────────────────────────────────────── */
$menu = [

    'inicio' => [
        'label' => 'Inicio', 'icon' => 'home', 'color' => '#2f6fd0',
        'href'  => '/dashboard', 'group' => false, 'items' => [],
    ],

    'almacen' => [
        'label' => 'Almacén', 'icon' => 'box', 'color' => '#f59e0b', 'group' => true,
        'items' => [
            ['label' => 'Productos',     'icon' => 'cube',   'href'  => '/products',
             'paths' => ['products'], 'not' => ['proyectado']],

            ['label' => 'Materia Prima', 'icon' => 'flask',  'route' => 'raw-materials.index',
             'roles' => ['admin'], 'paths' => ['raw-materials']],

            ['label' => 'Suministros',   'icon' => 'layers', 'route' => 'supply-orders.index',
             'title' => 'Abastecimiento a Plantas',
             'routes' => ['supply-orders.*'], 'paths' => ['supply-orders']],

            ['label' => 'Movimientos',   'icon' => 'swap',   'route' => 'kardex.index',
             'title' => 'Kardex',
             'roles' => ['admin'], 'paths' => ['kardex']],

            ['label' => 'Inventario',    'icon' => 'grid',   'route' => 'warehouse.index',
             'title' => 'Mapa del Almacén',
             'paths' => ['warehouse']],

            ['label' => 'Etiquetas',     'icon' => 'tag',    'route' => 'labels.index',
             'roles' => ['admin'], 'paths' => ['labels']],

            // — Resto de enlaces de almacén que ya existían —
            ['label' => 'Stickers de tapa', 'icon' => 'tag',  'route' => 'stickers.index',
             'roles' => ['admin'], 'paths' => ['stickers'], 'sep' => true],

            ['label' => 'Precintos',     'icon' => 'lock',   'route' => 'precintos.index',
             'roles' => ['admin'], 'paths' => ['precintos']],

            ['label' => 'Cajas',         'icon' => 'box',    'route' => 'cajas.index',
             'paths' => ['cajas']],

            ['label' => 'Conteo físico', 'icon' => 'clipboard', 'route' => 'stockcount.index',
             'roles' => ['admin'], 'routes' => ['stockcount.*'], 'paths' => ['conteo-fisico']],

            ['label' => 'Desmedros',     'icon' => 'ban',    'route' => 'desmedros.index',
             'roles' => ['admin'], 'routes' => ['desmedros.*'], 'paths' => ['desmedros']],

            ['label' => 'Joselito',      'icon' => 'building', 'route' => 'joselito.index',
             'roles' => ['admin'], 'paths' => ['joselito']],

            ['label' => 'Dalsa',         'icon' => 'factory',  'route' => 'dalsa.index',
             'roles' => ['admin'], 'paths' => ['dalsa']],
        ],
    ],

    'produccion' => [
        'label' => 'Producción', 'icon' => 'grid', 'color' => '#2f6fd0', 'group' => true,
        'items' => [
            ['label' => 'Producción', 'icon' => 'factory', 'route' => 'production-orders.index',
             'roles' => ['admin'], 'routes' => ['production-orders.*'], 'paths' => ['production', 'produccion']],

            ['label' => 'Proyectado', 'icon' => 'trend',   'route' => 'products.proyectado',
             'roles' => ['admin'], 'paths' => ['proyectado']],
        ],
    ],

    'despachos' => [
        'label' => 'Despachos', 'icon' => 'truck', 'color' => '#1f4f8f', 'group' => true,
        'items' => [
            ['label' => 'Órdenes', 'icon' => 'list', 'href' => '/orders',
             'paths' => ['orders'], 'not' => ['supply-orders', 'production-orders', 'validacion', 'validation']],

            ['label' => 'Pedidos', 'icon' => 'box', 'href' => '/pedidos',
             'roles' => ['operario'], 'paths' => ['pedidos'], 'not' => ['validacion', 'validation']],

            ['label' => 'Historial', 'icon' => 'clock', 'href' => '/historial',
             'paths' => ['historial']],

            ['label' => 'Validación de Pedidos', 'icon' => 'check', 'route' => 'orders.validation.index',
             'roles' => ['admin'], 'routes' => ['orders.validation.*'], 'paths' => ['validacion-pedidos']],

            ['label' => 'Rechazos', 'icon' => 'undo', 'route' => 'rechazos.index',
             'roles' => ['admin'], 'paths' => ['rechazos']],
        ],
    ],

    'comercial' => [
        'label' => 'Comercial', 'icon' => 'users', 'color' => '#2f6fd0', 'group' => true,
        'items' => [
            ['label' => 'Clientes',    'icon' => 'user',  'href' => '/clients',
             'roles' => ['admin'], 'paths' => ['clients']],

            ['label' => 'Proveedores', 'icon' => 'truck', 'href' => '/proveedores',
             'roles' => ['admin'], 'paths' => ['proveedores']],
        ],
    ],

    'reportes' => [
        'label' => 'Reportes', 'icon' => 'bars', 'color' => '#2f6fd0', 'group' => true,
        'items' => [
            ['label' => 'Movimientos', 'icon' => 'swap', 'route' => 'reports.movimientos',
             'roles' => ['admin'], 'routes' => ['reports.*'], 'paths' => ['reports', 'reportes']],
        ],
    ],

    'configuracion' => [
        'label' => 'Configuración', 'icon' => 'gear', 'color' => '#f59e0b', 'group' => true,
        'items' => [
            ['label' => 'Usuarios',   'icon' => 'user', 'route' => 'users.index',
             'roles' => ['admin'], 'routes' => ['users.*'], 'paths' => ['users']],

            ['label' => 'Categorías', 'icon' => 'tag',  'href' => '/categories',
             'roles' => ['admin'], 'paths' => ['categories']],
        ],
    ],
];

/* ── Filtrar por rol y resolver URLs (solo de lo permitido) ── */
$can = function ($it) use ($role) {
    return empty($it['roles']) || in_array($role, $it['roles']);
};

foreach ($menu as $mk => $m) {
    if (empty($m['group'])) continue;

    $items = array_values(array_filter($m['items'], $can));

    if (!count($items)) {
        unset($menu[$mk]);
        continue;
    }

    foreach ($items as $i => $it) {
        $items[$i]['url'] = isset($it['route']) ? route($it['route']) : $it['href'];
    }
    $menu[$mk]['items'] = $items;
}

/* ── Detectar ítem / sección activa (primera coincidencia) ── */
$isMatch = function ($it) use ($url) {
    foreach (($it['not'] ?? []) as $n) {
        if (str_contains($url, $n)) return false;
    }
    foreach (($it['routes'] ?? []) as $r) {
        if (request()->routeIs($r)) return true;
    }
    foreach (($it['paths'] ?? []) as $p) {
        if (str_contains($url, $p)) return true;
    }
    return false;
};

$activeMenu = null;
$activeItem = null;

foreach ($menu as $mk => $m) {
    foreach ($m['items'] as $ik => $it) {
        if ($isMatch($it)) {
            $activeMenu = $mk;
            $activeItem = $ik;
            break 2;
        }
    }
}
if ($activeMenu === null) {
    $activeMenu = 'inicio';
}

$showSubs = !empty($menu[$activeMenu]['group']);

$userName = Auth::user()->name;
@endphp

<style>
*{box-sizing:border-box;}

/* Variables conservadas por compatibilidad con otras vistas */
:root{
    --sb-bg1:#060f1e;
    --sb-bg2:#0a1628;
    --sb-bg3:#0d1f38;
    --sb-accent:#3b82f6;
    --sb-glow:rgba(59,130,246,.12);
    --sb-link:#93c5fd;
    --sb-sub:#60a5fa;
    --sb-border:rgba(255,255,255,.06);
    --sb-text:#c8daf0;
    --sb-text-muted:#5b7da8;
    --sb-ok:#22c55e;
    --sb-width:0px;
    --font:'Segoe UI',-apple-system,BlinkMacSystemFont,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',monospace;

    --nv-navy1:#0e2545;
    --nv-navy2:#1e3a5f;
    --nv-blue:#1a86f5;
    --nv-blue-dark:#1769d1;
    --nv-bg:#e8f0fa;
    --nv-bg-sub:#d9e7f7;
    --nv-text:#1f3a5f;
    --nv-text-soft:#475f80;
}

/* ── Contenido principal: ya no hay sidebar lateral ── */
.main-content,
.main-content.sidebar-collapsed{
    margin-left:0 !important;
    min-height:auto;
}

/* ── Contenedor ── */
.nv{
    font-family:var(--font);
    font-size:13px;
    padding:10px 14px 0;
    position:relative;   /* cambia a sticky + top:0 + z-index:1000 si lo quieres fijo */
    z-index:900;
}
.nv-card{
    background:var(--nv-bg);
    border-radius:14px;
    box-shadow:0 6px 24px rgba(15,39,71,.14);
}

/* ── Barra superior ── */
.nv-top{
    position:relative;
    display:flex;align-items:center;gap:14px;
    padding:12px 18px;
    background:linear-gradient(90deg,var(--nv-navy1) 0%,var(--nv-navy2) 100%);
    border-radius:14px 14px 0 0;
    color:#fff;
}
.nv-brand{
    display:flex;align-items:center;gap:10px;
    text-decoration:none;color:#fff;flex-shrink:0;
}
.nv-logo{
    width:36px;height:36px;flex-shrink:0;
    background:linear-gradient(135deg,#2b8cff,#1565d8);
    border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 12px rgba(26,134,245,.4);
}
.nv-logo svg{width:22px;height:22px;}
.nv-brand-name{font-size:16px;font-weight:800;letter-spacing:.3px;line-height:1.1;}
.nv-brand-sub{font-size:10.5px;color:#9db6d6;margin-top:2px;}

/* Buscador */
.nv-search{
    position:relative;
    margin-left:auto;
    width:270px;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.1);
    border-radius:9px;
    display:flex;align-items:center;gap:8px;
    padding:0 12px;height:36px;
    transition:background .15s,border-color .15s;
}
.nv-search:focus-within{background:rgba(255,255,255,.18);border-color:rgba(255,255,255,.3);}
.nv-search svg{width:16px;height:16px;flex-shrink:0;color:#c4d4ea;}
.nv-search input{
    flex:1;min-width:0;
    background:transparent;border:0;outline:0;
    color:#fff;font:inherit;font-size:12.5px;
}
.nv-search input::placeholder{color:#b6c8e2;}
.nv-results{
    display:none;
    position:absolute;top:calc(100% + 8px);left:0;right:0;
    background:#fff;border-radius:10px;
    box-shadow:0 12px 32px rgba(15,39,71,.28);
    padding:6px;max-height:320px;overflow-y:auto;
    z-index:1100;
}
.nv-results.show{display:block;}
.nv-results a{
    display:flex;justify-content:space-between;align-items:center;gap:10px;
    padding:8px 10px;border-radius:7px;
    color:var(--nv-text);text-decoration:none;font-size:12.5px;font-weight:600;
}
.nv-results a small{color:#7a8ea9;font-weight:500;font-size:11px;}
.nv-results a:hover,.nv-results a.sel{background:#eaf2fc;color:var(--nv-blue-dark);}
.nv-results .nv-empty{padding:10px;color:#7a8ea9;font-size:12px;}

.nv-icon-btn{
    position:relative;
    width:36px;height:36px;flex-shrink:0;
    background:transparent;border:0;border-radius:9px;
    color:#e3ecf8;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:background .15s;
}
.nv-icon-btn:hover{background:rgba(255,255,255,.12);}
.nv-icon-btn svg{width:20px;height:20px;}
.nv-badge{
    position:absolute;top:1px;right:1px;
    min-width:16px;height:16px;padding:0 4px;
    background:#ef4444;color:#fff;
    border-radius:99px;font-size:10px;font-weight:700;
    display:flex;align-items:center;justify-content:center;
    border:2px solid var(--nv-navy2);
    line-height:1;
}
.nv-search-btn{display:none;}

/* Usuario */
.nv-user-wrap{position:relative;flex-shrink:0;}
.nv-user{
    display:flex;align-items:center;gap:9px;
    background:transparent;border:0;border-radius:99px;
    padding:3px 8px 3px 3px;cursor:pointer;color:#fff;font:inherit;
    transition:background .15s;
}
.nv-user:hover{background:rgba(255,255,255,.1);}
.nv-avatar{
    width:34px;height:34px;border-radius:50%;
    background:#fff;color:#1a6fe0;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.nv-avatar svg{width:20px;height:20px;}
.nv-user-name{
    font-size:13px;font-weight:600;max-width:120px;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.nv-chev{width:14px;height:14px;color:#b6c8e2;transition:transform .2s;}
.nv-user[aria-expanded="true"] .nv-chev{transform:rotate(180deg);}

.nv-menu{
    display:none;
    position:absolute;right:0;top:calc(100% + 10px);
    width:250px;background:#fff;color:var(--nv-text);
    border-radius:12px;padding:14px;
    box-shadow:0 14px 36px rgba(15,39,71,.3);
    z-index:1100;
}
.nv-menu.show{display:block;}
.nv-menu-name{font-size:14px;font-weight:700;word-break:break-word;}
.nv-menu-role{font-size:11px;color:#7a8ea9;margin-top:1px;text-transform:capitalize;}
.nv-status{
    display:inline-flex;align-items:center;gap:5px;margin-top:8px;
    padding:2px 9px;border-radius:99px;font-size:10.5px;font-weight:700;
    background:#e7f7ee;color:#15803d;border:1px solid #bfe8cf;
}
.nv-status i{
    width:6px;height:6px;border-radius:50%;background:#22c55e;
    animation:nvPulse 1.5s ease infinite;
}
@keyframes nvPulse{
    0%,100%{opacity:1;transform:scale(1);}
    50%{opacity:.4;transform:scale(1.4);}
}
.nv-clock{
    margin-top:12px;padding:10px;text-align:center;
    background:#eef4fc;border:1px solid #d5e3f6;border-radius:9px;
}
#clockTime{
    font-family:var(--font-mono);font-size:20px;font-weight:700;
    color:var(--nv-blue-dark);letter-spacing:2px;line-height:1;
}
#clockDate{margin-top:5px;font-size:11px;color:#7a8ea9;text-transform:capitalize;}
.nv-logout{
    width:100%;margin-top:12px;padding:9px 12px;
    border:1px solid rgba(239,68,68,.25);border-radius:8px;
    background:rgba(239,68,68,.08);color:#dc2626;
    font:inherit;font-size:12.5px;font-weight:700;cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:6px;
    transition:background .15s;
}
.nv-logout:hover{background:rgba(239,68,68,.16);}

/* ── Pestañas principales ── */
.nv-tabs{
    display:flex;align-items:center;gap:6px;
    padding:10px 16px;
    overflow-x:auto;
    scrollbar-width:none;
}
.nv-tabs::-webkit-scrollbar{display:none;}
.nv-tab{
    --ic:#2f6fd0;
    flex-shrink:0;
    display:inline-flex;align-items:center;gap:8px;
    height:38px;padding:0 16px;
    background:transparent;border:0;border-radius:9px;
    color:var(--nv-text);text-decoration:none;
    font:inherit;font-size:13px;font-weight:600;
    cursor:pointer;white-space:nowrap;
    transition:background .15s,color .15s,box-shadow .15s;
}
.nv-tab .nv-ic{color:var(--ic);display:flex;transition:color .15s;}
.nv-tab .nv-ic svg{width:18px;height:18px;}
.nv-tab:hover{background:rgba(26,134,245,.1);}
.nv-tab.is-active{
    background:var(--nv-blue);color:#fff;
    box-shadow:0 4px 12px rgba(26,134,245,.35);
}
.nv-tab.is-active .nv-ic{color:#fff;}

/* ── Subpestañas ── */
.nv-subs{display:none;padding:0 16px 12px;}
.nv-subs.show{display:block;}
.nv-panel{
    display:none;align-items:center;gap:4px;
    background:var(--nv-bg-sub);
    border:1px solid rgba(26,100,200,.08);
    border-radius:11px;padding:6px 8px;
    overflow-x:auto;scrollbar-width:none;
}
.nv-panel::-webkit-scrollbar{display:none;}
.nv-panel.show{display:flex;}
.nv-sub{
    flex-shrink:0;
    display:inline-flex;align-items:center;gap:7px;
    padding:8px 14px;border-radius:8px;
    color:var(--nv-text-soft);text-decoration:none;
    font-size:12.5px;font-weight:500;white-space:nowrap;
    transition:background .15s,color .15s;
}
.nv-sub .nv-ic{color:#3b78c4;display:flex;}
.nv-sub .nv-ic svg{width:16px;height:16px;}
.nv-sub:hover{background:rgba(255,255,255,.6);color:var(--nv-text);}
.nv-sub.active{
    background:#eef5fd;color:var(--nv-blue-dark);font-weight:700;
    box-shadow:inset 0 -2px 0 var(--nv-blue);
}
.nv-sub.active .nv-ic{color:var(--nv-blue-dark);}
.nv-sep{
    flex-shrink:0;width:1px;height:20px;margin:0 6px;
    background:rgba(31,58,95,.2);
}

/* ── Responsive ── */
@media(max-width:900px){
    .nv-search{width:200px;}
}
@media(max-width:680px){
    .nv{padding:6px 6px 0;}
    .nv-top{padding:10px 12px;gap:8px;}
    .nv-brand-sub,.nv-user-name,.nv-chev{display:none;}
    .nv-user{padding:3px;}
    .nv-search-btn{display:flex;margin-left:auto;}
    .nv-search{
        display:none;
        position:absolute;left:10px;right:10px;top:calc(100% + 6px);
        width:auto;margin:0;
        background:var(--nv-navy2);z-index:1100;
        box-shadow:0 10px 28px rgba(15,39,71,.35);
    }
    .nv-search.open{display:flex;}
    .nv-tabs{padding:8px 10px;}
    .nv-tab{padding:0 12px;}
    .nv-subs{padding:0 10px 10px;}
}
</style>

<header class="nv" id="nv">
    <div class="nv-card">

        {{-- Barra superior --}}
        <div class="nv-top">

            <a class="nv-brand" href="/dashboard">
                <div class="nv-logo">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#fff" fill-rule="evenodd" d="M5 4h7.2a8 8 0 0 1 0 16H5zM9.5 8.2v7.6h2.7a3.8 3.8 0 0 0 0-7.6z"/>
                    </svg>
                </div>
                <div>
                    <div class="nv-brand-name">DISTAN ERP</div>
                    <div class="nv-brand-sub">Gestión empresarial</div>
                </div>
            </a>

            <div class="nv-search" id="nvSearch">
                {!! $svg('search') !!}
                <input type="search" id="nvSearchInput" placeholder="Buscar en DISTAN..." autocomplete="off">
                <div class="nv-results" id="nvResults"></div>
            </div>

            <button type="button" class="nv-icon-btn nv-search-btn" id="nvSearchBtn" aria-label="Buscar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            </button>

            <button type="button" class="nv-icon-btn" aria-label="Notificaciones">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9a6 6 0 1 1 12 0c0 6 2.5 7.5 2.5 7.5h-17S6 15 6 9"/><path d="M10 20a2 2 0 0 0 4 0"/></svg>
                @if($nvNotifCount > 0)
                    <span class="nv-badge">{{ $nvNotifCount }}</span>
                @endif
            </button>

            <div class="nv-user-wrap">
                <button type="button" class="nv-user" id="nvUserBtn" aria-expanded="false" aria-haspopup="true">
                    <span class="nv-avatar">{!! $svg('user') !!}</span>
                    <span class="nv-user-name">{{ $userName }}</span>
                    <svg class="nv-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>

                <div class="nv-menu" id="nvUserMenu">
                    <div class="nv-menu-name">{{ $userName }}</div>
                    <div class="nv-menu-role">{{ ucfirst(auth()->user()->role) }}</div>
                    <div class="nv-status"><i></i>En línea</div>

                    <div class="nv-clock">
                        <div id="clockTime">00:00:00</div>
                        <div id="clockDate">--</div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="nv-logout">
                            <span>🚪</span>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Pestañas principales --}}
        <nav class="nv-tabs" aria-label="Menú principal">
            @foreach($menu as $mk => $m)
                @if(empty($m['group']))
                    <a href="{{ $m['href'] }}"
                       class="nv-tab {{ $activeMenu === $mk ? 'is-active' : '' }}"
                       style="--ic:{{ $m['color'] }}"
                       data-menu="{{ $m['label'] }}">
                        <span class="nv-ic">{!! $svg($m['icon']) !!}</span>
                        <span>{{ $m['label'] }}</span>
                    </a>
                @else
                    <button type="button"
                            class="nv-tab {{ $activeMenu === $mk ? 'is-active' : '' }}"
                            style="--ic:{{ $m['color'] }}"
                            data-panel="{{ $mk }}">
                        <span class="nv-ic">{!! $svg($m['icon']) !!}</span>
                        <span>{{ $m['label'] }}</span>
                    </button>
                @endif
            @endforeach
        </nav>

        {{-- Subpestañas --}}
        <div class="nv-subs {{ $showSubs ? 'show' : '' }}" id="nvSubs">
            @foreach($menu as $mk => $m)
                @if(!empty($m['group']))
                    <div class="nv-panel {{ $activeMenu === $mk ? 'show' : '' }}" data-panel="{{ $mk }}">
                        @foreach($m['items'] as $ik => $it)
                            @if(!empty($it['sep']))
                                <span class="nv-sep"></span>
                            @endif
                            <a href="{{ $it['url'] }}"
                               class="nv-sub {{ ($activeMenu === $mk && $activeItem === $ik) ? 'active' : '' }}"
                               data-menu="{{ $m['label'] }}"
                               @if(!empty($it['title'])) title="{{ $it['title'] }}" @endif
                               @if($activeMenu === $mk && $activeItem === $ik) aria-current="page" @endif>
                                <span class="nv-ic">{!! $svg($it['icon']) !!}</span>
                                <span>{{ $it['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</header>

<script>
/* ── Compatibilidad: funciones del sidebar anterior (ya no hacen nada) ── */
function toggleMenu() {}
function toggleSidebar() {}
function openSidebar() {}
function closeSidebar() {}

/* ── Reloj ── */
function actualizarReloj() {
    var ahora  = new Date();
    var timeEl = document.getElementById('clockTime');
    var dateEl = document.getElementById('clockDate');
    if (timeEl) timeEl.textContent = ahora.toLocaleTimeString('es-PE');
    if (dateEl) dateEl.textContent = ahora.toLocaleDateString('es-PE', {
        weekday:'long', day:'numeric', month:'long'
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var nv = document.getElementById('nv');
    if (!nv) return;

    var each = function (list, fn) { Array.prototype.forEach.call(list, fn); };

    /* ── Pestañas principales → cambian el panel de subpestañas ── */
    var subs   = document.getElementById('nvSubs');
    var panels = nv.querySelectorAll('.nv-panel');
    var btnTabs = nv.querySelectorAll('button.nv-tab');

    each(btnTabs, function (tab) {
        tab.addEventListener('click', function () {
            var key = tab.getAttribute('data-panel');

            each(nv.querySelectorAll('.nv-tab'), function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');

            each(panels, function (p) {
                p.classList.toggle('show', p.getAttribute('data-panel') === key);
            });
            if (subs) subs.classList.add('show');
        });
    });

    /* Llevar a la vista la pestaña / subpestaña activa (móvil) */
    try {
        var act = nv.querySelector('.nv-tab.is-active');
        var sub = nv.querySelector('.nv-sub.active');
        if (act) act.scrollIntoView({ inline:'center', block:'nearest' });
        if (sub) sub.scrollIntoView({ inline:'center', block:'nearest' });
    } catch (e) {}

    /* ── Menú de usuario ── */
    var userBtn  = document.getElementById('nvUserBtn');
    var userMenu = document.getElementById('nvUserMenu');
    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = userMenu.classList.toggle('show');
            userBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        userMenu.addEventListener('click', function (e) { e.stopPropagation(); });
    }

    /* ── Buscador (filtra los enlaces del propio menú) ── */
    var box     = document.getElementById('nvSearch');
    var input   = document.getElementById('nvSearchInput');
    var results = document.getElementById('nvResults');
    var sBtn    = document.getElementById('nvSearchBtn');

    var norm = function (s) {
        return (s || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    };

    var links = [];
    each(nv.querySelectorAll('a.nv-tab, a.nv-sub'), function (a) {
        var label = a.textContent.replace(/\s+/g, ' ').trim();
        var group = a.getAttribute('data-menu') || '';
        links.push({
            href: a.getAttribute('href'),
            label: label,
            group: group,
            key: norm(label + ' ' + group + ' ' + (a.getAttribute('title') || ''))
        });
    });

    var closeResults = function () {
        results.classList.remove('show');
        results.innerHTML = '';
    };

    var renderResults = function () {
        var q = norm(input.value.trim());
        results.innerHTML = '';
        if (!q) { results.classList.remove('show'); return; }

        var found = links.filter(function (l) { return l.key.indexOf(q) !== -1; }).slice(0, 8);

        if (!found.length) {
            var empty = document.createElement('div');
            empty.className = 'nv-empty';
            empty.textContent = 'Sin resultados';
            results.appendChild(empty);
        } else {
            found.forEach(function (l, i) {
                var a = document.createElement('a');
                a.href = l.href;
                if (i === 0) a.className = 'sel';
                var s1 = document.createElement('span');
                s1.textContent = l.label;
                a.appendChild(s1);
                if (l.group) {
                    var s2 = document.createElement('small');
                    s2.textContent = l.group;
                    a.appendChild(s2);
                }
                results.appendChild(a);
            });
        }
        results.classList.add('show');
    };

    if (input && results) {
        input.addEventListener('input', renderResults);
        input.addEventListener('focus', renderResults);
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                var first = results.querySelector('a');
                if (first) { e.preventDefault(); window.location.href = first.getAttribute('href'); }
            } else if (e.key === 'Escape') {
                closeResults();
                input.blur();
            }
        });
        box.addEventListener('click', function (e) { e.stopPropagation(); });
    }

    if (sBtn && box) {
        sBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            box.classList.toggle('open');
            if (box.classList.contains('open') && input) input.focus();
        });
    }

    /* ── Cerrar desplegables al hacer clic fuera / con Escape ── */
    document.addEventListener('click', function () {
        if (userMenu) {
            userMenu.classList.remove('show');
            if (userBtn) userBtn.setAttribute('aria-expanded', 'false');
        }
        if (results) closeResults();
        if (box) box.classList.remove('open');
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && userMenu) {
            userMenu.classList.remove('show');
            if (userBtn) userBtn.setAttribute('aria-expanded', 'false');
        }
    });

    /* ── Reloj ── */
    actualizarReloj();
    setInterval(actualizarReloj, 1000);
});
</script>