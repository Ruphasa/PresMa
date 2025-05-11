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
                'user_id' => 1, // Merujuk ke Budi Santoso
                'prodi_id' => 1, // Teknik Informatika
                'dosen_id' => 1, // Merujuk ke Prof. Andi Wijaya
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_mahasiswa')->insert($mahasiswas);
    }
}