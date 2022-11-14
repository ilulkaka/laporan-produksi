<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TindakanModel extends Model
{
    protected $table = 'tb_tindakan';
    protected $primaryKey ='id_tindakan';
    public $incrementing = false;
    protected $fillable = [
        'id_tindakan',
        'id_masalah',
        'id_user',
        'isi_tindakan',
        'tgl_deadline',
        'tgl_selesai',
        'pic_tindakan',
        'status_tindakan',
        'file_lampiran',
      
    ];
}
