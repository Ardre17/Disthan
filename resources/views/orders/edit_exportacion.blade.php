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

/* ══════════════════════════════════════════════════════════
   EXPORTACIÓN · rediseño (prefijo ex-) — aditivo, no pisa lo anterior
══════════════════════════════════════════════════════════ */
.ex{
    --ex-navy:#1e3a5f; --ex-blue:#1d7ff2; --ex-blue-soft:#eaf2ff;
    --ex-green:#16a34a; --ex-green-soft:#dcfce7;
    --ex-orange:#f59e0b; --ex-orange-soft:#fef3c7;
    --ex-red:#ef4444; --ex-red-soft:#fee2e2;
    --ex-purple:#7c3aed; --ex-purple-soft:#ede9fe;
    --ex-text:#0f172a; --ex-muted:#64748b; --ex-line:#e2e8f0; --ex-bg:#f8fafc;
    --ex-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
    color:var(--ex-text);
}
.ex-i{width:16px;height:16px;flex-shrink:0;}
.ex-num{font-family:var(--ex-mono);font-variant-numeric:tabular-nums;}
.ex-card{background:#fff;border:1px solid var(--ex-line);border-radius:14px;padding:14px 16px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.ex-card-t{display:flex;align-items:center;gap:8px;font-size:15px;font-weight:800;margin:0 0 12px;}
.ex-card-t .ex-ico{width:26px;height:26px;border-radius:7px;background:var(--ex-blue-soft);color:var(--ex-blue);display:inline-flex;align-items:center;justify-content:center;}
.ex-card-t .ex-ico .ex-i{width:15px;height:15px;}
.ex-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 11px;border-radius:99px;font-size:12px;font-weight:700;}

/* Breadcrumb + cabecera */
.ex-crumb{font-size:12.5px;color:var(--ex-muted);margin-bottom:10px;}
.ex-crumb a{color:var(--ex-muted);text-decoration:none;}
.ex-crumb a:hover{color:var(--ex-blue);}
.ex-crumb b{color:var(--ex-text);font-weight:600;}
.ex-head{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:14px;}
.ex-head-l{display:flex;align-items:center;gap:14px;flex-wrap:wrap;}
.ex-ship{width:62px;height:62px;border-radius:14px;background:#fff;border:1px solid var(--ex-line);color:var(--ex-navy);display:flex;align-items:center;justify-content:center;box-shadow:0 1px 2px rgba(15,23,42,.05);}
.ex-ship .ex-i{width:32px;height:32px;}
.ex-ord{font-size:26px;font-weight:800;color:var(--ex-navy);font-family:var(--ex-mono);letter-spacing:-.5px;line-height:1;}
.ex-meta{display:flex;gap:18px;flex-wrap:wrap;margin-top:8px;font-size:12.5px;color:var(--ex-muted);}
.ex-meta b{color:var(--ex-text);font-weight:600;margin-left:4px;}
.ex-head-r{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.ex-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;border:1px solid transparent;font-family:inherit;transition:filter .15s,background .15s;}
.ex-btn:hover{filter:brightness(.95);}
.ex-btn.green{background:#16a34a;color:#fff;}
.ex-btn.red{background:#ef4444;color:#fff;}
.ex-btn.white{background:#fff;color:var(--ex-text);border-color:var(--ex-line);}
.ex-btn.blue{background:var(--ex-blue);color:#fff;}
.ex-btn.sm{padding:7px 12px;font-size:12px;}
.ex-btn.is-off{opacity:.45;cursor:not-allowed;}
.ex-split{display:inline-flex;}
.ex-split .ex-btn:first-child{border-radius:9px 0 0 9px;}
.ex-split .ex-btn:last-child{border-radius:0 9px 9px 0;border-left:none;padding:10px 11px;}

/* Dropdown simple */
.ex-dd{position:relative;}
.ex-dd-menu{display:none;position:absolute;right:0;top:calc(100% + 6px);min-width:210px;background:#fff;border:1px solid var(--ex-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.14);padding:6px;z-index:60;}
.ex-dd.open .ex-dd-menu{display:block;}
.ex-dd-item{display:flex;align-items:center;gap:9px;width:100%;padding:9px 10px;border:none;background:none;border-radius:7px;font-size:13px;color:#1e293b;cursor:pointer;text-decoration:none;font-family:inherit;text-align:left;}
.ex-dd-item:hover{background:#f1f5f9;}
.ex-dd-item.danger{color:#b91c1c;}

/* KPIs */
.ex-kpis{display:grid;grid-template-columns:1.1fr 1.1fr 1.1fr 1px .85fr .85fr 1fr 2.1fr;gap:10px;margin-bottom:14px;align-items:stretch;}
@media(max-width:1280px){.ex-kpis{grid-template-columns:repeat(3,1fr);}.ex-kpis .ex-vsep{display:none;}.ex-kpis .ex-prog{grid-column:1/-1;}}
@media(max-width:560px){.ex-kpis{grid-template-columns:1fr 1fr;}}
.ex-vsep{background:var(--ex-line);}
.ex-k{display:flex;align-items:center;gap:11px;border-radius:12px;padding:12px 13px;border:1px solid var(--ex-line);background:#fff;}
.ex-k-ic{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ex-k-ic .ex-i{width:22px;height:22px;}
.ex-k b{display:block;font-size:20px;font-weight:800;line-height:1.05;font-family:var(--ex-mono);}
.ex-k small{font-size:11px;color:var(--ex-muted);}
.ex-k.t-blue{background:#eef5ff;border-color:#dbe8ff;}.ex-k.t-blue .ex-k-ic{background:#dbeafe;color:#2563eb;}
.ex-k.t-green{background:#effcf3;border-color:#c9f0d5;}.ex-k.t-green .ex-k-ic{background:#d1fae5;color:#16a34a;}
.ex-k.t-orange{background:#fffaeb;border-color:#fde7b0;}.ex-k.t-orange .ex-k-ic{background:#fef3c7;color:#d97706;}
.ex-k.t-plain .ex-k-ic{background:#eef2f7;color:#334155;}
.ex-k.t-purple .ex-k-ic{background:#ede9fe;color:#7c3aed;}
.ex-prog{background:#fff;border:1px solid var(--ex-line);border-radius:12px;padding:12px 16px;display:flex;flex-direction:column;justify-content:center;gap:7px;min-width:240px;}
.ex-prog-top{display:flex;justify-content:space-between;align-items:flex-end;font-size:12.5px;font-weight:700;gap:10px;}
.ex-prog-top span{color:var(--ex-muted);font-weight:500;font-size:12px;}
.ex-prog-row{display:flex;align-items:center;gap:12px;}
.ex-bar{flex:1;height:10px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.ex-bar > div{height:100%;border-radius:99px;transition:width .3s;}
.ex-prog-pct{font-size:20px;font-weight:800;color:var(--ex-blue);font-family:var(--ex-mono);}
.ex-obj-link{background:none;border:none;color:var(--ex-blue);font-size:11px;font-weight:600;cursor:pointer;padding:0;font-family:inherit;text-align:left;}
.ex-obj-form{display:none;align-items:flex-end;gap:6px;margin-top:2px;}
.ex-obj-form.open{display:flex;}

/* Tabs */
.ex-tabs{display:flex;gap:4px;border-bottom:1px solid var(--ex-line);margin-bottom:14px;overflow-x:auto;}
.ex-tab{background:none;border:none;padding:11px 16px;font-size:13.5px;font-weight:600;color:var(--ex-muted);cursor:pointer;display:inline-flex;align-items:center;gap:8px;border-bottom:3px solid transparent;margin-bottom:-1px;white-space:nowrap;font-family:inherit;}
.ex-tab.on{color:var(--ex-blue);border-bottom-color:var(--ex-blue);}
.ex-tab em{font-style:normal;background:#eef2f7;color:#475569;border-radius:99px;font-size:11px;padding:1px 8px;font-weight:700;}
.ex-tab.on em{background:var(--ex-blue-soft);color:var(--ex-blue);}
.ex-pane{display:none;}
.ex-pane.on{display:block;}

/* Escáner */
.ex-scan{display:flex;align-items:center;gap:12px;background:#10244a;border-radius:12px;padding:12px 14px;margin-bottom:6px;flex-wrap:wrap;}
.ex-scan-ic{color:#fff;opacity:.9;display:flex;}
.ex-scan-ic .ex-i{width:34px;height:34px;}
.ex-scan input{flex:1;min-width:200px;height:40px;padding:0 14px;border-radius:9px;border:1px solid rgba(255,255,255,.18);background:rgba(255,255,255,.08);color:#fff;font-size:13px;outline:none;font-family:inherit;}
.ex-scan input::placeholder{color:#9db2d3;}
.ex-scan input:focus{border-color:#5eb0ff;background:rgba(255,255,255,.14);}
.ex-scan-hint{font-size:11px;color:#9db2d3;line-height:1.25;text-align:center;}
.ex-scan-res{display:none;margin-bottom:14px;padding:10px 14px;border-radius:10px;font-size:13px;align-items:center;gap:10px;flex-wrap:wrap;}
.ex-scan-res.show{display:flex;}
.ex-scan-res.ok{background:#effcf3;border:1px solid #c9f0d5;color:#166534;}
.ex-scan-res.warn{background:#fffaeb;border:1px solid #fde7b0;color:#92400e;}
.ex-scan-res.err{background:#fff1f1;border:1px solid #fecaca;color:#b91c1c;}
.ex-scan-res b{font-weight:800;}
.ex-scan-gap{height:14px;}

/* Grid principal */
.ex-main{display:grid;grid-template-columns:minmax(0,1.04fr) minmax(0,1fr);gap:14px;align-items:start;}
@media(max-width:1180px){.ex-main{grid-template-columns:1fr;}}

/* Tabla productos */
.ex-ptools{display:flex;gap:8px;align-items:center;margin-left:auto;flex-wrap:wrap;}
.ex-search{position:relative;}
.ex-search .ex-i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;width:15px;height:15px;}
.ex-search input{padding:8px 12px 8px 32px;border:1px solid var(--ex-line);border-radius:9px;font-size:13px;width:190px;outline:none;font-family:inherit;}
.ex-search input:focus{border-color:var(--ex-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);}
.ex-count{background:var(--ex-blue-soft);color:var(--ex-blue);border-radius:99px;padding:2px 10px;font-size:12px;font-weight:800;}
.ex-addbox{display:none;background:var(--ex-bg);border:1px solid var(--ex-line);border-radius:10px;padding:12px;margin-bottom:12px;}
.ex-addbox.open{display:block;}
.ex-scroll{overflow-x:auto;}
.ex-tbl{width:100%;min-width:760px;border-collapse:separate;border-spacing:0;font-size:12.5px;}
.ex-tbl th{background:#f1f5f9;color:#475569;font-size:11px;font-weight:700;padding:9px 8px;text-align:center;white-space:nowrap;}
.ex-tbl th.l{text-align:left;}
.ex-tbl td{padding:8px;border-bottom:1px solid #eef2f7;vertical-align:middle;text-align:center;}
.ex-tbl td.l{text-align:left;}
.ex-tbl tr.ex-prow:hover td{background:#fafcff;}
.ex-tbl td.ex-stripe{box-shadow:inset 4px 0 0 var(--c,#94a3b8);width:34px;font-family:var(--ex-mono);font-size:12px;}
.ex-prod{display:flex;align-items:center;gap:9px;min-width:170px;text-align:left;}
.ex-thumb{width:34px;height:34px;border-radius:7px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:17px;flex-shrink:0;}
.ex-thumb img{width:100%;height:100%;object-fit:cover;}
.ex-sku{font-size:11px;color:#64748b;font-family:var(--ex-mono);}
.ex-pname{font-size:12.5px;font-weight:600;line-height:1.2;}
.ex-pg{display:flex;align-items:center;gap:7px;min-width:130px;}
.ex-pg .ex-bar{height:8px;}
.ex-pg b{font-family:var(--ex-mono);font-size:11.5px;min-width:36px;text-align:right;}
.ex-act{display:flex;gap:6px;justify-content:center;}
.ex-ic{width:34px;height:34px;border:1px solid var(--ex-line);background:#fff;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;color:#475569;padding:0;}
.ex-ic:hover{background:#f1f5f9;}
.ex-ic.blue{background:var(--ex-blue);border-color:var(--ex-blue);color:#fff;}
.ex-ic.blue:hover{filter:brightness(.92);}
.ex-ic.red{color:#dc2626;border-color:#fecaca;background:#fff5f5;}
.ex-ic.sm{width:28px;height:28px;border-radius:7px;}
.ex-ic .ex-i{width:15px;height:15px;}
.ex-empty{display:none;text-align:center;padding:22px;color:var(--ex-muted);font-size:13px;}
@keyframes exHit{0%{background:#fde68a;}100%{background:transparent;}}
.ex-prow.ex-hit td{animation:exHit 2.2s ease;}
.ex-rmenu{display:none;position:fixed;z-index:950;min-width:200px;background:#fff;border:1px solid var(--ex-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.18);padding:6px;}
.ex-rmenu.open{display:block;}

/* Paletas */
.ex-ph{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px;}
.ex-ph .ex-card-t{margin:0;}
.ex-ph-w{margin-left:auto;font-size:12.5px;color:#475569;}
.ex-newpal{display:none;align-items:center;gap:8px;background:var(--ex-bg);border:1px solid var(--ex-line);border-radius:10px;padding:10px 12px;margin-bottom:12px;flex-wrap:wrap;}
.ex-newpal.open{display:flex;}
.ex-newpal input{width:80px;padding:7px 8px;border:1px solid #cbd5e1;border-radius:7px;font-size:13px;font-weight:700;text-align:center;font-family:var(--ex-mono);}
.ex-pcards{display:grid;grid-template-columns:repeat(auto-fill,minmax(104px,1fr));gap:9px;margin-bottom:12px;}
.ex-pcard{position:relative;border:1px solid var(--ex-line);border-radius:12px;padding:10px 8px 9px;text-align:center;cursor:pointer;background:#fff;transition:box-shadow .15s,transform .15s,border-color .15s;user-select:none;}
.ex-pcard:hover{box-shadow:0 6px 16px rgba(15,23,42,.1);transform:translateY(-2px);}
.ex-pcard.on{border:2px solid var(--ex-blue);background:#f5f9ff;padding:9px 7px 8px;}
.ex-pcard.on::after{content:'';position:absolute;left:50%;bottom:-9px;width:14px;height:14px;background:#f5f9ff;border-right:2px solid var(--ex-blue);border-bottom:2px solid var(--ex-blue);transform:translateX(-50%) rotate(45deg);z-index:2;}
.ex-pcard .ex-st{position:absolute;top:6px;right:6px;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:10px;font-weight:800;}
.ex-pcard .ex-bx{font-size:30px;line-height:1;margin:2px 0 3px;}
.ex-pcard .n{font-size:12.5px;font-weight:700;}
.ex-pcard .kg{font-size:15px;font-weight:800;font-family:var(--ex-mono);margin-top:3px;}
.ex-pcard .cj{font-size:11px;color:#64748b;}
.ex-pcard .ex-bar{height:5px;margin:6px 0 3px;}
.ex-pcard .pc{font-size:11px;font-weight:700;font-family:var(--ex-mono);}
.ex-pempty{text-align:center;padding:22px 10px;color:var(--ex-muted);}

/* Detalle de paleta */
.ex-pdet{display:none;background:#fff;border:2px solid var(--ex-blue);border-radius:14px;padding:14px;scroll-margin-top:90px;}
.ex-pdet.on{display:block;}
.ex-pdet-h{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px;}
.ex-pdet-h .ex-bx{font-size:26px;}
.ex-pdet-h h4{margin:0;font-size:17px;font-weight:800;}
.ex-pill{display:inline-flex;align-items:center;gap:6px;background:#eef2f7;border-radius:8px;padding:5px 10px;font-size:12px;color:#475569;}
.ex-pill b{background:#dbeafe;color:#1d4ed8;border-radius:6px;padding:2px 8px;font-family:var(--ex-mono);}
.ex-pdet-h .sp{margin-left:auto;display:flex;gap:6px;align-items:center;}
.ex-pdet-body{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(210px,1fr);gap:14px;}
@media(max-width:820px){.ex-pdet-body{grid-template-columns:1fr;}}
.ex-sub{font-size:13px;font-weight:800;margin:0 0 8px;display:flex;align-items:center;gap:7px;}
.ex-sub .d{width:20px;height:20px;border-radius:50%;background:var(--ex-blue-soft);color:var(--ex-blue);display:inline-flex;align-items:center;justify-content:center;font-size:11px;}
.ex-ptbl{width:100%;border-collapse:collapse;font-size:12px;border:1px solid var(--ex-line);border-radius:8px;overflow:hidden;}
.ex-ptbl th{background:#f1f5f9;color:#475569;font-size:10.5px;padding:7px 8px;text-align:center;}
.ex-ptbl th.l,.ex-ptbl td.l{text-align:left;}
.ex-ptbl td{padding:7px 8px;border-top:1px solid #eef2f7;text-align:center;}
.ex-ptbl .dot{display:inline-block;width:9px;height:9px;border-radius:2px;margin-right:6px;}
.ex-padd{background:#f1f5ff;border:1px solid #dbe5fb;border-radius:10px;padding:11px;margin-top:12px;}
.ex-padd .row{display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;}
.ex-padd label{display:block;font-size:10.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;}
.ex-pinfo{background:var(--ex-bg);border:1px solid var(--ex-line);border-radius:10px;padding:12px;align-self:start;}
.ex-pinfo h5{margin:0 0 8px;font-size:13px;font-weight:800;}
.ex-ir{display:flex;justify-content:space-between;align-items:center;padding:6px 0;font-size:12.5px;color:#475569;border-bottom:1px solid #eef2f7;}
.ex-ir:last-of-type{border:none;}
.ex-ir b{font-family:var(--ex-mono);color:var(--ex-text);}
.ex-capform{display:flex;gap:6px;align-items:flex-end;margin:10px 0;}
.ex-capform input{width:100%;padding:7px 8px;border:1px solid #cbd5e1;border-radius:7px;font-size:12.5px;font-weight:700;font-family:var(--ex-mono);}
.ex-capform label{display:block;font-size:10.5px;font-weight:700;color:#64748b;text-transform:uppercase;margin-bottom:3px;}

/* Inferior */
.ex-bottom{display:grid;grid-template-columns:1fr 1.4fr;gap:14px;margin-top:14px;}
@media(max-width:900px){.ex-bottom{grid-template-columns:1fr;}}
.ex-sum{display:grid;grid-template-columns:repeat(3,1fr);gap:0;}
@media(max-width:560px){.ex-sum{grid-template-columns:1fr 1fr;}}
.ex-sum > div{padding:10px 8px;border-bottom:1px solid #eef2f7;}
.ex-sum small{display:block;font-size:11px;color:var(--ex-muted);}
.ex-sum b{font-family:var(--ex-mono);font-size:15px;}
.ex-total{display:flex;justify-content:space-between;align-items:center;margin-top:10px;padding:10px 12px;background:#f0f7ff;border-radius:10px;}
.ex-total span{font-weight:800;color:var(--ex-navy);}
.ex-total b{font-family:var(--ex-mono);font-size:20px;color:var(--ex-navy);}

/* Historial */
.ex-hist-tools{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:12px;}
.ex-fchip{border:1px solid var(--ex-line);background:#fff;border-radius:99px;padding:6px 14px;font-size:12.5px;font-weight:600;color:#475569;cursor:pointer;font-family:inherit;}
.ex-fchip.on{background:var(--ex-blue);border-color:var(--ex-blue);color:#fff;}
.ex-tl{position:relative;padding-left:6px;}
.ex-dayh{font-size:11.5px;font-weight:800;color:var(--ex-muted);text-transform:uppercase;letter-spacing:.05em;margin:14px 0 6px;}
.ex-ev{display:flex;gap:12px;align-items:flex-start;padding:10px 12px;border:1px solid var(--ex-line);border-radius:11px;background:#fff;margin-bottom:7px;}
.ex-ev-ic{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;}
.ex-ev-ic.orden{background:var(--ex-purple-soft);}
.ex-ev-ic.linea{background:var(--ex-blue-soft);}
.ex-ev-ic.pallet{background:var(--ex-orange-soft);}
.ex-ev b{font-size:13px;display:block;}
.ex-ev span{font-size:12px;color:var(--ex-muted);}
.ex-ev time{margin-left:auto;font-size:11.5px;color:var(--ex-muted);font-family:var(--ex-mono);white-space:nowrap;}

/* Cámara */
.ex-cam{display:none;position:fixed;inset:0;background:rgba(15,23,42,.75);z-index:1100;align-items:center;justify-content:center;padding:16px;}
.ex-cam.open{display:flex;}
.ex-cam-box{background:#0b1b36;border-radius:14px;padding:14px;width:min(520px,100%);color:#fff;}
.ex-cam-box video{width:100%;border-radius:10px;background:#000;max-height:60vh;}
.ex-cam-box p{font-size:12.5px;color:#9db2d3;margin:10px 0;text-align:center;}
</style>

<div class="page">
<div class="body">

@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

{{-- ── Datos base (SIN CAMBIOS respecto al original) ── --}}
@php
    $totalItems  = $order->details->count();
    $totalPallets= $order->pallets->count();
    $pesoTotal   = $order->details->sum(fn($d) => ($d->product->peso ?? 0) * $d->cantidad_solicitada / 1000);
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d' : ($order->estado === 'PARCIAL' ? '#b45309' : '#b91c1c');
    $estadoBg    = $order->estado === 'COMPLETO' ? '#dcfce7' : ($order->estado === 'PARCIAL' ? '#fef3c7' : '#fee2e2');

    // Objetivo de cajas (mismo cálculo original)
    $totalCajasAsignadas = $order->pallets
        ->flatMap(fn($pallet) => $pallet->detalles)
        ->sum('cantidad_cajas');
    $objetivoCajas = (int) ($order->cajas_objetivo ?? 0);
    $avanceCajas = $objetivoCajas > 0
        ? min(100, round(($totalCajasAsignadas / $objetivoCajas) * 100))
        : 0;
    $cajasFaltantes = max(0, $objetivoCajas - $totalCajasAsignadas);
    $avanceColor = $avanceCajas >= 100
        ? 'var(--erp-ok)'
        : ($avanceCajas > 0 ? '#f59e0b' : '#94a3b8');
@endphp

{{-- ── Datos adicionales para el rediseño (solo lectura) ── --}}
@php
    // Rutas opcionales: si las defines, el botón se activa solo.
    // Ej: $exRutaEliminarPaleta = fn($pallet) => route('exportacion.pallet.destroy', $pallet);
    $exRutaEliminarPaleta = null;

    $exN = fn($n, $d = 1) => $d > 0
        ? (rtrim(rtrim(number_format((float) $n, $d, '.', ''), '0'), '.') ?: '0')
        : number_format((float) $n, 0);

    $exCajasPedido = (int) $order->details->sum(
        fn($d) => intdiv((int) $d->cantidad_solicitada, max(1, (int) ($d->product->cantidad_por_caja ?? 1)))
    );
    $exCajasPrep = (int) $totalCajasAsignadas;
    $exCajasPend = max(0, $exCajasPedido - $exCajasPrep);
    $exBase = $objetivoCajas > 0 ? $objetivoCajas : $exCajasPedido;
    $exPct  = $exBase > 0 ? min(100, round(($exCajasPrep / $exBase) * 100)) : 0;
    $exPctColor = $exPct >= 100 ? '#16a34a' : '#1d7ff2';

    $exDestino = (string) ($order->destino ?? $order->pais_destino ?? $order->pais ?? '');
    $exFlags = ['chile'=>'🇨🇱','estados unidos'=>'🇺🇸','usa'=>'🇺🇸','eeuu'=>'🇺🇸','mexico'=>'🇲🇽','méxico'=>'🇲🇽','colombia'=>'🇨🇴',
                'ecuador'=>'🇪🇨','bolivia'=>'🇧🇴','brasil'=>'🇧🇷','argentina'=>'🇦🇷','españa'=>'🇪🇸','china'=>'🇨🇳',
                'panamá'=>'🇵🇦','panama'=>'🇵🇦','paraguay'=>'🇵🇾','uruguay'=>'🇺🇾','canadá'=>'🇨🇦','canada'=>'🇨🇦'];
    $exFlag = $exDestino !== '' ? ($exFlags[mb_strtolower(trim($exDestino))] ?? '🌐') : '🌐';

    $exEstadoTxt = ['COMPLETO' => 'Completada', 'PARCIAL' => 'En preparación', 'INCOMPLETO' => 'Pendiente'][$order->estado] ?? $order->estado;

    $exCol = ['#22c55e','#f59e0b','#8b5cf6','#ef4444','#0ea5e9','#06b6d4','#ec4899','#84cc16','#f97316','#6366f1'];
    $exImg = function ($p) {
        $i = $p->imagen ?? $p->image ?? $p->foto ?? null;
        if ($i && is_string($i) && !preg_match('#^(https?:)?//#', $i)) { $i = asset('storage/' . ltrim($i, '/')); }
        return is_string($i) ? $i : null;
    };
    $exFecha = fn($v, $f = 'd/m/Y') => $v ? \Carbon\Carbon::parse($v)->format($f) : '—';
    $exObs = $order->observaciones ?? $order->observacion ?? null;

    // ── Información de cada pallet (mismas fórmulas del original) ──
    $exPI = [];
    $exPalletsData = [];
    $colorPalette = ['#0ea5e9','#7c3aed','#22c55e','#f59e0b','#ef4444','#06b6d4','#ec4899','#84cc16','#f97316','#8b5cf6'];
    foreach ($order->pallets->sortBy('orden') as $pallet) {
        $capacidadPallet = max(1, (int) ($pallet->capacidad_cajas ?? 20));
        $totalCajas = (int) $pallet->detalles->sum('cantidad_cajas');
        $disponible = max(0, $capacidadPallet - $totalCajas);
        $pct = $capacidadPallet > 0 ? min(100, round(($totalCajas / $capacidadPallet) * 100)) : 0;
        if ($totalCajas <= 0) {
            $estadoPallet = 'INCOMPLETO'; $colorPallet = '#94a3b8'; $bgPallet = '#f8fafc';
        } elseif ($totalCajas < $capacidadPallet) {
            $estadoPallet = 'PARCIAL';    $colorPallet = '#f59e0b'; $bgPallet = '#fffbeb';
        } else {
            $estadoPallet = 'COMPLETO';   $colorPallet = '#22c55e'; $bgPallet = '#f0fdf4';
        }
        $pesoP = $pallet->detalles->sum(fn($d) => (($d->product->peso ?? 0) * $d->cantidad) / 1000);
        $prodColores = []; $ci = 0;
        foreach ($pallet->detalles as $det) {
            if (!isset($prodColores[$det->product_id])) {
                $prodColores[$det->product_id] = $colorPalette[$ci % count($colorPalette)];
                $ci++;
            }
        }
        $exPI[$pallet->id] = compact('capacidadPallet','totalCajas','disponible','pct','estadoPallet','colorPallet','bgPallet','pesoP','prodColores');

        $exPalletsData[$pallet->id] = [
            'orden' => $pallet->orden,
            'cajas' => $totalCajas,
            'cap'   => $capacidadPallet,
            'peso'  => round($pesoP, 2),
            'estado'=> $estadoPallet,
            'items' => $pallet->detalles->map(fn($d) => [
                'n'    => $d->product->nombre ?? '',
                'sku'  => $d->product->sku ?? '',
                'pres' => 'Caja x ' . max(1, (int) ($d->product->cantidad_por_caja ?? 1)),
                'cajas'=> (int) ($d->cantidad_cajas ?? 0),
                'peso' => round((($d->product->peso ?? 0) * $d->cantidad) / 1000, 2),
            ])->values()->all(),
        ];
    }

    // ── Historial de la orden (derivado de las fechas de registro existentes) ──
    $exTs = fn($v) => $v ? \Carbon\Carbon::parse($v) : null;
    $exEventos = collect();
    $exAdd = function ($fecha, $tipo, $icono, $titulo, $detalle = '') use (&$exEventos, $exTs) {
        $f = $exTs($fecha);
        if (!$f) { return; }
        $exEventos->push(['f' => $f, 'ts' => $f->getTimestamp(), 'tipo' => $tipo, 'i' => $icono, 't' => $titulo, 'd' => $detalle]);
    };
    $exAdd($order->created_at ?? null, 'orden', '🆕', 'Orden de exportación creada', $order->numero_orden);
    foreach ($order->details as $d) {
        $nom = $d->product->nombre ?? 'Producto';
        $exAdd($d->created_at ?? null, 'linea', '➕', 'Producto agregado a la orden', $nom . ' · ' . $exN($d->cantidad_solicitada, 2) . ' u');
        $c = $exTs($d->created_at ?? null); $u = $exTs($d->updated_at ?? null);
        if ($c && $u && abs($u->getTimestamp() - $c->getTimestamp()) > 60) {
            $exAdd($u, 'linea', '✏️', 'Línea actualizada', $nom . ' · despachado ' . $exN($d->cantidad_despachada, 2) . ' u');
        }
    }
    foreach ($order->pallets as $p) {
        $exAdd($p->created_at ?? null, 'pallet', '🟫', 'Pallet ' . $p->orden . ' creado', 'Capacidad ' . (int) ($p->capacidad_cajas ?? 0) . ' cajas');
        foreach ($p->detalles as $dd) {
            $exAdd($dd->created_at ?? null, 'pallet', '📦', 'Producto asignado al Pallet ' . $p->orden,
                ($dd->product->nombre ?? 'Producto') . ' · ' . (int) ($dd->cantidad_cajas ?? 0) . ' cajas');
        }
    }
    if ($order->estado === 'COMPLETO') {
        $exAdd($order->updated_at ?? null, 'orden', '🔒', 'Exportación cerrada', '');
    }
    $exEventos = $exEventos->sortByDesc('ts')->values();
@endphp

{{-- Iconos (sprite) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="ex-ship" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l2 3h14l2-3-9-3z"/><path d="M5 14V9h14v5"/><path d="M9 9V6h6v3"/><line x1="12" y1="3" x2="12" y2="6"/></symbol>
    <symbol id="ex-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
    <symbol id="ex-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
    <symbol id="ex-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
    <symbol id="ex-scale" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="5" r="2.5"/><path d="M6.5 8h11l3 13h-17z"/></symbol>
    <symbol id="ex-grid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></symbol>
    <symbol id="ex-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
    <symbol id="ex-printer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></symbol>
    <symbol id="ex-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
    <symbol id="ex-camera" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></symbol>
    <symbol id="ex-barcode" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="5" x2="3" y2="19"/><line x1="6" y1="5" x2="6" y2="19"/><line x1="10" y1="5" x2="10" y2="19"/><line x1="13" y1="5" x2="13" y2="19"/><line x1="17" y1="5" x2="17" y2="19"/><line x1="21" y1="5" x2="21" y2="19"/></symbol>
    <symbol id="ex-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
    <symbol id="ex-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="ex-dots" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="19" cy="12" r="1.8"/></symbol>
    <symbol id="ex-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
    <symbol id="ex-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></symbol>
    <symbol id="ex-history" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/><polyline points="12 7 12 12 15 14"/></symbol>
    <symbol id="ex-list" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></symbol>
</defs></svg>

<div class="ex">

{{-- ══════════ BREADCRUMB + CABECERA ══════════ --}}
<div class="ex-crumb">
    <a href="/orders">Operaciones</a> &nbsp;/&nbsp; <a href="/orders">Órdenes</a> &nbsp;/&nbsp; <b>Exportación</b>
</div>

<div class="ex-head">
    <div class="ex-head-l">
        <div class="ex-ship"><svg class="ex-i"><use href="#ex-ship"/></svg></div>
        <div>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <span class="ex-ord">{{ $order->numero_orden }}</span>
                <span class="ex-chip" style="background:{{ $estadoBg }};color:{{ $estadoColor }};" title="{{ $order->estado }}">{{ $exEstadoTxt }}</span>
            </div>
            <div class="ex-meta">
                <span>Cliente <b>{{ $order->client->razon_social }}</b></span>
                <span>Destino <b>{{ $exFlag }} {{ $exDestino !== '' ? $exDestino : '—' }}</b></span>
                <span>Fecha <b class="ex-num">{{ $exFecha($order->fecha_pedido) }}</b></span>
            </div>
        </div>
    </div>

    <div class="ex-head-r">
        @if($order->estado != 'COMPLETO')
        <form method="POST" action="{{ route('orders.cerrar', $order) }}" style="display:inline;">
            @csrf
            <button type="submit" class="ex-btn green"
                    onclick="return confirm('¿Confirmas cerrar esta exportación?')">
                <svg class="ex-i"><use href="#ex-check"/></svg> Cerrar Exportación
            </button>
        </form>
        @else
        <span class="ex-chip" style="background:#dcfce7;color:#15803d;padding:9px 16px;font-size:13px;">✅ Exportación cerrada</span>
        @endif

        <div class="ex-dd" id="exDdPrint">
            <div class="ex-split">
                <button type="button" class="ex-btn white" onclick="exPrintTodas()"><svg class="ex-i"><use href="#ex-printer"/></svg> Imprimir etiquetas</button>
                <button type="button" class="ex-btn white" onclick="exDD('exDdPrint',event)" title="Más opciones"><svg class="ex-i"><use href="#ex-chev"/></svg></button>
            </div>
            <div class="ex-dd-menu" onclick="event.stopPropagation()">
                <button type="button" class="ex-dd-item" onclick="exPrintTodas()"><svg class="ex-i"><use href="#ex-printer"/></svg> Todas las paletas</button>
                <button type="button" class="ex-dd-item" onclick="exPrintSel()"><svg class="ex-i"><use href="#ex-printer"/></svg> Paleta seleccionada</button>
            </div>
        </div>

        <a href="{{ route('orders.pdf', $order) }}" target="_blank" class="ex-btn red"><svg class="ex-i"><use href="#ex-file"/></svg> PDF Cliente</a>
    </div>
</div>

{{-- ══════════ KPIs ══════════ --}}
<div class="ex-kpis">
    <div class="ex-k t-blue"><div class="ex-k-ic"><svg class="ex-i"><use href="#ex-box"/></svg></div><div><b>{{ number_format($exCajasPedido) }}</b><small>Cajas del pedido</small></div></div>
    <div class="ex-k t-green"><div class="ex-k-ic"><svg class="ex-i"><use href="#ex-check"/></svg></div><div><b style="color:#16a34a;">{{ number_format($exCajasPrep) }}</b><small>Cajas preparadas</small></div></div>
    <div class="ex-k t-orange"><div class="ex-k-ic"><svg class="ex-i"><use href="#ex-clock"/></svg></div><div><b style="color:#d97706;">{{ number_format($exCajasPend) }}</b><small>Cajas pendientes</small></div></div>
    <div class="ex-vsep"></div>
    <div class="ex-k t-plain"><div class="ex-k-ic"><svg class="ex-i"><use href="#ex-box"/></svg></div><div><b>{{ $totalItems }}</b><small>Productos</small></div></div>
    <div class="ex-k t-purple"><div class="ex-k-ic"><svg class="ex-i"><use href="#ex-grid"/></svg></div><div><b style="color:#7c3aed;">{{ $totalPallets }}</b><small>Paletas</small></div></div>
    <div class="ex-k t-plain"><div class="ex-k-ic"><svg class="ex-i"><use href="#ex-scale"/></svg></div><div><b>{{ number_format($pesoTotal, 0) }} kg</b><small>Peso total</small></div></div>

    <div class="ex-prog">
        <div class="ex-prog-top">
            <div>Progreso de preparación (cajas)</div>
            <span class="ex-num">{{ number_format($exCajasPrep) }} / {{ number_format($exBase) }} cajas</span>
        </div>
        <div class="ex-prog-row">
            <div class="ex-bar"><div style="width:{{ $exPct }}%;background:{{ $exPctColor }};"></div></div>
            <div class="ex-prog-pct" style="color:{{ $exPctColor }};">{{ $exPct }}%</div>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap;">
            <span style="font-size:11px;color:var(--ex-muted);">
                @if($objetivoCajas > 0)
                    Objetivo: <b class="ex-num">{{ number_format($objetivoCajas) }}</b> cajas ·
                    @if($cajasFaltantes > 0) faltan <b>{{ number_format($cajasFaltantes) }}</b> por asignar @else <b style="color:#16a34a;">objetivo completado</b> @endif
                @else
                    Sin objetivo definido (se usa el total del pedido)
                @endif
            </span>
            <button type="button" class="ex-obj-link" onclick="document.getElementById('exObjForm').classList.toggle('open')">✎ {{ $objetivoCajas > 0 ? 'Cambiar objetivo' : 'Definir objetivo' }}</button>
        </div>

        {{-- Formulario original: objetivo de cajas --}}
        <form action="{{ route('exportacion.cajasObjetivo', $order) }}" method="POST" class="ex-obj-form" id="exObjForm">
            @csrf
            <div>
                <label class="flabel">Cajas objetivo</label>
                <input type="number" name="cajas_objetivo" min="1" required value="{{ $order->cajas_objetivo }}" class="finput" style="width:130px;" placeholder="1000">
            </div>
            <button type="submit" class="btn-primary" style="background:#7c3aed;">💾 Definir</button>
        </form>
    </div>
</div>

{{-- ══════════ PESTAÑAS ══════════ --}}
<div class="ex-tabs">
    <button type="button" class="ex-tab on" data-tab="prep" onclick="exTab('prep',this)"><svg class="ex-i"><use href="#ex-grid"/></svg> Preparación</button>
    <button type="button" class="ex-tab" data-tab="lineas" onclick="exTab('lineas',this)"><svg class="ex-i"><use href="#ex-list"/></svg> Líneas y precios <em>{{ $totalItems }}</em></button>
    <button type="button" class="ex-tab" data-tab="historial" onclick="exTab('historial',this)"><svg class="ex-i"><use href="#ex-history"/></svg> Historial de la orden <em>{{ $exEventos->count() }}</em></button>
</div>

{{-- ═════════════════ PANE: PREPARACIÓN ═════════════════ --}}
<div class="ex-pane on" data-pane="prep">

    {{-- Escáner --}}
    <div class="ex-scan">
        <div class="ex-scan-ic"><svg class="ex-i"><use href="#ex-barcode"/></svg></div>
        <input type="text" id="exScanner" placeholder="Escanea un producto para ver su estado en la orden..." autocomplete="off"
               onkeydown="if(event.key==='Enter'){event.preventDefault();exScan();}">
        <div class="ex-scan-hint">Enter para<br>confirmar</div>
        <button type="button" class="ex-btn blue" onclick="exCamara()"><svg class="ex-i"><use href="#ex-camera"/></svg> Cámara</button>
    </div>
    <div class="ex-scan-res" id="exScanRes"></div>
    <div class="ex-scan-gap"></div>

    <div class="ex-main">

        {{-- ───── IZQUIERDA: productos de la orden ───── --}}
        <div class="ex-card">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px;">
                <h3 class="ex-card-t" style="margin:0;">
                    <span class="ex-ico"><svg class="ex-i"><use href="#ex-box"/></svg></span> Productos de la orden
                    <span class="ex-count" id="exCount">{{ $totalItems }}</span>
                </h3>
                <div class="ex-ptools">
                    <button type="button" class="ex-btn blue sm" onclick="document.getElementById('exAddBox').classList.toggle('open')"><svg class="ex-i"><use href="#ex-plus"/></svg> Agregar producto</button>
                    <div class="ex-search">
                        <svg class="ex-i"><use href="#ex-search"/></svg>
                        <input type="text" id="exBuscar" placeholder="Buscar producto..." oninput="exFiltrar()">
                    </div>
                </div>
            </div>

            {{-- Formulario original: agregar línea de producto --}}
            <div class="ex-addbox" id="exAddBox">
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

            <div class="ex-scroll">
            <table class="ex-tbl" id="exTabla">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="l">Producto</th>
                        <th>Presentación</th>
                        <th>Cajas<br>solicitadas</th>
                        <th>Cajas en<br>paletas</th>
                        <th>Faltante</th>
                        <th>Progreso</th>
                        <th>Peso total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($order->details as $detalle)
                    @php
                        $porCaja = (int) ($detalle->product->cantidad_por_caja ?? 1);
                        if ($porCaja < 1) { $porCaja = 1; }

                        // Cajas ya asignadas a pallets
                        $cajasEnPallets = (int) $detalle->palletDetails->sum('cantidad_cajas');
                        // Cajas solicitadas según las unidades del pedido
                        $cajasSolicitadas = intdiv((int) $detalle->cantidad_solicitada, $porCaja);
                        // Cajas que todavía faltan asignar
                        $pendiente = max(0, $cajasSolicitadas - $cajasEnPallets);
                        // Porcentaje de avance
                        $pct2 = $cajasSolicitadas > 0
                            ? min(100, round(($cajasEnPallets / $cajasSolicitadas) * 100))
                            : 0;
                        $bc2 = $pct2 >= 100 ? '#16a34a' : ($pct2 > 0 ? '#f59e0b' : '#cbd5e1');
                        // Peso solicitado
                        $peso = ($detalle->product->peso ?? 0) * $detalle->cantidad_solicitada;

                        $exStripe = $exCol[$loop->index % count($exCol)];
                        $exThumb  = $exImg($detalle->product);
                    @endphp
                    <tr class="ex-prow"
                        id="ex-prow-{{ $detalle->id }}"
                        data-id="{{ $detalle->id }}"
                        data-barcode="{{ $detalle->product->barcode ?? '' }}"
                        data-box-barcode="{{ $detalle->product->box_barcode ?? '' }}"
                        data-sku="{{ $detalle->product->sku ?? '' }}"
                        data-name="{{ $detalle->product->nombre }}"
                        data-solic="{{ $cajasSolicitadas }}"
                        data-enpal="{{ $cajasEnPallets }}"
                        data-falt="{{ $pendiente }}"
                        data-search="{{ mb_strtolower($detalle->product->nombre.' '.($detalle->product->sku ?? '').' '.($detalle->product->barcode ?? '')) }}">
                        <td class="ex-stripe" style="--c:{{ $exStripe }};">{{ $loop->iteration }}</td>
                        <td class="l">
                            <div class="ex-prod">
                                <div class="ex-thumb">@if($exThumb)<img src="{{ $exThumb }}" alt="" loading="lazy" onerror="this.replaceWith(document.createTextNode('📦'))">@else 📦 @endif</div>
                                <div>
                                    <div class="ex-sku">{{ $detalle->product->sku ?? '' }}</div>
                                    <div class="ex-pname">{{ $detalle->product->nombre }}</div>
                                </div>
                            </div>
                        </td>
                        <td>Caja x {{ $porCaja }}</td>
                        <td class="ex-num" style="font-weight:700;">{{ number_format($cajasSolicitadas) }}</td>
                        <td class="ex-num" style="font-weight:700;color:{{ $pendiente <= 0 && $cajasSolicitadas > 0 ? '#16a34a' : '#0f172a' }};">{{ number_format($cajasEnPallets) }}</td>
                        <td class="ex-num" style="font-weight:700;color:{{ $pendiente > 0 ? '#ef4444' : '#0f172a' }};">{{ number_format($pendiente) }}</td>
                        <td>
                            <div class="ex-pg">
                                <div class="ex-bar"><div style="width:{{ $pct2 }}%;background:{{ $bc2 }};"></div></div>
                                <b style="color:{{ $pct2 > 0 ? $bc2 : '#94a3b8' }};">{{ $pct2 }}%</b>
                            </div>
                        </td>
                        <td class="ex-num" style="white-space:nowrap;">{{ $exN($peso / 1000, 0) }} kg</td>
                        <td>
                            <div class="ex-act">
                                <button type="button" class="ex-ic blue" title="Asignar a paleta" onclick="exAsignar({{ $detalle->id }})"><svg class="ex-i"><use href="#ex-file"/></svg></button>
                                <button type="button" class="ex-ic" title="Más acciones" onclick="exRowMenu(this,{{ $detalle->id }},event)"><svg class="ex-i"><use href="#ex-dots"/></svg></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <div class="ex-empty" id="exEmpty">No hay productos que coincidan con la búsqueda.</div>
        </div>

        {{-- ───── DERECHA: paletas + detalle ───── --}}
        <div>
            <div class="ex-card" style="margin-bottom:14px;">
                <div class="ex-ph">
                    <h3 class="ex-card-t"><span class="ex-ico"><svg class="ex-i"><use href="#ex-grid"/></svg></span> Paletas ({{ $totalPallets }})</h3>
                    <button type="button" class="ex-btn blue sm" onclick="document.getElementById('exNewPal').classList.toggle('open')"><svg class="ex-i"><use href="#ex-plus"/></svg> Nueva paleta</button>
                    <div class="ex-ph-w">Peso total: <b class="ex-num">{{ number_format($pesoTotal, 0) }} kg</b></div>
                </div>

                {{-- Formulario original: crear pallet --}}
                <form action="{{ route('exportacion.pallet.store', $order) }}" method="POST" class="ex-newpal" id="exNewPal">
                    @csrf
                    <span style="font-size:12px;color:var(--ex-muted);">Capacidad</span>
                    <input type="number" name="capacidad_cajas" value="20" min="1" max="1000" required>
                    <span style="font-size:12px;color:var(--ex-muted);">cajas</span>
                    <button type="submit" class="btn-primary" style="background:#7c3aed;">➕ Crear pallet</button>
                </form>

                @if($order->pallets->count())
                    <div class="ex-pcards">
                        @foreach($order->pallets->sortBy('orden') as $mapPallet)
                            @php
                                $pi = $exPI[$mapPallet->id];
                                if ($pi['totalCajas'] <= 0)                          { $stBg = '#ef4444'; $stTx = '!'; $barC = '#cbd5e1'; }
                                elseif ($pi['totalCajas'] < $pi['capacidadPallet'])  { $stBg = '#f59e0b'; $stTx = '◔'; $barC = '#f59e0b'; }
                                else                                                  { $stBg = '#22c55e'; $stTx = '✓'; $barC = '#22c55e'; }
                            @endphp
                            <div class="ex-pcard {{ $loop->first ? 'on' : '' }}" data-pid="{{ $mapPallet->id }}" onclick="exSelPaleta({{ $mapPallet->id }})">
                                <span class="ex-st" style="background:{{ $stBg }};">{{ $stTx }}</span>
                                <div class="ex-bx">📦</div>
                                <div class="n">Paleta {{ $mapPallet->orden }}</div>
                                <div class="kg">{{ $exN($pi['pesoP'], 0) }} kg</div>
                                <div class="cj">{{ number_format($pi['totalCajas']) }} cajas</div>
                                <div class="ex-bar"><div style="width:{{ $pi['pct'] }}%;background:{{ $barC }};"></div></div>
                                <div class="pc" style="color:{{ $pi['totalCajas'] > 0 ? $barC : '#94a3b8' }};">{{ $pi['pct'] }}%</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="ex-pempty">
                        <div style="font-size:34px;margin-bottom:6px;">🟫</div>
                        <div style="font-size:14px;font-weight:700;color:var(--ex-text);margin-bottom:3px;">No hay pallets creados</div>
                        <div style="font-size:12px;">Crea el primer pallet para comenzar la asignación de productos.</div>
                    </div>
                @endif
            </div>

            {{-- Detalle de cada paleta (solo se muestra la seleccionada). Todos los formularios originales siguen aquí. --}}
            @foreach($order->pallets->sortBy('orden') as $pallet)
                @php extract($exPI[$pallet->id]); @endphp
                <div class="ex-pdet {{ $loop->first ? 'on' : '' }}" id="pallet-{{ $pallet->id }}" data-pid="{{ $pallet->id }}">

                    <div class="ex-pdet-h">
                        <span class="ex-bx">📦</span>
                        <h4>Paleta {{ $pallet->orden }}</h4>
                        <span class="ex-chip" style="background:{{ $colorPallet }}22;color:{{ $estadoPallet === 'INCOMPLETO' ? '#64748b' : $colorPallet }};">
                            {{ $estadoPallet === 'COMPLETO' ? 'Completa' : ($estadoPallet === 'PARCIAL' ? 'En preparación' : 'Vacía') }}
                        </span>
                        <span class="ex-pill">Peso: <b>{{ $exN($pesoP, 0) }} kg</b></span>
                        <span class="ex-pill">Cajas: <b>{{ number_format($totalCajas) }}</b></span>
                        <div class="sp">
                            <button type="button" class="ex-ic" title="Imprimir etiqueta de la paleta" onclick="exPrint([{{ $pallet->id }}])"><svg class="ex-i"><use href="#ex-printer"/></svg></button>
                            <button type="button" class="ex-ic" title="Cerrar detalle" onclick="exClosePaleta()"><svg class="ex-i"><use href="#ex-x"/></svg></button>
                        </div>
                    </div>

                    <div class="ex-pdet-body">
                        <div>
                            <h5 class="ex-sub"><span class="d">▣</span> Productos en la paleta ({{ $pallet->detalles->count() }})</h5>

                            <div class="ex-scroll">
                            <table class="ex-ptbl">
                                <thead><tr><th>#</th><th class="l">Producto</th><th>Presentación</th><th>Cajas</th><th>Peso</th><th>Acciones</th></tr></thead>
                                <tbody>
                                @forelse($pallet->detalles as $detalle)
                                    @php
                                        $colorProducto = $prodColores[$detalle->product_id] ?? '#64748b';
                                        $cantidadDetalle = (int) ($detalle->cantidad_cajas ?? 0);
                                    @endphp
                                    <tr>
                                        <td class="ex-num">{{ $loop->iteration }}</td>
                                        <td class="l"><span class="dot" style="background:{{ $colorProducto }};"></span><span style="font-size:11px;color:#64748b;font-family:var(--ex-mono);">{{ $detalle->product->sku ?? '' }}</span> {{ $detalle->product->nombre }}</td>
                                        <td>Caja x {{ max(1, (int) ($detalle->product->cantidad_por_caja ?? 1)) }}</td>
                                        <td class="ex-num" style="font-weight:700;">{{ number_format($cantidadDetalle, 0) }}</td>
                                        <td class="ex-num">{{ $exN((($detalle->product->peso ?? 0) * $detalle->cantidad) / 1000, 0) }} kg</td>
                                        <td>
                                            {{-- Formulario original: quitar producto del pallet --}}
                                            <form method="POST"
                                                  action="{{ route('exportacion.pallet.detalle.destroy', $detalle) }}"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('¿Eliminar {{ addslashes($detalle->product->nombre) }} del Pallet {{ $pallet->orden }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ex-ic red sm" title="Eliminar producto del pallet"><svg class="ex-i"><use href="#ex-trash"/></svg></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" style="padding:18px;color:#94a3b8;font-size:12px;">Este pallet aún no tiene productos.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                            </div>

                            {{-- Formulario original: agregar producto al pallet --}}
                            <div class="ex-padd">
                                <h5 class="ex-sub" style="margin-bottom:8px;"><span class="d">＋</span> Agregar producto a la paleta</h5>
                                <form action="{{ route('exportacion.pallet.agregarProducto', $pallet) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div style="flex:1;min-width:180px;">
                                            <label>Producto</label>
                                            <select name="order_detail_id" class="fselect" required>
                                                <option value="">Seleccionar producto pendiente</option>
                                                @foreach($order->details as $detalle)
                                                    @php
                                                        $porCaja = (int) ($detalle->product->cantidad_por_caja ?? 1);
                                                        if ($porCaja < 1) { $porCaja = 1; }
                                                        $cajasSolicitadas = intdiv((int) $detalle->cantidad_solicitada, $porCaja);
                                                        $cajasEnPallets = (int) $detalle->palletDetails->sum('cantidad_cajas');
                                                        $pendiente = max(0, $cajasSolicitadas - $cajasEnPallets);
                                                    @endphp
                                                    @if($pendiente > 0)
                                                        <option value="{{ $detalle->id }}">
                                                            {{ $detalle->product->nombre }}
                                                            ({{ number_format($pendiente, 0) }} cajas pend.)
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="width:110px;">
                                            <label>Cajas</label>
                                            <input type="number" name="cantidad_cajas" class="finput" min="1" step="1" required placeholder="Cajas">
                                        </div>
                                        <button type="submit" class="ex-btn blue sm" style="height:34px;">Agregar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="ex-pinfo">
                            <h5>Información de la paleta</h5>
                            <div class="ex-ir"><span>Productos:</span><b>{{ $pallet->detalles->count() }}</b></div>
                            <div class="ex-ir"><span>Cajas:</span><b>{{ number_format($totalCajas) }}</b></div>
                            <div class="ex-ir"><span>Peso total:</span><b>{{ $exN($pesoP, 0) }} kg</b></div>
                            <div class="ex-ir"><span>Capacidad estimada:</span><b>{{ number_format($capacidadPallet) }} cajas</b></div>
                            <div class="ex-ir"><span>Restante:</span><b style="color:{{ $disponible > 0 ? '#d97706' : '#16a34a' }};">{{ number_format($disponible) }} cajas</b></div>
                            <div class="ex-prog-row" style="margin-top:8px;">
                                <div class="ex-bar"><div style="width:{{ $pct }}%;background:{{ $colorPallet }};"></div></div>
                                <b class="ex-num" style="color:{{ $colorPallet }};font-size:13px;">{{ $pct }}%</b>
                            </div>

                            {{-- Formulario original: capacidad del pallet --}}
                            <form action="{{ route('exportacion.pallet.capacidad', $pallet) }}" method="POST" class="ex-capform">
                                @csrf
                                @method('PUT')
                                <div style="flex:1;">
                                    <label>Capacidad (cajas)</label>
                                    <input type="number" name="capacidad_cajas" value="{{ $capacidadPallet }}" min="{{ max(1, $totalCajas) }}" max="1000" required>
                                </div>
                                <button type="submit" class="ex-btn white sm" title="Guardar capacidad">💾</button>
                            </form>

                            <button type="button" class="ex-btn white" style="width:100%;justify-content:center;margin-bottom:8px;" onclick="exPrint([{{ $pallet->id }}])">
                                <svg class="ex-i"><use href="#ex-printer"/></svg> Imprimir etiqueta de paleta
                            </button>

                            @if($exRutaEliminarPaleta)
                                <form method="POST" action="{{ $exRutaEliminarPaleta($pallet) }}" onsubmit="return confirm('¿Eliminar el Pallet {{ $pallet->orden }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ex-btn white" style="width:100%;justify-content:center;color:#dc2626;border-color:#fecaca;"><svg class="ex-i"><use href="#ex-trash"/></svg> Eliminar paleta</button>
                                </form>
                            @else
                                <button type="button" class="ex-btn white is-off" disabled style="width:100%;justify-content:center;color:#dc2626;border-color:#fecaca;" title="Ruta de eliminación de pallets sin configurar"><svg class="ex-i"><use href="#ex-trash"/></svg> Eliminar paleta</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ══════════ INFERIOR: OBSERVACIONES + RESUMEN ══════════ --}}
    <div class="ex-bottom">
        <div class="ex-card">
            <h3 class="ex-card-t"><span class="ex-ico"><svg class="ex-i"><use href="#ex-file"/></svg></span> Observaciones</h3>
            <div style="font-size:13px;color:#334155;line-height:1.5;min-height:48px;">{{ $exObs ?: 'Sin observaciones registradas.' }}</div>
        </div>

        <div class="ex-card">
            <h3 class="ex-card-t"><span class="ex-ico"><svg class="ex-i"><use href="#ex-list"/></svg></span> Resumen de la exportación</h3>
            <div class="ex-sum">
                <div><small>N° Orden</small><b style="color:var(--ex-blue);">{{ $order->numero_orden }}</b></div>
                <div><small>Tipo</small><b style="font-family:inherit;font-size:12px;"><span class="ex-chip" style="background:#dbeafe;color:#1d4ed8;padding:2px 9px;">🚢 EXPORTACIÓN</span></b></div>
                <div><small>Estado</small><b style="font-family:inherit;font-size:12px;"><span class="ex-chip" style="background:{{ $estadoBg }};color:{{ $estadoColor }};padding:2px 9px;">{{ $order->estado }}</span></b></div>
                <div><small>Productos</small><b>{{ $totalItems }}</b></div>
                <div><small>Pallets</small><b>{{ $totalPallets }}</b></div>
                <div><small>Peso estimado</small><b>{{ number_format($pesoTotal, 2) }} kg</b></div>
                <div><small>Subtotal</small><b>S/ {{ number_format($order->subtotal, 2) }}</b></div>
                <div><small>IGV (18%)</small><b>S/ {{ number_format($order->igv, 2) }}</b></div>
                <div><small>Fecha</small><b>{{ $exFecha($order->fecha_pedido) }}</b></div>
            </div>
            <div class="ex-total"><span>TOTAL</span><b>S/ {{ number_format($order->total, 2) }}</b></div>
        </div>
    </div>
</div>

{{-- ═════════════════ PANE: LÍNEAS Y PRECIOS (tabla original con edición, sin cambios) ═════════════════ --}}
<div class="ex-pane" data-pane="lineas">
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
</div>

{{-- ═════════════════ PANE: HISTORIAL DE LA ORDEN ═════════════════ --}}
<div class="ex-pane" data-pane="historial">
    <div class="ex-card">
        <h3 class="ex-card-t"><span class="ex-ico"><svg class="ex-i"><use href="#ex-history"/></svg></span> Historial de la orden</h3>

        <div class="ex-hist-tools">
            <button type="button" class="ex-fchip on" data-f="todos" onclick="exHist('todos',this)">Todos ({{ $exEventos->count() }})</button>
            <button type="button" class="ex-fchip" data-f="orden" onclick="exHist('orden',this)">Orden ({{ $exEventos->where('tipo','orden')->count() }})</button>
            <button type="button" class="ex-fchip" data-f="linea" onclick="exHist('linea',this)">Productos ({{ $exEventos->where('tipo','linea')->count() }})</button>
            <button type="button" class="ex-fchip" data-f="pallet" onclick="exHist('pallet',this)">Pallets ({{ $exEventos->where('tipo','pallet')->count() }})</button>
        </div>

        <div class="ex-tl" id="exTl">
            @php $exDiaPrev = null; @endphp
            @forelse($exEventos as $ev)
                @php
                    $exDia = $ev['f']->format('Y-m-d');
                    $exDiaTxt = $ev['f']->isToday() ? 'Hoy' : ($ev['f']->isYesterday() ? 'Ayer' : $ev['f']->format('d/m/Y'));
                @endphp
                @if($exDia !== $exDiaPrev)
                    <div class="ex-dayh" data-day="{{ $exDia }}">{{ $exDiaTxt }}</div>
                    @php $exDiaPrev = $exDia; @endphp
                @endif
                <div class="ex-ev" data-tipo="{{ $ev['tipo'] }}" data-day="{{ $exDia }}">
                    <div class="ex-ev-ic {{ $ev['tipo'] }}">{{ $ev['i'] }}</div>
                    <div>
                        <b>{{ $ev['t'] }}</b>
                        @if($ev['d'] !== '')<span>{{ $ev['d'] }}</span>@endif
                    </div>
                    <time>{{ $ev['f']->format('H:i') }}</time>
                </div>
            @empty
                <div class="ex-pempty">Aún no hay movimientos registrados en esta orden.</div>
            @endforelse
        </div>
        <div style="margin-top:10px;font-size:11px;color:var(--ex-muted);">
            El historial se arma con las fechas de registro de la orden, sus productos, los pallets y las asignaciones.
        </div>
    </div>
</div>

</div>{{-- /.ex --}}

{{-- Menú flotante de acciones por fila --}}
<div class="ex-rmenu" id="exRMenu" onclick="event.stopPropagation()">
    <button type="button" class="ex-dd-item" onclick="exRowAct('edit')">✏️ Editar línea (cantidades y precio)</button>
    <button type="button" class="ex-dd-item" onclick="exRowAct('asignar')">🟫 Asignar a paleta</button>
    <button type="button" class="ex-dd-item danger" onclick="exRowAct('del')">🗑 Eliminar línea</button>
</div>

{{-- Modal cámara --}}
<div class="ex-cam" id="exCam">
    <div class="ex-cam-box">
        <video id="exCamVideo" playsinline muted></video>
        <p>Apunta al código de barras del producto…</p>
        <div style="text-align:center;"><button type="button" class="ex-btn white" onclick="exCamCerrar()">Cerrar cámara</button></div>
    </div>
</div>

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
<script>
// ══════════════════════════════════════════════════════════
//  EXPORTACIÓN · interacciones del rediseño (aditivo)
//  No toca editarFila / syncHidden / actualizarBarra ni los formularios.
// ══════════════════════════════════════════════════════════
const EX_KEY     = 'ex_pal_{{ $order->id }}';
const EX_TABKEY  = 'ex_tab_{{ $order->id }}';
const EX_TOTAL   = {{ $totalItems }};
const EX_ORDEN   = {
    numero:  {{ Js::from($order->numero_orden) }},
    cliente: {{ Js::from($order->client->razon_social) }},
    destino: {{ Js::from($exDestino) }},
    fecha:   {{ Js::from($exFecha($order->fecha_pedido)) }}
};
const EX_PALLETS = {!! json_encode($exPalletsData, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!};
let EX_SEL = null;
let EX_ROW = null;

function exEsc(s) {
    return String(s ?? '').replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
}

/* ── Dropdown cabecera ── */
function exDD(id, ev) {
    ev.stopPropagation();
    document.querySelectorAll('.ex-dd.open').forEach(d => { if (d.id !== id) d.classList.remove('open'); });
    document.getElementById(id).classList.toggle('open');
}
document.addEventListener('click', () => {
    document.querySelectorAll('.ex-dd.open').forEach(d => d.classList.remove('open'));
    exCerrarRowMenu();
});
window.addEventListener('scroll', exCerrarRowMenu, true);

/* ── Pestañas ── */
function exTab(name, btn) {
    document.querySelectorAll('.ex-pane').forEach(p => p.classList.toggle('on', p.dataset.pane === name));
    document.querySelectorAll('.ex-tab').forEach(b => b.classList.toggle('on', b.dataset.tab === name));
    try { sessionStorage.setItem(EX_TABKEY, name); } catch (e) {}
}

/* ── Selección de paleta (se recuerda tras guardar un formulario) ── */
function exSelPaleta(pid, init) {
    const card = document.querySelector('.ex-pcard[data-pid="' + pid + '"]');
    const det  = document.getElementById('pallet-' + pid);
    if (!card || !det) return;
    document.querySelectorAll('.ex-pcard').forEach(c => c.classList.toggle('on', c === card));
    document.querySelectorAll('.ex-pdet').forEach(p => p.classList.toggle('on', p === det));
    EX_SEL = pid;
    try { localStorage.setItem(EX_KEY, pid); } catch (e) {}
    if (!init && window.innerWidth < 1180) det.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
function exClosePaleta() {
    document.querySelectorAll('.ex-pcard').forEach(c => c.classList.remove('on'));
    document.querySelectorAll('.ex-pdet').forEach(p => p.classList.remove('on'));
    EX_SEL = null;
    try { localStorage.removeItem(EX_KEY); } catch (e) {}
}

/* ── Búsqueda de productos ── */
function exFiltrar() {
    const q = (document.getElementById('exBuscar').value || '').trim().toLowerCase();
    let n = 0;
    document.querySelectorAll('#exTabla tr.ex-prow').forEach(tr => {
        const ok = !q || (tr.dataset.search || '').includes(q);
        tr.style.display = ok ? '' : 'none';
        if (ok) n++;
    });
    document.getElementById('exCount').textContent = q ? (n + ' / ' + EX_TOTAL) : EX_TOTAL;
    document.getElementById('exEmpty').style.display = n ? 'none' : 'block';
}

/* ── Menú flotante por fila (position:fixed para no recortarse) ── */
function exRowMenu(btn, id, ev) {
    ev.stopPropagation();
    const m = document.getElementById('exRMenu');
    if (m.classList.contains('open') && EX_ROW === id) { exCerrarRowMenu(); return; }
    EX_ROW = id;
    const r = btn.getBoundingClientRect();
    m.classList.add('open');
    const w = m.offsetWidth;
    m.style.left = Math.max(8, Math.min(window.innerWidth - w - 8, r.right - w)) + 'px';
    const h = m.offsetHeight;
    m.style.top = (r.bottom + h + 8 > window.innerHeight ? r.top - h - 4 : r.bottom + 4) + 'px';
}
function exCerrarRowMenu() {
    const m = document.getElementById('exRMenu');
    if (m) m.classList.remove('open');
}
function exRowAct(act) {
    const id = EX_ROW;
    exCerrarRowMenu();
    if (!id) return;
    if (act === 'edit')    exIrLinea(id);
    if (act === 'asignar') exAsignar(id);
    if (act === 'del')     exEliminarLinea(id);
}

/* ── Acciones sobre una línea ── */
function exIrLinea(id) {
    exTab('lineas');
    const row = document.getElementById('row-' + id);
    if (!row) return;
    row.scrollIntoView({ behavior: 'smooth', block: 'center' });
    if (typeof editarFila === 'function') { try { editarFila(id); } catch (e) {} }
}
function exEliminarLinea(id) {
    // Usa el formulario original de eliminación (mantiene su confirmación)
    const b = document.querySelector('#row-' + id + ' form button[type="submit"]');
    if (b) b.click();
}
function exAsignar(id) {
    if (!EX_SEL) {
        const first = document.querySelector('.ex-pcard');
        if (!first) { alert('Crea primero una paleta para asignar productos.'); return; }
        exSelPaleta(first.dataset.pid, true);
    }
    const det = document.getElementById('pallet-' + EX_SEL);
    if (!det) return;
    const sel = det.querySelector('select[name="order_detail_id"]');
    if (sel) {
        const opt = Array.from(sel.options).find(o => o.value == id);
        if (!opt) { alert('Este producto ya no tiene cajas pendientes por asignar.'); return; }
        sel.value = id;
    }
    det.scrollIntoView({ behavior: 'smooth', block: 'center' });
    const inp = det.querySelector('input[name="cantidad_cajas"]');
    if (inp) setTimeout(() => inp.focus(), 250);
}

/* ── Escáner: muestra el estado del producto dentro de la orden ── */
function exScan() {
    const inp = document.getElementById('exScanner');
    const res = document.getElementById('exScanRes');
    const code = (inp.value || '').trim().toLowerCase();
    if (!code) return;

    let hit = null;
    document.querySelectorAll('#exTabla tr.ex-prow').forEach(tr => {
        if (hit) return;
        if ([tr.dataset.barcode, tr.dataset.boxBarcode, tr.dataset.sku].some(v => v && v.toLowerCase() === code)) hit = tr;
    });

    if (!hit) {
        res.className = 'ex-scan-res show err';
        res.innerHTML = '✖ <b>' + exEsc(inp.value.trim()) + '</b> no pertenece a esta orden.';
        inp.select();
        return;
    }

    exTab('prep');
    hit.style.display = '';
    const sol = +hit.dataset.solic, en = +hit.dataset.enpal, fal = +hit.dataset.falt;
    const done = fal <= 0 && sol > 0;
    res.className = 'ex-scan-res show ' + (done ? 'ok' : 'warn');
    res.innerHTML = (done ? '✔' : '⏳') + ' <b>' + exEsc(hit.dataset.name) + '</b>' +
        '<span>Solicitadas: <b>' + sol + '</b> cajas</span>' +
        '<span>En paletas: <b>' + en + '</b></span>' +
        '<span>' + (done ? 'Completo' : 'Faltan: <b>' + fal + '</b> cajas') + '</span>';

    hit.classList.remove('ex-hit');
    void hit.offsetWidth;
    hit.classList.add('ex-hit');
    hit.scrollIntoView({ behavior: 'smooth', block: 'center' });
    inp.value = '';
    inp.focus();
}

/* ── Cámara (BarcodeDetector, si el navegador lo soporta) ── */
let exStream = null, exCamTimer = null;
async function exCamara() {
    if (!navigator.mediaDevices || !window.BarcodeDetector) {
        alert('Tu navegador no admite lectura por cámara. Usa el lector de código de barras o escribe el código.');
        return;
    }
    const modal = document.getElementById('exCam');
    const video = document.getElementById('exCamVideo');
    modal.classList.add('open');
    try {
        exStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
        video.srcObject = exStream;
        await video.play();
        const det = new BarcodeDetector();
        exCamTimer = setInterval(async () => {
            try {
                const r = await det.detect(video);
                if (r.length) {
                    const v = r[0].rawValue;
                    exCamCerrar();
                    document.getElementById('exScanner').value = v;
                    exScan();
                }
            } catch (e) {}
        }, 350);
    } catch (e) {
        exCamCerrar();
        alert('No se pudo acceder a la cámara.');
    }
}
function exCamCerrar() {
    clearInterval(exCamTimer);
    exCamTimer = null;
    if (exStream) { exStream.getTracks().forEach(t => t.stop()); exStream = null; }
    document.getElementById('exCam').classList.remove('open');
}

/* ── Impresión de etiquetas de paleta (sin rutas: ventana de impresión) ── */
function exPrintSel() {
    if (!EX_SEL) { alert('Selecciona primero una paleta.'); return; }
    exPrint([EX_SEL]);
}
function exPrintTodas() {
    const ids = Object.keys(EX_PALLETS);
    if (!ids.length) { alert('No hay paletas creadas.'); return; }
    exPrint(ids);
}
function exPrint(ids) {
    const w = window.open('', '_blank');
    if (!w) { alert('Permite las ventanas emergentes para imprimir.'); return; }
    const css = 'body{font-family:Arial,Helvetica,sans-serif;margin:0;color:#0f172a}' +
        '.lbl{width:190mm;min-height:270mm;padding:12mm;box-sizing:border-box;page-break-after:always;border:2px solid #0f172a;margin:4mm auto}' +
        '.lbl:last-child{page-break-after:auto}' +
        'h1{font-size:64px;margin:0 0 6px;letter-spacing:-1px}h2{font-size:22px;margin:0 0 16px;color:#1e3a5f}' +
        '.meta{font-size:15px;line-height:1.7;margin-bottom:14px}.meta b{display:inline-block;min-width:90px;color:#475569}' +
        '.big{display:flex;gap:14px;margin:14px 0}.big div{flex:1;border:2px solid #0f172a;border-radius:8px;padding:10px;text-align:center}' +
        '.big strong{display:block;font-size:34px}.big span{font-size:12px;color:#475569}' +
        'table{width:100%;border-collapse:collapse;font-size:13px;margin-top:8px}th,td{border:1px solid #94a3b8;padding:6px 8px;text-align:left}th{background:#e2e8f0}' +
        '@page{size:A4;margin:8mm}';
    const html = ids.map(id => {
        const p = EX_PALLETS[id];
        if (!p) return '';
        const rows = p.items.map((it, i) =>
            '<tr><td>' + (i + 1) + '</td><td>' + exEsc(it.sku) + '</td><td>' + exEsc(it.n) + '</td><td>' +
            exEsc(it.pres) + '</td><td>' + it.cajas + '</td><td>' + it.peso + ' kg</td></tr>').join('');
        return '<section class="lbl">' +
            '<h1>PALLET ' + exEsc(p.orden) + '</h1><h2>' + exEsc(EX_ORDEN.numero) + '</h2>' +
            '<div class="meta"><div><b>Cliente:</b> ' + exEsc(EX_ORDEN.cliente) + '</div>' +
            '<div><b>Destino:</b> ' + exEsc(EX_ORDEN.destino || '—') + '</div>' +
            '<div><b>Fecha:</b> ' + exEsc(EX_ORDEN.fecha) + '</div></div>' +
            '<div class="big"><div><strong>' + p.cajas + ' / ' + p.cap + '</strong><span>CAJAS</span></div>' +
            '<div><strong>' + p.peso + ' kg</strong><span>PESO</span></div></div>' +
            '<table><thead><tr><th>#</th><th>SKU</th><th>Producto</th><th>Presentación</th><th>Cajas</th><th>Peso</th></tr></thead><tbody>' +
            (rows || '<tr><td colspan="6">Sin productos asignados</td></tr>') + '</tbody></table></section>';
    }).join('');
    w.document.write('<!doctype html><html><head><meta charset="utf-8"><title>Etiquetas ' + exEsc(EX_ORDEN.numero) +
        '</title><style>' + css + '</style></head><body>' + html + '</body></html>');
    w.document.close();
    w.focus();
    setTimeout(() => w.print(), 350);
}

/* ── Historial: filtros por tipo ── */
function exHist(f, btn) {
    document.querySelectorAll('.ex-fchip').forEach(b => b.classList.toggle('on', b === btn));
    const dias = {};
    document.querySelectorAll('#exTl .ex-ev').forEach(ev => {
        const ok = f === 'todos' || ev.dataset.tipo === f;
        ev.style.display = ok ? '' : 'none';
        if (ok) dias[ev.dataset.day] = true;
    });
    document.querySelectorAll('#exTl .ex-dayh').forEach(h => {
        h.style.display = dias[h.dataset.day] ? '' : 'none';
    });
}

/* ── Init ── */
(function () {
    // Pestaña recordada
    try {
        const t = sessionStorage.getItem(EX_TABKEY);
        if (t && document.querySelector('.ex-tab[data-tab="' + t + '"]')) exTab(t);
    } catch (e) {}

    // Paleta: #pallet-ID de la URL > última seleccionada > primera
    const cards = document.querySelectorAll('.ex-pcard');
    if (cards.length) {
        let pid = null;
        const m = (location.hash || '').match(/^#pallet-(\d+)$/);
        if (m && document.querySelector('.ex-pcard[data-pid="' + m[1] + '"]')) pid = m[1];
        if (!pid) { try { pid = localStorage.getItem(EX_KEY); } catch (e) {} }
        if (!pid || !document.querySelector('.ex-pcard[data-pid="' + pid + '"]')) pid = cards[0].dataset.pid;
        exSelPaleta(pid, true);
        if (m) exTab('prep');
    }
})();
</script>
@endsection
