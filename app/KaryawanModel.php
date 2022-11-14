<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KaryawanModel extends Model
{
    protected $connection = 'sqlsrv_pga';
    protected $table = 'T_KARYAWAN';
    protected $primaryKey ='NIK';
    public $incrementing = false;
    protected $fillable = [
        'TANGGAL_ENTRY',
        'NO_KTP',
        'NIK',
        'NAMA',
        'ALAMAT',
        'TEMPAT_LAHIR',
        'TANGGAL_LAHIR',
        'JENIS_KELAMIN',
        'AGAMA',
        'STATUS_PERNIKAHAN',
        'JUMLAH_ANAK',
        'NOMOR_TELEPON',
        'PENDIDIKAN_TERAKHIR',
        'TANGGAL_MASUK',
        'TANGGAL_KELUAR',
        'NAMA_JABATAN',
        'NAMA_DEPARTEMEN',
        'DEPT_GROUP',
        'DEPT_SECTION',
        'STATUS_KARYAWAN',
        'EMAIL',

    ];

    public function UserModel(){
        return $this->hasOne('App\UserModel','nik','NIK');
    }
}
