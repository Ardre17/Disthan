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
    --font-ui:'Segoe UI',-apple-system,BlinkMacSystemFont,Roboto,Arial,sans-serif;
    --font-mono:'Consolas','SFMono-Regular',Menlo,monospace;
}
*{box-sizing:border-box;}
.page{background:var(--erp-bg);font-family:var(--font-ui);color:var(--erp-ink);padding:0;min-height:100vh;}

/* Top bar */
.erp-bar{background:#1e3a5f;padding:0 1.5rem;height:44px;display:flex;align-items:center;justify-content:space-between;margin-bottom:0;}
.erp-bar-left{display:flex;align-items:center;gap:10px;}
.erp-logo{font-size:15px;font-weight:800;color:#fff;letter-spacing:.5px;}
.erp-sep{width:1px;height:20px;background:#334155;}
.erp-module{font-size:11px;color:#7eb8f7;font-weight:600;text-transform:uppercase;letter-spacing:.06em;}
.erp-user{font-size:11px;color:#7eb8f7;background:#152d4d;padding:3px 10px;border-radius:4px;}

/* Body padding */
.dash-body{padding:1.25rem;}

/* KPI strip */
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:6px;padding:.9rem 1rem;border-left:4px solid;position:relative;overflow:hidden;}
.kpi-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:28px;opacity:.1;}
.kpi-label{font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;margin-bottom:4px;}
.kpi-val{font-size:26px;font-weight:800;line-height:1;font-family:var(--font-mono);margin-bottom:3px;}
.kpi-sub{font-size:10px;color:#94a3b8;}

/* Section grids */
.section-row{display:grid;grid-template-columns:2fr 1fr;gap:12px;margin-bottom:1rem;}
@media(max-width:900px){.section-row{grid-template-columns:1fr;}}
.bottom-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:800px){.bottom-row{grid-template-columns:1fr;}}
.right-col{display:flex;flex-direction:column;gap:12px;}

/* Cards */
.chart-card,.stat-card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:6px;padding:1rem 1.25rem;}
.chart-title{font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.75rem;display:flex;align-items:center;gap:6px;}

/* Tabla recientes */
.recent-table{width:100%;border-collapse:collapse;font-size:12px;}
.recent-table th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.recent-table td{padding:7px 10px;border-bottom:1px solid #f8fafc;color:#374151;vertical-align:middle;}
.recent-table tbody tr:hover td{background:#f8fafc;}
.badge{display:inline-flex;align-items:center;font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}

/* Progreso tipos */
.prog-item{display:flex;flex-direction:column;gap:3px;padding:7px 0;border-bottom:1px solid #f1f5f9;}
.prog-item:last-child{border:none;padding-bottom:0;}
.prog-hdr{display:flex;justify-content:space-between;font-size:12px;color:#374151;}
.prog-bar{width:100%;height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}

/* Alertas */
.alert-strip{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:1rem;}
.alert-item{display:flex;align-items:center;gap:7px;padding:7px 12px;border-radius:6px;font-size:12px;font-weight:600;}
.alert-danger{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;}
.alert-warn{background:#fef3c7;color:#b45309;border:1px solid #fde68a;}

/* Legend */
.legend{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:8px;}
.leg-item{display:flex;align-items:center;gap:4px;font-size:11px;color:#64748b;}
.leg-dot{width:8px;height:8px;border-radius:2px;flex-shrink:0;}

#fano-container{

    position:fixed;

    right:20px;

    bottom:20px;

    z-index:9999;

}

#fano-img{
    width:200px;
    height:auto;
}

#fano-img:hover{

    transform:scale(1.05);

}

#fano-chat{

    position:absolute;

    bottom:260px;

    right:120px;

    width:250px;

    background:#fff;

    border-radius:18px;

    padding:18px;

    box-shadow:0 10px 30px rgba(0,0,0,.18);

    transition:.4s;

    z-index:10000;

}
#fano-chat::after{

    content:"";

    position:absolute;

    right:-14px;

    bottom:30px;

    border-top:12px solid transparent;

    border-bottom:12px solid transparent;

    border-left:16px solid white;

}

.fano-hidden{

    opacity:0;

    visibility:hidden;

}

.fano-show{

    opacity:1;

    visibility:visible;

}
#fano-btn{

    margin-top:15px;

    width:100%;

    border:none;

    background:#2563eb;

    color:white;

    padding:12px;

    border-radius:12px;

    cursor:pointer;

    font-weight:bold;

    transition:.3s;

}

#fano-btn:hover{

    background:#1d4ed8;

}

/* ══════════════════════════════════════════════════════════
   DASHBOARD · rediseño (prefijo db-) — aditivo
   Se conservan .kpis/.kpi/.chart-card/.stat-card/.recent-table del CSS anterior
   (los usa la sección "Resumen general y análisis").
══════════════════════════════════════════════════════════ */
.dbx{
    --db-navy:#1e3a5f; --db-blue:#1d7ff2; --db-blue-soft:#eaf2ff;
    --db-green:#16a34a; --db-orange:#f59e0b; --db-red:#ef4444; --db-purple:#7c3aed;
    --db-text:#0f172a; --db-muted:#64748b; --db-line:#e2e8f0; --db-bg:#f8fafc;
    --db-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
    color:var(--db-text);
}
.dbx *{box-sizing:border-box;}
.db-i{width:16px;height:16px;flex-shrink:0;}
.db-num{font-family:var(--db-mono);font-variant-numeric:tabular-nums;}
.db-card{background:#fff;border:1px solid var(--db-line);border-radius:14px;padding:14px 16px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.db-card-h{display:flex;align-items:center;gap:8px;margin:0 0 12px;}
.db-card-h h3{margin:0;font-size:14.5px;font-weight:800;display:flex;align-items:center;gap:8px;}
.db-ico{width:24px;height:24px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;background:var(--db-blue-soft);color:var(--db-blue);}
.db-ico .db-i{width:14px;height:14px;}
.db-ico.red{background:#fee2e2;color:#dc2626;}.db-ico.green{background:#dcfce7;color:#16a34a;}.db-ico.orange{background:#fef3c7;color:#d97706;}.db-ico.purple{background:#ede9fe;color:#7c3aed;}
.db-more{margin-left:auto;font-size:12px;font-weight:700;color:var(--db-blue);text-decoration:none;background:none;border:none;cursor:pointer;font-family:inherit;}
.db-more:hover{text-decoration:underline;}
.db-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:7px;font-size:11px;font-weight:700;white-space:nowrap;}
.db-ok{background:#dcfce7;color:#15803d;}.db-proc{background:#fef3c7;color:#b45309;}.db-bad{background:#fee2e2;color:#b91c1c;}.db-info{background:#dbeafe;color:#1d4ed8;}.db-pen{background:#eef2f7;color:#475569;}
.db-empty{text-align:center;color:#94a3b8;font-size:12.5px;padding:18px 8px;}

/* Banner de alertas */
.db-alerts{display:flex;align-items:stretch;gap:12px;margin-bottom:14px;}
.db-alert-main{display:flex;align-items:center;gap:13px;background:linear-gradient(90deg,#ffe5e5,#fff1f1);border:1px solid #fecaca;border-radius:14px;padding:12px 18px;flex:0 0 320px;}
.db-alert-ic{width:46px;height:46px;border-radius:50%;background:#fee2e2;color:#dc2626;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.db-alert-ic .db-i{width:22px;height:22px;}
.db-alert-main b{display:block;font-size:15px;color:#b91c1c;font-weight:800;}
.db-alert-main span{font-size:12px;color:#7f1d1d;}
.db-alert-track{display:flex;gap:10px;overflow-x:auto;flex:1;scroll-behavior:smooth;scrollbar-width:none;align-items:stretch;}
.db-alert-track::-webkit-scrollbar{display:none;}
.db-al{display:flex;align-items:center;gap:11px;min-width:250px;max-width:300px;background:#fff;border:1px solid #fecaca;border-radius:12px;padding:10px 13px;text-decoration:none;color:inherit;flex-shrink:0;}
.db-al.warn{border-color:#fde7b0;}.db-al.info{border-color:#cfe0fb;}
.db-al-ic{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;background:#fee2e2;}
.db-al.warn .db-al-ic{background:#fef3c7;}.db-al.info .db-al-ic{background:#dbeafe;}
.db-al b{display:block;font-size:12.5px;font-weight:800;line-height:1.25;}
.db-al small{font-size:11.5px;color:#dc2626;}
.db-al.warn small{color:#b45309;}.db-al.info small{color:#1d4ed8;}
.db-al .ch{margin-left:auto;color:#94a3b8;}
.db-alert-nav{width:34px;border:1px solid var(--db-line);background:#fff;border-radius:10px;cursor:pointer;color:#475569;flex-shrink:0;}
@media(max-width:900px){.db-alerts{flex-direction:column;}.db-alert-main{flex:1;}}

/* KPIs */
.db-kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:14px;}
@media(max-width:1250px){.db-kpis{grid-template-columns:repeat(3,1fr);}}
@media(max-width:700px){.db-kpis{grid-template-columns:1fr 1fr;}}
.db-k{display:flex;align-items:center;gap:13px;border-radius:14px;padding:14px 15px;background:#fff;border:1px solid var(--db-line);text-decoration:none;color:inherit;transition:transform .15s,box-shadow .15s;}
.db-k:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(15,23,42,.08);}
.db-k-ic{width:52px;height:52px;border-radius:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.db-k-ic .db-i{width:26px;height:26px;}
.db-k small.l{display:block;font-size:12.5px;font-weight:700;color:#334155;}
.db-k b{display:block;font-size:28px;font-weight:800;line-height:1.1;font-family:var(--db-mono);}
.db-k small.s{font-size:11px;color:var(--db-muted);}
.db-k .tr{margin-left:auto;align-self:flex-start;font-size:11px;font-weight:700;border-radius:99px;padding:2px 8px;font-family:var(--db-mono);}
.db-k .tr.up{background:#dcfce7;color:#15803d;}.db-k .tr.down{background:#fee2e2;color:#b91c1c;}
.db-k.t-blue{background:#f3f8ff;border-color:#dbe8ff;}.db-k.t-blue .db-k-ic{background:#dbeafe;color:#2563eb;}.db-k.t-blue b{color:#1e3a5f;}
.db-k.t-green{background:#f1fcf5;border-color:#c9f0d5;}.db-k.t-green .db-k-ic{background:#d1fae5;color:#16a34a;}.db-k.t-green b{color:#15803d;}
.db-k.t-orange{background:#fff9ee;border-color:#fde7b0;}.db-k.t-orange .db-k-ic{background:#fde9c4;color:#d97706;}.db-k.t-orange b{color:#b91c1c;}
.db-k.t-purple{background:#f7f3ff;border-color:#e4d9fb;}.db-k.t-purple .db-k-ic{background:#ede9fe;color:#7c3aed;}.db-k.t-purple b{color:#6d28d9;}
.db-k.t-cyan{background:#f0fbff;border-color:#c9ecf7;}.db-k.t-cyan .db-k-ic{background:#d3f1fb;color:#0891b2;}.db-k.t-cyan b{color:#0e7490;}

/* Grid de 3 columnas */
.db-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr) 340px;gap:14px;align-items:start;}
@media(max-width:1350px){.db-grid{grid-template-columns:minmax(0,1fr) minmax(0,1fr);}.db-col3{grid-column:1/-1;display:grid;grid-template-columns:1fr 1fr;gap:14px;}}
@media(max-width:900px){.db-grid{grid-template-columns:1fr;}.db-col3{grid-template-columns:1fr;}}
.db-col{display:flex;flex-direction:column;gap:14px;min-width:0;}
.db-col3{display:flex;flex-direction:column;gap:14px;min-width:0;}

/* Tablas de widgets */
.db-scroll{overflow-x:auto;}
.db-tbl{width:100%;border-collapse:collapse;font-size:12.5px;}
.db-tbl th{font-size:11.5px;color:#475569;font-weight:700;text-align:left;padding:8px 8px;border-bottom:1px solid var(--db-line);white-space:nowrap;}
.db-tbl td{padding:9px 8px;border-bottom:1px solid #eef2f7;vertical-align:middle;}
.db-tbl tr:last-child td{border-bottom:none;}
.db-tbl tr.lnk{cursor:pointer;}
.db-tbl tr.lnk:hover td{background:#fafcff;}
.db-tbl .c{text-align:center;}
.db-ped{font-weight:800;color:var(--db-navy);font-family:var(--db-mono);}
.db-ch{color:#94a3b8;}

/* Stock bajo */
.db-prod{display:flex;align-items:center;gap:10px;}
.db-th{width:38px;height:38px;border-radius:9px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:18px;overflow:hidden;flex-shrink:0;}
.db-th img{width:100%;height:100%;object-fit:cover;}
.db-prod b{display:block;font-size:12.5px;font-weight:700;}
.db-prod small{font-size:11px;color:var(--db-muted);font-family:var(--db-mono);}
.db-stk{display:inline-block;min-width:34px;text-align:center;padding:3px 9px;border-radius:7px;font-weight:800;font-family:var(--db-mono);}

/* Progreso de órdenes */
.db-pr{display:grid;grid-template-columns:78px minmax(0,1fr) 110px 40px;gap:10px;align-items:center;padding:7px 0;font-size:12.5px;}
.db-pr .n{font-weight:800;font-family:var(--db-mono);color:var(--db-navy);}
.db-pr .c{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#334155;}
.db-bar{height:9px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.db-bar > div{height:100%;border-radius:99px;}
.db-pr b{font-family:var(--db-mono);font-size:12px;text-align:right;}
@media(max-width:560px){.db-pr{grid-template-columns:70px 1fr 40px;}.db-pr .c{display:none;}}

/* Movimientos */
.db-mv-t{font-size:11px;font-weight:800;padding:3px 10px;border-radius:7px;display:inline-block;}
.db-mv-t.in{background:#dcfce7;color:#15803d;}.db-mv-t.out{background:#fee2e2;color:#b91c1c;}

/* Agenda */
.db-ag-h{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:10px;}
.db-ag-h h3{margin:0;font-size:14.5px;font-weight:800;display:flex;align-items:center;gap:8px;}
.db-ag-h .sp{margin-left:auto;display:flex;gap:8px;align-items:center;}
.db-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:9px;font-size:12.5px;font-weight:700;cursor:pointer;text-decoration:none;border:1px solid transparent;font-family:inherit;}
.db-btn.blue{background:var(--db-blue);color:#fff;}
.db-btn.blue:hover{filter:brightness(.93);}
.db-btn.white{background:#fff;color:var(--db-blue);border-color:#cfe0fb;}
.db-wk-nav{display:flex;align-items:center;gap:8px;margin-bottom:10px;font-size:12.5px;font-weight:700;}
.db-wk-nav button{width:28px;height:28px;border:1px solid var(--db-line);background:#fff;border-radius:8px;cursor:pointer;color:#475569;}
.db-days{display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin-bottom:12px;}
.db-day{border:1px solid var(--db-line);background:#fff;border-radius:10px;padding:7px 2px;text-align:center;cursor:pointer;font-family:inherit;}
.db-day small{display:block;font-size:10.5px;color:var(--db-muted);}
.db-day b{display:block;font-size:15px;font-weight:800;}
.db-day.today{border-color:#93c5fd;}
.db-day.sel{background:var(--db-blue);border-color:var(--db-blue);color:#fff;}
.db-day.sel small{color:#dbeafe;}
.db-day .dot{display:block;width:5px;height:5px;border-radius:50%;background:#2563eb;margin:3px auto 0;}
.db-day.sel .dot{background:#fff;}
.db-ev{display:grid;grid-template-columns:62px 14px minmax(0,1fr) auto 24px;gap:8px;align-items:center;padding:8px 0;font-size:12.5px;}
.db-ev time{color:#475569;font-family:var(--db-mono);font-size:11.5px;}
.db-ev .pt{width:10px;height:10px;border-radius:50%;}
.db-ev b{display:block;font-weight:700;}
.db-ev small{color:var(--db-muted);font-size:11px;}
.db-tag{font-size:10.5px;font-weight:800;padding:3px 9px;border-radius:6px;}
.tg-entrega{background:#fee2e2;color:#b91c1c;}.tg-tarea{background:#dbeafe;color:#1d4ed8;}.tg-envio{background:#fef3c7;color:#b45309;}.tg-reunion{background:#e0e7ff;color:#4338ca;}.tg-produccion{background:#ede9fe;color:#6d28d9;}
.db-dots{border:none;background:none;cursor:pointer;color:#94a3b8;font-size:16px;line-height:1;padding:2px;}

/* Tareas */
.db-task{display:flex;align-items:center;gap:10px;padding:9px 2px;border-bottom:1px solid #eef2f7;font-size:13px;}
.db-task:last-child{border-bottom:none;}
.db-task input{width:16px;height:16px;accent-color:var(--db-blue);cursor:pointer;}
.db-task span.t{flex:1;min-width:0;}
.db-task.done span.t{text-decoration:line-through;color:#94a3b8;}
.db-task em{font-style:normal;font-size:10px;color:#94a3b8;margin-left:6px;}
.db-when{font-size:10.5px;font-weight:800;padding:3px 9px;border-radius:6px;background:#fee2e2;color:#b91c1c;}
.db-when.m{background:#fef3c7;color:#b45309;}.db-when.f{background:#eef2f7;color:#475569;}

/* Asistente IA */
.db-ai-h{display:flex;align-items:center;gap:9px;margin-bottom:10px;}
.db-ai-h h3{margin:0;font-size:14.5px;font-weight:800;display:flex;align-items:center;gap:8px;}
.db-ai-min{margin-left:auto;width:26px;height:26px;border:1px solid var(--db-line);background:#fff;border-radius:7px;cursor:pointer;color:#475569;font-size:15px;line-height:1;}
.db-ai-body.min{display:none;}
.db-ai-top{display:flex;gap:10px;align-items:flex-end;margin-bottom:10px;}
.db-ai-bot{width:92px;height:92px;object-fit:contain;flex-shrink:0;cursor:pointer;}
.db-ai-bubble{background:#eaf2ff;border-radius:14px 14px 14px 4px;padding:10px 12px;font-size:12.5px;line-height:1.45;color:#1e293b;}
.db-ai-bubble b{display:block;margin-bottom:2px;}
.db-chat{max-height:230px;overflow-y:auto;display:flex;flex-direction:column;gap:8px;margin-bottom:10px;padding-right:2px;}
.db-msg{max-width:92%;padding:8px 11px;border-radius:12px;font-size:12.5px;line-height:1.45;word-wrap:break-word;}
.db-msg.me{align-self:flex-end;background:var(--db-blue);color:#fff;border-bottom-right-radius:4px;}
.db-msg.bot{align-self:flex-start;background:#f1f5f9;color:#1e293b;border-bottom-left-radius:4px;}
.db-msg a{color:#1d4ed8;font-weight:700;}
.db-msg.me a{color:#fff;}
.db-msg ul{margin:4px 0 0;padding-left:16px;}
.db-msg .row{display:flex;justify-content:space-between;gap:10px;}
.db-sug{display:flex;flex-direction:column;gap:7px;margin-bottom:10px;}
.db-sug button{display:flex;align-items:center;gap:10px;border:1px solid var(--db-line);background:#fff;border-radius:10px;padding:9px 12px;font-size:12.5px;color:#1e293b;cursor:pointer;text-align:left;font-family:inherit;}
.db-sug button:hover{background:#f3f8ff;border-color:#bcd6fb;}
.db-sug button .e{font-size:16px;}
.db-ai-in{display:flex;gap:8px;align-items:center;border:1px solid var(--db-line);border-radius:12px;padding:6px 6px 6px 12px;background:#fff;}
.db-ai-in:focus-within{border-color:var(--db-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);}
.db-ai-in input{flex:1;border:none;outline:none;font-size:13px;font-family:inherit;background:transparent;min-width:0;}
.db-ai-in button{width:36px;height:36px;border:none;border-radius:9px;background:var(--db-blue);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;}
.db-typing{display:inline-flex;gap:4px;}
.db-typing i{width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:dbTy 1s infinite;}
.db-typing i:nth-child(2){animation-delay:.15s;}.db-typing i:nth-child(3){animation-delay:.3s;}
@keyframes dbTy{0%,60%,100%{opacity:.3;transform:translateY(0);}30%{opacity:1;transform:translateY(-3px);}}

/* Enlaces rápidos */
.db-links{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;}
.db-lk{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:7px;text-align:center;border:1px solid var(--db-line);background:#fff;border-radius:12px;padding:12px 6px;text-decoration:none;color:#1e293b;font-size:12px;font-weight:700;min-height:84px;transition:transform .15s,box-shadow .15s;}
.db-lk:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(15,23,42,.08);}
.db-lk .ic{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;}
.db-lk .ic .db-i{width:20px;height:20px;}
.ic-blue{background:#dbeafe;color:#2563eb;}.ic-navy{background:#e0e7ff;color:#1e3a5f;}.ic-purple{background:#ede9fe;color:#7c3aed;}.ic-violet{background:#f3e8ff;color:#9333ea;}.ic-cyan{background:#d3f1fb;color:#0891b2;}.ic-orange{background:#fde9c4;color:#d97706;}

/* Modal nueva tarea */
.db-modal{display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:1100;align-items:center;justify-content:center;padding:16px;}
.db-modal.open{display:flex;}
.db-modal-box{background:#fff;border-radius:14px;width:min(440px,100%);padding:18px;}
.db-modal-box h4{margin:0 0 12px;font-size:16px;font-weight:800;}
.db-modal-box label{display:block;font-size:11px;font-weight:700;color:var(--db-muted);text-transform:uppercase;letter-spacing:.04em;margin:10px 0 4px;}
.db-modal-box input,.db-modal-box select{width:100%;padding:9px 10px;border:1px solid var(--db-line);border-radius:9px;font-size:13px;font-family:inherit;outline:none;}
.db-modal-box input:focus,.db-modal-box select:focus{border-color:var(--db-blue);}
.db-modal-box .two{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.db-modal-box .acts{display:flex;justify-content:flex-end;gap:8px;margin-top:16px;}

/* Sección de análisis (contenido original) */
.db-sec-t{display:flex;align-items:center;gap:8px;font-size:15px;font-weight:800;color:var(--db-navy);margin:22px 0 12px;}
</style>

<div class="page">
<div class="dash-body dbx">

{{-- ── PHP vars ── --}}
@php
    $totalOrdenes   = \App\Models\Order::count();
    $incompletas    = \App\Models\Order::where('estado','INCOMPLETO')->count();
    $parciales      = \App\Models\Order::where('estado','PARCIAL')->count();
    $completas      = \App\Models\Order::where('estado','COMPLETO')->count();
    $pctCompletas   = $totalOrdenes > 0 ? number_format($completas / $totalOrdenes * 100, 1) : 0;

    $ordenesEsteMes = \App\Models\Order::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)->count();
    $facturadoMes   = \App\Models\Order::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)->sum('total');

    $clientesActivos = \App\Models\Order::whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->distinct('client_id')->count('client_id');

    $sinStock = \App\Models\Product::whereColumn('stock','<=','stock_minimo')->count();

    $ordenesRecientes = \App\Models\Order::with('client')
                        ->orderByDesc('created_at')->take(6)->get();

    // Tipos de orden
    $tiposConteo = \App\Models\Order::selectRaw('tipo_orden, count(*) as total')
                    ->groupBy('tipo_orden')->pluck('total','tipo_orden');
    $maxTipo = $tiposConteo->max() ?: 1;

    // Datos gráfico clientes
    $topProductos = \App\Models\OrderDetail::selectRaw('product_id, SUM(cantidad_despachada) as total_vendido')
    ->with('product')
    ->groupBy('product_id')
    ->orderByDesc('total_vendido')
    ->take(10)
    ->get();

    // Facturación mensual últimos 6 meses
    $mesesLabels = [];
    $mesesData   = [];
    for($i = 5; $i >= 0; $i--){
        $m = now()->subMonths($i);
        $mesesLabels[] = $m->format('M');
        $mesesData[]   = \App\Models\Order::whereMonth('created_at',$m->month)
                            ->whereYear('created_at',$m->year)->sum('total');
    }
@endphp

{{-- ── Datos adicionales para el rediseño (solo lectura; consultas protegidas) ── --}}
@php
    $dbSafe = function (callable $fn, $default = null) {
        try { return $fn(); } catch (\Throwable $e) { return $default; }
    };
    $dbUser   = auth()->user();
    $dbNombre = $dbUser->name ?? 'Usuario';
    $dbPrimer = explode(' ', trim($dbNombre))[0] ?: 'Usuario';
    $dbUid    = $dbUser->id ?? 0;
    $dbFmt    = fn($n) => rtrim(rtrim(number_format((float) $n, 2, '.', ''), '0'), '.') ?: '0';

    // ── KPIs ──
    $dbActivas    = $parciales + $incompletas;
    $dbStockTotal = (float) $dbSafe(fn() => \App\Models\Product::sum('stock'), 0);
    $dbN7  = (int) $dbSafe(fn() => \App\Models\Order::where('created_at', '>=', now()->subDays(7))->count(), 0);
    $dbN14 = (int) $dbSafe(fn() => \App\Models\Order::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count(), 0);
    $dbTrend = $dbN14 > 0 ? (int) round((($dbN7 - $dbN14) / $dbN14) * 100) : null;

    // Producción de hoy (usa el modelo de producción si existe; si no, muestra "—")
    $dbProdHoy = null;
    $dbProdModel = null;
    foreach (['\App\Models\ProductionOrder', '\App\Models\Production', '\App\Models\OrdenProduccion'] as $c) {
        if (class_exists($c)) { $dbProdModel = $c; break; }
    }
    if ($dbProdModel) {
        foreach (['cantidad', 'cantidad_producida', 'cantidad_total', 'total'] as $col) {
            $v = $dbSafe(fn() => $dbProdModel::whereDate('created_at', today())->sum($col), null);
            if ($v !== null) { $dbProdHoy = (float) $v; break; }
        }
    }

    // Envíos pendientes = órdenes completas que todavía no tienen guía asociada
    $dbEnviosQ = fn() => \App\Models\Order::where('estado', 'COMPLETO')
        ->where(function ($q) { $q->whereNull('guia_asociada')->orWhere('guia_asociada', ''); });
    $dbEnviosN = $dbSafe(fn() => $dbEnviosQ()->count(), null);
    $dbEnvios  = $dbSafe(fn() => $dbEnviosQ()->with('client')->orderByDesc('created_at')->take(5)->get(), collect());

    // ── Listas ──
    $dbStockBajo = $dbSafe(fn() => \App\Models\Product::whereColumn('stock', '<=', 'stock_minimo')->orderBy('stock')->take(5)->get(), collect());
    $dbRecientes = $dbSafe(fn() => \App\Models\Order::with('client')->withCount('details')->orderByDesc('created_at')->take(5)->get(), collect());
    $dbProgreso  = $dbSafe(fn() => \App\Models\Order::with(['client', 'details'])->where('estado', '!=', 'COMPLETO')->orderByDesc('created_at')->take(5)->get(), collect());
    $dbPend      = $dbSafe(fn() => \App\Models\Order::with('client')->whereIn('estado', ['INCOMPLETO', 'PARCIAL'])->orderByDesc('created_at')->take(8)->get(), collect());

    // Etiquetas con stock bajo
    $dbLabelClass = class_exists('\App\Models\Label') ? '\App\Models\Label' : null;
    $dbEtqBajas = $dbLabelClass ? (int) $dbSafe(fn() => $dbLabelClass::whereColumn('stock_actual', '<=', 'stock_minimo')->count(), 0) : 0;

    // Movimientos recientes (detecta el modelo; fíjalo aquí si usas otro: $dbMovModel = \App\Models\TuModelo::class;)
    $dbMovModel = null;
    foreach (['\App\Models\StockMovement', '\App\Models\ProductMovement', '\App\Models\Movimiento', '\App\Models\Kardex', '\App\Models\InventoryMovement', '\App\Models\MovimientoStock'] as $c) {
        if (class_exists($c)) { $dbMovModel = $c; break; }
    }
    $dbMovs = collect();
    if ($dbMovModel) {
        $dbMovs = $dbSafe(fn() => $dbMovModel::with('product')->orderByDesc('created_at')->take(5)->get(), null)
               ?? $dbSafe(fn() => $dbMovModel::orderByDesc('created_at')->take(5)->get(), collect());
    }
    $dbMovProd = fn($m) => $m->product->nombre ?? ($m->producto->nombre ?? (is_string($m->producto ?? null) ? $m->producto : '—'));
    $dbMovUser = function ($m) {
        $u = $m->user ?? ($m->usuario ?? null);
        if (is_object($u)) { return $u->name ?? ($u->nombre ?? '—'); }
        return is_string($u) && $u !== '' ? $u : '—';
    };

    // ── Alertas (conserva los dos avisos originales y suma más) ──
    $dbAl = [];
    if ($incompletas > 0) { $dbAl[] = ['t' => 'danger', 'i' => '⚠️', 'b' => $incompletas . ' orden(es) incompleta(s) requieren atención', 's' => 'Revisar órdenes', 'h' => url('/orders') . '?estado=INCOMPLETO']; }
    if ($sinStock > 0)    { $dbAl[] = ['t' => 'warn',   'i' => '📦', 'b' => $sinStock . ' producto(s) con stock bajo o agotado', 's' => 'Ver productos', 'h' => route('products.index')]; }
    foreach ($dbStockBajo->take(2) as $p) {
        $dbAl[] = ['t' => 'danger', 'i' => '🧃', 'b' => $p->nombre, 's' => 'Stock bajo: ' . $dbFmt($p->stock) . ' unid.', 'h' => route('products.index')];
    }
    if ($dbEtqBajas > 0)  { $dbAl[] = ['t' => 'warn', 'i' => '🏷️', 'b' => 'Etiquetas', 's' => 'Stock bajo: ' . $dbEtqBajas . ' tipo(s)', 'h' => route('labels.index')]; }
    if ($dbEnviosN)       { $dbAl[] = ['t' => 'info', 'i' => '🚚', 'b' => 'Entrega pendiente', 's' => ($dbEnvios->first()->client->razon_social ?? 'Orden lista') . ' · ' . $dbEnviosN . ' sin guía', 'h' => url('/orders')]; }

    // ── Tareas sugeridas por el sistema (no se guardan; solo su estado "hecha") ──
    $dbSys = [];
    foreach ($dbPend->where('estado', 'INCOMPLETO')->take(2) as $o) {
        $dbSys[] = ['id' => 'sys:inc:' . $o->id, 'title' => 'Completar ' . $o->numero_orden . ' (' . ($o->client->razon_social ?? 'cliente') . ')', 'tag' => 'tarea'];
    }
    foreach ($dbEnvios->take(2) as $o) {
        $dbSys[] = ['id' => 'sys:guia:' . $o->id, 'title' => 'Generar guía de ' . $o->numero_orden, 'tag' => 'envio'];
    }
    if ($dbEtqBajas > 0) { $dbSys[] = ['id' => 'sys:etq', 'title' => 'Revisar stock de etiquetas', 'tag' => 'tarea']; }
    foreach ($dbStockBajo->take(2) as $p) {
        $dbSys[] = ['id' => 'sys:stk:' . $p->id, 'title' => 'Reponer stock de ' . $p->nombre, 'tag' => 'tarea'];
    }

    // ── Datos para el asistente y la agenda (JS) ──
    $dbJs = [
        'user'      => $dbPrimer,
        'uid'       => $dbUid,
        'sinStock'  => (int) $sinStock,
        'etqBajas'  => $dbEtqBajas,
        'stockBajo' => $dbStockBajo->map(fn($p) => ['n' => $p->nombre, 'sku' => $p->sku ?? '', 'st' => (float) $p->stock, 'mn' => (float) $p->stock_minimo])->values()->all(),
        'pendientes'=> $dbPend->map(fn($o) => ['n' => $o->numero_orden, 'c' => $o->client->razon_social ?? '—', 'e' => $o->estado, 'u' => route('orders.edit', $o)])->values()->all(),
        'envios'    => $dbEnvios->map(fn($o) => ['n' => $o->numero_orden, 'c' => $o->client->razon_social ?? '—', 'u' => route('orders.edit', $o)])->values()->all(),
        'enviosN'   => (int) ($dbEnviosN ?? 0),
        'sys'       => $dbSys,
        'urls'      => [
            'productos' => route('products.index'),
            'etiquetas' => route('labels.index'),
            'ordenes'   => url('/orders'),
            'kardex'    => route('kardex.index'),
            'validar'   => route('orders.validation.index'),
        ],
        'csrf'      => csrf_token(),
    ];
    $dbEstado = fn($e) => match ($e) {
        'COMPLETO' => ['Completado', 'db-ok'],
        'PARCIAL'  => ['En preparación', 'db-proc'],
        default    => ['Incompleto', 'db-bad'],
    };
    $dbImg = function ($p) {
        $i = $p->imagen ?? $p->image ?? $p->foto ?? null;
        if ($i && is_string($i) && !preg_match('#^(https?:)?//#', $i)) { $i = asset('storage/' . ltrim($i, '/')); }
        return is_string($i) ? $i : null;
    };
@endphp

{{-- Iconos --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="db-bell" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></symbol>
    <symbol id="db-doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
    <symbol id="db-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
    <symbol id="db-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
    <symbol id="db-factory" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20V8l6 4V8l6 4V4h4v16z"/><line x1="2" y1="20" x2="22" y2="20"/></symbol>
    <symbol id="db-truck" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></symbol>
    <symbol id="db-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 1.98-1.7L23 6H6"/></symbol>
    <symbol id="db-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
    <symbol id="db-chart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></symbol>
    <symbol id="db-swap" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></symbol>
    <symbol id="db-barcode" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="5" x2="3" y2="19"/><line x1="6" y1="5" x2="6" y2="19"/><line x1="10" y1="5" x2="10" y2="19"/><line x1="13" y1="5" x2="13" y2="19"/><line x1="17" y1="5" x2="17" y2="19"/><line x1="21" y1="5" x2="21" y2="19"/></symbol>
    <symbol id="db-printer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></symbol>
    <symbol id="db-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="db-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
    <symbol id="db-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></symbol>
    <symbol id="db-chevl" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></symbol>
    <symbol id="db-cal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
    <symbol id="db-list" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></symbol>
    <symbol id="db-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
    <symbol id="db-bot" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="12" rx="3"/><line x1="12" y1="8" x2="12" y2="4"/><circle cx="12" cy="3" r="1"/><circle cx="9" cy="14" r="1"/><circle cx="15" cy="14" r="1"/></symbol>
</defs></svg>

{{-- ══════════ ALERTAS ══════════ --}}
@if(count($dbAl) > 0)
<div class="db-alerts">
    <div class="db-alert-main">
        <div class="db-alert-ic"><svg class="db-i"><use href="#db-bell"/></svg></div>
        <div>
            <b>Tienes {{ count($dbAl) }} {{ count($dbAl) === 1 ? 'alerta importante' : 'alertas importantes' }}</b>
            <span>Revisa los stocks bajos, órdenes y tareas pendientes.</span>
        </div>
    </div>
    <div class="db-alert-track" id="dbAlTrack">
        @foreach($dbAl as $al)
            <a href="{{ $al['h'] }}" class="db-al {{ $al['t'] }}">
                <div class="db-al-ic">{{ $al['i'] }}</div>
                <div style="min-width:0;"><b>{{ $al['b'] }}</b><small>{{ $al['s'] }}</small></div>
                <svg class="db-i ch"><use href="#db-chev"/></svg>
            </a>
        @endforeach
    </div>
    <button type="button" class="db-alert-nav" onclick="document.getElementById('dbAlTrack').scrollBy({left:280,behavior:'smooth'})" title="Siguiente"><svg class="db-i"><use href="#db-chev"/></svg></button>
</div>
@endif

{{-- ══════════ KPIs ══════════ --}}
<div class="db-kpis">
    <a href="{{ url('/orders') }}" class="db-k t-blue">
        <div class="db-k-ic"><svg class="db-i"><use href="#db-doc"/></svg></div>
        <div><small class="l">Órdenes activas</small><b>{{ $dbActivas }}</b><small class="s">{{ $dbN7 }} nuevas esta semana</small></div>
        @if($dbTrend !== null)<span class="tr {{ $dbTrend >= 0 ? 'up' : 'down' }}">{{ $dbTrend >= 0 ? '▲ +' : '▼ ' }}{{ $dbTrend }}%</span>@endif
    </a>
    <a href="{{ route('products.index') }}" class="db-k t-green">
        <div class="db-k-ic"><svg class="db-i"><use href="#db-box"/></svg></div>
        <div><small class="l">Productos en stock</small><b>{{ number_format($dbStockTotal, 0) }}</b><small class="s">Unidades en inventario</small></div>
    </a>
    <a href="{{ route('products.index') }}" class="db-k t-orange">
        <div class="db-k-ic"><svg class="db-i"><use href="#db-alert"/></svg></div>
        <div><small class="l">Stock bajo</small><b>{{ $sinStock }}</b><small class="s">Productos</small></div>
    </a>
    <a href="{{ route('production-orders.index') }}" class="db-k t-purple">
        <div class="db-k-ic"><svg class="db-i"><use href="#db-factory"/></svg></div>
        <div><small class="l">Producción hoy</small><b>{{ $dbProdHoy !== null ? number_format($dbProdHoy, 0) : '—' }}</b><small class="s">{{ $dbProdHoy !== null ? 'Unidades' : 'Sin datos de producción' }}</small></div>
    </a>
    <a href="{{ url('/orders') }}" class="db-k t-cyan">
        <div class="db-k-ic"><svg class="db-i"><use href="#db-truck"/></svg></div>
        <div><small class="l">Envíos pendientes</small><b>{{ $dbEnviosN ?? '—' }}</b><small class="s">Completas sin guía</small></div>
    </a>
</div>

{{-- ══════════ GRID PRINCIPAL ══════════ --}}
<div class="db-grid">

{{-- ───────── Columna 1 ───────── --}}
<div class="db-col">

    <div class="db-card">
        <div class="db-card-h"><h3><span class="db-ico"><svg class="db-i"><use href="#db-doc"/></svg></span> Órdenes recientes</h3><a class="db-more" href="{{ url('/orders') }}">Ver todas ›</a></div>
        <div class="db-scroll">
        <table class="db-tbl">
            <thead><tr><th># Orden</th><th>Cliente</th><th>Fecha</th><th class="c">Productos</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($dbRecientes as $o)
                @php [$eTxt, $eCls] = $dbEstado($o->estado); @endphp
                <tr class="lnk" onclick="location.href='{{ route('orders.edit', $o) }}'">
                    <td class="db-ped">{{ $o->numero_orden }}</td>
                    <td>{{ $o->client->razon_social ?? '—' }}</td>
                    <td class="db-num">{{ $o->fecha_pedido ? \Carbon\Carbon::parse($o->fecha_pedido)->format('d/m/Y') : '—' }}</td>
                    <td class="c db-num">{{ $o->details_count ?? '—' }}</td>
                    <td><span class="db-chip {{ $eCls }}" title="{{ $o->estado }}">{{ $eTxt }}</span></td>
                    <td class="db-ch">›</td>
                </tr>
            @empty
                <tr><td colspan="6" class="db-empty">Aún no hay órdenes.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-h"><h3><span class="db-ico"><svg class="db-i"><use href="#db-chart"/></svg></span> Progreso de órdenes</h3><a class="db-more" href="{{ url('/orders') }}">Ver todas</a></div>
        @forelse($dbProgreso as $o)
            @php
                $dSol = (float) $o->details->sum('cantidad_solicitada');
                $dDes = (float) $o->details->sum('cantidad_despachada');
                $dPct = $dSol > 0 ? min(100, (int) round($dDes / $dSol * 100)) : 0;
                $dCol = $dPct >= 100 ? '#16a34a' : ($dPct >= 60 ? '#1d7ff2' : ($dPct >= 30 ? '#f5c542' : '#ef4444'));
            @endphp
            <div class="db-pr">
                <span class="n">{{ $o->numero_orden }}</span>
                <span class="c">{{ $o->client->razon_social ?? '—' }}</span>
                <div class="db-bar"><div style="width:{{ $dPct }}%;background:{{ $dCol }};"></div></div>
                <b style="color:{{ $dCol }};">{{ $dPct }}%</b>
            </div>
        @empty
            <div class="db-empty">No hay órdenes en proceso.</div>
        @endforelse
    </div>

    <div class="db-card">
        <div class="db-card-h"><h3><span class="db-ico orange"><svg class="db-i"><use href="#db-swap"/></svg></span> Movimientos recientes</h3><a class="db-more" href="{{ route('kardex.index') }}">Ver todas</a></div>
        <div class="db-scroll">
        <table class="db-tbl">
            <thead><tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th class="c">Cantidad</th><th>Usuario</th></tr></thead>
            <tbody>
            @forelse($dbMovs as $m)
                @php
                    $mIn = in_array(strtoupper((string) ($m->tipo ?? '')), ['ENTRADA', 'INGRESO', 'IN'], true);
                    $mQ  = (float) ($m->cantidad ?? 0);
                @endphp
                <tr>
                    <td class="db-num" style="white-space:nowrap;">{{ $m->created_at ? $m->created_at->format('d/m H:i') : '—' }}</td>
                    <td style="font-weight:600;">{{ $dbMovProd($m) }}</td>
                    <td><span class="db-mv-t {{ $mIn ? 'in' : 'out' }}">{{ $mIn ? 'Entrada' : 'Salida' }}</span></td>
                    <td class="c db-num" style="font-weight:800;color:{{ $mIn ? '#16a34a' : '#dc2626' }};">{{ $mIn ? '+' : '−' }}{{ $dbFmt(abs($mQ)) }}</td>
                    <td>{{ $dbMovUser($m) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="db-empty">
                    Sin movimientos para mostrar.<br>
                    <small>Define <code>$dbMovModel</code> al inicio del bloque de datos con tu modelo de movimientos.</small>
                </td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

{{-- ───────── Columna 2 ───────── --}}
<div class="db-col">

    <div class="db-card">
        <div class="db-card-h"><h3><span class="db-ico red"><svg class="db-i"><use href="#db-alert"/></svg></span> Stock bajo</h3><a class="db-more" href="{{ route('products.index') }}">Ver todos</a></div>
        <div class="db-scroll">
        <table class="db-tbl">
            <thead><tr><th>Producto</th><th class="c">Stock</th><th class="c">Mínimo</th></tr></thead>
            <tbody>
            @forelse($dbStockBajo as $p)
                @php
                    $sRed = (float) $p->stock <= ((float) $p->stock_minimo * 0.5);
                    $sTh  = $dbImg($p);
                @endphp
                <tr>
                    <td><div class="db-prod">
                        <div class="db-th">@if($sTh)<img src="{{ $sTh }}" alt="" loading="lazy" onerror="this.replaceWith(document.createTextNode('📦'))">@else 📦 @endif</div>
                        <div><b>{{ $p->nombre }}</b><small>{{ $p->sku ?? '' }}</small></div>
                    </div></td>
                    <td class="c"><span class="db-stk" style="background:{{ $sRed ? '#fee2e2' : '#fef3c7' }};color:{{ $sRed ? '#b91c1c' : '#b45309' }};">{{ $dbFmt($p->stock) }}</span></td>
                    <td class="c db-num">{{ $dbFmt($p->stock_minimo) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="db-empty">✅ Todo el stock está por encima del mínimo.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>

    {{-- Agenda semanal (se guarda en este navegador) --}}
    <div class="db-card">
        <div class="db-ag-h">
            <h3><span class="db-ico"><svg class="db-i"><use href="#db-cal"/></svg></span> Mi agenda semanal</h3>
            <div class="sp">
                <button type="button" class="db-btn white" onclick="dbAgHoy()">Hoy</button>
                <button type="button" class="db-btn blue" onclick="dbNuevaTarea()"><svg class="db-i"><use href="#db-plus"/></svg> Nueva tarea</button>
            </div>
        </div>
        <div class="db-wk-nav">
            <button type="button" onclick="dbAgSemana(-1)" title="Semana anterior"><svg class="db-i"><use href="#db-chevl"/></svg></button>
            <span id="dbAgTitulo">—</span>
            <button type="button" onclick="dbAgSemana(1)" title="Semana siguiente"><svg class="db-i"><use href="#db-chev"/></svg></button>
        </div>
        <div class="db-days" id="dbDays"></div>
        <div id="dbAgenda"></div>
    </div>

    <div class="db-card">
        <div class="db-card-h"><h3><span class="db-ico orange"><svg class="db-i"><use href="#db-list"/></svg></span> Tareas pendientes <span id="dbTaskN" class="db-num" style="color:#64748b;">(0)</span></h3><button type="button" class="db-more" onclick="dbNuevaTarea()">+ Agregar</button></div>
        <div id="dbTasks"></div>
    </div>
</div>

{{-- ───────── Columna 3 ───────── --}}
<div class="db-col3">

    {{-- Asistente DISTAN IA --}}
    <div class="db-card" id="dbAi">
        <div class="db-ai-h">
            <h3><span class="db-ico purple"><svg class="db-i"><use href="#db-bot"/></svg></span> Asistente DISTAN IA</h3>
            <button type="button" class="db-ai-min" onclick="document.getElementById('dbAiBody').classList.toggle('min')" title="Minimizar">–</button>
        </div>
        <div class="db-ai-body" id="dbAiBody">
            <div class="db-ai-top">
                <img class="db-ai-bot" id="dbAiImg" src="/assets/fano/expresiones/invierno/Saludando.png" alt="Asistente"
                     onerror="this.replaceWith(Object.assign(document.createElement('div'),{textContent:'🤖',style:'font-size:56px;width:92px;text-align:center;'}))">
                <div class="db-ai-bubble"><b>Hola {{ $dbPrimer }} 👋</b>¿Cómo puedo ayudarte hoy? Puedo revisar tus órdenes, stock, reportes o recordatorios.</div>
            </div>
            <div class="db-chat" id="dbChat"></div>
            <div class="db-sug" id="dbSug">
                <button type="button" onclick="dbPreguntar('¿Qué productos tienen stock bajo?')"><span class="e">📦</span> ¿Qué productos tienen stock bajo?</button>
                <button type="button" onclick="dbPreguntar('Muéstrame las órdenes pendientes')"><span class="e">📋</span> Muéstrame las órdenes pendientes</button>
                <button type="button" onclick="dbPreguntar('Genera un reporte de inventario')"><span class="e">📄</span> Genera un reporte de inventario</button>
                <button type="button" onclick="dbPreguntar('¿Qué entregas tengo hoy?')"><span class="e">🚚</span> ¿Qué entregas tengo hoy?</button>
                <button type="button" onclick="dbPreguntar('Ayúdame a registrar una nota')"><span class="e">📝</span> Ayúdame a registrar una nota</button>
            </div>
            <form class="db-ai-in" onsubmit="dbEnviar(event)">
                <input type="text" id="dbAiInput" placeholder="Escribe tu consulta aquí..." autocomplete="off">
                <button type="submit" title="Enviar"><svg class="db-i"><use href="#db-send"/></svg></button>
            </form>
        </div>
    </div>

    {{-- Enlaces rápidos --}}
    <div class="db-card">
        <div class="db-card-h"><h3><span class="db-ico"><svg class="db-i"><use href="#db-plus"/></svg></span> Enlaces rápidos</h3></div>
        <div class="db-links">
            <a href="{{ route('orders.create') }}" class="db-lk"><span class="ic ic-blue"><svg class="db-i"><use href="#db-doc"/></svg></span>Nuevo pedido</a>
            <a href="{{ route('orders.validation.index') }}" class="db-lk"><span class="ic ic-navy"><svg class="db-i"><use href="#db-barcode"/></svg></span>Validar pedido</a>
            <a href="{{ route('kardex.index') }}" class="db-lk"><span class="ic ic-violet"><svg class="db-i"><use href="#db-swap"/></svg></span>Registrar movimiento</a>
            <a href="{{ route('labels.index') }}" class="db-lk"><span class="ic ic-purple"><svg class="db-i"><use href="#db-printer"/></svg></span>Imprimir etiquetas</a>
            <a href="{{ url('/orders') }}" class="db-lk" title="Abre la orden y genera su guía"><span class="ic ic-cyan"><svg class="db-i"><use href="#db-truck"/></svg></span>Generar guía</a>
            <a href="{{ route('products.index') }}" class="db-lk"><span class="ic ic-orange"><svg class="db-i"><use href="#db-box"/></svg></span>Ver inventario</a>
        </div>
    </div>
</div>

</div>{{-- /.db-grid --}}

{{-- ══════════ RESUMEN GENERAL Y ANÁLISIS (indicadores y gráficos originales, sin cambios) ══════════ --}}
<div class="db-sec-t">📊 Resumen general y análisis</div>

{{-- ── KPIs fila 1 ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#0b5ed7;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Total órdenes</div>
        <div class="kpi-val" style="color:#0b5ed7;">{{ $totalOrdenes }}</div>
        <div class="kpi-sub">acumulado histórico</div>
    </div>
    <div class="kpi" style="border-left-color:#b91c1c;">
        <div class="kpi-icon">⏳</div>
        <div class="kpi-label">Incompletas</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $incompletas }}</div>
        <div class="kpi-sub">requieren atención</div>
    </div>
    <div class="kpi" style="border-left-color:#b45309;">
        <div class="kpi-icon">⚠️</div>
        <div class="kpi-label">Parciales</div>
        <div class="kpi-val" style="color:#b45309;">{{ $parciales }}</div>
        <div class="kpi-sub">en progreso</div>
    </div>
    <div class="kpi" style="border-left-color:#15803d;background:#f0fdf4;">
        <div class="kpi-icon">✅</div>
        <div class="kpi-label">Completadas</div>
        <div class="kpi-val" style="color:#15803d;">{{ $completas }}</div>
        <div class="kpi-sub">{{ $pctCompletas }}% del total</div>
    </div>
</div>

{{-- ── KPIs fila 2 ── --}}
<div class="kpis">
    <div class="kpi" style="border-left-color:#7c3aed;">
        <div class="kpi-icon">💰</div>
        <div class="kpi-label">Facturado este mes</div>
        <div class="kpi-val" style="font-size:18px;color:#7c3aed;">S/ {{ number_format($facturadoMes,0) }}</div>
        <div class="kpi-sub">{{ now()->format('F Y') }}</div>
    </div>
    <div class="kpi" style="border-left-color:#0ea5e9;">
        <div class="kpi-icon">📋</div>
        <div class="kpi-label">Órdenes este mes</div>
        <div class="kpi-val" style="color:#0284c7;">{{ $ordenesEsteMes }}</div>
        <div class="kpi-sub">mes en curso</div>
    </div>
    <div class="kpi" style="border-left-color:#f59e0b;">
        <div class="kpi-icon">👥</div>
        <div class="kpi-label">Clientes activos</div>
        <div class="kpi-val" style="color:#b45309;">{{ $clientesActivos }}</div>
        <div class="kpi-sub">con órdenes este mes</div>
    </div>
    <div class="kpi" style="border-left-color:#ef4444;">
        <div class="kpi-icon">📦</div>
        <div class="kpi-label">Productos s/ stock</div>
        <div class="kpi-val" style="color:#b91c1c;">{{ $sinStock }}</div>
        <div class="kpi-sub">stock ≤ mínimo</div>
    </div>
</div>

{{-- ── Gráficos principales ── --}}
<div class="section-row">

    {{-- Barra clientes --}}
    <div class="chart-card">
        <div class="chart-title">🏆 Top 10 productos más vendidos</div>
        <div style="position:relative;width:100%;height:220px;">
            <canvas id="clientesChart"></canvas>
        </div>
    </div>

    <div class="right-col">
        {{-- Donut estado --}}
        <div class="stat-card">
            <div class="chart-title">📈 Estado general</div>
            <div class="legend">
                <span class="leg-item"><span class="leg-dot" style="background:#22c55e;"></span>Completas</span>
                <span class="leg-item"><span class="leg-dot" style="background:#f59e0b;"></span>Parciales</span>
                <span class="leg-item"><span class="leg-dot" style="background:#ef4444;"></span>Incompletas</span>
            </div>
            <div style="position:relative;height:130px;">
                <canvas id="estadoChart"></canvas>
            </div>
        </div>

        {{-- Tipos de orden barras --}}
        <div class="stat-card">
            <div class="chart-title">🏷️ Tipos de orden</div>
            @foreach($tiposConteo as $tipo => $cnt)
            @php $pct = $maxTipo > 0 ? round($cnt / $maxTipo * 100) : 0; @endphp
            <div class="prog-item">
                <div class="prog-hdr">
                    <span>{{ $tipo }}</span>
                    <span style="font-weight:700;">{{ $cnt }}</span>
                </div>
                <div class="prog-bar">
                    <div class="prog-fill" style="width:{{ $pct }}%;background:#0b5ed7;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ── Fila inferior ── --}}
<div class="bottom-row">

    {{-- Línea facturación --}}
    <div class="chart-card">
        <div class="chart-title">📅 Facturación — últimos 6 meses</div>
        <div style="position:relative;height:160px;">
            <canvas id="facturacionChart"></canvas>
        </div>
    </div>

    {{-- Tabla recientes --}}
    <div class="chart-card" style="padding:0;overflow:hidden;">
        <div style="padding:.85rem 1.1rem;border-bottom:1px solid #f1f5f9;">
            <div class="chart-title" style="margin:0;">🕐 Órdenes recientes</div>
        </div>
        <div style="overflow-x:auto;">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ordenesRecientes as $ord)
                    @php
                        $badgeCls = $ord->estado === 'COMPLETO' ? 'bc'
                                  : ($ord->estado === 'PARCIAL'  ? 'bp' : 'bi');
                    @endphp
                    <tr>
                        <td style="font-weight:600;font-family:'Consolas',monospace;font-size:11px;">
                            {{ $ord->numero_orden }}
                        </td>
                        <td style="max-width:110px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $ord->client->razon_social ?? '—' }}
                        </td>
                        <td style="font-weight:600;color:#15803d;white-space:nowrap;">
                            S/ {{ number_format($ord->total,0) }}
                        </td>
                        <td>
                            <span class="badge {{ $badgeCls }}">{{ $ord->estado }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

</div>
</div>

{{-- Modal: nueva tarea / evento --}}
<div class="db-modal" id="dbModal" onclick="if(event.target===this)dbCerrarModal()">
    <div class="db-modal-box">
        <h4>Nueva tarea</h4>
        <label>Título</label>
        <input type="text" id="dbTTitle" placeholder="Ej. Confirmar guía de ORD-2081" maxlength="120">
        <div class="two">
            <div><label>Fecha</label><input type="date" id="dbTDate"></div>
            <div><label>Hora (opcional)</label><input type="time" id="dbTTime"></div>
        </div>
        <div class="two">
            <div><label>Tipo</label>
                <select id="dbTTag">
                    <option value="tarea">Tarea</option>
                    <option value="entrega">Entrega</option>
                    <option value="envio">Envío</option>
                    <option value="reunion">Reunión</option>
                    <option value="produccion">Producción</option>
                </select>
            </div>
            <div><label>Lugar (opcional)</label><input type="text" id="dbTPlace" placeholder="Ej. Planta Norte" maxlength="60"></div>
        </div>
        <div class="acts">
            <button type="button" class="db-btn white" onclick="dbCerrarModal()">Cancelar</button>
            <button type="button" class="db-btn blue" onclick="dbGuardarTarea()">Guardar</button>
        </div>
    </div>
</div>

<x-fano />
{{-- ── Scripts ── --}}
@php
    $labelsClientes = json_encode($topProductos->map(fn($d) => $d->product->nombre ?? '?')->values()->toArray());
    $valuesClientes = json_encode($topProductos->map(fn($d) => (int)$d->total_vendido)->values()->toArray());
    $mesesLabelsJ   = json_encode($mesesLabels);
    $mesesDataJ     = json_encode($mesesData);
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var labelsClientes = {!! $labelsClientes !!};
var valuesClientes = {!! $valuesClientes !!};
var mesesLabels    = {!! $mesesLabelsJ !!};
var mesesData      = {!! $mesesDataJ !!};

var colores = ['#0b5ed7','#7c3aed','#0ea5e9','#f59e0b','#22c55e','#ef4444','#ec4899','#14b8a6'];

new Chart(document.getElementById('clientesChart'), {
    type: 'bar',
    data: {
        labels: labelsClientes,
        datasets: [{
            label: 'Pedidos del mes',
            data: valuesClientes,
            backgroundColor: colores.slice(0, labelsClientes.length),
            borderRadius: 5,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } }
        }
    }
});

new Chart(document.getElementById('estadoChart'), {
    type: 'doughnut',
    data: {
        labels: ['Completas','Parciales','Incompletas'],
        datasets: [{
            data: [{{ $completas }}, {{ $parciales }}, {{ $incompletas }}],
            backgroundColor: ['#22c55e','#f59e0b','#ef4444'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '62%'
    }
});

new Chart(document.getElementById('facturacionChart'), {
    type: 'line',
    data: {
        labels: mesesLabels,
        datasets: [{
            label: 'Facturación S/',
            data: mesesData,
            borderColor: '#0b5ed7',
            backgroundColor: 'rgba(11,94,215,.08)',
            borderWidth: 2,
            pointBackgroundColor: '#0b5ed7',
            pointRadius: 4,
            tension: .4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
            y: {
                grid: { color: '#f1f5f9' },
                ticks: {
                    font: { size: 10 },
                    callback: function(v){ return 'S/' + v.toLocaleString(); }
                }
            }
        }
    }
});
</script>
<script>

document.addEventListener("DOMContentLoaded", function () {

    const stock = {{ $stockBajo }};

    const chat = document.getElementById("fano-chat");
    const mensaje = document.getElementById("fano-message");
    const imagen = document.getElementById("fano-img");
    const boton = document.getElementById("fano-btn");

    const hora = new Date().getHours();

    let saludo = "";

    if (hora < 12) {
        saludo = "☀️ Buenos días";
    } else if (hora < 18) {
        saludo = "🌤️ Buenas tardes";
    } else {
        saludo = "🌙 Buenas noches";
    }

    const primeraVez = !sessionStorage.getItem("fano_saludo");

    if (primeraVez) {
        sessionStorage.setItem("fano_saludo", "1");
    }

    function esperar(ms){
        return new Promise(resolve=>setTimeout(resolve,ms));
    }

    async function escribir(texto, velocidad = 22){

        mensaje.innerHTML="";

        for(let i=0;i<texto.length;i++){

            if(texto[i]=="\n"){
                mensaje.innerHTML+="<br>";
            }else{
                mensaje.innerHTML+=texto[i];
            }

            await esperar(velocidad);

        }

    }

    async function mostrarResumen(){

        boton.style.display="none";

        imagen.src="/assets/fano/expresiones/invierno/Pensando.png";

        await escribir("🔎 Revisando el almacén...");

        await esperar(800);

        if(stock==0){

            imagen.src="/assets/fano/expresiones/invierno/Saludando.png";

            await escribir(
                "✅ Todo está en orden.\nNo encontré productos con stock bajo."
            );

        }else{

            imagen.src="/assets/fano/expresiones/invierno/Pensando.png";

            await escribir(
                "⚠ Encontré "+stock+" productos con stock bajo."
            );

            boton.style.display="block";

        }

    }

    async function iniciarFano(){

        clearTimeout(window.fanoTimer);

        chat.classList.remove("fano-hidden");
        chat.classList.add("fano-show");

        boton.style.display="none";

        if(primeraVez){

            imagen.src="/assets/fano/expresiones/invierno/Saludando.png";

            await escribir(
                saludo+"\nHola, bienvenido a DISTAN 👋"
            );

            await esperar(1200);

        }

        await mostrarResumen();

        window.fanoTimer=setTimeout(function(){

            chat.classList.remove("fano-show");
            chat.classList.add("fano-hidden");

        },8000);

    }

    imagen.addEventListener("click",function(){

        iniciarFano();

    });

    boton.addEventListener("click",function(){

        window.location.href="{{ route('products.index') }}";

    });

    iniciarFano();

});

</script>

<script>
// ══════════════════════════════════════════════════════════
//  DASHBOARD · agenda, tareas y asistente DISTAN IA (aditivo)
//  No toca los gráficos (Chart.js) ni el asistente Fano originales.
// ══════════════════════════════════════════════════════════

/* Conexión opcional con una IA real:
   si defines una URL aquí, las preguntas que el asistente no resuelva con los datos
   de la página se envían por POST (JSON: {message, history, context}) y se espera {reply}.
   Ej: var DISTAN_AI_URL = '{{ url('/api/asistente') }}';                                */
var DISTAN_AI_URL = null;

(function () {
    var DB = {!! json_encode($dbJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!};
    function $(id) { return document.getElementById(id); }
    function esc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[c]; }); }
    function norm(s) { return String(s || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ''); }
    function num(n) { var v = Math.round((parseFloat(n) || 0) * 100) / 100; return String(v); }

    /* ── Almacenamiento local (por usuario, en este navegador) ── */
    var K_TASKS = 'distan_tasks_' + DB.uid, K_SYS = 'distan_sys_done_' + DB.uid, K_NOTES = 'distan_notes_' + DB.uid;
    function load(k, d) { try { var v = JSON.parse(localStorage.getItem(k)); return v == null ? d : v; } catch (e) { return d; } }
    function save(k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) {} }

    /* ── Fechas ── */
    var MESES = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    var MESES_L = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var DIAS = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
    function iso(d) { var m = d.getMonth() + 1, day = d.getDate(); return d.getFullYear() + '-' + (m < 10 ? '0' : '') + m + '-' + (day < 10 ? '0' : '') + day; }
    function lunes(d) { var x = new Date(d.getFullYear(), d.getMonth(), d.getDate()); var wd = (x.getDay() + 6) % 7; x.setDate(x.getDate() - wd); return x; }
    var HOY = iso(new Date());
    var week = lunes(new Date());
    var sel = HOY;

    /* ── Agenda ── */
    var TAGS = { entrega: ['Entrega', '#ef4444'], tarea: ['Tarea', '#2563eb'], envio: ['Envío', '#f59e0b'], reunion: ['Reunión', '#6366f1'], produccion: ['Producción', '#8b5cf6'] };
    function tasks() { return load(K_TASKS, []); }

    function renderAgenda() {
        var all = tasks();
        var end = new Date(week); end.setDate(end.getDate() + 6);
        $('dbAgTitulo').textContent = (week.getMonth() === end.getMonth()
            ? MESES_L[week.getMonth()] + ' ' + week.getFullYear()
            : MESES[week.getMonth()] + ' – ' + MESES[end.getMonth()] + ' ' + end.getFullYear());

        var h = '';
        for (var i = 0; i < 7; i++) {
            var d = new Date(week); d.setDate(week.getDate() + i);
            var k = iso(d);
            var has = all.some(function (t) { return t.date === k && !t.done; });
            h += '<button type="button" class="db-day' + (k === sel ? ' sel' : '') + (k === HOY ? ' today' : '') + '" onclick="dbAgDia(\'' + k + '\')">' +
                 '<small>' + DIAS[i] + '</small><b>' + d.getDate() + '</b>' + (has ? '<span class="dot"></span>' : '<span class="dot" style="visibility:hidden"></span>') + '</button>';
        }
        $('dbDays').innerHTML = h;

        var items = all.filter(function (t) { return t.date === sel; })
                       .sort(function (a, b) { return (a.time || '99:99').localeCompare(b.time || '99:99'); });
        if (!items.length) {
            $('dbAgenda').innerHTML = '<div class="db-empty">Sin eventos para este día.<br>Usa «Nueva tarea» para agregar uno.</div>';
            return;
        }
        $('dbAgenda').innerHTML = items.map(function (t) {
            var tg = TAGS[t.tag] || TAGS.tarea;
            return '<div class="db-ev"><time>' + esc(t.time || 'Todo el día') + '</time><span class="pt" style="background:' + tg[1] + ';"></span>' +
                   '<div><b' + (t.done ? ' style="text-decoration:line-through;color:#94a3b8;"' : '') + '>' + esc(t.title) + '</b>' + (t.place ? '<small>' + esc(t.place) + '</small>' : '') + '</div>' +
                   '<span class="db-tag tg-' + esc(t.tag) + '">' + tg[0] + '</span>' +
                   '<button type="button" class="db-dots" title="Eliminar" onclick="dbBorrar(\'' + esc(t.id) + '\')">⋮</button></div>';
        }).join('');
    }
    window.dbAgDia = function (k) { sel = k; renderAgenda(); };
    window.dbAgSemana = function (n) { week.setDate(week.getDate() + 7 * n); renderAgenda(); };
    window.dbAgHoy = function () { week = lunes(new Date()); sel = HOY; renderAgenda(); };
    window.dbBorrar = function (id) {
        var t = tasks().filter(function (x) { return x.id === id; })[0];
        if (!t || !confirm('¿Eliminar «' + t.title + '»?')) return;
        save(K_TASKS, tasks().filter(function (x) { return x.id !== id; }));
        renderAgenda(); renderTasks();
    };

    /* ── Tareas pendientes (propias + sugeridas por el sistema) ── */
    function cuando(t) {
        if (!t.date) return '';
        if (t.date === HOY) return '<span class="db-when">Hoy</span>';
        var m = new Date(); m.setDate(m.getDate() + 1);
        if (t.date === iso(m)) return '<span class="db-when m">Mañana</span>';
        var p = t.date.split('-');
        return '<span class="db-when f">' + parseInt(p[2], 10) + ' ' + MESES[parseInt(p[1], 10) - 1] + '</span>';
    }
    function renderTasks() {
        var mine = tasks().filter(function (t) { return !t.done; })
                          .sort(function (a, b) { return ((a.date || '9999') + (a.time || '')).localeCompare((b.date || '9999') + (b.time || '')); });
        var done = load(K_SYS, []);
        var sys = (DB.sys || []).filter(function (s) { return done.indexOf(s.id) === -1; });
        var rows = mine.map(function (t) { return { id: t.id, sys: false, title: t.title, chip: cuando(t) }; })
                       .concat(sys.map(function (s) { return { id: s.id, sys: true, title: s.title, chip: '<span class="db-when f">Sugerida</span>' }; }));
        $('dbTaskN').textContent = '(' + rows.length + ')';
        $('dbTasks').innerHTML = rows.length ? rows.slice(0, 8).map(function (r) {
            return '<label class="db-task"><input type="checkbox" onchange="dbHecha(\'' + esc(r.id) + '\',' + r.sys + ')">' +
                   '<span class="t">' + esc(r.title) + '</span>' + r.chip + '</label>';
        }).join('') : '<div class="db-empty">🎉 No tienes tareas pendientes.</div>';
    }
    window.dbHecha = function (id, isSys) {
        if (isSys) { var d = load(K_SYS, []); d.push(id); save(K_SYS, d); }
        else { var all = tasks(); all.forEach(function (t) { if (t.id === id) t.done = true; }); save(K_TASKS, all); }
        renderTasks(); renderAgenda();
    };

    /* ── Modal nueva tarea ── */
    window.dbNuevaTarea = function () {
        $('dbTTitle').value = ''; $('dbTTime').value = ''; $('dbTPlace').value = ''; $('dbTTag').value = 'tarea';
        $('dbTDate').value = sel;
        $('dbModal').classList.add('open');
        setTimeout(function () { $('dbTTitle').focus(); }, 50);
    };
    window.dbCerrarModal = function () { $('dbModal').classList.remove('open'); };
    window.dbGuardarTarea = function () {
        var title = $('dbTTitle').value.trim();
        if (!title) { $('dbTTitle').focus(); return; }
        var all = tasks();
        all.push({ id: 't' + Date.now(), title: title, date: $('dbTDate').value || '', time: $('dbTTime').value || '',
                   tag: $('dbTTag').value, place: $('dbTPlace').value.trim(), done: false });
        save(K_TASKS, all);
        if ($('dbTDate').value) { sel = $('dbTDate').value; var p = sel.split('-'); week = lunes(new Date(+p[0], +p[1] - 1, +p[2])); }
        dbCerrarModal(); renderAgenda(); renderTasks();
    };
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') dbCerrarModal(); });
    $('dbTTitle').addEventListener('keydown', function (e) { if (e.key === 'Enter') dbGuardarTarea(); });

    /* ══════════ ASISTENTE DISTAN IA ══════════ */
    var chat = $('dbChat'), hist = [], modoNota = false;
    var IMG_OK = '/assets/fano/expresiones/invierno/Saludando.png', IMG_THINK = '/assets/fano/expresiones/invierno/Pensando.png';

    function addMsg(who, html) {
        var d = document.createElement('div');
        d.className = 'db-msg ' + who;
        d.innerHTML = html;
        chat.appendChild(d);
        chat.scrollTop = chat.scrollHeight;
        return d;
    }
    function link(txt, url) { return '<a href="' + esc(url) + '">' + esc(txt) + '</a>'; }
    function csv(rows, name) {
        var q = function (v) { return '"' + String(v == null ? '' : v).replace(/"/g, '""') + '"'; };
        var blob = new Blob(['\ufeff' + rows.map(function (r) { return r.map(q).join(','); }).join('\r\n')], { type: 'text/csv;charset=utf-8;' });
        var a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = name;
        document.body.appendChild(a); a.click(); a.remove();
        setTimeout(function () { URL.revokeObjectURL(a.href); }, 1000);
    }

    var R = {
        stock: function () {
            if (!DB.stockBajo.length) return '✅ No encontré productos con stock bajo.';
            return '⚠️ Hay <b>' + DB.sinStock + '</b> producto(s) con stock bajo. Los más críticos:<ul>' +
                DB.stockBajo.map(function (p) { return '<li>' + esc(p.n) + ' — <b>' + num(p.st) + '</b> / mín. ' + num(p.mn) + '</li>'; }).join('') +
                '</ul>' + link('Ver productos →', DB.urls.productos);
        },
        pendientes: function () {
            if (!DB.pendientes.length) return '✅ No hay órdenes pendientes.';
            return '📋 Órdenes pendientes:<ul>' + DB.pendientes.map(function (o) {
                return '<li>' + link(o.n, o.u) + ' — ' + esc(o.c) + ' <i>(' + (o.e === 'PARCIAL' ? 'en preparación' : 'incompleta') + ')</i></li>';
            }).join('') + '</ul>' + link('Ver todas las órdenes →', DB.urls.ordenes);
        },
        entregas: function () {
            var hoy = tasks().filter(function (t) { return t.date === HOY && !t.done && (t.tag === 'entrega' || t.tag === 'envio'); });
            var out = '';
            if (hoy.length) out += '🗓️ En tu agenda de hoy:<ul>' + hoy.map(function (t) { return '<li>' + esc(t.time || '') + ' ' + esc(t.title) + (t.place ? ' · ' + esc(t.place) : '') + '</li>'; }).join('') + '</ul>';
            if (DB.envios.length) out += '🚚 Órdenes completas sin guía (' + DB.enviosN + '):<ul>' + DB.envios.map(function (o) { return '<li>' + link(o.n, o.u) + ' — ' + esc(o.c) + '</li>'; }).join('') + '</ul>';
            return out || '✅ No tienes entregas registradas para hoy ni órdenes esperando guía.';
        },
        etiquetas: function () {
            return DB.etqBajas > 0
                ? '🏷️ Hay <b>' + DB.etqBajas + '</b> tipo(s) de etiqueta con stock bajo. ' + link('Ver etiquetas →', DB.urls.etiquetas)
                : '✅ Las etiquetas tienen stock suficiente. ' + link('Ver etiquetas →', DB.urls.etiquetas);
        },
        reporte: function () {
            var rows = [['Producto', 'SKU', 'Stock', 'Stock mínimo', 'Faltante']].concat(DB.stockBajo.map(function (p) {
                return [p.n, p.sku, p.st, p.mn, Math.max(p.mn - p.st, 0)];
            }));
            csv(rows, 'reporte-stock-bajo.csv');
            return '📄 Generé y descargué el reporte de <b>productos con stock bajo</b> (' + DB.stockBajo.length + ' filas). ' +
                   'Para el inventario completo usa ' + link('Ver inventario →', DB.urls.productos) + '.';
        },
        tareas: function () {
            var hoy = tasks().filter(function (t) { return t.date === HOY && !t.done; });
            return hoy.length
                ? '🗓️ Tus tareas de hoy:<ul>' + hoy.map(function (t) { return '<li>' + esc(t.time || '') + ' ' + esc(t.title) + '</li>'; }).join('') + '</ul>'
                : '✅ No tienes tareas con fecha de hoy. Puedes agregar una con «Nueva tarea».';
        },
        notas: function () {
            var n = load(K_NOTES, []);
            return n.length ? '📝 Tus últimas notas:<ul>' + n.slice(-5).reverse().map(function (x) { return '<li>' + esc(x.t) + ' <small>(' + esc(x.d) + ')</small></li>'; }).join('') + '</ul>'
                            : 'Todavía no guardaste notas. Dime «registrar una nota» para crear una.';
        },
        ayuda: function () {
            return '👋 Puedo ayudarte con:<ul><li>Productos con <b>stock bajo</b></li><li><b>Órdenes</b> pendientes</li><li><b>Entregas</b> y envíos de hoy</li><li>Un <b>reporte</b> de inventario (CSV)</li><li><b>Etiquetas</b> con poco stock</li><li>Guardar una <b>nota</b> o ver tus tareas</li></ul>';
        }
    };

    async function responder(q) {
        var n = norm(q);
        if (modoNota) {
            modoNota = false;
            var notas = load(K_NOTES, []);
            notas.push({ t: q, d: new Date().toLocaleDateString('es-PE') });
            save(K_NOTES, notas);
            return '📝 Listo, guardé tu nota: «' + esc(q) + '». Puedes pedirme «ver mis notas».';
        }
        if (/(ver|mis|lista).*notas?|^notas?$/.test(n) && !/registrar|nueva|anotar/.test(n)) return R.notas();
        if (/registrar.*nota|anotar|nueva nota|agrega.*nota|recordatorio|apunta/.test(n)) { modoNota = true; return '¿Qué nota quieres guardar? Escríbela y la registro.'; }
        if (/reporte|exportar|csv|informe/.test(n)) return R.reporte();
        if (/entrega|envio|despach|guia/.test(n)) return R.entregas();
        if (/stock|agotad|reponer|minimo/.test(n)) return R.stock();
        if (/pendient|orden|pedido|incomplet/.test(n)) return R.pendientes();
        if (/etiqueta/.test(n)) return R.etiquetas();
        if (/tarea|agenda|hoy/.test(n)) return R.tareas();
        if (/^(hola|buenas|buen dia|buenos dias|buenas tardes|buenas noches)|ayuda|que puedes|como funcionas/.test(n)) return R.ayuda();

        if (DISTAN_AI_URL) {
            try {
                var r = await fetch(DISTAN_AI_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': DB.csrf },
                    body: JSON.stringify({
                        message: q, history: hist.slice(-6),
                        context: { user: DB.user, sinStock: DB.sinStock, stockBajo: DB.stockBajo, pendientes: DB.pendientes, envios: DB.envios, etiquetasBajas: DB.etqBajas }
                    })
                });
                var j = await r.json();
                var txt = j.reply || j.message || j.answer;
                if (txt) return esc(txt).replace(/\n/g, '<br>');
            } catch (e) { /* si falla, se usa la respuesta local */ }
        }
        return 'No tengo una respuesta para eso todavía (aún no estoy conectado a un modelo de IA). ' + R.ayuda();
    }

    window.dbPreguntar = async function (q) {
        $('dbAiInput').value = '';
        addMsg('me', esc(q));
        hist.push({ role: 'user', content: q });
        var typing = addMsg('bot', '<span class="db-typing"><i></i><i></i><i></i></span>');
        var img = $('dbAiImg'); if (img && img.tagName === 'IMG') img.src = IMG_THINK;
        var reply;
        try { reply = await responder(q); } catch (e) { reply = 'Ocurrió un error al procesar tu consulta.'; }
        await new Promise(function (r) { setTimeout(r, 350); });
        typing.remove();
        addMsg('bot', reply);
        hist.push({ role: 'assistant', content: reply.replace(/<[^>]+>/g, '') });
        if (img && img.tagName === 'IMG') img.src = IMG_OK;
    };
    window.dbEnviar = function (e) {
        e.preventDefault();
        var v = $('dbAiInput').value.trim();
        if (v) window.dbPreguntar(v);
    };

    /* ── Init ── */
    renderAgenda();
    renderTasks();
})();
</script>

@endsection
