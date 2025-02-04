
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    h1 {
      text-align: center;
    }

    /* Contenedor general de todas las filas */
    .odontograma-container {
      display: flex;
      flex-direction: column;
      gap: 40px; /* espacio entre filas */
      align-items: center; /* centrar cada fila */
    }

    /* Cada fila de dientes */
    .row-dientes {
      display: flex;
      gap: 20px; /* separa cada diente en la fila */
      flex-wrap: wrap; 
      justify-content: center; 
    }

    /* Diente */
    .diente {
      position: relative;
      width: 70px;  /* puedes ajustar a tu gusto */
      height: 70px;
      border: 1px solid #000;
      border-radius: 40px;
      cursor: pointer;
      user-select: none;
      box-sizing: border-box;
    }
    .diente .numero_diente {
      position: absolute;
      top: -18px;
      width: 100%;
      text-align: center;
      font-weight: bold;
      font-size: 12px;
    }

    /* Zonas internas del diente */
    .parte_superior,
    .parte_inferior,
    .parte_izquierda,
    .parte_derecha,
    .parte_centro {
      position: absolute;
      border: 1px solid #000;
      box-sizing: border-box;
      background-color: #fff;
    }
    .parte_superior {
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 36px;
      height: 18px;
      border-top-left-radius: 39px;
      border-top-right-radius: 39px;
    }
    .parte_inferior {
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 36px;
      height: 18px;
      border-bottom-left-radius: 39px;
      border-bottom-right-radius: 39px;
    }
    .parte_izquierda {
      top: 18px;
      left: 6px;
      width: 24px;
      height: 34px;
      border-top-left-radius: 39px;
      border-bottom-left-radius: 39px;
    }
    .parte_derecha {
      top: 18px;
      right: 6px;
      width: 24px;
      height: 34px;
      border-top-right-radius: 39px;
      border-bottom-right-radius: 39px;
    }
    .parte_centro {
      top: 18px;
      left: 30px;
      right: 30px;
      height: 34px;
    }

    /* Modal */
    #modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #f2f2f2;
      padding: 20px;
      border: 2px solid #666;
      z-index: 9999;
      border-radius: 8px;
      max-width: 300px;
    }
    #modal h2 {
      margin-top: 0;
      font-size: 18px;
    }
    #modal select {
      width: 100%;
      margin-bottom: 15px;
      padding: 6px;
      font-size: 14px;
    }

    /* Fondo oscuro detrás del modal */
    #overlay {
      display: none;
      position: fixed;
      top: 0; 
      left: 0;
      width: 100vw; 
      height: 100vh;
      background: rgba(0,0,0,0.5);
      z-index: 9998;
    }

    .botones {
      margin-top: 30px;
      text-align: center;
    }
    .botones button {
      margin: 0 10px;
      padding: 10px 20px;
      cursor: pointer;
    }

  </style>
</head>
<body>
  
  <div class="odontograma-container p-4">
    <!-- Fila 1 -->
    <div class="row-dientes" id="row1"></div>
    <!-- Fila 2 (centrada) -->
    <div class="row-dientes" id="row2"></div>
    <!-- Fila 3 (centrada) -->
    <div class="row-dientes" id="row3"></div>
    <!-- Fila 4 -->
    <div class="row-dientes" id="row4"></div>
  </div>

  <!--div class="botones">
    <button id="mostrar-json">Mostrar JSON en Consola</button>
  </div-->

  <!-- Overlay (fondo oscuro) -->
  <div id="overlay"></div>

  <!-- Modal para seleccionar el estado de la zona -->
  <div id="modal">
    <h2>Selecciona el estado/zona</h2>
    <p><strong id="info-diente"></strong></p>

    <!-- Select con las opciones de estado -->
    <select id="select-estado">
      <!-- Se llenará dinámicamente con JS -->
    </select>

    <button type="button" id="btn-aplicar">Aplicar</button>
    <button type="button" id="modal-cancelar">Cancelar</button>
  </div>

  <script>
    // 1) Arrays con el ORDEN de dientes por FILAS
    const fila1 = ["18","17","16","15","14","12","11","21","22","23","24","25","26","27","28"];
    const fila2 = ["55","54","53","52","51","61","62","63","64","65"];
    const fila3 = ["85","84","83","82","81","71","72","73","74","75"];
    const fila4 = ["48","47","46","45","44","43","42","41","31","32","33","34","35","36","37","38"];

    // 2) Opciones de estado/colores (podrías cambiar los colores a tu gusto)
    //    label = nombre del estado, color = color que se pintará
    const estadoOpciones = [
      { label: "empastizado",      color: "#B5651D" },
      { label: "caries",           color: "#FF0000" },
      { label: "sano",             color: "#00FF00" },
      { label: "extraccion",       color: "#000000" },
      { label: "odontopediatria",  color: "#FF69B4" },
      { label: "ortodoncia",       color: "#0000FF" },
      { label: "protesis dental",  color: "#8A2BE2" },
      { label: "endodoncia",       color: "#FFA500" },
      { label: "eliminar",         color: "#FFFFFF" } // "blanco" para resetear
    ];

    // 3) Objeto global para almacenar el estado de cada ZONA de cada diente
    //    Estructura: toothStates[diente] = {
    //       top:    { label: "caries", color: "#f00" },
    //       bottom: { label: "sano", color: "#0f0" },
    //       ...
    //    };
    const toothStates = {};

    // Función para crear la estructura HTML de un diente
    function crearDiente(toothNumber) {
      const diente = document.createElement('div');
      diente.className = 'diente';
      diente.setAttribute('data-diente', toothNumber);

      // Número del diente
      const numElem = document.createElement('div');
      numElem.className = 'numero_diente';
      numElem.textContent = toothNumber;
      diente.appendChild(numElem);

      // Zonas (5)
      const top = document.createElement('div');
      top.className = 'parte_superior';
      top.setAttribute('data-area', 'top');
      diente.appendChild(top);

      const bottom = document.createElement('div');
      bottom.className = 'parte_inferior';
      bottom.setAttribute('data-area', 'bottom');
      diente.appendChild(bottom);

      const left = document.createElement('div');
      left.className = 'parte_izquierda';
      left.setAttribute('data-area', 'left');
      diente.appendChild(left);

      const right = document.createElement('div');
      right.className = 'parte_derecha';
      right.setAttribute('data-area', 'right');
      diente.appendChild(right);

      const center = document.createElement('div');
      center.className = 'parte_centro';
      center.setAttribute('data-area', 'center');
      diente.appendChild(center);

      // Inicializamos en "blanco" (o "sano"?), aquí usamos "blanco" por defecto
      toothStates[toothNumber] = {
        top:    { label: "eliminar", color: "#ffffff" },
        bottom: { label: "eliminar", color: "#ffffff" },
        left:   { label: "eliminar", color: "#ffffff" },
        right:  { label: "eliminar", color: "#ffffff" },
        center: { label: "eliminar", color: "#ffffff" }
      };

      // Listeners de clic en cada zona
      [top, bottom, left, right, center].forEach(zone => {
        zone.addEventListener('click', (event) => {
          event.stopPropagation();
          abrirModal(toothNumber, zone.getAttribute('data-area'));
        });
      });

      return diente;
    }

    // Renderizar los dientes en cada fila
    function renderFila(arrayDientes, rowId) {
      const rowContainer = document.getElementById(rowId);
      arrayDientes.forEach(num => {
        const dienteElem = crearDiente(num);
        rowContainer.appendChild(dienteElem);
      });
    }

    // Renderizamos las 4 filas
    renderFila(fila1, 'row1');
    renderFila(fila2, 'row2');
    renderFila(fila3, 'row3');
    renderFila(fila4, 'row4');

    // --- Modal ---
    const modal = document.getElementById('modal');
    const overlay = document.getElementById('overlay');
    const infoDiente = document.getElementById('info-diente');
    const selectEstado = document.getElementById('select-estado');
    const btnAplicar = document.getElementById('btn-aplicar');
    const btnCancelar = document.getElementById('modal-cancelar');

    let currentTooth = null;
    let currentArea  = null;

    // Poblar <select> con las opciones de estado
    (function cargarOpcionesEnSelect() {
      estadoOpciones.forEach((op) => {
        const optionEl = document.createElement('option');
        optionEl.value = op.label;       // ejemplo: "caries"
        optionEl.textContent = op.label; // lo que se muestra en el select
        optionEl.setAttribute('data-color', op.color);
        selectEstado.appendChild(optionEl);
      });
    })();

    function abrirModal(toothNumber, area) {
      currentTooth = toothNumber;
      currentArea  = area;
      infoDiente.textContent = `Diente ${toothNumber} - Zona: ${area}`;
      modal.style.display = 'block';
      overlay.style.display = 'block';

      // Seleccionar la opción actual en el <select> según lo que tenga guardado
      const estadoActual = toothStates[toothNumber][area]; 
      // Buscamos la opción que coincida con .label
      Array.from(selectEstado.options).forEach(option => {
        if (option.value === estadoActual.label) {
          option.selected = true;
        }
      });
    }

    // Botón "Aplicar": selecciona la opción del <select> y pinta la zona
    btnAplicar.addEventListener('click', () => {
      
      const selectedValue = selectEstado.value; 
      const selectedOption = selectEstado.querySelector(`option[value="${selectedValue}"]`);
      if (!selectedOption) return;

      // Obtenemos el color
      const color = selectedOption.getAttribute('data-color');

      // Actualizamos el objeto global
      toothStates[currentTooth][currentArea] = {
        label: selectedValue,
        color: color
      };

      // Pintamos visualmente
      pintarZona(currentTooth, currentArea, color);
      cerrarModal();
    });

    // Botón "Cancelar"
    btnCancelar.addEventListener('click', cerrarModal);

    function cerrarModal() {
      
      modal.style.display = 'none';
      overlay.style.display = 'none';
    }

    // Pintar una zona de un diente
    function pintarZona(tooth, area, color) {
      const dienteElem = document.querySelector(`.diente[data-diente='${tooth}']`);
      if (!dienteElem) return;
      const zonaElem = dienteElem.querySelector(`[data-area='${area}']`);
      if (zonaElem) {
        zonaElem.style.backgroundColor = color;
      }
    }

    
  </script>

