<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetModel extends Model
{
    protected $table = 'tb_target';
    protected $primaryKey = "id_number";
    protected $fillable = [
        
        'process_cd',
        'process_name',
        'target',
        'periode',
        
    ];
}
