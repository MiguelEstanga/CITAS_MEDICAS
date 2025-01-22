@extends('layout.app')

@section('content')
    <div class="mb-2">
        <div class="">
            <button class="btn-default auto" data-bs-toggle="modal" data-bs-target="#modal1"> Crear nuevo paciente</button>
        </div>
    </div>
    
    <div class="table-container">
        <h4 class=" alert">
            Lista de pacientes
        </h4>
        @include('pacientes.table.pacientes')
    </div>

    <x-modal id="modal1" title="Registrar Usuario">

        <form class="form-horizontal" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre" />
            <x-input name="last_name" :required="true" label="Apellido" type="text" placeholder="Apellido" />
            <x-input name="email" :required="true" label="Email" type="text" placeholder="Email" />
            <x-input name="cedula" :required="true" label="Cedula" type="text" placeholder="Cedula" rew />
            <x-input name="edad" :required="true" label="Edad" type="text" placeholder="Edad" rew />
            <x-input name="telefono" :required="true" label="Telefono" type="telefono" placeholder="telefono" rew />
            <x-input_select name="role" :required="true" label="Rol" :options="['1' => 'superusuario', '2' => 'doctor', '3' => 'paciente']" />
            <x-input_file label="Subir imagen" name="imagen" />
            <div class="">
                <button class=" btn-default " type="submit">Crear</button>
            </div>
        </form>

    </x-modal>
@endsection
