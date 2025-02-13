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
    @php
    // Convertir imagen a Base64
    $logoPath = storage_path("app/public/sistema/logo.png");
    if (File::exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = File::mimeType($logoPath);
        $logoBase64 = "data:$logoMime;base64,$logoData";
    } else {
        $logoBase64 = '';
    }
@endphp
    

    <header style="background-color: black;">
        <img src="{{ $logoBase64}}" alt="Logo de la Empresa" width="100%" height="100px">
        
    </header>
    <h1>Ficha Odontològica de  {{$user->name}} {{$user->last_name}}</h1>



    <table class="examen-clinico">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Diagnóstico</th>
                <th>Observaciones</th>
                <th>A cuenta</th>
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
