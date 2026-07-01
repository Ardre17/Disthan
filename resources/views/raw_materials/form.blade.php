<form method="POST"
      action="{{ isset($raw_material)
            ? route('raw-materials.update',$raw_material)
            : route('raw-materials.store') }}">

    @csrf

    @isset($raw_material)
        @method('PUT')
    @endisset

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">

                📦 Información General

            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-9 mb-3">

                    <label>Nombre</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name',$raw_material->name ?? '') }}"
                        required>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Categoría</label>

                    <input
                        type="text"
                        name="category"
                        class="form-control"
                        value="{{ old('category',$raw_material->category ?? '') }}">

                </div>

                <div class="col-md-4 mb-3">

                    <label>Proveedor</label>

                    <input
                        type="text"
                        name="supplier"
                        class="form-control"
                        value="{{ old('supplier',$raw_material->supplier ?? '') }}">

                </div>

                <div class="col-md-2 mb-3">

                    <label>Color</label>

                    <input
                        type="text"
                        name="color"
                        class="form-control"
                        value="{{ old('color',$raw_material->color ?? '') }}">

                </div>

                <div class="col-md-2 mb-3">

                    <label>Unidad</label>

                    <select
                        name="unit"
                        class="form-select">

                        @foreach(['KG','LITROS','UNIDADES'] as $unidad)

                            <option
                                value="{{ $unidad }}"
                                @selected(old('unit',$raw_material->unit ?? '')==$unidad)>

                                {{ $unidad }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>

    <br>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                📦 Inventario

            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">

                    <label>Stock Actual</label>

                    <input
                        type="number"
                        step="0.01"
                        name="stock"
                        class="form-control"
                        value="{{ old('stock',$raw_material->stock ?? 0) }}">

                </div>

                <div class="col-md-3">

                    <label>Stock Mínimo</label>

                    <input
                        type="number"
                        step="0.01"
                        name="minimum_stock"
                        class="form-control"
                        value="{{ old('minimum_stock',$raw_material->minimum_stock ?? 0) }}">

                </div>

               

                <div class="col-md-3">

                    <label>Activo</label>

                    <select
                        name="active"
                        class="form-select">

                        <option value="1"
                            @selected(old('active',$raw_material->active ?? true))>

                            Sí

                        </option>

                        <option value="0"
                            @selected(!old('active',$raw_material->active ?? true))>

                            No

                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    <br>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-secondary text-white">

            Observaciones

        </div>

        <div class="card-body">

            <textarea
                name="notes"
                rows="4"
                class="form-control">{{ old('notes',$raw_material->notes ?? '') }}</textarea>

        </div>

    </div>

    <br>

    <div class="text-end">

        <a
            href="{{ route('raw-materials.index') }}"
            class="btn btn-secondary">

            Cancelar

        </a>

        <button
            class="btn btn-success">

            💾 Guardar Materia Prima

        </button>

    </div>

</form>