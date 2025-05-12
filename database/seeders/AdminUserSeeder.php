<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'role' => 'administrador',
            'password' => Hash::make('12345678'), // Cambia por una contraseña segura
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
