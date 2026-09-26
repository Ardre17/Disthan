<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Reporte de Movimientos - DISTAN ERP</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f3f4f6;
            color: #111827;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .report-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #1f2937;
            padding-bottom: 18px;
            margin-bottom: 20px;
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .subtitle {
            margin-top: 4px;
            color: #6b7280;
            font-size: 11px;
        }

        .report-title {
            text-align: right;
        }

        .report-title h1 {
            margin: 0;
            font-size: 20px;
        }

        .report-title p {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 11px;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .filter {
            border: 1px solid #d1d5db;
            background: #f9fafb;
            border-radius: 5px;
            padding: 7px 10px;
        }

        .filter strong {
            color: #374151;
        }

        .kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 24px;
        }

        .kpi {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            background: #f9fafb;
        }

        .kpi-label {
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .kpi-value {
            font-size: 18px;
            font-weight: 800;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f2937;
            color: white;
            text-align: left;
            padding: 8px;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background: #f9fafb;
        }

        .type {
            font-weight: 700;
        }

        .quantity {
            text-align: right;
            white-space: nowrap;
        }

        .reference {
            font-family: Consolas, monospace;
            font-size: 11px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #d1d5db;
            display: flex;
            justify-content: space-between;
            color: #6b7280;
            font-size: 10px;
        }

        .print-actions {
            max-width: 1200px;
            margin: 0 auto 15px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .print-button,
        .back-button {
            border: 0;
            border-radius: 6px;
            padding: 9px 14px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
        }

        .print-button {
            background: #111827;
            color: white;
        }

        .back-button {
            background: #e5e7eb;
            color: #111827;
        }

        @media print {

    body {
        background: white;
        padding: 0;
    }

    .report-container {
        max-width: none;
        padding: 4mm 3mm;
    }

    .print-actions {
        display: none;
    }

    .header {
        margin-top: 0;
    }

    table {
        page-break-inside: auto;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }

    thead {
        display: table-header-group;
    }

    .footer {
        margin-bottom: 0;
    }

    @page {
        size: A4 landscape;
        margin: 18mm;
    }
}
        @media screen and (max-width: 768px) {

            body {
                padding: 10px;
            }

            .report-container {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
            }

            .report-title {
                text-align: left;
            }

            .kpis {
                grid-template-columns: repeat(2, 1fr);
            }

            table {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="print-actions">
        <button class="back-button" onclick="window.history.back()">
            ← Volver
        </button>

        <button class="print-button" onclick="window.print()">
            🖨️ Imprimir
        </button>
    </div>

    <div class="report-container">

        <div class="header">

            <div>
                <div class="brand">
                    DISTAN ERP
                </div>

                <div class="subtitle">
                    Warehouse & Production Management
                </div>
            </div>

            <div class="report-title">

                <h1>
                    Reporte de Movimientos
                </h1>

                <p>
                    Generado: {{ now()->format('d/m/Y H:i') }}
                </p>

            </div>

        </div>


        {{-- FILTROS APLICADOS --}}
        <div class="filters">

            <div class="filter">
                <strong>Desde:</strong>
                {{ $fechaInicio ? \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') : 'Todas' }}
            </div>

            <div class="filter">
                <strong>Hasta:</strong>
                {{ $fechaFin ? \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') : 'Todas' }}
            </div>

            <div class="filter">
                <strong>Tipo:</strong>

                @if($tipo === 'MATERIA_PRIMA')
                    Ingreso de materia prima
                @elseif($tipo === 'PRODUCCION')
                    Producción terminada
                @elseif($tipo === 'PEDIDO')
                    Pedido cerrado
                @else
                    Todos
                @endif
            </div>

            @if($busqueda)
                <div class="filter">
                    <strong>Búsqueda:</strong>
                    {{ $busqueda }}
                </div>
            @endif

        </div>


        {{-- KPIs --}}
        <div class="kpis">

            <div class="kpi">
                <div class="kpi-label">
                    Movimientos
                </div>

                <div class="kpi-value">
                    {{ number_format($totalMovimientos) }}
                </div>
            </div>

            <div class="kpi">
                <div class="kpi-label">
                    Materia prima
                </div>

                <div class="kpi-value">
                    {{ number_format($totalMateriaPrima, 2) }}
                </div>
            </div>

            <div class="kpi">
                <div class="kpi-label">
                    Producción
                </div>

                <div class="kpi-value">
                    {{ number_format($totalProduccion, 2) }}
                </div>
            </div>

            <div class="kpi">
                <div class="kpi-label">
                    Pedidos cerrados
                </div>

                <div class="kpi-value">
                    {{ number_format($pedidosCerrados) }}
                </div>
            </div>

        </div>


        {{-- DETALLE --}}
        <div class="section-title">
            Detalle de movimientos
        </div>

        @if($movimientos->count())

            <table>

                <thead>

                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Movimiento</th>
                        <th>Referencia</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Usuario</th>
                        <th>Observación</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($movimientos as $movimiento)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y H:i') }}
                            </td>

                            <td class="type">

                                @if($movimiento['tipo'] === 'MATERIA_PRIMA')
                                    Materia prima
                                @elseif($movimiento['tipo'] === 'PRODUCCION')
                                    Producción
                                @else
                                    Pedido
                                @endif

                            </td>

                            <td>
                                {{ $movimiento['titulo'] }}
                            </td>

                            <td class="reference">
                                {{ $movimiento['referencia'] }}
                            </td>

                            <td>
                                {{ $movimiento['descripcion'] }}
                            </td>

                            <td class="quantity">

                                @if($movimiento['cantidad'] !== null)
                                    {{ number_format($movimiento['cantidad'], 2) }}
                                @else
                                    —
                                @endif

                            </td>

                            <td>
                                {{ $movimiento['usuario'] }}
                            </td>

                            <td>
                                {{ $movimiento['observacion'] }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">
                No existen movimientos para los filtros seleccionados.
            </div>

        @endif


        <div class="footer">

            <div>
                DISTAN ERP · Reporte de Movimientos
            </div>

            <div>
                Total de registros: {{ number_format($totalMovimientos) }}
            </div>

        </div>

    </div>

</body>
</html>