<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilProduksiModel extends Model
{
    protected $table = 'tb_hasil_produksi';
    protected $primaryKey = 'id_hasil_produksi';
    public $incrementing = false;
    protected $fillable = [
        'id_hasil_produksi',
        'tgl_proses',
        'part_no',
        'lot_no',
        'type',
        'crf',
        'start_qty',
        'total_production_qty',
        'camu_qty',
        'incoming_qty',
        'finish_qty',
        'line_proses',
        'operator',
        'no_mesin',
        'remark',
        'ukuran_haba',
        'cycle',
        'nik',
        'barcode_no',
        'shape',
        'departemen',
        'ng_qty',
        'shift',
        'material',
        'item_type1',
        'item_type2',
        'dandoriman',
        'dandori',
        'grouping',
        'nik',
        'tanegata',
        'cast_no',
        'moulding_no',
        'moulding_opr',
        'ukuran_haba_awal',
        'total_cycle',
        'dressing',
        'remark_1',
    ];

    public function LineModel(){
        return $this->belongsTo('App\LineModel','kode_line','line_proses');
    }
}
