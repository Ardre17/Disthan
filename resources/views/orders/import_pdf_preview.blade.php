@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- =========================================================
         TITULO
    ========================================================== --}}

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Vista previa de importación
        </h1>

        <p class="text-gray-500">
            Revisa la información antes de crear la orden.
        </p>

    </div>


    {{-- =========================================================
         CLIENTE
    ========================================================== --}}

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


    {{-- =========================================================
         FORMULARIO
    ========================================================== --}}

    <form
        action="{{ route('orders.importPdf.store') }}"
        method="POST"
        id="form-importar-orden"
    >

        @csrf


        {{-- =====================================================
             DATOS DEL PEDIDO
        ====================================================== --}}

        <div class="bg-white border rounded-2xl
                    p-6 mb-6 shadow-sm">

            <h2 class="text-lg font-bold mb-5">
                Datos del pedido
            </h2>


            <div class="grid
                        grid-cols-2
                        md:grid-cols-4
                        gap-5">


                {{-- NUMERO ORDEN --}}

                <div>

                    <div class="text-xs text-gray-500">
                        Orden
                    </div>

                    <div class="font-bold">
                        {{ $datos['numero_orden'] ?? '—' }}
                    </div>

                    <input
                        type="hidden"
                        name="numero_orden"
                        value="{{ $datos['numero_orden'] ?? '' }}"
                    >

                </div>


                {{-- FECHA --}}

                <div>

                    <div class="text-xs text-gray-500">
                        Fecha
                    </div>

                    <div class="font-semibold">
                        {{ $datos['fecha_pedido'] ?? '—' }}
                    </div>

                    <input
                        type="hidden"
                        name="fecha_pedido"
                        value="{{ $datos['fecha_pedido'] ?? '' }}"
                    >

                </div>


                {{-- ENTREGA --}}

                <div>

                    <div class="text-xs text-gray-500">
                        Entrega
                    </div>

                    <div class="font-semibold">
                        {{ $datos['fecha_entrega'] ?? '—' }}
                    </div>

                    <input
                        type="hidden"
                        name="fecha_entrega"
                        value="{{ $datos['fecha_entrega'] ?? '' }}"
                    >

                </div>


                {{-- INTERNO --}}

                <div>

                    <div class="text-xs text-gray-500">
                        N.º interno
                    </div>

                    <div class="font-semibold">
                        {{ $datos['order_interna'] ?? '—' }}
                    </div>

                    <input
                        type="hidden"
                        name="order_interna"
                        value="{{ $datos['order_interna'] ?? '' }}"
                    >

                </div>

            </div>


            {{-- CLIENTE OCULTO --}}

            @if($client)

                <input
                    type="hidden"
                    name="client_id"
                    value="{{ $client->id }}"
                >

            @endif


            {{-- TIPO DE ORDEN --}}

            <div class="mt-6">

                <label
                    for="tipo_orden"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Tipo de orden
                </label>

                <select
                    name="tipo_orden"
                    id="tipo_orden"
                    required
                    class="w-full md:w-80 rounded-xl border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500"
                >

                    <option value="">
                        Seleccionar...
                    </option>

                    <option value="SUPERMERCADO">
                        SUPERMERCADO
                    </option>

                    <option value="LOCAL">
                        LOCAL
                    </option>

                    <option value="ENCOMIENDA">
                        ENCOMIENDA
                    </option>

                    <option value="EXPORTACION">
                        EXPORTACIÓN
                    </option>

                </select>

            </div>

        </div>


        {{-- =====================================================
             PRODUCTOS
        ====================================================== --}}

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
                                Código PDF
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

                            <th class="px-4 py-3 text-center">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">


                    @foreach(
                        $datos['productos']
                        as $item
                    )

                        <tr
                            data-product-row="{{ $loop->index }}"
                        >


                            {{-- =================================
                                 ESTADO
                            ================================== --}}

                            <td
                                class="px-4 py-4 estado-producto"
                            >

                                @if($item['encontrado'])

                                    @if(
                                        ($item['coincidencia'] ?? null)
                                        === 'codigo'
                                    )

                                        <span
                                            class="inline-flex
                                                   px-2 py-1
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
                                            class="inline-flex
                                                   px-2 py-1
                                                   rounded-full
                                                   bg-yellow-100
                                                   text-yellow-700
                                                   text-xs
                                                   font-semibold"
                                        >
                                            ⚠ Nombre
                                        </span>

                                    @endif

                                @else

                                    <span
                                        class="inline-flex
                                               px-2 py-1
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


                            {{-- =================================
                                 CODIGO PDF
                            ================================== --}}

                            <td class="px-4 py-4">

                                <div class="font-bold">
                                    {{ $item['codigo'] }}
                                </div>

                            </td>


                            {{-- =================================
                                 PRODUCTO PDF
                            ================================== --}}

                            <td class="px-4 py-4">

                                <div>
                                    {{ $item['descripcion'] }}
                                </div>

                            </td>


                            {{-- =================================
                                 PRODUCTO DISTAN
                            ================================== --}}

                            <td
                                class="px-4 py-4 producto-distan"
                            >

                                @if($item['encontrado'])

                                    <div class="font-semibold">

                                        {{ $item['nombre_distan'] }}

                                    </div>

                                    <div
                                        class="text-xs
                                               text-gray-500"
                                    >

                                        SKU:
                                        {{ $item['sku_distan'] ?? '—' }}

                                    </div>

                                @else

                                    <span class="text-red-600">
                                        Producto no encontrado
                                    </span>

                                @endif

                            </td>


                            {{-- =================================
                                 CANTIDAD
                            ================================== --}}

                            <td
                                class="px-4 py-4
                                       text-center"
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


                                <input
                                    type="hidden"
                                    name="productos[{{ $loop->index }}][cantidad]"
                                    value="{{ $item['cantidad'] }}"
                                >

                            </td>


                            {{-- =================================
                                 PRECIO UNITARIO
                            ================================== --}}

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


                                <input
                                    type="hidden"
                                    name="productos[{{ $loop->index }}][precio_unitario]"
                                    value="{{ $item['precio_unitario'] }}"
                                >

                            </td>


                            {{-- =================================
                                 TOTAL PDF
                                 SOLO REFERENCIA
                            ================================== --}}

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


                            {{-- =================================
                                 ACCION
                            ================================== --}}

                            <td
                                class="px-4 py-4
                                       text-center"
                            >

                                {{-- product_id que realmente
                                     se enviará al servidor --}}

                                <input
                                    type="hidden"
                                    name="productos[{{ $loop->index }}][product_id]"
                                    value="{{ $item['product_id'] ?? '' }}"
                                    id="product-id-{{ $loop->index }}"
                                >


                                @if($item['encontrado'])

                                    <button
                                        type="button"
                                        onclick="abrirBuscadorProducto({{ $loop->index }})"
                                        class="px-3 py-2
                                               rounded-lg
                                               border
                                               border-blue-300
                                               text-blue-700
                                               text-xs
                                               font-semibold
                                               hover:bg-blue-50"
                                    >
                                        Cambiar
                                    </button>

                                @else

                                    <button
                                        type="button"
                                        onclick="abrirBuscadorProducto({{ $loop->index }})"
                                        class="px-3 py-2
                                               rounded-lg
                                               bg-orange-500
                                               text-white
                                               text-xs
                                               font-semibold
                                               hover:bg-orange-600"
                                    >
                                        🔎 Buscar producto
                                    </button>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             AVISO
        ====================================================== --}}

        <div
            class="mt-5 p-4 rounded-xl
                   bg-blue-50
                   border border-blue-200
                   text-blue-800"
        >

            <div class="font-semibold">
                ℹ️ Vista previa
            </div>

            <p class="text-sm mt-1">

                El precio unitario será utilizado posteriormente
                por DISTAN para realizar los cálculos.

                El total mostrado del PDF es solamente informativo
                y no se utilizará como total de la orden.

            </p>

        </div>


        {{-- =====================================================
             BOTONES
        ====================================================== --}}

        <div
            class="mt-6
                   flex
                   flex-col
                   sm:flex-row
                   justify-between
                   gap-3"
        >

            <a
                href="{{ route('orders.importPdf') }}"
                class="inline-flex
                       justify-center
                       items-center
                       px-5 py-3
                       rounded-xl
                       border
                       bg-white
                       text-gray-700
                       hover:bg-gray-50"
            >
                ← Volver
            </a>


            <button
                type="submit"
                id="btn-crear-orden"
                disabled
                class="px-6 py-3
                       rounded-xl
                       bg-gray-400
                       text-white
                       font-semibold
                       cursor-not-allowed"
            >
                Revisar productos
            </button>

        </div>

    </form>

</div>


{{-- =============================================================
     MODAL BUSCAR PRODUCTO
============================================================= --}}

<div
    id="modal-producto"
    class="hidden fixed inset-0 z-50
           bg-black/50
           items-center
           justify-center
           p-4"
>

    <div
        class="bg-white
               rounded-2xl
               shadow-2xl
               w-full
               max-w-2xl
               max-h-[90vh]
               overflow-hidden"
    >


        {{-- HEADER MODAL --}}

        <div class="p-5 border-b">

            <div
                class="flex
                       justify-between
                       items-center"
            >

                <div>

                    <h2 class="text-xl font-bold">
                        Buscar producto
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Busca por nombre, SKU o código.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="cerrarBuscadorProducto()"
                    class="text-gray-500
                           hover:text-gray-800
                           text-xl"
                >
                    ✕
                </button>

            </div>

        </div>


        {{-- CONTENIDO MODAL --}}

        <div class="p-5">


            <input
                type="text"
                id="producto-busqueda"
                placeholder="Ej. Palmitos, PL800..."
                class="w-full rounded-xl
                       border-gray-300
                       focus:border-blue-500
                       focus:ring-blue-500"
                autocomplete="off"
            >


            <div
                id="resultados-productos"
                class="mt-4
                       space-y-2
                       max-h-80
                       overflow-y-auto"
            >

                <div
                    class="text-center
                           text-gray-400
                           py-8"
                >
                    Escribe para buscar...
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

let filaProductoActual = null;

let temporizadorBusqueda = null;


/*
|--------------------------------------------------------------------------
| ABRIR MODAL
|--------------------------------------------------------------------------
*/

function abrirBuscadorProducto(index)
{
    filaProductoActual = index;

    const modal =
        document.getElementById(
            'modal-producto'
        );

    const input =
        document.getElementById(
            'producto-busqueda'
        );


    modal.classList.remove('hidden');

    modal.classList.add('flex');


    input.value = '';

    input.focus();


    document.getElementById(
        'resultados-productos'
    ).innerHTML = `

        <div
            class="text-center
                   text-gray-400
                   py-8"
        >
            Escribe para buscar...
        </div>

    `;
}


/*
|--------------------------------------------------------------------------
| CERRAR MODAL
|--------------------------------------------------------------------------
*/

function cerrarBuscadorProducto()
{
    const modal =
        document.getElementById(
            'modal-producto'
        );


    modal.classList.add('hidden');

    modal.classList.remove('flex');


    filaProductoActual = null;
}


/*
|--------------------------------------------------------------------------
| BUSCAR AL ESCRIBIR
|--------------------------------------------------------------------------
*/

document
    .getElementById(
        'producto-busqueda'
    )
    .addEventListener(
        'input',
        function () {

            clearTimeout(
                temporizadorBusqueda
            );


            const q =
                this.value.trim();


            if (q.length < 2) {

                document.getElementById(
                    'resultados-productos'
                ).innerHTML = `

                    <div
                        class="text-center
                               text-gray-400
                               py-8"
                    >
                        Escribe al menos 2 caracteres...
                    </div>

                `;

                return;
            }


            temporizadorBusqueda =
                setTimeout(
                    () => buscarProductos(q),
                    300
                );

        }
    );


/*
|--------------------------------------------------------------------------
| BUSCAR PRODUCTOS EN LARAVEL
|--------------------------------------------------------------------------
*/

async function buscarProductos(q)
{
    const contenedor =
        document.getElementById(
            'resultados-productos'
        );


    contenedor.innerHTML = `

        <div
            class="text-center
                   text-gray-400
                   py-8"
        >
            Buscando...
        </div>

    `;


    try {

        const response =
            await fetch(
                `{{ route('orders.importPdf.productSearch') }}?q=${encodeURIComponent(q)}`,
                {
                    headers: {
                        'Accept':
                            'application/json',
                    }
                }
            );


        if (!response.ok) {

            throw new Error(
                'Error en la búsqueda'
            );

        }


        const productos =
            await response.json();


        if (!productos.length) {

            contenedor.innerHTML = `

                <div
                    class="text-center
                           text-red-500
                           py-8"
                >
                    No se encontraron productos.
                </div>

            `;

            return;
        }


        contenedor.innerHTML =
            productos
                .map(
                    producto => `

                    <button
                        type="button"
                        onclick='seleccionarProducto(${JSON.stringify(producto)})'
                        class="w-full
                               text-left
                               p-4
                               rounded-xl
                               border
                               hover:bg-blue-50
                               hover:border-blue-300
                               transition"
                    >

                        <div
                            class="font-semibold
                                   text-gray-800"
                        >
                            ${escapeHtml(
                                producto.nombre
                            )}
                        </div>


                        <div
                            class="text-xs
                                   text-gray-500
                                   mt-1"
                        >

                            SKU:
                            ${escapeHtml(
                                producto.sku ?? '—'
                            )}

                            &nbsp; | &nbsp;

                            Barcode:
                            ${escapeHtml(
                                producto.barcode ?? '—'
                            )}

                        </div>

                    </button>

                `
                )
                .join('');


    } catch (error) {

        console.error(
            error
        );


        contenedor.innerHTML = `

            <div
                class="text-center
                       text-red-500
                       py-8"
            >
                Error al buscar productos.
            </div>

        `;

    }
}


/*
|--------------------------------------------------------------------------
| SELECCIONAR PRODUCTO
|--------------------------------------------------------------------------
*/

function seleccionarProducto(producto)
{
    if (
        filaProductoActual === null
    ) {
        return;
    }


    const index =
        filaProductoActual;


    /*
     * Guardar product_id
     */

    const input =
        document.getElementById(
            `product-id-${index}`
        );


    if (input) {

        input.value =
            producto.id;

    }


    /*
     * Buscar fila
     */

    const fila =
        document.querySelector(
            `[data-product-row="${index}"]`
        );


    if (fila) {


        /*
         * Actualizar producto DISTAN
         */

        const productoDistan =
            fila.querySelector(
                '.producto-distan'
            );


        if (productoDistan) {

            productoDistan.innerHTML = `

                <div
                    class="font-semibold
                           text-gray-800"
                >
                    ${escapeHtml(
                        producto.nombre
                    )}
                </div>

                <div
                    class="text-xs
                           text-gray-500"
                >
                    SKU:
                    ${escapeHtml(
                        producto.sku ?? '—'
                    )}
                </div>

            `;

        }


        /*
         * Actualizar estado
         */

        const estado =
            fila.querySelector(
                '.estado-producto'
            );


        if (estado) {

            estado.innerHTML = `

                <span
                    class="inline-flex
                           px-2 py-1
                           rounded-full
                           bg-blue-100
                           text-blue-700
                           text-xs
                           font-semibold"
                >
                    ✓ Manual
                </span>

            `;

        }

    }


    cerrarBuscadorProducto();


    verificarProductos();
}


/*
|--------------------------------------------------------------------------
| VERIFICAR SI TODOS LOS PRODUCTOS ESTÁN ASIGNADOS
|--------------------------------------------------------------------------
*/

function verificarProductos()
{
    let completos = true;


    document
        .querySelectorAll(
            '[id^="product-id-"]'
        )
        .forEach(
            input => {

                if (
                    !input.value
                    ||
                    input.value.trim() === ''
                ) {

                    completos = false;

                }

            }
        );


    const boton =
        document.getElementById(
            'btn-crear-orden'
        );


    if (!boton