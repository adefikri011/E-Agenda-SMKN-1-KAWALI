<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validasi data sebelum disimpan
        if (empty($row['nama_siswa']) || empty($row['nis']) || empty($row['kelas_id']) || empty($row['jenkel'])) {
            return null; // Lewati baris jika data tidak lengkap
        }

        // Cek apakah NIS sudah ada
        $existingSiswa = Siswa::where('nis', $row['nis'])->first();
        if ($existingSiswa) {
            return null; // Lewati baris jika NIS sudah ada
        }

        // Buat siswa
        return new Siswa([
            'nama_siswa' => $row['nama_siswa'],
            'nis'        => $row['nis'],
            'kelas_id'   => $row['kelas_id'],
            'jenkel'     => $row['jenkel'],
        ]);
    }
}
