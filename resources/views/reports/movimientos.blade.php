@extends('layouts.app')

@section('content')

<style>
    .report-page {
        padding: 24px;
        max-width: 1500px;
        margin: 0 auto;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .report-title h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #172033;
    }

    .report-title p {
        margin: 6px 0 0;
        color: #718096;
        font-size: 14px;
    }

    .report-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef4ff;
        font-size: 23px;
    }

    /* =========================================================
       KPIs
    ========================================================= */

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .kpi-card {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .kpi-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kpi-label {
        font-size: 12px;
        color: #718096;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .kpi-value {
        margin-top: 10px;
        font-size: 28px;
        font-weight: 800;
        color: #172033;
    }

    .kpi-description {
        margin-top: 5px;
        font-size: 12px;
        color: #94a3b8;
    }

    .kpi-circle {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .kpi-blue {
        background: #eef4ff;
    }

    .kpi-green {
        background: #ecfdf3;
    }

    .kpi-orange {
        background: #fff7ed;
    }

    .kpi-purple {
        background: #f5f3ff;
    }

    /* =========================================================
       FILTROS
    ========================================================= */

    .filters-card {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .filters-title {
        font-size: 14px;
        font-weight: 800;
        color: #172033;
        margin-bottom: 14px;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1.5fr auto;
        gap: 12px;
        align-items: end;
    }

    .field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 6px;
    }

    .field input,
    .field select {
        width: 100%;
        height: 42px;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 0 12px;
        font-size: 13px;
        color: #1e293b;
        background: #fff;
        outline: none;
    }

    .field input:focus,
    .field select:focus {
        border-color: #7aa2ff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .08);
    }

    .filter-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-filter,
    .btn-clear {
        height: 42px;
        padding: 0 15px;
        border-radius: 10px;
        border: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn-filter {
        background: #2563eb;
        color: #fff;
    }

    .btn-filter:hover {
        background: #1d4ed8;
    }

    .btn-clear {
        background: #f1f5f9;
        color: #475569;
    }

    /* =========================================================
       TABLA
    ========================================================= */

    .movements-card {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
    }

    .movements-header {
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .movements-header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: #172033;
    }

    .movement-count {
        font-size: 12px;
        color: #64748b;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .movements-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .movements-table th {
        padding: 13px 18px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5eaf0;
    }

    .movements-table td {
        padding: 15px 18px;
        border-bottom: 1px solid #edf1f5;
        vertical-align: middle;
        font-size: 13px;
        color: #334155;
    }

    .movements-table tbody tr:hover {
        background: #fafcff;
    }

    .date-main {
        font-weight: 700;
        color: #1e293b;
    }

    .date-time {
        margin-top: 3px;
        font-size: 11px;
        color: #94a3b8;
    }

    .movement-main {
        font-weight: 700;
        color: #1e293b;
    }

    .movement-sub {
        margin-top: 3px;
        font-size: 11px;
        color: #94a3b8;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-material {
        background: #eef4ff;
        color: #2563eb;
    }

    .badge-production {
        background: #ecfdf3;
        color: #15803d;
    }

    .badge-order {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .quantity {
        font-weight: 800;
        color: #172033;
    }

    .detail-btn {
        border: 1px solid #dbe2ea;
        background: #fff;
        color: #475569;
        border-radius: 8px;
        padding: 7px 10px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 700;
    }

    .detail-btn:hover {
        background: #f8fafc;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .empty-state {
        padding: 55px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .empty-state strong {
        display: block;
        color: #475569;
        font-size: 15px;
        margin-bottom: 5px;
    }

    /* =========================================================
       PAGINACIÓN
    ========================================================= */

    .pagination-wrapper {
        padding: 16px 20px;
        border-top: 1px solid #edf1f5;
    }

    /* =========================================================
       MODAL
    ========================================================= */

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .48);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(15, 23, 42, .2);
    }

    .modal-header {
        padding: 18px 20px;
        border-bottom: 1px solid #edf1f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 16px;
        color: #172033;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        background: #f1f5f9;
        cursor: pointer;
        font-size: 18px;
        color: #475569;
    }

    .modal-body {
        padding: 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .detail-item span {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .detail-item strong {
        display: block;
        font-size: 13px;
        color: #1e293b;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1100px) {

        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-grid {
            grid-template-columns: 1fr 1fr;
        }

        .filter-buttons {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 700px) {

        .report-page {
            padding: 14px;
        }

        .report-header {
            margin-bottom: 18px;
        }

        .report-title h1 {
            font-size: 22px;
        }

        .kpi-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .kpi-card {
            padding: 14px;
        }

        .kpi-value {
            font-size: 22px;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .filter-buttons {
            grid-column: auto;
        }

        .btn-filter,
        .btn-clear {
            flex: 1;
        }

        /*
         * En móvil convertimos la tabla en tarjetas.
         */

        .table-wrapper {
            overflow: visible;
        }

        .movements-table {
            min-width: 0;
        }

        .movements-table thead {
            display: none;
        }

        .movements-table,
        .movements-table tbody,
        .movements-table tr,
        .movements-table td {
            display: block;
            width: 100%;
        }

        .movements-table tr {
            padding: 16px;
            border-bottom: 1px solid #edf1f5;
        }

        .movements-table td {
            border: none;
            padding: 5px 0;
        }

        .movements-table td::before {
            content: attr(data-label);
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .movements-table td:first-child::before {
            display: none;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
    .btn-imprimir-reporte {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 14px;
    border-radius: 8px;
    background: #111827;
    color: #ffffff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    border: 1px solid #1f2937;
    transition: .2s ease;
    cursor: pointer;
}

.btn-imprimir-reporte:hover {
    background: #374151;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .btn-imprimir-reporte {
        width: 100%;
    }
}
</style>

<div class="report-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="report-header">

        <div style="display:flex;gap:14px;align-items:flex-start;">

            <div class="report-icon">
                📊
            </div>

            <div class="report-title">
                <h1>Movimientos</h1>

                <p>
                    Registro cronológico de los principales movimientos de DISTAN.
                </p>
            </div>

        </div>
        <a
            href="{{ route('reports.movimientos.imprimir', request()->query()) }}"
            target="_blank"
            class="btn-imprimir-reporte"
        >
            🖨️ Imprimir reporte
        </a>

    </div>


    {{-- =====================================================
         KPIs
    ====================================================== --}}

    <div class="kpi-grid">

        <div class="kpi-card">

            <div class="kpi-top">

                <div class="kpi-label">
                    Movimientos
                </div>

                <div class="kpi-circle kpi-blue">
                    📋
                </div>

            </div>

            <div class="kpi-value">
                {{ number_format($totalMovimientos) }}
            </div>

            <div class="kpi-description">
                Registros encontrados
            </div>

        </div>


        <div class="kpi-card">

            <div class="kpi-top">

                <div class="kpi-label">
                    Materia prima
                </div>

                <div class="kpi-circle kpi-orange">
                    📦
                </div>

            </div>

            <div class="kpi-value">
                {{ number_format($totalMateriaPrima, 2) }}
            </div>

            <div class="kpi-description">
                Cantidad ingresada
            </div>

        </div>


        <div class="kpi-card">

            <div class="kpi-top">

                <div class="kpi-label">
                    Producción
                </div>

                <div class="kpi-circle kpi-green">
                    🏭
                </div>

            </div>

            <div class="kpi-value">
                {{ number_format($totalProduccion, 2) }}
            </div>

            <div class="kpi-description">
                Producto terminado
            </div>

        </div>


        <div class="kpi-card">

            <div class="kpi-top">

                <div class="kpi-label">
                    Pedidos cerrados
                </div>

                <div class="kpi-circle kpi-purple">
                    ✓
                </div>

            </div>

            <div class="kpi-value">
                {{ number_format($pedidosCerrados) }}
            </div>

            <div class="kpi-description">
                Pedidos completados
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTROS
    ====================================================== --}}

    <div class="filters-card">

        <div class="filters-title">
            Filtrar movimientos
        </div>

        <form method="GET"
              action="{{ route('reports.movimientos') }}">

            <div class="filters-grid">

                <div class="field">

                    <label>
                        Fecha inicial
                    </label>

                    <input
                        type="date"
                        name="fecha_inicio"
                        value="{{ $fechaInicio }}"
                    >

                </div>


                <div class="field">

                    <label>
                        Fecha final
                    </label>

                    <input
                        type="date"
                        name="fecha_fin"
                        value="{{ $fechaFin }}"
                    >

                </div>


                <div class="field">

                    <label>
                        Tipo
                    </label>

                    <select name="tipo">

                        <option value="">
                            Todos los movimientos
                        </option>

                        <option
                            value="MATERIA_PRIMA"
                            {{ $tipo === 'MATERIA_PRIMA' ? 'selected' : '' }}
                        >
                            Materia prima
                        </option>

                        <option
                            value="PRODUCCION"
                            {{ $tipo === 'PRODUCCION' ? 'selected' : '' }}
                        >
                            Producción
                        </option>

                        <option
                            value="PEDIDO"
                            {{ $tipo === 'PEDIDO' ? 'selected' : '' }}
                        >
                            Pedido cerrado
                        </option>

                    </select>

                </div>


                <div class="field">

                    <label>
                        Buscar
                    </label>

                    <input
                        type="text"
                        name="busqueda"
                        value="{{ $busqueda }}"
                        placeholder="Orden, producto, materia prima..."
                    >

                </div>


                <div class="filter-buttons">

                    <button
                        type="submit"
                        class="btn-filter"
                    >
                        🔎 Filtrar
                    </button>

                    <a
                        href="{{ route('reports.movimientos') }}"
                        class="btn-clear"
                    >
                        Limpiar
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         MOVIMIENTOS
    ====================================================== --}}

    <div class="movements-card">

        <div class="movements-header">

            <h2>
                Historial de movimientos
            </h2>

            <div class="movement-count">

                {{ $movimientosPaginados->total() }}

                registros

            </div>

        </div>


        @if($movimientosPaginados->count())

            <div class="table-wrapper">

                <table class="movements-table">

                    <thead>

                        <tr>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Tipo
                            </th>

                            <th>
                                Movimiento
                            </th>

                            <th>
                                Cantidad
                            </th>

                            <th>
                                Usuario
                            </th>

                            <th>
                                Referencia
                            </th>

                            <th>
                                Detalle
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($movimientosPaginados as $movimiento)

                            <tr>

                                {{-- FECHA --}}

                                <td data-label="Fecha">

                                    <div class="date-main">

                                        {{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y') }}

                                    </div>

                                    <div class="date-time">

                                        {{ \Carbon\Carbon::parse($movimiento['fecha'])->format('H:i') }}

                                    </div>

                                </td>


                                {{-- TIPO --}}

                                <td data-label="Tipo">

                                    @if($movimiento['tipo'] === 'MATERIA_PRIMA')

                                        <span class="badge badge-material">
                                            📦 Materia prima
                                        </span>

                                    @elseif($movimiento['tipo'] === 'PRODUCCION')

                                        <span class="badge badge-production">
                                            🏭 Producción
                                        </span>

                                    @else

                                        <span class="badge badge-order">
                                            ✓ Pedido cerrado
                                        </span>

                                    @endif

                                </td>


                                {{-- MOVIMIENTO --}}

                                <td data-label="Movimiento">

                                    <div class="movement-main">

                                        {{ $movimiento['titulo'] }}

                                    </div>

                                    <div class="movement-sub">

                                        {{ $movimiento['descripcion'] }}

                                    </div>

                                </td>


                                {{-- CANTIDAD --}}

                                <td data-label="Cantidad">

                                    @if($movimiento['cantidad'] !== null)

                                        <span class="quantity">

                                            {{ number_format($movimiento['cantidad'], 2) }}

                                        </span>

                                    @else

                                        <span style="color:#94a3b8;">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- USUARIO --}}

                                <td data-label="Usuario">

                                    {{ $movimiento['usuario'] }}

                                </td>


                                {{-- REFERENCIA --}}

                                <td data-label="Referencia">

                                    <strong>
                                        {{ $movimiento['referencia'] }}
                                    </strong>

                                </td>


                                {{-- DETALLE --}}

                                <td data-label="Detalle">

                                    <button
                                        type="button"
                                        class="detail-btn"
                                        onclick='mostrarDetalle(@json($movimiento))'
                                    >
                                        Ver detalle
                                    </button>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PAGINACIÓN --}}

            <div class="pagination-wrapper">

                {{ $movimientosPaginados->links() }}

            </div>


        @else

            <div class="empty-state">

                <div class="empty-icon">
                    📭
                </div>

                <strong>
                    No se encontraron movimientos
                </strong>

                <span>
                    Prueba cambiando los filtros de búsqueda.
                </span>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL
========================================================= --}}

<div
    id="detalleModal"
    class="modal-overlay"
    onclick="cerrarDetalle(event)"
>

    <div
        class="modal-box"
        onclick="event.stopPropagation()"
    >

        <div class="modal-header">

            <h3>
                Detalle del movimiento
            </h3>

            <button
                type="button"
                class="modal-close"
                onclick="cerrarDetalle()"
            >
                ×
            </button>

        </div>


        <div class="modal-body">

            <div class="detail-grid">

                <div class="detail-item">

                    <span>
                        Tipo
                    </span>

                    <strong id="detalleTipo">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Fecha
                    </span>

                    <strong id="detalleFecha">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Movimiento
                    </span>

                    <strong id="detalleTitulo">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Referencia
                    </span>

                    <strong id="detalleReferencia">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Descripción
                    </span>

                    <strong id="detalleDescripcion">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Cantidad
                    </span>

                    <strong id="detalleCantidad">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Usuario
                    </span>

                    <strong id="detalleUsuario">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        Relacionado con
                    </span>

                    <strong id="detalleTercero">
                        —
                    </strong>

                </div>


                <div
                    class="detail-item"
                    style="grid-column:1/-1;"
                >

                    <span>
                        Observación
                    </span>

                    <strong id="detalleObservacion">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

function mostrarDetalle(movimiento)
{
    document.getElementById('detalleTipo').textContent =
        movimiento.tipo || '—';

    document.getElementById('detalleFecha').textContent =
        formatearFecha(movimiento.fecha);

    document.getElementById('detalleTitulo').textContent =
        movimiento.titulo || '—';

    document.getElementById('detalleReferencia').textContent =
        movimiento.referencia || '—';

    document.getElementById('detalleDescripcion').textContent =
        movimiento.descripcion || '—';

    document.getElementById('detalleCantidad').textContent =
        movimiento.cantidad !== null &&
        movimiento.cantidad !== undefined
            ? movimiento.cantidad
            : '—';

    document.getElementById('detalleUsuario').textContent =
        movimiento.usuario || '—';

    document.getElementById('detalleTercero').textContent =
        movimiento.tercero || '—';

    document.getElementById('detalleObservacion').textContent =
        movimiento.observacion || '—';

    document
        .getElementById('detalleModal')
        .classList
        .add('active');
}


function cerrarDetalle(event)
{
    if (
        !event ||
        event.target.id === 'detalleModal'
    ) {

        document
            .getElementById('detalleModal')
            .classList
            .remove('active');
    }
}


function formatearFecha(fecha)
{
    if (!fecha) {
        return '—';
    }

    const date = new Date(
        fecha.replace(' ', 'T')
    );

    if (isNaN(date.getTime())) {
        return fecha;
    }

    return date.toLocaleString(
        'es-PE',
        {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }
    );
}

</script>

@endsection