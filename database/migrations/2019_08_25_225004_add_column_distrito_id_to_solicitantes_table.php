<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDistritoIdToSolicitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitantes', function (Blueprint $table) {
            $table->unsignedBigInteger('distrito_id')->nullable()->after('persona_id');
            $table->foreign('distrito_id')->references('id')->on('distritos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitantes', function (Blueprint $table) {
            $table->dropForeign('solicitantes_distrito_id_foreign');
            $table->dropColumn('distrito_id');
        });
    }
}
