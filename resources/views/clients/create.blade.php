@extends('layouts.app')

@section('content')

<div style="padding:30px;">

    <div style="
        background:white;
        padding:25px;
        border-radius:10px;
        max-width:900px;
        box-shadow:0 2px 8px rgba(0,0,0,.1);
    ">

        <h1 style="margin-bottom:20px;">
            👥 Nuevo Cliente
        </h1>

        <form action="{{ route('clients.store') }}"
              method="POST">

            @csrf

            <div style="margin-bottom:15px;">
                <label>RUC</label>
                <input type="text"
                       name="ruc"
                       required
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Razón Social</label>
                <input type="text"
                       name="razon_social"
                       required
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Nombre Comercial</label>
                <input type="text"
                       name="nombre_comercial"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Contacto</label>
                <input type="text"
                       name="contacto"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Teléfono</label>
                <input type="text"
                       name="telefono"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Correo</label>
                <input type="email"
                       name="correo"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Dirección</label>
                <input type="text"
                       name="direccion"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Distrito</label>
                <input type="text"
                       name="distrito"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Ciudad</label>
                <input type="text"
                       name="ciudad"
                       value="Lima"
                       style="width:100%;padding:10px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Observaciones</label>
                <textarea
                    name="observaciones"
                    style="width:100%;height:100px;"></textarea>
            </div>

            <button type="submit"
                    style="
                        background:#2563eb;
                        color:white;
                        border:none;
                        padding:12px 25px;
                        border-radius:8px;
                        cursor:pointer;
                    ">
                Guardar Cliente
            </button>

        </form>

    </div>

</div>

@endsection