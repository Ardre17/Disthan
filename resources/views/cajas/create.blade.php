@extends('layouts.app')
@section('content')

<style>
:root{--erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;--erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;--erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;--erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;--erp-warn:#b9690e;--font-ui:'Segoe UI',sans-serif;}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}
#loadingScreen{position:fixed;inset:0;background:#1e3a5f;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;z-index:9999;transition:opacity .5s ease;}
#loadingScreen.hidden{opacity:0;pointer-events:none;}
.box-anim{font-size:72px;animation:boxBounce 1s ease infinite;}
@keyframes boxBounce{0%,100%{transform:translateY(0) scale(1);}50%{transform:translateY(-18px) scale(1.1);}}
.loading-text{color:#7eb8f7;font-size:14px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;}
.loading-bar-bg{width:180px;height:4px;background:#334155;border-radius:99px;overflow:hidden;}
.loading-bar-fill{height:100%;background:#7eb8f7;border-radius:99px;animation:loadBar 1.2s ease infinite;}
@keyframes loadBar{0%{width:0%;}100%{width:100%;}}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.grid-main{display:grid;grid-template-columns:1fr 250px;gap:14px;}
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
/* Selector tipo visual */
.tipo-selector{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:4px;}
.tipo-option{
    padding:16px 8px;border:2px solid var(--erp-border);border-radius:4px;
    text-align:center;cursor:pointer;transition:.15s;
    background:#fff;
}
.tipo-option .tipo-icon{font-size:28px;display:block;margin-bottom:6px;}
.tipo-option .tipo-label{font-size:12px;font-weight:700;color:var(--erp-ink-muted);}
.tipo-option .tipo-desc{font-size:10px;color:#94a3b8;margin-top:2px;}
.tipo-option.selected-logo{border-color:#7c3aed;background:#f5f3ff;}
.tipo-option.selected-logo .tipo-label{color:#7c3aed;}
.tipo-option.selected-sin {border-color:#0ea5e9;background:#f0f9ff;}
.tipo-option.selected-sin .tipo-label{color:#0369a1;}
.side-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.side-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.6rem 1rem;font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.side-body{padding:.85rem 1rem;}
.info-item{display:flex;align-items:flex-start;gap:7px;padding:6px 0;border-bottom:1px solid #f4f6f9;font-size:11px;color:var(--erp-ink-muted);line-height:1.5;}
.info-item:last-child{border:none;}
</style>

<div id="loadingScreen">
    <div class="box-anim">📦</div>
    <div class="loading-text">Cargando...</div>
    <div class="loading-bar-bg"><div class="loading-bar-fill"></div></div>
</div>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Nueva caja</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Inventario › Cajas › Nueva</span>
</div>

<div class="body">
<div class="page-hdr">
    <div>
        <div class="page-title">Nueva caja</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px;">Registra un nuevo tipo de caja en el inventario</div>
    </div>
</div>

@if($errors->any())
<div style="background:#fbe9e8;border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;margin-bottom:.85rem;font-size:12px;color:#c0312b;">
    <strong>⚠️ Errores:</strong>
    <ul style="margin:.4rem 0 0 1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('cajas.store') }}">
@csrf
<div class="grid-main">
<div>
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">1</div>
            <div class="sec-hdr-title">Identificación</div>
        </div>
        <div class="sec-body">
            <div class="field" style="margin-bottom:10px;">
                <label class="flabel">Nombre <span class="required-star">*</span></label>
                <input type="text" name="nombre" class="finput"
                       value="{{ old('nombre') }}"
                       placeholder="Ej: Caja grande 60x40x30" required>
            </div>
            <div class="field">
                <label class="flabel">Tipo de caja <span class="required-star">*</span></label>
                <select name="tipo" class="fselect" id="tipoSelect"
                        onchange="updateTipoPreview()" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="CON_LOGO"  @selected(old('tipo')==='CON_LOGO')>🏷️ Con logo</option>
                    <option value="SIN_LOGO"  @selected(old('tipo')==='SIN_LOGO')>📫 Sin logo</option>
                </select>
                <div class="tipo-selector">
                    <div class="tipo-option {{ old('tipo')==='CON_LOGO' ? 'selected-logo' : '' }}"
                         id="opt-logo" onclick="selectTipo('CON_LOGO')">
                        <span class="tipo-icon">🏷️📦</span>
                        <div class="tipo-label">Con logo</div>
                        <div class="tipo-desc">Incluye logotipo impreso</div>
                    </div>
                    <div class="tipo-option {{ old('tipo')==='SIN_LOGO' ? 'selected-sin' : '' }}"
                         id="opt-sin" onclick="selectTipo('SIN_LOGO')">
                        <span class="tipo-icon">📦</span>
                        <div class="tipo-label">Sin logo</div>
                        <div class="tipo-desc">Caja genérica / neutra</div>
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
                           value="{{ old('stock_inicial',0) }}" min="0" step="1"
                           style="font-size:16px;font-weight:700;text-align:center;font-family:'Consolas',monospace;color:var(--erp-ok);background:var(--erp-ok-bg);">
                    <span class="field-hint">Se registra como primera entrada</span>
                </div>
                <div class="field">
                    <label class="flabel">Stock mínimo <span class="required-star">*</span></label>
                    <input type="number" name="stock_minimo" class="finput"
                           value="{{ old('stock_minimo',0) }}" min="0" step="1"
                           style="font-size:16px;font-weight:700;text-align:center;font-family:'Consolas',monospace;color:var(--erp-warn);background:#fdf1e2;"
                           required>
                    <span class="field-hint">Umbral de alerta de reposición</span>
                </div>
            </div>
        </div>
    </div>

    <div class="btn-row">
        <button type="submit" class="btn-save">📦 Guardar caja</button>
        <a href="{{ route('cajas.index') }}" class="btn-cancel">✕ Cancelar</a>
    </div>
</div>

<div>
    <div class="side-card">
        <div class="side-hdr">Tipos de caja</div>
        <div class="side-body">
            <div class="info-item">
                <span style="font-size:20px;">🏷️📦</span>
                <div><strong style="color:#7c3aed;">Con logo</strong><br>Caja con el logotipo de la empresa impreso. Para despachos a clientes finales o exportación con marca.</div>
            </div>
            <div class="info-item">
                <span style="font-size:20px;">📦</span>
                <div><strong style="color:#0369a1;">Sin logo</strong><br>Caja genérica o neutra. Para almacenamiento interno, muestras o despachos sin identificación de marca.</div>
            </div>
        </div>
    </div>
    <div class="side-card" style="border-color:#fde68a;background:#fffbeb;">
        <div class="side-hdr" style="background:#fef9c3;border-color:#fde68a;color:#b45309;">⚠️ Advertencias</div>
        <div class="side-body">
            <div class="info-item" style="color:#7c4b00;">
                <span>🎯</span>
                <div>Verifica el <strong>tipo</strong> antes de guardar. Afecta cómo se clasifica en despachos.</div>
            </div>
            <div class="info-item" style="color:#7c4b00;">
                <span>📋</span>
                <div>El stock solo se modifica desde el <strong>kardex</strong>. No editar manualmente.</div>
            </div>
        </div>
    </div>
</div>
</div>
</form>
</div>
</div>

<script>
window.addEventListener('load', function(){
    var s=document.getElementById('loadingScreen');
    setTimeout(function(){ s.classList.add('hidden'); setTimeout(function(){ s.style.display='none'; },500); },700);
});
function selectTipo(tipo){
    document.getElementById('tipoSelect').value = tipo;
    updateTipoPreview();
}
function updateTipoPreview(){
    var t = document.getElementById('tipoSelect').value;
    document.getElementById('opt-logo').className = 'tipo-option' + (t==='CON_LOGO' ? ' selected-logo' : '');
    document.getElementById('opt-sin').className  = 'tipo-option' + (t==='SIN_LOGO'  ? ' selected-sin'  : '');
}
document.addEventListener('DOMContentLoaded', updateTipoPreview);
</script>
@endsection