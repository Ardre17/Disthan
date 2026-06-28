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
/* ==========================
   MENÚ PRINCIPAL
==========================*/

.menu-section{
    margin-top:12px;
}

.menu-title{

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:14px 22px;

    cursor:pointer;

    font-size:15px;

    font-weight:600;

    color:#dbeafe;

    transition:.25s;

}

.menu-title:hover{

    background:rgba(255,255,255,.06);

}

.menu-title span:last-child{

    transition:.3s;

    color:#7fb5ff;

}

.menu-item{

    display:flex;

    align-items:center;

    gap:12px;

    color:#dbeafe;

    text-decoration:none;

    padding:13px 22px;

    transition:.25s;

    position:relative;

}

.menu-item:hover{

    background:rgba(255,255,255,.08);

    padding-left:28px;

}

.menu-item.active{

    background:rgba(37,99,235,.20);

    color:white;

    font-weight:bold;

    border-left:4px solid #3b82f6;

}

.menu-sub{

    overflow:hidden;

    max-height:0;

    transition:max-height .35s ease;

}

.menu-sub a{

    display:flex;

    align-items:center;

    gap:10px;

    color:#a8c5eb;

    text-decoration:none;

    padding:12px 40px;

    transition:.25s;

    font-size:14px;

}

.menu-sub a:hover{

    background:rgba(255,255,255,.05);

    color:white;

    padding-left:48px;

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

<a
href="/dashboard"
class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
<span>📊</span>
<span>Dashboard</span>
</a>

<!-- OPERACIONES -->
<div class="menu-section">

<div class="menu-title"
onclick="toggleMenu(this)">
<span>📦 Operaciones</span>
<span>▾</span>
</div>

<div class="menu-sub">

@if($role == 'admin')
    <a href="/orders"> <span>📋</span> <span>Órdenes</span> </a>
    <a href="/historial"> <span>📚</span> <span>Historial</span> </a>
    <a href="/produccion"> <span>🏭</span> <span>Producción</span> </a>
@endif

@if($role == 'operario')
    <a href="/pedidos"> <span>📦</span> <span>Pedidos</span> </a>
@endif

</div>
</div>

<!-- INVENTARIO -->
<div>
<div class="menu-title"
onclick="toggleMenu(this)">
<span>📚 Inventario</span>
<span>▾</span>
</div>
<div class="menu-sub">

@if($role == 'admin')
    <a href="/categories"> <span>🏷</span> <span>Categorías</span> </a>
    <a href="/control-etiquetas"> <span>🏷️</span> <span>Control de Etiquetas</span> </a>
    <a href="/control-stickers"> <span>🏷️</span> <span>Stickers de tapa</span> </a>
    <a href="/control-precintos"> <span>🔒</span> <span>Precintos</span> </a>
@endif
    <a href="/products"> <span>📦</span> <span>Productos</span> </a>
</div>
</div>

<!-- COMERCIAL -->
<div>
<div class="menu-title"
onclick="toggleMenu(this)">
<span>🤝 Comercial</span>
<span>▾</span>
</div>
<div class="menu-sub">

@if($role == 'admin')
    <a href="/clients"> <span>👤</span> <span>Clientes</span> </a>
    <a href="/proveedores"> <span>🚚</span> <span>Proveedores</span> </a>
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

    let arrow = el.querySelector("span:last-child");

    if(sub.style.maxHeight){

        sub.style.maxHeight = null;

        arrow.style.transform="rotate(0deg)";

    }else{

        sub.style.maxHeight=sub.scrollHeight+"px";

        arrow.style.transform="rotate(180deg)";

    }

}

</script>
