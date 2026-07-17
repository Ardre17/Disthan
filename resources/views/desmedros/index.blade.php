@extends('layouts.app')

@section('title', 'Desmedros')


@section('content')
<style>
    :root {
        --dsm-navy: #1B2A4A;
        --dsm-navy-light: #24365c;
        --dsm-bg: #F4F6F9;
        --dsm-card: #FFFFFF;
        --dsm-border: #E3E7EE;
        --dsm-red: #C0392B;
        --dsm-red-bg: #FDEDEB;
        --dsm-amber: #D97706;
        --dsm-amber-bg: #FEF3E2;
        --dsm-green: #15803D;
        --dsm-green-bg: #EAF7EF;
        --dsm-blue: #2563EB;
        --dsm-blue-bg: #EBF1FE;
        --dsm-ink: #1F2937;
        --dsm-muted: #6B7280;
        --dsm-mono: 'JetBrains Mono', 'Roboto Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
    }

    .dsm-wrap { background: var(--dsm-bg); min-height: 100%; padding: 24px; }

    .dsm-breadcrumb { font-size: 12px; color: var(--dsm-muted); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
    .dsm-breadcrumb a { color: var(--dsm-muted); text-decoration: none; }
    .dsm-breadcrumb a:hover { color: var(--dsm-navy); }
    .dsm-breadcrumb .sep { opacity: .5; }
    .dsm-breadcrumb .current { color: var(--dsm-ink); font-weight: 600; }

    .dsm-header {
        display: flex; align-items: center; justify-content: space-between;
        background: var(--dsm-navy); color: #fff; border-radius: 12px;
        padding: 18px 24px; margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(27,42,74,.18);
    }
    .dsm-header h1 { font-size: 19px; font-weight: 700; margin: 0; letter-spacing: .2px; }
    .dsm-header p { margin: 2px 0 0; font-size: 12.5px; color: #B9C4D8; }
    .dsm-header .dsm-badge-count {
        font-family: var(--dsm-mono); background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.18); border-radius: 8px;
        padding: 6px 12px; font-size: 12px; color: #E7ECF5;
    }

    .dsm-alert {
        border-radius: 10px; padding: 13px 16px; font-size: 13px; margin-bottom: 16px;
        display: flex; align-items: flex-start; gap: 10px; border: 1px solid transparent;
    }
    .dsm-alert .ico { font-size: 15px; line-height: 1.2; }
    .dsm-alert strong { font-weight: 700; }
    .dsm-alert.success { background: var(--dsm-green-bg); color: #0F5C31; border-color: #BFE6CD; }
    .dsm-alert.danger { background: var(--dsm-red-bg); color: #8A2A20; border-color: #F3C6C0; }
    .dsm-alert ul { margin: 4px 0 0; padding-left: 16px; }

    .dsm-kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 18px; }
    @media (max-width: 980px) { .dsm-kpis { grid-template-columns: repeat(2, 1fr); } }
    .dsm-kpi-card {
        background: var(--dsm-card); border: 1px solid var(--dsm-border); border-radius: 12px;
        padding: 16px 18px; border-left: 3px solid var(--dsm-navy);
        box-shadow: 0 1px 3px rgba(16,24,40,.05);
    }
    .dsm-kpi-card.red { border-left-color: var(--dsm-red); }
    .dsm-kpi-card.amber { border-left-color: var(--dsm-amber); }
    .dsm-kpi-card.green { border-left-color: var(--dsm-green); }
    .dsm-kpi-card .k-label { font-size: 10.5px; text-transform: uppercase; letter-spacing: .6px; color: var(--dsm-muted); }
    .dsm-kpi-card .k-value { font-family: var(--dsm-mono); font-size: 24px; font-weight: 700; color: var(--dsm-ink); margin-top: 6px; }
    .dsm-kpi-card .k-sub { font-size: 11px; color: var(--dsm-muted); margin-top: 3px; }
    .dsm-kpi-card .k-sub b { color: var(--dsm-red); font-family: var(--dsm-mono); }

    .dsm-charts { display: grid; grid-template-columns: 1.4fr 1fr; gap: 14px; margin-bottom: 20px; }
    @media (max-width: 980px) { .dsm-charts { grid-template-columns: 1fr; } }
    .dsm-chart-card {
        background: var(--dsm-card); border: 1px solid var(--dsm-border); border-radius: 14px;
        padding: 18px 20px; box-shadow: 0 1px 3px rgba(16,24,40,.06);
    }
    .dsm-chart-card h3 { font-size: 13px; font-weight: 700; color: var(--dsm-ink); margin: 0 0 2px; }
    .dsm-chart-card p.hint { font-size: 11.5px; color: var(--dsm-muted); margin: 0 0 14px; }
    .dsm-chart-card canvas { max-height: 220px; }

    .dsm-top-list { display: flex; flex-direction: column; gap: 10px; }
    .dsm-top-item { display: flex; align-items: center; gap: 10px; }
    .dsm-top-item .rank {
        width: 20px; height: 20px; border-radius: 6px; background: var(--dsm-red-bg); color: var(--dsm-red);
        font-family: var(--dsm-mono); font-size: 10.5px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .dsm-top-item .info { flex: 1; min-width: 0; }
    .dsm-top-item .nombre { font-size: 12.5px; font-weight: 600; color: var(--dsm-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .dsm-top-item .barra-bg { height: 6px; background: #F1F3F7; border-radius: 4px; margin-top: 4px; overflow: hidden; }
    .dsm-top-item .barra-fill { height: 100%; background: var(--dsm-red); border-radius: 4px; }
    .dsm-top-item .cant { font-family: var(--dsm-mono); font-size: 12px; font-weight: 700; color: var(--dsm-red); white-space: nowrap; }
    .dsm-top-empty { text-align: center; color: var(--dsm-muted); font-size: 12px; padding: 30px 0; }

    .dsm-grid { display: grid; grid-template-columns: 420px 1fr; gap: 20px; align-items: start; }
    @media (max-width: 980px) { .dsm-grid { grid-template-columns: 1fr; } }

    .dsm-ticket {
        background: var(--dsm-card); border-radius: 14px; border: 1px solid var(--dsm-border);
        box-shadow: 0 1px 3px rgba(16,24,40,.06); overflow: hidden; position: relative;
    }
    .dsm-ticket-head {
        padding: 16px 20px; border-bottom: 1px dashed var(--dsm-border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .dsm-ticket-head .id {
        font-family: var(--dsm-mono); font-size: 13px; font-weight: 700; color: var(--dsm-navy);
        letter-spacing: .5px;
    }
    .dsm-ticket-head .id small { display: block; font-family: inherit; font-weight: 500; color: var(--dsm-muted); font-size: 10.5px; letter-spacing: 1px; text-transform: uppercase; }
    .dsm-state {
        font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px;
        padding: 4px 10px; border-radius: 100px;
    }
    .dsm-state.borrador { background: var(--dsm-amber-bg); color: var(--dsm-amber); }
    .dsm-state.registrado { background: var(--dsm-green-bg); color: var(--dsm-green); }

    .dsm-hint-box {
        margin: 14px 20px 0; padding: 10px 12px; background: var(--dsm-blue-bg); border-radius: 10px;
        font-size: 11.5px; color: #1E3A73; display: flex; gap: 8px; align-items: flex-start; line-height: 1.4;
    }
    .dsm-hint-box .ico { flex-shrink: 0; }

    .dsm-search { padding: 14px 20px 8px; position: relative; }
    .dsm-search input {
        width: 100%; border: 1.5px solid var(--dsm-border); border-radius: 10px;
        padding: 11px 14px; font-size: 13.5px; color: var(--dsm-ink); outline: none;
        transition: border-color .15s;
    }
    .dsm-search input:focus { border-color: var(--dsm-navy); }
    .dsm-suggest {
        position: absolute; left: 20px; right: 20px; top: 60px; z-index: 20;
        background: #fff; border: 1px solid var(--dsm-border); border-radius: 10px;
        box-shadow: 0 8px 24px rgba(16,24,40,.12); max-height: 260px; overflow-y: auto;
    }
    .dsm-suggest button {
        width: 100%; text-align: left; padding: 10px 14px; background: none; border: none;
        border-bottom: 1px solid #F1F3F7; cursor: pointer; display: flex; justify-content: space-between; gap: 8px;
    }
    .dsm-suggest button:last-child { border-bottom: none; }
    .dsm-suggest button:hover { background: #F7F9FC; }
    .dsm-suggest .nombre { font-size: 13px; color: var(--dsm-ink); font-weight: 600; }
    .dsm-suggest .codigo { font-family: var(--dsm-mono); font-size: 11px; color: var(--dsm-muted); }
    .dsm-suggest .stock { font-family: var(--dsm-mono); font-size: 11.5px; color: var(--dsm-muted); white-space: nowrap; }
    .dsm-suggest-empty { padding: 14px; text-align: center; font-size: 12px; color: var(--dsm-muted); }

    .dsm-qty-row { display: flex; gap: 10px; padding: 10px 20px 4px; }
    .dsm-qty-row input {
        width: 110px; border: 1.5px solid var(--dsm-border); border-radius: 10px;
        padding: 10px 12px; font-family: var(--dsm-mono); font-size: 14px; text-align: right;
    }
    .dsm-qty-row button {
        flex: 1; background: var(--dsm-navy); color: #fff; border: none; border-radius: 10px;
        font-size: 13px; font-weight: 600; cursor: pointer; transition: background .15s;
    }
    .dsm-qty-row button:hover { background: var(--dsm-navy-light); }
    .dsm-qty-row button:disabled { opacity: .4; cursor: not-allowed; }
    .dsm-selected {
        margin: 8px 20px 0; padding: 10px 12px; background: #F7F9FC; border-radius: 10px;
        font-size: 12.5px; color: var(--dsm-ink); display: flex; justify-content: space-between;
    }
    .dsm-selected b { color: var(--dsm-navy); }
    .dsm-selected.low-stock { background: var(--dsm-red-bg); color: #8A2A20; }
    .dsm-inline-error {
        margin: 8px 20px 0; padding: 9px 12px; background: var(--dsm-red-bg); color: #8A2A20;
        border-radius: 8px; font-size: 12px;
    }

    .dsm-detalle-list { padding: 14px 20px 4px; max-height: 300px; overflow-y: auto; }
    .dsm-detalle-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #F1F3F7;
        animation: dsmSlideIn .18s ease-out;
    }
    @keyframes dsmSlideIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }
    .dsm-detalle-item .nombre { font-size: 13px; color: var(--dsm-ink); font-weight: 600; }
    .dsm-detalle-item .codigo { font-family: var(--dsm-mono); font-size: 10.5px; color: var(--dsm-muted); }
    .dsm-detalle-item .cant { font-family: var(--dsm-mono); font-size: 13.5px; color: var(--dsm-red); font-weight: 700; }
    .dsm-detalle-item .quitar {
        background: none; border: none; color: #9AA4B2; cursor: pointer; font-size: 15px; padding: 2px 6px;
        margin-left: 6px; line-height: 1;
    }
    .dsm-detalle-item .quitar:hover { color: var(--dsm-red); }
    .dsm-empty { padding: 30px 20px; text-align: center; color: var(--dsm-muted); font-size: 12.5px; }

    .dsm-ticket-foot {
        padding: 16px 20px 20px; border-top: 1px dashed var(--dsm-border);
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }
    .dsm-total { font-size: 12px; color: var(--dsm-muted); }
    .dsm-total b { font-family: var(--dsm-mono); font-size: 17px; color: var(--dsm-ink); display: block; }
    .dsm-btn-registrar {
        background: var(--dsm-red); color: #fff; border: none; border-radius: 10px;
        padding: 12px 20px; font-size: 13px; font-weight: 700; cursor: pointer;
        letter-spacing: .3px; transition: background .15s, transform .1s;
        box-shadow: 0 2px 6px rgba(192,57,43,.28);
    }
    .dsm-btn-registrar:hover { background: #A93226; }
    .dsm-btn-registrar:active { transform: scale(.98); }
    .dsm-btn-registrar:disabled { background: #D1D5DB; cursor: not-allowed; box-shadow: none; }

    .dsm-ticket::before, .dsm-ticket::after {
        content: ''; position: absolute; width: 18px; height: 18px; background: var(--dsm-bg);
        border-radius: 50%; top: 0; margin-top: -9px;
    }
    .dsm-ticket::before { left: -9px; }
    .dsm-ticket::after { right: -9px; }

    .dsm-list-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .dsm-list-head h2 { font-size: 14.5px; font-weight: 700; color: var(--dsm-ink); margin: 0; }
    .dsm-list-head span { font-size: 12px; color: var(--dsm-muted); }

    .dsm-table-card {
        background: var(--dsm-card); border: 1px solid var(--dsm-border); border-radius: 14px;
        overflow: hidden; box-shadow: 0 1px 3px rgba(16,24,40,.06);
    }
    table.dsm-table { width: 100%; border-collapse: collapse; }
    table.dsm-table thead th {
        text-align: left; font-size: 10.5px; text-transform: uppercase; letter-spacing: .6px;
        color: var(--dsm-muted); background: #FAFBFD; padding: 12px 18px; border-bottom: 1px solid var(--dsm-border);
    }
    table.dsm-table tbody td { padding: 13px 18px; font-size: 13px; color: var(--dsm-ink); border-bottom: 1px solid #F1F3F7; }
    table.dsm-table tbody tr:last-child td { border-bottom: none; }
    table.dsm-table tbody tr:hover { background: #FAFBFD; cursor: pointer; }
    .dsm-code-cell { font-family: var(--dsm-mono); font-weight: 700; color: var(--dsm-navy); }
    .dsm-qty-cell { font-family: var(--dsm-mono); color: var(--dsm-red); font-weight: 700; }
    .dsm-tag-registrado {
        display: inline-flex; align-items: center; gap: 5px; font-size: 10.5px; font-weight: 700;
        color: var(--dsm-green); background: var(--dsm-green-bg); padding: 3px 9px; border-radius: 100px;
        text-transform: uppercase; letter-spacing: .5px;
    }
    .dsm-list-empty { padding: 50px 20px; text-align: center; color: var(--dsm-muted); font-size: 13px; }
    [x-cloak] { display: none !important; }
</style>
<div class="dsm-wrap" x-data="desmedroBuilder({
        desmedroId: {{ $borrador?->id ?? 'null' }},
        codigo: @js($borrador?->codigo),
        detalles: @js($borrador?->detalles->map(fn($d) => [
            'id' => $d->id,
            'producto_id' => $d->producto_id,
            'nombre' => $d->producto->nombre,
            'sku' => $d->producto->sku,
            'cantidad' => $d->cantidad,
        ]) ?? []),
        buscarUrl: '{{ route('desmedros.productos.buscar') }}',
        detalleStoreUrl: '{{ route('desmedros.detalle.store') }}',
        detalleDestroyUrlBase: '{{ url('desmedros/detalle') }}',
        registrarUrlBase: '{{ url('desmedros') }}',
        csrf: '{{ csrf_token() }}',
    })">

    <div class="dsm-breadcrumb">
        <a href="{{ url('/') }}">Inicio</a>
        <span class="sep">/</span>
        <a href="{{ url('/inventario') }}">Inventario</a>
        <span class="sep">/</span>
        <span class="current">Desmedros</span>
    </div>

    <div class="dsm-header">
        <div>
            <h1>Desmedros</h1>
            <p>Productos dados de baja por mal origen &middot; el registro descuenta el stock automáticamente</p>
        </div>
        <div class="dsm-badge-count">{{ $desmedros->total() }} cajas registradas</div>
    </div>

    @if(session('success'))
        <div class="dsm-alert success">
            <span class="ico">✓</span>
            <div><strong>Listo.</strong> {{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="dsm-alert danger">
            <span class="ico">⚠</span>
            <div>
                <strong>Revisa lo siguiente antes de continuar:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="dsm-kpis">
        <div class="dsm-kpi-card navy">
            <div class="k-label">Cajas registradas (histórico)</div>
            <div class="k-value">{{ number_format($kpis['total_cajas']) }}</div>
            <div class="k-sub">{{ $kpis['cajas_este_mes'] }} este mes</div>
        </div>
        <div class="dsm-kpi-card red">
            <div class="k-label">Unidades desmedradas (histórico)</div>
            <div class="k-value">{{ number_format($kpis['total_unidades'], 0) }}</div>
            <div class="k-sub"><b>{{ number_format($kpis['unidades_este_mes'], 0) }}</b> este mes</div>
        </div>
        <div class="dsm-kpi-card amber">
            <div class="k-label">Promedio por caja</div>
            <div class="k-value">{{ number_format($kpis['promedio_caja'], 1) }}</div>
            <div class="k-sub">unidades / caja</div>
        </div>
        <div class="dsm-kpi-card green">
            <div class="k-label">Caja en construcción</div>
            <div class="k-value">{{ $borrador ? $borrador->detalles->count() : 0 }}</div>
            <div class="k-sub">{{ $borrador ? 'productos agregados, pendiente de registrar' : 'sin caja abierta' }}</div>
        </div>
    </div>

    <div class="dsm-charts">
        <div class="dsm-chart-card">
            <h3>Cajas registradas por mes</h3>
            <p class="hint">Últimos 6 meses</p>
            <canvas id="dsmTendenciaChart"></canvas>
        </div>
        <div class="dsm-chart-card">
            <h3>Top 5 productos con más pérdida</h3>
            <p class="hint">Unidades desmedradas, histórico</p>
            @if($topProductos->count())
                <div class="dsm-top-list">
                    @php $maxTop = $topProductos->max('total') ?: 1; @endphp
                    @foreach($topProductos as $i => $tp)
                        <div class="dsm-top-item">
                            <div class="rank">{{ $i + 1 }}</div>
                            <div class="info">
                                <div class="nombre">{{ $tp->producto->nombre ?? 'Producto eliminado' }}</div>
                                <div class="barra-bg"><div class="barra-fill" style="width: {{ ($tp->total / $maxTop) * 100 }}%"></div></div>
                            </div>
                            <div class="cant">{{ number_format($tp->total, 0) }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="dsm-top-empty">Aún no hay suficientes datos para el ranking.</div>
            @endif
        </div>
    </div>

    <div class="dsm-grid">
        <div class="dsm-ticket">
            <div class="dsm-ticket-head">
                <div class="id">
                    <small>Caja de desmedro</small>
                    <span x-text="codigo || 'Sin asignar'"></span>
                </div>
                <span class="dsm-state borrador">En construcción</span>
            </div>

            <div class="dsm-hint-box">
                <span class="ico">💡</span>
                <span>Busca el producto, indica la cantidad y agrégalo a la caja. El stock recién se descuenta cuando presionas <b>Registrar desmedro</b>.</span>
            </div>

            <div class="dsm-search">
                <input
                    type="text"
                    placeholder="Buscar producto por SKU, código de barras o nombre..."
                    x-model="query"
                    @input.debounce.250ms="buscar()"
                    @keydown.escape="sugerencias = []"
                    autocomplete="off"
                >
                <div class="dsm-suggest" x-show="sugerencias.length || buscando" x-cloak @click.outside="sugerencias = []">
                    <template x-if="buscando">
                        <div class="dsm-suggest-empty">Buscando...</div>
                    </template>
                    <template x-for="p in sugerencias" :key="p.id">
                        <button type="button" @click="seleccionar(p)">
                            <span>
                                <span class="nombre" x-text="p.nombre"></span><br>
                                <span class="codigo" x-text="p.sku"></span>
                            </span>
                            <span class="stock" x-text="'stock: ' + p.stock"></span>
                        </button>
                    </template>
                </div>
            </div>

            <template x-if="seleccionado">
                <div class="dsm-selected" :class="{ 'low-stock': cantidad > seleccionado.stock }">
                    <span>Seleccionado: <b x-text="seleccionado.nombre"></b></span>
                    <span x-text="'stock disp.: ' + seleccionado.stock"></span>
                </div>
            </template>

            <template x-if="seleccionado && cantidad > seleccionado.stock">
                <div class="dsm-inline-error">⚠ La cantidad supera el stock disponible. No se podrá registrar así.</div>
            </template>

            <div class="dsm-qty-row">
                <input type="number" min="0.01" step="0.01" placeholder="Cant." x-model.number="cantidad" @keydown.enter="agregar()">
                <button type="button" :disabled="!seleccionado || !cantidad || cantidad <= 0 || agregando" @click="agregar()">
                    <span x-show="!agregando">+ Agregar a la caja</span>
                    <span x-show="agregando">Agregando...</span>
                </button>
            </div>

            <div class="dsm-detalle-list">
                <template x-if="!detalles.length">
                    <div class="dsm-empty">Aún no agregaste productos a esta caja.</div>
                </template>
                <template x-for="d in detalles" :key="d.id">
                    <div class="dsm-detalle-item">
                        <div>
                            <div class="nombre" x-text="d.nombre"></div>
                            <div class="codigo" x-text="d.sku"></div>
                        </div>
                        <div style="display:flex; align-items:center;">
                            <span class="cant" x-text="d.cantidad"></span>
                            <button class="quitar" title="Quitar" @click="quitar(d)">&times;</button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="dsm-ticket-foot">
                <div class="dsm-total">
                    Total en la caja
                    <b x-text="totalCantidad()"></b>
                </div>
                <button type="button" class="dsm-btn-registrar" :disabled="!detalles.length || registrando" @click="registrar()">
                    <span x-show="!registrando">Registrar desmedro</span>
                    <span x-show="registrando">Descontando stock...</span>
                </button>
            </div>
        </div>

        <div>
            <div class="dsm-list-head">
                <h2>Desmedros registrados</h2>
                <span>Descuento de stock aplicado</span>
            </div>

            <div class="dsm-table-card">
                @if($desmedros->count())
                    <table class="dsm-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Fecha</th>
                                <th>Responsable</th>
                                <th># Productos</th>
                                <th>Cant. total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($desmedros as $d)
                                <tr onclick="window.location='{{ route('desmedros.show', $d) }}'">
                                    <td class="dsm-code-cell">{{ $d->codigo }}</td>
                                    <td>{{ optional($d->registrado_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $d->usuario->name ?? '—' }}</td>
                                    <td>{{ $d->detalles_count }}</td>
                                    <td class="dsm-qty-cell">{{ number_format($d->detalles->sum('cantidad') ?? 0, 2) }}</td>
                                    <td><span class="dsm-tag-registrado">● Registrado</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="dsm-list-empty">Todavía no hay desmedros registrados.</div>
                @endif
            </div>

            <div style="margin-top:14px;">{{ $desmedros->links() }}</div>
        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
function desmedroBuilder(cfg) {
    return {
        desmedroId: cfg.desmedroId,
        codigo: cfg.codigo,
        detalles: cfg.detalles || [],
        query: '',
        sugerencias: [],
        seleccionado: null,
        cantidad: null,
        agregando: false,
        registrando: false,
        buscando: false,

        async buscar() {
            if (this.query.trim().length < 2) { this.sugerencias = []; return; }
            this.buscando = true;
            try {
                const res = await fetch(cfg.buscarUrl + '?q=' + encodeURIComponent(this.query));
                this.sugerencias = res.ok ? await res.json() : [];
            } finally {
                this.buscando = false;
            }
        },

        seleccionar(p) {
            this.seleccionado = p;
            this.query = p.nombre;
            this.sugerencias = [];
        },

        totalCantidad() {
            return this.detalles.reduce((sum, d) => sum + Number(d.cantidad), 0).toFixed(2);
        },

        async agregar() {
            if (!this.seleccionado || !this.cantidad || this.cantidad <= 0) return;
            this.agregando = true;
            try {
                const res = await fetch(cfg.detalleStoreUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': cfg.csrf },
                    body: JSON.stringify({
                        desmedro_id: this.desmedroId,
                        producto_id: this.seleccionado.id,
                        cantidad: this.cantidad,
                    }),
                });
                if (!res.ok) throw new Error('No se pudo agregar el producto.');
                const data = await res.json();

                this.desmedroId = data.desmedro.id;
                this.codigo = data.desmedro.codigo;
                this.detalles.push({
                    id: data.detalle.id,
                    producto_id: data.detalle.producto_id,
                    nombre: data.detalle.producto.nombre,
                    sku: data.detalle.producto.sku,
                    cantidad: data.detalle.cantidad,
                });

                this.seleccionado = null;
                this.query = '';
                this.cantidad = null;
            } catch (e) {
                alert(e.message);
            } finally {
                this.agregando = false;
            }
        },

        async quitar(d) {
            if (!confirm('¿Quitar ' + d.nombre + ' de la caja?')) return;
            const res = await fetch(cfg.detalleDestroyUrlBase + '/' + d.id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': cfg.csrf },
            });
            if (res.ok) {
                this.detalles = this.detalles.filter(x => x.id !== d.id);
            }
        },

        async registrar() {
            if (!this.detalles.length) return;
            if (!confirm('Se descontará el stock de ' + this.detalles.length + ' producto(s). ¿Confirmar registro?')) return;
            this.registrando = true;
            try {
                const res = await fetch(cfg.registrarUrlBase + '/' + this.desmedroId + '/registrar', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': cfg.csrf, 'Accept': 'application/json' },
                });
                if (res.redirected) {
                    window.location = res.url;
                    return;
                }
                if (!res.ok) {
                    const data = await res.json().catch(() => ({}));
                    throw new Error(data.message || 'No se pudo registrar el desmedro.');
                }
                window.location = cfg.registrarUrlBase + '/' + this.desmedroId;
            } catch (e) {
                alert(e.message);
                this.registrando = false;
            }
        },
    };
}

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('dsmTendenciaChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($tendencia->pluck('label')),
            datasets: [{
                label: 'Cajas registradas',
                data: @json($tendencia->pluck('cantidad')),
                backgroundColor: '#C0392B',
                borderRadius: 5,
                maxBarThickness: 34,
            }],
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F1F3F7' } },
                x: { grid: { display: false } },
            },
        },
    });
});
</script>
@endsection
