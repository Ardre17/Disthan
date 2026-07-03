@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                📒 Kardex General

            </h2>

            <small class="text-muted">

                Historial de todos los movimientos de inventario.

            </small>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>Fecha</th>

                        <th>Artículo</th>

                        <th>Tipo</th>

                        <th>Documento</th>

                        <th>Entrada</th>

                        <th>Salida</th>

                        <th>Stock</th>

                        <th>Usuario</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($movements as $m)

                    <tr>

                        <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>

                        <td>
                            {{ $m->product?->nombre ?? $m->rawMaterial?->name }}
                        </td>

                        <td>{{ $m->movement_type }}</td>

                        <td>{{ $m->document_number }}</td>

                        <td>{{ $m->entry }}</td>

                        <td>{{ $m->exit }}</td>

                        <td>{{ $m->stock_after }}</td>

                        <td>{{ $m->user?->name }}</td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center">

                            No existen movimientos registrados.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">

        {{ $movements->links() }}

    </div>

</div>

@endsection