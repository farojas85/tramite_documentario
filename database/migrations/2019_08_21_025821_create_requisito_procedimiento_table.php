<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitoProcedimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisito_procedimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisito_id')->index();
            $table->unsignedBigInteger('procedimiento_id')->index();
            $table->timestamps();
            $table->foreign('requisito_id')->references('id')->on('requisitos');
            $table->foreign('procedimiento_id')->references('id')->on('procedimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisito_procedimiento');
    }
}
