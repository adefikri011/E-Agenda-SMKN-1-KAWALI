<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanSebelumKBM extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_sebelum_kbm';

    protected $fillable = [
        'hari',
        'kegiatan',
        'jurusan_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the activities for a specific day
     */
    public static function getByDay($day)
    {
        return self::where('hari', $day)->get();
    }

    /**
     * Get all available days
     */
    public static function getAvailableDays()
    {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    }

    /**
     * Relasi ke jurusan (opsional)
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
