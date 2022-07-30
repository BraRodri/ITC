<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_administrador = Role::create(['name' => 'Administrador']);
        $role_director = Role::create(['name' => 'Director']);
        $role_secretaria = Role::create(['name' => 'Secretaria']);
        $role_axu_administrativa = Role::create(['name' => 'Auxiliar Administrativa']);
        $role_docente = Role::create(['name' => 'Docente']);
        $role_estudiante = Role::create(['name' => 'Estudiante']);

    }
}
