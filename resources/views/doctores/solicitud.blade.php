@extends('layout.app')

@section('content')
    <div class="mb-2 header-container text-center">
        <p class="text-white">
            Rellene el formulario para solicitar al doctor
        </p>
    </div>
    <div class="">
        <form action="{{route('doctores.enviar_solicitud' , $doctor->id)}}" method="POST" class="form-container">
            @csrf
            <div class="form-group mb-4">
                <label for="descripcion" class="form-label text-white mb-4">Descripción de la solicitud</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-control"
                    placeholder="Escriba la descripción detallada de su solicitud..." required></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="sintomas" class="form-label text-white mb-4">Síntomas</label>
                <div id="sintomas-container">
                    <!-- Primer campo de síntomas -->
                    <div class="input-group mb-2 sintoma-item">
                        <input type="text" name="sintomas[]" class="form-control" placeholder="Escriba un síntoma"
                            required>
                        <button type="button" class="btn btn-danger btn-sm btn-remove">
                            Eliminar
                        </button>
                    </div>
                </div>
                <button type="button" id="add-sintoma" class="btn btn-primary mt-2">
                    Agregar otro síntoma
                </button>
            </div>

            <button type="submit" class="btn btn-success">Enviar solicitud</button>
        </form>
    </div>

    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .form-container {

            margin: 0 auto;
            padding: 20px;
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .form-label {
            font-weight: bold;
            color: #ffffff;
        }

        .form-control {
            background-color: #2a2a2a;
            color: #ffffff;
            border: 1px solid #444;
        }

        .form-control::placeholder {
            color: #ffffff;
            /* Cambia el color del placeholder */
            opacity: 0.7;
            /* Ajusta la opacidad del placeholder (opcional) */
        }

        .form-control:focus {
            background-color: #2a2a2a;
            color: #ffffff;
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
        }

        .btn {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #a71d2a;
            border-color: #a71d2a;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
        }

        .text-white {
            color: #ffffff;
        }
    </style>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sintomasContainer = document.getElementById('sintomas-container');
        const addSintomaButton = document.getElementById('add-sintoma');

        // Agregar un nuevo campo de síntoma
        addSintomaButton.addEventListener('click', function() {
            const newSintoma = document.createElement('div');
            newSintoma.classList.add('input-group', 'mb-2', 'sintoma-item');
            newSintoma.innerHTML = `
                    <input type="text" name="sintomas[]" class="form-control" placeholder="Escriba un síntoma" required>
                    <button type="button" class="btn btn-danger btn-sm btn-remove">
                        Eliminar
                    </button>
                `;
            sintomasContainer.appendChild(newSintoma);
        });

        // Eliminar un campo de síntoma
        sintomasContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove')) {
                const itemToRemove = event.target.closest('.sintoma-item');
                sintomasContainer.removeChild(itemToRemove);
            }
        });
    });
</script>
