@extends('layouts.app')

@section('content')

<div style="padding:20px;">

<h2>🔒 Control de Precintos</h2>

{{-- FORMULARIO --}}
<div style="background:white;padding:15px;border-radius:10px;margin-bottom:20px;">

<form method="POST" action="/inventario/store">
@csrf

<div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr;gap:10px;">

    <select name="product_id" required>
        <option value="">Producto</option>
        @foreach($products as $p)
            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
        @endforeach
    </select>

    <select name="tipo_precinto" required>
        <option value="PEQUEÑO">Pequeño</option>
        <option value="MEDIANO">Mediano</option>
        <option value="GRANDE">Grande</option>
    </select>

    <select name="color" required>
        <option value="NEGRO">Negro</option>
        <option value="VERDE">Verde</option>
        <option value="TRANSPARENTE">Transparente</option>
        <option value="BLANCO">Blanco</option>
    </select>

    <input type="text" name="zona" placeholder="Zona">

    <input type="number" name="cantidad" placeholder="Cantidad">

</div>

<button style="margin-top:10px;background:#16a34a;color:white;padding:8px;border:none;border-radius:6px;">
    Guardar
</button>

</form>

</div>

{{-- CARDS --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:15px;">

@foreach($inventories as $inv)

@php
$color = match($inv->color){
    'NEGRO' => '#000000',
    'VERDE' => '#16a34a',
    'TRANSPARENTE' => '#94a3b8',
    'BLANCO' => '#e5e7eb',
    default => '#64748b'
};
@endphp

<div style="background:white;padding:15px;border-radius:10px;border-left:5px solid {{ $color }};">

    <strong>{{ $inv->product->nombre }}</strong>

    <div style="font-size:12px;color:#64748b;">
        {{ $inv->tipo_precinto }} | {{ $inv->color }}
    </div>

    <h2 id="stock-{{ $inv->id }}">{{ $inv->stock }}</h2>

    <input type="number" id="input-{{ $inv->id }}" placeholder="Cantidad">

    <div style="display:flex;gap:5px;margin-top:5px;">
        <button onclick="entrada({{ $inv->id }})" style="flex:1;background:green;color:white;">➕</button>
        <button onclick="salida({{ $inv->id }})" style="flex:1;background:red;color:white;">➖</button>
    </div>

    <button onclick="toggleHist({{ $inv->id }})" style="margin-top:5px;width:100%;">
        📊 Historial
    </button>

    <div id="hist-{{ $inv->id }}" style="display:none;margin-top:5px;">
        @foreach($inv->movements->take(5) as $m)
            <div style="font-size:12px;">
                {{ $m->tipo }} {{ $m->cantidad }}
            </div>
        @endforeach
    </div>

</div>

@endforeach

</div>

</div>

<script>

function entrada(id){
    let cantidad = document.getElementById('input-'+id).value;

    fetch('/inventario/add/'+id,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad })
    })
    .then(r=>r.json())
    .then(d=>{
        document.getElementById('stock-'+id).innerText = d.nuevo_stock;
    });
}

function salida(id){
    let cantidad = document.getElementById('input-'+id).value;

    fetch('/inventario/salida/'+id,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad })
    })
    .then(r=>r.json())
    .then(d=>{
        if(d.success){
            document.getElementById('stock-'+id).innerText = d.nuevo_stock;
        }
    });
}

function toggleHist(id){
    let div = document.getElementById('hist-'+id);
    div.style.display = div.style.display == 'none' ? 'block' : 'none';
}

</script>

@endsection