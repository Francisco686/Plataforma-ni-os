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
        Schema::create('logros', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->text('descripcion')->nullable();
    $table->string('icono')->nullable(); // ruta al ícono o nombre de ícono
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('logro_user');
}

};
