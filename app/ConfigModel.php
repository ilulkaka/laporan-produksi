<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    protected $table = 'tb_monitoring';
    protected $primaryKey = "id_config";
    public $incrementing = true;
    protected $fillable = [
        'id_config',
        'user_id',
        'kode_line',
        'kategori',
        'periode',
        'kode_ng',
    ];
}
