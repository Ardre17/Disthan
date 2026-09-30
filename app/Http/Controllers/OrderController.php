@extends('layouts.app')

@section('content')

<style>

/* =========================================================
   BASE
========================================================= */

* {
    box-sizing: border-box;
}

.pdf-page {
    padding: 1.25rem;
    background: #f1f5f9;
    min-height: 100vh;
}


/* =========================================================
   HEADER
========================================================= */

.pdf-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 1rem;
}

.pdf-title {
    font-size: 17px;
    font-weight: 700;
    color: #1e293b;
}

.pdf-subtitle {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 3px;
}


/* =========================================================
   BOTONES
========================================================= */

.pdf-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: opacity .15s, background .15s;
}

.pdf-btn:hover {
    opacity: .85;
}

.pdf-btn-blue {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

.pdf-btn-orange {
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #fed7aa;
}

.pdf-btn-green {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.pdf-btn-gray {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.pdf-btn-primary {
    background: #2563eb;
    color: white;
    border: none;
}

.pdf-btn-primary:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    opacity: 1;
}


/* =========================================================
   CARDS
========================================================= */

.pdf-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 1rem;
    overflow: hidden;
}

.pdf-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
}

.pdf-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
}

.pdf-card-subtitle {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 3px;
}

.pdf-card-body {
    padding: 1rem 1.25rem;
}


/* =========================================================
   ALERTAS
========================================================= */

.pdf-alert {
    border-radius: 10px;
    padding: 10px 13px;
    margin-bottom: 1rem;
    font-size: 12px;
}

.pdf-alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.pdf-alert-danger {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

.pdf-alert-info {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;
}

.pdf-alert-title {
    font-weight: 700;
    margin-bottom: 3px;
}


/* =========================================================
   DATOS PEDIDO
========================================================= */

.pdf-meta {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px 14px;
}

.pdf-meta-item {
    font-size: 12px;
    color: #64748b;
}

.pdf-meta-value {
    font-weight: 700;
    color: #374151;
}

.pdf-meta-label {
    font-size: 10px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 3px;
}


/* =========================================================
   TIPO DE ORDEN
========================================================= */

.pdf-type {
    margin-top: 15px;
}

.pdf-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 4px;
}

.pdf-input,
.pdf-select {
    padding: 8px 10px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13px;
    color: #1e293b;
    background: #fff;
    outline: none;
}

.pdf-select {
    width: 250px;
}

.pdf-input:focus,
.pdf-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}


/* =========================================================
   TABLA
========================================================= */

.pdf-table-wrapper {
    overflow-x: auto;
}

.pdf-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1050px;
    font-size: 12px;
}

.pdf-table thead {
    background: #f8fafc;
}

.pdf-table th {
    padding: 10px;
    text-align: left;
    font-size: 10px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .03em;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}

.pdf-table td {
    padding: 11px 10px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    vertical-align: middle;
}

.pdf-table tbody tr:hover {
    background: #fafafa;
}

.pdf-code {
    font-family: monospace;
    font-weight: 700;
    color: #1e293b;
}

.pdf-product {
    color: #374151;
}

.pdf-product-distan {
    font-weight: 600;
    color: #1e293b;
}

.pdf-sku {
    margin-top: 2px;
    font-size: 10px;
    color: #94a3b8;
}

.pdf-price {
    text-align: right;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
}

.pdf-total {
    text-align: right;
    color: #94a3b8;
    white-space: nowrap;
}

.pdf-center {
    text-align: center !important;
}


/* =========================================================
   BADGES
========================================================= */

.pdf-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 99px;
    font-weight: 600;
    white-space: nowrap;
}

.pdf-badge-code {
    background: #dcfce7;
    color: #15803d;
}

.pdf-badge-name {
    background: #fef3c7;
    color: #b45309;
}

.pdf-badge-manual {
    background: #dbeafe;
    color: #1d4ed8;
}

.pdf-badge-none {
    background: #fee2e2;
    color: #b91c1c;
}


/* =========================================================
   FOOTER
========================================================= */

.pdf-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-top: 1rem;
}


/* =========================================================
   MODAL
========================================================= */

#modalProductoPdf {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(15,23,42,.60);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

#modalProductoPdf.abierto {
    display: flex;
}

.pdf-modal {
    width: min(650px, 96vw);
    max-height: 90vh;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 25px 60px rgba(0,0,0,.30);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.pdf-modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pdf-modal-title {
    font-size: 16px;
    font-weight: 800;
    color: #1e293b;
}

.pdf-modal-subtitle {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 3px;
}

.pdf-modal-close {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 7px;
    background: #f1f5f9;
    color: #475569;
    font-size: 20px;
    cursor: pointer;
}

.pdf-modal-close:hover {
    background: #e2e8f0;
}

.pdf-modal-body {
    padding: 18px 20px;
    overflow: auto;
}

.pdf-search {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13px;
    outline: none;
}

.pdf-search:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.10);
}

.pdf-results {
    margin-top: 12px;
    max-height: 400px;
    overflow-y: auto;
}

.pdf-result {
    width: 100%;
    border: 1px solid #e2e8f0;
    background: #fff;
    border-radius: 9px;
    padding: 11px 12px;
    margin-bottom: 7px;
    text-align: left;
    cursor: pointer;
    transition: background .15s, border-color .15s;
}

.pdf-result:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
}

.pdf-result-name {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
}

.pdf-result-data {
    margin-top: 4px;
    font-size: 10px;
    color: #94a3b8;
}

.pdf-search-message {
    text-align: center;
    padding: 25px;
    color: #94a3b8;
    font-size: 12px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:800px) {

    .pdf-meta {
        grid-template-columns: repeat(2,1fr);
    }

    .pdf-header {
        flex-direction: column;
    }

}

@media(max-width:500px) {

    .pdf-page {
        padding: .75rem;
    }

    .pdf-meta {
        grid-template-columns: 1fr 1fr;
    }

    .pdf-footer {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .pdf-footer .pdf-btn {
        width: 100%;
    }

}

</style>


<div class="pdf-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="pdf-header">

        <div>

            <div class="pdf-title">
                📋 Importar pedido PDF
            </div>

            <div class="pdf-subtitle">
                Revisa y relaciona los productos antes de crear la orden.
            </div>

        </div>


        <a
            href="{{ route('orders.importPdf') }}"
            class="pdf-btn pdf-btn-gray"
        >
            ← Volver
        </a>

    </div>


    <form
        id="importPdfForm"
        method="POST"
        action="{{ route('orders.importPdf.store') }}"
    >

        @csrf

        <input type="hidden" name="client_id" value="{{ $client?->id ?? '' }}">
        <input type="hidden" name="fecha_pedido" value="{{ $datos['fecha_pedido'] ?? '' }}">
        <input type="hidden" name="fecha_entrega" value="{{ $datos['fecha_entrega'] ?? '' }}">
        <input type="hidden" name="order_interna" value="{{ $datos['order_interna'] ?? '' }}">

    {{-- =====================================================
         CLIENTE
    ====================================================== --}}

    @if($client)

        <div class="pdf-alert pdf-alert-success">

            <div class="pdf-alert-title">
                ✓ Cliente encontrado
            </div>

            {{ $client->razon_social }}
            — RUC: {{ $client->ruc }}

        </div>

    @else

        <div class="pdf-alert pdf-alert-danger">

            <div class="pdf-alert-title">
                ⚠ Cliente no encontrado
            </div>

            RUC detectado:
            {{ $datos['ruc_cliente'] ?? '—' }}

        </div>

    @endif


    {{-- =====================================================
         DATOS DEL PEDIDO
    ====================================================== --}}

    <div class="pdf-card">

        <div class="pdf-card-header">

            <div class="pdf-card-title">
                Datos del pedido
            </div>

        </div>


        <div class="pdf-card-body">

            <div class="pdf-meta">

                <div class="pdf-meta-item">

                    <div class="pdf-meta-label">
                        Orden
                    </div>

                    <span class="pdf-meta-value">
                        {{ $datos['numero_orden'] ?? '—' }}
                    </span>

                </div>


                <div class="pdf-meta-item">

                    <div class="pdf-meta-label">
                        Fecha
                    </div>

                    <span class="pdf-meta-value">
                        {{ $datos['fecha_pedido'] ?? '—' }}
                    </span>

                </div>


                <div class="pdf-meta-item">

                    <div class="pdf-meta-label">
                        Entrega
                    </div>

                    <span class="pdf-meta-value">
                        {{ $datos['fecha_entrega'] ?? '—' }}
                    </span>

                </div>


                <div class="pdf-meta-item">

                    <div class="pdf-meta-label">
                        Orden interna
                    </div>

                    <span class="pdf-meta-value">
                        {{ $datos['order_interna'] ?? '—' }}
                    </span>

                </div>

            </div>


            <div class="pdf-type">

                <label
                    class="pdf-label"
                    for="tipoOrdenPdf"
                >
                    Tipo de orden
                </label>

                <select
                    id="tipoOrdenPdf"
                    name="tipo_orden"
                    class="pdf-select"
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

    </div>


    {{-- =====================================================
         PRODUCTOS
    ====================================================== --}}

    <div class="pdf-card">

        <div class="pdf-card-header">

            <div class="pdf-card-title">
                Productos detectados
            </div>

            <div class="pdf-card-subtitle">

                {{ count($datos['productos']) }}
                producto(s) encontrado(s) en el PDF.

            </div>

        </div>


        <div class="pdf-table-wrapper">

            <table class="pdf-table">

                <thead>

                    <tr>

                        <th>
                            Estado
                        </th>

                        <th>
                            Código PDF
                        </th>

                        <th>
                            Producto PDF
                        </th>

                        <th>
                            Producto DISTAN
                        </th>

                        <th class="pdf-center">
                            Cant.
                        </th>

                        <th style="text-align:right;">
                            Precio
                        </th>

                        <th style="text-align:right;">
                            Total PDF
                        </th>

                        <th class="pdf-center">
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody>

                @foreach($datos['productos'] as $item)

                    <tr
                        data-product-row="{{ $loop->index }}"
                    >

                        {{-- ESTADO --}}

                        <td class="estado-producto">

                            @if($item['encontrado'])

                                @if(
                                    ($item['coincidencia'] ?? null)
                                    === 'codigo'
                                )

                                    <span
                                        class="pdf-badge pdf-badge-code"
                                    >
                                        ✓ Código
                                    </span>

                                @else

                                    <span
                                        class="pdf-badge pdf-badge-name"
                                    >
                                        ⚠ Nombre
                                    </span>

                                @endif

                            @else

                                <span
                                    class="pdf-badge pdf-badge-none"
                                >
                                    ✕ No encontrado
                                </span>

                            @endif

                        </td>


                        {{-- CODIGO --}}

                        <td>

                            <div class="pdf-code">
                                {{ $item['codigo'] }}
                            </div>

                        </td>


                        {{-- PRODUCTO PDF --}}

                        <td>

                            <div class="pdf-product">
                                {{ $item['descripcion'] }}
                            </div>

                        </td>


                        {{-- PRODUCTO DISTAN --}}

                        <td class="producto-distan">

                            @if($item['encontrado'])

                                <div class="pdf-product-distan">

                                    {{ $item['nombre_distan'] }}

                                </div>

                                <div class="pdf-sku">

                                    SKU:
                                    {{ $item['sku_distan'] ?? '—' }}

                                </div>

                            @else

                                <span
                                    style="color:#b91c1c;"
                                >
                                    Producto no encontrado
                                </span>

                            @endif

                        </td>


                        {{-- CANTIDAD --}}

                        <td class="pdf-center">

                            {{
                                rtrim(
                                    rtrim(
                                        number_format(
                                            $item['cantidad'],
                                            3
                                        ),
                                        '0'
                                    ),
                                    '.'
                                )
                            }}

                            {{ $item['unidad'] }}

                        </td>


                        {{-- PRECIO --}}

                        <td class="pdf-price">

                            S/
                            {{
                                number_format(
                                    $item['precio_unitario'],
                                    2
                                )
                            }}

                        </td>


                        {{-- TOTAL PDF --}}

                        <td class="pdf-total">

                            S/
                            {{
                                number_format(
                                    $item['total_pdf'],
                                    2
                                )
                            }}

                        </td>


                        {{-- ACCION --}}

                        <td class="pdf-center">

                            <input
                                type="hidden"
                                id="product-id-{{ $loop->index }}"
                                name="productos[{{ $loop->index }}][product_id]"
                                value="{{ $item['product_id'] ?? '' }}"
                            >

                            <input
                                type="hidden"
                                name="productos[{{ $loop->index }}][cantidad]"
                                value="{{ $item['cantidad'] }}"
                            >

                            <input
                                type="hidden"
                                name="productos[{{ $loop->index }}][precio_unitario]"
                                value="{{ $item['precio_unitario'] }}"
                            >


                            <button
                                type="button"
                                class="pdf-btn
                                    {{ $item['encontrado']
                                        ? 'pdf-btn-blue'
                                        : 'pdf-btn-orange'
                                    }}"
                                data-product-search="{{ $loop->index }}"
                            >

                                {{
                                    $item['encontrado']
                                        ? 'Cambiar'
                                        : '🔎 Buscar producto'
                                }}

                            </button>

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

    <div class="pdf-alert pdf-alert-info">

        <div class="pdf-alert-title">
            ℹ️ Vista previa
        </div>

        El precio unitario se conservará para que DISTAN
        realice posteriormente sus cálculos.

        El total del PDF es solamente informativo.

    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="pdf-footer">

        <a
            href="{{ route('orders.importPdf') }}"
            class="pdf-btn pdf-btn-gray"
        >
            ← Volver
        </a>


        <button
            type="submit"
            id="btn-crear-orden"
            class="pdf-btn pdf-btn-primary"
            disabled
        >
            Revisar productos
        </button>

    </div>


</div>

    </form>


{{-- =========================================================
     MODAL
========================================================= --}}

<div id="modalProductoPdf">

    <div class="pdf-modal">


        <div class="pdf-modal-header">

            <div>

                <div class="pdf-modal-title">
                    Buscar producto
                </div>

                <div class="pdf-modal-subtitle">
                    Busca por nombre, SKU, código de barras o código de caja.
                </div>

            </div>


            <button
                type="button"
                class="pdf-modal-close"
                id="cerrarModalProducto"
            >
                ×
            </button>

        </div>


        <div class="pdf-modal-body">

            <input
                type="text"
                id="buscarProductoPdf"
                class="pdf-search"
                placeholder="Ejemplo: Palmitos, PL800..."
                autocomplete="off"
            >


            <div
                id="resultadosProductoPdf"
                class="pdf-results"
            >

                <div class="pdf-search-message">
                    Escribe al menos 2 caracteres...
                </div>

            </div>

        </div>

    </div>

</div>


<script>

(function () {

    'use strict';


    /*
    |--------------------------------------------------------------------------
    | VARIABLES
    |--------------------------------------------------------------------------
    */

    let filaActual = null;
    let timerBusqueda = null;


    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const modal =
        document.getElementById(
            'modalProductoPdf'
        );

    const input =
        document.getElementById(
            'buscarProductoPdf'
        );

    const resultados =
        document.getElementById(
            'resultadosProductoPdf'
        );


    /*
    |--------------------------------------------------------------------------
    | ABRIR MODAL
    |--------------------------------------------------------------------------
    */

    function abrirModal(index)
    {
        filaActual = index;

        modal.classList.add('abierto');

        document.body.style.overflow = 'hidden';

        input.value = '';

        resultados.innerHTML = `
            <div class="pdf-search-message">
                Escribe al menos 2 caracteres...
            </div>
        `;

        setTimeout(function () {
            input.focus();
        }, 50);
    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR MODAL
    |--------------------------------------------------------------------------
    */

    function cerrarModal()
    {
        modal.classList.remove('abierto');

        document.body.style.overflow = '';

        filaActual = null;

        input.value = '';
    }


    /*
    |--------------------------------------------------------------------------
    | BOTONES "CAMBIAR" / "BUSCAR"
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('[data-product-search]')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const index =
                        this.getAttribute(
                            'data-product-search'
                        );

                    abrirModal(index);

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | CERRAR
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'cerrarModalProducto'
        )
        .addEventListener(
            'click',
            cerrarModal
        );


    /*
    |--------------------------------------------------------------------------
    | CLICK FUERA DEL MODAL
    |--------------------------------------------------------------------------
    */

    modal.addEventListener(
        'click',
        function (event) {

            if (
                event.target === modal
            ) {

                cerrarModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape'
                &&
                modal.classList.contains(
                    'abierto'
                )
            ) {

                cerrarModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCRIBIR BUSQUEDA
    |--------------------------------------------------------------------------
    */

    input.addEventListener(
        'input',
        function () {

            clearTimeout(
                timerBusqueda
            );


            const q =
                this.value.trim();


            if (
                q.length < 2
            ) {

                resultados.innerHTML = `
                    <div class="pdf-search-message">
                        Escribe al menos 2 caracteres...
                    </div>
                `;

                return;
            }


            resultados.innerHTML = `
                <div class="pdf-search-message">
                    ⏳ Buscando productos...
                </div>
            `;


            timerBusqueda =
                setTimeout(
                    function () {

                        buscarProductos(q);

                    },
                    250
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | BUSCAR EN LARAVEL
    |--------------------------------------------------------------------------
    */

    async function buscarProductos(q)
    {
        try {

            const url =
                "{{ route('orders.importPdf.productSearch') }}"
                +
                '?q='
                +
                encodeURIComponent(q);


            const response =
                await fetch(
                    url,
                    {
                        method: 'GET',

                        headers: {
                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'
                        }
                    }
                );


            if (!response.ok) {

                throw new Error(
                    'HTTP ' +
                    response.status
                );

            }


            const productos =
                await response.json();


            mostrarResultados(
                productos
            );


        } catch (error) {

            console.error(
                'ERROR BUSCANDO PRODUCTO:',
                error
            );


            resultados.innerHTML = `
                <div
                    class="pdf-search-message"
                    style="color:#b91c1c;"
                >
                    ❌ No se pudo consultar
                    el catálogo de productos.
                    <br><br>
                    <small>
                        Error ${error.message}
                    </small>
                </div>
            `;

        }
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR RESULTADOS
    |--------------------------------------------------------------------------
    */

    function mostrarResultados(
        productos
    )
    {

        if (
            !productos
            ||
            productos.length === 0
        ) {

            resultados.innerHTML = `
                <div
                    class="pdf-search-message"
                    style="color:#b91c1c;"
                >
                    No se encontraron productos.
                </div>
            `;

            return;
        }


        resultados.innerHTML =
            productos
                .map(
                    function (producto) {

                        return `

                            <button
                                type="button"
                                class="pdf-result"
                                data-product-id="${producto.id}"
                            >

                                <div class="pdf-result-name">

                                    ${escapeHtml(
                                        producto.nombre
                                    )}

                                </div>


                                <div class="pdf-result-data">

                                    SKU:
                                    ${escapeHtml(
                                        producto.sku || '—'
                                    )}

                                    &nbsp; | &nbsp;

                                    Barcode:
                                    ${escapeHtml(
                                        producto.barcode || '—'
                                    )}

                                    ${
                                        producto.box_barcode
                                        ?
                                        `
                                        &nbsp; | &nbsp;
                                        Caja:
                                        ${escapeHtml(
                                            producto.box_barcode
                                        )}
                                        `
                                        :
                                        ''
                                    }

                                </div>

                            </button>

                        `;

                    }
                )
                .join('');


        /*
        |--------------------------------------------------------------------------
        | EVENTO DE SELECCION
        |--------------------------------------------------------------------------
        */

        resultados
            .querySelectorAll(
                '[data-product-id]'
            )
            .forEach(
                function (button, posicion) {

                    button.addEventListener(
                        'click',
                        function () {

                            const producto =
                                productos[
                                    posicion
                                ];

                            seleccionarProducto(
                                producto
                            );

                        }
                    );

                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SELECCIONAR PRODUCTO
    |--------------------------------------------------------------------------
    */

    function seleccionarProducto(
        producto
    )
    {

        if (
            filaActual === null
        ) {

            return;

        }


        const index =
            filaActual;


        /*
        |--------------------------------------------------------------------------
        | GUARDAR PRODUCT ID
        |--------------------------------------------------------------------------
        */

        const hidden =
            document.getElementById(
                'product-id-' + index
            );


        if (hidden) {

            hidden.value =
                producto.id;

        }


        /*
        |--------------------------------------------------------------------------
        | FILA
        |--------------------------------------------------------------------------
        */

        const fila =
            document.querySelector(
                '[data-product-row="' +
                index +
                '"]'
            );


        if (fila) {


            /*
            | Producto DISTAN
            */

            const productoDistan =
                fila.querySelector(
                    '.producto-distan'
                );


            if (
                productoDistan
            ) {

                productoDistan.innerHTML = `

                    <div class="pdf-product-distan">

                        ${escapeHtml(
                            producto.nombre
                        )}

                    </div>

                    <div class="pdf-sku">

                        SKU:
                        ${escapeHtml(
                            producto.sku || '—'
                        )}

                    </div>

                `;

            }


            /*
            | Estado
            */

            const estado =
                fila.querySelector(
                    '.estado-producto'
                );


            if (
                estado
            ) {

                estado.innerHTML = `

                    <span
                        class="pdf-badge
                               pdf-badge-manual"
                    >
                        ✓ Manual
                    </span>

                `;

            }


            /*
            | Botón
            */

            const boton =
                fila.querySelector(
                    '[data-product-search]'
                );


            if (
                boton
            ) {

                boton.textContent =
                    'Cambiar';

                boton.classList.remove(
                    'pdf-btn-orange'
                );

                boton.classList.add(
                    'pdf-btn-blue'
                );

            }

        }


        cerrarModal();

        verificarProductos();

    }


    /*
    |--------------------------------------------------------------------------
    | VERIFICAR PRODUCTOS
    |--------------------------------------------------------------------------
    */

    function verificarProductos()
    {

        const inputs =
            document.querySelectorAll(
                '[id^="product-id-"]'
            );


        let completos = true;


        inputs.forEach(
            function (input) {

                if (
                    !input.value
                    ||
                    input.value.trim() === ''
                ) {

                    completos = false;

                }

            }
        );


        const tipoOrden =
            document.getElementById(
                'tipoOrdenPdf'
            );


        if (
            !tipoOrden
            ||
            !tipoOrden.value
        ) {

            completos = false;

        }


        const clientId =
            document.querySelector(
                'input[name="client_id"]'
            );


        if (
            !clientId
            ||
            !clientId.value
        ) {

            completos = false;

        }


        const boton =
            document.getElementById(
                'btn-crear-orden'
            );


        if (!boton) {

            return;

        }


        if (completos) {

            boton.disabled = false;

            boton.textContent =
                '✓ Crear orden';

        } else {

            boton.disabled = true;

            boton.textContent =
                'Revisar productos';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPAR HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ?? '';


        return div.innerHTML;

    }


    /*
    |--------------------------------------------------------------------------
    | TIPO DE ORDEN
    |--------------------------------------------------------------------------
    */

    const tipoOrden =
        document.getElementById(
            'tipoOrdenPdf'
        );

    if (tipoOrden) {

        tipoOrden.addEventListener(
            'change',
            verificarProductos
        );

    }


    /*
    |--------------------------------------------------------------------------
    | INICIO
    |--------------------------------------------------------------------------
    */

    verificarProductos();


})();

</script>

@endsection