@extends('layouts.app')

@section('content')

<div style="max-width:900px;margin:auto;">

    <h1 style="font-size:28px;font-weight:bold;">
        📦 Modo Operario
    </h1>

    <p style="color:#64748b;margin-bottom:20px;">
        Escanea productos para procesar pedidos
    </p>

    <!-- ESCÁNER -->
    <input type="text" id="scanner"
        placeholder="🔍 Escanea código..."
        style="
            width:100%;
            padding:15px;
            border-radius:10px;
            border:1px solid #ddd;
            margin-bottom:20px;
            font-size:16px;
        ">

    <!-- RESULTADO -->
    <div id="resultado"></div>

</div>

<script>
document.getElementById('scanner').addEventListener('keypress', function(e){

    if(e.key === 'Enter'){
        e.preventDefault();

        let codigo = this.value;

        if(!codigo) return;

        fetch('/buscar-producto/' + codigo)
        .then(res => res.json())
        .then(data => {

            if(!data){
                alert('Producto no encontrado');
                return;
            }

            document.getElementById('resultado').innerHTML = `
                <div style="
                    background:white;
                    padding:15px;
                    border-radius:10px;
                    box-shadow:0 2px 8px rgba(0,0,0,.1);
                ">
                    <strong>${data.nombre}</strong><br>
                    Stock: ${data.stock}
                </div>
            `;

            document.getElementById('scanner').value = '';
        });

    }

});
</script>

@endsection


