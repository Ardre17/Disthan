@extends('layouts.app')

@section('content')
{{-- =============================================================
     ESTILOS
============================================================= --}}
<style>

    /* =========================================================
       BASE
    ========================================================= */

    .validation-page {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding: 28px 30px 50px;
        color: #1e293b;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .validation-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .validation-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .validation-title-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .validation-title h1 {
        margin: 0;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .validation-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .validation-status-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 13px;
        border-radius: 30px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22c55e;
    }


    /* =========================================================
       BUSCADOR
    ========================================================= */

    .validation-search-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 21px;
        margin-bottom: 28px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
    }

    .search-card-label {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .search-card-label > i {
        width: 37px;
        height: 37px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .search-card-label div {
        display: flex;
        flex-direction: column;
    }

    .search-card-label strong {
        font-size: 14px;
        color: #0f172a;
    }

    .search-card-label span {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .search-row {
        display: flex;
        gap: 10px;
    }

    .search-input-wrapper {
        flex: 1;
        height: 53px;
        display: flex;
        align-items: center;
        border: 2px solid #e2e8f0;
        border-radius: 11px;
        background: #f8fafc;
        transition: .2s ease;
    }

    .search-input-wrapper:focus-within {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
    }

    .search-input-wrapper > i {
        margin-left: 17px;
        color: #94a3b8;
        font-size: 19px;
    }

    .search-input-wrapper input {
        width: 100%;
        height: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 0 16px;
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
    }

    .search-input-wrapper input::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .btn-search {
        min-width: 175px;
        border: 0;
        border-radius: 11px;
        background: #2563eb;
        color: #ffffff;
        font-weight: 700;
        font-size: 13px;
        padding: 0 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-search:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-search:disabled {
        opacity: .7;
        cursor: wait;
        transform: none;
    }

    .search-help {
        margin-top: 9px;
        font-size: 11px;
        color: #94a3b8;
    }

    .search-help i {
        margin-right: 4px;
    }


    /* =========================================================
       INFORMACIÓN PEDIDO
    ========================================================= */

    .order-info-card {
        display: grid;
        grid-template-columns: 1.5fr 1.5fr 1fr 1fr;
        gap: 0;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 28px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
    }

    .order-info-main {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 19px 21px;
    }

    .order-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .order-main-text {
        display: flex;
        flex-direction: column;
    }

    .order-label {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .order-main-text strong {
        margin-top: 3px;
        font-size: 16px;
        color: #0f172a;
    }

    .order-info-item {
        min-height: 57px;
        border-left: 1px solid #e2e8f0;
        padding: 10px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .order-info-item span {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .order-info-item strong {
        color: #334155;
        font-size: 13px;
        margin-top: 3px;
        word-break: break-word;
    }


    /* =========================================================
       MODALIDADES
    ========================================================= */

    .section-heading {
        margin-bottom: 15px;
    }

    .section-heading h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .section-heading p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .modalities-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 17px;
        margin-bottom: 28px;
    }

    .modality-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
        transition: .2s ease;
    }

    .modality-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 24px rgba(15, 23, 42, .09);
    }

    .modality-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .modality-blue::before {
        background: #2563eb;
    }

    .modality-green::before {
        background: #16a34a;
    }

    .modality-orange::before {
        background: #f59e0b;
    }

    .modality-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modality-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .modality-blue .modality-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .modality-green .modality-icon {
        background: #f0fdf4;
        color: #16a34a;
    }

    .modality-orange .modality-icon {
        background: #fffbeb;
        color: #d97706;
    }

    .modality-number {
        color: #cbd5e1;
        font-size: 22px;
        font-weight: 800;
    }

    .modality-card h3 {
        margin: 17px 0 7px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
    }

    .modality-card p {
        min-height: 55px;
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.55;
    }

    .modality-features {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin: 17px 0;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .modality-features span {
        color: #64748b;
        font-size: 11px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .modality-blue .modality-features i {
        color: #2563eb;
    }

    .modality-green .modality-features i {
        color: #16a34a;
    }

    .modality-orange .modality-features i {
        color: #d97706;
    }

    .modality-button {
        width: 100%;
        height: 43px;
        border: 0;
        border-radius: 9px;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: .2s ease;
    }

    .modality-blue .modality-button {
        background: #2563eb;
    }

    .modality-blue .modality-button:hover {
        background: #1d4ed8;
    }

    .modality-green .modality-button {
        background: #16a34a;
    }

    .modality-green .modality-button:hover {
        background: #15803d;
    }

    .modality-orange .modality-button {
        background: #d97706;
    }

    .modality-orange .modality-button:hover {
        background: #b45309;
    }


    /* =========================================================
       PANELES
    ========================================================= */

    .validation-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .06);
        margin-bottom: 25px;
    }

    .panel-header {
        min-height: 69px;
        padding: 13px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #ffffff;
    }

    .panel-blue {
        background: #2563eb;
    }

    .panel-green {
        background: #16a34a;
    }

    .panel-orange {
        background: #d97706;
    }

    .panel-header-left {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .panel-icon {
        width: 39px;
        height: 39px;
        border-radius: 10px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .panel-header-left div:last-child {
        display: flex;
        flex-direction: column;
    }

    .panel-header-left span {
        font-size: 9px;
        opacity: .75;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .panel-header-left strong {
        margin-top: 2px;
        font-size: 14px;
        font-weight: 800;
    }

    .progress-counter {
        padding: 7px 12px;
        border-radius: 20px;
        background: rgba(255,255,255,.15);
        font-size: 12px;
        font-weight: 800;
    }

    .panel-body {
        padding: 24px;
    }


    /* =========================================================
       PROGRESO ITEM
    ========================================================= */

    .item-progress {
        margin-bottom: 22px;
    }

    .progress-line {
        height: 6px;
        width: 100%;
        border-radius: 20px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-line-fill {
        height: 100%;
        width: 0%;
        border-radius: inherit;
        transition: width .25s ease;
    }

    .progress-blue {
        background: #2563eb;
    }


    /* =========================================================
       ITEM
    ========================================================= */

    .item-validation-content {
        max-width: 920px;
        margin: 0 auto;
        text-align: center;
    }

    .product-main-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 13px;
        border-radius: 18px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .product-overline {
        color: #94a3b8;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .product-information h2 {
        margin: 6px 0 2px;
        color: #0f172a;
        font-size: 23px;
        font-weight: 800;
    }

    .product-brand {
        color: #64748b;
        font-size: 13px;
    }

    .product-data-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        max-width: 600px;
        margin: 22px auto;
    }

    .product-data-box {
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .product-data-box span {
        color: #94a3b8;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .product-data-box strong {
        color: #0f172a;
        font-size: 23px;
        font-weight: 800;
    }

    .product-code {
        font-size: 13px !important;
        word-break: break-all;
    }


    /* =========================================================
       CANTIDAD PARCIAL
    ========================================================= */

    .partial-quantity-box {
        max-width: 600px;
        margin: 0 auto 18px;
        padding: 14px;
        border-radius: 12px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        text-align: left;
    }

    .partial-quantity-box > div {
        display: flex;
        flex-direction: column;
    }

    .partial-quantity-box span {
        color: #b45309;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .6px;
    }

    .partial-quantity-box strong {
        margin-top: 3px;
        color: #92400e;
        font-size: 12px;
    }

    .partial-quantity-box input {
        width: 140px;
        height: 46px;
        border: 2px solid #f59e0b;
        border-radius: 9px;
        outline: none;
        text-align: center;
        font-size: 18px;
        font-weight: 800;
        background: #ffffff;
    }

    .partial-quantity-box input:focus {
        box-shadow: 0 0 0 4px rgba(245, 158, 11, .12);
    }


    /* =========================================================
       BOTONES VALIDACIÓN
    ========================================================= */

    .validation-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 18px;
    }

    .validation-action {
        min-height: 72px;
        border-radius: 11px;
        border: 2px solid;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: .18s ease;
    }

    .validation-action > i {
        font-size: 25px;
    }

    .validation-action span {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .validation-action strong {
        font-size: 12px;
        font-weight: 800;
    }

    .validation-action small {
        margin-top: 2px;
        font-size: 9px;
        opacity: .7;
    }

    .action-danger {
        color: #dc2626;
        border-color: #fecaca;
    }

    .action-danger:hover {
        background: #fef2f2;
        border-color: #ef4444;
    }

    .action-warning {
        color: #d97706;
        border-color: #fde68a;
    }

    .action-warning:hover {
        background: #fffbeb;
        border-color: #f59e0b;
    }

    .action-success {
        color: #16a34a;
        border-color: #bbf7d0;
    }

    .action-success:hover {
        background: #f0fdf4;
        border-color: #22c55e;
    }

    .validation-action:disabled {
        opacity: .5;
        cursor: not-allowed;
    }


    /* =========================================================
       ESCÁNER
    ========================================================= */

    .scanner-body {
        min-height: 500px;
    }

    .scanner-instruction {
        text-align: center;
        margin-bottom: 18px;
    }

    .scanner-large-icon {
        width: 75px;
        height: 75px;
        margin: 0 auto 12px;
        border-radius: 20px;
        background: #f0fdf4;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }

    .scanner-instruction h2 {
        margin: 0;
        color: #0f172a;
        font-size: 21px;
        font-weight: 800;
    }

    .scanner-instruction p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .scanner-input-wrapper {
        max-width: 700px;
        height: 62px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        border: 3px solid #16a34a;
        border-radius: 13px;
        background: #f0fdf4;
        box-shadow: 0 0 0 5px rgba(22,163,74,.07);
    }

    .scanner-input-wrapper > i {
        margin-left: 20px;
        color: #16a34a;
        font-size: 22px;
    }

    .scanner-input-wrapper input {
        width: 100%;
        height: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 0 18px;
        color: #14532d;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
    }

    .scanner-input-wrapper input::placeholder {
        color: #86efac;
        font-weight: 500;
    }

    .scanner-help {
        max-width: 700px;
        margin: 10px auto 22px;
        display: flex;
        justify-content: center;
        gap: 20px;
        color: #94a3b8;
        font-size: 10px;
    }

    .scanner-help span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .scanner-help i {
        color: #16a34a;
    }

    .scanner-product-card {
        max-width: 900px;
        margin: 0 auto;
        padding: 19px;
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        background: #f0fdf4;
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 15px;
    }

    .scanner-product-icon {
        width: 55px;
        height: 55px;
        border-radius: 13px;
        background: #dcfce7;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .scanner-product-info > span {
        color: #16a34a;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .7px;
    }

    .scanner-product-info h2 {
        margin: 3px 0 1px;
        color: #14532d;
        font-size: 18px;
        font-weight: 800;
    }

    .scanner-product-info p {
        margin: 0;
        color: #64748b;
        font-size: 11px;
    }

    .scanner-product-data {
        display: flex;
        gap: 25px;
    }

    .scanner-product-data div {
        display: flex;
        flex-direction: column;
        text-align: right;
    }

    .scanner-product-data span {
        color: #94a3b8;
        font-size: 8px;
        font-weight: 800;
    }

    .scanner-product-data strong {
        color: #14532d;
        font-size: 17px;
        margin-top: 2px;
    }

    .scanner-product-card .partial-quantity-box {
        grid-column: 1 / -1;
        width: 100%;
        margin: 0;
    }

    .scanner-product-card .validation-actions {
        grid-column: 1 / -1;
        width: 100%;
        margin-top: 0;
    }


    /* =========================================================
       TABLA COMPLETA
    ========================================================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .validation-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .validation-table th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 13px 14px;
        color: #64748b;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .validation-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 12px;
        vertical-align: middle;
    }

    .validation-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .validation-table tbody tr:hover {
        background: #f8fafc;
    }

    .table-product-name {
        color: #0f172a;
        font-weight: 700;
        font-size: 12px;
    }

    .table-product-brand {
        margin-top: 2px;
        color: #94a3b8;
        font-size: 10px;
    }

    .table-code {
        color: #64748b;
        font-family: monospace;
        font-size: 11px;
    }

    .table-quantity {
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .validation-table input,
    .validation-table select {
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: #ffffff;
        outline: none;
        font-size: 11px;
    }

    .validation-table input {
        width: 120px;
        text-align: center;
        font-weight: 700;
    }

    .validation-table input:focus,
    .validation-table select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    .validation-table select {
        min-width: 135px;
        padding: 0 10px;
    }


    /* =========================================================
       FOOTER PEDIDO COMPLETO
    ========================================================= */

    .complete-footer {
        margin-top: 20px;
        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 15px;
        align-items: end;
    }

    .observation-box {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .observation-box label {
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .observation-box label i {
        margin-right: 4px;
    }

    .observation-box textarea {
        width: 100%;
        resize: vertical;
        min-height: 80px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        outline: none;
        padding: 11px;
        font-size: 12px;
    }

    .observation-box textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    .save-validation-button {
        height: 50px;
        border: 0;
        border-radius: 10px;
        background: #16a34a;
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: .2s ease;
    }

    .save-validation-button:hover {
        background: #15803d;
        transform: translateY(-1px);
    }

    .save-validation-button:disabled {
        opacity: .7;
        cursor: wait;
        transform: none;
    }


    /* =========================================================
       ALERTA
    ========================================================= */

    .validation-alert {
        position: fixed;
        top: 20px;
        right: 25px;
        z-index: 9999;
        max-width: 430px;
        padding: 14px 18px;
        border-radius: 11px;
        box-shadow: 0 8px 25px rgba(15,23,42,.15);
        font-size: 12px;
        font-weight: 600;
    }

    .validation-alert.alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .validation-alert.alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .validation-alert.alert-warning {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }


    /* =========================================================
       RESPONSIVE TABLET
    ========================================================= */

    @media (max-width: 1100px) {

        .validation-page {
            padding: 22px 20px 40px;
        }

        .modalities-grid {
            grid-template-columns: 1fr;
        }

        .modality-card p {
            min-height: auto;
        }

        .order-info-card {
            grid-template-columns: 1fr 1fr;
        }

        .order-info-main {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0;
        }

        .order-info-item:nth-child(3) {
            border-left: 0;
        }

    }


    /* =========================================================
       RESPONSIVE MÓVIL
    ========================================================= */

    @media (max-width: 700px) {

        .validation-page {
            padding: 16px 12px 35px;
        }

        .validation-header {
            align-items: flex-start;
        }

        .validation-title-icon {
            width: 43px;
            height: 43px;
            font-size: 20px;
        }

        .validation-title h1 {
            font-size: 21px;
        }

        .validation-title p {
            font-size: 11px;
        }

        .validation-status-badge {
            display: none;
        }

        .validation-search-card {
            padding: 15px;
            border-radius: 13px;
        }

        .search-row {
            flex-direction: column;
        }

        .search-input-wrapper {
            height: 55px;
        }

        .btn-search {
            width: 100%;
            height: 50px;
        }

        .order-info-card {
            grid-template-columns: 1fr;
        }

        .order-info-main {
            grid-column: auto;
        }

        .order-info-item {
            border-left: 0;
            border-top: 1px solid #e2e8f0;
        }

        .order-info-item:nth-child(3) {
            border-left: 0;
        }

        .modalities-grid {
            gap: 12px;
        }

        .modality-card {
            padding: 18px;
        }

        .panel-body {
            padding: 15px;
        }

        .panel-header {
            min-height: 61px;
            padding: 10px 13px;
        }

        .product-information h2 {
            font-size: 19px;
        }

        .product-data-grid {
            grid-template-columns: 1fr;
        }

        .validation-actions {
            grid-template-columns: 1fr;
        }

        .validation-action {
            min-height: 62px;
        }

        .partial-quantity-box {
            flex-direction: column;
            align-items: stretch;
        }

        .partial-quantity-box input {
            width: 100%;
        }

        .scanner-product-card {
            grid-template-columns: auto 1fr;
        }

        .scanner-product-data {
            grid-column: 1 / -1;
            justify-content: space-between;
        }

        .scanner-product-data div {
            text-align: left;
        }

        .complete-footer {
            grid-template-columns: 1fr;
        }

        .save-validation-button {
            width: 100%;
        }

    }
/* =========================================================
   PENDIENTES E HISTORIAL
========================================================= */

.validation-orders-section {
    margin-top: 24px;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.validation-list-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
}

.validation-list-header {
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #e2e8f0;
}

.validation-list-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.validation-list-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
}

.validation-list-icon.pending {
    background: #fff7ed;
    color: #ea580c;
}

.validation-list-icon.history {
    background: #eff6ff;
    color: #2563eb;
}

.validation-list-title strong {
    display: block;
    font-size: 16px;
    color: #0f172a;
}

.validation-list-title span {
    display: block;
    margin-top: 2px;
    font-size: 12px;
    color: #64748b;
}

.validation-count {
    min-width: 30px;
    height: 30px;
    padding: 0 9px;
    border-radius: 20px;
    background: #f1f5f9;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
}

.validation-table-wrapper {
    overflow-x: auto;
}

.validation-list-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

.validation-list-table th {
    padding: 11px 16px;
    text-align: left;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    white-space: nowrap;
}

.validation-list-table td {
    padding: 14px 16px;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13px;
    vertical-align: middle;
}

.validation-list-table tbody tr:hover {
    background: #f8fafc;
}

.validation-order-number {
    font-weight: 700;
    color: #0f172a;
}

.validation-client-name {
    color: #475569;
}

.validation-empty {
    padding: 35px 20px;
    text-align: center;
    color: #94a3b8;
}

.validation-empty i {
    display: block;
    font-size: 30px;
    margin-bottom: 8px;
}

.validation-status {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.validation-status.completo {
    background: #dcfce7;
    color: #15803d;
}

.validation-status.parcial {
    background: #fef3c7;
    color: #b45309;
}

.validation-status.no-enviado {
    background: #fee2e2;
    color: #b91c1c;
}

.validation-status.pendiente {
    background: #f1f5f9;
    color: #475569;
}

.validation-row-actions {
    display: flex;
    gap: 7px;
    flex-wrap: wrap;
}

.validation-row-button {
    border: 0;
    border-radius: 8px;
    padding: 7px 10px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: .15s ease;
}

.validation-row-button:hover {
    transform: translateY(-1px);
}

.validation-row-button.open {
    background: #eff6ff;
    color: #2563eb;
}

.validation-row-button.history {
    background: #f1f5f9;
    color: #475569;
}

.validation-row-button.revalidate {
    background: #ecfdf5;
    color: #047857;
}

.validation-history-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(15, 23, 42, .55);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.validation-history-modal.d-none {
    display: none;
}

.validation-history-dialog {
    width: min(1000px, 100%);
    max-height: 90vh;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(15, 23, 42, .25);
    display: flex;
    flex-direction: column;
}

.validation-history-dialog-header {
    padding: 18px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.validation-history-dialog-header strong {
    font-size: 17px;
    color: #0f172a;
}

.validation-history-close {
    width: 34px;
    height: 34px;
    border: 0;
    border-radius: 8px;
    background: #f1f5f9;
    color: #475569;
    cursor: pointer;
    font-size: 17px;
}

.validation-history-dialog-body {
    padding: 20px;
    overflow-y: auto;
}

.validation-history-summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.validation-history-summary-item {
    padding: 12px;
    border-radius: 10px;
    background: #f8fafc;
}

.validation-history-summary-item span {
    display: block;
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.validation-history-summary-item strong {
    display: block;
    margin-top: 4px;
    color: #0f172a;
    font-size: 13px;
}

@media (max-width: 700px) {
    .validation-history-summary {
        grid-template-columns: 1fr 1fr;
    }

    .validation-list-header {
        align-items: flex-start;
    }
}
/* =========================================================
   FILTROS HISTORIAL
========================================================= */

.validation-history-filters {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    flex-wrap: wrap;
    padding: 16px 18px;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
}

.validation-history-filter-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.validation-history-filter-group label {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #64748b;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .5px;
}

.validation-history-filter-group input {
    height: 38px;
    min-width: 155px;
    padding: 0 10px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    font-size: 12px;
    outline: none;
}

.validation-history-filter-group input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.validation-history-filter-button,
.validation-history-clear-button {
    height: 38px;
    border: 0;
    border-radius: 8px;
    padding: 0 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 10px;
    font-weight: 800;
    cursor: pointer;
    transition: .15s ease;
}

.validation-history-filter-button {
    background: #2563eb;
    color: #ffffff;
}

.validation-history-filter-button:hover {
    background: #1d4ed8;
}

.validation-history-clear-button {
    background: #e2e8f0;
    color: #475569;
}

.validation-history-clear-button:hover {
    background: #cbd5e1;
}


/* =========================================================
   PAGINACIÓN HISTORIAL
========================================================= */

.validation-history-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 16px;
    border-top: 1px solid #e2e8f0;
    background: #ffffff;
    flex-wrap: wrap;
}

.validation-history-page-button {
    min-width: 34px;
    height: 34px;
    padding: 0 9px;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    background: #ffffff;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: .15s ease;
}

.validation-history-page-button:hover {
    background: #f1f5f9;
}

.validation-history-page-button.active {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
}

.validation-history-page-button:disabled {
    opacity: .45;
    cursor: not-allowed;
}

.validation-history-page-info {
    margin: 0 8px;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
}


/* =========================================================
   RESPONSIVE FILTROS HISTORIAL
========================================================= */

@media (max-width: 700px) {

    .validation-history-filters {
        align-items: stretch;
        flex-direction: column;
    }

    .validation-history-filter-group input,
    .validation-history-filter-button,
    .validation-history-clear-button {
        width: 100%;
    }

}
/* =========================================================
   PAGINADOR - HISTORIAL DE VALIDACIONES
   ========================================================= */

.historial-paginacion {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 18px 20px;
    margin-top: 10px;
    border-top: 1px solid #e5e7eb;
    background: #fafafa;
}

.historial-paginacion-info {
    color: #6b7280;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
}

.historial-paginacion-nav {
    display: flex;
    align-items: center;
    gap: 5px;
}

.historial-paginacion-nav a,
.historial-paginacion-nav span {
    min-width: 36px;
    height: 36px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0 10px;

    border: 1px solid #e5e7eb;
    border-radius: 8px;

    background: #ffffff;

    color: #374151;

    font-size: 13px;
    font-weight: 600;

    text-decoration: none;

    transition:
        background-color 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease,
        transform 0.2s ease;
}

.historial-paginacion-nav a:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    color: #111827;
    transform: translateY(-1px);
}

.historial-paginacion-nav .active {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
    cursor: default;
}

.historial-paginacion-nav .disabled {
    background: #f9fafb;
    border-color: #f0f0f0;
    color: #c4c7cc;
    cursor: not-allowed;
}

.historial-paginacion-nav .dots {
    min-width: auto;
    padding: 0 5px;
    border: none;
    background: transparent;
    color: #9ca3af;
}

/* Iconos de anterior / siguiente */
.historial-paginacion-nav .pagina-anterior,
.historial-paginacion-nav .pagina-siguiente {
    font-size: 15px;
}

/* Responsive */
@media (max-width: 768px) {

    .historial-paginacion {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .historial-paginacion-info {
        white-space: normal;
        text-align: center;
    }

    .historial-paginacion-nav {
        flex-wrap: wrap;
        justify-content: center;
    }

    .historial-paginacion-nav a,
    .historial-paginacion-nav span {
        min-width: 34px;
        height: 34px;
    }
}

    /* =========================================================
       REDISEÑO · VALIDACIÓN DE PEDIDOS (prefijo vp-)
       Aditivo: sobrescribe estilos, no toca IDs ni lógica.
    ========================================================= */
    .vp{
        --vp-blue:#1d7ff2; --vp-blue-soft:#eaf2ff; --vp-navy:#1e3a5f;
        --vp-green:#16a34a; --vp-orange:#f59e0b; --vp-red:#ef4444;
        --vp-text:#0f172a; --vp-muted:#64748b; --vp-line:#e2e8f0; --vp-bg:#f8fafc;
        --vp-mono:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
        max-width:1680px;
        padding:16px 22px 44px;
    }
    .vp *{box-sizing:border-box;}
    .vp-card{background:#fff;border:1px solid var(--vp-line);border-radius:14px;padding:14px;box-shadow:0 1px 2px rgba(15,23,42,.04);}
    .vp-num{font-family:var(--vp-mono);font-variant-numeric:tabular-nums;}
    .vp-hide{display:none !important;}
    .vp-crumb{font-size:12.5px;color:var(--vp-muted);margin-bottom:10px;}
    .vp-crumb b{color:var(--vp-text);font-weight:600;}

    /* Cabecera */
    .vp .validation-header{margin-bottom:12px;}
    .vp .validation-title-icon{width:58px;height:58px;border-radius:14px;background:#e3eefc;color:var(--vp-blue);font-size:28px;}
    .vp .validation-title h1{font-size:24px;color:var(--vp-navy);letter-spacing:-.3px;}

    /* Buscador original (compacto) */
    .vp .validation-search-card{display:flex !important;align-items:center;gap:18px;flex-wrap:wrap;padding:12px 16px !important;margin-bottom:14px !important;border-radius:14px !important;}
    .vp .search-card-label{flex-shrink:0;margin:0 !important;}
    .vp .search-row{flex:1;min-width:260px;margin:0 !important;}
    .vp .search-help{display:none !important;}

    /* Grid de 3 columnas */
    .vp-grid{display:grid;grid-template-columns:330px minmax(0,1fr) 320px;gap:14px;align-items:start;}
    @media(max-width:1320px){
        .vp-grid{grid-template-columns:320px minmax(0,1fr);}
        .vp-right{grid-column:2;}
    }
    @media(max-width:900px){
        .vp-grid{grid-template-columns:1fr;}
        .vp-right{grid-column:1;}
        .vp{padding:12px 12px 36px;}
    }

    /* Lista de pedidos (izquierda) */
    .vp-ltabs{display:flex;gap:6px;margin-bottom:10px;}
    .vp-ltab{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:9px 8px;border:none;border-radius:9px;background:#eef2f7;color:#334155;font-size:12.5px;font-weight:700;cursor:pointer;font-family:inherit;}
    .vp-ltab em{font-style:normal;background:rgba(15,23,42,.08);border-radius:99px;padding:1px 8px;font-size:11px;}
    .vp-ltab.on{background:var(--vp-blue);color:#fff;}
    .vp-ltab.on em{background:rgba(255,255,255,.25);}
    .vp-lsearch{position:relative;margin-bottom:10px;}
    .vp-lsearch i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;}
    .vp-lsearch input{width:100%;padding:10px 12px 10px 36px;border:1px solid var(--vp-line);border-radius:10px;font-size:13px;outline:none;font-family:inherit;}
    .vp-lsearch input:focus{border-color:var(--vp-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);}
    .vp-list{display:none;flex-direction:column;gap:9px;max-height:calc(100vh - 360px);min-height:220px;overflow-y:auto;padding:2px;}
    .vp-list.on{display:flex;}
    .vp-oc{display:flex;gap:11px;align-items:center;padding:11px 12px;border:1px solid var(--vp-line);border-radius:12px;cursor:pointer;background:#fff;transition:border-color .15s,box-shadow .15s,background .15s;}
    .vp-oc:hover{border-color:#b9d3f7;box-shadow:0 4px 12px rgba(15,23,42,.06);}
    .vp-oc.sel{border-color:var(--vp-blue);background:#f3f8ff;box-shadow:0 0 0 2px rgba(29,127,242,.15);}
    .vp-oc-ic{width:42px;height:42px;border-radius:10px;background:#e8f0fe;color:var(--vp-blue);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
    .vp-oc-b{flex:1;min-width:0;}
    .vp-oc-b .r1{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
    .vp-oc-b .r1 b{font-size:14px;font-weight:800;color:var(--vp-text);}
    .vp-oc-b .cli{font-size:12.5px;color:#334155;margin:2px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .vp-oc-b .meta{display:flex;gap:10px;flex-wrap:wrap;font-size:11.5px;color:var(--vp-muted);margin-top:2px;}
    .vp-oc-b .meta i{margin-right:4px;}
    .vp-oc > .bi-chevron-right{color:var(--vp-blue);font-size:15px;}
    .vp-chip{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;border-radius:99px;padding:2px 10px;}
    .vp-chip.pend{background:#eef2f7;color:#475569;}
    .vp-chip.rev{background:#fff1d6;color:#b45309;}
    .vp-chip.ok{background:#dcfce7;color:#15803d;}
    .vp-oc-act{display:flex;gap:6px;margin-top:6px;}
    .vp-mini{border:1px solid var(--vp-line);background:#fff;border-radius:7px;font-size:11px;font-weight:700;padding:4px 9px;cursor:pointer;color:#334155;font-family:inherit;}
    .vp-mini:hover{background:#f1f5f9;}
    .vp-lfoot{display:block;text-align:center;margin-top:10px;font-size:12.5px;font-weight:600;color:var(--vp-blue);background:none;border:none;cursor:pointer;width:100%;font-family:inherit;}
    .vp-lempty{text-align:center;color:#94a3b8;padding:28px 10px;font-size:13px;}

    /* Centro */
    .vp-center{display:flex;flex-direction:column;gap:14px;min-width:0;}
    .vp-empty{text-align:center;padding:64px 20px;color:var(--vp-muted);}
    .vp-empty i{font-size:42px;color:#b9d3f7;display:block;margin-bottom:10px;}
    .vp-empty b{display:block;font-size:16px;color:var(--vp-text);margin-bottom:4px;}

    .vp-oh{background:#fff;border:1px solid var(--vp-line);border-radius:14px;padding:14px 16px;display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;align-items:flex-start;}
    .vp-oh-l{display:flex;gap:13px;align-items:flex-start;min-width:0;}
    .vp-oh-ic{width:46px;height:46px;border-radius:11px;background:#e8f0fe;color:var(--vp-blue);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .vp-oh-t{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
    .vp-oh-t strong{font-size:18px;font-weight:800;color:var(--vp-navy);font-family:var(--vp-mono);}
    .vp-oh-cli{font-size:13px;color:#334155;margin-top:2px;}
    .vp-oh-meta{display:flex;gap:18px;flex-wrap:wrap;margin-top:10px;font-size:12.5px;color:var(--vp-muted);}
    .vp-oh-meta span{display:inline-flex;align-items:center;gap:6px;}
    .vp-oh-meta b{color:var(--vp-text);font-weight:600;}
    .vp-oh-meta small{font-size:10.5px;text-transform:uppercase;letter-spacing:.04em;opacity:.8;}
    .vp-oh-r{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
    .vp-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;border:1px solid transparent;font-family:inherit;}
    .vp-btn.green{background:#16a34a;color:#fff;}
    .vp-btn.green:hover{background:#15803d;}
    .vp-btn.white{background:#fff;color:#1e293b;border-color:var(--vp-line);}
    .vp-btn.white:hover{background:#f1f5f9;}
    .vp-dd{position:relative;}
    .vp-dd-menu{display:none;position:absolute;right:0;top:calc(100% + 6px);min-width:230px;background:#fff;border:1px solid var(--vp-line);border-radius:10px;box-shadow:0 12px 30px rgba(15,23,42,.14);padding:6px;z-index:60;}
    .vp-dd.open .vp-dd-menu{display:block;}
    .vp-dd-menu button{display:flex;align-items:center;gap:9px;width:100%;padding:9px 10px;border:none;background:none;border-radius:7px;font-size:13px;color:#1e293b;cursor:pointer;font-family:inherit;text-align:left;}
    .vp-dd-menu button:hover{background:#f1f5f9;}

    /* Progreso */
    .vp-prog-top{display:flex;justify-content:space-between;align-items:flex-end;gap:10px;margin-bottom:8px;}
    .vp-prog-top b{font-size:14px;font-weight:800;}
    .vp-prog-top span{font-size:12.5px;color:#334155;}
    .vp-prog-row{display:flex;align-items:center;gap:14px;}
    .vp-bar{flex:1;height:11px;background:#e5e7eb;border-radius:99px;overflow:hidden;}
    .vp-bar > div{height:100%;border-radius:99px;background:var(--vp-green);transition:width .3s;}
    .vp-prog-pct{font-size:22px;font-weight:800;color:var(--vp-green);font-family:var(--vp-mono);}
    .vp-legend{display:flex;gap:16px;flex-wrap:wrap;margin-top:10px;font-size:12px;color:var(--vp-muted);}
    .vp-legend i{display:inline-block;width:9px;height:9px;border-radius:50%;margin-right:6px;}
    .vp-legend b{font-family:var(--vp-mono);color:var(--vp-text);margin-left:3px;}

    /* Modos de validación (compactos) */
    .vp-modes{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;}
    @media(max-width:560px){.vp-modes{grid-template-columns:1fr;}}
    .vp-mode{border:1px solid var(--vp-line);border-radius:12px;background:#fff;padding:12px 10px;text-align:center;cursor:pointer;position:relative;transition:border-color .15s,background .15s,box-shadow .15s;user-select:none;}
    .vp-mode:hover{border-color:#b9d3f7;}
    .vp-mode i{display:block;font-size:24px;color:var(--vp-blue);margin-bottom:4px;}
    .vp-mode b{display:block;font-size:14px;font-weight:800;color:var(--vp-text);}
    .vp-mode small{display:block;font-size:11.5px;color:var(--vp-muted);margin-top:1px;}
    .vp-mode.active{border:2px solid var(--vp-blue);background:#f3f8ff;box-shadow:0 4px 14px rgba(29,127,242,.14);padding:11px 9px;}

    /* Paneles de validación (originales, restilizados) */
    .vp .validation-panel{margin-bottom:0 !important;border-radius:14px !important;box-shadow:0 1px 2px rgba(15,23,42,.04) !important;}
    .vp .panel-header{min-height:0 !important;padding:11px 16px !important;}
    .vp .panel-body{padding:16px !important;}
    .vp .scanner-body{min-height:0 !important;}

    .vp .item-validation-content{max-width:none !important;margin:0 !important;text-align:left !important;display:grid;grid-template-columns:96px minmax(0,1fr);column-gap:16px;align-items:center;}
    .vp .item-validation-content > .product-main-icon{grid-row:1;margin:0 !important;width:96px !important;height:96px !important;border-radius:14px !important;overflow:hidden;}
    .vp .item-validation-content > .product-main-icon img{width:100%;height:100%;object-fit:cover;}
    .vp .item-validation-content > .product-information{grid-column:2;}
    .vp .item-validation-content > .product-data-grid,
    .vp .item-validation-content > .partial-quantity-box,
    .vp .item-validation-content > .validation-actions{grid-column:1 / -1;}
    .vp .product-information h2{font-size:20px !important;}
    .vp .product-data-grid{max-width:none !important;margin:14px 0 0 !important;}
    .vp .product-data-box{background:#fff !important;}

    .vp .partial-quantity-box{max-width:none !important;margin:12px 0 0 !important;justify-content:space-between;gap:12px;flex-wrap:wrap;}
    .vp-stepper{display:flex;align-items:center;gap:8px;}
    .vp-step{width:44px;height:46px;border:1px solid var(--vp-line);background:#fff;border-radius:10px;font-size:22px;font-weight:700;cursor:pointer;line-height:1;color:#334155;font-family:inherit;}
    .vp-step:hover{background:#f1f5f9;}
    .vp .partial-quantity-box input{width:110px !important;}

    .vp .validation-actions{grid-template-columns:1fr 1fr !important;margin-top:14px !important;}
    .vp .action-success{grid-column:1 / -1;order:-1;background:#16a34a !important;color:#fff !important;border-color:#16a34a !important;min-height:58px !important;}
    .vp .action-success:hover{background:#15803d !important;border-color:#15803d !important;}
    .vp .action-success small{opacity:.9 !important;font-size:11px !important;}
    .vp .action-success strong{font-size:14px !important;}
    .vp .action-danger{background:#fff5f5 !important;}
    .vp .action-warning{background:#fffbeb !important;}
    .vp .validation-action{min-height:52px !important;}

    /* Observaciones (espejo) */
    .vp-obs h4{display:flex;justify-content:space-between;align-items:center;font-size:14px;font-weight:800;margin:0 0 8px;}
    .vp-obs h4 span{font-size:11.5px;color:var(--vp-muted);font-weight:500;}
    .vp-obs textarea{width:100%;min-height:78px;border:1px solid var(--vp-line);border-radius:10px;padding:10px 12px;font-family:inherit;font-size:13px;resize:vertical;outline:none;}
    .vp-obs textarea:focus{border-color:var(--vp-blue);box-shadow:0 0 0 3px rgba(29,127,242,.1);}

    /* Productos del pedido (derecha) */
    .vp-right h4{display:flex;justify-content:space-between;align-items:center;font-size:14px;font-weight:800;margin:0 0 10px;}
    .vp-items{display:flex;flex-direction:column;gap:4px;max-height:calc(100vh - 250px);min-height:120px;overflow-y:auto;}
    .vp-it{display:grid;grid-template-columns:46px minmax(0,1fr) 28px;gap:10px;align-items:center;padding:8px;border:1px solid transparent;border-radius:10px;}
    .vp-it.cur{background:#f3f8ff;border-color:#bcd6fb;}
    .vp-it-th{width:46px;height:46px;border-radius:9px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:20px;}
    .vp-it-th img{width:100%;height:100%;object-fit:cover;}
    .vp-it-n{font-size:12.5px;font-weight:700;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .vp-it-s{font-size:11px;color:var(--vp-muted);font-family:var(--vp-mono);}
    .vp-it-p{display:flex;align-items:center;gap:7px;margin-top:3px;}
    .vp-it-p .vp-bar{height:6px;}
    .vp-it-p b{font-size:11px;font-family:var(--vp-mono);min-width:34px;text-align:right;}
    .vp-it-p span{font-size:11px;font-family:var(--vp-mono);color:#334155;min-width:34px;}
    .vp-it-st{font-size:24px;text-align:center;line-height:1;}
    .vp-st-ok{color:#16a34a;}.vp-st-par{color:#f59e0b;}.vp-st-no{color:#ef4444;}.vp-st-pen{color:#94a3b8;}

    /* Historial (original) debajo del grid */
    .vp .validation-orders-section{display:block !important;margin-top:16px;scroll-margin-top:calc(var(--tn-h,176px) + 12px);}
    .vp .validation-orders-section > .validation-list-card:first-child{display:none !important;}


    /* Ajustes de contención: evitar que las tres columnas excedan el área útil del ERP. */
    .validation-page.vp {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        max-width: 1680px;
        margin-left: auto;
        margin-right: auto;
    }
    .vp-grid, .vp-left, .vp-center, .vp-right { min-width: 0; }
    @media (max-width: 1550px) {
        .vp-grid { grid-template-columns: minmax(260px, 320px) minmax(0, 1fr); }
        .vp-right { grid-column: 2; }
    }
    @media (max-width: 950px) {
        .vp-grid { grid-template-columns: minmax(0, 1fr); }
        .vp-right { grid-column: 1; }
        .validation-page.vp { padding-left: 12px; padding-right: 12px; }
    }
</style>
<div class="validation-page vp">

    <div class="vp-crumb">Operaciones &nbsp;/&nbsp; Órdenes &nbsp;/&nbsp; <b>Validación de pedidos</b></div>

<div class="validation-header">

        <div class="validation-title">

            <div class="validation-title-icon">
                <i class="bi bi-clipboard2-check"></i>
            </div>

            <div>
                <h1>Validación de pedidos</h1>

                <p>
                    Revisa y confirma los productos del pedido.
                </p>
            </div>

        </div>

        <div class="validation-status-badge">
            <span class="status-dot"></span>
            Módulo de validación
        </div>

    </div>

{{-- =========================================================
         BUSCADOR
    ========================================================== --}}
    <div class="validation-search-card">

        <div class="search-card-label">
            <i class="bi bi-search"></i>

            <div>
                <strong>Buscar pedido</strong>

                <span>
                    Ingresa el número de factura o guía asociada.
                </span>
            </div>
        </div>


        <div class="search-row">

            <div class="search-input-wrapper">

                <i class="bi bi-upc-scan"></i>

                <input
                    type="text"
                    id="codigoPedido"
                    placeholder="Factura o guía..."
                    autocomplete="off"
                    autofocus
                >

            </div>


            <button
                type="button"
                id="btnBuscarPedido"
                class="btn-search"
            >
                <i class="bi bi-search"></i>
                <span>BUSCAR PEDIDO</span>
            </button>

        </div>

        <div class="search-help">
            <i class="bi bi-info-circle"></i>
            También puedes presionar <strong>Enter</strong> después de ingresar el código.
        </div>

    </div>

    {{-- =========================================================
         GRID: LISTA DE PEDIDOS · VALIDACIÓN · PRODUCTOS
    ========================================================== --}}
    <div class="vp-grid">

        {{-- ───────────── IZQUIERDA: pedidos ───────────── --}}
        <aside class="vp-left vp-card">

            <div class="vp-ltabs">
                <button type="button" class="vp-ltab on" data-pane="pend" onclick="vpLTab('pend', this)">
                    Pendientes <em>{{ $pendientes->count() }}</em>
                </button>
                <button type="button" class="vp-ltab" data-pane="val" onclick="vpLTab('val', this)">
                    Validados <em>{{ $historial->total() }}</em>
                </button>
            </div>

            <div class="vp-lsearch">
                <i class="bi bi-search"></i>
                <input type="text" id="vpLSearch" placeholder="Buscar por pedido, factura, guía, cliente..." autocomplete="off" oninput="vpLFiltrar()">
            </div>

            {{-- Pendientes (mismos datos y misma acción que la tabla original) --}}
            <div class="vp-list on" id="vpListPend">
                @forelse($pendientes as $pedido)
                    @php
                        $vpCli = $pedido->client->razon_social ?? $pedido->client->nombre_comercial ?? 'Sin cliente';
                        $vpFecha = $pedido->fecha_pedido ? \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') : '-';
                        $vpNProd = $pedido->details_count ?? null;
                    @endphp
                    <div class="vp-oc" tabindex="0" role="button"
                         data-numero="{{ $pedido->numero_orden }}"
                         data-search="{{ mb_strtolower(($pedido->numero_orden ?? '').' '.($pedido->factura_asociada ?? '').' '.($pedido->guia_asociada ?? '').' '.$vpCli) }}"
                         onclick="abrirPedidoDesdeLista({{ $pedido->id }})">
                        <div class="vp-oc-ic"><i class="bi bi-shop"></i></div>
                        <div class="vp-oc-b">
                            <div class="r1"><b>{{ $pedido->numero_orden ?? '-' }}</b><span class="vp-chip pend">Pendiente</span></div>
                            <div class="cli">{{ $vpCli }}</div>
                            <div class="meta">
                                <span><i class="bi bi-file-earmark-text"></i>{{ $pedido->factura_asociada ?? '-' }}</span>
                                <span><i class="bi bi-receipt"></i>{{ $pedido->guia_asociada ?? '-' }}</span>
                            </div>
                            <div class="meta">
                                <span><i class="bi bi-calendar3"></i>{{ $vpFecha }}</span>
                                @if($vpNProd !== null)<span><i class="bi bi-box-seam"></i>{{ $vpNProd }} productos</span>@endif
                            </div>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                @empty
                    <div class="vp-lempty"><i class="bi bi-check-circle" style="font-size:26px;"></i><br>No hay pedidos pendientes de validar</div>
                @endforelse
            </div>

            {{-- Validados (mismas acciones: historial y revalidar) --}}
            <div class="vp-list" id="vpListVal">
                @forelse($historial as $validacion)
                    @php
                        $vpPed = $validacion->order;
                        $vpEst = $validacion->estado;
                        $vpCli2 = $vpPed->client->razon_social ?? $vpPed->client->nombre_comercial ?? 'Sin cliente';
                    @endphp
                    @if($vpPed)
                    <div class="vp-oc" tabindex="0" role="button"
                         data-numero="{{ $vpPed->numero_orden }}"
                         data-search="{{ mb_strtolower(($vpPed->numero_orden ?? '').' '.($vpPed->factura_asociada ?? '').' '.($vpPed->guia_asociada ?? '').' '.$vpCli2) }}"
                         onclick="abrirPedidoDesdeLista({{ $vpPed->id }})" title="Revalidar este pedido">
                        <div class="vp-oc-ic" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-check2-circle"></i></div>
                        <div class="vp-oc-b">
                            <div class="r1">
                                <b>{{ $vpPed->numero_orden ?? '-' }}</b>
                                <span class="validation-status {{ strtolower(str_replace('_', '-', $vpEst)) }}">{{ $vpEst }}</span>
                            </div>
                            <div class="cli">{{ $vpCli2 }}</div>
                            <div class="meta">
                                <span><i class="bi bi-calendar3"></i>{{ $validacion->fecha_validacion ? \Carbon\Carbon::parse($validacion->fecha_validacion)->format('d/m/Y H:i') : '-' }}</span>
                                <span><i class="bi bi-person"></i>{{ $validacion->usuario->name ?? 'Sistema' }}</span>
                            </div>
                            <div class="vp-oc-act">
                                <button type="button" class="vp-mini" onclick="event.stopPropagation();verHistorialPedido({{ $vpPed->id }})"><i class="bi bi-clock-history"></i> Historial</button>
                                <button type="button" class="vp-mini" onclick="event.stopPropagation();abrirPedidoDesdeLista({{ $vpPed->id }})"><i class="bi bi-arrow-repeat"></i> Revalidar</button>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="vp-lempty"><i class="bi bi-clock-history" style="font-size:26px;"></i><br>Todavía no hay validaciones</div>
                @endforelse
                @if($historial->total() > 0)
                    <button type="button" class="vp-lfoot" onclick="vpIrHistorial()">Ver historial completo ({{ $historial->total() }}) <i class="bi bi-arrow-down"></i></button>
                @endif
            </div>
        </aside>

        {{-- ───────────── CENTRO: validación ───────────── --}}
        <main class="vp-center">

            <div class="vp-card vp-empty" id="vpEmpty">
                <i class="bi bi-clipboard2-check"></i>
                <b>Selecciona un pedido para validar</b>
                Elige uno de la lista o búscalo por factura o guía.
            </div>

            {{-- Información del pedido (mismos IDs) --}}
            <div id="pedidoInfo" class="vp-oh d-none">
                <div class="vp-oh-l">
                    <div class="vp-oh-ic"><i class="bi bi-shop"></i></div>
                    <div>
                        <div class="vp-oh-t">
                            <strong id="pedidoNumero">-</strong>
                            <span class="vp-chip rev" id="vpEstado">En revisión</span>
                        </div>
                        <div class="vp-oh-cli" id="pedidoCliente">-</div>
                        <div class="vp-oh-meta">
                            <span><i class="bi bi-calendar3"></i><b id="pedidoFecha" class="vp-num">-</b></span>
                            <span><i class="bi bi-box-seam"></i><b id="pedidoProductos">-</b></span>
                            <span><i class="bi bi-file-earmark-text"></i><small>Factura</small><b id="pedidoFactura" class="vp-num">-</b></span>
                            <span><i class="bi bi-receipt"></i><small>Guía</small><b id="pedidoGuia" class="vp-num">-</b></span>
                        </div>
                    </div>
                </div>
                <div class="vp-oh-r">
                    <button type="button" class="vp-btn green" onclick="vpFinalizar()"><i class="bi bi-check2"></i> Finalizar validación</button>
                    <div class="vp-dd" id="vpDdMas">
                        <button type="button" class="vp-btn white" onclick="vpDD(event)"><i class="bi bi-three-dots"></i> Más acciones <i class="bi bi-chevron-down"></i></button>
                        <div class="vp-dd-menu" onclick="event.stopPropagation()">
                            <button type="button" onclick="vpAccion('historial')"><i class="bi bi-clock-history"></i> Historial del pedido</button>
                            <button type="button" onclick="vpAccion('recargar')"><i class="bi bi-arrow-repeat"></i> Recargar pedido (reinicia el avance)</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progreso de validación --}}
            <div class="vp-card d-none" id="vpProgress">
                <div class="vp-prog-top">
                    <b>Progreso de validación</b>
                    <span><b id="vpProgTxt" class="vp-num">0 / 0</b> productos</span>
                </div>
                <div class="vp-prog-row">
                    <div class="vp-bar"><div id="vpProgBar" style="width:0%;"></div></div>
                    <div class="vp-prog-pct" id="vpProgPct">0%</div>
                </div>
                <div class="vp-legend">
                    <span><i style="background:#16a34a;"></i>Completos <b id="vpLgOk">0</b></span>
                    <span><i style="background:#f59e0b;"></i>Parciales <b id="vpLgPar">0</b></span>
                    <span><i style="background:#ef4444;"></i>No enviados <b id="vpLgNo">0</b></span>
                    <span><i style="background:#94a3b8;"></i>Sin validar <b id="vpLgPen">0</b></span>
                </div>
            </div>

            {{-- Modos de validación (mismos botones ocultos; la tarjeta los activa) --}}
            <div id="modalidades" class="vp-modes d-none">
                <div class="vp-mode" role="button" tabindex="0" data-vp-btn="btnModoItem" data-vp-panel="panelItem">
                    <i class="bi bi-list-check"></i><b>Ítem por ítem</b><small>Valida uno por uno</small>
                    <button type="button" id="btnModoItem" class="vp-hide" tabindex="-1">INICIAR VALIDACIÓN</button>
                </div>
                <div class="vp-mode" role="button" tabindex="0" data-vp-btn="btnModoScanner" data-vp-panel="panelScanner">
                    <i class="bi bi-upc-scan"></i><b>Escáner</b><small>Código de producto o caja</small>
                    <button type="button" id="btnModoScanner" class="vp-hide" tabindex="-1">INICIAR ESCÁNER</button>
                </div>
                <div class="vp-mode" role="button" tabindex="0" data-vp-btn="btnModoCompleto" data-vp-panel="panelCompleto">
                    <i class="bi bi-grid"></i><b>Pedido completo</b><small>Vista de todos</small>
                    <button type="button" id="btnModoCompleto" class="vp-hide" tabindex="-1">VALIDAR PEDIDO</button>
                </div>
            </div>

{{-- =========================================================
         PANEL ITEM POR ITEM
    ========================================================== --}}
    <div
        id="panelItem"
        class="validation-panel d-none"
    >

        <div class="panel-header panel-blue">

            <div class="panel-header-left">

                <div class="panel-icon">
                    <i class="bi bi-list-check"></i>
                </div>

                <div>
                    <span>VALIDACIÓN</span>
                    <strong>ITEM POR ITEM</strong>
                </div>

            </div>


            <div class="progress-counter">

                <span id="contadorItem">
                    0 / 0
                </span>

            </div>

        </div>


        <div class="panel-body">

            <div class="item-progress">

                <div class="progress-line">

                    <div
                        id="itemProgressBar"
                        class="progress-line-fill progress-blue"
                    ></div>

                </div>

            </div>


            <div
                id="itemActual"
                class="item-validation-content"
            >

                <div class="product-main-icon">
                    <i class="bi bi-box-seam"></i>
                </div>


                <div class="product-information">

                    <span class="product-overline">
                        PRODUCTO A VALIDAR
                    </span>

                    <h2 id="itemNombre">
                        -
                    </h2>

                    <div
                        id="itemMarca"
                        class="product-brand"
                    >
                        -
                    </div>

                </div>


                <div class="product-data-grid">

                    <div class="product-data-box">

                        <span>
                            CANTIDAD DESPACHADO
                        </span>

                        <strong id="itemCantidadSolicitada">
                            0
                        </strong>

                    </div>


                    <div class="product-data-box">

                        <span>
                            CÓDIGO
                        </span>

                        <strong
                            id="itemCodigo"
                            class="product-code"
                        >
                            -
                        </strong>

                    </div>

                </div>


                {{-- CANTIDAD PARCIAL --}}
                <div
                    id="itemCantidadParcial"
                    class="partial-quantity-box d-none"
                >

                    <div>

                        <span>
                            VALIDACIÓN PARCIAL
                        </span>

                        <strong>
                            ¿Cuánto recibiste?
                        </strong>

                    </div>

                    <div class="vp-stepper"><button type="button" class="vp-step" data-step="-1" data-target="cantidadItem" title="Restar">−</button><input
                        type="number"
                        id="cantidadItem"
                        min="0"
                        step="0.01"
                        placeholder="0"
                    ><button type="button" class="vp-step" data-step="1" data-target="cantidadItem" title="Sumar">+</button></div>

                </div>


                <div class="validation-actions">

                    <button
                        type="button"
                        id="btnItemIncompleto"
                        class="validation-action action-danger"
                    >
                        <i class="bi bi-x-circle"></i>

                        <span>
                            <strong>NO ENVIADO</strong>
                            <small>No se recibió</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnItemParcial"
                        class="validation-action action-warning"
                    >
                        <i class="bi bi-dash-circle"></i>

                        <span>
                            <strong>PARCIAL</strong>
                            <small>Recibido parcialmente</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnItemCompleto"
                        class="validation-action action-success"
                    >
                        <i class="bi bi-check-circle"></i>

                        <span>
                            <strong>Marcar como validado</strong>
                            <small>Recibido completo</small>
                        </span>

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PANEL ESCÁNER
    ========================================================== --}}
    <div
        id="panelScanner"
        class="validation-panel d-none"
    >

        <div class="panel-header panel-green">

            <div class="panel-header-left">

                <div class="panel-icon">
                    <i class="bi bi-upc-scan"></i>
                </div>

                <div>
                    <span>VALIDACIÓN</span>
                    <strong>ESCÁNER</strong>
                </div>

            </div>


            <div class="progress-counter">

                <span id="contadorScanner">
                    0 / 0
                </span>

            </div>

        </div>


        <div class="panel-body scanner-body">

            <div class="scanner-instruction">

                <div class="scanner-large-icon">
                    <i class="bi bi-upc-scan"></i>
                </div>

                <h2>
                    Escanea el producto
                </h2>

                <p>
                    Utiliza el lector de códigos o escribe el código manualmente.
                </p>

            </div>


            <div class="scanner-input-wrapper">

                <i class="bi bi-upc"></i>

                <input
                    type="text"
                    id="codigoScanner"
                    placeholder="Esperando código..."
                    autocomplete="off"
                >

            </div>


            <div class="scanner-help">

                <span>
                    <i class="bi bi-check-circle"></i>
                    Código de producto
                </span>

                <span>
                    <i class="bi bi-box-seam"></i>
                    Código de caja
                </span>

            </div>


            {{-- PRODUCTO ENCONTRADO --}}
            <div
                id="scannerProducto"
                class="scanner-product-card d-none"
            >

                <div class="scanner-product-icon">
                    <i class="bi bi-box-seam"></i>
                </div>


                <div class="scanner-product-info">

                    <span>
                        PRODUCTO ENCONTRADO
                    </span>

                    <h2 id="scannerNombre">
                        -
                    </h2>

                    <p id="scannerMarca">
                        -
                    </p>

                </div>


                <div class="scanner-product-data">

                    <div>
                        <span>DESPACHADO</span>

                        <strong id="scannerSolicitado">
                            0
                        </strong>
                    </div>

                    <div>
                        <span>CÓDIGO</span>

                        <strong id="scannerCodigo">
                            -
                        </strong>
                    </div>

                </div>


                {{-- CANTIDAD PARCIAL --}}
                <div
                    id="scannerCantidadParcial"
                    class="partial-quantity-box d-none"
                >

                    <div>

                        <span>
                            VALIDACIÓN PARCIAL
                        </span>

                        <strong>
                            ¿Cuánto recibiste?
                        </strong>

                    </div>

                    <div class="vp-stepper"><button type="button" class="vp-step" data-step="-1" data-target="cantidadScanner" title="Restar">−</button><input
                        type="number"
                        id="cantidadScanner"
                        min="0"
                        step="0.01"
                        placeholder="0"
                    ><button type="button" class="vp-step" data-step="1" data-target="cantidadScanner" title="Sumar">+</button></div>

                </div>


                <div class="validation-actions">

                    <button
                        type="button"
                        id="btnScannerIncompleto"
                        class="validation-action action-danger"
                    >
                        <i class="bi bi-x-circle"></i>

                        <span>
                            <strong>NO ENVIADO</strong>
                            <small>No se recibió</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnScannerParcial"
                        class="validation-action action-warning"
                    >
                        <i class="bi bi-dash-circle"></i>

                        <span>
                            <strong>PARCIAL</strong>
                            <small>Recibido parcialmente</small>
                        </span>

                    </button>


                    <button
                        type="button"
                        id="btnScannerCompleto"
                        class="validation-action action-success"
                    >
                        <i class="bi bi-check-circle"></i>

                        <span>
                            <strong>Marcar como validado</strong>
                            <small>Recibido completo</small>
                        </span>

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PANEL PEDIDO COMPLETO
    ========================================================== --}}
    <div
        id="panelCompleto"
        class="validation-panel d-none"
    >

        <div class="panel-header panel-orange">

            <div class="panel-header-left">

                <div class="panel-icon">
                    <i class="bi bi-boxes"></i>
                </div>

                <div>
                    <span>VALIDACIÓN</span>
                    <strong>PEDIDO COMPLETO</strong>
                </div>

            </div>


            <div class="progress-counter">

                <span id="contadorCompleto">
                    0 / 0
                </span>

            </div>

        </div>


        <div class="panel-body">

            <div class="table-wrapper">

                <table class="validation-table">

                    <thead>

                        <tr>

                            <th>
                                PRODUCTO
                            </th>

                            <th>
                                CÓDIGO
                            </th>

                            <th class="text-center">
                                DESPACHADO
                            </th>

                            <th class="text-center">
                                VALIDADO
                            </th>

                            <th class="text-center">
                                ESTADO
                            </th>

                        </tr>

                    </thead>

                    <tbody id="tablaValidacion">

                    </tbody>

                </table>

            </div>


            <div class="complete-footer">

                <div class="observation-box">

                    <label for="observacionesValidacion">
                        <i class="bi bi-chat-left-text"></i>
                        OBSERVACIONES
                    </label>

                    <textarea
                        id="observacionesValidacion"
                        rows="3"
                        placeholder="Agrega una observación si es necesario..."
                    ></textarea>

                </div>


                <button
                    type="button"
                    id="btnGuardarValidacion"
                    class="save-validation-button"
                >
                    <i class="bi bi-check-circle"></i>

                    <span>
                        GUARDAR VALIDACIÓN
                    </span>
                </button>

            </div>

        </div>

    </div>

            {{-- Observaciones (refleja el campo original #observacionesValidacion) --}}
            <div class="vp-card vp-obs d-none" id="vpObsCard">
                <h4><span><i class="bi bi-chat-left-text"></i> Observaciones del pedido</span><span>Se envían al guardar la validación</span></h4>
                <textarea id="vpObs" placeholder="Agrega una observación general sobre esta validación..."></textarea>
            </div>

        </main>

        {{-- ───────────── DERECHA: productos del pedido ───────────── --}}
        <aside class="vp-right vp-card">
            <h4><span>Productos del pedido <span class="vp-num" id="vpItemsCount">(0)</span></span></h4>
            <div class="vp-items" id="vpItems">
                <div class="vp-lempty">Carga un pedido para ver sus productos.</div>
            </div>
        </aside>

    </div>

<div class="validation-orders-section" id="vpHistorial">

    {{-- =====================================================
         PEDIDOS PENDIENTES
    ====================================================== --}}
    <div class="validation-list-card">

        <div class="validation-list-header">

            <div class="validation-list-title">

                <div class="validation-list-icon pending">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div>
                    <strong>Pedidos pendientes de validar</strong>
                    <span>
                        Pedidos que todavía no tienen ninguna validación registrada.
                    </span>
                </div>

            </div>

            <span class="validation-count">
                {{ $pendientes->count() }}
            </span>

        </div>

        @if($pendientes->count())

            <div class="validation-table-wrapper">

                <table class="validation-list-table">

                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Guía</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pendientes as $pedido)

                            <tr>

                                <td>
                                    <span class="validation-order-number">
                                        {{ $pedido->numero_orden ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="validation-client-name">
                                        {{ $pedido->client->razon_social
                                            ?? $pedido->client->nombre_comercial
                                            ?? 'Sin cliente' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $pedido->factura_asociada ?? '-' }}
                                </td>

                                <td>
                                    {{ $pedido->guia_asociada ?? '-' }}
                                </td>

                                <td>
                                    {{ $pedido->fecha_pedido
                                        ? \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y')
                                        : '-' }}
                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="validation-row-button open"
                                        onclick="abrirPedidoDesdeLista({{ $pedido->id }})"
                                    >
                                        <i class="bi bi-play-fill"></i>
                                        VALIDAR
                                    </button>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="validation-empty">

                <i class="bi bi-check-circle"></i>

                <strong>No hay pedidos pendientes</strong>

                <div>
                    Todos los pedidos registrados ya tienen una validación.
                </div>

            </div>

        @endif

    </div>


    {{-- =====================================================
         HISTORIAL
    ====================================================== --}}
    <div class="validation-list-card">

        <div class="validation-list-header">

            <div class="validation-list-title">

                <div class="validation-list-icon history">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>
                    <strong>Historial de validaciones</strong>
                    <span>
                        Registro de todas las validaciones realizadas.
                    </span>
                </div>

            </div>

            <div class="validation-history-header-right"><span class="validation-count">{{ $historial->total() }}</span></div>

        </div>

        @if($historial->total() > 0)

    {{-- =====================================================
         FILTROS DEL HISTORIAL
    ====================================================== --}}
    <form
        method="GET"
        action="{{ route('orders.validation.index') }}"
        class="validation-history-filters"
    >

        <div class="validation-history-filter-group">

            <label for="historialFechaDesde">
                <i class="bi bi-calendar3"></i>
                DESDE
            </label>

            <input
                type="date"
                id="historialFechaDesde"
                name="fecha_desde"
                value="{{ request('fecha_desde') }}"
            >

        </div>


        <div class="validation-history-filter-group">

            <label for="historialFechaHasta">
                <i class="bi bi-calendar3"></i>
                HASTA
            </label>

            <input
                type="date"
                id="historialFechaHasta"
                name="fecha_hasta"
                value="{{ request('fecha_hasta') }}"
            >

        </div>


        <button
            type="submit"
            class="validation-history-filter-button"
        >
            <i class="bi bi-funnel"></i>
            FILTRAR
        </button>


        @if(request('fecha_desde') || request('fecha_hasta'))

            <a
                href="{{ route('orders.validation.index') }}"
                class="validation-history-clear-button"
            >
                <i class="bi bi-x-circle"></i>
                LIMPIAR
            </a>

        @endif

    </form>

            <div class="validation-table-wrapper">

                <table class="validation-list-table">

                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Fecha validación</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($historial as $validacion)

                            @php
                                $pedidoHistorial = $validacion->order;
                                $estadoHistorial = $validacion->estado;
                            @endphp

                           <tr
                                    class="historial-row"
                                    data-fecha="{{ $validacion->fecha_validacion ? \Carbon\Carbon::parse($validacion->fecha_validacion)->format('Y-m-d') : '' }}"
                                >

                                <td>
                                    <span class="validation-order-number">
                                        {{ $pedidoHistorial->numero_orden ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="validation-client-name">
                                        {{ $pedidoHistorial->client->razon_social
                                            ?? $pedidoHistorial->client->nombre_comercial
                                            ?? 'Sin cliente' }}
                                    </span>
                                </td>

                                <td>

                                    <span class="validation-status
                                        {{ strtolower(str_replace('_', '-', $estadoHistorial)) }}"
                                    >
                                        {{ $estadoHistorial }}
                                    </span>

                                </td>

                                <td>
                                    {{ $validacion->fecha_validacion
                                        ? \Carbon\Carbon::parse($validacion->fecha_validacion)->format('d/m/Y H:i')
                                        : '-' }}
                                </td>

                                <td>
                                    {{ $validacion->usuario->name ?? 'Sistema' }}
                                </td>

                                <td>

                                    <div class="validation-row-actions">

                                        <button
                                            type="button"
                                            class="validation-row-button history"
                                            onclick="verHistorialPedido({{ $pedidoHistorial->id }})"
                                        >
                                            <i class="bi bi-clock-history"></i>
                                            HISTORIAL
                                        </button>

                                        <button
                                            type="button"
                                            class="validation-row-button revalidate"
                                            onclick="abrirPedidoDesdeLista({{ $pedidoHistorial->id }})"
                                        >
                                            <i class="bi bi-arrow-repeat"></i>
                                            REVALIDAR
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
@if($historial->total() > 0)

    <div class="historial-paginacion">

        <div class="historial-info">
            Mostrando
            <strong>{{ $historial->firstItem() }}</strong>
            -
            <strong>{{ $historial->lastItem() }}</strong>
            de
            <strong>{{ $historial->total() }}</strong>
            validaciones
        </div>

        @if($historial->hasPages())
            <div class="pagination-buttons">

                @if($historial->onFirstPage())
                    <span class="pagina disabled">‹</span>
                @else
                    <a href="{{ $historial->previousPageUrl() }}" class="pagina">
                        ‹
                    </a>
                @endif

                @foreach($historial->getUrlRange(
                    max(1, $historial->currentPage() - 2),
                    min($historial->lastPage(), $historial->currentPage() + 2)
                ) as $page => $url)

                    @if($page == $historial->currentPage())
                        <span class="pagina activa">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagina">
                            {{ $page }}
                        </a>
                    @endif

                @endforeach

                @if($historial->hasMorePages())
                    <a href="{{ $historial->nextPageUrl() }}" class="pagina">
                        ›
                    </a>
                @else
                    <span class="pagina disabled">›</span>
                @endif

            </div>
        @endif

    </div>

@endif
            </div>

        @else

            <div class="validation-empty">

                <i class="bi bi-clock-history"></i>

                <strong>Sin historial</strong>

                <div>
                    Todavía no se ha realizado ninguna validación.
                </div>

            </div>

        @endif

    </div>

</div>

{{-- =========================================================
     MODAL HISTORIAL
========================================================= --}}
<div
    id="validationHistoryModal"
    class="validation-history-modal d-none"
>

    <div class="validation-history-dialog">

        <div class="validation-history-dialog-header">

            <strong id="validationHistoryTitle">
                Historial del pedido
            </strong>

            <button
                type="button"
                class="validation-history-close"
                onclick="cerrarHistorialPedido()"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

        <div
            id="validationHistoryBody"
            class="validation-history-dialog-body"
        >

            <div class="validation-empty">
                <i class="bi bi-arrow-repeat"></i>
                Cargando historial...
            </div>

        </div>

    </div>

</div>

<div
        id="alertaValidacion"
        class="validation-alert d-none"
    ></div>
</div>

{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | VARIABLES
    |--------------------------------------------------------------------------
    */

    let pedidoActual = null;

    let detalles = [];

    let indiceItem = 0;

    let validaciones = {};

    let itemScannerActual = null;

    let modoActual = null;

    // Estado compartido de solo lectura para los componentes visuales nuevos.
    window.__valPedido = {
        get pedido() { return pedidoActual; },
        get detalles() { return detalles; },
        get validaciones() { return validaciones; },
        get indice() { return indiceItem; },
        get modo() { return modoActual; }
    };

        /*
    |--------------------------------------------------------------------------
    | PEDIDOS PENDIENTES / HISTORIAL
    |--------------------------------------------------------------------------
    */

   window.abrirPedidoDesdeLista = async function (orderId) {

    if (!orderId) {

        mostrarAlerta(
            'No se pudo identificar el pedido.',
            'danger'
        );

        return;
    }

    ocultarAlerta();

    try {

        const response = await fetch(
            `/validacion-pedidos/${orderId}/datos`,
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        const data = await response.json();

        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'No se pudo cargar el pedido.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CARGAR PEDIDO
        |--------------------------------------------------------------------------
        */

        pedidoActual = data.order;

        detalles =
            pedidoActual.details || [];

        validaciones = {};

        indiceItem = 0;

        itemScannerActual = null;

        modoActual = null;


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR PRODUCTOS
        |--------------------------------------------------------------------------
        */

        if (!detalles.length) {

            throw new Error(
                'El pedido no tiene productos.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR INFORMACIÓN
        |--------------------------------------------------------------------------
        */

        mostrarInformacionPedido();

        modalidades.classList.remove(
            'd-none'
        );

        ocultarPaneles();


        /*
        |--------------------------------------------------------------------------
        | LIMPIAR BUSCADOR
        |--------------------------------------------------------------------------
        */

        codigoPedido.value =
            pedidoActual.factura_asociada ||
            pedidoActual.guia_asociada ||
            '';


        /*
        |--------------------------------------------------------------------------
        | IR AL PEDIDO
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            'pedidoInfo'
        ).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });


    } catch (error) {

        mostrarAlerta(
            error.message,
            'danger'
        );

    }

};


    window.cerrarHistorialPedido = function () {

        const modal =
            document.getElementById('validationHistoryModal');

        if (modal) {
            modal.classList.add('d-none');
        }
    };


    window.verHistorialPedido = async function (orderId) {

        const modal =
            document.getElementById('validationHistoryModal');

        const body =
            document.getElementById('validationHistoryBody');

        const title =
            document.getElementById('validationHistoryTitle');

        modal.classList.remove('d-none');

        body.innerHTML = `
            <div class="validation-empty">
                <i class="bi bi-arrow-repeat"></i>
                Cargando historial...
            </div>
        `;

        try {

            const response = await fetch(
                `/validacion-pedidos/${orderId}/historial`,
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(
                    data.message ||
                    'No se pudo obtener el historial.'
                );
            }

            const validaciones =
                data.validations || [];

            if (!validaciones.length) {

                body.innerHTML = `
                    <div class="validation-empty">
                        <i class="bi bi-clock-history"></i>
                        No existen validaciones para este pedido.
                    </div>
                `;

                return;
            }

            const primera =
                validaciones[0];

            const order =
                primera.order ||
                primera.order_detail?.order ||
                null;

            title.textContent =
                `Historial del pedido ${
                    order?.numero_orden || ''
                }`;

            let html = '';

            validaciones.forEach(function (validacion, index) {

                const estado =
                    validacion.estado || 'PENDIENTE';

                const estadoClase =
                    estado
                        .toLowerCase()
                        .replaceAll('_', '-');

                const fecha =
                    validacion.fecha_validacion
                        ? new Date(
                            validacion.fecha_validacion
                          ).toLocaleString('es-PE')
                        : '-';

                const usuario =
                    validacion.usuario?.name ||
                    'Sistema';

                html += `

                    <div
                        style="
                            border:1px solid #e2e8f0;
                            border-radius:12px;
                            margin-bottom:16px;
                            overflow:hidden;
                        "
                    >

                        <div
                            style="
                                padding:14px 16px;
                                background:#f8fafc;
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                gap:10px;
                            "
                        >

                            <div>

                                <strong style="
                                    display:block;
                                    color:#0f172a;
                                    font-size:14px;
                                ">
                                    Validación #${validaciones.length - index}
                                </strong>

                                <span style="
                                    display:block;
                                    margin-top:3px;
                                    color:#64748b;
                                    font-size:11px;
                                ">
                                    ${fecha} · ${usuario}
                                </span>

                            </div>

                            <span class="
                                validation-status
                                ${estadoClase}
                            ">
                                ${estado}
                            </span>

                        </div>

                        <div style="overflow-x:auto;">

                            <table class="validation-list-table">

                                <thead>

                                    <tr>
                                        <th>Producto</th>
                                        <th>Solicitado</th>
                                        <th>Validado</th>
                                        <th>Estado</th>
                                        <th>Código</th>
                                    </tr>

                                </thead>

                                <tbody>
                `;

                const detallesValidacion =
                    validacion.details || [];

                detallesValidacion.forEach(function (detalle) {

                    const producto =
                        detalle.order_detail?.product;

                    const nombreProducto =
                        producto?.nombre ||
                        'Producto';

                    const estadoDetalle =
                        detalle.estado ||
                        'PENDIENTE';

                    const claseDetalle =
                        estadoDetalle
                            .toLowerCase()
                            .replaceAll('_', '-');

                    html += `

                        <tr>

                            <td>
                                <strong>
                                    ${nombreProducto}
                                </strong>
                            </td>

                            <td>
                                ${detalle.cantidad_despachada ?? 0}
                            </td>

                            <td>
                                ${detalle.cantidad_validada ?? 0}
                            </td>

                            <td>

                                <span class="
                                    validation-status
                                    ${claseDetalle}
                                ">
                                    ${estadoDetalle}
                                </span>

                            </td>

                            <td>
                                ${detalle.codigo_escaneado || '-'}
                            </td>

                        </tr>

                    `;

                });

                html += `

                                </tbody>

                            </table>

                        </div>

                    </div>

                `;

            });

            body.innerHTML = html;

        } catch (error) {

            body.innerHTML = `

                <div class="validation-empty">

                    <i class="bi bi-exclamation-triangle"></i>

                    ${error.message}

                </div>

            `;

        }

    };


    /*
    |--------------------------------------------------------------------------
    | CERRAR MODAL CON ESCAPE / CLICK EXTERIOR
    |--------------------------------------------------------------------------
    */

    const historyModal =
        document.getElementById(
            'validationHistoryModal'
        );

    if (historyModal) {

        historyModal.addEventListener(
            'click',
            function (event) {

                if (event.target === historyModal) {
                    cerrarHistorialPedido();
                }

            }
        );

    }

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                historyModal &&
                !historyModal.classList.contains('d-none')
            ) {

                cerrarHistorialPedido();

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const codigoPedido =
        document.getElementById('codigoPedido');

    const btnBuscarPedido =
        document.getElementById('btnBuscarPedido');

    const pedidoInfo =
        document.getElementById('pedidoInfo');

    const modalidades =
        document.getElementById('modalidades');

    const panelItem =
        document.getElementById('panelItem');

    const panelScanner =
        document.getElementById('panelScanner');

    const panelCompleto =
        document.getElementById('panelCompleto');

    const alerta =
        document.getElementById('alertaValidacion');


    /*
    |--------------------------------------------------------------------------
    | ALERTAS
    |--------------------------------------------------------------------------
    */

    function mostrarAlerta(mensaje, tipo = 'danger') {

        alerta.className =
            `validation-alert alert-${tipo}`;

        alerta.textContent =
            mensaje;

        alerta.classList.remove('d-none');

        setTimeout(function () {

            alerta.classList.add('d-none');

        }, 4500);

    }


    function ocultarAlerta() {

        alerta.classList.add('d-none');

    }


    /*
    |--------------------------------------------------------------------------
    | OCULTAR PANELES
    |--------------------------------------------------------------------------
    */

    function ocultarPaneles() {

        panelItem.classList.add('d-none');

        panelScanner.classList.add('d-none');

        panelCompleto.classList.add('d-none');

    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR PEDIDO
    |--------------------------------------------------------------------------
    */

    async function buscarPedido() {

        const codigo =
            codigoPedido.value.trim();

        if (!codigo) {

            mostrarAlerta(
                'Ingresa una factura o guía.',
                'warning'
            );

            codigoPedido.focus();

            return;
        }

        ocultarAlerta();

        btnBuscarPedido.disabled = true;

        btnBuscarPedido.innerHTML =
            '<i class="bi bi-arrow-repeat"></i> BUSCANDO...';

        try {

            const response =
                await fetch(
                    '{{ route("orders.validation.buscar") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            codigo: codigo
                        })
                    }
                );


            const data =
                await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'No se encontró el pedido.'
                );

            }


            pedidoActual =
                data.order;

            detalles =
                pedidoActual.details || [];

            validaciones = {};

            indiceItem = 0;

            itemScannerActual = null;


            if (!detalles.length) {

                throw new Error(
                    'El pedido no tiene productos.'
                );

            }


            mostrarInformacionPedido();

            modalidades.classList.remove('d-none');

            ocultarPaneles();

            document.getElementById(
                'modalidades'
            ).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        } catch (error) {

            mostrarAlerta(
                error.message,
                'danger'
            );

        } finally {

            btnBuscarPedido.disabled = false;

            btnBuscarPedido.innerHTML =
                '<i class="bi bi-search"></i><span>BUSCAR PEDIDO</span>';

        }

    }


    btnBuscarPedido.addEventListener(
        'click',
        buscarPedido
    );


    codigoPedido.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Enter') {

                event.preventDefault();

                buscarPedido();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INFORMACIÓN PEDIDO
    |--------------------------------------------------------------------------
    */

    function mostrarInformacionPedido() {

        document.getElementById(
            'pedidoNumero'
        ).textContent =
            pedidoActual.numero_orden || '-';


        document.getElementById(
            'pedidoCliente'
        ).textContent =
            pedidoActual.client?.razon_social ||
            pedidoActual.client?.nombre_comercial ||
            '-';


        document.getElementById(
            'pedidoFactura'
        ).textContent =
            pedidoActual.factura_asociada || '-';


        document.getElementById(
            'pedidoGuia'
        ).textContent =
            pedidoActual.guia_asociada || '-';


        pedidoInfo.classList.remove(
            'd-none'
        );

        const fechaPedido = document.getElementById('pedidoFecha');
        if (fechaPedido) {
            const fechaRaw = pedidoActual.fecha_pedido || pedidoActual.created_at || '';
            if (fechaRaw) {
                const fecha = new Date(String(fechaRaw).slice(0, 10) + 'T00:00:00');
                fechaPedido.textContent = Number.isNaN(fecha.getTime())
                    ? String(fechaRaw).slice(0, 10)
                    : fecha.toLocaleDateString('es-PE');
            } else {
                fechaPedido.textContent = '-';
            }
        }

        const pedidoProductos = document.getElementById('pedidoProductos');
        if (pedidoProductos) pedidoProductos.textContent = `${detalles.length} productos`;

        const vpEstado = document.getElementById('vpEstado');
        if (vpEstado) vpEstado.textContent = 'En revisión';

        const vpEmpty = document.getElementById('vpEmpty');
        if (vpEmpty) vpEmpty.classList.add('d-none');

        if (typeof actualizarVpResumen === 'function') actualizarVpResumen();

    }


    /*
    |--------------------------------------------------------------------------
    | MODO ITEM POR ITEM
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnModoItem'
    ).addEventListener(
        'click',
        function () {

            modoActual = 'item';

            indiceItem = 0;

            validaciones = {};

            ocultarPaneles();

            panelItem.classList.remove(
                'd-none'
            );

            mostrarItemActual();

            panelItem.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }
    );


    function mostrarItemActual() {

        if (indiceItem >= detalles.length) {

            finalizarValidacionItem();

            return;
        }


        const detail =
            detalles[indiceItem];

        const product =
            detail.product || {};


        document.getElementById(
            'contadorItem'
        ).textContent =
            `${indiceItem + 1} / ${detalles.length}`;


        /*
         * Barra de progreso.
         */
        const progress =
            (
                indiceItem /
                detalles.length
            ) * 100;


        document.getElementById(
            'itemProgressBar'
        ).style.width =
            `${progress}%`;


        document.getElementById(
            'itemNombre'
        ).textContent =
            product.nombre ||
            'Producto sin nombre';


        document.getElementById(
            'itemMarca'
        ).textContent =
            product.marca ||
            '';


        document.getElementById(
            'itemCantidadSolicitada'
        ).textContent =
            detail.cantidad_despachada ??
            0;


        document.getElementById(
            'itemCodigo'
        ).textContent =
            product.barcode ||
            product.box_barcode ||
            '-';


        document.getElementById(
            'itemCantidadParcial'
        ).classList.add(
            'd-none'
        );


        document.getElementById(
            'cantidadItem'
        ).value = '';


        ocultarAlerta();

    }


    /*
    |--------------------------------------------------------------------------
    | REGISTRAR ITEM
    |--------------------------------------------------------------------------
    */

    function registrarItem(
        estado,
        cantidad = 0
    ) {

        const detail =
            detalles[indiceItem];


        validaciones[detail.id] = {

            order_detail_id:
                detail.id,

            estado:
                estado,

            cantidad_validada:
                cantidad,

            codigo_escaneado:
                null,

            observaciones:
                null

        };


        indiceItem++;

        mostrarItemActual();

    }


    /*
    |--------------------------------------------------------------------------
    | ITEM - NO ENVIADO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnItemIncompleto'
    ).addEventListener(
        'click',
        function () {

            registrarItem(
                'NO_ENVIADO',
                0
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ITEM - PARCIAL
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnItemParcial'
    ).addEventListener(
        'click',
        function () {

            const detail =
                detalles[indiceItem];

            const panelCantidad =
                document.getElementById(
                    'itemCantidadParcial'
                );

            const cantidadInput =
                document.getElementById(
                    'cantidadItem'
                );


            if (
                panelCantidad.classList.contains(
                    'd-none'
                )
            ) {

                panelCantidad.classList.remove(
                    'd-none'
                );

                cantidadInput.value = '';

                cantidadInput.focus();

                return;

            }


            const cantidad =
                parseFloat(
                    cantidadInput.value
                );


            if (
                isNaN(cantidad) ||
                cantidad <= 0
            ) {

                mostrarAlerta(
                    'Ingresa una cantidad válida.',
                    'warning'
                );

                cantidadInput.focus();

                return;

            }


            if (
                cantidad >=
                parseFloat(
                    detail.cantidad_despachada
                )
            ) {

                mostrarAlerta(
                    'La cantidad parcial debe ser menor que la cantidad despachada.',
                    'warning'
                );

                cantidadInput.focus();

                return;

            }


            ocultarAlerta();


            registrarItem(
                'PARCIAL',
                cantidad
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ITEM - COMPLETO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnItemCompleto'
    ).addEventListener(
        'click',
        function () {

            registrarItem(
                'COMPLETO',
                parseFloat(
                    detalles[indiceItem]
                        .cantidad_despachada
                )
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FINALIZAR ITEM
    |--------------------------------------------------------------------------
    */

    function finalizarValidacionItem() {

        document.getElementById(
            'itemProgressBar'
        ).style.width = '100%';


        ocultarPaneles();

        panelCompleto.classList.remove(
            'd-none'
        );

        construirTablaCompleta();

        mostrarAlerta(
            'Todos los productos fueron revisados. Verifica la información antes de guardar.',
            'success'
        );

        panelCompleto.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    }


    /*
    |--------------------------------------------------------------------------
    | MODO ESCÁNER
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnModoScanner'
    ).addEventListener(
        'click',
        function () {

            modoActual = 'scanner';

            validaciones = {};

            itemScannerActual = null;

            ocultarPaneles();

            panelScanner.classList.remove(
                'd-none'
            );


            document.getElementById(
                'scannerProducto'
            ).classList.add(
                'd-none'
            );


            document.getElementById(
                'codigoScanner'
            ).value = '';


            actualizarContadorScanner();


            panelScanner.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });


            setTimeout(function () {

                document.getElementById(
                    'codigoScanner'
                ).focus();

            }, 350);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER
    |--------------------------------------------------------------------------
    */

    const codigoScanner =
        document.getElementById(
            'codigoScanner'
        );


    codigoScanner.addEventListener(
        'keydown',
        async function (event) {

            if (
                event.key !== 'Enter'
            ) {

                return;

            }


            event.preventDefault();


            const codigo =
                codigoScanner.value.trim();


            if (!codigo) {

                return;

            }


            await procesarScanner(
                codigo
            );

        }
    );


    async function procesarScanner(
        codigo
    ) {

        ocultarAlerta();


        try {

            const response =
                await fetch(
                    '{{ route("orders.validation.producto.buscar") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            codigo: codigo
                        })
                    }
                );


            const data =
                await response.json();


            if (
                !response.ok ||
                !data.success
            ) {

                throw new Error(
                    data.message ||
                    'Producto no encontrado.'
                );

            }


            const product =
                data.product;


            /*
             * Verificar que el producto
             * pertenece al pedido.
             */
            const encontrados =
                detalles.filter(
                    detail =>
                        detail.product &&
                        (
                            String(
                                detail.product.barcode
                            ) === String(codigo)

                            ||

                            String(
                                detail.product.box_barcode
                            ) === String(codigo)
                        )
                );


            if (
                !encontrados.length
            ) {

                mostrarAlerta(
                    '⚠️ Este producto no pertenece al pedido.',
                    'warning'
                );


                codigoScanner.value = '';

                codigoScanner.focus();

                return;

            }


            /*
             * Buscar un detalle que todavía
             * no haya sido validado.
             */
            const detail =
                encontrados.find(
                    d =>
                        !validaciones[d.id]
                ) ||
                encontrados[0];


            itemScannerActual =
                detail;


            document.getElementById(
                'scannerNombre'
            ).textContent =
                product.nombre ||
                'Producto sin nombre';


            document.getElementById(
                'scannerMarca'
            ).textContent =
                product.marca ||
                '';


            document.getElementById(
                'scannerSolicitado'
            ).textContent =
                detail.cantidad_despachada ??
                0;


            document.getElementById(
                'scannerCodigo'
            ).textContent =
                codigo;


            document.getElementById(
                'scannerProducto'
            ).classList.remove(
                'd-none'
            );


            document.getElementById(
                'scannerCantidadParcial'
            ).classList.add(
                'd-none'
            );


            document.getElementById(
                'cantidadScanner'
            ).value = '';


            codigoScanner.value = '';


        } catch (error) {

            mostrarAlerta(
                error.message,
                'danger'
            );


            codigoScanner.select();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | REGISTRAR ESCÁNER
    |--------------------------------------------------------------------------
    */

    function registrarScanner(
        estado,
        cantidad = 0
    ) {

        if (!itemScannerActual) {

            mostrarAlerta(
                'Primero escanea un producto.',
                'warning'
            );

            return;

        }


        validaciones[
            itemScannerActual.id
        ] = {

            order_detail_id:
                itemScannerActual.id,

            estado:
                estado,

            cantidad_validada:
                cantidad,

            codigo_escaneado:
                document.getElementById(
                    'scannerCodigo'
                ).textContent,

            observaciones:
                null

        };


        itemScannerActual =
            null;


        document.getElementById(
            'scannerProducto'
        ).classList.add(
            'd-none'
        );


        actualizarContadorScanner();


        codigoScanner.value = '';

        codigoScanner.focus();


        if (
            Object.keys(validaciones).length >=
            detalles.length
        ) {

            finalizarScanner();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER - NO ENVIADO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnScannerIncompleto'
    ).addEventListener(
        'click',
        function () {

            registrarScanner(
                'NO_ENVIADO',
                0
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER - PARCIAL
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnScannerParcial'
    ).addEventListener(
        'click',
        function () {

            if (
                !itemScannerActual
            ) {

                return;

            }


            const panelCantidad =
                document.getElementById(
                    'scannerCantidadParcial'
                );


            if (
                panelCantidad.classList.contains(
                    'd-none'
                )
            ) {

                panelCantidad.classList.remove(
                    'd-none'
                );


                document.getElementById(
                    'cantidadScanner'
                ).focus();


                return;

            }


            const cantidad =
                parseFloat(
                    document.getElementById(
                        'cantidadScanner'
                    ).value
                );


            const despachada =
            parseFloat(
                itemScannerActual
                    .cantidad_despachada
            );


            if (
                isNaN(cantidad) ||
                cantidad <= 0 ||
                cantidad >= despachada
            ) {

                mostrarAlerta(
                    'La cantidad parcial debe ser mayor a 0 y menor a la cantidad despachada.',
                    'warning'
                );

                return;

            }


            registrarScanner(
                'PARCIAL',
                cantidad
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCÁNER - COMPLETO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnScannerCompleto'
    ).addEventListener(
        'click',
        function () {

            if (
                !itemScannerActual
            ) {

                return;

            }


            registrarScanner(
                'COMPLETO',
                parseFloat(
                    itemScannerActual
                        .cantidad_despachada
                )
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CONTADOR ESCÁNER
    |--------------------------------------------------------------------------
    */

    function actualizarContadorScanner() {

        document.getElementById(
            'contadorScanner'
        ).textContent =
            `${Object.keys(validaciones).length} / ${detalles.length}`;

    }


    /*
    |--------------------------------------------------------------------------
    | FINALIZAR ESCÁNER
    |--------------------------------------------------------------------------
    */

    function finalizarScanner() {

        ocultarPaneles();

        panelCompleto.classList.remove(
            'd-none'
        );

        construirTablaCompleta();

        mostrarAlerta(
            'Todos los productos fueron procesados por escáner. Revisa y guarda la validación.',
            'success'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODO PEDIDO COMPLETO
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnModoCompleto'
    ).addEventListener(
        'click',
        function () {

            modoActual = 'completo';

            validaciones = {};

            ocultarPaneles();

            panelCompleto.classList.remove(
                'd-none'
            );

            construirTablaCompleta();


            panelCompleto.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TABLA COMPLETA
    |--------------------------------------------------------------------------
    */

    function construirTablaCompleta() {

        const tabla =
            document.getElementById(
                'tablaValidacion'
            );


        tabla.innerHTML = '';


        detalles.forEach(
            function (detail) {

                const product =
                    detail.product || {};


                const validacion =
                    validaciones[detail.id];


                let estado =
                    validacion?.estado ||
                    'PENDIENTE';


                let cantidad =
                    validacion?.cantidad_validada ??
                    0;


                const tr =
                    document.createElement(
                        'tr'
                    );


                tr.dataset.detailId =
                    detail.id;


                tr.innerHTML = `

                    <td>

                        <div class="table-product-name">

                            ${escapeHtml(
                                product.nombre ||
                                'Producto sin nombre'
                            )}

                        </div>

                        <div class="table-product-brand">

                            ${escapeHtml(
                                product.marca ||
                                ''
                            )}

                        </div>

                    </td>


                    <td>

                        <span class="table-code">

                            ${escapeHtml(
                                product.barcode ||
                                product.box_barcode ||
                                '-'
                            )}

                        </span>

                    </td>


                    <td class="text-center">

                        <span class="table-quantity">

                            ${detail.cantidad_despachada}

                        </span>

                    </td>


                    <td class="text-center">

                        <input
                            type="number"
                            class="cantidad-validada"
                            data-detail-id="${detail.id}"
                            value="${cantidad}"
                            min="0"
                            step="0.01"
                        >

                    </td>


                    <td class="text-center">

                        <select
                            class="estado-validacion"
                            data-detail-id="${detail.id}"
                        >

                            <option
                                value="PENDIENTE"
                                ${estado === 'PENDIENTE' ? 'selected' : ''}
                            >
                                PENDIENTE
                            </option>

                            <option
                                value="COMPLETO"
                                ${estado === 'COMPLETO' ? 'selected' : ''}
                            >
                                COMPLETO
                            </option>

                            <option
                                value="PARCIAL"
                                ${estado === 'PARCIAL' ? 'selected' : ''}
                            >
                                PARCIAL
                            </option>

                            <option
                                value="NO_ENVIADO"
                                ${estado === 'NO_ENVIADO' ? 'selected' : ''}
                            >
                                NO ENVIADO
                            </option>

                        </select>

                    </td>

                `;


                tabla.appendChild(
                    tr
                );

            }
        );


        /*
         * Eventos estado.
         */
        tabla
            .querySelectorAll(
                '.estado-validacion'
            )
            .forEach(
                select => {

                    select.addEventListener(
                        'change',
                        function () {

                            actualizarValidacionTabla(
                                this.dataset.detailId
                            );

                        }
                    );

                }
            );


        /*
         * Eventos cantidad.
         */
        tabla
            .querySelectorAll(
                '.cantidad-validada'
            )
            .forEach(
                input => {

                    input.addEventListener(
                        'change',
                        function () {

                            actualizarValidacionTabla(
                                this.dataset.detailId
                            );

                        }
                    );

                }
            );


        actualizarContadorCompleto();

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR FILA
    |--------------------------------------------------------------------------
    */

    function actualizarValidacionTabla(
        detailId
    ) {

        const select =
            document.querySelector(
                `.estado-validacion[data-detail-id="${detailId}"]`
            );


        const input =
            document.querySelector(
                `.cantidad-validada[data-detail-id="${detailId}"]`
            );


        if (
            !select ||
            !input
        ) {

            return;

        }


        const detail =
            detalles.find(
                d =>
                    String(d.id) ===
                    String(detailId)
            );


        if (!detail) {

            return;

        }


        const estado =
            select.value;


        if (
            estado === 'COMPLETO'
        ) {

            input.value =
                detail.cantidad_despachada;

        }


        if (
            estado === 'NO_ENVIADO'
        ) {

            input.value = 0;

        }


        validaciones[detailId] = {

            order_detail_id:
                parseInt(detailId),

            estado:
                estado,

            cantidad_validada:
                parseFloat(
                    input.value
                ) || 0,

            codigo_escaneado:
                null,

            observaciones:
                null

        };


        actualizarContadorCompleto();

    }


    /*
    |--------------------------------------------------------------------------
    | CONTADOR PEDIDO COMPLETO
    |--------------------------------------------------------------------------
    */

    function actualizarContadorCompleto() {

        document.getElementById(
            'contadorCompleto'
        ).textContent =
            `${Object.keys(validaciones).length} / ${detalles.length}`;

    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'btnGuardarValidacion'
    ).addEventListener(
        'click',
        async function () {

            /*
             * Actualizar todos los productos
             * visibles en la tabla.
             */
            detalles.forEach(
                detail => {

                    actualizarValidacionTabla(
                        detail.id
                    );

                }
            );


            /*
             * Todos deben estar definidos.
             */
            if (
                Object.keys(validaciones).length !==
                detalles.length
            ) {

                mostrarAlerta(
                    'Debes validar todos los productos antes de guardar.',
                    'warning'
                );

                return;

            }


            /*
             * Validar cantidades.
             */
            for (
                const detail of detalles
            ) {

                const validation =
                    validaciones[
                        detail.id
                    ];


                if (!validation) {

                    continue;

                }


                const despachada =
                    parseFloat(
                        detail.cantidad_despachada
                    );


                const cantidad =
                    parseFloat(
                        validation.cantidad_validada
                    ) || 0;


                /*
                 * COMPLETO.
                 */
                if (
                    validation.estado ===
                    'COMPLETO' &&
                    cantidad < despachada
                ) {

                    mostrarAlerta(
                        `El producto "${detail.product?.nombre || ''}" está marcado como COMPLETO pero la cantidad validada es menor a la despachada.`,
                        'warning'
                    );

                    return;

                }


                /*
                 * PARCIAL.
                 */
                if (
                    validation.estado ===
                    'PARCIAL' &&
                    (
                        cantidad <= 0 ||
                        cantidad >= despachada
                    )
                ) {

                    mostrarAlerta(
                        `La cantidad parcial de "${detail.product?.nombre || ''}" no es válida.`,
                        'warning'
                    );

                    return;

                }


                /*
                 * NO ENVIADO.
                 */
                if (
                    validation.estado ===
                    'NO_ENVIADO' &&
                    cantidad !== 0
                ) {

                    mostrarAlerta(
                        `El producto "${detail.product?.nombre || ''}" está marcado como NO ENVIADO y debe tener cantidad 0.`,
                        'warning'
                    );

                    return;

                }


                /*
                 * PENDIENTE.
                 */
                if (
                    validation.estado ===
                    'PENDIENTE'
                ) {

                    mostrarAlerta(
                        `El producto "${detail.product?.nombre || ''}" todavía está pendiente de validar.`,
                        'warning'
                    );

                    return;

                }

            }


            const boton =
                document.getElementById(
                    'btnGuardarValidacion'
                );


            boton.disabled = true;


            boton.innerHTML =
                '<i class="bi bi-arrow-repeat"></i> GUARDANDO...';


            try {

                const response =
                    await fetch(
                        '{{ url("validacion-pedidos") }}/' +
                        pedidoActual.id +
                        '/guardar',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({

                                items:
                                    Object.values(
                                        validaciones
                                    ),

                                observaciones:
                                    document.getElementById(
                                        'observacionesValidacion'
                                    ).value

                            })

                        }
                    );


                const data =
                    await response.json();


                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        'No se pudo guardar la validación.'
                    );

                }


                mostrarAlerta(
                    '✓ Validación guardada correctamente.',
                    'success'
                );
                setTimeout(function () {
                    window.location.reload();
                }, 1000);

                boton.disabled = false;


                boton.innerHTML =
                    '<i class="bi bi-check-circle"></i><span>GUARDAR VALIDACIÓN</span>';


            } catch (error) {

                mostrarAlerta(
                    error.message,
                    'danger'
                );


                boton.disabled = false;


                boton.innerHTML =
                    '<i class="bi bi-check-circle"></i><span>GUARDAR VALIDACIÓN</span>';

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ?? '';


        return div.innerHTML;

    }


    /* ================================================================
       ADAPTADORES DEL REDISEÑO VISUAL
       Conservan las acciones y endpoints del módulo original.
    ================================================================ */

    window.vpLTab = function (pane, button) {
        document.querySelectorAll('.vp-ltab').forEach(el => el.classList.remove('on'));
        if (button) button.classList.add('on');
        const pend = document.getElementById('vpListPend');
        const val = document.getElementById('vpListVal');
        if (pend) pend.classList.toggle('on', pane === 'pend');
        if (val) val.classList.toggle('on', pane === 'val');
        window.vpLFiltrar();
    };

    window.vpLFiltrar = function () {
        const input = document.getElementById('vpLSearch');
        const query = (input?.value || '').trim().toLocaleLowerCase('es');
        document.querySelectorAll('.vp-oc').forEach(card => {
            const haystack = (card.dataset.search || card.textContent || '').toLocaleLowerCase('es');
            card.style.display = haystack.includes(query) ? '' : 'none';
        });
    };

    window.vpIrHistorial = function () {
        const destino = document.getElementById('vpHistorial');
        if (destino) destino.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    window.vpDD = function (event) {
        if (event) event.stopPropagation();
        const menu = document.getElementById('vpDdMas');
        if (menu) menu.classList.toggle('open');
    };

    window.vpAccion = function (accion) {
        const menu = document.getElementById('vpDdMas');
        if (menu) menu.classList.remove('open');
        const pedido = window.__valPedido?.pedido;
        if (!pedido?.id) {
            mostrarAlerta('Primero selecciona un pedido.', 'warning');
            return;
        }
        if (accion === 'historial') {
            if (typeof window.verHistorialPedido === 'function') window.verHistorialPedido(pedido.id);
        } else if (accion === 'recargar') {
            window.abrirPedidoDesdeLista(pedido.id);
        }
    };

    window.vpFinalizar = function () {
        const pedido = window.__valPedido?.pedido;
        if (!pedido) {
            mostrarAlerta('Primero selecciona un pedido.', 'warning');
            return;
        }
        const panelCompleto = document.getElementById('panelCompleto');
        if (panelCompleto && !panelCompleto.classList.contains('d-none')) {
            document.getElementById('btnGuardarValidacion')?.click();
        } else {
            document.getElementById('btnModoCompleto')?.click();
            panelCompleto?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    function actualizarVpResumen() {
        const state = window.__valPedido;
        const pedido = state?.pedido;
        const detallesActuales = state?.detalles || [];
        const validacionesActuales = state?.validaciones || {};
        const panel = document.getElementById('vpProgress');
        const lista = document.getElementById('vpItems');
        const vacio = document.getElementById('vpEmpty');
        const contador = document.getElementById('vpItemsCount');
        if (!pedido || !detallesActuales.length) {
            if (panel) panel.classList.add('d-none');
            if (contador) contador.textContent = '(0)';
            if (lista) lista.innerHTML = '<div class="vp-lempty">Carga un pedido para ver sus productos.</div>';
            if (vacio) vacio.classList.remove('d-none');
            return;
        }
        if (panel) panel.classList.remove('d-none');
        if (vacio) vacio.classList.add('d-none');
        const entries = detallesActuales.map(detail => {
            const product = detail.product || {};
            const validation = validacionesActuales[detail.id] || null;
            const status = validation?.estado || 'PENDIENTE';
            const valid = !!validation;
            return { detail, product, status, valid };
        });
        const ok = entries.filter(x => x.valid && !String(x.status).includes('PARCIAL') && !String(x.status).includes('NO_ENVIADO')).length;
        const parcial = entries.filter(x => x.valid && String(x.status).includes('PARCIAL')).length;
        const no = entries.filter(x => x.valid && String(x.status).includes('NO_ENVIADO')).length;
        const hechas = entries.filter(x => x.valid).length;
        const total = entries.length;
        const pct = total ? Math.round((hechas / total) * 100) : 0;
        const setText = (id, value) => { const el = document.getElementById(id); if (el) el.textContent = value; };
        setText('vpProgTxt', `${hechas} / ${total}`);
        setText('vpProgPct', `${pct}%`);
        setText('vpLgOk', ok);
        setText('vpLgPar', parcial);
        setText('vpLgNo', no);
        setText('vpLgPen', total - hechas);
        const bar = document.getElementById('vpProgBar');
        if (bar) bar.style.width = `${pct}%`;
        if (contador) contador.textContent = `(${total})`;
        if (lista) {
            lista.innerHTML = entries.map(({detail, product, status, valid}, index) => {
                const name = product.nombre || product.name || 'Producto sin nombre';
                const code = product.barcode || product.box_barcode || product.sku || 'Sin código';
                const qty = detail.cantidad_despachada ?? detail.cantidad ?? 0;
                const stateClass = !valid ? 'vp-st-pen' : String(status).includes('PARCIAL') ? 'vp-st-par' : String(status).includes('NO_ENVIADO') ? 'vp-st-no' : 'vp-st-ok';
                const icon = !valid ? 'bi-circle' : String(status).includes('PARCIAL') ? 'bi-exclamation-circle-fill' : String(status).includes('NO_ENVIADO') ? 'bi-x-circle-fill' : 'bi-check-circle-fill';
                return `<div class="vp-it ${index === (state?.indice ?? -1) ? 'cur' : ''}">
                    <div class="vp-it-th"><i class="bi bi-box-seam"></i></div>
                    <div><div class="vp-it-n" title="${escapeHtml(name)}">${escapeHtml(name)}</div>
                    <div class="vp-it-s">${escapeHtml(String(code))}</div>
                    <div class="vp-it-p"><div class="vp-bar"><div style="width:${valid ? 100 : 0}%"></div></div><b>${valid ? '100%' : '0%'}</b><span>${escapeHtml(String(qty))} u.</span></div></div>
                    <div class="vp-it-st ${stateClass}"><i class="bi ${icon}"></i></div>
                </div>`;
            }).join('');
        }
    }

    // Las tarjetas visuales activan los botones originales que ya contienen la lógica real.
    document.querySelectorAll('.vp-mode').forEach(card => {
        const activar = () => document.getElementById(card.dataset.vpBtn)?.click();
        card.addEventListener('click', event => {
            if (event.target.closest('button')) return;
            activar();
        });
        card.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                activar();
            }
        });
    });

    // Controles + / − para cantidades parciales del diseño nuevo.
    document.addEventListener('click', event => {
        const button = event.target.closest('.vp-step');
        if (!button) return;
        const input = document.getElementById(button.dataset.target);
        if (!input) return;
        event.preventDefault();
        const step = Number.parseFloat(input.step) || 1;
        const current = Number.parseFloat(input.value) || 0;
        const min = Number.parseFloat(input.min);
        let next = current + (Number(button.dataset.step) * step);
        if (Number.isFinite(min)) next = Math.max(min, next);
        input.value = String(Number(next.toFixed(2)));
        input.dispatchEvent(new Event('input', { bubbles: true }));
        input.dispatchEvent(new Event('change', { bubbles: true }));
    });

    // Mantener las observaciones del diseño sincronizadas con el campo que se guarda.
    const vpObs = document.getElementById('vpObs');
    const originalObs = document.getElementById('observacionesValidacion');
    if (vpObs && originalObs) {
        vpObs.addEventListener('input', () => { originalObs.value = vpObs.value; });
        originalObs.addEventListener('input', () => { if (vpObs.value !== originalObs.value) vpObs.value = originalObs.value; });
    }

    document.addEventListener('click', event => {
        const menu = document.getElementById('vpDdMas');
        if (menu && !menu.contains(event.target)) menu.classList.remove('open');
    });

    // Refrescar la lista lateral cuando la validación original cambia de producto o estado.
    const observer = new MutationObserver(() => actualizarVpResumen());
    ['pedidoInfo', 'panelItem', 'panelScanner', 'panelCompleto'].forEach(id => {
        const target = document.getElementById(id);
        if (target) observer.observe(target, { subtree: true, childList: true, characterData: true, attributes: true });
    });
    actualizarVpResumen();

});

</script>

@endsection