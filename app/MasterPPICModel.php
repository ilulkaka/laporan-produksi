<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPPICModel extends Model
{
    protected $table = 'tb_master_ppic';
    protected $primaryKey = "part_no";
    public $incrementing = false;
    protected $fillable = [
        'part_no',
        'grouping',
        'pas',
        'material',
        'futatsuwari',
        'mark',
        'habanocchi',
        'uchinocchi',
        'detail',
        'user_input',
        'keterangan',
        'masternaiara',
        'fcr',
        'status',
        'user',
    ];
}
