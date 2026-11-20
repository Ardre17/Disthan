<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="theme-color" content="#123d72">
    <title>Armado del pedido | DISTAN</title>
    <style>
        :root{--blue:#1f6bff;--navy:#123d72;--ink:#172b4d;--muted:#718096;--line:#e5ebf3;--bg:#f3f6fb;--green:#168653;--green-bg:#e8f7ef;--amber:#b77909;--amber-bg:#fff5df;--red:#c93636;--red-bg:#fff0f0;--white:#fff}
        *{box-sizing:border-box}html,body{margin:0;max-width:100%;overflow-x:hidden;background:var(--bg);color:var(--ink);font:14px/1.45 Inter,system-ui,-apple-system,"Segoe UI",sans-serif}
        button,input{font:inherit}.nav{max-width:1180px;margin:auto;padding:10px 16px;display:flex;gap:8px}.nav a{flex:1;text-align:center;text-decoration:none;background:#fff;border:1px solid var(--line);border-radius:10px;padding:10px 6px;color:var(--navy);font-weight:750;font-size:12px}.nav a.active{background:var(--navy);color:#fff;border-color:var(--navy)}
        .hero{background:linear-gradient(125deg,#123d72,#1769aa);color:#fff;padding:18px max(16px,calc((100% - 1148px)/2)) 25px}.back{color:#dcecff;text-decoration:none;font-weight:700;font-size:13px}.hero h1{font-size:25px;line-height:1.15;margin:15px 0 5px}.hero-sub{color:#d9e9fb;font-size:13px}.wrap{max-width:1180px;margin:0 auto;padding:16px}.panel{background:#fff;border:1px solid var(--line);border-radius:15px;padding:16px;margin-bottom:14px;box-shadow:0 2px 8px #18324d08}.section-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin:0 0 13px}.section-head h2{font-size:16px;margin:0}.muted{color:var(--muted)}.small{font-size:12px}.meta-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}.label{display:block;font-size:10px;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);font-weight:800}.value{font-weight:750;margin-top:4px}.badge{display:inline-flex;align-items:center;gap:5px;border-radius:99px;padding:5px 9px;font-size:11px;font-weight:800;background:#eaf1fb;color:#245b91}.badge.green{background:var(--green-bg);color:var(--green)}.badge.amber{background:var(--amber-bg);color:var(--amber)}.badge.red{background:var(--red-bg);color:var(--red)}
        .kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}.kpi{border:1px solid var(--line);border-radius:12px;padding:12px;background:#fff}.kpi strong{display:block;font-size:23px;line-height:1.1}.kpi span{display:block;color:var(--muted);font-size:11px;margin-top:5px}.overall{margin-top:14px}.progress{height:9px;background:#e9eef5;border-radius:99px;overflow:hidden}.progress>i{display:block;height:100%;background:var(--blue);border-radius:99px}.progress-label{display:flex;justify-content:space-between;font-size:12px;font-weight:750;margin-bottom:6px}
        .scan-row{display:flex;gap:9px}.scan-input{flex:1;min-width:0;border:1.5px solid #8db4ff;border-radius:10px;padding:12px 13px;background:#fff;font-size:15px;outline:none}.scan-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px #1f6bff1c}.btn{border:0;border-radius:10px;padding:11px 14px;background:var(--blue);color:#fff;font-weight:800;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:7px}.btn.secondary{background:#edf3ff;color:#245b91;border:1px solid #d9e6ff}.btn.ghost{background:#fff;color:var(--ink);border:1px solid var(--line)}.btn:disabled{opacity:.5;cursor:not-allowed}.hint{font-size:11px;color:var(--muted);margin-top:7px}.search{width:100%;margin-top:10px;border:1px solid var(--line);border-radius:9px;padding:10px 12px}
        .product-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.product{border:1px solid var(--line);border-radius:13px;background:#fff;padding:14px;min-width:0;scroll-margin-top:10px}.product.complete{border-color:#bce5ce;background:linear-gradient(0deg,#f5fcf8,#fff 55%)}.product.partial{border-color:#f0d48f}.product.pending{border-color:#efc1c1}.product.selected{outline:2px solid var(--blue);outline-offset:1px}.product-top{display:flex;justify-content:space-between;gap:8px;align-items:flex-start}.product h3{font-size:14px;margin:0 0 4px;line-height:1.3}.code{font:11px ui-monospace,monospace;color:var(--muted)}.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:7px;margin:12px 0}.stat{background:#f4f7fb;border-radius:9px;padding:8px;text-align:center}.stat b{display:block;font-size:17px}.stat span{font-size:10px;color:var(--muted)}.stat.done b{color:var(--green)}.stat.left b{color:var(--amber)}.product .progress{margin:8px 0 12px}.data-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;margin:10px 0}.data-cell{font-size:11px;min-width:0}.data-cell b{display:block;font-size:12px;overflow-wrap:anywhere;margin-top:2px}.actions{display:flex;gap:7px;flex-wrap:wrap;margin-top:10px}.actions .btn{flex:1}.entry{display:flex;gap:8px;align-items:end;margin-top:12px;padding-top:12px;border-top:1px solid var(--line)}.entry label{flex:1;font-size:11px;color:var(--muted);font-weight:750}.entry input{display:block;width:100%;margin-top:5px;border:1px solid #d7e0ec;border-radius:9px;padding:11px;font-size:16px;font-weight:750;color:var(--ink)}.responsible{font-size:11px;color:var(--muted);margin-top:8px}.warning{border-radius:9px;padding:9px 10px;font-size:11px;line-height:1.4;margin-top:10px}.warning.amber{background:var(--amber-bg);color:#805809}.warning.red{background:var(--red-bg);color:#9e2929}.warning.green{background:var(--green-bg);color:#17663f}.history{margin-top:10px;border-top:1px dashed var(--line);padding-top:9px}.history summary{font-size:11px;font-weight:800;color:#315d8b;cursor:pointer}.history-list{margin-top:7px;display:grid;gap:6px}.history-row{display:flex;justify-content:space-between;gap:8px;font-size:11px;background:#f7f9fc;padding:7px 9px;border-radius:8px}.empty{padding:24px;text-align:center;color:var(--muted);border:1px dashed var(--line);border-radius:10px}.flash{padding:12px 14px;border-radius:11px;margin-bottom:12px;font-weight:650}.flash.ok{background:var(--green-bg);color:var(--green)}.flash.error{background:var(--red-bg);color:var(--red)}
        .alert-modal{display:none;position:fixed;inset:0;z-index:1300;background:#0b1d35c9;align-items:center;justify-content:center;padding:16px}
        .alert-modal.show{display:flex}.alert-dialog{width:min(100%,440px);background:#fff;border-radius:16px;padding:22px;text-align:center;box-shadow:0 20px 55px #0005}
        .alert-dialog h3{margin:0 0 9px;font-size:20px;color:#9e2929}.alert-dialog p{font-size:13px;line-height:1.5;color:#334155;margin:8px 0}
        .alert-dialog .alert-detail{background:#fff5df;border:1px solid #f0d48f;border-radius:10px;padding:11px;color:#805809;font-weight:750}
        .oct-images{display:flex;justify-content:center;align-items:center;gap:10px;flex-wrap:wrap;margin:18px 0}
        .oct-images img{height:105px;max-width:105px;object-fit:contain}.oct-label{background:#111;color:#fff;padding:12px;border-radius:6px;font-size:11px;font-weight:900}
        .modal{display:none;position:fixed;inset:0;z-index:1000;background:#0b1d35b8;align-items:center;justify-content:center;padding:16px}.modal.show{display:flex}.dialog{background:#fff;border-radius:16px;padding:16px;width:min(100%,440px);max-height:90vh;overflow:auto}.dialog-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}.dialog-head h3{margin:0;font-size:16px}.close{border:0;background:#edf2f8;border-radius:9px;width:34px;height:34px;font-size:19px;cursor:pointer}.dialog label{display:block;font-size:12px;font-weight:750;margin:10px 0 5px}.dialog input{width:100%;border:1px solid var(--line);border-radius:9px;padding:11px}.camera-view{width:100%;min-height:240px;border-radius:12px;overflow:hidden;background:#101827}.toast{position:fixed;left:50%;bottom:18px;transform:translate(-50%,20px);opacity:0;pointer-events:none;background:#172b4d;color:#fff;padding:11px 15px;border-radius:99px;font-size:12px;z-index:1200;transition:.2s}.toast.show{opacity:1;transform:translate(-50%,0)}
        @media(max-width:760px){.wrap{padding:11px}.hero{padding:16px 16px 22px}.meta-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.kpis{grid-template-columns:repeat(2,minmax(0,1fr))}.product-list{grid-template-columns:1fr}.panel{padding:13px}.hero h1{font-size:22px}.scan-row{flex-wrap:wrap}.scan-row .scan-input{flex-basis:100%}.scan-row .btn{flex:1}.nav{padding:8px}.nav a{font-size:11px}.entry{align-items:stretch}.entry .btn{min-width:104px}}
        @media(min-width:761px) and (max-width:980px){.product-list{grid-template-columns:1fr}.meta-grid{grid-template-columns:repeat(2,1fr)}}
    </style>
</head>
<body>
<nav class="nav">
    <a href="{{ route('mobile.home') }}">⌂ Inicio</a>
    <a href="{{ route('mobile.products.index') }}">▤ Productos</a>
    <a class="active" href="{{ route('mobile.orders.index') }}">▦ Pedidos</a>
</nav>
<header class="hero">
    <a class="back" href="{{ route('mobile.orders.index') }}">‹ Volver a pedidos</a>
    <h1>{{ $order->numero_orden ?: 'Pedido #'.$order->id }}</h1>
    <div class="hero-sub">{{ $order->client->razon_social ?? 'Cliente no disponible' }} · Armado de pedido</div>
</header>
<main class="wrap">
    @if(session('success'))<div class="flash ok">✓ {{ session('success') }}</div>@endif
    @if($errors->any())<div class="flash error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif

    @php
        $totalProductos = $order->details->count();
        $totalSolicitado = (float) $order->details->sum('cantidad_solicitada');
        $totalArmado = 0; $completos = 0; $parciales = 0; $pendientes = 0;
        foreach ($order->details as $d) {
            $a = (float) ($prepared[$d->id] ?? 0); $s = (float) ($d->cantidad_solicitada ?? 0); $totalArmado += $a;
            if ($s > 0 && $a >= $s) $completos++; elseif ($a > 0) $parciales++; else $pendientes++;
        }
        $porcentaje = $totalSolicitado > 0 ? min(100, ($totalArmado / $totalSolicitado) * 100) : 0;
    @endphp

    <section class="panel">
        <div class="section-head"><h2>Información del pedido</h2><span class="badge">{{ str_replace('_',' ', $order->estado ?? 'SIN ESTADO') }}</span></div>
        <div class="meta-grid">
            <div><span class="label">Tipo de pedido</span><div class="value">{{ str_replace('_',' ', $order->tipo_orden ?? '—') }}</div></div>
            <div><span class="label">Fecha de pedido</span><div class="value">{{ $order->fecha_pedido ? \Carbon\Carbon::parse($order->fecha_pedido)->format('d/m/Y') : '—' }}</div></div>
            <div><span class="label">Fecha de entrega</span><div class="value">{{ $order->fecha_entrega ? \Carbon\Carbon::parse($order->fecha_entrega)->format('d/m/Y') : '—' }}</div></div>
            <div><span class="label">Referencia interna</span><div class="value">{{ $order->order_interna ?: '—' }}</div></div>
        </div>
        @if($order->observaciones)<div class="warning amber"><b>Observaciones:</b> {{ $order->observaciones }}</div>@endif
    </section>

    <section class="panel">
        <div class="section-head"><h2>Resumen de armado</h2><span class="badge {{ $porcentaje >= 100 ? 'green' : ($porcentaje > 0 ? 'amber' : 'red') }}">{{ number_format($porcentaje,1) }} %</span></div>
        <div class="kpis">
            <div class="kpi"><strong>{{ $totalProductos }}</strong><span>Productos en pedido</span></div>
            <div class="kpi"><strong>{{ $completos }}</strong><span>Armado completo</span></div>
            <div class="kpi"><strong>{{ $parciales }}</strong><span>Armado parcial</span></div>
            <div class="kpi"><strong>{{ $pendientes }}</strong><span>Pendientes de iniciar</span></div>
        </div>
        <div class="overall"><div class="progress-label"><span>Unidades armadas</span><span>{{ rtrim(rtrim(number_format($totalArmado,3,'.',''), '0'), '.') }} / {{ rtrim(rtrim(number_format($totalSolicitado,3,'.',''), '0'), '.') }}</span></div><div class="progress"><i style="width:{{ $porcentaje }}%"></i></div></div>
    </section>

    <section class="panel" id="panelEscaner">
        <div class="section-head"><h2>Buscar producto</h2><span class="badge">Escáner / manual</span></div>
        <div class="scan-row">
            <input id="scannerInput" class="scan-input" type="text" autocomplete="off" placeholder="Escanea SKU, código de barras o código de caja…">
            <button type="button" class="btn" id="btnBuscar">Buscar</button>
            <button type="button" class="btn secondary" id="btnCamara">▣ Cámara</button>
        </div>
        <div class="hint">El lector USB/Bluetooth funciona como teclado: escanea el código y presiona Enter. También puedes buscar por nombre.</div>
        <input id="filtroProducto" class="search" type="search" placeholder="Filtrar productos por nombre o código…">
        <div id="scanFeedback" class="hint" aria-live="polite"></div>
    </section>

    <section class="panel">
        <div class="section-head"><h2>Productos del pedido</h2><span class="small muted">{{ $totalProductos }} registros</span></div>
        <div class="product-list" id="productList">
            @forelse($order->details as $detail)
                @php
                    $armado = (float) ($prepared[$detail->id] ?? 0);
                    $solicitado = (float) ($detail->cantidad_solicitada ?? 0);
                    $faltante = max(0, $solicitado - $armado);
                    $stockActual = (float) ($detail->product?->stock ?? 0);
                    $stockRestanteParaArmar = max(0, $stockActual - $armado);
                    $sinStock = $faltante > 0 && $stockRestanteParaArmar <= 0;
                    $stockInsuficiente = $faltante > 0 && $stockRestanteParaArmar > 0 && $stockRestanteParaArmar < $faltante;
                    $maximoArmable = min($faltante, $stockRestanteParaArmar);
                    $pct = $solicitado > 0 ? min(100, ($armado / $solicitado) * 100) : 0;
                    $estadoArmado = $solicitado > 0 && $armado >= $solicitado ? 'complete' : ($armado > 0 ? 'partial' : 'pending');
                    $meta = $preparationMeta[$detail->id] ?? null;
                    $lote = $detail->lote ?: ($detail->product->lote ?? '');
                    $vence = $detail->fecha_vencimiento ?: ($detail->product->fecha_vencimiento ?? null);
                    $produccion = $detail->fecha_produccion ?: ($detail->product->fecha_produccion ?? null);
                    $ultimoUsuario = 'Sin registros';
                    if ($meta && !empty($meta->updated_by)) {
                        $ultimoUsuario = is_numeric($meta->updated_by)
                            ? ($userNames[$meta->updated_by] ?? ('Usuario #' . $meta->updated_by))
                            : $meta->updated_by;
                    }
                @endphp
                <article class="product {{ $estadoArmado }}" id="detail-{{ $detail->id }}"
                    data-detail-id="{{ $detail->id }}"
                    data-name="{{ mb_strtolower($detail->product->nombre ?? '') }}"
                    data-sku="{{ $detail->product->sku ?? '' }}"
                    data-barcode="{{ $detail->product->barcode ?? '' }}"
                    data-box-barcode="{{ $detail->product->box_barcode ?? '' }}"
                    data-stock="{{ $stockActual }}"
                    data-pending="{{ $faltante }}"
                    data-warnings="{{ $detail->product->advertencias ?? '' }}">
                    <div class="product-top">
                        <div><h3>{{ $detail->product->nombre ?? 'Producto no disponible' }}</h3><div class="code">SKU: {{ $detail->product->sku ?? '—' }} · ID detalle: {{ $detail->id }}</div></div>
                        @if($estadoArmado==='complete')<span class="badge green">Completo</span>@elseif($estadoArmado==='partial')<span class="badge amber">Parcial</span>@else<span class="badge red">Pendiente</span>@endif
                    </div>
                    <div class="stats">
                        <div class="stat"><b>{{ rtrim(rtrim(number_format($solicitado,3,'.',''), '0'), '.') }}</b><span>Solicitado</span></div>
                        <div class="stat done"><b>{{ rtrim(rtrim(number_format($armado,3,'.',''), '0'), '.') }}</b><span>Armado</span></div>
                        <div class="stat left"><b>{{ rtrim(rtrim(number_format($faltante,3,'.',''), '0'), '.') }}</b><span>Falta</span></div>
                    </div>
                    <div class="progress"><i style="width:{{ $pct }}%;background:{{ $pct>=100 ? 'var(--green)' : ($pct>0 ? '#d69a25' : '#d04b4b') }}"></i></div>
                    <div class="data-grid">
                        <div class="data-cell"><span class="label">Stock actual</span><b>{{ rtrim(rtrim(number_format($stockActual,3,'.',''), '0'), '.') }}</b></div>
                        <div class="data-cell"><span class="label">Lote</span><b>{{ $lote ?: '—' }}</b></div>
                        <div class="data-cell"><span class="label">Fecha de producción</span><b>{{ $produccion ? \Carbon\Carbon::parse($produccion)->format('d/m/Y') : '—' }}</b></div>
                        <div class="data-cell"><span class="label">Fecha de vencimiento</span><b>{{ $vence ? \Carbon\Carbon::parse($vence)->format('d/m/Y') : '—' }}</b></div>
                        <div class="data-cell"><span class="label">Último responsable</span><b>{{ $ultimoUsuario }}</b></div>
                    </div>
                    @if($faltante > 0)
                        @if($sinStock)
                            <div class="warning red">⛔ No queda stock disponible para continuar el armado. Consulta con el encargado si existe producto disponible o si corresponde producir.</div>
                        @elseif($stockInsuficiente)
                            <div class="warning amber">⚠ Stock insuficiente: faltan {{ rtrim(rtrim(number_format($faltante,3,'.',''), '0'), '.') }} unidades por armar, pero el stock disponible para continuar es {{ rtrim(rtrim(number_format($stockRestanteParaArmar,3,'.',''), '0'), '.') }}. Puedes registrar un avance parcial hasta el stock disponible.</div>
                        @elseif($armado > 0)
                            <div class="warning amber">Armado parcial: faltan {{ rtrim(rtrim(number_format($faltante,3,'.',''), '0'), '.') }} unidades. Puedes continuar registrando el avance.</div>
                        @else
                            <div class="warning red">Pendiente de armado. Aún no se han registrado unidades.</div>
                        @endif
                        @if(!$sinStock)
                            <form class="entry" method="POST" action="{{ route('mobile.orders.prepare', [$order,$detail]) }}">
                                @csrf
                                <label>Cantidad armada ahora<input type="number" name="cantidad_armada" min="0.001" max="{{ $maximoArmable }}" step="0.001" required inputmode="decimal" {{ $stockActual <= 0 ? "disabled" : "" }} placeholder="Máximo {{ $maximoArmable }}"></label>
                                <button class="btn" type="submit">Guardar avance</button>
                            </form>
                        @endif
                    @else
                        <div class="warning green">✓ Cantidad solicitada completamente armada.</div>
                    @endif
                    <div class="actions"><button class="btn ghost" type="button" onclick="abrirLote({{ $detail->id }}, @js($lote), @js($vence ? \Carbon\Carbon::parse($vence)->format('Y-m-d') : ''))">Editar lote / vencimiento</button></div>
                    @php($logs = $preparationLogs[$detail->id] ?? collect())
                    @if($logs->isNotEmpty())
                        <details class="history"><summary>Historial de armado ({{ $logs->count() }} registros)</summary>
                            <div class="history-list">
                                @foreach($logs as $log)
                                    <div class="history-row"><span><b>+{{ rtrim(rtrim(number_format((float)$log->quantity,3,'.',''), '0'), '.') }}</b> unidades · {{ $log->user_name ?: 'Usuario no disponible' }}</span><span>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</span></div>
                                @endforeach
                            </div>
                        </details>
                    @elseif($meta)
                        <div class="responsible">Acumulado existente antes de activar el historial · actualizado {{ $meta->updated_at ? \Carbon\Carbon::parse($meta->updated_at)->format('d/m/Y H:i') : '—' }}</div>
                    @endif
                </article>
            @empty
                <div class="empty">Este pedido todavía no tiene productos registrados.</div>
            @endforelse
        </div>
    </section>

    @if(strtoupper(trim($order->tipo_orden ?? ''))==='ENCOMIENDA')
        <section class="panel"><div class="section-head"><h2>Bultos</h2><span class="badge">Encomienda</span></div>
            @forelse($order->bultos as $bulto)<div class="product"><h3>{{ $bulto->nombre ?? 'Bulto' }}</h3><div class="small muted">Peso total: {{ $bulto->peso_total ?? '—' }} · Productos incluidos: {{ $bulto->detalles->count() }}</div></div>@empty<div class="empty">No hay bultos registrados.</div>@endforelse
        </section>
    @endif
    @if(strtoupper(trim($order->tipo_orden ?? ''))==='EXPORTACION')
        <section class="panel"><div class="section-head"><h2>Paletas</h2><span class="badge">Exportación</span></div>
            @forelse($order->pallets as $pallet)<div class="product"><h3>{{ $pallet->nombre ?? ('Paleta #'.$pallet->id) }}</h3><div class="small muted">Detalles registrados: {{ $pallet->detalles->count() }}</div></div>@empty<div class="empty">No hay paletas registradas.</div>@endforelse
        </section>
    @endif
    <div class="small muted" style="text-align:center;padding:5px 0 18px">El armado se registra por separado. No modifica cantidades despachadas ni descuenta stock.</div>
</main>

<div class="modal" id="modalLote"><div class="dialog"><div class="dialog-head"><h3>Editar lote y vencimiento</h3><button class="close" type="button" onclick="cerrarModal('modalLote')">×</button></div>
    <form method="POST" id="formLote">@csrf @method('PUT')
        <label for="loteInput">Número de lote</label><input id="loteInput" name="lote" maxlength="100" placeholder="Ej. L-2026-045">
        <label for="venceInput">Fecha de vencimiento</label><input id="venceInput" type="date" name="fecha_vencimiento">
        <p class="hint">La fecha de producción se muestra desde la ficha del producto. Esta acción actualiza el lote y vencimiento del detalle del pedido.</p>
        <button class="btn" style="width:100%;margin-top:12px" type="submit">Guardar cambios</button>
    </form>
</div></div>
<div class="modal" id="modalCamara"><div class="dialog"><div class="dialog-head"><h3>Escáner de cámara</h3><button class="close" type="button" onclick="cerrarCamara()">×</button></div><div id="cameraReader" class="camera-view"></div><div class="hint">Centra el código de barras dentro del recuadro. Requiere permiso de cámara y conexión HTTPS.</div></div></div>
<div class="alert-modal" id="modalProduccion" role="alertdialog" aria-modal="true">
    <div class="alert-dialog">
        <h3>⚠ STOCK INSUFICIENTE</h3>
        <p id="produccionProducto" style="font-weight:850;color:#172b4d"></p>
        <p id="produccionDetalle"></p>
        <p class="alert-detail">Consultar con el encargado si existe materia prima disponible para solicitar producción y completar el pedido.</p>
        <button class="btn" type="button" onclick="cerrarAlerta('modalProduccion')">Entendido</button>
    </div>
</div>
<div class="alert-modal" id="modalOctogonos" role="alertdialog" aria-modal="true">
    <div class="alert-dialog">
        <h3>⚠ Verificar etiqueta</h3>
        <p id="octProducto" style="font-weight:850;color:#172b4d"></p>
        <div class="oct-images" id="octImagenes"></div>
        <p>Verifique que el producto tenga correctamente los octógonos nutricionales antes de continuar.</p>
        <button class="btn" type="button" onclick="cerrarAlerta('modalOctogonos')">✔ Entendido</button>
    </div>
</div>
<div id="toast" class="toast"></div>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const cards = [...document.querySelectorAll('.product[data-detail-id]')];
    const scannerInput = document.getElementById('scannerInput');
    const feedback = document.getElementById('scanFeedback');
    let cameraScanner = null;
    function toast(msg){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');clearTimeout(t._timer);t._timer=setTimeout(()=>t.classList.remove('show'),2600)}
    function findCard(code){const v=String(code||'').trim().toLowerCase();return cards.find(c=>[c.dataset.sku,c.dataset.barcode,c.dataset.boxBarcode].some(x=>String(x||'').trim().toLowerCase()===v))}
    async function focusCard(card){
        if(!card)return false;
        cards.forEach(c=>c.classList.remove('selected'));
        card.classList.add('selected');
        card.scrollIntoView({behavior:'smooth',block:'center'});
        const nombre=card.querySelector('h3')?.textContent || 'Producto';
        const stock=Math.max(0,parseFloat(card.dataset.stock)||0);
        const pendiente=Math.max(0,parseFloat(card.dataset.pending)||0);
        const faltante=Math.max(0,pendiente-stock);
        if(pendiente>0 && stock<pendiente){
            document.getElementById('produccionProducto').textContent=nombre;
            document.getElementById('produccionDetalle').textContent='Pendiente por armar: '+pendiente+' · Stock disponible: '+stock+' · Faltante: '+faltante;
            await mostrarAlerta('modalProduccion');
        }
        const tokens=String(card.dataset.warnings||'').normalize('NFD').replace(/[\u0300-\u036f]/g,'').toUpperCase().split(',').map(x=>x.trim()).filter(Boolean);
        const catalogo={
            AZUCAR:['Alto en azúcar','https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png'],
            SODIO:['Alto en sodio','https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png'],
            GRASAS:['Alto en grasas','https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png']
        };
        const box=document.getElementById('octImagenes');
        box.innerHTML='';
        tokens.forEach(token=>{
            const info=catalogo[token];
            if(!info)return;
            const img=document.createElement('img');img.src=info[1];img.alt=info[0];img.onerror=()=>{img.replaceWith(Object.assign(document.createElement('span'),{className:'oct-label',textContent:info[0].toUpperCase()}))};box.appendChild(img);
        });
        if(box.children.length){
            document.getElementById('octProducto').textContent=nombre;
            await mostrarAlerta('modalOctogonos');
        }
        const qty=card.querySelector('input[name="cantidad_armada"]');
        if(qty && !qty.disabled){setTimeout(()=>{qty.focus();qty.select()},150);}
        else if(pendiente<=0){toast('Este producto ya tiene el armado completo.');}
        else if(stock<=0){toast('⛔ Sin stock: casilla de armado bloqueada.');}
        return true;
    }
    const alertResolvers={};
    function mostrarAlerta(id){return new Promise(resolve=>{const modal=document.getElementById(id);alertResolvers[id]=resolve;modal.classList.add('show');const btn=modal.querySelector('button');btn.onclick=()=>cerrarAlerta(id);});}
    function cerrarAlerta(id){const modal=document.getElementById(id);if(modal)modal.classList.remove('show');if(alertResolvers[id]){const done=alertResolvers[id];delete alertResolvers[id];done();}}

    function buscarCodigo(){const code=scannerInput.value.trim();if(!code)return;const card=findCard(code);if(card){feedback.textContent='Producto encontrado: '+card.querySelector('h3').textContent;focusCard(card);scannerInput.value='';}else{feedback.textContent='No se encontró un producto con el código '+code;toast('Código no encontrado en este pedido.')}}
    document.getElementById('btnBuscar').addEventListener('click',buscarCodigo);
    cards.forEach(card=>card.addEventListener('click',e=>{if(e.target.closest('button,a,input,form,summary'))return;focusCard(card)}));
    scannerInput.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();buscarCodigo()}});
    document.getElementById('filtroProducto').addEventListener('input',function(){const q=this.value.trim().toLowerCase();cards.forEach(c=>{c.style.display=(!q||c.dataset.name.includes(q)||[c.dataset.sku,c.dataset.barcode,c.dataset.boxBarcode].some(x=>String(x||'').toLowerCase().includes(q)))?'':'none'})});
    function abrirLote(id,lote,vence){document.getElementById('formLote').action='/order-details/'+id+'/lote';document.getElementById('loteInput').value=lote||'';document.getElementById('venceInput').value=vence||'';document.getElementById('modalLote').classList.add('show')}
    function cerrarModal(id){document.getElementById(id).classList.remove('show')}
    async function abrirCamara(){if(typeof Html5Qrcode==='undefined'){toast('No se pudo cargar el módulo de cámara.');return}document.getElementById('modalCamara').classList.add('show');try{cameraScanner=new Html5Qrcode('cameraReader');await cameraScanner.start({facingMode:'environment'},{fps:10,qrbox:{width:260,height:130}},decoded=>{const card=findCard(decoded);if(card){focusCard(card);feedback.textContent='Código leído: '+decoded;cerrarCamara();toast('Producto identificado');}else{feedback.textContent='Código leído, pero no pertenece a este pedido: '+decoded;}},()=>{});}catch(e){toast('No se pudo iniciar la cámara. Verifica permisos y HTTPS.');cerrarCamara();}}
    async function cerrarCamara(){if(cameraScanner){try{await cameraScanner.stop();await cameraScanner.clear()}catch(e){}cameraScanner=null}cerrarModal('modalCamara')}
    document.getElementById('btnCamara').addEventListener('click',abrirCamara);
    document.querySelectorAll('.modal').forEach(m=>m.addEventListener('click',e=>{if(e.target===m){if(m.id==='modalCamara')cerrarCamara();else m.classList.remove('show')}}));
    document.addEventListener('keydown',e=>{if(e.key==='Escape'){cerrarModal('modalLote');cerrarAlerta('modalProduccion');cerrarAlerta('modalOctogonos');cerrarCamara()}});
    document.querySelectorAll('.entry').forEach(form=>form.addEventListener('submit',e=>{const btn=form.querySelector('button');btn.disabled=true;btn.textContent='Guardando…'}));
</script>
</body>
</html>
