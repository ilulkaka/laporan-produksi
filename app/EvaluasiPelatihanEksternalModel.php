<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluasiPelatihanEksternalModel extends Model
{
    protected $table = 'tb_evaluasi_eksternal';
    protected $primaryKey = 'id_evaluasi_eksternal';
    public $incrementing = false;
    protected $fillable = [
        'id_evaluasi_eksternal',
        'id_pelatihan_eksternal',
        'kebutuhan',
        'metode',
        'pemahaman',
        'pengajar',
        'kelebihan',
        'kekurangan',
        'saran',
        'status_evaluasi',
        'created_at',
        'updated_at',
    ];
}
