<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DISTAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin:0;
            font-family:sans-serif;
            background:#f4f6f9;
        }

        /* ── CAMBIO 1: quitar margin-left fijo, dejarlo en 0 ──
           El sidebar ya maneja el margen con .main-content en su propio CSS.
           Solo necesitamos el padding y el id correcto aquí. */
        #mainContent {
            padding: 20px;
            min-height: 100vh;
            transition: margin-left .3s ease;
        }
    </style>
</head>

<body>

    @include('layouts.navigation')

    {{-- CAMBIO 2: agregar id="mainContent" y class="main-content" --}}
    <div id="mainContent" class="main-content">
        @yield('content')
    </div>

</body>
</html>