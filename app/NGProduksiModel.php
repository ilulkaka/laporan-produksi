<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NGProduksiModel extends Model
{
    protected $table = 'tb_ng_produksi';
    protected $primaryKey = 'id_ng_produksi';
    public $incrementing = false;
    protected $fillable = [
        'id_ng_produksi',
        'id_hasil_produksi',
        'ng_code',
        'ng_type',
        'ng_qty',
        'balance',
    ];
}
