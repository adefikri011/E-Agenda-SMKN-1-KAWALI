<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    protected $table = 'guru_mapel';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'start_jampel_id',
        'end_jampel_id',
        'hari_tipe'
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

    /**
     * Relasi ke jam pelajaran mulai
     */
    public function startJampel()
    {
        return $this->belongsTo(Jampel::class, 'start_jampel_id');
    }

    /**
     * Relasi ke jam pelajaran selesai
     */
    public function endJampel()
    {
        return $this->belongsTo(Jampel::class, 'end_jampel_id');
    }
}
