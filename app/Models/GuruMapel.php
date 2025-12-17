<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    protected $table = 'guru_mapel';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id'
    ];

    /**
     * Relasi ke guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * Relasi ke kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke mata pelajaran
     */
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}
