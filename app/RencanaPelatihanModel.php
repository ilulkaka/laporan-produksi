<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RencanaPelatihanModel extends Model
{
    protected $table = 'tb_rencana_pelatihan';
    protected $primaryKey = 'id_rencana_pelatihan';
    public $incrementing = false;
    protected $fillable = [
        'id_rencana_pelatihan',
        'id_tema_pelatihan',
        'nik',
        'tema_pelatihan',
        'instruktur',
        'dok_digunakan',
        'rencana_mulai',
        'rencana_selesai',
        'aktual_mulai',
        'aktual_selesai',
        'nama',
        'dept_pelatihan',
        'level_pelatihan',
        'loc_pelatihan',
        'status_pelatihan',
        'created_at',
        'updated_at',
    ];
}
