@extends('layout.app')

@section('content')
    <div class="mb-2 header-container">
        <button class="btn btn-default btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal1"> Crear Usuario </button>
    </div>
    <div class="table-container">
        <livewire:user-table /> 
    </div>

    <x-modal id="modal1" title="Registrar Usuario">

        <form class="form-horizontal" action="{{ route('admin.user.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf
            <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre" />
            <x-input name="last_name" :required="true" label="Apellido" type="text" placeholder="Apellido" />
            <x-input name="cedula" :required="true" label="Cedula" type="text" placeholder="cedula" rew />
            <x-input name="email" :required="true" label="email" type="email" placeholder="email" rew />
            <x-input name="edad" :required="true" label="Edad" type="text" placeholder="edad" rew />
           
            <x-input name="password" :required="true" label="contraseña" type="password" placeholder="Contraseña" />
            <x-input_select name="role" :required="true" label="Rol" :options="['1' => 'superusuario', '2' => 'doctor' , '3' => 'paciente']" />
            <x-input_file label="Subir imagen" name="imagen"  />
            <div class="container">
                <button class=" btn-default " type="submit">Crear</button>
            </div>
        </form>

    </x-modal>

@endsection
