@extends('layouts.app')

@section('content')

<style>
*{box-sizing:border-box;}
.pg{padding:1.25rem;background:#f1f5f9;min-height:100vh;}
.top-hdr{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.1rem;flex-wrap:wrap;gap:10px;}
.hdr-left h1{font-size:20px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;}
.hdr-left p{font-size:12px;color:#94a3b8;margin-top:2px;}
.hdr-right{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.badge-estado{padding:5px 14px;border-radius:99px;font-size:12px;font-weight:700;color:#fff;}
.kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:1.1rem;}
@media(max-width:700px){.kpis{grid-template-columns:repeat(2,1fr);}}
.kpi{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:.8rem 1rem;display:flex;align-items:center;gap:10px;}
.kpi-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.kpi-label{font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;}
.kpi-val{font-size:18px;font-weight:700;color:#1e293b;line-height:1.1;}
.main-layout{display:grid;grid-template-columns:1fr 290px;gap:16px;}
@media(max-width:900px){.main-layout{grid-template-columns:1fr;}}
.left-col{display:flex;flex-direction:column;gap:14px;}
.right-col{display:flex;flex-direction:column;gap:12px;}
.scanner-card{background:#0f172a;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:12px;}
.scanner-label{font-size:12px;color:#94a3b8;font-weight:600;margin-bottom:4px;}
.scanner-input{width:100%;padding:10px 14px;font-size:16px;border-radius:8px;border:none;background:#1e293b;color:#f8fafc;outline:none;letter-spacing:1px;}
.scanner-input::placeholder{color:#475569;}
.scanner-input:focus{box-shadow:0 0 0 2px #2563eb;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.3;}}
.section-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem 1.25rem;}
.sec-title{font-size:13px;font-weight:600;color:#1e293b;margin-bottom:.85rem;display:flex;align-items:center;gap:7px;}
.import-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.file-label{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:1px dashed #e2e8f0;border-radius:8px;font-size:12px;color:#64748b;cursor:pointer;background:#f8fafc;flex:1;transition:border-color .15s;}
.file-label:hover{border-color:#2563eb;color:#2563eb;}
.add-grid{display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:8px;align-items:end;}
@media(max-width:600px){.add-grid{grid-template-columns:1fr 1fr;}}
.flabel{font-size:10px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;}
.finput{padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;color:#1e293b;background:#fff;outline:none;width:100%;transition:border-color .15s;}
.finput:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;}
.prod-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem;display:flex;flex-direction:column;gap:.65rem;border-left:4px solid;transition:transform .15s;}
.prod-card:hover{transform:translateY(-2px);}
.prod-top{display:flex;justify-content:space-between;align-items:flex-start;}
.prod-name{font-size:13px;font-weight:700;color:#0f172a;}
.prod-sku{font-size:10px;color:#94a3b8;margin-top:1px;}
.prod-badge{font-size:10px;padding:2px 8px;border-radius:99px;font-weight:700;white-space:nowrap;}
.bc{background:#dcfce7;color:#15803d;}
.bp{background:#fef3c7;color:#b45309;}
.bi{background:#fee2e2;color:#b91c1c;}
.info-strip{display:grid;grid-template-columns:1fr 1fr;gap:5px;background:#f8fafc;border-radius:8px;padding:7px 9px;}
.info-item{font-size:11px;color:#64748b;display:flex;align-items:center;gap:4px;}
.info-val{font-weight:600;color:#374151;}
.prog-mini{width:100%;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-mini-fill{height:100%;border-radius:99px;}
.fields-box{background:#f8fafc;border-radius:8px;padding:9px 10px;display:flex;flex-direction:column;gap:7px;}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:7px;}

/* Edición compacta en dos columnas */
.oc-info-grid{
    grid-template-columns:1fr 1fr !important;
    gap:6px;
    margin-bottom:8px;
}
.oc-info-card{
    min-height:34px;
    padding:7px 9px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:7px;
    display:grid;
    grid-template-columns:auto 1fr;
    align-items:center;
    column-gap:6px;
}
.oc-info-card .info-val{
    justify-self:end;
}
.oc-info-card small{
    grid-column:1 / -1;
    color:#94a3b8;
    font-size:9px;
    margin-top:1px;
}
.oc-info-progress{
    grid-column:1 / -1;
    padding:7px 9px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:7px;
    display:grid;
    grid-template-columns:auto 1fr auto;
    align-items:center;
    gap:7px;
}
.oc-info-progress .prog-mini{min-width:0;}
.oc-extra-units{color:#f59e0b !important;}

.oc-fields-grid{
    display:grid !important;
    grid-template-columns:1fr 1fr;
    gap:8px;
    align-items:end;
}
.oc-fields-grid > div{
    min-width:0;
}
.oc-fields-grid .finput{
    width:100%;
    box-sizing:border-box;
}
.oc-fields-grid .paleta-input{
    text-align:left;
    letter-spacing:1px;
}
.oc-form-subtotal{
    min-height:38px;
    padding:8px 10px;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-sizing:border-box;
}
.oc-form-subtotal span{
    font-size:11px;
    color:#64748b;
}
.oc-form-subtotal strong{
    font-size:13px;
    color:#0f172a;
}
.oc-form-save{
    display:flex;
    align-items:stretch;
}
.oc-form-save .btn{
    width:100%;
    min-height:38px;
}
@media(max-width:700px){
    .oc-info-grid,
    .oc-fields-grid{
        grid-template-columns:1fr 1fr !important;
    }
}

.paleta-input{width:100%;padding:10px 14px;font-size:17px;border:2px solid #2563eb;border-radius:9px;text-align:center;font-weight:700;letter-spacing:3px;outline:none;background:#fff;transition:box-shadow .15s;}
.paleta-input:focus{box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.subtotal-row{display:flex;justify-content:space-between;align-items:center;}
.subtotal-val{font-size:14px;font-weight:700;color:#0f172a;}
.btn-row-prod{display:grid;grid-template-columns:1fr auto;gap:7px;}
hr.dv{border:none;border-top:1px solid #f1f5f9;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:5px;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:opacity .15s;}
.btn:hover{opacity:.85;}
.btn-green{background:#16a34a;color:#fff;}
.btn-blue{background:#2563eb;color:#fff;}
.btn-gray{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.btn-red{background:#dc2626;color:#fff;}
.resumen-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:1.1rem;}
.resumen-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:#64748b;padding:5px 0;border-bottom:1px solid #f1f5f9;}
.resumen-row:last-child{border:none;}
.resumen-val{font-weight:600;color:#1e293b;}
.resumen-total-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;margin-top:4px;}
.prog-resumen{padding:10px;background:#f8fafc;border-radius:9px;}
.prog-label{display:flex;justify-content:space-between;font-size:11px;color:#64748b;margin-bottom:4px;}
.prog-bar{width:100%;height:7px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.prog-fill{height:100%;border-radius:99px;}
.legend{display:flex;flex-direction:column;gap:5px;margin-top:4px;}
.leg-row{display:flex;justify-content:space-between;align-items:center;font-size:12px;}
.leg-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-right:5px;display:inline-block;}

/* ══════════════════════════════
   MAPA DE PALETAS
══════════════════════════════ */
.paleta-map-card {
    background:#fff; border:1px solid #e2e8f0;
    border-radius:12px; overflow:hidden;
}
.paleta-map-header {
    background:#0f172a; padding:10px 14px;
    display:flex; align-items:center; justify-content:space-between;
}
.paleta-map-title {
    font-size:12px; font-weight:700; color:#f8fafc;
    display:flex; align-items:center; gap:7px;
}
.paleta-map-body { padding:12px; }

.paleta-map-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(110px,1fr));
    gap:8px;
}

/* Cada caja de paleta en el mapa */
.paleta-box {
    border-radius:10px; border:2px solid transparent;
    padding:10px 8px; text-align:center;
    cursor:pointer; transition:transform .15s, box-shadow .15s;
    position:relative; user-select:none;
}
.paleta-box:hover {
    transform:translateY(-3px);
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}
.paleta-box.estado-completo { background:#dcfce7; border-color:#86efac; }
.paleta-box.estado-parcial { background:#fef3c7; border-color:#fde68a; }
.paleta-box.estado-incompleto{ background:#fee2e2; border-color:#fca5a5; }
.paleta-box.estado-vacia { background:#f8fafc; border-color:#e2e8f0; }

.paleta-box-icon { font-size:22px; margin-bottom:4px; }
.paleta-box-name { font-size:12px; font-weight:800; color:#0f172a; }
.paleta-box-items { font-size:10px; color:#64748b; margin-top:2px; }
.paleta-box-pct { font-size:11px; font-weight:700; margin-top:3px; }
.paleta-box-bar { height:4px; border-radius:99px; background:#e5e7eb; overflow:hidden; margin-top:5px; }
.paleta-box-fill { height:100%; border-radius:99px; }

/* Aviso de paleta llena */
.paleta-box.paleta-llena { opacity:.85; }
.paleta-box-full-badge {
    position:absolute; top:6px; right:6px;
    background:#dc2626; color:#fff; font-size:9px; font-weight:800;
    padding:1px 6px; border-radius:99px;
}

/* Sin paleta chip */
.no-paleta-chip {
    display:flex; align-items:center; justify-content:space-between;
    background:#fff8f0; border:1px dashed #fed7aa;
    border-radius:8px; padding:7px 10px; font-size:12px;
    color:#92400e; margin-top:8px; cursor:pointer;
    transition:background .15s;
}
.no-paleta-chip:hover { background:#fef3e2; }

/* ══════════════════════════════
   MODAL DE DETALLE
══════════════════════════════ */
.pm-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.45); z-index:1000;
    align-items:center; justify-content:center; padding:16px;
}
.pm-overlay.open { display:flex; }
.pm-modal {
    background:#fff; border-radius:14px;
    width:480px; max-width:100%; max-height:90vh;
    overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.2);
    animation:mIn .16s ease;
}
@keyframes mIn{from{transform:scale(.95);opacity:0}to{transform:scale(1);opacity:1}}
.pm-header {
    padding:14px 18px; display:flex; align-items:center;
    justify-content:space-between; border-bottom:1px solid #f1f5f9;
    position:sticky; top:0; background:#fff; z-index:1;
}
.pm-title { font-size:15px; font-weight:700; color:#0f172a; }
.pm-sub { font-size:11px; color:#94a3b8; margin-top:2px; }
.pm-body { padding:16px 18px; }
.pm-close { background:none; border:none; font-size:20px; cursor:pointer; color:#94a3b8; padding:2px 6px; }

.pm-kpis { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-bottom:14px; }
.pm-kpi {
    background:#f8fafc; border-radius:9px; padding:8px 10px;
    text-align:center; border:1px solid #e2e8f0;
}
.pm-kpi-label { font-size:10px; color:#94a3b8; font-weight:600; text-transform:uppercase; }
.pm-kpi-val { font-size:17px; font-weight:700; color:#1e293b; margin-top:2px; }

.pm-prog-wrap { background:#f8fafc; border-radius:9px; padding:10px 12px; margin-bottom:14px; }
.pm-prog-hdr { display:flex; justify-content:space-between; font-size:11px; color:#64748b; margin-bottom:5px; }
.pm-prog-bar { height:8px; background:#e5e7eb; border-radius:99px; overflow:hidden; }
.pm-prog-fill { height:100%; border-radius:99px; }

.pm-item {
    display:flex; align-items:center; gap:10px;
    padding:9px 0; border-bottom:1px solid #f1f5f9;
}
.pm-item:last-child { border-bottom:none; }
.pm-item-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
.pm-item-name { flex:1; font-size:12px; font-weight:500; color:#374151; }
.pm-item-right{ display:flex; align-items:center; gap:8px; flex-shrink:0; }
.pm-item-qty { font-size:12px; font-weight:700; color:#0f172a; }
.pm-item-badge{ font-size:10px; font-weight:700; padding:2px 7px; border-radius:99px; }

.et-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1001;align-items:center;justify-content:center;padding:16px;}
.et-overlay.open{display:flex;}
.et-modal{background:#fff;border:1px solid #000;padding:22px 18px;width:300px;max-width:100%;text-align:center;}
.et-label{display:flex;flex-direction:column;align-items:center;gap:6px;color:#000;}
.et-nombre{font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:.03em;}
.et-cpc{font-size:11px;}
.et-info{margin-top:6px;font-size:11px;line-height:1.7;text-align:center;}
.et-actions{margin-top:16px;display:flex;gap:8px;justify-content:center;}
/* =========================================================
   VISOR 3D DE PALETA
========================================================= */

.p3d-overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(2,6,23,.72);
    z-index:3000;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.p3d-overlay.open {
    display:flex;
}

.p3d-modal {
    width:min(1100px,96vw);
    height:min(760px,92vh);
    background:#f8fafc;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 25px 80px rgba(0,0,0,.35);
    display:flex;
    flex-direction:column;
}

.p3d-header {
    background:#0f172a;
    color:#fff;
    padding:13px 18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
}

.p3d-title {
    font-size:16px;
    font-weight:800;
}

.p3d-subtitle {
    font-size:10px;
    color:#94a3b8;
    margin-top:2px;
}

.p3d-close {
    border:0;
    background:#1e293b;
    color:#fff;
    width:34px;
    height:34px;
    border-radius:7px;
    cursor:pointer;
    font-size:18px;
}

.p3d-body {
    flex:1;
    display:grid;
    grid-template-columns:1fr 270px;
    min-height:0;
}

@media(max-width:800px) {
    .p3d-body {
        grid-template-columns:1fr;
    }

    .p3d-panel {
        max-height:240px;
    }
}

/* Área donde gira la paleta */

.p3d-stage {
    position:relative;
    overflow:hidden;
    background:
        radial-gradient(circle at center,#ffffff 0,#f1f5f9 55%,#e2e8f0 100%);
    cursor:grab;
    perspective:1000px;
}

.p3d-stage.dragging {
    cursor:grabbing;
}

/* Contenedor 3D */

.p3d-world {
    position:absolute;
    left:50%;
    top:50%;
    width:600px;
    height:500px;
    transform-style:preserve-3d;
    transform:
        translate(-50%,-50%)
        rotateX(58deg)
        rotateZ(-28deg)
        scale(.85);
    transition:transform .08s linear;
}

/* Base de la paleta */

.p3d-pallet {
    position:absolute;
    left:50%;
    top:50%;
    width:520px;
    height:330px;
    transform:
        translate(-50%,-50%)
        translateZ(0);
    transform-style:preserve-3d;
}

.p3d-pallet-top {
    position:absolute;
    inset:0;
    background:
        repeating-linear-gradient(
            90deg,
            #b9824b 0,
            #b9824b 22px,
            #9f6c3e 23px,
            #9f6c3e 27px
        );
    border:4px solid #704214;
    border-radius:5px;
    box-shadow:
        0 15px 0 #704214,
        0 20px 25px rgba(0,0,0,.25);
}

/* Patas de la paleta */

.p3d-pallet-leg {
    position:absolute;
    width:55px;
    height:35px;
    background:#704214;
    bottom:-45px;
    border-radius:2px;
}

.p3d-pallet-leg.l1 {
    left:35px;
}

.p3d-pallet-leg.l2 {
    left:50%;
    transform:translateX(-50%);
}

.p3d-pallet-leg.l3 {
    right:35px;
}

/* =========================================================
   GRUPOS Y CAJAS 3D
========================================================= */

.p3d-product-group {
    position:absolute;
    transform-style:preserve-3d;
    cursor:grab;
    user-select:none;
    transition:filter .15s;
}

.p3d-product-group.dragging {
    cursor:grabbing;
}

.p3d-product-group:hover {
    filter:brightness(1.05);
}
/* =========================================================
   CAJAS 3D REALES
========================================================= */

.p3d-box {
    position:absolute;
    transform-style:preserve-3d;
    transform-origin:center center;
}

/* CARAS COMUNES */

.p3d-box-face {
    position:absolute;
    display:flex;
    align-items:center;
    justify-content:center;

    box-sizing:border-box;

    border:1.5px solid rgba(0,0,0,.35);
    backface-visibility:hidden;

    overflow:hidden;

    font-size:8px;
    font-weight:800;

    text-align:center;

    user-select:none;
}

/* FRENTE */

.p3d-box-front {
    transform-style:preserve-3d;
}

/* PARTE TRASERA */

.p3d-box-back {
    transform-style:preserve-3d;
}

/* DERECHA */

.p3d-box-right {
    transform-style:preserve-3d;
}

/* IZQUIERDA */

.p3d-box-left {
    transform-style:preserve-3d;
}

/* ARRIBA */

.p3d-box-top {
    transform-style:preserve-3d;
}

/* ABAJO */

.p3d-box-bottom {
    transform-style:preserve-3d;
}

.p3d-face {
    position:absolute;
    display:flex;
    align-items:center;
    justify-content:center;
    box-sizing:border-box;
    border:2px solid;
    backface-visibility:hidden;
    overflow:hidden;
    font-size:8px;
    font-weight:800;
    text-align:center;
    padding:3px;
}

/* FRENTE */
.p3d-front {
    transform:
        translateZ(
            calc(var(--box-depth, 55px) / 2)
        );
}

/* ATRÁS */
.p3d-back {
    transform:
        rotateY(180deg)
        translateZ(
            calc(var(--box-depth, 55px) / 2)
        );
}

/* DERECHA */
.p3d-right {
    transform:
        rotateY(90deg)
        translateZ(
            calc(var(--box-width, 75px) / 2)
        );
    transform-origin:center center;
}

/* IZQUIERDA */
.p3d-left {
    transform:
        rotateY(-90deg)
        translateZ(
            calc(var(--box-width, 75px) / 2)
        );
    transform-origin:center center;
}

/* ARRIBA */
.p3d-top {
    transform:
        rotateX(90deg)
        translateZ(
            calc(var(--box-height, 18px) / 2)
        );
}

/* ABAJO */
.p3d-bottom {
    transform:
        rotateX(-90deg)
        translateZ(
            calc(var(--box-height, 18px) / 2)
        );
}

.p3d-product-group {
    position:absolute;
    transform-style:preserve-3d;
    cursor:grab;
    user-select:none;
    transition:filter .15s;
}

.p3d-product-group.dragging {
    cursor:grabbing;
}

.p3d-product-group:hover {
    filter:brightness(1.05);
}
/*
|--------------------------------------------------------------------------
| PANEL DE EDICIÓN
|--------------------------------------------------------------------------
*/

.p3d-edit-box {
    margin-top:10px;

    padding:10px;

    background:#f8fafc;

    border:1px solid #dbe3ee;

    border-radius:8px;
}

.p3d-edit-title {
    font-size:10px;

    font-weight:800;

    color:#334155;

    margin-bottom:8px;

    text-transform:uppercase;
}

.p3d-edit-row {
    display:grid;

    grid-template-columns:1fr auto;

    gap:7px;

    align-items:center;

    margin-bottom:7px;
}

.p3d-edit-row label {
    font-size:10px;

    color:#64748b;
}

.p3d-edit-row strong {
    font-size:10px;

    color:#0f172a;
}

.p3d-edit-row input[type="range"] {
    grid-column:1 / -1;

    width:100%;
}

/* Panel lateral */

.p3d-panel {
    background:#fff;
    border-left:1px solid #e2e8f0;
    overflow-y:auto;
    padding:15px;
}

.p3d-panel-title {
    font-size:12px;
    font-weight:800;
    color:#334155;
    margin-bottom:10px;
}

.p3d-product-row {
    border:1px solid #e2e8f0;
    border-radius:8px;
    padding:9px;
    margin-bottom:7px;
    cursor:pointer;
    transition:.15s;
}

.p3d-product-row:hover,
.p3d-product-row.selected {
    border-color:#2563eb;
    background:#eff6ff;
}

.p3d-product-name {
    font-size:11px;
    font-weight:700;
    color:#1e293b;
}

.p3d-product-meta {
    font-size:10px;
    color:#64748b;
    margin-top:3px;
}

.p3d-controls {
    margin-top:14px;
    border-top:1px solid #e2e8f0;
    padding-top:12px;
}

.p3d-control-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:10px;
    color:#64748b;
    margin-bottom:7px;
}

.p3d-control-row strong {
    color:#1e293b;
}

.p3d-range {
    width:100%;
}

.p3d-help {
    margin-top:12px;
    padding:8px;
    background:#f8fafc;
    border:1px dashed #cbd5e1;
    border-radius:6px;
    font-size:9px;
    color:#64748b;
    line-height:1.5;
}

/* ══════════════════════════════════════════════════════════
   CONTROL DE LA ORDEN · rediseño ERP (prefijo oc-)
   Todo es aditivo: no pisa las clases anteriores.
══════════════════════════════════════════════════════════ */
.oc{
    --oc-navy:#1e3a5f; --oc-blue:#2563eb; --oc-blue-soft:#eaf1ff;
    --oc-green:#16a34a; --oc-green-soft:#dcfce7;
    --oc-orange:#f59e0b; --oc-orange-soft:#fef3c7;
    --oc-red:#dc2626; --oc-red-soft:#fee2e2;
    --oc-text:#0f172a; --oc-muted:#64748b; --oc-line:#e2e8f0; --oc-bg:#f8fafc;
    --oc-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
    color:var(--oc-text);
}
.oc-i{width:16px;height:16px;flex-shrink:0;}
.oc-num{font-family:var(--oc-mono);font-variant-numeric:tabular-nums;}

/* Cabecera */
.oc-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px;}
.oc-head-l{display:flex;align-items:center;gap:12px;}
.oc-back{width:42px;height:42px;border-radius:10px;border:1px solid var(--oc-line);background:#fff;display:inline-flex;align-items:center;justify-content:center;color:var(--oc-navy);cursor:pointer;text-decoration:none;}
.oc-back .oc-i{width:18px;height:18px;}
.oc-title{font-size:22px;font-weight:800;color:var(--oc-navy);line-height:1.1;margin:0;}
.oc-sub{font-size:13px;color:var(--oc-muted);margin-top:3px;}
.oc-head-r{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.oc-btn{display:inline-flex;align-items:center;gap:7px;padding:9px 14px;border:1px solid var(--oc-line);background:#fff;color:var(--oc-blue);border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;font-family:inherit;transition:background .15s,border-color .15s;}
.oc-btn:hover{background:#f1f5ff;border-color:#bfd2ff;}
.oc-btn.is-off{opacity:.45;cursor:not-allowed;}
.oc-btn.is-off:hover{background:#fff;border-color:var(--oc-line);}
.oc-btn.sq{padding:9px 11px;}

/* Dropdowns */
.oc-dd{position:relative;}
.oc-dd-menu{display:none;position:absolute;right:0;top:calc(100% + 6px);min-width:230px;background:#fff;border:1px solid var(--oc-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.14);padding:8px;z-index:50;}
.oc-dd.open .oc-dd-menu{display:block;}
.oc-dd-item{display:flex;align-items:center;gap:9px;width:100%;padding:9px 10px;border:none;background:none;border-radius:7px;font-size:13px;color:#1e293b;cursor:pointer;text-decoration:none;font-family:inherit;text-align:left;}
.oc-dd-item:hover{background:#f1f5f9;}
.oc-dd-lbl{display:block;font-size:11px;font-weight:700;color:var(--oc-muted);text-transform:uppercase;letter-spacing:.04em;margin:6px 2px 4px;}
.oc-dd-sel{width:100%;padding:8px 10px;border:1px solid var(--oc-line);border-radius:8px;font-size:13px;background:#fff;font-family:inherit;}

/* Tarjetas */
.oc-card{background:#fff;border:1px solid var(--oc-line);border-radius:14px;padding:16px 18px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.oc-card-t{font-size:15px;font-weight:800;margin:0 0 12px;display:flex;justify-content:space-between;align-items:center;gap:8px;}
.oc-link{font-size:12px;font-weight:600;color:var(--oc-blue);background:var(--oc-blue-soft);border:none;border-radius:7px;padding:5px 10px;cursor:pointer;font-family:inherit;}
.oc-top{display:grid;grid-template-columns:1.35fr 1fr 1.7fr;gap:14px;margin-bottom:14px;}
@media(max-width:1200px){.oc-top{grid-template-columns:1fr 1fr;}.oc-top > :nth-child(3){grid-column:1/-1;}}
@media(max-width:760px){.oc-top{grid-template-columns:1fr;}}
.oc-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 11px;border-radius:99px;font-size:12px;font-weight:700;}

/* Tarjeta de la orden */
.oc-ord-id{display:flex;align-items:center;gap:12px;margin-bottom:14px;flex-wrap:wrap;}
.oc-ord-ic{width:58px;height:58px;border-radius:12px;background:var(--oc-blue-soft);color:var(--oc-blue);display:flex;align-items:center;justify-content:center;}
.oc-ord-ic .oc-i{width:26px;height:26px;}
.oc-ord-num{font-size:26px;font-weight:800;color:var(--oc-navy);font-family:var(--oc-mono);letter-spacing:-.5px;}
.oc-meta{display:grid;grid-template-columns:repeat(4,auto);gap:14px;justify-content:space-between;}
@media(max-width:560px){.oc-meta{grid-template-columns:1fr 1fr;}}
.oc-meta label{display:block;font-size:11px;color:var(--oc-muted);margin-bottom:3px;}
.oc-meta b{font-size:13px;font-weight:600;}
.oc-obs{margin-top:14px;border:1px solid var(--oc-line);border-radius:10px;padding:10px 12px;background:var(--oc-bg);display:flex;gap:10px;align-items:center;color:var(--oc-muted);}
.oc-obs small{display:block;font-size:11px;}
.oc-obs span{font-size:13px;color:#334155;}

/* Donut */
.oc-donut-wrap{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
.oc-donut{position:relative;width:132px;height:132px;flex-shrink:0;}
.oc-donut svg{transform:rotate(-90deg);}
.oc-donut-c{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;}
.oc-donut-c b{font-size:24px;font-weight:800;font-family:var(--oc-mono);}
.oc-donut-c small{font-size:11px;color:var(--oc-muted);}
.oc-leg{flex:1;min-width:150px;display:flex;flex-direction:column;gap:8px;}
.oc-leg-r{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:#475569;}
.oc-leg-r i{display:inline-block;width:9px;height:9px;border-radius:50%;margin-right:8px;}
.oc-leg-r b{font-family:var(--oc-mono);color:var(--oc-text);}
.oc-leg-tot{border-top:1px solid var(--oc-line);padding-top:8px;}

/* Paletas */
.oc-pals{display:grid;grid-template-columns:repeat(auto-fill,minmax(112px,1fr));gap:10px;}
.oc-pal-card{border:1px solid var(--oc-line);border-radius:12px;padding:10px 8px;text-align:center;cursor:pointer;position:relative;background:#fff;transition:transform .15s,box-shadow .15s;user-select:none;}
.oc-pal-card:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(15,23,42,.1);}
.oc-pal-card.paleta-llena{opacity:.9;}
.oc-pal-ic{color:#334155;display:flex;justify-content:center;margin-bottom:4px;}
.oc-pal-ic .oc-i{width:26px;height:26px;}
.oc-pal-n{font-size:16px;font-weight:800;font-family:var(--oc-mono);}
.oc-pal-st{display:block;margin:6px 0 4px;padding:3px 0;border-radius:6px;font-size:12px;font-weight:700;}
.oc-pal-cj{font-size:12px;color:#475569;}
.oc-pal-it{font-size:10px;color:#94a3b8;margin-top:2px;}
.oc-pal-bar{height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;margin-top:7px;}
.oc-pal-bar > div{height:100%;border-radius:99px;}
.oc-pal-new{border:2px dashed #cbd5e1;border-radius:12px;color:var(--oc-blue);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;font-weight:700;font-size:13px;cursor:pointer;background:#fbfdff;min-height:130px;font-family:inherit;}
.oc-pal-new:hover{background:#f1f5ff;border-color:#93b4ff;}
.oc-pal-new .oc-i{width:26px;height:26px;}
.oc-pal-sin{display:flex;align-items:center;justify-content:space-between;background:#fff8f0;border:1px dashed #fed7aa;border-radius:8px;padding:8px 12px;font-size:12px;color:#92400e;margin-top:10px;cursor:pointer;}
.oc-pal-sin:hover{background:#fef3e2;}

/* Escáner */
.oc-scan{display:flex;align-items:center;gap:14px;background:var(--oc-navy);border-radius:12px;padding:10px 16px;margin-bottom:14px;}
.oc-scan .scanner-label{margin:0 0 4px;}
.oc-scan-hint{font-size:10px;color:#93a4bd;text-align:right;white-space:nowrap;}
@media(max-width:560px){.oc-scan-hint{display:none;}}

/* Panel de acciones (importar / agregar) */
.oc-accpanel{display:none;grid-template-columns:1fr 1.6fr;gap:14px;margin-bottom:14px;}
.oc-accpanel.open{display:grid;}
@media(max-width:900px){.oc-accpanel.open{grid-template-columns:1fr;}}

/* Tarjeta de tabla + tabs */
.oc-main{background:#fff;border:1px solid var(--oc-line);border-radius:14px;overflow:hidden;margin-bottom:14px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
.oc-tabsbar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;border-bottom:1px solid var(--oc-line);padding:0 14px;}
.oc-tabs{display:flex;gap:4px;flex-wrap:wrap;}
.oc-tab{background:none;border:none;padding:15px 14px;font-size:13px;font-weight:600;color:var(--oc-muted);cursor:pointer;display:inline-flex;gap:8px;align-items:center;border-bottom:3px solid transparent;margin-bottom:-1px;font-family:inherit;}
.oc-tab.on{color:var(--oc-blue);border-bottom-color:var(--oc-blue);}
.oc-tools{display:flex;gap:8px;align-items:center;flex-wrap:wrap;padding:8px 0;}
.oc-search{position:relative;}
.oc-search .oc-i{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;}
.oc-search input{padding:9px 12px 9px 34px;border:1px solid var(--oc-line);border-radius:9px;font-size:13px;width:260px;max-width:100%;outline:none;font-family:inherit;}
.oc-search input:focus{border-color:var(--oc-blue);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.oc-pane{display:none;}
.oc-pane.on{display:block;}
.oc-scroll{overflow-x:auto;}
.oc-count{padding:8px 16px;font-size:11px;color:var(--oc-muted);border-top:1px solid var(--oc-line);background:var(--oc-bg);}

/* Tabla */
.oc-tbl{width:100%;min-width:1480px;border-collapse:separate;border-spacing:0;font-size:12.5px;}
.oc-tbl th{background:#f1f5f9;color:#334155;font-size:11.5px;font-weight:700;text-align:left;padding:10px;white-space:nowrap;}
.oc-tbl td{padding:9px 10px;border-bottom:1px solid #eef2f7;vertical-align:middle;}
.oc-tbl tr.oc-row:hover td{background:#fafcff;}
.oc-tbl .c{text-align:center;}
.oc-prod{display:flex;align-items:center;gap:10px;min-width:200px;}
.oc-thumb{width:42px;height:42px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:20px;flex-shrink:0;}
.oc-thumb img{width:100%;height:100%;object-fit:cover;}
.oc-pname{font-weight:700;font-size:13px;color:var(--oc-text);}
.oc-pmarca{font-size:11px;color:var(--oc-muted);}
.oc-av{display:flex;align-items:center;gap:8px;min-width:140px;}
.oc-av-bar{flex:1;height:7px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
.oc-av-bar > div{height:100%;border-radius:99px;}
.oc-av b{font-family:var(--oc-mono);font-size:12px;min-width:38px;text-align:right;}
.oc-pal{display:inline-block;padding:3px 9px;border-radius:7px;background:var(--oc-blue-soft);color:var(--oc-blue);font-weight:700;font-size:12px;font-family:var(--oc-mono);}
.oc-dash{color:#94a3b8;}
.oc-octos-imgs{display:flex;align-items:center;justify-content:center;gap:4px;flex-wrap:wrap;min-width:72px;max-width:105px;}
.oc-oct-img{width:38px;height:38px;object-fit:contain;display:block;border-radius:3px;}
.oc-oct{width:38px;height:38px;background:#111;color:#fff;clip-path:polygon(30% 0,70% 0,100% 30%,100% 70%,70% 100%,30% 100%,0 70%,0 30%);display:inline-flex;flex-direction:column;align-items:center;justify-content:center;font-size:6.5px;font-weight:800;line-height:1.1;text-align:center;margin-right:3px;}
.oc-ult{font-size:12px;line-height:1.35;}
.oc-ult small{color:var(--oc-muted);display:block;}
.oc-acts{display:flex;gap:6px;align-items:center;}
.oc-acts form{display:inline;margin:0;}
.oc-ic{width:34px;height:34px;border:1px solid var(--oc-line);background:#fff;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;color:var(--oc-blue);padding:0;}
.oc-ic:hover{background:#f1f5ff;}
.oc-ic.del{color:var(--oc-red);border-color:#fecaca;background:#fff5f5;}
.oc-ic.del:hover{background:#fee2e2;}
.oc-vacio{display:none;text-align:center;padding:26px;color:var(--oc-muted);font-size:13px;}

/* Fila expandible (info + formulario original de edición) */
.oc-detail{display:none;}
.oc-detail.open{display:table-row;}
.oc-detail > td{background:#f8fafc;padding:14px 16px !important;border-bottom:1px solid var(--oc-line);}
.oc-panel{display:grid;grid-template-columns:270px 1fr;gap:18px;align-items:start;}
@media(max-width:980px){.oc-panel{grid-template-columns:1fr;}}
.oc-form{display:grid;grid-template-columns:1fr 150px 150px 130px;gap:12px;align-items:end;}
@media(max-width:1100px){.oc-form{grid-template-columns:1fr 1fr;}.oc-form .fields-box{grid-column:1/-1;}}
.oc-form .fields-box{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;background:transparent;padding:0;}
@media(max-width:700px){.oc-form .fields-box{grid-template-columns:1fr 1fr;}}
.oc-form .field-row{display:contents;}
.oc-form hr.dv{display:none;}
.oc-form > div[style*="margin-top"]{margin-top:0 !important;}
.oc-form .btn-row-prod{margin-top:0 !important;}

/* Historial / documentos */
.oc-simple{width:100%;border-collapse:collapse;font-size:13px;}
.oc-simple th{background:#f1f5f9;text-align:left;padding:10px 14px;font-size:11.5px;color:#334155;}
.oc-simple td{padding:10px 14px;border-bottom:1px solid #eef2f7;}
.oc-docs{padding:16px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;}

/* Inferior */
.oc-bottom{display:grid;grid-template-columns:1.25fr 1fr 1fr;gap:14px;}
@media(max-width:1200px){.oc-bottom{grid-template-columns:1fr 1fr;}.oc-bottom > :first-child{grid-column:1/-1;}}
@media(max-width:760px){.oc-bottom{grid-template-columns:1fr;}}
.oc-acc{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;}
@media(max-width:700px){.oc-acc{grid-template-columns:1fr 1fr;}}
.oc-tile{display:flex;align-items:center;gap:10px;padding:13px 14px;border-radius:10px;border:none;text-align:left;cursor:pointer;text-decoration:none;font-family:inherit;min-height:62px;}
.oc-tile .oc-i{width:26px;height:26px;}
.oc-tile b{display:block;font-size:13px;font-weight:700;}
.oc-tile small{display:block;font-size:11.5px;opacity:.8;margin-top:1px;}
.oc-tile.is-off{opacity:.5;cursor:not-allowed;}
.t-blue{background:#2563eb;color:#fff;}
.t-green{background:#dcfce7;color:#15803d;}
.t-purple{background:#ede9fe;color:#6d28d9;}
.t-orange{background:#fef3c7;color:#b45309;}
.t-sky{background:#e0ecff;color:#1d4ed8;}
.t-gray{background:#f1f5f9;color:#334155;}
.oc-kpi4{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;}
@media(max-width:560px){.oc-kpi4{grid-template-columns:1fr 1fr;}}
.oc-k{border:1px solid var(--oc-line);border-radius:12px;padding:12px 6px;text-align:center;}
.oc-k-ic{width:38px;height:38px;border-radius:50%;margin:0 auto 6px;display:flex;align-items:center;justify-content:center;font-weight:800;}
.oc-k b{display:block;font-size:20px;font-weight:800;font-family:var(--oc-mono);}
.oc-k small{font-size:11px;color:var(--oc-muted);}
.oc-fin{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-top:12px;padding:10px 12px;background:var(--oc-bg);border-radius:10px;font-size:12px;color:var(--oc-muted);}
.oc-fin b{color:var(--oc-text);font-family:var(--oc-mono);}
.oc-fin .tot b{color:#15803d;font-size:14px;}
.oc-info{display:grid;grid-template-columns:1fr 1fr;}
@media(max-width:560px){.oc-info{grid-template-columns:1fr;}}
.oc-info > div{display:flex;justify-content:space-between;gap:8px;padding:10px 8px;border-bottom:1px solid #eef2f7;font-size:12.5px;}
.oc-info span{color:var(--oc-muted);}
.oc-info b{font-weight:600;text-align:right;}

/* =========================================================
   DISTAN — CONTROL DE LA ORDEN
   Integración con layouts.app / sidebar existente
   No crea un segundo menú ni una segunda "ventana" de aplicación.
   ========================================================= */
html, body {
    margin: 0 !important;
    padding: 0 !important;
}

#mainContent.main-content {
    width: auto !important;
    max-width: none !important;
    padding: 0 !important;
    overflow-x: hidden;
}

#mainContent.main-content > .pg {
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    padding: 20px 22px 30px !important;
    min-height: 100vh !important;
    background: #f1f5f9 !important;
}

/* El contenido interno es el que debe tener límites visuales,
   no el layout completo. */
#mainContent .oc-head,
#mainContent .oc-top,
#mainContent .oc-main,
#mainContent .oc-bottom,
#mainContent .oc-actions,
#mainContent .oc-info,
#mainContent .oc-wrap-inner {
    max-width: none;
}

/* La tabla ocupa todo el ancho disponible y se desplaza horizontalmente
   solo cuando la pantalla realmente no alcanza. */
#mainContent .oc-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

#mainContent .oc-tbl {
    width: 100%;
    min-width: 1180px;
}

/* Evita que cards del layout de la aplicación se aniden dentro de la vista. */
#mainContent .pg > .card,
#mainContent .pg > .container,
#mainContent .pg > .max-w-7xl {
    max-width: none !important;
}

/* Responsive */
@media (max-width: 1100px) {
    #mainContent.main-content > .pg {
        padding: 16px !important;
    }
}

@media (max-width: 768px) {
    #mainContent.main-content > .pg {
        padding: 12px 10px 24px !important;
    }
}


/* ─────────────── RESPONSABLE DE ARMADO ─────────────── */
.oc-armado-card{
    background:#fff;
    border:1px solid #dbe5f0;
    border-radius:14px;
    margin:0 0 14px;
    padding:12px 15px;
    display:flex;
    align-items:center;
    gap:12px;
    box-shadow:0 1px 2px rgba(15,23,42,.04);
}
.oc-armado-icon{
    width:42px;
    height:42px;
    border-radius:11px;
    display:grid;
    place-items:center;
    background:#eff6ff;
    font-size:20px;
    flex:0 0 auto;
}
.oc-armado-body{min-width:0;flex:1;}
.oc-armado-label{
    font-size:9px;
    color:#64748b;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.05em;
}
.oc-armado-name{
    color:#0f172a;
    font-size:14px;
    font-weight:850;
    margin-top:2px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
.oc-armado-name.muted{color:#94a3b8;}
.oc-armado-help{
    font-size:10px;
    color:#94a3b8;
    margin-top:2px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
.oc-armado-status{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    color:#475569;
    border-radius:999px;
    padding:6px 10px;
    font-size:10px;
    font-weight:800;
    white-space:nowrap;
}
.oc-armador-cell{min-width:125px;}
.oc-persona{
    display:inline-flex;
    align-items:center;
    gap:5px;
    color:#334155;
    font-size:10px;
    font-weight:700;
    max-width:145px;
}
.oc-persona-icon{font-size:12px;}
@media(max-width:700px){
    .oc-armado-card{align-items:flex-start;}
    .oc-armado-status{margin-left:auto;}
}
@media(max-width:520px){
    .oc-armado-card{flex-wrap:wrap;}
    .oc-armado-status{width:100%;text-align:center;}
}


.oc-back-orders{
    display:inline-flex !important;
    align-items:center;
    gap:7px;
    text-decoration:none !important;
    white-space:nowrap;
}
.oc-back-orders span{
    font-size:11px;
    font-weight:800;
    color:#334155;
}
.oc-back-orders:hover{
    border-color:#93c5fd !important;
    background:#eff6ff !important;
    color:#2563eb !important;
}
@media(max-width:600px){
    .oc-back-orders span{display:inline;}
}

</style>

<div class="pg">

{{-- ── Datos base (SIN CAMBIOS respecto al original) ── --}}
@php
    $estadoColor = $order->estado === 'COMPLETO' ? '#15803d'
        : ($order->estado === 'PARCIAL' ? '#b45309' : '#b91c1c');
    $totalItems = $order->details->count();
    $armadoresOrden = $order->details
        ->pluck('personal_despacho')
        ->filter(fn($nombre) => trim((string) $nombre) !== '')
        ->map(fn($nombre) => trim((string) $nombre))
        ->unique()
        ->values();
    $armadorPrincipal = $armadoresOrden->count() === 1 ? $armadoresOrden->first() : null;

    $completados = $order->details->where('estado_item','COMPLETO')->count();
    $faltantes = $totalItems - $completados;
    $porcentaje = $totalItems > 0 ? round(($completados / $totalItems) * 100) : 0;
    $progColor = $porcentaje === 100 ? '#22c55e' : ($porcentaje > 40 ? '#f59e0b' : '#ef4444');

    // ── Preparar datos de paletas para el mapa ──────────────────────────
    $paletas = $order->details
        ->filter(fn($d) => !empty($d->paleta))
        ->groupBy('paleta')
        ->sortKeys();

    $sinPaleta = $order->details->filter(fn($d) => empty($d->paleta));

    // ── Límite de ítems por paleta ──────────────────────────────────────
    $paletaMax = 10;
    $paletaCounts = $paletas->map->count();
@endphp

{{-- ── Datos adicionales para el rediseño (solo lectura, no tocan lógica) ── --}}
@php
    // Rutas opcionales: si las defines, los botones se activan solos.
    // Ej: $ocRutaEtiquetas = route('orders.etiquetas', $order);
    $ocRutaEtiquetas = null;
    $ocRutaGuia      = null;

    $ocFecha = fn($v, $f = 'd/m/Y') => $v ? \Carbon\Carbon::parse($v)->format($f) : '—';
    $ocN     = fn($n) => rtrim(rtrim(number_format((float) $n, 2, '.', ''), '0'), '.');

    $ocParciales  = $order->details->where('estado_item','PARCIAL')->count();
    $ocPendientes = max($totalItems - $completados - $ocParciales, 0);

    $ocSumSol  = (float) $order->details->sum('cantidad_solicitada');
    $ocSumDesp = (float) $order->details->sum('cantidad_despachada');
    $ocSumPend = max($ocSumSol - $ocSumDesp, 0);
    $ocAvance  = $ocSumSol > 0 ? round(($ocSumDesp / $ocSumSol) * 100, 1) : 0;

    $ocMaxNum = $paletas->keys()->map(fn($k) => (int) preg_replace('/\D/', '', (string) $k))->max() ?? 0;
    $ocSiguientePaleta = 'P' . str_pad($ocMaxNum + 1, 2, '0', STR_PAD_LEFT);
    $ocPrimeroSinPaleta = $sinPaleta->first()?->id;

    $ocObs = $order->observaciones ?? $order->observacion ?? null;

    $ocOctLabel = function ($k) {
        $k = mb_strtolower((string) $k);
        if (str_contains($k, 'azuc') || str_contains($k, 'azúc')) return ['ALTO EN', 'AZÚCAR'];
        if (str_contains($k, 'sod'))                              return ['ALTO EN', 'SODIO'];
        if (str_contains($k, 'satur'))                            return ['ALTO EN', 'GRAS.SAT.'];
        if (str_contains($k, 'trans'))                            return ['ALTO EN', 'GRAS.TRANS'];
        return ['', mb_strtoupper(mb_substr($k, 0, 10))];
    };

    $ocCsvRows = $order->details->map(function ($d) {
        $v = $d->fecha_vencimiento ?? ($d->product->fecha_vencimiento ?? null);
        return [
            $d->product->sku ?? '',
            $d->product->nombre ?? '',
            (float) $d->cantidad_solicitada,
            (float) $d->cantidad_despachada,
            max((float) $d->cantidad_solicitada - (float) $d->cantidad_despachada, 0),
            $d->lote ?? '',
            $v ? \Carbon\Carbon::parse($v)->format('d/m/Y') : '',
            $d->paleta ?? '',
            round((float) $d->cantidad_despachada * (float) $d->precio_unitario, 2),
        ];
    })->values();
@endphp

{{-- Iconos (sprite) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
    <symbol id="oc-back" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></symbol>
    <symbol id="oc-file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
    <symbol id="oc-printer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></symbol>
    <symbol id="oc-truck" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></symbol>
    <symbol id="oc-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></symbol>
    <symbol id="oc-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></symbol>
    <symbol id="oc-dots" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="19" cy="12" r="1.8"/></symbol>
    <symbol id="oc-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 1.98-1.7L23 6H6"/></symbol>
    <symbol id="oc-grid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></symbol>
    <symbol id="oc-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
    <symbol id="oc-box" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
    <symbol id="oc-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></symbol>
    <symbol id="oc-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
    <symbol id="oc-history" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/><polyline points="12 7 12 12 15 14"/></symbol>
    <symbol id="oc-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
    <symbol id="oc-filter" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></symbol>
    <symbol id="oc-sliders" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></symbol>
    <symbol id="oc-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="oc-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.83 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></symbol>
    <symbol id="oc-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></symbol>
    <symbol id="oc-scan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><line x1="7" y1="12" x2="17" y2="12"/></symbol>
</defs></svg>

<div class="oc">

{{-- LOADER PROFESIONAL AISLADO: no intercepta enlaces ni clicks globales --}}
<style>
#distanOrderLoader{display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;background:rgba(248,250,252,.72);backdrop-filter:blur(2px);pointer-events:none}
#distanOrderLoader.is-active{display:flex;pointer-events:auto}
.distan-loader-card{width:min(330px,90vw);padding:26px 24px;background:#fff;border:1px solid #e2e8f0;border-radius:18px;box-shadow:0 20px 55px rgba(15,23,42,.16);text-align:center}
.distan-cart-wrap{position:relative;width:64px;height:64px;margin:0 auto 14px;display:flex;align-items:center;justify-content:center}
.distan-cart{width:48px;height:48px;color:#2563eb;animation:distanCartFloat 1.2s ease-in-out infinite}
.distan-spinner{position:absolute;inset:0;border:3px solid #dbeafe;border-top-color:#2563eb;border-radius:50%;animation:distanSpin .85s linear infinite}
.distan-loader-title{font-size:15px;font-weight:800;color:#0f172a}.distan-loader-text{margin-top:5px;font-size:12px;color:#64748b}
.distan-dots span{display:inline-block;animation:distanDots 1.2s infinite;margin-left:2px}.distan-dots span:nth-child(2){animation-delay:.15s}.distan-dots span:nth-child(3){animation-delay:.3s}
@keyframes distanSpin{to{transform:rotate(360deg)}}@keyframes distanCartFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-3px)}}@keyframes distanDots{0%,60%,100%{opacity:.2}30%{opacity:1}}
</style>
<div id="distanOrderLoader" aria-hidden="true">
  <div class="distan-loader-card">
    <div class="distan-cart-wrap"><div class="distan-spinner"></div><svg class="distan-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 1.9-1.4L21 8H6"/><path d="M10 9.5l1.8 1.8L15 8.1"/></svg></div>
    <div class="distan-loader-title" id="distanOrderLoaderTitle">Procesando...</div>
    <div class="distan-loader-text">Espera un momento<span class="distan-dots"><span>.</span><span>.</span><span>.</span></span></div>
  </div>
</div>
<script>
(function(){
  window.distanShowOrderLoader=function(title){const l=document.getElementById('distanOrderLoader'),t=document.getElementById('distanOrderLoaderTitle');if(!l)return;if(t)t.textContent=title||'Procesando...';l.classList.add('is-active');l.setAttribute('aria-hidden','false')};
  window.distanHideOrderLoader=function(){const l=document.getElementById('distanOrderLoader');if(!l)return;l.classList.remove('is-active');l.setAttribute('aria-hidden','true')};
  document.querySelectorAll('form.distan-loader-form').forEach(function(f){f.addEventListener('submit',function(){window.distanShowOrderLoader(f.dataset.loaderTitle)})});
})();
</script>


{{-- ══════════ CABECERA ══════════ --}}
<div class="oc-head">
            <h1 class="oc-title">Control de la orden</h1>
            <div class="oc-sub">Gestiona los productos, despachos y paletas de la orden</div>
        </div>
    </div>
    <div class="oc-head-r">
        <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="oc-btn"><svg class="oc-i"><use href="#oc-file"/></svg> Ver PDF</a>

        @if($ocRutaEtiquetas)
            <a href="{{ $ocRutaEtiquetas }}" target="_blank" class="oc-btn"><svg class="oc-i"><use href="#oc-printer"/></svg> Imprimir etiquetas</a>
        @else
            <button type="button" class="oc-btn is-off" disabled title="Ruta de impresión masiva sin configurar"><svg class="oc-i"><use href="#oc-printer"/></svg> Imprimir etiquetas</button>
        @endif

        @if($ocRutaGuia)
            <a href="{{ $ocRutaGuia }}" class="oc-btn"><svg class="oc-i"><use href="#oc-truck"/></svg> Generar guía</a>
        @else
            <button type="button" class="oc-btn is-off" disabled title="Ruta de guía sin configurar"><svg class="oc-i"><use href="#oc-truck"/></svg> Generar guía</button>
        @endif

        <div class="oc-dd" id="ddExport">
            <button type="button" class="oc-btn" onclick="ocDD('ddExport',event)"><svg class="oc-i"><use href="#oc-file"/></svg> Exportar <svg class="oc-i"><use href="#oc-chev"/></svg></button>
            <div class="oc-dd-menu" onclick="event.stopPropagation()">
                <button type="button" class="oc-dd-item" onclick="ocExportCSV()"><svg class="oc-i"><use href="#oc-download"/></svg> Excel (CSV)</button>
                <a href="{{ route('orders.pdf',$order) }}" class="oc-dd-item"><svg class="oc-i"><use href="#oc-download"/></svg> PDF (descargar)</a>
            </div>
        </div>

        <div class="oc-dd" id="ddMas">
            <button type="button" class="oc-btn sq" onclick="ocDD('ddMas',event)" title="Más opciones"><svg class="oc-i"><use href="#oc-dots"/></svg></button>
            <div class="oc-dd-menu" onclick="event.stopPropagation()">
                <button type="button" class="oc-dd-item" onclick="abrirResumenOrden()"><svg class="oc-i"><use href="#oc-file"/></svg> Ver orden (resumen)</button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════ FILA SUPERIOR: ORDEN · AVANCE · PALETAS ══════════ --}}
<div class="oc-top">

    {{-- Datos de la orden --}}
    <div class="oc-card">
        <div class="oc-ord-id">
            <div class="oc-ord-ic"><svg class="oc-i"><use href="#oc-cart"/></svg></div>
            <div class="oc-ord-num">{{ $order->numero_orden }}</div>
            <span class="oc-chip" style="background:{{ $estadoColor }};color:#fff;">{{ $order->estado }}</span>
        </div>
        <div class="oc-meta">
            <div><label>Cliente</label><b>{{ $order->client?->razon_social ?? '—' }}</b></div>
            <div><label>Tipo de orden</label>
                <b><span class="oc-chip" style="background:#dcfce7;color:#15803d;padding:2px 9px;">{{ $order->tipo_orden ?? '—' }}</span></b></div>
            <div><label>Fecha de pedido</label><b class="oc-num">{{ $ocFecha($order->fecha_pedido) }}</b></div>
            <div><label>Fecha de entrega</label><b class="oc-num">{{ $ocFecha($order->fecha_entrega ?? null) }}</b></div>
        </div>
        <div class="oc-obs">
            <svg class="oc-i" style="width:22px;height:22px;"><use href="#oc-file"/></svg>
            <div><small>Observaciones</small><span>{{ $ocObs ?: 'Sin observaciones' }}</span></div>
        </div>
    </div>

    {{-- Avance --}}
    <div class="oc-card">
        <h3 class="oc-card-t">Avance de la orden</h3>
        <div class="oc-donut-wrap">
            <div class="oc-donut">
                <svg width="132" height="132" viewBox="0 0 132 132">
                    <circle cx="66" cy="66" r="52" fill="none" stroke="#e5e7eb" stroke-width="13"/>
                    <circle cx="66" cy="66" r="52" fill="none" stroke="{{ $progColor }}" stroke-width="13" stroke-linecap="round"
                            stroke-dasharray="{{ round($porcentaje * 3.2673, 1) }} 326.73"/>
                </svg>
                <div class="oc-donut-c"><b>{{ $porcentaje }}%</b><small>Progreso general</small></div>
            </div>
            <div class="oc-leg">
                <div class="oc-leg-r"><span><i style="background:#22c55e;"></i>Completados</span><b>{{ $completados }}</b></div>
                <div class="oc-leg-r"><span><i style="background:#2563eb;"></i>En proceso</span><b>{{ $ocParciales }}</b></div>
                <div class="oc-leg-r"><span><i style="background:#f59e0b;"></i>Pendientes</span><b>{{ $ocPendientes }}</b></div>
                <div class="oc-leg-r oc-leg-tot"><span>Total de productos</span><b>{{ $totalItems }}</b></div>
            </div>
        </div>
    </div>

    {{-- Paletas (mismo abrirPaleta() del mapa original) --}}
    <div class="oc-card" id="ocPaletas">
        <h3 class="oc-card-t">Paletas de la orden
            <span style="font-size:11px;color:var(--oc-muted);font-weight:500;">{{ $paletas->count() }} paleta{{ $paletas->count() !== 1 ? 's' : '' }} · clic para ver detalle</span>
        </h3>

        <div class="oc-pals">
            @foreach($paletas as $nombrePaleta => $items)
                @php
                    $totUds = $items->sum('cantidad_solicitada');
                    $despUds = $items->sum('cantidad_despachada');
                    $pesoKg = $items->sum(fn($i) => ($i->product->peso ?? 0) * $i->cantidad_solicitada / 1000);
                    $pctP = $totUds > 0 ? round(($despUds / $totUds) * 100) : 0;
                    $todoC = $items->every(fn($i) => $i->estado_item === 'COMPLETO');
                    $algunP = $items->contains(fn($i) => $i->estado_item === 'PARCIAL');
                    $fillColor= $todoC ? '#22c55e' : ($algunP ? '#f59e0b' : '#ef4444');
                    $llena = $items->count() >= $paletaMax;

                    $cajasSolP = $items->sum(function ($i) { $c = $i->product->cantidad_por_caja ?? 1; return $c > 0 ? ceil($i->cantidad_solicitada / $c) : 0; });
                    $cajasDespP = $items->sum(function ($i) { $c = $i->product->cantidad_por_caja ?? 1; return $c > 0 ? floor($i->cantidad_despachada / $c) : 0; });

                    if ($todoC)               { $stTxt = 'Completa';   $stBg = '#dcfce7'; $stCl = '#15803d'; $barC = '#22c55e'; }
                    elseif ($despUds > 0)     { $stTxt = 'En proceso'; $stBg = '#e0ecff'; $stCl = '#1d4ed8'; $barC = '#2563eb'; }
                    else                      { $stTxt = 'Pendiente';  $stBg = '#fef3c7'; $stCl = '#b45309'; $barC = '#f59e0b'; }

                    // Serializar items para el modal
                    $itemsJson = $items->map(fn($i) => [
                        'nombre' => $i->product->nombre ?? 'Producto',
                        'sku' => $i->product->sku ?? '',
                        'solicitada' => $i->cantidad_solicitada,
                        'despachada' => $i->cantidad_despachada,
                        'estado' => $i->estado_item,
                        'precio' => $i->precio_unitario,
                        'subtotal' => $i->subtotal,
                        'peso' => number_format(($i->product->peso ?? 0) / 1000, 3),
                        'cantidad_por_caja' => $i->product->cantidad_por_caja ?? 1,
                        'barcode' => $i->product->barcode,
                        'box_barcode' => $i->product->box_barcode,
                    ])->values()->toJson();
                @endphp

                <div class="oc-pal-card {{ $llena ? 'paleta-llena' : '' }}"
                    onclick="abrirPaleta({{ json_encode($nombrePaleta) }}, {{ $items->count() }}, {{ $totUds }}, {{ $despUds }}, {{ round($pesoKg,1) }}, {{ $pctP }}, {{ json_encode($fillColor) }}, {{ $itemsJson }})">
                    @if($llena)
                        <span class="paleta-box-full-badge">LLENA</span>
                    @endif
                    <div class="oc-pal-ic"><svg class="oc-i"><use href="#oc-grid"/></svg></div>
                    <div class="oc-pal-n">{{ $nombrePaleta }}</div>
                    <span class="oc-pal-st" style="background:{{ $stBg }};color:{{ $stCl }};">{{ $stTxt }}</span>
                    <div class="oc-pal-cj oc-num">{{ $todoC ? $cajasSolP.' cajas' : $cajasDespP.' / '.$cajasSolP.' cajas' }}</div>
                    <div class="oc-pal-it">{{ $items->count() }}/{{ $paletaMax }} ítem{{ $items->count() > 1 ? 's' : '' }}</div>
                    <div class="oc-pal-bar"><div style="width:{{ $pctP }}%;background:{{ $barC }};"></div></div>
                </div>
            @endforeach

            <button type="button" class="oc-pal-new" id="ocNuevaPaleta"
                    data-next="{{ $ocSiguientePaleta }}" data-first-sin="{{ $ocPrimeroSinPaleta }}"
                    onclick="ocNuevaPaleta()">
                <svg class="oc-i"><use href="#oc-plus"/></svg>
                Nueva paleta
            </button>
        </div>

        {{-- Sin paleta --}}
        @if($sinPaleta->count())
            @php
                $spJson = $sinPaleta->map(fn($i) => [
                    'nombre' => $i->product->nombre ?? 'Producto',
                    'sku' => $i->product->sku ?? '',
                    'solicitada' => $i->cantidad_solicitada,
                    'despachada' => $i->cantidad_despachada,
                    'estado' => $i->estado_item,
                    'precio' => $i->precio_unitario,
                    'subtotal' => $i->subtotal,
                    'peso' => number_format(($i->product->peso ?? 0) / 1000, 3),
                    'cantidad_por_caja' => $i->product->cantidad_por_caja ?? 1,
                    'barcode' => $i->product->barcode,
                    'box_barcode' => $i->product->box_barcode,
                ])->values()->toJson();
            @endphp
            <div class="oc-pal-sin"
                onclick="abrirPaleta('Sin paleta', {{ $sinPaleta->count() }}, {{ $sinPaleta->sum('cantidad_solicitada') }}, {{ $sinPaleta->sum('cantidad_despachada') }}, 0, 0, '#94a3b8', {{ $spJson }})">
                <span>⚠️ Sin paleta asignada</span>
                <span style="font-weight:700;">{{ $sinPaleta->count() }} ítem{{ $sinPaleta->count() > 1 ? 's' : '' }} →</span>
            </div>
        @endif
    </div>
</div>

{{-- ══════════ ESCÁNER (mismo id="scanner") ══════════ --}}
<div class="oc-scan">
    <div style="width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse 1.5s infinite;"></div>
    <div style="flex:1;">
        <div class="scanner-label">📡 Escanear código de barras</div>
        <input type="text" id="scanner" class="scanner-input" placeholder="Escanea o escribe el código...">
    </div>
    <div class="oc-scan-hint">Enter para<br>confirmar</div>
</div>

{{-- ══════════ IMPORTAR / AGREGAR (formularios originales, se abren desde "Acciones") ══════════ --}}
<div class="oc-accpanel" id="ocAccPanel">
    {{-- Importar CSV --}}
    <div class="section-card">
        <div class="sec-title">📄 Importar pedido CSV</div>
        <form action="{{ route('orders.import',$order) }}" method="POST" enctype="multipart/form-data" class="distan-loader-form" data-loader-title="Importando productos...">
            @csrf
            <div class="import-row">
                <label class="file-label">
                    📎 Seleccionar archivo .csv
                    <input type="file" name="archivo" accept=".csv" required style="display:none;">
                </label>
                <button type="submit" class="btn btn-green">Importar</button>
            </div>
        </form>
    </div>

    {{-- Agregar producto --}}
    <div class="section-card">
        <div class="sec-title">➕ Agregar producto</div>
        <form method="POST" action="{{ route('orders.addProduct',$order) }}" class="distan-loader-form" data-loader-title="Agregando producto...">
            @csrf
            <div class="add-grid">
                <div>
                    <label class="flabel">Producto</label>
                    <select name="product_id" class="finput" required>
                        <option value="">Seleccionar producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->nombre }}</option>
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
                <button type="submit" class="btn btn-red" style="align-self:end;">Agregar</button>
            </div>
        </form>
    </div>
</div>

{{-- ─────────────── ARMADO DE LA ORDEN ─────────────── --}}
<div class="oc-armado-card" id="ocArmadoresResumen">
    <div class="oc-armado-icon">👤</div>
    <div class="oc-armado-body">
        <div class="oc-armado-label">Personal que armó la orden</div>
        @if($armadoresOrden->count() === 0)
            <div class="oc-armado-name muted">Aún no registrado</div>
            <div class="oc-armado-help">Se mostrará cuando se registre un despacho.</div>
        @elseif($armadoresOrden->count() === 1)
            <div class="oc-armado-name">{{ $armadorPrincipal }}</div>
            <div class="oc-armado-help">Responsable registrado en los productos despachados.</div>
        @else
            <div class="oc-armado-name">{{ $armadoresOrden->count() }} personas</div>
            <div class="oc-armado-help">{{ $armadoresOrden->implode(' · ') }}</div>
        @endif
    </div>
    <div class="oc-armado-status">
        <span>{{ $completados }} / {{ $totalItems }} productos completos</span>
    </div>
</div>

{{-- ══════════ TARJETA PRINCIPAL: TABS + TABLA ══════════ --}}
<div class="oc-main">

    <div class="oc-tabsbar">
        <div class="oc-tabs">
            <button type="button" class="oc-tab on" onclick="ocTab('productos',this)"><svg class="oc-i"><use href="#oc-box"/></svg> Productos de la orden</button>
            <button type="button" class="oc-tab" onclick="ocTab('historial',this)"><svg class="oc-i"><use href="#oc-history"/></svg> Historial de despachos</button>
            <button type="button" class="oc-tab" onclick="ocTab('documentos',this)"><svg class="oc-i"><use href="#oc-file"/></svg> Documentos</button>
        </div>

        <div class="oc-tools" id="ocTools">
            <div class="oc-search">
                <svg class="oc-i"><use href="#oc-search"/></svg>
                <input type="text" id="ocBuscar" placeholder="Buscar producto, SKU o lote..." oninput="ocFiltrar()">
            </div>

            <div class="oc-dd" id="ddFiltros">
                <button type="button" class="oc-btn" style="color:#334155;" onclick="ocDD('ddFiltros',event)"><svg class="oc-i"><use href="#oc-filter"/></svg> Filtros</button>
                <div class="oc-dd-menu" onclick="event.stopPropagation()">
                    <span class="oc-dd-lbl">Estado</span>
                    <select id="ocFEstado" class="oc-dd-sel" onchange="ocFiltrar()">
                        <option value="">Todos</option>
                        <option value="COMPLETO">Completo</option>
                        <option value="PARCIAL">Parcial</option>
                        <option value="INCOMPLETO">Incompleto</option>
                    </select>
                    <span class="oc-dd-lbl">Paleta</span>
                    <select id="ocFPaleta" class="oc-dd-sel" onchange="ocFiltrar()">
                        <option value="">Todas</option>
                        @foreach($paletas->keys() as $kp)
                            <option value="{{ strtoupper($kp) }}">{{ $kp }}</option>
                        @endforeach
                        <option value="__SIN__">Sin paleta</option>
                    </select>
                    <button type="button" class="oc-dd-item" style="margin-top:6px;color:var(--oc-blue);" onclick="ocLimpiar()">Limpiar filtros</button>
                </div>
            </div>

            <button type="button" class="oc-btn" style="color:#334155;" onclick="ocTogglePanel()"><svg class="oc-i"><use href="#oc-sliders"/></svg> Acciones <svg class="oc-i"><use href="#oc-chev"/></svg></button>
        </div>
    </div>

    {{-- ─── PANE: PRODUCTOS ─── --}}
    <div class="oc-pane on" data-pane="productos">
        <div class="oc-scroll">
            <table class="oc-tbl" id="ocTabla">
                <thead>
                    <tr>
                        <th style="width:34px;">#</th>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th class="c">Solicitado</th>
                        <th class="c">Despachado</th>
                        <th class="c">Pendiente</th>
                        <th>Avance</th>
                        <th>Lote</th>
                        <th>Vencimiento</th>
                        <th>Octógonos</th>
                        <th class="c">Paleta</th>
                        <th>Ubicación</th>
                        <th>Últ. despacho</th>
                        <th>Armó</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($order->details as $detail)
                    @php
                        $s = $detail->estado_item;
                        $bc = $s === 'COMPLETO' ? '#22c55e' : ($s === 'PARCIAL' ? '#f59e0b' : '#ef4444');
                        $sc = $s === 'COMPLETO' ? '#15803d' : ($s === 'PARCIAL' ? '#b45309' : '#b91c1c');
                        $pct = $detail->cantidad_solicitada > 0
                            ? round(($detail->cantidad_despachada / $detail->cantidad_solicitada) * 100)
                            : 0;

                        $cpc = $detail->product->cantidad_por_caja ?? 1;
                        $cajasDesp = $cpc > 0 ? floor($detail->cantidad_despachada / $cpc) : 0;
                        $cajasSol = $cpc > 0 ? ceil($detail->cantidad_solicitada / $cpc) : 0;
                        $unidSueltas = $cpc > 0 ? ($detail->cantidad_despachada % $cpc) : 0;

                        $ocSol  = (float) $detail->cantidad_solicitada;
                        $ocDesp = (float) $detail->cantidad_despachada;
                        $ocPend = max($ocSol - $ocDesp, 0);

                        $ocVenc = $detail->fecha_vencimiento ?? ($detail->product->fecha_vencimiento ?? null);
                        $ocVencado = $ocVenc && \Carbon\Carbon::parse($ocVenc)->isPast();

                        $ocImg = $detail->product->imagen ?? $detail->product->image ?? $detail->product->foto ?? null;
                        if ($ocImg && is_string($ocImg) && !preg_match('#^(https?:)?//#', $ocImg)) {
                            $ocImg = asset('storage/' . ltrim($ocImg, '/'));
                        }

                        // Los octógonos se guardan en el mismo campo que usa la vista Products:
                        // products.advertencias = "AZUCAR,SODIO,GRASAS"
                        $ocOcts = array_values(array_filter(array_map(
                            'trim',
                            explode(',', strtoupper((string) ($detail->product->advertencias ?? '')))
                        )));

                        $ocUbic = $detail->ubicacion ?? ($detail->product->ubicacion ?? null);
                        $ocUlt  = $ocDesp > 0 ? $detail->updated_at : null;
                    @endphp

                    <tr class="oc-row"
                        id="producto-{{ $detail->product->barcode }}"
                        data-barcode="{{ $detail->product->barcode }}"
                        data-box-barcode="{{ $detail->product->box_barcode }}"
                        data-estado="{{ $s }}"
                        data-paleta="{{ $detail->paleta }}"
                        data-search="{{ mb_strtolower(($detail->product->nombre ?? '').' '.($detail->product->sku ?? '').' '.($detail->lote ?? '').' '.($detail->product->barcode ?? '')) }}">

                        <td class="oc-num">{{ $loop->iteration }}</td>

                        <td>
                            <div class="oc-prod">
                                <div class="oc-thumb">@if($ocImg)<img src="{{ $ocImg }}" alt="" loading="lazy" onerror="this.replaceWith(document.createTextNode('📦'))">@else 📦 @endif</div>
                                <div>
                                    <div class="oc-pname">{{ $detail->product->nombre }}</div>
                                    @if(!empty($detail->product->marca))<div class="oc-pmarca">Marca: {{ $detail->product->marca }}</div>@endif
                                </div>
                            </div>
                        </td>

                        <td class="oc-num" style="color:#64748b;">{{ $detail->product->sku }}</td>
                        <td class="c oc-num" style="font-weight:700;">{{ $ocN($ocSol) }}</td>
                        <td class="c oc-num" style="font-weight:700;color:{{ $s === 'COMPLETO' ? '#16a34a' : '#0f172a' }};">{{ $ocN($ocDesp) }}</td>
                        <td class="c oc-num" style="font-weight:700;color:{{ $ocPend > 0 ? '#f59e0b' : '#16a34a' }};">{{ $ocN($ocPend) }}</td>

                        <td>
                            <div class="oc-av">
                                <div class="oc-av-bar"><div style="width:{{ min($pct,100) }}%;background:{{ $bc }};"></div></div>
                                <b style="color:{{ $sc }};">{{ $pct }}%</b>
                            </div>
                        </td>

                        <td class="oc-num">{{ $detail->lote ?: '—' }}</td>
                        <td class="oc-num" @if($ocVencado) style="color:#dc2626;font-weight:700;" title="Vencido" @endif>{{ $ocFecha($ocVenc) }}</td>

                        <td>
                            <div class="oc-octos-imgs">
                                @forelse($ocOcts as $o)
                                    @php
                                        $oNorm = mb_strtolower(trim((string) $o));
                                        $lb = $ocOctLabel($o);

                                        $octImg = null;
                                        if (in_array('AZUCAR', $ocOcts, true) && $oNorm === 'azucar') {
                                            $octImg = 'https://pbs.twimg.com/media/F-6D6zQWEAMPN7d.png';
                                        } elseif (in_array('SODIO', $ocOcts, true) && $oNorm === 'sodio') {
                                            $octImg = 'https://blogs.ucontinental.edu.pe/wp-content/uploads/2019/06/Octogono-sodio.png';
                                        } elseif ($oNorm === 'grasas') {
                                            $octImg = 'https://dolcezzaperu.pe/wp-content/uploads/2023/06/MicrosoftTeams-image-2.png';
                                        }
                                    @endphp

                                    @if($octImg)
                                        <img
                                            src="{{ $octImg }}"
                                            class="oc-oct-img"
                                            alt="{{ trim($lb[0].' '.$lb[1]) }}"
                                            title="{{ trim($lb[0].' '.$lb[1]) }}"
                                            loading="lazy"
                                            onerror="this.style.display='none'"
                                        >
                                    @else
                                        <span class="oc-oct" title="{{ trim($lb[0].' '.$lb[1]) }}"><span>{{ $lb[0] }}</span><span>{{ $lb[1] }}</span></span>
                                    @endif
                                @empty
                                    <span class="oc-dash">–</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="c">@if($detail->paleta)<span class="oc-pal">{{ $detail->paleta }}</span>@else<span class="oc-dash">—</span>@endif</td>
                        <td class="oc-num">{{ $ocUbic ?: '—' }}</td>

                        <td>
                            @if($ocUlt)
                                <div class="oc-ult oc-num">{{ $ocUlt->format('d/m H:i') }}</div>
                            @else
                                <span class="oc-dash">—</span>
                            @endif
                        </td>

                        <td class="oc-armador-cell">
                            @if(trim((string)($detail->personal_despacho ?? '')) !== '')
                                <span class="oc-persona">
                                    <span class="oc-persona-icon">👤</span>
                                    <span>{{ $detail->personal_despacho }}</span>
                                </span>
                            @else
                                <span class="oc-dash">Sin registrar</span>
                            @endif
                        </td>

                        <td class="oc-num" style="font-weight:700;white-space:nowrap;">S/ {{ number_format($detail->cantidad_despachada * $detail->precio_unitario,2) }}</td>

                        <td>
                            <div class="oc-acts">
                                <button type="button" class="oc-ic" title="Ver detalle" onclick="ocToggle({{ $detail->id }})"><svg class="oc-i"><use href="#oc-eye"/></svg></button>
                                <button type="button" class="oc-ic" title="Editar" onclick="ocEditar({{ $detail->id }})"><svg class="oc-i"><use href="#oc-edit"/></svg></button>
                                <button type="button" class="oc-ic" title="Generar etiqueta"
                                    onclick="abrirEtiqueta({
                                        detailId: {{ $detail->id }},
                                        nombre: {{ Js::from($detail->product->nombre) }},
                                        cantidadPorCaja: {{ (int) ($detail->product->cantidad_por_caja ?? 1) }},
                                        codigo: {{ Js::from(
                                            in_array(strtoupper(trim($order->client->razon_social ?? '')), [
                                                'HIPERMERCADOS TOTTUS ORIENTE SAC',
                                                'HIPERMERCADOS TOTTUS S.A',
                                            ], true)
                                                ? ($detail->product->barcode ?? '')
                                                : ($detail->product->box_barcode ?? '')
                                        ) }},
                                        lote: {{ Js::from($detail->lote ?? '') }},
                                        fecha: {{ Js::from($detail->fecha_vencimiento
                                            ? \Carbon\Carbon::parse($detail->fecha_vencimiento)->format('d/m/Y')
                                            : ($detail->product->fecha_vencimiento
                                                ? \Carbon\Carbon::parse($detail->product->fecha_vencimiento)->format('d/m/Y')
                                                : '')) }},
                                        cantidadDespachada: {{ (float) $detail->cantidad_despachada }}
                                    })"><svg class="oc-i"><use href="#oc-printer"/></svg></button>

                                <form method="POST" action="{{ route('orders.details.destroy',$detail) }}" class="distan-loader-form" data-loader-title="Eliminando producto..."
                                    onsubmit="return confirm('¿Eliminar {{ $detail->product->nombre }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="oc-ic del" title="Eliminar"><svg class="oc-i"><use href="#oc-trash"/></svg></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Fila expandible: info del producto + formulario original de edición --}}
                    <tr class="oc-detail" id="oc-det-{{ $detail->id }}">
                        <td colspan="16">
                            <div class="oc-panel">

                                <div class="info-strip oc-info-grid">
                                    <div class="info-item oc-info-card">
                                        <span>📦 Stock</span>
                                        <span class="info-val">{{ $detail->product->stock }}</span>
                                    </div>

                                    <div class="info-item oc-info-card">
                                        <span>⚖ Peso</span>
                                        <span class="info-val">{{ number_format($detail->product->peso/1000,3) }} kg</span>
                                    </div>

                                    <div class="info-item oc-info-card">
                                        <span>🗃 Cajas solicitadas</span>
                                        <span class="info-val" style="color:#2563eb;">
                                            {{ $cajasSol }} caja{{ $cajasSol !== 1 ? 's' : '' }}
                                        </span>
                                        <small>({{ $detail->cantidad_solicitada }} u · {{ $cpc }} u/caja)</small>
                                    </div>

                                    <div class="info-item oc-info-card">
                                        <span>✅ Cajas despachadas</span>
                                        <span class="info-val" style="color:{{ $bc }};">
                                            {{ $cajasDesp }} caja{{ $cajasDesp !== 1 ? 's' : '' }}
                                        </span>
                                        @if($unidSueltas > 0)
                                            <small class="oc-extra-units">+ {{ $unidSueltas }} u. sueltas</small>
                                        @endif
                                    </div>

                                    <div class="info-item oc-info-progress">
                                        <span>Despacho</span>
                                        <div class="prog-mini">
                                            <div class="prog-mini-fill" style="width:{{ $pct }}%;background:{{ $bc }};"></div>
                                        </div>
                                        <strong style="color:{{ $sc }};">{{ $pct }}%</strong>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('orders.updateDetail',$detail) }}"
                                    class="distan-loader-form oc-form"
                                    data-loader-title="Guardando cambios..."
                                    data-detail-form
                                    data-original-paleta="{{ $detail->paleta }}">
                                    @csrf @method('PUT')

                                    <div class="fields-box oc-fields-grid">
                                        <div>
                                            <label class="flabel">Solicitado</label>
                                            <input type="number" step="0.01" name="cantidad_solicitada" class="finput" value="{{ $detail->cantidad_solicitada }}">
                                        </div>

                                        <div>
                                            <label class="flabel">Despachado</label>
                                            <input type="number" step="0.01" name="cantidad_despachada" id="despachado-{{ $detail->product->barcode }}" class="finput" value="{{ $detail->cantidad_despachada }}">
                                        </div>

                                        <div>
                                            <label class="flabel">Precio</label>
                                            <input type="number" step="0.01" name="precio_unitario" class="finput" value="{{ $detail->precio_unitario }}">
                                        </div>

                                        <div>
                                            <label class="flabel">Lote</label>
                                            <input type="text" name="lote" class="finput" value="{{ $detail->lote }}" placeholder="Lote">
                                        </div>

                                        <div>
                                            <label class="flabel">Vencimiento</label>
                                            <input type="date" name="fecha_vencimiento" class="finput" value="{{ $detail->fecha_vencimiento ?? $detail->product->fecha_vencimiento }}">
                                        </div>

                                        <div>
                                            <label class="flabel">Paleta</label>
                                            <input type="text" name="paleta" class="finput paleta-input"
                                                value="{{ $detail->paleta }}" placeholder="P01"
                                                oninput="this.value=this.value.toUpperCase()">
                                        </div>

                                        <div class="oc-form-subtotal">
                                            <span>Subtotal</span>
                                            <strong>S/ {{ number_format($detail->cantidad_despachada * $detail->precio_unitario,2) }}</strong>
                                        </div>

                                        <div class="oc-form-save">
                                            <button type="submit" class="btn btn-blue">💾 Guardar cambios</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="oc-vacio" id="ocVacio">No hay productos que coincidan con la búsqueda o los filtros.</div>
        <div class="oc-count"><span id="ocContador">{{ $totalItems }} de {{ $totalItems }}</span> productos</div>
    </div>

    {{-- ─── PANE: HISTORIAL (último despacho por producto, con datos existentes) ─── --}}
    <div class="oc-pane" data-pane="historial">
        <div class="oc-scroll">
            <table class="oc-simple">
                <thead><tr><th>Fecha / hora</th><th>Producto</th><th>SKU</th><th>Despachado</th><th>Paleta</th></tr></thead>
                <tbody>
                @forelse($order->details->filter(fn($d) => $d->cantidad_despachada > 0)->sortByDesc('updated_at') as $h)
                    <tr>
                        <td class="oc-num">{{ $h->updated_at ? $h->updated_at->format('d/m/Y H:i') : '—' }}</td>
                        <td style="font-weight:600;">{{ $h->product->nombre ?? 'Producto' }}</td>
                        <td class="oc-num" style="color:#64748b;">{{ $h->product->sku ?? '' }}</td>
                        <td class="oc-num" style="font-weight:700;">{{ $ocN($h->cantidad_despachada) }} <span style="color:#94a3b8;font-weight:400;">/ {{ $ocN($h->cantidad_solicitada) }}</span></td>
                        <td>@if($h->paleta)<span class="oc-pal">{{ $h->paleta }}</span>@else<span class="oc-dash">—</span>@endif</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:26px;">Aún no hay despachos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="oc-count">Muestra la última actualización de despacho de cada producto.</div>
    </div>

    {{-- ─── PANE: DOCUMENTOS ─── --}}
    <div class="oc-pane" data-pane="documentos">
        <div class="oc-docs">
            <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="oc-tile t-orange">
                <svg class="oc-i"><use href="#oc-file"/></svg>
                <span><b>Orden de pedido (PDF)</b><small>{{ $order->numero_orden }}</small></span>
            </a>
            <button type="button" class="oc-tile t-gray" onclick="abrirResumenOrden()">
                <svg class="oc-i"><use href="#oc-file"/></svg>
                <span><b>Resumen de armado</b><small>Estado de cada producto</small></span>
            </button>
        </div>
    </div>

</div>{{-- /.oc-main --}}

{{-- ══════════ INFERIOR: ACCIONES · RESUMEN · INFO ══════════ --}}
<div class="oc-bottom">

    <div class="oc-card">
        <h3 class="oc-card-t">Acciones principales</h3>
        <div class="oc-acc">
            <button type="button" class="oc-tile t-blue" onclick="ocIrEscaner()">
                <svg class="oc-i"><use href="#oc-truck"/></svg>
                <span><b>Registrar despacho</b><small>Ingresar cantidades</small></span>
            </button>

            @if($ocRutaEtiquetas)
                <a href="{{ $ocRutaEtiquetas }}" target="_blank" class="oc-tile t-green">
            @else
                <button type="button" class="oc-tile t-green is-off" disabled title="Ruta de impresión masiva sin configurar">
            @endif
                <svg class="oc-i"><use href="#oc-printer"/></svg>
                <span><b>Imprimir etiquetas</b><small>Etiquetas por paleta o producto</small></span>
            @if($ocRutaEtiquetas) </a> @else </button> @endif

            <button type="button" class="oc-tile t-purple" onclick="document.getElementById('ocPaletas').scrollIntoView({behavior:'smooth',block:'center'})">
                <svg class="oc-i"><use href="#oc-grid"/></svg>
                <span><b>Gestionar paletas</b><small>Crear o editar paletas</small></span>
            </button>

            <a href="{{ route('orders.pdf',$order) }}" target="_blank" class="oc-tile t-orange">
                <svg class="oc-i"><use href="#oc-file"/></svg>
                <span><b>Ver/Descargar PDF</b><small>Orden de pedido</small></span>
            </a>

            @if($ocRutaGuia)
                <a href="{{ $ocRutaGuia }}" class="oc-tile t-sky">
            @else
                <button type="button" class="oc-tile t-sky is-off" disabled title="Ruta de guía sin configurar">
            @endif
                <svg class="oc-i"><use href="#oc-truck"/></svg>
                <span><b>Generar guía</b><small>Documento de transporte</small></span>
            @if($ocRutaGuia) </a> @else </button> @endif

            <button type="button" class="oc-tile t-gray" onclick="ocExportCSV()">
                <svg class="oc-i"><use href="#oc-file"/></svg>
                <span><b>Exportar</b><small>Excel (CSV)</small></span>
            </button>
        </div>
    </div>

    <div class="oc-card">
        <h3 class="oc-card-t">Resumen de la orden</h3>
        <div class="oc-kpi4">
            <div class="oc-k"><div class="oc-k-ic" style="background:#eaf1ff;color:#2563eb;"><svg class="oc-i" style="width:20px;height:20px;"><use href="#oc-box"/></svg></div><b>{{ $ocN($ocSumSol) }}</b><small>Solicitado total</small></div>
            <div class="oc-k"><div class="oc-k-ic" style="background:#dcfce7;color:#16a34a;"><svg class="oc-i" style="width:20px;height:20px;"><use href="#oc-check"/></svg></div><b>{{ $ocN($ocSumDesp) }}</b><small>Despachado</small></div>
            <div class="oc-k"><div class="oc-k-ic" style="background:#fef3c7;color:#d97706;"><svg class="oc-i" style="width:20px;height:20px;"><use href="#oc-clock"/></svg></div><b>{{ $ocN($ocSumPend) }}</b><small>Pendiente</small></div>
            <div class="oc-k"><div class="oc-k-ic" style="background:#eaf1ff;color:#2563eb;">%</div><b>{{ $ocAvance }}%</b><small>Avance general</small></div>
        </div>
        <div class="oc-fin">
            <span>Subtotal <b>S/ {{ number_format($order->subtotal,2) }}</b></span>
            <span>IGV (18%) <b>S/ {{ number_format($order->igv,2) }}</b></span>
            <span class="tot">Total <b>S/ {{ number_format($order->total,2) }}</b></span>
        </div>
    </div>

    <div class="oc-card">
        <h3 class="oc-card-t">Información adicional</h3>
        <div class="oc-info">
            <div><span>Creado por</span><b>{{ $order->user->name ?? $order->creado_por ?? '—' }}</b></div>
            <div><span>Estado</span><b><span class="oc-chip" style="background:{{ $estadoColor }}1a;color:{{ $estadoColor }};padding:2px 10px;">{{ $order->estado }}</span></b></div>
            <div><span>Fecha de creación</span><b class="oc-num">{{ $ocFecha($order->created_at ?? null, 'd/m/Y H:i') }}</b></div>
            <div><span>Prioridad</span><b>{{ $order->prioridad ?? 'Normal' }}</b></div>
            <div><span>Última actualización</span><b class="oc-num">{{ $ocFecha($order->updated_at ?? null, 'd/m/Y H:i') }}</b></div>
            <div><span>Almacén de salida</span><b>{{ $order->almacen ?? $order->almacen_salida ?? '—' }}</b></div>
        </div>
    </div>

</div>{{-- /.oc-bottom --}}

</div>{{-- /.oc --}}
</div>{{-- /.pg --}}

{{-- ══════════════════════════════
     MODAL DETALLE DE PALETA
══════════════════════════════ --}}
<div class="pm-overlay" id="pmOverlay" onclick="cerrarPaleta(event)">
    <div class="pm-modal">
        <div class="pm-header">
            <div>
                <div class="pm-title" id="pmTitle"></div>
                <div class="pm-sub" id="pmSub"></div>
            </div>
            <button class="pm-close" onclick="document.getElementById('pmOverlay').classList.remove('open')">✕</button>
        </div>
        <div class="pm-body">

            {{-- Mini KPIs --}}
            <div class="pm-kpis">
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Ítems</div>
                    <div class="pm-kpi-val" id="pmItems"></div>
                </div>
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Unidades</div>
                    <div class="pm-kpi-val" id="pmUds"></div>
                </div>
                <div class="pm-kpi">
                    <div class="pm-kpi-label">Peso total</div>
                    <div class="pm-kpi-val" id="pmPeso"></div>
                </div>
            </div>

            {{-- Progreso --}}
            <div class="pm-prog-wrap">
                <div class="pm-prog-hdr">
                    <span>Progreso de despacho</span>
                    <span id="pmPct" style="font-weight:700;"></span>
                </div>
                <div class="pm-prog-bar">
                    <div class="pm-prog-fill" id="pmProgFill"></div>
                </div>
                <div style="font-size:10px;color:#94a3b8;margin-top:3px;" id="pmProgSub"></div>
            </div>

            {{-- Lista de productos --}}
            <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Productos en esta paleta</div>
            <div id="pmItemsList"></div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════
     MODAL ETIQUETA DE PRODUCTO
══════════════════════════════ --}}
<div class="et-overlay" id="etOverlay" onclick="cerrarEtiqueta(event)">
    <div class="et-modal" onclick="event.stopPropagation()">
        <div class="et-label" id="etLabel">
            <div class="et-nombre" id="etNombre"></div>
            <div class="et-cpc" id="etCpc"></div>
            <svg id="etBarcode"></svg>
            <div class="et-info">
                <div>Lote: <span id="etLote"></span></div>
                <div>Fecha: <span id="etFecha"></span></div>
                <div>Cajas: <span id="etCajas"></span></div>
                <div>Unidades: <span id="etUnidades"></span></div>
            </div>
        </div>
        <div class="et-actions" data-etiqueta-url-template="{{ route('orders.details.etiqueta', ['item' => '__ID__']) }}">
            <a id="etPdfLink" href="#" target="_blank" class="btn btn-gray">🖨 Generar PDF</a>
            <button type="button" class="btn btn-gray" onclick="document.getElementById('etOverlay').classList.remove('open')">Cerrar</button>
        </div>
    </div>
</div>
<div id="modalResumenOrden"
     style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.55);
        z-index:9999;
        align-items:center;
        justify-content:center;
        padding:20px;
     ">

    <div style="
        background:#fff;
        width:min(1000px, 95vw);
        max-height:90vh;
        border-radius:10px;
        box-shadow:0 20px 50px rgba(0,0,0,.25);
        display:flex;
        flex-direction:column;
        overflow:hidden;
    ">

        {{-- CABECERA --}}
        <div style="
            padding:15px 18px;
            border-bottom:1px solid #e5e7eb;
            display:flex;
            align-items:center;
            justify-content:space-between;
        ">

            <div>
                <div style="
                    font-size:17px;
                    font-weight:800;
                    color:#111827;
                ">
                    📋 Resumen de orden
                </div>

                <div style="
                    font-size:12px;
                    color:#6b7280;
                    margin-top:3px;
                ">
                    Orden #{{ $order->numero_orden }}
                </div>
            </div>

            <button
                type="button"
                onclick="cerrarResumenOrden()"
                style="
                    border:0;
                    background:#f3f4f6;
                    width:32px;
                    height:32px;
                    border-radius:6px;
                    font-size:18px;
                    cursor:pointer;
                ">
                ×
            </button>

        </div>


        {{-- TABLA --}}
        <div style="
            overflow:auto;
            padding:15px;
        ">

            <table style="
                width:100%;
                border-collapse:collapse;
                font-size:12px;
            ">

                <thead>

                    <tr style="
                        background:#f3f4f6;
                        color:#374151;
                    ">

                        <th style="padding:9px;text-align:left;">
                            Código
                        </th>

                        <th style="padding:9px;text-align:left;">
                            Descripción
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Solicitado
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Despachado
                        </th>

                        <th style="padding:9px;text-align:center;">
                            Estado
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($order->details as $detalle)

                        @php
                            $solicitado = (float) ($detalle->cantidad_solicitada ?? 0);
                            $despachado = (float) ($detalle->cantidad_despachada ?? 0);

                            if ($despachado >= $solicitado && $solicitado > 0) {
                                $estado = 'ARMADO';
                                $estadoColor = '#166534';
                                $estadoBg = '#dcfce7';
                            } elseif ($despachado > 0) {
                                $estado = 'PARCIAL';
                                $estadoColor = '#92400e';
                                $estadoBg = '#fef3c7';
                            } else {
                                $estado = 'NO ARMADO';
                                $estadoColor = '#991b1b';
                                $estadoBg = '#fee2e2';
                            }
                        @endphp

                        <tr style="border-bottom:1px solid #e5e7eb;">

                            {{-- CÓDIGO --}}
                            <td style="
                                padding:9px;
                                font-family:monospace;
                                font-weight:700;
                            ">
                                {{ $detalle->product->sku
                                    ?? $detalle->product->barcode
                                    ?? '—' }}
                            </td>

                            {{-- DESCRIPCIÓN --}}
                            <td style="
                                padding:9px;
                                font-weight:600;
                            ">
                                {{ $detalle->product->nombre ?? 'Producto' }}
                            </td>

                            {{-- SOLICITADO --}}
                            <td style="
                                padding:9px;
                                text-align:center;
                                font-family:monospace;
                            ">
                                {{ number_format($solicitado, 0) }}
                            </td>

                            {{-- DESPACHADO --}}
                            <td style="
                                padding:9px;
                                text-align:center;
                                font-family:monospace;
                                font-weight:700;
                            ">
                                {{ number_format($despachado, 0) }}
                            </td>

                            {{-- ESTADO --}}
                            <td style="
                                padding:9px;
                                text-align:center;
                            ">

                                <span style="
                                    display:inline-block;
                                    padding:4px 8px;
                                    border-radius:999px;
                                    background:{{ $estadoBg }};
                                    color:{{ $estadoColor }};
                                    font-size:10px;
                                    font-weight:800;
                                ">
                                    {{ $estado }}
                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- PIE --}}
        <div style="
            padding:10px 15px;
            border-top:1px solid #e5e7eb;
            text-align:right;
        ">

            <button
                type="button"
                onclick="cerrarResumenOrden()"
                style="
                    padding:7px 14px;
                    border:1px solid #d1d5db;
                    background:#fff;
                    border-radius:6px;
                    cursor:pointer;
                ">
                Cerrar
            </button>

        </div>

    </div>

</div>

{{-- =========================================================
     VISOR 3D DE PALETA
========================================================= --}}

<div
    class="p3d-overlay"
    id="p3dOverlay"
    onclick="cerrarPaleta3D(event)"
>

    <div
        class="p3d-modal"
        onclick="event.stopPropagation()"
    >

        {{-- CABECERA --}}

        <div class="p3d-header">

            <div>

                <div
                    class="p3d-title"
                    id="p3dTitle"
                >
                    🧊 Paleta
                </div>

                <div
                    class="p3d-subtitle"
                    id="p3dSubtitle"
                >
                    Vista 3D
                </div>

            </div>

            <button
                type="button"
                class="p3d-close"
                onclick="cerrarPaleta3D()"
            >
                ✕
            </button>

        </div>


        {{-- CUERPO --}}

        <div class="p3d-body">


            {{-- ESCENARIO --}}

            <div
                class="p3d-stage"
                id="p3dStage"
            >

                <div
                    class="p3d-world"
                    id="p3dWorld"
                >

                    <div
                        class="p3d-pallet"
                        id="p3dPallet"
                    >

                        <div class="p3d-pallet-top"></div>

                        <div class="p3d-pallet-leg l1"></div>
                        <div class="p3d-pallet-leg l2"></div>
                        <div class="p3d-pallet-leg l3"></div>

                    </div>

                </div>

            </div>


            {{-- PANEL --}}

            <div class="p3d-panel">

                <div class="p3d-panel-title">
                    📦 Productos de la paleta
                </div>
<div id="p3dControls" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin:8px 0 10px;padding:9px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:9px;">
                    <label style="font-size:10px;color:#64748b;font-weight:700;">Zoom <span id="p3dZoomValue">85%</span><input id="p3dZoom" type="range" min="50" max="140" value="85" style="width:100%;"></label>
                    <label style="font-size:10px;color:#64748b;font-weight:700;">Inclinación <span id="p3dRotXValue">58°</span><input id="p3dRotX" type="range" min="20" max="80" value="58" style="width:100%;"></label>
                    <label style="font-size:10px;color:#64748b;font-weight:700;">Rotación <span id="p3dRotYValue">-28°</span><input id="p3dRotY" type="range" min="-180" max="180" value="-28" style="width:100%;"></label>
                </div>
            <div id="p3dProducts"></div>

<div id="p3dEditor"></div>

<div
    style="
        margin-top:10px;
        padding:8px;
        background:#eff6ff;
        border:1px dashed #93c5fd;
        border-radius:7px;
        font-size:9px;
        color:#1e40af;
        line-height:1.5;
    "
>
    🖱️ Arrastra un producto hacia la paleta.<br>
    📦 Al soltarlo podrás indicar cuántas cajas colocar.<br>
    🔄 Cada bloque puede moverse, redimensionarse y girarse.
</div>

                </div>

            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
// ── Scanner ──────────────────────────────────────────────────────────────
let scanner = document.getElementById('scanner');
scanner.addEventListener('keydown', function(e){
    if(e.key !== 'Enter') return;
    e.preventDefault();
    let codigo = this.value.trim();
    if(!codigo) return;
    let card = document.querySelector(
        '[data-barcode="' + codigo + '"], [data-box-barcode="' + codigo + '"]');
    if(card){
        card.scrollIntoView({ behavior:'smooth', block:'center' });
        card.style.boxShadow = "0 0 0 3px #2563eb";
        setTimeout(() => { card.style.boxShadow = ""; }, 1500);
        let barcode = card.dataset.barcode;
        let input = document.getElementById('despachado-' + barcode);
        if(input){ input.focus(); input.select(); }
        this.value = '';
        return;
    }
    fetch(`/api/producto/${codigo}`)
        .then(res => res.json())
        .then(producto => {
            if(!producto){ alert('Producto no encontrado'); return; }
            let select = document.querySelector('[name=product_id]');
            select.value = producto.id;
            document.querySelector('[name=precio_unitario]').value = producto.precio ?? 0;
            document.querySelector('[name=cantidad_solicitada]').focus();
        });
    this.value = '';
});

// ── Límite de ítems por paleta ─────────────────────────────────────────
const paletaCounts = {!! $paletaCounts->toJson() !!};
const PALETA_MAX = {{ $paletaMax }};

document.querySelectorAll('form[data-detail-form]').forEach(form => {
    form.addEventListener('submit', function (e) {
        const paletaInput = form.querySelector('[name="paleta"]');
        if (!paletaInput) return;

        const nueva = paletaInput.value.trim().toUpperCase();
        const original = (form.dataset.originalPaleta || '').trim().toUpperCase();

        // Solo valida si está cambiando a una paleta distinta (o asignando una nueva)
        if (nueva && nueva !== original) {
            const countActual = paletaCounts[nueva] || 0;
            if (countActual >= PALETA_MAX) {
                e.preventDefault();
                alert(`⚠️ La paleta ${nueva} ya tiene ${countActual} ítems (máximo ${PALETA_MAX}). No se pueden agregar más productos a esta paleta.`);
            }
        }
    });
});

// ── Modal de paleta ──────────────────────────────────────────────────────
function abrirPaleta(nombre, nItems, totUds, despUds, pesoKg, pct, fillColor, items) {
    document.getElementById('pmTitle').textContent = '🪵 ' + nombre;
    document.getElementById('pmSub').textContent = 'Detalle de contenido · ' + nItems + ' ítem' + (nItems !== 1 ? 's' : '');
    document.getElementById('pmItems').textContent = nItems;
    document.getElementById('pmUds').textContent = totUds;
    document.getElementById('pmPeso').textContent = pesoKg + ' kg';
    document.getElementById('pmPct').textContent = pct + '%';
    document.getElementById('pmPct').style.color = fillColor;
    document.getElementById('pmProgFill').style.width = pct + '%';
    document.getElementById('pmProgFill').style.background = fillColor;
    document.getElementById('pmProgSub').textContent = despUds + ' de ' + totUds + ' unidades despachadas';

    const estadoColors = {
        'COMPLETO' : { bg:'#dcfce7', color:'#15803d', dot:'#22c55e' },
        'PARCIAL' : { bg:'#fef3c7', color:'#b45309', dot:'#f59e0b' },
        'INCOMPLETO': { bg:'#fee2e2', color:'#b91c1c', dot:'#ef4444' },
    };

    let html = '';
    items.forEach(item => {
        const ec = estadoColors[item.estado] ?? { bg:'#f1f5f9', color:'#64748b', dot:'#94a3b8' };
        const itemPct = item.solicitada > 0 ? Math.round((item.despachada / item.solicitada) * 100) : 0;

        // ── Cálculo de cajas ──
        const cpc = item.cantidad_por_caja > 0 ? item.cantidad_por_caja : 1;
        const cajasSol = Math.ceil(item.solicitada / cpc);
        const cajasDesp = Math.floor(item.despachada / cpc);
        const sueltas = item.despachada % cpc;
        const cajasLabel = cajasDesp + ' / ' + cajasSol + ' caja' + (cajasSol !== 1 ? 's' : '');
        const sueltasHtml = sueltas > 0
            ? `<span style="font-size:10px;color:#f59e0b;margin-left:4px;">+${sueltas} u. sueltas</span>`
            : '';

        html += `
        <div class="pm-item">
            <div class="pm-item-dot" style="background:${ec.dot};"></div>
            <div class="pm-item-name">
                <div style="font-weight:600;">${item.nombre}</div>
                <div style="font-size:10px;color:#94a3b8;">
                    ${item.sku ? 'SKU: '+item.sku+' · ' : ''}${item.peso} kg · S/ ${parseFloat(item.precio).toFixed(2)}
                </div>

                {{-- Línea de cajas --}}
                <div style="
                    display:inline-flex;align-items:center;gap:4px;
                    margin-top:3px;
                    background:#eff6ff;border:1px solid #bfdbfe;
                    border-radius:4px;padding:2px 7px;
                    font-size:10px;font-weight:700;color:#1d4ed8;
                ">
                    🗃 ${cajasLabel}
                </div>
                ${sueltasHtml}

                <div style="height:3px;background:#e5e7eb;border-radius:99px;margin-top:5px;overflow:hidden;">
                    <div style="height:100%;width:${itemPct}%;background:${ec.dot};border-radius:99px;"></div>
                </div>
            </div>
            <div class="pm-item-right">
                <div class="pm-item-qty">${item.despachada}/${item.solicitada}</div>
                <span class="pm-item-badge" style="background:${ec.bg};color:${ec.color};">${item.estado}</span>
            </div>
        </div>`;
    });

    // Número de la paleta
    let numeroPaleta = nombre.replace(/\D/g,'');
    if(numeroPaleta === '')
        numeroPaleta = '0';
    numeroPaleta = numeroPaleta.padStart(4,'0');

    // SSCC
    let sscc = '50000014373324' + numeroPaleta;

    // Tabla logística
    let tabla = `
    <hr style="margin:18px 0">
    <h4 style="margin-bottom:10px;">📋 Hoja logística</h4>
    <table style="width:100%;border-collapse:collapse;font-size:11px;">
        <thead>
            <tr style="background:#f1f5f9;">
                <th style="padding:6px;border:1px solid #ddd;">DUM13</th>
                <th style="padding:6px;border:1px solid #ddd;">DUM14</th>
                <th style="padding:6px;border:1px solid #ddd;">DESCRIPCIÓN</th>
                <th style="padding:6px;border:1px solid #ddd;">UXB</th>
                <th style="padding:6px;border:1px solid #ddd;">BULTOS</th>
            </tr>
        </thead>
        <tbody>
    `;

    items.forEach(item=>{
        let bultos = Math.ceil(item.despachada / item.cantidad_por_caja);
        tabla += `
        <tr>
            <td style="border:1px solid #ddd;padding:5px;">${item.barcode}</td>
            <td style="border:1px solid #ddd;padding:5px;">${item.box_barcode}</td>
            <td style="border:1px solid #ddd;padding:5px;">${item.nombre}</td>
            <td style="border:1px solid #ddd;padding:5px;text-align:center;">${item.cantidad_por_caja}</td>
            <td style="border:1px solid #ddd;padding:5px;text-align:center;">${bultos}</td>
        </tr>
        `;
    });

    tabla += `
        </tbody>
    </table>
    <div style="margin-top:18px;text-align:center;">
        <div style="font-size:13px;font-weight:bold;">SSCC</div>
        <div style="font-size:20px;font-weight:bold;letter-spacing:2px;margin-top:6px;">${sscc}</div>
        <div style="display:flex;justify-content:center;margin-top:15px;">
            <svg id="barcode"></svg>
        </div>
    </div>
    `;
    tabla += `
<div style="
    margin-top:20px;
    display:flex;
    flex-direction:column;
    gap:7px;
">

    <a
        href="/orders/{{ $order->id }}/pallet/${encodeURIComponent(nombre)}/pdf"
        target="_blank"
        class="btn btn-blue"
        style="width:100%;"
    >
        🖨 Generar Hoja Logística
    </a>

    <button
        type="button"
        class="btn"
        style="
            width:100%;
            background:#111827;
            color:#fff;
        "
        onclick='abrirPaleta3D(
            ${JSON.stringify(nombre)},
            ${JSON.stringify(items)}
        )'
    >
        🧊 Ver paleta en 3D
    </button>

</div>
`;

    document.getElementById('pmItemsList').innerHTML = html + tabla;

    JsBarcode("#barcode", sscc, {
        format:"CODE128",
        width:2,
        height:60,
        displayValue:true
    });

    document.getElementById('pmOverlay').classList.add('open');
}

function cerrarPaleta(e) {
    if (e.target.id === 'pmOverlay') {
        document.getElementById('pmOverlay').classList.remove('open');
    }
}
// =========================================================
// VISOR 3D DE PALETA — ARMADO MANUAL
// =========================================================

let p3dData = [];
let p3dBlocks = [];

let p3dSelected = null;

let p3dZoom = 85;
let p3dRotX = 58;
let p3dRotY = -28;

let p3dDragging = false;
let p3dStartX = 0;
let p3dStartY = 0;

const PALLET_WIDTH = 520;
const PALLET_DEPTH = 330;
const BOX_GAP = 4;


/**
 * =========================================================
 * ABRIR PALETA
 * =========================================================
 */
function abrirPaleta3D(nombre, items)
{
    p3dData = items || [];

    // La paleta comienza VACÍA
    p3dBlocks = [];

    p3dSelected = null;

    document.getElementById('p3dTitle').textContent =
        '🧊 Paleta ' + nombre;

    document.getElementById('p3dSubtitle').textContent =
        p3dData.length +
        ' producto' +
        (p3dData.length !== 1 ? 's' : '') +
        ' · máximo {{ $paletaMax }} productos';

    document.getElementById('p3dOverlay')
        .classList.add('open');

    document.body.style.overflow = 'hidden';

    p3dZoom = 85;
    p3dRotX = 58;
    p3dRotY = -28;

    document.getElementById('p3dZoom').value = p3dZoom;
    document.getElementById('p3dRotX').value = p3dRotX;
    document.getElementById('p3dRotY').value = p3dRotY;

    renderPaleta3D();
    renderP3dProducts();
    actualizarEditor3D();
    actualizarP3dTransform();
}


/**
 * =========================================================
 * CERRAR
 * =========================================================
 */
function cerrarPaleta3D(event)
{
    if (
        event &&
        event.target &&
        event.target.id !== 'p3dOverlay'
    ) {
        return;
    }

    document.getElementById('p3dOverlay')
        .classList.remove('open');

    document.body.style.overflow = '';
}


/**
 * =========================================================
 * PRODUCTOS DEL PANEL
 * =========================================================
 */
function renderP3dProducts()
{
    const contenedor =
        document.getElementById('p3dProducts');

    if (!contenedor) {
        return;
    }

    contenedor.innerHTML = '';

    p3dData.forEach((item, index) => {

        const cpc =
            Number(item.cantidad_por_caja) > 0
                ? Number(item.cantidad_por_caja)
                : 1;

        const unidades =
            Number(item.despachada || 0);

        const totalCajas =
            Math.ceil(unidades / cpc);

        const colocadas =
            p3dBlocks
                .filter(
                    block =>
                        block.productIndex === index
                )
                .reduce(
                    (total, block) =>
                        total +
                        Number(block.cantidad),
                    0
                );

        const restantes =
            Math.max(
                0,
                totalCajas - colocadas
            );

        const porcentaje =
            totalCajas > 0
                ? Math.min(
                    100,
                    Math.round(
                        (colocadas / totalCajas) * 100
                    )
                )
                : 0;

        const row =
            document.createElement('div');

        row.className =
            'p3d-product-row';

        row.draggable =
            restantes > 0;

        row.innerHTML = `
            <div class="p3d-product-name">
                📦 ${item.nombre}
            </div>

            <div class="p3d-product-meta">
                Cajas totales:
                <strong>
                    ${totalCajas}
                </strong>
            </div>

            <div class="p3d-product-meta">
                Colocadas:
                <strong>
                    ${colocadas}
                </strong>
            </div>

            <div class="p3d-product-meta">
                Restantes:
                <strong
                    style="
                        color:${restantes > 0
                            ? '#2563eb'
                            : '#15803d'};
                    "
                >
                    ${restantes}
                </strong>
            </div>

            <div
                style="
                    width:100%;
                    height:5px;
                    background:#e5e7eb;
                    border-radius:99px;
                    overflow:hidden;
                    margin-top:6px;
                "
            >
                <div
                    style="
                        width:${porcentaje}%;
                        height:100%;
                        background:${porcentaje >= 100
                            ? '#22c55e'
                            : '#2563eb'};
                        border-radius:99px;
                    "
                ></div>
            </div>

            ${
                restantes <= 0
                    ? `
                        <div
                            style="
                                font-size:9px;
                                color:#15803d;
                                font-weight:700;
                                margin-top:5px;
                            "
                        >
                            ✅ COMPLETO
                        </div>
                    `
                    : `
                        <div
                            style="
                                font-size:9px;
                                color:#64748b;
                                margin-top:5px;
                            "
                        >
                            🖱️ Arrastra hacia la paleta
                        </div>
                    `
            }
        `;

        /*
         * ARRRASTRAR PRODUCTO
         */
        row.addEventListener(
            'dragstart',
            function(event)
            {
                if (restantes <= 0) {
                    event.preventDefault();
                    return;
                }

                event.dataTransfer.setData(
                    'text/plain',
                    String(index)
                );

                event.dataTransfer.effectAllowed =
                    'copy';

                row.classList.add(
                    'selected'
                );
            }
        );

        row.addEventListener(
            'dragend',
            function()
            {
                row.classList.remove(
                    'selected'
                );
            }
        );

        /*
         * CLICK = SELECCIONAR
         */
        row.addEventListener(
            'click',
            function()
            {
                seleccionarProducto3D(
                    index
                );
            }
        );

        contenedor.appendChild(row);
    });
}
    
/**
 * =========================================================
 * PALETA COMO ZONA DE DROP
 * =========================================================
 */
const p3dStage =
    document.getElementById('p3dStage');

p3dStage?.addEventListener(
    'dragover',
    function(event)
    {
        event.preventDefault();

        p3dStage.style.outline =
            '3px dashed #2563eb';
    }
);

p3dStage?.addEventListener(
    'dragleave',
    function(event)
    {
        if (
            event.relatedTarget &&
            p3dStage.contains(event.relatedTarget)
        ) {
            return;
        }

        p3dStage.style.outline = '';
    }
);

p3dStage?.addEventListener(
    'drop',
    function(event)
    {
        event.preventDefault();

        p3dStage.style.outline = '';

        const index =
            Number(
                event.dataTransfer.getData(
                    'text/plain'
                )
            );

        if (
            Number.isNaN(index) ||
            !p3dData[index]
        ) {
            return;
        }

        const restante =
            obtenerCajasRestantes(index);

        if (restante <= 0) {
            alert(
                'Este producto ya tiene todas sus cajas asignadas.'
            );

            return;
        }

        /*
         * Calcular posición aproximada
         * dentro de la paleta.
         */
        const pallet =
            document.getElementById('p3dPallet');

        const rect =
            pallet.getBoundingClientRect();

        let x =
            (
                event.clientX -
                rect.left
            ) / (p3dZoom / 100);

        let y =
            (
                event.clientY -
                rect.top
            ) / (p3dZoom / 100);

        x = Math.max(
            0,
            Math.min(
                PALLET_WIDTH - 75,
                x
            )
        );

        y = Math.max(
            0,
            Math.min(
                PALLET_DEPTH - 55,
                y
            )
        );

        abrirCantidadBloque(
            index,
            x,
            y
        );
    }
);


/**
 * =========================================================
 * CANTIDAD DE CAJAS
 * =========================================================
 */
function abrirCantidadBloque(
    productIndex,
    x,
    y
)
{
    const item =
        p3dData[productIndex];

    const restantes =
        obtenerCajasRestantes(productIndex);

    const cantidad =
        prompt(
            `¿Cuántas cajas de "${item.nombre}" quieres colocar?\n\n` +
            `Cajas restantes: ${restantes}`,
            restantes
        );

    if (cantidad === null) {
        return;
    }

    const cantidadNumero =
        parseInt(cantidad);

    if (
        !Number.isInteger(cantidadNumero) ||
        cantidadNumero <= 0
    ) {
        alert(
            'Ingresa una cantidad válida.'
        );

        return;
    }

    if (
        cantidadNumero > restantes
    ) {
        alert(
            `Solo quedan ${restantes} cajas disponibles.`
        );

        return;
    }

    const nuevoBloque = {

        id:
            Date.now() +
            Math.random(),

        productIndex:
            productIndex,

        cantidad:
            cantidadNumero,

        x:
            x,

        y:
            y,

        width:
            75,

        depth:
            55,

        height:
            18,

        columnas:
            1,

        filas:
            1,

        niveles:
            cantidadNumero,

        rotation:
            0
    };

    p3dBlocks.push(
        nuevoBloque
    );

    p3dSelected =
        p3dBlocks.length - 1;

    renderPaleta3D();
    renderP3dProducts();
    actualizarEditor3D();
}


/**
 * =========================================================
 * CAJAS RESTANTES
 * =========================================================
 */
function obtenerCajasRestantes(
    productIndex
)
{
    const item =
        p3dData[productIndex];

    const cpc =
        Number(item.cantidad_por_caja) > 0
            ? Number(item.cantidad_por_caja)
            : 1;

    const totalCajas =
        Math.ceil(
            Number(item.despachada || 0)
            / cpc
        );

    const colocadas =
        p3dBlocks
            .filter(
                block =>
                    block.productIndex ===
                    productIndex
            )
            .reduce(
                (total, block) =>
                    total +
                    Number(block.cantidad),
                0
            );

    return Math.max(
        0,
        totalCajas - colocadas
    );
}


/**
 * =========================================================
 * RENDERIZAR PALETA
 * =========================================================
 */
function renderPaleta3D()
{
    const pallet =
        document.getElementById('p3dPallet');

    pallet
        .querySelectorAll(
            '.p3d-product-group'
        )
        .forEach(
            el => el.remove()
        );

    p3dBlocks.forEach(
        (block, blockIndex) => {

            const item =
                p3dData[
                    block.productIndex
                ];

            if (!item) {
                return;
            }

            const columnas =
                Math.max(
                    1,
                    Number(
                        block.columnas || 1
                    )
                );

            const filas =
                Math.max(
                    1,
                    Number(
                        block.filas || 1
                    )
                );

            const niveles =
                Math.max(
                    1,
                    Number(
                        block.niveles || 1
                    )
                );

            const groupWidth =
                (
                    columnas *
                    block.width
                ) +
                (
                    (columnas - 1) *
                    BOX_GAP
                );

            const groupDepth =
                (
                    filas *
                    block.depth
                ) +
                (
                    (filas - 1) *
                    BOX_GAP
                );

            const group =
                document.createElement(
                    'div'
                );

            group.className =
                'p3d-product-group';

            group.dataset.blockIndex =
                blockIndex;

            group.style.left =
                block.x + 'px';

            group.style.top =
                block.y + 'px';

            group.style.width =
                groupWidth + 'px';

            group.style.height =
                groupDepth + 'px';

            group.style.transform =
                `rotateZ(${block.rotation}deg)`;

            /*
             * COLORES
             */
            const colores = [
                ['#dbeafe','#2563eb','#1e3a8a'],
                ['#dcfce7','#16a34a','#166534'],
                ['#fef3c7','#f59e0b','#92400e'],
                ['#fce7f3','#db2777','#9d174d'],
                ['#ede9fe','#7c3aed','#5b21b6'],
                ['#cffafe','#0891b2','#155e75']
            ];

            const color =
                colores[
                    block.productIndex %
                    colores.length
                ];

            /*
             * CREAR CAJAS
             */
            let cajaActual = 0;

            for (
                let nivel = 0;
                nivel < niveles;
                nivel++
            ) {

                for (
                    let fila = 0;
                    fila < filas;
                    fila++
                ) {

                    for (
                        let columna = 0;
                        columna < columnas;
                        columna++
                    ) {

                        if (
                            cajaActual >=
                            block.cantidad
                        ) {
                            break;
                        }

                        const caja =
                            crearCaja3D(
                                item,
                                block,
                                color,
                                columna,
                                fila,
                                nivel
                            );

                        group.appendChild(
                            caja
                        );

                        cajaActual++;
                    }
                }
            }

            configurarDragBloque(
                group,
                blockIndex
            );

            group.addEventListener(
                'click',
                function(event)
                {
                    event.stopPropagation();

                    p3dSelected =
                        blockIndex;

                    seleccionarBloque3D(
                        blockIndex
                    );
                }
            );

            pallet.appendChild(
                group
            );
        }
    );

    actualizarEditor3D();
}


/**
 * =========================================================
 * CREAR UNA CAJA 3D REAL
 * =========================================================
 */
function crearCaja3D(
    item,
    block,
    color,
    columna,
    fila,
    nivel
)
{
    const caja =
        document.createElement(
            'div'
        );

    caja.className =
        'p3d-box';
caja.style.setProperty(
    '--box-width',
    block.width + 'px'
);

caja.style.setProperty(
    '--box-depth',
    block.depth + 'px'
);

caja.style.setProperty(
    '--box-height',
    block.height + 'px'
);
    caja.style.width =
        block.width + 'px';

    caja.style.height =
        block.height + 'px';

    caja.style.transform =
        `
        translate3d(
            ${
                columna *
                (
                    block.width +
                    BOX_GAP
                )
            }px,
            ${
                fila *
                (
                    block.depth +
                    BOX_GAP
                )
            }px,
            ${
                nivel *
                block.height
            }px
        )
        `;

    /*
     * FRENTE
     */
    const front =
        document.createElement(
            'div'
        );

    front.className =
        'p3d-face p3d-front';

    front.style.width =
        block.width + 'px';

    front.style.height =
        block.height + 'px';

    front.style.background =
        color[0];

    front.style.borderColor =
        color[1];

    front.style.color =
        color[2];

    front.textContent =
        item.nombre;

    /*
     * ATRÁS
     */
    const back =
        document.createElement(
            'div'
        );

    back.className =
        'p3d-face p3d-back';

    back.style.width =
        block.width + 'px';

    back.style.height =
        block.height + 'px';

    back.style.background =
        color[0];

    back.style.borderColor =
        color[1];

    /*
     * DERECHA
     */
    const right =
        document.createElement(
            'div'
        );

    right.className =
        'p3d-face p3d-right';

    right.style.width =
        block.depth + 'px';

    right.style.height =
        block.height + 'px';

    right.style.background =
        color[1];

    right.style.borderColor =
        color[1];

    /*
     * IZQUIERDA
     */
    const left =
        document.createElement(
            'div'
        );

    left.className =
        'p3d-face p3d-left';

    left.style.width =
        block.depth + 'px';

    left.style.height =
        block.height + 'px';

    left.style.background =
        color[1];

    left.style.borderColor =
        color[1];

    /*
     * ARRIBA
     */
    const top =
        document.createElement(
            'div'
        );

    top.className =
        'p3d-face p3d-top';

    top.style.width =
        block.width + 'px';

    top.style.height =
        block.depth + 'px';

    top.style.background =
        color[0];

    top.style.borderColor =
        color[1];

    /*
     * ABAJO
     */
    const bottom =
        document.createElement(
            'div'
        );

    bottom.className =
        'p3d-face p3d-bottom';

    bottom.style.width =
        block.width + 'px';

    bottom.style.height =
        block.depth + 'px';

    bottom.style.background =
        color[2];

    /*
     * AGREGAR CARAS
     */
    caja.appendChild(front);
    caja.appendChild(back);
    caja.appendChild(right);
    caja.appendChild(left);
    caja.appendChild(top);
    caja.appendChild(bottom);

    return caja;
}


/**
 * =========================================================
 * SELECCIONAR BLOQUE
 * =========================================================
 */
function seleccionarBloque3D(
    index
)
{
    p3dSelected =
        index;

    document
        .querySelectorAll(
            '.p3d-product-group'
        )
        .forEach(
            group => {

                const seleccionado =
                    Number(
                        group.dataset.blockIndex
                    ) === index;

                group.style.filter =
                    seleccionado
                        ? 'brightness(1.12) drop-shadow(0 0 12px rgba(37,99,235,.65))'
                        : '';
            }
        );

    actualizarEditor3D();
}


/**
 * =========================================================
 * SELECCIONAR PRODUCTO
 * =========================================================
 */
function seleccionarProducto3D(
    productIndex
)
{
    const blockIndex =
        p3dBlocks.findIndex(
            block =>
                block.productIndex ===
                productIndex
        );

    if (blockIndex >= 0) {
        seleccionarBloque3D(
            blockIndex
        );
    }
}


/**
 * =========================================================
 * ARRASTRAR BLOQUE SOBRE PALETA
 * =========================================================
 */
function configurarDragBloque(
    group,
    blockIndex
)
{
    let dragging = false;

    let startX = 0;
    let startY = 0;

    let originalX = 0;
    let originalY = 0;

    group.addEventListener(
        'mousedown',
        function(event)
        {
            event.stopPropagation();

            seleccionarBloque3D(
                blockIndex
            );

            dragging = true;

            startX =
                event.clientX;

            startY =
                event.clientY;

            originalX =
                p3dBlocks[
                    blockIndex
                ].x;

            originalY =
                p3dBlocks[
                    blockIndex
                ].y;

            group.classList.add(
                'dragging'
            );

            document.body.style.userSelect =
                'none';
        }
    );

    window.addEventListener(
        'mousemove',
        function(event)
        {
            if (!dragging) {
                return;
            }

            const block =
                p3dBlocks[
                    blockIndex
                ];

            const dx =
                (
                    event.clientX -
                    startX
                ) /
                (p3dZoom / 100);

            const dy =
                (
                    event.clientY -
                    startY
                ) /
                (p3dZoom / 100);

            const groupWidth =
                (
                    block.columnas *
                    block.width
                ) +
                (
                    (block.columnas - 1) *
                    BOX_GAP
                );

            const groupDepth =
                (
                    block.filas *
                    block.depth
                ) +
                (
                    (block.filas - 1) *
                    BOX_GAP
                );

            block.x =
                Math.max(
                    0,
                    Math.min(
                        PALLET_WIDTH -
                        groupWidth,
                        originalX + dx
                    )
                );

            block.y =
                Math.max(
                    0,
                    Math.min(
                        PALLET_DEPTH -
                        groupDepth,
                        originalY + dy
                    )
                );

            group.style.left =
                block.x + 'px';

            group.style.top =
                block.y + 'px';

            actualizarEstadoPosicion(
                blockIndex
            );
        }
    );

    window.addEventListener(
        'mouseup',
        function()
        {
            if (!dragging) {
                return;
            }

            dragging = false;

            group.classList.remove(
                'dragging'
            );

            document.body.style.userSelect =
                '';
        }
    );
}


/**
 * =========================================================
 * EDITOR DEL BLOQUE
 * =========================================================
 */
function actualizarEditor3D()
{
    const editor =
        document.getElementById(
            'p3dEditor'
        );

    if (!editor) {
        return;
    }

    if (
        p3dSelected === null ||
        !p3dBlocks[
            p3dSelected
        ]
    ) {
        editor.innerHTML = `
            <div
                style="
                    padding:10px;
                    background:#f8fafc;
                    border:1px dashed #cbd5e1;
                    border-radius:7px;
                    font-size:9px;
                    color:#64748b;
                    text-align:center;
                "
            >
                Selecciona un bloque colocado
                para editarlo.
            </div>
        `;

        return;
    }

    const block =
        p3dBlocks[
            p3dSelected
        ];

    const item =
        p3dData[
            block.productIndex
        ];

    const restantes =
        obtenerCajasRestantes(
            block.productIndex
        );

    editor.innerHTML = `

        <div class="p3d-edit-box">

            <div class="p3d-edit-title">
                ⚙️ ${item.nombre}
            </div>

            <div
                style="
                    font-size:10px;
                    color:#64748b;
                    margin-bottom:8px;
                "
            >
                📦 Este bloque:
                <strong>
                    ${block.cantidad} cajas
                </strong>
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Columnas</label>
                <strong>${block.columnas}</strong>

                <input
                    type="range"
                    min="1"
                    max="6"
                    value="${block.columnas}"
                    oninput="
                        editarBloque3D(
                            'columnas',
                            this.value
                        )
                    "
                >
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Filas</label>
                <strong>${block.filas}</strong>

                <input
                    type="range"
                    min="1"
                    max="6"
                    value="${block.filas}"
                    oninput="
                        editarBloque3D(
                            'filas',
                            this.value
                        )
                    "
                    >
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Niveles</label>
                <strong>${block.niveles}</strong>

                <input
                    type="range"
                    min="1"
                    max="10"
                    value="${block.niveles}"
                    oninput="
                        editarBloque3D(
                            'niveles',
                            this.value
                        )
                    "
                >
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Ancho</label>
                <strong>
                    ${Math.round(block.width)} px
                </strong>

                <input
                    type="range"
                    min="40"
                    max="140"
                    value="${block.width}"
                    oninput="
                        editarBloque3D(
                            'width',
                            this.value
                        )
                    "
                >
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Profundidad</label>
                <strong>
                    ${Math.round(block.depth)} px
                </strong>

                <input
                    type="range"
                    min="35"
                    max="120"
                    value="${block.depth}"
                    oninput="
                        editarBloque3D(
                            'depth',
                            this.value
                        )
                    "
                >
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Altura</label>
                <strong>
                    ${Math.round(block.height)} px
                </strong>

                <input
                    type="range"
                    min="8"
                    max="40"
                    value="${block.height}"
                    oninput="
                        editarBloque3D(
                            'height',
                            this.value
                        )
                    "
                >
            </div>

            <div
                class="p3d-edit-row"
            >
                <label>Rotación</label>

                <strong>
                    ${Math.round(block.rotation)}°
                </strong>

                <input
                    type="range"
                    min="0"
                    max="180"
                    step="1"
                    value="${block.rotation}"
                    oninput="
                        editarBloque3D(
                            'rotation',
                            this.value
                        )
                    "
                >
            </div>

            <div
                style="
                    margin-top:8px;
                    padding:6px;
                    background:#eff6ff;
                    color:#1d4ed8;
                    border-radius:6px;
                    font-size:9px;
                    text-align:center;
                "
            >
                🔄 Rotación:
                ${Math.round(block.rotation)}°
            </div>
            <button
    type="button"
    onclick="eliminarBloque3D()"
    style="
        width:100%;
        margin-top:10px;
        padding:8px;
        border:1px solid #fecaca;
        background:#fef2f2;
        color:#b91c1c;
        border-radius:6px;
        font-size:10px;
        font-weight:700;
        cursor:pointer;
    "
>
    🗑️ Eliminar este bloque
</button>
            <div
                id="p3dPositionStatus"
                style="
                    margin-top:8px;
                    font-size:9px;
                    text-align:center;
                    padding:5px;
                    border-radius:6px;
                "
            ></div>

        </div>
    `;

    actualizarEstadoPosicion(
        p3dSelected
    );
}


/**
 * =========================================================
 * EDITAR BLOQUE
 * =========================================================
 */
function editarBloque3D(
    propiedad,
    valor
)
{
    if (
        p3dSelected === null ||
        !p3dBlocks[
            p3dSelected
        ]
    ) {
        return;
    }

    const block =
        p3dBlocks[
            p3dSelected
        ];

    block[propiedad] =
        Number(valor);

    /*
     * Si cambiamos la cantidad
     * de posiciones, aseguramos
     * que quepan las cajas.
     */
    if (
        propiedad === 'columnas' ||
        propiedad === 'filas' ||
        propiedad === 'niveles'
    ) {

        const capacidad =
            block.columnas *
            block.filas *
            block.niveles;

        if (
            capacidad <
            block.cantidad
        ) {

            alert(
                'La distribución seleccionada no alcanza para las ' +
                block.cantidad +
                ' cajas de este bloque.'
            );

            return;
        }
    }

    renderPaleta3D();
    seleccionarBloque3D(
        p3dSelected
    );

    renderP3dProducts();
}
/**
 * =========================================================
 * ELIMINAR BLOQUE
 * =========================================================
 */
function eliminarBloque3D()
{
    if (
        p3dSelected === null ||
        !p3dBlocks[p3dSelected]
    ) {
        return;
    }

    const block =
        p3dBlocks[p3dSelected];

    const item =
        p3dData[block.productIndex];

    const confirmar =
        confirm(
            `¿Eliminar el bloque de "${item.nombre}"?\n\n` +
            `Se devolverán ${block.cantidad} cajas a las cajas restantes.`
        );

    if (!confirmar) {
        return;
    }

    p3dBlocks.splice(
        p3dSelected,
        1
    );

    p3dSelected = null;

    renderPaleta3D();
    renderP3dProducts();
    actualizarEditor3D();
}

/**
 * =========================================================
 * ESTADO DE POSICIÓN
 * =========================================================
 */
function actualizarEstadoPosicion(
    index
)
{
    const status =
        document.getElementById(
            'p3dPositionStatus'
        );

    if (
        !status ||
        !p3dBlocks[index]
    ) {
        return;
    }

    const block =
        p3dBlocks[index];

    const groupWidth =
        (
            block.columnas *
            block.width
        ) +
        (
            (block.columnas - 1) *
            BOX_GAP
        );

    const groupDepth =
        (
            block.filas *
            block.depth
        ) +
        (
            (block.filas - 1) *
            BOX_GAP
        );

    const dentro =
        block.x >= 0 &&
        block.y >= 0 &&
        block.x + groupWidth <= PALLET_WIDTH &&
        block.y + groupDepth <= PALLET_DEPTH;

    if (dentro) {

        status.textContent =
            '🟢 Bloque dentro de la paleta';

        status.style.background =
            '#dcfce7';

        status.style.color =
            '#15803d';

    } else {

        status.textContent =
            '🔴 Bloque fuera de la paleta';

        status.style.background =
            '#fee2e2';

        status.style.color =
            '#b91c1c';
    }
}


/**
 * =========================================================
 * TRANSFORMACIÓN DE CÁMARA
 * =========================================================
 */
function actualizarP3dTransform()
{
    const world =
        document.getElementById(
            'p3dWorld'
        );

    if (!world) {
        return;
    }

    world.style.transform = `
        translate(-50%,-50%)
        rotateX(${p3dRotX}deg)
        rotateZ(${p3dRotY}deg)
        scale(${p3dZoom / 100})
    `;

    document.getElementById(
        'p3dZoomValue'
    ).textContent =
        p3dZoom + '%';

    document.getElementById(
        'p3dRotXValue'
    ).textContent =
        p3dRotX + '°';

    document.getElementById(
        'p3dRotYValue'
    ).textContent =
        p3dRotY + '°';
}


/**
 * =========================================================
 * CONTROLES DE CÁMARA
 * =========================================================
 */
document.getElementById('p3dZoom')
    ?.addEventListener(
        'input',
        function()
        {
            p3dZoom =
                Number(this.value);

            actualizarP3dTransform();
        }
    );

document.getElementById('p3dRotX')
    ?.addEventListener(
        'input',
        function()
        {
            p3dRotX =
                Number(this.value);

            actualizarP3dTransform();
        }
    );

document.getElementById('p3dRotY')
    ?.addEventListener(
        'input',
        function()
        {
            p3dRotY =
                Number(this.value);

            actualizarP3dTransform();
        }
    );


/**
 * =========================================================
 * GIRAR CÁMARA CON EL RATÓN
 * =========================================================
 */
p3dStage?.addEventListener(
    'mousedown',
    function(event)
    {
        if (
            event.target.closest(
                '.p3d-product-group'
            )
        ) {
            return;
        }

        p3dDragging = true;

        p3dStartX =
            event.clientX;

        p3dStartY =
            event.clientY;

        p3dStage.classList.add(
            'dragging'
        );
    }
);

window.addEventListener(
    'mousemove',
    function(event)
    {
        if (!p3dDragging) {
            return;
        }

        const dx =
            event.clientX -
            p3dStartX;

        const dy =
            event.clientY -
            p3dStartY;

        p3dRotY +=
            dx * .5;

        p3dRotX -=
            dy * .3;

        p3dRotX =
            Math.max(
                25,
                Math.min(
                    75,
                    p3dRotX
                )
            );

        p3dStartX =
            event.clientX;

        p3dStartY =
            event.clientY;

        document.getElementById(
            'p3dRotX'
        ).value =
            p3dRotX;

        document.getElementById(
            'p3dRotY'
        ).value =
            p3dRotY;

        actualizarP3dTransform();
    }
);

window.addEventListener(
    'mouseup',
    function()
    {
        p3dDragging = false;

        p3dStage?.classList.remove(
            'dragging'
        );
    }
);


/**
 * =========================================================
 * ESC
 * =========================================================
 */
document.addEventListener(
    'keydown',
    function(event)
    {
        if (
            event.key === 'Escape' &&
            document
                .getElementById('p3dOverlay')
                ?.classList.contains('open')
        ) {
            cerrarPaleta3D();
        }
    }
);
// ── Modal de etiqueta de producto ─────────────────────────────────────────
function cerrarEtiqueta(e){
    if(e && e.target && e.target.id !== 'etOverlay') return;
    const overlay=document.getElementById('etOverlay');
    if(overlay) overlay.classList.remove('open');
}

function abrirEtiqueta(data) {
    document.getElementById('etNombre').textContent = data.nombre;
    document.getElementById('etCpc').textContent = data.cantidadPorCaja + ' unid. por caja';

    const cpc = data.cantidadPorCaja > 0 ? data.cantidadPorCaja : 1;
    const cajas = Math.floor(data.cantidadDespachada / cpc);
    const sueltas = data.cantidadDespachada % cpc;

    document.getElementById('etLote').textContent = data.lote || '—';
    document.getElementById('etFecha').textContent = data.fecha || '—';
    document.getElementById('etCajas').textContent = cajas;
    document.getElementById('etUnidades').textContent =
        data.cantidadDespachada + (sueltas > 0 ? ' (' + sueltas + ' sueltas)' : '');

    const barcodeEl = document.getElementById('etBarcode');
    barcodeEl.innerHTML = '';

    const codigo = (data.codigo || '').toString().trim();

    if (codigo) {
        try {
            JsBarcode(barcodeEl, codigo, {
                format: "CODE128",
                width: 2,
                height: 60,
                displayValue: true,
                lineColor: "#000",
                background: "#fff"
            });
        } catch (err) {
            console.error('Código inválido:', codigo, err);
            barcodeEl.outerHTML = '<div id="etBarcode" style="font-size:11px;color:#b91c1c;">Código no válido: ' + codigo + '</div>';
        }
    } else {
        barcodeEl.outerHTML = '<div id="etBarcode" style="font-size:11px;color:#b91c1c;">Sin código registrado</div>';
    }

    const urlTemplate = document.querySelector('.et-actions').dataset.etiquetaUrlTemplate;
    document.getElementById('etPdfLink').href = urlTemplate.replace('__ID__', data.detailId);

    document.getElementById('etOverlay').classList.add('open');
}


// =========================================================
// FUNCIONES DEL REDISEÑO ERP
// =========================================================
function ocDD(id,event){
    if(event) event.stopPropagation();
    document.querySelectorAll('.oc-dd.open').forEach(el=>{ if(el.id!==id) el.classList.remove('open'); });
    document.getElementById(id)?.classList.toggle('open');
}
document.addEventListener('click',()=>document.querySelectorAll('.oc-dd.open').forEach(el=>el.classList.remove('open')));

function ocTab(name,btn){
    document.querySelectorAll('.oc-tab').forEach(b=>b.classList.remove('on'));
    document.querySelectorAll('.oc-pane').forEach(p=>p.classList.remove('on'));
    btn?.classList.add('on');
    document.querySelector('.oc-pane[data-pane="'+name+'"]')?.classList.add('on');
}

function ocToggle(id){ document.getElementById('oc-det-'+id)?.classList.toggle('open'); }
function ocEditar(id){
    const row=document.getElementById('oc-det-'+id); if(!row)return;
    row.classList.add('open');
    row.scrollIntoView({behavior:'smooth',block:'center'});
    const input=row.querySelector('[name="cantidad_despachada"]');
    if(input)setTimeout(()=>{input.focus();input.select();},250);
}
function ocFiltrar(){
    const q=(document.getElementById('ocBuscar')?.value||'').trim().toLowerCase();
    const e=(document.getElementById('ocFEstado')?.value||'').trim().toUpperCase();
    const p=(document.getElementById('ocFPaleta')?.value||'').trim().toUpperCase();
    const rows=document.querySelectorAll('#ocTabla tbody tr.oc-row'); let n=0;
    rows.forEach(row=>{
        const s=(row.dataset.search||'').toLowerCase();
        const st=(row.dataset.estado||'').toUpperCase();
        const pa=(row.dataset.paleta||'').trim().toUpperCase();
        const ok=(!q||s.includes(q))&&(!e||st===e)&&(!p||(p==='__SIN__'?!pa:pa===p));
        row.style.display=ok?'':'none';
        const id=(row.id||'').replace('producto-','');
        const d=id?document.getElementById('oc-det-'+id):null;
        if(d&&!ok)d.style.display='none';
        if(ok)n++;
    });
    const v=document.getElementById('ocVacio');if(v)v.style.display=n?'none':'block';
    const c=document.getElementById('ocContador');if(c)c.textContent=n+' de '+rows.length;
}
function ocLimpiar(){
    ['ocBuscar','ocFEstado','ocFPaleta'].forEach((id,i)=>{const el=document.getElementById(id);if(el)el.value='';});
    ocFiltrar();
}
function ocTogglePanel(){ document.getElementById('ocAccPanel')?.classList.toggle('open'); }
function ocIrEscaner(){
    const el=document.getElementById('scanner');
    if(el){el.scrollIntoView({behavior:'smooth',block:'center'});setTimeout(()=>el.focus(),300);}
}
function ocNuevaPaleta(){
    const b=document.getElementById('ocNuevaPaleta');
    const name=b?.dataset.next||'P01', first=b?.dataset.firstSin;
    if(first){
        const row=document.getElementById('oc-det-'+first);
        const input=row?.querySelector('[name="paleta"]');
        if(row&&input){row.classList.add('open');input.value=name;setTimeout(()=>{input.focus();input.select();},80);return;}
    }
    document.getElementById('ocPaletas')?.scrollIntoView({behavior:'smooth',block:'center'});
}
function ocExportCSV(){
    const rows=[['#','Producto','SKU','Solicitado','Despachado','Pendiente','Avance','Lote','Vencimiento','Paleta','Ubicación','Últ. despacho','Armó','Subtotal']];
    document.querySelectorAll('#ocTabla tbody tr.oc-row').forEach(tr=>{
        if(tr.style.display==='none')return;const c=tr.children;if(!c||c.length<16)return;
        rows.push([0,1,2,3,4,5,6,7,8,10,11,12,13,14].map(i=>(c[i]?.innerText||'').replace(/\s+/g,' ').trim()));
    });
    const csv=rows.map(r=>r.map(v=>'"'+String(v).replace(/"/g,'""')+'"').join(',')).join('\n');
    const blob=new Blob(["\ufeff"+csv],{type:'text/csv;charset=utf-8;'});
    const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='orden-{{ $order->numero_orden }}.csv';document.body.appendChild(a);a.click();a.remove();
}


function abrirResumenOrden() {
    const modal = document.getElementById('modalResumenOrden');

    modal.style.display = 'flex';

    document.body.style.overflow = 'hidden';
}

function cerrarResumenOrden() {
    const modal = document.getElementById('modalResumenOrden');

    modal.style.display = 'none';

    document.body.style.overflow = '';
}

// Cerrar haciendo clic fuera de la ventana
document.getElementById('modalResumenOrden')?.addEventListener('click', function(e) {

    if (e.target === this) {
        cerrarResumenOrden();
    }

});

</script>
@endsection
