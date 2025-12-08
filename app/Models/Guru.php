<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'users_id',
        'nama',
        'nik',
        'nip',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
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
     * Contoh relasi tambahan (opsional):
     * Jika guru menjadi wali kelas → kelas_id bisa ditambah nanti
     */
    // public function kelas()
    // {
    //     return $this->hasOne(Kelas::class, 'wali_kelas_id');
    // }
}
