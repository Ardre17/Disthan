@extends('layouts.app')

@section('content')

<div class="validation-page">

    {{-- =========================================================
         ENCABEZADO
    ========================================================== --}}
    <div class="validation-header">

        <div class="validation-title">

            <div class="validation-title-icon">
                <i class="bi bi-clipboard2-check"></i>
            </div>

            <div>
                <h1>Validación de Pedidos</h1>

                <p>
                    Verifica los productos recibidos contra el pedido.
                </p>
            </div>

        </div>

        <div class="validation-status-badge">
            <span class="status-dot"></span>
            Módulo de validación
        </div>

    </div>


    {{-- =========================================================
         BUSCADOR
    ========================================================== --}}
    <div class="validation-search-card">

        <div class="search-card-label">
            <i class="bi bi-search"></i>

            <div>
                <strong>Buscar pedido</strong>

                <span>
                    Ingresa el número de factura o guía asociada.
                </span>
            </div>
        </div>


        <div class="search-row">

            <div class="search-input-wrapper">

                <i class="bi bi-upc-scan"></i>

                <input
                    type="text"
                    id="codigoPedido"
                    placeholder="Factura o guía..."
                    autocomplete="off"
                    autofocus
                >

            </div>


            <button
                type="button"
                id="btnBuscarPedido"
                class="btn-search"
            >
                <i class="bi bi-search"></i>
                <span>BUSCAR PEDIDO</span>
            </button>

        </div>

        <div class="search-help">
            <i class="bi bi-info-circle"></i>
            También puedes presionar <strong>Enter</strong> después de ingresar el código.
        </div>

    </div>
    {{-- =========================================================
     PEDIDOS PENDIENTES + HISTORIAL
========================================================= --}}
<div class="validation-orders-section">

    {{-- =====================================================
         PEDIDOS PENDIENTES
    ====================================================== --}}
    <div class="validation-list-card">

        <div class="validation-list-header">

            <div class="validation-list-title">

                <div class="validation-list-icon pending">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div>
                    <strong>Pedidos pendientes de validar</strong>
                    <span>
                        Pedidos que todavía no tienen ninguna validación registrada.
                    </span>
                </div>

            </div>

            <span class="validation-count">
                {{ $pendientes->count() }}
            </span>

        </div>

        @if($pendientes->count())

            <div class="validation-table-wrapper">

                <table class="validation-list-table">

                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Guía</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pendientes as $pedido)

                            <tr>

                                <td>
                                    <span class="validation-order-number">
                                        {{ $pedido->numero_orden ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="validation-client-name">
                                        {{ $pedido->client->razon_social
                                            ?? $pedido->client->nombre_comercial
                                            ?? 'Sin cliente' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $pedido->factura_asociada ?? '-' }}
                                </td>

                                <td>
                                    {{ $pedido->guia_asociada ?? '-' }}
                                </td>

                                <td>
                                    {{ $pedido->fecha_pedido
                                        ? \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y')
                                        : '-' }}
                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="validation-row-button open"
                                        onclick="abrirPedidoDesdeLista({{ $pedido->id }})"
                                    >
                                        <i class="bi bi-play-fill"></i>
                                        VALIDAR
                                    </button>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="validation-empty">

                <i class="bi bi-check-circle"></i>

                <strong>No hay pedidos pendientes</strong>

                <div>
                    Todos los pedidos registrados ya tienen una validación.
                </div>

            </div>

        @endif

    </div>


    {{-- =====================================================
         HISTORIAL
    ====================================================== --}}
    <div class="validation-list-card">

        <div class="validation-list-header">

            <div class="validation-list-title">

                <div class="validation-list-icon history">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>
                    <strong>Historial de validaciones</strong>
                    <span>
                        Registro de todas las validaciones realizadas.
                    </span>
                </div>

            </div>

            <span class="validation-count">
                {{ $historial->count() }}
            </span>

        </div>

        @if($historial->count())

            <div class="validation-table-wrapper">

                <table class="validation-list-table">

                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Fecha validación</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($historial as $validacion)

                            @php
                                $pedidoHistorial = $validacion->order;
                                $estadoHistorial = $validacion->estado;
                            @endphp

                            <tr>

                                <td>
                                    <span class="validation-order-number">
                                        {{ $pedidoHistorial->numero_orden ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="validation-client-name">
                                        {{ $pedidoHistorial->client->razon_social
                                            ?? $pedidoHistorial->client->nombre_comercial
                                            ?? 'Sin cliente' }}
                                    </span>
                                </td>

                                <td>

                                    <span class="validation-status
                                        {{ strtolower(str_replace('_', '-', $estadoHistorial)) }}"
                                    >
                                        {{ $estadoHistorial }}
                                    </span>

                                </td>

                                <td>
                                    {{ $validacion->fecha_validacion
                                        ? \Carbon\Carbon::parse($validacion->fecha_validacion)->format('d/m/Y H:i')
                                        : '-' }}
                                </td>

                                <td>
                                    {{ $validacion->usuario->name ?? 'Sistema' }}
                                </td>

                                <td>

                                    <div class="validation-row-actions">

                                        <button
                                            type="button"
                                            class="validation-row-button history"
                                            onclick="verHistorialPedido({{ $pedidoHistorial->id }})"
                                        >
                                            <i class="bi bi-clock-history"></i>
                                            HISTORIAL
                                        </button>

                                        <button
                                            type="button"
                                            class="validation-row-button revalidate"
                                            onclick="abrirPedidoDesdeLista({{ $pedidoHistorial->id }})"
                                        >
                                            <i class="bi bi-arrow-repeat"></i>
                                            REVALIDAR
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="validation-empty">

                <i class="bi bi-clock-history"></i>

                <strong>Sin historial</strong>

                <div>
                    Todavía no se ha realizado ninguna validación.
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL HISTORIAL
========================================================= --}}
<div
    id="validationHistoryModal"
    class="validation-history-modal d-none"
>

    <div class="validation-history-dialog">

        <div class="validation-history-dialog-header">

            <strong id="validationHistoryTitle">
                Historial del pedido
            </strong>

            <button
                type="button"
                class="validation-history-close"
                onclick="cerrarHistorialPedido()"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

        <div
            id="validationHistoryBody"
            class="validation-history-dialog-body"
        >

            <div class="validation-empty">
                <i class="bi bi-arrow-repeat"></i>
                Cargando historial...
            </div>

        </div>

    </div>

</div>

    {{-- =========================================================
         INFORMACIÓN DEL PEDIDO
    ========================================================== --}}
    <div
        id="pedidoInfo"
        class="order-info-card d-none"
    >

        <div class="order-info-main">

            <div class="order-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <div class="order-main-text">

                <span class="order-label">
                    PEDIDO
                </span>

                <strong id="pedidoNumero">
                    -
                </strong>

            </div>

        </div>


        <div class="order-info-item">

            <span>CLIENTE</span>

            <strong id="pedidoCliente">
                -
            </strong>

        </div>


        <div class="order-info-item">

            <span>FACTURA</span>

            <strong id="pedidoFactura">
                -
            </strong>

        </div>


        <div class="order-info-item">

            <span>GUÍA</span>

            <strong id="pedidoGuia">
                -
            </strong>

        </div>

    </div>


    {{-- =========================================================
         MODALIDADES
    ========================================================== --}}
    <div
        id="modalidades"
        class="modalities-section d-none"
    >

        <div class="section-heading">

            <div>
                <h2>¿Cómo deseas validar?</h2>

                <p>
                    Selecciona el método que utilizarás para verificar este pedido.
                </p>
            </div>

        </div>


        <div class="modalities-grid">


            {{-- =================================================
                 ITEM POR ITEM
            ================================================== --}}
            <div class="modality-card modality-blue">

                <div class="modality-top">

                    <div class="modality-icon">
                        <i class="bi bi-list-check"></i>
                    </div>

                    <span class="modality-number">
                        01
                    </span>

                </div>


                <h3>
                    ITEM POR ITEM
                </h3>

                <p>
                    Revisa cada producto individualmente y define
                    si fue recibido completo, parcialmente o no enviado.
                </p>


                <div class="modality-features">

                    <span>
                        <i class="bi bi-check2"></i>
                        Un producto a la vez
                    </span>

                    <span>
                        <i class="bi bi-check2"></i>
                        Avance automático
                    </span>

                    <span>
                        <i class="bi bi-check2"></i>
                        Cantidad parcial
                    </span>

                </div>


                <button
                    type="button"
                    id="btnModoItem"
                    class="modality-button"
                >
                    INICIAR VALIDACIÓN
                    <i class="bi bi-arrow-right"></i>
                </button>

            </div>


            {{-- =================================================
                 ESCÁNER
            ================================================== --}}
            <div class="modality-card modality-green">

                <div class="modality-top">

                    <div class="modality-icon">
                        <i class="bi bi-upc-scan"></i>
                    </div>

                    <span class="modality-number">
                        02
                    </span>

                </div>


                <h3>
                    ESCÁNER
                </h3>

                <p>
                    Escanea los productos mediante código de barras
                    utilizando un lector físico o dispositivo compatible.
                </p>


                <div class="modality-features">

                    <span>
                        <i class="bi bi-check2"></i>
                        Código de producto
                    </span>

                    <span>
                        <i class="bi bi-check2"></i>
                        Código de caja
                    </span>

                    <span>
                        <i class="bi bi-check2"></i>
                        Validación inmediata
                    </span>

                </div>


                <button
                    type="button"
                    id="btnModoScanner"
                    class="modality-button"
                >
                    INICIAR ESCÁNER
                    <i class="bi bi-arrow-right"></i>
                </button>

            </div>


            {{-- =================================================
                 PEDIDO COMPLETO
            ================================================== --}}
            <div class="modality-card modality-orange">

                <div class="modality-top">

                    <div class="modality-icon">
                        <i class="bi bi-boxes"></i>
                    </div>

                    <span class="modality-number">
                        03
                    </span>

                </div>


                <h3>
                    PEDIDO COMPLETO
                </h3>

                <p>
                    Visualiza todos los productos del pedido
                    y define su estado desde una sola pantalla.
                </p>


                <div class="modality-features">

                    <span>
                        <i class="bi bi-check2"></i>
                        Todos los productos
                    </span>

                    <span>
                        <i class="bi bi-check2"></i>
                        Estado individual
                    </span>

                    <span>
                        <i class="bi bi-check2"></i>
                        Guardado completo
                    </span>

                </div>


                <button
                    type="button"
                    id="btnModoCompleto"
                    class="modality-button"
                >
                    VALIDAR PEDIDO
                    <i class="bi bi-arrow-right"></i>
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PANEL ITEM POR ITEM
    ========================================================== --}}
    <div
        id="panelItem"
        class="validation-panel d-none"
    >

        <div class="panel-header panel-blue">

            <div class="panel-header-left">

                <div class="panel-icon">
                    <i class="bi bi-list-check"></i>
                </div>

                <div>
                    <span>VALIDACIÓN</span>
                    <strong>ITEM POR ITEM</strong>
                </div>

            </div>


            <div class="progress-counter">

                <span id="contadorItem">
                    0 / 0
                </span>

            </div>

        </div>


        <div class="panel-body">

            <div class="item-progress">

                <div class="progress-line">

                    <div
                        id="itemProgressBar"
                        class="progress-line-fill progress-blue"
                    ></div>

                </div>

            </div>


            <div
                id="itemActual"
                class="item-validation-content"
            >

                <div class="product-main-icon">
                    <i class="bi bi-box-seam"></i>
                </div>


                <div class="product-information">

                    <span class="product-overline">
                        PRODUCTO A VALIDAR
                    </span>

                    <h2 id="itemNombre">
                        -
                    </h2>

                    <div
                        id="itemMarca"
                        class="product-brand"
                    >
                        -
                    </div>

                </div>


                <div class="product-data-grid">

                    <div class="product-data-box">

                        <span>
                            CANTIDAD DESPACHADO
                        </span>

                        <strong id="itemCantidadSolicitada">
                            0
                        </strong>

                    </div>


                    <div class="product-data-box">

                        <span>
                            CÓDIGO
                        </span>

                        <strong
                            id="itemCodigo"
                            class="product-code"
                        >
                            -
                        </strong>

                    </div>

                </div>


                {{-- CANTIDAD PARCIAL --}}
                <div
                    id="itemCantidadParcial"
                    class="partial-quantity-box d-none"
                >

                    <div>

                        <span>
                            VALIDACIÓN PARCIAL
                        </span>

                        <strong>
                            ¿Cuánto recibiste?
                        </strong>

                    </div>

                    <input
                        type="number"
                        id="cantidadItem"
                        min="0"
                        step="0.01"
                        placeholder="0"
                    >

                </div>


                <div class="validation-actions">

                    <button
                        type="button"
                        id="btnItemIncompleto"
                        class="validation-action action-danger"
                    >
                        <i class="bi bi-x-circle"></i>

                        <span>
                            <strong>NO ENVIADO</strong>
                            <small>No se recibió</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnItemParcial"
                        class="validation-action action-warning"
                    >
                        <i class="bi bi-dash-circle"></i>

                        <span>
                            <strong>PARCIAL</strong>
                            <small>Recibido parcialmente</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnItemCompleto"
                        class="validation-action action-success"
                    >
                        <i class="bi bi-check-circle"></i>

                        <span>
                            <strong>COMPLETO</strong>
                            <small>Recibido completo</small>
                        </span>

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PANEL ESCÁNER
    ========================================================== --}}
    <div
        id="panelScanner"
        class="validation-panel d-none"
    >

        <div class="panel-header panel-green">

            <div class="panel-header-left">

                <div class="panel-icon">
                    <i class="bi bi-upc-scan"></i>
                </div>

                <div>
                    <span>VALIDACIÓN</span>
                    <strong>ESCÁNER</strong>
                </div>

            </div>


            <div class="progress-counter">

                <span id="contadorScanner">
                    0 / 0
                </span>

            </div>

        </div>


        <div class="panel-body scanner-body">

            <div class="scanner-instruction">

                <div class="scanner-large-icon">
                    <i class="bi bi-upc-scan"></i>
                </div>

                <h2>
                    Escanea el producto
                </h2>

                <p>
                    Utiliza el lector de códigos o escribe el código manualmente.
                </p>

            </div>


            <div class="scanner-input-wrapper">

                <i class="bi bi-upc"></i>

                <input
                    type="text"
                    id="codigoScanner"
                    placeholder="Esperando código..."
                    autocomplete="off"
                >

            </div>


            <div class="scanner-help">

                <span>
                    <i class="bi bi-check-circle"></i>
                    Código de producto
                </span>

                <span>
                    <i class="bi bi-box-seam"></i>
                    Código de caja
                </span>

            </div>


            {{-- PRODUCTO ENCONTRADO --}}
            <div
                id="scannerProducto"
                class="scanner-product-card d-none"
            >

                <div class="scanner-product-icon">
                    <i class="bi bi-box-seam"></i>
                </div>


                <div class="scanner-product-info">

                    <span>
                        PRODUCTO ENCONTRADO
                    </span>

                    <h2 id="scannerNombre">
                        -
                    </h2>

                    <p id="scannerMarca">
                        -
                    </p>

                </div>


                <div class="scanner-product-data">

                    <div>
                        <span>DESPACHADO</span>

                        <strong id="scannerSolicitado">
                            0
                        </strong>
                    </div>

                    <div>
                        <span>CÓDIGO</span>

                        <strong id="scannerCodigo">
                            -
                        </strong>
                    </div>

                </div>


                {{-- CANTIDAD PARCIAL --}}
                <div
                    id="scannerCantidadParcial"
                    class="partial-quantity-box d-none"
                >

                    <div>

                        <span>
                            VALIDACIÓN PARCIAL
                        </span>

                        <strong>
                            ¿Cuánto recibiste?
                        </strong>

                    </div>

                    <input
                        type="number"
                        id="cantidadScanner"
                        min="0"
                        step="0.01"
                        placeholder="0"
                    >

                </div>


                <div class="validation-actions">

                    <button
                        type="button"
                        id="btnScannerIncompleto"
                        class="validation-action action-danger"
                    >
                        <i class="bi bi-x-circle"></i>

                        <span>
                            <strong>NO ENVIADO</strong>
                            <small>No se recibió</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnScannerParcial"
                        class="validation-action action-warning"
                    >
                        <i class="bi bi-dash-circle"></i>

                        <span>
                            <strong>PARCIAL</strong>
                            <small>Recibido parcialmente</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnScannerCompleto"
                        class="validation-action action-success"
                    >
                        <i class="bi bi-check-circle"></i>

                        <span>
                            <strong>COMPLETO</strong>
                            <small>Recibido completo</small>
                        </span>

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PANEL PEDIDO COMPLETO
    ========================================================== --}}
    <div
        id="panelCompleto"
        class="validation-panel d-none"
    >

        <div class="panel-header panel-orange">

            <div class="panel-header-left">

                <div class="panel-icon">
                    <i class="bi bi-boxes"></i>
                </div>

                <div>
                    <span>VALIDACIÓN</span>
                    <strong>PEDIDO COMPLETO</strong>
                </div>

            </div>


            <div class="progress-counter">

                <span id="contadorCompleto">
                    0 / 0
                </span>

            </div>

        </div>


        <div class="panel-body">

            <div class="table-wrapper">

                <table class="validation-table">

                    <thead>

                        <tr>

                            <th>
                                PRODUCTO
                            </th>

                            <th>
                                CÓDIGO
                            </th>

                            <th class="text-center">
                                DESPACHADO
                            </th>

                            <th class="text-center">
                                VALIDADO
                            </th>

                            <th class="text-center">
                                ESTADO
                            </th>

                        </tr>

                    </thead>

                    <tbody id="tablaValidacion">

                    </tbody>

                </table>

            </div>


            <div class="complete-footer">

                <div class="observation-box">

                    <label for="observacionesValidacion">
                        <i class="bi bi-chat-left-text"></i>
                        OBSERVACIONES
                    </label>

                    <textarea
                        id="observacionesValidacion"
                        rows="3"
                        placeholder="Agrega una observación si es necesario..."
                    ></textarea>

                </div>


                <button
                    type="button"
                    id="btnGuardarValidacion"
                    class="save-validation-button"
                >
                    <i class="bi bi-check-circle"></i>

                    <span>
                        GUARDAR VALIDACIÓN
                    </span>
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
         ALERTA
    ========================================================== --}}
    <div
        id="alertaValidacion"
        class="validation-alert d-none"
    ></div>

</div>


{{-- =============================================================
     ESTILOS
============================================================= --}}
<style>

    /* =========================================================
       BASE
    ========================================================= */

    .validation-page {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding: 28px 30px 50px;
        color: #1e293b;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .validation-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .validation-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .validation-title-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .validation-title h1 {
        margin: 0;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .validation-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .validation-status-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 13px;
        border-radius: 30px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22c55e;
    }


    /* =========================================================
       BUSCADOR
    ========================================================= */

    .validation-search-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 21px;
        margin-bottom: 28px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
    }

    .search-card-label {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .search-card-label > i {
        width: 37px;
        height: 37px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .search-card-label div {
        display: flex;
        flex-direction: column;
    }

    .search-card-label strong {
        font-size: 14px;
        color: #0f172a;
    }

    .search-card-label span {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .search-row {
        display: flex;
        gap: 10px;
    }

    .search-input-wrapper {
        flex: 1;
        height: 53px;
        display: flex;
        align-items: center;
        border: 2px solid #e2e8f0;
        border-radius: 11px;
        background: #f8fafc;
        transition: .2s ease;
    }

    .search-input-wrapper:focus-within {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .search-input-wrapper > i {
        margin-left: 17px;
        color: #94a3b8;
        font-size: 19px;
    }

    .search-input-wrapper input {
        width: 100%;
        height: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 0 16px;
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
    }

    .search-input-wrapper input::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .btn-search {
        min-width: 175px;
        border: 0;
        border-radius: 11px;
        background: #2563eb;
        color: #ffffff;
        font-weight: 700;
        font-size: 13px;
        padding: 0 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-search:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-search:disabled {
        opacity: .7;
        cursor: wait;
        transform: none;
    }

    .search-help {
        margin-top: 9px;
        font-size: 11px;
        color: #94a3b8;
    }

    .search-help i {
        margin-right: 4px;
    }


    /* =========================================================
       INFORMACIÓN PEDIDO
    ========================================================= */

    .order-info-card {
        display: grid;
        grid-template-columns: 1.5fr 1.5fr 1fr 1fr;
        gap: 0;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 28px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
    }

    .order-info-main {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 19px 21px;
    }

    .order-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .order-main-text {
        display: flex;
        flex-direction: column;
    }

    .order-label {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .order-main-text strong {
        margin-top: 3px;
        font-size: 16px;
        color: #0f172a;
    }

    .order-info-item {
        min-height: 57px;
        border-left: 1px solid #e2e8f0;
        padding: 10px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .order-info-item span {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .order-info-item strong {
        color: #334155;
        font-size: 13px;
        margin-top: 3px;
        word-break: break-word;
    }


    /* =========================================================
       MODALIDADES
    ========================================================= */

    .section-heading {
        margin-bottom: 15px;
    }

    .section-heading h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .section-heading p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .modalities-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 17px;
        margin-bottom: 28px;
    }

    .modality-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
        transition: .2s ease;
    }

    .modality-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 24px rgba(15, 23, 42, .09);
    }

    .modality-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .modality-blue::before {
        background: #2563eb;
    }

    .modality-green::before {
        background: #16a34a;
    }

    .modality-orange::before {
        background: #f59e0b;
    }

    .modality-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modality-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .modality-blue .modality-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .modality-green .modality-icon {
        background: #f0fdf4;
        color: #16a34a;
    }

    .modality-orange .modality-icon {
        background: #fffbeb;
        color: #d97706;
    }

    .modality-number {
        color: #cbd5e1;
        font-size: 22px;
        font-weight: 800;
    }

    .modality-card h3 {
        margin: 17px 0 7px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
    }

    .modality-card p {
        min-height: 55px;
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.55;
    }

    .modality-features {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin: 17px 0;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .modality-features span {
        color: #64748b;
        font-size: 11px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .modality-blue .modality-features i {
        color: #2563eb;
    }

    .modality-green .modality-features i {
        color: #16a34a;
    }

    .modality-orange .modality-features i {
        color: #d97706;
    }

    .modality-button {
        width: 100%;
        height: 43px;
        border: 0;
        border-radius: 9px;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: .2s ease;
    }

    .modality-blue .modality-button {
        background: #2563eb;
    }

    .modality-blue .modality-button:hover {
        background: #1d4ed8;
    }

    .modality-green .modality-button {
        background: #16a34a;
    }

    .modality-green .modality-button:hover {
        background: #15803d;
    }

    .modality-orange .modality-button {
        background: #d97706;
    }

    .modality-orange .modality-button:hover {
        background: #b45309;
    }


    /* =========================================================
       PANELES
    ========================================================= */

    .validation-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .06);
        margin-bottom: 25px;
    }

    .panel-header {
        min-height: 69px;
        padding: 13px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #ffffff;
    }

    .panel-blue {
        background: #2563eb;
    }

    .panel-green {
        background: #16a34a;
    }

    .panel-orange {
        background: #d97706;
    }

    .panel-header-left {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .panel-icon {
        width: 39px;
        height: 39px;
        border-radius: 10px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .panel-header-left div:last-child {
        display: flex;
        flex-direction: column;
    }

    .panel-header-left span {
        font-size: 9px;
        opacity: .75;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .panel-header-left strong {
        margin-top: 2px;
        font-size: 14px;
        font-weight: 800;
    }

    .progress-counter {
        padding: 7px 12px;
        border-radius: 20px;
        background: rgba(255,255,255,.15);
        font-size: 12px;
        font-weight: 800;
    }

    .panel-body {
        padding: 24px;
    }


    /* =========================================================
       PROGRESO ITEM
    ========================================================= */

    .item-progress {
        margin-bottom: 22px;
    }

    .progress-line {
        height: 6px;
        width: 100%;
        border-radius: 20px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-line-fill {
        height: 100%;
        width: 0%;
        border-radius: inherit;
        transition: width .25s ease;
    }

    .progress-blue {
        background: #2563eb;
    }


    /* =========================================================
       ITEM
    ========================================================= */

    .item-validation-content {
        max-width: 920px;
        margin: 0 auto;
        text-align: center;
    }

    .product-main-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 13px;
        border-radius: 18px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .product-overline {
        color: #94a3b8;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .product-information h2 {
        margin: 6px 0 2px;
        color: #0f172a;
        font-size: 23px;
        font-weight: 800;
    }

    .product-brand {
        color: #64748b;
        font-size: 13px;
    }

    .product-data-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        max-width: 600px;
        margin: 22px auto;
    }

    .product-data-box {
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .product-data-box span {
        color: #94a3b8;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .product-data-box strong {
        color: #0f172a;
        font-size: 23px;
        font-weight: 800;
    }

    .product-code {
        font-size: 13px !important;
        word-break: break-all;
    }


    /* =========================================================
       CANTIDAD PARCIAL
    ========================================================= */

    .partial-quantity-box {
        max-width: 600px;
        margin: 0 auto 18px;
        padding: 14px;
        border-radius: 12px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        text-align: left;
    }

    .partial-quantity-box > div {
        display: flex;
        flex-direction: column;
    }

    .partial-quantity-box span {
        color: #b45309;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .6px;
    }

    .partial-quantity-box strong {
        margin-top: 3px;
        color: #92400e;
        font-size: 12px;
    }

    .partial-quantity-box input {
        width: 140px;
        height: 46px;
        border: 2px solid #f59e0b;
        border-radius: 9px;
        outline: none;
        text-align: center;
        font-size: 18px;
        font-weight: 800;
        background: #ffffff;
    }

    .partial-quantity-box input:focus {
        box-shadow: 0 0 0 4px rgba(245, 158, 11, .12);
    }


    /* =========================================================
       BOTONES VALIDACIÓN
    ========================================================= */

    .validation-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 18px;
    }

    .validation-action {
        min-height: 72px;
        border-radius: 11px;
        border: 2px solid;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: .18s ease;
    }

    .validation-action > i {
        font-size: 25px;
    }

    .validation-action span {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .validation-action strong {
        font-size: 12px;
        font-weight: 800;
    }

    .validation-action small {
        margin-top: 2px;
        font-size: 9px;
        opacity: .7;
    }

    .action-danger {
        color: #dc2626;
        border-color: #fecaca;
    }

    .action-danger:hover {
        background: #fef2f2;
        border-color: #ef4444;
    }

    .action-warning {
        color: #d97706;
        border-color: #fde68a;
    }

    .action-warning:hover {
        background: #fffbeb;
        border-color: #f59e0b;
    }

    .action-success {
        color: #16a34a;
        border-color: #bbf7d0;
    }

    .action-success:hover {
        background: #f0fdf4;
        border-color: #22c55e;
    }

    .validation-action:disabled {
        opacity: .5;
        cursor: not-allowed;
    }


    /* =========================================================
       ESCÁNER
    ========================================================= */

    .scanner-body {
        min-height: 500px;
    }

    .scanner-instruction {
        text-align: center;
        margin-bottom: 18px;
    }

    .scanner-large-icon {
        width: 75px;
        height: 75px;
        margin: 0 auto 12px;
        border-radius: 20px;
        background: #f0fdf4;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }

    .scanner-instruction h2 {
        margin: 0;
        color: #0f172a;
        font-size: 21px;
        font-weight: 800;
    }

    .scanner-instruction p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .scanner-input-wrapper {
        max-width: 700px;
        height: 62px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        border: 3px solid #16a34a;
        border-radius: 13px;
        background: #f0fdf4;
        box-shadow: 0 0 0 5px rgba(22,163,74,.07);
    }

    .scanner-input-wrapper > i {
        margin-left: 20px;
        color: #16a34a;
        font-size: 22px;
    }

    .scanner-input-wrapper input {
        width: 100%;
        height: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 0 18px;
        color: #14532d;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
    }

    .scanner-input-wrapper input::placeholder {
        color: #86efac;
        font-weight: 500;
    }

    .scanner-help {
        max-width: 700px;
        margin: 10px auto 22px;
        display: flex;
        justify-content: center;
        gap: 20px;
        color: #94a3b8;
        font-size: 10px;
    }

    .scanner-help span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .scanner-help i {
        color: #16a34a;
    }

    .scanner-product-card {
        max-width: 900px;
        margin: 0 auto;
        padding: 19px;
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        background: #f0fdf4;
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 15px;
    }

    .scanner-product-icon {
        width: 55px;
        height: 55px;
        border-radius: 13px;
        background: #dcfce7;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .scanner-product-info > span {
        color: #16a34a;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .7px;
    }

    .scanner-product-info h2 {
        margin: 3px 0 1px;
        color: #14532d;
        font-size: 18px;
        font-weight: 800;
    }

    .scanner-product-info p {
        margin: 0;
        color: #64748b;
        font-size: 11px;
    }

    .scanner-product-data {
        display: flex;
        gap: 25px;
    }

    .scanner-product-data div {
        display: flex;
        flex-direction: column;
        text-align: right;
    }

    .scanner-product-data span {
        color: #94a3b8;
        font-size: 8px;
        font-weight: 800;
    }

    .scanner-product-data strong {
        color: #14532d;
        font-size: 17px;
        margin-top: 2px;
    }

    .scanner-product-card .partial-quantity-box {
        grid-column: 1 / -1;
        width: 100%;
        margin: 0;
    }

    .scanner-product-card .validation-actions {
        grid-column: 1 / -1;
        width: 100%;
        margin-top: 0;
    }


    /* =========================================================
       TABLA COMPLETA
    ========================================================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .validation-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .validation-table th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 13px 14px;
        color: #64748b;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .validation-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 12px;
        vertical-align: middle;
    }

    .validation-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .validation-table tbody tr:hover {
        background: #f8fafc;
    }

    .table-product-name {
        color: #0f172a;
        font-weight: 700;
        font-size: 12px;
    }

    .table-product-brand {
        margin-top: 2px;
        color: #94a3b8;
        font-size: 10px;
    }

    .table-code {
        color: #64748b;
        font-family: monospace;
        font-size: 11px;
    }

    .table-quantity {
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .validation-table input,
    .validation-table select {
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: #ffffff;
        outline: none;
        font-size: 11px;
    }

    .validation-table input {
        width: 120px;
        text-align: center;
        font-weight: 700;
    }

    .validation-table input:focus,
    .validation-table select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    .validation-table select {
        min-width: 135px;
        padding: 0 10px;
    }


    /* =========================================================
       FOOTER PEDIDO COMPLETO
    ========================================================= */

    .complete-footer {
        margin-top: 20px;
        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 15px;
        align-items: end;
    }

    .observation-box {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .observation-box label {
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .observation-box label i {
        margin-right: 4px;
    }

    .observation-box textarea {
        width: 100%;
        resize: vertical;
        min-height: 80px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        outline: none;
        padding: 11px;
        font-size: 12px;
    }

    .observation-box textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    .save-validation-button {
        height: 50px;
        border: 0;
        border-radius: 10px;
        background: #16a34a;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: .2s ease;
    }

    .save-validation-button:hover {
        background: #15803d;
        transform: translateY(-1px);
    }

    .save-validation-button:disabled {
        opacity: .7;
        cursor: wait;
        transform: none;
    }


    /* =========================================================
       ALERTA
    ========================================================= */

    .validation-alert {
        position: fixed;
        top: 20px;
        right: 25px;
        z-index: 9999;
        max-width: 430px;
        padding: 14px 18px;
        border-radius: 11px;
        box-shadow: 0 8px 25px rgba(15,23,42,.15);
        font-size: 12px;
        font-weight: 600;
    }

    .validation-alert.alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .validation-alert.alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .validation-alert.alert-warning {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }


    /* =========================================================
       RESPONSIVE TABLET
    ========================================================= */

    @media (max-width: 1100px) {

        .validation-page {
            padding: 22px 20px 40px;
        }

        .modalities-grid {
            grid-template-columns: 1fr;
        }

        .modality-card p {
            min-height: auto;
        }

        .order-info-card {
            grid-template-columns: 1fr 1fr;
        }

        .order-info-main {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0;
        }

        .order-info-item:nth-child(3) {
            border-left: 0;
        }

    }


    /* =========================================================
       RESPONSIVE MÓVIL
    ========================================================= */

    @media (max-width: 700px) {

        .validation-page {
            padding: 16px 12px 35px;
        }

        .validation-header {
            align-items: flex-start;
        }

        .validation-title-icon {
            width: 43px;
            height: 43px;
            font-size: 20px;
        }

        .validation-title h1 {
            font-size: 21px;
        }

        .validation-title p {
            font-size: 11px;
        }

        .validation-status-badge {
            display: none;
        }

        .validation-search-card {
            padding: 15px;
            border-radius: 13px;
        }

        .search-row {
            flex-direction: column;
        }

        .search-input-wrapper {
            height: 55px;
        }

        .btn-search {
            width: 100%;
            height: 50px;
        }

        .order-info-card {
            grid-template-columns: 1fr;
        }

        .order-info-main {
            grid-column: auto;
        }

        .order-info-item {
            border-left: 0;
            border-top: 1px solid #e2e8f0;
        }

        .order-info-item:nth-child(3) {
            border-left: 0;
        }

        .modalities-grid {
            gap: 12px;
        }

        .modality-card {
            padding: 18px;
        }

        .panel-body {
            padding: 15px;
        }

        .panel-header {
            min-height: 61px;
            padding: 10px 13px;
        }

        .product-information h2 {
            font-size: 19px;
        }

        .product-data-grid {
            grid-template-columns: 1fr;
        }

        .validation-actions {
            grid-template-columns: 1fr;
        }

        .validation-action {
            min-height: 62px;
        }

        .partial-quantity-box {
            flex-direction: column;
            align-items: stretch;
        }

        .partial-quantity-box input {
            width: 100%;
        }

        .scanner-product-card {
            grid-template-columns: auto 1fr;
        }

        .scanner-product-data {
            grid-column: 1 / -1;
            justify-content: space-between;
        }

        .scanner-product-data div {
            text-align: left;
        }

        .complete-footer {
            grid-template-columns: 1fr;
        }

        .save-validation-button {
            width: 100%;
        }

    }
/* =========================================================
   PENDIENTES E HISTORIAL
========================================================= */

.validation-orders-section {
    margin-top: 24px;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.validation-list-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
}

.validation-list-header {
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #e2e8f0;
}

.validation-list-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.validation-list-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
}

.validation-list-icon.pending {
    background: #fff7ed;
    color: #ea580c;
}

.validation-list-icon.history {
    background: #eff6ff;
    color: #2563eb;
}

.validation-list-title strong {
    display: block;
    font-size: 16px;
    color: #0f172a;
}

.validation-list-title span {
    display: block;
    margin-top: 2px;
    font-size: 12px;
    color: #64748b;
}

.validation-count {
    min-width: 30px;
    height: 30px;
    padding: 0 9px;
    border-radius: 20px;
    background: #f1f5f9;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
}

.validation-table-wrapper {
    overflow-x: auto;
}

.validation-list-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

.validation-list-table th {
    padding: 11px 16px;
    text-align: left;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    white-space: nowrap;
}

.validation-list-table td {
    padding: 14px 16px;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13px;
    vertical-align: middle;
}

.validation-list-table tbody tr:hover {
    background: #f8fafc;
}

.validation-order-number {
    font-weight: 700;
    color: #0f172a;
}

.validation-client-name {
    color: #475569;
}

.validation-empty {
    padding: 35px 20px;
    text-align: center;
    color: #94a3b8;
}

.validation-empty i {
    display: block;
    font-size: 30px;
    margin-bottom: 8px;
}

.validation-status {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.validation-status.completo {
    background: #dcfce7;
    color: #15803d;
}

.validation-status.parcial {
    background: #fef3c7;
    color: #b45309;
}

.validation-status.no-enviado {
    background: #fee2e2;
    color: #b91c1c;
}

.validation-status.pendiente {
    background: #f1f5f9;
    color: #475569;
}

.validation-row-actions {
    display: flex;
    gap: 7px;
    flex-wrap: wrap;
}

.validation-row-button {
    border: 0;
    border-radius: 8px;
    padding: 7px 10px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: .15s ease;
}

.validation-row-button:hover {
    transform: translateY(-1px);
}

.validation-row-button.open {
    background: #eff6ff;
    color: #2563eb;
}

.validation-row-button.history {
    background: #f1f5f9;
    color: #475569;
}

.validation-row-button.revalidate {
    background: #ecfdf5;
    color: #047857;
}

.validation-history-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(15, 23, 42, .55);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.validation-history-modal.d-none {
    display: none;
}

.validation-history-dialog {
    width: min(1000px, 100%);
    max-height: 90vh;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(15, 23, 42, .25);
    display: flex;
    flex-direction: column;
}

.validation-history-dialog-header {
    padding: 18px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.validation-history-dialog-header strong {
    font-size: 17px;
    color: #0f172a;
}

.validation-history-close {
    width: 34px;
    height: 34px;
    border: 0;
    border-radius: 8px;
    background: #f1f5f9;
    color: #475569;
    cursor: pointer;
    font-size: 17px;
}

.validation-history-dialog-body {
    padding: 20px;
    overflow-y: auto;
}

.validation-history-summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.validation-history-summary-item {
    padding: 12px;
    border-radius: 10px;
    background: #f8fafc;
}

.validation-history-summary-item span {
    display: block;
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.validation-history-summary-item strong {
    display: block;
    margin-top: 4px;
    color: #0f172a;
    font-size: 13px;
}

@media (max-width: 700px) {
    .validation-history-summary {
        grid-template-columns: 1fr 1fr;
    }

    .validation-list-header {
        align-items: flex-start;
    }
}
</style>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | VARIABLES
    |--------------------------------------------------------------------------
    */

    let pedidoActual = null;

    let detalles = [];

    let indiceItem = 0;

    let validaciones = {};

    let itemScannerActual = null;

    let modoActual = null;

        /*
    |--------------------------------------------------------------------------
    | PEDIDOS PENDIENTES / HISTORIAL
    |--------------------------------------------------------------------------
    */

   window.abrirPedidoDesdeLista = async function (orderId) {

    if (!orderId) {

        mostrarAlerta(
            'No se pudo identificar el pedido.',
            'danger'
        );

        return;
    }

    ocultarAlerta();

    try {

        const response = await fetch(
            `/validacion-pedidos/${orderId}/datos`,
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        const data = await response.json();

        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'No se pudo cargar el pedido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CARGAR PEDIDO
        |--------------------------------------------------------------------------
        */

        pedidoActual = data.order;

        detalles =
            pedidoActual.details || [];

        validaciones = {};

        indiceItem = 0;

        itemScannerActual = null;

        modoActual = null;


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PRODUCTOS
        |--------------------------------------------------------------------------
        */

        if (!detalles.length) {

            throw new Error(
                'El pedido no tiene productos.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR INFORMACIÓN
        |--------------------------------------------------------------------------
        */

        mostrarInformacionPedido();

        modalidades.classList.remove(
            'd-none'
        );

        ocultarPaneles();


        /*
        |--------------------------------------------------------------------------
        | LIMPIAR BUSCADOR
        |--------------------------------------------------------------------------
        */

        codigoPedido.value =
            pedidoActual.factura_asociada ||
            pedidoActual.guia_asociada ||
            '';


        /*
        |--------------------------------------------------------------------------
        | IR AL PEDIDO
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'pedidoInfo'
        ).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });


    } catch (error) {

        mostrarAlerta(
            error.message,
            'danger'
        );

    }

};


    window.cerrarHistorialPedido = function () {

        const modal =
            document.getElementById('validationHistoryModal');

        if (modal) {
            modal.classList.add('d-none');
        }
    };


    window.verHistorialPedido = async function (orderId) {

        const modal =
            document.getElementById('validationHistoryModal');

        const body =
            document.getElementById('validationHistoryBody');

        const title =
            document.getElementById('validationHistoryTitle');

        modal.classList.remove('d-none');

        body.innerHTML = `
            <div class="validation-empty">
                <i class="bi bi-arrow-repeat"></i>
                Cargando historial...
            </div>
        `;

        try {

            const response = await fetch(
                `/validacion-pedidos/${orderId}/historial`,
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(
                    data.message ||
                    'No se pudo obtener el historial.'
                );
            }

            const validaciones =
                data.validations || [];

            if (!validaciones.length) {

                body.innerHTML = `
                    <div class="validation-empty">
                        <i class="bi bi-clock-history"></i>
                        No existen validaciones para este pedido.
                    </div>
                `;

                return;
            }

            const primera =
                validaciones[0];

            const order =
                primera.order ||
                primera.order_detail?.order ||
                null;

            title.textContent =
                `Historial del pedido ${
                    order?.numero_orden || ''
                }`;

            let html = '';

            validaciones.forEach(function (validacion, index) {

                const estado =
                    validacion.estado || 'PENDIENTE';

                const estadoClase =
                    estado
                        .toLowerCase()
                        .replaceAll('_', '-');

                const fecha =
                    validacion.fecha_validacion
                        ? new Date(
                            validacion.fecha_validacion
                          ).toLocaleString('es-PE')
                        : '-';

                const usuario =
                    validacion.usuario?.name ||
                    'Sistema';

                html += `

                    <div
                        style="
                            border:1px solid #e2e8f0;
                            border-radius:12px;
                            margin-bottom:16px;
                            overflow:hidden;
                        "
                    >

                        <div
                            style="
                                padding:14px 16px;
                                background:#f8fafc;
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                gap:10px;
                            "
                        >

                            <div>

                                <strong style="
                                    display:block;
                                    color:#0f172a;
                                    font-size:14px;
                                ">
                                    Validación #${validaciones.length - index}
                                </strong>

                                <span style="
                                    display:block;
                                    margin-top:3px;
                                    color:#64748b;
                                    font-size:11px;
                                ">
                                    ${fecha} · ${usuario}
                                </span>

                            </div>

                            <span class="
                                validation-status
                                ${estadoClase}
                            ">
                                ${estado}
                            </span>

                        </div>

                        <div style="overflow-x:auto;">

                            <table class="validation-list-table">

                                <thead>

                                    <tr>
                                        <th>Producto</th>
                                        <th>Solicitado</th>
                                        <th>Validado</th>
                                        <th>Estado</th>
                                        <th>Código</th>
                                    </tr>

                                </thead>

                                <tbody>
                `;

                const detallesValidacion =
                    validacion.details || [];

                detallesValidacion.forEach(function (detalle) {

                    const producto =
                        detalle.order_detail?.product;

                    const nombreProducto =
                        producto?.nombre ||
                        'Producto';

                    const estadoDetalle =
                        detalle.estado ||
                        'PENDIENTE';

                    const claseDetalle =
                        estadoDetalle
                            .toLowerCase()
                            .replaceAll('_', '-');

                    html += `

                        <tr>

                            <td>
                                <strong>
                                    ${nombreProducto}
                                </strong>
                            </td>

                            <td>
                                ${detalle.cantidad_despachada ?? 0}
                            </td>

                            <td>
                                ${detalle.cantidad_validada ?? 0}
                            </td>

                            <td>

                                <span class="
                                    validation-status
                                    ${claseDetalle}
                                ">
                                    ${estadoDetalle}
                                </span>

                            </td>

                            <td>
                                ${detalle.codigo_escaneado || '-'}
                            </td>

                        </tr>

                    `;

                });

                html += `

                                </tbody>

                            </table>

                        </div>

                    </div>

                `;

            });

            body.innerHTML = html;

        } catch (error) {

            body.innerHTML = `

                <div class="validation-empty">

                    <i class="bi bi-exclamation-triangle"></i>

                    ${error.message}

                </div>

            `;

        }

    };


    /*
    |--------------------------------------------------------------------------
    | CERRAR MODAL CON ESCAPE / CLICK EXTERIOR
    |--------------------------------------------------------------------------
    */

    const historyModal =
        document.getElementById(
            'validationHistoryModal'
        );

    if (historyModal) {

        historyModal.addEventListener(
            'click',
            function (event) {

                if (event.target === historyModal) {
                    cerrarHistorialPedido();
                }

            }
        );

    }

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                historyModal &&
                !historyModal.classList.contains('d-none')
            ) {

                cerrarHistorialPedido();

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const codigoPedido =
        document.getElementById('codigoPedido');

    const btnBuscarPedido =
        document.getElementById('btnBuscarPedido');

    const pedidoInfo =
        document.getElementById('pedidoInfo');

    const modalidades =
        document.getElementById('modalidades');

    const panelItem =
        document.getElementById('panelItem');

    const panelScanner =
        document.getElementById('panelScanner');

    const panelCompleto =
        document.getElementById('panelCompleto');

    const alerta =
        document.getElementById('alertaValidacion');


    /*
    |--------------------------------------------------------------------------
    | ALERTAS
    |--------------------------------------------------------------------------
    */

    function mostrarAlerta(mensaje, tipo = 'danger') {

        alerta.className =
            `validation-alert alert-${tipo}`;

        alerta.textContent =
            mensaje;

        alerta.classList.remove('d-none');

        setTimeout(function () {

            alerta.classList.add('d-none');

        }, 4500);

    }


    function ocultarAlerta() {

        alerta.classList.add('d-none');

    }


    /*
    |--------------------------------------------------------------------------
    | OCULTAR PANELES
    |--------------------------------------------------------------------------
    */

    function ocultarPaneles() {

        panelItem.classList.add('d-none');

        panelScanner.classList.add('d-none');

        panelCompleto.classList.add('d-none');

    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR PEDIDO
    |--------------------------------------------------------------------------
    */

    async function buscarPedido() {

        const codigo =
            codigoPedido.value.trim();

        if (!codigo) {

            mostrarAlerta(
                'Ingresa una factura o guía.',
                'warning'
            );

            codigoPedido.focus();

            return;
        }

        ocultarAlerta();

        btnBuscarPedido.disabled = true;

        btnBuscarPedido.innerHTML =
            '<i class="bi bi-arrow-repeat"></i> BUSCANDO...';

        try {

            const response =
                await fetch(
                    '{{ route("orders.validation.buscar") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            codigo: codigo
                        })
                    }
                );


            const data =
                await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'No se encontró el pedido.'
                );

            }


            pedidoActual =
                data.order;

            detalles =
                pedidoActual.details || [];

            validaciones = {};

            indiceItem = 0;

            itemScannerActual = null;


            if (!detalles.length) {

                throw new Error(
                    'El pedido no tiene productos.'
                );

            }


            mostrarInformacionPedido();

            modalidades.classList.remove('d-none');

            ocultarPaneles();

            document.getElementById(
                'modalidades'
            ).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        } catch (error) {

            mostrarAlerta(
                error.message,
                'danger'
            );

        } finally {

            btnBuscarPedido.disabled = false;

            btnBuscarPedido.innerHTML =
                '<i class="bi bi-search"></i><span>BUSCAR PEDIDO</span>';

        }

    }


    btnBuscarPedido.addEventListener(
        'click',
        buscarPedido
    );


    codigoPedido.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                buscarPedido();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INFORMACIÓN PEDIDO
    |--------------------------------------------------------------------------
    */

    function mostrarInformacionPedido() {

        document.getElementById(
            'pedidoNumero'
        ).textContent =
            pedidoActual.numero_orden || '-';


        document.getElementById(
            'pedidoCliente'
        ).textContent =
            pedidoActual.client?.razon_social ||
            pedidoActual.client?.nombre_comercial ||
            '-';


        document.getElementById(
            'pedidoFactura'
        ).textContent =
            pedidoActual.factura_asociada || '-';


        document.getElementById(
            'pedidoGuia'
        ).textContent =
            pedidoActual.guia_asociada || '-';


        pedidoInfo.classList.remove(
            'd-none'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODO ITEM POR ITEM
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnModoItem'
    ).addEventListener(
        'click',
        function () {

            modoActual = 'item';

            indiceItem = 0;

            validaciones = {};

            ocultarPaneles();

            panelItem.classList.remove(
                'd-none'
            );

            mostrarItemActual();

            panelItem.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }
    );


    function mostrarItemActual() {

        if (indiceItem >= detalles.length) {

            finalizarValidacionItem();

            return;
        }


        const detail =
            detalles[indiceItem];

        const product =
            detail.product || {};


        document.getElementById(
            'contadorItem'
        ).textContent =
            `${indiceItem + 1} / ${detalles.length}`;


        /*
         * Barra de progreso.
         */
        const progress =
            (
                indiceItem /
                detalles.length
            ) * 100;


        document.getElementById(
            'itemProgressBar'
        ).style.width =
            `${progress}%`;


        document.getElementById(
            'itemNombre'
        ).textContent =
            product.nombre ||
            'Producto sin nombre';


        document.getElementById(
            'itemMarca'
        ).textContent =
            product.marca ||
            '';


        document.getElementById(
            'itemCantidadSolicitada'
        ).textContent =
            detail.cantidad_despachada ??
            0;


        document.getElementById(
            'itemCodigo'
        ).textContent =
            product.barcode ||
            product.box_barcode ||
            '-';


        document.getElementById(
            'itemCantidadParcial'
        ).classList.add(
            'd-none'
        );


        document.getElementById(
            'cantidadItem'
        ).value = '';


        ocultarAlerta();

    }


    /*
    |--------------------------------------------------------------------------
    | REGISTRAR ITEM
    |--------------------------------------------------------------------------
    */

    function registrarItem(
        estado,
        cantidad = 0
    ) {

        const detail =
            detalles[indiceItem];


        validaciones[detail.id] = {

            order_detail_id:
                detail.id,

            estado:
                estado,

            cantidad_validada:
                cantidad,

            codigo_escaneado:
                null,

            observaciones:
                null

        };


        indiceItem++;

        mostrarItemActual();

    }


    /*
    |--------------------------------------------------------------------------
    | ITEM - NO ENVIADO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnItemIncompleto'
    ).addEventListener(
        'click',
        function () {

            registrarItem(
                'NO_ENVIADO',
                0
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ITEM - PARCIAL
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnItemParcial'
    ).addEventListener(
        'click',
        function () {

            const detail =
                detalles[indiceItem];

            const panelCantidad =
                document.getElementById(
                    'itemCantidadParcial'
                );

            const cantidadInput =
                document.getElementById(
                    'cantidadItem'
                );


            if (
                panelCantidad.classList.contains(
                    'd-none'
                )
            ) {

                panelCantidad.classList.remove(
                    'd-none'
                );

                cantidadInput.value = '';

                cantidadInput.focus();

                return;

            }


            const cantidad =
                parseFloat(
                    cantidadInput.value
                );


            if (
                isNaN(cantidad) ||
                cantidad <= 0
            ) {

                mostrarAlerta(
                    'Ingresa una cantidad válida.',
                    'warning'
                );

                cantidadInput.focus();

                return;

            }


            if (
                cantidad >=
                parseFloat(
                    detail.cantidad_despachada
                )
            ) {

                mostrarAlerta(
                    'La cantidad parcial debe ser menor que la cantidad despachada.',
                    'warning'
                );

                cantidadInput.focus();

                return;

            }


            ocultarAlerta();


            registrarItem(
                'PARCIAL',
                cantidad
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ITEM - COMPLETO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnItemCompleto'
    ).addEventListener(
        'click',
        function () {

            registrarItem(
                'COMPLETO',
                parseFloat(
                    detalles[indiceItem]
                        .cantidad_despachada
                )
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FINALIZAR ITEM
    |--------------------------------------------------------------------------
    */

    function finalizarValidacionItem() {

        document.getElementById(
            'itemProgressBar'
        ).style.width = '100%';


        ocultarPaneles();

        panelCompleto.classList.remove(
            'd-none'
        );

        construirTablaCompleta();

        mostrarAlerta(
            'Todos los productos fueron revisados. Verifica la información antes de guardar.',
            'success'
        );

        panelCompleto.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    }


    /*
    |--------------------------------------------------------------------------
    | MODO ESCÁNER
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnModoScanner'
    ).addEventListener(
        'click',
        function () {

            modoActual = 'scanner';

            validaciones = {};

            itemScannerActual = null;

            ocultarPaneles();

            panelScanner.classList.remove(
                'd-none'
            );


            document.getElementById(
                'scannerProducto'
            ).classList.add(
                'd-none'
            );


            document.getElementById(
                'codigoScanner'
            ).value = '';


            actualizarContadorScanner();


            panelScanner.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });


            setTimeout(function () {

                document.getElementById(
                    'codigoScanner'
                ).focus();

            }, 350);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER
    |--------------------------------------------------------------------------
    */

    const codigoScanner =
        document.getElementById(
            'codigoScanner'
        );


    codigoScanner.addEventListener(
        'keydown',
        async function (event) {

            if (
                event.key !== 'Enter'
            ) {

                return;

            }


            event.preventDefault();


            const codigo =
                codigoScanner.value.trim();


            if (!codigo) {

                return;

            }


            await procesarScanner(
                codigo
            );

        }
    );


    async function procesarScanner(
        codigo
    ) {

        ocultarAlerta();


        try {

            const response =
                await fetch(
                    '{{ route("orders.validation.producto.buscar") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            codigo: codigo
                        })
                    }
                );


            const data =
                await response.json();


            if (
                !response.ok ||
                !data.success
            ) {

                throw new Error(
                    data.message ||
                    'Producto no encontrado.'
                );

            }


            const product =
                data.product;


            /*
             * Verificar que el producto
             * pertenece al pedido.
             */
            const encontrados =
                detalles.filter(
                    detail =>
                        detail.product &&
                        (
                            String(
                                detail.product.barcode
                            ) === String(codigo)

                            ||

                            String(
                                detail.product.box_barcode
                            ) === String(codigo)
                        )
                );


            if (
                !encontrados.length
            ) {

                mostrarAlerta(
                    '⚠️ Este producto no pertenece al pedido.',
                    'warning'
                );


                codigoScanner.value = '';

                codigoScanner.focus();

                return;

            }


            /*
             * Buscar un detalle que todavía
             * no haya sido validado.
             */
            const detail =
                encontrados.find(
                    d =>
                        !validaciones[d.id]
                ) ||
                encontrados[0];


            itemScannerActual =
                detail;


            document.getElementById(
                'scannerNombre'
            ).textContent =
                product.nombre ||
                'Producto sin nombre';


            document.getElementById(
                'scannerMarca'
            ).textContent =
                product.marca ||
                '';


            document.getElementById(
                'scannerDespachado'
            ).textContent =
                detail.cantidad_despachada ??
                0;


            document.getElementById(
                'scannerCodigo'
            ).textContent =
                codigo;


            document.getElementById(
                'scannerProducto'
            ).classList.remove(
                'd-none'
            );


            document.getElementById(
                'scannerCantidadParcial'
            ).classList.add(
                'd-none'
            );


            document.getElementById(
                'cantidadScanner'
            ).value = '';


            codigoScanner.value = '';


        } catch (error) {

            mostrarAlerta(
                error.message,
                'danger'
            );


            codigoScanner.select();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | REGISTRAR ESCÁNER
    |--------------------------------------------------------------------------
    */

    function registrarScanner(
        estado,
        cantidad = 0
    ) {

        if (!itemScannerActual) {

            mostrarAlerta(
                'Primero escanea un producto.',
                'warning'
            );

            return;

        }


        validaciones[
            itemScannerActual.id
        ] = {

            order_detail_id:
                itemScannerActual.id,

            estado:
                estado,

            cantidad_validada:
                cantidad,

            codigo_escaneado:
                document.getElementById(
                    'scannerCodigo'
                ).textContent,

            observaciones:
                null

        };


        itemScannerActual =
            null;


        document.getElementById(
            'scannerProducto'
        ).classList.add(
            'd-none'
        );


        actualizarContadorScanner();


        codigoScanner.value = '';

        codigoScanner.focus();


        if (
            Object.keys(validaciones).length >=
            detalles.length
        ) {

            finalizarScanner();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER - NO ENVIADO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnScannerIncompleto'
    ).addEventListener(
        'click',
        function () {

            registrarScanner(
                'NO_ENVIADO',
                0
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER - PARCIAL
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnScannerParcial'
    ).addEventListener(
        'click',
        function () {

            if (
                !itemScannerActual
            ) {

                return;

            }


            const panelCantidad =
                document.getElementById(
                    'scannerCantidadParcial'
                );


            if (
                panelCantidad.classList.contains(
                    'd-none'
                )
            ) {

                panelCantidad.classList.remove(
                    'd-none'
                );


                document.getElementById(
                    'cantidadScanner'
                ).focus();


                return;

            }


            const cantidad =
                parseFloat(
                    document.getElementById(
                        'cantidadScanner'
                    ).value
                );


            const despachada =
            parseFloat(
                itemScannerActual
                    .cantidad_despachada
            );


            if (
                isNaN(cantidad) ||
                cantidad <= 0 ||
                cantidad >= despachada
            ) {

                mostrarAlerta(
                    'La cantidad parcial debe ser mayor a 0 y menor a la cantidad despachada.',
                    'warning'
                );

                return;

            }


            registrarScanner(
                'PARCIAL',
                cantidad
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER - COMPLETO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnScannerCompleto'
    ).addEventListener(
        'click',
        function () {

            if (
                !itemScannerActual
            ) {

                return;

            }


            registrarScanner(
                'COMPLETO',
                parseFloat(
                    itemScannerActual
                        .cantidad_despachada
                )
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CONTADOR ESCÁNER
    |--------------------------------------------------------------------------
    */

    function actualizarContadorScanner() {

        document.getElementById(
            'contadorScanner'
        ).textContent =
            `${Object.keys(validaciones).length} / ${detalles.length}`;

    }


    /*
    |--------------------------------------------------------------------------
    | FINALIZAR ESCÁNER
    |--------------------------------------------------------------------------
    */

    function finalizarScanner() {

        ocultarPaneles();

        panelCompleto.classList.remove(
            'd-none'
        );

        construirTablaCompleta();

        mostrarAlerta(
            'Todos los productos fueron procesados por escáner. Revisa y guarda la validación.',
            'success'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODO PEDIDO COMPLETO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnModoCompleto'
    ).addEventListener(
        'click',
        function () {

            modoActual = 'completo';

            validaciones = {};

            ocultarPaneles();

            panelCompleto.classList.remove(
                'd-none'
            );

            construirTablaCompleta();


            panelCompleto.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TABLA COMPLETA
    |--------------------------------------------------------------------------
    */

    function construirTablaCompleta() {

        const tabla =
            document.getElementById(
                'tablaValidacion'
            );


        tabla.innerHTML = '';


        detalles.forEach(
            function (detail) {

                const product =
                    detail.product || {};


                const validacion =
                    validaciones[detail.id];


                let estado =
                    validacion?.estado ||
                    'PENDIENTE';


                let cantidad =
                    validacion?.cantidad_validada ??
                    0;


                const tr =
                    document.createElement(
                        'tr'
                    );


                tr.dataset.detailId =
                    detail.id;


                tr.innerHTML = `

                    <td>

                        <div class="table-product-name">

                            ${escapeHtml(
                                product.nombre ||
                                'Producto sin nombre'
                            )}

                        </div>

                        <div class="table-product-brand">

                            ${escapeHtml(
                                product.marca ||
                                ''
                            )}

                        </div>

                    </td>


                    <td>

                        <span class="table-code">

                            ${escapeHtml(
                                product.barcode ||
                                product.box_barcode ||
                                '-'
                            )}

                        </span>

                    </td>


                    <td class="text-center">

                        <span class="table-quantity">

                            ${detail.cantidad_despachada}

                        </span>

                    </td>


                    <td class="text-center">

                        <input
                            type="number"
                            class="cantidad-validada"
                            data-detail-id="${detail.id}"
                            value="${cantidad}"
                            min="0"
                            step="0.01"
                        >

                    </td>


                    <td class="text-center">

                        <select
                            class="estado-validacion"
                            data-detail-id="${detail.id}"
                        >

                            <option
                                value="PENDIENTE"
                                ${estado === 'PENDIENTE' ? 'selected' : ''}
                            >
                                PENDIENTE
                            </option>

                            <option
                                value="COMPLETO"
                                ${estado === 'COMPLETO' ? 'selected' : ''}
                            >
                                COMPLETO
                            </option>

                            <option
                                value="PARCIAL"
                                ${estado === 'PARCIAL' ? 'selected' : ''}
                            >
                                PARCIAL
                            </option>

                            <option
                                value="NO_ENVIADO"
                                ${estado === 'NO_ENVIADO' ? 'selected' : ''}
                            >
                                NO ENVIADO
                            </option>

                        </select>

                    </td>

                `;


                tabla.appendChild(
                    tr
                );

            }
        );


        /*
         * Eventos estado.
         */
        tabla
            .querySelectorAll(
                '.estado-validacion'
            )
            .forEach(
                select => {

                    select.addEventListener(
                        'change',
                        function () {

                            actualizarValidacionTabla(
                                this.dataset.detailId
                            );

                        }
                    );

                }
            );


        /*
         * Eventos cantidad.
         */
        tabla
            .querySelectorAll(
                '.cantidad-validada'
            )
            .forEach(
                input => {

                    input.addEventListener(
                        'change',
                        function () {

                            actualizarValidacionTabla(
                                this.dataset.detailId
                            );

                        }
                    );

                }
            );


        actualizarContadorCompleto();

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR FILA
    |--------------------------------------------------------------------------
    */

    function actualizarValidacionTabla(
        detailId
    ) {

        const select =
            document.querySelector(
                `.estado-validacion[data-detail-id="${detailId}"]`
            );


        const input =
            document.querySelector(
                `.cantidad-validada[data-detail-id="${detailId}"]`
            );


        if (
            !select ||
            !input
        ) {

            return;

        }


        const detail =
            detalles.find(
                d =>
                    String(d.id) ===
                    String(detailId)
            );


        if (!detail) {

            return;

        }


        const estado =
            select.value;


        if (
            estado === 'COMPLETO'
        ) {

            input.value =
                detail.cantidad_despachada;

        }


        if (
            estado === 'NO_ENVIADO'
        ) {

            input.value = 0;

        }


        validaciones[detailId] = {

            order_detail_id:
                parseInt(detailId),

            estado:
                estado,

            cantidad_validada:
                parseFloat(
                    input.value
                ) || 0,

            codigo_escaneado:
                null,

            observaciones:
                null

        };


        actualizarContadorCompleto();

    }


    /*
    |--------------------------------------------------------------------------
    | CONTADOR PEDIDO COMPLETO
    |--------------------------------------------------------------------------
    */

    function actualizarContadorCompleto() {

        document.getElementById(
            'contadorCompleto'
        ).textContent =
            `${Object.keys(validaciones).length} / ${detalles.length}`;

    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnGuardarValidacion'
    ).addEventListener(
        'click',
        async function () {

            /*
             * Actualizar todos los productos
             * visibles en la tabla.
             */
            detalles.forEach(
                detail => {

                    actualizarValidacionTabla(
                        detail.id
                    );

                }
            );


            /*
             * Todos deben estar definidos.
             */
            if (
                Object.keys(validaciones).length !==
                detalles.length
            ) {

                mostrarAlerta(
                    'Debes validar todos los productos antes de guardar.',
                    'warning'
                );

                return;

            }


            /*
             * Validar cantidades.
             */
            for (
                const detail of detalles
            ) {

                const validation =
                    validaciones[
                        detail.id
                    ];


                if (!validation) {

                    continue;

                }


                const despachada =
                    parseFloat(
                        detail.cantidad_despachada
                    );


                const cantidad =
                    parseFloat(
                        validation.cantidad_validada
                    ) || 0;


                /*
                 * COMPLETO.
                 */
                if (
                    validation.estado ===
                    'COMPLETO' &&
                    cantidad < despachada
                ) {

                    mostrarAlerta(
                        `El producto "${detail.product?.nombre || ''}" está marcado como COMPLETO pero la cantidad validada es menor a la despachada.`,
                        'warning'
                    );

                    return;

                }


                /*
                 * PARCIAL.
                 */
                if (
                    validation.estado ===
                    'PARCIAL' &&
                    (
                        cantidad <= 0 ||
                        cantidad >= despachada
                    )
                ) {

                    mostrarAlerta(
                        `La cantidad parcial de "${detail.product?.nombre || ''}" no es válida.`,
                        'warning'
                    );

                    return;

                }


                /*
                 * NO ENVIADO.
                 */
                if (
                    validation.estado ===
                    'NO_ENVIADO' &&
                    cantidad !== 0
                ) {

                    mostrarAlerta(
                        `El producto "${detail.product?.nombre || ''}" está marcado como NO ENVIADO y debe tener cantidad 0.`,
                        'warning'
                    );

                    return;

                }


                /*
                 * PENDIENTE.
                 */
                if (
                    validation.estado ===
                    'PENDIENTE'
                ) {

                    mostrarAlerta(
                        `El producto "${detail.product?.nombre || ''}" todavía está pendiente de validar.`,
                        'warning'
                    );

                    return;

                }

            }


            const boton =
                document.getElementById(
                    'btnGuardarValidacion'
                );


            boton.disabled = true;


            boton.innerHTML =
                '<i class="bi bi-arrow-repeat"></i> GUARDANDO...';


            try {

                const response =
                    await fetch(
                        '{{ url("validacion-pedidos") }}/' +
                        pedidoActual.id +
                        '/guardar',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({

                                items:
                                    Object.values(
                                        validaciones
                                    ),

                                observaciones:
                                    document.getElementById(
                                        'observacionesValidacion'
                                    ).value

                            })

                        }
                    );


                const data =
                    await response.json();


                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'No se pudo guardar la validación.'
                    );

                }


                mostrarAlerta(
                    '✓ Validación guardada correctamente.',
                    'success'
                );
                setTimeout(function () {
                    window.location.reload();
                }, 1000);

                boton.disabled = false;


                boton.innerHTML =
                    '<i class="bi bi-check-circle"></i><span>GUARDAR VALIDACIÓN</span>';


            } catch (error) {

                mostrarAlerta(
                    error.message,
                    'danger'
                );


                boton.disabled = false;


                boton.innerHTML =
                    '<i class="bi bi-check-circle"></i><span>GUARDAR VALIDACIÓN</span>';

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ?? '';


        return div.innerHTML;

    }

});

</script>

@endsection