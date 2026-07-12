<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DISTAN— Acceso al sistema</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}

:root{
    --navy:#0f172a;
    --navy2:#1e293b;
    --navy3:#334155;
    --accent:#3b82f6;
    --accent2:#1d4ed8;
    --ok:#22c55e;
    --ink:#f1f5f9;
    --ink-muted:#94a3b8;
    --border:#334155;
    --font:'Segoe UI',-apple-system,BlinkMacSystemFont,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',monospace;
}

html,body{
    height:100%;
    font-family:var(--font);
    background:var(--navy);
    color:var(--ink);
    overflow:hidden;
}

/* ── Fondo animado ── */
.bg{
    position:fixed;inset:0;
    background:var(--navy);
    overflow:hidden;
    z-index:0;
}
.bg-glow{
    position:absolute;
    border-radius:50%;
    filter:blur(100px);
    opacity:.25;
    animation:pulse 8s ease-in-out infinite;
}
.bg-glow-1{
    width:600px;height:600px;
    background:#1d4ed8;
    top:-200px;left:-200px;
    animation-delay:0s;
}
.bg-glow-2{
    width:500px;height:500px;
    background:#059669;
    bottom:-200px;right:-200px;
    animation-delay:4s;
}
.bg-glow-3{
    width:300px;height:300px;
    background:#7c3aed;
    top:40%;left:40%;
    animation-delay:2s;
    opacity:.12;
}
@keyframes pulse{
    0%,100%{transform:scale(1);opacity:.25;}
    50%{transform:scale(1.15);opacity:.35;}
}

/* Grid de puntos de fondo */
.bg-grid{
    position:absolute;inset:0;
    background-image:
        radial-gradient(circle,#334155 1px,transparent 1px);
    background-size:32px 32px;
    opacity:.2;
}

/* ── Wrapper ── */
.wrapper{
    position:relative;z-index:1;
    min-height:100vh;
    display:flex;align-items:center;justify-content:center;
    padding:1rem;
}

/* ── Card principal ── */
.login-card{
    display:grid;
    grid-template-columns:1fr 1fr;
    width:860px;
    max-width:100%;
    border-radius:12px;
    overflow:hidden;
    box-shadow:
        0 0 0 1px rgba(255,255,255,.06),
        0 40px 80px rgba(0,0,0,.6),
        0 0 60px rgba(59,130,246,.08);
    animation:slideUp .6s cubic-bezier(.16,1,.3,1) both;
}
@keyframes slideUp{
    from{opacity:0;transform:translateY(24px);}
    to{opacity:1;transform:translateY(0);}
}

/* ── Panel izquierdo (branding) ── */
.panel-left{
    background:linear-gradient(160deg,#1e3a5f 0%,#0f172a 100%);
    padding:2.5rem 2rem;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    border-right:1px solid var(--border);
    position:relative;
    overflow:hidden;
}
.panel-left::before{
    content:'';
    position:absolute;
    width:300px;height:300px;
    background:#2563eb;
    border-radius:50%;
    filter:blur(80px);
    opacity:.12;
    top:-80px;right:-80px;
}

/* Logo y nombre */
.brand{display:flex;align-items:center;gap:10px;}
.brand-icon{
    width:40px;height:40px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border-radius:8px;
    display:flex;align-items:center;justify-content:center;
    font-size:20px;
    box-shadow:0 4px 16px rgba(37,99,235,.4);
    flex-shrink:0;
}
.brand-name{
    font-size:18px;font-weight:800;
    letter-spacing:.5px;color:#f8fafc;
}
.brand-sub{font-size:10px;color:#7eb8f7;font-weight:600;text-transform:uppercase;letter-spacing:.08em;}

/* Módulos disponibles */
.modules{margin-top:2rem;flex:1;}
.modules-title{
    font-size:10px;font-weight:700;
    color:var(--ink-muted);text-transform:uppercase;
    letter-spacing:.08em;margin-bottom:.85rem;
}
.module-list{display:flex;flex-direction:column;gap:6px;}
.module-item{
    display:flex;align-items:center;gap:8px;
    padding:7px 10px;
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.06);
    border-radius:6px;
    font-size:11.5px;color:#cbd5e1;
    transition:background .2s;
}
.module-item:hover{background:rgba(255,255,255,.07);}
.module-dot{
    width:6px;height:6px;border-radius:50%;flex-shrink:0;
    background:var(--ok);box-shadow:0 0 6px rgba(34,197,94,.5);
}

/* Status bar */
.status-bar{
    display:flex;align-items:center;gap:6px;
    padding:8px 10px;
    background:rgba(34,197,94,.08);
    border:1px solid rgba(34,197,94,.15);
    border-radius:6px;
    font-size:11px;color:#86efac;
}
.status-dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--ok);
    box-shadow:0 0 6px rgba(34,197,94,.6);
    animation:blink 2s ease infinite;
    flex-shrink:0;
}
@keyframes blink{
    0%,100%{opacity:1;}
    50%{opacity:.3;}
}

/* ── Panel derecho (formulario) ── */
.panel-right{
    background:#0f172a;
    padding:2.5rem 2rem;
    display:flex;align-items:center;justify-content:center;
}
.form-inner{width:100%;}

.form-title{
    font-size:22px;font-weight:800;
    color:#f8fafc;margin-bottom:4px;
}
.form-sub{
    font-size:12px;color:var(--ink-muted);
    margin-bottom:1.75rem;line-height:1.5;
}

/* Separador */
.divider{
    height:1px;background:var(--border);
    margin-bottom:1.5rem;
}

/* Error */
.error-box{
    background:#450a0a;
    border:1px solid #7f1d1d;
    border-left:3px solid #ef4444;
    border-radius:6px;
    padding:10px 12px;
    margin-bottom:1.1rem;
    font-size:12px;color:#fca5a5;
    display:flex;align-items:center;gap:7px;
}

/* Campo */
.field{
    display:flex;flex-direction:column;gap:5px;
    margin-bottom:14px;
}
.field-label{
    font-size:10px;font-weight:700;
    color:var(--ink-muted);
    text-transform:uppercase;letter-spacing:.06em;
}
.field-wrap{position:relative;}
.field-icon{
    position:absolute;left:11px;top:50%;
    transform:translateY(-50%);
    font-size:14px;color:#475569;
    pointer-events:none;
}
.field-input{
    width:100%;
    padding:10px 12px 10px 36px;
    background:rgba(255,255,255,.05);
    border:1px solid var(--border);
    border-radius:6px;
    color:#f8fafc;
    font-size:13px;
    font-family:var(--font);
    outline:none;
    transition:border-color .2s,background .2s,box-shadow .2s;
}
.field-input::placeholder{color:#475569;}
.field-input:focus{
    border-color:var(--accent);
    background:rgba(59,130,246,.06);
    box-shadow:0 0 0 3px rgba(59,130,246,.15);
}
.field-input.email-input{
    font-family:var(--font-mono);
    letter-spacing:.3px;
}
.toggle-pass{
    position:absolute;right:11px;top:50%;
    transform:translateY(-50%);
    cursor:pointer;color:#475569;
    font-size:15px;
    transition:color .15s;
    background:none;border:none;
    padding:2px;display:flex;
}
.toggle-pass:hover{color:#94a3b8;}

/* Botón */
.btn-login{
    width:100%;
    padding:11px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border:none;border-radius:6px;
    color:#fff;font-size:13px;font-weight:700;
    cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:7px;
    transition:transform .15s,box-shadow .2s,opacity .15s;
    box-shadow:0 4px 20px rgba(37,99,235,.35);
    margin-top:4px;
    font-family:var(--font);
    letter-spacing:.02em;
}
.btn-login:hover{
    transform:translateY(-1px);
    box-shadow:0 8px 28px rgba(37,99,235,.5);
}
.btn-login:active{transform:translateY(0);opacity:.9;}
.btn-arrow{font-size:16px;transition:transform .2s;}
.btn-login:hover .btn-arrow{transform:translateX(3px);}

/* Footer */
.form-footer{
    margin-top:1.25rem;
    padding-top:1rem;
    border-top:1px solid var(--border);
    display:flex;justify-content:space-between;align-items:center;
    flex-wrap:wrap;gap:8px;
}
.footer-tag{
    font-size:10px;color:#334155;
    font-family:var(--font-mono);
    letter-spacing:.04em;
}
.footer-version{
    font-size:10px;color:#334155;
    background:rgba(255,255,255,.03);
    border:1px solid var(--border);
    padding:2px 8px;border-radius:3px;
    font-family:var(--font-mono);
}

/* ── RESPONSIVE ── */
@media(max-width:680px){
    html,body{overflow:auto;}
    .wrapper{
        align-items:flex-start;
        padding:.75rem;
    }
    .login-card{
        grid-template-columns:1fr;
        border-radius:10px;
        width:100%;
    }
    .panel-left{
        padding:1.5rem 1.25rem;
        border-right:none;
        border-bottom:1px solid var(--border);
    }
    .modules{display:none;}
    .panel-right{
        padding:1.5rem 1.25rem;
    }
    .form-title{font-size:18px;}
    .brand-name{font-size:16px;}
}

@media(max-width:360px){
    .panel-right{padding:1.25rem 1rem;}
}
</style>
</head>

<body>

<!-- Fondo -->
<div class="bg">
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>
    <div class="bg-glow bg-glow-3"></div>
</div>

<div class="wrapper">
<div class="login-card">

    <!-- ── Panel izquierdo ── -->
    <div class="panel-left">

        <div>
            <!-- Brand -->
            <div class="brand">
                <div class="brand-icon">🚀</div>
                <div>
                    <div class="brand-name"> DISTAN</div>
                    <div class="brand-sub">ERP Logístico</div>
                </div>
            </div>

            <!-- Módulos -->
            <div class="modules">
                <div class="modules-title">Módulos disponibles</div>
                <div class="module-list">
                    <div class="module-item">
                        <span class="module-dot"></span>
                        📦 Inventario y stock
                    </div>
                    <div class="module-item">
                        <span class="module-dot"></span>
                        📋 Órdenes de pedido
                    </div>
                    <div class="module-item">
                        <span class="module-dot"></span>
                        🏭 Producción
                    </div>
                    <div class="module-item">
                        <span class="module-dot"></span>
                        🚚 Logística / Almacenes
                    </div>
                    <div class="module-item">
                        <span class="module-dot"></span>
                        👥 Clientes
                    </div>
                    <div class="module-item">
                        <span class="module-dot"></span>
                        📊 Proyectado de stock
                    </div>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="status-bar">
            <div class="status-dot"></div>
            Sistema operativo · v2025
        </div>

    </div>

    <!-- ── Panel derecho ── -->
    <div class="panel-right">
    <div class="form-inner">

        <div class="form-title">Bienvenido</div>
        <div class="form-sub">
            Ingresa tus credenciales para acceder<br>al sistema ERP de DISTAN.
        </div>

        <div class="divider"></div>

        @if ($errors->any())
        <div class="error-box">
            ⚠️ {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
        @csrf

            <div class="field">
                <label class="field-label">Correo electrónico</label>
                <div class="field-wrap">
                    <span class="field-icon">✉️</span>
                    <input
                        type="email"
                        name="email"
                        class="field-input email-input"
                        placeholder="usuario@disthan.com"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required>
                </div>
            </div>

            <div class="field">
                <label class="field-label">Contraseña</label>
                <div class="field-wrap">
                    <span class="field-icon">🔒</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="field-input"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required>
                    <button
                        type="button"
                        class="toggle-pass"
                        onclick="togglePassword()"
                        tabindex="-1"
                        aria-label="Mostrar contraseña">
                        👁
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Ingresar al sistema
                <span class="btn-arrow">→</span>
            </button>

        </form>

        <div class="form-footer">
            <span class="footer-tag">DISTAN · Sistema ERP</span>
            <span class="footer-version">build 2026.1</span>
        </div>

    </div>
    </div>

</div>
</div>

<script>
function togglePassword() {
    var input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>