<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Inventario;
use App\Models\User;

class ReporteController extends Controller
{
    public function Pdf($data)
    {
        $view = $data['view'];
        $var = $data['var'];
        $html = view("{$view}", $var)->render();

        $options = new Options();
        // Por ejemplo, si usas fuentes con tildes/caracteres especiales, 
        // puedes cambiar la fuente predeterminada (o habilitar isRemoteEnabled si necesitas imágenes remotas):
        $options->set('defaultFont', 'DejaVu Sans');
       //  $options->set('isRemoteEnabled', true);  // Útil si cargas imágenes desde URLs absolutas
      
        // 5) Instanciar Dompdf con  las opciones indicadas
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

    public function reporte_presupuesto(Request $request)
    {
        $fecha_inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_fin = Carbon::parse($request->fecha_fin)->endOfDay();

        $eventos = Eventos::where('created_at', '>=', $fecha_inicio)
            ->where('created_at', '<=', $fecha_fin)
            ->get();

        return $this->Pdf([
            'view' => 'pdf.eventos',
            'var' => [
                'presupuesto' => $eventos,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]
        ]);
    }

    public function reporte_inventario(Request $request)
    {
        $fecha_inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_fin = Carbon::parse($request->fecha_fin)->endOfDay();

        $inventario = Inventario::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
            ->where('tipo_producto', 'inventario')
            ->get();


        return $this->Pdf([
            'view' => 'pdf.inventario',
            'var' => [
                'inventario' => $inventario,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]
        ]);
    }

    public function reporte_medicamentos(Request $request)
    {
        $fecha_inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_fin = Carbon::parse($request->fecha_fin)->endOfDay();

        $medicamentos = Inventario::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
            ->where('tipo_producto', 'medicamentos')
            ->get();


        return $this->Pdf([
            'view' => 'pdf.inventario',
            'var' => [
                'medicamentos' => $medicamentos,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]
        ]);
    }

    public function reporte_usuarios(Request $request)
    {
        $fecha_inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_fin = Carbon::parse($request->fecha_fin)->endOfDay();

        $usuario = User::where('created_at', '>=', $fecha_inicio)
            ->where('created_at', '<=', $fecha_fin)
            ->get();

        return $this->Pdf([
            'view' => 'pdf.user',
            'var' => [
                'usuario' => $usuario,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]
        ]);
    }
}
