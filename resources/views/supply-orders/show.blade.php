@extends('layouts.app')

@section('content')

<style>
*{
    box-sizing:border-box;
}

.pg{
    padding:1rem;
    background:#e8ecf0;
    min-height:100vh;
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


/* HEADER */

.page-header{
    background:#fff;
    border:1px solid #c9d4e0;
    border-top:4px solid #1e3a5f;
    border-radius:4px;
    padding:.85rem 1.1rem;
    margin-bottom:10px;

    display:flex;
    justify-content:space-between;
    align-items:center;
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

.btn-secondary{
    background:#f1f5f9;
    color:#475569;
    border:1px solid #cbd5e1;
    padding:7px 14px;
    border-radius:3px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
}


/* GRID */

.info-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
    margin-bottom:10px;
}

@media(max-width:850px){
    .info-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:500px){
    .info-grid{
        grid-template-columns:1fr;
    }
}


/* INFO */

.info-card{
    background:#fff;
    border:1px solid #c9d4e0;
    border-radius:4px;
    padding:10px 12px;
}

.info-label{
    font-size:9px;
    color:#64748b;
    text-transform:uppercase;
    font-weight:700;
    letter-spacing:.06em;
}

.info-value{
    color:#1e293b;
    font-size:13px;
    font-weight:700;
    margin-top:3px;
}


/* PANEL */

.panel{
    background:#fff;
    border:1px solid #c9d4e0;
    border-radius:4px;
    margin-bottom:10px;
}

.panel-header{
    background:#f1f5f9;
    border-bottom:1px solid #c9d4e0;
    padding:.6rem 1rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.panel-title{
    font-size:12px;
    font-weight:700;
    color:#1e3a5f;
    text-transform:uppercase;
    letter-spacing:.06em;
}

.panel-body{
    padding:0;
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
    background:#f8fafc;
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


/* MATERIAL */

.material-name{
    font-weight:700;
    color:#1e3a5f;
}

.material-type{
    display:inline-block;
    padding:3px 7px;
    border-radius:3px;
    font-size:9px;
    font-weight:700;
}

.type-label{
    background:#dbeafe;
    color:#1d4ed8;
}

.type-sticker{
    background:#f3e8ff;
    color:#7e22ce;
}

.type-precinto{
    background:#fee2e2;
    color:#b91c1c;
}

.type-caja{
    background:#fef3c7;
    color:#b45309;
}


/* PROGRESO */

.progress-container{
    min-width:140px;
}

.progress-top{
    display:flex;
    justify-content:space-between;
    font-size:10px;
    margin-bottom:4px;
}

.progress-bar{
    height:7px;
    background:#e2e8f0;
    border-radius:99px;
    overflow:hidden;
}

.progress-fill{
    height:100%;
    background:#1e3a5f;
    border-radius:99px;
}


/* ESTADO */

.status{
    display:inline-flex;
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


/* ALERTA */

.alert{
    margin:10px;
    padding:9px 11px;
    border-radius:3px;
    font-size:11px;
}

.alert-error{
    background:#fef2f2;
    border:1px solid #fecaca;
    color:#991b1b;
}

.alert-success{
    background:#f0fdf4;
    border:1px solid #bbf7d0;
    color:#166534;
}


/* ACCIONES */

.actions{
    display:flex;
    gap:7px;
    flex-wrap:wrap;
}

@media(max-width:650px){

    .erp-breadcrumb,
    .erp-user{
        display:none;
    }

    .actions{
        width:100%;
    }

    .actions a{
        flex:1;
        justify-content:center;
    }

    .erp-table{
        min-width:800px;
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
            Operaciones › Abastecimiento › {{ $supplyOrder->numero_orden }}
        </span>

        <span class="erp-user">
            👤 {{ auth()->user()->name ?? 'Operador' }}
        </span>

    </div>

</div>


<div class="pg">


    {{-- MENSAJES --}}

    @if(session('success'))

        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <strong>⚠ Atención</strong>

            <ul style="margin:5px 0 0 18px;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- HEADER --}}

    <div class="page-header">

        <div>

            <div class="page-title">
                📋 {{ $supplyOrder->numero_orden }}
            </div>

            <div class="page-subtitle">
                Detalle de la orden de abastecimiento
            </div>

        </div>

        <div class="actions">

    @if($supplyOrder->estado !== 'COMPLETADA')

        <a
            href="{{ route('supply-orders.dispatch.create', $supplyOrder) }}"
            class="btn-primary"
        >
            🚚 Registrar salida
        </a>

    @endif

    <a
        href="{{ route('supply-orders.index') }}"
        class="btn-secondary"
    >
        ← Volver
    </a>

</div>

    </div>


    {{-- INFORMACIÓN GENERAL --}}

    <div class="info-grid">

        <div class="info-card">

            <div class="info-label">
                Planta
            </div>

            <div class="info-value">
                🏭 {{ $supplyOrder->planta }}
            </div>

        </div>


        <div class="info-card">

            <div class="info-label">
                Fecha solicitud
            </div>

            <div class="info-value">
                {{ optional($supplyOrder->fecha_solicitud)->format('d/m/Y') }}
            </div>

        </div>


        <div class="info-card">

            <div class="info-label">
                Fecha requerida
            </div>

            <div class="info-value">
                {{ optional($supplyOrder->fecha_requerida)->format('d/m/Y') ?: '—' }}
            </div>

        </div>


        <div class="info-card">

            <div class="info-label">
                Lote
            </div>

            <div class="info-value">
                {{ $supplyOrder->lote ?: '—' }}
            </div>

        </div>

    </div>


    {{-- MATERIALES --}}

    <div class="panel">

        <div class="panel-header">

            <div class="panel-title">
                📦 Materiales solicitados
            </div>

            <span style="
                font-size:10px;
                color:#64748b;
            ">
                {{ $supplyOrder->items->count() }} líneas
            </span>

        </div>


        <div class="table-wrapper">

            <table class="erp-table">

                <thead>

                    <tr>

                        <th>Tipo</th>
                        <th>Material</th>
                        <th>Solicitado</th>
                        <th>Entregado</th>
                        <th>Pendiente</th>
                        <th>Avance</th>

                    </tr>

                </thead>


                <tbody>

                @foreach($supplyOrder->items as $item)

                    @php

                        $solicitado =
                            (float) $item->cantidad_solicitada;

                        $entregado =
                            (float) $item->dispatchItems->sum(
                                fn($dispatch) =>
                                    (float) $dispatch->cantidad
                            );

                        $pendiente =
                            max(0, $solicitado - $entregado);

                        $porcentaje =
                            $solicitado > 0
                                ? min(
                                    100,
                                    round(
                                        ($entregado / $solicitado) * 100
                                    )
                                )
                                : 0;

                        $tipoClase = match($item->tipo_material){

                            'LABEL' =>
                                'type-label',

                            'STICKER' =>
                                'type-sticker',

                            'PRECINTO' =>
                                'type-precinto',

                            'CAJA' =>
                                'type-caja',

                            default => '',
                        };

                    @endphp


                    <tr>

                        <td>

                            <span class="material-type {{ $tipoClase }}">
                                {{ $item->tipo_material }}
                            </span>

                        </td>


                        <td>

                            <div class="material-name">

                                {{ $item->material_id }}

                            </div>

                            <div style="
                                font-size:9px;
                                color:#94a3b8;
                            ">
                                ID del material
                            </div>

                        </td>


                        <td>

                            <strong>
                                {{ number_format($solicitado, 2) }}
                            </strong>

                        </td>


                        <td>

                            <strong style="color:#166534;">
                                {{ number_format($entregado, 2) }}
                            </strong>

                        </td>


                        <td>

                            <strong
                                style="
                                    color:
                                    {{ $pendiente > 0
                                        ? '#b45309'
                                        : '#166534' }};
                                "
                            >
                                {{ number_format($pendiente, 2) }}
                            </strong>

                        </td>


                        <td>

                            <div class="progress-container">

                                <div class="progress-top">

                                    <span>
                                        {{ $entregado }}
                                        /
                                        {{ $solicitado }}
                                    </span>

                                    <strong>
                                        {{ $porcentaje }}%
                                    </strong>

                                </div>

                                <div class="progress-bar">

                                    <div
                                        class="progress-fill"
                                        style="width:{{ $porcentaje }}%;"
                                    ></div>

                                </div>

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>


    {{-- OBSERVACIONES --}}

    @if($supplyOrder->observaciones)

        <div class="panel">

            <div class="panel-header">

                <div class="panel-title">
                    📝 Observaciones
                </div>

            </div>

            <div style="
                padding:12px;
                font-size:12px;
                color:#475569;
                line-height:1.5;
            ">
                {{ $supplyOrder->observaciones }}
            </div>

        </div>

    @endif


    {{-- SALIDAS --}}

    <div class="panel">

        <div class="panel-header">

            <div class="panel-title">
                🚚 Historial de salidas
            </div>

            <span style="
                font-size:10px;
                color:#64748b;
            ">
                {{ $supplyOrder->dispatches->count() }} salidas
            </span>

        </div>


        @if($supplyOrder->dispatches->count())

            <div class="table-wrapper">

                <table class="erp-table">

                    <thead>

                        <tr>
                            <th>Salida</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                        </tr>

                    </thead>

                    <tbody>

                    @foreach($supplyOrder->dispatches as $dispatch)

                        <tr>

                            <td>
                                <strong>
                                    {{ $dispatch->numero_salida }}
                                </strong>
                            </td>

                            <td>
                                {{ optional($dispatch->fecha_salida)->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                {{ $dispatch->observaciones ?: '—' }}
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div style="
                padding:30px;
                text-align:center;
                color:#94a3b8;
                font-size:11px;
            ">

                🚚 Todavía no se han registrado salidas para esta orden.

            </div>

        @endif

    </div>


    {{-- ACCIONES --}}

    <div style="
        display:flex;
        justify-content:flex-end;
        gap:8px;
    ">

        @if($supplyOrder->dispatches->count() === 0)

            <form
                method="POST"
                action="{{ route('supply-orders.destroy', $supplyOrder) }}"
                onsubmit="return confirm(
                    '¿Eliminar la orden {{ $supplyOrder->numero_orden }}?'
                );"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    style="
                        background:#fee2e2;
                        color:#b91c1c;
                        border:1px solid #fecaca;
                        border-radius:3px;
                        padding:7px 12px;
                        font-size:11px;
                        font-weight:600;
                        cursor:pointer;
                    "
                >
                    🗑 Eliminar orden
                </button>

            </form>

        @endif

    </div>

</div>

@endsection