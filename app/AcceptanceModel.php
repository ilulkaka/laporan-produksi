<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcceptanceModel extends Model
{
    protected $connection = 'oracle';
    protected $table = 't_acp_tr';
    public $incrementing = false;
}
