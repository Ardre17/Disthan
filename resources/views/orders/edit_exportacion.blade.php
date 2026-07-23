<h2>🚢 Exportación</h2>

<hr>

<h4>Orden: {{ $order->numero_orden }}</h4>

<p>
    <strong>Cliente:</strong>
    {{ $order->client->razon_social }}
</p>

<p>
    <strong>Fecha:</strong>
    {{ $order->fecha_pedido }}
</p>

<p>
    <strong>Estado:</strong>
    {{ $order->estado }}
</p>

<hr>
<h3>Agregar producto</h3>

<form method="POST"
      action="{{ route('orders.addProduct',$order) }}">

    @csrf

    <p>

        Producto

        <select
            name="product_id"
            required>

            <option value="">
                Seleccionar
            </option>

            @foreach($products as $product)

                <option value="{{ $product->id }}">

                    {{ $product->nombre }}

                </option>

            @endforeach

        </select>

    </p>

    <p>

        Cantidad

        <input
            type="number"
            name="cantidad_solicitada"
            required>

    </p>

    <p>

        Precio

        <input
            type="number"
            step="0.01"
            name="precio_unitario"
            required>

    </p>

    <button>

        Agregar

    </button>

</form>

<hr>
<h3>Productos</h3>

<table border="1" cellpadding="5">

<thead>

<tr>

<th>Producto</th>

<th>Solicitado</th>

<th>Despachado</th>

<th>Peso</th>

<th>Subtotal</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

@foreach($order->details as $item)

<tr>

<td>

{{ $item->product->nombre }}

</td>

<td>

{{ $item->cantidad_solicitada }}

</td>

<td>

{{ $item->cantidad_despachada }}

</td>

<td>

{{ number_format(($item->product->peso ?? 0)/1000,3) }} kg

</td>

<td>

S/

{{ number_format($item->subtotal,2) }}

</td>

<td>

Editar

Eliminar

</td>

</tr>

@endforeach

</tbody>

</table>
<hr>

<h3>Resumen</h3>

<p>

Productos:

{{ $order->details->count() }}

</p>

<p>

Subtotal:

S/

{{ number_format($order->subtotal,2) }}

</p>

<p>

IGV:

S/

{{ number_format($order->igv,2) }}

</p>

<p>

Total:

S/

{{ number_format($order->total,2) }}

</p>
<hr>

<a
    href="{{ route('orders.pdf',$order) }}"
    target="_blank">

    Ver PDF

</a>

@if($order->estado!='COMPLETO')

<form
    method="POST"
    action="{{ route('orders.cerrar',$order) }}">

    @csrf

    <button>

        Cerrar Exportación

    </button>

</form>

@endif
<hr>

<h3>🟫 Pallets</h3>

<button type="button">

    ➕ Crear Pallet

</button>

<br><br>

@if($order->pallets->count())

    @foreach($order->pallets as $pallet)

        <fieldset style="margin-bottom:20px;">

            <legend>

                <strong>

                    {{ $pallet->nombre }}

                </strong>

            </legend>

            <table border="1" cellpadding="5" width="100%">

                <thead>

                    <tr>

                        <th>Producto</th>

                        <th>Cantidad</th>

                        <th>Peso</th>

                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pallet->detalles as $detalle)

                        <tr>

                            <td>

                                {{ $detalle->product->nombre }}

                            </td>

                            <td>

                                {{ $detalle->cantidad }}

                            </td>

                            <td>

                                {{ number_format(($detalle->product->peso * $detalle->cantidad)/1000,2) }} kg

                            </td>

                            <td>

                                Quitar

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                Este pallet aún no tiene productos.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <br>

            <form>

                <select>

                    <option>

                        Agregar producto...

                    </option>

                </select>

                <input
                    type="number"
                    placeholder="Cantidad">

                <button>

                    Agregar

                </button>

            </form>

        </fieldset>

    @endforeach

@else

    <p>

        No hay pallets creados.

    </p>

@endif
<h3>📦 Estado de Producción</h3>

<table border="1" cellpadding="5" width="100%">

    <thead>

        <tr>

            <th>Producto</th>

            <th>Solicitado</th>

            <th>En Pallets</th>

            <th>Pendiente</th>

            <th>Peso Total</th>

        </tr>

    </thead>

    <tbody>

        @foreach($order->details as $detalle)

            @php

                $enPallets = $detalle->cantidad_en_pallets ?? 0;

                $pendiente = $detalle->cantidad_solicitada - $enPallets;

                $peso = ($detalle->product->peso ?? 0) * $detalle->cantidad_solicitada;

            @endphp

            <tr>

                <td>{{ $detalle->product->nombre }}</td>

                <td align="center">

                    {{ $detalle->cantidad_solicitada }}

                </td>

                <td align="center">

                    {{ $enPallets }}

                </td>

                <td align="center">

                    {{ $pendiente }}

                </td>

                <td align="right">

                    {{ number_format($peso/1000,2) }} kg

                </td>

            </tr>

        @endforeach

    </tbody>

</table>