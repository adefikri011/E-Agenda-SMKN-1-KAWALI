<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KelasImport implements ToModel, WithHeadingRow
{
    public $successCount = 0;
    public $failureCount = 0;

    public function model(array $row)
    {
        // Debug: log incoming row
        Log::debug('KelasImport row:', $row);

        // Handle case-insensitive headers
        $nama = null;
        $jurusanId = null;

        // Find nama_kelas - case insensitive
        foreach ($row as $key => $value) {
            $lowerKey = strtolower(trim($key));
            if ($lowerKey === 'nama_kelas') {
                $nama = trim($value);
                break;
            }
        }

        // Find jurusan_id - case insensitive
        foreach ($row as $key => $value) {
            $lowerKey = strtolower(trim($key));
            if ($lowerKey === 'jurusan_id') {
                if ($value !== '' && $value !== null) {
                    $tempId = (int)$value;
                    // Check if jurusan exists
                    if ($tempId > 0 && DB::table('jurusan')->where('id', $tempId)->exists()) {
                        $jurusanId = $tempId;
                    } else {
                        Log::warning('KelasImport: Invalid jurusan_id ' . $tempId . ', setting to NULL for kelas: ' . $nama);
                    }
                }
                break;
            }
        }

        if (empty($nama)) {
            Log::warning('KelasImport: Empty nama_kelas, skipping row: ' . json_encode($row));
            $this->failureCount++;
            return null;
        }

        // Skip if kelas with same nama_kelas already exists
        $exists = Kelas::where('nama_kelas', $nama)->first();
        if ($exists) {
            Log::warning('KelasImport: Duplicate kelas ' . $nama . ', skipping');
            $this->failureCount++;
            return null;
        }

        Log::info('KelasImport: Creating kelas ' . $nama . ' with jurusan_id=' . ($jurusanId ?? 'NULL'));

        $this->successCount++;
        return new Kelas([
            'nama_kelas' => $nama,
            'jurusan_id' => $jurusanId,
        ]);
    }
}
