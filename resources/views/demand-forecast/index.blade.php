@extends('layouts.app')
@section('content')
<style>
.df-wrap{--df-navy:#172b4d;--df-blue:#2563eb;--df-teal:#0f9f91;--df-purple:#7c3aed;--df-orange:#d97706;--df-red:#dc2626;--df-muted:#718096;--df-border:#e5eaf1;background:#f3f6fb;min-height:100vh;padding:24px;color:#172435;font-size:13px}
.df-wrap *{box-sizing:border-box}.df-hero{background:linear-gradient(115deg,#172b4d 0%,#244d80 62%,#2563a6 100%);color:#fff;border-radius:18px;padding:24px 26px;margin-bottom:18px;display:flex;justify-content:space-between;align-items:center;gap:18px;box-shadow:0 12px 28px rgba(23,43,77,.13)}
.df-hero h1{font-size:24px;font-weight:800;letter-spacing:-.03em;margin:0 0 5px}.df-hero p{color:#dbeafe;margin:0;font-size:12px}.df-hero-meta{display:flex;gap:8px;align-items:center;flex-wrap:wrap}.df-hero-chip{border:1px solid rgba(255,255,255,.22);background:rgba(255,255,255,.12);padding:8px 11px;border-radius:10px;color:#eff6ff;font-size:11px;font-weight:650}
.df-nav{display:flex;gap:7px;flex-wrap:wrap;margin:0 0 18px;padding:6px;background:#e8edf5;border-radius:13px;width:max-content;max-width:100%}.df-nav .df-btn{background:transparent!important;color:#53647b;border:0;padding:10px 15px;border-radius:9px;font-weight:700;transition:.18s}.df-nav .df-btn:hover{background:#fff!important;color:#172b4d}.df-nav .df-btn.df-active{background:#fff!important;color:#1d4ed8;box-shadow:0 2px 8px rgba(23,43,77,.09)}
.df-card{background:#fff;border:1px solid var(--df-border);border-radius:15px;padding:18px;margin-bottom:16px;box-shadow:0 3px 12px rgba(30,55,90,.035)}.df-section-head{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:14px}.df-section-title{font-size:16px;font-weight:800;color:#172b4d;margin:0}.df-section-sub{font-size:11px;color:#8290a3;margin:4px 0 0}.df-muted{color:#718096}.df-kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px;margin-bottom:16px}.df-kpi{position:relative;overflow:hidden;padding:17px 18px;min-height:112px}.df-kpi:after{content:"";position:absolute;right:-20px;top:-25px;width:88px;height:88px;border-radius:50%;background:var(--kpi-tint,#eff6ff)}.df-kpi-top{display:flex;align-items:center;justify-content:space-between;gap:8px;position:relative;z-index:1}.df-kpi small{font-size:11px;color:#718096;font-weight:650}.df-kpi strong{display:block;font-size:27px;line-height:1.2;color:#172b4d;margin-top:11px;font-weight:800;letter-spacing:-.03em;position:relative;z-index:1}.df-kpi-icon{width:34px;height:34px;display:grid;place-items:center;border-radius:10px;background:var(--kpi-tint,#eff6ff);color:var(--kpi-color,#2563eb);font-size:17px;position:relative;z-index:1}.df-kpi-foot{font-size:10px;color:#94a3b8;margin-top:4px;position:relative;z-index:1}
.df-chart-grid{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,1fr);gap:15px;margin-bottom:16px}.df-chart-card{background:#fff;border:1px solid var(--df-border);border-radius:15px;padding:18px;min-width:0;box-shadow:0 3px 12px rgba(30,55,90,.035)}.df-chart-card h3{font-size:13px;color:#263b59;font-weight:800;margin:0}.df-chart-card p{font-size:10px;color:#94a3b8;margin:4px 0 12px}.df-chart-area{height:245px;position:relative}.df-chart-area.df-chart-small{height:220px}.df-chart-area canvas{width:100%!important;height:100%!important}
.df-filters{display:flex;gap:9px;flex-wrap:wrap;margin:0 0 14px}.df-input{border:1px solid #d9e1ec;border-radius:9px;padding:10px 12px;background:#fff;color:#334155;min-height:39px}.df-input:focus{outline:2px solid #bfdbfe;border-color:#60a5fa}.df-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:#1d4ed8;color:#fff;border:0;border-radius:9px;padding:10px 14px;text-decoration:none;cursor:pointer;font-weight:700;font-size:12px}.df-btn:hover{color:#fff;background:#1e40af}.df-btn.df-secondary{background:#edf2f8;color:#475569}.df-btn.df-secondary:hover{background:#e2e8f0;color:#172b4d}
.df-table-wrap{overflow:auto;border:1px solid #edf1f6;border-radius:11px}table.df-table{width:100%;border-collapse:separate;border-spacing:0;min-width:1050px;background:#fff}table.df-table th{text-align:left;color:#64748b;font-size:10px;text-transform:uppercase;letter-spacing:.045em;background:#f7f9fc;font-weight:800;position:sticky;top:0;z-index:1} .df-table th,.df-table td{padding:12px 11px;border-bottom:1px solid #edf0f5;white-space:nowrap}.df-table tbody tr:hover{background:#f8fbff}.df-table tbody tr:last-child td{border-bottom:0}.df-num{font-variant-numeric:tabular-nums;font-weight:700;color:#263b59}.df-alert{color:#b45309}.df-good{color:#15803d}.df-bad{color:#b91c1c}.df-pill{padding:6px 10px;border-radius:20px;background:#eaf2ff;color:#315b89;font-size:11px;font-weight:700}.df-status{display:inline-flex;align-items:center;gap:5px;padding:5px 9px;border-radius:20px;font-size:10px;font-weight:750;background:#eef2f7;color:#475569}.df-status-good{background:#dcfce7;color:#166534}.df-status-warn{background:#fef3c7;color:#92400e}.df-status-bad{background:#fee2e2;color:#991b1b}.df-table details summary{cursor:pointer;color:#1d4ed8;font-weight:700;padding:4px 0}.df-table details[open] summary{margin-bottom:10px}.df-table details .df-table-wrap{box-shadow:0 3px 12px rgba(30,55,90,.04)}.df-note{font-size:10px;line-height:1.65;color:#8190a4;margin:13px 2px 0}.df-empty{padding:24px;text-align:center;color:#94a3b8}
@media(max-width:1000px){.df-kpis{grid-template-columns:repeat(2,minmax(0,1fr))}.df-chart-grid{grid-template-columns:1fr}}
@media(max-width:640px){.df-wrap{padding:12px}.df-hero{padding:18px;border-radius:14px;align-items:flex-start;flex-direction:column}.df-hero h1{font-size:20px}.df-nav{width:100%;display:grid;grid-template-columns:repeat(3,1fr)}.df-nav .df-btn{padding:9px 5px;font-size:10px}.df-kpis{gap:8px}.df-kpi{padding:13px;min-height:98px}.df-kpi strong{font-size:23px}.df-card,.df-chart-card{padding:13px;border-radius:12px}.df-chart-area{height:220px}.df-section-head{flex-direction:column}}
</style>
<div class="df-wrap">
    <div class="df-hero">
        <div>
            <h1>Planificación de Demanda y Stock</h1>
            <p>Panel de inteligencia operativa · Actualizado al {{ now()->format('d/m/Y') }}</p>
        </div>
        <div class="df-hero-meta">
            <span class="df-hero-chip">Historial: 180 días</span>
            <span class="df-hero-chip">Ponderación 60% / 40%</span>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <nav class="df-nav">
        <a class="df-btn {{ !request('section') ? 'df-active' : '' }}" href="{{ route('demand-forecast.index') }}">Demanda y stock</a>
        <a class="df-btn {{ request('section') === 'supermarkets' ? 'df-active' : '' }}" href="{{ route('demand-forecast.index', ['section' => 'supermarkets']) }}">Supermercados</a>
        <a class="df-btn {{ request('section') === 'clients' ? 'df-active' : '' }}" href="{{ route('demand-forecast.index', ['section' => 'clients']) }}">Clientes</a>
    </nav>

    @if(request('section') === 'clients')
        <div class="df-kpis">
            <div class="df-card df-kpi"><small>Clientes LOCAL / ENCOMIENDA</small><strong>{{ $clientData['summary']['clients'] }}</strong></div>
            <div class="df-card df-kpi"><small>Órdenes en últimos 180 días</small><strong>{{ $clientData['summary']['orders'] }}</strong></div>
            <div class="df-card df-kpi"><small>Órdenes todavía abiertas</small><strong>{{ $clientData['summary']['pending_orders'] }}</strong></div>
            <div class="df-card df-kpi"><small>Unidades pendientes</small><strong>{{ number_format($clientData['summary']['pending_units'], 0) }}</strong></div>
        </div>
        <div class="df-card">
            <h2 class="df-section-title">Predicción de pedidos por cliente</h2>
            <p class="df-muted">Incluye únicamente órdenes LOCAL y ENCOMIENDA. La siguiente orden se estima con el promedio de lo realmente despachado por producto; los faltantes no se acumulan. Los pedidos abiertos se muestran aparte.</p>
            <div class="df-kpis" style="margin:12px 0">
                <div class="df-card df-kpi"><small>Despachados últimos 7 días</small><strong>{{ $clientData['summary']['group_counts']['recently_dispatched'] }}</strong></div>
                <div class="df-card df-kpi"><small>Próximos a pedir</small><strong>{{ $clientData['summary']['group_counts']['due_soon'] }}</strong></div>
                <div class="df-card df-kpi"><small>Baja frecuencia</small><strong>{{ $clientData['summary']['group_counts']['low_frequency'] }}</strong></div>
                <div class="df-card df-kpi"><small>Sin pedidos por más de 90 días</small><strong>{{ $clientData['summary']['group_counts']['inactive_90'] }}</strong></div>
            </div>
            <div class="df-chart-grid">
                <section class="df-chart-card">
                    <h3>Distribución de clientes por actividad</h3>
                    <p>Clasificación comercial según el comportamiento registrado.</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfClientGroupsChart"></canvas></div>
                </section>
                <section class="df-chart-card">
                    <h3>Clientes con mayor volumen despachado</h3>
                    <p>Principales clientes del grupo seleccionado.</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfClientVolumeChart"></canvas></div>
                </section>
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
            <h2 class="df-section-title">Planificación por supermercado</h2>
            <p class="df-muted">Frecuencia y cantidades calculadas con despachos reales de los últimos 180 días. Los compromisos abiertos se muestran por separado.</p>
            <div class="df-chart-grid">
                <section class="df-chart-card">
                    <h3>Volumen despachado por supermercado</h3>
                    <p>Comparación de los principales clientes por unidades entregadas.</p>
                    <div class="df-chart-area"><canvas id="dfSupermarketVolumeChart"></canvas></div>
                </section>
                <section class="df-chart-card">
                    <h3>Próximas órdenes estimadas</h3>
                    <p>Distribución de clientes por cercanía de su siguiente pedido.</p>
                    <div class="df-chart-area"><canvas id="dfSupermarketTimingChart"></canvas></div>
                </section>
            </div>
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

    <div class="df-chart-grid">
        <section class="df-chart-card">
            <h3>Demanda proyectada por horizonte</h3>
            <p>Unidades estimadas a 7, 15 y 30 días para los productos del filtro actual.</p>
            <div class="df-chart-area"><canvas id="dfDemandHorizonChart"></canvas></div>
        </section>
        <section class="df-chart-card">
            <h3>Productos con mayor necesidad de producción</h3>
            <p>Comparación de stock disponible frente a demanda de 30 días.</p>
            <div class="df-chart-area"><canvas id="dfProductionNeedChart"></canvas></div>
        </section>
    </div>
    <div class="df-card">
        <div class="df-section-head">
            <div><h2 class="df-section-title">Detalle de productos</h2><p class="df-section-sub">Consulta y configura los parámetros de cobertura de cada producto.</p></div>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;
    Chart.defaults.font.family = "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    Chart.defaults.color = '#718096';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.boxWidth = 8;
    const palette = ['#2563eb','#0f9f91','#7c3aed','#d97706','#dc2626','#64748b'];
    const baseOptions = {responsive:true, maintainAspectRatio:false, plugins:{legend:{position:'bottom'}}, scales:{x:{grid:{display:false},ticks:{font:{size:10}}},y:{beginAtZero:true,grid:{color:'#edf1f6'},ticks:{font:{size:10}}}}};
    const makeChart = (id, config) => { const el=document.getElementById(id); if(el) new Chart(el,config); };

    @if(request('section') === 'clients')
        const clientGroupLabels = ['Despachados últimos 7 días','Próximos a pedir','Baja frecuencia','Sin pedidos +90 días','En seguimiento'];
        const clientGroupValues = [
            {{ (int) $clientData['summary']['group_counts']['recently_dispatched'] }},
            {{ (int) $clientData['summary']['group_counts']['due_soon'] }},
            {{ (int) $clientData['summary']['group_counts']['low_frequency'] }},
            {{ (int) $clientData['summary']['group_counts']['inactive_90'] }},
            {{ (int) ($clientData['summary']['group_counts']['follow_up'] ?? 0) }}
        ];
        makeChart('dfClientGroupsChart',{type:'doughnut',data:{labels:clientGroupLabels,datasets:[{data:clientGroupValues,backgroundColor:palette,borderWidth:0,hoverOffset:5}]},options:{responsive:true,maintainAspectRatio:false,cutout:'66%',plugins:{legend:{position:'bottom'}}}});
        const clientTop = @json($clientData['clients']->sortByDesc('total_dispatched')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'qty'=>(float)$c['total_dispatched']])->all());
        makeChart('dfClientVolumeChart',{type:'bar',data:{labels:clientTop.map(x=>x.name),datasets:[{label:'Unidades despachadas',data:clientTop.map(x=>x.qty),backgroundColor:'#2563eb',borderRadius:6,maxBarThickness:24}]},options:{...baseOptions,indexAxis:'y',plugins:{legend:{display:false}} ,scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'}},y:{grid:{display:false}}}}});
    @elseif(request('section') === 'supermarkets')
        const supermarketTop = @json($supermarketData['clients']->sortByDesc('total_dispatched')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'qty'=>(float)$c['total_dispatched']])->all());
        makeChart('dfSupermarketVolumeChart',{type:'bar',data:{labels:supermarketTop.map(x=>x.name),datasets:[{label:'Unidades despachadas',data:supermarketTop.map(x=>x.qty),backgroundColor:'#0f9f91',borderRadius:6,maxBarThickness:25}]},options:{...baseOptions,indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'}},y:{grid:{display:false}}}}});
        const supermarketTiming = @json($supermarketData['clients']->map(function($c){$days=$c['days_until_next'];return ['name'=>$c['client_name'],'bucket'=>($days===null?'Sin fecha':($days<0?'Atrasado':($days<=7?'Próximos 7 días':'Más adelante')))];})->groupBy('bucket')->map->count()->all());
        makeChart('dfSupermarketTimingChart',{type:'doughnut',data:{labels:Object.keys(supermarketTiming),datasets:[{data:Object.values(supermarketTiming),backgroundColor:palette,borderWidth:0}]},options:{responsive:true,maintainAspectRatio:false,cutout:'62%',plugins:{legend:{position:'bottom'}}}});
    @else
        const horizon = {
            d7: {{ (float) $products->sum(fn($p)=>(float)$p->forecast['demand_7d']) }},
            d15: {{ (float) $products->sum(fn($p)=>(float)$p->forecast['demand_15d']) }},
            d30: {{ (float) $products->sum(fn($p)=>(float)$p->forecast['demand_30d']) }}
        };
        makeChart('dfDemandHorizonChart',{type:'bar',data:{labels:['7 días','15 días','30 días'],datasets:[{label:'Demanda proyectada (unidades)',data:[horizon.d7,horizon.d15,horizon.d30],backgroundColor:['#93c5fd','#3b82f6','#1d4ed8'],borderRadius:8,maxBarThickness:58}]},options:{...baseOptions,plugins:{legend:{display:false}}}});
        const productionTop = @json($products->sortByDesc(fn($p)=>(float)$p->forecast['to_produce'])->take(8)->values()->map(fn($p)=>['name'=>$p->nombre,'available'=>(float)$p->forecast['available_stock'],'demand'=>(float)$p->forecast['demand_30d']])->all());
        makeChart('dfProductionNeedChart',{type:'bar',data:{labels:productionTop.map(x=>x.name),datasets:[{label:'Disponible',data:productionTop.map(x=>x.available),backgroundColor:'#0f9f91',borderRadius:5},{label:'Demanda 30 días',data:productionTop.map(x=>x.demand),backgroundColor:'#f59e0b',borderRadius:5}]},options:{...baseOptions,indexAxis:'y',scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'}},y:{grid:{display:false}}}}});
    @endif
});
</script>

@endsection
