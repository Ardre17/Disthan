@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .supply-page {
        min-height: 100vh;
        background:
            radial-gradient(circle at top right, rgba(6,182,212,.08), transparent 30%),
            linear-gradient(135deg, #07111f 0%, #0a1628 50%, #0b1d2d 100%);
        padding: 28px;
        color: #dbeafe;
    }

    .supply-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* HEADER */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .header-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        box-shadow: 0 10px 30px rgba(6,182,212,.2);
    }

    .page-title {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #f8fafc;
    }

    .page-subtitle {
        margin: 4px 0 0;
        color: #7892ad;
        font-size: 13px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 9px;
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.04);
        color: #b8cbe0;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-back:hover {
        background: rgba(6,182,212,.12);
        color: #67e8f9;
        border-color: rgba(6,182,212,.3);
    }

    /* INFO PRINCIPAL */

    .order-info {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }

    .info-card {
        background: rgba(10,25,42,.82);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 13px;
        padding: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,.15);
    }

    .info-label {
        color: #64809e;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 6px;
    }

    .info-value {
        color: #f1f5f9;
        font-size: 15px;
        font-weight: 700;
    }

    .info-value.accent {
        color: #67e8f9;
    }

    /* PROGRESO */

    .progress-card {
        background: rgba(10,25,42,.82);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 13px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .progress-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .progress-title {
        font-size: 13px;
        font-weight: 700;
        color: #dbeafe;
    }

    .progress-percent {
        color: #67e8f9;
        font-weight: 800;
        font-size: 14px;
    }

    .progress-bar {
        height: 9px;
        background: rgba(255,255,255,.07);
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #06b6d4, #22d3ee);
        border-radius: 99px;
        transition: width .3s ease;
    }

    /* ALERTAS */

    .alert-box {
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .alert-error {
        background: rgba(239,68,68,.1);
        border: 1px solid rgba(239,68,68,.25);
        color: #fca5a5;
    }

    .alert-success {
        background: rgba(34,197,94,.1);
        border: 1px solid rgba(34,197,94,.25);
        color: #86efac;
    }

    /* TABLA */

    .materials-card {
        background: rgba(8,22,37,.9);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0,0,0,.18);
    }

    .card-header {
        padding: 18px 20px;
        border-bottom: 1px solid rgba(255,255,255,.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .card-title {
        color: #f1f5f9;
        font-size: 15px;
        font-weight: 800;
    }

    .card-description {
        color: #607b98;
        font-size: 11px;
        margin-top: 3px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }

    th {
        background: rgba(255,255,255,.025);
        color: #6683a0;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .06em;
        text-align: left;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255,255,255,.06);
    }

    td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(255,255,255,.045);
        color: #c7d8ea;
        font-size: 13px;
        vertical-align: middle;
    }

    tbody tr {
        transition: background .15s;
    }

    tbody tr:hover {
        background: rgba(6,182,212,.035);
    }

    .material-name {
        color: #f1f5f9;
        font-weight: 700;
    }

    .material-detail {
        color: #66819c;
        font-size: 11px;
        margin-top: 3px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        border-radius: 99px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .03em;
    }

    .badge-label {
        background: rgba(59,130,246,.12);
        color: #93c5fd;
    }

    .badge-sticker {
        background: rgba(168,85,247,.12);
        color: #d8b4fe;
    }

    .badge-precinto {
        background: rgba(245,158,11,.12);
        color: #fcd34d;
    }

    .badge-caja {
        background: rgba(34,197,94,.12);
        color: #86efac;
    }

    .number {
        font-family: Consolas, monospace;
        font-weight: 700;
    }

    .stock-ok {
        color: #86efac;
    }

    .stock-low {
        color: #fcd34d;
    }

    .stock-danger {
        color: #fca5a5;
    }

    .pending {
        color: #67e8f9;
        font-weight: 800;
    }

    .quantity-input {
        width: 120px;
        padding: 9px 11px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,.1);
        background: rgba(255,255,255,.045);
        color: #f8fafc;
        outline: none;
        font-family: Consolas, monospace;
        font-weight: 700;
        text-align: center;
        transition: .2s;
    }

    .quantity-input:focus {
        border-color: #06b6d4;
        box-shadow: 0 0 0 3px rgba(6,182,212,.1);
    }

    .quantity-input.invalid {
        border-color: #ef4444;
        background: rgba(239,68,68,.08);
    }

    .input-help {
        display: block;
        margin-top: 4px;
        color: #59748f;
        font-size: 10px;
    }

    /* FOOTER FORM */

    .dispatch-footer {
        margin-top: 20px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 20px;
        align-items: end;
    }

    .observations {
        background: rgba(10,25,42,.82);
        border: 1px solid rgba(255,255,255,.07);
        border-radius: 13px;
        padding: 16px;
    }

    .field-label {
        display: block;
        color: #8ca6c0;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .textarea {
        width: 100%;
        min-height: 90px;
        resize: vertical;
        background: rgba(255,255,255,.035);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 8px;
        color: #e2e8f0;
        padding: 11px;
        outline: none;
        font-family: inherit;
    }

    .textarea:focus {
        border-color: #06b6d4;
    }

    .dispatch-summary {
        min-width: 300px;
        background: rgba(6,182,212,.06);
        border: 1px solid rgba(6,182,212,.16);
        border-radius: 13px;
        padding: 16px;
    }

    .summary-title {
        color: #67e8f9;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        color: #8ba5bd;
        font-size: 12px;
    }

    .summary-row strong {
        color: #f1f5f9;
        font-family: Consolas, monospace;
    }

    .btn-submit {
        width: 100%;
        margin-top: 14px;
        padding: 12px 18px;
        border: none;
        border-radius: 9px;
        background: linear-gradient(135deg, #0891b2, #06b6d4);
        color: white;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        transition: .2s;
        box-shadow: 0 7px 20px rgba(6,182,212,.18);
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(6,182,212,.25);
    }

    .btn-submit:disabled {
        opacity: .45;
        cursor: not-allowed;
        transform: none;
    }

    /* RESPONSIVE */

    @media(max-width: 900px) {

        .supply-page {
            padding: 18px;
        }

        .order-info {
            grid-template-columns: 1fr 1fr;
        }

        .dispatch-footer {
            grid-template-columns: 1fr;
        }

        .dispatch-summary {
            min-width: 0;
        }
    }

    @media(max-width: 600px) {

        .page-header {
            flex-direction: column;
        }

        .order-info {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 21px;
        }
    }
</style>


<div class="supply-page">

    <div class="supply-container">

        {{-- ================================================= --}}
        {{-- HEADER --}}
        {{-- ================================================= --}}

        <div class="page-header">

            <div class="header-left">

                <div class="header-icon">
                    🚚
                </div>

                <div>
                    <h1 class="page-title">
                        Registrar salida
                    </h1>

                    <p class="page-subtitle">
                        Registra los suministros que serán enviados a la planta.
                    </p>
                </div>

            </div>


            <a
                href="{{ route('supply-orders.show', $supplyOrder) }}"
                class="btn-back"
            >
                ← Volver al detalle
            </a>

        </div>


        {{-- ================================================= --}}
        {{-- MENSAJES --}}
        {{-- ================================================= --}}

        @if(session('success'))

            <div class="alert-box alert-success">
                ✓ {{ session('success') }}
            </div>

        @endif


        @if($errors->any())

            <div class="alert-box alert-error">

                <strong>Revisa la información:</strong>

                <ul style="margin:7px 0 0 18px;">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ================================================= --}}
        {{-- INFORMACIÓN DE LA ORDEN --}}
        {{-- ================================================= --}}

        <div class="order-info">

            <div class="info-card">

                <div class="info-label">
                    Orden de abastecimiento
                </div>

                <div class="info-value accent">
                    {{ $supplyOrder->numero_orden }}
                </div>

            </div>


            <div class="info-card">

                <div class="info-label">
                    Planta
                </div>

                <div class="info-value">
                    {{ $supplyOrder->planta }}
                </div>

            </div>


            <div class="info-card">

                <div class="info-label">
                    Fecha requerida
                </div>

                <div class="info-value">

                    @if($supplyOrder->fecha_requerida)

                        {{ $supplyOrder->fecha_requerida->format('d/m/Y') }}

                    @else

                        —

                    @endif

                </div>

            </div>


            <div class="info-card">

                <div class="info-label">
                    Estado
                </div>

                <div class="info-value accent">
                    {{ $supplyOrder->estado }}
                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PROGRESO --}}
        {{-- ================================================= --}}

        @php

            $totalSolicitado = 0;
            $totalEntregado = 0;

            foreach($supplyOrder->items as $item)