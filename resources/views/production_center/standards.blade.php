@extends('layouts.app')
@section('content')
<style>
.pc{padding:18px;background:#f3f6fb;min-height:calc(100vh - 70px);color:#172338}.pc-card{background:#fff;border:1px solid #dce4ef;border-radius:9px;padding:16px;margin-bottom:12px}.pc-grid{display:grid;grid-template-columns:2fr 1fr 2fr auto;gap:9px;align-items:end}.pc-field{display:flex;flex-direction:column;gap:5px}.pc-field label{font-size:10px;font-weight:800;color:#64748b}.pc-field input,.pc-field select{padding:9px;border:1px solid #d5deeb;border-radius:6px}.pc-btn{padding:9px 13px;border:1px solid #075ee8;background:#075ee8;color:#fff;border-radius:6px;font-weight:700;cursor:pointer}.pc-table{width:100%;border-collapse:collapse}.pc-table td,.pc-table th{text-align:left;padding:10px;border-bottom:1px solid #edf1f6;font-size:11px}.pc-table th{color:#64748b;background:#f7f9fc}
@media(max-width:750px){.pc-grid{grid-template-columns:1fr}.pc{padding:9px}}
</style>
<div class="pc">
    <div class="pc-card">
        <h2 style="font-size:18px;margin:0 0 5px">Tiempos estándar por producto</h2>
        <p style="font-size:11px;color:#64748b">Configura cuántos segundos toma fabricar una unidad. El valor se copia a cada nueva orden y no modifica las anteriores.</p>
        @if(session('success'))<div style="background:#e8f7ee;color:#166534;padding:9px;border-radius:6px;margin:10px 0">{{ session('success') }}</div>@endif
        @if($errors->any())<div style="color:#be123c;margin:10px 0">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('production-center.standards.save') }}" class="pc-grid">
            @csrf
            <div class="pc-field"><label>PRODUCTO</label><select name="product_id" required><option value="">Seleccionar</option>@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->nombre }} · {{ $p->sku }}</option>@endforeach</select></div>
            <div class="pc-field"><label>SEGUNDOS / UNIDAD</label><input name="seconds_per_unit" type="number" min="0.001" step="0.001" required placeholder="50"></div>
            <div class="pc-field"><label>NOTA</label><input name="notes" placeholder="Ej. frasco de 250 g, línea manual"></div>
            <button class="pc-btn">Guardar estándar</button>
        </form>
    </div>
    <div class="pc-card">
        <h3 style="font-size:14px;margin:0 0 10px">Catálogo de tiempos</h3>
        <div style="overflow:auto"><table class="pc-table"><thead><tr><th>Producto</th><th>SKU</th><th>Segundos por unidad</th><th>Nota</th><th>Estado</th></tr></thead><tbody>
        @forelse($standards as $s)<tr><td>{{ $s->product->nombre ?? 'Producto eliminado' }}</td><td>{{ $s->product->sku ?? '—' }}</td><td><strong>{{ number_format((float)$s->seconds_per_unit,3) }} s</strong></td><td>{{ $s->notes ?? '—' }}</td><td>{{ $s->active ? 'Activo' : 'Inactivo' }}</td></tr>@empty<tr><td colspan="5">Todavía no hay tiempos estándar configurados.</td></tr>@endforelse
        </tbody></table></div>
    </div>
    <a href="{{ route('production-center.index') }}" style="font-size:12px">← Volver al centro de producción</a>
</div>
@endsection
