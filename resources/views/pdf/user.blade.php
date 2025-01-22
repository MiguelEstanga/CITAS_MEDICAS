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
            padding: 8px;
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
            font-size: 18px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{asset('storage/sistema/logo.png')}}" alt="Logo de la Empresa">
        
    </header>
    <h1>Lista de Usuarios del {{$fecha_inicio}} al {{$fecha_fin}}</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Cedula</th>
                <th>Avata</th>
                <th>Edad</th>
                <th>Telefono</th>
                <th>Creado</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($usuario as $item)
            
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->cedula }}</td>
                    <td><img src="{{asset('storage/' . $item->avatar) ?? user_default() }}" alt=""></td>
                    <td>{{ $item->edad }}</td>
                    <td>{{ $item->telefono }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
              
            @endforeach
           
        </tbody>
    </table>
</body>
</html>
