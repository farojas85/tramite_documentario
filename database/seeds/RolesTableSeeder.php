<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'nombre' =>'admin',
            'slug' => 'admin',
            'descripcion' => 'Administrador del Sistema'
        ]);

        Role::create([
            'nombre' =>'user',
            'slug' => 'user',
            'descripcion' => 'Usuario Estándar'
        ]);
    }
}
