<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HHModel extends Model
{
    protected $table = 'tb_hhky';
    protected $primaryKey = 'id_hhky';
    public $incrementing = false;
    protected $fillable = [
        'id_hhky',
        'no_laporan',
        'status_laporan',
        'tgl_lapor',
        'jenis_laporan',
        'nama',
        'nik',
        'bagian',
        'tgl_kejadian',
        'tempat_kejadian',
        'pada_saat',
        'menjadi',
        'solusi_perbaikan',
        'penyebab',
        'foto_kondisi',
        'keterangan',
    ];

}
