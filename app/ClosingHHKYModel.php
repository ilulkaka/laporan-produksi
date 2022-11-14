<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClosingHHKYModel extends Model
{
    protected $table = 'tb_closing_hhky';
    protected $primaryKey = 'id_closing_hhky';
    public $incrementing = false;
    protected $fillable = [
        'id_closing_hhky',
        'id_hhky',
        'periode',
        'status_laporan',
        'jenis_laporan',
        'level_resiko',
        'jenis_evaluasi',
    ];
}
