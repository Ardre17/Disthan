@extends('layouts.app')

@section('content')
<style>
/*====================================================
MAPA DEL ALMACÉN
====================================================*/

.warehouse-layout{

    display:grid;

    grid-template-columns:78% 22%;

    gap:24px;

    align-items:start;

}

.warehouse-map{

    background:white;

    border-radius:20px;

    padding:25px;

    box-shadow:0 12px 30px rgba(0,0,0,.08);

    overflow:auto;

    min-height:980px;

}

.warehouse-panel{

    display:flex;

    flex-direction:column;

    gap:18px;

    position:sticky;

    top:20px;

}

.panel-card{

    background:white;

    border-radius:18px;

    padding:22px;

    box-shadow:
        0 8px 25px rgba(0,0,0,.08);

}

.panel-card h2{

    margin:0 0 14px;

    font-size:20px;

    color:#0f172a;

}

/*======================================
SVG
======================================*/

#warehouseMap{

    width:100%;

    height:auto;

}

/*======================================
RACKS NIVEL 2
======================================*/

.rack{

    fill:#f8fbff;

    stroke:#2563eb;

    stroke-width:2;

    transition:.25s;

    cursor:pointer;

    filter:drop-shadow(0 6px 8px rgba(0,0,0,.12));

}

.rack:hover{

    fill:#dbeafe;

    stroke:#1d4ed8;

    transform-box:fill-box;

    transform-origin:center;

}

/*======================================
RACKS NIVEL 1
======================================*/

.rackGreen{

    fill:#f7fff8;

    stroke:#16a34a;

    stroke-width:2;

    transition:.25s;

    cursor:pointer;

    filter:drop-shadow(0 6px 8px rgba(0,0,0,.12));

}

.rackGreen:hover{

    fill:#dcfce7;

    stroke:#15803d;

    transform-box:fill-box;

    transform-origin:center;

}

/*======================================
RACKS PEQUEÑOS
======================================*/

.rackSmall{

    fill:#fafafa;

    stroke:#9ca3af;

    stroke-width:2;

    filter:drop-shadow(0 4px 8px rgba(0,0,0,.10));

}

/*======================================
KPIs
======================================*/

.warehouse-stats{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:18px;

    margin-top:22px;

}

.stat-card{

    background:white;

    border-radius:18px;

    padding:20px;

    box-shadow:
        0 8px 25px rgba(0,0,0,.08);

    text-align:center;

}

.stat-card h3{

    margin:0;

    font-size:15px;

    color:#64748b;

}

.stat-card span{

    display:block;

    margin-top:8px;

    font-size:34px;

    font-weight:bold;

    color:#0f172a;

}

/*======================================
BOTONES
======================================*/

.warehouse-toolbar{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;

}

.toolbar-actions{

    display:flex;

    gap:10px;

}

.toolbar-actions button{

    padding:12px 18px;

    border-radius:12px;

    border:1px solid #dbe4ef;

    background:white;

    cursor:pointer;

    font-weight:600;

}

.toolbar-actions .primary{

    background:#2563eb;

    color:white;

}

/*======================================
ANIMACIÓN
======================================*/

.rack,
.rackGreen{

    transition:
        transform .20s,
        fill .20s,
        stroke .20s;

}

.rack:hover,
.rackGreen:hover{

    transform:translateY(-4px);

}

.warehouse-rack{

    cursor:pointer;

}

.warehouse-rack:hover{

    opacity:.92;

}

/*=========================
MODAL
=========================*/

.rack-modal{

position:fixed;

top:0;

left:0;

width:100%;

height:100%;

background:rgba(0,0,0,.45);

display:none;

justify-content:center;

align-items:center;

z-index:9999;

}

.rack-modal-content{

width:720px;

background:white;

border-radius:20px;

overflow:hidden;

box-shadow:0 20px 60px rgba(0,0,0,.25);

}

.rack-modal-header{

display:flex;

justify-content:space-between;

align-items:center;

padding:20px;

background:#2563eb;

color:white;

}

.rack-modal-header button{

border:none;

background:none;

color:white;

font-size:28px;

cursor:pointer;

}

.rack-grid{

padding:25px;

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

}

.rack-cell{

height:70px;

border-radius:10px;

border:2px solid #2563eb;

display:flex;

justify-content:center;

align-items:center;

font-weight:bold;

cursor:pointer;

transition:.25s;

}

.rack-cell:hover{

background:#dbeafe;

}

.rack-footer{

padding:20px;

border-top:1px solid #eee;

}
.disponible{

background:#ecfdf5;

border-color:#22c55e;

}

.ocupado{

background:#dbeafe;

border-color:#2563eb;

}

.bloqueado{

background:#fee2e2;

border-color:#ef4444;

}

.reserva{

background:#f3e8ff;

border-color:#8b5cf6;

.primary-btn{

background:#2563eb;

color:white;

border:none;

padding:12px 18px;

border-radius:10px;

cursor:pointer;

}

.secondary-btn{

background:white;

border:1px solid #d1d5db;

padding:12px 18px;

border-radius:10px;

cursor:pointer;

}

table td{

padding:10px;

border-bottom:1px solid #ececec;

}
}
.ubicacion-info{

display:grid;

grid-template-columns:1fr 1fr;

gap:18px;

margin-bottom:25px;

}

.ubicacion-info div{

background:#f8fafc;

padding:15px;

border-radius:12px;

border:1px solid #e5e7eb;

}

.ubicacion-info strong{

display:block;

margin-bottom:8px;

color:#64748b;

font-size:13px;

}

.ubicacion-info span{

font-size:17px;

font-weight:600;

color:#111827;

}
.libre{

background:#ecfdf5;

border:2px solid #22c55e;

}

.ocupado{

background:#dbeafe;

border:2px solid #2563eb;

}

.stockbajo{

background:#fef3c7;

border:2px solid #f59e0b;

}

.reservado{

background:#ede9fe;

border:2px solid #7c3aed;

}
.progress{

height:12px;

background:#e5e7eb;

border-radius:20px;

overflow:hidden;

margin-top:6px;

}

.progress-fill{

height:100%;

width:0;

background:#22c55e;

transition:.35s;

}
.rack-resumen{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:10px;

margin-bottom:20px;

}

.resumen-item{

background:#f8fafc;

padding:14px;

border-radius:12px;

border:1px solid #e5e7eb;

}

.resumen-item span{

display:block;

font-size:13px;

color:#64748b;

}

.resumen-item strong{

font-size:24px;

color:#111827;

}
</style>

@include('warehouse.partials.toolbar')

<div class="warehouse-layout">

    <div class="warehouse-map">

        @include('warehouse.components.warehouse-svg')

    </div>

    <div class="warehouse-panel">

        @include('warehouse.partials.right-panel')

    </div>

</div>

@include('warehouse.partials.stats')

<script>

console.log("Mapa del almacén cargado.");

function abrirRack(rack){

    document.getElementById("panelRack").innerHTML=rack;
    document.getElementById("rackTitle").innerHTML="RACK "+rack;

    let html="";

    for(let i=1;i<=10;i++){
        let ocupadas=0;

    let libres=0;

    for(let codigo in ubicaciones){

        if(codigo.startsWith(rack)){

            if(ubicaciones[codigo].estado=="LIBRE")

                libres++;

            else

                ocupadas++;

        }

    }

    document.getElementById("panelOcupadas").innerHTML=ocupadas;

    document.getElementById("panelLibres").innerHTML=libres;

    document.getElementById("panelTotal").innerHTML=
    ocupadas+libres;

    let codigo=rack+String(i).padStart(2,"0");

    let estado="disponible";

    if(i==2 || i==11)
        estado="ocupado";

    if(i==6)
        estado="bloqueado";

    if(i==15)
        estado="reserva";

    html+=`

    <div
        let clase="libre";

switch(u.estado){

case "OCUPADO":
clase="ocupado";
break;

case "STOCK_BAJO":
clase="stockbajo";
break;

case "RESERVADO":
clase="reservado";
break;

case "LIBRE":
clase="libre";
break;

}
html+=`

<div
class="rack-cell ${clase}"
onclick="abrirUbicacion('${codigo}')">

<strong>${codigo}</strong>

</div>

`;
    </div>

    `;

}

    document.getElementById("rackGrid").innerHTML=html;

    document.getElementById("rackModal").style.display="flex";

}

function cerrarRackModal(){

    document.getElementById("rackModal").style.display="none";

}
const ubicaciones = {

A01:{
producto:"Mermelada Fresa",
sku:"MER-001",
lote:"L240501",
stock:180,
capacidad:200,
estado:"Ocupado"
},

A02:{
producto:"Mermelada Piña",
sku:"MER-002",
lote:"L240502",
stock:95,
capacidad:200,
estado:"Ocupado"
},

A03:{
producto:"Salsa BBQ",
sku:"SAL-003",
lote:"L240503",
stock:45,
capacidad:200,
estado:"Stock Bajo"
},

A04:{
producto:"",
sku:"",
lote:"",
stock:0,
capacidad:200,
estado:"Disponible"
},

A05:{
producto:"",
sku:"",
lote:"",
stock:0,
capacidad:200,
estado:"Disponible"
},

A06:{
producto:"Reservado",
sku:"---",
lote:"---",
stock:120,
capacidad:200,
estado:"Reservado"
}

};
function abrirUbicacion(codigo){

    document.getElementById("rackModal").style.display="none";

    const u = ubicaciones[codigo] || {

        producto:"",
        sku:"",
        lote:"",
        stock:0,
        capacidad:200,
        estado:"Disponible"

    };

    document.getElementById("panelUbicacion").innerHTML=codigo;

    document.getElementById("panelProducto").innerHTML=
        u.producto || "Sin producto";

    document.getElementById("panelSku").innerHTML=
        u.sku || "-";

    document.getElementById("panelLote").innerHTML=
        u.lote || "-";

    document.getElementById("panelStock").innerHTML=
        u.stock + " cajas";

    document.getElementById("panelCapacidad").innerHTML=
        u.capacidad + " cajas";

    document.getElementById("panelEstado").innerHTML=
        u.estado;
        document.getElementById("ocupacionBar").style.width =
    u.ocupacion+"%";

    document.getElementById("ocupacionTexto").innerHTML =
    u.ocupacion+"%";

}
</script>
<!-- ===========================
MODAL DE RACK
=========================== -->

<div id="rackModal" class="rack-modal">

    <div class="rack-modal-content">

        <div class="rack-modal-header">

            <h2 id="rackTitle">Rack A</h2>

            <button onclick="cerrarRackModal()">✕</button>

        </div>

        <div id="rackGrid" class="rack-grid">

        </div>

        <div class="rack-footer">

            <strong id="rackInfo">

            10 ubicaciones

            </strong>

        </div>

    </div>

</div>
@endsection