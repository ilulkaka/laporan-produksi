<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OjtModel extends Model
{
    protected $table = 'tb_ojt';
    protected $primaryKey = 'id_ojt';
    public $incrementing = false;
    protected $fillable = [
        'id_ojt',
        'id_rencana_pelatihan',
        'isi_tujuan',
        'instruktur',
        'evaluasi',
        'catatan',
        'created_at',
        'updated_at',
    ];
}
