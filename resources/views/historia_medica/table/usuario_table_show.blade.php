<table id="userTable"  class="table  " style="width:100%">
    <thead>
        <tr>
            <th>N</th>
            <th>Nombre Y Apellido</th>
           
            <th>Cédula</th>
            <th>Dirección</th>
            <th>Edad</th>
            <th>Teléfono</th>
           
            <th>Email</th>
            <th>Fecha de registro</th>
            <th>Enfermedades\Familiares</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $usuario->id }}</td>
            <td>{{ $usuario->name }}</td>
           
            <td>{{ $usuario->cedula }}</td>
            <td>{{ $usuario->direccion ?? "" }}</td>
            <td>{{ $usuario->edad }}</td>
            <td>{{ $usuario->telefono }}</td>
          
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->created_at ?? 'n/a' }}</td>
            <td>{{ $usuario->antecedentes_familiares ?? 'n/a' }}</td>
        </tr>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "paging": false,         // Desactiva la paginación
            "searching": false,      // Desactiva el cuadro de búsqueda
            "info": false,           // Oculta la información de la tabla (ej. "Mostrando 1 de 10")
            "ordering": false,       // Desactiva el ordenamiento por columnas
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
        });
    });
</script>
