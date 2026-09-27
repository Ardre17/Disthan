@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Vista previa de importación
        </h1>

        <p class="text-gray-500">
            Revisa la información antes de crear la orden.
        </p>

    </div>


    {{-- CLIENTE --}}

    @if($client)

        <div class="mb-5 p-4 rounded-xl
                    bg-green-50
                    border border-green-200
                    text-green-800">

            <div class="font-bold">
                ✓ Cliente encontrado
            </div>

            <div class="text-sm mt-1">

                {{ $client->razon_social }}

                — RUC:
                {{ $client->ruc }}

            </div>

        </div>

    @else

        <div class="mb-5 p-4 rounded-xl
                    bg-red-50
                    border border-red-200
                    text-red-800">

            <div class="font-bold">
                ⚠ Cliente no encontrado
            </div>

            <div class="text-sm mt-1">

                RUC detectado:
                {{ $datos['ruc_cliente'] ?? '—' }}

            </div>

        </div>

    @endif


    {{-- CABECERA --}}

    <div class="bg-white border rounded-2xl
                p-6 mb-6 shadow-sm">

        <h2 class="text-lg font-bold mb-5">
            Datos del pedido
        </h2>


        <div class="grid
                    grid-cols-2
                    md:grid-cols-4
                    gap-5">


            <div>

                <div class="text-xs text-gray-500">
                    Orden
                </div>

                <div class="font-bold">
                    {{ $datos['numero_orden'] ?? '—' }}
                </div>

            </div>


            <div>

                <div class="text-xs text-gray-500">
                    Fecha
                </div>

                <div class="font-semibold">
                    {{ $datos['fecha_pedido'] ?? '—' }}
                </div>

            </div>


            <div>

                <div class="text-xs text-gray-500">
                    Entrega
                </div>

                <div class="font-semibold">
                    {{ $datos['fecha_entrega'] ?? '—' }}
                </div>

            </div>


            <div>

                <div class="text-xs text-gray-500">
                    N.º interno
                </div>

                <div class="font-semibold">
                    {{ $datos['order_interna'] ?? '—' }}
                </div>

            </div>

        </div>

    </div>


    {{-- PRODUCTOS --}}

    <div class="bg-white border rounded-2xl
                shadow-sm overflow-hidden">

        <div class="p-5 border-b">

            <h2 class="font-bold text-lg">
                Productos detectados
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                {{ count($datos['productos']) }}
                producto(s) encontrado(s) en el PDF.
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            Estado
                        </th>

                        <th class="px-4 py-3 text-left">
                            Código
                        </th>

                        <th class="px-4 py-3 text-left">
                            Producto PDF
                        </th>

                        <th class="px-4 py-3 text-left">
                            Producto DISTAN
                        </th>

                        <th class="px-4 py-3 text-center">
                            Cant.
                        </th>

                        <th class="px-4 py-3 text-right">
                            Precio
                        </th>

                        <th class="px-4 py-3 text-right">
                            Total PDF
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                @foreach(
                    $datos['productos']
                    as $item
                )

                    <tr>

                        {{-- ESTADO --}}

                        <td class="px-4 py-4">

                            @if($item['encontrado'])

                                <span
                                    class="px-2 py-1
                                           rounded-full
                                           bg-green-100
                                           text-green-700
                                           text-xs
                                           font-semibold"
                                >
                                    ✓ Código
                                </span>

                            @else

                                <span
                                    class="px-2 py-1
                                           rounded-full
                                           bg-red-100
                                           text-red-700
                                           text-xs
                                           font-semibold"
                                >
                                    ✕ No encontrado
                                </span>

                            @endif

                        </td>


                        {{-- CODIGO --}}

                        <td class="px-4 py-4">

                            <div class="font-bold">
                                {{ $item['codigo'] }}
                            </div>

                        </td>


                        {{-- NOMBRE PDF --}}

                        <td class="px-4 py-4">

                            {{ $item['descripcion'] }}

                        </td>


                        {{-- NOMBRE DISTAN --}}

                        <td class="px-4 py-4">

                            @if($item['encontrado'])

                                <div class="font-semibold">

                                    {{ $item['nombre_distan'] }}

                                </div>

                                <div class="text-xs text-gray-500">

                                    SKU:
                                    {{ $item['sku_distan'] ?? '—' }}

                                </div>

                            @else

                                <span class="text-red-600">
                                    Producto no encontrado
                                </span>

                            @endif

                        </td>


                        {{-- CANTIDAD --}}

                        <td
                            class="px-4 py-4 text-center"
                        >

                            {{ rtrim(
                                rtrim(
                                    number_format(
                                        $item['cantidad'],
                                        3
                                    ),
                                    '0'
                                ),
                                '.'
                            ) }}

                            {{ $item['unidad'] }}

                        </td>


                        {{-- PRECIO --}}

                        <td
                            class="px-4 py-4
                                   text-right
                                   font-semibold"
                        >

                            S/
                            {{ number_format(
                                $item['precio_unitario'],
                                2
                            ) }}

                        </td>


                        {{-- TOTAL PDF --}}

                        <td
                            class="px-4 py-4
                                   text-right
                                   text-gray-500"
                        >

                            S/
                            {{ number_format(
                                $item['total_pdf'],
                                2
                            ) }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>


    {{-- AVISO --}}

    <div class="mt-5 p-4 rounded-xl
                bg-blue-50
                border border-blue-200
                text-blue-800">

        <div class="font-semibold">
            ℹ️ Vista previa
        </div>

        <p class="text-sm mt-1">

            El precio unitario será utilizado posteriormente
            por DISTAN para realizar los cálculos.

            El total mostrado del PDF es solamente
            informativo y todavía no se guardará.

        </p>

    </div>


    <div class="mt-6">

        <a
            href="{{ route('orders.importPdf') }}"
            class="inline-flex
                   px-5 py-3
                   rounded-xl
                   border
                   bg-white"
        >
            ← Volver
        </a>

    </div>

</div>

@endsection