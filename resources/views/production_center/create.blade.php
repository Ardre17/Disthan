@extends('layouts.app')
@section('content')
<style>
.pc{padding:18px;background:#f3f6fb;min-height:calc(100vh - 70px);color:#172338}.pc-card{background:#fff;border:1px solid #dce4ef;border-radius:10px;padding:18px;max-width:950px;margin:auto}
.pc-grid{display:grid;grid-template-columns:1fr 1fr;gap:13px}.pc-field{display:flex;flex-direction:column;gap:5px}.pc-field label{font-size:11px;font-weight:700;color:#52627a}.pc-field input,.pc-field select,.pc-field textarea{border:1px solid #d5deeb;border-radius:7px;padding:10px;font-size:13px;width:100%;background:#fbfcfe}.pc-help{font-size:10px;color:#8492a6}.pc-worker{display:flex;gap:8px;margin-bottom:7px}.pc-worker input{flex:1;border:1px solid #d5deeb;border-radius:7px;padding:9px}.pc-btn{border:1px solid #d5deeb;background:#fff;border-radius:7px;padding:9px 13px;font-weight:700;cursor:pointer}.pc-primary{background:#075ee8;color:#fff;border-color:#075ee8}.pc-section{margin-top:18px;padding-top:15px;border-top:1px solid #e8edf4}.pc-estimate{background:#eff6ff;padding:13px;border-radius:8px;margin-top:12px}.pc-estimate strong{font-size:22px;color:#075ee8}
@media(max-width:650px){.pc{padding:8px}.pc-grid{grid-template-columns:1fr}}
</style>
<div class="pc">
<form method="POST" action="{{ route('production-center.store') }}" class="pc-card">
    @csrf
    <h2 style="font-size:19px;margin:0 0 5px">Nueva orden de producción</h2>
    <p style="font-size:12px;color:#64748b;margin:0 0 18px">Se creará la orden y comenzará la primera jornada al guardar.</p>
    @if($errors->any())<div style="background:#fff1f2;color:#be123c;padding:10px;border-radius:7px;margin-bottom:12px">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <div class="pc-grid">
        <div class="pc-field"><label>Producto terminado</label><select name="product_id" id="pcProduct" required><option value="">Seleccionar producto</option>@foreach($products as $p)<option value="{{ $p->id }}" data-standard="{{ $standards[$p->id]->seconds_per_unit ?? '' }}">{{ $p->nombre }} · {{ $p->sku }}</option>@endforeach</select></div>
        <div class="pc-field"><label>Materia prima</label><select name="raw_material_id" required><option value="">Seleccionar materia prima</option>@foreach($materials as $m)<option value="{{ $m->id }}">{{ $m->name }} · Stock {{ number_format((float)$m->stock,2) }} {{ $m->unit }}</option>@endforeach</select></div>
        <div class="pc-field"><label>Cantidad objetivo</label><input type="number" min="0.01" step="0.01" name="target_quantity" id="pcTarget" required placeholder="Ej. 500"></div>
        <div class="pc-field"><label>Consumo previsto de materia prima</label><input type="number" min="0.01" step="0.01" name="consumed_quantity" required placeholder="Cantidad de MP que se descontará al cierre"></div>
        <div class="pc-field"><label>Tiempo estándar por unidad (segundos)</label><input type="number" min="0.001" step="0.001" name="standard_time_seconds" id="pcStandard" required placeholder="Configura o ingresa segundos"><span class="pc-help">Se guarda como fotografía para esta orden. Cambios futuros no alteran órdenes existentes.</span></div>
        <div class="pc-field"><label>Observaciones</label><textarea name="observation" rows="2" placeholder="Indicaciones de fabricación..."></textarea></div>
    </div>
    <div class="pc-estimate">Tiempo proyectado de fabricación: <strong id="pcEstimate">—</strong><div class="pc-help">Estimación matemática: cantidad objetivo × segundos estándar. No incluye pausas.</div></div>
    <div class="pc-section">
        <h3 style="font-size:14px;margin:0 0 5px">Línea de producción · Jornada 1</h3>
        <p class="pc-help" style="margin:0 0 10px">Escribe los nombres de las personas que trabajarán en esta jornada.</p>
        <div id="pcWorkers"><div class="pc-worker"><input name="workers[]" required maxlength="150" placeholder="Nombre del operario"><button type="button" class="pc-btn" onclick="this.parentElement.remove()">Quitar</button></div></div>
        <button type="button" class="pc-btn" onclick="addWorker()">＋ Añadir persona</button>
    </div>
    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;flex-wrap:wrap">
        <a class="pc-btn" href="{{ route('production-center.index') }}">Cancelar</a>
        <button class="pc-btn pc-primary" type="submit">▶ Crear orden e iniciar jornada</button>
    </div>
</form>
</div>
<script>
function addWorker(){const d=document.createElement('div');d.className='pc-worker';d.innerHTML='<input name="workers[]" required maxlength="150" placeholder="Nombre del operario"><button type="button" class="pc-btn" onclick="this.parentElement.remove()">Quitar</button>';document.getElementById('pcWorkers').appendChild(d);}
const product=document.getElementById('pcProduct'), standard=document.getElementById('pcStandard'), target=document.getElementById('pcTarget');
product.addEventListener('change',()=>{const v=product.selectedOptions[0]?.dataset.standard;if(v)standard.value=v;updateEstimate();});
function fmt(s){if(!Number.isFinite(s)||s<0)return '—';let h=Math.floor(s/3600),m=Math.floor((s%3600)/60),sec=Math.round(s%60);return `${h} h ${m} min ${sec} s`;}
function updateEstimate(){let t=Number(target.value),s=Number(standard.value);document.getElementById('pcEstimate').textContent=t>0&&s>0?fmt(t*s):'—';}
target.addEventListener('input',updateEstimate);standard.addEventListener('input',updateEstimate);
</script>
@endsection
