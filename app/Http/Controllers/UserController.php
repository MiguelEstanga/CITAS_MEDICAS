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
        $administrador =  User::role('administrador')->get();
        return view('pacientes.index', [
            'pacientes' => $administrador,
            'type' => 'usuario'
        ]);
    }

    public function store(Request $request)
    {

        // Crear una nueva instancia de User
        $user = new User();

        // Verificar si se ha subido una imagen
        if ($request->hasFile('imagen')) {
            // Almacenar la imagen en el almacenamiento (storage) y guardar la ruta
            $filePath = $request->file('imagen')->store('images', 'public');

            $user->avatar =  $filePath; // Ajustar ruta para accesibilidad
        } else {
            $user->avatar = 'sistema/icono_diente.png';
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

    public function edit($id)
    {


        try {
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
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Usuario no encontrado');
        }
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        // Verificar si el correo electrónico ya está en uso, pero excluir el usuario actual
       

        // Si se ha subido una nueva imagen
        if ($request->hasFile('imagen')) {
            // Almacenar la imagen y actualizar el campo avatar
            $filePath = $request->file('imagen')->store('images', 'public');
            $user->avatar = $filePath;
        }

        // Actualizar los demás campos
        $user->name = $request->input('name');
     //   $user->email = $request->input('email');
        $user->telefono = $request->input('telefono');
        $user->cedula = $request->input('cedula');
        $user->edad = $request->input('edad');

        // Guardar los cambios
        $user->save();

        return back()->with('success', 'Usuario actualizado exitosamente');
    }
}
