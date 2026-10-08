<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DISTAN ERP — Acceso al sistema</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
    --blue:#1473ea;
    --text:#172554;
    --muted:#71809d;
    --line:#dce3ef;
    --font:'Segoe UI',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;
}
html,body{width:100%;min-height:100%;font-family:var(--font);background:#07152f}
body{overflow:hidden}

/* La ilustración aprobada ocupa TODA la pantalla. */
.login-page{
    position:relative;
    min-height:100vh;
    width:100%;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    padding:clamp(18px,3.2vw,46px) clamp(18px,5vw,82px);
    overflow:hidden;
    background:#07152f url('/images/login/login-background-octubre.png') center center / cover no-repeat;
}

/* Capa suave para que el formulario se lea sin perder el almacén del fondo. */
.login-page::after{
    content:'';
    position:absolute;
    inset:0;
    pointer-events:none;
    background:linear-gradient(90deg,rgba(2,8,24,.02) 0%,rgba(2,8,24,.02) 48%,rgba(2,8,24,.16) 100%);
}

.login-side{
    position:relative;
    z-index:3;
    width:min(480px,38vw);
    min-width:420px;
    display:flex;
    justify-content:center;
}

.login-card{
    width:100%;
    max-height:calc(100vh - 42px);
    overflow:hidden;
    background:rgba(255,255,255,.985);
    border-radius:24px;
    box-shadow:0 28px 75px rgba(0,0,0,.40),0 0 0 1px rgba(255,255,255,.55);
    animation:cardIn .5s cubic-bezier(.16,1,.3,1) both;
}
@keyframes cardIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}

.form-content{padding:31px 38px 0}
.brand-logo{display:block;width:245px;max-width:78%;height:auto;margin:0 auto 18px}
.welcome{color:var(--text);font-size:30px;line-height:1.1;font-weight:800;letter-spacing:-.035em}
.subtitle{margin-top:5px;margin-bottom:22px;color:var(--muted);font-size:14px}

.error-box{background:#fff1f2;border:1px solid #fecdd3;border-left:4px solid #ef4444;border-radius:10px;color:#be123c;padding:10px 12px;margin-bottom:14px;font-size:13px}
.field{margin-bottom:13px}.field-wrap{position:relative}
.field-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#60708f;pointer-events:none;z-index:2;font-size:17px}
.field-input{width:100%;height:54px;border:1px solid var(--line);border-radius:12px;background:#fff;color:#172554;font-size:14px;padding:0 47px 0 45px;outline:none;transition:.2s;box-shadow:0 2px 7px rgba(15,23,42,.025)}
.field-input::placeholder{color:#9aa6bb}
.field-input:focus{border-color:#75a9f8;box-shadow:0 0 0 4px rgba(20,115,234,.10)}
.toggle-pass{position:absolute;right:14px;top:50%;transform:translateY(-50%);border:0;background:none;color:#60708f;cursor:pointer;font-size:17px;padding:5px}

.form-options{display:flex;align-items:center;justify-content:space-between;gap:10px;margin:6px 0 17px;font-size:12.5px;color:#34415d}
.remember{display:flex;align-items:center;gap:7px;cursor:pointer;white-space:nowrap}.remember input{width:16px;height:16px;accent-color:var(--blue)}
.forgot{color:#086bea;text-decoration:none;font-weight:600;white-space:nowrap}.forgot:hover{text-decoration:underline}

.btn-login{width:100%;height:54px;border:0;border-radius:11px;background:linear-gradient(135deg,#1473ea,#0862d5);color:#fff;font-size:15px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;box-shadow:0 8px 23px rgba(20,115,234,.25);transition:.18s}
.btn-login:hover{transform:translateY(-1px);box-shadow:0 12px 28px rgba(20,115,234,.32)}
.btn-arrow{font-size:22px;line-height:1}

.card-decoration{height:145px;margin:20px -38px 0;background:url('/images/login/halloween-card-bottom.png') center bottom / cover no-repeat}
.production-link{display:flex;justify-content:center;align-items:center;gap:8px;color:#50617d;text-decoration:none;font-size:12px;font-weight:600;padding:12px 0 14px;border-top:1px solid #edf1f7;background:#fff}
.production-link:hover{color:var(--blue)}

/* Evita que el contenido sobresalga en pantallas pequeñas. */
@media (max-height:760px) and (min-width:901px){
    .login-page{padding-top:18px;padding-bottom:18px}
    .form-content{padding-top:23px}
    .brand-logo{width:210px;margin-bottom:12px}
    .welcome{font-size:26px}.subtitle{margin-bottom:15px}
    .field{margin-bottom:10px}.field-input{height:48px}
    .form-options{margin-bottom:12px}.btn-login{height:49px}
    .card-decoration{height:110px;margin-top:14px}
    .production-link{padding:9px 0 10px}
}

@media(max-width:900px){
    html,body{overflow:auto}
    .login-page{
        min-height:100vh;
        align-items:flex-start;
        justify-content:center;
        padding:32px 18px;
        background-position:center center;
    }
    .login-page::before{
        content:'';
        position:absolute;inset:0;
        background:rgba(4,12,32,.20);
        z-index:1;
    }
    .login-side{width:min(480px,100%);min-width:0;margin-top:70px}
}

@media(max-width:600px){
    .login-page{padding:20px 12px 28px;background-position:42% center}
    .login-side{margin-top:35px}
    .login-card{border-radius:20px}
    .form-content{padding:25px 22px 0}
    .brand-logo{width:225px;margin-bottom:15px}
    .welcome{font-size:27px}
    .subtitle{font-size:13px}
    .card-decoration{height:125px;margin-left:-22px;margin-right:-22px}
}

@media(max-width:390px){
    .login-page{padding-left:9px;padding-right:9px}
    .form-content{padding-left:17px;padding-right:17px}
    .card-decoration{margin-left:-17px;margin-right:-17px}
    .form-options{font-size:11px}
    .forgot{font-size:11px}
}
</style>
</head>
<body>
<div class="login-page">
    <main class="login-side">
        <section class="login-card" aria-label="Inicio de sesión DISTAN ERP">
            <div class="form-content">
                <img class="brand-logo" src="{{ asset('images/login/distan-logo-login.png') }}" alt="DISTAN ERP">

                <h1 class="welcome">Bienvenido</h1>
                <p class="subtitle">Ingresa a tu cuenta para continuar</p>

                @if ($errors->any())
                    <div class="error-box">⚠️ {{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <div class="field-wrap">
                            <span class="field-icon" aria-hidden="true">♙</span>
                            <input type="email" name="email" class="field-input" placeholder="Usuario" value="{{ old('email') }}" autocomplete="email" required autofocus>
                        </div>
                    </div>

                    <div class="field">
                        <div class="field-wrap">
                            <span class="field-icon" aria-hidden="true">♙</span>
                            <input type="password" id="password" name="password" class="field-input" placeholder="Contraseña" autocomplete="current-password" required>
                            <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Mostrar contraseña">◉</button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember">
                            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <span>Recordarme</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="forgot" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">
                        <span class="btn-arrow">→</span>
                        Iniciar sesión
                    </button>
                </form>
            </div>

            <div class="card-decoration" aria-hidden="true"></div>

            @if (Route::has('production.outputs'))
                <a href="{{ route('production.outputs') }}" class="production-link">
                    📦 Registrar salida de producción
                </a>
            @endif
        </section>
    </main>
</div>

<script>
function togglePassword(){
    const input=document.getElementById('password');
    const button=document.querySelector('.toggle-pass');
    const visible=input.type==='text';
    input.type=visible?'password':'text';
    button.setAttribute('aria-label',visible?'Mostrar contraseña':'Ocultar contraseña');
}
</script>
</body>
</html>
