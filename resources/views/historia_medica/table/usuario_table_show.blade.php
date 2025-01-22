<table id="userTable"  class="table  " style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cedula</th>
            <th>Edad</th>
            <th>Teléfono</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $usuario->id }}</td>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->last_name }}</td>
            <td>{{ $usuario->cedula }}</td>
            <td>{{ $usuario->edad }}</td>
            <td>{{ $usuario->telefono }}</td>
            <td>{{ $usuario->email }}</td>
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
