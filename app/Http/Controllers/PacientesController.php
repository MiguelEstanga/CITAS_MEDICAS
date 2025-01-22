<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\Sintomas;
use Exception;
use Illuminate\Support\Facades\Log;

class PacientesController extends Controller
{
    public function doctores()
    {
        $doctores = User::role('paciente')->get();
        return view('doctores.index', [
            'doctores' => $doctores
        ]);
    }

    public function solicitud($id_doctor)
    {
        return view('doctores.solicitud', [
            'doctor' => User::find($id_doctor)
        ]);
    }

    public function enviar_solicitud($id_doctor, Request $request)
    {
        $sintomas = new Sintomas();


        try {
            $solicitud = Solicitud::create([
                'id_doctor' => $id_doctor,
                'id_paciente' => user()->id,
                'estado' => 'pendiente',
                'descripcion' => $request->descripcion,
            ]);

            foreach ($request->sintomas as $sintoma) {
                $sintomas->create([
                    'id_solicituds' => $solicitud->id,
                    'sintomas' => $sintoma,
                ]);
            }

            return back()->with('success', 'Solicitud enviada exitosamente');
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'No se pudo enviar la solicitud');
        }
        return $request->all();
    }

    public function mis_solicitudes()
    {
        $solicitudes = user()->solicitudes_paciente;
        return view('doctores.mis_solicitudes', [
            'solicitudes' => $solicitudes,
            'type' => 'paciente'
        ]);
    }
}
