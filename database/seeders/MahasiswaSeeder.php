<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        
        // Data mahasiswa awal yang sudah ada
        $mahasiswas = [
            [
                'nim' => 2341720202,
                'user_id' => 1,
                'prodi_id' => 1,
                'dosen_id' => 1,
                'angkatan' => 2023,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => 2341720204,
                'user_id' => 2,
                'prodi_id' => 1,
                'dosen_id' => 1,
                'angkatan' => 2023,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        for ($i = 1; $i <= 200; $i++) {
            $mahasiswas[] = [
                'nim' => 2341720000 + $i,
                'user_id' => rand(3, 204), 
                'prodi_id' => rand(1, 3), 
                'dosen_id' => 1, 
                'angkatan' => rand(2020, 2024),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('m_mahasiswa')->insert($mahasiswas);
    }
}
