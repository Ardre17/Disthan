@extends('layouts.app')

@section('content')

<style>
/* igual que create */
</style>

<div class="page">

    <div class="erp-bar">
        <div class="erp-bar-left">
            <div class="erp-sep"></div>
            <div class="erp-module">Editar Precinto</div>
        </div>

        <span style="font-size:11px;color:#5a8abf;">
            Inventario › Precinto › Editar
        </span>
    </div>

    <div style="padding:1.1rem;background:#eef1f5;min-height:100vh;font-family:'Segoe UI',sans-serif;">

        <h2 style="font-size:17px;font-weight:700;color:#0f172a;margin-bottom:1rem;">
            Editar: {{ $precinto->nombre }}
        </h2>

        @if($errors->any())
            <div style="background:#fbe9e8;border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;margin-bottom:.85rem;font-size:12px;color:#c0312b;">
                <strong>⚠️ Errores:</strong>
                <ul style="margin:.4rem 0 0 1rem;">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('precintos.update', $precinto) }}">

            @csrf
            @method('PUT')

            <div style="background:#fff;border:1px solid #dde2ea;border-radius:4px;padding:1rem;margin-bottom:10px;">

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">

                    <div>
                        <label style="font-size:10px;font-weight:700;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:3px;">
                            Nombre *
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            required
                            value="{{ old('nombre',$precinto->nombre) }}"
                            style="width:100%;padding:7px 9px;border:1px solid #dde2ea;border-radius:3px;font-size:12px;outline:none;">
                    </div>

                    <div>

                        <label style="font-size:10px;font-weight:700;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:3px;">
                            Color *
                        </label>

                        <select
                            name="color"
                            required
                            style="width:100%;padding:7px 9px;border:1px solid #dde2ea;border-radius:3px;font-size:12px;">

                            @foreach($colores as $color)
                                <option
                                    value="{{ $color }}"
                                    {{ old('color',$precinto->color)==$color ? 'selected' : '' }}>
                                    {{ $color }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label style="font-size:10px;font-weight:700;color:#5b6b7d;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:3px;">
                            Stock mínimo *
                        </label>

                        <input
                            type="number"
                            name="stock_minimo"
                            required
                            min="0"
                            step="0.01"
                            value="{{ old('stock_minimo',$precinto->stock_minimo) }}"
                            style="width:100%;padding:7px 9px;border:1px solid #dde2ea;border-radius:3px;font-size:14px;font-weight:700;text-align:center;color:#b9690e;background:#fdf1e2;outline:none;">

                    </div>

                    <div style="display:flex;align-items:flex-end;">

                        <div style="background:#f4f6f9;border-radius:3px;padding:8px;text-align:center;width:100%;">

                            <div style="font-size:10px;color:#5b6b7d;text-transform:uppercase;margin-bottom:3px;">
                                Stock actual
                            </div>

                            <div style="font-size:20px;font-weight:800;font-family:'Consolas',monospace;color:#1c7c4d;">
                                {{ number_format($precinto->stock_actual,0) }}
                            </div>

                            <div style="font-size:10px;color:#94a3b8;">
                                Usar Kardex para modificar el stock.
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div style="display:flex;gap:8px;">

                <button
                    type="submit"
                    style="padding:8px 20px;background:#0b5ed7;color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;">
                    💾 Guardar cambios
                </button>

                <a
                    href="{{ route('precintos.index') }}"
                    style="padding:8px 16px;background:#fff;color:#5b6b7d;border:1px solid #dde2ea;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;">
                    ✕ Cancelar
                </a>

                <a
                    href="{{ route('precintos.show', $precinto) }}"
                    style="padding:8px 14px;background:#e8f5ee;color:#1c7c4d;border:1px solid #b7dfca;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;">
                    📋 Ver Kardex
                </a>

            </div>

        </form>

    </div>

</div>

@endsection