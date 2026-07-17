@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}

/* ── ERP Shell ── */
.erp-bar{background:#1e3a5f;padding:0 1.25rem;height:40px;display:flex;align-items:center;justify-content:space-between;margin:-20px -20px 0;}
.erp-bar-title{color:#7eb8f7;font-size:13px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}
.erp-user{font-size:11px;color:#7eb8f7;background:#152d4d;padding:3px 10px;border-radius:4px;}
.pg{padding:1rem;background:#e8ecf0;min-height:100vh;}

/* ── Header ── */
.order-header{background:#fff;border:1px solid #c9d4e0;border-top:4px solid #1e3a5f;border-radius:4px;padding:.85rem 1.1rem;margin-bottom:.85rem;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;}
.order-id{font-size:16px;font-weight:700;color:#1e3a5f;}
.order-sub{font-size:11px;color:#64748b;margin-top:2px;}
.status-chip{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:3px;font-size:11px;font-weight:700;letter-spacing:.05em;}

/* ── KPIs ── */
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:.85rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #c9d4e0;border-radius:4px;padding:.7rem .9rem;border-left:4px solid;}
.kpi-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:19px;font-weight:700;line-height:1;color:#1e293b;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:2px;}

/* ── Layout ── */
.layout{display:grid;grid-template-columns:1fr 290px;gap:10px;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}
.left-col{display:flex;flex-direction:column;gap:10px;}

/* ── Panel ── */
.panel{background:#fff;border:1px solid #c9d4e0;border-radius:4px;}
.panel-header{background:#f1f5f9;border-bottom:1px solid #c9d4e0;padding:.6rem 1rem;display:flex;align-items:center;justify-content:space-between;}
.panel-title{font-size:12px;font-weight:700;color:#1e3a5f;text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:6px;}
.panel-body{padding:.9rem 1rem;}

/* ── Scanner ── */
.scanner-erp{
    background:#0f172a;
    border-radius:4px;
    padding:.45rem .7rem;
    display:flex;
    align-items:center;
    gap:8px;
    border:1px solid #334155;
    width:100%;
    overflow:hidden;
}
.scan-led{width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:blink 1.4s infinite;}
@keyframes blink{0%,100%{opacity:1;}50%{opacity:.2;}}
.scan-input{
    flex:1;
    min-width:0;
    padding:6px 10px;
    border-radius:4px;
    border:1px solid #334155;
    background:#1e293b;
    color:#fff;
    font-size:13px;
    outline:none;
    font-family:'Courier New', monospace;
    letter-spacing:1px;
}
.scan-input:focus{border-color:#3b82f6;}
.scan-input::placeholder{color:#334155;font-size:12px;letter-spacing:0;font-family:'Segoe UI',sans-serif;}

/* ── Form agregar producto ── */
.add-grid{
    display:grid;
    grid-template-columns:2fr 1fr 1fr auto;
    gap:7px;
    align-items:end;
}
@media(max-width:900px){
    .add-grid{grid-template-columns:1fr 1fr;gap:8px;}
    .add-grid > div:first-child{grid-column:1 / -1;}
    .add-grid > button{grid-column:1 / -1;width:100%;justify-content:center;}
}
@media(max-width:480px){
    .add-grid{grid-template-columns:1fr;gap:8px;}
    .add-grid > div:first-child,
    .add-grid > button{grid-column:1 / -1;}
}

.flabel{font-size:10px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #c9d4e0;border-radius:3px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#1e3a5f;box-shadow:0 0 0 2px rgba(30,58,95,.1);}

/* ── Tabla ERP ── */
.erp-table{width:100%;border-collapse:collapse;font-size:12px;}
.erp-table th{background:#f1f5f9;color:#475569;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;padding:7px 10px;border-bottom:2px solid #c9d4e0;text-align:left;white-space:nowrap;}
.erp-table td{padding:7px 10px;border-bottom:1px solid #f1f5f9;color:#1e293b;vertical-align:middle;}
.erp-table tbody tr:hover td{background:#f8fafc;}
.erp-table .num-input{padding:5px 7px;border:1px solid #c9d4e0;border-radius:3px;font-size:12px;width:75px;text-align:center;background:#fff;outline:none;}
.erp-table .num-input:focus{border-color:#1e3a5f;}
.erp-table .num-input:disabled{background:#f8fafc;color:#94a3b8;border-color:#e2e8f0;}
.state-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:4px;}
.mini-bar{width:60px;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;display:inline-block;vertical-align:middle;}
.mini-fill{height:100%;border-radius:99px;}

/* ── Scroll hint solo en móvil ── */
.scroll-hint-mobile{
    display:none;
    font-size:10px;color:#94a3b8;
    padding:4px 10px 0;text-align:right;
}
@media(max-width:768px){
    .scroll-hint-mobile{display:block;}
    .erp-table{min-width:580px;}
    .erp-table td,.erp-table th{padding:6px 7px;font-size:11px;}
    .erp-table th:nth-child(3),
    .erp-table td:nth-child(3),
    .erp-table th:nth-child(8),
    .erp-table td:nth-child(8){display:none;}
    .erp-table .num-input{width:60px;font-size:11px;padding:4px 5px;}
    .btn-xs{padding:4px 6px;font-size:10px;}
    #btnCamara{display:flex !important;}
}
@media(max-width:480px){
    .erp-table th:nth-child(6),
    .erp-table td:nth-child(6){display:none;}
    .erp-table{min-width:420px;}
    .erp-breadcrumb{display:none;}
    .order-sub{font-size:10px;}
    .kpis{grid-template-columns:repeat(2,1fr);}
}

/* ── Botones ── */
.btn-xs{display:inline-flex;align-items:center;gap:3px;padding:5px 9px;border-radius:3px;font-size:11px;font-weight:600;cursor:pointer;border:none;transition:opacity .15s;white-space:nowrap;}
.btn-xs:hover{opacity:.85;}
.btn-edit{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.btn-save{background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe;}
.btn-del{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.btn-primary{background:#1e3a5f;color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:5px;transition:opacity .15s;}
.btn-primary:hover{opacity:.9;}
.btn-green{background:#16a34a;color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;transition:opacity .15s;}
.btn-green:hover{opacity:.9;}

/* ── Summary ── */
.summary-table{width:100%;font-size:12px;border-collapse:collapse;}
.summary-table tr td{padding:5px 6px;border-bottom:1px solid #f1f5f9;color:#475569;}
.summary-table tr td:last-child{text-align:right;font-weight:600;color:#1e293b;}
.summary-table .total-row td{border-top:2px solid #c9d4e0;font-size:14px;font-weight:700;color:#1e3a5f;padding-top:8px;}
.status-row{display:flex;justify-content:space-between;align-items:center;font-size:11px;padding:3px 0;color:#64748b;}
.alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:3px;padding:7px 10px;font-size:12px;color:#15803d;margin-bottom:8px;display:flex;align-items:center;gap:6px;}
.alert-warn{background:#fef3c7;border:1px solid #fde68a;border-radius:3px;padding:7px 10px;font-size:12px;color:#b45309;margin-bottom:8px;display:flex;align-items:center;gap:6px;}
hr.dv{border:none;border-top:1px solid #e2e8f0;margin:.65rem 0;}

/* ── Modal cámara ── */
@keyframes scanAnim{
    0%  { top:0; }
    50% { top:calc(100% - 2px); }
    100%{ top:0; }
}
</style>

{{-- ── ERP Top Bar ── --}}
<div class="erp-bar">
    <div class="erp-bar-title">DISTHAN · Sistema ERP</div>
    <div style="display:flex;align-items:center;gap:12px;">
        <span class="erp-breadcrumb">Ventas › Órdenes › Pedido Local</span>
        <span class="erp-user">👤 {{ auth()->user()->name ?? 'Operador' }}</span>
    </div>
</div>

<div class="pg">

@if(session('success'))
<div class="alert-ok" style="margin-bottom:.85rem;">✅ {{ session('success') }}</div>
@endif

@php
    $totalItems  = $order->details->count();
    $completados = $order->details->filter(fn($i) => $i->cantidad_despachada >= $i->cantidad_solicitada && $i->cantidad_solicitada > 0)->count();
    $parciales   = $order->details->filter(fn($i) => $i->cantidad_despachada > 0 && $i->cantidad_despachada < $i->cantidad_solicitada)->count();
    $pendientes  = $order->details->filter(fn($i) => $i->cantidad_despachada == 0)->count();
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d' : ($order->estado === 'PARCIAL' ? '#b45309' : '#b91c1c');
    $estadoBg    = $order->estado === 'COMPLETO' ? '#dcfce7' : ($order->estado === 'PARCIAL' ? '#fef3c7' : '#fee2e2');
@endphp

{{-- ── Order Header ── --}}
<div class="order-header">
    <div>
        <div class="order-id">🏪 Pedido Local — {{ $order->numero_orden }}</div>
        <div class="order-sub">
            Cliente: {{ $order->client->razon_social ?? '—' }}
            &nbsp;·&nbsp; Fecha: {{ \Carbon\Carbon::parse($order->fecha_pedido ?? now())->format('d M Y') }}
            &nbsp;·&nbsp; Tipo: LOCAL
        </div>
    </div>
    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <span class="status-chip" style="background:{{ $estadoBg }};color:{{ $estadoColor }};">
            {{ $order->estado }}
        </span>
        <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="btn-green">📄 PDF</a>
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#1e3a5f;">
        <div class="kpi-label">Productos</div>
        <div class="kpi-val">{{ $totalItems }}</div>
        <div class="kpi-sub">líneas de pedido</div>
    </div>
    <div class="kpi" style="border-left-color:#22c55e;">
        <div class="kpi-label">Completos</div>
        <div class="kpi-val" style="color:#15803d;">{{ $completados }}</div>
        <div class="kpi-sub">ítems OK</div>
    </div>
    <div class="kpi" style="border-left-color:#ef4444;">
        <div class="kpi-label">Pendientes</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $pendientes }}</div>
        <div class="kpi-sub">sin despachar</div>
    </div>
    <div class="kpi" style="border-left-color:#2563eb;">
        <div class="kpi-label">Subtotal</div>
        <div class="kpi-val" style="font-size:14px;color:#2563eb;">S/ {{ number_format($order->subtotal,2) }}</div>
        <div class="kpi-sub">sin IGV</div>
    </div>
    <div class="kpi" style="border-left-color:#1e3a5f;background:#f0f7ff;">
        <div class="kpi-label">Total</div>
        <div class="kpi-val" style="font-size:14px;color:#1e3a5f;">S/ {{ number_format($order->total,2) }}</div>
        <div class="kpi-sub">con IGV 18%</div>
    </div>
</div>

{{-- ── Layout ── --}}
<div class="layout">

    {{-- ── Columna izquierda ── --}}
    <div class="left-col">

        {{-- ── Scanner ── --}}
        <div class="scanner-erp">
            <div class="scan-led"></div>
            <input type="text" id="scanner" class="scan-input"
                   placeholder="Escanea o escribe código de barras">
            <span style="font-size:10px;color:#475569;white-space:nowrap;flex-shrink:0;">⏎ Enter</span>
            <button type="button" id="btnCamara" onclick="abrirCamara()"
                    style="display:none;background:#1e3a5f;border:1px solid #334155;color:#7eb8f7;border-radius:4px;padding:6px 10px;cursor:pointer;font-size:13px;white-space:nowrap;flex-shrink:0;">
                📷 Cámara
            </button>
        </div>

        {{-- ── Agregar producto ── --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">➕ Agregar línea de producto</div>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('orders.addProduct',$order) }}">
                @csrf
                <div class="add-grid">
                    <div>
                        <label class="flabel">Producto</label>
                        <select name="product_id" class="finput" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} (Stock: {{ $p->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="flabel">Cantidad</label>
                        <input type="number" name="cantidad_solicitada" class="finput" placeholder="0" required>
                    </div>
                    <div>
                        <label class="flabel">Precio unit.</label>
                        <input type="number" step="0.01" name="precio_unitario" class="finput" placeholder="0.00" required>
                    </div>
                    <button type="submit" class="btn-primary" style="align-self:end;">+ Agregar</button>
                </div>
                </form>
            </div>
        </div>

        {{-- ── Tabla ERP de productos ── --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">📦 Líneas del pedido</div>
                <span style="font-size:10px;color:#94a3b8;">{{ $totalItems }} registro(s)</span>
            </div>

            <div class="scroll-hint-mobile">← desliza horizontalmente →</div>

            <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%;">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th>Est.</th>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th style="text-align:center;">Solicitado</th>
                        <th style="text-align:center;">Despachado</th>
                        <th style="text-align:center;">Precio</th>
                        <th style="text-align:right;">Subtotal</th>
                        <th style="text-align:center;">Prog.</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($order->details as $item)
                @php
                    $pct = $item->cantidad_solicitada > 0
                        ? ($item->cantidad_despachada / $item->cantidad_solicitada) * 100 : 0;
                    $lc  = $pct >= 100 ? '#22c55e' : ($pct > 0 ? '#f59e0b' : '#ef4444');
                    $montoColor = $pct >= 100 ? '#15803d' : ($pct > 0 ? '#b45309' : '#b91c1c');
                @endphp

                {{-- ✅ FIX: form FUERA del tr, referenciado con form="form-X" en los inputs --}}
                <form method="POST"
                      action="{{ route('orders.updateDetail',$item) }}"
                      id="form-{{ $item->id }}"
                      style="display:none;">
                    @csrf @method('PUT')
                    <input type="hidden" name="cantidad_solicitada" id="hid-sol-{{ $item->id }}" value="{{ $item->cantidad_solicitada }}">
                    <input type="hidden" name="cantidad_despachada" id="hid-des-{{ $item->id }}" value="{{ $item->cantidad_despachada }}">
                    <input type="hidden" name="precio_unitario"     id="hid-pre-{{ $item->id }}" value="{{ $item->precio_unitario }}">
                </form>

                <tr id="row-{{ $item->id }}">
                    <td><span class="state-dot" style="background:{{ $lc }};"></span></td>
                    <td style="font-weight:600;color:#0f172a;">{{ $item->product->nombre }}</td>
                    <td style="color:#94a3b8;font-size:11px;">{{ $item->product->sku ?? '—' }}</td>
                    <td style="text-align:center;">
                        <input type="number" step="0.01"
                               class="num-input" id="sol-{{ $item->id }}"
                               value="{{ $item->cantidad_solicitada }}"
                               disabled
                               oninput="syncHidden({{ $item->id }})">
                    </td>
                    <td style="text-align:center;">
                        <input type="number" step="0.01"
                               class="num-input" id="des-{{ $item->id }}"
                               value="{{ $item->cantidad_despachada }}"
                               disabled
                               oninput="syncHidden({{ $item->id }})">
                    </td>
                    <td style="text-align:center;">
                        <input type="number" step="0.01"
                               class="num-input" id="pre-{{ $item->id }}"
                               value="{{ $item->precio_unitario }}"
                               disabled
                               oninput="syncHidden({{ $item->id }})">
                    </td>
                    <td style="text-align:right;font-weight:700;color:{{ $montoColor }};">
                        S/ {{ number_format($item->subtotal ?? ($item->cantidad_despachada * $item->precio_unitario),2) }}
                    </td>
                    <td style="text-align:center;">
                        <div class="mini-bar">
                            <div class="mini-fill" style="width:{{ min($pct,100) }}%;background:{{ $lc }};"></div>
                        </div>
                        <div style="font-size:10px;font-weight:700;color:{{ $lc }};">{{ number_format($pct,0) }}%</div>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px;flex-wrap:wrap;">
                            <button type="button" class="btn-xs btn-edit"
                                    onclick="editar({{ $item->id }})">✏️ Editar</button>
                            <button type="submit" form="form-{{ $item->id }}"
                                    class="btn-xs btn-save"
                                    id="btn-save-{{ $item->id }}"
                                    style="display:none;">💾 Guardar</button>
                            <form method="POST"
                                  action="{{ route('orders.details.destroy',$item) }}"
                                  onsubmit="return confirm('¿Eliminar {{ addslashes($item->product->nombre) }}?')"
                                  style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-xs btn-del">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>
            </div>
        </div>

    </div>{{-- fin left-col --}}

    {{-- ── Columna derecha: Resumen ── --}}
    <div>
        <div class="panel" style="position:sticky;top:10px;">
            <div class="panel-header">
                <div class="panel-title">📊 Resumen del pedido</div>
            </div>
            <div class="panel-body">

                @if($completados === $totalItems && $totalItems > 0)
                <div class="alert-ok">✅ Todos los ítems completos</div>
                @else
                <div class="alert-warn">⏳ {{ $completados }} de {{ $totalItems }} ítems completos</div>
                @endif

                <table class="summary-table">
                    <tr><td>Nº Orden</td><td>{{ $order->numero_orden }}</td></tr>
                    <tr><td>Tipo</td><td>LOCAL</td></tr>
                    <tr><td>Fecha</td><td>{{ \Carbon\Carbon::parse($order->fecha_pedido ?? now())->format('d M Y') }}</td></tr>
                    <tr><td>Cliente</td><td style="font-size:11px;">{{ $order->client->razon_social ?? '—' }}</td></tr>
                    <tr><td>Productos</td><td>{{ $totalItems }}</td></tr>
                </table>

                <hr class="dv">

                <table class="summary-table">
                    <tr><td>Subtotal</td><td>S/ {{ number_format($order->subtotal,2) }}</td></tr>
                    <tr><td>IGV (18%)</td><td>S/ {{ number_format($order->igv,2) }}</td></tr>
                    <tr class="total-row"><td>TOTAL</td><td>S/ {{ number_format($order->total,2) }}</td></tr>
                </table>

                <hr class="dv">

                <div style="font-size:10px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Estado de ítems</div>
                <div class="status-row"><span>🟢 Completo</span><span style="font-weight:700;color:#15803d;">{{ $completados }}</span></div>
                <div class="status-row"><span>🟡 Parcial</span><span style="font-weight:700;color:#b45309;">{{ $parciales }}</span></div>
                <div class="status-row"><span>🔴 Pendiente</span><span style="font-weight:700;color:#b91c1c;">{{ $pendientes }}</span></div>

                <hr class="dv">

                <a href="{{ route('orders.pdf',$order) }}" target="_blank"
                   class="btn-green"
                   style="display:block;text-align:center;text-decoration:none;padding:9px;margin-bottom:6px;">
                    📄 Ver / Descargar PDF
                </a>
            </div>
        </div>
    </div>

</div>{{-- fin layout --}}

{{-- ── Modal cámara ── --}}
<div id="modalCamara" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;flex-direction:column;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#0f172a;border:1px solid #334155;border-radius:8px;width:100%;max-width:420px;overflow:hidden;">
        <div style="background:#1e293b;padding:.75rem 1rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #334155;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div class="scan-led"></div>
                <span style="color:#7eb8f7;font-size:13px;font-weight:600;">Escáner de cámara</span>
            </div>
            <button onclick="cerrarCamara()" style="background:none;border:none;color:#94a3b8;font-size:20px;cursor:pointer;line-height:1;padding:2px 6px;">✕</button>
        </div>
        <div style="position:relative;background:#000;">
            <video id="videoEscan" style="width:100%;display:block;max-height:300px;object-fit:cover;" autoplay playsinline muted></video>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
                <div style="width:220px;height:110px;border:2px solid #22c55e;border-radius:6px;box-shadow:0 0 0 9999px rgba(0,0,0,.45);position:relative;">
                    <span style="position:absolute;top:-2px;left:-2px;width:18px;height:18px;border-top:3px solid #22c55e;border-left:3px solid #22c55e;border-radius:3px 0 0 0;"></span>
                    <span style="position:absolute;top:-2px;right:-2px;width:18px;height:18px;border-top:3px solid #22c55e;border-right:3px solid #22c55e;border-radius:0 3px 0 0;"></span>
                    <span style="position:absolute;bottom:-2px;left:-2px;width:18px;height:18px;border-bottom:3px solid #22c55e;border-left:3px solid #22c55e;border-radius:0 0 0 3px;"></span>
                    <span style="position:absolute;bottom:-2px;right:-2px;width:18px;height:18px;border-bottom:3px solid #22c55e;border-right:3px solid #22c55e;border-radius:0 0 3px 0;"></span>
                    <div style="position:absolute;left:0;right:0;height:2px;background:#22c55e;box-shadow:0 0 8px #22c55e;animation:scanAnim 2s ease-in-out infinite;top:0;"></div>
                </div>
            </div>
        </div>
        <div style="padding:.75rem 1rem;border-top:1px solid #334155;">
            <div id="scanResultado" style="font-size:12px;color:#94a3b8;text-align:center;min-height:24px;">
                Apunta la cámara al código de barras
            </div>
            <select id="selectCamara" style="display:none;width:100%;margin-top:8px;padding:6px 8px;background:#1e293b;border:1px solid #334155;color:#c8daf0;border-radius:4px;font-size:12px;"></select>
        </div>
    </div>
</div>

</div>{{-- fin pg --}}

{{-- ZXing CDN --}}
<script src="https://unpkg.com/@zxing/library@0.19.1/umd/index.min.js"></script>

<script>
/* ============================================================
   ÚNICA definición de todas las funciones — sin duplicados
============================================================ */

/* ── Sync inputs visibles → hidden del form ── */
function syncHidden(id) {
    var sol = document.getElementById('sol-' + id);
    var des = document.getElementById('des-' + id);
    var pre = document.getElementById('pre-' + id);
    if(sol) document.getElementById('hid-sol-' + id).value = sol.value;
    if(des) document.getElementById('hid-des-' + id).value = des.value;
    if(pre) document.getElementById('hid-pre-' + id).value = pre.value;
}

/* ── Editar fila ── */
function editar(id) {
    document.getElementById('sol-' + id).disabled = false;
    document.getElementById('des-' + id).disabled = false;
    document.getElementById('pre-' + id).disabled = false;
    document.getElementById('btn-save-' + id).style.display = 'inline-flex';
    var des = document.getElementById('des-' + id);
    des.focus();
    des.select();
}

/* ── Scanner (teclado / lector físico) ── */
document.getElementById('scanner').addEventListener('keypress', function(e) {
    if (e.key !== 'Enter') return;
    e.preventDefault();
    var codigo = this.value.trim();
    if (!codigo) return;

    fetch('/buscar-producto/' + codigo)
        .then(function(res){ return res.json(); })
        .then(function(data) {
            if (!data) { alert('❌ Producto no encontrado'); return; }
            var sel = document.querySelector('select[name="product_id"]');
            if (sel) {
                for (var o of sel.options) {
                    if (o.value == data.id) { sel.value = data.id; break; }
                }
            }
            var precioInput = document.querySelector('input[name="precio_unitario"]');
            if (precioInput && data.precio) precioInput.value = data.precio;
            var cantInput = document.querySelector('input[name="cantidad_solicitada"]');
            if (cantInput) { cantInput.focus(); cantInput.select(); }
        })
        .catch(function() {
            console.warn('Error buscando producto');
        });

    this.value = '';
});

/* ── Cámara ZXing ── */
var codeReader  = null;
var streamActual = null;

function abrirCamara() {
    document.getElementById('modalCamara').style.display = 'flex';
    iniciarEscaneo();
}

function cerrarCamara() {
    document.getElementById('modalCamara').style.display = 'none';
    detenerStream();
}

function detenerStream() {
    if (codeReader) { codeReader.reset(); codeReader = null; }
    if (streamActual) { streamActual.getTracks().forEach(function(t){ t.stop(); }); streamActual = null; }
    var video = document.getElementById('videoEscan');
    if (video) video.srcObject = null;
}

function iniciarEscaneo() {
    var resultado = document.getElementById('scanResultado');
    var selectCam = document.getElementById('selectCamara');

    if (typeof ZXing === 'undefined') {
        resultado.innerHTML = '<span style="color:#ef4444;">Error: librería no cargada</span>';
        return;
    }

    codeReader = new ZXing.BrowserMultiFormatReader();
    resultado.textContent = 'Iniciando cámara...';

    codeReader.listVideoInputDevices().then(function(devices) {
        if (!devices || devices.length === 0) {
            resultado.innerHTML = '<span style="color:#ef4444;">No se encontró cámara</span>';
            return;
        }
        if (devices.length > 1) {
            selectCam.style.display = 'block';
            selectCam.innerHTML = '';
            devices.forEach(function(d, i) {
                var opt = document.createElement('option');
                opt.value = d.deviceId;
                opt.textContent = d.label || ('Cámara ' + (i + 1));
                if (d.label && d.label.toLowerCase().includes('back')) opt.selected = true;
                selectCam.appendChild(opt);
            });
            selectCam.onchange = function() {
                codeReader.reset();
                empezarConDispositivo(this.value);
            };
            empezarConDispositivo(selectCam.value);
        } else {
            empezarConDispositivo(devices[0].deviceId);
        }
    }).catch(function(err) {
        resultado.innerHTML = '<span style="color:#ef4444;">Sin permiso de cámara</span>';
        console.error(err);
    });
}

function empezarConDispositivo(deviceId) {
    var video     = document.getElementById('videoEscan');
    var resultado = document.getElementById('scanResultado');
    resultado.textContent = 'Apunta la cámara al código de barras';

    codeReader.decodeFromVideoDevice(deviceId, video, function(result, err) {
        if (result) {
            var codigo = result.getText();
            resultado.innerHTML = '✅ <strong style="color:#22c55e;">' + codigo + '</strong>';
            if (navigator.vibrate) navigator.vibrate(120);
            cerrarCamara();

            var inputScanner = document.getElementById('scanner');
            inputScanner.value = codigo;
            inputScanner.dispatchEvent(new KeyboardEvent('keypress', {
                key:'Enter', code:'Enter', keyCode:13, which:13, bubbles:true
            }));
        }
        if (err && !(err instanceof ZXing.NotFoundException)) {
            console.warn(err);
        }
    });
}

/* Cerrar modal al tocar fuera */
document.getElementById('modalCamara').addEventListener('click', function(e) {
    if (e.target === this) cerrarCamara();
});
</script>

@endsection