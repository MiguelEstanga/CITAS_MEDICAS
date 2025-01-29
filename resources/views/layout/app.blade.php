<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinica Odontologica</title>
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjX0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <link rel="icon" href="{{ asset('storage/sistema/icono_diente.png') }}" type="image/png">
</head>

<body class="text-dark" style="background-color: var(--color_menu)!important;">
    <div id="wrapper" class="d-flex">
        <nav id="sidebar" class="text-white p-4" style="background-color: var(--color_menu);">
            <div class="logo mb-3 text-center">
                <img src="{{ asset('storage/sistema/icono_diente.png') }}" alt="Logo" width="200px" height="200px">
            </div>
            <ul class="nav flex-column">
                <!-- Panel principal -->
                <li class="nav-item {{ request()->segment(1) == 'panel' ? 'active' : '' }}">
                    <a class="nav-link {{ request()->segment(1) == 'panel' ? 'active' : '' }}"
                       href="{{ route('panel.index') }}">Panel</a>
                </li>

                <!-- Menú Desplegable: Citas -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ in_array(request()->segment(1), ['pacientes','usuarios','agenda']) ? 'active' : '' }}"
                       href="#"
                       id="navbarCitas"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                       Citas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarCitas" style="background-color: var(--color_menu);">
                        @can('v_asistente_general')
                            <li>
                                <a class="dropdown-item text-white {{ request()->segment(1) == 'pacientes' ? 'active' : '' }}"
                                   href="{{ route('usuarios.pacientes', 'paciente') }}"
                                   style="background-color: inherit;">
                                    Lista de pacientes
                                </a>
                            </li>
                        @endcan

                        @can('v_asistente_general')
                            <li>
                                <a class="dropdown-item text-white {{ request()->segment(1) == 'usuarios' ? 'active' : '' }}"
                                   href="{{ route('usuarios.index', 'usuario') }}"
                                   style="background-color: inherit;">
                                    Lista de usuarios
                                </a>
                            </li>
                        @endcan

                        @can('v_admnistrador')
                            <li>
                                <a class="dropdown-item text-white {{ request()->segment(1) == 'agenda' ? 'active' : '' }}"
                                   href="{{ route('agenda.index') }}"
                                   style="background-color: inherit;">
                                    Mi agenda
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <!-- Fin menú desplegable Citas -->

                @can('v_asistente_dental')
                    <li class="nav-item {{ request()->segment(1) == 'inventario' ? 'active' : '' }}">
                        <a class="nav-link {{ request()->segment(1) == 'inventario' ? 'active' : '' }}"
                           href="{{ route('inventario.index') }}">Inventario</a>
                    </li>
                @endcan

                @can('v_admnistrador')
                    <li class="nav-item {{ request()->segment(1) == 'servicios' ? 'active' : '' }}">
                        <a class="nav-link {{ request()->segment(1) == 'servicios' ? 'active' : '' }}"
                           href="{{ route('servicios.index') }}">Servicios</a>
                    </li>
                @endcan

                @can('v_admnistrador')
                    <li class="nav-item {{ request()->segment(1) == 'venta' ? 'active' : '' }}">
                        <a class="nav-link {{ request()->segment(1) == 'venta' ? 'active' : '' }}"
                           href="{{ route('venta.index') }}">Ventas</a>
                    </li>
                @endcan

                @can('v_asistente_general')
                    <li class="nav-item {{ request()->segment(1) == 'estadisticas' ? 'active' : '' }}">
                        <a class="nav-link {{ request()->segment(1) == 'estadisticas' ? 'active' : '' }}"
                           href="{{ route('estadisticas.index') }}">Estadísticas</a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}">Cerrar Sesión</a>
                </li>
            </ul>
        </nav>

        <div id="content" class="p-4" style=" background: var(--color_body)!important;">
            <button class="btn btn-dark mb-3 d-md-none" id="menu-toggle">☰ Menu</button>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.7/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('d-none');
        });
    </script>
</body>
</html>

<style>
    #content {
        margin: 10px;
        border-radius: 10px;
        background: var(--color_body) !important;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        color: #000 !important;
        background: #343a40 !important;
    }

    #wrapper {
        display: flex;
        width: 100%;
    }

    #sidebar {
        width: 250px;
        min-height: 100vh;
        transition: all 0.3s;
    }

    #content {
        flex-grow: 1;
        padding: 20px;
    }

    .nav-link {
        display: block;
        padding: 10px 15px;
        color: #fff;
        transition: all 0.5s;
    }

    .nav-link.active {
        color: black !important;
        transition: all 0.5s;
    }

    .nav-link:hover,
    .nav-link.active {
        background-color: #eeeeef;
        color: black !important;
        margin: 10px 0;
        width: 127%;
        border-radius: 20px;
    }

    .logo {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 768px) {
        #sidebar.d-none {
            display: none !important;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: #343a40;
            color: #fff;
            z-index: 9999;
        }

        #content {
            margin-left: 0;
        }
    }
</style>
