<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inventario;
use Exception;
use Illuminate\Support\Facades\Log;
use  Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function item($items){
        $inventario = Inventario::findOrFail($items);
        return response()->json($inventario);
    }

    public function index()
    {
        $inventario = Inventario::where('tipo_producto', '=', 'medicamentos')->get();
        return view('inventario.index' , [
            'inventario' => $inventario,
            'tipos_productos' => 'medicamentos'
        ]);
    }
    

    public function inventarios()
    {
        $inventario = Inventario::where('tipo_producto', '=', 'inventario')->get();
        $estado = DB::table('estado_inventarios')->get();
        return view('inventario.index' , [
            'inventario' => $inventario,
            'tipos_productos' => 'inventario',
            'estados' => $estado
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
            'estado' => 'required'
        ]);
        try{
            $inventario = new Inventario();
            $inventario->nombre = $request->nombre;
            $inventario->descripcion = $request->descripcion;
            $inventario->precio = $request->precio;
            $inventario->cantidad = $request->cantidad;
            $inventario->imagen = $request->hasFile('imagen') ? $request->file('imagen')->store('imagen_inventario', 'public') : 'sistema/default_inventario.png';
            $inventario->tipo_producto = $request->tipo_producto;
            $inventario->estado = $request->estado;
            $inventario->save();
            return back()->with('mensaje', 'Item creado exitosamente');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return back()->with('mensaje', $e->getMessage());
        }
       
    }

    public function update(Request $request, $item_id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
        ]);
        try{
            $inventario = Inventario::findOrFail($item_id);
            $inventario->nombre = $request->nombre;
            $inventario->descripcion = $request->descripcion;
            $inventario->precio = $request->precio;
            $inventario->cantidad = $request->cantidad;
            if(  $request->hasFile('imagen') ){
                $inventario->imagen = $request->file('imagen')->store('imagen_inventario', 'public');
            }
            $inventario->save();
            return back()->with('mensaje', 'Item actualizado exitosamente');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return back()->with('mensaje', $e->getMessage());
        }
       
    }
    public function destroy($items)
    {
        try{
            $inventario = Inventario::findOrFail($items);
            $inventario->delete();
            return response()->json(['success' => true, 'message' => 'Item eliminado exitosamente']);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return back()->with('mensaje', $e->getMessage());
        }
    }

    //aumenta cantidad
    public function aumentar_cantidad(Request $request)
    {
        try{
            $inventario = Inventario::findOrFail($request->item_id);
            $inventario->cantidad = $request->cantidad;
            $inventario->save();
            return back()->with('mensaje', 'Cantidad aumentada exitosamente');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return back()->with('mensaje', $e->getMessage());
        }
    }
}
