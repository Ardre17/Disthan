<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Salida de Cajas | DISTAN</title>

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

        .boxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .box-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 18px;

            padding: 28px;

            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.07);
        }

        .box-card:hover {
            border-color: #94a3b8;
        }

        .box-icon {
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

        .box-name {
            text-align: center;
            font-size: 23px;
            font-weight: 800;
        }

        .box-type {
            text-align: center;
            margin-top: 6px;

            font-size: 13px;
            font-weight: 700;

            color: #64748b;
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
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
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

        .btn-submit:active {
            transform: scale(0.99);
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

            .header .btn-back {
                padding: 11px 14px;
                font-size: 14px;
            }

            .container {
                width: calc(100% - 20px);
                margin-top: 22px;
            }

            .page-title h2 {
                font-size: 25px;
            }

            .boxes {
                grid-template-columns: 1fr;
            }

            .box-card {
                padding: 24px 20px;
            }
        }

        @media (max-width: 500px) {

            .header {
                flex-direction: column;
                text-align: center;
            }

            .header .btn-back {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<header class="header">

    <div class="brand">
        <h1>DISTAN ERP</h1>
        <p>Salida de producción · Cajas</p>
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
        <h2>📦 Salida de Cajas</h2>

        <p>
            Selecciona la caja y registra la cantidad retirada.
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


    @if($cajas->count())

        <div class="boxes">

            @foreach($cajas as $caja)

                <div class="box-card">

                    <div class="box-icon">
                        📦
                    </div>

                    <div class="box-name">
                        {{ $caja->nombre }}
                    </div>

                    <div class="box-type">

                        {{ $caja->tipo === 'CON_LOGO'
                            ? 'CON LOGO'
                            : 'SIN LOGO'
                        }}

                    </div>


                    <div class="stock-box">

                        <div class="stock-label">
                            Stock disponible
                        </div>

                        <div class="stock-number">
                            {{ number_format($caja->stock_actual, 2) }}
                        </div>

                    </div>


                    @if($caja->stock_actual > 0)

                        <form
                            action="{{ route('production.outputs.cajas.salida', $caja) }}"
                            method="POST"
                        >

                            @csrf


                            <div class="form-group">

                                <label for="cantidad-{{ $caja->id }}">
                                    Cantidad a retirar
                                </label>

                                <input
                                    id="cantidad-{{ $caja->id }}"
                                    type="number"
                                    name="cantidad"
                                    class="form-control"
                                    min="0.01"
                                    max="{{ $caja->stock_actual }}"
                                    step="1"
                                    inputmode="numeric"
                                    placeholder="Ejemplo: 10"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label for="responsable-{{ $caja->id }}">
                                    Responsable
                                </label>

                                <input
                                    id="responsable-{{ $caja->id }}"
                                    type="text"
                                    name="responsable"
                                    class="form-control"
                                    maxlength="100"
                                    placeholder="Nombre de quien retira"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label for="observacion-{{ $caja->id }}">
                                    Observación
                                    <span style="font-weight: normal; color: #94a3b8;">
                                        (opcional)
                                    </span>
                                </label>

                                <input
                                    id="observacion-{{ $caja->id }}"
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
                                onclick="return confirm('¿Confirmas registrar esta salida?')"
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

            <div style="font-size:55px; margin-bottom:15px;">
                📦
            </div>

            <h3 style="font-size:21px; margin-bottom:8px;">
                No hay cajas disponibles
            </h3>

            <p>
                No existen cajas activas registradas en el inventario.
            </p>

        </div>

    @endif


    <div class="footer">
        DISTAN ERP · Registro de salidas de producción
    </div>

</main>

</body>
</html>