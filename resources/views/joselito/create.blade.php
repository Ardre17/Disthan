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
.grid-main{display:grid;grid-template-columns:1fr 260px;gap:14px;}
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
.finput,.fselect,.ftarea{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus,.ftarea:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.ftarea{resize:vertical;min-height:80px;}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}
.finput-cajas{padding:10px;border:1px solid var(--erp-border);border-radius:3px;font-size:20px;font-weight:800;text-align:center;font-family:'Consolas',monospace;color:var(--erp-ok);background:var(--erp-ok-bg);outline:none;width:100%;transition:border-color .15s;}
.finput-cajas:focus{border-color:var(--erp-ok);box-shadow:0 0 0 2px rgba(28,124,77,.1);}
.btn-row{display:flex;gap:8px;padding-top:.85rem;border-top:1px solid #f1f5f9;margin-top:.5rem;}
.btn-save{padding:9px 20px;background:var(--erp-accent);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:background .15s;}
.btn-save:hover{background:var(--erp-accent-dark);}
.btn-cancel{padding:9px 16px;background:#fff;color:var(--erp-ink-muted);border:1px solid var(--erp-border);border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;}
.btn-cancel:hover{background:#f4f6f9;}
.side-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.side-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.6rem 1rem;font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.side-body{padding:.85rem 1rem;}
.flow-item{display:flex;align-items:flex-start;gap:8px;padding:6px 0;border-bottom:1px solid #f4f6f9;font-size:11px;color:var(--erp-ink-muted);line-height:1.5;}
.flow-item:last-child{border:none;}
.flow-num{width:18px;height:18px;border-radius:50%;background:var(--erp-accent);color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.warn-item{display:flex;align-items:flex-start;gap:8px;padding:6px 0;border-bottom:1px solid #fef9c3;font-size:11px;color:#7c4b00;line-height:1.5;}
.warn-item:last-child{border:none;}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Registrar llegada — Joselito</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Logística › Joselito › Nueva llegada</span>
</div>

<div class="body">
<div class="page-hdr">
    <div>
        <div class="page-title">Registrar llegada de mercadería</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px;">
            Nueva entrada al almacén Joselito desde provincia
        </div>
    </div>
    <span style="font-size:11px;color:#94a3b8;">📦 Joselito › Nueva llegada</span>
</div>

@if($errors->any())
<div style="background:#fbe9e8;border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;margin-bottom:.85rem;font-size:12px;color:#c0312b;">
    <strong>⚠️ Errores:</strong>
    <ul style="margin:.4rem 0 0 1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('joselito.store') }}">
@csrf

<div class="grid-main">
<div>

    {{-- Sección 1: Identificación --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">1</div>
            <div class="sec-hdr-title">Datos de la mercadería</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-2" style="margin-bottom:10px;">
                <div class="field">
                    <label class="flabel">
                        Nombre / Descripción <span class="required-star">*</span>
                    </label>
                    <input type="text" name="nombre" class="finput"
                           value="{{ old('nombre') }}"
                           placeholder="Ej: Conservas atún 170g x 48" required>
                    <span class="field-hint">Descripción del producto o lote</span>
                </div>
                <div class="field">
                    <label class="flabel">
                        Proveedor <span class="required-star">*</span>
                    </label>
                    <input type="text" name="proveedor" class="finput"
                           value="{{ old('proveedor') }}"
                           placeholder="Ej: Distribuidora del Sur SAC" required>
                </div>
            </div>
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">
                        Origen (ciudad/provincia) <span class="required-star">*</span>
                    </label>
                    <select name="origen" class="fselect" required>
                        <option value="">Seleccionar ciudad</option>
                        @foreach($ciudades as $c)
                            <option value="{{ $c }}" @selected(old('origen')===$c)>
                                🗺️ {{ $c }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label class="flabel">
                        Fecha de llegada <span class="required-star">*</span>
                    </label>
                    <input type="date" name="fecha_llegada" class="finput"
                           value="{{ old('fecha_llegada', date('Y-m-d')) }}" required>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 2: Cantidad --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-ok);">2</div>
            <div class="sec-hdr-title">Cantidad recibida</div>
        </div>
        <div class="sec-body">
            <div class="field">
                <label class="flabel">
                    Número de cajas <span class="required-star">*</span>
                </label>
                <input type="number" name="cantidad" class="finput-cajas"
                       value="{{ old('cantidad') }}"
                       placeholder="0" min="1" step="1" required>
                <span class="field-hint">
                    Cantidad exacta de cajas que llegan al almacén
                </span>
            </div>
        </div>
    </div>

    {{-- Sección 3: Observaciones --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#64748b;">3</div>
            <div class="sec-hdr-title">Observaciones</div>
        </div>
        <div class="sec-body">
            <div class="field">
                <label class="flabel">Notas internas</label>
                <textarea name="observaciones" class="ftarea"
                          placeholder="Condición de la mercadería, incidencias en el transporte, instrucciones especiales...">{{ old('observaciones') }}</textarea>
            </div>
        </div>
    </div>

    <div class="btn-row">
        <button type="submit" class="btn-save">
            📦 Registrar llegada
        </button>
        <a href="{{ route('joselito.index') }}" class="btn-cancel">
            ✕ Cancelar
        </a>
    </div>

</div>

{{-- Panel lateral --}}
<div>
    <div class="side-card">
        <div class="side-hdr">¿Qué pasa al registrar?</div>
        <div class="side-body">
            <div class="flow-item">
                <div class="flow-num">1</div>
                <div>Se crea la mercadería en el almacén Joselito con el stock inicial ingresado.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">2</div>
                <div>Se registra automáticamente una <strong>ENTRADA</strong> en el kardex con motivo "Llegada de provincia".</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">3</div>
                <div>La mercadería aparece en la vista principal mientras tenga cajas disponibles.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">4</div>
                <div>Al despacharse completamente <strong>desaparece</strong> del listado principal automáticamente.</div>
            </div>
        </div>
    </div>

    <div class="side-card" style="border-color:#fde68a;background:#fffbeb;">
        <div class="side-hdr" style="background:#fef9c3;border-color:#fde68a;color:#b45309;">
            ⚠️ Advertencias
        </div>
        <div class="side-body">
            <div class="warn-item">
                <span>🎯</span>
                <div>Verifica la <strong>cantidad exacta</strong> de cajas antes de guardar. Afecta el inventario del almacén.</div>
            </div>
            <div class="warn-item">
                <span>📋</span>
                <div>Si la mercadería ya existe, usa el <strong>kardex</strong> para agregar más stock, no registres una nueva entrada.</div>
            </div>
            <div class="warn-item">
                <span>🗺️</span>
                <div>Confirma el <strong>origen</strong> con la guía de remisión antes de seleccionarlo.</div>
            </div>
        </div>
    </div>
</div>

</div>
</form>
</div>
</div>

@endsection