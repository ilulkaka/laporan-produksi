<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\UserModel;

class MainController extends Controller
{
    public function notifskill (){

        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
        
        $listdept= array();
        
        foreach ($cekinput as $key) {
            array_push($listdept,$key->nama_departemen);  
        }
        
        $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik')->whereIn('nama_departemen',$listdept)->get();
        $dept_1= array();
        
        foreach ($dept_trining as $key1) {
            array_push($dept_1,$key1->nik);  
        }

        //dd($dept_1);
        if($user->departemen == 'PGA' && $user->level_user == 'Manager'){
            $skillmatrik = db::table('tb_tema_pelatihan')->select('status_pengajuan')->where('status_pengajuan','=',null)->get();
            $komen = db::table('tb_pelatihan_eksternal')->select('status_pelatihan')->whereIn('nik',$dept_1)->where('status_pelatihan','=','Komen Atasan')->get();

                return array(
                    'skillmatrik' => count($skillmatrik) + count($komen) ,      
                );

        } elseif ($user->level_user == 'Supervisor' || $user->level_user == 'Assisten Manager' || $user->level_user == 'Manager'){
            $komen = db::table('tb_pelatihan_eksternal')->select('status_pelatihan')->whereIn('nik',$dept_1)->where('status_pelatihan','=','Komen Atasan')->get();

                return array(
                    'skillmatrik' =>  count($komen) ,      
                );
        }
    }

    public function notifdocument (){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $datenow = date('Y-m-d');

        $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
        
        $listdept= array();
        
        foreach ($cekinput as $key) {
            array_push($listdept,$key->nama_departemen);  
        }
        
        $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section')->whereIn('nama_departemen',$listdept)->get();
        $dept_1= array();
        
        foreach ($dept_trining as $key1) {
            array_push($dept_1,$key1->dept_section);  
        }
        
        $komen = db::table('tb_manag_document')->select('doc_status')->whereIn('owner',$dept_1)->where('doc_status','=','Running')->where('notif_date','<=',$datenow)->get();
        //dd($komen);
        return array(
            'document' =>  count($komen) ,      
        );
    }
}
