<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    protected $table = 'tb_log';
    protected $primaryKey = "record_no";
    public $incrementing = false;
    protected $casts = [
        'message' => 'array',
    ];
    protected $fillable = [
        'record_no',
        'user_id',
        'activity',
        'message',
    ];
}
