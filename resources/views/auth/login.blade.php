<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DISTAN ERP — Acceso al sistema</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue: #1675ed;
            --blue-dark: #0864d5;
            --navy: #10284b;
            --text: #182b4d;
            --muted: #7d8ba5;
            --border: #d7dfec;
            --white: #ffffff;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            font-family:
                "Segoe UI",
                -apple-system,
                BlinkMacSystemFont,
                sans-serif;

            background: #08172f;

            overflow: hidden;
        }


        /* =====================================================
           FONDO PRINCIPAL
        ===================================================== */

        .login-background {
            position: fixed;

            inset: 0;

            width: 100%;
            height: 100%;

            background-image:
                url("/images/login/login-background-octubre.png");

            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;

            z-index: 0;
        }


        /* =====================================================
           CONTENEDOR
        ===================================================== */

        .wrapper {
            position: relative;

            z-index: 10;

            width: 100%;
            height: 100vh;

            display: flex;

            align-items: center;

            justify-content: flex-end;

            padding-right: 4.1%;
        }


        /* =====================================================
           TARJETA REAL DEL LOGIN
        ===================================================== */

        .login-card {
            position: relative;

            width: 31.8vw;

            max-width: 600px;
            min-width: 430px;

            background: transparent;

            border-radius: 25px;

            overflow: visible;
        }


        /* Ocultamos completamente
           el panel izquierdo antiguo */
        .panel-left {
            display: none !important;
        }


        /* =====================================================
           PANEL DERECHO
        ===================================================== */

        .panel-right {
            width: 100%;

            padding: 0;

            background: transparent;

            border: none;

            display: block;
        }


        /* =====================================================
           FORMULARIO
        ===================================================== */

        .form-inner {
            width: 100%;

            background: rgba(255, 255, 255, 0.985);

            border-radius: 25px;

            padding:
                35px
                38px
                0
                38px;

            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.35),
                0 0 0 1px rgba(255, 255, 255, 0.7);
        }


        /* =====================================================
           LOGO DISTAN ERP
        ===================================================== */

        .login-logo {
            width: 100%;

            display: flex;

            justify-content: center;

            align-items: center;

            margin-bottom: 20px;
        }

        .login-logo img {
            display: block;

            width: 88%;

            max-width: 430px;

            height: auto;
        }


        /* =====================================================
           TITULO
        ===================================================== */

        .form-title {
            font-size: 31px;

            line-height: 1.15;

            font-weight: 800;

            color: var(--text);

            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 14px;

            line-height: 1.5;

            color: var(--muted);

            margin-bottom: 23px;
        }


        /* =====================================================
           ERROR
        ===================================================== */

        .error-box {
            display: flex;

            align-items: center;

            gap: 8px;

            padding: 11px 13px;

            margin-bottom: 15px;

            background: #fff1f2;

            border: 1px solid #fecdd3;

            border-left: 4px solid #ef4444;

            border-radius: 8px;

            color: #be123c;

            font-size: 13px;
        }


        /* =====================================================
           CAMPOS
        ===================================================== */

        .field {
            display: flex;

            flex-direction: column;

            margin-bottom: 14px;
        }

        .field-label {
            display: none;
        }

        .field-wrap {
            position: relative;

            width: 100%;
        }

        .field-icon {
            position: absolute;

            left: 17px;

            top: 50%;

            transform: translateY(-50%);

            font-size: 17px;

            color: #63718a;

            pointer-events: none;
        }

        .field-input {
            width: 100%;

            height: 57px;

            padding:
                0
                48px
                0
                50px;

            border-radius: 10px;

            border: 1px solid var(--border);

            background: #ffffff;

            color: var(--text);

            font-family: inherit;

            font-size: 15px;

            outline: none;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .field-input::placeholder {
            color: #9aa7ba;
        }

        .field-input:focus {
            border-color: #4b9af5;

            box-shadow:
                0 0 0 3px rgba(22, 117, 237, 0.13);
        }


        /* =====================================================
           MOSTRAR CONTRASEÑA
        ===================================================== */

        .toggle-pass {
            position: absolute;

            right: 15px;

            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: transparent;

            color: #63718a;

            cursor: pointer;

            font-size: 17px;

            padding: 4px;
        }

        .toggle-pass:hover {
            color: var(--blue);
        }


        /* =====================================================
           RECORDAR / RECUPERAR
        ===================================================== */

        .login-options {
            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin:
                3px
                0
                19px;

            font-size: 13px;
        }

        .remember {
            display: flex;

            align-items: center;

            gap: 7px;

            color: #263754;

            white-space: nowrap;
        }

        .remember input {
            width: 17px;

            height: 17px;

            accent-color: var(--blue);

            cursor: pointer;
        }

        .forgot-password {
            color: var(--blue);

            font-weight: 600;

            text-decoration: none;

            white-space: nowrap;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }


        /* =====================================================
           BOTON INICIAR SESION
        ===================================================== */

        .btn-login {
            width: 100%;

            height: 57px;

            border: none;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #167af0,
                    #0865d8
                );

            color: #ffffff;

            font-family: inherit;

            font-size: 16px;

            font-weight: 700;

            letter-spacing: 0.01em;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            box-shadow:
                0 7px 20px rgba(22, 117, 237, 0.28);

            transition:
                transform 0.15s ease,
                box-shadow 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);

            box-shadow:
                0 11px 26px rgba(22, 117, 237, 0.38);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-arrow {
            font-size: 20px;

            transition:
                transform 0.2s ease;
        }

        .btn-login:hover .btn-arrow {
            transform: translateX(3px);
        }


        /* =====================================================
           REGISTRAR SALIDA
        ===================================================== */

        .btn-production {
            width: calc(100% + 76px);

            margin-left: -38px;

            min-height: 54px;

            padding: 13px 18px;

            margin-top: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            background: #ffffff;

            color: #1475e8;

            border: none;

            border-top: 1px solid #e5e9f0;

            border-radius: 0 0 25px 25px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;

            transition:
                background 0.2s ease;
        }

        .btn-production:hover {
            background: #f5f8fc;
        }

        .btn-production span {
            font-size: 16px;
        }


        /* =====================================================
           ILUSTRACION HALLOWEEN DEL FORMULARIO
        ===================================================== */

        .login-season-art {
            display: block;

            width: calc(100% + 76px);

            height: 150px;

            margin-left: -38px;

            margin-top: 19px;

            object-fit: cover;

            object-position: center;

            border: none;
        }


        /* =====================================================
           FOOTER ANTIGUO
        ===================================================== */

        .form-footer {
            display: none !important;
        }


        /* =====================================================
           RESPONSIVE — PANTALLAS MEDIANAS
        ===================================================== */

        @media (max-width: 1200px) {

            .wrapper {
                padding-right: 2.5%;
            }

            .login-card {
                width: 36vw;

                min-width: 410px;
            }

            .form-inner {
                padding-left: 32px;

                padding-right: 32px;
            }

            .btn-production,
            .login-season-art {
                width: calc(100% + 64px);

                margin-left: -32px;
            }

            .login-logo img {
                width: 90%;
            }
        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 850px) {

            body {
                overflow-y: auto;
            }

            .login-background {
                background-position: center center;
            }

            .wrapper {
                height: auto;

                min-height: 100vh;

                justify-content: center;

                align-items: center;

                padding:
                    30px
                    20px;
            }

            .login-card {
                width: min(520px, 94vw);

                min-width: 0;

                margin: 0;
            }

            .form-inner {
                padding:
                    32px
                    30px
                    0;
            }

            .btn-production,
            .login-season-art {
                width: calc(100% + 60px);

                margin-left: -30px;
            }
        }


        /* =====================================================
           CELULAR
        ===================================================== */

        @media (max-width: 520px) {

            .wrapper {
                padding:
                    18px
                    12px;
            }

            .login-card {
                width: 100%;
            }

            .form-inner {
                padding:
                    27px
                    20px
                    0;

                border-radius: 18px;
            }

            .login-logo {
                margin-bottom: 16px;
            }

            .login-logo img {
                width: 94%;
            }

            .form-title {
                font-size: 26px;
            }

            .form-sub {
                font-size: 13px;

                margin-bottom: 19px;
            }

            .field-input {
                height: 53px;

                font-size: 14px;
            }

            .btn-login {
                height: 53px;

                font-size: 15px;
            }

            .login-options {
                font-size: 12px;

                gap: 8px;
            }

            .login-season-art {
                height: 125px;

                width: calc(100% + 40px);

                margin-left: -20px;

                margin-top: 17px;
            }

            .btn-production {
                width: calc(100% + 40px);

                margin-left: -20px;

                min-height: 52px;

                border-radius:
                    0
                    0
                    18px
                    18px;

                font-size: 12px;
            }
        }


        /* =====================================================
           CELULAR PEQUEÑO
        ===================================================== */

        @media (max-width: 380px) {

            .login-options {
                align-items: flex-start;

                flex-direction: column;

                gap: 8px;
            }

            .forgot-password {
                margin-left: 24px;
            }
        }

    </style>
</head>


<body>

    {{-- =====================================================
         FONDO DE TEMPORADA
    ====================================================== --}}

    <div class="login-background"></div>


    {{-- =====================================================
         CONTENEDOR
    ====================================================== --}}

    <div class="wrapper">

        <div class="login-card">

            {{-- =================================================
                 PANEL DERECHO / LOGIN
            ================================================== --}}

            <div class="panel-right">

                <div class="form-inner">


                    {{-- =================================================
                         LOGO GRANDE DISTAN ERP
                    ================================================== --}}

                    <div class="login-logo">

                        <img
                            src="{{ asset('images/login/distan-logo-login.png') }}"
                            alt="DISTAN ERP"
                        >

                    </div>


                    {{-- =================================================
                         TITULO
                    ================================================== --}}

                    <div class="form-title">
                        Bienvenido
                    </div>

                    <div class="form-sub">
                        Ingresa a tu cuenta para continuar
                    </div>


                    {{-- =================================================
                         ERRORES
                    ================================================== --}}

                    @if ($errors->any())

                        <div class="error-box">

                            <span>⚠️</span>

                            <span>
                                {{ $errors->first() }}
                            </span>

                        </div>

                    @endif


                    {{-- =================================================
                         FORMULARIO LARAVEL
                    ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('login') }}"
                    >

                        @csrf


                        {{-- =================================================
                             USUARIO / CORREO
                        ================================================== --}}

                        <div class="field">

                            <label
                                class="field-label"
                                for="email"
                            >
                                Correo electrónico
                            </label>

                            <div class="field-wrap">

                                <span class="field-icon">
                                    👤
                                </span>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    class="field-input"
                                    placeholder="Usuario"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >

                            </div>

                        </div>


                        {{-- =================================================
                             CONTRASEÑA
                        ================================================== --}}

                        <div class="field">

                            <label
                                class="field-label"
                                for="password"
                            >
                                Contraseña
                            </label>

                            <div class="field-wrap">

                                <span class="field-icon">
                                    🔒
                                </span>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="field-input"
                                    placeholder="Contraseña"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="toggle-pass"
                                    onclick="togglePassword()"
                                    tabindex="-1"
                                    aria-label="Mostrar contraseña"
                                >
                                    👁
                                </button>

                            </div>

                        </div>


                        {{-- =================================================
                             RECORDAR / RECUPERAR
                        ================================================== --}}

                        <div class="login-options">

                            <label class="remember">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                >

                                <span>
                                    Recordarme
                                </span>

                            </label>


                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="forgot-password"
                                >
                                    ¿Olvidaste tu contraseña?
                                </a>

                            @endif

                        </div>


                        {{-- =================================================
                             INICIAR SESION
                        ================================================== --}}

                        <button
                            type="submit"
                            class="btn-login"
                        >

                            <span class="btn-arrow">
                                →
                            </span>

                            <span>
                                Iniciar sesión
                            </span>

                        </button>


                    </form>


                    {{-- =================================================
                         IMAGEN INFERIOR DE HALLOWEEN
                    ================================================== --}}

                    <img
                        class="login-season-art"
                        src="{{ asset('images/login/halloween-card-bottom.png') }}"
                        alt=""
                    >


                    {{-- =================================================
                         REGISTRAR SALIDA DE PRODUCCION
                         DEBAJO DEL LOGIN
                    ================================================== --}}

                    <a
                        href="{{ route('production.outputs') }}"
                        class="btn-production"
                    >

                        <span>
                            📦
                        </span>

                        <span>
                            Registrar salida de producción
                        </span>

                    </a>


                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script>

        function togglePassword() {

            const input =
                document.getElementById('password');

            const button =
                document.querySelector('.toggle-pass');

            if (input.type === 'password') {

                input.type = 'text';

                button.innerHTML = '🙈';

                button.setAttribute(
                    'aria-label',
                    'Ocultar contraseña'
                );

            } else {

                input.type = 'password';

                button.innerHTML = '👁';

                button.setAttribute(
                    'aria-label',
                    'Mostrar contraseña'
                );

            }

        }

    </script>

</body>

</html>