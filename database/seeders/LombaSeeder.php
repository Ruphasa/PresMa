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
        $lomba =[
            [
                'kategori_id' => 1,
                'user_id' => 1,
                'lomba_tingkat' => 'Nasional',
                'lomba_tanggal' => '2025-06-15',
                'lomba_nama' => 'Lomba Robotika Nasional',
                'lomba_detail' => 'Lomba robotika tingkat nasional untuk siswa SMA.',
                'status' => 'validated'
            ],
            [
                'kategori_id' => 2,
                'user_id' => 1,
                'lomba_tingkat' => 'Internasional',
                'lomba_tanggal' => '2025-07-20',
                'lomba_nama' => 'Festival Seni Internasional',
                'lomba_detail' => 'Festival seni yang diikuti oleh peserta dari berbagai negara.',
                'status' => 'pending'
            ],
            [
                'kategori_id' => 3,
                'user_id' => 1,
                'lomba_tingkat' => 'Regional',
                'lomba_tanggal' => '2025-08-10',
                'lomba_nama' => 'Lomba Debat Bahasa Inggris Provinsi',
                'lomba_detail' => 'Lomba debat bahasa Inggris tingkat provinsi.',
                'status' => 'rejected'
            ],
        ];
        for ($i = 4; $i <= 20; $i++) {
            $lomba []=[
                'kategori_id' => rand(1, 3),
                'user_id' => rand(1, 5), // Asumsi user_id antara 1 sampai 5
                'lomba_tingkat' => ['Nasional', 'Internasional', 'Regional'][rand(0, 2)],
                'lomba_tanggal' => now()->addDays(rand(-182, 182))->format('Y-m-d'),
                'lomba_nama' => 'Lomba ' . $i,
                'lomba_detail' => 'Detail lomba ke-' . $i,
                'status' => ['validated', 'pending', 'rejected'][rand(0, 2)]
            ];
        }
        DB::table('m_lomba')->insert($lomba);
    }
}
