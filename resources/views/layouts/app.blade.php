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

    right:20px;

    bottom:20px;

    z-index:9999;

}

#fano-img{

    width:210px;

    cursor:pointer;

    transition:.3s;

}

#fano-img:hover{

    transform:scale(1.05);

}

#fano-chat{

    position:absolute;

    bottom:190px;

    right:40px;

    width:240px;

    background:white;

    border-radius:18px;

    padding:16px;

    box-shadow:0 10px 30px rgba(0,0,0,.18);

    transition:.4s;

}

#fano-chat::after{

    content:"";

    position:absolute;

    bottom:-14px;

    right:45px;

    border-left:12px solid transparent;

    border-right:12px solid transparent;

    border-top:16px solid white;

}

.fano-hidden{

    opacity:0;

    visibility:hidden;

}

.fano-show{

    opacity:1;

    visibility:visible;

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

<body>

    @include('layouts.navigation')

    <div class="main-content">
        @yield('content')
    </div>
<x-fano />
</body>
</html>
