<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PacienteDoctor;
use App\Models\Solicitud;
use Exception;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    public function pacientes()
    {
        $paciente =  User::role('paciente')->get();
        return view('pacientes.index', [
            'pacientes' => $paciente
        ]);
    }

    public function agregar_paciente(Request $request)
    {
        try {

            $paciente = PacienteDoctor::create([
                'id_paciente' => $request->id_paciente,
                'id_doctor' => $request->id_doctor,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Paciente agregado exitosamente',
                'data' => $paciente,
            ]);
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Paciente no encontrado');
        }
    }

    public function quitar_paciente(Request $request)
    {
        
        try {
            $paciente = PacienteDoctor::where('id_paciente', $request->id_paciente)
            ->where('id_doctor', $request->id_doctor)
            ->first();
            
            
            $paciente->delete();
            return response()->json([
                'success' => true,
                'message' => 'Paciente quitado exitosamente',
                'data' => $paciente,
            ]);
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Paciente no encontrado');
        }
    }

    public function solicitud()
    {
        $solicitudes = user()->solicitudes_doctor;
        return view('doctores.mis_solicitudes', [
            'solicitudes' => $solicitudes,
            'type' => 'doctor'
        ]);
    }


   

   
}
