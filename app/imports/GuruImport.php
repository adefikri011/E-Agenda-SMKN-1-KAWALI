<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk logging
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row)
        {
            // 1. Bersihkan data (hapus spasi berlebih)
            // Kita ambil nilainya, jika null ganti string kosong
            $nama = trim($row['nama_guru'] ?? $row['nama'] ?? '');
            $nip = trim($row['nip'] ?? '');
            $email = trim($row['email'] ?? '');
            $jk = trim($row['jenis_kelamin'] ?? '');

            // 2. LEWATI (Skip) baris jika data penting kosong
            if (empty($nama) || empty($nip) || empty($email)) {
                // Opsional: Catat log agar tahu ada baris terlewat
                // Log::warning("Lewati baris " . ($index + 2) . " karena data tidak lengkap.");
                continue;
            }

            // 3. Cek User berdasarkan Email
            $user = User::where('email', $email)->first();

            // 4. Jika User belum ada, buat User baru
            if (!$user) {
                // Cek lagi sebelum create (Double check)
                if (empty($nama)) {
                    continue; // Jangan proses jika nama masih kosong
                }

                $user = User::create([
                    'name'     => $nama,
                    'email'    => $email,
                    'password' => Hash::make('12345678'),
                    'role'     => 'guru',
                ]);
            }

            // 5. Simpan Data Guru
            Guru::updateOrCreate(
                [
                    'nip' => $nip
                ],
                [
                    'users_id'      => $user->id,
                    'nama'          => $nama,
                    'nip'           => $nip,
                    'jenis_kelamin' => $jk,
                ]
            );
        }
    }
}
