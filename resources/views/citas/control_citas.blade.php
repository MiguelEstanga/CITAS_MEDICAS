@extends('layout.app')

@section('content')
    <div class="table-container mb-4">
        <x-user :avatar="$evento->paciente->avatar" :name="$evento->paciente->name" :email="$evento->paciente->email" />
    </div>


    <div class="table-container">
        <div class="">
            @if ($historia_medica == null)
                <button class=" btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal1"> Cargar Historia
                    Medica
                    del paciente
                </button>
            @else
                <button class=" btn btn-outline-primary" disabled data-bs-toggle="modal" data-bs-target="#modal1"> Editar
                    Historia dental
                    del paciente
                </button>
            @endif


        </div>
        <div class="mt-4">
            <h4>
                Historia Medica del paciente
            </h4>
         
            @if ($historia_medica != null)
            <div class="medico-informe">
                <div class="informe-item">
                    <span class="label">Nombre del informe:</span>
                    <span class="value">{{ $historia_medica->nombre_informe }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Antecedentes familiares:</span>
                    <span class="value">{{ $historia_medica->antecedentes_familiares }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Antecedentes personales:</span>
                    <span class="value">{{ $historia_medica->antecedentes_personales }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Motivo de la consulta:</span>
                    <span class="value">{{ $historia_medica->motivo_consulta }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Labios:</span>
                    <span class="value">{{ $historia_medica->labios }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Encimas:</span>
                    <span class="value">{{ $historia_medica->encimas }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Piso de boca:</span>
                    <span class="value">{{ $historia_medica->piso_de_boca }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Vastibulos:</span>
                    <span class="value">{{ $historia_medica->vastibulos }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Paladar:</span>
                    <span class="value">{{ $historia_medica->paladar }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Carrillos:</span>
                    <span class="value">{{ $historia_medica->carrillos }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Lengua:</span>
                    <span class="value">{{ $historia_medica->lengua }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Atm:</span>
                    <span class="value">{{ $historia_medica->atm }}</span>
                </div>
                <div class="informe-item">
                    <span class="label">Oclucion:</span>
                    <span class="value">{{ $historia_medica->oclucion }}</span>
                </div>
            </div>
            @endif

        </div>


        <x-modal id="modal1" title="Registrar Historia Médica">
            <div class="table-container">
                <form action="{{ route('historia-medico.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input :required="true" name="nombre_informe" label="Nombre del informe" />
                    <x-input :required="true" name="antecedentes_familiares"
                        label="Antecedentes familiares Nombre de la enfermedad" />
                    <x-input :required="true" name="antecedentes_personales"
                        label="Antecedentes personales Nombre de la enfermedad" />
                    <x-input :required="true" name="motivo_consulta" label="Motivo de la consulta" />
                    <x-input :required="true" name="labios" label="LABIOS" />
                    <x-input :required="true" name="encimas" label="Encimas" />
                    <x-input :required="true" name="piso_de_boca" label="Piso De Boca" />
                    <x-input :required="true" name="vastibulos" label="Vastibulos" />
                    <x-input :required="true" name="paladar" label="Paladar" />
                    <x-input :required="true" name="carrillos" label="Carrillos" />
                    <x-input :required="true" name="lengua" label="Lengua" />
                    <x-input :required="true" name="atm" label="ATM" />
                    <x-input :required="true" name="Oclucion" label="Oclucion" />
                    <input type="hidden" name="id_control_citas" value="{{ $evento->id }}">
                    <input type="hidden" name="id_paciente" value="{{ $control_citas->id }}">
                    <div class=" mt-4">
                        <button class=" btn btn-outline-primary " type="submit">Registrar Historia Médica</button>
                    </div>
                </form>
            </div>
        </x-modal>
    </div>
    <div class="table-container mt-4">

        <button class=" btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#presupuesto"> Cargar presupuesto
        </button>
       <div class="mb-4">
        <a href="{{ route('presupuesto.persupuesto_pdf' , $control_citas->id)}}" class="btn btn-outline-danger" >Generar PDF</a>
       </div>
        <x-modal id="presupuesto" title="Cargar presupuesto">
            <div class="table-container">
                <form action="{{ route('presupuesto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input :required="true" name="fecha" label="Fecha" type="date" />
                    <x-input :required="true" name="tratamiento" label="Tratamiento" />
                    <x-input :required="true" name="costo" label="Costo" />
                    <x-input :required="true" name="abono" label="Abono" />
                    <x-input :required="true" name="saldo" label="Saldo" />
                    <x-input :required="true" name="firma" label="Firma" />
                    <input type="hidden" name="id_control_citas" value="{{ $evento->id }}">
                    <input type="hidden" name="id_paciente" value="{{ $control_citas->id }}">
                    <div class=" mt-4">
                        <button class=" btn btn-outline-primary " type="submit">Registrar Historia Médica</button>
                    </div>
                </form>
            </div>
        </x-modal>
        <x-modal id="editModal" title="Editar Presupuesto">
            <div class="table-container">
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Usamos PUT porque es una actualización -->

                    <!-- Campos del formulario para editar -->
                    <div class="mb-3 form-floating ">
                        <label for="floatingInput">Fecha</label>
                        <input class="form-control" name="fecha" label="Fecha" id="editFecha" />
                    </div>
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Tratamiento</label>
                        <input class="form-control" name="tratamiento" label="Tratamiento" id="editTratamiento" />
                    </div>
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Costo</label>
                        <input class="form-control" name="costo" label="Costo" id="editCosto" />
                    </div>
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Abono</label>
                        <input class="form-control" name="abono" label="Abono" id="editAbono" />
                    </div>
                    <div class="form-floating mb-3">
                        <label for="floatingInput">Saldo</label>
                        <input class="form-control" name="saldo" label="Saldo" id="editSaldo" />
                    </div>
                    <div class="mb-3 form-floating mb-3">
                        <label for="floatingInput">Firma</label>
                        <input class="form-control" name="firma" label="Firma" id="editFirma" />
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-outline-primary" type="submit">Actualizar Presupuesto</button>
                    </div>
                </form>
            </div>
        </x-modal>
        <table class="table-container" id="presupuestoTable">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tratamiento Relacionado</th>
                    <th>Costo</th>
                    <th>Abono</th>
                    <th>Saldo</th>
                    <th>Firma</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($control_citas->presupuesto as $presupuesto)
                    <tr>
                        <td>{{ $presupuesto->fecha }}</td>
                        <td>{{ $presupuesto->tratamiento }}</td>
                        <td>{{ $presupuesto->costo }}</td>
                        <td>{{ $presupuesto->abono }}</td>
                        <td>{{ $presupuesto->saldo }}</td>
                        <td>{{ $presupuesto->firma }}</td>
                        <td>
                            <a type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="{{ $presupuesto->id }}" data-fecha="{{ $presupuesto->fecha }}"
                                data-tratamiento="{{ $presupuesto->tratamiento }}"
                                data-costo="{{ $presupuesto->costo }}" data-abono="{{ $presupuesto->abono }}"
                                data-saldo="{{ $presupuesto->saldo }}" data-firma="{{ $presupuesto->firma }}">
                                {!! iconos('edit') !!}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#historia_medicaTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "paging": false,
                "searching": false,
                "info": false,
                "ordering": false
            });

            $('#presupuestoTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },

            });

            $('.btn-edit').click(function() {
                // 1. Capturamos los datos del botón de edición
                let id = $(this).data('id');
                let fecha = $(this).data('fecha');
                let tratamiento = $(this).data('tratamiento');
                let costo = $(this).data('costo');
                let abono = $(this).data('abono');
                let saldo = $(this).data('saldo');
                let firma = $(this).data('firma');

                // 2. Actualizamos el formulario con los datos del presupuesto
                var url = `{{route('presupuesto.update' , ':id')}}`.replace(':id', id);
                console.log(url);
                $('#editForm').attr('action', url); // Establecemos la acción del formulario
                $('#editForm').attr('method', 'POST'); // Establecemos el método de la acción
                // Actualizamos los valores de los inputs
                $('#editFecha').val(fecha);
                $('#editTratamiento').val(tratamiento);
                $('#editCosto').val(costo);
                $('#editAbono').val(abono);
                $('#editSaldo').val(saldo);
                $('#editFirma').val(firma);
            });

        });
    </script>
@endsection
