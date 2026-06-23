@extends('layouts.app')

@section('content')

<div style="padding:20px; max-width:600px; margin:auto;">

    <h2>✏️ Editar Cliente</h2>

    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:10px;">
            <label>RUC</label>
            <input type="text" name="ruc" value="{{ $client->ruc }}" class="finput" required>
        </div>

        <div style="margin-bottom:10px;">
            <label>Razón Social</label>
            <input type="text" name="razon_social" value="{{ $client->razon_social }}" class="finput" required>
        </div>

        <div style="margin-bottom:10px;">
            <label>Nombre Comercial</label>
            <input type="text" name="nombre_comercial" value="{{ $client->nombre_comercial }}" class="finput">
        </div>

        <div style="margin-bottom:10px;">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ $client->telefono }}" class="finput">
        </div>

        <div style="margin-bottom:10px;">
            <label>Correo</label>
            <input type="email" name="correo" value="{{ $client->correo }}" class="finput">
        </div>

        <div style="margin-bottom:10px;">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ $client->direccion }}" class="finput">
        </div>

        <div style="margin-bottom:10px;">
            <label>Activo</label>
            <select name="activo" class="finput">
                <option value="1" {{ $client->activo ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ !$client->activo ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-blue">💾 Actualizar</button>

    </form>

</div>

@endsection