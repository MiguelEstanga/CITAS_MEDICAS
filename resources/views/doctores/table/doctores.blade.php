<div>
  <table id="userTable" class="table  " style="width:100%">
      <thead>
          <tr>
              <th>ID</th>
              <th>Avatar</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Rol</th>
              <th>En mi lista</th>
              <th>Enviar solicitud</th>

          </tr>
      </thead>
      <tbody>
          @foreach ($doctores as $user)
              <tr>
                  <td>{{ $user->id }}</td>
                  <td><img src="{{ asset('storage/' . $user->avatar) ?? user_default() }}"
                          alt="{{ asset('storage/' . $user->avatar) }}" class="circle_avatar"></td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->roles->first()->name }}</td>
                  <td>
                      {!! esta_agregado(['id_paciente' => $user->id, 'id_doctor' => user()->id]) ? 'o' : 'x' !!}
                  </td>
                  <td class=" ">
                      @if (esta_solicitud(['id_paciente' => $user->id, 'id_doctor' => user()->id]))
                          {!! esta_solicitud(['id_paciente' => $user->id, 'id_doctor' => user()->id] , true) !!}
                      @else
                          <a class="pointer" href="{{route('doctores.solicitud' , $user->id)}}">
                              {!! iconos('add2') !!}
                          </a>
                      @endif

                  </td>

              </tr>
          @endforeach

      </tbody>
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
      function confirmarAgregar(idPaciente, idDoctor) {
          console.log(idPaciente);
          console.log(idDoctor);
          Swal.fire({
              title: '¿Está seguro?',
              text: "¿Desea agregar este paciente a su lista?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, agregar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Realizar solicitud AJAX para agregar paciente
                  $.ajax({
                      url: `{{ route('pacientes.agregar_paciente') }}`, // Ruta que manejará la lógica
                      method: 'POST',
                      data: {
                          _token: '{{ csrf_token() }}', // Token CSRF para seguridad
                          id_paciente: idPaciente,
                          id_doctor: idDoctor
                      },
                      success: function(response) {
                          console.log(response);
                          if (response.success) {
                              Swal.fire(
                                  'Agregado',
                                  'El paciente ha sido agregado exitosamente.',
                                  'success'
                              ).then(() => {
                                  location.reload(); // Refrescar la página
                              });
                          } else {
                              Swal.fire(
                                  'Error',
                                  'No se pudo agregar el paciente.',
                                  'error'
                              );
                          }
                      },
                      error: function() {
                          Swal.fire(
                              'Error',
                              'Ocurrió un error al intentar agregar el paciente.',
                              'error'
                          );
                      }
                  });
              }
          });
      }

      function confirmarEliminar(idPaciente, idDoctor) {
          console.log(idPaciente);
          console.log(idDoctor);
          Swal.fire({
              title: '¿Está seguro?',
              text: "¿Desea quitar este paciente a su lista?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, quitar de la lista',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Realizar solicitud AJAX para agregar paciente
                  $.ajax({
                      url: `{{ route('pacientes.quitar_paciente') }}`, // Ruta que manejará la lógica
                      method: 'POST',
                      data: {
                          _token: '{{ csrf_token() }}', // Token CSRF para seguridad
                          id_paciente: idPaciente,
                          id_doctor: idDoctor
                      },
                      success: function(response) {
                          console.log(response);
                          if (response.success) {
                              Swal.fire(
                                  'Agregado',
                                  'El paciente ha sido agregado exitosamente.',
                                  'success'
                              ).then(() => {
                                  location.reload(); // Refrescar la página
                              });
                          } else {
                              Swal.fire(
                                  'Error',
                                  'No se pudo agregar el paciente.',
                                  'error'
                              );
                          }
                      },
                      error: function() {
                          Swal.fire(
                              'Error',
                              'Ocurrió un error al intentar agregar el paciente.',
                              'error'
                          );
                      }
                  });
              }
          });
      }
  </script>

</div>
