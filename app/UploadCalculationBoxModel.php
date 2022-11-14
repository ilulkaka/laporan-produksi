<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadCalculationBoxModel extends Model
{
    protected $table = 'tb_calculation_box';
    protected $primaryKey ='id_calculation_box';
    public $incrementing = false;
    protected $fillable = [
        'id_calculation_box',
        'part_no',
        'qty',
        'nouki',
        'ship_to',
        'jby',
    ];
}
