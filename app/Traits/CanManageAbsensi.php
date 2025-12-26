<?php

namespace App\Traits;

use App\Models\Guru;
use App\Models\GuruMapel;

/**
 * Trait untuk mengecek dan mengelola akses input absensi
 * Bisa digunakan oleh Guru dan Walikelas
 */
trait CanManageAbsensi
{
    /**
     * Cek apakah user bisa input absensi
     * Return true jika user adalah guru atau walikelas
     */
    protected function canManageAbsensi()
    {
        return auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas');
    }

    /**
     * Get guru data dari user yang sedang login
     * Berfungsi untuk guru dan walikelas
     */
    protected function getGuruFromUser()
    {
        $guru = Guru::where('users_id', auth()->id())->first();

        if (!$guru) {
            return null;
        }

        return $guru;
    }

    /**
     * Cek apakah guru (atau walikelas) mengajar mapel di kelas tertentu
     */
    protected function teachesClass($guruId, $kelasId, $mapelId)
    {
        return GuruMapel::where('guru_id', $guruId)
            ->where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->exists();
    }

    /**
     * Get kelas yang bisa diakses oleh guru/walikelas yang login
     */
    protected function getAccessibleClasses()
    {
        $guru = $this->getGuruFromUser();

        if (!$guru) {
            return collect();
        }

        return GuruMapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get()
            ->unique('kelas_id')
            ->pluck('kelas');
    }

    /**
     * Get mapel yang bisa diakses oleh guru/walikelas untuk kelas tertentu
     */
    protected function getAccessibleMapelByKelas($kelasId)
    {
        $guru = $this->getGuruFromUser();

        if (!$guru) {
            return collect();
        }

        return GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $kelasId)
            ->with('mapel')
            ->get()
            ->pluck('mapel');
    }
}
