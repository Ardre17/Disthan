@extends('layouts.app')

@section('content')

<style>

:root{

    --primary:#2563eb;
    --primary-dark:#1d4ed8;

    --success:#16a34a;
    --danger:#dc2626;
    --warning:#d97706;

    --bg:#f3f6fb;

    --card:#ffffff;

    --border:#dbe4ee;

    --text:#1e293b;

    --muted:#64748b;

}

*{
    box-sizing:border-box;
}

body{

    background:var(--bg);

}

.preparation-container{

    max-width:900px;

    margin:30px auto;

    padding:20px;

}

.preparation-header{

    background:white;

    border:1px solid var(--border);

    border-radius:14px;

    padding:25px;

    box-shadow:0 10px 25px rgba(0,0,0,.05);

    margin-bottom:20px;

}

.preparation-title{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}

.preparation-title h2{

    margin:0;

    color:var(--text);

    font-size:28px;

    font-weight:700;

}

.order-number{

    background:var(--primary);

    color:white;

    padding:8px 16px;

    border-radius:30px;

    font-weight:700;

    letter-spacing:1px;

}

.info-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:20px;

}

.info-box{

    background:#f8fafc;

    border-radius:10px;

    padding:15px;

    border:1px solid var(--border);

}

.info-box small{

    display:block;

    color:var(--muted);

    text-transform:uppercase;

    font-size:11px;

    margin-bottom:5px;

}

.info-box strong{

    font-size:18px;

    color:var(--text);

}

.progress-card{

    margin-top:25px;

}

.progress{

    height:18px;

    background:#e5e7eb;

    border-radius:30px;

    overflow:hidden;

}

.progress-bar{

    height:100%;

    background:linear-gradient(90deg,#16a34a,#22c55e);

    width:{{ $progreso }}%;

    transition:.4s;

}

.progress-info{

    display:flex;

    justify-content:space-between;

    margin-top:10px;

    font-weight:600;

    color:var(--muted);

}

.product-card{

    background:white;

    border-radius:14px;

    border:1px solid var(--border);

    padding:30px;

    box-shadow:0 10px 25px rgba(0,0,0,.05);

}

</style>

<div class="preparation-container">

<div class="preparation-header">

<div class="preparation-title">

<h2>

📦 Preparación de Pedido

</h2>

<div class="order-number">

{{ $order->numero_orden }}

</div>

</div>

<div class="info-grid">

<div class="info-box">

<small>Cliente</small>

<strong>

{{ $order->client->razon_social }}

</strong>

</div>

<div class="info-box">

<small>Tipo</small>

<strong>

{{ $order->tipo_orden }}

</strong>

</div>

<div class="info-box">

<small>Estado</small>

<strong>

{{ $order->estado_preparacion }}

</strong>

</div>

</div>

<div class="progress-card">

<div class="progress">

<div class="progress-bar"></div>

</div>

<div class="progress-info">

<div>

{{ $preparados }} de {{ $total }} productos preparados

</div>

<div>

{{ $progreso }}%

</div>

</div>

</div>

</div>

<div class="product-card">