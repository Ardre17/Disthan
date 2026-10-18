@extends('layouts.app')

@section('content')

@php
    /* ─────────────────────────────────────────────────────────────
       LOGO / ICONO DE PESTAÑA / IMAGEN DE CARGA
       Si tienes tu logo como imagen, pon aquí su ruta, por ejemplo:
           $kxLogoUrl = asset('images/logo.png');
       Si lo dejas en null se usa el logo "D" incluido (SVG).
    ───────────────────────────────────────────────────────────── */
    $kxLogoUrl = null;

    $kxLogoSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">'
        . '<defs><linearGradient id="kxg" x1="0" y1="0" x2="1" y2="1">'
        . '<stop offset="0" stop-color="#2b8cff"/><stop offset="1" stop-color="#1243a8"/>'
        . '</linearGradient></defs>'
        . '<rect width="64" height="64" rx="15" fill="url(#kxg)"/>'
        . '<path fill="#fff" fill-rule="evenodd" d="M17 14h15.5a18 18 0 0 1 0 36H17zM27.5 23.2v17.6h5a8.8 8.8 0 0 0 0-17.6z"/>'
        . '</svg>';

    $kxFavicon = $kxLogoUrl ?: 'data:image/svg+xml,' . rawurlencode($kxLogoSvg);

    /* ─────────────────────────────────────────────────────────────
       CÁLCULOS PARA LAS TARJETAS (solo derivan de lo que ya envía el controlador)
    ───────────────────────────────────────────────────────────── */
    $pctDe = function ($valor) use ($totalSolicitado) {
        return $totalSolicitado > 0 ? round(($valor / $totalSolicitado) * 100) : 0;
    };

    $kxRing = function ($pct, $color) {
        $pct = max(0, min(100, (float) $pct));
        $c   = 2 * M_PI * 20;
        $off = $c * (1 - $pct / 100);

        return '<svg class="kx-ring" viewBox="0 0 48 48" aria-hidden="true">'
            . '<circle class="kx-ring-bg" cx="24" cy="24" r="20"/>'
            . '<circle class="kx-ring-fg" cx="24" cy="24" r="20" stroke="' . $color . '"'
            . ' stroke-dasharray="' . round($c, 2) . '" stroke-dashoffset="' . round($off, 2) . '"'
            . ' transform="rotate(-90 24 24)"/>'
            . '<text x="24" y="27.5" text-anchor="middle">' . round($pct) . '%</text>'
            . '</svg>';
    };

    // Ingreso directo / desmedro: si el controlador no envía el total del periodo,
    // se usa lo visible en la página actual (y se avisa en la tarjeta).
    $entradaTotal    = $totalEntrada ?? $totalEntradaDirecta ?? null;
    $entradaEsPagina = false;
    if ($entradaTotal === null) {
        $entradaTotal    = $movimientosPaginados->sum('cantidad_entrada');
        $entradaEsPagina = true;
    }

    $desmedroTotal    = $totalDesmedro ?? null;
    $desmedroEsPagina = false;
    if ($desmedroTotal === null) {
        $desmedroTotal    = $movimientosPaginados->sum('cantidad_desmedro');
        $desmedroEsPagina = true;
    }

    $valorSolicitado = $totalFacturado + $valorPendiente;

    $resumen = [
        ['Solicitado',      $totalSolicitado, 100,                           '#2563eb', 'i-doc'],
        ['Producción',      $totalProduccion, $pctDe($totalProduccion),      '#16a34a', 'i-factory'],
        ['Ingreso directo', $entradaTotal,    $pctDe($entradaTotal),         '#7c3aed', 'i-store'],
        ['Despachado',      $totalSalidas,    $pctDe($totalSalidas),         '#ef4444', 'i-truck'],
        ['Pendiente',       $totalPendiente,  $pctDe($totalPendiente),       '#f59e0b', 'i-clock'],
    ];
    if ($desmedroTotal > 0) {
        $resumen[] = ['Desmedro', $desmedroTotal, $pctDe($desmedroTotal), '#ea580c', 'i-alert'];
    }

    $tipoInfo = [
        'produccion' => ['PRODUCCIÓN',  '#15803d', '#dcfce7', '#22c55e'],
        'entrada'    => ['ING. DIRECTO','#6d28d9', '#ede9fe', '#8b5cf6'],
        'pendiente'  => ['PENDIENTE',   '#a16207', '#fef9c3', '#eab308'],
        'desmedro'   => ['DESMEDRO',    '#c2410c', '#ffedd5', '#f97316'],
        'salida'     => ['SALIDA',      '#b91c1c', '#fee2e2', '#ef4444'],
    ];
@endphp

{{-- ── Íconos (sprite SVG, no depende de librerías externas) ── --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="i-boxes" viewBox="0 0 24 24"><path d="M12 3 7 5.8v5.6l5 2.8 5-2.8V5.8z"/><path d="M7 5.8l5 2.8 5-2.8M12 8.6v5.6"/><path d="M2.5 13.5 7 16v4.5L2.5 18zM21.5 13.5 17 16v4.5l4.5-2.5z"/><path d="M7 16l5 2.8 5-2.8"/></symbol>
    <symbol id="i-doc" viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4M9 13h6M9 17h6"/></symbol>
    <symbol id="i-factory" viewBox="0 0 24 24"><path d="M3 21V9l6 4V9l6 4V5h6v16z"/><path d="M7 17h2M12 17h2M17 17h2"/></symbol>
    <symbol id="i-store" viewBox="0 0 24 24"><path d="M3 9l1.5-5h15L21 9"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M5 12v9h14v-9M10 21v-5h4v5"/></symbol>
    <symbol id="i-truck" viewBox="0 0 24 24"><path d="M2 6h11v10H2z"/><path d="M13 9h4l4 4v3h-8"/><circle cx="6.5" cy="17.5" r="2"/><circle cx="17.5" cy="17.5" r="2"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
    <symbol id="i-coin" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M14.5 9.2c-.6-.7-1.5-1.1-2.5-1.1-1.5 0-2.6.8-2.6 1.9 0 2.9 5.2 1.4 5.2 4.1 0 1.2-1.2 2-2.7 2-1.1 0-2.1-.5-2.7-1.3M12 6v2M12 16v2"/></symbol>
    <symbol id="i-trend" viewBox="0 0 24 24"><path d="M7 17 17 7M8 7h9v9"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></symbol>
    <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6"/></symbol>
    <symbol id="i-layers" viewBox="0 0 24 24"><path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/></symbol>
    <symbol id="i-cal" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></symbol>
    <symbol id="i-funnel" viewBox="0 0 24 24"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></symbol>
    <symbol id="i-reset" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></symbol>
    <symbol id="i-chev" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></symbol>
    <symbol id="i-chevl" viewBox="0 0 24 24"><path d="m15 6-6 6 6 6"/></symbol>
    <symbol id="i-chevr" viewBox="0 0 24 24"><path d="m9 6 6 6-6 6"/></symbol>
    <symbol id="i-eye" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="i-dots" viewBox="0 0 24 24"><circle cx="12" cy="5" r="1.3"/><circle cx="12" cy="12" r="1.3"/><circle cx="12" cy="19" r="1.3"/></symbol>
    <symbol id="i-copy" viewBox="0 0 24 24"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></symbol>
    <symbol id="i-chart" viewBox="0 0 24 24"><path d="M4 20V4M4 20h16M8 16v-5M12 16V8M16 16v-3"/></symbol>
    <symbol id="i-pie" viewBox="0 0 24 24"><path d="M21 12A9 9 0 1 1 12 3v9z"/><path d="M15 3.5A9 9 0 0 1 20.5 9H15z"/></symbol>
    <symbol id="i-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.2"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6 6 18"/></symbol>
    <symbol id="i-pdf" viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4M9 14h1.5a1.5 1.5 0 0 0 0-3H9v6M14 17v-6h1.5M14 14h1.2"/></symbol>
    <symbol id="i-clip" viewBox="0 0 24 24"><rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4h6v3H9zM9 12h6M9 16h6"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6"/><circle cx="17" cy="9" r="2.5"/><path d="M17 14c2.7 0 4.5 1.8 4.5 4.5"/></symbol>
    <symbol id="i-alert" viewBox="0 0 24 24"><path d="M12 3 2 20h20z"/><path d="M12 10v5M12 18h.01"/></symbol>
    <symbol id="i-refresh" viewBox="0 0 24 24"><path d="M20 12a8 8 0 1 1-2.5-5.8L20 8"/><path d="M20 3v5h-5"/></symbol>
</svg>

<style>

    /* =========================================================
       BASE
    ========================================================= */

    .kx-page {
        position: relative;
        background: linear-gradient(180deg, #f3f7fd 0%, #eef3fa 100%);
        min-height: 100vh;
        padding: 22px 24px 40px;
        color: #0f172a;
        font-size: 13px;
    }
    .kx-page *, .kx-page *::before, .kx-page *::after { box-sizing: border-box; }
    .kx-wrap { max-width: 1680px; margin: 0 auto; }

    .kx-ic {
        width: 18px; height: 18px; flex-shrink: 0;
        fill: none; stroke: currentColor; stroke-width: 1.8;
        stroke-linecap: round; stroke-linejoin: round;
    }
    .kx-ic-sm { width: 15px; height: 15px; }
    .kx-ic-lg { width: 24px; height: 24px; }

    .kx-card {
        background: #fff; border: 1px solid #e1e9f5; border-radius: 16px;
        box-shadow: 0 2px 12px rgba(15, 42, 77, .05);
    }
    .kx-hidden { display: none !important; }


    /* =========================================================
       PANTALLA DE CARGA (logo)
    ========================================================= */

    .kx-loader {
        position: fixed; inset: 0; z-index: 9998;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 18px;
        background: rgba(243, 247, 253, .94);
        -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px);
        opacity: 1; transition: opacity .35s ease, visibility .35s ease;
    }
    .kx-loader.is-hidden { opacity: 0; visibility: hidden; pointer-events: none; }
    .kx-loader-logo { position: relative; width: 84px; height: 84px; display: flex; align-items: center; justify-content: center; }
    .kx-loader-logo svg, .kx-loader-logo img {
        width: 64px; height: 64px; border-radius: 16px; object-fit: contain;
        animation: kxPulse 1.4s ease-in-out infinite;
        box-shadow: 0 8px 24px rgba(29, 78, 216, .3);
    }
    .kx-loader-ring {
        position: absolute; inset: 0; border-radius: 50%;
        border: 3px solid #d6e4fb; border-top-color: #2563eb;
        animation: kxSpin 1s linear infinite;
    }
    .kx-loader-text { font-size: 13px; font-weight: 700; color: #1e3a5f; letter-spacing: .3px; }
    .kx-loader-bar { width: 150px; height: 4px; border-radius: 99px; background: #dbe6f6; overflow: hidden; }
    .kx-loader-bar i { display: block; width: 40%; height: 100%; background: #2563eb; border-radius: 99px; animation: kxSlide 1.1s ease-in-out infinite; }
    @keyframes kxSpin { to { transform: rotate(360deg); } }
    @keyframes kxPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.07); } }
    @keyframes kxSlide { 0% { margin-left: -40%; } 100% { margin-left: 100%; } }


    /* =========================================================
       CABECERA
    ========================================================= */

    .kx-head {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px 24px; flex-wrap: wrap; margin-bottom: 18px;
    }
    .kx-title { display: flex; align-items: center; gap: 14px; min-width: 0; }
    .kx-title-ico { width: 56px; height: 56px; color: #1d6fe8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .kx-title-ico .kx-ic { width: 54px; height: 54px; stroke-width: 1.5; }
    .kx-title h1 { margin: 0; font-size: 28px; font-weight: 800; color: #0f2a4d; letter-spacing: -.5px; line-height: 1.1; }
    .kx-title p { margin: 4px 0 0; font-size: 14px; color: #475569; }

    .kx-head-right { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .kx-crumbs { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #64748b; margin-right: 6px; }
    .kx-crumbs a { color: #64748b; text-decoration: none; }
    .kx-crumbs a:hover { color: #2563eb; }
    .kx-crumbs .kx-ic { width: 12px; height: 12px; }
    .kx-date {
        display: flex; align-items: center; gap: 10px; padding: 8px 14px;
        background: #fff; border: 1px solid #dfe8f5; border-radius: 12px;
        box-shadow: 0 2px 10px rgba(15, 42, 77, .05);
    }
    .kx-date > .kx-ic { color: #2563eb; width: 20px; height: 20px; }
    .kx-date strong { display: block; font-size: 13px; color: #0f2a4d; line-height: 1.2; }
    .kx-date small { display: block; font-size: 11px; color: #64748b; }
    .kx-date a { color: #64748b; display: inline-flex; padding: 4px; border-radius: 6px; }
    .kx-date a:hover { color: #2563eb; background: #eef3fb; }
    .kx-btn-pdf {
        display: inline-flex; align-items: center; gap: 9px; height: 48px; padding: 0 22px;
        border: 0; border-radius: 12px; background: linear-gradient(135deg, #1d6fe8, #1243a8);
        color: #fff; font: inherit; font-size: 13.5px; font-weight: 700; cursor: pointer;
        box-shadow: 0 6px 16px rgba(29, 78, 216, .3); transition: transform .15s, box-shadow .15s;
    }
    .kx-btn-pdf:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(29, 78, 216, .38); }


    /* =========================================================
       FILTROS
    ========================================================= */

    .kx-filters { padding: 16px 18px; margin-bottom: 16px; }
    .kx-filter-bar { display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
    .kx-field { display: flex; flex-direction: column; gap: 6px; flex: 1 1 170px; min-width: 150px; }
    .kx-field.kx-grow { flex: 1.5 1 220px; }
    .kx-field > label { font-size: 12px; font-weight: 700; color: #1e293b; }
    .kx-control {
        position: relative; display: flex; align-items: center; gap: 9px; height: 42px; padding: 0 12px;
        border: 1px solid #d5e0ef; border-radius: 11px; background: #fff; color: #334155;
        transition: border-color .15s, box-shadow .15s;
    }
    .kx-control:focus-within, .kx-control.is-open { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, .12); }
    .kx-control > .kx-ic { color: #475569; }
    .kx-control input, .kx-control select {
        flex: 1; min-width: 0; height: 100%; border: 0; outline: 0; background: transparent;
        font: inherit; font-size: 13px; color: #0f172a; appearance: none; -webkit-appearance: none;
    }
    .kx-control select { cursor: pointer; padding-right: 20px; }
    .kx-control .kx-caret { position: absolute; right: 11px; width: 14px; height: 14px; color: #475569; pointer-events: none; }
    .kx-btn-filter {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 42px; padding: 0 26px; border: 0; border-radius: 11px; background: #1d6fe8; color: #fff;
        font: inherit; font-size: 13.5px; font-weight: 700; cursor: pointer; transition: background .15s;
    }
    .kx-btn-filter:hover { background: #1556c0; }
    .kx-btn-reset {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 42px; padding: 0 20px; border: 1px solid #d5e0ef; border-radius: 11px; background: #fff;
        color: #334155; font: inherit; font-size: 13.5px; font-weight: 600; text-decoration: none; cursor: pointer;
    }
    .kx-btn-reset:hover { background: #f5f8fd; }

    /* Buscador desplegable (reemplaza visualmente a los <select> de producto y cliente) */
    .kx-combo { position: relative; flex: 1; min-width: 0; height: 100%; }
    .kx-combo-btn {
        width: 100%; height: 100%; border: 0; background: transparent; padding: 0; margin: 0;
        display: flex; align-items: center; justify-content: space-between; gap: 8px;
        font: inherit; font-size: 13px; color: #0f172a; cursor: pointer; text-align: left;
    }
    .kx-combo-txt { flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .kx-combo-txt.is-placeholder { color: #64748b; }
    .kx-combo-panel {
        position: absolute; left: -35px; right: -12px; top: calc(100% + 12px); z-index: 60;
        background: #fff; border: 1px solid #dfe8f5; border-radius: 12px;
        box-shadow: 0 16px 36px rgba(15, 42, 77, .2); padding: 8px; min-width: 260px;
    }
    .kx-combo-search { display: flex; align-items: center; gap: 8px; padding: 0 10px; height: 36px; border: 1px solid #d5e0ef; border-radius: 9px; margin-bottom: 6px; }
    .kx-combo-search input { flex: 1; min-width: 0; border: 0; outline: 0; font: inherit; font-size: 12.5px; background: transparent; }
    .kx-combo-list { list-style: none; margin: 0; padding: 0; max-height: 240px; overflow-y: auto; }
    .kx-combo-list li { padding: 8px 10px; border-radius: 8px; font-size: 12.5px; color: #334155; cursor: pointer; }
    .kx-combo-list li:hover, .kx-combo-list li.is-focus { background: #eef4fd; color: #1d4ed8; }
    .kx-combo-list li.is-selected { font-weight: 700; color: #1d4ed8; }
    .kx-combo-empty { padding: 12px; text-align: center; font-size: 12px; color: #94a3b8; }


    /* =========================================================
       KPIs
    ========================================================= */

    .kx-kpis { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; margin-bottom: 12px; }
    .kx-kpi { border: 1px solid; border-radius: 16px; padding: 14px 16px 12px; display: flex; flex-direction: column; gap: 10px; transition: transform .15s; }
    .kx-kpi:hover { transform: translateY(-2px); }
    .kx-kpi-main { display: flex; align-items: center; gap: 12px; }
    .kx-kpi-ico {
        width: 54px; height: 54px; flex-shrink: 0; border-radius: 14px; color: #fff;
        display: flex; align-items: center; justify-content: center;
    }
    .kx-kpi-ico .kx-ic { width: 27px; height: 27px; }
    .kx-kpi-txt { flex: 1; min-width: 0; }
    .kx-kpi-label { display: block; font-size: 12.5px; font-weight: 600; color: #1e293b; }
    .kx-kpi-val { display: block; font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .kx-kpi-unit { font-size: 12.5px; color: #334155; }
    .kx-kpi-side { display: flex; flex-direction: column; align-items: center; gap: 2px; text-align: center; flex-shrink: 0; }
    .kx-kpi-side small { font-size: 10.5px; color: #64748b; max-width: 72px; line-height: 1.15; }
    .kx-kpi-side .kx-trend { width: 22px; height: 22px; }
    .kx-kpi-side b { font-size: 12px; color: #334155; }
    .kx-ring { width: 54px; height: 54px; }
    .kx-ring-bg { fill: none; stroke: #e6ecf5; stroke-width: 5; }
    .kx-ring-fg { fill: none; stroke-width: 5; stroke-linecap: round; transition: stroke-dashoffset .6s; }
    .kx-ring text { font-size: 10.5px; font-weight: 800; fill: #334155; }
    .kx-kpi-foot { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #334155; }
    .kx-kpi-foot .kx-ic { width: 20px; height: 20px; }
    .kx-kpi-foot small { font-size: 11px; font-weight: 500; color: #64748b; }

    .kx-kpi.k-blue   { background: linear-gradient(180deg, #f1f7ff, #eaf3ff); border-color: #bcd7fb; }
    .kx-kpi.k-green  { background: linear-gradient(180deg, #f2fbf5, #ebf8ef); border-color: #bfe6cb; }
    .kx-kpi.k-purple { background: linear-gradient(180deg, #f8f4ff, #f3edff); border-color: #d7c8f7; }
    .kx-kpi.k-red    { background: linear-gradient(180deg, #fff5f5, #ffeded); border-color: #f6c4c4; }
    .kx-kpi.k-orange { background: linear-gradient(180deg, #fffaf0, #fff4e0); border-color: #f4d9a8; }
    .k-blue .kx-kpi-ico   { background: linear-gradient(135deg, #3b8cff, #1d58d6); }
    .k-green .kx-kpi-ico  { background: linear-gradient(135deg, #2fb865, #17803f); }
    .k-purple .kx-kpi-ico { background: linear-gradient(135deg, #9b6bf2, #6a35d1); }
    .k-red .kx-kpi-ico    { background: linear-gradient(135deg, #f26565, #d42d2d); }
    .k-orange .kx-kpi-ico { background: linear-gradient(135deg, #f8b43b, #e68a00); }
    .k-blue .kx-kpi-foot .kx-ic   { color: #2563eb; }
    .k-green .kx-kpi-foot .kx-ic  { color: #16a34a; }
    .k-purple .kx-kpi-foot .kx-ic { color: #7c3aed; }
    .k-red .kx-kpi-foot .kx-ic    { color: #ef4444; }
    .k-orange .kx-kpi-foot .kx-ic { color: #f59e0b; }

    .kx-strip { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)) 2fr; gap: 12px; margin-bottom: 16px; }
    .kx-chip { padding: 11px 14px; background: #fff; border: 1px solid #e1e9f5; border-radius: 13px; }
    .kx-chip span { display: block; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
    .kx-chip strong { display: block; margin-top: 3px; font-size: 18px; font-weight: 800; color: #0f2a4d; }
    .kx-chip small { display: block; margin-top: 1px; font-size: 10.5px; color: #94a3b8; }
    .kx-chip.kx-note { background: #fffafa; border-color: #f6d4d4; }
    .kx-chip.kx-note strong { color: #cf1322; }


    /* =========================================================
       GRÁFICO + RESUMEN
    ========================================================= */

    .kx-row { display: grid; grid-template-columns: minmax(0, 2.1fr) minmax(0, 1fr); gap: 14px; margin-bottom: 16px; align-items: stretch; }
    .kx-panel { padding: 16px 18px; }
    .kx-panel-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 8px; }
    .kx-panel-title { display: flex; align-items: center; gap: 9px; font-size: 16px; font-weight: 800; color: #0f2a4d; }
    .kx-panel-title .kx-ic { color: #2563eb; width: 20px; height: 20px; }
    .kx-panel-sub { margin: 2px 0 0 29px; font-size: 11.5px; color: #64748b; }
    .kx-vista { min-width: 190px; }
    .kx-vista .kx-control { height: 38px; }

    .kx-minis { display: flex; flex-wrap: wrap; gap: 6px 8px; margin: 4px 0 10px; }
    .kx-mini { font-size: 11px; color: #475569; background: #f3f7fd; border: 1px solid #e3ebf7; border-radius: 99px; padding: 3px 10px; white-space: nowrap; }
    .kx-mini b { color: #0f2a4d; }

    .kx-chart-box { position: relative; height: 300px; }
    .kx-chart-empty { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .kx-chart-empty .kx-ic { width: 42px; height: 42px; color: #bfd0ea; margin-bottom: 8px; stroke-width: 1.4; }
    .kx-chart-empty strong { display: block; color: #475569; font-size: 14px; margin-bottom: 3px; }

    .kx-resumen-list { display: flex; flex-direction: column; gap: 4px; margin-top: 6px; }
    .kx-rs { display: grid; grid-template-columns: 26px minmax(0, 1fr) auto; align-items: center; gap: 4px 10px; padding: 7px 0; }
    .kx-rs > .kx-ic { width: 22px; height: 22px; }
    .kx-rs-name { font-size: 13px; color: #1e293b; }
    .kx-rs-val { font-size: 13px; font-weight: 800; color: #0f172a; text-align: right; }
    .kx-rs-bar { grid-column: 3; display: flex; align-items: center; gap: 8px; }
    .kx-rs-track { width: 130px; height: 7px; border-radius: 99px; background: #e6ecf5; overflow: hidden; }
    .kx-rs-track i { display: block; height: 100%; border-radius: 99px; }
    .kx-rs-pct { font-size: 10.5px; color: #64748b; width: 30px; }
    .kx-rs-row { display: contents; }
    .kx-cumpl {
        margin-top: 12px; display: flex; align-items: center; gap: 12px; padding: 12px 14px;
        background: linear-gradient(135deg, #eafaf0, #e2f6ea); border: 1px solid #c3e8d0; border-radius: 13px;
    }
    .kx-cumpl > .kx-ic { width: 28px; height: 28px; color: #16a34a; }
    .kx-cumpl div { flex: 1; }
    .kx-cumpl strong { display: block; font-size: 13.5px; color: #0f2a4d; }
    .kx-cumpl small { font-size: 11.5px; color: #475569; }
    .kx-cumpl .kx-ring { width: 56px; height: 56px; }
    .kx-cumpl-na { font-size: 13px; font-weight: 800; color: #64748b; }


    /* =========================================================
       TABLA
    ========================================================= */

    .kx-table-card { overflow: hidden; margin-bottom: 16px; }
    .kx-table-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; padding: 14px 18px; border-bottom: 1px solid #edf1f8; }
    .kx-pager-mini { display: flex; align-items: center; gap: 10px; font-size: 12px; color: #64748b; }
    .kx-pg-btn {
        width: 32px; height: 32px; border: 1px solid #d5e0ef; border-radius: 9px; background: #fff; color: #334155;
        display: inline-flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer;
    }
    .kx-pg-btn:hover { background: #f1f6fd; border-color: #93b4ee; }
    .kx-pg-btn.is-off { opacity: .4; pointer-events: none; }
    .kx-tscroll { overflow-x: auto; }
    .kx-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
    .kx-table thead th {
        background: #fff; color: #1e293b; font-weight: 800; font-size: 12px; padding: 12px 12px;
        text-align: left; border-bottom: 1px solid #e3ebf7; white-space: nowrap;
    }
    .kx-table tbody tr { border-bottom: 1px solid #eff3f9; transition: background .1s; }
    .kx-table tbody tr:hover { background: #f6f9fe; }
    .kx-table tbody td { padding: 10px 12px; color: #0f172a; vertical-align: middle; }
    .kx-table .r { text-align: right; }
    .kx-table .c { text-align: center; }
    .kx-n { color: #94a3b8; font-size: 12px; }
    .kx-date-cell { white-space: nowrap; color: #475569; font-size: 12px; }
    .kx-tipo {
        display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px;
        font-size: 10.5px; font-weight: 800; letter-spacing: .02em; white-space: nowrap;
    }
    .kx-tipo i { width: 7px; height: 7px; border-radius: 50%; }
    .kx-orden { font-weight: 700; color: #1d6fe8; }
    .kx-ellip { max-width: 170px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .kx-prod-name { font-weight: 700; }
    .kx-q { font-weight: 800; }
    .kx-dash { color: #94a3b8; font-weight: 700; }
    .kx-sub { font-weight: 800; }
    .kx-acts { display: inline-flex; align-items: center; gap: 4px; }
    .kx-ibtn {
        width: 30px; height: 30px; border: 0; border-radius: 8px; background: transparent; color: #1d4ed8; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .kx-ibtn:hover { background: #eaf1fd; }
    .kx-ibtn.dots { color: #475569; }
    .kx-table tfoot td { padding: 11px 12px; font-weight: 800; background: #f1f6fd; color: #1d4ed8; border-top: 2px solid #c9dcf7; }
    .kx-empty-row td { text-align: center; padding: 48px 10px !important; color: #94a3b8; }
    .kx-empty-row .kx-ic { width: 36px; height: 36px; color: #bfd0ea; margin-bottom: 6px; stroke-width: 1.4; }
    .kx-filter-note { padding: 8px 18px; font-size: 11.5px; color: #1d4ed8; background: #eef4fd; border-bottom: 1px solid #dfe9f8; }

    .kx-table-foot { padding: 12px 18px; border-top: 1px solid #edf1f8; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .kx-table-foot p { margin: 0; font-size: 12px; color: #64748b; }
    .kx-pages { display: flex; gap: 4px; align-items: center; }
    .kx-page-b {
        padding: 6px 12px; border: 1px solid #d5e0ef; border-radius: 8px; font-size: 12px; color: #475569;
        text-decoration: none; background: #fff;
    }
    a.kx-page-b:hover { border-color: #93b4ee; color: #1d4ed8; }
    .kx-page-b.on { background: #1d6fe8; border-color: #1d6fe8; color: #fff; font-weight: 700; }
    .kx-page-b.off { color: #cbd5e1; cursor: default; }


    /* =========================================================
       STOCK + TOP CLIENTES
    ========================================================= */

    .kx-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
    .kx-card-head { padding: 14px 18px; border-bottom: 1px solid #edf1f8; }
    .kx-card-head p { margin: 0; }
    .kx-card-head .t { font-size: 15px; font-weight: 800; color: #0f2a4d; display: flex; align-items: center; gap: 8px; }
    .kx-card-head .t .kx-ic { color: #2563eb; }
    .kx-card-head .s { font-size: 11.5px; color: #64748b; margin-top: 2px; }
    .kx-list-body { padding: 8px 18px 12px; max-height: 340px; overflow-y: auto; }
    .kx-inv-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f1f5fa; gap: 10px; }
    .kx-inv-row:last-child { border-bottom: none; }
    .kx-inv-bar { height: 6px; border-radius: 3px; background: #e6ecf5; margin-top: 5px; }
    .kx-inv-fill { height: 6px; border-radius: 3px; }


    /* =========================================================
       MODAL + MENÚ DE FILA
    ========================================================= */

    .kx-modal {
        position: fixed; inset: 0; z-index: 9990; display: none; align-items: center; justify-content: center;
        padding: 20px; background: rgba(15, 23, 42, .5);
    }
    .kx-modal.show { display: flex; }
    .kx-dialog { width: min(560px, 100%); background: #fff; border-radius: 18px; box-shadow: 0 25px 70px rgba(15, 23, 42, .3); overflow: hidden; }
    .kx-dialog-head { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid #edf1f8; }
    .kx-dialog-head strong { font-size: 16px; color: #0f2a4d; }
    .kx-dialog-body { padding: 18px 20px 20px; }
    .kx-dl { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .kx-dl div { background: #f6f9fe; border: 1px solid #e6edf8; border-radius: 11px; padding: 9px 12px; min-width: 0; }
    .kx-dl div.full { grid-column: 1 / -1; }
    .kx-dl dt { font-size: 10.5px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .04em; margin: 0; }
    .kx-dl dd { margin: 3px 0 0; font-size: 14px; font-weight: 700; color: #0f172a; word-break: break-word; }

    .kx-menu {
        position: fixed; z-index: 9995; display: none; min-width: 220px;
        background: #fff; border: 1px solid #dfe8f5; border-radius: 12px; padding: 5px;
        box-shadow: 0 14px 34px rgba(15, 42, 77, .22);
    }
    .kx-menu.show { display: block; }
    .kx-menu button {
        width: 100%; display: flex; align-items: center; gap: 9px; padding: 9px 10px; border: 0; border-radius: 8px;
        background: transparent; color: #334155; font: inherit; font-size: 12.5px; font-weight: 600; text-align: left; cursor: pointer;
    }
    .kx-menu button:hover { background: #eef4fd; color: #1d4ed8; }
    .kx-menu .kx-ic { color: #2563eb; }

    .kx-toast {
        position: fixed; left: 50%; bottom: 28px; transform: translateX(-50%) translateY(20px); z-index: 9999;
        background: #0f2a4d; color: #fff; padding: 10px 18px; border-radius: 11px; font-size: 12.5px; font-weight: 600;
        opacity: 0; pointer-events: none; transition: opacity .25s, transform .25s;
    }
    .kx-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1500px) {
        .kx-kpis { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 1279px) {
        .kx-row { grid-template-columns: 1fr; }
        .kx-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .kx-strip .kx-note { grid-column: 1 / -1; }
    }
    @media (max-width: 900px) {
        .kx-kpis { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .kx-two { grid-template-columns: 1fr; }
        .kx-title h1 { font-size: 23px; }
        .kx-combo-panel { left: -12px; right: -12px; }
    }
    @media (max-width: 600px) {
        .kx-page { padding: 14px 12px 30px; }
        .kx-kpis { grid-template-columns: 1fr; }
        .kx-field, .kx-field.kx-grow { flex: 1 1 100%; }
        .kx-btn-filter, .kx-btn-reset { flex: 1; }
        .kx-title-ico { display: none; }
        .kx-dl { grid-template-columns: 1fr; }
        .kx-rs-track { width: 90px; }
    }

    /* =========================================================
       IMPRESIÓN / PDF
    ========================================================= */

    @page { size: A4 landscape; margin: 10mm; }
    @media print {
        .kx-loader, .kx-noprint, .kx-modal, .kx-menu, .kx-toast { display: none !important; }
        .kx-page { background: #fff; padding: 0; min-height: 0; }
        .kx-card, .kx-kpi, .kx-chip { box-shadow: none !important; }
        .kx-page, .kx-page * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .kx-kpis { grid-template-columns: repeat(5, minmax(0, 1fr)); }
        .kx-row { grid-template-columns: 2fr 1fr; }
        .kx-two { grid-template-columns: 1fr 1fr; }
        .kx-table tbody tr { break-inside: avoid; }
        .kx-tscroll { overflow: visible; }
        .kx-list-body { max-height: none; overflow: visible; }
        .kx-chart-box { height: 260px; }
    }

</style>

<noscript><style>.kx-loader { display: none !important; }</style></noscript>

{{-- ═══════════ PANTALLA DE CARGA ═══════════ --}}
<div class="kx-loader" id="kxLoader" role="status" aria-live="polite">
    <div class="kx-loader-logo">
        <span class="kx-loader-ring"></span>
        @if($kxLogoUrl)
            <img src="{{ $kxLogoUrl }}" alt="Logo">
        @else
            {!! $kxLogoSvg !!}
        @endif
    </div>
    <div class="kx-loader-text">Cargando Kardex…</div>
    <div class="kx-loader-bar"><i></i></div>
</div>

<div class="kx-page" id="kxPage">
<div class="kx-wrap">

{{-- ═══════════ HEADER ═══════════ --}}
<div class="kx-head">

    <div class="kx-title">
        <div class="kx-title-ico"><svg class="kx-ic"><use href="#i-boxes"/></svg></div>
        <div>
            <h1>Kardex de Inventario</h1>
            <p>Control de movimientos, producción, ingresos directos y despachos</p>
        </div>
    </div>

    <div class="kx-head-right">

        <div class="kx-crumbs">
            <a href="/dashboard">Inicio</a>
            <svg class="kx-ic"><use href="#i-chevr"/></svg>
            <span>Inventario</span>
            <svg class="kx-ic"><use href="#i-chevr"/></svg>
            <strong style="color:#0f2a4d;">Kardex</strong>
        </div>

        <div class="kx-date">
            <svg class="kx-ic"><use href="#i-cal"/></svg>
            <div>
                <strong>{{ now()->locale('es')->translatedFormat('j \d\e F \d\e Y') }}</strong>
                <small>Última actualización: {{ now()->format('H:i') }} h</small>
            </div>
            <a href="{{ route('kardex.index') }}" class="kx-noprint kx-nav" title="Actualizar"><svg class="kx-ic kx-ic-sm"><use href="#i-refresh"/></svg></a>
        </div>

        <button type="button" class="kx-btn-pdf kx-noprint" id="kxBtnPdf" title="Imprime o guarda como PDF el reporte con los filtros aplicados">
            <svg class="kx-ic"><use href="#i-pdf"/></svg>
            Generar PDF
        </button>

    </div>
</div>


{{-- ═══════════ FILTROS ═══════════ --}}
<div class="kx-card kx-filters kx-noprint">
    <form method="GET" action="{{ route('kardex.index') }}" id="kxFilterForm">
        <div class="kx-filter-bar">

            <div class="kx-field kx-grow">
                <label>Producto</label>
                <div class="kx-control">
                    <svg class="kx-ic"><use href="#i-search"/></svg>
                    <select name="product_id" data-kx-combo data-placeholder="Buscar producto...">
                        <option value="">Todos los productos</option>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id }}" {{ $productId == $prod->id ? 'selected' : '' }}>
                                {{ $prod->nombre }} @if($prod->sku) · {{ $prod->sku }} @endif
                            </option>
                        @endforeach
                    </select>
                    <svg class="kx-ic kx-caret"><use href="#i-chev"/></svg>
                </div>
            </div>

            <div class="kx-field">
                <label>Cliente</label>
                <div class="kx-control">
                    <svg class="kx-ic"><use href="#i-user"/></svg>
                    <select name="client_id" data-kx-combo data-placeholder="Todos los clientes">
                        <option value="">Todos los clientes</option>
                        @foreach($clientes as $cli)
                            <option value="{{ $cli->id }}" {{ $clientId == $cli->id ? 'selected' : '' }}>
                                {{ $cli->razon_social }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="kx-ic kx-caret"><use href="#i-chev"/></svg>
                </div>
            </div>

            <div class="kx-field">
                <label>Desde</label>
                <div class="kx-control">
                    <svg class="kx-ic"><use href="#i-cal"/></svg>
                    <input type="date" name="date_from" value="{{ $dateFrom }}">
                </div>
            </div>

            <div class="kx-field">
                <label>Hasta</label>
                <div class="kx-control">
                    <svg class="kx-ic"><use href="#i-cal"/></svg>
                    <input type="date" name="date_to" value="{{ $dateTo }}">
                </div>
            </div>

            <div class="kx-field">
                <label>Tipo de movimiento <span style="font-weight:500;color:#94a3b8;">(esta página)</span></label>
                <div class="kx-control">
                    <svg class="kx-ic"><use href="#i-layers"/></svg>
                    <select id="kxTipo">
                        <option value="">Todos</option>
                        <option value="salida">Salida</option>
                        <option value="produccion">Producción</option>
                        <option value="entrada">Ingreso directo</option>
                        <option value="pendiente">Pedido pendiente</option>
                        <option value="desmedro">Desmedro</option>
                    </select>
                    <svg class="kx-ic kx-caret"><use href="#i-chev"/></svg>
                </div>
            </div>

            <button type="submit" class="kx-btn-filter">
                <svg class="kx-ic"><use href="#i-funnel"/></svg> Filtrar
            </button>
            <a href="{{ route('kardex.index') }}" class="kx-btn-reset kx-nav">
                <svg class="kx-ic"><use href="#i-reset"/></svg> Limpiar
            </a>

        </div>
    </form>
</div>


{{-- ═══════════ KPIs ═══════════ --}}
<div class="kx-kpis">

    {{-- Solicitado --}}
    <div class="kx-kpi k-blue">
        <div class="kx-kpi-main">
            <div class="kx-kpi-ico"><svg class="kx-ic"><use href="#i-doc"/></svg></div>
            <div class="kx-kpi-txt">
                <span class="kx-kpi-label">Solicitado</span>
                <strong class="kx-kpi-val">{{ number_format($totalSolicitado) }}</strong>
                <span class="kx-kpi-unit">unidades</span>
            </div>
            <div class="kx-kpi-side">
                <svg class="kx-ic kx-trend" style="color:#2563eb;"><use href="#i-trend"/></svg>
                <b>100%</b>
                <small>Total de pedidos</small>
            </div>
        </div>
        <div class="kx-kpi-foot" title="Facturado + valor pendiente de despacho">
            <svg class="kx-ic"><use href="#i-coin"/></svg> S/ {{ number_format($valorSolicitado, 2) }}
        </div>
    </div>

    {{-- Producción --}}
    <div class="kx-kpi k-green">
        <div class="kx-kpi-main">
            <div class="kx-kpi-ico"><svg class="kx-ic"><use href="#i-factory"/></svg></div>
            <div class="kx-kpi-txt">
                <span class="kx-kpi-label">Producción</span>
                <strong class="kx-kpi-val">{{ number_format($totalProduccion) }}</strong>
                <span class="kx-kpi-unit">unidades</span>
            </div>
            <div class="kx-kpi-side">
                {!! $kxRing($pctDe($totalProduccion), '#16a34a') !!}
                <small>vs. solicitado</small>
            </div>
        </div>
        <div class="kx-kpi-foot"><small>Unidades fabricadas en el periodo</small></div>
    </div>

    {{-- Ingreso directo a tienda --}}
    <div class="kx-kpi k-purple">
        <div class="kx-kpi-main">
            <div class="kx-kpi-ico"><svg class="kx-ic"><use href="#i-store"/></svg></div>
            <div class="kx-kpi-txt">
                <span class="kx-kpi-label">Ingreso directo a tienda</span>
                <strong class="kx-kpi-val">{{ number_format($entradaTotal) }}</strong>
                <span class="kx-kpi-unit">unidades</span>
            </div>
            <div class="kx-kpi-side">
                {!! $kxRing($pctDe($entradaTotal), '#7c3aed') !!}
                <small>vs. solicitado</small>
            </div>
        </div>
        <div class="kx-kpi-foot"><small>{{ $entradaEsPagina ? 'Suma de la página actual' : 'Entradas directas del periodo' }}</small></div>
    </div>

    {{-- Despachado --}}
    <div class="kx-kpi k-red">
        <div class="kx-kpi-main">
            <div class="kx-kpi-ico"><svg class="kx-ic"><use href="#i-truck"/></svg></div>
            <div class="kx-kpi-txt">
                <span class="kx-kpi-label">Despachado</span>
                <strong class="kx-kpi-val">{{ number_format($totalSalidas) }}</strong>
                <span class="kx-kpi-unit">unidades</span>
            </div>
            <div class="kx-kpi-side">
                {!! $kxRing($cumplimiento ?? $pctDe($totalSalidas), '#ef4444') !!}
                <small>Cumplimiento</small>
            </div>
        </div>
        <div class="kx-kpi-foot" title="Total facturado">
            <svg class="kx-ic"><use href="#i-coin"/></svg> S/ {{ number_format($totalFacturado, 2) }}
        </div>
    </div>

    {{-- Pendiente de despacho --}}
    <div class="kx-kpi k-orange">
        <div class="kx-kpi-main">
            <div class="kx-kpi-ico"><svg class="kx-ic"><use href="#i-clock"/></svg></div>
            <div class="kx-kpi-txt">
                <span class="kx-kpi-label">Pendiente de despacho</span>
                <strong class="kx-kpi-val">{{ number_format($totalPendiente) }}</strong>
                <span class="kx-kpi-unit">unidades</span>
            </div>
            <div class="kx-kpi-side">
                {!! $kxRing($pctDe($totalPendiente), '#f59e0b') !!}
                <small>Por despachar</small>
            </div>
        </div>
        <div class="kx-kpi-foot" title="Valor estimado pendiente de despacho">
            <svg class="kx-ic"><use href="#i-coin"/></svg> S/ {{ number_format($valorPendiente, 2) }}
        </div>
    </div>

</div>

{{-- Datos complementarios (los KPIs de siempre) --}}
<div class="kx-strip">
    <div class="kx-chip">
        <span>Movimientos</span>
        <strong>{{ number_format($totalMovimientos) }}</strong>
    </div>
    <div class="kx-chip">
        <span>Productos movidos</span>
        <strong style="color:#6d28d9;">{{ $productosMovidos }}</strong>
    </div>
    <div class="kx-chip">
        <span>Total facturado</span>
        <strong style="color:#15803d;">S/ {{ number_format($totalFacturado, 2) }}</strong>
    </div>
    <div class="kx-chip">
        <span>Cumplimiento</span>
        <strong style="color:#0e7490;">{{ $cumplimiento === null ? 'Sin datos' : number_format($cumplimiento, 1) . '%' }}</strong>
    </div>
    <div class="kx-chip kx-note">
        <span>Valor estimado pendiente de despacho</span>
        <strong>S/ {{ number_format($valorPendiente, 2) }}</strong>
        <small>Estimado según el precio unitario registrado en cada pedido; no equivale necesariamente a una pérdida contable.</small>
    </div>
</div>


{{-- ═══════════ GRÁFICO + RESUMEN DEL PERIODO ═══════════ --}}
<div class="kx-row">

    {{-- ── GRÁFICO DE TENDENCIAS — solo visible al filtrar ── --}}
    <div class="kx-card kx-panel">

        @if(!is_null($chartData))
        @php
            $chartTitle = $chartData['producto']
                ? 'Tendencia de despachos · ' . $chartData['producto']
                : ($chartData['cliente'] ? 'Tendencia de despachos · ' . $chartData['cliente'] : 'Tendencia');
            $totalProduccionGrafico = collect($chartData['produccion'])->sum();
            $totalSalidasGrafico    = collect($chartData['salidas'])->sum();
            $totalFact              = collect($chartData['subtotal'])->sum();
            $totalSolicitadoGrafico = collect($chartData['solicitado'])->sum();
            $totalPendienteGrafico  = collect($chartData['pendiente'])->sum();
            $totalValorPendienteGrafico = collect($chartData['valor_pendiente'])->sum();
            $cumplimientoGrafico = $totalSolicitadoGrafico > 0 ? round((($totalSolicitadoGrafico - $totalPendienteGrafico) / $totalSolicitadoGrafico) * 100, 1) : null;
            $totalOrd               = collect($chartData['ordenes'])->sum();

            $eficiencia = $totalProduccionGrafico > 0
                ? round(($totalSalidasGrafico / $totalProduccionGrafico) * 100, 1)
                : 0;
        @endphp

        <div class="kx-panel-head">
            <div>
                <div class="kx-panel-title"><svg class="kx-ic"><use href="#i-chart"/></svg> Movimientos diarios</div>
                <p class="kx-panel-sub">{{ $chartTitle }} · cantidad de unidades por tipo de movimiento</p>
            </div>
            <div class="kx-vista kx-noprint">
                <div class="kx-control">
                    <svg class="kx-ic"><use href="#i-chart"/></svg>
                    <select id="kxChartVista" aria-label="Tipo de vista del gráfico">
                        <option value="line">Vista diaria (líneas)</option>
                        <option value="bar">Vista diaria (barras)</option>
                        <option value="acum">Vista acumulada</option>
                    </select>
                    <svg class="kx-ic kx-caret"><use href="#i-chev"/></svg>
                </div>
            </div>
        </div>

        <div class="kx-minis">
            <span class="kx-mini">Producción <b style="color:#389e0d;">{{ number_format($totalProduccionGrafico) }} u.</b></span>
            <span class="kx-mini">Salidas <b style="color:#cf1322;">{{ number_format($totalSalidasGrafico) }} u.</b></span>
            <span class="kx-mini">Facturado <b style="color:#389e0d;">S/ {{ number_format($totalFact, 2) }}</b></span>
            <span class="kx-mini">Pedidos <b style="color:#722ed1;">{{ number_format($totalOrd) }}</b></span>
            <span class="kx-mini">Solicitado <b style="color:#1677ff;">{{ number_format($totalSolicitadoGrafico) }} u.</b></span>
            <span class="kx-mini">Pendiente <b style="color:#d48806;">{{ number_format($totalPendienteGrafico) }} u.</b></span>
            <span class="kx-mini">Cumplimiento <b style="color:#13a8a8;">{{ $cumplimientoGrafico === null ? 'Sin datos' : number_format($cumplimientoGrafico, 1) . '%' }}</b></span>
            <span class="kx-mini">Valor pendiente <b style="color:#cf1322;">S/ {{ number_format($totalValorPendienteGrafico, 2) }}</b></span>
        </div>

        @if(count($chartData['labels']) === 0)
            <div class="kx-chart-empty">
                <svg class="kx-ic"><use href="#i-chart"/></svg>
                <strong>Sin movimientos</strong>
                No hay movimientos en el período seleccionado
            </div>
        @else
            <div class="kx-chart-box">
                <canvas id="kardexChart"></canvas>
            </div>
        @endif

        @else

        <div class="kx-panel-head">
            <div>
                <div class="kx-panel-title"><svg class="kx-ic"><use href="#i-chart"/></svg> Movimientos diarios</div>
                <p class="kx-panel-sub">Cantidad de unidades por tipo de movimiento</p>
            </div>
        </div>
        <div class="kx-chart-empty">
            <svg class="kx-ic"><use href="#i-chart"/></svg>
            <strong>Filtra un producto o cliente</strong>
            Filtra un producto o cliente para ver la tendencia diaria
        </div>

        @endif

    </div>

    {{-- ── RESUMEN DEL PERIODO ── --}}
    <div class="kx-card kx-panel">

        <div class="kx-panel-head" style="margin-bottom:0;">
            <div class="kx-panel-title"><svg class="kx-ic"><use href="#i-pie"/></svg> Resumen del periodo</div>
        </div>

        <div class="kx-resumen-list">
            @foreach($resumen as $fila)
            <div class="kx-rs">
                <svg class="kx-ic" style="color:{{ $fila[3] }};"><use href="#{{ $fila[4] }}"/></svg>
                <span class="kx-rs-name">{{ $fila[0] }}</span>
                <span class="kx-rs-val">{{ number_format($fila[1]) }} un.</span>
                <div class="kx-rs-bar">
                    <div class="kx-rs-track"><i style="width:{{ min(100, $fila[2]) }}%;background:{{ $fila[3] }};"></i></div>
                    <span class="kx-rs-pct">{{ $fila[2] }}%</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="kx-cumpl">
            <svg class="kx-ic"><use href="#i-target"/></svg>
            <div>
                <strong>Porcentaje de cumplimiento</strong>
                <small>Despachado vs. Solicitado</small>
            </div>
            @if($cumplimiento === null)
                <span class="kx-cumpl-na">Sin datos</span>
            @else
                {!! $kxRing($cumplimiento, '#16a34a') !!}
            @endif
        </div>

        @if($entradaEsPagina)
            <p style="margin:10px 0 0;font-size:10.5px;color:#94a3b8;">* Ingreso directo corresponde a la página actual de movimientos.</p>
        @endif

    </div>

</div>


{{-- ═══════════ TABLA MOVIMIENTOS ═══════════ --}}
<div class="kx-card kx-table-card">

    <div class="kx-table-head">
        <div class="kx-panel-title"><svg class="kx-ic"><use href="#i-clip"/></svg> Movimientos de despacho</div>
        <div class="kx-pager-mini">
            <span>{{ $totalMovimientos }} registros · página {{ $movimientosPaginados->currentPage() }} de {{ $movimientosPaginados->lastPage() }}</span>
            <span class="kx-noprint" style="display:inline-flex;gap:6px;">
                @if($movimientosPaginados->onFirstPage())
                    <span class="kx-pg-btn is-off"><svg class="kx-ic kx-ic-sm"><use href="#i-chevl"/></svg></span>
                @else
                    <a href="{{ $movimientosPaginados->previousPageUrl() }}" class="kx-pg-btn kx-nav" title="Anterior"><svg class="kx-ic kx-ic-sm"><use href="#i-chevl"/></svg></a>
                @endif
                @if($movimientosPaginados->hasMorePages())
                    <a href="{{ $movimientosPaginados->nextPageUrl() }}" class="kx-pg-btn kx-nav" title="Siguiente"><svg class="kx-ic kx-ic-sm"><use href="#i-chevr"/></svg></a>
                @else
                    <span class="kx-pg-btn is-off"><svg class="kx-ic kx-ic-sm"><use href="#i-chevr"/></svg></span>
                @endif
            </span>
        </div>
    </div>

    <div class="kx-filter-note kx-hidden" id="kxTipoNote"></div>

    <div class="kx-tscroll">
        <table class="kx-table" id="kxTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>N° Orden</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th class="r">Producción</th>
                    <th class="r">Ingreso directo</th>
                    <th class="r">Desmedro</th>
                    <th class="r">Salida</th>
                    <th class="r">Precio U.</th>
                    <th class="r">Subtotal</th>
                    <th class="c kx-noprint">Acciones</th>
                </tr>
            </thead>
            <tbody id="kxTbody">
                @if($movimientosPaginados->count() > 0)
                @foreach($movimientosPaginados as $i => $mov)

@php

    $esProduccion = $mov['tipo'] === 'PRODUCCIÓN';
    $esEntrada = $mov['tipo'] === 'ENTRADA';
    $esPendiente = $mov['tipo'] === 'PEDIDO PENDIENTE';
    $esDesmedro = $mov['tipo'] === 'DESMEDRO';

    $tipoKey = $esProduccion ? 'produccion' : ($esEntrada ? 'entrada' : ($esPendiente ? 'pendiente' : ($esDesmedro ? 'desmedro' : 'salida')));
    $ti = $tipoInfo[$tipoKey];

    $conPrecio = in_array($mov['tipo'], ['SALIDA', 'PEDIDO PENDIENTE']);

    $qProd = (float) ($mov['cantidad_produccion'] ?? 0);
    $qEnt  = (float) ($mov['cantidad_entrada'] ?? 0);
    $qDes  = (float) ($mov['cantidad_desmedro'] ?? 0);
    $qSal  = (float) ($mov['cantidad_despachada'] ?? 0);
    $qSub  = (float) ($mov['subtotal'] ?? 0);

@endphp

                <tr
                    data-tipo="{{ $tipoKey }}"
                    data-tipo-label="{{ $ti[0] }}"
                    data-fecha="{{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y H:i') }}"
                    data-orden="{{ $mov['numero_orden'] ?? '' }}"
                    data-cliente="{{ $mov['cliente'] }}"
                    data-producto="{{ $mov['producto'] }}"
                    data-produccion="{{ $qProd }}"
                    data-entrada="{{ $qEnt }}"
                    data-desmedro="{{ $qDes }}"
                    data-salida="{{ $qSal }}"
                    data-precio="{{ $conPrecio ? number_format($mov['precio_unitario'], 2) : '' }}"
                    data-subtotal="{{ $qSub }}"
                >

                    {{-- # --}}
                    <td class="kx-n">{{ $i + 1 }}</td>

                    {{-- FECHA --}}
                    <td class="kx-date-cell">
                        {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y H:i') }}
                    </td>

                    {{-- TIPO --}}
                    <td>
                        <span class="kx-tipo" style="background:{{ $ti[2] }};color:{{ $ti[1] }};">
                            <i style="background:{{ $ti[3] }};"></i>{{ $ti[0] }}
                        </span>
                    </td>

                    {{-- ORDEN --}}
                    <td>
                        @if($mov['numero_orden'])
                            <span class="kx-orden">{{ $mov['numero_orden'] }}</span>
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- CLIENTE --}}
                    <td class="kx-ellip" title="{{ $mov['cliente'] }}">{{ $mov['cliente'] }}</td>

                    {{-- PRODUCTO --}}
                    <td class="kx-ellip kx-prod-name" title="{{ $mov['producto'] }}">{{ $mov['producto'] }}</td>

                    {{-- PRODUCCIÓN --}}
                    <td class="r kx-q" style="color:#15803d;">
                        @if(($mov['cantidad_produccion'] ?? 0) > 0)
                            +{{ number_format($mov['cantidad_produccion']) }}
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- INGRESO DIRECTO A TIENDA --}}
                    <td class="r kx-q" style="color:#6d28d9;">
                        @if(($mov['cantidad_entrada'] ?? 0) > 0)
                            +{{ number_format($mov['cantidad_entrada']) }}
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- DESMEDRO --}}
                    <td class="r kx-q" style="color:#ea580c;">
                        @if(($mov['cantidad_desmedro'] ?? 0) > 0)
                            -{{ number_format($mov['cantidad_desmedro']) }}
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- SALIDA --}}
                    <td class="r kx-q" style="color:#dc2626;">
                        @if($mov['cantidad_despachada'] > 0)
                            -{{ number_format($mov['cantidad_despachada']) }}
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- PRECIO --}}
                    <td class="r" style="color:#475569;">
                        @if($conPrecio)
                            S/ {{ number_format($mov['precio_unitario'], 2) }}
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- SUBTOTAL --}}
                    <td class="r kx-sub">
                        @if($conPrecio)
                            S/ {{ number_format($mov['subtotal'], 2) }}
                        @else
                            <span class="kx-dash">—</span>
                        @endif
                    </td>

                    {{-- ACCIONES --}}
                    <td class="c kx-noprint">
                        <span class="kx-acts">
                            <button type="button" class="kx-ibtn" data-kx-ver title="Ver detalle"><svg class="kx-ic"><use href="#i-eye"/></svg></button>
                            <button type="button" class="kx-ibtn dots" data-kx-menu title="Más acciones"><svg class="kx-ic"><use href="#i-dots"/></svg></button>
                        </span>
                    </td>

                </tr>

                @endforeach
                @else

                <tr class="kx-empty-row">
                    <td colspan="13">
                        <svg class="kx-ic"><use href="#i-clip"/></svg>
                        <p style="margin:0;">No hay movimientos con los filtros aplicados</p>
                    </td>
                </tr>

                @endif

                <tr class="kx-empty-row kx-hidden" id="kxNoMatch">
                    <td colspan="13">
                        <svg class="kx-ic"><use href="#i-layers"/></svg>
                        <p style="margin:0;">Ningún movimiento de esta página coincide con el tipo elegido</p>
                    </td>
                </tr>
            </tbody>
            @if($movimientosPaginados->total() > 0)

            <tfoot>
                <tr>
                    <td colspan="6" class="r" style="color:#475569;">TOTALES</td>
                    <td class="r" id="kxTfProd" style="color:#15803d;">{{ number_format($movimientosPaginados->sum('cantidad_produccion')) }}</td>
                    <td class="r" id="kxTfEnt" style="color:#6d28d9;">{{ number_format($movimientosPaginados->sum('cantidad_entrada')) }}</td>
                    <td class="r" id="kxTfDes" style="color:#ea580c;">{{ number_format($movimientosPaginados->sum('cantidad_desmedro')) }}</td>
                    <td class="r" id="kxTfSal" style="color:#dc2626;">{{ number_format($movimientosPaginados->sum('cantidad_despachada')) }}</td>
                    <td></td>
                    <td class="r" id="kxTfSub">S/ {{ number_format($movimientosPaginados->sum('subtotal'), 2) }}</td>
                    <td class="kx-noprint"></td>
                </tr>
            </tfoot>

            @endif
        </table>
    </div>

    @if($movimientosPaginados->hasPages())
    <div class="kx-table-foot kx-noprint">
        <p>
            Mostrando {{ $movimientosPaginados->firstItem() }}–{{ $movimientosPaginados->lastItem() }} de {{ $movimientosPaginados->total() }} movimientos
        </p>
        <div class="kx-pages">
            {{-- Anterior --}}
            @if($movimientosPaginados->onFirstPage())
                <span class="kx-page-b off">‹ Ant.</span>
            @else
                <a href="{{ $movimientosPaginados->previousPageUrl() }}" class="kx-page-b kx-nav">‹ Ant.</a>
            @endif

            {{-- Páginas --}}
            @foreach($movimientosPaginados->getUrlRange(
                max(1, $movimientosPaginados->currentPage() - 2),
                min($movimientosPaginados->lastPage(), $movimientosPaginados->currentPage() + 2)
            ) as $page => $url)
                @if($page == $movimientosPaginados->currentPage())
                    <span class="kx-page-b on">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="kx-page-b kx-nav">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if($movimientosPaginados->hasMorePages())
                <a href="{{ $movimientosPaginados->nextPageUrl() }}" class="kx-page-b kx-nav">Sig. ›</a>
            @else
                <span class="kx-page-b off">Sig. ›</span>
            @endif
        </div>
    </div>
    @endif

</div>


{{-- ═══════════ STOCK ACTUAL + TOP CLIENTES ═══════════ --}}
<div class="kx-two">

    {{-- Saldo actual de stock --}}
    <div class="kx-card" style="overflow:hidden;">
        <div class="kx-card-head">
            <p class="t"><svg class="kx-ic"><use href="#i-boxes"/></svg> Stock actual</p>
            <p class="s">Saldo por producto en inventario</p>
        </div>
        <div class="kx-list-body">
            @php $maxStock = max($stockProductos->max('stock'), 1); @endphp
            @if($stockProductos->count() > 0)
            @foreach($stockProductos as $prod)
            @php
                $color = $prod->stock <= ($prod->stock_minimo ?? 5)
                    ? '#cf1322'
                    : ($prod->stock <= (($prod->stock_minimo ?? 5) * 2) ? '#d48806' : '#1890ff');
            @endphp
            <div class="kx-inv-row">
                <div style="flex:1;min-width:0;">
                    <p style="font-size:13px;color:#0f172a;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:600;">
                        {{ $prod->nombre }}
                    </p>
                    @if($prod->sku)
                    <p style="font-size:11px;color:#94a3b8;margin:1px 0 0;">SKU: {{ $prod->sku }}</p>
                    @endif
                    <div class="kx-inv-bar">
                        <div class="kx-inv-fill" style="width:{{ $maxStock > 0 ? round(($prod->stock/$maxStock)*100) : 0 }}%;background:{{ $color }};"></div>
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0;margin-left:10px;">
                    <span style="font-size:15px;font-weight:800;color:{{ $color }};">{{ number_format($prod->stock) }}</span>
                    @if($prod->stock_minimo)
                    <p style="font-size:10px;color:#94a3b8;margin:0;">mín: {{ $prod->stock_minimo }}</p>
                    @endif
                </div>
            </div>
            @endforeach
            @else
            <p style="text-align:center;color:#94a3b8;font-size:13px;padding:20px 0;">Sin productos activos</p>
            @endif
        </div>
    </div>

    {{-- Top clientes --}}
    @if($movimientosPaginados->total() > 0)
    <div class="kx-card" style="overflow:hidden;">
        <div class="kx-card-head">
            <p class="t"><svg class="kx-ic"><use href="#i-users"/></svg> Top clientes</p>
            <p class="s">Por unidades despachadas</p>
        </div>
        <div class="kx-list-body">
            @php
                $topClientes = $movimientosPaginados->groupBy('cliente')
                    ->map(fn($g) => ['uds' => $g->sum('cantidad_despachada'), 'total' => $g->sum('subtotal')])
                    ->sortByDesc('uds')->take(5);
                $maxCli = $topClientes->max('uds') ?: 1;
            @endphp
            @foreach($topClientes as $nombre => $data)
            <div class="kx-inv-row">
                <div style="flex:1;min-width:0;">
                    <p style="font-size:13px;color:#0f172a;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:600;">{{ $nombre }}</p>
                    <p style="font-size:11px;color:#94a3b8;margin:1px 0 2px;">S/ {{ number_format($data['total'], 2) }}</p>
                    <div class="kx-inv-bar">
                        <div class="kx-inv-fill" style="width:{{ round(($data['uds']/$maxCli)*100) }}%;background:#722ed1;"></div>
                    </div>
                </div>
                <span style="font-size:14px;font-weight:800;color:#722ed1;margin-left:10px;flex-shrink:0;">{{ number_format($data['uds']) }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

</div>{{-- /kx-wrap --}}
</div>{{-- /kx-page --}}


{{-- ═══════════ DETALLE DEL MOVIMIENTO (modal) ═══════════ --}}
<div class="kx-modal" id="kxModal" role="dialog" aria-modal="true" aria-labelledby="kxModalTitle">
    <div class="kx-dialog">
        <div class="kx-dialog-head">
            <strong id="kxModalTitle">Detalle del movimiento</strong>
            <button type="button" class="kx-ibtn" id="kxModalCerrar" title="Cerrar"><svg class="kx-ic"><use href="#i-x"/></svg></button>
        </div>
        <div class="kx-dialog-body">
            <dl class="kx-dl" id="kxModalBody"></dl>
        </div>
    </div>
</div>

{{-- Menú de acciones de fila --}}
<div class="kx-menu" id="kxRowMenu">
    <button type="button" data-kx-act="ver"><svg class="kx-ic"><use href="#i-eye"/></svg> Ver detalle</button>
    <button type="button" data-kx-act="copiar"><svg class="kx-ic"><use href="#i-copy"/></svg> Copiar N° de orden</button>
    <button type="button" data-kx-act="producto"><svg class="kx-ic"><use href="#i-search"/></svg> Filtrar por este producto</button>
    <button type="button" data-kx-act="cliente"><svg class="kx-ic"><use href="#i-user"/></svg> Filtrar por este cliente</button>
</div>

<div class="kx-toast" id="kxToast"></div>


{{-- ═══════════════════════════════════════════════════════
     GRÁFICO DE TENDENCIAS — solo visible al filtrar
═══════════════════════════════════════════════════════ --}}
@if(!is_null($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    const labels     = @json($chartData['labels']);
const salidas    = @json($chartData['salidas']);
const produccion = @json($chartData['produccion']);
const entradaDirecta = @json($chartData['entrada_directa'] ?? []);
const desmedro = @json($chartData['desmedro'] ?? []);
const subtotales = @json($chartData['subtotal']);
const solicitado = @json($chartData['solicitado']);
const pendiente = @json($chartData['pendiente']);
const valorPendiente = @json($chartData['valor_pendiente']);

    if (!labels.length) return;

    const canvas = document.getElementById('kardexChart');
    if (!canvas) return;

    if (typeof Chart === 'undefined') {
        canvas.parentNode.innerHTML = '<div class="kx-chart-empty"><strong>No se pudo cargar el gráfico</strong>Revisa tu conexión e intenta nuevamente.</div>';
        return;
    }

    const ctx = canvas.getContext('2d');

    const rgba = (hex, a) => {
        const n = parseInt(hex.slice(1), 16);
        return `rgba(${(n >> 16) & 255}, ${(n >> 8) & 255}, ${n & 255}, ${a})`;
    };
    const acum = arr => { let s = 0; return (arr || []).map(v => (s += (Number(v) || 0))); };
    const soles = v => parseFloat(v).toLocaleString('es-PE', {minimumFractionDigits:2});

    // Mismas series y colores de siempre
    const series = [
        { label: 'Solicitado',              data: solicitado,     color: '#1677ff', fill: false, radius: 3 },
        { label: 'Producción',              data: produccion,     color: '#389e0d', fill: true,  radius: 4 },
        { label: 'Ingreso directo a tienda',data: entradaDirecta, color: '#722ed1', fill: false, radius: 4 },
        { label: 'Desmedro',                data: desmedro,       color: '#fa8c16', fill: false, radius: 4 },
        { label: 'Salidas',                 data: salidas,        color: '#cf1322', fill: true,  radius: 4 },
        { label: 'Pendiente de despacho',   data: pendiente,      color: '#d48806', fill: false, radius: 3 },
    ];

    let chart = null;

    function construir(modo) {

        if (chart) chart.destroy();

        const tipo = modo === 'bar' ? 'bar' : 'line';

        const datasets = series.map(s => {
            const data = modo === 'acum' ? acum(s.data) : s.data;

            if (tipo === 'bar') {
                return {
                    label: s.label, data,
                    backgroundColor: rgba(s.color, .85), borderRadius: 4, borderWidth: 0,
                    yAxisID: 'y',
                };
            }

            return {
                label: s.label, data,
                borderColor: s.color,
                backgroundColor: rgba(s.color, .10),
                borderWidth: 2.5,
                pointBackgroundColor: s.color,
                pointRadius: s.radius,
                pointHoverRadius: 6,
                tension: 0.35,
                fill: modo === 'line' ? s.fill : false,
                yAxisID: 'y',
            };
        });

        const sub = modo === 'acum' ? acum(subtotales)      : subtotales;
        const vp  = modo === 'acum' ? acum(valorPendiente)  : valorPendiente;

        chart = new Chart(ctx, {
            type: tipo,
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, pointStyle: 'circle', font:{ size:11 }, boxWidth:8, padding:16 }
                    },
                    tooltip: {
                        callbacks: {
                            afterBody: function(items) {
                                const idx = items[0]?.dataIndex;
                                if (idx === undefined) return '';
                                const s = sub[idx] ?? 0;
                                const v = vp[idx] ?? 0;
                                return ['', `💰 Facturado: S/ ${soles(s)}`, `⏳ Valor pendiente: S/ ${soles(v)}`];
                            },
                            label: c => ` ${c.dataset.label}: ${c.parsed.y.toLocaleString()} u.`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Unidades', font:{ size:11 }, color:'#64748b' },
                        grid: { color:'#eef2f8' },
                        ticks: { font:{ size:10 }, color:'#64748b', callback: v => v.toLocaleString() }
                    },
                    x: {
                        grid: { display:false },
                        ticks: { font:{ size:10 }, color:'#64748b' }
                    }
                }
            }
        });
    }

    construir('line');

    const selVista = document.getElementById('kxChartVista');
    if (selVista) selVista.addEventListener('change', () => construir(selVista.value));

    // Al imprimir, el gráfico se redibuja al tamaño de la hoja
    window.addEventListener('beforeprint', () => { if (chart) chart.resize(); });
})();
</script>
@endif
{{-- ── FIN GRÁFICO ── --}}


<script>
(function () {

    var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
    var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };
    var norm = function (t) {
        return (t || '').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    };

    /* ─────────────────────────────────────────────
       ICONO DE LA PESTAÑA (favicon)
    ───────────────────────────────────────────── */
    (function () {
        var href = @json($kxFavicon);
        var link = document.querySelector('link[rel~="icon"]');
        if (!link) {
            link = document.createElement('link');
            link.rel = 'icon';
            document.head.appendChild(link);
        }
        if (href.indexOf('data:image/svg+xml') === 0) { link.type = 'image/svg+xml'; }
        link.href = href;
    })();

    /* ─────────────────────────────────────────────
       PANTALLA DE CARGA
    ───────────────────────────────────────────── */
    var loader = $('#kxLoader');
    var ocultarLoader = function () { if (loader) loader.classList.add('is-hidden'); };
    var mostrarLoader = function () { if (loader) loader.classList.remove('is-hidden'); };

    if (document.readyState === 'complete') {
        setTimeout(ocultarLoader, 250);
    } else {
        window.addEventListener('load', function () { setTimeout(ocultarLoader, 250); });
        setTimeout(ocultarLoader, 5000); // por si algún recurso externo tarda demasiado
    }
    // Al volver con el botón "atrás" el navegador restaura la página tal cual
    window.addEventListener('pageshow', function (e) { if (e.persisted) ocultarLoader(); });

    var form = $('#kxFilterForm');
    if (form) form.addEventListener('submit', mostrarLoader);

    document.addEventListener('click', function (e) {
        var a = e.target.closest('a.kx-nav, a.kx-page-b');
        if (a && a.href && !e.ctrlKey && !e.metaKey && !e.shiftKey && a.target !== '_blank') {
            mostrarLoader();
        }
    });

    /* ─────────────────────────────────────────────
       TOAST
    ───────────────────────────────────────────── */
    var toast = $('#kxToast');
    var toastTimer = null;
    var avisar = function (texto) {
        toast.textContent = texto;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toast.classList.remove('show'); }, 2200);
    };

    /* ─────────────────────────────────────────────
       SELECTORES CON BUSCADOR (producto / cliente)
       El <select> original sigue en el formulario y es el que se envía.
    ───────────────────────────────────────────── */
    var combos = [];

    $$('select[data-kx-combo]').forEach(function (sel) {

        var control = sel.closest('.kx-control');
        var caret = $('.kx-caret', control);
        var placeholder = sel.getAttribute('data-placeholder') || 'Seleccionar...';

        var wrap = document.createElement('div');
        wrap.className = 'kx-combo';
        wrap.innerHTML =
            '<button type="button" class="kx-combo-btn"><span class="kx-combo-txt"></span></button>' +
            '<div class="kx-combo-panel kx-hidden">' +
                '<div class="kx-combo-search"><svg class="kx-ic kx-ic-sm"><use href="#i-search"/></svg>' +
                '<input type="text" placeholder="Escribe para buscar..." autocomplete="off"></div>' +
                '<ul class="kx-combo-list"></ul>' +
            '</div>';

        sel.style.display = 'none';
        control.insertBefore(wrap, sel);

        var btn = $('.kx-combo-btn', wrap);
        var txt = $('.kx-combo-txt', wrap);
        var panel = $('.kx-combo-panel', wrap);
        var input = $('input', wrap);
        var list = $('.kx-combo-list', wrap);
        var foco = -1;

        function textoActual() {
            var opt = sel.options[sel.selectedIndex];
            if (!opt || opt.value === '') {
                txt.textContent = placeholder;
                txt.classList.add('is-placeholder');
            } else {
                txt.textContent = opt.textContent.replace(/\s+/g, ' ').trim();
                txt.classList.remove('is-placeholder');
            }
        }

        function pintar(filtro) {
            var q = norm(filtro);
            list.innerHTML = '';
            var visibles = 0;

            Array.prototype.forEach.call(sel.options, function (opt) {
                var t = opt.textContent.replace(/\s+/g, ' ').trim();
                if (q && norm(t).indexOf(q) === -1) return;
                var li = document.createElement('li');
                li.textContent = t;
                li.setAttribute('data-value', opt.value);
                if (opt.value === sel.value) li.classList.add('is-selected');
                list.appendChild(li);
                visibles++;
            });

            if (!visibles) {
                var vacio = document.createElement('div');
                vacio.className = 'kx-combo-empty';
                vacio.textContent = 'Sin resultados';
                list.appendChild(vacio);
            }
            foco = -1;
        }

        function abrir() {
            combos.forEach(function (c) { if (c !== api) c.cerrar(); });
            panel.classList.remove('kx-hidden');
            control.classList.add('is-open');
            input.value = '';
            pintar('');
            setTimeout(function () { input.focus(); }, 0);
        }

        function cerrar() {
            panel.classList.add('kx-hidden');
            control.classList.remove('is-open');
        }

        function elegir(valor) {
            sel.value = valor;
            sel.dispatchEvent(new Event('change', { bubbles: true }));
            textoActual();
            cerrar();
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            panel.classList.contains('kx-hidden') ? abrir() : cerrar();
        });
        panel.addEventListener('click', function (e) { e.stopPropagation(); });

        list.addEventListener('click', function (e) {
            var li = e.target.closest('li');
            if (li) elegir(li.getAttribute('data-value'));
        });

        input.addEventListener('input', function () { pintar(input.value); });

        input.addEventListener('keydown', function (e) {
            var items = $$('li', list);
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                if (!items.length) return;
                foco = e.key === 'ArrowDown' ? Math.min(items.length - 1, foco + 1) : Math.max(0, foco - 1);
                items.forEach(function (li, i) { li.classList.toggle('is-focus', i === foco); });
                items[foco].scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'Enter') {
                e.preventDefault();
                var objetivo = items[foco >= 0 ? foco : 0];
                if (objetivo) elegir(objetivo.getAttribute('data-value'));
            } else if (e.key === 'Escape') {
                cerrar();
                btn.focus();
            }
        });

        var api = { cerrar: cerrar, refrescar: textoActual };
        combos.push(api);
        textoActual();
    });

    document.addEventListener('click', function () { combos.forEach(function (c) { c.cerrar(); }); });

    /* ─────────────────────────────────────────────
       FILTRO POR TIPO DE MOVIMIENTO (filas de esta página) + totales
    ───────────────────────────────────────────── */
    var selTipo = $('#kxTipo');
    var filas = $$('#kxTbody tr[data-tipo]');
    var nota = $('#kxTipoNote');
    var sinCoincidencia = $('#kxNoMatch');

    var f0 = function (n) { return Math.round(n).toLocaleString('es-PE'); };
    var f2 = function (n) { return n.toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };

    function aplicarTipo() {

        if (!selTipo) return;

        var tipo = selTipo.value;
        var visibles = 0;
        var t = { produccion: 0, entrada: 0, desmedro: 0, salida: 0, subtotal: 0 };

        filas.forEach(function (tr) {
            var mostrar = !tipo || tr.getAttribute('data-tipo') === tipo;
            tr.classList.toggle('kx-hidden', !mostrar);
            if (!mostrar) return;
            visibles++;
            t.produccion += parseFloat(tr.getAttribute('data-produccion')) || 0;
            t.entrada    += parseFloat(tr.getAttribute('data-entrada')) || 0;
            t.desmedro   += parseFloat(tr.getAttribute('data-desmedro')) || 0;
            t.salida     += parseFloat(tr.getAttribute('data-salida')) || 0;
            t.subtotal   += parseFloat(tr.getAttribute('data-subtotal')) || 0;
        });

        var set = function (id, valor) { var el = document.getElementById(id); if (el) el.textContent = valor; };
        set('kxTfProd', f0(t.produccion));
        set('kxTfEnt',  f0(t.entrada));
        set('kxTfDes',  f0(t.desmedro));
        set('kxTfSal',  f0(t.salida));
        set('kxTfSub',  'S/ ' + f2(t.subtotal));

        if (sinCoincidencia) sinCoincidencia.classList.toggle('kx-hidden', !(tipo && filas.length && visibles === 0));

        if (nota) {
            if (tipo) {
                nota.textContent = 'Mostrando ' + visibles + ' de ' + filas.length + ' movimientos de esta página (' +
                    selTipo.options[selTipo.selectedIndex].text + '). Los totales se recalcularon con esas filas.';
                nota.classList.remove('kx-hidden');
            } else {
                nota.classList.add('kx-hidden');
            }
        }
    }

    if (selTipo) selTipo.addEventListener('change', aplicarTipo);

    /* ─────────────────────────────────────────────
       DETALLE / MENÚ DE ACCIONES POR FILA
    ───────────────────────────────────────────── */
    var modal = $('#kxModal');
    var modalBody = $('#kxModalBody');
    var menu = $('#kxRowMenu');
    var filaMenu = null;

    var esc = function (t) {
        var d = document.createElement('div');
        d.textContent = t == null ? '' : t;
        return d.innerHTML;
    };

    function verDetalle(tr) {

        var ds = function (k) { return tr.getAttribute('data-' + k) || ''; };
        var cant = function (k, signo) {
            var n = parseFloat(ds(k)) || 0;
            return n > 0 ? signo + Math.round(n).toLocaleString('es-PE') : '—';
        };
        var tieneSub = ds('precio') !== '';

        modalBody.innerHTML =
            '<div><dt>Tipo</dt><dd>' + esc(ds('tipo-label')) + '</dd></div>' +
            '<div><dt>Fecha</dt><dd>' + esc(ds('fecha')) + '</dd></div>' +
            '<div><dt>N° de orden</dt><dd>' + esc(ds('orden') || '—') + '</dd></div>' +
            '<div><dt>Cliente</dt><dd>' + esc(ds('cliente') || '—') + '</dd></div>' +
            '<div class="full"><dt>Producto</dt><dd>' + esc(ds('producto')) + '</dd></div>' +
            '<div><dt>Producción</dt><dd style="color:#15803d;">' + cant('produccion', '+') + '</dd></div>' +
            '<div><dt>Ingreso directo</dt><dd style="color:#6d28d9;">' + cant('entrada', '+') + '</dd></div>' +
            '<div><dt>Desmedro</dt><dd style="color:#ea580c;">' + cant('desmedro', '-') + '</dd></div>' +
            '<div><dt>Salida</dt><dd style="color:#dc2626;">' + cant('salida', '-') + '</dd></div>' +
            '<div><dt>Precio unitario</dt><dd>' + (tieneSub ? 'S/ ' + esc(ds('precio')) : '—') + '</dd></div>' +
            '<div><dt>Subtotal</dt><dd>' + (tieneSub ? 'S/ ' + f2(parseFloat(ds('subtotal')) || 0) : '—') + '</dd></div>';

        modal.classList.add('show');
    }

    function cerrarModal() { modal.classList.remove('show'); }
    function cerrarMenu() { menu.classList.remove('show'); filaMenu = null; }

    $('#kxModalCerrar').addEventListener('click', cerrarModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) cerrarModal(); });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { cerrarModal(); cerrarMenu(); combos.forEach(function (c) { c.cerrar(); }); }
    });

    var tbody = $('#kxTbody');

    if (tbody) {
        tbody.addEventListener('click', function (e) {

            var ver = e.target.closest('[data-kx-ver]');
            var dots = e.target.closest('[data-kx-menu]');

            if (ver) {
                verDetalle(ver.closest('tr'));
                return;
            }

            if (dots) {
                e.stopPropagation();
                var tr = dots.closest('tr');

                if (filaMenu === tr && menu.classList.contains('show')) { cerrarMenu(); return; }

                filaMenu = tr;
                var r = dots.getBoundingClientRect();
                menu.classList.add('show');

                var ancho = menu.offsetWidth;
                var alto = menu.offsetHeight;
                var left = Math.min(window.innerWidth - ancho - 10, Math.max(10, r.right - ancho));
                var top = r.bottom + 6;
                if (top + alto > window.innerHeight - 10) { top = Math.max(10, r.top - alto - 6); }

                menu.style.left = left + 'px';
                menu.style.top = top + 'px';
            }
        });
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#kxRowMenu')) cerrarMenu();
    });
    window.addEventListener('scroll', cerrarMenu, true);
    window.addEventListener('resize', cerrarMenu);

    function filtrarPorTexto(selectName, texto) {

        var sel = $('select[name="' + selectName + '"]');
        if (!sel || !texto) return false;

        var buscado = norm(texto).trim();
        var encontrada = null;

        Array.prototype.forEach.call(sel.options, function (opt) {
            if (encontrada || opt.value === '') return;
            var nombre = norm(opt.textContent.split('·')[0]).replace(/\s+/g, ' ').trim();
            if (nombre === buscado) encontrada = opt;
        });

        if (!encontrada) return false;

        sel.value = encontrada.value;
        sel.dispatchEvent(new Event('change', { bubbles: true }));
        combos.forEach(function (c) { c.refrescar(); });
        mostrarLoader();
        form.submit();
        return true;
    }

    menu.addEventListener('click', function (e) {

        var boton = e.target.closest('[data-kx-act]');
        if (!boton || !filaMenu) return;

        var tr = filaMenu;
        var accion = boton.getAttribute('data-kx-act');
        cerrarMenu();

        if (accion === 'ver') {
            verDetalle(tr);
        } else if (accion === 'copiar') {
            var orden = tr.getAttribute('data-orden');
            if (!orden) { avisar('Este movimiento no tiene N° de orden'); return; }
            var listo = function () { avisar('N° de orden copiado: ' + orden); };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(orden).then(listo, function () { avisar(orden); });
            } else {
                var tmp = document.createElement('textarea');
                tmp.value = orden;
                document.body.appendChild(tmp);
                tmp.select();
                try { document.execCommand('copy'); listo(); } catch (err) { avisar(orden); }
                document.body.removeChild(tmp);
            }
        } else if (accion === 'producto') {
            if (!filtrarPorTexto('product_id', tr.getAttribute('data-producto'))) avisar('No se encontró el producto en el filtro');
        } else if (accion === 'cliente') {
            if (!filtrarPorTexto('client_id', tr.getAttribute('data-cliente'))) avisar('No se encontró el cliente en el filtro');
        }
    });

    /* ─────────────────────────────────────────────
       GENERAR PDF (imprime la vista con los filtros aplicados)
    ───────────────────────────────────────────── */
    var btnPdf = $('#kxBtnPdf');
    if (btnPdf) btnPdf.addEventListener('click', function () { window.print(); });

})();
</script>

@endsection