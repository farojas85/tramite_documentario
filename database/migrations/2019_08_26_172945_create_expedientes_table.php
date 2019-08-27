<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesTable extends Migration
{

    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->time('hora');
            $table->string('cabecera')->nullable();
            $table->string('numero_expediente',50);
            $table->string('observaciones');
            $table->string('estado',20)->nullable();
            $table->string('estado_actual',20)->nullable();
            $table->string('prioridad',50)->nullable();
            $table->integer('tota_folios')->nullable();
            $table->unsignedBigInteger('procedimiento_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('procedimiento_id')->references('id')->on('procedimientos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expedientes');
    }
}
