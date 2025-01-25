@extends('layout.app')
@section('content')
    <div class="container_estadisticas">
        <!-- Panel izquierdo -->
        <div class="usuario_estadisticas">
            <div class="card mb-3">
                <div class="card-header">
                    <h3>Usuarios Nuevos</h3>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h1 class="text-center">{{ $newUsersCount }}</h1>
                    <div class="" style="width: 150px;">
                        <canvas id="usersPieChart"></canvas>
                        <p class="text-center mt-3">Usuarios registrados en los últimos 7 días</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Generar reporte de usuarios</h3>
                </div>
                <div class="card-body ">

                    <div class="">
                        <form action="{{ route('reportes.reporte_usuario') }}" >
                          
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" name="all" type="checkbox" role="switch"
                                    id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Todos los usuarios</label>
                            </div>
                            <x-input type="date" name="fecha_inicio" label="Nombre del reporte"
                                placeholder="Nombre del reporte" class="mb-3" />
                            <x-input type="date" name="fecha_fin" label="Fecha del reporte"
                                placeholder="Fecha del reporte" class="mb-3" />
                            <button class="btn btn-default auto" type="submit">Generar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Generar reporte de Ventas</h3>
                </div>
                <div class="card-body ">
                    <div class="">
                        <form action="{{ route('reportes.reporte_ventas') }}" >
                          
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" name="all" type="checkbox" role="switch"
                                    id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Todas las ventas</label>
                            </div>
                            <x-input type="date" name="fecha_inicio" label="Nombre del reporte"
                                placeholder="Nombre del reporte" class="mb-3" />
                            <x-input type="date" name="fecha_fin" label="Fecha del reporte"
                                placeholder="Fecha del reporte" class="mb-3" />
                            <button class="btn btn-default auto" type="submit">Generar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel derecho -->
        <div class="estadisticas_derecha">
            <!-- Gráfico de Ventas -->
            <div class="card">
                <div class="card-header">
                    <h3>Ventas</h3>
                </div>
                <div class="card-body">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>

            <!-- Gráfico de Presupuestos -->
            <div class="card">
                <div class="card-header">
                    <h3>Presupuestos</h3>
                </div>
                <div class="card-body">
                    <canvas id="presupuestosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos -->
    <style>
        .container_estadisticas {
            display: grid;
            grid-template-columns: 25% 75%;
            gap: 20px;
        }

        .card {
            border-radius: 10px;
            padding: 20px;
            background-color: #f5f5f5;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .estadisticas_derecha .card {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container_estadisticas {
                grid-template-columns: 100%;
            }
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos comunes
        const labels = @json($labels);

        // Gráfico de Usuarios (Pastel)
        const dataUsers = @json($dataUsers);
        const ctxUsers = document.getElementById('usersPieChart').getContext('2d');
        new Chart(ctxUsers, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: dataUsers,
                    backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Gráfico de Ventas (Línea con Flechas)

        const labelsventas = @json($labelsA); // Fechas
        const dataModelA = @json($ventas); // Datos para las ventas

        const ctxModelA = document.getElementById('ventasChart').getContext('2d');
        new Chart(ctxModelA, {
            type: 'bar', // Cambiamos el tipo de gráfico a 'bar'
            data: {
                labels: labelsventas, // Fechas (eje X)
                datasets: [{
                    label: 'Ventas',
                    data: dataModelA, // Cantidad de ventas por día
                    backgroundColor: 'rgba(255, 0, 0, 0.5)', // Color de las barras (rojo con transparencia)
                    borderColor: 'rgba(255, 0, 0, 1)', // Borde de las barras (rojo sólido)
                    borderWidth: 1 // Grosor del borde de las barras
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top' // Posición de la leyenda
                    },
                    tooltip: {
                        enabled: true // Habilitar el tooltip al pasar sobre las barras
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha' // Título del eje X
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad de Ventas' // Título del eje Y
                        },
                        beginAtZero: true // Comienza desde cero
                    }
                }
            }
        });


        // Gráfico de Presupuestos (Pastel)
        const totalPresupuestos = @json($totalPresupuestos);
        const totalCancelado = @json($totalCancelado);
        const ctxPresupuestos = document.getElementById('presupuestosChart').getContext('2d');

        // Verificar si el total ha sido completamente cancelado
        let backgroundColors;

        if (totalCancelado === totalPresupuestos) {
            // Todo está cancelado, la gráfica será completamente verde
            backgroundColors = ['rgba(75, 192, 75, 0.7)', 'rgba(75, 192, 75, 0.7)']; // Verde
        } else {
            // Mostrar el total y lo cancelado con colores diferentes
            backgroundColors = ['rgba(75, 192, 75,  0.7)', 'rgba(203, 67, 53 , 0.7)'];
        }

        new Chart(ctxPresupuestos, {
            type: 'pie',
            data: {
                labels: ['Cancelado', 'No cancelado'],
                datasets: [{
                    data: [totalPresupuestos, totalCancelado],
                    backgroundColor: backgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            // Formato para mostrar los valores en el tooltip
                            label: function(tooltipItem) {
                                const label = tooltipItem.label || '';
                                const value = tooltipItem.raw;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
