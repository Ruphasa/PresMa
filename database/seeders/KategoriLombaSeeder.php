<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriLombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert data into the 'm_kategori_lomba' table
        DB::table('m_kategori')->insert([
            [
                'kategori_kode' => 'SNT',
                'kategori_nama' => 'Sains dan Teknologi',
                'kategori_keterangan' => 'Dikenal sebagai Saintek, Kategori ini menggunakan bidang sains dan teknologi, termasuk robotika, pemrograman, dan inovasi teknologi.'
            ],
            [
                'kategori_kode' => 'SEN',
                'kategori_nama' => 'Seni',
                'kategori_keterangan' => 'Kategori ini mencakup seni rupa, seni pertunjukan, dan seni musik. Peserta dapat menunjukkan bakat seni mereka dalam berbagai bentuk.'
            ],
            [
                'kategori_kode' => 'BHS',
                'kategori_nama' => 'Bahasa dan Sastra',
                'kategori_keterangan' => 'Kategori ini berfokus pada kemampuan berbahasa, termasuk lomba pidato, debat, dan penulisan kreatif. Peserta dapat menunjukkan keterampilan berbahasa mereka.'
            ]
        ]);
    }
}
