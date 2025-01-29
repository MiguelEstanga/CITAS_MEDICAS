<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>Odontograma</h1>

    <!-- Contenedor del odontograma -->
    <div id="odontograma-container">
        <div id="odontograma"></div>
    </div>

    <!-- Modal dinámico para opciones -->
    <div id="opcionesModal" class="modal">
        <div class="modal-header">
            <h5>Opciones del Diente</h5>
            <button type="button" class="close" onclick="cerrarModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Diente: <span id="numeroDiente"></span></p>
            <p>Parte: <span id="parteDiente"></span></p>
            <div id="accionesOpciones">
                <button type="button" class="btn btn-danger" onclick="marcarDiente('fractura')">Fractura</button>
                <button  type="button"class="btn btn-primary" onclick="marcarDiente('restauracion')">Restauración</button>
                <button  type="button"class="btn btn-warning" onclick="marcarDiente('empastado')">Empastado</button>
                <button  type="button"class="btn btn-success" onclick="marcarDiente('sano')">Sano</button>
                <button  type="button"class="btn btn-secondary" onclick="marcarDiente('borrar')">Borrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Estilos -->
<style>
/* Contenedor principal */
#odontograma-container {
    text-align: center;
    margin: 20px 0;
}

/* Grid para el odontograma */
#odontograma {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
    gap: 10px;
    justify-content: center;
}

/* Cada diente */
.diente {
    position: relative;
    width: 50px;
    height: 50px;
    margin: 10px 0;
    border-radius: 50%;
    background: black;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.diente:hover {
    transform: scale(1.1);
}

/* Número del diente */
.numero-diente {
    position: absolute;
    top: -20px;
    font-size: 0.8rem;
    font-weight: bold;
    color: black;
}

/* Secciones del diente */
.seccion {
    position: absolute;
    width: 100%;
    height: 100%;
    transition: background-color 0.2s;
}

.central {
    clip-path: circle(25% at 50% 50%);
    background: rgba(255, 255, 255, 0.7);
    z-index: 5;
}

.superior {
    clip-path: polygon(0 0, 100% 0, 50% 50%);
    background: rgba(255, 255, 255, 0.9);
}

.inferior {
    clip-path: polygon(0 100%, 100% 100%, 50% 50%);
    background: rgba(255, 255, 255, 0.9);
}

.izquierda {
    clip-path: polygon(0 0, 0 100%, 50% 50%);
    background: rgba(255, 255, 255, 0.9);
}

.derecha {
    clip-path: polygon(100% 0, 100% 100%, 50% 50%);
    background: rgba(255, 255, 255, 0.9);
}

/* Modal dinámico */
.modal {
    display: none;
    position: absolute;
    background: white;
    border: 1px solid #ccc;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
    max-width: 200px;
}

.modal .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    margin-bottom: 10px;
}

.modal .modal-body {
    padding: 10px;
}

.modal .btn {
    display: block;
    width: 100%;
    margin-bottom: 5px;
    text-align: center;
}

.close {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
}
</style>

<!-- JavaScript -->
<script>
    const dientes = 32; // Número de dientes
    const odontograma = document.getElementById("odontograma");
    let parteSeleccionada = null; // Parte seleccionada del diente

    // Generar dientes con 5 partes (central, superior, inferior, izquierda, derecha)
    function generarOdontograma() {
        for (let i = 1; i <= dientes; i++) {
            const diente = document.createElement("div");
            diente.classList.add("diente");
            diente.setAttribute("data-id", i);

            // Número del diente
            const numero = document.createElement("div");
            numero.classList.add("numero-diente");
            numero.innerText = i;
            diente.appendChild(numero);

            // Partes del diente
            ["central", "superior", "inferior", "izquierda", "derecha"].forEach((parte) => {
                const seccion = document.createElement("div");
                seccion.classList.add("seccion", parte);
                seccion.setAttribute("data-parte", parte);
                seccion.setAttribute("data-diente", i);
                diente.appendChild(seccion);
            });

            odontograma.appendChild(diente);
        }
    }

    // Manejar clic en las partes del diente
    function manejarClick(event) {
        const target = event.target;

        // Validar que sea una sección
        if (!target.classList.contains("seccion")) return;

        // Guardar la parte seleccionada
        parteSeleccionada = target;

        // Obtener datos del diente y parte
        const parte = target.getAttribute("data-parte");
        const diente = target.getAttribute("data-diente");

        // Actualizar modal
        document.getElementById("numeroDiente").innerText = diente;
        document.getElementById("parteDiente").innerText = parte;

        // Mostrar modal cerca del diente seleccionado
        const modal = document.getElementById("opcionesModal");
        modal.style.display = "block";
        modal.style.left = `${event.pageX + 10}px`;
        modal.style.top = `${event.pageY + 10}px`;
    }

    // Función para cerrar el modal
    function cerrarModal() {
        document.getElementById("opcionesModal").style.display = "none";
        parteSeleccionada = null;
    }

    // Marcar la parte del diente seleccionada
    function marcarDiente(accion) {
        if (!parteSeleccionada) return;

        let color = "";
        switch (accion) {
            case "fractura": color = "red"; break;
            case "restauracion": color = "blue"; break;
            case "empastado": color = "yellow"; break;
            case "sano": color = "green"; break;
            case "borrar": color = ""; break;
        }

        parteSeleccionada.style.backgroundColor = color;
        cerrarModal();
    }

    // Inicializar odontograma
    document.addEventListener("DOMContentLoaded", () => {
        event.preventDefault();
        generarOdontograma();
     
        odontograma.addEventListener("click", manejarClick);
    });
</script>
