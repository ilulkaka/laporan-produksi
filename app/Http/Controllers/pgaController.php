<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\DeptheadModel;
use App\UserModel;
use App\LogModel;
use App\UploadabsensiModel;
use App\TemaPelatihanModel;
use App\OjtModel;
use App\RencanaPelatihanModel;
use App\ApproveSkillmatrikModel;
use App\PenyelenggaraModel;
use App\PelatihanEksternalModel;
use App\EvaluasiPelatihanEksternalModel;
use App\EvaluasiEksternalTigaBulanModel;
use App\PKWTModel;
use App\PenilaianPKWTModel;
use PDF;

class pgaController extends Controller
{
    public function appraisal(){
        $nomerinduk = DB::connection('sqlsrv_pga')->select("select nik, nama, dept_group from t_karyawan");
        $total = DB::connection('sqlsrv')->table('tb_appraisal')->get();
        //dd($total);
        return view('/pga/appraisal',['nomerinduk'=>$nomerinduk,'total'=>$total]);
    }

    public function PGABonus(){
        $nomerinduk = DB::connection('sqlsrv_pga')->select("select nik, nama, dept_group from t_karyawan");
        $total = DB::connection('sqlsrv')->table('tb_appraisal')->get();
        //dd($total);
        return view('/pga/PGABonus',['nomerinduk'=>$nomerinduk,'total'=>$total]);
    }

    public function rekapappraisal(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode = $request->input("periode")."-01";
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->user_name;
        $dept1 = $user->departemen;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('penilai')->groupBy('penilai')->get();

       
        $listdept= array();
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->penilai);
                
            }
        }else {
            array_push($listdept, $dept); 
        }
       // dd($listdept);
        
        
        $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.id_appraisal,a.nik, a.nama, b.STATUS_KARYAWAN, a.departemen, (a.dandori + a.kecepatan + a.ketelitian + a.improvement + a.sikap_kerja + a.Penyelesaian_masalah + a.horenso)as nilai1, (a.pengetahuan)as nilai2, (a.keputusan + a.ekspresi + a.perencanaan + a.respon)as nilai3, (a.kedisiplinan + a.kerjasama + a.antusiasme + a.tanggung_jawab)as nilai4, a.poin_kebijakan as nilai5, a.keterangan'))
        ->where('a.type','=','Performance')
        ->where('a.jabatan','!=','leader')
        ->where('a.jabatan','!=','foreman')
        ->where('a.jabatan','!=','Ast Supervisor')
        ->where('a.jabatan','!=','Supervisor')
        ->where('a.jabatan','!=','Ast Manager')
        ->where('a.jabatan','!=','Manager')
        ->where('a.disetujui','!=',null)
        ->wherein('a.penilai',$listdept)->where('a.periode','like',$periode.'%')
        ->where(function($q) use ($search){
            $q->orWhere('a.nik','like','%'.$search.'%') 
            ->orwhere('a.nama','like','%'.$search.'%')
            ->orwhere('a.departemen','like','%'.$search.'%')
            ->orwhere('a.periode','like','%'.$search.'%');
        })             
        ->skip($start)
        ->take($length)
        ->get();
        
        $count = DeptheadModel::wherein('penilai',$listdept)->where('periode','like',$periode.'%')
        ->where('type','=','Performance')
        ->where('jabatan','!=','leader')
        ->where('jabatan','!=','foreman')
        ->where('jabatan','!=','Ast Supervisor')
        ->where('jabatan','!=','Supervisor')
        ->where('jabatan','!=','Ast Manager')
        ->where('jabatan','!=','Manager')
        ->where('disetujui','!=',null)
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

    public function rekapbonus(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode = $request->input("periode")."-01";
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->user_name;
        $dept1 = $user->departemen;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('penilai')->groupBy('penilai')->get();

       
        $listdept= array();
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->penilai);
                
            }
        }else {
            array_push($listdept, $dept); 
        }
       // dd($listdept);
        
        
        $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.id_appraisal,a.nik, a.nama, b.STATUS_KARYAWAN, a.departemen, (a.dandori + a.kecepatan + a.ketelitian + a.improvement + a.sikap_kerja + a.Penyelesaian_masalah + a.horenso)as nilai1, (a.kedisiplinan + a.kerjasama + a.antusiasme + a.tanggung_jawab)as nilai4, a.poin_kebijakan as nilai5, a.keterangan'))
        ->where('a.type','=','Bonus')
        ->where('a.jabatan','!=','leader')
        ->where('a.jabatan','!=','foreman')
        ->where('a.jabatan','!=','Ast Supervisor')
        ->where('a.jabatan','!=','Supervisor')
        ->where('a.jabatan','!=','Ast Manager')
        ->where('a.jabatan','!=','Manager')
        ->where('a.disetujui','!=',null)
        ->wherein('a.penilai',$listdept)->where('a.periode','like',$periode.'%')
        ->where(function($q) use ($search){
            $q->orWhere('a.nik','like','%'.$search.'%') 
            ->orwhere('a.nama','like','%'.$search.'%')
            ->orwhere('a.departemen','like','%'.$search.'%')
            ->orwhere('a.periode','like','%'.$search.'%');
        })             
        ->skip($start)
        ->take($length)
        ->get();

        $count = DeptheadModel::wherein('penilai',$listdept)->where('periode','like',$periode.'%')
        ->where('type','=','Bonus')
        ->where('jabatan','!=','leader')
        ->where('jabatan','!=','foreman')
        ->where('jabatan','!=','Ast Supervisor')
        ->where('jabatan','!=','Supervisor')
        ->where('jabatan','!=','Ast Manager')
        ->where('jabatan','!=','Manager')
        ->where('disetujui','!=',null)
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

    public function rekapappraisal_1(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode = $request->input("periode_1")."-01";
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->user_name;
        $dept1 = $user->departemen;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('penilai')->groupBy('penilai')->get();

       
        $listdept= array();
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->penilai);
                
            }
        }else {
            array_push($listdept, $dept); 
        }
       // dd($listdept);

       $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.id_appraisal, a.nik, a.nama, b.STATUS_KARYAWAN, a.departemen, (a.keselamatan + a.kualitas + a.biaya + a.pengiriman + a.penjualan)as nilai1, (a.kontrol_progres + a.improvement + a.penyelesaian_masalah + a.motivasi_bawahan + a.horenso + a.koordinasi_pekerjaan)as nilai2, (a.pengetahuan)as nilai3, (a.keputusan + a.perencanaan + a.negosiasi + a.respon)as nilai4, (a.kedisiplinan + a.kerjasama + a.antusiasme + a.tanggung_jawab)as nilai5, (a.poin_kebijakan)as nilai6, a.keterangan'))
        ->wherein('a.penilai',$listdept)->where('a.periode','like',$periode.'%')
        ->where('a.type','=','Performance')
        ->where('a.jabatan','!=','operator')
        ->where('a.jabatan','!=','staff')
        ->where('a.disetujui','!=',null)
        ->where(function($q) use ($search){
            $q->where('a.periode','like','%'.$search.'%')
            ->orWhere('a.nik','like','%'.$search.'%') 
            ->orwhere('a.departemen','like','%'.$search.'%')
            ->orwhere('a.nama','like','%'.$search.'%');
        })             
        ->skip($start)
        ->take($length)
        ->get();

        $count = DeptheadModel::wherein('penilai',$listdept)->where('periode','like',$periode.'%')        
        ->where('type','=','Performance')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->where('disetujui','!=',null)
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

    public function rekapbonus_1(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $periode = $request->input("periode_1")."-01";
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->user_name;
        $dept1 = $user->departemen;
        $level = $user->level_user;
        $alldept = DB::connection('sqlsrv')->table('tb_appraisal')->select('penilai')->groupBy('penilai')->get();

       
        $listdept= array();
        
        if ($level=='Admin' || $level == 'Manager') {
            
            foreach ($alldept as $key) {
                array_push($listdept,$key->penilai);
                
            }
        }else {
            array_push($listdept, $dept); 
        }
       // dd($listdept);

       $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.id_appraisal, a.nik, a.nama, b.STATUS_KARYAWAN, a.departemen, (a.keselamatan + a.kualitas + a.biaya + a.pengiriman + a.penjualan)as nilai1,(a.kedisiplinan + a.kerjasama + a.antusiasme + a.tanggung_jawab)as nilai5, (a.poin_kebijakan)as nilai6, a.keterangan'))
        ->wherein('a.penilai',$listdept)->where('a.periode','like',$periode.'%')
        ->where('a.type','=','Bonus')
        ->where('a.jabatan','!=','operator')
        ->where('a.jabatan','!=','staff')
        ->where('a.disetujui','!=',null)
        ->where(function($q) use ($search){
            $q->where('a.periode','like','%'.$search.'%')
            ->orWhere('a.nik','like','%'.$search.'%') 
            ->orwhere('a.departemen','like','%'.$search.'%')
            ->orwhere('a.nama','like','%'.$search.'%');
        })             
        ->skip($start)
        ->take($length)
        ->get();

        $count = DeptheadModel::wherein('penilai',$listdept)->where('periode','like',$periode.'%')        
        ->where('type','=','Bonus')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->where('disetujui','!=',null)
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

    public function excelrekappenilaian (Request $request){
        $periode = $request->input("periode")."-01";

        $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.id_appraisal,a.periode,a.nik, a.nama, b.STATUS_KARYAWAN, a.departemen, a.penilai, a.poin_kebijakan, a.keterangan, (a.dandori + a.kecepatan + a.ketelitian + a.improvement + a.sikap_kerja + a.Penyelesaian_masalah + a.horenso)as nilai1, (a.pengetahuan)as nilai2, (a.keputusan + a.ekspresi + a.perencanaan + a.respon)as nilai3, (a.kedisiplinan + a.kerjasama + a.antusiasme + a.tanggung_jawab)as nilai4, (a.poin_kebijakan)as nilai5'))
        ->where('a.periode','like',$periode.'%')
        ->where('a.type','=','Performance')
        ->where('a.jabatan','!=','leader')
        ->where('a.jabatan','!=','foreman')
        ->where('a.jabatan','!=','Ast Supervisor')
        ->where('a.jabatan','!=','Supervisor')
        ->where('a.jabatan','!=','Ast Manager')
        ->where('a.jabatan','!=','Manager')
        ->where('a.disetujui','!=',null)
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','NO');
        $sheet->setCellValue('B1','PERIODE');
        $sheet->setCellValue('C1','NIK');
        $sheet->setCellValue('D1','NAMA');
        $sheet->setCellValue('E1','STATUS');
        $sheet->setCellValue('F1','DEPARTEMEN');
        $sheet->setCellValue('G1','Evaluasi Hasil Kinerja');
        $sheet->setCellValue('H1','Pengetahuan Keterampilan');
        $sheet->setCellValue('I1','Penilaian Kemampuan');
        $sheet->setCellValue('J1','Penilaian Sikap, Kesadaran');
        $sheet->setCellValue('K1','TOTAL');
        $sheet->setCellValue('L1','Rata - Rata');
        $sheet->setCellValue('M1','Total Poin');
        $sheet->setCellValue('N1','RANK');
        $sheet->setCellValue('O1','PENILAI');
        $sheet->setCellValue('P1','PENYESUAIAN');
        $sheet->setCellValue('Q1','KETERANGAN');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->periode);
            $sheet->setCellValue('C'.$line,$data->nik);
            $sheet->setCellValue('D'.$line,$data->nama);
            $sheet->setCellValue('E'.$line,$data->STATUS_KARYAWAN);
            $sheet->setCellValue('F'.$line,$data->departemen);
            $sheet->setCellValue('G'.$line,$data->nilai1);
            $sheet->setCellValue('H'.$line,$data->nilai2);
            $sheet->setCellValue('I'.$line,$data->nilai3);
            $sheet->setCellValue('J'.$line,$data->nilai4);

            $total = $data->nilai1 + $data->nilai2 + $data->nilai3 + $data->nilai4;
            $sheet->setCellValue('K'.$line,$total);

            $rata = ($data->nilai1/7) + ($data->nilai2/1) + ($data->nilai3/4) + ($data->nilai4/4);
            $sheet->setCellValue('L'.$line,$rata);

            $totalpoin = (($data->nilai1/7)*(40/100)*20) + (($data->nilai2/1)*(10/100)*20) + (($data->nilai3/4)*(10/100)*20) + (($data->nilai4/4)*(40/100)*20) + ($data->nilai5);
            $sheet->setCellValue('M'.$line,$totalpoin);

            if($totalpoin >= 86){
                $rank = "S";
            } elseif($totalpoin >= 71) {
                $rank = "A";
            } elseif($totalpoin >= 51){
                $rank = "B";
            } elseif($totalpoin >= 35){
                $rank = "C";
            } else {
                $rank = "D";
            }

            $sheet->setCellValue('N'.$line,$rank);
            $sheet->setCellValue('O'.$line,$data->penilai);
            $sheet->setCellValue('P'.$line,$data->poin_kebijakan);
            $sheet->setCellValue('Q'.$line,$data->keterangan);
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Rekap_Penilaian_Umum".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
       
    }

    public function excelrekapbonus (Request $request){
        $periode = $request->input("periode")."-01";

        $Datas = DB::table('tb_appraisal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.id_appraisal,a.periode,a.nik, a.nama, b.STATUS_KARYAWAN, a.departemen, a.penilai, a.poin_kebijakan, a.keterangan, (a.dandori + a.kecepatan + a.ketelitian + a.improvement + a.sikap_kerja + a.Penyelesaian_masalah + a.horenso)as nilai1, (a.kedisiplinan + a.kerjasama + a.antusiasme + a.tanggung_jawab)as nilai4, (a.poin_kebijakan)as nilai5'))
        ->where('a.periode','like',$periode.'%')
        ->where('a.type','=','Bonus')
        ->where('a.jabatan','!=','leader')
        ->where('a.jabatan','!=','foreman')
        ->where('a.jabatan','!=','Ast Supervisor')
        ->where('a.jabatan','!=','Supervisor')
        ->where('a.jabatan','!=','Ast Manager')
        ->where('a.jabatan','!=','Manager')
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','NO');
        $sheet->setCellValue('B1','PERIODE');
        $sheet->setCellValue('C1','NIK');
        $sheet->setCellValue('D1','NAMA');
        $sheet->setCellValue('E1','STATUS');
        $sheet->setCellValue('F1','DEPARTEMEN');
        $sheet->setCellValue('G1','Evaluasi Hasil Kinerja');
        $sheet->setCellValue('H1','Penilaian Sikap, Kesadaran');
        $sheet->setCellValue('I1','TOTAL');
        $sheet->setCellValue('J1','Rata - Rata');
        $sheet->setCellValue('K1','Total Poin');
        $sheet->setCellValue('L1','RANK');
        $sheet->setCellValue('M1','PENILAI');
        $sheet->setCellValue('N1','PENYESUAIAN');
        $sheet->setCellValue('O1','KETERANGAN');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->periode);
            $sheet->setCellValue('C'.$line,$data->nik);
            $sheet->setCellValue('D'.$line,$data->nama);
            $sheet->setCellValue('E'.$line,$data->STATUS_KARYAWAN);
            $sheet->setCellValue('F'.$line,$data->departemen);
            $sheet->setCellValue('G'.$line,$data->nilai1);
            $sheet->setCellValue('H'.$line,$data->nilai4);

            $total = $data->nilai1 + $data->nilai4;
            $sheet->setCellValue('I'.$line,$total);

            $rata = ($data->nilai1/7) + ($data->nilai4/4);
            $sheet->setCellValue('J'.$line,$rata);

            $totalpoin = (($data->nilai1/7)*(60/100)*20) + (($data->nilai4/4)*(40/100)*20) + ($data->nilai5);
            $sheet->setCellValue('K'.$line,$totalpoin);

            if($totalpoin >= 86){
                $rank = "S";
            } elseif($totalpoin >= 71) {
                $rank = "A";
            } elseif($totalpoin >= 51){
                $rank = "B";
            } elseif($totalpoin >= 35){
                $rank = "C";
            } else {
                $rank = "D";
            }

            $sheet->setCellValue('L'.$line,$rank);
            $sheet->setCellValue('M'.$line,$data->penilai);
            $sheet->setCellValue('N'.$line,$data->poin_kebijakan);
            $sheet->setCellValue('O'.$line,$data->keterangan);
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Rekap_Bonus_Umum".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
    }

    public function edit_poin_umum (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req = DeptheadModel::find($id);

            if ($dept == "Admin" || $dept == $req->dept || strtoupper($rubah) == "ASMAN" ) { 
                if ($req->poin_kebijakan = $request['poin_kebijakan'] <-100 || $req->poin_kebijakan = $request['poin_kebijakan'] >100){
                    //echo ("gagal ");
                    $status = false;
                    $mess = "Update gagal.";
                } else {
                    $req->poin_kebijakan = $request['poin_kebijakan'];
                    $req->keterangan = $request['keterangan'];

                    $req->save();
                    $status = true;
                    $mess = "Update data berhasil";
                }
            }
    
            $details = [
                'id_appraisal' => $id,
                'poin_kebijakan'=>$request['poin_kebijakan'],
                'keterangan' => $request['keterangan'],
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

    public function edit_poin_bonus_umum (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req = DeptheadModel::find($id);

            if ($dept == "Admin" || $dept == $req->dept || strtoupper($rubah) == "ASMAN") { 
                if ($req->poin_kebijakan = $request['poin_kebijakan'] <-100 || $req->poin_kebijakan = $request['poin_kebijakan'] >100){
                    //echo ("gagal ");
                    $status = false;
                    $mess = "Update gagal.";
                } else {
                    $req->poin_kebijakan = $request['poin_kebijakan'];
                    $req->keterangan = $request['keterangan'];

                    $req->save();
                    $status = true;
                    $mess = "Update data berhasil";
                }
            }
    
            $details = [
                'id_bonus' => $id,
                'poin_kebijakan'=>$request['poin_kebijakan'],
                'keterangan' => $request['keterangan'],
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

    public function edit_poin_leaderup (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req = DeptheadModel::find($id);

            if ($dept == "Admin" || $dept == $req->dept || strtoupper($rubah) == "ASMAN" ) { 
                if ($req->poin_kebijakan = $request['poin_kebijakan'] <-100 || $req->poin_kebijakan = $request['poin_kebijakan'] >100){
                    //echo ("gagal ");
                    $status = false;
                    $mess = "Update gagal.";
                } else {
                    $req->poin_kebijakan = $request['poin_kebijakan'];
                    $req->keterangan = $request['keterangan'];

                    $req->save();
                    $status = true;
                    $mess = "Update data berhasil";
                }
            }
    
            $details = [
                'id_appraisal' => $id,
                'poin_kebijakan'=>$request['poin_kebijakan'],
                'keterangan' => $request['keterangan'],
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

    public function edit_poin_bonus_leaderup (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $rubah = $user->user_name;
            $id = $request->input('id');
            $req = DeptheadModel::find($id);

            if ($dept == "Admin" || $dept == $req->dept || strtoupper($rubah) == "ASMAN" ) { 
                if ($req->poin_kebijakan = $request['poin_kebijakan'] <-100 || $req->poin_kebijakan = $request['poin_kebijakan'] >100){
                    //echo ("gagal ");
                    $status = false;
                    $mess = "Update gagal.";
                } else {
                    $req->poin_kebijakan = $request['poin_kebijakan'];
                    $req->keterangan = $request['keterangan'];

                    $req->save();
                    $status = true;
                    $mess = "Update data berhasil";
                }
            }
    
            $details = [
                'id_bonus' => $id,
                'poin_kebijakan'=>$request['poin_kebijakan'],
                'keterangan' => $request['keterangan'],
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

    public function excelrekappenilaianleaderup (Request $request){
        $periode = $request->input("periode")."-01";

        $Datas = DeptheadModel::select(DB::raw('id_appraisal,periode, nik, nama, departemen, penilai, poin_kebijakan, keterangan, (keselamatan + kualitas + biaya + pengiriman + penjualan)as nilai1, (kontrol_progres + improvement + penyelesaian_masalah + motivasi_bawahan + horenso + koordinasi_pekerjaan)as nilai2, (pengetahuan)as nilai3, (keputusan + perencanaan + negosiasi + respon)as nilai4, (kedisiplinan + kerjasama + antusiasme + tanggung_jawab)as nilai5, (poin_kebijakan)as nilai6, keterangan'))
        ->where('periode','like',$periode.'%')
        ->where('type','!=','Bonus')
        ->where('jabatan','!=','staff')
        ->where('jabatan','!=','operator')
        ->where('disetujui','!=',null)
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','NO');
        $sheet->setCellValue('B1','PERIODE');
        $sheet->setCellValue('C1','NIK');
        $sheet->setCellValue('D1','NAMA');
        $sheet->setCellValue('E1','DEPARTEMEN');
        $sheet->setCellValue('F1','Evaluasi Hasil Kinerja');
        $sheet->setCellValue('G1','Evaluasi Proses');
        $sheet->setCellValue('H1','Capability Pengetahuan');
        $sheet->setCellValue('I1','Capability Kemampuan');
        $sheet->setCellValue('J1','Sikap, Kesadaran');
        $sheet->setCellValue('K1','TOTAL');
        $sheet->setCellValue('L1','Rata - Rata');
        $sheet->setCellValue('M1','Total Poin Production');
        $sheet->setCellValue('N1','Total Poin Indirect');
        $sheet->setCellValue('O1','RANK PRODUCTION');
        $sheet->setCellValue('P1','RANK INDIRECT');
        $sheet->setCellValue('Q1','PENILAI');
        $sheet->setCellValue('R1','PENYESUAIAN');
        $sheet->setCellValue('S1','KETERANGAN');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->periode);
            $sheet->setCellValue('C'.$line,$data->nik);
            $sheet->setCellValue('D'.$line,$data->nama);
            $sheet->setCellValue('E'.$line,$data->departemen);
            $sheet->setCellValue('F'.$line,$data->nilai1);
            $sheet->setCellValue('G'.$line,$data->nilai2);
            $sheet->setCellValue('H'.$line,$data->nilai3);
            $sheet->setCellValue('I'.$line,$data->nilai4);
            $sheet->setCellValue('J'.$line,$data->nilai5);
            $total = $data->nilai1 + $data->nilai2 + $data->nilai3 + $data->nilai4 + $data->nilai5;
            $sheet->setCellValue('K'.$line,$total);

            $rata = ($data->nilai1/5) + ($data->nilai2/6) + ($data->nilai3/1) + ($data->nilai4/4)+ ($data->nilai5/4);
            $sheet->setCellValue('L'.$line,$rata);

            $totalpoinproduction = (($data->nilai1/5)*(30/100)*20) + (($data->nilai2/6)*(25/100)*20) + (($data->nilai3/1)*(5/100)*20) + (($data->nilai4/4)*(10/100)*20) + (($data->nilai5/4)*(30/100)*20) + ($data->nilai6);
            $sheet->setCellValue('M'.$line,$totalpoinproduction);

            $totalpoinindirect = (($data->nilai1/5)*(10/100)*20) + (($data->nilai2/6)*(25/100)*20) + (($data->nilai3/1)*(10/100)*20) + (($data->nilai4/4)*(25/100)*20) + (($data->nilai5/4)*(30/100)*20) + ($data->nilai6);
            $sheet->setCellValue('N'.$line,$totalpoinindirect);

            if($totalpoinproduction >= 86){
                $rank = "S";
            } elseif($totalpoinproduction >= 71) {
                $rank = "A";
            } elseif($totalpoinproduction >= 51){
                $rank = "B";
            } elseif($totalpoinproduction >= 35){
                $rank = "C";
            } else {
                $rank = "D";
            }
            $sheet->setCellValue('O'.$line,$rank);

            if($totalpoinindirect >= 86){
                $rank = "S";
            } elseif($totalpoinindirect >= 71) {
                $rank = "A";
            } elseif($totalpoinindirect >= 51){
                $rank = "B";
            } elseif($totalpoinindirect >= 35){
                $rank = "C";
            } else {
                $rank = "D";
            }
            $sheet->setCellValue('P'.$line,$rank);

            $sheet->setCellValue('Q'.$line,$data->penilai);
            $sheet->setCellValue('R'.$line,$data->poin_kebijakan);
            $sheet->setCellValue('S'.$line,$data->keterangan);
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Rekap_Penilaian_LeaderUp".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
       
    }

    public function excelrekapbonusleaderup (Request $request){
        $periode = $request->input("periode")."-01";

        $Datas = DeptheadModel::select(DB::raw('id_appraisal,periode, nik, nama, departemen, penilai, poin_kebijakan, keterangan, (keselamatan + kualitas + biaya + pengiriman + penjualan)as nilai1, (kedisiplinan + kerjasama + antusiasme + tanggung_jawab)as nilai5, (poin_kebijakan)as nilai6, keterangan'))
        ->where('periode','like',$periode.'%')
        ->where('type','=','Bonus')
        ->where('jabatan','!=','operator')
        ->where('jabatan','!=','staff')
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','NO');
        $sheet->setCellValue('B1','PERIODE');
        $sheet->setCellValue('C1','NIK');
        $sheet->setCellValue('D1','NAMA');
        $sheet->setCellValue('E1','DEPARTEMEN');
        $sheet->setCellValue('F1','Evaluasi Hasil Kinerja');
        $sheet->setCellValue('G1','Sikap, Kesadaran');
        $sheet->setCellValue('H1','TOTAL');
        $sheet->setCellValue('I1','Rata - Rata');
        $sheet->setCellValue('J1','Total Poin Production');
        $sheet->setCellValue('K1','Total Poin Indirect');
        $sheet->setCellValue('L1','RANK PRODUCTION');
        $sheet->setCellValue('M1','RANK INDIRECT');
        $sheet->setCellValue('N1','PENILAI');
        $sheet->setCellValue('O1','PENYESUAIAN');
        $sheet->setCellValue('P1','KETERANGAN');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->periode);
            $sheet->setCellValue('C'.$line,$data->nik);
            $sheet->setCellValue('D'.$line,$data->nama);
            $sheet->setCellValue('E'.$line,$data->departemen);
            $sheet->setCellValue('F'.$line,$data->nilai1);
            $sheet->setCellValue('G'.$line,$data->nilai5);
            $total = $data->nilai1 + $data->nilai5;
            $sheet->setCellValue('H'.$line,$total);

            $rata = ($data->nilai1/5) + ($data->nilai5/4);
            $sheet->setCellValue('I'.$line,$rata);

            $totalpoinproduction = (($data->nilai1/5)*(60/100)*20) + (($data->nilai5/4)*(40/100)*20) + ($data->nilai6);
            $sheet->setCellValue('J'.$line,$totalpoinproduction);

            $totalpoinindirect = (($data->nilai1/5)*(55/100)*20) + (($data->nilai5/4)*(45/100)*20) + ($data->nilai6);
            $sheet->setCellValue('K'.$line,$totalpoinindirect);

            if($totalpoinproduction >= 86){
                $rank = "S";
            } elseif($totalpoinproduction >= 71) {
                $rank = "A";
            } elseif($totalpoinproduction >= 51){
                $rank = "B";
            } elseif($totalpoinproduction >= 35){
                $rank = "C";
            } else {
                $rank = "D";
            }
            $sheet->setCellValue('L'.$line,$rank);

            if($totalpoinindirect >= 86){
                $rank = "S";
            } elseif($totalpoinindirect >= 71) {
                $rank = "A";
            } elseif($totalpoinindirect >= 51){
                $rank = "B";
            } elseif($totalpoinindirect >= 35){
                $rank = "C";
            } else {
                $rank = "D";
            }
            $sheet->setCellValue('M'.$line,$rank);

            $sheet->setCellValue('N'.$line,$data->penilai);
            $sheet->setCellValue('O'.$line,$data->poin_kebijakan);
            $sheet->setCellValue('P'.$line,$data->keterangan);
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Rekap_Bonus_LeaderUp".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
       
    }

    public function employee (){
        $karyawan = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->select('status_karyawan', 'jenis_kelamin', 'nama_jabatan', 'nama_departemen')->count();
        $statusk = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->selectRaw('status_karyawan, count (status_karyawan) as total')->groupBy('status_karyawan')->get();
        $jenisk = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->selectRaw('jenis_kelamin, count (jenis_kelamin) as total')->groupBy('jenis_kelamin')->get();
        
        //dd($statusk);
      $nikah = 0;
      $belumnikah = 0;
      $duda = 0;
      $janda = 0;
      $kosong = 0;
      
      //dd($nikah);

        return view ('/pga/employee',['karyawan'=>$karyawan, 'statusk'=>$statusk,'jenisk'=>$jenisk]);
    }

    public function countkaryawan (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        
        //$Datas = db::connection('sqlsrv_pga')->select("select nama_departemen, dept_section, count(dept_section) as total from t_karyawan group by nama_departemen, dept_section ");
        //dd($Datas);
        //$Datas = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->selectRaw('dept_section,nama_departemen, count (dept_section) as total')->groupBy('dept_section','nama_departemen')             
        $Datas = db::connection('sqlsrv_pga')->table('t_karyawan')->select(DB::Raw('dept_section,nama_departemen, count(*)as total'))->where('status_karyawan','<>','Off')->where('nama_departemen','<>','Admin')->groupBy('dept_section','nama_departemen')
        ->where(function($q) use ($search){
            $q->where('dept_section','like','%'.$search.'%')
            ->orwhere('nama_departemen','like','%'.$search.'%');
        }) 
        ->skip($start)
        ->take($length)
        ->get();
        
        $count = db::connection('sqlsrv_pga')->table('t_karyawan')->select(DB::Raw('dept_section,nama_departemen, count(*)as total'))->where('status_karyawan','<>','Off')->where('nama_departemen','<>','Admin')->groupBy('dept_section','nama_departemen')               

        ->where(function($q) use ($search){
            $q->where('dept_section','like','%'.$search.'%')
            ->orwhere('nama_departemen','like','%'.$search.'%');
        }) 
        ->count();

        //dd($count);
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function countkaryawan_1 (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $Datas = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->selectRaw('nama_jabatan, count (nama_jabatan) as total')->where('nama_departemen','<>','Admin')->groupBy('nama_jabatan')             
        ->where(function($q) use ($search){
            $q->where('dept_section','like','%'.$search.'%')
            ->orwhere('nama_jabatan','like','%'.$search.'%');
        }) 
        ->skip($start)
        ->take($length)
        ->get();

        $count =  db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->selectRaw('nama_jabatan, count (nama_jabatan) as total')->where('nama_departemen','<>','Admin')->groupBy('nama_jabatan')               
        ->where(function($q) use ($search){
            $q->where('dept_section','like','%'.$search.'%')
            ->orwhere('nama_jabatan','like','%'.$search.'%');
        })
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function detail_karyawan (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $nama_jabatan = $request->input("nama_jabatan");
        //$nama_jabatan = 'Leader';

        $Datas = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->where('nama_jabatan','=',$nama_jabatan)->select('nik', 'nama', 'nama_jabatan', 'dept_section')           
        ->where(function($q) use ($search){
            $q->where('dept_section','like','%'.$search.'%')
            ->orwhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%');
        }) 
        ->skip($start)
        ->take($length)
        ->get();

        $count =  db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->where('nama_jabatan','=',$nama_jabatan)->select('nik', 'nama', 'nama_jabatan', 'dept_section')             
        ->where(function($q) use ($search){
            $q->where('dept_section','like','%'.$search.'%')
            ->orwhere('nik','like','%'.$search.'%')
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

    public function detail_karyawan_list (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $dept_section = $request->input("dept_section");
        //dd($dept_section);

        $Datas = db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->where('dept_section','=',$dept_section)->select('nik', 'nama', 'nama_jabatan', 'dept_section')           
        ->where(function($q) use ($search){
            $q->where('nama_jabatan','like','%'.$search.'%')
            ->orwhere('nik','like','%'.$search.'%')
            ->orwhere('nama','like','%'.$search.'%');
        }) 
        ->skip($start)
        ->take($length)
        ->get();

        $count =  db::connection('sqlsrv_pga')->table('t_karyawan')->where('status_karyawan','!=','Off')->where('dept_section','=',$dept_section)->select('nik', 'nama', 'nama_jabatan', 'dept_section')             
        ->where(function($q) use ($search){
            $q->where('nama_jabatan','like','%'.$search.'%')
            ->orwhere('nik','like','%'.$search.'%')
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

    public function absensi_upload(){
        return view ('pga/absensi_upload');
    }

    public function import_absensi (Request $request){
        if ($request->hasFile('import_file')) {
            $path = $request->file('import_file')->getRealPath();
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $Data = $reader->load($path);
            $sheetdata = $Data->getActiveSheet()->toArray(null, true, true, true);
             unset($sheetdata[1]);
           
            $gagal = 0;
            $list = array ();
            foreach ($sheetdata as $row) {
            $cek = UploadabsensiModel::where('nik','=',$row['B'])->where('periode_absen','=',$row['A'])->count();
                //dd($row['B']);
                
                if ($cek > 0){
                  $gagal =  $gagal + 1;
            array_push($list,$row['B']);
                }else{
                    UploadabsensiModel::create([
                        'id_no'=>Str::uuid(),
                     'periode_absen'=>$row['A'],
                     'nik'=>$row['B'],
                     'tot_jadwal'=>$row['C'],
                     'tot_aktual'=>$row['D'],
                     'dinas_luar'=>$row['E'],
                     'alpa'=>$row['F'],
                     'sakit_faskes'=>$row['G'],
                     'sakit_nonfaskes'=>$row['H'],
                     'itu'=>$row['I'],
                     'cuti_tahunan'=>$row['J'],
                     'cuti_hamil'=>$row['K'],
                     'cuti_nikah'=>$row['L'],
                     'cuti_haid'=>$row['M'],
                     'cuti_kematian'=>$row['N'],
                     'cuti_khitan_anak'=>$row['O'],
                     'cuti_haji'=>$row['P'],
                     'cuti_kelahiran'=>$row['Q'],
                     'ijin_serikat'=>$row['R'],
                     'tot_absen'=>$row['S'],
                     'avg_absen'=>$row['T'],
                     'avg_dept'=>$row['U'],
                     'avg_npmi'=>$row['V'],
                    
                 ]);
                }
            }
           
            if ($gagal > 0){
               $pesan = implode(",",$list);
                Session::flash('alert-danger','Error Nik sudah ada : '.$pesan);     
            }else{

                Session::flash('alert-success','Import data berhasil'); 
            }
            return redirect()->route('upload');
            
        }
    }

    public function listabsensi(){
        return view('/pga/listabsensi');
    }

    public function inqueryabsensi (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $dept_section = $request->input("dept_section");

            //dd($dept_section);
            //$nama = DB::select("select b.*, a.nama from db_pgasystem.dbo.t_karyawan a join db_produksi.dbo.tb_absen b on a.nik=b.nik");
            //dd($nama);
        $Datas = DB::table( \DB::raw('db_produksi.dbo.tb_absen as a'))
                        ->join(\DB::raw('db_pgasystem.dbo.t_karyawan as b'), 'a.nik', '=', 'b.nik')
                        ->select('a.*', 'b.nama')
                        ->where(function($q) use ($search){
                            $q->where('a.periode_absen','like','%'.$search.'%')
                            ->orwhere('a.nik','like','%'.$search.'%')
                            ->orwhere('b.nama','like','%'.$search.'%');
                        }) 
                        ->skip($start)
                        ->take($length)
                        ->get();

            /*
            $Datas = db::table('tb_absen')           
            ->where(function($q) use ($search){
                $q->where('periode_absen','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%');
            }) 
            ->skip($start)
            ->take($length)
            ->get();
            */

    
            $count =  DB::table( \DB::raw('db_produksi.dbo.tb_absen as a'))
            ->join(\DB::raw('db_pgasystem.dbo.t_karyawan as b'), 'a.nik', '=', 'b.nik')
            ->select('a.*', 'b.nama')           
            ->where(function($q) use ($search){
                $q->where('a.periode_absen','like','%'.$search.'%')
                ->orwhere('a.nik','like','%'.$search.'%')
                ->orwhere('b.nama','like','%'.$search.'%');
            }) 
            ->count();
            
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }
    

        public function skillmatrik (Request $request){
            $dept_section = db::connection('sqlsrv_pga')->table('t_departemen')->select('dept_section')->groupBy('dept_section')->get();
            $kategori = db::table('tb_lainlain')->select('kategori_ojt')->where('kategori_ojt','!=',null)->groupBy('kategori_ojt')->get();
            $nomerinduk = DB::connection('sqlsrv_pga')->select("select nik, nama, dept_section from t_karyawan where status_karyawan != 'Off'");
            $inst = DB::connection('sqlsrv_pga')->select("select nama from t_karyawan where status_karyawan != 'Off' and nama_jabatan != 'operator' and nama_jabatan != 'staff' ");
            return view ('/pga/skillmatrik',['dept_section'=>$dept_section, 'kategori'=>$kategori, 'nomerinduk'=>$nomerinduk, 'inst'=>$inst]);
        }

        public function inqueryskillkaryawanbaru (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            //dd($dept_section);
            $env_database = env('DB_DATABASE');
    
            $allnik = DB::table( \DB::raw('db_pgasystem.dbo.t_karyawan as a'))
            ->join(\DB::raw($env_database.'.dbo.tb_rencana_pelatihan as b'), 'a.nik', '=', 'b.nik')
            ->select('a.nik','a.nama','a.dept_section')->get();
            //dd($allnik);
       
            $listdept= array();
                
                foreach ($allnik as $key) {
                    array_push($listdept,$key->nik);  
                }

                //dd($listdept);

            $Datas = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama','dept_section')
            ->whereNotIn('nik',$listdept)->where('nik','>=','0932')->where('nik','!=','11111')->where('nik','!=','999999')
            ->skip($start)
            ->take($length)
            ->get();

            $count = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama','dept_section')
            ->whereNotIn('nik',$listdept)->where('nik','>=','0932')->where('nik','!=','11111')->where('nik','!=','999999') 
            ->count();
            
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }

        public function inquerytemapelatihan (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");

            $Datas = db::table('tb_tema_pelatihan')->select('id_tema_pelatihan', 'kategori', 'tema_pelatihan', 'dept_section','standar','user_pengaju','approved')
            ->where('approved','!=',null)->where('status_pengajuan','=','Terima')          
            ->where(function($q) use ($search){
                $q->where('kategori','like','%'.$search.'%')
                ->orwhere('tema_pelatihan','like','%'.$search.'%')
                ->orwhere('standar','like','%'.$search.'%')
                ->orwhere('dept_section','like','%'.$search.'%');
            }) 
            ->orderBy('kategori','asc')->orderBy('tema_pelatihan','asc')
            ->skip($start)
            ->take($length)
            ->get();
    
            $count =  db::table('tb_tema_pelatihan')->select('id_tema_pelatihan', 'kategori', 'tema_pelatihan', 'dept_section','standar','user_pengaju','approved') 
            ->where('approved','!=',null)->where('status_pengajuan','=','Terima')              
            ->where(function($q) use ($search){
                $q->where('kategori','like','%'.$search.'%')
                ->orwhere('tema_pelatihan','like','%'.$search.'%')
                ->orwhere('standar','like','%'.$search.'%')
                ->orwhere('dept_section','like','%'.$search.'%');
            })
            ->count();
            
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }

        public function ajukantemabaru (Request $request){
            //dd($request->all());
            $id = Str::uuid();
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $userpengaju = $user->user_name;

            $cek = DB::table('tb_tema_pelatihan')->select('tema_pelatihan')->where('kategori','=',$request->kategori)
            ->where('tema_pelatihan','=',$request->tema_pelatihan)->where('dept_section','=',$request->dept_section)
            ->where('standar','=',$request->standar)->count();
            //dd($cek);

            if($cek >= 1){
                return array(
                    'message' => 'Tema sudah ada !',
                    'success' => false,
                );
            } else {
                $tambahtemabaru = TemaPelatihanModel::create([
                    'id_tema_pelatihan'=>$id,
                    'kategori'=>$request->input('kategori'),
                    'tema_pelatihan'=>$request->input('tema_pelatihan'),
                    'dept_section'=>$request->input('dept_section'),
                    'standar'=>$request->input('standar'),
                    'user_pengaju'=>$userpengaju,
                ]);

                if($tambahtemabaru){
                  return array(
                      'message' => 'Pengajuan Tema Baru Berhasil !',
                      'success' => true,
                    );
                  } else {
                  return array(
                      'message' => 'Pengajuan tema baru Gagal !',
                      'success' => false,
                  );
                }
            }

        }

        public function form_rpk (Request $request){
            //dd($request->all());
            $kode = $request->rpk_isitujuan;
            $idrpk = Str::uuid();
            $datenow = date('Y-m-d H:i:s');
            $nik = $request->input('rpk-nik');
            $dept = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section')->where('nik','=',$nik)->get();
            //dd($dept[0]->dept_section);

            $insertrpk = DB::table('tb_rencana_pelatihan')->insert([
                'id_rencana_pelatihan' => $idrpk,
                'nik' => $request->input('rpk-nik'),
                'nama' => $request->input('rpk-nama'),
                'tema_pelatihan' => $request->input('rpk-tema'),
                'level_pelatihan' => $request->input('rpk-level'),
                'rencana_mulai' => $request->input('rpk-mulai'),
                'rencana_selesai' => $request->input('rpk-selesai'),
                'dept_pelatihan' => $dept[0]->dept_section,
                'loc_pelatihan' => $request->input('rpk-lokasi'),
                'status_pelatihan' => 'Rencana',
                'id_tema_pelatihan' => $request->input('rpk-idpelatihan'),
                'created_at' => $datenow,
                'updated_at' =>$datenow,
            ]);

            if($insertrpk){
                if (!empty($kode)) {
                    $coun = count($kode);
                      for ($i=0; $i<$coun; $i++){
                        $idojt = Str::uuid();
                        OjtModel::create([
                          'id_ojt'=> $idojt,
                          'id_rencana_pelatihan' => $idrpk,
                          'isi_tujuan' => $request->rpk_isitujuan[$i],
                          //'instruktur' => $request->rpk_instruktur[$i],
                        ]); 
                      }
                    }

                return array (
                    'message' => 'Tambah Rencana Pelatihan Berhasil !',
                    'success' => true,
                );
            } else {
                return array (
                    'message' => 'Tambah Rencana Pelatihan Gagal !',
                    'success' => false,
                );
            }
        }

        public function listnamasm (){
            return view ('pga/listnamasm');
        }

        public function inquerynamaskillmatrik (Request $request){

            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");

            /*$Datas = DB::select("select nik, nama, dept_pelatihan from tb_rencana_pelatihan where tema_pelatihan != '' and (nik like '%$search%' or nama like '%$search%' or dept_pelatihan like '%$search%')
            group by nik, nama, dept_pelatihan order by nik asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");


            $co = DB::select("select nik, nama, dept_pelatihan from tb_rencana_pelatihan where tema_pelatihan != '' and (nik like '%$search%' or nama like '%$search%' or dept_pelatihan like '%$search%')
            group by nik, nama, dept_pelatihan");
            $count = count($co);
            */
            $Datas = DB::table('tb_rencana_pelatihan as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.nik, a.nama, b.tanggal_masuk, a.dept_pelatihan'))
            ->where('a.tema_pelatihan','!=',null)
            ->where('a.tema_pelatihan','!=','')
            //->where('b.status_karyawan','=','Tetap')
            ->where(function($q) use ($search){
                $q->Where('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.dept_pelatihan','like','%'.$search.'%')
                ->orwhere('b.tanggal_masuk','like','%'.$search.'%');
            })     
            ->groupBy('a.nama','a.nik','a.dept_pelatihan','b.tanggal_masuk')   
            ->orderBy('a.nik')     
            ->skip($start)
            ->take($length)
            ->get();

            $count = DB::table('tb_rencana_pelatihan as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.nik, a.nama, b.tanggal_masuk, a.dept_pelatihan'))
            //->where('b.status_karyawan','=','Kontrak')
            ->where('a.tema_pelatihan','!=',null)
            ->where('a.tema_pelatihan','!=','')
            ->distinct('a.nik')
           ->where(function($q) use ($search){
                $q->Where('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('a.dept_pelatihan','like','%'.$search.'%')
                ->orwhere('b.tanggal_masuk','like','%'.$search.'%');
            })             
            ->count();

                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        
        public function listskillmatrik ($nik, $nama){
            $inst = DB::connection('sqlsrv_pga')->select("select nama from t_karyawan where status_karyawan != 'Off' and nama_jabatan != 'operator' and nama_jabatan != 'staff' ");
            //$inst = DB::table('tb_rencana_pelatihan')->select('nama')->where('')
            return view ('pga/listskillmatrik',['nik'=>$nik, 'nama'=>$nama, 'inst'=>$inst]);
        }

        public function all_skillmatrik ($nik, $nama){
            $inst = DB::connection('sqlsrv_pga')->select("select nama from t_karyawan where status_karyawan != 'Off' and nama_jabatan != 'operator' and nama_jabatan != 'staff' ");
            //$inst = DB::table('tb_rencana_pelatihan')->select('nama')->where('')
            return view ('pga/all_skillmatrik',['nik'=>$nik, 'nama'=>$nama, 'inst'=>$inst]);
        }

        public function listskilleksternal ($nik, $nama){
            return view ('pga/listskilleksternal',['nik'=>$nik, 'nama'=>$nama]);
        }

        public function inqueryskillmatrik (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            $nik = $request->nik;
            $nama = $request->nama;
            //dd($nik);

            $Datas = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_tema_pelatihan as b','b.id_tema_pelatihan','=','a.id_tema_pelatihan')->select(DB::raw('a.id_tema_pelatihan,a.id_rencana_pelatihan, a.nik, a.nama, a.tema_pelatihan, b.kategori, a.loc_pelatihan, b.standar, a.level_pelatihan, a.status_pelatihan, a.rencana_mulai, a.rencana_selesai, datediff(Day,rencana_mulai, rencana_selesai) as dif'))
            ->where('a.tema_pelatihan','!=',null)->where('a.nik','=',$nik)
            ->where(function($q) use ($search){
                $q->where('a.tema_pelatihan','like','%'.$search.'%')
                ->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('b.kategori','like','%'.$search.'%');
            })      
            ->orderBy('b.kategori','asc')->orderBy('a.tema_pelatihan','asc')       
            ->skip($start)
            ->take($length)
            ->get();

            $count = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_tema_pelatihan as b','b.id_tema_pelatihan','=','a.id_tema_pelatihan')->select(DB::raw('a.id_tema_pelatihan,a.id_rencana_pelatihan, a.nik, a.nama, a.tema_pelatihan, b.kategori, a.loc_pelatihan, b.standar, a.level_pelatihan, a.status_pelatihan, a.rencana_mulai, a.rencana_selesai, datediff(Day,rencana_mulai, rencana_selesai) as dif'))
            ->where('a.tema_pelatihan','!=',null)->where('a.nik','=',$nik)
            ->where(function($q) use ($search){
                $q->where('a.tema_pelatihan','like','%'.$search.'%')
                ->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('b.kategori','like','%'.$search.'%');
            })
            ->orderBy('b.kategori','asc')->orderBy('a.tema_pelatihan','asc')     
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        public function list_isitujuan (Request $request){
            //dd($request->all());
            $idpp = $request->id_rencana;
        /*    $idpptema = $request->id_tema_pelatihan;
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");

            //$inst = DB::table('tb_rencana_pelatihan')->select('nama')->where('id_tema_pelatihan','=',$idpptema)->where('status_pelatihan','=','Tercapai')->where('level_pelatihan','=',4)->get();

            $Datas = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_ojt as b','b.id_rencana_pelatihan','=','a.id_rencana_pelatihan')->select(DB::raw('b.id_rencana_pelatihan, b.isi_tujuan, b.instruktur, b.evaluasi, b.catatan, a.id_tema_pelatihan, b.id_ojt'))
            ->where('a.id_rencana_pelatihan','=',$idpp)
            ->where(function($q) use ($search){
                $q->where('b.isi_tujuan','like','%'.$search.'%')
                ->orWhere('b.instruktur','like','%'.$search.'%');
            })             
            ->skip($start)
            ->take($length)
            ->get();

            $count = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_ojt as b','b.id_rencana_pelatihan','=','a.id_rencana_pelatihan')->select(DB::raw('b.id_rencana_pelatihan, b.isi_tujuan, b.instruktur, b.evaluasi, b.catatan, a.id_tema_pelatihan, b.id_ojt'))
            ->where('a.id_rencana_pelatihan','=',$idpp)
            ->where(function($q) use ($search){
                $q->where('b.isi_tujuan','like','%'.$search.'%')
                ->orWhere('b.instruktur','like','%'.$search.'%');
            })
            ->count();

                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas,
                ];
                */

                $instruk = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_ojt as b','b.id_rencana_pelatihan','=','a.id_rencana_pelatihan')->select(DB::raw('b.id_rencana_pelatihan, b.isi_tujuan, b.instruktur, b.evaluasi, b.catatan, a.id_tema_pelatihan, b.id_ojt'))
                ->where('a.id_rencana_pelatihan','=',$idpp)->get();
                //dd($instruk);

                return array ('instruk'=>$instruk,
            'id_tema'=>$instruk[0]->id_tema_pelatihan);
        }

        public function form_pelaksanaanpelatihan (Request $request){
            //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dibuat = $user->user_name;
            //dd($user->departemen);

            $idapprovesm = Str::uuid();
            $kode = $request->pp_isitujuan;
            $ppid = $request->pp_idpelatihan;
            $datenow = date('Y-m-d H:i:s');

            $cek = DB::table('tb_ojt')->select('instruktur','evaluasi')->where('id_rencana_pelatihan','=',$ppid)
            ->where(function($q){
                $q->where('instruktur','=',null)->orWhere('evaluasi','=',null);
            })->get();

            $cek1 = DB::table('tb_ojt')->select('instruktur','evaluasi')->where('id_rencana_pelatihan','=',$ppid)
            ->where(function($q){
                $q->where('instruktur','!=',null)->orWhere('evaluasi','!=',null);
            })->get();

            $ceklok = DB::table('tb_rencana_pelatihan')->select('loc_pelatihan')->where('id_rencana_pelatihan',$ppid)->get();
            //dd($ceklok[0]->loc_pelatihan);

            if (count($cek) >= 1){
                return array(
                    'message' => 'Data Instruktur atau Evaluasi Belum terpenuhi  !',
                    'success' => false,
                );
            } else {
                if($user->departemen == "Admin" || $ceklok[0]->loc_pelatihan == $user->departemen ){
                    $ppupdate = DB::table('tb_rencana_pelatihan')->where('id_rencana_pelatihan','=',$ppid)->update([
                                    'aktual_mulai' => $request->pp_aktualmulai,
                                    'aktual_selesai' => $request->pp_aktualselesai,
                                    'status_pelatihan' => 'Belum Approve',
                                    'updated_at' =>$datenow,
                    ]);
    
                    $approvesm = ApproveSkillmatrikModel::create([
                        'id_approve_skillmatrik'=>$idapprovesm,
                        'id_rencana_pelatihan'=>$ppid,
                        'dibuat'=>$dibuat,
                        'tgl_dibuat'=>date('Y-m-d'),
                    ]);
    
                    return array(
                        'message' => 'Update Berhasil !',
                        'success' => true,
                      );
                } else if ($ceklok[0]->loc_pelatihan == "EKSTERNAL"){
                    if($user->departemen == "PGA"){
                        $ppupdate = DB::table('tb_rencana_pelatihan')->where('id_rencana_pelatihan','=',$ppid)->update([
                            'aktual_mulai' => $request->pp_aktualmulai,
                            'aktual_selesai' => $request->pp_aktualselesai,
                            'status_pelatihan' => 'Belum Approve',
                            'updated_at' =>$datenow,
                        ]);

                        $approvesm = ApproveSkillmatrikModel::create([
                            'id_approve_skillmatrik'=>$idapprovesm,
                            'id_rencana_pelatihan'=>$ppid,
                            'dibuat'=>$dibuat,
                            'tgl_dibuat'=>date('Y-m-d'),
                        ]);

                        return array(
                            'message' => 'Update Berhasil !',
                            'success' => true,
                        );
                    } else {
                        return array(
                            'message' => 'Lokasi pelatihan Eksternal, Section Anda Tidak Sesuai .',
                            'success' => false,
                          );
                    }

                } else {
                    return array(
                        'message' => 'Lokasi pelatihan dengan Section Anda Tidak Sesuai .',
                        'success' => false,
                      );
                }
            }

        }

        public function lembarOJT ($id){
            $req = RencanaPelatihanModel::find($id);
            $isi = DB::table('tb_ojt')->select('isi_tujuan','instruktur','evaluasi','catatan')->where('id_rencana_pelatihan','=',$req->id_rencana_pelatihan)->get();
            
            $sign = DB::table('tb_approve_skillmatrik')->where('id_rencana_pelatihan','=',$req->id_rencana_pelatihan)->get();
            //$isi []=$isi1;
            //dd($is);
            $printdate = date('Y-m-d H:i:s');
            $pdf = PDF::loadview('/pga/PDF_lembarOJT',['list'=>$req, 'isi'=>$isi, 'printdate'=>$printdate, 'sign'=>$sign])->setPaper('A4','potrait');
            return $pdf->stream('Lembar Laporan Pelaksanaan OJT.pdf');
        }

        public function get_instruktur (Request $request){
            //dd($request->all());
            $id_tema = $request->id_tema;
            $id_ojt = $request->id_ojt;

            $id_tema1 = DB::table('tb_rencana_pelatihan')->select('nama','id_rencana_pelatihan')->where('id_tema_pelatihan','=',$id_tema)->where('level_pelatihan','=',4)->where('status_pelatihan','=','Tercapai')->get();
            //$mgr = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama')->where('nama_jabatan','=','Manager')->get();
            $mgr = DB::table('tb_lainlain')->select('instruktur')->where('instruktur','!=',null)->get();
            $isi = DB::table('tb_ojt')->select('isi_tujuan','id_ojt','id_rencana_pelatihan')->where('id_ojt','=',$id_ojt)->get();
            if (count($id_tema1) > 0){
                return array(
                    'message' => 'Update Berhasil !',
                    'success' => true,
                    'inst' => $id_tema1,
                    'mgr' => $mgr,
                    'isi' => $isi,

                );
            } else {
                return array(
                    'message' => 'Instruktur Belum tersedia .',
                    'success' => false,
                    'mgr' => $mgr,
                    'isi' => $isi,
        
                );
            }
        }

        public function form_e_pelaksanaan_ojt (Request $request){
            //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            
            $e_ojt_id_rencana_pelatihan = $request->e_ojt_id_rencana_pelatihan;
            $e_ojt_inst = OjtModel::find($request['e_ojt_id_ojt']);
            $e_user_dept = DB::table('tb_rencana_pelatihan')->select('loc_pelatihan')->where('id_rencana_pelatihan','=',$e_ojt_id_rencana_pelatihan)->get();
            //dd($e_user_dept[0]->loc_pelatihan);

            if ($dept == "Admin" || $dept == $e_user_dept[0]->loc_pelatihan) {
                $e_ojt_inst->instruktur = $request['e_ojt_instruktur'];
                $e_ojt_inst->evaluasi = $request['e_ojt_evaluasi'];
                $e_ojt_inst->catatan = $request['e_ojt_catatan'];

                $e_ojt_inst->save();

                $status = true;
                $mess = "Update data berhasil";
            } else if ($e_user_dept[0]->loc_pelatihan == "EKSTERNAL"){
                if ($dept == "PGA"){
                    $e_ojt_inst->instruktur = $request['e_ojt_instruktur'];
                    $e_ojt_inst->evaluasi = $request['e_ojt_evaluasi'];
                    $e_ojt_inst->catatan = $request['e_ojt_catatan'];
    
                    $e_ojt_inst->save();
    
                    $status = true;
                    $mess = "Update data berhasil";
                } else {
                    $status = false;
                    $mess = "Update data gagal, Lokasi Pelatihan Eksternal !";
                }
            } else {
                $status = false;
                $mess = "Update data gagal, Lokasi Pelatihan tidak sesuai !";
            }

            return array(
                'message' => $mess,
                'success'=>$status
            );
        }

        public function inquerypengajuantema (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");

            $Datas = db::table('tb_tema_pelatihan')->select('id_tema_pelatihan', 'kategori', 'tema_pelatihan', 'dept_section','standar','user_pengaju','approved')
            ->where('status_pengajuan','=',null) 
           
            ->where(function($q) use ($search){
                $q->where('kategori','like','%'.$search.'%')
                ->orwhere('tema_pelatihan','like','%'.$search.'%')
                ->orwhere('standar','like','%'.$search.'%')
                ->orwhere('dept_section','like','%'.$search.'%');
            }) 
            ->skip($start)
            ->take($length)
            ->get();
    
            $count =  db::table('tb_tema_pelatihan')->select('id_tema_pelatihan', 'kategori', 'tema_pelatihan', 'dept_section','standar','user_pengaju','approved') 
            ->where('status_pengajuan','=',null) 
                 
            ->where(function($q) use ($search){
                $q->where('kategori','like','%'.$search.'%')
                ->orwhere('tema_pelatihan','like','%'.$search.'%')
                ->orwhere('standar','like','%'.$search.'%')
                ->orwhere('dept_section','like','%'.$search.'%');
            })
            ->count();
            
            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
        }

        public function approvetemapelatihan (Request $request){
            //dd($request->a);
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $kr = $user->departemen.$user->level_user;
            $req = TemaPelatihanModel::find($request->idltp);
            $tgl = date('Y-m-d');

            if($user->departemen == 'Admin' || $kr == 'PGAManager'){
                if($request->a == 'Approve'){
                    $req->approved = $user->user_name;
                    $req->tgl_approve = $tgl;
                    $req->status_pengajuan = 'Terima';
    
                    $req->save();
                    $status = true;
                    $mess = "Approve Tema Pelatihan berhasil .";
                } else if ($request->a == 'Tolak'){
                    $req->approved = $user->user_name;
                    $req->tgl_approve = $tgl;
                    $req->status_pengajuan = 'Tolak';
    
                    $req->save();
                    $status = true;
                    $mess = "Tema Pelatihan berhasil di Tolak .";
                }
            } else {
                $status = false;
                $mess = "Access Denied .";
            }

            return array(
                'message' => $mess,
                'success'=>$status
            );
        }

        public function listOJT(Request $request){
            $diperiksa = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama')->where('nama_jabatan','!=','staff')->where('nama_jabatan','!=','operator')->where('nama_jabatan','!=','manager')->where('status_karyawan','!=','Off')->get();
            $disahkan = DB::table('tb_penilai')->select('nik','nama')->where('kategori','=','SkillMatrik')->where('status','=','Aktif')->get();

            return view ('pga/listOJT',['diperiksa'=>$diperiksa, 'disahkan'=>$disahkan]);
        }

        public function listojt_1 (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            //dd($nama);

            $Datas = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_tema_pelatihan as b','b.id_tema_pelatihan','=','a.id_tema_pelatihan')->select(DB::raw('a.id_tema_pelatihan,a.id_rencana_pelatihan, a.nik, a.nama, a.tema_pelatihan, b.kategori, a.loc_pelatihan, b.standar, a.level_pelatihan, a.status_pelatihan, a.rencana_mulai, a.rencana_selesai, datediff(Day,rencana_mulai, rencana_selesai) as dif'))
            ->where('a.tema_pelatihan','!=',null)->where('a.status_pelatihan','=','Tercapai')
            ->where(function($q) use ($search){
                $q->where('a.tema_pelatihan','like','%'.$search.'%')
                ->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('b.kategori','like','%'.$search.'%')
                ->orwhere('a.loc_pelatihan','like','%'.$search.'%');
            })         
            ->orderBy('a.nik', 'asc')->orderBy('b.kategori','asc')->orderby('a.tema_pelatihan','asc')    
            ->skip($start)
            ->take($length)
            ->get();

            $count = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_tema_pelatihan as b','b.id_tema_pelatihan','=','a.id_tema_pelatihan')->select(DB::raw('a.id_tema_pelatihan,a.id_rencana_pelatihan, a.nik, a.nama, a.tema_pelatihan, b.kategori, a.loc_pelatihan, b.standar, a.level_pelatihan, a.status_pelatihan, a.rencana_mulai, a.rencana_selesai, datediff(Day,rencana_mulai, rencana_selesai) as dif'))
            ->where('a.tema_pelatihan','!=',null)->where('a.status_pelatihan','=','Tercapai')
            ->where(function($q) use ($search){
                $q->where('a.tema_pelatihan','like','%'.$search.'%')
                ->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('b.kategori','like','%'.$search.'%')
                ->orwhere('a.loc_pelatihan','like','%'.$search.'%');
            })
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }
    
        public function listojt_approve (Request $request){
            //dd($request->all());
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");

            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $lev = $user->level_user;
            //dd($lev);

            $cek = DB::table('tb_penilai')->where('nik','=',$user->nik)->where('kategori','=','SkillMatrik')->where('status','=','Aktif')->count();
            //dd($cek);
            $allev = array();

            if($dept == "PGA"){
                array_push($allev,$dept);
                array_push($allev,'EKSTERNAL');
            } else if ($cek >= 1){
                
                $dept2 = DB::connection('sqlsrv_pga')->table('t_karyawan as a')->leftjoin('t_departemen as b','b.nama_departemen','=','a.nama_departemen')->select('b.dept_section')->where('a.nik',$user->nik)->get();
                foreach ($dept2 as $key) {
                array_push($allev,$key->dept_section);
                }
            }  else {
                array_push($allev,$dept);
            }
            //dd($allev);

            $Datas = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_tema_pelatihan as b','b.id_tema_pelatihan','=','a.id_tema_pelatihan')->leftJoin('tb_approve_skillmatrik as c','c.id_rencana_pelatihan','=','a.id_rencana_pelatihan')->select(DB::raw('a.id_tema_pelatihan,a.id_rencana_pelatihan, a.nik, a.nama, a.tema_pelatihan, b.kategori, a.loc_pelatihan, b.standar, a.level_pelatihan, a.status_pelatihan, a.rencana_mulai, a.rencana_selesai, c.diperiksa, datediff(Day,rencana_mulai, rencana_selesai) as dif'))
            ->where('a.tema_pelatihan','!=',null)->where('status_pelatihan','=','Belum Approve')->whereIn('a.loc_pelatihan',$allev)
            ->where(function($q) use ($search){
                $q->where('a.tema_pelatihan','like','%'.$search.'%')
                ->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('b.kategori','like','%'.$search.'%')
                ->orwhere('loc_pelatihan','like','%'.$search.'%');
            })             
            ->skip($start)
            ->take($length)
            ->get();

            $count = DB::table('tb_rencana_pelatihan as a')->leftJoin('tb_tema_pelatihan as b','b.id_tema_pelatihan','=','a.id_tema_pelatihan')->leftJoin('tb_approve_skillmatrik as c','c.id_rencana_pelatihan','=','a.id_rencana_pelatihan')->select(DB::raw('a.id_tema_pelatihan,a.id_rencana_pelatihan, a.nik, a.nama, a.tema_pelatihan, b.kategori, a.loc_pelatihan, b.standar, a.level_pelatihan, a.status_pelatihan, a.rencana_mulai, a.rencana_selesai, c.diperiksa, datediff(Day,rencana_mulai, rencana_selesai) as dif'))
            ->where('a.tema_pelatihan','!=',null)->where('status_pelatihan','=','Belum Approve')->whereIn('a.loc_pelatihan',$allev)
            ->where(function($q) use ($search){
                $q->where('a.tema_pelatihan','like','%'.$search.'%')
                ->orWhere('a.nik','like','%'.$search.'%') 
                ->orwhere('a.nama','like','%'.$search.'%')
                ->orwhere('b.kategori','like','%'.$search.'%')
                ->orwhere('loc_pelatihan','like','%'.$search.'%');
            })
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        public function approve_pelaksanaan_ojt (Request $request){
            //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $diperiksa = $user->user_name;
            //dd($user->level_user);

            $t = DB::table('tb_approve_skillmatrik')->select('id_approve_skillmatrik')->where('id_rencana_pelatihan','=',$request->a_id_rencana_pelatihan)->get();
            $req = ApproveSkillmatrikModel::find($t[0]->id_approve_skillmatrik);
            $req_ren = RencanaPelatihanModel::find($request->a_id_rencana_pelatihan);
            //dd($req_ren);
            $tgl = date('Y-m-d');

            
            $cek_diperiksa = DB::table('tb_approve_skillmatrik')->where('id_rencana_pelatihan','=',$request->a_id_rencana_pelatihan)->where('diperiksa','!=',null)->count();
            $cek_disahkan = DB::table('tb_penilai')->select('nik')->where('nik','=',$user->nik)->where('kategori','=','SkillMatrik')->where('status','=','Aktif')->get();
            //dd(count($cek_disahkan));

            if($user->level_user == 'Operator' || $user->level_user == 'Administrasi' || $user->level_user == 'Staff'){
                return array(
                    'message' => 'Level Operator, Administrasi dan Staff tidak bisa Approve Skill Matrik .',
                    'success' => false,
                );
            } else {
                if(count($cek_disahkan) == 0){
                    if ($cek_diperiksa >= 1)  {
                        return array(
                            'message' => 'Sign diperiksa sudah dilakukan .',
                            'success' => false,
                        );
                    } else if($cek_diperiksa <= 0){
                        $req->diperiksa = $diperiksa;
                        $req->tgl_diperiksa = $tgl;
            
                        $req->save();
        
                        return array(
                            'message' => 'Sign Diperiksa berhasil diUpdate .',
                            'success' => true,
                        );
                    }
                } else {
                    if ($user->nik == $cek_disahkan[0]->nik){
                        $req->disahkan = $diperiksa;
                        $req->tgl_disahkan = $tgl;
            
                        $req->save();
    
                        $req_ren->status_pelatihan = 'Tercapai';
                        $req_ren->save();
        
                        return array(
                            'message' => 'Sign Disahkan berhasil diUpdate .',
                            'success' => true,
                        );
                    }
                }
            }
        }

        public function pp_update_eksternal (Request $request){
            //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->user_name;

            $mulai = substr($request->daterange,0,10);
            $selesai = substr($request->daterange,13);
            //dd($user->departemen);

            if($user->level_user == 'Admin' || $user->departemen == 'PGA'){
                $id_penyelenggara = Str::uuid();
    
                $tambahpenyelenggara = PenyelenggaraModel::create([
                    'id_penyelenggara'=>$id_penyelenggara,
                    'mulai_pelatihan'=>$mulai,
                    'selesai_pelatihan'=>$selesai,
                    'penyelenggara'=>$request->pp_penyelenggara,
                    'instruktur'=>$request->pp_instruktur,
                    'tempat'=>$request->pp_tempat,
                    'materi'=>$request->pp_materi,
                    'inputor'=>$inputor,
                  ]);

                  return array(
                    'message' => 'Update Penyelenggara Success .',
                    'success' => true,
                  );
            } else {
                return array(
                    'message' => 'Access denied .',
                    'success' => false,
                );
            }
        }

        public function inquerypenyelenggara (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            //dd($nama);

            $Datas = DB::table('tb_penyelenggara')->select('id_penyelenggara','mulai_pelatihan','selesai_pelatihan','penyelenggara','instruktur','tempat','materi','inputor')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orWhere('materi','like','%'.$search.'%');
            })         
            ->orderBy('penyelenggara', 'asc') 
            ->skip($start)
            ->take($length)
            ->get();
            //dd($Datas);
            $count = DB::table('tb_penyelenggara')->select('id_penyelenggara','mulai_pelatihan','selesai_pelatihan','penyelenggara','instruktur','tempat','materi','inputor')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orWhere('materi','like','%'.$search.'%');
            })  
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        public function form_rpke (Request $request){
            //dd($request->all());
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->user_name;

            $idrpke = Str::uuid();
            $idpenyelenggara = PenyelenggaraModel::find($request->id_rpke_penyelenggara);
            //dd($idpenyelenggara->mulai_pelatihan);
            $cek = DB::table('tb_pelatihan_eksternal')->where('id_penyelenggara','=',$request->id_rpke_penyelenggara)->where('nik','=',$request->rpke_nik)->count();
            //dd($cek);
            if($cek >= 1){
                return array (
                    'message' => 'Rencana Pelatihan Eksternal Sudah Ada .',
                    'success' => false,
                );
            } else if($user->level_user == 'Admin' || $user->departemen == 'PGA'){
                $insertrpke = PelatihanEksternalModel::create([
                    'id_pelatihan_eksternal' => $idrpke,
                    'id_penyelenggara' => $request->id_rpke_penyelenggara,
                    'tgl_pelatihan' => $idpenyelenggara->mulai_pelatihan,
                    'sampai' => $idpenyelenggara->selesai_pelatihan,
                    'nik' => $request->rpke_nik,
                    'nama' => $request->rpke_nama,
                    'tempat_pelatihan' => $idpenyelenggara->tempat,
                    'penyelenggara' => $idpenyelenggara->penyelenggara,
                    'materi_pelatihan' => $idpenyelenggara->materi,
                    'instruktur' => $idpenyelenggara->instruktur,
                    //'user_input' => $inputor,
                ]);
                return array (
                    'message' => 'Tambah Rencana Pelatihan Eksternal Berhasil !',
                    'success' => true,
                );
            } else {
                return array (
                    'message' => 'Tambah Rencana Pelatihan Eksternal Gagal !',
                    'success' => false,
                );
            }
        }

        public function inquery_rpke (Request $request){
            //dd($request->all());
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            $nik = $request->nik;
            //dd($nik);

            $Datas = DB::table('tb_pelatihan_eksternal')->select('id_pelatihan_eksternal','tgl_pelatihan','sampai','nik','nama','penyelenggara','instruktur','tempat_pelatihan','materi_pelatihan','poin_pelatihan','pendapat','status_pelatihan','lampiran_sertifikat','keterangan')
            ->where('nik','=',$nik)
            //->where('poin_pelatihan','=',null)->where('pendapat','=',null)->orwhere('status_pelatihan','=','Komen Atasan')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%')
                ->orwhere('nama','like','%'.$search.'%')
                ->orWhere('materi_pelatihan','like','%'.$search.'%');
            })         
            ->orderBy('penyelenggara', 'asc') 
            ->skip($start)
            ->take($length)
            ->get();
                //dd($Datas);
            $count = DB::table('tb_pelatihan_eksternal')->select('id_pelatihan_eksternal','tgl_pelatihan','sampai','nik','nama','penyelenggara','instruktur','tempat_pelatihan','materi_pelatihan','poin_pelatihan','pendapat','status_pelatihan','lampiran_sertifikat','keterangan')
            ->where('nik','=',$nik)
            //->where('poin_pelatihan','=',null)->where('pendapat','=',null)->orwhere('status_pelatihan','=','Komen Atasan')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%')
                ->orwhere('nama','like','%'.$search.'%')
                ->orWhere('materi_pelatihan','like','%'.$search.'%');
            })  
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        public function form_ule_update (Request $request){
            //dd($request->all());
            $findid = PelatihanEksternalModel::find($request->ule_idpelatihan);

            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->user_name;
            $idepe = Str::uuid();

            $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
            //dd($cekinput[0]->nama_departemen);

            $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section','nama_departemen')->where('nik','=',$findid->nik)->get();
            $tempo = DB::select("SELECT DATEADD(MONTH, 3, sampai) as date_tempo from tb_pelatihan_eksternal tpe WHERE id_pelatihan_eksternal = '$findid->id_pelatihan_eksternal' ");
            //dd($dept_trining[0]->nama_departemen);

            if($user->level_user == 'Admin' || $cekinput[0]->nama_departemen == $dept_trining[0]->nama_departemen){
                $findid->poin_pelatihan = $request->ule_poin;
                $findid->pendapat = $request->ule_pendapat;
                $findid->bentuk_pengayaan = $request->ule_bentuk_pengayaan;
                $findid->diaplikasikan_untuk = $request->ule_diaplikasikan_untuk;
                $findid->status_pelatihan = 'Komen Atasan';
                $findid->user_input = $inputor;
                $findid->tri_wulan = 'N';
                $findid->tempo_tri_wulan = $tempo[0]->date_tempo;

                $findid->save();

                $insert_epe = EvaluasiPelatihanEksternalModel::create([
                    'id_evaluasi_eksternal'=> $idepe,
                    'id_pelatihan_eksternal' => $request->ule_idpelatihan,
                    'kebutuhan' => $request->ule_kebutuhan,
                    'metode' => $request->ule_metode,
                    'pemahaman' => $request->ule_pemahaman,
                    'pengajar' => $request->ule_pengajar,
                    'kelebihan' => $request->ule_kelebihan,
                    'kekurangan' => $request->ule_kekurangan,
                    'saran' => $request->ule_saran,
                ]);

                $id_ale = Str::uuid();
                $approve_le = ApproveSkillmatrikModel::create([
                    'id_approve_skillmatrik'=> $id_ale,
                    'id_rencana_pelatihan'=>$request->ule_idpelatihan,
                    'dibuat'=>$findid->nama,
                    'keterangan'=> 'Eksternal',
                    'tgl_dibuat'=>date('Y-m-d'),
                ]);

                /*if ($request->hasFile('ule_sertifikat')) {
                    $this->validate($request,['gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
                    $file_name = $id.'.'.$request->file('ule_sertifikat')->getClientOriginalExtension();
                   $request->file('ule_sertifikat')->move(public_path("storage/img/pga/sertifikat/"),$file_name);
                   
                    //SSModel::where('id_ss',$id)
                    //      ->update(['foto_before'=>$file_name]);
                }*/

                return array(
                    'message' => 'Laporan Pelatihan Eksternal berhasil diUpdate .',
                    'success' => true,
                );
            } else {
                return array(
                    'message' => 'Laporan Gagal diUpdate, Access Denied .',
                    'success' => false,
                );
            }
        }

        public function komentar_atasan_lap_eksternal (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");

            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            //$inputor = $user->user_name;

            $cekuser = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
        
            $listdept= array();
            foreach ($cekuser as $key) {
                array_push($listdept,$key->nama_departemen);  
            }
            
            $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik')->whereIn('nama_departemen',$listdept)->get();
            
            $dept_1= array();
            foreach ($dept_trining as $key1) {
                array_push($dept_1,$key1->nik);  
            }

            //dd($nama);

            $Datas = DB::table('tb_pelatihan_eksternal')->select('id_pelatihan_eksternal','tgl_pelatihan','sampai','nik','nama','penyelenggara','instruktur','tempat_pelatihan','materi_pelatihan','poin_pelatihan','pendapat','status_pelatihan','bentuk_pengayaan','diaplikasikan_untuk')
            ->whereIn('nik',$dept_1)->where('status_pelatihan','=','Komen Atasan')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%')
                ->orwhere('nama','like','%'.$search.'%')
                ->orWhere('materi_pelatihan','like','%'.$search.'%');
            })         
            ->orderBy('tgl_pelatihan', 'desc') 
            ->skip($start)
            ->take($length)
            ->get();
                //dd($Datas);
            $count = DB::table('tb_pelatihan_eksternal')->select('id_pelatihan_eksternal','tgl_pelatihan','sampai','nik','nama','penyelenggara','instruktur','tempat_pelatihan','materi_pelatihan','poin_pelatihan','pendapat','status_pelatihan','bentuk_pengayaan','diaplikasikan_untuk')
            ->whereIn('nik',$dept_1)->where('status_pelatihan','=','Komen Atasan')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%')
                ->orwhere('nama','like','%'.$search.'%')
                ->orWhere('materi_pelatihan','like','%'.$search.'%');
            })  
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        public function inquery_lap_eksternal (Request $request){
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            //dd($nama);

            $Datas = DB::table('tb_pelatihan_eksternal')->select('id_pelatihan_eksternal','tgl_pelatihan','sampai','nik','nama','penyelenggara','instruktur','tempat_pelatihan','materi_pelatihan','poin_pelatihan','pendapat','status_pelatihan','bentuk_pengayaan','diaplikasikan_untuk','lampiran_sertifikat','tri_wulan','tempo_tri_wulan','keterangan')
            ->where('status_pelatihan','=','Close')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%')
                ->orwhere('nama','like','%'.$search.'%')
                ->orWhere('materi_pelatihan','like','%'.$search.'%');
            })         
            ->orderBy('nik', 'asc') 
            ->skip($start)
            ->take($length)
            ->get();
                //dd($Datas);
            $count = DB::table('tb_pelatihan_eksternal')->select('id_pelatihan_eksternal','tgl_pelatihan','sampai','nik','nama','penyelenggara','instruktur','tempat_pelatihan','materi_pelatihan','poin_pelatihan','pendapat','status_pelatihan','bentuk_pengayaan','diaplikasikan_untuk','lampiran_sertifikat','tri_wulan','tempo_tri_wulan','keterangan')
            ->where('status_pelatihan','=','Close')
            ->where(function($q) use ($search){
                $q->where('penyelenggara','like','%'.$search.'%')
                ->orwhere('nik','like','%'.$search.'%')
                ->orwhere('nama','like','%'.$search.'%')
                ->orWhere('materi_pelatihan','like','%'.$search.'%');
            })  
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
        }

        public function form_kale_update (Request $request){
            //dd($request->all());
            $findid = PelatihanEksternalModel::find($request->kale_idpelatihan);
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->user_name;
            
            $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
            $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik','=',$findid->nik)->get();
            //dd($dept_trining[0]->nama_departemen);
            $t = DB::table('tb_approve_skillmatrik')->select('id_approve_skillmatrik')->where('id_rencana_pelatihan','=',$findid->id_pelatihan_eksternal)->get();
            $req = ApproveSkillmatrikModel::find($t[0]->id_approve_skillmatrik);


            if($user->level_user == 'Admin' || $user->level_user == 'Manager' || $user->level_user == 'Assisten Manager' || $user->level_user == 'Supervisor'){
                if($user->level_user == 'Admin' || $cekinput[0]->nama_departemen == $dept_trining[0]->nama_departemen){
                    $findid->komentar_atasan = $request->kale_komentar_atasan;
                    $findid->status_pelatihan = 'Close';
    
                    $findid->save();

                    $req->disahkan = $inputor;
                    $req->tgl_disahkan = date('Y-m-d');
        
                    $req->save();

    
                    return array(
                        'message' => 'Komentar atasan berhasil diUpdate .',
                        'success' => true,
                    );
                } else {
                    return array(
                        'message' => 'Komen Gagal diUpdate !',
                        'success' => false,
                    );
                }
            } else {
                return array(
                    'message' => 'Access Denied !',
                    'success' => false,
                );
            }
        }

        public function upload_sertifikat (Request $request){
            //dd($request->all());
            $user = UserModel::find(Session::get('id'));
            $findid = PelatihanEksternalModel::find($request->us_idpelatihan);

            $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
            $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik','=',$findid->nik)->get();
        

            if ($user->level_user == 'Admin' || $cekinput[0]->nama_departemen == $dept_trining[0]->nama_departemen) {
            //$tindakan->tgl_selesai = $request['tgl_selesai'];
    
                if ($request->hasFile('file_us')) {
                    
                    $file_name = $findid->id_pelatihan_eksternal.'.'.$request->file('file_us')->getClientOriginalExtension();
                    $request->file('file_us')->move(public_path("storage/img/pga/sertifikat/"),$file_name);
                    
                    $findid->lampiran_sertifikat = $file_name;
                
                }
                
        
                $findid->save();
        
                return array(
                    'success' => true,
                    'message' => 'Upload sertifikat berhasil .',
                );
            } else {
                return array(
                    'success' => true,
                    'message' => 'Upload sertifikat gagal, Access denied .',
                );
            }
        }

        public function lembar_laporan_eksternal ($id){
            $req = PelatihanEksternalModel::find($id);
            $eval = DB::table('tb_evaluasi_eksternal')->where('id_pelatihan_eksternal','=',$id)->get();
            //dd($eval);
            //$isi = DB::table('tb_ojt')->select('isi_tujuan','instruktur','evaluasi','catatan')->where('id_rencana_pelatihan','=',$req->id_rencana_pelatihan)->get();
            
            $sign = DB::table('tb_approve_skillmatrik')->where('id_rencana_pelatihan','=',$id)->get();
            //$isi []=$isi1;
            //dd($sign[0]->dibuat);
            $printdate = date('Y-m-d H:i:s');
            $pdf = PDF::loadview('/pga/PDFpelatihaneksternal',['list'=>$req, 'eval'=>$eval, 'printdate'=>$printdate, 'sign'=>$sign])->setPaper('A4','potrait');
            return $pdf->stream('Lembar Laporan Pelatihan Eksternal.pdf');
        }

        public function form_estb_update (Request $request){
            //dd($request->all());
            $findid = PelatihanEksternalModel::find($request->estb_idpelatihan);
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->user_name;

            $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
            $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik','=',$findid->nik)->get();
            //dd($dept_trining[0]->nama_departemen);

            if($user->level_user == 'Admin' || $user->level_user == 'Manager' || $user->level_user == 'Assisten Manager' || $user->level_user == 'Supervisor'){
                if($user->level_user == 'Admin' || $cekinput[0]->nama_departemen == $dept_trining[0]->nama_departemen){

                    $id_3bulan = Str::uuid();
                    $insert_3bulan = EvaluasiEksternalTigaBulanModel::create([
                        'id_evaluasi_eksternal_3bulan'=> $id_3bulan,
                        'id_pelatihan_eksternal' => $request->estb_idpelatihan,
                        'ada_peningkatan' => $request->estb_ada_peningkatan,
                        'skill_sebelum' => $request->estb_skill_sebelum,
                        'skill_sesudah' => $request->estb_skill_sesudah,
                        'hasil_pelatihan' => $request->estb_hasil_pelatihan,
                        'usulan' => $request->estb_usulan,
                        'atasan' => $inputor,
                        'tgl_approve' => date('Y-m-d'),
                    ]);

                    $findid->tri_wulan = 'Y';
                    $findid->save();

                    return array(
                        'message' => 'Evaluasi setelah tiga bulan berhasil diUpdate .',
                        'success' => true,
                    );
                } else {
                    return array(
                        'message' => 'Evaluasi Gagal diUpdate !',
                        'success' => false,
                    );
                }
            } else {
                return array(
                    'message' => 'Access Denied !',
                    'success' => false,
                );
            }
        }

        public function lembar_laporan_eksternal_tiga_bulan ($id){
            $req = PelatihanEksternalModel::find($id);
            $eval = DB::table('tb_evaluasi_eksternal')->where('id_pelatihan_eksternal','=',$id)->get();
            $eval3bln = DB::table('tb_evaluasi_eksternal_3bulan')->where('id_pelatihan_eksternal','=',$id)->get();
            //dd($eval3bln);
            //$isi = DB::table('tb_ojt')->select('isi_tujuan','instruktur','evaluasi','catatan')->where('id_rencana_pelatihan','=',$req->id_rencana_pelatihan)->get();
            
            $printdate = date('Y-m-d H:i:s');
            $pdf = PDF::loadview('/pga/PDFevaluasi3bulan',['list'=>$req, 'eval'=>$eval, 'printdate'=>$printdate, 'eval3bln'=>$eval3bln])->setPaper('A4','potrait');
            return $pdf->stream('Lembar Evaluasi Pelatihan Eksternal.pdf');
        }

    public function inquery_ln_eksternal(Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $Datas = DB::table('tb_pelatihan_eksternal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.nik, a.nama, b.tanggal_masuk'))
        ->where(function($q) use ($search){
            $q->Where('a.nik','like','%'.$search.'%') 
            ->orwhere('a.nama','like','%'.$search.'%')
            ->orwhere('b.tanggal_masuk','like','%'.$search.'%');
        })     
            ->groupBy('a.nama','a.nik','b.tanggal_masuk')   
            ->orderBy('a.nik')     
            ->skip($start)
            ->take($length)
            ->get();
    
        $count = DB::table('tb_pelatihan_eksternal as a')->leftJoin('db_pgasystem.dbo.T_KARYAWAN as b','b.nik','=','a.NIK')->select(DB::raw('a.nik, a.nama, b.tanggal_masuk'))
        ->distinct('a.nik')
        ->where(function($q) use ($search){
            $q->Where('a.nik','like','%'.$search.'%') 
            ->orwhere('a.nama','like','%'.$search.'%')
            ->orwhere('b.tanggal_masuk','like','%'.$search.'%');
        })    
            ->orderBy('a.nik')           
            ->count();
    
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function listpkwt (){
        return view ('/pga/listpkwt');
    }

    public function inquery_pkwt_perpanjangan (Request $request){
        $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            $tglnow = date('Y-m-d');

            $tgl_habiskontrak_value = $request->input('tgl_habiskontrak');
            $tgl_habiskontrak = $request->input('tgl_habiskontrak').'-01';
            $tt = new Carbon($tgl_habiskontrak);
            $tahun = $tt->format('Y');
            $bulan = $tt->format('m');
            $t = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
            $tgl_habiskontrak1 = $request->input('tgl_habiskontrak').'-'.$t;
            //dd($tgl_habiskontrak);
        if($tgl_habiskontrak_value == null){
            $Datas = DB::select("SELECT r1.id_pkwt, r1.nik, r1.nama, r1.mulai_kontrak, r1.selesai_kontrak, r1.lama_kontrak, r1.kontrak_ke, r1.nilai_kehadiran, r1.nilai_pkwt, r2.keputusan from
            (SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_kehadiran, b1.nilai_pkwt FROM
                                (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                                LEFT JOIN 
                                (SELECT tb_pkwt.* from tb_pkwt,
                                (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                                where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 
                                on a1.nik = b1.nik where b1.nik is not null)r1
                                LEFT JOIN 
                                (select id_pkwt, keputusan from tb_penilaian_pkwt)r2
                                on r1.id_pkwt = r2.id_pkwt 
                    where (r1.nik like '%$search%' or r1.nama like '%$search%')
                    order by r1.nik asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
                 //dd($Datas[0]->selisih);
    
            $co = DB::select("SELECT r1.id_pkwt, r1.nik, r1.nama, r1.mulai_kontrak, r1.selesai_kontrak, r1.lama_kontrak, r1.kontrak_ke, r1.nilai_kehadiran, r1.nilai_pkwt, r2.keputusan from
            (SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_kehadiran, b1.nilai_pkwt FROM
                                (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                                LEFT JOIN 
                                (SELECT tb_pkwt.* from tb_pkwt,
                                (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                                where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 
                                on a1.nik = b1.nik where b1.nik is not null)r1
                                LEFT JOIN 
                                (select id_pkwt, keputusan from tb_penilaian_pkwt)r2
                                on r1.id_pkwt = r2.id_pkwt 
                    where (r1.nik like '%$search%' or r1.nama like '%$search%')");
            $count = count($co);
        } else {
            $Datas = DB::select("SELECT r1.id_pkwt, r1.nik, r1.nama, r1.mulai_kontrak, r1.selesai_kontrak, r1.lama_kontrak, r1.kontrak_ke, r1.nilai_kehadiran, r1.nilai_pkwt, r2.keputusan from
            (SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_kehadiran, b1.nilai_pkwt FROM
                    (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                    LEFT JOIN 
                    (SELECT tb_pkwt.* from tb_pkwt,
                    (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                    where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.selesai_kontrak >= '$tgl_habiskontrak' and b1.selesai_kontrak <= '$tgl_habiskontrak1')r1
                    LEFT JOIN 
                                (select id_pkwt, keputusan from tb_penilaian_pkwt)r2
                                on r1.id_pkwt = r2.id_pkwt 
                    where (r1.nik like '%$search%' or r1.nama like '%$search%')
                    order by r1.nik asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
                 //dd($Datas[0]->selisih);
    
            $co = DB::select("SELECT r1.id_pkwt, r1.nik, r1.nama, r1.mulai_kontrak, r1.selesai_kontrak, r1.lama_kontrak, r1.kontrak_ke, r1.nilai_kehadiran, r1.nilai_pkwt, r2.keputusan from
            (SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_kehadiran, b1.nilai_pkwt FROM
                  (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                  LEFT JOIN 
                  (SELECT tb_pkwt.* from tb_pkwt,
                  (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                  where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.selesai_kontrak >= '$tgl_habiskontrak' and b1.selesai_kontrak <= '$tgl_habiskontrak1')r1
                  LEFT JOIN 
                                (select id_pkwt, keputusan from tb_penilaian_pkwt)r2
                                on r1.id_pkwt = r2.id_pkwt 
                    where (r1.nik like '%$search%' or r1.nama like '%$search%')");
            $count = count($co);
        }


        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function inquery_pkwt_go (Request $request){
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
            //dd($nama);
        $env_database = DB::connection('sqlsrv')->getDatabaseName();

        $Datas = DB::connection('sqlsrv_pga')->table('t_karyawan as a')->leftJoin(\DB::raw($env_database.'.dbo.tb_pkwt as b'),'b.nik','=','a.NIK')->select('a.nik', 'a.nama', 'a.tanggal_masuk')
        ->where('b.nik','=', null)->where('a.status_karyawan','=','Kontrak')
        ->where(function($q) use ($search){
            $q->where('a.nik','like','%'.$search.'%')
            ->orwhere('a.nama','like','%'.$search.'%');
        })         
            ->orderBy('a.nik', 'asc') 
            ->skip($start)
            ->take($length)
            ->get();
                //dd($Datas);
        $count = DB::connection('sqlsrv_pga')->table('t_karyawan as a')->leftJoin(\DB::raw($env_database.'.dbo.tb_pkwt as b'),'b.nik','=','a.NIK')->select('a.nik', 'a.nama', 'a.tanggal_masuk')
        ->where('b.nik','=', null)->where('a.status_karyawan','=','Kontrak')
        ->where(function($q) use ($search){
            $q->where('a.nik','like','%'.$search.'%')
            ->orwhere('a.nama','like','%'.$search.'%');
            })  
        ->count();


        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function btn_up_check (Request $request){
        //dd($request->all());
        $kontrak = $request->input('up_kontrak');
        //dd($kontrak);
        if($kontrak <= 0){
            return array(
                'message' => 'Input Rencana waktu kontrak !',
                'success' => false,
            );
        } else if(is_numeric($kontrak)){
            $plus = DB::connection('sqlsrv_pga')->select("select dateadd(month,$kontrak,tanggal_masuk)as selesai from t_karyawan where nik=$request->up_nik");

            $tt = new Carbon(strtotime($plus[0]->selesai));
            $r = $tt->modify('-0 day');
            $a = $r->format('Y-m-d');

                return array(
                    'success' => true,
                    'message' => $a,
                );
        } else {
                return array(
                    'message' => 'Month Not Valid .',
                    'success' => false,
                );
        }
    }

    public function btn_pp_check (Request $request){
        //dd($request->all());
        $kontrak = $request->input('pp_kontrak');
        $kontrak_lama = $request->input('pp_kontrak_lama');
        $nik = $request->input('pp_nik');
        if($kontrak <= 0){
            return array(
                'message' => 'Input Rencana waktu kontrak !',
                'success' => false,
            );
        } else if(is_numeric($kontrak)){
            //$plus = DB::select("select dateadd(month,$kontrak,mulai_kontrak)as selesai from tb_pkwt where nik=$request->pp_nik");
            $baru = DB::select("SELECT tb_pkwt.* from tb_pkwt,
            (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt where nik = $nik group by nik, nama) t1
            where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke");
            //$baru = DB::select("select dateadd(day,1,selesai_kontrak)as mulai from tb_pkwt where nik=$nik1 ");
            $h1 = new Carbon($baru[0]->selesai_kontrak);
            $h2 = carbon::parse($h1)->addDays(1);
            $a = $h2->format('Y-m-d');

            $m = $h2->addMonth($kontrak); //Selesai kontrak tambah lama kontrak bulan

            $k = $m->addDays(-1); //hasil tambah bulan dikurangi 1 hari
            $b = $k->format('Y-m-d');

            /*$b1 = $h1->modify('-1 day');
            $b2 = $b1->modify($kontrak.'month');
            $b = $b2->format('Y-m-d');*/
            //dd($a, $b, $k1);

                return array(
                    'success' => true,
                    'selesai' => $b,
                    'mulai' => $a,
                    //'mulai' => $baru[0]->mulai,
                );
        } else {
                return array(
                    'message' => 'Month Not Valid .',
                    'success' => false,
                );
        }
    }

    public function form_pkwt_go (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        if($user->departemen == 'Admin' || $user->departemen == 'PGA'){
            $idpkwt = Str::uuid();
            $insert_pkwt_go = PKWTModel::create([
                'id_pkwt' => $idpkwt,
                'nik' => $request->up_nik,
                'nama' => $request->up_nama,
                'mulai_kontrak' => $request->up_mulai,
                'selesai_kontrak' => $request->up_selesai,
                'lama_kontrak' => $request->up_kontrak,
                'kontrak_ke' => '1',
                'status_pkwt' => 'PKWT',
            ]);
            return array (
                'message' => 'Update PKWT Berhasil !',
                'success' => true,
            );
        } else {
            return array (
                'message' => 'Access Denied !',
                'success' => false,
            );
        }
    }

    public function form_pkwt_perpanjangan (Request $request){
        //dd($request->all());
        //dd($request->pp_kontrak_ke + 1);
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        if($user->departemen == 'Admin' || $user->departemen == 'PGA'){
            $idpkwt = Str::uuid();
            $insert_pkwt_go = PKWTModel::create([
                'id_pkwt' => $idpkwt,
                'nik' => $request->pp_nik,
                'nama' => $request->pp_nama,
                'mulai_kontrak' => $request->pp_mulai,
                'selesai_kontrak' => $request->pp_selesai,
                'lama_kontrak' => $request->pp_kontrak,
                'kontrak_ke' => $request->pp_kontrak_ke + 1,
                'status_pkwt' => 'PKWT',
            ]);
            return array (
                'message' => 'Update PKWT Berhasil !',
                'success' => true,
            );
        } else {
            return array (
                'message' => 'Access Denied !',
                'success' => false,
            );
        }
    }

    public function inquery_nlp (Request $request){
        //dd($request->all());
        $nlp_nik = $request->input('nlp_nik');

        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $Datas = DB::table('tb_pkwt')->select('nik','nama','mulai_kontrak','selesai_kontrak','lama_kontrak','kontrak_ke')->where('nik','=',$nlp_nik)
        ->where(function($q) use ($search){
            $q->Where('nik','like','%'.$search.'%') 
            ->orwhere('nama','like','%'.$search.'%');
        })       
            ->orderBy('kontrak_ke','asc')     
            ->skip($start)
            ->take($length)
            ->get();
    
        $count = DB::table('tb_pkwt')->select('nik','nama','mulai_kontrak','selesai_kontrak','lama_kontrak','kontrak_ke')->where('nik','=',$nlp_nik)
        ->where(function($q) use ($search){
            $q->Where('nik','like','%'.$search.'%') 
            ->orwhere('nama','like','%'.$search.'%');
        })    
            ->orderBy('kontrak_ke','asc')           
            ->count();
    
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function excel_pkwt (Request $request){
        //dd($request->all());
        $tgl_habiskontrak = $request->input('tgl_habiskontrak').'-01';
        $tt = new Carbon($tgl_habiskontrak);
        $tahun = $tt->format('Y');
        $bulan = $tt->format('m');
        $t = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
        $tgl_habiskontrak1 = $request->input('tgl_habiskontrak').'-'.$t;
        $tgl_now = date('Y-m-d');
        //dd($tgl_habiskontrak1);

        $Datas = DB::select("SELECT b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke FROM
        (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
        LEFT JOIN 
        (SELECT tb_pkwt.* from tb_pkwt,
        (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
        where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.selesai_kontrak >= '$tgl_habiskontrak' and b1.selesai_kontrak <= '$tgl_habiskontrak1'
        order by b1.nik");
        //dd(count($Datas));


        if (count($Datas) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1','No');
            $sheet->setCellValue('B1','NIK');
            $sheet->setCellValue('C1','NAMA');
            $sheet->setCellValue('D1','Mulai Kontrak');
            $sheet->setCellValue('E1','Selesai Kontrak');
            $sheet->setCellValue('F1','Lama Kontrak');
            $sheet->setCellValue('G1','Kontrak Ke');
            $sheet->setCellValue('H1','TTD');
            $sheet->setCellValue('I1','Tanggal');
    
            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A'.$line,$no++);
                $sheet->setCellValue('B'.$line,$data->nik);
                $sheet->setCellValue('C'.$line,$data->nama);
                $sheet->setCellValue('D'.$line,$data->mulai_kontrak);
                $sheet->setCellValue('E'.$line,$data->selesai_kontrak);
                $sheet->setCellValue('F'.$line,$data->lama_kontrak);
                $sheet->setCellValue('G'.$line,$data->kontrak_ke);
                
                $line++;
            }
    
            $writer = new Xlsx($spreadsheet);
            $filename = "List_PKWT_".date('Ymd His').".xlsx";
            $writer->save(public_path("storage/excel/".$filename));
            return ["file"=>url("/")."/storage/excel/".$filename];
        } else {
            return ["message"=>"No Data .", "success"=>false];
        }
    }

    public function list_penilaian_pkwt (){
        return view ('/pga/penilaian_pkwt');
    }

    public function inquery_penilaian_pkwt (Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            $tglnow = date('Y-m-d');


            $tgl_habiskontrak_value = $request->input('tgl_habiskontrak');
            $tgl_habiskontrak = $request->input('tgl_habiskontrak').'-01';
            $tt = new Carbon($tgl_habiskontrak);
            $tahun = $tt->format('Y');
            $bulan = $tt->format('m');
            $t = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
            $tgl_habiskontrak1 = $request->input('tgl_habiskontrak').'-'.$t;
            //dd($tgl_habiskontrak);

            $cekuser = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section')->where('nik',$user->nik)->get();
        
            $listdept= array();
            foreach ($cekuser as $key) {
                array_push($listdept,$key->dept_section);  
            }
            
            $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik')->whereIn('dept_section',$listdept)->where('status_karyawan','=','Kontrak')->get();
            
            $dept_1= array();
            foreach ($dept_trining as $key1) {
                array_push($dept_1,$key1->nik);  
            }

            $nik_dept = join(',',$dept_1);
            //dd($t);
        if($tgl_habiskontrak_value == null){
            $Datas = DB::select("SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_pkwt FROM
                    (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                    LEFT JOIN 
                    (SELECT tb_pkwt.* from tb_pkwt,
                    (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                    where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.nik in ($nik_dept) and b1.nilai_kehadiran = 'Y'
                    and (b1.nik like '%$search%' or b1.nama like '%$search%')
                    order by b1.nik asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
                 //dd($Datas[0]->selisih);
    
            $co = DB::select("SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_pkwt FROM
                  (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                  LEFT JOIN 
                  (SELECT tb_pkwt.* from tb_pkwt,
                  (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                  where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.nik in ($nik_dept) and b1.nilai_kehadiran = 'Y'
                  and (b1.nik like '%$search%' or b1.nama like '%$search%')");
            $count = count($co);
        } else {
            $Datas = DB::select("SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_pkwt FROM
                    (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                    LEFT JOIN 
                    (SELECT tb_pkwt.* from tb_pkwt,
                    (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                    where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.selesai_kontrak >= '$tgl_habiskontrak' and b1.selesai_kontrak <= '$tgl_habiskontrak1' and b1.nik in ($nik_dept) and b1.nilai_kehadiran = 'Y'
                    and (b1.nik like '%$search%' or b1.nama like '%$search%')
                    order by b1.nik asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
                 //dd($Datas[0]->selisih);
    
            $co = DB::select("SELECT b1.id_pkwt, b1.nik, b1.nama, b1.mulai_kontrak, b1.selesai_kontrak,b1.lama_kontrak, b1.kontrak_ke, b1.nilai_pkwt FROM
                  (select nik from db_pgasystem.dbo.T_KARYAWAN where status_karyawan ='Kontrak')a1
                  LEFT JOIN 
                  (SELECT tb_pkwt.* from tb_pkwt,
                  (SELECT nik,nama, max(kontrak_ke)as kontrak_ke  from tb_pkwt group by nik, nama) t1
                  where tb_pkwt.nik = t1.nik and tb_pkwt.kontrak_ke = t1.kontrak_ke)b1 on a1.nik = b1.nik where b1.nik is not null and b1.selesai_kontrak >= '$tgl_habiskontrak' and b1.selesai_kontrak <= '$tgl_habiskontrak1' and b1.nik in ($nik_dept) and b1.nilai_kehadiran = 'Y'
                  and (b1.nik like '%$search%' or b1.nama like '%$search%')");
            $count = count($co);
        }


        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function form_ukp (Request $request){
        //dd($request->all());
        $findid = PKWTModel::find($request->ukp_idpkwt);

            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->departemen;
            $tgl_now = date('Y-m-d');

            $dept_pkwt = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section')->where('nik','=',$request->ukp_nik)->get();
            //$cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
            //$dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik','=',$findid->nik)->get();
            //dd($dept_trining[0]->nama_departemen);
            
            if($user->level_user == 'Admin' || $user->departemen == 'PGA'){
                $id_penilaian = Str::uuid();
                $insert_penilaian = PenilaianPKWTModel::create([
                    'id_penilaian_pkwt'=> $id_penilaian,
                    'id_pkwt' => $request->ukp_idpkwt,
                    'nik' => $request->ukp_nik,
                    'nama' => $request->ukp_nama,
                    'dept_section' => $dept_pkwt[0]->dept_section,
                    'absensi' => $request->ukp_absensi,
                    'imp' => $request->ukp_imp,
                    'tgl_nilai_kehadiran' => $tgl_now,
                ]);

                $findid->nilai_kehadiran = 'Y';
                $findid->save();

                    return array(
                        'message' => 'Nilai Absensi berhasil diUpdate .',
                        'success' => true,
                    );
            } else {
                return array(
                    'message' => 'Access Denied !',
                    'success' => false,
                );
            }
    }

    public function btn_upp_ambil (Request $request){
        //dd($request->upp_selesai);
        $mulai = $request->input('upp_mulai');
        $selesai = $request->input('upp_selesai');
        $a_absen = DB::table('tb_penilaian_pkwt')->select('absensi','imp')->where('id_pkwt',$request->upp_idpkwt)->get();
        //dd((int)$a_absen[0]->absensi);
        $ss = DB::select("SELECT t1.nik,  count(t2.jml)as jml from
        (SELECT nik from tb_pkwt )t1
        LEFT JOIN 
        (select nik, COUNT(nik)as jml, tgl_penyerahan  from tb_ss group by nik, tgl_penyerahan )t2 on t1.nik = t2.nik WHERE t1.nik = '$request->upp_nik' and t2.tgl_penyerahan >= '$mulai' and t2.tgl_penyerahan <= '$selesai'
        GROUP BY t1.nik");

        $ky = DB::select("SELECT t1.nik,  count(t2.jml)as jml from
        (SELECT nik from tb_pkwt )t1
        LEFT JOIN 
        (select nik, COUNT(nik)as jml, tgl_lapor  from tb_hhky group by nik, tgl_lapor )t2 on t1.nik = t2.nik WHERE t1.nik = '$request->upp_nik' and t2.tgl_lapor >= '$mulai' and t2.tgl_lapor <= '$selesai'
        GROUP BY t1.nik");
        //dd(count($ky[0]->jml));

        if(empty($ss[0]->jml)){
            $point_ss = 1;
            $jml_ss = 0;
        } else if($ss[0]->jml >= 4){
            $point_ss = 5;
            $jml_ss = $ss[0]->jml;
        } else if ($ss[0]->jml >= 3){
            $point_ss = 4;
            $jml_ss = $ss[0]->jml;
        } else if ($ss[0]->jml >= 2){
            $point_ss = 3;
            $jml_ss = $ss[0]->jml;
        } else if ($ss[0]->jml >= 1){
            $point_ss = 2;
            $jml_ss = $ss[0]->jml;
        }

        if(empty($ky[0]->jml)){
            $point_ky = 1;
            $jml_ky = 0;
        } else if($ky[0]->jml >= 4){
            $point_ky = 5;
            $jml_ky = $ky[0]->jml;
        } else if ($ky[0]->jml >= 3){
            $point_ky = 4;
            $jml_ky = $ky[0]->jml;
        } else if ($ky[0]->jml >= 2){
            $point_ky = 3;
            $jml_ky = $ky[0]->jml;
        } else if ($ky[0]->jml >= 1){
            $point_ky = 2;
            $jml_ky = $ky[0]->jml;
        }
        //dd($jml_ky);
        return array(
            'success' => true,
            'absen' =>  (int)$a_absen[0]->absensi,
            'imp' => (int)$a_absen[0]->imp,
            'point_ss' => $point_ss,
            'ss' => $jml_ss,
            'point_ky' => $point_ky,
            'ky' => $jml_ky,
        );
    }

    public function form_upp (Request $request){
        //dd($request->all());
        $findid_pkwt = PKWTModel::find($request->upp_idpkwt);
        $findid_penilaian_pkwt = $request->upp_idpkwt;
        //dd($findid_penilaian_pkwt);
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $inputor = $user->departemen;
            $tgl_now = date('Y-m-d');

            $dept_pkwt = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section')->where('nik','=',$request->upp_nik)->get();
            //dd($dept_pkwt[0]->dept_section);
            //$cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
            //$dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik','=',$findid->nik)->get();
            //dd($dept_trining[0]->nama_departemen);
            
            if($user->level_user == 'Admin' || $inputor == $dept_pkwt[0]->dept_section){
                $update_upp = DB::table('tb_penilaian_pkwt')->where('id_pkwt',$findid_penilaian_pkwt)->update([
                'tgl_nilai' => $tgl_now,
                'penilai' => $user->user_name,
                'inisiatif' => $request->upp_inisiatif,
                'kerjasama' => $request->upp_kerjasama,
                'ss' => $request->upp_point_ss,
                'ky' => $request->upp_point_ky,
                'kuantitas' => $request->upp_kuantitas,
                'kualitas' => $request->upp_kualitas,
                'ketaatan' => $request->upp_ketaatan,
                'perilaku' => $request->upp_perilaku,
                'motivasi' => $request->upp_motivasi,
                'total_nilai' => $request->upp_total_point,
                'keputusan' => $request->upp_keputusan,
                'catatan_tambahan' => $request->upp_catatan_tambahan,
            ]);

                $findid_pkwt->nilai_pkwt = 'Y';
                $findid_pkwt->save();

                    return array(
                        'message' => 'Penilaian berhasil diUpdate .',
                        'success' => true,
                    );
            } else {
                return array(
                    'message' => 'Access Denied !',
                    'success' => false,
                );
            }
    }

    public function get_penilaian_view (Request $request){
        //dd($request->all());
        $v_nilai = DB::table('tb_penilaian_pkwt')->where('id_pkwt',$request->id_pkwt)->get();
        //dd($v_nilai[0]->keputusan);
        return array(
            'success' => true,
            'ini' =>  (int)$v_nilai[0]->inisiatif,
            'ker' => (int)$v_nilai[0]->kerjasama,
            'ss' => (int)$v_nilai[0]->SS,
            'ky' => (int)$v_nilai[0]->KY,
            'kuan' => (int)$v_nilai[0]->kuantitas,
            'kual' => (int)$v_nilai[0]->kualitas,
            'abs' => (int)$v_nilai[0]->absensi,
            'imp' => (int)$v_nilai[0]->imp,
            'ket' => (int)$v_nilai[0]->ketaatan,
            'per' => (int)$v_nilai[0]->perilaku,
            'mot' => (int)$v_nilai[0]->motivasi,
            'tot_nil' => (int)$v_nilai[0]->total_nilai,
            'kep' => $v_nilai[0]->keputusan,
            'cat_tam' => $v_nilai[0]->catatan_tambahan,
            'penilai' => $v_nilai[0]->penilai,
            'tgl_nilai' => $v_nilai[0]->tgl_nilai,
        );
    }

    public function inquery_all_skillmatrik (Request $request){

        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $Datas = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select(DB::raw('nik, nama, tanggal_masuk, dept_section, nama_jabatan'))
        ->where('status_karyawan','!=','Off')
        ->where('dept_section','!=','Admin')
        ->where('nik','!=','11111')
        ->where(function($q) use ($search){
            $q->Where('nik','like','%'.$search.'%') 
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('nama_jabatan','like','%'.$search.'%')
            ->orwhere('dept_section','like','%'.$search.'%')
            ->orwhere('tanggal_masuk','like','%'.$search.'%');
        })     
        //->groupBy('nama','nik','dept_section','tanggal_masuk', 'nama_jabatan')   
        ->orderBy('nik')     
        ->skip($start)
        ->take($length)
        ->get();

        $count = DB::connection('sqlsrv_pga')->table('T_KARYAWAN')->select(DB::raw('nik, nama, tanggal_masuk, dept_section, nama_jabatan'))
        ->where('status_karyawan','!=','Off')
        ->where('dept_section','!=','Admin')
        ->where('nik','!=','11111')
        ->distinct('nik')
       ->where(function($q) use ($search){
            $q->Where('nik','like','%'.$search.'%') 
            ->orwhere('nama','like','%'.$search.'%')
            ->orwhere('nama_jabatan','like','%'.$search.'%')
            ->orwhere('dept_section','like','%'.$search.'%')
            ->orwhere('tanggal_masuk','like','%'.$search.'%');
        })             
        ->count();

            return  [
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $Datas
            ];
    }




}
