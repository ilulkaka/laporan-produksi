<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluasiEksternalTigaBulanModel extends Model
{
    protected $table = 'tb_evaluasi_eksternal_3bulan';
    protected $primaryKey = 'id_evaluasi_eksternal_3bulan';
    public $incrementing = false;
    protected $fillable = [
        'id_evaluasi_eksternal_3bulan',
        'id_pelatihan_eksternal',
        'ada_peningkatan',
        'skill_sebelum',
        'skill_sesudah',
        'hasil_pelatihan',
        'usulan',
        'atasan',
        'tgl_approve',
        'created_at',
        'updated_at',
    ];
}
