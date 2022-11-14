<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleModel extends Model
{
    protected $table = 'tb_schedule';
    protected $primaryKey = "id_schedule";

    protected $fillable = [
        'id_schedule',
        'id_perbaikan',
        'description',
        'lokasi',
        'no_induk_mesin',
        'nama_mesin',
        'no_urut_mesin',
        'tanggal_rencana_mulai',
        'tanggal_rencana_selesai',
        'operator',
        'item_code',
        'status',
        'hasil',
        'keterangan'
    ];
}
