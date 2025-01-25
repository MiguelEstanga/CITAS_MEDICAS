@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-end align-items-center mb-4">
       <x-avatar :user="user()"></x-avatar>
    </div>

    <div class="table-container">
      <h4 class=" alert">
        Lista de ventas
      </h4>
        @include('ventas.table')
    </div>

@endsection