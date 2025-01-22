@extends('layout.app')

@section('content')
    <div class="mb-2 header-container">
        <p>
          Lista de doctores
        </p>
    </div>
    <div class="table-container">
        @include('doctores.table.doctores')
    </div>
@endsection
