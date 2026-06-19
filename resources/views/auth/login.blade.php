<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>DISTHAN Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    height:100vh;
    background:linear-gradient(135deg,#020617,#0f172a);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

/* GLOW FONDO */
body::before{
    content:'';
    position:absolute;
    width:500px;
    height:500px;
    background:#2563eb;
    filter:blur(120px);
    top:-100px;
    left:-100px;
    opacity:0.3;
}

body::after{
    content:'';
    position:absolute;
    width:400px;
    height:400px;
    background:#22c55e;
    filter:blur(120px);
    bottom:-100px;
    right:-100px;
    opacity:0.3;
}

/* CONTENEDOR */
.container{
    display:flex;
    width:900px;
    height:550px;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 30px 80px rgba(0,0,0,.6);
    animation:fadeIn 0.8s ease;
}

/* IZQUIERDA */
.left{
    width:50%;
    background:linear-gradient(135deg,#1e3a8a,#020617);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
}

.left h1{
    font-size:44px;
    letter-spacing:1px;
}

.left p{
    margin-top:10px;
    color:#cbd5f5;
}

/* DERECHA */
.right{
    width:50%;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(20px);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* CARD */
.card{
    width:80%;
    color:white;
}

.card h2{
    margin-bottom:20px;
}

/* INPUT */
.input{
    margin-bottom:15px;
    position:relative;
}

.input input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    background:rgba(255,255,255,0.1);
    color:white;
    transition:0.3s;
}

.input input:focus{
    outline:none;
    background:rgba(255,255,255,0.2);
    box-shadow:0 0 0 2px #2563eb;
}

/* ICONO OJO */
.toggle-pass{
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#94a3b8;
}

/* BOTÓN */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 30px rgba(37,99,235,.5);
}

/* ERROR */
.error{
    background:#7f1d1d;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
}

/* ANIMACIÓN */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}
</style>

</head>

<body>

<div class="container">

    <div class="left">
        <div>
            <h1>🚀 DISTHAN</h1>
            <p>ERP Logístico Inteligente</p>
        </div>
    </div>

    <div class="right">

        <div class="card">

            <h2>Iniciar Sesión</h2>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input">
                    <input type="email" name="email" placeholder="Correo" required>
                </div>

                <div class="input">
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <span class="toggle-pass" onclick="togglePassword()">👁</span>
                </div>

                <button>Ingresar</button>

            </form>

        </div>

    </div>

</div>

<script>
function togglePassword(){
    let input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>


