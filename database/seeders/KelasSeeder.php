<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Jurusan;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusanTeknik = Jurusan::firstWhere('nama_jurusan', 'Teknik');
        $jurusanId = $jurusanTeknik ? $jurusanTeknik->id : null;

        Kelas::insert([
            ['nama_kelas' => 'X RPL 1',   'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'X RPL 2',   'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'XI RPL 1',  'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'XI RPL 2',  'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'XII RPL 1', 'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'XII RPL 2', 'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'X TKJ 1',   'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'X TKJ 2',   'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'XI TKJ 1',  'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
            ['nama_kelas' => 'XII TKJ 1', 'wali_kelas_id' => null, 'jurusan_id' => $jurusanId],
        ]);
    }
}
