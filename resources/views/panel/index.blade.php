@extends('layout.app')

@section('content')
    @php
        // En el controlador o directamente en la vista
        $tarjetas = [
            [
                'icon' => 'bi-person-lines-fill',
                'titulo' => 'Usuarios',
                'conteo' => count($usuario),
                'modal' => 'usuario',
            ],
            [
                'icon' => 'bi-bag-check-fill',
                'titulo' => 'Inventario',
                'conteo' => count($inventario),
                'modal' => 'inventario',
            ],
            [
                'icon' => 'bi-capsule',
                'titulo' => 'Medicamentos',
                'conteo' => count($medicamentos),
                'modal' => 'medicamentos',
            ],
            [
                'icon' => 'bi-calendar-event-fill',
                'titulo' => 'Citas',
                'conteo' => count($eventos),
                'modal' => 'reporte',
            ],
        ];

    @endphp

    <div class="estadostocas">
        @foreach ($tarjetas as $tarjeta)
            <div class="baner">
                <div class="header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi {{ $tarjeta['icon'] }}" viewBox="0 0 16 16">
                        <!-- SVG icon -->
                    </svg>
                    <h4>{{ $tarjeta['titulo'] }}</h4>
                </div>
                <div>
                    <div class="body">
                        <div class="">
                            {{ $tarjeta['conteo'] }}
                        </div>
                        <div>
                            <a class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#{{ $tarjeta['modal'] }}">Generar reporte</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



        <!--- FIN -->
        <x-modal id="reporte" title="Generar reporte">

            <form class="form-horizontal" action="{{ route('reportes.reporte_presupuesto') }}" method="GET"
                enctype="multipart/form-data">
                <x-input name="fecha_inicio" :required="true" label="Nombre" type="date" placeholder="fecha_inicio" />
                <x-input name="fecha_fin" :required="true" label="Apellido" type="date" placeholder="fecha_fin" />
                <div class="container">
                    <button class=" btn-default " type="submit">Crear</button>
                </div>
            </form>

        </x-modal>
        <x-modal id="inventario" title="Generar inventario">
            <form class="form-horizontal" action="{{ route('reportes.reporte_inventario') }}" method="GET"
                enctype="multipart/form-data">
                <x-input name="fecha_inicio" :required="true" label="Nombre" type="date" placeholder="fecha_inicio" />
                <x-input name="fecha_fin" :required="true" label="Apellido" type="date" placeholder="fecha_fin" />
                <div class="container">
                    <button class=" btn-default " type="submit">Generar</button>
                </div>
            </form>

        </x-modal>
        <x-modal id="medicamentos" title="Generar medicamentos">
            <form class="form-horizontal" action="{{ route('reportes.reporte_inventario') }}" method="GET"
                enctype="multipart/form-data">
                <x-input name="fecha_inicio" :required="true" label="Nombre" type="date" placeholder="fecha_inicio" />
                <x-input name="fecha_fin" :required="true" label="Apellido" type="date" placeholder="fecha_fin" />
                <div class="container">
                    <button class=" btn-default " type="submit">Generar</button>
                </div>
            </form>

        </x-modal>
        <x-modal id="usuario" title="Generar usuario">
            <form class="form-horizontal" action="{{ route('reportes.reporte_usuario') }}" method="GET"
                enctype="multipart/form-data">
                <x-input name="fecha_inicio" :required="true" label="Nombre" type="date" placeholder="fecha_inicio" />
                <x-input name="fecha_fin" :required="true" label="Apellido" type="date" placeholder="fecha_fin" />
                <div class="container">
                    <button class=" btn-default " type="submit">Generar reporte de usuario</button>
                </div>
            </form>

        </x-modal>
    </div>

    <div class="table-container p-4">
        <div class="imagen_baner">
            <img src="{{ asset('storage/' . user()->avatar) ?? user_default() }}"
                alt="{{ asset('storage/' . user()->avatar) }}" width="200px" height="200px">
        </div>
        <form id="editUserForm" method="POST" action="{{ route('admin.user.update', user()->id) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="modal-body">
                <input type="hidden" id="editUserId" name="id">
                <x-input_file label="" name="imagen" />
                <div class="mb-3 input">
                    <label for="editUserName" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="editUserName" name="name"
                        value="{{ user()->name }}" required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserName" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="editUserName" name="last_name"
                        value="{{ user()->last_name }}" required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserCedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control" id="editUserCedula" name="cedula"
                        value="{{ user()->cedula }}" required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserEdad" class="form-label">Edad</label>
                    <input type="number" class="form-control" id="editUserEdad" name="edad"
                        value="{{ user()->edad }}" required>
                </div>
                <div class="mb-3 input">
                    <label for="editUserTelefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="editUserTelefono" name="telefono"
                        value="{{ user()->telefono }}" required>
                </div>

                <div class="mb-3 input">
                    <label for="editUserEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editUserEmail" name="email"
                        value="{{ user()->email }}" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>

            </div>
        </form>
    </div>
    <style>
        .estadostocas {
            display: flex;

            margin-bottom: 100px;
            gap: 10px;
        }


        .header {
            display: flex;
            flex-direction: row;
            gap: 20px;
            margin: 10px;
            padding: 10px;
            align-items: center;
            justify-content: space-between;
        }

        .baner {
            border-radius: 10px;
            min-width: 200px;
            height: 200px;
            background-color: #f5f5f5;
        }

        .body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 10px;
            padding: 10px;
        }

        .imagen_baner {
            width: 205px;
            border: solid 3px var(--color_menu);
            border-radius: 50%;
            margin: auto;

            img {
                border-radius: 50%;
            }
        }
    </style>
@endsection
