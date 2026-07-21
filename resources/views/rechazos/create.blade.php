@extends('layouts.app')
@section('content')

<style>
:root{
    --erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;
    --erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;
    --erp-danger:#c0312b;--erp-danger-bg:#fbe9e8;
    --erp-warn:#b9690e;--erp-warn-bg:#fdf1e2;
    --erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;
    --font-ui:'Segoe UI',sans-serif;--font-mono:'Consolas',monospace;
}
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
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-danger);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.grid-main{display:grid;grid-template-columns:1fr 280px;gap:14px;}
@media(max-width:900px){.grid-main{grid-template-columns:1fr;}}
.sec-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.sec-hdr{padding:.65rem 1rem;display:flex;align-items:center;gap:7px;border-bottom:1px solid var(--erp-border);background:#f4f6f9;}
.sec-hdr-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.sec-hdr-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.sec-body{padding:1rem;}
.field{display:flex;flex-direction:column;gap:3px;margin-bottom:10px;}
.field:last-child{margin-bottom:0;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.required-star{color:var(--erp-danger);}
.finput,.fselect,.ftarea{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus,.ftarea:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.ftarea{resize:vertical;min-height:70px;}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Buscador de orden */
.search-orden-wrap{position:relative;}
.orden-resultados{
    position:absolute;top:100%;left:0;right:0;
    background:#fff;border:1px solid var(--erp-border);
    border-top:none;border-radius:0 0 4px 4px;
    z-index:100;max-height:220px;overflow-y:auto;
    box-shadow:0 4px 12px rgba(0,0,0,.1);
    display:none;
}
.orden-result-item{
    padding:9px 12px;cursor:pointer;
    border-bottom:1px solid #f4f6f9;
    transition:background .1s;
    font-size:12px;
}
.orden-result-item:hover{background:#f0f7ff;}
.orden-result-item:last-child{border:none;}
.orden-num{font-family:var(--font-mono);font-weight:700;color:var(--erp-accent);font-size:12px;}
.orden-cliente{color:var(--erp-ink-muted);font-size:11px;margin-top:1px;}
.orden-estado{display:inline-flex;font-size:10px;font-weight:700;padding:1px 6px;border-radius:3px;margin-left:6px;}

/* Orden seleccionada --*/
.orden-seleccionada{
    background:#eff6ff;border:1px solid #bfdbfe;
    border-radius:4px;padding:.75rem 1rem;
    margin-bottom:10px;
    display:none;
}
.orden-sel-num{font-family:var(--font-mono);font-weight:700;color:var(--erp-accent);font-size:14px;}
.orden-sel-cliente{font-size:12px;color:var(--erp-ink-muted);margin-top:2px;}

/* Tabla productos */
.prod-table{width:100%;border-collapse:collapse;font-size:12px;}
.prod-table th{background:#f4f6f9;color:var(--erp-ink-muted);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;}
.prod-table td{padding:8px 10px;border-bottom:1px solid #f4f6f9;vertical-align:middle;}
.prod-table tbody tr:hover{background:#f7fafc;}
.prod-table tbody tr.selected-row{background:#fef2f2;border-left:3px solid var(--erp-danger);}
.prod-radio{width:16px;height:16px;accent-color:var(--erp-danger);cursor:pointer;}
.disp-badge{display:inline-flex;font-family:var(--font-mono);font-size:11px;font-weight:700;padding:2px 7px;border-radius:3px;}
.disp-ok{background:var(--erp-ok-bg);color:var(--erp-ok);}
.disp-warn{background:var(--erp-warn-bg);color:var(--erp-warn);}
.loading-productos{text-align:center;padding:2rem;color:#94a3b8;font-size:12px;}

/* Resumen rechazo */
.resumen-rechazo{
    background:var(--erp-danger-bg);border:1px solid #f3c7c4;
    border-left:4px solid var(--erp-danger);
    border-radius:4px;padding:.85rem 1rem;
    margin-bottom:10px;display:none;
}
.resumen-producto{font-size:13px;font-weight:700;color:var(--erp-ink);margin-bottom:4px;}
.resumen-disp{font-size:11px;color:var(--erp-ink-muted);}

/* Botones */
.btn-row{display:flex;gap:8px;padding-top:.85rem;border-top:1px solid #f1f5f9;margin-top:.5rem;}
.btn-save{padding:9px 20px;background:var(--erp-danger);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:background .15s;}
.btn-save:hover{background:#9b1e1a;}
.btn-cancel{padding:9px 16px;background:#fff;color:var(--erp-ink-muted);border:1px solid var(--erp-border);border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;}
.btn-cancel:hover{background:#f4f6f9;}
.side-col{display:flex;flex-direction:column;gap:10px;}
.side-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;}
.side-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.6rem 1rem;font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.side-body{padding:.85rem 1rem;}
.flow-item{display:flex;align-items:flex-start;gap:8px;padding:6px 0;border-bottom:1px solid #f4f6f9;font-size:11px;color:var(--erp-ink-muted);line-height:1.5;}
.flow-item:last-child{border:none;}
.flow-num{width:18px;height:18px;border-radius:50%;background:var(--erp-danger);color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.warn-item{display:flex;align-items:flex-start;gap:7px;padding:6px 0;border-bottom:1px solid #fef9c3;font-size:11px;color:#7c4b00;line-height:1.5;}
.warn-item:last-child{border:none;}
.alert-err{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;font-size:12px;margin-bottom:.85rem;}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Registrar rechazo</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Ventas › Rechazos › Nuevo</span>
</div>

<div class="body">

<div class="page-hdr">
    <div>
        <div class="page-title">Registrar rechazo de cliente</div>
        <div class="page-sub">Busca la orden → selecciona el producto → ingresa la cantidad rechazada</div>
    </div>
    <a href="{{ route('rechazos.index') }}" class="btn-cancel">← Volver</a>
</div>

@if($errors->any())
<div class="alert-err">
    <strong>⚠️ Errores:</strong>
    <ul style="margin:.4rem 0 0 1rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('rechazos.store') }}" id="formRechazo">
@csrf

<input type="hidden" name="order_id"        id="hidOrderId">
<input type="hidden" name="order_detail_id" id="hidDetailId">

<div class="grid-main">
<div>

    {{-- Paso 1: Buscar orden --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-danger);">1</div>
            <div class="sec-hdr-title">Buscar orden</div>
        </div>
        <div class="sec-body">
            <div class="field">
                <label class="flabel">
                    N° de orden o nombre de cliente <span class="required-star">*</span>
                </label>
                <div class="search-orden-wrap">
                    <input type="text"
                           id="inputBuscarOrden"
                           class="finput"
                           placeholder="Escribe el número de orden o nombre del cliente..."
                           autocomplete="off">
                    <div class="orden-resultados" id="ordenResultados"></div>
                </div>
                <span class="field-hint">
                    Solo se muestran órdenes con estado COMPLETO o PARCIAL
                </span>
            </div>

            {{-- Orden seleccionada --}}
            <div class="orden-seleccionada" id="ordenSeleccionada">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <div class="orden-sel-num" id="selOrdenNum">—</div>
                        <div class="orden-sel-cliente" id="selOrdenCliente">—</div>
                    </div>
                    <button type="button"
                            onclick="limpiarOrden()"
                            style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:16px;">
                        ✕
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Paso 2: Seleccionar producto --}}
    <div class="sec-card" id="secProductos" style="display:none;">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-warn);">2</div>
            <div class="sec-hdr-title">Seleccionar producto rechazado</div>
        </div>
        <div class="sec-body" style="padding:0;">
            <div id="loadingProductos" class="loading-productos">
                ⏳ Cargando productos...
            </div>
            <div style="overflow-x:auto;display:none;" id="tablaProductosWrap">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th style="width:32px;"></th>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th style="text-align:center;">Despachado</th>
                        <th style="text-align:center;">Disponible p/ rechazo</th>
                    </tr>
                </thead>
                <tbody id="tablaProductosBody">
                </tbody>
            </table>
            </div>
        </div>
    </div>

    {{-- Paso 3: Datos del rechazo --}}
    <div class="sec-card" id="secDatos" style="display:none;">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">3</div>
            <div class="sec-hdr-title">Datos del rechazo</div>
        </div>
        <div class="sec-body">

            {{-- Resumen del producto seleccionado --}}
            <div class="resumen-rechazo" id="resumenRechazo">
                <div class="resumen-producto" id="resumenProductoNombre">—</div>
                <div class="resumen-disp">
                    Disponible para rechazo:
                    <strong id="resumenDisponible" style="color:var(--erp-danger);">—</strong>
                    unidades
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                <div class="field" style="margin:0;">
                    <label class="flabel">
                        Cantidad rechazada <span class="required-star">*</span>
                    </label>
                    <input type="number" name="cantidad_rechazada"
                           class="finput" id="inputCantidad"
                           placeholder="0" min="0.01" step="0.01" required
                           style="font-size:18px;font-weight:800;text-align:center;font-family:var(--font-mono);color:var(--erp-danger);">
                </div>
                <div class="field" style="margin:0;">
                    <label class="flabel">
                        Fecha de rechazo <span class="required-star">*</span>
                    </label>
                    <input type="date" name="fecha_rechazo"
                           class="finput"
                           value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div class="field">
                <label class="flabel">
                    Motivo <span class="required-star">*</span>
                </label>
                <select name="motivo" class="fselect" required>
                    <option value="">Seleccionar motivo</option>
                    @foreach($motivos as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="flabel">Observaciones</label>
                <textarea name="observaciones" class="ftarea"
                          placeholder="Detalles adicionales del rechazo..."></textarea>
            </div>
        </div>
    </div>

    {{-- Botones --}}
    <div class="btn-row" id="btnRow" style="display:none;">
        <button type="submit" class="btn-save" id="btnGuardar">
            ↩ Registrar rechazo
        </button>
        <a href="{{ route('rechazos.index') }}" class="btn-cancel">✕ Cancelar</a>
    </div>

</div>

{{-- Panel lateral --}}
<div class="side-col">

    <div class="side-card">
        <div class="side-hdr">¿Cómo funciona?</div>
        <div class="side-body">
            <div class="flow-item">
                <div class="flow-num">1</div>
                <div>Busca la orden del cliente que devuelve el producto.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">2</div>
                <div>Selecciona el producto rechazado de la lista de la orden.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">3</div>
                <div>Ingresa la cantidad, motivo y fecha del rechazo.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">4</div>
                <div>Al guardar, el sistema <strong>descuenta automáticamente</strong> de la cantidad despachada y <strong>restituye el stock</strong> del producto.</div>
            </div>
        </div>
    </div>

    <div class="side-card" style="border-color:#fde68a;background:#fffbeb;">
        <div class="side-hdr" style="background:#fef9c3;border-color:#fde68a;color:#b45309;">
            ⚠️ Importante
        </div>
        <div class="side-body">
            <div class="warn-item">
                <span>🔄</span>
                <div>El stock del producto se <strong>restituye automáticamente</strong> al registrar el rechazo.</div>
            </div>
            <div class="warn-item">
                <span>📋</span>
                <div>Solo puedes rechazar hasta la cantidad despachada menos rechazos previos del mismo ítem.</div>
            </div>
            <div class="warn-item">
                <span>🚫</span>
                <div>Esta acción <strong>no se puede deshacer</strong>. Verifica los datos antes de guardar.</div>
            </div>
        </div>
    </div>

    {{-- Panel resumen lateral --}}
    <div class="side-card" id="sideResumen" style="display:none;">
        <div class="side-hdr">Resumen del rechazo</div>
        <div class="side-body">
            <div style="font-size:11px;color:var(--erp-ink-muted);display:flex;flex-direction:column;gap:6px;">
                <div style="display:flex;justify-content:space-between;">
                    <span>Orden</span>
                    <span id="sideOrdenNum" style="font-family:var(--font-mono);font-weight:700;color:var(--erp-accent);">—</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span>Producto</span>
                    <span id="sideProdNombre" style="font-weight:600;color:var(--erp-ink);text-align:right;max-width:150px;">—</span>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span>Disponible</span>
                    <span id="sideDisp" style="font-family:var(--font-mono);font-weight:700;color:var(--erp-danger);">—</span>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
</form>

</div>
</div>

<script>
var ordenActual  = null;
var detalleActual = null;

/* ── Buscador de órdenes ── */
var timerBusqueda = null;

document.getElementById('inputBuscarOrden').addEventListener('input', function() {
    clearTimeout(timerBusqueda);
    var q = this.value.trim();
    if (q.length < 2) {
        cerrarResultados();
        return;
    }
    timerBusqueda = setTimeout(function() {
        buscarOrdenes(q);
    }, 300);
});

function buscarOrdenes(q) {
    var resultados = document.getElementById('ordenResultados');
    resultados.style.display = 'block';
    resultados.innerHTML = '<div style="padding:10px;text-align:center;color:#94a3b8;font-size:12px;">Buscando...</div>';

    fetch('{{ route('rechazos.buscarOrden') }}?q=' + encodeURIComponent(q))
        .then(function(r){ return r.json(); })
        .then(function(data) {
            if (!data.length) {
                resultados.innerHTML = '<div style="padding:10px;text-align:center;color:#94a3b8;font-size:12px;">Sin resultados</div>';
                return;
            }
            resultados.innerHTML = data.map(function(o) {
                var estadoColor = o.estado === 'COMPLETO' ? '#15803d' : '#b45309';
                var estadoBg    = o.estado === 'COMPLETO' ? '#dcfce7' : '#fef3c7';
                return '<div class="orden-result-item" onclick="seleccionarOrden(' + JSON.stringify(o).replace(/"/g, '&quot;') + ')">' +
                    '<span class="orden-num">' + o.numero_orden + '</span>' +
                    '<span class="orden-estado" style="background:' + estadoBg + ';color:' + estadoColor + ';">' + o.estado + '</span>' +
                    '<div class="orden-cliente">' + o.cliente + '</div>' +
                '</div>';
            }).join('');
        })
        .catch(function() {
            resultados.innerHTML = '<div style="padding:10px;text-align:center;color:#ef4444;font-size:12px;">Error al buscar</div>';
        });
}

function seleccionarOrden(orden) {
    ordenActual = orden;
    cerrarResultados();

    document.getElementById('inputBuscarOrden').value = orden.numero_orden;
    document.getElementById('hidOrderId').value       = orden.id;

    document.getElementById('selOrdenNum').textContent    = orden.numero_orden;
    document.getElementById('selOrdenCliente').textContent = orden.cliente;
    document.getElementById('ordenSeleccionada').style.display = 'block';

    document.getElementById('sideOrdenNum').textContent = orden.numero_orden;

    cargarProductos(orden.id);
}

function cerrarResultados() {
    document.getElementById('ordenResultados').style.display = 'none';
}

function limpiarOrden() {
    ordenActual  = null;
    detalleActual = null;
    document.getElementById('inputBuscarOrden').value = '';
    document.getElementById('hidOrderId').value       = '';
    document.getElementById('hidDetailId').value      = '';
    document.getElementById('ordenSeleccionada').style.display = 'none';
    document.getElementById('secProductos').style.display = 'none';
    document.getElementById('secDatos').style.display     = 'none';
    document.getElementById('btnRow').style.display       = 'none';
    document.getElementById('sideResumen').style.display  = 'none';
}

/* ── Cargar productos de la orden ── */
function cargarProductos(orderId) {
    var sec     = document.getElementById('secProductos');
    var loading = document.getElementById('loadingProductos');
    var wrap    = document.getElementById('tablaProductosWrap');

    sec.style.display     = 'block';
    loading.style.display = 'block';
    wrap.style.display    = 'none';

    fetch('/rechazos/orden/' + orderId)
        .then(function(r){ return r.json(); })
        .then(function(data) {
            loading.style.display = 'none';
            wrap.style.display    = 'block';

            var tbody = document.getElementById('tablaProductosBody');
            tbody.innerHTML = data.detalles.map(function(d) {
                var dispClass = d.disponible > 0 ? 'disp-ok' : 'disp-warn';
                var disabled  = d.disponible <= 0 ? 'disabled' : '';
                return '<tr id="prod-row-' + d.id + '">' +
                    '<td><input type="radio" class="prod-radio" name="_prod_radio" value="' + d.id + '" ' + disabled + ' onchange="seleccionarProducto(' + JSON.stringify(d).replace(/"/g, '&quot;') + ')"></td>' +
                    '<td style="font-weight:600;">' + d.producto + '</td>' +
                    '<td style="color:#94a3b8;font-size:11px;">' + d.sku + '</td>' +
                    '<td style="text-align:center;font-family:var(--font-mono);font-weight:700;">' + d.cantidad_despachada + '</td>' +
                    '<td style="text-align:center;"><span class="disp-badge ' + dispClass + '">' + d.disponible + ' u.</span></td>' +
                '</tr>';
            }).join('');
        })
        .catch(function() {
            loading.innerHTML = '<span style="color:#ef4444;">Error al cargar productos</span>';
        });
}

/* ── Seleccionar producto ── */
function seleccionarProducto(detalle) {
    detalleActual = detalle;

    // Highlight fila
    document.querySelectorAll('.prod-table tbody tr').forEach(function(tr) {
        tr.classList.remove('selected-row');
    });
    var row = document.getElementById('prod-row-' + detalle.id);
    if (row) row.classList.add('selected-row');

    document.getElementById('hidDetailId').value = detalle.id;

    // Resumen
    document.getElementById('resumenProductoNombre').textContent = detalle.producto;
    document.getElementById('resumenDisponible').textContent     = detalle.disponible;
    document.getElementById('resumenRechazo').style.display      = 'block';

    // Input cantidad con max
    var inputCant = document.getElementById('inputCantidad');
    inputCant.max   = detalle.disponible;
    inputCant.value = '';

    // Panel lateral
    document.getElementById('sideProdNombre').textContent = detalle.producto;
    document.getElementById('sideDisp').textContent       = detalle.disponible + ' u.';
    document.getElementById('sideResumen').style.display  = 'block';

    // Mostrar sección datos y botones
    document.getElementById('secDatos').style.display = 'block';
    document.getElementById('btnRow').style.display   = 'flex';

    // Scroll suave
    document.getElementById('secDatos').scrollIntoView({ behavior:'smooth', block:'start' });
}

/* ── Cerrar resultados al click fuera ── */
document.addEventListener('click', function(e) {
    var wrap = document.querySelector('.search-orden-wrap');
    if (wrap && !wrap.contains(e.target)) cerrarResultados();
});

/* ── Validación antes de enviar ── */
document.getElementById('formRechazo').addEventListener('submit', function(e) {
    if (!document.getElementById('hidOrderId').value) {
        e.preventDefault();
        alert('⚠️ Debes seleccionar una orden primero.');
        return;
    }
    if (!document.getElementById('hidDetailId').value) {
        e.preventDefault();
        alert('⚠️ Debes seleccionar un producto.');
        return;
    }
    var cant  = parseFloat(document.getElementById('inputCantidad').value);
    var max   = parseFloat(document.getElementById('inputCantidad').max);
    if (!cant || cant <= 0) {
        e.preventDefault();
        alert('⚠️ Ingresa una cantidad válida.');
        return;
    }
    if (cant > max) {
        e.preventDefault();
        alert('⚠️ La cantidad no puede superar las ' + max + ' unidades disponibles.');
        return;
    }
});
</script>

@endsection