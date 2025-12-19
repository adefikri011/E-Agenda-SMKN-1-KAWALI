<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jampel extends Model
{
    protected $table = 'jam_pelajaran';

    protected $fillable = [
        'nama_jam',
        'rentang_waktu',
        'jam_ke',
        'hari_tipe',
        'jam_mulai',
        'jam_selesai'
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // Relasi ke agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'jampel_id');
    }

    /**
     * Scope untuk filter jam pelajaran berdasarkan hari
     */
    public function scopeByHariTipe($query, $hariTipe)
    {
        return $query->where('hari_tipe', $hariTipe);
    }

    /**
     * Scope untuk filter jam pelajaran berdasarkan jam ke-
     */
    public function scopeByJamKe($query, $jamKe)
    {
        return $query->where('jam_ke', $jamKe);
    }

    /**
     * Get formatted display name
     */
    public function getDisplayNameAttribute()
    {
        if ($this->jam_ke) {
            return "Jam {$this->jam_ke} ({$this->rentang_waktu})";
        }
        return $this->nama_jam;
    }
}
