<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineModel extends Model
{
    protected $table = 'tb_line';
    protected $primaryKey = "id_line";
    public $incrementing = true;
    protected $fillable = [
        'id_line',
        'nama_line',
        'kode_line',
    ];

    public function HasilProduksiModel(){
        return $this->hasMany('App\HasilProduksiModel','line_proses','kode_line');
    }
}
