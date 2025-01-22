<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'v_doctor',
            'v_paciente',
            'v_superusuario',
            // Agrega más permisos según tus necesidades
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $superAdmin = Role::findByName('superusuario');
        $doctor = Role::findByName('doctor');
        $paciente = Role::findByName('paciente');
        
        $permissions = Permission::all();
        $superAdmin->givePermissionTo($permissions);
        $doctor->givePermissionTo(['v_doctor']);
        $paciente->givePermissionTo(['v_paciente']);
    }
}
