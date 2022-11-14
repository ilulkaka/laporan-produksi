<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\NoindukModel;
use App\UserModel;
use App\JiguModel;
use App\LogModel;
use App\RiwayatJiguModel;
use App\PermintaanModel;
use App\RequestjigumanualModel;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class JiguController extends Controller
{
    public function menujigu (){
        return view ('/produksi/menurequestjigu');
    }

    public function qamenu (){
        return view ('/qa/qamenu');
    }

    public function requestjigu(){
        $mesin = DB::connection('sqlsrv')->select("select nama_mesin, nama_jigu from tb_master_jigu group by nama_mesin, nama_jigu");
        
        return view ('/jigu/requestjigu',['mesin'=>$mesin]);
    }

    public function qajigu(){
        return view ('/qa/qajigu');
    }

    public function daichouprint(){
        $nomerinduk = DB::connection('sqlsrv_pga')->select("select count(nik)as nik from t_karyawan order by nik ");
        $nama = DB::connection('sqlsrv_pga')->select("select nama from t_karyawan ");
        //dd($nama);
        //$nomerinduk = DB::connection('sqlsrv_pga')->select("select nik from t_karyawan order by nik offset 0 rows FETCH NEXT 10 ROWS ONLY ");
        //dd($nomerinduk);
     /*   $kol1 = JiguModel::select('nama_mesin')->offset(0)->limit(2)->get();
        $kol2 = JiguModel::select('nama_mesin')->offset(2)->limit(2)->get();
        //dd($kol1);
        $item1 = [];
        $item2 = [];

        $allitem = [];

        $i = 1;
        foreach ($kol1 as $k1){
            array_push($item1, ['num_1'=>$i, 'desc1'=>$k1
            ]);
            $i++;
        }

        foreach ($kol2 as $k2){
            array_push($item2, [
                'num_2'=>$i, 'desc2'=>$k2
            ]);
            $i++;
        }

        $allitem = [$item1, $item2]; */
        //dd($allitem);
        //$pdf = PDF::loadview('/qa/daichouprint',['nomerinduk'=>$nomerinduk])->setPaper('A4');
        //return $pdf->stream('Form Request Jigu.pdf');
        return view ('/qa/daichouprint',['nomerinduk'=>$nomerinduk, 'nama'=>$nama]);
    }
    
    public function formnomerinduk (){
        $icl = DB::connection('sqlsrv_pass')->select("select icl_no, item_code, item from tb_incoming where item_code like 'JI%' group by icl_no, item_code, item");
        $mesin = DB::connection('sqlsrv')->select("select nama_mesin, nama_jigu from tb_master_jigu group by nama_mesin, nama_jigu");
        //dd($mesin->nama_jigu);
        return view ('/jigu/formnomerinduk',['icl'=>$icl,'mesin'=>$mesin]);
    }

    public function v_listdaichou (){
        $loc = DB::connection('sqlsrv')->table('tb_jigu')->select('lokasi')->get();
        return view ('/qa/daichoulist',['loc'=>$loc]);
    }

    public function tambahnomerinduk (Request $request){
        //dd($request->all());
        $id = Str::uuid();
        $noinduk = $request->input('no_induk_jigu');
        $cek = DB::table('tb_nomerinduk_jigu')->where('no_induk_jigu','=',$noinduk)->count();
        //dd($count);
        if ($cek > 0){
            Session::flash('alert-danger','Registration Number already exist !'); 
            return redirect()->route('formnomerinduk');
        } else {
            $insert = NoindukModel::create([
                'id_noinduk_jigu'=>$id,
                'tgl_datang'=>$request->tgl_datang,
                'no_induk_jigu'=>$request->no_induk_jigu,
                'nama_mesin'=>$request->nama_mesin,
                'nama_jigu'=>$request->nama_jigu,
                'kigou'=>$request->kigou,
                'ukuran'=>$request->ukuran,
                'qty'=>$request->qty,
                'no_icl'=>$request->icl_no_1,
                'item_cd'=>$request->item_cd,
                'status'=>'Stock',
                'lokasi'=>$request->location,
                'kode_gambar'=>$request->no_gambar
            ]);
        }

        if($insert){
            Session::flash('alert-success','Add data is successful !'); 
        }else{
            Session::flash('alert-danger','Add data failed !'); 
        }

        return redirect()->route('formnomerinduk');
    }

    public function get_nomer (Request $request){
        $nomer = DB::connection('sqlsrv')->select('exec no_induk_jigu ?', array($request['tgl']));
        return $nomer;
    }


    // Inquery Produksi
    public function inquerynoinduk (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
       /* $status1 = $request->input("status_order");
        //dd($status1);
        $datajigu = DB::table('tb_nomerinduk_jigu')->get();
        $listdatajigu= array();
        if ($status1 == "All") {
            foreach ($datajigu as $key) {
                array_push($listdatajigu,$key->status);
            }
        }else {
            foreach ($datajigu as $key) {
                array_push($listdatajigu, $status1);
            }
        }*/
       
        $Datas = DB::table('tb_nomerinduk_jigu')->where('status','!=','Out')->where('status','!=','CheckOut')
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%') 
              ->orwhere('no_induk_jigu','like','%'.$search.'%');
        })
        ->orderBy('created_at', 'desc')    
        ->skip($start)
        ->take($length)
        ->get();


        $count = DB::table('tb_nomerinduk_jigu')->where('status','!=','Out')->where('status','!=','CheckOut')
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('no_induk_jigu','like','%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    // Controller Inquery Warehouse
    public function inquerynoinduk_warehouse (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $status1 = $request->input("status_order");
        //dd($status1);
        $datajigu = DB::table('tb_nomerinduk_jigu')->get();
        $listdatajigu= array();
        if ($status1 == "All") {
            foreach ($datajigu as $key) {
                array_push($listdatajigu,$key->status);
            }
        }else {
            foreach ($datajigu as $key) {
                array_push($listdatajigu, $status1);
            }
        }
        //dd($listdatajigu,$status1);
       
        $Datas = DB::table('tb_nomerinduk_jigu')->whereIn('status',$listdatajigu)     
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('no_induk_jigu','like','%'.$search.'%');
        })
        ->orderBy('created_at', 'desc')    
        ->skip($start)
        ->take($length)
        ->get();


        $count = DB::table('tb_nomerinduk_jigu')->whereIn('status',$listdatajigu)
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('no_induk_jigu','like','%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    // Inquery QA
    public function inqueryjigu (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $status1 = $request->input("status_order");
        //dd($status1);
        $datajigu = DB::table('tb_jigu')->get();
        $listdatajigu= array();
        if ($status1 == "All") {
            foreach ($datajigu as $key) {
                array_push($listdatajigu,$key->status);
            }
        }else {
            foreach ($datajigu as $key) {
                array_push($listdatajigu, $status1);
            }
        }
        //dd($listdatajigu,$status1);
       
        $Datas = DB::table('tb_jigu')->whereIn('status',$listdatajigu)
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('no_induk','like','%'.$search.'%');
        })
        ->orderBy('created_at', 'desc')    
        ->skip($start)
        ->take($length)
        ->get();


        $count = DB::table('tb_jigu')->whereIn('status',$listdatajigu)
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('no_induk','like','%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inqueryorder (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $status1 = $request->input("ostatus");
        //dd($status1);
        $datajigu = DB::table('tb_requestjigu_manual')->get();

        $listdatajigu= array();
        if ($status1 == "All") {
            foreach ($datajigu as $key) {
                array_push($listdatajigu,$key->status);
            }
        }else {
            foreach ($datajigu as $key) {
                array_push($listdatajigu, $status1);
            }
        }
        //dd($listdatajigu,$status1);
       
        $Datas = DB::table('tb_requestjigu_manual')->whereIn('status',$listdatajigu)
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('user','like','%'.$search.'%');
        })
        ->orderBy('created_at', 'desc')    
        ->skip($start)
        ->take($length)
        ->get();


        $count = DB::table('tb_requestjigu_manual')->whereIn('status',$listdatajigu)
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
            ->orWhere('nama_jigu','like','%'.$search.'%')
              ->orWhere('kigou','like','%'.$search.'%')
              ->orWhere('ukuran','like','%'.$search.'%')
              ->orwhere('user','like','%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function process (Request $request){
//dd($request->all());
    $now = date('Y-m-d');
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $id = $request->input('id');
    $nomorinduk = NoindukModel::find($id);

    //dd($user->departemen);
    //dd($nomorinduk->id_noinduk_jigu);

    if ($nomorinduk->status == 'Stock') {
        $id_no = Str::uuid();
        $insert = JiguModel::create([
            'id_jigu'=>$id_no,
            'id_noinduk_jigu'=>$nomorinduk->id_noinduk_jigu,
            'tgl_permintaan'=>$now,
            'nama_mesin'=>$nomorinduk->nama_mesin,
            'nama_jigu'=>$nomorinduk->nama_jigu,
            'ukuran'=>$nomorinduk->ukuran,
            'kigou'=>$nomorinduk->kigou,
            'no_induk'=>$nomorinduk->no_induk_jigu,
            'qty'=>$nomorinduk->qty,
            'jenis_permintaan'=>$request->type,
            'alasan'=>$request->reason,
            'operator_produksi'=>$request->user,
            'no_induk_lama'=>$request->old,
            'pimpinan_produksi'=>$user->user_name,
            'departemen'=>$user->departemen,
            'kode_gambar'=>$nomorinduk->no_gambar
        ]);
        if ($insert) {
            $nomorinduk->status = 'Ordered';
            $nomorinduk->save();
        }

        $details = [
            'id_noinduk_jigu' => $id_no,
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"create",
            
            'message' => $details,
        ];
        LogModel::create($data);
        Session::flash('alert-success','Tambah Data berhasil !');
        $status = true;
        $mess = 'Tambah Data berhasil !';
        }else{
        Session::flash('alert-danger','Tambah Data Gagal !'); 
        $status = false;
        $mess = 'Tambah Data Gagal !';
        }
 
        return array(
        'message' => $mess,
        'success'=>$status
            ); 
    }

    public function permintaanpdf($id){
        $list = NoindukModel::find($id);
        //$detail = JiguModel::find($list->id_noinduk_jigu);
        //dd($list->lokasi);
        $listjigu = DB::table('tb_jigu')->where('id_noinduk_jigu',$id)->get();
        //$png = qrCode::format('png')->size(512)->generate(1);
        //$png = base64_encode($png);
//dd($idinduk->tgl_permintaan);
        //$pdf = PDF::loadview('/jigu/formjigupdf',['list'=>$list, 'listjigu'=>$listjigu, 'png'=>$png])->setPaper('A4');
        //return $pdf->stream('Form Request Jigu.pdf');

        return view ('/jigu/formjigupdf',['listjigu'=>$listjigu,'list'=>$list]);
    }

    public function checkout (Request $request){
        //dd($request->all());
            $now = date('Y-m-d');
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $id = $request->input('id');
            $nomorinduk = NoindukModel::find($id);
            $req = $request->input('status');
            //dd($req);
            //dd($statusjigu->status);
            //dd($nomorinduk->id_noinduk_jigu);
        
            if ($nomorinduk->status == 'Ordered') {
                    $ins = DB::table('tb_jigu')->where('id_noinduk_jigu',$id)->update(['status'=>$req]);
                    if ($ins) {
                        $nomorinduk->status = 'CheckOut';
                        $nomorinduk->save();
                      }
                 
                 $details = [
                     'id_noinduk_jigu' => $nomorinduk,
                 ];
                 $data = [
                     'record_no' => Str::uuid(),
                     'user_id' => $user->id,
                     'activity' =>"create",
                    
                     'message' => $details,
                 ];
                    LogModel::create($data);
                    Session::flash('alert-success','Tambah Data berhasil !');
                    $status = true;
                    $mess = 'Tambah Data berhasil !';
                    }else{
                    Session::flash('alert-danger','Tambah Data Gagal !'); 
                    $status = false;
                    $mess = 'Tambah Data Gagal !';
                    }
             
                return array(
                 'message' => $mess,
                 'success'=>$status
                    ); 
                }

    public function qaprocess (Request $request){
        //dd($request->all());
        //$r = $request->input('lokasi');
        $noid = Str::uuid();
        $now = date('Y-m-d');
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $id = $request->input('id');
        $nomorinduk = JiguModel::find($id);

        $exist = JiguModel::select('id_jigu')->where('no_induk',$nomorinduk->no_induk_lama)->first();

        if(!empty($exist->id_jigu)){
            $c = JiguModel::where('no_induk',$nomorinduk->no_induk_lama)->first();
        } else {
            $c = "";
        }

    //dd($c);
        if ($request['lokasi'] != null){
            $nomorinduk->lokasi = $request['lokasi'];
            //$nomorinduk->tindakan_perbaikan = $request['type'];
            $nomorinduk->tgl_masuk_produksi = $now;
            $nomorinduk->status = "In";
            $nomorinduk->save();


                if(!empty($c)){
                    $c->tindakan_perbaikan = $request['type'];
                    $c->tgl_keluar_produksi = $now;
                    $c->status = "Out";
                    $c->keterangan = $request['reason'];
                    $c->save();

                   /* $rep = RiwayatJiguModel::create([
                        'id_riwayat'=>$noid,
                        'no_induk'=>$c->no_induk,
                        'nama_mesin'=>$c->nama_mesin,
                        'nama_jigu'=>$c->nama_jigu,
                        'kigou'=>$c->kigou,
                        'ukuran'=>$c->ukuran,
                        'alasan'=>$request['reason'],
                        'tgl_masuk_produksi'=>$c->tgl_masuk_produksi,
                        'tgl_keluar_produksi'=>$c->tgl_keluar_produksi,
                        'status'=>$request['type']
                ]); */
                
                } else {
                    $c = "data tidak ada";
                }
        
    
        $details = [
                    'id_jigu' => $nomorinduk->id_jigu,
                    ];
                 $data = [
                     'record_no' => Str::uuid(),
                     'user_id' => $user->id,
                     'activity' =>"create",
                    
                     'message' => $details,
                 ];
                    LogModel::create($data);
                    Session::flash('alert-success','Tambah Data berhasil !');
                    $status = true;
                    $mess = 'Tambah Data berhasil !';
                    }else{
                    Session::flash('alert-danger','Failed Create Data !'); 
                    $status = false;
                    $mess = 'Please Insert Location !';
                    }
             
                return array(
                 'message' => $mess,
                 'success'=>$status
                    ); 
    }

    public function getlokasi (Request $request){
        //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $id = $request->input('id');
    $nomorinduk = JiguModel::find($id);

    //dd($nomorinduk->no_induk_lama);
    $exist = JiguModel::select('id_jigu','lokasi')->where('no_induk',$nomorinduk->no_induk_lama)->first();
    //dd($exist->lokasi);
    if (!empty($exist->lokasi)) {
        $m = $exist->lokasi;
    } else { 
        $m = "";
    } 
    
        return array(
        'm'=>$m
            ); 
    }

    public function qarepair (Request $request){
        //dd($request->all());
        
        $now = date('Y-m-d');
        $noid = Str::uuid();
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $id = $request->input('id');
        $nomorinduk = JiguModel::find($id);
        //dd($user->departemen);
            if($nomorinduk->tindakan_perbaikan == 'Repair'){
                $ins = RiwayatJiguModel::create([
                    'id_riwayat'=>$noid,
                    'no_induk'=>$nomorinduk->no_induk,
                    'nama_mesin'=>$nomorinduk->nama_mesin,
                    'nama_jigu'=>$nomorinduk->nama_jigu,
                    'kigou'=>$nomorinduk->kigou,
                    'ukuran'=>$nomorinduk->ukuran,
                    'kigou_after'=>$request['kigou_after'],
                    'ukuran_after'=>$request['ukuran_after'],
                    'alasan'=>$request['reason'],
                    //'tgl_masuk_produksi'=>$nomorinduk->tgl_masuk_produksi,
                    'status'=>'Repair'
                ]);

                    if($ins){
                        $nomorinduk->status = 'Process Repair';
                        $nomorinduk->ukuran_after = $request['ukuran_after'];
                        $nomorinduk->kigou_after = $request['kigou_after'];
                        $nomorinduk->save();
                    }

                $ins_tch = PermintaanModel::create([
                    'id_permintaan'=>Str::uuid(),
                    'tanggal_permintaan'=>$now,
                    'no_laporan'=>$request['no_laporan'],
                    'dept'=>$user->departemen,
                    'nama_user'=>$user->user_name,
                    'tujuan'=>'TCH',
                    'permintaan'=>'REPAIR',
                    'jenis_item'=>'Jigu',
                    'nama_mesin'=>$nomorinduk->nama_mesin,
                    'nama_item'=>$nomorinduk->nama_jigu,
                    'ukuran'=>$request['ukuran_after'],
                    'qty'=>1,
                    'satuan'=>'Pcs',
                    'alasan'=>$request['reason'],
                    'permintaan_perbaikan'=>$request['repairrequest'],
                    'status'=>"Open",
                    'nouki'=>$request['nouki'],
                ]);
                $details = [
                    'id_riwayat' => $noid,
                ];
                $data = [
                    'record_no' => Str::uuid(),
                    'user_id' => $user->id,
                    'activity' =>"create",
                   
                    'message' => $details,
                ];
                   LogModel::create($data);
                   Session::flash('alert-success','Tambah Data berhasil !');
                   $status = true;
                   $mess = 'Tambah Data berhasil !';
                   }else{
                   Session::flash('alert-danger','Tambah Data Gagal !'); 
                   $status = false;
                   $mess = 'Tambah Data Gagal !';
                   }
            
               return array(
                'message' => $mess,
                'success'=>$status
                   ); 
    }

    public function getnomertch(Request $request){
        $now = date('Y-m-d');
        $no_laporan = DB::connection('sqlsrv')->select('exec no_technical ?,?', array($now, 'KR'));
        return $no_laporan;
     }

    public function inrepair (Request $request){
        //dd($request->all());
            $stat = $request['status'];
            $loc = $request['location1'];
            //dd($loc);
            $now = date('Y-m-d');
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $id = $request->input('id');
            $nomorinduk = JiguModel::find($id);
        
            //dd($user->departemen); 
            if ($user->departemen == 'Admin' || $user->departemen == 'MEASUREMENT & KALIBRASI') {
                if ($stat =='Out' ){
                    $id_no = Str::uuid();
                    $ins = RiwayatJiguModel::create([
                        'id_riwayat'=>$id_no,
                        'no_induk'=>$nomorinduk->no_induk,
                        'nama_mesin'=>$nomorinduk->nama_mesin,
                        'nama_jigu'=>$nomorinduk->nama_jigu,
                        'kigou'=>$nomorinduk->kigou,
                        'ukuran'=>$nomorinduk->ukuran,
                        'kigou_after'=>$request['kigou_after'],
                        'ukuran_after'=>$request['ukuran_after'],
                        'alasan'=>$nomorinduk->keterangan,
                        'tgl_masuk_produksi'=>$nomorinduk->tgl_masuk_produksi,
                        'tgl_keluar_produksi'=>$now,
                        'status'=>$stat
                    ]);

                        if ($ins) {
                            $nomorinduk->status = $stat;
                            $nomorinduk->tindakan_perbaikan = $request['corrective'];
                            $nomorinduk->save();
                        }

                } else {
                    $nomorinduk->status = $stat;
                    $nomorinduk->lokasi = $loc;
                    $nomorinduk->ukuran = $nomorinduk->ukuran_after;
                    $nomorinduk->kigou = $nomorinduk->kigou_after;
                    $nomorinduk->save();
                }
                
        
                $details = [
                    'id_jigu' => $nomorinduk->id_jigu,
                ];
                $data = [
                    'record_no' => Str::uuid(),
                    'user_id' => $user->id,
                    'activity' =>"create",
                    
                    'message' => $details,
                ];
                LogModel::create($data);
                Session::flash('alert-success','Tambah Data berhasil !');
                $status = true;
                $mess = 'Tambah Data berhasil !';
                }else{
                Session::flash('alert-danger','Tambah Data Gagal !'); 
                $status = false;
                $mess = 'Tambah Data Gagal !';
                }
         
                return array(
                'message' => $mess,
                'success'=>$status
                    ); 
            }

    public function listdaichou (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        //dd($stat);
        /*$c_loc = $request->input("lokasi");
        $datajigu = DB::connection('sqlsrv')->select("select substring(lokasi,1,1) as lokasi from tb_jigu group by substring(lokasi,1,1)");
        $listdatajigu= array();
        
        if ($c_loc == "All") {
            foreach ($datajigu as $key) {
                array_push($listdatajigu,$key->lokasi);
            }
        }else {
            foreach ($datajigu as $key) {
                array_push($listdatajigu, $c_loc);
            }
        }
        dd($listdatajigu); */
       
        $Datas = DB::table('tb_jigu')->where('status','=','In')     
            ->where(function($q) use ($search) {
                $q->where('nama_mesin','like','%'.$search.'%')
                ->orWhere('nama_jigu','like','%'.$search.'%')
                ->orWhere('ukuran','like','%'.$search.'%')
                ->orwhere('kigou','like','%'.$search.'%')
                ->orwhere('lokasi','like','%'.$search.'%')
                ->orwhere('no_induk','like','%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')    
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_jigu')->where('status','=','In')
            ->where(function($q) use ($search) {
                $q->where('nama_mesin','like','%'.$search.'%')
                ->orWhere('nama_jigu','like','%'.$search.'%')
                ->orWhere('ukuran','like','%'.$search.'%')
                ->orwhere('kigou','like','%'.$search.'%')
                ->orwhere('lokasi','like','%'.$search.'%')
                ->orwhere('no_induk','like','%'.$search.'%');
                })
                ->orderBy('created_at', 'desc')
            ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function requestmanual (Request $request){
        //dd($request->all());
        $id_request = Str::uuid();
        $now = date('Y-m-d');
        $user = $request["user"];
        $machine = $request["mesin"];
        $jigu = $request["jigu"];
        $kigou = $request["kigou"];
        $ukuran = $request["ukuran"];
        $qty = $request["qty"];
        $kode_gambar = $request["kode_gambar"];
        $mno = $request["mno"];
        //dd($mno);
        if($user == null || $ukuran == null || $kigou == null){
            //Session::flash('alert-danger','Registration Number already exist !'); 
            $mess = 'data is empty .';
            $status = false;
            //return redirect()->route('requestjigu');
        } elseif ($user != null || $ukuran != null || $kigou != null) {
           $ins_requestmanual = RequestjigumanualModel::create([
                'id_requestjigu_manual'=>Str::uuid(),
                //'tgl_datang'=>$now,
                'nama_mesin'=>$machine,
                'nama_jigu'=>$jigu,
                'kigou'=>$kigou,
                'ukuran'=>$ukuran,
                'qty'=>$qty,
                'kode_gambar'=>$kode_gambar,
                'status'=>'Order',
                'user'=>$user,
            ]);

        Session::flash('alert-success','Request Success !');
        $status = true;
        $mess = 'Request Success !';
        }else{
        Session::flash('alert-danger','Failed created data !'); 
        $status = false;
        $mess = 'Failed created data !';
        }

        return array(
            'message' => $mess,
            'success'=>$status
                ); 
    }

    public function outofstockpdf(){
        //dd($mno);
        $nourut = DB::connection('sqlsrv')->select("select * from tb_requestjigu_manual where created_at IN(select max(created_at) from tb_requestjigu_manual) order by created_at");
        //dd($token);
        //$detail = JiguModel::find($list->id_noinduk_jigu);
        //dd($nourut);
        //$png = qrCode::format('png')->size(512)->generate(1);
        //$png = base64_encode($png);
//dd($idinduk->tgl_permintaan);
        //$pdf = PDF::loadview('/jigu/formjigupdf',['list'=>$list, 'listjigu'=>$listjigu, 'png'=>$png])->setPaper('A4');
        //return $pdf->stream('Form Request Jigu.pdf');

        return view ('/jigu/requestmanualpdf',['nourut'=>$nourut]);
    }

    public function noukimanual (Request $request){
        //dd($request->all());
            $tgl = $request['tgl'];
            $now = date('Y-m-d');
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $id = $request->input('id');
            //dd($id);
            $nomorid = RequestJiguManualModel::find($id);
        
            //dd($user->departemen); 
            if ($user->departemen == 'Admin' || $user->departemen == 'MEASUREMENT & KALIBRASI') {
                            $nomorid->nouki = $tgl;
                            $nomorid->save();
        
                $details = [
                    'id_requestjigu_manual' => $nomorid->id_requestjigu_manual,
                ];
                $data = [
                    'record_no' => Str::uuid(),
                    'user_id' => $user->id,
                    'activity' =>"create",
                    
                    'message' => $details,
                ];
                LogModel::create($data);
                Session::flash('alert-success','Tambah Data berhasil !');
                $status = true;
                $mess = 'Success edit data !';
                }else{
                Session::flash('alert-danger','Tambah Data Gagal !'); 
                $status = false;
                $mess = 'Edit data failed !';
                }
         
                return array(
                'message' => $mess,
                'success'=>$status
                    ); 
        }

        public function exceldaichou (Request $request){
                //dd($request->all());
                $data = $request['data'];
                $tawal = $request['tawal'];
                $takhir = $request['takhir'];
                //dd($data);
                if($data == 'daichou'){
                    $Datas = DB::table('tb_jigu')->where('status','=','In')->get();
            
                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A1','No');
                    $sheet->setCellValue('B1','nama_mesin');
                    $sheet->setCellValue('C1','nama_jigu');
                    $sheet->setCellValue('D1','ukuran');
                    $sheet->setCellValue('E1','kigou');
                    $sheet->setCellValue('F1','qty');
                    $sheet->setCellValue('G1','no_induk');
            
                    $line = 2;
                    $no = 1;
                    foreach ($Datas as $data) {
                        $sheet->setCellValue('A'.$line,$no++);
                        $sheet->setCellValue('B'.$line,$data->nama_mesin);
                        $sheet->setCellValue('C'.$line,$data->nama_jigu);
                        $sheet->setCellValue('D'.$line,$data->ukuran);
                        $sheet->setCellValue('E'.$line,$data->kigou);
                        $sheet->setCellValue('F'.$line,$data->qty);
                        $sheet->setCellValue('G'.$line,$data->no_induk);
                
                        $line++;
                    }
            
                    $writer = new Xlsx($spreadsheet);
                    $filename = "ListDaichou_".date('YmdHis').".xlsx";
                    $writer->save(public_path("storage/excel/".$filename));
                    return ["file"=>url("/")."/storage/excel/".$filename];

                } else {
                    $Datas = DB::table('tb_jigu')->where('status','=','Out')->where('tindakan_perbaikan','=','NG')
                    ->where('tgl_keluar_produksi','>=',$tawal)->where('tgl_keluar_produksi','<=',$takhir)->get();
            
                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A1','Periode : '.$tawal. ' ~ '.$takhir);
                    $sheet->setCellValue('A2','No');
                    $sheet->setCellValue('B2','nama_mesin');
                    $sheet->setCellValue('C2','nama_jigu');
                    $sheet->setCellValue('D2','ukuran');
                    $sheet->setCellValue('E2','qty');
                    $sheet->setCellValue('F2','no_induk');
            
                    $line = 3;
                    $no = 1;
                    foreach ($Datas as $data) {
                        $sheet->setCellValue('A'.$line,$no++);
                        $sheet->setCellValue('B'.$line,$data->nama_mesin);
                        $sheet->setCellValue('C'.$line,$data->nama_jigu);
                        $sheet->setCellValue('D'.$line,$data->ukuran);
                        $sheet->setCellValue('E'.$line,$data->qty);
                        $sheet->setCellValue('F'.$line,$data->no_induk);
                
                        $line++;
                    }
            
                    $writer = new Xlsx($spreadsheet);
                    $filename = "ListNG_".date('YmdHis').".xlsx";
                    $writer->save(public_path("storage/excel/".$filename));
                    return ["file"=>url("/")."/storage/excel/".$filename];
                }
               
        }



}
