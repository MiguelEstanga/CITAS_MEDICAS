<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PresioCita;
use App\Models\ControlCita;
use App\Models\Eventos;
use App\Models\HistoriaMedica;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
class CitasController extends Controller
{

  
    public function index( )
    {
        
        return view('citas.index' , [
            'pacientes' => User::role('paciente')->get()
        ]);
    }

    public function mis_citas(){
        $mis_citas = Eventos::where('id_doctor', Auth::user()->id)->get();
      
        return view(
            'citas.mis_citas',
            [
                'mis_citas' => $mis_citas
            ]
        );
    }

    public function control_citas($id){
        $control_citas = ControlCita::where('id', $id)->first();
          $historia_medica =  $control_citas;
        $evento = $control_citas->evento;
        return 0;
        return view(
            'citas.control_citas',
            [
                'control_citas' => $control_citas,
                'evento' => $evento,
                'historia_medica' => $historia_medica
            ]
        );
    }

    public function destroy($id)
    {
        try {
            $evento = Eventos::findOrFail($id);
            $evento->delete();
            return response()->json(['success' => true, 'message' => 'Evento eliminado exitosamente']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el evento']);
        }
    }
}
