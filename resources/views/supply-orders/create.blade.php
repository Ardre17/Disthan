@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}

.erp-bar{
    background:#1e3a5f;
    padding:0 1.25rem;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin:-20px -20px 0;
}

.erp-bar-title{
    color:#7eb8f7;
    font-size:13px;
    font-weight:600;
    letter-spacing:.05em;
    text-transform:uppercase;
}

.erp-breadcrumb{
    font-size:11px;
    color:#5a8abf;
}

.erp-user{
    font-size:11px;
    color:#7eb8f7;
    background:#152d4d;
    padding:3px 10px;
    border-radius:4px;
}

.pg{
    padding:1rem;
    background:#e8ecf0;
    min-height:100vh;
}

/* HEADER */

.order-header{
    background:#fff;
    border:1px solid #c9d4e0;
    border-top:4px solid #1e3a5f;
    border-radius:4px;
    padding:.85rem 1.1rem;
    margin-bottom:.85rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.order-id{
    font-size:16px;
    font-weight:700;
    color:#1e3a5f;
}

.order-sub{
    font-size:11px;
    color:#64748b;
    margin-top:2px;
}

/* BOTONES */

.btn-primary{
    background:#1e3a5f;
    color:#fff;
    padding:7px 14px;
    border-radius:3px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    border:none;
    display:inline-flex;
    align-items:center;
    gap:5px;
    text-decoration:none;
    transition:opacity .15s;
}

.btn-primary:hover{
    opacity:.9;
}

.btn-cancel{
    background:#f1f5f9;
    color:#475569;
    border:1px solid #e2e8f0;
    padding:7px 14px;
    border-radius:3px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
}

.btn-green{
    background:#16a34a;
    color:#fff;
    padding:7px 14px;
    border-radius:3px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    border:none;
}

/* LAYOUT */

.layout{
    display:grid;
    grid-template-columns:1fr 290px;
    gap:10px;
}

@media(max-width:900px){
    .layout{
        grid-template-columns:1fr;
    }
}

.left-col{
    display:flex;
    flex-direction:column;
    gap:10px;
}

/* PANEL */

.panel{
    background:#fff;
    border:1px solid #c9d4e0;
    border-radius:4px;
}

.panel-header{
    background:#f1f5f9;
    border-bottom:1px solid #c9d4e0;
    padding:.6rem 1rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.panel-title{
    font-size:12px;
    font-weight:700;
    color:#1e3a5f;
    text-transform:uppercase;
    letter-spacing:.06em;
    display:flex;
    align-items:center;
    gap:6px;
}

.panel-body{
    padding:.9rem 1rem;
}

/* FORMULARIOS */

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:10px;
}

.form-grid.three{
    grid-template-columns:repeat(3,1fr);
}

.form-full{
    grid-column:1 / -1;
}

.flabel{
    font-size:10px;
    font-weight:700;
    color:#475569;
    text-transform:uppercase;
    letter-spacing:.06em;
    display:block;
    margin-bottom:3px;
}

.finput{
    padding:7px 9px;
    border:1px solid #c9d4e0;
    border-radius:3px;
    font-size:12px;
    color:#1e293b;
    background:#fff;
    outline:none;
    width:100%;
    transition:border-color .15s;
}

.finput:focus{
    border-color:#1e3a5f;
    box-shadow:0 0 0 2px rgba(30,58,95,.1);
}

textarea.finput{
    resize:vertical;
    min-height:65px;
}

/* BUSCADOR */

.material-search{
    background:#0f172a;
    border:1px solid #334155;
    border-radius:4px;
    padding:.45rem .7rem;
    display:flex;
    align-items:center;
    gap:8px;
}

.search-led{
    width:9px;
    height:9px;
    border-radius:50%;
    background:#22c55e;
    flex-shrink:0;
}

.material-search input{
    flex:1;
    min-width:0;
    background:#1e293b;
    border:1px solid #334155;
    color:#fff;
    padding:6px 9px;
    border-radius:4px;
    outline:none;
    font-size:12px;
}

.material-search input:focus{
    border-color:#3b82f6;
}

.material-search input::placeholder{
    color:#64748b;
}

/* TABLA */

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.erp-table{
    width:100%;
    border-collapse:collapse;
    font-size:12px;
}

.erp-table th{
    background:#f1f5f9;
    color:#475569;
    font-size:10px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    padding:7px 10px;
    border-bottom:2px solid #c9d4e0;
    text-align:left;
    white-space:nowrap;
}

.erp-table td{
    padding:8px 10px;
    border-bottom:1px solid #f1f5f9;
    color:#1e293b;
    vertical-align:middle;
}

.erp-table tbody tr:hover td{
    background:#f8fafc;
}

/* BADGES */

.material-badge{
    display:inline-flex;
    align-items:center;
    padding:3px 7px;
    border-radius:3px;
    font-size:9px;
    font-weight:700;
    letter-spacing:.04em;
}

.badge-label{
    background:#dbeafe;
    color:#1d4ed8;
}

.badge-sticker{
    background:#f3e8ff;
    color:#7e22ce;
}

.badge-precinto{
    background:#fee2e2;
    color:#b91c1c;
}

.badge-caja{
    background:#fef3c7;
    color:#b45309;
}

.stock-ok{
    color:#15803d;
    font-weight:700;
}

.stock-low{
    color:#b45309;
    font-weight:700;
}

.stock-empty{
    color:#b91c1c;
    font-weight:700;
}

.qty-input{
    width:85px;
    padding:5px 7px;
    border:1px solid #c9d4e0;
    border-radius:3px;
    font-size:12px;
    text-align:center;
}

.qty-input:focus{
    border-color:#1e3a5f;
    outline:none;
}

.btn-remove{
    border:none;
    background:#fee2e2;
    color:#b91c1c;
    border:1px solid #fecaca;
    border-radius:3px;
    padding:4px 7px;
    cursor:pointer;
}

/* RESUMEN */

.summary-table{
    width:100%;
    font-size:12px;
    border-collapse:collapse;
}

.summary-table td{
    padding:6px;
    border-bottom:1px solid #f1f5f9;
    color:#475569;
}

.summary-table td:last-child{
    text-align:right;
    font-weight:700;
    color:#1e293b;
}

.total-row td{
    border-top:2px solid #c9d4e0;
    padding-top:9px;
    font-size:14px;
    color:#1e3a5f !important;
}

/* ALERTAS */

.alert-ok{
    background:#f0fdf4;
    border:1px solid #bbf7d0;
    border-radius:3px;
    padding:7px 10px;
    font-size:12px;
    color:#15803d;
    margin-bottom:8px;
}

.alert-warn{
    background:#fef3c7;
    border:1px solid #fde68a;
    border-radius:3px;
    padding:7px 10px;
    font-size:12px;
    color:#b45309;
    margin-bottom:8px;
}

/* FOOTER FORM */

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:8px;
    padding-top:10px;
}

@media(max-width:700px){

    .form-grid,
    .form-grid.three{
        grid-template-columns:1fr;
    }

    .form-full{
        grid-column:auto;
    }

    .erp-breadcrumb{
        display:none;
    }

    .erp-user{
        display:none;
    }

    .order-header{
        align-items:flex-start;
    }

    .form-actions{
        flex-direction:column;
    }

    .form-actions a,
    .form-actions button{
        width:100%;
        justify-content:center;
    }

    .erp-table{
        min-width:650px;
    }
}
</style>


{{-- ERP TOP BAR --}}
<div class="erp-bar">

    <div class="erp-bar-title">
        DISTAN · Sistema ERP
    </div>

    <div style="display:flex;align-items:center;gap:12px;">

        <span class="erp-breadcrumb">
            Operaciones › Abastecimiento a Plantas › Nueva orden
        </span>

        <span class="erp-user">
            👤 {{ auth()->user()->name ?? 'Operador' }}
        </span>

    </div>

</div>


<div class="pg">

    {{-- HEADER --}}
    <div class="order-header">

        <div>

            <div class="order-id">
                🚚 Nueva orden de abastecimiento
            </div>

            <div class="order-sub">
                Registro de suministros destinados a una planta externa
            </div>

        </div>

        <a href="{{ url('/dashboard') }}" class="btn-cancel">
            ← Volver
        </a>

    </div>


    <form method="POST" action="{{ route('supply-orders.store') }}" id="supplyOrderForm">

        @csrf

        <div class="layout">

            {{-- ========================= --}}
            {{-- COLUMNA PRINCIPAL --}}
            {{-- ========================= --}}

            <div class="left-col">


                {{-- DATOS DE LA ORDEN --}}
                <div class="panel">

                    <div class="panel-header">

                        <div class="panel-title">
                            📋 Datos de la orden
                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="form-grid">

                            <div>
                                <label class="flabel">
                                    Planta
                                </label>

                                <input
                                    type="text"
                                    name="planta"
                                    class="finput"
                                    placeholder="Ej. Dalsa"
                                    value="{{ old('planta') }}"
                                    required
                                >
                            </div>


                            <div>
                                <label class="flabel">
                                    Fecha de solicitud
                                </label>

                                <input
                                    type="date"
                                    name="fecha_solicitud"
                                    class="finput"
                                    value="{{ old('fecha_solicitud', now()->format('Y-m-d')) }}"
                                    required
                                >
                            </div>


                            <div>
                                <label class="flabel">
                                    Fecha requerida
                                </label>

                                <input
                                    type="date"
                                    name="fecha_requerida"
                                    class="finput"
                                    value="{{ old('fecha_requerida') }}"
                                >
                            </div>


                            <div>
                                <label class="flabel">
                                    Cantidad de producción
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="cantidad_produccion"
                                    class="finput"
                                    placeholder="Ej. 1000"
                                    value="{{ old('cantidad_produccion') }}"
                                >
                            </div>


                            <div>
                                <label class="flabel">
                                    Producto
                                </label>
                <div>
    <label class="flabel">
        Producto
    </label>

    <select
        name="product_id"
        class="finput"
    >
        <option value="">
            Seleccionar producto
        </option>

        @foreach($products as $product)
                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >
                                {{ $product->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>


                            <div>
                                <label class="flabel">
                                    Lote
                                </label>

                                <input
                                    type="text"
                                    name="lote"
                                    class="finput"
                                    placeholder="Ej. LOT-2026-001"
                                    value="{{ old('lote') }}"
                                >
                            </div>


                            <div class="form-full">

                                <label class="flabel">
                                    Observaciones
                                </label>

                                <textarea
                                    name="observaciones"
                                    class="finput"
                                    placeholder="Observaciones de la producción o del abastecimiento..."
                                >{{ old('observaciones') }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- MATERIALES --}}
                <div class="panel">

                    <div class="panel-header">

                        <div class="panel-title">
                            📦 Materiales a enviar
                        </div>

                        <button
                            type="button"
                            class="btn-primary"
                            onclick="abrirMateriales()"
                        >
                            + Agregar material
                        </button>

                    </div>

                    <div class="panel-body">


                        <div class="material-search">

                            <span class="search-led"></span>

                            <input
                                type="text"
                                id="buscarMaterial"
                                placeholder="Buscar etiqueta, sticker, precinto o caja..."
                                oninput="buscarMateriales()"
                            >

                        </div>


                        <div style="height:10px;"></div>


                        <div class="table-wrapper">

                            <table class="erp-table">

                                <thead>

                                    <tr>

                                        <th>Tipo</th>
                                        <th>Material</th>
                                        <th>Detalle</th>
                                        <th>Stock actual</th>
                                        <th>Cantidad solicitada</th>
                                        <th></th>

                                    </tr>

                                </thead>

                                <tbody id="materialesBody">

                                    <tr id="sinMateriales">

                                        <td
                                            colspan="6"
                                            style="
                                                text-align:center;
                                                padding:25px;
                                                color:#94a3b8;
                                            "
                                        >
                                            📦 No hay materiales agregados.
                                            <br>
                                            <span style="font-size:10px;">
                                                Agrega los materiales que la planta necesita.
                                            </span>
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>


                        <div style="margin-top:8px;font-size:10px;color:#94a3b8;">
                            ℹ️ El stock no se descuenta al crear la orden.
                            Se descontará únicamente al registrar una salida.
                        </div>

                    </div>

                </div>


                {{-- ACCIONES --}}
                <div class="panel">

                    <div class="panel-body">

                        <div class="form-actions">

                            <a
                                href="{{ url('/dashboard') }}"
                                class="btn-cancel"
                            >
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="btn-primary"
                            >
                                💾 Crear orden de abastecimiento
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================= --}}
            {{-- COLUMNA DERECHA --}}
            {{-- ========================= --}}

            <div>


                <div class="panel">

                    <div class="panel-header">

                        <div class="panel-title">
                            📊 Resumen
                        </div>

                    </div>

                    <div class="panel-body">

                        <table class="summary-table">

                            <tr>
                                <td>Materiales</td>
                                <td id="resumenMateriales">0</td>
                            </tr>

                            <tr>
                                <td>Unidades solicitadas</td>
                                <td id="resumenCantidad">0</td>
                            </tr>

                            <tr class="total-row">
                                <td>Total líneas</td>
                                <td id="resumenLineas">0</td>
                            </tr>

                        </table>


                        <hr style="
                            border:none;
                            border-top:1px solid #e2e8f0;
                            margin:.8rem 0;
                        ">


                        <div class="alert-ok">

                            ✓ La orden puede registrarse aunque
                            el stock actual sea insuficiente.

                        </div>


                        <div style="
                            font-size:11px;
                            color:#64748b;
                            line-height:1.5;
                        ">

                            El sistema verificará el stock real
                            cuando se registre cada salida.

                            <br><br>

                            Esto permite enviar, por ejemplo:

                            <strong>600 de 1,000</strong>

                            y posteriormente completar las

                            <strong>400 restantes</strong>.

                        </div>

                    </div>

                </div>


                <div style="height:10px;"></div>


                <div class="panel">

                    <div class="panel-header">

                        <div class="panel-title">
                            🔄 Flujo
                        </div>

                    </div>

                    <div class="panel-body">

                        <div style="
                            font-size:11px;
                            color:#64748b;
                            line-height:1.8;
                        ">

                            <div>
                                <strong style="color:#1e3a5f;">
                                    1.
                                </strong>
                                Crear solicitud
                            </div>

                            <div>
                                <strong style="color:#1e3a5f;">
                                    2.
                                </strong>
                                Preparar materiales
                            </div>

                            <div>
                                <strong style="color:#1e3a5f;">
                                    3.
                                </strong>
                                Registrar salida
                            </div>

                            <div>
                                <strong style="color:#1e3a5f;">
                                    4.
                                </strong>
                                Descontar inventario
                            </div>

                            <div>
                                <strong style="color:#1e3a5f;">
                                    5.
                                </strong>
                                Completar entrega
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- ================================================= --}}
{{-- MODAL DE MATERIALES --}}
{{-- ================================================= --}}

<div
    id="materialModal"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.55);
        z-index:9999;
        align-items:center;
        justify-content:center;
        padding:1rem;
    "
>

    <div style="
        background:#fff;
        border-radius:6px;
        width:100%;
        max-width:850px;
        max-height:90vh;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,.25);
    ">


        <div style="
            background:#1e3a5f;
            padding:.7rem 1rem;
            display:flex;
            align-items:center;
            justify-content:space-between;
        ">

            <span style="
                color:#fff;
                font-size:13px;
                font-weight:700;
            ">
                📦 Seleccionar material
            </span>

            <button
                type="button"
                onclick="cerrarMateriales()"
                style="
                    background:none;
                    border:none;
                    color:#93c5fd;
                    font-size:18px;
                    cursor:pointer;
                "
            >
                ×
            </button>

        </div>


        <div style="
            padding:1rem;
            overflow:auto;
            max-height:calc(90vh - 55px);
        ">


            <div class="material-search">

                <span class="search-led"></span>

                <input
                    type="text"
                    id="modalBuscar"
                    placeholder="Buscar material..."
                    oninput="buscarMaterialesModal()"
                >

            </div>


            <div style="height:10px;"></div>


            <div class="table-wrapper">

                <table class="erp-table">

                    <thead>

                        <tr>
                            <th>Tipo</th>
                            <th>Material</th>
                            <th>Detalle</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody id="modalMaterialesBody">

                        <tr>

                            <td
                                colspan="6"
                                style="
                                    text-align:center;
                                    padding:25px;
                                    color:#94a3b8;
                                "
                            >
                                Buscando materiales...
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>

let materiales = [];


/* ================================================= */
/* MODAL */
/* ================================================= */

function abrirMateriales(){

    document.getElementById('materialModal').style.display = 'flex';

    cargarMateriales();

}

function cerrarMateriales(){

    document.getElementById('materialModal').style.display = 'none';

}


/* ================================================= */
/* CARGAR MATERIALES */
/* ================================================= */

async function cargarMateriales(search = ''){

    const body = document.getElementById('modalMaterialesBody');

    body.innerHTML = `
        <tr>
            <td colspan="6"
                style="text-align:center;padding:25px;color:#94a3b8;">
                Cargando materiales...
            </td>
        </tr>
    `;

    try{

        const url =
            `{{ route('supply-orders.materials') }}?search=${encodeURIComponent(search)}`;

        const response = await fetch(url);

        const result = await response.json();

        if(!result.success){

            throw new Error('No se pudieron cargar los materiales.');

        }

        renderMaterialesModal(result.data);

    }catch(error){

        body.innerHTML = `
            <tr>
                <td colspan="6"
                    style="text-align:center;padding:25px;color:#b91c1c;">
                    ❌ Error al cargar materiales.
                </td>
            </tr>
        `;

        console.error(error);

    }

}


/* ================================================= */
/* MODAL SEARCH */
/* ================================================= */

let searchTimer;

function buscarMaterialesModal(){

    clearTimeout(searchTimer);

    const search =
        document.getElementById('modalBuscar').value;

    searchTimer = setTimeout(() => {

        cargarMateriales(search);

    }, 250);

}


/* ================================================= */
/* RENDER MODAL */
/* ================================================= */

function renderMaterialesModal(data){

    const body =
        document.getElementById('modalMaterialesBody');

    if(!data.length){

        body.innerHTML = `
            <tr>
                <td colspan="6"
                    style="text-align:center;padding:25px;color:#94a3b8;">
                    No se encontraron materiales.
                </td>
            </tr>
        `;

        return;

    }


    body.innerHTML = data.map(material => {

        let badge = '';

        if(material.tipo === 'LABEL'){
            badge = `<span class="material-badge badge-label">LABEL</span>`;
        }

        if(material.tipo === 'STICKER'){
            badge = `<span class="material-badge badge-sticker">STICKER</span>`;
        }

        if(material.tipo === 'PRECINTO'){
            badge = `<span class="material-badge badge-precinto">PRECINTO</span>`;
        }

        if(material.tipo === 'CAJA'){
            badge = `<span class="material-badge badge-caja">CAJA</span>`;
        }


        let stockClass = 'stock-ok';

        if(Number(material.stock) <= 0){
            stockClass = 'stock-empty';
        }
        else if(Number(material.stock) <= Number(material.stock_minimo)){
            stockClass = 'stock-low';
        }


        return `

            <tr>

                <td>
                    ${badge}
                </td>

                <td>
                    <strong>${escapeHtml(material.nombre)}</strong>
                </td>

                <td>
                    <span style="font-size:10px;color:#64748b;">
                        ${escapeHtml(material.detalle ?? '—')}
                    </span>
                </td>

                <td class="${stockClass}">
                    ${Number(material.stock).toLocaleString()}
                </td>

                <td>
                    <span style="font-size:10px;">
                        ${escapeHtml(material.estado ?? '—')}
                    </span>
                </td>

                <td style="text-align:right;">

                    <button
                        type="button"
                        class="btn-primary"
                        onclick='agregarMaterial(${JSON.stringify(material)})'
                    >
                        + Agregar
                    </button>

                </td>

            </tr>

        `;

    }).join('');

}


/* ================================================= */
/* AGREGAR MATERIAL */
/* ================================================= */

function agregarMaterial(material){

    const existe = materiales.find(item =>
        item.tipo === material.tipo &&
        Number(item.id) === Number(material.id)
    );

    if(existe){

        alert('Este material ya fue agregado.');

        return;

    }


    materiales.push({

        tipo:material.tipo,
        id:material.id,
        nombre:material.nombre,
        detalle:material.detalle,
        stock:Number(material.stock),
        cantidad:0

    });


    renderMateriales();

    cerrarMateriales();

}


/* ================================================= */
/* RENDER PRINCIPAL */
/* ================================================= */

function renderMateriales(){

    const body =
        document.getElementById('materialesBody');

    if(!materiales.length){

        body.innerHTML = `

            <tr id="sinMateriales">

                <td colspan="6"
                    style="
                        text-align:center;
                        padding:25px;
                        color:#94a3b8;
                    ">

                    📦 No hay materiales agregados.

                    <br>

                    <span style="font-size:10px;">
                        Agrega los materiales que la planta necesita.
                    </span>

                </td>

            </tr>

        `;

        actualizarResumen();

        return;

    }


    body.innerHTML = materiales.map((material,index) => {

        let badge = '';

        if(material.tipo === 'LABEL'){
            badge = `<span class="material-badge badge-label">LABEL</span>`;
        }

        if(material.tipo === 'STICKER'){
            badge = `<span class="material-badge badge-sticker">STICKER</span>`;
        }

        if(material.tipo === 'PRECINTO'){
            badge = `<span class="material-badge badge-precinto">PRECINTO</span>`;
        }

        if(material.tipo === 'CAJA'){
            badge = `<span class="material-badge badge-caja">CAJA</span>`;
        }


        return `

            <tr>

                <td>
                    ${badge}
                </td>

                <td>
                    <strong>${escapeHtml(material.nombre)}</strong>

                    <input
                        type="hidden"
                        name="materiales[${index}][tipo]"
                        value="${escapeHtml(material.tipo)}"
                    >

                    <input
                        type="hidden"
                        name="materiales[${index}][id]"
                        value="${material.id}"
                    >
                </td>

                <td>
                    <span style="font-size:10px;color:#64748b;">
                        ${escapeHtml(material.detalle ?? '—')}
                    </span>
                </td>

                <td>
                    <span class="${
                        material.stock <= 0
                            ? 'stock-empty'
                            : material.stock <= 10
                                ? 'stock-low'
                                : 'stock-ok'
                    }">
                        ${Number(material.stock).toLocaleString()}
                    </span>
                </td>

                <td>

                    <input
                        type="number"
                        min="0.01"
                        step="0.01"
                        class="qty-input"
                        value="${material.cantidad || ''}"
                        onchange="actualizarCantidad(${index}, this.value)"
                        required
                    >

                    <input
                        type="hidden"
                        name="materiales[${index}][cantidad]"
                        id="cantidadHidden${index}"
                        value="${material.cantidad || ''}"
                    >

                </td>

                <td style="text-align:right;">

                    <button
                        type="button"
                        class="btn-remove"
                        onclick="eliminarMaterial(${index})"
                    >
                        🗑
                    </button>

                </td>

            </tr>

        `;

    }).join('');


    actualizarResumen();

}


/* ================================================= */
/* CANTIDAD */
/* ================================================= */

function actualizarCantidad(index,value){

    materiales[index].cantidad =
        Number(value) || 0;

    const hidden =
        document.getElementById(`cantidadHidden${index}`);

    if(hidden){
        hidden.value =
            materiales[index].cantidad;
    }

    actualizarResumen();

}


/* ================================================= */
/* ELIMINAR */
/* ================================================= */

function eliminarMaterial(index){

    materiales.splice(index,1);

    renderMateriales();

}


/* ================================================= */
/* RESUMEN */
/* ================================================= */

function actualizarResumen(){

    const totalMateriales =
        materiales.length;

    const totalCantidad =
        materiales.reduce(
            (total,item) =>
                total + Number(item.cantidad || 0),
            0
        );


    document.getElementById('resumenMateriales')
        .textContent =
        totalMateriales;

    document.getElementById('resumenLineas')
        .textContent =
        totalMateriales;

    document.getElementById('resumenCantidad')
        .textContent =
        totalCantidad.toLocaleString();

}


/* ================================================= */
/* BÚSQUEDA PRINCIPAL */
/* ================================================= */

let mainSearchTimer;

function buscarMateriales(){

    clearTimeout(mainSearchTimer);

    const search =
        document.getElementById('buscarMaterial').value;

    mainSearchTimer = setTimeout(() => {

        cargarMateriales(search);

    },250);

}


/* ================================================= */
/* SEGURIDAD HTML */
/* ================================================= */

function escapeHtml(value){

    if(value === null || value === undefined){
        return '';
    }

    return String(value)
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;')
        .replace(/'/g,'&#039;');

}


/* ================================================= */
/* VALIDACIÓN */
/* ================================================= */

document
    .getElementById('supplyOrderForm')
    .addEventListener('submit',function(event){

        if(materiales.length === 0){

            event.preventDefault();

            alert(
                'Debes agregar al menos un material a la orden.'
            );

            return;

        }


        const invalido =
            materiales.some(
                item => Number(item.cantidad) <= 0
            );


        if(invalido){

            event.preventDefault();

            alert(
                'Todas las cantidades solicitadas deben ser mayores a cero.'
            );

        }

    });

</script>

@endsection