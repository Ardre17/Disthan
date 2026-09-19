<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Salida de Productos | DISTAN ERP</title>

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
            --warn-bg: #fffbeb;

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

            padding: 8px 14px;

            border-radius: 5px;

            background:
                rgba(255,255,255,.07);

            border:
                1px solid rgba(255,255,255,.12);

            color: #cbd5e1;

            text-decoration: none;

            font-size: 12px;

            font-weight: 600;

            transition: .15s;
        }


        .btn-back:hover {

            background:
                rgba(255,255,255,.13);

            color: #fff;
        }


        /* =========================================================
           CONTENIDO
        ========================================================= */

        .page-content {

            width: 100%;

            max-width: 1500px;

            margin: 0 auto;

            padding: 20px;
        }


        /* =========================================================
           MENSAJES
        ========================================================= */

        .alert {

            padding: 13px 16px;

            border-radius: 7px;

            margin-bottom: 16px;

            font-size: 13px;

            font-weight: 600;
        }


        .alert-success {

            background: var(--ok-bg);

            color: #166534;

            border:
                1px solid #bbf7d0;
        }


        .alert-danger {

            background: var(--danger-bg);

            color: #991b1b;

            border:
                1px solid #fecaca;
        }


        /* =========================================================
           BUSCADOR
        ========================================================= */

        .search-panel {

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 8px;

            padding: 16px;

            margin-bottom: 18px;

            box-shadow:
                0 1px 2px rgba(15,34,64,.04);
        }


        .search-title {

            font-size: 12px;

            font-weight: 800;

            color: var(--navy);

            text-transform: uppercase;

            letter-spacing: .06em;

            margin-bottom: 9px;
        }


        .search-row {

            display: flex;

            gap: 10px;
        }


        .search-box {

            flex: 1;

            position: relative;
        }


        .search-icon {

            position: absolute;

            left: 13px;

            top: 50%;

            transform:
                translateY(-50%);

            font-size: 17px;

            color: #64748b;

            pointer-events: none;
        }


        .search-input {

            width: 100%;

            height: 46px;

            border:
                1px solid #cbd5e1;

            border-radius: 6px;

            padding:
                0 14px 0 42px;

            font-size: 14px;

            color: var(--ink);

            outline: none;

            transition: .15s;
        }


        .search-input:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 3px rgba(37,99,235,.10);
        }


        .search-clear {

            height: 46px;

            padding:
                0 16px;

            border:
                1px solid #cbd5e1;

            background: #f8fafc;

            color: var(--muted);

            border-radius: 6px;

            cursor: pointer;

            font-size: 13px;

            font-weight: 600;
        }


        .search-clear:hover {

            background: #eef2f7;
        }


        .search-help {

            margin-top: 8px;

            color: var(--muted);

            font-size: 11px;
        }


        /* =========================================================
           CONTADOR
        ========================================================= */

        .results-info {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 12px;

            gap: 10px;
        }


        .results-count {

            color: var(--muted);

            font-size: 12px;
        }


        .results-count strong {

            color: var(--navy);

            font-size: 13px;
        }


        /* =========================================================
           GRID
        ========================================================= */

        .products-grid {

            display: grid;

            grid-template-columns:
                repeat(auto-fill, minmax(330px, 1fr));

            gap: 14px;
        }


        /* =========================================================
           TARJETA
        ========================================================= */

        .product-card {

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 8px;

            overflow: hidden;

            box-shadow:
                0 1px 2px rgba(15,34,64,.04);

            transition:
                transform .15s,
                box-shadow .15s;
        }


        .product-card:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 4px 12px rgba(15,34,64,.08);
        }


        .product-top {

            padding: 15px;

            border-bottom:
                1px solid #edf0f4;
        }


        .product-main {

            display: flex;

            gap: 13px;

            align-items: flex-start;
        }


        .product-image {

            width: 72px;

            height: 72px;

            border-radius: 7px;

            border:
                1px solid #e2e8f0;

            background: #f8fafc;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

            flex-shrink: 0;

            font-size: 28px;
        }


        .product-image img {

            width: 100%;

            height: 100%;

            object-fit: cover;
        }


        .product-info {

            min-width: 0;

            flex: 1;
        }


        .product-name {

            font-size: 14px;

            font-weight: 800;

            color: var(--navy);

            line-height: 1.3;

            margin-bottom: 7px;
        }


        .product-category {

            display: inline-block;

            background: #eff6ff;

            color: #1d4ed8;

            border:
                1px solid #dbeafe;

            border-radius: 4px;

            padding: 3px 7px;

            font-size: 10px;

            font-weight: 700;

            margin-bottom: 7px;
        }


        .product-code {

            font-family: var(--mono);

            color: var(--muted);

            font-size: 10px;

            line-height: 1.65;

            word-break: break-word;
        }


        /* =========================================================
           DATOS
        ========================================================= */

        .product-data {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 7px;

            padding: 12px 15px;

            background: #fafbfd;

            border-bottom:
                1px solid #edf0f4;
        }


        .data-item {

            min-width: 0;
        }


        .data-label {

            color: #7b8796;

            font-size: 9px;

            text-transform: uppercase;

            letter-spacing: .05em;

            font-weight: 700;

            margin-bottom: 2px;
        }


        .data-value {

            color: var(--ink);

            font-size: 11px;

            font-weight: 600;

            word-break: break-word;
        }


        .stock-box {

            padding: 13px 15px;
        }


        .stock-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 7px;
        }


        .stock-label {

            color: var(--muted);

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;
        }


        .stock-number {

            font-family: var(--mono);

            font-size: 16px;

            font-weight: 800;

            color: var(--navy);
        }


        .stock-number.low {

            color: var(--danger);
        }


        .stock-bar {

            width: 100%;

            height: 6px;

            background: #e5e7eb;

            border-radius: 99px;

            overflow: hidden;
        }


        .stock-fill {

            height: 100%;

            border-radius: 99px;

            background: var(--ok);

            transition: width .2s;
        }


        .stock-fill.low {

            background: var(--danger);
        }


        .stock-min {

            margin-top: 5px;

            color: var(--muted);

            font-size: 10px;

            text-align: right;
        }


        /* =========================================================
           FORMULARIO
        ========================================================= */

        .product-form {

            padding: 15px;

            background: #fff;
        }


        .form-grid {

            display: grid;

            grid-template-columns:
                110px 1fr;

            gap: 9px;

            margin-bottom: 9px;
        }


        .form-group {

            display: flex;

            flex-direction: column;

            gap: 4px;
        }


        .form-group.full {

            grid-column:
                1 / -1;
        }


        .form-label {

            color: var(--muted);

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .04em;
        }


        .form-input {

            width: 100%;

            height: 40px;

            border:
                1px solid #cbd5e1;

            border-radius: 5px;

            padding:
                0 10px;

            font-size: 13px;

            outline: none;

            background: #fff;
        }


        .form-input:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 3px rgba(37,99,235,.08);
        }


        .form-input[type="number"] {

            font-family: var(--mono);

            font-weight: 700;

            text-align: center;
        }


        textarea.form-input {

            height: 58px;

            padding: 9px 10px;

            resize: vertical;

            font-family: var(--font);

        }


        .btn-register {

            width: 100%;

            height: 43px;

            border: none;

            border-radius: 5px;

            background: var(--navy);

            color: #fff;

            font-size: 12px;

            font-weight: 800;

            cursor: pointer;

            transition: .15s;
        }


        .btn-register:hover {

            background: #294f7d;
        }


        .btn-register:disabled {

            opacity: .55;

            cursor: not-allowed;
        }


        /* =========================================================
           SIN RESULTADOS
        ========================================================= */

        .no-results {

            background: var(--surface);

            border:
                1px solid var(--border);

            border-radius: 8px;

            padding: 45px 20px;

            text-align: center;

            color: var(--muted);

            grid-column: 1 / -1;
        }


        .no-results-icon {

            font-size: 35px;

            margin-bottom: 10px;
        }


        .no-results-title {

            color: var(--navy);

            font-weight: 800;

            font-size: 15px;

            margin-bottom: 5px;
        }


        .no-results-text {

            font-size: 12px;
        }


        /* =========================================================
           MODAL CONFIRMACIÓN
        ========================================================= */

        .modal {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(15,34,64,.62);

            z-index: 999;

            align-items: center;

            justify-content: center;

            padding: 20px;
        }


        .modal.show {

            display: flex;
        }


        .modal-card {

            width: 100%;

            max-width: 420px;

            background: #fff;

            border-radius: 9px;

            box-shadow:
                0 20px 50px rgba(0,0,0,.25);

            overflow: hidden;
        }


        .modal-header {

            background: var(--navy2);

            color: #fff;

            padding: 15px 18px;

            font-size: 14px;

            font-weight: 800;
        }


        .modal-body {

            padding: 18px;
        }


        .modal-text {

            color: var(--muted);

            font-size: 13px;

            line-height: 1.55;
        }


        .modal-text strong {

            color: var(--ink);
        }


        .modal-actions {

            display: flex;

            gap: 9px;

            margin-top: 18px;
        }


        .modal-btn {

            flex: 1;

            height: 42px;

            border-radius: 5px;

            cursor: pointer;

            font-size: 12px;

            font-weight: 800;
        }


        .modal-cancel {

            background: #f1f5f9;

            border:
                1px solid #cbd5e1;

            color: var(--muted);
        }


        .modal-confirm {

            background: var(--navy);

            border:
                1px solid var(--navy);

            color: #fff;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 700px) {

            .erp-bar {

                padding: 0 1rem;
            }

            .erp-clock {

                display: none;
            }

            .page-header {

                padding: 12px 1rem;
            }

            .page-content {

                padding: 12px;
            }

            .products-grid {

                grid-template-columns:
                    1fr;
            }

            .search-row {

                flex-direction: column;
            }

            .search-clear {

                width: 100%;
            }

            .form-grid {

                grid-template-columns:
                    1fr;
            }

            .form-group.full {

                grid-column:
                    auto;
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

            <span class="erp-sep"></span>

            <span class="erp-module">
                Salidas de producción
            </span>

        </div>

        <div class="erp-clock" id="clock"></div>

    </div>


    {{-- =========================================================
         HEADER
    ========================================================= --}}

    <header class="page-header">

        <div class="page-header-left">

            <div class="page-header-icon">
                📦
            </div>

            <div>

                <div class="page-header-title">
                    Salida de Productos
                </div>

                <div class="page-header-sub">
                    Registro de productos retirados para producción
                </div>

            </div>

        </div>


        <a
    href="{{ url('/produccion/salidas') }}"
    class="btn-back"
>
    ← Volver
</a>

    </header>


    <main class="page-content">


        {{-- =====================================================
             MENSAJES
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- =====================================================
             BUSCADOR
        ====================================================== --}}

        <section class="search-panel">

            <div class="search-title">
                Buscar producto
            </div>

            <form
                method="GET"
                action="{{ route('production.outputs.productos') }}"
                id="searchForm"
            >

                <div class="search-row">

                    <div class="search-box">

                        <span class="search-icon">
                            🔎
                        </span>

                        <input
                            type="text"
                            name="buscar"
                            id="searchInput"
                            class="search-input"
                            value="{{ $busqueda }}"
                            placeholder="Nombre, SKU, código de barras, código de caja o lote..."
                            autocomplete="off"
                        >

                    </div>

                    <button
                        type="button"
                        class="search-clear"
                        onclick="limpiarBusqueda()"
                    >
                        Limpiar
                    </button>

                </div>

            </form>

            <div class="search-help">
                Puedes buscar por nombre, SKU, código de barras, código de caja o lote.
            </div>

        </section>


        {{-- =====================================================
             RESULTADOS
        ====================================================== --}}

        <div class="results-info">

            <div class="results-count">

                Productos encontrados:
                <strong>{{ $productos->count() }}</strong>

            </div>

        </div>


        <section class="products-grid">


            @forelse($productos as $producto)

                @php

                    $stock = (float) ($producto->stock ?? 0);

                    $stockMinimo = (float) ($producto->stock_minimo ?? 0);

                    if ($stockMinimo > 0) {

                        $porcentaje = ($stock / $stockMinimo) * 100;

                        $porcentaje = min(100, max(0, $porcentaje));

                    } else {

                        $porcentaje = $stock > 0 ? 100 : 0;

                    }

                    $stockBajo =
                        $stock <= $stockMinimo;

                @endphp


                <article class="product-card">


                    {{-- =================================================
                         INFORMACIÓN PRINCIPAL
                    ================================================== --}}

                    <div class="product-top">

                        <div class="product-main">


                            <div class="product-image">

                                @if($producto->imagen)

                                    <img
                                        src="{{ asset('storage/' . $producto->imagen) }}"
                                        alt="{{ $producto->nombre }}"
                                    >

                                @else

                                    📦

                                @endif

                            </div>


                            <div class="product-info">

                                <div class="product-name">
                                    {{ $producto->nombre }}
                                </div>


                                @if($producto->category)

                                    <span class="product-category">
                                        {{ $producto->category->nombre }}
                                    </span>

                                @endif


                                <div class="product-code">

                                    @if($producto->sku)
                                        SKU: {{ $producto->sku }}<br>
                                    @endif

                                    @if($producto->barcode)
                                        BARCODE: {{ $producto->barcode }}<br>
                                    @endif

                                    @if($producto->box_barcode)
                                        CAJA: {{ $producto->box_barcode }}<br>
                                    @endif

                                    @if($producto->lote)
                                        LOTE: {{ $producto->lote }}
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DATOS
                    ================================================== --}}

                    <div class="product-data">

                        <div class="data-item">

                            <div class="data-label">
                                Marca
                            </div>

                            <div class="data-value">
                                {{ $producto->marca ?: '—' }}
                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-label">
                                Cantidad por caja
                            </div>

                            <div class="data-value">
                                {{ number_format($producto->cantidad_por_caja ?? 1, 0) }}
                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-label">
                                Producción
                            </div>

                            <div class="data-value">
                                {{ $producto->fecha_produccion
                                    ? \Carbon\Carbon::parse($producto->fecha_produccion)->format('d/m/Y')
                                    : '—'
                                }}
                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-label">
                                Vencimiento
                            </div>

                            <div class="data-value">
                                {{ $producto->fecha_vencimiento
                                    ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y')
                                    : '—'
                                }}
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         STOCK
                    ================================================== --}}

                    <div class="stock-box">

                        <div class="stock-header">

                            <span class="stock-label">
                                Stock disponible
                            </span>

                            <span
                                class="stock-number {{ $stockBajo ? 'low' : '' }}"
                            >
                                {{ number_format($stock, 0) }}
                            </span>

                        </div>


                        <div class="stock-bar">

                            <div
                                class="stock-fill {{ $stockBajo ? 'low' : '' }}"
                                style="width: {{ $porcentaje }}%;"
                            ></div>

                        </div>


                        <div class="stock-min">

                            Mínimo:
                            {{ number_format($stockMinimo, 0) }}

                        </div>

                    </div>


                    {{-- =================================================
                         FORMULARIO
                    ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('production.outputs.productos.salida', $producto) }}"
                        class="product-form"
                        onsubmit="return confirmarSalida(this)"
                    >

                        @csrf


                        <div class="form-grid">


                            <div class="form-group">

                                <label class="form-label">
                                    Cantidad
                                </label>

                                <input
                                    type="number"
                                    name="cantidad"
                                    class="form-input cantidad-input"
                                    min="1"
                                    max="{{ max(1, (int) $stock) }}"
                                    step="1"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    required
                                    {{ $stock <= 0 ? 'disabled' : '' }}
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Responsable
                                </label>

                                <input
                                    type="text"
                                    name="responsable"
                                    class="form-input"
                                    maxlength="100"
                                    placeholder="Nombre del responsable"
                                    required
                                    {{ $stock <= 0 ? 'disabled' : '' }}
                                >

                            </div>


                            <div class="form-group full">

                                <label class="form-label">
                                    Observación
                                </label>

                                <textarea
                                    name="observacion"
                                    class="form-input"
                                    maxlength="255"
                                    placeholder="Opcional"
                                    {{ $stock <= 0 ? 'disabled' : '' }}
                                ></textarea>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="btn-register"
                            {{ $stock <= 0 ? 'disabled' : '' }}
                        >

                            {{ $stock <= 0
                                ? 'Sin stock disponible'
                                : 'Registrar salida'
                            }}

                        </button>

                    </form>


                </article>

            @empty


                <div class="no-results">

                    <div class="no-results-icon">
                        🔎
                    </div>

                    <div class="no-results-title">
                        No se encontraron productos
                    </div>

                    <div class="no-results-text">
                        Prueba con otro nombre, SKU, código de barras,
                        código de caja o lote.
                    </div>

                </div>


            @endforelse


        </section>


    </main>


    {{-- =========================================================
         MODAL
    ========================================================= --}}

    <div
        class="modal"
        id="confirmModal"
    >

        <div class="modal-card">

            <div class="modal-header">
                Confirmar salida
            </div>

            <div class="modal-body">

                <div
                    class="modal-text"
                    id="confirmText"
                ></div>


                <div class="modal-actions">

                    <button
                        type="button"
                        class="modal-btn modal-cancel"
                        onclick="cerrarModal()"
                    >
                        Cancelar
                    </button>


                    <button
                        type="button"
                        class="modal-btn modal-confirm"
                        onclick="confirmarFormulario()"
                    >
                        Confirmar salida
                    </button>

                </div>

            </div>

        </div>

    </div>


    <script>

        /* =========================================================
           RELOJ
        ========================================================= */

        function actualizarReloj() {

            const ahora = new Date();

            const hora =
                ahora.toLocaleTimeString('es-PE', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });

            const elemento =
                document.getElementById('clock');

            if (elemento) {
                elemento.textContent = hora;
            }
        }

        actualizarReloj();

        setInterval(actualizarReloj, 1000);


        /* =========================================================
           BÚSQUEDA
        ========================================================= */

        const searchInput =
            document.getElementById('searchInput');

        let searchTimer = null;


        if (searchInput) {

            searchInput.addEventListener('input', function () {

                clearTimeout(searchTimer);

                searchTimer = setTimeout(() => {

                    document
                        .getElementById('searchForm')
                        .submit();

                }, 450);

            });

        }


        function limpiarBusqueda() {

            window.location.href =
                "{{ route('production.outputs.productos') }}";

        }


        /* =========================================================
           CONFIRMACIÓN
        ========================================================= */

        let formularioPendiente = null;


        function confirmarSalida(formulario) {

            const cantidad =
                formulario.querySelector(
                    '[name="cantidad"]'
                ).value;

            const responsable =
                formulario.querySelector(
                    '[name="responsable"]'
                ).value;

            const tarjeta =
                formulario.closest('.product-card');

            const producto =
                tarjeta.querySelector(
                    '.product-name'
                ).textContent.trim();


            if (!cantidad || cantidad < 1) {

                return false;

            }


            formularioPendiente = formulario;


            document.getElementById(
                'confirmText'
            ).innerHTML =
                'Se registrará una salida de <strong>' +
                cantidad +
                '</strong> unidad(es) del producto ' +
                '<strong>' +
                producto +
                '</strong>.<br><br>' +
                'Responsable: <strong>' +
                responsable +
                '</strong>';


            document.getElementById(
                'confirmModal'
            ).classList.add('show');


            return false;
        }


        function cerrarModal() {

            formularioPendiente = null;

            document.getElementById(
                'confirmModal'
            ).classList.remove('show');

        }


        function confirmarFormulario() {

            if (!formularioPendiente) {

                return;

            }


            const formulario =
                formularioPendiente;


            formularioPendiente = null;


            document.getElementById(
                'confirmModal'
            ).classList.remove('show');


            formulario.submit();

        }


        /* =========================================================
           CERRAR MODAL AL HACER CLICK FUERA
        ========================================================= */

        document
            .getElementById('confirmModal')
            .addEventListener('click', function (event) {

                if (event.target === this) {

                    cerrarModal();

                }

            });


        /* =========================================================
           ESC
        ========================================================= */

        document.addEventListener('keydown', function (event) {

            if (
                event.key === 'Escape' &&
                document
                    .getElementById('confirmModal')
                    .classList
                    .contains('show')
            ) {

                cerrarModal();

            }

        });

    </script>


</body>

</html>