@extends('layout.app')
@section('content')

  <div class="table-container sombra">
    @include('historia_medica.odontograma_sho') 
  </div>
  
<div class=" sombra mb-4">
   <table class="">
       <thead>
           <tr>
               <th>Diagnóstico</th>
               <th>Observacion</th>
               <th>Fecha</th>
               <th>A cuenta</th>
               <th>Saldo</th>
               <th>Cancelado</th>
           </tr>
       </thead>
       <tbody>
           <tr>
               <td>{{ $presupuesto->diagnostico }}</td>
               <td>{{ $presupuesto->observacion }}</td>
               <td>{{ $presupuesto->fecha }}</td>
               <td>{{ $presupuesto->a_cuenta }}</td>
               <td>{{ $presupuesto->saldo }}</td>
               <td>{{ $presupuesto->cancelado }}</td>
           </tr>
       </tbody>
   </table>
</div>



@endsection
  
