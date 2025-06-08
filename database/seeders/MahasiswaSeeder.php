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
                'nim' => 2341720143,
                'user_id' => 1,
                'prodi_id' => 1,
                'dosen_id' => 1,
                'angkatan' => 2023,
                'prefrensi_lomba' => 1,
                'ipk' => 3.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => 2341720134,
                'user_id' => 4,
                'prodi_id' => 1,
                'dosen_id' => 1,
                'angkatan' => 2023,
                'prefrensi_lomba' => 2,
                'ipk' => 3.2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        for ($i = 0; $i < 198; $i++) {
            $mahasiswas[] = [
                'nim' => 2341720144 + $i,
                'user_id' => 5 + $i, // User ID dimulai dari 5
                'prodi_id' => rand(1, 3),
                'dosen_id' => ((198-$i)%20)+1,
                'angkatan' => rand(2020, 2024),
                'prefrensi_lomba' => rand(1, 3), // Asumsi ada 3 jenis lomba
                'ipk' => round(rand(200, 400) / 100, 2), // IPK antara 2.00 sampai 4.00
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('m_mahasiswa')->insert($mahasiswas);
    }
}
