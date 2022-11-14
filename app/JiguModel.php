<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JiguModel extends Model
{
    protected $table = 'tb_jigu';
    protected $primaryKey = "id_jigu";
    public $incrementing = false;
    protected $fillable = [
        'id_jigu',
        'tgl_permintaan',
        'nama_mesin',
        'no_mesin',
        'nama_jigu',
        'kode_gambar',
        'ukuran',
        'qty',
        'no_induk',
        'alasan',
        'jenis_permintaan',
        'part_no',
        'tgl_masuk_produksi',
        'tgl_keluar_produksi',
        'status',
        'ukuran_after',
        'lokasi',
        'kigou',
        'tindakan_perbaikan',
        'pimpinan_produksi',
        'operator_produksi',
        'operator_wh',
        'operator_qa',
        'keterangan',
        'created_at',
        'updated_at',
        'no_induk_lama',
        'id_noinduk_jigu',
        'departemen',
    ];
}
