<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar el seeder de talleres que también crea un usuario con CURP
        $this->call([
            TallerSeeder::class,
        ]);
    }
}
