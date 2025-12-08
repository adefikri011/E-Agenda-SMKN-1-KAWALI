<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class SekretarisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validasi data sebelum disimpan
        if (empty($row['name']) || empty($row['email']) || empty($row['nis']) || empty($row['kelas_id']) || empty($row['jenkel'])) {
            return null; // Lewati baris jika data tidak lengkap
        }

        // Cek apakah email sudah ada
        $existingUser = User::where('email', $row['email'])->first();
        if ($existingUser) {
            return null; // Lewati baris jika email sudah ada
        }

        // Cek apakah NIS sudah ada
        $existingSiswa = Siswa::where('nis', $row['nis'])->first();
        if ($existingSiswa) {
            return null; // Lewati baris jika NIS sudah ada
        }

        // Buat user sekretaris
        $user = User::create([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => Hash::make('12345678'),
            'role'     => 'sekretaris',
        ]);

        // Buat data siswa yang terhubung ke user
        Siswa::create([
            'nama_siswa' => $row['name'],
            'nis'        => $row['nis'],
            'kelas_id'   => $row['kelas_id'],
            'jenkel'     => $row['jenkel'],
            'users_id'   => $user->id,
        ]);

        return null; // Return null karena sudah disimpan manual di atas
    }
}
