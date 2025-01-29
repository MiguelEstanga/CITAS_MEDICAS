@extends('layout.app')

@section('content')
    <div class=" mb-4 d-flex justify-content-end align-items-center">
        <x-avatar :user="user()"></x-avatar>
    </div>

    <button style="width: 200px" class="btn-default mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#modal1">
        Crear nuevo registro
    </button>
    {{-- Alertas de éxito si existen --}}
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <div class="container-fluid">
            <h2>
                {{ $tipos_productos == 'inventario' ? 'Inventario' : 'Medicamentos' }}
            </h2>
        </div>
        <table class="table" style="width:100%" id="inventarioTable">
            <thead>
                <tr>
                    <th>N</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Aumentar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventario as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->estado() ?? '' }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $item->imagen) }}" alt="{{ $item->nombre }}"
                                class="circle_avatar" style="width: 50px; height: 50px;">
                        </td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->precio }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>
                            <form action="{{ route('inventario.aumentar_cantidad', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" name="cantidad" class="form-control"
                                            value="{{ $item->cantidad }}" min="1" max="100">
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <button type="submit" class="btn btn-primary">+</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>
                            {{-- Botón para abrir modal de Edición --}}
                            <a type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="{{ $item->id }}" data-nombre="{{ $item->nombre }}"
                                data-descripcion="{{ $item->descripcion }}" data-precio="{{ $item->precio }}"
                                data-cantidad="{{ $item->cantidad }}"
                                data-imagen="{{ asset('storage/' . $item->imagen) }}">
                                {!! iconos('edit') !!}
                            </a>

                            {{-- Botón para acción de eliminar (ejemplo) --}}
                            <a href="#" class="ml-4"
                                onclick="deleteHistoria(  '{{ $item->id }}' , '{{ route('inventario.delete', isset($item->id) ? $item->id : '-1') }}')">
                                {!! iconos('delete') !!}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal CREAR --}}
    <x-modal id="modal1" title="Registrar Articulo">

        <form action="{{ route('inventario.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-input :required="true" name="nombre" label="Nombre del Articulo" />
            <x-input :required="true" name="descripcion" label="Descripción" />
            <x-input_select name="estado" label="Tipo de producto" :options="$estados" />
            <x-input :required="true" name="precio" label="Precio" type="number" />
            <x-input :required="true" name="cantidad" label="Cantidad" type="number" />
            <x-input_file label="Subir imagen" name="imagen" />
            <input type="text" value="{{ $tipos_productos == 'inventario' ? 'inventario' : 'medicamentos' }}"
                name="tipo_producto" hidden>
            <div>
                <button class="btn-default" type="submit">Registrar Inventario</button>
            </div>
        </form>

    </x-modal>

    {{-- Modal EDITAR --}}
    <x-modal id="editModal" title="Editar Item">
        <div class="table-container">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- 
                    Usamos nombres de campos diferentes a los de "crear" 
                    para evitar conflictos (ej. "nombre_edit"). 
                    También puedes usar el mismo nombre de campos 
                    si así lo prefieres. 
                --}}
                <x-input :required="true" name="nombre" label="Nombre del item" />
                <x-input :required="true" name="descripcion" label="Descripción" />
                <x-input :required="true" name="precio" label="Precio" />
                <x-input :required="true" name="cantidad" label="Cantidad" />

                <x-input_file label="Subir nueva imagen (opcional)" name="imagen" :value="$rutaImagenExistente ?? null" />


                <div>
                    <button class="btn-default" type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        function deleteHistoria(id, deleteUrl) {
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
        $(document).ready(function() {
            // Inicializar DataTables
            $('#inventarioTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                pagingType: "simple_numbers",
            });

            // Al hacer clic en el botón "Editar"
            $('.btn-edit').click(function() {
                // 1. Capturamos datos del botón
                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                let descripcion = $(this).data('descripcion');
                let precio = $(this).data('precio');
                let cantidad = $(this).data('cantidad');
                let imagen = $(this).data('imagen'); // Ruta completa si deseas mostrarla

                // 2. Actualizamos el formulario
                var url = `{{ route('inventario.udate', '*') }}`.replace('*', id);
                console.log(url);
                $('#editForm').attr('action', url); // o tu ruta preferida

                $('input[name="nombre"]').val(nombre);
                $('input[name="descripcion"]').val(descripcion);
                $('input[name="precio"]').val(precio);
                $('input[name="cantidad"]').val(cantidad);

                // 3. Opcional: mostrar la imagen actual
                $('#previewImg').attr('src', imagen);
            });



        });
    </script>
@endsection
