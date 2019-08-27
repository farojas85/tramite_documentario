<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitanteMovimientoTable extends Migration
{
    public function up()
    {
        Schema::create('solicitante_movimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('solicitante_id');
            $table->unsignedBigInteger('movimiento_id');
            $table->timestamps();
            $table->foreign('solicitante_id')->references('id')->on('solicitantes');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitante_movimiento');
    }
}
