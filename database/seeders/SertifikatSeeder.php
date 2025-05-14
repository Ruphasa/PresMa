<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SertifikatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sertifikat=[
            [

                'sertifikat_id' => 1,
                'nomorSeri'=>1432619,
                'kategoriSertif' => 'A',
                'image'=>'',
                'prestasi_id'=>1,
            ],
        ];

         DB::table('sertifikat')->insert($sertifikat);
    }
}
