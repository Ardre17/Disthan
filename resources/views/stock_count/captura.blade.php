{{-- resources/views/stock_count/captura.blade.php --}}
@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:0 auto">
    <h2 style="margin:0 0 4px;font-size:22px;color:#1a1a1a">Captura — {{ $conteo->codigo }}</h2>
    <p style="margin:0 0 20px;color:#6b7280;font-size:14px">Ingresa el stock físico contado. Los campos vacíos no se guardarán.</p>

    <form method="POST" action="{{ route('stockcount.guardar', $conteo->id) }}">
        @csrf

        <input type="text" id="buscador" placeholder="Buscar producto..."
               style="width:100%;padding:10px 14px;margin-bottom:16px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box">

        <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden">
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f9fafb;text-align:left">
                        <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Producto</th>
                        <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Stock sistema</th>
                        <th style="padding:10px 16px;font-size:12px;color:#6b7280;text-transform:uppercase">Stock físico</th>
                    </tr>
                </thead>
                <tbody id="tablaProductos">
                    @foreach($detalles as $detalle)
                    <tr class="fila-producto" data-nombre="{{ strtolower($detalle->product->nombre) }}" style="border-top:1px solid #f0f0f0">
                        <td style="padding:10px 16px">{{ $detalle->product->nombre }}</td>
                        <td style="padding:10px 16px;color:#6b7280">{{ $detalle->stock_sistema }}</td>
                        <td style="padding:10px 16px">
                            <input type="number" name="stock_fisico[{{ $detalle->id }}]" min="0"
                                   style="width:100px;padding:8px;border:1px solid #d1d5db;border-radius:6px">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <textarea name="observaciones" placeholder="Observaciones generales (opcional)"
                  style="width:100%;margin-top:16px;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;min-height:70px;box-sizing:border-box;font-family:inherit"></textarea>

        <button type="submit" style="margin-top:16px;padding:12px 22px;background:#1D9E75;color:#fff;border:none;border-radius:8px;font-weight:500;cursor:pointer">
            Guardar conteo
        </button>
    </form>
</div>

<script>
document.getElementById('buscador').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.fila-producto').forEach(fila => {
        fila.style.display = fila.dataset.nombre.includes(q) ? '' : 'none';
    });
});
</script>
@endsection