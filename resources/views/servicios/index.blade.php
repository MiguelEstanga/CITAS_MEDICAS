@extends('layout.app')
@section('content')
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="mb-2">
        <div class="">
            <button class="btn-default auto" data-bs-toggle="modal" data-bs-target="#create_servicio"> Crear nuevo
                paciente</button>
        </div>
    </div>
    <div class="table-container">
        @include('servicios.table.table')
    </div>

    <x-modal id="create_servicio" title="Crear Servicio">
        <form class="form-horizontal" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-input name="nombre" :required="true" label="Nombre" type="text" placeholder="Nombre" />
            <x-input name="descripcion" :required="true" label="Descripcion" type="text" placeholder="Descripcion" />
            <x-input name="imagen" :required="true" label="Imagen" type="file" placeholder="Imagen" />
            <x-input name="precio" :required="true" label="Precio" type="text" placeholder="Precio" />
            <div class="">
                <button class=" btn-default " type="submit">Crear</button>
            </div>
        </form>
    </x-modal>

    <x-modal id="editServicioModal" title="Editar Servicio">
        <form class="form-horizontal" action="{{ route('servicios.udate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" id="editServicioId" name="id" hidden>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Nombre</label>
                <input type="text" id="editServicioNombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioDescripcion" class="form-label">Descripcion</label>
                <input type="text" id="editServicioDescripcion" name="descripcion" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Precio</label>
                <input type="number" id="editUserPrecio" name="precio" class="form-control" required>
            </div>
            <div class="">
                <button class=" btn-default " type="submit">Editar</button>
            </div>
        </form>
    </x-modal>
@endsection
