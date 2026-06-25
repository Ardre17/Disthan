@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.1rem;background:#f1f5f9;min-height:100vh;}
.erp-bar{background:#1e3a5f;padding:0 1.25rem;height:38px;display:flex;align-items:center;justify-content:space-between;margin:-20px -20px 1rem;}
.erp-bar-title{color:#7eb8f7;font-size:12px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;}
.erp-sub{font-size:11px;color:#5a8abf;}
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:.75rem 1rem;border-left:4px solid;}
.kpi-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.05em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:19px;font-weight:700;color:#1e293b;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.charts-row{display:grid;grid-template-columns:2fr 1fr;gap:10px;margin-bottom:1rem;}
@media(max-width:800px){.charts-row{grid-template-columns:1fr;}}
.chart-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.9rem 1rem;}
.chart-title{font-size:12px;font-weight:700;color:#1e293b;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.05em;}
.legend{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:6px;}
.leg-item{display:flex;align-items:center;gap:4px;font-size:11px;color:#64748b;}
.leg-dot{width:8px;height:8px;border-radius:2px;flex-shrink:0;}
.form-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.9rem 1rem;margin-bottom:1rem;}
.form-title{font-size:12px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem;display:flex;align-items:center;gap:6px;}
.fgrid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:8px;align-items:end;}
.mov-grid{display:grid;grid-template-columns:2fr 1fr 1fr 2fr auto;gap:8px;align-items:end;}
@media(max-width:700px){.fgrid,.mov-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #e2e8f0;border-radius:7px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#16a34a;box-shadow:0 0 0 2px rgba(22,163,74,.1);}
.btn-g{padding:8px 14px;background:#16a34a;color:#fff;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;align-self:end;}
.btn-g:hover{background:#15803d;}
.sec-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;flex-wrap:wrap;gap:6px;}
.sec-title{font-size:14px;font-weight:700;color:#1e293b;}
.cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;margin-bottom:1rem;}
.card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.9rem;border-left:4px solid;display:flex;flex-direction:column;gap:.5rem;transition:box-shadow .15s;}
.card:hover{box-shadow:0 4px 12px rgba(0,0,0,.08);}
.c-top{display:flex;justify-content:space-between;align-items:flex-start;}
.c-name{font-size:13px;font-weight:700;color:#0f172a;}
.c-meta{font-size:10px;color:#94a3b8;margin-top:1px;}
.lang-badge{display:inline-block;font-size:10px;font-weight:700;padding:2px 7px;border-radius:99px;}
.c-stock{font-size:24px;font-weight:800;line-height:1;}
.c-stocksub{font-size:10px;color:#94a3b8;margin-top:1px;}
.mini-bar{width:100%;height:4px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-top:3px;}
.mini-fill{height:100%;border-radius:99px;}
.c-input{padding:6px 9px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;width:100%;outline:none;text-align:center;transition:border-color .15s;}
.c-input:focus{border-color:#2563eb;}
.c-btns{display:grid;grid-template-columns:1fr 1fr;gap:5px;}
.c-btn{padding:7px;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:3px;transition:opacity .15s;}
.c-btn:hover{opacity:.85;}
.btn-in{background:#dcfce7;color:#15803d;}
.btn-out{background:#fee2e2;color:#b91c1c;}
.btn-hist{background:#eff6ff;color:#1d4ed8;width:100%;padding:5px;border:none;border-radius:7px;font-size:11px;font-weight:600;cursor:pointer;margin-top:2px;}
.hist-inline{background:#f8fafc;border-radius:7px;padding:7px;font-size:11px;display:none;flex-direction:column;gap:3px;max-height:120px;overflow-y:auto;margin-top:4px;}
.hist-inline.open{display:flex;}
.h-row{display:flex;justify-content:space-between;color:#475569;padding:2px 0;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}
.alert-bar{padding:8px 14px;border-radius:7px;font-size:12px;font-weight:500;margin-bottom:.75rem;display:none;align-items:center;gap:7px;}
.alert-bar.show{display:flex;}
.aok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
.awk{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.aer{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.ht{border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;background:#fff;}
.ht table{width:100%;border-collapse:collapse;font-size:12px;}
.ht th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid #e2e8f0;text-align:left;white-space:nowrap;}
.ht td{padding:7px 10px;border-bottom:1px solid #f8fafc;color:#374151;vertical-align:middle;}
.ht tbody tr:hover td{background:#f8fafc;}
.tipo-e{background:#dcfce7;color:#15803d;font-size:10px;padding:2px 7px;border-radius:99px;font-weight:700;white-space:nowrap;}
.tipo-s{background:#fee2e2;color:#b91c1c;font-size:10px;padding:2px 7px;border-radius:99px;font-weight:700;white-space:nowrap;}
.alerta-stock{font-size:10px;border-radius:6px;padding:3px 7px;font-weight:600;display:inline-block;}
</style>

<div class="erp-bar">
    <div class="erp-bar-title">JOYBER PERÚ · Control de Etiquetas</div>
    <span class="erp-sub">Inventario › Etiquetas</span>
</div>

<div class="pg">

<div id="alertBox" class="alert-bar"></div>

{{-- ── KPIs ── --}}
@php
    $total     = $inventories->sum('stock');
    $sinStock  = $inventories->where('stock', 0)->count();
    $bajo      = $inventories->where('stock', '>', 0)->where('stock', '<', 20)->count();
    $enStock   = $inventories->where('stock', '>=', 20)->count();
    $movHoy    = isset($movements) ? $movements->filter(function($m){
        return \Carbon\Carbon::parse($m->created_at)->isToday();
    })->count() : 0;
@endphp

<div class="kpis">
    <div class="kpi" style="border-left-color:#1e3a5f;">
        <div class="kpi-label">Total ítems</div>
        <div class="kpi-val">{{ $inventories->count() }}</div>
        <div class="kpi-sub">registros activos</div>
    </div>
    <div class="kpi" style="border-left-color:#22c55e;">
        <div class="kpi-label">Stock total</div>
        <div class="kpi-val" style="color:#15803d;">{{ number_format($total) }}</div>
        <div class="kpi-sub">etiquetas disponibles</div>
    </div>
    <div class="kpi" style="border-left-color:#ef4444;">
        <div class="kpi-label">Sin stock</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $sinStock }}</div>
        <div class="kpi-sub">requieren reposición</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-label">Stock bajo</div>
        <div class="kpi-val" style="color:#b45309;">{{ $bajo }}</div>
        <div class="kpi-sub">menos de 20 unid.</div>
    </div>
    <div class="kpi" style="border-left-color:#2563eb;background:#f0f7ff;">
        <div class="kpi-label">Mov. hoy</div>
        <div class="kpi-val" style="color:#2563eb;">{{ $movHoy }}</div>
        <div class="kpi-sub">entradas + salidas</div>
    </div>
</div>

{{-- ── Gráficos ── --}}
@php
    $porIdioma = $inventories->groupBy('idioma');
    $zonas     = $inventories->pluck('zona')->unique()->values();

    $idiomaLabels = json_encode($porIdioma->keys()->values()->toArray());
    $idiomaData   = json_encode($porIdioma->map(function($g){ return $g->sum('stock'); })->values()->toArray());
    $idiomaColors = json_encode(['#ef4444','#2563eb','#16a34a','#f59e0b']);

    $enStockC = $inventories->where('stock','>=',20)->count();
    $bajoC    = $inventories->where('stock','>',0)->where('stock','<',20)->count();
    $sinC     = $inventories->where('stock',0)->count();
@endphp

<div class="charts-row">
    <div class="chart-card">
        <div class="chart-title">Stock por idioma</div>
        <div class="legend" id="legIdioma"></div>
        <div style="position:relative;height:160px;">
            <canvas id="chartBar"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">Estado del stock</div>
        <div class="legend">
            <span class="leg-item"><span class="leg-dot" style="background:#22c55e;"></span>OK — {{ $enStockC }}</span>
            <span class="leg-item"><span class="leg-dot" style="background:#f59e0b;"></span>Bajo — {{ $bajoC }}</span>
            <span class="leg-item"><span class="leg-dot" style="background:#ef4444;"></span>Sin — {{ $sinC }}</span>
        </div>
        <div style="position:relative;height:140px;">
            <canvas id="chartDona"></canvas>
        </div>
    </div>
</div>

{{-- ── Formulario nueva etiqueta ── --}}
<div class="form-card">
    <div class="form-title">➕ Registrar nueva etiqueta</div>
    <form method="POST" action="/inventario/store">
        @csrf
        <div class="fgrid">
            <div>
                <label class="flabel">Producto</label>
                <select name="product_id" class="finput" required>
                    <option value="">Seleccionar</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="flabel">Idioma</label>
                <select name="idioma" class="finput" required>
                    <option value="ES">🇵🇪 Español</option>
                    <option value="EN">🇺🇸 Inglés</option>
                    <option value="PT">🇧🇷 Portugués</option>
                </select>
            </div>
            <div>
                <label class="flabel">Zona</label>
                <select name="zona" class="finput" required>
                    <option value="Sin Zona">Sin Zona</option>
                    <option value="Santa Luzia">Santa Luzia</option>
                    <option value="Zona Zul">Zona Zul</option>
                </select>
            </div>
            <div>
                <label class="flabel">Cantidad inicial</label>
                <input type="number" name="cantidad" class="finput" required placeholder="0">
            </div>
            <button type="submit" class="btn-g">💾 Guardar</button>
        </div>
    </form>
</div>

{{-- ── Formulario movimiento ── --}}
<div class="form-card">
    <div class="form-title">📋 Registrar movimiento manual</div>
    <div class="mov-grid">
        <div>
            <label class="flabel">Producto</label>
            <select id="product_id" class="finput">
                <option value="">Seleccionar</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="flabel">Cantidad</label>
            <input type="number" id="cantidad" class="finput" placeholder="0">
        </div>
        <div>
            <label class="flabel">Tipo</label>
            <select id="tipo" class="finput">
                <option value="ENTRADA">⬆ Entrada</option>
                <option value="SALIDA">⬇ Salida</option>
            </select>
        </div>
        <div>
            <label class="flabel">Motivo</label>
            <input type="text" id="motivo" class="finput" placeholder="Producción / Uso / Ajuste">
        </div>
        <button type="button" class="btn-g" onclick="guardarMovimiento()">Guardar</button>
    </div>
</div>

{{-- ── Cards etiquetas ── --}}
<div class="sec-hdr">
    <div class="sec-title">🏷️ Etiquetas en inventario</div>
    <div style="display:flex;gap:7px;flex-wrap:wrap;">
        <input class="finput" style="width:170px;" placeholder="Buscar producto..."
               oninput="filtrarCards(this.value)">
        <select class="finput" style="width:130px;" onchange="filtrarIdioma(this.value)">
            <option value="">Todos los idiomas</option>
            <option value="ES">🇵🇪 Español</option>
            <option value="EN">🇺🇸 Inglés</option>
            <option value="PT">🇧🇷 Portugués</option>
        </select>
    </div>
</div>

<div class="cards-grid" id="cardsGrid">
@foreach($inventories as $inv)
@php
    $s   = $inv->stock;
    $lc  = $s == 0 ? '#ef4444' : ($s < 20 ? '#f59e0b' : '#22c55e');
    $sc  = $s == 0 ? '#b91c1c' : ($s < 20 ? '#b45309' : '#15803d');
    $pct = $s > 0 ? min(100, ($s / max($inventories->max('stock'), 1)) * 100) : 0;

    $langColor = match($inv->idioma) {
        'ES' => ['bg'=>'#fee2e2','c'=>'#b91c1c'],
        'EN' => ['bg'=>'#dbeafe','c'=>'#1d4ed8'],
        'PT' => ['bg'=>'#dcfce7','c'=>'#15803d'],
        default => ['bg'=>'#f1f5f9','c'=>'#64748b'],
    };

    $alertaHtml = '';
    if ($s == 0)      $alertaHtml = '<div class="alerta-stock" style="background:#fee2e2;color:#b91c1c;">🔴 Sin stock</div>';
    elseif ($s < 20)  $alertaHtml = '<div class="alerta-stock" style="background:#fef3c7;color:#b45309;">⚠ Stock bajo</div>';
@endphp
<div class="card"
     style="border-left-color:{{ $lc }};"
     data-nombre="{{ strtolower($inv->product?->nombre ?? '') }}"
     data-idioma="{{ $inv->idioma }}">

    <div class="c-top">
        <div>
            <div class="c-name">
                📦 {{ $inv->product?->nombre ?? 'Sin producto' }}
            </div>
            <div class="c-meta">{{ $inv->zona }}</div>
        </div>
        <span class="lang-badge" style="background:{{ $langColor['bg'] }};color:{{ $langColor['c'] }};">
            {{ $inv->idioma }}
        </span>
    </div>

    <div class="c-stock" style="color:{{ $sc }};"
         id="stock-{{ $inv->id }}">{{ $inv->stock }}</div>
    <div class="c-stocksub">etiquetas disponibles</div>
    <div class="mini-bar">
        <div class="mini-fill" style="width:{{ $pct }}%;background:{{ $lc }};"></div>
    </div>

    {!! $alertaHtml !!}

    <hr class="dv">

    <input type="number" id="input-{{ $inv->id }}" class="c-input" placeholder="Cantidad" min="1">

    <div class="c-btns">
        <button class="c-btn btn-in" onclick="entrada({{ $inv->id }})">➕ Entrada</button>
        <button class="c-btn btn-out" onclick="salida({{ $inv->id }})"
                {{ $s == 0 ? 'disabled style=opacity:.4' : '' }}>➖ Salida</button>
    </div>

    <button class="btn-hist" onclick="toggleHistorial({{ $inv->id }})">
        📊 Ver historial
    </button>

    <div class="hist-inline" id="historial-{{ $inv->id }}">
        @forelse($inv->movements->take(6) as $m)
        <div class="h-row">
            <span>{{ $m->motivo }}</span>
            <span style="font-weight:700;color:{{ $m->tipo=='ENTRADA'?'#15803d':'#b91c1c' }};">
                {{ $m->tipo=='ENTRADA' ? '+' : '−' }}{{ $m->cantidad }}
            </span>
        </div>
        @empty
        <div style="color:#94a3b8;font-size:11px;">Sin movimientos</div>
        @endforelse
    </div>
</div>
@endforeach
</div>

{{-- ── Tabla historial global ── --}}
<div class="ht">
    <div style="padding:.85rem 1rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;border-bottom:2px solid #e2e8f0;">
        <div style="font-size:13px;font-weight:700;color:#1e293b;">📊 Historial de movimientos</div>
        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <select class="finput" style="width:130px;" onchange="filtrarHist(this.value,'tipo')">
                <option value="">Todos</option>
                <option value="ENTRADA">⬆ Entradas</option>
                <option value="SALIDA">⬇ Salidas</option>
            </select>
            <input class="finput" style="width:170px;" placeholder="Buscar producto..."
                   oninput="filtrarHist(this.value,'prod')">
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Idioma</th>
                    <th>Zona</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody id="histTbody">
                @foreach($movements as $m)
                @php
                    $lc2 = $m->tipo === 'ENTRADA' ? '#15803d' : '#b91c1c';
                    $inv2 = $inventories->firstWhere('id', $m->inventory_id);
                    $langC2 = match($inv2?->idioma ?? '') {
                        'ES' => ['bg'=>'#fee2e2','c'=>'#b91c1c'],
                        'EN' => ['bg'=>'#dbeafe','c'=>'#1d4ed8'],
                        'PT' => ['bg'=>'#dcfce7','c'=>'#15803d'],
                        default => ['bg'=>'#f1f5f9','c'=>'#64748b'],
                    };
                @endphp
                <tr data-tipo="{{ $m->tipo }}"
                    data-prod="{{ strtolower($m->product->nombre ?? '') }}">
                    <td style="color:#94a3b8;white-space:nowrap;">
                        {{ \Carbon\Carbon::parse($m->created_at)->format('d M Y H:i') }}
                    </td>
                    <td style="font-weight:600;color:#0f172a;">{{ $m->product->nombre ?? '—' }}</td>
                    <td>
                        @if($inv2?->idioma)
                        <span class="lang-badge" style="background:{{ $langC2['bg'] }};color:{{ $langC2['c'] }};">
                            {{ $inv2->idioma }}
                        </span>
                        @else —
                        @endif
                    </td>
                    <td style="color:#64748b;">{{ $inv2?->zona ?? '—' }}</td>
                    <td>
                        <span class="{{ $m->tipo === 'ENTRADA' ? 'tipo-e' : 'tipo-s' }}">
                            {{ $m->tipo === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}
                        </span>
                    </td>
                    <td style="font-weight:700;color:{{ $lc2 }};">
                        {{ $m->tipo === 'ENTRADA' ? '+' : '−' }}{{ $m->cantidad }}
                    </td>
                    <td style="color:#475569;">{{ $m->motivo }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
var idiomaLabels = {!! $idiomaLabels !!};
var idiomaData   = {!! $idiomaData !!};
var idiomaColors = {!! $idiomaColors !!};

new Chart(document.getElementById('chartBar'), {
    type: 'bar',
    data: {
        labels: idiomaLabels,
        datasets: [{
            data: idiomaData,
            backgroundColor: idiomaColors,
            borderRadius: 5,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }
        }
    }
});

document.getElementById('legIdioma').innerHTML = idiomaLabels.map(function(l, i){
    return '<span class="leg-item"><span class="leg-dot" style="background:'+idiomaColors[i]+';"></span>'+l+' — '+idiomaData[i]+'</span>';
}).join('');

new Chart(document.getElementById('chartDona'), {
    type: 'doughnut',
    data: {
        labels: ['En stock','Stock bajo','Sin stock'],
        datasets: [{
            data: [{{ $enStockC }}, {{ $bajoC }}, {{ $sinC }}],
            backgroundColor: ['#22c55e','#f59e0b','#ef4444'],
            borderWidth: 2, borderColor: '#fff'
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '62%'
    }
});

function showAlert(msg, cls) {
    var b = document.getElementById('alertBox');
    b.className = 'alert-bar show ' + cls;
    b.textContent = msg;
    clearTimeout(b._t);
    b._t = setTimeout(function(){ b.className = 'alert-bar'; }, 3500);
}

function getCantidad(id) {
    return parseInt(document.getElementById('input-' + id).value);
}

function actualizarStock(id, cambio) {
    var el = document.getElementById('stock-' + id);
    var actual = parseInt(el.textContent);
    el.textContent = actual + cambio;
    document.getElementById('input-' + id).value = '';
}

function entrada(id){
    let cantidad = parseInt(document.getElementById('input-' + id).value);

    if(!cantidad || cantidad <= 0){
        alert('Cantidad inválida');
        return;
    }

    fetch('/inventario/add/' + id, {
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad })
    })
    .then(res => res.json())
    .then(data => {

        if(!data.success){
            alert('Error al ingresar');
            return;
        }

        // 🔥 ACTUALIZAR STOCK REAL
        document.getElementById('stock-' + id).innerText = data.nuevo_stock;

        document.getElementById('input-' + id).value = '';

    })
    .catch(() => alert('Error en entrada'));
}

function salida(id){
    let cantidad = parseInt(document.getElementById('input-' + id).value);

    if(!cantidad || cantidad <= 0){
        alert('Cantidad inválida');
        return;
    }

    fetch('/inventario/salida/' + id, {
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad })
    })
    .then(res => res.json())
    .then(data => {

        if(!data.success){
            alert(data.message);
            return;
        }

        // 🔥 ACTUALIZAR STOCK REAL
        document.getElementById('stock-' + id).innerText = data.nuevo_stock;

        document.getElementById('input-' + id).value = '';

    })
    .catch(() => alert('Error en salida'));
}

function toggleHistorial(id) {
    var div = document.getElementById('historial-' + id);
    div.classList.toggle('open');
}

function guardarMovimiento() {
    var data = {
        product_id: document.getElementById('product_id').value,
        cantidad:   document.getElementById('cantidad').value,
        tipo:       document.getElementById('tipo').value,
        motivo:     document.getElementById('motivo').value,
        _token:     '{{ csrf_token() }}'
    };

    if (!data.product_id || !data.cantidad) {
        showAlert('Completa producto y cantidad', 'awk');
        return;
    }

    fetch('/control-etiquetas/store', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(function(res){ return res.json(); })
    .then(function(){
        showAlert('Movimiento registrado correctamente', 'aok');
        setTimeout(function(){ location.reload(); }, 1200);
    })
    .catch(function(){ showAlert('Error al guardar movimiento', 'aer'); });
}

var histFiltTipo = '', histFiltProd = '';

function filtrarHist(val, campo) {
    if (campo === 'tipo') histFiltTipo = val;
    else histFiltProd = val.toLowerCase();
    document.querySelectorAll('#histTbody tr').forEach(function(tr){
        var mT = !histFiltTipo || tr.dataset.tipo === histFiltTipo;
        var mP = !histFiltProd || (tr.dataset.prod && tr.dataset.prod.includes(histFiltProd));
        tr.style.display = (mT && mP) ? '' : 'none';
    });
}

function filtrarCards(q) {
    document.querySelectorAll('#cardsGrid .card').forEach(function(c){
        c.style.display = c.dataset.nombre.includes(q.toLowerCase()) ? '' : 'none';
    });
}

function filtrarIdioma(i) {
    document.querySelectorAll('#cardsGrid .card').forEach(function(c){
        c.style.display = (!i || c.dataset.idioma === i) ? '' : 'none';
    });
}
</script>

@endsection