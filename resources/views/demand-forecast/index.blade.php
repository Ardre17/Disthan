@extends('layouts.app')
@section('content')
@php
    /* ───────── Marca / pestaña (cambia $dfLogoUrl por el mismo logo/ícono que usan las otras vistas) ───────── */
    $dfLogoUrl = null; // ej.: asset('images/logo.png')
    $dfFavicon = $dfLogoUrl ?: 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="64" height="64" rx="14" fill="#172b4d"/><path d="M18 16h14c11 0 17 6 17 16s-6 16-17 16H18z" fill="none" stroke="#fff" stroke-width="6" stroke-linejoin="round"/></svg>');

    /* ───────── Iconos inline para KPIs ───────── */
    $dfPaths = [
        'box'    => '<path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5M12 13v8"/>',
        'alert'  => '<path d="M12 3l10 18H2L12 3z"/><path d="M12 10v5M12 18h.01"/>',
        'factory'=> '<path d="M3 21V9l6 4V9l6 4V5h6v16H3z"/>',
        'clock'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'users'  => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.5 3-6 6.5-6s6.5 2.5 6.5 6M17 11a3 3 0 100-6M21.5 20c0-2.5-1.5-4.5-4-5.3"/>',
        'cart'   => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l3 12h11l2-8H6"/>',
        'store'  => '<path d="M3 9l1.5-5h15L21 9M3 9v11h18V9M3 9c0 2 1.5 3 3 3s3-1 3-3c0 2 1.5 3 3 3s3-1 3-3c0 2 1.5 3 3 3s3-1 3-3"/>',
        'trend'  => '<path d="M3 17l6-6 4 4 8-8M15 7h6v6"/>',
        'check'  => '<path d="M5 13l4 4L19 7"/>',
        'layers' => '<path d="M12 3l9 5-9 5-9-5 9-5zM3 13l9 5 9-5"/>',
    ];
    $dfIco = fn($k) => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.($dfPaths[$k] ?? '').'</svg>';

    /* ───────── Barra de progreso (atención / cobertura) ───────── */
    $dfBar = function ($rate, $good = 90, $warn = 70) {
        $r = max(0, min(100, (float) $rate));
        $c = $r >= $good ? 'good' : ($r >= $warn ? 'warn' : 'bad');
        return '<div class="df-bar df-bar-'.$c.'"><span style="width:'.round($r, 1).'%"></span></div>';
    };

    $dfSection = request('section');
    $dfGroupLabels = [
        'all' => 'Todos los clientes',
        'recently_dispatched' => 'Despachados últimos 7 días',
        'due_soon' => 'Próximos a pedir / atrasados',
        'low_frequency' => 'Baja frecuencia (más de 30 días)',
        'inactive_90' => 'Sin pedidos por más de 90 días',
        'follow_up' => 'En seguimiento',
    ];
    $dfScopeLabel = $dfSection === 'clients' ? 'Clientes LOCAL / ENCOMIENDA' : ($dfSection === 'supermarkets' ? 'Supermercados' : 'Demanda y stock por producto');
@endphp

<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
.df-wrap{--df-navy:#172b4d;--df-blue:#2563eb;--df-teal:#0f9f91;--df-purple:#7c3aed;--df-orange:#d97706;--df-red:#dc2626;--df-muted:#718096;--df-border:#e5eaf1;--df-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;background:#f3f6fb;min-height:100vh;padding:24px;color:#172435;font-size:13px}
.df-wrap *{box-sizing:border-box}.df-hero{position:relative;overflow:hidden;background:linear-gradient(115deg,#172b4d 0%,#244d80 62%,#2563a6 100%);color:#fff;border-radius:18px;padding:24px 26px;margin-bottom:14px;display:flex;justify-content:space-between;align-items:center;gap:18px;box-shadow:0 12px 28px rgba(23,43,77,.13)}
.df-hero:before{content:"";position:absolute;right:-60px;top:-90px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,.06)}.df-hero:after{content:"";position:absolute;right:120px;bottom:-110px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.045)}.df-hero>*{position:relative;z-index:1}
.df-hero h1{font-size:24px;font-weight:800;letter-spacing:-.03em;margin:0 0 5px}.df-hero p{color:#dbeafe;margin:0;font-size:12px}.df-hero-meta{display:flex;gap:8px;align-items:center;flex-wrap:wrap;justify-content:flex-end}.df-hero-chip{border:1px solid rgba(255,255,255,.22);background:rgba(255,255,255,.12);padding:8px 11px;border-radius:10px;color:#eff6ff;font-size:11px;font-weight:650}
.df-crumb{display:flex;align-items:center;gap:6px;font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#93c5fd;margin-bottom:8px}.df-crumb i{font-style:normal;opacity:.5}
.df-hero .df-btn.df-ghost{background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.28);color:#fff}.df-hero .df-btn.df-ghost:hover{background:rgba(255,255,255,.24)}
.df-meta{display:flex;flex-wrap:wrap;gap:0;margin:0 0 16px;background:#fff;border:1px solid var(--df-border);border-radius:13px;box-shadow:0 3px 12px rgba(30,55,90,.035);overflow:hidden}.df-meta-item{flex:1 1 170px;padding:11px 16px;border-right:1px solid #edf1f6;min-width:0}.df-meta-item:last-child{border-right:0}.df-meta-item small{display:block;font-size:9px;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;font-weight:800;margin-bottom:3px}.df-meta-item b{display:block;font-size:12px;color:#172b4d;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.df-nav{display:flex;gap:7px;flex-wrap:wrap;margin:0 0 18px;padding:6px;background:#e8edf5;border-radius:13px;width:max-content;max-width:100%}.df-nav .df-btn{background:transparent!important;color:#53647b;border:0;padding:10px 15px;border-radius:9px;font-weight:700;transition:.18s}.df-nav .df-btn:hover{background:#fff!important;color:#172b4d}.df-nav .df-btn.df-active{background:#fff!important;color:#1d4ed8;box-shadow:0 2px 8px rgba(23,43,77,.09)}
.df-card{background:#fff;border:1px solid var(--df-border);border-radius:15px;padding:18px;margin-bottom:16px;box-shadow:0 3px 12px rgba(30,55,90,.035)}.df-section-head{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:14px}.df-section-title{font-size:16px;font-weight:800;color:#172b4d;margin:0}.df-section-sub{font-size:11px;color:#8290a3;margin:4px 0 0}.df-muted{color:#718096}.df-kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px;margin-bottom:16px}.df-kpi{position:relative;overflow:hidden;padding:17px 18px;min-height:112px;border-top:3px solid var(--kpi-color,#2563eb)}.df-kpi:after{content:"";position:absolute;right:-20px;top:-25px;width:88px;height:88px;border-radius:50%;background:var(--kpi-tint,#eff6ff)}.df-kpi-top{display:flex;align-items:center;justify-content:space-between;gap:8px;position:relative;z-index:1}.df-kpi small{font-size:11px;color:#718096;font-weight:650}.df-kpi strong{display:block;font-size:27px;line-height:1.2;color:#172b4d;margin-top:11px;font-weight:800;letter-spacing:-.03em;position:relative;z-index:1;font-family:var(--df-mono)}.df-kpi-icon{width:34px;height:34px;display:grid;place-items:center;border-radius:10px;background:var(--kpi-tint,#eff6ff);color:var(--kpi-color,#2563eb);font-size:17px;position:relative;z-index:1}.df-kpi-foot{font-size:10px;color:#94a3b8;margin-top:4px;position:relative;z-index:1}
.df-kpi.df-kpi-sm{min-height:96px;padding:14px 16px}.df-kpi.df-kpi-sm strong{font-size:23px;margin-top:8px}
.df-insights{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px;margin-bottom:16px}.df-insight{background:#fff;border:1px solid var(--df-border);border-left:4px solid var(--ins,#2563eb);border-radius:13px;padding:13px 15px;box-shadow:0 3px 12px rgba(30,55,90,.035)}.df-insight small{display:block;font-size:9px;text-transform:uppercase;letter-spacing:.08em;font-weight:800;color:var(--ins,#2563eb);margin-bottom:5px}.df-insight b{display:block;font-size:13px;color:#172b4d;line-height:1.4}.df-insight span{display:block;font-size:10px;color:#8290a3;margin-top:4px;line-height:1.5}
.df-chart-grid{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,1fr);gap:15px;margin-bottom:16px}.df-chart-grid.df-eq{grid-template-columns:repeat(2,minmax(0,1fr))}.df-chart-card{background:#fff;border:1px solid var(--df-border);border-radius:15px;padding:18px;min-width:0;box-shadow:0 3px 12px rgba(30,55,90,.035)}.df-chart-card h3{font-size:13px;color:#263b59;font-weight:800;margin:0}.df-chart-card p{font-size:10px;color:#94a3b8;margin:4px 0 12px}.df-chart-area{height:245px;position:relative}.df-chart-area.df-chart-small{height:220px}.df-chart-area canvas{width:100%!important;height:100%!important}
.df-filters{display:flex;gap:9px;flex-wrap:wrap;margin:0 0 14px}.df-input{border:1px solid #d9e1ec;border-radius:9px;padding:10px 12px;background:#fff;color:#334155;min-height:39px}.df-input:focus{outline:2px solid #bfdbfe;border-color:#60a5fa}.df-btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;background:#1d4ed8;color:#fff;border:0;border-radius:9px;padding:10px 14px;text-decoration:none;cursor:pointer;font-weight:700;font-size:12px}.df-btn:hover{color:#fff;background:#1e40af}.df-btn.df-secondary{background:#edf2f8;color:#475569}.df-btn.df-secondary:hover{background:#e2e8f0;color:#172b4d}
.df-chips{display:flex;flex-wrap:wrap;gap:7px;margin:0 0 14px}.df-chip-link{display:inline-flex;align-items:center;gap:7px;padding:7px 12px;border-radius:20px;background:#f1f5f9;border:1px solid #e2e8f0;color:#475569;font-size:11px;font-weight:700;text-decoration:none;transition:.15s}.df-chip-link:hover{background:#e8eef7;color:#172b4d}.df-chip-link em{font-style:normal;background:#fff;border-radius:10px;padding:1px 7px;font-size:10px;font-family:var(--df-mono);color:#64748b}.df-chip-link.df-chip-on{background:#172b4d;border-color:#172b4d;color:#fff}.df-chip-link.df-chip-on em{background:rgba(255,255,255,.18);color:#fff}
.df-table-wrap{overflow:auto;border:1px solid #edf1f6;border-radius:11px}table.df-table{width:100%;border-collapse:separate;border-spacing:0;min-width:1050px;background:#fff}table.df-table th{text-align:left;color:#64748b;font-size:10px;text-transform:uppercase;letter-spacing:.045em;background:#f7f9fc;font-weight:800;position:sticky;top:0;z-index:1} .df-table th,.df-table td{padding:12px 11px;border-bottom:1px solid #edf0f5;white-space:nowrap}.df-table tbody tr:hover{background:#f8fbff}.df-table tbody tr:last-child td{border-bottom:0}.df-num{font-variant-numeric:tabular-nums;font-weight:700;color:#263b59;font-family:var(--df-mono);font-size:12px}.df-alert{color:#b45309}.df-good{color:#15803d}.df-bad{color:#b91c1c}.df-pill{padding:6px 10px;border-radius:20px;background:#eaf2ff;color:#315b89;font-size:11px;font-weight:700}.df-status{display:inline-flex;align-items:center;gap:5px;padding:5px 9px;border-radius:20px;font-size:10px;font-weight:750;background:#eef2f7;color:#475569}.df-status-good{background:#dcfce7;color:#166534}.df-status-warn{background:#fef3c7;color:#92400e}.df-status-bad{background:#fee2e2;color:#991b1b}.df-table details summary{cursor:pointer;color:#1d4ed8;font-weight:700;padding:4px 0}.df-table details[open] summary{margin-bottom:10px}.df-table details .df-table-wrap{box-shadow:0 3px 12px rgba(30,55,90,.04)}.df-note{font-size:10px;line-height:1.65;color:#8190a4;margin:13px 2px 0}.df-empty{padding:24px;text-align:center;color:#94a3b8}
.df-table .df-row-bad td:first-child{box-shadow:inset 3px 0 0 #dc2626}.df-table .df-row-warn td:first-child{box-shadow:inset 3px 0 0 #d97706}
.df-bar{height:5px;border-radius:5px;background:#e8edf5;margin-top:6px;min-width:70px;overflow:hidden}.df-bar span{display:block;height:100%;border-radius:5px}.df-bar-good span{background:#16a34a}.df-bar-warn span{background:#f59e0b}.df-bar-bad span{background:#dc2626}
.df-toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin:0 0 12px}.df-count{font-size:11px;color:#64748b;background:#f1f5f9;border-radius:20px;padding:5px 11px;font-weight:700}.df-legend{display:flex;gap:12px;flex-wrap:wrap;font-size:10px;color:#64748b;font-weight:650}.df-legend i{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:5px}
.df-priority{display:flex;flex-direction:column;gap:11px}.df-prio-item{display:grid;grid-template-columns:26px minmax(0,1fr) auto;gap:11px;align-items:center;padding:10px 12px;border:1px solid #edf1f6;border-radius:11px;background:#fbfcfe}.df-prio-rank{width:26px;height:26px;border-radius:8px;background:#172b4d;color:#fff;display:grid;place-items:center;font-size:11px;font-weight:800;font-family:var(--df-mono)}.df-prio-name{font-weight:750;color:#172b4d;font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.df-prio-sub{font-size:10px;color:#8290a3;margin-top:2px}.df-prio-val{text-align:right;font-family:var(--df-mono);font-weight:800;color:#b45309;font-size:13px}.df-prio-val small{display:block;font-size:9px;color:#94a3b8;font-weight:600;font-family:inherit}
.df-method{margin-top:14px;border:1px dashed #d3dcea;border-radius:11px;background:#fafbfd;padding:2px 14px}.df-method summary{cursor:pointer;font-weight:750;font-size:11px;color:#475569;padding:10px 0}.df-method[open] summary{border-bottom:1px solid #edf1f6;margin-bottom:6px}
.df-loader{position:fixed;inset:0;z-index:99999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:20px;background:linear-gradient(135deg,#0f2342 0%,#172b4d 55%,#244d80 100%);transition:opacity .45s ease,visibility .45s ease}.df-loader.df-hide{opacity:0;visibility:hidden;pointer-events:none}
.df-loader-ring{position:relative;width:92px;height:92px;display:grid;place-items:center}.df-loader-ring:before{content:"";position:absolute;inset:0;border-radius:50%;border:3px solid rgba(255,255,255,.14);border-top-color:#60a5fa;animation:dfSpin 1s linear infinite}.df-loader-logo{width:58px;height:58px;border-radius:16px;background:#fff;display:grid;place-items:center;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,.25)}.df-loader-logo img{max-width:80%;max-height:80%;object-fit:contain}.df-loader-brand{color:#fff;font-size:22px;font-weight:800;letter-spacing:.28em;text-indent:.28em;text-align:center}.df-loader-brand small{display:block;font-size:10px;font-weight:600;letter-spacing:.2em;color:#93c5fd;margin-top:6px}.df-loader-msg{color:#bfdbfe;font-size:11px;font-weight:600;letter-spacing:.04em}.df-loader-bar{width:170px;height:3px;border-radius:3px;background:rgba(255,255,255,.14);overflow:hidden}.df-loader-bar span{display:block;width:40%;height:100%;border-radius:3px;background:#60a5fa;animation:dfSlide 1.2s ease-in-out infinite}
@keyframes dfSpin{to{transform:rotate(360deg)}}@keyframes dfSlide{0%{transform:translateX(-110%)}100%{transform:translateX(330%)}}
@media(prefers-reduced-motion:reduce){.df-loader-ring:before,.df-loader-bar span{animation-duration:3s}}
@media(max-width:1000px){.df-kpis,.df-insights{grid-template-columns:repeat(2,minmax(0,1fr))}.df-chart-grid,.df-chart-grid.df-eq{grid-template-columns:1fr}.df-hero-meta{justify-content:flex-start}}
@media(max-width:640px){.df-wrap{padding:12px}.df-hero{padding:18px;border-radius:14px;align-items:flex-start;flex-direction:column}.df-hero h1{font-size:20px}.df-nav{width:100%;display:grid;grid-template-columns:repeat(3,1fr)}.df-nav .df-btn{padding:9px 5px;font-size:10px}.df-kpis,.df-insights{gap:8px}.df-kpi{padding:13px;min-height:98px}.df-kpi strong{font-size:23px}.df-card,.df-chart-card{padding:13px;border-radius:12px}.df-chart-area{height:220px}.df-section-head{flex-direction:column}.df-meta-item{flex:1 1 45%;border-bottom:1px solid #edf1f6}}
@media print{.df-loader,.df-nav,.df-filters,.df-chips,.df-hero .df-btn,.df-method summary{display:none!important}.df-wrap{background:#fff;padding:0}.df-hero{box-shadow:none;-webkit-print-color-adjust:exact;print-color-adjust:exact}.df-card,.df-chart-card,.df-insight{box-shadow:none;break-inside:avoid}.df-method{display:block}}
</style>

{{-- ═══════════ Pantalla de carga (marca DISTAN) ═══════════ --}}
<div id="dfLoader" class="df-loader" role="status" aria-live="polite">
    <div class="df-loader-ring">
        <div class="df-loader-logo">
            @if($dfLogoUrl)
                <img src="{{ $dfLogoUrl }}" alt="DISTAN">
            @else
                <svg viewBox="0 0 64 64" width="34" height="34" aria-hidden="true"><path d="M18 16h14c11 0 17 6 17 16s-6 16-17 16H18z" fill="none" stroke="#172b4d" stroke-width="7" stroke-linejoin="round"/></svg>
            @endif
        </div>
    </div>
    <div class="df-loader-brand">DISTAN<small>ERP · Logistico</small></div>
    <div class="df-loader-bar"><span></span></div>
    <div class="df-loader-msg">Cargando proyección de demanda…</div>
</div>

<div class="df-wrap">
    <div class="df-hero">
        <div>
            <div class="df-crumb">Planificación <i>›</i> Proyección <i>›</i> {{ $dfScopeLabel }}</div>
            <h1>Planificación de Demanda y Stock</h1>
            <p>Panel de inteligencia operativa · Actualizado al {{ now()->format('d/m/Y') }}</p>
        </div>
        <div class="df-hero-meta">
            <span class="df-hero-chip">Historial: 180 días</span>
            <span class="df-hero-chip">Ponderación 60% / 40%</span>
            <button type="button" class="df-btn df-ghost" onclick="window.print()">Imprimir reporte</button>
        </div>
    </div>

    <div class="df-meta">
        <div class="df-meta-item"><small>Alcance</small><b>{{ $dfScopeLabel }}</b></div>
        <div class="df-meta-item"><small>Periodo de análisis</small><b>Últimos 180 días</b></div>
        <div class="df-meta-item"><small>Generado</small><b>{{ now()->format('d/m/Y H:i') }}</b></div>
        <div class="df-meta-item"><small>Filtros aplicados</small>
            <b>
                @if($dfSection === 'clients')
                    {{ $dfGroupLabels[$clientData['selected_group']] ?? 'Todos los clientes' }}
                @elseif($dfSection === 'supermarkets')
                    Todos los supermercados
                @else
                    @php $dfCatSel = request('category_id') ? $categories->firstWhere('id', request('category_id')) : null; @endphp
                    {{ request('q') ? '“'.request('q').'”' : 'Sin búsqueda' }} · {{ $dfCatSel ? $dfCatSel->nombre : 'Todas las categorías' }}
                @endif
            </b>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <nav class="df-nav">
        <a class="df-btn {{ !request('section') ? 'df-active' : '' }}" href="{{ route('demand-forecast.index') }}">Demanda y stock</a>
        <a class="df-btn {{ request('section') === 'supermarkets' ? 'df-active' : '' }}" href="{{ route('demand-forecast.index', ['section' => 'supermarkets']) }}">Supermercados</a>
        <a class="df-btn {{ request('section') === 'clients' ? 'df-active' : '' }}" href="{{ route('demand-forecast.index', ['section' => 'clients']) }}">Clientes</a>
    </nav>

    @if(request('section') === 'clients')
        @php
            $dfCl = $clientData['clients'];
            $dfClReq = (float) $dfCl->sum(fn($c) => (float) ($c['total_requested'] ?? 0));
            $dfClDis = (float) $dfCl->sum(fn($c) => (float) $c['total_dispatched']);
            $dfClRate = $dfClReq > 0 ? round($dfClDis / $dfClReq * 100, 1) : null;
            $dfClLate = $dfCl->filter(fn($c) => $c['next_order'] && $c['days_until_next'] !== null && $c['days_until_next'] < 0)->count();
            $dfClSoon = $dfCl->filter(fn($c) => $c['next_order'] && $c['days_until_next'] !== null && $c['days_until_next'] >= 0 && $c['days_until_next'] <= 3)->count();
            $dfClTop = $dfCl->sortByDesc('total_dispatched')->first();
            $dfGc = $clientData['summary']['group_counts'];
        @endphp

        <div class="df-kpis">
            <div class="df-card df-kpi" style="--kpi-color:#2563eb;--kpi-tint:#eff6ff"><div class="df-kpi-top"><small>Clientes LOCAL / ENCOMIENDA</small><span class="df-kpi-icon">{!! $dfIco('users') !!}</span></div><strong>{{ $clientData['summary']['clients'] }}</strong><div class="df-kpi-foot">Con planificación activa</div></div>
            <div class="df-card df-kpi" style="--kpi-color:#0f9f91;--kpi-tint:#e6f7f5"><div class="df-kpi-top"><small>Órdenes en últimos 180 días</small><span class="df-kpi-icon">{!! $dfIco('cart') !!}</span></div><strong>{{ $clientData['summary']['orders'] }}</strong><div class="df-kpi-foot">Historial analizado</div></div>
            <div class="df-card df-kpi" style="--kpi-color:#d97706;--kpi-tint:#fef3c7"><div class="df-kpi-top"><small>Órdenes todavía abiertas</small><span class="df-kpi-icon">{!! $dfIco('clock') !!}</span></div><strong>{{ $clientData['summary']['pending_orders'] }}</strong><div class="df-kpi-foot">Compromisos pendientes</div></div>
            <div class="df-card df-kpi" style="--kpi-color:#7c3aed;--kpi-tint:#f3ecff"><div class="df-kpi-top"><small>Unidades pendientes</small><span class="df-kpi-icon">{!! $dfIco('box') !!}</span></div><strong>{{ number_format($clientData['summary']['pending_units'], 0) }}</strong><div class="df-kpi-foot">Por despachar</div></div>
        </div>

        <div class="df-insights">
            <div class="df-insight" style="--ins:#2563eb"><small>Nivel de atención</small><b>{{ $dfClRate !== null ? number_format($dfClRate, 1).'% de lo solicitado fue despachado' : 'Sin datos de solicitud' }}</b><span>{{ number_format($dfClDis, 0) }} despachadas de {{ number_format($dfClReq, 0) }} solicitadas (grupo seleccionado).</span></div>
            <div class="df-insight" style="--ins:#dc2626"><small>Pedidos atrasados</small><b>{{ $dfClLate }} cliente(s) con fecha estimada vencida</b><span>{{ $dfClSoon }} más con pedido estimado en los próximos 3 días.</span></div>
            <div class="df-insight" style="--ins:#0f9f91"><small>Mayor volumen</small><b>{{ $dfClTop ? $dfClTop['client_name'] : 'Sin clientes' }}</b><span>{{ $dfClTop ? number_format($dfClTop['total_dispatched'], 0).' unidades despachadas en el periodo.' : 'No hay despachos en el grupo seleccionado.' }}</span></div>
            <div class="df-insight" style="--ins:#d97706"><small>Riesgo de fuga</small><b>{{ (int) $dfGc['inactive_90'] }} cliente(s) sin pedidos +90 días</b><span>{{ (int) $dfGc['low_frequency'] }} con baja frecuencia (más de 30 días).</span></div>
        </div>

        <div class="df-card">
            <h2 class="df-section-title">Predicción de pedidos por cliente</h2>
            <p class="df-muted">Incluye únicamente órdenes LOCAL y ENCOMIENDA. La siguiente orden se estima con el promedio de lo realmente despachado por producto; los faltantes no se acumulan. Los pedidos abiertos se muestran aparte.</p>
            <div class="df-kpis" style="margin:12px 0">
                <div class="df-card df-kpi df-kpi-sm" style="--kpi-color:#16a34a;--kpi-tint:#dcfce7"><div class="df-kpi-top"><small>Despachados últimos 7 días</small><span class="df-kpi-icon">{!! $dfIco('check') !!}</span></div><strong>{{ $clientData['summary']['group_counts']['recently_dispatched'] }}</strong></div>
                <div class="df-card df-kpi df-kpi-sm" style="--kpi-color:#d97706;--kpi-tint:#fef3c7"><div class="df-kpi-top"><small>Próximos a pedir</small><span class="df-kpi-icon">{!! $dfIco('clock') !!}</span></div><strong>{{ $clientData['summary']['group_counts']['due_soon'] }}</strong></div>
                <div class="df-card df-kpi df-kpi-sm" style="--kpi-color:#64748b;--kpi-tint:#eef2f7"><div class="df-kpi-top"><small>Baja frecuencia</small><span class="df-kpi-icon">{!! $dfIco('trend') !!}</span></div><strong>{{ $clientData['summary']['group_counts']['low_frequency'] }}</strong></div>
                <div class="df-card df-kpi df-kpi-sm" style="--kpi-color:#dc2626;--kpi-tint:#fee2e2"><div class="df-kpi-top"><small>Sin pedidos por más de 90 días</small><span class="df-kpi-icon">{!! $dfIco('alert') !!}</span></div><strong>{{ $clientData['summary']['group_counts']['inactive_90'] }}</strong></div>
            </div>
            <div class="df-chart-grid">
                <section class="df-chart-card">
                    <h3>Distribución de clientes por actividad</h3>
                    <p>Clasificación comercial según el comportamiento registrado.</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfClientGroupsChart"></canvas></div>
                </section>
                <section class="df-chart-card">
                    <h3>Clientes con mayor volumen despachado</h3>
                    <p>Principales clientes del grupo seleccionado.</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfClientVolumeChart"></canvas></div>
                </section>
            </div>
            <div class="df-chart-grid df-eq">
                <section class="df-chart-card">
                    <h3>Solicitado vs. despachado</h3>
                    <p>Brecha de atención en los 8 clientes con más volumen.</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfClientCompareChart"></canvas></div>
                </section>
                <section class="df-chart-card">
                    <h3>Calendario de próximos pedidos</h3>
                    <p>Días hasta la fecha estimada (valores negativos = atrasado).</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfClientNextChart"></canvas></div>
                </section>
            </div>

            <div class="df-chips">
                @foreach($dfGroupLabels as $dfGk => $dfGl)
                    @php $dfCnt = $dfGk === 'all' ? $clientData['summary']['clients'] : ($dfGc[$dfGk] ?? null); @endphp
                    <a class="df-chip-link {{ $clientData['selected_group'] === $dfGk ? 'df-chip-on' : '' }}" href="{{ route('demand-forecast.index', ['section' => 'clients', 'client_group' => $dfGk]) }}">{{ $dfGl }} @if($dfCnt !== null)<em>{{ $dfCnt }}</em>@endif</a>
                @endforeach
            </div>
            <form method="GET" class="df-filters">
                <input type="hidden" name="section" value="clients">
                <select class="df-input" name="client_group" onchange="this.form.submit()">
                    <option value="all" @selected($clientData['selected_group'] === 'all')>Todos los clientes</option>
                    <option value="recently_dispatched" @selected($clientData['selected_group'] === 'recently_dispatched')>Despachados últimos 7 días</option>
                    <option value="due_soon" @selected($clientData['selected_group'] === 'due_soon')>Próximos a pedir / atrasados</option>
                    <option value="low_frequency" @selected($clientData['selected_group'] === 'low_frequency')>Baja frecuencia (más de 30 días)</option>
                    <option value="inactive_90" @selected($clientData['selected_group'] === 'inactive_90')>Sin pedidos por más de 90 días</option>
                    <option value="follow_up" @selected($clientData['selected_group'] === 'follow_up')>En seguimiento</option>
                </select>
            </form>
            <div class="df-toolbar">
                <span class="df-count">{{ $dfCl->count() }} cliente(s) en el listado</span>
                <div class="df-legend"><span><i style="background:#dc2626"></i>Inactivo +90 días</span><span><i style="background:#d97706"></i>Próximo a pedir</span></div>
            </div>
            <div class="df-table-wrap">
                <table class="df-table">
                    <thead><tr><th>Cliente</th><th>Estado de planificación</th><th>Órdenes</th><th>Último pedido</th><th>Último despacho</th><th>Frecuencia habitual</th><th>Próximo pedido estimado</th><th>Total solicitado</th><th>Total despachado</th><th>Promedio despachado / orden</th><th>Órdenes abiertas</th><th>Unidades pendientes</th></tr></thead>
                    <tbody>
                    @forelse($clientData['clients'] as $client)
                        <tr class="{{ $client['planning_group'] === 'inactive_90' ? 'df-row-bad' : ($client['planning_group'] === 'due_soon' ? 'df-row-warn' : '') }}">
                            <td><strong>{{ $client['client_name'] }}</strong></td>
                            <td>
                                @if($client['planning_group'] === 'recently_dispatched')<span class="df-status df-status-good">Despachado reciente</span>
                                @elseif($client['planning_group'] === 'due_soon')<span class="df-status df-status-warn">Próximo a pedir</span>
                                @elseif($client['planning_group'] === 'low_frequency')<span class="df-status">Baja frecuencia</span>
                                @elseif($client['planning_group'] === 'inactive_90')<span class="df-status df-status-bad">Inactivo +90 días</span>
                                @else<span class="df-status">En seguimiento</span>@endif
                            </td>
                            <td>{{ $client['order_count'] }}</td>
                            <td>{{ $client['last_order'] ? $client['last_order']->format('d/m/Y') : 'Sin historial' }}</td>
                            <td>{{ $client['last_dispatch_date'] ? $client['last_dispatch_date']->format('d/m/Y') : 'Sin despacho' }}</td>
                            <td>{{ $client['average_interval'] !== null ? number_format($client['average_interval'], 1).' días' : 'Insuficiente historial' }}</td>
                            <td>
                                @if($client['next_order'])
                                    <strong>{{ $client['next_order']->format('d/m/Y') }}</strong>
                                    @if($client['days_until_next'] < 0)<br><small class="df-bad">Atrasado {{ abs($client['days_until_next']) }} días</small>
                                    @elseif($client['days_until_next'] <= 3)<br><small class="df-alert">Próximo en {{ $client['days_until_next'] }} días</small>@endif
                                @else<span class="df-muted">Por calcular</span>@endif
                            </td>
                            <td class="df-num">{{ number_format($client['total_requested'] ?? 0, 0) }}</td>
                            <td class="df-num">{{ number_format($client['total_dispatched'], 0) }}</td>
                            <td>{{ number_format($client['average_order_quantity'], 1) }}</td>
                            <td>{{ $client['pending_orders'] }}</td>
                            <td class="df-alert">{{ number_format($client['pending_units'], 0) }}</td>
                        </tr>
                        <tr><td colspan="12" style="padding:8px 12px 16px;background:#fafbfd">
                            <details>
                                <summary style="cursor:pointer;color:#1459a6;font-weight:650">Ver productos y proyección de {{ $client['client_name'] }}</summary>
                                <div class="df-table-wrap" style="margin-top:10px">
                                    <table class="df-table" style="min-width:1150px;background:white">
                                        <thead><tr><th>Producto</th><th>Órdenes con solicitud</th><th>Total solicitado</th><th>Total despachado</th><th>No atendido</th><th>Atención (%)</th><th>Promedio despachado por orden</th><th>Frecuencia</th><th>Última recepción</th><th>Ciclos acumulados</th><th>Siguiente orden estimada</th><th>Adicional descontando pendiente</th><th>Pendiente abierto</th></tr></thead>
                                        <tbody>
                                        @forelse($client['products'] as $item)
                                            <tr>
                                                <td><strong>{{ $item['name'] }}</strong><br><small class="df-muted">{{ $item['sku'] }}</small></td>
                                                <td>{{ $item['orders'] }}</td><td>{{ number_format($item['total_requested'], 1) }}</td>
                                                <td>{{ number_format($item['total_dispatched'], 1) }}</td><td>{{ number_format($item['total_unfulfilled'], 1) }}</td>
                                                <td>{{ number_format($item['fulfillment_rate'], 1) }}%{!! $dfBar($item['fulfillment_rate']) !!}</td><td>{{ number_format($item['average_quantity'], 1) }}</td>
                                                <td>{{ $item['frequency_days'] ? $item['frequency_days'].' días' : 'Sin patrón' }}</td>
                                                <td>{{ $item['last_order'] ? $item['last_order']->format('d/m/Y') : 'Sin recepción' }}</td>
                                                <td>{{ $item['elapsed_cycles'] }}</td>
                                                <td class="df-num">{{ number_format($item['expected_next_order'], 1) }} @if($item['expected_boxes'] !== null)<br><small class="df-muted">≈ {{ $item['expected_boxes'] }} cajas</small>@endif</td>
                                                <td class="df-good">{{ number_format($item['expected_additional'], 1) }}</td>
                                                <td class="df-alert">{{ number_format($item['pending'], 1) }}</td>
                                            </tr>
                                        @empty<tr><td colspan="13" class="df-muted">Sin historial de productos para este cliente.</td>@endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </details>
                        </td></tr>
                    @empty<tr><td colspan="12" class="df-muted">No hay clientes para este grupo o no hay órdenes LOCAL / ENCOMIENDA en el historial.</td></tr>@endforelse
                    </tbody>
                </table>
            </div>
            <details class="df-method">
                <summary>Metodología y supuestos del cálculo</summary>
                <p class="df-note" style="margin-top:6px">Para LOCAL y ENCOMIENDA, la siguiente orden por producto utiliza el promedio aritmético de lo despachado en las órdenes donde se solicitó ese producto, incluyendo como cero las órdenes donde no se logró despachar. Las cantidades no atendidas no se acumulan ni se agregan a la proyección. Los pedidos PARCIAL e INCOMPLETO se muestran como compromisos abiertos y se descuentan de la necesidad adicional. Los grupos se clasifican por último despacho, fecha estimada de compra, frecuencia histórica e inactividad superior a 90 días. La sección de supermercados mantiene su cálculo independiente.</p>
            </details>
        </div>
    @elseif(request('section') === 'supermarkets')
        @php
            $dfSm = $supermarketData['clients'];
            $dfSmDis = (float) $dfSm->sum(fn($c) => (float) $c['total_dispatched']);
            $dfSmOrders = (int) $dfSm->sum(fn($c) => (int) $c['order_count']);
            $dfSmAvg = $dfSmOrders > 0 ? $dfSmDis / $dfSmOrders : 0;
            $dfSmLate = $dfSm->filter(fn($c) => $c['next_order'] && $c['days_until_next'] !== null && $c['days_until_next'] < 0)->count();
            $dfSmWeek = $dfSm->filter(fn($c) => $c['next_order'] && $c['days_until_next'] !== null && $c['days_until_next'] >= 0 && $c['days_until_next'] <= 7)->count();
            $dfSmTop = $dfSm->sortByDesc('total_dispatched')->first();
            $dfSmPend = $dfSm->sortByDesc('pending_units')->first();
        @endphp

        <div class="df-kpis">
            <div class="df-card df-kpi" style="--kpi-color:#0f9f91;--kpi-tint:#e6f7f5"><div class="df-kpi-top"><small>Supermercados con actividad</small><span class="df-kpi-icon">{!! $dfIco('store') !!}</span></div><strong>{{ $supermarketData['summary']['clients'] }}</strong><div class="df-kpi-foot">Clientes SUPERMERCADO</div></div>
            <div class="df-card df-kpi" style="--kpi-color:#2563eb;--kpi-tint:#eff6ff"><div class="df-kpi-top"><small>Órdenes en últimos 180 días</small><span class="df-kpi-icon">{!! $dfIco('cart') !!}</span></div><strong>{{ $supermarketData['summary']['orders'] }}</strong><div class="df-kpi-foot">Historial analizado</div></div>
            <div class="df-card df-kpi" style="--kpi-color:#d97706;--kpi-tint:#fef3c7"><div class="df-kpi-top"><small>Órdenes todavía abiertas</small><span class="df-kpi-icon">{!! $dfIco('clock') !!}</span></div><strong>{{ $supermarketData['summary']['pending_orders'] }}</strong><div class="df-kpi-foot">Compromisos pendientes</div></div>
            <div class="df-card df-kpi" style="--kpi-color:#7c3aed;--kpi-tint:#f3ecff"><div class="df-kpi-top"><small>Unidades pendientes</small><span class="df-kpi-icon">{!! $dfIco('box') !!}</span></div><strong>{{ number_format($supermarketData['summary']['pending_units'], 0) }}</strong><div class="df-kpi-foot">Por despachar</div></div>
        </div>

        <div class="df-insights">
            <div class="df-insight" style="--ins:#0f9f91"><small>Mayor volumen</small><b>{{ $dfSmTop ? $dfSmTop['client_name'] : 'Sin datos' }}</b><span>{{ $dfSmTop ? number_format($dfSmTop['total_dispatched'], 0).' unidades despachadas en el periodo.' : 'No hay despachos en el periodo.' }}</span></div>
            <div class="df-insight" style="--ins:#2563eb"><small>Ritmo promedio</small><b>{{ number_format($dfSmAvg, 1) }} unidades por orden</b><span>{{ number_format($dfSmDis, 0) }} unidades despachadas en {{ $dfSmOrders }} órdenes.</span></div>
            <div class="df-insight" style="--ins:#dc2626"><small>Pedidos atrasados</small><b>{{ $dfSmLate }} supermercado(s) con fecha vencida</b><span>{{ $dfSmWeek }} con pedido estimado en los próximos 7 días.</span></div>
            <div class="df-insight" style="--ins:#d97706"><small>Mayor saldo abierto</small><b>{{ $dfSmPend && $dfSmPend['pending_units'] > 0 ? $dfSmPend['client_name'] : 'Sin saldos abiertos' }}</b><span>{{ $dfSmPend && $dfSmPend['pending_units'] > 0 ? number_format($dfSmPend['pending_units'], 0).' unidades pendientes de despacho.' : 'No hay unidades pendientes en órdenes PARCIAL / INCOMPLETO.' }}</span></div>
        </div>

        <div class="df-card">
            <h2 class="df-section-title">Planificación por supermercado</h2>
            <p class="df-muted">Frecuencia y cantidades calculadas con despachos reales de los últimos 180 días. Los compromisos abiertos se muestran por separado.</p>
            <div class="df-chart-grid">
                <section class="df-chart-card">
                    <h3>Volumen despachado por supermercado</h3>
                    <p>Comparación de los principales clientes por unidades entregadas.</p>
                    <div class="df-chart-area"><canvas id="dfSupermarketVolumeChart"></canvas></div>
                </section>
                <section class="df-chart-card">
                    <h3>Próximas órdenes estimadas</h3>
                    <p>Distribución de clientes por cercanía de su siguiente pedido.</p>
                    <div class="df-chart-area"><canvas id="dfSupermarketTimingChart"></canvas></div>
                </section>
            </div>
            <div class="df-chart-grid df-eq">
                <section class="df-chart-card">
                    <h3>Calendario de próximos pedidos</h3>
                    <p>Días hasta la fecha estimada (valores negativos = atrasado).</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfSupermarketNextChart"></canvas></div>
                </section>
                <section class="df-chart-card">
                    <h3>Unidades pendientes por supermercado</h3>
                    <p>Saldos abiertos de órdenes PARCIAL e INCOMPLETO.</p>
                    <div class="df-chart-area df-chart-small"><canvas id="dfSupermarketPendingChart"></canvas></div>
                </section>
            </div>
            <div class="df-toolbar">
                <span class="df-count">{{ $dfSm->count() }} supermercado(s) en el listado</span>
                <div class="df-legend"><span><i style="background:#16a34a"></i>Atención ≥ 90%</span><span><i style="background:#f59e0b"></i>70–89%</span><span><i style="background:#dc2626"></i>&lt; 70%</span></div>
            </div>
            <div class="df-table-wrap">
                <table class="df-table">
                    <thead><tr><th>Supermercado</th><th>Órdenes</th><th>Último pedido</th><th>Frecuencia media</th><th>Próximo pedido estimado</th><th>Unidades despachadas</th><th>Promedio por orden</th><th>Órdenes abiertas</th><th>Unidades pendientes</th></tr></thead>
                    <tbody>
                    @forelse($supermarketData['clients'] as $client)
                        <tr class="{{ $client['next_order'] && $client['days_until_next'] < 0 ? 'df-row-bad' : '' }}">
                            <td><strong>{{ $client['client_name'] }}</strong></td>
                            <td>{{ $client['order_count'] }}</td>
                            <td>{{ $client['last_order'] ? $client['last_order']->format('d/m/Y') : 'Sin historial' }}</td>
                            <td>{{ $client['average_interval'] !== null ? number_format($client['average_interval'], 1).' días' : 'Insuficiente historial' }}</td>
                            <td>
                                @if($client['next_order'])
                                    <strong>{{ $client['next_order']->format('d/m/Y') }}</strong>
                                    @if($client['days_until_next'] < 0)<br><small class="df-bad">Atrasado {{ abs($client['days_until_next']) }} días</small>
                                    @elseif($client['days_until_next'] <= 3)<br><small class="df-alert">Próximo en {{ $client['days_until_next'] }} días</small>@endif
                                @else
                                    <span class="df-muted">Por calcular</span>
                                @endif
                            </td>
                            <td class="df-num">{{ number_format($client['total_dispatched'], 0) }}</td>
                            <td>{{ number_format($client['average_order_quantity'], 1) }}</td>
                            <td>{{ $client['pending_orders'] }}</td>
                            <td class="df-alert">{{ number_format($client['pending_units'], 0) }}</td>
                        </tr>
                        <tr><td colspan="9" style="padding:8px 12px 16px;background:#fafbfd">
                            <details>
                                <summary style="cursor:pointer;color:#1459a6;font-weight:650">Ver productos y cantidades habituales de {{ $client['client_name'] }}</summary>
                                <div class="df-table-wrap" style="margin-top:10px">
                                    <table class="df-table" style="min-width:750px;background:white">
                                        <thead><tr><th>Producto</th><th>SKU</th><th>Órdenes con solicitud</th><th>Total solicitado</th><th>Total despachado</th><th>Atención (%)</th><th>Promedio solicitado por orden</th><th>Frecuencia</th><th>Última recepción estimada</th><th>Última recepción (unid.)</th><th>Último faltante solicitado</th><th>Ciclos acumulados</th><th>Siguiente orden estimada</th><th>Adicional descontando pendiente</th><th>Pendiente abierto</th></tr></thead>
                                        <tbody>
                                        @forelse($client['products'] as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td><td>{{ $item['sku'] }}</td><td>{{ $item['orders'] }}</td>
                                                <td>{{ number_format($item['total_requested'], 0) }}</td><td>{{ number_format($item['total_dispatched'], 0) }}</td>
                                                <td>{{ number_format($item['fulfillment_rate'], 1) }}%{!! $dfBar($item['fulfillment_rate']) !!}</td><td>{{ number_format($item['average_quantity'], 1) }}</td>
                                                <td>{{ $item['frequency_days'] ? $item['frequency_days'].' días' : 'Sin patrón' }}</td>
                                                <td>{{ $item['last_order'] ? $item['last_order']->format('d/m/Y') : 'Sin despacho' }}</td>
                                                <td>{{ number_format($item['last_received_quantity'], 1) }}</td>
                                                <td>{{ number_format($item['last_request_unfulfilled'], 1) }} unid.</td>
                                                <td>{{ $item['last_order'] ? $item['elapsed_cycles'] : '—' }}</td>
                                                <td class="df-num">{{ number_format($item['expected_next_order'], 1) }} @if($item['expected_boxes'] !== null)<br><small class="df-muted">≈ {{ $item['expected_boxes'] }} cajas</small>@endif</td>
                                                <td class="df-good">{{ number_format($item['expected_additional'], 1) }} @if($item['additional_boxes'] !== null)<br><small class="df-muted">≈ {{ $item['additional_boxes'] }} cajas</small>@endif</td>
                                                <td class="df-alert">{{ number_format($item['pending'], 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="15" class="df-muted">Este cliente todavía no tiene productos solicitados o despachados en el periodo.</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </details>
                        </td></tr>
                    @empty
                        <tr><td colspan="9" class="df-muted">No hay órdenes de tipo SUPERMERCADO en los últimos 180 días.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <details class="df-method">
                <summary>Metodología y supuestos del cálculo</summary>
                <p class="df-note" style="margin-top:6px">El promedio habitual se calcula con la mediana de las cantidades SOLICITADAS por orden, no solamente con lo despachado. Se muestran por separado lo solicitado, lo efectivamente despachado y el porcentaje de atención. Las diferencias de órdenes COMPLETO sirven como señal histórica de demanda no atendida, pero no se convierten en compromisos de despacho. La proyección acumula ciclos desde la última recepción estimada; si el producto nunca fue recibido, utiliza la primera solicitud como referencia. Una entrega extraordinaria puede moderar la estimación, pero nunca reducirla por debajo de un ciclo habitual. El faltante de la última solicitud se suma como señal de demanda potencial. “Adicional descontando pendiente” resta únicamente los saldos de órdenes PARCIAL e INCOMPLETO. Esta cifra es una estimación, no un pedido confirmado. La fecha de recepción se aproxima con la fecha de preparación del detalle y, si no existe, con la fecha de entrega o pedido. La equivalencia en cajas utiliza cantidad_por_caja del producto.</p>
            </details>
        </div>
    @else
        @php
            $dfCov = ['crit' => 0, 'warn' => 0, 'ok' => 0, 'high' => 0, 'none' => 0];
            foreach ($products as $dfP) {
                $dfC = $dfP->forecast['coverage_days'];
                if ($dfC === null) { $dfCov['none']++; }
                elseif ($dfC <= 7) { $dfCov['crit']++; }
                elseif ($dfC <= 15) { $dfCov['warn']++; }
                elseif ($dfC <= 30) { $dfCov['ok']++; }
                else { $dfCov['high']++; }
            }
            $dfDemand30 = (float) $products->sum(fn($p) => (float) $p->forecast['demand_30d']);
            $dfDaily = (float) $products->sum(fn($p) => (float) $p->forecast['daily_demand']);
            $dfProduceUnits = (float) $products->sum(fn($p) => (float) $p->forecast['to_produce']);
            $dfInProd = (float) $products->sum(fn($p) => (float) $p->forecast['in_production']);
            $dfPrio = $products->filter(fn($p) => (float) $p->forecast['to_produce'] > 0)->sortByDesc(fn($p) => (float) $p->forecast['to_produce'])->take(5)->values();
            $dfTotalP = max(1, (int) $summary['products']);
        @endphp

    <div class="df-kpis">
        <div class="df-card df-kpi" style="--kpi-color:#2563eb;--kpi-tint:#eff6ff"><div class="df-kpi-top"><small>Productos analizados</small><span class="df-kpi-icon">{!! $dfIco('layers') !!}</span></div><strong>{{ $summary['products'] }}</strong><div class="df-kpi-foot">Según el filtro actual</div></div>
        <div class="df-card df-kpi" style="--kpi-color:#dc2626;--kpi-tint:#fee2e2"><div class="df-kpi-top"><small>Cobertura crítica (≤ 7 días)</small><span class="df-kpi-icon">{!! $dfIco('alert') !!}</span></div><strong class="df-bad">{{ $summary['critical'] }}</strong><div class="df-kpi-foot">{{ number_format($summary['critical'] / $dfTotalP * 100, 1) }}% del catálogo analizado</div></div>
        <div class="df-card df-kpi" style="--kpi-color:#d97706;--kpi-tint:#fef3c7"><div class="df-kpi-top"><small>Productos por producir</small><span class="df-kpi-icon">{!! $dfIco('factory') !!}</span></div><strong class="df-alert">{{ $summary['to_produce'] }}</strong><div class="df-kpi-foot">{{ number_format($dfProduceUnits, 0) }} unidades a producir</div></div>
        <div class="df-card df-kpi" style="--kpi-color:#7c3aed;--kpi-tint:#f3ecff"><div class="df-kpi-top"><small>Unidades pendientes en órdenes</small><span class="df-kpi-icon">{!! $dfIco('clock') !!}</span></div><strong>{{ number_format($summary['pending'], 0) }}</strong><div class="df-kpi-foot">Órdenes PARCIAL / INCOMPLETO</div></div>
    </div>

    <div class="df-insights">
        <div class="df-insight" style="--ins:#dc2626"><small>Riesgo de quiebre</small><b>{{ $dfCov['crit'] }} producto(s) con cobertura ≤ 7 días</b><span>{{ $dfCov['warn'] }} más entre 8 y 15 días; {{ $dfCov['none'] }} sin demanda registrada.</span></div>
        <div class="df-insight" style="--ins:#d97706"><small>Prioridad de producción</small><b>{{ $dfPrio->isNotEmpty() ? $dfPrio->first()->nombre : 'Sin producción requerida' }}</b><span>{{ $dfPrio->isNotEmpty() ? number_format((float) $dfPrio->first()->forecast['to_produce'], 0).' unidades por producir (mayor necesidad).' : 'El stock disponible cubre el objetivo definido.' }}</span></div>
        <div class="df-insight" style="--ins:#2563eb"><small>Demanda proyectada</small><b>{{ number_format($dfDemand30, 0) }} unidades a 30 días</b><span>Ritmo diario combinado de {{ number_format($dfDaily, 1) }} unidades.</span></div>
        <div class="df-insight" style="--ins:#0f9f91"><small>Producción en proceso</small><b>{{ number_format($dfInProd, 0) }} unidades en curso</b><span>Se muestra por separado y no se suma al stock físico disponible.</span></div>
    </div>

    <div class="df-chart-grid">
        <section class="df-chart-card">
            <h3>Demanda proyectada por horizonte</h3>
            <p>Unidades estimadas a 7, 15 y 30 días para los productos del filtro actual.</p>
            <div class="df-chart-area"><canvas id="dfDemandHorizonChart"></canvas></div>
        </section>
        <section class="df-chart-card">
            <h3>Productos con mayor necesidad de producción</h3>
            <p>Comparación de stock disponible frente a demanda de 30 días.</p>
            <div class="df-chart-area"><canvas id="dfProductionNeedChart"></canvas></div>
        </section>
    </div>
    <div class="df-chart-grid df-eq">
        <section class="df-chart-card">
            <h3>Distribución de cobertura</h3>
            <p>Productos agrupados por días de cobertura de stock disponible.</p>
            <div class="df-chart-area df-chart-small"><canvas id="dfCoverageChart"></canvas></div>
        </section>
        <section class="df-chart-card">
            <h3>Prioridad de producción · Top 5</h3>
            <p>Productos con mayor cantidad a producir y su nivel de stock frente al objetivo.</p>
            <div class="df-priority">
                @forelse($dfPrio as $dfI => $dfPr)
                    @php
                        $dfTarget = (float) $dfPr->forecast['target_stock'];
                        $dfAvail = (float) $dfPr->forecast['available_stock'];
                        $dfPct = $dfTarget > 0 ? ($dfAvail / $dfTarget * 100) : 0;
                    @endphp
                    <div class="df-prio-item">
                        <div class="df-prio-rank">{{ $dfI + 1 }}</div>
                        <div style="min-width:0">
                            <div class="df-prio-name">{{ $dfPr->nombre }}</div>
                            <div class="df-prio-sub">{{ $dfPr->sku }} · Disponible {{ number_format($dfAvail, 0) }} de {{ number_format($dfTarget, 0) }}</div>
                            {!! $dfBar($dfPct, 80, 40) !!}
                        </div>
                        <div class="df-prio-val">{{ number_format((float) $dfPr->forecast['to_produce'], 0) }}<small>a producir</small></div>
                    </div>
                @empty
                    <div class="df-empty">No hay productos con necesidad de producción en el filtro actual.</div>
                @endforelse
            </div>
        </section>
    </div>

    <div class="df-card">
        <div class="df-section-head">
            <div><h2 class="df-section-title">Detalle de productos</h2><p class="df-section-sub">Consulta y configura los parámetros de cobertura de cada producto.</p></div>
        </div>
        <form method="GET" class="df-filters">
            <input class="df-input" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar producto o SKU">
            <select class="df-input" name="category_id"><option value="">Todas las categorías</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id')==$category->id)>{{ $category->nombre }}</option>@endforeach</select>
            <button class="df-btn">Filtrar</button>
            <a class="df-btn" style="background:#64748b" href="{{ route('demand-forecast.index') }}">Limpiar</a>
        </form>
        <div class="df-toolbar">
            <span class="df-count">{{ $products->count() }} producto(s) en el listado</span>
            <div class="df-legend"><span><i style="background:#dc2626"></i>Cobertura ≤ 7 días</span><span><i style="background:#f59e0b"></i>8–15 días / por producir</span><span><i style="background:#16a34a"></i>Óptima</span></div>
        </div>
        <div class="df-table-wrap">
            <table class="df-table">
                <thead><tr>
                    <th>Producto</th><th>Stock físico</th><th>Demanda diaria</th><th>7 días</th><th>15 días</th><th>30 días</th><th>Pendiente abierto</th><th>Disponible</th><th>En producción</th><th>Cobertura</th><th>Mín. recomendado</th><th>Stock objetivo</th><th>Producir</th><th>Parámetros</th>
                </tr></thead>
                <tbody>
                @forelse($products as $product)
                    @php
                        $dfCd = $product->forecast['coverage_days'];
                        $dfCdCls = $dfCd === null ? '' : ($dfCd <= 7 ? 'bad' : ($dfCd <= 15 ? 'warn' : 'good'));
                        $dfCdPct = $dfCd === null ? 0 : min(100, ($dfCd / 30) * 100);
                        $dfRow = ($dfCd !== null && $dfCd <= 7) ? 'df-row-bad' : (((float) $product->forecast['to_produce'] > 0) ? 'df-row-warn' : '');
                    @endphp
                    <tr class="{{ $dfRow }}">
                        <td><strong>{{ $product->nombre }}</strong><br><span class="df-muted">{{ $product->sku }}</span></td>
                        <td class="df-num">{{ number_format($product->stock,0) }}</td>
                        <td class="df-num">{{ number_format($product->forecast['daily_demand'],2) }}</td>
                        <td>{{ number_format($product->forecast['demand_7d'],0) }}</td>
                        <td>{{ number_format($product->forecast['demand_15d'],0) }}</td>
                        <td>{{ number_format($product->forecast['demand_30d'],0) }}</td>
                        <td class="df-alert">{{ number_format($product->forecast['pending'],0) }}</td>
                        <td class="df-num">{{ number_format($product->forecast['available_stock'],0) }}</td>
                        <td>{{ number_format($product->forecast['in_production'],0) }}</td>
                        <td class="{{ $product->forecast['coverage_days'] !== null && $product->forecast['coverage_days'] <= 7 ? 'df-bad' : '' }}">
                            {{ $product->forecast['coverage_days'] !== null ? $product->forecast['coverage_days'].' días' : 'Sin demanda' }}
                            @if($dfCd !== null)
                                <br><span class="df-status {{ $dfCdCls === 'bad' ? 'df-status-bad' : ($dfCdCls === 'warn' ? 'df-status-warn' : 'df-status-good') }}" style="margin-top:4px">{{ $dfCdCls === 'bad' ? 'Crítico' : ($dfCdCls === 'warn' ? 'Atención' : 'Óptimo') }}</span>
                                <div class="df-bar df-bar-{{ $dfCdCls }}"><span style="width:{{ round($dfCdPct, 1) }}%"></span></div>
                            @endif
                        </td>
                        <td>{{ number_format($product->forecast['minimum_to_use'],0) }}<br><small class="df-muted">Calculado: {{ number_format($product->forecast['recommended_minimum'],0) }} · Aprobado: {{ $product->forecast['approved_minimum'] !== null ? number_format($product->forecast['approved_minimum'],0) : 'Sin definir' }}</small></td>
                        <td class="df-num">{{ number_format($product->forecast['target_stock'],0) }}</td>
                        <td class="df-num {{ $product->forecast['to_produce'] > 0 ? 'df-alert' : 'df-good' }}">{{ number_format($product->forecast['to_produce'],0) }}</td>
                        <td>
                            <details><summary style="cursor:pointer;color:#1459a6">Configurar</summary>
                                <form method="POST" action="{{ route('demand-forecast.settings', $product) }}" style="padding:9px 0;min-width:190px">
                                    @csrf @method('PUT')
                                    <label>Días reposición <input class="df-input" type="number" min="0" name="lead_time_days" value="{{ $product->forecast['lead_time_days'] }}" required></label>
                                    <label>Días seguridad <input class="df-input" type="number" min="0" name="safety_days" value="{{ $product->forecast['safety_days'] }}" required></label>
                                    <label>Cobertura objetivo <input class="df-input" type="number" min="1" name="coverage_days" value="{{ $product->forecast['coverage_target_days'] }}" required></label>
                                    <label>Mínimo aprobado <input class="df-input" type="number" min="0" step="0.001" name="approved_min_stock" value="{{ $product->forecast['approved_minimum'] }}" placeholder="Opcional"></label>
                                    <button class="df-btn" style="margin-top:7px">Guardar</button>
                                </form>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="14" class="df-muted">No hay productos que coincidan con los filtros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <details class="df-method">
            <summary>Metodología y supuestos del cálculo</summary>
            <p class="df-note" style="margin-top:6px">La demanda histórica incluye órdenes no anuladas, incluso COMPLETO. Los compromisos pendientes solo incluyen órdenes PARCIAL e INCOMPLETO. La producción en proceso se muestra por separado y no se suma al stock físico disponible.</p>
        </details>
    </div>
    @endif
</div>

<script>
/* Título e ícono de la pestaña + pantalla de carga */
(function () {
    try {
        document.title = 'Proyección de Demanda · DISTAN ERP';
        var link = document.querySelector("link[rel~='icon']");
        if (!link) { link = document.createElement('link'); link.rel = 'icon'; document.head.appendChild(link); }
        link.href = @json($dfFavicon);
    } catch (e) {}
    var loader = document.getElementById('dfLoader');
    if (!loader) return;
    var started = Date.now();
    var hide = function () {
        var wait = Math.max(0, 500 - (Date.now() - started));
        setTimeout(function () { loader.classList.add('df-hide'); }, wait);
    };
    if (document.readyState === 'complete') { hide(); } else { window.addEventListener('load', hide); }
    setTimeout(hide, 5000);
    window.addEventListener('beforeunload', function () { loader.classList.remove('df-hide'); });
    window.addEventListener('pageshow', function (e) { if (e.persisted) { loader.classList.add('df-hide'); } });
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;
    Chart.defaults.font.family = "Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    Chart.defaults.color = '#718096';
    Chart.defaults.animation.duration = 700;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.boxWidth = 8;
    Chart.defaults.plugins.tooltip.backgroundColor = '#172b4d';
    Chart.defaults.plugins.tooltip.padding = 10;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    Chart.defaults.plugins.tooltip.callbacks.label = function (ctx) {
        var v = (ctx.parsed !== null && typeof ctx.parsed === 'object') ? (ctx.chart.options.indexAxis === 'y' ? ctx.parsed.x : ctx.parsed.y) : ctx.parsed;
        return (ctx.dataset.label || ctx.label) + ': ' + Number(v).toLocaleString('es-PE', {maximumFractionDigits: 1});
    };
    const palette = ['#2563eb','#0f9f91','#7c3aed','#d97706','#dc2626','#64748b'];
    const shortLabel = function (v) { const l = this.getLabelForValue(v); return l.length > 24 ? l.slice(0, 23) + '…' : l; };
    const baseOptions = {responsive:true, maintainAspectRatio:false, plugins:{legend:{position:'bottom'}}, scales:{x:{grid:{display:false},ticks:{font:{size:10}}},y:{beginAtZero:true,grid:{color:'#edf1f6'},ticks:{font:{size:10}}}}};
    const hOptions = {responsive:true, maintainAspectRatio:false, indexAxis:'y', plugins:{legend:{display:false}}, scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'},ticks:{font:{size:10}}},y:{grid:{display:false},ticks:{font:{size:10},callback:shortLabel}}}};
    const makeChart = (id, config) => {
        const el = document.getElementById(id);
        if (!el) return;
        const labels = config.data.labels || [];
        if (!labels.length) { el.parentNode.innerHTML = '<div class="df-empty">Sin datos para graficar en este filtro.</div>'; return; }
        new Chart(el, config);
    };
    const nextColor = d => d < 0 ? '#dc2626' : (d <= 3 ? '#d97706' : '#0f9f91');

    @if(request('section') === 'clients')
        const clientGroupLabels = ['Despachados últimos 7 días','Próximos a pedir','Baja frecuencia','Sin pedidos +90 días','En seguimiento'];
        const clientGroupValues = [
            {{ (int) $clientData['summary']['group_counts']['recently_dispatched'] }},
            {{ (int) $clientData['summary']['group_counts']['due_soon'] }},
            {{ (int) $clientData['summary']['group_counts']['low_frequency'] }},
            {{ (int) $clientData['summary']['group_counts']['inactive_90'] }},
            {{ (int) ($clientData['summary']['group_counts']['follow_up'] ?? 0) }}
        ];
        makeChart('dfClientGroupsChart',{type:'doughnut',data:{labels:clientGroupLabels,datasets:[{data:clientGroupValues,backgroundColor:palette,borderWidth:0,hoverOffset:5}]},options:{responsive:true,maintainAspectRatio:false,cutout:'66%',plugins:{legend:{position:'bottom'}}}});
        const clientTop = @json($clientData['clients']->sortByDesc('total_dispatched')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'qty'=>(float)$c['total_dispatched']])->all());
        makeChart('dfClientVolumeChart',{type:'bar',data:{labels:clientTop.map(x=>x.name),datasets:[{label:'Unidades despachadas',data:clientTop.map(x=>x.qty),backgroundColor:'#2563eb',borderRadius:6,maxBarThickness:24}]},options:{...baseOptions,indexAxis:'y',plugins:{legend:{display:false}} ,scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'}},y:{grid:{display:false},ticks:{callback:shortLabel}}}}});

        const clientCompare = @json($clientData['clients']->sortByDesc('total_dispatched')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'req'=>(float)($c['total_requested'] ?? 0),'dis'=>(float)$c['total_dispatched']])->all());
        makeChart('dfClientCompareChart',{type:'bar',data:{labels:clientCompare.map(x=>x.name),datasets:[{label:'Solicitado',data:clientCompare.map(x=>x.req),backgroundColor:'#f59e0b',borderRadius:5},{label:'Despachado',data:clientCompare.map(x=>x.dis),backgroundColor:'#0f9f91',borderRadius:5}]},options:{...hOptions,plugins:{legend:{position:'bottom'}}}});

        const clientNext = @json($clientData['clients']->filter(fn($c)=>$c['next_order'] && $c['days_until_next'] !== null)->sortBy('days_until_next')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'days'=>(int)$c['days_until_next']])->all());
        makeChart('dfClientNextChart',{type:'bar',data:{labels:clientNext.map(x=>x.name),datasets:[{label:'Días hasta el próximo pedido',data:clientNext.map(x=>x.days),backgroundColor:clientNext.map(x=>nextColor(x.days)),borderRadius:6,maxBarThickness:24}]},options:{...hOptions}});
    @elseif(request('section') === 'supermarkets')
        const supermarketTop = @json($supermarketData['clients']->sortByDesc('total_dispatched')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'qty'=>(float)$c['total_dispatched']])->all());
        makeChart('dfSupermarketVolumeChart',{type:'bar',data:{labels:supermarketTop.map(x=>x.name),datasets:[{label:'Unidades despachadas',data:supermarketTop.map(x=>x.qty),backgroundColor:'#0f9f91',borderRadius:6,maxBarThickness:25}]},options:{...baseOptions,indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'}},y:{grid:{display:false},ticks:{callback:shortLabel}}}}});
        const supermarketTiming = @json($supermarketData['clients']->map(function($c){$days=$c['days_until_next'];return ['name'=>$c['client_name'],'bucket'=>($days===null?'Sin fecha':($days<0?'Atrasado':($days<=7?'Próximos 7 días':'Más adelante')))];})->groupBy('bucket')->map->count()->all());
        makeChart('dfSupermarketTimingChart',{type:'doughnut',data:{labels:Object.keys(supermarketTiming),datasets:[{data:Object.values(supermarketTiming),backgroundColor:palette,borderWidth:0}]},options:{responsive:true,maintainAspectRatio:false,cutout:'62%',plugins:{legend:{position:'bottom'}}}});

        const supermarketNext = @json($supermarketData['clients']->filter(fn($c)=>$c['next_order'] && $c['days_until_next'] !== null)->sortBy('days_until_next')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'days'=>(int)$c['days_until_next']])->all());
        makeChart('dfSupermarketNextChart',{type:'bar',data:{labels:supermarketNext.map(x=>x.name),datasets:[{label:'Días hasta el próximo pedido',data:supermarketNext.map(x=>x.days),backgroundColor:supermarketNext.map(x=>nextColor(x.days)),borderRadius:6,maxBarThickness:24}]},options:{...hOptions}});
        const supermarketPending = @json($supermarketData['clients']->filter(fn($c)=>(float)$c['pending_units'] > 0)->sortByDesc('pending_units')->take(8)->values()->map(fn($c)=>['name'=>$c['client_name'],'qty'=>(float)$c['pending_units']])->all());
        makeChart('dfSupermarketPendingChart',{type:'bar',data:{labels:supermarketPending.map(x=>x.name),datasets:[{label:'Unidades pendientes',data:supermarketPending.map(x=>x.qty),backgroundColor:'#7c3aed',borderRadius:6,maxBarThickness:24}]},options:{...hOptions}});
    @else
        const horizon = {
            d7: {{ (float) $products->sum(fn($p)=>(float)$p->forecast['demand_7d']) }},
            d15: {{ (float) $products->sum(fn($p)=>(float)$p->forecast['demand_15d']) }},
            d30: {{ (float) $products->sum(fn($p)=>(float)$p->forecast['demand_30d']) }}
        };
        makeChart('dfDemandHorizonChart',{type:'bar',data:{labels:['7 días','15 días','30 días'],datasets:[{label:'Demanda proyectada (unidades)',data:[horizon.d7,horizon.d15,horizon.d30],backgroundColor:['#93c5fd','#3b82f6','#1d4ed8'],borderRadius:8,maxBarThickness:58}]},options:{...baseOptions,plugins:{legend:{display:false}}}});
        const productionTop = @json($products->sortByDesc(fn($p)=>(float)$p->forecast['to_produce'])->take(8)->values()->map(fn($p)=>['name'=>$p->nombre,'available'=>(float)$p->forecast['available_stock'],'demand'=>(float)$p->forecast['demand_30d']])->all());
        makeChart('dfProductionNeedChart',{type:'bar',data:{labels:productionTop.map(x=>x.name),datasets:[{label:'Disponible',data:productionTop.map(x=>x.available),backgroundColor:'#0f9f91',borderRadius:5},{label:'Demanda 30 días',data:productionTop.map(x=>x.demand),backgroundColor:'#f59e0b',borderRadius:5}]},options:{...baseOptions,indexAxis:'y',scales:{x:{beginAtZero:true,grid:{color:'#edf1f6'}},y:{grid:{display:false},ticks:{callback:shortLabel}}}}});
        const coverageBuckets = [
            {{ (int) $dfCov['crit'] }}, {{ (int) $dfCov['warn'] }}, {{ (int) $dfCov['ok'] }}, {{ (int) $dfCov['high'] }}, {{ (int) $dfCov['none'] }}
        ];
        makeChart('dfCoverageChart',{type:'doughnut',data:{labels:['Crítica (≤ 7 días)','Atención (8–15 días)','Óptima (16–30 días)','Alta (> 30 días)','Sin demanda'],datasets:[{data:coverageBuckets,backgroundColor:['#dc2626','#f59e0b','#16a34a','#2563eb','#94a3b8'],borderWidth:0,hoverOffset:5}]},options:{responsive:true,maintainAspectRatio:false,cutout:'64%',plugins:{legend:{position:'right'}}}});
    @endif
});
</script>

@endsection
