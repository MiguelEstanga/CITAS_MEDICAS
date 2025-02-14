@extends('layout.app')

@section('content')
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="mb-2">
        <div class="">
            <button class="btn-default auto" data-bs-toggle="modal" data-bs-target="#modal1"> Crear nuevo
                Tratamiento</button>
        </div>
    </div>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <x-modal id="modal1" title="Crear tratamiento">
        <form action="{{ route('opciones-tratamiento.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <x-input name="label" :required="true" label="Tratamiento" type="text"
                    placeholder="Tratamiento" />
            </div>
            <div class="form-group">
                <x-input name="color" :required="true" label="Color" type="color"
                    placeholder="Color" />
            </div>
            <div class="form-group">
                <button class="btn-default" type="submit">Crear</button>
            </div>
        </form>
    </x-modal>
    <div class="table-container">
        <h4 class=" alert">
           Tratamientos
        </h4>
        @include('opciones_tratamiento.table.table')
    </div>
@endsection
