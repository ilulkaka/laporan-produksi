<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenyelenggaraModel extends Model
{
    protected $table = 'tb_penyelenggara';
    protected $primaryKey = 'id_penyelenggara';
    public $incrementing = false;
    protected $fillable = [
        'id_penyelenggara',
        'mulai_pelatihan',
        'selesai_pelatihan',
        'penyelenggara',
        'materi',
        'tempat',
        'instruktur',
        'inputor',
        'keterangan',
        'created_at',
        'updated_at',
    ];
}
