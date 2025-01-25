<div>
    <h4 class="alert" style="text-align: center;">Detalle del Odontograma</h4>
</div>
<div class="Container_detalle_odontograma">
 
    <div id="odontograma-container">
        <div id="odontograma"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dientes = 32;
        const odontogramaContainer = document.getElementById("odontograma");

        for (let i = 1; i <= dientes; i++) {
            const diente = document.createElement("div");
            diente.classList.add("diente");
            diente.setAttribute("data-id", i);

            const numero = document.createElement("div");
            numero.classList.add("numero-diente");
            numero.innerText = i;
            diente.appendChild(numero);

            ["central", "superior", "inferior", "izquierda", "derecha"].forEach((parte) => {
                const seccion = document.createElement("div");
                seccion.classList.add("seccion", parte);
                seccion.setAttribute("data-parte", parte);
                seccion.setAttribute("data-diente", i);
                diente.appendChild(seccion);
            });

            odontogramaContainer.appendChild(diente);
        }

        const dataOdontograma = @json($odontograma);
        console.log(dataOdontograma);

        for (const tooth in dataOdontograma) {
            for (const part in dataOdontograma[tooth]) {
                const color = dataOdontograma[tooth][part];
                const selector = `.seccion[data-diente='${tooth}'][data-parte='${part}']`;
                const sectionElement = document.querySelector(selector);

                if (sectionElement) {
                    sectionElement.style.backgroundColor = color;
                }
            }
        }
    });
</script>

<style>
    h4{
        margin: auto;
    }
 .Container_detalle_odontograma {
    width: 800px;
   
   
   
    margin: auto;
    
}

#odontograma-container {
    text-align: center;
    margin: 20px 0;
}

#odontograma {
    display: grid;
    grid-template-columns: repeat(18, 40px); /* 18 columnas */
    gap: 10px;
    justify-content: center; /* Centrar los elementos */
}

.diente {
    position: relative;
    width: 40px;
    height: 40px;
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

.seccion {
    position: absolute;
    width: 100%;
    height: 100%;
    cursor: pointer;
    transition: background-color 0.2s;
    box-sizing: border-box;
}

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
  

