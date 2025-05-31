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
        Schema::create('actividad_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('taller_id')->constrained('sesiones_actividades')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('users')->onDelete('cascade');

            $table->enum('estado', ['pendiente', 'en_progreso', 'completada'])->default('pendiente');
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_completado')->nullable();
            $table->text('respuesta')->nullable();
            $table->string('archivo_path')->nullable();
            $table->timestamps();
        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_estudiantes');
    }
};
