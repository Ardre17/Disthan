@extends('layouts.app')


@section('content')


<style>
*{box-sizing:border-box;}
.pg{padding:1.25rem;background:#f1f5f9;min-height:100vh;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1.1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.85rem 1rem;display:flex;align-items:center;gap:12px;}
.kpi-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;}
.kpi-label{font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;}
.kpi-val{font-size:20px;font-weight:700;color:#1e293b;line-height:1.1;}
.filter-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem;}
.filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:10px;align-items:end;}
@media(max-width:700px){.filter-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:4px;}
.finput{padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.hdr-title{font-size:17px;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:8px;}
.btn-new{background:#16a34a;color:#fff;border:none;padding:9px 16px;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;text-decoration:none;transition:background .15s;}
.btn-new:hover{background:#15803d;}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;}
.order-card{background:#fff;border:1px solid #e2e8f0;border-radius:13px;padding:1.1rem;display:flex;flex-direction:column;gap:.75rem;border-top:4px solid;}
.card-top{display:flex;justify-content:space-between;align-items:flex-start;}
.order-num{font-size:14px;font-weight:700;color:#1e293b;}
.order-client{font-size:12px;color:#94a3b8;margin-top:1px;}
.badge{display:inline-flex;align-items:center;gap:3px;font-size:11px;padding:3px 9px;border-radius:99px;font-weight:600;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}
.meta-row{display:grid;grid-template-columns:1fr 1fr;gap:5px 10px;}
.meta-item{display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;}
.meta-val{font-weight:600;color:#374151;}
hr.div{border:none;border-top:1px solid #f1f5f9;}
.prog-hdr{display:flex;justify-content:space-between;font-size:12px;color:#64748b;margin-bottom:4px;}
.prog-bar{width:100%;height:7px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}
.prog-sub{font-size:11px;color:#94a3b8;margin-top:3px;}
.faltantes{background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:8px 10px;}
.falt-title{font-size:11px;font-weight:700;color:#b91c1c;margin-bottom:4px;display:flex;align-items:center;gap:4px;}
.falt-item{font-size:12px;color:#dc2626;display:flex;justify-content:space-between;padding:2px 0;border-bottom:1px solid #fecaca;}
.falt-item:last-child{border-bottom:none;}
.falt-qty{font-weight:700;}
.btn-row{display:grid;grid-template-columns:1fr 1fr;gap:7px;}
.btn{display:flex;align-items:center;justify-content:center;gap:4px;padding:8px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-blue{background:#eff6ff;color:#1d4ed8;}
.btn-green{background:#f0fdf4;color:#15803d;}
.btn-gray{background:#f8fafc;color:#475569;}
.btn-red{background:#fef2f2;color:#b91c1c;}
.btn-full{grid-column:1/-1;}
</style>


<div class="pg">


{{-- ── KPIs ── --}}
@php
   $total      = $orders->total();
   $completos  = $orders->getCollection()->where('estado','COMPLETO')->count();
   $parciales  = $orders->getCollection()->where('estado','PARCIAL')->count();
   $incompletos= $orders->getCollection()->where('estado','INCOMPLETO')->count();
   $montoTotal = $orders->getCollection()->sum('total');
@endphp
<div class="kpis">
   <div class="kpi">
       <div class="kpi-icon" style="background:#eff6ff;color:#2563eb;">📋</div>
       <div><div class="kpi-label">Total órdenes</div><div class="kpi-val">{{ $total }}</div></div>
   </div>
   <div class="kpi">
       <div class="kpi-icon" style="background:#dcfce7;color:#15803d;">✅</div>
       <div><div class="kpi-label">Completadas</div><div class="kpi-val" style="color:#15803d;">{{ $completos }}</div></div>
   </div>
   <div class="kpi">
       <div class="kpi-icon" style="background:#fef3c7;color:#b45309;">⏳</div>
       <div><div class="kpi-label">En progreso</div><div class="kpi-val" style="color:#b45309;">{{ $parciales }}</div></div>
   </div>
   <div class="kpi">
       <div class="kpi-icon" style="background:#fee2e2;color:#b91c1c;">⚠️</div>
       <div><div class="kpi-label">Incompletas</div><div class="kpi-val" style="color:#b91c1c;">{{ $incompletos }}</div></div>
   </div>
</div>


{{-- ── Filtros ── --}}
<div class="filter-card">
   <form method="GET">
       <div class="filter-grid">
           <div>
               <label class="flabel">Desde</label>
               <input type="date" name="fecha_inicio" class="finput" value="{{ request('fecha_inicio') }}">
           </div>
           <div>
               <label class="flabel">Hasta</label>
               <input type="date" name="fecha_fin" class="finput" value="{{ request('fecha_fin') }}">
           </div>
           <div>
               <label class="flabel">Estado</label>
               <select name="estado" class="finput">
                   <option value="">Todos</option>
                   @foreach(['COMPLETO','PARCIAL','INCOMPLETO'] as $e)
                       <option value="{{ $e }}" @selected(request('estado')===$e)>{{ $e }}</option>
                   @endforeach
               </select>
           </div>
           <button type="submit" style="padding:9px 18px;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;">
               🔍 Buscar
           </button>
       </div>
   </form>
</div>


{{-- ── Header ── --}}
<div class="hdr">
   <div class="hdr-title">📋 Órdenes</div>
   <a href="{{ route('orders.create') }}" class="btn-new">+ Nueva orden</a>
</div>


{{-- ── Cards ── --}}
<div class="cards">


@foreach($orders as $order)


@php
   $totalItems  = $order->details->count();
   $completados = $order->details->where('estado_item','COMPLETO')->count();
   $porcentaje  = $totalItems > 0 ? round(($completados / $totalItems) * 100) : 0;
   $faltantes   = $order->details->filter(fn($d) => $d->estado_item !== 'COMPLETO');


   $topColor    = $order->estado === 'COMPLETO' ? '#16a34a'
                : ($order->estado === 'PARCIAL'  ? '#f59e0b' : '#ef4444');
   $progColor   = $porcentaje === 100 ? '#22c55e'
                : ($porcentaje > 40   ? '#f59e0b' : '#ef4444');
   $montoColor  = $order->estado === 'COMPLETO' ? '#15803d'
                : ($order->estado === 'PARCIAL'  ? '#b45309' : '#b91c1c');
   $badgeClass  = $order->estado === 'COMPLETO' ? 'bc'
                : ($order->estado === 'PARCIAL'  ? 'bp' : 'bi');
   $badgeIcon   = $order->estado === 'COMPLETO' ? '✅'
                : ($order->estado === 'PARCIAL'  ? '⏳' : '⚠️');
@endphp


<div class="order-card" style="border-top-color:{{ $topColor }};">


   {{-- Cabecera --}}
   <div class="card-top">
       <div>
           <div class="order-num">{{ $order->numero_orden }}</div>
           <div class="order-client">{{ $order->client->razon_social ?? 'Sin cliente' }}</div>
       </div>
       <span class="badge {{ $badgeClass }}">{{ $badgeIcon }} {{ $order->estado }}</span>
   </div>


   <hr class="div">


   {{-- Meta --}}
   <div class="meta-row">
       <div class="meta-item">📦 <span>Tipo: <span class="meta-val">{{ $order->tipo_orden }}</span></span></div>
       <div class="meta-item">📅 <span class="meta-val">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}</span></div>
       <div class="meta-item">💰 <span>S/ <span class="meta-val" style="color:{{ $montoColor }};">{{ number_format($order->total,2) }}</span></span></div>
       <div class="meta-item">🗂 <span>Items: <span class="meta-val">{{ $totalItems }}</span></span></div>
   </div>


   <hr class="div">


   {{-- Progreso --}}
   <div>
       <div class="prog-hdr">
           <span>Progreso</span>
           <span style="font-weight:700;color:{{ $progColor }};">{{ $porcentaje }}%</span>
       </div>
       <div class="prog-bar">
           <div class="prog-fill" style="width:{{ $porcentaje }}%;background:{{ $progColor }};"></div>
       </div>
       <div class="prog-sub">{{ $completados }} / {{ $totalItems }} productos completados</div>
   </div>


   {{-- Faltantes --}}
   @if($faltantes->count())
   <div class="faltantes">
       <div class="falt-title">⚠️ Faltantes ({{ $faltantes->count() }})</div>
       @foreach($faltantes->take(4) as $f)
       <div class="falt-item">
           <span>{{ $f->product->nombre }}</span>
           <span class="falt-qty">−{{ $f->cantidad_solicitada - $f->cantidad_despachada }}</span>
       </div>
       @endforeach
       @if($faltantes->count() > 4)
       <div style="font-size:11px;color:#b91c1c;margin-top:3px;">+ {{ $faltantes->count() - 4 }} más...</div>
       @endif
   </div>
   @endif


   <hr class="div">


   {{-- Botones --}}
   <div class="btn-row">
       <a href="{{ route('orders.edit',$order) }}" class="btn btn-blue">✏️ Editar</a>
       <a href="{{ route('orders.operario',$order) }}" class="btn btn-green">🚀 Operario</a>
       <a href="{{ route('orders.pdf',$order) }}" class="btn btn-gray btn-full">📄 Ver PDF</a>
   </div>


   {{-- Eliminar --}}
   <form method="POST" action="{{ route('orders.destroy',$order) }}"
       onsubmit="return confirm('¿Eliminar la orden {{ $order->numero_orden }}? Esta acción no se puede deshacer.')">
       @csrf
       @method('DELETE')
       <button type="submit" class="btn btn-red btn-full" style="width:100%;">🗑 Eliminar orden</button>
   </form>


</div>


@endforeach


</div>


{{-- Paginación --}}
<div style="margin-top:1.25rem;">
   {{ $orders->links() }}
</div>


</div>


@endsection

