<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['prodi_id' => 01, 'kode_prodi' => 'TI', 'nama_prodi' => 'D4 Teknik Informatika'],
            ['prodi_id' => 02, 'kode_prodi' => 'SIB', 'nama_prodi' => 'D4 Sistem Informasi Bisnis'],
            ['prodi_id' => 03, 'kode_prodi' => 'PPLS', 'nama_prodi' => 'D2 Pengembangan Piranti Lunak Situs'],
        ];
        DB::table('prodi')->insert($data);
    }
}
