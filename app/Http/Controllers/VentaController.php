<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Exception;
use Illuminate\Support\Facades\Log;
class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('ventas.index', [
            'ventas' => $ventas
        ]);
    }
    public function store(Request $request)
    {
       
       try{
        $venta = new Venta();
        $venta->id_usuario = user()->id;
        $venta->id_servicio = $request->id;
        $venta->nombre = $request->nombre;
        $venta->apellido = $request->apellido;
        $venta->cedula = $request->cedula;
        $venta->telefono = $request->telefono;
        $venta->fecha = $request->fecha;
        $venta->precio = $request->precio;
        $venta->save();
        return redirect()->route('venta.index');
       }catch(Exception $e){
        Log::info($e);
       
        return back()->with('error', 'Error al crear venta');
       }
    }

    public function update( Request $request)
    {
        try {
            $venta = Venta::findOrFail($request->id);
            $venta->nombre = $request->nombre;
            $venta->apellido = $request->apellido;
            $venta->cedula = $request->cedula;
            $venta->telefono = $request->telefono;
            $venta->fecha = $request->fecha;
            $venta->precio = $request->precio;
            $venta->save();
            return back()->with('success', 'Venta actualizada exitosamente');
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Error al actualizar venta');
        }
    }

    public function  destroy(Request $request)
    {
        try {
            $venta = Venta::find($request->id);
            $venta->delete();
            return back()->with('success', 'Venta eliminada exitosamente');
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Error al eliminar venta');
        }
    }
}
