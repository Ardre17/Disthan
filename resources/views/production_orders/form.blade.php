<style>
.grid-main{display:grid;grid-template-columns:1fr 280px;gap:14px;}
@media(max-width:900px){.grid-main{grid-template-columns:1fr;}}
.sec-card{background:#fff;border:1px solid #dde2ea;border-radius:4px;margin-bottom:10px;}
.sec-hdr{
    background:#f4f6f9;border-bottom:1px solid #dde2ea;
    padding:.65rem 1rem;display:flex;align-items:center;gap:7px;
}
.sec-hdr-num{
    width:20px;height:20px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-size:10px;font-weight:700;color:#fff;flex-shrink:0;
}
.sec-hdr-title{
    font-size:11px;font-weight:700;color:#1c2733;
    text-transform:uppercase;letter-spacing:.06em;
}
.sec-body{padding:1rem;}
.field-grid{display:grid;gap:10px;}
.g-2{grid-template-columns:1fr 1fr;}
@media(max-width:640px){.g-2{grid-template-columns:1fr;}}
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{
    font-size:10px;font-weight:700;color:#5b6b7d;
    text-transform:uppercase;letter-spacing:.06em;
}
.required-star{color:#c0312b;margin-left:2px;}
.finput,.fselect,.ftarea{
    padding:7px 9px;border:1px solid #dde2ea;
    border-radius:3px;font-size:12px;color:#1c2733;
    background:#fbfcfe;outline:none;width:100%;
    font-family:'Segoe UI',sans-serif;transition:border-color .15s;
}
.finput:focus,.fselect:focus,.ftarea:focus{
    border-color:#0b5ed7;
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}
.ftarea{resize:vertical;min-height:90px;}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}
/* Cantidad inputs — destacados */
.finput-qty{
    padding:10px;border:1px solid #dde2ea;
    border-radius:3px;font-size:18px;font-weight:800;
    text-align:center;outline:none;width:100%;
    font-family:'Consolas',monospace;transition:border-color .15s;
}
.finput-qty.producida{
    color:#1c7c4d;background:#e8f5ee;
}
.finput-qty.producida:focus{border-color:#1c7c4d;box-shadow:0 0 0 2px rgba(28,124,77,.1);}
.finput-qty.consumida{
    color:#b9690e;background:#fdf1e2;
}
.finput-qty.consumida:focus{border-color:#b9690e;box-shadow:0 0 0 2px rgba(185,105,14,.1);}
/* Relación consumo/producción */
.ratio-block{
    background:#f4f6f9;border:1px solid #dde2ea;
    border-radius:3px;padding:10px 14px;
    display:flex;align-items:center;justify-content:space-between;
    font-size:12px;color:#5b6b7d;margin-top:8px;
}
.ratio-val{
    font-family:'Consolas',monospace;font-size:16px;
    font-weight:800;color:#0b5ed7;
}
/* Botones */
.btn-row{
    display:flex;gap:8px;
    padding-top:.85rem;border-top:1px solid #f1f5f9;
    margin-top:.5rem;
}
.btn-iniciar{
    padding:9px 22px;background:#1c7c4d;color:#fff;
    border:none;border-radius:3px;font-size:12px;font-weight:700;
    cursor:pointer;display:inline-flex;align-items:center;gap:6px;
    transition:background .15s;
}
.btn-iniciar:hover{background:#166534;}
.btn-cancel{
    padding:9px 16px;background:#fff;color:#5b6b7d;
    border:1px solid #dde2ea;border-radius:3px;
    font-size:12px;font-weight:600;text-decoration:none;
    display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-cancel:hover{background:#f4f6f9;}
/* Panel lateral */
.side-col{display:flex;flex-direction:column;gap:10px;}
.side-card{background:#fff;border:1px solid #dde2ea;border-radius:4px;}
.side-hdr{
    background:#f4f6f9;border-bottom:1px solid #dde2ea;
    padding:.6rem 1rem;font-size:11px;font-weight:700;
    color:#1c2733;text-transform:uppercase;letter-spacing:.06em;
}
.side-body{padding:.85rem 1rem;}
.flow-item{
    display:flex;align-items:flex-start;gap:8px;
    padding:7px 0;border-bottom:1px solid #f4f6f9;
    font-size:11px;color:#5b6b7d;line-height:1.5;
}
.flow-item:last-child{border:none;}
.flow-num{
    width:18px;height:18px;border-radius:50%;
    background:#0b5ed7;color:#fff;
    font-size:10px;font-weight:700;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;margin-top:1px;
}
.warn-item{
    display:flex;align-items:flex-start;gap:8px;
    padding:7px 0;border-bottom:1px solid #fef9c3;
    font-size:11px;color:#7c4b00;line-height:1.5;
}
.warn-item:last-child{border:none;}
.warn-item strong{color:#b45309;}
</style>

<form method="POST" action="{{ route('production-orders.store') }}">
@csrf

<div class="grid-main">

{{-- ── Columna izquierda ── --}}
<div>

    {{-- Sección 1: Selección de materiales --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#0b5ed7;">1</div>
            <div class="sec-hdr-title">Selección de producto y materia prima</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">
                        Producto <span class="required-star">*</span>
                    </label>
                    <select name="product_id" class="fselect" required>
                        <option value="">Seleccione un producto...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <span class="field-hint">Producto final que se va a fabricar</span>
                </div>
                <div class="field">
                    <label class="flabel">
                        Materia prima <span class="required-star">*</span>
                    </label>
                    <select name="raw_material_id" class="fselect" required>
                        <option value="">Seleccione materia prima...</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}">
                                {{ $material->name }}
                                @if($material->stock_actual)
                                    — Stock: {{ number_format($material->stock_actual,0) }} {{ $material->unit ?? '' }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <span class="field-hint">
                        Materia prima que se consumirá en esta producción
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 2: Cantidades --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#1c7c4d;">2</div>
            <div class="sec-hdr-title">Cantidades de producción</div>
        </div>
        <div class="sec-body">
            <div class="field-grid g-2">
                <div class="field">
                    <label class="flabel">
                        Cantidad a producir <span class="required-star">*</span>
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="produced_quantity"
                        class="finput-qty producida"
                        placeholder="0"
                        id="cantProducida"
                        oninput="calcRatio()"
                        required>
                    <span class="field-hint">
                        Unidades del producto final que se fabricarán
                    </span>
                </div>
                <div class="field">
                    <label class="flabel">
                        Cantidad consumida <span class="required-star">*</span>
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="consumed_quantity"
                        class="finput-qty consumida"
                        placeholder="0"
                        id="cantConsumida"
                        oninput="calcRatio()"
                        required>
                    <span class="field-hint">
                        Cantidad de materia prima que se descontará del inventario
                    </span>
                </div>
            </div>

            {{-- Ratio consumo --}}
            <div class="ratio-block" id="ratioBlock" style="display:none;">
                <span>Ratio consumo / producción:</span>
                <span>
                    <span class="ratio-val" id="ratioVal">—</span>
                    <span style="font-size:11px;color:#94a3b8;margin-left:4px;">
                        unidades de MP por unidad producida
                    </span>
                </span>
            </div>
        </div>
    </div>

    {{-- Sección 3: Observación --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#64748b;">3</div>
            <div class="sec-hdr-title">Observaciones</div>
        </div>
        <div class="sec-body">
            <div class="field">
                <label class="flabel">Observación</label>
                <textarea
                    name="observation"
                    class="ftarea"
                    placeholder="Instrucciones especiales, notas del lote, condiciones de producción..."></textarea>
                <span class="field-hint">
                    Visible solo para el equipo interno — no aparece en reportes externos
                </span>
            </div>
        </div>
    </div>

    {{-- Botones --}}
    <div class="btn-row">
        <button type="submit" class="btn-iniciar">
            🟢 Iniciar producción
        </button>
        <a href="{{ route('production-orders.index') }}" class="btn-cancel">
            ✕ Cancelar
        </a>
    </div>

</div>

{{-- ── Panel lateral ── --}}
<div class="side-col">

    {{-- Flujo de producción --}}
    <div class="side-card">
        <div class="side-hdr">Flujo de la orden</div>
        <div class="side-body">
            <div class="flow-item">
                <div class="flow-num">1</div>
                <div>Selecciona el <strong>producto final</strong> que se va a fabricar en esta orden.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">2</div>
                <div>Elige la <strong>materia prima</strong> que se consumirá. Verifica que haya stock suficiente.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">3</div>
                <div>Ingresa la <strong>cantidad a producir</strong> y la <strong>cantidad consumida</strong>. El ratio se calcula automáticamente.</div>
            </div>
            <div class="flow-item">
                <div class="flow-num">4</div>
                <div>Al <strong>iniciar</strong>, el sistema descuenta la materia prima del inventario y registra la orden.</div>
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
                <span style="font-size:15px;flex-shrink:0;">🎯</span>
                <div>
                    <strong>Verifica la materia prima</strong><br>
                    Confirma que el tipo y la cantidad corresponden exactamente a lo que se usará en producción.
                </div>
            </div>
            <div class="warn-item">
                <span style="font-size:15px;flex-shrink:0;">⌨️</span>
                <div>
                    <strong>Cuidado al digitar</strong><br>
                    La cantidad consumida <strong>descuenta el inventario</strong> automáticamente. Un error afecta el stock real.
                </div>
            </div>
            <div class="warn-item">
                <span style="font-size:15px;flex-shrink:0;">🚫</span>
                <div>
                    <strong>No se puede eliminar</strong><br>
                    Una vez iniciada la orden, no puede eliminarse. Contacta al encargado si hay un error.
                </div>
            </div>
        </div>
    </div>

    {{-- Resumen rápido --}}
    <div class="side-card">
        <div class="side-hdr">Resumen de la orden</div>
        <div class="side-body">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="background:#f4f6f9;border-radius:3px;padding:8px 10px;">
                    <div style="font-size:10px;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">A producir</div>
                    <div style="font-size:22px;font-weight:800;font-family:'Consolas',monospace;color:#1c7c4d;" id="resumenProd">—</div>
                    <div style="font-size:10px;color:#94a3b8;">unidades</div>
                </div>
                <div style="background:#fdf1e2;border-radius:3px;padding:8px 10px;">
                    <div style="font-size:10px;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">MP a consumir</div>
                    <div style="font-size:22px;font-weight:800;font-family:'Consolas',monospace;color:#b9690e;" id="resumenConsume">—</div>
                    <div style="font-size:10px;color:#94a3b8;">unidades de MP</div>
                </div>
                <div style="background:#eff6ff;border-radius:3px;padding:8px 10px;">
                    <div style="font-size:10px;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">Ratio MP / unidad</div>
                    <div style="font-size:22px;font-weight:800;font-family:'Consolas',monospace;color:#0b5ed7;" id="resumenRatio">—</div>
                    <div style="font-size:10px;color:#94a3b8;">unidades de MP por producto</div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

</form>

<script>
function calcRatio() {
    var p = parseFloat(document.getElementById('cantProducida').value)  || 0;
    var c = parseFloat(document.getElementById('cantConsumida').value)  || 0;

    document.getElementById('resumenProd').textContent    = p > 0 ? p.toLocaleString() : '—';
    document.getElementById('resumenConsume').textContent = c > 0 ? c.toLocaleString() : '—';

    var block = document.getElementById('ratioBlock');
    if (p > 0 && c > 0) {
        var ratio = (c / p).toFixed(3);
        document.getElementById('ratioVal').textContent         = ratio;
        document.getElementById('resumenRatio').textContent     = ratio;
        block.style.display = 'flex';
    } else {
        document.getElementById('resumenRatio').textContent = '—';
        block.style.display = 'none';
    }
}
</script>