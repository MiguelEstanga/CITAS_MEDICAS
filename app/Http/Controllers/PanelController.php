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

    // Datos para ModelA (Ventas): Agrupar por fecha y obtener el máximo por día
    $dailyVentas = Venta::where('created_at', '>=', Carbon::now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    $labelsA = $dailyVentas->pluck('date')->toArray(); // Fechas para el gráfico de ventas
    $maxVentasPerDay = $dailyVentas->pluck('count')->toArray(); // Cantidad máxima por día

    // Datos para ModelB (Presupuestos)
    $dailyModelB = Presupuesto::where('created_at', '>=', Carbon::now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // Total y cantidad cancelada en Presupuestos
    $totalPresupuestos = Presupuesto::sum('saldo'); // Suma total de los presupuestos
    $totalCancelado = Presupuesto::where('cancelado', 1)->sum('saldo'); // Suma de los montos cancelados

    // Obtener datos para los gráficos
    $labels = $dailyUsers->pluck('date')->toArray(); // Fechas (iguales para todos)
    $dataUsers = $dailyUsers->pluck('count')->toArray(); // Usuarios
    $dataModelB = $dailyModelB->pluck('count')->toArray(); // ModelB (Presupuestos)

    return view('panel.estadisticas', [
        'newUsersCount' => $newUsersCount,
        'labels' => $labels,
        'dataUsers' => $dataUsers,
        'labelsA' => $labelsA,
        'ventas' => $maxVentasPerDay, // Cantidad máxima de ventas por día
        'dataModelB' => $dataModelB,
        'totalPresupuestos' => $totalPresupuestos,
        'totalCancelado' => $totalCancelado,
    ]);
}

}
