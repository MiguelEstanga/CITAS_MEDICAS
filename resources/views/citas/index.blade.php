@extends('layout.app')

@section('content')
    <style>
        .fc-day-grid-event .fc-all-day {
            display: none;
        }
    </style>
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>
    <div class="table-container" style="max-height: 850px; overflow-y: auto;">
        <div id="calendar"></div>
    </div>

    <!-- Modal para crear evento -->
    <div class="modal" id="createEventModal" tabindex="-1" role="dialog">
        <div class="modal-dialog cart" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title ">Crear Cita</h5>
                </div>
                <div class="modal-body">
                    <form id="createEventForm" method="POST" action="{{ route('eventos.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="input">
                            <label for="titlo" class="form-label mb-2">Título</label>
                            <input type="text" id="titlo" name="titulo" class="form-control"
                                placeholder="Título de la cita">
                        </div>

                        <div class=" input">
                            <label for="createDate" class="form-label mb-2">Fecha</label>
                            <input type="date" id="createDate" name="fecha" class="form-control">
                        </div>

                        <div class="mb-2 input">
                            <label for="createStart" class="form-label mb-2">Hora de Inicio</label>
                            <input type="time" id="createStart" name="hora_inicio" class="form-control">
                        </div>
                        <div class="mb-3 input">
                            <label for="createEnd" class="form-label mb-2">Hora de Fin</label>
                            <input type="time" id="createEnd" name="hora_fin" class="form-control">
                        </div>
                        <input type="hidden" id="createSelectedColor" name="color" value="#FF5733">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar evento -->
    <div class="modal" id="editEventModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title ">Editar Cita</h5>
                </div>
                <div class="modal-body">
                    <form id="editEventForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" id="methodField" class="mb-3">
                        <input type="hidden" id="editEventId" name="id">

                        <div class="mb-3 input">
                            <label for="editTitle" class="form-label mb-3">Título</label>
                            <input type="text" id="editTitle" name="titulo" class="form-control"
                                placeholder="Título de la cita">
                        </div>

                        <div class="mb-3 input">
                            <label for="editDate" class="form-label mb-3">Fecha</label>
                            <input type="date" id="editDate" name="fecha" class="form-control">
                        </div>

                        <div class="mb-3 input">
                            <label for="editStart" class="form-label mb-3">Hora de Inicio</label>
                            <input type="time" id="editStart" name="hora_inicio" class="form-control">
                        </div>

                        <div class="mb-3 input">
                            <label for="editEnd" class="form-label mb-3">Hora de Fin</label>
                            <input type="time" id="editEnd" name="hora_fin" class="form-control">
                        </div>



                        <input type="hidden" id="editSelectedColor" name="color" value="#FF5733">
                        <!-- Default color -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>

                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                timeZone: 'Europe/Madrid',
                editable: true,
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // Nombres originales en inglés
                },
                buttonText: { // Textos traducidos
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    prev: '<',
                    next: '>'
                },

                // Ruta que devuelve los eventos en JSON
                events: `{{ route('eventos.eventos', user()->id) }}`,

                // Clic en un espacio vacío para crear evento
                dateClick: function(info) {
                    const date = info.dateStr.split('T')[0];
                    const start = info.dateStr.split('T')[1];
                    $('#createDate').val(date);
                    $('#createStart').val(start.split('-')[0]);
                    $('#createEnd').val(start.split('-')[0]);
                    $('#createEventModal').modal('show');
                },

                // Clic en un evento existente para editar
                eventClick: function(info) {
                    const start = info.event.start;
                    const end = info.event.end;
                    const startDate = start.toISOString().slice(0, 10);
                    const startTime = start.toLocaleTimeString('en-US', {
                        hour12: false
                    }).slice(0, 5);
                    const endTime = end ? end.toLocaleTimeString('en-US', {
                        hour12: false
                    }).slice(0, 5) : startTime;

                    $('#editEventModal').modal('show');
                    $('#editEventId').val(info.event.id);
                    $('#editTitle').val(info.event.title);
                    $('#editDate').val(startDate);
                    $('#editStart').val(startTime);
                    $('#editEnd').val(endTime);

                    const editRoute = `{{ route('eventos.update', '*') }}`.replace('*', info.event.id);
                    $('#editEventForm').attr('action', `${editRoute}`);
                },

                // ===== Nuevo: mover (arrastrar/soltar) un evento =====
                eventDrop: function(info) {
                    // Obtener datos actualizados
                    const eventId = info.event.id;
                    const start = info.event.start;
                    const end = info.event.end ||
                        start; // si no hay hora de fin, se usa la misma de inicio

                    // Convertir fechas a cadenas ISO (o al formato que necesites)
                    const startISO = start.toISOString();
                    const endISO = end.toISOString();

                    // Aquí harás la llamada para actualizar en tu backend:
                    // Por ejemplo, si tienes una ruta tipo: /eventos/actualizar-fechas/{id}
                    fetch(`/eventos/actualizar-fechas/${eventId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start: startISO,
                                end: endISO
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                // revertir el movimiento si hay error
                                info.revert();
                                Swal.fire('Error', 'No se pudo actualizar el evento.', 'error');
                            } else {
                                Swal.fire('Evento actualizado',
                                    'Se ha cambiado la fecha/horario del evento.', 'success');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            info.revert(); // revertir en caso de error de fetch
                            Swal.fire('Error', 'No se pudo actualizar el evento.', 'error');
                        });
                },

                // ===== Nuevo: redimensionar la duración del evento =====
                eventResize: function(info) {
                    const eventId = info.event.id;
                    const start = info.event.start;
                    const end = info.event.end || start;
                    const startISO = start.toISOString();
                    const endISO = end.toISOString();

                    fetch(`/eventos/actualizar-fechas/${eventId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start: startISO,
                                end: endISO
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                info.revert();
                                Swal.fire('Error', 'No se pudo actualizar la duración del evento.',
                                    'error');
                            } else {
                                Swal.fire('Evento actualizado',
                                    'Se ha redimensionado el horario del evento.', 'success');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            info.revert();
                            Swal.fire('Error', 'No se pudo actualizar la duración del evento.',
                                'error');
                        });
                }
            });

            calendar.render();

            // Eliminar evento

        });


        function eliminar() {
            // Obtener el ID del evento desde el campo oculto en el modal
            const eventId = document.getElementById('editEventId').value;

            // Crear la URL dinámica para la eliminación del evento
            const deleteUrl = `{{ route('agenda.destroy', ':id') }}`.replace(':id', eventId);

            // Mostrar SweetAlert para confirmar la eliminación
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás deshacer esta acción.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Realizar la solicitud para eliminar el evento
                    fetch(deleteUrl, {
                            method: 'post',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {


                                window.location.reload();
                            } else {
                                // Mostrar un mensaje de error si la eliminación falla
                                Swal.fire('Error', 'No se pudo eliminar el evento.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error al eliminar el evento:', error);
                            Swal.fire('Error', 'No se pudo eliminar el evento.', 'error');
                        });
                }
            });
        }
    </script>
@endsection
