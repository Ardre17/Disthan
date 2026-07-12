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

    background:linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.04));

    border-radius:18px;

    padding:18px;
    border:1px solid rgba(255,255,255,.08);
backdrop-filter:blur(15px);
}
.avatar{
width:84px;
height:84px;
margin:auto;
border-radius:50%;
background:linear-gradient(135deg,#2563eb,#60a5fa);
display:flex;
justify-content:center;
align-items:center;
font-size:34px;
font-weight:bold;
color:white;
box-shadow:
0 8px 20px rgba(37,99,235,.35);
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

    background:rgba(255,255,255,.08);

    color:white;

    font-weight:600;

    border-left:5px solid var(--accent,#3b82f6);

    box-shadow:inset 0 0 25px rgba(59,130,246,.15);

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
    /*==========================
FOOTER
==========================*/

.sidebar-footer{

padding:20px;

border-top:1px solid rgba(255,255,255,.08);

}

.storage-card{

background:rgba(255,255,255,.05);

padding:14px;

border-radius:14px;

margin-bottom:18px;

}

.storage-title{

font-size:13px;

margin-bottom:10px;

color:#dbeafe;

}

.storage-bar{

height:9px;

background:#1e3a5f;

border-radius:20px;

overflow:hidden;

}

.storage-fill{

height:100%;

width:82%;

background:linear-gradient(90deg,#22c55e,#3b82f6);

border-radius:20px;

}

.storage-text{

margin-top:8px;

font-size:12px;

color:#9fb7d7;

}

.clock-card{

text-align:center;

margin-bottom:18px;

}

#clockTime{

font-size:28px;

font-weight:bold;

letter-spacing:2px;

}

#clockDate{

margin-top:6px;

font-size:13px;

color:#9fb7d7;

}

.version{

text-align:center;

font-size:13px;

margin-bottom:18px;

color:#dbeafe;

}

.version span{

font-size:11px;

color:#8ea8c8;

}

.logout-btn{

width:100%;

padding:12px;

border:none;

border-radius:12px;

background:linear-gradient(90deg,#dc2626,#ef4444);

color:white;

font-weight:bold;

cursor:pointer;

transition:.25s;

}

.logout-btn:hover{

transform:translateY(-2px);

box-shadow:0 10px 20px rgba(239,68,68,.25);

}
:root{

--dashboard:#3b82f6;

--inventario:#22c55e;

--operaciones:#f59e0b;

--comercial:#8b5cf6;

}

.dashboard-active{

--accent:var(--dashboard);

}

.operaciones-active{

--accent:var(--operaciones);

}

.inventario-active{

--accent:var(--inventario);

}

.comercial-active{

--accent:var(--comercial);

}
.menu-item span:first-child,
.menu-sub span:first-child{

font-size:18px;

width:26px;

text-align:center;

}
.menu-section{

margin-top:8px;

margin-bottom:8px;

}
</style>

<div class="sidebar">
<div>

<div class="sidebar-header">
<div class="logo">
<img alt="DISTAN ERP">
</div>
<div class="system-sub"> Warehouse & Production Management </div>

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

<a href="/dashboard" class="menu-item dashboard-active {{ request()->is('dashboard') ? 'active' : '' }}">
<span>📊</span>
<span>Dashboard</span>
</a>

{{-- DESPUÉS del menu-item de Dashboard --}}
{{-- OPERACIONES --}}
<div class="menu-section operaciones-active">
    <div class="menu-title" onclick="toggleMenu(this)">
        <span>🏚️ Almacenes</span>
        <span>▾</span>
    </div>
    <div class="menu-sub">
        @if($role == 'admin')
            <a href="{{ route('joselito.index') }}">
                <span>🏚️</span><span>Joselito</span>
            </a>
            <a href="{{ route('dalsa.index') }}"><span>🏭</span><span>Dalsa</span></a>
        @endif
        
    </div>

</div>  {{-- ← cierra menu-section operaciones --}}
{{-- OPERACIONES --}}
<div class="menu-section operaciones-active">
    <div class="menu-title" onclick="toggleMenu(this)">
        <span>📦 Operaciones</span>
        <span>▾</span>
    </div>
    <div class="menu-sub">
        @if($role == 'admin')
            <a href="/orders"><span>📋</span><span>Órdenes</span></a>
            <a href="/historial"><span>📚</span><span>Historial</span></a>
            <a href="{{ route('raw-materials.index') }}"><span>📦</span><span>Materia Prima</span> </a>
            <a href="{{ route('products.proyectado') }}"><span>📊</span><span>Proyectado</span></a>
            <a href="{{ route('kardex.index') }}"><span>📒</span><span>Kardex</span></a>
        @endif
        <a href="{{ route('production-orders.index') }}"><span>🏭</span><span>Producción</span></a>
        @if($role == 'operario')
            <a href="/pedidos"><span>📦</span><span>Pedidos</span></a>
        @endif
    </div>
</div>  {{-- ← cierra menu-section operaciones --}}

{{-- INVENTARIO --}}
<div class="menu-section inventario-active">
    <div class="menu-title" onclick="toggleMenu(this)">
        <span>📚 Inventario</span>
        <span>▾</span>
    </div>
    <div class="menu-sub">
        @if($role == 'admin')
            <a href="/categories"><span>🏷</span><span>Categorías</span></a>
            <a href="{{ route('labels.index') }}"><span>📒</span><span>Control de Etiquetas</span></a>
            <a href="{{ route('stickers.index') }}"><span>🏷️</span><span>Stickers de tapa</span></a>
            <a href="{{ route('precintos.index') }}"><span>🔒</span><span>Precintos</span></a>
        @endif
        <a href="{{ route('cajas.index') }}"><span>📦</span><span>Cajas</span></a>
        <a href="/products"><span>📦</span><span>Productos</span></a>
        <a href="{{ route('warehouse.index') }}"><span>🗺️</span><span>Mapa del Almacén</span></a>

    </div>
</div>  {{-- ← cierra menu-section inventario --}}

{{-- COMERCIAL --}}
<div class="menu-section comercial-active">
    <div class="menu-title" onclick="toggleMenu(this)">
        <span>🤝 Comercial</span>
        <span>▾</span>
    </div>
    <div class="menu-sub">
        @if($role == 'admin')
            <a href="/clients"><span>👤</span><span>Clientes</span></a>
            <a href="/proveedores"><span>🚚</span><span>Proveedores</span></a>
        @endif
    </div>
</div>  {{-- ← cierra menu-section comercial --}}

</div>  {{-- ← cierra el <div> wrapper superior (el que va justo después de <div class="sidebar">) --}}

<div class="sidebar-footer">

<div class="storage-card">

<div class="storage-title">

📦 Capacidad del almacén

</div>

<div class="storage-bar">

<div class="storage-fill" id="storageFill"></div>

</div>

<div class="storage-text">

82% utilizado

</div>

</div>

<div class="clock-card">

<div id="clockTime">

00:00:00

</div>

<div id="clockDate">

--

</div>

</div>

<div class="version">

DISTAN ERP

<br>

<span>Versión 1.0.0</span>

</div>

<form method="POST"
action="{{ route('logout') }}">

@csrf

<button class="logout-btn">

🚪 Cerrar sesión

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
//==========================
// RELOJ
//==========================

function actualizarReloj(){

const ahora=new Date();

document.getElementById("clockTime").innerHTML=
ahora.toLocaleTimeString();

document.getElementById("clockDate").innerHTML=
ahora.toLocaleDateString(
'es-PE',
{
weekday:'long',
day:'numeric',
month:'long'
}
);

}

setInterval(actualizarReloj,1000);

actualizarReloj();
</script>
