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
    <div id="formulario-container" class="formulario table-container mt-2 mb-4 sombra">
        <h2>
            Nuevo Tratamiento
        </h2>
        <form action="" method="POST" id="formHistoria">
            @csrf
            <x-input name="diagnostico" label="Diagnóstico" required="true" value="{{ old('diagnostico') }}"
                :required="true" />
            <x-input name="observacion" label="Observación" required="true" value="{{ old('observacion') }}"
                :required="true" />
            <x-input name="tratamiento" label="Tratamiento" required="true" value="{{ old('Tratamiento') }}"
                :required="true" />
            <x-input name="motivo_consulta" label="Motivo de Consulta" required="true" value="{{ old('motivo_consulta') }}"
                :required="true" />
            <x-input_select name="metodo_de_pago" label="Metodo de Pago" required="true" :required="true"
                :options="$metodo_pagos" />
            <input value="{{ $usuario->id }}" name="id_usuario" hidden >
            <div class="row container" style="margin: auto;">
                <div class="col-2">
                    <x-input name="fecha" type="date" label="Fecha" required="true" value="{{ old('fecha') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="a_cuenta" label="A/cuenta" required="true" value="{{ old('a_cuenta') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="saldo" label="Saldo" required="true" value="{{ old('saldo') }}" type="number"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="costo" label="Costo" required="true" value="{{ old('saldo') }}" type="number"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="abono" label="Abono" required="true" value="{{ old('saldo') }}" type="number"
                        :required="true" />
                </div>
            </div>
            <div class="container mb-3 mt-4">
                <h2>
                    Tratamiento
                </h2>
            </div>
            <div class="row container" style="margin: auto;">
                <div class="col-2">
                    <x-input name="labios" label="Labios" required="true" value="{{ old('tratamiento') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="lengua" label="Lengua" required="true" value="{{ old('tratamiento') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="encimas" label="Encimas" required="true" value="{{ old('tratamiento') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="atm" label="Atm" required="true" value="{{ old('tratamiento') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="carrillos" label="Carrillos" required="true" value="{{ old('carrillos') }}"
                        :required="true" />
                </div>


            </div>

            <div class="row container" style="margin: auto;">
                <div class="col-2">
                    <x-input name="vosticulos" label="Vosticulos" required="true" value="{{ old('vosticulos') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="encimas" label="Encimas" required="true" value="{{ old('encimas') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="paladar" label="Paladar" required="true" value="{{ old('paladar') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="piso_lengua" label="Piso deLengua" required="true" value="{{ old('piso_lengua') }}"
                        :required="true" />
                </div>
                <div class="col-2">
                    <x-input name="oculacion" label="Oclusión " required="true" value="{{ old('oculacion') }}"
                        :required="true" />
                </div>
            </div>

            <div class="form-check form-switch container">
                <input class="form-check-input" type="checkbox" name="cancelado" role="switch"
                    id="flexSwitchCheckDefault" onchange="updateStatus(this)">
                <label class="form-check-label" for="flexSwitchCheckDefault" id="statusLabel">Pagado</label>
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
            <a class="btn btn-danger" href="{{ route('reporte.presupuesto', $id_usuario) }}" target="blank">Generar
                PDF</a>
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
            const metodo_de_pago = form.querySelector('[name="metodo_de_pago"]').value;
            const abono = form.querySelector('[name="abono"]').value;
            const costo = form.querySelector('[name="costo"]').value;
            const cancelado = form.querySelector('[name="cancelado"]').checked;
            const labios = form.querySelector('[name="labios"]').value;
            const lengua = form.querySelector('[name="lengua"]').value;
            const encimas = form.querySelector('[name="encimas"]').value;
            const atm = form.querySelector('[name="atm"]').value;
            const carrillos = form.querySelector('[name="carrillos"]').value;
            const vosticulos = form.querySelector('[name="vosticulos"]').value;
            const paladar = form.querySelector('[name="paladar"]').value;
            const piso_lengua = form.querySelector('[name="piso_lengua"]').value;
            const oculacion = form.querySelector('[name="oculacion"]').value;
            const tratamiento = form.querySelector('[name="tratamiento"]').value;
            const motivo_consulta = form.querySelector('[name="motivo_consulta"]').value;

            // 3. Construimos el objeto con el odontograma


            // 4. Creamos el objeto con todos los datos
            const payload = {
                diagnostico,
                observacion,
                fecha,
                a_cuenta,
                saldo,
                cancelado,
                odontograma: toothStates,
                id_usuario,
                metodo_de_pago,
                abono,
                costo,
                labios,
                tratamiento,
                lengua,
                encimas,
                atm,
                carrillos,
                vosticulos,
                paladar,
                piso_lengua,
                oculacion,
                motivo_consulta,
                vosticulos,



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
    <script>
        function updateStatus(checkbox) {
            // Obtener el label asociado
            const statusLabel = document.getElementById('statusLabel');

            // Verificar el estado del checkbox
            if (checkbox.checked) {
                statusLabel.textContent = 'Pago';
            } else {
                statusLabel.textContent = 'Deuda';
            }


        }
    </script>
@endsection
