@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#eef1f5;
    --erp-surface:#ffffff;
    --erp-border:#dde2ea;
    --erp-ink:#1c2733;
    --erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;
    --erp-accent-dark:#0a4eb3;
    --erp-ok:#1c7c4d;
    --erp-ok-bg:#e8f5ee;
    --erp-warn:#b9690e;
    --erp-warn-bg:#fdf1e2;
    --erp-danger:#c0312b;
    --erp-danger-bg:#fbe9e8;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    padding:0;min-height:100vh;font-size:13px;
}

/* ── Top bar ── */
.erp-bar{
    background:#1e3a5f;height:38px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.erp-badge{
    background:#152d4d;color:#7eb8f7;
    font-size:11px;padding:3px 10px;border-radius:3px;
    font-family:var(--font-mono);letter-spacing:.5px;
}
.body{padding:1.1rem;}

/* ── Page header ── */
.page-hdr{
    display:flex;justify-content:space-between;
    align-items:flex-start;margin-bottom:1rem;
    flex-wrap:wrap;gap:8px;
}
.page-title{
    font-size:17px;font-weight:700;color:#0f172a;
    display:flex;align-items:center;gap:8px;
}
.page-title:before{
    content:"";width:4px;height:20px;
    background:var(--erp-ok);border-radius:2px;display:inline-block;
}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.breadcrumb{font-size:11px;color:#94a3b8;}

/* ── Layout grid ── */
.layout{display:grid;grid-template-columns:1fr 260px;gap:14px;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}

/* ── Progress strip ── */
.progress-strip{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:.85rem 1rem;
    margin-bottom:1rem;
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:10px;
}
.progress-info{display:flex;flex-direction:column;gap:2px;}
.progress-label{font-size:11px;color:var(--erp-ink-muted);font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.progress-nums{font-family:var(--font-mono);font-size:13px;font-weight:700;color:var(--erp-ink);}
.progress-bar-wrap{flex:1;min-width:200px;}
.progress-track{
    width:100%;height:8px;
    background:#f1f5f9;border-radius:99px;
    overflow:hidden;
}
.progress-fill{
    height:100%;border-radius:99px;
    background:linear-gradient(90deg,var(--erp-ok),#4ade80);
    transition:width .5s ease;
}
.progress-pct{
    font-family:var(--font-mono);font-size:18px;font-weight:800;
    color:var(--erp-ok);margin-left:12px;flex-shrink:0;
}

/* ── Buscador ── */
.search-bar{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:.75rem 1rem;
    margin-bottom:1rem;
    display:flex;align-items:center;gap:8px;
}
.search-icon{font-size:15px;color:#94a3b8;flex-shrink:0;}
#buscador{
    flex:1;border:none;outline:none;
    font-size:13px;color:var(--erp-ink);
    font-family:var(--font-ui);
    background:transparent;
}
#buscador::placeholder{color:#94a3b8;}
.search-count{
    font-size:11px;color:var(--erp-ink-muted);
    font-family:var(--font-mono);
    white-space:nowrap;
}

/* ── Tabla ── */
.table-card{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    overflow:hidden;
    margin-bottom:10px;
}
table{width:100%;border-collapse:collapse;font-size:12.5px;}
thead th{
    background:#f4f6f9;
    color:var(--erp-ink-muted);
    font-size:10.5px;font-weight:700;
    text-transform:uppercase;letter-spacing:.05em;
    padding:9px 12px;
    border-bottom:2px solid var(--erp-border);
    text-align:left;white-space:nowrap;
}
tbody tr.fila-producto{
    border-bottom:1px solid #f0f3f7;
    transition:background .1s;
}
tbody tr.fila-producto:last-child{border-bottom:none;}
tbody tr.fila-producto:hover{background:#f7fafc;}
tbody td{padding:9px 12px;vertical-align:middle;}

/* Nombre del producto */
.td-product{
    display:flex;flex-direction:column;gap:1px;
}
.td-product-name{font-size:13px;font-weight:600;color:var(--erp-ink);}
.td-product-sku{font-family:var(--font-mono);font-size:10px;color:#94a3b8;}

/* Stock sistema */
.td-stock-sis{
    font-family:var(--font-mono);font-size:13px;
    font-weight:700;color:var(--erp-ink-muted);
    text-align:center;
}

/* Input stock físico */
.input-fisico-wrap{display:flex;align-items:center;gap:6px;}
.input-fisico{
    width:90px;padding:7px 9px;
    border:1px solid var(--erp-border);
    border-radius:3px;font-size:13px;
    font-family:var(--font-mono);font-weight:700;
    text-align:center;color:var(--erp-ink);
    background:#fbfcfe;outline:none;
    transition:border-color .15s,box-shadow .15s,background .15s;
}
.input-fisico:focus{
    border-color:var(--erp-ok);
    box-shadow:0 0 0 2px rgba(28,124,77,.12);
    background:var(--erp-ok-bg);
}
.input-fisico:not(:placeholder-shown){
    border-color:#b7dfca;
    background:var(--erp-ok-bg);
    color:var(--erp-ok);
}

/* Indicador diff inline */
.diff-badge{
    display:inline-flex;align-items:center;gap:3px;
    font-size:10px;font-weight:700;padding:2px 6px;
    border-radius:3px;white-space:nowrap;
    font-family:var(--font-mono);
    opacity:0;transition:opacity .2s;
}
.diff-badge.visible{opacity:1;}
.diff-ok  {background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.diff-warn{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}
.diff-zero{background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;}

/* ── Panel lateral ── */
.side-col{display:flex;flex-direction:column;gap:10px;}
.side-card{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
}
.side-hdr{
    background:#f4f6f9;
    border-bottom:1px solid var(--erp-border);
    padding:.6rem 1rem;
    font-size:11px;font-weight:700;
    color:var(--erp-ink);
    text-transform:uppercase;letter-spacing:.06em;
}
.side-body{padding:.85rem 1rem;}

/* Resumen en tiempo real */
.stat-row{
    display:flex;justify-content:space-between;align-items:center;
    font-size:12px;padding:5px 0;
    border-bottom:1px solid #f4f6f9;
    color:var(--erp-ink-muted);
}
.stat-row:last-child{border:none;}
.stat-val{
    font-family:var(--font-mono);font-weight:700;
    color:var(--erp-ink);font-size:13px;
}

/* Textarea observaciones */
.obs-wrap{margin-bottom:10px;}
.obs-label{
    font-size:10px;font-weight:700;
    color:var(--erp-ink-muted);
    text-transform:uppercase;letter-spacing:.06em;
    display:block;margin-bottom:4px;
}
textarea[name="observaciones"]{
    width:100%;
    padding:9px;
    border:1px solid var(--erp-border);
    border-radius:3px;
    min-height:80px;
    font-size:12px;
    font-family:var(--font-ui);
    color:var(--erp-ink);
    background:#fbfcfe;
    resize:vertical;
    outline:none;
    transition:border-color .15s;
}
textarea[name="observaciones"]:focus{
    border-color:var(--erp-accent);
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}

/* Botón guardar */
.btn-guardar{
    width:100%;padding:10px 16px;
    background:var(--erp-ok);color:#fff;
    border:none;border-radius:3px;
    font-size:13px;font-weight:700;
    cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:6px;
    font-family:var(--font-ui);
    transition:background .15s,box-shadow .15s;
}
.btn-guardar:hover{
    background:#166534;
    box-shadow:0 4px 16px rgba(28,124,77,.25);
}

/* Btn volver */
.btn-back{
    display:inline-flex;align-items:center;gap:5px;
    padding:7px 14px;
    background:#fff;color:var(--erp-ink-muted);
    border:1px solid var(--erp-border);border-radius:3px;
    font-size:12px;font-weight:600;
    text-decoration:none;
    transition:background .15s;
}
.btn-back:hover{background:#f4f6f9;}

/* Flow instrucciones */
.flow-item{
    display:flex;align-items:flex-start;gap:8px;
    padding:6px 0;
    border-bottom:1px solid #f4f6f9;
    font-size:11px;color:var(--erp-ink-muted);
    line-height:1.5;
}
.flow-item:last-child{border:none;}
.flow-num{
    width:18px;height:18px;border-radius:50%;
    background:var(--erp-ok);color:#fff;
    font-size:10px;font-weight:700;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;margin-top:1px;
}

/* Warn card */
.warn-card{
    background:#fffbeb;
    border:1px solid #fde68a;
    border-left:4px solid #f59e0b;
    border-radius:4px;
}
.warn-card .side-hdr{
    background:#fef9c3;
    border-color:#fde68a;
    color:#b45309;
}
.warn-item{
    display:flex;align-items:flex-start;gap:7px;
    padding:6px 0;
    border-bottom:1px solid #fef9c3;
    font-size:11px;color:#7c4b00;
    line-height:1.5;
}
.warn-item:last-child{border:none;}
.warn-item strong{color:#b45309;}

/* Empty */
.empty-row td{
    padding:2rem;text-align:center;
    color:var(--erp-ink-muted);font-style:italic;
}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Captura de conteo físico</div>
    </div>
    <div class="erp-badge">{{ $conteo->codigo }}</div>
</div>

<div class="body">

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Captura — {{ $conteo->codigo }}</div>
        <div class="page-sub">
            Ingresa el stock físico contado · Los campos vacíos no se guardarán
        </div>
    </div>
    <div style="display:flex;gap:7px;align-items:center;flex-wrap:wrap;">
        <a href="{{ route('stockcount.historial') }}" class="btn-back">
            ← Volver al historial
        </a>
        <span class="breadcrumb">Inventario › Conteo físico › Captura</span>
    </div>
</div>

{{-- ── Barra de progreso ── --}}
@php
    $totalDet   = count($detalles);
    $contados   = 0; // se actualiza por JS en tiempo real
@endphp
<div class="progress-strip">
    <div class="progress-info">
        <span class="progress-label">Progreso de captura</span>
        <span class="progress-nums" id="progNums">0 / {{ $totalDet }} productos</span>
    </div>
    <div class="progress-bar-wrap">
        <div class="progress-track">
            <div class="progress-fill" id="progFill" style="width:0%;"></div>
        </div>
    </div>
    <span class="progress-pct" id="progPct">0%</span>
</div>

<form method="POST" action="{{ route('stockcount.guardar', $conteo->id) }}"
      id="formCaptura">
@csrf

<div class="layout">

{{-- ── Columna izquierda: tabla ── --}}
<div>

    {{-- Buscador ── --}}
    <div class="search-bar">
        <span class="search-icon">🔍</span>
        <input type="text"
               id="buscador"
               placeholder="Buscar producto por nombre...">
        <span class="search-count" id="searchCount">
            {{ $totalDet }} productos
        </span>
    </div>

    {{-- Tabla ── --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align:center;">Stock sistema</th>
                    <th style="text-align:center;">Stock físico contado</th>
                    <th style="text-align:center;">Diferencia</th>
                </tr>
            </thead>
            <tbody id="tablaProductos">

            @forelse($detalles as $detalle)
            <tr class="fila-producto"
                data-nombre="{{ strtolower($detalle->product->nombre) }}"
                data-sis="{{ $detalle->stock_sistema }}">

                <td>
                    <div class="td-product">
                        <span class="td-product-name">
                            {{ $detalle->product->nombre }}
                        </span>
                        @if($detalle->product->sku)
                        <span class="td-product-sku">
                            SKU: {{ $detalle->product->sku }}
                        </span>
                        @endif
                    </div>
                </td>

                <td>
                    <div class="td-stock-sis">
                        {{ $detalle->stock_sistema }}
                    </div>
                </td>

                <td style="text-align:center;">
                    <div class="input-fisico-wrap" style="justify-content:center;">
                        <input
                            type="number"
                            name="stock_fisico[{{ $detalle->id }}]"
                            min="0"
                            class="input-fisico"
                            placeholder="—"
                            data-sis="{{ $detalle->stock_sistema }}"
                            oninput="calcDiff(this);updateProgress();">
                    </div>
                </td>

                <td style="text-align:center;">
                    <span class="diff-badge" id="diff-{{ $detalle->id }}">—</span>
                </td>

            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="4">No hay productos en este conteo.</td>
            </tr>
            @endforelse

            </tbody>
        </table>
    </div>

</div>

{{-- ── Columna derecha: panel ── --}}
<div class="side-col">

    {{-- Resumen en tiempo real --}}
    <div class="side-card">
        <div class="side-hdr">Resumen en tiempo real</div>
        <div class="side-body">
            <div class="stat-row">
                <span>Total productos</span>
                <span class="stat-val">{{ $totalDet }}</span>
            </div>
            <div class="stat-row">
                <span>Contados</span>
                <span class="stat-val" id="statContados" style="color:var(--erp-ok);">0</span>
            </div>
            <div class="stat-row">
                <span>Sin contar</span>
                <span class="stat-val" id="statSinContar" style="color:var(--erp-ink-muted);">{{ $totalDet }}</span>
            </div>
            <div class="stat-row">
                <span>Con diferencia</span>
                <span class="stat-val" id="statDiff" style="color:var(--erp-danger);">0</span>
            </div>
            <div class="stat-row">
                <span>Sin diferencia</span>
                <span class="stat-val" id="statOk" style="color:var(--erp-ok);">0</span>
            </div>
        </div>
    </div>

    {{-- Observaciones --}}
    <div class="side-card">
        <div class="side-hdr">Observaciones</div>
        <div class="side-body">
            <label class="obs-label">Notas del conteo</label>
            <textarea name="observaciones"
                      placeholder="Observaciones generales (opcional)..."></textarea>
            <div style="font-size:10px;color:#94a3b8;margin-top:4px;">
                Solo visible internamente
            </div>
        </div>
    </div>

    {{-- Botón guardar --}}
    <button type="submit" class="btn-guardar" form="formCaptura">
        💾 Guardar conteo
    </button>

    {{-- Cómo funciona --}}
    <div class="side-card">
        <div class="side-hdr">Cómo funciona</div>
        <div class="side-body">
            <div class="flow-item">
                <div class="flow-num">1</div>
                <div>Cuenta físicamente cada producto en el almacén.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">2</div>
                <div>Ingresa la cantidad real en el campo <strong>Stock físico</strong>.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">3</div>
                <div>La diferencia se calcula automáticamente al escribir.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">4</div>
                <div>Guarda cuando termines. Los campos vacíos no se registran.</div>
            </div>
        </div>
    </div>

    {{-- Advertencias --}}
    <div class="warn-card side-card">
        <div class="side-hdr">⚠️ Advertencias</div>
        <div class="side-body">
            <div class="warn-item">
                <span>🎯</span>
                <div><strong>Sé exacto</strong> — Ingresa la cantidad que ves físicamente, sin redondear.</div>
            </div>
            <div class="warn-item">
                <span>📋</span>
                <div>Los campos vacíos <strong>no se guardan</strong>. Solo ingresa los que contaste.</div>
            </div>
            <div class="warn-item">
                <span>🔒</span>
                <div>Al <strong>finalizar</strong> el conteo desde el historial quedará bloqueado.</div>
            </div>
        </div>
    </div>

</div>

</div>
</form>

</div>
</div>

<script>
/* ── Calcular diferencia inline ── */
function calcDiff(input) {
    var sis    = parseFloat(input.dataset.sis) || 0;
    var fisico = input.value !== '' ? parseFloat(input.value) : null;
    var fila   = input.closest('tr.fila-producto');
    var badge  = fila ? fila.querySelector('.diff-badge') : null;

    if (!badge) return;

    if (fisico === null || isNaN(fisico)) {
        badge.textContent = '—';
        badge.className   = 'diff-badge';
        return;
    }

    var diff = fisico - sis;

    if (diff === 0) {
        badge.textContent = '✓ Igual';
        badge.className   = 'diff-badge diff-zero visible';
    } else if (diff > 0) {
        badge.textContent = '+' + diff;
        badge.className   = 'diff-badge diff-ok visible';
    } else {
        badge.textContent = diff;
        badge.className   = 'diff-badge diff-warn visible';
    }
}

/* ── Actualizar progreso y resumen ── */
function updateProgress() {
    var inputs   = document.querySelectorAll('.input-fisico');
    var total    = inputs.length;
    var contados = 0;
    var conDiff  = 0;
    var sinDiff  = 0;

    inputs.forEach(function(inp) {
        if (inp.value !== '' && !isNaN(inp.value)) {
            contados++;
            var sis    = parseFloat(inp.dataset.sis) || 0;
            var fisico = parseFloat(inp.value);
            if (fisico !== sis) {
                conDiff++;
            } else {
                sinDiff++;
            }
        }
    });

    var pct = total > 0 ? Math.round(contados / total * 100) : 0;

    /* Barra de progreso */
    var fill = document.getElementById('progFill');
    var pctEl = document.getElementById('progPct');
    var nums  = document.getElementById('progNums');
    if (fill)  fill.style.width  = pct + '%';
    if (pctEl) pctEl.textContent = pct + '%';
    if (nums)  nums.textContent  = contados + ' / ' + total + ' productos';

    /* Stats */
    var sc = document.getElementById('statContados');
    var ss = document.getElementById('statSinContar');
    var sd = document.getElementById('statDiff');
    var so = document.getElementById('statOk');
    if (sc) sc.textContent = contados;
    if (ss) ss.textContent = total - contados;
    if (sd) sd.textContent = conDiff;
    if (so) so.textContent = sinDiff;
}

/* ── Buscador (JS original intacto + contador) ── */
document.getElementById('buscador').addEventListener('input', function() {
    var q       = this.value.toLowerCase();
    var visible = 0;
    document.querySelectorAll('.fila-producto').forEach(function(fila) {
        var show = fila.dataset.nombre.includes(q);
        fila.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    var cnt = document.getElementById('searchCount');
    if (cnt) cnt.textContent = visible + ' productos';
});

/* Init */
document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
});
</script>

@endsection