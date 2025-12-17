<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'users_id',
        'kelas_id',
        'nis',
        'nama_siswa',
        'jenkel',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
