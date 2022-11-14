<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\PerbaikanModel;
use App\TargetModel;
use App\UserModel;
use App\MesinModel;
use Carbon\Carbon;
use App\OperatorMtcModel;
use App\jiguSelesaiModel;
use App\MasalahModel;
use App\KaryawanModel;
use App\TindakanModel;
use App\LogModel;
use App\Traits\CheckStatus;
use App\Events\RealTimeMessage;
use App\Events\EventMessage;
use Illuminate\Support\Facades\Crypt;



class PageController extends Controller
{
   use CheckStatus;

   public function login(){
      if(Session::get('login') == 1){
         return redirect()->route('home');
     }
     return view('login_page');
   }

   public function under(){
      return view ('undermaintenance');
   }
   
   public function home(){
      $tanggal = date('Y-m');
      $awal = $tanggal.'-01';
      $now = date('Y-m-d');
      $tahun = date('Y');

      $sales = DB::connection('oracle')->table('t_ship_tr')->where('i_ship_date','>=',$tanggal.'-01')->where('i_ship_date','<=',$now)->selectraw('sum(i_ship_qty)as qty')->get(); 
      $acp9909 = DB::connection("oracle")->select("select sum(i_acp_qty)as qty from t_acp_tr where i_acp_date >= '$awal' and i_acp_date <= '$now' and i_stock_location='9909'");
      $lembur = DB::connection('sqlsrv_pga')->select("select sum(JUMLAH_JAM_LEMBUR) as lembur from T_LEMBUR where TANGGAL_LEMBUR >= '$awal' and TANGGAL_LEMBUR <= '$now'");
      $mesinstop = $this->mesinstop();
      $pross = DB::connection('sqlsrv_pga')->select("select t1.dept_group, isnull(sum(t1.jml),0)as jml, isnull(sum(t2.jml_ss),0)as jml_ss, isnull(sum((t2.jml_ss * 100)/(t1.jml * 2)),0) as prosentase from 
      (select dept_group, count(dept_group)as jml from t_karyawan where status_karyawan <> 'Off' and nama_jabatan not like '%Manager%' and dept_group <> 'Admin' group by dept_group)t1
      left join
      (select departemen, count(departemen)as jml_ss from db_produksi.dbo.tb_ss where tgl_penyerahan like '$tahun%' group by departemen)t2 on t1.dept_group = t2.departemen group by t1.dept_group");

      $dhh = DB::select("select t1.jenis_laporan, (isnull((t2.jml),0) + isnull((t3.jml1),0) - isnull((t3.jml1),0)) as Close1, (isnull((t2.jml),0) + isnull((t3.jml1),0)) as masuk from 
      (select jenis_laporan from tb_hhky where jenis_laporan = 'HH' and year(tgl_lapor) = '$tahun'  group by jenis_laporan)t1
      left join
      (select jenis_laporan, count(status_laporan) as jml from tb_hhky  where year(tgl_lapor) = '$tahun' and status_laporan = 'Close' and jenis_laporan = 'HH'  group by status_laporan, jenis_laporan)t2 on t1.jenis_laporan = t2.jenis_laporan
      left join 
      (select jenis_laporan, count(status_laporan) as jml1 from tb_hhky  where year(tgl_lapor) = '$tahun' and status_laporan = 'Open' and jenis_laporan = 'HH'  group by status_laporan, jenis_laporan)t3 on t1.jenis_laporan = t3.jenis_laporan");

      $dky = DB::select("select t1.jenis_laporan, (isnull((t2.jml),0) + isnull((t3.jml1),0) - isnull((t3.jml1),0)) as Close1, (isnull((t2.jml),0) + isnull((t3.jml1),0)) as masuk from 
      (select jenis_laporan from tb_hhky where jenis_laporan = 'KY' and year(tgl_lapor) = '$tahun' group by jenis_laporan)t1
      left join
      (select jenis_laporan, count(status_laporan) as jml from tb_hhky  where year(tgl_lapor) = '$tahun' and status_laporan = 'Close' and jenis_laporan = 'KY'  group by status_laporan, jenis_laporan)t2 on t1.jenis_laporan = t2.jenis_laporan
      left join 
      (select jenis_laporan, count(status_laporan) as jml1 from tb_hhky  where year(tgl_lapor) = '$tahun' and status_laporan = 'Open' and jenis_laporan = 'KY'  group by status_laporan, jenis_laporan)t3 on t1.jenis_laporan = t3.jenis_laporan");
      //dd($hhkyopen);

      return view('userPage.dashboard',['salespcs'=>$sales[0], 'acp9909'=>$acp9909[0], 'lembur'=>$lembur[0], 'mesinoff'=>$mesinstop, 'pross'=>$pross, 'tahun'=>$tahun, 'dhh'=>$dhh, 'dky'=>$dky]);
      
   }
   public function get_successrate(Request $request){
      $awal = $request['tgl_awal'];
      $now = $request['tgl_akhir'];
      //$yd = DB::connection('oracle')->select("select trim(t1.i_seiban) as seiban, t1.i_acp_qty as kensa, t2.i_acp_qty as zoukei from (select i_seiban, i_acp_qty from t_acp_tr where i_item_cd not like 'SS%' and i_ind_dest_cd = '1A5001' and i_acp_date >='$awal' and i_acp_date <='$now')t1 left join (select i_seiban, i_acp_qty, i_ind_dest_cd from t_acp_tr)t2 on t1.i_seiban=t2.i_seiban and t2.i_ind_dest_cd='1C1001'");
      $yd = DB::select("select sum(start_qty) as start, sum(finish_qty) as finish from tb_hasil_produksi where tgl_proses >= '$awal' and tgl_proses <= '$now' and line_proses = '320'");
      $kensa = $yd[0]->finish;
      $zoukei = $yd[0]->start;
     


      if ($zoukei >0) {
         $persen1 = ($kensa / $zoukei)*100;
      }else{
         $persen1 = 0;
      }
      $persen = number_format($persen1,2);
      return $persen;
   }
   public function register(){
    $dept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('DEPT_SECTION')->groupBy('DEPT_SECTION')->get();
    $line = DB::connection('sqlsrv')->table('tb_line')->get();
    $level = DB::connection('sqlsrv_pga')->table('T_JABATAN')->get();
   
    return view('userPage.register',['departemen'=>$dept, 'line'=>$line, 'level'=>$level]);
   }

   //-----------------------------------------------------maintenance-------------------------------------------------------------------

   public function schedule(){

      return view('maintenance.schedule');
   }

  public function completion($id){
     $req = PerbaikanModel::find($id);
     $user = UserModel::find($req->user_id);
     $operator = OperatorMtcModel::where('id_perbaikan', $id)->get();

     $level[] = (object) ["key"=>"A", "value"=>"A"];
     $level[] = (object) ["key"=>"B", "value"=>"B"];
     $level[] = (object) ["key"=>"C", "value"=>"C"];
     $level[] = (object) ["key"=>"D", "value"=>"D"];
     
        //$operator = DB::connection('sqlsrv')->select("SELECT operator = STUFF((SELECT N', ' + nama FROM tb_operator_mtc AS p2 WHERE p2.id_perbaikan = p.id_perbaikan FOR XML PATH(N'')), 1, 2, N'') FROM tb_operator_mtc AS p where p.id_perbaikan = '$id' GROUP BY id_perbaikan")[0];
    

      return view('maintenance.completion',['request'=>$req, 'user'=>$user, 'operator' => $operator, 'jenis'=>$level]);
  }
   public function list_perbaikan(){
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

      //$jam_rusak1 = DB::connection("sqlsrv")->select("select sum(total_jam_kerusakan)as total from tb_perbaikan where tanggal_rusak >= '$awal' and tanggal_rusak <= '$now' and status = 'complete'");
      $jam_rusak1 = DB::connection("sqlsrv")->select("select sum(jam_rusak) as total from dbo.v_jam_kerusakan");
      
     
      if ($tot_req <= 0){
         $proc = 0;
      }else{

         $proc = ($tot_compl / $tot_req) * 100;
      }
      $operator = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->where('DEPT_GROUP','=','MAINTENANCE')->where('STATUS_KARYAWAN','!=','Off')->get();
      $jam = PerbaikanModel::where('tanggal_rusak','>=',$tanggal.'-01')->where('tanggal_rusak','<=',$now)->where('status','=','complete')->sum('total_jam_kerusakan');
      
     
      return view('maintenance.listperbaikan',['total_request'=>$tot_req, 'prosentase'=>number_format($proc,2), 'total_rusak'=>$tot_rusak, 'total_pending'=>$tot_pending, 'operator'=>$operator, 'total_jam'=>$jam_rusak1]);
   }

   public function perbaikan(){
      $dept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->get();
      //$mesin = DB::connection('sqlsrv_pass')->table('tb_inventory')->where('class','=','Machinery & Equipment')->get();
      $mesin = MesinModel::where('kondisi','=','OK')->get();
      $operator = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->where('DEPT_GROUP','=','MAINTENANCE')->where('STATUS_KARYAWAN','!=','Off')->get();
     
      return view('maintenance.perbaikan',['departemen'=>$dept, 'mesin'=>$mesin, 'operator'=>$operator]);
   }

   public function userlist(){
      $user = DB::connection('sqlsrv')->table('tb_user')->select('user_name')->groupBy('user_name')->get();

      return view('list',['user'=>$user]);
      // TODO:checktok
   }

   public function mesinstop(){
      $Datas = DB::connection('sqlsrv')->table('tb_perbaikan')
      ->leftJoin('v_jam_kerusakan','v_jam_kerusakan.no_perbaikan','=','tb_perbaikan.no_perbaikan')
      ->select('tb_perbaikan.tanggal_rusak', 'tb_perbaikan.no_perbaikan', 'tb_perbaikan.departemen', 'tb_perbaikan.no_induk_mesin', 'tb_perbaikan.nama_mesin', 'tb_perbaikan.no_urut_mesin', 'tb_perbaikan.masalah', 'v_jam_kerusakan.jam_rusak')
      ->where('tb_perbaikan.no_induk_mesin','<>','NM')
      ->where('tb_perbaikan.klasifikasi', 'C')
      ->whereNotIn('tb_perbaikan.status',array('complete', 'selesai'))
      ->orderBy('tb_perbaikan.tanggal_rusak','asc')
      ->take(5)
      ->get();

      return $Datas;
   }

   public function mesin(){
     $Datas = $this->mesinstop();
     $mesin = MesinModel::where('kondisi','=','OK')->get();
     
      return view('maintenance.mesin',['mesinoff'=>$Datas, 'mesinlist'=>$mesin]);
   }
   public function historymesin($no_induk){
      $mes = DB::table('tb_mesin')->where('no_induk','=',$no_induk)->first();
      
      return view('/maintenance/historymesin',['mesin'=>$mes]);
  }

  public function splash(){
     return view('/mtchome/splash');
  }

  public function mtchome(){
   
   $operator = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->where('DEPT_GROUP','=','MAINTENANCE')->where('STATUS_KARYAWAN','!=','Off')->get();
   $mesinstop = $this->mesinstop();

   return view('/mtchome/mtc_home',['operator'=>$operator,'mesinoff'=>$mesinstop]);
  }

  public function mtccompletion($id){
      $req = PerbaikanModel::find($id);
      $user = UserModel::find($req->user_id);
      $operator = OperatorMtcModel::where('id_perbaikan', $id)->get();

      $level[] = (object) ["key"=>"A", "value"=>"A"];
      $level[] = (object) ["key"=>"B", "value"=>"B"];
      $level[] = (object) ["key"=>"C", "value"=>"C"];
      $level[] = (object) ["key"=>"D", "value"=>"D"];

    return view('mtchome.completion',['request'=>$req, 'user'=>$user, 'operator' => $operator, 'jenis'=>$level]);
  }

   //-----------------------------------------------------produksi-------------------------------------------------

   public function input_produksi(){
      return view('produksi.forminput');
   }

   public function detailmasalah($id){
      //dd($id);
      $masalah = MasalahModel::find($id);

      $user = UserModel::find($masalah->informer);
      $tindakan = TindakanModel::where('id_masalah','=',$id)->orderBy('created_at','desc')->get();
      $karyawan = KaryawanModel::find($user->nik);
      $setatus = $this->cekstatus($id);
   
      return view('produksi.detailmasalah',["masalah"=>$masalah, 'karyawan'=>$karyawan, 'tindakan'=>$tindakan, 'status'=>$setatus]);
   }

   public function req_perbaikan(){
      $dept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->get();
      //$mesin = DB::connection('sqlsrv_pass')->table('tb_inventory')->where('class','=','Machinery & Equipment')->get();
      $mesin = MesinModel::where('kondisi','=','OK')->get();
      $nik = Session::get('nik');
      $nomer = DB::connection("sqlsrv_pga")->select(\DB::raw("select b.KODE_DEPARTEMEN, b.DEPT_CODE, b.DEPT_SECTION from T_KARYAWAN a left join T_DEPARTEMEN b on a.DEPT_SECTION = b.DEPT_SECTION where a.NIK = '$nik'"));
      $dept = $nomer[0]->DEPT_SECTION;
     $req_selesai = PerbaikanModel::where('status', '=', 'selesai')->where('departemen','=',$dept)->count();

      return view('produksi.perbaikan',['departemen'=>$dept, 'mesin'=>$mesin, 'req_selesai'=>$req_selesai]);
   }



   public function report_produksi(){
      $tanggal = date('Y-m');
      $awal = $tanggal.'-01';
      $now = date('Y-m-d');

    $tgl = $now;
     
      $targetsales = DB::connection('oracle')->select("select sum(i_ship_qty)as qty from t_ship_tr where i_ship_date >= '$awal' and i_ship_date <= '$now'"); 

      $target = TargetModel::select('target')->where('process_cd','=','produksi')->where('periode', 'like', $tanggal.'%')->first();
      $t_sales = TargetModel::select('target')->where('process_cd','=','Sales')->where('periode', 'like', $tanggal.'%')->first();

      if (empty($target)) {
       
         $target = (object) ['target' => 0];
       }
       if(empty($t_sales)){
          $t_sales = (object) ['target' => 0];
       }

      $acp9909 = DB::connection("oracle")->select("select sum(i_acp_qty)as qty from t_acp_tr where i_acp_date >= '$awal' and i_acp_date <= '$now' and i_stock_location='9909'");
    
      $sales = DB::connection('oracle')->table('t_ship_tr')->where('i_ship_date','>=',$tanggal.'-01')->where('i_ship_date','<=',$now)->selectRaw('i_del_dest_desc,i_curr_cd,sum(i_ship_qty)as qty, sum(i_amt)as amt')->groupBy('i_del_dest_desc','i_curr_cd')->get(); 
      $totpcs = $sales->sum('qty');
      $salesamt = DB::connection('oracle')->table('t_ship_tr')->where('i_ship_date','>=',$tanggal.'-01')->where('i_ship_date','<=',$now)->selectRaw('i_curr_cd,sum(i_ship_qty)as qty, sum(i_amt)as amt')->groupBy('i_curr_cd')->get();
      
      $targetproduksi = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Proses')->where('periode','=',$awal)->get();
      $targetshikakari = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Shikakari')->where('periode','=',$awal)->get();
   
      return view('produksi.report',['salesproduksi'=>$sales, 'totalsales'=>$totpcs,'totalamount'=>$salesamt,'target'=>$target,'acp9909'=>$acp9909,'targetsales'=>$targetsales,'t_sales'=>$t_sales]);
      }

   public function getreport_produksi(Request $request){
      //dd($request->all());
      $tanggal = date('Y-m');
      $awal = $tanggal.'-01';
      //$awal = '2021-01-01';
      $now = date('Y-m-d');
      $bulan = date(' F Y');

      $tgl = $request["tgl"];
      $tgl1 = $request["tgl1"];
      $tglawal= date_create($tgl);
      $tglawalmulai = $tglawal->format('Y-m').'-01';
      $typering = $request["typering"];
    //dd($typering);
      $produksi = DB::connection('oracle')->select(DB::raw("select t1.v_seq, t1.v_name, trim(t1.v_loc_cd) as v_loc_cd, NVL(t2.qty,0) as qty from
      (select v_seq, v_name, v_loc_cd from npr_wipnmms) t1
      left join
      (select i_ind_content, sum(i_acp_qty) as qty from t_acp_tr where i_acp_date >= '$tgl' and i_acp_date <= '$tgl1' group by i_ind_content) t2 on t2.i_ind_content = t1.v_loc_cd
      order by t1.v_seq"));
      $NPRZ= DB::connection('oracle')->table('t_acp_tr')->where('i_seiban', 'like','%Z%')->where('i_seq','<=','3')->where('i_acp_date','=',$tgl)->selectRaw('i_ind_content, sum(i_acp_qty)as qty')->groupBy('i_ind_content')->get();
      $tenaoshi = DB::connection('oracle')->table('t_acp_tr')->join('npr_wipnmms','t_acp_tr.i_ind_content','=','npr_wipnmms.v_loc_cd')->where('t_acp_tr.i_seiban', 'like','C%')->where('t_acp_tr.i_ind_content','=','1A5001')->where('t_acp_tr.i_acp_date','=',$tgl)->selectRaw('npr_wipnmms.v_seq,npr_wipnmms.v_name,t_acp_tr.i_ind_content,sum(t_acp_tr.i_acp_qty) as qty')->groupBy('npr_wipnmms.v_seq','npr_wipnmms.v_name','t_acp_tr.i_ind_content')->orderBy('npr_wipnmms.v_seq')->get();
      $wip = DB::connection('oracle')->select("select trim(b.v_loc_cd) as v_loc_cd, b.v_name as v_name, sum(a.i_po_qty)as qty from (SELECT i_po_qty, i_po_detail_no, i_ind_content FROM T_PO_TR
      WHERE i_po_detail_no in(SELECT MAX(I_PO_DETAIL_NO) FROM T_PO_TR
      WHERE I_PO_CLS <> '00' AND I_PO_COMP_CLS = '00' GROUP BY I_SEIBAN)) a left join npr_wipnmms b on a.i_ind_content = b.v_loc_cd group by b.v_loc_cd, b.v_name,b.v_seq, a.i_ind_content order by b.v_seq asc");
      
      $targetproduksi = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Daily')->where('periode','=',$tglawalmulai)->get();
      $targetproduksi_monthly = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Monthly')->where('periode','=',$tglawalmulai)->get();
      $targetshikakari = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Shikakari')->where('periode','=',$awal)->get();
      //dd($targetproduksi);
      $zoukei =0;
      $nai =0;
      $sozai =0;
      $kensa =0;
//dd($produksi);
      

if ($NPRZ) {
  
   foreach($NPRZ as $x){
      if ($x->i_ind_content=='1C1001'){
         $zoukei = $x->qty;
      }
      elseif ($x->i_ind_content=='1C2001'){
         $nai = $x->qty;
      } elseif ($x->i_ind_content=='1C3001'){
         $sozai = $x->qty;
      } 
}}
if ($produksi) {
  $sum = 0;
   foreach ($produksi as $y){
      if($y->v_loc_cd=='1C1001'){
         $w = $y->qty-$zoukei;
      } elseif ($y->v_loc_cd=='1C2001') {
         $w = $y->qty-$nai;
      } elseif ($y->v_loc_cd=='1C3001'){
         $w = $y->qty-$sozai;
      } else{
         $w = $y->qty;
      }
      if ($y->v_loc_cd=='9909'){
         $sum = $sum + $y->qty;
      }
      //$target = $this->gettarget($targetproduksi,$y->i_ind_content);
      $hasil = array ('v_loc_cd'=>$y->v_loc_cd,'v_name'=>$y->v_name, 'i_acp_qty'=>$w);
   $final[]=$hasil;
   }
}
//dd($final);

if($wip){
   //$ex = count($wip);
   foreach($wip as $r){
      //$dd = $r->v_loc_cd;
      $g = $this->gettarget2($targetshikakari,$r->v_loc_cd);
      $h = array ('v_loc_cd'=>$r->v_loc_cd, 'v_name'=>$r->v_name,'qty'=>$r->qty,'target'=>$g);
      $h1[]=$h;
   }
}
//dd($h1);

if ($tenaoshi) {
   foreach($tenaoshi as $t){
     $kensa = $t->qty;
      }
   }
$index = count($final);

for ($i=0; $i < $index; $i++) { 
  if ($final[$i]["v_loc_cd"] == "1A5001") {
    $p = $final[$i]["i_acp_qty"] - $kensa;
  } else{
     $p = $final[$i]["i_acp_qty"];
  }
 // dd($final[$i]['v_loc_cd']);

  $tget = $this->gettarget1($targetproduksi,$final[$i]['v_loc_cd']);
  $rekap = array('i_ind_content'=>$final[$i]["v_loc_cd"],'v_name'=>$final[$i]["v_name"], 'i_acp_qty'=>$p,'target_prod'=>$tget);
  $hasil_produksi[]=$rekap;
  //dd($hasil_produksi);
  
  $tget_monthly = $this->gettarget1($targetproduksi_monthly,$final[$i]["v_loc_cd"]);
  $rekap_monthly = array('i_ind_content'=>$final[$i]["v_loc_cd"],'v_name'=>$final[$i]["v_name"], 'i_acp_qty'=>$p,'target_prod'=>$tget_monthly);
  $hasil_produksi_monthly[]=$rekap_monthly;

}
//dd($hasil_produksi);
      return array ( 'hasilproduksi'=>$hasil_produksi,'hasilproduksi_monthly'=>$hasil_produksi_monthly, 'h1'=>$h1,'shikakari'=>$wip,'sum'=>$sum);
  
   }

   public function getreport_shikakari(Request $request){
      $tanggal = date('Y-m');
      $awal = $tanggal.'-01';
      $now = date('Y-m-d');

      $tgl1 = $request->input("tgl1");
      $wip = DB::connection('oracle')->select("select trim(b.v_loc_cd) as v_loc_cd, b.v_name as v_name, sum(a.i_po_qty)as qty from (SELECT i_po_qty, i_po_detail_no, i_ind_content FROM T_PO_TR
      WHERE i_po_detail_no in(SELECT MAX(I_PO_DETAIL_NO) FROM T_PO_TR
      WHERE I_PO_CLS <> '00' AND I_PO_COMP_CLS = '00' GROUP BY I_SEIBAN)) a left join npr_wipnmms b on a.i_ind_content = b.v_loc_cd group by b.v_loc_cd, b.v_name,b.v_seq, a.i_ind_content order by b.v_seq asc");
      
      $targetproduksi = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Proses')->where('periode','=',$awal)->get();
      $targetshikakari = DB::table('tb_target')->select('process_name','target')->where('process_cd','=','Shikakari')->where('periode','=',$awal)->get();
   

if($wip){
   //$ex = count($wip);
   foreach($wip as $r){
      //$dd = $r->v_loc_cd;
      $g = $this->gettarget2($targetshikakari,$r->v_loc_cd);
      $h = array ('v_loc_cd'=>$r->v_loc_cd, 'v_name'=>$r->v_name,'qty'=>$r->qty,'target'=>$g);
      $h1[]=$h;
   }
}
      return array ('h1'=>$h1, 'shikakari'=>$wip);
  
   }


   public function gettarget1($targetproduksi, $p){
      $hasil = 0;
      $r = array();
     //dd($p);
      foreach ($targetproduksi as $t){
         //dd($t->process_name);
      if ( $t->process_name == $p){
         $hasil =  $t->target;
         return $hasil;
      }
   }
   //array_push($r,$t->process_cd);
  //dd($hasil);
   return $hasil;
   }

   public function gettarget2($targetshikakari, $p){
      $hasil = 0;
      $r = array();
      //dd($targetproduksi);
      foreach ($targetshikakari as $t){
      if ( $t->process_name == $p){
         $hasil =  $t->target;
         return $hasil;
      }
   }
   //array_push($r,$t->process_cd);
  // dd($r);
   return $hasil;
   }

   public function NGreport_produksi(){
     

     // $location = DB::connection('oracle')->select("select v_name, v_loc_cd from NPR_WIPNMMS");
     //$location = DB::table('tb_line')->get();
     $jenis = DB::table("tb_master_ng_produksi")->select("kode_ng","type_ng")->get();
   
     $location = DB::select("select a.line_proses, b.nama_line from tb_hasil_produksi a left join tb_line b on a.line_proses = b.kode_line group by a.line_proses, b.nama_line");

      return view ('produksi.NGreport',['location'=>$location,'jenis_ng'=>$jenis]);
   }

   public function successrate(Request $request){
      $tgl1 = $request->input("tanggalawal");
      $tgl2 = $request->input("tanggalakhir");
      $pro1 = $request->input("prosesawal");
      $pro2 = $request->input("prosesakhir");
      
      $start_date = date_create($tgl1);
      $end_date = date_create($tgl2);
    
      //Compring fmono
      $finish_compf = 0;
      $start_compf =0;
      $finish_compcr =0;
      $start_compcr = 0;
      $finish_oilf =0;
      $start_oilf =0;
      $finish_oilcr = 0;
      $start_oilcr =0;
      $liner_start = 0;
      $liner_finish =0;
      $pros1 = $pro1;
      
      if($pro1 == "10" && $pro2 == "320"){
         $pro1 = $pro2;
      }
      $sy = $start_date->format("Y");
      $sm = $start_date->format("n");
      $sd = $start_date->format("j");

      $ed = $end_date->format("j");

      if ($start_date->format("Ym") == date("Ym") && $end_date->format("Ym") == date("Ym")) {
         $sql_query = "select t3.ng_code, t3.ng_type, sum(t3.ng_qty) as qty, (sum(t3.ng_qty)/a.total)*100.00 as persen from
         (select part_no, lot_no, type, crf from tb_hasil_produksi where line_proses = $pro2 and YEAR(tgl_proses) = $sy and MONTH(tgl_proses) = $sm and datepart(DAY,tgl_proses) >= $sd and datepart(DAY,tgl_proses) <= $ed) t1
         left join
         (select id_hasil_produksi, line_proses, part_no, lot_no, start_qty, finish_qty from tb_hasil_produksi where line_proses >= $pros1 and line_proses <= $pro2) t2 on t1.lot_no = t2.lot_no
         left join
         (select id_hasil_produksi, ng_code, ng_type, ng_qty from tb_ng_produksi where ng_code not in('SISA'))t3 on t3.id_hasil_produksi = t2.id_hasil_produksi,
         (select sum(start_qty)as total from tb_hasil_produksi where line_proses = $pro2 and YEAR(tgl_proses) = $sy and MONTH(tgl_proses) = $sm and datepart(DAY,tgl_proses) >= $sd and datepart(DAY,tgl_proses) <= $ed) a
         group by t3.ng_code, t3.ng_type,a.total order by (sum(t3.ng_qty)/a.total)*100.00 desc";
      }else{
         $sql_query = "select t3.ng_code, t3.ng_type, sum(t3.ng_qty) as qty, (sum(t3.ng_qty)/a.total)*100.00 as persen from
         (select part_no, lot_no, type, crf from tb_hasil_produksi where line_proses = $pro2 and tgl_proses >= '$tgl1' and tgl_proses <= '$tgl2') t1
         left join
         (select id_hasil_produksi, line_proses, part_no, lot_no, start_qty, finish_qty from tb_hasil_produksi where line_proses >= $pros1 and line_proses <= $pro2) t2 on t1.lot_no = t2.lot_no
         left join
         (select id_hasil_produksi, ng_code, ng_type, ng_qty from tb_ng_produksi where ng_code not in('SISA'))t3 on t3.id_hasil_produksi = t2.id_hasil_produksi,
         (select sum(start_qty)as total from tb_hasil_produksi where line_proses = $pro2 and tgl_proses >= '$tgl1' and tgl_proses <= '$tgl2') a
         group by t3.ng_code, t3.ng_type,a.total order by (sum(t3.ng_qty)/a.total)*100.00 desc";
      }

      //$hasil = DB::select(\DB::raw("select line_proses, type, crf, sum(start_qty) as startqty, sum(incoming_qty) as incoming, sum(finish_qty) as finish from tb_hasil_produksi where tgl_proses >= '$tgl1' and tgl_proses <= '$tgl2' and (line_proses = '$pro1' or line_proses = '$pro2') group by line_proses, type, crf"));
      $hasil = DB::select(\DB::raw("select t1.type, t1.crf, sum(t2.start_qty) as start_qty, sum(t1.finish_qty) as finish_qty from
      (select line_proses, part_no, lot_no, type, crf, incoming_qty, finish_qty from tb_hasil_produksi where line_proses = '$pro2' and tgl_proses >= '$tgl1' and tgl_proses <= '$tgl2') t1
      left join
      (select line_proses, part_no, lot_no, start_qty, finish_qty from tb_hasil_produksi where line_proses = '$pro1') t2 on t1.lot_no = t2.lot_no
      group by t1.type, t1.crf"));

      
      //$ng = DB::select(\DB::raw("select b.ng_code, b.ng_type, sum(b.ng_qty) as qty from tb_hasil_produksi a inner join tb_ng_produksi b on a.id_hasil_produksi = b.id_hasil_produksi where a.tgl_proses >= '$tgl1' and a.tgl_proses <= '$tgl2' and(a.line_proses = '$pro1' or a.line_proses = '$pro2') group by b.ng_code, b.ng_type order by sum(b.ng_qty) desc"));
      $ng = DB::select(\DB::raw($sql_query));
      //dd($hasil);
     
      $kensha = DB::select(\DB::raw("select sum(start_qty)as zokei,sum(camu_qty) as camu, sum(incoming_qty) as incoming, sum(finish_qty) as finish, count(lot_no) as lot from tb_hasil_produksi where line_proses = '320' and tgl_proses >= '$tgl1' and tgl_proses <= '$tgl2'"));
      $bad = DB::select(\DB::raw("select top 10 id_hasil_produksi, part_no, lot_no, start_qty, finish_qty, (finish_qty/start_qty) * 100 as perlot from tb_hasil_produksi where line_proses = '320' and tgl_proses >= '$tgl1' and tgl_proses <= '$tgl2' and RIGHT(lot_no,1) != 'A' and part_no not like 'SS%' and id_hasil_produksi not in (select a.id_hasil_produksi from tb_ng_produksi a left join tb_hasil_produksi b on a.id_hasil_produksi = b.id_hasil_produksi where a.ng_code = 'KARA' and b.tgl_proses >= '$tgl1' and b.tgl_proses <= '$tgl2') order by (finish_qty/start_qty)* 100 asc"));
     
      foreach ($hasil as $key) {

         if ($key->type == "COMP" && $key->crf == "F") { //hitung comp f
            $start_compf = $start_compf + $key->start_qty;
            $finish_compf = $finish_compf + $key->finish_qty;
         }else if($key->type == "COMP" && $key->crf == "CR"){ //hitung comp cr
            $start_compcr = $start_compcr + $key->start_qty;
            $finish_compcr = $finish_compcr + $key->finish_qty;
         }else if($key->type == "OIL" && $key->crf == "F"){ //hitung oil F
            $start_oilf = $start_oilf + $key->start_qty;
            $finish_oilf = $finish_oilf + $key->finish_qty;
         }else if($key->type == "OIL" && $key->crf == "CR"){ // hitung oil cr
               $start_oilcr = $start_oilcr + $key->start_qty;
               $finish_oilcr = $finish_oilcr + $key->finish_qty;
            }else{
            $liner_start = $liner_start + $key->start_qty; //hitung liner
            $liner_finish = $liner_finish + $key->finish_qty;
         }

   }
   


    //dd($start_compcr);
        
     $qty_s = $start_compf + $start_compcr + $start_oilf + $start_oilcr + $liner_start;
     $qty_k = $finish_compf + $finish_compcr + $finish_oilf + $finish_oilcr + $liner_finish;

   

     //persentase comp ring
     $persen_compf = $start_compf > 0 ? number_format(($finish_compf / $start_compf)*100,2) : 0;
     $persen_compcr = $start_compcr > 0 ? number_format(($finish_compcr / $start_compcr)*100,2) : 0;

     //persentase oil ring
     $persen_oilf = $start_oilf > 0 ? number_format(($finish_oilf / $start_oilf)*100,2) : 0;
     $persen_oilcr = $start_oilcr > 0 ? number_format(($finish_oilcr / $start_oilcr)*100,2) : 0;
      //$persen_all = number_format(($kensa_compf + $kensa_compcr + $kensa_oilf + $kensa_oilcr)/(($zoukei_compf+$zoukei_compcr+$zoukei_oilf+$zoukei_oilcr)-(($kara_compf+$kara_compcr+$kara_oilf+$kara_oilcr)+($tena_compf+$tena_compcr+$tena_oilf+$tena_oilcr)))*100,2);
      
     // if ($qty_s > 0) {
        $persen_all = $qty_s >0 ? number_format(($qty_k / $qty_s)*100,2) : 0;
     // }else{
    //     $persen_all = 0;
    //  }
     
     

      return array ("success" => true,
      "items"=> $bad,
      "kensa" => $kensha[0],
      "compf"=>$persen_compf,
      "compcr"=>$persen_compcr,
      "oilf" =>$persen_oilf,
      "oilcr" =>$persen_oilcr,
      "all"=>$persen_all,
      "ng"=>$ng);
}

public function lembur(){
 
   return view('produksi.report_lembur');
}

public function grafiklembur(Request $request){
   $tgl1 = $request->input("tgl_awal");
   $tgl2 = $request->input("tgl_akhir");
   $periode = date_format(date_create($tgl1), "Y-m");

   $lembur = DB::connection('sqlsrv_pga')->select("select a.DEPT_SECTION, d.jmlh as totmember, isnull((b.total_jam),0) as jam, isnull((c.target_jam),0) as target_jam from (select DEPT_SECTION from T_DEPARTEMEN group by DEPT_SECTION) a
   left join
   (select NAMA_SECTION, sum(JUMLAH_JAM_LEMBUR) as total_jam from T_LEMBUR where TANGGAL_LEMBUR >= '$tgl1' and TANGGAL_LEMBUR <= '$tgl2' group by NAMA_SECTION) b on a.DEPT_SECTION = b.NAMA_SECTION
   left join
   (select section_name, target_jam from T_TARGET_LEMBUR where periode = '$periode') c on a.DEPT_SECTION = c.section_name
   left join
   (select dept_section, count (dept_section) as jmlh from t_karyawan where dept_section <> 'Admin' and status_karyawan <> 'Off' and nama_jabatan not in ('Supervisor', 'Manager','Assistant Manager') group by dept_section) d on a.dept_section = d.dept_section");

   return $lembur;

}

public function detail_lembur(Request $request){
   //dd($request->all());
   $draw = $request->input("draw");
   $search = $request->input("search")['value'];
   $start = (int) $request->input("start");
   $length = (int) $request->input("length");
   $tgl1 = $request->input("awal");
   $tgl2 = $request->input("akhir");
   $dept =  $request->input("dept");

   $Datas = DB::connection('sqlsrv_pga')->select("select a.NIK, a.NAMA, a.NAMA_SECTION, b.NAMA_JABATAN, sum(a.JUMLAH_JAM_LEMBUR) as total_jam from T_LEMBUR a join T_KARYAWAN b on b.NIK = a.NIK where a.NAMA_SECTION = '$dept' and a.JUMLAH_JAM_LEMBUR is not NULL and a.TANGGAL_LEMBUR >= '$tgl1' and a.TANGGAL_LEMBUR <= '$tgl2' group by a.NIK, a.NAMA, a.NAMA_SECTION, b.NAMA_JABATAN order by a.NAMA asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

   

   $count = DB::connection('sqlsrv_pga')->select("select count(*) as total from (select NIK, NAMA, NAMA_SECTION, sum(JUMLAH_JAM_LEMBUR) as total_jam from T_LEMBUR where NAMA_SECTION = '$dept' and JUMLAH_JAM_LEMBUR is not NULL and TANGGAL_LEMBUR >= '$tgl1' and TANGGAL_LEMBUR <= '$tgl2' group by NIK, NAMA, NAMA_SECTION) a")[0]->total;

   //dd($detail);
   return  [
      "draw" => $draw,
      "recordsTotal" => $count,
      "recordsFiltered" => $count,
      "data" => $Datas
  ];
}
   

   public function list_user(){
      $user = DB::table('tb_user')->get();
      return view('admin.userlist',['tb_user' => $user]);
   }

   public function listuser(Request $request){
      $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");


        $Datas = DB::table('tb_user')
        ->where('user_name','like','%'.$search.'%')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_user')
        ->where('user_name','like','%'.$search.'%')
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
   }

   public function input_target(){
      //$cek = db::table('tb_target')->get();
      //dd($cek);
      $periode = date('Y-m');
      $locationcd= DB::connection('oracle')->select("select v_loc_cd, v_name from npr_wipnmms");
      $t_produksi = TargetModel::select('target')->where('process_cd','=','produksi')->where('periode', 'like', $periode.'%')->first();
      $t_sales = TargetModel::select('target')->where('process_cd','=','Sales')->where('periode', 'like', $periode.'%')->first();
      if (empty($t_produksi)) {
       
        $t_produksi = (object) ['target' => 0];
      }
      if(empty($t_sales)){
         $t_sales = (object) ['target' => 0];
      }
    
      return view('ppic.target',['produksi'=>$t_produksi,'sales'=>$t_sales, 'locationcd'=>$locationcd]);
   }

   public function input_target_produksi (Request $request){
      //dd($request->all());
      $prosess_cd = $request->input("location_cd_1");
      $periode = $request->input("periode");
      $codetarget = $request->input("codetarget");
      $cek = TargetModel::select('process_cd', 'periode')->where('process_cd','=',$codetarget)->where('process_name','=',$prosess_cd)->where('periode','=',$periode.'-01')->count();
        
        if ($cek > 0){
      Session::flash('alert-danger','Data sudah ada.'); 
      return redirect()->route('input_target');
      } else {
    $insert = TargetModel::create([
        'periode'=>$periode."-01",
        'process_cd'=>$codetarget,
        'process_name'=>$prosess_cd,
        'target'=>$request->qtytarget,
    ]);
      }

     if ($insert) {
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }
        return redirect()->route('input_target'); 
   }

   public function input_target_shikakari (Request $request){
      //dd($request->all());
      $prosess_cd_shikakari = $request->input("location_cd_shikakari_1");
      $periode_shikakari = $request->input("periodeshikakari");
      $cek_shikakari = TargetModel::select('process_cd', 'periode')->where('process_cd','=','Shikakari')->where('process_name','=',$prosess_cd_shikakari)->where('periode','=',$periode_shikakari.'-01')->count();
      //dd($cek_shikakari);
        if ($cek_shikakari > 0){
      Session::flash('alert-danger','Data sudah ada.'); 
      return redirect()->route('input_target');
      } else {
    $insert = TargetModel::create([
        'periode'=>$periode_shikakari."-01",
        'process_cd'=>"Shikakari",
        'process_name'=>$prosess_cd_shikakari,
        'target'=>$request->qtytarget_shikakari,
    ]);
      }

     if ($insert) {
            Session::flash('alert-success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }
        return redirect()->route('input_target'); 
   }

   public function permintaan(){
      $dept = Session::get('dept');
      //$jigu = jiguSelesaiModel::where('status','=','open')->where('')->count();
      $jigu = DB::table('tb_jigu_selesai')
               ->join('tb_permintaan_kerja','tb_jigu_selesai.id_permintaan','=','tb_permintaan_kerja.id_permintaan')
               ->where('tb_permintaan_kerja.dept','=',$dept)
               ->where('tb_jigu_selesai.status','=','open')
               ->count();
      return view ('produksi.permintaan',["jigu_selesai"=>$jigu]);
   }
   public function readNotif($type, $id){
      $user = UserModel::find($id);
     
      foreach ($user->unreadNotifications as $key) {
         if ($key->data['type'] == $type) {
            $key->markAsRead();
         }
       
      }

      if ($type == 'perbaikan') { //notifikasi perbaikan maintenance
         
         return redirect()->route('mtc_perbaikan');
      }elseif ($type == 'req_perbaikan') { //notifikasi perbaikan selesai
         return redirect()->route('req_perbaikan');
      }else{
         return redirect()->route('req_permintaan_tch');
      }

   }

   public function laporan_mtc(){
      $dept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->get();
      return view ('maintenance.laporan',["dept"=>$dept]);
   }

   public function tools(){
      $dir = public_path()."/storage/excel";
      $files = scandir($dir);
      //unset($files[1]);
      $list = array_slice($files,2);
      $count = count($list);
      return view('admin.tools',["list_file"=>$list, "total"=>$count]);
   }

   public function deletefile(Request $request){

      if (Session::get('level') != "Admin") {
         Session::flash('alert-danger','Hapus data gagal!'); 
        
      }
      $dir = public_path()."/storage/excel";
      $hapus = array_map('unlink', glob($dir."/*.xlsx"));

      if ($hapus) {
         Session::flash('success','Hapus Data berhasil !'); 
      }else{
         Session::flash('alert-danger','Hapus Data Gagal !'); 
      }

      return redirect()->route('tools');
   }

   public function petunjuk (){
      return view ('admin.petunjuk');
   }

   public function userprofil (){
     /* $user = DB::table('tb_user')->where('id',$id)->get(); 'tb_user' => $user,'departemen'=>$dept, 'level'=>$level] */
      $dept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('DEPT_SECTION')->groupBy('DEPT_SECTION')->get();
      $level = DB::connection('sqlsrv_pga')->table('T_JABATAN')->get();

      return view ('userPage.userprofil',["departemen"=>$dept]);
   }

   public function logs(){
      return view ('admin.log');
   }

   public function listlog(Request $request){
      $draw = $request->input("draw");
      $search = $request->input("search")['value'];
      $start = (int) $request->input("start");
      $length = (int) $request->input("length");
      $awal = $request->input("tgl_awal");
      $akhir = $request->input("tgl_akhir");
     
      $Datas = DB::table('tb_log')
      ->select('tb_log.*','tb_user.user_name')
      ->join('tb_user','tb_user.id','=','tb_log.user_id')
      ->where(\DB::raw('CONVERT(date,tb_log.created_at)'),'>=',$awal)
      ->where(\DB::raw('CONVERT(date,tb_log.created_at)'),'<=',$akhir)
      ->orderBy('tb_log.created_at','asc')
      ->skip($start)
      ->take($length)
      ->get();

      $count =LogModel::where('created_at','>=',$awal)->where('created_at','<=',$akhir)->count();

      return  [
         "draw" => $draw,
         "recordsTotal" => $count,
         "recordsFiltered" => $count,
         "data" => $Datas
     ];
   }

   //=================================================================Manager================================================

   public function targetlembur(){
      return view ('manager.targetlembur');
   }

   public function getargetlembur(Request $request){
      $periode = $request->input("periode");

      $tglembur = DB::connection('sqlsrv_pga')->select("select t1.DEPT_SECTION, t1.KODE_DEPARTEMEN, isnull((t2.target_jam),0) as target_jam from (select DEPT_SECTION, KODE_DEPARTEMEN from T_DEPARTEMEN) t1 left join (select target_jam, section_name, section_cd from T_TARGET_LEMBUR where periode = '$periode') t2 on t1.KODE_DEPARTEMEN = t2.section_cd");
     
     return $tglembur;
   }

   public function postargetlembur(Request $request){

      $periode = $request->get('periode');
      if (!empty($request->get('section_cd'))) {
              
         $size = count(collect($request)->get('section_cd'));
     }else{
         $size = 0;
     }

     $rec = DB::connection('sqlsrv_pga')->select("select count(*) as total from T_TARGET_LEMBUR where periode = '$periode'")[0]->total;

     if ($rec > 0) {
       //update target_lembur
       if ($size > 0) {
         for ($i = 0; $i < $size; $i++){

            $sts = DB::connection('sqlsrv_pga')->table('T_TARGET_LEMBUR')
                     ->where('section_cd',$request->get('section_cd')[$i])
                     ->where('periode', $periode)
                     ->update([
                        'target_jam'=> $request->get('target')[$i],
                        'inputor'=> Session::get('name'),
                        'updated_at' => Carbon::now()
                     ]);
         }
       }


     }else{
        //insert target_lembur
        if ($size > 0) {
         for ($i = 0; $i < $size; $i++){
            $sts = DB::connection('sqlsrv_pga')->table('T_TARGET_LEMBUR')->insert([
               'id_number'=> Str::uuid(),
               'section_cd'=> $request->get('section_cd')[$i],
               'section_name'=> $request->get('section_name')[$i],
               'target_jam'=> $request->get('target')[$i],
               'periode'=> $periode,
               'inputor'=> Session::get('name'),
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now()
            ]);
         }
        }
     }
     if ($sts) {
       $status = true;
       $mess = 'Simpan data berhasil';
     }else{
        $status = false;
        $mess = 'Simpan data gagal';
     }

     return array(
      'message' => $mess,
      'success'=>$status,
   );
    
   }

   public function calendar(){
      return view('layout.calendar');
   }

   public function testevent(){
     $mes = array(
      'judul'=>"test",
      "sub"=>"sub judul",
      "isi"=>"lllkakakakjdjddhdhjj66777shhhhjhsjjkjsjsjksklkslkxmsdlksjdlksjncjsnckdj"
     );
      event(new EventMessage($mes));
   }

   //============================================== HSE =======================================================================

   public function dhhky (Request $request){
      //dd($request->all());
      $tahun = date('Y');
      //$hhky = DB::connection('sqlsrv')->select("select jenis_laporan, count(status_laporan)as jml from tb_hhky  where status_laporan = 'Open' and jenis_laporan != 'SM' group by jenis_laporan");

  /*    $hhky = DB::connection('sqlsrv')->select("select t1.jenis_laporan, t2.jml_hh, t3.jml_ky from
      (select jenis_laporan from tb_hhky where jenis_laporan = 'HH' or jenis_laporan = 'KY' group by jenis_laporan)t1
      left join
      (select jenis_laporan, count(status_laporan)as jml_hh from tb_hhky  where status_laporan = 'Open' and jenis_laporan = 'HH' group by jenis_laporan)t2 on t2.jenis_laporan = t1.jenis_laporan
      left join
      (select jenis_laporan, count(status_laporan)as jml_ky from tb_hhky  where status_laporan = 'Open' and jenis_laporan = 'KY' group by jenis_laporan)t3 on t3.jenis_laporan = t1.jenis_laporan");
*/
   /*   $hhky = DB::connection('sqlsrv')->select("select t1.jenis_laporan, t2.jml_hh from
      (select jenis_laporan from tb_hhky where jenis_laporan != 'SM' group by jenis_laporan)t1
      left join
      (select jenis_laporan, count(status_laporan)as jml_hh from tb_hhky  where status_laporan = 'Open' group by jenis_laporan)t2 on t2.jenis_laporan = t1.jenis_laporan");
   */   
      //dd($hhky);

      $hhky = DB::select("select t1.bagian, isnull((t2.jml),0) as HH ,isnull((t3.jml),0) as KY from 
      (select bagian from tb_hhky where jenis_laporan != 'SM' group by bagian)t1
      left join
      (select bagian, count(jenis_laporan) as jml from tb_hhky where jenis_laporan = 'HH' and status_laporan = 'Open' and year(tgl_lapor) = '$tahun' group by bagian, jenis_laporan)t2 on t1.bagian = t2.bagian
      left join 
      (select bagian, count(jenis_laporan) as jml from tb_hhky where jenis_laporan = 'KY' and status_laporan = 'Open' and year(tgl_lapor) = '$tahun' group by bagian, jenis_laporan)t3 on t1.bagian = t3.bagian");
      //dd($hhky);

      return $hhky;
   }

   public function dlokasi_hhky (Request $request){
      //dd($request->all());
      $tahun = date('Y');
      $draw = $request->input("draw");
      $search = $request->input("search")['value'];
      $start = (int) $request->input("start");
      $length = (int) $request->input("length");
      $jenis = $request->input("jenis");
      $departemen = $request->input("departemen");

     $Datas = DB::select("select t1.id_hhky, t1.pada_saat, t1.tempat_kejadian, t1.menjadi, t2.level_resiko from 
      (select id_hhky, pada_saat, tempat_kejadian, menjadi from tb_hhky where status_laporan = 'Open' and bagian = '$departemen' and jenis_laporan = '$jenis' and year(tgl_lapor) = '$tahun' )t1
      left join
      (select id_hhky, level_resiko from tb_evaluasi where jenis_evaluasi = 'Before')t2 on t1.id_hhky = t2.id_hhky order by t1.tempat_kejadian asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
 

      $count = DB::select("select count(*) as total from(select t1.id_hhky, t1.pada_saat, t1.tempat_kejadian, t1.menjadi, t2.level_resiko from 
      (select id_hhky, pada_saat, tempat_kejadian, menjadi from tb_hhky where status_laporan = 'Open' and bagian = '$departemen' and jenis_laporan = '$jenis' and year(tgl_lapor) = '$tahun' )t1
      left join
      (select id_hhky, level_resiko from tb_evaluasi where jenis_evaluasi = 'Before')t2 on t1.id_hhky = t2.id_hhky)a")[0]->total;


   /*   $Datas = DB::table('tb_hhky')
      ->select('tb_hhky.*','tb_evaluasi.*')
      ->join('tb_evaluasi','tb_evaluasi.id_hhky','=','tb_hhky.id_hhky')
      ->where(\DB::raw('tb_hhky.status_laporan','=','Open'))
      ->where(\DB::raw('tb_hhky.jenis_laporan','=',$lbl))
      ->orderBy('tb_hhky.tempat_kejadian','asc')
      ->skip($start)
      ->take($length)
      ->get();

      $count = DB::table('tb_hhky')
      ->select('tb_hhky.*','tb_evaluasi.*')
      ->join('tb_evaluasi','tb_evaluasi.id_hhky','=','tb_hhky.id_hhky')
      ->where(\DB::raw('tb_hhky.status_laporan','=','Open'))
      ->where(\DB::raw('tb_hhky.jenis_laporan','=',$lbl))
      ->orderBy('tb_hhky.tempat_kejadian','asc')
      ->count();
*/
      return  [
         "draw" => $draw,
         "recordsTotal" => $count,
         "recordsFiltered" => $count,
         "data" => $Datas
     ];
   }

     //============================================== Encrypt =======================================================================

     public function get_encrypt(Request $request){
        $enc = $request->input('enc').','.'NPMISystemProjectGJ'.date('ss');

        //$enc1 = Crypt::encrypt($enc);
        $encode = base64_encode($enc);

        //$real = explode(',',$encode);
        return array('enc'=>$encode);
     }



   //============================================== PGA ===========================================================================

}
