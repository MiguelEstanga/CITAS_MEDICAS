<style>

</style>
<div>
    <table id="userTable" class="table  " style="width:100%">
        <thead>
            <tr>
                <th>N</th>
                <th>Paciente</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Gmail</th>
                @if ($type != 'paciente')
                    <th>Rol</th>
                @endif
                <th>Acciones</th>
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
                    @if ($type != 'paciente')
                        <td>{{ $user->roles->first()->name ?? 'n/a' }}</td>
                    @endif

                    <td class=" flex justify-center gap-2">
                        @if ($type === 'paciente')
                            <a class="pointer" href="{{ route('historia-medica.index', [$user->id, 'paciente']) }}">
                                {!! iconos('historia') !!}
                            </a>
                        @endif
                        <a class="pointer btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                            data-cedula="{{ $user->cedula }}" data-edad="{{ $user->edad }}"
                            data-telefono="{{ $user->telefono }}" data-email="{{ $user->email }}"
                            data-rol="{{ $user->roles->first()->id ?? '-1' }}" href="javascript:void(0)">
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
                    <form id="editUserForm" method="post"
                        action="{{ route('usuarios.udate', $usuarios->id ?? '-1') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">
                                {{ $type === 'paciente' ? 'Editar Paciente' : 'Editar Usuario' }}
                            </h5>
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
                            <x-input_select name="role" :required="true" label="Rol" :options="$roles"
                                id="role" />
                            <!--div class="mb-3 input">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email" required>
                            </div-->
                            <div class="mb-3 ">
                                <x-input_file label="Subir imagen" name="imagen" />
                            </div>
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
                // Obtener los datos del usuario desde los atributos data-* del botón
                const id = $(this).data('id');
                const name = $(this).data('name');
                const cedula = $(this).data('cedula');
                const edad = $(this).data('edad');
                const telefono = $(this).data('telefono');
                const email = $(this).data('email');
                const rol = $(this).data('rol'); // Rol actual del usuario

                // Llenar el modal con los datos del usuario
                $('#editUserId').val(id);
                $('#editUserName').val(name);
                $('#editUserCedula').val(cedula);
                $('#editUserEdad').val(edad);
                $('#editUserTelefono').val(telefono);
                $('#editUserEmail').val(email);

                // Configurar el valor seleccionado del select basado en el rol
                $('#role').val(rol).change();

                // Abrir el modal
                $('#editUserModal').modal('show');
            });

            // Acción para confirmar eliminación
            $('#userTable').on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                const name = $(this).closest('tr').find('td:eq(2)').text();

                Swal.fire({
                    title: `¿Está seguro de eliminar a ${name}?`,
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = `{{ route('usuarios.delete', ':id') }}`.replace(':id', id);

                        $.ajax({
                            url: url,
                            method: 'GET',
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
                                    Swal.fire('Error',
                                        'No se pudo eliminar el usuario.', 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error',
                                    'Ocurrió un error al intentar eliminar el usuario.',
                                    'error');
                            },
                        });
                    }
                });
            });
        });
    </script>

</div>
