@extends('layouts.app')

@section('content')
<style>
.conc-wrap{max-width:1600px;margin:0 auto;padding:22px;color:#19324d}
.conc-head{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px}
.conc-head h1{font-size:25px;font-weight:800;margin:0;color:#163b67}
.conc-head p{margin:5px 0 0;color:#718198}
.conc-card{background:#fff;border:1px solid #dce6f1;border-radius:14px;padding:20px;box-shadow:0 5px 18px rgba(21,56,94,.05);margin-bottom:18px}
.conc-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.conc-label{display:block;font-size:13px;font-weight:700;margin-bottom:7px;color:#3b5069}
.conc-control{width:100%;border:1px solid #cbd8e7;border-radius:9px;padding:11px 12px;background:#fff;color:#213b58}
.conc-btn{border:0;border-radius:9px;background:#1769d1;color:#fff;padding:11px 17px;font-weight:700;cursor:pointer}
.conc-btn:hover{background:#1257b4}
.conc-muted{color:#718198;font-size:13px}
.conc-table-wrap{overflow:auto}
.conc-table{width:100%;border-collapse:collapse;min-width:760px}
.conc-table th{background:#f0f5fb;color:#415a78;text-align:left;font-size:12px;padding:11px;border-bottom:1px solid #dbe5f0}
.conc-table td{padding:10px 11px;border-bottom:1px solid #edf1f6;font-size:13px}
.conc-pill{display:inline-block;border-radius:999px;background:#e8f1ff;color:#1759a6;padding:5px 9px;font-size:12px;font-weight:700}
@media(max-width:850px){.conc-grid{grid-template-columns:1fr}.conc-head{align-items:flex-start;flex-direction:column}.conc-wrap{padding:14px}}
</style>

<div class="conc-wrap">
    <div class="conc-head">
        <div>
            <h1>Conciliación de inventario</h1>
            <p>Compara los movimientos del sistema del cliente con los registros de DISTAN.</p>
        </div>
        <span class="conc-pill">Margen de fecha: ±7 días</span>
    </div>

    @if ($errors->any())
        <div class="conc-card" style="border-color:#f3b6b6;background:#fff8f8;color:#a12626">
            <strong>Revisa el archivo:</strong>
            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="conc-card">
        <h2 style="font-size:17px;font-weight:800;margin:0 0 6px">Nueva conciliación</h2>
        <p class="conc-muted" style="margin:0 0 18px">Selecciona el producto y carga el CSV que preparaste desde el sistema del cliente. La importación actual solo genera una vista previa; todavía no guarda ni modifica inventario.</p>
        <form action="{{ route('reconciliacion.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="conc-grid">
                <div>
                    <label class="conc-label" for="product_id">Producto de DISTAN</label>
                    <select class="conc-control" name="product_id" id="product_id" required>
                        <option value="">Selecciona un producto...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" @selected(old('product_id', $productoSeleccionado ?? '') == $producto->id)>
                                {{ $producto->nombre }}{{ $producto->sku ? ' · '.$producto->sku : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="conc-label" for="archivo_csv">Archivo CSV del sistema del cliente</label>
                    <input class="conc-control" type="file" name="archivo_csv" id="archivo_csv" accept=".csv,.txt" required>
                    <p class="conc-muted" style="margin:6px 0 0">Columnas: Razón social, Emisión, Ingresos, Salidas y RUC/Cliente (opcional).</p>
                </div>
            </div>
            <div style="margin-top:17px">
                <button class="conc-btn" type="submit">Leer CSV y mostrar vista previa</button>
            </div>
        </form>
    </div>

    @isset($previewRows)
        <div class="conc-card">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px">
                <div>
                    <h2 style="font-size:17px;font-weight:800;margin:0">Vista previa del archivo</h2>
                    <p class="conc-muted" style="margin:5px 0 0">{{ $archivoNombre ?? 'CSV' }} · {{ $previewCount ?? count($previewRows) }} movimientos leídos</p>
                </div>
                <span class="conc-pill">Sin guardar cambios</span>
            </div>
            <div class="conc-table-wrap">
                <table class="conc-table">
                    <thead>
                        <tr><th>Fila CSV</th><th>Razón social</th><th>Emisión</th><th>RUC / Cliente</th><th style="text-align:right">Ingresos</th><th style="text-align:right">Salidas</th></tr>
                    </thead>
                    <tbody>
                        @forelse($previewRows as $row)
                            <tr>
                                <td>{{ $row['fila'] }}</td>
                                <td>{{ $row['razon_social'] ?: '—' }}</td>
                                <td>{{ $row['emision'] ?: '—' }}</td>
                                <td>{{ $row['ruc'] ?: '—' }}</td>
                                <td style="text-align:right;color:#15803d;font-weight:700">{{ number_format($row['ingresos'], 3) }}</td>
                                <td style="text-align:right;color:#c24141;font-weight:700">{{ number_format($row['salidas'], 3) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;padding:25px">El archivo no contiene movimientos.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endisset

    <div class="conc-grid">
        <div class="conc-card">
            <h2 style="font-size:16px;font-weight:800;margin:0 0 8px">Movimientos de DISTAN</h2>
            <p class="conc-muted" style="margin:0">En la siguiente fase conectaremos aquí el Kardex real del producto, incluyendo producción, ingresos directos, despachos y desmedros.</p>
        </div>
        <div class="conc-card">
            <h2 style="font-size:16px;font-weight:800;margin:0 0 8px">Movimientos del cliente</h2>
            <p class="conc-muted" style="margin:0">Aquí aparecerán los movimientos importados, las coincidencias automáticas y los casos dudosos para revisar.</p>
        </div>
    </div>
</div>
@endsection
