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
                'tingkatPrestasi' => 'Nasional',
                'juaraKe' => 3,
                'namaLomba' => 'akojwbdbuwi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('t_prestasi')->insert($prestasis);
    }
}
