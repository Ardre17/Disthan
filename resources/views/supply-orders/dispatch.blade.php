@extends('layouts.app')

@section('content')
        <div style="display:flex; align-items:center; justify-content:space-between; gap:20px;">
            <div>
                <h2 style="margin:0; font-size:1.5rem; font-weight:800; color:#e5f7ff;">
                    🚚 Registrar salida
                </h2>

                <p style="margin:5px 0 0; color:#8da5b8; font-size:0.85rem;">
                    Registra los suministros que serán enviados a la planta.
                </p>
            </div>

            <a href="{{ route('supply-orders.show', $supplyOrder) }}"
               style="
                    text-decoration:none;
                    color:#d7e9f4;
                    background:#102235;
                    border:1px solid #20384d;
                    padding:10px 16px;
                    border-radius:10px;
                    font-size:0.85rem;
                    font-weight:700;
               ">
                ← Volver al detalle
            </a>
        </div>



    {{-- CONTENIDO --}}
    <div style="
        width:100%;
        max-width:1400px;
        margin:0 auto;
        padding:24px;
        box-sizing:border-box;
    ">

        {{-- ERRORES --}}
        @if($errors->any())
            <div style="
                background:#3b1116;
                border:1px solid #7f1d1d;
                color:#fecaca;
                padding:15px 18px;
                border-radius:12px;
                margin-bottom:20px;
            ">
                <strong>⚠ No se pudo registrar la salida</strong>

                <ul style="margin:8px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- INFORMACIÓN DE LA ORDEN --}}
        <div style="
            display:grid;
            grid-template-columns:repeat(4, minmax(0,1fr));
            gap:14px;
            margin-bottom:22px;
        ">

            <div class="supply-info-card">
                <span>ORDEN DE ABASTECIMIENTO</span>
                <strong>
                    {{ $supplyOrder->numero_orden }}
                </strong>
            </div>

            <div class="supply-info-card">
                <span>PLANTA</span>
                <strong>
                    {{ $supplyOrder->planta }}
                </strong>
            </div>

            <div class="supply-info-card">
                <span>FECHA REQUERIDA</span>
                <strong>
                    {{ $supplyOrder->fecha_requerida
                        ? $supplyOrder->fecha_requerida->format('d/m/Y')
                        : '—'
                    }}
                </strong>
            </div>

            <div class="supply-info-card">
                <span>ESTADO</span>
                <strong class="estado-text">
                    {{ $supplyOrder->estado }}
                </strong>
            </div>

        </div>


        {{-- CALCULAR TOTALES --}}
        @php
            $totalSolicitado = 0;
            $totalEntregado = 0;
            $totalPendiente = 0;

            foreach ($supplyOrder->items as $item) {
                $totalSolicitado += (float) $item->cantidad_solicitada;
                $totalEntregado += (float) $item->cantidad_entregada;
                $totalPendiente += (float) $item->cantidad_pendiente;
            }

            $porcentaje = $totalSolicitado > 0
                ? round(($totalEntregado / $totalSolicitado) * 100, 1)
                : 0;
        @endphp


        {{-- RESUMEN --}}
        <div style="
            background:#081827;
            border:1px solid #142d40;
            border-radius:16px;
            padding:20px;
            margin-bottom:22px;
        ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:12px;
            ">
                <div>
                    <div style="
                        color:#91a8ba;
                        font-size:0.75rem;
                        font-weight:700;
                        text-transform:uppercase;
                    ">
                        Progreso de entrega
                    </div>

                    <div style="
                        color:#e8f5fb;
                        font-size:1.6rem;
                        font-weight:800;
                        margin-top:4px;
                    ">
                        {{ $porcentaje }}%
                    </div>
                </div>

                <div style="text-align:right;">
                    <div style="color:#7f9aae; font-size:0.8rem;">
                        Entregado
                    </div>

                    <strong style="color:#55d6e8;">
                        {{ number_format($totalEntregado, 2) }}
                    </strong>

                    <span style="color:#688094;">
                        /
                    </span>

                    <strong style="color:#dbeaf2;">
                        {{ number_format($totalSolicitado, 2) }}
                    </strong>
                </div>
            </div>


            <div style="
                height:9px;
                background:#10283a;
                border-radius:20px;
                overflow:hidden;
            ">
                <div style="
                    width:{{ min(100, $porcentaje) }}%;
                    height:100%;
                    background:linear-gradient(90deg,#0891b2,#22d3ee);
                    border-radius:20px;
                "></div>
            </div>

            <div style="
                margin-top:9px;
                color:#7891a4;
                font-size:0.8rem;
            ">
                Pendiente:
                <strong style="color:#fbbf24;">
                    {{ number_format($totalPendiente, 2) }}
                </strong>
            </div>

        </div>


        {{-- FORMULARIO --}}
        <form method="POST"
              action="{{ route('supply-orders.dispatch.store', $supplyOrder) }}">

            @csrf

            <div style="
                background:#081827;
                border:1px solid #142d40;
                border-radius:16px;
                overflow:hidden;
            ">

                {{-- CABECERA --}}
                <div style="
                    padding:20px 22px;
                    border-bottom:1px solid #142d40;
                ">

                    <h3 style="
                        margin:0;
                        color:#e5f5fb;
                        font-size:1.05rem;
                        font-weight:800;
                    ">
                        📦 Suministros a enviar
                    </h3>

                    <p style="
                        margin:5px 0 0;
                        color:#728b9e;
                        font-size:0.8rem;
                    ">
                        Ingresa solamente las cantidades que saldrán en esta entrega.
                        Puedes realizar entregas parciales.
                    </p>

                </div>


                {{-- TABLA --}}
                <div style="overflow-x:auto;">

                    <table style="
                        width:100%;
                        border-collapse:collapse;
                        min-width:900px;
                    ">

                        <thead>
                            <tr style="background:#0b1d2d;">

                                <th class="supply-th">
                                    SUMINISTRO
                                </th>

                                <th class="supply-th">
                                    SOLICITADO
                                </th>

                                <th class="supply-th">
                                    ENTREGADO
                                </th>

                                <th class="supply-th">
                                    PENDIENTE
                                </th>

                                <th class="supply-th">
                                    STOCK ACTUAL
                                </th>

                                <th class="supply-th">
                                    CANTIDAD A ENVIAR
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            @forelse($supplyOrder->items as $item)

                                @php
                                    $materialService = app(\App\Services\SupplyMaterialService::class);

                                    $material = $materialService->find(
                                        $item->tipo_material,
                                        $item->material_id
                                    );

                                    $solicitado = (float) $item->cantidad_solicitada;
                                    $entregado = (float) $item->cantidad_entregada;
                                    $pendiente = (float) $item->cantidad_pendiente;

                                    $stock = $material
                                        ? (float) ($material['stock'] ?? 0)
                                        : 0;

                                    $stockMinimo = $material
                                        ? (float) ($material['stock_minimo'] ?? 0)
                                        : 0;

                                    $stockBajo = $stock <= $stockMinimo;
                                @endphp

                                <tr style="border-top:1px solid #142d40;">

                                    {{-- MATERIAL --}}
                                    <td style="padding:17px 18px;">

                                        <div style="
                                            color:#e3f1f7;
                                            font-weight:800;
                                        ">
                                            {{ $material['nombre'] ?? 'Material no encontrado' }}
                                        </div>

                                        <div style="
                                            margin-top:4px;
                                            color:#71899b;
                                            font-size:0.75rem;
                                        ">
                                            {{ $item->tipo_material }}
                                            · ID {{ $item->material_id }}
                                        </div>

                                    </td>


                                    {{-- SOLICITADO --}}
                                    <td class="supply-number">
                                        {{ number_format($solicitado, 2) }}
                                    </td>


                                    {{-- ENTREGADO --}}
                                    <td class="supply-number">
                                        {{ number_format($entregado, 2) }}
                                    </td>


                                    {{-- PENDIENTE --}}
                                    <td>
                                        <span style="
                                            display:inline-block;
                                            padding:5px 9px;
                                            border-radius:7px;
                                            background:#3b2b0b;
                                            color:#fbbf24;
                                            font-weight:800;
                                            font-size:0.8rem;
                                        ">
                                            {{ number_format($pendiente, 2) }}
                                        </span>
                                    </td>


                                    {{-- STOCK --}}
                                    <td>

                                        <span style="
                                            color:{{ $stockBajo ? '#fb7185' : '#67e8f9' }};
                                            font-weight:800;
                                        ">
                                            {{ number_format($stock, 2) }}
                                        </span>

                                        @if($stockBajo)
                                            <div style="
                                                color:#fb7185;
                                                font-size:0.7rem;
                                                margin-top:3px;
                                            ">
                                                ⚠ Stock bajo
                                            </div>
                                        @endif

                                    </td>


                                    {{-- CANTIDAD --}}
                                    <td style="padding:14px 18px;">

                                        @if($pendiente > 0)

                                            <input
                                                type="number"
                                                name="cantidades[{{ $item->id }}]"
                                                min="0"
                                                max="{{ $pendiente }}"
                                                step="0.01"
                                                value="0"
                                                class="cantidad-salida"
                                                data-pendiente="{{ $pendiente }}"
                                                style="
                                                    width:150px;
                                                    background:#0d2233;
                                                    color:#e8f7fc;
                                                    border:1px solid #24445a;
                                                    border-radius:9px;
                                                    padding:10px 12px;
                                                    font-size:0.95rem;
                                                    font-weight:700;
                                                    outline:none;
                                                "
                                            >

                                            <div style="
                                                margin-top:5px;
                                                color:#627c90;
                                                font-size:0.7rem;
                                            ">
                                                Máximo:
                                                {{ number_format($pendiente, 2) }}
                                            </div>

                                        @else

                                            <span style="
                                                color:#4ade80;
                                                font-weight:800;
                                                font-size:0.8rem;
                                            ">
                                                ✓ Completo
                                            </span>

                                            <input
                                                type="hidden"
                                                name="cantidades[{{ $item->id }}]"
                                                value="0"
                                            >

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6"
                                        style="
                                            padding:50px;
                                            text-align:center;
                                            color:#71899b;
                                        ">
                                        No hay suministros registrados en esta orden.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- OBSERVACIONES --}}
                <div style="
                    padding:20px 22px;
                    border-top:1px solid #142d40;
                ">

                    <label style="
                        display:block;
                        color:#b8ceda;
                        font-weight:700;
                        font-size:0.8rem;
                        margin-bottom:8px;
                    ">
                        Observaciones de la salida
                    </label>

                    <textarea
                        name="observaciones"
                        rows="3"
                        placeholder="Ej: Entrega parcial para producción..."
                        style="
                            width:100%;
                            box-sizing:border-box;
                            resize:vertical;
                            background:#0a1d2c;
                            color:#e5f5fb;
                            border:1px solid #203b4f;
                            border-radius:10px;
                            padding:12px;
                            outline:none;
                        "
                    >{{ old('observaciones') }}</textarea>

                </div>


                {{-- FOOTER --}}
                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:15px;
                    padding:18px 22px;
                    background:#071522;
                    border-top:1px solid #142d40;
                ">

                    <div style="
                        color:#7891a4;
                        font-size:0.8rem;
                    ">
                        Los stocks se descontarán solamente al confirmar la salida.
                    </div>

                    <div style="display:flex; gap:10px;">

                        <a href="{{ route('supply-orders.show', $supplyOrder) }}"
                           style="
                                text-decoration:none;
                                padding:11px 18px;
                                border-radius:9px;
                                background:#172738;
                                color:#c9dbe5;
                                border:1px solid #294154;
                                font-weight:700;
                                font-size:0.85rem;
                           ">
                            Cancelar
                        </a>

                        <button type="submit"
                                style="
                                    border:none;
                                    cursor:pointer;
                                    padding:11px 20px;
                                    border-radius:9px;
                                    background:linear-gradient(135deg,#0891b2,#06b6d4);
                                    color:white;
                                    font-weight:800;
                                    font-size:0.85rem;
                                ">
                            ✓ Confirmar salida
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>


    <style>

        .supply-info-card {
            background:#081827;
            border:1px solid #142d40;
            border-radius:14px;
            padding:17px 18px;
            min-width:0;
        }

        .supply-info-card span {
            display:block;
            color:#647d90;
            font-size:0.68rem;
            font-weight:800;
            letter-spacing:.04em;
            margin-bottom:7px;
        }

        .supply-info-card strong {
            color:#dcecf4;
            font-size:0.95rem;
        }

        .supply-info-card .estado-text {
            color:#22d3ee;
        }

        .supply-th {
            padding:13px 18px;
            text-align:left;
            color:#6f8799;
            font-size:0.68rem;
            font-weight:800;
            letter-spacing:.04em;
        }

        .supply-number {
            padding:14px 18px;
            color:#c9dbe5;
            font-weight:700;
        }

        @media (max-width:900px) {

            .supply-info-card {
                grid-column:span 2;
            }

        }

        @media (max-width:600px) {

            .supply-info-card {
                grid-column:span 4;
            }

        }

    </style>


    <script>

        document.querySelectorAll('.cantidad-salida').forEach(function(input) {

            input.addEventListener('input', function() {

                let max = parseFloat(this.dataset.pendiente || 0);
                let value = parseFloat(this.value || 0);

                if (value < 0) {
                    this.value = 0;
                }

                if (value > max) {
                    this.value = max;
                }

            });

        });

    </script>
@endsection