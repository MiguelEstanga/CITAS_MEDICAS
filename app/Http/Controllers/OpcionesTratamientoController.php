<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpcionesTratamiento;
class OpcionesTratamientoController extends Controller
{
    public function index()
    {
        return view('opciones_tratamiento.index' , [
            'tratamientos' => OpcionesTratamiento::all() ?? []
        ]);
    }
    public function store(Request $request)
    {
        $tratamiento = new OpcionesTratamiento;
        $tratamiento->label = $request->label;
        $tratamiento->color = $request->color;
        $tratamiento->save();
        return redirect()->route('opciones-tratamiento.index');
    }
    public function update(Request $request)
    {
        $tratamiento = OpcionesTratamiento::find($request->id);
        $tratamiento->label = $request->label;
        $tratamiento->color = $request->color;
        $tratamiento->save();
        return redirect()->route('opciones-tratamiento.index');
    }

    public function destroy($id)
    {
        $tratamiento = OpcionesTratamiento::find($id);
        $tratamiento->delete();
        return response()->json(['success' => true, 'message' => 'Metodo de pago eliminado exitosamente']);
    }
}
