<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalisModel extends Model
{
    protected $table = 'tb_analisa';
    protected $primaryKey = "id_analisa";

    protected $fillable = [
        'id_analisa', 'id_perbaikan', 'why1','why2','why3','why4', 'why5','pencegahan',
    ];

   
}
