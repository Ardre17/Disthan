@extends('layouts.app')

@section('content')

<h2 style="font-size:22px;font-weight:bold;margin-bottom:15px;">
✏️ Editar Usuario
</h2>

<form method="POST" action="{{ route('users.update',$user) }}">
@csrf
@method('PUT')

<div style="background:white;padding:20px;border-radius:10px;max-width:400px;">

    <label>Nombre</label>
    <input name="name" value="{{ $user->name }}" 
        style="width:100%;padding:8px;margin-bottom:10px;">

    <label>Email</label>
    <input name="email" value="{{ $user->email }}" 
        style="width:100%;padding:8px;margin-bottom:10px;">

    <label>Rol</label>
    <select name="role" style="width:100%;padding:8px;margin-bottom:15px;">
        <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
        <option value="operario" {{ $user->role=='operario'?'selected':'' }}>Operario</option>
    </select>

    <button style="
        width:100%;
        background:#2563eb;
        color:white;
        padding:10px;
        border:none;
        border-radius:8px;
    ">
        Actualizar
    </button>

</div>

</form>

@endsection