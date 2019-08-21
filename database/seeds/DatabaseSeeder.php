<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            RolesTableSeeder::class,
            Cargo_calificadosTableSeeder::class,
            Documento_IdentidadsTableSeeder::class,
            Tipo_documentosTableSeeder::class
        );
    }
}
