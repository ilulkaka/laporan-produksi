<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarModel extends Model
{
    protected $table = 'tb_calendar';
    protected $primarykey = 'id_calendar';
    protected $fillable = [
        'id_calendar',
        'title',
        'start_event',
        'end_event',
        'color',
        'text_color',
        'user_id',
        'tag',
    ];
    public function getKeyName(){
        return "id_calendar";
    }
}
