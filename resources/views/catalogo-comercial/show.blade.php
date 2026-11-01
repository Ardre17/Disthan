@php
/* ─────────────────────────────────────────────────────────────
   MODO DE SALIDA
   - Petición AJAX (o ?modal=1): devuelve SOLO la ventana (para abrirla como popup).
   - Petición normal: devuelve la página completa con la misma ventana en el centro.
───────────────────────────────────────────────────────────── */
$pdEmbed = request()->ajax() || request()->boolean('modal') || request()->boolean('embed');

/* ── Cálculos originales (sin cambios) ── */
$stock=(float)($product->stock ?? 0);$min=(float)($product->stock_minimo ?? 0);$stateClass=$stock<=0?'out':(($min>0&&$stock<=$min)?'low':'ok');$stateText=$stock<=0?'AGOTADO':(($min>0&&$stock<=$min)?'STOCK BAJO':'DISPONIBLE');

/* ── Cálculos nuevos para el diseño (solo derivan de los datos ya enviados) ── */

// Equivalencia en cajas
$pdCpc   = (float)($product->cantidad_por_caja ?? 0);
$pdCajas = $pdCpc > 0 ? (int) floor($stock / $pdCpc) : null;
$pdResto = $pdCpc > 0 ? $stock - ($pdCajas * $pdCpc) : null;

// Vencimiento de la ficha del producto
$pdVenc  = $product->fecha_vencimiento ? \Carbon\Carbon::parse($product->fecha_vencimiento) : null;
$pdDias  = $pdVenc ? (int) \Carbon\Carbon::today()->diffInDays($pdVenc, false) : null;

// Escala del gráfico
$pdMeses = collect($months)->values();
$pdMax   = max(1, (float) $maxMovement);
$pdPow   = pow(10, floor(log10($pdMax)));
$pdNorm  = $pdMax / $pdPow;
$pdStepN = $pdNorm <= 1.2 ? 0.25 : ($pdNorm <= 2.4 ? 0.5 : ($pdNorm <= 5 ? 1 : 2));
$pdStep  = $pdStepN * $pdPow;
$pdTop   = ceil($pdMax / $pdStep) * $pdStep;
$pdTicks = [];
for ($t = 0; $t <= $pdTop + 0.0001; $t += $pdStep) { $pdTicks[] = $t; }
$pdFmt   = function ($v) { return rtrim(rtrim(number_format($v, 2), '0'), '.'); };
$pdAltoGrafico = 170;

// Último mes vs. mes anterior
$pdActual = $pdMeses->count() ? ($pdMeses->last()['cantidad'] ?? null) : null;
$pdPrev   = $pdMeses->count() > 1 ? ($pdMeses[$pdMeses->count() - 2]['cantidad'] ?? null) : null;

// Tendencia (mismos umbrales ±15% de la lectura comercial original)
if ($variation === null)      { $pdTend = ['Sin base para comparar', 'idle', 'pd-i-wave']; }
elseif ($variation <= -15)    { $pdTend = ['Movimiento a la baja', 'down', 'pd-i-tdown']; }
elseif ($variation >= 15)     { $pdTend = ['Movimiento en alza', 'up', 'pd-i-tup']; }
else                          { $pdTend = ['Movimiento estable', 'flat', 'pd-i-wave']; }

$pdCategoria = optional($product->category)->nombre ?: 'Sin categoría';
@endphp
@if(!$pdEmbed)
<!DOCTYPE html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Detalle comercial | DISTAN ERP</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:linear-gradient(180deg,#dfe9f6,#eef3fa);color:#203047;font:14px/1.45 Inter,system-ui,-apple-system,Segoe UI,Arial,sans-serif}
.topbar{background:#142d52;color:#fff;padding:17px 28px;font-weight:800}.topbar span{color:#86c5ff}
.wrap{max-width:1040px;margin:22px auto 40px;padding:0 20px}
.back{display:inline-block;color:#1769aa;text-decoration:none;font-weight:700;margin-bottom:14px}
</style></head><body>
<header class="topbar">DISTAN <span>ERP</span> · Catálogo Comercial</header><main class="wrap">
<a class="back" href="{{ route('catalogo.publico.index') }}">← Volver al catálogo</a>
@endif

<style data-pd>
.pd-modal{--navy:#142d52;--blue:#1769aa;--ink:#203047;--muted:#718096;--line:#e2e8f0;--green:#16845b;--amber:#b7791f;--red:#c53030;
    font:13px/1.45 Inter,system-ui,-apple-system,Segoe UI,Arial,sans-serif;color:var(--ink);background:#fff;border-radius:16px;overflow:hidden;
    box-shadow:0 24px 70px rgba(15,42,77,.28);text-align:left}
.pd-modal *,.pd-modal *::before,.pd-modal *::after{box-sizing:border-box}
.pd-ic{width:18px;height:18px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}

/* Cabecera de la ventana */
.pd-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 18px;color:#fff;background:linear-gradient(90deg,#0f3a78,#1d5fb4)}
.pd-head-t{display:flex;align-items:center;gap:10px;font-size:17px;font-weight:700;white-space:nowrap}
.pd-head-t .pd-ic{width:22px;height:22px}
.pd-x{width:34px;height:34px;border-radius:9px;display:grid;place-items:center;color:#fff;background:transparent;border:0;cursor:pointer;text-decoration:none}
.pd-x:hover{background:rgba(255,255,255,.18)}
.pd-x .pd-ic{width:20px;height:20px}

.pd-body{background:#f3f7fd;padding:16px 18px 18px;display:flex;flex-direction:column;gap:12px}
.pd-in-modal .pd-body{max-height:calc(92vh - 62px);overflow-y:auto}

.pd-card{background:#fff;border:1px solid #dfe8f5;border-radius:13px;padding:14px 16px;box-shadow:0 2px 10px rgba(15,42,77,.04)}
.pd-card h2{margin:0 0 11px;display:flex;align-items:center;gap:8px;font-size:14px;color:#17385f}
.pd-card h2 .pd-ic{color:#1769aa;width:19px;height:19px}

/* Producto */
.pd-prod-top{display:flex;align-items:center;gap:16px}
.pd-img{width:92px;height:92px;flex-shrink:0;border-radius:14px;background:linear-gradient(135deg,#eaf3fd,#d9e9fa);border:1px solid #cfe0f4;color:#1769aa;display:grid;place-items:center}
.pd-img .pd-ic{width:44px;height:44px;stroke-width:1.5}
.pd-main{min-width:0;flex:1}
.pd-name{margin:0;font-size:23px;line-height:1.2;color:#17345d;font-weight:800;overflow-wrap:anywhere}
.pd-chips{display:flex;flex-wrap:wrap;gap:7px;margin-top:9px}
.pd-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border:1px solid #d5e0ef;border-radius:8px;background:#f8fafd;font-size:12px;color:#334155}
.pd-chip b{color:#17385f}
.pd-specs{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:0;margin-top:13px;border:1px solid #e3ebf6;border-radius:11px;background:#fbfdff}
.pd-spec{display:flex;align-items:center;gap:10px;padding:10px 13px;border-right:1px solid #e3ebf6;min-width:0}
.pd-spec:last-child{border-right:0}
.pd-spec .pd-ic{width:24px;height:24px;color:#1769aa;stroke-width:1.6}
.pd-spec small{display:block;color:var(--muted);font-size:11px}
.pd-spec strong{display:block;font-size:13px;color:#17385f;overflow-wrap:anywhere}

/* Estados (mismos nombres de clase de siempre) */
.pd-modal .status{display:inline-block;padding:5px 11px;border-radius:20px;font-size:11px;font-weight:800;white-space:nowrap}
.pd-modal .ok{background:#e4f7ed;color:var(--green)}
.pd-modal .low{background:#fff4d8;color:var(--amber)}
.pd-modal .out{background:#fde8e8;color:var(--red)}

/* KPIs */
.pd-kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:11px}
.pd-kpi{display:flex;align-items:center;gap:12px;padding:14px;border-radius:13px;border:1px solid}
.pd-kpi-ic{width:46px;height:46px;flex-shrink:0;border-radius:12px;display:grid;place-items:center}
.pd-kpi-ic .pd-ic{width:25px;height:25px}
.pd-kpi h3{margin:0;font-size:12px;font-weight:700;color:#334155;line-height:1.2}
.pd-kpi .value{font-size:26px;font-weight:800;color:#17385f;line-height:1.15}
.pd-kpi .muted{font-size:12px;color:#475569}
.pd-k-blue{background:#eef5ff;border-color:#c6dcfa}.pd-k-blue .pd-kpi-ic{background:#d7e8fd;color:#1d5fb4}
.pd-k-orange{background:#fff7e8;border-color:#f6dba7}.pd-k-orange .pd-kpi-ic{background:#fde9c4;color:#d98a0a}
.pd-k-green{background:#eefaf2;border-color:#c4e8d2}.pd-k-green .pd-kpi-ic{background:#d3f0de;color:#16845b}
.pd-k-purple{background:#f6f1ff;border-color:#dccffa}.pd-k-purple .pd-kpi-ic{background:#e6dcfb;color:#6d3fd1}

.pd-two{display:grid;grid-template-columns:1fr 1.15fr;gap:12px}
.pd-two.pd-two-b{grid-template-columns:1.5fr 1fr}

/* Datos de ficha */
.pd-rows{display:flex;flex-direction:column}
.pd-row{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #eef2f8;font-size:13px}
.pd-row:last-child{border-bottom:0}
.pd-row span{color:#475569}
.pd-row strong{color:#17385f;text-align:right}

/* Tabla de lotes */
.pd-modal .muted{color:var(--muted);font-size:12px}
.tablewrap{overflow:auto}
.pd-modal table{width:100%;border-collapse:collapse;min-width:420px}
.pd-modal th,.pd-modal td{text-align:left;padding:9px 10px;border-bottom:1px solid #edf1f6;font-size:12.5px}
.pd-modal th{font-size:11px;text-transform:uppercase;color:var(--muted);background:#f1f6fc;letter-spacing:.3px}

/* Gráfico */
.pd-chart-head{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;flex-wrap:wrap;margin-bottom:6px}
.pd-chart-head h2{margin:0}
.pd-range{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border:1px solid #d5e0ef;border-radius:8px;background:#fff;font-size:12px;color:#334155;white-space:nowrap}
.pd-chart{display:flex;gap:8px;margin-top:10px}
.pd-yaxis{position:relative;width:34px;flex-shrink:0;height:170px}
.pd-yaxis span{position:absolute;right:0;transform:translateY(50%);font-size:10px;color:#64748b}
.pd-plot{position:relative;flex:1;height:170px;border-bottom:1px solid #cbd5e1}
.pd-grid{position:absolute;left:0;right:0;border-top:1px dashed #e3eaf4}
.pd-cols{position:absolute;inset:0;display:flex;align-items:flex-end;justify-content:space-around;gap:8px;padding:0 4px}
.barcol{flex:1;min-width:0;height:100%;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;gap:4px}
.barvalue{font-size:11px;font-weight:700;color:#475569}
.bar{width:min(42px,70%);background:linear-gradient(180deg,#4aa1e4,#1769aa);border-radius:6px 6px 0 0;min-height:2px}
.pd-xaxis{display:flex;justify-content:space-around;gap:8px;padding:6px 4px 0 42px}
.pd-xaxis span{flex:1;text-align:center;font-size:10.5px;color:var(--muted);line-height:1.15}
.pd-note{margin-top:8px;font-size:12px;color:var(--muted)}

/* Indicadores */
.pd-ind{display:flex;flex-direction:column;gap:2px}
.pd-ind-row{display:flex;align-items:center;gap:11px;padding:10px 0;border-bottom:1px solid #eef2f8}
.pd-ind-row:last-child{border-bottom:0}
.pd-ind-row .pd-ic{width:22px;height:22px}
.pd-ind-lab{flex:1;font-size:12px;color:#475569;line-height:1.25}
.pd-ind-lab small{display:block;color:#94a3b8;font-size:11px}
.pd-ind-val{font-size:18px;font-weight:800;text-align:right;line-height:1.1;flex-shrink:0}
.negative{color:var(--red)}.positive{color:var(--green)}
.pd-trend{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:800;white-space:nowrap}
.pd-trend .pd-ic{width:17px;height:17px}
.pd-trend.flat{background:#fff2c4;color:#8a6410}.pd-trend.down{background:#fde8e8;color:var(--red)}
.pd-trend.up{background:#e4f7ed;color:var(--green)}.pd-trend.idle{background:#eef1f6;color:#64748b}

/* Recomendación */
.callout{display:flex;align-items:flex-start;gap:14px;border:1px solid #cfe2f4;background:#eaf3fc;border-radius:13px;padding:14px 16px}
.callout .pd-bulb{width:40px;height:40px;flex-shrink:0;border-radius:50%;background:#d7e8fb;color:#1d5fb4;display:grid;place-items:center}
.callout .pd-bulb .pd-ic{width:22px;height:22px}
.callout strong{display:block;color:#174c7c;margin-bottom:3px;font-size:14px}
.callout p{margin:0;color:#334155}
.footer{font-size:11.5px;color:var(--muted);margin:2px 2px 0}

@media(max-width:820px){
    .pd-kpis{grid-template-columns:repeat(2,minmax(0,1fr))}
    .pd-two,.pd-two.pd-two-b{grid-template-columns:1fr}
    .pd-specs{grid-template-columns:repeat(2,minmax(0,1fr))}
    .pd-spec:nth-child(2){border-right:0}.pd-spec:nth-child(-n+2){border-bottom:1px solid #e3eaf6}
}
@media(max-width:520px){
    .pd-body{padding:12px}
    .pd-prod-top{align-items:flex-start}.pd-img{width:64px;height:64px}.pd-img .pd-ic{width:32px;height:32px}
    .pd-name{font-size:19px}.pd-kpi{padding:11px;gap:9px}.pd-kpi-ic{width:38px;height:38px}.pd-kpi .value{font-size:21px}
}
</style>

<div class="pd-modal {{ $pdEmbed ? 'pd-in-modal' : '' }}" role="document">

{{-- Íconos (propios, no dependen de librerías) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="pd-i-cube" viewBox="0 0 24 24"><path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/></symbol>
    <symbol id="pd-i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6 6 18"/></symbol>
    <symbol id="pd-i-scale" viewBox="0 0 24 24"><path d="M12 4v16M6 20h12M5 7h14"/><path d="m6 7-3 7a3 3 0 0 0 6 0zM18 7l-3 7a3 3 0 0 0 6 0z"/></symbol>
    <symbol id="pd-i-boxes" viewBox="0 0 24 24"><path d="M12 3 7 5.8v5.6l5 2.8 5-2.8V5.8z"/><path d="M7 5.8l5 2.8 5-2.8M12 8.6v5.6"/><path d="M2.5 13.5 7 16v4.5L2.5 18zM21.5 13.5 17 16v4.5l4.5-2.5z"/><path d="M7 16l5 2.8 5-2.8"/></symbol>
    <symbol id="pd-i-barcode" viewBox="0 0 24 24"><path d="M4 5v14M7 5v14M11 5v14M14 5v14M17 5v14M20 5v14"/></symbol>
    <symbol id="pd-i-cart" viewBox="0 0 24 24"><path d="M3 4h2.5l2 11h10l2-8H7"/><circle cx="9.5" cy="19" r="1.4"/><circle cx="16.5" cy="19" r="1.4"/></symbol>
    <symbol id="pd-i-layers" viewBox="0 0 24 24"><path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/></symbol>
    <symbol id="pd-i-cal" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></symbol>
    <symbol id="pd-i-chart" viewBox="0 0 24 24"><path d="M4 20V4M4 20h16M8 16v-5M12 16V8M16 16v-3"/></symbol>
    <symbol id="pd-i-tdown" viewBox="0 0 24 24"><path d="m3 7 6 6 4-4 8 8"/><path d="M15 17h6v-6"/></symbol>
    <symbol id="pd-i-tup" viewBox="0 0 24 24"><path d="m3 17 6-6 4 4 8-8"/><path d="M15 7h6v6"/></symbol>
    <symbol id="pd-i-wave" viewBox="0 0 24 24"><path d="M3 12h3l3-7 4 14 3-7h5"/></symbol>
    <symbol id="pd-i-pie" viewBox="0 0 24 24"><path d="M21 12A9 9 0 1 1 12 3v9z"/><path d="M15 3.5A9 9 0 0 1 20.5 9H15z"/></symbol>
    <symbol id="pd-i-bulb" viewBox="0 0 24 24"><path d="M9 18h6M10 21h4"/><path d="M12 3a6 6 0 0 0-3.5 10.9c.6.5 1 1.2 1 2V17h5v-1.1c0-.8.4-1.5 1-2A6 6 0 0 0 12 3z"/></symbol>
    <symbol id="pd-i-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></symbol>
    <symbol id="pd-i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="pd-i-factory" viewBox="0 0 24 24"><path d="M3 21V9l6 4V9l6 4V5h6v16z"/><path d="M7 17h2M12 17h2M17 17h2"/></symbol>
</svg>

<div class="pd-head">
    <div class="pd-head-t"><svg class="pd-ic"><use href="#pd-i-cube"/></svg> Detalle del Producto</div>
    <a class="pd-x" href="{{ route('catalogo.publico.index') }}" data-pd-close aria-label="Cerrar"><svg class="pd-ic"><use href="#pd-i-x"/></svg></a>
</div>

<div class="pd-body">

{{-- ═══════════ PRODUCTO ═══════════ --}}
<section class="pd-card">
    <div class="pd-prod-top">
        <div class="pd-img"><svg class="pd-ic"><use href="#pd-i-cube"/></svg></div>
        <div class="pd-main">
            <h1 class="pd-name">{{ $product->nombre }}</h1>
            <div class="pd-chips">
                <span class="pd-chip">SKU: <b>{{ $product->sku ?: '—' }}</b></span>
                <span class="pd-chip">Categoría: <b>{{ $pdCategoria }}</b></span>
                <span class="pd-chip">Marca: <b>{{ $product->marca ?: 'Sin marca' }}</b></span>
                <span class="status {{ $stateClass }}">{{ $stateText }}</span>
            </div>
        </div>
    </div>
    <div class="pd-specs">
        <div class="pd-spec"><svg class="pd-ic"><use href="#pd-i-scale"/></svg><div><small>Peso unitario</small><strong>{{ $product->peso !== null ? number_format((float)$product->peso, 3).' g' : '—' }}</strong></div></div>
        <div class="pd-spec"><svg class="pd-ic"><use href="#pd-i-boxes"/></svg><div><small>Cantidad por caja</small><strong>{{ $product->cantidad_por_caja ? $product->cantidad_por_caja.' unidades' : '—' }}</strong></div></div>
        <div class="pd-spec"><svg class="pd-ic"><use href="#pd-i-barcode"/></svg><div><small>Código unidad</small><strong>{{ $product->barcode ?: '—' }}</strong></div></div>
        <div class="pd-spec"><svg class="pd-ic"><use href="#pd-i-barcode"/></svg><div><small>Código caja</small><strong>{{ $product->box_barcode ?: '—' }}</strong></div></div>
    </div>
</section>

{{-- ═══════════ STOCK ═══════════ --}}
<section class="pd-kpis">
    <div class="pd-kpi pd-k-blue"><div class="pd-kpi-ic"><svg class="pd-ic"><use href="#pd-i-cube"/></svg></div><div><h3>Stock físico</h3><div class="value">{{ number_format($stock,0) }}</div><div class="muted">unidades</div></div></div>
    <div class="pd-kpi pd-k-orange"><div class="pd-kpi-ic"><svg class="pd-ic"><use href="#pd-i-cart"/></svg></div><div><h3>Comprometido en pedidos</h3><div class="value">{{ number_format((float)$product->comprometido_catalogo,0) }}</div><div class="muted">Pendiente de despacho</div></div></div>
    <div class="pd-kpi pd-k-green"><div class="pd-kpi-ic"><svg class="pd-ic"><use href="#pd-i-layers"/></svg></div><div><h3>No comprometido</h3><div class="value">{{ number_format((float)$product->no_comprometido_catalogo,0) }}</div><div class="muted">Referencia comercial</div></div></div>
    <div class="pd-kpi pd-k-purple"><div class="pd-kpi-ic"><svg class="pd-ic"><use href="#pd-i-boxes"/></svg></div><div><h3>Equivalencia</h3>
        @if($pdCajas !== null)
            <div class="value">{{ number_format($pdCajas,0) }} <span style="font-size:14px;font-weight:700;">cajas</span></div><div class="muted">{{ $pdResto > 0 ? '+ '.$pdFmt($pdResto).' unidades' : 'exactas' }}</div>
        @else
            <div class="value">—</div><div class="muted">Sin unidades por caja</div>
        @endif
    </div></div>
</section>

{{-- ═══════════ PRODUCCIÓN / LOTES ═══════════ --}}
<div class="pd-two">
<section class="pd-card"><h2><svg class="pd-ic"><use href="#pd-i-cal"/></svg> Producción y Vencimiento</h2>
    <div class="pd-rows">
        <div class="pd-row"><span>Lote (ficha)</span><strong>{{ $product->lote ?: '—' }}</strong></div>
        <div class="pd-row"><span>Fecha de producción (ficha)</span><strong>{{ $product->fecha_produccion ? \Carbon\Carbon::parse($product->fecha_produccion)->format('d/m/Y') : '—' }}</strong></div>
        <div class="pd-row"><span>Fecha de vencimiento (ficha)</span><strong>{{ $pdVenc ? $pdVenc->format('d/m/Y') : '—' }}</strong></div>
        <div class="pd-row"><span>Tiempo restante</span><strong>@if($pdDias === null)—@elseif($pdDias < 0)Vencido hace {{ abs($pdDias) }} días@else{{ $pdDias }} días @endif</strong></div>
        <div class="pd-row"><span>Estado</span><strong>@if($pdDias === null)—@elseif($pdDias<0)<span class="status out">VENCIDO</span>@elseif($pdDias<=60)<span class="status low">PRÓXIMO A VENCER</span>@else<span class="status ok">✓ VIGENTE</span>@endif</strong></div>
        <div class="pd-row"><span>Stock mínimo</span><strong>{{ $product->stock_minimo ?? '—' }}</strong></div>
    </div>
</section>

<section class="pd-card"><h2><svg class="pd-ic"><use href="#pd-i-factory"/></svg> Lotes y vencimientos registrados en pedidos</h2><p class="muted" style="margin:-4px 0 8px;">Estos datos provienen de lotes/fechas guardados en detalles de pedidos; no representan necesariamente todas las existencias físicas por lote.</p>
@if($lots->isEmpty())<div class="muted">No hay lotes o fechas de vencimiento adicionales registrados en los detalles de pedidos.</div>@else<div class="tablewrap"><table><thead><tr><th>Lote</th><th>Fecha de vencimiento</th><th>Referencias en pedidos</th><th>Estado de fecha</th></tr></thead><tbody>@foreach($lots as $lot)@php $days=$lot->fecha_vencimiento?\Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($lot->fecha_vencimiento), false):null; @endphp<tr><td>{{ $lot->lote ?: '—' }}</td><td>{{ $lot->fecha_vencimiento ? \Carbon\Carbon::parse($lot->fecha_vencimiento)->format('d/m/Y') : '—' }}</td><td>{{ $lot->referencias }}</td><td>@if($days===null)—@elseif($days<0)<span class="status out">VENCIDO</span>@elseif($days<=60)<span class="status low">PRÓXIMO A VENCER · {{ (int) $days }} días</span>@else<span class="status ok">VIGENTE · {{ (int) $days }} días</span>@endif</td></tr>@endforeach</tbody></table></div>@endif
</section>
</div>

{{-- ═══════════ MOVIMIENTO + INDICADORES ═══════════ --}}
<div class="pd-two pd-two-b">
<section class="pd-card">
    <div class="pd-chart-head">
        <div>
            <h2><svg class="pd-ic"><use href="#pd-i-chart"/></svg> Movimiento del Producto</h2>
            <div class="muted">Unidades despachadas por órdenes creadas en cada mes</div>
        </div>
        <span class="pd-range">Últimos {{ $pdMeses->count() }} meses · <b>{{ number_format($totalMovement,0) }} und.</b></span>
    </div>

    <div class="pd-chart">
        <div class="pd-yaxis">
            @foreach($pdTicks as $tick)<span style="bottom:{{ ($tick / $pdTop) * 100 }}%">{{ $pdFmt($tick) }}</span>@endforeach
        </div>
        <div class="pd-plot">
            @foreach($pdTicks as $tick)@if($tick > 0)<div class="pd-grid" style="bottom:{{ ($tick / $pdTop) * 100 }}%"></div>@endif @endforeach
            <div class="pd-cols">
            @foreach($months as $month)<div class="barcol"><span class="barvalue">{{ number_format($month['cantidad'],0) }}</span><div class="bar" style="height:{{ max(2, ($month['cantidad'] / $pdTop) * ($pdAltoGrafico - 22)) }}px" title="{{ $month['label'] }}: {{ number_format($month['cantidad'],0) }} unidades"></div></div>@endforeach
            </div>
        </div>
    </div>
    <div class="pd-xaxis">
        @foreach($months as $month)@php $pdLab = explode(' ', \Illuminate\Support\Str::limit($month['label'], 8, ''), 2); @endphp<span>{{ $pdLab[0] }}@if(isset($pdLab[1]))<br>{{ $pdLab[1] }}@endif</span>@endforeach
    </div>
</section>

<section class="pd-card"><h2><svg class="pd-ic"><use href="#pd-i-chart"/></svg> Indicadores Comerciales</h2>
    <div class="pd-ind">
        <div class="pd-ind-row">
            <svg class="pd-ic {{ $variation === null ? '' : ($variation < 0 ? 'negative' : 'positive') }}"><use href="{{ $variation !== null && $variation < 0 ? '#pd-i-tdown' : '#pd-i-tup' }}"/></svg>
            <div class="pd-ind-lab">Variación vs. mes anterior@if($pdPrev !== null && $pdActual !== null)<small>({{ number_format($pdPrev,0) }} → {{ number_format($pdActual,0) }} und.)</small>@endif</div>
            <div class="pd-ind-val">@if($variation === null)<span style="font-size:13px;color:#64748b;">Sin base para comparar</span>@else<span class="{{ $variation < 0 ? 'negative' : 'positive' }}">{{ $variation > 0 ? '+' : '' }}{{ number_format($variation,1) }} %</span>@endif</div>
        </div>
        <div class="pd-ind-row">
            <svg class="pd-ic" style="color:#1769aa;"><use href="#pd-i-pie"/></svg>
            <div class="pd-ind-lab">Participación estimada en movimiento de {{ $pdCategoria }}<small>(mismo periodo)</small></div>
            <div class="pd-ind-val" style="color:#17385f;">@if($categoryShare === null)<span style="font-size:13px;color:#64748b;">Sin datos</span>@else{{ number_format($categoryShare,1) }} %@endif</div>
        </div>
        <div class="pd-ind-row">
            <svg class="pd-ic" style="color:#d98a0a;"><use href="#pd-i-wave"/></svg>
            <div class="pd-ind-lab">Tendencia</div>
            <div class="pd-ind-val"><span class="pd-trend {{ $pdTend[1] }}"><svg class="pd-ic"><use href="#{{ $pdTend[2] }}"/></svg> {{ $pdTend[0] }}</span></div>
        </div>
    </div>
</section>
</div>

{{-- ═══════════ RECOMENDACIÓN COMERCIAL ═══════════ --}}
<div class="callout"><div class="pd-bulb"><svg class="pd-ic"><use href="#pd-i-bulb"/></svg></div><div><strong>Recomendación comercial</strong><p>@if($variation !== null && $variation <= -15)El movimiento atribuido a órdenes creadas este mes bajó {{ number_format(abs($variation),1) }}% frente al mes anterior. Revisa demanda, disponibilidad y prioridades comerciales.@elseif($variation !== null && $variation >= 15)El movimiento atribuido a órdenes creadas este mes creció {{ number_format($variation,1) }}% frente al mes anterior. Verifica que el stock disponible acompañe la demanda.@else El movimiento se mantiene dentro de una variación menor al 15%, o todavía no hay suficiente información para evaluar una tendencia.@endif @if((float)$product->no_comprometido_catalogo > 0)Aún cuenta con {{ number_format((float)$product->no_comprometido_catalogo,0) }} unidades no comprometidas.@endif</p></div></div>

<p class="footer">Catálogo público de solo consulta. Los compromisos se muestran por separado y no modifican el stock físico. El gráfico atribuye las cantidades despachadas al mes de creación de la orden (fecha_pedido).</p>

</div>{{-- /pd-body --}}
</div>{{-- /pd-modal --}}

@if(!$pdEmbed)
</main></body></html>
@endif