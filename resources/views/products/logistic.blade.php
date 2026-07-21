@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.1rem;background:#eef1f5;min-height:100vh;font-family:'Segoe UI',-apple-system,sans-serif;}

/* ── ERP Bar ── */
.erp-bar{background:#1e3a5f;height:40px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}
.erp-sep{width:1px;height:18px;background:#334155;}

/* ── Header ── */
.doc-header{background:#fff;border:1px solid #dde2ea;border-top:4px solid #1e3a5f;border-radius:4px;padding:.9rem 1.1rem;margin-bottom:.85rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;}
.doc-title{font-size:16px;font-weight:800;color:#1e3a5f;}
.doc-sub{font-size:11px;color:#64748b;margin-top:3px;}
.product-chip{background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;padding:5px 14px;border-radius:3px;font-size:12px;font-weight:700;}

/* ── Secciones ── */
.sec{background:#fff;border:1px solid #dde2ea;border-radius:4px;overflow:hidden;margin-bottom:.85rem;}
.sec-hdr{background:#f4f6f9;border-bottom:1px solid #dde2ea;padding:.6rem 1rem;display:flex;align-items:center;gap:8px;}
.sec-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:#fff;flex-shrink:0;}
.sec-title{font-size:11px;font-weight:700;color:#1e3a5f;text-transform:uppercase;letter-spacing:.06em;}
.sec-body{padding:1rem 1.1rem;}
.field-grid{display:grid;gap:10px;}
.g2{grid-template-columns:repeat(2,1fr);}
.g3{grid-template-columns:repeat(3,1fr);}
.g4{grid-template-columns:repeat(4,1fr);}
@media(max-width:700px){.g2,.g3,.g4{grid-template-columns:1fr 1fr;}}
@media(max-width:400px){.g2,.g3,.g4{grid-template-columns:1fr;}}

/* ── Campos ── */
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{font-size:10px;font-weight:700;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:4px;}
.finput,.fselect{padding:7px 9px;border:1px solid #dde2ea;border-radius:3px;font-size:12px;color:#1e293b;background:#fbfcfe;outline:none;width:100%;transition:border-color .15s;}
.finput:focus,.fselect:focus{border-color:#1e3a5f;box-shadow:0 0 0 2px rgba(30,58,95,.1);}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Input especial para medidas */
.finput-measure{
    padding:8px 9px 8px 9px;
    border:1px solid #dde2ea;border-radius:3px;
    font-size:14px;font-weight:700;font-family:'Consolas',monospace;
    color:#1e3a5f;background:#f0f7ff;outline:none;width:100%;
    transition:border-color .15s;text-align:center;
}
.finput-measure:focus{border-color:#1e3a5f;box-shadow:0 0 0 2px rgba(30,58,95,.1);}

/* ── Info chips ── */
.info-chip{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:3px;font-size:10px;font-weight:600;}
.chip-warn{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.chip-info{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
.chip-ok  {background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}

/* ── Preview visual de dimensiones ── */
.dim-preview{background:#f8fafc;border:1px solid #dde2ea;border-radius:3px;padding:10px 14px;display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
.dim-block{text-align:center;}
.dim-val{font-size:16px;font-weight:800;font-family:'Consolas',monospace;color:#1e3a5f;line-height:1;}
.dim-lbl{font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-top:2px;}

/* ── Botones ── */
.btn-row{display:flex;justify-content:space-between;align-items:center;padding:.85rem 1.1rem;border-top:1px solid #f1f5f9;background:#f8fafc;}
.btn-back{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;border:1px solid #dde2ea;border-radius:3px;background:#fff;color:#5b6b7d;font-size:12px;font-weight:600;text-decoration:none;transition:background .15s;}
.btn-back:hover{background:#f1f5f9;}
.btn-save{display:inline-flex;align-items:center;gap:6px;padding:9px 22px;background:#16a34a;color:#fff;border:none;border-radius:3px;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.btn-save:hover{background:#15803d;}

/* ── Advertencia logística ── */
.warn-box{background:#fffbeb;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:3px;padding:.75rem 1rem;margin-bottom:.85rem;font-size:11px;color:#7c4b00;display:flex;align-items:flex-start;gap:8px;}
</style>

<div class="erp-bar">
    <div style="display:flex;align-items:center;gap:10px;">
        <div class="erp-sep"></div>
        <div class="erp-module">Logística · Configuración</div>
    </div>
    <span class="erp-breadcrumb">Productos › {{ $product->nombre }} › Configuración Logística</span>
</div>

<div class="pg">

{{-- Header --}}
<div class="doc-header">
    <div>
        <div class="doc-title">📦 Configuración Logística del Producto</div>
        <div class="doc-sub">Define las reglas de paletizado, dimensiones y restricciones de apilado</div>
    </div>
    <span class="product-chip">📦 {{ $product->nombre }}</span>
</div>

{{-- Advertencia --}}
<div class="warn-box">
    <span style="font-size:16px;flex-shrink:0;">⚠️</span>
    <div>
        <strong>Importante:</strong> Estos datos son usados por el simulador de pallets.
        Verifica que las dimensiones y restricciones sean precisas antes de guardar.
        Un error en estos campos puede afectar la distribución de carga.
    </div>
</div>

<form method="POST" action="{{ route('products.logistic.update', $product) }}">
@csrf

{{-- ═══ SECCIÓN 1: Dimensiones físicas ═══ --}}
<div class="sec">
    <div class="sec-hdr">
        <div class="sec-num" style="background:#1e3a5f;">1</div>
        <div class="sec-title">📐 Dimensiones físicas de la caja</div>
        <span class="info-chip chip-info" style="margin-left:auto;">Medidas en centímetros</span>
    </div>
    <div class="sec-body">
        <div class="field-grid g3" style="margin-bottom:12px;">
            <div class="field">
                <label class="flabel">📏 Largo (cm)</label>
                <input type="number" step="0.01" name="largo_cm" class="finput-measure"
                       placeholder="0.00"
                       value="{{ old('largo_cm', $logistic->largo_cm) }}">
                <span class="field-hint">Dimensión longitudinal</span>
            </div>
            <div class="field">
                <label class="flabel">📐 Ancho (cm)</label>
                <input type="number" step="0.01" name="ancho_cm" class="finput-measure"
                       placeholder="0.00"
                       value="{{ old('ancho_cm', $logistic->ancho_cm) }}">
                <span class="field-hint">Dimensión transversal</span>
            </div>
            <div class="field">
                <label class="flabel">📦 Alto (cm)</label>
                <input type="number" step="0.01" name="alto_cm" class="finput-measure"
                       placeholder="0.00"
                       value="{{ old('alto_cm', $logistic->alto_cm) }}">
                <span class="field-hint">Dimensión vertical</span>
            </div>
        </div>

        {{-- Preview visual --}}
        @if($logistic->largo_cm || $logistic->ancho_cm || $logistic->alto_cm)
        <div class="dim-preview">
            <span style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Vista actual:</span>
            @if($logistic->largo_cm)
            <div class="dim-block">
                <div class="dim-val">{{ $logistic->largo_cm }}</div>
                <div class="dim-lbl">Largo cm</div>
            </div>
            <span style="color:#94a3b8;font-weight:700;">×</span>
            @endif
            @if($logistic->ancho_cm)
            <div class="dim-block">
                <div class="dim-val">{{ $logistic->ancho_cm }}</div>
                <div class="dim-lbl">Ancho cm</div>
            </div>
            <span style="color:#94a3b8;font-weight:700;">×</span>
            @endif
            @if($logistic->alto_cm)
            <div class="dim-block">
                <div class="dim-val">{{ $logistic->alto_cm }}</div>
                <div class="dim-lbl">Alto cm</div>
            </div>
            @endif
            @if($logistic->largo_cm && $logistic->ancho_cm && $logistic->alto_cm)
            <div style="margin-left:auto;">
                <span class="info-chip chip-info">
                    Vol. ≈ {{ number_format(($logistic->largo_cm * $logistic->ancho_cm * $logistic->alto_cm) / 1000000, 4) }} m³
                </span>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

{{-- ═══ SECCIÓN 2: Peso ═══ --}}
<div class="sec">
    <div class="sec-hdr">
        <div class="sec-num" style="background:#0369a1;">2</div>
        <div class="sec-title">⚖️ Peso y restricciones de carga</div>
    </div>
    <div class="sec-body">
        <div class="field-grid g2">
            <div class="field">
                <label class="flabel">⚖️ Peso por caja (kg)</label>
                <input type="number" step="0.01" name="peso_caja" class="finput"
                       placeholder="0.00"
                       value="{{ old('peso_caja', $logistic->peso_caja) }}">
                <span class="field-hint">Peso bruto de la caja lista para despacho</span>
            </div>
            <div class="field">
                <label class="flabel">🏋️ Peso máximo encima (kg)</label>
                <input type="number" step="0.01" name="peso_maximo_encima" class="finput"
                       placeholder="0.00"
                       value="{{ old('peso_maximo_encima', $logistic->peso_maximo_encima) }}">
                <span class="field-hint">Carga máxima que puede soportar encima</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ SECCIÓN 3: Configuración de pallet ═══ --}}
<div class="sec">
    <div class="sec-hdr">
        <div class="sec-num" style="background:#7c3aed;">3</div>
        <div class="sec-title">🪵 Configuración del pallet</div>
        <span class="info-chip chip-warn" style="margin-left:auto;">Usado por el simulador</span>
    </div>
    <div class="sec-body">
        <div class="field-grid g3">
            <div class="field">
                <label class="flabel">📦 Máx. cajas por pallet</label>
                <input type="number" name="max_cajas_pallet" class="finput"
                       placeholder="0"
                       value="{{ old('max_cajas_pallet', $logistic->max_cajas_pallet) }}">
                <span class="field-hint">Total de cajas que caben en un pallet</span>
            </div>
            <div class="field">
                <label class="flabel">📊 Máx. niveles de apilado</label>
                <input type="number" name="max_niveles" class="finput"
                       placeholder="0"
                       value="{{ old('max_niveles', $logistic->max_niveles) }}">
                <span class="field-hint">Cantidad de pisos permitidos</span>
            </div>
            <div class="field">
                <label class="flabel">📏 Altura máx. pallet (cm)</label>
                <input type="number" step="0.01" name="altura_maxima_pallet" class="finput"
                       placeholder="0.00"
                       value="{{ old('altura_maxima_pallet', $logistic->altura_maxima_pallet) }}">
                <span class="field-hint">Altura total permitida del pallet cargado</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ SECCIÓN 4: Reglas logísticas ═══ --}}
<div class="sec">
    <div class="sec-hdr">
        <div class="sec-num" style="background:#b45309;">4</div>
        <div class="sec-title">📋 Reglas y restricciones logísticas</div>
    </div>
    <div class="sec-body">
        <div class="field-grid g3">
            <div class="field">
                <label class="flabel">🔄 Orientación de carga</label>
                <select name="orientacion" class="fselect">
                    <option value="NORMAL"   {{ $logistic->orientacion=='NORMAL'   ? 'selected' : '' }}>↕ NORMAL</option>
                    <option value="ACOSTADO" {{ $logistic->orientacion=='ACOSTADO' ? 'selected' : '' }}>↔ ACOSTADO</option>
                    <option value="VERTICAL" {{ $logistic->orientacion=='VERTICAL' ? 'selected' : '' }}>⬆ VERTICAL</option>
                </select>
                <span class="field-hint">Posición permitida durante el transporte</span>
            </div>
            <div class="field">
                <label class="flabel">🔀 Permite mezcla en pallet</label>
                <select name="permite_mezcla" class="fselect">
                    <option value="1" {{ $logistic->permite_mezcla  ? 'selected' : '' }}>✅ Sí — puede mezclarse</option>
                    <option value="0" {{ !$logistic->permite_mezcla ? 'selected' : '' }}>❌ No — pallet exclusivo</option>
                </select>
                <span class="field-hint">¿Puede compartir pallet con otros productos?</span>
            </div>
            <div class="field">
                <label class="flabel">📚 ¿Se puede apilar?</label>
                <select name="apilable" class="fselect">
                    <option value="1" {{ $logistic->apilable  ? 'selected' : '' }}>✅ Sí — apilable</option>
                    <option value="0" {{ !$logistic->apilable ? 'selected' : '' }}>❌ No — no apilar</option>
                </select>
                <span class="field-hint">¿Se pueden colocar cajas encima?</span>
            </div>
            <div class="field">
                <label class="flabel">🏷️ Grupo logístico</label>
                <select name="grupo_logistico" class="fselect">
                    <option value="GENERAL"   {{ $logistic->grupo_logistico=='GENERAL'   ? 'selected' : '' }}>📦 General</option>
                    <option value="LIQUIDOS"  {{ $logistic->grupo_logistico=='LIQUIDOS'  ? 'selected' : '' }}>💧 Líquidos</option>
                    <option value="CONSERVAS" {{ $logistic->grupo_logistico=='CONSERVAS' ? 'selected' : '' }}>🥫 Conservas</option>
                    <option value="VIDRIO"    {{ $logistic->grupo_logistico=='VIDRIO'    ? 'selected' : '' }}>🫙 Vidrio</option>
                    <option value="FRAGIL"    {{ $logistic->grupo_logistico=='FRAGIL'    ? 'selected' : '' }}>⚠️ Frágil</option>
                </select>
                <span class="field-hint">Categoría para agrupar en el simulador</span>
            </div>
            <div class="field">
                <label class="flabel">🔢 Prioridad de apilado</label>
                <input type="number" name="prioridad_apilado" class="finput"
                       placeholder="1"
                       value="{{ old('prioridad_apilado', $logistic->prioridad_apilado) }}">
                <span class="field-hint">Menor número = se carga primero (base)</span>
            </div>
            <div class="field">
                <label class="flabel">🔘 Estado de la configuración</label>
                <select name="activo" class="fselect">
                    <option value="1" {{ $logistic->activo  ? 'selected' : '' }}>✅ Activo</option>
                    <option value="0" {{ !$logistic->activo ? 'selected' : '' }}>⏸ Inactivo</option>
                </select>
                <span class="field-hint">Solo las activas son usadas en el simulador</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ Botones ═══ --}}
<div style="background:#fff;border:1px solid #dde2ea;border-radius:4px;">
    <div class="btn-row">
        <a href="{{ route('products.index') }}" class="btn-back">← Volver al listado</a>
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:11px;color:#94a3b8;">Los cambios se aplican inmediatamente al simulador</span>
            <button type="submit" class="btn-save">💾 Guardar configuración</button>
        </div>
    </div>
</div>

</form>
</div>

@endsection