<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['rank' => 'Juara 1', 'point' => 100],
            ['rank' => 'Juara 2', 'point' => 80],
            ['rank' => 'Juara 3', 'point' => 60],
            ['rank' => 'Harapan 1', 'point' => 40],
            ['rank' => 'Harapan 2', 'point' => 20],
            ['rank' => 'Harapan 3', 'point' => 10],
            ['rank' => 'Best Seller', 'point' => 50],
            ['rank' => 'Editor\'s Choice', 'point' => 30],
            ['rank' => 'Partisipasi', 'point' => 5],
            ['rank' => 'Sertifikat', 'point' => 15],
            ['rank' => 'Penghargaan Khusus', 'point' => 25],
            ['rank' => 'Finalis', 'point' => 35],
            ['rank' => 'Peserta Aktif', 'point' => 10],
            ['rank' => 'Pemenang Favorit', 'point' => 20],
            ['rank' => 'Pemenang Pilihan Publik', 'point' => 30],
            ['rank' => 'Pemenang Kategori', 'point' => 40],
            ['rank' => 'Pemenang Utama', 'point' => 50],
            ['rank' => 'Pemenang Spesial', 'point' => 60],
            ['rank' => 'Pemenang Terbaik', 'point' => 70],
            ['rank' => 'Pemenang Terfavorit', 'point' => 80],
            ['rank' => 'Pemenang Terpopuler', 'point' => 90],
            ['rank' => 'Pemenang Terinspirasi', 'point' => 100],
            ['rank' => 'Pemenang Terpuji', 'point' => 110],

            //UNNECESSARY AMOUNT OF RANKS I GUESS
            ['rank' => 'Best Poster', 'point' => 120],
            ['rank' => 'Best Presentation', 'point' => 130],
            ['rank' => 'Best Innovation', 'point' => 140],
            ['rank' => 'Best Collaboration', 'point' => 150],
            ['rank' => 'Best Teamwork', 'point' => 160],
            ['rank' => 'Best Creativity', 'point' => 170],
            ['rank' => 'Best Leadership', 'point' => 180],
            ['rank' => 'Best Contribution', 'point' => 190],
            ['rank' => 'Best Performance', 'point' => 200],
            ['rank' => 'Best Design', 'point' => 210],
            ['rank' => 'Best Research', 'point' => 220],
            ['rank' => 'Best Development', 'point' => 230],
            ['rank' => 'Best Implementation', 'point' => 240],
            ['rank' => 'Best Impact', 'point' => 250],
            ['rank' => 'Best Sustainability', 'point' => 260],
            ['rank' => 'Best Outreach', 'point' => 270],
            ['rank' => 'Best Engagement', 'point' => 280],
            ['rank' => 'Best Initiative', 'point' => 290],
        ];
        DB::table('rank')->insert($data);
    }
}
