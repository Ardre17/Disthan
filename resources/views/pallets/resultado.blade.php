@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4>📦 Resultado de Paletización</h4>
        </div>

        <div class="card-body">

            <pre>{{ print_r($resultado, true) }}</pre>

        </div>

    </div>

</div>

@endsection