<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerNet extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'server_id',
        'ip',
        'MAC',
        'created_at',
    ];
}
