<?php

namespace App\Imports;

use App\Models\Siswa;
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
            empty($row['kelas_id']) ||
            empty($row['jenkel'])
        ) {
            return null;
        }

        // Alias jenkel
        $jenkel = strtolower(trim($row['jenkel']));

        $jenkelMap = [
            'laki-laki' => 'L',
            'laki laki' => 'L',
            'l'         => 'L',
            'pria'      => 'L',

            'perempuan' => 'P',
            'wanita'    => 'P',
            'p'         => 'P',
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
            'kelas_id'   => $row['kelas_id'],
            'jenkel'     => $jenkelMap[$jenkel],
        ]);
    }
}
