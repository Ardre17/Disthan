<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Salida de Producción | DISTAN</title>

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
            padding: 22px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand h1 {
            font-size: 26px;
            font-weight: 800;
        }

        .brand p {
            margin-top: 5px;
            color: #cbd5e1;
            font-size: 15px;
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 13px 20px;

            border-radius: 10px;
            background: #334155;
            color: white;

            text-decoration: none;
            font-size: 15px;
            font-weight: 700;

            border: 1px solid #475569;
        }

        .btn-login:hover {
            background: #475569;
        }

        .container {
            width: min(1200px, calc(100% - 40px));
            margin: 35px auto;
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
        }

        .title h2 {
            font-size: 30px;
            font-weight: 800;
        }

        .title p {
            margin-top: 8px;
            color: #64748b;
            font-size: 17px;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .option {
            min-height: 230px;

            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 18px;

            text-decoration: none;
            color: inherit;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            padding: 25px;

            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.07);

            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease,
                border-color 0.15s ease;
        }

        .option:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
            border-color: #94a3b8;
        }

        .option-image {
            width: 115px;
            height: 115px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 18px;

            border-radius: 18px;
            background: #f8fafc;

            font-size: 70px;
        }

        .option h3 {
            font-size: 21px;
            font-weight: 800;
        }

        .option p {
            margin-top: 6px;
            color: #64748b;
            font-size: 14px;
            text-align: center;
        }

        /*
         * PRODUCTOS
         * Ocupa el ancho de dos columnas en pantallas grandes.
         */
        .option.productos {
            grid-column: span 2;
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            margin: 35px 0 25px;
        }

        /* TABLET */
        @media (max-width: 900px) {

            .header {
                padding: 20px;
            }

            .container {
                width: calc(100% - 30px);
                margin: 25px auto;
            }

            .options {
                grid-template-columns: repeat(2, 1fr);
            }

            .option {
                min-height: 220px;
            }

            .option.productos {
                grid-column: span 2;
            }
        }

        /* CELULAR */
        @media (max-width: 600px) {

            .header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .btn-login {
                width: 100%;
            }

            .title h2 {
                font-size: 25px;
            }

            .title p {
                font-size: 15px;
            }

            .options {
                grid-template-columns: 1fr;
            }

            .option.productos {
                grid-column: span 1;
            }

            .option {
                min-height: 200px;
            }
        }
    </style>
</head>

<body>

    <header class="header">

        <div class="brand">
            <h1>DISTAN ERP</h1>
            <p>Registro de salidas de producción</p>
        </div>

        <a href="{{ route('login') }}" class="btn-login">
            ← Volver al inicio de sesión
        </a>

    </header>


    <main class="container">

        <div class="title">
            <h2>¿Qué deseas retirar?</h2>
            <p>Selecciona el material o producto que vas a retirar.</p>
        </div>


        <div class="options">

            {{-- CAJAS --}}
            <a href="#" class="option">

                <div class="option-image">
                    📦
                </div>

                <h3>Cajas</h3>

                <p>
                    Registrar salida de cajas
                </p>

            </a>


            {{-- ETIQUETAS --}}
            <a href="#" class="option">

                <div class="option-image">
                    🏷️
                </div>

                <h3>Etiquetas</h3>

                <p>
                    Registrar salida de etiquetas
                </p>

            </a>


            {{-- PRECINTOS --}}
            <a href="#" class="option">

                <div class="option-image">
                    🔒
                </div>

                <h3>Precintos</h3>

                <p>
                    Registrar salida de precintos
                </p>

            </a>


            {{-- STICKERS --}}
            <a href="#" class="option">

                <div class="option-image">
                    🏷️
                </div>

                <h3>Stickers de tapa</h3>

                <p>
                    Registrar salida de stickers
                </p>

            </a>


            {{-- PRODUCTOS --}}
            <a href="#" class="option productos">

                <div class="option-image">
                    🛒
                </div>

                <h3>Productos</h3>

                <p>
                    Buscar o escanear un producto
                </p>

            </a>

        </div>


        <div class="footer">
            DISTAN ERP · Registro de producción
        </div>

    </main>

</body>
</html>