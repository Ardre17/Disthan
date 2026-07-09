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
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}

.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}
.erp-breadcrumb a{color:#7eb8f7;text-decoration:none;}

.body{padding:1.1rem;}

.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}

.btn{padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s;border:none;cursor:pointer;}
.btn-primary{background:var(--erp-accent);color:#fff;}
.btn-primary:hover{background:var(--erp-accent-dark);color:#fff;}
.btn-ok{background:var(--erp-ok);color:#fff;}
.btn-ok:hover{background:#155f3a;color:#fff;}
.btn-ghost{background:#fff;color:var(--erp-ink-muted);border:1px solid var(--erp-border);}
.btn-ghost:hover{background:#f4f6f9;}

/* KPIs */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:26px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:22px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* Layout */
.main-layout{display:grid;grid-template-columns:1fr 320px;gap:14px;align-items:start;}
@media(max-width:960px){.main-layout{grid-template-columns:1fr;}}

/* Cards */
.erp-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;margin-bottom:14px;}
.erp-card-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.65rem 1rem;display:flex;align-items:center;justify-content:space-between;gap:8px;}
.erp-card-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:6px;}
.erp-card-body{padding:1rem;}

/* Info rows */
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;}
@media(max-width:500px){.info-grid{grid-template-columns:1fr;}}
.info-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:12px;color:var(--erp-ink-muted);}
.info-row:last-child{border-bottom:none;}
.info-val{font-weight:600;color:var(--erp-ink);text-align:right;}
.info-col{padding:0 10px;border-right:1px solid #f1f5f9;}
.info-col:last-child{border-right:none;}

/* Stock hero */
.stock-hero{
    padding:1.1rem;
    border-radius:4px;
    display:flex;align-items:center;justify-content:space-between;
    margin-bottom:12px;
}
.stock-hero-num{font-family:var(--font-mono);font-size:36px;font-weight:900;line-height:1;}
.stock-hero-label{font-size:11px;color:var(--erp-ink-muted);margin-top:3px;}

/* Barra de stock */
.stock-bar-wrap{margin-bottom:12px;}
.stock-bar-labels{display:flex;justify-content:space-between;font-size:10px;color:var(--erp-ink-muted);margin-bottom:4px;}
.stock-bar{height:8px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.stock-bar-fill{height:100%;border-radius:99px;transition:width .4s;}

/* Status badge */
.status-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:3px 8px;border-radius:3px;white-space:nowrap;}
.sb-ok   {background:var(--erp-ok-bg);   color:var(--erp-ok);   border:1px solid #b7dfca;}
.sb-warn {background:var(--erp-warn-bg); color:var(--erp-warn); border:1px solid #f9d5a3;}
.sb-low  {background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}

/* Formulario entrada */
.field{display:flex;flex-direction:column;gap:3px;margin-bottom:10px;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.finput,.fselect,.ftarea{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus,.ftarea:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.ftarea{resize:vertical;min-height:70px;}
.finput-qty{padding:10px;border:1px solid #b7dfca;border-radius:3px;font-size:22px;font-weight:800;text-align:center;outline:none;width:100%;font-family:var(--font-mono);color:var(--erp-ok);background:var(--erp-ok-bg);transition:border-color .15s;}
.finput-qty:focus{border-color:var(--erp-ok);box-shadow:0 0 0 2px rgba(28,124,77,.1);}

/* Tabla historial */
.hist-table{width:100%;border-collapse:collapse;font-size:12px;}
.hist-table th{background:#f4f6f9;color:var(--erp-ink-muted);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;text-align:left;border-bottom:2px solid var(--erp-border);}
.hist-table td{padding:8px 10px;border-bottom:1px solid #f1f5f9;color:var(--erp-ink);vertical-align:middle;}
.hist-table tr:hover td{background:#f9fafb;}
.hist-table tfoot td{background:#f4f6f9;font-weight:700;color:var(--erp-accent);border-top:2px solid var(--erp-border);}

.tipo-entrada{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:3px;background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.tipo-salida{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:3px;background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}

/* Producciones */
.prod-row{display:flex;align-items:center;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:12px;}
.prod-row:last-child{border-bottom:none;}
.prod-num{font-family:var(--font-mono);font-weight:700;color:var(--erp-accent);}

/* Alert */
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:9px 14px;font-size:12px;font-weight:500;margin-bottom:.85rem;display:flex;align-items:center;gap:8px;}
.alert-err{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;border-radius:4px;padding:9px 14px;font-size:12px;margin-bottom:.85rem;}

/* Paginador */
.pager{display:flex;gap:4px;align-items:center;padding:10px 0 2px;flex-wrap:wrap;}
.pager a,.pager span{padding:4px 10px;border:1px solid var(--erp-border);border-radius:3px;font-size:11px;text-decoration:none;color:var(--erp-ink-muted);}
.pager a:hover{background:#f4f6f9;}
.pager .active-page{background:var(--erp-accent);color:#fff;border-color:var(--erp-accent);}
.pager .disabled{color:#d0d0d0;cursor:default;}
</style>

<div class="page">

{{-- Top bar --}}
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Materia Prima</div>
    </div>
    <span class="erp-breadcrumb">
        <a href="{{ route('raw-materials.index') }}">Materia Prima</a>
        › {{ $raw_material->name }}
    </span>
</div>

<div class="body">

{{-- Alertas --}}
@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert-err">
    ⚠️ <strong>Error:</strong>
    <ul style="margin:.4rem 0 0 1rem;padding:0;">
        @foreach($errors->all() as $e)<li style="font-size:11px;">{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

{{-- Header --}}
<div class="page-hdr">
    <div>
        <div class="page-title">{{ $raw_material->name }}</div>
        <div class="page-sub">
            Código: <strong>{{ $raw_material->code }}</strong> ·
            Categoría: {{ $raw_material->category ?? '—' }} ·
            Proveedor: {{ $raw_material->supplier ?? '—' }}
        </div>
    </div>
    <div style="display:flex;gap:7px;flex-wrap:wrap;">
        <a href="{{ route('raw-materials.edit', $raw_material) }}" class="btn btn-ghost">✏️ Editar</a>
        <a href="{{ route('raw-materials.index') }}" class="btn btn-ghost">← Volver</a>
    </div>
</div>

{{-- KPIs --}}
@php
    $statusClass = match($raw_material->status) {
        'DISPONIBLE' => 'var(--erp-ok)',
        'STOCK_BAJO' => '#f59e0b',
        default      => 'var(--erp-danger)',
    };
    $pct = $raw_material->minimum_stock > 0
        ? min(100, round(($raw_material->stock / ($raw_material->minimum_stock * 2)) * 100))
        : 100;
    $ratio = $totalEntradas > 0
        ? round(($totalConsumido / $totalEntradas) * 100, 1)
        : 0;
@endphp
<div class="kpis">
    <div class="kpi" style="border-left-color:{{ $statusClass }};">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Stock actual</div>
        <div class="kpi-val" style="color:{{ $statusClass }};">{{ number_format($raw_material->stock) }}</div>
        <div class="kpi-sub">{{ $raw_material->unit }}</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);">
        <div class="kpi-icon">📥</div>
        <div class="kpi-label">Total ingresado</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ number_format($totalEntradas) }}</div>
        <div class="kpi-sub">{{ $raw_material->unit }} acumulado</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-danger);">
        <div class="kpi-icon">🏭</div>
        <div class="kpi-label">Total consumido</div>
        <div class="kpi-val" style="color:var(--erp-danger);">{{ number_format($totalConsumido) }}</div>
        <div class="kpi-sub">en producción finalizada</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">📊</div>
        <div class="kpi-label">% consumido</div>
        <div class="kpi-val" style="color:var(--erp-accent);">{{ $ratio }}%</div>
        <div class="kpi-sub">del total ingresado</div>
    </div>
</div>

{{-- Layout principal --}}
<div class="main-layout">

    {{-- ── COLUMNA IZQUIERDA ── --}}
    <div>

        {{-- Datos del material --}}
        <div class="erp-card">
            <div class="erp-card-hdr">
                <div class="erp-card-title">📋 Datos del material</div>
                @php
                    $badgeClass = match($raw_material->status) {
                        'DISPONIBLE' => 'sb-ok',
                        'STOCK_BAJO' => 'sb-warn',
                        default      => 'sb-low',
                    };
                    $badgeLabel = match($raw_material->status) {
                        'DISPONIBLE' => '✅ Disponible',
                        'STOCK_BAJO' => '⚠️ Stock bajo',
                        default      => '🔴 Agotado',
                    };
                @endphp
                <span class="status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>
            <div class="erp-card-body">

                {{-- Stock hero --}}
                <div class="stock-hero" style="background:{{ $raw_material->status === 'DISPONIBLE' ? 'var(--erp-ok-bg)' : ($raw_material->status === 'STOCK_BAJO' ? 'var(--erp-warn-bg)' : 'var(--erp-danger-bg)') }};">
                    <div>
                        <div class="stock-hero-num" style="color:{{ $statusClass }};">
                            {{ number_format($raw_material->stock) }}
                        </div>
                        <div class="stock-hero-label">{{ $raw_material->unit }} disponibles en inventario</div>
                    </div>
                    <div style="font-size:40px;opacity:.2;">📦</div>
                </div>

                {{-- Barra de nivel --}}
                <div class="stock-bar-wrap">
                    <div class="stock-bar-labels">
                        <span>0</span>
                        <span style="color:var(--erp-warn);">Mínimo: {{ $raw_material->minimum_stock }}</span>
                        <span>{{ $raw_material->minimum_stock * 2 }}</span>
                    </div>
                    <div class="stock-bar">
                        <div class="stock-bar-fill" style="width:{{ $pct }}%;background:{{ $statusClass }};"></div>
                    </div>
                </div>

                {{-- Info grid --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;">
                    <div class="info-col">
                        <div class="info-row"><span>Código</span><span class="info-val" style="font-family:var(--font-mono);">{{ $raw_material->code }}</span></div>
                        <div class="info-row"><span>Categoría</span><span class="info-val">{{ $raw_material->category ?? '—' }}</span></div>
                        <div class="info-row"><span>Unidad</span><span class="info-val">{{ $raw_material->unit }}</span></div>
                    </div>
                    <div class="info-col">
                        <div class="info-row"><span>Proveedor</span><span class="info-val">{{ $raw_material->supplier ?? '—' }}</span></div>
                        <div class="info-row"><span>Color</span><span class="info-val">{{ $raw_material->color ?? '—' }}</span></div>
                        <div class="info-row"><span>Stock mínimo</span><span class="info-val">{{ $raw_material->minimum_stock }}</span></div>
                    </div>
                </div>

                @if($raw_material->notes)
                <div style="margin-top:10px;background:#f8fafc;border:1px solid var(--erp-border);border-radius:3px;padding:8px 10px;font-size:12px;color:var(--erp-ink-muted);">
                    📝 {{ $raw_material->notes }}
                </div>
                @endif

            </div>
        </div>

        {{-- Historial de entradas --}}
        <div class="erp-card">
            <div class="erp-card-hdr">
                <div class="erp-card-title">📥 Historial de entradas</div>
                <span style="font-size:11px;color:var(--erp-ink-muted);">{{ $entradas->total() }} registros</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="hist-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th style="text-align:right;">Cantidad</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                        <tr>
                            <td style="white-space:nowrap;color:var(--erp-ink-muted);">
                                {{ $entrada->created_at->format('d/m/Y') }}
                            </td>
                            {{-- 👉 AJUSTA: si tu campo se llama distinto a 'supplier' --}}
                            <td>{{ $entrada->supplier ?? '—' }}</td>
                            {{-- 👉 AJUSTA: si tu campo se llama distinto a 'quantity' --}}
                            <td style="text-align:right;">
                                <span class="tipo-entrada">+{{ number_format($entrada->quantity) }} {{ $raw_material->unit }}</span>
                            </td>
                            {{-- 👉 AJUSTA: si tu campo se llama distinto a 'observation' --}}
                            <td style="color:var(--erp-ink-muted);font-size:11px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $entrada->observation ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:24px;color:#94a3b8;">
                                📭 Sin entradas registradas aún
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($entradas->total() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align:right;color:var(--erp-ink-muted);">TOTAL INGRESADO</td>
                            <td style="text-align:right;">{{ number_format($totalEntradas) }} {{ $raw_material->unit }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- Paginador --}}
            @if($entradas->hasPages())
            <div style="padding:10px 14px;border-top:1px solid var(--erp-border);">
                <div class="pager">
                    @if($entradas->onFirstPage())
                        <span class="disabled">‹</span>
                    @else
                        <a href="{{ $entradas->previousPageUrl() }}">‹</a>
                    @endif

                    @foreach($entradas->getUrlRange(max(1,$entradas->currentPage()-2), min($entradas->lastPage(),$entradas->currentPage()+2)) as $page => $url)
                        @if($page == $entradas->currentPage())
                            <span class="active-page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($entradas->hasMorePages())
                        <a href="{{ $entradas->nextPageUrl() }}">›</a>
                    @else
                        <span class="disabled">›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Órdenes de producción donde se usó --}}
        @if($produccionesUsadas->count())
        <div class="erp-card">
            <div class="erp-card-hdr">
                <div class="erp-card-title">🏭 Usado en producción</div>
                <span style="font-size:11px;color:var(--erp-ink-muted);">Últimas {{ $produccionesUsadas->count() }} órdenes</span>
            </div>
            <div class="erp-card-body">
                @foreach($produccionesUsadas as $prod)
                @php
                    $prodColor = $prod->status === 'FINALIZADA' ? 'var(--erp-ok)' : ($prod->status === 'EN_PROCESO' ? 'var(--erp-warn)' : '#94a3b8');
                @endphp
                <div class="prod-row">
                    <div>
                        <span class="prod-num">{{ $prod->number }}</span>
                        <span style="font-size:11px;color:var(--erp-ink-muted);margin-left:6px;">
                            {{ optional($prod->created_at)->format('d/m/Y') }}
                        </span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:11px;color:var(--erp-danger);font-weight:600;">
                            −{{ number_format($prod->consumed_quantity) }} {{ $raw_material->unit }}
                        </span>
                        <span style="font-size:10px;font-weight:700;padding:2px 7px;border-radius:3px;background:#f4f6f9;color:{{ $prodColor }};">
                            {{ $prod->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- /.left --}}

    {{-- ── COLUMNA DERECHA ── --}}
    <div>

        {{-- Formulario de entrada --}}
        <div class="erp-card">
            <div class="erp-card-hdr" style="background:#e8f5ee;border-color:#b7dfca;">
                <div class="erp-card-title" style="color:var(--erp-ok);">📥 Registrar entrada</div>
            </div>
            <div class="erp-card-body">
                {{-- 👉 AJUSTA: cambia la ruta si la tuya se llama distinto --}}
                <form method="POST" action="{{ route('raw-material-entries.store') }}">
                    @csrf
                    <input type="hidden" name="raw_material_id" value="{{ $raw_material->id }}">

                    <div class="field">
                        <label class="flabel">Cantidad <span style="color:var(--erp-danger);">*</span></label>
                        <input type="number" step="0.01" name="quantity"
                            class="finput-qty" placeholder="0" required
                            value="{{ old('quantity') }}">
                        <span style="font-size:10px;color:#94a3b8;margin-top:2px;">{{ $raw_material->unit }}</span>
                    </div>

                    <div class="field">
                        <label class="flabel">Proveedor <span style="color:var(--erp-danger);">*</span></label>
                        <input type="text" name="supplier" class="finput"
                            value="{{ old('supplier', $raw_material->supplier) }}"
                            placeholder="Nombre del proveedor" required>
                    </div>

                    <div class="field">
                        <label class="flabel">Observación</label>
                        <textarea name="observation" class="ftarea"
                            placeholder="Número de guía, lote, condiciones...">{{ old('observation') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-ok" style="width:100%;justify-content:center;">
                        📥 Registrar entrada
                    </button>
                </form>
            </div>
        </div>

        {{-- Resumen rápido --}}
        <div class="erp-card">
            <div class="erp-card-hdr">
                <div class="erp-card-title">📊 Resumen</div>
            </div>
            <div class="erp-card-body">
                <div class="info-row"><span>Stock actual</span><span class="info-val" style="color:{{ $statusClass }};">{{ number_format($raw_material->stock) }} {{ $raw_material->unit }}</span></div>
                <div class="info-row"><span>Stock mínimo</span><span class="info-val">{{ $raw_material->minimum_stock }} {{ $raw_material->unit }}</span></div>
                <div class="info-row"><span>Total entradas</span><span class="info-val" style="color:var(--erp-ok);">{{ number_format($totalEntradas) }}</span></div>
                <div class="info-row"><span>Total consumido</span><span class="info-val" style="color:var(--erp-danger);">{{ number_format($totalConsumido) }}</span></div>
                <div class="info-row"><span>Producciones</span><span class="info-val">{{ $produccionesUsadas->count() }}</span></div>
                @php $faltante = max(0, $raw_material->minimum_stock - $raw_material->stock); @endphp
                @if($faltante > 0)
                <div style="margin-top:10px;background:var(--erp-danger-bg);border:1px solid #f3c7c4;border-radius:3px;padding:8px 10px;font-size:11px;color:var(--erp-danger);">
                    ⚠️ Faltan <strong>{{ number_format($faltante) }} {{ $raw_material->unit }}</strong> para alcanzar el stock mínimo.
                </div>
                @endif
            </div>
        </div>

        {{-- Acciones --}}
        <div class="erp-card">
            <div class="erp-card-hdr">
                <div class="erp-card-title">⚙️ Acciones</div>
            </div>
            <div class="erp-card-body" style="display:flex;flex-direction:column;gap:7px;">
                <a href="{{ route('raw-materials.edit', $raw_material) }}" class="btn btn-ghost" style="width:100%;justify-content:center;">
                    ✏️ Editar información
                </a>
                <a href="{{ route('raw-materials.index') }}" class="btn btn-ghost" style="width:100%;justify-content:center;">
                    ← Volver al listado
                </a>
                <form method="POST" action="{{ route('raw-materials.destroy', $raw_material) }}"
                    onsubmit="return confirm('¿Desactivar {{ $raw_material->name }}? No se eliminará del historial.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn" style="width:100%;justify-content:center;background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;">
                        🗑 Desactivar material
                    </button>
                </form>
            </div>
        </div>

    </div>{{-- /.right --}}

</div>{{-- /.main-layout --}}
</div>{{-- /.body --}}
</div>{{-- /.page --}}

@endsection