@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;margin:0;padding:0;}
.pg{padding:1.25rem;background:#f1f5f9;min-height:100vh;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1.25rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.9rem 1rem;}
.kpi-label{font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;}
.kpi-val{font-size:22px;font-weight:700;color:#1e293b;}
.kpi-sub{font-size:11px;color:#94a3b8;margin-top:2px;}
.form-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;margin-bottom:1.1rem;}
.frow{display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:10px;align-items:end;}
@media(max-width:700px){.frow{grid-template-columns:1fr 1fr;}}
.flabel{font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:4px;}
.finput{padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.12);}
.btn-green{padding:9px 16px;background:#16a34a;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;white-space:nowrap;transition:background .15s;}
.btn-green:hover{background:#15803d;}
.btn-red{padding:9px 14px;background:#dc2626;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;white-space:nowrap;transition:background .15s;}
.btn-red:hover{background:#b91c1c;}
.btn-blue{padding:9px 14px;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;white-space:nowrap;transition:background .15s;}
.btn-blue:hover{background:#1d4ed8;}
.section-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:.9rem;}
.sec-title{font-size:15px;font-weight:600;color:#1e293b;display:flex;align-items:center;gap:7px;}
.main-grid{display:grid;grid-template-columns:1fr 340px;gap:14px;margin-bottom:1.25rem;}
@media(max-width:800px){.main-grid{grid-template-columns:1fr;}}
.cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(148px,1fr));gap:10px;align-content:start;}
.card-inv{background:#fff;border:1px solid #e2e8f0;border-radius:11px;padding:.9rem 1rem;cursor:pointer;border-left:4px solid;transition:transform .15s;}
.card-inv:hover{transform:translateY(-2px);}
.card-inv.sel{background:#f0fdf4;}
.c-name{font-size:13px;font-weight:600;color:#1e293b;margin-bottom:2px;line-height:1.3;}
.c-meta{font-size:11px;color:#94a3b8;margin-bottom:6px;}
.c-stock{font-size:20px;font-weight:700;margin-bottom:4px;}
.badge{display:inline-flex;align-items:center;gap:3px;font-size:11px;padding:2px 7px;border-radius:99px;font-weight:600;}
.bd{background:#fee2e2;color:#b91c1c;}
.bw{background:#fef3c7;color:#b45309;}
.bg{background:#dcfce7;color:#15803d;}
.panel{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;display:flex;flex-direction:column;gap:.9rem;}
.p-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;min-height:280px;color:#cbd5e1;font-size:13px;}
.p-title{font-size:15px;font-weight:600;color:#1e293b;}
.p-country{font-size:12px;color:#94a3b8;}
.stock-block{padding:.85rem 1rem;border-radius:9px;border:1px solid;display:flex;align-items:center;justify-content:space-between;}
.stock-num{font-size:26px;font-weight:700;}
.hist-title{font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;}
.hist-list{max-height:140px;overflow-y:auto;display:flex;flex-direction:column;gap:3px;}
.hist-row{display:flex;justify-content:space-between;align-items:center;padding:5px 8px;background:#f8fafc;border-radius:6px;font-size:12px;color:#475569;}
.qi{color:#15803d;font-weight:600;}
.qo{color:#b91c1c;font-weight:600;}
.add-row{display:flex;gap:8px;}
.btn-add{padding:9px 14px;background:#16a34a;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;}
.btn-add:hover{background:#15803d;}
.btn-out{padding:9px 14px;background:#dc2626;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;}
.btn-out:hover{background:#b91c1c;}
.alert-bar{padding:8px 14px;border-radius:8px;font-size:13px;display:none;align-items:center;gap:8px;margin-bottom:.75rem;}
.alert-bar.show{display:flex;}
.aok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
.awk{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.aer{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
hr.div{border:none;border-top:1px solid #f1f5f9;}
.chart-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;}
.chart-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:1.25rem;}
@media(max-width:700px){.chart-grid{grid-template-columns:1fr;}}
.legend{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:8px;}
.leg-item{display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;}
.leg-dot{width:10px;height:10px;border-radius:2px;flex-shrink:0;}
.filters{display:flex;gap:8px;margin-bottom:1rem;flex-wrap:wrap;}

/* Tabla historial global */
.hist-table-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;margin-bottom:1.25rem;}
.hist-table-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:.85rem;flex-wrap:wrap;gap:8px;}
.hist-table{width:100%;border-collapse:collapse;font-size:12px;}
.hist-table th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;padding:7px 10px;border-bottom:2px solid #e2e8f0;text-align:left;white-space:nowrap;}
.hist-table td{padding:7px 10px;border-bottom:1px solid #f1f5f9;color:#374151;vertical-align:middle;}
.hist-table tbody tr:hover td{background:#f8fafc;}
.tipo-pill{display:inline-flex;align-items:center;gap:3px;font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;}
.tipo-entrada{background:#dcfce7;color:#15803d;}
.tipo-salida{background:#fee2e2;color:#b91c1c;}
.motivo-input{padding:5px 8px;border:1px solid #e2e8f0;border-radius:6px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;}
.motivo-input:focus{border-color:#2563eb;}
/* Modal salida */
.modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:50;display:none;align-items:center;justify-content:center;}
.modal-overlay.open{display:flex;}
.modal-box{background:#fff;border-radius:14px;padding:1.5rem;width:100%;max-width:420px;display:flex;flex-direction:column;gap:1rem;box-shadow:0 20px 60px rgba(0,0,0,.2);}
.modal-title{font-size:16px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.modal-close{margin-left:auto;background:none;border:none;cursor:pointer;color:#94a3b8;font-size:18px;line-height:1;}
.modal-close:hover{color:#374151;}
</style>

<div class="pg">

<div id="alertBar" class="alert-bar"></div>

{{-- Modal salida de etiquetas --}}
<div class="modal-overlay" id="modalSalida">
    <div class="modal-box">
        <div class="modal-title">
            📤 Registrar salida de etiquetas
            <button class="modal-close" onclick="cerrarModal()">✕</button>
        </div>
        <div>
            <label class="flabel">Producto seleccionado</label>
            <div id="modalNombre" style="font-size:14px;font-weight:600;color:#0f172a;padding:8px 10px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;"></div>
        </div>
        <div>
            <label class="flabel">Stock actual</label>
            <div id="modalStock" style="font-size:13px;color:#64748b;padding:6px 10px;"></div>
        </div>
        <div>
            <label class="flabel">Cantidad a retirar</label>
            <input type="number" id="cantSalida" class="finput" placeholder="0" min="1">
        </div>
        <div>
            <label class="flabel">Motivo de salida</label>
            <select id="motivoSalida" class="finput">
                <option value="Despacho cliente">Despacho cliente</option>
                <option value="Exportación">Exportación</option>
                <option value="Merma">Merma</option>
                <option value="Ajuste inventario">Ajuste inventario</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;">
            <button class="btn-red" style="flex:1;justify-content:center;" onclick="confirmarSalida()">📤 Confirmar salida</button>
            <button onclick="cerrarModal()" style="flex:1;padding:9px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;background:#f8fafc;color:#475569;">Cancelar</button>
        </div>
    </div>
</div>

{{-- KPIs --}}
@php
    $total    = $inventories->sum('stock');
    $sinStock = $inventories->where('stock', 0)->count();
    $bajo     = $inventories->where('stock', '>', 0)->where('stock', '<', 20)->count();
    $enStock  = $inventories->where('stock', '>=', 20)->count();
@endphp
<div class="kpis">
    <div class="kpi">
        <div class="kpi-label">Total ítems</div>
        <div class="kpi-val">{{ $inventories->count() }}</div>
        <div class="kpi-sub">productos registrados</div>
    </div>
    <div class="kpi">
        <div class="kpi-label">Stock total</div>
        <div class="kpi-val" style="color:#15803d;">{{ $total }}</div>
        <div class="kpi-sub">unidades en inventario</div>
    </div>
    <div class="kpi">
        <div class="kpi-label">Stock bajo</div>
        <div class="kpi-val" style="color:#b45309;">{{ $bajo }}</div>
        <div class="kpi-sub">menos de 20 unidades</div>
    </div>
    <div class="kpi">
        <div class="kpi-label">Sin stock</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $sinStock }}</div>
        <div class="kpi-sub">requieren reposición</div>
    </div>
</div>

{{-- Formulario nueva etiqueta --}}
<div class="form-card">
    <div style="display:flex;align-items:center;gap:9px;margin-bottom:1rem;">
        <div style="width:30px;height:30px;background:#dcfce7;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#15803d;">➕</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:#1e293b;">Nueva etiqueta</div>
            <div style="font-size:11px;color:#94a3b8;">Registra un nuevo ítem de inventario</div>
        </div>
    </div>
    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf
        <div class="frow">
            <div>
                <label class="flabel">Producto</label>
                <select name="product_id" class="finput" required>
                    <option value="">Seleccionar producto</option>
                    @foreach(\App\Models\Product::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="flabel">País</label>
                <select name="pais" class="finput" required>
                    <option value="">País</option>
                    <option value="PERU">Perú</option>
                    <option value="USA">USA</option>
                    <option value="BRASIL">Brasil</option>
                </select>
            </div>
            <div>
                <label class="flabel">Zona</label>
                <select name="zona" class="finput">
                    <option value="">Zona</option>
                    <option value="ZONA_ZUL">Zona Zul</option>
                    <option value="SANTA_LUZIA">Santa Luzia</option>
                </select>
            </div>
            <div>
                <label class="flabel">Stock inicial</label>
                <input type="number" name="cantidad" class="finput" placeholder="0" min="0" required>
            </div>
            <button type="submit" class="btn-green">➕ Crear</button>
        </div>
    </form>
    <hr class="div" style="margin:.85rem 0;">
    <div style="display:flex;gap:14px;flex-wrap:wrap;">
        <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:#94a3b8;"><span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;"></span>Sin stock = 0</span>
        <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:#94a3b8;"><span style="width:7px;height:7px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>Stock bajo &lt; 20</span>
        <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:#94a3b8;"><span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span>En stock ≥ 20</span>
    </div>
</div>

{{-- Header + filtros --}}
<div class="section-hdr">
    <div class="sec-title">📦 Inventario</div>
    <div style="font-size:12px;color:#94a3b8;">{{ $inventories->count() }} ítems</div>
</div>

<div class="filters">
    <input class="finput" style="max-width:200px;" id="filtQ" placeholder="Buscar producto..." oninput="filtrar()">
    <select class="finput" style="width:140px;" id="filtPais" onchange="filtrar()">
        <option value="">Todos los países</option>
        <option value="PERU">Perú</option>
        <option value="USA">USA</option>
        <option value="BRASIL">Brasil</option>
    </select>
    <select class="finput" style="width:150px;" id="filtEstado" onchange="filtrar()">
        <option value="">Todos los estados</option>
        <option value="ok">En stock</option>
        <option value="bajo">Stock bajo</option>
        <option value="sin">Sin stock</option>
    </select>
</div>

{{-- Grid principal --}}
<div class="main-grid">

    <div class="cards-grid" id="cardGrid">
        @foreach($inventories as $inv)
            @php
                $s = $inv->stock;
                $bc = $s == 0 ? '#ef4444' : ($s < 20 ? '#f59e0b' : '#22c55e');
                $sc = $s == 0 ? '#b91c1c' : ($s < 20 ? '#b45309' : '#15803d');
                $badgeClass = $s == 0 ? 'bd' : ($s < 20 ? 'bw' : 'bg');
                $badgeLabel = $s == 0 ? 'Sin stock' : ($s < 20 ? 'Stock bajo' : 'En stock');
            @endphp
            <div class="card-inv"
                style="border-left-color:{{ $bc }};"
                data-nombre="{{ strtolower($inv->product->nombre) }}"
                data-pais="{{ $inv->pais }}"
                data-estado="{{ $s == 0 ? 'sin' : ($s < 20 ? 'bajo' : 'ok') }}"
                onclick="verDetalle({{ $inv->id }}, this)"
            >
                <div class="c-name">{{ $inv->product->nombre }}</div>
                <div class="c-meta">🌎 {{ $inv->pais }} · {{ $inv->zona ?? '—' }}</div>
                <div class="c-stock" style="color:{{ $sc }};">{{ $inv->stock }}</div>
                <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>
        @endforeach
    </div>

    {{-- Panel detalle --}}
    <div class="panel">
        <div class="p-empty" id="pEmpty">
            <span style="font-size:32px;">📦</span>
            <span>Selecciona un producto</span>
        </div>
        <div id="pContent" style="display:none;flex-direction:column;gap:.9rem;"></div>
    </div>

</div>

{{-- Gráficos --}}
<div class="chart-grid">
    <div class="chart-card">
        <div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:.5rem;">Stock por país</div>
        <div class="legend" id="leg1"></div>
        <div style="position:relative;width:100%;height:180px;">
            <canvas id="chartPais" role="img" aria-label="Stock total agrupado por país"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:.5rem;">Estado del inventario</div>
        <div class="legend" id="leg2"></div>
        <div style="position:relative;width:100%;height:180px;">
            <canvas id="chartEstado" role="img" aria-label="Distribución de items por estado de stock"></canvas>
        </div>
    </div>
</div>

{{-- ── TABLA HISTORIAL GLOBAL DE MOVIMIENTOS ── --}}
<div class="hist-table-card">
    <div class="hist-table-hdr">
        <div style="font-size:14px;font-weight:600;color:#1e293b;display:flex;align-items:center;gap:7px;">
            📋 Historial de movimientos
        </div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <select id="filtMovTipo" class="finput" style="width:140px;" onchange="filtrarMovimientos()">
                <option value="">Todos</option>
                <option value="ENTRADA">Solo entradas</option>
                <option value="SALIDA">Solo salidas</option>
            </select>
            <input type="text" id="filtMovProducto" class="finput" style="width:180px;"
                   placeholder="Buscar producto..." oninput="filtrarMovimientos()">
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="hist-table" id="tablaMovimientos">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Producto</th>
                    <th>País / Zona</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Stock tras mov.</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="tbodyMovimientos">
                @php
                    $movimientos = collect();
                    foreach($inventories as $inv) {
                        foreach($inv->movements as $mov) {
                            $movimientos->push([
                                'tipo'       => $mov->tipo,
                                'producto'   => $inv->product->nombre,
                                'pais'       => $inv->pais,
                                'zona'       => $inv->zona ?? '—',
                                'cantidad'   => $mov->cantidad,
                                'motivo'     => $mov->motivo,
                                'stock_post' => $mov->stock_post ?? '—',
                                'fecha'      => $mov->created_at
                                    ? \Carbon\Carbon::parse($mov->created_at)->format('d M Y H:i')
                                    : '—',
                            ]);
                        }
                    }
                    $movimientos = $movimientos->sortByDesc('fecha')->values();
                @endphp

                @forelse($movimientos as $mov)
                <tr data-tipo="{{ $mov['tipo'] }}" data-producto="{{ strtolower($mov['producto']) }}">
                    <td>
                        <span class="tipo-pill {{ $mov['tipo'] === 'ENTRADA' ? 'tipo-entrada' : 'tipo-salida' }}">
                            {{ $mov['tipo'] === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}
                        </span>
                    </td>
                    <td style="font-weight:600;color:#0f172a;">{{ $mov['producto'] }}</td>
                    <td style="color:#64748b;">{{ $mov['pais'] }} · {{ $mov['zona'] }}</td>
                    <td>
                        <span style="font-weight:700;color:{{ $mov['tipo'] === 'ENTRADA' ? '#15803d' : '#b91c1c' }};">
                            {{ $mov['tipo'] === 'ENTRADA' ? '+' : '−' }}{{ $mov['cantidad'] }}
                        </span>
                    </td>
                    <td style="color:#475569;">{{ $mov['motivo'] }}</td>
                    <td style="color:#64748b;">{{ $mov['stock_post'] }}</td>
                    <td style="color:#94a3b8;white-space:nowrap;">{{ $mov['fecha'] }}</td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>

let currentId   = null;
let currentNombre = '';
let currentStock  = 0;

function showAlert(msg, cls) {
    const b = document.getElementById('alertBar');
    b.className = 'alert-bar show ' + cls;
    b.textContent = msg;
    clearTimeout(b._t);
    b._t = setTimeout(function(){ b.className = 'alert-bar'; }, 3500);
}

function verDetalle(id, cardEl) {
    currentId = id;
    document.querySelectorAll('.card-inv').forEach(function(c){ c.classList.remove('sel'); });
    if (cardEl) cardEl.classList.add('sel');

    fetch('/inventario/' + id)
    .then(function(res){ return res.json(); })
    .then(function(data) {
        const inv = data.inventory;
        const s   = inv.stock;
        currentNombre = inv.product.nombre;
        currentStock  = s;

        const bc  = s === 0 ? '#ef4444' : (s < 20 ? '#f59e0b' : '#22c55e');
        const sc  = s === 0 ? '#b91c1c' : (s < 20 ? '#b45309' : '#15803d');
        const bg  = s === 0 ? '#fee2e2' : (s < 20 ? '#fef3c7' : '#dcfce7');
        const badgeClass = s === 0 ? 'bd' : (s < 20 ? 'bw' : 'bg');
        const badgeLabel = s === 0 ? 'Sin stock' : (s < 20 ? 'Stock bajo' : 'En stock');

        const movHtml = data.movements.length ? data.movements.map(function(m){
            return '<div class="hist-row">'
                + '<span>' + m.motivo + '</span>'
                + '<span class="' + (m.tipo === 'ENTRADA' ? 'qi' : 'qo') + '">'
                + (m.tipo === 'ENTRADA' ? '+' : '−') + m.cantidad
                + '</span></div>';
        }).join('') : '<div style="font-size:12px;color:#94a3b8;padding:6px;">Sin movimientos</div>';

        document.getElementById('pEmpty').style.display = 'none';
        const pc = document.getElementById('pContent');
        pc.style.display = 'flex';
        pc.innerHTML =
            '<div>'
            + '<div class="p-title">' + inv.product.nombre + '</div>'
            + '<div class="p-country">🌎 ' + inv.pais + ' · ' + (inv.zona || 'Sin zona') + '</div>'
            + '</div>'
            + '<div class="stock-block" style="background:' + bg + ';border-color:' + bc + '60;">'
            +   '<div>'
            +     '<div class="stock-num" style="color:' + sc + ';">' + s + '</div>'
            +     '<div style="font-size:11px;color:#64748b;">unidades disponibles</div>'
            +   '</div>'
            +   '<span class="badge ' + badgeClass + '">' + badgeLabel + '</span>'
            + '</div>'
            + '<hr class="div">'
            + '<div>'
            +   '<div class="hist-title">Historial de movimientos</div>'
            +   '<div class="hist-list">' + movHtml + '</div>'
            + '</div>'
            + '<hr class="div">'
            + '<div>'
            +   '<div class="hist-title" style="margin-bottom:6px;">Agregar stock</div>'
            +   '<div class="add-row">'
            +     '<input type="number" class="finput" id="cantAdd" placeholder="Cantidad" min="1" style="flex:1;">'
            +     '<button class="btn-add" onclick="agregarStock()">⬆ Entrada</button>'
            +     '<button class="btn-out" onclick="abrirModalSalida()">⬇ Salida</button>'
            +   '</div>'
            + '</div>';
    })
    .catch(function(){ showAlert('Error al cargar el detalle', 'aer'); });
}

function agregarStock() {
    const v = parseInt(document.getElementById('cantAdd') && document.getElementById('cantAdd').value);
    if (!v || v <= 0) { showAlert('Ingresa una cantidad válida', 'awk'); return; }

    fetch('/inventario/add/' + currentId, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ cantidad: v })
    })
    .then(function(){
        showAlert('+' + v + ' unidades agregadas correctamente', 'aok');
        verDetalle(currentId, document.querySelector('.card-inv.sel'));
    })
    .catch(function(){ showAlert('Error al guardar', 'aer'); });
}

function abrirModalSalida() {
    if (!currentId) return;
    document.getElementById('modalNombre').textContent = currentNombre;
    document.getElementById('modalStock').textContent  = 'Stock actual: ' + currentStock + ' unidades';
    document.getElementById('cantSalida').value = '';
    document.getElementById('motivoSalida').value = 'Despacho cliente';
    document.getElementById('modalSalida').classList.add('open');
    setTimeout(function(){ document.getElementById('cantSalida').focus(); }, 100);
}

function cerrarModal() {
    document.getElementById('modalSalida').classList.remove('open');
}

function confirmarSalida() {
    const v = parseInt(document.getElementById('cantSalida').value);
    const motivo = document.getElementById('motivoSalida').value;

    if (!v || v <= 0) { showAlert('Ingresa una cantidad válida', 'awk'); return; }
    if (v > currentStock) {
        showAlert('La cantidad supera el stock disponible (' + currentStock + ')', 'aer');
        return;
    }

    fetch('/inventario/salida/' + currentId, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ cantidad: v, motivo: motivo })
    })
    .then(function(res){ return res.json(); })
    .then(function(){
        cerrarModal();
        showAlert('⬇ ' + v + ' unidades retiradas — ' + motivo, 'aok');
        verDetalle(currentId, document.querySelector('.card-inv.sel'));
        location.reload();
    })
    .catch(function(){ showAlert('Error al registrar salida', 'aer'); });
}

function filtrar() {
    const q = document.getElementById('filtQ').value.toLowerCase();
    const p = document.getElementById('filtPais').value;
    const e = document.getElementById('filtEstado').value;
    document.querySelectorAll('.card-inv').forEach(function(c){
        const matchQ = c.dataset.nombre.includes(q);
        const matchP = !p || c.dataset.pais === p;
        const matchE = !e || c.dataset.estado === e;
        c.style.display = (matchQ && matchP && matchE) ? '' : 'none';
    });
}

function filtrarMovimientos() {
    const tipo     = document.getElementById('filtMovTipo').value;
    const producto = document.getElementById('filtMovProducto').value.toLowerCase();
    document.querySelectorAll('#tbodyMovimientos tr').forEach(function(tr){
        const matchT = !tipo     || tr.dataset.tipo === tipo;
        const matchP = !producto || (tr.dataset.producto && tr.dataset.producto.includes(producto));
        tr.style.display = (matchT && matchP) ? '' : 'none';
    });
}

document.getElementById('modalSalida').addEventListener('click', function(e){
    if (e.target === this) cerrarModal();
});

@php
    $paises     = $inventories->groupBy('pais');
    $paisLabels = $paises->keys()->toJson();
    $paisData   = $paises->map(function($g){ return $g->sum('stock'); })->values()->toJson();
    $sinStockC  = $inventories->where('stock', 0)->count();
    $bajoC      = $inventories->where('stock', '>', 0)->where('stock', '<', 20)->count();
    $enStockC   = $inventories->where('stock', '>=', 20)->count();
@endphp

var paisLabels = {!! $paisLabels !!};
var paisData   = {!! $paisData !!};
var paisColors = ['#16a34a','#3b82f6','#f59e0b','#ef4444'];

new Chart(document.getElementById('chartPais'), {
    type: 'bar',
    data: {
        labels: paisLabels,
        datasets: [{ data: paisData, backgroundColor: paisColors.slice(0, paisLabels.length), borderRadius: 6, borderSkipped: false }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { grid: { display: false } }, y: { grid: { color: '#f1f5f9' } } }
    }
});

document.getElementById('leg1').innerHTML = paisLabels.map(function(p, i){
    return '<span class="leg-item"><span class="leg-dot" style="background:' + paisColors[i] + ';"></span>' + p + ' — ' + paisData[i] + '</span>';
}).join('');

new Chart(document.getElementById('chartEstado'), {
    type: 'doughnut',
    data: {
        labels: ['En stock','Stock bajo','Sin stock'],
        datasets: [{ data: [{{ $enStockC }}, {{ $bajoC }}, {{ $sinStockC }}], backgroundColor: ['#22c55e','#f59e0b','#ef4444'], borderWidth: 2, borderColor: '#fff' }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '65%' }
});

document.getElementById('leg2').innerHTML = [
    { l: 'En stock',   c: '#22c55e', v: {{ $enStockC }} },
    { l: 'Stock bajo', c: '#f59e0b', v: {{ $bajoC }} },
    { l: 'Sin stock',  c: '#ef4444', v: {{ $sinStockC }} }
].map(function(x){
    return '<span class="leg-item"><span class="leg-dot" style="background:' + x.c + ';"></span>' + x.l + ' — ' + x.v + '</span>';
}).join('');

</script>

@endsection