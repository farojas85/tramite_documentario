<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotivoMovimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivo_movimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('motivo_id');
            $table->unsignedBigInteger('movimiento_id');
            $table->timestamps();
            $table->foreign('motivo_id')->references('id')->on('motivos');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motivo_movimiento');
    }
}
