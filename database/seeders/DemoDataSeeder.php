<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\GuruMapel;
use App\Models\Jampel;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Memulai pembuatan data demo...');

        // 1. Buat data kelas
        $kelasData = [
            ['nama_kelas' => 'X RPL 1', 'wali_kelas_id' => null],
            ['nama_kelas' => 'X RPL 2', 'wali_kelas_id' => null],
            ['nama_kelas' => 'XI RPL 1', 'wali_kelas_id' => null],
            ['nama_kelas' => 'XI RPL 2', 'wali_kelas_id' => null],
            ['nama_kelas' => 'XII RPL 1', 'wali_kelas_id' => null],
            ['nama_kelas' => 'XII RPL 2', 'wali_kelas_id' => null],
        ];

        foreach ($kelasData as $k) {
            Kelas::firstOrCreate($k);
        }

        $this->command->info('Data kelas berhasil dibuat/diperbarui!');

        // 2. Buat data mata pelajaran - TAMBAHKAN FIELD KODE DAN KELOMPOK
        $mapelData = [
            ['nama' => 'Pemrograman Web', 'kode' => 'PW', 'kelompok' => 'A'],
            ['nama' => 'Basis Data', 'kode' => 'BD', 'kelompok' => 'A'],
            ['nama' => 'Jaringan Komputer', 'kode' => 'JK', 'kelompok' => 'A'],
            ['nama' => 'Sistem Operasi', 'kode' => 'SO', 'kelompok' => 'A'],
            ['nama' => 'Multimedia', 'kode' => 'MM', 'kelompok' => 'B'],
            ['nama' => 'Pemrograman Mobile', 'kode' => 'PM', 'kelompok' => 'B'],
            ['nama' => 'Teknologi Layanan Jaringan', 'kode' => 'TLJ', 'kelompok' => 'B'],
            ['nama' => 'Administrasi Infrastruktur Jaringan', 'kode' => 'AIJ', 'kelompok' => 'B'],
        ];

        // Simpan mapel yang dibuat untuk digunakan di relasi
        $createdMapels = [];
        foreach ($mapelData as $mapel) {
            $createdMapels[] = MataPelajaran::firstOrCreate($mapel);
        }

        $this->command->info('Data mata pelajaran berhasil dibuat/diperbarui!');

        // 3. Buat data jam pelajaran
        $jampelData = [
            ['nama_jam' => 'Jam 1', 'rentang_waktu' => '07:00 - 07:45'],
            ['nama_jam' => 'Jam 2', 'rentang_waktu' => '07:45 - 08:30'],
            ['nama_jam' => 'Jam 3', 'rentang_waktu' => '08:30 - 09:15'],
            ['nama_jam' => 'Jam 4', 'rentang_waktu' => '09:30 - 10:15'],
            ['nama_jam' => 'Jam 5', 'rentang_waktu' => '10:15 - 11:00'],
            ['nama_jam' => 'Jam 6', 'rentang_waktu' => '11:00 - 11:45'],
            ['nama_jam' => 'Jam 7', 'rentang_waktu' => '12:30 - 13:15'],
            ['nama_jam' => 'Jam 8', 'rentang_waktu' => '13:15 - 14:00'],
            ['nama_jam' => 'Jam 9', 'rentang_waktu' => '14:00 - 14:45'],
            ['nama_jam' => 'Jam 10', 'rentang_waktu' => '14:45 - 15:30'],
        ];

        foreach ($jampelData as $j) {
            Jampel::firstOrCreate($j);
        }

        $this->command->info('Data jam pelajaran berhasil dibuat/diperbarui!');

        // 4. Buat user dan data guru
        $guruUser = User::firstOrCreate(
            ['email' => 'guru@rpl.sch.id'],
            [
                'name' => 'Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        $guru = Guru::firstOrCreate(
            ['users_id' => $guruUser->id],
            [
                'nama' => 'Ahmad Fauzi, S.Kom',
                'nip' => '198506152019031001',
                'jenis_kelamin' => 'laki-laki'
            ]
        );

        $this->command->info('Data guru berhasil dibuat/diperbarui!');
        $this->command->info('Email: guru@rpl.sch.id');
        $this->command->info('Password: password');

        // 5. Buat user dan data siswa (sekretaris kelas)
        $siswaUser = User::firstOrCreate(
            ['email' => 'siswa@rpl.sch.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'sekretaris',
            ]
        );

        $siswa = Siswa::firstOrCreate(
            ['users_id' => $siswaUser->id],
            [
                'kelas_id' => 1, // X RPL 1
                'nis' => '2021001',
                'nama_siswa' => 'Budi Santoso',
                'jenkel' => 'laki-laki'
            ]
        );

        $this->command->info('Data siswa berhasil dibuat/diperbarui!');
        $this->command->info('Email: siswa@rpl.sch.id');
        $this->command->info('Password: password');

        // 6. Hubungkan guru dengan kelas dan mata pelajaran
        // Hapus data guru_mapel yang ada untuk guru ini
        GuruMapel::where('guru_id', $guru->id)->delete();

        // Guru mengampu beberapa kelas dengan mata pelajaran tertentu
        // Gunakan ID dari mata pelajaran yang sudah dibuat
        $guruMapelData = [
            // X RPL 1
            ['guru_id' => $guru->id, 'kelas_id' => 1, 'mapel_id' => $createdMapels[0]->id], // Pemrograman Web
            ['guru_id' => $guru->id, 'kelas_id' => 1, 'mapel_id' => $createdMapels[1]->id], // Basis Data

            // X RPL 2
            ['guru_id' => $guru->id, 'kelas_id' => 2, 'mapel_id' => $createdMapels[0]->id], // Pemrograman Web
            ['guru_id' => $guru->id, 'kelas_id' => 2, 'mapel_id' => $createdMapels[2]->id], // Jaringan Komputer

            // XI RPL 1
            ['guru_id' => $guru->id, 'kelas_id' => 3, 'mapel_id' => $createdMapels[3]->id], // Sistem Operasi
            ['guru_id' => $guru->id, 'kelas_id' => 3, 'mapel_id' => $createdMapels[4]->id], // Multimedia

            // XI RPL 2
            ['guru_id' => $guru->id, 'kelas_id' => 4, 'mapel_id' => $createdMapels[5]->id], // Pemrograman Mobile
            ['guru_id' => $guru->id, 'kelas_id' => 4, 'mapel_id' => $createdMapels[6]->id], // Teknologi Layanan Jaringan

            // XII RPL 1
            ['guru_id' => $guru->id, 'kelas_id' => 5, 'mapel_id' => $createdMapels[7]->id], // Administrasi Infrastruktur Jaringan
            ['guru_id' => $guru->id, 'kelas_id' => 5, 'mapel_id' => $createdMapels[1]->id], // Basis Data

            // XII RPL 2
            ['guru_id' => $guru->id, 'kelas_id' => 6, 'mapel_id' => $createdMapels[0]->id], // Pemrograman Web
            ['guru_id' => $guru->id, 'kelas_id' => 6, 'mapel_id' => $createdMapels[7]->id], // Administrasi Infrastruktur Jaringan
        ];

        foreach ($guruMapelData as $data) {
            GuruMapel::create($data);
        }

        $this->command->info('Data relasi guru-kelas-mapel berhasil dibuat/diperbarui!');
        $this->command->info('Demo data siap digunakan!');
    }
}
