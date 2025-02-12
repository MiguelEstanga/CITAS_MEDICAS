<table id="historiaTable" class="table  " style="width:100% ; position: relative;">

    <div class="h4 historia_medica d-flex justify-content-between align-items-center gap-2 mb-4">
        Historia dental

    </div>
    <thead>
        <tr>
            <th>ID</th>
            <th>Diagnóstico</th>
            <th>Observaciones</th>
            <th>Fecha</th>
            <th>A/Cuenta</th>
            <th>Costo BS</th>
            <th>Abono BS</th>
            <th>Saldo BS</th>
            <th>Cancelado</th>
            <th>Pagado</th>
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
                <td>{{ $presupuesto->costo }}</td>
                <td>{{ $presupuesto->abono }}</td>
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
                        <input class="form-check-input cancelar_post" type="checkbox" role="switch" class="cancelado"
                            id="{{ $presupuesto->id }}" {{ $presupuesto->cancelado ? 'checked' : '' }}>

                    </div>
                </td>
                <td>
                    <a href="">
                        <a href="{{ route('historia-medica.ver_historia_medica', $presupuesto->id) }}">
                            {!! iconos('show') !!}
                        </a>
                    </a>
                    <a onclick="eliminar('{{ route('presupuesto.eliminar', $presupuesto->id) }}')">
                        {!! iconos('delete') !!}
                    </a>



                </td>
            </tr>
        @endforeach
    <tfoot>
        <tr>
            <th colspan="5" style="text-align: right;">Totales:</th>
            <th id="totalCosto">0.00 BS</th>
            <th id="totalAbono">0.00 BS</th>
            <th id="totalSaldo">0.00 BS</th>
            <th colspan="3"></th>
        </tr>
    </tfoot>
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
        // Seleccionar la tabla
        const table = document.getElementById('historiaTable');
        const rows = table.querySelectorAll('tbody tr');

        // Inicializar totales
        let totalCosto = 0;
        let totalAbono = 0;
        let totalSaldo = 0;

        // Recorrer las filas de la tabla
        rows.forEach(row => {
            const costo = parseFloat(row.querySelector('td:nth-child(6)').textContent) || 0;
            const abono = parseFloat(row.querySelector('td:nth-child(7)').textContent) || 0;
            const saldo = parseFloat(row.querySelector('td:nth-child(8)').textContent) || 0;

            // Sumar los valores
            totalCosto += costo;
            totalAbono += abono;
            totalSaldo += saldo;
        });

        // Mostrar los totales en el pie de la tabla
        document.getElementById('totalCosto').textContent = totalCosto.toFixed(2) + ' BS';
        document.getElementById('totalAbono').textContent = totalAbono.toFixed(2) + ' BS';
        document.getElementById('totalSaldo').textContent = totalSaldo.toFixed(2) + ' BS';
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
        document.querySelectorAll('.cancelar_post').forEach(function(checkbox) {
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
        var uri = `{{ route('presupuesto.updateCancelado') }}`;
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

    function confirmarEstado(id, cancelado) {
        const estado = cancelado ? 'Cancelar' : 'Marcar como No Cancelado';
        Swal.fire({
            title: `¿Estás seguro de ${estado}?`,
            text: "Este cambio se guardará automáticamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Llamar a la función para actualizar el estado
                actualizarEstado(id, cancelado);
            } else {
                // Revertir el estado del checkbox si se cancela
                document.getElementById(`cancelar-${id}`).checked = !cancelado;
            }
        });
    }

    function actualizarEstado(id, cancelado) {
        // Crear el payload para enviar
        const payload = {
            id: id,
            cancelado: cancelado ? 1 : 0
        };

        fetch(`{{ route('presupuesto.updateCancelado') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire(
                        'Estado actualizado',
                        `El estado ha sido actualizado a ${cancelado ? 'Cancelado' : 'No Cancelado'}.`,
                        'success'
                    );
                    location.reload();
                } else {
                    Swal.fire(
                        'Error',
                        'Hubo un problema al actualizar el estado.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                Swal.fire(
                    'Error',
                    'No se pudo actualizar el estado.',
                    'error'
                );
            });
    }

    function eliminar(deleteUrl) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realiza la eliminación
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _method: 'POST',
                        _token: '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
                    },
                    success: function(response) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        ).then(() => {
                            location.reload(); // Recargar la página
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el registro.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
