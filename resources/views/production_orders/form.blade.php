<form method="POST"
action="{{ route('production-orders.store') }}">

@csrf

<div class="card shadow-sm border-0">

<div class="card-header bg-primary text-white">

<h4>

Información General

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>

Producto

</label>

<select
name="product_id"
class="form-select">

<option>

Seleccione...

</option>

@foreach($products as $product)

<option
value="{{ $product->id }}">

{{ $product->nombre }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6">

<label>

Materia Prima

</label>

<select
name="raw_material_id"
class="form-select">

<option>

Seleccione...

</option>

@foreach($materials as $material)

<option
value="{{ $material->id }}">

{{ $material->name }}

</option>

@endforeach

</select>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>

Cantidad a producir

</label>

<input
type="number"
step="0.01"
name="produced_quantity"
class="form-control">

</div>

<div class="col-md-6">

<label>

Cantidad consumida

</label>

<input
type="number"
step="0.01"
name="consumed_quantity"
class="form-control">

</div>

</div>

<br>

<label>

Observación

</label>

<textarea
name="observation"
class="form-control"
rows="4"></textarea>

</div>

</div>

<br>

<div class="text-end">

<a
href="{{ route('production-orders.index') }}"
class="btn btn-secondary">

Cancelar

</a>

<button
class="btn btn-success">

🟢 Iniciar Producción

</button>

</div>

</form>