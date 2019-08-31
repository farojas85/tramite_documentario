<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMovimientoIdToMovimientoInternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_internos', function (Blueprint $table) {
            $table->unsignedBigInteger('movimiento_id')->after('id');
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
        Schema::table('movimiento_internos', function (Blueprint $table) {
            $table->dropForeign('movimiento_internos_movimiento_id_foreign');
            $table->dropColumn('movimiento_id');
        });
    }
}
