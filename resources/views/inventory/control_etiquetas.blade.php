@extends('layouts.app')

@section('content')

<div style="background:white;padding:15px;border-radius:10px;margin-bottom:20px;">

<h3>➕ Registrar nueva etiqueta</h3>

<form method="POST" action="/inventario/store">
@csrf

<div style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:10px;align-items:end;">

    <div>
        <label>Producto</label>
        <select name="product_id" class="finput" required>
            <option value="">Seleccionar</option>
            @foreach($products as $p)
                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Idioma</label>
        <select name="idioma" class="finput" required>
            <option value="ES">Español</option>
            <option value="EN">Inglés</option>
            <option value="PT">Portugués</option>
        </select>
    </div>

    <div>
        <label>Zona</label>
        <select name="zona" class="finput" required>
            <option value="Santa Luzia">Santa Luzia</option>
            <option value="Zona Zul">Zona Zul</option>
        </select>
    </div>

    <div>
        <label>Cantidad inicial</label>
        <input type="number" name="cantidad" class="finput" required>
    </div>

</div>

<button style="margin-top:10px;background:#16a34a;color:white;padding:8px 15px;border:none;border-radius:6px;">
    Guardar etiqueta
</button>

</form>

</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:15px;">

@foreach($inventories as $inv)
@php
    $colorIdioma = match($inv->idioma) {
        'ES' => '#ef4444', // rojo
        'EN' => '#2563eb', // azul
        'PT' => '#16a34a', // verde
        default => '#64748b'
    };
@endphp
<div style="
background:white;
border-radius:12px;
padding:15px;
border-left:5px solid
{{ $inv->stock == 0 ? '#ef4444' : ($inv->stock < 20 ? '#f59e0b' : '#22c55e') }};
box-shadow:0 2px 6px rgba(0,0,0,0.05);
">

    <div style="font-weight:bold;font-size:14px;">
        📦 {{ $inv->product->nombre }}
    </div>

    <div style="font-size:12px;color:#64748b;margin-bottom:10px;">
        🌎 🌎 {{ $inv->idioma }} | {{ $inv->zona }}
    </div>

    <div id="stock-{{ $inv->id }}" style="font-size:28px;font-weight:bold;
        color:{{ $inv->stock == 0 ? '#b91c1c' : ($inv->stock < 20 ? '#b45309' : '#15803d') }};
    ">
        {{ $inv->stock }}
    </div>

    <div style="font-size:11px;color:#94a3b8;margin-bottom:10px;">
        etiquetas disponibles
    </div>

    {{-- INPUT --}}
    <input type="number" id="input-{{ $inv->id }}" placeholder="Cantidad"
        style="width:100%;padding:6px;border:1px solid #ddd;border-radius:6px;margin-bottom:8px;">

    {{-- BOTONES --}}
    <div style="display:flex;gap:5px;margin-bottom:8px;">
        <button onclick="entrada({{ $inv->id }})"
            style="flex:1;background:#16a34a;color:white;border:none;padding:6px;border-radius:6px;">
            ➕
        </button>

        <button onclick="salida({{ $inv->id }})"
            style="flex:1;background:#dc2626;color:white;border:none;padding:6px;border-radius:6px;">
            ➖
        </button>
    </div>

    <button onclick="abrirHistorial({{ $inv->id }})"
        style="width:100%;background:#2563eb;color:white;border:none;padding:6px;border-radius:6px;">
        📊 Historial
    </button>

    {{-- HISTORIAL --}}
    <div id="historial-{{ $inv->id }}" style="margin-top:10px;display:none;">
        @foreach($inv->movements->take(5) as $m)
            <div style="font-size:11px;display:flex;justify-content:space-between;">
                <span>{{ $m->motivo }}</span>
                <span style="color:{{ $m->tipo=='ENTRADA'?'green':'red' }}">
                    {{ $m->tipo=='ENTRADA' ? '+' : '-' }}{{ $m->cantidad }}
                </span>
            </div>
        @endforeach
    </div>

</div>

@endforeach

</div>

<h2>🏷️ Control de Etiquetas</h2>

{{-- FORMULARIO --}}
<div style="background:white;padding:15px;border-radius:10px;margin-bottom:20px;">
    <form id="formMovimiento">
        @csrf

        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 2fr auto;gap:10px;align-items:end;">

            <div>
                <label>Producto</label>
                <select id="product_id" class="finput">
                    <option value="">Seleccionar</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Cantidad</label>
                <input type="number" id="cantidad" class="finput">
            </div>

            <div>
                <label>Tipo</label>
                <select id="tipo" class="finput">
                    <option value="ENTRADA">Entrada</option>
                    <option value="SALIDA">Salida</option>
                </select>
            </div>

            <div>
                <label>Motivo</label>
                <input type="text" id="motivo" class="finput" placeholder="Producción / Uso / Ajuste">
            </div>

            <button type="button" onclick="guardarMovimiento()" class="btn btn-green">
                Guardar
            </button>

        </div>
    </form>
</div>

{{-- HISTORIAL --}}
<div style="background:white;padding:15px;border-radius:10px;">
    <h3>📊 Historial</h3>

    <table style="width:100%;border-collapse:collapse;margin-top:10px;">
        <thead style="background:#f1f5f9;">
            <tr>
                <th style="padding:8px;">Fecha</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Motivo</th>
            </tr>
        </thead>

        <tbody id="tablaHistorial">
            @foreach($movements as $m)
            <tr style="border-bottom:1px solid #eee;">
                <td>{{ $m->created_at }}</td>
                <td>{{ $m->product->nombre }}</td>
                <td style="color:{{ $m->tipo == 'ENTRADA' ? 'green' : 'red' }}">
                    {{ $m->tipo }}
                </td>
                <td>{{ $m->tipo == 'ENTRADA' ? '+' : '-' }}{{ $m->cantidad }}</td>
                <td>{{ $m->motivo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</div>

<script>

function guardarMovimiento() {

    let data = {
        product_id: document.getElementById('product_id').value,
        cantidad: document.getElementById('cantidad').value,
        tipo: document.getElementById('tipo').value,
        motivo: document.getElementById('motivo').value,
        _token: '{{ csrf_token() }}'
    };

    fetch('/control-etiquetas/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(() => {
        alert('Movimiento registrado');
        location.reload();
    })
    .catch(() => alert('Error'));
}

</script>
<script>
function abrirHistorial(id){
    let div = document.getElementById('historial-' + id);

    if(div.style.display === 'none'){
        div.style.display = 'block';
    }else{
        div.style.display = 'none';
    }
}
</script>
<script>

function getCantidad(id){
    return parseInt(document.getElementById('input-' + id).value);
}

function entrada(id){
    let cantidad = getCantidad(id);

    if(!cantidad || cantidad <= 0){
        alert('Cantidad inválida');
        return;
    }

    fetch('/inventario/add/' + id, {
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad })
    })
    .then(res=>res.json())
    .then(()=>{
        actualizarStock(id, cantidad);
    });
}

function salida(id){
    let cantidad = getCantidad(id);

    if(!cantidad || cantidad <= 0){
        alert('Cantidad inválida');
        return;
    }

    fetch('/inventario/salida/' + id, {
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad })
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success){
            actualizarStock(id, -cantidad);
        }else{
            alert(data.message || 'Error');
        }
    });
}

function actualizarStock(id, cambio){
    let el = document.getElementById('stock-' + id);
    let actual = parseInt(el.innerText);

    el.innerText = actual + cambio;

    document.getElementById('input-' + id).value = '';
}

function abrirHistorial(id){
    let div = document.getElementById('historial-' + id);
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
}

</script>
@endsection