<div>
  <table id="userTable" class="table " style="width:100%">
      <thead>
          <tr>
              <th>ID</th>
              <th>Avatar</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Rol</th>
              <th>ver</th>
              <th>Acciones</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($doctores as $user)
              <tr>
                  <td>{{ $user->id }}</td>
                  <td><img src="{{asset( 'storage/'. $user->avatar)  ?? user_default() }}" alt="{{asset( 'storage/'. $user->avatar) }}" class="circle_avatar"></td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{$user->roles->first()->name}}</td>
                  <td>
                      <a href="{{route('agenda.index' , [$user->id, 'paciente'])}}"  >
                          {!! iconos('add') !!}
                      </a>
                  </td>
                  <td class=" ">
                      <a href=""  >
                          {!! iconos('edit') !!}
                      </a>
                      <a href="#"  class="ml-4" >
                          {!! iconos('delete') !!}
                      </a>
                  </td>
              </tr>
          @endforeach
         
      </tbody>
    </table>
   
    <script>
      $(document).ready(function() {
        
          $('#userTable').DataTable({
              "language":{
                  "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
              },
              "pagingType": "simple_numbers",
              
          });
          
         
      });
  </script>
</div>
