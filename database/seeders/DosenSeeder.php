<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosens = [
            [
                'nidn' => 1,
                'user_id' => 2, // Merujuk ke Prof. Hikari Megumi
                'username' => 'megumi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        for ($i=0; $i < 19 ; $i++) {
            $dosens []=[
                'nidn' => $i + 2, // NIDN dimulai dari 2
                'user_id' => $i + 205, // User ID dimulai dari 3
                'username' => 'dosen' . ($i), // Username dosen
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('m_dosen')->insert($dosens);
    }
}
