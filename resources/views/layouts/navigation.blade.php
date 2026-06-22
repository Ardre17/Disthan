<style>

.sidebar {

width:260px;

height:100vh;

position:fixed;

top:0;

left:0;

background:#0f172a;

color:white;

display:flex;

flex-direction:column;

justify-content:space-between;

}


.logo {

padding:20px;

font-weight:bold;

}


.menu-item, .menu-sub a {

display:block;

padding:10px 18px;

color:white;

text-decoration:none;

}


.menu-item:hover, .menu-sub a:hover {

background:#1e293b;

}


.menu-item.active {

background:#2563eb;

}


.menu-title {

padding:10px 18px;

cursor:pointer;

font-weight:bold;

}


.menu-sub {

max-height:0;

overflow:hidden;

transition:0.3s;

}


.menu-sub a {

padding-left:30px;

font-size:14px;

}

</style>


<div class="sidebar">


<div>


<div class="logo">

🚀 DISTAN

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

<a href="/orders">Órdenes</a>

<a href="/pedidos">Pedidos</a>

<a href="/historial">📚 Historial</a>

<a href="/produccion">Producción</a>

</div>

</div>


<!-- INVENTARIO -->

<div>

<div class="menu-title" onclick="toggleMenu(this)">

📚 Inventario

</div>


<div class="menu-sub">

<a href="/products">Productos</a>

<a href="/categories">Categorías</a>

<a href="/inventario">Inventario</a>

</div>

</div>


<!-- COMERCIAL -->

<div>

<div class="menu-title" onclick="toggleMenu(this)">

🤝 Comercial

</div>


<div class="menu-sub">

<a href="/clients">Clientes</a>

<a href="/proveedores">Proveedores</a>

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

