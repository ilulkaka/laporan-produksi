<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\UserModel;
use App\PermintaanModel;
use App\LogModel;
use App\jiguSelesaiModel;
use App\UpdatedenpyouModel;
use App\MasterTanegataModel;
use PDF;


class TechnicalController extends Controller
{
    public function update(){
        $tanggal = date('Y-m-d');
        //$tanggal_update = now()->format('d/m/yy H:i:s');

        $item = DB::connection('oracle')->select("select i_item_cd from t_pm_ms where I_item_cd like 'A%'");
        $namaproses = DB::table('tb_proses')->get();

        //dd($listupdate);
        return view('/technical/updatedenpyou',['tanggal'=>$tanggal,'partno'=>$item,'koujun'=>$namaproses]);
    }

    public function inqueryupdate(){
        $listupdate = DB::table('tb_update')->get();
        //dd($listupdate);

        return view('/technical/inqueryupdatedenpyou');
    }

    public function list_updatedenpyou(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        
        $Datas = DB::table('tb_update')                
        ->where('part_no','like','%'.$search.'%')
        ->orWhere('proses','like','%'.$search.'%')
        ->orwhere('jigu','like','%'.$search.'%')
        ->skip($start)
        ->take($length)
        ->get();

        
        $count = DB::table('tb_update')                
        ->where('part_no','like','%'.$search.'%')
        ->orWhere('proses','like','%'.$search.'%')
        ->orwhere('jigu','like','%'.$search.'%')
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }


    public function input(Request $request){
        $insert = UpdatedenpyouModel::create([
            'tanggal'=>$request->tanggal,
            'part_no'=>$request->i_item_cd,
            'jby'=>$request->jby,
            'proses'=>$request->proses,
            'jigu'=>$request->jigu,
            'ukuran_salah'=>$request->ukuransalah,
            'ukuran_benar'=>$request->ukuranbenar,
            'status'=>$request->status,
            'keterangan'=>$request->keterangan,
            'modified'=>$request->modified,
        ]);
        if ($insert) {
             
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }
        
        return redirect()->route('tchupdate');
    }

    public function edit ($id){
        $ud=DB::table('tb_update')->where('id_update',$id)->get();
        return view('/technical/editupdatedenpyou',['ud'=>$ud]);
    }

    /*

    public function update1(Request $request)
{
	// update data pegawai
	DB::table('tb_update')->where('id_update',$request->id)->update1([
        'tanggal'=>$request->tanggal,
        'part_no'=>$request->i_item_cd,
        'jby'=>$request->jby,
        'proses'=>$request->proses,
        'jigu'=>$request->jigu,
        'ukuran_salah'=>$request->ukuransalah,
        'ukuran_benar'=>$request->ukuranbenar,
        'status'=>$request->status,
        'keterangan'=>$request->keterangan,
        'modified'=>$request->modified
	]);
	// alihkan halaman ke halaman pegawai
    return redirect()->route('register')('/technical/inqueryupdatedenpyou');
    }
    */

    public function updatepermintaan(){
        
        return view('/technical/permintaan');
    }
    public function tampilpermintaan(){
        $oprtch = DB::connection('sqlsrv_pga')->select("select nama from t_karyawan where status_karyawan != 'Off' and dept_group = 'TECHNICAL' or dept_group like 'MEAS%'");
        //dd($oprtch);
        return view('/technical/inquerypermintaan',['oprtch'=>$oprtch]);
    }


    public function inquerypermintaan (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('dept_section')->groupBy('dept_section')->get();
    
        
        $listdept= array();

        if ($dept=='Admin' || $level == 'Manager') {
          
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION);
               
            }
        }else {
            array_push($listdept, $dept);
           
        }

        $Datas = DB::table('tb_permintaan_kerja')
        ->where('status','=','Open')->whereIn('dept',$listdept)
         ->where(function($q) use ($search) {
                $q->where('tanggal_permintaan','like','%'.$search.'%')
                ->orwhere('status','=','Tolak')
                  ->orWhere('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
         })
        ->orderBy('created_at','asc')
        ->skip($start)->take($length)->get();
        $count = DB::table('tb_permintaan_kerja')
        ->where('status','=','Open')->whereIn('dept',$listdept)
                 ->where(function($q) use ($search) {
                $q->where('tanggal_permintaan','like','%'.$search.'%')
                ->orwhere('status','=','Tolak')
                  ->orWhere('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
                 })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inquerypermintaan_tch (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $statusreq1 = $request->input("status_req1");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $dept = $user->departemen;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('dept_section')->groupBy('dept_section')->get();
        $listdept= array();
        
        if ($dept=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION); 
            }
        }else {
            array_push($listdept, $dept);
        }
        
        $status_req = DB::table('tb_permintaan_kerja')->select('status')->groupBy('status')->get();
        $liststatus= array();

        if ($statusreq1=='All') {
          
            foreach ($status_req as $key_status) {
                array_push($liststatus,$key_status->status);
            }
        }else {
            array_push($liststatus, $statusreq1);
        }
        //dd($liststatus);
        
        $Datas = DB::table('tb_permintaan_kerja')
        ->where('tanggal_permintaan','>=',$awal)
        ->where('tanggal_permintaan','<=',$akhir)
        ->whereIn('status',$liststatus)->where('dept',$listdept)
         ->where(function($q) use ($search) {
                $q->where('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
            })
        ->orderBy('created_at','asc')
        ->skip($start)->take($length)->get();
        $count = DB::table('tb_permintaan_kerja')
        ->where('tanggal_permintaan','>=',$awal)
        ->where('tanggal_permintaan','<=',$akhir)
        ->whereIn('status',$liststatus)->where('dept',$listdept)
         ->where(function($q) use ($search) {
                $q->where('no_laporan','like','%'.$search.'%')
                ->orwhere('nama_item','like','%'.$search.'%')
                ->orwhere('ukuran','like','%'.$search.'%');
            })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }


      // inquery permintaan TCH "PERMINTAAN SUDAH DITERIMA TCH"
    public function inquerypermintaan_tch_all (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $sstatus = $request->input("sstatus");

        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $dept = $user->departemen;
        $level = $user->level_user;

        $all = DB::table('tb_permintaan_kerja')->select('status')->groupBy('status')->get();
        
        $listall = array();
        if ($sstatus == "All"){
            foreach ($all as $key) {
                array_push($listall,$key->status);
            }
        }else {
            
                array_push($listall, $sstatus);
            
        } 
        //dd($listall);


        $tujuan= array();

        if ($dept == 'Admin') {
            array_push($tujuan,"QA");
            array_push($tujuan,"TCH");
        }else if(strpos($dept,'MEASUREMENT') !== FALSE){
            array_push($tujuan,"QA");
          }else{
            array_push($tujuan,"TCH");
          }

          //dd($tujuan);

        $Datas = DB::table('tb_permintaan_kerja')
        ->select('id_permintaan','tanggal_permintaan','no_laporan','dept','nama_user','permintaan','jenis_item','nama_mesin','nama_item','ukuran','satuan','qty','nouki','permintaan_perbaikan','operator_tch','material','tanggal_selesai_tch','accept_by','status as status1','qty_selesai','tanggal_selesai','qty_selesai_tch')
        ->whereIn('tujuan',$tujuan)->whereIn('status',$listall)
         ->where(function($q) use ($search) {
                $q->where('tanggal_permintaan','like','%'.$search.'%')
                
                  ->orWhere('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
            })
        ->orderBy('updated_at','Desc')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_permintaan_kerja')
        ->whereIn('tujuan',$tujuan)->whereIn('status',$listall)
         ->where(function($q) use ($search) {
                $q->where('tanggal_permintaan','like','%'.$search.'%')
                
                  ->orWhere('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
            })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    // inquery permintaan TCH "PERMINTAAN MENUNGGU PROSES"
    public function inquerypermintaan_all (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $dept = $user->departemen;
        $level = $user->level_user;

        $tujuan= array();

        if ($dept == 'Admin') {
            array_push($tujuan,"QA");
            array_push($tujuan,"TCH");
        }else if(strpos($dept,'MEASUREMENT') !== FALSE){
            array_push($tujuan,"QA");
          }else{
            array_push($tujuan,"TCH");
          }
       
        $Datas = DB::table('tb_permintaan_kerja')
        ->where('status','=','Open')->wherein('tujuan',$tujuan)
         ->where(function($q) use ($search) {
                $q->where('tanggal_permintaan','like','%'.$search.'%')
                ->orwhere('status','=','Pending')
                  ->orWhere('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
            })
        ->orderBy('created_at','asc')
        ->skip($start)->take($length)->get();
        $count = DB::table('tb_permintaan_kerja')
        ->where('status','=','Open')->wherein('tujuan',$tujuan)
         ->where(function($q) use ($search) {
                $q->where('tanggal_permintaan','like','%'.$search.'%')
                ->orwhere('status','=','Pending')
                  ->orWhere('no_laporan','like','%'.$search.'%')
                  ->orwhere('nama_item','like','%'.$search.'%')
                  ->orwhere('ukuran','like','%'.$search.'%');
            })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inputpermintaan (Request $request){
        //dd($request->all());
        
        PermintaanModel::create([
            'id_permintaan'=>Str::uuid(),
            'tanggal_permintaan'=>$request->tanggal_permintaan,
            'no_laporan'=>$request->no_laporan,
            'dept'=>Session::get('dept'),
            'nama_user'=>Session::get('name'),
            'tujuan'=>$request->tujuan,
            'permintaan'=>$request->permintaan,
            'jenis_item'=>$request->jenis_item,
            'nama_mesin'=>$request->nama_mesin,
            'nama_item'=>$request->nama_item,
            'material'=>$request->material,
            'ukuran'=>$request->ukuran,
            'qty'=>$request->qty,
            'satuan'=>$request->satuan,
            'alasan'=>$request->alasan,
            'permintaan_perbaikan'=>$request->permintaan_perbaikan,
            'tindakan_perbaikan'=>$request->tindakan_perbaikan,
            'operator_tch'=>$request->operator_tch,
            'tanggal_selesai'=>$request->tanggal_selesai,
            'material'=>$request->material,
            'accept_by'=>$request->accept_by,
            'status'=>"Open",
            'nouki'=>$request->nouki,
        ]);
        return redirect ('/technical/permintaan');
    }

    public function inputpermintaanproduksi (Request $request){
        //dd($request->all());
        $date = now();
        $nolap = $request->input('no_laporan');
        $cek = PermintaanModel::where('no_laporan',$nolap)->count();
        //dd($cek);
        if($cek > 0){
            Session::flash('alert-danger','No Laporan Sudah ada !'); 
            return redirect()->route('req_permintaan');
        } else {
            $in = PermintaanModel::create([
                'id_permintaan'=>Str::uuid(),
                'tanggal_permintaan'=>$date,
                'no_laporan'=>$request->no_laporan,
                'dept'=>Session::get('dept'),
                'nama_user'=>Session::get('name'),
                'tujuan'=>$request->tujuan,
                'permintaan'=>$request->unik,
                'jenis_item'=>$request->jenis_item,
                'nama_mesin'=>$request->nama_mesin,
                'nama_item'=>$request->nama_item,
                'material'=>$request->material,
                'ukuran'=>$request->ukuran,
                'qty'=>$request->qty,
                'satuan'=>$request->satuan,
                'alasan'=>$request->alasan,
                'permintaan_perbaikan'=>$request->permintaan_perbaikan,
                'status'=>"Open",
                'nouki'=>$request->nouki,
            ]);
        }

        if ($in) {         
            Session::flash('success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }

        return redirect()->route('req_permintaan');
    }

        public function get_nomer(Request $request){
            $nomer = DB::connection('sqlsrv')->select('exec no_technical ?,?', array($request['tanggal_permintaan'], $request['permintaan']));
     
            return $nomer;
         }

         public function update_permintaan(Request $request){
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $id = $request->input('id');
            $req = PermintaanModel::find($id);
           
            if ($dept == "Admin" || $dept == $req->dept) {
    
            $req->ukuran = $request['ukuran'];
            $req->qty = $request['qty'];
            $req->save();
    
              $status = true;
              $mess = "Update data berhasil";
            }else {
                $mess = "Update gagal";
                $status = false;
              
            }
    
            $details = [
                'id_req' => $id,
                'ukuran'=>$request['ukuran'],
                'qty' => $request['qty'],
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user->id,
                'activity' =>"update",
                //'message' => "update request ".$req->no_perbaikan.", ID : ".$id,
                'message' => $details,
            ];
            LogModel::create($data);
            return array(
                'message' => $mess,
                'success'=>$status
            );
        }

        public function update_permintaan_tch(Request $request){
            //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $id = $request->input('id');
            $req = PermintaanModel::find($id);
           
            if ($dept == "Admin" || $dept == $req->dept || strpos($dept,'TOOLING') !== FALSE || strpos($dept,'MEASUREMENT') !== FALSE ) {
    
            $req->accept_by = $user->user_name;
            $req->status = $request['status'];
            $req->material = $request['material'];
            $req->tanggal_selesai = $request['tanggal_selesai'];
            $req->operator_tch = $request['operator_tch'];
            $req->save();
    
              $status = true;
              $mess = "Update data berhasil";
              $tes = $request['status'];
            }else {
                $mess = "Update gagal, Permintaan TCH";
                $status = false;
              
            }
    
            $details = [
                'id_req' => $id,
                'accept_by'=>$request['accept_by'],
                'status' => $request['status'],
                'material' => $request['material'],
                'tanggal_selesai' => $request['tanggal_selesai'],
                'operator_tch' => $request['operator_tch'],
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user->id,
                'activity' =>"update",
                //'message' => "update request ".$req->no_perbaikan.", ID : ".$id,
                'message' => $details,
            ];
            LogModel::create($data);
            return array(
                'message' => $mess,
                'success'=>$status,
                'proses'=>$tes
            );
        }


        public function del_permintaan(Request $request){
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $id = $request->input('id');
            $req = PermintaanModel::find($id);
   
            
            if ($dept == "Admin") {
                $req->delete();
              $status = true;
              $mess = "Delete berhasil";
                //Session::flash('alert-success','Hapus Request berhasil !'); 
            }else if ($dept == $req->dept) {
               $req->delete();
               $status = true;
               $mess = "Delete berhasil";
               //Session::flash('alert-success','Hapus Request berhasil !'); 
            }else {
                $mess = "Delete gagal";
                $status = false;
                //Session::flash('alert-danger','Hapus Request gagal !');
            }
            $details = [
                'id_req' => $id,
                'no_req' => $req->no_laporan,
                'status'=>"delete",
    
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user->id,
                'activity' =>"delete",
                'message' => $details,
            ];
    
            LogModel::create($data);
    
            return array(
                'message' => $mess,
                'success'=>$status
            );
    
        }

    public function jiguselesai(Request $request){
      //dd($request->all());
    $operator_tch = $request['operator_tch'];
   // dd($operator_tch);
       $req = PermintaanModel::find($request['id']);
       $qty = $request['qty'];
       $token = apache_request_headers();
       $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

       $open = JiguSelesaiModel::where('id_permintaan','=',$request['id'])->where('status','=','open')->count();

        $hasil = '';
        for ($i =0; $i < count($operator_tch); $i++){
        if($i == count($operator_tch)-1){
            $hasil .=$operator_tch[$i];
        } else {
            $hasil .=$operator_tch[$i].', ';
        }
    }
       //dd($hasil); 

       if ($open > 0) {
        return array(
            'message' => "Update data gagal data sudah ada!",
            'success'=>false,
        );
       }

       if ($request['status'] == 'Pending') {
          $req->status = 'Pending';
          $req->save();

          $details = [
            'id_permintaan' => $request['id'],
           
            'status'=>"Pending",

        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $details,
        ];

        LogModel::create($data);
           return array(
            'message' => "Update data berhasil !",
            'success'=>true,
        );
       }else{

           /*if ($req->qty - $qty < 0) {
                return array(
                    'message' => "Update gagal ! Qty salah !",
                    'success'=>false,
                );
           }else{
            if ($req->qty - $qty == 0 ) {
                
            }else {
                $stat = "Open";
            }
        }*/
        $stat = "Close";
            
            $qty_selesai = $req->qty_selesai;
            $id_selesai = Str::uuid();
            $selesai = jiguSelesaiModel::create([
                "id_jigu_selesai" => $id_selesai,
                    "id_permintaan" => $request['id'],
                    "tgl_selesai" => $request['tanggal_selesai'],
                    "qty_selesai" => $qty,
                    'operator_tch' => $hasil,
                    "status"=> "open",
                ]);
                
                if ($selesai) {
                    
                    $req->material = $request['material'];
                    $req->operator_tch = $hasil;
                    $req->tindakan_perbaikan = $request['tindakan_perbaikan'];
                    $req->tanggal_selesai_tch = $request['tanggal_selesai'];
                    $req->qty_selesai_tch = $request['qty'];
                    
                    if ($req->status = $request['status'] == 'Close'){
                        $req->status = 'Waiting User';
                    } else {
                        $req->status = $request['status'];
                    }
                    $req->save();
                    
                    $details = [
                        'id_jigu_selesai' => $id_selesai,
                        'id_permintaan' => $request['id'],
                        'status'=>"open",
                        
                    ];
                    $data = [
                        'record_no' => Str::uuid(),
                        'user_id' => $user->id,
                        'activity' =>"create",
                        'message' => $details,
                    ];
                    
                    LogModel::create($data);
                    return array(
                        'message' => "Update data berhasil !",
                        'success'=>true,
                    );
                }else{
                    return array(
                        'message' => "Update data gagal !",
                        'success'=>false,
                    );
                }
       }


      
    }

    public function getselesai(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $level = $user->level_user;

        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('dept_section')->groupBy('dept_section')->get();
       
        $listdept= array();

        if ($dept=='Admin' || $level == 'Manager') {
          
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION);
               
            }
        }else {
            array_push($listdept, $dept);
           
        }
       
        //TODO: tampilkan qty selesai
        $Datas = DB::table('tb_jigu_selesai as a')
        ->join('tb_permintaan_kerja as b','a.id_permintaan','=','b.id_permintaan')
        ->select('b.*','a.id_jigu_selesai','a.tgl_selesai as tanggal', 'a.qty_selesai as jumlah')
        ->where('a.status','=','open')
        ->whereIn('b.dept', $listdept)
         ->where(function($q) use ($search) {
                $q->where('b.nama_mesin','like','%'.$search.'%')
                  ->orWhere('b.no_laporan','like','%'.$search.'%')
                  ->orwhere('b.nama_item','like','%'.$search.'%');
            })
        ->orderBy('a.created_at','asc')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_jigu_selesai')
        ->join('tb_permintaan_kerja','tb_jigu_selesai.id_permintaan','=','tb_permintaan_kerja.id_permintaan')
        ->where('tb_jigu_selesai.status','=','open')
        ->whereIn('tb_permintaan_kerja.dept', $listdept)
         ->where(function($q) use ($search) {
                $q->where('tb_permintaan_kerja.nama_mesin','like','%'.$search.'%')
                  ->orWhere('tb_permintaan_kerja.no_laporan','like','%'.$search.'%')
                  ->orwhere('tb_permintaan_kerja.nama_item','like','%'.$search.'%');
            })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }


    public function cetak_permintaan_tch($id){
        //$token = apache_request_headers();
        //$user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
       // $dept = $user->departemen;
       // $id = $request->input('id');
        $req = PermintaanModel::find($id);
        //dd($req);
       // if ($dept == $req->dept) {
           // $req->data = $request['id_permintaan'];
       // $list = DB::table('tb_permintaan_kerja');
        $pdf = PDF::loadview('/technical/permintaan_pdf',['list'=>$req])->setPaper('A4','potrait');
        return $pdf->stream('List Permintaan.pdf');
        //return $pdf->download('permintaan-pdf');
       // }
    }

    public function edit_update_denpyou(Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $id = $request->input('id');
        $req = UpdatedenpyouModel::find($id);
       
        if ($dept == "Admin" || strpos($dept,'TOOLING') !== FALSE) {

        $req->ukuran_salah = $request['ukuran_salah'];
        $req->ukuran_benar = $request['ukuran_benar'];
        $req->status = $request['status'];
        $req->save();

          $status = true;
          $mess = "Update data berhasil";
        }else {
            $mess = "Update gagal";
            $status = false;
          
        }

        $details = [
            'id_update' => $id,
            'ukuran_salah'=>$request['ukuran_salah'],
            'ukuran_benar' => $request['ukuran_benar'],
            'status' => $request['status'],
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"update",
            //'message' => "update request ".$req->no_perbaikan.", ID : ".$id,
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => $mess,
            'success'=>$status
        );
    }

    public function terimajigu(Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $id_selesai = $request["id"];
        $qty_selesai = $request["qty"];

        $selesai = jiguSelesaiModel::find($id_selesai);
       
        if ($selesai->status == "close") {
            return array(
                'message' => "ID salah !",
                'success'=>false
            );
        }

        if ($qty_selesai > $selesai->qty_selesai) {
            return array(
                'message' => "Qty salah !",
                'success'=>false
            );
        }
        $permintaan = PermintaanModel::find($selesai->id_permintaan);
       // dd($permintaan);
        if ($user->departemen != $permintaan->dept) {
            return array(
                'message' => "Akses ditolak !",
                'success'=>false
            );
        }
        $selesai->qty_selesai = $qty_selesai;
        $selesai->qty_ok =  $qty_selesai;
        $selesai->penerima = $user->user_name;
        $selesai->tgl_terima = Carbon::now();
        $selesai->status = "close";
        $selesai->save();


        $permintaan->qty_selesai = $qty_selesai;
        $permintaan->status = "Close";
         $permintaan->tanggal_selesai = Carbon::now();
        $permintaan->save();
        $statper = "Close";

        /*if($permintaan->qty == ($permintaan->qty_selesai + $qty_selesai)) {
           $permintaan->qty_selesai = $permintaan->qty_selesai + $qty_selesai;
           $permintaan->status = "Close";
            $permintaan->tanggal_selesai = Carbon::now();
           $permintaan->save();
           $statper = "Close";
        }else{
            $statper = $permintaan->status;
            $permintaan->qty_selesai = $permintaan->qty_selesai + $qty_selesai;
            $permintaan->save();
        }*/

        $details = [
            'id_selesai' => $id_selesai,
            'qty_ok'=>$qty_selesai,
            'status' => "close",
            'id_permintaan'=>$selesai->id_permintaan,
            'status_permintaan'=>$statper,
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => 'Simpan Data berhasil',
            'success'=>true
        );


    }

    public function listselesai(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $level = $user->level_user;

        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('dept_section')->groupBy('dept_section')->get();
       
        $listdept= array();

        if ($dept=='Admin' || $level == 'Manager') {
          
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION);
               
            }
        }else {
            array_push($listdept, $dept);
           
        }
       
        
        $Datas = DB::table('tb_jigu_selesai')
        ->join('tb_permintaan_kerja','tb_jigu_selesai.id_permintaan','=','tb_permintaan_kerja.id_permintaan')
        ->where('tb_jigu_selesai.status','=','close')
        ->where('tb_jigu_selesai.tgl_selesai','>=',$awal)
        ->where('tb_jigu_selesai.tgl_selesai','<=',$akhir)
        ->whereIn('tb_permintaan_kerja.dept', $listdept)
         ->where(function($q) use ($search) {
                $q->where('tb_permintaan_kerja.nama_mesin','like','%'.$search.'%')
                  ->orWhere('tb_permintaan_kerja.no_laporan','like','%'.$search.'%')
                  ->orwhere('tb_permintaan_kerja.nama_item','like','%'.$search.'%');
            })
        ->orderBy('tb_jigu_selesai.created_at','asc')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_jigu_selesai')
        ->join('tb_permintaan_kerja','tb_jigu_selesai.id_permintaan','=','tb_permintaan_kerja.id_permintaan')
        ->where('tb_jigu_selesai.status','=','close')
        ->where('tb_jigu_selesai.tgl_selesai','>=',$awal)
        ->where('tb_jigu_selesai.tgl_selesai','<=',$akhir)
        ->whereIn('tb_permintaan_kerja.dept', $listdept)
         ->where(function($q) use ($search) {
                $q->where('tb_permintaan_kerja.nama_mesin','like','%'.$search.'%')
                  ->orWhere('tb_permintaan_kerja.no_laporan','like','%'.$search.'%')
                  ->orwhere('tb_permintaan_kerja.nama_item','like','%'.$search.'%');
            })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function importexcel(Request $request){
        if ($request->hasFile('import_file')) {
           $path = $request->file('import_file')->getRealPath();
           $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
           $Data = $reader->load($path);
           $sheetdata = $Data->getActiveSheet()->toArray(null, true, true, true);
            unset($sheetdata[1]);
          
           foreach ($sheetdata as $row) {
           
             
               UpdatedenpyouModel::create([
                'tanggal'=>$row['A'],
                'part_no'=>$row['B'],
                'jby'=>$row['C'],
                'proses'=>$row['D'],
                'jigu'=>$row['E'],
                'ukuran_salah'=>$row['F'],
                'ukuran_benar'=>$row['G'],
                'status'=>$row['H'],
                'keterangan'=>$row['I'],
               
            ]);
        }

        Session::flash('alert-success','Import data berhasil'); 
        return redirect()->route('tools');
        }
    }
    

    public function updatexlsx(Request $request){

        $Datas = DB::table('tb_update')->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Tanggal');
        $sheet->setCellValue('C1','Part No');
        $sheet->setCellValue('D1','Jby');
        $sheet->setCellValue('E1','Proses');
        $sheet->setCellValue('F1','Jigu');
        $sheet->setCellValue('G1','Ukuran Salah');
        $sheet->setCellValue('H1','Ukuran Benar');
        $sheet->setCellValue('I1','Status');
        $sheet->setCellValue('J1','Keterangan');
        $sheet->setCellValue('K1','Created At');
        $sheet->setCellValue('L1','Updatetd At');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->tanggal);
            $sheet->setCellValue('C'.$line,$data->part_no);
            $sheet->setCellValue('D'.$line,$data->jby);
            $sheet->setCellValue('E'.$line,$data->proses);
            $sheet->setCellValue('F'.$line,$data->jigu);
            $sheet->setCellValue('G'.$line,$data->ukuran_salah);
            $sheet->setCellValue('H'.$line,$data->ukuran_benar);
            $sheet->setCellValue('I'.$line,$data->status);
            $sheet->setCellValue('J'.$line,$data->keterangan);
            $sheet->setCellValue('K'.$line,$data->created_at);
            $sheet->setCellValue('L'.$line,$data->updated_at);
           
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "UpdateDenpyou_".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
       
    }

    public function excelterima(Request $request){ //export excel daftar penerimaan jigu
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('dept_section')->groupBy('dept_section')->get();
       
        $listdept= array();

        if ($user->departemen =='Admin' || $user->level_user == 'Manager') {
          
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION);
               
            }
        }else {
            array_push($listdept, $user->departemen);
           
        }

        $Datas = DB::table('tb_jigu_selesai as a')
        ->join('tb_permintaan_kerja as b','a.id_permintaan','=','b.id_permintaan')
        ->select('b.*','a.id_jigu_selesai','a.tgl_selesai as tanggal', 'a.qty_selesai as jumlah','a.penerima','a.tgl_terima','a.qty_ok', 'a.created_at as create', 'a.updated_at as updated')
        ->where('a.status','=','close')
        ->whereIn('b.dept', $listdept)
        ->where('a.tgl_selesai','>=',$awal)
        ->where('a.tgl_selesai','<=',$akhir)
        ->orderBy('a.created_at','asc')
       ->get();

        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Tanggal Selesai');
        $sheet->setCellValue('C1','No. Laporan');
        $sheet->setCellValue('D1','Departemen');
        $sheet->setCellValue('E1','User');
        $sheet->setCellValue('F1','Permintaan');
        $sheet->setCellValue('G1','Jenis Item');
        $sheet->setCellValue('H1','Nama Mesin');
        $sheet->setCellValue('I1','Nama Item');
        $sheet->setCellValue('J1','Ukuran');
        $sheet->setCellValue('K1','Qty OK');
        $sheet->setCellValue('L1','Satuan');
        $sheet->setCellValue('M1','Penerima');
        $sheet->setCellValue('N1','Permintaan Perbaikan');
        $sheet->setCellValue('O1','Operator TCH');
        $sheet->setCellValue('P1','Created At');
        $sheet->setCellValue('Q1','Updated At');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->tanggal);
            $sheet->setCellValue('C'.$line,$data->no_laporan);
            $sheet->setCellValue('D'.$line,$data->dept);
            $sheet->setCellValue('E'.$line,$data->nama_user);
            $sheet->setCellValue('F'.$line,$data->permintaan);
            $sheet->setCellValue('G'.$line,$data->jenis_item);
            $sheet->setCellValue('H'.$line,$data->nama_mesin);
            $sheet->setCellValue('I'.$line,$data->nama_item);
            $sheet->setCellValue('J'.$line,$data->ukuran);
            $sheet->setCellValue('K'.$line,$data->qty_ok);
            $sheet->setCellValue('L'.$line,$data->satuan);
            $sheet->setCellValue('M'.$line,$data->penerima);
            $sheet->setCellValue('N'.$line,$data->permintaan_perbaikan);
            $sheet->setCellValue('O'.$line,$data->operator_tch);
            $sheet->setCellValue('P'.$line,$data->create);
            $sheet->setCellValue('Q'.$line,$data->updated);
           
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "ListJigu_".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
    }

    public function excel_permintaan(Request $request){ //export excel daftar permintaan jigu
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('dept_section')->groupBy('dept_section')->get();
       
        $listdept= array();

        if ($user->departemen =='Admin' || $user->level_user == 'Manager') {
          
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION);
               
            }
        }else {
            array_push($listdept, $user->departemen);
           
        }

        $Datas = DB::table('tb_permintaan_kerja')
        ->whereIn('dept', $listdept)
        ->where('tanggal_permintaan','>=',$awal)
        ->where('tanggal_permintaan','<=',$akhir)
        ->orderBy('tanggal_permintaan','asc')
       ->get();

        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Tanggal Permintaan');
        $sheet->setCellValue('C1','No. Laporan');
        $sheet->setCellValue('D1','Departemen');
        $sheet->setCellValue('E1','User');
        $sheet->setCellValue('F1','Tujuan');
        $sheet->setCellValue('G1','Permintaan');
        $sheet->setCellValue('H1','Jenis Item');
        $sheet->setCellValue('I1','Nama Mesin');
        $sheet->setCellValue('J1','Nama Item');
        $sheet->setCellValue('K1','Ukuran');
        $sheet->setCellValue('L1','Qty');
        $sheet->setCellValue('M1','Satuan');
        $sheet->setCellValue('N1','Alasan');
        $sheet->setCellValue('O1','Permintaan Perbaikan');
        $sheet->setCellValue('P1','Accept By');
        $sheet->setCellValue('Q1','Status');
        $sheet->setCellValue('R1','Tanggal Selesai');
        $sheet->setCellValue('S1','Qty Selesai');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->tanggal_permintaan);
            $sheet->setCellValue('C'.$line,$data->no_laporan);
            $sheet->setCellValue('D'.$line,$data->dept);
            $sheet->setCellValue('E'.$line,$data->nama_user);
            $sheet->setCellValue('F'.$line,$data->tujuan);
            $sheet->setCellValue('G'.$line,$data->permintaan);
            $sheet->setCellValue('H'.$line,$data->jenis_item);
            $sheet->setCellValue('I'.$line,$data->nama_mesin);
            $sheet->setCellValue('J'.$line,$data->nama_item);
            $sheet->setCellValue('K'.$line,$data->ukuran);
            $sheet->setCellValue('L'.$line,$data->qty);
            $sheet->setCellValue('M'.$line,$data->satuan);
            $sheet->setCellValue('N'.$line,$data->alasan);
            $sheet->setCellValue('O'.$line,$data->permintaan_perbaikan);
            $sheet->setCellValue('P'.$line,$data->accept_by);
            $sheet->setCellValue('Q'.$line,$data->status);
            $sheet->setCellValue('R'.$line,$data->tanggal_selesai);
            $sheet->setCellValue('S'.$line,$data->qty_selesai);
           
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "ListPermintaan_".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
    }

    public function list_master (){
        return view('/technical/list_tanegata');
    }

    public function list_master_tanegata (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $status_master = $request->input("status_master");
    
    
        $Datas = DB::table('tb_master_tanegata')->select('kode_tane','no_rak','ut_d','ut_b','ut_t','ut_dp','jml_omogata','dl','ds','il','is','b','t','nprh','kupingan','remark','tgl_cek') 
        ->where(function($q) use ($search) {
          $q->where('no_rak','like','%'.$search.'%');
        })
        ->orderBy('no_rak', 'asc')
        ->skip($start)->take($length)
        ->get();
    
        $count = DB::table('tb_master_tanegata')->select('kode_tane','no_rak','ut_d','ut_b','ut_t','ut_dp','jml_omogata','dl','ds','il','is','b','t','nprh','kupingan','remark','tgl_cek') 
        ->where(function($q) use ($search) {
          $q->where('no_rak','like','%'.$search.'%');
        })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function save_add_master (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $uname = $user->departemen;
        $id = Str::uuid();
        $rak = $request->input('no_rak');
        //dd($rak);

        $cek = DB::table('tb_master_tanegata')->select('no_rak')->where('no_rak',$rak)->count();
        //dd($cek);

        if ($cek > 0){
            $status = false;
            $mess = 'No Rak sudah ada .';
        } elseif ($uname == 'Admin' || $uname == 'TOOLINGS & KAIZEN'){
            MasterTanegataModel::create([
                    "id_master_tanegata"=>$id,
                    "no_rak"=>$request->input('no_rak'),
                    "kode_tane"=>$request->input('kode_tane'),
                    "ut_d"=>$request->input('ut_d'),
                    "ut_b"=>$request->input('ut_b'),
                    "ut_t"=>$request->input('ut_t'),
                    "ut_dp"=>$request->input('ut_dp'),
                    "jml_omogata"=>$request->input('jml_omogata'),
                    "dl"=>$request->input('dl'),
                    "ds"=>$request->input('ds'),
                    "il"=>$request->input('il'),
                    "is"=>$request->input('is'),
                    "b"=>$request->input('b'),
                    "t"=>$request->input('t'),
                    "nprh"=>$request->input('nprh'),
                    "kupingan"=>$request->input('kupingan'),
                    "tgl_cek"=>$request->input('tgl_cek'),
                    "remark"=>$request->input('keterangan'),
                    "inputor"=>$user->user_name,
               ]);

               $status = true;
               $mess = 'Add Master success .';
        } else {
            $status = false;
            $mess = 'Gagal Input Master .';
        }

        return array(
            'message' => $mess,
            'success'=>$status
        );
    }

    public function save_edit_master (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        $uname = $user->user_name;
        
        $req = MasterTanegataModel::find($request['e-no_rak']);
        //dd($req->no_rak);


        if ($dept == 'Admin' || $uname == 'Fuad'){
            $req->kode_tane = $request['e-kode_tane'];
            $req->ut_d = $request['e-ut_d'];
            $req->ut_b = $request['e-ut_b'];
            $req->ut_t = $request['e-ut_t'];
            $req->ut_dp = $request['e-ut_dp'];
            $req->jml_omogata = $request['e-jml_omogata'];
            $req->dl = $request['e-dl'];
            $req->ds = $request['e-ds'];
            $req->il = $request['e-il'];
            $req->is = $request['e-is'];
            $req->b = $request['e-b'];
            $req->t = $request['e-t'];
            $req->nprh = $request['e-nprh'];
            $req->kupingan = $request['e-kupingan'];
            $req->tgl_cek = $request['e-tgl_cek'];
            $req->remark = $request['e-keterangan'];

            $req->save();

            $status = true;
            $mess = "Update data berhasil .";
        } else {
            $status = false;
            $mess = "Update data gagal .";
        }

        return array(
            'message' => $mess,
            'success'=>$status
        );

    }
}
