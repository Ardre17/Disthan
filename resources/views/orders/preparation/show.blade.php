@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-bg:#0f172a;
    --erp-surface:#1e293b;
    --erp-surface2:#334155;
    --erp-border:#334155;
    --erp-ink:#f1f5f9;
    --erp-ink-muted:#94a3b8;
    --erp-accent:#3b82f6;
    --erp-ok:#22c55e;
    --erp-ok-dark:#16a34a;
    --erp-danger:#ef4444;
    --erp-danger-dark:#dc2626;
    --erp-warn:#f59e0b;
    --erp-warn-dark:#d97706;
    --font-ui:'Segoe UI',sans-serif;
    --font-mono:'Consolas',monospace;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{background:var(--erp-bg) !important;}
.page{
    background:var(--erp-bg);
    font-family:var(--font-ui);
    color:var(--erp-ink);
    min-height:100vh;
    padding:0;
}

/* ── Top bar ── */
.erp-bar{
    background:#0f172a;
    border-bottom:1px solid #1e293b;
    height:44px;
    display:flex;align-items:center;justify-content:space-between;
    padding:0 1.25rem;
    margin:-20px -20px 0;
}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;letter-spacing:.3px;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.erp-badge{
    background:#1e293b;color:#94a3b8;
    font-size:11px;padding:3px 10px;border-radius:3px;
    font-family:var(--font-mono);
}

/* ── Body ── */
.body{padding:1rem;max-width:720px;margin:0 auto;}

/* ── Order header ── */
.order-hdr{
    background:#1e293b;border:1px solid #334155;
    border-radius:6px;padding:.85rem 1rem;
    margin-bottom:1rem;
    display:flex;justify-content:space-between;
    align-items:center;flex-wrap:wrap;gap:8px;
}
.order-meta{display:flex;gap:20px;flex-wrap:wrap;}
.order-meta-item{display:flex;flex-direction:column;gap:2px;}
.order-meta-label{font-size:10px;color:#475569;text-transform:uppercase;letter-spacing:.06em;font-weight:600;}
.order-meta-val{font-size:13px;font-weight:700;color:#f1f5f9;}
.tipo-chip{
    display:inline-flex;align-items:center;
    font-size:11px;font-weight:700;padding:3px 10px;
    border-radius:3px;background:#1e40af;color:#93c5fd;
    border:1px solid #1d4ed8;
}

/* ── Progress bar ── */
.prog-section{margin-bottom:1rem;}
.prog-top{
    display:flex;justify-content:space-between;
    align-items:flex-end;margin-bottom:.5rem;
}
.prog-label{font-size:12px;color:#94a3b8;}
.prog-pct{
    font-size:24px;font-weight:800;
    font-family:var(--font-mono);
    color:var(--erp-ok);
}
.prog-counter{font-size:12px;color:#94a3b8;text-align:right;}
.prog-track{
    width:100%;height:16px;
    background:#1e293b;border-radius:99px;
    overflow:hidden;border:1px solid #334155;
}
.prog-fill{
    height:100%;border-radius:99px;
    background:linear-gradient(90deg,#16a34a,#22c55e);
    transition:width .5s ease;
    position:relative;
}
.prog-fill::after{
    content:'';position:absolute;inset:0;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.15));
    border-radius:99px;
}

/* ── Producto card ── */
.producto-card{
    background:#1e293b;
    border:1px solid #334155;
    border-radius:8px;
    overflow:hidden;
    margin-bottom:1rem;
}
.producto-card-top{
    background:#0f172a;
    border-bottom:1px solid #334155;
    padding:.75rem 1rem;
    display:flex;align-items:center;justify-content:space-between;
}
.producto-num{font-size:11px;color:#475569;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.producto-sku{
    font-family:var(--font-mono);
    font-size:12px;color:#64748b;
    background:#1e293b;border:1px solid #334155;
    padding:3px 10px;border-radius:3px;
}
.producto-body{padding:1.5rem 1rem 1rem;}
.producto-nombre{
    font-size:26px;font-weight:900;
    color:#f8fafc;text-align:center;
    margin-bottom:.75rem;line-height:1.2;
}
.advertencia-block{
    background:#451a03;border:1px solid #78350f;
    border-left:4px solid var(--erp-warn);
    border-radius:4px;padding:.75rem 1rem;
    margin-bottom:1rem;
    display:flex;align-items:center;gap:10px;
    font-size:13px;font-weight:600;color:#fde68a;
}

/* ── Cantidades ── */
.cantidades{
    display:grid;grid-template-columns:1fr 1fr 1fr;
    gap:10px;margin-bottom:1.25rem;
}
.cant-block{
    background:#0f172a;border:1px solid #334155;
    border-radius:6px;padding:.75rem;text-align:center;
}
.cant-label{
    font-size:10px;color:#475569;text-transform:uppercase;
    letter-spacing:.06em;font-weight:600;margin-bottom:6px;
}
.cant-val{
    font-size:28px;font-weight:900;
    font-family:var(--font-mono);color:#f1f5f9;line-height:1;
}
.cant-input{
    width:100%;padding:10px;
    font-size:28px;font-weight:900;
    font-family:var(--font-mono);
    text-align:center;
    background:#0f172a;
    border:2px solid var(--erp-accent);
    border-radius:6px;
    color:#f1f5f9;
    outline:none;
    transition:border-color .15s,box-shadow .15s;
}
.cant-input:focus{
    border-color:var(--erp-ok);
    box-shadow:0 0 0 3px rgba(34,197,94,.2);
}
.cant-price{
    font-size:26px;font-weight:900;
    font-family:var(--font-mono);color:#22c55e;line-height:1;
}

/* ── Botones de acción ── */
.acciones{display:flex;flex-direction:column;gap:10px;}
.btn-accion{
    width:100%;padding:18px;
    border:none;border-radius:8px;
    font-size:16px;font-weight:800;
    cursor:pointer;display:flex;
    align-items:center;justify-content:center;gap:10px;
    transition:transform .1s,opacity .15s,box-shadow .15s;
    letter-spacing:.03em;
    position:relative;overflow:hidden;
}
.btn-accion:active{transform:scale(.98);}
.btn-accion::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(180deg,rgba(255,255,255,.08),transparent);
}
.btn-preparado{
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
    box-shadow:0 4px 20px rgba(22,163,74,.4);
}
.btn-preparado:hover{
    box-shadow:0 6px 28px rgba(22,163,74,.6);
    opacity:.95;
}
.btn-preparado:disabled{
    opacity:.5;cursor:not-allowed;
    box-shadow:none;
}
.btn-no-encontrado{
    background:linear-gradient(135deg,#dc2626,#b91c1c);
    color:#fff;
    box-shadow:0 4px 16px rgba(220,38,38,.3);
}
.btn-no-encontrado:hover{
    box-shadow:0 6px 24px rgba(220,38,38,.5);
    opacity:.95;
}
.btn-saltar{
    background:linear-gradient(135deg,#d97706,#b45309);
    color:#fff;
    box-shadow:0 4px 16px rgba(217,119,6,.3);
}
.btn-saltar:hover{
    box-shadow:0 6px 24px rgba(217,119,6,.5);
    opacity:.95;
}

/* ── Saving overlay ── */
.saving-overlay{
    position:fixed;inset:0;background:rgba(0,0,0,.7);
    display:none;align-items:center;justify-content:center;
    z-index:9999;flex-direction:column;gap:12px;
    backdrop-filter:blur(4px);
}
.saving-overlay.show{display:flex;}
.saving-spinner{
    width:48px;height:48px;
    border:4px solid #334155;
    border-top-color:var(--erp-ok);
    border-radius:50%;
    animation:spin .8s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg);}}
.saving-text{color:#f1f5f9;font-size:14px;font-weight:600;}

/* ── Finalizado ── */
.finalizado-card{
    background:#1e293b;border:1px solid #334155;
    border-radius:8px;padding:3rem;text-align:center;
}
.finalizado-icon{font-size:64px;margin-bottom:1rem;display:block;}
.finalizado-title{font-size:24px;font-weight:800;color:#f1f5f9;margin-bottom:.5rem;}
.finalizado-sub{font-size:13px;color:#94a3b8;}
</style>

{{-- Saving overlay --}}
<div class="saving-overlay" id="savingOverlay">
    <div class="saving-spinner"></div>
    <div class="saving-text">Guardando producto...</div>
</div>

<div class="page">

<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Preparación de pedido</div>
    </div>
    <div class="erp-badge">{{ $order->numero_orden }}</div>
</div>

<div class="body">

    {{-- Order header --}}
    <div class="order-hdr">
        <div class="order-meta">
            <div class="order-meta-item">
                <span class="order-meta-label">Orden</span>
                <span class="order-meta-val" style="font-family:var(--font-mono);">
                    {{ $order->numero_orden }}
                </span>
            </div>
            <div class="order-meta-item">
                <span class="order-meta-label">Cliente</span>
                <span class="order-meta-val">{{ $order->client->razon_social }}</span>
            </div>
        </div>
        <span class="tipo-chip">{{ $order->tipo_orden }}</span>
    </div>

    @if($productoActual)

        {{-- Barra de progreso --}}
        <div class="prog-section">
            <div class="prog-top">
                <div>
                    <div class="prog-label">Progreso de preparación</div>
                </div>
                <div style="text-align:right;">
                    <div class="prog-pct">{{ $progreso }}%</div>
                    <div class="prog-counter">
                        Producto {{ $numeroProducto }} de {{ $total }}
                    </div>
                </div>
            </div>
            <div class="prog-track">
                <div class="prog-fill" style="width:{{ $progreso }}%;"></div>
            </div>
        </div>

        {{-- Tarjeta del producto --}}
        <div class="producto-card">
            <div class="producto-card-top">
                <span class="producto-num">
                    Producto {{ $numeroProducto }} / {{ $total }}
                </span>
                <span class="producto-sku">
                    SKU: {{ $productoActual->product->sku ?? '—' }}
                </span>
            </div>

            <div class="producto-body">

                <div class="producto-nombre">
                    {{ $productoActual->product->nombre }}
                </div>

                @if(!empty($productoActual->product->advertencias))
                <div class="advertencia-block">
                    <span style="font-size:20px;flex-shrink:0;">⚠️</span>
                    <span>{{ $productoActual->product->advertencias }}</span>
                </div>
                @endif

                {{-- Cantidades --}}
                <div class="cantidades">
                    <div class="cant-block">
                        <div class="cant-label">Solicitado</div>
                        <div class="cant-val">
                            {{ $productoActual->cantidad_solicitada }}
                        </div>
                    </div>
                    <div class="cant-block" style="border-color:var(--erp-accent);">
                        <div class="cant-label" style="color:#7eb8f7;">Preparado</div>
                        <input
                            id="cantidad_preparada"
                            type="number"
                            class="cant-input"
                            value="{{ $productoActual->cantidad_solicitada }}">
                    </div>
                    <div class="cant-block">
                        <div class="cant-label">Precio unit.</div>
                        <div class="cant-price">
                            S/ {{ number_format($productoActual->precio_unitario,2) }}
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="acciones">
                    <button id="btnPreparado" class="btn-accion btn-preparado">
                        <span style="font-size:22px;">✔</span>
                        PRODUCTO PREPARADO
                    </button>
                    <button id="btnNoEncontrado" class="btn-accion btn-no-encontrado">
                        <span style="font-size:22px;">❌</span>
                        NO ENCONTRADO
                    </button>
                    <button id="btnSaltar" class="btn-accion btn-saltar">
                        <span style="font-size:22px;">⏭</span>
                        SALTAR
                    </button>
                </div>

            </div>
        </div>

    @else

        {{-- Pedido finalizado --}}
        <div class="finalizado-card">
            <span class="finalizado-icon">🎉</span>
            <div class="finalizado-title">¡Pedido armado correctamente!</div>
            <div class="finalizado-sub">
                Todos los productos fueron preparados.
            </div>
            <div style="margin-top:1.5rem;">
                <a href="{{ route('orders.index') }}"
                   style="
                       display:inline-flex;align-items:center;gap:6px;
                       padding:10px 20px;
                       background:var(--erp-ok);color:#fff;
                       border-radius:6px;font-size:13px;font-weight:700;
                       text-decoration:none;
                   ">
                    ← Volver a órdenes
                </a>
            </div>
        </div>

    @endif

</div>
</div>
@if($productoActual)
<script>

document.addEventListener("DOMContentLoaded", function () {

    const btnPreparado = document.getElementById("btnPreparado");
    const btnNoEncontrado = document.getElementById("btnNoEncontrado");
    const btnSaltar = document.getElementById("btnSaltar");

    function enviar(url, datos = {}){

        document.getElementById("savingOverlay").classList.add("show");

        fetch(url,{

            method:"POST",

            headers:{
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":"{{ csrf_token() }}",
                "Accept":"application/json"
            },

            body:JSON.stringify(datos)

        })

        .then(r=>r.json())

        .then(data=>{

            location.reload();

        })

        .catch(e=>{

            console.error(e);

            alert("Ocurrió un error.");

            document.getElementById("savingOverlay").classList.remove("show");

        });

    }

    if(btnPreparado){

        btnPreparado.addEventListener("click",function(){

            enviar(
                "{{ route('preparation.save',$productoActual->id) }}",
                {
                    cantidad_preparada:document.getElementById("cantidad_preparada").value,
                    observacion:""
                }
            );

        });

    }

    if(btnNoEncontrado){

        btnNoEncontrado.addEventListener("click",function(){

            enviar(
                "{{ route('preparation.notFound',$productoActual->id) }}"
            );

        });

    }

    if(btnSaltar){

        btnSaltar.addEventListener("click",function(){

            enviar(
                "{{ route('preparation.skip',$productoActual->id) }}"
            );

        });

    }

});

</script>
@endif
@endsection