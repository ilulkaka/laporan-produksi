<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadDocumentModel extends Model
{
    protected $table = 'tb_lampiran_dokumen';
    protected $primaryKey = 'id_lampiran_dokumen';
    //protected $fillable = array ('id_manag_dokumen','filename','created_at','updated_at');
    public $incrementing = false;
    protected $fillable = [
        'id_lampiran_dokumen',
        'id_manag_dokumen',
        'filename',
    ];
}
