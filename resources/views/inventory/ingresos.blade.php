@extends('layouts.app')

@section('content')

<div style="padding:20px;">

<h2>📦 Ingresos a Almacén</h2>

{{-- FORMULARIO --}}
<div style="background:white;padding:15px;border-radius:10px;margin-bottom:20px;">
    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf

        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 2fr auto;gap:10px;align-items:end;">

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
                <label>Cantidad</label>
                <input type="number" name="cantidad" class="finput" required>
            </div>

            <div>
                <label>País</label>
                <input type="text" name="pais" class="finput">
            </div>

            <div>
                <label>Motivo</label>
                <input type="text" name="motivo" class="finput" placeholder="Producción / Compra / Ajuste">
            </div>

            <button class="btn btn-green">➕ Registrar</button>

        </div>
    </form>
</div>

{{-- HISTORIAL --}}
<div style="background:white;padding:15px;border-radius:10px;">
    <h3>📊 Historial de ingresos</h3>

    <table style="width:100%;border-collapse:collapse;margin-top:10px;">
        <thead style="background:#f1f5f9;">
            <tr>
                <th style="padding:8px;">Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>País</th>
                <th>Motivo</th>
            </tr>
        </thead>

        <tbody>
            @foreach($movements as $m)
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:8px;">{{ $m->created_at }}</td>
                <td>{{ $m->product->nombre }}</td>
                <td style="color:green;font-weight:bold;">+{{ $m->cantidad }}</td>
                <td>{{ $m->pais }}</td>
                <td>{{ $m->motivo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</div>

@endsection