<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Session;
use App\LogModel;
use App\TargetModel;
use App\UserModel;
use App\WorkresultModel;
use App\UpdatedenpyouModel;
use App\UploadCalculationBoxModel;
use App\MasterPPICModel;
use PDF;

class PPICController extends Controller
{
    public function set_produksi(Request $request){
       $kelompok = $request->input("set");
       $periode = $request->input("periode");
       $target = $request->input("target");
       //dd($target);

       $exist = TargetModel::select("target")->where("periode","LIKE",$periode."%")->where("process_cd","=",$kelompok)->count();

       if($target == null){
        $mess = "Please input your target .";
        $status = false;         
       }elseif ($exist >= 1) {
         $mess = "Update Failed, Target already exist .";
         $status = false;
       } else {
          $set = TargetModel::create([
            "process_cd"=>$kelompok,
            "process_name"=>"Produksi",
            "target"=>$target,
            "periode"=>$periode."-01",
          ])->id_number;
          $status = true;
          $mess = "Update Target Success .";
       }


       return array(
        'message' => $mess,
        'success'=>$status
      );
       
    }

    public function set_targetsales(Request $request){
      $kelompok = $request->input("setsales");
      $periode = $request->input("periodesales");
      $target = $request->input("targetsales");

      $exist = TargetModel::select("target")->where("periode","LIKE",$periode."%")->where("process_cd","=",$kelompok)->count();
      if($target == null){
        $mess = "Please input your target .";
        $status = false;         
       }elseif ($exist >= 1) {
         $mess = "Update Failed, Target already exist .";
         $status = false;
       } else {
         $set = TargetModel::create([
           "process_cd"=>$kelompok,
           "process_name"=>"Sales",
           "target"=>$target,
           "periode"=>$periode."-01",
         ])->id_number;
         $status = true;
         $mess = "Update Target Success .";
        }


        return array(
         'message' => $mess,
         'success'=>$status
     );
        
    }

    public function workresult (){
      $tanggal = date('Y-m-d');
      $per = date('Y-m');
      $hr = substr($tanggal,8);
      $mess = "Please Input your target .";
      //dd($per);
      //$barcode = DB::connection('oracle')->select("select i_po_detail_no, i_item_cd, i_proc_ptn, i_seiban, i_po_qty from t_po_tr where i_seq=1 and i_po_comp_cls=00");
      //dd($barcode);
      $mas = WorkresultModel::where('masalah','=',"NG")->where('tgl_keluar','=',$tanggal)->count();
      $err = TargetModel::whereIn('process_name',['Produksi','Sales','1C1001','1C2001','1C3001','1C4001','1C5001','1A3001','1B3001','1C6001','1C7001','1C8001','1A5001'])
      ->where('periode','>=',$per.'-01')->where('periode','<=',$tanggal)->count();
      //dd($err);
      if($hr <= 10 || $err >= 24){
        return view('/ppic/workresult',['mas'=>$mas]);
      } else {
        return view('error',['mess'=>$mess]);
      }
    }

    public function inqueryworkresult (){
      return view('/ppic/inqueryworkresult');
    }

    public function update_workresult (Request $request){
      //dd($request->all());
      $tanggal = date('Y-m-d');
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $id = $request->input('id');
      $barcode_no = $request['barcode_no'];


      
      $req1 = WorkresultModel::where('barcode_no','=',$barcode_no)->count();
      //$req1 = DB::connection('sqlsrv')->select("select count(*)as total from tb_workresult where barcode_no= $barcode_no")[0]->total;
      //dd($req1);
      if($req1 > 0){
        return array(
          'message' => "Item sudah ada.",
          'success'=> false,
      );
      } 
/*
      $barcode = DB::connection('oracle')->select("select TRIM(i_po_detail_no) as i_po_detail_no, TRIM(i_item_cd) as i_item_cd, TRIM(i_proc_ptn) as i_proc_ptn, TRIM(i_seiban) as i_seiban, TRIM(i_po_qty) as i_po_qty from t_po_tr where i_seq=1 and i_po_comp_cls=00 and i_po_detail_no=$barcode_no");
      if (empty($barcode)){
        return array(
          'message' => "Barcode salah.",
          'success'=> false,
      );
      }
*/
      $req = UpdatedenpyouModel::where('part_no','=',$request['partno'])
      ->where('status','=',"Open")
      ->count();
      if ($req > 0){
        $m = "NG";
        $tglkirim = Null;
      }else{
        $m = "OK";
        $tglkirim = date('Y-m-d');
      }

                WorkresultModel::create ([
          'id_workresult'=>Str::uuid(),
                 'user_name' => $user->user_name,
                  'tgl_keluar'=> $tanggal,
                  'no_tag'=>$request['tag_no'],
                  'warna_tag'=>$request['warna_tag'],
                  'nouki'=> $request['nouki'],
                  'start'=> $request['start'],
                  'msk_kamu'=>$request['msk_kamu'],
                  'finish'=> $request['finish'],
                  'barcode_no' => $request['barcode_no'],
                  'part_no' =>$request['partno'],
                  'jby' => $request['jby'],
                  'lot_no' => $request['lotno'],
                  'qty' => $request['qty'],
                  'tgl_kirim'=>$tglkirim,
                  'masalah'=> $m,
                  'customer' =>$request['customer'],
          
                ]);
                $mas = WorkresultModel::where('masalah','=',"NG")->where('tgl_keluar','=',$tanggal)->count();
                return array(
                  'message' => "Ok",
                  'success'=> true,
                  'totalmasalah'=>$mas
              );
    }

    public function getbarcode(Request $request){
      $barcode = DB::connection('oracle')->select("select TRIM(i_po_detail_no) as i_po_detail_no, TRIM(i_item_cd) as i_item_cd, TRIM(i_proc_ptn) as i_proc_ptn, TRIM(i_seiban) as i_seiban, i_po_qty from t_po_tr where i_seq=1 and i_po_comp_cls=00");
      return array(
        "success"=>true,
        "data"=> $barcode
      );
    }

    public function listworkresult (Request $request){
      $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $tgl = date('Y-m-d');
       
        //dd($request->all());
        //$req1 = DB::connection('sqlsrv')->select("select count(*)as total from tb_workresult where barcode_no= $barcode_no")[0]->total;
        //dd($mas);

        $Datas = DB::table('tb_workresult')
        ->where('tgl_keluar','=',$tgl)
        ->orderBy('created_at', 'asc')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_workresult')->where('tgl_keluar','=',$tgl)
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function listworkresultmasalah (Request $request){
      $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $tgl = date('Y-m-d');
       
        $masalah = "NG";
        //dd($request->all());
        //$req1 = DB::connection('sqlsrv')->select("select count(*)as total from tb_workresult where barcode_no= $barcode_no")[0]->total;
        //dd($mas);

      
        $Datas = DB::table('tb_workresult')
        ->where('tgl_keluar','=',$tgl)
        ->where('masalah',$masalah)
        ->orderBy('created_at', 'asc')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_workresult')->where('tgl_keluar','=',$tgl)->where('masalah',$masalah)
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function workresultxlsx (Request $request){
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $crf1 = $request->input("crf");
       
        if ($crf1 == "Cr") {
         
          $Datas = WorkresultModel::where('tgl_keluar','>=',$awal)
          ->where('tgl_keluar','<=',$akhir)
          ->where(function($q) {
            $q->where(\DB::raw('substring(part_no,4,1)'),'=','D')
            ->orWhere(\DB::raw('substring(part_no,4,1)'),'=','F');
          })
          ->orderBy('created_at', 'asc')
          ->get();

        }elseif($crf1 == "F"){
          $Datas = WorkresultModel::where('tgl_keluar','>=',$awal)
                                ->where('tgl_keluar','<=',$akhir)
                                ->where(function($q) {
                                  $q->where(\DB::raw('substring(part_no,4,1)'),'=','C')
                                  ->orWhere(\DB::raw('substring(part_no,4,1)'),'=','B');
                                })
                                ->orderBy('created_at', 'asc')
                                ->get();
        }else{
          $Datas = WorkresultModel::where('tgl_keluar','>=',$awal)
                                ->where('tgl_keluar','<=',$akhir)
                                ->orderBy('created_at', 'asc')
                                ->get();
        }
        
      
      if (count($Datas) > 0) {
       
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','User name');
        $sheet->setCellValue('C1','Tanggal keluar');
        $sheet->setCellValue('D1','No Tag');
        $sheet->setCellValue('E1','Nouki');
        $sheet->setCellValue('F1','Start');
        $sheet->setCellValue('G1','Tgl Kamu');
        $sheet->setCellValue('H1','Finish');
        $sheet->setCellValue('I1','Customer');
        $sheet->setCellValue('J1','Barcode No');
        $sheet->setCellValue('K1','Part No');
        $sheet->setCellValue('L1','Jby');
        $sheet->setCellValue('M1','Lot No');
        $sheet->setCellValue('N1','Qty');
        $sheet->setCellValue('O1','Masalah');
        $sheet->setCellValue('P1','Tanggal Kirim');
        $sheet->setCellValue('Q1','Create at');
        $sheet->setCellValue('R1','Update at');
        $sheet->setCellValue('S1','Cr/F');
        $sheet->setCellValue('T1','Warna Tag');
        
        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->user_name);
            $sheet->setCellValue('C'.$line,$data->tgl_keluar);
            $sheet->setCellValue('D'.$line,$data->no_tag);
            $sheet->setCellValue('E'.$line,$data->nouki);
            $sheet->setCellValue('F'.$line,$data->start);
            $sheet->setCellValue('G'.$line,$data->msk_kamu);
            $sheet->setCellValue('H'.$line,$data->finish);
            $sheet->setCellValue('I'.$line,$data->customer);
            $sheet->setCellValue('J'.$line,$data->barcode_no);
            $sheet->setCellValue('K'.$line,$data->part_no);
            $sheet->setCellValue('L'.$line,$data->jby);
            $sheet->setCellValue('M'.$line,$data->lot_no);
            $sheet->setCellValue('N'.$line,$data->qty);
            $sheet->setCellValue('O'.$line,$data->masalah);
            $sheet->setCellValue('P'.$line,$data->tgl_kirim);
            $sheet->setCellValue('Q'.$line,$data->created_at);
            $sheet->setCellValue('R'.$line,$data->updated_at);
        
            if (substr($data->part_no,3,1)== "D" || substr($data->part_no,3,1)== "F" ){
              $has = "Cr";
            } else {
              $has = "F";
            }
            
            $sheet->setCellValue('S'.$line,$has);
            $sheet->setCellValue('T'.$line,$data->warna_tag);
        
            $line++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = "Workresult_".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename,
                "success"=>true];
        
            }
            return ["message"=>"No Data", "success"=>false];
    }

    public function pdfworkresult(Request $request){
        $awal = $request->input("tgl_awal_1");
        $akhir = $request->input("tgl_akhir_1");
        $crf = $request->input("crf_1");

        if ($crf == "Cr") {
         
          $Datas = WorkresultModel::where('tgl_keluar','>=',$awal)
          ->where('tgl_keluar','<=',$akhir)
          ->where(function($q) {
            $q->where(\DB::raw('substring(part_no,4,1)'),'=','D')
            ->orWhere(\DB::raw('substring(part_no,4,1)'),'=','F');
          })
          ->orderBy('tgl_keluar', 'asc')->orderBy('part_no','asc')
          ->get();

          $total = WorkresultModel::where('tgl_keluar','>=',$awal)->where('tgl_keluar','<=',$akhir)
                                    ->where(function($q) {
                                      $q->where(\DB::raw('substring(part_no,4,1)'),'=','D')
                                      ->orWhere(\DB::raw('substring(part_no,4,1)'),'=','F');
                                    })->sum('qty');

        //dd($total);

        }elseif($crf == "F"){
          $Datas = WorkresultModel::where('tgl_keluar','>=',$awal)
                                ->where('tgl_keluar','<=',$akhir)
                                ->where(function($q) {
                                  $q->where(\DB::raw('substring(part_no,4,1)'),'=','C')
                                  ->orWhere(\DB::raw('substring(part_no,4,1)'),'=','B');
                                })
                                ->orderBy('tgl_keluar', 'asc')->orderBy('part_no','asc')
                                ->get();

                                $total = WorkresultModel::where('tgl_keluar','>=',$awal)->where('tgl_keluar','<=',$akhir)
                                ->where(function($q) {
                                  $q->where(\DB::raw('substring(part_no,4,1)'),'=','C')
                                  ->orWhere(\DB::raw('substring(part_no,4,1)'),'=','B');
                                })->sum('qty');
        }else{
          $Datas = WorkresultModel::where('tgl_keluar','>=',$awal)
                                ->where('tgl_keluar','<=',$akhir)
                                ->orderBy('tgl_keluar', 'asc')->orderBy('part_no','asc')
                                ->get();

                                $total = WorkresultModel::where('tgl_keluar','>=',$awal)->where('tgl_keluar','<=',$akhir)
                                ->sum('qty');
        }
        
        if (count($Datas) > 0){
       
          $pdf = PDF::loadview('/ppic/pdfworkresult',['datas'=>$Datas, 'crf'=>$crf, 'total'=>$total])->setPaper('A4','landscape');
          return $pdf->stream();
        } else {
          return ["message"=>"No Data", "success"=>false];
        }
    }


    public function inquery_workresult (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        $tgl = date('Y-m-d');
        $type = $request->input("edit-type");
        //dd($request->all());
        //$req1 = DB::connection('sqlsrv')->select("select count(*)as total from tb_workresult where barcode_no= $barcode_no")[0]->total;
        //dd($mas);

        $Datas = DB::table('tb_workresult')
        ->where('tgl_keluar','>=',$awal)
        ->where('tgl_keluar','<=',$akhir)
        ->where(function($q) use ($search) {
          $q->where('lot_no','like','%'.$search.'%');
        })
        ->orderBy('tgl_keluar', 'asc')
        ->skip($start)->take($length)
        ->get();

        $count = DB::table('tb_workresult')
        ->where('tgl_keluar','>=',$awal)
        ->where('tgl_keluar','<=',$akhir)
        ->where(function($q) use ($search) {
          $q->where('lot_no','like','%'.$search.'%');
        })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function del_workresult(Request $request){
     
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $dept = $user->departemen;
      $id = $request->input('id');
      $tanggal = date('Y-m-d');


      if ($dept == "Admin") {
        $req = WorkresultModel::where('id_workresult','=',$id)->delete();
        $status = true;
        $mess = "Delete berhasil";
          //Session::flash('alert-success','Hapus Request berhasil !'); 
      }else if ($dept == "PPIC") {
        $req = WorkresultModel::where('id_workresult','=',$id)->delete();
         $status = true;
         $mess = "Delete berhasil";
         //Session::flash('alert-success','Hapus Request berhasil !'); 
      }else {
          $mess = "Delete gagal";
          $status = false;
          //Session::flash('alert-danger','Hapus Request gagal !');
      }
      $details = [
          'id_workresult' => $id,
          //'barcode_no' => $req->barcode_no,
          'status'=>"delete",

      ];
      $data = [
          'record_no' => Str::uuid(),
          'user_id' => $user->id,
          'activity' =>"delete",
          'message' => $details,
      ];

      LogModel::create($data);

      $mas = WorkresultModel::where('masalah','=',"NG")->where('tgl_keluar','=',$tanggal)->count();
      return array(
          'message' => $mess,
          'success'=>$status,
          'totalmasalah'=>$mas,
      );
  }

  public function f_master (){
    $part = DB::connection('oracle')->table('t_pm_ms')->select('i_item_cd')->get();
    return view ('ppic/master_ppic',['part'=>$part]);
  }

  public function list_master_ppic (Request $request){
    $draw = $request->input("draw");
    $search = $request->input("search")['value'];
    $start = (int) $request->input("start");
    $length = (int) $request->input("length");
    $status_master = $request->input("status_master");

    $datamaster = DB::table('tb_master_ppic')->select('status')->groupBy('status')->get();
  
    $listdatamaster= array();

    if ($status_master == "All") {
        foreach ($datamaster as $key) {
            array_push($listdatamaster,$key->status);
        }
        }else {
            array_push($listdatamaster, $status_master);
    } 

    //dd($listdatamaster);


    $Datas = DB::table('tb_master_ppic')->select('part_no','grouping','pas','material','futatsuwari','mark', 'masternaiara','status')->whereIn('status',$listdatamaster)  
    ->where(function($q) use ($search) {
      $q->where('part_no','like','%'.$search.'%')
      ->orWhere('grouping','like','%'.$search.'%')
      ->orWhere('material','like','%'.$search.'%')
      ->orWhere('futatsuwari','like','%'.$search.'%')
      ->orWhere('masternaiara','like','%'.$search.'%')
      ->orWhere('mark','like','%'.$search.'%');
    })
    ->orderBy('part_no', 'asc')
    ->skip($start)->take($length)
    ->get();

    $count = DB::table('tb_master_ppic')->select('part_no','grouping','pas','material','futatsuwari','mark', 'masternaiara','status')->whereIn('status',$listdatamaster)  
    ->where(function($q) use ($search) {
      $q->where('part_no','like','%'.$search.'%')
      ->orWhere('grouping','like','%'.$search.'%')
      ->orWhere('material','like','%'.$search.'%')
      ->orWhere('futatsuwari','like','%'.$search.'%')
      ->orWhere('masternaiara','like','%'.$search.'%')
      ->orWhere('mark','like','%'.$search.'%');
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
    $partno = $request->input('part_no');
//dd($user->user_name);

      if (substr($partno,3,1)== "D" || substr($partno,3,1)== "F" ){
        $has = "Cr";
      } else {
        $has = "F";
      }


    $datamaster = MasterPPICModel::select('part_no')->where('part_no','=',$partno)->count();

    if($datamaster > 0){
      $status = false;
      $mess = 'Already exist .';
    } else {
      MasterPPICModel::create ([
               'part_no' => $request->part_no,
               'grouping'=> $request->grouping,
               'material'=> $request->material,
               'user_input'=>$user->user_name,
               'fcr'=>$has,
               'status'=>'Open',
              ]);

        $status = true;
        $mess = 'Add data success .';
    }
    //dd($datamaster);

    return array(
      'message' => $mess,
      'success'=>$status,
    );
  }

  public function edit_master (Request $request){
    //dd($request->all());
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $dept = $user->departemen;
    //dd($dept);
    
    $req = MasterPPICModel::find($request['part_no']);
    //dd($req);

    if ($dept == 'Admin'){
      $req->grouping = $request['grouping'];
      $req->material = $request['material'];
      $req->pas = $request['pas'];
      $req->futatsuwari = $request['futatsuwari'];
      $req->mark = $request['mark'];
      $req->masternaiara = $request['mnaiara'];

        if ($req->pas == null || $req->futatsuwari == null ||  $req->mark == null || $req->masternaiara == null){
          $req->status = 'Open';
        } else {
          $req->status = 'Close';
        }

      $req->save();

      $status = true;
      $mess = "Update data berhasil";

    } elseif ($dept == 'PPIC'){
      $req->grouping = $request['grouping'];
      $req->material = $request['material'];

      $req->save();

      $status = true;
      $mess = "Update data berhasil";

    } else {
      $req->pas = $request['pas'];
      $req->futatsuwari = $request['futatsuwari'];
      $req->mark = $request['mark'];
      $req->masternaiara = $request['mnaiara'];

      if ($req->pas == null || $req->futatsuwari == null ||  $req->mark == null || $req->masternaiara == null){
        $req->status = 'Open';
      } else {
        $req->status = 'Close';
      }

      $req->save();

      $status = true;
      $mess = "Update data berhasil";

    }

    return array(
      'message' => $mess,
      'success'=>$status
  );

  }

  public function jam_kerusakan (){
    return view('/ppic/jam_kerusakan');
  }

  public function f_calculation (){
    $shipto = DB::select("select ship_to from tb_calculation_box group by ship_to");
    return view ('/ppic/calculation_box',['ship_to'=>$shipto]);
  }

  public function calculation_box (Request $request){
    //dd($request->all());
    //$nouki = $request->input('nouki');
    //$ship_to = $request->input('ship_to');

    $cal = DB::select("SELECT t1.part_no, t1.qty , t2.diameter , t2.isi from
    (SELECT part_no, qty, SUBSTRING(part_no,5,3)as mm from tb_calculation_box)t1
    left join
    (select diameter, isi from tb_master_box_ppic)t2 on t1.mm = t2.diameter ");
    //dd($cal);
    
    //$shi = DB::connection('oracle')->table('t_order_prcs_ms')->select(DB::raw("trim(i_item_cd)as i_item_cd"), 'i_seq', 'i_ship_value')->where('i_seq','=','999')->whereIn(DB::raw("trim(i_item_cd)"),$listcal)->get();
    $shi = DB::connection('oracle')->select("select trim(i_item_cd)as i_item_cd, i_ship_value, i_proc_ptn from t_order_prcs_ms where i_seq='999'");
    //dd($shi);
    $totalqty = 0;
    $totalhousou = 0;
    $totalpallet = 0;
    $sisabox = 0;
    $totalbox1 = 0;
    $totalbox = 0;

    if(empty($cal)){
      return array('message'=>'Record Not Found .',
      'success'=>false,);
    }

    if($cal){
      foreach($cal as $r){
         //$dd = $r->v_loc_cd;
         $g = $this->getshipvalue($shi,$r->part_no); //ship value
         //$g = $g + $g;
         //$r2 = $r2 + $r->qty;
         if (empty($g)){
           return array('message'=>'Problem Items .',
           'success'=>false,);
         } 


          $housou = $r->qty/$g;
          $box = $housou / $r->isi;
          $totalbox1 = $totalbox1 + $box;
          $totalbox = ceil($totalbox1);
          $totalqty = $totalqty + $r->qty;
          $totalhousou = $totalhousou + $housou;
          $totalpallet1 = $totalbox / 18;
          $totalpallet2 = floor($totalpallet1);
          $ppallet = ($totalpallet2 * 18);
          $sisabox1 = number_format(($totalbox - $ppallet),2);
          
          //$t = round($totalbox);
          //$h = array ('part_no'=>$r->part_no,'qty'=>$r->qty,'isi'=>$r->isi,'i_ship_value'=>$g, 'housou'=>$housou, 'box'=>$box);
          //$h1[]=$h;
          
          if($sisabox1 == 18){
            $sisabox = 0;
            $totalpallet = floor($totalpallet2 + 1);
          }elseif($sisabox1 >= 0.01 && $sisabox1 <= 0.99){
            $sisabox = 1;
          }else{
            $sisabox = number_format(($totalbox - $ppallet),0);
            $totalpallet = floor($totalpallet2);
          }
        }
        //dd($totalpallet2);

        //dd($g);
        /*else {
          $housou = $r2/$g;
          //$housou = number_format(ceil($tt),0);
          $box = number_format(($housou / $r->isi),2);
          
          $totqty1 += ($r->qty);
          $totqty = number_format($totqty1,0);
          $tothousou1 +=  $housou;
          $tothousou = number_format($tothousou1,0);
          $totpallet1 = $box / 18;
          $totpallet2 = floor($totpallet1);
          $ppallet = ($totpallet2 * 18);
          $sisabox2 = number_format(($box - $ppallet),0);
          dd($r2);

           if ($sisabox2 == 18){
             $sisabox = 0;
             $totpallet = floor($totpallet1 + 1);
           } else {
             $sisabox = $sisabox2;
             $totpallet = $totpallet2;
           }
        }*/

    }
    //dd($sisabox);

   return array(
     //'h1'=>$h1, 
     'success'=>true,
     'totqty'=>number_format($totalqty), 
     'tothousou'=>$totalhousou,
     'totpallet'=>$totalpallet,
     'sisabox'=>$sisabox,
    );
  }

  public function getshipvalue($shi, $p){
    $hasil = 0;
    $r = array();
    foreach ($shi as $t){
       //dd($t->process_name);
    if ( $t->i_item_cd == $p){
       $hasil =  $t->i_ship_value;
       //rray_push($r,$t->i_ship_value);
       return $hasil;
    }
    }
    return $hasil;
    //array_push($r,$t->i_item_cd);
    //dd($hasil);
  }

  public function importexcel_perhitunganbox(Request $request){
    $del = UploadCalculationBoxModel::truncate();
    //Session::flash('alert-success','Delete data berhasil');
    //return redirect()->route('f_calculation'); 

    if ($del){
      if ($request->hasFile('import_file')) {
        $path = $request->file('import_file')->getRealPath();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $Data = $reader->load($path);
        $sheetdata = $Data->getActiveSheet()->toArray(null, true, true, true);
         unset($sheetdata[1]);
       
         foreach ($sheetdata as $row) {
                UploadCalculationBoxModel::create([
                    'id_calculation_box'=>Str::uuid(),
                 'part_no'=>$row['A'],
                 'qty'=>$row['B'],
                 //'nouki'=>$row['C'],
                 //'ship_to'=>$row['D'],
                 //'jby'=>$row['E'],
                
             ]);
             Session::flash('alert-success','Import data berhasil'); 
                }
        
            return redirect()->route('f_calculation');
      }
      return redirect()->route('f_calculation');
    }

  }
}
