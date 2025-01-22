<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\PacienteDoctor;
use App\Models\SolicitudRespuesta;
class SolicitudController extends Controller
{
    public function responder_solicitud($id_solicitud)
    {
        $solicitud = Solicitud::find($id_solicitud);
        return view('doctores.responder_solicitud', [
            'solicitud' => $solicitud
        ]);
    }

    public function responder_solicitud_store($id_solicitud, Request $request)
    {
       
        $solicitud_respuesta = new SolicitudRespuesta();
        $solicitud = Solicitud::find($id_solicitud);
        $solicitud->estado = $request->estado;

        $solicitud->save();
        $solicitud_respuesta->id_solicituds = $id_solicitud;
        $solicitud_respuesta->user_type = user()->roles->first()->name;
        $solicitud_respuesta->mensaje = $request->descripcion;
        $solicitud_respuesta->save();
        return back()->with('success', 'Solicitud respondida exitosamente');
    }

    public function conversacion_store($id_solicitud, Request $request)
    {
        $solicitud_respuesta = new SolicitudRespuesta();
        $solicitud_respuesta->id_solicituds = $id_solicitud;
        $solicitud_respuesta->user_type = user()->roles->first()->name;
        $solicitud_respuesta->mensaje = $request->mensaje;
        $solicitud_respuesta->save();
        return back()->with('success', 'Solicitud respondida exitosamente');
    }
}
