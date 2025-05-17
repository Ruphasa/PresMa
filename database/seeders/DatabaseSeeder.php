<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            ProdiSeeder::class,
            UserSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            AdminSeeder::class,
            KategoriLombaSeeder::class,
            LombaSeeder::class,            
            PrestasiSeeder::class,
            SertifikatSeeder::class,
        ]);
    }
}
