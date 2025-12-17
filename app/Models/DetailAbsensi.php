<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAbsensi extends Model
{
    use HasFactory;

    protected $table = 'detail_absensi';

    protected $fillable = [
        'absensi_id',
        'siswa_id',
        'status',
        'keterangan'
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
