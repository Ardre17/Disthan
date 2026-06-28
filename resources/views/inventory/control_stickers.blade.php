@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.1rem;background:#f1f5f9;min-height:100vh;}
.erp-bar{background:#1e3a5f;padding:0 1.25rem;height:38px;display:flex;align-items:center;justify-content:space-between;margin:-20px -20px 1rem;}
.erp-bar-title{color:#7eb8f7;font-size:12px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;}
.erp-sub{font-size:11px;color:#5a8abf;}

/* KPIs */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:600px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.1;}
.kpi-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;color:#1e293b;line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:2px;}

/* Form */
.form-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.9rem 1.1rem;margin-bottom:1rem;}
.form-title{font-size:12px;font-weight:700;color:#1e293b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem;display:flex;align-items:center;gap:6px;}
.fgrid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:8px;align-items:end;}
@media(max-width:700px){.fgrid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #e2e8f0;border-radius:7px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#16a34a;box-shadow:0 0 0 2px rgba(22,163,74,.1);}
.btn-save{padding:8px 16px;background:#16a34a;color:#fff;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;align-self:end;}
.btn-save:hover{background:#15803d;}

/* Filtros */
.filters{display:flex;gap:8px;margin-bottom:.85rem;flex-wrap:wrap;align-items:center;}
.sec-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;flex-wrap:wrap;gap:6px;}
.sec-title{font-size:14px;font-weight:700;color:#1e293b;}
.count-pill{font-size:11px;background:#f1f5f9;color:#64748b;padding:2px 10px;border-radius:99px;}

/* Cards */
.cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:10px;margin-bottom:1.25rem;}
.card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.9rem;border-left:4px solid;display:flex;flex-direction:column;gap:.55rem;transition:box-shadow .15s;}
.card:hover{box-shadow:0 4px 14px rgba(0,0,0,.08);}
.card-top{display:flex;justify-content:space-between;align-items:flex-start;}
.card-name{font-size:13px;font-weight:700;color:#0f172a;line-height:1.3;}
.card-zone{font-size:10px;color:#94a3b8;margin-top:1px;}
.lang-pill{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:99px;}
.lang-es{background:#fee2e2;color:#b91c1c;}
.lang-pt{background:#dcfce7;color:#15803d;}
.stock-num{font-size:26px;font-weight:800;line-height:1;}
.stock-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.mini-bar{width:100%;height:4px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.mini-fill{height:100%;border-radius:99px;transition:width .4s;}
.alert-tag{font-size:10px;font-weight:700;padding:2px 8px;border-radius:6px;display:inline-block;}
.alert-sin{background:#fee2e2;color:#b91c1c;}
.alert-bajo{background:#fef3c7;color:#b45309;}
.c-input{padding:7px 9px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;width:100%;outline:none;text-align:center;transition:border-color .15s;}
.c-input:focus{border-color:#2563eb;}
.c-btns{display:grid;grid-template-columns:1fr 1fr;gap:5px;}
.c-btn{padding:7px;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:3px;transition:opacity .15s;}
.c-btn:hover{opacity:.85;}
.btn-in{background:#dcfce7;color:#15803d;}
.btn-out{background:#fee2e2;color:#b91c1c;}
.btn-hist{width:100%;padding:5px;border:1px solid #e2e8f0;border-radius:7px;font-size:11px;font-weight:600;cursor:pointer;background:#f8fafc;color:#475569;transition:background .15s;}
.btn-hist:hover{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe;}

/* Historial inline */
.hist-box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:7px;padding:7px 9px;display:none;flex-direction:column;gap:3px;max-height:130px;overflow-y:auto;margin-top:2px;}
.hist-box.open{display:flex;}
.hist-row{display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#475569;padding:2px 0;border-bottom:1px solid #f1f5f9;}
.hist-row:last-child{border:none;}
.h-in{font-weight:700;color:#15803d;}
.h-out{font-weight:700;color:#b91c1c;}

/* Tabla historial global */
.ht-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;}
.ht-hdr{padding:.85rem 1.1rem;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;}
.ht table{width:100%;border-collapse:collapse;font-size:12px;}
.ht th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid #e2e8f0;text-align:left;white-space:nowrap;}
.ht td{padding:7px 10px;border-bottom:1px solid #f8fafc;color:#374151;vertical-align:middle;}
.ht tbody tr:hover td{background:#f8fafc;}
.tipo-e{background:#dcfce7;color:#15803d;font-size:10px;padding:2px 7px;border-radius:99px;font-weight:700;white-space:nowrap;}
.tipo-s{background:#fee2e2;color:#b91c1c;font-size:10px;padding:2px 7px;border-radius:99px;font-weight:700;white-space:nowrap;}

/* Alert bar */
.alert-bar{padding:8px 14px;border-radius:7px;font-size:12px;font-weight:500;margin-bottom:.75rem;display:none;align-items:center;gap:7px;}
.alert-bar.show{display:flex;}
.aok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
.awk{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.aer{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}

hr.dv{border:none;border-top:1px solid #f1f5f9;}
</style>

<div class="erp-bar">
    <div class="erp-bar-title">JOYBER PERÚ · Control Stickers de Tapa</div>
    <span class="erp-sub">Inventario › Stickers</span>
</div>

<div class="pg">

<div id="alertBox" class="alert-bar"></div>

{{-- ── PHP vars ── --}}
@php
    $totalItems  = $inventories->count();
    $totalStock  = $inventories->sum('stock');
    $sinStock    = $inventories->where('stock', 0)->count();
    $bajoStock   = $inventories->where('stock', '>', 0)->where('stock', '<', 20)->count();
    $maxStock    = $inventories->max('stock') ?: 1;

    // Todos los movimientos ordenados
    $todosMovs = collect();
    foreach($inventories as $inv) {
        foreach($inv->movements as $m) {
            $todosMovs->push([
                'formato'  => $inv->formato_sticker ?? $inv->product->nombre ?? '—',
                'idioma'   => $inv->idioma,
                'zona'     => $inv->zona ?? '—',
                'tipo'     => $m->tipo,
                'cantidad' => $m->cantidad,
                'motivo'   => $m->motivo ?? '—',
                'fecha'    => $m->created_at
                    ? \Carbon\Carbon::parse($m->created_at)->format('d M Y H:i')
                    : '—',
            ]);
        }
    }
    $todosMovs = $todosMovs->sortByDesc('fecha')->values();
@endphp

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#1e3a5f;">
        <div class="kpi-icon">🏷️</div>
        <div class="kpi-label">Total formatos</div>
        <div class="kpi-val">{{ $totalItems }}</div>
        <div class="kpi-sub">registros activos</div>
    </div>
    <div class="kpi" style="border-left-color:#22c55e;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Stock total</div>
        <div class="kpi-val" style="color:#15803d;">{{ number_format($totalStock) }}</div>
        <div class="kpi-sub">stickers disponibles</div>
    </div>
    <div class="kpi" style="border-left-color:#ef4444;">
        <div class="kpi-icon">🔴</div>
        <div class="kpi-label">Sin stock</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $sinStock }}</div>
        <div class="kpi-sub">requieren reposición</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Stock bajo</div>
        <div class="kpi-val" style="color:#b45309;">{{ $bajoStock }}</div>
        <div class="kpi-sub">menos de 20 unid.</div>
    </div>
</div>

{{-- ── Formulario nueva entrada ── --}}
<div class="form-card">
    <div class="form-title">➕ Registrar nuevo sticker</div>
    <form method="POST" action="/inventario/store">
        @csrf
        <div class="fgrid">
            <div>
                <label class="flabel">Formato</label>
                <select name="formato_sticker" class="finput" required>
                    <option value="">Seleccionar formato</option>
                    <option value="Sticker 30 mm">Sticker 30 mm</option>
                    <option value="Sticker 43 mm">Sticker 43 mm</option>
                    <option value="Sticker 50 mm">Sticker 50 mm</option>
                    <option value="Sticker 55 mm">Sticker 55 mm</option>
                    <option value="Sticker 65 mm">Sticker 65 mm</option>
                    <option value="Sticker 70 mm">Sticker 70 mm</option>
                    <option value="Sticker 85 mm">Sticker 85 mm</option>
                </select>
            </div>
            <div>
                <label class="flabel">Idioma</label>
                <select name="idioma" class="finput" required>
                    <option value="ES">🇪🇸 Español</option>
                    <option value="PT">🇧🇷 Portugués</option>
                </select>
            </div>
            <div>
                <label class="flabel">Zona</label>
                <input type="text" name="zona" class="finput" placeholder="Ej: Zona A">
            </div>
            <div>
                <label class="flabel">Cantidad</label>
                <input type="number" name="cantidad" class="finput" placeholder="0" min="0">
            </div>
            <button type="submit" class="btn-save">💾 Guardar</button>
        </div>
    </form>
</div>

{{-- ── Header + filtros ── --}}
<div class="sec-hdr">
    <div class="sec-title">🏷️ Stickers en inventario</div>
    <span class="count-pill">{{ $totalItems }} registros</span>
</div>

<div class="filters">
    <input class="finput" style="max-width:180px;" placeholder="Buscar formato..."
           id="filtQ" oninput="filtrarCards(this.value)">
    <select class="finput" style="width:130px;" id="filtIdioma" onchange="filtrarIdioma(this.value)">
        <option value="">Todos los idiomas</option>
        <option value="ES">🇪🇸 Español</option>
        <option value="PT">🇧🇷 Portugués</option>
    </select>
</div>

{{-- ── Cards ── --}}
<div class="cards-grid" id="cardsGrid">
@foreach($inventories as $inv)
@php
    $s      = $inv->stock;
    $idioma = $inv->idioma;
    $lc     = $s == 0 ? '#ef4444' : ($s < 20 ? '#f59e0b' : ($idioma === 'ES' ? '#ef4444' : '#22c55e'));
    $sc     = $s == 0 ? '#b91c1c' : ($s < 20 ? '#b45309' : ($idioma === 'ES' ? '#b91c1c' : '#15803d'));
    $pct    = $maxStock > 0 ? min(100, round($s / $maxStock * 100)) : 0;
    $nombre = $inv->formato_sticker ?? $inv->product->nombre ?? '—';
@endphp
<div class="card"
     style="border-left-color:{{ $lc }};"
     data-nombre="{{ strtolower($nombre) }}"
     data-idioma="{{ $idioma }}">

    <div class="card-top">
        <div>
            <div class="card-name">🏷️ {{ $nombre }}</div>
            <div class="card-zone">{{ $inv->zona ?? 'Sin zona' }}</div>
        </div>
        <span class="lang-pill {{ $idioma === 'ES' ? 'lang-es' : 'lang-pt' }}">
            {{ $idioma === 'ES' ? '🇪🇸 ES' : '🇧🇷 PT' }}
        </span>
    </div>

    <div>
        <div class="stock-num" id="stock-{{ $inv->id }}" style="color:{{ $sc }};">
            {{ $s }}
        </div>
        <div class="stock-sub">stickers disponibles</div>
    </div>

    <div class="mini-bar">
        <div class="mini-fill" style="width:{{ $pct }}%;background:{{ $lc }};"></div>
    </div>

    @if($s == 0)
        <span class="alert-tag alert-sin">🔴 Sin stock</span>
    @elseif($s < 20)
        <span class="alert-tag alert-bajo">⚠ Stock bajo</span>
    @endif

    <hr class="dv">

    <input type="number" id="input-{{ $inv->id }}" class="c-input"
           placeholder="Cantidad" min="1">

    <div class="c-btns">
        <button class="c-btn btn-in" onclick="entrada({{ $inv->id }})">
            ➕ Entrada
        </button>
        <button class="c-btn btn-out" onclick="salida({{ $inv->id }})"
                {{ $s == 0 ? 'disabled style=opacity:.4' : '' }}>
            ➖ Salida
        </button>
    </div>

    <button class="btn-hist"
            onclick="document.getElementById('hist-{{ $inv->id }}').classList.toggle('open')">
        📊 Ver historial
    </button>

    {{-- ✅ HISTORIAL INLINE CORREGIDO --}}
    <div class="hist-box" id="hist-{{ $inv->id }}">
        @if($inv->movements && $inv->movements->count())
            @foreach($inv->movements->take(8) as $m)
            <div class="hist-row">
                <span style="color:#475569;">{{ $m->motivo ?? ($m->tipo === 'ENTRADA' ? 'Entrada' : 'Salida') }}</span>
                <span class="{{ $m->tipo === 'ENTRADA' ? 'h-in' : 'h-out' }}">
                    {{ $m->tipo === 'ENTRADA' ? '+' : '−' }}{{ $m->cantidad }}
                </span>
            </div>
            @endforeach
        @else
            <div style="font-size:11px;color:#94a3b8;text-align:center;padding:4px;">
                Sin movimientos registrados
            </div>
        @endif
    </div>

</div>
@endforeach
</div>

{{-- ── Tabla historial global ── --}}
<div class="ht-card">
    <div class="ht-hdr">
        <div style="font-size:13px;font-weight:700;color:#1e293b;">📋 Historial global de movimientos</div>
        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <select class="finput" style="width:130px;" onchange="filtrarHist(this.value,'tipo')">
                <option value="">Todos</option>
                <option value="ENTRADA">⬆ Entradas</option>
                <option value="SALIDA">⬇ Salidas</option>
            </select>
            <select class="finput" style="width:120px;" onchange="filtrarHist(this.value,'idioma')">
                <option value="">Todos</option>
                <option value="ES">🇪🇸 ES</option>
                <option value="PT">🇧🇷 PT</option>
            </select>
            <input class="finput" style="width:160px;" placeholder="Buscar formato..."
                   oninput="filtrarHist(this.value,'formato')">
        </div>
    </div>
    <div class="ht" style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Formato</th>
                    <th>Idioma</th>
                    <th>Zona</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody id="histTbody">
                @forelse($todosMovs as $mov)
                <tr data-tipo="{{ $mov['tipo'] }}"
                    data-idioma="{{ $mov['idioma'] }}"
                    data-formato="{{ strtolower($mov['formato']) }}">
                    <td style="color:#94a3b8;white-space:nowrap;">{{ $mov['fecha'] }}</td>
                    <td style="font-weight:600;color:#0f172a;">{{ $mov['formato'] }}</td>
                    <td>
                        <span class="lang-pill {{ $mov['idioma'] === 'ES' ? 'lang-es' : 'lang-pt' }}">
                            {{ $mov['idioma'] === 'ES' ? '🇪🇸 ES' : '🇧🇷 PT' }}
                        </span>
                    </td>
                    <td style="color:#64748b;">{{ $mov['zona'] }}</td>
                    <td>
                        <span class="{{ $mov['tipo'] === 'ENTRADA' ? 'tipo-e' : 'tipo-s' }}">
                            {{ $mov['tipo'] === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}
                        </span>
                    </td>
                    <td style="font-weight:700;color:{{ $mov['tipo'] === 'ENTRADA' ? '#15803d' : '#b91c1c' }};">
                        {{ $mov['tipo'] === 'ENTRADA' ? '+' : '−' }}{{ $mov['cantidad'] }}
                    </td>
                    <td style="color:#475569;">{{ $mov['motivo'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#94a3b8;padding:2rem;">
                        Sin movimientos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>

<script>
function showAlert(msg, cls) {
    var b = document.getElementById('alertBox');
    b.className = 'alert-bar show ' + cls;
    b.textContent = msg;
    clearTimeout(b._t);
    b._t = setTimeout(function(){ b.className = 'alert-bar'; }, 3500);
}

function getCantidad(id) {
    var v = parseInt(document.getElementById('input-' + id).value);
    return isNaN(v) ? 0 : v;
}

function actualizarUI(id, nuevoStock) {
    var el  = document.getElementById('stock-' + id);
    var s   = parseInt(nuevoStock);
    el.textContent = s;
    el.style.color = s === 0 ? '#b91c1c' : (s < 20 ? '#b45309' : el.style.color);
    document.getElementById('input-' + id).value = '';
}

function entrada(id) {
    var cantidad = getCantidad(id);
    if (!cantidad || cantidad <= 0) { showAlert('Ingresa una cantidad válida', 'awk'); return; }

    fetch('/inventario/add/' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad: cantidad })
    })
    .then(function(r){ return r.json(); })
    .then(function(d){
        actualizarUI(id, d.nuevo_stock);
        showAlert('+' + cantidad + ' stickers ingresados', 'aok');
    })
    .catch(function(){ showAlert('Error al registrar entrada', 'aer'); });
}

function salida(id) {
    var cantidad = getCantidad(id);
    if (!cantidad || cantidad <= 0) { showAlert('Ingresa una cantidad válida', 'awk'); return; }

    fetch('/inventario/salida/' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ cantidad: cantidad })
    })
    .then(function(r){ return r.json(); })
    .then(function(d){
        if (d.success) {
            actualizarUI(id, d.nuevo_stock);
            showAlert('−' + cantidad + ' stickers retirados', 'aok');
        } else {
            showAlert(d.message || 'Stock insuficiente', 'aer');
        }
    })
    .catch(function(){ showAlert('Error al registrar salida', 'aer'); });
}

// Filtros cards
function filtrarCards(q) {
    var idioma = document.getElementById('filtIdioma').value;
    document.querySelectorAll('#cardsGrid .card').forEach(function(c){
        var mQ = c.dataset.nombre.includes(q.toLowerCase());
        var mI = !idioma || c.dataset.idioma === idioma;
        c.style.display = (mQ && mI) ? '' : 'none';
    });
}
function filtrarIdioma(i) {
    var q = document.getElementById('filtQ').value;
    document.querySelectorAll('#cardsGrid .card').forEach(function(c){
        var mQ = c.dataset.nombre.includes(q.toLowerCase());
        var mI = !i || c.dataset.idioma === i;
        c.style.display = (mQ && mI) ? '' : 'none';
    });
}

// Filtros tabla historial
var hFiltTipo = '', hFiltIdioma = '', hFiltFormato = '';
function filtrarHist(val, campo) {
    if (campo === 'tipo')    hFiltTipo    = val;
    if (campo === 'idioma')  hFiltIdioma  = val;
    if (campo === 'formato') hFiltFormato = val.toLowerCase();
    document.querySelectorAll('#histTbody tr').forEach(function(tr){
        var mT = !hFiltTipo    || tr.dataset.tipo    === hFiltTipo;
        var mI = !hFiltIdioma  || tr.dataset.idioma  === hFiltIdioma;
        var mF = !hFiltFormato || (tr.dataset.formato && tr.dataset.formato.includes(hFiltFormato));
        tr.style.display = (mT && mI && mF) ? '' : 'none';
    });
}
</script>

@endsection

