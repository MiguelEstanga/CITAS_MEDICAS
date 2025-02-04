@extends('layout.app')

@section('content')
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="mb-2">
        <div class="">
            <button class="btn-default auto" data-bs-toggle="modal" data-bs-target="#modal1"> Crear nuevo
                {{ $type === 'paciente' ? 'Paciente' : 'Usuario' }}</button>
        </div>
    </div>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="table-container">
        <h4 class=" alert">
            {{ $type === 'paciente' ? 'Lista de pacientes' : 'Lista de usuarios administrativos' }}
        </h4>
        @include('pacientes.table.usuarios')
    </div>
    @php
        $type === 'paciente' ? ($title = 'Registrar pacientes') : ($title = 'Registrar usuarios');
    @endphp
    <x-modal id="modal1" :title="$title">
        <form class="form-horizontal" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <x-input name="last_name" :required="true" label="Apellido" type="text" placeholder="Apellido" />
                @error('last_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <x-input name="direccion" :required="true" label="Direccion" type="text" placeholder="Direccion" />
                @error('direccion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <x-input name="email" :required="true" label="Gmail" type="text" placeholder="Email" id="userEmail"
                    id_label="userEmailLabel" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @if ($type === 'paciente')
                <input type="hidden" name="role" value="3">
                <input type="text" hidden name="password" value="12345678">
                <div class="form-group">
                    <x-input name="antecedentes" :required="true" label="Antecedentes Familiares" type="text"
                        placeholder="Antecedentes Familiares" />
                    @error('antecedentes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @elseif ($type === 'usuario')
                <div class="form-group">
                    <x-input name="password" :required="true" label="Contraseña" type="password"
                        placeholder="Contraseña" />
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <x-input_select name="role" :required="true" label="Rol" :options="$roles" id="role" />
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif
            <div class="form-group">
                <x-input name="cedula" :required="true" label="Cedula" type="number" placeholder="Cedula" />
                @error('cedula')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <x-input name="edad" :required="true" label="Edad" type="number" placeholder="Edad" />
                @error('edad')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <x-input name="telefono" :required="true" label="Telefono" type="number" placeholder="telefono" />
                @error('telefono')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <x-input_file label="Subir imagen" name="imagen" />
                @error('imagen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <button class="btn-default" type="submit">Crear</button>
            </div>
        </form>

    </x-modal>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona el modal por su ID
            const form = document.querySelector('form.form-horizontal');
            const nameInput = form.querySelector('input[name="name"]');
            const lastNameInput = form.querySelector('input[name="last_name"]');
            // Captura todos los inputs numéricos
            const numericInputs = document.querySelectorAll('input[type="number"]');

            numericInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    // Si el valor es menor que 0, lo reinicia a 0
                    if (Number(this.value) < 0) {
                        this.value = 0;
                    }
                });
            });
            form.addEventListener('submit', function(event) {
                const nameValue = nameInput.value;
                const lastNameValue = lastNameInput.value;

                if (/\d/.test(nameValue) || /\d/.test(lastNameValue)) {
                    event.preventDefault();
                    alert('El nombre y apellido no pueden contener números.');
                }
            });
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
