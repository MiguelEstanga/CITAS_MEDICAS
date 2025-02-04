@extends('layout.app')
@section('content')
    <div class="container_estadisticas">
        <!-- Panel izquierdo -->
        <div class="usuario_estadisticas">
            <div class="card mb-3">
                <div class="card-header">
                    <h3>Nuevos Pacientes</h3>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                 
                    <div class="" style="width: 150px;">
                        <canvas id="usersPieChart"></canvas>
                        <p class="text-center mt-3">Pacientes registrados en los últimos 7 días  <span style="color:red"> {{ $newUsersCount }}</span></p>
                        <p class="text-center mt-3">
                            Promedio de edad: {{ $edadPromedio }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel derecho -->
        <div class="estadisticas_derecha">
            <div class="d-flex gap-4 flex-wrap justify-content-center mb-4">
                <!-- Gráfico 1: Costos vs Abonos -->
                <div class="chart-container" style="height: 400px; width: 400px">
                    <canvas id="graficoCostos"></canvas>
                </div>

                <!-- Gráfico 2: Saldos vs Abonos -->
                <div class="chart-container" style="height: 400px; width: 400px">
                    <canvas id="graficoSaldos"></canvas>
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





        // Verificar si el total ha sido completamente cancelado
        let backgroundColors;


        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        // Obtener el contexto del canvas
        const ctxVentas = document.getElementById('presupuestosChart').getContext('2d');

        new Chart(ctxVentas, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Ventas mensuales',
                    data: @json($presupuestos),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)', // Color azul para las barras
                    borderColor: 'rgba(54, 162, 235, 1)', // Borde azul
                    borderWidth: 1,
                    borderRadius: 5, // Bordes redondeados en las barras
                    barThickness: 30 // Ancho de las barras
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto en USD'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'USD'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Configuración común para ambos gráficos
        const configComun = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        };

        // Gráfico 1: Costos vs Abonos
        new Chart(document.getElementById('graficoCostos'), {
            type: 'pie',
            data: {
                labels: ['Costos Totales', 'Recaudación'],
                datasets: [{
                    data: [@json($totalCosto), @json($totalAbono)],
                    backgroundColor: ['#ff6384', '#4bc0c0'],
                    borderWidth: 2
                }]
            },
            options: configComun
        });

        // Gráfico 2: Saldos vs Abonos
        new Chart(document.getElementById('graficoSaldos'), {
            type: 'pie',
            data: {
                labels: ['Saldo Pendiente', 'Abonos Realizados'],
                datasets: [{
                    data: [@json($totalSaldo), @json($totalAbono)],
                    backgroundColor: ['#ff6384', '#4bc0c0'],
                    borderWidth: 2
                }]
            },
            options: configComun
        });
    </script>
@endsection
