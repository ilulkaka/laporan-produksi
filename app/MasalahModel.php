<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasalahModel extends Model
{
    protected $table = 'tb_masalah';
    protected $primaryKey = "id_masalah";
    public $incrementing = false;
    protected $fillable = [
        'id_masalah',
        'tanggal_ditemukan',
        'informer',
        'no_kartu',
        'klasifikasi',
        'lokasi',
        'masalah',
        'penyebab',
        'lampiran',
        'status_masalah',
    ];

    public function UserModel(){
        return $this->belongsTo('App\UserModel','id', 'informer');
    }
}
