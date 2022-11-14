<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\DeptheadModel;
use App\UserModel;
use App\LogModel;

class DeptheadController extends Controller
{

    public function menupenilaian(){
        return view ('/depthead/menupenilaian');
    }

    public function get_nik(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik_user = $user->nik;
        $period = $request->input('periode');
        $mode = $request->input('mode');
        $type = $request->input('type');

        $aldept = array();
        $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$nik_user)->get();
        $jab = array();
        $nikx = array();
       
        if($nik_user == '0029'){
            //hartono
            array_push($aldept,'TECHNICAL');
            array_push($aldept,'MAINTENANCE');
            array_push($aldept,'TECHNICAL');
            
        }elseif($nik_user == '0005'){
           //haryono
            //array_push($aldept,'TECHNICAL');
            //array_push($aldept,'MAINTENANCE');
            //array_push($aldept,'TECHNICAL');
            array_push($aldept,'FOUNDRY');
            array_push($aldept,'MACHINING');
            array_push($aldept,'FINAL INSPECTION');

        } elseif ($nik_user == '0009'){
            //asman
            array_push($aldept,'PGA');
            array_push($aldept,'PPIC');
            array_push($aldept,'SEKRETARIAT ISO');
        }
        
        elseif($nik_user == '0014'){
            //dwi hariyadi
            array_push($aldept,'MEAS. & JIG CHECK');
            array_push($aldept,'SEKRETARIAT ISO');
        }else{
            
            array_push($aldept,$dept[0]->dept_group);
        }

        if($mode == 'atasan'){
            if(strtoupper($dept[0]->nama_jabatan) == 'MANAGER'){
                array_push($jab,'Assisten Manager');
                array_push($jab,'Ast Supervisor');
                array_push($jab,'Supervisor');
                array_push($jab,'Foreman');
                array_push($jab,'LEADER');
               
            }elseif(strtoupper($dept[0]->nama_jabatan) == 'ASSISTEN MANAGER'){
                array_push($jab,'Ast Supervisor');
                array_push($jab,'Supervisor');
                array_push($jab,'Foreman');
                array_push($jab,'Leader');
                
            }elseif(strtoupper($dept[0]->nama_jabatan) == 'SUPERVISOR'){
                array_push($jab,'Ast Supervisor');
                array_push($jab,'Foreman');
                array_push($jab,'LEADER');
            }
        }else{
            array_push($jab,'OPERATOR');
            array_push($jab,'Staff');
            //array_push($jab,'Administrasi');
        }
        //dd($aldept);
        $niky = DB::connection('sqlsrv')->table('tb_appraisal')->select('nik','type')->where('periode',$period.'-01')->where('type',$type)->whereIn('departemen',$aldept)->get();

        //dd($niky);
        foreach ($niky as $p) {
           array_push($nikx, $p->nik);
        }
        
        $nomerinduk = DB::table('db_pgasystem.dbo.t_karyawan')->select('nik','nama','dept_group','nama_jabatan')->whereIn('dept_group',$aldept)
        ->where('status_karyawan','<>','Off')
        ->whereIn('nama_jabatan',$jab)
        ->whereNotIn('nik',$nikx)->get();

        //$nomerinduk = DB::select("select nik, nama, dept_group, nama_jabatan from db_pgasystem.dbo.T_KARYAWAN where STATUS_KARYAWAN <> 'Off' and DEPT_GROUP in $aldept and NAMA_JABATAN in $jab and NIK not in(select nik from db_produksi.dbo.tb_appraisal where periode = '2020-12-01')");


        return $nomerinduk;
    }

   

    public function penilaian(){
        //$id = Session::get('nik');
       
       //$nomerinduk = $this->get_nik($id,'umum', '2020-12');
        return view('/depthead/penilaian');
    }

    public function penilaianpimpinan(){
       
        //$id = Session::get('nik');
        //$nomerinduk = $this->get_nik($id,'atasan');
        //dd($nomerinduk);
        return view('/depthead/penilaianpimpinan');
    }

    public function bonus(){
        //$id = Session::get('nik');
       // $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$id)->get();
       // $nomerinduk = $this->get_nik($id,'umum');
        //dd($nomerinduk);
        return view('/depthead/bonus');
    }

    public function bonuspimpinan(){
        //$id = Session::get('nik');
       // $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$id)->get();
       // $nomerinduk = $this->get_nik($id,'atasan');
        //dd($nomerinduk);
        return view('/depthead/bonuspimpinan');
    }
    

    public function listpenilaian(){
       
        return view ('/depthead/listpenilaian');
    }

    public function inquerypenilaian(Request $request){
        //$test = DB::connection('sqlsrv')->table('tb_appraisal')->get();
        //dd($test);
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nam = $user->user_name;
        //$dept = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select('DEPT_GROUP')->where('nik',$user->nik)->first();
        $level = $user->level_user;
        //dd($level);
        $periode = $request->input("periode");
        //$alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('penilai')->groupBy('penilai')->get();
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('departemen')->groupBy('departemen')->get();
       
        $listdept= array();

        $aldept = array();
        $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$user->nik)->get();
        if($user->nik == '0029'){
            array_push($aldept,'TECHNICAL');
            array_push($aldept,'MAINTENANCE');
            array_push($aldept,'TECHNICAL');
            
        }elseif($user->nik == '0005'){
           
            //array_push($aldept,'TECHNICAL');
            //array_push($aldept,'MAINTENANCE');
            //array_push($aldept,'TECHNICAL');
            array_push($aldept,'FOUNDRY');
            array_push($aldept,'MACHINING');
            array_push($aldept,'FINAL INSPECTION');
        }
        elseif($user->nik == '0014'){
            array_push($aldept,'MEAS. & JIG CHECK');
            array_push($aldept,'SEKRETARIAT ISO');
        }else{
            
            array_push($aldept,$dept[0]->dept_group);
        }
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->departemen);
               
                
            }
        }elseif($level == 'Supervisor' || $level == 'Assisten Supervisor' || $level == 'Assisten Manager' || $level == 'Leader' || $level == 'Foreman'){
            //array_push($listdept, $dept->DEPT_GROUP); 
            $listdept = $aldept;
        }else {
            array_push($listdept, $nam); 
            $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Performance')->where('a.periode','like',$periode.'%')
            ->where('a.jabatan','!=','leader')
            ->where('a.jabatan','!=','foreman')
            ->where('a.jabatan','!=','Ast Supervisor')
            ->where('a.jabatan','!=','Supervisor')
            ->where('a.jabatan','!=','Assisten Manager')
            ->where('a.jabatan','!=','Manager')
            ->whereIn('a.penilai',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })             
            ->skip($start)
            ->take($length)
            ->get();
    
      
        $count = DB::table('tb_appraisal')->where('type','=','Performance')->where('periode','like',$periode.'%')
        ->where('jabatan','!=','leader')
        ->where('jabatan','!=','foreman')
        ->where('jabatan','!=','Ast Supervisor')
        ->where('jabatan','!=','Supervisor')
        ->where('jabatan','!=','Assisten Manager')
        ->where('jabatan','!=','Manager')
        ->whereIn('penilai',$listdept)
        ->where(function($q) use ($search){
            $q->orWhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('periode','like','%'.$search.'%');
        })    
        ->count();
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }
        
    
            $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Performance')->where('a.periode','like',$periode.'%')
            ->where('a.jabatan','!=','leader')
            ->where('a.jabatan','!=','foreman')
            ->where('a.jabatan','!=','Ast Supervisor')
            ->where('a.jabatan','!=','Supervisor')
            ->where('a.jabatan','!=','Assisten Manager')
            ->where('a.jabatan','!=','Manager')
            ->whereIn('a.departemen',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })            
            ->skip($start)
            ->take($length)
            ->get();

            //dd($Datas);
      
        $count = DB::table('tb_appraisal')->where('type','=','Performance')->where('periode','like',$periode.'%')
        ->where('jabatan','!=','leader')
        ->where('jabatan','!=','foreman')
        ->where('jabatan','!=','Ast Supervisor')
        ->where('jabatan','!=','Supervisor')
        ->where('jabatan','!=','Ast Manager')
        ->where('jabatan','!=','Manager')
        ->whereIn('departemen',$listdept)
        ->where(function($q) use ($search){
            $q->orWhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('periode','like','%'.$search.'%');
        })    
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inquerypenilaianpimpinan(Request $request){
        //$test = DB::connection('sqlsrv')->table('tb_appraisal')->where('departemen','=','maintenance')->get();
        //dd($test);
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode_1 = $request->input("periode_1");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nam = $user->user_name;
        //$dept = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select('DEPT_GROUP')->where('nik',$user->nik)->first();
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('departemen')->groupBy('departemen')->get();
       
        $listdept= array();
        $aldept = array();
        $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$user->nik)->get();
        if($user->nik == '0029'){
            array_push($aldept,'TECHNICAL');
            array_push($aldept,'MAINTENANCE');
            array_push($aldept,'TECHNICAL');
            
        }elseif($user->nik == '0005'){
           
            //array_push($aldept,'TECHNICAL');
            //array_push($aldept,'MAINTENANCE');
            //array_push($aldept,'TECHNICAL');
            array_push($aldept,'FOUNDRY');
            array_push($aldept,'MACHINING');
            array_push($aldept,'FINAL INSPECTION');
        }
        elseif($user->nik == '0014'){
            array_push($aldept,'MEAS. & JIG CHECK');
            array_push($aldept,'SEKRETARIAT ISO');
        }else{
            
            array_push($aldept,$dept[0]->dept_group);
        }

        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->departemen);
                
            }
        }elseif($level == 'Supervisor' || $level == 'Assisten Supervisor' || $level == 'Assisten Manager'){
            //array_push($listdept, $dept->DEPT_GROUP); 
            $listdept = $aldept;
        } else {
            array_push($listdept, $nam); 
            $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Performance')->where('a.periode','like',$periode_1.'%')
            ->where('a.jabatan','!=','operator')
            ->where('a.jabatan','!=','staff')
            ->whereIn('a.penilai',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })          
            ->skip($start)
            ->take($length)
            ->get();
        //

        $count = DeptheadModel::wherein('penilai',$listdept)->where('type','=','Performance')->where('periode','like',$periode_1.'%')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->where(function($q) use ($search){
            $q->where('periode','like','%'.$search.'%')
            ->orWhere('nik','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%');
        })    
        ->count();
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
        }
       // dd($listdept);
        
        $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Performance')->where('a.periode','like',$periode_1.'%')
                ->where('a.jabatan','!=','operator')
                ->where('a.jabatan','!=','staff')
                ->whereIn('a.departemen',$listdept)
                ->where(function($q) use ($search){
                    $q->orWhere('a.nik','like','%'.$search.'%') 
                    ->orwhere('a.nama','like','%'.$search.'%')
                    ->orwhere('a.departemen','like','%'.$search.'%')
                    ->orwhere('a.periode','like','%'.$search.'%');
                })                 
                ->skip($start)
                ->take($length)
                ->get();
        //

        $count = DeptheadModel::wherein('departemen',$listdept)->where('type','=','Performance')->where('periode','like',$periode_1.'%')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->where(function($q) use ($search){
            $q->where('periode','like','%'.$search.'%')
            ->orWhere('nik','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%');
        })    
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inquerypenilaianbonus(Request $request){

        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode_bonus = $request->input("periode_bonus")."-01";
        //dd($periode_bonus);
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nam = $user->user_name;
        //$dept = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select('DEPT_GROUP')->where('nik',$user->nik)->first();
        $level = $user->level_user;
        $periode = $request->input("periode");
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('departemen')->groupBy('departemen')->get();
       
        $listdept= array();

        $aldept = array();
        $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$user->nik)->get();
        if($user->nik == '0029'){
            array_push($aldept,'TECHNICAL');
            array_push($aldept,'MAINTENANCE');
            array_push($aldept,'TECHNICAL');
            
        }elseif($user->nik == '0005'){
           
            //array_push($aldept,'TECHNICAL');
            //array_push($aldept,'MAINTENANCE');
            //array_push($aldept,'TECHNICAL');
            array_push($aldept,'FOUNDRY');
            array_push($aldept,'MACHINING');
            array_push($aldept,'FINAL INSPECTION');
        }
        elseif($user->nik == '0014'){
            array_push($aldept,'MEAS. & JIG CHECK');
            array_push($aldept,'SEKRETARIAT ISO');
        }else{
            
            array_push($aldept,$dept[0]->dept_group);
        }
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->departemen);
               
                
            }
        }elseif($level == 'Supervisor' || $level == 'Assisten Supervisor' || $level == 'Assisten Manager' || $level == 'Leader' || $level == 'Foreman'){
            //array_push($listdept, $dept->DEPT_GROUP); 
            $listdept = $aldept;
        }else {
            array_push($listdept, $nam); 
            $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Bonus')->where('a.periode','like',$periode_bonus.'%')
            ->where('a.jabatan','!=','leader')
            ->where('a.jabatan','!=','foreman')
            ->where('a.jabatan','!=','Ast Supervisor')
            ->where('a.jabatan','!=','Supervisor')
            ->where('a.jabatan','!=','Assisten Manager')
            ->where('a.jabatan','!=','Manager')
            ->whereIn('a.penilai',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })              
            ->skip($start)
            ->take($length)
            ->get();
    
      
        $count = DB::table('tb_appraisal')->where('type','=','Bonus')->where('periode','like',$periode_bonus.'%')
        ->where('jabatan','!=','leader')
        ->where('jabatan','!=','foreman')
        ->where('jabatan','!=','Ast Supervisor')
        ->where('jabatan','!=','Supervisor')
        ->where('jabatan','!=','Assisten Manager')
        ->where('jabatan','!=','Manager')
        ->whereIn('penilai',$listdept)
        ->where(function($q) use ($search){
            $q->orWhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('periode','like','%'.$search.'%');
        })    
        ->count();
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }
        
    
            $Datas =DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Bonus')->where('a.periode','like',$periode_bonus.'%')
            ->where('a.jabatan','!=','leader')
            ->where('a.jabatan','!=','foreman')
            ->where('a.jabatan','!=','Ast Supervisor')
            ->where('a.jabatan','!=','Supervisor')
            ->where('a.jabatan','!=','Assisten Manager')
            ->where('a.jabatan','!=','Manager')
            ->whereIn('a.departemen',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })                   
            ->skip($start)
            ->take($length)
            ->get();
           // dd($Datas);
      
        $count = DB::table('tb_appraisal')->where('type','=','Bonus')->where('periode','like',$periode_bonus.'%')
        ->where('jabatan','!=','leader')
        ->where('jabatan','!=','foreman')
        ->where('jabatan','!=','Ast Supervisor')
        ->where('jabatan','!=','Supervisor')
        ->where('jabatan','!=','Ast Manager')
        ->where('jabatan','!=','Manager')
        ->whereIn('departemen',$listdept)
        ->where(function($q) use ($search){
            $q->orWhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('periode','like','%'.$search.'%');
        })    
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inquerybonuspimpinan(Request $request){
        //$test = DB::connection('sqlsrv')->table('tb_appraisal')->where('departemen','=','maintenance')->get();
        //dd($test);
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode_bonus_1 = $request->input("periode_bonus_1")."-01";
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nam = $user->user_name;
        //$dept = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select('DEPT_GROUP')->where('nik',$user->nik)->first();
        $level = $user->level_user;
        $periode = $request->input("periode");
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('departemen')->groupBy('departemen')->get();
       
        $listdept= array();

        $aldept = array();
        $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$user->nik)->get();
        if($user->nik == '0029'){
            array_push($aldept,'TECHNICAL');
            array_push($aldept,'MAINTENANCE');
            array_push($aldept,'TECHNICAL');
            
        }elseif($user->nik == '0005'){
           
            //array_push($aldept,'TECHNICAL');
            //array_push($aldept,'MAINTENANCE');
            //array_push($aldept,'TECHNICAL');
            array_push($aldept,'FOUNDRY');
            array_push($aldept,'MACHINING');
            array_push($aldept,'FINAL INSPECTION');
        }
        elseif($user->nik == '0014'){
            array_push($aldept,'MEAS. & JIG CHECK');
            array_push($aldept,'SEKRETARIAT ISO');
        }else{
            
            array_push($aldept,$dept[0]->dept_group);
        }
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->departemen);
               
                
            }
        }elseif($level == 'Supervisor' || $level == 'Assisten Supervisor' || $level == 'Assisten Manager'){
            //array_push($listdept, $dept->DEPT_GROUP); 
            $listdept = $aldept;
        }else {
            array_push($listdept, $nam); 
            $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Bonus')->where('a.periode','like',$periode_bonus_1.'%')
            ->where('a.jabatan','!=','operator')
            ->where('a.jabatan','!=','staff')
            ->whereIn('a.penilai',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })            
            ->skip($start)
            ->take($length)
            ->get();
    
      
        $count = DB::table('tb_appraisal')->where('type','=','Bonus')->where('periode','like',$periode_bonus_1.'%')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->whereIn('penilai',$listdept)
        ->where(function($q) use ($search){
            $q->orWhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('periode','like','%'.$search.'%');
        })    
        ->count();
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }

      
            $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select('a.*','b.STATUS_KARYAWAN')->where('a.type','=','Bonus')->where('a.periode','like',$periode_bonus_1.'%')
            ->where('a.jabatan','!=','operator')
            ->where('a.jabatan','!=','staff')
            ->whereIn('a.departemen',$listdept)
            ->where(function($q) use ($search){
                $q->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.departemen','like','%'.$search.'%')
                ->orwhere('a.periode','like','%'.$search.'%');
            })             
            ->skip($start)
            ->take($length)
            ->get();
    
      
        $count = DB::table('tb_appraisal')->where('type','=','Bonus')->where('periode','like',$periode_bonus_1.'%')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->whereIn('departemen',$listdept)
        ->where(function($q) use ($search){
            $q->orWhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('departemen','like','%'.$search.'%')
            ->orwhere('periode','like','%'.$search.'%');
        })    
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function getCategory(Request $request){
        $nik = $request->input("nonik");
        $periode = $request->input("periode");
       
        $hasil = $this->getnilai($nik, $periode);
        
        return 
           $hasil;
    }

    public function getnilai ($nik, $periode){
        $pp = substr($periode,0,4);
        $dept = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select('DEPT_GROUP')->where('STATUS_KARYAWAN','<>','Off')->where('NIK','=',$nik)->first();
        $prosentase = DB::table('tb_absen')->select('avg_absen', 'avg_dept')->where('nik','=',$nik)->where('periode_absen','=',$periode.'-01')->first();
        //dd($periode);
        $ss = DB::table('tb_ss')->select('nik')->where(\DB::raw('DATEPART(YEAR,tgl_penyerahan)'),'=',$pp)->where('nik','=',$nik)->count();
       
        $hh = DB::table('tb_hhky')->select('nik')->where(\DB::raw('DATEPART(YEAR,tgl_lapor)'),'=',$pp)->where('nik','=',$nik)->where('jenis_laporan','=','KY')->count();
        //dd($hh);

        $poinkaizen = 0;
        if($ss + $hh >= 4){
            $poinkaizen = $poinkaizen + 5;
        }elseif ($ss + $hh >= 3) {
            $poinkaizen = $poinkaizen + 4;
        } elseif ($ss + $hh == 2) {
            $poinkaizen = $poinkaizen + 3;
        } elseif ($ss + $hh == 1) {
            $poinkaizen = $poinkaizen + 2;
        } else {
            $poinkaizen = $poinkaizen + 1;
        }

        //dd($poinkaizen);

        if(empty($prosentase)){
            $hasilprosentase = 0;
            $hasilprosentase_dept = 99999;
        } else{
            $hasilprosentase = $prosentase->avg_absen * 100;
            $hasilprosentase_dept = $prosentase->avg_dept * 100;
        }
        
        $hasil = 0;
        if($hasilprosentase - $hasilprosentase_dept >= 2.00){
            $hasil = $hasil + 5;
        }elseif($hasilprosentase - $hasilprosentase_dept >= 0.00){
            $hasil = $hasil + 4;
        }elseif($hasilprosentase - $hasilprosentase_dept < 0.00 && $hasilprosentase - $hasilprosentase_dept >= -1.99){
            $hasil = $hasil + 3;
        }elseif($hasilprosentase - $hasilprosentase_dept <= -2 &&  $hasilprosentase - $hasilprosentase_dept >= -4){
            $hasil = $hasil + 2;
        }elseif($hasilprosentase - $hasilprosentase_dept < -4 &&  $hasilprosentase - $hasilprosentase_dept >= -90){
            $hasil = $hasil + 1;
        }elseif($hasilprosentase - $hasilprosentase_dept < -99999){
            $hasil = $hasil;
        }

        
        if($dept->DEPT_GROUP == 'PURCHASING & WH' || $dept->DEPT_GROUP == 'HSE & ISO' || $dept->DEPT_GROUP == 'ACT / FIN' || $dept->DEPT_GROUP == 'PGA'){
            $ind = 'indirect';
        }else{
            $ind = 'production';
        }

        //return $hasil;
        return array(
            "hasil"=>$hasil,
            "prosentase"=>$hasilprosentase,
            "prosentase_dept"=>$hasilprosentase_dept,
            'jenis'=>$ind,
            "poinkaizen"=>$poinkaizen,
            "ss"=>$ss,
            "hh"=>$hh
        );
    }

    public function input_penilaian (Request $request){
        //dd($request->all());
        $nik = $request->input("nonik");
        $periode = $request->input("periode");
        $dept1 = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$nik)->first();
        $cek = DB::table('tb_appraisal')->select('nik', 'periode')->where('nik','=',$nik)->where('periode','=',$periode.'-01')->where('type','=','Performance')->count();
        
        if ($cek > 0){
            Session::flash('alert-danger','Data sudah ada.'); 
            return redirect()->route('depthead_input_penilaian');
        } else {
            $hasil = $this->getnilai($nik, $periode);
            //dd($hasil['poinkaizen']);
        $insert = DeptheadModel::create([
        'id_appraisal'=>Str::uuid(),
        'type'=>'Performance',
        'periode'=>$request->periode."-01",
        'nik'=>$request->nonik,
        'nama'=>$request->nama,
        'departemen'=>$dept1->dept_group,
        'jabatan'=>$dept1->nama_jabatan,
        'dandori'=>$request->dandori,
        'kecepatan'=>$request->kecepatan,
        'ketelitian'=>$request->ketelitian,
        'improvement'=>$hasil['poinkaizen'],
        'sikap_kerja'=>$request->sikap_kerja,
        'penyelesaian_masalah'=>$request->penyelesaian_masalah,
        'horenso'=>$request->horenso,
        'pengetahuan'=>$request->pengetahuan,
        'keputusan'=>$request->keputusan,
        'ekspresi'=>$request->ekspresi,
        'perencanaan'=>$request->perencanaan,
        'respon'=>$request->respon,
        'kedisiplinan'=>$hasil['hasil'],
        'kerjasama'=>$request->kerjasama,
        'antusiasme'=>$request->antusiasme,
        'tanggung_jawab'=>$request->tanggung_jawab,
        'poin_kebijakan'=> 0,
        'penilai'=>Session::get('name'),
        ]);
        }


     if ($insert) {
             
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }

        return redirect()->route('depthead_input_penilaian'); 
    } 

    public function edit_penilaian_umum(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req1 = DeptheadModel::find($id);

            $id_appraisal = $request['edit-appraisal'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
            //dd($req);
            $req->dandori = $request['edit-dandori'];
            $req->kecepatan = $request['edit-kecepatan'];
            $req->ketelitian = $request['edit-ketelitian'];

            $req->sikap_kerja = $request['edit-sikap_kerja'];
            $req->penyelesaian_masalah = $request['edit-penyelesaian_masalah'];
            $req->horenso = $request['edit-horenso'];
            $req->pengetahuan = $request['edit-pengetahuan'];
            $req->keputusan = $request['edit-keputusan'];
            $req->ekspresi = $request['edit-ekspresi'];
            $req->perencanaan = $request['edit-perencanaan'];
            $req->respon = $request['edit-respon'];

            $req->kerjasama = $request['edit-kerjasama'];
            $req->antusiasme = $request['edit-antusiasme'];
            $req->tanggung_jawab = $request['edit-tanggung_jawab'];


        $message['update']= 'tb_appraisal';
        $message['id_appraisal']= $id_appraisal;
        $message['nik']= $nik;
        if ($req->isDirty('dandori')) {
            $message['dandori']=$request['edit-dandori'];
        }
        if ($req->isDirty('kecepatan')) {
            $message['kecepatan']=$request['edit-kecepatan'];
        }
        if ($req->isDirty('ketelitian')) {
            $message['ketelitian']=$request['edit-ketelitian'];
        }
        if ($req->isDirty('sikap_kerja')) {
            $message['sikap_kerja']=$request['edit-sikap_kerja'];
        }
        if ($req->isDirty('penyelesaian_masalah')) {
            $message['penyelesaian_masalah']=$request['edit-penyelesaian_masalah'];
        }
        if ($req->isDirty('horenso')) {
            $message['horenso']=$request['edit-horenso'];
        }
        if ($req->isDirty('pengetahuan')) {
            $message['pengetahuan']=$request['edit-pengetahuan'];
        }
        if ($req->isDirty('keputusan')) {
            $message['keputusan']=$request['edit-keputusan'];
        }
        if ($req->isDirty('ekspresi')) {
            $message['ekspresi']=$request['edit-ekspresi'];
        }
        if ($req->isDirty('perencanaan')) {
            $message['perencanaan']=$request['edit-perencanaan'];
        }
        if ($req->isDirty('respon')) {
            $message['respon']=$request['edit-respon'];
        }
        if ($req->isDirty('kerjasama')) {
            $message['kerjasama']=$request['edit-kerjasama'];
        }
        if ($req->isDirty('antusiasme')) {
            $message['antusiasme']=$request['edit-antusiasme'];
        }
        if ($req->isDirty('tanggung_jawab')) {
            $message['tanggung_jawab']=$request['edit-tanggung_jawab'];
        }

        
        

        $req->save();
        $data = [
            'record_no' => Str::uuid(),
            //'user_id' => Session::get('id'),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $message,
        ];
        LogModel::create($data);

        return array(
            'message' =>"Update data berhasil !",
            'success'=>true
        );
    }

    public function approval_penilaian_umum(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $level = $user->level_user;
        $rubah = $user->user_name;
        $id = $request->input('id');
            //$req = DeptheadModel::find($id);

            $id_appraisal = $request['approve-appraisal'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
          //dd($req);
  
          
          if($level == 'Supervisor' || $level == 'Assisten Manager' || $level == 'Manager'){
            $message['id_appraisal']= $id_appraisal;
            $message['nik']= $nik;
            $message['disetujui']= $rubah;
              $req->disetujui = $rubah;
              $req->save();
              $data = [
                  'record_no' => Str::uuid(),
                  //'user_id' => Session::get('id'),
                  'user_id' => $user->id,
                  'activity' =>"update",
                  'message' => $message,
              ];
              LogModel::create($data);
        }else{
            return array(
                'message' =>"Anda tidak berhak untuk Aprove, jangan coba - coba !",
                'success'=>false
            );
          }



        return array(
            'message' =>"Approve berhasil !",
            'success'=>true
        );
    }

    public function edit_penilaian_leaderup (Request $request){
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req1 = DeptheadModel::find($id);

            $id_appraisal = $request['edit-appraisal-1'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
            //dd($nik);
            $req->keselamatan = $request['edit-keselamatan-1'];
            $req->kualitas = $request['edit-kualitas-1'];
            $req->biaya = $request['edit-biaya-1'];
            $req->pengiriman = $request['edit-pengiriman-1'];
            $req->penjualan = $request['edit-penjualan-1'];
            $req->kontrol_progres = $request['edit-kontrol_progres-1'];

            $req->penyelesaian_masalah = $request['edit-penyelesaian_masalah-1'];
            $req->motivasi_bawahan = $request['edit-motivasi_bawahan-1'];
            $req->horenso = $request['edit-horenso-1'];
            $req->koordinasi_pekerjaan = $request['edit-koordinasi_pekerjaan-1'];
            $req->pengetahuan = $request['edit-pengetahuan-1'];
            $req->keputusan = $request['edit-keputusan-1'];
            $req->perencanaan = $request['edit-perencanaan-1'];
            $req->negosiasi = $request['edit-negosiasi-1'];
            $req->respon = $request['edit-respon-1'];

            $req->kerjasama = $request['edit-kerjasama-1'];
            $req->antusiasme = $request['edit-antusiasme-1'];
            $req->tanggung_jawab = $request['edit-tanggung_jawab-1'];


        $message['update']= 'tb_appraisal';
        $message['id_appraisal']= $id_appraisal;
        $message['nik']= $nik;
        if ($req->isDirty('keselamatan')) {
            $message['keselamatan']=$request['edit-keselamatan-1'];
        }
        if ($req->isDirty('kualitas')) {
            $message['kualitas']=$request['edit-kualitas-1'];
        }
        if ($req->isDirty('biaya')) {
            $message['biaya']=$request['edit-biaya-1'];
        }
        if ($req->isDirty('pengiriman')) {
            $message['pengiriman']=$request['edit-pengiriman-1'];
        }
        if ($req->isDirty('penjualan')) {
            $message['penjualan']=$request['edit-penjualan-1'];
        }
        if ($req->isDirty('kontrol_progres')) {
            $message['kontrol_progres']=$request['edit-kontrol_progres-1'];
        }
        if ($req->isDirty('penyelesaian_masalah')) {
            $message['penyelesaian_masalah']=$request['edit-penyelesaian_masalah-1'];
        }
        if ($req->isDirty('motivasi_bawahan')) {
            $message['motivasi_bawahan']=$request['edit-motivasi_bawahan-1'];
        }
        if ($req->isDirty('horenso')) {
            $message['horenso']=$request['edit-horenso-1'];
        }
        if ($req->isDirty('koordinasi_pekerjaan')) {
            $message['koordinasi_pekerjaan']=$request['edit-koordinasi_pekerjaan-1'];
        }
        if ($req->isDirty('pengetahuan')) {
            $message['pengetahuan']=$request['edit-pengetahuan-1'];
        }
        if ($req->isDirty('keputusan')) {
            $message['keputusan']=$request['edit-keputusan-1'];
        }
        if ($req->isDirty('perencanaan')) {
            $message['perencanaan']=$request['edit-perencanaan-1'];
        }
        if ($req->isDirty('negosiasi')) {
            $message['negosiasi']=$request['edit-negosiasi-1'];
        }
        if ($req->isDirty('respon')) {
            $message['respon']=$request['edit-respon-1'];
        }
        if ($req->isDirty('kerjasama')) {
            $message['kerjasama']=$request['edit-kerjasama-1'];
        }
        if ($req->isDirty('antusiasme')) {
            $message['antusiasme']=$request['edit-antusiasme-1'];
        }
        if ($req->isDirty('tanggung_jawab')) {
            $message['tanggung_jawab']=$request['edit-tanggung_jawab-1'];
        }

        
        

        $req->save();
        $data = [
            'record_no' => Str::uuid(),
            //'user_id' => Session::get('id'),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $message,
        ];
        LogModel::create($data);

        return array(
            'message' =>"Update data berhasil !",
            'success'=>true
        );
    }

    public function approval_penilaian_leaderup(Request $request){
        //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $level = $user->level_user;
            //$req = DeptheadModel::find($id);

            $id_appraisal = $request['approve-appraisal-1'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
          //dd($req);
          if($level == 'Supervisor' || $level == 'Assisten Manager' || $level == 'Manager'){
              $req->disetujui = $rubah;
              $message['id_appraisal']= $id_appraisal;
              $message['nik']= $nik;
              $message['disetujui']= $rubah;
    
            $req->save();
            $data = [
                'record_no' => Str::uuid(),
                //'user_id' => Session::get('id'),
                'user_id' => $user->id,
                'activity' =>"update",
                'message' => $message,
            ];
            LogModel::create($data);
        }else{
            return array(
                'message' =>"Anda tidak berhak untuk Aprove, jangan coba - coba !",
                'success'=>false
            );
          }



        return array(
            'message' =>"Approve berhasil !",
            'success'=>true
        );
    }

    public function input_penilaian_pimpinan (Request $request){
        //dd($request->all());
        $nik = $request->input("nonik");
        $periode = $request->input("periode");
        $dept1 = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$nik)->first();
        //dd($dept1);
        $cek = DB::table('tb_appraisal')->select('nik', 'periode')->where('nik','=',$nik)->where('periode','=',$periode.'-01')->where('type','=','Performance')->count();
        if ($cek > 0){
        Session::flash('alert-danger','Data sudah ada.'); 
        return redirect()->route('depthead_input_penilaian_pimpinan');
        } else {
            $hasil = $this->getnilai($nik, $periode);

            $insert = DeptheadModel::create([
            'id_appraisal'=>Str::uuid(),
            'type'=>'Performance',
            'periode'=>$request->periode."-01",
            'nik'=>$request->nonik,
            'nama'=>$request->nama,
            'departemen'=>$dept1->dept_group,
            'jabatan'=>$dept1->nama_jabatan,
            'keselamatan'=>$request->keselamatan,
            'kualitas'=>$request->kualitas,
            'biaya'=>$request->biaya,
            'pengiriman'=>$request->pengiriman,
            'penjualan'=>$request->penjualan,
            'kontrol_progres'=>$request->kontrol_progres,
            'improvement'=>$hasil['poinkaizen'],
            'penyelesaian_masalah'=>$request->penyelesaian_masalah,
            'motivasi_bawahan'=>$request->motivasi_bawahan,
            'horenso'=>$request->horenso,
            'koordinasi_pekerjaan'=>$request->koordinasi_pekerjaan,
            'pengetahuan'=>$request->pengetahuan,
            'keputusan'=>$request->keputusan,
            'perencanaan'=>$request->perencanaan,
            'negosiasi'=>$request->negosiasi,
            'respon'=>$request->respon,
            'kedisiplinan'=>$hasil['hasil'],
            'kerjasama'=>$request->kerjasama,
            'antusiasme'=>$request->antusiasme,
            'tanggung_jawab'=>$request->tanggung_jawab,
            'poin_kebijakan'=> 0,
            'penilai'=>Session::get('name'),
                ]);
        }


     if ($insert) {
             
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }

        return redirect()->route('depthead_input_penilaian_pimpinan'); 
    }

    

    public function input_bonus (Request $request){
        $nik = $request->input("nonik");
        $periode = $request->input("periode");

        $hasil = $this->getnilai($nik, $periode);
        //dd($hasil['hasil']);
        
        $dept1 = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$nik)->first();
        //dd($dept1);
        $cek = DB::table('tb_appraisal')->select('nik', 'periode')->where('nik','=',$nik)->where('periode','=',$periode.'-01')->where('type','=','Bonus')->count();
        if ($cek > 0){
        Session::flash('alert-danger','Data sudah ada.'); 
        return redirect()->route('depthead_input_bonus');
        } elseif ($hasil['hasil'] < 1) {
            Session::flash('alert-danger', 'NIK ' .$nik.' Tidak Masuk dalam penilaian .'); 
            return redirect()->route('depthead_input_bonus');
        } else {
            $hasil = $this->getnilai($nik, $periode);
            $insert = DeptheadModel::create([
                'id_appraisal'=>Str::uuid(),
                'type'=>'Bonus',
                'periode'=>$request->periode."-01",
                'nik'=>$request->nonik,
                'nama'=>$request->nama,
                'departemen'=>$dept1->dept_group,
                'jabatan'=>$dept1->nama_jabatan,
                'dandori'=>$request->dandori,
                'kecepatan'=>$request->kecepatan,
                'ketelitian'=>$request->ketelitian,
                'improvement'=>$hasil['poinkaizen'],
                'sikap_kerja'=>$request->sikap_kerja,
                'penyelesaian_masalah'=>$request->penyelesaian_masalah,
                'horenso'=>$request->horenso,
                'kedisiplinan'=>$hasil['hasil'],
                'kerjasama'=>$request->kerjasama,
                'antusiasme'=>$request->antusiasme,
                'tanggung_jawab'=>$request->tanggung_jawab,
                'poin_kebijakan'=> 0,
                'penilai'=>Session::get('name'),
                ]);
        }


     if ($insert) {
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
            Session::flash('alert-danger','Tambah Data gagal !'); 
        }
        return redirect()->route('depthead_input_bonus'); 
    }

    public function edit_bonus_umum(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req1 = DeptheadModel::find($id);

            $id_appraisal = $request['eb-appraisal-bonus'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
            //dd($req);
            $req->dandori = $request['eb-dandori'];
            $req->kecepatan = $request['eb-kecepatan'];
            $req->ketelitian = $request['eb-ketelitian'];

            $req->sikap_kerja = $request['eb-sikap_kerja'];
            $req->penyelesaian_masalah = $request['eb-penyelesaian_masalah'];
            $req->horenso = $request['eb-horenso'];

            $req->kerjasama = $request['eb-kerjasama'];
            $req->antusiasme = $request['eb-antusiasme'];
            $req->tanggung_jawab = $request['eb-tanggung_jawab'];


        $message['update']= 'tb_appraisal';
        $message['id_appraisal']= $id_appraisal;
        $message['nik']= $nik;
        if ($req->isDirty('dandori')) {
            $message['dandori']=$request['eb-dandori'];
        }
        if ($req->isDirty('kecepatan')) {
            $message['kecepatan']=$request['eb-kecepatan'];
        }
        if ($req->isDirty('ketelitian')) {
            $message['ketelitian']=$request['eb-ketelitian'];
        }
        if ($req->isDirty('sikap_kerja')) {
            $message['sikap_kerja']=$request['eb-sikap_kerja'];
        }
        if ($req->isDirty('penyelesaian_masalah')) {
            $message['penyelesaian_masalah']=$request['eb-penyelesaian_masalah'];
        }
        if ($req->isDirty('horenso')) {
            $message['horenso']=$request['eb-horenso'];
        }
        if ($req->isDirty('kerjasama')) {
            $message['kerjasama']=$request['eb-kerjasama'];
        }
        if ($req->isDirty('antusiasme')) {
            $message['antusiasme']=$request['eb-antusiasme'];
        }
        if ($req->isDirty('tanggung_jawab')) {
            $message['tanggung_jawab']=$request['eb-tanggung_jawab'];
        }

        
        

        $req->save();
        $data = [
            'record_no' => Str::uuid(),
            //'user_id' => Session::get('id'),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $message,
        ];
        LogModel::create($data);

        return array(
            'message' =>"Update data berhasil !",
            'success'=>true
        );
    }

    public function approval_bonus_umum(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $level = $user->level_user;
        $rubah = $user->user_name;
        $id = $request->input('id');
            //$req = DeptheadModel::find($id);

            $id_appraisal = $request['ab-appraisal'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
          //dd($req);
  
          
          if($level == 'Supervisor' || $level == 'Assisten Manager' || $level == 'Manager' ){
            $message['id_appraisal']= $id_appraisal;
            $message['nik']= $nik;
            $message['disetujui']= $rubah;
              $req->disetujui = $rubah;
              $req->save();
              $data = [
                  'record_no' => Str::uuid(),
                  //'user_id' => Session::get('id'),
                  'user_id' => $user->id,
                  'activity' =>"update",
                  'message' => $message,
              ];
              LogModel::create($data);
        }else{
            return array(
                'message' =>"Anda tidak berhak untuk Aprove, jangan coba - coba !",
                'success'=>false
            );
          }



        return array(
            'message' =>"Approve berhasil !",
            'success'=>true
        );
    }

    public function input_bonus_pimpinan (Request $request){
        //dd($request->all());
        $nik = $request->input("nonik");
        $periode = $request->input("periode");

        $hasil = $this->getnilai($nik, $periode);

        $dept1 = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','nama_jabatan')->where('nik','=',$nik)->first();
        //dd($dept1);
        $cek = DB::table('tb_appraisal')->select('nik', 'periode')->where('nik','=',$nik)->where('periode','=',$periode.'-01')->where('type','=','Bonus')->count();
        if ($cek > 0){
        Session::flash('alert-danger','Data sudah ada.'); 
        return redirect()->route('depthead_input_bonus');
        } elseif ($hasil['hasil'] < 1) {
            Session::flash('alert-danger', 'NIK ' .$nik.' Tidak Masuk dalam penilaian .'); 
            return redirect()->route('depthead_input_bonus');
        } else {
            $hasil = $this->getnilai($nik, $periode);
            $insert = DeptheadModel::create([
            'id_appraisal'=>Str::uuid(),
            'type'=>'Bonus',
            'periode'=>$request->periode."-01",
            'nik'=>$request->nonik,
            'nama'=>$request->nama,
            'departemen'=>$dept1->dept_group,
            'jabatan'=>$dept1->nama_jabatan,
            'keselamatan'=>$request->keselamatan,
            'kualitas'=>$request->kualitas,
            'biaya'=>$request->biaya,
            'pengiriman'=>$request->pengiriman,
            'penjualan'=>$request->penjualan,
            'kedisiplinan'=>$hasil['hasil'],
            'kerjasama'=>$request->kerjasama,
            'antusiasme'=>$request->antusiasme,
            'tanggung_jawab'=>$request->tanggung_jawab,
            'poin_kebijakan'=> 0,
            'penilai'=>Session::get('name'),
                ]);
        }


     if ($insert) {
             
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }

        return redirect()->route('depthead_input_bonus_pimpinan'); 
    }

    public function edit_bonus_leader(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req1 = DeptheadModel::find($id);

            $id_appraisal = $request['ebl-appraisal-bonus'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
            //dd($req);
            $req->keselamatan = $request['ebl-keselamatan'];
            $req->kualitas = $request['ebl-kualitas'];
            $req->biaya = $request['ebl-biaya'];

            $req->pengiriman = $request['ebl-pengiriman'];
            $req->penjualan = $request['ebl-penjualan'];

            $req->kerjasama = $request['ebl-kerjasama'];
            $req->antusiasme = $request['ebl-antusiasme'];
            $req->tanggung_jawab = $request['ebl-tanggung_jawab'];


        $message['update']= 'tb_appraisal';
        $message['id_appraisal']= $id_appraisal;
        $message['nik']= $nik;
        if ($req->isDirty('keselamatan')) {
            $message['keselamatan']=$request['ebl-keselamatan'];
        }
        if ($req->isDirty('kualitas')) {
            $message['kualitas']=$request['ebl-kualitas'];
        }
        if ($req->isDirty('biaya')) {
            $message['biaya']=$request['ebl-biaya'];
        }
        if ($req->isDirty('pengiriman')) {
            $message['pengiriman']=$request['ebl-pengiriman'];
        }
        if ($req->isDirty('penjualan')) {
            $message['penjualan']=$request['ebl-penjualan'];
        }
        if ($req->isDirty('kerjasama')) {
            $message['kerjasama']=$request['eb-kerjasama'];
        }
        if ($req->isDirty('antusiasme')) {
            $message['antusiasme']=$request['eb-antusiasme'];
        }
        if ($req->isDirty('tanggung_jawab')) {
            $message['tanggung_jawab']=$request['eb-tanggung_jawab'];
        }

        
        

        $req->save();
        $data = [
            'record_no' => Str::uuid(),
            //'user_id' => Session::get('id'),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $message,
        ];
        LogModel::create($data);

        return array(
            'message' =>"Update data berhasil !",
            'success'=>true
        );
    }

    public function approval_bonus_leader(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $level = $user->level_user;
        $rubah = $user->user_name;
        $id = $request->input('id');
            //$req = DeptheadModel::find($id);

            $id_appraisal = $request['abl-appraisal'];
            $req = DeptheadModel::find($id_appraisal);
            $nik = $req->nik;
          //dd($req);
  
          
          if($level == 'Supervisor' || $level == 'Assisten Manager' || $level == 'Manager'){
            $message['id_appraisal']= $id_appraisal;
            $message['nik']= $nik;
            $message['disetujui']= $rubah;
              $req->disetujui = $rubah;
              $req->save();
              $data = [
                  'record_no' => Str::uuid(),
                  //'user_id' => Session::get('id'),
                  'user_id' => $user->id,
                  'activity' =>"update",
                  'message' => $message,
              ];
              LogModel::create($data);
        }else{
            return array(
                'message' =>"Anda tidak berhak untuk Aprove, jangan coba - coba !",
                'success'=>false
            );
          }



        return array(
            'message' =>"Approve berhasil !",
            'success'=>true
        );
    }

    public function getgrade (Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $rubah = $user->user_name;
        $id = $request->input('id');
        //$req = DeptheadModel::find($id);

        $id_appraisal = $request['approve-appraisal-1'];
        $req = DeptheadModel::find($id_appraisal);
        $nik = $req->nik;

        $Datas = DeptheadModel::select(DB::raw('id_appraisal,periode,nik, nama, departemen, penilai, poin_kebijakan, keterangan, (dandori + kecepatan + ketelitian + improvement + sikap_kerja + Penyelesaian_masalah + horenso)as nilai1, (kedisiplinan + kerjasama + antusiasme + tanggung_jawab)as nilai4, (poin_kebijakan)as nilai5'))
        ->where('id_appraisal',$req)->get();
    }
}
