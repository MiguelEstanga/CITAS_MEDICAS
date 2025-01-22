<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <link rel="icon" href="{{ asset('storage/sistema/icono_diente.png') }}" type="image/png">
        
    
</head>

<body  >
    <nav id="sidebar" class="d-none d-md-block">
        <div class="p-4">
            <div class="mb-3 logo">
                <img src="{{asset('storage/sistema/icono_diente.png')}}" alt="{{asset('sistema/logo.png')}}" width="100px" height="100px">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item {{ request()->segment(1) == 'panel' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('panel.index') }}">Panel</a>
                </li>
                @can('superusuario')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(1) == 'lista_pacientes' ? 'active' : '' }} " href="{{ route('pacientes.index') }}">Lista de pacientes</a>
                    </li>
                @endcan
                @can('v_doctor')
                    <li class="nav-item {{ request()->segment(1) == 'lista_pacientes' ? 'active' : '' }}">
                        <a class="nav-link  "  href="{{ route('pacientes.index') }}">Lista de pacientes</a>
                    </li>
                  
                    <li class="nav-item  {{ request()->segment(1) == 'agenda' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('agenda.index') }}">Mi agenda</a>
                    </li>
                
                @endcan
                <li class="nav-item  {{ request()->segment(1) == 'medicamentos' ? 'active' : '' }}">
                    <a class="nav-link {{ request()->segment(1) == 'medicamentos' ? 'active' : '' }}"
                        href="{{ route('medicamentos.index') }}">Medicamentos</a>
                </li>
                <li class="nav-item  {{ request()->segment(1) == 'inventario' ? 'active' : '' }}">
                    <a class="nav-link {{ request()->segment(1) == 'inventario' ? 'active' : '' }}"
                        href="{{ route('inventario.index') }}">Inventario</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link "
                        href="{{ route('logout') }}">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="content">
        <button class="d-md-none btn btn-dark mb-3" onclick="toggleSidebar()">☰ Menu</button>

        @yield('content')
    </div>
  
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.7/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('d-none');
        }
    </script>
</body>

</html>
<style>
    .logo{
     
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<script>
    function deleteHistoria(id, url) {
        // Mostrar la alerta de confirmación
        console.log(id);

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás deshacer esta acción!",
            icon: 'warning',
            background: '#2c2c2c', // Fondo oscuro del cuadro de alerta
            color: '#ffffff', // Texto blanco
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal-dark-popup',
                title: 'swal-dark-title',
                content: 'swal-dark-content',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear un formulario dinámico para enviar el POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                // Agregar el token CSRF
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}";
                form.appendChild(csrfInput);

                // Agregar el método DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                // Agregar el formulario al cuerpo y enviarlo
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
