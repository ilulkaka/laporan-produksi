<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkresultModel extends Model
{
    protected $table = 'tb_workresult';
    protected $primarykey = 'id_workresult';
    public $incrementing = false;
    protected $fillable = [
        'id_workresult',
        'user_name',
        'tgl_keluar',
        'barcode_no',
        'part_no',
        'jby',
        'lot_no',
        'qty',
        'no_tag',
        'nouki',
        'start',
        'finish',
        'masalah',
        'tgl_kirim',
        'customer',
        'msk_kamu',
        'warna_tag',
    ];
}
