<div>
    <table id="userTable" class="table  " style="width:100%">
        <thead>
            <tr>
                <th>N</th>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Gmail</th>

                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><img src="{{asset( 'storage/'. $user->avatar)  ?? user_default() }}" alt="{{asset( 'storage/'. $user->avatar) }}" class="circle_avatar"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->cedula }}</td>
                    <td>{{ $user->edad }}</td>
                    <td>{{ $user->telefono }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{$user->roles->first()->name}}</td>
                   
                    <td class=" ">
                        <a href="{{route('admin.user.edit' , $user->id)}}"  >
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
