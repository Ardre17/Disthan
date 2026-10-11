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
    --font-ui:'Segoe UI',sans-serif;
    --font-mono:'Consolas',monospace;
}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;font-size:13px;}
.erp-bar{background:#1e3a5f;height:38px;display:flex;align-items:center;justify-content:space-between;padding:0 1.25rem;margin:-20px -20px 0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{color:#fff;font-size:13px;font-weight:700;}
.erp-sep{width:1px;height:18px;background:#334155;}
.erp-module{color:#7eb8f7;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.body{padding:1.1rem;}
.page-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:8px;}
.page-title{font-size:17px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.page-title:before{content:"";width:4px;height:20px;background:var(--erp-accent);border-radius:2px;display:inline-block;}
.page-sub{font-size:11px;color:#64748b;margin-top:2px;}
.btn-new{background:var(--erp-accent);color:#fff;padding:8px 16px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s;}
.btn-new:hover{background:var(--erp-accent-dark);color:#fff;}
.kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:1rem;}
@media(max-width:800px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:24px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:3px;}
.kpi-val{font-size:20px;font-weight:800;color:var(--erp-ink);line-height:1;}
.kpi-sub{font-size:10px;color:#94a3b8;margin-top:1px;}
.filter-bar{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:.75rem 1rem;margin-bottom:1rem;display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;font-family:var(--font-ui);transition:border-color .15s;}
.finput{flex:1;min-width:160px;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.btn-search{padding:7px 16px;background:var(--erp-ink);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;}
.main-grid{display:grid;grid-template-columns:1fr 320px;gap:14px;margin-bottom:1.25rem;}
@media(max-width:900px){.main-grid{grid-template-columns:1fr;}}
.catalog{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px;}
.lbl-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;display:flex;flex-direction:column;transition:box-shadow .15s,border-color .15s;border-top:3px solid;}
.lbl-card:hover{border-color:#c2cbd8;box-shadow:0 2px 10px rgba(20,30,45,.08);}
.lbl-card-hdr{padding:.7rem .9rem .5rem;border-bottom:1px solid var(--erp-border);display:flex;justify-content:space-between;align-items:flex-start;gap:6px;}
.lbl-name{font-size:13px;font-weight:700;color:var(--erp-ink);line-height:1.3;}
.lbl-fmt{font-size:10px;color:var(--erp-ink-muted);margin-top:1px;font-family:var(--font-mono);}
.status-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:3px;white-space:nowrap;flex-shrink:0;}
.sb-ok  {background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.sb-warn{background:var(--erp-warn-bg);color:var(--erp-warn);border:1px solid #f9d5a3;}
.sb-low {background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}
.lbl-body{padding:.7rem .9rem;flex:1;}
.lbl-stock{font-size:24px;font-weight:800;line-height:1;font-family:var(--font-mono);}
.lbl-stock-sub{font-size:10px;color:var(--erp-ink-muted);margin-top:1px;margin-bottom:8px;}
.mini-bar{width:100%;height:4px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:8px;}
.mini-fill{height:100%;border-radius:99px;transition:width .4s;}
.meta-tags{display:flex;gap:4px;flex-wrap:wrap;}
.meta-tag{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:600;padding:2px 7px;border-radius:3px;}
.tag-es  {background:#fee2e2;color:#b91c1c;}
.tag-pt  {background:#dcfce7;color:#15803d;}
.tag-en  {background:#dbeafe;color:#1d4ed8;}
.tag-pais{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.tag-zona{background:#fdf1e2;color:var(--erp-warn);border:1px solid #f9d5a3;}
.lbl-footer{padding:.6rem .9rem;background:#f9fafb;border-top:1px solid var(--erp-border);display:flex;gap:5px;}
.btn-mov{flex:1;text-align:center;padding:6px;border-radius:3px;font-size:11px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:background .15s;}
.btn-edit-s{background:#fff;color:var(--erp-warn);border:1px solid var(--erp-warn);}
.btn-edit-s:hover{background:var(--erp-warn-bg);}
.btn-view-s{background:#fff;color:var(--erp-ok);border:1px solid var(--erp-ok);}
.btn-view-s:hover{background:var(--erp-ok-bg);}
/* Panel movimiento */
.panel{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;padding:1rem;}
.panel-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;min-height:200px;color:#cbd5e1;font-size:12px;}
.panel-title{font-size:13px;font-weight:700;color:var(--erp-ink);margin-bottom:.75rem;}
.mov-form-field{display:flex;flex-direction:column;gap:3px;margin-bottom:8px;}
.mov-label{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;}
.mov-input,.mov-select{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);}
.mov-input:focus,.mov-select:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.btn-entrada{width:100%;padding:8px;background:var(--erp-ok);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;margin-bottom:5px;}
.btn-salida{width:100%;padding:8px;background:var(--erp-danger);color:#fff;border:none;border-radius:3px;font-size:12px;font-weight:600;cursor:pointer;}
.btn-entrada:hover{background:#166534;}
.btn-salida:hover{background:#991b1b;}
/* Historial global */
.ht-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;overflow:hidden;}
.ht-hdr{padding:.85rem 1.1rem;border-bottom:1px solid var(--erp-border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;}
.ht table{width:100%;border-collapse:collapse;font-size:12px;}
.ht th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.ht td{padding:7px 10px;border-bottom:1px solid #f8fafc;color:#374151;vertical-align:middle;}
.ht tbody tr:hover td{background:#f8fafc;}
.tipo-e{background:var(--erp-ok-bg);color:var(--erp-ok);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;white-space:nowrap;}
.tipo-s{background:var(--erp-danger-bg);color:var(--erp-danger);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;white-space:nowrap;}
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}

/* ══════════════════════════════════════════════════════════
   CONTROL DE ETIQUETAS · rediseño (prefijo lb-) — aditivo
══════════════════════════════════════════════════════════ */
.lb{
    --lb-navy:#1e3a5f; --lb-blue:#1d7ff2; --lb-blue-soft:#eaf2ff;
    --lb-green:#16a34a; --lb-orange:#f59e0b; --lb-red:#ef4444;
    --lb-text:#0f172a; --lb-muted:#64748b; --lb-line:#e2e8f0; --lb-bg:#f8fafc;
    --lb-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
    color:var(--lb-text);
}
.lb-i{width:16px;height:16px;flex-shrink:0;}
.lb-num{font-family:var(--lb-mono);font-variant-numeric:tabular-nums;}
.lb-card{background:#fff;border:1px solid var(--lb-line);border-radius:14px;padding:14px 16px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.lb-card-t{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:800;margin:0 0 12px;}
.lb-card-t .lb-ico{width:24px;height:24px;border-radius:7px;background:var(--lb-blue-soft);color:var(--lb-blue);display:inline-flex;align-items:center;justify-content:center;}
.lb-card-t .lb-ico .lb-i{width:14px;height:14px;}
.lb-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:7px;font-size:11.5px;font-weight:700;white-space:nowrap;}

/* Cabecera */
.lb-crumb{font-size:12.5px;color:var(--lb-muted);margin-bottom:10px;}
.lb-crumb a{color:var(--lb-muted);text-decoration:none;}
.lb-crumb a:hover{color:var(--lb-blue);}
.lb-crumb b{color:var(--lb-text);font-weight:600;}
.lb-head{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:14px;}
.lb-head-l{display:flex;align-items:center;gap:14px;}
.lb-logo{width:60px;height:60px;border-radius:14px;background:#e3eefc;color:var(--lb-blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.lb-logo .lb-i{width:30px;height:30px;}
.lb-title{font-size:24px;font-weight:800;color:var(--lb-navy);margin:0;line-height:1.1;}
.lb-sub{font-size:13px;color:var(--lb-muted);margin-top:4px;max-width:640px;}
.lb-head-r{display:flex;gap:8px;flex-wrap:wrap;}
.lb-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;border:1px solid transparent;font-family:inherit;transition:filter .15s,background .15s;}
.lb-btn:hover{filter:brightness(.95);}
.lb-btn.blue{background:var(--lb-blue);color:#fff;}
.lb-btn.white{background:#fff;color:var(--lb-text);border-color:var(--lb-line);}
.lb-btn.sm{padding:8px 12px;font-size:12px;}
.lb-btn.blue-soft{background:var(--lb-blue-soft);color:var(--lb-blue);border-color:#cfe0fb;}

/* KPIs */
.lb-kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:14px;}
@media(max-width:900px){.lb-kpis{grid-template-columns:1fr 1fr;}}
@media(max-width:480px){.lb-kpis{grid-template-columns:1fr;}}
.lb-k{display:flex;align-items:center;gap:14px;border-radius:14px;padding:14px 16px;border:1px solid var(--lb-line);}
.lb-k-ic{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.lb-k-ic .lb-i{width:26px;height:26px;}
.lb-k small.l{display:block;font-size:12.5px;font-weight:600;color:#334155;}
.lb-k b{display:block;font-size:28px;font-weight:800;line-height:1.1;font-family:var(--lb-mono);}
.lb-k small.s{font-size:11.5px;color:var(--lb-muted);}
.lb-k.blue{background:#eef5ff;border-color:#dbe8ff;}.lb-k.blue .lb-k-ic{background:#dbeafe;color:#2563eb;}.lb-k.blue b{color:#1e3a5f;}
.lb-k.green{background:#effcf3;border-color:#c9f0d5;}.lb-k.green .lb-k-ic{background:#d1fae5;color:#16a34a;}.lb-k.green b{color:#16a34a;}
.lb-k.orange{background:#fff8ec;border-color:#fde7b0;}.lb-k.orange .lb-k-ic{background:#fde9c4;color:#d97706;}.lb-k.orange b{color:#d97706;}
.lb-k.red{background:#fff1f1;border-color:#fecaca;}.lb-k.red .lb-k-ic{background:#fee2e2;color:#dc2626;}.lb-k.red b{color:#dc2626;}

/* Layout */
.lb-grid{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:14px;align-items:start;}
@media(max-width:1200px){.lb-grid{grid-template-columns:1fr;}}
.lb-stack{display:flex;flex-direction:column;gap:14px;min-width:0;}

/* Filtros fila 1 */
.lb-f1{display:grid;grid-template-columns:1.7fr 1fr 1.25fr;gap:12px;}
@media(max-width:1000px){.lb-f1{grid-template-columns:1fr;}}
.lb-fcard{background:#fff;border:1px solid var(--lb-line);border-radius:12px;padding:10px 12px;}
.lb-flab{font-size:12px;font-weight:700;margin-bottom:7px;color:#334155;}
.lb-chips{display:flex;gap:6px;flex-wrap:wrap;}
.lb-fchip{display:inline-flex;align-items:center;gap:7px;border:1px solid var(--lb-line);background:#fff;border-radius:9px;padding:7px 12px;font-size:12.5px;font-weight:600;color:#334155;cursor:pointer;font-family:inherit;transition:background .15s,border-color .15s;}
.lb-fchip:hover{background:#f8fbff;}
.lb-fchip.on{background:var(--lb-blue-soft);border-color:var(--lb-blue);color:var(--lb-blue);}
.lb-fchip.vert{flex-direction:column;gap:4px;padding:7px 10px;min-width:62px;font-size:11.5px;}
.lb-fchip .fl{font-size:16px;line-height:1;}
.lb-fchip[disabled]{opacity:.45;cursor:not-allowed;}
.lb-sel{width:100%;padding:9px 10px;border:1px solid var(--lb-line);border-radius:9px;font-size:13px;background:#fff;font-family:inherit;color:var(--lb-text);}
.lb-sel:disabled{opacity:.55;}

/* Filtros fila 2 (formulario GET original) */
.lb-f2{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;background:#fff;border:1px solid var(--lb-line);border-radius:12px;padding:10px 12px;}
.lb-f2 .grow{flex:1;min-width:220px;}
.lb-f2 label{display:block;font-size:11.5px;font-weight:700;color:#334155;margin-bottom:4px;}
.lb-search{position:relative;}
.lb-search .lb-i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;}
.lb-search input{width:100%;padding:10px 12px 10px 34px;border:1px solid var(--lb-line);border-radius:9px;font-size:13px;outline:none;font-family:inherit;}
.lb-search input:focus,.lb-sel:focus{border-color:var(--lb-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);outline:none;}
.lb-f2 .w{width:150px;}
.lb-more{display:none;width:100%;gap:10px;align-items:flex-end;padding-top:6px;border-top:1px dashed var(--lb-line);margin-top:2px;}
.lb-more.open{display:flex;}
.lb-limpiar{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:9px;font-size:13px;font-weight:700;background:#eef2f7;color:#334155;text-decoration:none;}
.lb-limpiar:hover{background:#e2e8f0;}

/* Barra de selección */
.lb-bulk{display:none;align-items:center;gap:12px;background:#10244a;color:#fff;border-radius:10px;padding:8px 14px;font-size:12.5px;}
.lb-bulk.show{display:flex;}
.lb-bulk button{background:rgba(255,255,255,.14);border:none;color:#fff;border-radius:7px;padding:6px 12px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;}
.lb-bulk button:hover{background:rgba(255,255,255,.24);}

/* Tabla */
.lb-tcard{background:#fff;border:1px solid var(--lb-line);border-radius:14px;overflow:hidden;}
.lb-scroll{overflow-x:auto;}
.lb-tbl{width:100%;min-width:1040px;border-collapse:separate;border-spacing:0;font-size:12.5px;}
.lb-tbl th{background:#f1f5f9;color:#334155;font-size:11.5px;font-weight:700;padding:10px 9px;text-align:left;white-space:nowrap;}
.lb-tbl th.c,.lb-tbl td.c{text-align:center;}
.lb-tbl td{padding:8px 9px;border-bottom:1px solid #eef2f7;vertical-align:middle;}
.lb-tbl tr.lb-row{cursor:pointer;}
.lb-tbl tr.lb-row:hover td{background:#fafcff;}
.lb-tbl tr.lb-row.sel td{background:#eef5ff;}
.lb-tbl input[type=checkbox]{width:15px;height:15px;accent-color:var(--lb-blue);cursor:pointer;}
.lb-thumb{width:44px;height:38px;border-radius:7px;background:#f1f5f9;border:1px solid var(--lb-line);display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:18px;}
.lb-thumb img{width:100%;height:100%;object-fit:cover;}
.lb-nm{font-weight:600;}
.lb-cod{font-family:var(--lb-mono);color:#475569;}
.lb-fl{font-size:18px;line-height:1;}
.lb-tag{display:inline-block;font-size:10.5px;font-weight:700;padding:2px 7px;border-radius:5px;}
.lb-t-pro{background:#dbeafe;color:#1d4ed8;}.lb-t-caj{background:#ede9fe;color:#6d28d9;}.lb-t-pal{background:#fef3c7;color:#b45309;}.lb-t-per{background:#e2e8f0;color:#475569;}
.lb-ok{background:#dcfce7;color:#15803d;}.lb-bajo{background:#fef3c7;color:#b45309;}.lb-sin{background:#fee2e2;color:#b91c1c;}
.lb-acts{display:flex;gap:6px;justify-content:center;}
.lb-ic{width:34px;height:32px;border:1px solid var(--lb-line);background:#fff;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;color:#475569;padding:0;text-decoration:none;}
.lb-ic:hover{background:#f1f5f9;}
.lb-ic.blue{color:var(--lb-blue);border-color:#bcd6fb;}
.lb-ic .lb-i{width:15px;height:15px;}
.lb-empty{display:none;text-align:center;padding:26px;color:var(--lb-muted);font-size:13px;}
.lb-foot{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;padding:10px 14px;border-top:1px solid var(--lb-line);}
.lb-pager{display:flex;gap:5px;align-items:center;}
.lb-pg{min-width:32px;height:32px;border:1px solid var(--lb-line);background:#fff;border-radius:8px;font-size:12.5px;font-weight:600;color:#334155;cursor:pointer;font-family:inherit;}
.lb-pg.on{background:var(--lb-blue);border-color:var(--lb-blue);color:#fff;}
.lb-pg:disabled{opacity:.4;cursor:not-allowed;}

/* Menú flotante por fila */
.lb-rmenu{display:none;position:fixed;z-index:950;min-width:190px;background:#fff;border:1px solid var(--lb-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.18);padding:6px;}
.lb-rmenu.open{display:block;}
.lb-rmenu a,.lb-rmenu button{display:flex;align-items:center;gap:9px;width:100%;padding:9px 10px;border:none;background:none;border-radius:7px;font-size:13px;color:#1e293b;cursor:pointer;text-decoration:none;font-family:inherit;text-align:left;}
.lb-rmenu a:hover,.lb-rmenu button:hover{background:#f1f5f9;}

/* Gráficos inferiores */
.lb-charts{display:grid;grid-template-columns:1.05fr 1fr 1.25fr;gap:14px;}
@media(max-width:1100px){.lb-charts{grid-template-columns:1fr;}}
.lb-donut{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
.lb-donut svg{width:132px;height:132px;flex-shrink:0;}
.lb-leg{flex:1;min-width:140px;display:flex;flex-direction:column;gap:7px;font-size:12.5px;}
.lb-leg > div{display:flex;align-items:center;gap:8px;}
.lb-leg i{width:9px;height:9px;border-radius:50%;flex-shrink:0;}
.lb-leg span.n{margin-left:auto;font-family:var(--lb-mono);font-weight:700;}
.lb-leg span.p{color:var(--lb-muted);font-size:11px;min-width:34px;text-align:right;}
.lb-bars{display:flex;flex-direction:column;gap:11px;}
.lb-bar-r{display:grid;grid-template-columns:110px 1fr 32px;gap:10px;align-items:center;font-size:12.5px;}
.lb-bar-r .tr{height:12px;background:#eef2f7;border-radius:99px;overflow:hidden;}
.lb-bar-r .tr div{height:100%;border-radius:99px;}
.lb-bar-r b{font-family:var(--lb-mono);text-align:right;}
.lb-mini{width:100%;border-collapse:collapse;font-size:12px;}
.lb-mini th{background:#f1f5f9;color:#475569;font-size:10.5px;padding:7px 8px;text-align:left;}
.lb-mini td{padding:7px 8px;border-bottom:1px solid #eef2f7;}
.lb-mini td.r,.lb-mini th.r{text-align:right;}
.lb-note{font-size:10.5px;color:var(--lb-muted);margin-top:8px;}

/* Panel derecho */
.lb-side{position:sticky;top:calc(var(--tn-h,176px) + 12px);}
@media(max-width:1200px){.lb-side{position:static;}}
.lb-prev{background:#f8fafc;border:1px solid var(--lb-line);border-radius:12px;min-height:150px;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-bottom:12px;padding:8px;}
.lb-prev img{max-width:100%;max-height:170px;object-fit:contain;}
.lb-prev .ph{text-align:center;color:#94a3b8;}
.lb-prev .ph .big{font-size:40px;}
.lb-prev .ph b{display:block;color:#334155;font-size:13px;margin-top:6px;}
.lb-dl{font-size:12.5px;}
.lb-dl > div{display:grid;grid-template-columns:110px 1fr;gap:8px;padding:5px 0;align-items:center;}
.lb-dl span.k{color:var(--lb-muted);}
.lb-dl b{font-weight:600;}
.lb-side-btns{display:grid;grid-template-columns:1fr 1.4fr;gap:8px;margin-top:12px;}
.lb-side-btns a{justify-content:center;}
.lb-rec{display:grid;grid-template-columns:78px 66px 1fr;gap:8px;align-items:center;padding:8px 0;border-bottom:1px solid #eef2f7;font-size:12px;}
.lb-rec:last-of-type{border-bottom:none;}
.lb-rec .tp{font-weight:700;border-left:3px solid;padding-left:7px;}
.lb-rec .tp.in{color:#16a34a;border-color:#16a34a;}
.lb-rec .tp.out{color:#ea580c;border-color:#ea580c;}
.lb-rec .q{font-family:var(--lb-mono);font-weight:700;}
.lb-rec .m{color:#475569;}
.lb-rec .m small{display:block;color:#94a3b8;font-size:10.5px;}
.lb-link{display:block;text-align:center;margin-top:10px;font-size:12.5px;font-weight:600;color:var(--lb-blue);background:none;border:none;cursor:pointer;width:100%;font-family:inherit;}
</style>

<div class="page">
<div class="body">

@if(session('success'))
<div class="alert-ok">✅ {{ session('success') }}</div>
@endif

{{-- ── Datos adicionales para el rediseño (solo lectura; no tocan variables del controlador) ── --}}
@php
    $lbItems = $labels instanceof \Illuminate\Pagination\AbstractPaginator ? $labels->getCollection() : collect($labels);
    $lbMovs  = $movimientos instanceof \Illuminate\Pagination\AbstractPaginator ? $movimientos->getCollection() : collect($movimientos);

    $lbPaisMap = [
        'PERU'=>['🇵🇪','Perú'], 'PANAMA'=>['🇵🇦','Panamá'], 'COSTA_RICA'=>['🇨🇷','C.Rica'],
        'BRASIL'=>['🇧🇷','Brasil'], 'USA'=>['🇺🇸','EE.UU.'],
        'CHILE'=>['🇨🇱','Chile'], 'BOLIVIA'=>['🇧🇴','Bolivia'], 'ECUADOR'=>['🇪🇨','Ecuador'],
        'ARGENTINA'=>['🇦🇷','Argentina'], 'COLOMBIA'=>['🇨🇴','Colombia'], 'MEXICO'=>['🇲🇽','México'],
    ];
    $lbZonaMap = ['ZONA_SUL'=>['📍','Zona Sul'], 'SANTA_LUZIA'=>['📍','Santa Luzia']];
    $lbGeoLbl = function ($k) use ($lbPaisMap, $lbZonaMap) {
        $m = $lbPaisMap[$k] ?? ($lbZonaMap[$k] ?? null);
        return $m ? ($m[0] . ' ' . $m[1]) : ($k === 'SIN_DEFINIR' ? 'Sin definir' : ucwords(strtolower(str_replace('_', ' ', $k))));
    };
    $lbFmt = fn($n) => number_format((float) $n, 0);
    $lbFecha = fn($v, $f = 'd/m/Y') => $v ? \Carbon\Carbon::parse($v)->format($f) : '—';

    $lbCliente = function ($l) {
        $c = $l->cliente ?? $l->client ?? $l->customer ?? null;
        if (is_object($c)) { $c = $c->razon_social ?? $c->nombre ?? $c->name ?? null; }
        return is_string($c) && $c !== '' ? $c : null;
    };
    $lbTipoRaw = fn($l) => ($t = $l->tipo ?? $l->tipo_etiqueta ?? null) && is_string($t) ? strtoupper(trim($t)) : null;
    $lbTipoLbl = fn($t) => $t ? ucfirst(mb_strtolower($t)) : '—';
    $lbTipoCls = function ($t) {
        $t = mb_strtolower((string) $t);
        if (str_contains($t, 'prod')) return 'lb-t-pro';
        if (str_contains($t, 'caj'))  return 'lb-t-caj';
        if (str_contains($t, 'pal'))  return 'lb-t-pal';
        return 'lb-t-per';
    };
    $lbCodigo = fn($l) => ($l->codigo ?? $l->code ?? $l->sku ?? null) ?: ('ETQ-' . str_pad((string) $l->id, 3, '0', STR_PAD_LEFT));
    $lbImg = function ($l) {
        $i = $l->imagen ?? $l->foto ?? $l->image ?? $l->preview ?? null;
        if ($i && is_string($i) && !preg_match('#^(https?:)?//#', $i)) { $i = asset('storage/' . ltrim($i, '/')); }
        return is_string($i) ? $i : '';
    };

    // Rotación y últimos movimientos (con los movimientos cargados en la vista)
    $lbDesde = now()->subDays(30);
    $lbSalidas = []; $lbUltIng = []; $lbUltSal = []; $lbLabelById = [];
    foreach ($lbMovs as $m) {
        $lid = $m->label_id ?? ($m->label->id ?? null);
        if (!$lid) { continue; }
        $lbLabelById[$lid] = $m->label ?? null;
        $f = \Carbon\Carbon::parse($m->created_at);
        if ($m->tipo === 'SALIDA') {
            if ($f->gte($lbDesde)) { $lbSalidas[$lid] = ($lbSalidas[$lid] ?? 0) + (float) $m->cantidad; }
            if (!isset($lbUltSal[$lid]) || $f->gt($lbUltSal[$lid])) { $lbUltSal[$lid] = $f; }
        } else {
            if (!isset($lbUltIng[$lid]) || $f->gt($lbUltIng[$lid])) { $lbUltIng[$lid] = $f; }
        }
    }

    // Datos por etiqueta
    $lbRows = [];
    foreach ($lbItems as $l) {
        $sal = $lbSalidas[$l->id] ?? 0;
        $rot = $sal <= 0 ? 'BAJA' : ($sal >= max(1, (float) $l->stock_minimo) ? 'ALTA' : 'MEDIA');
        $lbRows[$l->id] = ['rot' => $rot, 'sal' => $sal];
    }

    // Chips de país/zona, clientes y tipos que realmente existen en los datos
    $lbGeo = []; $lbClientes = []; $lbTipos = []; $lbIdiomas = [];
    foreach ($lbItems as $l) {
        $k = $l->pais ?: ($l->zona ?: 'SIN_DEFINIR');
        $lbGeo[$k] = ($lbGeo[$k] ?? 0) + 1;
        $c = $lbCliente($l); if ($c) { $lbClientes[$c] = true; }
        $t = $lbTipoRaw($l); if ($t) { $lbTipos[$t] = ($lbTipos[$t] ?? 0) + 1; }
        $lbIdiomas[$l->idioma ?? '—'] = ($lbIdiomas[$l->idioma ?? '—'] ?? 0) + 1;
    }
    arsort($lbGeo);
    ksort($lbClientes);

    // Donut: etiquetas por país
    $lbColors = ['#ef4444','#2563eb','#10b981','#f59e0b','#8b5cf6','#06b6d4','#ec4899'];
    $lbGeoTotal = max(1, array_sum($lbGeo));
    $lbCirc = 2 * M_PI * 40; $lbOff = 0; $lbSegs = []; $ci = 0;
    foreach ($lbGeo as $k => $n) {
        $len = ($n / $lbGeoTotal) * $lbCirc;
        $lbSegs[] = ['k' => $k, 'n' => $n, 'p' => round($n / $lbGeoTotal * 100), 'c' => $lbColors[$ci % count($lbColors)], 'len' => round($len, 2), 'off' => round($lbOff, 2)];
        $lbOff += $len; $ci++;
    }

    // Barras: por tipo (o por idioma si las etiquetas no tienen tipo)
    if (count($lbTipos)) {
        $lbBarTitle = 'Etiquetas por tipo'; $lbBarData = $lbTipos;
    } else {
        $lbBarTitle = 'Etiquetas por idioma'; $lbBarData = $lbIdiomas;
    }
    arsort($lbBarData);
    $lbBarMax = max(1, max($lbBarData ?: [1]));

    // Top 5 por salidas (30 días)
    arsort($lbSalidas);
    $lbTop = array_slice($lbSalidas, 0, 5, true);

    $lbBusca = $lbItems->keyBy('id');
    $lbRecientes = $lbMovs->take(5);
@endphp

{{-- Iconos --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="lb-tag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></symbol>
    <symbol id="lb-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
    <symbol id="lb-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
    <symbol id="lb-list" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></symbol>
    <symbol id="lb-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="lb-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
    <symbol id="lb-filter" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></symbol>
    <symbol id="lb-sliders" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></symbol>
    <symbol id="lb-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="lb-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></symbol>
    <symbol id="lb-dots" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="19" cy="12" r="1.8"/></symbol>
    <symbol id="lb-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></symbol>
    <symbol id="lb-pie" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></symbol>
    <symbol id="lb-trend" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></symbol>
</defs></svg>

<div class="lb">

{{-- ══════════ BREADCRUMB + CABECERA ══════════ --}}
<div class="lb-crumb"><a href="/dashboard">Operaciones</a> &nbsp;/&nbsp; <b>Etiquetas</b></div>

<div class="lb-head">
    <div class="lb-head-l">
        <div class="lb-logo"><svg class="lb-i"><use href="#lb-tag"/></svg></div>
        <div>
            <h1 class="lb-title">Control de etiquetas</h1>
            <div class="lb-sub">Gestiona el stock de etiquetas por país, cliente y tipo. Registra ingresos, salidas y mantén tu inventario actualizado.</div>
        </div>
    </div>
    <div class="lb-head-r">
        <button type="button" class="lb-btn white" onclick="lbIrHist()"><svg class="lb-i"><use href="#lb-list"/></svg> Movimientos</button>
        <a href="{{ route('labels.create') }}" class="lb-btn blue"><svg class="lb-i"><use href="#lb-plus"/></svg> Nueva etiqueta</a>
    </div>
</div>

{{-- ══════════ KPIs (mismas variables del controlador) ══════════ --}}
<div class="lb-kpis">
    <div class="lb-k blue">
        <div class="lb-k-ic"><svg class="lb-i"><use href="#lb-tag"/></svg></div>
        <div><small class="l">Total de etiquetas</small><b>{{ $total }}</b><small class="s">Tipos registrados · {{ $disponibles }} disponibles</small></div>
    </div>
    <div class="lb-k green">
        <div class="lb-k-ic"><svg class="lb-i"><use href="#lb-box"/></svg></div>
        <div><small class="l">Stock total</small><b>{{ number_format($totalStock,0) }}</b><small class="s">Unidades disponibles</small></div>
    </div>
    <div class="lb-k orange">
        <div class="lb-k-ic"><svg class="lb-i"><use href="#lb-alert"/></svg></div>
        <div><small class="l">Stock bajo</small><b>{{ $stockBajo }}</b><small class="s">Tipos de etiquetas</small></div>
    </div>
    <div class="lb-k red">
        <div class="lb-k-ic"><svg class="lb-i"><use href="#lb-alert"/></svg></div>
        <div><small class="l">Sin stock</small><b>{{ $agotadas }}</b><small class="s">Tipos de etiquetas</small></div>
    </div>
</div>

<div class="lb-grid">

{{-- ═════════════ COLUMNA IZQUIERDA ═════════════ --}}
<div class="lb-stack">

    {{-- Filtros: país · cliente · tipo (filtran las filas en pantalla) --}}
    <div class="lb-f1">
        <div class="lb-fcard">
            <div class="lb-flab">País</div>
            <div class="lb-chips" id="lbChipsPais">
                <button type="button" class="lb-fchip on" data-v="" onclick="lbChip('pais',this)"><svg class="lb-i"><use href="#lb-globe"/></svg> Todos</button>
                @foreach($lbGeo as $gk => $gn)
                    @if($gk !== 'SIN_DEFINIR')
                        @php $gl = $lbGeoLbl($gk); @endphp
                        <button type="button" class="lb-fchip" data-v="{{ $gk }}" onclick="lbChip('pais',this)" title="{{ $gn }} etiqueta(s)">
                            {{ $gl }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="lb-fcard">
            <div class="lb-flab">Cliente</div>
            <select class="lb-sel" id="lbFCliente" onchange="lbApply()" @if(!count($lbClientes)) disabled title="Las etiquetas no tienen cliente asociado" @endif>
                <option value="">Todos los clientes</option>
                @foreach(array_keys($lbClientes) as $cn)
                    <option value="{{ mb_strtolower($cn) }}">{{ $cn }}</option>
                @endforeach
            </select>
        </div>

        <div class="lb-fcard">
            <div class="lb-flab">Tipo de etiqueta</div>
            <div class="lb-chips" id="lbChipsTipo">
                <button type="button" class="lb-fchip vert on" data-v="" onclick="lbChip('tipo',this)"><svg class="lb-i"><use href="#lb-tag"/></svg>Todos</button>
                @if(count($lbTipos))
                    @foreach($lbTipos as $tk => $tn)
                        <button type="button" class="lb-fchip vert" data-v="{{ $tk }}" onclick="lbChip('tipo',this)" title="{{ $tn }} etiqueta(s)">
                            <svg class="lb-i"><use href="#lb-box"/></svg>{{ $lbTipoLbl($tk) }}
                        </button>
                    @endforeach
                @else
                    @foreach(['Producto','Caja','Paleta','Personalizada'] as $tk)
                        <button type="button" class="lb-fchip vert" disabled title="Las etiquetas no tienen tipo registrado"><svg class="lb-i"><use href="#lb-box"/></svg>{{ $tk }}</button>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Búsqueda / estado / rotación — formulario GET original (search, idioma, estado) --}}
    <form method="GET" class="lb-f2" id="lbForm">
        <div class="grow">
            <label>&nbsp;</label>
            <div class="lb-search">
                <svg class="lb-i"><use href="#lb-search"/></svg>
                <input type="text" name="search" id="lbBuscar" value="{{ request('search') }}" placeholder="Buscar etiqueta por nombre, código o cliente..." oninput="lbApply()">
            </div>
        </div>
        <div class="w">
            <label>Estado</label>
            <select name="estado" class="lb-sel" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="DISPONIBLE" @selected(request('estado')==='DISPONIBLE')>Óptimo</option>
                <option value="STOCK_BAJO" @selected(request('estado')==='STOCK_BAJO')>Stock bajo</option>
                <option value="AGOTADO"    @selected(request('estado')==='AGOTADO')>Sin stock</option>
            </select>
        </div>
        <div class="w">
            <label>Rotación</label>
            <select class="lb-sel" id="lbFRot" onchange="lbApply()">
                <option value="">Todas</option>
                <option value="ALTA">Alta</option>
                <option value="MEDIA">Media</option>
                <option value="BAJA">Baja</option>
            </select>
        </div>
        <button type="button" class="lb-btn white" style="color:var(--lb-blue);" onclick="document.getElementById('lbMore').classList.toggle('open')"><svg class="lb-i"><use href="#lb-sliders"/></svg> Más filtros</button>
        <button type="submit" class="lb-btn blue-soft"><svg class="lb-i"><use href="#lb-search"/></svg> Buscar</button>
        <a href="{{ route('labels.index') }}" class="lb-limpiar"><svg class="lb-i"><use href="#lb-filter"/></svg> Limpiar</a>

        <div class="lb-more {{ request('idioma') ? 'open' : '' }}" id="lbMore">
            <div class="w">
                <label>Idioma</label>
                <select name="idioma" class="lb-sel" onchange="this.form.submit()">
                    <option value="">Todos los idiomas</option>
                    <option value="ES" @selected(request('idioma')==='ES')>🇪🇸 Español</option>
                    <option value="PT" @selected(request('idioma')==='PT')>🇧🇷 Portugués</option>
                    <option value="EN" @selected(request('idioma')==='EN')>🇺🇸 Inglés</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Barra de selección múltiple --}}
    <div class="lb-bulk" id="lbBulk">
        <span><b id="lbBulkN">0</b> seleccionadas</span>
        <button type="button" onclick="lbExportSel()">⬇ Exportar CSV</button>
        <button type="button" onclick="lbQuitarSel()">Quitar selección</button>
    </div>

    {{-- Tabla de etiquetas (reemplaza las tarjetas; mismas acciones: Editar y Kardex) --}}
    <div class="lb-tcard">
        <div class="lb-scroll">
        <table class="lb-tbl" id="lbTabla">
            <thead>
                <tr>
                    <th style="width:34px;"><input type="checkbox" id="lbAll" onclick="lbToggleAll(this)" title="Seleccionar visibles"></th>
                    <th>#</th>
                    <th>Vista</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Idioma</th>
                    <th>Cliente</th>
                    <th class="c">País / Zona</th>
                    <th>Tipo</th>
                    <th>Medidas</th>
                    <th class="c">Stock</th>
                    <th class="c">Stock mín.</th>
                    <th>Estado</th>
                    <th class="c">Acciones</th>
                </tr>
            </thead>
            <tbody id="lbTbody">
            @forelse($labels as $lbl)
                @php
                    $est   = $lbl->estado;
                    $topC  = match($est){ 'DISPONIBLE'=>'#22c55e','STOCK_BAJO'=>'#f59e0b',default=>'#ef4444' };
                    $stkC  = match($est){ 'DISPONIBLE'=>'#16a34a','STOCK_BAJO'=>'#d97706',default=>'#dc2626' };
                    $sbCls = match($est){ 'DISPONIBLE'=>'lb-ok','STOCK_BAJO'=>'lb-bajo',default=>'lb-sin' };
                    $sbLbl = match($est){ 'DISPONIBLE'=>'Óptimo','STOCK_BAJO'=>'Stock bajo',default=>'Sin stock' };
                    $langCls = match($lbl->idioma){ 'ES'=>'tag-es','PT'=>'tag-pt',default=>'tag-en' };
                    $langLbl = match($lbl->idioma){ 'ES'=>'🇪🇸 ES','PT'=>'🇧🇷 PT',default=>'🇺🇸 EN' };
                    $paisLabel = match($lbl->pais ?? ''){
                        'PERU'=>'🇵🇪 Perú','PANAMA'=>'🇵🇦 Panamá','COSTA_RICA'=>'🇨🇷 C.Rica',
                        'BRASIL'=>'🇧🇷 Brasil','USA'=>'🇺🇸 EE.UU.',default=>''
                    };
                    $zonaLabel = match($lbl->zona ?? ''){
                        'ZONA_SUL'=>'Zona Sul','SANTA_LUZIA'=>'Santa Luzia',default=>''
                    };

                    $lbPaisFull = $lbl->pais ? $lbGeoLbl($lbl->pais) : '';
                    $lbFlag = $lbl->pais && isset($lbPaisMap[$lbl->pais]) ? $lbPaisMap[$lbl->pais][0] : '';
                    $lbTipoV = $lbTipoRaw($lbl);
                    $lbCli = $lbCliente($lbl);
                    $lbCod = $lbCodigo($lbl);
                    $lbImgU = $lbImg($lbl);
                    $lbRot = $lbRows[$lbl->id]['rot'] ?? 'BAJA';
                    $lbGeoTok = trim(($lbl->pais ?? '') . ' ' . ($lbl->zona ?? ''));
                @endphp
                <tr class="lb-row"
                    data-id="{{ $lbl->id }}"
                    data-codigo="{{ $lbCod }}"
                    data-nombre="{{ $lbl->nombre }}"
                    data-cliente="{{ $lbCli ?? '' }}"
                    data-geo="{{ $lbGeoTok }}"
                    data-paisl="{{ $paisLabel ?: ($zonaLabel ?: '') }}"
                    data-tipo="{{ $lbTipoV ?? '' }}"
                    data-tipol="{{ $lbTipoV ? $lbTipoLbl($lbTipoV) : '' }}"
                    data-medidas="{{ $lbl->formato ?? '' }}"
                    data-idioma="{{ $langLbl }}"
                    data-stock="{{ (float) $lbl->stock_actual }}"
                    data-min="{{ (float) $lbl->stock_minimo }}"
                    data-estado="{{ $sbLbl }}"
                    data-estcls="{{ $sbCls }}"
                    data-rot="{{ $lbRot }}"
                    data-ing="{{ isset($lbUltIng[$lbl->id]) ? $lbUltIng[$lbl->id]->format('d/m/Y') : '' }}"
                    data-sal="{{ isset($lbUltSal[$lbl->id]) ? $lbUltSal[$lbl->id]->format('d/m/Y') : '' }}"
                    data-edit="{{ route('labels.edit', $lbl) }}"
                    data-show="{{ route('labels.show', $lbl) }}"
                    data-img="{{ $lbImgU }}"
                    data-search="{{ mb_strtolower($lbl->nombre.' '.$lbCod.' '.($lbCli ?? '')) }}">
                    <td onclick="event.stopPropagation()"><input type="checkbox" class="lb-chk" onclick="lbChkChange()"></td>
                    <td class="lb-num">{{ $loop->iteration }}</td>
                    <td><div class="lb-thumb">@if($lbImgU)<img src="{{ $lbImgU }}" alt="" loading="lazy" onerror="this.replaceWith(document.createTextNode('🏷️'))">@else 🏷️ @endif</div></td>
                    <td class="lb-cod">{{ $lbCod }}</td>
                    <td class="lb-nm">{{ $lbl->nombre }}</td>
                    <td><span class="meta-tag {{ $langCls }}">{{ $langLbl }}</span></td>
                    <td>{{ $lbCli ?? '—' }}</td>
                    <td class="c">
                        @if($lbFlag)<span class="lb-fl" title="{{ $paisLabel }}">{{ $lbFlag }}</span>
                        @elseif($paisLabel)<span title="{{ $paisLabel }}">{{ $paisLabel }}</span>@endif
                        @if($zonaLabel)<div><span class="meta-tag tag-zona">{{ $zonaLabel }}</span></div>@endif
                        @if(!$paisLabel && !$zonaLabel)—@endif
                    </td>
                    <td>@if($lbTipoV)<span class="lb-tag {{ $lbTipoCls($lbTipoV) }}">{{ $lbTipoLbl($lbTipoV) }}</span>@else<span style="color:#94a3b8;">—</span>@endif</td>
                    <td class="lb-num" style="white-space:nowrap;">{{ $lbl->formato ?? '—' }}</td>
                    <td class="c lb-num" style="font-weight:800;color:{{ $stkC }};">{{ number_format($lbl->stock_actual,0) }}</td>
                    <td class="c lb-num" style="color:#64748b;">{{ number_format($lbl->stock_minimo,0) }}</td>
                    <td><span class="lb-tag {{ $sbCls }}">{{ $sbLbl }}</span></td>
                    <td onclick="event.stopPropagation()">
                        <div class="lb-acts">
                            <a href="{{ route('labels.show', $lbl) }}" class="lb-ic blue" title="Ver kardex"><svg class="lb-i"><use href="#lb-eye"/></svg></a>
                            <a href="{{ route('labels.edit', $lbl) }}" class="lb-ic" title="Editar"><svg class="lb-i"><use href="#lb-edit"/></svg></a>
                            <button type="button" class="lb-ic" title="Más acciones" onclick="lbRowMenu(this,event)"><svg class="lb-i"><use href="#lb-dots"/></svg></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="14" style="padding:0;border:none;">
                    <div style="background:var(--erp-surface);border:1px dashed var(--erp-border);border-radius:4px;padding:3rem;text-align:center;color:var(--erp-ink-muted);margin:12px;">
                        <div style="font-size:32px;margin-bottom:8px;">🏷️</div>
                        <div style="font-size:14px;font-weight:600;color:var(--erp-ink);">No hay etiquetas registradas</div>
                        <div style="font-size:12px;margin:.5rem 0 1rem;">Crea tu primera etiqueta para comenzar.</div>
                        <a href="{{ route('labels.create') }}" class="btn-new">➕ Nueva etiqueta</a>
                    </div>
                </td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
        <div class="lb-empty" id="lbEmpty">Ninguna etiqueta coincide con los filtros.</div>

        <div class="lb-foot">
            <div class="lb-pager" id="lbPager"></div>
            <div style="font-size:12.5px;color:var(--lb-muted);" id="lbInfo"></div>
            <select class="lb-sel" style="width:130px;" id="lbPerPage" onchange="lbPer()">
                <option value="10">10 por página</option>
                <option value="25">25 por página</option>
                <option value="50">50 por página</option>
                <option value="100">100 por página</option>
            </select>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="lb-charts">
        <div class="lb-card">
            <h3 class="lb-card-t"><span class="lb-ico"><svg class="lb-i"><use href="#lb-pie"/></svg></span> Etiquetas por país</h3>
            <div class="lb-donut">
                <svg viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#eef2f7" stroke-width="16"/>
                    @foreach($lbSegs as $sg)
                        <circle cx="50" cy="50" r="40" fill="none" stroke="{{ $sg['c'] }}" stroke-width="16"
                                stroke-dasharray="{{ $sg['len'] }} {{ round($lbCirc - $sg['len'], 2) }}"
                                stroke-dashoffset="{{ -$sg['off'] }}" transform="rotate(-90 50 50)"/>
                    @endforeach
                </svg>
                <div class="lb-leg">
                    @forelse($lbSegs as $sg)
                        <div><i style="background:{{ $sg['c'] }};"></i><span>{{ $lbGeoLbl($sg['k']) }}</span><span class="n">{{ $sg['n'] }}</span><span class="p">({{ $sg['p'] }}%)</span></div>
                    @empty
                        <div style="color:#94a3b8;">Sin datos</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lb-card">
            <h3 class="lb-card-t"><span class="lb-ico"><svg class="lb-i"><use href="#lb-box"/></svg></span> {{ $lbBarTitle }}</h3>
            <div class="lb-bars">
                @forelse($lbBarData as $bk => $bn)
                    @php $bcol = $lbColors[$loop->index % count($lbColors)]; @endphp
                    <div class="lb-bar-r">
                        <span>{{ $lbBarTitle === 'Etiquetas por tipo' ? $lbTipoLbl($bk) : $bk }}</span>
                        <div class="tr"><div style="width:{{ round($bn / $lbBarMax * 100) }}%;background:{{ $bcol }};"></div></div>
                        <b>{{ $bn }}</b>
                    </div>
                @empty
                    <div style="color:#94a3b8;font-size:12.5px;">Sin datos</div>
                @endforelse
            </div>
        </div>

        <div class="lb-card">
            <h3 class="lb-card-t"><span class="lb-ico"><svg class="lb-i"><use href="#lb-trend"/></svg></span> Top 5 con mayor rotación</h3>
            <table class="lb-mini">
                <thead><tr><th>#</th><th>Etiqueta</th><th>Cliente</th><th class="r">Salidas (30 d)</th></tr></thead>
                <tbody>
                @forelse($lbTop as $tid => $tq)
                    @php
                        $tl = $lbBusca[$tid] ?? ($lbLabelById[$tid] ?? null);
                        $tcli = $tl ? $lbCliente($tl) : null;
                    @endphp
                    <tr>
                        <td class="lb-num">{{ $loop->iteration }}</td>
                        <td style="font-weight:600;">{{ $tl->nombre ?? '—' }}</td>
                        <td>{{ $tcli ?? '—' }}</td>
                        <td class="r lb-num" style="font-weight:700;">{{ number_format($tq, 0) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:14px;">Sin salidas en los últimos 30 días</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="lb-note">Calculado con los últimos 50 movimientos cargados.</div>
        </div>
    </div>
</div>

{{-- ═════════════ COLUMNA DERECHA ═════════════ --}}
<div class="lb-stack lb-side">

    <div class="lb-card" id="panelMov">
        <h3 class="lb-card-t"><span class="lb-ico"><svg class="lb-i"><use href="#lb-tag"/></svg></span> Detalle de etiqueta</h3>

        <div class="panel-empty" id="panelEmpty" style="min-height:140px;">
            <span style="font-size:32px;">🏷️</span>
            <span>Selecciona una etiqueta de la tabla para ver su detalle</span>
        </div>

        <div id="lbDetail" style="display:none;">
            <div class="lb-prev" id="lbPrev"></div>
            <div class="lb-dl">
                <div><span class="k">Código:</span><b id="dCodigo" class="lb-num"></b></div>
                <div><span class="k">Nombre:</span><b id="dNombre"></b></div>
                <div><span class="k">Cliente:</span><b id="dCliente"></b></div>
                <div><span class="k">País / Zona:</span><b id="dPais"></b></div>
                <div><span class="k">Idioma:</span><b id="dIdioma"></b></div>
                <div><span class="k">Tipo:</span><b id="dTipo"></b></div>
                <div><span class="k">Medidas:</span><b id="dMedidas" class="lb-num"></b></div>
                <div><span class="k">Stock actual:</span><b id="dStock" class="lb-num"></b></div>
                <div><span class="k">Stock mínimo:</span><b id="dMin" class="lb-num"></b></div>
                <div><span class="k">Estado:</span><b id="dEstado"></b></div>
                <div><span class="k">Rotación:</span><b id="dRot"></b></div>
                <div><span class="k">Último ingreso:</span><b id="dIng" class="lb-num"></b></div>
                <div><span class="k">Última salida:</span><b id="dSal" class="lb-num"></b></div>
            </div>
            <div class="lb-side-btns">
                <a href="#" id="dEdit" class="lb-btn white sm"><svg class="lb-i"><use href="#lb-edit"/></svg> Editar</a>
                <a href="#" id="dShow" class="lb-btn blue sm"><svg class="lb-i"><use href="#lb-list"/></svg> Registrar movimiento</a>
            </div>
            <div class="lb-note" style="text-align:center;">Los movimientos se registran desde el kardex de la etiqueta.</div>
        </div>
    </div>

    <div class="lb-card">
        <h3 class="lb-card-t"><span class="lb-ico"><svg class="lb-i"><use href="#lb-list"/></svg></span> Movimientos recientes</h3>
        @forelse($lbRecientes as $rm)
            @php $isIn = $rm->tipo === 'ENTRADA'; @endphp
            <div class="lb-rec">
                <span class="lb-num" style="color:#64748b;">{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</span>
                <span class="tp {{ $isIn ? 'in' : 'out' }}">{{ $isIn ? 'Ingreso' : 'Salida' }}</span>
                <span class="m">
                    <b class="q" style="color:{{ $isIn ? '#16a34a' : '#ea580c' }};">{{ $isIn ? '+' : '−' }}{{ number_format($rm->cantidad,0) }}</b>
                    <small>{{ $rm->label->nombre ?? '—' }}{{ $rm->motivo ? ' · '.$rm->motivo : '' }}</small>
                </span>
            </div>
        @empty
            <div style="text-align:center;color:#94a3b8;padding:14px;font-size:12.5px;">Sin movimientos</div>
        @endforelse
        <button type="button" class="lb-link" onclick="lbIrHist()">Ver todos los movimientos</button>
    </div>
</div>

</div>{{-- /.lb-grid --}}

{{-- ══════════ HISTORIAL GLOBAL (original, sin cambios) ══════════ --}}
<div id="lbHist" style="margin-top:14px;scroll-margin-top:calc(var(--tn-h,176px) + 12px);">
{{-- Historial global --}}
<div class="ht-card">
    <div class="ht-hdr">
        <div style="font-size:13px;font-weight:700;color:var(--erp-ink);">📋 Últimos 50 movimientos</div>
        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <select class="fselect" onchange="filtrarHist(this.value,'tipo')">
                <option value="">Todos</option>
                <option value="ENTRADA">⬆ Entradas</option>
                <option value="SALIDA">⬇ Salidas</option>
            </select>
            <input class="finput" style="width:170px;" placeholder="Buscar etiqueta..."
                   oninput="filtrarHist(this.value,'nombre')">
        </div>
    </div>
    <div class="ht" style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Etiqueta</th>
                    <th>Idioma</th>
                    <th>País / Zona</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Saldo</th>
                    <th>Motivo</th>
                    <th>Referencia</th>
                </tr>
            </thead>
            <tbody id="histTbody">
            @forelse($movimientos as $mov)
            @php
                $lc = $mov->tipo === 'ENTRADA' ? 'var(--erp-ok)' : 'var(--erp-danger)';
                $langCls2 = match($mov->label->idioma ?? ''){
                    'ES'=>'tag-es','PT'=>'tag-pt',default=>'tag-en'
                };
                $langLbl2 = match($mov->label->idioma ?? ''){
                    'ES'=>'🇪🇸 ES','PT'=>'🇧🇷 PT',default=>'🇺🇸 EN'
                };
                $paisZona = $mov->label->pais
                    ? match($mov->label->pais){
                        'PERU'=>'🇵🇪 Perú','PANAMA'=>'🇵🇦 Panamá',
                        'COSTA_RICA'=>'🇨🇷 C.Rica','BRASIL'=>'🇧🇷 Brasil','USA'=>'🇺🇸 EE.UU.',
                        default=>$mov->label->pais
                      }
                    : ($mov->label->zona
                        ? match($mov->label->zona){
                            'ZONA_SUL'=>'Zona Sul','SANTA_LUZIA'=>'Santa Luzia',
                            default=>$mov->label->zona
                          }
                        : '—');
            @endphp
            <tr data-tipo="{{ $mov->tipo }}"
                data-nombre="{{ strtolower($mov->label->nombre ?? '') }}">
                <td style="color:#94a3b8;white-space:nowrap;font-size:11px;">
                    {{ \Carbon\Carbon::parse($mov->created_at)->format('d M Y H:i') }}
                </td>
                <td style="font-weight:600;color:var(--erp-ink);">{{ $mov->label->nombre ?? '—' }}</td>
                <td><span class="meta-tag {{ $langCls2 }}">{{ $langLbl2 }}</span></td>
                <td style="color:#64748b;font-size:11px;">{{ $paisZona }}</td>
                <td><span class="{{ $mov->tipo === 'ENTRADA' ? 'tipo-e' : 'tipo-s' }}">
                    {{ $mov->tipo === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}
                </span></td>
                <td style="font-weight:700;color:{{ $lc }};font-family:var(--font-mono);">
                    {{ $mov->tipo === 'ENTRADA' ? '+' : '−' }}{{ number_format($mov->cantidad,0) }}
                </td>
                <td style="font-family:var(--font-mono);color:var(--erp-ink-muted);">
                    {{ number_format($mov->saldo_post,0) }}
                </td>
                <td style="color:#475569;">{{ $mov->motivo ?? '—' }}</td>
                <td style="color:#94a3b8;font-size:11px;">{{ $mov->referencia ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#94a3b8;padding:2rem;">Sin movimientos</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>

</div>{{-- /.lb --}}

{{-- Menú flotante por fila --}}
<div class="lb-rmenu" id="lbRMenu" onclick="event.stopPropagation()">
    <button type="button" onclick="lbRowAct('panel')">👁 Ver detalle en el panel</button>
    <a href="#" id="lbRmShow">📋 Kardex / registrar movimiento</a>
    <a href="#" id="lbRmEdit">✏️ Editar</a>
</div>

</div>
</div>

<script>
var hFiltTipo='', hFiltNombre='';
function filtrarHist(val, campo){
    if(campo==='tipo')   hFiltTipo   = val;
    if(campo==='nombre') hFiltNombre = val.toLowerCase();
    document.querySelectorAll('#histTbody tr[data-tipo]').forEach(function(tr){
        var mT = !hFiltTipo   || tr.dataset.tipo   === hFiltTipo;
        var mN = !hFiltNombre || tr.dataset.nombre.includes(hFiltNombre);
        tr.style.display = (mT && mN) ? '' : 'none';
    });
}
</script>

<script>
// ══════════════════════════════════════════════════════════
//  CONTROL DE ETIQUETAS · interacciones del rediseño (aditivo)
//  No modifica filtrarHist ni el formulario GET original.
// ══════════════════════════════════════════════════════════
var LB_PAGE = 1, LB_PER = 10, LB_F = { pais: '', tipo: '' }, LB_VIS = [], LB_MROW = null;

function lbRows() { return Array.prototype.slice.call(document.querySelectorAll('#lbTbody tr.lb-row')); }

/* ── Chips País / Tipo ── */
function lbChip(grp, btn) {
    btn.parentElement.querySelectorAll('.lb-fchip').forEach(function (b) { b.classList.toggle('on', b === btn); });
    LB_F[grp] = btn.dataset.v || '';
    LB_PAGE = 1;
    lbApply();
}

/* ── Filtros en pantalla + paginación ── */
function lbMatch(tr) {
    var q   = (document.getElementById('lbBuscar').value || '').trim().toLowerCase();
    var cli = document.getElementById('lbFCliente').value;
    var rot = document.getElementById('lbFRot').value;
    if (q && (tr.dataset.search || '').indexOf(q) === -1) return false;
    if (cli && (tr.dataset.cliente || '').toLowerCase() !== cli) return false;
    if (rot && tr.dataset.rot !== rot) return false;
    if (LB_F.pais && (tr.dataset.geo || '').split(' ').indexOf(LB_F.pais) === -1) return false;
    if (LB_F.tipo && tr.dataset.tipo !== LB_F.tipo) return false;
    return true;
}
function lbApply() {
    var all = lbRows();
    LB_VIS = all.filter(lbMatch);
    var pages = Math.max(1, Math.ceil(LB_VIS.length / LB_PER));
    if (LB_PAGE > pages) LB_PAGE = pages;
    var ini = (LB_PAGE - 1) * LB_PER, fin = ini + LB_PER;

    all.forEach(function (tr) { tr.style.display = 'none'; });
    LB_VIS.forEach(function (tr, i) { tr.style.display = (i >= ini && i < fin) ? '' : 'none'; });

    var shown = Math.min(LB_PER, Math.max(0, LB_VIS.length - ini));
    document.getElementById('lbInfo').textContent =
        all.length ? ('Mostrando ' + shown + ' de ' + LB_VIS.length + ' etiquetas') : '';
    document.getElementById('lbEmpty').style.display = (all.length && !LB_VIS.length) ? 'block' : 'none';
    lbPager(pages);
    lbChkChange();

    // Si la fila seleccionada ya no está en la lista, selecciona la primera visible
    var sel = document.querySelector('#lbTbody tr.lb-row.sel');
    if (!sel || LB_VIS.indexOf(sel) === -1) { if (LB_VIS[0]) lbSel(LB_VIS[0]); }
}
function lbPager(pages) {
    var box = document.getElementById('lbPager');
    var h = '<button class="lb-pg" ' + (LB_PAGE <= 1 ? 'disabled' : '') + ' onclick="lbGo(' + (LB_PAGE - 1) + ')">‹</button>';
    var from = Math.max(1, LB_PAGE - 2), to = Math.min(pages, from + 4);
    from = Math.max(1, to - 4);
    for (var p = from; p <= to; p++) {
        h += '<button class="lb-pg ' + (p === LB_PAGE ? 'on' : '') + '" onclick="lbGo(' + p + ')">' + p + '</button>';
    }
    h += '<button class="lb-pg" ' + (LB_PAGE >= pages ? 'disabled' : '') + ' onclick="lbGo(' + (LB_PAGE + 1) + ')">›</button>';
    box.innerHTML = h;
}
function lbGo(p) { LB_PAGE = p; lbApply(); }
function lbPer() { LB_PER = parseInt(document.getElementById('lbPerPage').value, 10) || 10; LB_PAGE = 1; lbApply(); }

/* ── Panel de detalle ── */
function lbEsc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[c]; }); }
function lbNum(n) { return Number(n || 0).toLocaleString('es-PE'); }
function lbSel(tr) {
    lbRows().forEach(function (r) { r.classList.toggle('sel', r === tr); });
    var d = tr.dataset;
    document.getElementById('panelEmpty').style.display = 'none';
    document.getElementById('lbDetail').style.display = 'block';

    document.getElementById('lbPrev').innerHTML = d.img
        ? '<img src="' + lbEsc(d.img) + '" alt="">'
        : '<div class="ph"><div class="big">🏷️</div><b>' + lbEsc(d.nombre) + '</b></div>';

    function set(id, v) { document.getElementById(id).textContent = (v === '' || v == null) ? '—' : v; }
    set('dCodigo', d.codigo);
    set('dNombre', d.nombre);
    set('dCliente', d.cliente);
    set('dPais', d.paisl);
    set('dIdioma', d.idioma);
    set('dTipo', d.tipol);
    set('dMedidas', d.medidas);
    set('dStock', lbNum(d.stock) + ' und.');
    set('dMin', lbNum(d.min) + ' und.');
    set('dIng', d.ing);
    set('dSal', d.sal);

    document.getElementById('dEstado').innerHTML = '<span class="lb-tag ' + lbEsc(d.estcls) + '">' + lbEsc(d.estado) + '</span>';
    var rot = { ALTA: ['lb-ok', '▲ Alta'], MEDIA: ['lb-bajo', '● Media'], BAJA: ['lb-t-per', '▼ Baja'] }[d.rot] || ['lb-t-per', '—'];
    document.getElementById('dRot').innerHTML = '<span class="lb-tag ' + rot[0] + '">' + rot[1] + '</span>';

    document.getElementById('dEdit').href = d.edit;
    document.getElementById('dShow').href = d.show;
}
document.getElementById('lbTbody').addEventListener('click', function (e) {
    var tr = e.target.closest('tr.lb-row');
    if (tr) lbSel(tr);
});

/* ── Menú flotante de fila ── */
function lbRowMenu(btn, ev) {
    ev.stopPropagation();
    var tr = btn.closest('tr.lb-row');
    var m = document.getElementById('lbRMenu');
    if (m.classList.contains('open') && LB_MROW === tr) { lbCerrarMenu(); return; }
    LB_MROW = tr;
    document.getElementById('lbRmShow').href = tr.dataset.show;
    document.getElementById('lbRmEdit').href = tr.dataset.edit;
    var r = btn.getBoundingClientRect();
    m.classList.add('open');
    var w = m.offsetWidth, h = m.offsetHeight;
    m.style.left = Math.max(8, Math.min(window.innerWidth - w - 8, r.right - w)) + 'px';
    m.style.top  = (r.bottom + h + 8 > window.innerHeight ? r.top - h - 4 : r.bottom + 4) + 'px';
}
function lbCerrarMenu() { document.getElementById('lbRMenu').classList.remove('open'); }
function lbRowAct(a) {
    lbCerrarMenu();
    if (a === 'panel' && LB_MROW) lbSel(LB_MROW);
}
document.addEventListener('click', lbCerrarMenu);
window.addEventListener('scroll', lbCerrarMenu, true);

/* ── Selección múltiple + exportar ── */
function lbChkChange() {
    var checks = Array.prototype.slice.call(document.querySelectorAll('#lbTbody .lb-chk'));
    var n = checks.filter(function (c) { return c.checked; }).length;
    document.getElementById('lbBulkN').textContent = n;
    document.getElementById('lbBulk').classList.toggle('show', n > 0);
    var vis = checks.filter(function (c) { return c.closest('tr').style.display !== 'none'; });
    document.getElementById('lbAll').checked = vis.length > 0 && vis.every(function (c) { return c.checked; });
}
function lbToggleAll(cb) {
    document.querySelectorAll('#lbTbody tr.lb-row').forEach(function (tr) {
        if (tr.style.display !== 'none') tr.querySelector('.lb-chk').checked = cb.checked;
    });
    lbChkChange();
}
function lbQuitarSel() {
    document.querySelectorAll('#lbTbody .lb-chk').forEach(function (c) { c.checked = false; });
    lbChkChange();
}
function lbExportSel() {
    var head = ['Código', 'Nombre', 'Idioma', 'Cliente', 'País/Zona', 'Tipo', 'Medidas', 'Stock', 'Stock mínimo', 'Estado'];
    var esc = function (v) { return '"' + String(v == null ? '' : v).replace(/"/g, '""') + '"'; };
    var rows = [];
    document.querySelectorAll('#lbTbody tr.lb-row').forEach(function (tr) {
        if (!tr.querySelector('.lb-chk').checked) return;
        var d = tr.dataset;
        rows.push([d.codigo, d.nombre, d.idioma, d.cliente, d.paisl, d.tipol, d.medidas, d.stock, d.min, d.estado]);
    });
    var csv = [head].concat(rows).map(function (r) { return r.map(esc).join(','); }).join('\r\n');
    var blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'etiquetas.csv';
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(function () { URL.revokeObjectURL(a.href); }, 1000);
}

/* ── Ir al historial completo ── */
function lbIrHist() {
    var h = document.getElementById('lbHist');
    if (h) h.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/* ── Init ── */
lbApply();
</script>

@endsection
