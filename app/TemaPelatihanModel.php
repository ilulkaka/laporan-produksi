<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemaPelatihanModel extends Model
{
    protected $table = 'tb_tema_pelatihan';
    protected $primaryKey = "id_tema_pelatihan";
    protected $fillable = [
        
        'id_tema_pelatihan',
        'kategori',
        'tema_pelatihan',
        'dept_section',
        'standar',
        'user_pengaju',
        'approved',
        'tgl_approve',
        'status_pengajuan',
        
    ];
}
