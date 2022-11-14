<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestJiguManualModel extends Model
{
    protected $table = 'tb_requestjigu_manual';
    protected $primaryKey = 'id_requestjigu_manual';
    public $incrementing = false;
    protected $fillable = [
        'id_requestjigu_manual',
        'tgl_datang',
        'nama_mesin',
        'nama_jigu',
        'kode_gambar',
        'kigou',
        'ukuran',
        'qty',
        'status',
        'user',
    ];
}
