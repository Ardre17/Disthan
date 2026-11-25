@extends('layouts.app')

@section('content')
<style>
.ci{--navy:#1e3a5f;--blue:#1d7ff2;--line:#e2e8f0;--muted:#64748b;--text:#0f172a;background:#eef1f5;padding:20px;color:var(--text);font-family:'Segoe UI',Arial,sans-serif;min-height:100vh}
.ci *{box-sizing:border-box}.ci-head{background:var(--navy);color:#fff;border-radius:12px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px}.ci-head h1{font-size:21px;margin:0 0 4px;font-weight:800}.ci-head p{margin:0;color:#cbdcf0;font-size:12px}.ci-tag{font-size:11px;background:#294d75;padding:6px 10px;border-radius:7px;white-space:nowrap}
.ci-filters{background:#fff;border:1px solid var(--line);border-radius:12px;padding:13px;margin-bottom:14px;display:flex;gap:10px;align-items:end;flex-wrap:wrap}.ci-field{display:flex;flex-direction:column;gap:4px;min-width:145px}.ci-field label{font-size:10px;text-transform:uppercase;letter-spacing:.05em;font-weight:800;color:var(--muted)}.ci-field input,.ci-field select{height:36px;border:1px solid #cbd5e1;border-radius:7px;padding:0 9px;font:inherit;font-size:12px;min-width:145px;background:#fff}.ci-field.product-field{min-width:250px;flex:1}.ci-field.product-field input{width:100%}.ci-btn{height:36px;padding:0 14px;border:0;border-radius:7px;background:var(--blue);color:#fff;font-weight:700;font-size:12px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}.ci-btn.light{background:#eef4fc;color:#1d4ed8;border:1px solid #cfe0fb}
.ci-tabs{display:flex;gap:7px;margin:0 0 14px;border-bottom:1px solid #d8e0ea}.ci-tab{padding:10px 15px;background:#e7edf5;color:#52647a;text-decoration:none;font-size:12px;font-weight:800;border-radius:8px 8px 0 0}.ci-tab.active{background:#fff;color:#1d4ed8;border:1px solid var(--line);border-bottom:1px solid #fff;margin-bottom:-1px}
.ci-kpis{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:11px;margin-bottom:14px}.ci-kpi{background:#fff;border:1px solid var(--line);border-radius:12px;padding:14px 15px;min-width:0}.ci-kpi small{display:block;color:var(--muted);font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}.ci-kpi strong{display:block;font-size:25px;line-height:1.25;margin:5px 0 2px;font-weight:800;font-variant-numeric:tabular-nums}.ci-kpi span{font-size:10px;color:#94a3b8}.ci-kpi.blue{border-top:3px solid #1d7ff2}.ci-kpi.green{border-top:3px solid #16a34a}.ci-kpi.orange{border-top:3px solid #f59e0b}.ci-kpi.red{border-top:3px solid #ef4444}.ci-kpi.purple{border-top:3px solid #7c3aed}
.ci-grid{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(300px,.75fr);gap:14px;margin-bottom:14px}.ci-card{background:#fff;border:1px solid var(--line);border-radius:12px;padding:15px;min-width:0;margin-bottom:14px}.ci-card h2{font-size:14px;margin:0 0 12px;color:var(--navy);font-weight:800}.ci-sub{font-size:11px;color:var(--muted);font-weight:500;margin-left:5px}.ci-table-wrap{overflow:auto}.ci-table{border-collapse:collapse;width:100%;font-size:11.5px;white-space:nowrap}.ci-table th{text-align:left;padding:9px 8px;background:#f8fafc;color:#475569;font-size:10px;text-transform:uppercase;letter-spacing:.03em;border-bottom:1px solid var(--line)}.ci-table td{padding:9px 8px;border-bottom:1px solid #eef2f7}.ci-table tr:last-child td{border-bottom:0}.ci-num{text-align:right;font-variant-numeric:tabular-nums;font-family:Consolas,monospace}.ci-muted{color:var(--muted)}.ci-pill{display:inline-flex;padding:4px 8px;border-radius:6px;font-size:9px;font-weight:900}.p-alta{background:#fee2e2;color:#b91c1c}.p-media{background:#fef3c7;color:#92400e}.p-seguimiento{background:#dbeafe;color:#1d4ed8}.p-atendido{background:#dcfce7;color:#15803d}
.ci-bars{display:flex;flex-direction:column;gap:12px}.ci-bar-row{display:grid;grid-template-columns:145px 1fr 65px;gap:9px;align-items:center;font-size:11px}.ci-bar-track{height:9px;border-radius:99px;background:#edf2f7;overflow:hidden}.ci-bar-fill{height:100%;border-radius:99px;background:#1d7ff2}.ci-legend{display:flex;gap:12px;flex-wrap:wrap;margin-top:5px;font-size:10px;color:var(--muted)}.ci-dot{display:inline-block;width:8px;height:8px;border-radius:3px;margin-right:4px}.ci-empty{text-align:center;color:#94a3b8;padding:22px;font-size:12px}.ci-foot{font-size:10px;color:#64748b;line-height:1.5;margin-top:12px}.ci-link{color:#1d4ed8;text-decoration:none;font-weight:800}.ci-link:hover{text-decoration:underline}.ci-back{display:inline-flex;margin-bottom:10px;color:#1d4ed8;text-decoration:none;font-size:12px;font-weight:800}.ci-detail-head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
@media(max-width:1100px){.ci-kpis{grid-template-columns:repeat(3,1fr)}.ci-grid{grid-template-columns:1fr}}@media(max-width:650px){.ci{padding:10px}.ci-head{align-items:flex-start;flex-direction:column}.ci-kpis{grid-template-columns:1fr 1fr}.ci-kpi strong{font-size:21px}.ci-field{flex:1;min-width:calc(50% - 8px)}.ci-field input,.ci-field select{width:100%;min-width:0}.ci-field.product-field{min-width:100%}.ci-btn{flex:1}.ci-tab{flex:1;text-align:center;padding:9px 5px}.ci-bar-row{grid-template-columns:110px 1fr 55px}}
</style>

@php
    $filterParams = array_filter([
        'desde' => $desde, 'hasta' => $hasta, 'tipo_cliente' => $tipoCliente,
    ], fn($v) => $v !== null && $v !== '');
    $matrixParams = array_merge($filterParams, ['vista' => 'matriz']);
    $clientParams = array_merge($filterParams, ['vista' => 'clientes']);
@endphp

<div class="ci">
    <header class="ci-head">
        <div><h1>Inteligencia Comercial</h1><p>Análisis de demanda, nivel de atención y comportamiento de compra por cliente</p></div>
        <span class="ci-tag">DISTAN ERP · SOLO LECTURA</span>
    </header>

    <form method="GET" action="{{ route('commercial-intelligence.index') }}" class="ci-filters">
        <input type="hidden" name="vista" value="{{ $vista }}">
        <div class="ci-field"><label>Desde</label><input type="date" name="desde" value="{{ $desde }}"></div>
        <div class="ci-field"><label>Hasta</label><input type="date" name="hasta" value="{{ $hasta }}"></div>
        <div class="ci-field"><label>Tipo de cliente</label>
            <select name="tipo_cliente">
                <option value="">Todos los tipos</option>
                @foreach(['MAYORISTA'=>'Mayorista','MINORISTA'=>'Minorista','SUPERMERCADOS'=>'Supermercados'] as $valor=>$texto)
                    <option value="{{ $valor }}" @selected($tipoCliente === $valor)>{{ $texto }}</option>
                @endforeach
            </select>
        </div>
        @if($vista === 'matriz')
            <div class="ci-field"><label>Cliente</label><select name="cliente"><option value="">Todos los clientes</option>@foreach($clientes as $cliente)<option value="{{ $cliente->id }}" @selected((string)($validated['cliente'] ?? '') === (string)$cliente->id)>{{ $cliente->nombre }}</option>@endforeach</select></div>
            <div class="ci-field product-field"><label>Producto (escriba para buscar)</label>
                <input type="text" name="producto" list="ci-productos" value="{{ $validated['producto'] ?? '' }}" placeholder="Escriba el nombre del producto..." autocomplete="off">
                <datalist id="ci-productos">@foreach($productosFiltro as $producto)<option value="{{ $producto->nombre }}" label="SKU: {{ $producto->sku }}"></option>@endforeach</datalist>
            </div>
            <div class="ci-field"><label>Prioridad</label><select name="prioridad"><option value="">Todas</option>@foreach(['ALTA','MEDIA','SEGUIMIENTO','ATENDIDO'] as $p)<option value="{{ $p }}" @selected(($validated['prioridad'] ?? '') === $p)>{{ $p }}</option>@endforeach</select></div>
        @endif
        @if($vista === 'detalle')<input type="hidden" name="cliente_detalle" value="{{ $validated['cliente_detalle'] ?? '' }}">@endif
        <button class="ci-btn" type="submit">Aplicar filtros</button>
        <a class="ci-btn light" href="{{ route('commercial-intelligence.index', ['vista'=>$vista]) }}">Limpiar</a>
    </form>

    <nav class="ci-tabs">
        <a class="ci-tab {{ $vista === 'matriz' ? 'active' : '' }}" href="{{ route('commercial-intelligence.index', $matrixParams) }}">Matriz de prioridad</a>
        <a class="ci-tab {{ in_array($vista, ['clientes','detalle'], true) ? 'active' : '' }}" href="{{ route('commercial-intelligence.index', $clientParams) }}">Análisis por cliente</a>
    </nav>

    <section class="ci-kpis">
        <div class="ci-kpi blue"><small>Pedidos analizados</small><strong>{{ number_format((int)($totales->pedidos ?? 0)) }}</strong><span>{{ $tipoCliente ? str_replace('_',' ', $tipoCliente) : 'Todos los segmentos' }}</span></div>
        <div class="ci-kpi"><small>Unidades solicitadas</small><strong>{{ number_format($solicitadas,0) }}</strong><span>Demanda acumulada</span></div>
        <div class="ci-kpi green"><small>Unidades despachadas</small><strong>{{ number_format($despachadas,0) }}</strong><span>Atención registrada</span></div>
        <div class="ci-kpi red"><small>Faltantes históricos</small><strong>{{ number_format($faltantes,0) }}</strong><span>Faltante positivo por línea</span></div>
        <div class="ci-kpi purple"><small>Nivel de atención</small><strong>{{ number_format($atencion,2) }}%</strong><span>Despachado / solicitado</span></div>
    </section>

    @if($vista === 'matriz')
        <article class="ci-card">
            <h2>Matriz de prioridad · {{ $tipoCliente ? str_replace('_',' ', $tipoCliente) : 'Todos los tipos de cliente' }} <span class="ci-sub">{{ number_format($matrixTotales['filas']) }} combinaciones cliente / producto</span></h2>
            <div class="ci-legend"><span><i class="ci-dot" style="background:#ef4444"></i>ALTA: ≥ 70</span><span><i class="ci-dot" style="background:#f59e0b"></i>MEDIA: 45–69.99</span><span><i class="ci-dot" style="background:#3b82f6"></i>SEGUIMIENTO: menor de 45</span><span><i class="ci-dot" style="background:#16a34a"></i>ATENDIDO: sin faltante</span></div>
            <div class="ci-table-wrap" style="margin-top:10px"><table class="ci-table"><thead><tr><th>Prioridad</th><th>Cliente</th><th>Producto</th><th>SKU</th><th class="ci-num">Pedidos</th><th class="ci-num">Solicitado</th><th class="ci-num">Despachado</th><th class="ci-num">Faltante</th><th class="ci-num">Atención</th><th class="ci-num">Índice</th></tr></thead><tbody>
            @forelse($matrix as $r)
                @php $cls = ['ALTA'=>'p-alta','MEDIA'=>'p-media','SEGUIMIENTO'=>'p-seguimiento','ATENDIDO'=>'p-atendido'][$r->prioridad]; @endphp
                <tr><td><span class="ci-pill {{ $cls }}">{{ $r->prioridad }}</span></td><td>{{ $r->cliente }}</td><td>{{ $r->producto }}</td><td><strong>{{ $r->sku }}</strong></td><td class="ci-num">{{ number_format($r->pedidos) }}</td><td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td><td class="ci-num"><strong>{{ number_format($r->faltantes,0) }}</strong></td><td class="ci-num">{{ number_format($r->atencion,2) }}%</td><td class="ci-num">{{ number_format($r->indice,2) }}</td></tr>
            @empty<tr><td colspan="10" class="ci-empty">No hay combinaciones que coincidan con los filtros.</td></tr>@endforelse
            </tbody></table></div>
            <p class="ci-foot">Metodología: V = faltante de la combinación / máximo faltante del cliente × 100; B = 100 − nivel de atención; F = pedidos de la combinación / máximo de pedidos del cliente × 100. Índice = 0.40V + 0.35B + 0.25F. Faltante = suma de GREATEST(solicitado − despachado, 0) por línea. No se compensan excedentes entre SKU. Se excluyen exportaciones y estados distintos de COMPLETO, INCOMPLETO y PARCIAL.</p>
        </article>

        <section class="ci-grid">
            <article class="ci-card">
                <h2>Demanda y atención por segmento</h2>
                <div class="ci-table-wrap"><table class="ci-table"><thead><tr><th>Segmento</th><th class="ci-num">Pedidos</th><th class="ci-num">Solicitadas</th><th class="ci-num">Despachadas</th><th class="ci-num">Faltantes</th><th class="ci-num">Atención</th></tr></thead><tbody>
                @forelse($porTipo as $r) @php $pct = (float)$r->solicitadas > 0 ? ((float)$r->despachadas/(float)$r->solicitadas)*100 : 0; @endphp
                    <tr><td><strong>{{ $r->tipo }}</strong></td><td class="ci-num">{{ number_format($r->pedidos) }}</td><td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td><td class="ci-num">{{ number_format($r->faltantes,0) }}</td><td class="ci-num">{{ number_format($pct,2) }}%</td></tr>
                @empty<tr><td colspan="6" class="ci-empty">No hay información para el período seleccionado.</td></tr>@endforelse
                </tbody></table></div>
            </article>
            <article class="ci-card">
                <h2>Top productos con faltantes <span class="ci-sub">Por unidades</span></h2>
                <div class="ci-bars">
                    @php $maxF = max(1, (float)($topProductos->max('faltantes') ?? 0)); @endphp
                    @forelse($topProductos as $p)
                        <div class="ci-bar-row"><div title="{{ $p->nombre }}"><strong>{{ $p->nombre }}</strong><br><span class="ci-muted">SKU: {{ $p->sku }}</span></div><div class="ci-bar-track"><div class="ci-bar-fill" style="width:{{ min(100,((float)$p->faltantes/$maxF)*100) }}%"></div></div><strong class="ci-num">{{ number_format($p->faltantes,0) }}</strong></div>
                    @empty<div class="ci-empty">Sin faltantes registrados.</div>@endforelse
                </div>
            </article>
        </section>

    @elseif($vista === 'clientes')
        <article class="ci-card">
            <h2>Clientes · {{ $tipoCliente ? str_replace('_',' ', $tipoCliente) : 'Todos los tipos' }} <span class="ci-sub">{{ number_format($resumenClientes->count()) }} clientes con pedidos en el período</span></h2>
            <p class="ci-foot" style="margin:0 0 10px">Seleccione el nombre de un cliente para consultar su detalle de productos.</p>
            <div class="ci-table-wrap"><table class="ci-table"><thead><tr><th>Cliente</th><th class="ci-num">Pedidos</th><th class="ci-num">Unidades solicitadas</th><th class="ci-num">Unidades despachadas</th><th class="ci-num">Faltantes</th><th class="ci-num">Nivel de atención</th><th>Detalle</th></tr></thead><tbody>
            @forelse($resumenClientes as $r)
                <tr><td><strong>{{ $r->cliente }}</strong></td><td class="ci-num">{{ number_format($r->pedidos) }}</td><td class="ci-num">{{ number_format($r->solicitadas,0) }}</td><td class="ci-num">{{ number_format($r->despachadas,0) }}</td><td class="ci-num">{{ number_format($r->faltantes,0) }}</td><td class="ci-num">{{ number_format($r->atencion,2) }}%</td><td><a class="ci-link" href="{{ route('commercial-intelligence.index', array_merge($filterParams, ['vista'=>'detalle','cliente_detalle'=>$r->client_id])) }}">Ver productos →</a></td></tr>
            @empty<tr><td colspan="7" class="ci-empty">No hay clientes con pedidos para los filtros seleccionados.</td></tr>@endforelse
            </tbody></table></div>
        </article>

    @else
        <article class="ci-card">
            <a class="ci-back" href="{{ route('commercial-intelligence.index', $clientParams) }}">← Volver a todos los clientes</a>
            @if($clienteDetalle)
                <div class="ci-detail-head"><h2>Productos solicitados por {{ $clienteDetalle->nombre }}</h2><span class="ci-sub">Ordenados de mayor a menor por unidades solicitadas</span></div>
                <div class="ci-table-wrap"><table class="ci-table"><thead><tr><th>#</th><th>Producto</th><th>SKU</th><th class="ci-num">Pedidos</th><th class="ci-num">Solicitado</th><th class="ci-num">Despachado</th><th class="ci-num">Faltante</th><th class="ci-num">Atención</th></tr></thead><tbody>
                @forelse($productosCliente as $i=>$p)
                    <tr><td>{{ $i+1 }}</td><td><strong>{{ $p->producto }}</strong></td><td>{{ $p->sku }}</td><td class="ci-num">{{ number_format($p->pedidos) }}</td><td class="ci-num"><strong>{{ number_format($p->solicitadas,0) }}</strong></td><td class="ci-num">{{ number_format($p->despachadas,0) }}</td><td class="ci-num">{{ number_format($p->faltantes,0) }}</td><td class="ci-num">{{ number_format($p->atencion,2) }}%</td></tr>
                @empty<tr><td colspan="8" class="ci-empty">No hay productos registrados para este cliente en el período.</td></tr>@endforelse
                </tbody></table></div>
            @else
                <div class="ci-empty">No se encontró el cliente solicitado dentro del tipo y período seleccionados. Vuelva al listado y selecciónelo nuevamente.</div>
            @endif
        </article>
    @endif
</div>
@endsection
