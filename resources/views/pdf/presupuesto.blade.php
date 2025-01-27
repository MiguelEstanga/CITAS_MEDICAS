<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Ficha Odontológica</title>
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

        th,
        td {
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
    <h1>Ficha Odontològica de  {{$user->name}} {{$user->last_name}}</h1>



    <table class="examen-clinico">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Diagnostico</th>
                <th>Observaciones</th>
                <th>Acuenta</th>
                <th>Saldo</th>
                <th>Canselado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presupuesto as $item)
             <tr>
                 <td>{{ $item->fecha }}</td>
                 <td>{{ $item->diagnostico }}</td>
                 <td>{{ $item->observacion }}</td>
                 <td>{{ $item->a_cuenta }}</td>
                 <td>{{ $item->saldo }}</td>    
                 <td>{{ $item->cancelado }}</td>
             </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
