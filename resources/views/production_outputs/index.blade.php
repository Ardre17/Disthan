<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida de Producción | DISTAN ERP</title>

    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #1e3a5f;
            --navy2:   #0f2240;
            --navy3:   #152d4d;
            --surface: #ffffff;
            --bg:      #eef1f5;
            --border:  #dde2ea;
            --ink:     #1c2733;
            --muted:   #5b6b7d;
            --accent:  #2563eb;
            --ok:      #16a34a;
            --warn:    #d97706;
            --danger:  #dc2626;
            --font:    'Segoe UI', -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            --mono:    'Consolas', 'SFMono-Regular', monospace;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top bar ERP ── */
        .erp-bar {
            background: var(--navy);
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .erp-bar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .erp-logo {
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .5px;
        }
        .erp-sep {
            width: 1px;
            height: 18px;
            background: rgba(255,255,255,.15);
        }
        .erp-module {
            color: #7eb8f7;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
        }
        .erp-bar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .erp-time {
            font-size: 11px;
            color: #5a8abf;
            font-family: var(--mono);
        }

        /* ── Header ── */
        .page-header {
            background: var(--navy2);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            border-bottom: 3px solid var(--accent);
        }
        .page-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .page-header-icon {
            width: 44px;
            height: 44px;
            background: rgba(37,99,235,.18);
            border: 1px solid rgba(37,99,235,.35);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .page-header-title {
            color: #fff;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .2px;
        }
        .page-header-sub {
            color: #7eb8f7;
            font-size: 11px;
            margin-top: 2px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 4px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: #cbd5e1;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background .15s;
            white-space: nowrap;
        }
        .btn-back:hover {
            background: rgba(255,255,255,.13);
            color: #fff;
        }
        .btn-back svg {
            width: 14px; height: 14px; flex-shrink: 0;
        }

        /* ── Info strip ── */
        .info-strip {
            background: #0b1e38;
            border-bottom: 1px solid rgba(255,255,255,.06);
            padding: .5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .info-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #5a8abf;
        }
        .info-chip-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse 2s ease infinite;
            flex-shrink: 0;
        }
        @keyframes pulse {
            0%,100%{opacity:1;transform:scale(1);}
            50%{opacity:.4;transform:scale(1.3);}
        }
        .info-chip strong { color: #93c5fd; font-weight: 700; }

        /* ── Container ── */
        .container {
            width: min(1200px, calc(100% - 40px));
            margin: 2rem auto;
            flex: 1;
        }

        /* ── Section heading ── */
        .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.25rem;
        }
        .section-head-bar {
            width: 4px;
            height: 22px;
            background: var(--accent);
            border-radius: 2px;
            flex-shrink: 0;
        }
        .section-head-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
        }
        .section-head-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
        }
        .section-head-count {
            margin-left: auto;
            font-size: 11px;
            color: var(--muted);
            font-family: var(--mono);
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 2px 10px;
            border-radius: 99px;
        }

        /* ── Grid de opciones ── */
        .options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        /* ── Tarjeta de opción ── */
        .option {
            position: relative;
            background: var(--surface);
            border: 1px solid var(--border);
            border-top: 3px solid transparent;
            border-radius: 6px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem 1.5rem;
            min-height: 210px;
            gap: .75rem;
            transition: transform .15s, box-shadow .15s, border-color .15s;
            overflow: hidden;
        }
        .option::after {
            content: '';
            position: absolute;
            inset: 0;
            background: currentColor;
            opacity: 0;
            transition: opacity .15s;
            pointer-events: none;
        }
        .option:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(15,23,42,.12);
        }
        .option:hover::after { opacity: .03; }
        .option:active { transform: translateY(-1px); }

        /* Colores de acento por tipo */
        .option-cajas     { border-top-color: #2563eb; color: #2563eb; }
        .option-etiquetas { border-top-color: #d97706; color: #d97706; }
        .option-precintos { border-top-color: #dc2626; color: #dc2626; }
        .option-stickers  { border-top-color: #7c3aed; color: #7c3aed; }
        .option-productos { border-top-color: #16a34a; color: #16a34a; }

        .option-cajas:hover     { box-shadow: 0 8px 24px rgba(37,99,235,.18); }
        .option-etiquetas:hover { box-shadow: 0 8px 24px rgba(217,119,6,.18); }
        .option-precintos:hover { box-shadow: 0 8px 24px rgba(220,38,38,.18); }
        .option-stickers:hover  { box-shadow: 0 8px 24px rgba(124,58,237,.18); }
        .option-productos:hover { box-shadow: 0 8px 24px rgba(22,163,74,.18); }

        /* Ícono dentro de la card */
        .option-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            background: currentColor;
            position: relative;
            flex-shrink: 0;
        }
        .option-icon-wrap::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #fff;
            opacity: .12;
            border-radius: inherit;
        }
        /* Emoji no hereda color — fuerza visibilidad */
        .option-icon-wrap span { position: relative; z-index: 1; }

        .option-body { text-align: center; }
        .option-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: .1px;
        }
        .option-desc {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 3px;
            line-height: 1.4;
        }

        /* Flecha CTA */
        .option-arrow {
            margin-top: .25rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            opacity: 0;
            transition: opacity .15s, transform .15s;
            transform: translateY(4px);
        }
        .option:hover .option-arrow {
            opacity: 1;
            transform: translateY(0);
        }

        /* Badge de número de orden */
        .option-num {
            position: absolute;
            top: 10px;
            left: 12px;
            font-family: var(--mono);
            font-size: 10px;
            font-weight: 700;
            color: currentColor;
            opacity: .35;
            letter-spacing: .5px;
        }

        /* Productos ocupa 2 columnas */
        .option.productos {
            grid-column: span 2;
            flex-direction: row;
            gap: 1.5rem;
            justify-content: flex-start;
            padding: 1.75rem 2rem;
            min-height: 130px;
        }
        .option.productos .option-body { text-align: left; flex: 1; }
        .option.productos .option-arrow { display: none; }
        .option.productos .option-num { top: 12px; left: 14px; }
        .option.productos .option-desc { font-size: 12px; }

        /* Chip de estado en card de productos */
        .option-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 700;
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            margin-top: 6px;
        }

        /* ── Separador de sección ── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.5rem 0 1.25rem;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
        }
        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Footer ── */
        .page-footer {
            background: var(--navy2);
            border-top: 1px solid rgba(255,255,255,.06);
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        .page-footer-left {
            font-size: 11px;
            color: #334155;
            font-family: var(--mono);
        }
        .page-footer-right {
            font-size: 11px;
            color: #334155;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .options {
                grid-template-columns: repeat(2, 1fr);
            }
            .option.productos {
                grid-column: span 2;
            }
        }
        @media (max-width: 600px) {
            .options {
                grid-template-columns: 1fr;
            }
            .option.productos {
                grid-column: span 1;
                flex-direction: column;
                align-items: center;
                min-height: 180px;
                justify-content: center;
            }
            .option.productos .option-body { text-align: center; }
            .info-strip { display: none; }
            .page-header { padding: 1rem; }
        }
    </style>
</head>

<body>

    {{-- ── Top bar ERP ── --}}
    <div class="erp-bar">
        <div class="erp-bar-left">
            <span class="erp-logo">DISTAN ERP</span>
            <div class="erp-sep"></div>
            <span class="erp-module">Registro de salidas</span>
        </div>
        <div class="erp-bar-right">
            <span class="erp-time" id="erpClock">--:--:--</span>
        </div>
    </div>

    {{-- ── Header ── --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-icon">📤</div>
            <div>
                <div class="page-header-title">Salida de producción</div>
                <div class="page-header-sub">Selecciona el material o producto que deseas retirar</div>
            </div>
        </div>
        <a href="{{ route('login') }}" class="btn-back">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10 12L6 8l4-4"/>
            </svg>
            Volver al inicio
        </a>
    </div>

    {{-- ── Info strip ── --}}
    <div class="info-strip">
        <div class="info-chip">
            <div class="info-chip-dot"></div>
            Sistema operativo
        </div>
        <div class="info-chip">
            <strong>Módulo:</strong> Producción &rsaquo; Salidas
        </div>
        <div class="info-chip">
            <strong>Registro:</strong> Todas las salidas quedan registradas en el kardex
        </div>
    </div>

    {{-- ── Contenido ── --}}
    <main class="container">

        <div class="section-head">
            <div class="section-head-bar"></div>
            <div>
                <div class="section-head-title">¿Qué deseas retirar?</div>
                <div class="section-head-sub">Cada salida genera un movimiento automático en el inventario</div>
            </div>
            <span class="section-head-count">5 opciones disponibles</span>
        </div>

        <div class="options">

            {{-- ── CAJAS ── --}}
            <a href="{{ route('production.outputs.cajas') }}" class="option option-cajas">
                <span class="option-num">01</span>
                <div class="option-icon-wrap">
                    <span>📦</span>
                </div>
                <div class="option-body">
                    <div class="option-name">Cajas</div>
                    <div class="option-desc">Registrar salida de cajas de embalaje</div>
                </div>
                <span class="option-arrow" style="color:#2563eb;">
                    Ir al registro
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 4l4 4-4 4"/>
                    </svg>
                </span>
            </a>

            {{-- ── ETIQUETAS ── --}}
            <a href="{{ route('production.outputs.etiquetas') }}" class="option option-etiquetas">
                <span class="option-num">02</span>
                <div class="option-icon-wrap">
                    <span>🔖</span>
                </div>
                <div class="option-body">
                    <div class="option-name">Etiquetas</div>
                    <div class="option-desc">Registrar salida de etiquetas de producto</div>
                </div>
                <span class="option-arrow" style="color:#d97706;">
                    Ir al registro
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 4l4 4-4 4"/>
                    </svg>
                </span>
            </a>

            {{-- ── PRECINTOS ── --}}
            <a href="{{ route('production.outputs.precintos') }}" class="option option-precintos">
                <span class="option-num">03</span>
                <div class="option-icon-wrap">
                    <span>🔒</span>
                </div>
                <div class="option-body">
                    <div class="option-name">Precintos</div>
                    <div class="option-desc">Registrar salida de precintos de seguridad</div>
                </div>
                <span class="option-arrow" style="color:#dc2626;">
                    Ir al registro
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 4l4 4-4 4"/>
                    </svg>
                </span>
            </a>

            {{-- ── STICKERS ── --}}
            <a href="{{ route('production.outputs.stickers') }}" class="option option-stickers">
                <span class="option-num">04</span>
                <div class="option-icon-wrap">
                    <span>🏷️</span>
                </div>
                <div class="option-body">
                    <div class="option-name">Stickers de tapa</div>
                    <div class="option-desc">Registrar salida de stickers adhesivos</div>
                </div>
                <span class="option-arrow" style="color:#7c3aed;">
                    Ir al registro
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 4l4 4-4 4"/>
                    </svg>
                </span>
            </a>

            {{-- ── PRODUCTOS (span 2) ── --}}
            <a href="#" class="option option-productos productos">
                <span class="option-num">05</span>
                <div class="option-icon-wrap" style="width:64px;height:64px;font-size:32px;flex-shrink:0;">
                    <span>🛒</span>
                </div>
                <div class="option-body">
                    <div class="option-name">Productos terminados</div>
                    <div class="option-desc">Busca o escanea un producto por código de barras para registrar su salida desde el almacén</div>
                    <div class="option-chip">
                        <svg width="10" height="10" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="12" height="12" rx="1"/>
                            <path d="M5 8h6M8 5v6"/>
                        </svg>
                        Scanner disponible
                    </div>
                </div>
                <svg style="margin-left:auto;color:#16a34a;flex-shrink:0;" width="24" height="24" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 4l4 4-4 4"/>
                </svg>
            </a>

        </div>

        {{-- ── Aviso operacional ── --}}
        <div class="section-divider">Información operacional</div>

        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:10px;
            margin-bottom:1rem;
        ">
            <div style="
                background:var(--surface);
                border:1px solid var(--border);
                border-left:4px solid var(--accent);
                border-radius:4px;
                padding:.85rem 1rem;
                display:flex;align-items:flex-start;gap:10px;
            ">
                <span style="font-size:18px;flex-shrink:0;margin-top:1px;">📋</span>
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--ink);margin-bottom:2px;">Registro automático</div>
                    <div style="font-size:11px;color:var(--muted);line-height:1.5;">Cada salida descuenta el stock en tiempo real y queda registrada en el kardex del producto.</div>
                </div>
            </div>
            <div style="
                background:var(--surface);
                border:1px solid var(--border);
                border-left:4px solid var(--warn);
                border-radius:4px;
                padding:.85rem 1rem;
                display:flex;align-items:flex-start;gap:10px;
            ">
                <span style="font-size:18px;flex-shrink:0;margin-top:1px;">⚠️</span>
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--ink);margin-bottom:2px;">Verifica la cantidad</div>
                    <div style="font-size:11px;color:var(--muted);line-height:1.5;">Ingresa la cantidad exacta retirada. Esta acción no se puede deshacer fácilmente.</div>
                </div>
            </div>
            <div style="
                background:var(--surface);
                border:1px solid var(--border);
                border-left:4px solid var(--ok);
                border-radius:4px;
                padding:.85rem 1rem;
                display:flex;align-items:flex-start;gap:10px;
            ">
                <span style="font-size:18px;flex-shrink:0;margin-top:1px;">🔍</span>
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--ink);margin-bottom:2px;">Trazabilidad completa</div>
                    <div style="font-size:11px;color:var(--muted);line-height:1.5;">Todas las salidas quedan vinculadas al usuario y fecha. Consulta el historial en cualquier momento.</div>
                </div>
            </div>
        </div>

    </main>

    {{-- ── Footer ── --}}
    <div class="page-footer">
        <span class="page-footer-left">DISTAN ERP · Sistema ERP · Producción › Salidas</span>
        <span class="page-footer-right">v2025.1</span>
    </div>

    <script>
        /* ── Reloj en top bar ── */
        function actualizarReloj() {
            var el = document.getElementById('erpClock');
            if (el) {
                el.textContent = new Date().toLocaleTimeString('es-PE');
            }
        }
        actualizarReloj();
        setInterval(actualizarReloj, 1000);
    </script>

</body>
</html>