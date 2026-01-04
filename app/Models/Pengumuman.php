<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Pengumuman extends Model
{
    protected $table = "Pengumumans";
    protected $fillable = ['judul', 'isi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
