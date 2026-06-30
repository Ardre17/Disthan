@extends('layouts.app')

@vite([
'resources/css/warehouse-map.css',
'resources/js/warehouse-map.js'
])

@section('content')

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

<!-- ===========================
MODAL DE RACK
=========================== -->

<div id="rackModal" class="rack-modal">

    <div class="rack-modal-content">

        <div class="rack-modal-header">

            <h2 id="rackTitle">Rack A</h2>

            <button onclick="cerrarRackModal()">✕</button>

        </div>

        <div id="rackGrid" class="rack-grid">

        </div>

        <div class="rack-footer">

            <strong id="rackInfo">

            10 ubicaciones

            </strong>

        </div>

    </div>

</div>
@endsection