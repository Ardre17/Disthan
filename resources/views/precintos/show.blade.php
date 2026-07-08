@extends('layouts.app')
@section('content')
<style>
:root{--erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;--erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;--erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;--erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;--erp-warn:#b9690e;--font-ui:'Segoe UI',sans-serif;}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.grid-main{display:grid;grid-template-columns:1fr 240px;gap:14px;}
@media(max-width:800px){.grid-main{grid-template-columns:1fr;}}
.sec-card,.side-card{background:#fff;border:1px solid #dde2ea;border-radius:4px;margin-bottom:10px;}
.sec-hdr,.side-hdr{padding:.65rem 1rem;border-bottom:1px solid #dde2ea;background:#f4f6f9;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;}
.sec-body,.side-body{padding:1rem;}
.field-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{font-size:10px;font-weight:700;color:#5b6b7d;text-transform:uppercase;}
.finput,.fselect{padding:7px 9px;border:1px solid #dde2ea;border-radius:3px;font-size:12px;width:100%;}
.btn-row{display:flex;gap:8px;padding-top:.85rem;}
.btn-save{padding:8px 20px;background:#0b5ed7;color:#fff;border:none;border-radius:3px;}
.btn-cancel{padding:8px 16px;background:#fff;color:#5b6b7d;border:1px solid #dde2ea;border-radius:3px;text-decoration:none;}
.color-selector{display:flex;gap:8px;margin-top:4px}
.color-option{flex:1;padding:10px 6px;border:2px solid #dde2ea;border-radius:3px;text-align:center;cursor:pointer}
.selected-verde{border-color:#22c55e;background:#f0fdf4}
.selected-blanco{border-color:#94a3b8;background:#f8fafc}
.selected-negro{border-color:#1e293b;background:#1e293b;color:#fff}
</style>

<div class="page">
<div class="erp-bar">
<div class="erp-bar-left">
<div class="erp-sep"></div>
<div class="erp-module">Editar precinto</div>
</div>
<span style="font-size:11px;color:#5a8abf;">Inventario › Precintos › Editar</span>
</div>

<div class="body">

@if($errors->any())
<div style="background:#fbe9e8;border:1px solid #f3c7c4;border-radius:4px;padding:10px;margin-bottom:12px;">
<strong>Errores:</strong>
<ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('precintos.update',$precinto) }}">
@csrf
@method('PUT')

<div class="grid-main">
<div>

<div class="sec-card">
<div class="sec-hdr">Identificación</div>
<div class="sec-body">

<div class="field-grid">

<div class="field">
<label class="flabel">Nombre</label>
<input class="finput" type="text" name="nombre" value="{{ old('nombre',$precinto->nombre) }}" required>
</div>

<div class="field">
<label class="flabel">Color</label>
<select class="fselect" name="color" id="colorSelect" onchange="updateColorPreview()" required>
@foreach($colores as $c)
<option value="{{ $c }}" {{ old('color',$precinto->color)===$c?'selected':'' }}>
{{ match($c){'VERDE'=>'🟢 Verde','BLANCO'=>'⚪ Blanco','NEGRO'=>'⚫ Negro',default=>$c} }}
</option>
@endforeach
</select>

<div class="color-selector">
<div id="prev-verde" class="color-option" onclick="selectColor('VERDE')">🟢<br>Verde</div>
<div id="prev-blanco" class="color-option" onclick="selectColor('BLANCO')">⚪<br>Blanco</div>
<div id="prev-negro" class="color-option" onclick="selectColor('NEGRO')">⚫<br>Negro</div>
</div>

</div>

<div class="field">
<label class="flabel">Stock actual</label>
<input class="finput" type="text" readonly value="{{ number_format($precinto->stock_actual,0) }}">
</div>

<div class="field">
<label class="flabel">Stock mínimo</label>
<input class="finput" type="number" name="stock_minimo" min="0" step="0.01" value="{{ old('stock_minimo',$precinto->stock_minimo) }}" required>
</div>

</div>
</div>
</div>

<div class="btn-row">
<button class="btn-save" type="submit">💾 Guardar cambios</button>
<a class="btn-cancel" href="{{ route('precintos.index') }}">Cancelar</a>
<a class="btn-cancel" href="{{ route('precintos.show',$precinto) }}">Ver Kardex</a>
</div>

</div>

<div>
<div class="side-card">
<div class="side-hdr">Información</div>
<div class="side-body">
<p><strong>Color:</strong> {{ $precinto->color }}</p>
<p><strong>Stock:</strong> {{ number_format($precinto->stock_actual,0) }}</p>
</div>
</div>
</div>

</div>

</form>
</div>
</div>

<script>
function selectColor(c){
document.getElementById('colorSelect').value=c;
updateColorPreview();
}
function updateColorPreview(){
let c=document.getElementById('colorSelect').value;
document.getElementById('prev-verde').className='color-option'+(c==='VERDE'?' selected-verde':'');
document.getElementById('prev-blanco').className='color-option'+(c==='BLANCO'?' selected-blanco':'');
document.getElementById('prev-negro').className='color-option'+(c==='NEGRO'?' selected-negro':'');
}
document.addEventListener('DOMContentLoaded',updateColorPreview);
</script>

@endsection
