<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    /**
     * Relasi ke guru
     */
    public function guru()
    {
        return $this->hasOne(Guru::class, 'users_id');
    }

    /**
     * Relasi ke siswa
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'users_id');
    }

    /**
     * Relasi ke agenda yang dibuat oleh user ini
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'users_id');
    }

    /**
     * Relasi ke agenda yang ditandatangani oleh user ini (jika guru)
     */
    public function signedAgendas()
    {
        return $this->hasMany(Agenda::class, 'guru_ttd_id');
    }

    /**
     * Relasi ke kelas sebagai wali kelas
     */
    public function kelasAsWali()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Cek apakah user adalah guru
     */
    public function isGuru(): bool
    {
        return $this->hasRole('guru') || $this->guru !== null;
    }

    /**
     * Cek apakah user adalah siswa
     */
    public function isSiswa(): bool
    {
        return $this->hasRole('siswa') || $this->siswa !== null;
    }

    /**
     * Mendapatkan kelas user (untuk siswa)
     */
    public function getKelasAttribute()
    {
        if ($this->isSiswa() && $this->siswa) {
            return $this->siswa->kelas;
        }

        return null;
    }
}
