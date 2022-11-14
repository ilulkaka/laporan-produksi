<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdatedenpyouModel extends Model
{
    protected $table = 'tb_update';
    protected $primaryKey = "id_update";
    public $incrementing = false;
    protected $fillable = [
        'id_update',
        'tanggal',
        'part_no',
        'jby',
        'proses',
        'jigu',
        'ukuran_salah',
        'ukuran_benar',
        'status',
        'keterangan',
        'modified',
    ];
}
