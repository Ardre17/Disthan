@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <h2 class="mb-3">
                📦 Preparación de Pedido
            </h2>

            <div class="row">

                <div class="col-md-4">

                    <strong>Orden</strong><br>

                    {{ $order->numero_orden }}

                </div>

                <div class="col-md-4">

                    <strong>Cliente</strong><br>

                    {{ $order->client->razon_social }}

                </div>

                <div class="col-md-4">

                    <strong>Tipo</strong><br>

                    {{ $order->tipo_orden }}

                </div>

            </div>

        </div>

    </div>

    @foreach($order->details as $detail)

    <div class="card mb-3">

        <div class="card-body">

            <div class="row">

                <div class="col-md-8">

                    <h5>

                        {{ $detail->product->nombre }}

                    </h5>

                    <small>

                        SKU:
                        {{ $detail->product->sku }}

                    </small>

                </div>

                <div class="col-md-2">

                    <strong>

                        Solicitado

                    </strong>

                    <br>

                    {{ $detail->cantidad_solicitada }}

                </div>

                <div class="col-md-2 text-end">

                    <button
                        class="btn btn-success">

                        ✔ Preparado

                    </button>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>

@endsection