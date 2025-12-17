<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama',
        'kode',
        'kelompok'
    ];

    /**
     * Relasi ke GuruMapel
     */
    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class, 'mapel_id');
    }

    /**
     * Relasi ke guru melalui GuruMapel
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke kelas melalui GuruMapel
     */
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapel', 'mapel_id', 'kelas_id')
            ->withPivot('guru_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke agenda
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'mata_pelajaran', 'nama');
    }
}
