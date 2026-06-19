@extends('layouts.app')

@section('content')

<h1 style="font-size:28px;font-weight:bold;">
    📊 Dashboard
</h1>

<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-top:20px;
">

    <div style="background:white;padding:20px;border-radius:12px;">
        <h3>📦 Órdenes</h3>
        <p>Total: {{ \App\Models\Order::count() }}</p>
    </div>

    <div style="background:white;padding:20px;border-radius:12px;">
        <h3>⏳ Pendientes</h3>
        <p>{{ \App\Models\Order::where('estado','INCOMPLETO')->count() }}</p>
    </div>

    <div style="background:white;padding:20px;border-radius:12px;">
        <h3>⚠️ Parciales</h3>
        <p>{{ \App\Models\Order::where('estado','PARCIAL')->count() }}</p>
    </div>

    <div style="background:white;padding:20px;border-radius:12px;">
        <h3>✅ Completas</h3>
        <p>{{ \App\Models\Order::where('estado','COMPLETO')->count() }}</p>
    </div>

</div>
<div style="
    background:'#8b5cf6';
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    margin-top:20px;
">

    <h3 style="margin-bottom:15px;">
        📊 Pedidos por Cliente (Mes Actual)
    </h3>

    <div style="
    width:100%;
    max-width:700px;
    height:300px; /* 🔥 ALTURA CONTROLADA */
    margin:auto;
">
        <canvas id="clientesChart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let data = @json($data ?? []);

let labels = data.map(d => d.client.razon_social);
let values = data.map(d => d.total);

new Chart(document.getElementById('clientesChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pedidos del mes',
            data: values,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // 🔥 CLAVE
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
