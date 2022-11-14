<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;

class UserModel extends Model
{
    use Notifiable;
    protected $table = 'tb_user';
    protected $primaryKey = "id";

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'user_name', 'password', 'departemen','line_process', 'level_user', 'nik',
    ];

    public function rollApiKey(){
        do{
            $this->api_token =Str::random(60);
        }while(
            $this->where('api_token', $this->api_token)->exists()
        );
        $this->save();
    }

    public function KaryawanModel(){
        return $this->belongsTo('App\KaryawanModel','NIK','nik');
    }

    public function PerbaikanModel(){
        return $this->hasMany('App\PerbaikanModel','user_id','id');
    }

    public function PermintaanModel(){
        return $this->hasMany('App\PermintaanModel','user_id','id');
    }

    public function MasalahModel(){
        return $this->hasMany('App\MasalahModel','user_id','id');
    }

    public function DeptheadModel(){
        return $this->hasMany('App\DeptheadModel','user_id','id');
    }


}
