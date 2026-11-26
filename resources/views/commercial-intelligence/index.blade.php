@extends('layouts.app')

@section('content')
<style>
.ci{--navy:#1e3a5f;--blue:#1d7ff2;--line:#dfe6ef;--muted:#64748b;--text:#172033;background:#f1f4f8;padding:20px;color:var(--text);font-family:'Segoe UI',Arial,sans-serif;min-height:100vh}
.ci *{box-sizing:border-box}.ci-head{background:var(--navy);color:#fff;border-radius:12px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px}.ci-head h1{font-size:21px;margin:0 0 4px;font-weight:800}.ci-head p{margin:0;color:#d5e2f0;font-size:12px}.ci-tag{font-size:10px;background:#294d75;padding:7px 10px;border-radius:7px;white-space:nowrap}
.ci-filters{background:#fff;border:1px solid var(--line);border-radius:12px;padding:13px;margin-bottom:12px;display:flex;gap:10px;align-items:end;flex-wrap:wrap}.ci-field{display:flex;flex-direction:column;gap:5px;min-width:145px}.ci-field label{font-size:10px;text-transform:uppercase;letter-spacing:.05em;font-weight:800;color:var(--muted)}.ci-field input,.ci-field select{height:36px;border:1px solid #cbd5e1;border-radius:7px;padding:0 9px;font:inherit;font-size:12px;min-width:145px;background:#fff;color:#172033}.ci-field.product-field{min-width:230px;flex:1}.ci-field.product-field input{width:100%}.ci-btn{height:36px;padding:0 14px;border:0;border-radius:7px;background:var(--blue);color:#fff;font-weight:700;font-size:12px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}.ci-btn.light{background:#f1f5f9;color:#1e40af;border:1px solid #cbd5e1}
.ci-tabs{display:flex;gap:7px;margin:0 0 14px;border-bottom:1px solid #d8e0ea}.ci-tab{padding:10px 16px;background:#e7edf5;color:#52647a;text-decoration:none;font-size:12px;font-weight:800;border-radius:8px 8px 0 0;border:1px solid transparent}.ci-tab.active{background:#fff;color:#1d4ed8;border-color:var(--line);border-bottom-color:#fff;margin-bottom:-1px}
.ci-kpis{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:11px;margin-bottom:14px}.ci-kpi{background:#fff;border:1px solid var(--line);border-radius:12px;padding:14px 15px;min-width:0}.ci-kpi small{display:block;color:var(--muted);font-size:10px;font-weight:800;text-transform:uppercase}.ci-kpi strong{display:block;font-size:24px;line-height:1.25;margin:5px 0 2px;font-weight:800;font-variant-numeric:tabular-nums}.ci-kpi span{font-size:10px;color:#94a3b8}
.ci-grid{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(300px,.75fr);gap:14px;margin-bottom:14px}.ci-card{background:#fff;border:1px solid var(--line);border-radius:12px;padding:15px;min-width:0;margin-bottom:14px}.ci-card h2{font-size:14px;margin:0 0 12px;color:var(--navy);font-weight:800}.ci-sub{font-size:11px;color:var(--muted);font-weight:500;margin-left:5px}.ci-table-wrap{width:100%;overflow-x:auto}.ci-table{border-collapse:collapse;width:100%;font-size:11.5px;white-space:nowrap;table-layout:auto}.ci-table th{text-align:left;padding:10px 9px;background:#f8fafc;color:#475569;font-size:10px;text-transform:uppercase;letter-spacing:.025em;border-bottom:1px solid var(--line);vertical-align:middle}.ci-table td{padding:10px 9px;border-bottom:1px solid #eef2f7;vertical-align:middle}.ci-table th.ci-num{text-align:right}.ci-table td.ci-num{text-align:right;font-variant-numeric:tabular-nums;font-family:Consolas,monospace}.ci-table tbody tr:hover{background:#f8fbff}.ci-table tr:last-child td{border-bottom:0}.ci-table--summary{min-width:850px}.ci-table--detail{min-width:920px}.ci-table--summary th:first-child,.ci-table--summary td:first-child{min-width:220px;white-space:normal}.ci-table--detail th:nth-child(2),.ci-table--detail td:nth-child(2){min-width:230px;white-space:normal}.ci-table .ci-action-cell{text-align:center;white-space:nowrap}.ci-money{font-weight:700;color:#0f766e}.ci-money-loss{font-weight:700;color:#b45309}.ci-table tfoot th,.ci-table tfoot td{background:#f1f5f9;border-top:2px solid #cbd5e1;font-weight:900}
.ci-pill{display:inline-flex;padding:4px 8px;border-radius:6px;font-size:9px;font-weight:900;white-space:nowrap}.p-alta{background:#fee2e2;color:#b91c1c}.p-media{background:#fef3c7;color:#92400e}.p-seguimiento{background:#dbeafe;color:#1d4ed8}.p-atendido{background:#dcfce7;color:#15803d}
.ci-bars{display:flex;flex-direction:column;gap:12px}.ci-bar-row{display:grid;grid-template-columns:minmax(120px,145px) minmax(60px,1fr) 65px;gap:9px;align-items:center;font-size:11px}.ci-bar-track{height:9px;border-radius:99px;background:#edf2f7;overflow:hidden}.ci-bar-fill{height:100%;border-radius:99px;background:#1d7ff2}.ci-legend{display:flex;gap:12px;flex-wrap:wrap;margin:5px 0 8px;font-size:10px;color:var(--muted)}.ci-dot{display:inline-block;width:8px;height:8px;border-radius:3px;margin-right:4px}.ci-empty{text-align:center;color:#94a3b8;padding:22px;font-size:12px}.ci-foot{font-size:10px;color:#64748b;line-height:1.5;margin-top:12px}.ci-link{color:#1d4ed8;text-decoration:none;font-weight:800}.ci-link:hover{text-decoration:underline}.ci-back{display:inline-flex;margin-bottom:10px;color:#1d4ed8;text-decoration:none;font-size:12px;font-weight:800}.ci-detail-head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
@media(max-width:1100px){.ci-kpis{grid-template-columns:repeat(3,minmax(0,1fr))}.ci-grid{grid-template-columns:1fr}}@media(max-width:650px){.ci{padding:10px}.ci-head{align-items:flex-start;flex-direction:column}.ci-kpis{grid-template-columns:1fr 1fr}.ci-kpi strong{font-size:20px}.ci-field{flex:1;min-width:calc(50% - 8px)}.ci-field input,.ci-field select{width:100%;min-width:0}.ci-field.product-field{min-width:100%}.ci-btn{flex:1}.ci-tab{flex:1;text-align:center;padding:9px 5px}.ci-bar-row{grid-template-columns:110px 1fr 55px}}
</style>

@php
    $filterParams = array_filter([
        'desde' => $desde,
        'hasta' => $hasta,
        'tipo_cliente' => $tipoCliente,
        'producto' => $validated['producto'] ?? '',
        'prioridad' => $validated['prioridad'] ?? '',
    ], fn($v) => $v !== null && $v !== '');
    $matrixParams = array_merge($filterParams, ['vista' => 'matriz']);
    $clientParams = array_merge($filterParams, ['vista' => 'clientes']);
    $pdfParams = array_merge($filterParams, ['vista' => $vista]);
    if (!empty($validated['cliente'])) $pdfParams['cliente'] = $validated['cliente'];
    if (!empty($validated['cliente_detalle'])) $pdfParams['cliente_detalle'] = $validated['cliente_detalle'];
    $priorityClass = ['ALTA'=>'p-alta','MEDIA'=>'p-media','SEGUIMIENTO'=>'p-seguimiento','ATENDIDO'=>'p-atendido'];
@endphp

<div class="ci">
    <header class="ci-head">
        <div><h1>Inteligencia Comercial</h1><p>Análisis de demanda, nivel de atención y comportamiento de compra por cliente</p></div>
        <span class="ci-tag">DISTAN ERP · SOLO LECTURA</span>
    </header>

    <form method="GET" action="{{ route('commercial-intelligence.index') }}" class="ci-filters">
        <input type="hidden" name="vista" value="{{ $vista }}">
        <div class="ci-field"><label for="ci-desde">Desde</label><input id="ci-desde" type="date" name="desde" value="{{ $desde }}"></div>
        <div class="ci-field"><label for="ci-hasta">Hasta</label><input id="ci-hasta" type="date" name="hasta" value="{{ $hasta }}"></div>
        <div class="ci-field"><label for="ci-tipo">Tipo de cliente</label>
            <select id="ci-tipo" name="tipo_cliente">
                <option value="">Todos los tipos</option>
                @foreach(['MAYORISTA'=>'Mayorista','MINORISTA'=>'Minorista','SUPERMERCADOS'=>'Supermercados'] as $valor=>$texto)
                    <option value="{{ $valor }}" @selected($tipoCliente === $valor)>{{ $texto }}</option>
                @endforeach
            </select>
        </div>
        @if($vista === 'matriz')
            <div class="ci-field product-field"><label for="ci-producto">Producto o SKU</label>
                <input id="ci-producto" type="search" name="producto" list="ci-productos" placeholder="Escriba el nombre del producto..." value="{{ $validated['producto'] ?? '' }}" autocomplete="off">
                <datalist id="ci-productos">
                    @foreach($productosFiltro as $pf)
                        <option value="{{ $pf->nombre }}">{{ $pf->sku }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="ci-field"><label for="ci-prioridad">Prioridad</label>
                <select id="ci-prioridad" name="prioridad">
                    <option value="">Todas</option>
                    @foreach(['ALTA'=>'Alta','MEDIA'=>'Media','SEGUIMIENTO'=>'Seguimiento','ATENDIDO'=>'Atendido'] as $valor=>$texto)
                        <option value="{{ $valor }}" @selected(($validated['prioridad'] ?? '') === $valor)>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <button type="submit" class="ci-btn">Aplicar filtros</button>
        <a class="ci-btn light" href="{{ route('commercial-intelligence.index', ['vista'=>$vista]) }}">Limpiar</a>
        <a class="ci-btn" style="background:#0f766e" href="{{ route('commercial-intelligence.pdf', $pdfParams) }}" target="_blank" rel="noopener">Descargar PDF</a>
    </form>

    <nav class="ci-tabs" aria-label="Secciones de Inteligencia Comercial">
        <a class="ci-tab {{ $vista === 'matriz' ? 'active' : '' }}" href="{{ route('commercial-intelligence.index', $matrixParams) }}">Matriz de prioridad</a>
        <a class="ci-tab {{ in_array($vista, ['clientes','detalle'], true) ? 'active' : '' }}" href="{{ route('commercial-intelligence.index', $clientParams) }}">Análisis por cliente</a>
    </nav>

    @if($vista === 'matriz')
        @if(empty($validated['cliente']))
            <article class="ci-card">
                <h2>Clientes · Matriz de prioridad <span class="ci-sub">{{ number_format($matrixClientes->count()) }} clientes · {{ number_format($matrixTotales['filas']) }} combinaciones producto/cliente</span></h2>
                <div class="ci-legend"><span><i class="ci-dot" style="background:#ef4444"></i>ALTA: ≥ 70</span><span><i class="ci-dot" style="background:#f59e0b"></i>MEDIA: 45–69.99</span><span><i class="ci-dot" style="background:#3b82f6"></i>SEGUIMIENTO: menor de 45</span><span><i class="ci-dot" style="background:#16a34a"></i>ATENDIDO: sin faltante</span></div>
                <p class="ci-foot" style="margin:8px 0 10px">Se muestra un solo registro por cliente. Seleccione «Ver productos» para consultar sus productos y prioridades.</p>
                <div class="ci-table-wrap"><table class="ci-table ci-table--summary">
                    <thead><tr><th>Cliente</th><th class="ci-num">Productos</th><th class="ci-num">Solicitado</th><th class="ci-num">Despachado</th><th class="ci-num">Faltante</th><th class="ci-num">Precio prom. (S/)</th><th class="ci-num">Venta despachada (S/)</th><th class="ci-num">Valor no despachado (S/)</th><th>Prioridad</th><th class="ci-num">Índice máx.</th><th class="ci-action-cell">Detalle</th></tr></thead>
                    <tbody>
                    @forelse($matrixClientes as $r)
                        @php $cls = $priorityClass[$r->prioridad] ?? 'p-atendido'; @endphp
                        <tr>
                            <td><strong>{{ $r->cliente }}</strong></td><td class="ci-num">{{ number_format($r->productos) }}</td>
                            <td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td>
                            <td class="ci-num"><strong>{{ number_format($r->faltantes,0) }}</strong></td><td class="ci-num">S/ {{ number_format($r->precio_unitario_promedio,2) }}</td><td class="ci-num ci-money">S/ {{ number_format($r->venta_despachada,2) }}</td><td class="ci-num ci-money-loss">S/ {{ number_format($r->valor_no_despachado,2) }}</td><td><span class="ci-pill {{ $cls }}">{{ $r->prioridad }}</span></td>
                            <td class="ci-num">{{ number_format($r->indice,2) }}</td>
                            <td class="ci-action-cell"><a class="ci-link" href="{{ route('commercial-intelligence.index', array_merge($filterParams, ['vista'=>'matriz','cliente'=>$r->client_id])) }}">Ver productos →</a></td>
                        </tr>
                    @empty<tr><td colspan="11" class="ci-empty">No hay clientes que coincidan con los filtros.</td></tr>@endforelse
                    </tbody>
                    @if($matrixClientes->isNotEmpty())
                        @php
                            $sumSol = (float)$matrixClientes->sum('solicitadas');
                            $sumVentaSol = (float)$matrixClientes->sum('venta_solicitada');
                        @endphp
                        <tfoot><tr>
                            <th>TOTAL</th><th class="ci-num">{{ number_format($matrixClientes->sum('productos')) }}</th>
                            <th class="ci-num">{{ number_format($sumSol,0) }}</th><th class="ci-num">{{ number_format($matrixClientes->sum('despachadas'),0) }}</th>
                            <th class="ci-num">{{ number_format($matrixClientes->sum('faltantes'),0) }}</th>
                            <th class="ci-num">S/ {{ number_format($sumSol > 0 ? $sumVentaSol/$sumSol : 0,2) }}</th>
                            <th class="ci-num ci-money">S/ {{ number_format($matrixClientes->sum('venta_despachada'),2) }}</th>
                            <th class="ci-num ci-money-loss">S/ {{ number_format($matrixClientes->sum('valor_no_despachado'),2) }}</th>
                            <th colspan="3"></th>
                        </tr></tfoot>
                    @endif
                </table></div>
                <p class="ci-foot">Metodología: V = faltante de la combinación / máximo faltante del cliente × 100; B = 100 − nivel de atención; F = pedidos de la combinación / máximo de pedidos del cliente × 100. Índice = 0.40V + 0.35B + 0.25F. Faltante = suma de GREATEST(solicitado − despachado, 0) por línea. No se compensan excedentes entre SKU.</p>
            </article>
        @else
            @php $clienteSeleccionado = $clientes->firstWhere('id', (int)$validated['cliente']); @endphp
            <article class="ci-card">
                <a class="ci-back" href="{{ route('commercial-intelligence.index', $matrixParams) }}">← Volver a todos los clientes</a>
                <div class="ci-detail-head"><h2>Productos y prioridad · {{ $clienteSeleccionado->nombre ?? 'Cliente seleccionado' }} <span class="ci-sub">{{ number_format($matrix->count()) }} productos</span></h2></div>
                <div class="ci-legend"><span><i class="ci-dot" style="background:#ef4444"></i>ALTA: ≥ 70</span><span><i class="ci-dot" style="background:#f59e0b"></i>MEDIA: 45–69.99</span><span><i class="ci-dot" style="background:#3b82f6"></i>SEGUIMIENTO: menor de 45</span><span><i class="ci-dot" style="background:#16a34a"></i>ATENDIDO: sin faltante</span></div>
                <div class="ci-table-wrap"><table class="ci-table ci-table--detail"><thead><tr><th>Prioridad</th><th>Producto</th><th>SKU</th><th class="ci-num">Pedidos</th><th class="ci-num">Solicitado</th><th class="ci-num">Despachado</th><th class="ci-num">Faltante</th><th class="ci-num">Precio prom. (S/)</th><th class="ci-num">Venta despachada (S/)</th><th class="ci-num">Valor no despachado (S/)</th><th class="ci-num">Atención</th><th class="ci-num">Índice</th></tr></thead><tbody>
                    @forelse($matrix as $r)
                        @php $cls = $priorityClass[$r->prioridad] ?? 'p-atendido'; @endphp
                        <tr><td><span class="ci-pill {{ $cls }}">{{ $r->prioridad }}</span></td><td>{{ $r->producto }}</td><td><strong>{{ $r->sku }}</strong></td><td class="ci-num">{{ number_format($r->pedidos) }}</td><td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td><td class="ci-num"><strong>{{ number_format($r->faltantes,0) }}</strong></td><td class="ci-num">S/ {{ number_format($r->precio_unitario_promedio,2) }}</td><td class="ci-num ci-money">S/ {{ number_format($r->venta_despachada,2) }}</td><td class="ci-num ci-money-loss">S/ {{ number_format($r->valor_no_despachado,2) }}</td><td class="ci-num">{{ number_format($r->atencion,2) }}%</td><td class="ci-num">{{ number_format($r->indice,2) }}</td></tr>
                    @empty<tr><td colspan="12" class="ci-empty">No hay productos que coincidan con los filtros.</td></tr>@endforelse
                </tbody>
                @if($matrix->isNotEmpty())
                    @php $sumSolDet=(float)$matrix->sum('solicitadas'); $sumVentaSolDet=(float)$matrix->sum('venta_solicitada'); @endphp
                    <tfoot><tr>
                        <th colspan="4">TOTAL</th><th class="ci-num">{{ number_format($sumSolDet,0) }}</th>
                        <th class="ci-num">{{ number_format($matrix->sum('despachadas'),0) }}</th><th class="ci-num">{{ number_format($matrix->sum('faltantes'),0) }}</th>
                        <th class="ci-num">S/ {{ number_format($sumSolDet>0?$sumVentaSolDet/$sumSolDet:0,2) }}</th>
                        <th class="ci-num ci-money">S/ {{ number_format($matrix->sum('venta_despachada'),2) }}</th>
                        <th class="ci-num ci-money-loss">S/ {{ number_format($matrix->sum('valor_no_despachado'),2) }}</th><th colspan="2"></th>
                    </tr></tfoot>
                @endif
                </table></div>
            </article>
        @endif

        <section class="ci-grid">
            <article class="ci-card"><h2>Demanda y atención por segmento</h2>
                <div class="ci-table-wrap"><table class="ci-table"><thead><tr><th>Segmento</th><th class="ci-num">Pedidos</th><th class="ci-num">Solicitadas</th><th class="ci-num">Despachadas</th><th class="ci-num">Faltantes</th><th class="ci-num">Venta despachada (S/)</th><th class="ci-num">Valor no despachado (S/)</th><th class="ci-num">Atención</th></tr></thead><tbody>
                @forelse($porTipo as $r) @php $pct = (float)$r->solicitadas > 0 ? ((float)$r->despachadas/(float)$r->solicitadas)*100 : 0; @endphp
                    <tr><td><strong>{{ $r->tipo }}</strong></td><td class="ci-num">{{ number_format($r->pedidos) }}</td><td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td><td class="ci-num">{{ number_format($r->faltantes,0) }}</td><td class="ci-num ci-money">S/ {{ number_format($r->venta_despachada,2) }}</td><td class="ci-num ci-money-loss">S/ {{ number_format($r->valor_no_despachado,2) }}</td><td class="ci-num">{{ number_format($pct,2) }}%</td></tr>
                @empty<tr><td colspan="8" class="ci-empty">No hay información para el período seleccionado.</td></tr>@endforelse
                </tbody></table></div>
            </article>
            <article class="ci-card"><h2>Top productos con faltantes <span class="ci-sub">Por unidades</span></h2>
                <div class="ci-bars">@php $maxF = max(1, (float)($topProductos->max('faltantes') ?? 0)); @endphp
                    @forelse($topProductos as $p)
                        <div class="ci-bar-row"><div title="{{ $p->nombre }}"><strong>{{ $p->nombre }}</strong><br><span class="ci-muted">SKU: {{ $p->sku }}</span></div><div class="ci-bar-track"><div class="ci-bar-fill" style="width:{{ min(100,((float)$p->faltantes/$maxF)*100) }}%"></div></div><strong class="ci-num">{{ number_format($p->faltantes,0) }}<br><small class="ci-money-loss">S/ {{ number_format($p->valor_no_despachado,2) }}</small></strong></div>
                    @empty<div class="ci-empty">Sin faltantes registrados.</div>@endforelse
                </div>
            </article>
        </section>

    @elseif($vista === 'clientes')
        <article class="ci-card">
            <h2>Clientes · {{ $tipoCliente ? str_replace('_',' ', $tipoCliente) : 'Todos los tipos' }} <span class="ci-sub">{{ number_format($resumenClientes->count()) }} clientes con pedidos en el período</span></h2>
            <p class="ci-foot" style="margin:0 0 10px">Seleccione un cliente para consultar su detalle de productos.</p>
            <div class="ci-table-wrap"><table class="ci-table ci-table--summary"><thead><tr><th>Cliente</th><th class="ci-num">Pedidos</th><th class="ci-num">Unidades solicitadas</th><th class="ci-num">Unidades despachadas</th><th class="ci-num">Faltantes</th><th class="ci-num">Venta despachada (S/)</th><th class="ci-num">Valor no despachado (S/)</th><th class="ci-num">Nivel de atención</th><th class="ci-action-cell">Detalle</th></tr></thead><tbody>
            @forelse($resumenClientes as $r)
                <tr><td><strong>{{ $r->cliente }}</strong></td><td class="ci-num">{{ number_format($r->pedidos) }}</td><td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td><td class="ci-num">{{ number_format($r->faltantes,0) }}</td><td class="ci-num ci-money">S/ {{ number_format($r->venta_despachada,2) }}</td><td class="ci-num ci-money-loss">S/ {{ number_format($r->valor_no_despachado,2) }}</td><td class="ci-num">{{ number_format($r->atencion,2) }}%</td><td class="ci-action-cell"><a class="ci-link" href="{{ route('commercial-intelligence.index', array_merge($filterParams, ['vista'=>'detalle','cliente_detalle'=>$r->client_id])) }}">Ver productos →</a></td></tr>
            @empty<tr><td colspan="9" class="ci-empty">No hay clientes con pedidos para los filtros seleccionados.</td></tr>@endforelse
            </tbody>
            @if($resumenClientes->isNotEmpty())
                <tfoot><tr><th>TOTAL</th><th class="ci-num">{{ number_format($resumenClientes->sum('pedidos')) }}</th>
                    <th class="ci-num">{{ number_format($resumenClientes->sum('solicitadas'),0) }}</th><th class="ci-num">{{ number_format($resumenClientes->sum('despachadas'),0) }}</th>
                    <th class="ci-num">{{ number_format($resumenClientes->sum('faltantes'),0) }}</th>
                    <th class="ci-num ci-money">S/ {{ number_format($resumenClientes->sum('venta_despachada'),2) }}</th>
                    <th class="ci-num ci-money-loss">S/ {{ number_format($resumenClientes->sum('valor_no_despachado'),2) }}</th><th colspan="2"></th>
                </tr></tfoot>
            @endif
            </table></div>
        </article>

    @else
        <article class="ci-card">
            <a class="ci-back" href="{{ route('commercial-intelligence.index', $clientParams) }}">← Volver a todos los clientes</a>
            @if($clienteDetalle)
                <div class="ci-detail-head"><h2>Productos solicitados por {{ $clienteDetalle->nombre }}</h2><span class="ci-sub">Ordenados de mayor a menor por unidades solicitadas</span></div>
                <div class="ci-table-wrap"><table class="ci-table ci-table--detail"><thead><tr><th>#</th><th>Producto</th><th>SKU</th><th class="ci-num">Pedidos</th><th class="ci-num">Solicitado</th><th class="ci-num">Despachado</th><th class="ci-num">Faltante</th><th class="ci-num">Precio prom. (S/)</th><th class="ci-num">Venta despachada (S/)</th><th class="ci-num">Valor no despachado (S/)</th><th class="ci-num">Atención</th></tr></thead><tbody>
                @forelse($productosCliente as $i=>$p)
                    <tr><td>{{ $i+1 }}</td><td><strong>{{ $p->producto }}</strong></td><td>{{ $p->sku }}</td><td class="ci-num">{{ number_format($p->pedidos) }}</td><td class="ci-num"><strong>{{ number_format($p->solicitadas,0) }}</strong></td><td class="ci-num">{{ number_format($p->despachadas,0) }}</td><td class="ci-num">{{ number_format($p->faltantes,0) }}</td><td class="ci-num">S/ {{ number_format($p->precio_unitario_promedio,2) }}</td><td class="ci-num ci-money">S/ {{ number_format($p->venta_despachada,2) }}</td><td class="ci-num ci-money-loss">S/ {{ number_format($p->valor_no_despachado,2) }}</td><td class="ci-num">{{ number_format($p->atencion,2) }}%</td></tr>
                @empty<tr><td colspan="11" class="ci-empty">No hay productos registrados para este cliente en el período.</td></tr>@endforelse
                </tbody>
                @if($productosCliente->isNotEmpty())
                    @php $sumSolCli=(float)$productosCliente->sum('solicitadas'); $sumVentaSolCli=(float)$productosCliente->sum('venta_solicitada'); @endphp
                    <tfoot><tr><th colspan="4">TOTAL</th><th class="ci-num">{{ number_format($sumSolCli,0) }}</th>
                        <th class="ci-num">{{ number_format($productosCliente->sum('despachadas'),0) }}</th><th class="ci-num">{{ number_format($productosCliente->sum('faltantes'),0) }}</th>
                        <th class="ci-num">S/ {{ number_format($sumSolCli>0?$sumVentaSolCli/$sumSolCli:0,2) }}</th>
                        <th class="ci-num ci-money">S/ {{ number_format($productosCliente->sum('venta_despachada'),2) }}</th>
                        <th class="ci-num ci-money-loss">S/ {{ number_format($productosCliente->sum('valor_no_despachado'),2) }}</th><th></th>
                    </tr></tfoot>
                @endif
                </table></div>
            @else
                <div class="ci-empty">No se encontró el cliente solicitado dentro del tipo y período seleccionados. Vuelva al listado y selecciónelo nuevamente.</div>
            @endif
        </article>
    @endif
</div>
@endsection
