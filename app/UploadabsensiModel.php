<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadabsensiModel extends Model
{
    protected $table = 'tb_absen';
    protected $primaryKey ='id_no';
    public $incrementing = false;
    protected $fillable = [
        'id_no',
        'periode_absen',
        'nik',
        'tot_jadwal',
        'tot_aktual',
        'dinas_luar',
        'alpa',
        'sakit_faskes',
        'sakit_nonfaskes',
        'itu',
        'cuti_tahunan',
        'cuti_hamil',
        'cuti_nikah',
        'cuti_haid',
        'cuti_kematian',
        'cuti_khitan_anak',
        'cuti_haji',
        'cuti_kelahiran',
        'ijin_serikat',
        'tot_absen',
        'avg_absen',
        'avg_dept',
        'avg_npmi',
    ];
}
