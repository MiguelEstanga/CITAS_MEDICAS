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
    <h1>Lista de Inventario del {{$fecha_inicio}} al {{$fecha_fin}}</h1>
    <table>
        <thead>
            <tr>
                <th>N</th>
                <th>Articulo</th>
                <th>Descripción</th>
                <th>Precio en Bs</th>
                <th>Cantidad</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $inventario as $item)
            
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->precio }}{{precio()}}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td><img src="{{url(Storage::url($item->imagen)) }}" alt=""></td>
                </tr>
              
            @endforeach
           
        </tbody>
    </table>
</body>
</html>
