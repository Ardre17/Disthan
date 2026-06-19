@extends('layouts.app')

@section('content')
<a href="{{ route('users.create') }}" style="
    background:#16a34a;
    color:white;
    padding:10px;
    border-radius:8px;
    text-decoration:none;
">
    + Usuario
</a>
<h1 style="font-size:26px;font-weight:bold;margin-bottom:20px;">
👤 Usuarios del Sistema
</h1>

<div style="
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:20px;
">


@foreach($users as $user)

<div style="
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    position:relative;
">

    <!-- ROL -->
    <div style="
        position:absolute;
        top:15px;
        right:15px;
        background:#2563eb;
        color:white;
        padding:5px 10px;
        border-radius:20px;
        font-size:12px;
    ">
        {{ $user->role ?? 'USER' }}
    </div>

    <!-- NOMBRE -->
    <h3 style="font-size:18px;font-weight:bold;">
        {{ $user->name }}
    </h3>

    <!-- EMAIL -->
    <p style="color:#64748b;font-size:14px;">
        {{ $user->email }}
    </p>

    <!-- FECHA -->
    <p style="font-size:12px;color:#9ca3af;margin-top:10px;">
        Registrado: {{ $user->created_at->format('d/m/Y') }}
    </p>

    <!-- BOTONES -->
   <div style="display:flex;gap:10px;margin-top:15px;">

    <a href="{{ route('users.edit',$user) }}" style="
        flex:1;
        text-align:center;
        background:#f59e0b;
        color:white;
        padding:8px;
        border-radius:8px;
        text-decoration:none;
    ">
        ✏️ Editar
    </a>

    <form method="POST" action="{{ route('users.destroy',$user) }}"
        onsubmit="return confirm('¿Eliminar usuario?')"
        style="flex:1;">
        @csrf
        @method('DELETE')

        <button style="
            width:100%;
            background:#dc2626;
            color:white;
            padding:8px;
            border:none;
            border-radius:8px;
        ">
            🗑 Eliminar
        </button>
    </form>

</div>

</div>

@endforeach

</div>

@endsection