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

        .main-content {
            margin-left:285px;
            padding:25px;
            min-height:100vh;
            transition:0.3s;
        }

    </style>
</head>

<body>

    @include('layouts.navigation')

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>
