<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = [
            [
                'nim' => 2341720143,
                'user_id' => 1,
                'prodi_id' => 1,
                'dosen_id' => 1,
                'angkatan' => 2023,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => 2341720134,
                'user_id' => 4,
                'prodi_id' => 1,
                'dosen_id' => 1,
                'angkatan' => 2023,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_mahasiswa')->insert($mahasiswas);
    }
}
