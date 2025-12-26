<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'kode',
    ];

    /**
     * Relasi ke kelas
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }
}
