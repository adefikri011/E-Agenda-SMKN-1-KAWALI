<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'no_hp',
        'alamat'
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'users_id');
    }
}
