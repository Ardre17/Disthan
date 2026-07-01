@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">📦 Materia Prima</h2>
            <small class="text-muted">
                Control de materias primas disponibles para producción.
            </small>
        </div>
        @if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Se encontraron errores:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

        <a href="{{ route('raw-materials.create') }}"
           class="btn btn-primary">

            + Nueva Materia Prima

        </a>
        <div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <h2>{{ $total }}</h2>

                <small>Total</small>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <h2 class="text-success">

                    {{ $disponibles }}

                </h2>

                <small>Disponibles</small>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <h2 class="text-warning">

                    {{ $stockBajo }}

                </h2>

                <small>Stock Bajo</small>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center">

                <h2 class="text-danger">

                    {{ $agotadas }}

                </h2>

                <small>Agotadas</small>

            </div>

        </div>

    </div>

</div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <input
            type="text"
            id="buscarMateria"
            class="form-control"
            placeholder="Buscar materia prima...">

    </div>

</div>
    <div class="row">

        @forelse($materials as $material)

        <div class="col-md-4 mb-4 materia-card">

            <div class="card shadow-sm h-100

@if($material->status=='DISPONIBLE')

border-success

@elseif($material->status=='STOCK_BAJO')

border-warning

@else

border-danger

@endif

">

                <div class="card-body">

                    <h5 class="fw-bold">

                        {{ $material->name }}

                    </h5>

                    <hr>

                    <p>

                        <strong>Código:</strong>

                        {{ $material->code }}

                    </p>

                    <p>

                        <strong>Categoría:</strong>

                        {{ $material->category }}

                    </p>

                    <p>

                        <strong>Proveedor:</strong>
                        <p>

<strong>Color:</strong>

{{ $material->color }}

</p>

                        {{ $material->supplier }}

                    </p>

                    <p>

                        <strong>Stock:</strong>

                        {{ $material->stock }}

                        {{ $material->unit }}

                    </p>

                    <p>

                        <strong>Estado:</strong>

                        @if($material->status=="DISPONIBLE")

                            <span class="badge bg-success">

                                Disponible

                            </span>

                        @elseif($material->status=="STOCK_BAJO")

                            <span class="badge bg-warning text-dark">

                                Stock Bajo

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Agotado

                            </span>

                        @endif

                    </p>

                </div>

                <div class="card-footer bg-white">

                    <a href="{{ route('raw-materials.edit',$material) }}"
                       class="btn btn-outline-primary btn-sm">

                        Editar

                    </a>
                    <a href="{{ route('raw-materials.show',$material) }}"
                        class="btn btn-outline-success btn-sm">

                        Ver

                        </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info">

                No hay materias primas registradas.

            </div>

        </div>

        @endforelse

    </div>

</div>
<script>

document
.getElementById("buscarMateria")
.addEventListener("keyup",function(){

    let texto=this.value.toLowerCase();

    document.querySelectorAll(".materia-card").forEach(card=>{

        card.style.display=
            card.innerText.toLowerCase().includes(texto)
            ? ""
            : "none";

    });

});

</script>
@endsection