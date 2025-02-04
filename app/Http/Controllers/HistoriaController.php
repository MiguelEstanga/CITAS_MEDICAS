<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use App\Models\HistoriaMedica;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Odontogram;
use App\Models\Presupuesto;
use App\Http\Controllers\ReporteController;
use App\Models\MetodoDePago;
use Spatie\Browsershot\Browsershot;

class HistoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $usuario =  User::find($id);
    
        return view('historia_medica.index', [
            'presupuestos' => $usuario->presupuestos ?? [],
            'usuario' => $usuario ?? [],
            'id_usuario' => $usuario->id,
            'metodo_pagos' => MetodoDePago::all() ?? []
        ]);
    }


    public function ver_historia_medica($id)
    {
        $presupuesto = Presupuesto::find($id);
        $odontograma = json_decode($presupuesto->odontograma->data, true);
         $presupuesto->user;
    
        return view('historia_medica.ver_historia_medica', [
            'presupuesto' => $presupuesto,
            'datosOdontograma' => $odontograma
        ]);
    }

    
    public function create()
    {
        return view('historia_medica.create');
    }

   
    public function show(string $id)
    {
        return view('historia_medica.show', [
            'historiaMedica' => MedicalHistory::find($id)
        ]);
        
    }


   


    
}
