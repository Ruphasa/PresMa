<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_id' => 1,
                'level_id' => 3,
                'nama' => 'Ruphasa Mafahl',
                'password' => Hash::make('12345'),
                'img' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'level_id' => 2,
                'nama' => 'Prof. Hikari Megumi',
                'password' => Hash::make('12345'),
                'img' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'level_id' => 1,
                'nama' => 'Admin',
                'password' => Hash::make('12345'),
                'img' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'level_id' => 3,
                'nama' => 'Ripqi',
                'password' => Hash::make('12345'),
                'img' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_user')->insert($users);
    }
}
