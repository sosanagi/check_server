<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpuUsed extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'cpu_percent',
    ];

    public static function scopeList($query)
    {
        return $query->select(['id', 'cpu_percent']);
    }
}
