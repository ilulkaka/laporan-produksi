<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoindukModel extends Model
{
    protected $table = 'tb_nomerinduk_jigu';
    protected $primaryKey = 'id_noinduk_jigu';
    public $incrementing = false;
    protected $fillable = [
        'id_noinduk_jigu',
        'tgl_datang',
        'nama_mesin',
        'nama_jigu',
        'kode_gambar',
        'kigou',
        'ukuran',
        'qty',
        'no_induk_jigu',
        'no_icl',
        'item_cd',
        'status',
        'lokasi',
        'created_at',
        'updated_at',
    ];
}
