@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Preparación de Pedidos</h2>

        <span>
            Total:
            <strong>{{ $orders->count() }}</strong>
        </span>
    </div>

    <table class="table table-hover align-middle">

        <thead>

            <tr>
                <th>Orden</th>
                <th>Cliente</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th></th>
            </tr>

        </thead>

        <tbody>

        @forelse($orders as $order)

            <tr>

                <td>
                    {{ $order->numero_orden }}
                </td>

                <td>
                    {{ $order->client->razon_social }}
                </td>

                <td>
                    {{ $order->tipo_orden }}
                </td>

                <td>
                    {{ $order->estado }}
                </td>

                <td width="170">

                    <a
                        href="{{ route('preparation.show',$order) }}"
                        class="btn btn-success w-100">

                        📦 Preparar

                    </a>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5">

                    No existen pedidos pendientes.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection