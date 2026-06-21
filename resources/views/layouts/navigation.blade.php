<style>

:root{
    --sb-bg:#0b1220;
    --sb-bg-soft:#121b2e;
    --sb-border:#1d2940;
    --sb-text:#aab4c5;
    --sb-text-bright:#eef2f8;
    --sb-accent:#0b5ed7;
    --sb-accent-soft:#152c52;
    --sb-danger:#c0312b;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
}

.sidebar {
    width:248px;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    background:var(--sb-bg);
    color:var(--sb-text);
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    font-family:var(--font-ui);
    font-size:13px;
    border-right:1px solid var(--sb-border);
    z-index:100;
}

.sidebar-scroll{
    overflow-y:auto;
    flex:1;
}

.sidebar-scroll::-webkit-scrollbar{
    width:6px;
}
.sidebar-scroll::-webkit-scrollbar-thumb{
    background:var(--sb-border);
    border-radius:3px;
}

/* ---------- Logo ---------- */

.logo {
    padding:18px 20px;
    font-weight:700;
    font-size:15px;
    letter-spacing:.5px;
    color:var(--sb-text-bright);
    display:flex;
    align-items:center;
    gap:10px;
    border-bottom:1px solid var(--sb-border);
}

.logo .logo-mark{
    width:30px;
    height:30px;
    border-radius:6px;
    background:linear-gradient(135deg,var(--sb-accent),#3b82f6);
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
    color:var(--sb-text);
    letter-spacing:.6px;
    text-transform:uppercase;
}

/* ---------- Top-level item ---------- */

.menu-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:11px 20px;
    color:var(--sb-text);
    text-decoration:none;
    border-left:3px solid transparent;
    font-weight:500;
    transition:background .15s, color .15s;
}

.menu-item .icon{
    width:16px;
    text-align:center;
    flex-shrink:0;
    opacity:.85;
}

.menu-item:hover {
    background:var(--sb-bg-soft);
    color:var(--sb-text-bright);
}

.menu-item.active {
    background:var(--sb-accent-soft);
    color:var(--sb-text-bright);
    border-left-color:var(--sb-accent);
    font-weight:600;
}

/* ---------- Section group / collapsible ---------- */

.menu-group{
    margin-top:4px;
}

.menu-title {
    display:flex;
    align-items:center;
    gap:10px;
    padding:11px 20px;
    cursor:pointer;
    font-weight:600;
    font-size:11px;
    letter-spacing:.6px;
    text-transform:uppercase;
    color:#7c89a0;
    user-select:none;
}

.menu-title .icon{
    width:16px;
    text-align:center;
    flex-shrink:0;
    font-size:13px;
}

.menu-title .chevron{
    margin-left:auto;
    font-size:10px;
    transition:transform .25s;
    opacity:.7;
}

.menu-title.open .chevron{
    transform:rotate(90deg);
}

.menu-title:hover{
    color:var(--sb-text-bright);
}

.menu-sub {
    max-height:0;
    overflow:hidden;
    transition:max-height .25s ease;
}

.menu-sub a {
    display:flex;
    align-items:center;
    gap:9px;
    padding:9px 20px 9px 38px;
    color:var(--sb-text);
    text-decoration:none;
    font-size:12.5px;
    border-left:3px solid transparent;
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
    background:var(--sb-bg-soft);
    color:var(--sb-text-bright);
}

.menu-sub a:hover:before{
    background:var(--sb-accent);
}

.menu-sub a.active{
    color:var(--sb-text-bright);
    background:var(--sb-accent-soft);
    border-left-color:var(--sb-accent);
    font-weight:600;
}

.menu-sub a.active:before{
    background:var(--sb-accent);
}

/* ---------- User / footer ---------- */

.sidebar-footer {
    padding:14px 16px;
    border-top:1px solid var(--sb-border);
    background:var(--sb-bg-soft);
}

.user-row{
    display:flex;
    align-items:center;
    gap:10px;
    padding:6px 4px 12px;
}

.user-avatar{
    width:32px;
    height:32px;
    border-radius:50%;
    background:var(--sb-accent);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:13px;
    flex-shrink:0;
}

.user-info{
    min-width:0;
}

.user-name{
    color:var(--sb-text-bright);
    font-weight:600;
    font-size:12.5px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.user-role{
    color:#7c89a0;
    font-size:10.5px;
}

.btn-logout {
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    background:transparent;
    color:#f3a8a4;
    border:1px solid #3a2330;
    padding:8px;
    border-radius:5px;
    font-weight:600;
    font-size:12px;
    cursor:pointer;
    transition:background .15s, color .15s;
}

.btn-logout:hover {
    background:var(--sb-danger);
    color:white;
    border-color:var(--sb-danger);
}

</style>

<div class="sidebar">

    <div class="sidebar-scroll">

        <div class="logo">
            <div class="logo-mark">🚀</div>
            <div>
                DISTAN
                <span class="logo-sub">ERP Logística</span>
            </div>
        </div>

        <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>

        <!-- OPERACIONES -->
        <div class="menu-group">
            <div class="menu-title {{ request()->is('orders*','pedidos*','historial*','produccion*') ? 'open' : '' }}" onclick="toggleMenu(this)">
                <span class="icon">📦</span> Operaciones
                <span class="chevron">▶</span>
            </div>

            <div class="menu-sub" style="{{ request()->is('orders*','pedidos*','historial*','produccion*') ? 'max-height:200px;' : '' }}">
                <a href="/orders" class="{{ request()->is('orders*') ? 'active' : '' }}">Órdenes</a>
                <a href="/pedidos" class="{{ request()->is('pedidos*') ? 'active' : '' }}">Pedidos</a>
                <a href="/historial" class="{{ request()->is('historial*') ? 'active' : '' }}">📚 Historial</a>
                <a href="/produccion" class="{{ request()->is('produccion*') ? 'active' : '' }}">Producción</a>
            </div>
        </div>

        <!-- INVENTARIO -->
        <div class="menu-group">
            <div class="menu-title {{ request()->is('products*','categories*','inventario*') ? 'open' : '' }}" onclick="toggleMenu(this)">
                <span class="icon">📚</span> Inventario
                <span class="chevron">▶</span>
            </div>

            <div class="menu-sub" style="{{ request()->is('products*','categories*','inventario*') ? 'max-height:200px;' : '' }}">
                <a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">Productos</a>
                <a href="/categories" class="{{ request()->is('categories*') ? 'active' : '' }}">Categorías</a>
                <a href="/inventario" class="{{ request()->is('inventario*') ? 'active' : '' }}">Inventario</a>
            </div>
        </div>

        <!-- COMERCIAL -->
        <div class="menu-group">
            <div class="menu-title {{ request()->is('clients*','proveedores*') ? 'open' : '' }}" onclick="toggleMenu(this)">
                <span class="icon">🤝</span> Comercial
                <span class="chevron">▶</span>
            </div>

            <div class="menu-sub" style="{{ request()->is('clients*','proveedores*') ? 'max-height:200px;' : '' }}">
                <a href="/clients" class="{{ request()->is('clients*') ? 'active' : '' }}">Clientes</a>
                <a href="/proveedores" class="{{ request()->is('proveedores*') ? 'active' : '' }}">Proveedores</a>
            </div>
        </div>

    </div>

    <div class="sidebar-footer">

        <div class="user-row">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Usuario activo</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                🚪 Cerrar sesión
            </button>
        </form>

    </div>

</div>

<script>
function toggleMenu(el){
    let sub = el.nextElementSibling;

    el.classList.toggle('open');

    if(sub.style.maxHeight && sub.style.maxHeight !== "0px"){
        sub.style.maxHeight = null;
    } else {
        sub.style.maxHeight = sub.scrollHeight + "px";
    }
}
</script>