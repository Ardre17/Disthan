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
.df-table th,.df-table td{padding:11px 10px;border-bottom:1px solid #edf0f5;white-space:nowrap}.df-num{font-variant-numeric:tabular-nums;font-weight:650}.df-alert{color:#b45309}.df-good{color:#15803d}.df-bad{color:#b91c1c}.df-pill{padding:4px 8px;border-radius:20px;background:#eef4fb;color:#315b89;font-size:11px}
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
</div>
@endsection
