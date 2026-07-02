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
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
}
*{box-sizing:border-box;}
.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    padding:0;min-height:100vh;font-size:13px;
}
.erp-bar{
    background:#1e3a5f;height:38px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.breadcrumb{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:5px;}

/* Cards */
.sec-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.sec-hdr{padding:.65rem 1rem;display:flex;align-items:center;gap:7px;border-bottom:1px solid var(--erp-border);}
.sec-hdr-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.sec-hdr-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.sec-body{padding:1rem;}

/* Fields */
.field-grid{display:grid;gap:10px;}
.g-9-3{grid-template-columns:3fr 1fr;}
.g-4-4-2-2{grid-template-columns:2fr 2fr 1fr 1fr;}
.g-3-3-3{grid-template-columns:1fr 1fr 1fr;}
@media(max-width:700px){
    .g-9-3,.g-4-4-2-2,.g-3-3-3{grid-template-columns:1fr;}
}
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.required-star{color:#c0312b;margin-left:2px;}
.finput,.fselect,.ftarea{
    padding:7px 9px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;width:100%;
    font-family:var(--font-ui);transition:border-color .15s;
}
.finput:focus,.fselect:focus,.ftarea:focus{
    border-color:var(--erp-accent);
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}
.ftarea{resize:vertical;min-height:90px;}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Stock inputs highlight */
.finput-stock{
    padding:9px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:15px;font-weight:700;
    color:var(--erp-ok);background:var(--erp-ok-bg);
    outline:none;width:100%;font-family:'Consolas',monospace;
    text-align:center;transition:border-color .15s;
}
.finput-stock:focus{border-color:var(--erp-ok);box-shadow:0 0 0 2px rgba(28,124,77,.1);}
.finput-min{
    padding:9px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:15px;font-weight:700;
    color:var(--erp-warn);background:#fdf1e2;
    outline:none;width:100%;font-family:'Consolas',monospace;
    text-align:center;transition:border-color .15s;
}
.finput-min:focus{border-color:var(--erp-warn);box-shadow:0 0 0 2px rgba(185,105,14,.1);}

/* Stock hint bar */
.stock-hint{
    background:#f4f6f9;border:1px solid var(--erp-border);
    border-radius:3px;padding:8px 10px;
    display:flex;align-items:center;gap:8px;
    font-size:11px;color:var(--erp-ink-muted);margin-top:8px;
}
.stock-hint-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}

/* Btn row */
.btn-row{
    display:flex;justify-content:flex-end;gap:8px;
    padding-top:.85rem;border-top:1px solid #f1f5f9;
    margin-top:.5rem;
}
.btn-cancel{
    padding:8px 16px;background:#fff;color:var(--erp-ink-muted);
    border:1px solid var(--erp-border);border-radius:3px;
    font-size:12px;font-weight:600;cursor:pointer;
    text-decoration:none;display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-cancel:hover{background:#f4f6f9;color:var(--erp-ink-muted);}
.btn-save{
    padding:8px 20px;background:var(--erp-ok);color:#fff;
    border:none;border-radius:3px;font-size:12px;font-weight:600;
    cursor:pointer;display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-save:hover{background:#166534;}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">
            {{ isset($raw_material) ? 'Editar materia prima' : 'Nueva materia prima' }}
        </div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">
        Producción › Materia Prima ›
        {{ isset($raw_material) ? 'Editar' : 'Nueva' }}
    </span>
</div>

<div class="body">

<div class="page-hdr">
    <div>
        <div class="page-title">
            {{ isset($raw_material) ? 'Editar materia prima' : 'Nueva materia prima' }}
        </div>
        <div class="page-sub">
            {{ isset($raw_material)
                ? 'Actualiza los datos de '.$raw_material->name
                : 'Registra una nueva materia prima en el sistema' }}
        </div>
    </div>
    <span class="breadcrumb">
        🏠 Materia prima ›
        {{ isset($raw_material) ? 'Editar' : 'Nueva' }}
    </span>
</div>

{{-- ══ FORM (todo el código original intacto) ══ --}}
<form method="POST"
      action="{{ isset($raw_material)
        ? route('raw-materials.update', $raw_material)
        : route('raw-materials.store') }}">

    @csrf
    @isset($raw_material)
        @method('PUT')
    @endisset

    {{-- ── Sección 1: Información general ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">1</div>
            <div class="sec-hdr-title">Información general</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-9-3" style="margin-bottom:10px;">
                <div class="field">
                    <label class="flabel">
                        Nombre <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        class="finput"
                        value="{{ old('name', $raw_material->name ?? '') }}"
                        placeholder="Ej: Polietileno de baja densidad"
                        required>
                </div>
                <div class="field">
                    <label class="flabel">Unidad <span class="required-star">*</span></label>
                    <select name="unit" class="fselect">
                        @foreach(['KG','LITROS','UNIDADES'] as $unidad)
                            <option
                                value="{{ $unidad }}"
                                @selected(old('unit', $raw_material->unit ?? '') == $unidad)>
                                {{ $unidad }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="field-grid g-4-4-2-2">
                <div class="field">
                    <label class="flabel">Categoría</label>
                    <input
                        type="text"
                        name="category"
                        class="finput"
                        value="{{ old('category', $raw_material->category ?? '') }}"
                        placeholder="Ej: Tintas, Cartón, Plástico">
                </div>
                <div class="field">
                    <label class="flabel">Proveedor</label>
                    <input
                        type="text"
                        name="supplier"
                        class="finput"
                        value="{{ old('supplier', $raw_material->supplier ?? '') }}"
                        placeholder="Nombre del proveedor">
                </div>
                <div class="field">
                    <label class="flabel">Color</label>
                    <input
                        type="text"
                        name="color"
                        class="finput"
                        value="{{ old('color', $raw_material->color ?? '') }}"
                        placeholder="Ej: Rojo">
                </div>
                <div class="field">
                    <label class="flabel">Activo</label>
                    <select name="active" class="fselect">
                        <option value="1" @selected(old('active', $raw_material->active ?? true))>
                            ✅ Sí
                        </option>
                        <option value="0" @selected(!old('active', $raw_material->active ?? true))>
                            ❌ No
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Sección 2: Inventario ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-ok);">2</div>
            <div class="sec-hdr-title">Inventario y stock</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-3-3-3">
                <div class="field">
                    <label class="flabel">Stock actual</label>
                    <input
                        type="number"
                        step="0.01"
                        name="stock"
                        class="finput-stock"
                        value="{{ old('stock', $raw_material->stock ?? 0) }}"
                        min="0">
                    <span class="field-hint">Cantidad física disponible ahora</span>
                </div>
                <div class="field">
                    <label class="flabel">Stock mínimo</label>
                    <input
                        type="number"
                        step="0.01"
                        name="minimum_stock"
                        class="finput-min"
                        value="{{ old('minimum_stock', $raw_material->minimum_stock ?? 0) }}"
                        min="0">
                    <span class="field-hint">Umbral de alerta para reposición</span>
                </div>
                <div style="display:flex;align-items:flex-end;padding-bottom:18px;">
                    <div class="stock-hint" style="flex:1;">
                        <span class="stock-hint-dot" style="background:#22c55e;"></span>
                        Stock actual ≥ mínimo → Disponible
                        <br>
                        <span class="stock-hint-dot" style="background:#f59e0b;margin-top:4px;"></span>
                        Stock actual &lt; mínimo → Stock bajo
                        <br>
                        <span class="stock-hint-dot" style="background:#ef4444;margin-top:4px;"></span>
                        Stock actual = 0 → Agotado
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Sección 3: Observaciones ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#64748b;">3</div>
            <div class="sec-hdr-title">Observaciones y notas</div>
        </div>
        <div class="sec-body">
            <div class="field">
                <label class="flabel">Notas internas</label>
                <textarea
                    name="notes"
                    class="ftarea"
                    placeholder="Instrucciones de uso, condiciones de almacenamiento, alertas especiales...">{{ old('notes', $raw_material->notes ?? '') }}</textarea>
                <span class="field-hint">
                    Visible solo para el equipo interno — no aparece en documentos externos
                </span>
            </div>
        </div>
    </div>

    {{-- ── Botones ── --}}
    <div class="btn-row">
        <a href="{{ route('raw-materials.index') }}" class="btn-cancel">
            ✕ Cancelar
        </a>
        <button type="submit" class="btn-save">
            💾 Guardar materia prima
        </button>
    </div>

</form>

</div>
</div>

@endsection