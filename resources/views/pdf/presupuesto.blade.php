<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Ficha Odontológica</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 20px;
            color: #000;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 20px;
            text-transform: uppercase;
        }

        /* Sección superior: datos del paciente */
        .datos-paciente {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .datos-paciente td {
            padding: 8px 4px;
            vertical-align: middle;
        }

        .datos-paciente td.label {
            width: 170px;
            /* Ajusta según tu preferencia */
            font-weight: bold;
            white-space: nowrap;
        }

        .linea {
            display: inline-block;
            border-bottom: 0.5px solid rgba(0, 0, 0, .5);
        }

        /* Título "Odontograma" centrado */
        h2 {
            text-align: center;
            margin: 10px 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        /* Odontograma */
        .odontograma-container {
            width: 100%;
            margin: 0 auto 20px auto;
            text-align: center;
        }

        .fila-odontograma {
            display: flex;
            justify-content: center;
            margin-bottom: 5px;
        }

        .diente {
            width: 40px;
            height: 40px;
            border: 1px solid #000;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 3px;
            font-weight: bold;
        }

     

        .examen-clinico td {
            padding: 2px;
          text-align: left;
           width: auto;
           position: relative;
         
        }
        .examen-clinico td {
            padding: 2px;
            text-align: left;
            width: auto;
            position: relative;

        }


        .examen-clinico {
            table-layout: auto;
            width: 100%;
            border-collapse: collapse;
            /* Opcional: quita el espacio entre celdas */
        }

        /* A las celdas que son "etiquetas" les ponemos ancho automático
       y forzamos que el texto no haga salto de línea */
        .examen-clinico td.label {
            white-space: nowrap;
            width: 1px;
            /* Deja que el contenido dicte el tamaño */
            padding: 0 8px;
            /* Ajusta el espaciado interno si lo deseas */
        }

        /* Para los td que tienen input, usamos ancho 100%
       y box-sizing para que no se descuadre si hay padding o border */
        .examen-clinico td input {
            width: 100%;
            box-sizing: border-box;
        }

        .examen-clinico td input[type="text"] {
            width: 100%;
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            position: relative;
            top: 1px;
            right: 3px;
        }

        /* Pedido de exámenes */
        .pedido-examenes {
           
        }

        .pedido-examenes label {

            display: block;

            font-size: 8px !important;
        }

        .pedido-examenes input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            padding: 5px 0;
        }

        /* Tabla de tratamientos */
        .tabla-tratamientos {
           margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabla-tratamientos th,
        .tabla-tratamientos td {
            border: 1px solid #000;
            text-align: center;
           padding: 2px;
            font-size: 9px;
        }

        .tabla-tratamientos th {
            background-color: #f2f2f2;
        }

        /* Se puede ajustar el ancho de cada columna si se desea */
        .col-fecha {
            width: 80px;
        }

        .col-tratamiento {
            width: 300px;
            text-align: left;
        }

        .col-costo,
        .col-abono,
        .col-saldo {
            width: 70px;
        }

        .col-firma {
            width: 120px;
        }

        /* Firmas (Paciente y Odontólogo) */
        .firmas {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .firmas .firma-box {
            width: 40%;
            text-align: center;
        }

        .firmas .line-firma {
            width: 80%;
            border-top: 1px solid #000;
            margin: 50px auto 10px auto;
            height: 0;
        }

        .firmas p {
            margin-top: 0;
        }

        .inline-block {
            display: inline-block;
        }

        /* Para impresión */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

        }
    </style>
</head>

<body>

    <h1>Ficha Odontológica</h1>

    <!-- Sección de datos personales -->
    <div>
        <div style="display: flex;">
            <div class="inline-block">
                Nombre y Apellido :
            </div>
            <div class="linea" style="min-width: 500px; ">
                {{$user->name}} {{$user->last_name}}
            </div>
            <div class="inline-block">
                Edad :
            </div>
            <div class="linea" style="min-width: 100px ">
                Edad
            </div>
        </div>
        <div style="display: flex;" style="margin-top:10px;">
            <div class="inline-block">
                Domicilio:
            </div>
            <div class="linea" style="min-width: 680px; ">
                nombre
            </div>

        </div>
        <div style="display: flex;" style="margin-top:10px;">
            <div class="inline-block">
                Antecedentes Personales:
            </div>
            <div class="linea" style="min-width: 610px; ">
                {{$historia_medica->antecedentes_personales ?? ""}}
            </div>

        </div>
        <div style="display: flex;" style="margin-top:10px;">
            <div class="inline-block">
                Antecedentes Familiares:
            </div>
            <div class="linea" style="min-width: 610px; ">
              {{$historia_medica->antecedentes_familiares ?? ''}}
            </div>

        </div>
        <div style="display: flex;" style="margin-top:10px;">
            <div class="inline-block">
                Motivo de la Consulta :
            </div>
            <div class="linea" style="min-width: 620px; ">
              {{$historia_medica->nombre_informe ?? ""}}
            </div>

        </div>
    </div>

    <!-- ODONTOGRAMA -->
    <h2>Odontograma</h2>
    <div class="odontograma-container">
        <!-- Fila 1 -->
        <div class="fila-odontograma">
            <div class="diente">18</div>
            <div class="diente">17</div>
            <div class="diente">16</div>
            <div class="diente">15</div>
            <div class="diente">14</div>
            <div class="diente">13</div>
            <div class="diente">12</div>
            <div class="diente">11</div>
            <div class="diente">21</div>
            <div class="diente">22</div>
            <div class="diente">23</div>
            <div class="diente">24</div>
            <div class="diente">25</div>
            <div class="diente">26</div>
            <div class="diente">27</div>
            <div class="diente">28</div>
        </div>
        <!-- Fila 2 -->
        <div class="fila-odontograma">
            <div class="diente">55</div>
            <div class="diente">54</div>
            <div class="diente">53</div>
            <div class="diente">52</div>
            <div class="diente">51</div>
            <div class="diente">61</div>
            <div class="diente">62</div>
            <div class="diente">63</div>
            <div class="diente">64</div>
            <div class="diente">65</div>
        </div>
        <!-- Fila 3 -->
        <div class="fila-odontograma">
            <div class="diente">85</div>
            <div class="diente">84</div>
            <div class="diente">83</div>
            <div class="diente">82</div>
            <div class="diente">81</div>
            <div class="diente">71</div>
            <div class="diente">72</div>
            <div class="diente">73</div>
            <div class="diente">74</div>
            <div class="diente">75</div>
        </div>
        <!-- Fila 4 -->
        <div class="fila-odontograma">
            <div class="diente">48</div>
            <div class="diente">47</div>
            <div class="diente">46</div>
            <div class="diente">45</div>
            <div class="diente">44</div>
            <div class="diente">43</div>
            <div class="diente">42</div>
            <div class="diente">41</div>
            <div class="diente">31</div>
            <div class="diente">32</div>
            <div class="diente">33</div>
            <div class="diente">34</div>
            <div class="diente">35</div>
            <div class="diente">36</div>
            <div class="diente">37</div>
            <div class="diente">38</div>
        </div>
    </div>

    <!-- EXAMEN CLÍNICO -->
    <table class="examen-clinico">
        <tr style="margin-bottom: 10px;">
            <td class="label">Labios:</td>
            <td><input type="text" value="{{$historia_medica->labios}}" /></td>
            <td class="label">Encías:</td>
            <td><input type="text" value="{{$historia_medica->encimas}}" /></td>
            <td class="label">Piso de Boca:</td>
            <td><input type="text" value="{{$historia_medica->piso_de_boca}}"  /></td>
        </tr>
        <tr style="margin-top: 10px;">
            <td class="label">Vestíbulos:</td>
            <td><input type="text" value="{{$historia_medica->vastibulos}}"  /></td>
            <td class="label">Paladar:</td>
            <td><input type="text"value="{{$historia_medica->paladar}}"  /></td>
            <td class="label">Carrillos:</td>
            <td><input type="text" value="{{$historia_medica->carrillos}}"  /></td>
        </tr>
        <tr>
            <td class="label">Lengua:</td>
            <td><input type="text" value="{{$historia_medica->lengua}}"  /></td>
            <td class="label">ATM:</td>
            <td><input type="text" value="{{$historia_medica->atm}}"  /></td>
            <td class="label">Oclusión:</td>
            <td><input type="text"  value="{{$historia_medica->oclucion	}}"  /></td>
        </tr>
    </table>

    <!-- PEDIDO DE EXÁMENES -->
    <div class="pedido-examenes">
        <label for="pedido">Pedido de Exámenes:</label>
        <input type="text" id="pedido" />
    </div>

    <!-- TABLA DE TRATAMIENTOS -->
    <table class="tabla-tratamientos">
        <thead>
            <tr>
                <th class="col-fecha">Fecha</th>
                <th class="col-tratamiento">Tratamiento Realizado</th>
                <th class="col-costo">Costo</th>
                <th class="col-abono">Abono</th>
                <th class="col-saldo">Saldo</th>
                <th class="col-firma">Firma</th>
            </tr>
        </thead>
        <tbody>
            <!-- Filas en blanco para ir llenando -->
            @foreach ($presupuesto as $item)
                <tr>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->tratamiento }}</td>
                    <td>{{ $item->costo }}</td>
                    <td>{{ $item->abono }}</td>
                    <td>{{ $item->saldo }}</td>
                    <td>{{ $item->firma }}</td>
                </tr>
            @endforeach
            <!-- Agrega más filas según sea necesario -->
        </tbody>
    </table>

    <!-- FIRMAS -->
    <div class="firmas" >
        <div class="firma-box" style="display: inline-block; margin:auto;">
            <div class="line-firma"></div>
            <p>Firma del Paciente</p>
        </div>
        <div class="firma-box" style="display: inline-block; margin:auto;">
            <div class="line-firma"></div>
            <p>Firma del Odontólogo</p>
        </div>
    </div>

</body>

</html>
