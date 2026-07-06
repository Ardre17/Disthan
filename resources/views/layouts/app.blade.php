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
    width:200px;
    height:auto;
}

#fano-img:hover{

    transform:scale(1.05);

}

#fano-chat{

    position:absolute;

    bottom:260px;

    right:120px;

    width:250px;

    background:#fff;

    border-radius:18px;

    padding:18px;

    box-shadow:0 10px 30px rgba(0,0,0,.18);

    transition:.4s;

    z-index:10000;

}
#fano-chat::after{

    content:"";

    position:absolute;

    right:-14px;

    bottom:30px;

    border-top:12px solid transparent;

    border-bottom:12px solid transparent;

    border-left:16px solid white;

}

.fano-hidden{

    opacity:0;

    visibility:hidden;

}

.fano-show{

    opacity:1;

    visibility:visible;

}
#fano-btn{

    margin-top:15px;

    width:100%;

    border:none;

    background:#2563eb;

    color:white;

    padding:12px;

    border-radius:12px;

    cursor:pointer;

    font-weight:bold;

    transition:.3s;

}

#fano-btn:hover{

    background:#1d4ed8;

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
