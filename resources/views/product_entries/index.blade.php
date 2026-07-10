@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#eef1f5; --erp-surface:#fff; --erp-border:#dde2ea;
    --erp-ink:#1c2733; --erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7; --erp-accent-dark:#0a4eb3;
    --erp-danger:#c0312b; --erp-danger-bg:#fbe9e8;
    --erp-warn:#b9690e; --erp-warn-bg:#fdf1e2;
    --erp-ok:#1c7c4d; --erp-ok-bg:#e8f5ee;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);min-height:100vh;font-size:13px;}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-ok);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}

/* KPIs */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:26px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:22px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Layout */
.main-layout{display:grid;grid-template-columns:1fr 340px;gap:14px;align-items:start;}
@media(max-width:960px){.main-layout{grid-template-columns:1fr;}}

/* Alerts */
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:9px 14px;font-size:12px;font-weight:500;margin-bottom:.85rem;display:flex;align-items:center;gap:8px;}
.alert-err{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;font-size:12px;margin-bottom:.85rem;}

/* Cards */
.erp-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;margin-bottom:14px;}
.erp-card-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.65rem 1rem;display:flex;align-items:center;justify-content:space-between;gap:8px;}
.erp-card-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:6px;}
.erp-card-body{padding:1rem;}

/* Filtros */
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end;padding:.75rem 1rem;background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:1rem;}
.fgroup{display:flex;flex-direction:column;gap:3px;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.ftarea{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);resize:vertical;min-height:70px;}

/* Qty input especial */
.finput-qty{padding:12px;border:2px solid #b7dfca;border-radius:3px;font-size:26px;font-weight:900;text-align:center;outline:none;width:100%;font-family:var(--font-mono);color:var(--erp-ok);background:var(--erp-ok-bg);transition:border-color .15s;}
.finput-qty:focus{border-color:var(--erp-ok);box-shadow:0 0 0 2px rgba(28,124,77,.15);}

/* Botones */
.btn{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:background .15s;}
.btn:hover{opacity:.88;}
.btn-ok{background:var(--erp-ok);color:#fff;}
.btn-ghost{background:#fff;color:var(--erp-ink-muted);border:1px solid var(--erp-border);}
.btn-accent{background:var(--erp-accent);color:#fff;}

/* Tabla historial */
.hist-table{width:100%;border-collapse:collapse;font-size:12px;}
.hist-table th{background:#f4f6f9;color:var(--erp-ink-muted);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:8px 10px;text-align:left;border-bottom:2px solid var(--erp-border);white-space:nowrap;}
.hist-table td{padding:9px 10px;border-bottom:1px solid #f1f5f9;color:var(--erp-ink);vertical-align:middle;}
.hist-table tr:hover td{background:#f9fafb;}
.hist-table tfoot td{background:#f0f9f4;font-weight:700;color:var(--erp-ok);border-top:2px solid #b7dfca;padding:9px 10px;}

/* Badge entrada */
.badge-entrada{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:3px;background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}

/* Stock before/after */
.stock-arrow{color:#94a3b8;font-size:11px;margin:0 3px;}

/* Paginador */
.pager{display:flex;gap:4px;align-items:center;padding:10px 14px;border-top:1px solid var(--erp-border);flex-wrap:wrap;}
.pager a,.pager span{padding:5px 10px;border:1px solid var(--erp-border);border-radius:3px;font-size:11px;text-decoration:none;color:var(--erp-ink-muted);}
.pager a:hover{background:#f4f6f9;}
.pager .pg-active{background:var(--erp-accent);color:#fff;border-color:var(--erp-accent);font-weight:700;}
.pager .pg-disabled{color:#d0d0d0;cursor:default;}

/* Stock preview en form */
.stock-preview{background:#f4f6f9;border:1px solid var(--erp-border);border-radius:3px;padding:8px 10px;font-size:12px;display:flex;justify-content:space-between;align-items:center;margin-top:6px;}
.stock-preview-val{font-family:var(--font-mono);font-size:16px;font-weight:800;}

/* Info row */
.info-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #f1f5f9;font-size:12px;color:var(--erp-ink-muted);}
.info-row:last-child{border-bottom:none;}
.info-val{font-weight:600;color:var(--erp-ink);}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Tienda · Entradas</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Inventario › Entradas de Productos</span>
</div>

<div class="body">

{{-- Alertas --}}
@if(session('success'))
<div class="alert-ok">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert-err">
    ⚠️ <strong>Errores:</strong>
    <ul style="margin:.4rem 0 0 1rem;padding:0;">
        @foreach($errors->all() as $e)<li style="font-size:11px;">{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

{{-- Header --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Entradas de productos al stock</div>
        <div class="page-sub">Registra productos listos para distribución · El stock se actualiza automáticamente</div>
    </div>
</div>

{{-- KPIs --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-ok);">
        <div class="kpi-icon">📥</div>
        <div class="kpi-label">Total entradas</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ number_format($totalEntradas) }}</div>
        <div class="kpi-sub">registros históricos</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Unidades ingresadas</div>
        <div class="kpi-val" style="color:var(--erp-accent);">{{ number_format($totalUnidades) }}</div>
        <div class="kpi-sub">acumulado total</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">🌅</div>
        <div class="kpi-label">Ingresado hoy</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ number_format($hoy) }}</div>
        <div class="kpi-sub">unidades del día</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">🏷️</div>
        <div class="kpi-label">Productos activos</div>
        <div class="kpi-val" style="color:#7c3aed;">{{ $productosActivos }}</div>
        <div class="kpi-sub">disponibles para entrada</div>
    </div>
</div>

{{-- Layout --}}
<div class="main-layout">

    {{-- ── IZQUIERDA: historial ── --}}
    <div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('product-entries.index') }}">
        <div class="filter-bar">
            <div class="fgroup">
                <span class="flabel">Producto</span>
                <select name="product_id" class="fselect" style="min-width:200px;">
                    <option value="">Todos los productos</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre }} @if($p->sku)({{ $p->sku }})@endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="fgroup">
                <span class="flabel">Desde</span>
                <input type="date" name="date_from" class="finput" value="{{ request('date_from') }}">
            </div>
            <div class="fgroup">
                <span class="flabel">Hasta</span>
                <input type="date" name="date_to" class="finput" value="{{ request('date_to') }}">
            </div>
            <button type="submit" class="btn btn-accent" style="align-self:flex-end;">🔍 Filtrar</button>
            <a href="{{ route('product-entries.index') }}" class="btn btn-ghost" style="align-self:flex-end;">✕ Limpiar</a>
        </div>
        </form>

        {{-- Tabla historial --}}
        <div class="erp-card">
            <div class="erp-card-hdr">
                <div class="erp-card-title">📋 Historial de entradas</div>
                <span style="font-size:11px;color:var(--erp-ink-muted);">{{ $entries->total() }} registros</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="hist-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Lote</th>
                            <th>Proveedor</th>
                            <th style="text-align:right;">Cantidad</th>
                            <th>Stock</th>
                            <th>Vencimiento</th>
                            <th>Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $entry)
                        <tr>
                            <td style="white-space:nowrap;color:var(--erp-ink-muted);font-size:11px;">
                                {{ $entry->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div style="font-weight:600;color:var(--erp-ink);">
                                    {{ $entry->product->nombre ?? '—' }}
                                </div>
                                @if($entry->product->sku)
                                <div style="font-size:10px;color:#94a3b8;font-family:var(--font-mono);">
                                    {{ $entry->product->sku }}
                                </div>
                                @endif
                            </td>
                            <td style="font-family:var(--font-mono);font-size:11px;color:var(--erp-ink-muted);">
                                {{ $entry->lote ?? '—' }}
                            </td>
                            <td style="font-size:12px;">{{ $entry->supplier ?? '—' }}</td>
                            <td style="text-align:right;">
                                <span class="badge-entrada">+{{ number_format($entry->quantity) }}</span>
                            </td>
                            <td style="white-space:nowrap;font-size:11px;">
                                <span style="color:var(--erp-ink-muted);">{{ number_format($entry->stock_before) }}</span>
                                <span class="stock-arrow">→</span>
                                <span style="font-weight:700;color:var(--erp-ok);">{{ number_format($entry->stock_after) }}</span>
                            </td>
                            <td style="font-size:11px;color:var(--erp-ink-muted);">
                                {{ $entry->fecha_vencimiento ? $entry->fecha_vencimiento->format('d/m/Y') : '—' }}
                            </td>
                            <td style="font-size:11px;color:var(--erp-ink-muted);">
                                {{ optional($entry->user)->name ?? 'Sistema' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:32px;color:#94a3b8;">
                                <div style="font-size:28px;margin-bottom:6px;">📭</div>
                                Sin entradas registradas aún
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($entries->total() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;color:var(--erp-ink-muted);">
                                TOTAL UNIDADES (esta vista)
                            </td>
                            <td style="text-align:right;">
                                +{{ number_format($entries->sum('quantity')) }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- Paginador --}}
            @if($entries->hasPages())
            <div class="pager">
                <span style="font-size:11px;color:var(--erp-ink-muted);margin-right:4px;">
                    {{ $entries->firstItem() }}–{{ $entries->lastItem() }} de {{ $entries->total() }}
                </span>

                @if($entries->onFirstPage())
                    <span class="pg-disabled">‹ Ant.</span>
                @else
                    <a href="{{ $entries->previousPageUrl() }}">‹ Ant.</a>
                @endif

                @foreach($entries->getUrlRange(max(1,$entries->currentPage()-2), min($entries->lastPage(),$entries->currentPage()+2)) as $page => $url)
                    @if($page == $entries->currentPage())
                        <span class="pg-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($entries->hasMorePages())
                    <a href="{{ $entries->nextPageUrl() }}">Sig. ›</a>
                @else
                    <span class="pg-disabled">Sig. ›</span>
                @endif
            </div>
            @endif
        </div>

    </div>{{-- /.left --}}

    {{-- ── DERECHA: formulario ── --}}
    <div>
        <div class="erp-card">
            <div class="erp-card-hdr" style="background:#e8f5ee;border-color:#b7dfca;">
                <div class="erp-card-title" style="color:var(--erp-ok);">📥 Registrar nueva entrada</div>
            </div>
            <div class="erp-card-body">
                <form method="POST" action="{{ route('product-entries.store') }}" id="entryForm">
                    @csrf

                    {{-- Producto --}}
                    <div style="margin-bottom:10px;">
                        <label class="flabel">Producto <span style="color:var(--erp-danger);">*</span></label>
                        <select name="product_id" class="fselect" style="width:100%;margin-top:3px;"
                            required onchange="actualizarStockPreview(this)">
                            <option value="">Seleccione un producto...</option>
                            @foreach($products as $p)
                            <option value="{{ $p->id }}"
                                data-stock="{{ $p->stock }}"
                                data-nombre="{{ $p->nombre }}"
                                data-sku="{{ $p->sku }}"
                                data-lote="{{ $p->lote }}"
                                data-vence="{{ $p->fecha_vencimiento }}">
                                {{ $p->nombre }}
                                @if($p->sku)({{ $p->sku }})@endif
                                · Stock: {{ $p->stock }}
                            </option>
                            @endforeach
                        </select>

                        {{-- Preview stock actual --}}
                        <div class="stock-preview" id="stockPreview" style="display:none;">
                            <span style="color:var(--erp-ink-muted);">Stock actual</span>
                            <span class="stock-preview-val" id="stockActual" style="color:var(--erp-ok);">—</span>
                        </div>
                    </div>

                    {{-- Cantidad --}}
                    <div style="margin-bottom:10px;">
                        <label class="flabel">Cantidad a ingresar <span style="color:var(--erp-danger);">*</span></label>
                        <input type="number" step="0.01" name="quantity" id="cantidadInput"
                            class="finput-qty" placeholder="0" required min="0.01"
                            value="{{ old('quantity') }}"
                            oninput="calcularNuevoStock()">
                        {{-- Nuevo stock calculado --}}
                        <div class="stock-preview" id="nuevoStockPreview" style="display:none;">
                            <span style="color:var(--erp-ink-muted);">Nuevo stock</span>
                            <span class="stock-preview-val" id="nuevoStock" style="color:var(--erp-accent);">—</span>
                        </div>
                    </div>

                    {{-- Proveedor --}}
                    <div style="margin-bottom:10px;">
                        <label class="flabel">Proveedor</label>
                        <input type="text" name="supplier" class="finput" style="margin-top:3px;"
                            value="{{ old('supplier') }}" placeholder="Nombre del proveedor...">
                    </div>

                    {{-- Lote y Vencimiento --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px;">
                        <div>
                            <label class="flabel">Lote</label>
                            <input type="text" name="lote" class="finput" id="loteInput"
                                style="margin-top:3px;font-family:var(--font-mono);"
                                value="{{ old('lote') }}" placeholder="Ej: LOT-001">
                        </div>
                        <div>
                            <label class="flabel">Fecha vencimiento</label>
                            <input type="date" name="fecha_vencimiento" class="finput" id="venceInput"
                                style="margin-top:3px;" value="{{ old('fecha_vencimiento') }}">
                        </div>
                    </div>

                    {{-- Observación --}}
                    <div style="margin-bottom:14px;">
                        <label class="flabel">Observación</label>
                        <textarea name="observation" class="ftarea" style="margin-top:3px;"
                            placeholder="Guía de remisión, notas de recepción...">{{ old('observation') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-ok" style="width:100%;justify-content:center;font-size:13px;padding:10px;">
                        📥 Registrar entrada al stock
                    </button>
                </form>
            </div>
        </div>

        {{-- Info del producto seleccionado --}}
        <div class="erp-card" id="productInfoCard" style="display:none;">
            <div class="erp-card-hdr">
                <div class="erp-card-title">📦 Producto seleccionado</div>
            </div>
            <div class="erp-card-body">
                <div class="info-row"><span>Nombre</span><span class="info-val" id="infoNombre">—</span></div>
                <div class="info-row"><span>SKU</span><span class="info-val" style="font-family:var(--font-mono);" id="infoSku">—</span></div>
                <div class="info-row"><span>Lote actual</span><span class="info-val" style="font-family:var(--font-mono);" id="infoLote">—</span></div>
                <div class="info-row"><span>Vencimiento actual</span><span class="info-val" id="infoVence">—</span></div>
                <div class="info-row"><span>Stock actual</span><span class="info-val" style="color:var(--erp-ok);" id="infoStock">—</span></div>
            </div>
        </div>

    </div>{{-- /.right --}}

</div>{{-- /.main-layout --}}
</div>{{-- /.body --}}
</div>{{-- /.page --}}

<script>
let stockActualVal = 0;

function actualizarStockPreview(select) {
    const opt = select.options[select.selectedIndex];
    if (!select.value) {
        document.getElementById('stockPreview').style.display = 'none';
        document.getElementById('nuevoStockPreview').style.display = 'none';
        document.getElementById('productInfoCard').style.display = 'none';
        stockActualVal = 0;
        return;
    }

    stockActualVal = parseFloat(opt.dataset.stock) || 0;

    // Stock preview
    document.getElementById('stockActual').textContent = stockActualVal.toLocaleString() + ' u.';
    document.getElementById('stockPreview').style.display = 'flex';

    // Info card
    document.getElementById('infoNombre').textContent = opt.dataset.nombre || '—';
    document.getElementById('infoSku').textContent    = opt.dataset.sku    || '—';
    document.getElementById('infoLote').textContent   = opt.dataset.lote   || '—';
    document.getElementById('infoVence').textContent  = opt.dataset.vence  || '—';
    document.getElementById('infoStock').textContent  = stockActualVal.toLocaleString() + ' u.';
    document.getElementById('productInfoCard').style.display = 'block';

    // Pre-llenar lote y vencimiento si el producto los tiene
    if (opt.dataset.lote  && !document.getElementById('loteInput').value)
        document.getElementById('loteInput').value  = opt.dataset.lote;
    if (opt.dataset.vence && !document.getElementById('venceInput').value)
        document.getElementById('venceInput').value = opt.dataset.vence;

    calcularNuevoStock();
}

function calcularNuevoStock() {
    const cant = parseFloat(document.getElementById('cantidadInput').value) || 0;
    if (cant <= 0 || stockActualVal === null) {
        document.getElementById('nuevoStockPreview').style.display = 'none';
        return;
    }
    const nuevo = stockActualVal + cant;
    document.getElementById('nuevoStock').textContent = nuevo.toLocaleString() + ' u.';
    document.getElementById('nuevoStockPreview').style.display = 'flex';
}
</script>

@endsection