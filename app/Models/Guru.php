<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'users_id',
        'nama',
        'nip',
        'jenis_kelamin'
    ];

    /**
     * Relasi ke tabel Users
     * Setiap guru terhubung ke satu user (akun login)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    /**
     * Relasi ke GuruMapel (guru - kelas - mata pelajaran)
     */
    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class, 'guru_id');
    }

    /**
     * Relasi ke kelas melalui GuruMapel
     */
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapel', 'guru_id', 'kelas_id')
            ->withPivot('mapel_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke mata pelajaran melalui GuruMapel
     */
    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mapel', 'guru_id', 'mapel_id')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke agenda yang dibuat oleh guru ini
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'users_id');
    }

    /**
     * Relasi ke agenda yang ditandatangani oleh guru ini
     */
    public function signedAgendas()
    {
        return $this->hasMany(Agenda::class, 'guru_ttd_id');
    }
}

