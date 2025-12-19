<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

class UserGuruSeeder extends Seeder
{
    public function run(): void
    {
        // ================= USER =================
        $userGuru = User::firstOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Seeder',
                'password' => Hash::make('12345678'),
                'role' => 'guru', // ENUM
            ]
        );

        // ================= GURU =================
        Guru::firstOrCreate(
            ['users_id' => $userGuru->id],
            [
                'nama' => 'Guru Seeder', // ✅ SESUAI MODEL
                'nip' => '1987654321',
                'jenis_kelamin' => 'laki-laki',
            ]
        );
    }
}
