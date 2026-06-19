@extends('layouts.app')

@section('content')

<h2>➕ Crear Usuario</h2>

<form method="POST" action="{{ route('users.store') }}">
@csrf

<input name="name" placeholder="Nombre" required><br><br>
<input name="email" placeholder="Email" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>

<select name="role">
    <option value="admin">Admin</option>
    <option value="operario">Operario</option>
</select><br><br>

<button>Guardar</button>

</form>

@endsection