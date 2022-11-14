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
use App\LogModel;
use App\HHModel;
use App\EvaluasiModel;
use App\TindakanModel;
use App\ ClosingHHKYModel;
use PDF;
use App\Traits\CheckStatus;

class HSEController extends Controller
{
    use CheckStatus;
    public function importexcel_hh(Request $request){
        if ($request->hasFile('import_file_hh')) {
            $path = $request->file('import_file_hh')->getRealPath();
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $Data = $reader->load($path);
            $sheetdata = $Data->getActiveSheet()->toArray(null, true, true, true);
             unset($sheetdata[1]);
           
            $gagal = 0;
            $list = array ();
            foreach ($sheetdata as $row) {
            $cek = HHModel::where('no_laporan','=',$row['A'])->count();
                //dd($row['B']);
                
                if ($cek > 0){
                    $gagal =  $gagal + 1;
                    array_push($list,$row['A']);
                }else{
                    HHModel::create([
                    'id_hhky'=>Str::uuid(),
                    'no_laporan'=>$row['A'],
                    'status_laporan'=>$row['B'],
                    'tgl_lapor'=>$row['C'],
                    'jenis_laporan'=>$row['D'],
                    'nama'=>$row['E'],
                    'nik'=>$row['F'],
                    'bagian'=>$row['G'],
                    'tgl_kejadian'=>$row['H'],
                    'tempat_kejadian'=>$row['I'],
                    'pada_saat'=>$row['J'],
                    'menjadi'=>$row['K'],
                    'solusi_perbaikan'=>$row['L'],
                    'keterangan'=>$row['M'],
                    ]);
                }
            }

            if ($gagal > 0){
               $pesan = implode(",",$list);
                Session::flash('alert-danger','Error No HH/KY sudah ada : '.$pesan);     
            }else{

                Session::flash('alert-success','Import data berhasil'); 
            }
            return redirect()->route('tools');
         }
    }

    public function f_hhky (){
        $nomerinduk = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama','dept_group','dept_section')->get();
        $jenis = DB::table('tb_proses')->select('p_hhky')->where('p_hhky','!=',null)->groupBy('p_hhky')->get();
        return view ('hse/f_hhky',['nomerinduk'=>$nomerinduk, 'jenis'=>$jenis]);
    }

    public function hklist (){
        $jenis = DB::table('tb_proses')->select('p_hhky')->where('p_hhky','!=',null)->groupBy('p_hhky')->get();
        return view ('hse/hklist',['jenis'=>$jenis]);
    }

    public function hhkydetail ($id){
        //dd($id);
        $detail = HHModel::find($id);
        //dd($detail);
        $eval = EvaluasiModel::where('id_hhky','=',$id)->where('jenis_evaluasi','=','Before')->get();
        //dd($eval);
        //$user = UserModel::find($detail->informer);
        $tindakan = EvaluasiModel::where('id_hhky','=',$id)->where('jenis_evaluasi','<>','Before')->orderBy('created_at','desc')->get();
        //dd($tindakan);
        $setatus = $this->cekstatus($id);

        return view ('hse/hkdetail',['detail'=>$detail, 'status'=>$setatus, 'tindakan'=>$tindakan,'eval'=>$eval]);
    }

    public function entry_hhky (Request $request){
        //dd($request->all());
        $id = Str::uuid();
        $nik = $request->input("nonik");
        $dept1 = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama','dept_group','dept_section')->where('nik','=',$nik)->first();
        //dd($dept1);

        $nolap = $request->input('no_laporan');
        $cek = HHModel::select('no_laporan')->where('no_laporan',$nolap)->first();
      
        $anyar = $this->no_hhky($request->tgl_kejadian);

        if ($cek > 0){
            $insert1 = $anyar;
        } else {
            $insert1= $request->no_laporan;
        }
            $insertHH = HHModel::create([
                'id_hhky'=>$id,
                'no_laporan'=>$insert1,
                'status_laporan'=>'Open',
                'tgl_lapor'=>$request->tgl_kejadian,
                'jenis_laporan'=>$request->jenis_laporan,
                'nama'=>$dept1->nama,
                'nik'=>$request->nonik,
                'bagian'=>$dept1->dept_section,
                'tgl_kejadian'=>$request->tgl_kejadian,
                'tempat_kejadian'=>$request->tempat_kejadian,
                'pada_saat'=>$request->pada_saat,
                'menjadi'=>$request->menjadi,
                'solusi_perbaikan'=>$request->solusi_perbaikan,
                'penyebab'=>$request->penyebab,
                'foto_kondisi'=>$request->foto_kondisi,
                'keterangan'=>$request->keterangan,
            ]);

    
            $insertEvaluasi = EvaluasiModel::Create([
                'id_evaluasi'=>Str::uuid(),
                'id_hhky'=>$insertHH['id_hhky'],
                'jenis_evaluasi'=>'Before',
                'severity'=>$request->severity_1,
                'frekwensi'=>$request->frekwensi_1,
                'possibility'=>$request->possibility_1,
                'point'=>$request->poin_1,
                'level_resiko'=>$request->rank_1,
                'tindakan'=>$request->tindakan,
                'status_tindakan'=>'Open',
                'tgl_evaluasi'=>$request->tgl_evaluasi,
                'evaluator'=>$request->evaluator,
            ]);
        
    
         if ($insertHH) {
            if ($request->hasFile('foto_kondisi')) {
                $this->validate($request,['gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
                $file_name = $id.'.'.$request->file('foto_kondisi')->getClientOriginalExtension();
               $request->file('foto_kondisi')->move(public_path("storage/img/hk/"),$file_name);
               
               
                HHModel::where('id_hhky',$id)
                      ->update(['foto_kondisi'=>$file_name]);
            }
                Session::flash('alert-success','Tambah Data berhasil !'); 
            }else {
              Session::flash('alert-danger','Tambah Data gagal !'); 
            }
            return redirect()->route('form_hhky'); 
    }

    public function no_hhky($tgl){
        $nomer = DB::connection('sqlsrv')->select('exec nomer_hhky ?', array($tgl));
        return $nomer;
    }

    public function get_nomer (Request $request){
        //dd($request->all());
        $tanggal = date('Y-m-d');
        $nomer = $this->no_hhky($tanggal);
        return $nomer;
    }

    public function hkinquery(Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $status_hk1 = $request->input("status_hk");
        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir").' '.'23:59:59';
        $jenis_hk = $request->input("jenis_hk");

        //$datahk = DB::table('tb_hhky')->where('tgl_lapor','>=',$tgl_awal)->where('tgl_lapor','<=',$tgl_akhir)->get();
        $datahk = DB::table('tb_hhky')->select('status_laporan')->groupBy('status_laporan')->get();
        //dd($datahk);
        $listdatahk= array();

        if ($status_hk1 == "All") {
            foreach ($datahk as $key) {
                array_push($listdatahk,$key->status_laporan);
            }
            }else {
            foreach ($datahk as $key) {
                array_push($listdatahk, $status_hk1);
            }
        } 

        $jenis = DB::table('tb_hhky')->select('jenis_laporan')->groupBy('jenis_laporan')->get();
        $listjenishk= array();

        if ($jenis_hk == "All") {
            foreach ($jenis as $key) {
                array_push($listjenishk,$key->jenis_laporan);
            }
            }else {
            foreach ($jenis as $key) {
                array_push($listjenishk, $jenis_hk);
            }
        } 

        //dd($listjenishk);
        $Datas = DB::table('tb_hhky')->where('tgl_lapor','>=',$tgl_awal)->where('tgl_lapor','<=',$tgl_akhir)->whereIn('status_laporan',$listdatahk)->whereIn('jenis_laporan',$listjenishk)     
        ->where(function($q) use ($search) {
            $q->where('nama','like','%'.$search.'%')
            ->orWhere('no_laporan','like','%'.$search.'%')
              ->orWhere('nik','like','%'.$search.'%')
              ->orwhere('bagian','like','%'.$search.'%')
              ->orwhere('jenis_laporan','like','%'.$search.'%')
              ->orwhere('tempat_kejadian','like','%'.$search.'%');
        })    
        ->orderBy('created_at', 'desc')  
        ->skip($start)
        ->take($length)
        ->get();


        $count = DB::table('tb_hhky')->where('tgl_lapor','>=',$tgl_awal)->where('tgl_lapor','<=',$tgl_akhir)->whereIn('status_laporan',$listdatahk)->whereIn('jenis_laporan',$listjenishk)
        ->where(function($q) use ($search) {
            $q->where('nama','like','%'.$search.'%')
            ->orWhere('no_laporan','like','%'.$search.'%')
              ->orWhere('nik','like','%'.$search.'%')
              ->orwhere('bagian','like','%'.$search.'%')
              ->orwhere('jenis_laporan','like','%'.$search.'%')
              ->orwhere('tempat_kejadian','like','%'.$search.'%');
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

    public function addtindakan(Request $request){
        //dd($request->all());
        $user = UserModel::find(Session::get('id'));
        $nomorhh = HHModel::find($request['id_hhky']);
         //dd($nomorhh->status_laporan);
 
         if ($nomorhh->status_laporan == 'Open') {
            $id_evaluasi = Str::uuid();
             $tindakan = EvaluasiModel::create([
                 'id_evaluasi'=>$id_evaluasi,
                 'id_hhky'=>$nomorhh->id_hhky,
                 'jenis_evaluasi'=>$request->jenis_evaluasi,
                 'tindakan'=>$request->tindakan,
                 'tgl_evaluasi'=>$request->tgl_evaluasi,
                 'evaluator'=>$request->evaluator,
                 'severity'=>$request->severity,
                 'frekwensi'=>$request->frekwensi,
                 'possibility'=>$request->possibility,
                 'point'=>$request->poin1,
                 'level_resiko'=>$request->rank1
     
             ]);
             if ($tindakan) {
               $nomorhh->status_laporan = 'Open';
               $nomorhh->save();
             }
 
             $details = [
                 'id_evaluasi' => $id_evaluasi,
                 'id_hhky' =>$nomorhh->id_hhky,
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

    public function get_tindakan($id){
        //dd($id);
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $tindakan = EvaluasiModel::find($id);

        //dd($tindakan);
    
        if ($user->departemen == 'Admin' || $user->departemen == 'HSE') {
           
            return array(
                'data'=>$tindakan,
                'message' => 'Ambil data berhasil...',
                'success'=>true
            );
        }else{
            return array(
                'message' => 'Ambil data Gagal !',
                'success'=>false
            );
        }
    
    }

    public function get_tindakan_point($id){
        //dd($id);
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $tindakan = EvaluasiModel::find($id);

        //dd($user->departemen);
    
        if ($user->departemen == 'Admin' || $user->departemen == 'HSE') {
           
            return array(
                'data'=>$tindakan,
                'message' => 'Ambil data berhasil',
                'success'=>true
            );
        }else{
            return array(
                'message' => 'Ambil data Gagal !',
                'success'=>false
            );
        }
    
       }

       public function update_masalah(Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        
        $req = HHModel::find($request['id_hhky']);
        $details =[
            'id_hhky'=>$request['id_hhky'],
        ];
       
        if ($dept == "Admin" || $dept == 'HSE') {
                $req->tempat_kejadian = $request['edit_tempat_kejadian'];
                $req->pada_saat = $request['edit_pada_saat'];
                $req->menjadi = $request['edit_menjadi'];
                $req->solusi_perbaikan = $request['edit_solusi_perbaikan'];

            if ($req->isDirty('lokasi')) {
                $details['lokasi'] = $request['edit_lokasi'];
            }
            if ($req->isDirty('pada_saat')) {
                $details['pada_saat']=$request['edit_pada_saat'];
            }

            if ($req->isDirty('menjadi')) {
               $details['menjadi'] = $request['edit_menjadi'];
            }
            if ($req->isDirty('solusi_perbaikan')) {
                $details['solusi_perbaikan'] = $request['edit_solusi_perbaikan'];
             }


                $req->save();
        
                $status = true;
                $mess = "Update data berhasil";

                
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $details,
        ];

        LogModel::create($data);

        }else {
            $status = false;
            $mess = "Update data gagal !";
          
        }

      
        return array(
            'message' => $mess,
            'success'=>$status
        );
    }

    public function updtindakan(Request $request){
        //dd($request->all());
        $user = UserModel::find(Session::get('id'));
        
        if ($request->has('id_evaluasi')) {
            $tindakan = EvaluasiModel::find($request['id_evaluasi']);
        }else{
            $tindakan = EvaluasiModel::find($request['id_evaluasi2']);
        }
        
        //
        $hhky = HHModel::find($tindakan->id_hhky);
        $id_m = $tindakan->id_hhky;
        $details =[
            'id_evaluasi'=>$request['id_evaluasi'],
        ];
        
        //dd($jenisb);
        
       
         $stat = false;
         $mess = 'Update data gagal !';
        if ($user->departemen == 'Admin' || $user->departemen == 'HSE') {
           $tindakan->tindakan = $request['edit_evaluasi'];
           $tindakan->tgl_evaluasi = $request['edit_tgl_evaluasi'];
           $tindakan->evaluator = $request['edit_evaluator'];
           $tindakan->status_tindakan = $request['edit_status_tindakan'];
            
           if ($tindakan->jenis_evaluasi == 'Before'){
                $tindakan->severity = $request['eseverity'];
                $tindakan->frekwensi = $request['efrekwensi'];
                $tindakan->possibility = $request['epossibility'];
                $tindakan->point = $request['epoin1'];
                $tindakan->level_resiko = $request['erank1'];
            } else {
                $tindakan->severity = $request['tseverity'];
                $tindakan->frekwensi = $request['tfrekwensi'];
                $tindakan->possibility = $request['tpossibility'];
                $tindakan->point = $request['tpoin1'];
                $tindakan->level_resiko = $request['trank1'];
            }

           if ($tindakan->jenis_evaluasi == 'After'){
            $upd = DB::table('tb_evaluasi')->select('id_evaluasi')->where('id_hhky',$id_m)->update(['status_tindakan'=> $request['edit_status_tindakan'],]);
            $upd1 = DB::table('tb_hhky')->where('id_hhky',$id_m)->update(['status_laporan'=>$request['edit_status_tindakan'],]);
        }

         //$tindakan->tgl_selesai = $request['tgl_selesai'];
           if($tindakan->isDirty('tindakan')){
               $details['tindakan'] = $request['edit_tindakan'];
           }
           if($tindakan->isDirty('tgl_evaluasi')){
              $details['tgl_evaluasi']= $request['edit_tgl_evaluasi'];
           }
           if($tindakan->isDirty('evaluator')){
               $details['evaluator']= $request['edit_evaluator'];
           }
           if($tindakan->isDirty('status_tindakan')){
               $details['status_tindakan']=  $request['edit_status_tindakan'];
           }

           if ($request['edit_status_tindakan'] == 'Close') {
                $tindakan->tgl_evaluasi = now();
           }else{
                $tindakan->tgl_evaluasi = $request['edit_tgl_evaluasi'];
            }

 
 
         if ($request->hasFile('lampiran')) {
            
             $file_name = $tindakan->id_evaluasi.'.'.$request->file('lampiran')->getClientOriginalExtension();
            $request->file('lampiran')->move(public_path("storage/img/hk/"),$file_name);
            
             $tindakan->lampiran = $file_name;
           
         }
         
 
           $tindakan->save();

           $setatus = $this->cekstatus($id_m);
 
           $hhky->status_laporan = $setatus['status'];
 
           if ($hhky->isDirty('status_laporan')) {
               $hhky->save();
               $details['id_hhky']= $id_m;
               $details['status_laporan']= $setatus['status'];
           }
           $stat = true;
           $mess = 'Update data berhasil !';
 
           $data = [
             'record_no' => Str::uuid(),
             'user_id' => $user->id,
             'activity' =>"update",
             'message' => $details,
         ];
         LogModel::create($data);
 
         Session::flash('alert-success',$mess);
        }
        Session::flash('alert-danger',$mess);
        return array(
             'success' => $stat,
             'message' => $mess,
        );
    }

    function cekstatus($id_hhky){
        $total = EvaluasiModel::where('id_hhky','=',$id_hhky)->where('jenis_evaluasi','<>','Before')->count();
        $status = 'Open';
        $persen = 0;
        $close = 0;
        if ($total > 0) {
           $close = EvaluasiModel::where('id_hhky','=',$id_hhky)->where('jenis_evaluasi','<>','Before')->where('status_tindakan','=','Close')->count();
            if ($total == $close) {
               $status = 'Close';
            }
            $persen = $close / $total;
        }
       
        return array(
            'status'=>$status,
            'persen' =>$persen,
            'close'=>$close,
            'total'=>$total,
        ); 
   }

    public function deltindakan(Request $request){
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $tindakan = EvaluasiModel::find($request['id']);
    $hhky = HHModel::find($tindakan->id_hhky);

    if ($user->departemen == 'Admin' || $user->departemen == 'HSE') {
        $file = $tindakan->lampiran;
        
        $tindakan->delete();
            if (!empty($file)) {
                $dir = public_path()."/storage/img/hk/";
                $path = $dir.$file;
                //fclose($path);
                unlink($path);
            }
        $setatus = $this->cekstatus($hhky->id_hhky);
        
        $hhky->status_laporan = $setatus['status'];
        $hhky->save();

        $details = [
            'id_evaluasi' => $request['id'],
            'id_hhky' =>$hhky->id_hhky,
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"delete",
           
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => 'Hapus data berhasil !',
            'success'=>true
        );
    }else{
        return array(
            'message' => 'Hapus data gagal !',
            'success'=>false
        );
    }
   }

    public function del_hhky(Request $request){
        //$token = $request->header('token_req');
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        //$id = Session::get('id');
        $req = HHModel::find($request['id']);

        
        if ($dept == "Admin" || $dept == 'HSE') {
            $tindakan = EvaluasiModel::where('id_hhky','=',$req->id_hhky)->get();
            
            foreach ($tindakan as $p) {
            
            $file = $p->lampiran;
            if (!empty($file)) {
                $dir = public_path()."/storage/img/hk/";
                $path = $dir.$file;
                //fclose($path);
                unlink($path);
            }
            }
        
            $req->delete();
            
            
        $status = true;
        $mess = "Delete berhasil";
            //Session::flash('alert-success','Hapus Request berhasil !'); 
        } else {
            $mess = "Delete gagal";
            $status = false;
            //Session::flash('alert-danger','Hapus Request gagal !');
        }
        $details = [
            'id_req' => $request['id'],
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

    public function hhkygrafik(){
        return view ('hse/hhgrafik');
    }

    public function grafikpie(Request $request){
        $tgl1 = $request->input("tgl1");
        $tgl2 = $request->input('tgl2').' '.'23:59:59';

      $dept = DB::select("select t1.bagian, t2.jml as HH ,t3.jml as KY, t4.jml as SM from 
      (select bagian from tb_hhky group by bagian)t1
      left join
      (select bagian, count(jenis_laporan) as jml from tb_hhky where jenis_laporan = 'HH' and created_at >='$tgl1' and created_at <= '$tgl2' group by bagian, jenis_laporan)t2 on t1.bagian = t2.bagian
      left join 
      (select bagian, count(jenis_laporan) as jml from tb_hhky where jenis_laporan = 'KY' and created_at >='$tgl1' and created_at <= '$tgl2' group by bagian, jenis_laporan)t3 on t1.bagian = t3.bagian
      left join 
      (select bagian, count(jenis_laporan) as jml from tb_hhky where jenis_laporan = 'SM' and created_at >='$tgl1' and created_at <= '$tgl2' group by bagian, jenis_laporan)t4 on t1.bagian = t4.bagian");

        return $dept;
    }

    public function grafikbar(Request $request){
        $tgl1 = $request->input("tgl1");
        $tgl2 = $request->input('tgl2').' '.'23:59:59';
        //dd($tgl2);

        $level = DB::select("select t1.jenis_laporan, isnull((t2.jml),0) as Open1 ,isnull((t3.jml1),0) as Close1, (isnull((t2.jml),0) + isnull((t3.jml1),0)) as Alltotal from 
        (select jenis_laporan from tb_hhky group by jenis_laporan)t1
        left join
        (select jenis_laporan, count(status_laporan) as jml from tb_hhky where status_laporan = 'Open' and created_at >='$tgl1' and created_at <= '$tgl2' group by status_laporan, jenis_laporan)t2 on t1.jenis_laporan = t2.jenis_laporan
        left join 
        (select jenis_laporan, count(status_laporan) as jml1 from tb_hhky where status_laporan = 'Close' and created_at >='$tgl1' and created_at <= '$tgl2' group by status_laporan, jenis_laporan)t3 on t1.jenis_laporan = t3.jenis_laporan");
  
        //dd($level);
        return $level;
    }

    public function grafikbar2(Request $request){
        $tgl1 = $request->input("tgl1");
        $tgl2 = $request->input('tgl2').' '.'23:59:59';

        $resiko = DB::select("select t1.level_resiko, isnull((t2.jml),0) as Open1 ,isnull((t3.jml),0) as Close1, (isnull((t2.jml),0) + isnull((t3.jml),0)) as Alltotal from 
        (select level_resiko from tb_evaluasi group by level_resiko)t1
        left join
        (select level_resiko, count(status_tindakan) as jml from tb_evaluasi where status_tindakan = 'Open' and created_at >='$tgl1' and created_at <= '$tgl2' group by status_tindakan, level_resiko)t2 on t1.level_resiko = t2.level_resiko
        left join 
        (select level_resiko, count(status_tindakan) as jml from tb_evaluasi where status_tindakan = 'Close' and created_at >='$tgl1' and created_at <= '$tgl2' group by status_tindakan, level_resiko)t3 on t1.level_resiko = t3.level_resiko");
 
        //dd($dept);
        return $resiko;
    }

    public function get_hseexcel (Request $request){
        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $status_hk = $request->input("status_hk");
        $jenis_hk = $request->input("jenis_hk");

        $datahk = DB::table('tb_hhky')->select('status_laporan')->groupBy('status_laporan')->get();
        //dd($datahk);
        $listdatahk= array();

        if ($status_hk == "All") {
            foreach ($datahk as $key) {
                array_push($listdatahk,$key->status_laporan);
            }
            }else {
            foreach ($datahk as $key) {
                array_push($listdatahk, $status_hk);
            }
        } 

        $jenis = DB::table('tb_hhky')->select('jenis_laporan')->groupBy('jenis_laporan')->get();
        $listjenishk= array();

        if ($jenis_hk == "All") {
            foreach ($jenis as $key) {
                array_push($listjenishk,$key->jenis_laporan);
            }
            }else {
            foreach ($jenis as $key) {
                array_push($listjenishk, $jenis_hk);
            }
        } 
        
        $Datas = DB::table('tb_hhky')->select('no_laporan','tgl_lapor','nama','nik','tempat_kejadian','pada_saat','menjadi','solusi_perbaikan')
        ->where('tgl_lapor','>=',$tgl_awal)->where('tgl_lapor','<=',$tgl_akhir)->whereIn('status_laporan',$listdatahk)->whereIn('jenis_laporan',$listjenishk)->get();

        if (count($Datas) > 0) {
       
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1','No');
            $sheet->setCellValue('B1','No HH/KY');
            $sheet->setCellValue('C1','Tanggal Lapor');
            $sheet->setCellValue('D1','Nama');
            $sheet->setCellValue('E1','Nik');
            $sheet->setCellValue('F1','Tmp Kejadian');
            $sheet->setCellValue('G1','Pada Saat');
            $sheet->setCellValue('H1','Menjadi');
            $sheet->setCellValue('I1','Solusi');
            
            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A'.$line,$no++);
                $sheet->setCellValue('B'.$line,$data->no_laporan);
                $sheet->setCellValue('C'.$line,$data->tgl_lapor);
                $sheet->setCellValue('D'.$line,$data->nama);
                $sheet->setCellValue('E'.$line,$data->nik);
                $sheet->setCellValue('F'.$line,$data->tempat_kejadian);
                $sheet->setCellValue('G'.$line,$data->pada_saat);
                $sheet->setCellValue('H'.$line,$data->menjadi);
                $sheet->setCellValue('I'.$line,$data->solusi_perbaikan);
            
                $line++;
            }
            
            $writer = new Xlsx($spreadsheet);
            $filename = "HSE_".$jenis_hk."_"."$status_hk"."_".date('YmdHis').".xlsx";
            $writer->save(public_path("storage/excel/".$filename));
            return ["file"=>url("/")."/storage/excel/".$filename,
            "message"=>"Berhasil Export Data .",
                    "success"=>true];
            
                } else {
                    return ["message"=>"No Data", "success"=>false];
                }
    }

    public function hhkyrekap (){
        return view ('hse/reportjapan');
    }

    public function hhkyrekapmonth (Request $request){

        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $selectjenis = $request->input("selectjenis");

            $list = DB::select("SELECT year, jenis_laporan, status_laporan, isnull(([1]),0) as m1, isnull(([2]),0) as m2, isnull(([3]),0) as m3, isnull(([4]),0) as m4, isnull(([5]),0) as m5, isnull(([6]),0) as m6, isnull(([7]),0) as m7, isnull(([8]),0) as m8, isnull(([9]),0) as m9, isnull(([10]),0) as m10, isnull(([11]),0) as m11, isnull(([12]),0) as m12 FROM (
                SELECT year(periode) year, month(periode) month, jenis_laporan, status_laporan, count(status_laporan) as jml
                FROM tb_closing_hhky
                WHERE jenis_laporan = '$selectjenis' and periode >= '$tgl_awal' AND periode <= '$tgl_akhir' GROUP BY jenis_laporan, periode, status_laporan
              ) p
              PIVOT(
                sum(jml)
                FOR month in (
                   [1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12]
                )
              ) t1
              ORDER BY t1.year, t1.jenis_laporan, t1.status_laporan DESC");

            $listclose = DB::select("SELECT year, jenis_laporan, status_laporan, isnull(([1]),0) as m1, isnull(([2]),0) as m2, isnull(([3]),0) as m3, isnull(([4]),0) as m4, isnull(([5]),0) as m5, isnull(([6]),0) as m6, isnull(([7]),0) as m7, isnull(([8]),0) as m8, isnull(([9]),0) as m9, isnull(([10]),0) as m10, isnull(([11]),0) as m11, isnull(([12]),0) as m12 FROM (
                SELECT year(periode) year, month(periode) month, jenis_laporan, status_laporan, count(status_laporan) as jml
                FROM tb_closing_hhky
                WHERE jenis_laporan = '$selectjenis' and periode >= '$tgl_awal' AND periode <= '$tgl_akhir' and status_laporan = 'Close' GROUP BY jenis_laporan, periode, status_laporan
            ) p
            PIVOT(
                sum(jml)
                FOR month in (
                [1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12]
                )
            ) t1
            ORDER BY t1.year, t1.jenis_laporan, t1.status_laporan DESC");



        return array ( "list"=>$list, "listclose"=>$listclose);
    }

    public function hhkyrekaplevel (Request $request){

        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $selectjenis = $request->input("selectjenis");

            $listlevel = DB::select("SELECT year, level_resiko, status_laporan, isnull(([1]),0) as m1, isnull(([2]),0) as m2, isnull(([3]),0) as m3, isnull(([4]),0) as m4, isnull(([5]),0) as m5, isnull(([6]),0) as m6, isnull(([7]),0) as m7, isnull(([8]),0) as m8, isnull(([9]),0) as m9, isnull(([10]),0) as m10, isnull(([11]),0) as m11, isnull(([12]),0) as m12 FROM (
                SELECT year(periode) year, month(periode) month, level_resiko, count(level_resiko) as jml, status_laporan
                FROM tb_closing_hhky
                WHERE periode >= '$tgl_awal' and periode <= '$tgl_akhir' and level_resiko >= 'III' GROUP BY level_resiko, periode, status_laporan
            ) p
            PIVOT(
                sum(jml)
                FOR month in (
                [1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12]
                )
            ) t1
            ORDER BY t1.year, t1.level_resiko, t1.status_laporan DESC");

            $listlevelclose = DB::select("SELECT year, level_resiko, status_laporan, isnull(([1]),0) as m1, isnull(([2]),0) as m2, isnull(([3]),0) as m3, isnull(([4]),0) as m4, isnull(([5]),0) as m5, isnull(([6]),0) as m6, isnull(([7]),0) as m7, isnull(([8]),0) as m8, isnull(([9]),0) as m9, isnull(([10]),0) as m10, isnull(([11]),0) as m11, isnull(([12]),0) as m12 FROM (
                SELECT year(periode) year, month(periode) month, level_resiko, count(level_resiko) as jml, status_laporan
                FROM tb_closing_hhky
                WHERE periode >= '$tgl_awal' and periode <= '$tgl_akhir' and level_resiko >= 'III' and status_laporan = 'Close' GROUP BY level_resiko, periode, status_laporan
            ) p
            PIVOT(
                sum(jml)
                FOR month in (
                [1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12]
                )
            ) t1
            ORDER BY t1.year, t1.level_resiko, t1.status_laporan DESC");



        return array ( "listlevel"=>$listlevel, "listlevelclose"=>$listlevelclose);
    }

    public function closing_hhky (Request $request){
        //dd($request->all());
        $periode_awal = $request->input("periode_awal").'-01';
        $periode_akhir = Carbon::createFromFormat('yy-m-d', $periode_awal)->format('Y-m-t');
        
        
        $Datas = DB::select("SELECT t2.id_hhky as id_hhky , t2.status_laporan , t2.jenis_laporan , t3.level_resiko from
        (SELECT id_hhky, status_laporan, jenis_laporan from tb_hhky where tgl_lapor >= '$periode_awal' and tgl_lapor <= '$periode_akhir' and jenis_laporan != 'AP' and jenis_laporan != 'SM')t2
        left join
        (select id_hhky, level_resiko from tb_evaluasi WHERE jenis_evaluasi ='Before')t3 on t3.id_hhky = t2.id_hhky");
        //dd($Datas);

        $total = count($Datas);

            $id_hhky = array();
            foreach ($Datas as $key) {
                array_push($id_hhky,$key->id_hhky);
            }

            $status_laporan = array();
            foreach ($Datas as $key) {
                array_push($status_laporan,$key->status_laporan);
            }

            $jenis_laporan = array();
            foreach ($Datas as $key) {
                array_push($jenis_laporan,$key->jenis_laporan);
            }

            $level_resiko = array();
            foreach ($Datas as $key) {
                array_push($level_resiko,$key->level_resiko);
            }

        $cek = DB::table('tb_closing_hhky')->select('periode')->where('periode',$periode_akhir)->groupBy('periode')->count();
      
        if ($cek > 0){
            return array(
                'message' => 'Update Gagal, Periode tsb sudah dilakukan Closing HH KY !',
                'success' => false,
            );
        }

        if ($total > 0){
            for ($i=0; $i<$total; $i++){
                $idclosing = Str::uuid();
                ClosingHHKYModel::create([
                'id_closing_hhky'=> $idclosing,
                'id_hhky' => $id_hhky[$i],
                'periode' => $periode_akhir,
                'jenis_laporan' => $jenis_laporan[$i],
                'status_laporan' => $status_laporan[$i],
                'level_resiko' => $level_resiko[$i],
                ]); 
            }
            return array(
                'message' => 'Closing HH / KY Berhasil !',
                'success' => true,
              );
        } else {
                return array(
                    'message' => 'Update Gagal, tidak ada Data untuk di Closing !',
                    'success' => false,
                );
        }
    }


}
