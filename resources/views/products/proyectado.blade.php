@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#eef1f5;
    --erp-surface:#ffffff;
    --erp-border:#dde2ea;
    --erp-ink:#1c2733;
    --erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;
    --erp-accent-dark:#0a4eb3;
    --erp-danger:#c0312b;
    --erp-danger-bg:#fbe9e8;
    --erp-warn:#b9690e;
    --erp-warn-bg:#fdf1e2;
    --erp-ok:#1c7c4d;
    --erp-ok-bg:#e8f5ee;
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    padding:20px 24px 40px;
    font-size:13px;
    min-height:100vh;
}

/* ── Top bar ── */
.top-bar{
    display:flex;flex-wrap:wrap;justify-content:space-between;
    align-items:center;gap:12px;
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-left:4px solid var(--erp-accent);border-radius:4px;
    padding:14px 18px;margin-bottom:16px;
}
.title{
    font-size:17px;font-weight:700;color:var(--erp-ink);
    display:flex;align-items:center;gap:8px;white-space:nowrap;
}
.title:before{content:"";width:8px;height:8px;background:var(--erp-accent);display:inline-block;}
.btn-link{
    background:#fff;color:var(--erp-accent);border:1px solid var(--erp-accent);
    padding:8px 14px;border-radius:3px;font-size:12px;font-weight:600;
    text-decoration:none;transition:background .15s;white-space:nowrap;
}
.btn-link:hover{background:#eaf0fb;}

/* ── KPIs ── */
.kpi-strip{
    display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));
    gap:12px;margin-bottom:16px;
}
.kpi-card{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:14px 16px;position:relative;overflow:hidden;
}
.kpi-bar{position:absolute;left:0;top:0;bottom:0;width:4px;}
.kpi-label{font-size:10.5px;text-transform:uppercase;letter-spacing:.6px;
    color:var(--erp-ink-muted);font-weight:600;margin-bottom:6px;}
.kpi-value{font-family:var(--font-mono);font-size:24px;font-weight:700;
    color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:11px;color:var(--erp-ink-muted);margin-top:4px;}

/* ── Filtros ── */
.filter-bar{
    display:flex;gap:8px;flex-wrap:wrap;align-items:center;
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:10px 14px;margin-bottom:14px;
}
.filter-bar input,
.filter-bar select{
    padding:7px 10px;border:1px solid var(--erp-border);border-radius:3px;
    font-size:12px;font-family:var(--font-ui);background:#fbfcfe;color:var(--erp-ink);
    outline:none;
}
.filter-bar input{flex:1;min-width:160px;}
.filter-bar input:focus,
.filter-bar select:focus{border-color:var(--erp-accent);outline:2px solid #bcd6f7;outline-offset:0;}
.filter-label{font-size:11px;font-weight:600;color:var(--erp-ink-muted);
    text-transform:uppercase;letter-spacing:.5px;white-space:nowrap;}
.badge-filter{
    padding:5px 12px;border-radius:3px;font-size:11px;font-weight:700;
    cursor:pointer;border:1px solid var(--erp-border);background:#f5f7fa;
    color:var(--erp-ink-muted);transition:.15s;white-space:nowrap;
}
.badge-filter.active-all  {background:var(--erp-accent);color:#fff;border-color:var(--erp-accent);}
.badge-filter.active-crit {background:var(--erp-danger);color:#fff;border-color:var(--erp-danger);}
.badge-filter.active-warn {background:var(--erp-warn);color:#fff;border-color:var(--erp-warn);}
.badge-filter.active-ok   {background:var(--erp-ok);color:#fff;border-color:var(--erp-ok);}
.badge-filter.active-sin  {background:#64748b;color:#fff;border-color:#64748b;}

/* ── Tabla ── */
.table-wrap{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;overflow:hidden;
}
.result-bar{
    display:flex;justify-content:space-between;align-items:center;
    padding:10px 16px;border-bottom:1px solid var(--erp-border);
    font-size:12px;color:var(--erp-ink-muted);
}
.result-bar strong{color:var(--erp-ink);}
table{width:100%;border-collapse:collapse;font-size:12.5px;}
thead th{
    background:#f4f6f9;color:var(--erp-ink-muted);
    font-size:10.5px;font-weight:700;text-transform:uppercase;
    letter-spacing:.5px;padding:10px 12px;
    border-bottom:2px solid var(--erp-border);
    text-align:left;white-space:nowrap;cursor:pointer;
    user-select:none;
}
thead th:hover{background:#eaecf0;color:var(--erp-ink);}
thead th .sort-icon{opacity:.4;margin-left:3px;font-size:10px;}
thead th.sorted .sort-icon{opacity:1;}
tbody tr{border-bottom:1px solid #f0f3f7;transition:background .1s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f7f9fc;}
tbody td{padding:9px 12px;vertical-align:middle;}

/* ── Celdas especiales ── */
.td-name{font-weight:600;color:var(--erp-ink);}
.td-sku{font-family:var(--font-mono);font-size:11px;color:var(--erp-ink-muted);}
.td-num{font-family:var(--font-mono);text-align:right;}
.td-center{text-align:center;}

/* stock pill */
.stock-pill{
    display:inline-block;font-family:var(--font-mono);
    font-weight:700;font-size:13px;padding:2px 8px;border-radius:3px;
}
.sp-ok   {background:var(--erp-ok-bg);   color:var(--erp-ok);}
.sp-warn {background:var(--erp-warn-bg); color:var(--erp-warn);}
.sp-crit {background:var(--erp-danger-bg);color:var(--erp-danger);}
.sp-zero {background:#f1f5f9;color:#64748b;}

/* cobertura badge */
.cob-badge{
    display:inline-flex;align-items:center;gap:4px;
    font-size:11.5px;font-weight:700;padding:3px 9px;
    border-radius:3px;white-space:nowrap;
}
.cob-ok   {background:var(--erp-ok-bg);   color:var(--erp-ok);}
.cob-warn {background:var(--erp-warn-bg); color:var(--erp-warn);}
.cob-crit {background:var(--erp-danger-bg);color:var(--erp-danger);}
.cob-none {background:#f1f5f9;color:#94a3b8;font-style:italic;}

/* proyectado bar */
.proy-wrap{display:flex;align-items:center;gap:6px;}
.proy-bar-bg{flex:1;height:6px;background:#eaecf0;border-radius:3px;overflow:hidden;min-width:40px;}
.proy-bar-fill{height:100%;border-radius:3px;background:var(--erp-accent);transition:width .3s;}
.proy-num{font-family:var(--font-mono);font-size:12px;font-weight:600;
    color:var(--erp-ink);white-space:nowrap;min-width:28px;text-align:right;}

/* estado dot */
.estado-dot{
    display:inline-flex;align-items:center;gap:5px;
    font-size:11px;font-weight:700;
}
.dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.dot-ok   {background:var(--erp-ok);}
.dot-warn {background:var(--erp-warn);}
.dot-crit {background:var(--erp-danger);}
.dot-none {background:#94a3b8;}

/* sin movimiento tag */
.sin-mov{
    font-size:10.5px;color:#94a3b8;font-style:italic;
}

/* rotación chip */
.rot-chip{
    display:inline-block;font-size:10px;font-weight:700;
    padding:2px 7px;border-radius:3px;text-transform:uppercase;letter-spacing:.3px;
}
.rot-muy-alta{background:var(--erp-danger-bg);color:var(--erp-danger);}
.rot-alta    {background:var(--erp-warn-bg);  color:var(--erp-warn);}
.rot-media   {background:#eaf0f9;             color:var(--erp-accent-dark);}
.rot-baja    {background:var(--erp-ok-bg);    color:var(--erp-ok);}

/* empty */
.empty-row td{
    padding:40px;text-align:center;
    color:var(--erp-ink-muted);font-style:italic;
}

/* ── Leyenda ── */
.legend{
    display:flex;flex-wrap:wrap;gap:14px;
    margin-top:12px;font-size:11.5px;color:var(--erp-ink-muted);
    padding:10px 14px;background:var(--erp-surface);
    border:1px solid var(--erp-border);border-radius:4px;
}
.leg{display:flex;align-items:center;gap:5px;}
</style>

<div class="page">

{{-- ── PHP: cálculos ── --}}
@php
    $totalProds  = $products->count();
    $criticos    = $products->filter(fn($p) => $p->cobertura_dias !== null && $p->cobertura_dias <= 7)->count();
    $enAlerta    = $products->filter(fn($p) => $p->cobertura_dias !== null && $p->cobertura_dias > 7 && $p->cobertura_dias <= 20)->count();
    $estables    = $products->filter(fn($p) => $p->cobertura_dias !== null && $p->cobertura_dias > 20)->count();
    $sinMov      = $products->filter(fn($p) => $p->ventas_diarias == 0)->count();
    $maxProy7    = $products->max('proyectado_7d') ?: 1;
    $maxProy30   = $products->max('proyectado_30d') ?: 1;
@endphp

{{-- ── Top bar ── --}}
<div class="top-bar">
    <div class="title">Proyectado de Stock — Últimos 60 días</div>
    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <a href="{{ route('products.index') }}" class="btn-link">← Catálogo</a>
        <span style="font-size:11px;color:var(--erp-ink-muted);">
            Base: órdenes completadas · ventana 60 días
        </span>
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpi-strip">
    <div class="kpi-card">
        <div class="kpi-bar" style="background:var(--erp-accent);"></div>
        <div class="kpi-label">Total productos</div>
        <div class="kpi-value">{{ $totalProds }}</div>
        <div class="kpi-sub">en catálogo activo</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-bar" style="background:var(--erp-danger);"></div>
        <div class="kpi-label">Cobertura crítica</div>
        <div class="kpi-value" style="color:var(--erp-danger);">{{ $criticos }}</div>
        <div class="kpi-sub">≤ 7 días de stock</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-bar" style="background:var(--erp-warn);"></div>
        <div class="kpi-label">En alerta</div>
        <div class="kpi-value" style="color:var(--erp-warn);">{{ $enAlerta }}</div>
        <div class="kpi-sub">8 – 20 días de stock</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-bar" style="background:var(--erp-ok);"></div>
        <div class="kpi-label">Estables</div>
        <div class="kpi-value" style="color:var(--erp-ok);">{{ $estables }}</div>
        <div class="kpi-sub">> 20 días de stock</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-bar" style="background:#64748b;"></div>
        <div class="kpi-label">Sin movimiento</div>
        <div class="kpi-value" style="color:#64748b;">{{ $sinMov }}</div>
        <div class="kpi-sub">sin ventas en 60 días</div>
    </div>
</div>

{{-- ── Filtros ── --}}
<div class="filter-bar">
    <span class="filter-label">Filtros:</span>

    <input type="text" id="fSearch"
           placeholder="Buscar producto o SKU..."
           oninput="aplicarFiltros()">

    <select id="fCategoria" onchange="aplicarFiltros()">
        <option value="">Todas las categorías</option>
        @foreach($categories as $cat)
            <option value="{{ strtolower($cat->nombre) }}">{{ $cat->nombre }}</option>
        @endforeach
    </select>

    <select id="fRotacion" onchange="aplicarFiltros()">
        <option value="">Toda rotación</option>
        <option value="muy_alta">Muy alta</option>
        <option value="alta">Alta</option>
        <option value="media">Media</option>
        <option value="baja">Baja</option>
    </select>

    <span class="filter-label" style="margin-left:4px;">Estado:</span>
    <button class="badge-filter active-all"  id="btn-all"  onclick="setEstado('all')">Todos</button>
    <button class="badge-filter active-crit" id="btn-crit" onclick="setEstado('crit')" style="opacity:.5;">Crítico</button>
    <button class="badge-filter active-warn" id="btn-warn" onclick="setEstado('warn')" style="opacity:.5;">Alerta</button>
    <button class="badge-filter active-ok"   id="btn-ok"   onclick="setEstado('ok')"   style="opacity:.5;">Estable</button>
    <button class="badge-filter active-sin"  id="btn-sin"  onclick="setEstado('sin')"  style="opacity:.5;">Sin mov.</button>
</div>

{{-- ── Tabla ── --}}
<div class="table-wrap">
    <div class="result-bar">
        <span>Mostrando <strong id="countVisible">{{ $totalProds }}</strong> de <strong>{{ $totalProds }}</strong> productos</span>
        <span style="font-size:11px;">Proyectado basado en promedio diario de últimos 60 días</span>
    </div>

    <div style="overflow-x:auto;">
    <table id="tablaProyectado">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Producto <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(1)">SKU <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(2)">Categoría <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(3)">Rotación <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(4)" style="text-align:right;">Stock actual <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(5)" style="text-align:right;">Mín. <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(6)" style="text-align:right;">Vtas/día <span class="sort-icon">↕</span></th>
                <th onclick="sortTable(7)">Cobertura <span class="sort-icon">↕</span></th>
                <th>Proyectado 7 días</th>
                <th>Proyectado 30 días</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody id="tablaBody">

        @forelse($products as $p)
        @php
            // Estado de cobertura
            if ($p->ventas_diarias == 0) {
                $estadoKey = 'sin';
                $estadoHtml = '<span class="estado-dot"><span class="dot dot-none"></span>Sin movimiento</span>';
                $cobHtml    = '<span class="cob-none">— sin datos</span>';
            } elseif ($p->cobertura_dias <= 7) {
                $estadoKey = 'crit';
                $estadoHtml = '<span class="estado-dot"><span class="dot dot-crit"></span>Crítico</span>';
                $cobHtml    = '<span class="cob-badge cob-crit">🔴 '.$p->cobertura_dias.' días</span>';
            } elseif ($p->cobertura_dias <= 20) {
                $estadoKey = 'warn';
                $estadoHtml = '<span class="estado-dot"><span class="dot dot-warn"></span>Alerta</span>';
                $cobHtml    = '<span class="cob-badge cob-warn">🟡 '.$p->cobertura_dias.' días</span>';
            } else {
                $estadoKey = 'ok';
                $estadoHtml = '<span class="estado-dot"><span class="dot dot-ok"></span>Estable</span>';
                $cobHtml    = '<span class="cob-badge cob-ok">🟢 '.$p->cobertura_dias.' días</span>';
            }

            // Stock pill
            if ($p->stock == 0) {
                $spClass = 'sp-zero';
            } elseif ($p->stock <= $p->stock_minimo) {
                $spClass = 'sp-crit';
            } elseif ($p->stock <= $p->stock_minimo * 2) {
                $spClass = 'sp-warn';
            } else {
                $spClass = 'sp-ok';
            }

            // Rotación chip
            $rotMap = [
                'MUY_ALTA' => ['cls'=>'rot-muy-alta','txt'=>'Muy alta'],
                'ALTA'     => ['cls'=>'rot-alta',     'txt'=>'Alta'],
                'MEDIA'    => ['cls'=>'rot-media',    'txt'=>'Media'],
                'BAJA'     => ['cls'=>'rot-baja',     'txt'=>'Baja'],
            ];
            $rot = $rotMap[$p->rotacion] ?? ['cls'=>'rot-baja','txt'=>$p->rotacion ?? '—'];

            // Barras proyectado
            $pct7  = $maxProy7  > 0 ? round(min(100, $p->proyectado_7d  / $maxProy7  * 100)) : 0;
            $pct30 = $maxProy30 > 0 ? round(min(100, $p->proyectado_30d / $maxProy30 * 100)) : 0;
        @endphp

        <tr
            data-nombre="{{ strtolower($p->nombre) }}"
            data-sku="{{ strtolower($p->sku ?? '') }}"
            data-categoria="{{ strtolower($p->categoria ?? '') }}"
            data-rotacion="{{ strtolower(str_replace('_','',$p->rotacion ?? '')) }}"
            data-estado="{{ $estadoKey }}"
            data-cobertura="{{ $p->cobertura_dias ?? 9999 }}"
            data-stock="{{ $p->stock }}"
        >
            <td class="td-name">{{ $p->nombre }}</td>
            <td class="td-sku">{{ $p->sku ?? '—' }}</td>
            <td>{{ $p->categoria ?? '—' }}</td>
            <td><span class="rot-chip {{ $rot['cls'] }}">{{ $rot['txt'] }}</span></td>
            <td class="td-num">
                <span class="stock-pill {{ $spClass }}">{{ number_format($p->stock) }}</span>
            </td>
            <td class="td-num" style="color:var(--erp-ink-muted);">
                {{ number_format($p->stock_minimo ?? 0) }}
            </td>
            <td class="td-num">
                @if($p->ventas_diarias > 0)
                    {{ number_format($p->ventas_diarias, 1) }}
                @else
                    <span class="sin-mov">0.0</span>
                @endif
            </td>
            <td class="td-center">{!! $cobHtml !!}</td>
            <td>
                <div class="proy-wrap">
                    <div class="proy-bar-bg">
                        <div class="proy-bar-fill" style="width:{{ $pct7 }}%;"></div>
                    </div>
                    <span class="proy-num">{{ number_format($p->proyectado_7d) }}</span>
                </div>
            </td>
            <td>
                <div class="proy-wrap">
                    <div class="proy-bar-bg">
                        <div class="proy-bar-fill" style="width:{{ $pct30 }}%;background:#7c3aed;"></div>
                    </div>
                    <span class="proy-num">{{ number_format($p->proyectado_30d) }}</span>
                </div>
            </td>
            <td>{!! $estadoHtml !!}</td>
        </tr>

        @empty
        <tr class="empty-row">
            <td colspan="11">No hay productos registrados.</td>
        </tr>
        @endforelse

        </tbody>
    </table>
    </div>
</div>

{{-- ── Leyenda ── --}}
<div class="legend">
    <span class="leg"><span class="dot dot-crit"></span>Crítico: cobertura ≤ 7 días</span>
    <span class="leg"><span class="dot dot-warn"></span>Alerta: cobertura 8–20 días</span>
    <span class="leg"><span class="dot dot-ok"></span>Estable: cobertura > 20 días</span>
    <span class="leg"><span class="dot dot-none"></span>Sin movimiento: sin ventas en 60 días</span>
    <span class="leg" style="margin-left:auto;font-style:italic;">
        Proyectado = promedio diario × 7 ó 30 días · Stock mín. = umbral de reposición
    </span>
</div>

</div>

<script>
var estadoActivo = 'all';
var sortDir = {};

function setEstado(e) {
    estadoActivo = e;
    ['all','crit','warn','ok','sin'].forEach(function(k){
        var btn = document.getElementById('btn-'+k);
        btn.style.opacity = (k === e) ? '1' : '.5';
    });
    aplicarFiltros();
}

function aplicarFiltros() {
    var q    = document.getElementById('fSearch').value.toLowerCase();
    var cat  = document.getElementById('fCategoria').value;
    var rot  = document.getElementById('fRotacion').value.replace('_','');
    var rows = document.querySelectorAll('#tablaBody tr[data-nombre]');
    var visible = 0;

    rows.forEach(function(tr){
        var nombre    = tr.dataset.nombre    || '';
        var sku       = tr.dataset.sku       || '';
        var categoria = tr.dataset.categoria || '';
        var rotacion  = tr.dataset.rotacion  || '';
        var estado    = tr.dataset.estado    || '';

        var mQ   = !q   || nombre.includes(q) || sku.includes(q);
        var mCat = !cat || categoria === cat;
        var mRot = !rot || rotacion === rot;
        var mEst = estadoActivo === 'all' || estado === estadoActivo;

        var show = mQ && mCat && mRot && mEst;
        tr.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('countVisible').textContent = visible;
}

function sortTable(colIdx) {
    var tbody = document.getElementById('tablaBody');
    var rows  = Array.from(tbody.querySelectorAll('tr[data-nombre]'));
    var dir   = (sortDir[colIdx] === 'asc') ? 'desc' : 'asc';
    sortDir   = {};
    sortDir[colIdx] = dir;

    // Marcar columna
    document.querySelectorAll('thead th').forEach(function(th, i){
        th.classList.toggle('sorted', i === colIdx);
        var icon = th.querySelector('.sort-icon');
        if (icon) icon.textContent = i === colIdx ? (dir === 'asc' ? '↑' : '↓') : '↕';
    });

    rows.sort(function(a, b){
        var aVal = a.cells[colIdx] ? a.cells[colIdx].textContent.trim() : '';
        var bVal = b.cells[colIdx] ? b.cells[colIdx].textContent.trim() : '';

        // Numérico si ambos son número
        var aNum = parseFloat(aVal.replace(/[^0-9.\-]/g,''));
        var bNum = parseFloat(bVal.replace(/[^0-9.\-]/g,''));
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return dir === 'asc' ? aNum - bNum : bNum - aNum;
        }
        return dir === 'asc'
            ? aVal.localeCompare(bVal, 'es')
            : bVal.localeCompare(aVal, 'es');
    });

    rows.forEach(function(r){ tbody.appendChild(r); });
}
</script>

@endsection

