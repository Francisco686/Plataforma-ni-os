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
        // database/migrations/xxxx_xx_xx_create_secciones_taller_table.php
Schema::create('secciones_taller', function (Blueprint $table) {
    $table->id();
    $table->foreignId('taller_id')->constrained('tallers')->onDelete('cascade');
    $table->string('tipo'); // lectura | actividad | test
    $table->string('titulo');
    $table->text('contenido')->nullable();
    $table->json('opciones')->nullable(); // para tipo test
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secciones_taller');
    }
};
