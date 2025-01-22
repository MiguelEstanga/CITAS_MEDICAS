@extends('layout.app')

@section('content')
    @php
        $estado = $solicitud->estado;
    @endphp
    <div class="mb-2 header-container">
        <p>
            Solicitud # {{ $solicitud->id }}
        </p>
    </div>
    <div class="table-container">

        @switch(user()->roles->first()->name)
            @case('doctor')
                <p>Paciente: {{ $solicitud->paciente()->name }}</p>
            @break

            @case('paciente')
                <p>Doctor: {{ $solicitud->doctor()->name }}</p>
            @break

            @default
                <p>Doctor: {{ $solicitud->doctor()->name }}</p>
        @endswitch

        <p>Descripción: </p>
        <p>{{ $solicitud->descripcion }}</p>
        <hr>
        <p> Sintomas descritos por el paciente: </p>
        <ul>
            @foreach ($solicitud->sintomas() as $sintoma)
                <li>{{ $sintoma->sintomas }}</li>
            @endforeach
        </ul>
        <hr>
        <p> Estado: </p>
        <p>{{ $estado }}</p>
        <hr>
        <p> Fecha de solicitud: </p>
        <p>{{ $solicitud->created_at }}</p>
        <hr>

        @switch(user()->roles->first()->name)
            @case('doctor')
                <form action="{{ route('doctores.responder_solicitud_store', $solicitud->id) }}" method="POST" class="form-container">
                    @csrf
                    <x-input_select name="estado" :required="true" label="Estado" :options="['pendiente' => 'pendiente', 'aceptado' => 'aceptado', 'rechazado' => 'rechazado']" />
                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Responder solicitud..."
                        required></textarea>
                    <div class="mt-4">
                        <button class=" btn-default " type="submit">Responder</button>
                    </div>
                </form>
            @break

            @case('paciente')
                @switch($solicitud->estado)
                    @case('pendiente')
                        <p>No hay respuesta aun</p>
                    @break

                    @case('aceptado')
                       
                    @break

                    @default
                        <a href="{{ route('doctores.ver_solicitud') }}" class="btn btn-primary">Volver</a>
                @endswitch
            @break

            @default
                @switch($solicitud->estado)
                    @case('pendiente')
                        <p>No hay respuesta aun</p>
                    @break

                    @case('aceptado')
                       
                    @break

                    @default
                        <a href="{{ route('doctores.ver_solicitud') }}" class="btn btn-primary">Volver</a>
                @endswitch
        @endswitch

    </div>

    @if ($solicitud->conversacion->count() > 0)
        <div class="table-container mt-4">
            <p>Respuestas: </p>


            @foreach ($solicitud->conversacion as $respuesta)
                <div class="table-container mt-4">
                    <p>Usuario: {{ $respuesta->user_type }}</p>
                    <p>Mensaje: {{ $respuesta->mensaje }}</p>
                </div>
            @endforeach

            <form action="{{ route('doctores.conversacion_store', $solicitud->id) }}" method="POST"
                class="form-container">
                @csrf

                <textarea name="mensaje" id="descripcion" rows="4" class="form-control" placeholder="Responder solicitud..."
                    required></textarea>
                <div class="mt-4">
                    <button class=" btn-default " type="submit">Responder</button>
                </div>
            </form>
        </div>
    @endif
@endsection
