<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterNGModel extends Model
{
    protected $table = 'tb_master_ng_produksi';
    protected $primaryKey = 'id_master_ng_produksi';
    public $incrementing = false;
    protected $fillable = [
        'id_master_ng_produksi',
        'kode_ng',
        'type_ng',
    ];
}
