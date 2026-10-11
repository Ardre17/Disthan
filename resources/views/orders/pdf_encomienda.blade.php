<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

@page {
    margin: 10mm 10mm 14mm 10mm;
}

* {
    box-sizing: border-box;
}
div, table, tr, td, th, p, span, h1, h2, h3, ul, li {
    margin: 0;
    padding: 0;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9px;
    color: #1e293b;
    line-height: 1.4;
}

.mono { font-family: 'Courier New', monospace; }

/* ── Header ── */
.hdr { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
.hdr-l { width: 36%; vertical-align: middle; padding: 6px 4px 6px 0; }
.hdr-r {
    width: 64%; vertical-align: middle;
    background: #12305c; padding: 10px 14px;
    border-radius: 6px;
}
.logo-tile {
    width: 34px; height: 34px;
    background: #1e3a5f; color: #fff;
    border-radius: 7px;
    text-align: center; vertical-align: middle;
    font-size: 20px; font-weight: 700;
}
.logo-name { font-size: 20px; font-weight: 700; color: #1e3a5f; letter-spacing: 1px; line-height: 1; }
.logo-sub  { font-size: 17px; font-weight: 700; color: #2563eb; letter-spacing: 1px; line-height: 1.1; }
.doc-title { font-size: 17px; font-weight: 700; color: #fff; letter-spacing: .5px; }
.doc-subtitle { font-size: 8px; color: #a9bddb; margin-top: 3px; letter-spacing: .05em; }
.num-box {
    background: #fff; border-radius: 5px;
    padding: 5px 8px 4px; text-align: center;
}
.num-box .n { font-size: 11px; font-weight: 700; color: #1e3a5f; margin-bottom: 3px; }
.num-box .f { font-size: 7.5px; color: #475569; margin-top: 2px; }
.estado-chip {
    display: block; margin-top: 5px;
    padding: 3px 8px; border-radius: 4px;
    font-size: 8.5px; font-weight: 700; text-align: center;
    text-transform: uppercase; letter-spacing: .04em;
}
.estado-completo   { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
.estado-parcial    { background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
.estado-incompleto { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

/* ── Tarjetas ── */
.card { border: 1px solid #c7dbf5; border-radius: 6px; background: #fff; }
.card-h {
    background: #eaf2fd; color: #1e3a5f;
    font-size: 9.5px; font-weight: 700;
    padding: 5px 8px;
    border-bottom: 1px solid #c7dbf5;
    border-radius: 5px 5px 0 0;
}
.card-b { padding: 6px 8px; }
.kv { width: 100%; border-collapse: collapse; }
.kv td { padding: 1.5px 0; vertical-align: top; font-size: 8.5px; }
.kv td.k { color: #64748b; width: 38%; }
.kv td.v { color: #0f172a; font-weight: 700; }
.cli-name { font-size: 11px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.sq { display: inline-block; width: 7px; height: 7px; border-radius: 2px; margin-right: 4px; }

/* ── Sección título ── */
.sec {
    background: #eaf2fd; border: 1px solid #c7dbf5; border-radius: 5px;
    color: #1e3a5f; font-size: 9.5px; font-weight: 700;
    padding: 5px 8px; margin-bottom: 6px;
}
.sec .num {
    display: inline-block;
    background: #1e3a5f; color: #fff; border-radius: 3px;
    padding: 1px 4px 0 4px; font-size: 8px; line-height: 1.2; margin-right: 5px;
}

/* ── Tabla productos ── */
.tbl { width: 100%; border-collapse: collapse; font-size: 8.5px; }
.tbl thead th {
    background: #eaf2fd; color: #1e3a5f;
    padding: 5px 5px; text-align: left;
    font-size: 8px; font-weight: 700;
    border-bottom: 1px solid #c7dbf5;
}
.tbl thead th.center { text-align: center; }
.tbl tbody tr { page-break-inside: avoid; }
.tbl tbody td {
    padding: 3px 5px;
    border-bottom: 1px solid #e8eef7;
    vertical-align: middle;
}
.tbl tbody td.center { text-align: center; }
.tbl tfoot td {
    padding: 5px 5px;
    background: #1e3a5f; color: #fff;
    font-weight: 700; font-size: 8.5px;
}
.tbl tfoot td.center { text-align: center; }
.p-name { font-weight: 700; color: #0f172a; }
.p-sub  { font-size: 7px; color: #94a3b8; }

/* ── Progreso ── */
.prog-title { font-size: 9px; font-weight: 700; color: #1e3a5f; margin-bottom: 6px; }
.prog-bar { width: 100%; border-collapse: collapse; }
.prog-bar td { height: 10px; font-size: 1px; line-height: 10px; }
.prog-pct { font-size: 22px; font-weight: 700; color: #2563eb; text-align: right; line-height: 1; }
.prog-units { font-size: 8px; color: #475569; text-align: right; }
.legend td { font-size: 7.5px; color: #475569; padding-top: 6px; }

/* ── Bultos ── */
.brow { width: 100%; border-collapse: collapse; page-break-inside: avoid; margin-bottom: 8px; }
.brow td.bc { width: 33.33%; vertical-align: top; padding: 0 3px; }
.bcard { border-width: 1.5px; border-style: solid; border-radius: 8px; padding: 7px 8px; background: #fff; }
.b-tile {
    width: 24px; height: 24px; border-radius: 6px;
    text-align: center; vertical-align: middle;
    font-size: 12px; font-weight: 700;
}
.b-name { font-size: 11px; font-weight: 700; color: #0f172a; }
.b-kg {
    display: inline-block; background: #dbeafe; color: #1d4ed8;
    font-size: 13px; font-weight: 700; padding: 3px 14px; border-radius: 8px;
}
.b-n { font-size: 8px; color: #64748b; margin-top: 3px; }
.bt { width: 100%; border-collapse: collapse; margin-top: 5px; }
.bt th {
    background: #f1f5f9; color: #475569; font-size: 7.5px; font-weight: 700;
    padding: 3px 5px; text-align: left;
}
.bt th.r, .bt td.r { text-align: right; }
.bt td { font-size: 8px; padding: 3px 5px; border-bottom: 1px solid #f1f5f9; }
.bt td.cant { font-family: 'Courier New', monospace; font-weight: 700; color: #1e3a5f; }
.bulto-empty { color: #94a3b8; font-size: 8px; font-style: italic; padding: 6px 0; text-align: center; }
.b-code { font-size: 7.5px; font-weight: 700; color: #1e293b; text-align: center; margin-top: 2px; }

/* ── Observaciones / Recibido conforme ── */
.line { border-bottom: 1px solid #94a3b8; height: 13px; }
.sig td { font-size: 8px; color: #64748b; padding-top: 6px; vertical-align: bottom; }

/* ── Footer ── */
.footer-table {
    width: 100%; border-collapse: collapse;
    border-top: 1px solid #e2e8f0; margin-top: 12px;
}
.footer-table td { font-size: 7.5px; color: #94a3b8; padding-top: 5px; }
.footer-table td:last-child { text-align: right; }

</style>
</head>
<body>

@php
    $ahora = \Carbon\Carbon::now('America/Lima');

    $totalPeso = 0;
    $totalUnidades = 0;

    // Bultos ordenados de forma correlativa (Bulto 1, 2, 3...) en vez del
    // orden que devuelva la relación por defecto (que puede salir por peso/insercion)
    $bultosOrdenados = $order->bultos->sortBy(function ($bulto) {
        return (int) preg_replace('/\D/', '', $bulto->nombre);
    })->values();

    $estadoClass = match($order->estado) {
        'COMPLETO'   => 'estado-completo',
        'PARCIAL'    => 'estado-parcial',
        default      => 'estado-incompleto',
    };

    /* ── Progreso de preparación (solicitado vs. despachado) ── */
    $uSolicitadas = 0;
    $uDespachadas = 0;
    $nCompletos = 0; $nParciales = 0; $nPendientes = 0;
    foreach ($order->details as $it) {
        $sol  = (float) $it->cantidad_solicitada;
        $desp = (float) $it->cantidad_despachada;
        $uSolicitadas += $sol;
        $uDespachadas += $desp;
        if ($desp >= $sol && $sol > 0) $nCompletos++;
        elseif ($desp > 0)             $nParciales++;
        else                           $nPendientes++;
    }
    $pctProg = $uSolicitadas > 0 ? min(100, ($uDespachadas / $uSolicitadas) * 100) : 0;

    /* ── Datos opcionales del cliente (se ocultan si el campo no existe o está vacío) ── */
    $cliente = $order->client ?? null;
    $datosCliente = [];
    foreach ([
        'RUC'       => 'ruc',
        'Dirección' => 'direccion',
        'Contacto'  => 'contacto',
        'Teléfono'  => 'telefono',
    ] as $etiqueta => $campo) {
        $valor = $cliente ? data_get($cliente, $campo) : null;
        if (filled($valor)) $datosCliente[$etiqueta] = $valor;
    }

    // Columna "Presentación" solo si algún producto la tiene
    $tienePres = $order->details->contains(function ($it) {
        return filled(data_get($it->product, 'presentacion'));
    });

    $observaciones = data_get($order, 'observaciones');

    /* ── Código de barras Code 128 (HTML puro, funciona en DomPDF) ── */
    $c128 = [
        '212222','222122','222221','121223','121322','131222','122213','122312','132212','221213',
        '221312','231212','112232','122132','122231','113222','123122','123221','223211','221132',
        '221231','213212','223112','312131','311222','321122','321221','312212','322112','322211',
        '212123','212321','232121','111323','131123','131321','112313','132113','132311','211313',
        '231113','231311','112133','112331','132131','113123','113321','133121','313121','211331',
        '231131','213113','213311','213131','311123','311321','331121','312113','312311','332111',
        '314111','221411','431111','111224','111422','121124','121421','141122','141221','112214',
        '112412','122114','122411','142112','142211','241211','221114','413111','241112','134111',
        '111242','121142','121241','114212','124112','124211','411212','421112','421211','212141',
        '214121','412121','111143','111341','131141','114113','114311','411113','411311','113141',
        '114131','311141','411131','211412','211214','211232','2331112',
    ];
    $barcode = function (string $texto, float $modulo = 0.8, float $alto = 22) use ($c128) {
        $texto = preg_replace('/[^\x20-\x7E]/', '', $texto);
        if ($texto === '') return '';

        $codigos = [104];              // Start B
        $suma = 104;
        $pos  = 1;
        foreach (str_split($texto) as $ch) {
            $v = ord($ch) - 32;
            $codigos[] = $v;
            $suma += $v * $pos++;
        }
        $codigos[] = $suma % 103;      // dígito de control
        $codigos[] = 106;              // Stop

        $quiet = 10 * $modulo;         // zona en blanco a cada lado
        $total = 2 * $quiet;
        $barras = '';
        foreach ($codigos as $c) {
            $patron = $c128[$c];
            for ($k = 0; $k < strlen($patron); $k++) {
                $w = (int) $patron[$k] * $modulo;
                $total += $w;
                $barras .= '<div style="float:left;width:' . round($w, 3) . 'pt;height:' . $alto . 'pt;background:'
                         . ($k % 2 === 0 ? '#000' : '#fff') . ';"></div>';
            }
        }
        return '<div style="width:' . round($total + 3, 2) . 'pt;height:' . $alto . 'pt;margin:0 auto;background:#fff;">'
             . '<div style="float:left;width:' . round($quiet, 3) . 'pt;height:' . $alto . 'pt;"></div>'
             . $barras . '</div>';
    };

    // Paleta de los bultos (borde, fondo suave del icono)
    $coloresBulto = [
        ['#22c55e', '#dcfce7', '#15803d'],
        ['#3b82f6', '#dbeafe', '#1d4ed8'],
        ['#f59e0b', '#fef3c7', '#b45309'],
    ];

    $codigoOrden = strtoupper(str_replace(['-', ' '], '', $order->numero_orden));
@endphp

{{-- ══ HEADER ══ --}}
<table class="hdr" cellpadding="0" cellspacing="0">
    <tr>
        <td class="hdr-l">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="logo-tile">D</td>
                    <td style="width:8px;">&nbsp;</td>
                    <td style="vertical-align:middle;">
                        <div class="logo-name">DISTHAN</div>
                        <div class="logo-sub">ERP</div>
                    </td>
                </tr>
            </table>
        </td>
        <td class="hdr-r">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="vertical-align:middle;">
                        <div class="doc-title">ORDEN DE ENCOMIENDA</div>
                        <div class="doc-subtitle">Orden de despacho · {{ $order->tipo_orden }}</div>
                    </td>
                    <td style="width:128px;vertical-align:middle;">
                        <div class="num-box">
                            <div class="n">N° {{ $order->numero_orden }}</div>
                            {!! $barcode($order->numero_orden, 0.7, 20) !!}
                            <div class="f">Fecha: {{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d/m/Y') }}</div>
                        </div>
                        <div class="estado-chip {{ $estadoClass }}">{{ $order->estado }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ══ INFO: CLIENTE · ENVÍO · RESUMEN ══ --}}
<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
    <tr>
        <td style="width:36%;vertical-align:top;padding-right:4px;">
            <div class="card">
                <div class="card-h">Cliente</div>
                <div class="card-b" style="height:86px;">
                    <div class="cli-name">{{ $order->client->razon_social ?? '—' }}</div>
                    @if(count($datosCliente))
                    <table class="kv" cellpadding="0" cellspacing="0">
                        @foreach($datosCliente as $etiqueta => $valor)
                        <tr><td class="k">{{ $etiqueta }}:</td><td class="v">{{ $valor }}</td></tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </td>
        <td style="width:32%;vertical-align:top;padding:0 2px;">
            <div class="card">
                <div class="card-h">Datos del envío</div>
                <div class="card-b" style="height:86px;">
                    <table class="kv" cellpadding="0" cellspacing="0">
                        <tr><td class="k">Orden:</td><td class="v">{{ $order->numero_orden }}</td></tr>
                        <tr><td class="k">Fecha de pedido:</td><td class="v">{{ \Carbon\Carbon::parse($order->fecha_pedido)->format('d/m/Y') }}</td></tr>
                        <tr><td class="k">Tipo de orden:</td><td class="v">{{ $order->tipo_orden }}</td></tr>
                        <tr><td class="k">Estado:</td><td class="v">{{ $order->estado }}</td></tr>
                        <tr><td class="k">Generado:</td><td class="v">{{ $ahora->format('d/m/Y H:i') }}</td></tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="width:32%;vertical-align:top;padding-left:4px;">
            <div class="card">
                <div class="card-h">Resumen del envío</div>
                <div class="card-b" style="height:86px;">
                    <table class="kv" cellpadding="0" cellspacing="0">
                        <tr><td class="k"><span class="sq" style="background:#f59e0b;"></span>Bultos</td><td class="v">{{ $order->bultos->count() }}</td></tr>
                        <tr><td class="k"><span class="sq" style="background:#3b82f6;"></span>Productos</td><td class="v">{{ $order->details->count() }}</td></tr>
                        <tr><td class="k"><span class="sq" style="background:#22c55e;"></span>Unidades</td><td class="v">{{ number_format($uDespachadas, 0) }}</td></tr>
                        <tr><td class="k"><span class="sq" style="background:#7c3aed;"></span>Peso total</td><td class="v">{{ number_format($order->bultos->sum('peso_total'), 2) }} kg</td></tr>
                    </table>
                </div>
            </div>
        </td>
    </tr>
</table>

{{-- ══ PROGRESO DE PREPARACIÓN ══ --}}
<div class="card" style="margin-bottom:10px;page-break-inside:avoid;">
    <div class="card-b" style="padding:8px 10px;">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:72%;vertical-align:middle;padding-right:12px;">
                    <div class="prog-title">Progreso de preparación</div>
                    <table class="prog-bar" cellpadding="0" cellspacing="0">
                        <tr>
                            @if($pctProg >= 100)
                                <td style="background:#2563eb;">&nbsp;</td>
                            @elseif($pctProg <= 0)
                                <td style="background:#e2e8f0;">&nbsp;</td>
                            @else
                                <td style="width:{{ round($pctProg, 1) }}%;background:#2563eb;">&nbsp;</td>
                                <td style="background:#e2e8f0;">&nbsp;</td>
                            @endif
                        </tr>
                    </table>
                    <div style="font-size:8px;color:#475569;margin-top:4px;">
                        {{ number_format($uDespachadas, 0) }} / {{ number_format($uSolicitadas, 0) }} unidades preparadas
                    </div>
                </td>
                <td style="width:12%;vertical-align:middle;text-align:right;">
                    <div class="prog-pct">{{ number_format($pctProg, 0) }}%</div>
                </td>
                <td style="width:16%;vertical-align:middle;padding-left:12px;">
                    <div style="font-size:7.5px;color:#475569;line-height:1.8;">
                        <div><span class="sq" style="background:#22c55e;"></span>Completos ({{ $nCompletos }})</div>
                        <div><span class="sq" style="background:#f59e0b;"></span>Parciales ({{ $nParciales }})</div>
                        <div><span class="sq" style="background:#ef4444;"></span>Pendientes ({{ $nPendientes }})</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ══ PRODUCTOS ENVIADOS ══ --}}
<div class="sec"><span class="num">1</span>Productos del envío</div>
<table class="tbl" cellpadding="0" cellspacing="0" style="margin-bottom:10px;">
    <thead>
        <tr>
            <th style="width:5%;" class="center">#</th>
            <th>Producto</th>
            @if($tienePres)
            <th style="width:16%;">Present.</th>
            @endif
            <th style="width:10%;" class="center">Solic.</th>
            <th style="width:9%;" class="center">Env.</th>
            <th style="width:9%;" class="center">Falt.</th>
            <th style="width:14%;" class="center">Peso (kg)</th>
        </tr>
    </thead>
    <tbody>
    @foreach($order->details as $item)
        @php
            $pesoUnit = ($item->product->peso ?? 0) / 1000;
            $peso = $item->cantidad_despachada * $pesoUnit;
            $totalPeso += $peso;
            $totalUnidades += $item->cantidad_despachada;

            $faltaItem = max(0, $item->cantidad_solicitada - $item->cantidad_despachada);
            $colEnv = $item->cantidad_despachada >= $item->cantidad_solicitada && $item->cantidad_solicitada > 0
                ? '#15803d'
                : ($item->cantidad_despachada > 0 ? '#d97706' : '#dc2626');
        @endphp
        <tr>
            <td class="center" style="color:#64748b;">{{ $loop->iteration }}</td>
            <td>
                <div class="p-name">{{ $item->product->nombre }}</div>
                <div class="p-sub">{{ number_format($pesoUnit, 3) }} kg/u</div>
            </td>
            @if($tienePres)
            <td>{{ data_get($item->product, 'presentacion') }}</td>
            @endif
            <td class="center mono">{{ number_format($item->cantidad_solicitada, 0) }}</td>
            <td class="center mono" style="font-weight:700;color:{{ $colEnv }};">{{ number_format($item->cantidad_despachada, 0) }}</td>
            <td class="center mono" style="font-weight:700;color:{{ $faltaItem > 0 ? '#dc2626' : '#94a3b8' }};">{{ number_format($faltaItem, 0) }}</td>
            <td class="center mono" style="font-weight:700;color:#1e3a5f;">{{ number_format($peso, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>TOTALES</td>
            @if($tienePres)
            <td></td>
            @endif
            <td class="center">{{ number_format($uSolicitadas, 0) }}</td>
            <td class="center">{{ number_format($totalUnidades, 0) }}</td>
            <td class="center">{{ number_format(max(0, $uSolicitadas - $uDespachadas), 0) }}</td>
            <td class="center">{{ number_format($totalPeso, 2) }}</td>
        </tr>
    </tfoot>
</table>

{{-- ══ BULTOS ══ --}}
<div class="sec"><span class="num">2</span>Bultos del envío ({{ $order->bultos->count() }})</div>

@if($bultosOrdenados->count() === 0)
    <div class="bulto-empty" style="margin-bottom:10px;">No hay bultos registrados para esta encomienda.</div>
@else
    @foreach($bultosOrdenados->chunk(3) as $fila)
    <table class="brow" cellpadding="0" cellspacing="0">
        <tr>
            @foreach($fila as $bulto)
            @php
                $col = $coloresBulto[$loop->index % 3];
                $numBulto = (int) preg_replace('/\D/', '', $bulto->nombre);
                if ($numBulto <= 0) $numBulto = $loop->iteration;
                $codigoBulto = $codigoOrden . '-B' . $numBulto;
            @endphp
            <td class="bc">
                <div class="bcard" style="border-color:{{ $col[0] }};">

                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="b-tile" style="background:{{ $col[1] }};color:{{ $col[2] }};">{{ $numBulto }}</td>
                            <td style="width:7px;">&nbsp;</td>
                            <td style="vertical-align:middle;"><span class="b-name">{{ $bulto->nombre }}</span></td>
                        </tr>
                    </table>

                    <div style="text-align:center;margin-top:6px;">
                        <span class="b-kg">{{ number_format($bulto->peso_total, 2) }} kg</span>
                        <div class="b-n">{{ $bulto->detalles->count() }} {{ $bulto->detalles->count() === 1 ? 'producto' : 'productos' }}</div>
                    </div>

                    @if($bulto->detalles->count() > 0)
                    <table class="bt" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr><th>Producto</th><th class="r">Cant.</th></tr>
                        </thead>
                        <tbody>
                        @foreach($bulto->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->product->nombre ?? 'Producto eliminado' }}</td>
                                <td class="r cant">x {{ number_format($detalle->cantidad, 0) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="bulto-empty">Sin productos asignados</div>
                    @endif

                    <div style="margin-top:7px;">
                        {!! $barcode($codigoBulto, 0.75, 22) !!}
                        <div class="b-code">Código: {{ $codigoBulto }}</div>
                    </div>
                </div>
            </td>
            @endforeach

            {{-- Celdas vacías para completar la fila --}}
            @for($i = $fila->count(); $i < 3; $i++)
            <td class="bc"></td>
            @endfor
        </tr>
    </table>
    @endforeach
@endif

{{-- ══ OBSERVACIONES / RECIBIDO CONFORME ══ --}}
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:2px;page-break-inside:avoid;">
    <tr>
        <td style="width:50%;vertical-align:top;padding-right:4px;">
            <div class="card">
                <div class="card-h">Observaciones</div>
                <div class="card-b" style="height:58px;">
                    @if(filled($observaciones))
                        <div style="font-size:8.5px;">{{ $observaciones }}</div>
                    @else
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    @endif
                </div>
            </div>
        </td>
        <td style="width:50%;vertical-align:top;padding-left:4px;">
            <div class="card">
                <div class="card-h">Recibido conforme</div>
                <div class="card-b" style="height:58px;">
                    <table class="sig" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:30%;">Nombre:</td>
                            <td style="border-bottom:1px solid #94a3b8;">&nbsp;</td>
                            <td style="width:8%;">&nbsp;</td>
                            <td style="width:14%;">DNI:</td>
                            <td style="width:24%;border-bottom:1px solid #94a3b8;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Firma:</td>
                            <td style="border-bottom:1px solid #94a3b8;">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Fecha:</td>
                            <td style="border-bottom:1px solid #94a3b8;">&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
    </tr>
</table>

{{-- ══ FOOTER ══ --}}
<table class="footer-table" cellpadding="0" cellspacing="0">
    <tr>
        <td>DISTHAN · Detalle de encomienda · Orden {{ $order->numero_orden }}</td>
        <td>Generado el {{ $ahora->format('d/m/Y \a \l\a\s H:i') }}</td>
    </tr>
</table>

</body>
</html>