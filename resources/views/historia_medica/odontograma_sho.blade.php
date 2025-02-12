@extends('layout.app')

@section('content')
    @php
        // Orden de piezas en cada fila
        $fila1 = ['18', '17', '16', '15', '14', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28'];
        $fila2 = ['55', '54', '53', '52', '51', '61', '62', '63', '64', '65'];
        $fila3 = ['85', '84', '83', '82', '81', '71', '72', '73', '74', '75'];
        $fila4 = ['48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38'];
    @endphp

    <style>
        /* Contenedor general */
        .odontograma-container {
            display: flex;
            flex-direction: column;
            gap: 25px;
            /* Espacio vertical entre filas */
            align-items: center;
        }

        /* Cada fila de dientes */
        .row-dientes {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            /* Espacio horizontal entre dientes */
            justify-content: center;
        }

        /* Contenedor de cada diente (50x50 aprox.) */
        .diente {
            position: relative;
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            border-radius: 50px;
            /* Borde redondo */
            box-sizing: border-box;
        }

        /* Número del diente */
        .numero_diente {
            position: absolute;
            top: -18px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }

        /* Cada zona es un círculo pequeño (12x12) */
        .zona {
            position: absolute;
            width: 14px;
            height: 14px;

            border: 1px solid #000;
            background-color: #fff;
            /* color por defecto */
        }

        /* Coordenadas aproximadas para ubicar cada zona */
        /* Top => cerca del borde superior */
        .zona-top {
            height: 18px;
            width: 18px;
            left: 50%;
            transform: translateX(-50%);
            border-top-left-radius: 39px;
            border-top-right-radius: 39px;
        }

        /* Bottom => cerca del borde inferior */
        .zona-bottom {
            bottom: 0;
            left: 50%;
            width: 18px;
            height: 18px;
            transform: translateX(-50%);
            border-bottom-left-radius: 39px;
            border-bottom-right-radius: 39px;
        }

        /* Left => lado izquierdo */
        .zona-left {
            top: 50%;

            transform: translateY(-50%);
            border-top-left-radius: 39px;
            border-bottom-left-radius: 39px;
            width: 18px;
            height: 14px;
        }

        /* Right => lado derecho */
        .zona-right {
            top: 50%;
            right: 0;
            border-top-right-radius: 39px;
            border-bottom-right-radius: 39px;
            transform: translateY(-50%);
            width: 19px;
        }

        /* Center => el medio */
        .zona-center {
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
        }
    </style>
    <div class="mb-4">
        Paciente : {{ $presupuesto->user->name ?? '' }} {{ $presupuesto->user->last_name ?? '' }} <a class="btn btn-danger" href="{{route('presupuesto.persupuesto_pdf', $presupuesto->id)}}" target="blank">
            PDF
        </a>
    </div>
    <div class=" mb-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Labios</th>
                    <th>Lengua</th>
                    <th>Encimas</th>
                    <th>Atm</th>
                    <th>Carrillos</th>
                    <th>Vestibulos </th>
                    <th>Paladar</th>
                    <th>Piso Lengua</th>
                    <th>Oculacion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $estado->labios }}</td>
                    <td>{{ $estado->lengua }}</td>
                    <td>{{ $estado->encimas }}</td>
                    <td>{{ $estado->atm }}</td>
                    <td>{{ $estado->carrillos }}</td>
                    <td>{{ $estado->vosticulos }}</td>
                    <td>{{ $estado->paladar }}</td>
                    <td>{{ $estado->piso_lengua }}</td>
                    <td>{{ $estado->oculacion }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="odontograma-container table-container sombra p-4">

        <!-- Fila 1 -->
        <div class="row-dientes">
            @foreach ($fila1 as $num)
                @php
                    // Extraemos el array de zonas para este diente (si no existe, es null)
                    $dienteData = $datosOdontograma[$num] ?? null;

                    // Si existe, sacamos el color para cada zona. Si no, default #fff
                    $colorTop = $dienteData['top']['color'] ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft = $dienteData['left']['color'] ?? '#ffffff';
                    $colorRight = $dienteData['right']['color'] ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>

                    <!-- Top -->
                    <div class="zona zona-top" style="background-color: {{ $colorTop }};"></div>
                    <!-- Bottom -->
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <!-- Left -->
                    <div class="zona zona-left" style="background-color: {{ $colorLeft }};"></div>
                    <!-- Right -->
                    <div class="zona zona-right" style="background-color: {{ $colorRight }};"></div>
                    <!-- Center -->
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

        <!-- Fila 2 -->
        <div class="row-dientes">
            @foreach ($fila2 as $num)
                @php
                    $dienteData = $datosOdontograma[$num] ?? null;
                    $colorTop = $dienteData['top']['color'] ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft = $dienteData['left']['color'] ?? '#ffffff';
                    $colorRight = $dienteData['right']['color'] ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top" style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left" style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right" style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

        <!-- Fila 3 -->
        <div class="row-dientes">
            @foreach ($fila3 as $num)
                @php
                    $dienteData = $datosOdontograma[$num] ?? null;
                    $colorTop = $dienteData['top']['color'] ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft = $dienteData['left']['color'] ?? '#ffffff';
                    $colorRight = $dienteData['right']['color'] ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top" style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left" style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right" style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

        <!-- Fila 4 -->
        <div class="row-dientes">
            @foreach ($fila4 as $num)
                @php
                    $dienteData = $datosOdontograma[$num] ?? null;
                    $colorTop = $dienteData['top']['color'] ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft = $dienteData['left']['color'] ?? '#ffffff';
                    $colorRight = $dienteData['right']['color'] ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top" style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left" style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right" style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="table-container sombra m-4">
        <table class="table" id="odontogramaTable">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>A cuenta</th>
                    <th>Saldo</th>
                    <th>Costo</th>
                    <th>Abono</th>
                    <th>Tratamiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $presupuesto->fecha }}</td>
                    <td>{{ $presupuesto->a_cuenta }}</td>
                    <td>{{ $presupuesto->saldo }}</td>
                    <td>{{ $presupuesto->costo }}</td>
                    <td>{{ $presupuesto->abono }}</td>
                    <td>{{ $presupuesto->tratamiento }}</td>
                    <td><button type="button" class="btn btn-primary btn-sm"
                            onclick="abrirModalEditar(  '{{ $presupuesto->tratamiento ?? '' }}', '{{ $presupuesto->id }}', '{{ $presupuesto->fecha }}', '{{ $presupuesto->a_cuenta }}', '{{ $presupuesto->saldo }}', '{{ $presupuesto->costo }}', '{{ $presupuesto->abono }}')">
                            Editar
                        </button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Modal Bootstrap 5 -->
    <div class="modal fade " id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Cabecera del Modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Presupuesto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Cuerpo del Modal (Formulario) -->
                <div class="modal-body">
                    <!--
                Creamos un formulario para editar.
                Usamos method="POST" + @method('PUT') para actualizar.
                Ajusta la ruta según tu controlador (presupuesto.update).
              -->
                    <form id="formEditar" action="{{ route('presupuesto.update', $presupuesto->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-input name="fecha" label="Fecha" required="true" value="{{ old('fecha') }}" :required="true"  id="fecha"/>
                       
                        <x-input name="a_cuenta" label="A cuenta" required="true" value="{{ old('a_cuenta') }}" :required="true"  id="a_cuenta"/>
                        <x-input name="saldo" label="Saldo" required="true" value="{{ old('saldo') }}" :required="true"  id="saldo"/>
                        <x-input name="costo" label="Costo" required="true" value="{{ old('costo') }}" :required="true"  id="costo"/>
                        <x-input name="abono" label="Abono" required="true" value="{{ old('abono') }}" :required="true"  id="abono"/>
                        <x-input name="tratamiento" label="Tratamiento" required="true" value="{{ old('tratamiento') }}" :required="true"  id="tratamiento"/>
                    

                        <!--
                  Aquí podrías agregar más campos según tu modelo,
                  por ejemplo diagnóstico, observación, etc.
                -->
                    </form>
                </div>

                <!-- Footer con el botón de Guardar -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- El botón de Guardar "submit" envía el formulario -->
                    <button type="submit" form="formEditar" class="btn btn-primary">Guardar</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function abrirModalEditar( tratamiento, id, fecha, a_cuenta, saldo, costo, abono) {
          // 1) Llenamos los campos del formulario con los valores que pasamos
          document.getElementById('fecha').value = fecha;
          document.getElementById('a_cuenta').value = a_cuenta;
          document.getElementById('saldo').value = saldo;
          document.getElementById('costo').value = costo;
          document.getElementById('abono').value = abono;
           document.getElementById('tratamiento').value = tratamiento;
          // 2) Ajustamos la acción del formulario al id correspondiente (por si tienes varios)
          //    Por ejemplo, si la ruta es /presupuesto/{id}, actualizamos con el id real
          const formEditar = document.getElementById('formEditar');
          formEditar.action = "{{ url('presupuesto') }}/" + id;
      
          // 3) Abrir el modal (usando Bootstrap 5)
          let modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'), {});
          modalEditar.show();
        }
      </script>
      
    <script>
        $(document).ready(function() {
            $('#odontogramaTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pagingType": "simple_numbers",

            });
        });
    </script>
@endsection
