@extends('layouts.app')

@section('content')
@php
    /*
     * Clasificación por stock mínimo cuando el modelo lo tenga disponible:
     * Bajo: stock <= mínimo (incluye cero)
     * Medio: stock > mínimo y <= 2 veces el mínimo
     * Alto: stock > 2 veces el mínimo
     * Si todavía no existe un campo de mínimo, se conserva el estado calculado
     * por el controlador/modelo como alternativa, sin inventar cantidades.
     */
    $materialsOrdenados = collect($materials)->sortByDesc(fn ($m) => (float) ($m->stock ?? 0))->values();
    $clasificarStock = function ($material) {
        $stock = (float) ($material->stock ?? 0);
        $minimo = null;
        foreach (['stock_minimo', 'minimum_stock', 'min_stock', 'stock_min'] as $campo) {
            $valor = data_get($material, $campo);
            if ($valor !== null && is_numeric($valor) && (float) $valor > 0) {
                $minimo = (float) $valor;
                break;
            }
        }
        if ($stock <= 0) return 'bajo';
        if ($minimo !== null) {
            if ($stock <= $minimo) return 'bajo';
            if ($stock <= ($minimo * 2)) return 'medio';
            return 'alto';
        }
        $estado = strtoupper(trim((string) ($material->status ?? '')));
        if (in_array($estado, ['STOCK_MEDIO', 'MEDIO', 'MEDIO_STOCK'], true)) return 'medio';
        if (in_array($estado, ['DISPONIBLE', 'ALTO', 'STOCK_ALTO'], true)) return 'alto';
        return 'bajo';
    };
    $conteosNivel = ['alto' => 0, 'medio' => 0, 'bajo' => 0];
    foreach ($materialsOrdenados as $m) { $conteosNivel[$clasificarStock($m)]++; }
    $totalMaterias = $materialsOrdenados->count();
@endphp

<style>
:root{--rm-bg:#f3f6fb;--rm-surface:#fff;--rm-border:#dce4ef;--rm-ink:#172b45;--rm-muted:#64748b;--rm-blue:#1746b3;--rm-blue-dark:#1e3a5f;--rm-green:#138653;--rm-green-bg:#e8f7ef;--rm-amber:#b77908;--rm-amber-bg:#fff5dc;--rm-red:#c43d3d;--rm-red-bg:#ffeded;--rm-font:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif}
.raw-page{margin:-20px -20px 0;background:var(--rm-bg);min-height:100vh;color:var(--rm-ink);font:13px var(--rm-font)}
.raw-top{height:42px;background:var(--rm-blue-dark);color:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 24px}
.raw-top strong{font-size:14px;letter-spacing:.25px}.raw-top span{font-size:11px;color:#b8cbe5}
.raw-content{padding:20px 22px 28px;max-width:1800px;margin:auto}
.raw-heading{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:17px}
.raw-title{font-size:23px;font-weight:750;letter-spacing:-.45px;color:#142b49}.raw-subtitle{font-size:12px;color:var(--rm-muted);margin-top:4px}
.raw-actions{display:flex;gap:8px;flex-wrap:wrap}.raw-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:9px 13px;border:1px solid #b9c9e2;border-radius:8px;background:#fff;color:#16439d;text-decoration:none;font-weight:650;font-size:12px;white-space:nowrap}.raw-btn.primary{background:var(--rm-blue);border-color:var(--rm-blue);color:#fff}.raw-btn:hover{filter:brightness(.97);color:inherit;text-decoration:none}
.raw-alert{padding:10px 13px;border-radius:8px;margin-bottom:12px;font-size:12px}.raw-alert.ok{background:var(--rm-green-bg);border:1px solid #b9e6ce;color:#176b43}.raw-alert.err{background:var(--rm-red-bg);border:1px solid #f1c4c4;color:#a32c2c}.raw-alert ul{margin:5px 0 0 18px}
.raw-kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:14px}.raw-kpi{background:#fff;border:1px solid var(--rm-border);border-radius:11px;padding:14px 16px;display:flex;align-items:center;gap:12px;min-width:0;box-shadow:0 2px 7px rgba(24,49,83,.035)}.raw-kpi-icon{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;font-size:20px;flex-shrink:0}.raw-kpi-label{font-size:11px;color:var(--rm-muted);font-weight:600}.raw-kpi-value{font-size:25px;line-height:1.15;font-weight:800;color:#172b45;margin-top:2px}.raw-kpi.total .raw-kpi-icon{background:#e8f1ff;color:#2462c4}.raw-kpi.high .raw-kpi-icon{background:var(--rm-green-bg);color:var(--rm-green)}.raw-kpi.medium .raw-kpi-icon{background:var(--rm-amber-bg);color:var(--rm-amber)}.raw-kpi.low .raw-kpi-icon{background:var(--rm-red-bg);color:var(--rm-red)}
.raw-toolbar{background:#fff;border:1px solid var(--rm-border);border-radius:11px;padding:10px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:12px;box-shadow:0 2px 7px rgba(24,49,83,.035)}.raw-search{position:relative;flex:1 1 230px;min-width:190px}.raw-search input{width:100%;height:39px;border:1px solid #d6dfeb;border-radius:8px;padding:0 12px 0 36px;font:12px var(--rm-font);outline:none}.raw-search input:focus,.raw-select:focus{border-color:#6e95df;box-shadow:0 0 0 3px #e8efff}.raw-search span{position:absolute;left:12px;top:9px;color:#647b9b;font-size:17px}.raw-filter-label{font-size:11px;font-weight:700;color:#435570;white-space:nowrap}.raw-filters{display:flex;gap:6px;flex-wrap:wrap}.raw-filter{border:1px solid #d5dfec;background:#fff;color:#33465f;border-radius:20px;padding:8px 11px;font-size:11px;font-weight:700;cursor:pointer;white-space:nowrap}.raw-filter.active{background:var(--rm-blue);border-color:var(--rm-blue);color:#fff}.raw-filter .dot{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:5px}.raw-filter[data-level="alto"] .dot{background:#16a36a}.raw-filter[data-level="medio"] .dot{background:#e6a008}.raw-filter[data-level="bajo"] .dot{background:#dc4545}.raw-filter.active .dot{background:#fff}.raw-sort{display:flex;align-items:center;gap:7px;margin-left:auto;white-space:nowrap}.raw-select{height:37px;border:1px solid #d6dfeb;border-radius:8px;padding:0 10px;background:#fff;color:#33465f;font:12px var(--rm-font)}
.raw-table-wrap{background:#fff;border:1px solid var(--rm-border);border-radius:11px;overflow:hidden;box-shadow:0 3px 10px rgba(24,49,83,.045)}.raw-table-scroll{overflow:auto;max-height:calc(100vh - 390px);min-height:300px}.raw-table{width:100%;border-collapse:separate;border-spacing:0;min-width:1020px}.raw-table thead th{position:sticky;top:0;z-index:2;background:#233f67;color:#fff;text-align:left;padding:12px 13px;font-size:11px;font-weight:700;white-space:nowrap;letter-spacing:.15px}.raw-table tbody td{padding:10px 13px;border-bottom:1px solid #e8edf4;color:#33445c;font-size:12px;vertical-align:middle}.raw-table tbody tr:nth-child(even){background:#f8fafd}.raw-table tbody tr:hover{background:#eef4ff}.raw-code{font:11px Consolas,monospace;color:#64748b;white-space:nowrap}.raw-name{font-weight:750;color:#182f4d;min-width:190px}.raw-provider{max-width:190px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.raw-number{font-weight:800;font-variant-numeric:tabular-nums;color:#172b45;white-space:nowrap}.raw-unit{color:#64748b;white-space:nowrap}.raw-equivalence{white-space:nowrap;color:#52647d}.raw-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 10px;border-radius:18px;font-size:10px;font-weight:800;white-space:nowrap}.raw-badge:before{content:"";width:7px;height:7px;border-radius:50%;background:currentColor}.raw-badge.alto{background:var(--rm-green-bg);color:var(--rm-green)}.raw-badge.medio{background:var(--rm-amber-bg);color:var(--rm-amber)}.raw-badge.bajo{background:var(--rm-red-bg);color:var(--rm-red)}.raw-actions-cell{display:flex;gap:5px;white-space:nowrap}.raw-icon-btn{width:32px;height:30px;display:inline-grid;place-items:center;border:1px solid #dce5f1;background:#f7f9fc;border-radius:7px;color:#244b80;text-decoration:none;font-size:14px}.raw-icon-btn:hover{background:#eaf1ff;color:#1746b3;text-decoration:none}.raw-empty{text-align:center!important;padding:38px 15px!important;color:#718096!important}.raw-table-footer{padding:12px 15px;display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;color:#64748b;font-size:11px}.raw-count strong{color:#1c3556}.raw-pagination{display:flex;align-items:center;gap:5px}.raw-pagination button{border:1px solid #dce5f1;background:#fff;color:#38516f;border-radius:6px;min-width:29px;height:29px;cursor:pointer}.raw-pagination button.active{background:var(--rm-blue);color:#fff;border-color:var(--rm-blue)}.raw-pagination button:disabled{opacity:.4;cursor:default}.raw-note{font-size:10px;color:#7b8ba1;margin-top:8px}
@media(max-width:900px){.raw-kpis{grid-template-columns:repeat(2,minmax(0,1fr))}.raw-toolbar{align-items:stretch}.raw-sort{margin-left:0}.raw-table-scroll{max-height:none}}
@media(max-width:560px){.raw-content{padding:15px 12px}.raw-top{padding:0 13px}.raw-heading{align-items:flex-start}.raw-actions{width:100%}.raw-actions .raw-btn{flex:1}.raw-kpis{gap:7px}.raw-kpi{padding:10px;gap:8px}.raw-kpi-icon{width:34px;height:34px;font-size:16px}.raw-kpi-value{font-size:21px}.raw-filters{width:100%}.raw-filter{flex:1}.raw-sort{width:100%;justify-content:space-between}.raw-select{flex:1}}
</style>

<div class="raw-page">
    <div class="raw-top">
        <strong>DISTAN ERP <span style="color:#8fa8c8;margin:0 8px">|</span> Materia Prima</strong>
        <span>Producción&nbsp; › &nbsp;Inventario</span>
    </div>

    <div class="raw-content">
        <div class="raw-heading">
            <div>
                <div class="raw-title">Control de Materia Prima</div>
                <div class="raw-subtitle">Inventario, niveles de stock y trazabilidad</div>
            </div>
            <div class="raw-actions">
                <a href="{{ route('raw-material-entries.create') }}" class="raw-btn">📥 Entrada de stock</a>
                <a href="{{ route('product-entries.index') }}" class="raw-btn">📦 Entrada Tienda</a>
                <a href="{{ route('raw-materials.create') }}" class="raw-btn primary">＋ Nueva materia prima</a>
            </div>
        </div>

        @if(session('success'))
            <div class="raw-alert ok">✓ {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="raw-alert err"><strong>Se encontraron errores:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <details style="background:#fff;border:1px solid #e7d9b5;border-left:4px solid #d99a19;border-radius:9px;padding:9px 13px;margin-bottom:13px;">
            <summary style="cursor:pointer;font-size:11px;font-weight:750;color:#8b620c;">⚠ Recomendaciones para el control de materia prima</summary>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:10px;margin-top:10px;color:#6d5a35;font-size:11px;line-height:1.5;">
                <div><strong>Verificar antes de seleccionar:</strong> confirma tipo, color y especificación de la materia prima.</div>
                <div><strong>Cantidad = producción real:</strong> registra la cantidad realmente utilizada, sin estimaciones ni redondeos.</div>
                <div><strong>Actualizar inventario:</strong> registra el saldo restante para mantener el stock del sistema alineado con el físico.</div>
                <div><strong>Stock bajo o agotado:</strong> coordina la reposición con el responsable de compras antes de continuar.</div>
            </div>
        </details>

        <div class="raw-kpis">
            <div class="raw-kpi total"><div class="raw-kpi-icon">▦</div><div><div class="raw-kpi-label">Total de materias primas</div><div class="raw-kpi-value">{{ $totalMaterias }}</div></div></div>
            <div class="raw-kpi high"><div class="raw-kpi-icon">▤</div><div><div class="raw-kpi-label">Alto stock</div><div class="raw-kpi-value">{{ $conteosNivel['alto'] }}</div></div></div>
            <div class="raw-kpi medium"><div class="raw-kpi-icon">⚠</div><div><div class="raw-kpi-label">Medio stock</div><div class="raw-kpi-value">{{ $conteosNivel['medio'] }}</div></div></div>
            <div class="raw-kpi low"><div class="raw-kpi-icon">▣</div><div><div class="raw-kpi-label">Bajo stock</div><div class="raw-kpi-value">{{ $conteosNivel['bajo'] }}</div></div></div>
        </div>

        <div class="raw-toolbar">
            <div class="raw-search"><span>⌕</span><input type="search" id="buscarMateria" placeholder="Buscar por código, nombre o proveedor..."></div>
            <span class="raw-filter-label">Nivel de stock:</span>
            <div class="raw-filters">
                <button type="button" class="raw-filter active" data-level="todos">Todos ({{ $totalMaterias }})</button>
                <button type="button" class="raw-filter" data-level="alto"><span class="dot"></span>Alto ({{ $conteosNivel['alto'] }})</button>
                <button type="button" class="raw-filter" data-level="medio"><span class="dot"></span>Medio ({{ $conteosNivel['medio'] }})</button>
                <button type="button" class="raw-filter" data-level="bajo"><span class="dot"></span>Bajo ({{ $conteosNivel['bajo'] }})</button>
            </div>
            <div class="raw-sort"><label class="raw-filter-label" for="ordenStock">Orden:</label><select id="ordenStock" class="raw-select"><option value="desc">Mayor stock</option><option value="asc">Menor stock</option><option value="nombre">Nombre A–Z</option></select></div>
        </div>

        <div class="raw-table-wrap">
            <div class="raw-table-scroll">
                <table class="raw-table" id="tablaMaterias">
                    <thead><tr>
                        <th>Código</th><th>Materia prima</th><th>Proveedor</th><th>Unidad</th><th>Stock actual</th><th>Equivalencia (cajas)</th><th>Nivel</th><th>Acciones</th>
                    </tr></thead>
                    <tbody id="materiasBody">
                    @forelse($materialsOrdenados as $material)
                        @php
                            $nivel = $clasificarStock($material);
                            $stock = (float) ($material->stock ?? 0);
                            $porCaja = (int) ($material->cantidad_por_caja ?? 0);
                            $cajas = $porCaja > 0 ? intdiv((int) floor(max(0, $stock)), $porCaja) : null;
                            $sueltas = $porCaja > 0 ? ((int) floor(max(0, $stock)) % $porCaja) : null;
                        @endphp
                        <tr class="materia-row" data-level="{{ $nivel }}" data-stock="{{ $stock }}" data-name="{{ strtolower($material->name ?? '') }}" data-search="{{ strtolower(($material->code ?? '').' '.($material->name ?? '').' '.($material->supplier ?? '').' '.($material->category ?? '').' '.($material->color ?? '')) }}">
                            <td class="raw-code">{{ $material->code ?? '—' }}</td>
                            <td class="raw-name">{{ $material->name }}</td>
                            <td class="raw-provider" title="{{ $material->supplier ?? '' }}">{{ $material->supplier ?? '—' }}</td>
                            <td class="raw-unit">{{ $material->unit ?? '—' }}</td>
                            <td class="raw-number">{{ number_format($stock, 2) }}</td>
                            <td class="raw-equivalence">
                                @if($porCaja > 0)
                                    {{ number_format($cajas) }} {{ $cajas === 1 ? 'caja' : 'cajas' }}@if($sueltas > 0) <span style="color:#8290a3">+ {{ number_format($sueltas) }} sueltas</span>@endif
                                @else — @endif
                            </td>
                            <td><span class="raw-badge {{ $nivel }}">{{ ucfirst($nivel) }}</span></td>
                            <td><div class="raw-actions-cell">
                                <a class="raw-icon-btn" href="{{ route('raw-materials.edit', $material) }}" title="Editar" aria-label="Editar">✎</a>
                                <a class="raw-icon-btn" href="{{ route('raw-materials.show', $material) }}" title="Ver kardex" aria-label="Ver kardex">▤</a>
                            </div></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="raw-empty">No hay materias primas registradas. Utiliza “Nueva materia prima” para comenzar.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="raw-table-footer">
                <div class="raw-count">Mostrando <strong id="countVisible">{{ $totalMaterias }}</strong> de <strong>{{ $totalMaterias }}</strong> materias primas</div>
                <div class="raw-pagination" id="rawPagination" aria-label="Paginación"></div>
            </div>
        </div>
        <div class="raw-note">La clasificación utiliza el stock mínimo de la materia prima cuando está disponible. Si no existe un mínimo configurado, conserva el estado que entrega el sistema.</div>
    </div>
</div>

<script>
(function () {
    const input = document.getElementById('buscarMateria');
    const body = document.getElementById('materiasBody');
    const order = document.getElementById('ordenStock');
    const count = document.getElementById('countVisible');
    const pagination = document.getElementById('rawPagination');
    if (!input || !body) return;

    let activeLevel = 'todos';
    let currentPage = 1;
    const pageSize = 12;
    let rows = Array.from(body.querySelectorAll('.materia-row'));

    function sortRows() {
        const mode = order.value;
        rows.sort((a, b) => {
            if (mode === 'nombre') return a.dataset.name.localeCompare(b.dataset.name, 'es');
            const diff = Number(a.dataset.stock) - Number(b.dataset.stock);
            return mode === 'asc' ? diff : -diff;
        });
        rows.forEach(row => body.appendChild(row));
    }

    function render() {
        const query = input.value.trim().toLocaleLowerCase('es');
        const filtered = rows.filter(row => {
            const matchesText = (row.dataset.search || '').includes(query);
            const matchesLevel = activeLevel === 'todos' || row.dataset.level === activeLevel;
            return matchesText && matchesLevel;
        });
        const pages = Math.max(1, Math.ceil(filtered.length / pageSize));
        currentPage = Math.min(currentPage, pages);
        const start = (currentPage - 1) * pageSize;
        const visible = new Set(filtered.slice(start, start + pageSize));
        rows.forEach(row => row.style.display = visible.has(row) ? '' : 'none');
        count.textContent = filtered.length ? `${start + 1}–${Math.min(start + pageSize, filtered.length)} (${filtered.length})` : '0';

        pagination.innerHTML = '';
        const addButton = (label, page, disabled, active) => {
            const btn = document.createElement('button');
            btn.type = 'button'; btn.textContent = label; btn.disabled = disabled;
            if (active) btn.classList.add('active');
            btn.addEventListener('click', () => { currentPage = page; render(); });
            pagination.appendChild(btn);
        };
        addButton('‹', Math.max(1, currentPage - 1), currentPage === 1, false);
        for (let p = 1; p <= pages && p <= 5; p++) addButton(String(p), p, false, p === currentPage);
        if (pages > 5) {
            const dots = document.createElement('span'); dots.textContent = '…'; dots.style.padding = '0 3px'; pagination.appendChild(dots);
            addButton(String(pages), pages, false, pages === currentPage);
        }
        addButton('›', Math.min(pages, currentPage + 1), currentPage === pages, false);
    }

    input.addEventListener('input', () => { currentPage = 1; render(); });
    order.addEventListener('change', () => { sortRows(); currentPage = 1; render(); });
    document.querySelectorAll('.raw-filter').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.raw-filter').forEach(b => b.classList.remove('active'));
            button.classList.add('active'); activeLevel = button.dataset.level; currentPage = 1; render();
        });
    });
    sortRows();
    render();
})();
</script>
@endsection
