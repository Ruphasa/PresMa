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
        DB::table('m_kategori_lomba')->insert([
            [
                'kl_kode' => 'SNT',
                'kl_nama' => 'Sains dan Teknologi',
                'kl_keterangan' => 'Dikenal sebagai Saintek, Kategori ini menggunakan bidang sains dan teknologi, termasuk robotika, pemrograman, dan inovasi teknologi.'
            ],
            [
                'kl_kode' => 'SEN',
                'kl_nama' => 'Seni',
                'kl_keterangan' => 'Kategori ini mencakup seni rupa, seni pertunjukan, dan seni musik. Peserta dapat menunjukkan bakat seni mereka dalam berbagai bentuk.'
            ],
            [
                'kl_kode' => 'BHS',
                'kl_nama' => 'Bahasa dan Sastra',
                'kl_keterangan' => 'Kategori ini berfokus pada kemampuan berbahasa, termasuk lomba pidato, debat, dan penulisan kreatif. Peserta dapat menunjukkan keterampilan berbahasa mereka.'
            ]
        ]);
    }
}
