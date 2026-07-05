@extends('layouts.app')

@section('content')
@php
    $role = auth()->user()->role;
@endphp
@php
    $niveles  = [1, 2];
    $filas    = ['A', 'B'];
    $espacios = [1, 2, 3, 4];
    $slots    = [1, 2, 3, 4];
    $rotacionPorNivel = [1 => 10, 2 => 5];
    $dotColor = ['ok' => '#52c41a', 'warn' => '#faad14', 'crit' => '#ff4d4f', 'empty' => '#d0d0d0'];
@endphp

<style>
    .wh-page  { background:#f0f2f5; min-height:100vh; padding:16px; width:100%; box-sizing:border-box; }
    .wh-card  { background:white; border-radius:10px; box-shadow:0 1px 4px rgba(0,0,0,.07); width:100%; box-sizing:border-box; }

    /* KPIs */
    .wh-kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:18px; }
    .wh-kpi { padding:14px 18px; border-radius:10px; background:white; box-shadow:0 1px 4px rgba(0,0,0,.07); border-top:3px solid transparent; transition:transform .15s; }
    .wh-kpi:hover { transform:translateY(-2px); }
    .wh-kpi-label { font-size:11px; text-transform:uppercase; letter-spacing:.06em; color:#8c8c8c; margin:0; }
    .wh-kpi-value { font-size:22px; font-weight:700; margin:4px 0 0; }

    /* Tabs */
    .wh-tab-bar { display:flex; gap:2px; border-bottom:2px solid #f0f0f0; margin-bottom:20px; }
    .wh-tab { padding:8px 20px; font-size:13px; font-weight:500; color:#8c8c8c; cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-2px; transition:color .15s; }
    .wh-tab.active { color:#1890ff; border-bottom-color:#1890ff; }
    .wh-nivel { display:none; }
    .wh-nivel.active { display:block; }

    /* Fila */
    .wh-fila-label  { font-size:11px; font-weight:700; color:#8c8c8c; text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px; }
    .wh-fila-scroll { overflow-x:auto; padding-bottom:4px; margin-bottom:10px; width:100%; }
    .wh-fila-row    { display:flex; gap:12px; align-items:flex-start; flex-wrap:nowrap; min-width:max-content; width:100%; }

    /* Rack block */
    .rack-block { border:2px solid #3B5BDB; border-radius:7px; background:#f0f4ff; overflow:hidden; flex-shrink:0; min-width:130px; flex:1; }
    .rack-header { background:#3B5BDB; color:white; font-size:10px; font-weight:700; text-align:center; padding:4px 0; letter-spacing:.04em; }
    .rack-slots  { display:flex; flex-direction:column; gap:3px; padding:5px; }

    /* Slot */
    .wh-slot {
        border-radius:5px; border:1.5px solid transparent;
        padding:5px 7px; font-size:10px; font-weight:500;
        cursor:pointer; transition:transform .1s, box-shadow .1s;
        display:flex; align-items:center; gap:5px; min-height:28px;
    }
    .wh-slot:hover { transform:scale(1.04); box-shadow:0 2px 8px rgba(0,0,0,.15); z-index:2; position:relative; }
    .wh-slot.empty { background:#f5f5f5; border-color:#d0d0d0; color:#bbb; font-style:italic; }
    .wh-slot.ok    { background:#EAFBEA; border-color:#52c41a; color:#237804; }
    .wh-slot.warn  { background:#FFFBE6; border-color:#faad14; color:#ad6800; }
    .wh-slot.crit  { background:#FFF1F0; border-color:#ff4d4f; color:#a8071a; }
    .slot-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }

    /* Pasillo */
    .wh-pasillo { display:flex; align-items:center; justify-content:center; height:26px; margin:4px 0 10px;
        background:repeating-linear-gradient(90deg,#e8e8e8 0,#e8e8e8 8px,#f5f5f5 8px,#f5f5f5 16px);
        border-radius:3px; font-size:10px; color:#8c8c8c; font-weight:600; letter-spacing:.08em; width:100%; }

    /* Zona rotación */
    .zona-rot { border:2px dashed #FF9800; border-radius:8px; background:#FFF8F0; padding:8px 10px; flex-shrink:0; width:220px; min-width:220px; }
    .zona-rot-title { font-size:10px; color:#E65100; font-weight:700; text-align:center; margin-bottom:6px; white-space:nowrap; }
    .zona-rot-grid  { display:flex; flex-wrap:wrap; gap:4px; width:204px; }
    .zona-slot {
        border-radius:5px; border:1.5px solid #FF9800; background:#FFF3E0;
        color:#E65100; font-size:10px; font-weight:500;
        cursor:pointer; display:flex; align-items:center; justify-content:center;
        padding:4px 6px; min-height:28px; width:96px;
        transition:transform .1s; white-space:nowrap; width:96px; flex-shrink:0;
    }
    .zona-slot:hover { transform:scale(1.05); }
    .zona-slot.empty { background:#f5f5f5; border-color:#d0d0d0; color:#bbb; font-style:italic; }

    /* Leyenda */
    .wh-legend { display:flex; gap:14px; flex-wrap:wrap; margin-top:16px; padding:10px 14px; background:#fafafa; border-radius:8px; border:0.5px solid #f0f0f0; }
    .leg-item  { display:flex; align-items:center; gap:5px; font-size:11px; color:#595959; }
    .leg-dot   { width:12px; height:12px; border-radius:3px; flex-shrink:0; }

    /* Modal */
    .wh-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1000; align-items:center; justify-content:center; }
    .wh-overlay.open { display:flex; }
    .wh-modal { background:white; border-radius:14px; width:400px; max-width:95vw; max-height:90vh; overflow-y:auto;
        box-shadow:0 20px 60px rgba(0,0,0,.2); animation:mIn .16s ease; }
    @keyframes mIn { from{transform:scale(.95);opacity:0} to{transform:scale(1);opacity:1} }
    .wh-modal-hd { padding:16px 20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; }
    .wh-modal-bd { padding:20px; }
    .wh-modal-ft { padding:14px 20px; border-top:1px solid #f0f0f0; display:flex; gap:8px; justify-content:flex-end; }
    .wh-info-panel { background:#f8faff; border-radius:8px; padding:12px; margin-bottom:16px; }
    .wh-info-row   { display:flex; justify-content:space-between; font-size:12px; padding:5px 0; border-bottom:1px solid #f0f0f0; }
    .wh-info-row:last-child { border:none; }
    .wh-info-label { color:#8c8c8c; }
    .wh-info-val   { font-weight:600; color:#1a1a2e; }
    .m-label  { font-size:11px; font-weight:600; color:#595959; display:block; margin:12px 0 4px; }
    .m-label:first-child { margin-top:0; }
    .m-select, .m-input  { width:100%; padding:9px 11px; border:1px solid #e2e8f0; border-radius:7px; font-size:13px; outline:none; background:white; }
    .m-select:focus, .m-input:focus { border-color:#1890ff; }
    .m-textarea { width:100%; padding:9px 11px; border:1px solid #e2e8f0; border-radius:7px; font-size:13px; outline:none; resize:none; }
    .wh-btn { padding:9px 16px; border:none; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer; transition:opacity .15s; }
    .wh-btn:hover { opacity:.85; }
    .wh-btn-primary { background:#1890ff; color:white; }
    .wh-btn-danger  { background:#ff4d4f; color:white; }
    .wh-btn-ghost   { background:#f0f0f0; color:#595959; }
    .wh-toast { position:fixed; bottom:24px; right:24px; background:#1a1a2e; color:white; padding:12px 20px; border-radius:8px; font-size:13px; z-index:2000; opacity:0; transform:translateY(10px); transition:all .25s; pointer-events:none; }
    .wh-toast.show { opacity:1; transform:translateY(0); }

    @media (max-width:900px) {
        .wh-kpi-grid { grid-template-columns:repeat(2,1fr) !important; }
    }
</style>

<div class="wh-page">

    {{-- HEADER --}}
    <div class="wh-card" style="padding:16px 22px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;border-left:5px solid #1890ff;flex-wrap:wrap;gap:10px;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:#e6f0ff;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">🏭</div>
            <div>
                <h1 style="font-size:20px;font-weight:700;margin:0;color:#1a1a2e;">Plano del Almacén</h1>
                <p style="font-size:12px;color:#8c8c8c;margin:2px 0 0;">Vista interactiva · Haz clic en cualquier slot para asignar un producto</p>
            </div>
        </div>
        <span style="font-size:12px;color:#8c8c8c;">🕒 {{ now()->format('d/m/Y H:i') }}</span>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
    <div style="background:#f6ffed;border:1px solid #b7eb8f;border-radius:8px;padding:12px 18px;margin-bottom:16px;color:#237804;font-size:13px;font-weight:500;">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- KPIs --}}
    <div class="wh-kpi-grid">
        <div class="wh-kpi" style="border-top-color:#1890ff;">
            <p class="wh-kpi-label">Total slots</p>
            <p class="wh-kpi-value" style="color:#1890ff;">{{ $totalSlots }}</p>
        </div>
        <div class="wh-kpi" style="border-top-color:#52c41a;">
            <p class="wh-kpi-label">Ocupados</p>
            <p class="wh-kpi-value" style="color:#52c41a;">{{ $ocupados }}</p>
        </div>
        <div class="wh-kpi" style="border-top-color:#bfbfbf;">
            <p class="wh-kpi-label">Libres</p>
            <p class="wh-kpi-value" style="color:#bfbfbf;">{{ $libres }}</p>
        </div>
        <div class="wh-kpi" style="border-top-color:#722ed1;">
            <p class="wh-kpi-label">Productos distintos</p>
            <p class="wh-kpi-value" style="color:#722ed1;">{{ $productosDistintos }}</p>
        </div>
    </div>

    {{-- PLANO --}}
    <div class="wh-card" style="padding:20px;">

        {{-- Tabs --}}
        <div class="wh-tab-bar">
            @foreach($niveles as $n)
            <div class="wh-tab {{ $n === 1 ? 'active' : '' }}" onclick="showNivel({{ $n }}, this)">
                Nivel {{ $n }}
            </div>
            @endforeach
        </div>

        @foreach($niveles as $nivel)
        <div class="wh-nivel {{ $nivel === 1 ? 'active' : '' }}" id="nivel{{ $nivel }}">

            @foreach($filas as $fila)

            <div class="wh-fila-label">Fila {{ $fila }}</div>

            {{-- Scroll wrapper: evita que la zona naranja baje --}}
            <div class="wh-fila-scroll">
            <div class="wh-fila-row">

                {{-- 4 espacios de rack --}}
                @foreach($espacios as $espacio)
                @php $eLabel = $fila . $espacio; @endphp
                <div class="rack-block">
                    <div class="rack-header">Espacio {{ $eLabel }}</div>
                    <div class="rack-slots">
                        @foreach($slots as $slot)
                        @php
                            $cell   = $racks->get("{$nivel}-{$fila}-{$espacio}-{$slot}");
                            $estado = $cell ? $cell->color_estado : 'empty';
                            $etiq   = $cell ? $cell->etiqueta     : '— libre';
                            $cid    = $cell ? $cell->id           : '';
                            $dot    = $dotColor[$estado]          ?? '#d0d0d0';
                            $prod   = $cell ? $cell->product      : null;
                        @endphp
                        <div
                            class="wh-slot {{ $estado }}"
                            id="slot-{{ $cid }}"
                            data-id="{{ $cid }}"
                            data-label="Nivel {{ $nivel }} · Esp. {{ $eLabel }} · Slot {{ $slot }}"
                            data-product-id="{{ optional($prod)->id }}"
                            data-product-nombre="{{ optional($prod)->nombre }}"
                            data-product-sku="{{ optional($prod)->sku }}"
                            data-product-stock="{{ optional($prod)->stock }}"
                            data-product-stock-min="{{ optional($prod)->stock_minimo }}"
                            data-product-lote="{{ optional($prod)->lote }}"
                            data-product-vence="{{ optional($prod)->fecha_vencimiento }}"
                            data-product-marca="{{ optional($prod)->marca }}"
                            data-cantidad="{{ $cell ? $cell->cantidad : 0 }}"
                            data-obs="{{ $cell ? $cell->observaciones : '' }}"
                            onclick="openModal(this)"
                        >
                            <div class="slot-dot" style="background:{{ $dot }};"></div>
                            <span style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:100px;">{{ $etiq }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                {{-- Zona poca rotación — solo en Fila A, al lado de los racks --}}
                @if($fila === 'A')
                @php $totalRot = $rotacionPorNivel[$nivel]; @endphp
                <div class="zona-rot">
                    <div class="zona-rot-title">🟠 Poca rotación · N{{ $nivel }} ({{ $totalRot }})</div>
                    <div class="zona-rot-grid">
                        @for($rSlot = 1; $rSlot <= $totalRot; $rSlot++)
                        @php
                            $rCell  = $rotacion->get("{$nivel}-{$rSlot}");
                            $rEstado = ($rCell && $rCell->product_id) ? 'ok' : 'empty';
                            $rProd  = $rCell ? $rCell->product : null;
                        @endphp
                        <div
                            class="zona-slot {{ $rEstado }}"
                            data-id="{{ $rCell ? $rCell->id : '' }}"
                            data-label="Rotación N{{ $nivel }} · Esp. {{ $rSlot }}"
                            data-product-id="{{ optional($rProd)->id }}"
                            data-product-nombre="{{ optional($rProd)->nombre }}"
                            data-product-sku="{{ optional($rProd)->sku }}"
                            data-product-stock="{{ optional($rProd)->stock }}"
                            data-product-stock-min="{{ optional($rProd)->stock_minimo }}"
                            data-product-lote="{{ optional($rProd)->lote }}"
                            data-product-vence="{{ optional($rProd)->fecha_vencimiento }}"
                            data-product-marca="{{ optional($rProd)->marca }}"
                            data-cantidad="{{ $rCell ? $rCell->cantidad : 0 }}"
                            data-obs="{{ $rCell ? $rCell->observaciones : '' }}"
                            onclick="openModal(this)"
                        >
                            ZR{{ $rSlot }} · {{ \Str::limit(optional($rProd)->nombre ?? 'libre', 8) }}
                        </div>
                        @endfor
                    </div>
                </div>
                @endif

            </div>{{-- /.wh-fila-row --}}
            </div>{{-- /.wh-fila-scroll --}}

            {{-- Pasillo entre Fila A y Fila B --}}
            @if(!$loop->last)
            <div class="wh-pasillo">← &nbsp; PASILLO CENTRAL &nbsp; →</div>
            @endif

            @endforeach

        </div>{{-- /.wh-nivel --}}
        @endforeach

        {{-- Leyenda --}}
        <div class="wh-legend">
            <div class="leg-item"><div class="leg-dot" style="background:#EAFBEA;border:1.5px solid #52c41a;"></div>Stock OK</div>
            <div class="leg-item"><div class="leg-dot" style="background:#FFFBE6;border:1.5px solid #faad14;"></div>Stock bajo</div>
            <div class="leg-item"><div class="leg-dot" style="background:#FFF1F0;border:1.5px solid #ff4d4f;"></div>Sin stock</div>
            <div class="leg-item"><div class="leg-dot" style="background:#FFF3E0;border:1.5px solid #FF9800;"></div>Poca rotación</div>
            <div class="leg-item"><div class="leg-dot" style="background:#f5f5f5;border:1.5px solid #d0d0d0;"></div>Libre</div>
        </div>

    </div>{{-- /.wh-card --}}
</div>{{-- /.wh-page --}}

{{-- MODAL --}}
<div class="wh-overlay" id="whOverlay" onclick="closeOnOverlay(event)">
    <div class="wh-modal">
        <div class="wh-modal-hd">
            <div>
                <p style="font-weight:700;font-size:15px;margin:0;color:#1a1a2e;" id="mTitle"></p>
                <p style="font-size:12px;color:#8c8c8c;margin:2px 0 0;" id="mSub"></p>
            </div>
            <button onclick="closeModal()" style="background:none;border:none;font-size:20px;cursor:pointer;color:#8c8c8c;padding:2px 6px;">✕</button>
        </div>
        <div class="wh-modal-bd">
            <div id="mInfoPanel" class="wh-info-panel" style="display:none;">
                <div class="wh-info-row"><span class="wh-info-label">🏷️ Producto</span>   <span class="wh-info-val" id="iProd"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">🔖 SKU</span>          <span class="wh-info-val" id="iSku"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">🏢 Marca</span>        <span class="wh-info-val" id="iMarca"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">📦 Stock global</span> <span class="wh-info-val" id="iStock"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">⚠️ Stock mínimo</span> <span class="wh-info-val" id="iMin"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">🔢 Lote</span>         <span class="wh-info-val" id="iLote"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">📅 Vencimiento</span>  <span class="wh-info-val" id="iVence"></span></div>
                <div class="wh-info-row"><span class="wh-info-label">📍 Cant. en slot</span><span class="wh-info-val" id="iCant"></span></div>
            </div>
            <div id="mEmptyMsg" style="text-align:center;padding:16px 0;color:#bfbfbf;font-size:13px;display:none;">
                📭 Slot vacío — sin producto asignado
            </div>
            <label class="m-label">Asignar producto</label>
            <select class="m-select" id="mProdSelect">
                <option value="">— Dejar vacío —</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}"
                    data-nombre="{{ $p->nombre }}"
                    data-stock="{{ $p->stock }}"
                    data-sku="{{ $p->sku }}"
                    data-marca="{{ $p->marca }}"
                    data-min="{{ $p->stock_minimo }}"
                    data-lote="{{ $p->lote }}"
                    data-vence="{{ $p->fecha_vencimiento }}">
                    {{ $p->nombre }}@if($p->sku) ({{ $p->sku }})@endif · Stock: {{ $p->stock }}
                </option>
                @endforeach
            </select>
            
            <label class="m-label">Cantidad en este slot</label>
            <input type="number" class="m-input" id="mCantidad" placeholder="0" min="0" style="margin-top:0;">
            <label class="m-label">Observaciones</label>
            <textarea class="m-textarea" id="mObs" rows="2" placeholder="Opcional..."></textarea>
            
        </div>
        
        <div class="wh-modal-ft">
            <button class="wh-btn wh-btn-ghost"  onclick="closeModal()">Cancelar</button>
            <button class="wh-btn wh-btn-danger"  id="mBtnClear" onclick="clearSlot()">🗑 Vaciar</button>
            @if($role == 'admin')
            <button class="wh-btn wh-btn-primary" onclick="saveSlot()">💾 Guardar</button>
            @endif
        </div>
        
    </div>
</div>

<div class="wh-toast" id="whToast"></div>

<script>
const CSRF    = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const BASE_URL = '{{ rtrim(config("app.url"), "/") }}';
let currentEl = null;

function showNivel(n, el) {
    document.querySelectorAll('.wh-nivel').forEach(d => d.classList.remove('active'));
    document.querySelectorAll('.wh-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('nivel' + n).classList.add('active');
    el.classList.add('active');
}

function openModal(el) {
    currentEl = el;
    const d = el.dataset;
    const hasProduct = !!d.productId;
    document.getElementById('mTitle').textContent = d.label;
    document.getElementById('mSub').textContent   = hasProduct ? '📦 ' + d.productNombre : 'Slot vacío';
    document.getElementById('mInfoPanel').style.display = hasProduct ? 'block' : 'none';
    document.getElementById('mEmptyMsg').style.display  = hasProduct ? 'none'  : 'block';
    document.getElementById('mBtnClear').style.display  = hasProduct ? 'inline-block' : 'none';
    if (hasProduct) {
        document.getElementById('iProd').textContent  = d.productNombre   || '—';
        document.getElementById('iSku').textContent   = d.productSku      || '—';
        document.getElementById('iMarca').textContent = d.productMarca    || '—';
        document.getElementById('iStock').textContent = (d.productStock   || '0') + ' u.';
        document.getElementById('iMin').textContent   = (d.productStockMin|| '—') + ' u.';
        document.getElementById('iLote').textContent  = d.productLote     || '—';
        document.getElementById('iVence').textContent = d.productVence    || '—';
        document.getElementById('iCant').textContent  = (d.cantidad       || '0') + ' u.';
    }
    document.getElementById('mProdSelect').value = d.productId || '';
    document.getElementById('mCantidad').value   = d.cantidad  || '';
    document.getElementById('mObs').value        = d.obs       || '';
    document.getElementById('whOverlay').classList.add('open');
}

function closeModal()        { document.getElementById('whOverlay').classList.remove('open'); }
function closeOnOverlay(e)   { if (e.target.id === 'whOverlay') closeModal(); }

function postForm(action, fields) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = action;
    form.style.display = 'none';
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden'; csrfInput.name = '_token'; csrfInput.value = CSRF;
    form.appendChild(csrfInput);
    Object.entries(fields).forEach(([key, val]) => {
        const input = document.createElement('input');
        input.type = 'hidden'; input.name = key; input.value = val ?? '';
        form.appendChild(input);
    });
    document.body.appendChild(form);
    form.submit();
}

async function saveSlot() {

    const id = currentEl?.dataset?.id;

    if (!id) {
        showToast('❌ Slot sin ID');
        return;
    }

    const productId = document.getElementById('mProdSelect').value;
    const cantidad  = document.getElementById('mCantidad').value;
    const obs       = document.getElementById('mObs').value;

    try {

        const response = await fetch(`/warehouse/${id}/assign`, {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'Accept': 'application/json',

                'X-CSRF-TOKEN': CSRF

            },

            body: JSON.stringify({

                product_id: productId || null,

                cantidad: cantidad,

                observaciones: obs

            })

        });

        const data = await response.json();

        if(data.success){

            showToast('✅ ' + data.message);

            closeModal();

            setTimeout(function(){

                location.reload();

            },500);

        }else{

            showToast('❌ Error al guardar');

        }

    }catch(e){

        console.error(e);

        showToast('❌ Error de conexión');

    }

}

function clearSlot() {
    const id = currentEl?.dataset?.id;
    if (!id || !confirm('¿Vaciar este slot?')) return;
    postForm(`/warehouse/${id}/clear`, { _method: 'DELETE' });
}

function updateSlotUI(el, data) {
    const colorMap = { ok:'#52c41a', warn:'#faad14', crit:'#ff4d4f', empty:'#d0d0d0' };
    const estado   = data.color_estado ?? 'empty';
    const etiqueta = data.etiqueta ?? '— libre';
    const p        = data.product;
    const isZona   = el.classList.contains('zona-slot');

    el.className = isZona
        ? `zona-slot ${estado === 'empty' ? 'empty' : ''}`
        : `wh-slot ${estado}`;

    el.innerHTML = isZona
        ? etiqueta
        : `<div class="slot-dot" style="background:${colorMap[estado]};width:7px;height:7px;border-radius:50%;flex-shrink:0;"></div>
           <span style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;max-width:100px;">${etiqueta}</span>`;

    if (p) {
        Object.assign(el.dataset, {
            productId: p.id ?? '', productNombre: p.nombre ?? '', productSku: p.sku ?? '',
            productStock: p.stock ?? '', productStockMin: p.stock_minimo ?? '',
            productLote: p.lote ?? '', productVence: p.fecha_vencimiento ?? '', productMarca: p.marca ?? ''
        });
    } else {
        el.dataset.productId = '';
        el.dataset.productNombre = '';
    }
    el.dataset.cantidad = document.getElementById('mCantidad').value;
    el.dataset.obs      = document.getElementById('mObs').value;
}

function showToast(msg) {
    const t = document.getElementById('whToast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}
</script>

@endsection