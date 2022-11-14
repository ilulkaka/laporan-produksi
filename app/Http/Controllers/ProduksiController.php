<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserModel;
use App\HasilProduksiModel;
use App\NGProduksiModel;
use App\MasterNGModel;
use App\JamhasiloperatorModel;
use App\LogModel;
use App\ConfigModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Crypt;

class ProduksiController extends Controller
{

  public function menu_produksi(){
    $proses = DB::connection('sqlsrv')->table('tb_line')->get();
    return view ('produksi/startup_produksi',['proses'=>$proses]);
  }

  public function f_approve_jam_operator(){
    $proses = DB::select("select a.line_proses, b.nama_line from 
    (select line_proses from tb_jam_kerja group by line_proses )a
    left join 
    (select kode_line, nama_line from tb_line group by kode_line, nama_line)b on b.kode_line = a.line_proses group by a.line_proses, b.nama_line");
    //dd($proses);
    return view ('produksi/approve_jam_operator',['proses'=>$proses]);
  }

  public function menu_hasil_produksi (){
    return view ('produksi/menu_hasil_produksi');
  }

  public function frm_report_produksi($tgl, $id, $shift){
    //dd($tgl);
    //$tgl = date('Y-m-d');
    $line = DB::table('tb_line')->select('kode_line','dept_section','nama_line')->where('kode_line',$id)->get();
    $line1 = $line[0]->kode_line;
    $line2 = $line[0]->dept_section;
    //dd($line[0]->dept_section);
    $nomerinduk = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama')->where('status_karyawan','<>','Off')->get();  
    $deptdandori = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama')->where('status_karyawan','<>','Off')->where('dept_section','=',$line2)->get();   
    $masterng = DB::connection('sqlsrv')->table('tb_master_ng_produksi')->select('kode_ng','type_ng')->get();
    $oprmoulding = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama')->where('status_karyawan','<>','Off')->where('dept_section','=','CASTING')->get(); 

    //$s2 = HasilProduksiModel::where('tgl_proses','=',$tgl)->where('line_proses',$line[0]->kode_line)
    //->sum('finish_qty');
    $s3 = HasilProduksiModel::select('shift','line_proses')->where('shift','=',$shift)->where('tgl_proses','=',$tgl)->where('line_proses',$line[0]->kode_line)
    ->sum('finish_qty');
    $ratalot = HasilProduksiModel::select('lot_no, ')->where('tgl_proses','=',$tgl)->where('line_proses',$line[0]->kode_line)
    ->count();

    $startF = 0;
    $startCR = 0;
    $finishF = 0;
    $finishCR =0;
    $lot = 0;
    $prosentaseF = 0;
    $prosentaseCR = 0;
    $s1 = 0;
    $s2 = 0;
    $s3 = 0;
    $nonshift = 0;
    $totalshift = 0;
    $shiftnow = 0;
    $compf = 0;
    $compcr = 0;
    $oilf = 0;
    $oilcr = 0;
    $t1bf = 0;
    $t1ic = 0;
    $reg = 0;
    $proses2x = 0;
    $tenaoshi = 0;



    $hasilAll = DB::select("select shift, line_proses, type, crf, count(lot_no) as lot_no, sum(start_qty) as start_qty, sum(incoming_qty) as incoming_qty, sum(finish_qty) as finish_qty, item_type1, item_type2 from tb_hasil_produksi where tgl_proses >= '$tgl' and tgl_proses <= '$tgl' and line_proses = '$line1' group by shift, line_proses, type, crf, item_type1, item_type2");
    $hasil = DB::select("select shift, type, line_proses, crf, sum(incoming_qty) as incoming_qty, sum(finish_qty) as finish_qty, item_type2, remark from tb_hasil_produksi where tgl_proses >= '$tgl' and tgl_proses <= '$tgl' and line_proses = '$line1' and shift = '$shift' group by shift, type, line_proses, crf, item_type2, remark");
    $codeshape = DB::connection('oracle')->select(\DB::raw("SELECT trim(i_item_cd) as i_item_cd, trim(i_item_type2) as i_item_type2  FROM T_PM_MS "));
    $tanegata = DB::connection('oracle')->select(\DB::raw("select trim(i_qry_mtrl) as i_qry_mtrl from t_pm_ms group by i_qry_mtrl order by i_qry_mtrl asc"));

    foreach ($hasilAll as $key1){

      $lot = $lot + $key1->lot_no;

      if ($key1->crf == 'F'){
        $startF = $startF + $key1->incoming_qty;
        $finishF = $finishF + $key1->finish_qty;
      }else {
        $startCR = $startCR + $key1->incoming_qty;
        $finishCR = $finishCR + $key1->finish_qty;
      }

      if($key1->shift == 'SHIFT1'){
        $s1 = $s1 + $key1->finish_qty;
      } elseif ($key1->shift == 'SHIFT2') {
        $s2 = $s2 + $key1->finish_qty;
      } elseif ($key1->shift == 'SHIFT3'){
        $s3 = $s3 + $key1->finish_qty;
      } else {
        $nonshift = $key1->finish_qty;
      }
    }

    
    foreach ($hasil as $key){

      if($key->shift == $shift){
        $shiftnow = $shiftnow + $key->finish_qty;
      }

      if($key->type == 'COMP' && $key->crf == 'F'){
        $compf = $compf + $key->finish_qty;
      } elseif ($key->type == 'COMP' && $key->crf == 'CR') {
        $compcr = $compcr + $key->finish_qty;

        if ($key->item_type2 == 'AD' || $key->item_type2 == 'CA' || $key->item_type2 == 'CB' || $key->item_type2 == 'CC' ) {
          $t1ic = $t1ic + $key->finish_qty;
        } else {
          $t1bf = $t1bf + $key->finish_qty;
        }
        
      } elseif ($key->type == 'OIL' && $key->crf == 'F') {
        $oilf = $oilf + $key->finish_qty;
      } else {
        $oilcr = $oilcr + $key->finish_qty;
      }

      if ($key->remark == 'Reguler'){
        $reg = $reg + $key->finish_qty;
      } elseif ($key->remark == 'Proses2x') {
        $proses2x = $proses2x + $key->finish_qty;
      } else {
        $tenaoshi = $tenaoshi + $key->finish_qty;
      }

    } 

  //dd($compf);

    $totalshift = $s1 + $s2 + $s3 + $nonshift;
    $rataratalot = $lot > 0 ? number_format( ($startCR + $startF) / $lot,2) : 0;

    $prosentaseF =($finishF + $finishCR) > 0 ? number_format($finishF / ($finishF + $finishCR) * 100,2) : 0;
    $prosentaseCR = ($finishF + $finishCR) > 0 ? number_format($finishCR / ($finishF + $finishCR) * 100,2) : 0;

    $pas11 = DB::table('tb_hasil_produksi')->select('total_cycle')->where('tgl_proses','=',$tgl)->where('line_proses','=',$line1)->where('shift','=','SHIFT1')->sum('total_cycle');
    $pas22 = DB::table('tb_hasil_produksi')->select('total_cycle')->where('tgl_proses','=',$tgl)->where('line_proses','=',$line1)->where('shift','=','SHIFT2')->sum('total_cycle');
    $pas33 = DB::table('tb_hasil_produksi')->select('total_cycle')->where('tgl_proses','=',$tgl)->where('line_proses','=',$line1)->where('shift','=','SHIFT3')->sum('total_cycle');
    $pas1 = number_format($pas11, 0);
    $pas2 = number_format($pas22, 0);
    $pas3 = number_format($pas33, 0);
    //dd($pas1);

    $opr = HasilProduksiModel::select('operator')->where('line_proses',$line[0]->kode_line)->groupBy('operator')->get();    
    //dd($opr);
    return view ('produksi/report_produksi',['nomerinduk'=>$nomerinduk, 'masterng'=>$masterng,'opr'=>$opr, 'line'=>$line, 'shift'=>$shift, 'shiftnow'=>$shiftnow, 'totalshift'=>$totalshift,
     'rataratalot'=>$rataratalot, 'prosentaseF'=>$prosentaseF, 'prosentaseCR'=>$prosentaseCR, 's1'=>$s1, 's2'=>$s2, 's3'=>$s3, 'nonshift'=>$nonshift,
     'compf'=>$compf, 'compcr'=>$compcr, 'oilf'=>$oilf, 'oilcr'=>$oilcr, 't1bf'=>$t1bf, 't1ic'=>$t1ic, 'reg'=>$reg, 'proses2x'=>$proses2x, 'tenaoshi'=>$tenaoshi, 'deptdandori'=>$deptdandori, 'tgl'=>$tgl,
      'tanegata'=>$tanegata, 'oprmoulding'=>$oprmoulding, 'pas1'=>$pas1, 'pas2'=>$pas2, 'pas3'=>$pas3]);
  }

  public function inquery_report (){
    //$proses = DB::connection('sqlsrv')->table('tb_line')->get();
    $proses = DB::connection('sqlsrv')->table('tb_hasil_produksi as a')->leftJoin('tb_line as b','b.kode_line','=','a.line_proses')->select('a.line_proses','b.nama_line')->groupBy('a.line_proses','b.nama_line')->get();
   
    return view ('produksi/list_report_produksi',['proses'=>$proses]);
  }


  public function update_laporan_produksi (Request $request){
    //dd($request->all());
    $kode = $request->kode_ng;
    //dd($kode);
   
    $idHasil = Str::uuid();
    
    $lotno = $request->input('lotno1');
    $partno = $request->input('partno1');
    $barcode = $request->input('barcodeno');
    $idline = $request->input('idline');
    $remark = $request->input('remark');
    $nik = $request->input('nik');
    $operator = $request->input('operator');
    $tanegata = $request->input('tanegata');
    $cast_no = $request->input('cast_no');
    $moulding_opr = $request->input('moulding_opr');
    $moulding_no = $request->input('moulding_no');
    $remark_1 = $request->input('no_urut');
    
    /*$nik = $request['operator'];
    $operator1 = db::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama')->whereIn('nik',$nik)->get();
    $operator = array();
    if($operator1->count() > 0){
        foreach ($operator1 as $x){
          array_push($operator,$x->nama);
        }
    }*/
    //dd($operator);

    $grouping = DB::table('tb_master_ppic')->select('grouping')->where('part_no','=',$partno)->first();

    if ($grouping == null || $grouping == ""){
      $grouping_1 = "Lain";
    } else {
      $grouping_1 = $grouping->grouping;
    }
    //dd($grouping_1);

    $shape = DB::connection('oracle')->select(\DB::raw("SELECT trim(i_drw_no) as i_drw_no, trim(i_item_type1) as i_item_type1, trim(i_item_type2) as i_item_type2  FROM T_PM_MS WHERE i_item_cd = '$partno' "));
    $shape1=$shape[0]->i_drw_no;
    $type1=$shape[0]->i_item_type1;
    $type2=$shape[0]->i_item_type2;
    //dd($type2);

    /*$opr = '';
    for ($i =0; $i < count($operator); $i++){
    if($i == count($operator)-1){
        $opr .=$operator[$i];
      } else {
        $opr .=$operator[$i].', ';
      }
    }*/

    //dd($opr);

    $crf = 0;
    $type = 0;
    $material = 0;

    if(substr($partno,3,1) == "D" || substr($partno,3,1) == "F"){
      $crf = "CR";
    } else{
      $crf = "F";
    }

    if(substr($partno,1,1) == "1"){
      $type = "COMP";
    }elseif (substr($partno,1,1) == "2"){
      $type = "OIL";
    }else{
      $type = "LINER";
    }

    if(substr($lotno,-1)=='Z' || substr($lotno,-2,1) == 'Z'){
      $material = 'NPR';
    } else {
      $material = 'NPMI';
    }

    $ceklotno = HasilProduksiModel::where('lot_no','=',$lotno)->where('line_proses','=',$idline)->where('remark','=','Reguler')->count();
    $cek2x = HasilProduksiModel::where('lot_no','=',$lotno)->where('line_proses','=',$idline)->where('remark','=','Proses2x')->count();
    $lotmes = "    Lot No $lotno Sudah Ada .";

    if ($remark == 'Reguler' && $ceklotno > 0){
      return array(
        'message' => $lotmes,
        'success' => false,
      );
    } elseif ($remark == 'Proses2x' && $cek2x > 0) {
      return array(
        'message' => $lotmes,
        'success' => false,
      );
    } 
    else {
      //$cekbarcode = DB::connection('oracle')->select(\DB::raw("SELECT trim(i_item_cd)as i_item_cd, trim(i_seiban)as i_seiban,trim(i_ind_dest_cd)as i_ind_dest_cd, I_IND_CONTENT, I_ACP_QTY FROM T_PO_TR WHERE I_SEIBAN = (SELECT i_seiban FROM t_PO_TR WHERE I_PO_DETAIL_NO = 2103946232) and i_ind_content in('1C1001','1C4001','1C8001')"));
      if(is_numeric($barcode)){
        $cekbarcode = DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("trim(i_ind_dest_cd)as i_ind_dest_cd, trim(i_item_cd)as i_item_cd, i_seiban"))->where('i_po_detail_no','=',$barcode)->first();
      } else {
        //$cekbarcode = DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("trim(i_ind_dest_cd)as i_ind_dest_cd, trim(i_item_cd)as i_item_cd, i_seiban"))->where('i_seiban','=',$barcode)->first();
        $lotplan = DB::connection('oracle')->select(\DB::raw("SELECT i_item_cd, i_seiban  FROM T_Plan_TR tpt WHERE TRIM(I_SEIBAN) = '$barcode' "));
        $lot1=$lotplan[0]->i_seiban;
        $cekbarcode = DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("trim(i_ind_dest_cd)as i_ind_dest_cd, trim(i_item_cd)as i_item_cd, i_seiban"))->where('i_seiban','=',$lot1)->orderBy('i_seq','asc')->first();
      }
      //dd($cekbarcode);
  
      $finish = $request->input('finish_qty');
      $reject = $request->input('reject');
      $lotno = $cekbarcode->i_seiban;
      $partno = $cekbarcode->i_item_cd;
      if ($cekbarcode->i_ind_dest_cd == '1A5001'){
        /*
        $data = DB::connection('oracle')->table('t_acp_tr')->select(\DB::raw('i_item_cd,i_seiban,i_acp_qty,i_ind_content'))
        ->where(\DB::raw("trim(i_seiban)"),$lotno)
        ->where(function ($q){
          $q->where('i_ind_content','=','1C1001')
          ->orWhere('i_ind_content','=','1C4001')
          ->orWhere('i_ind_content','=','1C8001');
        })
        ->get();
        $data = DB::connection('oracle')->table('t_acp_tr')->select('i_acp_qty','i_ind_content')->where(\DB::raw("trim(i_seiban)"),$lotno)->whereIn('i_ind_content',['1C1001','1C4001','1C8001'])->get();
        */
        $data =  DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("trim(i_item_cd)as i_item_cd, trim(i_seiban)as i_seiban,trim(i_ind_dest_cd)as i_ind_dest_cd, I_IND_CONTENT, I_ACP_QTY, I_STD_PO_QTY"))->where('i_seiban',$lotno)->whereIn('i_ind_content',['1C1001','1C4001','1A5001'])->orderBy('i_seq','asc')->get();
        $lotno = preg_replace('/\s/', '', $lotno);
        //dd($lotno);
        if (substr($partno,0,2) == "SS"){
          $insertHasilProduksi = HasilProduksiModel::create([
            'id_hasil_produksi'=>$idHasil,
            'tgl_proses'=>$request->tgl_proses,
            'part_no'=>$partno,
            'lot_no'=>$lotno,
            'type'=>$type,
            'crf'=>$crf,
            'start_qty'=>($request->finish_qty1)+($request->reject),
            //'camu_qty'=>$data[1]->i_acp_qty,
            'incoming_qty'=>($request->finish_qty1)+($request->reject),
            'finish_qty'=>$request->finish_qty1,
            'line_proses'=>$request->idline,
            'operator'=>$operator,
            'no_mesin'=>$request->no_meja,
            'ng_qty'=>$request->reject,
            'barcode_no'=>$request->barcodeno,
            'shift'=>$request->shift,
            'material'=>$material,
            'cycle'=>$request->cycle,
            'shape'=>$shape1,
            'item_type1'=>$type1,
            'item_type2'=>$type2,
            'remark'=>$remark,
            'grouping'=>$grouping_1,
            'nik'=>$nik,
            'tanegata'=>$tanegata,
            'cast_no'=>$cast_no,
            'moulding_opr'=>$moulding_opr,
            'moulding_no'=>$moulding_no,
            'ukuran_haba_awal'=>$request->input('ukuran_haba_awal'),
            'total_cycle'=>$request->input('total_cycle'),
            'dressing'=>$request->input('dressing'),
            'remark_1'=>$remark_1,
          ]);
        } else {
          if (substr($lotno, -1) == 'A') {
           $startqty = 0;
          }else{
            $startqty = $data[0]->i_acp_qty;
          }
          $insertHasilProduksi = HasilProduksiModel::create([
            'id_hasil_produksi'=>$idHasil,
            'tgl_proses'=>$request->tgl_proses,
            'part_no'=>$partno,
            'lot_no'=>$lotno,
            'type'=>$type,
            'crf'=>$crf,
            'start_qty'=>$startqty,
            'camu_qty'=>$data[1]->i_acp_qty,
          //'incoming_qty'=>$data[2]->i_std_po_qty,
            //'incoming_qty'=>($request->finish_qty1)+($request->reject),
            'incoming_qty'=>$request->incoming_qty,
            'finish_qty'=>$request->finish_qty1,
            'line_proses'=>$request->idline,
            'operator'=>$operator,
            'no_mesin'=>$request->no_meja,
            'ng_qty'=>$request->reject,
            'barcode_no'=>$request->barcodeno,
            'shift'=>$request->shift,
            'material'=>$material,
            'cycle'=>$request->cycle,
            'shape'=>$shape1,
            'item_type1'=>$type1,
            'item_type2'=>$type2,
            'remark'=>$remark,
            'dandoriman'=>$request->dandoriman,
            'dandori'=>$request->dandori,
            'grouping'=>$grouping_1,
            'ukuran_haba'=>$request->ukuran_haba,
            'nik'=>$nik,
            'tanegata'=>$tanegata,
            'cast_no'=>$cast_no,
            'moulding_opr'=>$moulding_opr,
            'moulding_no'=>$moulding_no,
            'ukuran_haba_awal'=>$request->input('ukuran_haba_awal'),
            'total_cycle'=>$request->input('total_cycle'),
            'dressing'=>$request->input('dressing'),
            'remark_1'=>$remark_1,
          ]);
        }
      } else {
  
        $lotno = preg_replace('/\s/', '', $lotno);
        $insertHasilProduksi = HasilProduksiModel::create([
          'id_hasil_produksi'=>$idHasil,
          'tgl_proses'=>$request->tgl_proses,
          'part_no'=>$partno,
          'lot_no'=>$lotno,
          'type'=>$type,
          'crf'=>$crf,
          'start_qty'=>$finish + $reject,
          'incoming_qty'=>$finish + $reject,
          'finish_qty'=>$finish,
          'line_proses'=>$request->idline,
          'operator'=>$operator,
          'no_mesin'=>$request->no_meja,
          'ng_qty'=>$reject,
          'barcode_no'=>$request->barcodeno,
          'shift'=>$request->shift,
          'incoming_qty'=> $reject + $finish,
          'material'=>$material,
          'cycle'=>$request->cycle,
          'shape'=>$shape1,
          'item_type1'=>$type1,
          'item_type2'=>$type2,
          'remark'=>$remark,
          'dandoriman'=>$request->dandoriman,
          'dandori'=>$request->dandori,
          'grouping'=>$grouping_1,
          'ukuran_haba'=>$request->ukuran_haba,
          'nik'=>$nik,
          'tanegata'=>$tanegata,
            'cast_no'=>$cast_no,
            'moulding_opr'=>$moulding_opr,
            'moulding_no'=>$moulding_no,
            'ukuran_haba_awal'=>$request->input('ukuran_haba_awal'),
            'total_cycle'=>$request->input('total_cycle'),
            'dressing'=>$request->input('dressing'),
            'remark_1'=>$remark_1,
        ]);
      }
  
  //dd($request->get('kode_ng'));
          //$hasil .= $kode[$i];  
    if ($insertHasilProduksi) {
          if (!empty($kode)) {
            $coun = count($kode);
            for ($i=0; $i<$coun; $i++){
              $idNG = Str::uuid();
              NGProduksiModel::create([
                'id_ng_produksi'=> $idNG,
                'id_hasil_produksi' => $idHasil,
                'ng_code' => $request->kode_ng[$i],
                'ng_type' => $request->type_ng[$i],
                'ng_qty' => $request->qty_ng[$i],
                
              ]); 
            }
          }

        /*  $countnik = count($nik);
          for ($i=0; $i<$countnik; $i++){
            $idjam = Str::uuid();
            JamhasiloperatorModel::create([
              'id_hasil_operator'=> $idjam,
              'id_hasil_produksi' => $idHasil,
              'nik' => $nik[$i],
              'operator' => $operator[$i],
              
            ]); 
          } */

            return array(
            'message' => 'Update Berhasil !',
            'success' => true,
          );
        } else {
        return array(
            'message' => 'Gagal Update request !',
            'success' => false,
        );
        }
    }
      
  }

  public function getbarcode(Request $request){
    
        $inpbar = $request->input("barcode_no");
        $title = $request->input("title");
        $remark = $request->input("remark");
        $kodeline = $request->kodeline;
      
        if (is_numeric ($inpbar)){
          $codewip = DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("TRIM(i_item_cd)as i_item_cd, TRIM(i_seiban) as i_seiban, i_seq, i_std_po_qty, i_acp_qty"))->where('i_po_detail_no','=',$inpbar)
          ->get();
          $code1 = $codewip[0]->i_seiban;
          $lotplan = DB::connection('oracle')->select(\DB::raw("SELECT i_seiban, i_plan_qty  FROM T_Plan_TR tpt WHERE TRIM(I_SEIBAN) = '$code1' "));
          if (empty($lotplan)){
            return array (
              'message' => "tidak ada record...",
              'success'=>false
            );
          }
          $lot1=$lotplan[0]->i_seiban;
          $fg=$lotplan[0]->i_plan_qty;

        } else {
         
          $lotplan = DB::connection('oracle')->select(\DB::raw("SELECT i_seiban, i_plan_qty  FROM T_Plan_TR tpt WHERE TRIM(I_SEIBAN) = '$inpbar' "));
          if (empty($lotplan)){
            return array (
              'message' => "tidak ada record...",
              'success'=>false
            );
          }
          $lot1=$lotplan[0]->i_seiban;
          $fg=$lotplan[0]->i_plan_qty;
          //dd($lot1);
          $codewip = DB::connection('oracle')->select(\DB::raw("SELECT TRIM(i_item_cd)as i_item_cd, TRIM(i_seiban) as i_seiban, i_seq, i_std_po_qty, i_acp_qty FROM T_Po_TR tpt WHERE I_SEIBAN = '$lot1' and i_seq='1'"));
          //$codewip = DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("TRIM(i_item_cd)as i_item_cd, TRIM(i_seiban) as i_seiban, i_seq, i_std_po_qty, i_acp_qty"))->where(\DB::raw("trim(i_seiban)"),'=',$lot1)->where('I_SEQ','=','1')
          //->get();
        }
        //dd($codewip);
       
       if (empty($codewip[0]->i_seiban)) {
          return array (
            'message' => "tidak ada record...",
            'success'=>false
          );
        }

        $lokal = DB::table('tb_hasil_produksi')->where('lot_no',$codewip[0]->i_seiban)->where('line_proses', $kodeline)->count();
        
        //$b1 = 0;
        if ($kodeline == 40){
          $tane1 = DB::table('tb_hasil_produksi')->select('tanegata')->where('lot_no','=',$codewip[0]->i_seiban)->where('line_proses','=',30)->count();

            if ($tane1 > 0){
              $tane1 = DB::table('tb_hasil_produksi')->select('tanegata')->where('lot_no','=',$codewip[0]->i_seiban)->where('line_proses','=',30)->get();
              $tane = $tane1[0]->tanegata;
              $b1 = DB::table('tb_master_tanegata')->select('b')->where('no_rak','=',$tane)->get();
//
              $b = $b1[0]->b;
            } else {
              $b = 0;
            }
        } else {
          $b = 0;
        }


        //dd($b);

      if ($remark == 'Reguler' && $lokal > 0) {
        return array (
          'message' => "Data sudah ada",
          'success'=>false
        );
      } else {
        $rjt = $codewip[0]->i_std_po_qty - $codewip[0]->i_acp_qty;
  
  
      if($codewip[0]->i_seq == '999' && $kodeline != '320'){
            return array(
              'message' => "tidak ada record.",
              'success'=>false
            );
          } else if($codewip[0]->i_seq == '999' && $kodeline == '320'){
            return array(
              'message' => "Kensa",
              'success'=>true,
              'codekensa' => $codewip,
              'rjt' => $rjt,
              'fg'=>$fg
            );
         
          } else {
            return array (
              'message' => "Produksi",
              'success'=>true,
              'codekensa' => $codewip,
              'rjt' => $rjt,
              'fg'=>$fg,
              'b'=>$b
            );
          }

      }

          //"success"=>true,
  }

  public function master_ng(Request $request){
      //dd($request->all());
      $draw = $request->input("draw");
      $search = $request->input("search")['value'];
      $start = (int) $request->input("start");
      $length = (int) $request->input("length");
 
      $Datas = DB::connection('sqlsrv')->table('tb_master_ng_produksi')
          ->where('kode_ng','like','%'.$search.'%')
          ->orWhere('type_ng','like','%'.$search.'%')
          ->skip($start)
          ->take($length)
          ->get();
      $count = DB::connection('sqlsrv')->table('tb_master_ng_produksi')
          ->where('kode_ng','like','%'.$search.'%')
          ->orWhere('type_ng','like','%'.$search.'%')
          ->count();
    
      return  [
          "draw" => $draw,
          "recordsTotal" => $count,
          "recordsFiltered" => $count,
          "data" => $Datas
      ];
  }

  public function hasilproduksi (Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $tgl = $request->input('tgl');
    $shift = $request->input('shift');
    $line = $request->line;
    //dd($tgl);

    $Datas = HasilProduksiModel::where('shift','=',$shift)->where('tgl_proses','=',$tgl)->where('line_proses','=',$line)
            ->where(function($q) use ($search){
              $q->where('part_no','like','%'.$search.'%')
              ->orwhere('lot_no','like','%'.$search.'%')
              ->orwhere('operator','like','%'.$search.'%');
        })
        ->orderBy('created_at','desc')
        ->skip($start)
        ->take($length)
        ->get();
    $count = HasilProduksiModel::where('shift','=',$shift)->where('tgl_proses','=',$tgl)->where('line_proses','=',$line)
            ->where(function($q) use ($search){
              $q->where('part_no','like','%'.$search.'%')
              ->orwhere('lot_no','like','%'.$search.'%')
              ->orwhere('operator','like','%'.$search.'%');
        })
        ->count();

      /*  $Datas = HasilProduksiModel::where('shift','=',$shift)->where('line_proses','=',$line)
        ->skip($start)
        ->take($length)
        ->get();

        $count = HasilProduksiModel::where('shift','=',$shift)->where('line_proses','=',$line)
        ->count(); */
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function detail_inquery_report (Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $tgl_awal = $request->input("tgl_awal");
    $tgl_akhir = $request->input("tgl_akhir");

    $line_proses1 = $request->input("selectline");
    //dd($line_proses1);
    //$datass = DB::table('tb_hasil_produksi')->get();
    $datass = DB::select(\DB::raw("select line_proses from tb_hasil_produksi group by line_proses"));
    $listdatass= array();
    //dd($datass);

    if ($line_proses1 == "All") {
        foreach ($datass as $key) {
            array_push($listdatass,$key->line_proses);
        }
        }else {
       
            array_push($listdatass, $line_proses1);
        
    } 
    
    //dd($listdatass);

    $Datas = DB::table('tb_hasil_produksi as a')->leftJoin('tb_line as b','a.line_proses','=','b.kode_line')->select(DB::raw('a.id_hasil_produksi, (b.nama_line) as line1, a.tgl_proses, a.part_no, a.lot_no, a.incoming_qty, a.finish_qty, a.ng_qty, a.operator, a.shift, a.total_cycle, a.shape,  a.no_mesin,(a.finish_qty  / a.incoming_qty * 100)as pro, a.ukuran_haba, a.remark'))
    ->where('a.tgl_proses','>=',$tgl_awal)->where('a.tgl_proses','<=',$tgl_akhir)->whereIn('a.line_proses',$listdatass)         
        ->where(function($q) use ($search){
            $q->where('a.part_no','like','%'.$search.'%')
            ->orwhere('a.lot_no','like','%'.$search.'%')
            ->orwhere('a.operator','like','%'.$search.'%')
            ->orwhere('a.ukuran_haba','like','%'.$search);
    }) 
        ->skip($start)
        ->take($length)
        ->get();
    $count = DB::table('tb_hasil_produksi as a')->leftJoin('tb_line as b','a.line_proses','=','b.kode_line')->select(DB::raw('a.id_hasil_produksi, (b.nama_line) as line1, a.tgl_proses, a.part_no, a.lot_no, a.incoming_qty, a.finish_qty, a.ng_qty, a.operator, a.shift, a.total_cycle, a.shape,  a.no_mesin,(a.finish_qty  / a.incoming_qty * 100)as pro, a.ukuran_haba, a.remark'))
    ->where('a.tgl_proses','>=',$tgl_awal)->where('a.tgl_proses','<=',$tgl_akhir)->whereIn('a.line_proses',$listdatass)         
    ->where(function($q) use ($search){
        $q->where('a.part_no','like','%'.$search.'%')
        ->orwhere('a.lot_no','like','%'.$search.'%')
        ->orwhere('a.operator','like','%'.$search.'%')
        ->orwhere('a.ukuran_haba','like','%'.$search);
    }) 
        ->count();
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function detail_ng (Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $id_hasil_produksi = $request->input("id_hasil_produksi");

    $Datas = NGProduksiModel::where('id_hasil_produksi','=',$id_hasil_produksi)
        ->skip($start)
        ->take($length)
        ->get();
    $count = NGProduksiModel::where('id_hasil_produksi','=',$id_hasil_produksi)
        ->count();
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function hapus_hasil_produksi (Request $request){
    $tgl = date('Y-m-d');
    $Hasil = $request->input('id_hasil_produksi');
    $line = $request->input('line_proses');

    //dd($line);
    $req = HasilProduksiModel::find($Hasil);
    $req1 = NGProduksiModel::find($req);

    //$ng = NGProduksiModel::select('id_ng_produksi')->where('id_hasil_produksi','=',$Hasil);
    //dd($req->tgl_proses);
    
    if($req->tgl_proses == $tgl){
      if($req->line_proses == $line){
        $req->delete();
        //$ng->delete();
  
        $details = [
          'id_req' => $Hasil,
          'status'=>'Delete',
      ];
  
      $data = [
          'record_no' => Str::uuid(),
          'user_id' => $line,
          'activity' =>"Delete",
          'message' => $details,
      ];
      LogModel::create($data);
      return array (
        'message' => "Hapus Berhasil .",
        'success'=>true
      );
      } /*else {
        return array (
          'message' => "ID Request tidak valid .",
          'success'=>false
        );
      }*/
    }else {
      return array (
        'message' => "Invalid Date .",
        'success'=>false
      );
    }
  }

  public function get_excel_hasilproduksi (Request $request){
    //dd($request->all());
    $search = $request->input("search")['value'];
    $tgl_awal = $request->input("tgl_awal");
    $tgl_akhir = $request->input("tgl_akhir");
    $line_proses1 = $request->input("selectline");
    //dd($tgl_awal);
    if ($line_proses1 == "All") {
      $Datas = DB::table('tb_hasil_produksi as a')->leftJoin('tb_line as b','a.line_proses','=','b.kode_line')
      ->select(DB::raw('a.id_hasil_produksi, (b.nama_line) as line1, a.part_no, a.lot_no, a.incoming_qty, a.finish_qty, a.ng_qty, a.operator, a.shift, a.no_mesin,(a.finish_qty  / a.incoming_qty * 100)as pro, a.type, a.crf, a.created_at, a.start_qty, a.tgl_proses, a.remark'))
      ->where('a.tgl_proses','>=',$tgl_awal)->where('a.tgl_proses','<=',$tgl_akhir)       
          ->where(function($q) use ($search){
              $q->where('a.part_no','like','%'.$search.'%')
              ->orwhere('a.lot_no','like','%'.$search.'%')
              ->orwhere('a.operator','like','%'.$search.'%');
      })
      ->get();
        }else {
          $Datas = DB::table('tb_hasil_produksi as a')->leftJoin('tb_line as b','a.line_proses','=','b.kode_line')
          ->select(DB::raw('a.id_hasil_produksi, (b.nama_line) as line1, a.part_no, a.lot_no, a.incoming_qty, a.finish_qty, a.ng_qty, a.operator, a.shift, a.no_mesin,(a.finish_qty  / a.incoming_qty * 100)as pro, a.type, a.crf, a.created_at, a.start_qty, a.tgl_proses, a.remark'))
          ->where('a.tgl_proses','>=',$tgl_awal)->where('a.tgl_proses','<=',$tgl_akhir)->where('a.line_proses',$line_proses1)         
              ->where(function($q) use ($search){
                  $q->where('a.part_no','like','%'.$search.'%')
                  ->orwhere('a.lot_no','like','%'.$search.'%')
                  ->orwhere('a.operator','like','%'.$search.'%');
          })
          ->get();
    } 

    //dd($Datas);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1','NO');
    $sheet->setCellValue('B1','PROSES');
    $sheet->setCellValue('C1','TYPE');
    $sheet->setCellValue('D1','CRF');
    $sheet->setCellValue('E1','PART NO');
    $sheet->setCellValue('F1','LOT NO');
    $sheet->setCellValue('G1','START QTY');
    $sheet->setCellValue('H1','INCOMING');
    $sheet->setCellValue('I1','FINISH');
    $sheet->setCellValue('J1','NG');
    $sheet->setCellValue('K1','PROSENTASE');
    $sheet->setCellValue('L1','OPERATOR');
    $sheet->setCellValue('M1','SHIFT');
    $sheet->setCellValue('N1','MESIN NO');
    $sheet->setCellValue('O1','PROSES DATE');
    $sheet->setCellValue('P1','REMARK');
    $sheet->setCellValue('Q1','Created_Date');

    $line = 2;
    $no = 1;
    foreach ($Datas as $data) {
        $sheet->setCellValue('A'.$line,$no++);
        $sheet->setCellValue('B'.$line,$data->line1);
        $sheet->setCellValue('C'.$line,$data->type);
        $sheet->setCellValue('D'.$line,$data->crf);
        $sheet->setCellValue('E'.$line,$data->part_no);
        $sheet->setCellValue('F'.$line,$data->lot_no);
        $sheet->setCellValue('G'.$line,$data->start_qty);
        $sheet->setCellValue('H'.$line,$data->incoming_qty);
        $sheet->setCellValue('I'.$line,$data->finish_qty);
        $sheet->setCellValue('J'.$line,$data->ng_qty);
        $sheet->setCellValue('K'.$line,$data->pro);
        $sheet->setCellValue('L'.$line,$data->operator);
        $sheet->setCellValue('M'.$line,$data->shift);
        $sheet->setCellValue('N'.$line,$data->no_mesin);
        $sheet->setCellValue('O'.$line,$data->tgl_proses);
        $sheet->setCellValue('P'.$line,$data->remark);
        $sheet->setCellValue('Q'.$line,$data->created_at);
        $line++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = "Rekap_Hasil_Produksi".date('YmdHis').".xlsx";
    $writer->save(public_path("storage/excel/".$filename));
    return ["file"=>url("/")."/storage/excel/".$filename];
  }

  public function tambahng (Request $request){
    $code = $request->input('t_code_ng');
    $type = $request->input('t_type_ng');

    $cek = MasterNGModel::where('kode_ng','=',$code)->count();

    if($cek > 0){
      return array(
        'message' => "Kode sudah ada.",
        'success'=> false,
    );
    }else{
      $tambah = MasterNGModel::create([
        'id_master_ng_produksi' => Str::uuid(),
        'kode_ng' => $code,
        'type_ng' => $type,
      ]);
      return array(
        'message' => "Tambah NG Berhasil .",
        'success'=> true,
    );
    }
  }

  public function deleteng (Request $request){
    $id_masterng = $request->input('id_master_ng_produksi');

    $del = MasterNGModel::where('id_master_ng_produksi',$id_masterng)->delete();

    return array(
      'message' => "Delete NG Berhasil .",
      'success'=> true,
  );
  }

  public function listng (Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $Datas = DB::table('tb_master_ng_produksi')
        ->skip($start)
        ->take($length)
        ->get();
    $count = DB::table('tb_master_ng_produksi')
        ->count();
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function listrekap (Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $tgl1 = $request->input('tgl1');
    $tgl2 = $request->input('tgl2');
    $opr = $request->input('opr');
    //dd($opr);
    $datass = DB::table('tb_hasil_produksi')->select('operator')->groupBy('operator')->get();
    $listdatass= array();
    //dd($datass->operator);

    if ($opr == "All") {
        foreach ($datass as $key) {
            array_push($listdatass,$key->operator);
        }
        }else {
        foreach ($datass as $key) {
            array_push($listdatass, $opr);
        }
    } 
    
    //dd($listdatass);

    $Datas = db::table('tb_hasil_produksi')->select(DB::Raw('operator, sum(finish_qty)as total, sum(ng_qty)as totalng'))->where('tgl_proses','>=',$tgl1)->where('tgl_proses','<=',$tgl2)->whereIn('operator',$listdatass)->groupBy('operator')
    ->where(function($q) use ($search){
            $q->where('operator','like','%'.$search.'%')
            ->orwhere('finish_qty','like','%'.$search.'%');
    }) 
        ->skip($start)
        ->take($length)
        ->get();
    $count = db::table('tb_hasil_produksi')->select(DB::Raw('operator, sum(finish_qty)as total, sum(ng_qty)as totalng'))->where('tgl_proses','>=',$tgl1)->where('tgl_proses','<=',$tgl2)->whereIn('operator',$listdatass)->groupBy('operator')      
    ->where(function($q) use ($search){
        $q->where('operator','like','%'.$search.'%')
        ->orwhere('finish_qty','like','%'.$search.'%');
    }) 
        ->count();
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];

  }

  public function del_lotno (Request $request){

    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $dept = $user->departemen;
    $id = $request->input('id');
    $req = HasilProduksiModel::find($id);
    //$ng = NGProduksiModel::find($id);
    //dd($user);

    $line = DB::table('tb_line')->select('dept_section')->where('kode_line','=',$req->line_proses)->get();
    //dd($line[0]->dept_section);

    if ($dept == "Admin") {
      $req->delete();
    $status = true;
    $mess = "Delete berhasil";
      //Session::flash('alert-success','Hapus Request berhasil !'); 
    }else if ($line[0]->dept_section == $dept) {
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
        'id_hasil_produksi' => $id,
        'no_req' => $req->lot_no,
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

  public function groupchart(Request $request){
    //dd($request->all());
    $str = explode("-", $request->input("jenis"));
    $type = strtoupper($str[0]);
    $crf = strtoupper($str[1]);
    $awal = $request->input("awal");
    $akhir = $request->input("akhir");
    $pros1 = $request->input("pros1");
    $pros2 = $request->input("pros2");

    if($pros1 == "10" && $pros2 == "320"){
      $pros1 = $pros2;
   }

    $datas = DB::select(\DB::raw("select t3.ng_code, t3.ng_type, sum(t3.ng_qty) as qty,ROUND(ISNULL(((sum(t3.ng_qty)/ NULLIF(c.mulai,0))),0) * 100.0,2)  as persen from
    (select part_no, lot_no, type, crf from tb_hasil_produksi where line_proses = '$pros2' and tgl_proses >= '$awal' and tgl_proses <= '$akhir' and type = '$type' and crf ='$crf') t1
    left join
    (select id_hasil_produksi, line_proses, part_no, lot_no, start_qty, finish_qty from tb_hasil_produksi where CONVERT(int,line_proses) >= CONVERT(int,'$pros1') and CONVERT(int,line_proses) <= CONVERT(int,'$pros2')) t2 on t1.lot_no = t2.lot_no
    inner join
    (select id_hasil_produksi, ng_code, ng_type, ng_qty from tb_ng_produksi where ng_code not in('SISA'))t3 on t3.id_hasil_produksi = t2.id_hasil_produksi
    cross join
	(select sum(start_qty) as mulai from tb_hasil_produksi where line_proses = '$pros1' and lot_no in(select lot_no from tb_hasil_produksi where line_proses = '$pros1' and tgl_proses >= '$awal' and tgl_proses <= '$akhir' and type = '$type' and crf ='$crf'))c
    group by t3.ng_code, t3.ng_type,c.mulai order by sum(t3.ng_qty) desc"));

    return array(
      'success'=>true,
      'chart' => $datas,
    );
  }
  public function itemng(Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $str = explode("-", $request->input("jenis"));
    $type = strtoupper($str[0]);
    $crf = strtoupper($str[1]);
    $awal = $request->input("awal");
    $akhir = $request->input("akhir");
    $pros1 = $request->input("pros1");
    $pros2 = $request->input("pros2");
    $ngtype = $request->input("ngtyp");

    $datas = DB::select(\DB::raw("select t2.id_hasil_produksi, t2.part_no, t2.lot_no, tl.nama_line, t2.operator, t2.no_mesin,t2.tgl_proses, t3.ng_qty,t3.ng_type,(t3.ng_qty/t2.start_qty)*100 as prosentase from
    (select part_no, lot_no from tb_hasil_produksi where line_proses = '$pros2' and tgl_proses >= '$awal' and tgl_proses <= '$akhir' and type = '$type' and crf ='$crf' and (part_no like '%$search%' or operator like '%$search%')) t1
    left join
    (select id_hasil_produksi, part_no, lot_no, line_proses,operator,no_mesin,tgl_proses, start_qty from tb_hasil_produksi where CONVERT(int,line_proses) >= CONVERT(int,'$pros1') and CONVERT(int,line_proses) <= CONVERT(int,'$pros2')) t2 on t1.lot_no = t2.lot_no
    inner join
    (select id_hasil_produksi, ng_code, ng_type, ng_qty from tb_ng_produksi where ng_type ='$ngtype')t3 on t3.id_hasil_produksi = t2.id_hasil_produksi
    left join
    (select kode_line, nama_line from tb_line)tl on tl.kode_line = t2.line_proses
	order by (t3.ng_qty/t2.start_qty)*100 desc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY"));

    $co = DB::select(\DB::raw("select t2.id_hasil_produksi, t2.part_no, t2.lot_no, tl.nama_line, t2.operator, t2.no_mesin,t2.tgl_proses, t3.ng_qty,t3.ng_type from
    (select part_no, lot_no from tb_hasil_produksi where line_proses = '$pros2' and tgl_proses >= '$awal' and tgl_proses <= '$akhir' and type = '$type' and crf ='$crf' and (part_no like '%$search%' or operator like '%$search%')) t1
    left join
    (select id_hasil_produksi, part_no, lot_no, line_proses,operator,no_mesin,tgl_proses from tb_hasil_produksi where CONVERT(int,line_proses) >= CONVERT(int,'$pros1') and CONVERT(int,line_proses) <= CONVERT(int,'$pros2')) t2 on t1.lot_no = t2.lot_no
    inner join
    (select id_hasil_produksi, ng_code, ng_type, ng_qty from tb_ng_produksi where ng_type ='$ngtype')t3 on t3.id_hasil_produksi = t2.id_hasil_produksi
    left join
    (select kode_line, nama_line from tb_line)tl on tl.kode_line = t2.line_proses"));
  //dd(count($count));

    $count = count($co);

      return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $datas
    ];
  }

  public function graph_month(Request $request){
    //$amb = DB::select(\DB::raw("select DATEPART(MM, tgl_proses) as bulan, type, crf, material, sum(start_qty) as start, sum(finish_qty) as finish from tb_hasil_produksi where DATEPART(YYYY, tgl_proses) = DATEPART(YYYY, GETDATE()) group by DATEPART(MM, tgl_proses), type, crf, material"));
    $now = date('Y-m-d');
    $amb = DB::select(\DB::raw("select DATEPART(MM, tbm.Date) as bln, tm.* from
    (SELECT  TOP (DATEDIFF(MONTH,CONVERT(datetime, DATEADD(YEAR, DATEDIFF(YEAR, 0, '$now'), 0)), DATEADD(yy, DATEDIFF(yy, 0, '$now') + 1, -1)) + 1)
            Date = convert(varchar, EOMONTH(DATEADD(MONTH, ROW_NUMBER() OVER(ORDER BY a.object_id) - 1, CONVERT(datetime, DATEADD(YEAR, DATEDIFF(YEAR, 0, '$now'), 0)))), 23) 
    FROM    sys.all_objects a
            CROSS JOIN sys.all_objects b)tbm
    left join
    (select DATEPART(MM, tgl_proses) as bulan, type, crf, material, sum(start_qty) as start, sum(finish_qty) as finish from tb_hasil_produksi where DATEPART(YYYY, tgl_proses) = DATEPART(YYYY, GETDATE()) and line_proses = '320' group by DATEPART(MM, tgl_proses),type, crf, material) tm on tm.bulan = DATEPART(MM, tbm.Date)"));
    //dd($amb);
    $res= [];
    for ($i=0; $i < 13; $i++) { 
     $res[$i]= (object)[
       'bulan'=>0,
      'COMP_Fs'=> 0,
      'COMP_Ff'=> 0,
      'COMP_CRs'=>0,
      'COMP_CRf'=>0,
      'OIL_CRs' =>0,
      'OIL_CRf' =>0,
      'OIL_Fs' =>0,
      'OIL_Ff' =>0,
      'NPRs' =>0,
      'NPRf'=>0,
      'NPMIs'=>0,
      'NPMIf'=>0,
      'LINERs'=>0,
      'LINERf'=>0,
        ];
    
    }
   
    foreach ($amb as $key) {

      $compfstart = 0;
      $compcrstart = 0;
      $oilfstart =0;
      $oilcrstart =0;
      $compffin = 0;
      $compcrfin = 0;
      $oilffin =0;
      $oilcrfin =0;
      $linerstart = 0;
      $linerfin = 0;
      $nprstart = 0;
      $npmistart =0;
      $nprfin = 0;
      $npmifin =0;

     
        if ($key->type == "COMP" && $key->crf == "F") {
          $compfstart = $compfstart + $key->start;
          $compffin = $compffin + $key->finish;
        }elseif($key->type == "COMP" && $key->crf == "CR"){
          $compcrstart = $compcrstart + $key->start;
          $compcrfin = $compcrfin + $key->finish;
        }elseif($key->type == "OIL" && $key->crf == "F"){
          $oilfstart = $oilfstart + $key->start;
          $oilffin = $oilffin + $key->finish;
        }elseif($key->type == "OIL" && $key->crf == "CR"){
          $oilcrstart = $oilcrstart + $key->start;
          $oilcrfin = $oilcrfin + $key->finish;
        }else{
          $linerstart = $linerstart + $key->start;
          $linerfin = $linerfin + $key->finish;
        }
        if ($key->material == "NPR") {
          $nprstart = $nprstart + $key->start;
          $nprfin = $nprfin + $key->finish;
        }else{
          $npmistart = $npmistart + $key->start;
          $npmifin = $npmifin + $key->finish;
        }

     
    $res[$key->bln]= (object)[
      'bulan'=>$key->bln,
      'COMP_Fs'=> $res[$key->bln]->COMP_Fs + $compfstart,
      'COMP_CRs'=>$res[$key->bln]->COMP_CRs + $compcrstart,
      'COMP_Ff'=> $res[$key->bln]->COMP_Ff + $compffin,
      'COMP_CRf'=>$res[$key->bln]->COMP_CRf + $compcrfin,
      'OIL_CRs' =>$res[$key->bln]->OIL_CRs + $oilcrstart,
      'OIL_CRf' =>$res[$key->bln]->OIL_CRf + $oilcrfin,
      'OIL_Fs' =>$res[$key->bln]->OIL_Fs + $oilfstart,
      'OIL_Ff' =>$res[$key->bln]->OIL_Ff + $oilffin,
      'NPRs' =>$res[$key->bln]->NPRs + $nprstart,
      'NPRf'=>$res[$key->bln]->NPRf + $nprfin,
      'NPMIs'=>$res[$key->bln]->NPMIs + $npmistart,
      'NPMIf'=>$res[$key->bln]->NPMIf + $npmifin,
      'LINERs'=>$res[$key->bln]->LINERs + $linerstart,
      'LINERf'=>$res[$key->bln]->LINERf + $linerfin,
        ];
    }
    unset($res[0]);
    //dd($res);
    $val = array();
    foreach ($res as $k) {
      array_push($val, (object)[
        'bulan'=>$k->bulan,
        'COMP_F'=>$k->COMP_Fs > 0 ? number_format(($k->COMP_Ff / $k->COMP_Fs)*100,2): 0,
        'COMP_Cr'=>$k->COMP_CRs > 0 ? number_format(($k->COMP_CRf / $k->COMP_CRs)*100,2) : 0,
        'OIL_F'=>$k->OIL_Fs > 0 ? number_format(($k->OIL_Ff / $k->OIL_Fs)*100,2): 0,
        'OIL_Cr'=>$k->OIL_CRs > 0 ? number_format(($k->OIL_CRf / $k->OIL_CRs)*100,2) : 0,
        'LINER'=>$k->LINERs > 0 ? number_format(($k->LINERf / $k->LINERs)*100,2) : 0,
        'NPR'=>$k->NPRs > 0 ? number_format(($k->NPRf / $k->NPRs)*100,2): 0,
        'NPMI'=>$k->NPMIs > 0 ? number_format(($k->NPMIf / $k->NPMIs)*100,2): 0,
      ]);
    }

    return array(
      'success'=>true,
      'data'=>$val,
    );
  
  }

  public function ngperitem(Request $request){
   
    $lot = $request->input("id");
    $datas = DB::select(\DB::raw("select  t1.ng_code, t1.ng_type, sum(t1.ng_qty) as qty from
    (select a.id_hasil_produksi, b.ng_code, b.ng_type, b.ng_qty from tb_hasil_produksi a inner join tb_ng_produksi b on a.id_hasil_produksi = b.id_hasil_produksi where a.lot_no = '$lot') t1 
    group by  t1.ng_code, t1.ng_type 
    
    union all
    select 'OT', 'OTHER', (t1.start_qty - t1.finish_qty) - t2.ng from
    (select lot_no, start_qty, finish_qty from tb_hasil_produksi where lot_no = '$lot' and line_proses = '320')t1
    join
    (select a.lot_no, sum(b.ng_qty) as ng from tb_hasil_produksi a inner join tb_ng_produksi b on a.id_hasil_produksi = b.id_hasil_produksi where a.lot_no = '$lot' group by a.lot_no) t2 on t1.lot_no = t2.lot_no
    order by sum(t1.ng_qty) desc"));
   
    return array(
      'success'=>true,
      'chart' => $datas,
    );
  }

  public function perproses(Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $lotno =  $pros1 = $request->input("id");
    $datas = DB::select(\DB::raw("select t1.id_hasil_produksi, t1.part_no, t1.lot_no, t3.nama_line, t1.operator, t1.no_mesin,t1.tgl_proses, t2.ng_qty,t2.ng_type, (t2.ng_qty / t1.start_qty) * 100 as prosentase from
    (select id_hasil_produksi, part_no, lot_no, line_proses, operator, no_mesin, tgl_proses, start_qty from tb_hasil_produksi where lot_no = '$lotno') t1
    inner join
    (select id_hasil_produksi, ng_qty, ng_type from tb_ng_produksi) t2 on t1.id_hasil_produksi = t2.id_hasil_produksi
    left join
    (select kode_line, nama_line from tb_line)t3 on t1.line_proses = t3.kode_line
	  order by (t2.ng_qty / t1.start_qty) * 100 desc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY"));

    $co = DB::select(\DB::raw("select t1.id_hasil_produksi, t1.part_no, t1.lot_no, t3.nama_line, t1.operator, t1.no_mesin,t1.tgl_proses, t2.ng_qty,t2.ng_type, (t2.ng_qty / t1.start_qty) * 100 as prosentase from
    (select id_hasil_produksi, part_no, lot_no, line_proses, operator, no_mesin, tgl_proses, start_qty from tb_hasil_produksi where lot_no = '$lotno') t1
    inner join
    (select id_hasil_produksi, ng_qty, ng_type from tb_ng_produksi) t2 on t1.id_hasil_produksi = t2.id_hasil_produksi
    left join
    (select kode_line, nama_line from tb_line)t3 on t1.line_proses = t3.kode_line"));
  //dd(count($count));

    $count = count($co);

      return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $datas
    ];
  }
  

  public function ceklot (){
    $tgl = date('Y-m-d');
    //$tgl = date('21-09-11');
    //dd($tgl);
    $cek = DB::connection('oracle')->table('t_po_tr')->select(\DB::raw("i_item_cd, trim(i_seiban)as i_seiban"))->where('i_upd_date','=',$tgl)->where('i_seq','=','999')->where('i_po_comp_cls','=','01')->get();
    //$cekhasil = DB::table('tb_hasil_produksi')->select('part_no', 'lot_no')->where('tgl_proses','=',$tgl)->where('line_proses','=',320)->get();
    //dd($cekhasil);
    $ceklot= array();

    foreach  ($cek as $lot){
      $cekhasil = DB::table('tb_hasil_produksi')->select('part_no', 'lot_no')->where('tgl_proses','=',$tgl)->where('line_proses','=',320)->where('lot_no','=',$lot->i_seiban)->count();
      //dd($cekhasil);
      if ($cekhasil == 0){
        array_push($ceklot,(object)['lot_no'=>$lot->i_seiban, 'part_no'=>$lot->i_item_cd] );
      } 
    }
    //dd($ceklot);

    if (count($ceklot) > 0){
      return array (
        'success'=> true,
        'ceklot'=>$ceklot,
      );
    } else {
      return array (
        'success'=> false,
      );
    }
  }

  public function i_approve_jam_operator (Request $request){
    //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $dept = $user->departemen;

    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    
    //$tgl_proses = $request->input('tgl_proses');
    $selectshift = $request->input('selectshift');
    $line = $request->input('selectline');

    $datass = DB::table('tb_jam_kerja')->select('line_proses', 'shift')->groupBy('line_proses','shift')->get();
    $listdatass= array();

    if ($line == "All") {
        foreach ($datass as $key) {
            array_push($listdatass,$key->line_proses);
        }
        }else {
        foreach ($datass as $key) {
            array_push($listdatass, $line);
        }
    } 

  $listshift= array();
    if ($selectshift == "All") {
      foreach ($datass as $key) {
          array_push($listshift,$key->shift);
      }
      }else {
      foreach ($datass as $key) {
          array_push($listshift, $selectshift);
      }
  } 
    //dd($listshift);

    $Datas = db::table('tb_jam_kerja')->select(DB::Raw('id_jam_kerja, tgl_jam_kerja, operator, line_proses, shift, jam_total, jam_lain, ket, status'))->whereIn('line_proses',$listdatass)->whereIn('shift',$listshift)
    ->where('approve','=',null)
    ->where(function($q) use ($search){
            $q->where('operator','like','%'.$search.'%')
            ->orwhere('line_proses','like','%'.$search.'%');
    })->orderBy('created_at','asc') 
        ->skip($start)
        ->take($length)
        ->get();

    $count = db::table('tb_jam_kerja')->select(DB::Raw('id_jam_kerja, tgl_jam_kerja, operator, line_proses, shift, jam_total, jam_lain, ket, status'))->whereIn('line_proses',$listdatass)->whereIn('shift',$listshift)
    ->where('approve','=',null)
    ->where(function($q) use ($search){
        $q->where('operator','like','%'.$search.'%')
        ->orwhere('line_proses','like','%'.$search.'%');
    }) 
        ->count();
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function i_approve_jam_operator_1 (Request $request){
    //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $dept = $user->departemen;

    $tgl_awal = $request->input("tgl_awal");
    $tgl_akhir = $request->input("tgl_akhir");

    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");

    $selectshift = $request->input('selectshift_1');
    $line = $request->input('selectline_1');

    $datass = DB::table('tb_jam_kerja')->select('line_proses', 'shift')->groupBy('line_proses','shift')->get();
    $listdatass= array();

    if ($line == "All") {
        foreach ($datass as $key) {
            array_push($listdatass,$key->line_proses);
        }
        }else {
        foreach ($datass as $key) {
            array_push($listdatass, $line);
        }
    } 
//dd($listdatass);

    $Datas = db::table('tb_jam_kerja')->select(DB::Raw('id_jam_kerja, tgl_jam_kerja, operator, line_proses, shift, jam_total, jam_lain, ket, status, approve, tgl_approve'))
    ->where('tgl_jam_kerja','>=',$tgl_awal)->where('tgl_jam_kerja','<=',$tgl_akhir)->whereIn('line_proses',$listdatass)->where('status','=','Approve')
    ->where(function($q) use ($search){
            $q->where('operator','like','%'.$search.'%')
            ->orwhere('line_proses','like','%'.$search.'%');
    })  ->orderBy('created_at','asc') 
        ->skip($start)
        ->take($length)
        ->get();

    $count = db::table('tb_jam_kerja')->select(DB::Raw('id_jam_kerja, tgl_jam_kerja, operator, line_proses, shift, jam_total, jam_lain, ket, status, approve, tgl_approve'))
    ->where('tgl_jam_kerja','>=',$tgl_awal)->where('tgl_jam_kerja','<=',$tgl_akhir)->whereIn('line_proses',$listdatass)->where('status','=','Approve')
    ->where(function($q) use ($search){
        $q->where('operator','like','%'.$search.'%')
        ->orwhere('line_proses','like','%'.$search.'%');
    }) 
        ->count();
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function approve_jam_kerja (Request $request){
    //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $dept = $user->departemen;
    $username = $user->user_name;
    $idjam = $request->input('id_jam_kerja');
    //$req = DB::table('tb_jam_kerja')->where('id_jam_kerja','=',$idjam)->first();
    //$req = JamhasiloperatorModel::find($idjam);

    $lineproses = DB::select("select line_proses from tb_jam_kerja where id_jam_kerja = '$idjam'");
    $lineproses1 = $lineproses[0]->line_proses;

    $kodeline = DB::select("select dept_section from tb_line where kode_line = '$lineproses1'");
    $kodeline1 = $kodeline[0]->dept_section;

    if ($dept == $kodeline1){
      $req = DB::table('tb_jam_kerja')->where('id_jam_kerja','=',$idjam)->update([
        'approve' => $username,
        'status' => "Approve",
        'tgl_approve' => date('Y-m-d')
      ]);

      return array (
        'message' => "Update Success .",
        'success'=>true
      );

    } else {
      return array (
        'message' => "Approve Gagal, Karna Bukan Operator Anda .",
        'success'=> false,
      );
    }
  }

  public function edit_jamkerjaoperator (Request $request){
    //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $dept = $user->departemen;
    $username = $user->user_name;
    $idjam = $request->input('id_jam_kerja');
    $jamtotal = $request->input('e-jamtotal');
    $ket = $request->input('e-keterangan');
    //$req = DB::table('tb_jam_kerja')->where('id_jam_kerja','=',$idjam)->first();
    //$req = JamhasiloperatorModel::find($idjam);

    $lineproses = DB::select("select line_proses from tb_jam_kerja where id_jam_kerja = '$idjam'");
    $lineproses1 = $lineproses[0]->line_proses;

    $kodeline = DB::select("select dept_section from tb_line where kode_line = '$lineproses1'");
    $kodeline1 = $kodeline[0]->dept_section;

    if ($dept == $kodeline1){
      $req = DB::table('tb_jam_kerja')->where('id_jam_kerja','=',$idjam)->update([
        'jam_total' => $jamtotal,
        'ket' => $ket,
      ]);

      return array (
        'message' => "Update Total Jam Operator Success .",
        'success'=>true
      );

    } else {
      return array (
        'message' => "Update Gagal, Karna Bukan Operator Anda .",
        'success'=> false,
      );
    }
  }

  public function getscan (Request $request){
    //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $scan = $request->input('scan');
    //dd($scan);
    $q = Crypt::decrypt($scan);
    dd($q);
    return( $qDecoded );

  }

  public function shikakaricamu (Request $request){
    //dd($request->all());
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $proses1 = $request->input('proses1');
    $proses2 = $request->input('proses2');

    $Datas = DB::select("SELECT a.part_no, a.lot_no, a.finish_qty, a.tgl_proses from
    (select part_no, lot_no, finish_qty, tgl_proses from tb_hasil_produksi where line_proses= '$proses1')a
    left JOIN 
    (select part_no, lot_no from tb_hasil_produksi WHERE line_proses = '$proses2')b on a.lot_no = b.lot_no WHERE b.lot_no is NULL and (a.part_No like  '%$search%' or a.lot_no like '%$search%')
    order by a.part_no, a.tgl_proses, a.lot_no asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
    /*->where(function($q) use ($search) {
      $q->where('part_no','like','%'.$search.'%')
      ->orWhere('lot_no','like','%'.$search.'%');
    })
    ->orderBy('part_no', 'asc')
    ->skip($start)->take($length)
    ->get();*/

    $co = DB::select("SELECT a.part_no, a.lot_no, a.finish_qty, a.tgl_proses from
    (select part_no, lot_no, finish_qty, tgl_proses from tb_hasil_produksi where line_proses=60)a
    left JOIN 
    (select part_no, lot_no from tb_hasil_produksi WHERE line_proses = 70)b on a.lot_no = b.lot_no WHERE b.lot_no is NULL and (a.part_No like  '%$search%' or a.lot_no like '%$search%')");
    $count = count($co);
    /*->where(function($q) use ($search) {
      $q->where('part_no','like','%'.$search.'%')
      ->orWhere('lot_no','like','%'.$search.'%');
    })
        ->count();*/
  
    return  [
        "draw" => $draw,
        "recordsTotal" => $count,
        "recordsFiltered" => $count,
        "data" => $Datas
    ];
  }

  public function config_ng(Request $request){
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $kode = $request->kode_ng;
    $period = $request->input('periode');
    $listdel = explode(",", $request->input('itemDel'));

    if (!empty($kode)) {
      //$listdel = ConfigModel::select("kode_ng")->where("user_id",$user->id)->where("kategori","monitor")->get()->toArray();
      if (count($listdel)>0) {
        
        for ($i=0; $i < count($listdel) ; $i++) { 
          $deleted = ConfigModel::where("user_id",$user->id)->where("kategori","monitor")->where("kode_ng", $listdel[$i])->delete();
         
        }
      }
      
      $coun = count($kode);
      
      for ($i=0; $i<$coun; $i++){
        
        $iconf = ConfigModel::where("user_id",$user->id)->where("kode_ng", $request->kode_ng[$i])->first();
        if ($iconf) {
          $iconf->periode = $period;
          $iconf->kode_line = $request->input('kode_line');
          $iconf->save();
          
        }else{
          ConfigModel::create([
            "user_id" => $user->id,
            "kode_line" => $request->input('kode_line'),
            "kategori" => "monitor",
            "periode" => $period,
            "kode_ng" => $request->kode_ng[$i],
          ]);
          
        }
       

      }
     
      return array(
        'message' => 'Update data berhasil !',
        'success'=>true,
      );
    }
    return array(
      'message' => 'Update data gagal !',
      'success'=>false,
  );
    
  }

  public function get_monitoring(Request $request){
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $id = $user->id;
    $period = "";
    $kode_line = "";
    $monitoring = DB::select("select a.kategori, a.periode,a.kode_ng, a.kode_line, b.type_ng from tb_monitoring a left join tb_master_ng_produksi b on a.kode_ng = b.kode_ng where a.user_id = '$id' and a.kategori = 'monitor'");
    if (count($monitoring) > 0) {
     $period = $monitoring[0]->periode;
     $kode_line = $monitoring[0]->kode_line;
    }
    return array(
        'period' => $period,
        'kode_line' => $kode_line,
        'datas' => $monitoring,
        'success' => true,
    );

  }

  public function monitoring_chart(Request $request){
    $now = date('Y-m-d');
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $id = $user->id;
    $monitoring = DB::select("select a.kategori, a.periode,a.kode_ng, a.kode_line, b.type_ng from tb_monitoring a left join tb_master_ng_produksi b on a.kode_ng = b.kode_ng where a.user_id = '$id' and a.kategori = 'monitor'");
    //dd($monitoring);
    $kode_proses = "";
    $ng_kode=array();
    foreach($monitoring as $p){
      array_push($ng_kode,$p->kode_ng);
      $kode_proses = $p->kode_line;
    }
    $str_ng = implode(',',$ng_kode);
   
    $amb = DB::select(\DB::raw("select DATEPART(MM, tbm.Date) as bln, tn.ng_type,c.mulai, sum(tn.jumlah_ng) as qty_ng, ROUND(ISNULL(((sum(tn.jumlah_ng)/ NULLIF(c.mulai,0))),0) * 100.0,2) as ng from
    (SELECT  TOP (DATEDIFF(MONTH,CONVERT(datetime, DATEADD(YEAR, DATEDIFF(YEAR, 0, '$now'), 0)), DATEADD(yy, DATEDIFF(yy, 0,'$now') + 1, -1)) + 1)
            Date = convert(varchar, EOMONTH(DATEADD(MONTH, ROW_NUMBER() OVER(ORDER BY a.object_id) - 1, CONVERT(datetime, DATEADD(YEAR, DATEDIFF(YEAR, 0, '$now'), 0)))), 23) 
    FROM    sys.all_objects a
            CROSS JOIN sys.all_objects b)tbm
    left join
    (select DATEPART(MM, tgl_proses) as bulan, id_hasil_produksi from tb_hasil_produksi where line_proses = $kode_proses and DATEPART(YYYY, tgl_proses) = DATEPART(YYYY, GETDATE()) group by DATEPART(MM, tgl_proses),id_hasil_produksi) tm on tm.bulan = DATEPART(MM, tbm.Date)
	inner join
	(select id_hasil_produksi, ng_code, ng_type, sum(ng_qty) as jumlah_ng from tb_ng_produksi where ng_code in ('".implode("','",$ng_kode)."') group by id_hasil_produksi, ng_code, ng_type)tn on tm.id_hasil_produksi = tn.id_hasil_produksi
	left join
	(select DATEPART(MM, tgl_proses) as bulan, sum(start_qty) as mulai from tb_hasil_produksi where line_proses = $kode_proses and DATEPART(YYYY, tgl_proses) = DATEPART(YYYY, GETDATE()) group by DATEPART(MM, tgl_proses))c on c.bulan = DATEPART(MM, tbm.Date)
	group by DATEPART(MM, tbm.Date), tn.ng_type,c.mulai order by DATEPART(MM, tbm.Date) asc"));
    
  //dd($amb);
    $res= [];
    for ($i=0; $i < 13; $i++) { 
     $res[$i]= (object)[
       'bulan'=>0,
       
      ];
      foreach($monitoring as $t){
        $y[$t->type_ng]=0;
        $res[$i]= $y;
      }
    
    }
 
    foreach ($amb as $key) {

      
     
    $res[$key->bln]= (object)[
      'bulan'=>$key->bln,
        ];
    $y[$key->ng_type]=$key->qty_ng > 0 ? number_format(($key->qty_ng / $key->mulai)*100,2): 0;
    $res[$key->bln]= $y;
    }
    array_splice($res,0,1);
  
    return array(
      'success'=>true,
      'data'=>$res,
    );
  }

}
