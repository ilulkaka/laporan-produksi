<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerbaikanModel extends Model
{
    protected $table = 'tb_perbaikan';
    protected $primaryKey = "id_perbaikan";
    public $incrementing = false;
    protected $fillable = [
        'id_perbaikan',
        'no_perbaikan',
        'departemen',
        'shift',
        'tanggal_rusak',
        'nama_mesin',
        'no_induk_mesin',
        'no_urut_mesin',
        'masalah',
        'kondisi',
        'penyebab',
        'tindakan',
        'tanggal_mulai',
        'tanggal_selesai',
        'klasifikasi',
        'operator',
        'total_jam_perbaikan',
        'total_jam_kerusakan',
        'total_jam_menunggu',
        'user_id',
        'approved_by',
        'completed_by',
        'lapor_ppic',
        'status',
    ];

    public function PartsModel(){
        return $this->hasMany('App\PartsModel','id_perbaikan','id_perbaikan');
    }

    public function OperatorMtcModel(){
        return $this->hasMany('App\OperatorMtcModel','id_perbaikan','id_perbaikan');
    }

    public function UserModel(){
        return $this->belongsTo('App\UserModel','id','user_id');
    }
    
}
