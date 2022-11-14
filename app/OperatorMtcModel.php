<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatorMtcModel extends Model
{
    protected $table = 'tb_operator_mtc';
    protected $primaryKey = "record_no";
    public $incrementing = false;
    protected $fillable = [
        'record_no',
        'id_perbaikan',
        'no_perbaikan',
        'nik',
        'nama',
    ];

    public function PerbaikanModel(){
        return $this->belongsTo('App\PerbaikanModel','id_perbaikan','id_perbaikan');
    }
}
