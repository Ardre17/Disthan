<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
@page { margin: 28px 30px 38px; }
body { font-family: DejaVu Sans, sans-serif; color:#172033; font-size:9px; }
.header { background:#1e3a5f; color:#fff; padding:14px 16px; margin-bottom:14px; }
h1 { font-size:17px; margin:0 0 5px; }
.subtitle { font-size:9px; color:#dbeafe; }
.meta { margin:0 0 13px; padding:9px 11px; background:#f1f5f9; border:1px solid #dbe3ed; }
.meta span { display:inline-block; margin-right:22px; }
.meta b { color:#334155; }
table { width:100%; border-collapse:collapse; table-layout:auto; }
th { background:#eaf0f7; color:#334155; text-transform:uppercase; font-size:8px; text-align:left; padding:8px 6px; border:1px solid #d7e0eb; }
td { padding:7px 6px; border:1px solid #e1e7ef; vertical-align:middle; }
.num { text-align:right; white-space:nowrap; }
.center { text-align:center; }
tr { page-break-inside:avoid; }
.footer { margin-top:13px; color:#64748b; font-size:8px; }
.pill { font-weight:bold; }
</style>
</head>
<body>
<div class="header"><h1>INTELIGENCIA COMERCIAL</h1><div class="subtitle">{{ $titulo }}</div></div>
<div class="meta">
    <span><b>Tipo de cliente:</b> {{ $tituloSegmento }}</span>
    <span><b>Desde:</b> {{ $desde ? \Illuminate\Support\Carbon::parse($desde)->format('d/m/Y') : 'Sin límite' }}</span>
    <span><b>Hasta:</b> {{ $hasta ? \Illuminate\Support\Carbon::parse($hasta)->format('d/m/Y') : 'Sin límite' }}</span>
    @if($productoBuscado)<span><b>Producto buscado:</b> {{ $productoBuscado }}</span>@endif
    <span><b>Generado:</b> {{ now()->format('d/m/Y H:i') }}</span>
</div>
@if($tipoReporte === 'matriz')
    <h3>Clientes que solicitaron el producto / resultados de prioridad</h3>
    <table><thead><tr><th>Cliente</th><th class="num">Productos</th><th class="num">Solicitado</th><th class="num">Despachado</th><th class="num">Faltante</th><th>Prioridad</th><th class="num">Atención</th><th class="num">Índice máx.</th></tr></thead><tbody>
    @forelse($rows as $r)<tr><td>{{ $r->cliente }}</td><td class="num">{{ number_format($r->productos,0) }}</td><td class="num">{{ number_format($r->solicitadas,0) }}</td><td class="num">{{ number_format($r->despachadas,0) }}</td><td class="num">{{ number_format($r->faltantes,0) }}</td><td>{{ $r->prioridad }}</td><td class="num">{{ number_format($r->atencion,2) }}%</td><td class="num">{{ number_format($r->indice,2) }}</td></tr>
    @empty<tr><td colspan="8">No hay resultados para los filtros seleccionados.</td></tr>@endforelse
    </tbody></table>
@elseif($tipoReporte === 'matriz_detalle')
    <h3>Productos y prioridades · {{ $cliente->nombre ?? 'Cliente' }}</h3>
    <table><thead><tr><th>Producto</th><th>SKU</th><th class="num">Pedidos</th><th class="num">Solicitado</th><th class="num">Despachado</th><th class="num">Faltante</th></tr></thead><tbody>
    @forelse($rows as $r)<tr><td>{{ $r->producto }}</td><td>{{ $r->sku }}</td><td class="num">{{ number_format($r->pedidos,0) }}</td><td class="num">{{ number_format($r->solicitadas,0) }}</td><td class="num">{{ number_format($r->despachadas,0) }}</td><td class="num">{{ number_format($r->faltantes,0) }}</td></tr>
    @empty<tr><td colspan="6">No hay productos para los filtros seleccionados.</td></tr>@endforelse
    </tbody></table>
@elseif($tipoReporte === 'clientes')
    <h3>Resumen de clientes</h3>
    <table><thead><tr><th>Cliente</th><th class="num">Pedidos</th><th class="num">Solicitado</th><th class="num">Despachado</th><th class="num">Faltante</th><th class="num">Atención</th></tr></thead><tbody>
    @forelse($rows as $r)<tr><td>{{ $r->cliente }}</td><td class="num">{{ number_format($r->pedidos,0) }}</td><td class="num">{{ number_format($r->solicitadas,0) }}</td><td class="num">{{ number_format($r->despachadas,0) }}</td><td class="num">{{ number_format($r->faltantes,0) }}</td><td class="num">{{ number_format($r->atencion,2) }}%</td></tr>
    @empty<tr><td colspan="6">No hay clientes para los filtros seleccionados.</td></tr>@endforelse
    </tbody></table>
@else
    <h3>Productos solicitados por {{ $cliente->nombre ?? 'cliente seleccionado' }}</h3>
    <table><thead><tr><th>#</th><th>Producto</th><th>SKU</th><th class="num">Pedidos</th><th class="num">Solicitado</th><th class="num">Despachado</th><th class="num">Faltante</th><th class="num">Atención</th></tr></thead><tbody>
    @forelse($rows as $i=>$r)<tr><td>{{ $i+1 }}</td><td>{{ $r->producto }}</td><td>{{ $r->sku }}</td><td class="num">{{ number_format($r->pedidos,0) }}</td><td class="num">{{ number_format($r->solicitadas,0) }}</td><td class="num">{{ number_format($r->despachadas,0) }}</td><td class="num">{{ number_format($r->faltantes,0) }}</td><td class="num">{{ number_format($r->atencion,2) }}%</td></tr>
    @empty<tr><td colspan="8">No hay productos registrados para este cliente.</td></tr>@endforelse
    </tbody></table>
@endif
<div class="footer">DISTAN ERP · Reporte generado con los filtros seleccionados. Documento de consulta; no modifica los registros del sistema.</div>
</body></html>
