<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('groups')->insert([
            ['id' => 1, 'grado' => 1, 'grupo' => 'A', 'created_at' => '2025-09-01 20:07:16', 'updated_at' => '2025-09-01 20:07:17'],
            ['id' => 2, 'grado' => 1, 'grupo' => 'B', 'created_at' => '2025-09-01 20:07:33', 'updated_at' => '2025-09-01 20:07:34'],
            ['id' => 3, 'grado' => 1, 'grupo' => 'C', 'created_at' => '2025-09-01 20:08:41', 'updated_at' => '2025-09-01 20:08:42'],
            ['id' => 4, 'grado' => 2, 'grupo' => 'A', 'created_at' => '2025-09-01 20:08:55', 'updated_at' => '2025-09-01 20:08:56'],
            ['id' => 5, 'grado' => 2, 'grupo' => 'B', 'created_at' => '2025-09-01 20:09:05', 'updated_at' => '2025-09-01 20:09:07'],
            ['id' => 6, 'grado' => 2, 'grupo' => 'C', 'created_at' => '2025-09-01 20:09:14', 'updated_at' => '2025-09-01 20:09:15'],
            ['id' => 7, 'grado' => 3, 'grupo' => 'A', 'created_at' => '2025-09-01 20:09:22', 'updated_at' => '2025-09-01 20:09:24'],
            ['id' => 8, 'grado' => 3, 'grupo' => 'B', 'created_at' => '2025-09-01 20:10:12', 'updated_at' => '2025-09-01 20:10:13'],
            ['id' => 9, 'grado' => 3, 'grupo' => 'C', 'created_at' => '2025-09-01 20:10:25', 'updated_at' => '2025-09-01 20:10:26'],
            ['id' => 10, 'grado' => 4, 'grupo' => 'A', 'created_at' => '2025-09-01 20:10:34', 'updated_at' => '2025-09-01 20:10:35'],
            ['id' => 11, 'grado' => 4, 'grupo' => 'B', 'created_at' => '2025-09-01 20:10:44', 'updated_at' => '2025-09-01 20:10:45'],
            ['id' => 12, 'grado' => 4, 'grupo' => 'C', 'created_at' => '2025-09-01 20:10:51', 'updated_at' => '2025-09-01 20:10:52'],
            ['id' => 13, 'grado' => 5, 'grupo' => 'A', 'created_at' => '2025-09-01 20:11:00', 'updated_at' => '2025-09-01 20:11:00'],
            ['id' => 14, 'grado' => 5, 'grupo' => 'B', 'created_at' => '2025-09-01 20:11:09', 'updated_at' => '2025-09-01 20:11:09'],
            ['id' => 15, 'grado' => 5, 'grupo' => 'C', 'created_at' => '2025-09-01 20:11:33', 'updated_at' => '2025-09-01 20:11:36'],
            ['id' => 16, 'grado' => 6, 'grupo' => 'A', 'created_at' => '2025-09-01 20:11:46', 'updated_at' => '2025-09-01 20:11:46'],
            ['id' => 17, 'grado' => 6, 'grupo' => 'B', 'created_at' => '2025-09-01 20:11:54', 'updated_at' => '2025-09-01 20:11:55'],
            ['id' => 18, 'grado' => 6, 'grupo' => 'C', 'created_at' => '2025-09-01 20:12:03', 'updated_at' => '2025-09-01 20:12:04'],
        ]);
    }
}
