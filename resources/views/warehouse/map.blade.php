@extends('layouts.app')

@section('content')

@vite([
'resources/css/warehouse-map.css',
'resources/js/warehouse-map.js'
])

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

@endsection