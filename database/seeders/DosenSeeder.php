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
                'user_id' => 2, // Merujuk ke Prof. Andi Wijaya
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_dosen')->insert($dosens);
    }
}