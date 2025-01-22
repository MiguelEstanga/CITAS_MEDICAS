<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeederRole extends Seeder
{
    public function run()
    {
        // Crear el usuario
        $userId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'last_name' => 'Super Admin',
            'password' => Hash::make('12345678'), // Cambia esto por una contraseña segura
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar el rol de superadmin
        $superAdminRoleId = DB::table('roles')->where('name', 'superusuario')->value('id');

        DB::table('model_has_roles')->insert([
            'role_id' => $superAdminRoleId,
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ]);
    }
}
