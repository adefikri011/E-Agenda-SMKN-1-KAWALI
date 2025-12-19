<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'kelas_id',
        'guru_id',
        'mapel_id',
        'jampel_id',
        'start_jampel_id',
        'end_jampel_id',
        'jam',
        'tanggal',
        'pertemuan',
    ];

    protected $attributes = [
        'jam' => '00:00',
    ];

    protected $dates = [
        'tanggal',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function jampel()
    {
        return $this->belongsTo(Jampel::class, 'jampel_id');
    }

    public function detailAbsensi()
    {
        return $this->hasMany(DetailAbsensi::class);
    }

    /**
     * Relasi langsung ke siswa melalui tabel detail_absensi
     * Memudahkan penggunaan whereHas('siswa', ...) pada query Absensi
     */
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'detail_absensi', 'absensi_id', 'siswa_id');
    }
}
