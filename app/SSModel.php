<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SSModel extends Model
{
    protected $table = 'tb_ss';
    protected $primaryKey ='id_ss';
    public $incrementing = false;
    protected $fillable = [
        'id_ss',
        'no_ss',
        'status_ss',
        'tgl_penyerahan',
        'nama',
        'nik',
        'departemen',
        'bagian',
        'tema_ss',
        'masalah',
        'ide_ss',
        'tujuan_ss',
        'kategori',
        'aprove1',
        'aprove2',
        'foto_before',
        'foto_after',
        'keterangan',
    ];
}
