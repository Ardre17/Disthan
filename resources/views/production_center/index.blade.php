@extends('layouts.app')
@section('content')
<style>
.pc{padding:18px;background:#f3f6fb;min-height:calc(100vh - 70px);color:#172338}
.pc-top{display:flex;justify-content:flex-end;gap:8px;margin-bottom:14px;flex-wrap:wrap}
.pc-btn{display:inline-flex;align-items:center;justify-content:center;padding:9px 13px;border-radius:7px;border:1px solid #d5deeb;background:#fff;color:#26364d;text-decoration:none;font-size:12px;font-weight:700;cursor:pointer}
.pc-primary{background:#075ee8;border-color:#075ee8;color:white}
.pc-kpis{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:14px}
.pc-kpi,.pc-panel{background:#fff;border:1px solid #dce4ef;border-radius:9px;padding:14px;box-shadow:0 2px 7px #0f23410a}
.pc-kpi small{display:block;color:#64748b;font-size:11px}.pc-kpi strong{display:block;font-size:23px;margin-top:4px}
.pc-panel{padding:0;overflow:hidden}.pc-panel h3{font-size:14px;margin:0;padding:13px 15px;border-bottom:1px solid #e5ebf3}
.pc-table{width:100%;border-collapse:collapse;min-width:760px}.pc-table th,.pc-table td{text-align:left;padding:11px 12px;border-bottom:1px solid #edf1f6;font-size:11px}.pc-table th{background:#f7f9fc;color:#52627a;text-transform:uppercase;font-size:10px}
.pc-badge{padding:5px 8px;border-radius:20px;background:#e7f1ff;color:#0758cf;font-size:10px;font-weight:700}
.pc-muted{color:#64748b}
@media(max-width:700px){.pc{padding:9px}.pc-kpis{grid-template-columns:1fr 1fr}.pc-top>*{flex:1}.pc-table-wrap{overflow:auto}}
</style>
<div class="pc">
    <div class="pc-top">
        <a class="pc-btn" href="{{ route('production-center.standards') }}">⏱ Tiempos estándar</a>
        <a class="pc-btn pc-primary" href="{{ route('production-center.create') }}">＋ Nueva orden</a>
    </div>
    @php
        $open = $orders->where('status','EN_PRODUCCION');
        $finished = $orders->where('status','FINALIZADA');
        $units = $finished->sum('produced_quantity');
    @endphp
    <div class="pc-kpis">
        <div class="pc-kpi"><small>Órdenes abiertas</small><strong>{{ $open->count() }}</strong></div>
        <div class="pc-kpi"><small>Órdenes finalizadas</small><strong>{{ $finished->count() }}</strong></div>
        <div class="pc-kpi"><small>Unidades fabricadas</small><strong>{{ number_format($units,0) }}</strong></div>
    </div>
    <section class="pc-panel">
        <h3>Órdenes de producción</h3>
        <div class="pc-table-wrap">
            <table class="pc-table">
                <thead><tr><th>Orden</th><th>Producto</th><th>Objetivo</th><th>Real fabricado</th><th>Jornadas</th><th>Tiempo efectivo</th><th>Estado</th><th></th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->number }}</strong></td>
                        <td>{{ $order->product->nombre ?? '—' }}</td>
                        <td>{{ number_format((float)($order->target_quantity ?? $order->produced_quantity),2) }}</td>
                        <td>{{ number_format((float)$order->produced_quantity,2) }}</td>
                        <td>{{ $order->shifts->count() }}</td>
                        <td>{{ gmdate('H:i:s', (int)$order->actual_duration_seconds) }}</td>
                        <td><span class="pc-badge">{{ $order->status }}</span></td>
                        <td><a class="pc-btn" href="{{ route('production-center.show',$order) }}">Abrir</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="pc-muted">Todavía no hay órdenes registradas en el nuevo centro.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
