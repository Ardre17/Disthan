@extends('layouts.app')
@section('content')
<style>
.df-wrap{padding:22px;background:#f3f6fa;min-height:100vh;color:#172435;font-size:13px}
.df-head,.df-card{background:#fff;border:1px solid #e0e6ee;border-radius:12px}
.df-head{padding:20px;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}
.df-title{font-size:21px;font-weight:750;margin:0}.df-muted{color:#718096}.df-kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;margin-bottom:16px}
.df-kpi{padding:16px}.df-kpi small{color:#718096}.df-kpi strong{display:block;font-size:25px;margin-top:5px}
.df-card{padding:16px;margin-bottom:16px}.df-filters{display:flex;gap:9px;flex-wrap:wrap;margin-bottom:12px}.df-input{border:1px solid #d6deea;border-radius:8px;padding:9px 11px;background:#fff}
.df-btn{background:#1459a6;color:#fff;border:0;border-radius:8px;padding:9px 13px;text-decoration:none;cursor:pointer}.df-table-wrap{overflow:auto}table.df-table{width:100%;border-collapse:collapse;min-width:1050px} .df-table th{text-align:left;color:#64748b;font-size:11px;text-transform:uppercase;letter-spacing:.04em;background:#f7f9fc}
.df-table th,.df-table td{padding:11px 10px;border-bottom:1px solid #edf0f5;white-space:nowrap}.df-num{font-variant-numeric:tabular-nums;font-weight:650}.df-alert{color:#b45309}.df-good{color:#15803d}.df-bad{color:#b91c1c}.df-pill{padding:4px 8px;border-radius:20px;background:#eef4fb;color:#315b89;font-size:11px}.df-status{display:inline-block;padding:4px 8px;border-radius:20px;font-size:11px;font-weight:650;background:#eef2f7;color:#475569}.df-status-good{background:#dcfce7;color:#166534}.df-status-warn{background:#fef3c7;color:#92400e}.df-status-bad{background:#fee2e2;color:#991b1b}
@media(max-width:700px){.df-wrap{padding:12px}.df-head{padding:15px}.df-title{font-size:18px}}
</style>
<div class="df-wrap">
    <div class="df-head">
        <div>
            <h1 class="df-title">Planificación de Demanda y Stock</h1>
            <div class="df-muted">Proyección basada en órdenes de los últimos 180 días · Actualizada al {{ now()->format('d/m/Y') }}</div>
        </div>
        <span class="df-pill">28 días recientes: 60% · 152 días anteriores: 40%</span>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <div class="df-filters" style="margin:0 0 16px">
        <a class="df-btn" href="{{ route('demand-forecast.index') }}" style="background:{{ !request('section') ? '#1459a6' : '#64748b' }}">Demanda y stock</a>
        <a class="df-btn" href="{{ route('demand-forecast.index', ['section' => 'supermarkets']) }}" style="background:{{ request('section') === 'supermarkets' ? '#1459a6' : '#64748b' }}">Supermercados</a>
        <a class="df-btn" href="{{ route('demand-forecast.index', ['section' => 'clients']) }}" style="background:{{ request('section') === 'clients' ? '#1459a6' : '#64748b' }}">Clientes</a>
    </div>

    @if(request('section') === 'clients')
        <div class="df-kpis">
            <div class="df-card df-kpi"><small>Clientes LOCAL / ENCOMIENDA</small><strong>{{ $clientData['summary']['clients'] }}</strong></div>
            <div class="df-card df-kpi"><small>Órdenes en últimos 180 días</small><strong>{{ $clientData['summary']['orders'] }}</strong></div>
            <div class="df-card df-kpi"><small>Órdenes todavía abiertas</small><strong>{{ $clientData['summary']['pending_orders'] }}</strong></div>
            <div class="df-card df-kpi"><small>Unidades pendientes</small><strong>{{ number_format($clientData['summary']['pending_units'], 0) }}</strong></div>
        </div>
        <div class="df-card">
            <h2 style="font-size:17px;font-weight:750;margin:0 0 5px">Predicción de pedidos por cliente</h2>
            <p class="df-muted">Incluye únicamente órdenes LOCAL y ENCOMIENDA. La siguiente orden se estima con el promedio de lo realmente despachado por producto; los faltantes no se acumulan. Los pedidos abiertos se muestran aparte.</p>
            <div class="df-kpis" style="margin:12px 0">
                <div class="df-card df-kpi"><small>Despachados últimos 7 días</small><strong>{{ $clientData['summary']['group_counts']['recently_dispatched'] }}</strong></div>
                <div class="df-card df-kpi"><small>Próximos a pedir</small><strong>{{ $clientData['summary']['group_counts']['due_soon'] }}</strong></div>
                <div class="df-card df-kpi"><small>Baja frecuencia</small><strong>{{ $clientData['summary']['group_counts']['low_frequency'] }}</strong></div>
                <div class="df-card df-kpi"><small>Sin pedidos por más de 90 días</small><strong>{{ $clientData['summary']['group_counts']['inactive_90'] }}</strong></div>
            </div>
            <form method="GET" class="df-filters">
                <input type="hidden" name="section" value="clients">
                <select class="df-input" name="client_group" onchange="this.form.submit()">
                    <option value="all" @selected($clientData['selected_group'] === 'all')>Todos los clientes</option>
                    <option value="recently_dispatched" @selected($clientData['selected_group'] === 'recently_dispatched')>Despachados últimos 7 días</option>
                    <option value="due_soon" @selected($clientData['selected_group'] === 'due_soon')>Próximos a pedir / atrasados</option>
                    <option value="low_frequency" @selected($clientData['selected_group'] === 'low_frequency')>Baja frecuencia (más de 30 días)</option>
                    <option value="inactive_90" @selected($clientData['selected_group'] === 'inactive_90')>Sin pedidos por más de 90 días</option>
                    <option value="follow_up" @selected($clientData['selected_group'] === 'follow_up')>En seguimiento</option>
                </select>
            </form>
            <div class="df-table-wrap">
                <table class="df-table">
                    <thead><tr><th>Cliente</th><th>Estado de planificación</th><th>Órdenes</th><th>Último pedido</th><th>Último despacho</th><th>Frecuencia habitual</th><th>Próximo pedido estimado</th><th>Total solicitado</th><th>Total despachado</th><th>Promedio despachado / orden</th><th>Órdenes abiertas</th><th>Unidades pendientes</th></tr></thead>
                    <tbody>
                    @forelse($clientData['clients'] as $client)
                        <tr>
                            <td><strong>{{ $client['client_name'] }}</strong></td>
                            <td>
                                @if($client['planning_group'] === 'recently_dispatched')<span class="df-status df-status-good">Despachado reciente</span>
                                @elseif($client['planning_group'] === 'due_soon')<span class="df-status df-status-warn">Próximo a pedir</span>
                                @elseif($client['planning_group'] === 'low_frequency')<span class="df-status">Baja frecuencia</span>
                                @elseif($client['planning_group'] === 'inactive_90')<span class="df-status df-status-bad">Inactivo +90 días</span>
                                @else<span class="df-status">En seguimiento</span>@endif
                            </td>
                            <td>{{ $client['order_count'] }}</td>
                            <td>{{ $client['last_order'] ? $client['last_order']->format('d/m/Y') : 'Sin historial' }}</td>
                            <td>{{ $client['last_dispatch_date'] ? $client['last_dispatch_date']->format('d/m/Y') : 'Sin despacho' }}</td>
                            <td>{{ $client['average_interval'] !== null ? number_format($client['average_interval'], 1).' días' : 'Insuficiente historial' }}</td>
                            <td>
                                @if($client['next_order'])
                                    <strong>{{ $client['next_order']->format('d/m/Y') }}</strong>
                                    @if($client['days_until_next'] < 0)<br><small class="df-bad">Atrasado {{ abs($client['days_until_next']) }} días</small>
                                    @elseif($client['days_until_next'] <= 3)<br><small class="df-alert">Próximo en {{ $client['days_until_next'] }} días</small>@endif
                                @else<span class="df-muted">Por calcular</span>@endif
                            </td>
                            <td class="df-num">{{ number_format($client['total_requested'] ?? 0, 0) }}</td>
                            <td class="df-num">{{ number_format($client['total_dispatched'], 0) }}</td>
                            <td>{{ number_format($client['average_order_quantity'], 1) }}</td>
                            <td>{{ $client['pending_orders'] }}</td>
                            <td class="df-alert">{{ number_format($client['pending_units'], 0) }}</td>
                        </tr>
                        <tr><td colspan="12" style="padding:8px 12px 16px;background:#fafbfd">
                            <details>
                                <summary style="cursor:pointer;color:#1459a6;font-weight:650">Ver productos y proyección de {{ $client['client_name'] }}</summary>
                                <div class="df-table-wrap" style="margin-top:10px">
                                    <table class="df-table" style="min-width:1150px;background:white">
                                        <thead><tr><th>Producto</th><th>Órdenes con solicitud</th><th>Total solicitado</th><th>Total despachado</th><th>No atendido</th><th>Atención (%)</th><th>Promedio despachado por orden</th><th>Frecuencia</th><th>Última recepción</th><th>Ciclos acumulados</th><th>Siguiente orden estimada</th><th>Adicional descontando pendiente</th><th>Pendiente abierto</th></tr></thead>
                                        <tbody>
                                        @forelse($client['products'] as $item)
                                            <tr>
                                                <td><strong>{{ $item['name'] }}</strong><br><small class="df-muted">{{ $item['sku'] }}</small></td>
                                                <td>{{ $item['orders'] }}</td><td>{{ number_format($item['total_requested'], 1) }}</td>
                                                <td>{{ number_format($item['total_dispatched'], 1) }}</td><td>{{ number_format($item['total_unfulfilled'], 1) }}</td>
                                                <td>{{ number_format($item['fulfillment_rate'], 1) }}%</td><td>{{ number_format($item['average_quantity'], 1) }}</td>
                                                <td>{{ $item['frequency_days'] ? $item['frequency_days'].' días' : 'Sin patrón' }}</td>
                                                <td>{{ $item['last_order'] ? $item['last_order']->format('d/m/Y') : 'Sin recepción' }}</td>
                                                <td>{{ $item['elapsed_cycles'] }}</td>
                                                <td class="df-num">{{ number_format($item['expected_next_order'], 1) }} @if($item['expected_boxes'] !== null)<br><small class="df-muted">≈ {{ $item['expected_boxes'] }} cajas</small>@endif</td>
                                                <td class="df-good">{{ number_format($item['expected_additional'], 1) }}</td>
                                                <td class="df-alert">{{ number_format($item['pending'], 1) }}</td>
                                            </tr>
                                        @empty<tr><td colspan="13" class="df-muted">Sin historial de productos para este cliente.</td>@endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </details>
                        </td></tr>
                    @empty<tr><td colspan="12" class="df-muted">No hay clientes para este grupo o no hay órdenes LOCAL / ENCOMIENDA en el historial.</td></tr>@endforelse
                    </tbody>
                </table>
            </div>
            <p class="df-muted" style="margin-top:12px">Para LOCAL y ENCOMIENDA, la siguiente orden por producto utiliza el promedio aritmético de lo despachado en las órdenes donde se solicitó ese producto, incluyendo como cero las órdenes donde no se logró despachar. Las cantidades no atendidas no se acumulan ni se agregan a la proyección. Los pedidos PARCIAL e INCOMPLETO se muestran como compromisos abiertos y se descuentan de la necesidad adicional. Los grupos se clasifican por último despacho, fecha estimada de compra, frecuencia histórica e inactividad superior a 90 días. La sección de supermercados mantiene su cálculo independiente.</p>
        </div>
    @elseif(request('section') === 'supermarkets')
        <div class="df-kpis">
            <div class="df-card df-kpi"><small>Supermercados con actividad</small><strong>{{ $supermarketData['summary']['clients'] }}</strong></div>
            <div class="df-card df-kpi"><small>Órdenes en últimos 180 días</small><strong>{{ $supermarketData['summary']['orders'] }}</strong></div>
            <div class="df-card df-kpi"><small>Órdenes todavía abiertas</small><strong>{{ $supermarketData['summary']['pending_orders'] }}</strong></div>
            <div class="df-card df-kpi"><small>Unidades pendientes</small><strong>{{ number_format($supermarketData['summary']['pending_units'], 0) }}</strong></div>
        </div>

        <div class="df-card">
            <h2 style="font-size:17px;font-weight:750;margin:0 0 5px">Planificación por supermercado</h2>
            <p class="df-muted">Frecuencia y cantidades calculadas con despachos reales de los últimos 180 días. Los compromisos abiertos se muestran por separado.</p>
            <div class="df-table-wrap">
                <table class="df-table">
                    <thead><tr><th>Supermercado</th><th>Órdenes</th><th>Último pedido</th><th>Frecuencia media</th><th>Próximo pedido estimado</th><th>Unidades despachadas</th><th>Promedio por orden</th><th>Órdenes abiertas</th><th>Unidades pendientes</th></tr></thead>
                    <tbody>
                    @forelse($supermarketData['clients'] as $client)
                        <tr>
                            <td><strong>{{ $client['client_name'] }}</strong></td>
                            <td>{{ $client['order_count'] }}</td>
                            <td>{{ $client['last_order'] ? $client['last_order']->format('d/m/Y') : 'Sin historial' }}</td>
                            <td>{{ $client['average_interval'] !== null ? number_format($client['average_interval'], 1).' días' : 'Insuficiente historial' }}</td>
                            <td>
                                @if($client['next_order'])
                                    <strong>{{ $client['next_order']->format('d/m/Y') }}</strong>
                                    @if($client['days_until_next'] < 0)<br><small class="df-bad">Atrasado {{ abs($client['days_until_next']) }} días</small>
                                    @elseif($client['days_until_next'] <= 3)<br><small class="df-alert">Próximo en {{ $client['days_until_next'] }} días</small>@endif
                                @else
                                    <span class="df-muted">Por calcular</span>
                                @endif
                            </td>
                            <td class="df-num">{{ number_format($client['total_dispatched'], 0) }}</td>
                            <td>{{ number_format($client['average_order_quantity'], 1) }}</td>
                            <td>{{ $client['pending_orders'] }}</td>
                            <td class="df-alert">{{ number_format($client['pending_units'], 0) }}</td>
                        </tr>
                        <tr><td colspan="9" style="padding:8px 12px 16px;background:#fafbfd">
                            <details>
                                <summary style="cursor:pointer;color:#1459a6;font-weight:650">Ver productos y cantidades habituales de {{ $client['client_name'] }}</summary>
                                <div class="df-table-wrap" style="margin-top:10px">
                                    <table class="df-table" style="min-width:750px;background:white">
                                        <thead><tr><th>Producto</th><th>SKU</th><th>Órdenes con solicitud</th><th>Total solicitado</th><th>Total despachado</th><th>Atención (%)</th><th>Promedio solicitado por orden</th><th>Frecuencia</th><th>Última recepción estimada</th><th>Última recepción (unid.)</th><th>Último faltante solicitado</th><th>Ciclos acumulados</th><th>Siguiente orden estimada</th><th>Adicional descontando pendiente</th><th>Pendiente abierto</th></tr></thead>
                                        <tbody>
                                        @forelse($client['products'] as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td><td>{{ $item['sku'] }}</td><td>{{ $item['orders'] }}</td>
                                                <td>{{ number_format($item['total_requested'], 0) }}</td><td>{{ number_format($item['total_dispatched'], 0) }}</td>
                                                <td>{{ number_format($item['fulfillment_rate'], 1) }}%</td><td>{{ number_format($item['average_quantity'], 1) }}</td>
                                                <td>{{ $item['frequency_days'] ? $item['frequency_days'].' días' : 'Sin patrón' }}</td>
                                                <td>{{ $item['last_order'] ? $item['last_order']->format('d/m/Y') : 'Sin despacho' }}</td>
                                                <td>{{ number_format($item['last_received_quantity'], 1) }}</td>
                                                <td>{{ number_format($item['last_request_unfulfilled'], 1) }} unid.</td>
                                                <td>{{ $item['last_order'] ? $item['elapsed_cycles'] : '—' }}</td>
                                                <td class="df-num">{{ number_format($item['expected_next_order'], 1) }} @if($item['expected_boxes'] !== null)<br><small class="df-muted">≈ {{ $item['expected_boxes'] }} cajas</small>@endif</td>
                                                <td class="df-good">{{ number_format($item['expected_additional'], 1) }} @if($item['additional_boxes'] !== null)<br><small class="df-muted">≈ {{ $item['additional_boxes'] }} cajas</small>@endif</td>
                                                <td class="df-alert">{{ number_format($item['pending'], 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="15" class="df-muted">Este cliente todavía no tiene productos solicitados o despachados en el periodo.</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </details>
                        </td></tr>
                    @empty
                        <tr><td colspan="9" class="df-muted">No hay órdenes de tipo SUPERMERCADO en los últimos 180 días.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <p class="df-muted" style="margin-top:12px">El promedio habitual se calcula con la mediana de las cantidades SOLICITADAS por orden, no solamente con lo despachado. Se muestran por separado lo solicitado, lo efectivamente despachado y el porcentaje de atención. Las diferencias de órdenes COMPLETO sirven como señal histórica de demanda no atendida, pero no se convierten en compromisos de despacho. La proyección acumula ciclos desde la última recepción estimada; si el producto nunca fue recibido, utiliza la primera solicitud como referencia. Una entrega extraordinaria puede moderar la estimación, pero nunca reducirla por debajo de un ciclo habitual. El faltante de la última solicitud se suma como señal de demanda potencial. “Adicional descontando pendiente” resta únicamente los saldos de órdenes PARCIAL e INCOMPLETO. Esta cifra es una estimación, no un pedido confirmado. La fecha de recepción se aproxima con la fecha de preparación del detalle y, si no existe, con la fecha de entrega o pedido. La equivalencia en cajas utiliza cantidad_por_caja del producto.</p>
        </div>
    @else
    <div class="df-kpis">
        <div class="df-card df-kpi"><small>Productos analizados</small><strong>{{ $summary['products'] }}</strong></div>
        <div class="df-card df-kpi"><small>Cobertura crítica (≤ 7 días)</small><strong class="df-bad">{{ $summary['critical'] }}</strong></div>
        <div class="df-card df-kpi"><small>Productos por producir</small><strong class="df-alert">{{ $summary['to_produce'] }}</strong></div>
        <div class="df-card df-kpi"><small>Unidades pendientes en órdenes</small><strong>{{ number_format($summary['pending'], 0) }}</strong></div>
    </div>

    <div class="df-card">
        <form method="GET" class="df-filters">
            <input class="df-input" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar producto o SKU">
            <select class="df-input" name="category_id"><option value="">Todas las categorías</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id')==$category->id)>{{ $category->nombre }}</option>@endforeach</select>
            <button class="df-btn">Filtrar</button>
            <a class="df-btn" style="background:#64748b" href="{{ route('demand-forecast.index') }}">Limpiar</a>
        </form>
        <div class="df-table-wrap">
            <table class="df-table">
                <thead><tr>
                    <th>Producto</th><th>Stock físico</th><th>Demanda diaria</th><th>7 días</th><th>15 días</th><th>30 días</th><th>Pendiente abierto</th><th>Disponible</th><th>En producción</th><th>Cobertura</th><th>Mín. recomendado</th><th>Stock objetivo</th><th>Producir</th><th>Parámetros</th>
                </tr></thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td><strong>{{ $product->nombre }}</strong><br><span class="df-muted">{{ $product->sku }}</span></td>
                        <td class="df-num">{{ number_format($product->stock,0) }}</td>
                        <td class="df-num">{{ number_format($product->forecast['daily_demand'],2) }}</td>
                        <td>{{ number_format($product->forecast['demand_7d'],0) }}</td>
                        <td>{{ number_format($product->forecast['demand_15d'],0) }}</td>
                        <td>{{ number_format($product->forecast['demand_30d'],0) }}</td>
                        <td class="df-alert">{{ number_format($product->forecast['pending'],0) }}</td>
                        <td class="df-num">{{ number_format($product->forecast['available_stock'],0) }}</td>
                        <td>{{ number_format($product->forecast['in_production'],0) }}</td>
                        <td class="{{ $product->forecast['coverage_days'] !== null && $product->forecast['coverage_days'] <= 7 ? 'df-bad' : '' }}">{{ $product->forecast['coverage_days'] !== null ? $product->forecast['coverage_days'].' días' : 'Sin demanda' }}</td>
                        <td>{{ number_format($product->forecast['minimum_to_use'],0) }}<br><small class="df-muted">Calculado: {{ number_format($product->forecast['recommended_minimum'],0) }} · Aprobado: {{ $product->forecast['approved_minimum'] !== null ? number_format($product->forecast['approved_minimum'],0) : 'Sin definir' }}</small></td>
                        <td class="df-num">{{ number_format($product->forecast['target_stock'],0) }}</td>
                        <td class="df-num {{ $product->forecast['to_produce'] > 0 ? 'df-alert' : 'df-good' }}">{{ number_format($product->forecast['to_produce'],0) }}</td>
                        <td>
                            <details><summary style="cursor:pointer;color:#1459a6">Configurar</summary>
                                <form method="POST" action="{{ route('demand-forecast.settings', $product) }}" style="padding:9px 0;min-width:190px">
                                    @csrf @method('PUT')
                                    <label>Días reposición <input class="df-input" type="number" min="0" name="lead_time_days" value="{{ $product->forecast['lead_time_days'] }}" required></label>
                                    <label>Días seguridad <input class="df-input" type="number" min="0" name="safety_days" value="{{ $product->forecast['safety_days'] }}" required></label>
                                    <label>Cobertura objetivo <input class="df-input" type="number" min="1" name="coverage_days" value="{{ $product->forecast['coverage_target_days'] }}" required></label>
                                    <label>Mínimo aprobado <input class="df-input" type="number" min="0" step="0.001" name="approved_min_stock" value="{{ $product->forecast['approved_minimum'] }}" placeholder="Opcional"></label>
                                    <button class="df-btn" style="margin-top:7px">Guardar</button>
                                </form>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="14" class="df-muted">No hay productos que coincidan con los filtros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <p class="df-muted" style="margin:12px 0 0">La demanda histórica incluye órdenes no anuladas, incluso COMPLETO. Los compromisos pendientes solo incluyen órdenes PARCIAL e INCOMPLETO. La producción en proceso se muestra por separado y no se suma al stock físico disponible.</p>
    </div>
    @endif
</div>
@endsection
