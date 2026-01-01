<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['nim','name','password','role','status'];

    public function getJWTIdentifier(){ return $this->getKey(); }
    public function getJWTCustomClaims(){ return []; }

    public function mahasiswa(){
        return $this->hasOne(Mahasiswa::class);
    }
}
