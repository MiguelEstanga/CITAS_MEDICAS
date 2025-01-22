<?php

use App\Models\User;
use App\Models\PacienteDoctor;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Auth;
use App\Models\ControlCita;

if (!function_exists('iconos')) {
   
    function iconos($icono)
    {
        $tamano = 16;
        switch ($icono) {
            case 'edit':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill=" #239b56 " class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
                              </svg>';
            case 'delete':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill="#cb4335" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                              </svg>';
            case 'show':
                return '<svg xmlns="ttp://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                        </svg>';
            case 'add':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill="#117a65" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                    </svg>';
            case 'add2':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill=" #d4ac0d " class="bi bi-cloud-plus-fill" viewBox="0 0 16 16">
                <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m.5 4v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0"/>
                </svg>';
            case 'enlista':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill="currentColor" class="bi bi-calendar2-check-fill" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5m-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                    </svg>';
            case 'ojo':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill="#b9770e" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                    </svg>';
            case 'historia':
                return '<svg xmlns="http://www.w3.org/2000/svg" width="'.$tamano.'" height="'.$tamano.'" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/>
                        </svg>';
        }
    }
}

if (!function_exists('user_default')) {
    function user_default()
    {
        return asset("storage" . '/imagen/user.jpg');
    }
}

if (!function_exists('user')) {
    function user()
    {
        return User::find(Auth::user()->id);
    }

    function esta_agregado($data = [], $conId = false)
    {
        $id_paciente = $data['id_paciente'];
        $id_doctor = $data['id_doctor'];

        // Verificar si existe la relación entre el paciente y el doctor
        $existe = PacienteDoctor::where('id_paciente', $id_paciente)
            ->where('id_doctor', $id_doctor)
            ->exists();

        if ($existe) {
            if ($conId) {
                // Obtener la relación si se requiere el ID
                $relacion = PacienteDoctor::where('id_paciente', $id_paciente)
                    ->where('id_doctor', $id_doctor)
                    ->first();

                // Devuelve el ID de la relación
                return $relacion->id;
            } else {
                // Devuelve true si la relación existe y no se requiere el ID
                return true;
            }
        } else {
            // Devuelve false si la relación no existe y no se requiere el ID
            if (!$conId) {
                return false;
            }

            // Devuelve null si se requiere el ID pero la relación no existe
            return null;
        }
    }

    function esta_solicitud($data = [], $conEstado = false)
    {
        $id_paciente = $data['id_paciente'];
        $id_doctor = $data['id_doctor'];

        // Verificar si existe la relación entre el paciente y el doctor
        $existe = Solicitud::where('id_paciente', $id_paciente)
            ->where('id_doctor', $id_doctor)
            ->exists();

        if ($existe) {
            if ($conEstado) {
                // Obtener la relación si se requiere el ID
                $relacion = Solicitud::where('id_paciente', $id_paciente)
                    ->where('id_doctor', $id_doctor)
                    ->first();

                // Devuelve el ID de la relación
                return $relacion->estado;
            } else {
                // Devuelve true si la relación existe y no se requiere el ID
                return true;
            }
        } else {
            // Devuelve false si la relación no existe y no se requiere el ID
            if (!$conEstado) {
                return false;
            }

            // Devuelve null si se requiere el ID pero la relación no existe
            return null;
        }
    }

    function precio($precio = 0, $moneda = "Bs")
    {
        switch ($moneda) {
            case "Bs":
                return "{$precio}bs";
            case "Bs.":
                return "{$precio}bs.";
            case "Bss":
                return "{$precio}bss";
            case "Bsss":
                return "{$precio}bsss";
            case "Bssss":
                return "{$precio}bssss";
            case "Bsssss":
                return "{$precio}bsssss";
        }
    }

    function role()
    {
        return Auth::user()->roles->first()->name;
    }

    function control_citas($evento_id)
    {
        return ControlCita::where('evento_id', $evento_id)->first();
    }
}
