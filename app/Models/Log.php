<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'logs';
    protected $primaryKey = 'log_id';
    protected $fillable = [
        'user_id',
        'log_method',
        'log_url',
        'log_ip',
        'log_request',
        'log_response',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
