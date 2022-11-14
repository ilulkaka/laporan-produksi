<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PKWTModel extends Model
{
    protected $table = 'tb_pkwt';
    protected $primaryKey = 'id_pkwt';
    public $incrementing = false;
    protected $fillable = [
        'id_pkwt',
        'nik',
        'nama',
        'mulai_kontrak',
        'selesai_kontrak',
        'kontrak_ke',
        'status_pkwt',
        'lama_kontrak',
        'created_at',
        'updated_at',
        'nilai_kehadiran',
        'nilai_pkwt',
        'approve',
    ];
}
