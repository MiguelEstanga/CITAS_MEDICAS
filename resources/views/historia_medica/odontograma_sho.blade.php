
    <div class="">
        <h4 class="alert" style="text-align: center;" >Detalle del Odontograma</h4>
        <div id="odontograma-container">
            <div id="odontograma">
                <!-- Se generan los 32 dientes dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dientes = 32;
            const odontogramaContainer = document.getElementById("odontograma");

            // 1. Generar la estructura básica de los 32 dientes
            for (let i = 1; i <= dientes; i++) {
                const diente = document.createElement("div");
                diente.classList.add("diente");
                diente.setAttribute("data-id", i);

                // Mostrar el número del diente
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

                odontogramaContainer.appendChild(diente);
            }

            // 2. Recuperar el JSON de la BD (ya lo pasamos desde el controlador)
            const dataOdontograma = @json($odontograma);
            console.log(dataOdontograma);
            // 3. Recorrer ca da diente y cada parte para aplicar el color guardado
            for (const tooth in dataOdontograma) {
                for (const part in dataOdontograma[tooth]) {
                    const color = dataOdontograma[tooth][part];

                    // Encontrar la sección correspondiente en el DOM
                    const selector = `.seccion[data-diente='${tooth}'][data-parte='${part}']`;
                    const sectionElement = document.querySelector(selector);

                    // Si existe esa parte del diente, colorearla
                    if (sectionElement) {
                        sectionElement.style.backgroundColor = color;
                    }
                }
            }
        });
    </script>

    <style>
        /* Contenedor principal */
        #odontograma-container {
            text-align: center;
            margin: 20px 0;
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
            border: 1px solid #666;
            box-sizing: border-box;
        }

        /* PARTE CENTRAL (círculo) */
        .central {
            clip-path: circle(25% at 50% 50%);
            z-index: 5;
        }

        /* PARTE SUPERIOR (triángulo) */
        .superior {
            clip-path: polygon(0 0, 100% 0, 50% 50%);
        }

        /* PARTE INFERIOR (triángulo) */
        .inferior {
            clip-path: polygon(0 100%, 100% 100%, 50% 50%);
        }

        /* PARTE IZQUIERDA (triángulo) */
        .izquierda {
            clip-path: polygon(0 0, 0 100%, 50% 50%);
        }

        /* PARTE DERECHA (triángulo) */
        .derecha {
            clip-path: polygon(100% 0, 100% 100%, 50% 50%);
        }
    </style>

