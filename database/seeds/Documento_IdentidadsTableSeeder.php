<?php

use Illuminate\Database\Seeder;
use App\DocumentoIdentidad;

class Documento_IdentidadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentoIdentidad::create([
            'descripcion_larga' => 'DNI o Libreta Electoral',
            'descripcion_corta' => 'DNI / L.E',
            'tipo' => '01'
        ]);

        DocumentoIdentidad::create([
            'descripcion_larga' => 'Carnét de Extranjería',
            'descripcion_corta' => 'CARNET EXT.',
            'tipo' => '04'
        ]);

        DocumentoIdentidad::create([
            'descripcion_larga' => 'Reg. Único de Contribuyentes',
            'descripcion_corta' => 'RUC',
            'tipo' => '06'
        ]);

        DocumentoIdentidad::create([
            'descripcion_larga' => 'Pasaporte',
            'descripcion_corta' => 'PASAPORTE',
            'tipo' => '07'
        ]);

        DocumentoIdentidad::create([
            'descripcion_larga' => 'Part. de Nacimiento-Identidad',
            'descripcion_corta' => 'P. NAC.',
            'tipo' => '11'
        ]);
    }
}
