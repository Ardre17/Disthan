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
    --blue-dark:#0d47b5;
    --navy:#08152f;
    --text:#172554;
    --muted:#71809d;
    --line:#dce3ef;
    --orange:#ff8a00;
    --card:#fff;
    --font:'Segoe UI',-apple-system,BlinkMacSystemFont,'Helvetica Neue',Arial,sans-serif;
}
html,body{min-height:100%;font-family:var(--font);background:#07152f}
body{overflow-x:hidden}
.login-page{min-height:100vh;display:grid;grid-template-columns:minmax(0,1.05fr) minmax(390px,.95fr);background:#07152f}

/* IZQUIERDA: arte aprobado de octubre */
.season-panel{
    position:relative;min-height:100vh;overflow:hidden;
    background:#111d35 url('/images/login/octubre-left.png') center center/cover no-repeat;
}
.season-panel::after{content:'';position:absolute;inset:0;background:linear-gradient(90deg,rgba(3,10,27,.08),rgba(3,10,27,.05) 65%,rgba(3,10,27,.24));pointer-events:none}

/* DERECHA */
.login-side{display:flex;align-items:center;justify-content:center;padding:34px;background:linear-gradient(145deg,#07152f 0%,#10254a 100%);position:relative}
.login-side::before{content:'';position:absolute;width:360px;height:360px;border-radius:50%;background:#1473ea;filter:blur(120px);opacity:.10;right:-150px;top:-100px}
.login-card{position:relative;width:min(500px,100%);background:rgba(255,255,255,.98);border-radius:24px;padding:38px 42px 0;box-shadow:0 30px 80px rgba(0,0,0,.38);overflow:hidden;animation:cardIn .55s cubic-bezier(.16,1,.3,1)}
@keyframes cardIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}

.brand-logo{display:block;width:270px;max-width:82%;height:auto;margin:0 auto 20px}
.welcome{text-align:left;color:var(--text);font-size:31px;font-weight:800;letter-spacing:-.03em}
.subtitle{margin-top:5px;color:var(--muted);font-size:15px;margin-bottom:24px}

.error-box{background:#fff1f2;border:1px solid #fecdd3;border-left:4px solid #ef4444;border-radius:10px;color:#be123c;padding:11px 13px;margin-bottom:16px;font-size:13px}
.field{margin-bottom:14px}.field-wrap{position:relative}
.field-icon{position:absolute;left:17px;top:50%;transform:translateY(-50%);color:#60708f;pointer-events:none;z-index:2}
.field-input{width:100%;height:58px;border:1px solid var(--line);border-radius:13px;background:#fff;color:#172554;font-size:15px;padding:0 48px 0 48px;outline:none;transition:.2s;box-shadow:0 2px 7px rgba(15,23,42,.025)}
.field-input::placeholder{color:#9aa6bb}.field-input:focus{border-color:#75a9f8;box-shadow:0 0 0 4px rgba(20,115,234,.10)}
.toggle-pass{position:absolute;right:15px;top:50%;transform:translateY(-50%);border:0;background:none;color:#60708f;cursor:pointer;font-size:18px;padding:4px}
.form-options{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:7px 0 18px;font-size:13px;color:#34415d}
.remember{display:flex;align-items:center;gap:8px;cursor:pointer}.remember input{width:17px;height:17px;accent-color:var(--blue)}
.forgot{color:#086bea;text-decoration:none;font-weight:600}.forgot:hover{text-decoration:underline}
.btn-login{width:100%;height:56px;border:0;border-radius:12px;background:linear-gradient(135deg,#1473ea,#0862d5);color:#fff;font-size:16px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;box-shadow:0 9px 25px rgba(20,115,234,.25);transition:.18s}
.btn-login:hover{transform:translateY(-1px);box-shadow:0 13px 30px rgba(20,115,234,.32)}.btn-login:active{transform:none}
.btn-arrow{font-size:23px;line-height:1}

.card-decoration{height:190px;margin:24px -42px 0;background:url('/images/login/halloween-card-bottom.png') center bottom/cover no-repeat;position:relative}
.card-decoration::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(255,255,255,0) 0%,rgba(255,255,255,.02) 15%,rgba(255,255,255,.04));pointer-events:none}
.production-link{display:flex;justify-content:center;align-items:center;gap:8px;color:#50617d;text-decoration:none;font-size:12px;font-weight:600;padding:13px 0 16px;border-top:1px solid #edf1f7;background:#fff;position:relative;z-index:3}
.production-link:hover{color:var(--blue)}

@media(max-width:1000px){.login-page{grid-template-columns:1fr}.season-panel{min-height:430px;height:430px}.login-side{min-height:auto;padding:28px 20px}.login-card{margin-top:-90px;z-index:5}}
@media(max-width:600px){
    .season-panel{height:310px;min-height:310px;background-position:56% center}
    .login-side{padding:0 12px 18px;align-items:flex-start;background:#07152f}
    .login-card{margin-top:-35px;border-radius:20px;padding:28px 22px 0}
    .brand-logo{width:235px;margin-bottom:15px}.welcome{font-size:27px}.subtitle{font-size:14px}
    .form-options{font-size:12px}.card-decoration{height:145px;margin-left:-22px;margin-right:-22px}
}
@media(max-width:390px){.season-panel{height:260px;min-height:260px}.login-card{padding-left:17px;padding-right:17px}.card-decoration{margin-left:-17px;margin-right:-17px}.forgot{font-size:11px}}
</style>
</head>
<body>
<div class="login-page">
    <section class="season-panel" aria-label="Temporada octubre DISTAN ERP"></section>

    <main class="login-side">
        <section class="login-card" aria-label="Inicio de sesión DISTAN ERP">
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
    button.textContent=visible?'◉':'◉';
    button.setAttribute('aria-label',visible?'Mostrar contraseña':'Ocultar contraseña');
}
</script>
</body>
</html>
