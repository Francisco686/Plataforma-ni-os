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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesiones_actividades');
            $table->string('tipo'); // texto, pregunta, opcion_multiple, verdadero_falso, etc.
            $table->text('pregunta')->nullable();
            $table->text('respuesta_correcta')->nullable(); // Para almacenar la respuesta correcta esperada
            $table->json('opciones')->nullable(); // Para opciones múltiple: ["Opción 1", "Opción 2"]
            $table->string('archivo_path')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('puntos')->default(0);
            $table->boolean('permite_archivo')->default(false);
            $table->text('contenido')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
