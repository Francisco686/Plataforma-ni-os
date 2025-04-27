<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('seccion_tallers', function (Blueprint $table) {
        $table->string('tipo')->nullable(); // lectura, actividad, test
        $table->text('contenido')->nullable();
        $table->json('opciones')->nullable();
        $table->string('respuesta_correcta')->nullable();
    });
}

public function down()
{
    Schema::table('seccion_tallers', function (Blueprint $table) {
        $table->dropColumn(['tipo', 'contenido', 'opciones', 'respuesta_correcta']);
    });
}

};
