@extends('layouts.app')

@section('content')

<style>
*{
    box-sizing:border-box;
}

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

.page-header{
    background:#fff;
    border:1px solid #c9d4e0;
    border-top:4px solid #1e3a5f;
    border-radius:4px;
    padding:.85rem 1.1rem;
    margin-bottom:.85rem;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    flex-wrap:wrap;
}

.page-title{
    font-size:16px;
    font-weight:700;
    color:#1e3a5f;
}

.page-subtitle{
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
}

.btn-primary:hover{
    opacity:.9;
}


/* KPIs */

.kpi-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
    margin-bottom:10px;
}

@media(max-width:900px){
    .kpi-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:500px){
    .kpi-grid{
        grid-template-columns:1fr;
    }
}

.kpi{
    background:#fff;
    border:1px solid #c9d4e0;
    border-radius:4px;
    padding:12px 14px;
    position:relative;
    overflow:hidden;
}

.kpi::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    bottom:0;
    width:4px;
    background:#1e3a5f;
}

.kpi.warning::before{
    background:#f59e0b;
}

.kpi.success::before{
    background:#16a34a;
}

.kpi.info::before{
    background:#2563eb;
}

.kpi-label{
    font-size:10px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:#64748b;
}

.kpi-value{
    font-size:22px;
    font-weight:700;
    color:#1e3a5f;
    margin-top:3px;
}

.kpi-description{
    font-size:10px;
    color:#94a3b8;
    margin-top:2px;
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
    gap:10px;
    flex-wrap:wrap;
}

.panel-title{
    font-size:12px;
    font-weight:700;
    color:#1e3a5f;
    text-transform:uppercase;
    letter-spacing:.06em;
}


/* FILTROS */

.filters{
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1fr 1fr auto;
    gap:7px;
    padding:.75rem 1rem;
    border-bottom:1px solid #e2e8f0;
}

@media(max-width:1100px){
    .filters{
        grid-template-columns:2fr 1fr 1fr;
    }
}

@media(max-width:650px){
    .filters{
        grid-template-columns:1fr;
    }
}

.filter-label{
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
    color:#64748b;
    margin-bottom:3px;
}

.filter-input{
    width:100%;
    padding:7px 8px;
    border:1px solid #c9d4e0;
    border-radius:3px;
    font-size:11px;
    color:#334155;
    background:#fff;
    outline:none;
}

.filter-input:focus{
    border-color:#1e3a5f;
}

.btn-filter{
    align-self:end;
    background:#1e3a5f;
    color:#fff;
    border:none;
    border-radius:3px;
    padding:7px 12px;
    font-size:11px;
    font-weight:600;
    cursor:pointer;
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
    letter-spacing:.05em;
    padding:8px 10px;
    border-bottom:2px solid #c9d4e0;
    text-align:left;
    white-space:nowrap;
}

.erp-table td{
    padding:9px 10px;
    border-bottom:1px solid #eef2f6;
    color:#1e293b;
    vertical-align:middle;
}

.erp-table tbody tr:hover td{
    background:#f8fafc;
}

.order-number{
    font-weight:700;
    color:#1e3a5f;
}

.plant{
    font-weight:600;
}

.date{
    font-size:11px;
    color:#64748b;
}


/* PROGRESO */

.progress-container{
    min-width:130px;
}

.progress-top{
    display:flex;
    justify-content:space-between;
    font-size:10px;
    margin-bottom:4px;
}

.progress-percent{
    font-weight:700;
    color:#1e3a5f;
}

.progress-bar{
    height:6px;
    background:#e2e8f0;
    border-radius:99px;
    overflow:hidden;
}

.progress-fill{
    height:100%;
    background:#1e3a5f;
    border-radius:99px;
    transition:width .3s;
}


/* ESTADOS */

.status{
    display:inline-flex;
    align-items:center;
    padding:3px 8px;
    border-radius:3px;
    font-size:9px;
    font-weight:700;
    text-transform:uppercase;
}

.status-pendiente{
    background:#fef3c7;
    color:#92400e;
}

.status-parcial{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-completada{
    background:#dcfce7;
    color:#166534;
}


/* BOTON VER */

.btn-view{
    background:#f1f5f9;
    color:#1e3a5f;
    border:1px solid #cbd5e1;
    border-radius:3px;
    padding:5px 8px;
    font-size:10px;
    font-weight:600;
    text-decoration:none;
    white-space:nowrap;
}

.btn-view:hover{
    background:#e2e8f0;
}


/* VACIO */

.empty{
    text-align:center;
    padding:45px 20px;
    color:#94a3b8;
}

.empty-icon{
    font-size:28px;
    margin-bottom:7px;
}

.empty-title{
    font-size:13px;
    font-weight:700;
    color:#64748b;
}

.empty-text{
    font-size:11px;
    margin-top:3px;
}


/* PAGINACION */

.pagination-area{
    padding:.7rem 1rem;
    border-top:1px solid #e2e8f0;
    display:flex;
    align-items:center;
    justify-content:space-between;
    font-size:10px;
    color:#64748b;
}

.pagination{
    display:flex;
    gap:3px;
}

.pagination a,
.pagination span{
    padding:5px 8px;
    border:1px solid #cbd5e1;
    border-radius:3px;
    text-decoration:none;
    color:#475569;
    background:#fff;
}

.pagination .active span{
    background:#1e3a5f;
    color:#fff;
    border-color:#1e3a5f;
}

@media(max-width:700px){

    .erp-breadcrumb,
    .erp-user{
        display:none;
    }

    .erp-table{
        min-width:900px;
    }

    .pagination-area{
        flex-direction:column;
        gap:8px;
        align-items:flex-start;
    }
}
</style>


{{-- TOP BAR --}}

<div class="erp-bar">

    <div class="erp-bar-title">
        DISTAN · Sistema ERP
    </div>

    <div style="display:flex;align-items:center;gap:12px;">

        <span class="erp-breadcrumb">
            Operaciones › Abastecimiento a Plantas
        </span>

        <span class="erp-user">
            👤 {{ auth()->user()->name ?? 'Operador' }}
        </span>

    </div>

</div>


<div class="pg">


    {{-- HEADER --}}

    <div class="page-header">

        <div>

            <div class="page-title">
                🚚 Abastecimiento a Plantas
            </div>

            <div class="page-subtitle">
                Gestión de solicitudes y salidas de suministros hacia plantas externas
            </div>

        </div>


        <a
            href="{{ route('supply-orders.create') }}"
            class="btn-primary"
        >
            + Nueva orden
        </a>

    </div>


    {{-- KPIs --}}

    <div class="kpi-grid">


        <div class="kpi warning">

            <div class="kpi-label">
                Pendientes
            </div>

            <div class="kpi-value">
                {{ $pendientes }}
            </div>

            <div class="kpi-description">
                Órdenes sin salida registrada
            </div>

        </div>


        <div class="kpi info">

            <div class="kpi-label">
                Parciales
            </div>

            <div class="kpi-value">
                {{ $parciales }}
            </div>

            <div class="kpi-description">
                Órdenes con entregas parciales
            </div>

        </div>


        <div class="kpi success">

            <div class="kpi-label">
                Completadas
            </div>

            <div class="kpi-value">
                {{ $completadas }}
            </div>

            <div class="kpi-description">
                Suministros entregados
            </div>

        </div>


        <div class="kpi">

            <div class="kpi-label">
                Salidas hoy
            </div>

            <div class="kpi-value">
                {{ $salidasHoy }}
            </div>

            <div class="kpi-description">
                Documentos de salida registrados
            </div>

        </div>

    </div>


    {{-- TABLA PRINCIPAL --}}

    <div class="panel">


        <div class="panel-header">

            <div class="panel-title">
                📋 Órdenes de abastecimiento
            </div>

        </div>


        {{-- FILTROS --}}

        <form
            method="GET"
            action="{{ route('supply-orders.index') }}"
            class="filters"
        >

            <div>

                <div class="filter-label">
                    Buscar
                </div>

                <input
                    type="text"
                    name="search"
                    class="filter-input"
                    placeholder="Orden o planta..."
                    value="{{ request('search') }}"
                >

            </div>


            <div>

                <div class="filter-label">
                    Planta
                </div>

                <select
                    name="planta"
                    class="filter-input"
                >

                    <option value="">
                        Todas
                    </option>

                    @foreach($plantas as $planta)

                        <option
                            value="{{ $planta }}"
                            {{ request('planta') == $planta ? 'selected' : '' }}
                        >
                            {{ $planta }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <div class="filter-label">
                    Estado
                </div>

                <select
                    name="estado"
                    class="filter-input"
                >

                    <option value="">
                        Todos
                    </option>

                    <option
                        value="PENDIENTE"
                        {{ request('estado') == 'PENDIENTE' ? 'selected' : '' }}
                    >
                        Pendiente
                    </option>

                    <option
                        value="PARCIAL"
                        {{ request('estado') == 'PARCIAL' ? 'selected' : '' }}
                    >
                        Parcial
                    </option>

                    <option
                        value="COMPLETADA"
                        {{ request('estado') == 'COMPLETADA' ? 'selected' : '' }}
                    >
                        Completada
                    </option>

                </select>

            </div>


            <div>

                <div class="filter-label">
                    Desde
                </div>

                <input
                    type="date"
                    name="fecha_desde"
                    class="filter-input"
                    value="{{ request('fecha_desde') }}"
                >

            </div>


            <div>

                <div class="filter-label">
                    Hasta
                </div>

                <input
                    type="date"
                    name="fecha_hasta"
                    class="filter-input"
                    value="{{ request('fecha_hasta') }}"
                >

            </div>


            <div>

                <button
                    type="submit"
                    class="btn-filter"
                >
                    🔎 Filtrar
                </button>

            </div>

        </form>


        {{-- TABLA --}}

        <div class="table-wrapper">

            <table class="erp-table">

                <thead>

                    <tr>

                        <th>Orden</th>

                        <th>Fecha</th>

                        <th>Planta</th>

                        <th>Lote</th>

                        <th>Materiales</th>

                        <th>Avance</th>

                        <th>Estado</th>

                        <th></th>

                    </tr>

                </thead>


                <tbody>

                @forelse($ordenes as $orden)

                    @php

                        $solicitado = $orden->items->sum(
                            fn($item) => (float) $item->cantidad_solicitada
                        );

                        $entregado = $orden->items->sum(
                            fn($item) => $item->dispatchItems->sum(
                                fn($dispatch) => (float) $dispatch->cantidad
                            )
                        );

                        $porcentaje = $solicitado > 0
                            ? min(100, round(($entregado / $solicitado) * 100))
                            : 0;

                    @endphp


                    <tr>

                        <td>

                            <div class="order-number">
                                {{ $orden->numero_orden }}
                            </div>

                        </td>


                        <td>

                            <div class="date">

                                {{ optional($orden->fecha_solicitud)->format('d/m/Y') }}

                            </div>

                        </td>


                        <td>

                            <div class="plant">
                                {{ $orden->planta }}
                            </div>

                        </td>


                        <td>

                            <span style="
                                font-size:11px;
                                color:#64748b;
                            ">

                                {{ $orden->lote ?: '—' }}

                            </span>

                        </td>


                        <td>

                            <strong>
                                {{ $orden->items->count() }}
                            </strong>

                            <span style="
                                font-size:10px;
                                color:#94a3b8;
                            ">
                                líneas
                            </span>

                        </td>


                        <td>

                            <div class="progress-container">

                                <div class="progress-top">

                                    <span>
                                        {{ number_format($entregado, 0) }}
                                        /
                                        {{ number_format($solicitado, 0) }}
                                    </span>

                                    <span class="progress-percent">
                                        {{ $porcentaje }}%
                                    </span>

                                </div>

                                <div class="progress-bar">

                                    <div
                                        class="progress-fill"
                                        style="width:{{ $porcentaje }}%;"
                                    ></div>

                                </div>

                            </div>

                        </td>


                        <td>

                            @if($orden->estado === 'PENDIENTE')

                                <span class="status status-pendiente">
                                    Pendiente
                                </span>

                            @elseif($orden->estado === 'PARCIAL')

                                <span class="status status-parcial">
                                    Parcial
                                </span>

                            @elseif($orden->estado === 'COMPLETADA')

                                <span class="status status-completada">
                                    Completada
                                </span>

                            @else

                                <span class="status">
                                    {{ $orden->estado }}
                                </span>

                            @endif

                        </td>


                        <td>

                            <a
                                href="#"
                                class="btn-view"
                            >
                                Ver detalle
                            </a>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="8">

                            <div class="empty">

                                <div class="empty-icon">
                                    📦
                                </div>

                                <div class="empty-title">
                                    No hay órdenes de abastecimiento
                                </div>

                                <div class="empty-text">
                                    Crea la primera orden para comenzar a gestionar los suministros.
                                </div>

                                <div style="margin-top:12px;">

                                    <a
                                        href="{{ route('supply-orders.create') }}"
                                        class="btn-primary"
                                    >
                                        + Crear primera orden
                                    </a>

                                </div>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}

        @if($ordenes->hasPages())

            <div class="pagination-area">

                <div>

                    Mostrando
                    {{ $ordenes->firstItem() }}
                    -
                    {{ $ordenes->lastItem() }}
                    de
                    {{ $ordenes->total() }}
                    órdenes

                </div>

                <div class="pagination">

                    {{ $ordenes->links() }}

                </div>

            </div>

        @endif


    </div>

</div>

@endsection