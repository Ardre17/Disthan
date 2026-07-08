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

    @if($productoActual)

<div class="card shadow-lg border-0">

    <div class="card-body p-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="mb-0">
                Producto {{ $numeroProducto }} de {{ $total }}
            </h4>

            <span class="badge bg-primary fs-6">
                {{ $progreso }}%
            </span>

        </div>

        <div class="progress mb-4" style="height:12px;">
            <div class="progress-bar bg-success"
                style="width: {{ $progreso }}%">
            </div>
        </div>

        <div class="text-center mb-4">

            <div class="text-muted mb-2">
                SKU {{ $productoActual->product->sku }}
            </div>

            <h1 class="fw-bold">
                {{ $productoActual->product->nombre }}
            </h1>

        </div>

        @if(!empty($productoActual->product->advertencias))

            <div class="alert alert-warning text-center">

                <strong>

                    {{ $productoActual->product->advertencias }}

                </strong>

            </div>

        @endif

        <div class="row text-center mt-4">

            <div class="col-md-4">

                <h6>Solicitado</h6>

                <h2>

                    {{ $productoActual->cantidad_solicitada }}

                </h2>

            </div>

            <div class="col-md-4">

                <h6>Preparado</h6>

                <input
                    id="cantidad_preparada"
                    type="number"
                    class="form-control form-control-lg text-center"
                    value="{{ $productoActual->cantidad_solicitada }}">

            </div>

            <div class="col-md-4">

                <h6>Precio</h6>

                <h2>

                    S/

                    {{ number_format($productoActual->precio_unitario,2) }}

                </h2>

            </div>

        </div>

        <div class="d-grid gap-3 mt-5">

            <button
                id="btnPreparado"
                class="btn btn-success btn-lg">

                ✔ PRODUCTO PREPARADO

            </button>

            <button
                id="btnNoEncontrado"
                class="btn btn-danger btn-lg">

                ❌ NO ENCONTRADO

            </button>

            <button
                id="btnSaltar"
                class="btn btn-warning btn-lg">

                ⏭ SALTAR

            </button>

        </div>

    </div>

</div>

@else

<div class="alert alert-success text-center">

    <h3>

        🎉 Pedido armado correctamente

    </h3>

    <p>

        Todos los productos fueron preparados.

    </p>

</div>

@endif

</div>

@endsection
<script>

document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("btnPreparado");

    if (!btn) return;

    btn.addEventListener("click", function () {

        btn.disabled = true;
        btn.innerHTML = "Guardando...";

        fetch("{{ route('preparation.save', $productoActual->id) }}", {

            method: "POST",

            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },

            body: JSON.stringify({
                cantidad_preparada: document.getElementById("cantidad_preparada").value,
                observacion: ""
            })

        })
        .then(async response => {

            console.log("STATUS:", response.status);

            const text = await response.text();

            console.log("RESPUESTA:", text);

            return text;

        })
        .catch(error => {

            console.error(error);

            alert("Error de conexión.");

        });

    });

});

</script>