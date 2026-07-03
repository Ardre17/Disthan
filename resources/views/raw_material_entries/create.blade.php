@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">
                📥 Entrada de Materia Prima
            </h4>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('raw-material-entries.store') }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Materia Prima

                    </label>

                    <select
                        name="raw_material_id"
                        class="form-select"
                        required>

                        <option value="">
                            Seleccione...
                        </option>

                        @foreach($materials as $material)

                        <option value="{{ $material->id }}">

                            {{ $material->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Proveedor

                    </label>

                    <input
                        type="text"
                        name="supplier"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Cantidad

                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="quantity"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Observación

                    </label>

                    <textarea
                        name="observation"
                        rows="3"
                        class="form-control"></textarea>

                </div>

                <button
                    class="btn btn-success">

                    Guardar Entrada

                </button>

                <a
                    href="{{ route('raw-materials.index') }}"
                    class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

@endsection