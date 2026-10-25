@extends('layouts.app')


@section('content')


<style>
*{box-sizing:border-box;}
.pg{padding:1.25rem;background:#f1f5f9;min-height:100vh;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1.1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.85rem 1rem;display:flex;align-items:center;gap:12px;}
.kpi-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;}
.kpi-label{font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;}
.kpi-val{font-size:20px;font-weight:700;color:#1e293b;line-height:1.1;}
.filter-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1rem;}
.filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:10px;align-items:end;}
@media(max-width:700px){.filter-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:4px;}
.finput{padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.hdr-title{font-size:17px;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:8px;}
.btn-new{background:#16a34a;color:#fff;border:none;padding:9px 16px;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;text-decoration:none;transition:background .15s;}
.btn-new:hover{background:#15803d;}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;}
.order-card{background:#fff;border:1px solid #e2e8f0;border-radius:13px;padding:1.1rem;display:flex;flex-direction:column;gap:.75rem;border-top:4px solid;}
.card-top{display:flex;justify-content:space-between;align-items:flex-start;}
.order-num{font-size:14px;font-weight:700;color:#1e293b;}
.order-client{font-size:12px;color:#94a3b8;margin-top:1px;}
.badge{display:inline-flex;align-items:center;gap:3px;font-size:11px;padding:3px 9px;border-radius:99px;font-weight:600;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}
.meta-row{display:grid;grid-template-columns:1fr 1fr;gap:5px 10px;}
.meta-item{display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;}
.meta-val{font-weight:600;color:#374151;}
hr.div{border:none;border-top:1px solid #f1f5f9;}
.prog-hdr{display:flex;justify-content:space-between;font-size:12px;color:#64748b;margin-bottom:4px;}
.prog-bar{width:100%;height:7px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}
.prog-sub{font-size:11px;color:#94a3b8;margin-top:3px;}
.faltantes{background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:8px 10px;}
.falt-title{font-size:11px;font-weight:700;color:#b91c1c;margin-bottom:4px;display:flex;align-items:center;gap:4px;}
.falt-item{font-size:12px;color:#dc2626;display:flex;justify-content:space-between;padding:2px 0;border-bottom:1px solid #fecaca;}
.falt-item:last-child{border-bottom:none;}
.falt-qty{font-weight:700;}
.btn-row{display:grid;grid-template-columns:1fr 1fr;gap:7px;}
.btn{display:flex;align-items:center;justify-content:center;gap:4px;padding:8px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-blue{background:#eff6ff;color:#1d4ed8;}
.btn-green{background:#f0fdf4;color:#15803d;}
.btn-gray{background:#f8fafc;color:#475569;}
.btn-red{background:#fef2f2;color:#b91c1c;}
.btn-full{grid-column:1/-1;}

/* ══════════════════════════════════════════════════════════
   PEDIDOS · rediseño lista + detalle (prefijo po-) — aditivo
   Mantiene .finput/.flabel/.btn-new y todo el CSS anterior.
══════════════════════════════════════════════════════════ */
.po{
    --po-navy:#1e3a5f; --po-blue:#1d7ff2; --po-blue-soft:#eaf2ff;
    --po-green:#16a34a; --po-orange:#f59e0b; --po-red:#ef4444;
    --po-text:#0f172a; --po-muted:#64748b; --po-line:#e2e8f0; --po-bg:#f8fafc;
    --po-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
    color:var(--po-text);
}
.po-i{width:16px;height:16px;flex-shrink:0;}
.po-num{font-family:var(--po-mono);font-variant-numeric:tabular-nums;}
.po-card{background:#fff;border:1px solid var(--po-line);border-radius:14px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.po-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 11px;border-radius:7px;font-size:11.5px;font-weight:700;white-space:nowrap;}
.po-ok{background:#dcfce7;color:#15803d;}
.po-proc{background:#fef3c7;color:#b45309;}
.po-bad{background:#fee2e2;color:#b91c1c;}
.po-pen{background:#eef2f7;color:#475569;}

/* Cabecera */
.po-head{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:14px;}
.po-head-l{display:flex;align-items:center;gap:14px;}
.po-logo{width:56px;height:56px;border-radius:14px;background:#e3eefc;color:var(--po-blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.po-logo .po-i{width:28px;height:28px;}
.po-title{font-size:24px;font-weight:800;color:var(--po-navy);margin:0;line-height:1.1;letter-spacing:-.3px;}
.po-sub{font-size:13px;color:var(--po-muted);margin-top:4px;}
.po-head-r{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.po-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;border:1px solid transparent;font-family:inherit;transition:filter .15s,background .15s;}
.po-btn:hover{filter:brightness(.95);}
.po-btn.blue{background:var(--po-blue);color:#fff;}
.po-btn.green{background:#16a34a;color:#fff;}
.po-btn.white{background:#fff;color:var(--po-blue);border-color:#cfe0fb;}
.po-btn.red{background:#fff5f5;color:#b91c1c;border-color:#fecaca;}
.po-btn.sm{padding:8px 13px;font-size:12px;}

/* KPIs */
.po-kpis{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:14px;}
@media(max-width:1180px){.po-kpis{grid-template-columns:repeat(3,1fr);}}
@media(max-width:620px){.po-kpis{grid-template-columns:1fr 1fr;}}
.po-k{display:flex;align-items:center;gap:12px;border-radius:14px;padding:13px 14px;background:#fff;border:1px solid var(--po-line);}
.po-k-ic{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.po-k-ic .po-i{width:24px;height:24px;}
.po-k small.l{display:block;font-size:12px;font-weight:700;color:#334155;}
.po-k b{display:block;font-size:26px;font-weight:800;line-height:1.1;font-family:var(--po-mono);}
.po-k small.s{font-size:11px;color:var(--po-muted);}
.po-k .pc{margin-left:auto;font-size:12px;font-weight:700;font-family:var(--po-mono);align-self:flex-end;}
.po-k.t-blue{background:#f3f8ff;border-color:#dbe8ff;}.po-k.t-blue .po-k-ic{background:#dbeafe;color:#2563eb;}
.po-k.t-orange{background:#fff9ee;border-color:#fde7b0;}.po-k.t-orange .po-k-ic{background:#fde9c4;color:#d97706;}.po-k.t-orange b,.po-k.t-orange .pc{color:#d97706;}
.po-k.t-green{background:#f1fcf5;border-color:#c9f0d5;}.po-k.t-green .po-k-ic{background:#d1fae5;color:#16a34a;}.po-k.t-green b,.po-k.t-green .pc{color:#15803d;}
.po-k.t-red{background:#fff4f4;border-color:#fecaca;}.po-k.t-red .po-k-ic{background:#fee2e2;color:#dc2626;}.po-k.t-red b,.po-k.t-red .pc{color:#b91c1c;}
.po-k.t-navy{background:#f0f6ff;border-color:#d3e1f7;}.po-k.t-navy .po-k-ic{background:#dbe5f5;color:#1e3a5f;}.po-k.t-navy b{font-size:19px;color:var(--po-navy);}

/* Toolbar */
.po-bar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin-bottom:12px;}
.po-pills{display:flex;gap:7px;flex-wrap:wrap;}
.po-pill{display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:9px;font-size:12.5px;font-weight:700;text-decoration:none;background:#fff;color:#334155;border:1px solid var(--po-line);}
.po-pill:hover{background:#f8fbff;}
.po-pill em{font-style:normal;background:rgba(15,23,42,.08);border-radius:99px;padding:1px 8px;font-size:11px;}
.po-pill.on{background:var(--po-blue);border-color:var(--po-blue);color:#fff;}
.po-pill.on em{background:rgba(255,255,255,.25);}
.po-form{display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end;margin-left:auto;}
.po-form label{display:block;font-size:10.5px;font-weight:700;color:var(--po-muted);text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;}
.po-form .finput{padding:8px 10px;font-size:12.5px;border-radius:9px;min-width:130px;}
.po-search{position:relative;min-width:220px;flex:1;}
.po-search .po-i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;}
.po-search input{width:100%;padding:9px 12px 9px 34px;border:1px solid var(--po-line);border-radius:9px;font-size:12.5px;outline:none;font-family:inherit;background:#fff;}
.po-search input:focus{border-color:var(--po-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);}
.po-lim{display:inline-flex;align-items:center;padding:9px 14px;border-radius:9px;font-size:12.5px;font-weight:700;background:#eef2f7;color:#334155;text-decoration:none;}

/* Layout */
.po-grid{display:grid;grid-template-columns:minmax(0,1.02fr) minmax(0,1fr);gap:14px;align-items:start;}
@media(max-width:1180px){.po-grid{grid-template-columns:1fr;}}
.po-side{position:sticky;top:calc(var(--tn-h,176px) + 12px);display:flex;flex-direction:column;gap:12px;}
@media(max-width:1180px){.po-side{position:static;}}

/* Barra de selección */
.po-bulk{display:none;align-items:center;gap:12px;background:#10244a;color:#fff;border-radius:10px;padding:8px 14px;font-size:12.5px;margin-bottom:10px;}
.po-bulk.show{display:flex;}
.po-bulk button{background:rgba(255,255,255,.14);border:none;color:#fff;border-radius:7px;padding:6px 12px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;}

/* Tabla */
.po-scroll{overflow-x:auto;}
.po-tbl{width:100%;min-width:640px;border-collapse:collapse;font-size:12.5px;}
.po-tbl th{background:#f8fafc;color:#475569;font-size:11.5px;font-weight:700;padding:11px 10px;text-align:left;white-space:nowrap;border-bottom:1px solid var(--po-line);}
.po-tbl th.c,.po-tbl td.c{text-align:center;}
.po-tbl td{padding:10px;border-bottom:1px solid #eef2f7;vertical-align:middle;}
.po-tbl tr.po-row{cursor:pointer;}
.po-tbl tr.po-row:hover td{background:#fafcff;}
.po-tbl tr.po-row.sel td{background:#eef5ff;}
.po-tbl input[type=checkbox]{width:15px;height:15px;accent-color:var(--po-blue);cursor:pointer;}
.po-ped{font-weight:800;color:var(--po-navy);font-family:var(--po-mono);}
.po-ver{border:1px solid #bcd6fb;background:#fff;color:var(--po-blue);border-radius:7px;font-size:12px;font-weight:700;padding:5px 11px;cursor:pointer;font-family:inherit;}
.po-ver:hover{background:#f1f7ff;}
.po-dots{width:30px;height:30px;border:1px solid var(--po-line);background:#fff;border-radius:7px;cursor:pointer;color:#475569;display:inline-flex;align-items:center;justify-content:center;padding:0;}
.po-dots:hover{background:#f1f5f9;}
.po-acts{display:flex;gap:6px;align-items:center;justify-content:center;}
.po-foot{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;padding:10px 14px;font-size:12.5px;color:var(--po-muted);}
.po-empty{display:none;text-align:center;padding:24px;color:var(--po-muted);font-size:13px;}
.po-rmenu{display:none;position:fixed;z-index:950;min-width:190px;background:#fff;border:1px solid var(--po-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.18);padding:6px;}
.po-rmenu.open{display:block;}
.po-rmenu a,.po-rmenu button{display:flex;align-items:center;gap:9px;width:100%;padding:9px 10px;border:none;background:none;border-radius:7px;font-size:13px;color:#1e293b;cursor:pointer;text-decoration:none;font-family:inherit;text-align:left;}
.po-rmenu a:hover,.po-rmenu button:hover{background:#f1f5f9;}
.po-rmenu .danger{color:#b91c1c;}

/* Panel de detalle */
.po-det{display:none;}
.po-dcard{border:2px solid var(--po-blue);border-radius:14px;background:#fff;overflow:hidden;margin-bottom:12px;}
.po-det.on{display:block;}
.po-oh{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:flex-start;padding:14px 16px 4px;}
.po-oh-l{display:flex;gap:12px;align-items:flex-start;min-width:0;}
.po-oh-ic{width:46px;height:46px;border-radius:11px;background:#e8f0fe;color:var(--po-blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.po-oh-ic .po-i{width:23px;height:23px;}
.po-oh-t{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.po-oh-t strong{font-size:19px;font-weight:800;color:var(--po-navy);font-family:var(--po-mono);}
.po-oh-cli{font-size:13px;font-weight:600;color:#334155;margin-top:2px;}
.po-oh-r{display:flex;gap:7px;}
.po-meta{display:flex;gap:18px;flex-wrap:wrap;padding:4px 16px 10px;font-size:12px;color:var(--po-muted);}
.po-meta span{display:inline-flex;align-items:center;gap:6px;}
.po-meta b{color:var(--po-text);font-weight:600;}
.po-tabs{display:flex;gap:2px;border-bottom:1px solid var(--po-line);padding:0 12px;overflow-x:auto;}
.po-tab{background:none;border:none;padding:11px 16px;font-size:13px;font-weight:600;color:var(--po-muted);cursor:pointer;border-bottom:3px solid transparent;margin-bottom:-1px;white-space:nowrap;font-family:inherit;}
.po-tab.on{color:var(--po-blue);border-bottom-color:var(--po-blue);}
.po-pane{display:none;padding:14px 16px 16px;}
.po-pane.on{display:block;}
.po-pt{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:6px;}
.po-pt b{font-size:13px;}
.po-pt span{font-size:12px;color:#334155;}
.po-pr{display:flex;align-items:center;gap:12px;margin-bottom:12px;}
.po-bar2{flex:1;height:10px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.po-bar2 > div{height:100%;border-radius:99px;}
.po-pct{font-size:22px;font-weight:800;font-family:var(--po-mono);}
.po-ptbl{width:100%;border-collapse:collapse;font-size:12px;border:1px solid var(--po-line);border-radius:10px;overflow:hidden;}
.po-ptbl th{background:#f8fafc;color:#475569;font-size:11px;padding:8px;text-align:left;white-space:nowrap;}
.po-ptbl th.c,.po-ptbl td.c{text-align:center;}
.po-ptbl td{padding:8px;border-top:1px solid #eef2f7;vertical-align:middle;}
.po-ptbl .more{display:none;}
.po-det.all .po-ptbl .more{display:table-row;}
.po-pn{display:flex;align-items:center;gap:8px;}
.po-th{width:30px;height:30px;border-radius:7px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.po-pn b{font-weight:700;font-size:12px;}
.po-pg{display:flex;align-items:center;gap:6px;min-width:100px;}
.po-pg .po-bar2{height:6px;}
.po-pg b{font-size:11px;font-family:var(--po-mono);min-width:34px;text-align:right;}
.po-all{display:block;width:100%;text-align:center;margin-top:10px;padding:9px;border:none;border-radius:9px;background:#eef5ff;color:var(--po-blue);font-size:12.5px;font-weight:700;cursor:pointer;font-family:inherit;}
.po-box{border:1px solid var(--po-line);border-radius:12px;padding:12px;margin-bottom:10px;}
.po-box h4{margin:0 0 8px;font-size:12.5px;font-weight:800;color:var(--po-navy);}
.po-dl > div{display:grid;grid-template-columns:130px 1fr;gap:8px;padding:5px 0;font-size:12.5px;}
.po-dl span{color:var(--po-muted);}
.po-dl b{font-weight:600;}
.po-obs{font-size:13px;line-height:1.6;color:#334155;white-space:pre-wrap;min-height:50px;}
.po-ev{display:flex;gap:10px;align-items:flex-start;padding:9px 11px;border:1px solid var(--po-line);border-radius:10px;margin-bottom:6px;}
.po-ev-ic{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;background:var(--po-blue-soft);}
.po-ev b{display:block;font-size:12.5px;}
.po-ev span{font-size:11.5px;color:var(--po-muted);}
.po-ev time{margin-left:auto;font-size:11px;color:var(--po-muted);font-family:var(--po-mono);white-space:nowrap;}

/* Línea de estado */
.po-steps{display:grid;grid-template-columns:repeat(5,1fr);padding:12px 8px 8px;}
.po-step{text-align:center;position:relative;font-size:11.5px;color:var(--po-muted);}
.po-step .dot{width:24px;height:24px;border-radius:50%;margin:0 auto 6px;display:flex;align-items:center;justify-content:center;background:#e5e7eb;color:#fff;position:relative;z-index:2;}
.po-step .dot .po-i{width:13px;height:13px;}
.po-step::before{content:'';position:absolute;top:11px;left:-50%;width:100%;height:3px;background:#e5e7eb;z-index:1;}
.po-step:first-child::before{display:none;}
.po-step.done .dot{background:#2563eb;}
.po-step.done::before{background:#2563eb;}
.po-step.cur .dot{box-shadow:0 0 0 5px rgba(37,99,235,.15);}
.po-step b{display:block;font-size:11.5px;color:#334155;font-weight:700;line-height:1.2;}
.po-step small{display:block;font-size:10px;color:#94a3b8;font-family:var(--po-mono);margin-top:1px;min-height:12px;}

/* Barra de acciones */
.po-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:14px;}
.po-actions .po-btn{padding:12px 20px;}
@media(max-width:620px){.po-actions .po-btn{flex:1;justify-content:center;}}
.po-nodet{padding:40px 20px;text-align:center;color:var(--po-muted);}
</style>


<div class="pg">

{{-- ── KPIs: mismas variables del original ── --}}
@php
   $total      = $orders->total();
   $completos  = $orders->getCollection()->where('estado','COMPLETO')->count();
   $parciales  = $orders->getCollection()->where('estado','PARCIAL')->count();
   $incompletos= $orders->getCollection()->where('estado','INCOMPLETO')->count();
   $montoTotal = $orders->getCollection()->sum('total');
@endphp

{{-- ── Datos adicionales para el rediseño (solo lectura) ── --}}
@php
    $poN      = max(1, $orders->count());
    $poPc     = fn($n) => round(($n / $poN) * 100) . '%';
    $poFecha  = fn($v, $f = 'd/m/Y') => $v ? \Carbon\Carbon::parse($v)->format($f) : '—';
    $poFH     = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m H:i') : '';
    $poNum    = fn($n) => rtrim(rtrim(number_format((float) $n, 2, '.', ''), '0'), '.') ?: '0';
    $poEstReq = request('estado');

    // Estado de la orden → texto / clase / ícono
    $poEst = function ($e) {
        return match ($e) {
            'COMPLETO' => ['Completado',     'po-ok',   '✔'],
            'PARCIAL'  => ['En preparación', 'po-proc', '◔'],
            default    => ['Incompleto',     'po-bad',  '!'],
        };
    };
    // Estado de cada línea
    $poItem = function ($e) {
        return match ($e) {
            'COMPLETO' => ['Listo',          'po-ok'],
            'PARCIAL'  => ['En preparación', 'po-proc'],
            default    => ['Pendiente',      'po-pen'],
        };
    };
    $poImg = function ($p) {
        $i = $p->imagen ?? $p->image ?? $p->foto ?? null;
        if ($i && is_string($i) && !preg_match('#^(https?:)?//#', $i)) { $i = asset('storage/' . ltrim($i, '/')); }
        return is_string($i) ? $i : null;
    };
@endphp

{{-- Iconos --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="po-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 1.98-1.7L23 6H6"/></symbol>
    <symbol id="po-store" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M5 12v8h14v-8"/><path d="M10 20v-5h4v5"/></symbol>
    <symbol id="po-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
    <symbol id="po-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></symbol>
    <symbol id="po-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></symbol>
    <symbol id="po-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
    <symbol id="po-alert" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></symbol>
    <symbol id="po-money" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></symbol>
    <symbol id="po-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
    <symbol id="po-cal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
    <symbol id="po-printer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></symbol>
    <symbol id="po-truck" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></symbol>
    <symbol id="po-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
    <symbol id="po-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="po-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></symbol>
    <symbol id="po-dots" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="12" cy="19" r="1.8"/></symbol>
    <symbol id="po-list" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></symbol>
</defs></svg>

<div class="po">

{{-- ══════════ CABECERA ══════════ --}}
<div class="po-head">
    <div class="po-head-l">
        <div class="po-logo"><svg class="po-i"><use href="#po-cart"/></svg></div>
        <div>
            <h1 class="po-title">Pedidos</h1>
            <div class="po-sub">Gestiona y da seguimiento a las órdenes de tiendas y clientes.</div>
        </div>
    </div>
    <div class="po-head-r">
        {{-- IMPORTAR PEDIDO DESDE PDF --}}
        <a href="{{ route('orders.importPdf') }}" class="po-btn white"><svg class="po-i"><use href="#po-file"/></svg> Importar pedido PDF</a>

        {{-- STOCK DE PEDIDOS --}}
        <button type="button" onclick="abrirStockPedidos()" class="po-btn white"><svg class="po-i"><use href="#po-box"/></svg> Stock de pedidos</button>

        {{-- NUEVA ORDEN --}}
        <a href="{{ route('orders.create') }}" class="po-btn blue"><svg class="po-i"><use href="#po-plus"/></svg> Nueva orden</a>
    </div>
</div>

{{-- ══════════ KPIs ══════════ --}}
<div class="po-kpis">
    <div class="po-k t-blue">
        <div class="po-k-ic"><svg class="po-i"><use href="#po-store"/></svg></div>
        <div><small class="l">Total de órdenes</small><b>{{ $total }}</b><small class="s">Órdenes registradas</small></div>
    </div>
    <div class="po-k t-orange">
        <div class="po-k-ic"><svg class="po-i"><use href="#po-clock"/></svg></div>
        <div><small class="l">En progreso</small><b>{{ $parciales }}</b><small class="s">En esta página</small></div>
        <span class="pc">{{ $poPc($parciales) }}</span>
    </div>
    <div class="po-k t-green">
        <div class="po-k-ic"><svg class="po-i"><use href="#po-shield"/></svg></div>
        <div><small class="l">Completadas</small><b>{{ $completos }}</b><small class="s">En esta página</small></div>
        <span class="pc">{{ $poPc($completos) }}</span>
    </div>
    <div class="po-k t-red">
        <div class="po-k-ic"><svg class="po-i"><use href="#po-alert"/></svg></div>
        <div><small class="l">Incompletas</small><b>{{ $incompletos }}</b><small class="s">Requieren atención</small></div>
        <span class="pc">{{ $poPc($incompletos) }}</span>
    </div>
    <div class="po-k t-navy">
        <div class="po-k-ic"><svg class="po-i"><use href="#po-money"/></svg></div>
        <div><small class="l">Monto de la página</small><b>S/ {{ number_format($montoTotal, 2) }}</b><small class="s">Suma de totales</small></div>
    </div>
</div>

{{-- ══════════ FILTROS ══════════ --}}
<div class="po-bar">
    <div class="po-pills">
        <a class="po-pill {{ !$poEstReq ? 'on' : '' }}" href="{{ request()->fullUrlWithQuery(['estado' => null, 'page' => null]) }}">Todos @if(!$poEstReq)<em>{{ $total }}</em>@endif</a>
        <a class="po-pill {{ $poEstReq === 'PARCIAL' ? 'on' : '' }}" href="{{ request()->fullUrlWithQuery(['estado' => 'PARCIAL', 'page' => null]) }}">En preparación @if($poEstReq === 'PARCIAL')<em>{{ $total }}</em>@endif</a>
        <a class="po-pill {{ $poEstReq === 'COMPLETO' ? 'on' : '' }}" href="{{ request()->fullUrlWithQuery(['estado' => 'COMPLETO', 'page' => null]) }}">Completados @if($poEstReq === 'COMPLETO')<em>{{ $total }}</em>@endif</a>
        <a class="po-pill {{ $poEstReq === 'INCOMPLETO' ? 'on' : '' }}" href="{{ request()->fullUrlWithQuery(['estado' => 'INCOMPLETO', 'page' => null]) }}">Incompletos @if($poEstReq === 'INCOMPLETO')<em>{{ $total }}</em>@endif</a>
    </div>

    {{-- Formulario GET original: fecha_inicio, fecha_fin, estado --}}
    <form method="GET" class="po-form">
        <div>
            <label>Desde</label>
            <input type="date" name="fecha_inicio" class="finput" value="{{ request('fecha_inicio') }}">
        </div>
        <div>
            <label>Hasta</label>
            <input type="date" name="fecha_fin" class="finput" value="{{ request('fecha_fin') }}">
        </div>
        <div>
            <label>Estado</label>
            <select name="estado" class="finput">
                <option value="">Todos</option>
                @foreach(['COMPLETO','PARCIAL','INCOMPLETO'] as $e)
                    <option value="{{ $e }}" @selected(request('estado')===$e)>{{ $e }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="po-btn blue sm" style="height:36px;"><svg class="po-i"><use href="#po-search"/></svg> Buscar</button>
        <a href="{{ url()->current() }}" class="po-lim" style="height:36px;">Limpiar</a>
    </form>
</div>

{{-- ══════════ LISTA + DETALLE ══════════ --}}
<div class="po-grid">

    {{-- ───────── Lista ───────── --}}
    <div>
        <div class="po-search" style="margin-bottom:10px;">
            <svg class="po-i"><use href="#po-search"/></svg>
            <input type="text" id="poBuscar" placeholder="Buscar por pedido, cliente, factura o guía..." oninput="poFiltrar()">
        </div>

        <div class="po-bulk" id="poBulk">
            <span><b id="poBulkN">0</b> seleccionadas</span>
            <button type="button" onclick="poExportSel()">⬇ Exportar CSV</button>
            <button type="button" onclick="poQuitarSel()">Quitar selección</button>
        </div>

        <div class="po-card">
            <div class="po-scroll">
            <table class="po-tbl" id="poTabla">
                <thead>
                    <tr>
                        <th style="width:34px;"><input type="checkbox" id="poAll" onclick="poToggleAll(this)" title="Seleccionar visibles"></th>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th class="c">Productos</th>
                        <th>Estado</th>
                        <th class="c">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    @php
                        $rItems = $order->details->count();
                        [$rTxt, $rCls, $rIc] = $poEst($order->estado);
                        $rCli = $order->client->razon_social ?? 'Sin cliente';
                    @endphp
                    <tr class="po-row" data-oid="{{ $order->id }}"
                        data-numero="{{ $order->numero_orden }}"
                        data-cliente="{{ $rCli }}"
                        data-fecha="{{ $poFecha($order->fecha_pedido) }}"
                        data-items="{{ $rItems }}"
                        data-estado="{{ $rTxt }}"
                        data-total="{{ number_format($order->total, 2, '.', '') }}"
                        data-search="{{ mb_strtolower($order->numero_orden.' '.$rCli.' '.($order->factura_asociada ?? '').' '.($order->guia_asociada ?? '').' '.($order->order_interna ?? '')) }}">
                        <td onclick="event.stopPropagation()"><input type="checkbox" class="po-chk" onclick="poChkChange()"></td>
                        <td class="po-ped">{{ $order->numero_orden }}</td>
                        <td>{{ $rCli }}</td>
                        <td class="po-num">{{ $poFecha($order->fecha_pedido) }}</td>
                        <td class="c po-num">{{ $rItems }}</td>
                        <td><span class="po-chip {{ $rCls }}">{{ $rIc }} {{ $rTxt }}</span></td>
                        <td onclick="event.stopPropagation()">
                            <div class="po-acts">
                                <button type="button" class="po-ver" onclick="poSel({{ $order->id }}, true)">Ver</button>
                                <button type="button" class="po-dots" title="Más acciones" onclick="poRowMenu(this, {{ $order->id }}, event)"><svg class="po-i"><use href="#po-dots"/></svg></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:28px;">No hay órdenes para los filtros seleccionados.</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
            <div class="po-empty" id="poVacio">Ninguna orden de esta página coincide con la búsqueda.</div>

            <div class="po-foot">
                <span>Mostrando {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} de {{ $total }} pedidos</span>
            </div>
        </div>

        {{-- Paginación (original) --}}
        <div style="margin-top:1rem;">
           {{ $orders->links() }}
        </div>
    </div>

    {{-- ───────── Detalle de la orden seleccionada ───────── --}}
    <aside class="po-side">

        <div class="po-card po-nodet" id="poNoDet" style="{{ $orders->count() ? 'display:none;' : '' }}">
            <div style="font-size:34px;">📋</div>
            <b style="display:block;margin-top:6px;color:var(--po-text);">Selecciona una orden</b>
            Elige una de la lista para ver su detalle.
        </div>

        @foreach($orders as $order)
        @php
            $dTotal   = $order->details->count();
            $dOk      = $order->details->where('estado_item','COMPLETO')->count();
            $dPar     = $order->details->where('estado_item','PARCIAL')->count();
            $dPct     = $dTotal > 0 ? round(($dOk / $dTotal) * 100) : 0;
            $dColor   = $dPct >= 100 ? '#16a34a' : '#1d7ff2';
            [$dTxt, $dCls, $dIc] = $poEst($order->estado);
            $dCli     = $order->client->razon_social ?? 'Sin cliente';
            $dOrden   = $order->details->sortBy(fn($d) => $d->estado_item === 'COMPLETO' ? 1 : 0)->values();

            // Línea de estado
            $dAny   = $order->details->contains(fn($d) => $d->cantidad_despachada > 0);
            $dUlt   = $order->details->max('updated_at');
            $dDesp  = $order->fecha_despacho ?? $order->despachado_at ?? null;
            $dSteps = [
                ['Pedido registrado',   true,                                                 $order->created_at ?? null],
                ['En preparación',      $dAny,                                                $dAny ? $dUlt : null],
                ['Listo para despacho', $order->estado === 'COMPLETO',                        $order->estado === 'COMPLETO' ? $dUlt : null],
                ['Despachado',          (bool) $dDesp,                                        $dDesp],
                ['Completado',          (bool) $dDesp && $order->estado === 'COMPLETO',       $order->estado === 'COMPLETO' ? ($order->updated_at ?? null) : null],
            ];
            $dCur = 0;
            foreach ($dSteps as $k => $s) { if ($s[1]) { $dCur = $k; } }

            // Historial (derivado de fechas de registro)
            $dEv = collect();
            $dAdd = function ($f, $ic, $t, $d = '') use (&$dEv) {
                if (!$f) { return; }
                $c = \Carbon\Carbon::parse($f);
                $dEv->push(['f' => $c, 'ts' => $c->getTimestamp(), 'i' => $ic, 't' => $t, 'd' => $d]);
            };
            $dAdd($order->created_at ?? null, '🆕', 'Orden registrada', $order->numero_orden);
            foreach ($order->details as $x) {
                $nm = $x->product->nombre ?? 'Producto';
                $dAdd($x->created_at ?? null, '➕', 'Producto agregado', $nm . ' · ' . $poNum($x->cantidad_solicitada) . ' u');
                if (($x->created_at ?? null) && ($x->updated_at ?? null)
                    && abs(\Carbon\Carbon::parse($x->updated_at)->getTimestamp() - \Carbon\Carbon::parse($x->created_at)->getTimestamp()) > 60) {
                    $dAdd($x->updated_at, '✏️', 'Línea actualizada', $nm . ' · despachado ' . $poNum($x->cantidad_despachada) . ' de ' . $poNum($x->cantidad_solicitada));
                }
            }
            $dEv = $dEv->sortByDesc('ts')->values()->take(30);
        @endphp

        <div class="po-det {{ $loop->first ? 'on' : '' }}" data-oid="{{ $order->id }}"
             data-numero="{{ $order->numero_orden }}"
             data-edit="{{ route('orders.edit', $order) }}"
             data-operario="{{ route('orders.operario', $order) }}">

            <div class="po-dcard">
                <div class="po-oh">
                    <div class="po-oh-l">
                        <div class="po-oh-ic"><svg class="po-i"><use href="#po-store"/></svg></div>
                        <div>
                            <div class="po-oh-t">
                                <strong>{{ $order->numero_orden }}</strong>
                                <span class="po-chip {{ $dCls }}" title="{{ $order->estado }}">{{ $dIc }} {{ $dTxt }}</span>
                            </div>
                            <div class="po-oh-cli">{{ $dCli }}</div>
                        </div>
                    </div>
                    <div class="po-oh-r">
                        <a href="{{ route('orders.edit', $order) }}" class="po-btn white sm"><svg class="po-i"><use href="#po-edit"/></svg> Controlar</a>
                    </div>
                </div>

                <div class="po-meta">
                    <span><svg class="po-i"><use href="#po-cal"/></svg><b class="po-num">{{ $poFecha($order->fecha_pedido) }}</b></span>
                    <span><svg class="po-i"><use href="#po-box"/></svg><b>{{ $dTotal }} productos</b></span>
                    <span><svg class="po-i"><use href="#po-file"/></svg>Factura: <b class="po-num">{{ $order->factura_asociada ?? '—' }}</b></span>
                    <span><svg class="po-i"><use href="#po-truck"/></svg>Guía: <b class="po-num">{{ $order->guia_asociada ?? '—' }}</b></span>
                </div>

                <div class="po-tabs">
                    <button type="button" class="po-tab on" data-tab="prod" onclick="poTab(this,'prod')">Productos ({{ $dTotal }})</button>
                    <button type="button" class="po-tab" data-tab="info" onclick="poTab(this,'info')">Información</button>
                    <button type="button" class="po-tab" data-tab="obs" onclick="poTab(this,'obs')">Observaciones</button>
                    <button type="button" class="po-tab" data-tab="hist" onclick="poTab(this,'hist')">Historial</button>
                </div>

                {{-- Productos --}}
                <div class="po-pane on" data-pane="prod">
                    <div class="po-pt"><b>Progreso de preparación</b><span class="po-num">{{ $dOk }} / {{ $dTotal }} productos</span></div>
                    <div class="po-pr">
                        <div class="po-bar2"><div style="width:{{ $dPct }}%;background:{{ $dColor }};"></div></div>
                        <div class="po-pct" style="color:{{ $dColor }};">{{ $dPct }}%</div>
                    </div>

                    <div class="po-scroll">
                    <table class="po-ptbl">
                        <thead><tr><th>Producto</th><th>SKU</th><th class="c">Pedido</th><th class="c">Preparado</th><th class="c">Pendiente</th><th>Progreso</th><th>Estado</th></tr></thead>
                        <tbody>
                        @forelse($dOrden as $d)
                            @php
                                $sol = (float) $d->cantidad_solicitada;
                                $des = (float) $d->cantidad_despachada;
                                $pen = max($sol - $des, 0);
                                $pp  = $sol > 0 ? min(100, round($des / $sol * 100)) : 0;
                                $pc  = $pp >= 100 ? '#16a34a' : ($pp > 0 ? '#1d7ff2' : '#fca5a5');
                                [$iTxt, $iCls] = $poItem($d->estado_item);
                                $th  = $poImg($d->product);
                            @endphp
                            <tr class="po-prow {{ $loop->index >= 5 ? 'more' : '' }}"
                                data-nombre="{{ $d->product->nombre }}" data-sku="{{ $d->product->sku ?? '' }}"
                                data-sol="{{ $poNum($sol) }}" data-des="{{ $poNum($des) }}" data-pen="{{ $poNum($pen) }}">
                                <td><div class="po-pn"><div class="po-th">@if($th)<img src="{{ $th }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:7px;" loading="lazy" onerror="this.replaceWith(document.createTextNode('📦'))">@else 📦 @endif</div><b>{{ $d->product->nombre }}</b></div></td>
                                <td class="po-num" style="color:#64748b;font-size:11px;">{{ $d->product->sku ?? '—' }}</td>
                                <td class="c po-num" style="font-weight:700;">{{ $poNum($sol) }}</td>
                                <td class="c po-num" style="font-weight:700;color:{{ $pp >= 100 ? '#16a34a' : '#0f172a' }};">{{ $poNum($des) }}</td>
                                <td class="c po-num" style="font-weight:700;color:{{ $pen > 0 ? '#ef4444' : '#16a34a' }};">{{ $poNum($pen) }}</td>
                                <td><div class="po-pg"><div class="po-bar2"><div style="width:{{ $pp }}%;background:{{ $pc }};"></div></div><b style="color:{{ $pp > 0 ? $pc : '#94a3b8' }};">{{ $pp }}%</b></div></td>
                                <td><span class="po-chip {{ $iCls }}">{{ $iTxt }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:18px;">Esta orden no tiene productos.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    </div>
                    @if($dTotal > 5)
                        <button type="button" class="po-all" onclick="this.closest('.po-det').classList.toggle('all');this.textContent=this.closest('.po-det').classList.contains('all')?'Mostrar menos':'Ver todos los productos ({{ $dTotal }})'">Ver todos los productos ({{ $dTotal }})</button>
                    @endif
                    <div style="font-size:11px;color:var(--po-muted);margin-top:8px;">Los productos incompletos se muestran primero.</div>
                </div>

                {{-- Información --}}
                <div class="po-pane" data-pane="info">
                    <div class="po-box">
                        <h4>Datos de la orden</h4>
                        <div class="po-dl">
                            <div><span>Nº Orden</span><b>{{ $order->numero_orden }}</b></div>
                            <div><span>Tipo</span><b>{{ $order->tipo_orden ?? '—' }}</b></div>
                            <div><span>Fecha</span><b>{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d M Y') }}</b></div>
                            <div><span>Cliente</span><b>{{ $dCli }}</b></div>
                            <div><span>Items</span><b>{{ $dTotal }}</b></div>
                            <div><span>Orden interna</span><b>{{ $order->order_interna ?: '—' }}</b></div>
                            <div><span>Factura</span><b>{{ $order->factura_asociada ?? '—' }}</b></div>
                            <div><span>Guía</span><b>{{ $order->guia_asociada ?? '—' }}</b></div>
                        </div>
                    </div>
                    <div class="po-box" style="margin-bottom:0;">
                        <h4>Importes y estado de ítems</h4>
                        <div class="po-dl">
                            <div><span>Total</span><b class="po-num">S/ {{ number_format($order->total, 2) }}</b></div>
                            <div><span>🟢 Completos</span><b>{{ $dOk }}</b></div>
                            <div><span>🟡 Parciales</span><b>{{ $dPar }}</b></div>
                            <div><span>🔴 Pendientes</span><b>{{ max($dTotal - $dOk - $dPar, 0) }}</b></div>
                        </div>
                    </div>
                </div>

                {{-- Observaciones --}}
                <div class="po-pane" data-pane="obs">
                    <div class="po-box" style="margin-bottom:0;">
                        <h4>📝 Observaciones</h4>
                        <div class="po-obs">{{ $order->observaciones ?: 'Sin observaciones registradas.' }}</div>
                    </div>
                </div>

                {{-- Historial --}}
                <div class="po-pane" data-pane="hist">
                    @forelse($dEv as $ev)
                        <div class="po-ev">
                            <div class="po-ev-ic">{{ $ev['i'] }}</div>
                            <div><b>{{ $ev['t'] }}</b>@if($ev['d'] !== '')<span>{{ $ev['d'] }}</span>@endif</div>
                            <time>{{ $ev['f']->format('d/m/Y H:i') }}</time>
                        </div>
                    @empty
                        <div style="text-align:center;color:#94a3b8;padding:20px;">Sin movimientos registrados.</div>
                    @endforelse
                    <div style="font-size:11px;color:var(--po-muted);margin-top:6px;">Se arma con las fechas de registro de la orden y sus productos.</div>
                </div>
            </div>

            <div class="po-card" style="padding:4px 6px;">
                <div class="po-steps">
                    @foreach($dSteps as $k => $st)
                        <div class="po-step {{ $st[1] ? 'done' : '' }} {{ $k === $dCur ? 'cur' : '' }}">
                            <div class="dot">@if($st[1])<svg class="po-i"><use href="#po-check"/></svg>@endif</div>
                            <b>{{ $st[0] }}</b>
                            <small>{{ $st[1] ? $poFH($st[2]) : '' }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </aside>
</div>

{{-- ══════════ ACCIONES SOBRE LA ORDEN SELECCIONADA ══════════ --}}
<div class="po-actions">
    <button type="button" class="po-btn red" onclick="poEliminarSel()">🗑 Eliminar orden</button>
    <button type="button" class="po-btn white" onclick="poPicking()"><svg class="po-i"><use href="#po-printer"/></svg> Imprimir picking</button>
    <a href="#" id="poLnkEdit" class="po-btn white"><svg class="po-i"><use href="#po-edit"/></svg> Controlar</a>
    <a href="#" id="poLnkOp" class="po-btn green"><svg class="po-i"><use href="#po-truck"/></svg> Armado</a>
</div>

{{-- Formularios de eliminación (mismos action / method / confirmación del original) --}}
<div style="display:none;">
@foreach($orders as $order)
   <form method="POST" action="{{ route('orders.destroy',$order) }}" id="del-{{ $order->id }}"
       onsubmit="return confirm('¿Eliminar la orden {{ $order->numero_orden }}? Esta acción no se puede deshacer.')">
       @csrf
       @method('DELETE')
   </form>
@endforeach
</div>

</div>{{-- /.po --}}

{{-- Menú flotante por fila --}}
<div class="po-rmenu" id="poRMenu" onclick="event.stopPropagation()">
    <button type="button" onclick="poRowAct('ver')"><svg class="po-i"><use href="#po-list"/></svg> Ver detalle</button>
    <a href="#" id="poRmEdit"><svg class="po-i"><use href="#po-edit"/></svg> Controlar</a>
    <a href="#" id="poRmOp"><svg class="po-i"><use href="#po-truck"/></svg> 🚀 Armado</a>
    <button type="button" class="danger" onclick="poRowAct('del')">🗑 Eliminar orden</button>
</div>

</div>

tabla.innerHTML = productos.map(producto => {

    let estadoColor = '#15803d';
    let estadoBg = '#dcfce7';
    let icono = '✅';

    const pendiente = Number(producto.pendiente || 0);
    const stock = Number(producto.stock || 0);
    const faltante = Number(producto.faltante || 0);
    const cantidadPorCaja = Number(
        producto.cantidad_por_caja || 0
    );

    // Convertir unidades en cajas y unidades restantes.
    const formatoCajas = (cantidad) => {

        cantidad = Number(cantidad || 0);

        if (cantidadPorCaja <= 0) {
            return 'Sin configuración';
        }

        const cajas = Math.floor(
            cantidad / cantidadPorCaja
        );

        const unidadesRestantes =
            cantidad % cantidadPorCaja;

        if (unidadesRestantes > 0) {
            return `${cajas} cajas + ${unidadesRestantes} und.`;
        }

        return `${cajas} cajas`;
    };

    // Conversión decimal para comparar cantidades en cajas.
    const cajasDecimales = (cantidad) => {

        if (cantidadPorCaja <= 0) {
            return '—';
        }

        return (
            Number(cantidad || 0) / cantidadPorCaja
        ).toFixed(2) + ' cajas';
    };

    if (producto.estado === 'STOCK PARCIAL') {

        estadoColor = '#b45309';
        estadoBg = '#fef3c7';
        icono = '🟡';

    } else if (
        producto.estado === 'SOLICITAR PRODUCCIÓN'
    ) {

        estadoColor = '#b91c1c';
        estadoBg = '#fee2e2';
        icono = '🏭';
    }

    return `
        <tr style="border-bottom:1px solid #f1f5f9;">

            <td style="
                padding:12px 10px;
                font-family:monospace;
                font-weight:700;
            ">
                ${producto.codigo}
            </td>

            <td style="
                padding:12px 10px;
                font-weight:600;
                min-width:200px;
            ">
                ${producto.nombre}
            </td>

            <td style="
                padding:12px 10px;
                text-align:center;
            ">
                <div style="font-weight:700;">
                    ${pendiente.toLocaleString()} und.
                </div>

                <div style="
                    margin-top:4px;
                    font-size:10px;
                    color:#64748b;
                ">
                    📦 ${formatoCajas(pendiente)}
                </div>

                <div style="
                    margin-top:3px;
                    font-size:10px;
                    color:#94a3b8;
                ">
                    ${cajasDecimales(pendiente)}
                </div>
            </td>

            <td style="
                padding:12px 10px;
                text-align:center;
            ">
                <div style="font-weight:700;">
                    ${stock.toLocaleString()} und.
                </div>

                <div style="
                    margin-top:4px;
                    font-size:10px;
                    color:#64748b;
                ">
                    📦 ${formatoCajas(stock)}
                </div>

                <div style="
                    margin-top:3px;
                    font-size:10px;
                    color:#94a3b8;
                ">
                    ${cajasDecimales(stock)}
                </div>
            </td>

            <td style="
                padding:12px 10px;
                text-align:center;
            ">
                <div style="
                    font-weight:800;
                    color:${faltante > 0 ? '#dc2626' : '#15803d'};
                ">
                    ${faltante.toLocaleString()} und.
                </div>

                <div style="
                    margin-top:4px;
                    font-size:10px;
                    color:#64748b;
                ">
                    📦 ${formatoCajas(faltante)}
                </div>

                <div style="
                    margin-top:3px;
                    font-size:10px;
                    color:#94a3b8;
                ">
                    ${cajasDecimales(faltante)}
                </div>
            </td>

            <td style="
                padding:12px 10px;
                text-align:center;
            ">
                <span style="
                    display:inline-flex;
                    align-items:center;
                    gap:4px;
                    padding:6px 9px;
                    border-radius:999px;
                    background:${estadoBg};
                    color:${estadoColor};
                    font-size:10px;
                    font-weight:800;
                    white-space:nowrap;
                ">
                    ${icono} ${producto.estado}
                </span>
            </td>

        </tr>
    `;

}).join('');


    } catch (error) {

        console.error(error);

        tabla.innerHTML = `
            <tr>
                <td colspan="6"
                    style="
                        padding:30px;
                        text-align:center;
                        color:#dc2626;
                    ">
                    ❌ No se pudo cargar el stock.
                </td>
            </tr>
        `;
    }
}


document.getElementById('modalStockPedidos')
    ?.addEventListener('click', function(event) {

        if (event.target === this) {
            cerrarStockPedidos();
        }

    });

</script>

<script>
// ══════════════════════════════════════════════════════════
//  PEDIDOS · interacciones del rediseño (aditivo)
//  No toca el modal de stock de pedidos ni sus funciones.
// ══════════════════════════════════════════════════════════
var PO_SEL = null, PO_MROW = null;

function poEsc(s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[c]; }); }
function poRows() { return Array.prototype.slice.call(document.querySelectorAll('#poTabla tbody tr.po-row')); }
function poPanel(id) { return document.querySelector('.po-det[data-oid="' + id + '"]'); }

/* ── Selección de la orden (lista ↔ panel) ── */
function poSel(id, scroll) {
    PO_SEL = id;
    poRows().forEach(function (r) { r.classList.toggle('sel', r.dataset.oid == id); });
    var found = null;
    document.querySelectorAll('.po-det').forEach(function (p) {
        var on = p.dataset.oid == id;
        p.classList.toggle('on', on);
        if (on) found = p;
    });
    document.getElementById('poNoDet').style.display = found ? 'none' : '';
    var e = document.getElementById('poLnkEdit'), o = document.getElementById('poLnkOp');
    if (found) { e.href = found.dataset.edit; o.href = found.dataset.operario; }
    else { e.href = '#'; o.href = '#'; }
    if (scroll && found && window.innerWidth < 1180) found.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
document.querySelector('#poTabla tbody').addEventListener('click', function (e) {
    var tr = e.target.closest('tr.po-row');
    if (tr) poSel(tr.dataset.oid, false);
});

/* ── Pestañas del panel ── */
function poTab(btn, name) {
    var det = btn.closest('.po-det');
    det.querySelectorAll('.po-tab').forEach(function (b) { b.classList.toggle('on', b === btn); });
    det.querySelectorAll('.po-pane').forEach(function (p) { p.classList.toggle('on', p.dataset.pane === name); });
}

/* ── Búsqueda dentro de la página actual ── */
function poFiltrar() {
    var q = (document.getElementById('poBuscar').value || '').trim().toLowerCase();
    var vis = [];
    poRows().forEach(function (tr) {
        var ok = !q || (tr.dataset.search || '').indexOf(q) !== -1;
        tr.style.display = ok ? '' : 'none';
        if (ok) vis.push(tr);
    });
    document.getElementById('poVacio').style.display = (poRows().length && !vis.length) ? 'block' : 'none';
    var cur = document.querySelector('#poTabla tr.po-row.sel');
    if (!cur || cur.style.display === 'none') {
        if (vis[0]) poSel(vis[0].dataset.oid, false); else poSel(null, false);
    }
    poChkChange();
}

/* ── Menú flotante de fila ── */
function poRowMenu(btn, id, ev) {
    ev.stopPropagation();
    var m = document.getElementById('poRMenu');
    if (m.classList.contains('open') && PO_MROW === id) { poCerrarMenu(); return; }
    PO_MROW = id;
    var p = poPanel(id);
    document.getElementById('poRmEdit').href = p ? p.dataset.edit : '#';
    document.getElementById('poRmOp').href = p ? p.dataset.operario : '#';
    var r = btn.getBoundingClientRect();
    m.classList.add('open');
    var w = m.offsetWidth, h = m.offsetHeight;
    m.style.left = Math.max(8, Math.min(window.innerWidth - w - 8, r.right - w)) + 'px';
    m.style.top = (r.bottom + h + 8 > window.innerHeight ? r.top - h - 4 : r.bottom + 4) + 'px';
}
function poCerrarMenu() { document.getElementById('poRMenu').classList.remove('open'); }
function poRowAct(a) {
    var id = PO_MROW;
    poCerrarMenu();
    if (!id) return;
    if (a === 'ver') poSel(id, true);
    if (a === 'del') poDel(id);
}
document.addEventListener('click', poCerrarMenu);
window.addEventListener('scroll', poCerrarMenu, true);

/* ── Eliminar: usa el formulario original (mantiene su confirmación) ── */
function poDel(id) {
    var f = document.getElementById('del-' + id);
    if (!f) return;
    if (typeof f.requestSubmit === 'function') { f.requestSubmit(); }
    else if (!f.onsubmit || f.onsubmit() !== false) { f.submit(); }
}
function poEliminarSel() {
    if (!PO_SEL) { alert('Selecciona primero una orden.'); return; }
    poDel(PO_SEL);
}

/* ── Imprimir picking de la orden seleccionada ── */
function poPicking() {
    var p = PO_SEL ? poPanel(PO_SEL) : null;
    if (!p) { alert('Selecciona primero una orden.'); return; }
    var fila = poRows().filter(function (r) { return r.dataset.oid == PO_SEL; })[0];
    var w = window.open('', '_blank');
    if (!w) { alert('Permite las ventanas emergentes para imprimir.'); return; }
    var filas = '', i = 0;
    p.querySelectorAll('tr.po-prow').forEach(function (tr) {
        i++;
        filas += '<tr><td>' + i + '</td><td>' + poEsc(tr.dataset.sku) + '</td><td>' + poEsc(tr.dataset.nombre) +
                 '</td><td class="n">' + poEsc(tr.dataset.sol) + '</td><td class="n">' + poEsc(tr.dataset.des) +
                 '</td><td class="n">' + poEsc(tr.dataset.pen) + '</td><td class="chk"></td></tr>';
    });
    var css = 'body{font-family:Arial,Helvetica,sans-serif;margin:18px;color:#0f172a}h1{font-size:20px;margin:0 0 4px}' +
              '.s{font-size:13px;color:#475569;margin-bottom:14px}table{width:100%;border-collapse:collapse;font-size:12px}' +
              'th,td{border:1px solid #94a3b8;padding:6px 8px;text-align:left}th{background:#e2e8f0}.n{text-align:right;font-family:monospace}' +
              '.chk{width:50px}@page{size:A4;margin:10mm}';
    w.document.write('<!doctype html><html><head><meta charset="utf-8"><title>Picking ' + poEsc(p.dataset.numero) + '</title><style>' + css +
        '</style></head><body><h1>Picking · ' + poEsc(p.dataset.numero) + '</h1><div class="s">Cliente: ' + poEsc(fila ? fila.dataset.cliente : '') +
        ' · ' + new Date().toLocaleString('es-PE') + '</div><table><thead><tr><th>#</th><th>SKU</th><th>Producto</th>' +
        '<th>Pedido</th><th>Preparado</th><th>Pendiente</th><th>✓</th></tr></thead><tbody>' + filas + '</tbody></table></body></html>');
    w.document.close();
    w.focus();
    setTimeout(function () { w.print(); }, 350);
}

/* ── Selección múltiple + exportar CSV ── */
function poChkChange() {
    var checks = Array.prototype.slice.call(document.querySelectorAll('#poTabla .po-chk'));
    var n = checks.filter(function (c) { return c.checked; }).length;
    document.getElementById('poBulkN').textContent = n;
    document.getElementById('poBulk').classList.toggle('show', n > 0);
    var vis = checks.filter(function (c) { return c.closest('tr').style.display !== 'none'; });
    document.getElementById('poAll').checked = vis.length > 0 && vis.every(function (c) { return c.checked; });
}
function poToggleAll(cb) {
    poRows().forEach(function (tr) {
        if (tr.style.display !== 'none') tr.querySelector('.po-chk').checked = cb.checked;
    });
    poChkChange();
}
function poQuitarSel() {
    document.querySelectorAll('#poTabla .po-chk').forEach(function (c) { c.checked = false; });
    poChkChange();
}
function poExportSel() {
    var head = ['Pedido', 'Cliente', 'Fecha', 'Productos', 'Estado', 'Total'];
    var esc = function (v) { return '"' + String(v == null ? '' : v).replace(/"/g, '""') + '"'; };
    var rows = [];
    poRows().forEach(function (tr) {
        if (!tr.querySelector('.po-chk').checked) return;
        var d = tr.dataset;
        rows.push([d.numero, d.cliente, d.fecha, d.items, d.estado, d.total]);
    });
    var csv = [head].concat(rows).map(function (r) { return r.map(esc).join(','); }).join('\r\n');
    var blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'ordenes.csv';
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(function () { URL.revokeObjectURL(a.href); }, 1000);
}

/* ── Init: selecciona la primera orden de la página ── */
(function () {
    var first = poRows()[0];
    if (first) poSel(first.dataset.oid, false);
})();
</script>

@endsection
