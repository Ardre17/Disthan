{{-- resources/views/stock_count/historial.blade.php --}}
@extends('layouts.app')

@section('content')
<div style="max-width:1000px;margin:0 auto">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
        <div>
            <h2 style="margin:0;font-size:22px;color:#1a1a1a">Conteo físico de inventario</h2>
            <p style="margin:4px 0 0;color:#6b7280;font-size:14px">Historial de sesiones de conteo y diferencias detectadas</p>
        </div>
        <form method="POST" action="{{ route('stockcount.nuevo') }}">
            @csrf
            <button type="submit" style="padding:10px 18px;background:#1D9E75;color:#fff;border:none;border-radius:8px;font-weight:500;cursor:pointer">
                + Nuevo conteo
            </button>
        </form>
    </div>

    <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f9fafb;text-align:left">
                    <th style="padding:12px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Código</th>
                    <th style="padding:12px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Fecha</th>
                    <th style="padding:12px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Responsable</th>
                    <th style="padding:12px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Estado</th>
                    <th style="padding:12px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Productos</th>
                    <th style="padding:12px 16px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($conteos as $conteo)
                <tr style="border-top:1px solid #f0f0f0">
                    <td style="padding:12px 16px;font-weight:500">{{ $conteo->codigo }}</td>
                    <td style="padding:12px 16px;color:#4b5563">{{ \Carbon\Carbon::parse($conteo->fecha)->format('d/m/Y') }}</td>
                    <td style="padding:12px 16px;color:#4b5563">{{ $conteo->realizado_por ?? '—' }}</td>
                    <td style="padding:12px 16px">
                        <span style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:500;
                            background:{{ $conteo->estado === 'FINALIZADO' ? '#eafaf0' : '#fff7e6' }};
                            color:{{ $conteo->estado === 'FINALIZADO' ? '#1D9E75' : '#b7791f' }}">
                            {{ $conteo->estado === 'FINALIZADO' ? 'Finalizado' : 'En proceso' }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;color:#4b5563">{{ $conteo->detalles_count }}</td>
                    <td style="padding:12px 16px;text-align:right">
                        <a href="{{ $conteo->estado === 'EN_PROCESO' ? route('stockcount.captura', $conteo->id) : route('stockcount.show', $conteo->id) }}"
                           style="color:#1D9E75;font-weight:500;text-decoration:none;font-size:14px">
                            {{ $conteo->estado === 'EN_PROCESO' ? 'Continuar →' : 'Ver diferencias →' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding:24px;text-align:center;color:#9ca3af">Aún no hay conteos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">{{ $conteos->links() }}</div>
</div>
@endsection