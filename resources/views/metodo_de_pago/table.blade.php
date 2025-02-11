<style>

</style>
<div>
    <table id="tabelMetodo" class="table  " style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($metodoPago as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                   
                    <td class=" flex justify-center gap-2">
                        <a class="pointer btn-edit" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                            data-created_at="{{ $item->created_at }}"
                            href="javascript:void(0)">
                            {!! iconos('edit') !!}
                        </a>

                        <a class="pointer btn-delete" data-id="{{ $item->id }}">
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
                        action="{{ route('metodo-de-pago.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">
                                Editar metodo de pago
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editUserId" name="id">
                            <x-input name="name" :required="true" label="Nombre" type="text" placeholder="Nombre" id="name" />
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
            $('#tabelMetodo').DataTable({
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
            $('#tabelMetodo').on('click', '.btn-edit', function() {
                // Obtener los datos del usuario desde los atributos data-* del botón
                const id = $(this).data('id');
                const name = $(this).data('name');
           

                // Llenar el modal con los datos del usuario
                $('#name').val(name);
                $('#editUserId').val(id);
                // Abrir el modal
                $('#editUserModal').modal('show');
            });

            // Acción para confirmar eliminación
            $('#tabelMetodo').on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                const name = $(this).closest('tr').find('td:eq(1)').text();

                Swal.fire({
                    title: `¿Está seguro de  eliminar el metodo de pago ${name}?`,
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = `{{ route('metodo-de-pago.destroy', ':id') }}`.replace(':id', id);

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Eliminado',
                                        'El metodo de pago  ha sido eliminado exitosamente.',
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
