<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PresioCita;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventario;
use App\Models\Eventos;
class PanelController extends Controller
{
    public function index()
    {
        $eventos = Eventos::all();
        $inventario = Inventario::where('tipo_producto', 'inventario')->get();
        $medicamentos = Inventario::where('tipo_producto', 'medicamentos')->get();
         $usuario = User::role('paciente')->get();
        return view('panel.index' , [
            'eventos' => $eventos,
            'inventario' => $inventario,
            'medicamentos' => $medicamentos,
            'usuario' => $usuario
        ]);
    }

    //para el doctor
    public function guardar_precio_citas(Request $request)
    {
      
        $check =  PresioCita::where('doctor_id',  Auth::user()->id)->exists();
       
        if(!$check){
         $cita_precio = new PresioCita();
           $cita_precio->doctor_id = $request->doctor_id;
           $cita_precio->precio = $request->precio;
           $cita_precio->doctor_id = Auth::user()->id;
           $cita_precio->save();
        }
        else{
           $cita_precio = PresioCita::where('doctor_id', Auth::user()->id)->first();
           $cita_precio->doctor_id = $request->doctor_id;
           $cita_precio->precio = $request->precio;
           $cita_precio->save();
        }
        
        return back();
    }
}
