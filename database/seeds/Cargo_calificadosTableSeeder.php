<?php

use Illuminate\Database\Seeder;
use App\CargoCalificado;

class Cargo_calificadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoCalificado::create([
            'nombre' =>'Funcionario',
            'abreviatura' => 'F'
        ]);
        CargoCalificado::create([
            'nombre' =>'Empleado de Confianza',
            'abreviatura' => 'EC'
        ]);
        CargoCalificado::create([
            'nombre' =>'Servidor Público Directivo Superior',
            'abreviatura' => 'SP-DS'
        ]);
        CargoCalificado::create([
            'nombre' =>'Servidor Público Ejecutivo',
            'abreviatura' => 'SP-EJ'
        ]);
        CargoCalificado::create([
            'nombre' =>'Servidor Público Especialista',
            'abreviatura' => 'SP-ES'
        ]);
        CargoCalificado::create([
            'nombre' =>'Servidor Público de Apoyo',
            'abreviatura' => 'SP-AP'
        ]);
        CargoCalificado::create([
            'nombre' =>'Régimen Especial',
            'abreviatura' => 'RE'
        ]);
    }
}
