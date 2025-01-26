<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Obtén los roles por su nombre
        $roles = DB::table('roles')->pluck('id', 'name');

        // Obtén los permisos por su nombre
        $permissions = DB::table('permissions')->pluck('id', 'name');

        $rolePermissions = [
            // Superusuario: Todos los permisos
            $roles['superusuario'] => $permissions->values()->all(),

            // Administrador: Todos los permisos
            $roles['administrador'] => $permissions->values()->all(),

            // Doctor: Todos los permisos
            $roles['doctor'] => $permissions->values()->all(),

            // Asistente General: Solo permisos de asistente general y dental
            $roles['Asistente General'] => [
                $permissions['v_asistente_general'],
                $permissions['v_asistente_dental'],
            ],

            // Asistente Dental: Solo permisos de asistente dental
            $roles['Asistente Dental'] => [
                $permissions['v_asistente_dental'],
            ],
        ];

        // Asigna los permisos a los roles en la tabla intermedia
        foreach ($rolePermissions as $roleId => $permissionIds) {
            foreach ($permissionIds as $permissionId) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }
}
