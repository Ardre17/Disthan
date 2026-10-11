@extends('layouts.app')

@section('content')

{{-- ── Íconos (sprite SVG) ── --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="i-cube" viewBox="0 0 24 24"><path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="m3 8 9 5 9-5M12 13v8"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="i-alert" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></symbol>
    <symbol id="i-archive" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="5" rx="1"/><path d="M5 9v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9M10 13h4"/></symbol>
    <symbol id="i-scale" viewBox="0 0 24 24"><path d="M12 3v18M5 21h14M6 7h12"/><path d="m6 7-3 7a3 3 0 0 0 6 0zM18 7l-3 7a3 3 0 0 0 6 0z"/></symbol>
    <symbol id="i-clip" viewBox="0 0 24 24"><rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4h6v3H9zM9 12h6M9 16h6"/></symbol>
    <symbol id="i-barcode" viewBox="0 0 24 24"><path d="M4 5v14M7 5v14M11 5v14M14 5v14M17 5v14M20 5v14"/></symbol>
    <symbol id="i-camera" viewBox="0 0 24 24"><path d="M4 8h3l2-3h6l2 3h3v11H4z"/><circle cx="12" cy="13" r="3.5"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
    <symbol id="i-print" viewBox="0 0 24 24"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M7 14h10v7H7z"/></symbol>
    <symbol id="i-file" viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4M9 13h6M9 17h6"/></symbol>
    <symbol id="i-trash" viewBox="0 0 24 24"><path d="M4 7h16M10 3h4M6 7l1 14h10l1-14M10 11v6M14 11v6"/></symbol>
    <symbol id="i-more" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.3"/><circle cx="12" cy="12" r="1.3"/><circle cx="19" cy="12" r="1.3"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6 6 18"/></symbol>
    <symbol id="i-history" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5M12 8v4l3 2"/></symbol>
    <symbol id="i-cal" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></symbol>
</svg>

<style>
*{box-sizing:border-box;}
.ic{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;vertical-align:middle;}
.ic-sm{width:14px;height:14px;}
.ic-lg{width:22px;height:22px;}

.pg{padding:1.1rem;background:#eef3f9;min-height:100vh;color:#0f172a;}

/* ── Breadcrumb + header ── */
.crumbs{font-size:11.5px;color:#64748b;margin-bottom:.6rem;}
.crumbs a{color:#64748b;text-decoration:none;}
.crumbs a:hover{color:#2563eb;}
.crumbs span{margin:0 4px;color:#94a3b8;}
.top-hdr{
    background:#fff;border:1px solid #e2e8f0;border-radius:14px;
    padding:.9rem 1.1rem;margin-bottom:.9rem;
    display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;
    box-shadow:0 2px 10px rgba(15,39,71,.04);
}
.hdr-left{display:flex;align-items:center;gap:14px;min-width:0;}
.hdr-ico{
    width:54px;height:54px;border-radius:14px;flex-shrink:0;
    background:linear-gradient(135deg,#fff7ed,#ffedd5);border:1px solid #fed7aa;
    color:#ea580c;display:flex;align-items:center;justify-content:center;
}
.hdr-ico .ic{width:30px;height:30px;}
.hdr-title{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.hdr-title h1{font-size:22px;font-weight:800;color:#0f172a;letter-spacing:.2px;line-height:1.1;}
.estado-badge{padding:4px 12px;border-radius:7px;font-size:11px;font-weight:700;}
.hdr-meta{font-size:12px;color:#64748b;margin-top:5px;display:flex;gap:16px;flex-wrap:wrap;}
.hdr-meta strong{color:#0f172a;font-weight:600;}
.hdr-right{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}

.btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s,transform .1s;font-family:inherit;}
.btn:hover{opacity:.88;}
.btn:active{transform:translateY(1px);}
.btn-green{background:#16a34a;color:#fff;}
.btn-blue{background:#2563eb;color:#fff;}
.btn-red{background:#dc2626;color:#fff;}
.btn-gray{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.btn-white{background:#fff;color:#0f172a;border:1px solid #cbd5e1;}
.btn-dark{background:#111827;color:#fff;}

/* ── KPIs + progreso ── */
.top-row{display:grid;grid-template-columns:minmax(0,2fr) minmax(0,1fr);gap:12px;margin-bottom:.9rem;}
@media(max-width:1000px){.top-row{grid-template-columns:1fr;}}
.kpis{display:grid;grid-template-columns:repeat(6,1fr);gap:8px;}
@media(max-width:900px){.kpis{grid-template-columns:repeat(3,1fr);}}
@media(max-width:480px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:.7rem .75rem;display:flex;align-items:center;gap:9px;min-width:0;}
.kpi-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.kpi-val{font-size:18px;font-weight:800;color:#0f172a;line-height:1;white-space:nowrap;}
.kpi-label{font-size:10.5px;color:#64748b;margin-top:3px;line-height:1.15;}
.kpi.k-blue{background:#eff6ff;border-color:#bfdbfe;}

.prog-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:.9rem 1.1rem;display:flex;flex-direction:column;justify-content:center;gap:8px;}
.prog-top{display:flex;justify-content:space-between;align-items:center;font-size:12px;}
.prog-top b{font-size:13px;color:#0f172a;}
.prog-top span{color:#64748b;font-weight:600;}
.prog-row{display:flex;align-items:center;gap:14px;}
.prog-track{flex:1;height:14px;background:#e2e8f0;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;transition:width .5s;}
.prog-pct{font-size:24px;font-weight:800;line-height:1;}

/* ── Alertas ── */
.alert-box{padding:9px 14px;border-radius:8px;font-size:13px;font-weight:500;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
.alert-err{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.alert-ok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}

/* ── Scanner ── */
.scanner-wrap{
    background:linear-gradient(90deg,#0f2a5c,#16377a);
    border-radius:12px;padding:.8rem 1rem;margin-bottom:.9rem;
    display:flex;align-items:center;gap:12px;
}
.scanner-ico{color:#fff;display:flex;flex-shrink:0;}
.scanner-ico .ic{width:30px;height:30px;stroke-width:1.6;}
.scanner-input{
    flex:1;min-width:0;padding:9px 14px;font-size:14px;border-radius:8px;
    border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.1);
    color:#f8fafc;outline:none;letter-spacing:.5px;transition:border-color .2s,background .2s;
}
.scanner-input:focus{border-color:#60a5fa;background:rgba(255,255,255,.16);}
.scanner-input::placeholder{color:#a9bddb;font-size:12px;letter-spacing:0;}
.scanner-hint{font-size:10.5px;color:#a9bddb;white-space:nowrap;line-height:1.25;}
@media(max-width:600px){.scanner-hint{display:none;}}
.cam-box{display:none;background:#0f172a;border-radius:12px;padding:.75rem;margin-bottom:.9rem;}
.cam-box .btn{margin-top:.6rem;}

/* ── Pestañas ── */
.enc-tabs{display:flex;gap:6px;margin-bottom:.9rem;overflow-x:auto;scrollbar-width:none;}
.enc-tabs::-webkit-scrollbar{display:none;}
.enc-tab{
    display:inline-flex;align-items:center;gap:7px;flex-shrink:0;
    padding:9px 16px;border-radius:10px;border:1px solid #e2e8f0;
    background:#fff;color:#475569;font:inherit;font-size:12.5px;font-weight:600;cursor:pointer;
    transition:background .15s,color .15s,border-color .15s;
}
.enc-tab:hover{border-color:#bfdbfe;color:#1d4ed8;}
.enc-tab.on{background:#2563eb;border-color:#2563eb;color:#fff;box-shadow:0 4px 12px rgba(37,99,235,.28);}
.enc-tab .tab-n{background:rgba(100,116,139,.15);border-radius:99px;padding:0 7px;font-size:10.5px;line-height:18px;}
.enc-tab.on .tab-n{background:rgba(255,255,255,.25);}
.enc-panel{display:none;}
.enc-panel.on{display:block;}

/* ── Layout 2 columnas ── */
.layout{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,1fr);gap:14px;align-items:start;}
@media(max-width:1100px){.layout{grid-template-columns:1fr;}}
.sec-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:1rem 1.1rem;box-shadow:0 2px 10px rgba(15,39,71,.04);}
.sec-title{font-size:15px;font-weight:700;color:#0f172a;margin-bottom:.85rem;display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap;}
.sec-title-left{display:flex;align-items:center;gap:8px;}
.sec-ico{width:28px;height:28px;border-radius:8px;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center;}
.count-pill{background:#dbeafe;color:#1d4ed8;font-size:11px;font-weight:700;padding:2px 9px;border-radius:99px;}

/* Agregar producto (colapsable) */
.add-form-box{display:none;background:#f8fafc;border-radius:10px;padding:.75rem;margin-bottom:.85rem;border:1px solid #e2e8f0;}
.add-form-box.open{display:block;}
.add-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:7px;align-items:end;}
@media(max-width:700px){.add-grid{grid-template-columns:1fr 1fr;}.add-grid > div:first-child{grid-column:1 / -1;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:7px 9px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;font-family:inherit;transition:border-color .15s,box-shadow .15s;}
.finput:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12);}

/* Tabla de productos (grid, para poder envolver cada fila en su <form>) */
.plist{overflow-x:auto;}
.phead,.prow-grid{
    display:grid;
    grid-template-columns:24px minmax(130px,1.7fr) 64px 50px 52px minmax(92px,1fr) 62px 64px 78px;
    gap:6px;align-items:center;
}
.phead{
    background:#f1f5f9;border-radius:8px;padding:8px 10px;margin-bottom:6px;
    font-size:10.5px;font-weight:700;color:#475569;text-align:center;
}
.phead > :nth-child(2){text-align:left;}
.prod-item{
    border:1px solid #e2e8f0;border-left:4px solid;border-radius:10px;
    padding:8px 10px;margin-bottom:6px;background:#fff;
    transition:box-shadow .15s;
}
.prod-item.row-part{background:#fffbeb;border-color:#fde68a;}
.prod-item.row-pend{background:#fef2f2;border-color:#fecaca;}
.prow-grid{font-size:12px;text-align:center;color:#334155;}
.c-n{color:#64748b;font-weight:600;}
.c-prod{display:flex;align-items:center;gap:8px;text-align:left;min-width:0;}
.p-tile{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:#fff;border:1px solid #e2e8f0;}
.p-name{font-size:12.5px;font-weight:700;color:#0f172a;line-height:1.2;}
.p-sub{font-size:10px;color:#64748b;margin-top:2px;line-height:1.3;}
.cell-in{
    width:100%;text-align:center;padding:6px 4px;font-size:12px;font-family:inherit;color:#1e293b;
    background:transparent;border:1px solid transparent;border-radius:7px;outline:none;
}
.cell-in:hover{border-color:#cbd5e1;background:#fff;}
.cell-in:focus{border-color:#2563eb;background:#fff;box-shadow:0 0 0 3px rgba(37,99,235,.12);}
.cell-price{background:#fff;border-color:#cbd5e1;font-weight:600;}
.c-falt-n{color:#dc2626;font-weight:700;}
.c-falt-0{color:#64748b;}
.c-prog{display:flex;align-items:center;gap:6px;}
.pbar{flex:1;height:8px;background:#e2e8f0;border-radius:99px;overflow:hidden;min-width:34px;}
.pbar > i{display:block;height:100%;border-radius:99px;}
.pbar-t{font-size:10.5px;font-weight:700;min-width:32px;text-align:right;}
.c-act{display:flex;align-items:center;justify-content:center;gap:5px;}
.sq-btn{
    width:30px;height:30px;border-radius:8px;border:1px solid #cbd5e1;background:#fff;color:#475569;
    display:inline-flex;align-items:center;justify-content:center;cursor:pointer;padding:0;font-family:inherit;
    transition:background .15s,color .15s;
}
.sq-btn:hover{background:#f1f5f9;}
.sq-btn.primary{background:#2563eb;border-color:#2563eb;color:#fff;}
.sq-btn.primary:hover{background:#1d4ed8;}
.prow-extra{display:none;margin-top:8px;padding-top:8px;border-top:1px dashed #cbd5e1;align-items:center;gap:10px;flex-wrap:wrap;font-size:11px;color:#64748b;}
.prod-item.open .prow-extra{display:flex;}
.prow-extra .finput{width:90px;text-align:center;}
.falt-tag{font-size:10px;font-weight:700;color:#b91c1c;background:#fee2e2;padding:1px 7px;border-radius:99px;}

/* Productos en móvil → tarjeta */
@media(max-width:760px){
    .phead{display:none;}
    .plist{overflow-x:visible;}
    .prow-grid{grid-template-columns:repeat(2,1fr);gap:8px 10px;text-align:left;}
    .prow-grid > .c-n{display:none;}
    .prow-grid > .c-prod{grid-column:1 / -1;}
    .prow-grid > [data-l]::before{
        content:attr(data-l);display:block;font-size:9.5px;font-weight:700;
        color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;
    }
    .prow-grid > .c-prog{display:block;}
    .prow-grid > .c-prog .pbar{margin:3px 0;}
    .prow-grid > .c-prog .pbar-t{text-align:left;}
    .prow-grid > .c-act{grid-column:1 / -1;justify-content:flex-end;}
    .cell-in{text-align:left;border-color:#e2e8f0;background:#fff;}
}

/* ── Bultos ── */
.b-head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:.8rem;}
.b-head-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.b-peso{font-size:11.5px;color:#64748b;}
.b-peso strong{color:#1d4ed8;}
.bcards{display:grid;grid-template-columns:repeat(auto-fill,minmax(112px,1fr));gap:10px;margin-bottom:.9rem;}
.bcard{
    position:relative;background:#fff;border:1px solid #e2e8f0;border-radius:12px;
    padding:.8rem .5rem;text-align:center;cursor:pointer;font-family:inherit;color:#0f172a;
    display:flex;flex-direction:column;align-items:center;gap:3px;
    transition:border-color .15s,box-shadow .15s,transform .15s;
}
.bcard:hover{border-color:#93c5fd;transform:translateY(-1px);}
.bcard.on{border-color:#2563eb;box-shadow:0 0 0 2px rgba(37,99,235,.18);background:#f5f9ff;}
.bcard-ico{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:2px;}
.bcard-ico .ic{width:22px;height:22px;}
.bcard-name{font-size:12.5px;font-weight:800;line-height:1.15;word-break:break-word;}
.bcard-kg{font-size:11.5px;color:#334155;font-weight:600;}
.bcard-dot{position:absolute;top:8px;right:8px;width:8px;height:8px;border-radius:50%;}
.bnuevo{margin:0;display:block;}
.nuevo-bulto-btn{
    width:100%;height:100%;min-height:112px;border:2px dashed #cbd5e1;border-radius:12px;
    display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;
    background:transparent;color:#64748b;font-size:11.5px;font-weight:600;cursor:pointer;font-family:inherit;
    transition:border-color .2s,color .2s,background .2s;
}
.nuevo-bulto-btn:hover{border-color:#2563eb;color:#2563eb;background:#f5f9ff;}
.nuevo-bulto-btn .ic{width:22px;height:22px;}

.bpanel{display:none;border:2px solid #2563eb;border-radius:14px;padding:.9rem;background:#fff;}
.bpanel.on{display:block;}
.bp-top{display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap;margin-bottom:.6rem;}
.bp-name{display:flex;align-items:center;gap:8px;font-size:17px;font-weight:800;}
.bp-name .ic{width:24px;height:24px;color:#ea580c;}
.bp-right{display:flex;align-items:center;gap:6px;}
.peso-badge{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;background:#dbeafe;color:#1d4ed8;padding:4px 10px;border-radius:7px;}
.peso-badge.heavy{background:#fef3c7;color:#b45309;}
.bp-meta{display:flex;gap:16px;flex-wrap:wrap;font-size:11px;color:#64748b;margin-bottom:.7rem;}
.bp-meta span{display:inline-flex;align-items:center;gap:5px;}
.bt-wrap{overflow-x:auto;}
.bt-head,.bt-row{display:grid;grid-template-columns:24px minmax(100px,1fr) 62px 66px 46px;gap:6px;align-items:center;}
.bt-head{background:#f1f5f9;border-radius:8px;padding:7px 10px;font-size:10.5px;font-weight:700;color:#475569;text-align:center;}
.bt-head > :nth-child(2),.bt-row > :nth-child(2){text-align:left;}
.bt-row{padding:8px 10px;font-size:12px;color:#334155;text-align:center;border-bottom:1px solid #f1f5f9;}
.bt-row:last-child{border-bottom:none;}
.bt-qty{font-weight:700;color:#1d4ed8;}
.bt-del{background:none;border:none;cursor:pointer;color:#dc2626;padding:4px;display:inline-flex;border-radius:6px;}
.bt-del:hover{background:#fee2e2;}
.bt-empty{font-size:11.5px;color:#94a3b8;text-align:center;padding:14px;}
.bp-bottom{display:grid;grid-template-columns:minmax(0,1.6fr) minmax(0,1fr);gap:10px;margin-top:.8rem;}
@media(max-width:560px){.bp-bottom{grid-template-columns:1fr;}}
.bp-add{background:#eff6ff;border:1px solid #dbeafe;border-radius:10px;padding:.7rem;}
.bp-add-t{font-size:12px;font-weight:700;color:#1d4ed8;margin-bottom:6px;}
.bp-add-row{display:flex;gap:6px;}
.bp-add-row .finput{flex:1;min-width:0;}
.bp-add-row .qty{flex:0 0 70px;text-align:center;}
.bp-peso{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:.7rem;}
.bp-peso-v{font-size:20px;font-weight:800;color:#1d4ed8;margin-top:4px;}
.bp-peso-v small{font-size:12px;color:#64748b;font-weight:600;}

/* Orden completa */
.done-row{display:flex;justify-content:space-between;align-items:center;background:#f8fafc;padding:8px 12px;border-radius:8px;margin-bottom:5px;border-left:3px solid #22c55e;gap:8px;}

/* ── Historial ── */
.hist-sum{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:1rem;}
.hist-chip{background:#f1f5f9;border:1px solid #e2e8f0;border-radius:10px;padding:.55rem .8rem;min-width:130px;}
.hist-chip small{display:block;font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:.04em;font-weight:700;}
.hist-chip b{font-size:13px;color:#0f172a;}
.tl-day{
    font-size:11px;font-weight:800;color:#1d4ed8;text-transform:capitalize;
    background:#eff6ff;border:1px solid #dbeafe;border-radius:99px;
    display:inline-block;padding:3px 12px;margin:.4rem 0 .7rem;
}
.tl{position:relative;margin-left:14px;padding-left:22px;border-left:2px solid #e2e8f0;}
.tl-item{position:relative;padding-bottom:.9rem;}
.tl-dot{
    position:absolute;left:-36px;top:0;width:28px;height:28px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;border:3px solid #fff;
    box-shadow:0 0 0 1px #e2e8f0;
}
.tl-dot .ic{width:13px;height:13px;}
.tl-orden .tl-dot{background:#dbeafe;color:#1d4ed8;}
.tl-bulto .tl-dot{background:#ffedd5;color:#ea580c;}
.tl-item-add .tl-dot{background:#dcfce7;color:#15803d;}
.tl-card{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:.55rem .8rem;}
.tl-top{display:flex;justify-content:space-between;align-items:center;gap:8px;}
.tl-title{font-size:12.5px;font-weight:700;color:#0f172a;}
.tl-time{font-size:11px;color:#64748b;font-weight:600;white-space:nowrap;}
.tl-sub{font-size:11.5px;color:#475569;margin-top:2px;}
.tl-prog{display:flex;align-items:center;gap:8px;margin-top:6px;font-size:10.5px;color:#64748b;}
.tl-prog .pbar{max-width:200px;}
.hist-note{font-size:11px;color:#94a3b8;margin-top:.4rem;}

/* ── Cámara (comportamiento original) ── */
#btnCamara,
#cameraScanner {
    display: none;
}

@media (max-width: 768px) {
    #btnCamara {
        display: inline-flex;
    }
}
</style>

@php
    // ── Helper de fechas (seguro si el campo viene nulo o como texto) ──
    $toCarbon = function($v){
        if(!$v) return null;
        try {
            return $v instanceof \Carbon\CarbonInterface ? $v : \Carbon\Carbon::parse($v);
        } catch(\Throwable $e) {
            return null;
        }
    };

    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d' : '#b45309';
    $estadoBg    = $order->estado === 'COMPLETO' ? '#dcfce7' : '#fef3c7';

    // Totales globales
    $totalUnidades = $order->details->sum('cantidad_solicitada');
    $totalEnBultos = 0;
    foreach($order->details as $item){
        foreach($order->bultos as $b){
            foreach($b->detalles as $d){
                if($d->product_id == $item->product_id)
                    $totalEnBultos += $d->cantidad;
            }
        }
    }
    $porcentajeGlobal = $totalUnidades > 0 ? ($totalEnBultos / $totalUnidades) * 100 : 0;
    $progColor = $porcentajeGlobal >= 100 ? '#22c55e' : ($porcentajeGlobal > 40 ? '#f59e0b' : '#ef4444');
    $barColor  = $porcentajeGlobal >= 100 ? '#22c55e' : '#2563eb';

    // Peso total de todos los bultos
    $pesoTotal = $order->bultos->sum('peso_total');

    // Conteos de estados de items
    $itemsCompletos = 0; $itemsParciales = 0; $itemsPendientes = 0;
    foreach($order->details as $item){
        $enB = 0;
        foreach($order->bultos as $b)
            foreach($b->detalles as $d)
                if($d->product_id == $item->product_id) $enB += $d->cantidad;
        if($enB >= $item->cantidad_solicitada) $itemsCompletos++;
        elseif($enB > 0) $itemsParciales++;
        else $itemsPendientes++;
    }

    // Productos con faltante (para el selector "agregar al bulto"; se calcula una sola vez)
    $opcionesBulto = [];
    if($order->estado != 'COMPLETO'){
        foreach($order->details as $d){
            $cantidadEnBultos = 0;
            foreach($order->bultos as $bultoDisponible) {
                foreach($bultoDisponible->detalles as $detalleBulto) {
                    if($detalleBulto->product_id == $d->product_id) {
                        $cantidadEnBultos += $detalleBulto->cantidad;
                    }
                }
            }
            $pendienteProducto = $d->cantidad_solicitada - $cantidadEnBultos;
            if($pendienteProducto > 0){
                $opcionesBulto[] = [
                    'id'     => $d->product->id,
                    'nombre' => $d->product->nombre,
                    'falta'  => $pendienteProducto,
                ];
            }
        }
    }

    // ── Historial del pedido (se arma solo con datos que ya existen) ──
    $idsOrden = $order->details->pluck('product_id')->all();
    $eventos  = [];
    $seq      = 0;

    $fOrden = $toCarbon($order->created_at);
    $eventos[] = [
        'ts' => $fOrden ? $fOrden->timestamp : 0, 'ord' => 0, 'seq' => $seq++,
        't' => $fOrden, 'tipo' => 'orden',
        'titulo' => 'Orden creada',
        'sub' => ($order->client->razon_social ?? '') . ' · ' . $order->details->count() . ' producto(s) · ' . $totalUnidades . ' unidades solicitadas',
    ];

    foreach($order->bultos as $b){
        $fB = $toCarbon($b->created_at);
        $eventos[] = [
            'ts' => $fB ? $fB->timestamp : 0, 'ord' => 1, 'seq' => $seq++,
            't' => $fB, 'tipo' => 'bulto',
            'titulo' => $b->nombre . ' creado',
            'sub' => 'Se abrió un nuevo bulto',
        ];
        foreach($b->detalles as $d){
            $fD = $toCarbon($d->created_at);
            $pesoLinea = isset($d->product->peso) ? ($d->product->peso / 1000) * $d->cantidad : 0;
            $eventos[] = [
                'ts' => $fD ? $fD->timestamp : 0, 'ord' => 2, 'seq' => $seq++,
                't' => $fD, 'tipo' => 'item',
                'titulo' => 'Producto agregado a ' . $b->nombre,
                'sub' => ($d->product->nombre ?? '—') . ' ×' . $d->cantidad . ' · ' . number_format($pesoLinea, 2) . ' kg',
                'cant' => in_array($d->product_id, $idsOrden) ? $d->cantidad : 0,
            ];
        }
    }

    usort($eventos, function($a, $b){
        return [$a['ts'], $a['ord'], $a['seq']] <=> [$b['ts'], $b['ord'], $b['seq']];
    });

    // Avance acumulado después de cada movimiento
    $acum = 0;
    foreach($eventos as $k => $e){
        if($e['tipo'] === 'item'){
            $acum += $e['cant'];
            $eventos[$k]['acum'] = $acum;
            $eventos[$k]['pct']  = $totalUnidades > 0 ? min(100, ($acum / $totalUnidades) * 100) : 0;
        }
    }

    // Agrupar por día
    $eventosPorDia = [];
    foreach($eventos as $e){
        $dia = $e['t'] ? $e['t']->copy()->locale('es')->translatedFormat('l, d \d\e F Y') : 'Sin fecha';
        $eventosPorDia[$dia][] = $e;
    }

    $primerEv = null; $ultimoEv = null;
    foreach($eventos as $e){
        if($e['t']){
            if(!$primerEv) $primerEv = $e['t'];
            $ultimoEv = $e['t'];
        }
    }
@endphp

<div class="pg">

{{-- ── Alertas de sesión ── --}}
@if(session('error'))
<div class="alert-box alert-err">⚠️ {{ session('error') }}</div>
@endif
@if(session('success'))
<div class="alert-box alert-ok">✅ {{ session('success') }}</div>
@endif

{{-- ── Breadcrumb ── --}}
<div class="crumbs">
    Despachos <span>/</span> <a href="/orders">Órdenes</a> <span>/</span> Encomienda
</div>

{{-- ── Header ── --}}
<div class="top-hdr">
    <div class="hdr-left">
        <div class="hdr-ico"><svg class="ic"><use href="#i-cube"/></svg></div>
        <div style="min-width:0;">
            <div class="hdr-title">
                <h1>{{ $order->numero_orden }}</h1>
                <span class="estado-badge" style="color:{{ $estadoColor }};background:{{ $estadoBg }};">
                    {{ $order->estado }}
                </span>
            </div>
            <div class="hdr-meta">
                <span>Cliente: <strong>{{ $order->client->razon_social ?? '' }}</strong></span>
                @if($toCarbon($order->created_at))
                <span>Fecha: <strong>{{ $toCarbon($order->created_at)->format('d/m/Y') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="hdr-right">
        @if($order->tipo_orden == 'ENCOMIENDA' && $order->estado != 'COMPLETO')
        <form method="POST" action="{{ route('orders.cerrar', $order) }}"
              onsubmit="return confirmarCierre()" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-green"><svg class="ic"><use href="#i-check"/></svg> Cerrar Encomienda</button>
        </form>
        @endif

        @if($order->bultos->count() > 0)
        <a href="{{ route('orders.bultos.etiquetas', $order) }}" target="_blank" class="btn btn-white">
            <svg class="ic"><use href="#i-print"/></svg> Imprimir etiquetas
        </a>
        @endif

        <a href="{{ route('orders.pdfEncomienda',$order) }}" target="_blank" class="btn btn-red">
            <svg class="ic"><use href="#i-file"/></svg> PDF Cliente
        </a>
    </div>
</div>

{{-- ── KPIs + Progreso ── --}}
<div class="top-row">
    <div class="kpis">
        <div class="kpi">
            <div class="kpi-icon" style="background:#dbeafe;color:#2563eb;"><svg class="ic ic-lg"><use href="#i-clip"/></svg></div>
            <div><div class="kpi-val">{{ $order->details->count() }}</div><div class="kpi-label">Productos en la orden</div></div>
        </div>
        <div class="kpi">
            <div class="kpi-icon" style="background:#dcfce7;color:#15803d;"><svg class="ic ic-lg"><use href="#i-check"/></svg></div>
            <div><div class="kpi-val" style="color:#15803d;">{{ $itemsCompletos }}</div><div class="kpi-label">Completos</div></div>
        </div>
        <div class="kpi">
            <div class="kpi-icon" style="background:#fef3c7;color:#d97706;"><svg class="ic ic-lg"><use href="#i-clock"/></svg></div>
            <div><div class="kpi-val" style="color:#d97706;">{{ $itemsParciales }}</div><div class="kpi-label">Parciales</div></div>
        </div>
        <div class="kpi">
            <div class="kpi-icon" style="background:#fee2e2;color:#dc2626;"><svg class="ic ic-lg"><use href="#i-alert"/></svg></div>
            <div><div class="kpi-val" style="color:#dc2626;">{{ $itemsPendientes }}</div><div class="kpi-label">Pendientes</div></div>
        </div>
        <div class="kpi">
            <div class="kpi-icon" style="background:#ede9fe;color:#7c3aed;"><svg class="ic ic-lg"><use href="#i-archive"/></svg></div>
            <div><div class="kpi-val">{{ $order->bultos->count() }}</div><div class="kpi-label">Bultos</div></div>
        </div>
        <div class="kpi k-blue">
            <div class="kpi-icon" style="background:#dbeafe;color:#1d4ed8;"><svg class="ic ic-lg"><use href="#i-scale"/></svg></div>
            <div><div class="kpi-val" style="color:#1d4ed8;">{{ number_format($pesoTotal,1) }} kg</div><div class="kpi-label">Peso total</div></div>
        </div>
    </div>

    <div class="prog-card">
        <div class="prog-top">
            <b>Progreso de embalaje</b>
            <span>{{ $totalEnBultos }} / {{ $totalUnidades }} unidades</span>
        </div>
        <div class="prog-row">
            <div class="prog-track">
                <div class="prog-fill" style="width:{{ min(100,$porcentajeGlobal) }}%;background:{{ $barColor }};"></div>
            </div>
            <div class="prog-pct" style="color:{{ $barColor }};">{{ number_format($porcentajeGlobal,0) }}%</div>
        </div>
    </div>
</div>

@if($order->estado != 'COMPLETO')

{{-- ── Scanner ── --}}
<div class="scanner-wrap">
    <div class="scanner-ico"><svg class="ic"><use href="#i-barcode"/></svg></div>
    <input type="text" id="scanner" class="scanner-input"
           placeholder="Escanea un producto para ver su estado en la orden...">
    <span class="scanner-hint">Enter para<br>confirmar</span>
    <button
    type="button"
    id="btnCamara"
    class="btn"
    style="
        background:#2563eb;
        color:white;
        white-space:nowrap;
        min-height:38px;
    "
>
    <svg class="ic"><use href="#i-camera"/></svg> Cámara
</button>
</div>

{{-- Lector de cámara (los ids los usa el script de más abajo) --}}
<div id="cameraScanner" class="cam-box">
    <div id="reader" style="width:100%;"></div>
    <button type="button" id="cerrarCamara" class="btn btn-gray">Cerrar cámara</button>
</div>

@endif

{{-- ── Pestañas ── --}}
<div class="enc-tabs" role="tablist">
    <button type="button" class="enc-tab on" data-tab="armado">
        <svg class="ic"><use href="#i-archive"/></svg> Armado de bultos
    </button>
    <button type="button" class="enc-tab" data-tab="historial">
        <svg class="ic"><use href="#i-history"/></svg> Historial del pedido
        <span class="tab-n">{{ count($eventos) }}</span>
    </button>
</div>

{{-- ═════════ PESTAÑA: ARMADO ═════════ --}}
<div class="enc-panel on" id="panel-armado">

@if($order->estado != 'COMPLETO')

{{-- ── Layout 2 columnas ── --}}
<div class="layout">

    {{-- ── COLUMNA IZQUIERDA: Productos ── --}}
    <div class="sec-card">
        <div class="sec-title">
            <div class="sec-title-left">
                <span class="sec-ico"><svg class="ic"><use href="#i-clip"/></svg></span>
                Productos de la orden
                <span class="count-pill">{{ $order->details->count() }}</span>
            </div>
            <button type="button" class="btn btn-blue" id="addProdBtn">
                <svg class="ic ic-sm"><use href="#i-plus"/></svg> Agregar producto
            </button>
        </div>

        {{-- Agregar producto --}}
        <div class="add-form-box" id="addProdBox">
            <form method="POST" action="{{ route('orders.addProduct',$order) }}">
                @csrf
                <div class="add-grid">
                    <div>
                        <label class="flabel">Producto</label>
                        <select name="product_id" class="finput" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} (Stock: {{ $p->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="flabel">Cantidad</label>
                        <input type="number" name="cantidad_solicitada" class="finput" placeholder="0" required>
                    </div>
                    <div>
                        <label class="flabel">Precio</label>
                        <input type="number" step="0.01" name="precio_unitario" class="finput" placeholder="0.00" required>
                    </div>
                    <button type="submit" class="btn btn-green" style="align-self:end;">+ Agregar</button>
                </div>
            </form>
        </div>

        {{-- Lista de productos --}}
        <div class="plist">
            <div class="phead">
                <span>#</span><span>Producto</span><span>Solicitado</span><span>En bultos</span>
                <span>Faltante</span><span>Progreso</span><span>Peso emb.</span><span>Precio</span><span>Acciones</span>
            </div>

            @foreach($order->details as $item)
            @php
                $enBultos = 0;
                $bultosUsados = [];
                foreach($order->bultos as $b){
                    foreach($b->detalles as $d){
                        if($d->product_id == $item->product_id){
                            $enBultos += $d->cantidad;
                            $bultosUsados[] = $b->nombre;
                        }
                    }
                }
                $faltante   = $item->cantidad_solicitada - $enBultos;
                $pct        = $item->cantidad_solicitada > 0 ? ($enBultos / $item->cantidad_solicitada) * 100 : 0;
                $lc         = $pct >= 100 ? '#22c55e' : ($pct > 0 ? '#f59e0b' : '#ef4444');
                $pesoItem   = isset($item->product->peso) ? ($item->product->peso / 1000) * $item->cantidad_solicitada : 0;
                $pesoEmb    = isset($item->product->peso) ? ($item->product->peso / 1000) * $enBultos : 0;
                $bultosStr  = count($bultosUsados) ? implode(', ', array_unique($bultosUsados)) : 'Sin bulto';
                $rowClass   = $pct >= 100 ? 'row-ok' : ($pct > 0 ? 'row-part' : 'row-pend');
            @endphp

            <form method="POST" action="{{ route('orders.updateDetail',$item) }}"
                  class="prod-item {{ $rowClass }}" style="border-left-color:{{ $lc }};">
                @csrf @method('PUT')

                <div class="prow-grid">
                    <div class="c-n">{{ $loop->iteration }}</div>

                    <div class="c-prod">
                        <div class="p-tile" style="color:{{ $lc }};"><svg class="ic"><use href="#i-cube"/></svg></div>
                        <div style="min-width:0;">
                            <div class="p-name">{{ $item->product->nombre }}</div>
                            <div class="p-sub">
                                ⚖ {{ number_format(($item->product->peso ?? 0)/1000,3) }} kg/u
                                · Bulto: <strong>{{ $bultosStr }}</strong>
                            </div>
                        </div>
                    </div>

                    <div data-l="Solicitado">
                        <input type="number" name="cantidad_solicitada" class="cell-in"
                               value="{{ $item->cantidad_solicitada }}">
                    </div>

                    <div data-l="En bultos">{{ $enBultos }}</div>

                    <div data-l="Faltante">
                        @if($faltante > 0)
                            <span class="c-falt-n">{{ $faltante }}</span>
                        @elseif($faltante < 0)
                            <span style="color:#d97706;font-weight:700;">+{{ abs($faltante) }}</span>
                        @else
                            <span class="c-falt-0">0</span>
                        @endif
                    </div>

                    <div class="c-prog" data-l="Progreso">
                        <div class="pbar"><i style="width:{{ min(100,$pct) }}%;background:{{ $lc }};"></i></div>
                        <span class="pbar-t" style="color:{{ $lc }};">{{ number_format($pct,0) }}%</span>
                    </div>

                    <div data-l="Peso emb.">{{ number_format($pesoEmb,2) }} kg</div>

                    <div data-l="Precio">
                        <input type="number" step="0.01" name="precio_unitario" class="cell-in cell-price"
                               value="{{ $item->precio_unitario }}" placeholder="Precio">
                    </div>

                    <div class="c-act">
                        <button type="submit" class="sq-btn primary" title="Guardar cambios"><svg class="ic"><use href="#i-file"/></svg></button>
                        <button type="button" class="sq-btn js-more" title="Más opciones"><svg class="ic"><use href="#i-more"/></svg></button>
                    </div>
                </div>

                <div class="prow-extra">
                    <label for="cd{{ $item->id }}">Cant. despachada</label>
                    <input type="number" id="cd{{ $item->id }}" name="cantidad_despachada" class="finput"
                           value="{{ $item->cantidad_despachada }}">
                    @if($faltante > 0)
                        <span class="falt-tag">Faltan {{ $faltante }}</span>
                    @endif
                    <span style="margin-left:auto;">Se guarda con el botón azul</span>
                </div>
            </form>
            @endforeach
        </div>
    </div>

    {{-- ── COLUMNA DERECHA: Bultos ── --}}
    <div class="sec-card">

        <div class="b-head">
            <div class="sec-title-left sec-title" style="margin:0;">
                <span class="sec-ico"><svg class="ic"><use href="#i-archive"/></svg></span>
                Bultos ({{ $order->bultos->count() }})
            </div>
            <div class="b-head-right">
                <span class="b-peso">Peso total: <strong>{{ number_format($pesoTotal,2) }} kg</strong></span>

                {{-- Crear nuevo bulto --}}
                <form method="POST" action="{{ route('bultos.crear',$order) }}">
                    @csrf
                    <button type="submit" class="btn btn-blue">
                        <svg class="ic ic-sm"><use href="#i-plus"/></svg> Nuevo bulto
                    </button>
                </form>
            </div>
        </div>

        {{-- Tarjetas de bultos --}}
        <div class="bcards">
            @php
                $coloresBulto = [
                    ['#ffedd5', '#ea580c'],
                    ['#fef3c7', '#d97706'],
                    ['#ede9fe', '#7c3aed'],
                    ['#dbeafe', '#2563eb'],
                    ['#dcfce7', '#16a34a'],
                ];
            @endphp
            @foreach($order->bultos as $bulto)
            @php
                $cb = $coloresBulto[$loop->index % count($coloresBulto)];
            @endphp
            <button type="button" class="bcard {{ $loop->first ? 'on' : '' }}" data-bulto="{{ $bulto->id }}">
                <span class="bcard-dot" style="background:{{ $bulto->detalles->count() > 0 ? '#22c55e' : '#f59e0b' }};"></span>
                <span class="bcard-ico" style="background:{{ $cb[0] }};color:{{ $cb[1] }};"><svg class="ic"><use href="#i-cube"/></svg></span>
                <span class="bcard-name">{{ $bulto->nombre }}</span>
                <span class="bcard-kg">{{ number_format($bulto->peso_total ?? 0,1) }} kg</span>
            </button>
            @endforeach

            {{-- Placeholder nuevo bulto --}}
            <form method="POST" action="{{ route('bultos.crear',$order) }}" class="bnuevo">
                @csrf
                <button type="submit" class="nuevo-bulto-btn">
                    <svg class="ic"><use href="#i-plus"/></svg>
                    <span>Nuevo bulto</span>
                </button>
            </form>
        </div>

        {{-- Detalle del bulto seleccionado --}}
        @foreach($order->bultos as $bulto)
        @php
            $pesoB = $bulto->peso_total ?? 0;
            $isHeavy = $pesoB > 20;
        @endphp
        <div class="bpanel {{ $loop->first ? 'on' : '' }}" data-bulto="{{ $bulto->id }}">

            <div class="bp-top">
                <div class="bp-name"><svg class="ic"><use href="#i-cube"/></svg> {{ $bulto->nombre }}</div>
                <div class="bp-right">
                    <div class="peso-badge {{ $isHeavy ? 'heavy' : '' }}">
                        Peso: {{ number_format($pesoB,2) }} kg {{ $isHeavy ? '⚠' : '' }}
                    </div>
                    <a href="{{ route('orders.bulto.etiqueta', $bulto) }}" target="_blank"
                       title="Imprimir etiqueta del bulto" class="sq-btn">
                        <svg class="ic"><use href="#i-print"/></svg>
                    </a>
                    <button type="button" class="sq-btn js-close-bulto" title="Cerrar detalle">
                        <svg class="ic"><use href="#i-x"/></svg>
                    </button>
                </div>
            </div>

            <div class="bp-meta">
                <span><svg class="ic ic-sm"><use href="#i-clip"/></svg> Productos: {{ $bulto->detalles->count() }}</span>
                @if($toCarbon($bulto->created_at))
                <span><svg class="ic ic-sm"><use href="#i-cal"/></svg> Fecha creación: {{ $toCarbon($bulto->created_at)->format('d/m/Y') }}</span>
                @endif
            </div>

            <div class="bt-wrap">
                <div class="bt-head"><span>#</span><span>Producto</span><span>Cantidad</span><span>Peso</span><span></span></div>

                @forelse($bulto->detalles as $det)
                @php
                    $pesoLineaB = isset($det->product->peso) ? ($det->product->peso / 1000) * $det->cantidad : 0;
                @endphp
                <div class="bt-row">
                    <span style="color:#64748b;font-weight:600;">{{ $loop->iteration }}</span>
                    <span>{{ $det->product->nombre }}</span>
                    <span class="bt-qty">×{{ $det->cantidad }}</span>
                    <span>{{ number_format($pesoLineaB,2) }} kg</span>
                    <form method="POST" action="{{ route('bultos.eliminar',$det) }}"
                          onsubmit="return confirm('¿Eliminar del bulto?')" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="bt-del" title="Eliminar del bulto"><svg class="ic"><use href="#i-trash"/></svg></button>
                    </form>
                </div>
                @empty
                <div class="bt-empty">Bulto vacío</div>
                @endforelse
            </div>

            <div class="bp-bottom">
                {{-- Agregar al bulto --}}
                <form method="POST" action="{{ route('bultos.agregar',$bulto) }}" class="bp-add">
                    @csrf
                    <div class="bp-add-t">Agregar producto al bulto</div>
                    <div class="bp-add-row">
                        <select name="product_id" class="finput" required>
                            <option value="">+ Seleccionar producto</option>
                            @foreach($opcionesBulto as $op)
                                <option value="{{ $op['id'] }}">
                                    {{ $op['nombre'] }}
                                    — faltan {{ number_format($op['falta'], 0) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="cantidad" class="finput qty" placeholder="Cant." required>
                        <button type="submit" class="btn btn-blue" title="Agregar">+</button>
                    </div>
                </form>

                {{-- Peso del bulto (solo lectura: se calcula con los productos) --}}
                <div class="bp-peso">
                    <div class="flabel" style="margin:0;">Peso del bulto</div>
                    <div class="bp-peso-v">{{ number_format($pesoB,2) }} <small>kg</small></div>
                </div>
            </div>
        </div>
        @endforeach

        @if($order->bultos->count() == 0)
        <div class="bt-empty" style="border:2px dashed #e2e8f0;border-radius:12px;">
            Aún no hay bultos. Crea el primero con «Nuevo bulto».
        </div>
        @endif
    </div>
</div>

@else

{{-- ── VISTA ORDEN COMPLETA ── --}}
<div class="sec-card">
    <div class="sec-title"><div class="sec-title-left">
        <span class="sec-ico"><svg class="ic"><use href="#i-archive"/></svg></span> Productos enviados
    </div></div>
    @foreach($order->bultos as $bulto)
        @foreach($bulto->detalles as $det)
        <div class="done-row">
            <span style="font-size:13px;font-weight:500;color:#0f172a;">{{ $det->product->nombre }}</span>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:12px;color:#64748b;">×{{ $det->cantidad }}</span>
                <form method="POST" action="{{ route('bultos.eliminar',$det) }}"
                      onsubmit="return confirm('¿Eliminar?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-red" style="padding:4px 8px;font-size:11px;"><svg class="ic ic-sm"><use href="#i-trash"/></svg></button>
                </form>
            </div>
        </div>
        @endforeach
    @endforeach
</div>

@endif

</div>{{-- /panel-armado --}}

{{-- ═════════ PESTAÑA: HISTORIAL DEL PEDIDO ═════════ --}}
<div class="enc-panel" id="panel-historial">
    <div class="sec-card">
        <div class="sec-title">
            <div class="sec-title-left">
                <span class="sec-ico"><svg class="ic"><use href="#i-history"/></svg></span>
                Historial del pedido
                <span class="count-pill">{{ count($eventos) }}</span>
            </div>
        </div>

        <div class="hist-sum">
            <div class="hist-chip">
                <small>Inicio</small>
                <b>{{ $primerEv ? $primerEv->format('d/m/Y H:i') : '—' }}</b>
            </div>
            <div class="hist-chip">
                <small>Último movimiento</small>
                <b>{{ $ultimoEv ? $ultimoEv->format('d/m/Y H:i') : '—' }}</b>
            </div>
            <div class="hist-chip">
                <small>Duración del armado</small>
                <b>{{ ($primerEv && $ultimoEv) ? $primerEv->copy()->locale('es')->diffForHumans(['other' => $ultimoEv, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]) : '—' }}</b>
            </div>
            <div class="hist-chip">
                <small>Avance actual</small>
                <b>{{ $totalEnBultos }} / {{ $totalUnidades }} · {{ number_format($porcentajeGlobal,0) }}%</b>
            </div>
        </div>

        @foreach($eventosPorDia as $dia => $evs)
            <div class="tl-day">{{ $dia }}</div>
            <div class="tl">
                @foreach($evs as $e)
                <div class="tl-item tl-{{ $e['tipo'] }} {{ $e['tipo'] === 'item' ? 'tl-item-add' : '' }}">
                    <div class="tl-dot">
                        @if($e['tipo'] === 'orden')
                            <svg class="ic"><use href="#i-clip"/></svg>
                        @elseif($e['tipo'] === 'bulto')
                            <svg class="ic"><use href="#i-archive"/></svg>
                        @else
                            <svg class="ic"><use href="#i-plus"/></svg>
                        @endif
                    </div>
                    <div class="tl-card">
                        <div class="tl-top">
                            <span class="tl-title">{{ $e['titulo'] }}</span>
                            <span class="tl-time">{{ $e['t'] ? $e['t']->format('H:i') : '--:--' }}</span>
                        </div>
                        <div class="tl-sub">{{ $e['sub'] }}</div>
                        @if(isset($e['acum']))
                        <div class="tl-prog">
                            <div class="pbar"><i style="width:{{ $e['pct'] }}%;background:{{ $e['pct'] >= 100 ? '#22c55e' : '#2563eb' }};"></i></div>
                            <span>{{ $e['acum'] }} / {{ $totalUnidades }} unidades · {{ number_format($e['pct'],0) }}%</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach

        <div class="hist-note">
            Muestra la creación de la orden, de los bultos y los productos agregados a cada uno.
            Lo que se elimina de un bulto deja de aparecer.
        </div>
    </div>
</div>

</div>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
let scanner = document.getElementById('scanner');
if(scanner){
    scanner.addEventListener('keydown', function(e){
        if(e.key !== 'Enter') return;
        e.preventDefault();
        const codigo = this.value.trim();
        if(!codigo) return;

        fetch(`/api/producto/${codigo}`)
        .then(r => r.json())
        .then(prod => {
            if(!prod){ alert('❌ Producto no encontrado'); this.value=''; return; }
            const items = document.querySelectorAll('.prod-item');
            let found = false;
            items.forEach(el => {
                if(el.textContent.includes(prod.nombre)){
                    el.scrollIntoView({behavior:'smooth',block:'center'});
                    el.style.boxShadow = '0 0 0 2px #2563eb';
                    setTimeout(()=>{ el.style.boxShadow=''; }, 1500);
                    found = true;
                }
            });
            if(!found) alert('⚠ Producto no está en esta orden');
        })
        .catch(()=>{ alert('❌ Error al buscar producto'); });

        this.value = '';
    });
}

function confirmarCierre(){
    @php
        $faltantesJs = $order->details->filter(function($item) use ($order){
            $enB = 0;
            foreach($order->bultos as $b)
                foreach($b->detalles as $d)
                    if($d->product_id == $item->product_id) $enB += $d->cantidad;
            return $enB < $item->cantidad_solicitada;
        })->map(function($item) use ($order){
            $enB = 0;
            foreach($order->bultos as $b)
                foreach($b->detalles as $d)
                    if($d->product_id == $item->product_id) $enB += $d->cantidad;
            return ['nombre' => $item->product->nombre, 'falta' => $item->cantidad_solicitada - $enB];
        });
    @endphp

    const faltantes = @json($faltantesJs);
    if(faltantes.length === 0)
        return confirm('✅ Todo embalado.\n\n¿Cerrar la encomienda?');
    const lista = faltantes.map(f => `• ${f.nombre} (faltan ${f.falta})`).join('\n');
    return confirm('⚠️ Productos sin embalaje completo:\n\n' + lista + '\n\n¿Cerrar encomienda de todas formas?');
}
/*
|--------------------------------------------------------------------------
| ACTIVAR ESCÁNER DE CÁMARA SOLO EN DISPOSITIVOS PEQUEÑOS
|--------------------------------------------------------------------------
*/

function configurarCamaraMovil()
{
    const btn =
        document.getElementById('btnCamara');

    const camera =
        document.getElementById('cameraScanner');

    if(!btn || !camera){
        return;
    }

    if(esDispositivoPequeno()){

        btn.style.display =
            'inline-flex';

    }else{

        btn.style.display =
            'none';

        camera.style.display =
            'none';

    }
}
let lectorCamara = null;

const btnCamara = document.getElementById('btnCamara');
const cameraScanner = document.getElementById('cameraScanner');
const cerrarCamara = document.getElementById('cerrarCamara');

if (btnCamara) {

    btnCamara.addEventListener('click', async function () {

        cameraScanner.style.display = 'block';

        btnCamara.disabled = true;

        lectorCamara = new Html5Qrcode('reader');

        try {

            await lectorCamara.start(
                {
                    facingMode: 'environment'
                },
                {
                    fps: 10,
                    qrbox: {
                        width: 280,
                        height: 120
                    }
                },
                function (codigo) {

                    codigo = codigo.trim();

                    if (!codigo) {
                        return;
                    }

                    /*
                     * Colocamos el código detectado
                     * en el mismo campo del scanner.
                     */
                    scanner.value = codigo;

                    cerrarLectorCamara();

                    /*
                     * Ejecutamos exactamente el mismo
                     * proceso que utiliza el lector físico.
                     */
                    scanner.dispatchEvent(
                        new KeyboardEvent('keydown', {
                            key: 'Enter',
                            code: 'Enter',
                            bubbles: true
                        })
                    );

                },
                function () {
                    // Ignorar errores normales de lectura
                }
            );

        } catch (error) {

            console.error(error);

            alert(
                'No se pudo acceder a la cámara. ' +
                'Verifica que hayas permitido el acceso.'
            );

            cerrarLectorCamara();
        }

    });

}


if (cerrarCamara) {

    cerrarCamara.addEventListener(
        'click',
        function () {

            cerrarLectorCamara();

        }
    );

}


async function cerrarLectorCamara()
{
    if (lectorCamara) {

        try {

            await lectorCamara.stop();

        } catch (error) {

            console.log(
                'La cámara ya estaba detenida.'
            );

        }

        try {

            await lectorCamara.clear();

        } catch (error) {}

        lectorCamara = null;
    }

    cameraScanner.style.display = 'none';

    btnCamara.disabled = false;
}
</script>

{{-- ── Interfaz: pestañas, selección de bulto y filas (no toca la lógica de arriba) ── --}}
<script>
(function () {
    var oid  = '{{ $order->id }}';
    var kTab = 'enc_tab_' + oid;
    var kBul = 'enc_bulto_' + oid;

    function sget(k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } }
    function sset(k, v) { try { sessionStorage.setItem(k, v); } catch (e) {} }
    function each(list, fn) { Array.prototype.forEach.call(list, fn); }

    /* ── Pestañas ── */
    var tabs   = document.querySelectorAll('.enc-tab');
    var panels = document.querySelectorAll('.enc-panel');

    window.mostrarTabEnc = function (name) {
        each(tabs, function (t) { t.classList.toggle('on', t.getAttribute('data-tab') === name); });
        each(panels, function (p) { p.classList.toggle('on', p.id === 'panel-' + name); });
        sset(kTab, name);
    };
    each(tabs, function (t) {
        t.addEventListener('click', function () { window.mostrarTabEnc(t.getAttribute('data-tab')); });
    });
    var tabGuardada = sget(kTab);
    if (tabGuardada && document.getElementById('panel-' + tabGuardada)) {
        window.mostrarTabEnc(tabGuardada);
    }

    /* El lector/cámara siempre te lleva a la pestaña de armado */
    var sc = document.getElementById('scanner');
    if (sc) {
        sc.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') window.mostrarTabEnc('armado');
        });
    }

    /* ── Bultos: seleccionar uno para ver su detalle ── */
    var cards = document.querySelectorAll('.bcard');
    var bps   = document.querySelectorAll('.bpanel');

    function selBulto(id) {
        each(cards, function (c) { c.classList.toggle('on', c.getAttribute('data-bulto') === id); });
        each(bps,   function (p) { p.classList.toggle('on', p.getAttribute('data-bulto') === id); });
        sset(kBul, id);
    }
    each(cards, function (c) {
        c.addEventListener('click', function () { selBulto(c.getAttribute('data-bulto')); });
    });
    each(document.querySelectorAll('.js-close-bulto'), function (b) {
        b.addEventListener('click', function () { selBulto(''); });
    });

    /* Al recargar tras agregar/eliminar, se mantiene el bulto que estabas armando */
    var guardado = sget(kBul);
    if (guardado !== null) {
        var existe = false;
        each(cards, function (c) { if (c.getAttribute('data-bulto') === guardado) existe = true; });
        if (existe || guardado === '') selBulto(guardado);
    }

    /* ── Agregar producto (panel colapsable) ── */
    var addBtn = document.getElementById('addProdBtn');
    var addBox = document.getElementById('addProdBox');
    if (addBtn && addBox) {
        addBtn.addEventListener('click', function () { addBox.classList.toggle('open'); });
    }

    /* ── Fila de producto: opciones extra (cantidad despachada) ── */
    each(document.querySelectorAll('.js-more'), function (b) {
        b.addEventListener('click', function () {
            var row = b.closest('.prod-item');
            if (row) row.classList.toggle('open');
        });
    });
})();
</script>

@endsection