<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluasiModel extends Model
{
    protected $table = 'tb_evaluasi';
    protected $primaryKey = 'id_evaluasi';
    public $incrementing = false;
    protected $fillable = [
        'id_evaluasi',
        'id_hhky',
        'jenis_evaluasi',
        'severity',
        'frekwensi',
        'possibility',
        'point',
        'level_resiko',
        'tindakan',
        'status_tindakan',
        'tgl_evaluasi',
        'evaluator',
    ];
}
