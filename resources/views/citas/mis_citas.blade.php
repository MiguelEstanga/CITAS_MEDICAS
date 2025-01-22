@extends('layout.app')

@section('content')
  <div class="table-container">
      <table class="table " style="width:100%" id="citasTable">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>
                    Paciente
                  </th>
                  <th>Estado</th>
                  <th>precio</th>
                  <th>Pagado</th>
                  <th>Referencia</th>
                  <th>Banco</th>
                  
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($mis_citas as $evento)
                  <tr>
                      <td>{{ $evento->id }}</td>
                      <td>{{ $evento->start }}</td>
                      <td>
                    
                      </td>
                      <td>{{  control_citas($evento->id)->estado  }}</td>
                      <td>{{ precio(control_citas($evento->id)->monto_consulta ?? '0') }}</td>
                      <td>{{control_citas($evento->id)->pagada == true ? 'Si' : 'No'}}</td>
                      <td>{{ control_citas($evento->id)->referencia ?? "No Referencia" }}</td>
                      <td>{{ control_citas($evento->id)->banco  ?? "No Banco" }}</td>
                      <th>
                          <a href="{{route('citas.control_citas' ,control_citas($evento->id)->id )}}" class=" ">
                               {!!
                                 iconos('ojo')
                               !!}
                          </a>
                      </th>
                  </tr>
              @endforeach
         
          </tbody>
      </table>

  </div>
  <script>
       $(document).ready(function() {
          
          $('#citasTable').DataTable({
              "language":{
                  "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
              },
              "pagingType": "simple_numbers",
              
          });
          
         
      });
  </script>
@endsection