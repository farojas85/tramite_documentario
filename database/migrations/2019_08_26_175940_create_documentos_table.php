<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('expediente_id');
            $table->unsignedBigInteger('tipo_documento_id');
            $table->string('cabecera_documento')->nullable();
            $table->string('numero_documento',50);
            $table->string('asunto');
            $table->integer('folios');
            $table->timestamps();
            $table->foreign('expediente_id')->references('id')->on('expedientes');
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
