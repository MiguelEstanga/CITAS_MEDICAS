<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PresioCita;
use App\Models\ControlCita;
use App\Models\Eventos;
use App\Models\HistoriaMedica;
use Illuminate\Support\Facades\Auth;
class CitasController extends Controller
{

  
    public function index( )
    {
        
        return view('citas.index' , [
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
        
        return view(
            'citas.control_citas',
            [
                'control_citas' => $control_citas,
                'evento' => $evento,
                'historia_medica' => $historia_medica
            ]
        );
    }
}
