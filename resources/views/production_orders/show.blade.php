@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

<h3>

🏭 {{ $production_order->number }}

</h3>

</div>

<div class="card-body">

<p>

<strong>Producto:</strong>

{{ $production_order->product->name }}

</p>

<p>

<strong>Materia Prima:</strong>

{{ $production_order->rawMaterial->name }}

</p>

<p>

<strong>Producción:</strong>

{{ $production_order->produced_quantity }}

</p>

<p>

<strong>Consumo:</strong>

{{ $production_order->consumed_quantity }}

</p>

<p>

<strong>Estado:</strong>

<span class="badge bg-{{ $production_order->status_color }}">

{{ $production_order->status }}

</span>

</p>

<hr>

@if($production_order->status!='FINALIZADA')

<form
method="POST"
action="{{ route('production-orders.finish',$production_order) }}">

@csrf

<button
class="btn btn-success btn-lg">

🏁 FINALIZAR PRODUCCIÓN

</button>

</form>

@else

<div class="alert alert-success">

Producción finalizada.

</div>

@endif

</div>

</div>

</div>

@endsection