<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiempoResolucionAndErroresToPartidasTable extends Migration
{
    public function up()
    {
        Schema::table('partidas', function (Blueprint $table) {
            $table->integer('tiempo_resolucion')->nullable()->after('tipo'); // Tiempo en segundos
            $table->integer('errores')->nullable()->after('tiempo_resolucion'); // Número de errores
        });
    }

    public function down()
    {
        Schema::table('partidas', function (Blueprint $table) {
            $table->dropColumn('tiempo_resolucion');
            $table->dropColumn('errores');
        });
    }
}
