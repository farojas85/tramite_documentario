<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('expediente_id');
            $table->unsignedBigInteger('tipo_movimiento_id');
            $table->unsignedBigInteger('unidad_origen')->nullable();
            $table->unsignedBigInteger('dependencia_origen')->nullable();
            $table->date('fecha');
            $table->time('hora');
            $table->string('numero_recepcion',50)->nullable();
            $table->string('observaciones')->nullable();
            $table->string('prioridad',50)->nullable();
            $table->string('estado_actual',20);
            $table->timestamps();
            $table->foreign('expediente_id')->references('id')->on('expedientes');
            $table->foreign('unidad_origen')->references('id')->on('unidad_organicas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}
