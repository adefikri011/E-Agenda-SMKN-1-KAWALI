<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = [
        'tanggal',
        'jampel_id',
        'kelas_id',
        'users_id',
        'mata_pelajaran',
        'materi',
        'kegiatan',
        'catatan',
        'tanda_tangan',
        'pembuat',
        'status_ttd',
        'sudah_ttd',
        'guru_ttd_id',
        'ditandatangani_oleh',
        'waktu_ttd'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_ttd' => 'datetime',
    ];

    /**
     * Relasi ke user yang membuat agenda
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relasi ke guru yang menandatangani agenda
     */
    public function guruTtd()
    {
        return $this->belongsTo(User::class, 'guru_ttd_id');
    }

    /**
     * Relasi ke kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi ke jam pelajaran
     */
    public function jampel()
    {
        return $this->belongsTo(Jampel::class, 'jampel_id');
    }

    /**
     * Relasi ke mata pelajaran
     */
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    /**
     * Relasi ke guru-mapel
     */
    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class, 'kelas_id', 'kelas_id');
    }

    /**
     * Accessor untuk status tanda tangan
     */
    public function getStatusTtdAttribute($value)
    {
        return $value === 'sudah';
    }

    /**
     * Mutator untuk status tanda tangan
     */
    public function setStatusTtdAttribute($value)
    {
        // Accept boolean or explicit string values ('sudah'|'belum').
        // Previously passing a string like 'belum' evaluated truthy and stored 'sudah'.
        if (is_bool($value)) {
            $this->attributes['status_ttd'] = $value ? 'sudah' : 'belum';
            $this->attributes['sudah_ttd'] = $value ? 1 : 0;
        } elseif (is_string($value) && in_array($value, ['sudah', 'belum'])) {
            $this->attributes['status_ttd'] = $value;
            $this->attributes['sudah_ttd'] = $value === 'sudah' ? 1 : 0;
        } else {
            // Fallback: coerce truthy values to 'sudah', falsy to 'belum'
            $this->attributes['status_ttd'] = $value ? 'sudah' : 'belum';
            $this->attributes['sudah_ttd'] = $value ? 1 : 0;
        }
    }

    /**
     * Mutator for guru_ttd_id to also set legacy column ditandatangani_oleh
     */
    public function setGuruTtdIdAttribute($value)
    {
        $this->attributes['guru_ttd_id'] = $value;
        $this->attributes['ditandatangani_oleh'] = $value;
    }

    /**
     * Mutator for waktu_ttd to keep value consistent
     */
    public function setWaktuTtdAttribute($value)
    {
        $this->attributes['waktu_ttd'] = $value;
    }

    /**
     * Scope untuk agenda yang dibuat oleh guru
     */
    public function scopeCreatedByGuru($query)
    {
        return $query->where('pembuat', 'guru');
    }

    /**
     * Scope untuk agenda yang dibuat oleh siswa
     */
    public function scopeCreatedBySiswa($query)
    {
        return $query->where('pembuat', 'siswa');
    }

    /**
     * Scope untuk agenda yang sudah ditandatangani
     */
    public function scopeSigned($query)
    {
        return $query->where('status_ttd', 'sudah');
    }

    /**
     * Scope untuk agenda yang belum ditandatangani
     */
    public function scopeUnsigned($query)
    {
        return $query->where('status_ttd', 'belum');
    }
}
