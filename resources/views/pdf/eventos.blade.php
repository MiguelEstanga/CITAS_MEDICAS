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
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo de la Empresa">
        
    </header>
    <h1>Lista de Eventos del {{$fecha_inicio}} al {{$fecha_fin}}</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Editable</th>
                <th>Color</th>
                <th>Paciente</th>
                <th>Usuario</th>
                <th>Creado</th>
                <th>Actualizado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Salida</td>
                <td>2025-01-18 01:30:00</td>
                <td>2025-01-18 02:30:00</td>
                <td>No</td>
                <td>#FF5733</td>
                <td>N/A</td>
                <td>1</td>
                <td>2025-01-17 06:24:26</td>
                <td>2025-01-17 07:07:05</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Visita de Miguel</td>
                <td>2025-01-16 00:00:00</td>
                <td>2025-01-16 00:00:00</td>
                <td>No</td>
                <td>#FF5733</td>
                <td>N/A</td>
                <td>1</td>
                <td>2025-01-18 04:32:29</td>
                <td>2025-01-18 04:32:29</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
