<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Salida de Stickers | DISTAN ERP</title>


    <style>

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        :root {

            --navy: #1e3a5f;
            --navy2: #0f2240;

            --surface: #ffffff;
            --bg: #eef1f5;
            --border: #dde2ea;

            --ink: #1c2733;
            --muted: #5b6b7d;

            --accent: #2563eb;

            --ok: #16a34a;
            --ok-bg: #f0fdf4;

            --warn: #d97706;

            --danger: #dc2626;
            --danger-bg: #fef2f2;

            --font:
                'Segoe UI',
                -apple-system,
                BlinkMacSystemFont,
                Arial,
                sans-serif;

            --mono:
                'Consolas',
                'SFMono-Regular',
                monospace;
        }


        body {

            font-family: var(--font);

            background: var(--bg);

            color: var(--ink);

            min-height: 100vh;

            display: flex;

            flex-direction: column;
        }


        /* =========================================================
           TOP BAR
        ========================================================= */

        .erp-bar {

            background: var(--navy);

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 1.5rem;

            border-bottom:
                1px solid rgba(255,255,255,.07);

            flex-shrink: 0;
        }


        .erp-bar-left {

            display: flex;

            align-items: center;

            gap: 10px;
        }


        .erp-logo {

            color: #fff;

            font-size: 12px;

            font-weight: 800;

            letter-spacing: .4px;
        }


        .erp-sep {

            width: 1px;

            height: 16px;

            background:
                rgba(255,255,255,.15);
        }


        .erp-module {

            color: #7eb8f7;

            font-size: 11px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: .07em;
        }


        .erp-clock {

            color: #5a8abf;

            font-size: 11px;

            font-family: var(--mono);
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .page-header {

            background: var(--navy2);

            padding: 1rem 1.5rem;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 14px;

            flex-wrap: wrap;

            border-bottom:
                3px solid var(--accent);

            flex-shrink: 0;
        }


        .page-header-left {

            display: flex;

            align-items: center;

            gap: 12px;
        }


        .page-header-icon {

            width: 42px;

            height: 42px;

            background:
                rgba(37,99,235,.18);

            border:
                1px solid rgba(37,99,235,.35);

            border-radius: 7px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            flex-shrink: 0;
        }


        .page-header-title {

            color: #fff;

            font-size: 16px;

            font-weight: 800;
        }


        .page-header-sub {

            color: #7eb8f7;

            font-size: 11px;

            margin-top: 2px;
        }


        .btn-back {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 14px;

            border-radius: 4px;

            background:
                rgba(255,255,255,.07);

            border:
                1px solid rgba(255,255,255,.12);

            color: #cbd5e1;

            text-decoration: none;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;
        }


        .btn-back:hover {

            background:
                rgba(255,255,255,.14);

            color: #fff;
        }


        /* =========================================================
           ALERTAS
        ========================================================= */

        .alert-ok {

            background: var(--ok-bg);

            border:
                1px solid #bbf7d0;

            border-left:
                4px solid var(--ok);

            border-radius: 4px;

            padding: 10px 14px;

            font-size: 12px;

            font-weight: 600;

            color: #166534;

            margin-bottom: 1rem;
        }


        .alert-err {

            background: var(--danger-bg);

            border:
                1px solid #fca5a5;

            border-left:
                4px solid var(--danger);

            border-radius: 4px;

            padding: 10px 14px;

            font-size: 12px;

            color: #991b1b;

            margin-bottom: 1rem;
        }


        .alert-err ul {

            margin: .4rem 0 0 1.1rem;
        }


        .alert-err li {

            font-size: 11px;

            margin-bottom: 2px;
        }


        /* =========================================================
           CONTENEDOR
        ========================================================= */

        .container {

            width:
                min(1140px, calc(100% - 40px));

            margin:
                1.5rem auto;

            flex: 1;
        }


        /* =========================================================
           SECTION HEADER
        ========================================================= */

        .sec-head {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 1.1rem;
        }


        .sec-head-bar {

            width: 4px;

            height: 20px;

            background: var(--accent);

            border-radius: 2px;
        }


        .sec-head-title {

            font-size: 14px;

            font-weight: 700;
        }


        .sec-head-sub {

            font-size: 11px;

            color: var(--muted);

            margin-top: 1px;
        }


        .sec-head-count {

            margin-left: auto;

            font-size: 11px;

            color: var(--muted);

            font-family: var(--mono);

            background: var(--surface);

            border:
                1px solid var(--border);

            padding: 2px 10px;

            border-radius: 99px;
        }


        /* =========================================================
           BUSCADOR
        ========================================================= */

        .search-box {

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 6px;

            padding: 12px 14px;

            margin-bottom: 14px;

            display: flex;

            align-items: center;

            gap: 10px;
        }


        .search-icon {

            width: 34px;

            height: 34px;

            border-radius: 5px;

            background: #eef2ff;

            border:
                1px solid #c7d2fe;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 17px;

            flex-shrink: 0;
        }


        .search-content {

            flex: 1;

            min-width: 0;
        }


        .search-label {

            display: block;

            font-size: 9px;

            font-weight: 700;

            color: var(--muted);

            text-transform: uppercase;

            letter-spacing: .06em;

            margin-bottom: 4px;
        }


        .search-input-wrap {

            position: relative;
        }


        .search-input {

            width: 100%;

            padding:
                9px 38px 9px 11px;

            border:
                1px solid var(--border);

            border-radius: 4px;

            background: #fbfcfe;

            color: var(--ink);

            font-size: 13px;

            outline: none;
        }


        .search-input:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 2px
                rgba(37,99,235,.12);

            background: #fff;
        }


        .search-clear {

            position: absolute;

            right: 8px;

            top: 50%;

            transform: translateY(-50%);

            width: 25px;

            height: 25px;

            border: none;

            border-radius: 4px;

            background: transparent;

            color: #94a3b8;

            cursor: pointer;

            font-size: 15px;

            display: none;

            align-items: center;

            justify-content: center;
        }


        .search-clear:hover {

            background: #f1f5f9;

            color: var(--ink);
        }


        .search-result-info {

            margin-top: 5px;

            font-size: 10px;

            color: var(--muted);
        }


        /* =========================================================
           GRID
        ========================================================= */

        .stickers {

            display: grid;

            grid-template-columns:
                repeat(auto-fill, minmax(320px, 1fr));

            gap: 14px;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .sticker-card {

            background: var(--surface);

            border:
                1px solid var(--border);

            border-top:
                3px solid var(--accent);

            border-radius: 6px;

            overflow: hidden;

            display: flex;

            flex-direction: column;

            transition:
                box-shadow .15s,
                border-color .15s;
        }


        .sticker-card:hover {

            border-color: #c2cbd8;

            box-shadow:
                0 4px 16px
                rgba(15,23,42,.1);
        }


        .sticker-card.agotado {

            border-top-color: var(--danger);
        }


        /* =========================================================
           HEADER CARD
        ========================================================= */

        .sticker-card-header {

            padding:
                .85rem 1rem;

            border-bottom:
                1px solid var(--border);

            display: flex;

            align-items: center;

            gap: 12px;

            background: #f9fafb;
        }


        .sticker-card-icon {

            width: 48px;

            height: 48px;

            background: #eef2ff;

            border:
                1px solid #c7d2fe;

            border-radius: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 26px;

            flex-shrink: 0;
        }


        .sticker-card-info {

            flex: 1;

            min-width: 0;
        }


        .sticker-card-name {

            font-size: 14px;

            font-weight: 800;

            color: var(--ink);

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .sticker-card-details {

            margin-top: 5px;

            display: flex;

            align-items: center;

            flex-wrap: wrap;

            gap: 4px;
        }


        .sticker-badge {

            display: inline-flex;

            align-items: center;

            gap: 4px;

            font-size: 9px;

            font-weight: 700;

            padding:
                2px 7px;

            border-radius: 3px;

            background: #f1f5f9;

            color: var(--muted);

            border:
                1px solid var(--border);
        }


        .sticker-badge.blue {

            background: #dbeafe;

            color: #1d4ed8;

            border-color: #bfdbfe;
        }


        /* =========================================================
           STOCK
        ========================================================= */

        .stock-block {

            padding:
                .75rem 1rem;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 8px;

            border-bottom:
                1px solid var(--border);
        }


        .stock-block-label {

            font-size: 10px;

            color: var(--muted);

            text-transform: uppercase;

            letter-spacing: .06em;

            font-weight: 600;
        }


        .stock-block-num {

            font-family: var(--mono);

            font-size: 26px;

            font-weight: 800;

            line-height: 1;
        }


        .stock-block-unit {

            font-size: 10px;

            color: var(--muted);

            margin-top: 1px;
        }


        .stock-ok {

            color: var(--ok);
        }


        .stock-warn {

            color: var(--warn);
        }


        .stock-zero {

            color: var(--danger);
        }


        /* =========================================================
           BARRA
        ========================================================= */

        .stock-bar-wrap {

            padding:
                0 1rem .65rem;
        }


        .stock-bar-track {

            width: 100%;

            height: 5px;

            background: #f1f5f9;

            border-radius: 99px;

            overflow: hidden;
        }


        .stock-bar-fill {

            height: 100%;

            border-radius: 99px;
        }


        /* =========================================================
           FORMULARIO
        ========================================================= */

        .sticker-form {

            padding:
                .85rem 1rem;

            display: flex;

            flex-direction: column;

            gap: .65rem;

            flex: 1;
        }


        .field {

            display: flex;

            flex-direction: column;

            gap: 4px;
        }


        .field-label {

            font-size: 10px;

            font-weight: 700;

            color: var(--muted);

            text-transform: uppercase;

            letter-spacing: .06em;
        }


        .required {

            color: var(--danger);
        }


        .optional {

            color: #94a3b8;

            font-weight: 400;

            font-size: 9px;

            text-transform: none;

            letter-spacing: 0;
        }


        .form-control {

            width: 100%;

            padding:
                9px 11px;

            border:
                1px solid var(--border);

            border-radius: 4px;

            background: #fbfcfe;

            color: var(--ink);

            font-size: 13px;

            outline: none;
        }


        .form-control:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 2px
                rgba(37,99,235,.12);

            background: #fff;
        }


        .cantidad-input {

            font-family: var(--mono);

            font-size: 20px;

            font-weight: 800;

            text-align: center;

            padding: 12px;
        }


        .cantidad-preview {

            display: none;

            font-size: 11px;

            color: var(--muted);

            background: #f8fafc;

            border:
                1px solid var(--border);

            border-radius: 3px;

            padding:
                5px 9px;

            text-align: center;
        }


        .cantidad-preview.visible {

            display: block;
        }


        /* =========================================================
           BOTÓN
        ========================================================= */

        .btn-submit {

            width: 100%;

            padding: 11px;

            background: var(--accent);

            color: #fff;

            border: none;

            border-radius: 4px;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            margin-top: auto;
        }


        .btn-submit:hover {

            background: #1d4ed8;

            box-shadow:
                0 4px 14px
                rgba(37,99,235,.3);
        }


        /* =========================================================
           SIN STOCK
        ========================================================= */

        .no-stock {

            margin:
                .75rem 1rem 1rem;

            padding:
                10px 12px;

            background:
                var(--danger-bg);

            border:
                1px solid #fca5a5;

            border-radius: 4px;

            text-align: center;

            font-size: 12px;

            font-weight: 700;

            color: #991b1b;
        }


        /* =========================================================
           SIN RESULTADOS
        ========================================================= */

        .no-results {

            display: none;

            background: var(--surface);

            border:
                1px dashed var(--border);

            border-radius: 6px;

            padding: 3rem;

            text-align: center;

            color: var(--muted);

            grid-column: 1 / -1;
        }


        .no-results-icon {

            font-size: 44px;

            margin-bottom: 8px;
        }


        .no-results h3 {

            font-size: 15px;

            color: var(--ink);

            margin:
                .5rem 0 .35rem;
        }


        .no-results p {

            font-size: 12px;
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .empty-state {

            background: var(--surface);

            border:
                1px dashed var(--border);

            border-radius: 6px;

            padding: 3rem;

            text-align: center;

            color: var(--muted);
        }


        .empty-state h3 {

            font-size: 15px;

            color: var(--ink);

            margin:
                .5rem 0 .35rem;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .page-footer {

            background: var(--navy2);

            border-top:
                1px solid rgba(255,255,255,.06);

            padding:
                .65rem 1.5rem;

            display: flex;

            align-items: center;

            justify-content: space-between;

            flex-wrap: wrap;

            gap: 6px;

            flex-shrink: 0;
        }


        .page-footer-l {

            font-size: 11px;

            color: #334155;

            font-family: var(--mono);
        }


        .page-footer-r {

            font-size: 11px;

            color: #334155;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 750px) {

            .stickers {

                grid-template-columns: 1fr;
            }


            .container {

                width:
                    calc(100% - 24px);
            }
        }


        @media (max-width: 500px) {

            .page-header {

                flex-direction: column;

                align-items: flex-start;
            }


            .btn-back {

                width: 100%;

                justify-content: center;
            }


            .search-icon {

                display: none;
            }
        }

    </style>

</head>


<body>


{{-- =========================================================
     TOP BAR
========================================================= --}}

<div class="erp-bar">

    <div class="erp-bar-left">

        <span class="erp-logo">
            DISTAN ERP
        </span>

        <div class="erp-sep"></div>

        <span class="erp-module">
            Producción › Salida de stickers
        </span>

    </div>


    <span
        class="erp-clock"
        id="erpClock"
    >
        --:--:--
    </span>

</div>


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="page-header">

    <div class="page-header-left">

        <div class="page-header-icon">
            🏷️
        </div>

        <div>

            <div class="page-header-title">
                Salida de stickers de tapa
            </div>

            <div class="page-header-sub">
                Registra la cantidad de stickers retirados para producción
            </div>

        </div>

    </div>


    <a
        href="{{ route('production.outputs') }}"
        class="btn-back"
    >
        ← Volver a salidas
    </a>

</div>


{{-- =========================================================
     CONTENIDO
========================================================= --}}

<main class="container">


    @if(session('success'))

        <div class="alert-ok">

            ✅ {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert-err">

            <strong>
                ⚠️ No se pudo registrar la salida:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    @if($stickers->count())


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="sec-head">

            <div class="sec-head-bar"></div>

            <div>

                <div class="sec-head-title">
                    Stickers disponibles
                </div>

                <div class="sec-head-sub">
                    Busca el sticker y registra la cantidad a retirar
                </div>

            </div>


            <span
                class="sec-head-count"
                id="contadorStickers"
            >
                {{ $stickers->count() }}
                tipo{{ $stickers->count() !== 1 ? 's' : '' }}
            </span>

        </div>


        {{-- =================================================
             BUSCADOR
        ================================================== --}}

        <div class="search-box">

            <div class="search-icon">
                🔎
            </div>


            <div class="search-content">

                <label
                    class="search-label"
                    for="buscarSticker"
                >
                    Buscar sticker
                </label>


                <div class="search-input-wrap">

                    <input
                        type="search"
                        id="buscarSticker"
                        class="search-input"
                        placeholder="Escribe el nombre o idioma..."
                        autocomplete="off"
                        spellcheck="false"
                    >


                    <button
                        type="button"
                        id="limpiarBusqueda"
                        class="search-clear"
                        aria-label="Limpiar búsqueda"
                    >
                        ✕
                    </button>

                </div>


                <div
                    class="search-result-info"
                    id="resultadoBusqueda"
                >
                    Mostrando todos los stickers
                </div>

            </div>

        </div>


        {{-- =================================================
             GRID
        ================================================== --}}

        <div
            class="stickers"
            id="stickersGrid"
        >


            @foreach($stickers as $sticker)

                @php

                    $stock =
                        $sticker->stock_actual;

                    $stockMin =
                        $sticker->stock_minimo ?? 0;

                    $agotado =
                        $stock <= 0;


                    $stockColorClass =
                        $agotado

                        ? 'stock-zero'

                        : (
                            $stock <= $stockMin
                            ? 'stock-warn'
                            : 'stock-ok'
                        );


                    $barColor =
                        $agotado

                        ? '#ef4444'

                        : (
                            $stock <= $stockMin
                            ? '#f59e0b'
                            : '#22c55e'
                        );


                    $pctStock =
                        $stockMin > 0

                        ? min(
                            100,
                            round(
                                $stock /
                                max(
                                    $stock,
                                    $stockMin * 3
                                ) * 100
                            )
                        )

                        : ($stock > 0 ? 100 : 0);


                    $textoBusqueda =
                        implode(
                            ' ',
                            array_filter([

                                $sticker->nombre,

                                $sticker->idioma,

                            ])
                        );

                @endphp


                <div
                    class="sticker-card {{ $agotado ? 'agotado' : '' }}"
                    data-search="{{ $textoBusqueda }}"
                >


                    {{-- HEADER CARD --}}

                    <div class="sticker-card-header">


                        <div class="sticker-card-icon">
                            🏷️
                        </div>


                        <div class="sticker-card-info">


                            <div
                                class="sticker-card-name"
                                title="{{ $sticker->nombre }}"
                            >
                                {{ $sticker->nombre }}
                            </div>


                            <div class="sticker-card-details">


                                @if($sticker->idioma)

                                    <span class="sticker-badge blue">

                                        {{ $sticker->idioma }}

                                    </span>

                                @endif


                            </div>


                        </div>


                    </div>


                    {{-- STOCK --}}

                    <div class="stock-block">


                        <div>

                            <div class="stock-block-label">
                                Stock disponible
                            </div>


                            <div
                                class="stock-block-num {{ $stockColorClass }}"
                            >
                                {{ number_format($stock, 0) }}
                            </div>


                            <div class="stock-block-unit">
                                unidades
                            </div>

                        </div>


                        @if(!$agotado && $stockMin > 0)

                            <div style="text-align:right;">

                                <div class="stock-block-label">
                                    Mínimo
                                </div>


                                <div
                                    style="
                                        font-family:var(--mono);
                                        font-size:14px;
                                        font-weight:700;
                                        color:var(--muted);
                                    "
                                >
                                    {{ number_format($stockMin, 0) }}
                                </div>

                            </div>

                        @endif


                    </div>


                    {{-- BARRA --}}

                    <div class="stock-bar-wrap">

                        <div class="stock-bar-track">

                            <div
                                class="stock-bar-fill"
                                style="
                                    width:{{ $pctStock }}%;
                                    background:{{ $barColor }};
                                "
                            ></div>

                        </div>

                    </div>


                    @if(!$agotado)


                        {{-- FORMULARIO --}}

                        <form
                            action="{{ route(
                                'production.outputs.stickers.salida',
                                $sticker
                            ) }}"
                            method="POST"
                            class="sticker-form"
                            onsubmit="
                                return confirmarSalida(
                                    this,
                                    '{{ addslashes($sticker->nombre) }}'
                                )
                            "
                        >

                            @csrf


                            {{-- CANTIDAD --}}

                            <div class="field">

                                <label
                                    class="field-label"
                                    for="cantidad-{{ $sticker->id }}"
                                >

                                    Cantidad a retirar

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <input
                                    id="cantidad-{{ $sticker->id }}"
                                    type="number"
                                    name="cantidad"
                                    class="form-control cantidad-input"
                                    min="1"
                                    max="{{ floor($stock) }}"
                                    step="1"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    placeholder="0"
                                    required
                                    oninput="
                                        mostrarPreview(
                                            this,
                                            {{ $stock }},
                                            'preview-{{ $sticker->id }}'
                                        )
                                    "
                                >


                                <div
                                    class="cantidad-preview"
                                    id="preview-{{ $sticker->id }}"
                                ></div>

                            </div>


                            {{-- RESPONSABLE --}}

                            <div class="field">

                                <label
                                    class="field-label"
                                    for="responsable-{{ $sticker->id }}"
                                >

                                    Responsable

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <input
                                    id="responsable-{{ $sticker->id }}"
                                    type="text"
                                    name="responsable"
                                    class="form-control"
                                    maxlength="100"
                                    placeholder="Nombre de quien retira"
                                    required
                                >

                            </div>


                            {{-- OBSERVACIÓN --}}

                            <div class="field">

                                <label
                                    class="field-label"
                                    for="observacion-{{ $sticker->id }}"
                                >

                                    Observación

                                    <span class="optional">
                                        (opcional)
                                    </span>

                                </label>


                                <input
                                    id="observacion-{{ $sticker->id }}"
                                    type="text"
                                    name="observacion"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Ej: Producción pedido"
                                >

                            </div>


                            {{-- BOTÓN --}}

                            <button
                                type="submit"
                                class="btn-submit"
                            >

                                📤 Registrar salida

                            </button>


                        </form>


                    @else


                        <div class="no-stock">

                            🔴 Sin stock disponible —
                            solicita reposición

                        </div>


                    @endif


                </div>


            @endforeach


            {{-- SIN RESULTADOS --}}

            <div
                class="no-results"
                id="sinResultados"
            >

                <div class="no-results-icon">
                    🔎
                </div>


                <h3>
                    No encontramos stickers
                </h3>


                <p>
                    Prueba escribiendo otro nombre o idioma.
                </p>

            </div>


        </div>


    @else


        <div class="empty-state">

            <div
                style="
                    font-size:44px;
                    margin-bottom:8px;
                "
            >
                🏷️
            </div>


            <h3>
                No hay stickers disponibles
            </h3>


            <p style="font-size:12px;">
                No existen stickers activos
                registrados en el inventario.
            </p>

        </div>


    @endif


</main>


{{-- FOOTER --}}

<div class="page-footer">

    <span class="page-footer-l">
        DISTAN ERP · Producción › Salida de stickers
    </span>


    <span class="page-footer-r">
        v2025.1
    </span>

</div>


<script>


/* =========================================================
   RELOJ
========================================================= */

function actualizarReloj() {

    var el =
        document.getElementById('erpClock');

    if (el) {

        el.textContent =
            new Date().toLocaleTimeString('es-PE');

    }

}


actualizarReloj();

setInterval(
    actualizarReloj,
    1000
);


/* =========================================================
   NORMALIZAR TEXTO
========================================================= */

function normalizarTexto(texto) {

    return String(texto || '')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim();

}


/* =========================================================
   BUSCADOR
========================================================= */

var buscador =
    document.getElementById('buscarSticker');

var limpiar =
    document.getElementById('limpiarBusqueda');

var resultado =
    document.getElementById('resultadoBusqueda');

var contador =
    document.getElementById('contadorStickers');

var sinResultados =
    document.getElementById('sinResultados');

var tarjetas =
    document.querySelectorAll('.sticker-card');


function filtrarStickers() {

    if (!buscador) return;


    var texto =
        normalizarTexto(
            buscador.value
        );


    var visibles = 0;


    tarjetas.forEach(function(card) {

        var contenido =
            normalizarTexto(
                card.getAttribute(
                    'data-search'
                )
            );


        var coincide =
            texto === ''
            ||
            contenido.includes(texto);


        if (coincide) {

            card.style.display = '';

            visibles++;

        } else {

            card.style.display = 'none';

        }

    });


    if (limpiar) {

        limpiar.style.display =
            texto.length > 0
                ? 'flex'
                : 'none';

    }


    if (contador) {

        contador.textContent =
            visibles +
            ' tipo' +
            (visibles !== 1 ? 's' : '');

    }


    if (resultado) {

        if (texto === '') {

            resultado.textContent =
                'Mostrando todos los stickers';

        } else {

            resultado.textContent =
                visibles === 0

                    ? 'No se encontraron coincidencias'

                    : 'Mostrando ' +
                      visibles +
                      ' resultado' +
                      (visibles !== 1 ? 's' : '');

        }

    }


    if (sinResultados) {

        sinResultados.style.display =
            visibles === 0
                ? 'block'
                : 'none';

    }

}


if (buscador) {

    buscador.addEventListener(
        'input',
        filtrarStickers
    );

}


/* =========================================================
   LIMPIAR
========================================================= */

if (limpiar) {

    limpiar.addEventListener(
        'click',
        function() {

            buscador.value = '';

            filtrarStickers();

            buscador.focus();

        }
    );

}


/* =========================================================
   PREVIEW CANTIDAD
========================================================= */

function mostrarPreview(
    input,
    stockActual,
    previewId
) {

    var preview =
        document.getElementById(
            previewId
        );


    var val =
        parseInt(input.value);


    if (!preview) return;


    if (
        isNaN(val)
        ||
        val <= 0
    ) {

        preview.className =
            'cantidad-preview';

        preview.innerHTML = '';

        input.style.borderColor = '';

        return;
    }


    var restante =
        stockActual - val;


    if (val > stockActual) {

        preview.className =
            'cantidad-preview visible';

        preview.innerHTML =
            '⚠️ Supera el stock disponible (' +
            stockActual +
            ')';

        preview.style.color =
            '#991b1b';

        preview.style.background =
            '#fef2f2';

        preview.style.borderColor =
            '#fca5a5';

        input.style.borderColor =
            '#dc2626';

        return;
    }


    input.style.borderColor =
        '#2563eb';


    preview.className =
        'cantidad-preview visible';


    preview.style.color =
        restante <= 0
            ? '#991b1b'
            : '#1c2733';


    preview.style.background =
        restante <= 0
            ? '#fef2f2'
            : '#f8fafc';


    preview.style.borderColor =
        restante <= 0
            ? '#fca5a5'
            : '#dde2ea';


    preview.innerHTML =

        'Retiras <strong>' +
        val +
        '</strong> · ' +

        'Queda en stock: ' +

        '<strong style="color:' +

        (
            restante <= 0
                ? '#dc2626'
                : (
                    restante < 10
                        ? '#d97706'
                        : '#16a34a'
                )
        ) +

        ';">' +

        restante +

        '</strong>';

}


/* =========================================================
   CONFIRMAR
========================================================= */

function confirmarSalida(
    form,
    nombre
) {

    var cantidadInput =
        form.querySelector(
            '[name="cantidad"]'
        );


    var cantidad =
        parseInt(
            cantidadInput
                ? cantidadInput.value
                : 0
        );


    if (
        isNaN(cantidad)
        ||
        cantidad <= 0
    ) {

        return false;

    }


    return confirm(

        '¿Confirmas registrar la salida?\n\n' +

        '🏷️ Sticker: ' +
        nombre +
        '\n' +

        '🔢 Cantidad: ' +
        cantidad +
        ' unidades\n\n' +

        'Esta acción descontará del inventario.'

    );

}


</script>


</body>

</html>