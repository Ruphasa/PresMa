<?php

namespace Database\Seeders;

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
         * Points reference:
         * 1: ikut regional
         * 2: juara 3 regional
         * 3: juara 2 regional
         * 4: juara 1 regional
         * 5: ikut nasional
         * 6: juara 3 nasional
         * 7: juara 2 nasional
         * 8: juara 1 nasional
         * 9: ikut internasional
         * 10: juara 3 internasional
         * 11: juara 2 internasional
         * 12: juara 1 internasional
         */

        // Data awal
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

        // Tambahkan 50 data prestasi tambahan
        for ($i = 3; $i <= 52; $i++) {
            $mahasiswaId = 2341720000 + rand(1, 200); 
            $tingkatOptions = ['Regional', 'Nasional', 'Internasional'];
            $tingkat = $tingkatOptions[array_rand($tingkatOptions)];

            // Mapping point berdasarkan tingkat dan juara
            $juara = rand(1, 4); // 4 = ikut saja,  1-3 = juara 
            $pointMap = [
            'Regional' => [1 => 4, 2 => 3, 3 => 2, 4 => 1],         // Juara 1 = 4 poin, ikut saja = 1 poin
            'Nasional' => [1 => 8, 2 => 7, 3 => 6, 4 => 5],         // Juara 1 = 8 poin, ikut saja = 5 poin
            'Internasional' => [1 => 12, 2 => 11, 3 => 10, 4 => 9], // Juara 1 = 12 poin, ikut saja = 9 poin
            ];
            $point = $pointMap[$tingkat][$juara];

            $prestasis[] = [
                'prestasi_id' => $i,
                'lomba_id' => rand(1, 3), 
                'mahasiswa_id' => $mahasiswaId,
                'tingkat_prestasi' => $tingkat,
                'juara_ke' => $juara,
                'status' => ['pending', 'validated'][rand(0, 1)],
                'point' => $point,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_prestasi')->insert($prestasis);
    }
}
