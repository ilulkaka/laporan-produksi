<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramModel extends Model
{
    protected $table = 'tb_program';
    protected $primaryKey = "record_id";
    protected $fillable = [
        
        'record_id',
        'no_induk_mesin',
        'nama_file',
        'type_plc',
        'tgl_update',
        'link_file',
        'keterangan',
        'user_name',
        
    ];
}
