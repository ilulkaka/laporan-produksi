<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApproveSkillmatrikModel extends Model
{
    protected $table = 'tb_approve_skillmatrik';
    protected $primaryKey = 'id_approve_skillmatrik';
    public $incrementing = false;
    protected $fillable = [
        'id_approve_skillmatrik',
        'id_rencana_pelatihan',
        'dibuat',
        'tgl_dibuat',
        'diperiksa',
        'tgl_diperiksa',
        'disahkan',
        'tgl_disahkan',
        'keterangan',
    ];
}
