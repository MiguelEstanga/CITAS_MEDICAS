<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Presupuesto;
use App\Models\ControlCita;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\MetodoDePago;
use App\Models\Odontogram;
use App\Models\EstadoBucal;
class PresupuestoController extends Controller
{   
    public function odontograma_store(Request $request)
    {
        $odontograma = new Odontogram();
       
        $odontograma->data = json_encode($request->data);  // Se guardará como JSON automáticamente
        $odontograma->save();

        return response()->json([
            'success' => true,
            'message' => 'Odontograma guardado exitosamente',
            'odontograma_id' => $odontograma->id
        ]);
    }
    public function store(Request $request)
    {
       
        try {
            Log::error($request->fecha);
           $metodo = MetodoDePago::where('id', $request->metodo_de_pago)->first();
           $presupuesto =  Presupuesto::create([
                'diagnostico' => $request->diagnostico,
                'observacion' => $request->observacion,
                'fecha' => $request->fecha,
                'a_cuenta' => $request->a_cuenta,
                'saldo' => $request->saldo,
                'cancelado' =>  $request->cancelado,
                'total' => 0,
                'id_user' =>  $request->id_usuario,
                'metodo_de_pago' => $metodo->name,
                'costo' => $request->costo,
                'abono' => $request->abono,
                'tratamiento' => $request->tratamiento,
                'motivo_consulta' => $request->motivo_consulta
            ]);

            EstadoBucal::create([
                'labios' => $request->labios,
                'lengua' => $request->lengua,
                'encimas' => $request->encimas,
                'atm' => $request->atm,
                'carrillos' => $request->carrillos,
                'examenes' => $request->examenes,
                'vosticulos' => $request->vosticulos,
                'paladar' => $request->paladar,
                'piso_lengua' => $request->piso_lengua,
                'oculacion' => $request->oculacion,
                'id_presupuesto' => $presupuesto->id
            ]);
            $odontograma = new Odontogram();
            $odontograma->data =  json_encode($request->odontograma);
            $odontograma->presupuestos_id = $presupuesto->id;
            $odontograma->save();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Presupuesto creado exitosamente',
                    'data' => $presupuesto,
                    'odontograma' => $odontograma
                 
                ]
            );
            return back()->with('mensaje', 'Presupuesto creado exitosamente');
        } catch (Exception $e) {
            Log::error($request);
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
    public function updateCancelado(Request $request)
    {
       
        try {
            $presupuesto = Presupuesto::findOrFail($request->id);
            $presupuesto->cancelado = $request->cancelado;
            $presupuesto->save();
            return response()->json([
                'success' => true,
                'message' => 'Presupuesto actualizado exitosamente',
                'data' => $presupuesto
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
    public function update($id, Request $request)
    {
        
        try {
            $presupuesto = Presupuesto::findOrFail($id);
            $presupuesto->fecha = $request->fecha;
            $presupuesto->tratamiento = $request->tratamiento;
            $presupuesto->costo = $request->costo;
            $presupuesto->abono = $request->abono;
            $presupuesto->saldo = $request->costo - $request->abono;
        
            $presupuesto->save();
            return back()->with('mensaje', 'Presupuesto actualizado exitosamente');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
    public function ver_historia_medica($id)
    {
        $presupuesto = Presupuesto::find($id);
        $odontograma = json_decode($presupuesto->odontograma->data, true);
        $estado = EstadoBucal::where('id_presupuesto', $id)->first();
       
    
        return view('historia_medica.ver_historia_medica', [
            'presupuesto' => $presupuesto,
            'datosOdontograma' => $odontograma,
            'estado' => $estado
        ]);
    }
    public function persupuesto_pdf($id)
    {
       $presupuesto = Presupuesto::where('id', $id)->first();
       
       $odontograma = json_decode($presupuesto->odontograma->data, true);
        $estado = EstadoBucal::where('id_presupuesto', $id)->first();
       return ReporteController::Pdf([
           'view' => "historia_medica.pdf.odontograma",
           'var' => [
              'datosOdontograma' => $odontograma,
              'presupuesto' => $presupuesto,
              'estado' => $estado
           ]
       ]);
    }

    public function eliminar($id)
    {
        $presupuesto = Presupuesto::find($id);
        if ($presupuesto) {
            $presupuesto->delete();
            return response()->json(['success' => true, 'message' => 'Presupuesto eliminado exitosamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se pudo eliminar el presupuesto']);
        }
    }
}
