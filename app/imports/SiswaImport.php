<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validasi wajib
        if (
            empty($row['nama_siswa']) ||
            empty($row['nis']) ||
            empty($row['nama_kelas']) ||
            empty($row['jenkel'])
        ) {
            return null;
        }

        // Lookup kelas berdasarkan nama_kelas
        $kelas = Kelas::where('nama_kelas', trim($row['nama_kelas']))->first();
        if (!$kelas) {
            return null; // Lewati jika kelas tidak ditemukan
        }

        // Alias jenkel
        $jenkel = strtolower(trim($row['jenkel']));

        $jenkelMap = [
            'laki-laki' => 'laki-laki',
            'laki laki' => 'laki-laki',
            'l'         => 'laki-laki',
            'pria'      => 'laki-laki',

            'perempuan' => 'perempuan',
            'wanita'    => 'perempuan',
            'p'         => 'perempuan',
        ];

        if (!isset($jenkelMap[$jenkel])) {
            return null; // Lewati jika format tidak dikenal
        }

        // Cek NIS unik
        if (Siswa::where('nis', $row['nis'])->exists()) {
            return null;
        }

        return new Siswa([
            'nama_siswa' => $row['nama_siswa'],
            'nis'        => $row['nis'],
            'kelas_id'   => $kelas->id,
            'jenkel'     => $jenkelMap[$jenkel],
        ]);
    }
}
