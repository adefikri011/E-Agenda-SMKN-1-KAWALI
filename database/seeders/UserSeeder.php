<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru Satu',
                'email' => 'guru@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'guru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wali Kelas',
                'email' => 'walikelas@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'walikelas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sekretaris',
                'email' => 'sekretaris@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'sekretaris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
