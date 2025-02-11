<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos;
use Exception;
use App\Models\User;
use App\Models\ControlCita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class EventosCalendarController extends Controller
{
    public function eventos($usuario_id)
    {
        $usuario = User::find($usuario_id);
        Log::info($usuario->events);
        return response()->json($usuario->events);
    }
    public function store(Request $request)
    {
       
        try {
            $start = "{$request->fecha} {$request->hora_inicio}";
            $end = "{$request->fecha} {$request->hora_fin}";
          
            $user = User::find($request->id_paciente);
            $evento = Eventos::create([
                'title' => $request->titulo . ' - ' . $user->name . ' - ' . $user->name,
                'start' => $start,
                'end' => $end,
                'id_user' => user()->id,
                
                'color' => $request->color,
            ]);
           
           
            return back();
        } catch (Exception $e) {
            // Eliminar el evento si fue creado
            if (isset($evento)) {
                $evento->delete();
            }
        
            // Eliminar el control de cita si fue creado
            if (isset($controlCita)) {
                $controlCita->delete();
            }
        
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al crear el evento']);
        }
        
    }

    public function destroy($id)
    {
        try {
            $evento = Eventos::findOrFail($id);
            $evento->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al eliminar el evento']);
        }
    }

    public function update(Request $request, $id)
    {
        
        try {
            $start = "{$request->fecha} {$request->hora_inicio}:00";
            $end = "{$request->fecha} {$request->hora_fin}:00";

            $evento = Eventos::findOrFail($id);
            $evento->update([
                'title' => $request->titulo,
                'start' => $start,
                'end' => $end,
                'color' => $request->color,
            ]);
            return back();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error al actualizar el evento']);
        }
    }
}
