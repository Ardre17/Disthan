@extends('layouts.app')

@section('content')
<style>
.conc-detail{max-width:1700px;margin:0 auto;padding:22px;color:#19324d}
.conc-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:18px}
.conc-head h1{font-size:25px;font-weight:800;margin:0;color:#163b67}
.conc-muted{color:#718198;font-size:13px}
.conc-card{background:#fff;border:1px solid #dce6f1;border-radius:14px;padding:18px;box-shadow:0 5px 18px rgba(21,56,94,.05);margin-bottom:18px}
.conc-btn{display:inline-block;border:0;border-radius:9px;background:#1769d1;color:#fff;padding:10px 15px;font-weight:700;cursor:pointer;text-decoration:none}
.conc-btn.secondary{background:#eef4fb;color:#23486f;border:1px solid #d3e0ef}
.conc-stats{display:grid;grid-template-columns:repeat(4,minmax(130px,1fr));gap:12px}
.conc-stat{border:1px solid #e0e8f2;border-radius:11px;padding:13px;background:#fbfdff}
.conc-stat small{display:block;color:#6d8098;font-size:12px;font-weight:700}
.conc-stat strong{display:block;font-size:23px;color:#183e68;margin-top:5px}
.conc-table-wrap{overflow:auto}
.conc-table{width:100%;border-collapse:collapse;min-width:1450px}
.conc-table th{background:#f0f5fb;color:#415a78;text-align:left;font-size:12px;padding:11px;border-bottom:1px solid #dbe5f0;white-space:nowrap}
.conc-table td{padding:10px 11px;border-bottom:1px solid #edf1f6;font-size:13px;vertical-align:top}
.conc-pill{display:inline-block;border-radius:999px;padding:5px 9px;font-size:12px;font-weight:800;white-space:nowrap}
.pill-coincidencia{background:#e8f7ed;color:#176534}.pill-diferencia{background:#fff1dd;color:#965600}.pill-pendiente{background:#eef2f7;color:#4a6079}
.conc-filter{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.conc-filter select{border:1px solid #cbd8e7;border-radius:9px;padding:10px;background:#fff;color:#213b58}
.conc-num{text-align:right;font-variant-numeric:tabular-nums;white-space:nowrap}
.conc-diff{font-weight:800}
@media(max-width:800px){.conc-detail{padding:12px}.conc-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
</style>
<div class="conc-detail">
    <div class="conc-head">
        <div>
            <h1>Comparación de inventario #{{ $reconciliacion->id }}</h1>
            <p class="conc-muted" style="margin:6px 0 0">
                Producto: <strong>{{ $reconciliacion->nombre ?? '—' }}</strong>
                · Archivo: {{ $reconciliacion->archivo_origen ?? '—' }}
                · Comparación con tolerancia de fechas de ±7 días
            </p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a class="conc-btn secondary" href="{{ route('reconciliacion.index') }}">Volver al historial</a>
            <form action="{{ route('reconciliacion.compare', $reconciliacion->id) }}" method="POST" style="margin:0">
                @csrf
                <button class="conc-btn" type="submit" onclick="return confirm('¿Volver a comparar esta conciliación? Se recalcularán los estados guardados; no se modificará el stock.')">Volver a comparar</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div style="border-radius:10px;padding:13px 16px;margin-bottom:16px;background:#edf9f0;border:1px solid #b7e4c1;color:#176534">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div style="border-radius:10px;padding:13px 16px;margin-bottom:16px;background:#fff8f8;border:1px solid #f3b6b6;color:#a12626">
            <ul style="margin:0;padding-left:20px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="conc-card">
        <div class="conc-stats">
            <div class="conc-stat"><small>TOTAL DE MOVIMIENTOS</small><strong>{{ $conteos->total ?? 0 }}</strong></div>
            <div class="conc-stat"><small>COINCIDENCIAS</small><strong style="color:#218044">{{ $conteos->coincidencias ?? 0 }}</strong></div>
            <div class="conc-stat"><small>DIFERENCIAS</small><strong style="color:#b36b00">{{ $conteos->diferencias ?? 0 }}</strong></div>
            <div class="conc-stat"><small>PENDIENTES</small><strong style="color:#5b6f85">{{ $conteos->pendientes ?? 0 }}</strong></div>
        </div>
    </div>

    <div class="conc-card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:14px">
            <div><h2 style="font-size:17px;font-weight:800;margin:0">Tabla comparativa</h2><p class="conc-muted" style="margin:5px 0 0">Compara cada fila del CSV con el movimiento de DISTAN asociado.</p></div>
            <form method="GET" action="{{ route('reconciliacion.show', $reconciliacion->id) }}" class="conc-filter">
                <label for="estado" class="conc-muted">Mostrar:</label>
                <select name="estado" id="estado">
                    <option value="" @selected(!$estadoFiltro)>Todos los estados</option>
                    <option value="diferencia" @selected($estadoFiltro === 'diferencia')>Solo diferencias</option>
                    <option value="pendiente" @selected($estadoFiltro === 'pendiente')>Solo pendientes</option>
                    <option value="coincidencia" @selected($estadoFiltro === 'coincidencia')>Solo coincidencias</option>
                </select>
                <button class="conc-btn" type="submit">Filtrar</button>
                <a class="conc-btn secondary" href="{{ route('reconciliacion.show', $reconciliacion->id) }}">Limpiar</a>
            </form>
        </div>
        <div class="conc-table-wrap">
            <table class="conc-table">
                <thead>
                    <tr>
                        <th>Fila CSV</th>
                        <th>Razón social</th>
                        <th>Tipo</th>
                        <th>Fecha CSV</th>
                        <th class="conc-num">Ingreso CSV</th>
                        <th class="conc-num">Salida CSV</th>
                        <th>Fuente Kardex</th>
                        <th>Referencia Kardex</th>
                        <th>Fecha Kardex</th>
                        <th class="conc-num">Cantidad Kardex</th>
                        <th class="conc-num">Diferencia cantidad</th>
                        <th>Resultado</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($movimientos as $m)
                    @php
                        $status = $m->estado_conciliacion ?? 'pendiente';
                        $statusLabel = $status === 'coincidencia' ? 'Coincidencia' : ($status === 'diferencia' ? 'Diferencia' : 'Pendiente');
                        $kardexDirection = $m->tipo_csv === 'Ingreso' ? 'Ingreso' : ($m->tipo_csv === 'Salida' ? 'Salida' : '—');
                    @endphp
                    <tr>
                        <td>{{ $m->numero_fila }}</td>
                        <td>{{ $m->razon_social ?: '—' }}</td>
                        <td>{{ $m->tipo_csv }}</td>
                        <td>{{ $m->fecha_movimiento ?: '—' }}</td>
                        <td class="conc-num">{{ number_format((float)$m->ingresos, 3, '.', ',') }}</td>
                        <td class="conc-num">{{ number_format((float)$m->salidas, 3, '.', ',') }}</td>
                        <td>{{ $m->kardex['fuente'] ?? 'Sin movimiento asociado' }}</td>
                        <td>{{ $m->kardex['referencia'] ?? '—' }}</td>
                        <td>{{ $m->kardex['fecha_kardex'] ?? '—' }}</td>
                        <td class="conc-num">{{ $m->cantidad_kardex !== null ? number_format($m->cantidad_kardex, 3, '.', ',') : '—' }}</td>
                        <td class="conc-num conc-diff">
                            @if($m->diferencia_cantidad !== null)
                                {{ $m->diferencia_cantidad > 0 ? '+' : '' }}{{ number_format($m->diferencia_cantidad, 3, '.', ',') }}
                            @else
                                —
                            @endif
                        </td>
                        <td><span class="conc-pill pill-{{ $status }}">{{ $statusLabel }}</span></td>
                        <td style="min-width:260px">{{ $m->observacion ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="13" style="text-align:center;padding:28px">No hay movimientos para el filtro seleccionado.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <p class="conc-muted" style="margin:12px 0 0">La diferencia se calcula como cantidad CSV menos cantidad Kardex. Un valor positivo indica que el CSV registra más unidades; un valor negativo indica que DISTAN registra más.</p>
    </div>
</div>
@endsection
