<?php

use Illuminate\Database\Seeder;
use App\TipoDocumento;

class Tipo_documentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::create(['descripcion' => 'Carta']);

        TipoDocumento::create(['descripcion' => 'Circular']);

        TipoDocumento::create(['descripcion' => 'Solicitud']);

        TipoDocumento::create(['descripcion' => 'Sobre']);

        TipoDocumento::create(['descripcion' => 'Constancia']);

        TipoDocumento::create(['descripcion' => 'Copia Documento']);

        TipoDocumento::create(['descripcion' => 'Certificado']);
        
        TipoDocumento::create(['descripcion' => 'Acta']);

        TipoDocumento::create(['descripcion' => 'Memorando']);
    }
}
