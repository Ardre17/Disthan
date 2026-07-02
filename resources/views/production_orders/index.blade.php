@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                🏭 Órdenes de Producción

            </h2>

        </div>

        <a
        href="{{ route('production-orders.create') }}"
        class="btn btn-primary">

            Nueva Producción

        </a>

    </div>

    <div class="row">

        @forelse($orders as $order)

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>

                        {{ $order->number }}

                    </h5>

                    <hr>

                    <p>

                        <strong>Producto</strong>

                        <br>

                        {{ $order->product->name }}

                    </p>

                    <p>

                        <strong>Materia Prima</strong>

                        <br>

                        {{ $order->rawMaterial->name }}

                    </p>

                    <p>

                        <strong>Estado</strong>

                        <br>

                        {{ $order->status }}

                    </p>

                </div>

                <div class="card-footer bg-white">

                    <a
                    href="{{ route('production-orders.show',$order) }}"
                    class="btn btn-success btn-sm">

                        Abrir

                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info">

                No existen órdenes de producción.

            </div>

        </div>

        @endforelse

    </div>

</div>

@endsection