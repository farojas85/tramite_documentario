<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientointernoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientointernos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unidad_destino');
            $table->unsignedBigInteger('dependencia_destino');
            $table->unsignedBigInteger('cargo_destino');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientointernos');
    }
}
