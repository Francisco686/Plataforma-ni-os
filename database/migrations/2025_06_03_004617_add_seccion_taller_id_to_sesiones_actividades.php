<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('sesiones_actividades', function (Blueprint $table) {
        $table->unsignedBigInteger('seccion_taller_id')->nullable();
        $table->foreign('seccion_taller_id')->references('id')->on('secciones_taller')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesiones_actividades', function (Blueprint $table) {
            //
        });
    }
};
