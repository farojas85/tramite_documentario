<?php

use Illuminate\Database\Seeder;
use App\Motivo;

class MotivosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Motivo::create([ 'motivo' => 'Conocimineto' ]);
        Motivo::create([ 'motivo' => 'Acciones de Competencia' ]);
        Motivo::create([ 'motivo' => 'Cumplimiento Inmediato' ]);
        Motivo::create([ 'motivo' => 'Transcribir Documento' ]);
        Motivo::create([ 'motivo' => 'Devolución' ]);

    }
}
