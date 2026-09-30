@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.erp-bar{
    background:#1e3a5f;height:40px;display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;margin:-20px -20px 0;
}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}

.pg{
    padding:1.25rem;background:#eef1f5;min-height:100vh;
    font-family:'Segoe UI',-apple-system,BlinkMacSystemFont,Arial,sans-serif;
}

/* ── Centrado ── */
.import-wrap{
    max-width:600px;margin:0 auto;
    display:flex;flex-direction:column;gap:14px;
}

/* ── Header card ── */
.import-hdr{
    background:#fff;border:1px solid #dde2ea;border-top:4px solid #1e3a5f;
    border-radius:6px;padding:1rem 1.25rem;
    display:flex;align-items:center;gap:12px;
}
.import-hdr-icon{
    width:44px;height:44px;border-radius:10px;flex-shrink:0;
    background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;
    display:flex;align-items:center;justify-content:center;font-size:20px;
}
.import-hdr-title{font-size:16px;font-weight:800;color:#0f172a;}
.import-hdr-sub{font-size:11px;color:#64748b;margin-top:2px;}

/* ── Alert ── */
.alert-err{
    background:#fef2f2;border:1px solid #fecaca;border-left:4px solid #dc2626;
    border-radius:6px;padding:11px 14px;font-size:12px;font-weight:600;color:#991b1b;
    display:flex;align-items:center;gap:8px;
}

/* ── Card principal ── */
.import-card{
    background:#fff;border:1px solid #dde2ea;border-radius:6px;overflow:hidden;
    box-shadow:0 1px 3px rgba(15,23,42,.05);
}
.import-card-hdr{
    background:#f4f6f9;border-bottom:1px solid #dde2ea;
    padding:.6rem 1rem;display:flex;align-items:center;gap:6px;
}
.import-card-title{font-size:11px;font-weight:700;color:#1e3a5f;text-transform:uppercase;letter-spacing:.06em;}
.import-card-body{padding:1.5rem;}

/* ── Drop zone ── */
.drop-zone{
    border:2px dashed #bfdbfe;border-radius:8px;
    padding:2.5rem 1.5rem;text-align:center;
    background:#f8fbff;cursor:pointer;
    transition:border-color .2s,background .2s;
    position:relative;
}
.drop-zone:hover,.drop-zone.drag-over{
    border-color:#2563eb;background:#eff6ff;
}
.drop-icon{font-size:42px;margin-bottom:.75rem;opacity:.7;}
.drop-title{font-size:14px;font-weight:700;color:#1e293b;margin-bottom:4px;}
.drop-sub{font-size:11px;color:#64748b;margin-bottom:1rem;}
.drop-badge{
    display:inline-flex;align-items:center;gap:4px;
    background:#fee2e2;color:#dc2626;border:1px solid #fecaca;
    border-radius:3px;padding:2px 9px;font-size:10px;font-weight:700;
    margin-bottom:1.25rem;
}

/* Input file oculto con botón visual */
.file-input-wrap{display:flex;justify-content:center;}

input[type="file"]{
    display:block;
    font-size:12px;
    color:#475569;
    background:#fff;
    border:1px solid #dde2ea;
    border-radius:5px;
    padding:8px 12px;
    outline:none;
    cursor:pointer;
    max-width:360px;
    width:100%;
}

input[type="file"]::-webkit-file-upload-button{
    background:#1e3a5f;color:#fff;border:none;
    padding:6px 14px;border-radius:4px;
    font-size:11px;font-weight:700;cursor:pointer;
    margin-right:10px;transition:background .15s;
}
input[type="file"]::-webkit-file-upload-button:hover{background:#2d4f7c;}

/* ── Info strip ── */
.info-strip{
    margin-top:1.25rem;background:#f8fafc;border:1px solid #e2e8f0;
    border-radius:6px;padding:.75rem 1rem;
    display:flex;flex-direction:column;gap:6px;
}
.info-row{display:flex;align-items:center;gap:8px;font-size:11px;color:#64748b;}
.info-row .dot{width:6px;height:6px;border-radius:50%;background:#2563eb;flex-shrink:0;}

/* ── Botón submit ── */
.btn-row{
    padding:.85rem 1rem;border-top:1px solid #f1f5f9;
    background:#f8fafc;display:flex;justify-content:flex-end;
    gap:8px;align-items:center;
}
.btn-submit{
    display:inline-flex;align-items:center;gap:7px;
    padding:9px 22px;background:#2563eb;color:#fff;
    border:none;border-radius:5px;font-size:12px;font-weight:700;
    cursor:pointer;transition:background .15s,transform .1s;
    letter-spacing:.02em;
}
.btn-submit:hover{background:#1d4ed8;}
.btn-submit:active{transform:scale(.99);}
.btn-hint{font-size:11px;color:#94a3b8;}
</style>

<div class="erp-bar">
    <span class="erp-module">📄 Importar Pedido PDF</span>
    <span class="erp-breadcrumb">Órdenes › Importar PDF</span>
</div>

<div class="pg">
<div class="import-wrap">

    {{-- Header --}}
    <div class="import-hdr">
        <div class="import-hdr-icon">📄</div>
        <div>
            <div class="import-hdr-title">Importar pedido desde PDF</div>
            <div class="import-hdr-sub">Carga el PDF del pedido para analizarlo automáticamente con el sistema</div>
        </div>
    </div>

    {{-- Error --}}
    @if(session('error'))
    <div class="alert-err">⚠️ {{ session('error') }}</div>
    @endif

    {{-- Card del form --}}
    <div class="import-card">
        <div class="import-card-hdr">
            <div class="import-card-title">📎 Seleccionar archivo</div>
        </div>

        <form
            action="{{ route('orders.importPdf.preview') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="import-card-body">

                {{-- Drop zone visual --}}
                <div class="drop-zone" id="dropZone">
                    <div class="drop-icon">📄</div>
                    <div class="drop-title">Selecciona el PDF del pedido</div>
                    <div class="drop-sub">Utiliza el PDF generado por el sistema de pedidos</div>
                    <div class="drop-badge">📋 Solo archivos PDF</div>

                    <div class="file-input-wrap">
                        <input
                            type="file"
                            name="archivo"
                            accept="application/pdf"
                            required
                            id="archivoInput"
                            onchange="mostrarArchivo(this)"
                        >
                    </div>
                </div>

                {{-- Nombre del archivo seleccionado --}}
                <div id="archivoSeleccionado" style="display:none;margin-top:10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:5px;padding:8px 12px;font-size:12px;color:#166534;font-weight:600;">
                    ✅ <span id="archivoNombre"></span>
                </div>

                {{-- Info --}}
                <div class="info-strip">
                    <div class="info-row"><span class="dot"></span>El sistema extrae automáticamente los productos y cantidades del PDF.</div>
                    <div class="info-row"><span class="dot"></span>Podrás revisar y confirmar los datos antes de crear la orden.</div>
                    <div class="info-row"><span class="dot"></span>Solo se aceptan archivos PDF generados por el sistema de pedidos.</div>
                </div>

            </div>

            <div class="btn-row">
                <span class="btn-hint">El análisis tarda unos segundos</span>
                <button type="submit" class="btn-submit">
                    🔍 Analizar pedido
                </button>
            </div>

        </form>
    </div>

</div>
</div>

<script>
function mostrarArchivo(input) {
    const wrap = document.getElementById('archivoSeleccionado');
    const nombre = document.getElementById('archivoNombre');
    if (input.files && input.files[0]) {
        nombre.textContent = input.files[0].name;
        wrap.style.display = 'block';
        document.getElementById('dropZone').style.borderColor = '#16a34a';
        document.getElementById('dropZone').style.background = '#f0fdf4';
    }
}
</script>

@endsection