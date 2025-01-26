@extends('layout.app')

@section('content')
    <div class=" mb-4">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="table-container_show sombra">
        <div class="paciente-info">
            <span class="name">Paciente</span>: {{ $usuario->name }} {{ $usuario->last_name }}
        </div>
        <div>
            
        </div>
        <div class="p-2">
            @include('historia_medica.table.usuario_table_show')
        </div>
    </div>

    <!-- Botón para desplegar el formulario -->
    <button class="btn-default auto mt-4 mb-4" id="toggle-form-btn">
        + Registrar nueva historia
    </button>

    <!-- Formulario oculto inicialmente -->
    <div id="formulario-container" class="formulario table-container mt-2 mb-4 sombra" style="padding: 20px;display: none;">
        <h2>
            Nuevo Tratamiento
        </h2>
        <form action="" method="POST" id="formHistoria">
            @csrf
            <x-input name="diagnostico" label="Diagnostico" required="true" value="{{ old('diagnostico') }}" :required="true" />
            <x-input name="observacion" label="Observación" required="true" value="{{ old('observacion') }}" :required="true" />
            <input value="{{ $id_usuario }}" name="id_usuario" hidden>
            <div class="row">
                <div class="col-4">
                    <x-input name="fecha" type="date" label="Fecha" required="true" value="{{ old('fecha') }}" :required="true" />
                </div>
                <div class="col-4">
                    <x-input name="a_cuenta" label="A cuenta" required="true" value="{{ old('a_cuenta') }}" :required="true" />
                </div>
                <div class="col-4">
                    <x-input name="saldo" label="Saldo" required="true" value="{{ old('saldo') }}" type="number" :required="true"  />
                </div>

            </div>

            <div class="form-check form-switch container">
                <input class="form-check-input" type="checkbox" name="cancelado" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Cancelado</label>
            </div>

            <div class="sombra mt-4 p-3 container" style="border-radius: 5px;">
                @include('historia_medica.odontograma')
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="buttom" class="btn btn-primary" onclick="guardarHistoria(event)">Guardar</button>
            </div>

        </form>
    </div>
    <div class="" style="display:felx; flex-direction: row; gap: 10px;">
        <div>
            <a class="btn btn-danger"  href="{{route('reporte.presupuesto' , $id_usuario)}}" target="blank">Generar PDF</a>
        </div>
        
    </div>
    <div class="table-container_show sombra" style="position: relative;">
        <div class="p-2">
            @include('historia_medica.table.historia_medica')
        </div>
    </div>

    <style>
        .paciente-info {
            background: black;
            color: white;
            height: 50px;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px 5px 0 0;
            font-size: 20px;
        }

        .name {
            color: var(--color_texto) !important;
            font-weight: bold;
        }

        .formulario {
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.5s ease;
        }

        .formulario.collapsed {
            max-height: 0;
            opacity: 0;
        }

        .formulario.expanded {

            /* Ajusta este valor según el tamaño del formulario */
            opacity: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('toggle-form-btn');
            const formularioContainer = document.getElementById('formulario-container');

            toggleButton.addEventListener('click', () => {
                if (formularioContainer.style.display === 'none') {
                    formularioContainer.style.display = 'block';
                    formularioContainer.classList.remove('collapsed');
                    formularioContainer.classList.add('expanded');
                } else {
                    formularioContainer.classList.remove('expanded');
                    formularioContainer.classList.add('collapsed');
                    setTimeout(() => {
                        formularioContainer.style.display = 'none';
                    }, 500); // Duración de la transición
                }
            });
        });

        function guardarHistoria(event) {
            event.preventDefault(); // Evita el envío tradicional

            // 1. Tomamos la referencia al formulario
            const form = document.getElementById('formHistoria');

            // 2. Obtenemos los valores del formulario
            const diagnostico = form.querySelector('[name="diagnostico"]').value;
            const observacion = form.querySelector('[name="observacion"]').value;
            const fecha = form.querySelector('[name="fecha"]').value;
            const a_cuenta = form.querySelector('[name="a_cuenta"]').value;
            const saldo = form.querySelector('[name="saldo"]').value;
            const id_usuario = form.querySelector('[name="id_usuario"]').value;

            const cancelado = form.querySelector('[name="cancelado"]').checked;

            // 3. Construimos el objeto con el odontograma
            const dataOdontograma = {};

            document.querySelectorAll('.seccion').forEach((section) => {
                const tooth = section.getAttribute('data-diente');
                const part = section.getAttribute('data-parte');
                const color = section.style.backgroundColor || '';

                // Asegúrate de inicializar cada diente dentro del objeto
                if (!dataOdontograma[tooth]) {
                    dataOdontograma[tooth] = {
                        superior: '',
                        inferior: '',
                        central: '',
                        izquierda: '',
                        derecha: ''
                    };
                }

                // Asigna el color correspondiente
                dataOdontograma[tooth][part] = color;
            });

            // 4. Creamos el objeto con todos los datos
            const payload = {
                diagnostico,
                observacion,
                fecha,
                a_cuenta,
                saldo,
                cancelado,
                odontograma: dataOdontograma,
                id_usuario: id_usuario
            };

            // 5. Hacemos la petición Fetch a tu ruta Laravel
            fetch("{{ route('presupuesto.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    if (result.success) {
                        location.reload();
                        // Redirigir, limpiar formulario, mostrar mensaje, etc.
                    } else {
                        alert("Error al guardar: " + (result.message || ''));
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert("Ocurrió un error en la petición por favor rellena los campos requeridos.");
                });
        }
    </script>
   
@endsection
