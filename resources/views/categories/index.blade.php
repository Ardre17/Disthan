@extends('layouts.app')

@section('content')
<style>

.page{
    padding:30px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:10px;
}

.title{
    font-size:28px;
    font-weight:bold;
    color:#1e293b;
}

.btn-create{
    background:#2563eb;
    color:white;
    padding:12px 18px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
}

.btn-create:hover{
    opacity:.9;
}

.search-box{
    background:white;
    padding:20px;
    border-radius:12px;
    margin-bottom:25px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.search-input{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 4px 14px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover{
    transform:translateY(-3px);
}

.color-bar{
    height:8px;
}

.card-body{
    padding:20px;
}

.category-name{
    font-size:20px;
    font-weight:bold;
    color:#1e293b;
    margin-bottom:10px;
}

.status{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
    font-weight:bold;
    margin-bottom:15px;
}

.active{
    background:#16a34a;
}

.inactive{
    background:#dc2626;
}

.description{
    color:#64748b;
    min-height:60px;
}

.actions{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.btn-edit{
    flex:1;
    background:#2563eb;
    color:white;
    text-align:center;
    padding:10px;
    border-radius:8px;
    text-decoration:none;
}

.btn-delete{
    flex:1;
    background:#dc2626;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
    cursor:pointer;
}

.empty{
    background:white;
    padding:40px;
    text-align:center;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

</style>

<div class="page">

    <div class="topbar">

        <div class="title">
            🗂 Gestión de Categorías
        </div>

        <a
            href="{{ route('categories.create') }}"
            class="btn-create">
            ➕ Nueva Categoría
        </a>

    </div>

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar categoría..."
                class="search-input">

        </form>

    </div>

    @if(session('success'))

        <div style="
            background:#dcfce7;
            color:#166534;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>

    @endif

    @if($categories->count())

        <div class="grid">

            @foreach($categories as $category)

                <div class="card">

                    <div
                        class="color-bar"
                        style="
                        background:{{ $category->color }};
                        ">
                    </div>

                    <div class="card-body">

                        <div class="category-name">
                            {{ $category->nombre }}
                        </div>

                        <span class="
                            status
                            {{ $category->activo ? 'active' : 'inactive' }}
                        ">
                            {{ $category->activo ? 'ACTIVA' : 'INACTIVA' }}
                        </span>

                        <div class="description">

                            {{ $category->descripcion ?? 'Sin descripción registrada' }}

                        </div>

                        <div style="
                            margin-top:15px;
                            font-size:14px;
                            color:#64748b;
                        ">
                            📦 Productos:
                            {{ $category->products()->count() }}
                        </div>

                        <div class="actions">

                            <a
                                href="{{ route('categories.edit',$category) }}"
                                class="btn-edit">
                                Editar
                            </a>

                            <form
                                action="{{ route('categories.destroy',$category) }}"
                                method="POST"
                                style="flex:1;">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn-delete"
                                    onclick="return confirm('¿Eliminar categoría?')">
                                    Eliminar
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty">

            <h2>
                No existen categorías registradas
            </h2>

            <p>
                Comienza creando tu primera categoría.
            </p>

        </div>

    @endif

</div>

@endsection