@extends('layouts.app')

@section('content')

<style>

.form-card{
    max-width:800px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.title{
    font-size:28px;
    font-weight:bold;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    font-weight:bold;
    margin-bottom:8px;
}

input,
textarea,
select{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
}

.actions{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.btn-save{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}

.btn-back{
    background:#64748b;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:8px;
}

</style>

<div style="padding:30px;">

    <div class="form-card">

        <div class="title">
            ✏️ Editar Categoría
        </div>

        <form method="POST"
              action="{{ route('categories.update',$category) }}">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre</label>
                <input type="text"
                       name="nombre"
                       value="{{ $category->nombre }}"
                       required>
            </div>

            <div class="form-group">
                <label>Color</label>
                <input type="color"
                       name="color"
                       value="{{ $category->color }}">
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea
                    rows="4"
                    name="descripcion">{{ $category->descripcion }}</textarea>
            </div>

            <div class="form-group">

                <label>

                    <input type="checkbox"
                           name="activo"
                           {{ $category->activo ? 'checked' : '' }}>

                    Categoría Activa

                </label>

            </div>

            <div class="actions">

                <a href="{{ route('categories.index') }}"
                   class="btn-back">
                    Volver
                </a>

                <button type="submit"
                        class="btn-save">
                    Actualizar Categoría
                </button>

            </div>

        </form>

    </div>

</div>

@endsection