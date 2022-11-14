<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JamoperatorModel extends Model
{
    protected $table = 'tb_jam_kerja';
    protected $primaryKey ='id_jam_kerja';
    public $incrementing = false;
    protected $fillable = [
        'id_jam_kerja',
        'tgl_jam_kerja',
        'nik',
        'operator',
        'line_proses',
        'jam_mulai',
        'jam_selesai',
        'jam_total',
        'jam_lain',
        'ket',
        'status',
        'approve',
        'tgl_approve',
        'shift',
        'no_mesin',
    ];
}
