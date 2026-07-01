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
.erp-badge{
    background:#152d4d;color:#7eb8f7;
    font-size:11px;padding:3px 10px;border-radius:3px;
    font-family:var(--font-mono);letter-spacing:.5px;
}

/* ── Body ── */
.body{padding:1.1rem;}

/* ── Page header ── */
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{
    font-size:17px;font-weight:700;color:#0f172a;
    display:flex;align-items:center;gap:8px;
}
.page-title:before{
    content:"";width:4px;height:20px;
    background:var(--erp-accent);border-radius:2px;display:inline-block;
}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.breadcrumb{font-size:11px;color:#94a3b8;display:flex;align-items:center;gap:5px;}

/* ── Grid ── */
.grid-main{display:grid;grid-template-columns:1fr 280px;gap:12px;}
@media(max-width:800px){.grid-main{grid-template-columns:1fr;}}

/* ── Card ── */
.card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;}
.card-hdr{
    background:#f4f6f9;border-bottom:1px solid var(--erp-border);
    padding:.65rem 1rem;display:flex;align-items:center;gap:7px;
}
.card-hdr-title{
    font-size:11px;font-weight:700;color:var(--erp-ink);
    text-transform:uppercase;letter-spacing:.06em;
}
.card-hdr-num{
    width:18px;height:18px;border-radius:50%;
    background:var(--erp-accent);color:#fff;
    font-size:10px;font-weight:700;
    display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.card-body{padding:1rem;}

/* ── Fields ── */
.field-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.field{display:flex;flex-direction:column;gap:3px;}
.field-full{grid-column:1/-1;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.required-star{color:var(--erp-danger);margin-left:2px;}
.finput,
.fselect,
.ftarea{
    padding:7px 9px;
    border:1px solid var(--erp-border);
    border-radius:3px;
    font-size:12px;
    color:var(--erp-ink);
    background:#fbfcfe;
    outline:none;
    width:100%;
    font-family:var(--font-ui);
    transition:border-color .15s;
}
.finput:focus,.fselect:focus,.ftarea:focus{
    border-color:var(--erp-accent);
    box-shadow:0 0 0 2px rgba(11,94,215,.1);
}
.ftarea{resize:vertical;min-height:90px;}
.field-hint{font-size:10px;color:#94a3b8;margin-top:1px;}

/* ── Botones ── */
.btn-row{
    display:flex;gap:8px;
    margin-top:1rem;padding-top:.85rem;
    border-top:1px solid #f1f5f9;
}
.btn-primary{
    padding:9px 20px;background:var(--erp-accent);color:#fff;
    border:none;border-radius:3px;font-size:12px;font-weight:600;
    cursor:pointer;display:inline-flex;align-items:center;gap:5px;
    text-decoration:none;transition:background .15s;
}
.btn-primary:hover{background:var(--erp-accent-dark);}
.btn-cancel{
    padding:9px 16px;background:#fff;color:var(--erp-ink-muted);
    border:1px solid var(--erp-border);border-radius:3px;
    font-size:12px;font-weight:600;cursor:pointer;
    text-decoration:none;display:inline-flex;align-items:center;gap:5px;
    transition:background .15s;
}
.btn-cancel:hover{background:#f4f6f9;}

/* ── Panel lateral ── */
.right-col{display:flex;flex-direction:column;gap:10px;}
.status-chip{
    display:inline-flex;align-items:center;gap:5px;
    padding:4px 12px;border-radius:3px;font-size:11px;font-weight:700;
    background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;
}
.resumen-row{
    display:flex;justify-content:space-between;align-items:center;
    font-size:12px;padding:6px 0;
    border-bottom:1px solid #f4f6f9;color:var(--erp-ink-muted);
}
.resumen-row:last-child{border:none;}
.resumen-val{font-weight:600;color:var(--erp-ink);}
.resumen-total{
    display:flex;justify-content:space-between;align-items:center;
    padding:8px 0;margin-top:4px;border-top:2px solid var(--erp-border);
}
.info-row{
    display:flex;align-items:flex-start;gap:8px;
    padding:6px 0;border-bottom:1px solid #f4f6f9;
    font-size:11px;color:var(--erp-ink-muted);line-height:1.5;
}
.info-row:last-child{border:none;}
.info-icon{color:var(--erp-accent);font-size:14px;flex-shrink:0;margin-top:1px;}
</style>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-sep"></div>
        <div class="erp-module">Nueva orden</div>
    </div>
    <div class="erp-badge">ORD-AUTO</div>
</div>

<div class="body">

    <div class="page-hdr">
        <div>
            <div class="page-title">Nueva orden de pedido</div>
            <div class="page-sub">Registro de pedidos y programación logística</div>
        </div>
        <div class="breadcrumb">
            🏠 Órdenes › Nueva orden
        </div>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="grid-main">

            {{-- ── Columna izquierda ── --}}
            <div style="display:flex;flex-direction:column;gap:10px;">

                {{-- Sección 1: Información general --}}
                <div class="card">
                    <div class="card-hdr">
                        <div class="card-hdr-num">1</div>
                        <div class="card-hdr-title">Información general</div>
                    </div>
                    <div class="card-body">
                        <div class="field-grid">

                            <div class="field">
                                <label class="flabel">
                                    Cliente <span class="required-star">*</span>
                                </label>
                                <select name="client_id" class="fselect" required>
                                    <option value="">Seleccionar cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">
                                            {{ $client->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="field">
                                <label class="flabel">
                                    Tipo de orden <span class="required-star">*</span>
                                </label>
                                <select name="tipo_orden" class="fselect" required>
                                    <option value="LOCAL">LOCAL</option>
                                    <option value="ENCOMIENDA">ENCOMIENDA</option>
                                    <option value="SUPERMERCADO">SUPERMERCADO</option>
                                    <option value="EXPORTACION">EXPORTACION</option>
                                    <option value="MUESTRA">MUESTRA</option>
                                </select>
                            </div>

                            <div class="field">
                                <label class="flabel">
                                    Fecha de pedido <span class="required-star">*</span>
                                </label>
                                <input type="date"
                                       name="fecha_pedido"
                                       class="finput"
                                       value="{{ date('Y-m-d') }}"
                                       required>
                            </div>

                            <div class="field">
                                <label class="flabel">Fecha de entrega</label>
                                <input type="date"
                                       name="fecha_entrega"
                                       class="finput">
                                <span class="field-hint">Opcional — si aplica</span>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Sección 2: Observaciones --}}
                <div class="card">
                    <div class="card-hdr">
                        <div class="card-hdr-num">2</div>
                        <div class="card-hdr-title">Observaciones y notas</div>
                    </div>
                    <div class="card-body">
                        <div class="field">
                            <label class="flabel">Observaciones</label>
                            <textarea name="observaciones"
                                      class="ftarea"
                                      placeholder="Instrucciones especiales, referencias de pedido, condiciones de entrega..."></textarea>
                            <span class="field-hint">
                                Información adicional que el operario debe conocer al procesar la orden
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="btn-row">
                    <button type="submit" class="btn-primary">
                        💾 Guardar orden
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn-cancel">
                        ✕ Cancelar
                    </a>
                </div>

            </div>

            {{-- ── Panel lateral ── --}}
            <div class="right-col">

                {{-- Estado inicial --}}
                <div class="card">
                    <div class="card-hdr">
                        <div class="card-hdr-title">Estado inicial</div>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom:.75rem;">
                            <span class="status-chip">
                                ⚠️ INCOMPLETO
                            </span>
                        </div>
                        <div style="font-size:11px;color:#64748b;line-height:1.6;">
                            La orden se crea en estado <strong>Incompleto</strong>
                            y avanza conforme se agregan y despachan productos.
                        </div>
                    </div>
                </div>
                    
                {{-- Aviso cliente --}}
<div class="card" style="border-color:#fde68a;">
    <div class="card-hdr" style="background:#fef9c3;border-bottom-color:#fde68a;">
        <div class="card-hdr-title" style="color:#b45309;">
            ⚠️ Advertencia
        </div>
    </div>
    <div class="card-body">
        <div style="display:flex;flex-direction:column;gap:10px;">

            <div style="
                background:#fef3c7;
                border:1px solid #fde68a;
                border-radius:3px;
                padding:10px 12px;
                font-size:12px;
                color:#b45309;
                line-height:1.6;
                font-weight:600;
            ">
                ¿No aparece el cliente en la lista?
            </div>

            <div style="font-size:11px;color:#5b6b7d;line-height:1.7;">
                Si el cliente que buscas <strong>no aparece en el selector</strong>,
                es porque aún no está registrado en el sistema.
            </div>

            <div style="font-size:11px;color:#5b6b7d;line-height:1.7;">
                Antes de continuar con esta orden, debes
                <strong style="color:#b45309;">registrar al cliente</strong>
                en el módulo correspondiente.
            </div>

            <a href="{{ route('clients.create') }}"
               style="
                   display:flex;
                   align-items:center;
                   justify-content:center;
                   gap:6px;
                   padding:9px;
                   background:#fff;
                   color:#b45309;
                   border:1px solid #f59e0b;
                   border-radius:3px;
                   font-size:12px;
                   font-weight:700;
                   text-decoration:none;
                   transition:background .15s;
               "
               onmouseover="this.style.background='#fef3c7'"
               onmouseout="this.style.background='#fff'"
            >
                ➕ Registrar nuevo cliente
            </a>

            <div style="
                border-top:1px solid #f1f5f9;
                padding-top:8px;
                font-size:10px;
                color:#94a3b8;
                line-height:1.6;
            ">
                Una vez registrado, recarga esta página y el cliente aparecerá disponible en el selector.
            </div>

        </div>
    </div>
</div>  

                {{-- Flujo --}}
                <div class="card">
                    <div class="card-hdr">
                        <div class="card-hdr-title">Flujo de la orden</div>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-icon">①</span>
                            <span>Crea la orden con cliente y tipo</span>
                        </div>
                        <div class="info-row">
                            <span class="info-icon">②</span>
                            <span>Agrega productos desde la vista de edición</span>
                        </div>
                        <div class="info-row">
                            <span class="info-icon">③</span>
                            <span>El operario completa el despacho</span>
                        </div>
                        <div class="info-row">
                            <span class="info-icon">④</span>
                            <span>La orden cierra al completarse</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

</div>
</div>

@endsection