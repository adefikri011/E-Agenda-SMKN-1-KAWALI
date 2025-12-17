<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'wali_kelas_id'];

    /**
     * Relasi ke wali kelas (users)
     */
    public function walikelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke siswa
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    /**
     * Relasi ke agenda
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'kelas_id');
    }

    /**
     * Relasi ke GuruMapel
     */
    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class, 'kelas_id');
    }

    /**
     * Relasi ke guru melalui GuruMapel
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'kelas_id', 'guru_id')
            ->withPivot('mapel_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke mata pelajaran melalui GuruMapel
     */
    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mapel', 'kelas_id', 'mapel_id')
            ->withPivot('guru_id')
            ->withTimestamps();
    }
}
