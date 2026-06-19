<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
            margin-left:260px;
            padding:20px;
            min-height:100vh;
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