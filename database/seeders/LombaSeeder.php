<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_lomba')->insert([
            [
                'kategori_id' => 1,
                'lomba_tingkat' => 'Nasional',
                'lomba_tanggal' => '2025-06-15',
                'lomba_nama' => 'Lomba Robotika Nasional',
                'lomba_detail' => 'Lomba robotika tingkat nasional untuk siswa SMA.',
                'status' => 'valid'
            ],
            [
                'kategori_id' => 2,
                'lomba_tingkat' => 'Internasional',
                'lomba_tanggal' => '2025-07-20',
                'lomba_nama' => 'Festival Seni Internasional',
                'lomba_detail' => 'Festival seni yang diikuti oleh peserta dari berbagai negara.',
                'status' => 'pending'
            ],
            [
                'kategori_id' => 3,
                'lomba_tingkat' => 'Provinsi',
                'lomba_tanggal' => '2025-08-10',
                'lomba_nama' => 'Lomba Debat Bahasa Inggris Provinsi',
                'lomba_detail' => 'Lomba debat bahasa Inggris tingkat provinsi.',
                'status' => 'rejected'
            ]
        ]);
    }
}
