@php
    $role = auth()->user()->role;
@endphp

<style>

*{
    box-sizing:border-box;
}

.sidebar{
    width:285px;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    overflow-y:auto;
    overflow-x:hidden;

    background:linear-gradient(
        180deg,
        #081B36 0%,
        #0B2345 45%,
        #102C54 100%
    );

    color:white;

    display:flex;
    flex-direction:column;
    justify-content:space-between;

    box-shadow:
        8px 0 25px rgba(0,0,0,.18);

    border-right:1px solid rgba(255,255,255,.08);
}

/* Scroll */

.sidebar::-webkit-scrollbar{

    width:6px;

}

.sidebar::-webkit-scrollbar-thumb{

    background:#1f4f8f;
    border-radius:20px;

}

/* =======================================
HEADER
======================================= */

.sidebar-header{

    padding:28px 20px 18px;

    text-align:center;

    border-bottom:1px solid rgba(255,255,255,.08);

}

/* Logo */

.logo{

    width:120px;

    margin:auto;

}

.logo img{

    width:100%;

    border-radius:18px;

}

/* Nombre sistema */

.system-name{

    margin-top:14px;

    font-size:26px;

    font-weight:700;

    letter-spacing:1px;

}

.system-sub{

    font-size:12px;

    color:#9fb7d7;

    margin-top:3px;

}

/* =======================================
USUARIO
======================================= */

.user-card{

    margin-top:22px;

    background:rgba(255,255,255,.06);

    border-radius:18px;

    padding:18px;

}

.avatar{

    width:72px;

    height:72px;

    margin:auto;

    border-radius:50%;

    background:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:34px;

    color:#2563eb;

    font-weight:bold;

    border:4px solid rgba(255,255,255,.15);

}

.user-name{

    margin-top:14px;

    font-size:17px;

    font-weight:bold;

}

.user-role{

    margin-top:4px;

    font-size:13px;

    color:#9fb7d7;

}

.status{

    margin-top:12px;

    display:inline-flex;

    align-items:center;

    gap:8px;

    background:#143d28;

    color:#8ef5b1;

    padding:6px 14px;

    border-radius:30px;

    font-size:12px;

}

.status-dot{

    width:9px;

    height:9px;

    border-radius:50%;

    background:#22c55e;

    animation:pulse 1.3s infinite;

}

@keyframes pulse{

0%{

transform:scale(1);

opacity:1;

}

50%{

transform:scale(1.5);

opacity:.5;

}

100%{

transform:scale(1);

opacity:1;

}

}

</style>

<div class="sidebar">

<div>

<div class="sidebar-header">

<div class="logo">

<img
src="TU_LOGO_AQUI"
alt="DISTAN ERP">

</div>

<div class="system-name">

DISTAN ERP

</div>

<div class="system-sub">

Warehouse & Production Management

</div>

<div class="user-card">

<div class="avatar">

{{ strtoupper(substr(Auth::user()->name,0,1)) }}

</div>

<div class="user-name">

{{ Auth::user()->name }}

</div>

<div class="user-role">

{{ ucfirst(auth()->user()->role) }}

</div>

<div class="status">

<span class="status-dot"></span>

En línea

</div>

</div>

</div>

<a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
📊 Dashboard
</a>

<!-- OPERACIONES -->
<div>
<div class="menu-title" onclick="toggleMenu(this)">
📦 Operaciones
</div>

<div class="menu-sub">

@if($role == 'admin')
    <a href="/orders">📋 Órdenes</a>
    <a href="/historial">📚 Historial</a>
    <a href="/produccion">🏭 Producción</a>
@endif

@if($role == 'operario')
    <a href="/pedidos">📦 Pedidos</a>
@endif

</div>
</div>

<!-- INVENTARIO -->
<div>
<div class="menu-title" onclick="toggleMenu(this)">
📚 Inventario
</div>

<div class="menu-sub">

@if($role == 'admin')
    <a href="/categories">🏷 Categorías</a>
    <a href="/control-etiquetas">🏷️ Control de Etiquetas</a>
    <a href="/control-stickers">🏷️ Stickers de tapa</a>
    <a href="/control-precintos">🔒 Precintos</a>
@endif
    <a href="/products">📦 Productos</a>
</div>
</div>

<!-- COMERCIAL -->
<div>
<div class="menu-title" onclick="toggleMenu(this)">
🤝 Comercial
</div>

<div class="menu-sub">

@if($role == 'admin')
    <a href="/clients">👤 Clientes</a>
    <a href="/proveedores">🚚 Proveedores</a>
@endif
</div>
</div>

</div>

<div style="padding:15px;">
👤 {{ Auth::user()->name }}

<form method="POST" action="{{ route('logout') }}">
@csrf

<button style="
width:100%;
background:#dc2626;
color:white;
border:none;
padding:8px;
border-radius:6px;
">
Cerrar sesión
</button>

</form>
</div>

</div>

<script>
function toggleMenu(el){
    let sub = el.nextElementSibling;

    if(sub.style.maxHeight){
        sub.style.maxHeight = null;
    } else {
        sub.style.maxHeight = sub.scrollHeight + "px";
    }
}
</script>