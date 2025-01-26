<style>

</style>
<div>
    <table id="userTable" class="table  " style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Edad</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Aciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><img src="{{ asset('storage/' . $user->avatar) ?? user_default() }}"
                            alt="{{ asset('storage/' . $user->avatar) }}" class="circle_avatar"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->edad }}</td>
                    <td>{{ $user->cedula }}</td>
                    <td>{{ $user->telefono }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->first()->name }}</td>

                    <td class=" flex justify-center gap-2">

                        @if ($type === 'paciente')
                            <a class="pointer" href="{{ route('historia-medica.index', [$user->id, 'paciente']) }}">
                                {!! iconos('historia') !!}
                            </a>
                        @endif
                        <a class="pointer btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                            data-cedula="{{ $user->cedula }}" data-edad="{{ $user->edad }}"
                            data-telefono="{{ $user->telefono }}" data-email="{{ $user->email }}"
                            data-rol="{{ $user->roles->first()->name }}" href="javascript:void(0)">
                            {!! iconos('edit') !!}
                        </a>
                        <a class="pointer btn-delete" data-id="{{ $user->id }}">
                            {!! iconos('delete') !!}
                        </a>

                    </td>

                </tr>
            @endforeach

        </tbody>
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editUserForm" method="post"  action="{{ route('usuarios.udate' , $user->id) }}"  enctype="multipart/form-data" >
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editUserId" name="id">
                            <div class="mb-3 input">
                                <label for="editUserName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editUserName" name="name" required>
                            </div>
                         
                            <div class="mb-3 input">
                                <label for="editUserCedula" class="form-label">Cédula</label>
                                <input type="text" class="form-control" id="editUserCedula" name="cedula" required>
                            </div>
                            <div class="mb-3 input">
                                <label for="editUserEdad" class="form-label">Edad</label>
                                <input type="number" class="form-control" id="editUserEdad" name="edad" required>
                            </div>
                            <div class="mb-3 input">
                                <label for="editUserTelefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="editUserTelefono" name="telefono"
                                    required>
                            </div>
                            <!--div class="mb-3 input">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email" required>
                            </div-->
                            <div class="mb-3 input">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <x-input_file label="Subir imagen" name="imagen" />
                            </div>
                            <x-input_select name="role" :required="true" label="Rol" :options="['4' => 'Administrador', '2' => '', '3' => 'paciente']" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </table>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pagingType": "simple_numbers",

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Acción para abrir el modal de edición con los datos cargados
            $('#userTable').on('click', '.btn-edit', function() {
                const row = $(this).closest('tr');
                const id = row.find('td:eq(0)').text();
                const name = row.find('td:eq(2)').text();
                const cedula = row.find('td:eq(3)').text();
                const edad = row.find('td:eq(4)').text();
                const telefono = row.find('td:eq(5)').text();
                const email = row.find('td:eq(6)').text();
                const rol = row.find('td:eq(7)').text();

                // Llenar el modal con los datos del usuario
                $('#editUserId').val(id);
                $('#editUserName').val(name);
                $('#editUserCedula').val(cedula);
                $('#editUserEdad').val(edad);
                $('#editUserTelefono').val(telefono);
                $('#editUserEmail').val(email);
                $('#editUserRol').val(rol);

                // Abrir el modal
                $('#editUserModal').modal('show');
            });

            // Acción para confirmar eliminación
            $('#userTable').on('click', '.btn-delete', function() {
                const row = $(this).closest('tr');
                const id = row.find('td:eq(0)').text();
                const name = row.find('td:eq(2)').text();

                Swal.fire({
                    title: `¿Está seguro de eliminar a ${name}?`,
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Realizar solicitud AJAX para eliminar usuario
                        $.ajax({
                            url: ``, // Cambia la ruta si es necesario
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Eliminado',
                                        'El usuario ha sido eliminado exitosamente.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'No se pudo eliminar el usuario.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Error',
                                    'Ocurrió un error al intentar eliminar el usuario.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

</div>
