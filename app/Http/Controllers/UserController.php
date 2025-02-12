<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    public function verificacion($email)
    {
        try {
            $user = User::where('email', $email)->exists();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario verificado exitosamente',
                    'data' => $user,
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Usuario no verificado',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            Log::info($e);
            return back()->with('error', 'Usuario no encontrado');
        }
    }
    public function index($type)
    {
        $role = DB::table('roles')->get();
        $usuarios =  User::role('administrador')->get();
        if ($type === 'paciente') {
            $usuarios =  User::role('paciente')->get();
        } else {
            $usuarios = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'paciente');
            })
                ->where('id', '!=', 1) // Excluir al usuario con ID 1
                ->get();
        }
        return view('pacientes.index', [
            'pacientes' => $usuarios,
            'type' => $type,
            'roles' => $role
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:18',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:18',
            'direccion' => 'required|max:60',
            'email' => 'required|email|unique:users,email',
            'cedula' => 'required|numeric',
            'edad' => 'required|numeric',
            'telefono' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Revise el formulario');
        }

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
        $user->antecedentes_familiares = $request->input('antecedentes') ?? null;
        $user->direccion = $request->input('direccion') ?? null;
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


        $user = User::findOrFail($request->id);


      
        // Verificar si se ha subido una nueva imagen
        if ($request->hasFile('imagen')) {
            // Almacenar la imagen en el almacenamiento (storage) y guardar la ruta
            $filePath = $request->file('imagen')->store('images', 'public');

            $user->avatar =  $filePath; // Ajustar ruta para accesibilidad
        }
     
        // Actualizar los demás campos
        $user->name = $request->input('name') ?? "";
        $user->telefono = $request->input('telefono') ?? "";
        $user->last_name = $request->input('last_name') ?? "";
        $user->cedula = $request->input('cedula') ?? "";
        $user->edad = $request->input('edad') ?? "";

        // Eliminar el rol actual del usuario
        $user->roles()->detach();

        $roleName = \Spatie\Permission\Models\Role::where('id', $request->input('role'))->value('name');

        // Asignar el nuevo rol
        $user->assignRole($roleName);

        // Guardar los cambios del usuario
        $user->save();

        return back()->with('success', 'Usuario actualizado exitosamente');
    }


    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            $user->delete();

            return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el usuario'], 500);
        }
    }
}
