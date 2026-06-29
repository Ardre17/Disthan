@extends('layouts.app')

@section('content')
<style>

.warehouse-layout{

display:grid;

grid-template-columns:1fr 320px;

gap:25px;

}

.warehouse-map{

background:white;

border-radius:18px;

padding:20px;

box-shadow:0 4px 18px rgba(0,0,0,.08);

}

.rack{

fill:white;

stroke:#2563eb;

stroke-width:4;

rx:12;

cursor:pointer;

transition:.25s;

}

.rack:hover{

fill:#dbeafe;

stroke:#1d4ed8;

}

.panel-card{

background:white;

padding:18px;

border-radius:18px;

box-shadow:0 4px 15px rgba(0,0,0,.08);

margin-bottom:20px;

}

.warehouse-stats{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-top:25px;

}

.stat-card{

background:white;

padding:20px;

border-radius:18px;

text-align:center;

box-shadow:0 3px 12px rgba(0,0,0,.08);

}

.page-title{

font-size:32px;

font-weight:bold;

margin-bottom:25px;

}

</style>

@include('warehouse.partials.toolbar')

<div class="warehouse-layout">

    <div class="warehouse-map">

        @include('warehouse.components.warehouse-svg')

    </div>

    <div class="warehouse-panel">

        @include('warehouse.partials.right-panel')

    </div>

</div>

@include('warehouse.partials.stats')

<script>

console.log("Mapa del almacén cargado.");

</script>

@endsection