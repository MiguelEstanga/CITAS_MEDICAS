@extends('layout.app')

@section('content')
    <div class="mb-2 header-container text-center">
        <p class="text-white">
            Solicitudes {{ $type }}
        </p>
    </div>
    <div class="table-container">
        <table class="table    " id="solicitudesTable">
            <thead>
                <tr>
                    <th>{{  $type == 'doctor' ? 'Nombre Paciente' : 'Nombre Doctor' }}</th>
                    <th>Avatar</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Responder</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes as $solicitud)
                    @php
                        $user;
                        if ($type === 'doctor') {
                            $user = $solicitud->paciente();
                        } else {
                            $user = $solicitud->doctor();
                        }
                    @endphp
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td> <img src="{{ asset('storage/' . $user->avatar) ?? user_default() }}" alt=""
                                class="circle_avatar"> </td>
                        <td>{{ $solicitud->descripcion }}</td>
                        <td> {{ $solicitud->estado }} </td>
                        @if ($type == 'doctor')
                            
                            <td> <a href="{{ route('doctores.responder_solicitud', $solicitud->id) }}"
                                    class="btn btn-primary">Responder</a> </td>
                        @endif
                        @if ($type === 'paciente')
                                
                            <td> <a href="{{ route('doctores.responder_solicitud', $solicitud->id) }}" class="btn btn-primary">Ver</a> </td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {

            $('#solicitudesTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pagingType": "simple_numbers",

            });


        });
    </script>
@endsection
