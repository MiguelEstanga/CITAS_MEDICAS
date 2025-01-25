<div>
  <!-- Modal de edición -->
  <div class="modal fade" id="ventaServicio" tabindex="-1" aria-labelledby="ventaServicioLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <form id="editVentaForm" method="POST" action="{{ route('venta.update') }}">
                  @csrf
                  @method('PUT')
                 
                  <div class="modal-header">
                      <h5 class="modal-title" id="ventaServicioLabel">Editar Venta</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <input type="hidden" id="editVentaId" name="id">
                      <div class="mb-3 input">
                          <label for="editVentaNombre" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="editVentaNombre" name="nombre" required>
                      </div>
                      <div class="mb-3 input">
                          <label for="editVentaApellido" class="form-label">Apellido</label>
                          <input type="text" class="form-control" id="editVentaApellido" name="apellido" required>
                      </div>
                      <div class="mb-3 input">
                          <label for="editVentaCedula" class="form-label">Cédula</label>
                          <input type="text" class="form-control" id="editVentaCedula" name="cedula" required>
                      </div>
                      <div class="mb-3 input">
                          <label for="editVentaTelefono" class="form-label">Teléfono</label>
                          <input type="text" class="form-control" id="editVentaTelefono" name="telefono" required>
                      </div>
                      <div class="mb-3 input">
                          <label for="editVentaFecha" class="form-label">Fecha</label>
                          <input type="date" class="form-control" id="editVentaFecha" name="fecha" required>
                      </div>
                      <div class="mb-3 input">
                          <label for="editVentaPrecio" class="form-label">Precio</label>
                          <input type="number" class="form-control" id="editVentaPrecio" name="precio" required>
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

  <!-- Tabla de ventas -->
  <table id="ventasTable" class="table" style="width:100%">
      <thead>
          <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Cédula</th>
              <th>Teléfono</th>
              <th>Fecha</th>
              <th>Precio</th>
             
          </tr>
      </thead>
      <tbody>
          @foreach ($ventas as $items)
              <tr>
                  <td>{{ $items->id }}</td>
                  <td>{{ $items->nombre }}</td>
                  <td>{{ $items->apellido }}</td>
                  <td>{{ $items->cedula }}</td>
                  <td>{{ $items->telefono }}</td>
                  <td>{{ $items->fecha }}</td>
                  <td>{{ $items->precio }}{{ precio() }}</td>
                  <!--td>
                   
                      <a class="btn-edit" href="javascript:void(0)">
                          {!! iconos('edit') !!}
                      </a>
                    
                      <a class="btn-delete" href="javascript:void(0)">
                          {!! iconos('delete') !!}
                      </a>
                  </td -->
              </tr>
          @endforeach
      </tbody>
  </table>

  <script>
      $(document).ready(function () {
          // Inicializar DataTable
          $('#ventasTable').DataTable({
              "language": {
                  "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
              },
              "pagingType": "simple_numbers"
          });

          // Abrir modal con datos de la fila para edición
          $('#ventasTable').on('click', '.btn-edit', function () {
              const row = $(this).closest('tr');
              const id = row.find('td:eq(0)').text();
              const nombre = row.find('td:eq(1)').text();
              const apellido = row.find('td:eq(2)').text();
              const cedula = row.find('td:eq(3)').text();
              const telefono = row.find('td:eq(4)').text();
              const fecha = row.find('td:eq(5)').text();
              const precio = row.find('td:eq(6)').text();

              // Llenar el formulario del modal con los datos
              $('#editVentaId').val(id.trim());
              $('#editVentaNombre').val(nombre.trim());
              $('#editVentaApellido').val(apellido.trim());
              $('#editVentaCedula').val(cedula.trim());
              $('#editVentaTelefono').val(telefono.trim());
              $('#editVentaFecha').val(fecha.trim());
              $('#editVentaPrecio').val(precio.trim());

              // Mostrar el modal
              $('#ventaServicio').modal('show');
          });

          // Confirmación para eliminar
          $('#ventasTable').on('click', '.btn-delete', function () {
              const row = $(this).closest('tr');
              const id = row.find('td:eq(0)').text();
              const nombre = row.find('td:eq(1)').text();

              Swal.fire({
                  title: `¿Está seguro de eliminar la venta de ${nombre}?`,
                  text: "Esta acción no se puede deshacer.",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sí, eliminar',
                  cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.isConfirmed) {
                      const url = `{{ route('venta.destroy', ':id') }}`.replace(':id', id);

                      // Realizar la solicitud AJAX
                      $.ajax({
                          url: url,
                          method: 'DELETE',
                          data: {
                              _token: '{{ csrf_token() }}'
                          },
                          success: function (response) {
                              if (response.success) {
                                  Swal.fire(
                                      'Eliminado',
                                      'La venta ha sido eliminada exitosamente.',
                                      'success'
                                  ).then(() => {
                                      location.reload();
                                  });
                              } else {
                                  Swal.fire(
                                      'Error',
                                      'No se pudo eliminar la venta.',
                                      'error'
                                  );
                              }
                          },
                          error: function () {
                              Swal.fire(
                                  'Error',
                                  'Ocurrió un error al intentar eliminar la venta.',
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
