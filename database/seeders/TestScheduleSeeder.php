<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Jampel;
use App\Models\GuruMapel;

class TestScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah sudah ada data test, jika belum buat

        // 1. Create test user (guru)
        $user = User::firstOrCreate(
            ['email' => 'guru.test@smk.sch.id'],
            [
                'name' => 'Guru Test',
                'password' => bcrypt('password'),
                'role' => 'guru'
            ]
        );

        // 2. Create atau dapatkan guru
        $guru = Guru::firstOrCreate(
            ['users_id' => $user->id],
            [
                'nama' => 'Guru Test',
                'nip' => '123456789'
            ]
        );

        // 3. Dapatkan atau buat kelas
        $kelas = Kelas::firstOrCreate(
            ['nama_kelas' => '10 TKJ'],
            [
                'tingkat_kelas' => 10,
                'jurusan' => 'TKJ'
            ]
        );

        // 4. Dapatkan atau buat mata pelajaran
        $mapel = MataPelajaran::firstOrCreate(
            ['nama' => 'Networking'],
            [
                'kode' => 'NET001',
                'kelompok' => 'Kejuruan'
            ]
        );

        // 5. Dapatkan jam pelajaran untuk senin jam 1
        $jampelSenin1 = Jampel::where('jam_ke', 1)
            ->where('hari_tipe', 'senin')
            ->first();

        // 6. Create assignment
        if ($jampelSenin1) {
            GuruMapel::firstOrCreate(
                [
                    'guru_id' => $guru->id,
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $mapel->id,
                ],
                [
                    'jampel_id' => $jampelSenin1->id
                ]
            );
        }
    }
}
