<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermintaanModel extends Model
{
    protected $table = 'tb_permintaan_kerja';
    protected $primaryKey = "id_permintaan";
    public $incrementing = false;
    protected $fillable = [
        'id_permintaan',
        'tanggal_permintaan',
        'no_laporan',
        'dept',
        'nama_user',
        'tujuan',
        'permintaan',
        'jenis_item',
        'nama_mesin',
        'nama_item',
        'material',
        'ukuran',
        'qty',
        'satuan',
        'alasan',
        'permintaan_perbaikan',
        'tindakan_perbaikan',
        'operator_tch',
        'tanggal_selesai',
        'material',
        'accept_by',
        'status',
        'nouki',
    ];
}