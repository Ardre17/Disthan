console.log("Mapa del almacén cargado.");

function abrirRack(rack){

    document.getElementById("panelRack").innerHTML = rack;
    document.getElementById("rackTitle").innerHTML = "RACK " + rack;

    let html = "";
    let ocupadas = 0;
    let libres = 0;

    for(let i = 1; i <= 18; i++){

        let codigo = rack + String(i).padStart(2,"0");

        let u = ubicaciones[codigo] || {
            estado:"LIBRE"
        };

        let clase = "libre";

        switch(u.estado){

            case "OCUPADO":
                clase = "ocupado";
                ocupadas++;
                break;

            case "STOCK_BAJO":
                clase = "stockbajo";
                ocupadas++;
                break;

            case "RESERVADO":
                clase = "reservado";
                ocupadas++;
                break;

            case "BLOCKED":
                clase = "bloqueado";
                ocupadas++;
                break;

            default:
                clase = "libre";
                libres++;
        }

        html += `
            <div class="rack-cell ${clase}" onclick="abrirUbicacion('${codigo}')">
                <strong>${codigo}</strong>
            </div>
        `;

    }

    document.getElementById("panelOcupadas").textContent = ocupadas;
    document.getElementById("panelLibres").textContent = libres;
    document.getElementById("panelTotal").textContent = ocupadas + libres;

    document.getElementById("rackGrid").innerHTML = html;
    document.getElementById("rackModal").style.display = "flex";

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
// ===============================
// Exponer funciones al navegador
// ===============================

window.abrirRack = abrirRack;
window.abrirUbicacion = abrirUbicacion;
window.cerrarRackModal = cerrarRackModal;