@extends('layouts.app')
@section('content')
<style>
:root{--erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;--erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;--erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;--erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;--erp-warn:#b9690e;--font-ui:'Segoe UI',sans-serif;}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.grid-main{display:grid;grid-template-columns:1fr 240px;gap:14px;}
@media(max-width:800px){.grid-main{grid-template-columns:1fr;}}
.sec-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.sec-hdr{padding:.65rem 1rem;display:flex;align-items:center;gap:7px;border-bottom:1px solid var(--erp-border);background:#f4f6f9;}
.sec-hdr-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.sec-hdr-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.sec-body{padding:1rem;}
.field-grid{display:grid;gap:10px;}
.g-2{grid-template-columns:1fr 1fr;}
@media(max-width:600px){.g-2{grid-template-columns:1fr;}}
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.required-star{color:#c0312b;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}
.btn-row{display:flex;gap:8px;padding-top:.85rem;border-top:1px solid #f1f5f9;margin-top:.5rem;}
.btn-save{padding:8px 20px;background:var(--erp-accent);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;}
.btn-cancel{padding:8px 16px;background:#fff;color:var(--erp-ink-muted);border:1px solid var(--erp-border);border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;}
/* Selector de color visual */
.color-selector{display:flex;gap:8px;margin-top:4px;}
.color-option{flex:1;padding:10px 6px;border:2px solid var(--erp-border);border-radius:3px;text-align:center;cursor:pointer;font-size:12px;font-weight:700;transition:.15s;}
.color-option.selected-verde {border-color:#22c55e;background:#f0fdf4;color:#15803d;}
.color-option.selected-blanco{border-color:#94a3b8;background:#f8fafc;color:#475569;}
.color-option.selected-negro {border-color:#1e293b;background:#1e293b;color:#fff;}
.side-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.side-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.6rem 1rem;font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.side-body{padding:.85rem 1rem;}
.info-item{display:flex;align-items:flex-start;gap:7px;padding:6px 0;border-bottom:1px solid #f4f6f9;font-size:11px;color:var(--erp-ink-muted);line-height:1.5;}
.info-item:last-child{border:none;}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Nuevo precinto</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Inventario › Precintos › Nuevo</span>
</div>

<div class="body">
<div class="page-hdr">
    <div>
        <div class="page-title">Nuevo precinto</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px;">Registra un nuevo precinto en el inventario</div>
    </div>
</div>

@if($errors->any())
<div style="background:#fbe9e8;border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;margin-bottom:.85rem;font-size:12px;color:#c0312b;">
    <strong>⚠️ Errores:</strong>
    <ul style="margin:.4rem 0 0 1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('precintos.store') }}">
@csrf
<div class="grid-main">
<div>
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">1</div>
            <div class="sec-hdr-title">Identificación</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">Nombre <span class="required-star">*</span></label>
                    <input type="text" name="nombre" class="finput"
                           value="{{ old('nombre') }}"
                           placeholder="Ej: Precinto Seguridad 30cm" required>
                </div>
                <div class="field">
                    <label class="flabel">Color <span class="required-star">*</span></label>
                    <select name="color" class="fselect" required id="colorSelect" onchange="updateColorPreview()">
                        <option value="">Seleccionar color</option>
                        @foreach($colores as $c)
                            <option value="{{ $c }}" @selected(old('color')===$c)>
                                {{ match($c){ 'VERDE'=>'🟢 Verde','BLANCO'=>'⚪ Blanco','NEGRO'=>'⚫ Negro',default=>$c } }}
                            </option>
                        @endforeach
                    </select>
                    {{-- Preview visual --}}
                    <div class="color-selector" id="colorPreview">
                        <div class="color-option" id="prev-verde" onclick="selectColor('VERDE')">🟢<br>Verde</div>
                        <div class="color-option" id="prev-blanco" onclick="selectColor('BLANCO')">⚪<br>Blanco</div>
                        <div class="color-option" id="prev-negro" onclick="selectColor('NEGRO')">⚫<br>Negro</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-ok);">2</div>
            <div class="sec-hdr-title">Inventario</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">Stock inicial</label>
                    <input type="number" name="stock_inicial" class="finput"
                           value="{{ old('stock_inicial',0) }}" min="0" step="0.01"
                           style="font-size:16px;font-weight:700;text-align:center;font-family:'Consolas',monospace;color:var(--erp-ok);background:var(--erp-ok-bg);">
                    <span class="field-hint">Se registra como primera entrada</span>
                </div>
                <div class="field">
                    <label class="flabel">Stock mínimo <span class="required-star">*</span></label>
                    <input type="number" name="stock_minimo" class="finput"
                           value="{{ old('stock_minimo',0) }}" min="0" step="0.01"
                           style="font-size:16px;font-weight:700;text-align:center;font-family:'Consolas',monospace;color:var(--erp-warn);background:#fdf1e2;"
                           required>
                    <span class="field-hint">Umbral de alerta</span>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-row">
        <button type="submit" class="btn-save">💾 Guardar precinto</button>
        <a href="{{ route('precintos.index') }}" class="btn-cancel">✕ Cancelar</a>
    </div>
</div>
<div>
    <div class="side-card">
        <div class="side-hdr">Colores disponibles</div>
        <div class="side-body">
            <div class="info-item"><span style="font-size:16px;">🟢</span><div><strong>Verde</strong> — para mercados estándar o exportación general.</div></div>
            <div class="info-item"><span style="font-size:16px;">⚪</span><div><strong>Blanco</strong> — para líneas especiales o mercado local.</div></div>
            <div class="info-item"><span style="font-size:16px;">⚫</span><div><strong>Negro</strong> — para productos premium o mercados específicos.</div></div>
        </div>
    </div>
    <div class="side-card" style="border-color:#fde68a;background:#fffbeb;">
        <div class="side-hdr" style="background:#fef9c3;border-color:#fde68a;color:#b45309;">⚠️ Advertencias</div>
        <div class="side-body">
            <div class="info-item" style="color:#7c4b00;"><span>🎯</span><div>Verifica el <strong>color</strong> antes de guardar. Afecta la clasificación del inventario.</div></div>
            <div class="info-item" style="color:#7c4b00;"><span>📋</span><div>El stock solo se modifica desde el <strong>kardex</strong>. No editar manualmente.</div></div>
        </div>
    </div>
</div>
</div>
</form>
</div>
</div>

<script>
function selectColor(color) {
    document.getElementById('colorSelect').value = color;
    updateColorPreview();
}
function updateColorPreview() {
    var c = document.getElementById('colorSelect').value;
    document.getElementById('prev-verde').className  = 'color-option' + (c==='VERDE'  ? ' selected-verde'  : '');
    document.getElementById('prev-blanco').className = 'color-option' + (c==='BLANCO' ? ' selected-blanco' : '');
    document.getElementById('prev-negro').className  = 'color-option' + (c==='NEGRO'  ? ' selected-negro'  : '');
}
document.addEventListener('DOMContentLoaded', updateColorPreview);
</script>
@endsection