{{-- resources/views/stock_count/detalle.blade.php --}}
@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:0 auto">
    <h2 style="margin:0 0 4px;font-size:22px;color:#1a1a1a">{{ $conteo->codigo }}</h2>
    <p style="margin:0 0 20px;color:#6b7280;font-size:14px">
        {{ \Carbon\Carbon::parse($conteo->fecha)->format('d/m/Y') }} — {{ $conteo->realizado_por ?? 'Sin asignar' }}
    </p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px">
            <p style="margin:0;font-size:13px;color:#6b7280">Productos con diferencia</p>
            <p style="margin:6px 0 0;font-size:26px;font-weight:600;color:#1a1a1a">{{ $totalDiferencias }}</p>
        </div>
        <div style="background:#eafaf0;border-radius:12px;padding:16px">
            <p style="margin:0;font-size:13px;color:#0f6e56">Sobrantes totales</p>
            <p style="margin:6px 0 0;font-size:26px;font-weight:600;color:#1D9E75">+{{ $sobrantes }}</p>
        </div>
        <div style="background:#faece7;border-radius:12px;padding:16px">
            <p style="margin:0;font-size:13px;color:#993c1d">Faltantes totales</p>
            <p style="margin:6px 0 0;font-size:26px;font-weight:600;color:#D85A30">{{ $faltantes }}</p>
        </div>
    </div>

    <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f9fafb;text-align:left">
                    <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Producto</th>
                    <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Sistema</th>
                    <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Físico</th>
                    <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Diferencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $detalle)
                <tr style="border-top:1px solid #f0f0f0">
                    <td style="padding:10px 16px">{{ $detalle->product->nombre }}</td>
                    <td style="padding:10px 16px;color:#6b7280">{{ $detalle->stock_sistema }}</td>
                    <td style="padding:10px 16px;color:#6b7280">{{ $detalle->stock_fisico ?? '—' }}</td>
                    <td style="padding:10px 16px;font-weight:600;color:{{ $detalle->diferencia > 0 ? '#1D9E75' : ($detalle->diferencia < 0 ? '#D85A30' : '#9ca3af') }}">
                        {{ $detalle->diferencia !== null ? ($detalle->diferencia > 0 ? '+' : '') . $detalle->diferencia : '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection