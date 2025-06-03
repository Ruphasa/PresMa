<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * points:
         * 1 point:ikut regional
         * 2 point:juara 3 regional
         * 3 point:juara 2 regional
         * 4 point:juara 1 regional
         * 5 point:ikut nasional
         * 6 point:juara 3 nasional
         * 7 point:juara 2 nasional
         * 8 point:juara 1 nasional
         * 9 point:ikut internasional
         * 10 point:juara 3 internasional
         * 11 point:juara 2 internasional
         * 12 point:juara 1 internasional
         */
        $prestasis = [
            [
                'prestasi_id' => 1,
                'lomba_id' => 1,
                'mahasiswa_id' => 2341720134,
                'tingkat_prestasi' => 'Nasional',
                'juara_ke' => 3,
                'status' => 'validated',
                'point' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'prestasi_id' => 2,
                'lomba_id' => 1,
                'mahasiswa_id' => 2341720143,
                'tingkat_prestasi' => 'Internasional',
                'juara_ke' => 3,
                'status' => 'pending',
                'point' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('t_prestasi')->insert($prestasis);
    }
}
