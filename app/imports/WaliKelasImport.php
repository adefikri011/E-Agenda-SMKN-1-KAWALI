<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class WaliKelasImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari kelas berdasarkan nama_kelas dari Excel
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();

        // Cari guru berdasarkan NIP dari Excel
        $guru = Guru::where('nip', $row['nip_guru'])->first();

        // Jika kelas dan guru ditemukan, lakukan update
        if ($kelas && $guru) {
            // Hapus penugasan lama jika guru ini sudah menjadi wali kelas di lain tempat
            Kelas::where('wali_kelas_id', $guru->users_id)->update(['wali_kelas_id' => null]);

            // Tetapkan guru sebagai wali kelas baru
            $kelas->wali_kelas_id = $guru->users_id;
            $kelas->save();
        }
        
        // Kembalikan null karena kita tidak membuat model baru, hanya update
        return null;
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama_kelas' => 'required|string|exists:kelas,nama_kelas',
            'nip_guru' => 'required|string|exists:guru,nip',
        ];
    }
}