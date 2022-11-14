<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianPKWTModel extends Model
{
    protected $table = 'tb_penilaian_pkwt';
    protected $primaryKey = 'id_penilaian_pkwt';
    public $incrementing = false;
    protected $fillable = [
        'id_penilaian_pkwt',
        'id_pkwt',
        'nik',
        'nama',
        'dept_section',
        'tgl_nilai',
        'penilai',
        'inisiatif',
        'kerjasama',
        'SS',
        'KY',
        'kuantitas',
        'kualitas',
        'absensi',
        'imp',
        'ketaatan',
        'perilaku',
        'motivasi',
        'total_nilai',
        'keputusan',
        'tgl_nilai_kehadiran',
        'catatan_tambahan',
        'approve',
        'tgl_approve',
        'created_at',
        'updated_at',
    ];
}
