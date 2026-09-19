<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Salida de Etiquetas | DISTAN</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            min-height: 100vh;
        }

        .header {
            background: #0f172a;
            color: white;

            padding: 20px 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .brand h1 {
            font-size: 25px;
            font-weight: 800;
        }

        .brand p {
            margin-top: 5px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 13px 18px;

            background: #334155;
            color: white;

            border: 1px solid #475569;
            border-radius: 10px;

            text-decoration: none;

            font-size: 15px;
            font-weight: 700;
        }

        .btn-back:hover {
            background: #475569;
        }

        .container {
            width: min(1100px, calc(100% - 30px));
            margin: 30px auto 50px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .page-title h2 {
            font-size: 30px;
            font-weight: 800;
        }

        .page-title p {
            margin-top: 8px;
            color: #64748b;
            font-size: 16px;
        }

        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;

            padding: 15px 18px;

            border-radius: 12px;

            margin-bottom: 22px;

            font-weight: 700;
            text-align: center;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;

            padding: 15px 18px;

            border-radius: 12px;

            margin-bottom: 22px;

            font-weight: 700;
        }

        .error-list {
            margin-top: 7px;
            padding-left: 20px;
        }

        .labels {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .label-card {
            background: white;

            border: 2px solid #e2e8f0;
            border-radius: 18px;

            padding: 28px;

            box-shadow:
                0 6px 20px rgba(15, 23, 42, 0.07);
        }

        .label-card:hover {
            border-color: #94a3b8;
        }

        .label-icon {
            width: 90px;
            height: 90px;

            margin: 0 auto 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f8fafc;
            border-radius: 18px;

            font-size: 58px;
        }

        .label-name {
            text-align: center;

            font-size: 22px;
            font-weight: 800;
        }

        .label-info {
            margin-top: 10px;

            display: flex;
            flex-wrap: wrap;

            justify-content: center;

            gap: 7px;
        }

        .badge {
            padding: 6px 10px;

            border-radius: 999px;

            background: #f1f5f9;
            color: #475569;

            font-size: 12px;
            font-weight: 700;
        }

        .stock-box {
            margin: 20px 0;

            padding: 15px;

            border-radius: 12px;
            background: #f8fafc;

            text-align: center;
        }

        .stock-label {
            font-size: 13px;
            color: #64748b;
        }

        .stock-number {
            margin-top: 4px;

            font-size: 28px;
            font-weight: 900;
        }

        .form-group {
            margin-top: 15px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 14px;
            font-weight: 800;
        }

        .form-control {
            width: 100%;

            min-height: 52px;

            padding: 12px 14px;

            border: 1px solid #cbd5e1;
            border-radius: 10px;

            background: white;

            font-size: 17px;

            outline: none;
        }

        .form-control:focus {
            border-color: #3b82f6;

            box-shadow:
                0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .btn-submit {
            width: 100%;

            min-height: 56px;

            margin-top: 20px;

            border: none;
            border-radius: 11px;

            background: #2563eb;
            color: white;

            font-size: 17px;
            font-weight: 800;

            cursor: pointer;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .empty {
            background: white;

            border-radius: 16px;

            padding: 40px 25px;

            text-align: center;

            color: #64748b;
        }

        .footer {
            text-align: center;

            margin-top: 35px;

            color: #94a3b8;

            font-size: 13px;
        }

        @media (max-width: 750px) {

            .header {
                padding: 18px;
            }

            .container {
                width: calc(100% - 20px);
                margin-top: 22px;
            }

            .page-title h2 {
                font-size: 25px;
            }

            .labels {
                grid-template-columns: 1fr;
            }

            .label-card {
                padding: 24px 20px;
            }
        }

        @media (max-width: 500px) {

            .header {
                flex-direction: column;
                text-align: center;
            }

            .btn-back {
                width: 100%;
            }
        }

    </style>

</head>


<body>

<header class="header">

    <div class="brand">

        <h1>DISTAN ERP</h1>

        <p>
            Salida de producción · Etiquetas
        </p>

    </div>


    <a
        href="{{ route('production.outputs') }}"
        class="btn-back"
    >
        ← Volver
    </a>

</header>


<main class="container">

    <div class="page-title">

        <h2>
            🏷️ Salida de Etiquetas
        </h2>

        <p>
            Selecciona la etiqueta y registra la cantidad retirada.
        </p>

    </div>


    @if(session('success'))

        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            No se pudo registrar la salida.

            <ul class="error-list">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    @if($etiquetas->count())

        <div class="labels">

            @foreach($etiquetas as $etiqueta)

                <div class="label-card">

                    <div class="label-icon">
                        🏷️
                    </div>


                    <div class="label-name">
                        {{ $etiqueta->nombre }}
                    </div>


                    <div class="label-info">

                        @if($etiqueta->idioma)
                            <span class="badge">
                                Idioma: {{ $etiqueta->idioma }}
                            </span>
                        @endif

                        @if($etiqueta->pais)
                            <span class="badge">
                                País: {{ $etiqueta->pais }}
                            </span>
                        @endif

                        @if($etiqueta->zona)
                            <span class="badge">
                                Zona: {{ $etiqueta->zona }}
                            </span>
                        @endif

                        @if($etiqueta->formato)
                            <span class="badge">
                                {{ $etiqueta->formato }}
                            </span>
                        @endif

                    </div>


                    <div class="stock-box">

                        <div class="stock-label">
                            Stock disponible
                        </div>

                        <div class="stock-number">
                            {{ number_format($etiqueta->stock_actual, 0) }}
                        </div>

                    </div>


                    @if($etiqueta->stock_actual > 0)

                        <form
                            action="{{ route(
                                'production.outputs.etiquetas.salida',
                                $etiqueta
                            ) }}"
                            method="POST"
                        >

                            @csrf


                            <div class="form-group">

                                <label
                                    for="cantidad-{{ $etiqueta->id }}"
                                >
                                    Cantidad a retirar
                                </label>

                                <input
                                    id="cantidad-{{ $etiqueta->id }}"
                                    type="number"
                                    name="cantidad"
                                    class="form-control"
                                    min="1"
                                    max="{{ floor($etiqueta->stock_actual) }}"
                                    step="1"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    placeholder="Ejemplo: 100"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label
                                    for="responsable-{{ $etiqueta->id }}"
                                >
                                    Responsable
                                </label>

                                <input
                                    id="responsable-{{ $etiqueta->id }}"
                                    type="text"
                                    name="responsable"
                                    class="form-control"
                                    maxlength="100"
                                    placeholder="Nombre de quien retira"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label
                                    for="observacion-{{ $etiqueta->id }}"
                                >
                                    Observación
                                    <span
                                        style="
                                            font-weight:normal;
                                            color:#94a3b8;
                                        "
                                    >
                                        (opcional)
                                    </span>
                                </label>

                                <input
                                    id="observacion-{{ $etiqueta->id }}"
                                    type="text"
                                    name="observacion"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Ejemplo: Producción de pedido"
                                >

                            </div>


                            <button
                                type="submit"
                                class="btn-submit"
                                onclick="
                                    return confirm(
                                        '¿Confirmas registrar esta salida?'
                                    )
                                "
                            >
                                Registrar salida
                            </button>

                        </form>

                    @else

                        <div
                            style="
                                margin-top:20px;
                                padding:15px;
                                border-radius:10px;
                                background:#fee2e2;
                                color:#991b1b;
                                text-align:center;
                                font-weight:800;
                            "
                        >
                            Sin stock disponible
                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @else

        <div class="empty">

            <div
                style="
                    font-size:55px;
                    margin-bottom:15px;
                "
            >
                🏷️
            </div>

            <h3
                style="
                    font-size:21px;
                    margin-bottom:8px;
                "
            >
                No hay etiquetas disponibles
            </h3>

            <p>
                No existen etiquetas activas registradas en el inventario.
            </p>

        </div>

    @endif


    <div class="footer">
        DISTAN ERP · Registro de salidas de producción
    </div>

</main>

</body>

</html>