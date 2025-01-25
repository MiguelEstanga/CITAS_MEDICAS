<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabla de Usuarios con Gráfico</title>
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
    <img src="{{asset('storage/sistema/logo.png')}}" alt="Logo de la Empresa">
  </header>

  <h1>Lista de Usuarios del {{$fecha_inicio}} al {{$fecha_fin}}</h1>

  <!-- Tabla de usuarios -->
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Cédula</th>
        <th>Avatar</th>
        <th>Edad</th>
        <th>Teléfono</th>
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

  <!-- Gráfico de barras -->
  <h2 class="title">Gráfico de Usuarios Registrados por Día</h2>
  <table>
    <thead>
      <tr>
        <th>Día</th>
        <th>Usuarios Registrados</th>
      </tr>
    </thead>
    <tbody>
      @php
        $usuariosPorDia = $usuario->groupBy(function($item) {
          return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
        })->map->count();
      @endphp
      @foreach ($usuariosPorDia as $dia => $cantidad)
      <tr>
        <td>{{ $dia }}</td>
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
</body>
</html>
