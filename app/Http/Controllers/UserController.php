<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index' , [
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        /** 
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar imagen opcional
        ]);*/

        // Crear una nueva instancia de User
        $user = new User();
      
        // Verificar si se ha subido una imagen
        if ($request->hasFile('imagen')) {
            // Almacenar la imagen en el almacenamiento (storage) y guardar la ruta
            $filePath = $request->file('imagen')->store('images' , 'public');
         
            $user->avatar =  $filePath; // Ajustar ruta para accesibilidad
        }

        

        // Asignar otros campos al modelo User
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Encriptar la contraseña
        $user->cedula = $request->input('cedula');
        $user->edad = $request->input('edad');
        $user->telefono = $request->input('telefono');
        // Guardar el usuario en la base de datos
        $user->save();

        // Asignar rol al usuario (tabla model_has_roles)
        DB::table('model_has_roles')->insert([
            'role_id' => $request->input('role'),
            'model_type' => User::class, // Clase del modelo
            'model_id' => $user->id,    // ID del usuario creado
        ]);
        
        // Redirigir con mensaje de éxito
        return back()->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id){
      
      
        try{
            $user = User::find($id);
            
            $rolesSelect = [];
            $roles = DB::table('roles')->get();
            foreach ($roles as $role) {
                $rolesSelect[$role->id] = $role->name;
            }
           
            return view('admin.user.edit', [
                'user' => $user,
                'roles' => $rolesSelect,
            ]);
        }catch(Exception $e){
            Log::info($e);
            return back()->with('error', 'Usuario no encontrado');
           
        }
       
    }

    public function update( $id , Request $request){
        $user = User::find($id);
        if(  $request->hasFile('imagen')){
            $filePath = $request->file('imagen')->store('images' , 'public');
            $user->avatar =  $filePath;

        }
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->telefono = $request->input('telefono');
        $user->cedula = $request->input('cedula');
        $user->edad = $request->input('edad');
        $user->save();
       // DB::table('model_has_roles')->where('model_type', 'App\Models\User')->where('model_id', $id)->update(['role_id' => $request->input('role')]);
       
        return back()->with('success', 'Usuario actualizado exitosamente');
    }
}
