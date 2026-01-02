<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'nim',
        'name',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = ['password'];

    // MATIKAN FIELD EMAIL LARAVEL
    protected $attributes = [];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
