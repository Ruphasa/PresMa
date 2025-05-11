<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'nip' => 1,
                'user_id' => 3, // Merujuk ke Admin John Doe
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_admin')->insert($admins);
    }
}