@extends('layout.app')

@section('content')
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="mb-2">
        <div class="">
            <button class="btn-default auto" data-bs-toggle="modal" data-bs-target="#modal1"> Crear nuevo usuario</button>
        </div>
    </div>

    <div class="table-container">
        <h4 class=" alert">
            {{ $type === 'paciente' ? 'Lista de pacientes' : 'Lista de usuarios administrativos' }}
        </h4>
        @include('pacientes.table.usuarios')
    </div>

    <x-modal id="modal1" title="Registrar Usuarios">
        <form class="form-horizontal" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre" />
            <x-input name="last_name" :required="true" label="Apellido" type="text" placeholder="Apellido" />
            <x-input name="email" :required="true" label="Email" type="text" placeholder="Email" id="userEmail"
                id_label="userEmailLabel" />
            @if ($type === 'paciente')
                <input type="hidden" name="role" value="3">
                <input type="text" hidden name="password" value="12345678">
            @elseif ($type === 'usuario')
                <x-input name="password" :required="true" label="Contraseña" type="password" placeholder="Contraseña" />
                <x-input_select name="role" :required="true" label="Rol" :options="$roles" id="role" />
            @endif
            <x-input name="cedula" :required="true" label="Cedula" type="text" placeholder="Cedula" rew />
            <x-input name="edad" :required="true" label="Edad" type="text" placeholder="Edad" rew />
            <x-input name="telefono" :required="true" label="Telefono" type="telefono" placeholder="telefono" rew />


            <x-input_file label="Subir imagen" name="imagen" />
            <div class="">
                <button class=" btn-default " type="submit">Crear</button>
            </div>
        </form>

    </x-modal>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona el modal por su ID
            const modalElement = document.getElementById('modal1');

            if (modalElement) {
                // Escucha el evento de cuando el modal se muestra
                modalElement.addEventListener('shown.bs.modal', function() {
                    const userEmail = modalElement.querySelector(
                        'input[name="email"]'); // Selecciona el input por su name

                    if (userEmail) {
                        // Agrega el evento input al campo de email
                        userEmail.addEventListener('input', function() {
                            let email = userEmail.value;
                            var url = `{{ route('api.verificacion', '*') }}`.replace('*', email);

                            fetch(url)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Advertencia',
                                            'Este correo electrónico ya está registrado',
                                            'warning'
                                        ).then(() => {

                                        });
                                    } else {

                                    }
                                });
                        });
                    }
                });
            }
        });
    </script>
@endsection
