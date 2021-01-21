<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TlabServer extends Model
{
    public $timestamps = false;

    use HasFactory;
    protected $fillable = [
        'a',
        'b',
        'c',
    ];
}
