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
        Schema::table('tallers', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->renameColumn('nombre', 'titulo');
        });
    }
    
    public function down()
    {
        Schema::table('tallers', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->renameColumn('titulo', 'nombre');
        });
    }
    
};
