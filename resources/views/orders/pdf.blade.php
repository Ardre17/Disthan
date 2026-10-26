<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

/* Márgenes reales de la hoja A4 (en mm). OJO: el reset "* { margin:0 }" anulaba este margen en DomPDF. */
@page { margin: 12mm 12mm 18mm 12mm; }
* { box-sizing: border-box; }
div, span, p, b, table, thead, tbody, tfoot, tr, th, td, img, h1, h2, h3, ul, li { margin: 0; padding: 0; }

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
.brand-name { font-size:18px; font-weight:bold; color:#1d4ed8; letter-spacing:.3px; white-space:nowrap; }
.brand-name span { color:#0f2d5c; }
.brand-sub { font-size:8px; color:#64748b; margin-top:1px; }
.doc-title { font-size:15px; font-weight:bold; color:#0f2d5c; text-align:center; letter-spacing:.3px; }
.doc-tipo  { font-size:11px; font-weight:bold; color:#1d4ed8; text-align:center; margin-top:3px; text-transform:uppercase; }
.doc-meta  { font-size:7.5px; color:#94a3b8; text-align:center; margin-top:4px; }
.ord-box   { background:#0b4ea2; color:#fff; border-radius:7px; padding:6px 10px 8px; text-align:center; }
.ord-lbl   { font-size:7.5px; letter-spacing:.12em; color:#bcd6fb; }
.ord-num   { font-size:15px; font-weight:bold; letter-spacing:.5px; margin:1px 0 4px; }
.bc-wrap   { background:#fff; border-radius:4px; padding:4px 6px 2px; text-align:center; }
.bc-txt    { font-size:7px; color:#334155; margin-top:2px; }

/* TARJETAS */
.card { background:#fff; border:1px solid #d6e4f5; border-radius:7px; padding:8px 10px; }
.card-lbl { font-size:8.5px; font-weight:bold; color:#0f2d5c; }
.card-name { font-size:10px; font-weight:bold; color:#0f2d5c; margin:1px 0 3px; }
.card-line { font-size:8px; color:#475569; }
.card-line b { color:#64748b; font-weight:bold; display:inline-block; width:54px; }

/* CHIPS DE DATOS */
.chips { width:100%; border-collapse:collapse; margin-bottom:10px; }
.chips td { padding-right:5px; vertical-align:top; }
.chips td:last-child { padding-right:0; }
.chip { background:#f5f9ff; border:1px solid #d6e4f5; border-radius:7px; padding:6px 8px; }
.chip-lbl { font-size:7.5px; color:#64748b; }
.chip-val { font-size:9.5px; font-weight:bold; color:#0f2d5c; margin-top:1px; }

/* SECCIONES */
.panel { background:#eef5fd; border:1px solid #dbe7f6; border-radius:8px; padding:8px 10px; margin-bottom:10px; }
.sec { font-size:10px; font-weight:bold; color:#0f2d5c; margin-bottom:7px; }

/* KPIs */
.kpis { width:100%; border-collapse:collapse; }
.kpis td { text-align:center; padding:2px 3px; }
.kpi-n { font-size:15px; font-weight:bold; color:#0f2d5c; line-height:1.1; }
.kpi-l { font-size:7.5px; color:#475569; line-height:1.2; }

/* TABLAS */
.tbl { width:100%; border-collapse:collapse; font-size:8.5px; background:#fff; }
/* Las cabeceras se repiten en cada hoja y las filas no se cortan entre páginas */
.tbl thead, .ptbl thead, .ftbl thead { display:table-header-group; }
.tbl tr, .ptbl tr, .ftbl tr { page-break-inside:avoid; }
.tbl thead th { background:#0b4ea2; color:#fff; padding:5px 5px; text-align:center; font-size:8px; font-weight:bold; border-right:1px solid #2d6bbd; }
.tbl thead th:last-child { border-right:none; }
.tbl tbody td { padding:4.5px 5px; border-bottom:1px solid #e6eef9; text-align:center; vertical-align:middle; }
.tbl tbody td.l { text-align:left; }
.tbl tfoot td { padding:5px 5px; background:#e8f1fc; font-weight:bold; color:#0f2d5c; text-align:center; border-top:2px solid #0b4ea2; }

/* ESTADOS */
.st { display:inline-block; padding:2px 6px; border-radius:9px; font-size:7.2px; font-weight:bold; white-space:nowrap; }
.st-ok  { background:#dcfce7; color:#15803d; }
.st-par { background:#fde9b3; color:#a16207; }
.st-no  { background:#fecaca; color:#b91c1c; }
.row-par td { background:#fff7dc !important; }
.row-no  td { background:#ffe3e3 !important; }

/* PALETAS */
.pcell { vertical-align:top; padding:0 5px 8px 0; }
.pcell-r { padding:0 0 8px 5px; }
.pcard { width:100%; border-collapse:collapse; page-break-inside:avoid; }
.pcard-h { background:#0b4ea2; color:#fff; padding:5px 8px; font-size:10px; font-weight:bold; border-radius:6px 0 0 0; }
.pcard-hr { background:#0b4ea2; text-align:right; padding:4px 6px; border-radius:0 6px 0 0; border-left:1px solid #0b4ea2; }
.pchip { display:inline-block; padding:3px 12px; border-radius:6px; font-size:7.5px; font-weight:bold; letter-spacing:.04em; }
.pc-ok { background:#16a34a; color:#fff; } .pc-par { background:#fbbf24; color:#422006; } .pc-no { background:#ef4444; color:#fff; }
.pbody { background:#f6f9fe; border:1px solid #d6e4f5; border-top:none; padding:6px 7px; }
.pstats { width:100%; border-collapse:collapse; }
.pstats td { text-align:center; font-size:7.5px; color:#475569; padding:0 2px; }
.pstats b { display:block; font-size:9.5px; color:#0f2d5c; font-weight:bold; white-space:nowrap; }
.ptbl { width:100%; border-collapse:collapse; font-size:7.5px; background:#fff; margin-top:6px; }
.ptbl thead th { background:#0b4ea2; color:#fff; padding:3.5px 3px; font-size:7px; text-align:center; border-right:1px solid #2d6bbd; }
.ptbl tbody td { padding:3.5px 3px; border-bottom:1px solid #e6eef9; text-align:center; }
.ptbl tbody td.l { text-align:left; }
.ptfoot { font-size:7.5px; color:#0b4ea2; font-weight:bold; text-align:right; margin-top:3px; }

/* FALTANTES */
.fcell { vertical-align:top; }
.fbox-no  { background:#fff1f1; border:1px solid #fecaca; border-radius:7px; padding:7px 8px; }
.fbox-par { background:#fffaf0; border:1px solid #fde7b0; border-radius:7px; padding:7px 8px; }
.ftitle-no  { font-size:9px; font-weight:bold; color:#b91c1c; margin-bottom:5px; }
.ftitle-par { font-size:9px; font-weight:bold; color:#a16207; margin-bottom:5px; }
.ftbl { width:100%; border-collapse:collapse; font-size:7.5px; background:#fff; }
.ftbl thead th { padding:3.5px 3px; font-size:7px; text-align:center; color:#fff; }
.ftbl thead th.no  { background:#dc2626; }
.ftbl thead th.par { background:#d97706; }
.ftbl tbody td { padding:3.5px 3px; border-bottom:1px solid #f1f5f9; text-align:center; }
.ftbl tbody td.l { text-align:left; }

/* OBSERVACIONES + FIRMAS */
.obs-box { background:#eef5fd; border:1px solid #dbe7f6; border-radius:8px; padding:8px 10px; vertical-align:top; }
.obs-t { font-size:9.5px; font-weight:bold; color:#0f2d5c; margin-bottom:4px; }
.obs-x { font-size:8.5px; color:#334155; line-height:1.5; }
.firma { text-align:center; vertical-align:bottom; padding:0 8px; }
.firma-line { border-top:1px solid #334155; padding-top:4px; font-size:8.5px; font-weight:bold; color:#0f2d5c; }

/* RESUMEN GENERAL (original) */
.summary-table { width:100%; border-collapse:collapse; margin-top:10px; border:1.5px solid #0b4ea2; background:#fff; }
.summary-table td { padding:6px 12px; border-bottom:1px solid #e2e8f0; font-size:9.5px; }
.summary-table td:last-child { text-align:right; font-weight:bold; color:#0f2d5c; font-size:10.5px; }
.summary-total td { background:#0b4ea2; color:#fff !important; font-weight:bold; font-size:11.5px; padding:8px 12px; }
.summary-total td:last-child { color:#bcd6fb !important; font-size:13.5px; }

/* FOOTER (fijo al pie de cada hoja, con numeración) */
.pgfooter { position:fixed; left:0; right:0; bottom:-12mm; }
.footer { border-top:1px solid #d6e4f5; padding-top:5px; width:100%; border-collapse:collapse; }
.footer td { font-size:7.5px; color:#94a3b8; padding-top:4px; }
.footer td.c { text-align:center; }
.footer td.r { text-align:right; }
.pn:before { content: counter(page); }


</style>
</head>
<body>

{{-- FOOTER (se repite en cada hoja) --}}
<div class="pgfooter">
    <table class="footer" cellpadding="0" cellspacing="0">
        <tr>
            <td>DISTAN ERP · Generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}</td>
            <td class="c">{{ $order->numero_orden }}</td>
            <td class="r">Página <span class="pn"></span></td>
        </tr>
    </table>
</div>

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
        if ($d->cantidad_despachada == 0)                         return ['No despachado', 'st-no',  'row-no',  'X'];
        if ($d->cantidad_despachada < $d->cantidad_solicitada)    return ['Parcial',       'st-par', 'row-par', '!'];
        return ['Completo', 'st-ok', '', 'OK'];
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

    $logoB64   = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQECAgMCAgICAgQDAwIDBQQFBQUEBAQFBgcGBQUHBgQEBgkGBwgICAgIBQYJCgkICgcICAj/2wBDAQEBAQICAgQCAgQIBQQFCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAj/wAARCAB4AHgDAREAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+/igAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKAOe8V+K9A8EeH9W8UeJ9Ri0vRLK3luriZgTsjjjaRyFGScIjsQB0UnoDXThMJUr1FSpq7ZlWrwprmm7HxF4O/4KGfCrxLq9zBq3h7xR4T8NvdJDYancwvIJ4ygBeWFELQnzCQPvIYx5m8A7R+j4vwlzanQ9uo3Xp/T/AA/DU/P8P4mZdPELCyklUfS6f4r3P/Jvx0Ptjwr4y8LeN9MTVvCuuadrdmViZ/IkBe3MkSSqkqfejcxyxtscBgGGRzX5vicJUoy5akWmfoFOtGavFnTVzmoUAFABQAUAFABQAUAFABQBg+J/E+geC/D+r+K/FWq2mh+HbCBrm8u5ziO3iHVmPpXRhcLUrVFSpK8nsiKlSMU5Sdkj8upP+Cnmh+KvEnxp8L+B/h9rL6Bo14mn+HfFX2lTba5/o6GacRug8nZcS+QsblnJhnd0UCFbj9jyXwaxuJ9jKPvN3547cvbXZ+dv+G/OeJ/EjAYGjN+0Sl9nTmv8rr5XsmtU2fnpd+LvF19pcmka5408U+KbA3c979nvbqSS3jmlneY7YmLbiruNjSbiqBEU+WqIv9W8OeFeCw7VatFOpp+H+R/N/EfihXxqcKb5U+z1fq+z6pWj5GB503mecJG87H3q/S6VC0fZ1EuVH5dBSc+e+ppeE9a1jwP4s0/xr4L1/V/B/ieAyFJbWd/sz73VpDJa79hZjFCZGABcRRK5ZFCn8+4t8OMDmlNpJRb623/rvufonC3iJisC1QxLcop97Na30a/J3jrqmfp38J/+Civh+N49N/aB0218AQTTKltrsd0s9kGkd9sMzBExtHkxCYKvmyFiIolAz/IXFvg9j8DP91G+m2uvo9fub+bP6g4c8SMDmM40qLu3vsuX1Tet+8b262P08hmhuYYri3lint5FDo6MGV1IyCCOCCO9fjk4uLcZKzR+ixkmrokqRhQAUAFABQAUANd0jRpJGVEUEsxOAB6k04xbdkB8h/E79tr4H/DzU5fDOneI7Dx140jmRJNK0u5R5UTzZI5XOMkiNoJI2IBVZWhjkaPzVavtMk4BzLHNezg0n5f0uvVrr2PmuIOKcNl9CVeo1Zab6X+Sb+STfyu1+Mc3x0/am8Tan46X4rfHIeKfB2ou0emaFp2n/YhZwPgSJd3CSeXcKSiGNY4ozFG8kbvct++b+x+HfBzK4UqFaWHtUj8Wr1/r5fM/mXijxZxmIrzpYOfuO1tFpprbt6tt3V043aOEiit7W2tLK0ghs7GFFjgtoV2QwR8KFVFIwOABgkgAA9a/YMBRVJKhTjax+P1sZPET5qsuabv8+5KqMxCqm+uyqm/ebtYwp0VeyWoU176s9gnFt6Cdcg9K0hyr4TOpVg4Om9XIhuYLa8s73Tb+1ttQ0y5jeG5trhN8VzE6lSjxsSGXkggjJBIFceLwSqpxkr3O3DY6thGsTSfLNbWNfQvFXxW8G+PPAnj34f8Axc8YeHDoUM9pBod1cyXWjmCaRHmItSyrvJReGyqqZFj8oyvKfxbifwmw9ajUhRpJyl+PnfpY/XuGPGHE0LfXX7v81r/erpO/fR31baVn+zXwr/4KHfs2fEjxLcfD3VPF0Xw6+KcASWfw7rStFPHBJN5cEwl2+W8UhaNRKjNEZTJEru8MgX+TOI/C3OMt96tSvHurflf8rn9GcM8c4LM4XpSV/nby1aTvps0n1s1Zv7kVldVdGV0IyCDkEV+dtNOzPsx1IAoAKACgD8Rf+C2v7VOofAX4SfDz4dW/hrRvE+i+N7q403WLfUGmSGW1aW2tFXdFLE3EmoRyEbtpEW1ldWKn9q8F+E45jjJVJP4HH8ZK/wCGn5WZ8Px3mWJw2FU8M7P3m9ukJNb+aR+Tvwv/AGg/h74knn0SS1t/AmvzzEzRTyhl1KRVCh/tbAGVyiRr+8w7bRktgGv9E5eG88soOFGF4qz031/P1P4Jr8Z43NKjjip63fpvsuiXktD6LJx2zXnwhfyOiEKctnqBI79Kl02l+73ImnB6H0P+yrpmn6x8evh/perafZapps011HNb3MSypIv2Wb5WVvlavyjxkx9elw/VqU24SVtnZ7rZrU++8NcG6udU6dVc0Xf8j75+Ln7B3hDxH9p1b4a3o8H6s3zfY5i0tpK3y9PvPF/4+v8Asiv5x4N8fcxwUlTzD95D5J/5P8PmfuHE/gvh8QnVwHuyPyv8e+B9f+HHirU/B/ii2htdYtGRZo45lkXmNXDKy/3lZW/4FX9i8J8S0M2wUcbQfuyv+dj+bM/ySWBqzw817yOPyCcd6+gUHFcyPJceaEWAwx2rgmiEpfa0ZNShCoveZ8M/tB/tw/Bv4b+d4S0yCD4r+NYZCiWtjc7LfSpgMF2vVy0TruYYhy6k8sp5r3aXhZUzWk6uJjywV3d7/d09fwN8v4tq5ZVX1aVntp18n3Xk9D9m/wDghJ+2Zrn7UHwV+JngDVvCeh+FLH4e3el6Pptvp0k7wRWslih2r57O4HmRTttLkDcQoVdqj/Nvxk4Vhl2NVSD+Ny/CTX4LTv3dz+7OC8yxGJoOVd3+G23WEW9vNs/dyvxs+zCgAoAKAP5yv+Dgl9PuNB/Zn024hZ7z7dqFzG3YKlzpp6/7wQ/hX9E/R/U44irOO14f+lI/PfEanzYPe2k//Tcz+eW8/wCPm5/66N/6FX+yeGdP2cI1Ve6X5H+XHtajxLjVdldnuHw0/aF8bfD/AMnTrmb/AISnwwPl+x3UjeZAv/TGX7y/7rblr43PeCMLi050fdl/W57eFzWpSer0P0C+Hvxc8EfEm3z4f1IJqoXdNYXH7u6i/wCA/wAS/wC0u6vx3N+H8Xg5Wqr3e/T/AIB9vl+bwqxs2fcH7IWE/aI+GuP+fm4/9JZq/BvHSLlw7Wl2t+Z+seD9SVHOqcVqtfyP33Vdy5GMfzr/ADulUalaWx/bUb2vHRs/B39tIY/aM8fgYx/oX/pFBX+g3gLKMuGaK7uX/pTP4p8XmlntSkvL8j83PjZ+0p8J/gJYiXxvr8cmvPH5lro1jtm1C6/7Zf8ALNf+mkm1f96v6AyXh7FY6Tp0Vp36f8H5fgfleKxCp0tz8Wfj1+298WvjSt/oOl3L/DvwDJuX+zdNmbzryP8A6ebn5Wk/3V2x/wCy1ftGR8CYfCtSxC5p9+3ov6fds+exONnP4T41t/lmtlVdnzLX3VSHs6E0tVZ/kcmGmvaL2muqP64f+DYyWxPg/wDbK+z486TXvD4YD/Y09wc/8Cdv1r/GL6QUJfWaLey5198v+Af6P8A2WGaX9z/03A/qar+dj7wKACgAoA/nQ/4OAwP7F/ZjbA3G71YE/wDbfTP8a/obwCf7+t60/wD0o/PfEX/dPlP/ANNzP537z/j5uf8Aro3/AKFX+ytJaQ9F+R/ls/4kvV/mVq1LJre4uLOeG6s7iWzvI28yOSNmWSJv7ysv3azq0oyTUlcqMmnoz9IP2Mf24YvhJ8YPAutfGlb3WvCdlNKJtTtIQ13bo0EkYaSMMqzLll3N97bub52+Vv5y8Z/B6rm+Q4illTXtXa0Xot7vXW2myWmy06fq/hrx1HLM2hUxfwdz+s74VfHP4U/G7wzF4r+FPjvw94z0RtqvJZz7mtnb+GeNsSRN/suqt7V/kzxJwXmWU4iWFzOi6cvPr6NaP5Nn+hGR8VYLHQjWozTifyJf8FoP20/iR8P/ANsb4xfBf4bW9t4Rlso9L+2a6G866l83SrSbbbK3yw7Vl27vmb+7tr/TH6J/CGDxHC2HxWN+Buat6TaP4z8bcdGPElSEetvyP52tQ1PUNWvrzVNV1C81XVbmTzLi6uJmkmuJP7zM3zM1f2RSwMaclCjpFbH4rXbi+TuVa6J7kEtt/wAfEP8A11Wsq38Kfo/yCj/Fj6o/rX/4NjgB4c/bGAAA/tnQDx/14Gv8Z/pA/wAaj6z/APSmf6R8Af7s/SH/AKbgf1SV/OR96FABQAUAfzof8HAZH9i/sxrkbhd6sSP+2+mf4V/Q3gEv39b1p/8ApR+e+Iv+6fKf/puZ/O/ef8fNz/10b/0Kv9laO0PRfkf5bf8ALyXq/wAytWpYUPzD0ChxoNRpvRMaTUZVHrNdTzXxj8Yvir8DPFvgPx78H/iB4s+HPi+2+1LHqGkXclvJt/d7o22/6yNv4o23K38S185xHwTlmb0Z4bMqMatLzS/rQ+v4U4hx2XV3Xw825HhH7QXx8+I37TfxV8Q/Gn4s6hp+q/EDVILKLULq2tI7ZLo29pDbJJ5Kfu1Zkt4921VXdu2qv3ax4K4Fy7JcvhleXJ+xpuTV238Tcnq9Xqz0eIs7nmmKlj6nxaf5HjFfW1azkoKelzx1L2lSMmFbPfQJEtt/x8Q/9dVrKt/Cn6P8hUf4sfVH9bH/AAbIceHf2xlPDf2x4fOPY2BxX+M/0gP41H1n/wClM/0j4A/3Z+kP/TcD+qOv5yPvQoAKACgD+cX/AIOCiE0b9maTyZPM+2agokBOCDdaaCMfkfxr+i/o/q9asr9Yf+lI/PPEfleBabtpP/03M/nqvP8Aj5uf+ujf+hV/sbh1KMKbk7aL8j/LmpF01Oo3om/zK1dLBO+oUhhSsEPhPm39oj7vhL/t4/8Aadbw2PUy56nzTVLTY9QKTVwQVVNezjoTyOpuS23/AB8Q/wDXVa551Kns56dH+R0YejTjUjd9Uf1jf8GyUk2oP+2leNqsl1FbXHhaDyvIKKC1jKuc9yot9nvjd3r/ABu+kBaEsPHltd1Hv2k/8z/R7gKzwza7Q/8ATcD+rWv5vPvAoAKACgD8aP8AgsZ+zF8Yfj98Ofh34o+FNtY6pD4S/tK+1W2mmVHFs4t2ZoV2NvfZbyDBwoO0kqMtX7H4O8R4LAYyUMZLlU3DXV7SvbT8D818UaeOeXuWApe0klO6vFWvCSTvJpWu1fXRXZ/JzHqWm6rd62NOvra7ls7x7S9iB/e2E+EYw3MQIMMgWSPKOARuXgZBr/abJeIMuzLDUamBlz8y9Nkf5s5zkeY5fUlQx1NprW3TXqns15rQlr2GrbnjhSTC4UrhT+E+bf2iPu+Ev+3j/wBp1vDY9TLtz5pqvM9QKACpbfNdk1K1tEZ2q+INE8L29vqmv6nb6bZtKsUCv8z3cvzMsVvGvzSzNtbbGiszbdqrXj8QcT4XB0ZKpJJWse5knC2Kx9Veyi3qn5JX3b2S7t6I/si/4NnfhX+0R4K+Bnx0+I3xe+Gt74R8B+ONZtNV8IateXCCbXNNgiaK2lS3yZEhMBiwZAhLB8Lgg1/jx9IbG5VUzGNLLa3tOTmvo1bmdz/RLgrKqmFw7jPry/hGMf0Z/TfX88H2gUAFABQAEAggjIoBo/BX9rj/AIIMfAz43/ErS/it+zv4zP7IvjG4mvbrxNc6FpQvF8R3Mxj2XFxE8qrK0YSdUjl3xJ9pldY1kIcfvfAfj/m+SxtzOco/C725f0fzTPhOKuAcHmlNwqRWvdaeulnf0ab0TbWh+Bv7Yf7OHxX/AGHfF/h3QPjt4Zms9A1q4kg0nxRokcl/pUrhIzslZE8yBQWcGWWKOMCB5H8rzI1P99+EH0l8FnlFUszlyzW8vXy6fl5n8acfeBeLy+rbASdRPo1Z9dE7KMn0srSb2hY8D2/Kkisjwv8AMsituV/92v6mwzoSpJUZX8z8BqYb2dZ0mnddHoFV+6qO7FHltZnzb+0R93wl/wBvH/tOulQT0pno5ZFwd0fNNUpKL9jPZ/gejNSWtTboOVWbDH7g+839ysZVoOMp1ZWaNqeHc37iu+p9D/swfso/H39sL486N+z18HPBV1o/iS+02fUX8SeJrG6tNF0uAWhmhllcIZJY5N8G0quJUldo2cxug/mvxK+kdgMoy2c8LH2jWid7Xd7bb/p5n7VwT4LV80kquL9xLpu/RvaL6NO8oveFj+s/9hL/AIN3vgV+yx8ZdU+M/wAefiNF+2N4hsfssvgs6/4dWwHhm5XJnuTFHPJDLK5WBV2pGirAh2GQvI3+eHiD9IDMc7pKNOLpSlfnalfmXTorfJI/r3hrgbCZdTVOEU7dlZX+d2/JttrpZaH9EscccMaRRIkUSgKqqMBQOgA7CvwCUm3d7n2w+kAUAFABQAUAFAHNeK/B/hjxvo93oXizQdJ8Q6VNFJC8F5AJEKupVuDyMgnkEH3FdWExtahLnoycX5eRnUoQmuWoro/m/wD23P8AghjY+E/Bp8ef8E5bR/B+paJazTt8K3mWew8YSM4fykvb6cG1lZnuJDN5gJkk8xzP5awP/UfhH9JXH5RiFSzCTlTlZN+ndfqrd3c/F+PvBzCZxN12/e6aarbZpq/mp82mkXDc/Bnxv4f8e/CLxrp3wt+PHw/8RfBb4sXEcrJo2qxt5N60btGz2V3tCzRloZzEWCNPFDJMqCNQ4/0R8N/G7KOII8lFrmfn/X3b+R/GfHnhXi8qcpxTlFb6Wa1tdx3tt7yvC7SUmz5f/aGRj/wiShX3/wCkfL/37r9lpShT99Ncp8NgOaKs1qeQ+A/hr8Rviv4gTwX8JfBGu/EnxxOkwtNO06CSUSToqHy5pURxCpaa2jLkYXz42PDAD8l8QfGrAZFieSpaUo7xvtdd/wAe5+q8HeGuOzaanUThF7Safva2dl+rainZNq6P6QP+CfP/AAblr8SPhvP49/4KbT681xrqh0+E2mtBawaFECCqXmpW7vLPJujik3RNEwYHkKRGv+efi/8ASXxuYY1wyuf7uOz6a76dfmf2Dwb4V4LLqS920ur6v53bXpG3ZuW7/rN+Gvww8AfB7wZoXw++GfhTRvBvg/TbaO0s7GyhCJFGgwo9WOO5ya/lDMMxr4qq61eTlJn6ph8NTpQVOmrJdjvK4TcKACgAoAKACgAoAKACgAoA+Zv2qf2Pf2eP21fhyPhR+0l8PLL4jeBhdQ3q2cs8sOJYpUmTLRspdBJDExibMb7AHVlyp+h4c4pxuVVnXwM+WTOXF4KlXjy1Ff8ANejP5h/iL/wb3/tA+JP2lvC/gLTfi62p/swxodTufFl86reW2/IksBYr++bJJYSC6xuSJfLSEOj/ANSYX6TmJWSywtRvyp3e/fm3t1/DyPyzEeEWWSxXt4U0pd7L/wBJtyX87db25rSX9Jn7GP7Bf7L37Anw7u/hp+zH8NdP8A6HeXDXmoyrLJNPqFwxJZ3eRmIGWOEXCKMBQAAB/MfFXGOPzmv7fHT5mtvI/UcHgadCNoL+vzPsWvljsCgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoA//9k=';
    $palletB64 = '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';

    // Resumen por paleta (se reutiliza abajo)
    $paletaInfo = [];
    foreach ($paletas as $nombre => $items) {
        $pStatus = 'pc-ok'; $pTxt = 'COMPLETA'; $pEst = ['Completa', 'st-ok', 'OK'];
        if ($items->contains(fn($d) => $d->cantidad_despachada == 0))                       { $pStatus = 'pc-no';  $pTxt = 'CON INCIDENCIAS'; $pEst = ['Con incidencias', 'st-no', 'X']; }
        elseif ($items->contains(fn($d) => $d->cantidad_despachada < $d->cantidad_solicitada)) { $pStatus = 'pc-par'; $pTxt = 'PARCIAL';         $pEst = ['Parcial', 'st-par', '!']; }
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


{{-- ── Íconos vectoriales para el PDF (reemplazan las letras P, U, OK, !, PL, KG, R, D, X) ── --}}
@php
    $icoPaths = [
            'clip'   => '<rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4h6v3H9zM9 12h6M9 16h6"/>',
            'list'   => '<path d="M9 6h12M9 12h12M9 18h12M4 6v.5M4 12v.5M4 18v.5"/>',
            'layers' => '<path d="M12 3 21 8 12 13 3 8z"/><path d="M3 13 12 18 21 13"/>',
            'box'    => '<path d="M21 8 12 3 3 8v8l9 5 9-5z"/><path d="M3 8 12 13 21 8M12 13v8"/>',
            'check'  => '<circle cx="12" cy="12" r="9"/><path d="M8 12 11 15 16 9"/>',
            'alert'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5L12 13"/><path d="M12 16.2L12 16.8"/>',
            'x'      => '<path d="M6 6L18 18"/><path d="M18 6L6 18"/>',
            'scale'  => '<path d="M12 4v16M6 20h12M5 7h14"/><path d="M5 7 2.5 13a2.6 2.6 0 0 0 5 0zM19 7l-2.5 6a2.6 2.6 0 0 0 5 0z"/>',
            'pallet' => '<rect x="3" y="5" width="18" height="9" rx="1"/><path d="M3 9.5h18M12 5v9"/><path d="M3 17h18M5 14v3M12 14v3M19 14v3M3 20h18"/>',
    ];
    $svgIco = function (string $name, string $color = '#ffffff', int $px = 14, string $style = '') use ($icoPaths) {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="' . $px . '" height="' . $px . '" fill="none"'
             . ' stroke="' . $color . '" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">'
             . ($icoPaths[$name] ?? '') . '</svg>';
        return '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="' . $px . '" height="' . $px . '"'
             . ($style ? ' style="' . $style . '"' : '') . ' alt="">';
    };
    // Cuadrito de color con el ícono dentro, dibujado como UNA sola imagen (no depende de centrados CSS)
    $svgTile = function (string $name, string $bg, string $fg = '#ffffff', int $px = 16, string $style = 'vertical-align:middle;margin-right:5px;') use ($icoPaths) {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="' . $px . '" height="' . $px . '">'
             . '<rect x="0" y="0" width="24" height="24" rx="6" fill="' . $bg . '"/>'
             . '<g transform="translate(5 5) scale(0.583)" fill="none" stroke="' . $fg . '" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">'
             . ($icoPaths[$name] ?? '') . '</g></svg>';
        return '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="' . $px . '" height="' . $px . '"'
             . ($style ? ' style="' . $style . '"' : '') . ' alt="">';
    };
    // Glifos de las etiquetas de estado (DejaVu Sans los incluye)
    $glifo = ['OK' => '✓', 'X' => '✕', '!' => '!'];
@endphp

{{-- ═══════════════════════ PÁGINA 1 ═══════════════════════ --}}

{{-- HEADER --}}
<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:200px; vertical-align:middle;">
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
    <div class="sec">{!! $svgTile('clip', '#1d4ed8') !!}&nbsp;Resumen de la orden</div>
    <table class="kpis" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:16.6%;">{!! $svgTile('box', '#dbe9fb', '#1d4ed8', 26, 'margin-bottom:2px;') !!}<div class="kpi-n">{{ $detalles->count() }}</div><div class="kpi-l">Productos<br>SKU diferentes</div></td>
            <td style="width:16.6%;">{!! $svgTile('layers', '#dbe9fb', '#1d4ed8', 26, 'margin-bottom:2px;') !!}<div class="kpi-n">{{ $n($solTotal) }}</div><div class="kpi-l">Unidades<br>solicitadas</div></td>
            <td style="width:16.6%;">{!! $svgTile('check', '#d9f5e3', '#15803d', 26, 'margin-bottom:2px;') !!}<div class="kpi-n">{{ $n($totalUds) }}</div><div class="kpi-l">Unidades<br>despachadas</div></td>
            <td style="width:16.6%;">{!! $svgTile('alert', '#fde0e0', '#dc2626', 26, 'margin-bottom:2px;') !!}<div class="kpi-n">{{ $n($penTotal) }}</div><div class="kpi-l">Unidades<br>pendientes</div></td>
            <td style="width:16.6%;">{!! $svgTile('pallet', '#dbe9fb', '#1d4ed8', 26, 'margin-bottom:2px;') !!}<div class="kpi-n">{{ $paletasConNombre->count() }}</div><div class="kpi-l">Paletas<br>a despachar</div></td>
            <td style="width:16.6%;">{!! $svgTile('scale', '#dbe9fb', '#1d4ed8', 26, 'margin-bottom:2px;') !!}<div class="kpi-n">{{ number_format($pesoTotal, 2) }} kg</div><div class="kpi-l">Peso total<br>despachado</div></td>
        </tr>
    </table>
</div>

{{-- DETALLE DE PRODUCTOS (ordenado por id) --}}
<div class="panel" style="padding-bottom:8px;">
    <div class="sec">{!! $svgTile('list', '#1d4ed8') !!}&nbsp;Detalle de productos</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width:4%;">#</th>
                <th style="width:9%;">Código</th>
                <th style="width:27%;">Producto</th>
                <th style="width:11%;">Presentación</th>
                <th style="width:9%;">Solicitado</th>
                <th style="width:8%;">Despacho</th>
                <th style="width:8%;">Faltante</th>
                <th style="width:10%;">Vencimiento</th>
                <th style="width:14%;">Estado</th>
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
            <td style="font-weight:bold;">{{ $n($item->cantidad_despachada, 2) }}</td>
            <td style="font-weight:bold;color:{{ $falt > 0 ? '#dc2626' : '#15803d' }};">{{ $n($falt, 2) }}</td>
            <td>{{ $f($fecha) }}</td>
            <td><span class="st {{ $eCls }}">{{ $glifo[$eIc] ?? $eIc }} {{ $eTxt }}</span></td>
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
        <td style="width:200px; vertical-align:middle;">
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
<div class="sec" style="margin-bottom:6px;">{!! $svgTile('pallet', '#1d4ed8') !!}&nbsp;Desglose por paletas</div>

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
                            <td style="width:28%; text-align:left;"><img src="data:image/jpeg;base64,{{ $palletB64 }}" width="58" alt=""></td>
                            <td><b>{{ $pi['prods'] }}</b>Productos</td>
                            <td><b>{{ $pi['cajas'] }}</b>Cajas</td>
                            <td><b>{{ $n($pi['uds']) }}</b>Unidades</td>
                            <td><b>{{ number_format($pi['peso'], 2) }}</b>Peso (kg)</td>
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
                            <td style="font-weight:bold;">{{ $n($detail->cantidad_despachada) }}</td>
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
    <div class="sec">{!! $svgTile('layers', '#1d4ed8') !!}&nbsp;Resumen por paletas</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead>
            <tr><th style="width:16%;">Paleta</th><th>Productos</th><th>Cajas</th><th>Unidades</th><th>Peso (kg)</th><th style="width:26%;">Estado</th></tr>
        </thead>
        <tbody>
        @foreach($paletas as $paleta => $items)
        @php $pi = $paletaInfo[$paleta]; @endphp
        <tr>
            <td style="font-weight:bold;">{{ $paleta === 'SIN PALETA' ? 'Sin paleta' : 'Paleta ' . $paleta }}</td>
            <td>{{ $pi['prods'] }}</td>
            <td>{{ $pi['cajas'] }}</td>
            <td>{{ $n($pi['uds']) }}</td>
            <td>{{ number_format($pi['peso'], 2) }}</td>
            <td><span class="st {{ $pi['est'][1] }}">{{ $glifo[$pi['est'][2]] ?? $pi['est'][2] }} {{ $pi['est'][0] }}</span></td>
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
                <div class="ftitle-no">{!! $svgTile('x', '#dc2626') !!}&nbsp;Productos no despachados ({{ $noDesp->count() }})</div>
                <table class="ftbl" cellpadding="0" cellspacing="0">
                    <thead><tr><th class="no">Código</th><th class="no">Producto</th><th class="no">Solicitado</th><th class="no">Despacho</th><th class="no">Faltante</th><th class="no">Vencimiento</th></tr></thead>
                    <tbody>
                    @foreach($noDesp as $d)
                    <tr>
                        <td>{{ $d->product->sku ?? '—' }}</td>
                        <td class="l" style="font-weight:700;">{{ $d->product->nombre }}</td>
                        <td>{{ $n($d->cantidad_solicitada, 2) }}</td>
                        <td>{{ $n($d->cantidad_despachada, 2) }}</td>
                        <td style="font-weight:bold;color:#b91c1c;">{{ $n($d->cantidad_solicitada - $d->cantidad_despachada, 2) }}</td>
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
                <div class="ftitle-par">{!! $svgTile('alert', '#f59e0b') !!}&nbsp;Productos despachados parcialmente ({{ $parcial->count() }})</div>
                <table class="ftbl" cellpadding="0" cellspacing="0">
                    <thead><tr><th class="par">Código</th><th class="par">Producto</th><th class="par">Solicitado</th><th class="par">Despacho</th><th class="par">Faltante</th><th class="par">Vencimiento</th></tr></thead>
                    <tbody>
                    @foreach($parcial as $d)
                    <tr>
                        <td>{{ $d->product->sku ?? '—' }}</td>
                        <td class="l" style="font-weight:700;">{{ $d->product->nombre }}</td>
                        <td>{{ $n($d->cantidad_solicitada, 2) }}</td>
                        <td>{{ $n($d->cantidad_despachada, 2) }}</td>
                        <td style="font-weight:bold;color:#a16207;">{{ $n($d->cantidad_solicitada - $d->cantidad_despachada, 2) }}</td>
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
    <div class="sec">{!! $svgTile('x', '#dc2626') !!}&nbsp;Productos no enviados</div>
    <table class="tbl" cellpadding="0" cellspacing="0">
        <thead><tr><th style="text-align:left;">Producto</th><th>Cantidad faltante</th></tr></thead>
        <tbody>
        @foreach($faltantes as $fl)
        <tr>
            <td class="l">{{ $fl['producto'] }}</td>
            <td style="font-weight:bold; color:#991b1b;">{{ $fl['faltante'] }}</td>
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

</body>
</html>