@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;
    --erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;
    --erp-accent:#0b5ed7;--erp-accent-dark:#0a4eb3;
    --erp-danger:#c0312b;--erp-danger-bg:#fbe9e8;
    --erp-warn:#b9690e;--erp-warn-bg:#fdf1e2;
    --erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;
    --font-ui:'Segoe UI',sans-serif;--font-mono:'Consolas',monospace;
}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}

/* ── Header ── */
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:#0ea5e9;border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}

/* ── KPIs ── */
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:18px;font-weight:800;color:var(--erp-ink);line-height:1;font-family:var(--font-mono);}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}

/* ── Cards ── */
.sec-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.sec-hdr{padding:.65rem 1rem;display:flex;align-items:center;gap:7px;border-bottom:1px solid var(--erp-border);background:#f4f6f9;border-radius:4px 4px 0 0;}
.sec-hdr-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.sec-hdr-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.sec-body{padding:1rem;}

/* ── Layout ── */
.layout{display:grid;grid-template-columns:1fr 280px;gap:12px;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}

/* ── Form ── */
.field-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:8px;align-items:end;}
@media(max-width:700px){.field-grid{grid-template-columns:1fr;}}
.field{display:flex;flex-direction:column;gap:3px;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}

/* ── Tabla ── */
.erp-table{width:100%;border-collapse:collapse;font-size:12px;}
.erp-table th{background:#f4f6f9;color:var(--erp-ink-muted);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.erp-table td{padding:8px 10px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.erp-table tbody tr:hover td{background:#f7fafc;}
.num-mono{font-family:var(--font-mono);font-weight:700;}

/* ── Botones ── */
.btn-primary{background:var(--erp-accent);color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s;font-family:var(--font-ui);}
.btn-primary:hover{background:var(--erp-accent-dark);}
.btn-ok{background:var(--erp-ok);color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:5px;font-family:var(--font-ui);}
.btn-danger{background:var(--erp-danger);color:#fff;padding:6px 12px;border-radius:3px;font-size:11px;font-weight:600;cursor:pointer;border:none;font-family:var(--font-ui);}
.btn-pdf{background:#0ea5e9;color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;display:inline-flex;align-items:center;gap:5px;}
.btn-cerrar{background:#dc2626;color:#fff;padding:7px 16px;border-radius:3px;font-size:12px;font-weight:700;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:5px;font-family:var(--font-ui);}
.btn-sm-add{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;padding:5px 10px;border-radius:3px;font-size:11px;font-weight:600;cursor:pointer;font-family:var(--font-ui);}

/* ── Badges ── */
.badge{display:inline-flex;align-items:center;gap:3px;padding:3px 8px;border-radius:3px;font-size:10.5px;font-weight:700;}
.badge-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.badge-warn{background:var(--erp-warn-bg);color:var(--erp-warn);border:1px solid #f9d5a3;}
.badge-danger{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}
.badge-blue{background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe;}

/* ── Resumen lateral ── */
.sum-row{display:flex;justify-content:space-between;align-items:center;font-size:12px;padding:5px 0;border-bottom:1px solid #f4f6f9;color:var(--erp-ink-muted);}
.sum-row:last-child{border:none;}
.sum-val{font-family:var(--font-mono);font-weight:700;color:var(--erp-ink);}

/* ── Pallet card ── */
.pallet-wrap{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:12px;margin-top:.75rem;}
.pallet-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;}
.pallet-hdr{background:linear-gradient(135deg,#1e3a5f,#0f172a);padding:.75rem 1rem;display:flex;justify-content:space-between;align-items:center;}
.pallet-code{color:#fff;font-family:var(--font-mono);font-size:13px;font-weight:700;letter-spacing:.5px;}
.pallet-body{padding:.85rem;}

/* ── Pallet 2D ── */
.pallet-2d-wrap{
    background:#f8fafc;border:1px solid var(--erp-border);
    border-radius:4px;padding:.75rem;margin-bottom:.85rem;
}
.pallet-2d-title{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;}
.pallet-grid-svg{display:block;width:100%;max-width:320px;margin:0 auto;}

/* ── Mini barra progreso pallet ── */
.pallet-prog{margin-bottom:.75rem;}
.pallet-prog-top{display:flex;justify-content:space-between;font-size:10px;color:var(--erp-ink-muted);margin-bottom:3px;}
.pallet-prog-bar{height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.pallet-prog-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#0ea5e9,#7c3aed);}

/* ── Estado de producción tabla ── */
.prod-row-ok td{background:var(--erp-ok-bg)!important;}
.prod-row-warn td{background:var(--erp-warn-bg)!important;}
.mini-bar{width:70px;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;display:inline-block;vertical-align:middle;margin-left:4px;}
.mini-fill{height:100%;border-radius:99px;}

.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">DISTAN ERP</div>
        <div class="erp-sep"></div>
        <div class="erp-module">🚢 Exportación</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Ventas › Exportación › {{ $order->numero_orden }}</span>
</div>

<div class="body">

@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

@php
    $totalItems  = $order->details->count();
    $totalPallets= $order->pallets->count();
    $pesoTotal   = $order->details->sum(fn($d) => ($d->product->peso ?? 0) * $d->cantidad_solicitada / 1000);
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d' : ($order->estado === 'PARCIAL' ? '#b45309' : '#b91c1c');
    $estadoBg    = $order->estado === 'COMPLETO' ? '#dcfce7' : ($order->estado === 'PARCIAL' ? '#fef3c7' : '#fee2e2');
@endphp

{{-- ── Header ── --}}
<div class="page-hdr">
    <div>
        <div class="page-title">Exportación — {{ $order->numero_orden }}</div>
        <div class="page-sub">
            🏢 {{ $order->client->razon_social }}
            &nbsp;·&nbsp; 📅 {{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}
        </div>
    </div>
    <div style="display:flex;gap:7px;align-items:center;flex-wrap:wrap;">
        <span class="badge" style="background:{{ $estadoBg }};color:{{ $estadoColor }};font-size:12px;padding:5px 12px;">
            {{ $order->estado }}
        </span>
        <a href="{{ route('orders.pdf', $order) }}" target="_blank" class="btn-pdf">
            📄 Ver PDF
        </a>
        @if($order->estado != 'COMPLETO')
        <form method="POST" action="{{ route('orders.cerrar', $order) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-cerrar"
                    onclick="return confirm('¿Confirmas cerrar esta exportación?')">
                🔒 Cerrar exportación
            </button>
        </form>
        @endif
    </div>
</div>

{{-- ── KPIs ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#0ea5e9;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Productos</div>
        <div class="kpi-val">{{ $totalItems }}</div>
        <div class="kpi-sub">líneas de pedido</div>
    </div>
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">🟫</div>
        <div class="kpi-label">Pallets</div>
        <div class="kpi-val" style="color:#7c3aed;">{{ $totalPallets }}</div>
        <div class="kpi-sub">creados</div>
    </div>
    <div class="kpi" style="border-left-color:var(--erp-ok);">
        <div class="kpi-icon">⚖️</div>
        <div class="kpi-label">Peso total</div>
        <div class="kpi-val" style="font-size:15px;color:var(--erp-ok);">{{ number_format($pesoTotal,2) }} kg</div>
        <div class="kpi-sub">estimado</div>
    </div>
    <div class="kpi" style="border-left-color:#2563eb;">
        <div class="kpi-icon">💰</div>
        <div class="kpi-label">Subtotal</div>
        <div class="kpi-val" style="font-size:15px;color:#2563eb;">S/ {{ number_format($order->subtotal,2) }}</div>
        <div class="kpi-sub">sin IGV</div>
    </div>
    <div class="kpi" style="border-left-color:#1e3a5f;background:#f0f7ff;">
        <div class="kpi-icon">🧾</div>
        <div class="kpi-label">Total</div>
        <div class="kpi-val" style="font-size:15px;color:#1e3a5f;">S/ {{ number_format($order->total,2) }}</div>
        <div class="kpi-sub">con IGV 18%</div>
    </div>
</div>

<div class="layout">
<div>

    {{-- ── Sección 1: Agregar producto ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:var(--erp-accent);">1</div>
            <div class="sec-hdr-title">➕ Agregar línea de producto</div>
        </div>
        <div class="sec-body">
            {{-- =========================================================
     OBJETIVO DE CAJAS DE LA EXPORTACIÓN
========================================================= --}}

@php
    $totalCajasAsignadas = $order->pallets
        ->flatMap(fn($pallet) => $pallet->detalles)
        ->sum('cantidad');

    $objetivoCajas = (int) ($order->cajas_objetivo ?? 0);

    $avanceCajas = $objetivoCajas > 0
        ? min(100, round(($totalCajasAsignadas / $objetivoCajas) * 100))
        : 0;

    $cajasFaltantes = max(
        0,
        $objetivoCajas - $totalCajasAsignadas
    );

    $avanceColor = $avanceCajas >= 100
        ? 'var(--erp-ok)'
        : ($avanceCajas > 0 ? '#f59e0b' : '#94a3b8');
@endphp

<div style="
    background:#f8fafc;
    border:1px solid var(--erp-border);
    border-radius:4px;
    padding:12px;
    margin-bottom:12px;
">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
        flex-wrap:wrap;
    ">

        <div>

            <div style="
                font-size:10px;
                color:var(--erp-ink-muted);
                text-transform:uppercase;
                font-weight:700;
                letter-spacing:.05em;
            ">
                📦 Objetivo de exportación
            </div>

            <div style="
                font-size:22px;
                font-weight:900;
                font-family:var(--font-mono);
                color:#1e3a5f;
                margin-top:2px;
            ">
                {{ number_format($totalCajasAsignadas) }}
                /
                {{ $objetivoCajas > 0 ? number_format($objetivoCajas) : '—' }}
                <span style="
                    font-size:11px;
                    font-family:var(--font-ui);
                    color:#64748b;
                    font-weight:600;
                ">
                    cajas
                </span>
            </div>

        </div>


        {{-- FORMULARIO OBJETIVO --}}

        <form
            action="{{ route('exportacion.cajasObjetivo', $order) }}"
            method="POST"
            style="
                display:flex;
                align-items:end;
                gap:6px;
            "
        >

            @csrf

            <div>

                <label class="flabel">
                    Cajas objetivo
                </label>

                <input
                    type="number"
                    name="cajas_objetivo"
                    min="1"
                    required
                    value="{{ $order->cajas_objetivo }}"
                    class="finput"
                    style="width:130px;"
                    placeholder="1000"
                >

            </div>

            <button
                type="submit"
                class="btn-primary"
                style="background:#7c3aed;"
            >
                💾 Definir
            </button>

        </form>

    </div>


    {{-- BARRA GLOBAL --}}

    <div style="margin-top:12px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-size:10px;
            color:var(--erp-ink-muted);
            margin-bottom:4px;
        ">

            <span>
                Avance de asignación
            </span>

            <span style="
                font-weight:800;
                color:{{ $avanceColor }};
            ">
                {{ $avanceCajas }}%
            </span>

        </div>

        <div style="
            height:9px;
            background:#e5e7eb;
            border-radius:99px;
            overflow:hidden;
        ">

            <div style="
                height:100%;
                width:{{ $avanceCajas }}%;
                background:{{ $avanceColor }};
                border-radius:99px;
                transition:width .3s;
            "></div>

        </div>

        <div style="
            margin-top:5px;
            font-size:10px;
            color:#64748b;
        ">

            @if($objetivoCajas > 0)

                @if($cajasFaltantes > 0)

                    Faltan
                    <strong>
                        {{ number_format($cajasFaltantes) }}
                    </strong>
                    cajas por asignar.

                @else

                    <strong style="color:var(--erp-ok);">
                        ✅ Objetivo de cajas completado.
                    </strong>

                @endif

            @else

                Define primero la cantidad total de cajas de esta exportación.

            @endif

        </div>

    </div>

</div>
            <form method="POST" action="{{ route('orders.addProduct', $order) }}">
            @csrf
            <div class="field-grid">
                <div class="field">
                    <label class="flabel">Producto</label>
                    <select name="product_id" class="fselect" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label class="flabel">Cantidad</label>
                    <input type="number" name="cantidad_solicitada" class="finput" min="1" required placeholder="0">
                </div>
                <div class="field">
                    <label class="flabel">Precio unit.</label>
                    <input type="number" step="0.01" min="0" name="precio_unitario" class="finput" required placeholder="0.00">
                </div>
                <button type="submit" class="btn-primary" style="align-self:end;">
                    ➕ Agregar
                </button>
            </div>
            </form>
        </div>
    </div>

    {{-- ── Sección 2: Productos ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#0ea5e9;">2</div>
            <div class="sec-hdr-title">📦 Productos de la orden</div>
        </div>
        <div style="overflow-x:auto;">
        <table class="erp-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align:center;">Solicitado</th>
                    <th style="text-align:center;">Despachado</th>
                    <th style="text-align:center;">Peso</th>
                    <th style="text-align:right;">Subtotal</th>
                    <th style="text-align:center;">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
@foreach($order->details as $item)
@php
    $pct = $item->cantidad_solicitada > 0
        ? round($item->cantidad_despachada / $item->cantidad_solicitada * 100) : 0;
    $bc  = $pct >= 100 ? 'var(--erp-ok)' : ($pct > 0 ? '#f59e0b' : 'var(--erp-danger)');
@endphp
<tr id="row-{{ $item->id }}">
    <td style="font-weight:600;">{{ $item->product->nombre }}</td>
    <td style="text-align:center;">
        <input type="number"
               class="num-mono"
               id="sol-{{ $item->id }}"
               value="{{ $item->cantidad_solicitada }}"
               disabled
               style="width:70px;text-align:center;border:1px solid #dde2ea;border-radius:3px;padding:4px;font-family:var(--font-mono);font-weight:700;background:#fbfcfe;"
               oninput="syncHidden({{ $item->id }})">
    </td>
    <td style="text-align:center;">
        <input type="number"
               class="num-mono"
               id="des-{{ $item->id }}"
               value="{{ $item->cantidad_despachada }}"
               disabled
               style="width:70px;text-align:center;border:1px solid #dde2ea;border-radius:3px;padding:4px;font-family:var(--font-mono);font-weight:700;background:#fbfcfe;"
               oninput="syncHidden({{ $item->id }});actualizarBarra({{ $item->id }})">
    </td>
    <td style="text-align:center;color:var(--erp-ink-muted);">
        {{ number_format(($item->product->peso ?? 0)/1000,3) }} kg
    </td>
    <td style="text-align:right;" class="num-mono">
        S/ {{ number_format($item->subtotal,2) }}
    </td>
    <td style="text-align:center;">
        <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
            <div class="mini-bar">
                <div class="mini-fill"
                     id="bar-{{ $item->id }}"
                     style="width:{{ $pct }}%;background:{{ $bc }};transition:width .3s;">
                </div>
            </div>
            <span id="pct-{{ $item->id }}"
                  style="font-size:10px;font-weight:700;color:{{ $bc }};">
                {{ $pct }}%
            </span>
        </div>
    </td>
    <td>
        <div style="display:flex;gap:4px;">
            {{-- Botón editar --}}
            <button type="button"
                    class="btn-sm-add"
                    id="btn-edit-{{ $item->id }}"
                    onclick="editarFila({{ $item->id }})">
                ✏️ Editar
            </button>
            {{-- Botón guardar (oculto hasta editar) --}}
            <button type="submit"
                    form="form-upd-{{ $item->id }}"
                    class="btn-ok"
                    id="btn-save-{{ $item->id }}"
                    style="display:none;padding:5px 10px;font-size:11px;">
                💾 Guardar
            </button>
            {{-- Eliminar --}}
            <form method="POST"
                  action="{{ route('orders.details.destroy', $item) }}"
                  onsubmit="return confirm('¿Eliminar {{ addslashes($item->product->nombre) }}?')"
                  style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">🗑</button>
            </form>
        </div>
    </td>
</tr>
@endforeach
</tbody>
        </table>
        </div>
    </div>

    {{-- ── Sección 3: Pallets ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#7c3aed;">3</div>
            <div class="sec-hdr-title">🟫 Pallets de exportación</div>
            <div style="margin-left:auto;">
                <form action="{{ route('exportacion.pallet.store', $order) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-primary" style="background:#7c3aed;">
                        ➕ Crear pallet
                    </button>
                </form>
            </div>
        </div>
        <div class="sec-body">

        @if($order->pallets->count())
        <div class="pallet-wrap">

        @foreach($order->pallets as $pallet)
        @php
            /* ── Datos para el gráfico 2D ── */
            $cols        = 5;
            $rows        = 4;
            $totalSlots  = $cols * $rows;          // 20 posiciones por capa
            $totalCajas  = $pallet->detalles->sum('cantidad');

            // Paleta de colores por producto
            $colorPalette = [
                '#0ea5e9','#7c3aed','#22c55e','#f59e0b',
                '#ef4444','#06b6d4','#ec4899','#84cc16',
                '#f97316','#8b5cf6',
            ];
            $prodColores = [];
            $ci = 0;
            foreach($pallet->detalles as $det) {
                $prodColores[$det->product->nombre] = $colorPalette[$ci % count($colorPalette)];
                $ci++;
            }

            // Construir slots
            $slots = [];
            foreach($pallet->detalles as $det) {
                for($x = 0; $x < $det->cantidad; $x++) {
                    $slots[] = [
                        'nombre' => $det->product->nombre,
                        'color'  => $prodColores[$det->product->nombre],
                    ];
                }
            }
            // Rellenar vacíos
            while(count($slots) < $totalSlots) {
                $slots[] = ['nombre' => null, 'color' => '#f1f5f9'];
            }
            $slots = array_slice($slots, 0, $totalSlots);
            $pct   = $totalSlots > 0 ? round($totalCajas / $totalSlots * 100) : 0;
            $pesoP = $pallet->detalles->sum(fn($d) => ($d->product->peso ?? 0) * $d->cantidad / 1000);
        @endphp

        <div class="pallet-card">

            {{-- Header del pallet --}}
            <div class="pallet-hdr">
                <div>
                    <div class="pallet-code">🟫 {{ $pallet->codigo }}</div>
                    <div style="font-size:10px;color:#7eb8f7;margin-top:2px;">
                        {{ $totalCajas }} / {{ $totalSlots }} posiciones · {{ number_format($pesoP,2) }} kg
                    </div>
                </div>
                <span class="badge" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.2);">
                    {{ $pct }}% lleno
                </span>
            </div>

            <div class="pallet-body">

                {{-- ── BARRA DE PROGRESO ── --}}
                <div class="pallet-prog">
                    <div class="pallet-prog-top">
                        <span>Ocupación del pallet</span>
                        <span style="font-weight:700;">{{ $pct }}%</span>
                    </div>
                    <div class="pallet-prog-bar">
                        <div class="pallet-prog-fill" style="width:{{ $pct }}%;"></div>
                    </div>
                </div>

                {{-- ── GRÁFICO 2D DEL PALLET ── --}}
                <div class="pallet-2d-wrap">
                    <div class="pallet-2d-title">Vista 2D del pallet — {{ $rows }} filas × {{ $cols }} columnas</div>

                    {{-- SVG del pallet --}}
                    @php
                        $cw   = 54;    // ancho celda
                        $ch   = 32;    // alto celda
                        $gap  = 3;     // separación
                        $padX = 20;    // padding izq (para labels)
                        $padY = 14;    // padding top (para labels)
                        $svgW = $padX + $cols * ($cw + $gap) + 10;
                        $svgH = $padY + $rows * ($ch + $gap) + 10;
                    @endphp

                    <svg class="pallet-grid-svg"
                         viewBox="0 0 {{ $svgW }} {{ $svgH }}"
                         xmlns="http://www.w3.org/2000/svg">

                        {{-- Fondo del pallet --}}
                        <rect x="0" y="0" width="{{ $svgW }}" height="{{ $svgH }}"
                              rx="4" ry="4" fill="#e2e8f0"/>

                        {{-- Labels columnas --}}
                        @for($c = 0; $c < $cols; $c++)
                            <text
                                x="{{ $padX + $c * ($cw + $gap) + $cw/2 }}"
                                y="{{ $padY - 3 }}"
                                text-anchor="middle"
                                font-size="7"
                                fill="#94a3b8"
                                font-family="Consolas,monospace">
                                {{ chr(65 + $c) }}
                            </text>
                        @endfor

                        {{-- Labels filas --}}
                        @for($r = 0; $r < $rows; $r++)
                            <text
                                x="{{ $padX - 5 }}"
                                y="{{ $padY + $r * ($ch + $gap) + $ch/2 + 3 }}"
                                text-anchor="end"
                                font-size="7"
                                fill="#94a3b8"
                                font-family="Consolas,monospace">
                                {{ $r + 1 }}
                            </text>
                        @endfor

                        {{-- Celdas ── --}}
                        @foreach($slots as $idx => $slot)
                        @php
                            $row  = intdiv($idx, $cols);
                            $col  = $idx % $cols;
                            $x    = $padX + $col * ($cw + $gap);
                            $y    = $padY + $row * ($ch + $gap);
                            $vacia = $slot['nombre'] === null;
                            $fill  = $slot['color'];
                            $stroke= $vacia ? '#cbd5e1' : 'rgba(0,0,0,.15)';
                            // Abreviar nombre del producto
                            $label = $vacia ? '' : implode('',array_map(fn($w)=>strtoupper(substr($w,0,1)),explode(' ',$slot['nombre'])));
                            $label = substr($label, 0, 4);
                        @endphp
                        <g>
                            <rect
                                x="{{ $x }}" y="{{ $y }}"
                                width="{{ $cw }}" height="{{ $ch }}"
                                rx="3" ry="3"
                                fill="{{ $fill }}"
                                stroke="{{ $stroke }}"
                                stroke-width="{{ $vacia ? '1' : '1.5' }}"
                                opacity="{{ $vacia ? '0.5' : '1' }}"/>

                            @if(!$vacia)
                            {{-- Ícono caja --}}
                            <text
                                x="{{ $x + $cw/2 }}"
                                y="{{ $y + $ch/2 - 3 }}"
                                text-anchor="middle"
                                font-size="10"
                                fill="white">📦</text>
                            {{-- Siglas --}}
                            <text
                                x="{{ $x + $cw/2 }}"
                                y="{{ $y + $ch - 5 }}"
                                text-anchor="middle"
                                font-size="7"
                                fill="white"
                                font-weight="bold"
                                font-family="Consolas,monospace">
                                {{ $label }}
                            </text>
                            @else
                            {{-- Celda vacía --}}
                            <text
                                x="{{ $x + $cw/2 }}"
                                y="{{ $y + $ch/2 + 3 }}"
                                text-anchor="middle"
                                font-size="8"
                                fill="#cbd5e1">—</text>
                            @endif
                        </g>
                        @endforeach

                    </svg>

                    {{-- Leyenda colores --}}
                    @if($pallet->detalles->count())
                    <div style="margin-top:.6rem;display:flex;flex-wrap:wrap;gap:5px;">
                        @foreach($pallet->detalles as $det)
                        <span style="
                            display:inline-flex;align-items:center;gap:4px;
                            font-size:10px;padding:2px 7px;border-radius:3px;
                            background:{{ $prodColores[$det->product->nombre] }};
                            color:#fff;font-weight:700;
                        ">
                            {{ implode('',array_map(fn($w)=>strtoupper(substr($w,0,1)),explode(' ',$det->product->nombre))) }}
                            — {{ $det->product->nombre }}
                        </span>
                        @endforeach
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:10px;padding:2px 7px;border-radius:3px;background:#f1f5f9;color:#94a3b8;font-weight:700;">
                            — Vacío
                        </span>
                    </div>
                    @endif
                </div>

                {{-- ── TABLA DE PRODUCTOS DEL PALLET ── --}}
                <table class="erp-table" style="margin-bottom:.75rem;">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th style="text-align:center;">Cajas</th>
                            <th style="text-align:center;">Peso</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pallet->detalles as $detalle)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <span style="width:10px;height:10px;border-radius:2px;background:{{ $prodColores[$detalle->product->nombre] }};flex-shrink:0;display:inline-block;"></span>
                                {{ $detalle->product->nombre }}
                            </div>
                        </td>
                        <td style="text-align:center;" class="num-mono">{{ $detalle->cantidad }}</td>
                        <td style="text-align:center;color:var(--erp-ink-muted);">
                            {{ number_format(($detalle->product->peso * $detalle->cantidad)/1000,2) }} kg
                        </td>
                        <td style="text-align:right;">
                            <button class="btn-danger" style="padding:3px 8px;font-size:10px;">🗑 Quitar</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#94a3b8;padding:1rem;font-style:italic;">
                            Este pallet aún no tiene productos
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>

                {{-- ── FORM AGREGAR A PALLET ── --}}
                <div style="background:#f8fafc;border:1px solid var(--erp-border);border-radius:4px;padding:.75rem;">
                    <div style="font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">
                        ➕ Agregar producto al pallet
                    </div>
                    <form action="{{ route('exportacion.pallet.agregarProducto', $pallet) }}" method="POST">
                    @csrf
                    <div style="display:grid;grid-template-columns:2fr 1fr auto;gap:7px;align-items:end;">
                        <div>
                            <select name="order_detail_id" class="fselect" required>
                                <option value="">Seleccionar producto pendiente</option>
                                @foreach($order->details as $detalle)
                                @php
                                    $enPallets = $detalle->palletDetails->sum('cantidad');
                                    $pendiente = $detalle->cantidad_solicitada - $enPallets;
                                @endphp
                                @if($pendiente > 0)
                                <option value="{{ $detalle->id }}">
                                    {{ $detalle->product->nombre }} ({{ $pendiente }} pend.)
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input type="number" name="cantidad" class="finput"
                                   min="1" required placeholder="Cantidad">
                        </div>
                        <button type="submit" class="btn-sm-add">✔ Agregar</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
        </div>

        @else
        <div style="text-align:center;padding:2rem;color:var(--erp-ink-muted);">
            <div style="font-size:36px;margin-bottom:8px;">🟫</div>
            <div style="font-size:14px;font-weight:600;color:var(--erp-ink);margin-bottom:4px;">No hay pallets creados</div>
            <div style="font-size:12px;">Crea el primer pallet para comenzar la asignación de productos.</div>
        </div>
        @endif

        </div>
    </div>

    {{-- ── Sección 4: Estado de producción ── --}}
    <div class="sec-card">
        <div class="sec-hdr">
            <div class="sec-hdr-num" style="background:#f59e0b;">4</div>
            <div class="sec-hdr-title">📊 Estado de asignación a pallets</div>
        </div>
        <div style="overflow-x:auto;">
        <table class="erp-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align:center;">Solicitado</th>
                    <th style="text-align:center;">En pallets</th>
                    <th style="text-align:center;">Pendiente</th>
                    <th style="text-align:center;">Avance</th>
                    <th style="text-align:right;">Peso total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($order->details as $detalle)
            @php
                $enPallets = $detalle->palletDetails->sum('cantidad');
                $pendiente = $detalle->cantidad_solicitada - $enPallets;
                $peso      = ($detalle->product->peso ?? 0) * $detalle->cantidad_solicitada;
                $pct2      = $detalle->cantidad_solicitada > 0
                    ? round($enPallets / $detalle->cantidad_solicitada * 100) : 0;
                $bc2 = $pct2 >= 100 ? 'var(--erp-ok)' : ($pct2 > 0 ? '#f59e0b' : '#94a3b8');
                $rowClass = $pct2 >= 100 ? 'prod-row-ok' : ($pct2 > 0 ? 'prod-row-warn' : '');
            @endphp
            <tr class="{{ $rowClass }}">
                <td style="font-weight:600;">{{ $detalle->product->nombre }}</td>
                <td style="text-align:center;" class="num-mono">{{ $detalle->cantidad_solicitada }}</td>
                <td style="text-align:center;" class="num-mono" style="color:var(--erp-ok);">{{ $enPallets }}</td>
                <td style="text-align:center;">
                    @if($pendiente > 0)
                    <span class="badge badge-warn">{{ $pendiente }}</span>
                    @else
                    <span class="badge badge-ok">✓ Completo</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                        <div class="mini-bar"><div class="mini-fill" style="width:{{ $pct2 }}%;background:{{ $bc2 }};"></div></div>
                        <span style="font-size:10px;font-weight:700;color:{{ $bc2 }};">{{ $pct2 }}%</span>
                    </div>
                </td>
                <td style="text-align:right;color:var(--erp-ink-muted);">
                    {{ number_format($peso/1000,2) }} kg
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>

</div>

{{-- ── Panel lateral ── --}}
<div>
    <div style="position:sticky;top:10px;display:flex;flex-direction:column;gap:10px;">

        {{-- Resumen financiero --}}
        <div class="sec-card">
            <div class="sec-hdr">
                <div class="sec-hdr-title">💰 Resumen financiero</div>
            </div>
            <div class="sec-body">
                <div class="sum-row"><span>Productos</span><span class="sum-val">{{ $totalItems }}</span></div>
                <div class="sum-row"><span>Pallets</span><span class="sum-val">{{ $totalPallets }}</span></div>
                <div class="sum-row"><span>Peso estimado</span><span class="sum-val">{{ number_format($pesoTotal,2) }} kg</span></div>
                <div class="sum-row"><span>Subtotal</span><span class="sum-val">S/ {{ number_format($order->subtotal,2) }}</span></div>
                <div class="sum-row"><span>IGV (18%)</span><span class="sum-val">S/ {{ number_format($order->igv,2) }}</span></div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-top:2px solid var(--erp-border);margin-top:4px;">
                    <span style="font-size:14px;font-weight:800;color:#1e3a5f;">TOTAL</span>
                    <span style="font-size:18px;font-weight:900;color:#1e3a5f;font-family:var(--font-mono);">S/ {{ number_format($order->total,2) }}</span>
                </div>
            </div>
        </div>

        {{-- Info orden --}}
        <div class="sec-card">
            <div class="sec-hdr"><div class="sec-hdr-title">📋 Datos de la orden</div></div>
            <div class="sec-body">
                <div class="sum-row"><span>N° Orden</span><span class="sum-val" style="color:var(--erp-accent);font-size:11px;">{{ $order->numero_orden }}</span></div>
                <div class="sum-row"><span>Cliente</span><span class="sum-val" style="font-size:11px;text-align:right;max-width:150px;">{{ $order->client->razon_social }}</span></div>
                <div class="sum-row"><span>Tipo</span><span><span class="badge badge-blue">🚢 EXPORTACIÓN</span></span></div>
                <div class="sum-row"><span>Fecha</span><span class="sum-val">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}</span></div>
                <div class="sum-row"><span>Estado</span>
                    <span class="badge" style="background:{{ $estadoBg }};color:{{ $estadoColor }};">{{ $order->estado }}</span>
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="sec-card">
            <div class="sec-hdr"><div class="sec-hdr-title">⚡ Acciones</div></div>
            <div class="sec-body" style="display:flex;flex-direction:column;gap:7px;">
                <a href="{{ route('orders.pdf', $order) }}" target="_blank" class="btn-pdf" style="justify-content:center;">
                    📄 Descargar PDF
                </a>
                @if($order->estado != 'COMPLETO')
                <form method="POST" action="{{ route('orders.cerrar', $order) }}">
                    @csrf
                    <button type="submit" class="btn-cerrar" style="width:100%;justify-content:center;"
                            onclick="return confirm('¿Confirmas cerrar esta exportación?')">
                        🔒 Cerrar exportación
                    </button>
                </form>
                @else
                <div style="background:var(--erp-ok-bg);border:1px solid #b7dfca;border-radius:3px;padding:8px;text-align:center;font-size:12px;font-weight:600;color:var(--erp-ok);">
                    ✅ Exportación cerrada
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

</div>{{-- fin layout --}}

</div>
</div>
<script>

function editarFila(id){

    document.getElementById('txtSolicitada'+id).style.display='none';
    document.getElementById('txtDespachada'+id).style.display='none';
    document.getElementById('txtSubtotal'+id).style.display='none';

    document.getElementById('inpSolicitada'+id).style.display='inline-block';
    document.getElementById('inpDespachada'+id).style.display='inline-block';
    document.getElementById('inpPrecio'+id).style.display='inline-block';

    document.getElementById('btnEditar'+id).style.display='none';
    document.getElementById('formEditar'+id).style.display='inline-block';
    document.getElementById('btnCancelar'+id).style.display='inline-block';

}

function cancelarFila(id){

    location.reload();

}

document.querySelectorAll("form[id^='formEditar']").forEach(form=>{

    form.addEventListener("submit",function(){

        let id=this.id.replace('formEditar','');

        document.getElementById('formSolicitada'+id).value=
            document.getElementById('inpSolicitada'+id).value;

        document.getElementById('formDespachada'+id).value=
            document.getElementById('inpDespachada'+id).value;

        document.getElementById('formPrecio'+id).value=
            document.getElementById('inpPrecio'+id).value;

    });

});

</script>
{{-- Forms ocultos para actualizar cada ítem --}}
@foreach($order->details as $item)
<form method="POST"
      action="{{ route('orders.updateDetail', $item) }}"
      id="form-upd-{{ $item->id }}"
      style="display:none;">
    @csrf @method('PUT')
    <input type="hidden" name="cantidad_solicitada" id="h-sol-{{ $item->id }}" value="{{ $item->cantidad_solicitada }}">
    <input type="hidden" name="cantidad_despachada" id="h-des-{{ $item->id }}" value="{{ $item->cantidad_despachada }}">
    <input type="hidden" name="precio_unitario"     id="h-pre-{{ $item->id }}" value="{{ $item->precio_unitario }}">
</form>
@endforeach
<script>
/* ── Sync inputs visibles → hidden ocultos ── */
function syncHidden(id) {
    var sol = document.getElementById('sol-' + id);
    var des = document.getElementById('des-' + id);
    var pre = document.getElementById('h-pre-' + id);

    if (sol) document.getElementById('h-sol-' + id).value = sol.value;
    if (des) document.getElementById('h-des-' + id).value = des.value;
}

/* ── Actualizar barra en tiempo real ── */
function actualizarBarra(id) {
    var sol = parseFloat(document.getElementById('sol-' + id).value) || 0;
    var des = parseFloat(document.getElementById('des-' + id).value) || 0;
    var pct = sol > 0 ? Math.min(100, Math.round(des / sol * 100)) : 0;
    var bc  = pct >= 100 ? '#1c7c4d' : (pct > 0 ? '#f59e0b' : '#c0312b');

    var bar  = document.getElementById('bar-' + id);
    var pctEl = document.getElementById('pct-' + id);

    if (bar)  { bar.style.width = pct + '%'; bar.style.background = bc; }
    if (pctEl){ pctEl.textContent = pct + '%'; pctEl.style.color = bc; }
}

/* ── Habilitar edición de una fila ── */
function editarFila(id) {
    var sol    = document.getElementById('sol-' + id);
    var des    = document.getElementById('des-' + id);
    var btnE   = document.getElementById('btn-edit-' + id);
    var btnS   = document.getElementById('btn-save-' + id);

    sol.disabled = false;
    des.disabled = false;

    sol.style.borderColor     = '#0b5ed7';
    sol.style.background      = '#eff6ff';
    des.style.borderColor     = '#1c7c4d';
    des.style.background      = '#e8f5ee';

    btnE.style.display = 'none';
    btnS.style.display = 'inline-flex';

    des.focus();
    des.select();
}
</script>
@endsection