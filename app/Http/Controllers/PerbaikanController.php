<?php

namespace App\Http\Controllers;
//use Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PerbaikanModel;
use App\PartsModel;
use App\OperatorMtcModel;
use App\LogModel;
use App\TargetModel;
use Carbon\Carbon;
use App\UserModel;
use App\MesinModel;
use App\ScheduleModel;
use App\ProgramModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Notifications\RequestNotif;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Events\EventMessage;
use App\Events\EventPPIC;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PerbaikanController extends Controller
{

    public function postmesin(Request $request){
        $id = Str::uuid();
        $no_mesin = MesinModel::where('no_induk','=',$request["nomerinduk"])->get();
        $state = False;
       if (count($no_mesin) <= 0) {
           MesinModel::create([
               'id_mesin'=>$id,
               'no_induk'=>$request["nomerinduk"],
               'nama_mesin'=>$request["nama_mesin"],
               'no_urut'=>$request["no_urut"],
               'merk_mesin'=>$request["merk_mesin"],
               'type_mesin'=>$request["type_mesin"],
               'tahun_pembuatan'=>$request["tahun_mesin"],
               'factory'=>$request["factory"],
               'lokasi'=>$request["lokasi"],
               'kondisi'=>$request["kondisi"],
               'kategori_mesin'=>$request["kategori"],
               'keterangan'=>$request["keterangan"]   
           ]);
           Session::flash('alert-success','Tambah Data berhasil !'); 
           $pesan = 'Tambah Data berhasil !';
           $state = true;
           $details = [
            'no_mesin' => $request['nomerinduk'],
            'id_mesin' => $id,
            'status'=>$request["kondisi"],
           
        ];
           $data = [
            'record_no' => Str::uuid(),
            'user_id' => Session::get('id'),
            'activity' =>"create",
            'message' => $details,
        ];
        LogModel::create($data);
       }else{
        Session::flash('alert-danger','Tambah Data gagal !'); 
        $pesan = 'Tambah Data gagal !';
       }
       
       
       return  [
       "message"=>$pesan,
        "success" => $state
    ];


    }

    public function listmesin(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
   
        $Datas = MesinModel::where('no_induk','like','%'.$search.'%')
            ->orWhere('nama_mesin','like','%'.$search.'%')
            ->orWhere('lokasi','like','%'.$search.'%')
            ->orderBy('tahun_pembuatan','DESC')
            ->skip($start)
            ->take($length)
            ->get();

        $count =MesinModel::where('no_induk','like','%'.$search.'%')
            ->orWhere('nama_mesin','like','%'.$search.'%')
            ->orWhere('lokasi','like','%'.$search.'%')
            ->count();
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function editmesin(Request $request){
        $id_mesin = $request['id_mesin'];
        $mesin = MesinModel::find($id_mesin);

        $mesin->nama_mesin = $request['nama_mesin'];
        $mesin->no_urut = $request['no_urut'];
        $mesin->merk_mesin = $request['merk_mesin'];
        $mesin->tahun_pembuatan = $request['tahun_mesin'];
        $mesin->type_mesin = $request['type_mesin'];
        $mesin->kategori_mesin = $request['kategori'];
        $mesin->lokasi = $request['lokasi'];
        $mesin->factory = $request['factory'];
        $mesin->kondisi = $request['kondisi'];
        $mesin->keterangan = $request['keterangan'];
        $message['update']= 'tb_mesin';
        $message['id_mesin']= $id_mesin;
        if ($mesin->isDirty('nama_mesin')) {
            $message['nama_mesin']=$request['nama_mesin'];
        }
        if ($mesin->isDirty('no_urut')) {
            $message['no_urut']=$request['no_urut'];
        }
        if ($mesin->isDirty('merk_mesin')) {
            $message['merk_mesin']=$request['merk_mesin'];
        }
        if ($mesin->isDirty('tahun_pembuatan')) {
            $message['tahun_pembuatan']=$request['tahun_mesin'];
        }
        if ($mesin->isDirty('type_mesin')) {
            $message['type_mesin']=$request['type_mesin'];
        }
        if ($mesin->isDirty('kategori_mesin')) {
            $message['kategori_mesin']=$request['kategori'];
        }
        if ($mesin->isDirty('lokasi')) {
            $message['lokasi']=$request['lokasi'];
        }
        if ($mesin->isDirty('keterangan')) {
            $message['keterangan']=$request['keterangan'];
        }

        $mesin->save();
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => Session::get('id'),
            'activity' =>"update",
            'message' => $message,
        ];
        LogModel::create($data);

        return array(
            'message' =>"Update data berhasil !",
            'success'=>true
        );

    }
    public function delmesin(Request $request){
       if (Session::get('level') == 'Admin' || Session::get('level') == 'Leader' || Session::get('level') == 'Foreman' || Session::get('level') == 'Supervisor') {
          $mesin = MesinModel::find($request['id']);
          $mesin->delete();
          $message = ["id_mesin"=>$request['id']];
          $data = [
            'record_no' => Str::uuid(),
            'user_id' => Session::get('id'),
            'activity' =>"delete",
            'message' => $message,
        ];
        LogModel::create($data);
          return array(
            'message' =>"Hapus data berhasil !",
            'success'=>true
        );
       }else{
        return array(
            'message' =>"Hapus data gagal !",
            'success'=>false
        );
       }
    }
    public function importmesin(Request $request){
        if ($request->hasFile('list_mesin')) {
            $path = $request->file('list_mesin')->getRealPath();
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $Data = $reader->load($path);
            $sheetdata = $Data->getActiveSheet()->toArray(null, true, true, true);
             unset($sheetdata[1]);
           
            foreach ($sheetdata as $row) {
                $id = Str::uuid();
             MesinModel::create([
                'id_mesin'=>$id,
                'no_induk'=>$row['C'],
                'nama_mesin'=>$row['B'],
                'no_urut'=>$row['D'],
                'merk_mesin'=>$row['E'],
                'type_mesin'=>$row['F'],
                'tahun_pembuatan'=>$row['G'],
                'factory'=>$row['J'],
                'lokasi'=>$row['H'],
                'kondisi'=>$row['I'],
                'kategori_mesin'=>$row['L'],
                'keterangan'=>$row['K']   
            ]);
         }
 
         Session::flash('success','Import data berhasil'); 
         return redirect()->route('tools');
         }
    }
    public function listperbaikan (){
        $perbaikan = DB::table('tb_perbaikan')->get();
        return view ('maintenance.listperbaikan',['tb_perbaikan' => $perbaikan]);
    }
   
    
    public function tambah (Request $request){
      //dd($request->all());
            $this->validate($request,[
        
        'departemen' => 'required',
        'shift' => 'required',
        'tanggal_rusak' => 'required',
      
        'kondisi' => 'required',
        'penyebab' => 'required',
        'tindakan' => 'required',
 
      
    ]);

    $id = Str::uuid();
    $user_id = Session::get('id');
    $jam_rusak = date_create($request['tanggal_rusak']);
    $jam_mulai = date_create($request['tanggal_mulai']);
    $jam_selesai = date_create($request['tanggal_selesai']);
    $mesin = MesinModel::where('no_induk','=',$request['no_induk'])->first();
    $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($jam_mulai, $jam_selesai));
    //$jam_perbaikan = date_diff($jam_mulai,$jam_selesai);
    $jam_perbaikan = $hasilnya[0]->hasil;
    $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($jam_rusak, $jam_selesai));
    //$jam_kerusakan = date_diff($tanggal_rusak, $jam_selesai);
    $jam_kerusakan = $hasilnya[0]->hasil;
    $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($jam_rusak, $jam_mulai));
    //$jam_menunggu = date_diff($tanggal_rusak, $jam_mulai);
    $jam_menunggu = $hasilnya[0]->hasil;
    $tgl_per = date('Y-m-d',strtotime($request['tanggal_rusak']));
    $no_perbaikan = $request['nopermintaan'];
        $nom = PerbaikanModel::where('no_perbaikan',$no_perbaikan)->count();
        if ($nom > 0) {
           $no_perbaikan = $this->nomer_perbaikan($tgl_per,$request['dept_code']);
        }

    if ($jam_mulai < $jam_rusak ) {
        return array(
            'message' => 'Jam Mulai perbaikan salah!',
            'success'=>false,
        );
    }elseif ($jam_selesai < $jam_rusak || $jam_selesai < $jam_mulai) {
        return array(
            'message' => 'Jam Selesai perbaikan salah!',
            'success'=>false,
        );
    }else{

        if ($request['klasifikasi'] == 'A') {
            $jamperbaikan =  $jam_perbaikan;
            $jamkerusakan = 0;
            $jammenunggu = 0;
        } elseif ($request['klasifikasi'] == 'B') {
            $jamperbaikan =  $jam_perbaikan;
            $jamkerusakan = $jam_perbaikan;
            $jammenunggu = 0;
        }elseif ($request['klasifikasi'] == 'C') {
            $jamperbaikan = $jam_perbaikan;
            $jamkerusakan = $jam_kerusakan;
            $jammenunggu = $jam_menunggu;
        }else {
            $jamperbaikan =  $jam_perbaikan;
            $jamkerusakan = 0;
            $jammenunggu = 0;
        }

    PerbaikanModel::create([
        'id_perbaikan' => $id,
        'no_perbaikan' => $no_perbaikan,
        'departemen' => $request['departemen'],
        'shift' => $request['shift'],
        'tanggal_rusak' => $jam_rusak,
        'nama_mesin' => $request['mesin'],
        'no_induk_mesin' => $request['no_induk'],
        'no_urut_mesin' => $mesin->no_urut,
        'masalah' => $request['masalah'],
        'kondisi' => $request['kondisi'],
        'penyebab' => $request['penyebab'],
        'tindakan' => $request['tindakan'],
        'tanggal_mulai' => $jam_mulai,
        'tanggal_selesai' => $jam_selesai,
        'klasifikasi' => $request['klasifikasi'],
        'operator' => 1,
        'status' =>'complete',
        'total_jam_perbaikan' => $jamperbaikan,
        'total_jam_kerusakan' => $jamkerusakan,
        'total_jam_menunggu' => $jammenunggu,
        'user_id' => $user_id,
       ]);
       $nik = $request['operator'];
       $nama = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->where('NIK','=',$nik)->first();
       
       $id_req = Str::uuid();
       OperatorMtcModel::create([
         'record_no'=>$id_req,
         'id_perbaikan'=>$id,
         'no_perbaikan'=>$no_perbaikan,
         'nik'=> $nik,
         'nama' =>$nama->NAMA,
         ]);

        if (!empty($request->get('part_code'))) {
              
            $size = count(collect($request)->get('part_code'));
        }else{
            $size = 0;
        }

       if ($size > 0) {
        for ($i = 0; $i < $size; $i++){
            $record = Str::uuid();
            PartsModel::create([
                'record_parts'=>$record,
                'id_perbaikan' => $id,
                'item_code'=>  $request->get('part_code')[$i],
                'nama_part' => $request->get('part_name')[$i],
                'qty'=>  $request->get('part_qty')[$i],

            ]);
        }

       }
        
    Session::flash('alert-success','Tambah Data berhasil !'); 
    $data = [
        'record_no' => Str::uuid(),
        'user_id' => $user_id,
        'activity' =>"create",
        'message' => "create request ".$request['nopermintaan'].", ID : ".$id,
    ];
    LogModel::create($data);
       return redirect()->route('input-perbaikan');
    }
}

    public function nomer_perbaikan($tanggal, $dept){
        $nomer = DB::connection('sqlsrv')->select('exec get_no_perbaikan ?,?', array($tanggal, $dept));

       return $nomer[0]->no_perbaikan;
    }
    public function get_nomer(Request $request){
      
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$user->nik'"));
        $nomer = $this->nomer_perbaikan($request['tanggal'],$dept[0]->KODE_DEPARTEMEN);
       return [
           "no_perbaikan"=>$nomer];
    }

    public function list_parts(Request $request){

        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
   
        $Datas = DB::connection('sqlsrv_pass')->table('tb_masteritem')
            ->where('item','like','%'.$search.'%')
            ->orWhere('spesifikasi','like','%'.$search.'%')
            ->orWhere('item_code','like','%'.$search.'%')
            ->skip($start)
            ->take($length)
            ->get();
        $count = DB::connection('sqlsrv_pass')->table('tb_masteritem')
            ->where('item','like','%'.$search.'%')
            ->orWhere('spesifikasi','like','%'.$search.'%')
            ->orWhere('item_code','like','%'.$search.'%')
            ->count();
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
       
    }

    public function list_perbaikan(Request $request){
        
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
   
        $Datas = PerbaikanModel::where('status','=','open')
            ->where(function($q) use ($search) {
                $q->where('nama_mesin','like','%'.$search.'%')
                  ->orWhere('masalah','like','%'.$search.'%')
                  ->orwhere('no_perbaikan','like','%'.$search.'%');
            })
            ->orderBy('tanggal_rusak','asc')
            ->skip($start)
            ->take($length)
            ->get();

        
        $count = PerbaikanModel::where('status','=','open')
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
              ->orWhere('masalah','like','%'.$search.'%')
              ->orwhere('no_perbaikan','like','%'.$search.'%');
        })
      
            ->count();
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function request(Request $request){
       //dd($request->all());
        $this->validate($request,[
            'no-permintaan' => 'required|min:12',
            'shift' => 'required',
            'no_induk' => 'required',
            'masalah' => 'required',
        ]);

        $nik = Session::get('nik');
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        
        $mesin = MesinModel::where('no_induk','=',$request['no_induk'])->first();

        
        //dd($users);
        $id = Str::uuid();
        $user_id = Session::get('id');
        //$tanggal = date('Y-m-d h:i:sa');
        $tgl = date("Y-m-d");
        $tanggal = Carbon::now();

        $no_perbaikan = $request['no-permintaan'];
        $nom = PerbaikanModel::where('no_perbaikan',$no_perbaikan)->count();
        if ($nom > 0) {
           $no_perbaikan = $this->nomer_perbaikan($tgl,$nomer[0]->KODE_DEPARTEMEN);
        }
        if ($request['ppic'] == 'Y') {
            $klasi = 'C';
        }else{
            $klasi = NULL;
        }
        $insert = PerbaikanModel::create([
            'id_perbaikan' => $id,
            'no_perbaikan' => $no_perbaikan,
            'departemen' => $nomer[0]->DEPT_SECTION,
            'shift' => $request['shift'],
            'tanggal_rusak' => $tanggal,
            'nama_mesin' => $mesin->nama_mesin,
            'no_induk_mesin' => $mesin->no_induk,
            'no_urut_mesin' => $mesin->no_urut,
            'masalah' => $request['masalah'],
            'kondisi' => $request['kondisi'],
            'klasifikasi'=>$klasi,
            'lapor_ppic'=>$request['ppic'],
            'status' => 'open',
            'user_id' => $user_id,
           ]);

           if ($insert) {
             
               Session::flash('alert-success','Tambah Data berhasil !'); 
               $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user_id,
                'activity' =>"create",
                'message' => "create request ".$no_perbaikan.", ID : ".$id,
            ];
            LogModel::create($data);
            $users = UserModel::where('departemen','MAINTENANCE')->get();
       
                $details = [
                    'type'=>'perbaikan',
                    'no' => $no_perbaikan,
                    'nama_mesin' => $mesin->nama_mesin,
                    'dept'=>$nomer[0]->DEPT_SECTION,
                    'user' => $user_id,
                ];
          
                
               
                //Notification::send($users, new RequestNotif($details));
                
                $mes = array(
                    'judul'=> $nomer[0]->DEPT_SECTION,
                    "sub"=>$mesin->nama_mesin,
                    "isi"=>$request['masalah']." ".$request['kondisi'],
                    "ppic"=>$request['ppic'],
                   );
                    event(new EventMessage($mes));

            if ($request['ppic'] == 'Y') {
               event(new EventPPIC($mes));
            }
                   
            return array(
                "success"=>true,
                "message"=>"Tambah Data berhasil !"
            );
           }else {
             Session::flash('alert-danger','Tambah Data gagal !');
             return array(
                "success"=>false,
                "message"=>"Tambah Data Gagal !"
            );
           }

    }

    public function nonmesin(Request $request){
       //dd($request->all());
        $this->validate($request,[
            'no-permintaan2' => 'required|min:12',
            
            'shift2' => 'required',
            'mesin2' => 'required',
           
        ]);

        $nik = Session::get('nik');
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        
        $no_perbaikan = $request['no-permintaan2'];
        $tgl = date("Y-m-d");
        $nom = PerbaikanModel::where('no_perbaikan',$no_perbaikan)->count();
        if ($nom > 0) {
           $no_perbaikan = $this->nomer_perbaikan($tgl,$nomer[0]->KODE_DEPARTEMEN);
        }

        $id = Str::uuid();
        $user_id = Session::get('id');
        $tanggal = Carbon::now();
        if ($request['ppic'] == 'Y') {
            $klasi = 'C';
        }else{
            $klasi = NULL;
        }

        $insert = PerbaikanModel::create([
            'id_perbaikan' => $id,
            'no_perbaikan' => $no_perbaikan,
            'departemen' => $nomer[0]->DEPT_SECTION,
            'shift' => $request['shift2'],
            'tanggal_rusak' => $tanggal,
            'nama_mesin' => $request['mesin2'],
            'no_induk_mesin' => 'NM',
            'no_urut_mesin' => 0,
            'masalah' => $request['masalah2'],
            'kondisi' => $request['kondisi2'],
            'klasifikasi'=>$klasi,
            'lapor_ppic'=>$request['ppic'],
            'status' => 'open',
            'user_id' => $user_id,
           ]);

           if ($insert) {
             
               Session::flash('alert-success','Tambah Data berhasil !'); 
               $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user_id,
                'activity' =>"create",
                'message' => "create request ".$no_perbaikan.", ID : ".$id,
            ];
            LogModel::create($data);
            $users = UserModel::where('departemen','MAINTENANCE')->get();
       
            $details = [
                'type'=>'perbaikan',
                'no' => $no_perbaikan,
                'nama_mesin' => $request['mesin'],
                'dept'=>$nomer[0]->DEPT_SECTION,
                'user' => $user_id,
            ];
            Notification::send($users, new RequestNotif($details));
            $mes = array(
                'judul'=> $nomer[0]->DEPT_SECTION,
                "sub"=>$request['mesin2'],
                "isi"=>$request['masalah2']." ".$request['kondisi2'],
                "ppic"=>$request['ppic'],
               );
                event(new EventMessage($mes));
            if ($request['ppic'] == 'Y') {
                event(new EventPPIC($mes));
                }
                return array(
                    "success"=>true,
                    "message"=>"Tambah Data berhasil !"
                );
           }else {
             Session::flash('alert-danger','Tambah Data gagal !'); 
             return array(
                "success"=>false,
                "message"=>"Tambah Data Gagal !"
            );
           }
    }

    public function update_pelaksana(Request $request){
        if ($request->operator != null) {
          $no = $request['no_req'];
          $klas = $request['klasifikasi'];
          $token = apache_request_headers();
          $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
          $req = PerbaikanModel::find($no);
          $no_per = $req->no_perbaikan;
          $size = count(collect($request)->get('operator'));
          if ($req) {
            
              $req->operator = $size;
              $req->status = 'process';
              $req->approved_by = $user->id;
              $req->klasifikasi = $klas;
              $req->save();
          }
         
          
          if ($size > 0) {
              for ($i = 0; $i < $size; $i++){
                  $nik = $request->get('operator')[$i];
                  $nama = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->where('NIK','=',$nik)->first();
                  
                  $id = Str::uuid();
                  OperatorMtcModel::create([
                    'record_no'=>$id,
                    'id_perbaikan'=>$no,
                    'no_perbaikan'=>$no_per,
                    'nik'=> $request->get('operator')[$i],
                    'nama' =>$nama->NAMA,
              ]);
            }
    
           }
         
           Session::flash('alert-success','Penentuan Operator berhasil !'); 
           return ["respon"=>"success"];

        }else {
            
           return ["respon"=>"operatornull"];
        }
      

    }

    public function req_perbaikan(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik = $user->nik;
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        $dept = $nomer[0]->DEPT_SECTION;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->get();
       
        $listdept= array();

        if ($dept=='Admin' || $level == 'Manager' || $user->nik == '0033') {
          
            foreach ($alldept as $key) {
                array_push($listdept,$key->DEPT_SECTION);
               
            }
        }else {
            array_push($listdept, $dept);
           
        }
      

        
        $Datas = DB::table('tb_perbaikan')->leftjoin('tb_user','tb_perbaikan.user_id','=','tb_user.id')
            ->select('tb_perbaikan.*','tb_user.user_name')
            ->where('tb_perbaikan.no_perbaikan','like','%'.$search.'%')
            ->where('tb_perbaikan.status','<>','complete')
            ->where('tb_perbaikan.status','<>','selesai')
            ->whereIn('tb_perbaikan.departemen',$listdept)
            ->where(function($q) use ($search) {
                $q->where('tb_perbaikan.nama_mesin','like','%'.$search.'%')
                  ->orWhere('tb_perbaikan.masalah','like','%'.$search.'%');
                  
            })
            ->orderBy('tb_perbaikan.tanggal_rusak','asc')
            ->skip($start)
            ->take($length)
            ->get();

        
        $count = PerbaikanModel::where('no_perbaikan','like','%'.$search.'%')
        ->where('status','<>','complete')
        ->where('status','<>','selesai')
        ->whereIn('departemen',$listdept)
        ->where(function($q) use ($search) {
            $q->where('nama_mesin','like','%'.$search.'%')
              ->orWhere('masalah','like','%'.$search.'%');
              
        })
            ->count();
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function del_req(Request $request){
        //$dept = Session::get('dept');
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik = $user->nik;
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        $dept = $nomer[0]->DEPT_SECTION;
       
        $id = $request->input('id');
        $req = PerbaikanModel::find($id);

        
        if ($dept == "Admin") {
            $req->delete();
          $status = true;
          $mess = "Delete berhasil";
            //Session::flash('alert-success','Hapus Request berhasil !'); 
        }else if ($dept == $req->departemen) {
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
            'no_req' => $req->no_perbaikan,
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

    
    public function update_req(Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik = $user->nik;
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        $dept = $nomer[0]->DEPT_SECTION;
        
        $id = $request->input('id');
        $req = PerbaikanModel::find($id);
       
        
        if ($dept == "Admin" || $dept == $req->departemen) {

        $req->shift = $request['shift'];
        $req->no_induk_mesin = $request['no_mesin'];
        if ($request['no_mesin'] != 'NM'){

            $mesin = DB::connection('sqlsrv_pass')->table('tb_inventory')->where('item_code','=',$request['no_mesin'])->first();
        
            $req->nama_mesin = $mesin->item.' '.$mesin->spesifikasi;
        }
        $req->masalah = $request['masalah'];
        $req->kondisi = $request['kondisi'];
        $req->save();

          $status = true;
          $mess = "Update data berhasil";
        }else {
            $mess = "Update gagal";
            $status = false;
          
        }

        $details = [
            'id_req' => $id,
            'shift'=>$request['shift'],
            'no_mesin' => $request['no_mesin'],
            'masalah' => $request['masalah'],
            'kondisi' => $request['kondisi'],
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

    public function list_req(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        
        $dept = $user->departemen;
        $level = $user->level_user;

        $Datas = DB::connection('sqlsrv')->select("SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, klasifikasi, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p where p .status = 'process' and p.masalah like '%$search%'
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, klasifikasi, operator
      ORDER BY tanggal_rusak OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

        
        $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p where p .status = 'process' and p.masalah like '%$search%'
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator)a")[0]->total;
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function postcomplete(Request $request){
       //input selesai perbaikan oleh maintenance
        
        $jam_mulai = date_create($request['tanggal_mulai']);
        $jam_selesai = date_create($request['tanggal_selesai']);
        
        $req = PerbaikanModel::find($request['id_req']);
        $tanggal_rusak = date_create($req->tanggal_rusak);
        $departemen = $req->departemen;

        $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($jam_mulai, $jam_selesai));
        //$jam_perbaikan = date_diff($jam_mulai,$jam_selesai);
        $jam_perbaikan = $hasilnya[0]->hasil;
        $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($tanggal_rusak, $jam_selesai));
        //$jam_kerusakan = date_diff($tanggal_rusak, $jam_selesai);
        $jam_kerusakan = $hasilnya[0]->hasil;
        $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($tanggal_rusak, $jam_mulai));
        //$jam_menunggu = date_diff($tanggal_rusak, $jam_mulai);
        $jam_menunggu = $hasilnya[0]->hasil;
        
        if ($jam_mulai < $tanggal_rusak ) {
            return array(
                'message' => 'Jam Mulai perbaikan salah!',
                'success'=>false,
            );
        }elseif ($jam_selesai < $tanggal_rusak || $jam_selesai < $jam_mulai) {
            return array(
                'message' => 'Jam Selesai perbaikan salah!',
                'success'=>false,
            );
        }else{

            if ($request['klasifikasi'] == 'A') {
                $jamperbaikan =  $jam_perbaikan;
                $jamkerusakan = 0;
                $jammenunggu = 0;
            } elseif ($request['klasifikasi'] == 'B') {
                $jamperbaikan =  $jam_perbaikan;
                $jamkerusakan = $jam_perbaikan;
                $jammenunggu = 0;
            }elseif ($request['klasifikasi'] == 'C') {
                $jamperbaikan = $jam_perbaikan;
                $jamkerusakan = $jam_kerusakan;
                $jammenunggu = $jam_menunggu;
            }else {
                $jamperbaikan =  $jam_perbaikan;
                $jamkerusakan = 0;
                $jammenunggu = 0;
            }
           


            $req->penyebab = $request['penyebab'];
            $req->tanggal_mulai = $jam_mulai;
            $req->tindakan = $request['tindakan'];
            $req->klasifikasi = $request['klasifikasi'];
            $req->tanggal_selesai = $jam_selesai;
            $req->total_jam_perbaikan =$jamperbaikan;
            $req->total_jam_kerusakan = $jamkerusakan;
            $req->total_jam_menunggu = $jammenunggu;
            $req->status = 'selesai';
            $req->save();

            if (!empty($request->get('part_code'))) {
              
                $size = count(collect($request)->get('part_code'));
            }else{
                $size = 0;
            }

            if ($size > 0) {
             for ($i = 0; $i < $size; $i++){
                 $record = Str::uuid();
                 PartsModel::create([
                     'record_parts'=>$record,
                     'id_perbaikan' => $request['id_req'],
                     'item_code'=>  $request->get('part_code')[$i],
                     'nama_part'=> $request->get('part_name')[$i],
                     'qty'=>  $request->get('part_qty')[$i],
     
                 ]);
             }
            }

            $details = [
                'id_req' => $request['id_req'],
                'no_request' => $req->no_perbaikan,
                'status'=>'selesai',
               
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' => Session::get('id'),
                'activity' =>"update",
                'message' => $details,
            ];
            LogModel::create($data);
            $users = UserModel::where('departemen',$departemen)->get();
       
            $details = [
                'type'=>'req_perbaikan',
                'no' => $req->no_perbaikan,
                'nama_mesin' => $req->nama_mesin,
                'dept'=>$departemen,
                'user' => Session::get('id'),
            ];
            Notification::send($users, new RequestNotif($details));
            return array(
                'message' => 'Simpan berhasil!',
                'success'=>true,
            );
           

        }
        
        
    }

    public function perbaikan_selesai(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik = $user->nik;
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        $dept = $nomer[0]->DEPT_SECTION;
        
        $level = $user->level_user;

        $Datas = DB::connection('sqlsrv')->select("SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan where a.departemen = '$dept') AS p where p.status = 'selesai'
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai
      ORDER BY tanggal_rusak OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

        
        $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan where a.departemen = '$dept') AS p where p .status = 'selesai'
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai)a")[0]->total;
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function perbaikan_complete(Request $request){
      
        $token = apache_request_headers();
        $id = $request->input("id");
        $req = PerbaikanModel::find($id);
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik = $user->nik;
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        $dept = $nomer[0]->DEPT_SECTION;

        if ($dept == 'Admin') {
            $req->completed_by = $user->id;
            $req->status = "complete";
            $req->save();
            $details = [
                'id_req' => $request['id'],
                'no_request' => $req->no_perbaikan,
                'status'=>'complete',
               
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' =>  $user->id,
                'activity' =>"update",
                'message' => $details,
            ];
            LogModel::create($data);
          
            return array(
                'message' => 'Update Berhasil !',
                'success'=>true,
            );
        }elseif ($dept == $req->departemen) {
            $req->completed_by = $user->id;
            $req->status = "complete";
            $req->save();
            $details = [
                'id_req' => $request['id'],
                'no_request' => $req->no_perbaikan,
                'status'=>'complete',
               
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' =>  $user->id,
                'activity' =>"update",
                'message' => $details,
            ];
            LogModel::create($data);
            return array(
                'message' => 'Update Berhasil !',
                'success'=>true,
            );
        }else{
            return array(
                'message' => 'Gagal Update request !',
                'success'=>false,
            );
        }
    }

    public function perbaikan_ditolak(Request $request){
        $token = apache_request_headers();
        $id = $request->input("id");
        $req = PerbaikanModel::find($id);
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        if(!$req){
            return array(
                'message' => 'Gagal Update perbaikan !',
                'success'=>false,
            );
        }
        $req->status = 'process';
        $req->save();
        $details = [
            'id_req' => $id,
            'no_request' => $req->no_perbaikan,
            'status'=>'process',
            
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' =>  $user->id,
            'activity' =>"update",
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => 'Perbaikan berhasil ditolak !',
            'success'=>true,
        );
    }

    public function pending(Request $request){
        $id = $request['id-req'];
        $req = PerbaikanModel::find($id);

        $pend = ScheduleModel::create([
            'id_schedule' => str::uuid(),
            'id_perbaikan' => $id,
            'description' => 'pending_perbaikan',
            'lokasi' => $req->departemen,
            'keterangan' => $request['keterangan'],
            'no_induk_mesin' => $req->no_induk_mesin,
            'nama_mesin' => $req->nama_mesin,
            'no_urut_mesin' => $req->no_urut_mesin,
            'tanggal_rencana_mulai' => date_create($request['jadwal1']),
            'tanggal_rencana_selesai' => date_create($request['jadwal2']),
            'operator' => $req->operator,
            'status' => 'open'
        ]);

        if ($pend) {
           $req->status = 'pending';
           $req->save();
           $details = [
            'id_req' => $id,
            'no_request' => $req->no_perbaikan,
            'status'=>'pending',
           
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' =>  session::get('id'),
            'activity' =>"update",
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => 'Update Berhasil !',
            'success'=>true,
        );
          
        }else {
            return array(
                'message' => 'Update Gagal !',
                'success'=>false,
            );
        }
    }

    public function req_selesai(Request $request){
       
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");


        $Datas = DB::connection('sqlsrv')->select("SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, klasifikasi, status, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p where (p.tanggal_rusak >= CONVERT(datetime,'$awal') and p.tanggal_rusak <= CONVERT(datetime,'$akhir 23:59:59')) and (p.status = 'selesai' or p.status = 'complete') and ( p.nama_mesin like '%$search%' or p.no_perbaikan like '%$search%')
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai, klasifikasi, status
      ORDER BY tanggal_rusak OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

        
        $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p where  (p.tanggal_rusak >= CONVERT(datetime,'$awal') and p.tanggal_rusak <= CONVERT(datetime,'$akhir 23:59:59')) and (p.status = 'selesai' or p.status = 'complete') and ( p.nama_mesin like '%$search%' or p.no_perbaikan like '%$search%')
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai)a")[0]->total;
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function hyst_perbaikan(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $nik = $user->nik;
        $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
        $dept = $nomer[0]->DEPT_SECTION;
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
       
        $level = $user->level_user;

        $Datas = DB::connection('sqlsrv')->select("SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan where a.departemen = '$dept') AS p where (p.tanggal_rusak >= CONVERT(datetime,'$awal') and p.tanggal_rusak <= CONVERT(datetime,'$akhir 23:59:59')) and p.status = 'complete' and ( p.nama_mesin like '%$search%' or p.no_perbaikan like '%$search%')
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai
      ORDER BY tanggal_rusak OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

        
        $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, operator = STUFF((SELECT N', ' + nama 
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
         WHERE p2.id_perbaikan = p.id_perbaikan
         
         ORDER BY p.tanggal_rusak
         FOR XML PATH(N'')), 1, 2, N'')
      FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan where a.departemen = '$dept') AS p where (p.tanggal_rusak >= CONVERT(datetime,'$awal') and p.tanggal_rusak <= CONVERT(datetime,'$akhir 23:59:59')) and p .status = 'complete' and ( p.nama_mesin like '%$search%' or p.no_perbaikan like '%$search%')
      group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai)a")[0]->total;
     

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function jam_kerusakan(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $now = Date('Y-m');
        $peri = $request->input("periode");
        $thn = substr($peri,0,4);
        $bln = substr($peri,5,2);
        $klas = $request->input('klas');
        if ($peri == $now) {
           
            $Datas = DB::connection('sqlsrv')->table('v_jam_kerusakan')
                        ->where('no_induk_mesin','like','%'.$search.'%')
                        ->whereIn('klasifikasi',$klas)
                        ->where(function($q) use ($search) {
                            $q->where('no_induk_mesin','like','%'.$search.'%')
                            ->orWhere('nama_mesin','like','%'.$search.'%');
                           
                        })
                        ->orderBy('jam_rusak','desc')
                        ->skip($start)
                        ->take($length)
                        ->get();
            //$s = DB::connection('sqlsrv')->select("select * from v_jam_kerusakan where klasifikasi in ($klas) and (No_induk_mesin like '%$search%' OR nama_mesin like '%$search%')");
            //$count = count($s);
            $count = DB::connection('sqlsrv')->table('v_jam_kerusakan')
                        ->where('no_induk_mesin','like','%'.$search.'%')
                        ->whereIn('klasifikasi',$klas)
                        ->where(function($q) use ($search) {
                            $q->where('no_induk_mesin','like','%'.$search.'%')
                            ->orWhere('nama_mesin','like','%'.$search.'%');
                           
                        })
                        ->count();
        }else{
            $Datas = DB::connection('sqlsrv')->table('tb_jamkerusakan')
                        //->where(\DB::raw('DATEPART(YEAR,tgl_rekap)','=',$thn))
                        //->where(\DB::raw('DATEPART(MONTH,tgl_rekap)','=',$bln))
                        ->whereYear('tgl_rekap','=',$thn)
                        ->whereMonth('tgl_rekap','=',$bln)
                        ->whereIn('klasifikasi',$klas)
                        ->where(function($q) use ($search) {
                            $q->where('no_induk_mesin','like','%'.$search.'%')
                            ->orWhere('nama_mesin','like','%'.$search.'%');
                           
                        })
                        ->orderBy('jam_rusak','desc')
                        ->skip($start)
                        ->take($length)
                        ->get();
            
            $s = DB::connection('sqlsrv')->table('tb_jamkerusakan')
            ->whereYear('tgl_rekap','=',$thn)
            ->whereMonth('tgl_rekap','=',$bln)
            ->whereIn('klasifikasi',$klas)
            ->where(function($q) use ($search) {
                $q->where('no_induk_mesin','like','%'.$search.'%')
                ->orWhere('nama_mesin','like','%'.$search.'%');
               
            })
            ->get();
            $count = count($s);
        }

      
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function grafikjam(Request $request){
        $peri = $request->input("periode");
        $now = Date('Y-m');
        $thn = substr($peri,0,4);
        $bln = substr($peri,5,2);

        if ($peri == $now) {
          $totjam = DB::connection('sqlsrv')->select(\DB::raw('select departemen, sum(jam_rusak) as jam, sum(jam_menunggu) as menunggu from v_jam_kerusakan group by departemen'));
         
        }else{
            $totjam = DB::connection('sqlsrv')->select(\DB::raw('select departemen, sum(jam_rusak) as jam, sum(jam_menunggu) as menunggu from tb_jamkerusakan where DATEPART(YEAR,tgl_rekap) = '.$thn.' and DATEPART(MONTH,tgl_rekap)='.$bln.' group by departemen'));
        }

        return $totjam;
    }

    public function detailjam(Request $request){
       //dd($request->all());
        $peri = $request->input("period");
        $dept = $request->input("dept");
        $now = Date('Y-m');
        $thn = substr($peri,0,4);
        $bln = substr($peri,5,2);
        if ($peri == $now) {
            $detail = DB::connection('sqlsrv')->select(\DB::raw("select top 5 no_induk_mesin, nama_mesin, jam_menunggu, jam_rusak from v_jam_kerusakan where departemen = '$dept' order by jam_rusak desc"));
           
          }else{
              $detail = DB::connection('sqlsrv')->select(\DB::raw("select top 5 no_induk_mesin, nama_mesin, jam_menunggu, jam_rusak from tb_jamkerusakan where DATEPART(YEAR,tgl_rekap) = '$thn' and DATEPART(MONTH,tgl_rekap)='$bln' and departemen = '$dept' order by jam_rusak desc"));
          }
        return $detail;
    }

    public function postreport(Request $request){
       $tgl1 = $request['tgl1'];
       $tgl2 = $request['tgl2'];

       $rep1 = DB::select("select coalesce(count(*),0) as total from tb_jamkerusakan where DATEPART(YEAR,tgl_rekap) = DATEPART(YEAR,'$tgl1') and DATEPART(MONTH, tgl_rekap) = DATEPART(MONTH,'$tgl1')")[0]->total;
        if ($rep1 > 0) {
           return array(
            'message' => 'Periode report sudah ada !',
            'success'=>false,
        );
        }

        $nomer = DB::select('exec jamkerusakan ?,?,?', array($tgl1, $tgl2, Session::get('name')));
        Session::flash('success','Report berhasil dismpan !'); 
        return array(
            'message' => 'Report berhasil dismpan !',
            'success'=>true,
        );

    }

public function historymesin(Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $no_mesin = $request->input("no_mesin");
   
        $Datas = DB::connection('sqlsrv')->table('tb_perbaikan')
                   ->where('no_induk_mesin',$no_mesin)
                    ->where(function($q) use ($search) {
                        $q->where('masalah','like','%'.$search.'%')
                        ->orWhere('tindakan','like','%'.$search.'%');
                       
                    })
                    ->skip($start)
                    ->take($length)
                    ->orderBy('tanggal_rusak','asc')
                    ->get();
        
        $s = DB::connection('sqlsrv')->table('tb_perbaikan')
        ->where('no_induk_mesin',$no_mesin)
        ->where(function($q) use ($search) {
            $q->where('masalah','like','%'.$search.'%')
            ->orWhere('tindakan','like','%'.$search.'%');
           
        })
        ->get();
        $count = count($s);
    

  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
}

public function partlist(Request $request){
   
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $id_perbaikan = $request->input("id_perbaikan");
   
        $Datas = DB::connection('sqlsrv')->table('tb_parts')
                   ->where('id_perbaikan',$id_perbaikan)
                   ->where(function($q) use ($search) {
                    $q->where('nama_part','like','%'.$search.'%')
                    ->orWhere('item_code','like','%'.$search.'%');
                   
                })
                    ->skip($start)
                    ->take($length)
                    ->get();
        
        $s = DB::connection('sqlsrv')->table('tb_parts')
        ->where('id_perbaikan',$id_perbaikan)
        ->where(function($q) use ($search) {
            $q->where('nama_part','like','%'.$search.'%')
            ->orWhere('item_code','like','%'.$search.'%');
           
        })
        ->get();
        $count = count($s);
    

  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
}

    public function get_schedule(Request $request){
        $id = $request['id_perbaikan'];
        $perb = DB::table('tb_perbaikan')
                ->leftJoin('tb_schedule','tb_perbaikan.id_perbaikan','=','tb_schedule.id_perbaikan')
                ->select('tb_perbaikan.id_perbaikan','tb_schedule.*')
                ->where('tb_perbaikan.id_perbaikan',$id)
                ->first();
        return array(
            "data" => $perb,
            "success" => true,
        );
    }

    public function exceljam(Request $request){
        $now = Date('Y-m');
        $peri = $request->input("periode");
        $thn = substr($peri,0,4);
        $bln = substr($peri,5,2);
       
        if ($peri == $now) {
           
            $Datas = DB::connection('sqlsrv')->table('v_jam_kerusakan')
                        ->orderBy('jam_rusak','desc')
                        ->get();
        }else{
            $Datas = DB::connection('sqlsrv')->table('tb_jamkerusakan')
                     
                        ->whereYear('tgl_rekap','=',$thn)
                        ->whereMonth('tgl_rekap','=',$bln)
                        ->orderBy('jam_rusak','desc')
                        ->get();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','No. Request');
        $sheet->setCellValue('C1','Departemen');
        $sheet->setCellValue('D1','No Mesin');
        $sheet->setCellValue('E1','Nama Mesin');
        $sheet->setCellValue('F1','Klasifikasi');
        $sheet->setCellValue('G1','Status');
        $sheet->setCellValue('H1','Tgl Rusak');
        $sheet->setCellValue('I1','Tgl Mulai Perbaikan');
        $sheet->setCellValue('J1','Tgl Selesai Perbaikan');
        //$sheet->setCellValue('K1','Jam Holiday');
        //$sheet->setCellValue('L1','Jam Kerja');
        $sheet->setCellValue('K1','Jam Menunggu');
        $sheet->setCellValue('L1','Jam Kerusakan');
        //$sheet->setCellValue('O1','Tgl Rekap');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->no_perbaikan);
            $sheet->setCellValue('C'.$line,$data->departemen);
            $sheet->setCellValue('D'.$line,$data->no_induk_mesin);
            $sheet->setCellValue('E'.$line,$data->nama_mesin);
            $sheet->setCellValue('F'.$line,$data->klasifikasi);
            $sheet->setCellValue('G'.$line,$data->status_perbaikan);
            $sheet->setCellValue('H'.$line,$data->tgl_rusak);
            $sheet->setCellValue('I'.$line,$data->tgl_mulai);
            $sheet->setCellValue('J'.$line,$data->tgl_selesai);
           // $sheet->setCellValue('K'.$line,$data->jam_hol);
           // $sheet->setCellValue('L'.$line,$data->jam_kerja);
            $sheet->setCellValue('K'.$line,$data->jam_menunggu);
            $sheet->setCellValue('L'.$line,$data->jam_rusak);
            //$sheet->setCellValue('O'.$line,$Datas->jam_tgl_rekap);
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "jamkerusakan_".date('YmdHi').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
    }

    public function mtbf(Request $request){
       // dd($request->all());
       $period = $request['periode'];
       $no_mesin = $request['no'];

        $datas = DB::connection('sqlsrv')->select('exec get_mtbf ?,?', array($period, $no_mesin));
        return $datas;
    }

    public function testnotif(){
        $user = UserModel::find(14);

        $details = [
            'no' => '000001',
            'user' => $user->user_name,
        ];
  
        
        $user->notify(new RequestNotif($details));
    }

    public function settarget(Request $request){
        $nik = Session::get('nik');
        $tgl1 = Carbon::parse($request->input("tgl1"));
        $tgl2 = Carbon::parse($request->input("tgl2"));
        $diff = $tgl1->diffInMonths($tgl2);
        $proc_cd = "jam_kerusakan";
       
        $proc_name = $request->input("departemen");
        $target = $request->input("target");

        //dd($tgl1);
        if ($diff == 0) {
            $exist = TargetModel::select('target','periode')->whereYear("periode",$tgl1->year)->whereMonth("periode",$tgl1->month)->where("process_cd",$proc_cd)->where("process_name",$proc_name)->get();
           //dd($exist);
            if ($exist->count() > 0) {
              return array(
                "success" => false,
                "message" => "Target sudah ada",
                "periode" => $exist[0]->periode,
                "target_before" => $exist[0]->target,
                
              );
            }

            TargetModel::create([
                "process_cd"=>$proc_cd,
                "process_name"=>$proc_name,
                "target"=>$target,
                "periode"=>$tgl1,
              ]);
              return array(
                "success" => True,
                "message" => "Setting target berhasil",
                
              );
        }else{
           
            for ($i=0; $i <= $diff ; $i++) { 
                //$t = $tgl1;
               $period = $tgl1;
               $exist = TargetModel::select('target','periode')->whereYear("periode",$period->year)->whereMonth("periode",$period->month)->where("process_cd",$proc_cd)->where("process_name",$proc_name)->get();
           
                if ($exist->count() > 0) {
                return array(
                    "success" => false,
                    "message" => "Target sudah ada",
                    "periode" => $exist[0]->periode,
                    "target_before" => $exist[0]->target,
                );
                }
               TargetModel::create([
                "process_cd"=>$proc_cd,
                "process_name"=>$proc_name,
                "target"=>$target,
                "periode"=>$period,
              ]);

              $period = $tgl1->addMonths(1);
            }
            return array(
                "success" => True,
                "message" => "Setting target berhasil",
                
              );
           // dd($diff,$w);
        }

   }

   public function addprogram(Request $request){
    //dd($request->all());
    $no_mesin = $request->input("no-mesin");
    $mesin = MesinModel::where("no_induk",'=',$no_mesin)->first();
    $tgl = Date('Y-m-d');
    if ($mesin->count()<=0) {
        Session::flash('alert-danger','Nomer Mesin Salah !'); 
        return redirect()->route('mesin');
    }
    if ($request->hasFile('file_prog')) {
        $file_name = $mesin->no_induk.'_'.$tgl.'.'.$request->file('file_prog')->getClientOriginalExtension();
        $request->file('file_prog')->move(public_path("storage/NPMI_PLC_PROGRAMS/".$mesin->no_induk),$file_name);
       // dd($file_name);
       $inserted = ProgramModel::create([
                    'record_id'=>Str::uuid(),
                    'no_induk_mesin'=>$mesin->no_induk,
                    'nama_file'=>$file_name,
                    'type_plc'=>$request->input("type-plc"),
                    'tgl_update'=>$tgl,
                    'link_file'=>$file_name,
                    'keterangan'=>$request->input("ket_prog"),
                    'user_name'=>Session::get('name'),
                ]);
    }
    Session::flash('success','Tambah Data berhasil !'); 
    return redirect()->route('mesin');

   }

   public function listprog(Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
  
    $Datas = DB::select("select T.record_id, T.no_induk_mesin,T.type_plc, T.tgl_update, T.user_name, T.keterangan, b.nama_mesin, b.no_urut from 
                        (select record_id, no_induk_mesin,type_plc, tgl_update, user_name, keterangan, ROW_NUMBER() over(partition by no_induk_mesin order by tgl_update desc) as rn from tb_program) as T 
                        left join tb_mesin as b on t.no_induk_mesin = b.no_induk where T.rn = 1 and (T.no_induk_mesin like '%$search%' or b.nama_mesin like '%$search%') order by T.tgl_update asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

    $count = DB::select("select count(*) as total from(select T.record_id, T.no_induk_mesin,T.type_plc, T.tgl_update, T.user_name, T.keterangan, b.nama_mesin, b.no_urut from 
                        (select record_id, no_induk_mesin,type_plc, tgl_update, user_name, keterangan, ROW_NUMBER() over(partition by no_induk_mesin order by tgl_update desc) as rn from tb_program) as T 
                        left join tb_mesin as b on t.no_induk_mesin = b.no_induk where T.rn = 1 and (T.no_induk_mesin like '%$search%' or b.nama_mesin like '%$search%'))a")[0]->total;
    
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
   }

   public function getlist_prog(Request $request){
       $noinduk = $request->input("no_induk");
       $datas = ProgramModel::select('link_file','tgl_update','keterangan')->where('no_induk_mesin',$noinduk)->get();
       if ($datas->count()>0) {
       
           return array(
            "success" => True,
            "data" => $datas,
            
          );
       }
       return array(
        "success" => False,
        "message" => "Data tidak ditemukan !",
        
      );

   }

   public function download_prog($id, $file){
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

    if ($user->departemen == 'MAINTENANCE' || $user->departemen == 'Admin') {
       
        return array(
            "url" => url("/")."/storage/NPMI_PLC_PROGRAMS/".$id.'/'.$file,
            "success" => true,
        );
    }

    return array(
        "success" => false,
        "message" => "Anda tidak memiliki ijin akses !",
    );
      
   }
   
}
