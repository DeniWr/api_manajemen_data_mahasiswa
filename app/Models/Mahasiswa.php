<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Mahasiswa extends Model
{
    protected $table = "mahasiswa";
    protected $fillable = ['user_id', 'jurusan', 'fakultas', 'angkatan', 'alamat', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
