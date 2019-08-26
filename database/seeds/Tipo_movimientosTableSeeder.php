<?php

use Illuminate\Database\Seeder;
use App\TipoMovimiento;

class Tipo_movimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMovimiento::create([
            'descripcion' => 'Interno'
        ]);

        TipoMovimiento::create([
            'descripcion' => 'Externo'
        ]);
    }
}
