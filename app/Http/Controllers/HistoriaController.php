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
class HistoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $usuario =  User::find($id);
         // return view('historia_medica.odontograma_sho' , ['odontograma' =>json_decode(Odontogram::find(2)->data )]);
        return view('historia_medica.index', [
            'presupuestos' => $usuario->presupuestos,
            'usuario' => $usuario,
            'id_usuario' => $usuario->id
        ]);
    }


    public function ver_historia_medica($id)
    {
        $presupuesto = Presupuesto::find($id);
        $odontograma = $presupuesto->odontograma->data;
       
        return view('historia_medica.ver_historia_medica', [
            'presupuesto' => $presupuesto,
            'odontograma' => json_decode($odontograma)
        ]);
    }
    //de aqui para bajo se eliminara
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('historia_medica.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        try {
           
            $historiaMedica = new HistoriaMedica();
            $historiaMedica->nombre_informe = $request->nombre_informe;
            $historiaMedica->antecedentes_familiares = $request->antecedentes_familiares;
            $historiaMedica->antecedentes_personales = $request->antecedentes_personales;
            $historiaMedica->motivo_consulta = $request->motivo_consulta;
            $historiaMedica->labios = $request->labios;
            $historiaMedica->encimas = $request->encimas;
            $historiaMedica->piso_de_boca = $request->piso_de_boca;
            $historiaMedica->vastibulos = $request->vastibulos;
            $historiaMedica->paladar = $request->paladar;
            $historiaMedica->carrillos = $request->carrillos;
            $historiaMedica->lengua = $request->lengua;
            $historiaMedica->atm = $request->atm;
            $historiaMedica->oclucion	 = $request->Oclucion;
            $historiaMedica->piso_de_boca = $request->piso_de_boca;
            $historiaMedica->id_paciente = $request->id_paciente;
            $historiaMedica->id_control_citas = $request->id_control_citas;
            $historiaMedica->save();
            return back()->with('message', 'Informe médico registrado con éxito.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('historia_medica.show', [
            'historiaMedica' => MedicalHistory::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $historiaMedica = MedicalHistory::find($id);
        return view('historia_medica.edit', [
            'historiaMedica' => $historiaMedica
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            $historiaMedica = MedicalHistory::find($id);

            // Actualiza los campos de texto
            $historiaMedica->nombre_informe = $request->nombre_informe;
            $historiaMedica->fecha_nacimiento = $request->fecha_nacimiento;
            $historiaMedica->doctor = $request->doctor;
            $historiaMedica->ultimo_diagnostico = $request->ultimo_diagnostico;
            $historiaMedica->genero = $request->genero;
            $historiaMedica->estado_civil = $request->estado_civil;
            $historiaMedica->antecedentes_familiares = $request->antecedentes_familiares;

            // Actualiza el archivo 'examen_fisico', eliminando el anterior si existe
            if ($request->file('examen_fisico')) {
                if ($historiaMedica->examen_fisico) {
                    Storage::disk('public')->delete($historiaMedica->examen_fisico);
                }
                $historiaMedica->examen_fisico = $request->file('examen_fisico')->store('pdfs', 'public');
            }

            // Actualiza el archivo 'lab_results', eliminando el anterior si existe
            if ($request->file('lab_results')) {
                if ($historiaMedica->lab_results) {
                    Storage::disk('public')->delete($historiaMedica->lab_results);
                }
                $historiaMedica->lab_results = $request->file('lab_results')->store('pdfs', 'public');
            }

            // Actualiza el archivo 'treatment_plan', eliminando el anterior si existe
            if ($request->file('treatment_plan')) {
                if ($historiaMedica->treatment_plan) {
                    Storage::disk('public')->delete($historiaMedica->treatment_plan);
                }
                $historiaMedica->treatment_plan = $request->file('treatment_plan')->store('pdfs', 'public');
            }

            // Guarda los cambios en la base de datos
            $historiaMedica->save();

            return back()->with('message', 'Informe médico actualizado con éxito.');
        } catch (Exception $e) {
            return back()->with('message', 'Error al actualizar el informe médico');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $historiaMedica = MedicalHistory::find($id);


            if ($historiaMedica->examen_fisico) {
                Storage::disk('public')->delete($historiaMedica->examen_fisico);
            }
            // Actualiza el archivo 'lab_results', eliminando el anterior si existe
            if ($historiaMedica->lab_results) {
                Storage::disk('public')->delete($historiaMedica->lab_results);
            }
            // Actualiza el archivo 'treatment_plan', eliminando el anterior si existe
            if ($historiaMedica->treatment_plan) {
                Storage::disk('public')->delete($historiaMedica->treatment_plan);
            }
            $historiaMedica->delete();
            return back()->with('message', 'Informe médico eliminado con éxito.');
        } catch (Exception $e) {
            return back()->with('message', 'Error al eliminar el informe médico');
        }
    }
}
