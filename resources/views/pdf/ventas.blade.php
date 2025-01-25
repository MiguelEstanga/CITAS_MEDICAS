<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        header img {
            max-height: 60px;
        }
        header h1 {
            font-size: 20px;
            margin: 0;
            text-align: right;
            flex-grow: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background-color: #FF5733;
            color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
        }
        th {
            text-transform: uppercase;
        }
        .title {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
        }
        .bar-container {
            width: 100%;
            background-color: #f1f1f1;
            position: relative;
            height: 20px;
        }
        .bar {
            height: 100%;
            background-color: #4CAF50;
            text-align: right;
            line-height: 20px;
            color: white;
        }
        .bar span {
            padding-right: 5px;
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo de la Empresa">
        
    </header>
    @if($all == "on")
        <h1>Lista de Ventas</h1>
    @else
    <h1>Lista de Eventos del {{$fecha_inicio}} al {{$fecha_fin}}</h1>
    @endif
    <div>
        <h2 class="title">Gráfico de Eventos por Día</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cantidad de Eventos</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $eventosPorDia = $ventas->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->fecha)->format('Y-m-d');
                    })->map->count();
                @endphp
                @foreach ($eventosPorDia as $fecha => $cantidad)
                    <tr>
                        <td>{{ $fecha }}</td>
                        <td>
                            <div class="bar-container">
                                <div class="bar" style="width: {{ $cantidad * 10 }}%;">
                                    <span>{{ $cantidad }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Servicio</th>
                <th>Nombre del comprador</th>
                <th>Apellido del comprador</th>
                <th>Cédula del comprador</th>
                <th>Telefono del comprador</th>
                <th>Fecha</th>
                <th>Precio</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->servicio->nombre }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->apellido }}</td>
                    <td>{{ $item->cedula }}</td>
                    <td>{{ $item->telefono }}</td>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->precio }}</td>
                </tr>
                
            @endforeach
        </tbody>
    </table>
</body>
</html>
