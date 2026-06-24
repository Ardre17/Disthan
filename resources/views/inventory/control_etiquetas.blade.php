@extends('layouts.app')

@section('content')

<div style="padding:20px;">

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

@endsection