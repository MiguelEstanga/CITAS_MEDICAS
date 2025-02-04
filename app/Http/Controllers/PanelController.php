<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PresioCita;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventario;
use App\Models\Eventos;
use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Presupuesto;

class PanelController extends Controller
{
    public function index()
    {
        $eventos = Eventos::all();
        $inventario = Inventario::where('tipo_producto', 'inventario')->get();
        $medicamentos = Inventario::where('tipo_producto', 'medicamentos')->get();
        $usuario = User::role('paciente')->get();
        return view('panel.index', [
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

        if (!$check) {
            $cita_precio = new PresioCita();
            $cita_precio->doctor_id = $request->doctor_id;
            $cita_precio->precio = $request->precio;
            $cita_precio->doctor_id = Auth::user()->id;
            $cita_precio->save();
        } else {
            $cita_precio = PresioCita::where('doctor_id', Auth::user()->id)->first();
            $cita_precio->doctor_id = $request->doctor_id;
            $cita_precio->precio = $request->precio;
            $cita_precio->save();
        }

        return back();
    }


    public function estadisticas()
    {
        $newUsersCount = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Datos para usuarios
        $dailyUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        


        // Obtener datos para los gráficos
        $labels = $dailyUsers->pluck('date')->toArray(); // Fechas (iguales para todos)
        $dataUsers = $dailyUsers->pluck('count')->toArray(); // Usuarios
      
        return view('panel.estadisticas', [
            'newUsersCount' => $newUsersCount,
            'labels' => $labels,
            'dataUsers' => $dataUsers,
            'edadPromedio' => User::edadPromedioPacientes() ?? 0,
            'presupuestos' => $this->presupuestos()['abonos'],
            'totalCosto' => $this->graficosPastel()['totalCosto'],
            'totalAbono' => $this->graficosPastel()['totalAbono'],
            'totalSaldo' => $this->graficosPastel()['totalSaldo']
        ]);
    }
    public function graficosPastel()
    {
        // Obtener sumatorias totales
        $totalCosto = Presupuesto::sum('costo');
        $totalAbono = Presupuesto::sum('abono');
        $totalSaldo = Presupuesto::sum('saldo');

        return [
            'totalCosto' => $totalCosto,
            'totalAbono' => $totalAbono,
            'totalSaldo' => $totalSaldo
        ];
    }
    public function presupuestos()
    {
        $presupuestos = Presupuesto::all()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->fecha)->format('Y-m');
            })
            ->map(function ($monthItems) {
                return [
                    'abonos' => $monthItems->sum('abono'),
                    'costos' => $monthItems->sum('costo')
                ];
            });

        // Rellenar meses sin datos
        $startDate = \Carbon\Carbon::now()->subYear();
        $endDate = \Carbon\Carbon::now();

        while ($startDate <= $endDate) {
            $key = $startDate->format('Y-m');
            if (!isset($presupuestos[$key])) {
                $presupuestos[$key] = ['abonos' => 0, 'costos' => 0];
            }
            $startDate->addMonth();
        }

        // Ordenar por fecha
        return  [
            'abonos' => $presupuestos->pluck('abonos'),
            'costos' => $presupuestos->pluck('costos')
        ];
    }
}
