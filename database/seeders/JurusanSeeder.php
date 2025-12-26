<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak', 'kode' => 'RPL'],
            ['nama_jurusan' => 'Teknik Komputer dan Jaringan', 'kode' => 'TKJ'],
            ['nama_jurusan' => 'Pengembangan Gim', 'kode' => 'GIM'],
            ['nama_jurusan' => 'Teknik Kendaraan Ringan', 'kode' => 'TKR'],
            ['nama_jurusan' => 'Manajemen Perkantoran', 'kode' => 'MPK'],
            ['nama_jurusan' => 'Akuntansi', 'kode' => 'AKT'],
            ['nama_jurusan' => 'Seni Karawitan', 'kode' => 'SK'],
            ['nama_jurusan' => 'Desain Pemodelan dan Informasi Bangunan', 'kode' => 'DPIB'],
        ];

        foreach ($data as $d) {
            Jurusan::firstOrCreate(['nama_jurusan' => $d['nama_jurusan']], $d);
        }
    }
}
