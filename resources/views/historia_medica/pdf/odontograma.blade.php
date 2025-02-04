@php
    // Orden de piezas en cada fila
    $fila1 = ['18','17','16','15','14','12','11','21','22','23','24','25','26','27','28'];
    $fila2 = ['55','54','53','52','51','61','62','63','64','65'];
    $fila3 = ['85','84','83','82','81','71','72','73','74','75'];
    $fila4 = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'];
@endphp
{{-- resources/views/pdf/ficha-odontologica.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Odontológica</title>
    <style>
        /* Ajustes generales que DOMPDF soporta */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h1, h2, h3 {
            margin: 0;
            padding: 0;
        }

        /* Encabezado (tabla con info del paciente) */
        .header-table td {
            padding: 4px 8px;
            vertical-align: middle;
        }

        .header-table, .header-table td {
            border: none; /* sin borde */
        }

        .titulo-ficha {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Sección de “leyenda de colores” */
        .leyenda-colores {
            position: absolute; /* para colocarlo en una esquina */
            top: 50px;         /* ajusta según necesites */
            right: 30px;        /* ajusta según necesites */
            width: 130px;
            border: 1px solid #000;
            padding: 5px;
            font-size: 11px;
            background-color: #f9f9f9;
        }

        .leyenda-colores h3 {
            font-size: 12px;
            margin-bottom: 5px;
        }

        /* Sección de Odontograma (reutilizando el “inline-block” approach) */
        .odontograma-container {
            margin: 10px auto;
            width: 100%;
            text-align: center;
        }
        .row-dientes {
            display: block;
            margin-bottom: 15px;
        }
        .diente {
            display: inline-block;
            vertical-align: top;
            margin: 5px;
            position: relative;
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            border-radius: 50px;
            box-sizing: border-box;
        }
        .numero_diente {
            position: absolute;
            top: -18px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        .zona {
            position: absolute;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            background-color: #fff;
        }
        /* Ajustes “aproximados” para top, bottom, left, right, center */
        .zona-top {
            top: 0; left: 50%;
            transform: translateX(-50%);
            border-top-left-radius: 39px;
            border-top-right-radius: 39px;
        }
        .zona-bottom {
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            border-bottom-left-radius: 39px;
            border-bottom-right-radius: 39px;
        }
        .zona-left {
            top: 50%; left: 0;
            transform: translateY(-50%);
            border-top-left-radius: 39px;
            border-bottom-left-radius: 39px;
        }
        .zona-right {
            top: 50%; right: 0;
            transform: translateY(-50%);
            border-top-right-radius: 39px;
            border-bottom-right-radius: 39px;
        }
        .zona-center {
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Tabla final (igual que en tu ejemplo) */
        .tabla-final {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
       

        /* Campos extra (si quieres simular líneas para firmar, etc.) */
        .firma-campos {
            margin-top: 90px;
            display: block;
            width: 90%;
            
        }
        .firma-campos div {
            width: 200px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-left: 20px;
            display: inline-block;
           position: relative;
           left: 20%;
        }
        .tabla-final th, .tabla-final td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        #odontolgo{
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- Título principal -->
    <div class="titulo-ficha">FICHA ODONTOLÓGICA</div>

    <!-- Tabla con info del paciente, domicilio, etc. -->
    <table class="header-table" width="100%">
        <tr>
            <td style="width: 40%;">
                <strong>Apellidos y Nombres:</strong> {{ $presupuesto->user->name ?? '__________' }} {{ $presupuesto->user->last_name ?? '__________' }}
            </td>
            <td style="width: 20%;">
                <strong>Edad:</strong> {{ $presupuesto->user->edad ?? '___' }}
            </td>
            <td style="width: 40%;">
                <strong>Tel/Cel:</strong> {{ $presupuesto->user->telefono ?? '__________' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Domicilio:</strong> {{ $presupuesto->user->domicilio ?? '_________________________' }}
            </td>
        </tr>
        
        <tr>
            <td colspan="3" >
                <strong >Antecedentes Familiares:</strong> {{ $presupuesto->user->antecedentes_familiares ?? '_________________________' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Motivo de Consulta:</strong> {{ $presupuesto->user->motivo_consulta ?? '_________________________' }}
            </td>
        </tr>
    </table>
  
       
    

    <!-- Subtítulo: Odontograma -->
    <div style="margin-top: 50px; font-weight:bold;">ODONTOGRAMA</div>

    <!-- Odontograma -->
    <div class="odontograma-container">

        <!-- Fila 1 (ejemplo) -->
        <div class="row-dientes">
            @foreach ($fila1 as $num)
                @php
                    $dienteData  = $datosOdontograma[$num] ?? null;
                    $colorTop    = $dienteData['top']['color']    ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft   = $dienteData['left']['color']   ?? '#ffffff';
                    $colorRight  = $dienteData['right']['color']  ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top"    style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left"   style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right"  style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

        <!-- Fila 2 -->
        <div class="row-dientes">
            @foreach ($fila2 as $num)
                @php
                    $dienteData  = $datosOdontograma[$num] ?? null;
                    $colorTop    = $dienteData['top']['color']    ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft   = $dienteData['left']['color']   ?? '#ffffff';
                    $colorRight  = $dienteData['right']['color']  ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top"    style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left"   style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right"  style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

        <!-- Fila 3 -->
        <div class="row-dientes">
            @foreach ($fila3 as $num)
                @php
                    $dienteData  = $datosOdontograma[$num] ?? null;
                    $colorTop    = $dienteData['top']['color']    ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft   = $dienteData['left']['color']   ?? '#ffffff';
                    $colorRight  = $dienteData['right']['color']  ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top"    style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left"   style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right"  style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

        <!-- Fila 4 (opcional) -->
        <div class="row-dientes">
            @foreach ($fila4 as $num)
                @php
                    $dienteData  = $datosOdontograma[$num] ?? null;
                    $colorTop    = $dienteData['top']['color']    ?? '#ffffff';
                    $colorBottom = $dienteData['bottom']['color'] ?? '#ffffff';
                    $colorLeft   = $dienteData['left']['color']   ?? '#ffffff';
                    $colorRight  = $dienteData['right']['color']  ?? '#ffffff';
                    $colorCenter = $dienteData['center']['color'] ?? '#ffffff';
                @endphp

                <div class="diente">
                    <div class="numero_diente">{{ $num }}</div>
                    <div class="zona zona-top"    style="background-color: {{ $colorTop }};"></div>
                    <div class="zona zona-bottom" style="background-color: {{ $colorBottom }};"></div>
                    <div class="zona zona-left"   style="background-color: {{ $colorLeft }};"></div>
                    <div class="zona zona-right"  style="background-color: {{ $colorRight }};"></div>
                    <div class="zona zona-center" style="background-color: {{ $colorCenter }};"></div>
                </div>
            @endforeach
        </div>

    </div>
    
    <!-- Leyenda de colores en la esquina -->
    <div class="leyenda-colores">
        <h3>Colores</h3>
        <p><strong>Caries:</strong> <span style="color: #ff0000;">Rojo</span></p>
        <p><strong>Obturación:</strong> <span style="color: #0000ff;">Azul</span></p>
        <p><strong>Resina:</strong> <span style="color: #FFA500;">Naranja</span></p>
        <p><strong>Sano:</strong> <span style="color: #00ff00;">Verde</span></p>
        <!-- Añade tantas categorías como necesites -->
    </div>
    <!-- Tabla final (ejemplo) -->
  
    <table  border="1" cellspacing="0" cellpadding="6" width="100%" style="margin-top:20px;">
        <thead>
            <tr>
                <th>Labios</th>
                <th>Lengua</th>
                <th>Encimas</th>
                <th>Atm</th>
                <th>Carrillos</th>
                <th>Vosticulos</th>
                <th>Paladar</th>
                <th>Piso Lengua</th>
                <th>Oculacion</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $estado->labios }}</td>
                <td>{{ $estado->lengua }}</td>
                <td>{{ $estado->encimas }}</td>
                <td>{{ $estado->atm }}</td>
                <td>{{ $estado->carrillos }}</td>
                <td>{{ $estado->vosticulos }}</td>
                <td>{{ $estado->paladar }}</td>
                <td>{{ $estado->piso_lengua }}</td>
                <td>{{ $estado->oculacion }}</td>
            </tr>
        </tbody>
    </table>
    <table border="1" cellspacing="0" cellpadding="6" width="100%"style="margin-top:20px;">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>A cuenta</th>
            <th>Saldo</th>
            <th>Costo</th>
            <th>Abono</th>
            <th>Tratamiento</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $presupuesto->fecha }}</td>
            <td>{{ $presupuesto->a_cuenta }}</td>
            <td>{{ $presupuesto->saldo }}</td>
            <td>{{ $presupuesto->costo }}</td>
            <td>{{ $presupuesto->abono }}</td>
            <td>{{ $presupuesto->tratamiento }}</td>
          </tr>
        </tbody>
      </table>
    <!-- Campos de firmas -->
    <div class="firma-campos">
        <div>Firma del Paciente</div>
        <div id="odontolgo">Firma del Odontólogo</div>
    </div>

</body>
</html>
