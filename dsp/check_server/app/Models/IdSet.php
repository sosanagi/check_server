<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdSet extends Model
{
    // idのセットの入力をどこかでしなければならない。
    // 受信したデータに対してのidを指定
    // 新規ならば新たなidを指定し、cpuなどのidも新たに付与した後、登録
    // そうでなければ、既に使用しているidを参照し、このデータセットから、
    // cpuなどのidを登録の際に使用まあ、つまりupdateの形となる。


    public $timestamps = false;
    
    use HasFactory;
    protected $fillable = [
        'id',
        'cpu_id',
        'memory_id',
        'net_id',
        'disk_id',
        'os_id',
    ];


}
