<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jampel extends Model
{
    protected $table = 'jam_pelajaran';

    protected $fillable = ['nama_jam', 'rentang_waktu'];

    // Relasi ke agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'jampel_id');
    }
}
