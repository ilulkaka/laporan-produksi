<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeptheadModel extends Model
{
    protected $table = 'tb_appraisal';
    protected $primaryKey = "id_appraisal";
    public $incrementing = false;
    protected $fillable = [
        'id_appraisal',
        'type',
        'periode',
        'nik',
        'nama',
        'departemen',
        'jabatan',
        'keselamatan',
        'kualitas',
        'biaya',
        'pengiriman',
        'penjualan',
        'kontrol_progres',
        'improvement',
        'penyelesaian_masalah',
        'motivasi_bawahan',
        'horenso',
        'koordinasi_pekerjaan',
        'pengetahuan',
        'keputusan',
        'perencanaan',
        'negosiasi',
        'respon',
        'kedisiplinan',
        'kerjasama',
        'antusiasme',
        'tanggung_jawab',
        'poin_kebijakan',
        'keterangan',
        'penilai',
        'dandori',
        'kecepatan',
        'ketelitian',
        'sikap_kerja',
        'ekspresi',
    ];

    public function UserModel(){
        return $this->belongsTo('App\DeptheadModel','id', 'penilai');
    }
}
