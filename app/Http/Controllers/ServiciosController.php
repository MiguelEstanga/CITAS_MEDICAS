<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;
use Exception;
use Illuminate\Support\Facades\Log;
class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicios::where('estado' ,1)->get();
        return view('servicios.index', [
            'servicios' => $servicios
        ]);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imagen = "";
        if ($request->hasFile('imagen')) {
            $filePath = $request->file('imagen')->store('images' , 'public');
            $imagen = $filePath;
        }
        Servicios::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $imagen,
            'precio' => $request->precio,
            'estado' => 1,

        ]);

        return redirect()->route('servicios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $servicio = Servicios::findOrFail($request->id);
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio = $request->precio;
        $servicio->save();
        return back()->with('success', 'Servicio actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $items)
    {
        
        try {
            $servicio = Servicios::findOrFail($items);
            if($servicio->estado == 1){
                $servicio->estado = 0;
            }
            $servicio->save();
            return response()->json([
                'success' => true,
                'message' => 'Servicio eliminado exitosamente',
                'data' => $servicio,
            ]);
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Servicio no encontrado');
        }
    }
}
