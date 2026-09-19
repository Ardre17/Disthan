<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida de Cajas | DISTAN ERP</title>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #1e3a5f;
            --navy2:   #0f2240;
            --surface: #ffffff;
            --bg:      #eef1f5;
            --border:  #dde2ea;
            --ink:     #1c2733;
            --muted:   #5b6b7d;
            --accent:  #2563eb;
            --ok:      #16a34a;
            --ok-bg:   #f0fdf4;
            --warn:    #d97706;
            --danger:  #dc2626;
            --danger-bg: #fef2f2;
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

        /* ── Top bar ── */
        .erp-bar {
            background: var(--navy);
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .erp-bar-left { display: flex; align-items: center; gap: 10px; }
        .erp-logo { color: #fff; font-size: 12px; font-weight: 800; letter-spacing: .4px; }
        .erp-sep  { width: 1px; height: 16px; background: rgba(255,255,255,.15); }
        .erp-module { color: #7eb8f7; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; }
        .erp-clock  { color: #5a8abf; font-size: 11px; font-family: var(--mono); }

        /* ── Page header ── */
        .page-header {
            background: var(--navy2);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            border-bottom: 3px solid var(--accent);
            flex-shrink: 0;
        }
        .page-header-left { display: flex; align-items: center; gap: 12px; }
        .page-header-icon {
            width: 42px; height: 42px;
            background: rgba(37,99,235,.18);
            border: 1px solid rgba(37,99,235,.35);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .page-header-title { color: #fff; font-size: 16px; font-weight: 800; }
        .page-header-sub   { color: #7eb8f7; font-size: 11px; margin-top: 2px; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 4px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: #cbd5e1; text-decoration: none;
            font-size: 12px; font-weight: 600;
            transition: background .15s; white-space: nowrap;
        }
        .btn-back:hover { background: rgba(255,255,255,.14); color: #fff; }

        /* ── Alertas ── */
        .alert-ok {
            background: var(--ok-bg); border: 1px solid #bbf7d0;
            border-left: 4px solid var(--ok); border-radius: 4px;
            padding: 10px 14px; font-size: 12px; font-weight: 600;
            color: #166534; display: flex; align-items: center; gap: 8px;
            margin-bottom: 1rem;
        }
        .alert-err {
            background: var(--danger-bg); border: 1px solid #fca5a5;
            border-left: 4px solid var(--danger); border-radius: 4px;
            padding: 10px 14px; font-size: 12px;
            color: #991b1b; margin-bottom: 1rem;
        }
        .alert-err ul { margin: .4rem 0 0 1.1rem; }
        .alert-err li { font-size: 11px; margin-bottom: 2px; }

        /* ── Container ── */
        .container {
            width: min(1140px, calc(100% - 40px));
            margin: 1.5rem auto;
            flex: 1;
        }

        /* ── Section heading ── */
        .sec-head {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 1.1rem;
        }
        .sec-head-bar {
            width: 4px; height: 20px;
            background: var(--accent); border-radius: 2px; flex-shrink: 0;
        }
        .sec-head-title { font-size: 14px; font-weight: 700; color: var(--ink); }
        .sec-head-sub   { font-size: 11px; color: var(--muted); margin-top: 1px; }
        .sec-head-count {
            margin-left: auto; font-size: 11px; color: var(--muted);
            font-family: var(--mono); background: var(--surface);
            border: 1px solid var(--border); padding: 2px 10px;
            border-radius: 99px;
        }

        /* ── Grid de cajas ── */
        .boxes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 14px;
        }

        /* ── Card de caja ── */
        .box-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-top: 3px solid var(--accent);
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow .15s, border-color .15s;
        }
        .box-card:hover {
            border-color: #c2cbd8;
            box-shadow: 0 4px 16px rgba(15,23,42,.1);
        }
        .box-card.agotada { border-top-color: var(--danger); }

        /* Header de la card */
        .box-card-header {
            padding: .85rem 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f9fafb;
        }
        .box-card-icon {
            width: 48px; height: 48px;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; flex-shrink: 0;
        }
        .box-card.agotada .box-card-icon {
            background: var(--danger-bg);
            border-color: #fca5a5;
        }
        .box-card-info { flex: 1; min-width: 0; }
        .box-card-name {
            font-size: 14px; font-weight: 800; color: var(--ink);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .box-card-type {
            margin-top: 2px;
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 700; padding: 2px 8px;
            border-radius: 3px;
        }
        .type-con-logo { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .type-sin-logo { background: #f1f5f9; color: var(--muted);  border: 1px solid var(--border); }

        /* Stock block */
        .stock-block {
            padding: .75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            border-bottom: 1px solid var(--border);
        }
        .stock-block-label { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; font-weight: 600; }
        .stock-block-num   {
            font-family: var(--mono);
            font-size: 26px; font-weight: 800; line-height: 1;
        }
        .stock-block-unit  { font-size: 10px; color: var(--muted); margin-top: 1px; }
        .stock-ok   { color: var(--ok); }
        .stock-warn { color: var(--warn); }
        .stock-zero { color: var(--danger); }

        /* Barra de stock */
        .stock-bar-wrap { padding: 0 1rem .65rem; }
        .stock-bar-track {
            width: 100%; height: 5px;
            background: #f1f5f9; border-radius: 99px; overflow: hidden;
        }
        .stock-bar-fill { height: 100%; border-radius: 99px; transition: width .4s; }

        /* Form */
        .box-form { padding: .85rem 1rem; display: flex; flex-direction: column; gap: .65rem; flex: 1; }
        .field { display: flex; flex-direction: column; gap: 4px; }
        .field-label {
            font-size: 10px; font-weight: 700; color: var(--muted);
            text-transform: uppercase; letter-spacing: .06em;
            display: flex; align-items: center; gap: 4px;
        }
        .field-label .required { color: var(--danger); }
        .field-label .optional { color: #94a3b8; font-weight: 400; font-size: 9px; text-transform: none; letter-spacing: 0; }
        .form-control {
            width: 100%; padding: 9px 11px;
            border: 1px solid var(--border); border-radius: 4px;
            background: #fbfcfe; color: var(--ink);
            font-size: 13px; font-family: var(--font); outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(37,99,235,.12);
            background: #fff;
        }
        .form-control.cantidad-input {
            font-family: var(--mono);
            font-size: 20px; font-weight: 800; text-align: center;
            padding: 12px;
        }
        .form-control.cantidad-input:focus { border-color: var(--accent); }

        /* Preview de cantidad */
        .cantidad-preview {
            display: none;
            font-size: 11px; color: var(--muted);
            background: #f8fafc; border: 1px solid var(--border);
            border-radius: 3px; padding: 5px 9px;
            text-align: center;
        }
        .cantidad-preview.visible { display: block; }
        .cantidad-preview strong { color: var(--ink); }

        /* Botón submit */
        .btn-submit {
            width: 100%;
            padding: 11px;
            background: var(--accent); color: #fff;
            border: none; border-radius: 4px;
            font-size: 13px; font-weight: 700;
            cursor: pointer; font-family: var(--font);
            display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: background .15s, transform .1s, box-shadow .15s;
            margin-top: auto;
        }
        .btn-submit:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 14px rgba(37,99,235,.3);
        }
        .btn-submit:active { transform: scale(.99); }

        /* Sin stock */
        .no-stock {
            margin: .75rem 1rem 1rem;
            padding: 10px 12px;
            background: var(--danger-bg);
            border: 1px solid #fca5a5;
            border-radius: 4px;
            text-align: center;
            font-size: 12px; font-weight: 700; color: #991b1b;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }

        /* Empty state */
        .empty-state {
            background: var(--surface);
            border: 1px dashed var(--border);
            border-radius: 6px;
            padding: 3rem;
            text-align: center;
            color: var(--muted);
        }
        .empty-state h3 { font-size: 15px; color: var(--ink); margin: .5rem 0 .35rem; }

        /* Footer */
        .page-footer {
            background: var(--navy2);
            border-top: 1px solid rgba(255,255,255,.06);
            padding: .65rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 6px;
            flex-shrink: 0;
        }
        .page-footer-l { font-size: 11px; color: #334155; font-family: var(--mono); }
        .page-footer-r { font-size: 11px; color: #334155; }

        /* Responsive */
        @media (max-width: 750px) {
            .boxes { grid-template-columns: 1fr; }
            .container { width: calc(100% - 24px); }
        }
        @media (max-width: 500px) {
            .page-header { flex-direction: column; align-items: flex-start; }
            .btn-back { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>

{{-- ── Top bar ERP ── --}}
<div class="erp-bar">
    <div class="erp-bar-left">
        <span class="erp-logo">DISTAN ERP</span>
        <div class="erp-sep"></div>
        <span class="erp-module">Producción › Salida de cajas</span>
    </div>
    <span class="erp-clock" id="erpClock">--:--:--</span>
</div>

{{-- ── Page header ── --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-icon">📦</div>
        <div>
            <div class="page-header-title">Salida de cajas</div>
            <div class="page-header-sub">Registra la cantidad de cajas retiradas para producción</div>
        </div>
    </div>
    <a href="{{ route('production.outputs') }}" class="btn-back">
        ← Volver a salidas
    </a>
</div>

{{-- ── Contenido ── --}}
<main class="container">

    {{-- Alertas --}}
    @if(session('success'))
    <div class="alert-ok">✅ {{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert-err">
        <strong>⚠️ No se pudo registrar la salida:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($cajas->count())

    {{-- Section heading --}}
    <div class="sec-head">
        <div class="sec-head-bar"></div>
        <div>
            <div class="sec-head-title">Cajas disponibles</div>
            <div class="sec-head-sub">Ingresa la cantidad a retirar y el nombre del responsable</div>
        </div>
        <span class="sec-head-count">{{ $cajas->count() }} tipo{{ $cajas->count() !== 1 ? 's' : '' }}</span>
    </div>

    <div class="boxes">

        @foreach($cajas as $caja)
        @php
            $stock    = $caja->stock_actual;
            $agotada  = $stock <= 0;
            $stockMin = $caja->stock_minimo ?? 0;
            $pctStock = $stockMin > 0
                ? min(100, round($stock / max($stock, $stockMin * 3) * 100))
                : ($stock > 0 ? 100 : 0);
            $stockColorClass = $agotada ? 'stock-zero' : ($stock <= $stockMin ? 'stock-warn' : 'stock-ok');
            $barColor        = $agotada ? '#ef4444'   : ($stock <= $stockMin ? '#f59e0b'   : '#22c55e');
            $tipoClass       = $caja->tipo === 'CON_LOGO' ? 'type-con-logo' : 'type-sin-logo';
            $tipoLabel       = $caja->tipo === 'CON_LOGO' ? '✦ Con logo' : 'Sin logo';
        @endphp

        <div class="box-card {{ $agotada ? 'agotada' : '' }}">

            {{-- Header card --}}
            <div class="box-card-header">
                <div class="box-card-icon">📦</div>
                <div class="box-card-info">
                    <div class="box-card-name">{{ $caja->nombre }}</div>
                    <span class="box-card-type {{ $tipoClass }}">{{ $tipoLabel }}</span>
                </div>
            </div>

            {{-- Stock --}}
            <div class="stock-block">
                <div>
                    <div class="stock-block-label">Stock disponible</div>
                    <div class="stock-block-num {{ $stockColorClass }}">
                        {{ number_format($stock, 0) }}
                    </div>
                    <div class="stock-block-unit">unidades</div>
                </div>
                @if(!$agotada && $stockMin > 0)
                <div style="text-align:right;">
                    <div class="stock-block-label">Mínimo</div>
                    <div style="font-family:var(--mono);font-size:14px;font-weight:700;color:var(--muted);">
                        {{ number_format($stockMin, 0) }}
                    </div>
                </div>
                @endif
            </div>

            {{-- Barra de stock --}}
            <div class="stock-bar-wrap">
                <div class="stock-bar-track">
                    <div class="stock-bar-fill"
                         style="width:{{ $pctStock }}%;background:{{ $barColor }};"></div>
                </div>
            </div>

            @if(!$agotada)

            {{-- Formulario --}}
            <form
                action="{{ route('production.outputs.cajas.salida', $caja) }}"
                method="POST"
                class="box-form"
                onsubmit="return confirmarSalida(this, '{{ addslashes($caja->nombre) }}')"
            >
                @csrf

                {{-- Cantidad --}}
                <div class="field">
                    <label class="field-label" for="cantidad-{{ $caja->id }}">
                        Cantidad a retirar <span class="required">*</span>
                    </label>
                    <input
                        id="cantidad-{{ $caja->id }}"
                        type="number"
                        name="cantidad"
                        class="form-control cantidad-input"
                        min="1"
                        max="{{ floor($stock) }}"
                        step="1"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        placeholder="0"
                        required
                        oninput="mostrarPreview(this, {{ $stock }}, 'preview-{{ $caja->id }}')"
                    >
                    <div class="cantidad-preview" id="preview-{{ $caja->id }}"></div>
                </div>

                {{-- Responsable --}}
                <div class="field">
                    <label class="field-label" for="responsable-{{ $caja->id }}">
                        Responsable <span class="required">*</span>
                    </label>
                    <input
                        id="responsable-{{ $caja->id }}"
                        type="text"
                        name="responsable"
                        class="form-control"
                        maxlength="100"
                        placeholder="Nombre de quien retira"
                        required
                    >
                </div>

                {{-- Observación --}}
                <div class="field">
                    <label class="field-label" for="observacion-{{ $caja->id }}">
                        Observación
                        <span class="optional">(opcional)</span>
                    </label>
                    <input
                        id="observacion-{{ $caja->id }}"
                        type="text"
                        name="observacion"
                        class="form-control"
                        maxlength="255"
                        placeholder="Ej: Producción pedido #2025-001"
                    >
                </div>

                <button type="submit" class="btn-submit">
                    📤 Registrar salida
                </button>

            </form>

            @else

            <div class="no-stock">
                🔴 Sin stock disponible — solicita reposición
            </div>

            @endif
        </div>

        @endforeach
    </div>

    @else

    <div class="empty-state">
        <div style="font-size:44px;margin-bottom:8px;">📦</div>
        <h3>No hay cajas disponibles</h3>
        <p style="font-size:12px;">No existen cajas activas registradas en el inventario.</p>
    </div>

    @endif

</main>

{{-- ── Footer ── --}}
<div class="page-footer">
    <span class="page-footer-l">DISTAN ERP · Producción › Salida de cajas</span>
    <span class="page-footer-r">v2025.1</span>
</div>

<script>
/* ── Reloj ── */
function actualizarReloj() {
    var el = document.getElementById('erpClock');
    if (el) el.textContent = new Date().toLocaleTimeString('es-PE');
}
actualizarReloj();
setInterval(actualizarReloj, 1000);

/* ── Preview de cantidad en tiempo real ── */
function mostrarPreview(input, stockActual, previewId) {
    var preview = document.getElementById(previewId);
    var val     = parseInt(input.value);

    if (!preview) return;

    if (isNaN(val) || val <= 0) {
        preview.className = 'cantidad-preview';
        preview.innerHTML = '';
        return;
    }

    var restante = stockActual - val;
    var valido   = val <= stockActual;

    if (!valido) {
        preview.className = 'cantidad-preview visible';
        preview.innerHTML = '⚠️ Supera el stock disponible (' + stockActual + ')';
        preview.style.color = '#991b1b';
        preview.style.background = '#fef2f2';
        preview.style.borderColor = '#fca5a5';
        input.style.borderColor = '#dc2626';
        return;
    }

    input.style.borderColor = '#2563eb';
    preview.className = 'cantidad-preview visible';
    preview.style.color   = restante <= 0 ? '#991b1b' : '#1c2733';
    preview.style.background = restante <= 0 ? '#fef2f2' : '#f8fafc';
    preview.style.borderColor = restante <= 0 ? '#fca5a5' : '#dde2ea';
    preview.innerHTML =
        'Retiras <strong>' + val + '</strong> · ' +
        'Queda en stock: <strong style="color:' +
        (restante <= 0 ? '#dc2626' : (restante < 10 ? '#d97706' : '#16a34a')) +
        ';">' + restante + '</strong>';
}

/* ── Confirmación antes de enviar ── */
function confirmarSalida(form, nombre) {
    var cantidadInput = form.querySelector('[name="cantidad"]');
    var cantidad      = parseInt(cantidadInput ? cantidadInput.value : 0);

    if (isNaN(cantidad) || cantidad <= 0) return false;

    return confirm(
        '¿Confirmas registrar la salida?\n\n' +
        '📦 Caja: ' + nombre + '\n' +
        '🔢 Cantidad: ' + cantidad + ' unidades\n\n' +
        'Esta acción descontará del inventario.'
    );
}
</script>

</body>
</html>