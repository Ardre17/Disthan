@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                📦 Configuración Logística
            </h4>
        </div>

        <div class="card-body">

            <h5 class="mb-4">
                Producto:
                <strong>{{ $product->nombre }}</strong>
            </h5>

            <form method="POST"
                  action="{{ route('products.logistic.update',$product) }}">

                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Largo (cm)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="largo_cm"
                            class="form-control"
                            value="{{ old('largo_cm',$logistic->largo_cm) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Ancho (cm)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="ancho_cm"
                            class="form-control"
                            value="{{ old('ancho_cm',$logistic->ancho_cm) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Alto (cm)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="alto_cm"
                            class="form-control"
                            value="{{ old('alto_cm',$logistic->alto_cm) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Peso por caja (Kg)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="peso_caja"
                            class="form-control"
                            value="{{ old('peso_caja',$logistic->peso_caja) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Máximo cajas por pallet
                        </label>

                        <input
                            type="number"
                            name="max_cajas_pallet"
                            class="form-control"
                            value="{{ old('max_cajas_pallet',$logistic->max_cajas_pallet) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Máximo niveles
                        </label>

                        <input
                            type="number"
                            name="max_niveles"
                            class="form-control"
                            value="{{ old('max_niveles',$logistic->max_niveles) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Altura máxima pallet (cm)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="altura_maxima_pallet"
                            class="form-control"
                            value="{{ old('altura_maxima_pallet',$logistic->altura_maxima_pallet) }}">
                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Permite mezcla
                        </label>

                        <select
                            name="permite_mezcla"
                            class="form-select">

                            <option value="1"
                                {{ $logistic->permite_mezcla ? 'selected' : '' }}>
                                Sí
                            </option>

                            <option value="0"
                                {{ !$logistic->permite_mezcla ? 'selected' : '' }}>
                                No
                            </option>

                        </select>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Orientación
                        </label>

                        <select
                            name="orientacion"
                            class="form-select">

                            <option value="NORMAL"
                                {{ $logistic->orientacion=='NORMAL'?'selected':'' }}>
                                NORMAL
                            </option>

                            <option value="ACOSTADO"
                                {{ $logistic->orientacion=='ACOSTADO'?'selected':'' }}>
                                ACOSTADO
                            </option>

                            <option value="VERTICAL"
                                {{ $logistic->orientacion=='VERTICAL'?'selected':'' }}>
                                VERTICAL
                            </option>

                        </select>

                    </div>
                    <div class="col-md-4 mb-3">

    <label class="form-label">
        Prioridad de apilado
    </label>

    <input
        type="number"
        name="prioridad_apilado"
        class="form-control"
        value="{{ old('prioridad_apilado',$logistic->prioridad_apilado) }}">

</div>
<div class="col-md-4 mb-3">

    <label class="form-label">
        Grupo logístico
    </label>

    <select
        name="grupo_logistico"
        class="form-select">

        <option value="GENERAL"
            {{ $logistic->grupo_logistico=='GENERAL'?'selected':'' }}>
            General
        </option>

        <option value="LIQUIDOS"
            {{ $logistic->grupo_logistico=='LIQUIDOS'?'selected':'' }}>
            Líquidos
        </option>

        <option value="CONSERVAS"
            {{ $logistic->grupo_logistico=='CONSERVAS'?'selected':'' }}>
            Conservas
        </option>

        <option value="VIDRIO"
            {{ $logistic->grupo_logistico=='VIDRIO'?'selected':'' }}>
            Vidrio
        </option>

        <option value="FRAGIL"
            {{ $logistic->grupo_logistico=='FRAGIL'?'selected':'' }}>
            Frágil
        </option>

    </select>

</div>
<div class="col-md-4 mb-3">

    <label class="form-label">
        ¿Se puede apilar?
    </label>

    <select
        name="apilable"
        class="form-select">

        <option value="1"
            {{ $logistic->apilable ? 'selected':'' }}>
            Sí
        </option>

        <option value="0"
            {{ !$logistic->apilable ? 'selected':'' }}>
            No
        </option>

    </select>

</div>
<div class="col-md-4 mb-3">

    <label class="form-label">
        Peso máximo sobre el producto (Kg)
    </label>

    <input
        type="number"
        step="0.01"
        name="peso_maximo_encima"
        class="form-control"
        value="{{ old('peso_maximo_encima',$logistic->peso_maximo_encima) }}">

</div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Estado
                        </label>

                        <select
                            name="activo"
                            class="form-select">

                            <option value="1"
                                {{ $logistic->activo ? 'selected':'' }}>
                                Activo
                            </option>

                            <option value="0"
                                {{ !$logistic->activo ? 'selected':'' }}>
                                Inactivo
                            </option>

                        </select>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between">

                    <a href="{{ route('products.index') }}"
                       class="btn btn-secondary">

                        ← Volver

                    </a>

                    <button
                        class="btn btn-success">

                        💾 Guardar Configuración

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection