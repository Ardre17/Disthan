@php
$role = auth()->user()->role;

// ── Detectar sección activa para el color del menú ──
$seccionActiva = 'dash';
$url = request()->path();

if (
    str_contains($url, 'joselito') ||
    str_contains($url, 'dalsa')
) {
    $seccionActiva = 'alm';

} elseif (
    str_contains($url, 'orders') ||
    str_contains($url, 'historial') ||
    str_contains($url, 'raw-materials') ||
    str_contains($url, 'proyectado') ||
    str_contains($url, 'kardex') ||
    str_contains($url, 'production') ||
    str_contains($url, 'pedidos') ||
    str_contains($url, 'produccion')
) {
    $seccionActiva = 'ops';

} elseif (
    str_contains($url, 'categories') ||
    str_contains($url, 'labels') ||
    str_contains($url, 'stickers') ||
    str_contains($url, 'precintos') ||
    str_contains($url, 'cajas') ||
    str_contains($url, 'products') ||
    str_contains($url, 'warehouse')
) {
    $seccionActiva = 'inv';

} elseif (
    str_contains($url, 'clients') ||
    str_contains($url, 'proveedores')
) {
    $seccionActiva = 'com';
}

// Colores por sección
$temas = [
    'dash' => [
        'grad1' => '#060f1e',
        'grad2' => '#0a1628',
        'grad3' => '#0d1f38',
        'accent'=> '#3b82f6',
        'glow'  => 'rgba(59,130,246,.12)',
        'link'  => '#93c5fd',
        'sub'   => '#60a5fa',
        'icon'  => '#3b82f6',
        'label' => 'Dashboard',
    ],
    'alm' => [
        'grad1' => '#061818',
        'grad2' => '#082020',
        'grad3' => '#0a2828',
        'accent'=> '#06b6d4',
        'glow'  => 'rgba(6,182,212,.12)',
        'link'  => '#67e8f9',
        'sub'   => '#22d3ee',
        'icon'  => '#06b6d4',
        'label' => 'Almacenes',
    ],
    'ops' => [
        'grad1' => '#1a1000',
        'grad2' => '#1f1500',
        'grad3' => '#251a00',
        'accent'=> '#f59e0b',
        'glow'  => 'rgba(245,158,11,.12)',
        'link'  => '#fcd34d',
        'sub'   => '#fbbf24',
        'icon'  => '#f59e0b',
        'label' => 'Operaciones',
    ],
    'inv' => [
        'grad1' => '#061a0a',
        'grad2' => '#082010',
        'grad3' => '#0a2814',
        'accent'=> '#22c55e',
        'glow'  => 'rgba(34,197,94,.12)',
        'link'  => '#86efac',
        'sub'   => '#4ade80',
        'icon'  => '#22c55e',
        'label' => 'Inventario',
    ],
    'com' => [
        'grad1' => '#120820',
        'grad2' => '#160a28',
        'grad3' => '#1a0c30',
        'accent'=> '#8b5cf6',
        'glow'  => 'rgba(139,92,246,.12)',
        'link'  => '#c4b5fd',
        'sub'   => '#a78bfa',
        'icon'  => '#8b5cf6',
        'label' => 'Comercial',
    ],
];

$t = $temas[$seccionActiva];
@endphp

<style>
*{box-sizing:border-box;}

:root{
    --sb-bg1:{{ $t['grad1'] }};
    --sb-bg2:{{ $t['grad2'] }};
    --sb-bg3:{{ $t['grad3'] }};
    --sb-accent:{{ $t['accent'] }};
    --sb-glow:{{ $t['glow'] }};
    --sb-link:{{ $t['link'] }};
    --sb-sub:{{ $t['sub'] }};
    --sb-border:rgba(255,255,255,.06);
    --sb-text:#c8daf0;
    --sb-text-muted:#5b7da8;
    --sb-ok:#22c55e;
    --sb-width:270px;
    --font:'Segoe UI',-apple-system,BlinkMacSystemFont,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',monospace;
}

/* ── Contenido principal ── */
.main-content{
    margin-left:var(--sb-width);
    transition:margin-left .3s ease;
    min-height:100vh;
}
.main-content.sidebar-collapsed{
    margin-left:56px;
}
@media(max-width:768px){
    .main-content{margin-left:0 !important;}
}

/* ── Botón hamburguesa ── */
.sb-toggle{
    position:fixed;
    top:12px;left:12px;
    z-index:1001;
    width:36px;height:36px;
    background:#0a1628;
    border:1px solid rgba(255,255,255,.1);
    border-radius:6px;
    display:none;
    align-items:center;justify-content:center;
    cursor:pointer;
    box-shadow:0 2px 10px rgba(0,0,0,.4);
    transition:background .2s;
}
.sb-toggle:hover{background:var(--sb-accent);}
.sb-toggle-icon{display:flex;flex-direction:column;gap:4px;}
.sb-toggle-icon span{
    display:block;width:18px;height:2px;
    background:#7eb8f7;border-radius:2px;
    transition:transform .3s,opacity .3s;
}

/* Overlay móvil */
.sb-overlay{
    display:none;
    position:fixed;inset:0;
    background:rgba(0,0,0,.6);
    backdrop-filter:blur(2px);
    z-index:999;
}
.sb-overlay.show{display:block;}

/* ── Sidebar ── */
.sidebar{
    width:var(--sb-width);
    height:100vh;
    position:fixed;
    top:0;left:0;
    overflow-y:auto;
    overflow-x:hidden;
    background:linear-gradient(
        180deg,
        var(--sb-bg1) 0%,
        var(--sb-bg2) 50%,
        var(--sb-bg3) 100%
    );
    color:var(--sb-text);
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:
        6px 0 24px rgba(0,0,0,.4),
        inset -1px 0 0 var(--sb-border);
    font-family:var(--font);
    font-size:13px;
    z-index:1000;
    transition:width .3s cubic-bezier(.16,1,.3,1),
               transform .3s cubic-bezier(.16,1,.3,1);
}

/* Glow de color en el sidebar */
.sidebar::before{
    content:'';
    position:absolute;
    top:0;left:0;right:0;
    height:200px;
    background:radial-gradient(ellipse at top left, var(--sb-glow), transparent 70%);
    pointer-events:none;
    z-index:0;
}
.sidebar > *{position:relative;z-index:1;}

.sidebar::-webkit-scrollbar{width:4px;}
.sidebar::-webkit-scrollbar-track{background:transparent;}
.sidebar::-webkit-scrollbar-thumb{background:var(--sb-accent);border-radius:99px;opacity:.3;}

/* ── Header ── */
.sb-header{
    padding:18px 16px 14px;
    border-bottom:1px solid var(--sb-border);
    flex-shrink:0;
}
.sb-brand{
    display:flex;align-items:center;gap:10px;
    margin-bottom:14px;
}
.sb-brand-icon{
    width:36px;height:36px;flex-shrink:0;
    background:linear-gradient(135deg,var(--sb-accent),var(--sb-sub));
    border-radius:8px;
    display:flex;align-items:center;justify-content:center;
    font-size:18px;
    box-shadow:0 4px 14px var(--sb-glow);
    transition:background .4s;
}
.sb-brand-name{
    font-size:14px;font-weight:800;
    color:#f1f5f9;letter-spacing:.3px;
}
.sb-brand-sub{
    font-size:10px;color:var(--sb-text-muted);
    text-transform:uppercase;letter-spacing:.07em;margin-top:1px;
}
.sb-collapse-btn{
    margin-left:auto;
    width:26px;height:26px;flex-shrink:0;
    background:rgba(255,255,255,.05);
    border:1px solid var(--sb-border);
    border-radius:5px;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;color:var(--sb-text-muted);
    font-size:16px;font-weight:700;
    transition:background .15s,color .15s,border-color .15s;
    line-height:1;user-select:none;
}
.sb-collapse-btn:hover{
    background:var(--sb-accent);
    border-color:var(--sb-accent);
    color:#fff;
}

/* User card */
.sb-user{
    background:rgba(255,255,255,.05);
    border:1px solid var(--sb-border);
    border-radius:8px;
    padding:12px;
    display:flex;align-items:center;gap:10px;
    transition:border-color .4s;
}
.sb-user:hover{border-color:var(--sb-accent);}
.sb-avatar{
    width:38px;height:38px;flex-shrink:0;
    border-radius:50%;
    background:linear-gradient(135deg,var(--sb-accent),var(--sb-sub));
    display:flex;align-items:center;justify-content:center;
    font-size:16px;font-weight:800;color:#fff;
    box-shadow:0 4px 12px var(--sb-glow);
    border:2px solid rgba(255,255,255,.12);
    transition:background .4s,box-shadow .4s;
}
.sb-user-info{flex:1;min-width:0;}
.sb-user-name{
    font-size:13px;font-weight:700;color:#f1f5f9;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.sb-user-role{
    font-size:10px;color:var(--sb-text-muted);
    margin-top:1px;text-transform:capitalize;
}
.sb-status{
    display:inline-flex;align-items:center;gap:4px;
    border-radius:99px;
    padding:2px 8px;
    font-size:10px;
    margin-top:4px;font-weight:600;
    background:color-mix(in srgb, var(--sb-accent) 15%, transparent);
    border:1px solid color-mix(in srgb, var(--sb-accent) 30%, transparent);
    color:var(--sb-link);
    transition:background .4s,border-color .4s,color .4s;
}
.sb-status-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--sb-accent);
    animation:sbPulse 1.5s ease infinite;
    flex-shrink:0;
    transition:background .4s;
}
@keyframes sbPulse{
    0%,100%{opacity:1;transform:scale(1);}
    50%{opacity:.4;transform:scale(1.4);}
}

/* ── Nav ── */
.sb-nav{flex:1;padding:8px 0;}

.sb-item{
    display:flex;align-items:center;gap:10px;
    color:var(--sb-text);
    text-decoration:none;
    padding:10px 16px;
    border-left:3px solid transparent;
    transition:background .15s,color .15s,border-color .15s;
    font-size:13px;font-weight:500;
}
.sb-item:hover{
    background:color-mix(in srgb, var(--sb-accent) 8%, transparent);
    color:#f1f5f9;
}
.sb-item.active{
    background:color-mix(in srgb, var(--sb-accent) 12%, transparent);
    color:#fff;font-weight:700;
    border-left-color:var(--sb-accent);
}
.sb-item .sb-icon{
    width:24px;height:24px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    font-size:15px;
}

/* Secciones */
.sb-section{margin-bottom:2px;}
.sb-section-title{
    display:flex;justify-content:space-between;align-items:center;
    padding:9px 16px;
    cursor:pointer;
    font-size:11px;font-weight:700;
    text-transform:uppercase;letter-spacing:.07em;
    color:var(--sb-text-muted);
    border-left:3px solid transparent;
    transition:background .15s,color .15s,border-color .15s;
    user-select:none;
}
.sb-section-title:hover{
    background:color-mix(in srgb, var(--sb-accent) 6%, transparent);
    color:var(--sb-text);
}
.sb-section-left{display:flex;align-items:center;gap:8px;}
.sb-section-icon{font-size:14px;width:20px;text-align:center;}
.sb-section-arrow{
    font-size:11px;color:var(--sb-text-muted);
    transition:transform .3s;flex-shrink:0;
}
.sb-section-title.open{
    color:var(--sb-link);
    border-left-color:var(--sb-accent);
}
.sb-section-title.open .sb-section-arrow{
    transform:rotate(180deg);
    color:var(--sb-accent);
}

/* Submenú */
.sb-sub{
    overflow:hidden;
    max-height:0;
    transition:max-height .35s ease;
}
.sb-sub a{
    display:flex;align-items:center;gap:9px;
    color:var(--sb-text-muted);
    text-decoration:none;
    padding:8px 16px 8px 40px;
    font-size:12.5px;
    border-left:3px solid transparent;
    transition:background .15s,color .15s,padding-left .15s,border-color .15s;
}
.sb-sub a:hover{
    background:color-mix(in srgb, var(--sb-accent) 8%, transparent);
    color:var(--sb-link);
    padding-left:46px;
    border-left-color:color-mix(in srgb, var(--sb-accent) 40%, transparent);
}
.sb-sub a .sb-icon{
    width:20px;height:20px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    font-size:13px;
}

.sb-divider{
    height:1px;
    background:linear-gradient(90deg, var(--sb-accent) 0%, transparent 100%);
    opacity:.15;
    margin:6px 16px;
}

/* ── Footer ── */
.sb-footer{
    border-top:1px solid var(--sb-border);
    padding:14px 16px;
    flex-shrink:0;
}
.sb-clock{
    text-align:center;
    margin-bottom:12px;
    background:color-mix(in srgb, var(--sb-accent) 6%, transparent);
    border:1px solid color-mix(in srgb, var(--sb-accent) 20%, transparent);
    border-radius:7px;
    padding:10px;
    transition:background .4s,border-color .4s;
}
#clockTime{
    font-family:var(--font-mono);
    font-size:22px;font-weight:700;
    color:var(--sb-link);
    letter-spacing:2px;line-height:1;
    transition:color .4s;
}
#clockDate{
    margin-top:5px;font-size:11px;
    color:var(--sb-text-muted);
    text-transform:capitalize;
}
.sb-storage{margin-bottom:12px;}
.sb-storage-top{
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:6px;
}
.sb-storage-label{font-size:11px;color:var(--sb-text-muted);}
.sb-storage-pct{
    font-size:11px;font-weight:700;
    color:var(--sb-link);
    font-family:var(--font-mono);
    transition:color .4s;
}
.sb-storage-bar{
    height:5px;background:rgba(255,255,255,.07);
    border-radius:99px;overflow:hidden;
}
.sb-storage-fill{
    height:100%;width:82%;
    background:linear-gradient(90deg, var(--sb-accent), var(--sb-sub));
    border-radius:99px;
    transition:background .4s;
}
.sb-version{
    text-align:center;font-size:10px;
    color:var(--sb-text-muted);margin-bottom:10px;
    font-family:var(--font-mono);
}

/* Indicador de sección activa */
.sb-section-indicator{
    display:flex;align-items:center;justify-content:center;gap:6px;
    margin-bottom:10px;
    padding:5px 10px;
    background:color-mix(in srgb, var(--sb-accent) 10%, transparent);
    border:1px solid color-mix(in srgb, var(--sb-accent) 25%, transparent);
    border-radius:5px;
    font-size:10px;font-weight:700;
    color:var(--sb-link);
    text-transform:uppercase;letter-spacing:.06em;
    transition:background .4s,border-color .4s,color .4s;
}
.sb-section-indicator-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--sb-accent);
    transition:background .4s;
}

.sb-logout{
    width:100%;padding:9px 12px;
    border:1px solid rgba(239,68,68,.2);
    border-radius:6px;
    background:rgba(239,68,68,.08);
    color:#fca5a5;
    font-size:12px;font-weight:700;
    cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:6px;
    transition:background .15s,box-shadow .15s,transform .1s;
    font-family:var(--font);
}
.sb-logout:hover{
    background:rgba(239,68,68,.18);
    box-shadow:0 4px 16px rgba(239,68,68,.15);
    transform:translateY(-1px);
}

/* ── COLAPSADO ── */
.sidebar.collapsed{width:56px;}

.sidebar.collapsed .sb-brand-info,
.sidebar.collapsed .sb-user-info,
.sidebar.collapsed .sb-status,
.sidebar.collapsed .sb-section-left span:not(.sb-section-icon),
.sidebar.collapsed .sb-section-arrow,
.sidebar.collapsed .sb-item .sb-item-label,
.sidebar.collapsed .sb-sub,
.sidebar.collapsed #clockDate,
.sidebar.collapsed .sb-storage-label,
.sidebar.collapsed .sb-storage-pct,
.sidebar.collapsed .sb-storage-bar,
.sidebar.collapsed .sb-version,
.sidebar.collapsed .sb-section-indicator,
.sidebar.collapsed .sb-logout span:last-child,
.sidebar.collapsed .sb-divider{
    display:none !important;
}
.sidebar.collapsed .sb-brand{justify-content:center;margin-bottom:0;}
.sidebar.collapsed .sb-user{justify-content:center;padding:8px;}
.sidebar.collapsed .sb-avatar{margin:0;}
.sidebar.collapsed .sb-item{justify-content:center;padding:10px 0;}
.sidebar.collapsed .sb-section-title{justify-content:center;padding:10px 0;}
.sidebar.collapsed .sb-clock{padding:8px;}
.sidebar.collapsed #clockTime{font-size:11px;letter-spacing:0;}
.sidebar.collapsed .sb-logout{justify-content:center;padding:9px 0;}
.sidebar.collapsed .sb-collapse-btn{display:none;}
.sidebar.collapsed .sb-storage{display:none;}

/* Botón expandir colapsado */
.sb-expand-btn{
    display:none;
    width:100%;padding:10px 0;
    background:none;border:none;
    color:var(--sb-accent);
    font-size:18px;cursor:pointer;
    font-weight:700;
    transition:color .15s,transform .15s;
}
.sb-expand-btn:hover{
    color:var(--sb-link);
    transform:scale(1.2);
}
.sidebar.collapsed .sb-expand-btn{display:block;}

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .sb-toggle{display:flex;}
    .sidebar{
        transform:translateX(-100%);
        width:var(--sb-width) !important;
    }
    .sidebar.mobile-open{transform:translateX(0);}
    .sidebar.collapsed{
        width:var(--sb-width) !important;
        transform:translateX(-100%);
    }
}
</style>

{{-- Botón hamburguesa (móvil) --}}
<button class="sb-toggle" id="sbToggle" aria-label="Abrir menú">
    <div class="sb-toggle-icon">
        <span></span><span></span><span></span>
    </div>
</button>

{{-- Overlay fondo (móvil) --}}
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="sidebar">

    <div>
        {{-- Header --}}
        <div class="sb-header">
            <div class="sb-brand">
                <div class="sb-brand-icon">🚀</div>
                <div class="sb-brand-info">
                    <div class="sb-brand-name">DISTAN</div>
                    <div class="sb-brand-sub">Warehouse & Production</div>
                </div>
                <div class="sb-collapse-btn"
                     id="collapseBtn"
                     onclick="toggleSidebar()"
                     title="Colapsar menú">‹</div>
            </div>

            <button class="sb-expand-btn" onclick="toggleSidebar()" title="Expandir">›</button>

            <div class="sb-user">
                <div class="sb-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="sb-user-info">
                    <div class="sb-user-name">{{ Auth::user()->name }}</div>
                    <div class="sb-user-role">{{ ucfirst(auth()->user()->role) }}</div>
                    <div class="sb-status">
                        <span class="sb-status-dot"></span>
                        En línea
                    </div>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="sb-nav">

            <a href="/dashboard"
               class="sb-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="sb-icon">🏠</span>
                <span class="sb-item-label">Dashboard</span>
            </a>

            <div class="sb-divider"></div>

            {{-- Almacenes --}}
            @if($role == 'admin')
            <div class="sb-section alm-s">
                <div class="sb-section-title {{ $seccionActiva === 'alm' ? 'open' : '' }}"
                     onclick="toggleMenu(this)">
                    <div class="sb-section-left">
                        <span class="sb-section-icon">🏢</span>
                        <span>Almacenes</span>
                    </div>
                    <span class="sb-section-arrow">▾</span>
                </div>
                <div class="sb-sub">
                    <a href="{{ route('joselito.index') }}">
                        <span class="sb-icon">🏚️</span><span>Joselito</span>
                    </a>
                    <a href="{{ route('dalsa.index') }}">
                        <span class="sb-icon">🏭</span><span>Dalsa</span>
                    </a>
                </div>
            </div>
            @endif

            {{-- Operaciones --}}
            <div class="sb-section ops-s">
                <div class="sb-section-title {{ $seccionActiva === 'ops' ? 'open' : '' }}"
                     onclick="toggleMenu(this)">
                    <div class="sb-section-left">
                        <span class="sb-section-icon">⚙️</span>
                        <span>Operaciones</span>
                    </div>
                    <span class="sb-section-arrow">▾</span>
                </div>
                <div class="sb-sub">
                    @if($role == 'admin')
                    <a href="/orders">
                        <span class="sb-icon">📋</span><span>Órdenes</span>
                    </a>
                    <a href="/historial">
                        <span class="sb-icon">📚</span><span>Historial</span>
                    </a>
                    <a href="{{ route('raw-materials.index') }}">
                        <span class="sb-icon">🧪</span><span>Materia Prima</span>
                    </a>
                    <a href="{{ route('products.proyectado') }}">
                        <span class="sb-icon">📊</span><span>Proyectado</span>
                    </a>
                    <a href="{{ route('kardex.index') }}">
                        <span class="sb-icon">📒</span><span>Kardex</span>
                    </a>
                    @endif
                    <a href="{{ route('production-orders.index') }}">
                        <span class="sb-icon">🏭</span><span>Producción</span>
                    </a>
                    @if($role == 'operario')
                    <a href="/pedidos">
                        <span class="sb-icon">📦</span><span>Pedidos</span>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Inventario --}}
            <div class="sb-section inv-s">
                <div class="sb-section-title {{ $seccionActiva === 'inv' ? 'open' : '' }}"
                     onclick="toggleMenu(this)">
                    <div class="sb-section-left">
                        <span class="sb-section-icon">📦</span>
                        <span>Inventario</span>
                    </div>
                    <span class="sb-section-arrow">▾</span>
                </div>
                <div class="sb-sub">
                    @if($role == 'admin')
                    <a href="/categories">
                        <span class="sb-icon">🏷</span><span>Categorías</span>
                    </a>
                    <a href="{{ route('labels.index') }}">
                        <span class="sb-icon">🔖</span><span>Etiquetas</span>
                    </a>
                    <a href="{{ route('stickers.index') }}">
                        <span class="sb-icon">🏷️</span><span>Stickers de tapa</span>
                    </a>
                    <a href="{{ route('precintos.index') }}">
                        <span class="sb-icon">🔒</span><span>Precintos</span>
                    </a>
                    @endif
                    <a href="{{ route('cajas.index') }}">
                        <span class="sb-icon">📫</span><span>Cajas</span>
                    </a>
                    <a href="/products">
                        <span class="sb-icon">🛍️</span><span>Productos</span>
                    </a>
                    <a href="{{ route('warehouse.index') }}">
                        <span class="sb-icon">🗺️</span><span>Mapa del Almacén</span>
                    </a>
                </div>
            </div>

            {{-- Comercial --}}
            @if($role == 'admin')
            <div class="sb-section com-s">
                <div class="sb-section-title {{ $seccionActiva === 'com' ? 'open' : '' }}"
                     onclick="toggleMenu(this)">
                    <div class="sb-section-left">
                        <span class="sb-section-icon">🤝</span>
                        <span>Comercial</span>
                    </div>
                    <span class="sb-section-arrow">▾</span>
                </div>
                <div class="sb-sub">
                    <a href="/clients">
                        <span class="sb-icon">👤</span><span>Clientes</span>
                    </a>
                    <a href="/proveedores">
                        <span class="sb-icon">🚚</span><span>Proveedores</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active configuracion' : '' }}">
                    <span class="sb-icon">👤</span><span>Usuarios</span> </a>
                </div>
            </div>
            @endif
            {{-- Comercial --}}
            @if($role == 'admin')
            <div class="sb-section com-s">
                <div class="sb-section-title {{ $seccionActiva === 'com' ? 'open' : '' }}"
                     onclick="toggleMenu(this)">
                    <div class="sb-section-left">
                        <span class="sb-section-icon"></span>
                        <span>Auditoria</span>
                    </div>
                    <span class="sb-section-arrow">▾</span>
                     </div>
                <div class="sb-sub">
                    <a href="{{ route('stockcount.index') }}">Conteo físico</a>
                
                    <a href="{{ route('desmedros.index') }}" class="{{ request()->routeIs('desmedros.*') ? 'active' : '' }}">
                        <span>Desmedros</span> 
                    </a>
                    <a href="{{ route('rechazos.index') }}">
                        <span>↩</span><span>Rechazos</span>
                    </a>
                </div>
            </div>
            @endif

        </nav>
    </div>

    {{-- Footer --}}
    <div class="sb-footer">

        <div class="sb-section-indicator">
            <span class="sb-section-indicator-dot"></span>
            {{ $t['label'] }}
        </div>

        <div class="sb-clock">
            <div id="clockTime">00:00:00</div>
            <div id="clockDate">--</div>
        </div>

        <div class="sb-storage">
            <div class="sb-storage-top">
                <span class="sb-storage-label">📦 Capacidad almacén</span>
                <span class="sb-storage-pct">82%</span>
            </div>
            <div class="sb-storage-bar">
                <div class="sb-storage-fill"></div>
            </div>
        </div>

        <div class="sb-version">DISTAN ERP · v1.0.0</div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sb-logout">
                <span>🚪</span>
                <span>Cerrar sesión</span>
            </button>
        </form>

    </div>

</div>

<script>
/* ── 1. Toggle secciones ── */
function toggleMenu(el) {
    var sub   = el.nextElementSibling;
    var arrow = el.querySelector('.sb-section-arrow');
    if (!sub) return;

    if (sub.style.maxHeight && sub.style.maxHeight !== '0px') {
        sub.style.maxHeight = '0px';
        el.classList.remove('open');
    } else {
        sub.style.maxHeight = sub.scrollHeight + 'px';
        el.classList.add('open');
    }
}

/* ── 2. Colapsar / expandir (desktop) ── */
var sbCollapsed = false;

function toggleSidebar() {
    var sb   = document.getElementById('sidebar');
    var main = document.getElementById('mainContent');

    sbCollapsed = !sbCollapsed;
    sb.classList.toggle('collapsed', sbCollapsed);

    if (main) {
        main.classList.toggle('sidebar-collapsed', sbCollapsed);
    }

    localStorage.setItem('sb_collapsed', sbCollapsed ? '1' : '0');
}

/* ── 3. Sidebar móvil ── */
function openSidebar() {
    document.getElementById('sidebar').classList.add('mobile-open');
    document.getElementById('sbOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sbOverlay').classList.remove('show');
    document.body.style.overflow = '';
}

/* ── 4. Reloj ── */
function actualizarReloj() {
    var ahora  = new Date();
    var timeEl = document.getElementById('clockTime');
    var dateEl = document.getElementById('clockDate');
    if (timeEl) timeEl.textContent = ahora.toLocaleTimeString('es-PE');
    if (dateEl) dateEl.textContent = ahora.toLocaleDateString('es-PE', {
        weekday:'long', day:'numeric', month:'long'
    });
}

/* ── 5. Init ── */
document.addEventListener('DOMContentLoaded', function() {

    /* Restaurar estado colapsado */
    if (localStorage.getItem('sb_collapsed') === '1') {
        var sb   = document.getElementById('sidebar');
        var main = document.getElementById('mainContent');
        sbCollapsed = true;
        if (sb)   sb.classList.add('collapsed');
        if (main) main.classList.add('sidebar-collapsed');
    }

    /* Abrir sección activa y expandir su submenú */
    var seccionActiva = '{{ $seccionActiva }}';
    if (seccionActiva !== 'dash') {
        document.querySelectorAll('.sb-section-title.open').forEach(function(title) {
            var sub = title.nextElementSibling;
            if (sub) sub.style.maxHeight = sub.scrollHeight + 'px';
        });
    }

    /* Botón hamburguesa */
    var toggleBtn = document.getElementById('sbToggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            var sb = document.getElementById('sidebar');
            if (sb.classList.contains('mobile-open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    /* Reloj */
    actualizarReloj();
    setInterval(actualizarReloj, 1000);
});
</script>