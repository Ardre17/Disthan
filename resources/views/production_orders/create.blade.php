@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                🏭 Nueva Orden de Producción

            </h2>

            <small class="text-muted">

                Registrar una nueva producción.

            </small>

        </div>

    </div>

    @include('production_orders.form')

</div>

@endsection