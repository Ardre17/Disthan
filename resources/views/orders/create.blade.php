<div style="padding:30px;background:#f4f6f9;min-height:100vh;">

```
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
">

    <div>
        <h1 style="
            margin:0;
            font-size:30px;
            color:#0f172a;
        ">
            📋 Nueva Orden
        </h1>

        <p style="
            margin-top:5px;
            color:#64748b;
        ">
            Registro de pedidos y programación logística
        </p>
    </div>

    <div style="
        background:white;
        padding:12px 18px;
        border-radius:10px;
        box-shadow:0 2px 8px rgba(0,0,0,.08);
    ">
        ORD-AUTO
    </div>

</div>

<form action="{{ route('orders.store') }}"
      method="POST">

    @csrf

    <div style="
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:25px;
    ">

        <div style="
            background:white;
            padding:25px;
            border-radius:16px;
            box-shadow:0 3px 10px rgba(0,0,0,.08);
        ">

            <h3 style="margin-bottom:20px;">
                Información General
            </h3>

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:15px;
            ">

                <div>
                    <label>Cliente</label>

                    <select name="client_id"
                            style="
                                width:100%;
                                padding:12px;
                                border:1px solid #ddd;
                                border-radius:8px;
                            ">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">
                                {{ $client->razon_social }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Tipo Orden</label>

                    <select name="tipo_orden"
                            style="
                                width:100%;
                                padding:12px;
                                border:1px solid #ddd;
                                border-radius:8px;
                            ">
                        <option>LOCAL</option>
                        <option>ENCOMIENDA</option>
                        <option>SUPERMERCADO</option>
                        <option>EXPORTACION</option>
                        <option>MUESTRA</option>
                    </select>
                </div>

                <div>
                    <label>Fecha Pedido</label>

                    <input type="date"
                           name="fecha_pedido"
                           value="{{ date('Y-m-d') }}"
                           style="
                               width:100%;
                               padding:12px;
                               border:1px solid #ddd;
                               border-radius:8px;
                           ">
                </div>

                <div>
                    <label>Fecha Entrega</label>

                    <input type="date"
                           name="fecha_entrega"
                           style="
                               width:100%;
                               padding:12px;
                               border:1px solid #ddd;
                               border-radius:8px;
                           ">
                </div>

            </div>

            <div style="margin-top:20px;">
                <label>Observaciones</label>

                <textarea
                    name="observaciones"
                    style="
                        width:100%;
                        height:120px;
                        padding:12px;
                        border:1px solid #ddd;
                        border-radius:8px;
                    "></textarea>
            </div>

            <div style="
                margin-top:25px;
                display:flex;
                gap:10px;
            ">

                <button type="submit"
                        style="
                            background:#dc2626;
                            color:white;
                            border:none;
                            padding:12px 24px;
                            border-radius:8px;
                            cursor:pointer;
                            font-weight:bold;
                        ">
                    Guardar Orden
                </button>

                <a href="{{ route('orders.index') }}"
                   style="
                       background:#64748b;
                       color:white;
                       padding:12px 24px;
                       border-radius:8px;
                       text-decoration:none;
                   ">
                    Cancelar
                </a>

            </div>

        </div>

        <div>

            <div style="
                background:white;
                padding:20px;
                border-radius:16px;
                box-shadow:0 3px 10px rgba(0,0,0,.08);
            ">

                <h3>Resumen</h3>

                <hr>

                <p>Estado Inicial:</p>

                <span style="
                    background:#dc2626;
                    color:white;
                    padding:6px 12px;
                    border-radius:20px;
                ">
                    INCOMPLETO
                </span>

                <hr style="margin:20px 0;">

                <p>
                    Productos:
                    <strong>0</strong>
                </p>

                <p>
                    Total:
                    <strong>S/ 0.00</strong>
                </p>

            </div>

        </div>

    </div>

</form>
```

</div>
