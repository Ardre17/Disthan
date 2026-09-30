@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       IMPORTAR PEDIDO PDF
    ========================================================= */

    .pdf-import-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        color: #1f2937;
        font-family: Arial, Helvetica, sans-serif;
    }

    .pdf-import-title {
        margin-bottom: 25px;
    }

    .pdf-import-title h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .pdf-import-title p {
        margin: 7px 0 0;
        color: #6b7280;
        font-size: 14px;
    }


    /* =========================================================
       ALERTAS
    ========================================================= */

    .pdf-alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid;
    }

    .pdf-alert-success {
        background: #ecfdf5;
        border-color: #a7f3d0;
        color: #065f46;
    }

    .pdf-alert-danger {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    .pdf-alert-info {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1e40af;
    }

    .pdf-alert-title {
        font-weight: 700;
        margin-bottom: 5px;
    }


    /* =========================================================
       TARJETAS
    ========================================================= */

    .pdf-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
        margin-bottom: 22px;
        overflow: hidden;
    }

    .pdf-card-body {
        padding: 24px;
    }

    .pdf-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .pdf-card-header h2 {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
    }

    .pdf-card-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 13px;
    }


    /* =========================================================
       DATOS PEDIDO
    ========================================================= */

    .pdf-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }

    .pdf-info-label {
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .pdf-info-value {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }


    /* =========================================================
       TABLA
    ========================================================= */

    .pdf-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .pdf-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px;
    }

    .pdf-table thead {
        background: #f8fafc;
    }

    .pdf-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .pdf-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #eef0f3;
        vertical-align: middle;
        font-size: 13px;
    }

    .pdf-table tbody tr:hover {
        background: #fafafa;
    }

    .pdf-code {
        font-weight: 700;
        color: #111827;
    }

    .pdf-product-name {
        font-weight: 600;
        color: #111827;
    }

    .pdf-product-sku {
        margin-top: 4px;
        font-size: 11px;
        color: #6b7280;
    }

    .pdf-price {
        font-weight: 700;
        text-align: right;
        white-space: nowrap;
    }

    .pdf-total {
        color: #6b7280;
        text-align: right;
        white-space: nowrap;
    }

    .pdf-center {
        text-align: center !important;
    }


    /* =========================================================
       ESTADOS
    ========================================================= */

    .pdf-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .pdf-status-code {
        background: #dcfce7;
        color: #166534;
    }

    .pdf-status-name {
        background: #fef3c7;
        color: #92400e;
    }

    .pdf-status-manual {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .pdf-status-none {
        background: #fee2e2;
        color: #b91c1c;
    }


    /* =========================================================
       BOTONES
    ========================================================= */

    .pdf-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 0;
        border-radius: 9px;
        padding: 9px 14px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .15s ease;
    }

    .pdf-btn-search {
        background: #f97316;
        color: white;
    }

    .pdf-btn-search:hover {
        background: #ea580c;
    }

    .pdf-btn-change {
        background: white;
        color: #2563eb;
        border: 1px solid #93c5fd;
    }

    .pdf-btn-change:hover {
        background: #eff6ff;
    }

    .pdf-btn-primary {
        background: #2563eb;
        color: white;
        padding: 12px 22px;
        font-size: 14px;
    }

    .pdf-btn-primary:hover {
        background: #1d4ed8;
    }

    .pdf-btn-primary:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    .pdf-btn-back {
        background: white;
        color: #374151;
        border: 1px solid #d1d5db;
        text-decoration: none;
        padding: 12px 22px;
        font-size: 14px;
    }

    .pdf-btn-back:hover {
        background: #f9fafb;
    }


    /* =========================================================
       TIPO DE ORDEN
    ========================================================= */

    .pdf-form-group {
        margin-top: 25px;
    }

    .pdf-form-label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
    }

    .pdf-select {
        width: 300px;
        max-width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: white;
        font-size: 14px;
        color: #374151;
    }


    /* =========================================================
       BOTONES FINALES
    ========================================================= */

    .pdf-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 22px;
    }


    /* =========================================================
       MODAL
    ========================================================= */

    #modal-producto {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0, 0, 0, .55);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    #modal-producto.pdf-modal-visible {
        display: flex;
    }

    .pdf-modal-box {
        width: 100%;
        max-width: 650px;
        max-height: 90vh;
        background: white;
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(0,0,0,.30);
        overflow: hidden;
        animation: pdfModalIn .15s ease-out;
    }

    @keyframes pdfModalIn {
        from {
            opacity: 0;
            transform: translateY(10px) scale(.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .pdf-modal-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pdf-modal-header h2 {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
    }

    .pdf-modal-header p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .pdf-modal-close {
        width: 35px;
        height: 35px;
        border: 0;
        border-radius: 8px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 18px;
        cursor: pointer;
    }

    .pdf-modal-close:hover {
        background: #e5e7eb;
    }

    .pdf-modal-body {
        padding: 22px;
    }

    .pdf-search-input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
    }

    .pdf-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }

    .pdf-results {
        margin-top: 15px;
        max-height: 400px;
        overflow-y: auto;
    }

    .pdf-result {
        width: 100%;
        box-sizing: border-box;
        text-align: left;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: .15s ease;
    }

    .pdf-result:hover {
        background: #eff6ff;
        border-color: #93c5fd;
    }

    .pdf-result-name {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .pdf-result-info {
        margin-top: 5px;
        font-size: 11px;
        color: #6b7280;
    }

    .pdf-search-message {
        text-align: center;
        color: #9ca3af;
        padding: 30px 10px;
        font-size: 13px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .pdf-import-page {
            padding: 18px;
        }

        .pdf-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 600px) {

        .pdf-import-page {
            padding: 12px;
        }

        .pdf-import-title h1 {
            font-size: 23px;
        }

        .pdf-info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .pdf-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .pdf-btn-back,
        .pdf-btn-primary {
            width: 100%;
        }

    }
</style>


<div class="pdf-import-page">

    {{-- =====================================================
         TITULO
    ====================================================== --}}

    <div class="pdf-import-title">

        <h1>
            Vista previa de importación
        </h1>

        <p>
            Revisa la información antes de crear la orden.
        </p>

    </div>


    {{-- =====================================================
         CLIENTE
    ====================================================== --}}

    @if($client)

        <div class="pdf-alert pdf-alert-success">

            <div class="pdf-alert-title">
                ✓ Cliente encontrado
            </div>

            <div>
                {{ $client->razon_social }}
                — RUC: {{ $client->ruc }}
            </div>

        </div>

    @else

        <div class="pdf-alert pdf-alert-danger">

            <div class="pdf-alert-title">
                ⚠ Cliente no encontrado
            </div>

            <div>
                RUC detectado:
                {{ $datos['ruc_cliente'] ?? '—' }}
            </div>

        </div>

    @endif


    {{-- =====================================================
         DATOS DEL PEDIDO
    ====================================================== --}}

    <div class="pdf-card">

        <div class="pdf-card-body">

            <h2 style="margin:0 0 22px;font-size:19px;">
                Datos del pedido
            </h2>


            <div class="pdf-info-grid">

                <div>

                    <div class="pdf-info-label">
                        Orden
                    </div>

                    <div class="pdf-info-value">
                        {{ $datos['numero_orden'] ?? '—' }}
                    </div>

                </div>


                <div>

                    <div class="pdf-info-label">
                        Fecha
                    </div>

                    <div class="pdf-info-value">
                        {{ $datos['fecha_pedido'] ?? '—' }}
                    </div>

                </div>


                <div>

                    <div class="pdf-info-label">
                        Entrega
                    </div>

                    <div class="pdf-info-value">
                        {{ $datos['fecha_entrega'] ?? '—' }}
                    </div>

                </div>


                <div>

                    <div class="pdf-info-label">
                        N.º interno
                    </div>

                    <div class="pdf-info-value">
                        {{ $datos['order_interna'] ?? '—' }}
                    </div>

                </div>

            </div>


            {{-- Tipo de orden solamente para la vista.
                 Lo conectamos al guardado después. --}}

            <div class="pdf-form-group">

                <label
                    class="pdf-form-label"
                    for="tipo_orden"
                >
                    Tipo de orden
                </label>

                <select
                    id="tipo_orden"
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

            <h2>
                Productos detectados
            </h2>

            <p>
                {{ count($datos['productos']) }}
                producto(s) encontrado(s) en el PDF.
            </p>

        </div>


        <div class="pdf-table-container">

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
                                        class="pdf-status pdf-status-code"
                                    >
                                        ✓ Código
                                    </span>

                                @else

                                    <span
                                        class="pdf-status pdf-status-name"
                                    >
                                        ⚠ Nombre
                                    </span>

                                @endif

                            @else

                                <span
                                    class="pdf-status pdf-status-none"
                                >
                                    ✕ No encontrado
                                </span>

                            @endif

                        </td>


                        {{-- CODIGO PDF --}}

                        <td>

                            <div class="pdf-code">
                                {{ $item['codigo'] }}
                            </div>

                        </td>


                        {{-- PRODUCTO PDF --}}

                        <td>

                            {{ $item['descripcion'] }}

                        </td>


                        {{-- PRODUCTO DISTAN --}}

                        <td class="producto-distan">

                            @if($item['encontrado'])

                                <div class="pdf-product-name">

                                    {{ $item['nombre_distan'] }}

                                </div>

                                <div class="pdf-product-sku">

                                    SKU:
                                    {{ $item['sku_distan'] ?? '—' }}

                                </div>

                            @else

                                <span style="color:#dc2626;">
                                    Producto no encontrado
                                </span>

                            @endif

                        </td>


                        {{-- CANTIDAD --}}

                        <td class="pdf-center">

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

                        <td class="pdf-price">

                            S/
                            {{ number_format(
                                $item['precio_unitario'],
                                2
                            ) }}

                        </td>


                        {{-- TOTAL PDF --}}

                        <td class="pdf-total">

                            S/
                            {{ number_format(
                                $item['total_pdf'],
                                2
                            ) }}

                        </td>


                        {{-- ACCION --}}

                        <td class="pdf-center">

                            <input
                                type="hidden"
                                value="{{ $item['product_id'] ?? '' }}"
                                id="product-id-{{ $loop->index }}"
                            >


                            @if($item['encontrado'])

                                <button
                                    type="button"
                                    class="pdf-btn pdf-btn-change"
                                    onclick="abrirBuscadorProducto({{ $loop->index }})"
                                >
                                    Cambiar
                                </button>

                            @else

                                <button
                                    type="button"
                                    class="pdf-btn pdf-btn-search"
                                    onclick="abrirBuscadorProducto({{ $loop->index }})"
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

    <div class="pdf-alert pdf-alert-info">

        <div class="pdf-alert-title">
            ℹ️ Vista previa
        </div>

        <div>

            El precio unitario será utilizado posteriormente
            por DISTAN para realizar los cálculos.

            El total mostrado del PDF es solamente informativo
            y no se utilizará como total de la orden.

        </div>

    </div>


    {{-- =====================================================
         BOTONES
    ====================================================== --}}

    <div class="pdf-actions">

        <a
            href="{{ route('orders.importPdf') }}"
            class="pdf-btn pdf-btn-back"
        >
            ← Volver
        </a>


        <button
            type="button"
            id="btn-crear-orden"
            disabled
            class="pdf-btn pdf-btn-primary"
        >
            Revisar productos
        </button>

    </div>

</div>


{{-- =========================================================
     MODAL BUSCAR PRODUCTO
========================================================= --}}

<div id="modal-producto">

    <div class="pdf-modal-box">

        <div class="pdf-modal-header">

            <div>

                <h2>
                    Buscar producto
                </h2>

                <p>
                    Busca por nombre, SKU o código.
                </p>

            </div>


            <button
                type="button"
                class="pdf-modal-close"
                onclick="cerrarBuscadorProducto()"
            >
                ×
            </button>

        </div>


        <div class="pdf-modal-body">

            <input
                type="text"
                id="producto-busqueda"
                class="pdf-search-input"
                placeholder="Ej. Palmitos, PL800..."
                autocomplete="off"
            >


            <div
                id="resultados-productos"
                class="pdf-results"
            >

                <div class="pdf-search-message">
                    Escribe para buscar...
                </div>

            </div>

        </div>

    </div>

</div>


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
        document.getElementById('modal-producto');

    const input =
        document.getElementById('producto-busqueda');


    modal.classList.add(
        'pdf-modal-visible'
    );


    input.value = '';

    input.focus();


    document.getElementById(
        'resultados-productos'
    ).innerHTML = `
        <div class="pdf-search-message">
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
        document.getElementById('modal-producto');


    modal.classList.remove(
        'pdf-modal-visible'
    );


    filaProductoActual = null;
}


/*
|--------------------------------------------------------------------------
| CERRAR AL HACER CLICK FUERA
|--------------------------------------------------------------------------
*/

document
    .getElementById('modal-producto')
    .addEventListener(
        'click',
        function(event) {

            if (
                event.target === this
            ) {

                cerrarBuscadorProducto();

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
    function(event) {

        if (
            event.key === 'Escape'
        ) {

            cerrarBuscadorProducto();

        }

    }
);


/*
|--------------------------------------------------------------------------
| BUSCAR AL ESCRIBIR
|--------------------------------------------------------------------------
*/

document
    .getElementById('producto-busqueda')
    .addEventListener(
        'input',
        function() {

            clearTimeout(
                temporizadorBusqueda
            );


            const q =
                this.value.trim();


            if (
                q.length < 2
            ) {

                document.getElementById(
                    'resultados-productos'
                ).innerHTML = `
                    <div class="pdf-search-message">
                        Escribe al menos 2 caracteres...
                    </div>
                `;

                return;

            }


            temporizadorBusqueda =
                setTimeout(
                    function() {

                        buscarProductos(q);

                    },
                    300
                );

        }
    );


/*
|--------------------------------------------------------------------------
| CONSULTAR LARAVEL
|--------------------------------------------------------------------------
*/

async function buscarProductos(q)
{
    const contenedor =
        document.getElementById(
            'resultados-productos'
        );


    contenedor.innerHTML = `
        <div class="pdf-search-message">
            Buscando...
        </div>
    `;


    try {

        const response =
            await fetch(
                `{{ route('orders.importPdf.productSearch') }}?q=${encodeURIComponent(q)}`,
                {
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );


        if (!response.ok) {

            throw new Error(
                'HTTP ' + response.status
            );

        }


        const productos =
            await response.json();


        if (
            !productos.length
        ) {

            contenedor.innerHTML = `
                <div class="pdf-search-message"
                     style="color:#dc2626;">
                    No se encontraron productos.
                </div>
            `;

            return;

        }


        contenedor.innerHTML =
            productos.map(
                function(producto) {

                    return `

                        <button
                            type="button"
                            class="pdf-result"
                            onclick='seleccionarProducto(${JSON.stringify(producto)})'
                        >

                            <div class="pdf-result-name">
                                ${escapeHtml(
                                    producto.nombre
                                )}
                            </div>

                            <div class="pdf-result-info">

                                SKU:
                                ${escapeHtml(
                                    producto.sku ?? '—'
                                )}

                                &nbsp; | &nbsp;

                                Barcode:
                                ${escapeHtml(
                                    producto.barcode ?? '—'
                                )}

                                ${
                                    producto.box_barcode
                                    ? `
                                        &nbsp; | &nbsp;
                                        Caja:
                                        ${escapeHtml(
                                            producto.box_barcode
                                        )}
                                      `
                                    : ''
                                }

                            </div>

                        </button>

                    `;

                }
            ).join('');


    } catch(error) {

        console.error(
            'Error buscando productos:',
            error
        );


        contenedor.innerHTML = `
            <div class="pdf-search-message"
                 style="color:#dc2626;">
                Error al buscar productos.
                <br>
                <small>
                    Revisa la consola del navegador.
                </small>
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
     * Guardar ID en la fila
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
         * Producto DISTAN
         */

        const productoDistan =
            fila.querySelector(
                '.producto-distan'
            );


        if (productoDistan) {

            productoDistan.innerHTML = `

                <div class="pdf-product-name">

                    ${escapeHtml(
                        producto.nombre
                    )}

                </div>

                <div class="pdf-product-sku">

                    SKU:
                    ${escapeHtml(
                        producto.sku ?? '—'
                    )}

                </div>

            `;

        }


        /*
         * Estado
         */

        const estado =
            fila.querySelector(
                '.estado-producto'
            );


        if (estado) {

            estado.innerHTML = `

                <span
                    class="pdf-status
                           pdf-status-manual"
                >
                    ✓ Manual
                </span>

            `;

        }


        /*
         * Cambiar botón
         */

        const boton =
            fila.querySelector(
                'button.pdf-btn'
            );


        if (boton) {

            boton.textContent =
                'Cambiar';

            boton.className =
                'pdf-btn pdf-btn-change';

        }

    }


    cerrarBuscadorProducto();


    verificarProductos();
}


/*
|--------------------------------------------------------------------------
| VERIFICAR PRODUCTOS
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
            function(input) {

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
            'Revisar productos