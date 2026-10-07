
<style id="operario-responsive-fix">
html, body {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
    -webkit-text-size-adjust: 100%;
}
*, *::before, *::after {
    box-sizing: border-box;
}
.pg {
    width: 100%;
    max-width: 100%;
}
@media (max-width: 900px) {
    .pg {
        padding: 10px !important;
    }
    .prod-list,
    .sec-card,
    .activo-box,
    .order-header,
    .kpi-grid {
        width: 100% !important;
        max-width: 100% !important;
    }
    .prod-item {
        min-width: 0 !important;
    }
    .prod-item-top {
        gap: 8px;
        flex-wrap: wrap;
    }
}
@media (max-width: 640px) {
    .pg {
        padding: 8px !important;
    }
    .activo-fields {
        grid-template-columns: 1fr !important;
    }
    .kpi-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
    .prod-item {
        padding: 10px !important;
    }
    .prod-item-name {
        font-size: 13px !important;
        word-break: break-word;
    }
    #camaraModal {
        padding: 8px !important;
    }
    #camaraModal > div {
        width: 100% !important;
        max-height: 96vh !important;
        border-radius: 12px !important;
    }
}
</style>

@extends('layouts.app')

@section('content')

<style>
:root{
    --erp-primary:#2563eb;
    --erp-primary-dark:#1d4ed8;
    --erp-primary-soft:#eff6ff;
    --erp-bg:#f5f7fb;
    --erp-card:#ffffff;
    --erp-border:#e2e8f0;
    --erp-text:#172033;
    --erp-muted:#64748b;
    --erp-green:#16a34a;
    --erp-green-soft:#ecfdf3;
    --erp-yellow:#f59e0b;
    --erp-yellow-soft:#fffbeb;
    --erp-red:#dc2626;
    --erp-red-soft:#fef2f2;
    --erp-shadow:0 8px 24px rgba(15,23,42,.06);
    --erp-radius:14px;
}
*{box-sizing:border-box;}
html,body{margin:0;background:var(--erp-bg);color:var(--erp-text);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;}
body{overflow-x:hidden;}
.erp-shell{min-height:100vh;background:var(--erp-bg);display:flex;}
.erp-sidebar{width:224px;flex:0 0 224px;background:#fff;border-right:1px solid var(--erp-border);min-height:100vh;position:sticky;top:0;height:100vh;z-index:20;display:flex;flex-direction:column;}
.erp-brand{height:68px;display:flex;align-items:center;gap:10px;padding:0 20px;border-bottom:1px solid #eef2f7;}
.erp-brand-mark{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#60a5fa);color:#fff;display:grid;place-items:center;font-size:18px;box-shadow:0 5px 14px rgba(37,99,235,.22);}
.erp-brand-text{font-weight:800;font-size:20px;letter-spacing:-.03em;color:#123b7a;}
.erp-brand-text span{font-weight:500;color:#64748b;font-size:11px;display:block;letter-spacing:.04em;margin-top:-3px;}
.erp-nav{padding:14px 10px;display:flex;flex-direction:column;gap:4px;}
.erp-nav-item{display:flex;align-items:center;gap:11px;padding:11px 12px;border-radius:9px;color:#475569;text-decoration:none;font-size:13px;font-weight:600;}
.erp-nav-item:hover{background:#f8fafc;color:#1e3a8a;}
.erp-nav-item.active{background:#eaf2ff;color:var(--erp-primary);box-shadow:inset 3px 0 0 var(--erp-primary);}
.erp-nav-icon{width:24px;text-align:center;font-size:16px;}
.erp-sidebar-foot{margin-top:auto;padding:14px;border-top:1px solid #eef2f7;color:#94a3b8;font-size:10px;}
.erp-main{min-width:0;flex:1;}
.erp-topbar{height:68px;background:#fff;border-bottom:1px solid var(--erp-border);display:flex;align-items:center;justify-content:space-between;padding:0 26px;position:sticky;top:0;z-index:15;}
.erp-crumb{font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:8px;}
.erp-crumb strong{color:#334155;}
.erp-user{display:flex;align-items:center;gap:10px;font-size:12px;font-weight:700;color:#334155;}
.erp-user-avatar{width:34px;height:34px;border-radius:50%;background:#eaf2ff;color:var(--erp-primary);display:grid;place-items:center;font-size:16px;}
.pg{width:100%;max-width:1180px;margin:0 auto;padding:24px 26px 34px;background:transparent;min-height:calc(100vh - 68px);}
.page-title{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:18px;}
.page-title-left{display:flex;gap:12px;align-items:flex-start;}
.page-title-icon{width:44px;height:44px;border-radius:12px;background:var(--erp-primary-soft);color:var(--erp-primary);display:grid;place-items:center;font-size:23px;flex:0 0 auto;}
.page-title h1{margin:0;font-size:24px;line-height:1.1;letter-spacing:-.03em;color:#13213b;}
.page-title p{margin:5px 0 0;color:var(--erp-muted);font-size:12px;}
.order-summary{background:#fff;border:1px solid var(--erp-border);border-radius:var(--erp-radius);box-shadow:var(--erp-shadow);padding:16px;display:grid;grid-template-columns:minmax(260px,1.35fr) repeat(4,minmax(110px,1fr));gap:0;align-items:stretch;margin-bottom:16px;}
.order-summary-main{padding:3px 18px 3px 2px;border-right:1px solid #edf1f5;}
.order-number{display:flex;align-items:center;gap:8px;font-size:18px;font-weight:800;color:#14213d;}
.order-client{margin-top:5px;font-size:12px;color:#475569;font-weight:600;}
.order-meta{display:flex;flex-wrap:wrap;gap:7px;margin-top:10px;}
.meta-pill{display:inline-flex;align-items:center;gap:5px;border-radius:99px;padding:5px 9px;font-size:10px;font-weight:700;background:#f8fafc;color:#475569;border:1px solid #e2e8f0;}
.meta-pill.blue{background:#eff6ff;color:#1d4ed8;border-color:#dbeafe;}
.meta-pill.green{background:#ecfdf3;color:#15803d;border-color:#bbf7d0;}
.badge-estado{padding:5px 10px;border-radius:99px;font-size:10px;font-weight:800;color:#fff;}
.summary-kpi{padding:3px 15px;border-right:1px solid #edf1f5;display:flex;align-items:center;gap:9px;}
.summary-kpi:last-child{border-right:0;}
.kpi-icon{width:34px;height:34px;border-radius:10px;display:grid;place-items:center;font-size:16px;flex:0 0 auto;background:#f8fafc;}
.kpi-val{font-size:19px;font-weight:800;line-height:1;color:#172033;}
.kpi-label{font-size:10px;color:#64748b;margin-top:3px;white-space:nowrap;}
.kpi-blue .kpi-icon{background:#eff6ff;color:#2563eb}.kpi-green .kpi-icon{background:#ecfdf3;color:#16a34a}.kpi-yellow .kpi-icon{background:#fffbeb;color:#d97706}.kpi-red .kpi-icon{background:#fef2f2;color:#dc2626}
.progress-kpi{min-width:0;}
.progress-ring-mini{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:conic-gradient(var(--erp-primary) 66%,#e5e7eb 0);position:relative;flex:0 0 auto;}
.progress-ring-mini:after{content:"";position:absolute;inset:5px;background:#fff;border-radius:50%;}
.progress-ring-mini span{position:relative;z-index:1;font-size:8px;font-weight:800;color:#1d4ed8;}
.prog-card{background:#fff;border:1px solid var(--erp-border);border-radius:var(--erp-radius);padding:15px 17px;margin-bottom:16px;box-shadow:var(--erp-shadow);}
.prog-top{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:8px;}
.prog-pct{font-size:28px;font-weight:850;line-height:1;color:var(--erp-primary)!important;}
.prog-track{width:100%;height:10px;background:#e9eef5;border-radius:99px;overflow:hidden;margin-bottom:7px;}
.prog-fill{height:100%;border-radius:99px;transition:width .5s ease;background:var(--erp-primary)!important;}
.prog-labels{display:flex;justify-content:space-between;font-size:10px;color:#94a3b8;}
.kpis{display:none;}
.workflow-grid{display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:16px;align-items:start;}
.workflow-main{min-width:0;}
.scanner-wrap{background:#fff;border:1px solid var(--erp-border);border-radius:var(--erp-radius);padding:15px 16px;margin-bottom:16px;box-shadow:var(--erp-shadow);}
.scanner-top{display:flex;align-items:center;gap:9px;margin-bottom:9px;}
.scanner-pulse{width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;box-shadow:0 0 0 4px #dcfce7;animation:pulse 1.4s infinite;}
.scanner-label{font-size:12px;color:#334155;font-weight:800;}
.scanner-input-row{display:flex;gap:10px;align-items:stretch;}
.scanner-input{width:100%;padding:13px 15px;font-size:16px;border-radius:10px;border:1px solid #cbd5e1;background:#fff;color:#172033;outline:none;letter-spacing:1px;transition:border-color .2s,box-shadow .2s;}
.scanner-input:focus{border-color:#60a5fa;box-shadow:0 0 0 4px rgba(37,99,235,.10);}
.scanner-input::placeholder{color:#94a3b8;font-size:13px;letter-spacing:0;}
.scanner-hint{font-size:10px;color:#94a3b8;margin-top:7px;display:flex;align-items:center;gap:4px;}
.camera-btn{flex:0 0 auto;background:var(--erp-primary);color:#fff;border:none;border-radius:10px;padding:0 18px;font-size:12px;font-weight:800;cursor:pointer;box-shadow:0 5px 14px rgba(37,99,235,.18);}
.camera-btn:hover{background:var(--erp-primary-dark);}
.ready-card{background:#fff;border:1px dashed #cbd5e1;border-radius:var(--erp-radius);padding:28px 20px;text-align:center;margin-bottom:16px;box-shadow:var(--erp-shadow);}
.ready-cart{width:68px;height:68px;margin:0 auto 10px;border-radius:20px;background:#eff6ff;color:#2563eb;display:grid;place-items:center;font-size:34px;animation:cartFloat 2.2s ease-in-out infinite;}
.ready-title{font-size:15px;font-weight:800;color:#1e293b;}
.ready-text{font-size:11px;color:#94a3b8;margin-top:4px;}
@keyframes cartFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
.activo-box{background:#fff;border:1px solid #bfdbfe;border-top:3px solid var(--erp-primary);border-radius:var(--erp-radius);padding:18px;margin-bottom:16px;display:none;box-shadow:0 10px 30px rgba(37,99,235,.08);}
.activo-head{display:flex;align-items:flex-start;gap:13px;margin-bottom:15px;}
.activo-product-icon{width:62px;height:62px;border-radius:12px;background:#f1f5f9;color:#64748b;display:grid;place-items:center;font-size:28px;flex:0 0 auto;}
.activo-name{font-size:19px;font-weight:800;color:#172033;margin-bottom:4px;}
.activo-meta{font-size:11px;color:#64748b;margin-bottom:0;display:flex;gap:12px;flex-wrap:wrap;}
.activo-meta strong{color:#334155!important;}
.activo-fields{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;}
.activo-label{font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:5px;font-weight:800;}
.activo-input{width:100%;padding:10px 12px;border-radius:9px;border:1px solid #cbd5e1;background:#fff;color:#172033;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;}
.activo-input:focus{border-color:#60a5fa;box-shadow:0 0 0 3px rgba(37,99,235,.08);}
.activo-input.big{font-size:21px;font-weight:800;text-align:center;padding:10px;background:#f8fbff;}
.active-extra-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;}
.active-actions{display:flex;gap:9px;margin-top:12px;}
.active-save-btn{flex:1;background:var(--erp-primary);color:#fff;border:0;border-radius:9px;padding:12px;font-size:13px;font-weight:800;cursor:pointer;}
.active-clear-btn{background:#fff;color:#475569;border:1px solid #cbd5e1;border-radius:9px;padding:12px 16px;font-weight:700;cursor:pointer;}
.activo-bar-track{width:100%;height:8px;background:#e8eef6;border-radius:99px;overflow:hidden;margin:.5rem 0;}
.sec-title{font-size:13px;font-weight:800;color:#1e293b;margin:2px 0 9px;display:flex;align-items:center;gap:6px;}
.prod-list{display:flex;flex-direction:column;gap:8px;}
.prod-item{background:#fff;border:1px solid var(--erp-border);border-left:4px solid;border-radius:11px;padding:12px 13px;transition:box-shadow .15s,transform .15s;box-shadow:0 3px 12px rgba(15,23,42,.035);}
.prod-item:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(15,23,42,.06);}
.prod-item-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:7px;gap:10px;}
.prod-item-name{font-size:13px;font-weight:800;color:#1e293b;}
.prod-item-sku{font-size:10px;color:#94a3b8;margin-top:2px;}
.prod-item-badge{font-size:9px;padding:4px 8px;border-radius:99px;font-weight:800;white-space:nowrap;}
.bc{background:var(--erp-green-soft);color:#15803d;border:1px solid #bbf7d0}.bp{background:var(--erp-yellow-soft);color:#b45309;border:1px solid #fde68a}.bi{background:var(--erp-red-soft);color:#b91c1c;border:1px solid #fecaca}
.prod-item-meta{display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#64748b;margin-bottom:7px;gap:8px;}
.prod-item-meta strong{color:#334155!important;}
.prod-mini-bar{width:100%;height:5px;background:#e8eef6;border-radius:99px;overflow:hidden;}
.prod-mini-fill{height:100%;border-radius:99px;transition:width .4s;}
.item-detail-box{margin-top:8px;padding:9px 10px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:9px;font-size:10px;color:#64748b;}
.item-detail-box strong{color:#334155!important;}
.item-edit-btn{margin-top:7px;width:100%;background:#fff;color:#2563eb;border:1px solid #bfdbfe;border-radius:8px;padding:8px 9px;font-size:10px;font-weight:800;cursor:pointer;}
.btn-cerrar{width:100%;background:#fff;color:#dc2626;border:1px solid #fecaca;padding:12px;border-radius:10px;font-size:13px;font-weight:800;cursor:pointer;margin-top:14px;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .15s;}
.btn-cerrar:hover{background:#fef2f2;}
.side-card{background:#fff;border:1px solid var(--erp-border);border-radius:var(--erp-radius);box-shadow:var(--erp-shadow);overflow:hidden;position:sticky;top:86px;}
.side-card-head{padding:13px 14px;border-bottom:1px solid #edf1f5;font-size:12px;font-weight:800;color:#1e293b;display:flex;align-items:center;gap:7px;}
.side-card-body{padding:14px;}
.side-cart-art{height:120px;border-radius:12px;background:linear-gradient(135deg,#eff6ff,#f8fbff);display:grid;place-items:center;font-size:55px;margin-bottom:12px;position:relative;overflow:hidden;}
.side-cart-art:before,.side-cart-art:after{content:"";position:absolute;border-radius:50%;background:#dbeafe;opacity:.7;}.side-cart-art:before{width:90px;height:90px;left:-25px;top:-25px}.side-cart-art:after{width:70px;height:70px;right:-20px;bottom:-20px}
.side-status{background:#eff6ff;border:1px solid #dbeafe;color:#1d4ed8;border-radius:9px;padding:10px;font-size:10px;line-height:1.45;text-align:center;}
.side-progress{margin-top:14px;}.side-progress-label{display:flex;justify-content:space-between;font-size:10px;color:#64748b;margin-bottom:5px;font-weight:700;}.side-progress-bar{height:7px;background:#e8eef6;border-radius:99px;overflow:hidden;}.side-progress-fill{height:100%;background:#2563eb;border-radius:99px;}
.toast{position:fixed;top:82px;right:24px;z-index:9999;padding:11px 15px;border-radius:10px;font-size:12px;font-weight:700;display:none;align-items:center;gap:8px;box-shadow:0 8px 25px rgba(15,23,42,.14);}
.toast.show{display:flex;animation:toastIn .2s}.tok{background:#ecfdf3;color:#166534;border:1px solid #86efac}.twk{background:#fffbeb;color:#92400e;border:1px solid #fcd34d}.ter{background:#fef2f2;color:#991b1b;border:1px solid #fca5a5}
.modal-lote-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.42);backdrop-filter:blur(2px);z-index:10001;align-items:center;justify-content:center;padding:16px;}
.modal-lote-box{width:100%;max-width:430px;background:#fff;border:1px solid var(--erp-border);border-radius:16px;box-shadow:0 24px 70px rgba(15,23,42,.18);overflow:hidden;}
.modal-lote-head{display:flex;justify-content:space-between;align-items:center;padding:15px 16px;border-bottom:1px solid #edf1f5;color:#172033;font-weight:800;}
.modal-lote-head button{background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer;}
.modal-lote-body{padding:16px;}.modal-lote-warn{background:#fffbeb;border:1px solid #fde68a;color:#92400e;border-radius:10px;padding:10px 12px;font-size:11px;line-height:1.45;margin-bottom:14px}.modal-lote-label{display:block;font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin:0 0 5px;font-weight:800}.modal-lote-input{width:100%;padding:11px 12px;border-radius:9px;border:1px solid #cbd5e1;background:#fff;color:#172033;font-size:15px;outline:none;margin-bottom:12px}.modal-lote-input:focus{border-color:#60a5fa;box-shadow:0 0 0 3px rgba(37,99,235,.08)}.modal-lote-actions{display:flex;justify-content:flex-end;gap:8px}.modal-lote-btn{border:none;border-radius:9px;padding:10px 14px;font-weight:800;cursor:pointer}.modal-lote-cancel{background:#f1f5f9;color:#475569}.modal-lote-save{background:#2563eb;color:#fff}
#camaraModal{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(2px);z-index:10000;align-items:center;justify-content:center;padding:12px}.camara-dialog{width:100%;max-width:520px;background:#fff;border:1px solid var(--erp-border);border-radius:16px;overflow:hidden;box-shadow:0 24px 70px rgba(15,23,42,.2)}#camaraModal.open{display:flex}.camara-hdr{display:flex;align-items:center;justify-content:space-between;padding:13px 14px;border-bottom:1px solid #edf1f5}.camara-hdr-title{font-size:13px;font-weight:800;color:#172033;display:flex;align-items:center;gap:8px}.camara-hdr-pulse{width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 4px #dcfce7}.btn-camara-cerrar{background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;width:30px;height:30px;border-radius:8px;font-size:16px;cursor:pointer}#camaraVisor{position:relative;background:#0f172a;min-height:300px;overflow:hidden}#camaraVisor video{width:100%!important;height:auto!important;display:block}.scan-frame{position:absolute;z-index:3;inset:50% auto auto 50%;width:260px;height:150px;transform:translate(-50%,-50%);pointer-events:none;border:2px solid #60a5fa;border-radius:10px;box-shadow:0 0 0 9999px rgba(15,23,42,.35)}.scan-line{position:absolute;left:8px;right:8px;top:50%;height:2px;background:#22c55e;box-shadow:0 0 8px #22c55e;animation:scanAnim 1.8s ease-in-out infinite}.camara-result{padding:10px 14px;text-align:center;border-top:1px solid #edf1f5;min-height:42px;color:#64748b;font-size:12px}.camara-result-code{font-family:monospace;color:#15803d;font-size:15px;font-weight:800}.camara-hint{padding:0 14px 13px;text-align:center;color:#94a3b8;font-size:10px}
#modalOctogonos{background:rgba(15,23,42,.45)!important;backdrop-filter:blur(2px);}
#modalOctogonos>div{border:1px solid #e2e8f0!important;box-shadow:0 24px 70px rgba(15,23,42,.18)!important}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.45;transform:scale(.85)}}@keyframes toastIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}@keyframes popup{from{transform:scale(.96);opacity:0}to{transform:scale(1);opacity:1}}
@media(max-width:980px){.erp-sidebar{display:none}.erp-topbar{height:58px;padding:0 14px}.pg{padding:16px 14px 28px}.workflow-grid{grid-template-columns:1fr}.side-card{display:none}.order-summary{grid-template-columns:1fr 1fr 1fr 1fr}.order-summary-main{grid-column:1/-1;border-right:0;border-bottom:1px solid #edf1f5;padding:0 0 12px;margin-bottom:8px}.summary-kpi{border-right:1px solid #edf1f5}.summary-kpi:last-child{border-right:0}.page-title h1{font-size:21px}}
@media(max-width:640px){.erp-topbar{position:relative}.erp-crumb{font-size:11px}.erp-user span{display:none}.pg{padding:12px 10px 24px}.page-title{margin-bottom:12px}.page-title-icon{width:38px;height:38px;font-size:19px}.page-title h1{font-size:19px}.page-title p{font-size:10px}.order-summary{grid-template-columns:repeat(2,1fr);padding:12px}.order-summary-main{padding-bottom:10px}.summary-kpi{padding:8px 7px}.kpi-icon{width:30px;height:30px;font-size:14px}.kpi-val{font-size:16px}.kpi-label{font-size:9px}.prog-card{padding:13px}.scanner-wrap{padding:13px}.scanner-input-row{flex-direction:column}.camera-btn{height:44px;padding:0 14px}.activo-box{padding:14px}.activo-fields,.active-extra-grid{grid-template-columns:1fr}.activo-name{font-size:17px}.activo-product-icon{width:52px;height:52px;font-size:23px}.prod-item{padding:11px}.prod-item-meta{flex-wrap:wrap}.toast{top:68px;right:10px;left:10px}.ready-card{padding:24px 16px}.modal-lote-box{max-width:100%}#camaraVisor{min-height:270px}.scan-frame{width:230px;height:135px}}
</style>

<div class="erp-shell">
    <aside class="erp-sidebar">
        <div class="erp-brand">
            <div class="erp-brand-mark">📦</div>
            <div class="erp-brand-text">DISTAN<span>ERP</span></div>
        </div>
        <nav class="erp-nav">
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">⌂</span>Inicio</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">▣</span>Inventario</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">⚙</span>Producción</a>
            <a class="erp-nav-item active" href="#"><span class="erp-nav-icon">🛒</span>Pedidos</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">▱</span>Encomiendas</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">♙</span>Clientes</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">▤</span>Kardex</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">▧</span>Reportes</a>
            <a class="erp-nav-item" href="#"><span class="erp-nav-icon">⚙</span>Configuración</a>
        </nav>
        <div class="erp-sidebar-foot">DISTAN ERP · Preparación de pedidos</div>
    </aside>
    <div class="erp-main">
        <header class="erp-topbar">
            <div class="erp-crumb">Órdenes <span>›</span> <strong>Preparación de pedido</strong></div>
            <div class="erp-user"><span>🔔</span><div class="erp-user-avatar">👤</div><span>Operario · Almacén</span></div>
        </header>
        <div class="pg">

{{-- Toast --}}
<div class="toast" id="toast"></div>

{{-- Header --}}
@php
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d'
                 : ($order->estado === 'PARCIAL'  ? '#b45309' : '#b91c1c');
    $totalUnidades = $order->details->sum('cantidad_solicitada');
    $doneUnidades  = $order->details->sum('cantidad_despachada');
    $porcentaje    = $totalUnidades > 0 ? ($doneUnidades / $totalUnidades) * 100 : 0;
    $progColor     = $porcentaje >= 100 ? '#22c55e' : ($porcentaje > 40 ? '#f59e0b' : '#ef4444');
    $totalItems    = $order->details->count();
    $compItems     = $order->details->where('estado_item','COMPLETO')->count();
    $parItems      = $order->details->where('estado_item','PARCIAL')->count();
    $incItems      = $order->details->where('estado_item','INCOMPLETO')->count();
@endphp

<div class="page-title">
    <div class="page-title-left">
        <div class="page-title-icon">🛒</div>
        <div>
            <h1>Preparación de pedido</h1>
            <p>Escanea los productos y registra las cantidades a despachar.</p>
        </div>
    </div>
</div>

<div class="order-summary">
    <div class="order-summary-main">
        <div class="order-number">📋 {{ $order->numero_orden }} <span class="badge-estado" style="background:{{ $estadoColor }};">{{ $order->estado }}</span></div>
        <div class="order-client">{{ $order->client?->razon_social }}</div>
        <div class="order-meta">
            <span class="meta-pill blue">📦 {{ $totalItems }} productos</span>
            <span class="meta-pill green">🛒 {{ strtoupper(trim($order->tipo_orden ?? '')) === 'SUPERMERCADO' ? 'Supermercados' : ($order->tipo_orden ?? 'Pedido') }}</span>
        </div>
    </div>
    <div class="summary-kpi kpi-blue"><div class="kpi-icon">▣</div><div><div class="kpi-val">{{ $totalItems }}</div><div class="kpi-label">Productos</div></div></div>
    <div class="summary-kpi kpi-green"><div class="kpi-icon">✓</div><div><div class="kpi-val" id="kpiOkTop">{{ $compItems }}</div><div class="kpi-label">Completados</div></div></div>
    <div class="summary-kpi kpi-yellow"><div class="kpi-icon">◷</div><div><div class="kpi-val" id="kpiParTop">{{ $parItems }}</div><div class="kpi-label">Pendientes</div></div></div>
    <div class="summary-kpi progress-kpi"><div class="progress-ring-mini" id="progressRingMini" style="background:conic-gradient(#2563eb {{ $porcentaje }}%,#e5e7eb 0);"><span id="progressRingText">{{ number_format($porcentaje,0) }}%</span></div><div><div class="kpi-val" id="summaryPct">{{ number_format($porcentaje,0) }}%</div><div class="kpi-label">Avance general</div></div></div>
</div>

{{-- Barra grande --}}
<div class="prog-card">
    <div class="prog-top">
        <div>
            <div class="prog-pct" id="pctNum" style="color:{{ $progColor }};">{{ number_format($porcentaje,0) }}%</div>
            <div style="font-size:11px;color:#64748b;margin-top:2px;">Progreso de despacho</div>
        </div>
        <div style="text-align:right;">
            <div id="pctDone" style="font-size:18px;font-weight:700;color:#f8fafc;">{{ $doneUnidades }} / {{ $totalUnidades }}</div>
            <div style="font-size:11px;color:#64748b;">unidades despachadas</div>
        </div>
    </div>
    <div class="prog-track">
        <div class="prog-fill" id="progFill" style="width:{{ $porcentaje }}%;background:{{ $progColor }};"></div>
    </div>
    <div class="prog-labels">
        <span>0%</span>
        <span id="progEstado" style="color:{{ $progColor }};">● {{ $order->estado }}</span>
        <span>100%</span>
    </div>
</div>

{{-- KPIs --}}
<div class="kpis">
    <div class="kpi">
        <div class="kpi-val" style="color:#3b82f6;">{{ $totalItems }}</div>
        <div class="kpi-label">Productos</div>
    </div>
    <div class="kpi">
        <div class="kpi-val" style="color:#22c55e;" id="kpiOk">{{ $compItems }}</div>
        <div class="kpi-label">Completos</div>
    </div>
    <div class="kpi">
        <div class="kpi-val" style="color:#f59e0b;" id="kpiPar">{{ $parItems }}</div>
        <div class="kpi-label">Parciales</div>
    </div>
    <div class="kpi">
        <div class="kpi-val" style="color:#ef4444;" id="kpiInc">{{ $incItems }}</div>
        <div class="kpi-label">Faltantes</div>
    </div>
</div>

<div class="workflow-grid">
    <main class="workflow-main">

{{-- Scanner --}}
<div class="scanner-wrap">
    <div class="scanner-top">
        <div class="scanner-pulse"></div>
        <div class="scanner-label">📡 Escanear código de barras</div>
        <button type="button" class="camera-btn" id="btnAbrirCamara">📷 Cámara</button>
    </div>
    <input type="text" id="scanner" class="scanner-input"
           placeholder="Escanea o escribe el código y presiona Enter..." >
    <div class="scanner-hint">⌨ Presiona <strong style="color:#64748b;">Enter</strong> para confirmar · También puedes usar la cámara</div>
</div>

<div class="ready-card" id="readyCard">
    <div class="ready-cart">🛒</div>
    <div class="ready-title">Escanea un producto para comenzar</div>
    <div class="ready-text">Usa el lector, escribe el código o abre la cámara del celular.</div>
</div>

{{-- Producto activo --}}
<div class="activo-box" id="activoBox">
    <div class="activo-head">
        <div class="activo-product-icon">📦</div>
        <div style="min-width:0;flex:1;">
            <div class="activo-name" id="activoNombre">—</div>
    <div class="activo-meta">
        <span>SKU: <strong id="activoSku" style="color:#64748b;">—</strong></span>
        <span>Stock: <strong id="activoStock" style="color:#64748b;">—</strong></span>
        <span>Peso: <strong id="activoPeso" style="color:#64748b;">—</strong></span>
        </div>
    </div>

    @if(strtoupper(trim($order->tipo_orden ?? '')) === 'SUPERMERCADO')
    <div style="margin-bottom:.75rem;">
        <label class="activo-label">🪵 Paleta</label>
        <input type="text" class="activo-input" id="activoPaletaInput" maxlength="50"
               placeholder="Ej: P01" autocomplete="off"
               style="text-transform:uppercase;">
    </div>
    @endif

    <div style="margin-bottom:.75rem;">
        <label class="activo-label">👤 Personal que retiró el producto</label>
        <input type="text" class="activo-input" id="activoPersonal"
               placeholder="Escribe el nombre del personal..." maxlength="100" autocomplete="off">
    </div>

    <div class="activo-fields">
        <div>
            <label class="activo-label">Solicitado</label>
            <input type="number" class="activo-input" id="activoSolicitado" readonly style="color:#64748b;">
        </div>
        <div>
            <label class="activo-label">Despachado ✏️</label>
            <input type="number" class="activo-input big" id="activoCantidad" placeholder="0">
        </div>
    </div>
    <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:3px;">
        <span>Progreso ítem</span>
        <span id="activoPctLabel" style="font-weight:700;color:#94a3b8;">—</span>
    </div>
    <div class="activo-bar-track">
        <div id="activoBarFill" style="height:100%;border-radius:99px;background:#3b82f6;width:0%;transition:width .3s;"></div>
    </div>
    <div style="font-size:11px;color:#475569;margin-top:4px;">
        @if(strtoupper(trim($order->tipo_orden ?? '')) !== 'SUPERMERCADO')
            Paleta: <strong id="activoPaleta" style="color:#64748b;">—</strong> ·
        @endif
        Ubicación: <strong id="activoUbicacion" style="color:#64748b;">—</strong>
        · Vence: <strong id="activoVence" style="color:#64748b;">—</strong>
    </div>
    <div class="active-actions">
        <button type="button" class="active-save-btn" id="btnGuardarDespacho">✓ Guardar despacho</button>
        <button type="button" class="active-clear-btn" id="btnLimpiarActivo">Limpiar</button>
    </div>
</div>

{{-- Lista productos --}}
<div class="sec-title">📦 Productos de la orden</div>
<div class="prod-list">

@foreach($order->details as $item)
@php
    $pct2 = $item->cantidad_solicitada > 0
           ? ($item->cantidad_despachada / $item->cantidad_solicitada) * 100
           : 0;
    $lc  = $item->cantidad_despachada >= $item->cantidad_solicitada ? '#22c55e'
          : ($item->cantidad_despachada > 0 ? '#f59e0b' : '#ef4444');
    $badgeCls = $item->cantidad_despachada >= $item->cantidad_solicitada ? 'bc'
              : ($item->cantidad_despachada > 0 ? 'bp' : 'bi');
    $badgeLbl = $item->cantidad_despachada >= $item->cantidad_solicitada ? 'COMPLETO'
              : ($item->cantidad_despachada > 0 ? 'PARCIAL' : 'INCOMPLETO');
@endphp
<div class="prod-item" id="item-{{ $item->id }}" style="border-left-color:{{ $lc }};">
    <div class="prod-item-top">
        <div>
            <div class="prod-item-name">{{ $item->product->nombre }}</div>
            <div class="prod-item-sku">
                SKU: {{ $item->product->sku }}
                @if($item->paleta) · {{ $item->paleta }}@endif
                @if($item->ubicacion) · {{ $item->ubicacion }}@endif
            </div>
        </div>
        <span class="prod-item-badge {{ $badgeCls }}">{{ $badgeLbl }}</span>
    </div>
    @php
    $porCaja = (int) ($item->product->cantidad_por_caja ?? 0);

    $cajasSolicitadas = $porCaja > 0
        ? intdiv((int) $item->cantidad_solicitada, $porCaja)
        : 0;

    $sueltasSolicitadas = $porCaja > 0
        ? ((int) $item->cantidad_solicitada % $porCaja)
        : 0;

    $cajasDespachadas = $porCaja > 0
        ? intdiv((int) $item->cantidad_despachada, $porCaja)
        : 0;

    $sueltasDespachadas = $porCaja > 0
        ? ((int) $item->cantidad_despachada % $porCaja)
        : 0;
@endphp

<div class="prod-item-meta" style="flex-wrap:wrap;gap:6px;">
    <span>
        Solicitado:
        <strong style="color:#334155;">{{ $item->cantidad_solicitada }}</strong>
        @if($porCaja > 0)
            <small style="color:#64748b;">
                · <span id="cajas-solicitadas-{{ $item->id }}">{{ $cajasSolicitadas }}</span>
                caja<span id="cajas-solicitadas-plural-{{ $item->id }}">{{ $cajasSolicitadas != 1 ? 's' : '' }}</span>
                <span id="sueltas-solicitadas-wrap-{{ $item->id }}">
                    @if($sueltasSolicitadas > 0)
                        + {{ $sueltasSolicitadas }} suelta{{ $sueltasSolicitadas != 1 ? 's' : '' }}
                    @endif
                </span>
            </small>
        @endif
    </span>

    <span>
        Despachado:
        <strong id="despachado-{{ $item->id }}" style="color:{{ $lc }};">{{ $item->cantidad_despachada }}</strong>
        @if($porCaja > 0)
            <small style="color:#64748b;">
                · <span id="cajas-despachadas-{{ $item->id }}">{{ $cajasDespachadas }}</span>
                caja<span id="cajas-despachadas-plural-{{ $item->id }}">{{ $cajasDespachadas != 1 ? 's' : '' }}</span>
                <span id="sueltas-despachadas-wrap-{{ $item->id }}">
                    @if($sueltasDespachadas > 0)
                        + {{ $sueltasDespachadas }} suelta{{ $sueltasDespachadas != 1 ? 's' : '' }}
                    @endif
                </span>
            </small>
        @endif
    </span>

    <span style="font-weight:700;color:{{ $lc }};" id="pct-{{ $item->id }}">
        {{ number_format($pct2,0) }}%
    </span>
</div>

    <div class="item-detail-box">
        <div style="display:flex;justify-content:space-between;gap:8px;align-items:center;flex-wrap:wrap;">
            <div>🏷️ Lote: <strong style="color:#334155;">{{ $item->lote ?: '—' }}</strong></div>
            <div>📅 Vence: <strong style="color:#334155;">{{ $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '—' }}</strong></div>
        </div>
        @if(strtoupper(trim($order->tipo_orden ?? '')) === 'SUPERMERCADO')
        <div style="margin-top:4px;">🪵 Paleta: <strong id="paleta-{{ $item->id }}" style="color:#334155;">{{ $item->paleta ?: '—' }}</strong></div>
        @endif
        @if(!empty($item->personal_despacho))
            <div id="personal-{{ $item->id }}" style="margin-top:4px;">👤 Retiró: <strong style="color:#334155;">{{ $item->personal_despacho }}</strong></div>
        @else
            <div id="personal-{{ $item->id }}" style="display:none;margin-top:4px;"></div>
        @endif
        <button type="button" onclick="abrirModalLote(
            {{ $item->id }},
            @js($item->lote),
            @js($item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('Y-m-d') : '')
        )" class="item-edit-btn">
            ✏️ Modificar lote / vencimiento
        </button>
    </div>

    <div class="prod-mini-bar">
        <div class="prod-mini-fill" id="bar-{{ $item->id }}" style="width:{{ $pct2 }}%;background:{{ $lc }};"></div>
    </div>
</div>
@endforeach

</div>

{{-- Cerrar orden --}}
<form method="POST" action="{{ route('orders.cerrar', $order) }}" onsubmit="return confirmarCierre()">
    @csrf
    <button type="submit" class="btn-cerrar">✅ Cerrar orden (aunque esté incompleta)</button>
</form>

    </main>

    <aside class="side-card">
        <div class="side-card-head">🛒 Armado de pedido</div>
        <div class="side-card-body">
            <div class="side-cart-art">🛒</div>
            <div class="side-status">Selecciona un producto para comenzar el despacho. El avance se actualiza automáticamente.</div>
            <div class="side-progress">
                <div class="side-progress-label"><span>Avance del pedido</span><strong id="sidePct">{{ number_format($porcentaje,0) }}%</strong></div>
                <div class="side-progress-bar"><div class="side-progress-fill" id="sideProgressFill" style="width:{{ $porcentaje }}%;"></div></div>
            </div>
        </div>
    </aside>
</div>
<div id="pedidoLoader" style="display:none;position:fixed;inset:0;background:rgba(255,255,255,.88);backdrop-filter:blur(2px);z-index:20000;align-items:center;justify-content:center;">
    <div style="text-align:center;background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:24px 30px;box-shadow:0 20px 60px rgba(15,23,42,.14);">
        <div style="font-size:48px;animation:cartFloat 1.1s ease-in-out infinite;">🛒</div>
        <div style="font-size:15px;font-weight:800;color:#172033;margin-top:8px;">Guardando despacho...</div>
        <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Actualizando el pedido</div>
    </div>
</div>

<!-- =========================================
     MODAL OCTÓGONOS
========================================= -->

<div id="modalOctogonos"
style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.65);
z-index:9999;
justify-content:center;
align-items:center;
">

<div style="
background:white;
width:420px;
max-width:92%;
border-radius:18px;
padding:25px;
text-align:center;
box-shadow:0 20px 40px rgba(0,0,0,.35);
animation:popup .25s;
">

<h2 style="
margin:0;
color:#dc2626;
font-size:24px;
">
⚠ Verificar Etiqueta
</h2>

<div
id="modalProducto"
style="
margin-top:12px;
font-size:18px;
font-weight:bold;
color:#0f172a;
">
Producto
</div>

<div
id="modalAdvertencias"
style="
margin:25px 0;
display:flex;
justify-content:center;
gap:12px;
flex-wrap:wrap;
">

</div>

<div style="
font-size:14px;
color:#475569;
margin-bottom:20px;
">

Verifique que el producto tenga correctamente
los octógonos nutricionales antes de continuar.

</div>

<button
id="btnEntendido"
style="
background:#16a34a;
color:white;
border:none;
padding:12px 35px;
font-size:16px;
border-radius:10px;
cursor:pointer;
font-weight:bold;
">

✔ Entendido

</button>

</div>

</div>


{{-- Modal editar lote / vencimiento --}}
<div id="modalLote" class="modal-lote-overlay">
    <div class="modal-lote-box">
        <div class="modal-lote-head">
            <span>🏷️ Editar lote y vencimiento</span>
            <button type="button" onclick="cerrarModalLote()">✕</button>
        </div>
        <div class="modal-lote-body">
            <div class="modal-lote-warn">
                ⚠️ <strong>Esta edición es para casos extraordinarios.</strong><br>
                Si el dato está mal en el producto, corrígelo también en <strong>Productos</strong> para mantener la información actualizada.
            </div>
            <form id="formLote" method="POST" action="">
                @csrf
                @method('PUT')
                <label class="modal-lote-label">Lote</label>
                <input type="text" name="lote" id="loteInput" class="modal-lote-input" maxlength="100" placeholder="Ej: L-2026-045">
                <label class="modal-lote-label">Fecha de vencimiento</label>
                <input
    type="text"
    name="fecha_vencimiento"
    id="fechaVencInput"
    class="modal-lote-input"
    inputmode="numeric"
    autocomplete="off"
    maxlength="10"
    placeholder="DD/MM/AAAA"
    pattern="\\d{2}/\\d{2}/\\d{4}"
>
                <div class="modal-lote-actions">
                    <button type="button" class="modal-lote-btn modal-lote-cancel" onclick="cerrarModalLote()">Cancelar</button>
                    <button type="submit" class="modal-lote-btn modal-lote-save">💾 Guardar</button>
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

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let detalles = @json($order->details->load('product'));
let scanner  = document.getElementById('scanner');
let activoActual = null;

function showToast(msg, tipo){
    const t = document.getElementById('toast');
    t.className = 'toast show ' + tipo;
    t.textContent = msg;
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.className = 'toast'; }, 2800);
}

function beep(){
    try {
        let ctx = new (window.AudioContext || window.webkitAudioContext)();
        let o = ctx.createOscillator();
        let g = ctx.createGain();
        o.connect(g); g.connect(ctx.destination);
        o.frequency.value = 880;
        o.type = 'sine';
        g.gain.setValueAtTime(0.3, ctx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.15);
        o.start(ctx.currentTime);
        o.stop(ctx.currentTime + 0.15);
    } catch(e){}
}

function abrirModalLote(id, lote, fecha){
    document.getElementById('formLote').action = '/order-details/' + id + '/lote';
    document.getElementById('loteInput').value = lote || '';

    // El usuario puede escribir la fecha con el teclado del celular.
    // El backend seguirá recibiendo YYYY-MM-DD.
    let fechaMostrar = '';
    if(fecha){
        const partes = String(fecha).split('-');
        fechaMostrar = partes.length === 3
            ? partes[2] + '/' + partes[1] + '/' + partes[0]
            : fecha;
    }
    document.getElementById('fechaVencInput').value = fechaMostrar;
    document.getElementById('modalLote').style.display = 'flex';
}

function cerrarModalLote(){
    document.getElementById('modalLote').style.display = 'none';
}

document.getElementById('modalLote').addEventListener('click', function(e){
    if(e.target === this) cerrarModalLote();
});

// Formato DD/MM/AAAA y conversión a YYYY-MM-DD para Laravel.
document.getElementById('fechaVencInput').addEventListener('input', function(){
    let v = this.value.replace(/\D/g, '').slice(0, 8);
    if(v.length > 4) v = v.slice(0,2) + '/' + v.slice(2,4) + '/' + v.slice(4);
    else if(v.length > 2) v = v.slice(0,2) + '/' + v.slice(2);
    this.value = v;
});

document.getElementById('formLote').addEventListener('submit', function(e){
    const input = document.getElementById('fechaVencInput');
    const valor = input.value.trim();

    if(!valor) return;

    const m = valor.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
    if(!m){
        e.preventDefault();
        showToast('⚠ Fecha inválida. Usa DD/MM/AAAA', 'twk');
        input.focus();
        return;
    }

    const dia = parseInt(m[1], 10);
    const mes = parseInt(m[2], 10);
    const anio = parseInt(m[3], 10);
    const fecha = new Date(anio, mes - 1, dia);

    if(
        fecha.getFullYear() !== anio ||
        fecha.getMonth() !== mes - 1 ||
        fecha.getDate() !== dia
    ){
        e.preventDefault();
        showToast('⚠ La fecha ingresada no es válida', 'twk');
        input.focus();
        return;
    }

    input.value =
        anio.toString().padStart(4,'0') + '-' +
        mes.toString().padStart(2,'0') + '-' +
        dia.toString().padStart(2,'0');
});
// =====================================
// MODAL ADVERTENCIAS
// =====================================
function mostrarModalAdvertencias(item){

    document.getElementById("modalProducto").innerHTML =
        item.product.nombre;

    let html = "";

    let adv = (item.product.advertencias || "")
        .toUpperCase()
        .split(",");

    if(adv.includes("AZUCAR")){

        html += `
        <img
        src="https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png"
        style="
            height:120px;
            object-fit:contain;
        ">
        `;

    }

    if(adv.includes("SODIO")){

        html += `
        <img
        src="https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png"
        style="
            height:120px;
            object-fit:contain;
        ">
        `;

    }

    if(adv.includes("GRASAS")){

        html += `
        <img
        src="https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png"
        style="
            height:120px;
            object-fit:contain;
        ">
        `;

    }

    document.getElementById("modalAdvertencias").innerHTML = html;

    document.getElementById("modalOctogonos").style.display = "flex";

    document.getElementById("btnEntendido").addEventListener("click", function(){

    document.getElementById("modalOctogonos").style.display = "none";

    setTimeout(function(){

        document.getElementById("activoCantidad").focus();

        document.getElementById("activoCantidad").select();

    },100);

});


}

function actualizarBarra(){
    let total = 0, done = 0, ok = 0, par = 0, inc = 0;
    detalles.forEach(d => {
        total += parseFloat(d.cantidad_solicitada);
        done  += parseFloat(d.cantidad_despachada);
        const pct = parseFloat(d.cantidad_solicitada) > 0
            ? d.cantidad_despachada / d.cantidad_solicitada : 0;
        if(pct >= 1) ok++;
        else if(pct > 0) par++;
        else inc++;
    });
    const pct = total > 0 ? (done / total) * 100 : 0;
    const color = pct >= 100 ? '#22c55e' : (pct > 40 ? '#f59e0b' : '#ef4444');

    document.getElementById('progFill').style.width  = pct + '%';
    document.getElementById('progFill').style.background = color;
    document.getElementById('pctNum').textContent = Math.round(pct) + '%';
    document.getElementById('pctNum').style.color = color;
    document.getElementById('pctDone').textContent = Math.round(done) + ' / ' + Math.round(total);
    document.getElementById('kpiOk').textContent  = ok;
    document.getElementById('kpiPar').textContent = par;
    document.getElementById('kpiInc').textContent = inc;
    const topOk = document.getElementById('kpiOkTop');
    const topPar = document.getElementById('kpiParTop');
    const topPct = document.getElementById('summaryPct');
    const ring = document.getElementById('progressRingMini');
    const ringText = document.getElementById('progressRingText');
    const sidePct = document.getElementById('sidePct');
    const sideFill = document.getElementById('sideProgressFill');
    if(topOk) topOk.textContent = ok;
    if(topPar) topPar.textContent = par + inc;
    if(topPct) topPct.textContent = Math.round(pct) + '%';
    if(ring) ring.style.background = 'conic-gradient(#2563eb ' + Math.min(pct,100) + '%,#e5e7eb 0)';
    if(ringText) ringText.textContent = Math.round(pct) + '%';
    if(sidePct) sidePct.textContent = Math.round(pct) + '%';
    if(sideFill) sideFill.style.width = Math.min(pct,100) + '%';
}

function mostrarActivo(item){
    activoActual = item;
    const pct = item.cantidad_solicitada > 0
        ? (item.cantidad_despachada / item.cantidad_solicitada) * 100 : 0;
    const color = pct >= 100 ? '#22c55e' : (pct > 0 ? '#f59e0b' : '#ef4444');

    document.getElementById('activoNombre').textContent   = item.product.nombre;
    document.getElementById('activoSku').textContent      = item.product.sku ?? '—';
    document.getElementById('activoStock').textContent    = item.product.stock ?? '—';
    document.getElementById('activoPeso').textContent     = item.product.peso
        ? (item.product.peso / 1000).toFixed(3) + ' kg' : '—';
    document.getElementById('activoSolicitado').value     = item.cantidad_solicitada;
    document.getElementById('activoCantidad').value       = item.cantidad_despachada || '';
    document.getElementById('activoUbicacion').textContent= item.ubicacion || '—';
    const paletaInput = document.getElementById('activoPaletaInput');
    if(paletaInput){
        paletaInput.value = item.paleta || '';
    }
    const personalInput = document.getElementById('activoPersonal');
    if(personalInput){
        personalInput.value = item.personal_despacho || '';
    }
    const paletaText = document.getElementById('activoPaleta');
    if(paletaText){
        paletaText.textContent = item.paleta || '—';
    }
    document.getElementById('activoVence').textContent = item.fecha_vencimiento || item.product?.fecha_vencimiento || '—';
    document.getElementById('activoBarFill').style.width  = pct + '%';
    document.getElementById('activoBarFill').style.background = color;
    document.getElementById('activoPctLabel').textContent = Math.round(pct) + '%';
    document.getElementById('activoPctLabel').style.color = color;

    document.getElementById('activoBox').style.display = 'block';
    const readyCard = document.getElementById('readyCard');
    if(readyCard) readyCard.style.display = 'none';

// =====================================
// VERIFICAR ADVERTENCIAS NUTRICIONALES
// =====================================

if(item.product.advertencias){

    mostrarModalAdvertencias(item);

}else{

    document.getElementById('activoCantidad').focus();
    document.getElementById('activoCantidad').select();

}
}

// Update mini bar en lista
function actualizarCajasUI(item){
    const porCaja = parseInt(item.product?.cantidad_por_caja || 0, 10);
    if(!porCaja || porCaja <= 0) return;

    const cantidad = Math.max(0, Math.floor(parseFloat(item.cantidad_despachada) || 0));
    const cajas = Math.floor(cantidad / porCaja);
    const sueltas = cantidad % porCaja;

    const cajasEl = document.getElementById('cajas-despachadas-' + item.id);
    if(cajasEl) cajasEl.textContent = cajas;

    const pluralEl = document.getElementById('cajas-despachadas-plural-' + item.id);
    if(pluralEl) pluralEl.textContent = cajas !== 1 ? 's' : '';

    const sueltasWrap = document.getElementById('sueltas-despachadas-wrap-' + item.id);
    if(sueltasWrap){
        sueltasWrap.textContent = sueltas > 0
            ? `+ ${sueltas} suelta${sueltas !== 1 ? 's' : ''}`
            : '';
    }
}

function actualizarItemUI(item){
    const pct = item.cantidad_solicitada > 0
        ? (item.cantidad_despachada / item.cantidad_solicitada) * 100 : 0;
    const color = pct >= 100 ? '#22c55e' : (pct > 0 ? '#f59e0b' : '#ef4444');

    const card = document.getElementById('item-' + item.id);
    if(!card) return;
    card.style.borderLeftColor = color;

    const span = document.getElementById('despachado-' + item.id);
    if(span){ span.textContent = item.cantidad_despachada; span.style.color = color; }

    const pctEl = document.getElementById('pct-' + item.id);
    if(pctEl){ pctEl.textContent = Math.round(pct) + '%'; pctEl.style.color = color; }

    const barEl = document.getElementById('bar-' + item.id);
    if(barEl){ barEl.style.width = pct + '%'; barEl.style.background = color; }

    const badge = card.querySelector('.prod-item-badge');
    if(badge){
        badge.className = 'prod-item-badge ' + (pct >= 100 ? 'bc' : (pct > 0 ? 'bp' : 'bi'));
        badge.textContent = pct >= 100 ? 'COMPLETO' : (pct > 0 ? 'PARCIAL' : 'INCOMPLETO');
    }
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

    const pct = item.cantidad_solicitada > 0
        ? (item.cantidad_despachada / item.cantidad_solicitada) * 100
        : 0;

    if(pct >= 100){
        showToast('⚠ ' + item.product.nombre + ' ya está completo', 'twk');
        scanner.value = '';
        return;
    }

    const card = document.getElementById('item-' + item.id);
    if(card){
        card.scrollIntoView({ behavior:'smooth', block:'center' });
        card.style.boxShadow = '0 0 0 2px #3b82f6';
        setTimeout(() => { card.style.boxShadow = ''; }, 1500);
    }

    mostrarActivo(item);
    showToast('✔ ' + item.product.nombre, 'tok');
    beep();
    scanner.value = '';
}

scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    procesarCodigo(this.value);
});

const btnGuardarDespacho = document.getElementById('btnGuardarDespacho');
if(btnGuardarDespacho){
    btnGuardarDespacho.addEventListener('click', function(){
        const campo = document.getElementById('activoCantidad');
        if(campo){ campo.dispatchEvent(new KeyboardEvent('keydown', {key:'Enter', bubbles:true})); }
    });
}

const btnLimpiarActivo = document.getElementById('btnLimpiarActivo');
if(btnLimpiarActivo){
    btnLimpiarActivo.addEventListener('click', function(){
        activoActual = null;
        const box = document.getElementById('activoBox');
        const ready = document.getElementById('readyCard');
        if(box) box.style.display = 'none';
        if(ready) ready.style.display = 'block';
    });
}

// Guardar desde campo cantidad
document.getElementById('activoCantidad').addEventListener('keydown', function(e){
    if(e.key !== 'Enter' || !activoActual) return;
    e.preventDefault();

    const cantidad = parseFloat(this.value);
    if(isNaN(cantidad) || cantidad < 0){
        showToast('⚠ Cantidad inválida', 'twk');
        return;
    }
    if(cantidad > activoActual.cantidad_solicitada){
        showToast('⚠ Supera la cantidad solicitada (' + activoActual.cantidad_solicitada + ')', 'twk');
        return;
    }

    const personalInput = document.getElementById('activoPersonal');
    const personal = personalInput ? personalInput.value.trim() : '';
    if(!personal){
        showToast('⚠ Debes indicar quién retiró el producto', 'twk');
        if(personalInput) personalInput.focus();
        return;
    }

    const paletaInput = document.getElementById('activoPaletaInput');
    const paleta = paletaInput ? paletaInput.value.trim().toUpperCase() : '';

    const formData = new FormData();
    formData.append('cantidad_despachada', cantidad);
    formData.append('cantidad_solicitada', activoActual.cantidad_solicitada);
    formData.append('precio_unitario', activoActual.precio_unitario || 0);
    formData.append('personal_despacho', personal);
    if(paletaInput){
        formData.append('paleta', paleta);
    }
    formData.append('_method', 'PUT');
    formData.append('_token', '{{ csrf_token() }}');

    const loader = document.getElementById('pedidoLoader');
    if(loader) loader.style.display = 'flex';

    fetch(`/order-details/${activoActual.id}`, {
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
        if(loader) loader.style.display = 'none';
        activoActual.cantidad_despachada = cantidad;
        activoActual.personal_despacho = personal;
        if(paletaInput){ activoActual.paleta = paleta; }

        actualizarItemUI(activoActual);
        actualizarBarra();

        const personalEl = document.getElementById('personal-' + activoActual.id);
        if(personalEl){
            personalEl.style.display = 'block';
            personalEl.innerHTML = `👤 Retiró: <strong style="color:#334155;">${escapeHtml(personal)}</strong>`;
        }

        const paletaEl = document.getElementById('paleta-' + activoActual.id);
        if(paletaEl){ paletaEl.textContent = paleta || '—'; }

        const pct = activoActual.cantidad_solicitada > 0
            ? (cantidad / activoActual.cantidad_solicitada) * 100 : 0;

        if(pct >= 100){
            showToast('✅ ' + activoActual.product.nombre + ' completado!', 'tok');
            document.getElementById('activoBox').style.display = 'none';
            const ready = document.getElementById('readyCard');
            if(ready) ready.style.display = 'block';
        } else {
            showToast('💾 Guardado: ' + cantidad + ' de ' + activoActual.cantidad_solicitada, 'tok');
            document.getElementById('activoBarFill').style.width  = pct + '%';
            document.getElementById('activoBarFill').style.background = '#f59e0b';
            document.getElementById('activoPctLabel').textContent = Math.round(pct) + '%';
        }

        beep();
        activoActual = null;
    })
    .catch(error => {
        if(loader) loader.style.display = 'none';
        console.error('❌ ERROR AL GUARDAR:', error);
        showToast('❌ Error al guardar. Revisa la consola.', 'ter');
    });
});

function escapeHtml(value){
    const div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
}

// Foco manual: no se fuerza el regreso al campo de escaneo.
// ================================
// ESCÁNER DE CÁMARA
// ================================
(function(){
    let lectorCamara = null;
    let procesando = false;

    const modal = document.getElementById('camaraModal');
    const btnAbrir = document.getElementById('btnAbrirCamara');
    const btnCerrar = document.getElementById('btnCerrarCamara');
    const resultado = document.getElementById('camaraResult');

    function mostrarErrorCamara(error){
        console.error('Error cámara:', error);

        let mensaje = '⚠️ No se pudo iniciar la cámara.';

        if(!window.isSecureContext){
            mensaje = '⚠️ Chrome bloquea la cámara porque esta página no está en HTTPS.';
        }else if(error && (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError')){
            mensaje = '⚠️ Chrome no autorizó la cámara para este sitio. Revisa el permiso de Cámara del sitio.';
        }else if(error && error.name === 'NotFoundError'){
            mensaje = '⚠️ No se encontró una cámara disponible.';
        }else if(error && error.name === 'NotReadableError'){
            mensaje = '⚠️ La cámara está siendo utilizada por otra aplicación.';
        }

        if(resultado){
            resultado.innerHTML =
                '<span style="color:#ef4444;">' + escapeHtml(mensaje) + '</span>';
        }
    }

    async function detenerLector(){
        const lector = lectorCamara;
        lectorCamara = null;

        if(lector){
            try { await lector.stop(); } catch(e){}
            try { lector.clear(); } catch(e){}
        }
    }

    async function cerrarCamara(){
        await detenerLector();

        if(modal){
            modal.classList.remove('open');
        }

        procesando = false;
    }

    async function abrirCamara(){
        if(!modal || !btnAbrir || lectorCamara) return;

        modal.classList.add('open');
        procesando = false;

        if(resultado){
            resultado.innerHTML = '🔐 Comprobando permiso de cámara...';
        }

        // Chrome exige un contexto seguro (HTTPS o localhost) para getUserMedia.
        if(!window.isSecureContext || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia){
            mostrarErrorCamara({ name:'SecurityError' });
            return;
        }

        let pruebaStream = null;

        try{
            // Solicitamos explícitamente el permiso al navegador.
            pruebaStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: 'environment' } },
                audio: false
            });

            // Ya tenemos permiso. Liberamos esta prueba y dejamos que
            // html5-qrcode abra la cámara que usará para escanear.
            pruebaStream.getTracks().forEach(track => track.stop());
            pruebaStream = null;

            if(resultado){
                resultado.innerHTML = '📷 Cámara autorizada · apunta al código...';
            }

            const visor = document.getElementById('camaraVisor');
            if(visor){
                visor.innerHTML =
                    '<div class="scan-frame"><div class="scan-line"></div></div>';
            }

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
                { facingMode: { ideal: 'environment' } },
                {
                    fps: 10,
                    qrbox: { width: 260, height: 150 },
                    aspectRatio: 1.777
                },
                async function(codigo){
                    if(procesando) return;

                    codigo = String(codigo || '').trim();
                    if(!codigo) return;

                    procesando = true;

                    if(resultado){
                        resultado.innerHTML =
                            '<span class="camara-result-code">✅ ' +
                            escapeHtml(codigo) +
                            '</span>';
                    }

                    if(navigator.vibrate){
                        navigator.vibrate(80);
                    }

                    // Procesamos el código sin devolver el foco al scanner.
                    try{
                        scanner.value = codigo;
                        procesarCodigo(codigo);
                    }catch(error){
                        console.error('Error procesando código de cámara:', error);
                        showToast('❌ Error al procesar el código', 'ter');
                    }finally{
                        await detenerLector();

                        if(modal){
                            modal.classList.remove('open');
                        }

                        procesando = false;
                    }
                },
                function(){}
            );

        }catch(error){
            if(pruebaStream){
                pruebaStream.getTracks().forEach(track => track.stop());
            }

            await detenerLector();
            mostrarErrorCamara(error);
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

window.onload = () => {
    actualizarBarra();
};
</script>


        </div>
    </div>
</div>
@endsection
