<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    protected $table = 'tb_manag_document';
    protected $primaryKey = 'id_manag_document';
    public $incrementing = false;
    protected $fillable = [
        'id_manag_document',
        'doc_number',
        'doc_type',
        'doc_name',
        'doc_location',
        'created_date',
        'effective_date',
        'expired_date',
        'notif_date',
        'owner',
        'category',
        'remark',
        'doc_status',
    ];
}
