@extends('layouts.app')

@section('content')
<style>

/* DISTAN ERP: identidad visual compartida y pantalla de carga */
.distan-loading{position:fixed;inset:0;z-index:99999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;background:rgba(243,247,253,.96);backdrop-filter:blur(4px);transition:opacity .25s ease,visibility .25s ease}
.distan-loading.is-hidden{opacity:0;visibility:hidden;pointer-events:none}
.distan-loading-mark{position:relative;width:76px;height:76px;display:flex;align-items:center;justify-content:center}
.distan-loading-mark svg{width:48px;height:48px;animation:distanPulse 1.35s ease-in-out infinite}
.distan-loading-ring{position:absolute;inset:0;border-radius:50%;border:3px solid #d6e4fb;border-top-color:#1e3a5f;animation:distanSpin .9s linear infinite}
.distan-loading-label{font-size:13px;font-weight:700;letter-spacing:.3px;color:#1e3a5f}
.distan-loading-track{width:150px;height:4px;border-radius:99px;background:#dbe6f6;overflow:hidden}
.distan-loading-track i{display:block;width:38%;height:100%;background:#2563eb;border-radius:99px;animation:distanSlide 1.1s ease-in-out infinite}
@keyframes distanSpin{to{transform:rotate(360deg)}}
@keyframes distanPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
@keyframes distanSlide{0%{margin-left:-40%}100%{margin-left:110%}}

</style>

<div id="distanLoading" class="distan-loading" aria-live="polite" aria-label="Cargando DISTAN ERP">
  <div class="distan-loading-mark">
    <div class="distan-loading-ring"></div>
    <svg viewBox="0 0 64 64" aria-hidden="true"><path fill="#1e3a5f" d="M32 4 57 18v28L32 60 7 46V18L32 4Zm0 7L14 21v22l18 10 18-10V21L32 11Z"/><path fill="#2563eb" d="m32 17 13 7.5v15L32 47l-13-7.5v-15L32 17Zm0 7-7 4v8l7 4 7-4v-8l-7-4Z"/></svg>
  </div>
  <div class="distan-loading-label">Cargando DISTAN ERP…</div>
  <div class="distan-loading-track"><i></i></div>
</div>

        <div style="display:flex; align-items:center; justify-content:space-between; gap:20px;">
            <div>
                <h2 style="margin:0; font-size:1.5rem; font-weight:800; color:#1e3a5f;">
                    🚚 Registrar salida
                </h2>

                <p style="margin:5px 0 0; color:#64748b; font-size:0.85rem;">
                    Registra los suministros que serán enviados a la planta.
                </p>
            </div>

            <a href="{{ route('supply-orders.show', $supplyOrder) }}"
               style="
                    text-decoration:none;
                    color:#475569;
                    background:#f1f5f9;
                    border:1px solid #cbd5e1;
                    padding:10px 16px;
                    border-radius:3px;
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
                border-radius:4px;
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
            background:#ffffff;
            border:1px solid #c9d4e0;
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
                        color:#64748b;
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
                    <div style="color:#64748b; font-size:0.8rem;">
                        Entregado
                    </div>

                    <strong style="color:#2563eb;">
                        {{ number_format($totalEntregado, 2) }}
                    </strong>

                    <span style="color:#64748b;">
                        /
                    </span>

                    <strong style="color:#334155;">
                        {{ number_format($totalSolicitado, 2) }}
                    </strong>
                </div>
            </div>


            <div style="
                height:9px;
                background:#f8fafc;
                border-radius:20px;
                overflow:hidden;
            ">
                <div style="
                    width:{{ min(100, $porcentaje) }}%;
                    height:100%;
                    background:linear-gradient(90deg,#1e3a5f,#2563eb);
                    border-radius:20px;
                "></div>
            </div>

            <div style="
                margin-top:9px;
                color:#64748b;
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
                background:#ffffff;
                border:1px solid #c9d4e0;
                border-radius:16px;
                overflow:hidden;
            ">

                {{-- CABECERA --}}
                <div style="
                    padding:20px 22px;
                    border-bottom:1px solid #c9d4e0;
                ">

                    <h3 style="
                        margin:0;
                        color:#1e3a5f;
                        font-size:1.05rem;
                        font-weight:800;
                    ">
                        📦 Suministros a enviar
                    </h3>

                    <p style="
                        margin:5px 0 0;
                        color:#64748b;
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
                            <tr style="background:#f8fafc;">

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

                                <tr style="border-top:1px solid #c9d4e0;">

                                    {{-- MATERIAL --}}
                                    <td style="padding:17px 18px;">

                                        <div style="
                                            color:#334155;
                                            font-weight:800;
                                        ">
                                            {{ $material['nombre'] ?? 'Material no encontrado' }}
                                        </div>

                                        <div style="
                                            margin-top:4px;
                                            color:#64748b;
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
                                            color:{{ $stockBajo ? '#fb7185' : '#2563eb' }};
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
                                                    border-radius:3px;
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
                                            color:#64748b;
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
                    border-top:1px solid #c9d4e0;
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
                            color:#1e3a5f;
                            border:1px solid #203b4f;
                            border-radius:3px;
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
                    border-top:1px solid #c9d4e0;
                ">

                    <div style="
                        color:#64748b;
                        font-size:0.8rem;
                    ">
                        Los stocks se descontarán solamente al confirmar la salida.
                    </div>

                    <div style="display:flex; gap:10px;">

                        <a href="{{ route('supply-orders.show', $supplyOrder) }}"
                           style="
                                text-decoration:none;
                                padding:11px 18px;
                                border-radius:3px;
                                background:#172738;
                                color:#334155;
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
                                    border-radius:3px;
                                    background:linear-gradient(135deg,#1e3a5f,#2563eb);
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
            background:#ffffff;
            border:1px solid #c9d4e0;
            border-radius:4px;
            padding:17px 18px;
            min-width:0;
        }

        .supply-info-card span {
            display:block;
            color:#64748b;
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
            color:#2563eb;
        }

        .supply-th {
            padding:13px 18px;
            text-align:left;
            color:#64748b;
            font-size:0.68rem;
            font-weight:800;
            letter-spacing:.04em;
        }

        .supply-number {
            padding:14px 18px;
            color:#334155;
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

<script>
(function () {
    var faviconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><path fill="#1e3a5f" d="M32 3 59 18v28L32 61 5 46V18L32 3Z"/><path fill="#fff" d="M32 13 49 23v18L32 51 15 41V23l17-10Z"/><path fill="#2563eb" d="M32 21 42 27v10L32 43 22 37V27l10-6Z"/></svg>';
    var favicon = document.querySelector('link[rel~="icon"]');
    if (!favicon) { favicon = document.createElement('link'); favicon.rel = 'icon'; document.head.appendChild(favicon); }
    favicon.type = 'image/svg+xml';
    favicon.href = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(faviconSvg);

    var loader = document.getElementById('distanLoading');
    function hideLoader(){ if(loader) loader.classList.add('is-hidden'); }
    if (document.readyState === 'complete') { setTimeout(hideLoader, 180); }
    else { window.addEventListener('load', function(){ setTimeout(hideLoader, 180); }, {once:true}); }
    document.addEventListener('submit', function(event) {
        if (event.defaultPrevented) return;
        var form = event.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (form.dataset.noLoading === 'true') return;
        if (loader) loader.classList.remove('is-hidden');
    });
    document.addEventListener('click', function(event) {
        var link = event.target.closest('a');
        if (!link || link.target === '_blank' || link.hasAttribute('download')) return;
        var href = link.getAttribute('href') || '';
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.dataset.noLoading === 'true') return;
        if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        if (loader) loader.classList.remove('is-hidden');
    });
})();
</script>

@endsection