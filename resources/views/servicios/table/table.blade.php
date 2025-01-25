<style>

</style>
<div>
    <h2 class="mb-3">
        Lista de Servicios
    </h2>
    <x-modal id="ventaServicio" title="Vender Servicio">
        <form class="form-horizontal" action="{{ route('venta.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" id="editServicioId" name="id" hidden>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Telefono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioDescripcion" class="form-label">Fecga</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="mb-3 input">
                <label for="editServicioNombre" class="form-label">Precio</label>
                <input type="number" id="editUserPrecio" name="precio" class="form-control" required>
            </div>
            <div class="">
                <button class=" btn-default " type="submit">Editar</button>
            </div>
        </form>
    </x-modal>
    <table id="servicioTable" class="table  " style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Aciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $items)
                <tr>
                    <td>{{ $items->id }}</td>
                    <td><img src="{{ asset('storage/' . $items->imagen) ?? user_default() }}"
                            alt="{{ asset('storage/' . $items->imagen) }}" class="circle_avatar"></td>
                    <td>{{ $items->nombre }}</td>
                    <td>{{ $items->descripcion }}</td>
                    <td>{{ $items->precio }}</td>

                    <td class=" flex justify-center gap-2">

                        <a class="pointer btn-edit" data-id="{{ $items->id }}" data-nombre="{{ $items->nombre }}"
                            data-precio="{{ $items->precio }}" data-descripcion="{{ $items->descripcion }}"
                            data-precio="{{ $items->precio }}" href="javascript:void(0)">
                            {!! iconos('edit') !!}
                        </a>
                        <a class="pointer" data-bs-toggle="modal" data-bs-target="#ventaServicio">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bag-check-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0m-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z" />
                            </svg>
                        </a>
                        <a class="pointer btn-delete" data-id="{{ $items->id }}">
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
                    <form id="editUserForm" method="POST">
                        @csrf
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
                                <input type="text" class="form-control" id="editUserCedula" name="cedula"
                                    required>
                            </div>
                            <div class="mb-3 input">
                                <label for="editUserEdad" class="form-label">Edad</label>
                                <input type="number" class="form-control" id="editUserEdad" name="edad"
                                    required>
                            </div>
                            <div class="mb-3 input">
                                <label for="editUserTelefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="editUserTelefono" name="telefono"
                                    required>
                            </div>
                            <div class="mb-3 input">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email"
                                    required>
                            </div>
                            <div class="mb-3 input">
                                <label for="editUserRol" class="form-label">Rol</label>
                                <input type="text" class="form-control" id="editUserRol" name="rol" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
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
            $('#servicioTable').on('click', '.btn-edit', function() {
                const row = $(this).closest('tr');
                const id = row.find('td:eq(0)').text();
                const nombre = row.find('td:eq(2)').text();
                const descripcion = row.find('td:eq(3)').text();
                const precio = row.find('td:eq(4)').text();
                // Llenar el modal con los datos del usuario
                $('#editServicioId').val(id);
                $('#editServicioNombre').val(nombre);
                $('#editServicioDescripcion').val(descripcion);
                $('#editUserPrecio').val(precio);

                // Abrir el modal
                $('#editServicioModal').modal('show');
            });

            // Acción para confirmar eliminación
            $('#servicioTable').on('click', '.btn-delete', function() {
                const row = $(this).closest('tr');
                const id = row.find('td:eq(0)').text();
                const name = row.find('td:eq(2)').text();

                Swal.fire({
                    title: `¿Está seguro de eliminar el siguiente servicio ${name}?`,
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    console.log(id);
                    console.log(result);
                    url = `{{ route('servicios.delete', '*') }}`.replace('*', id);
                    console.log(url);
                    if (result.isConfirmed) {
                        // Realizar solicitud AJAX para eliminar usuario
                        $.ajax({
                            url: `${url}`, // Cambia la ruta si es necesario
                            method: 'get',
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
            $('#servicioTable').on('click', 'a[data-bs-target="#ventaServicio"]', function() {
                const row = $(this).closest('tr'); // Obtener la fila
                const precio = row.find('td:eq(4)')
            .text(); // Obtener el precio de la columna correspondiente

                // Asignar el precio al input del modal
                $('#editUserPrecio').val(precio.trim());
                $('#editServicioId').val(row.find('td:eq(0)').text());
                // Abrir el modal
                $('#ventaServicio').modal('show');
            });
        });
    </script>

</div>
