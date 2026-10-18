@extends('layouts.app')

@section('content')

@php
    // Icono de pestaña e imagen animada de carga, siguiendo el estilo de Kardex.
    $erpLogoUrl = null;
    $erpLogoSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><defs><linearGradient id="erpLogoGrad" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2b8cff"/><stop offset="1" stop-color="#1243a8"/></linearGradient></defs><rect width="64" height="64" rx="15" fill="url(#erpLogoGrad)"/><path fill="#fff" fill-rule="evenodd" d="M17 14h15.5a18 18 0 0 1 0 36H17zM27.5 23.2v17.6h5a8.8 8.8 0 0 0 0-17.6z"/></svg>';
    $erpFavicon = $erpLogoUrl ?: 'data:image/svg+xml,' . rawurlencode($erpLogoSvg);
@endphp

<style>
*{box-sizing:border-box;}

/* ── ERP Shell ── */
.erp-bar{background:#1e3a5f;padding:0 1.25rem;height:40px;display:flex;align-items:center;justify-content:space-between;margin:-20px -20px 0;}
.erp-bar-title{color:#7eb8f7;font-size:13px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;}
.erp-breadcrumb{font-size:11px;color:#5a8abf;}
.erp-user{font-size:11px;color:#7eb8f7;background:#152d4d;padding:3px 10px;border-radius:4px;}
.pg{padding:1rem;background:#e8ecf0;min-height:100vh;}

/* ── Header ── */
.order-header{background:#fff;border:1px solid #c9d4e0;border-top:4px solid #1e3a5f;border-radius:4px;padding:.85rem 1.1rem;margin-bottom:.85rem;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;}
.order-id{font-size:16px;font-weight:700;color:#1e3a5f;}
.order-sub{font-size:11px;color:#64748b;margin-top:2px;}
.status-chip{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:3px;font-size:11px;font-weight:700;letter-spacing:.05em;}

/* ── KPIs ── */
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:.85rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #c9d4e0;border-radius:4px;padding:.7rem .9rem;border-left:4px solid;}
.kpi-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:19px;font-weight:700;line-height:1;color:#1e293b;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:2px;}

/* ── Layout ── */
.layout{display:grid;grid-template-columns:1fr 290px;gap:10px;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}
.left-col{display:flex;flex-direction:column;gap:10px;}

/* ── Panel ── */
.panel{background:#fff;border:1px solid #c9d4e0;border-radius:4px;}
.panel-header{background:#f1f5f9;border-bottom:1px solid #c9d4e0;padding:.6rem 1rem;display:flex;align-items:center;justify-content:space-between;}
.panel-title{font-size:12px;font-weight:700;color:#1e3a5f;text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:6px;}
.panel-body{padding:.9rem 1rem;}

/* ── Scanner ── */
.scanner-erp{
    background:#0f172a;
    border-radius:4px;
    padding:.45rem .7rem;
    display:flex;
    align-items:center;
    gap:8px;
    border:1px solid #334155;
    width:100%;
    overflow:hidden;
}
.scan-led{width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:blink 1.4s infinite;}
@keyframes blink{0%,100%{opacity:1;}50%{opacity:.2;}}
.scan-input{
    flex:1;
    min-width:0;
    padding:6px 10px;
    border-radius:4px;
    border:1px solid #334155;
    background:#1e293b;
    color:#fff;
    font-size:13px;
    outline:none;
    font-family:'Courier New', monospace;
    letter-spacing:1px;
}
.scan-input:focus{border-color:#3b82f6;}
.scan-input::placeholder{color:#334155;font-size:12px;letter-spacing:0;font-family:'Segoe UI',sans-serif;}

/* ── Form agregar producto ── */
.add-grid{
    display:grid;
    grid-template-columns:2fr 1fr 1fr auto;
    gap:7px;
    align-items:end;
}
@media(max-width:900px){
    .add-grid{grid-template-columns:1fr 1fr;gap:8px;}
    .add-grid > div:first-child{grid-column:1 / -1;}
    .add-grid > button{grid-column:1 / -1;width:100%;justify-content:center;}
}
@media(max-width:480px){
    .add-grid{grid-template-columns:1fr;gap:8px;}
    .add-grid > div:first-child,
    .add-grid > button{grid-column:1 / -1;}
}

.flabel{font-size:10px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #c9d4e0;border-radius:3px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#1e3a5f;box-shadow:0 0 0 2px rgba(30,58,95,.1);}

/* ── Tabla ERP ── */
.erp-table{width:100%;border-collapse:collapse;font-size:12px;}
.erp-table th{background:#f1f5f9;color:#475569;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;padding:7px 10px;border-bottom:2px solid #c9d4e0;text-align:left;white-space:nowrap;}
.erp-table td{padding:7px 10px;border-bottom:1px solid #f1f5f9;color:#1e293b;vertical-align:middle;}
.erp-table tbody tr:hover td{background:#f8fafc;}
.erp-table .num-input{padding:5px 7px;border:1px solid #c9d4e0;border-radius:3px;font-size:12px;width:75px;text-align:center;background:#fff;outline:none;}
.erp-table .num-input:focus{border-color:#1e3a5f;}
.erp-table .num-input:disabled{background:#f8fafc;color:#94a3b8;border-color:#e2e8f0;}
.state-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:4px;}
.mini-bar{width:60px;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;display:inline-block;vertical-align:middle;}
.mini-fill{height:100%;border-radius:99px;}

/* ── Badge lote / vencimiento ── */
.lote-badge{
    font-size:10px;
    font-family:'Courier New',monospace;
    color:#475569;
    background:#f1f5f9;
    border:1px solid #e2e8f0;
    border-radius:3px;
    padding:1px 6px;
    white-space:nowrap;
}
.venc-badge{font-size:10px;font-weight:700;white-space:nowrap;}
.venc-dias{font-weight:400;color:#94a3b8;}
.btn-lote-edit{background:none;border:none;cursor:pointer;font-size:11px;color:#7c3aed;padding:0 2px;line-height:1;}
.btn-lote-edit:hover{opacity:.7;}

/* ── Scroll hint solo en móvil ── */
.scroll-hint-mobile{
    display:none;
    font-size:10px;color:#94a3b8;
    padding:4px 10px 0;text-align:right;
}
@media(max-width:768px){
    .scroll-hint-mobile{display:block;}
    .erp-table{min-width:580px;}
    .erp-table td,.erp-table th{padding:6px 7px;font-size:11px;}
    .erp-table th:nth-child(3),
    .erp-table td:nth-child(3),
    .erp-table th:nth-child(8),
    .erp-table td:nth-child(8){display:none;}
    .erp-table .num-input{width:60px;font-size:11px;padding:4px 5px;}
    .btn-xs{padding:4px 6px;font-size:10px;}
    #btnCamara{display:flex !important;}
}
@media(max-width:480px){
    .erp-table th:nth-child(6),
    .erp-table td:nth-child(6){display:none;}
    .erp-table{min-width:420px;}
    .erp-breadcrumb{display:none;}
    .order-sub{font-size:10px;}
    .kpis{grid-template-columns:repeat(2,1fr);}
}

/* ── Botones ── */
.btn-xs{display:inline-flex;align-items:center;gap:3px;padding:5px 9px;border-radius:3px;font-size:11px;font-weight:600;cursor:pointer;border:none;transition:opacity .15s;white-space:nowrap;}
.btn-xs:hover{opacity:.85;}
.btn-edit{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}
.btn-save{background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe;}
.btn-del{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.btn-cancel{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.btn-primary{background:#1e3a5f;color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:5px;transition:opacity .15s;}
.btn-primary:hover{opacity:.9;}
.btn-green{background:#16a34a;color:#fff;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;border:none;transition:opacity .15s;}
.btn-green:hover{opacity:.9;}

/* ── Summary ── */
.summary-table{width:100%;font-size:12px;border-collapse:collapse;}
.summary-table tr td{padding:5px 6px;border-bottom:1px solid #f1f5f9;color:#475569;}
.summary-table tr td:last-child{text-align:right;font-weight:600;color:#1e293b;}
.summary-table .total-row td{border-top:2px solid #c9d4e0;font-size:14px;font-weight:700;color:#1e3a5f;padding-top:8px;}
.status-row{display:flex;justify-content:space-between;align-items:center;font-size:11px;padding:3px 0;color:#64748b;}
.alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:3px;padding:7px 10px;font-size:12px;color:#15803d;margin-bottom:8px;display:flex;align-items:center;gap:6px;}
.alert-warn{background:#fef3c7;border:1px solid #fde68a;border-radius:3px;padding:7px 10px;font-size:12px;color:#b45309;margin-bottom:8px;display:flex;align-items:center;gap:6px;}
hr.dv{border:none;border-top:1px solid #e2e8f0;margin:.65rem 0;}

/* ── Modal cámara ── */
@keyframes scanAnim{
    0%  { top:0; }
    50% { top:calc(100% - 2px); }
    100%{ top:0; }
}

/* ── Modal lote/vencimiento ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;padding:1rem;}
.modal-box{background:#fff;border-radius:6px;width:100%;max-width:380px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.25);}
.modal-head{background:#1e3a5f;padding:.7rem 1rem;display:flex;justify-content:space-between;align-items:center;}
.modal-head span{color:#fff;font-size:13px;font-weight:700;}
.modal-head button{background:none;border:none;color:#93c5fd;font-size:18px;cursor:pointer;line-height:1;padding:2px 6px;}
.modal-body{padding:1rem;}
.modal-warn{background:#fef3c7;border:1px solid #fde68a;border-radius:4px;padding:9px 10px;font-size:11px;color:#92400e;margin-bottom:12px;line-height:1.5;}

/* ── Rediseño visual DISTAN: coherente con el panel de pedidos ── */
.pg{
    padding:clamp(12px,1.5vw,22px);
    background:#f4f7fb;
    min-height:100vh;
    color:#172554;
}
.erp-bar{
    background:#102b4e;
    height:42px;
    padding:0 1.25rem;
    margin:-20px -20px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}
.erp-bar-title{color:#e7f0ff;font-size:12px;letter-spacing:.04em;}
.erp-breadcrumb{color:#b8cbe5;}
.erp-user{background:#174078;color:#fff;border-radius:999px;padding:5px 11px;}
.order-header{
    background:#fff;
    border:1px solid #e1eaf5;
    border-top:0;
    border-radius:14px;
    padding:16px 18px;
    margin-bottom:14px;
    box-shadow:0 4px 14px rgba(15,45,80,.04);
    position:relative;
}
.order-header:before{
    content:"";
    position:absolute;left:0;top:0;bottom:0;width:4px;
    border-radius:14px 0 0 14px;background:#2563eb;
}
.order-id{font-size:19px;color:#102e5b;letter-spacing:-.02em;}
.order-sub{font-size:12px;color:#64748b;line-height:1.6;}
.status-chip{border-radius:999px;letter-spacing:0;padding:6px 11px;font-size:11px;}
.kpis{gap:10px;margin-bottom:14px;}
.kpi{
    border:1px solid #e1eaf5;border-left:0!important;border-radius:12px;
    padding:12px 14px;background:#fff;box-shadow:0 3px 12px rgba(15,45,80,.035);
    position:relative;overflow:hidden;
}
.kpi:before{content:"";position:absolute;left:0;top:0;bottom:0;width:4px;background:#3b82f6;}
.kpi:nth-child(2):before{background:#22c55e;}
.kpi:nth-child(3):before{background:#ef4444;}
.kpi:nth-child(4):before{background:#0ea5e9;}
.kpi:nth-child(5):before{background:#1e40af;}
.kpi-label{color:#64748b;letter-spacing:.035em;font-size:9px;}
.kpi-val{font-size:21px;color:#102e5b;}
.kpi-sub{font-size:10px;color:#94a3b8;}
.layout{grid-template-columns:minmax(0,1fr) 300px;gap:14px;align-items:start;}
.left-col{gap:14px;min-width:0;}
.panel{
    border:1px solid #e1eaf5;border-radius:13px;overflow:hidden;
    box-shadow:0 3px 12px rgba(15,45,80,.035);
}
.panel-header{
    background:#f8fbff;border-bottom:1px solid #e7eef7;
    padding:11px 14px;min-height:42px;
}
.panel-title{font-size:12px;color:#173b70;letter-spacing:.015em;text-transform:none;}
.panel-body{padding:14px;}
.scanner-erp{
    background:linear-gradient(110deg,#10294b,#163b69);
    border:1px solid #244a77;border-radius:12px;padding:10px 12px;
    box-shadow:0 4px 12px rgba(16,43,78,.08);
}
.scan-input{
    background:#fff;color:#102e5b;border:1px solid #d6e3f2;
    border-radius:8px;padding:9px 11px;font-size:14px;
}
.scan-input::placeholder{color:#8294ad;font-size:12px;}
.scan-input:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.15);}
.add-grid{gap:9px;}
.flabel{color:#64748b;font-size:10px;letter-spacing:.04em;}
.finput{
    border-color:#d8e3f0;border-radius:8px;padding:9px 10px;
    font-size:12px;min-height:36px;
}
.finput:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1);}
.erp-table{font-size:12px;}
.erp-table th{
    background:#f1f6fc;color:#526783;border-bottom:1px solid #dce7f4;
    font-size:9px;letter-spacing:.04em;padding:10px 9px;
}
.erp-table td{padding:9px;border-bottom:1px solid #edf2f8;}
.erp-table tbody tr:hover td{background:#f6faff;}
.erp-table .num-input{
    border:1px solid #d8e3f0;border-radius:7px;padding:6px 7px;
}
.lote-badge{border-radius:6px;background:#f5f8fc;border-color:#e0e9f4;}
.btn-xs{border-radius:7px;padding:6px 9px;}
.btn-primary{
    background:#2563eb;border-radius:8px;padding:9px 14px;
    box-shadow:0 3px 8px rgba(37,99,235,.15);
}
.btn-green{
    background:#16a34a;border-radius:8px;padding:9px 14px;
    box-shadow:0 3px 8px rgba(22,163,74,.13);
}
.btn-edit,.btn-save,.btn-del,.btn-cancel{border-radius:7px;}
.summary-table tr td{padding:8px 7px;border-bottom:1px solid #edf2f8;}
.summary-table .total-row td{border-top:1px solid #d8e3f0;color:#173b70;}
.alert-ok,.alert-warn{border-radius:9px;padding:9px 12px;}
hr.dv{border-top-color:#e8eef6;}
.modal-overlay{backdrop-filter:blur(3px);}
.modal-box{border-radius:14px;box-shadow:0 18px 50px rgba(10,30,60,.28);}
.modal-head{background:#102e5b;padding:13px 16px;}
.modal-head button{color:#dbeafe;}
.modal-body{padding:16px;}
.modal-warn{border-radius:8px;}
@media(max-width:1100px){
    .layout{grid-template-columns:minmax(0,1fr) 270px;}
}
@media(max-width:900px){
    .pg{padding:12px;}
    .layout{grid-template-columns:minmax(0,1fr);}
    .right-col{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;}
}
@media(max-width:600px){
    .erp-bar{margin:-12px -12px 0;padding:0 12px;height:38px;}
    .erp-bar-title{font-size:10px;}
    .erp-user{font-size:10px;}
    .pg{padding:10px;background:#f3f7fc;}
    .order-header{padding:14px 13px;border-radius:12px;}
    .order-id{font-size:17px;}
    .order-sub{font-size:11px;}
    .kpis{gap:8px;}
    .kpi{padding:10px 11px;border-radius:10px;}
    .kpi-val{font-size:19px;}
    .layout{gap:10px;}
    .left-col{gap:10px;}
    .right-col{display:flex;flex-direction:column;gap:10px;}
    .panel{border-radius:11px;}
    .panel-header{padding:10px 12px;}
    .panel-body{padding:11px;}
    .scanner-erp{flex-wrap:wrap;}
    .scan-input{font-size:16px;min-width:0;width:100%;}
    .erp-table{min-width:580px;}
}

/* ══════════════════════════════════════════════════════════
   PEDIDO LOCAL · rediseño (prefijo lc-) — aditivo
   Reutiliza: .scanner-erp, .scan-led, .scan-input, .add-grid, .flabel,
   .finput, .btn-primary, .btn-xs y los modales del CSS anterior.
══════════════════════════════════════════════════════════ */
.lc{
    --lc-navy:#1e3a5f; --lc-blue:#1d7ff2; --lc-blue-soft:#eaf2ff;
    --lc-green:#16a34a; --lc-orange:#f59e0b; --lc-red:#ef4444;
    --lc-text:#0f172a; --lc-muted:#64748b; --lc-line:#e2e8f0; --lc-bg:#f8fafc;
    --lc-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
    color:var(--lc-text);
}
.lc *{box-sizing:border-box;}
.lc-i{width:16px;height:16px;flex-shrink:0;}
.lc-num{font-family:var(--lc-mono);font-variant-numeric:tabular-nums;}
.lc-card{background:#fff;border:1px solid var(--lc-line);border-radius:14px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.lc-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 11px;border-radius:7px;font-size:11.5px;font-weight:700;white-space:nowrap;}

/* Cabecera de página */
.lc-crumb{font-size:12.5px;color:var(--lc-muted);margin-bottom:10px;}
.lc-crumb b{color:var(--lc-text);font-weight:600;}
.lc-head{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:14px;}
.lc-head-l{display:flex;align-items:center;gap:14px;}
.lc-logo{width:56px;height:56px;border-radius:14px;background:#e3eefc;color:var(--lc-blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.lc-logo .lc-i{width:28px;height:28px;}
.lc-title{font-size:24px;font-weight:800;color:var(--lc-navy);margin:0;line-height:1.1;letter-spacing:-.3px;}
.lc-sub{font-size:13px;color:var(--lc-muted);margin-top:4px;}
.lc-head-r{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.lc-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;border:1px solid transparent;font-family:inherit;transition:filter .15s,background .15s;}
.lc-btn:hover{filter:brightness(.95);}
.lc-btn.blue{background:var(--lc-blue);color:#fff;}
.lc-btn.green{background:#16a34a;color:#fff;}
.lc-btn.purple{background:#7c3aed;color:#fff;}
.lc-btn.white{background:#fff;color:var(--lc-blue);border-color:#cfe0fb;}
.lc-btn.sm{padding:8px 13px;font-size:12px;}
.lc-btn.is-off{opacity:.45;cursor:not-allowed;}
.lc-btn.is-off:hover{filter:none;}

/* KPIs */
.lc-kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:14px;}
@media(max-width:1100px){.lc-kpis{grid-template-columns:repeat(3,1fr);}}
@media(max-width:620px){.lc-kpis{grid-template-columns:1fr 1fr;}}
.lc-k{display:flex;align-items:center;gap:12px;border-radius:14px;padding:13px 14px;background:#fff;border:1px solid var(--lc-line);}
.lc-k-ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.lc-k-ic .lc-i{width:24px;height:24px;}
.lc-k small.l{display:block;font-size:12px;font-weight:700;color:#334155;}
.lc-k b{display:block;font-size:24px;font-weight:800;line-height:1.1;font-family:var(--lc-mono);}
.lc-k small.s{font-size:11px;color:var(--lc-muted);}
.lc-k.t-blue .lc-k-ic{background:#dbeafe;color:#2563eb;}.lc-k.t-blue{background:#f3f8ff;border-color:#dbe8ff;}
.lc-k.t-green .lc-k-ic{background:#d1fae5;color:#16a34a;}.lc-k.t-green{background:#f1fcf5;border-color:#c9f0d5;}.lc-k.t-green b{color:#15803d;}
.lc-k.t-red .lc-k-ic{background:#fee2e2;color:#dc2626;}.lc-k.t-red{background:#fff4f4;border-color:#fecaca;}.lc-k.t-red b{color:#b91c1c;}
.lc-k.t-orange .lc-k-ic{background:#fde9c4;color:#d97706;}.lc-k.t-orange{background:#fff9ee;border-color:#fde7b0;}
.lc-k.t-navy .lc-k-ic{background:#dbe5f5;color:#1e3a5f;}.lc-k.t-navy{background:#f0f6ff;border-color:#d3e1f7;}
.lc-k.t-money b{font-size:19px;color:var(--lc-navy);}

/* Tarjeta principal */
.lc-main{margin-bottom:14px;overflow:hidden;}
.lc-oh{display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;align-items:flex-start;padding:16px 18px 6px;}
.lc-oh-l{display:flex;gap:13px;align-items:flex-start;min-width:0;}
.lc-oh-ic{width:48px;height:48px;border-radius:12px;background:#e8f0fe;color:var(--lc-blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.lc-oh-ic .lc-i{width:24px;height:24px;}
.lc-oh-t{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.lc-oh-t strong{font-size:20px;font-weight:800;color:var(--lc-navy);font-family:var(--lc-mono);letter-spacing:-.5px;}
.lc-oh-cli{font-size:13.5px;font-weight:600;color:#334155;margin-top:3px;}
.lc-oh-r{display:flex;gap:8px;flex-wrap:wrap;}
.lc-meta{display:flex;gap:22px;flex-wrap:wrap;padding:6px 18px 12px;font-size:12.5px;color:var(--lc-muted);}
.lc-meta span{display:inline-flex;align-items:center;gap:7px;}
.lc-meta b{color:var(--lc-text);font-weight:600;}

/* Tabs */
.lc-tabs{display:flex;gap:2px;border-bottom:1px solid var(--lc-line);padding:0 14px;overflow-x:auto;}
.lc-tab{background:none;border:none;padding:12px 18px;font-size:13.5px;font-weight:600;color:var(--lc-muted);cursor:pointer;border-bottom:3px solid transparent;margin-bottom:-1px;white-space:nowrap;font-family:inherit;}
.lc-tab.on{color:var(--lc-blue);border-bottom-color:var(--lc-blue);}
.lc-pane{display:none;padding:16px 18px 18px;}
.lc-pane.on{display:block;}

/* Progreso */
.lc-prog-top{display:flex;justify-content:space-between;align-items:flex-end;gap:10px;margin-bottom:7px;}
.lc-prog-top b{font-size:13.5px;}
.lc-prog-top span{font-size:12.5px;color:#334155;}
.lc-prog-row{display:flex;align-items:center;gap:14px;margin-bottom:14px;}
.lc-bar{flex:1;height:11px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.lc-bar > div{height:100%;border-radius:99px;}
.lc-prog-pct{font-size:24px;font-weight:800;font-family:var(--lc-mono);}

/* Barra de herramientas */
.lc-tools{display:flex;gap:9px;align-items:center;flex-wrap:wrap;margin-bottom:12px;}
.lc-search{position:relative;flex:1;min-width:220px;}
.lc-search .lc-i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;}
.lc-search input{width:100%;padding:10px 12px 10px 34px;border:1px solid var(--lc-line);border-radius:9px;font-size:13px;outline:none;font-family:inherit;}
.lc-search input:focus,.lc-sel:focus{border-color:var(--lc-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);outline:none;}
.lc-sel{padding:10px 11px;border:1px solid var(--lc-line);border-radius:9px;font-size:13px;background:#fff;font-family:inherit;color:var(--lc-text);}
.lc-addbox{display:none;background:var(--lc-bg);border:1px solid var(--lc-line);border-radius:12px;padding:14px;margin-bottom:12px;}
.lc-addbox.open{display:block;}
.lc-scanwrap{margin-bottom:12px;}

/* Tabla */
.lc-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;border:1px solid var(--lc-line);border-radius:12px;}
.lc-tbl{width:100%;min-width:1000px;border-collapse:collapse;font-size:12.5px;}
.lc-tbl th{background:#f1f5f9;color:#475569;font-size:11px;font-weight:700;padding:10px;text-align:left;white-space:nowrap;}
.lc-tbl th.c,.lc-tbl td.c{text-align:center;}
.lc-tbl th.r,.lc-tbl td.r{text-align:right;}
.lc-tbl td{padding:9px 10px;border-top:1px solid #eef2f7;vertical-align:middle;}
.lc-tbl tr.lc-row:hover td{background:#fafcff;}
.lc-prod{display:flex;align-items:flex-start;gap:10px;min-width:210px;}
.lc-thumb{width:38px;height:38px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:18px;flex-shrink:0;}
.lc-thumb img{width:100%;height:100%;object-fit:cover;}
.lc-pname{font-weight:700;font-size:13px;color:var(--lc-text);}
.lc-tbl .num-input{width:78px;padding:6px 7px;border:1px solid #d8e3f0;border-radius:7px;font-size:12px;text-align:center;background:#fff;outline:none;font-family:var(--lc-mono);}
.lc-tbl .num-input:focus{border-color:var(--lc-blue);}
.lc-tbl .num-input:disabled{background:#f8fafc;color:#64748b;border-color:#e8eef6;}
.lc-pg{display:flex;align-items:center;gap:7px;min-width:120px;}
.lc-pg .lc-bar{height:7px;}
.lc-pg b{font-family:var(--lc-mono);font-size:11.5px;min-width:36px;text-align:right;}
.lc-acts{display:flex;gap:5px;align-items:center;flex-wrap:wrap;}
.lc-acts form{display:inline;margin:0;}
.lc-count{padding:9px 14px;font-size:11.5px;color:var(--lc-muted);}
.lc-empty{display:none;text-align:center;padding:24px;color:var(--lc-muted);font-size:13px;}

/* Información / observaciones / historial */
.lc-info{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media(max-width:820px){.lc-info{grid-template-columns:1fr;}}
.lc-box{border:1px solid var(--lc-line);border-radius:12px;padding:14px;}
.lc-box h4{margin:0 0 10px;font-size:13px;font-weight:800;color:var(--lc-navy);}
.lc-box .summary-table{font-size:12.5px;}
.lc-obs-txt{font-size:13.5px;line-height:1.6;color:#334155;white-space:pre-wrap;min-height:60px;}
.lc-ev{display:flex;gap:12px;align-items:flex-start;padding:10px 12px;border:1px solid var(--lc-line);border-radius:11px;margin-bottom:7px;}
.lc-ev-ic{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;background:var(--lc-blue-soft);}
.lc-ev b{display:block;font-size:13px;}
.lc-ev span{font-size:12px;color:var(--lc-muted);}
.lc-ev time{margin-left:auto;font-size:11.5px;color:var(--lc-muted);font-family:var(--lc-mono);white-space:nowrap;}

/* Línea de estado */
.lc-steps{display:grid;grid-template-columns:repeat(5,1fr);padding:18px 24px 12px;position:relative;margin-bottom:6px;}
@media(max-width:700px){.lc-steps{padding:14px 4px 8px;}}
.lc-step{text-align:center;position:relative;font-size:12px;color:var(--lc-muted);padding-top:2px;}
.lc-step .dot{width:26px;height:26px;border-radius:50%;margin:0 auto 7px;display:flex;align-items:center;justify-content:center;background:#e5e7eb;color:#fff;position:relative;z-index:2;}
.lc-step .dot .lc-i{width:14px;height:14px;}
.lc-step::before{content:'';position:absolute;top:15px;left:-50%;width:100%;height:3px;background:#e5e7eb;z-index:1;}
.lc-step:first-child::before{display:none;}
.lc-step.done .dot{background:#2563eb;}
.lc-step.done::before{background:#2563eb;}
.lc-step.cur .dot{box-shadow:0 0 0 5px rgba(37,99,235,.15);}
.lc-step b{display:block;font-size:12px;color:#334155;font-weight:700;}
.lc-step.done b{color:var(--lc-text);}
.lc-step small{display:block;font-size:10.5px;color:#94a3b8;font-family:var(--lc-mono);margin-top:1px;min-height:13px;}

/* Barra de acciones */
.lc-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:6px;}
.lc-actions .lc-btn{padding:12px 20px;}
.lc-actions .lc-btn.big{min-width:290px;justify-content:center;}
@media(max-width:620px){.lc-actions .lc-btn{flex:1;justify-content:center;}.lc-actions .lc-btn.big{min-width:100%;order:-1;}}

/* ── Franja: personal que armó + tiempo de armado ── */
.lc-band{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;padding:12px 18px;margin-bottom:14px;}
.lc-band-l{display:flex;align-items:center;gap:12px;min-width:0;}
.lc-band-ic{width:42px;height:42px;border-radius:11px;background:#e8f0fe;color:var(--lc-blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.lc-band-ic .lc-i{width:22px;height:22px;}
.lc-band small.k{display:block;font-size:9.5px;font-weight:700;letter-spacing:.06em;color:#64748b;text-transform:uppercase;}
.lc-band b{display:block;font-size:15px;font-weight:800;margin-top:1px;}
.lc-band .names{font-size:10.5px;color:#94a3b8;margin-top:1px;max-width:560px;}
.lc-band-r{display:flex;gap:8px;flex-wrap:wrap;}
.lc-pill{display:inline-flex;align-items:center;gap:6px;border:1px solid #cfe0fb;background:#f3f8ff;border-radius:99px;padding:6px 13px;font-size:11.5px;font-weight:700;color:#1d4ed8;white-space:nowrap;}
.lc-pill .lc-i{width:14px;height:14px;}
.lc-pill.time{background:#fff7e6;border-color:#fde7b0;color:#b45309;}
.lc-pill.time b{display:inline;font-size:12.5px;margin:0;}

/* ── Dropdowns de la barra de herramientas ── */
.lc-dd{position:relative;}
.lc-dd-menu{display:none;position:absolute;right:0;top:calc(100% + 6px);min-width:230px;background:#fff;border:1px solid var(--lc-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.14);padding:10px;z-index:60;}
.lc-dd.open .lc-dd-menu{display:block;}
.lc-dd-lbl{display:block;font-size:10.5px;font-weight:700;color:var(--lc-muted);text-transform:uppercase;letter-spacing:.04em;margin:6px 2px 4px;}
.lc-dd-item{display:flex;align-items:center;gap:9px;width:100%;padding:9px 10px;border:none;background:none;border-radius:7px;font-size:13px;color:#1e293b;cursor:pointer;font-family:inherit;text-align:left;}
.lc-dd-item:hover{background:#f1f5f9;}

/* ── Tabla estilo mockup ── */
.lc-tbl2{min-width:1380px;font-size:12px;}
.lc-tbl2 th{padding:11px 9px;font-size:11px;color:#334155;}
.lc-tbl2 td{padding:8px 9px;}
.lc-tbl2 .idx{width:28px;color:#475569;}
.lc-tbl2 .lc-prod{min-width:230px;align-items:center;}
.lc-tbl2 .lc-thumb{width:34px;height:34px;}
.lc-tbl2 .lc-pname{font-weight:800;font-size:12.5px;}
.lc-tbl2 .num-input{width:74px;font-size:12.5px;}
/* Cantidades: se ven como texto; al editar se vuelven campos */
.lc-tbl2 .num-input:disabled{border-color:transparent;background:transparent;font-weight:800;color:#0f172a;-webkit-text-fill-color:#0f172a;opacity:1;-moz-appearance:textfield;appearance:textfield;}
.lc-tbl2 .num-input.des-in:disabled{color:#16a34a;-webkit-text-fill-color:#16a34a;}
.lc-tbl2 .num-input:not(:disabled){border:1px solid #93c5fd;background:#fff;}
/* Precio: solo aparece al editar la fila */
.lc-tbl2 .pre-in:disabled{display:none;}
.lc-tbl2 .pre-in:not(:disabled){display:block;margin:5px 0 0 auto;}
.lc-pal{font-size:12.5px;font-weight:800;}
.lc-arm{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:700;color:#1e3a5f;white-space:nowrap;}
.lc-arm .lc-i{width:13px;height:13px;color:#2563eb;}
.lc-oct{width:40px;height:40px;flex:0 0 40px;background:#111;color:#fff;clip-path:polygon(30% 0,70% 0,100% 30%,100% 70%,70% 100%,30% 100%,0 70%,0 30%);display:inline-flex;flex-direction:column;align-items:center;justify-content:center;font-size:6.5px;font-weight:900;line-height:1.1;text-align:center;margin:0 1px;padding:2px;box-sizing:border-box;}
.lc-oct span{display:block;}
.lc-octs{display:flex;gap:5px;justify-content:center;align-items:center;flex-wrap:wrap;min-width:125px;}
.lc-octw{display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;flex:0 0 42px;}
.lc-octimg{width:42px;height:42px;object-fit:contain;display:block;}
.lc-tbl2 td:has(.lc-octs){min-width:135px;}
.lc-tbl2 .lc-pg{min-width:130px;}
.lc-tbl2 .lc-pg .lc-bar{height:8px;}
.lc-tbl2 .lc-acts{gap:7px;flex-wrap:nowrap;}
.lc-ic{width:34px;height:34px;border:1px solid transparent;background:transparent;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;color:#334155;padding:0;text-decoration:none;}
.lc-ic:hover{background:#f1f5f9;}
.lc-ic .lc-i{width:16px;height:16px;}
.lc-ic.del{color:#dc2626;background:#fff1f1;border-color:#fde2e2;}
.lc-ic.del:hover{background:#fee2e2;}
.lc-ic.lc-save{color:#fff;background:#16a34a;}
.lc-ic.lc-save:hover{background:#15803d;}
.lc-octs{display:flex;gap:4px;justify-content:center;align-items:center;flex-wrap:nowrap;}
.lc-octw{display:inline-flex;}
.lc-octimg{width:40px;height:40px;object-fit:contain;display:block;}

/* Buscador desplegable de productos con el mismo comportamiento visual que Kardex */
.erp-product-combo{position:relative;width:100%;min-width:0}
.erp-product-native{position:absolute!important;left:0!important;bottom:0!important;width:1px!important;height:1px!important;opacity:0!important;pointer-events:none!important}
.erp-product-trigger{width:100%;min-height:36px;display:flex;align-items:center;justify-content:space-between;gap:8px;padding:8px 10px;border:1px solid #d5e0ef;border-radius:8px;background:#fff;color:#1e293b;font:inherit;font-size:12px;text-align:left;cursor:pointer}
.erp-product-trigger:focus{outline:0;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.erp-product-trigger span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.erp-product-trigger .erp-placeholder{color:#64748b}
.erp-product-panel{position:absolute;left:0;right:0;top:calc(100% + 6px);z-index:1000;padding:8px;background:#fff;border:1px solid #dfe8f5;border-radius:10px;box-shadow:0 16px 36px rgba(15,42,77,.2)}
.erp-product-panel[hidden]{display:none}
.erp-product-search{width:100%;height:36px;padding:0 10px;margin-bottom:6px;border:1px solid #d5e0ef;border-radius:8px;outline:0;font:inherit;font-size:12px}
.erp-product-search:focus{border-color:#2563eb;box-shadow:0 0 0 2px rgba(37,99,235,.1)}
.erp-product-options{list-style:none;margin:0;padding:0;max-height:220px;overflow-y:auto}
.erp-product-options li{padding:8px 10px;border-radius:7px;font-size:12px;color:#334155;cursor:pointer}
.erp-product-options li:hover,.erp-product-options li.is-active{background:#eef4fd;color:#1d4ed8}
.erp-product-options li.is-selected{font-weight:700;color:#1d4ed8}
.erp-product-empty{padding:12px;text-align:center;color:#94a3b8;font-size:12px}
.erp-view-loader{position:fixed;inset:0;z-index:99999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;background:rgba(243,247,253,.94);backdrop-filter:blur(4px);opacity:1;visibility:visible;transition:opacity .35s,visibility .35s}
.erp-view-loader.is-hidden{opacity:0;visibility:hidden;pointer-events:none}
.erp-view-loader-logo{position:relative;width:84px;height:84px;display:flex;align-items:center;justify-content:center}
.erp-view-loader-logo img,.erp-view-loader-logo svg{width:64px;height:64px;border-radius:16px;animation:erpLogoPulse 1.4s ease-in-out infinite;box-shadow:0 8px 24px rgba(29,78,216,.3)}
.erp-view-loader-ring{position:absolute;inset:0;border-radius:50%;border:3px solid #d6e4fb;border-top-color:#2563eb;animation:erpLogoSpin 1s linear infinite}
.erp-view-loader-text{font-size:13px;font-weight:700;color:#1e3a5f;letter-spacing:.3px}
.erp-view-loader-bar{width:150px;height:4px;border-radius:99px;background:#dbe6f6;overflow:hidden}
.erp-view-loader-bar i{display:block;width:40%;height:100%;background:#2563eb;border-radius:99px;animation:erpLogoSlide 1.1s ease-in-out infinite}
@keyframes erpLogoSpin{to{transform:rotate(360deg)}}@keyframes erpLogoPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.07)}}@keyframes erpLogoSlide{0%{margin-left:-40%}100%{margin-left:100%}}
@media(max-width:600px){.erp-product-panel{min-width:0}}

</style>
<noscript><style>.erp-view-loader{display:none!important}</style></noscript>
<div class="erp-view-loader" id="erpViewLoader" role="status" aria-live="polite">
    <div class="erp-view-loader-logo"><span class="erp-view-loader-ring"></span>
        @if($erpLogoUrl)<img src="{{ $erpLogoUrl }}" alt="Logo DISTAN">@else{!! $erpLogoSvg !!}@endif
    </div>
    <div class="erp-view-loader-text">Cargando pedido local...</div><div class="erp-view-loader-bar"><i></i></div>
</div>


<div class="pg">

@if(session('success'))
<div class="alert-ok" style="margin-bottom:.85rem;">✅ {{ session('success') }}</div>
@endif

{{-- ── Datos base (SIN CAMBIOS respecto al original) ── --}}
@php
    $totalItems  = $order->details->count();
    $completados = $order->details->filter(fn($i) => $i->cantidad_despachada >= $i->cantidad_solicitada && $i->cantidad_solicitada > 0)->count();
    $parciales   = $order->details->filter(fn($i) => $i->cantidad_despachada > 0 && $i->cantidad_despachada < $i->cantidad_solicitada)->count();
    $pendientes  = $order->details->filter(fn($i) => $i->cantidad_despachada == 0)->count();
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d' : ($order->estado === 'PARCIAL' ? '#b45309' : '#b91c1c');
    $estadoBg    = $order->estado === 'COMPLETO' ? '#dcfce7' : ($order->estado === 'PARCIAL' ? '#fef3c7' : '#fee2e2');
@endphp

{{-- ── Datos adicionales para el rediseño (solo lectura) ── --}}
@php
    // Rutas opcionales: si las defines, el botón se activa solo.
    // Ej: $lcRutaGuia = route('orders.guia', $order);   $lcRutaListo = route('orders.marcarListo', $order);
    $lcRutaGuia  = null;
    $lcRutaListo = null;

    $lcPct = $totalItems > 0 ? round(($completados / $totalItems) * 100) : 0;
    $lcPctColor = $lcPct >= 100 ? '#16a34a' : '#1d7ff2';
    $lcEstadoTxt = ['COMPLETO' => 'Completado', 'PARCIAL' => 'En preparación'][$order->estado] ?? 'Pendiente';
    $lcFecha = fn($v, $f = 'd/m/Y') => $v ? \Carbon\Carbon::parse($v)->format($f) : '—';
    $lcFechaHora = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m H:i') : '';
    $lcN = fn($n) => rtrim(rtrim(number_format((float) $n, 2, '.', ''), '0'), '.') ?: '0';
    $lcObs = $order->observaciones ?? $order->observacion ?? null;
    $lcImg = function ($p) {
        $i = $p->imagen ?? $p->image ?? $p->foto ?? null;
        if ($i && is_string($i) && !preg_match('#^(https?:)?//#', $i)) { $i = asset('storage/' . ltrim($i, '/')); }
        return is_string($i) ? $i : null;
    };

    // Línea de estado del pedido
    $lcAnyDesp = $order->details->contains(fn($i) => $i->cantidad_despachada > 0);
    $lcAllDone = $completados === $totalItems && $totalItems > 0;
    $lcUlt     = $order->details->max('updated_at');
    $lcFechaDesp = $order->fecha_despacho ?? $order->despachado_at ?? null;
    $lcSteps = [
        ['Pedido registrado',     true,                                                   $order->created_at ?? null],
        ['En preparación',        $lcAnyDesp,                                             $lcAnyDesp ? $lcUlt : null],
        ['Listo para despacho',   $lcAllDone,                                             $lcAllDone ? $lcUlt : null],
        ['Despachado',            (bool) $lcFechaDesp,                                    $lcFechaDesp],
        ['Completado',            (bool) $lcFechaDesp && $order->estado === 'COMPLETO',   $order->estado === 'COMPLETO' ? ($order->updated_at ?? null) : null],
    ];
    $lcCur = 0;
    foreach ($lcSteps as $k => $s) { if ($s[1]) { $lcCur = $k; } }

    // ── Personal que armó la orden (lee el nombre de cada línea; ajusta aquí si tu campo se llama distinto) ──
    $lcArmo = function ($i) {
        $n = $i->personal_despacho ?? $i->armado_por ?? $i->armo ?? null;
        if (!is_string($n) || $n === '' || is_numeric($n)) {
            $u = $i->usuario ?? $i->user ?? $i->operario ?? null;
            $n = is_object($u) ? ($u->name ?? $u->nombre ?? null) : (is_string($u) ? $u : null);
        }
        return is_string($n) && trim($n) !== '' && !is_numeric($n) ? trim($n) : null;
    };
    $lcPersonas = [];
    foreach ($order->details as $x) {
        $n = $lcArmo($x);
        if ($n) { $lcPersonas[$n] = ($lcPersonas[$n] ?? 0) + 1; }
    }
    ksort($lcPersonas);
    $lcPersonasN = count($lcPersonas);

    // ── Tiempo de armado: del primer al último despacho registrado (o campos propios si existen) ──
    $lcConDesp = $order->details->filter(fn($i) => $i->cantidad_despachada > 0 && ($i->updated_at ?? null));
    $lcIni = $order->inicio_armado ?? $order->armado_inicio ?? $lcConDesp->min('updated_at');
    $lcFin = $order->fin_armado ?? $order->armado_fin ?? ($lcAllDone ? $lcConDesp->max('updated_at') : null);
    $lcFinEf = $lcFin ?: now();
    $lcDur = function ($a, $b) {
        if (!$a || !$b) { return null; }
        $s = abs(\Carbon\Carbon::parse($b)->getTimestamp() - \Carbon\Carbon::parse($a)->getTimestamp());
        $d = intdiv($s, 86400); $h = intdiv($s % 86400, 3600); $m = intdiv($s % 3600, 60);
        $p = [];
        if ($d) { $p[] = $d . ' d'; }
        if ($h) { $p[] = $h . ' h'; }
        if ($m || !$p) { $p[] = $m . ' min'; }
        return implode(' ', $p);
    };
    $lcTiempoArmado = $lcIni ? $lcDur($lcIni, $lcFinEf) : null;
    $lcTiempoTotal  = ($order->created_at ?? null) ? $lcDur($order->created_at, $lcFinEf) : null;
    $lcEnCurso      = !$lcFin;

    // ── Octógonos (lee product->octogonos o alto_azucar / alto_sodio / alto_grasas_saturadas / alto_grasas_trans) ──
    $lcOctLabel = function ($k) {
        $k = mb_strtolower((string) $k);
        if (str_contains($k, 'azuc') || str_contains($k, 'azúc')) return ['ALTO EN', 'AZÚCAR'];
        if (str_contains($k, 'sod'))                              return ['ALTO EN', 'SODIO'];
        if (str_contains($k, 'satur'))                            return ['ALTO EN', 'GRAS.SAT.'];
        if (str_contains($k, 'trans'))                            return ['ALTO EN', 'GRAS.TRANS'];
        if (str_contains($k, 'grasa'))                            return ['ALTO EN', 'GRASAS'];
        return ['', mb_strtoupper(mb_substr($k, 0, 10))];
    };
    // Imágenes de octógonos (las mismas de la vista de control de la orden)
    $lcOctImgs = [
        'azucar' => 'https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png',
        'sodio'  => 'https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png',
        'grasas' => 'https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png',
    ];

    // Historial (derivado de las fechas de registro existentes)
    $lcEventos = collect();
    $lcAdd = function ($f, $ico, $t, $d = '') use (&$lcEventos) {
        if (!$f) { return; }
        $c = \Carbon\Carbon::parse($f);
        $lcEventos->push(['f' => $c, 'ts' => $c->getTimestamp(), 'i' => $ico, 't' => $t, 'd' => $d]);
    };
    $lcAdd($order->created_at ?? null, '🆕', 'Pedido local registrado', $order->numero_orden);
    foreach ($order->details as $d) {
        $nom = $d->product->nombre ?? 'Producto';
        $lcAdd($d->created_at ?? null, '➕', 'Producto agregado', $nom . ' · ' . $lcN($d->cantidad_solicitada) . ' u');
        if (($d->created_at ?? null) && ($d->updated_at ?? null)
            && abs(\Carbon\Carbon::parse($d->updated_at)->getTimestamp() - \Carbon\Carbon::parse($d->created_at)->getTimestamp()) > 60) {
            $lcAdd($d->updated_at, '✏️', 'Línea actualizada', $nom . ' · preparado ' . $lcN($d->cantidad_despachada) . ' de ' . $lcN($d->cantidad_solicitada));
        }
    }
    $lcEventos = $lcEventos->sortByDesc('ts')->values();
@endphp

{{-- Iconos --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="lc-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 1.98-1.7L23 6H6"/></symbol>
    <symbol id="lc-store" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M5 12v8h14v-8"/><path d="M10 20v-5h4v5"/></symbol>
    <symbol id="lc-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
    <symbol id="lc-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="lc-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></symbol>
    <symbol id="lc-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
    <symbol id="lc-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
    <symbol id="lc-money" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></symbol>
    <symbol id="lc-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
    <symbol id="lc-cal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
    <symbol id="lc-printer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></symbol>
    <symbol id="lc-truck" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></symbol>
    <symbol id="lc-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
    <symbol id="lc-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="lc-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
    <symbol id="lc-timer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="13" r="8"/><polyline points="12 9 12 13 15 15"/><line x1="9" y1="2" x2="15" y2="2"/></symbol>
    <symbol id="lc-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="lc-pencil" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></symbol>
    <symbol id="lc-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></symbol>
    <symbol id="lc-save" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
    <symbol id="lc-filter" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></symbol>
    <symbol id="lc-sliders" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></symbol>
    <symbol id="lc-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
</defs></svg>

<div class="lc">

{{-- ══════════ BREADCRUMB + CABECERA ══════════ --}}
<div class="lc-crumb">Operaciones &nbsp;/&nbsp; Órdenes &nbsp;/&nbsp; <b>Pedido local</b></div>

<div class="lc-head">
    <div class="lc-head-l">
        <div class="lc-logo"><svg class="lc-i"><use href="#lc-cart"/></svg></div>
        <div>
            <h1 class="lc-title">Pedido local</h1>
            <div class="lc-sub">Gestiona y da seguimiento a los productos y despachos del pedido.</div>
        </div>
    </div>
    <div class="lc-head-r">
        <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="lc-btn green"><svg class="lc-i"><use href="#lc-file"/></svg> PDF</a>
        {{-- Solo para órdenes LOCAL --}}
        @if($order->tipo_orden === 'LOCAL')
        <a href="{{ route('orders.cartaCalidad', $order) }}" target="_blank" class="lc-btn purple">🏅 Carta de calidad</a>
        @endif
    </div>
</div>

{{-- ══════════ KPIs ══════════ --}}
<div class="lc-kpis">
    <div class="lc-k t-blue"><div class="lc-k-ic"><svg class="lc-i"><use href="#lc-box"/></svg></div><div><small class="l">Productos</small><b>{{ $totalItems }}</b><small class="s">líneas de pedido</small></div></div>
    <div class="lc-k t-green"><div class="lc-k-ic"><svg class="lc-i"><use href="#lc-shield"/></svg></div><div><small class="l">Completos</small><b>{{ $completados }}</b><small class="s">ítems OK</small></div></div>
    <div class="lc-k t-red"><div class="lc-k-ic"><svg class="lc-i"><use href="#lc-alert"/></svg></div><div><small class="l">Pendientes</small><b>{{ $pendientes }}</b><small class="s">sin despachar</small></div></div>
    <div class="lc-k t-orange t-money"><div class="lc-k-ic"><svg class="lc-i"><use href="#lc-money"/></svg></div><div><small class="l">Subtotal</small><b>S/ {{ number_format($order->subtotal,2) }}</b><small class="s">sin IGV</small></div></div>
    <div class="lc-k t-navy t-money"><div class="lc-k-ic"><svg class="lc-i"><use href="#lc-money"/></svg></div><div><small class="l">Total</small><b>S/ {{ number_format($order->total,2) }}</b><small class="s">con IGV 18%</small></div></div>
</div>

{{-- ══════════ PERSONAL QUE ARMÓ + TIEMPO DE ARMADO ══════════ --}}
<div class="lc-card lc-band">
    <div class="lc-band-l">
        <div class="lc-band-ic"><svg class="lc-i"><use href="#lc-user"/></svg></div>
        <div style="min-width:0;">
            <small class="k">Personal que armó la orden</small>
            <b>{{ $lcPersonasN > 0 ? $lcPersonasN . ($lcPersonasN === 1 ? ' persona' : ' personas') : 'Sin registrar' }}</b>
            <div class="names">
                @if($lcPersonasN > 0)
                    @foreach($lcPersonas as $pn => $pc){{ $pn }}@if(!$loop->last) · @endif @endforeach
                @else
                    El nombre de quien arma se muestra cuando la línea lo registra.
                @endif
            </div>
        </div>
    </div>
    <div class="lc-band-r">
        <span class="lc-pill time" title="Del primer al último despacho registrado{{ $lcEnCurso ? ' (aún en curso)' : '' }}">
            <svg class="lc-i"><use href="#lc-timer"/></svg>
            Tiempo de armado:
            <b class="lc-num">{{ $lcTiempoArmado ?? '—' }}</b>
            @if($lcTiempoArmado && $lcEnCurso)<em style="font-style:normal;font-weight:600;opacity:.8;">(en curso)</em>@endif
        </span>
        <span class="lc-pill">{{ $completados }} / {{ $totalItems }} productos completos</span>
    </div>
</div>

{{-- ══════════ TARJETA DEL PEDIDO ══════════ --}}
<div class="lc-card lc-main">

    <div class="lc-oh">
        <div class="lc-oh-l">
            <div class="lc-oh-ic"><svg class="lc-i"><use href="#lc-store"/></svg></div>
            <div>
                <div class="lc-oh-t">
                    <strong>{{ $order->numero_orden }}</strong>
                    <span class="lc-chip" style="background:{{ $estadoBg }};color:{{ $estadoColor }};" title="{{ $order->estado }}">{{ $lcEstadoTxt }}</span>
                </div>
                <div class="lc-oh-cli">{{ $order->client->razon_social ?? '—' }}</div>
            </div>
        </div>
    </div>
    <div class="lc-meta">
        <span><svg class="lc-i"><use href="#lc-cal"/></svg><b class="lc-num">{{ \Carbon\Carbon::parse($order->fecha_pedido ?? now())->format('d/m/Y') }}</b></span>
        <span><svg class="lc-i"><use href="#lc-box"/></svg><b>{{ $totalItems }} productos</b></span>
        <span><svg class="lc-i"><use href="#lc-file"/></svg>Factura: <b class="lc-num">{{ $order->factura_asociada ?? '—' }}</b></span>
        <span><svg class="lc-i"><use href="#lc-truck"/></svg>Guía: <b class="lc-num">{{ $order->guia_asociada ?? '—' }}</b></span>
    </div>

    <div class="lc-tabs">
        <button type="button" class="lc-tab on" data-tab="productos" onclick="lcTab('productos',this)">Productos ({{ $totalItems }})</button>
        <button type="button" class="lc-tab" data-tab="info" onclick="lcTab('info',this)">Información</button>
        <button type="button" class="lc-tab" data-tab="obs" onclick="lcTab('obs',this)">Observaciones</button>
        <button type="button" class="lc-tab" data-tab="hist" onclick="lcTab('hist',this)">Historial de despachos ({{ $lcEventos->count() }})</button>
        <button type="button" class="lc-tab" data-tab="docs" onclick="lcTab('docs',this)">Documentos</button>
    </div>

    {{-- ─────────── PRODUCTOS ─────────── --}}
    <div class="lc-pane on" data-pane="productos">

        <div class="lc-prog-top">
            <b>Progreso de preparación</b>
            <span class="lc-num">{{ $completados }} / {{ $totalItems }} productos</span>
        </div>
        <div class="lc-prog-row">
            <div class="lc-bar"><div style="width:{{ $lcPct }}%;background:{{ $lcPctColor }};"></div></div>
            <div class="lc-prog-pct" style="color:{{ $lcPctColor }};">{{ $lcPct }}%</div>
        </div>

        {{-- Scanner (mismos ids) --}}
        <div class="lc-scanwrap">
            <div class="scanner-erp">
                <div class="scan-led"></div>
                <input type="text" id="scanner" class="scan-input"
                       placeholder="Escanea o escribe código de barras">
                <span style="font-size:10px;color:#b8cbe5;white-space:nowrap;flex-shrink:0;">⏎ Enter</span>
                <button type="button" id="btnCamara" onclick="abrirCamara()"
                        style="display:none;background:#1e3a5f;border:1px solid #334155;color:#7eb8f7;border-radius:4px;padding:6px 10px;cursor:pointer;font-size:13px;white-space:nowrap;flex-shrink:0;">
                    📷 Cámara
                </button>
            </div>
        </div>

        {{-- Agregar producto (formulario original; se abre solo al escanear) --}}
        <div class="lc-addbox" id="lcAddBox">
            <div style="font-size:13px;font-weight:800;margin-bottom:10px;color:var(--lc-navy);">➕ Agregar línea de producto</div>
<form method="POST" action="{{ route('orders.addProduct',$order) }}">
                @csrf
                <div class="add-grid">
                    <div>
                        <label class="flabel">Producto</label>
                        <div class="erp-product-combo" data-erp-product-combo>
                        <select name="product_id" class="finput erp-product-native" data-erp-product-select required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} (Stock: {{ $p->stock }})</option>
                            @endforeach
                        </select>
                        <button type="button" class="erp-product-trigger" aria-expanded="false"><span class="erp-placeholder">Buscar producto...</span><b aria-hidden="true">⌄</b></button>
                        <div class="erp-product-panel" hidden><input type="search" class="erp-product-search" placeholder="Buscar por nombre o código..." autocomplete="off"><ul class="erp-product-options"></ul></div>
                    </div>
                    </div>
                    <div>
                        <label class="flabel">Cantidad</label>
                        <input type="number" name="cantidad_solicitada" class="finput" placeholder="0" required>
                    </div>
                    <div>
                        <label class="flabel">Precio unit.</label>
                        <input type="number" step="0.01" name="precio_unitario" class="finput" placeholder="0.00" required>
                    </div>
                    <button type="submit" class="btn-primary" style="align-self:end;">+ Agregar</button>
                </div>
                </form>
        </div>

        <div class="lc-tools">
            <div class="lc-search">
                <svg class="lc-i"><use href="#lc-search"/></svg>
                <input type="text" id="lcBuscar" placeholder="Buscar producto, SKU o lote..." oninput="lcFiltrar()">
            </div>

            <div class="lc-dd" id="lcDdFiltros">
                <button type="button" class="lc-btn white sm" style="color:#334155;" onclick="lcDD('lcDdFiltros',event)"><svg class="lc-i"><use href="#lc-filter"/></svg> Filtros <svg class="lc-i"><use href="#lc-chev"/></svg></button>
                <div class="lc-dd-menu" onclick="event.stopPropagation()">
                    <span class="lc-dd-lbl">Estado</span>
                    <select class="lc-sel" style="width:100%;" id="lcEstado" onchange="lcFiltrar()">
                        <option value="">Todos los estados</option>
                        <option value="LISTO">Listo</option>
                        <option value="PROCESO">En preparación</option>
                        <option value="PEND">Pendiente</option>
                    </select>
                    <span class="lc-dd-lbl">Armó</span>
                    <select class="lc-sel" style="width:100%;" id="lcArmoSel" onchange="lcFiltrar()">
                        <option value="">Todo el personal</option>
                        @foreach(array_keys($lcPersonas) as $pn)
                            <option value="{{ mb_strtolower($pn) }}">{{ $pn }}</option>
                        @endforeach
                        <option value="__sin__">Sin registrar</option>
                    </select>
                    <button type="button" class="lc-dd-item" style="margin-top:6px;color:var(--lc-blue);" onclick="lcLimpiar()">Limpiar filtros</button>
                </div>
            </div>

            <div class="lc-dd" id="lcDdAcc">
                <button type="button" class="lc-btn white sm" style="color:#334155;" onclick="lcDD('lcDdAcc',event)"><svg class="lc-i"><use href="#lc-sliders"/></svg> Acciones <svg class="lc-i"><use href="#lc-chev"/></svg></button>
                <div class="lc-dd-menu" onclick="event.stopPropagation()">
                    <button type="button" class="lc-dd-item" onclick="document.getElementById('lcAddBox').classList.add('open');lcDD('lcDdAcc',event)"><svg class="lc-i"><use href="#lc-plus"/></svg> Agregar producto</button>
                    <button type="button" class="lc-dd-item" onclick="lcPicking()"><svg class="lc-i"><use href="#lc-printer"/></svg> Imprimir picking</button>
                    <button type="button" class="lc-dd-item" onclick="lcExportCSV()"><svg class="lc-i"><use href="#lc-file"/></svg> Exportar CSV</button>
                </div>
            </div>
        </div>

        <div class="scroll-hint-mobile">← desliza horizontalmente →</div>

        <div class="lc-scroll">
        <table class="lc-tbl lc-tbl2" id="lcTabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>SKU</th>
                    <th class="c">Solicitado</th>
                    <th class="c">Despachado</th>
                    <th class="c">Pendiente</th>
                    <th>Avance</th>
                    <th>Lote</th>
                    <th>Vencimiento</th>
                    <th class="c">Octógonos</th>
                    <th>Últ. despacho</th>
                    <th>Armó</th>
                    <th class="r">Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($order->details as $item)
            @php
                $pct = $item->cantidad_solicitada > 0
                    ? ($item->cantidad_despachada / $item->cantidad_solicitada) * 100 : 0;
                $lc  = $pct >= 100 ? '#22c55e' : ($pct > 0 ? '#f59e0b' : '#ef4444');
                $montoColor = $pct >= 100 ? '#15803d' : ($pct > 0 ? '#b45309' : '#b91c1c');

                // Lote / vencimiento por línea
                $loteItem     = $item->lote;
                $fechaVenc    = $item->fecha_vencimiento;
                $vColor       = '#334155';
                $diasVencItem = null;
                if ($fechaVenc) {
                    $diasVencItem = (int) round(now()->diffInDays(\Carbon\Carbon::parse($fechaVenc), false));
                    if ($diasVencItem < 0)       { $vColor = '#b91c1c'; }
                    elseif ($diasVencItem <= 30) { $vColor = '#b45309'; }
                }

                $lcSol  = (float) $item->cantidad_solicitada;
                $lcDesp = (float) $item->cantidad_despachada;
                $lcPend = max($lcSol - $lcDesp, 0);
                if ($pct >= 100)      { $lcEstK = 'LISTO'; }
                elseif ($lcDesp > 0)  { $lcEstK = 'PROCESO'; }
                else                  { $lcEstK = 'PEND'; }
                $lcThumb = $lcImg($item->product);

                $lcArmoN  = $lcArmo($item);
                $lcUltD   = $lcDesp > 0 ? ($item->updated_at ?? null) : null;
                $lcSubt   = $item->subtotal ?? ($item->cantidad_despachada * $item->precio_unitario);

                $lcOcts = [];
                // Compatibilidad con los dos formatos usados en las vistas: octogonos y advertencias.
                foreach (['octogonos', 'advertencias'] as $lcCampoOct) {
                    $lcRaw = $item->product->{$lcCampoOct} ?? null;
                    if (is_string($lcRaw) && trim($lcRaw) !== '') {
                        $dec = json_decode($lcRaw, true);
                        $lcRaw = is_array($dec) ? $dec : preg_split('/[,;|]+/', $lcRaw);
                    }
                    if (is_array($lcRaw)) {
                        foreach ($lcRaw as $o) {
                            if (is_string($o) || is_numeric($o)) { $lcOcts[] = trim((string) $o); }
                        }
                    }
                }
                foreach (['azucar'=>'alto_azucar','sodio'=>'alto_sodio','grasas saturadas'=>'alto_grasas_saturadas','grasas trans'=>'alto_grasas_trans'] as $k => $col) {
                    if (!empty($item->product->{$col})) { $lcOcts[] = $k; }
                }
                $lcOcts = array_values(array_unique(array_filter($lcOcts, fn($v) => trim((string) $v) !== '')));

                // Normaliza acentos y variantes al conjunto de imágenes usado en Supermercados.
                $lcOctKeys = [];
                foreach ($lcOcts as $o) {
                    $oNorm = mb_strtolower(trim((string) $o));
                    $oNorm = strtr($oNorm, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u']);
                    if ($oNorm === '') { continue; }
                    if (str_contains($oNorm, 'azuc')) { $ok = 'azucar'; }
                    elseif (str_contains($oNorm, 'sod')) { $ok = 'sodio'; }
                    elseif (str_contains($oNorm, 'grasa') || str_contains($oNorm, 'satur') || str_contains($oNorm, 'trans')) { $ok = 'grasas'; }
                    else { continue; }
                    $lcOctKeys[$ok] = $oNorm;
                }
            @endphp
                <tr class="lc-row" id="row-{{ $item->id }}"
                    data-estado="{{ $lcEstK }}"
                    data-nombre="{{ $item->product->nombre }}"
                    data-sku="{{ $item->product->sku ?? '' }}"
                    data-lote="{{ $loteItem ?? '' }}"
                    data-venc="{{ $fechaVenc ? \Carbon\Carbon::parse($fechaVenc)->format('d/m/Y') : '' }}"
                    data-armo="{{ $lcArmoN ? mb_strtolower($lcArmoN) : '' }}"
                    data-armo-txt="{{ $lcArmoN ?? '' }}"
                    data-sub="{{ number_format((float) $lcSubt, 2, '.', '') }}"
                    data-search="{{ mb_strtolower($item->product->nombre.' '.($item->product->sku ?? '').' '.($loteItem ?? '').' '.($lcArmoN ?? '')) }}">

                    <td class="lc-num idx">{{ $loop->iteration }}</td>

                    <td>
                        <div class="lc-prod">
                            <div class="lc-thumb">@if($lcThumb)<img src="{{ $lcThumb }}" alt="" loading="lazy" onerror="this.replaceWith(document.createTextNode('📦'))">@else 📦 @endif</div>
                            <div class="lc-pname">{{ $item->product->nombre }}</div>
                        </div>
                    </td>

                    <td class="lc-num" style="color:#64748b;">{{ $item->product->sku ?? '—' }}</td>

                    <td class="c">
                        <input type="number" step="0.01"
                               class="num-input sol-in" id="sol-{{ $item->id }}"
                               value="{{ $item->cantidad_solicitada }}"
                               disabled
                               oninput="syncHidden({{ $item->id }})">
                    </td>
                    <td class="c">
                        <input type="number" step="0.01"
                               class="num-input des-in" id="des-{{ $item->id }}"
                               value="{{ $item->cantidad_despachada }}"
                               disabled
                               oninput="syncHidden({{ $item->id }})">
                    </td>
                    <td class="c lc-num" style="font-weight:800;color:{{ $lcPend > 0 ? '#f59e0b' : '#16a34a' }};">{{ $lcN($lcPend) }}</td>

                    <td>
                        <div class="lc-pg">
                            <div class="lc-bar"><div style="width:{{ min($pct,100) }}%;background:{{ $lc }};"></div></div>
                            <b style="color:{{ $pct > 0 ? ($pct >= 100 ? '#16a34a' : '#d97706') : '#dc2626' }};">{{ number_format($pct,0) }}%</b>
                        </div>
                    </td>

                    <td class="lc-num">{{ $loteItem ?: '—' }}</td>
                    <td class="lc-num" style="color:{{ $vColor }};{{ ($diasVencItem !== null && $diasVencItem < 0) ? 'font-weight:700;' : '' }}" @if($diasVencItem !== null) title="{{ $diasVencItem < 0 ? 'Vencido' : $diasVencItem.' días para vencer' }}" @endif>
                        {{ $fechaVenc ? \Carbon\Carbon::parse($fechaVenc)->format('d/m/Y') : '—' }}
                    </td>

                    <td class="c">
                        <div class="lc-octs">
                        @forelse($lcOctKeys as $okey => $oRaw)
                            @php
                                $lb = $lcOctLabel($okey);
                                $octImg = $lcOctImgs[$okey] ?? null;
                            @endphp
                            <span class="lc-octw" title="{{ trim($lb[0].' '.$lb[1]) }}">
                                @if($octImg)
                                    <img class="lc-octimg" src="{{ $octImg }}" alt="{{ trim($lb[0].' '.$lb[1]) }}" loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='inline-flex';">
                                @endif
                                <span class="lc-oct" @if($octImg) style="display:none;" @endif><span>{{ $lb[0] }}</span><span>{{ $lb[1] }}</span></span>
                            </span>
                        @empty
                            <span style="color:#94a3b8;">–</span>
                        @endforelse
                        </div>
                    </td>

                    <td class="lc-num" style="font-size:11.5px;white-space:nowrap;">{{ $lcUltD ? \Carbon\Carbon::parse($lcUltD)->format('d/m H:i') : '—' }}</td>

                    <td>
                        @if($lcArmoN)
                            <span class="lc-arm"><svg class="lc-i"><use href="#lc-user"/></svg>{{ $lcArmoN }}</span>
                        @else
                            <span style="color:#94a3b8;font-size:11.5px;">Sin registrar</span>
                        @endif
                    </td>

                    <td class="r">
                        <div class="lc-num" style="font-weight:800;color:{{ $montoColor }};white-space:nowrap;"
                             title="Precio unitario: S/ {{ number_format($item->precio_unitario,2) }}">
                            S/ {{ number_format($lcSubt,2) }}
                        </div>
                        {{-- Precio: solo visible al editar la fila --}}
                        <input type="number" step="0.01"
                               class="num-input pre-in" id="pre-{{ $item->id }}"
                               value="{{ $item->precio_unitario }}"
                               disabled
                               title="Precio unitario"
                               oninput="syncHidden({{ $item->id }})">
                    </td>

                    <td>
                        <div class="lc-acts">
                            <button type="button" class="lc-ic" title="Ver / editar lote y vencimiento"
                                    onclick="abrirModalLote({{ $item->id }}, '{{ addslashes($loteItem ?? '') }}', '{{ $fechaVenc ? \Carbon\Carbon::parse($fechaVenc)->format('Y-m-d') : '' }}')">
                                <svg class="lc-i"><use href="#lc-eye"/></svg>
                            </button>
                            <button type="button" class="lc-ic btn-edit" title="Editar cantidades y precio"
                                    onclick="editar({{ $item->id }})">
                                <svg class="lc-i"><use href="#lc-pencil"/></svg>
                            </button>
                            <button type="submit" form="form-{{ $item->id }}"
                                    class="lc-ic lc-save btn-save"
                                    id="btn-save-{{ $item->id }}"
                                    title="Guardar cambios"
                                    style="display:none;">
                                <svg class="lc-i"><use href="#lc-save"/></svg>
                            </button>
                            <a href="{{ route('orders.etiqueta.local', $item) }}" target="_blank" class="lc-ic" title="Imprimir etiqueta">
                                <svg class="lc-i"><use href="#lc-printer"/></svg>
                            </a>
                            <form method="POST"
                                  action="{{ route('orders.details.destroy',$item) }}"
                                  onsubmit="return confirm('¿Eliminar {{ addslashes($item->product->nombre) }}?')"
                                  style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="lc-ic del" title="Eliminar"><svg class="lc-i"><use href="#lc-trash"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <div class="lc-empty" id="lcVacio">Ningún producto coincide con la búsqueda o el filtro.</div>
        <div class="lc-count"><span id="lcContador">{{ $totalItems }} de {{ $totalItems }}</span> productos</div>
    </div>

    {{-- ─────────── INFORMACIÓN (antes: Resumen del pedido) ─────────── --}}
    <div class="lc-pane" data-pane="info">
        @if($completados === $totalItems && $totalItems > 0)
        <div class="alert-ok">✅ Todos los ítems completos</div>
        @else
        <div class="alert-warn">⏳ {{ $completados }} de {{ $totalItems }} ítems completos</div>
        @endif

        <div class="lc-info">
            <div class="lc-box">
                <h4>Datos del pedido</h4>
                <table class="summary-table">
                    <tr><td>Nº Orden</td><td>{{ $order->numero_orden }}</td></tr>
                    <tr><td>Tipo</td><td>LOCAL</td></tr>
                    <tr><td>Fecha</td><td>{{ \Carbon\Carbon::parse($order->fecha_pedido ?? now())->format('d M Y') }}</td></tr>
                    <tr><td>Cliente</td><td style="font-size:11px;">{{ $order->client->razon_social ?? '—' }}</td></tr>
                    <tr><td>Productos</td><td>{{ $totalItems }}</td></tr>
                    <tr><td>Factura</td><td>{{ $order->factura_asociada ?? '—' }}</td></tr>
                    <tr><td>Guía</td><td>{{ $order->guia_asociada ?? '—' }}</td></tr>
                    <tr><td>Tiempo de armado</td><td>{{ $lcTiempoArmado ?? '—' }}@if($lcTiempoArmado && $lcEnCurso) <small>(en curso)</small>@endif</td></tr>
                    <tr><td>Desde el registro</td><td>{{ $lcTiempoTotal ?? '—' }}</td></tr>
                    <tr><td>Personal</td><td style="font-size:11px;">{{ $lcPersonasN ? implode(', ', array_keys($lcPersonas)) : 'Sin registrar' }}</td></tr>
                </table>
                <div style="font-size:10.5px;color:var(--lc-muted);margin-top:8px;">El tiempo de armado va del primer al último despacho registrado; “desde el registro” incluye la espera previa.</div>
            </div>
            <div class="lc-box">
                <h4>Importes</h4>
                <table class="summary-table">
                    <tr><td>Subtotal</td><td>S/ {{ number_format($order->subtotal,2) }}</td></tr>
                    <tr><td>IGV (18%)</td><td>S/ {{ number_format($order->igv,2) }}</td></tr>
                    <tr class="total-row"><td>TOTAL</td><td>S/ {{ number_format($order->total,2) }}</td></tr>
                </table>

                <hr class="dv">

                <div style="font-size:10px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">Estado de ítems</div>
                <div class="status-row"><span>🟢 Completo</span><span style="font-weight:700;color:#15803d;">{{ $completados }}</span></div>
                <div class="status-row"><span>🟡 Parcial</span><span style="font-weight:700;color:#b45309;">{{ $parciales }}</span></div>
                <div class="status-row"><span>🔴 Pendiente</span><span style="font-weight:700;color:#b91c1c;">{{ $pendientes }}</span></div>
            </div>
        </div>
    </div>

    {{-- ─────────── OBSERVACIONES ─────────── --}}
    <div class="lc-pane" data-pane="obs">
        <div class="lc-box">
            <h4>Observaciones del pedido</h4>
            <div class="lc-obs-txt">{{ $lcObs ?: 'Sin observaciones registradas.' }}</div>
        </div>
    </div>

    {{-- ─────────── HISTORIAL ─────────── --}}
    <div class="lc-pane" data-pane="hist">
        @forelse($lcEventos as $ev)
            <div class="lc-ev">
                <div class="lc-ev-ic">{{ $ev['i'] }}</div>
                <div>
                    <b>{{ $ev['t'] }}</b>
                    @if($ev['d'] !== '')<span>{{ $ev['d'] }}</span>@endif
                </div>
                <time>{{ $ev['f']->format('d/m/Y H:i') }}</time>
            </div>
        @empty
            <div style="text-align:center;color:#94a3b8;padding:24px;">Aún no hay movimientos registrados.</div>
        @endforelse
        <div style="margin-top:8px;font-size:11px;color:var(--lc-muted);">El historial se arma con las fechas de registro del pedido y sus líneas.</div>
    </div>
    {{-- ─────────── DOCUMENTOS ─────────── --}}
    <div class="lc-pane" data-pane="docs">
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="lc-btn green"><svg class="lc-i"><use href="#lc-file"/></svg> PDF del pedido</a>
            @if($order->tipo_orden === 'LOCAL')
            <a href="{{ route('orders.cartaCalidad', $order) }}" target="_blank" class="lc-btn purple">🏅 Carta de calidad</a>
            @endif
            <button type="button" class="lc-btn white" onclick="lcPicking()"><svg class="lc-i"><use href="#lc-printer"/></svg> Hoja de picking</button>
        </div>
    </div>
</div>

{{-- ══════════ LÍNEA DE ESTADO ══════════ --}}
<div class="lc-card" style="padding:6px 10px;margin-bottom:12px;">
    <div class="lc-steps">
        @foreach($lcSteps as $k => $st)
            <div class="lc-step {{ $st[1] ? 'done' : '' }} {{ $k === $lcCur ? 'cur' : '' }}">
                <div class="dot">@if($st[1])<svg class="lc-i"><use href="#lc-check"/></svg>@endif</div>
                <b>{{ $st[0] }}</b>
                <small>{{ $st[1] ? $lcFechaHora($st[2]) : '' }}</small>
            </div>
        @endforeach
    </div>
</div>

{{-- ══════════ ACCIONES ══════════ --}}
<div class="lc-actions">
    <button type="button" class="lc-btn white" onclick="lcPicking()"><svg class="lc-i"><use href="#lc-printer"/></svg> Imprimir picking</button>

    @if($lcRutaGuia)
        <a href="{{ $lcRutaGuia }}" class="lc-btn white"><svg class="lc-i"><use href="#lc-truck"/></svg> Generar guía</a>
    @else
        <button type="button" class="lc-btn white is-off" disabled title="Ruta de guía sin configurar"><svg class="lc-i"><use href="#lc-truck"/></svg> Generar guía</button>
    @endif

    @if($lcRutaListo)
        <form method="POST" action="{{ $lcRutaListo }}" style="display:inline;"
              onsubmit="return confirm('¿Marcar el pedido {{ $order->numero_orden }} como listo para despacho?')">
            @csrf
            <button type="submit" class="lc-btn green big"><svg class="lc-i"><use href="#lc-check"/></svg> Marcar como listo para despacho</button>
        </form>
    @else
        <button type="button" class="lc-btn green big is-off" disabled title="Ruta de “listo para despacho” sin configurar"><svg class="lc-i"><use href="#lc-check"/></svg> Marcar como listo para despacho</button>
    @endif
</div>

{{-- Formularios de actualización por línea (mismos ids; los inputs usan form="form-X") --}}
<div style="display:none;">
@foreach($order->details as $item)
    <form method="POST"
          action="{{ route('orders.updateDetail',$item) }}"
          id="form-{{ $item->id }}"
          style="display:none;">
        @csrf @method('PUT')
        <input type="hidden" name="cantidad_solicitada" id="hid-sol-{{ $item->id }}" value="{{ $item->cantidad_solicitada }}">
        <input type="hidden" name="cantidad_despachada" id="hid-des-{{ $item->id }}" value="{{ $item->cantidad_despachada }}">
        <input type="hidden" name="precio_unitario"     id="hid-pre-{{ $item->id }}" value="{{ $item->precio_unitario }}">
    </form>
@endforeach
</div>

</div>{{-- /.lc --}}

{{-- ── Modal cámara ── --}}
<div id="modalCamara" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;flex-direction:column;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#0f172a;border:1px solid #334155;border-radius:8px;width:100%;max-width:420px;overflow:hidden;">
        <div style="background:#1e293b;padding:.75rem 1rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #334155;">
            <div style="display:flex;align-items:center;gap:8px;">
                <div class="scan-led"></div>
                <span style="color:#7eb8f7;font-size:13px;font-weight:600;">Escáner de cámara</span>
            </div>
            <button onclick="cerrarCamara()" style="background:none;border:none;color:#94a3b8;font-size:20px;cursor:pointer;line-height:1;padding:2px 6px;">✕</button>
        </div>
        <div style="position:relative;background:#000;">
            <video id="videoEscan" style="width:100%;display:block;max-height:300px;object-fit:cover;" autoplay playsinline muted></video>
            <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
                <div style="width:220px;height:110px;border:2px solid #22c55e;border-radius:6px;box-shadow:0 0 0 9999px rgba(0,0,0,.45);position:relative;">
                    <span style="position:absolute;top:-2px;left:-2px;width:18px;height:18px;border-top:3px solid #22c55e;border-left:3px solid #22c55e;border-radius:3px 0 0 0;"></span>
                    <span style="position:absolute;top:-2px;right:-2px;width:18px;height:18px;border-top:3px solid #22c55e;border-right:3px solid #22c55e;border-radius:0 3px 0 0;"></span>
                    <span style="position:absolute;bottom:-2px;left:-2px;width:18px;height:18px;border-bottom:3px solid #22c55e;border-left:3px solid #22c55e;border-radius:0 0 0 3px;"></span>
                    <span style="position:absolute;bottom:-2px;right:-2px;width:18px;height:18px;border-bottom:3px solid #22c55e;border-right:3px solid #22c55e;border-radius:0 0 3px 0;"></span>
                    <div style="position:absolute;left:0;right:0;height:2px;background:#22c55e;box-shadow:0 0 8px #22c55e;animation:scanAnim 2s ease-in-out infinite;top:0;"></div>
                </div>
            </div>
        </div>
        <div style="padding:.75rem 1rem;border-top:1px solid #334155;">
            <div id="scanResultado" style="font-size:12px;color:#94a3b8;text-align:center;min-height:24px;">
                Apunta la cámara al código de barras
            </div>
            <select id="selectCamara" style="display:none;width:100%;margin-top:8px;padding:6px 8px;background:#1e293b;border:1px solid #334155;color:#c8daf0;border-radius:4px;font-size:12px;"></select>
        </div>
    </div>
</div>

{{-- ── Modal editar lote / vencimiento ── --}}
<div id="modalLote" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <span>🏷️ Editar lote y vencimiento</span>
            <button type="button" onclick="cerrarModalLote()">✕</button>
        </div>
        <div class="modal-body">
            <div class="modal-warn">
                ⚠️ <strong>Esta edición solo debe hacerse en casos extraordinarios.</strong>
                Si la fecha no coincide con el producto, ve a registrarla correctamente en la vista
                <strong>Productos</strong> para mantener la información actualizada.
            </div>
            <form id="formLote" method="POST" action="">
                @csrf
                @method('PUT')
                <label class="flabel">Lote</label>
                <input type="text" name="lote" id="loteInput" class="finput" style="margin-bottom:10px;" maxlength="100" placeholder="Ej: L-2026-045">

                <label class="flabel">Fecha de vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fechaVencInput" class="finput" style="margin-bottom:14px;">

                <div style="display:flex;gap:8px;justify-content:flex-end;">
                    <button type="button" class="btn-xs btn-cancel" onclick="cerrarModalLote()">Cancelar</button>
                    <button type="submit" class="btn-xs btn-save">💾 Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>{{-- fin pg --}}

{{-- ZXing CDN --}}
<script src="https://unpkg.com/@zxing/library@0.19.1/umd/index.min.js"></script>

<script>
/* ============================================================
   ÚNICA definición de todas las funciones — sin duplicados
============================================================ */

/* ── Sync inputs visibles → hidden del form ── */
function syncHidden(id) {
    var sol = document.getElementById('sol-' + id);
    var des = document.getElementById('des-' + id);
    var pre = document.getElementById('pre-' + id);
    if(sol) document.getElementById('hid-sol-' + id).value = sol.value;
    if(des) document.getElementById('hid-des-' + id).value = des.value;
    if(pre) document.getElementById('hid-pre-' + id).value = pre.value;
}

/* ── Editar fila ── */
function editar(id) {
    document.getElementById('sol-' + id).disabled = false;
    document.getElementById('des-' + id).disabled = false;
    document.getElementById('pre-' + id).disabled = false;
    document.getElementById('btn-save-' + id).style.display = 'inline-flex';
    var des = document.getElementById('des-' + id);
    des.focus();
    des.select();
}

/* ── Modal lote / vencimiento ── */
function abrirModalLote(id, lote, fecha) {
    document.getElementById('formLote').action = '/order-details/' + id + '/lote';
    document.getElementById('loteInput').value = lote || '';
    document.getElementById('fechaVencInput').value = fecha || '';
    document.getElementById('modalLote').style.display = 'flex';
}
function cerrarModalLote() {
    document.getElementById('modalLote').style.display = 'none';
}
document.getElementById('modalLote').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalLote();
});

/* ── Scanner (teclado / lector físico) ── */
document.getElementById('scanner').addEventListener('keypress', function(e) {
    if (e.key !== 'Enter') return;
    e.preventDefault();
    var codigo = this.value.trim();
    if (!codigo) return;

    fetch('/buscar-producto/' + codigo)
        .then(function(res){ return res.json(); })
        .then(function(data) {
            if (!data) { alert('❌ Producto no encontrado'); return; }
            var sel = document.querySelector('select[name="product_id"]');
            if (sel) {
                for (var o of sel.options) {
                    if (o.value == data.id) { sel.value = data.id; break; }
                }
            }
            var precioInput = document.querySelector('input[name="precio_unitario"]');
            if (precioInput && data.precio) precioInput.value = data.precio;
            var cantInput = document.querySelector('input[name="cantidad_solicitada"]');
            if (cantInput) { cantInput.focus(); cantInput.select(); }
        })
        .catch(function() {
            console.warn('Error buscando producto');
        });

    this.value = '';
});

/* ── Cámara ZXing ── */
var codeReader  = null;
var streamActual = null;

function abrirCamara() {
    document.getElementById('modalCamara').style.display = 'flex';
    iniciarEscaneo();
}

function cerrarCamara() {
    document.getElementById('modalCamara').style.display = 'none';
    detenerStream();
}

function detenerStream() {
    if (codeReader) { codeReader.reset(); codeReader = null; }
    if (streamActual) { streamActual.getTracks().forEach(function(t){ t.stop(); }); streamActual = null; }
    var video = document.getElementById('videoEscan');
    if (video) video.srcObject = null;
}

function iniciarEscaneo() {
    var resultado = document.getElementById('scanResultado');
    var selectCam = document.getElementById('selectCamara');

    if (typeof ZXing === 'undefined') {
        resultado.innerHTML = '<span style="color:#ef4444;">Error: librería no cargada</span>';
        return;
    }

    codeReader = new ZXing.BrowserMultiFormatReader();
    resultado.textContent = 'Iniciando cámara...';

    codeReader.listVideoInputDevices().then(function(devices) {
        if (!devices || devices.length === 0) {
            resultado.innerHTML = '<span style="color:#ef4444;">No se encontró cámara</span>';
            return;
        }
        if (devices.length > 1) {
            selectCam.style.display = 'block';
            selectCam.innerHTML = '';
            devices.forEach(function(d, i) {
                var opt = document.createElement('option');
                opt.value = d.deviceId;
                opt.textContent = d.label || ('Cámara ' + (i + 1));
                if (d.label && d.label.toLowerCase().includes('back')) opt.selected = true;
                selectCam.appendChild(opt);
            });
            selectCam.onchange = function() {
                codeReader.reset();
                empezarConDispositivo(this.value);
            };
            empezarConDispositivo(selectCam.value);
        } else {
            empezarConDispositivo(devices[0].deviceId);
        }
    }).catch(function(err) {
        resultado.innerHTML = '<span style="color:#ef4444;">Sin permiso de cámara</span>';
        console.error(err);
    });
}

function empezarConDispositivo(deviceId) {
    var video     = document.getElementById('videoEscan');
    var resultado = document.getElementById('scanResultado');
    resultado.textContent = 'Apunta la cámara al código de barras';

    codeReader.decodeFromVideoDevice(deviceId, video, function(result, err) {
        if (result) {
            var codigo = result.getText();
            resultado.innerHTML = '✅ <strong style="color:#22c55e;">' + codigo + '</strong>';
            if (navigator.vibrate) navigator.vibrate(120);
            cerrarCamara();

            var inputScanner = document.getElementById('scanner');
            inputScanner.value = codigo;
            inputScanner.dispatchEvent(new KeyboardEvent('keypress', {
                key:'Enter', code:'Enter', keyCode:13, which:13, bubbles:true
            }));
        }
        if (err && !(err instanceof ZXing.NotFoundException)) {
            console.warn(err);
        }
    });
}

/* Cerrar modal al tocar fuera */
document.getElementById('modalCamara').addEventListener('click', function(e) {
    if (e.target === this) cerrarCamara();
});
</script>

<script>
// ══════════════════════════════════════════════════════════
//  PEDIDO LOCAL · interacciones del rediseño (aditivo)
//  No modifica syncHidden / editar / scanner / cámara / modal de lote.
// ══════════════════════════════════════════════════════════
var LC_TOTAL = {{ $totalItems }};
var LC_ORDEN = {{ Js::from($order->numero_orden) }};
var LC_CLIENTE = {{ Js::from($order->client->razon_social ?? '—') }};

/* ── Pestañas ── */
function lcTab(name, btn) {
    document.querySelectorAll('.lc-pane').forEach(function (p) { p.classList.toggle('on', p.dataset.pane === name); });
    document.querySelectorAll('.lc-tab').forEach(function (b) { b.classList.toggle('on', b === btn); });
}

/* ── Búsqueda + filtro por estado (solo oculta/muestra filas) ── */
function lcFiltrar() {
    var q = (document.getElementById('lcBuscar').value || '').trim().toLowerCase();
    var est = document.getElementById('lcEstado').value;
    var n = 0;
    document.querySelectorAll('#lcTabla tr.lc-row').forEach(function (tr) {
        var arm = (document.getElementById('lcArmoSel') || {}).value || '';
        var okArm = !arm || (arm === '__sin__' ? !tr.dataset.armo : tr.dataset.armo === arm);
        var ok = (!q || (tr.dataset.search || '').indexOf(q) !== -1) && (!est || tr.dataset.estado === est) && okArm;
        tr.style.display = ok ? '' : 'none';
        if (ok) n++;
    });
    document.getElementById('lcVacio').style.display = n ? 'none' : 'block';
    document.getElementById('lcContador').textContent = n + ' de ' + LC_TOTAL;
}

/* ── Imprimir picking (ventana de impresión con los valores actuales) ── */
function lcEsc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[c]; }); }
function lcPicking() {
    var w = window.open('', '_blank');
    if (!w) { alert('Permite las ventanas emergentes para imprimir.'); return; }
    var filas = '', i = 0;
    document.querySelectorAll('#lcTabla tr.lc-row').forEach(function (tr) {
        var id = tr.id.replace('row-', '');
        var sol = parseFloat((document.getElementById('sol-' + id) || {}).value) || 0;
        var des = parseFloat((document.getElementById('des-' + id) || {}).value) || 0;
        var pend = Math.max(sol - des, 0);
        i++;
        filas += '<tr><td>' + i + '</td><td>' + lcEsc(tr.dataset.sku) + '</td><td>' + lcEsc(tr.dataset.nombre) +
                 '</td><td>' + lcEsc(tr.dataset.lote || '—') + '</td><td class="n">' + sol + '</td><td class="n">' + des +
                 '</td><td class="n">' + pend + '</td><td>' + lcEsc(tr.dataset.armoTxt || '') + '</td><td class="chk"></td></tr>';
    });
    var css = 'body{font-family:Arial,Helvetica,sans-serif;margin:18px;color:#0f172a}h1{font-size:20px;margin:0 0 4px}' +
              '.s{font-size:13px;color:#475569;margin-bottom:14px}table{width:100%;border-collapse:collapse;font-size:12px}' +
              'th,td{border:1px solid #94a3b8;padding:6px 8px;text-align:left}th{background:#e2e8f0}.n{text-align:right;font-family:monospace}' +
              '.chk{width:50px}@page{size:A4;margin:10mm}';
    w.document.write('<!doctype html><html><head><meta charset="utf-8"><title>Picking ' + lcEsc(LC_ORDEN) + '</title><style>' + css +
        '</style></head><body><h1>Picking · ' + lcEsc(LC_ORDEN) + '</h1><div class="s">Cliente: ' + lcEsc(LC_CLIENTE) +
        ' · ' + new Date().toLocaleString('es-PE') + '</div><table><thead><tr><th>#</th><th>SKU</th><th>Producto</th><th>Lote</th>' +
        '<th>Pedido</th><th>Preparado</th><th>Pendiente</th><th>Armó</th><th>✓</th></tr></thead><tbody>' + filas + '</tbody></table></body></html>');
    w.document.close();
    w.focus();
    setTimeout(function () { w.print(); }, 350);
}


/* ── Dropdowns (Filtros / Acciones) ── */
function lcDD(id, ev) {
    ev.stopPropagation();
    document.querySelectorAll('.lc-dd.open').forEach(function (d) { if (d.id !== id) d.classList.remove('open'); });
    var el = document.getElementById(id);
    el.classList.toggle('open');
}
document.addEventListener('click', function () {
    document.querySelectorAll('.lc-dd.open').forEach(function (d) { d.classList.remove('open'); });
});

/* ── Limpiar filtros ── */
function lcLimpiar() {
    document.getElementById('lcBuscar').value = '';
    document.getElementById('lcEstado').value = '';
    var a = document.getElementById('lcArmoSel'); if (a) a.value = '';
    lcFiltrar();
}

/* ── Exportar CSV (valores actuales de la tabla) ── */
function lcExportCSV() {
    var head = ['SKU', 'Producto', 'Solicitado', 'Despachado', 'Pendiente', 'Lote', 'Vencimiento', 'Armó', 'Subtotal'];
    var esc = function (v) { return '"' + String(v == null ? '' : v).replace(/"/g, '""') + '"'; };
    var rows = [];
    document.querySelectorAll('#lcTabla tr.lc-row').forEach(function (tr) {
        var id = tr.id.replace('row-', '');
        var sol = parseFloat((document.getElementById('sol-' + id) || {}).value) || 0;
        var des = parseFloat((document.getElementById('des-' + id) || {}).value) || 0;
        rows.push([tr.dataset.sku, tr.dataset.nombre, sol, des, Math.max(sol - des, 0), tr.dataset.lote, tr.dataset.venc,
                   tr.dataset.armoTxt, tr.dataset.sub]);
    });
    var csv = [head].concat(rows).map(function (r) { return r.map(esc).join(','); }).join('\r\n');
    var blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'pedido-' + LC_ORDEN + '.csv';
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(function () { URL.revokeObjectURL(a.href); }, 1000);
}

/* ── Scanner: abre el panel "Agregar producto" antes del handler original ──
   (el handler original rellena producto/precio y enfoca la cantidad; el panel debe estar visible) */
(function () {
    var sc = document.getElementById('scanner');
    if (!sc) return;
    sc.addEventListener('keypress', function (e) {
        if (e.key !== 'Enter') return;
        if ((this.value || '').trim() === '') return;
        document.getElementById('lcAddBox').classList.add('open');
    }, true);
})();
</script>


<script>
(function(){
  var normalize=function(v){return (v||'').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');};
  var loader=document.getElementById('erpViewLoader');
  var hideLoader=function(){if(loader)loader.classList.add('is-hidden');};
  var showLoader=function(){if(loader)loader.classList.remove('is-hidden');};
  (function(){var href=@json($erpFavicon);var link=document.querySelector('link[rel~="icon"]');if(!link){link=document.createElement('link');link.rel='icon';document.head.appendChild(link);}if(href.indexOf('data:image/svg+xml')===0)link.type='image/svg+xml';link.href=href;})();
  if(document.readyState==='complete'){setTimeout(hideLoader,250);}else{window.addEventListener('load',function(){setTimeout(hideLoader,250);});setTimeout(hideLoader,5000);}
  window.addEventListener('pageshow',function(e){if(e.persisted)hideLoader();});
  document.addEventListener('submit',function(e){if(e.target.matches('form.distan-loader-form'))showLoader();});
  document.addEventListener('click',function(e){var a=e.target.closest('a');if(a&&a.href&&!a.target&&a.origin===location.origin&&!e.ctrlKey&&!e.metaKey&&!e.shiftKey)showLoader();});
  document.querySelectorAll('[data-erp-product-combo]').forEach(function(combo){
    var select=combo.querySelector('[data-erp-product-select]'),trigger=combo.querySelector('.erp-product-trigger'),label=trigger.querySelector('span'),panel=combo.querySelector('.erp-product-panel'),search=combo.querySelector('.erp-product-search'),list=combo.querySelector('.erp-product-options'),active=-1;
    if(!select)return;
    function render(){var q=normalize(search.value),items=Array.prototype.slice.call(select.options).filter(function(o){return o.value&&normalize(o.textContent).includes(q);});list.innerHTML='';active=-1;
      if(!items.length){var empty=document.createElement('li');empty.className='erp-product-empty';empty.textContent='No se encontraron productos';list.appendChild(empty);return;}
      items.forEach(function(o){var li=document.createElement('li');li.textContent=o.textContent;li.dataset.value=o.value;if(o.value===select.value)li.classList.add('is-selected');li.addEventListener('mousedown',function(ev){ev.preventDefault();select.value=o.value;select.dispatchEvent(new Event('change',{bubbles:true}));updateLabel();close();});list.appendChild(li);});
    }
    function updateLabel(){var opt=select.options[select.selectedIndex];if(opt&&opt.value){label.textContent=opt.textContent;label.classList.remove('erp-placeholder');}else{label.textContent='Buscar producto...';label.classList.add('erp-placeholder');}}
    function open(){document.querySelectorAll('.erp-product-panel').forEach(function(p){if(p!==panel)p.hidden=true;});panel.hidden=false;trigger.setAttribute('aria-expanded','true');search.value='';render();search.focus();}
    function close(){panel.hidden=true;trigger.setAttribute('aria-expanded','false');trigger.focus();}
    trigger.addEventListener('click',function(){panel.hidden?open():close();});search.addEventListener('input',render);
    search.addEventListener('keydown',function(e){var rows=list.querySelectorAll('li[data-value]');if(e.key==='Escape'){close();return;}if(e.key==='ArrowDown'){e.preventDefault();active=Math.min(active+1,rows.length-1);}else if(e.key==='ArrowUp'){e.preventDefault();active=Math.max(active-1,0);}else if(e.key==='Enter'&&rows.length){e.preventDefault();(rows[active>=0?active:0]).dispatchEvent(new MouseEvent('mousedown',{bubbles:true}));return;}rows.forEach(function(li,i){li.classList.toggle('is-active',i===active);});if(rows[active])rows[active].scrollIntoView({block:'nearest'});});
    select.addEventListener('change',updateLabel);document.addEventListener('click',function(e){if(!combo.contains(e.target)&&!panel.hidden)close();});updateLabel();
  });
})();
</script>

@endsection
