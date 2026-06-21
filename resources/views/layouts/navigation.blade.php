<style>

:root{
    --nb-bg:#0b1220;
    --nb-bg-soft:#121b2e;
    --nb-border:#1d2940;
    --nb-text:#aab4c5;
    --nb-text-bright:#eef2f8;
    --nb-accent:#0b5ed7;
    --nb-accent-soft:#152c52;
    --nb-danger:#c0312b;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
}

*{
    box-sizing:border-box;
}

.navbar{
    width:100%;
    background:var(--nb-bg);
    color:var(--nb-text);
    font-family:var(--font-ui);
    font-size:13px;
    border-bottom:1px solid var(--nb-border);
    position:sticky;
    top:0;
    left:0;
    z-index:100;
}

.navbar-inner{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 18px;
    height:58px;
}

/* ---------- Logo ---------- */

.logo {
    font-weight:700;
    font-size:15px;
    letter-spacing:.5px;
    color:var(--nb-text-bright);
    display:flex;
    align-items:center;
    gap:10px;
    flex-shrink:0;
}

.logo .logo-mark{
    width:30px;
    height:30px;
    border-radius:6px;
    background:linear-gradient(135deg,var(--nb-accent),#3b82f6);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
    flex-shrink:0;
}

.logo .logo-sub{
    display:block;
    font-size:10px;
    font-weight:500;
    color:var(--nb-text);
    letter-spacing:.6px;
    text-transform:uppercase;
}

/* ---------- Desktop menu ---------- */

.nav-menu{
    display:flex;
    align-items:center;
    gap:2px;
    flex:1;
    margin-left:30px;
}

.menu-item {
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    color:var(--nb-text);
    text-decoration:none;
    border-radius:5px;
    font-weight:500;
    white-space:nowrap;
    transition:background .15s, color .15s;
}

.menu-item .icon{
    font-size:14px;
}

.menu-item:hover {
    background:var(--nb-bg-soft);
    color:var(--nb-text-bright);
}

.menu-item.active {
    background:var(--nb-accent-soft);
    color:var(--nb-text-bright);
    font-weight:600;
}

/* ---------- Dropdown group ---------- */

.menu-group{
    position:relative;
}

.menu-title {
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    cursor:pointer;
    font-weight:500;
    color:var(--nb-text);
    border-radius:5px;
    user-select:none;
    white-space:nowrap;
    transition:background .15s, color .15s;
}

.menu-title .icon{
    font-size:14px;
}

.menu-title .chevron{
    font-size:9px;
    opacity:.7;
    transition:transform .2s;
}

.menu-title.open .chevron{
    transform:rotate(180deg);
}

.menu-title:hover,
.menu-title.open{
    background:var(--nb-bg-soft);
    color:var(--nb-text-bright);
}

.menu-sub {
    position:absolute;
    top:calc(100% + 6px);
    left:0;
    min-width:190px;
    background:var(--nb-bg-soft);
    border:1px solid var(--nb-border);
    border-radius:8px;
    padding:6px;
    box-shadow:0 12px 24px rgba(0,0,0,.35);
    opacity:0;
    visibility:hidden;
    transform:translateY(-6px);
    transition:opacity .18s, transform .18s, visibility .18s;
}

.menu-sub.open{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

.menu-sub a {
    display:flex;
    align-items:center;
    gap:9px;
    padding:9px 12px;
    color:var(--nb-text);
    text-decoration:none;
    font-size:12.5px;
    border-radius:5px;
}

.menu-sub a:before{
    content:"";
    width:5px;
    height:5px;
    border-radius:50%;
    background:#3a4863;
    flex-shrink:0;
}

.menu-sub a:hover {
    background:#1a2740;
    color:var(--nb-text-bright);
}

.menu-sub a:hover:before{
    background:var(--nb-accent);
}

.menu-sub a.active{
    color:var(--nb-text-bright);
    background:var(--nb-accent-soft);
    font-weight:600;
}

.menu-sub a.active:before{
    background:var(--nb-accent);
}

/* ---------- User / logout (desktop) ---------- */

.nav-user{
    display:flex;
    align-items:center;
    gap:10px;
    flex-shrink:0;
}

.user-avatar{
    width:30px;
    height:30px;
    border-radius:50%;
    background:var(--nb-accent);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:12.5px;
    flex-shrink:0;
}

.user-info{
    min-width:0;
    line-height:1.2;
}

.user-name{
    color:var(--nb-text-bright);
    font-weight:600;
    font-size:12.5px;
    white-space:nowrap;
}

.user-role{
    color:#7c89a0;
    font-size:10px;
}

.btn-logout {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    background:transparent;
    color:#f3a8a4;
    border:1px solid #3a2330;
    padding:7px 12px;
    border-radius:5px;
    font-weight:600;
    font-size:12px;
    cursor:pointer;
    white-space:nowrap;
    transition:background .15s, color .15s;
}

.btn-logout:hover {
    background:var(--nb-danger);
    color:white;
    border-color:var(--nb-danger);
}

/* ---------- Hamburger (mobile) ---------- */

.nav-toggle{
    display:none;
    flex-direction:column;
    gap:4px;
    background:none;
    border:none;
    cursor:pointer;
    padding:8px;
}

.nav-toggle span{
    width:22px;
    height:2px;
    background:var(--nb-text-bright);
    border-radius:2px;
    transition:transform .2s, opacity .2s;
}

.nav-toggle.open span:nth-child(1){
    transform:translateY(6px) rotate(45deg);
}
.nav-toggle.open span:nth-child(2){
    opacity:0;
}
.nav-toggle.open span:nth-child(3){
    transform:translateY(-6px) rotate(-45deg);
}

/* ---------- Responsive ---------- */

@media (max-width:900px){

    .nav-toggle{
        display:flex;
    }

    .nav-menu{
        position:fixed;
        top:58px;
        left:0;
        right:0;
        bottom:0;
        margin-left:0;
        background:var(--nb-bg);
        flex-direction:column;
        align-items:stretch;
        padding:10px 12px;
        gap:2px;
        overflow-y:auto;
        max-height:0;
        visibility:hidden;
        transition:max-height .25s ease;
    }

    .nav-menu.open{
        max-height:calc(100vh - 58px);
        visibility:visible;
    }

    .menu-item, .menu-title{
        width:100%;
        padding:13px 14px;
    }

    .menu-group{
        width:100%;
    }

    .menu-sub{
        position:static;
        opacity:1;
        visibility:visible;
        transform:none;
        box-shadow:none;
        border:none;
        background:transparent;
        max-height:0;
        overflow:hidden;
        padding:0;
        transition:max-height .25s ease;
        display:block;
    }

    .menu-sub.open{
        max-height:300px;
        padding:4px 0 8px;
    }

    .menu-sub a{
        padding-left:34px;
    }

    .nav-user{
        display:none;
    }

    .nav-user-mobile{
        display:flex !important;
        margin-top:8px;
        padding-top:12px;
        border-top:1px solid var(--nb-border);
        flex-direction:column;
        gap:10px;
    }

    .nav-user-mobile .user-row{
        display:flex;
        align-items:center;
        gap:10px;
        padding:0 14px;
    }
}

.nav-user-mobile{
    display:none;
}

</style>

<nav class="navbar">

    <div class="navbar-inner">

        <div class="logo">
            <div class="logo-mark">🚀</div>
            <div>
                DISTAN
                <span class="logo-sub">ERP Logística</span>
            </div>
        </div>

        <button class="nav-toggle" onclick="toggleNav(this)" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-menu" id="navMenu">

            <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span> Dashboard
            </a>

            <!-- OPERACIONES -->
            <div class="menu-group">
                <div class="menu-title" onclick="toggleDropdown(this)">
                    <span class="icon">📦</span> Operaciones
                    <span class="chevron">▼</span>
                </div>

                <div class="menu-sub">
                    <a href="/orders" class="{{ request()->is('orders*') ? 'active' : '' }}">Órdenes</a>
                    <a href="/pedidos" class="{{ request()->is('pedidos*') ? 'active' : '' }}">Pedidos</a>
                    <a href="/historial" class="{{ request()->is('historial*') ? 'active' : '' }}">📚 Historial</a>
                    <a href="/produccion" class="{{ request()->is('produccion*') ? 'active' : '' }}">Producción</a>
                </div>
            </div>

            <!-- INVENTARIO -->
            <div class="menu-group">
                <div class="menu-title" onclick="toggleDropdown(this)">
                    <span class="icon">📚</span> Inventario
                    <span class="chevron">▼</span>
                </div>

                <div class="menu-sub">
                    <a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">Productos</a>
                    <a href="/categories" class="{{ request()->is('categories*') ? 'active' : '' }}">Categorías</a>
                    <a href="/inventario" class="{{ request()->is('inventario*') ? 'active' : '' }}">Inventario</a>
                </div>
            </div>

            <!-- COMERCIAL -->
            <div class="menu-group">
                <div class="menu-title" onclick="toggleDropdown(this)">
                    <span class="icon">🤝</span> Comercial
                    <span class="chevron">▼</span>
                </div>

                <div class="menu-sub">
                    <a href="/clients" class="{{ request()->is('clients*') ? 'active' : '' }}">Clientes</a>
                    <a href="/proveedores" class="{{ request()->is('proveedores*') ? 'active' : '' }}">Proveedores</a>
                </div>
            </div>

            <!-- Usuario / logout: solo visible en móvil, dentro del menú colapsable -->
            <div class="nav-user-mobile">
                <div class="user-row">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Usuario activo</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" style="padding:0 14px;">
                    @csrf
                    <button type="submit" class="btn-logout" style="width:100%;">
                        🚪 Cerrar sesión
                    </button>
                </form>
            </div>

        </div>

        <!-- Usuario / logout: visible en desktop -->
        <div class="nav-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Usuario activo</div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    🚪 Salir
                </button>
            </form>
        </div>

    </div>

</nav>

<script>
function toggleNav(btn){
    btn.classList.toggle('open');
    document.getElementById('navMenu').classList.toggle('open');
}

function toggleDropdown(el){
    const sub = el.nextElementSibling;
    const isOpen = el.classList.contains('open');

    // cierra otros dropdowns abiertos (comportamiento tipo ERP de un solo menú a la vez)
    document.querySelectorAll('.menu-title.open').forEach(function(t){
        if(t !== el){
            t.classList.remove('open');
            t.nextElementSibling.classList.remove('open');
        }
    });

    el.classList.toggle('open', !isOpen);
    sub.classList.toggle('open', !isOpen);
}

// cierra los dropdowns de escritorio si se hace click fuera
document.addEventListener('click', function(e){
    if(window.innerWidth > 900 && !e.target.closest('.menu-group')){
        document.querySelectorAll('.menu-title.open').forEach(function(t){
            t.classList.remove('open');
            t.nextElementSibling.classList.remove('open');
        });
    }
});
</script>