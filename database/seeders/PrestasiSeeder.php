<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestasis = [
            [
                'prestasi_id' => 1,
                'lomba_id' => 1,
                'tingkat_prestasi' => 'Nasional',
                'juara_ke' => 3,
                'status' => 'validated',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prestasi_id' => 2,
                'lomba_id' => 1,
                'tingkat_prestasi' => 'Internasional',
                'juara_ke' => 3,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('t_prestasi')->insert($prestasis);
    }
}
