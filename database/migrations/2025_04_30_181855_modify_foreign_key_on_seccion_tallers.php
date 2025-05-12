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
        Schema::table('seccion_tallers', function (Blueprint $table) {
            $table->dropForeign(['taller_id']);
            $table->foreign('taller_id')->references('id')->on('tallers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seccion_tallers', function (Blueprint $table) {
            //
        });
    }
};
