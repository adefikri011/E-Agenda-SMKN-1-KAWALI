<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapels = [
            [
                'nama' => 'Matematika',
                'kode' => 'MTK',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Bahasa Indonesia',
                'kode' => 'BIND',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Bahasa Inggris',
                'kode' => 'BING',
                'kelompok' => 'Umum',
            ],
            [
                'nama' => 'Produktif RPL',
                'kode' => 'RPL',
                'kelompok' => 'Kejuruan',
            ],
            [
                'nama' => 'Basis Data',
                'kode' => 'BD',
                'kelompok' => 'Kejuruan',
            ],
        ];

        foreach ($mapels as $mapel) {
            MataPelajaran::updateOrCreate(
                ['kode' => $mapel['kode']], // biar tidak dobel
                $mapel
            );
        }
    }
}
