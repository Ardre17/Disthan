<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>DISTAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #fano-container{

    position:fixed;

    right:25px;

    bottom:20px;

    z-index:9999;

    display:flex;

    align-items:flex-end;

    gap:15px;

}

#fano-img{

    width:240px;

    transition:.3s;

    cursor:pointer;

}

#fano-img:hover{

    transform:scale(1.05);

}

#fano-chat{

    background:#fff;

    border-radius:18px;

    padding:18px;

    width:220px;

    box-shadow:0 10px 35px rgba(0,0,0,.15);

    position:relative;

    font-size:15px;

}

#fano-chat:after{

    content:"";

    position:absolute;

    right:-18px;

    bottom:30px;

    border-top:10px solid transparent;

    border-bottom:10px solid transparent;

    border-left:20px solid white;

}
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
<x-fano />
<body>

    @include('layouts.navigation')

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>
