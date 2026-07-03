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
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
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
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}

/* Header */
.page-hdr{
    display:flex;justify-content:space-between;
    align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;
}
.page-title{
    font-size:17px;font-weight:700;color:#0f172a;
    display:flex;align-items:center;gap:8px;
}
.page-title:before{
    content:"";width:4px;height:20px;
    background:var(--erp-accent);border-radius:2px;display:inline-block;
}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.breadcrumb{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:5px;}

/* Layout */
.grid-main{display:grid;grid-template-columns:1fr 260px;gap:14px;max-width:960px;}
@media(max-width:800px){.grid-main{grid-template-columns:1fr;}}

/* Cards */
.sec-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.sec-hdr{
    padding:.65rem 1rem;display:flex;align-items:center;gap:7px;
    border-bottom:1px solid var(--erp-border);background:#f4f6f9;
}
.sec-hdr-num{
    width:20px;height:20px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-size:10px;font-weight:700;color:#fff;flex-shrink:0;
}
.sec-hdr-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.sec-body{padding:1rem;}

/* Fields */
.field-grid{display:grid;gap:10px;}
.g-2{grid-template-columns:1fr 1fr;}
.g-3{grid-template-columns:1fr 1fr 1fr;}
@media(max-width:600px){.g-2,.g-3{grid-template-columns:1fr;}}
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{
    font-size:10px;font-weight:700;color:var(--erp-ink-muted);
    text-transform:uppercase;letter-spacing:.06em;
}
.required-star{color:#c0312b;margin-left:2px;}
.finput,.ftarea{
    padding:7px 9px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;width:100%;
    font-family:var(--font-ui);transition:border-color .15s;
}
.finput:focus,.ftarea:focus{
    border-color:var(--erp-accent);
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}
.ftarea{resize:vertical;min-height:80px;}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}

/* RUC field especial */
.finput-ruc{
    padding:9px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:15px;font-weight:700;
    color:var(--erp-accent-dark);background:#f0f6ff;
    outline:none;width:100%;font-family:var(--font-mono);
    letter-spacing:2px;transition:border-color .15s;
}
.finput-ruc:focus{
    border-color:var(--erp-accent);
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}

/* Btn row */
.btn-row{
    display:flex;gap:8px;
    padding-top:.85rem;border-top:1px solid #f1f5f9;
    margin-top:.5rem;
}
.btn-save{
    padding:8px 20px;background:var(--erp-accent);color:#fff;
    border:none;border-radius:3px;font-size:12px;font-weight:600;
    cursor:pointer;display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-save:hover{background:var(--erp-accent-dark);}
.btn-cancel{
    padding:8px 16px;background:#fff;color:var(--erp-ink-muted);
    border:1px solid var(--erp-border);border-radius:3px;
    font-size:12px;font-weight:600;text-decoration:none;
    display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-cancel:hover{background:#f4f6f9;color:var(--erp-ink-muted);}

/* Panel lateral */
.side-col{display:flex;flex-direction:column;gap:10px;}
.side-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;}
.side-hdr{
    background:#f4f6f9;border-bottom:1px solid var(--erp-border);
    padding:.6rem 1rem;font-size:11px;font-weight:700;
    color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;
}
.side-body{padding:.85rem 1rem;}
.warn-item{
    display:flex;align-items:flex-start;gap:8px;
    padding:7px 0;border-bottom:1px solid #f4f6f9;
    font-size:11px;color:#7c4b00;line-height:1.5;
}
.warn-item:last-child{border:none;padding-bottom:0;}
.warn-item-icon{font-size:15px;flex-shrink:0;margin-top:1px;}
.warn-item strong{color:#b45309;}
.info-item{
    display:flex;align-items:flex-start;gap:8px;
    padding:7px 0;border-bottom:1px solid #f4f6f9;
    font-size:11px;color:var(--erp-ink-muted);line-height:1.5;
}
.info-item:last-child{border:none;padding-bottom:0;}
.info-item-icon{font-size:14px;flex-shrink:0;color:var(--erp-accent);margin-top:1px;}
.req-tag{
    display:inline-flex;align-items:center;gap:4px;
    font-size:10px;font-weight:600;padding:2px 7px;
    border-radius:3px;background:#fbe9e8;color:#c0312b;
    border:1px solid #f3c7c4;margin-bottom:6px;
}
.opt-tag{
    display:inline-flex;align-items:center;gap:4px;
    font-size:10px;font-weight:600;padding:2px 7px;
    border-radius:3px;background:#f1f5f9;color:#64748b;
    border:1px solid #dde2ea;margin-bottom:6px;
}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Nuevo Cliente</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Ventas › Clientes › Nuevo</span>
</div>

<div class="body">

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Registrar nuevo cliente</div>
        <div class="page-sub">Completa los datos del cliente para agregarlo al sistema</div>
    </div>
    <div class="breadcrumb">🏠 Clientes › Nuevo cliente</div>
</div>

{{-- ── Form ── --}}
<form action="{{ route('clients.store') }}" method="POST">
@csrf

<div class="grid-main">

{{-- ── Columna izquierda ── --}}
<div>

    {{-- Sección 1: Datos fiscales --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">1</div>
            <div class="sec-hdr-title">Datos fiscales</div>
        </div>
        <div class="sec-body">
            <div class="field-grid" style="margin-bottom:10px;">
                <div class="field">
                    <label class="flabel">
                        RUC <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        name="ruc"
                        class="finput-ruc"
                        placeholder="20XXXXXXXXX"
                        maxlength="11"
                        required>
                    <span class="field-hint">11 dígitos — sin espacios ni guiones</span>
                </div>
            </div>
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">
                        Razón Social <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        name="razon_social"
                        class="finput"
                        placeholder="Ej: DISTRIBUIDORA EL SOL SAC"
                        required>
                    <span class="field-hint">Tal como figura en SUNAT</span>
                </div>
                <div class="field">
                    <label class="flabel">Nombre Comercial</label>
                    <input
                        type="text"
                        name="nombre_comercial"
                        class="finput"
                        placeholder="Nombre que usa el cliente">
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 2: Contacto --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-ok);">2</div>
            <div class="sec-hdr-title">Información de contacto</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-3">
                <div class="field">
                    <label class="flabel">Contacto</label>
                    <input
                        type="text"
                        name="contacto"
                        class="finput"
                        placeholder="Nombre del responsable">
                </div>
                <div class="field">
                    <label class="flabel">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        class="finput"
                        placeholder="9XX XXX XXX">
                </div>
                <div class="field">
                    <label class="flabel">Correo</label>
                    <input
                        type="email"
                        name="correo"
                        class="finput"
                        placeholder="correo@empresa.com">
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 3: Ubicación --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#7c3aed;">3</div>
            <div class="sec-hdr-title">Ubicación y dirección</div>
        </div>
        <div class="sec-body">
            <div class="field-grid" style="margin-bottom:10px;">
                <div class="field">
                    <label class="flabel">Dirección</label>
                    <input
                        type="text"
                        name="direccion"
                        class="finput"
                        placeholder="Av. / Jr. / Calle — número">
                </div>
            </div>
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">Distrito</label>
                    <input
                        type="text"
                        name="distrito"
                        class="finput"
                        placeholder="Ej: Miraflores">
                </div>
                <div class="field">
                    <label class="flabel">Ciudad</label>
                    <input
                        type="text"
                        name="ciudad"
                        class="finput"
                        value="Lima">
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 4: Observaciones --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#64748b;">4</div>
            <div class="sec-hdr-title">Observaciones</div>
        </div>
        <div class="sec-body">
            <div class="field">
                <label class="flabel">Notas internas</label>
                <textarea
                    name="observaciones"
                    class="ftarea"
                    placeholder="Condiciones especiales, preferencias de entrega, notas de crédito, etc."></textarea>
                <span class="field-hint">Solo visible para el equipo interno</span>
            </div>
        </div>
    </div>

    {{-- Botones --}}
    <div class="btn-row">
        <button type="submit" class="btn-save">
            💾 Guardar cliente
        </button>
        <a href="{{ route('clients.index') }}" class="btn-cancel">
            ✕ Cancelar
        </a>
    </div>

</div>

{{-- ── Panel lateral ── --}}
<div class="side-col">

    {{-- Campos requeridos --}}
    <div class="side-card">
        <div class="side-hdr">Campos del formulario</div>
        <div class="side-body">
            <div style="margin-bottom:8px;">
                <div class="req-tag">* Obligatorio</div>
                <div style="font-size:11px;color:var(--erp-ink-muted);line-height:1.6;">
                    <div style="padding:3px 0;border-bottom:1px solid #f1f5f9;">RUC</div>
                    <div style="padding:3px 0;">Razón Social</div>
                </div>
            </div>
            <div>
                <div class="opt-tag">Opcional</div>
                <div style="font-size:11px;color:var(--erp-ink-muted);line-height:1.6;">
                    <div style="padding:3px 0;border-bottom:1px solid #f1f5f9;">Nombre comercial</div>
                    <div style="padding:3px 0;border-bottom:1px solid #f1f5f9;">Contacto / Teléfono</div>
                    <div style="padding:3px 0;border-bottom:1px solid #f1f5f9;">Correo electrónico</div>
                    <div style="padding:3px 0;border-bottom:1px solid #f1f5f9;">Dirección / Distrito</div>
                    <div style="padding:3px 0;">Observaciones</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Advertencias --}}
    <div class="side-card" style="border-color:#fde68a;background:#fffbeb;">
        <div class="side-hdr" style="background:#fef9c3;border-color:#fde68a;color:#b45309;">
            ⚠️ Advertencias
        </div>
        <div class="side-body">
            <div class="warn-item">
                <div class="warn-item-icon">🎯</div>
                <div>
                    <strong>RUC exacto</strong><br>
                    Debe tener 11 dígitos y coincidir con SUNAT. Un RUC incorrecto invalida la facturación.
                </div>
            </div>
            <div class="warn-item">
                <div class="warn-item-icon">📋</div>
                <div>
                    <strong>Razón social oficial</strong><br>
                    Usa la razón social tal como aparece en los documentos de la empresa, en mayúsculas.
                </div>
            </div>
            <div class="warn-item">
                <div class="warn-item-icon">🔗</div>
                <div>
                    <strong>No se puede eliminar</strong><br>
                    Un cliente con órdenes no puede eliminarse. Verifica bien antes de guardar.
                </div>
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="side-card" style="border-color:#bfdbfe;background:#eff6ff;">
        <div class="side-hdr" style="background:#dbeafe;border-color:#bfdbfe;color:var(--erp-accent-dark);">
            💡 Consejos
        </div>
        <div class="side-body">
            <div class="info-item">
                <div class="info-item-icon">①</div>
                <div>Ingresa el RUC primero — sirve para identificar al cliente en órdenes y PDFs.</div>
            </div>
            <div class="info-item">
                <div class="info-item-icon">②</div>
                <div>El teléfono y correo son clave para coordinar entregas de encomiendas.</div>
            </div>
            <div class="info-item">
                <div class="info-item-icon">③</div>
                <div>Usa observaciones para anotar condiciones especiales de pago o despacho.</div>
            </div>
        </div>
    </div>

</div>

</div>

</form>

</div>
</div>

@endsection