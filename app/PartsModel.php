<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartsModel extends Model
{
    protected $table = 'tb_parts';
    protected $primaryKey = "record_parts";

    protected $fillable = [
        'record_parts', 'id_perbaikan', 'item_code','nama_part','qty'
    ];

    public function PerbaikanModel(){
        return $this->belongsTo('App\PerbaikanModel','id_perbaikan','id_perbaikan');
    }
}
