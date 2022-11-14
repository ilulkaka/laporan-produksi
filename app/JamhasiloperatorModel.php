<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JamhasiloperatorModel extends Model
{
    protected $table = 'tb_hasil_operator';
    protected $primaryKey ='id_hasil_operator';
    public $incrementing = false;
    protected $fillable = [
        'id_hasil_operator',
        'id_hasil_produksi',
        'nik',
        'operator',
    ];
}
