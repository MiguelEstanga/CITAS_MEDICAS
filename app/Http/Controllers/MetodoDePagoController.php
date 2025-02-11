<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoDePago;
class MetodoDePagoController extends Controller
{
    public function index()
    {
        
        return view('metodo_de_pago.index' , [
            'metodoPago' => MetodoDePago::all()
        ]);
    }

    public function update(Request $request)
    {
       
        $metodo = MetodoDePago::find($request->id );
        $metodo->name = $request->name;
        $metodo->save();
        return back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $metodo = new MetodoDePago();
        $metodo->name = $request->name;
        $metodo->save();
        return back();
    }

    public function destroy($id)
    {
        $metodo = MetodoDePago::find($id);
        $metodo->delete();
        return response()->json(['success' => true, 'message' => 'Metodo de pago eliminado exitosamente']);
    }
}
