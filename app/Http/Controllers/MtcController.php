<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\LogModel;
use App\PerbaikanModel;
use App\UserModel;
use App\OperatorMtcModel;
use App\PartsModel;
use App\ScheduleModel;
use App\AnalisModel;
use App\Notifications\RequestNotif;
use Illuminate\Support\Facades\Notification;

class MtcController extends Controller
{
   public function getrequest(Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $token = apache_request_headers();
    $stat = $request->input("stat_req");
    //$user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $cond = array();
    if ($stat == 'all') {
        array_push($cond,"process");
        array_push($cond,"open");
        array_push($cond,"selesai");
        array_push($cond,"pending");
        array_push($cond,"scheduled");
    }else if($stat == 'pending'){
        array_push($cond,"pending");
        array_push($cond,"scheduled");
    }else{
        array_push($cond,$stat);
    }

    $ids = join("','",$cond);
   //dd($ids);
    $Datas = DB::connection('sqlsrv')->select("SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, klasifikasi, tanggal_selesai, no_urut_mesin,lapor_ppic, status,p3.user_name, operator = STUFF((SELECT N', ' + nama 
    FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
     WHERE p2.id_perbaikan = p.id_perbaikan
     
     ORDER BY p.tanggal_rusak
     FOR XML PATH(N'')), 1, 2, N'')
  FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p
  left join
  (select id, user_name from tb_user) AS p3 on p.user_id = p3.id
  where p.status in ('$ids') and (p.masalah like '%$search%' or p.nama_mesin like '%$search%' or p.no_induk_mesin like '%$search%')
  group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin,no_urut_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, klasifikasi, tanggal_selesai,lapor_ppic, status, p3.user_name
  ORDER BY tanggal_rusak OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

    
    $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT * FROM tb_perbaikan AS p where p.status in ('$ids') and (p.masalah like '%$search%' or p.nama_mesin like '%$search%' or p.no_induk_mesin like '%$search%'))a")[0]->total;
 

  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
   }

   public function getclose(Request $request){
   
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $token = apache_request_headers();
  
    $awal = date('Y-m-d H:i:s',strtotime($request->input("tgl_awal")));
   
    $p = date_create($request->input("tgl_akhir"));
    $a = $p->modify('+1 day');
    $ak = $a->modify('-1 second');
    $akhir = $ak->format('Y-m-d H:i:s');
  
    $Datas = DB::connection('sqlsrv')->select("SELECT p.id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan,no_urut_mesin, tanggal_selesai, klasifikasi, total_jam_kerusakan, ISNULL(( p3.jml),0) + ISNULL(( p4.analis),0) as indicator, operator = STUFF((SELECT N', ' + nama 
    FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
     WHERE p2.id_perbaikan = p.id_perbaikan
     
     ORDER BY p.tanggal_rusak
     FOR XML PATH(N'')), 1, 2, N'')
  FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p
  left join
  (select id_perbaikan, COUNT(id_perbaikan) as jml from tb_parts group by id_perbaikan) as p3 on p3.id_perbaikan = p.id_perbaikan
  left join
  (select id_perbaikan, COUNT(id_perbaikan) as analis from tb_analisa group by id_perbaikan) as p4 on p4.id_perbaikan = p.id_perbaikan
  where p.tanggal_rusak >= '$awal' and p.tanggal_rusak <= '$akhir' and p.status = 'complete' and (p.masalah like '%$search%' or p.nama_mesin like '%$search%' or p.no_induk_mesin like '%$search%')
  group by p.id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin,no_urut_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai,klasifikasi, total_jam_kerusakan, ISNULL(( p3.jml),0)+ ISNULL(( p4.analis),0)
  ORDER BY tanggal_rusak OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

    
    $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai, operator = STUFF((SELECT N', ' + nama 
    FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
     WHERE p2.id_perbaikan = p.id_perbaikan
     
     ORDER BY p.tanggal_rusak
     FOR XML PATH(N'')), 1, 2, N'')
  FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p where p.tanggal_rusak >= '$awal' and p.tanggal_rusak <= '$akhir' and p .status = 'complete' and (p.masalah like '%$search%' or p.nama_mesin like '%$search%' or p.no_induk_mesin like '%$search%')
  group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai)a")[0]->total;
 

  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
   }

   public function getdata(Request $request){
      $tanggal = date('Y-m');
      $awal = $tanggal.'-01';
      $now = Carbon::now();
      
      //total request yang masuk pada periode bulan berjalan dari tanggal 1
      $req = PerbaikanModel::where('tanggal_rusak','>=',$tanggal.'-01')->where('tanggal_rusak','<=',$now)->get();
      $tot_req = $req->count();
      //total mesin yang rusak
      $rusak = PerbaikanModel::where('status','<>','complete')->where('status','<>','selesai')->get();
      $tot_rusak = $rusak->count();
      // total request yang complete pada periode bulan berjalan dari tanggal 1
      $complete = PerbaikanModel::where('tanggal_rusak','>=',$tanggal.'-01')->where('tanggal_rusak','<=',$now)->where('status','=','complete')->get();
      $tot_compl = $complete->count();
      //total perbaikan yang pending
      $list = PerbaikanModel::where('status','=','pending')->get();
      $tot_pending = $list->count();

      $jam_rusak1 = DB::connection("sqlsrv")->select("select sum(jam_rusak) as total from dbo.v_jam_kerusakan");
      
      
      if ($tot_req <= 0){
         $proc = 0;
      }else{

         $proc = ($tot_compl / $tot_req) * 100;
      }
      
      return array(
         "success"=>true,
         "tot_req"=>$tot_req,
         "tot_rusak"=>$tot_rusak,
         "tot_pend"=>$tot_pending,
         "procent"=>number_format($proc,2),
         "jam_rusak"=>number_format($jam_rusak1[0]->total,2)
      );
   }

   function update_operator($operator, $id_req, $klasifikasi, $token){
         $user = UserModel::where('api_token',base64_decode($token))->first();
         $req = PerbaikanModel::find($id_req);
         $no_per = $req->no_perbaikan;
         $size = count($operator);
        
         if ($req) {
           
             $req->operator = $size;
             $req->approved_by = $user->id;
             $req->klasifikasi = $klasifikasi;
             $req->save();
         }
         $cek_op = OperatorMtcModel::where('id_perbaikan',$id_req)->count();
         if($cek_op > 0){
            OperatorMtcModel::where('id_perbaikan',$id_req)->delete();
         }
         if ($size > 0) {
             for ($i = 0; $i < $size; $i++){
                 $nik = $operator[$i];
                 $nama = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->where('NIK','=',$nik)->first();
                 
                 $id = Str::uuid();
                 OperatorMtcModel::create([
                   'record_no'=>$id,
                   'id_perbaikan'=>$id_req,
                   'no_perbaikan'=>$no_per,
                   'nik'=> $operator[$i],
                   'nama' =>$nama->NAMA,
             ]);
           }
           
          }

          return true;
         
   }

   public function postcomplete(Request $request){
     //dd($request->all());
    
     //dd($jam_mulai);
      $token = apache_request_headers();
      if ($request->operator != null) {
         $no = $request['id_req'];
         $klas = $request['klasifikasi'];
         $ope = $request->get('operator');
         $upd = $this->update_operator($ope,$no,$klas,$token['token_req']);
      }

      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

      //$jam_mulai = date_create($request['tgl_mulai']);
       // $jam_selesai = date_create($request['tgl_selesai']);

       $jam_mulai = Carbon::createFromFormat('Y-m-d H:i:s', $request['tgl_mulai']);
       $jam_selesai = Carbon::createFromFormat('Y-m-d H:i:s', $request['tgl_selesai']);
     
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
    
        if ($jam_mulai->lessThan($tanggal_rusak) ) {
            return array(
                'message' => 'Jam Mulai perbaikan salah!',
                'success'=>false,
            );
        }elseif ($jam_selesai->lessThan($tanggal_rusak) || $jam_selesai->lessThan($jam_mulai)) {
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
                if (!empty($request['why1']) || !empty($request['why2']) || !empty($request['why3']) || !empty($request['why4']) || !empty($request['why5']) || !empty($request['pencegahan'])) {
                    $analisa = AnalisModel::where('id_perbaikan', $request['id_req'])->first();
                   
                    if (!$analisa) {
                        AnalisModel::create([
                            'id_analisa'=>Str::uuid(),
                            'id_perbaikan'=>$request['id_req'],
                            'why1'=>$request['why1'],
                            'why2'=>$request['why2'],
                            'why3'=>$request['why3'],
                            'why4'=>$request['why4'],
                            'why5'=>$request['why5'],
                            'pencegahan'=>$request['pencegahan'],
                        ]);
                    }else{
                        $analisa->why1 = $request['why1'];
                        $analisa->why2 = $request['why2'];
                        $analisa->why3 = $request['why3'];
                        $analisa->why4 = $request['why4'];
                        $analisa->why5 = $request['why5'];
                        $analisa->pencegahan = $request['pencegahan'];
    
                        $analisa->save();
                    }
                }
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
                'user_id' => $user->id,
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
                'user' => $user->id,
            ];
            Notification::send($users, new RequestNotif($details));
            return array(
                'message' => 'Simpan berhasil!',
                'success'=>true,
            );
           

        }
     
   }

   public function postpending(Request $request){
      
        $id = $request['id_req'];
        $req = PerbaikanModel::find($id);
        $token = apache_request_headers();
       
        if ($request->operator != null) {
           $no = $request['id_req'];
           $klas = $request['klasifikasi'];
           $ope = $request->get('operator');
           $upd = $this->update_operator($ope,$no,$klas,$token['token_req']);
        }
        $stat = 'pending_perbaikan';
        $req_stat = 'pending';
        if ($request['schedule'] == 'true') {
            $stat = 'scheduled';
            $req_stat = 'scheduled';
        }
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $sch = ScheduleModel::where('id_perbaikan',$id)->count();
       
        $success = false;
        if ($sch > 0) {
           $sch->tanggal_rencana_mulai = date_create($request['jadwal1']);
           $sch->tanggal_rencana_selesai = date_create($request['jadwal2']);
           $sch->keterangan =  $request['keterangan'];
           $sch->save();
            $success = true;
        }else{

            $pend = ScheduleModel::create([
                'id_schedule' => str::uuid(),
                'id_perbaikan' => $id,
                'description' => $stat,
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
            $success = true;
        }

        if ($success) {
            $req->status = $req_stat;
            $req->save();
            $details = [
                'id_req' => $id,
                'no_request' => $req->no_perbaikan,
                'status'=>$req_stat,
            
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
        
        }else {
            return array(
                'message' => 'Update Gagal !',
                'success'=>false,
            );
        }
   }
   public function editcomplete(Request $request){
        $id = $request['id_req'];
        $setatus = $request['setatus'];
        $perbaikan = PerbaikanModel::find($id);
        if (!$perbaikan) {
            return array(
                
                'message' => "ID perbaikan tidak ditemukan !",
                'success'=>false,
            );
        }
        $operator = OperatorMtcModel::select('nik')->where('id_perbaikan',$id)->get();
        $op = array();
        $analis = AnalisModel::where('id_perbaikan',$id)->first();
        if($operator->count() > 0){
            foreach ($operator as $x){
                array_push($op,$x->nik);
            }
        }
        if ($setatus == 'selesai') {
            $parts = PartsModel::where('id_perbaikan',$id)->get();
            return array(
                'perbaikan' => $perbaikan,
                'parts' => $parts,
                'operator' =>$op,
                'analis'=>$analis,
                'success'=>true,
            );
        }else{
            $pend = ScheduleModel::where('id_perbaikan',$id)->where('status','=','open')->first();
            
            return array(
                'perbaikan' => $perbaikan,
                'pend' => $pend,
                'operator' =>$op,
                'analis'=>$analis,
                'success'=>true,
            );
        }
   }
   public function posteditp(Request $request){
       //dd($request->all());
        $id = $request['id_req'];
        $req = PerbaikanModel::find($id);
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $stat = 'pending_perbaikan';
        $req_stat = 'pending';
        if ($request['schedule'] == 'true') {
            $stat = 'scheduled';
            $req_stat = 'scheduled';
        }
        if ($req->status == 'pending' || $req->status == 'scheduled') {

            $pend = ScheduleModel::where('id_perbaikan',$id)->where('status','=','open')->first();
            $pend->tanggal_rencana_mulai = date_create($request['jadwal1']);
            $pend->tanggal_rencana_selesai = date_create($request['jadwal2']);
            $pend->description = $stat;
            $pend->keterangan = $request['keterangan'];
            $pend->save();
           
        }else{

            $pend = ScheduleModel::create([
                'id_schedule' => str::uuid(),
                'id_perbaikan' => $id,
                'description' => $stat,
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
        }
       

        $req->status = $req_stat;
        $req->save();

        if (!empty($request->get('operator'))){
            $this->update_operator($request->get('operator'),$id,$req->klasifikasi,$token['token_req']);
        }
        $details = [
            'id_req' => $id,
            'no_request' => $req->no_perbaikan,
            'status'=>'revisi pending',
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' =>  $user->id,
            'activity' =>"update",
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => "Update data berhasil !",
            'success'=>true,
        );
   }
   public function posteditc(Request $request){
      //dd($request->all());
        $id = $request['id_req'];
        $req = PerbaikanModel::find($id);
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        //$jam_mulai = date_create($request['tanggal_mulai']);
        //$jam_selesai = date_create($request['tanggal_selesai']);
        $jam_mulai = Carbon::createFromFormat('Y-m-d H:i:s', $request['tgl_mulai']);
        $jam_selesai = Carbon::createFromFormat('Y-m-d H:i:s', $request['tgl_selesai']);
     
        $req = PerbaikanModel::find($request['id_req']);
        $tanggal_rusak = date_create($req->tanggal_rusak);
        $departemen = $req->departemen;


        if (!empty($request->get('operator'))){
            $this->update_operator($request->get('operator'),$id,$req->klasifikasi,$token['token_req']);
        }

        $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($jam_mulai, $jam_selesai));
        //$jam_perbaikan = date_diff($jam_mulai,$jam_selesai);
        $jam_perbaikan = $hasilnya[0]->hasil;
        $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($tanggal_rusak, $jam_selesai));
        //$jam_kerusakan = date_diff($tanggal_rusak, $jam_selesai);
        $jam_kerusakan = $hasilnya[0]->hasil;
        $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($tanggal_rusak, $jam_mulai));
        //$jam_menunggu = date_diff($tanggal_rusak, $jam_mulai);
        $jam_menunggu = $hasilnya[0]->hasil;

        if ($jam_mulai->lessThan($tanggal_rusak) ) {
            return array(
                'message' => 'Jam Mulai perbaikan salah!',
                'success'=>false,
            );
        }elseif ($jam_selesai->lessThan($tanggal_rusak) || $jam_selesai->lessThan($jam_mulai)) {
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
                $jamperbaikan =  $jam_perbaikan;
                $jamkerusakan = $jam_kerusakan;
                $jammenunggu = $jam_menunggu;
                if (!empty($request['why1']) || !empty($request['why2']) || !empty($request['why3']) || !empty($request['why4']) || !empty($request['why5']) || !empty($request['pencegahan'])) {
                  
                    $analisa = AnalisModel::where('id_perbaikan', $id)->first();
                    if (!$analisa) {
                        AnalisModel::create([
                            'id_analisa'=>Str::uuid(),
                            'id_perbaikan'=>$id,
                            'why1'=>$request['why1'],
                            'why2'=>$request['why2'],
                            'why3'=>$request['why3'],
                            'why4'=>$request['why4'],
                            'why5'=>$request['why5'],
                            'pencegahan'=>$request['pencegahan'],
                        ]);
                    }else{
                        $analisa->why1 = $request['why1'];
                        $analisa->why2 = $request['why2'];
                        $analisa->why3 = $request['why3'];
                        $analisa->why4 = $request['why4'];
                        $analisa->why5 = $request['why5'];
                        $analisa->pencegahan = $request['pencegahan'];
    
                        $analisa->save();
                    }
                }
            }else {
                $jamperbaikan =  $jam_perbaikan;
                $jamkerusakan = 0;
                $jammenunggu = 0;
            }
            $req->klasifikasi = $request['klasifikasi'];
            $req->penyebab = $request['penyebab'];
            $req->tanggal_mulai = $jam_mulai;
            $req->tindakan = $request['tindakan'];
            $req->tanggal_selesai = $jam_selesai;
            $req->total_jam_perbaikan =$jamperbaikan;
            $req->total_jam_kerusakan = $jamkerusakan;
            $req->total_jam_menunggu = $jammenunggu;
            $req->status = 'selesai';
            $req->save();
            $par = PartsModel::where('id_perbaikan',$id)->delete();
            $pend = ScheduleModel::where('id_perbaikan',$id)->update(['status'=>'close']);
           
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
                'id_req' => $id,
                'no_request' => $req->no_perbaikan,
                'status'=>'selesai',
               
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user->id,
                'activity' =>"update",
                'message' => $details,
            ];
            LogModel::create($data);
            return array(
                'message' => 'Simpan berhasil!',
                'success'=>true,
            );
           

        }
   }
   public function posteditr(Request $request){
    //dd($request->all());
    $id = $request['id_req'];
    $req = PerbaikanModel::find($id);
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
   
    $req = PerbaikanModel::find($request['id_req']);

    
    $departemen = $req->departemen;

    if (!empty($request->get('operator'))){
        $this->update_operator($request->get('operator'),$id,$req->klasifikasi,$token['token_req']);
    }

   
        $req->klasifikasi = $request['klasifikasi'];
        $req->penyebab = $request['penyebab'];
        $req->tindakan = $request['tindakan'];
        $req->status = 'process';
        $req->save();
        $par = PartsModel::where('id_perbaikan',$id)->delete();
        $pend = ScheduleModel::where('id_perbaikan',$id)->update(['status'=>'close']);

        if ($request['klasifikasi'] == 'C') {
   
            if (!empty($request['why1']) || !empty($request['why2']) || !empty($request['why3']) || !empty($request['why4']) || !empty($request['why5']) || !empty($request['pencegahan'])) {
               
                $analisa = AnalisModel::where('id_perbaikan', $id)->first();
                if (!$analisa) {
                    AnalisModel::create([
                        'id_analisa'=>Str::uuid(),
                        'id_perbaikan'=>$id,
                        'why1'=>$request['why1'],
                        'why2'=>$request['why2'],
                        'why3'=>$request['why3'],
                        'why4'=>$request['why4'],
                        'why5'=>$request['why5'],
                        'pencegahan'=>$request['pencegahan'],
                    ]);
                }else{
                    $analisa->why1 = $request['why1'];
                    $analisa->why2 = $request['why2'];
                    $analisa->why3 = $request['why3'];
                    $analisa->why4 = $request['why4'];
                    $analisa->why5 = $request['why5'];
                    $analisa->pencegahan = $request['pencegahan'];
    
                    $analisa->save();
                }
            }
        }
      
        
       
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
            'id_req' => $id,
            'no_request' => $req->no_perbaikan,
            'status'=>'process',
           
        ];
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => 'Simpan berhasil!',
            'success'=>true,
        );
   }
   
   public function postbatal(Request $request){
    $id = $request['id_req'];
    $req = PerbaikanModel::find($id);
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

    $req->penyebab = NULL;
    $req->tanggal_mulai = NULL;
    $req->tindakan = NULL;
    $req->klasifikasi = NULL;
    $req->tanggal_selesai = NULL;
    $req->total_jam_perbaikan =NULL;
    $req->total_jam_kerusakan = NULL;
    $req->total_jam_menunggu = NULL;
    $req->status = 'process';
    $req->save();

    $par = PartsModel::where('id_perbaikan',$id)->delete();
    $op = OperatorMtcModel::where('id_perbaikan',$id)->delete();
    $analis = AnalisModel::where('id_perbaikan',$id)->delete(); 
    $details = [
        'id_req' => $id,
        'no_request' => $req->no_perbaikan,
        'status'=>'process',
    ];

    $data = [
        'record_no' => Str::uuid(),
        'user_id' => $user->id,
        'activity' =>"update",
        'message' => $details,
    ];
    LogModel::create($data);
    return array(
        'message' => 'Update data berhasil!',
        'success'=>true,
    );
   }
   public function get_jadwal(Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $Datas = DB::connection('sqlsrv')->select("SELECT p.id_perbaikan, tanggal_rusak, no_perbaikan, departemen, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, klasifikasi, no_urut_mesin, status, p3.tanggal_rencana_selesai, operator = STUFF((SELECT N', ' + nama 
            FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p2 
            WHERE p2.id_perbaikan = p.id_perbaikan
            
            ORDER BY p.tanggal_rusak
            FOR XML PATH(N'')), 1, 2, N'')
        FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p 
        left join
        (select id_perbaikan, tanggal_rencana_selesai from tb_schedule)AS p3 on p3.id_perbaikan = p.id_perbaikan where p.status = 'scheduled' and (p.masalah like '%$search%' or p.nama_mesin like '%$search%' or p.no_induk_mesin like '%$search%')
        group by p.id_perbaikan, tanggal_rusak, no_perbaikan, departemen, nama_mesin,no_urut_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, klasifikasi,p3.tanggal_rencana_selesai, status
        ORDER BY p3.tanggal_rencana_selesai OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

    $count = DB::connection('sqlsrv')->select("select coalesce(count(*),0) as total from (SELECT id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, tindakan, tanggal_selesai
    FROM (select a.*, b.nama from tb_perbaikan a left join tb_operator_mtc b on a.id_perbaikan = b.id_perbaikan) AS p where p .status = 'scheduled' and (p.masalah like '%$search%' or p.nama_mesin like '%$search%' or p.no_induk_mesin like '%$search%')
    group by id_perbaikan, tanggal_rusak, no_perbaikan, departemen, shift, nama_mesin, no_induk_mesin, masalah, kondisi, operator, tindakan, tanggal_selesai)a")[0]->total;

        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
   }
   public function hitung_jam(Request $request){
   
    $jam_mulai = date_create($request['awal']);
    $jam_selesai = date_create($request['akhir']);
    $klas = $request['klas'];
    $id = $request['id'];
    if ($klas == "C") {
        $perb = PerbaikanModel::find($id);
        $jam_mulai = $perb->tanggal_rusak;
    }else if($klas == "A" || $klas == "D"){
        $jam_mulai = $jam_selesai;
    }else{
        $jam_mulai = $jam_mulai;
    }

    $hasilnya = DB::connection('sqlsrv')->select('exec hitung_jam ?,?', array($jam_mulai, $jam_selesai));
    return $hasilnya;
   }
   public function getparts(Request $request){
    $id_perbaikan = $request->input("id_req");
    $Datas = DB::connection('sqlsrv')->table('tb_parts')
    ->where('id_perbaikan',$id_perbaikan)->get();
    $analisa = DB::connection('sqlsrv')->select("select id_perbaikan,
    indicatorname,
    indicatorvalue
  from tb_analisa
  
  unpivot
  (
    indicatorvalue
    for indicatorname in (why1, why2, why3,why4, why5, pencegahan)
  ) unpiv where id_perbaikan = '$id_perbaikan'");
    return array(
        "parts"=> $Datas,
        "analisa"=> $analisa
    );
   
   }
  public function sasaranmutu(Request $request){
    $now = date('Y-m-d');
    $dats = DB::select(DB::raw("select DATEPART(MM, tbm.Date) as bln, tt.process_name, tt.target, isnull((tm.jam_rusak),0) as hasil,tj.total from
    (SELECT  TOP (DATEDIFF(MONTH,CONVERT(datetime, DATEADD(YEAR, DATEDIFF(YEAR, 0, '$now'), 0)), DATEADD(yy, DATEDIFF(yy, 0, '$now') + 1, -1)) + 1)
            Date = convert(varchar, EOMONTH(DATEADD(MONTH, ROW_NUMBER() OVER(ORDER BY a.object_id) - 1, CONVERT(datetime, DATEADD(YEAR, DATEDIFF(YEAR, 0, '$now'), 0)))), 23) 
    FROM    sys.all_objects a
            CROSS JOIN sys.all_objects b)tbm
	left join
	(select periode, process_name, target from tb_target where process_cd = 'jam_kerusakan') tt on DATEPART(YYYY, tt.periode)= DATEPART(YYYY, tbm.Date) and DATEPART(MM, tt.periode)= DATEPART(MM, tbm.Date)
	left join
	(select convert(varchar(7), tgl_rekap, 126) as rekap, departemen, sum(jam_rusak) as jam_rusak from tb_jamkerusakan group by convert(varchar(7), tgl_rekap, 126), departemen) tm on tm.rekap= convert(varchar(7), tbm.Date, 126) and tt.process_name = tm.departemen
    left join
	(select convert(varchar(7), tgl_rekap, 126) per, sum(jam_rusak) as total from tb_jamkerusakan group by convert(varchar(7), tgl_rekap, 126))tj on tj.per = convert(varchar(7), tbm.Date, 126)"));

    $res= [];
    for ($i=0; $i < 13; $i++) { 
     $res[$i]= (object)[
       'bulan'=>0,
      'tCast'=> 0,
      'tGrind'=> 0,
      'tMach'=>0,
      'hCast'=>0,
      'hGrind' =>0,
      'hMach' =>0,
      'tTotal' =>0,
      'hTotal' =>0,
        ];
    
    }

    foreach ($dats as $key) {

     
        $tCast= null;
        $tGrind= null;
        $tMach=null;
        $hCast=0;
        $hGrind =0;
        $hMach =0;
        $tTotal =0;
        $hTotal =0;

        if ($key->process_name == 'CASTING') {
          $tCast = $tCast + $key->target;
          $hCast = $hCast + $key->hasil;
        }elseif($key->process_name == 'GRINDING'){
            $tGrind = $tGrind + $key->target;
          $hGrind = $hGrind + $key->hasil;
        }else{
            $tMach = $tMach + $key->target;
          $hMach = $hMach + $key->hasil;
        }

        $res[$key->bln]= (object)[
            'bulan'=>$key->bln,
            'tCast'=>$res[$key->bln]->tCast+$tCast,
            'tGrind'=> $res[$key->bln]->tGrind+$tGrind,
            'tMach'=>$res[$key->bln]->tMach+$tMach,
            'hCast'=>$res[$key->bln]->hCast+$hCast,
            'hGrind' =>$res[$key->bln]->hGrind+$hGrind,
            'hMach' =>$res[$key->bln]->hMach+$hMach,
            'tTotal' =>$res[$key->bln]->tTotal + $tCast + $tGrind + $tMach,
            'hTotal' =>$key->total,
        ];
    }
    unset($res[0]);
    return array(
        'success'=>true,
        'data'=>$res,
      );
  }
}
