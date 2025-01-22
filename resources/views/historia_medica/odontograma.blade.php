
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
                numero.innerText = i;
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

            const btnGuardar = document.getElementById('btn-guardar');
            btnGuardar.addEventListener('click', guardarOdontograma);
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

        /* Grid de 16 columnas para 32 dientes en 2 filas */
        #odontograma {
            display: grid;
            grid-template-columns: repeat(16, 60px);
            gap: 10px;
            justify-content: center;
        }

        /* Cada diente */
        .diente {
            position: relative;
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Número del diente (arriba) */
        .numero-diente {
            position: absolute;
            top: -15px;
            font-size: 12px;
            font-weight: bold;
            color: black;
        }

        /* Secciones del diente */
        .seccion {
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
            transition: background-color 0.2s;
            /* Líneas divisorias */
            border: 1px solid #666;
            box-sizing: border-box;
        }
        .seccion:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        /* PARTE CENTRAL (círculo) */
        .central {
            clip-path: circle(25% at 50% 50%);
            z-index: 5; /* para que no quede debajo de las secciones triangulares */
        }

        /* PARTE SUPERIOR: triángulo */
        .superior {
            clip-path: polygon(0 0, 100% 0, 50% 50%);
        }

        /* PARTE INFERIOR: triángulo */
        .inferior {
            clip-path: polygon(0 100%, 100% 100%, 50% 50%);
        }

        /* PARTE IZQUIERDA: triángulo */
        .izquierda {
            clip-path: polygon(0 0, 0 100%, 50% 50%);
        }

        /* PARTE DERECHA: triángulo */
        .derecha {
            clip-path: polygon(100% 0, 100% 100%, 50% 50%);
        }
    </style>
