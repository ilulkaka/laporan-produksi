<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PelatihanEksternalModel extends Model
{
    protected $table = 'tb_pelatihan_eksternal';
    protected $primaryKey = 'id_pelatihan_eksternal';
    public $incrementing = false;
    protected $fillable = [
        'id_pelatihan_eksternal',
        'id_penyelenggara',
        'tgl_pelatihan',
        'sampai',
        'nik',
        'nama',
        'tempat_pelatihan',
        'penyelenggara',
        'materi_pelatihan',
        'instruktur',
        'poin_pelatihan',
        'pendapat',
        'bentuk_pengayaan',
        'diaplikasikan_untuk',
        'lampiran_sertifikat',
        'komentar_atasan',
        'status_pelatihan',
        'tri_wulan',
        'tempo_tri_wulan',
        'tujuan_pelatihan',
        'user_input',
        'created_at',
        'updated_at',
    ];
}
