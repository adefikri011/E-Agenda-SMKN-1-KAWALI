<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'wali_kelas_id'];

    // Relasi ke wali kelas (users)
    public function walikelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
