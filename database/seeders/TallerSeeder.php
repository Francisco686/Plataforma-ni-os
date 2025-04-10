<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Taller;
use App\Models\SeccionTaller;
use App\Models\AsignaTaller;

class TallerSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba tipo alumno
        $user = User::firstOrCreate(
            ['curp' => 'TESTCURP123456789'],
            [
                'name' => 'Alumno Prueba',
                'role' => 'alumno',
                'password' => Hash::make('12345678'),
            ]
        );

        // Talleres
        $talleres = [
            'Reciclaje' => 'Taller sobre reciclaje',
            'Cuidado del Agua' => 'Taller sobre cuidado del agua',
            'Reutilizar Materiales' => 'Taller sobre reutilizar materiales',
        ];

        foreach ($talleres as $nombre => $descripcion) {
            $t = Taller::firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $descripcion]
            );

            // Crear secciones si no existen
            $secciones = [
                ['nombre' => 'Introducción', 'descripcion' => 'Sección introductoria del taller.', 'orden' => 1],
                ['nombre' => 'Actividad Interactiva', 'descripcion' => 'Una actividad para practicar.', 'orden' => 2],
                ['nombre' => 'Evaluación', 'descripcion' => 'Prueba final del taller.', 'orden' => 3],
            ];

            foreach ($secciones as $s) {
                SeccionTaller::firstOrCreate(
                    ['taller_id' => $t->id, 'nombre' => $s['nombre']],
                    ['descripcion' => $s['descripcion'], 'orden' => $s['orden']]
                );
            }

            // Asignar taller al alumno si no está asignado
            AsignaTaller::firstOrCreate([
                'user_id' => $user->id,
                'taller_id' => $t->id,
            ], [
                'fecha_inicio' => now(),
            ]);
        }
    }
}
