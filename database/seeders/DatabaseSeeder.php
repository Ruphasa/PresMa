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
            KategoriLombaSeeder::class,
            AdminSeeder::class,
            MahasiswaSeeder::class,
            LombaSeeder::class,
            PrestasiSeeder::class,
        ]);
    }
}
