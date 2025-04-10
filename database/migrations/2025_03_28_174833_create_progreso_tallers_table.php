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
        Schema::create('progreso_tallers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asigna_taller_id')->constrained('asigna_tallers');
            $table->foreignId('seccion_taller_id')->constrained('seccion_tallers');
            $table->boolean('completado')->default(false);
            $table->timestamp('fecha_completado')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progreso_tallers');
    }
};
