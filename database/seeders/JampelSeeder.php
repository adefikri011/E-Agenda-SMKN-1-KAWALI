<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JampelSeeder extends Seeder
{
    public function run(): void
    {
        $jam = [
            ['nama_jam' => 'Jam 1-2', 'rentang_waktu' => '07:30 - 09:00'],
            ['nama_jam' => 'Jam 3-4', 'rentang_waktu' => '09:15 - 10:45'],
            ['nama_jam' => 'Jam 5-6', 'rentang_waktu' => '11:00 - 12:30'],
            ['nama_jam' => 'Jam 7-8', 'rentang_waktu' => '13:00 - 14:30'],
            ['nama_jam' => 'Jam 9-10', 'rentang_waktu' => '14:35 - 16:00'], // Optional
        ];

        foreach ($jam as $j) {
            DB::table('jam_pelajaran')->insert([
                'nama_jam' => $j['nama_jam'],
                'rentang_waktu' => $j['rentang_waktu'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

