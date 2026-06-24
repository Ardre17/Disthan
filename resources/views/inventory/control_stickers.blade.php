@extends('layouts.app')

@section('content')

<div style="padding:20px;">

<h2>🏷️ Control Stickers de Tapa</h2>

{{-- FORMULARIO --}}
<div style="background:white;padding:15px;border-radius:10px;margin-bottom:20px;">

<form method="POST" action="/inventario/store">
@csrf

<div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:10px;">

    <select name="formato_sticker" required>
    <option value="">Formato</option>
    <option value="Sticker 30 mm">Sticker 30 mm</option>
    <option value="Sticker 43 mm">Sticker 43 mm</option>
    <option value="Sticker 50 mm">Sticker 50 mm</option>
    <option value="Sticker 55 mm">Sticker 55 mm</option>
    <option value="Sticker 65 mm">Sticker 65 mm</option>
    <option value="Sticker 70 mm">Sticker 70 mm</option>
    <option value="Sticker 85 mm">Sticker 85 mm</option>
</select>

    <select name="idioma" required>
        <option value="ES">🇪🇸 Español</option>
        <option value="PT">🇧🇷 Portugués</option>
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
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px;">

@foreach($inventories as $inv)

@php
$color = $inv->idioma == 'ES' ? '#ef4444' : '#16a34a';
@endphp

<div style="background:white;padding:15px;border-radius:10px;border-left:5px solid {{ $color }};">

    <strong>{{ $inv->product->nombre }}</strong>

    <div>
        {{ $inv->idioma == 'ES' ? '🇪🇸 Español' : '🇧🇷 Portugués' }}
    </div>

    <h2 id="stock-{{ $inv->id }}">{{ $inv->stock }}</h2>

    <input type="number" id="input-{{ $inv->id }}" placeholder="Cantidad">

    <div style="display:flex;gap:5px;margin-top:5px;">
        <button onclick="entrada({{ $inv->id }})" style="flex:1;background:green;color:white;">➕</button>
        <button onclick="salida({{ $inv->id }})" style="flex:1;background:red;color:white;">➖</button>
    </div>

    <button onclick="toggleHist({{ $inv->id }})" style="margin-top:5px;width:100%;">
        Historial
    </button>

    <div id="hist-{{ $inv->id }}" style="display:none;margin-top:5px;">
        @foreach($inv->movements->take(5) as $m)
            <div>
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