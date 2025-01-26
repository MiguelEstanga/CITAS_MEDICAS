<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionsToRolesSeeder extends Seeder
{
    public function run()
    {
        // Buscar los roles superusuario y doctor
        $superusuario = Role::where('name', 'superusuario')->first();
        $doctor = Role::where('name', 'doctor')->first();

        // Obtener todos los permisos
        $permissions = Permission::all();

        // Asignar todos los permisos al rol superusuario
        if ($superusuario) {
            $superusuario->syncPermissions($permissions);
        }

        // Asignar todos los permisos al rol doctor
        if ($doctor) {
            $doctor->syncPermissions($permissions);
        }

        $this->command->info('Todos los permisos han sido asignados a los roles superusuario y doctor.');
    }
}
