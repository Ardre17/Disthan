@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Nueva orden de abastecimiento
            </h2>

            <p class="text-muted mb-0">
                Solicita los materiales necesarios para completar la producción en planta.
            </p>
        </div>

        <a href="{{ url('/supply-orders') }}"
           class="btn btn-outline-secondary">
            ← Volver
        </a>
    </div>


    {{-- FORMULARIO --}}
    <form id="supplyOrderForm">

        {{-- INFORMACIÓN DE LA ORDEN --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">
                    Información de la orden
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    {{-- PLANTA --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Planta destino <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="planta"
                            id="planta"
                            class="form-control"
                            placeholder="Ej. Planta Arequipa"
                            required
                        >

                    </div>


                    {{-- FECHA SOLICITUD --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Fecha de solicitud
                        </label>

                        <input
                            type="date"
                            name="fecha_solicitud"
                            id="fecha_solicitud"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required
                        >

                    </div>


                    {{-- FECHA REQUERIDA --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Fecha requerida
                        </label>

                        <input
                            type="date"
                            name="fecha_requerida"
                            id="fecha_requerida"
                            class="form-control"
                        >

                    </div>


                    {{-- PRODUCTO --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Producto en producción
                        </label>

                        <input
                            type="text"
                            name="producto_produccion"
                            id="producto_produccion"
                            class="form-control"
                            placeholder="Ej. Aceituna verde 500g"
                        >

                    </div>


                    {{-- CANTIDAD --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Cantidad a producir
                        </label>

                        <input
                            type="number"
                            name="cantidad_produccion"
                            id="cantidad_produccion"
                            class="form-control"
                            min="0"
                            step="0.01"
                            placeholder="1000"
                        >

                    </div>


                    {{-- LOTE --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Lote
                        </label>

                        <input
                            type="text"
                            name="lote"
                            id="lote"
                            class="form-control"
                            placeholder="ACE-2026-102"
                        >

                    </div>


                    {{-- OBSERVACIONES --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observaciones
                        </label>

                        <textarea
                            name="observaciones"
                            id="observaciones"
                            class="form-control"
                            rows="3"
                            placeholder="Información adicional de la solicitud..."
                        ></textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- MATERIALES --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="fw-bold mb-1">
                            Materiales requeridos
                        </h5>

                        <small class="text-muted">
                            Agrega etiquetas, stickers, precintos, cajas u otros materiales disponibles.
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="abrirBuscadorMateriales()">
                        + Agregar material
                    </button>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="px-4">
                                    Tipo
                                </th>

                                <th>
                                    Material
                                </th>

                                <th>
                                    Stock actual
                                </th>

                                <th style="width: 180px;">
                                    Cantidad requerida
                                </th>

                                <th style="width: 70px;"></th>
                            </tr>

                        </thead>

                        <tbody id="materialesTable">

                            <tr id="emptyMaterials">

                                <td
                                    colspan="5"
                                    class="text-center py-5 text-muted">

                                    <div class="mb-2 fs-2">
                                        📦
                                    </div>

                                    <div>
                                        Todavía no has agregado materiales.
                                    </div>

                                    <small>
                                        Presiona "Agregar material" para comenzar.
                                    </small>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- RESUMEN --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <div class="text-muted small">
                            Materiales
                        </div>

                        <div
                            id="totalMateriales"
                            class="fs-4 fw-bold">
                            0
                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="text-muted small">
                            Cantidad total
                        </div>

                        <div
                            id="cantidadTotal"
                            class="fs-4 fw-bold">
                            0
                        </div>

                    </div>


                    <div class="col-md-4 text-md-end">

                        <button
                            type="button"
                            class="btn btn-outline-secondary me-2"
                            onclick="window.history.back()">
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary px-4">
                            Crear orden
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- MODAL BUSCADOR --}}
<div
    class="modal fade"
    id="materialModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5 class="modal-title fw-bold">
                        Agregar material
                    </h5>

                    <small class="text-muted">
                        Busca entre todos los inventarios.
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <div class="input-group mb-3">

                    <span class="input-group-text">
                        🔎
                    </span>

                    <input
                        type="text"
                        id="buscarMaterial"
                        class="form-control"
                        placeholder="Buscar etiqueta, sticker, precinto o caja..."
                        autocomplete="off">

                </div>


                <div
                    id="materialesResultados"
                    class="list-group">

                    <div class="text-center py-4 text-muted">
                        Escribe para buscar materiales.
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

let materialesSeleccionados = [];

let modalMaterial = null;


// ---------------------------------------------------------
// ABRIR MODAL
// ---------------------------------------------------------

function abrirBuscadorMateriales()
{
    modalMaterial = new bootstrap.Modal(
        document.getElementById('materialModal')
    );

    document.getElementById('buscarMaterial').value = '';

    document.getElementById('materialesResultados').innerHTML = `
        <div class="text-center py-4 text-muted">
            Escribe para buscar materiales.
        </div>
    `;

    modalMaterial.show();

    setTimeout(() => {

        document
            .getElementById('buscarMaterial')
            .focus();

    }, 300);
}


// ---------------------------------------------------------
// BUSCAR MATERIAL
// ---------------------------------------------------------

let timeoutBusqueda = null;

document
    .getElementById('buscarMaterial')
    .addEventListener('input', function () {

        const search = this.value.trim();

        clearTimeout(timeoutBusqueda);

        if (search.length < 2) {

            document.getElementById(
                'materialesResultados'
            ).innerHTML = `
                <div class="text-center py-4 text-muted">
                    Escribe al menos 2 caracteres.
                </div>
            `;

            return;
        }


        timeoutBusqueda = setTimeout(() => {

            buscarMateriales(search);

        }, 300);

    });


async function buscarMateriales(search)
{
    const contenedor =
        document.getElementById('materialesResultados');


    contenedor.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border spinner-border-sm"></div>
            <div class="mt-2 text-muted">
                Buscando...
            </div>
        </div>
    `;


    try {

        const response = await fetch(
            `{{ route('supply-orders.materials') }}?search=${encodeURIComponent(search)}`
        );


        if (!response.ok) {
            throw new Error('Error al consultar materiales');
        }


        const result = await response.json();


        if (!result.success || !result.data.length) {

            contenedor.innerHTML = `
                <div class="text-center py-4 text-muted">
                    No se encontraron materiales.
                </div>
            `;

            return;
        }


        contenedor.innerHTML = '';


        result.data.forEach(material => {

            const yaExiste =
                materialesSeleccionados.some(item =>
                    item.tipo === material.tipo &&
                    Number(item.id) === Number(material.id)
                );


            const estadoClass =
                material.estado === 'AGOTADO'
                    ? 'text-danger'
                    : material.estado === 'STOCK_BAJO'
                        ? 'text-warning'
                        : 'text-success';


            const elemento =
                document.createElement('button');

            elemento.type = 'button';

            elemento.className =
                'list-group-item list-group-item-action';


            elemento.innerHTML = `

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="fw-semibold">

                            ${material.nombre}

                        </div>

                        <small class="text-muted">

                            ${material.tipo}

                            ${material.detalle
                                ? ' · ' + material.detalle
                                : ''}

                        </small>

                    </div>


                    <div class="text-end">

                        <div class="fw-semibold ${estadoClass}">

                            Stock:
                            ${formatearNumero(material.stock)}

                        </div>

                        <small class="text-muted">

                            ${material.estado}

                        </small>

                    </div>

                </div>

            `;


            if (yaExiste) {

                elemento.disabled = true;

                elemento.classList.add('disabled');

            } else {

                elemento.addEventListener(
                    'click',
                    () => seleccionarMaterial(material)
                );

            }


            contenedor.appendChild(elemento);

        });

    } catch (error) {

        console.error(error);

        contenedor.innerHTML = `
            <div class="alert alert-danger">
                No se pudieron cargar los materiales.
            </div>
        `;

    }
}


// ---------------------------------------------------------
// SELECCIONAR
// ---------------------------------------------------------

function seleccionarMaterial(material)
{
    materialesSeleccionados.push({

        tipo: material.tipo,

        id: material.id,

        nombre: material.nombre,

        detalle: material.detalle,

        stock: Number(material.stock),

        cantidad: 1

    });


    renderMateriales();

    if (modalMaterial) {
        modalMaterial.hide();
    }
}


// ---------------------------------------------------------
// RENDER TABLA
// ---------------------------------------------------------

function renderMateriales()
{
    const tbody =
        document.getElementById('materialesTable');


    if (!materialesSeleccionados.length) {

        tbody.innerHTML = `
            <tr id="emptyMaterials">

                <td
                    colspan="5"
                    class="text-center py-5 text-muted">

                    <div class="mb-2 fs-2">
                        📦
                    </div>

                    Todavía no has agregado materiales.

                </td>

            </tr>
        `;

        actualizarResumen();

        return;
    }


    tbody.innerHTML = '';


    materialesSeleccionados.forEach((material, index) => {

        const stockBajo =
            material.cantidad > material.stock;


        const row =
            document.createElement('tr');


        row.innerHTML = `

            <td class="px-4">

                <span class="badge bg-light text-dark border">

                    ${material.tipo}

                </span>

            </td>


            <td>

                <div class="fw-semibold">

                    ${material.nombre}

                </div>

                <small class="text-muted">

                    ${material.detalle ?? ''}

                </small>

            </td>


            <td>

                ${formatearNumero(material.stock)}

            </td>


            <td>

                <input
                    type="number"
                    min="0"
                    step="0.01"
                    value="${material.cantidad}"
                    class="form-control cantidad-material
                           ${stockBajo ? 'is-invalid' : ''}"
                    onchange="actualizarCantidad(
                        ${index},
                        this.value
                    )">

                ${
                    stockBajo
                    ? `
                        <div class="invalid-feedback">
                            Stock disponible:
                            ${formatearNumero(material.stock)}
                        </div>
                    `
                    : ''
                }

            </td>


            <td class="text-end pe-4">

                <button
                    type="button"
                    class="btn btn-sm btn-outline-danger"
                    onclick="eliminarMaterial(${index})">

                    🗑

                </button>

            </td>

        `;


        tbody.appendChild(row);

    });


    actualizarResumen();
}


// ---------------------------------------------------------
// CANTIDAD
// ---------------------------------------------------------

function actualizarCantidad(index, value)
{
    let cantidad = Number(value);

    if (isNaN(cantidad) || cantidad < 0) {
        cantidad = 0;
    }


    materialesSeleccionados[index].cantidad =
        cantidad;


    renderMateriales();
}


// ---------------------------------------------------------
// ELIMINAR
// ---------------------------------------------------------

function eliminarMaterial(index)
{
    materialesSeleccionados.splice(index, 1);

    renderMateriales();
}


// ---------------------------------------------------------
// RESUMEN
// ---------------------------------------------------------

function actualizarResumen()
{
    document.getElementById('totalMateriales')
        .textContent =
        materialesSeleccionados.length;


    const total =
        materialesSeleccionados.reduce(
            (sum, material) =>
                sum + Number(material.cantidad || 0),
            0
        );


    document.getElementById('cantidadTotal')
        .textContent =
        formatearNumero(total);
}


// ---------------------------------------------------------
// FORMATO
// ---------------------------------------------------------

function formatearNumero(numero)
{
    return Number(numero || 0)
        .toLocaleString('es-PE', {
            maximumFractionDigits: 2
        });
}


// ---------------------------------------------------------
// SUBMIT TEMPORAL
// ---------------------------------------------------------

document
    .getElementById('supplyOrderForm')
    .addEventListener('submit', function (e) {

        e.preventDefault();


        if (!materialesSeleccionados.length) {

            alert(
                'Debes agregar al menos un material.'
            );

            return;
        }


        const materialesConCantidad =
            materialesSeleccionados.filter(
                item => Number(item.cantidad) > 0
            );


        if (!materialesConCantidad.length) {

            alert(
                'Debes ingresar una cantidad válida.'
            );

            return;
        }


        console.log({
            planta:
                document.getElementById('planta').value,

            fecha_solicitud:
                document.getElementById('fecha_solicitud').value,

            fecha_requerida:
                document.getElementById('fecha_requerida').value,

            producto_produccion:
                document.getElementById('producto_produccion').value,

            cantidad_produccion:
                document.getElementById('cantidad_produccion').value,

            lote:
                document.getElementById('lote').value,

            observaciones:
                document.getElementById('observaciones').value,

            materiales:
                materialesConCantidad
        });

        alert(
            'La estructura de la orden está lista. ' +
            'El guardado lo conectaremos en el siguiente paso.'
        );

    });

</script>

@endsection