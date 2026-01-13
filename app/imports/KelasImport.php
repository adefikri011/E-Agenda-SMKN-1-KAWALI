<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;

class KelasImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    public $successCount = 0;
    public $failureCount = 0;
    public $failures = [];

    /**
     * Menangani error validasi (jika kamu menambahkan WithValidation)
     */
    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
        $this->failureCount += count($failures);
    }

    public function model(array $row)
    {
        // 1. Normalisasi Key Kolom (Case Insensitive)
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            // Ubah key jadi huruf kecil dan hilangkan spasi berlebih
            $normalizedKey = strtolower(trim((string)$key));
            $normalizedRow[$normalizedKey] = $value;
        }

        // 2. Ambil Data 'nama_kelas'
        // Cari key yang mirip: 'nama_kelas', 'nama', 'kelas'
        $namaKelas = null;
        $possibleNameKeys = ['nama_kelas', 'nama', 'kelas', 'name'];

        foreach ($possibleNameKeys as $k) {
            if (isset($normalizedRow[$k]) && !empty($normalizedRow[$k])) {
                $namaKelas = trim($normalizedRow[$k]);
                break;
            }
        }

        // 3. Ambil Data 'kode_jurusan'
        // Cari key yang mirip: 'kode_jurusan', 'kode', 'jurusan'
        $kodeJurusan = null;
        $possibleCodeKeys = ['kode_jurusan', 'kode', 'code_jurusan', 'jurusan_id']; // fallback ke jurusan_id jika perlu

        foreach ($possibleCodeKeys as $k) {
            if (isset($normalizedRow[$k]) && !empty($normalizedRow[$k])) {
                $kodeJurusan = strtoupper(trim($normalizedRow[$k])); // Ubah jadi huruf besar biar match dengan DB
                break;
            }
        }

        // VALIDASI: Jika nama kelas kosong
        if (empty($namaKelas)) {
            Log::warning('KelasImport: Nama Kelas kosong. Row: ' . json_encode($row));
            $this->failureCount++; // Hitung sebagai gagal manual
            return null;
        }

        // VALIDASI: Cek Duplikat Kelas (nama_kelas di database)
        $existingKelas = Kelas::where('nama_kelas', $namaKelas)->first();
        if ($existingKelas) {
            Log::warning("KelasImport: Kelas '{$namaKelas}' sudah ada.");
            $this->failureCount++;
            return null;
        }

        // VALIDASI & PROSES: Cari Jurusan berdasarkan KODE
        $jurusanId = null;

        if (!empty($kodeJurusan)) {
            // Cari jurusan di database yang kode-nya sama dengan input Excel
            $jurusan = Jurusan::where('kode', $kodeJurusan)->first();

            if ($jurusan) {
                $jurusanId = $jurusan->id;
                Log::info("KelasImport: Kode '{$kodeJurusan}' cocok dengan ID Jurusan {$jurusanId}");
            } else {
                Log::error("KelasImport: Kode Jurusan '{$kodeJurusan}' tidak ditemukan di database!");
                $this->failureCount++;
                return null; // Batalkan import baris ini jika jurusan tidak ditemukan
            }
        } else {
            // Jika kolom kode jurusan kosong, kita bisa set NULL (opsional)
            // Atau kita gagalkan jika jurusan wajib. Disini kita set null saja.
            Log::warning("KelasImport: Kode Jurusan kosong untuk kelas '{$namaKelas}'. Diset NULL.");
        }

        // SIMPAN DATA
        $this->successCount++;

        return new Kelas([
            'nama_kelas' => $namaKelas,
            'jurusan_id' => $jurusanId, // Ini ID otomatis dari pencarian kode tadi
        ]);
    }
}
