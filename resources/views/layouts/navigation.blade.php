@php
$role = auth()->user()->role;
@endphp

<style>
    .main-content{

    margin-left:270px;

    transition:margin-left .30s ease;

    min-height:100vh;

}
.main-content.sidebar-collapsed{

    margin-left:56px;

}
/* ============================================================
   SIDEBAR — JOYBER PERÚ ERP
   Compatible con: toggleMenu(), reloj, roles admin/operario
============================================================ */

*{box-sizing:border-box;}
:root{

    --sidebar-width:270px;

}
:root{
    --sb-bg1:#060f1e;
    --sb-bg2:#0a1628;
    --sb-bg3:#0d1f38;
    --sb-border:rgba(255,255,255,.06);
    --sb-text:#c8daf0;
    --sb-text-muted:#5b7da8;
    --sb-accent-dash:#3b82f6;
    --sb-accent-ops:#f59e0b;
    --sb-accent-inv:#22c55e;
    --sb-accent-com:#8b5cf6;
    --sb-accent-alm:#06b6d4;
    --sb-ok:#22c55e;
    --sb-width:270px;
    --sb-collapsed:0px;
    --font:'Segoe UI',-apple-system,BlinkMacSystemFont,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',monospace;
}

/* ── Botón toggle (hamburguesa) ── */
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
.sb-toggle:hover{background:#0d1f38;}
.sb-toggle-icon{
    display:flex;flex-direction:column;gap:4px;
}
.sb-toggle-icon span{
    display:block;width:18px;height:2px;
    background:#7eb8f7;border-radius:2px;
    transition:transform .3s,opacity .3s;
}

/* Overlay para móvil */
.sb-overlay{
    display:none;
    position:fixed;inset:0;
    background:rgba(0,0,0,.6);
    backdrop-filter:blur(2px);
    z-index:999;
}
.sb-overlay.show{display:block;}

/* ── Sidebar principal ── */
.sidebar{
    width:var(--sb-width);
    height:100vh;
    position:fixed;
    top:0;left:0;
    overflow-y:auto;
    overflow-x:hidden;
    background:linear-gradient(180deg,var(--sb-bg1) 0%,var(--sb-bg2) 50%,var(--sb-bg3) 100%);
    color:var(--sb-text);
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:6px 0 24px rgba(0,0,0,.4);
    border-right:1px solid var(--sb-border);
    font-family:var(--font);
    font-size:13px;
    z-index:1000;
    transition:transform .3s cubic-bezier(.16,1,.3,1);
}

/* Scrollbar */
.sidebar::-webkit-scrollbar{width:4px;}
.sidebar::-webkit-scrollbar-track{background:transparent;}
.sidebar::-webkit-scrollbar-thumb{background:#1f3a5f;border-radius:99px;}

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
    background:linear-gradient(135deg,#1d4ed8,#2563eb);
    border-radius:8px;
    display:flex;align-items:center;justify-content:center;
    font-size:18px;
    box-shadow:0 4px 14px rgba(37,99,235,.35);
}
.sb-brand-info{}
.sb-brand-name{
    font-size:14px;font-weight:800;
    color:#f1f5f9;letter-spacing:.3px;
}
.sb-brand-sub{
    font-size:10px;color:var(--sb-text-muted);
    text-transform:uppercase;letter-spacing:.07em;margin-top:1px;
}

/* Botón colapsar */
.sb-collapse-btn{
    margin-left:auto;
    width:26px;height:26px;flex-shrink:0;
    background:rgba(255,255,255,.05);
    border:1px solid var(--sb-border);
    border-radius:5px;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;color:var(--sb-text-muted);
    font-size:14px;
    transition:background .15s,color .15s;
}
.sb-collapse-btn:hover{background:rgba(255,255,255,.1);color:#f1f5f9;}

/* User card */
.sb-user{
    background:rgba(255,255,255,.05);
    border:1px solid var(--sb-border);
    border-radius:8px;
    padding:12px;
    display:flex;align-items:center;gap:10px;
}
.sb-avatar{
    width:38px;height:38px;flex-shrink:0;
    border-radius:50%;
    background:linear-gradient(135deg,#2563eb,#60a5fa);
    display:flex;align-items:center;justify-content:center;
    font-size:16px;font-weight:800;color:#fff;
    box-shadow:0 4px 12px rgba(37,99,235,.3);
    border:2px solid rgba(255,255,255,.12);
}
.sb-user-info{flex:1;min-width:0;}
.sb-user-name{
    font-size:13px;font-weight:700;color:#f1f5f9;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.sb-user-role{
    font-size:10px;color:var(--sb-text-muted);margin-top:1px;
    text-transform:capitalize;
}
.sb-status{
    display:inline-flex;align-items:center;gap:4px;
    background:rgba(34,197,94,.1);
    border:1px solid rgba(34,197,94,.2);
    border-radius:99px;
    padding:2px 8px;
    font-size:10px;color:#86efac;
    margin-top:4px;
    font-weight:600;
}
.sb-status-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--sb-ok);
    animation:sbPulse 1.5s ease infinite;
    flex-shrink:0;
}
@keyframes sbPulse{
    0%,100%{opacity:1;transform:scale(1);}
    50%{opacity:.4;transform:scale(1.4);}
}

/* ── Nav (menú) ── */
.sb-nav{flex:1;padding:8px 0;}

/* Dashboard link directo */
.sb-item{
    display:flex;align-items:center;gap:10px;
    color:var(--sb-text);
    text-decoration:none;
    padding:10px 16px;
    border-left:3px solid transparent;
    transition:background .15s,padding-left .15s,border-color .15s;
    font-size:13px;font-weight:500;
    position:relative;
}
.sb-item:hover{
    background:rgba(255,255,255,.05);
    color:#f1f5f9;
}
.sb-item.active{
    background:rgba(59,130,246,.1);
    color:#fff;font-weight:700;
    border-left-color:var(--sb-accent-dash);
}
.sb-item .sb-icon{
    width:24px;height:24px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    font-size:15px;
}
.sb-item-label{font-size:13px;}

/* Sección colapsable */
.sb-section{margin-bottom:2px;}
.sb-section-title{
    display:flex;justify-content:space-between;align-items:center;
    padding:9px 16px;
    cursor:pointer;
    font-size:11px;font-weight:700;
    text-transform:uppercase;letter-spacing:.07em;
    color:var(--sb-text-muted);
    border-left:3px solid transparent;
    transition:background .15s,color .15s;
    user-select:none;
    position:relative;
}
.sb-section-title:hover{
    background:rgba(255,255,255,.04);
    color:var(--sb-text);
}
.sb-section-left{display:flex;align-items:center;gap:8px;}
.sb-section-icon{font-size:14px;width:20px;text-align:center;}
.sb-section-arrow{
    font-size:11px;color:var(--sb-text-muted);
    transition:transform .3s;
    flex-shrink:0;
}

/* Accent por sección */
.sb-section.dash-s  .sb-section-title:hover,
.sb-section.dash-s  .sb-section-title.open{ color:#7eb8f7; }
.sb-section.ops-s   .sb-section-title.open{ color:#fcd34d; }
.sb-section.inv-s   .sb-section-title.open{ color:#86efac; }
.sb-section.com-s   .sb-section-title.open{ color:#c4b5fd; }
.sb-section.alm-s   .sb-section-title.open{ color:#67e8f9; }

.sb-section-title.open .sb-section-arrow{transform:rotate(180deg);}

/* Accent bar izquierda */
.sb-section.ops-s .sb-section-title.open{border-left-color:var(--sb-accent-ops);}
.sb-section.inv-s .sb-section-title.open{border-left-color:var(--sb-accent-inv);}
.sb-section.com-s .sb-section-title.open{border-left-color:var(--sb-accent-com);}
.sb-section.alm-s .sb-section-title.open{border-left-color:var(--sb-accent-alm);}

/* Submenú */
.sb-sub{
    overflow:hidden;
    max-height:0;
    transition:max-height .35s ease;
}
.sb-sub a{
    display:flex;align-items:center;gap:9px;
    color:#8baecf;
    text-decoration:none;
    padding:8px 16px 8px 40px;
    font-size:12.5px;
    border-left:3px solid transparent;
    transition:background .15s,color .15s,padding-left .15s;
}
.sb-sub a:hover{
    background:rgba(255,255,255,.04);
    color:#f1f5f9;
    padding-left:46px;
}
.sb-sub a .sb-icon{
    width:20px;height:20px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    font-size:13px;
}
.sb-sub a span:last-child{flex:1;}

/* Separador de secciones */
.sb-divider{
    height:1px;background:var(--sb-border);
    margin:6px 16px;
}

/* ── Footer ── */
.sb-footer{
    border-top:1px solid var(--sb-border);
    padding:14px 16px;
    flex-shrink:0;
}

/* Reloj */
.sb-clock{
    text-align:center;
    margin-bottom:12px;
    background:rgba(255,255,255,.03);
    border:1px solid var(--sb-border);
    border-radius:7px;
    padding:10px;
}
#clockTime{
    font-family:var(--font-mono);
    font-size:22px;font-weight:700;
    color:#f1f5f9;letter-spacing:2px;
    line-height:1;
}
#clockDate{
    margin-top:5px;font-size:11px;
    color:var(--sb-text-muted);
    text-transform:capitalize;
}

/* Capacidad */
.sb-storage{
    margin-bottom:12px;
}
.sb-storage-top{
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:6px;
}
.sb-storage-label{font-size:11px;color:var(--sb-text-muted);}
.sb-storage-pct{font-size:11px;font-weight:700;color:#86efac;font-family:var(--font-mono);}
.sb-storage-bar{
    height:5px;background:rgba(255,255,255,.07);
    border-radius:99px;overflow:hidden;
}
.sb-storage-fill{
    height:100%;width:82%;
    background:linear-gradient(90deg,#22c55e,#3b82f6);
    border-radius:99px;
}

/* Versión */
.sb-version{
    text-align:center;font-size:10px;
    color:var(--sb-text-muted);margin-bottom:10px;
    font-family:var(--font-mono);
}

/* Logout */
.sb-logout{
    width:100%;padding:9px 12px;
    border:none;border-radius:6px;
    background:rgba(239,68,68,.1);
    border:1px solid rgba(239,68,68,.2);
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
.sidebar.collapsed{
    width:56px;
}
.sidebar.collapsed .sb-brand-info,
.sidebar.collapsed .sb-brand-icon{
    display:none;
}
.sidebar.collapsed .sb-user-info,
.sidebar.collapsed .sb-status,
.sidebar.collapsed .sb-section-left span:last-child,
.sidebar.collapsed .sb-section-arrow,
.sidebar.collapsed .sb-item-label,
.sidebar.collapsed .sb-sub,
.sidebar.collapsed .sb-clock #clockDate,
.sidebar.collapsed .sb-storage-label,
.sidebar.collapsed .sb-storage-pct,
.sidebar.collapsed .sb-storage-bar,
.sidebar.collapsed .sb-version,
.sidebar.collapsed .sb-logout span:last-child{
    display:none;
}
.sidebar.collapsed .sb-brand{justify-content:center;
    min-height:40px;
}
.sidebar.collapsed .sb-user{justify-content:center;padding:8px;}
.sidebar.collapsed .sb-avatar{margin:0;}
.sidebar.collapsed .sb-item{justify-content:center;padding:10px;}
.sidebar.collapsed .sb-section-title{justify-content:center;padding:10px;}
.sidebar.collapsed .sb-clock{
    display:none;}
.sidebar.collapsed .sb-collapse-btn{
    display:flex;
    position:absolute;
    top:18px;
    right:12px;
    width:26px;
    height:26px;
    z-index:1002;
}
.sidebar.collapsed .sb-collapse-btn{
    display:none;
}

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .sb-toggle{display:flex;}
    .sidebar{
        transform:translateX(-100%);
        width:var(--sb-width) !important;
    }
    .sidebar.mobile-open{
        transform:translateX(0);
    }
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

    {{-- ── Header ── --}}
    <div>
    <div class="sb-header">
        <div class="sb-brand">
            <div class="sb-brand-icon">🚀</div>
            <div class="sb-brand-info">
                <div class="sb-brand-name">DISTAN</div>
                <div class="sb-brand-sub">Warehouse & Production</div>
            </div>
            <div class="sb-collapse-btn" onclick="toggleSidebar()" title="Colapsar menú">‹</div>
        </div>

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

    {{-- ── Nav ── --}}
    <nav class="sb-nav">

        {{-- Dashboard --}}
        <a href="/dashboard"
           class="sb-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="sb-icon">⬛</span>
            <span class="sb-item-label">Dashboard</span>
        </a>

        <div class="sb-divider"></div>

        {{-- Almacenes --}}
        @if($role == 'admin')
        <div class="sb-section alm-s">
            <div class="sb-section-title" onclick="toggleMenu(this)">
                <div class="sb-section-left">
                    <span class="sb-section-icon">🏢</span>
                    <span>Almacenes</span>
                </div>
                <span class="sb-section-arrow">▾</span>
            </div>
            <div class="menu-sub sb-sub">
                <a href="{{ route('joselito.index') }}">
                    <span class="sb-icon">🏚️</span>
                    <span>Joselito</span>
                </a>
                <a href="{{ route('dalsa.index') }}">
                    <span class="sb-icon">🏭</span>
                    <span>Dalsa</span>
                </a>
            </div>
        </div>
        @endif

        {{-- Operaciones --}}
        <div class="sb-section ops-s">
            <div class="sb-section-title" onclick="toggleMenu(this)">
                <div class="sb-section-left">
                    <span class="sb-section-icon">⚙️</span>
                    <span>Operaciones</span>
                </div>
                <span class="sb-section-arrow">▾</span>
            </div>
            <div class="menu-sub sb-sub">
                @if($role == 'admin')
                <a href="/orders">
                    <span class="sb-icon">📋</span>
                    <span>Órdenes</span>
                </a>
                <a href="/historial">
                    <span class="sb-icon">📚</span>
                    <span>Historial</span>
                </a>
                <a href="{{ route('raw-materials.index') }}">
                    <span class="sb-icon">🧪</span>
                    <span>Materia Prima</span>
                </a>
                <a href="{{ route('products.proyectado') }}">
                    <span class="sb-icon">📊</span>
                    <span>Proyectado</span>
                </a>
                <a href="{{ route('kardex.index') }}">
                    <span class="sb-icon">📒</span>
                    <span>Kardex</span>
                </a>
                @endif
                <a href="{{ route('production-orders.index') }}">
                    <span class="sb-icon">🏭</span>
                    <span>Producción</span>
                </a>
                @if($role == 'operario')
                <a href="/pedidos">
                    <span class="sb-icon">📦</span>
                    <span>Pedidos</span>
                </a>
                @endif
            </div>
        </div>

        {{-- Inventario --}}
        <div class="sb-section inv-s">
            <div class="sb-section-title" onclick="toggleMenu(this)">
                <div class="sb-section-left">
                    <span class="sb-section-icon">📦</span>
                    <span>Inventario</span>
                </div>
                <span class="sb-section-arrow">▾</span>
            </div>
            <div class="menu-sub sb-sub">
                @if($role == 'admin')
                <a href="/categories">
                    <span class="sb-icon">🏷</span>
                    <span>Categorías</span>
                </a>
                <a href="{{ route('labels.index') }}">
                    <span class="sb-icon">🔖</span>
                    <span>Etiquetas</span>
                </a>
                <a href="{{ route('stickers.index') }}">
                    <span class="sb-icon">🏷️</span>
                    <span>Stickers de tapa</span>
                </a>
                <a href="{{ route('precintos.index') }}">
                    <span class="sb-icon">🔒</span>
                    <span>Precintos</span>
                </a>
                @endif
                <a href="{{ route('cajas.index') }}">
                    <span class="sb-icon">📫</span>
                    <span>Cajas</span>
                </a>
                <a href="/products">
                    <span class="sb-icon">🛍️</span>
                    <span>Productos</span>
                </a>
                <a href="{{ route('warehouse.index') }}">
                    <span class="sb-icon">🗺️</span>
                    <span>Mapa del Almacén</span>
                </a>
            </div>
        </div>

        {{-- Comercial --}}
        @if($role == 'admin')
        <div class="sb-section com-s">
            <div class="sb-section-title" onclick="toggleMenu(this)">
                <div class="sb-section-left">
                    <span class="sb-section-icon">🤝</span>
                    <span>Comercial</span>
                </div>
                <span class="sb-section-arrow">▾</span>
            </div>
            <div class="menu-sub sb-sub">
                <a href="/clients">
                    <span class="sb-icon">👤</span>
                    <span>Clientes</span>
                </a>
                <a href="/proveedores">
                    <span class="sb-icon">🚚</span>
                    <span>Proveedores</span>
                </a>
            </div>
        </div>
        @endif

    </nav>
    </div>

    {{-- ── Footer ── --}}
    <div class="sb-footer">

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

        <div class="sb-version">JOYBER ERP · v1.0.0</div>

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
/* ── Toggle secciones ── */
function toggleMenu(el) {
    var sub   = el.nextElementSibling;
    var arrow = el.querySelector('.sb-section-arrow');

    if (sub.style.maxHeight) {
        sub.style.maxHeight = null;
        el.classList.remove('open');
    } else {
        sub.style.maxHeight = sub.scrollHeight + 'px';
        el.classList.add('open');
    }
}

/* ── Colapsar sidebar (desktop) ── */
var sbCollapsed = false;
function toggleSidebar(){

    const sb   = document.getElementById('sidebar');
    const main = document.getElementById('mainContent');

    sbCollapsed = !sbCollapsed;

    sb.classList.toggle('collapsed', sbCollapsed);

    main.classList.toggle(
        'sidebar-collapsed',
        sbCollapsed
    );

    localStorage.setItem(
        'sb_collapsed',
        sbCollapsed ? '1' : '0'
    );

}

/* Restaurar estado al cargar */
document.addEventListener("DOMContentLoaded",function(){

    const sb   = document.getElementById("sidebar");
    const main = document.getElementById("mainContent");

    if(localStorage.getItem("sb_collapsed")=="1"){

        sb.classList.add("collapsed");

        main.classList.add("sidebar-collapsed");

    }

});

    // Abrir la sección activa automáticamente
    var links = document.querySelectorAll('.sb-sub a');
    links.forEach(function(link) {
        if (link.href === window.location.href) {
            var sub   = link.closest('.sb-sub');
            var title = sub.previousElementSibling;
            if (sub && title) {
                sub.style.maxHeight = sub.scrollHeight + 'px';
                title.classList.add('open');
            }
        }
    });
});

/* ── Sidebar móvil ── */
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
document.getElementById('sbToggle').addEventListener('click', function() {
    var sb = document.getElementById('sidebar');
    if (sb.classList.contains('mobile-open')) {
        closeSidebar();
    } else {
        openSidebar();
    }
});

/* ── Reloj ── */
function actualizarReloj() {
    var ahora = new Date();
    document.getElementById('clockTime').textContent = ahora.toLocaleTimeString('es-PE');
    document.getElementById('clockDate').textContent = ahora.toLocaleDateString('es-PE', {
        weekday:'long', day:'numeric', month:'long'
    });
}
setInterval(actualizarReloj, 1000);
actualizarReloj();
</script>