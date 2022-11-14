<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MesinModel extends Model
{
    protected $table = 'tb_mesin';
    protected $primaryKey = "id_mesin";
    public $incrementing = false;
    protected $fillable = [
        'id_mesin',
        'no_induk',
        'nama_mesin',
        'no_urut',
        'merk_mesin',
        'type_mesin',
        'tahun_pembuatan',
        'factory',
        'lokasi',
        'kondisi',
        'kategori_mesin',
        'keterangan',
    ];

}
