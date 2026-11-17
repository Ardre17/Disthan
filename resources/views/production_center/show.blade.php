@extends('layouts.app')
@section('content')
@php
    $order = $production_order;
    $planned = (int)($order->planned_duration_seconds ?? 0);
    $actual = (int)($order->actual_duration_seconds ?? 0);
    $activePause = $activeShift?->pauses?->firstWhere('resumed_at', null);
    $elapsedNow = 0;
    if ($activeShift) {
        $elapsedNow = $activeShift->started_at->diffInSeconds(now());
        $elapsedNow -= $activeShift->pauses->sum(fn($p) => $p->resumed_at ? $p->paused_at->diffInSeconds($p->resumed_at) : $p->paused_at->diffInSeconds(now()));
        $elapsedNow = max(0, $elapsedNow);
    }
@endphp
<style>
.pc{padding:18px;background:#f3f6fb;min-height:calc(100vh - 70px);color:#172338}.pc-grid{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:13px;align-items:start}.pc-card{background:#fff;border:1px solid #dce4ef;border-radius:10px;padding:16px;margin-bottom:12px}.pc-row{display:flex;justify-content:space-between;gap:10px;padding:9px 0;border-bottom:1px solid #edf1f6;font-size:12px}.pc-row:last-child{border:0}.pc-muted{color:#64748b}.pc-btn{display:inline-flex;align-items:center;justify-content:center;padding:9px 12px;border-radius:7px;border:1px solid #d5deeb;background:#fff;color:#26364d;text-decoration:none;font-size:11px;font-weight:700;cursor:pointer}.pc-primary{background:#075ee8;color:#fff;border-color:#075ee8}.pc-green{background:#16834b;color:#fff;border-color:#16834b}.pc-orange{background:#fff7e6;color:#a16207;border-color:#f5d69b}.pc-red{background:#fff1f2;color:#be123c;border-color:#fecdd3}.pc-clock{text-align:center;background:#101e33;color:#fff;border-radius:10px;padding:20px}.pc-clock strong{font:800 36px Consolas,monospace;display:block;margin:8px 0}.pc-clock small{color:#b9c6d8}.pc-workers{display:flex;flex-wrap:wrap;gap:6px}.pc-worker{background:#eef4ff;color:#1d4ed8;padding:6px 9px;border-radius:20px;font-size:10px;font-weight:700}.pc-table{width:100%;border-collapse:collapse}.pc-table th,.pc-table td{text-align:left;padding:9px;border-bottom:1px solid #edf1f6;font-size:11px}.pc-table th{color:#64748b;background:#f7f9fc}.pc-field{border:1px solid #d5deeb;border-radius:7px;padding:9px;width:100%;margin:5px 0 10px}.pc-actions{display:flex;gap:7px;flex-wrap:wrap}.pc-form label{font-size:11px;font-weight:700;color:#52627a}
@media(max-width:850px){.pc-grid{grid-template-columns:1fr}.pc{padding:9px}.pc-clock strong{font-size:30px}}
</style>
<div class="pc">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:13px">
        <div><div style="font-size:11px;color:#64748b">CENTRO DE PRODUCCIÓN / ORDEN</div><h2 style="font-size:20px;margin:3px 0">{{ $order->number }} · {{ $order->product->nombre ?? 'Producto' }}</h2></div>
        <span class="pc-worker">{{ $order->status }}</span>
    </div>
    @if(session('success'))<div style="background:#e8f7ee;color:#166534;padding:10px;border-radius:7px;margin-bottom:12px">{{ session('success') }}</div>@endif
    @if($errors->any())<div style="background:#fff1f2;color:#be123c;padding:10px;border-radius:7px;margin-bottom:12px">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif

    <div class="pc-grid">
        <main>
            <section class="pc-card">
                <h3 style="font-size:14px;margin:0 0 8px">Resumen de la orden</h3>
                <div class="pc-row"><span class="pc-muted">Cantidad objetivo</span><strong>{{ number_format((float)$order->target_quantity,2) }}</strong></div>
                <div class="pc-row"><span class="pc-muted">Cantidad real acumulada</span><strong style="color:#16834b">{{ number_format((float)$completedQuantity,2) }}</strong></div>
                <div class="pc-row"><span class="pc-muted">Pendiente frente al objetivo</span><strong>{{ number_format(max(0,(float)$order->target_quantity-$completedQuantity),2) }}</strong></div>
                <div class="pc-row"><span class="pc-muted">Estándar por unidad</span><strong>{{ number_format((float)$order->standard_time_seconds,3) }} segundos</strong></div>
                <div class="pc-row"><span class="pc-muted">Tiempo proyectado</span><strong>{{ gmdate('H:i:s',$planned) }}</strong></div>
                <div class="pc-row"><span class="pc-muted">Tiempo efectivo acumulado</span><strong>{{ gmdate('H:i:s',$actual) }}</strong></div>
                <div class="pc-row"><span class="pc-muted">Materia prima prevista para descontar al cierre</span><strong>{{ number_format((float)$order->consumed_quantity,2) }} · {{ $order->rawMaterial->unit ?? '' }}</strong></div>
            </section>

            <section class="pc-card">
                <h3 style="font-size:14px;margin:0 0 12px">Jornadas registradas</h3>
                <div style="overflow:auto">
                <table class="pc-table">
                    <thead><tr><th>Jornada</th><th>Fecha</th><th>Personal</th><th>Unidades</th><th>Tiempo efectivo</th><th>Estado</th></tr></thead>
                    <tbody>
                    @forelse($order->shifts as $shift)
                        <tr>
                            <td>#{{ $shift->shift_number }}</td>
                            <td>{{ $shift->started_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $shift->workers->pluck('name')->join(', ') }}</td>
                            <td>{{ number_format((float)$shift->produced_quantity,2) }}</td>
                            <td>{{ gmdate('H:i:s',(int)$shift->actual_duration_seconds) }}</td>
                            <td>{{ $shift->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="pc-muted">Sin jornadas registradas.</td></tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </section>

            @if($order->status !== 'FINALIZADA' && !$activeShift)
            <section class="pc-card">
                <h3 style="font-size:14px;margin:0 0 5px">Iniciar siguiente jornada</h3>
                <p class="pc-muted" style="font-size:11px">Registra al personal que participará en esta nueva jornada.</p>
                <form method="POST" action="{{ route('production-center.shifts.start',$order) }}" class="pc-form">
                    @csrf
                    <div id="newWorkers"><input class="pc-field" name="workers[]" required placeholder="Nombre del operario"></div>
                    <button type="button" class="pc-btn" onclick="addNewWorker()">＋ Añadir persona</button>
                    <button class="pc-btn pc-primary" type="submit">▶ Iniciar jornada</button>
                </form>
            </section>
            @endif
        </main>

        <aside>
            @if($activeShift)
                <section class="pc-card">
                    <h3 style="font-size:14px;margin:0 0 12px">Jornada #{{ $activeShift->shift_number }}</h3>
                    <div class="pc-clock">
                        <small>{{ $activePause ? 'JORNADA PAUSADA' : 'TIEMPO EFECTIVO DE ESTA JORNADA' }}</small>
                        <strong id="pcClock" data-elapsed="{{ $elapsedNow }}">{{ gmdate('H:i:s',$elapsedNow) }}</strong>
                        <small>Inicio: {{ $activeShift->started_at->format('d/m/Y H:i:s') }}</small>
                    </div>
                    <div style="margin:13px 0 7px;font-size:11px;font-weight:700">Personal participante</div>
                    <div class="pc-workers">@foreach($activeShift->workers as $worker)<span class="pc-worker">{{ $worker->name }}</span>@endforeach</div>
                    <div class="pc-actions" style="margin-top:14px">
                        @if($activePause)
                            <form method="POST" action="{{ route('production-center.shifts.resume',$activeShift) }}">@csrf<button class="pc-btn pc-green">▶ Reanudar</button></form>
                        @else
                            <form method="POST" action="{{ route('production-center.shifts.pause',$activeShift) }}">@csrf<button class="pc-btn pc-orange">Ⅱ Pausar</button></form>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('production-center.shifts.close',$activeShift) }}" style="margin-top:16px">
                        @csrf
                        <label>Cantidad fabricada durante esta jornada</label>
                        <input class="pc-field" type="number" min="0" step="0.01" name="produced_quantity" required placeholder="Unidades fabricadas hoy">
                        <label>Observación de la jornada (opcional)</label>
                        <input class="pc-field" name="notes" placeholder="Incidencias, cambios de turno...">
                        <button class="pc-btn pc-primary" style="width:100%" type="submit" onclick="return confirm('¿Cerrar esta jornada? La orden seguirá abierta.')">■ Cerrar jornada</button>
                    </form>
                </section>
            @elseif($order->status === 'FINALIZADA')
                <section class="pc-card"><h3 style="margin:0 0 8px">Orden finalizada</h3><strong style="font-size:27px;color:#16834b">{{ number_format((float)$order->produced_quantity,2) }}</strong><div class="pc-muted" style="font-size:11px">Unidades reales ingresadas al inventario.</div></section>
            @else
                <section class="pc-card">
                    <h3 style="font-size:14px;margin:0 0 8px">Finalizar orden</h3>
                    <p class="pc-muted" style="font-size:11px">La cantidad real será la suma de las cantidades registradas al cerrar cada jornada.</p>
                    <div style="font-size:24px;font-weight:800;color:#16834b">{{ number_format((float)$completedQuantity,2) }} unidades</div>
                    <form method="POST" action="{{ route('production-center.finish',$order) }}" style="margin-top:12px">
                        @csrf
                        <button class="pc-btn pc-green" style="width:100%" type="submit" onclick="return confirm('¿Finalizar la orden e ingresar al inventario la cantidad real acumulada?')">✓ Finalizar orden e ingresar inventario</button>
                    </form>
                </section>
            @endif
            <a class="pc-btn" style="width:100%" href="{{ route('production-center.index') }}">← Volver al centro de producción</a>
        </aside>
    </div>
</div>
<script>
const clock=document.getElementById('pcClock');
if(clock && !@json((bool)$activePause)){
 let elapsed=Number(clock.dataset.elapsed||0),last=Date.now();
 setInterval(()=>{const now=Date.now();elapsed+=(now-last)/1000;last=now;let n=Math.floor(elapsed),h=Math.floor(n/3600),m=Math.floor((n%3600)/60),s=n%60;clock.textContent=[h,m,s].map(v=>String(v).padStart(2,'0')).join(':');},1000);
}
function addNewWorker(){const input=document.createElement('input');input.className='pc-field';input.name='workers[]';input.required=true;input.placeholder='Nombre del operario';document.getElementById('newWorkers').appendChild(input);}
</script>
@endsection
