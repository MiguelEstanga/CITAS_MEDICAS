<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Presupuesto;
use App\Models\ControlCita;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Odontogram;
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
           $presupuesto =  Presupuesto::create([
                'diagnostico' => $request->diagnostico,
                'observacion' => $request->observacion,
                'fecha' => $request->fecha,
                'a_cuenta' => $request->a_cuenta,
                'saldo' => $request->saldo,
                'cancelado' =>  $request->cancelado,
                'total' => 0,
                'id_user' =>  $request->id_usuario
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
            $presupuesto->saldo = $request->saldo;
        
            $presupuesto->save();
            return back()->with('mensaje', 'Presupuesto actualizado exitosamente');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function persupuesto_pdf($control_cita_id)
    {
        $control_citas = ControlCita::where('id', $control_cita_id)->first();
        $historia_medica =  $control_citas;
        $user =  $control_citas->evento->paciente;
        $html = view('pdf.presupuesto', [
            'presupuesto' =>  $control_citas->presupuesto,
            'user' => $user,
            'historia_medica' => $historia_medica
        ])->render();
        // 4) Configurar las opciones de Dompdf
        $options = new Options();
        // Por ejemplo, si usas fuentes con tildes/caracteres especiales, 
        // puedes cambiar la fuente predeterminada (o habilitar isRemoteEnabled si necesitas imágenes remotas):
        $options->set('defaultFont', 'DejaVu Sans');
        // $options->set('isRemoteEnabled', true);  // Útil si cargas imágenes desde URLs absolutas

        // 5) Instanciar Dompdf con las opciones indicadas
        $dompdf = new Dompdf($options);

        // 6) Cargar el HTML
        $dompdf->loadHtml($html);

        // 7) (Opcional) Ajustar tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait'); // 'portrait' (vertical) o 'landscape' (horizontal)

        // 8) Renderizar el PDF
        $dompdf->render();
        $pdfContent = $dompdf->output();

        // Construir respuesta con header "inline"
        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="reporte.pdf"');
        // 9) Retornar el PDF:
        //    - Para mostrarlo en el navegador, usamos `stream()`.
        //    - Para forzar la descarga, usaríamos `->download()` o algo similar.
        return $dompdf->stream('reporte_' . now()->format('Ymd_His') . '.pdf');
    }
}
