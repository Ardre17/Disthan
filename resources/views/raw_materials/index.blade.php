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
    padding:0;
    min-height:100vh;
    font-size:13px;
}
/* ── Top bar ── */
.erp-bar{
    background:#1e3a5f;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 1.25rem;
    margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}

/* ── Header ── */
.page-hdr{
    display:flex;justify-content:space-between;
    align-items:flex-start;margin-bottom:1rem;
    flex-wrap:wrap;gap:8px;
}
.page-title{
    font-size:17px;font-weight:700;color:#0f172a;
    display:flex;align-items:center;gap:8px;
}
.page-title:before{
    content:"";width:4px;height:20px;
    background:var(--erp-accent);border-radius:2px;display:inline-block;
}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.btn-new{
    background:var(--erp-accent);color:#fff;
    padding:8px 16px;border-radius:3px;
    font-size:12px;font-weight:600;
    text-decoration:none;display:inline-flex;
    align-items:center;gap:5px;
    transition:background .15s;border:none;cursor:pointer;
}
.btn-new:hover{background:var(--erp-accent-dark);color:#fff;}

/* ── Alertas sesión ── */
.alert-ok{
    background:var(--erp-ok-bg);color:var(--erp-ok);
    border:1px solid #b7dfca;border-radius:4px;
    padding:9px 14px;font-size:12px;font-weight:500;
    margin-bottom:.85rem;display:flex;align-items:center;gap:8px;
}
.alert-err{
    background:var(--erp-danger-bg);color:var(--erp-danger);
    border:1px solid #f3c7c4;border-radius:4px;
    padding:9px 14px;font-size:12px;
    margin-bottom:.85rem;
}
.alert-err ul{margin:.4rem 0 0 1rem;padding:0;}
.alert-err li{font-size:11px;margin-bottom:2px;}

/* ── KPIs ── */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;border-left:4px solid;
    position:relative;overflow:hidden;
}
.kpi-icon{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    font-size:26px;opacity:.1;
}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:22px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* ── Advertencias ── */
.warn-card{
    background:#fffbeb;
    border:1px solid #fde68a;
    border-left:4px solid #f59e0b;
    border-radius:4px;
    padding:1rem;
    margin-bottom:1rem;
}
.warn-title{
    display:flex;align-items:center;gap:7px;
    font-size:12px;font-weight:700;color:#b45309;
    text-transform:uppercase;letter-spacing:.06em;
    margin-bottom:.75rem;
}
.warn-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:8px;}
.warn-item{
    display:flex;align-items:flex-start;gap:8px;
    background:#fff;border:1px solid #fde68a;border-radius:3px;
    padding:8px 10px;
}
.warn-item-icon{font-size:16px;flex-shrink:0;margin-top:1px;}
.warn-item-text{font-size:11px;color:#7c4b00;line-height:1.5;}
.warn-item-text strong{color:#b45309;}

/* ── Buscador ── */
.filter-bar{
    background:var(--erp-surface);border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem 1rem;
    margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;
}
.finput{
    padding:7px 10px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;flex:1;min-width:180px;
    font-family:var(--font-ui);transition:border-color .15s;
}
.finput:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.fselect{
    padding:7px 10px;border:1px solid var(--erp-border);
    border-radius:3px;font-size:12px;color:var(--erp-ink);
    background:#fbfcfe;outline:none;
    font-family:var(--font-ui);
}

/* ── Cards grid ── */
.catalog{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:12px;
}
.mat-card{
    background:var(--erp-surface);
    border:1px solid var(--erp-border);
    border-radius:4px;
    overflow:hidden;
    transition:box-shadow .15s,border-color .15s;
    display:flex;flex-direction:column;
}
.mat-card:hover{
    border-color:#c2cbd8;
    box-shadow:0 2px 10px rgba(20,30,45,.08);
}
.mat-card.status-ok   {border-top:3px solid var(--erp-ok);}
.mat-card.status-warn {border-top:3px solid #f59e0b;}
.mat-card.status-low  {border-top:3px solid var(--erp-danger);}

.mat-card-header{
    padding:.75rem 1rem .5rem;
    border-bottom:1px solid var(--erp-border);
    display:flex;justify-content:space-between;align-items:flex-start;gap:8px;
}
.mat-name{font-size:14px;font-weight:700;color:var(--erp-ink);line-height:1.3;}
.mat-code{font-family:var(--font-mono);font-size:10px;color:var(--erp-ink-muted);margin-top:2px;}

.status-badge{
    display:inline-flex;align-items:center;gap:3px;
    font-size:10px;font-weight:700;padding:3px 8px;
    border-radius:3px;white-space:nowrap;flex-shrink:0;
}
.sb-ok   {background:var(--erp-ok-bg);   color:var(--erp-ok);   border:1px solid #b7dfca;}
.sb-warn {background:var(--erp-warn-bg); color:var(--erp-warn); border:1px solid #f9d5a3;}
.sb-low  {background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}

.mat-body{padding:.75rem 1rem;flex:1;display:flex;flex-direction:column;gap:0;}

.info-row{
    display:flex;justify-content:space-between;align-items:center;
    font-size:12px;padding:5px 0;
    border-bottom:1px dashed #ecf0f4;
    color:var(--erp-ink-muted);
}
.info-row:last-of-type{border-bottom:none;}
.info-val{font-weight:600;color:var(--erp-ink);}

/* Stock highlight */
.stock-block{
    margin:8px 0;
    padding:8px 10px;
    border-radius:3px;
    display:flex;align-items:center;justify-content:space-between;
}
.stock-ok   {background:var(--erp-ok-bg);}
.stock-warn {background:var(--erp-warn-bg);}
.stock-low  {background:var(--erp-danger-bg);}
.stock-num{font-family:var(--font-mono);font-size:20px;font-weight:800;line-height:1;}
.stock-unit{font-size:11px;color:var(--erp-ink-muted);margin-top:2px;}

.mat-footer{
    padding:.65rem 1rem;
    background:#f9fafb;
    border-top:1px solid var(--erp-border);
    display:flex;gap:6px;
}
.btn-sm-edit{
    flex:1;text-align:center;
    background:#fff;color:var(--erp-warn);
    border:1px solid var(--erp-warn);
    padding:6px;border-radius:3px;
    font-size:11px;font-weight:600;
    text-decoration:none;transition:background .15s;
}
.btn-sm-edit:hover{background:var(--erp-warn-bg);color:var(--erp-warn);}
.btn-sm-view{
    flex:1;text-align:center;
    background:#fff;color:var(--erp-ok);
    border:1px solid var(--erp-ok);
    padding:6px;border-radius:3px;
    font-size:11px;font-weight:600;
    text-decoration:none;transition:background .15s;
}
.btn-sm-view:hover{background:var(--erp-ok-bg);color:var(--erp-ok);}

/* empty */
.empty-state{
    background:var(--erp-surface);border:1px dashed var(--erp-border);
    border-radius:4px;padding:3rem;text-align:center;
    color:var(--erp-ink-muted);grid-column:1/-1;
}
.empty-state h3{color:var(--erp-ink);font-size:15px;margin-bottom:6px;}

/* result bar */
.result-bar{
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:.65rem;font-size:12px;color:var(--erp-ink-muted);
    flex-wrap:wrap;gap:6px;
}
.result-bar strong{color:var(--erp-ink);}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Materia Prima</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Producción › Materia Prima</span>
</div>

<div class="body">

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Control de materia prima</div>
        <div class="page-sub">Control de materias primas disponibles para producción</div>
    </div>
    <a href="{{ route('raw-materials.create') }}" class="btn-new">
        ➕ Nueva materia prima
    </a>
</div>

{{-- ── Alertas sesión ── --}}
@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert-err">
    <strong>⚠️ Se encontraron errores:</strong>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:var(--erp-accent);">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Total materias</div>
        <div class="kpi-val">{{ $total }}</div>
        <div class="kpi-sub">registradas en sistema</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Disponibles</div>
        <div class="kpi-val" style="color:var(--erp-ok);">{{ $disponibles }}</div>
        <div class="kpi-sub">stock suficiente</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Stock bajo</div>
        <div class="kpi-val" style="color:var(--erp-warn);">{{ $stockBajo }}</div>
        <div class="kpi-sub">requieren reposición</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-danger);">
        <div class="kpi-icon">🔴</div>
        <div class="kpi-label">Agotadas</div>
        <div class="kpi-val" style="color:var(--erp-danger);">{{ $agotadas }}</div>
        <div class="kpi-sub">sin stock disponible</div>
    </div>
</div>

{{-- ── Panel de advertencias ── --}}
<div class="warn-card">
    <div class="warn-title">
        ⚠️ Advertencias de uso — leer antes de operar
    </div>
    <div class="warn-grid">
        <div class="warn-item">
            <div class="warn-item-icon">🎯</div>
            <div class="warn-item-text">
                <strong>Verificar antes de seleccionar</strong><br>
                Confirma que la materia prima seleccionada corresponde exactamente al tipo, color y especificación requerida. Una selección incorrecta puede afectar toda la producción.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">⚖️</div>
            <div class="warn-item-text">
                <strong>Cantidad = producción real</strong><br>
                La cantidad registrada como salida debe ser <strong>idéntica</strong> a la cantidad utilizada en producción. No redondear ni estimar.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">📋</div>
            <div class="warn-item-text">
                <strong>Actualizar inventario restante</strong><br>
                Después de cada uso, registra el saldo restante en el kardex. El stock del sistema debe reflejar siempre el stock físico real.
            </div>
        </div>
        <div class="warn-item">
            <div class="warn-item-icon">🔄</div>
            <div class="warn-item-text">
                <strong>No usar materia en stock bajo</strong><br>
                Si el estado es <strong>Stock Bajo</strong> o <strong>Agotado</strong>, notifica al responsable de compras antes de continuar con la producción.
            </div>
        </div>
    </div>
</div>

{{-- ── Buscador ── --}}
<div class="filter-bar">
    🔍
    <input
        type="text"
        id="buscarMateria"
        class="finput"
        placeholder="Buscar por nombre, código, categoría o proveedor...">
    <select class="fselect" id="filtroEstado" onchange="filtrarCards()">
        <option value="">Todos los estados</option>
        <option value="disponible">✅ Disponibles</option>
        <option value="stock_bajo">⚠️ Stock bajo</option>
        <option value="agotado">🔴 Agotadas</option>
    </select>
</div>

<div class="result-bar">
    <div>Mostrando <strong id="countVisible">{{ $materials->count() }}</strong> materias primas</div>
    <div style="font-size:11px;color:#94a3b8;">Ordenado por nombre</div>
</div>

{{-- ── Cards ── --}}
<div class="catalog" id="catalogGrid">

@forelse($materials as $material)
@php
    $statusClass = match($material->status) {
        'DISPONIBLE' => 'status-ok',
        'STOCK_BAJO' => 'status-warn',
        default      => 'status-low',
    };
    $badgeClass = match($material->status) {
        'DISPONIBLE' => 'sb-ok',
        'STOCK_BAJO' => 'sb-warn',
        default      => 'sb-low',
    };
    $badgeLabel = match($material->status) {
        'DISPONIBLE' => '✅ Disponible',
        'STOCK_BAJO' => '⚠️ Stock bajo',
        default      => '🔴 Agotado',
    };
    $stockClass = match($material->status) {
        'DISPONIBLE' => 'stock-ok',
        'STOCK_BAJO' => 'stock-warn',
        default      => 'stock-low',
    };
    $stockColor = match($material->status) {
        'DISPONIBLE' => 'var(--erp-ok)',
        'STOCK_BAJO' => 'var(--erp-warn)',
        default      => 'var(--erp-danger)',
    };
@endphp

<div class="mat-card {{ $statusClass }} materia-card"
     data-status="{{ strtolower($material->status) }}">

    <div class="mat-card-header">
        <div>
            <div class="mat-name">{{ $material->name }}</div>
            <div class="mat-code">{{ $material->code }}</div>
        </div>
        <span class="status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
    </div>

    <div class="mat-body">

        <div class="stock-block {{ $stockClass }}">
            <div>
                <div class="stock-num" style="color:{{ $stockColor }};">
                    {{ $material->stock }}
                </div>
                <div class="stock-unit">{{ $material->unit }} disponibles</div>
            </div>
            <div style="font-size:24px;opacity:.3;">📦</div>
        </div>

        <div class="info-row">
            <span>Categoría</span>
            <span class="info-val">{{ $material->category ?? '—' }}</span>
        </div>

        <div class="info-row">
            <span>Proveedor</span>
            <span class="info-val">{{ $material->supplier ?? '—' }}</span>
        </div>

        <div class="info-row">
            <span>Color</span>
            <span class="info-val">{{ $material->color ?? '—' }}</span>
        </div>

    </div>

    <div class="mat-footer">
        <a href="{{ route('raw-materials.edit', $material) }}" class="btn-sm-edit">
            ✏️ Editar
        </a>
        <a href="{{ route('raw-materials.show', $material) }}" class="btn-sm-view">
            📋 Ver kardex
        </a>
    </div>

</div>

@empty

<div class="empty-state">
    <div style="font-size:36px;margin-bottom:8px;">📦</div>
    <h3>No hay materias primas registradas</h3>
    <p style="font-size:12px;margin:.5rem 0 1rem;">
        Comienza registrando tu primera materia prima.
    </p>
    <a href="{{ route('raw-materials.create') }}" class="btn-new">
        ➕ Nueva materia prima
    </a>
    <a href="{{ route('raw-material-entries.create') }}"
   class="btn btn-success">
    📥 Entrada
</a>
</div>

@endforelse

</div>

</div>
</div>

<script>
document.getElementById('buscarMateria').addEventListener('keyup', filtrarCards);
document.getElementById('filtroEstado').addEventListener('change', filtrarCards);

function filtrarCards() {
    var texto   = document.getElementById('buscarMateria').value.toLowerCase();
    var estado  = document.getElementById('filtroEstado').value.toLowerCase();
    var cards   = document.querySelectorAll('.materia-card');
    var visible = 0;

    cards.forEach(function(card) {
        var matchTexto  = card.innerText.toLowerCase().includes(texto);
        var matchEstado = !estado || card.dataset.status === estado;
        var show = matchTexto && matchEstado;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    var cnt = document.getElementById('countVisible');
    if (cnt) cnt.textContent = visible;
}
</script>

@endsection