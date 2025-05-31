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
        Schema::create('actividad_estudiante', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actividad_id');
            $table->unsignedBigInteger('estudiante_id'); // user_id con rol estudiante
            $table->enum('estado', ['pendiente', 'en_progreso', 'completada'])->default('pendiente');
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_completado')->nullable();
            $table->text('respuesta')->nullable(); // si aplica
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('actividad_estudiante');
    }
};
