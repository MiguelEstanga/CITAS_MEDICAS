@extends('layout.app')

@section('content')
    <div class="mb-2 header-container">
        <button class="btn btn-default btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal1"> Crear Usuario </button>
    </div>
    <div class="table-container">
        <livewire:user-table />
    </div>

   
@endsection
