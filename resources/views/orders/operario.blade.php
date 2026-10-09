@extends('layouts.app')

@section('content')

<style>
html, body { max-width:100%; overflow-x:hidden; -webkit-text-size-adjust:100%; }

.op-wrap{
    --op-bg:#f3f6fb; --op-card:#ffffff; --op-line:#e3e9f2; --op-text:#14213d; --op-muted:#6b7a90;
    --op-blue:#1f6bff; --op-blue-d:#1857d6; --op-blue-s:#e8f0ff;
    --op-green:#16a34a; --op-green-s:#e3f6ea;
    --op-amber:#f59e0b; --op-amber-s:#fff3dc;
    --op-red:#ef4444;   --op-red-s:#fde8e8;
    background:var(--op-bg); min-height:100vh; margin:-20px; padding:20px;
    font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; color:var(--op-text);
}
.op-wrap, .op-wrap *, .op-wrap *::before, .op-wrap *::after{ box-sizing:border-box; }
.op-page{ max-width:1180px; margin:0 auto; width:100%; }
.ic{ width:18px; height:18px; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; flex-shrink:0; }
.ic.sm{ width:15px; height:15px; } .ic.lg{ width:26px; height:26px; }
.op-mono{ font-family:ui-monospace,SFMono-Regular,Menlo,Consolas,monospace; }

/* Encabezado */
.op-top{ display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:16px; }
.op-top-l{ display:flex; align-items:center; gap:12px; }
.op-top-l .ic{ width:34px; height:34px; color:var(--op-blue); }
.op-title{ font-size:22px; font-weight:700; margin:0; line-height:1.2; }
.op-sub-t{ font-size:13px; color:var(--op-muted); margin-top:2px; }

/* Botones */
.op-btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; border:1px solid transparent; border-radius:8px; padding:10px 16px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; transition:background .15s,border-color .15s,opacity .15s; }
.op-btn.primary{ background:var(--op-blue); color:#fff; }
.op-btn.primary:hover{ background:var(--op-blue-d); }
.op-btn.ghost{ background:#fff; color:var(--op-text); border-color:var(--op-line); }
.op-btn.ghost:hover{ background:#f6f8fc; }
.op-btn.soft{ background:var(--op-blue-s); color:var(--op-blue); border-color:#d3e2ff; }
.op-btn.green{ background:var(--op-green); color:#fff; }
.op-btn.green:hover{ background:#15803d; }
.op-btn:focus-visible, .op-tab:focus-visible, .op-icon-btn:focus-visible{ outline:2px solid var(--op-blue); outline-offset:2px; }
.op-btn:disabled{ cursor:not-allowed; }
.op-btn .op-spin{ display:none; }
.op-btn.is-loading{ opacity:.9; pointer-events:none; }
.op-btn.is-loading .op-spin{ display:inline-block; }
.op-btn.is-loading .op-btn-ico{ display:none; }

/* Icono de carga */
.op-spin{ width:16px; height:16px; border:2px solid rgba(255,255,255,.4); border-top-color:#fff; border-radius:50%; animation:opSpin .7s linear infinite; flex-shrink:0; }
.op-spin.dark{ border-color:rgba(31,107,255,.25); border-top-color:var(--op-blue); }
.op-spin.lg{ width:34px; height:34px; border-width:3px; }
@keyframes opSpin{ to{ transform:rotate(360deg); } }

/* Tarjetas */
.op-card{ background:var(--op-card); border:1px solid var(--op-line); border-radius:12px; padding:16px 18px; box-shadow:0 1px 2px rgba(20,33,61,.04); }
.op-h{ font-size:15px; font-weight:700; margin:0 0 12px; display:flex; align-items:center; gap:8px; }
.op-gap{ margin-bottom:16px; }

/* Tarjeta de orden */
.op-order{ display:grid; grid-template-columns:minmax(0,1.5fr) repeat(4,minmax(0,1fr)); gap:12px; align-items:stretch; }
.op-order-main{ display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
.op-avatar{ width:44px; height:44px; border-radius:50%; background:var(--op-blue-s); color:var(--op-blue); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.op-lbl{ font-size:11px; color:var(--op-muted); }
.op-order-num{ font-size:22px; font-weight:800; line-height:1.15; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.op-order-client{ font-size:13px; font-weight:600; margin-top:2px; }
.op-chip{ display:inline-flex; align-items:center; gap:6px; background:var(--op-green-s); color:#166534; border-radius:99px; padding:3px 10px; font-size:11px; font-weight:700; }
.op-chip.blue{ background:var(--op-blue-s); color:var(--op-blue); }
.op-badge{ border-radius:99px; padding:3px 10px; font-size:10px; font-weight:800; letter-spacing:.03em; }
.op-badge.ok{ background:var(--op-green); color:#fff; } .op-badge.warn{ background:var(--op-amber); color:#fff; } .op-badge.bad{ background:var(--op-red); color:#fff; }
.op-kpi{ border:1px solid var(--op-line); border-radius:10px; padding:12px; display:flex; align-items:center; gap:12px; background:#fff; }
.op-kpi-ico{ width:42px; height:42px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.op-kpi-ico.blue{ background:var(--op-blue-s); color:var(--op-blue); } .op-kpi-ico.green{ background:var(--op-green-s); color:var(--op-green); } .op-kpi-ico.amber{ background:var(--op-amber-s); color:var(--op-amber); }
.op-kpi-val{ font-size:22px; font-weight:800; line-height:1; }
.op-kpi-lab{ font-size:11px; color:var(--op-muted); margin-top:3px; }
.op-ring{ --p:0; --c:var(--op-blue); width:42px; height:42px; border-radius:50%; flex-shrink:0; background:conic-gradient(var(--c) calc(var(--p) * 1%), #e3e9f2 0); position:relative; }
.op-ring::after{ content:""; position:absolute; inset:6px; background:#fff; border-radius:50%; }
.op-kpi-prog{ flex:1; min-width:0; }
.op-track{ width:100%; height:6px; background:#e3e9f2; border-radius:99px; overflow:hidden; margin-top:6px; }
.op-fill{ height:100%; border-radius:99px; background:var(--op-blue); transition:width .4s ease; }

/* Rejilla principal */
.op-grid{ display:grid; grid-template-columns:minmax(0,1fr) 320px; gap:16px; align-items:stretch; }
.op-main{ display:flex; flex-direction:column; gap:16px; min-width:0; }

/* Pestañas + escáner */
.op-tabs{ display:flex; gap:22px; border-bottom:1px solid var(--op-line); margin:-4px 0 14px; overflow-x:auto; }
.op-tab{ background:none; border:none; border-bottom:2px solid transparent; padding:8px 2px 11px; font-size:13px; font-weight:600; color:var(--op-muted); display:flex; align-items:center; gap:7px; cursor:pointer; white-space:nowrap; font-family:inherit; }
.op-tab.active{ color:var(--op-blue); border-bottom-color:var(--op-blue); }
.op-scan-row{ display:flex; gap:12px; }
.op-input-wrap{ position:relative; flex:1; min-width:0; }
.op-input-wrap > .ic{ position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#4a5a75; }
.scanner-input{ width:100%; padding:12px 14px 12px 44px; font-size:15px; border-radius:8px; border:1.5px solid var(--op-blue); background:#fff; color:var(--op-text); outline:none; font-family:inherit; }
.scanner-input:focus{ box-shadow:0 0 0 3px rgba(31,107,255,.15); }
.scanner-input::placeholder{ color:#8b98ad; font-size:13px; }
.op-hint{ font-size:11px; color:var(--op-muted); margin-top:8px; }
.op-hint kbd{ background:#eef2f8; border:1px solid var(--op-line); border-radius:4px; padding:0 5px; font-family:inherit; font-weight:700; color:var(--op-text); }

/* Producto seleccionado */
.op-empty{ display:flex; flex-direction:column; align-items:center; gap:8px; padding:26px 12px; color:var(--op-muted); font-size:13px; text-align:center; border:1.5px dashed var(--op-line); border-radius:10px; }
.op-empty .ic{ width:32px; height:32px; color:#b3bfd1; }
.activo-box{ display:none; }
.op-prod-head{ display:grid; grid-template-columns:96px minmax(0,1fr) minmax(0,1.5fr); gap:16px; align-items:center; margin-bottom:16px; }
.op-prod-img{ width:96px; height:96px; border-radius:10px; background:#f1f5fb; border:1px solid var(--op-line); display:flex; align-items:center; justify-content:center; color:#9fb0c8; }
.op-prod-img .ic{ width:42px; height:42px; }
.activo-name{ font-size:18px; font-weight:800; line-height:1.2; word-break:break-word; }
.op-prod-tags{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:8px; font-size:12px; color:var(--op-muted); }
.op-prod-tags .op-chip{ background:var(--op-blue-s); color:var(--op-blue); border-radius:6px; }
.op-prod-meta{ font-size:12px; color:var(--op-muted); margin-top:8px; line-height:1.6; }
.op-prod-meta strong{ color:var(--op-text); }
.op-stats{ display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:8px; }
.op-stat{ border:1px solid var(--op-line); border-radius:10px; padding:10px 8px; text-align:center; background:#fff; }
.op-stat-l{ font-size:11px; color:var(--op-muted); }
.op-stat-v{ font-size:20px; font-weight:800; margin-top:4px; }
.op-stat-v.green{ color:var(--op-green); } .op-stat-v.amber{ color:var(--op-amber); }
.op-form{ display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px 14px; margin-bottom:14px; }
.op-field label{ display:block; font-size:12px; font-weight:600; margin-bottom:5px; }
.op-field label span{ color:var(--op-muted); font-weight:500; }
.op-ctrl{ position:relative; display:flex; align-items:center; }
.op-ctrl > .ic{ position:absolute; left:11px; color:#4a5a75; pointer-events:none; }
.activo-input{ width:100%; padding:10px 12px 10px 36px; border-radius:8px; border:1px solid var(--op-line); background:#fff; color:var(--op-text); font-size:14px; outline:none; font-family:inherit; }
.activo-input:focus{ border-color:var(--op-blue); box-shadow:0 0 0 3px rgba(31,107,255,.12); }
.activo-input[readonly]{ background:#f7f9fc; color:#3d4c66; }
.op-ctrl.has-btn .activo-input{ padding-right:40px; }
.op-icon-btn{ background:none; border:none; color:var(--op-blue); width:32px; height:32px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
.op-icon-btn:hover{ background:var(--op-blue-s); }
.op-ctrl .op-icon-btn{ position:absolute; right:4px; }
.op-qty{ display:flex; gap:8px; }
.op-qty .activo-input{ padding:10px 8px; text-align:center; font-size:18px; font-weight:800; }
.op-qty-btn{ width:42px; flex-shrink:0; border-radius:8px; border:1px solid var(--op-line); background:#fff; color:var(--op-text); display:flex; align-items:center; justify-content:center; cursor:pointer; }
.op-qty-btn.plus{ background:#cfe0ff; border-color:#b9d1ff; color:var(--op-blue); }
.op-qty-btn:hover{ filter:brightness(.97); }
.op-field-hint{ font-size:10px; color:var(--op-muted); margin-top:4px; }
.op-oct{ min-height:41px; border:1px solid var(--op-line); border-radius:8px; background:#f7f9fc; display:flex; align-items:center; gap:6px; flex-wrap:wrap; padding:6px 10px 6px 36px; position:relative; font-size:12px; color:var(--op-muted); }
.op-oct > .ic{ position:absolute; left:11px; top:12px; color:#4a5a75; }
.op-oct-tag{ background:var(--op-amber-s); color:#92400e; border-radius:6px; padding:2px 8px; font-size:11px; font-weight:700; }
.op-actions{ display:grid; grid-template-columns:2fr 1fr; gap:12px; }
.op-actions .op-btn{ padding:12px 16px; font-size:14px; }

/* Cámara lateral */
.op-cam{ display:flex; flex-direction:column; gap:14px; }
.op-cam-preview{ border:none; padding:0; cursor:pointer; border-radius:10px; overflow:hidden; background:radial-gradient(circle at 50% 40%,#5b6470,#232831); height:180px; position:relative; display:flex; align-items:center; justify-content:center; }
.op-cam-frame{ width:78%; height:62%; border-radius:8px; position:relative; display:flex; align-items:center; justify-content:center; }
.op-cam-frame::before, .op-cam-frame::after{ content:""; position:absolute; width:22px; height:22px; border:3px solid #22c55e; }
.op-cam-frame::before{ top:0; left:0; border-right:none; border-bottom:none; border-radius:6px 0 0 0; }
.op-cam-frame::after{ bottom:0; right:0; border-left:none; border-top:none; border-radius:0 0 6px 0; }
.op-cam-code{ background:#f2f2f2; border-radius:4px; padding:6px 10px; width:70%; }
.op-cam-code svg{ width:100%; height:44px; display:block; }
.op-cam-line{ position:absolute; left:4%; right:4%; top:50%; height:2px; background:#ef4444; box-shadow:0 0 8px #ef4444; animation:opScan 2s ease-in-out infinite; }
@keyframes opScan{ 0%,100%{ transform:translateY(-34px); } 50%{ transform:translateY(34px); } }
.op-note{ background:var(--op-blue-s); border-radius:10px; padding:12px; display:flex; gap:10px; font-size:12px; color:#27456f; line-height:1.45; }
.op-note .ic{ color:var(--op-blue); margin-top:1px; }

/* Tabla de productos */
.op-table-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; gap:8px; }
.op-table-head .op-h{ margin:0; }
.op-table-scroll{ overflow-x:auto; }
.op-table{ width:100%; border-collapse:collapse; font-size:13px; min-width:860px; }
.op-table th{ text-align:left; font-size:11px; font-weight:700; color:var(--op-muted); background:#f7f9fc; padding:9px 10px; border-bottom:1px solid var(--op-line); white-space:nowrap; }
.op-table td{ padding:11px 10px; border-bottom:1px solid var(--op-line); vertical-align:middle; }
.op-table tbody tr:first-child td:first-child{ border-top-left-radius:0; }
.op-table tbody tr td:first-child{ box-shadow:inset 4px 0 0 var(--lc,transparent); }
.op-table tbody tr:hover{ background:#f9fbfe; }
.op-table tr.op-flash{ animation:opFlash 1.5s ease; }
@keyframes opFlash{ 0%,60%{ background:#dce8ff; } 100%{ background:transparent; } }
.op-st{ width:24px; height:24px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:#fff; }
.op-st .ic{ width:14px; height:14px; stroke-width:3; }
.op-st.ok{ background:var(--op-green); } .op-st.warn{ background:var(--op-amber); } .op-st.bad{ background:var(--op-red); }
.op-pname{ font-weight:600; }
.op-psub{ font-size:11px; color:var(--op-muted); margin-top:2px; }
.op-psub strong{ color:var(--op-text); }
.op-caja{ display:block; font-size:10px; color:var(--op-muted); margin-top:2px; }
.op-num{ font-weight:700; font-variant-numeric:tabular-nums; }
.op-avance{ display:flex; align-items:center; gap:8px; min-width:150px; }
.op-avance .op-pct{ font-weight:800; min-width:44px; font-variant-numeric:tabular-nums; }
.op-avance .op-track{ margin:0; height:6px; flex:1; }
.op-row-actions{ display:flex; gap:2px; justify-content:flex-end; }
.op-lote-line{ font-size:12px; line-height:1.5; white-space:nowrap; }
.op-lote-line span{ color:var(--op-muted); }

/* Cerrar orden */
.btn-cerrar{ width:100%; margin-top:16px; padding:14px; font-size:15px; }

/* Toast */
.op-toast{ position:fixed; top:16px; right:16px; z-index:10050; padding:11px 16px; border-radius:10px; font-size:13px; font-weight:600; display:none; align-items:center; gap:8px; background:#fff; border:1px solid var(--op-line); box-shadow:0 8px 28px rgba(20,33,61,.18); max-width:calc(100vw - 32px); }
.op-toast.show{ display:flex; animation:toastIn .2s; }
@keyframes toastIn{ from{ opacity:0; transform:translateY(-10px); } to{ opacity:1; transform:translateY(0); } }
.op-toast.tok{ border-left:4px solid var(--op-green); } .op-toast.twk{ border-left:4px solid var(--op-amber); } .op-toast.ter{ border-left:4px solid var(--op-red); }

/* Modales */
.op-overlay{ display:none; position:fixed; inset:0; background:rgba(15,23,42,.55); z-index:10001; align-items:center; justify-content:center; padding:16px; }
.op-modal{ width:100%; max-width:430px; background:#fff; border-radius:14px; box-shadow:0 20px 50px rgba(15,23,42,.35); overflow:hidden; animation:popup .25s; }
.op-modal-head{ display:flex; justify-content:space-between; align-items:center; padding:14px 16px; border-bottom:1px solid var(--op-line); font-weight:700; }
.op-modal-head > span{ display:flex; align-items:center; gap:8px; }
.op-modal-body{ padding:16px; }
.op-modal-warn{ background:var(--op-amber-s); border:1px solid #f6d58f; color:#7a4a05; border-radius:10px; padding:10px 12px; font-size:12px; line-height:1.45; margin-bottom:14px; }
.op-modal-label{ display:block; font-size:12px; font-weight:600; margin:0 0 4px; }
.op-modal-input{ width:100%; padding:10px 12px; border-radius:8px; border:1px solid var(--op-line); background:#fff; color:var(--op-text); font-size:14px; outline:none; margin-bottom:12px; font-family:inherit; }
.op-modal-input:focus{ border-color:var(--op-blue); }
.op-modal-actions{ display:flex; justify-content:flex-end; gap:8px; }
.op-det-row{ display:flex; justify-content:space-between; gap:12px; padding:9px 0; border-bottom:1px solid var(--op-line); font-size:13px; }
.op-det-row:last-child{ border-bottom:none; }
.op-det-row span{ color:var(--op-muted); } .op-det-row strong{ text-align:right; }
@keyframes popup{ from{ transform:scale(.8); opacity:0; } to{ transform:scale(1); opacity:1; } }

/* Modal octógonos */
#modalOctogonos{ display:none; position:fixed; inset:0; background:rgba(15,23,42,.6); z-index:9999; justify-content:center; align-items:center; padding:16px; }
.op-oct-box{ background:#fff; width:420px; max-width:100%; border-radius:18px; padding:25px; text-align:center; box-shadow:0 20px 40px rgba(0,0,0,.35); animation:popup .25s; }
.op-oct-box h2{ margin:0; color:#dc2626; font-size:24px; }
#modalProducto{ margin-top:12px; font-size:18px; font-weight:700; color:var(--op-text); }
#modalAdvertencias{ margin:22px 0; display:flex; justify-content:center; gap:12px; flex-wrap:wrap; }
#modalAdvertencias img{ height:120px; object-fit:contain; }
.op-oct-fallback{ background:#111; color:#fff; font-weight:800; padding:14px 16px; border-radius:6px; font-size:13px; }
.op-oct-text{ font-size:14px; color:#475569; margin-bottom:20px; }

/* Cámara (modal) */
#camaraModal{ display:none; position:fixed; inset:0; background:rgba(0,0,0,.78); z-index:10000; align-items:center; justify-content:center; padding:12px; }
#camaraModal.open{ display:flex; }
.camara-dialog{ width:100%; max-width:520px; background:#0f172a; border:1px solid #334155; border-radius:14px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.55); }
.camara-hdr{ display:flex; align-items:center; justify-content:space-between; padding:12px 14px; border-bottom:1px solid #334155; }
.camara-hdr-title{ font-size:13px; font-weight:700; color:#f8fafc; display:flex; align-items:center; gap:8px; }
.camara-hdr-pulse{ width:8px; height:8px; border-radius:50%; background:#22c55e; animation:pulse 1.4s infinite; }
@keyframes pulse{ 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:.3; transform:scale(.8); } }
.btn-camara-cerrar{ background:transparent; border:none; color:#94a3b8; font-size:20px; cursor:pointer; }
#camaraVisor{ position:relative; background:#000; min-height:300px; overflow:hidden; }
#camaraVisor video{ width:100%!important; height:auto!important; display:block; }
.scan-frame{ position:absolute; z-index:3; inset:50% auto auto 50%; width:260px; height:150px; transform:translate(-50%,-50%); pointer-events:none; border:2px solid #3b82f6; border-radius:10px; box-shadow:0 0 0 9999px rgba(0,0,0,.28); }
.scan-line{ position:absolute; left:8px; right:8px; top:50%; height:2px; background:#22c55e; box-shadow:0 0 8px #22c55e; animation:scanAnim 1.8s ease-in-out infinite; }
@keyframes scanAnim{ 0%,100%{ transform:translateY(-55px); } 50%{ transform:translateY(55px); } }
.cam-loading{ position:absolute; inset:0; z-index:5; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px; background:rgba(15,23,42,.85); color:#e2e8f0; font-size:13px; }
.camara-result{ padding:10px 14px; text-align:center; border-top:1px solid #334155; min-height:42px; color:#94a3b8; font-size:12px; }
.camara-result-code{ font-family:monospace; color:#22c55e; font-size:15px; font-weight:700; }
.camara-hint{ padding:0 14px 13px; text-align:center; color:#64748b; font-size:10px; }

/* Responsive */
@media (max-width:1020px){
    .op-order{ grid-template-columns:repeat(2,minmax(0,1fr)); }
    .op-order-main{ grid-column:1 / -1; }
    .op-grid{ grid-template-columns:minmax(0,1fr); }
    .op-cam{ display:none; }
    .op-prod-head{ grid-template-columns:84px minmax(0,1fr); }
    .op-prod-img{ width:84px; height:84px; }
    .op-stats{ grid-column:1 / -1; }
    .op-form{ grid-template-columns:repeat(2,minmax(0,1fr)); }
}
@media (max-width:760px){
    .op-wrap{ padding:12px; }
    .op-title{ font-size:19px; }
    .op-scan-row{ flex-direction:column; }
    .op-form{ grid-template-columns:minmax(0,1fr); }
    .op-stats{ grid-template-columns:repeat(2,minmax(0,1fr)); }
    .op-table{ min-width:0; }
    .op-table thead{ display:none; }
    .op-table, .op-table tbody, .op-table tr, .op-table td{ display:block; width:100%; }
    .op-table tr{ border:1px solid var(--op-line); border-radius:10px; margin-bottom:10px; padding:6px 12px; box-shadow:inset 4px 0 0 var(--lc,transparent); }
    .op-table tbody tr td:first-child{ box-shadow:none; }
    .op-table td{ display:flex; justify-content:space-between; align-items:center; gap:12px; padding:7px 0; border:none; text-align:right; }
    .op-table td::before{ content:attr(data-label); color:var(--op-muted); font-weight:600; font-size:11px; text-align:left; flex-shrink:0; }
    .op-table td.op-td-prod{ display:block; text-align:left; }
    .op-table td.op-td-prod::before{ display:none; }
    .op-avance{ min-width:0; width:60%; }
    .op-lote-line{ white-space:normal; }
    #camaraModal{ padding:8px; }
    #camaraModal .camara-dialog{ max-height:96vh; border-radius:12px; }
    .scan-frame{ width:230px; height:135px; }
}
@media (prefers-reduced-motion:reduce){
    .op-spin, .op-cam-line, .scan-line, .camara-hdr-pulse{ animation-duration:2.4s; }
}
</style>

{{-- Iconos (sprite SVG) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="i-cart" viewBox="0 0 24 24"><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.5L21 8H6"/></symbol>
    <symbol id="i-file" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></symbol>
    <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></symbol>
    <symbol id="i-box" viewBox="0 0 24 24"><path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/></symbol>
    <symbol id="i-check-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 5 5 9-10"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="i-alert-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></symbol>
    <symbol id="i-alert" viewBox="0 0 24 24"><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4M12 17h.01"/></symbol>
    <symbol id="i-barcode" viewBox="0 0 24 24"><path d="M3 5v14M7 5v14M10 5v14M14 5v14M17 5v14M21 5v14"/></symbol>
    <symbol id="i-camera" viewBox="0 0 24 24"><path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.5" r="3.5"/></symbol>
    <symbol id="i-keyboard" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10h.01M10 10h.01M14 10h.01M18 10h.01M7 14h10"/></symbol>
    <symbol id="i-tag" viewBox="0 0 24 24"><path d="M20.6 13.4 13.4 20.6a2 2 0 0 1-2.8 0L3 13V3h10l7.6 7.6a2 2 0 0 1 0 2.8z"/><circle cx="7.5" cy="7.5" r="1.2"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></symbol>
    <symbol id="i-grid" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18M15 3v18"/></symbol>
    <symbol id="i-refresh" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/></symbol>
    <symbol id="i-minus" viewBox="0 0 24 24"><path d="M5 12h14"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
    <symbol id="i-chevron" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></symbol>
    <symbol id="i-edit" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></symbol>
    <symbol id="i-save" viewBox="0 0 24 24"><path d="M5 3h11l3 3v15H5z"/><path d="M8 3v6h8V3M8 21v-7h8v7"/></symbol>
</svg>

<div class="op-wrap">
<div class="op-page">

{{-- Toast --}}
<div class="op-toast" id="toast"></div>

@php
    $estadoCls     = $order->estado === 'COMPLETO' ? 'ok' : ($order->estado === 'PARCIAL' ? 'warn' : 'bad');
    $esSuper       = strtoupper(trim($order->tipo_orden ?? '')) === 'SUPERMERCADO';
    $totalUnidades = $order->details->sum('cantidad_solicitada');
    $doneUnidades  = $order->details->sum('cantidad_despachada');
    $porcentaje    = $totalUnidades > 0 ? ($doneUnidades / $totalUnidades) * 100 : 0;
    $progColor     = $porcentaje >= 100 ? '#16a34a' : '#1f6bff';
    $totalItems    = $order->details->count();
    $compItems     = $order->details->filter(fn($d) => (float) $d->cantidad_solicitada > 0 && (float) $d->cantidad_despachada >= (float) $d->cantidad_solicitada)->count();
    $pendItems     = $totalItems - $compItems;
@endphp

{{-- Encabezado --}}
<div class="op-top">
    <div class="op-top-l">
        <svg class="ic"><use href="#i-cart"/></svg>
        <div>
            <h1 class="op-title">Preparación de pedido</h1>
            <div class="op-sub-t">Escanea los productos y registra las cantidades a despachar</div>
        </div>
    </div>
    <button type="button" class="op-btn soft" onclick="abrirModalDetalles()">
        <svg class="ic sm"><use href="#i-file"/></svg> Ver detalles de la orden
    </button>
</div>

{{-- Orden + KPIs --}}
<section class="op-card op-order op-gap">
    <div class="op-order-main">
        <div class="op-avatar"><svg class="ic lg"><use href="#i-user"/></svg></div>
        <div>
            <div class="op-lbl">Orden</div>
            <div class="op-order-num">
                <span class="op-mono">{{ $order->numero_orden }}</span>
                <span class="op-badge {{ $estadoCls }}">{{ $order->estado }}</span>
            </div>
            <div class="op-order-client">{{ $order->client?->razon_social }}</div>
        </div>
        @if(!empty($order->tipo_orden))
        <div>
            <div class="op-lbl" style="margin-bottom:4px;">Tipo</div>
            <span class="op-chip">{{ $order->tipo_orden }}</span>
        </div>
        @endif
    </div>

    <div class="op-kpi">
        <div class="op-kpi-ico blue"><svg class="ic lg"><use href="#i-box"/></svg></div>
        <div>
            <div class="op-kpi-val">{{ $totalItems }}</div>
            <div class="op-kpi-lab">Productos</div>
        </div>
    </div>
    <div class="op-kpi">
        <div class="op-kpi-ico green"><svg class="ic lg"><use href="#i-check-circle"/></svg></div>
        <div>
            <div class="op-kpi-val" id="kpiOk">{{ $compItems }}</div>
            <div class="op-kpi-lab">Completados</div>
        </div>
    </div>
    <div class="op-kpi">
        <div class="op-kpi-ico amber"><svg class="ic lg"><use href="#i-clock"/></svg></div>
        <div>
            <div class="op-kpi-val" id="kpiPend">{{ $pendItems }}</div>
            <div class="op-kpi-lab">Pendientes</div>
        </div>
    </div>
    <div class="op-kpi">
        <div class="op-ring" id="progRing" style="--p:{{ round($porcentaje) }};--c:{{ $progColor }};"></div>
        <div class="op-kpi-prog">
            <div class="op-kpi-val" id="pctNum">{{ number_format($porcentaje, 0) }}%</div>
            <div class="op-kpi-lab">Avance general · <span id="pctDone">{{ $doneUnidades }} / {{ $totalUnidades }}</span> u.</div>
            <div class="op-track"><div class="op-fill" id="progFill" style="width:{{ $porcentaje }}%;background:{{ $progColor }};"></div></div>
        </div>
    </div>
</section>

<div class="op-grid op-gap">
    <div class="op-main">

        {{-- Escáner --}}
        <section class="op-card">
            <div class="op-tabs" role="tablist">
                <button type="button" class="op-tab active" data-tab="scan" role="tab"><svg class="ic sm"><use href="#i-barcode"/></svg> Escanear código</button>
                <button type="button" class="op-tab" data-tab="camara" role="tab"><svg class="ic sm"><use href="#i-camera"/></svg> Cámara del celular</button>
                <button type="button" class="op-tab" data-tab="manual" role="tab"><svg class="ic sm"><use href="#i-keyboard"/></svg> Ingreso manual</button>
            </div>
            <div class="op-scan-row">
                <div class="op-input-wrap">
                    <svg class="ic"><use href="#i-barcode"/></svg>
                    <input type="text" id="scanner" class="scanner-input" autocomplete="off"
                           placeholder="Escanea o ingresa el código del producto...">
                </div>
                <button type="button" class="op-btn primary" id="btnAbrirCamara"><svg class="ic sm"><use href="#i-camera"/></svg> Abrir cámara</button>
            </div>
            <div class="op-hint" id="scanHint">Presiona <kbd>Enter</kbd> para confirmar · También puedes usar la cámara</div>
        </section>

        {{-- Producto seleccionado --}}
        <section class="op-card" id="activoCard">
            <h2 class="op-h">Producto seleccionado</h2>

            <div class="op-empty" id="activoVacio">
                <svg class="ic"><use href="#i-barcode"/></svg>
                <div>Escanea un producto o elígelo en la tabla para registrar su despacho.</div>
            </div>

            <div class="activo-box" id="activoBox">
                <div class="op-prod-head">
                    <div class="op-prod-img"><svg class="ic"><use href="#i-box"/></svg></div>
                    <div>
                        <div class="activo-name" id="activoNombre">—</div>
                        <div class="op-prod-tags">
                            <span class="op-chip op-mono" id="activoSku">—</span>
                            <span>Stock: <strong id="activoStock" style="color:var(--op-text);">—</strong></span>
                        </div>
                        <div class="op-prod-meta">
                            Peso: <strong id="activoPeso">—</strong><br>
                            Ubicación: <strong id="activoUbicacion">—</strong>
                        </div>
                    </div>
                    <div class="op-stats">
                        <div class="op-stat"><div class="op-stat-l">Solicitado</div><div class="op-stat-v" id="activoSolicitado">—</div></div>
                        <div class="op-stat"><div class="op-stat-l">Despachado</div><div class="op-stat-v green" id="activoDespachado">—</div></div>
                        <div class="op-stat"><div class="op-stat-l">Pendiente</div><div class="op-stat-v amber" id="activoPendiente">—</div></div>
                        <div class="op-stat">
                            <div class="op-stat-l">Avance</div>
                            <div class="op-stat-v green" id="activoPctLabel" style="font-size:16px;">—</div>
                            <div class="op-track" style="margin-top:6px;"><div class="op-fill" id="activoBarFill" style="width:0%;"></div></div>
                        </div>
                    </div>
                </div>

                <div class="op-form">
                    <div class="op-field">
                        <label for="activoCantidad">Cantidad despachada <span>(total)</span></label>
                        <div class="op-qty">
                            <button type="button" class="op-qty-btn" onclick="ajustarCantidad(-1)" aria-label="Restar uno"><svg class="ic"><use href="#i-minus"/></svg></button>
                            <input type="number" class="activo-input" id="activoCantidad" placeholder="0" min="0" inputmode="decimal">
                            <button type="button" class="op-qty-btn plus" onclick="ajustarCantidad(1)" aria-label="Sumar uno"><svg class="ic"><use href="#i-plus"/></svg></button>
                        </div>
                        <div class="op-field-hint" id="activoHint"></div>
                    </div>

                    <div class="op-field">
                        <label for="activoPersonal">Personal que retiró</label>
                        <div class="op-ctrl">
                            <svg class="ic"><use href="#i-user"/></svg>
                            <input type="text" class="activo-input" id="activoPersonal" placeholder="Nombre del personal..." maxlength="100" autocomplete="off">
                        </div>
                    </div>

                    <div class="op-field">
                        @if($esSuper)
                            <label for="activoPaletaInput">Paleta <span>(opcional)</span></label>
                            <div class="op-ctrl">
                                <svg class="ic"><use href="#i-grid"/></svg>
                                <input type="text" class="activo-input" id="activoPaletaInput" maxlength="50" placeholder="Ej: P01" autocomplete="off" style="text-transform:uppercase;">
                            </div>
                        @else
                            <label for="activoPaleta">Paleta</label>
                            <div class="op-ctrl">
                                <svg class="ic"><use href="#i-grid"/></svg>
                                <input type="text" class="activo-input" id="activoPaleta" readonly value="—">
                            </div>
                        @endif
                    </div>

                    <div class="op-field">
                        <label for="activoLote">Número de lote</label>
                        <div class="op-ctrl has-btn">
                            <svg class="ic"><use href="#i-tag"/></svg>
                            <input type="text" class="activo-input" id="activoLote" readonly value="—">
                            <button type="button" class="op-icon-btn" onclick="abrirModalLoteActivo()" title="Modificar lote / vencimiento" aria-label="Modificar lote / vencimiento"><svg class="ic sm"><use href="#i-edit"/></svg></button>
                        </div>
                    </div>

                    <div class="op-field">
                        <label for="activoVence">Fecha de vencimiento</label>
                        <div class="op-ctrl">
                            <svg class="ic"><use href="#i-calendar"/></svg>
                            <input type="text" class="activo-input" id="activoVence" readonly value="—">
                        </div>
                    </div>

                    <div class="op-field">
                        <label>Octógonos <span>(si aplica)</span></label>
                        <div class="op-oct" id="activoOctogonos">
                            <svg class="ic sm"><use href="#i-alert"/></svg>
                            <span>No aplica</span>
                        </div>
                    </div>
                </div>

                <div class="op-actions">
                    <button type="button" class="op-btn primary" id="btnGuardar" onclick="guardarDespacho()">
                        <svg class="ic sm op-btn-ico"><use href="#i-check"/></svg><span class="op-spin"></span><span class="op-btn-txt">Guardar despacho</span>
                    </button>
                    <button type="button" class="op-btn ghost" id="btnLimpiar" onclick="limpiarActivo()">
                        <svg class="ic sm"><use href="#i-refresh"/></svg> Limpiar
                    </button>
                </div>
            </div>
        </section>
    </div>

    {{-- Cámara lateral --}}
    <aside class="op-card op-cam">
        <h2 class="op-h" style="margin:0;"><svg class="ic sm"><use href="#i-camera"/></svg> Cámara del celular</h2>
        <button type="button" class="op-cam-preview" onclick="document.getElementById('btnAbrirCamara').click()" aria-label="Abrir cámara">
            <div class="op-cam-frame">
                <div class="op-cam-code">
                    <svg viewBox="0 0 120 44" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M3 0v44M8 0v44M13 0v44M21 0v44M26 0v44M34 0v44M39 0v44M43 0v44M51 0v44M57 0v44M62 0v44M70 0v44M75 0v44M80 0v44M88 0v44M93 0v44M101 0v44M106 0v44M114 0v44" stroke="#111" stroke-width="2.2"/>
                        <path d="M5.5 0v44M17 0v44M30 0v44M47 0v44M66 0v44M84 0v44M97 0v44M110 0v44" stroke="#111" stroke-width="1"/>
                    </svg>
                </div>
                <span class="op-cam-line"></span>
            </div>
        </button>
        <div class="op-note">
            <svg class="ic"><use href="#i-camera"/></svg>
            <div><strong>Apunta el código de barras</strong><br>el producto se registrará automáticamente.</div>
        </div>
        <button type="button" class="op-btn primary" onclick="document.getElementById('btnAbrirCamara').click()"><svg class="ic sm"><use href="#i-camera"/></svg> Abrir cámara</button>
    </aside>
</div>

{{-- Productos de la orden --}}
<section class="op-card">
    <div class="op-table-head">
        <h2 class="op-h"><svg class="ic sm"><use href="#i-box"/></svg> Productos de la orden</h2>
        <span class="op-lbl">{{ $totalItems }} producto{{ $totalItems != 1 ? 's' : '' }}</span>
    </div>
    <div class="op-table-scroll">
    <table class="op-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Estado</th>
                <th>Producto</th>
                <th>SKU</th>
                <th>Solicitado</th>
                <th>Despachado</th>
                <th>Pendiente</th>
                <th>Avance</th>
                <th>Lote / Vence</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->details as $item)
        @php
            $pct2 = $item->cantidad_solicitada > 0
                   ? ($item->cantidad_despachada / $item->cantidad_solicitada) * 100
                   : 0;
            $completo = $item->cantidad_despachada >= $item->cantidad_solicitada;
            $parcial  = $item->cantidad_despachada > 0;
            $lc       = $completo ? '#16a34a' : ($parcial ? '#f59e0b' : '#ef4444');
            $stCls    = $completo ? 'ok' : ($parcial ? 'warn' : 'bad');
            $stIcon   = $completo ? '#i-check' : ($parcial ? '#i-clock' : '#i-alert-circle');
            $stLbl    = $completo ? 'Completo' : ($parcial ? 'Parcial' : 'Sin despachar');
            $pend     = max(0, (float) $item->cantidad_solicitada - (float) $item->cantidad_despachada);
            $pend     = rtrim(rtrim(number_format($pend, 2, '.', ''), '0'), '.');
            $pctTxt   = rtrim(rtrim(number_format($pct2, 1, '.', ''), '0'), '.');

            $porCaja = (int) ($item->product->cantidad_por_caja ?? 0);
            $cajasSolicitadas   = $porCaja > 0 ? intdiv((int) $item->cantidad_solicitada, $porCaja) : 0;
            $sueltasSolicitadas = $porCaja > 0 ? ((int) $item->cantidad_solicitada % $porCaja) : 0;
            $cajasDespachadas   = $porCaja > 0 ? intdiv((int) $item->cantidad_despachada, $porCaja) : 0;
            $sueltasDespachadas = $porCaja > 0 ? ((int) $item->cantidad_despachada % $porCaja) : 0;
        @endphp
        <tr id="item-{{ $item->id }}" style="--lc:{{ $lc }};">
            <td data-label="#">{{ $loop->iteration }}</td>
            <td data-label="Estado">
                <span class="op-st {{ $stCls }}" id="st-{{ $item->id }}" title="{{ $stLbl }}"><svg class="ic"><use href="{{ $stIcon }}"/></svg></span>
            </td>
            <td class="op-td-prod" data-label="Producto">
                <div class="op-pname">{{ $item->product->nombre }}</div>
                @if($esSuper)
                    <div class="op-psub">Paleta: <strong id="paleta-{{ $item->id }}">{{ $item->paleta ?: '—' }}</strong></div>
                @elseif($item->paleta)
                    <div class="op-psub">Paleta: <strong>{{ $item->paleta }}</strong></div>
                @endif
                @if($item->ubicacion)
                    <div class="op-psub">Ubicación: <strong>{{ $item->ubicacion }}</strong></div>
                @endif
                @if(!empty($item->personal_despacho))
                    <div class="op-psub" id="personal-{{ $item->id }}">Retiró: <strong>{{ $item->personal_despacho }}</strong></div>
                @else
                    <div class="op-psub" id="personal-{{ $item->id }}" style="display:none;"></div>
                @endif
            </td>
            <td data-label="SKU"><span class="op-mono" style="font-size:12px;">{{ $item->product->sku }}</span></td>
            <td data-label="Solicitado">
                <div>
                    <span class="op-num">{{ $item->cantidad_solicitada }}</span>
                    @if($porCaja > 0)
                        <small class="op-caja">
                            <span id="cajas-solicitadas-{{ $item->id }}">{{ $cajasSolicitadas }}</span>
                            caja<span id="cajas-solicitadas-plural-{{ $item->id }}">{{ $cajasSolicitadas != 1 ? 's' : '' }}</span>
                            <span id="sueltas-solicitadas-wrap-{{ $item->id }}">@if($sueltasSolicitadas > 0)+ {{ $sueltasSolicitadas }} suelta{{ $sueltasSolicitadas != 1 ? 's' : '' }}@endif</span>
                        </small>
                    @endif
                </div>
            </td>
            <td data-label="Despachado">
                <div>
                    <span class="op-num" id="despachado-{{ $item->id }}" style="color:{{ $lc }};">{{ $item->cantidad_despachada }}</span>
                    @if($porCaja > 0)
                        <small class="op-caja">
                            <span id="cajas-despachadas-{{ $item->id }}">{{ $cajasDespachadas }}</span>
                            caja<span id="cajas-despachadas-plural-{{ $item->id }}">{{ $cajasDespachadas != 1 ? 's' : '' }}</span>
                            <span id="sueltas-despachadas-wrap-{{ $item->id }}">@if($sueltasDespachadas > 0)+ {{ $sueltasDespachadas }} suelta{{ $sueltasDespachadas != 1 ? 's' : '' }}@endif</span>
                        </small>
                    @endif
                </div>
            </td>
            <td data-label="Pendiente"><span class="op-num" id="pend-{{ $item->id }}" style="color:#f59e0b;">{{ $pend }}</span></td>
            <td data-label="Avance">
                <div class="op-avance">
                    <span class="op-pct" id="pct-{{ $item->id }}" style="color:{{ $lc }};">{{ $pctTxt }}%</span>
                    <div class="op-track"><div class="op-fill" id="bar-{{ $item->id }}" style="width:{{ $pct2 }}%;background:{{ $lc }};"></div></div>
                </div>
            </td>
            <td data-label="Lote / Vence">
                <div class="op-lote-line">
                    <div><span>Lote:</span> <strong class="op-mono">{{ $item->lote ?: '—' }}</strong></div>
                    <div><span>Vence:</span> <strong>{{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '—' }}</strong></div>
                </div>
            </td>
            <td data-label="Acciones">
                <div class="op-row-actions">
                    <button type="button" class="op-icon-btn" title="Modificar lote / vencimiento" aria-label="Modificar lote / vencimiento" onclick="abrirModalLote(
                        {{ $item->id }},
                        @js($item->lote),
                        @js($item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('Y-m-d') : '')
                    )"><svg class="ic sm"><use href="#i-edit"/></svg></button>
                    @if((float) $item->cantidad_despachada > 0)
                    <a href="{{ $esSuper ? route('orders.etiqueta', $item) : route('orders.etiqueta.local', $item) }}"
                       target="_blank" rel="noopener"
                       class="op-icon-btn"
                       style="text-decoration:none;"
                       title="Imprimir etiqueta" aria-label="Imprimir etiqueta">
                        <svg class="ic sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 9V3h12v6"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v7H6z"/><path d="M18 12h.01"/>
                        </svg>
                    </a>
                    @endif
                    <button type="button" class="op-icon-btn" title="Seleccionar producto" aria-label="Seleccionar producto" onclick="seleccionarPorId({{ $item->id }})"><svg class="ic sm"><use href="#i-chevron"/></svg></button>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</section>

{{-- Cerrar orden --}}
<form method="POST" action="{{ route('orders.cerrar', $order) }}" onsubmit="return confirmarCierre() && marcarCierreCargando(this)">
    @csrf
    <button type="submit" class="op-btn green btn-cerrar">
        <svg class="ic sm op-btn-ico"><use href="#i-check-circle"/></svg><span class="op-spin"></span><span class="op-btn-txt">Cerrar orden (aunque esté incompleta)</span>
    </button>
</form>

</div>

{{-- Modal octógonos --}}
<div id="modalOctogonos">
    <div class="op-oct-box">
        <h2>⚠ Verificar etiqueta</h2>
        <div id="modalProducto">Producto</div>
        <div id="modalAdvertencias"></div>
        <div class="op-oct-text">Verifique que el producto tenga correctamente los octógonos nutricionales antes de continuar.</div>
        <button id="btnEntendido" type="button" class="op-btn green" style="padding:12px 35px;font-size:16px;">✔ Entendido</button>
    </div>
</div>

{{-- Modal detalles de la orden --}}
<div id="modalDetalles" class="op-overlay">
    <div class="op-modal">
        <div class="op-modal-head">
            <span><svg class="ic sm"><use href="#i-file"/></svg> Detalles de la orden</span>
            <button type="button" class="op-icon-btn" onclick="cerrarModalDetalles()" aria-label="Cerrar"><svg class="ic sm"><use href="#i-x"/></svg></button>
        </div>
        <div class="op-modal-body">
            <div class="op-det-row"><span>Orden</span><strong class="op-mono">{{ $order->numero_orden }}</strong></div>
            <div class="op-det-row"><span>Cliente</span><strong>{{ $order->client?->razon_social ?: '—' }}</strong></div>
            <div class="op-det-row"><span>Tipo</span><strong>{{ $order->tipo_orden ?: '—' }}</strong></div>
            <div class="op-det-row"><span>Estado</span><strong>{{ $order->estado }}</strong></div>
            <div class="op-det-row"><span>Productos</span><strong>{{ $totalItems }}</strong></div>
            <div class="op-det-row"><span>Unidades despachadas</span><strong id="detUnidades">{{ $doneUnidades }} / {{ $totalUnidades }}</strong></div>
        </div>
    </div>
</div>

{{-- Modal editar lote / vencimiento --}}
<div id="modalLote" class="op-overlay">
    <div class="op-modal">
        <div class="op-modal-head">
            <span><svg class="ic sm"><use href="#i-tag"/></svg> Editar lote y vencimiento</span>
            <button type="button" class="op-icon-btn" onclick="cerrarModalLote()" aria-label="Cerrar"><svg class="ic sm"><use href="#i-x"/></svg></button>
        </div>
        <div class="op-modal-body">
            <div class="op-modal-warn">
                ⚠️ <strong>Esta edición es para casos extraordinarios.</strong><br>
                Si el dato está mal en el producto, corrígelo también en <strong>Productos</strong> para mantener la información actualizada.
            </div>
            <form id="formLote" method="POST" action="">
                @csrf
                @method('PUT')
                <label class="op-modal-label" for="loteInput">Lote</label>
                <input type="text" name="lote" id="loteInput" class="op-modal-input" maxlength="100" placeholder="Ej: L-2026-045">
                <label class="op-modal-label" for="fechaVencInput">Fecha de vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fechaVencInput" class="op-modal-input">
                <div class="op-modal-actions">
                    <button type="button" class="op-btn ghost" onclick="cerrarModalLote()">Cancelar</button>
                    <button type="submit" class="op-btn primary" id="btnGuardarLote">
                        <svg class="ic sm op-btn-ico"><use href="#i-save"/></svg><span class="op-spin"></span><span class="op-btn-txt">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal escáner de cámara --}}
<div id="camaraModal">
    <div class="camara-dialog">
        <div class="camara-hdr">
            <div class="camara-hdr-title"><span class="camara-hdr-pulse"></span> Escáner de cámara</div>
            <button type="button" class="btn-camara-cerrar" id="btnCerrarCamara">✕</button>
        </div>
        <div id="camaraVisor">
            <div class="scan-frame"><div class="scan-line"></div></div>
        </div>
        <div class="camara-result" id="camaraResult">📷 Apunta al código de barras...</div>
        <div class="camara-hint">Encuadra el código en el marco · Se detecta automáticamente</div>
    </div>
</div>

</div>{{-- /op-wrap --}}

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let detalles = @json($order->details->load('product'));
let scanner  = document.getElementById('scanner');
let activoActual = null;

function byId(id){ return document.getElementById(id); }

// ---------- Utilidades ----------
function fmtNum(n){
    n = parseFloat(n);
    if(isNaN(n)) return '0';
    return String(+n.toFixed(2));
}
function fmtPct(p){
    p = parseFloat(p);
    if(isNaN(p)) return '0';
    return String(+p.toFixed(1));
}
function colorPct(p){
    return p >= 100 ? '#16a34a' : (p > 0 ? '#f59e0b' : '#ef4444');
}
function fmtFecha(v){
    if(!v) return '—';
    const m = String(v).match(/^(\d{4})-(\d{2})-(\d{2})/);
    return m ? (m[3] + '/' + m[2] + '/' + m[1]) : String(v);
}
function fechaYmd(v){
    if(!v) return '';
    const m = String(v).match(/^(\d{4}-\d{2}-\d{2})/);
    return m ? m[1] : '';
}
function escapeHtml(value){
    const div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
}

function showToast(msg, tipo){
    const t = byId('toast');
    t.className = 'op-toast show ' + tipo;
    t.textContent = msg;
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.className = 'op-toast'; }, 2800);
}

let audioCtx = null;
function beep(){
    try {
        audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();
        if(audioCtx.state === 'suspended'){ audioCtx.resume(); }
        let o = audioCtx.createOscillator();
        let g = audioCtx.createGain();
        o.connect(g); g.connect(audioCtx.destination);
        o.frequency.value = 880;
        o.type = 'sine';
        g.gain.setValueAtTime(0.3, audioCtx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.15);
        o.start(audioCtx.currentTime);
        o.stop(audioCtx.currentTime + 0.15);
    } catch(e){}
}

// ---------- Icono de carga en botones ----------
function setBtnLoading(btn, on, txt){
    if(!btn) return;
    const t = btn.querySelector('.op-btn-txt');
    if(on){
        if(t){ btn.dataset.txt = t.textContent; if(txt) t.textContent = txt; }
        btn.classList.add('is-loading');
        btn.disabled = true;
    } else {
        if(t && btn.dataset.txt){ t.textContent = btn.dataset.txt; }
        btn.classList.remove('is-loading');
        btn.disabled = false;
    }
}
window.addEventListener('pageshow', function(e){
    if(e.persisted){
        document.querySelectorAll('.op-btn.is-loading').forEach(b => setBtnLoading(b, false));
    }
});

// ---------- Modales ----------
function abrirModalLote(id, lote, fecha){
    byId('formLote').action = '/order-details/' + id + '/lote';
    byId('loteInput').value = lote || '';
    byId('fechaVencInput').value = fecha || '';
    byId('modalLote').style.display = 'flex';
}
function cerrarModalLote(){
    byId('modalLote').style.display = 'none';
}
function abrirModalLoteActivo(){
    if(!activoActual){ showToast('⚠ Selecciona un producto primero', 'twk'); return; }
    abrirModalLote(
        activoActual.id,
        activoActual.lote || '',
        fechaYmd(activoActual.fecha_vencimiento || activoActual.product?.fecha_vencimiento)
    );
}
byId('modalLote').addEventListener('click', function(e){
    if(e.target === this) cerrarModalLote();
});
byId('formLote').addEventListener('submit', function(){
    setBtnLoading(byId('btnGuardarLote'), true, 'Guardando...');
});

function abrirModalDetalles(){ byId('modalDetalles').style.display = 'flex'; }
function cerrarModalDetalles(){ byId('modalDetalles').style.display = 'none'; }
byId('modalDetalles').addEventListener('click', function(e){
    if(e.target === this) cerrarModalDetalles();
});
document.addEventListener('keydown', function(e){
    if(e.key === 'Escape'){ cerrarModalLote(); cerrarModalDetalles(); }
});

// =====================================
// MODAL ADVERTENCIAS (OCTÓGONOS)
// =====================================
const OCTOGONOS = {
    'AZUCAR': { label:'Alto en azúcar', src:'https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png' },
    'SODIO':  { label:'Alto en sodio',  src:'https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png' },
    'GRASAS': { label:'Alto en grasas', src:'https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png' }
};

function listarAdvertencias(item){
    return String(item.product?.advertencias || '')
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .toUpperCase()
        .split(',')
        .map(s => s.trim())
        .filter(Boolean);
}

function mostrarModalAdvertencias(item){
    byId('modalProducto').textContent = item.product.nombre;

    let html = '';
    listarAdvertencias(item).forEach(tok => {
        const oct = OCTOGONOS[tok];
        if(oct){
            html += '<img src="' + oct.src + '" alt="' + oct.label + '" ' +
                    'onerror="this.outerHTML=\'<span class=&quot;op-oct-fallback&quot;>' + oct.label.toUpperCase() + '</span>\'">';
        } else {
            html += '<span class="op-oct-fallback">' + escapeHtml(tok) + '</span>';
        }
    });
    byId('modalAdvertencias').innerHTML = html;
    byId('modalOctogonos').style.display = 'flex';

    byId('btnEntendido').onclick = function(){
        byId('modalOctogonos').style.display = 'none';
        setTimeout(function(){
            byId('activoCantidad').focus();
            byId('activoCantidad').select();
        }, 100);
    };
}

// =====================================
// BARRA GENERAL / KPIs
// =====================================
function actualizarBarra(){
    let total = 0, done = 0, ok = 0, pend = 0;
    detalles.forEach(d => {
        const sol = parseFloat(d.cantidad_solicitada) || 0;
        const des = parseFloat(d.cantidad_despachada) || 0;
        total += sol;
        done  += des;
        const pct = sol > 0 ? des / sol : 0;
        if(pct >= 1) ok++; else pend++;
    });
    const pct = total > 0 ? (done / total) * 100 : 0;
    const color = pct >= 100 ? '#16a34a' : '#1f6bff';

    byId('progFill').style.width  = Math.min(100, pct) + '%';
    byId('progFill').style.background = color;
    const ring = byId('progRing');
    ring.style.setProperty('--p', Math.min(100, Math.round(pct)));
    ring.style.setProperty('--c', color);
    byId('pctNum').textContent = Math.round(pct) + '%';
    byId('pctDone').textContent = Math.round(done) + ' / ' + Math.round(total);
    byId('detUnidades').textContent = Math.round(done) + ' / ' + Math.round(total);
    byId('kpiOk').textContent   = ok;
    byId('kpiPend').textContent = pend;
}

// =====================================
// PRODUCTO SELECCIONADO
// =====================================
function actualizarStatsActivo(item){
    const sol = parseFloat(item.cantidad_solicitada) || 0;
    const des = parseFloat(item.cantidad_despachada) || 0;
    const pct = sol > 0 ? (des / sol) * 100 : 0;
    const color = colorPct(pct);

    byId('activoSolicitado').textContent = fmtNum(sol);
    byId('activoDespachado').textContent = fmtNum(des);
    byId('activoPendiente').textContent  = fmtNum(Math.max(0, sol - des));
    byId('activoPctLabel').textContent   = fmtPct(pct) + '%';
    byId('activoPctLabel').style.color   = color;
    byId('activoBarFill').style.width    = Math.min(100, pct) + '%';
    byId('activoBarFill').style.background = color;
    byId('activoHint').textContent = 'Total acumulado · máximo ' + fmtNum(sol);
}

function pintarOctogonos(item){
    const cont = byId('activoOctogonos');
    const icono = '<svg class="ic sm"><use href="#i-alert"/></svg>';
    const advs = listarAdvertencias(item);
    if(!advs.length){
        cont.innerHTML = icono + '<span>No aplica</span>';
        return;
    }
    cont.innerHTML = icono + advs.map(t =>
        '<span class="op-oct-tag">' + escapeHtml(OCTOGONOS[t] ? OCTOGONOS[t].label : t) + '</span>'
    ).join('');
}

function mostrarActivo(item){
    activoActual = item;

    byId('activoNombre').textContent    = item.product.nombre;
    byId('activoSku').textContent       = item.product.sku ?? '—';
    byId('activoStock').textContent     = item.product.stock ?? '—';
    byId('activoPeso').textContent      = item.product.peso
        ? (item.product.peso / 1000).toFixed(3) + ' kg' : '—';
    byId('activoUbicacion').textContent = item.ubicacion || '—';
    byId('activoLote').value            = item.lote || '—';
    byId('activoVence').value           = fmtFecha(item.fecha_vencimiento || item.product?.fecha_vencimiento);

    byId('activoCantidad').value = (parseFloat(item.cantidad_despachada) > 0) ? item.cantidad_despachada : '';

    const paletaInput = byId('activoPaletaInput');
    if(paletaInput){ paletaInput.value = item.paleta || ''; }
    const paletaText = byId('activoPaleta');
    if(paletaText){ paletaText.value = item.paleta || '—'; }

    const personalInput = byId('activoPersonal');
    if(personalInput){ personalInput.value = item.personal_despacho || ''; }

    actualizarStatsActivo(item);
    pintarOctogonos(item);

    byId('activoVacio').style.display = 'none';
    byId('activoBox').style.display = 'block';

    // =====================================
    // VERIFICAR ADVERTENCIAS NUTRICIONALES
    // =====================================
    if(item.product.advertencias && listarAdvertencias(item).length){
        mostrarModalAdvertencias(item);
    } else {
        byId('activoCantidad').focus();
        byId('activoCantidad').select();
    }
}

function ocultarActivo(){
    activoActual = null;
    byId('activoBox').style.display = 'none';
    byId('activoVacio').style.display = 'flex';
}

function limpiarActivo(){
    ocultarActivo();
    scanner.value = '';
}

function ajustarCantidad(delta){
    if(!activoActual) return;
    const input = byId('activoCantidad');
    const max = parseFloat(activoActual.cantidad_solicitada) || 0;
    let v = parseFloat(input.value);
    if(isNaN(v)) v = 0;
    v = Math.min(max, Math.max(0, v + delta));
    input.value = v;
}

// =====================================
// ACTUALIZAR LISTA / TABLA
// =====================================
function actualizarCajasUI(item){
    const porCaja = parseInt(item.product?.cantidad_por_caja || 0, 10);
    if(!porCaja || porCaja <= 0) return;

    const cantidad = Math.max(0, Math.floor(parseFloat(item.cantidad_despachada) || 0));
    const cajas = Math.floor(cantidad / porCaja);
    const sueltas = cantidad % porCaja;

    const cajasEl = byId('cajas-despachadas-' + item.id);
    if(cajasEl) cajasEl.textContent = cajas;

    const pluralEl = byId('cajas-despachadas-plural-' + item.id);
    if(pluralEl) pluralEl.textContent = cajas !== 1 ? 's' : '';

    const sueltasWrap = byId('sueltas-despachadas-wrap-' + item.id);
    if(sueltasWrap){
        sueltasWrap.textContent = sueltas > 0
            ? `+ ${sueltas} suelta${sueltas !== 1 ? 's' : ''}`
            : '';
    }
}

function actualizarItemUI(item){
    const sol = parseFloat(item.cantidad_solicitada) || 0;
    const des = parseFloat(item.cantidad_despachada) || 0;
    const pct = sol > 0 ? (des / sol) * 100 : 0;
    const color = colorPct(pct);

    const row = byId('item-' + item.id);
    if(row){ row.style.setProperty('--lc', color); }

    const span = byId('despachado-' + item.id);
    if(span){ span.textContent = item.cantidad_despachada; span.style.color = color; }

    const pendEl = byId('pend-' + item.id);
    if(pendEl){ pendEl.textContent = fmtNum(Math.max(0, sol - des)); }

    const pctEl = byId('pct-' + item.id);
    if(pctEl){ pctEl.textContent = fmtPct(pct) + '%'; pctEl.style.color = color; }

    const barEl = byId('bar-' + item.id);
    if(barEl){ barEl.style.width = Math.min(100, pct) + '%'; barEl.style.background = color; }

    const st = byId('st-' + item.id);
    if(st){
        const cls  = pct >= 100 ? 'ok' : (pct > 0 ? 'warn' : 'bad');
        const icon = pct >= 100 ? '#i-check' : (pct > 0 ? '#i-clock' : '#i-alert-circle');
        st.className = 'op-st ' + cls;
        st.title = pct >= 100 ? 'Completo' : (pct > 0 ? 'Parcial' : 'Sin despachar');
        const use = st.querySelector('use');
        if(use){ use.setAttribute('href', icon); }
    }

    actualizarCajasUI(item);
}

function resaltarFila(id){
    const row = byId('item-' + id);
    if(!row) return;
    row.classList.remove('op-flash');
    void row.offsetWidth;
    row.classList.add('op-flash');
    setTimeout(() => row.classList.remove('op-flash'), 1500);
}

// =====================================
// SELECCIONAR / PROCESAR CÓDIGO
// =====================================
function seleccionarItem(item){
    const sol = parseFloat(item.cantidad_solicitada) || 0;
    const des = parseFloat(item.cantidad_despachada) || 0;
    const pct = sol > 0 ? (des / sol) * 100 : 0;

    if(pct >= 100){
        showToast('⚠ ' + item.product.nombre + ' ya está completo', 'twk');
        return false;
    }

    resaltarFila(item.id);
    mostrarActivo(item);
    showToast('✔ ' + item.product.nombre, 'tok');
    beep();

    const card = byId('activoCard');
    if(card){ card.scrollIntoView({ behavior:'smooth', block:'nearest' }); }
    return true;
}

function seleccionarPorId(id){
    const item = detalles.find(d => String(d.id) === String(id));
    if(item) seleccionarItem(item);
}

// Procesar un código tanto desde lector físico como desde cámara
function procesarCodigo(codigo){
    codigo = String(codigo || '').trim();
    if(!codigo) return;

    const item = detalles.find(d =>
        d.product && (
            String(d.product.barcode || '') === codigo ||
            String(d.product.box_barcode || '') === codigo ||
            String(d.product.sku || '') === codigo
        )
    );

    if(!item){
        showToast('❌ Producto no pertenece a esta orden', 'ter');
        scanner.value = '';
        return;
    }

    seleccionarItem(item);
    scanner.value = '';
}

scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    procesarCodigo(this.value);
});

// Pestañas del escáner
document.querySelectorAll('.op-tab').forEach(tab => {
    tab.addEventListener('click', function(){
        const modo = this.dataset.tab;
        if(modo === 'camara'){
            byId('btnAbrirCamara').click();
            return;
        }
        document.querySelectorAll('.op-tab').forEach(t => t.classList.toggle('active', t === this));
        if(modo === 'manual'){
            scanner.placeholder = 'Escribe el código o SKU del producto...';
            byId('scanHint').innerHTML = 'Escribe el código y presiona <kbd>Enter</kbd> para buscarlo';
        } else {
            scanner.placeholder = 'Escanea o ingresa el código del producto...';
            byId('scanHint').innerHTML = 'Presiona <kbd>Enter</kbd> para confirmar · También puedes usar la cámara';
        }
        scanner.focus();
    });
});

// =====================================
// GUARDAR DESPACHO
// =====================================
function guardarDespacho(){
    if(!activoActual){
        showToast('⚠ Escanea o selecciona un producto primero', 'twk');
        return;
    }
    const item = activoActual;
    const btn = byId('btnGuardar');

    const cantidad = parseFloat(byId('activoCantidad').value);
    if(isNaN(cantidad) || cantidad < 0){
        showToast('⚠ Cantidad inválida', 'twk');
        return;
    }
    if(cantidad > parseFloat(item.cantidad_solicitada)){
        showToast('⚠ Supera la cantidad solicitada (' + item.cantidad_solicitada + ')', 'twk');
        return;
    }

    const personalInput = byId('activoPersonal');
    const personal = personalInput ? personalInput.value.trim() : '';
    if(!personal){
        showToast('⚠ Debes indicar quién retiró el producto', 'twk');
        if(personalInput) personalInput.focus();
        return;
    }

    const paletaInput = byId('activoPaletaInput');
    const paleta = paletaInput ? paletaInput.value.trim().toUpperCase() : '';

    const formData = new FormData();
    formData.append('cantidad_despachada', cantidad);
    formData.append('cantidad_solicitada', item.cantidad_solicitada);
    formData.append('precio_unitario', item.precio_unitario || 0);
    formData.append('personal_despacho', personal);
    if(paletaInput){
        formData.append('paleta', paleta);
    }
    formData.append('_method', 'PUT');
    formData.append('_token', '{{ csrf_token() }}');

    setBtnLoading(btn, true, 'Guardando...');

    fetch(`/order-details/${item.id}`, {
        method:'POST',
        headers:{ 'Accept':'application/json' },
        body: formData
    })
    .then(async res => {
        const texto = await res.text();
        if(!res.ok){
            throw new Error('HTTP ' + res.status + ': ' + texto);
        }
        try { return JSON.parse(texto); } catch(e) { return {}; }
    })
    .then(() => {
        item.cantidad_despachada = cantidad;
        item.personal_despacho = personal;
        if(paletaInput){ item.paleta = paleta; }

        actualizarItemUI(item);
        actualizarBarra();

        const personalEl = byId('personal-' + item.id);
        if(personalEl){
            personalEl.style.display = 'block';
            personalEl.innerHTML = `Retiró: <strong>${escapeHtml(personal)}</strong>`;
        }

        const paletaEl = byId('paleta-' + item.id);
        if(paletaEl){ paletaEl.textContent = paleta || '—'; }

        const sol = parseFloat(item.cantidad_solicitada) || 0;
        const pct = sol > 0 ? (cantidad / sol) * 100 : 0;

        if(pct >= 100){
            showToast('✅ ' + item.product.nombre + ' completado!', 'tok');
            if(activoActual && activoActual.id === item.id){ ocultarActivo(); }
        } else {
            showToast('💾 Guardado: ' + cantidad + ' de ' + item.cantidad_solicitada, 'tok');
            if(activoActual && activoActual.id === item.id){ actualizarStatsActivo(item); }
        }

        beep();
    })
    .catch(error => {
        console.error('❌ ERROR AL GUARDAR:', error);
        showToast('❌ Error al guardar. Revisa la consola.', 'ter');
    })
    .finally(() => {
        setBtnLoading(btn, false);
    });
}

// Guardar con Enter desde el campo cantidad
byId('activoCantidad').addEventListener('keydown', function(e){
    if(e.key !== 'Enter' || !activoActual) return;
    e.preventDefault();
    guardarDespacho();
});

// Foco manual: no se fuerza el regreso al campo de escaneo.
// ================================
// ESCÁNER DE CÁMARA
// ================================
(function(){
    let lectorCamara = null;
    let procesando = false;

    const modal = byId('camaraModal');
    const btnAbrir = byId('btnAbrirCamara');
    const btnCerrar = byId('btnCerrarCamara');
    const resultado = byId('camaraResult');

    function quitarLoaderCamara(){
        const l = byId('camLoading');
        if(l) l.remove();
    }

    function cerrarCamara(){
        const lector = lectorCamara;
        lectorCamara = null;

        if(lector){
            lector.stop()
                .catch(() => {})
                .finally(() => {
                    try { lector.clear(); } catch(e) {}
                });
        }

        if(modal){
            modal.classList.remove('open');
        }

        procesando = false;
        // IMPORTANTE: no hacemos foco automático
    }

    async function abrirCamara(){
        if(!modal || !btnAbrir) return;
        if(lectorCamara) return;

        modal.classList.add('open');
        procesando = false;

        if(resultado){
            resultado.innerHTML =
                '<span class="camara-result-placeholder">📷 Apunta al código de barras...</span>';
        }

        // Limpiar visor antes de crear un lector nuevo (con icono de carga).
        const visor = byId('camaraVisor');
        if(visor){
            visor.innerHTML =
                '<div class="scan-frame"><div class="scan-line"></div></div>' +
                '<div class="cam-loading" id="camLoading"><span class="op-spin lg"></span><span>Iniciando cámara...</span></div>';
        }

        try{
            lectorCamara = new Html5Qrcode('camaraVisor', {
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.EAN_13,
                    Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.CODE_39,
                    Html5QrcodeSupportedFormats.UPC_A,
                    Html5QrcodeSupportedFormats.UPC_E,
                    Html5QrcodeSupportedFormats.QR_CODE
                ]
            });

            await lectorCamara.start(
                { facingMode: 'environment' },
                {
                    fps: 10,
                    qrbox: { width: 260, height: 150 },
                    aspectRatio: 1.777
                },
                async function(codigo){
                    if(procesando) return;
                    procesando = true;

                    codigo = String(codigo || '').trim();

                    if(!codigo){
                        procesando = false;
                        return;
                    }

                    if(resultado){
                        resultado.innerHTML =
                            '<span class="camara-result-code">✅ ' +
                            escapeHtml(codigo) +
                            '</span>';
                    }

                    if(navigator.vibrate){
                        navigator.vibrate(80);
                    }

                    // Guardamos el código en el mismo input para que quede visible.
                    scanner.value = codigo;

                    // Procesamos DIRECTAMENTE el código.
                    procesarCodigo(codigo);

                    // Cerramos después de procesarlo.
                    const lector = lectorCamara;
                    lectorCamara = null;

                    if(lector){
                        try{
                            await lector.stop();
                        }catch(e){}

                        try{
                            lector.clear();
                        }catch(e){}
                    }

                    modal.classList.remove('open');

                    // IMPORTANTE:
                    // NO foco automático
                    // NO setInterval()
                    // NO regreso automático al escáner

                    procesando = false;
                },
                function(){}
            );

            quitarLoaderCamara();

        }catch(error){
            console.error('Error cámara:', error);
            quitarLoaderCamara();

            if(resultado){
                const nombre = (error && (error.name || '')) + ' ' + String(error || '');
                let motivo = 'No se pudo iniciar la cámara.';
                if(!window.isSecureContext){
                    motivo = 'La cámara solo funciona en una página HTTPS.';
                } else if(window.self !== window.top){
                    motivo = 'La página está dentro de un iframe (vista previa). Ábrela en una pestaña normal del navegador.';
                } else if(/NotAllowed|Permission|denied/i.test(nombre)){
                    motivo = 'Permiso de cámara bloqueado. Toca el candado junto a la dirección, permite la Cámara y recarga la página.';
                } else if(/NotFound|DevicesNotFound/i.test(nombre)){
                    motivo = 'No se encontró ninguna cámara en este dispositivo.';
                } else if(/NotReadable|TrackStart|Could not start/i.test(nombre)){
                    motivo = 'La cámara está siendo usada por otra app o pestaña. Ciérrala e intenta de nuevo.';
                }
                resultado.innerHTML =
                    '<span style="color:#ef4444;">⚠️ ' + escapeHtml(motivo) + '</span>';
            }

            const lector = lectorCamara;
            lectorCamara = null;

            if(lector){
                try { await lector.stop(); } catch(e){}
                try { lector.clear(); } catch(e){}
            }
        }
    }

    if(btnAbrir){
        btnAbrir.addEventListener('click', function(e){
            e.preventDefault();
            abrirCamara();
        });
    }

    if(btnCerrar){
        btnCerrar.addEventListener('click', function(e){
            e.preventDefault();
            cerrarCamara();
        });
    }

    if(modal){
        modal.addEventListener('click', function(e){
            if(e.target === modal){
                cerrarCamara();
            }
        });
    }
})();

function confirmarCierre(){
    const faltantes = detalles.filter(d =>
        parseFloat(d.cantidad_despachada) < parseFloat(d.cantidad_solicitada)
    );
    if(faltantes.length === 0){
        return confirm('✅ Todos los productos están completos.\n\n¿Deseas cerrar la orden?');
    }
    const lista = faltantes.map(d => {
        const f = d.cantidad_solicitada - d.cantidad_despachada;
        return `• ${d.product.nombre} (faltan ${f})`;
    }).join('\n');
    return confirm('⚠️ Hay productos incompletos:\n\n' + lista + '\n\n¿Deseas cerrar la orden de todas formas?');
}

function marcarCierreCargando(form){
    const btn = form.querySelector('button[type="submit"]');
    // Se deshabilita en el siguiente ciclo para que el formulario sí se envíe.
    setTimeout(() => setBtnLoading(btn, true, 'Cerrando orden...'), 0);
    return true;
}

window.addEventListener('load', () => {
    actualizarBarra();
});
</script>

@endsection