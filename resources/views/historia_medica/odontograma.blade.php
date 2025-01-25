<div class="container">
    {{-- CSRF Token para el envío de datos --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>Odontograma</h1>

    <!-- Opciones de acción -->
    <div id="radio-actions">
        <input type="radio" id="fractura" name="accion" value="fractura" checked />
        <label for="fractura">Fractura</label>

        <input type="radio" id="restauracion" name="accion" value="restauracion" />
        <label for="restauracion">Restauración</label>

        <input type="radio" id="empastado" name="accion" value="empastado" />
        <label for="empastado">Empastado</label>

        <input type="radio" id="sano" name="accion" value="sano" />
        <label for="sano">Sano</label>

        <input type="radio" id="borrar" name="accion" value="borrar" />
        <label for="borrar">Borrar</label>
    </div>

    <!-- Contenedor del odontograma -->
    <div id="odontograma-container">
        <div id="odontograma">
            <!-- Aquí se generan dinámicamente los 32 dientes -->
        </div>
    </div>

    <!-- Botón para guardar -->

</div>

<!-- Script: Generar y manejar el odontograma -->
<script>
    const dientes = 32;
    const odontograma = document.getElementById("odontograma");

    // Generar dientes con 5 partes (central + 4 segmentos)
    function generarOdontograma() {
        for (let i = 1; i <= dientes; i++) {
            const diente = document.createElement("div");
            diente.classList.add("diente");
            diente.setAttribute("data-id", i);

            // Crear número del diente
            
            const numero = document.createElement("div");
            numero.classList.add("numero-diente");
            numero.innerText = i; // Generar el texto del número
            diente.appendChild(numero);
        

            // Crear 5 partes: central, superior, inferior, izquierda, derecha
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

    // Manejar clics en las partes del diente
    function manejarClick(event) {
        const target = event.target;
        if (!target.classList.contains("seccion")) return;

        const parte = target.getAttribute("data-parte");
        const diente = target.getAttribute("data-diente");
        const accion = document.querySelector("input[name='accion']:checked").value;

        let color = "";
        switch (accion) {
            case "fractura":
                color = "red";
                break;
            case "restauracion":
                color = "blue";
                break;
            case "empastado":
                color = "yellow";
                break;
            case "sano":
                color = "green";
                break;
            case "borrar":
                color = "";
                break;
        }
        target.style.backgroundColor = color;

        console.log(`Diente: ${diente}, Parte: ${parte}, Acción: ${accion}`);
    }

    // Guardar el odontograma


    // Inicializar el odontograma y añadir listeners
    document.addEventListener('DOMContentLoaded', () => {
        generarOdontograma();
        odontograma.addEventListener("click", manejarClick);


    });
</script>

<!-- Estilos básicos -->
<style>
  /* Contenedor principal */
#odontograma-container {
    text-align: center;
    margin: 20px 0;
}

#radio-actions {
    margin-bottom: 15px;
}

#radio-actions label {
    margin-right: 10px;
}

/* Grid responsive para el odontograma */
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
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: visible;
    box-sizing: border-box;
    background: black;
    transition: transform 0.3s ease;
}

.diente:hover {
    transform: scale(1.1);
}

/* Número del diente (centrado y arriba) */
.numero-diente {
    position: absolute;
    top: -20px;
    font-size: 0.8rem;
    font-weight: bold;
    color: black;
    text-align: center;
    width: 100%;
    z-index: 10;
}

/* Secciones del diente */
.seccion {
    position: absolute;
    width: 100%;
    height: 100%;
    cursor: pointer;
    transition: background-color 0.2s;
    box-sizing: border-box;
}

/* Secciones individuales con clip-path */
.central {
    clip-path: circle(25% at 50% 50%);
    z-index: 5;
    background: rgba(255, 255, 255, 0.7);
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

/* Media queries para mejorar la respuesta en dispositivos pequeños */
@media (max-width: 768px) {
    .diente {
        width: 40px;
        height: 40px;
    }
    .numero-diente {
        top: -15px;
        font-size: 0.7rem;
    }
}

@media (max-width: 480px) {
    .diente {
        width: 35px;
        height: 35px;
    }
    .numero-diente {
        top: -12px;
        font-size: 0.6rem;
    }
}

</style>
