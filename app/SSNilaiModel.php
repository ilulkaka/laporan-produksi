<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SSNilaiModel extends Model
{
    protected $table = 'tb_ss_nilai';
    protected $primaryKey ='id_ss_nilai';
    public $incrementing = false;
    protected $fillable = [
        'id_ss_nilai',
        'id_ss',
        'no_ss',
        'nik',
        'penilai',
        'poin',
        'keterangan',
    ];
}
