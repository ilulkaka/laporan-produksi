<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiwayatJiguModel extends Model
{
    protected $table = 'tb_riwayat_jigu';
    protected $primaryKey ='id_riwayat';
    public $incrementing = false;
    protected $fillable = [
        'id_riwayat',
        'no_induk',
        'nama_mesin',
        'nama_jigu',
        'kigou',
        'ukuran',
        'kigou_after',
        'ukuran_after',
        'alasan',
        'tgl_masuk_produksi',
        'tgl_keluar_produksi',
        'status',
    ];
}
