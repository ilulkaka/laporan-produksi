<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterTanegataModel extends Model
{
    protected $table = 'tb_master_tanegata';
    protected $primaryKey = "no_rak";
    public $incrementing = false;
    protected $fillable = [
        'id_master_tanegata',
        'no_rak',
        'kode_tane',
        'ut_d',
        'ut_b',
        'ut_t',
        'ut_dp',
        'jml_omogata',
        'dl',
        'ds',
        'il',
        'is',
        'b',
        't',
        'nprh',
        'kupingan',
        'remark',
        'tgl_cek',
        'inputor',
    ];
}
