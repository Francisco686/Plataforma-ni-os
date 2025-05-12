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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_seccion');
            $table->unsignedBigInteger('id_alumno');
            $table->text('pregunta1');
            $table->text('pregunta2');
            $table->text('pregunta3');
            $table->text('pregunta4');
            $table->text('pregunta5');
            $table->timestamps();

            $table->foreign('id_seccion')->references('id')->on('seccion_tallers')->onDelete('cascade');
            $table->foreign('id_alumno')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
