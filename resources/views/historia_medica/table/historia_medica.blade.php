<table id="historiaTable" class="table  " style="width:100% ; position: relative;">
    <div class="h4 historia_medica">
        Historia Medica
    </div>
    <thead>
        <tr>
            <th>ID</th>
            <th>Diagnostico</th>
            <th>Observaciones</th>
            <th>Fecha</th>
            <th>A/Cuenta</th>
            <th>Saldo</th>
            <th>Cancelado</th>
            <th>Cancelar</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($presupuestos as $presupuesto)
            <tr>
                <td>{{ $presupuesto->id }}</td>
                <td>{{ $presupuesto->diagnostico }}</td>
                <td>{{ $presupuesto->observacion }}</td>
                <td>{{ $presupuesto->fecha }}</td>
                <td>{{ $presupuesto->a_cuenta }}</td>
                <td>{{ $presupuesto->saldo }}</td>

                <td>
                    @if ($presupuesto->cancelado)
                        <span class="badge bg-success">Cancelado</span>
                    @else
                        <span class="badge bg-danger">No Cancelado</span>
                    @endif

                </td>
                <td>
                    <div class=" form-switch ">
                      <input class="form-check-input"  type="checkbox" role="switch" class="cancelado" id="{{$presupuesto->id}}"  {{$presupuesto->cancelado ? "checked" : ""}}  >
                           
                    </div>
                </td>
                <td>
                    <a href="">
                        <a href="{{ route('historia-medica.ver_historia_medica', $presupuesto->id) }}">
                            {!! iconos('show') !!}
                        </a>
                    </a>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
<style>
    .dt-search-0 {
        border: none !important;
    }

    .historia_medica {
        position: absolute;
        top: 26px;
        left: 10px;
    }

    .dt-search label {
        display: none !important;
    }

    .dt-search input {
        border-bottom: 1px solid #000;
        border-top: none;
        width: 200px !important;
    }

    .dt-search input:placeholder-shown {
        border-bottom: none;
    }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Inicializar DataTable
      $('#historiaTable').DataTable({
          "paging": false,
          "info": false,
          "ordering": false,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
          }
      });

      // Agregar evento de cambio a los checkboxes
      document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
          checkbox.addEventListener('change', function(event) {
              const id = event.target.id;
              const cancelado = event.target.checked ? 1 : 0;

              // Llamar a la función para actualizar el estado
              actualizarEstado(id, cancelado);
          });
      });
  });

  function actualizarEstado(id, cancelado) {
      // Crear el payload para enviar
      const payload = {
          id: id,
          cancelado: cancelado
      };
      console.log(payload);
      var uri =  `{{ route('presupuesto.updateCancelado') }}`;
      // Hacer la petición fetch
      fetch(uri, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(payload)
      })
      .then(response => response.json())
      .then(result => {
        console.log(result);
          if (result.success) {
              console.log('Estado actualizado exitosamente');
              location.reload();
              // Actualizar la interfaz o mostrar un mensaje de éxito
          } else {
              console.error('Error al actualizar el estado:', result.message);
              // Mostrar un mensaje de error al usuario
          }
      })
      .catch(error => {
          console.error('Error en la petición:', error);
          // Mostrar un mensaje de error al usuario
      });
  }
</script>

