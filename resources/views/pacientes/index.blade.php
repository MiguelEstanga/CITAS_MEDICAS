@extends('layout.app')

@section('content')
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="mb-2">
        <div class="">
            <button class="btn-default auto" data-bs-toggle="modal" data-bs-target="#modal1"> Crear nuevo paciente</button>
        </div>
    </div>

    <div class="table-container">
        <h4 class=" alert">
            {{ $type === 'paciente' ? 'Lista de pacientes' : 'Lista de usuarios administrativos' }}
        </h4>
        @include('pacientes.table.pacientes')
    </div>

    <x-modal id="modal1" title="Registrar Usuario">

        <form class="form-horizontal" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre" />
            <x-input name="last_name" :required="true" label="Apellido" type="text" placeholder="Apellido" />
            <x-input name="email" :required="true" label="Email" type="text" placeholder="Email" />
            @if ($type === 'paciente')
                <input type="hidden" name="role" value="3">
                <input type="text" hidden name="password" value="12345678">
            @else
                <x-input name="password" :required="true" label="Contraseña" type="password" placeholder="Contraseña" />
                <input type="hidden" name="role" value="4">
            @endif
            <x-input name="cedula" :required="true" label="Cedula" type="text" placeholder="Cedula" rew />
            <x-input name="edad" :required="true" label="Edad" type="text" placeholder="Edad" rew />
            <x-input name="telefono" :required="true" label="Telefono" type="telefono" placeholder="telefono" rew />
            {{ $type }}

            <x-input_file label="Subir imagen" name="imagen" />

            <div class="">
                <button class=" btn-default " type="submit">Crear</button>
            </div>
        </form>

    </x-modal>
@endsection
