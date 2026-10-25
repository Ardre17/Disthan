<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

@page { margin: 26px 28px; }
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9.5px;
    color: #1e293b;
    background: #fff;
    line-height: 1.35;
}

/* ── Colores base ── */
/* azul oscuro #0b4ea2 · azul marca #1d4ed8 · panel #eef5fd · borde #d6e4f5 */

/* HEADER */
.hdr { width:100%; border-collapse:collapse; margin-bottom:12px; }
.brand-name { font-size:21px; font-weight:900; color:#1d4ed8; letter-spacing:.5px; }
.brand-name span { color:#0f2d5c; }
.brand-sub { font-size:8px; color:#64748b; margin-top:1px; }
.doc-title { font-size:15px; font-weight:900; color:#0f2d5c; text-align:center; letter-spacing:.3px; }
.doc-tipo  { font-size:11px; font-weight:800; color:#1d4ed8; text-align:center; margin-top:3px; text-transform:uppercase; }
.doc-meta  { font-size:7.5px; color:#94a3b8; text-align:center; margin-top:4px; }
.ord-box   { background:#0b4ea2; color:#fff; border-radius:7px; padding:6px 10px 8px; text-align:center; }
.ord-lbl   { font-size:7.5px; letter-spacing:.12em; color:#bcd6fb; }
.ord-num   { font-size:15px; font-weight:900; letter-spacing:.5px; margin:1px 0 4px; }
.bc-wrap   { background:#fff; border-radius:4px; padding:4px 6px 2px; text-align:center; }
.bc-txt    { font-size:7px; color:#334155; margin-top:2px; }

/* TARJETAS */
.card { background:#fff; border:1px solid #d6e4f5; border-radius:7px; padding:8px 10px; }
.card-lbl { font-size:8.5px; font-weight:800; color:#0f2d5c; }
.card-name { font-size:10px; font-weight:900; color:#0f2d5c; margin:1px 0 3px; }
.card-line { font-size:8px; color:#475569; }
.card-line b { color:#64748b; font-weight:700; display:inline-block; width:44px; }

/* CHIPS DE DATOS */
.chips { width:100%; border-collapse:separate; border-spacing:5px 0; margin:0 -5px 10px; }
.chip { background:#f5f9ff; border:1px solid #d6e4f5; border-radius:7px; padding:6px 8px; }
.chip-lbl { font-size:7.5px; color:#64748b; }
.chip-val { font-size:9.5px; font-weight:800; color:#0f2d5c; margin-top:1px; }

/* SECCIONES */
.panel { background:#eef5fd; border:1px solid #dbe7f6; border-radius:8px; padding:8px 10px; margin-bottom:10px; }
.sec { font-size:10px; font-weight:900; color:#0f2d5c; margin-bottom:7px; }
.sec-ic { display:inline-block; width:14px; height:14px; background:#1d4ed8; color:#fff; border-radius:3px; text-align:center; font-size:8px; line-height:14px; margin-right:5px; }
.sec-ic.red { background:#dc2626; }
.sec-ic.amb { background:#f59e0b; }

/* KPIs */
.kpis { width:100%; border-collapse:collapse; }
.kpis td { text-align:center; padding:2px 3px; }
.kpi-n { font-size:15px; font-weight:900; color:#0f2d5c; line-height:1.1; }
.kpi-l { font-size:7.5px; color:#475569; line-height:1.2; }
.kpi-ic { display:inline-block; width:24px; height:24px; border-radius:6px; background:#dbe9fb; color:#1d4ed8; font-size:11px; line-height:24px; font-weight:900; }

/* TABLAS */
.tbl { width:100%; border-collapse:collapse; font-size:8.5px; background:#fff; }
.tbl thead th { background:#0b4ea2; color:#fff; padding:5px 5px; text-align:center; font-size:8px; font-weight:800; border-right:1px solid #2d6bbd; }
.tbl thead th:last-child { border-right:none; }
.tbl tbody td { padding:4.5px 5px; border-bottom:1px solid #e6eef9; text-align:center; vertical-align:middle; }
.tbl tbody td.l { text-align:left; }
.tbl tfoot td { padding:5px 5px; background:#e8f1fc; font-weight:900; color:#0f2d5c; text-align:center; border-top:2px solid #0b4ea2; }

/* ESTADOS */
.st { display:inline-block; padding:2px 7px; border-radius:9px; font-size:7.5px; font-weight:800; }
.st-ok  { background:#dcfce7; color:#15803d; }
.st-par { background:#fde9b3; color:#a16207; }
.st-no  { background:#fecaca; color:#b91c1c; }
.row-par td { background:#fff7dc !important; }
.row-no  td { background:#ffe3e3 !important; }

/* PALETAS */
.pcell { vertical-align:top; padding:0 5px 8px 0; }
.pcell-r { padding:0 0 8px 5px; }
.pcard { width:100%; border-collapse:collapse; page-break-inside:avoid; }
.pcard-h { background:#0b4ea2; color:#fff; padding:5px 8px; font-size:10px; font-weight:900; border-radius:6px 0 0 0; }
.pcard-hr { background:#0b4ea2; text-align:right; padding:4px 6px; border-radius:0 6px 0 0; }
.pchip { display:inline-block; padding:3px 12px; border-radius:6px; font-size:7.5px; font-weight:900; letter-spacing:.04em; }
.pc-ok { background:#16a34a; color:#fff; } .pc-par { background:#fbbf24; color:#422006; } .pc-no { background:#ef4444; color:#fff; }
.pbody { background:#f6f9fe; border:1px solid #d6e4f5; border-top:none; padding:6px 7px; }
.pstats { width:100%; border-collapse:collapse; }
.pstats td { text-align:center; font-size:7.5px; color:#475569; padding:0 2px; }
.pstats b { display:block; font-size:10.5px; color:#0f2d5c; font-weight:900; }
.ptbl { width:100%; border-collapse:collapse; font-size:7.5px; background:#fff; margin-top:6px; }
.ptbl thead th { background:#0b4ea2; color:#fff; padding:3.5px 3px; font-size:7px; text-align:center; border-right:1px solid #2d6bbd; }
.ptbl tbody td { padding:3.5px 3px; border-bottom:1px solid #e6eef9; text-align:center; }
.ptbl tbody td.l { text-align:left; }
.ptfoot { font-size:7.5px; color:#0b4ea2; font-weight:800; text-align:right; margin-top:3px; }

/* FALTANTES */
.fcell { vertical-align:top; }
.fbox-no  { background:#fff1f1; border:1px solid #fecaca; border-radius:7px; padding:7px 8px; }
.fbox-par { background:#fffaf0; border:1px solid #fde7b0; border-radius:7px; padding:7px 8px; }
.ftitle-no  { font-size:9px; font-weight:900; color:#b91c1c; margin-bottom:5px; }
.ftitle-par { font-size:9px; font-weight:900; color:#a16207; margin-bottom:5px; }
.ftbl { width:100%; border-collapse:collapse; font-size:7.5px; background:#fff; }
.ftbl thead th { padding:3.5px 3px; font-size:7px; text-align:center; color:#fff; }
.ftbl thead th.no  { background:#dc2626; }
.ftbl thead th.par { background:#d97706; }
.ftbl tbody td { padding:3.5px 3px; border-bottom:1px solid #f1f5f9; text-align:center; }
.ftbl tbody td.l { text-align:left; }

/* OBSERVACIONES + FIRMAS */
.obs-box { background:#eef5fd; border:1px solid #dbe7f6; border-radius:8px; padding:8px 10px; vertical-align:top; }
.obs-t { font-size:9.5px; font-weight:900; color:#0f2d5c; margin-bottom:4px; }
.obs-x { font-size:8.5px; color:#334155; line-height:1.5; }
.firma { text-align:center; vertical-align:bottom; padding:0 8px; }
.firma-line { border-top:1px solid #334155; padding-top:4px; font-size:8.5px; font-weight:800; color:#0f2d5c; }

/* RESUMEN GENERAL (original) */
.summary-table { width:100%; border-collapse:collapse; margin-top:10px; border:1.5px solid #0b4ea2; background:#fff; }
.summary-table td { padding:6px 12px; border-bottom:1px solid #e2e8f0; font-size:9.5px; }
.summary-table td:last-child { text-align:right; font-weight:800; color:#0f2d5c; font-size:10.5px; }
.summary-total td { background:#0b4ea2; color:#fff !important; font-weight:900; font-size:11.5px; padding:8px 12px; }
.summary-total td:last-child { color:#bcd6fb !important; font-size:13.5px; }

/* FOOTER */
.footer { margin-top:10px; border-top:1px solid #d6e4f5; padding-top:6px; width:100%; border-collapse:collapse; }
.footer td { font-size:7.5px; color:#94a3b8; }
.footer td:last-child { text-align:right; }

</style>
</head>
<body>

@php
    // ── Ordenar por id (orden de guardado) ──────────────────────────────
    $detalles = $order->details->sortBy('id');

    // ── Paletas ordenadas alfanuméricamente P01→P02→... ─────────────────
    $paletas = $detalles
        ->groupBy(fn($i) => $i->paleta ?: 'SIN PALETA')
        ->sortKeys(SORT_NATURAL);

    // ── Solo paletas con nombre real (excluir SIN PALETA del conteo) ────
    $paletasConNombre = $paletas->filter(fn($items, $key) => $key !== 'SIN PALETA');

    // ── Peso desde cantidad_despachada ───────────────────────────────────
    $pesoTotal = $detalles->sum(fn($d) =>
        $d->cantidad_despachada * ($d->product->peso ?? 0) / 1000
    );
    $totalUds        = $detalles->sum('cantidad_despachada');
    $completados     = $detalles->filter(fn($d) =>
        $d->cantidad_despachada >= $d->cantidad_solicitada
    )->count();
    $porcentaje = $detalles->count() > 0
        ? round(($completados / $detalles->count()) * 100) : 0;
@endphp

{{-- ── Datos adicionales para el rediseño (solo lectura; no tocan las variables de arriba) ── --}}
@php
    // Datos de la empresa que despacha ("Proveedor"). Complétalos aquí o en la orden ($order->proveedor).
    $pdfProv = [
        'nombre'    => null,   // Ej: 'JOYBER PERÚ S.A.C.'
        'ruc'       => null,   // Ej: '20601234567'
        'direccion' => null,   // Ej: 'JR. LOS ALISOS 125 - LIMA'
    ];

    $n   = function ($v, $d = 0) {
        $s = number_format((float) $v, $d, '.', '');
        if (strpos($s, '.') !== false) { $s = rtrim(rtrim($s, '0'), '.'); }
        return $s === '' ? '0' : $s;
    };
    $f   = fn($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m/Y') : '—';
    $cli = $order->client;
    $prv = $order->proveedor ?? null;
    $provNombre = (is_object($prv) ? ($prv->razon_social ?? $prv->nombre ?? null) : (is_string($prv) ? $prv : null)) ?: $pdfProv['nombre'];
    $provRuc    = (is_object($prv) ? ($prv->ruc ?? null) : null) ?: $pdfProv['ruc'];
    $provDir    = (is_object($prv) ? ($prv->direccion ?? null) : null) ?: $pdfProv['direccion'];

    $solTotal  = (float) $detalles->sum('cantidad_solicitada');
    $penTotal  = (float) $detalles->sum(fn($d) => max($d->cantidad_solicitada - $d->cantidad_despachada, 0));

    // Estado de cada línea
    $est = function ($d) {
        if ($d->cantidad_despachada == 0)                         return ['No despachado', 'st-no',  'row-no',  '✖'];
        if ($d->cantidad_despachada < $d->cantidad_solicitada)    return ['Parcial',       'st-par', 'row-par', '⚠'];
        return ['Completo', 'st-ok', '', '✔'];
    };
    $cajas = function ($d) {
        $c = (int) ($d->product->cantidad_por_caja ?? 0);
        return $c > 0 ? (int) ceil($d->cantidad_despachada / $c) : 0;
    };

    // Código de barras (Code 128) del número de pedido del cliente o, si no hay, de la orden
    $pedidoCli = $order->order_interna ?? null;
    $bcTexto   = trim((string) ($pedidoCli ?: $order->numero_orden));
    $c128 = [
    '11011001100',
    '11001101100',
    '11001100110',
    '10010011000',
    '10010001100',
    '10001001100',
    '10011001000',
    '10011000100',
    '10001100100',
    '11001001000',
    '11001000100',
    '11000100100',
    '10110011100',
    '10011011100',
    '10011001110',
    '10111001100',
    '10011101100',
    '10011100110',
    '11001110010',
    '11001011100',
    '11001001110',
    '11011100100',
    '11001110100',
    '11101101110',
    '11101001100',
    '11100101100',
    '11100100110',
    '11101100100',
    '11100110100',
    '11100110010',
    '11011011000',
    '11011000110',
    '11000110110',
    '10100011000',
    '10001011000',
    '10001000110',
    '10110001000',
    '10001101000',
    '10001100010',
    '11010001000',
    '11000101000',
    '11000100010',
    '10110111000',
    '10110001110',
    '10001101110',
    '10111011000',
    '10111000110',
    '10001110110',
    '11101110110',
    '11010001110',
    '11000101110',
    '11011101000',
    '11011100010',
    '11011101110',
    '11101011000',
    '11101000110',
    '11100010110',
    '11101101000',
    '11101100010',
    '11100011010',
    '11101111010',
    '11001000010',
    '11110001010',
    '10100110000',
    '10100001100',
    '10010110000',
    '10010000110',
    '10000101100',
    '10000100110',
    '10110010000',
    '10110000100',
    '10011010000',
    '10011000010',
    '10000110100',
    '10000110010',
    '11000010010',
    '11001010000',
    '11110111010',
    '11000010100',
    '10001111010',
    '10100111100',
    '10010111100',
    '10010011110',
    '10111100100',
    '10011110100',
    '10011110010',
    '11110100100',
    '11110010100',
    '11110010010',
    '11011011110',
    '11011110110',
    '11110110110',
    '10101111000',
    '10100011110',
    '10001011110',
    '10111101000',
    '10111100010',
    '11110101000',
    '11110100010',
    '10111011110',
    '10111101110',
    '11101011110',
    '11110101110',
    '11010000100',
    '11010010000',
    '11010011100'
];
    $c128stop = '1100011101011';
    $bcBits = '';
    if ($bcTexto !== '') {
        if (ctype_digit($bcTexto) && strlen($bcTexto) % 2 === 0) {
            $vals = [105];
            for ($k = 0; $k < strlen($bcTexto); $k += 2) { $vals[] = (int) substr($bcTexto, $k, 2); }
        } else {
            $vals = [104];
            foreach (str_split($bcTexto) as $ch) { $o = ord($ch); $vals[] = ($o < 32 || $o > 126 ? 63 : $o) - 32; }
        }
        $sum = $vals[0];
        for ($k = 1; $k < count($vals); $k++) { $sum += $vals[$k] * $k; }
        $vals[] = $sum % 103;
        foreach ($vals as $v) { $bcBits .= $c128[$v]; }
        $bcBits .= $c128stop;
    }
    $bcHtml = '';
    if ($bcBits !== '') {
        $mod = 0.9; $runs = []; $cur = $bcBits[0]; $len = 0;
        foreach (str_split($bcBits) as $b) {
            if ($b === $cur) { $len++; } else { $runs[] = [$cur, $len]; $cur = $b; $len = 1; }
        }
        $runs[] = [$cur, $len];
        $bcHtml = '<table cellpadding="0" cellspacing="0" style="margin:0 auto;border-collapse:collapse;"><tr>';
        foreach ($runs as $r) {
            $bcHtml .= '<td style="width:' . round($r[1] * $mod, 2) . 'px;height:20px;padding:0;font-size:0;line-height:0;background:' . ($r[0] === '1' ? '#000' : '#fff') . ';"></td>';
        }
        $bcHtml .= '</tr></table>';
    }

    $logoB64   = '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';
    $palletB64 = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAMCAgICAgMCAgIDAwMDBAYEBAQEBAgGBgUGCQgKCgkICQkKDA8MCgsOCwkJDRENDg8QEBEQCgwSExIQEw8QEBD/2wBDAQMDAwQDBAgEBAgQCwkLEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBD/wAARCABQAIIDASIAAhEBAxEB/8QAHQABAAIDAQEBAQAAAAAAAAAAAAYIBQcJBAECA//EAEYQAAAEBQEBCBAEAwkAAAAAAAECAwQABQYREgchCBMUMUFSVpEVFhcYIlFTYYGSlJXS09ThMjNXl1ST0QkmQkVkcoKHof/EABsBAAICAwEAAAAAAAAAAAAAAAADBAcCBQYB/8QALREAAQMDAwIGAQQDAAAAAAAAAQACAwQRMQUhQRJhBhNRkaHBcSJCkrHR4fH/2gAMAwEAAhEDEQA/AOVUIQgQkIQgQkIQgQkIQgQkIQgQkIQgQkIQgQkIQgQkIQgQkIQgQuqG400KoumKJmrqTTSsWD+YJ0+8dP5XVszlSy5XlOSmYigoDFdBM6aS8wdb1kQTlKpYxjccWC7njX9QNVv3OqP66Kf7gJVbeZyiVU4E4O0NgBhtfsew228cXFEVOcfrGKp1bUatlbIYpHNBsbAkcBWRDpVNTAwPY1xYXNuWjexIvzn0upDMNIqfCmhdhWmqm+nQIJhHVCpRAcrAOwZhblGIz3PGv6garfudUf10TeY1VKnNIhJkVF+FA3STsKQgGRRLfb6BiG5Kc4/WMRqnU6rrDo5nYF7OPF+/dIo9PhDXeZEMnIGFHn+j9NozlefEqXUbsi9bItnD0dQ5+K6yKRjmSTOpw3IxCCssJSiNiiqcQsJhj8DpxLLD/fHUsP8AsaofroiqK7gdZZ6kK6okLLUBAgnGwD4HJxRMBMpzzdYxqKiFksnmSgOcdyTuTf1JU9lJTkbRt9gppNNIqeToorwlZapAqLZE23U6pBLcRL/hF/j/AORBu5xK+mGpf7jVD9dGxJrWkjd0KWQIKueGg1QSsKIgXIolv4XoGIBkpzzdYxJ1HoqnsdJ+qzQN97Z2/wBKJQ0MTWu8yMZOR+F9k2kVOITR7P29S6joTFy2QaLPEtRKgIsqgmY5k0jqA9yMQhlVjFKIiBRVOIAGQxmO541/UDVb9zqj+ujXVLruB1iniIrqiQJWkIEzHEBuTbbijZQipzj9YwyOrqaNojhlc1tgbAkDHZSTRUrjcxN/iP8ACkMw0ip8KaF2Faaqb6dAgmEdUKlEBysA7BmFuUYjPc8a/qBqt+51R/XRN5jVUqc0iEmRUX4UDdJOwpCAZFEt9voGIbkpzj9YxKqdTqusOjmdgXs48X791Co9PhDXeZEMnIGFSf8AtD9IKXZpy+swmNUPJs1p16vwub1C+mqqoIzKVoJpGO9VWOVMpZi5MBSGL4RgHxgNAIvFu8lVT1NOUzqnMUlOjiUxhEC3fyq9g5Io7FgeGpnzUAMhuQTueb7/AGuV1wRtrCyNoaAANv7skIQjfrUJCEIELoduI2U5kcgmk9e0nOl2iwM2xSpsjApkMslypTYHxHAyZyHKfiMU5TFESiAxZ7tpT6CVJ7vD4o0puNtT0p7TL+U9h1G6iDeSlzBwBgEG1PShnf8ACG03B87cmVrja42MGdhb8lT14pmvke6a8zbOs24vjYbK1I/NeXOnFnlzuoDAPUbgbnnufysUpMZik04cpppVZW4lA2+jLQxsPEN8vPHj7aE+glSe7w+KN4zt4KemxHQ5CHA2xscvGJI1f2bDyKnrwqoY2EgAZF8pNLKahrieDZa0bs56NezOqy0VPTS92zSbJpg0uoUxcb5FvsDZsG8Z/h8w6B1J7AHxRn5DqK3c1dMaSCVrlVatU3IuN+DEwDjsta/L4+SJUM8C35Snrwp7rkdQ4CkAWwtfnJP02/Cz6b1SVEQA2Yy7ZYeIfxR5uHzDoFUnsAfFFh5q8FOhiufCEODIjjl4xLEB7Nh5FT14bURshIAGRdR6Wd07STwbLTErbTuV15Maoe0XPRYvWRG6SYNLqAYokuIlvsDZx3iU9tKfQSpPd4fFGRX1GQeVm9pMsrXIoxakXM4FYBKcDY7AC1w4/HGQGdhb8lT14U9xuOocBSWtusUpMZik04cpppVZW4lA2+jLQxsPEN8vPHj7aE+glSe7w+KN4zt4KemxHQ5CHA2xscvGJI1f2bDyKnrw2oY2EgAZF8qNSymoa4ng2VD93Mm/M+dTpaQTRk1mUhWSbgu0OAl3t/KshPiAgmW9gyMIAImKW+RigNIo6B7vWs0pgzcyAsvUIdrTTtMyxlQEDb5NZIoAgFuTebf8vNHPyLJ8LEHTwRm5v8fVlxevta2tPSb7C/Y/8skIQjolpUhCECF0D3DGQNpviW47w02Xt/l7CLZZK+SL6/2jT+5K0XplnQzxRKbT0HCiVPuzOSOiJqWeUvJXp0vAIUMCKOVCk2ZYFLkJjAJh3l3KZP0lqj3h9op/WGhta9jjuLD2AVpxVLavqqGAhr3OcL5sXEi+d18WqWo3EvCUrTBY7MCFJvIqBjiW1g4uSwRjslfJF9f7RNHehdLoU+ExJU1W7/vRD7ZnsuIhfZj54jvcpk/SWqPeH2iFNEYyA93HdYwSskBMYtv8qAUwKgaxz0SpgJuxSWzK3KTltGyc3H8OX+b9owzjSaQMHxpg0m9QJO1k8FHRXtlVCgIWKJrbQC0fkaCQ6W1T7xH+kYPcx5G/ATQCpSrP6gWZdjlXKh2oFAm9CsGOIcQfh8wR4c3H8OX+b9oyj/RmRtqVLOEqurDhIoJKbZp4NzCW+zHzxEe0JDpbVPvEf6RnNGYyA93HdJp3slBMYtY/KhiAn7s0+HAMuxje4Zf7OWJjkr5Ivr/aP6MNI6eXdOJoebVADw5CkO7B7ZVQuyxTGttALbI93cpk/SWqPeH2jB5a8ix4Cc27V8WqWo3EvCUrTBY7MCFJvIqBjiW1g4uSwRjslfJF9f7RNHehdLoU+ExJU1W7/vRD7ZnsuIhfZj54jvcpk/SWqPeH2jOaIxkB7uO6VBKyQExi2/yqJbuG/ZmbXCw9r59l/wDXymKSx0K3f+nEqp+RozRhNJsZU1OzBdYzhYivCMJrJEikOJiXxAFxN4IlG5Cbccim56xZfhZttPDvUn6H0uH1+NzK1xPIB+vpIQhHRLTJCEIELoluAlVt5nKJVTgTg7Q2AGG1+x7DbbxxcURU5x+sYoBuPtY9NdP5XM31WVMwbEXBu2Iio4TTVExGTMhjYKGKOIGTOXINgiUbRY3vudz70rY+0t/mRUuqUdRJVEtYTjg+gVpSVcDppXNeCC95BuNwXHdWkmNVSpzSISZFRfhQN0k7CkIBkUS32+gYhuSnOP1jGje+53PvStj7S3+ZDvudz70rY+0t/mRElpayYgujO22CkQvp4AQ143N8hSRFdwOss9SFdUSFlqAgQTjYB8Dk4omAmU55usYr8luitGCV9M6qGtpRwB4zSbpJ8OQ3wDFxvcuewNg8sZ7vqNCemEt9sb/MjyWhqSRaM4HBTW1ULcvHurRTWtJG7oUsgQVc8NBqglYURAuRRLfwvQMQDJTnm6xjTnfUaE9MJb7Y3+ZDvqNCemEt9sb/ADIJaWslILozsLYKXDJTQAhrxub5Cm9LruB1iniIrqiQJWkIEzHEBuTbbijZQipzj9YxWOUbozReX15MqodVtKDMXbJNummV83FQDhjxlz4tg8sSrvudz70rY+0t/mQSUNS4i0ZwOCmCphH7x7q0kxqqVOaRCTIqL8KBuknYUhAMiiW+30DENyU5x+sY0b33O596VsfaW/zId9zufelbH2lv8yPZaWsmILozttgpUL6eAENeNzfIVfN3kqqeppymdU5ikp0cSmMIgW7+VXsHJFHYtpuvtUaBreZOppS1RMniMykyjNBNBYipyqleS4+JwTE2FyIqiAmEAHAbbdkVLixPDUT4qLpeCDfn8BcRrT2vrXuabjb+khCEdCtWv//Z';

    // Resumen por paleta (se reutiliza abajo)
    $paletaInfo = [];
    foreach ($paletas as $nombre => $items) {
        $pStatus = 'pc-ok'; $pTxt = 'COMPLETA'; $pEst = ['Completa', 'st-ok', '✔'];
        if ($items->contains(fn($d) => $d->cantidad_despachada == 0))                       { $pStatus = 'pc-no';  $pTxt = 'CON INCIDENCIAS'; $pEst = ['Con incidencias', 'st-no', '✖']; }
        elseif ($items->contains(fn($d) => $d->cantidad_despachada < $d->cantidad_solicitada)) { $pStatus = 'pc-par'; $pTxt = 'PARCIAL';         $pEst = ['Parcial', 'st-par', '⚠']; }
        $paletaInfo[$nombre] = [
            'status' => $pStatus, 'txt' => $pTxt, 'est' => $pEst,
            'prods'  => $items->count(),
            'cajas'  => $items->sum(fn($d) => $cajas($d)),
            'uds'    => $items->sum('cantidad_despachada'),
            'peso'   => $items->sum(fn($d) => ($d->cantidad_despachada * ($d->product->peso ?? 0)) / 1000),
        ];
    }

    $noDesp  = $detalles->filter(fn($d) => $d->cantidad_despachada == 0)->values();
    $parcial = $detalles->filter(fn($d) => $d->cantidad_despachada > 0 && $d->cantidad_despachada < $d->cantidad_solicitada)->values();
@endphp

{{-- ═══════════════════════ PÁGINA 1 ═══════════════════════ --}}

{{-- HEADER --}}
<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:190px; vertical-align:middle;">
            <table cellpadding="0" cellspacing="0"><tr>
                <td style="vertical-align:middle; padding-right:7px;"><img src="data:image/jpeg;base64,{{ $logoB64 }}" width="38" height="38" alt=""></td>
                <td style="vertical-align:middle;">
                    <div class="brand-name">DISTAN <span>ERP</span></div>
                    <div class="brand-sub">Sistema de Gestión</div>
                </td>
            </tr></table>
        </td>
        <td style="vertical-align:middle;">
            <div class="doc-title">ORDEN DE DESPACHO</div>
            <div class="doc-tipo">{{ $order->tipo_orden }}</div>
            <div class="doc-meta">Estado: {{ $order->estado }} · Generado: {{ now()->format('d/m/Y H:i') }}</div>
        </td>
        <td style="width:175px; vertical-align:middle;">
            <div class="ord-box">
                <div class="ord-lbl">N° ORDEN</div>
                <div class="ord-num">{{ $order->numero_orden }}</div>
                @if($bcHtml)
                <div class="bc-wrap">{!! $bcHtml !!}<div class="bc-txt">@if($pedidoCli)Pedido N° {{ $pedidoCli }}@else{{ $bcTexto }}@endif</div></div>
                @endif
            </div>
        </td>
    </tr>
</table>

{{-- CLIENTE / PROVEEDOR --}}
<table style="width:100%; border-collapse:separate; border-spacing:0; margin-bottom:8px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:50%; padding-right:4px; vertical-align:top;">
            <div class="card">
                <div class="card-lbl">Cliente</div>
                <div class="card-name">{{ $cli?->razon_social ?? '—' }}</div>
                <div class="card-line"><b>RUC:</b> {{ $cli->ruc ?? $cli->numero_documento ?? '—' }}</div>
                <div class="card-line"><b>Dirección:</b> {{ $cli->direccion ?? '—' }}</div>
            </div>
        </td>
        <td style="width:50%; padding-left:4px; vertical-align:top;">
            <div class="card">
                <div class="card-lbl">Proveedor</div>
                <div class="card-name">{{ $provNombre ?: '—' }}</div>
                <div class="card-line"><b>RUC:</b> {{ $provRuc ?: '—' }}</div>
                <div class="card-line"><b>Dirección:</b> {{ $provDir ?: '—' }}</div>
            </div>
        </td>
    </tr>
</table>

{{-- DATOS DE LA ORDEN --}}
<table class="chips" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Fecha de emisión</div><div class="chip-val">{{ $f($order->fecha_pedido) }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Fecha de entrega</div><div class="chip-val">{{ $f($order->fecha_entrega ?? null) }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Tienda / Destino</div><div class="chip-val">{{ $order->tienda ?? $order->destino ?? $cli->tienda ?? '—' }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">Tipo de pedido</div><div class="chip-val">{{ ucfirst(strtolower((string) $order->tipo_orden)) }}</div></div></td>
        <td style="width:20%;"><div class="chip"><div class="chip-lbl">N° de guía / Ref.</div><div class="chip-val">{{ $order->guia_asociada ?? '—' }}</div>@if($order->factura_asociada ?? null)<div class="chip-lbl" style="margin-top:1px;">Fact. {{ $order->factura_asociada }}</div>@endif</div></td>
    </tr>
</table>

{{-- RESUMEN DE LA ORDEN --}}
<div class="panel">
    <div class="sec"><span class="sec-ic">≡</span>Resumen de la orden</div>
    <table class="kpis" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:16.6%;"><span class="kpi-ic">▣</span><div class="kpi-n">{{ $detalles->count() }}</div><div class="kpi-l">Productos<br>SKU diferentes</div></td>
            <td style="width:16.6%;"><span class="kpi-ic">≡</span><div class="kpi-n">{{ $n($solTotal) }}</div><div class="kpi-l">Unidades<br>solicitadas</div></td>
            <td style="width:16.6%;"><span class="kpi-ic" style="background:#d9f5e3;color:#15803d;">✔</span><div class="kpi-n">{{ $n($totalUds) }}</div><div class="kpi-l">Unidades<br>despachadas</div></td>
            <td style="width:16.6%;"><span class="kpi-ic" style="background:#fde0e0;color:#dc2626;">!</span><div class="kpi-n">{{ $n($penTotal) }}</div><div class="kpi-l">Unidades<br>pendientes</div></td>
            <td style="width:16.6%;"><span class="kpi-ic">▦</span><div class="kpi-n">{{ $paletasConNombre->count() }}</div><div class="kpi-l">Paletas<br>a despachar</div></td>
            <td style="width:16.6%;"><span class="kpi-ic">⚖</span><div class="kpi-n">{{ number_format($pesoTotal, 2) }} kg</div><div class="kpi-l">Peso total<br>despachado</div></td>
        </tr>
    </table>
</div>

{{-- DETALLE DE PRODUCTOS (ordenado por id) --}}
<div class="panel" style="padding-bottom:8px;">
    <div class="sec"><span class="sec-ic">▤</span>Detalle de productos</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width:4%;">#</th>
                <th style="width:10%;">Código</th>
                <th style="width:28%;">Producto</th>
                <th style="width:11%;">Presentación</th>
                <th style="width:9%;">Solicitado</th>
                <th style="width:9%;">Despacho</th>
                <th style="width:8%;">Faltante</th>
                <th style="width:10%;">Vencimiento</th>
                <th style="width:15%;">Estado</th>
            </tr>
        </thead>
        <tbody>
        @foreach($detalles as $i => $item)
        @php
            $fecha   = $item->fecha_vencimiento ?? $item->product->fecha_vencimiento;
            $cpc     = (int) ($item->product->cantidad_por_caja ?? 0);
            $pres    = $item->product->presentacion ?? ($cpc > 0 ? 'Caja x ' . $cpc : '—');
            $falt    = max($item->cantidad_solicitada - $item->cantidad_despachada, 0);
            [$eTxt, $eCls, $rCls, $eIc] = $est($item);
        @endphp
        <tr class="{{ $rCls }}">
            <td style="color:#64748b;">{{ $loop->iteration }}</td>
            <td style="color:#334155;">{{ $item->product->sku ?? '—' }}</td>
            <td class="l" style="font-weight:700;">{{ $item->product->nombre }}</td>
            <td>{{ $pres }}</td>
            <td>{{ $n($item->cantidad_solicitada, 2) }}</td>
            <td style="font-weight:800;">{{ $n($item->cantidad_despachada, 2) }}</td>
            <td style="font-weight:800;color:{{ $falt > 0 ? '#dc2626' : '#15803d' }};">{{ $n($falt, 2) }}</td>
            <td>{{ $f($fecha) }}</td>
            <td><span class="st {{ $eCls }}">{{ $eIc }} {{ $eTxt }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- OBSERVACIONES + FIRMAS --}}
<table style="width:100%; border-collapse:separate; border-spacing:0;" cellpadding="0" cellspacing="0">
    <tr>
        <td class="obs-box" style="width:46%;">
            <div class="obs-t">Observaciones</div>
            <div class="obs-x">{!! nl2br(e($order->observaciones ?: 'Sin observaciones registradas.')) !!}</div>
        </td>
        <td style="width:54%; padding-left:10px; vertical-align:bottom;">
            <table style="width:100%; border-collapse:collapse;" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="firma" style="width:33%;"><div style="height:32px;"></div><div class="firma-line">Preparado por</div></td>
                    <td class="firma" style="width:33%;"><div style="height:32px;"></div><div class="firma-line">Revisado por</div></td>
                    <td class="firma" style="width:34%;"><div style="height:32px;"></div><div class="firma-line">Recibido conforme</div></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ═══════════════════════ PÁGINA 2 ═══════════════════════ --}}
<div style="page-break-before:always;"></div>

<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:190px; vertical-align:middle;">
            <table cellpadding="0" cellspacing="0"><tr>
                <td style="vertical-align:middle; padding-right:7px;"><img src="data:image/jpeg;base64,{{ $logoB64 }}" width="38" height="38" alt=""></td>
                <td style="vertical-align:middle;">
                    <div class="brand-name">DISTAN <span>ERP</span></div>
                    <div class="brand-sub">Sistema de Gestión</div>
                </td>
            </tr></table>
        </td>
        <td style="vertical-align:middle;">
            <div class="doc-title">ORDEN DE DESPACHO</div>
            <div class="doc-tipo">{{ $order->tipo_orden }}</div>
        </td>
        <td style="width:175px; vertical-align:middle;">
            <div class="ord-box">
                <div class="ord-lbl">N° ORDEN</div>
                <div class="ord-num">{{ $order->numero_orden }}</div>
                @if($bcHtml)
                <div class="bc-wrap">{!! $bcHtml !!}<div class="bc-txt">@if($pedidoCli)Pedido N° {{ $pedidoCli }}@else{{ $bcTexto }}@endif</div></div>
                @endif
            </div>
        </td>
    </tr>
</table>

{{-- DESGLOSE POR PALETAS (ordenadas P01→P02...) --}}
<div class="sec" style="margin-bottom:6px;"><span class="sec-ic">▦</span>Desglose por paletas</div>

<table style="width:100%; border-collapse:separate; border-spacing:0;" cellpadding="0" cellspacing="0">
@foreach($paletas->chunk(2) as $par)
    <tr>
    @foreach($par as $paleta => $items)
    @php $pi = $paletaInfo[$paleta]; $pesoPaletaAcum = 0; $totalPaletaAcum = 0; @endphp
        <td class="pcell {{ $loop->last && $loop->count == 2 ? 'pcell-r' : '' }}" style="width:50%;">
            <table class="pcard" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="pcard-h">{{ $paleta === 'SIN PALETA' ? 'Sin paleta' : 'Paleta ' . $paleta }}</td>
                    <td class="pcard-hr"><span class="pchip {{ $pi['status'] }}">{{ $pi['txt'] }}</span></td>
                </tr>
                <tr><td colspan="2" class="pbody">
                    <table class="pstats" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:36%; text-align:left;"><img src="data:image/jpeg;base64,{{ $palletB64 }}" width="64" alt=""></td>
                            <td><b>{{ $pi['prods'] }}</b>Productos</td>
                            <td><b>{{ $pi['cajas'] }}</b>Cajas</td>
                            <td><b>{{ $n($pi['uds']) }}</b>Unidades</td>
                            <td><b>{{ number_format($pi['peso'], 2) }} kg</b>Peso</td>
                        </tr>
                    </table>
                    <table class="ptbl" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr><th style="width:5%;">#</th><th style="width:17%;">Código</th><th>Producto</th><th style="width:11%;">Cajas</th><th style="width:11%;">Unid.</th><th style="width:19%;">Vencimiento</th></tr>
                        </thead>
                        <tbody>
                        @foreach($items->sortBy('id') as $detail)
                        @php
                            $fecha2 = $detail->fecha_vencimiento ?? $detail->product->fecha_vencimiento;
                            $pesoD  = ($detail->cantidad_despachada * ($detail->product->peso ?? 0)) / 1000;
                            $pesoPaletaAcum  += $pesoD;
                            $totalPaletaAcum += $detail->cantidad_despachada;
                            [$dTxt, $dCls, $dRow, $dIc] = $est($detail);
                        @endphp
                        <tr class="{{ $dRow }}">
                            <td style="color:#64748b;">{{ $loop->iteration }}</td>
                            <td>{{ $detail->product->sku ?? '—' }}</td>
                            <td class="l" style="font-weight:700;">{{ $detail->product->nombre }}</td>
                            <td>{{ $cajas($detail) }}</td>
                            <td style="font-weight:800;">{{ $n($detail->cantidad_despachada) }}</td>
                            <td>{{ $f($fecha2) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- Totales originales de la paleta (unidades, peso y subtotal S/) --}}
                    <div class="ptfoot">Total paleta: {{ $n($totalPaletaAcum) }} u. · {{ number_format($pesoPaletaAcum, 3) }} kg · S/ {{ number_format($items->sum('subtotal'), 2) }}</div>
                </td></tr>
            </table>
        </td>
    @endforeach
    @if($par->count() < 2)
        <td style="width:50%;"></td>
    @endif
    </tr>
@endforeach
</table>

{{-- RESUMEN POR PALETAS --}}
<div class="panel" style="margin-top:2px;">
    <div class="sec"><span class="sec-ic">▤</span>Resumen por paletas</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead>
            <tr><th style="width:16%;">Paleta</th><th>Productos</th><th>Cajas</th><th>Unidades</th><th>Peso (kg)</th><th style="width:26%;">Estado</th></tr>
        </thead>
        <tbody>
        @foreach($paletas as $paleta => $items)
        @php $pi = $paletaInfo[$paleta]; @endphp
        <tr>
            <td style="font-weight:800;">{{ $paleta === 'SIN PALETA' ? 'Sin paleta' : 'Paleta ' . $paleta }}</td>
            <td>{{ $pi['prods'] }}</td>
            <td>{{ $pi['cajas'] }}</td>
            <td>{{ $n($pi['uds']) }}</td>
            <td>{{ number_format($pi['peso'], 2) }}</td>
            <td><span class="st {{ $pi['est'][1] }}">{{ $pi['est'][2] }} {{ $pi['est'][0] }}</span></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ collect($paletaInfo)->sum('prods') }}</td>
                <td>{{ collect($paletaInfo)->sum('cajas') }}</td>
                <td>{{ $n(collect($paletaInfo)->sum('uds')) }}</td>
                <td>{{ number_format(collect($paletaInfo)->sum('peso'), 2) }}</td>
                <td>—</td>
            </tr>
        </tfoot>
    </table>
</div>

{{-- PRODUCTOS NO DESPACHADOS / DESPACHADOS PARCIALMENTE --}}
@if($noDesp->count() || $parcial->count())
<table style="width:100%; border-collapse:separate; border-spacing:0;" cellpadding="0" cellspacing="0">
    <tr>
        @if($noDesp->count())
        <td class="fcell" style="width:{{ $parcial->count() ? '50%' : '100%' }}; {{ $parcial->count() ? 'padding-right:4px;' : '' }}">
            <div class="fbox-no">
                <div class="ftitle-no"><span class="sec-ic red">✖</span>Productos no despachados ({{ $noDesp->count() }})</div>
                <table class="ftbl" cellpadding="0" cellspacing="0">
                    <thead><tr><th class="no">Código</th><th class="no">Producto</th><th class="no">Solicitado</th><th class="no">Despacho</th><th class="no">Faltante</th><th class="no">Vencimiento</th></tr></thead>
                    <tbody>
                    @foreach($noDesp as $d)
                    <tr>
                        <td>{{ $d->product->sku ?? '—' }}</td>
                        <td class="l" style="font-weight:700;">{{ $d->product->nombre }}</td>
                        <td>{{ $n($d->cantidad_solicitada, 2) }}</td>
                        <td>{{ $n($d->cantidad_despachada, 2) }}</td>
                        <td style="font-weight:800;color:#b91c1c;">{{ $n($d->cantidad_solicitada - $d->cantidad_despachada, 2) }}</td>
                        <td>{{ $f($d->fecha_vencimiento ?? $d->product->fecha_vencimiento) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </td>
        @endif
        @if($parcial->count())
        <td class="fcell" style="width:{{ $noDesp->count() ? '50%' : '100%' }}; {{ $noDesp->count() ? 'padding-left:4px;' : '' }}">
            <div class="fbox-par">
                <div class="ftitle-par"><span class="sec-ic amb">⚠</span>Productos despachados parcialmente ({{ $parcial->count() }})</div>
                <table class="ftbl" cellpadding="0" cellspacing="0">
                    <thead><tr><th class="par">Código</th><th class="par">Producto</th><th class="par">Solicitado</th><th class="par">Despacho</th><th class="par">Faltante</th><th class="par">Vencimiento</th></tr></thead>
                    <tbody>
                    @foreach($parcial as $d)
                    <tr>
                        <td>{{ $d->product->sku ?? '—' }}</td>
                        <td class="l" style="font-weight:700;">{{ $d->product->nombre }}</td>
                        <td>{{ $n($d->cantidad_solicitada, 2) }}</td>
                        <td>{{ $n($d->cantidad_despachada, 2) }}</td>
                        <td style="font-weight:800;color:#a16207;">{{ $n($d->cantidad_solicitada - $d->cantidad_despachada, 2) }}</td>
                        <td>{{ $f($d->fecha_vencimiento ?? $d->product->fecha_vencimiento) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </td>
        @endif
    </tr>
</table>
@endif

{{-- FALTANTES (campos originales: producto, faltante) — respaldo si el detalle no los refleja --}}
@if(!empty($faltantes) && !$noDesp->count() && !$parcial->count())
<div class="panel" style="margin-top:8px;">
    <div class="sec"><span class="sec-ic red">✖</span>Productos no enviados</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead><tr><th style="text-align:left;">Producto</th><th>Cantidad faltante</th></tr></thead>
        <tbody>
        @foreach($faltantes as $fl)
        <tr>
            <td class="l">{{ $fl['producto'] }}</td>
            <td style="font-weight:800; color:#991b1b;">{{ $fl['faltante'] }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- RESUMEN GENERAL (campos originales) --}}
<table class="summary-table" cellpadding="0" cellspacing="0">
    <tr>
        <td style="color:#64748b;">Total unidades despachadas</td>
        <td>{{ number_format($totalUds) }} u.</td>
    </tr>
    <tr>
        <td style="color:#64748b;">Peso total despachado</td>
        <td>{{ number_format($pesoTotal, 2) }} kg</td>
    </tr>
    <tr>
        <td style="color:#64748b;">Total productos</td>
        <td>{{ $order->details->sum('cantidad_despachada') }}</td>
    </tr>
    <tr class="summary-total">
        <td>TOTAL S/</td>
        <td>S/ {{ number_format($order->total, 2) }}</td>
    </tr>
</table>

{{-- FOOTER --}}
<table class="footer" cellpadding="0" cellspacing="0">
    <tr>
        <td>DISTAN ERP · Generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}</td>
        <td>{{ $order->numero_orden }}</td>
    </tr>
</table>

</body>
</html>
