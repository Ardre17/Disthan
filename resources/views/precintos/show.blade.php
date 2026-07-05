@extends('layouts.app')
@section('content')
<style>
:root{--erp-bg:#eef1f5;--erp-surface:#fff;--erp-border:#dde2ea;--erp-ink:#1c2733;--erp-ink-muted:#5b6b7d;--erp-accent:#0b5ed7;--erp-danger:#c0312b;--erp-danger-bg:#fbe9e8;--erp-warn:#b9690e;--erp-warn-bg:#fdf1e2;--erp-ok:#1c7c4d;--erp-ok-bg:#e8f5ee;--font-ui:'Segoe UI',sans-serif;--font-mono:'Consolas',monospace;}
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
.layout{display:grid;grid-template-columns:1fr 280px;gap:14px;}
@media(max-width:900px){.layout{grid-template-columns:1fr;}}
.card{background:var(--erp-surface);border:1px solid var(--erp-border);border-radius:4px;margin-bottom:10px;}
.card-hdr{background:#f4f6f9;border-bottom:1px solid var(--erp-border);padding:.65rem 1rem;font-size:11px;font-weight:700;color:var(--erp-ink);text-transform:uppercase;letter-spacing:.06em;}
.card-body{padding:1rem;}
.stock-hero{text-align:center;padding:1.25rem;border-radius:4px;margin-bottom:1rem;}
.stock-big{font-size:48px;font-weight:900;line-height:1;font-family:var(--font-mono);}
.info-row{display:flex;justify-content:space-between;align-items:center;font-size:12px;padding:6px 0;border-bottom:1px solid #f4f6f9;color:var(--erp-ink-muted);}
.info-row:last-child{border:none;}
.info-val{font-weight:600;color:var(--erp-ink);}
.status-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:3px 8px;border-radius:3px;}
.sb-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;}
.sb-warn{background:var(--erp-warn-bg);color:var(--erp-warn);border:1px solid #f9d5a3;}
.sb-low{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;}
.flabel{font-size:10px;font-weight:700;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:3px;}
.finput,.fselect{padding:7px 9px;border:1px solid var(--erp-border);border-radius:3px;font-size:12px;color:var(--erp-ink);background:#fbfcfe;outline:none;width:100%;font-family:var(--font-ui);transition:border-color .15s;}
.finput:focus,.fselect:focus{border-color:var(--erp-accent);box-shadow:0 0 0 2px rgba(11,94,215,.1);}
.field{display:flex;flex-direction:column;gap:3px;margin-bottom:8px;}
.tipo-btns{display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:10px;}
.tipo-btn{padding:8px;border:2px solid var(--erp-border);border-radius:3px;font-size:12px;font-weight:700;cursor:pointer;text-align:center;background:#fff;color:var(--erp-ink-muted);transition:.15s;}
.tipo-btn.active-e{border-color:var(--erp-ok);background:var(--erp-ok-bg);color:var(--erp-ok);}
.tipo-btn.active-s{border-color:var(--erp-danger);background:var(--erp-danger-bg);color:var(--erp-danger);}
.btn-submit{width:100%;padding:9px;border:none;border-radius:3px;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.btn-submit.entrada{background:var(--erp-ok);color:#fff;}
.btn-submit.salida{background:var(--erp-danger);color:#fff;}
.kardex-table{width:100%;border-collapse:collapse;font-size:12px;}
.kardex-table th{background:#f8fafc;color:#64748b;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:7px 10px;border-bottom:2px solid var(--erp-border);text-align:left;white-space:nowrap;}
.kardex-table td{padding:7px 10px;border-bottom:1px solid #f8fafc;vertical-align:middle;}
.kardex-table tbody tr:hover td{background:#f8fafc;}
.tipo-e{background:var(--erp-ok-bg);color:var(--erp-ok);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;}
.tipo-s{background:var(--erp-danger-bg);color:var(--erp-danger);font-size:10px;padding:2px 7px;border-radius:3px;font-weight:700;}
.alert-ok{background:var(--erp-ok-bg);color:var(--erp-ok);border:1px solid #b7dfca;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;display:flex;align-items:center;gap:7px;}
.alert-err{background:var(--erp-danger-bg);color:var(--erp-danger);border:1px solid #f3c7c4;border-radius:4px;padding:8px 14px;font-size:12px;margin-bottom:.75rem;}
.btn-back{background:#fff;color:#5b6b7d;border:1px solid #dde2ea;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;}
.btn-edit-top{background:#fdf1e2;color:#b9690e;border:1px solid #b9690e;padding:7px 14px;border-radius:3px;font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px;}
.lang-tag{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:3px;}
.tag-en{background:#dbeafe;color:#1d4ed8;}
.tag-pt{background:#dcfce7;color:#15803d;}
</style>

<div class="page">
<div class="erp-bar">
    <div class="erp-bar-left">
        <div class="erp-logo">JOYBER PERÚ</div>
        <div class="erp-sep"></div>
        <div class="erp-module">Kardex — {{ $sticker->nombre }}</div>
    </div>
    <span style="font-size:11px;color:#5a8abf;">Inventario › Stickers › Kardex</span>
</div>

<div class="body">

@if(session('success'))<div class="alert-ok">✅ {{ session('success') }}</div>@endif
@if($errors->any())<div class="alert-err"><strong>⚠️</strong> @foreach($errors->all() as $e){{ $e }} @endforeach</div>@endif

@php
    $est   = $sticker->estado;
    $stkC  = match($est){ 'DISPONIBLE'=>'var(--erp-ok)','STOCK_BAJO'=>'var(--erp-warn)',default=>'var(--erp-danger)' };
    $stBg  = match($est){ 'DISPONIBLE'=>'var(--erp-ok-bg)','STOCK_BAJO'=>'var(--erp-warn-bg)',default=>'var(--erp-danger-bg)' };
    $sbCls = match($est){ 'DISPONIBLE'=>'sb-ok','STOCK_BAJO'=>'sb-warn',default=>'sb-low' };
    $sbLbl = match($est){ 'DISPONIBLE'=>'✅ Disponible','STOCK_BAJO'=>'⚠ Stock bajo',default=>'🔴 Agotado' };
    $totalEntradas = $sticker->movements->where('tipo','ENTRADA')->sum('cantidad');
    $totalSalidas  = $sticker->movements->where('tipo','SALIDA')->sum('cantidad');
@endphp

<div class="page-hdr">
    <div>
        <div class="page-title">{{ $sticker->nombre }}</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px;">Kardex individual · historial de movimientos</div>
    </div>
    <div style="display:flex;gap:7px;flex-wrap:wrap;">
        <a href="{{ route('stickers.edit', $sticker) }}" class="btn-edit-top">✏️ Editar</a>
        <a href="{{ route('stickers.index') }}" class="btn-back">← Volver</a>
    </div>
</div>

<div class="layout">
<div>
    <div class="card">
        <div class="card-hdr">Información</div>
        <div class="card-body">
            <div class="stock-hero" style="background:{{ $stBg }};">
                <div class="stock-big" style="color:{{ $stkC }};">{{ number_format($sticker->stock_actual,0) }}</div>
                <div style="font-size:12px;color:var(--erp-ink-muted);margin-top:4px;">unidades en stock</div>
                <div style="margin-top:6px;"><span class="status-badge {{ $sbCls }}">{{ $sbLbl }}</span></div>
            </div>
            <div class="info-row"><span>Color</span><span><span class="lang-tag {{ $sticker->idioma === 'EN' ? 'tag-en' : 'tag-pt' }}">{{ $sticker->idioma === 'EN' ? '🇺🇸 Inglés' : '🇧🇷 Portugués' }}</span></span></div>
            <div class="info-row"><span>Stock mínimo</span><span class="info-val" style="color:var(--erp-warn);">{{ number_format($sticker->stock_minimo,0) }}</span></div>
            <div class="info-row"><span>Total entradas</span><span class="info-val" style="color:var(--erp-ok);">+{{ number_format($totalEntradas,0) }}</span></div>
            <div class="info-row"><span>Total salidas</span><span class="info-val" style="color:var(--erp-danger);">−{{ number_format($totalSalidas,0) }}</span></div>
        </div>
    </div>

    <div class="card">
        <div class="card-hdr">Historial de movimientos</div>
        <div style="overflow-x:auto;">
            <table class="kardex-table">
                <thead><tr><th>Fecha</th><th>Tipo</th><th style="text-align:right;">Cantidad</th><th style="text-align:right;">Saldo</th><th>Motivo</th><th>Referencia</th></tr></thead>
                <tbody>
                @forelse($movements as $mov)
                <tr>
                    <td style="color:#94a3b8;white-space:nowrap;font-size:11px;">{{ \Carbon\Carbon::parse($mov->created_at)->format('d M Y H:i') }}</td>
                    <td><span class="{{ $mov->tipo === 'ENTRADA' ? 'tipo-e' : 'tipo-s' }}">{{ $mov->tipo === 'ENTRADA' ? '⬆ ENTRADA' : '⬇ SALIDA' }}</span></td>
                    <td style="text-align:right;font-weight:700;font-family:var(--font-mono);color:{{ $mov->tipo === 'ENTRADA' ? 'var(--erp-ok)' : 'var(--erp-danger)' }};">{{ $mov->tipo === 'ENTRADA' ? '+' : '−' }}{{ number_format($mov->cantidad,0) }}</td>
                    <td style="text-align:right;font-family:var(--font-mono);color:var(--erp-ink-muted);">{{ number_format($mov->saldo_post,0) }}</td>
                    <td style="color:#475569;">{{ $mov->motivo ?? '—' }}</td>
                    <td style="color:#94a3b8;font-size:11px;">{{ $mov->referencia ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:2rem;">Sin movimientos aún</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($movements->hasPages())<div style="padding:.75rem 1rem;border-top:1px solid var(--erp-border);">{{ $movements->links() }}</div>@endif
    </div>
</div>

<div>
    <div class="card">
        <div class="card-hdr">Registrar movimiento</div>
        <div class="card-body">
            <form method="POST" action="{{ route('stickers.movimiento', $sticker) }}" id="formMov">
            @csrf
            <div class="tipo-btns">
                <button type="button" class="tipo-btn active-e" id="btnEntrada" onclick="setTipo('ENTRADA')">⬆ ENTRADA</button>
                <button type="button" class="tipo-btn" id="btnSalida" onclick="setTipo('SALIDA')">⬇ SALIDA</button>
            </div>
            <input type="hidden" name="tipo" id="inputTipo" value="ENTRADA">
            <div class="field">
                <label class="flabel">Cantidad *</label>
                <input type="number" name="cantidad" class="finput" placeholder="0" min="0.01" step="0.01" required style="font-size:18px;font-weight:700;text-align:center;font-family:var(--font-mono);">
            </div>
            <div class="field">
                <label class="flabel">Motivo *</label>
                <select name="motivo" class="fselect" required>
                    <option value="">Seleccionar motivo</option>
                    @foreach(['Producción','Despacho cliente','Exportación','Merma','Ajuste inventario','Stock inicial','Otro'] as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label class="flabel">Referencia</label>
                <input type="text" name="referencia" class="finput" placeholder="Ej: ORD-2025-045">
            </div>
            <button type="submit" class="btn-submit entrada" id="btnSubmit">⬆ Registrar entrada</button>
            </form>
            <hr style="border:none;border-top:1px solid #f1f5f9;margin:1rem 0;">
            <div style="background:#f4f6f9;border-radius:3px;padding:10px;text-align:center;">
                <div style="font-size:10px;color:var(--erp-ink-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">Stock actual</div>
                <div style="font-size:24px;font-weight:800;font-family:var(--font-mono);color:{{ $stkC }};">{{ number_format($sticker->stock_actual,0) }}</div>
                <div style="font-size:10px;color:#94a3b8;">mín. {{ number_format($sticker->stock_minimo,0) }}</div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
function setTipo(tipo) {
    document.getElementById('inputTipo').value = tipo;
    var btnE = document.getElementById('btnEntrada');
    var btnS = document.getElementById('btnSalida');
    var sub  = document.getElementById('btnSubmit');
    if (tipo === 'ENTRADA') {
        btnE.className = 'tipo-btn active-e'; btnS.className = 'tipo-btn';
        sub.className = 'btn-submit entrada'; sub.textContent = '⬆ Registrar entrada';
    } else {
        btnE.className = 'tipo-btn'; btnS.className = 'tipo-btn active-s';
        sub.className = 'btn-submit salida'; sub.textContent = '⬇ Registrar salida';
    }
}
</script>
@endsection