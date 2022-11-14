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
use App\SSModel;
use App\SSNilaiModel;
use PDF;

class ISOController extends Controller
{
    public function importexcel_ss(Request $request){
        if ($request->hasFile('import_file_ss')) {
            $path = $request->file('import_file_ss')->getRealPath();
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $Data = $reader->load($path);
            $sheetdata = $Data->getActiveSheet()->toArray(null, true, true, true);
             unset($sheetdata[1]);
           
            $gagal = 0;
            $list = array ();
            foreach ($sheetdata as $row) {
            $cek = SSModel::where('no_ss','=',$row['A'])->count();
                //dd($row['B']);
                
                if ($cek > 0){
                    $gagal =  $gagal + 1;
                    array_push($list,$row['A']);
                }else{
                    SSModel::create([
                    'id_ss'=>Str::uuid(),
                    'no_ss'=>$row['A'],
                    'status_ss'=>$row['B'],
                    'tgl_penyerahan'=>$row['C'],
                    'nama'=>$row['D'],
                    'nik'=>$row['E'],
                    'departemen'=>$row['F'],
                    'bagian'=>$row['G'],
                    'tema_ss'=>$row['H'],
                    'masalah'=>$row['I'],
                    'ide_ss'=>$row['J'],
                    'tujuan_ss'=>$row['K'],
                    'kategori'=>$row['L'],
                    'aprove1'=>$row['M'],
                    'aprove2'=>$row['N'],
                    'foto_before'=>$row['O'],
                    'foto_after'=>$row['P'],
                    'keterangan'=>$row['O'],
                    ]);
                }
            }

            if ($gagal > 0){
               $pesan = implode(",",$list);
                Session::flash('alert-danger','Error No SS sudah ada : '.$pesan);     
            }else{

                Session::flash('alert-success','Import data berhasil'); 
            }
            return redirect()->route('tools');
         }
    }

    public function ss (){
        $nomerinduk = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nik','nama','dept_group','dept_section')->get();
        //dd($nomerinduk->nama);
        return view ('iso/ssentry',['nomerinduk'=>$nomerinduk]);
    }

    public function sslist (){
        return view ('iso/sslist');
    }

    public function sspoint (){
        return view ('iso/sspoint');
    }

    public function entryss (Request $request){
        //$test = SSModel::where('no_ss','=','SS/20/L/001')->get();
        //dd($test);
        $id = Str::uuid();
        $nik = $request->input("nonik");
        $dept1 = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_group','dept_section')->where('nik','=',$nik)->first();
        //dd($dept1->dept_section);
        $insert = SSModel::create([
            'id_ss'=>$id,
            'no_ss'=>$request->no_ss,
            'status_ss'=>'Masuk',
            'tgl_penyerahan'=>$request->tgl_penyerahan,
            'nama'=>$request->nama,
            'nik'=>$request->nonik,
            'departemen'=>$dept1->dept_group,
            'bagian'=>$dept1->dept_section,
            'tema_ss'=>$request->tema_ss,
            'masalah'=>$request->masalah,
            'ide_ss'=>$request->ide_ss,
            'tujuan_ss'=>$request->tujuan_ss,
            'kategori'=>$request->kategori,
            'aprove1'=>$request->aprove1,
            'aprove2'=>$request->aprove2,
            'foto_before'=>$request->foto_before,
            'foto_after'=>$request->foto_after,
            'keterangan'=>$request->keterangan,
        ]);
    
         if ($insert) {
            if ($request->hasFile('foto_before')) {
                $this->validate($request,['gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
                $file_name = $id.'.'.$request->file('foto_before')->getClientOriginalExtension();
               $request->file('foto_before')->move(public_path("storage/img/ss/before/"),$file_name);
               
                SSModel::where('id_ss',$id)
                      ->update(['foto_before'=>$file_name]);
            }
                Session::flash('alert-success','Tambah Data berhasil !'); 
            }else {
              Session::flash('alert-danger','Tambah Data gagal !'); 
            }
            return redirect()->route('form_ss'); 

    }
    
    public function get_nomer (Request $request){
        $nomer = DB::connection('sqlsrv')->select('exec nomer_ss ?', array($request['tgl']));
        return $nomer;
    }


    public function ssinquery(Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $status_ss1 = $request->input("status_ss");
        //dd($status_ss);
        $datass = DB::table('tb_ss')->get();
        $listdatass= array();

        if ($status_ss1 == "All") {
            foreach ($datass as $key) {
                array_push($listdatass,$key->status_ss);
            }
            }else {
            foreach ($datass as $key) {
                array_push($listdatass, $status_ss1);
            }
        } 

        if ($status_ss1 == "ET1" || $status_ss1 == "ET2"){
            $fil ='asc';
        } else {
            $fil = 'desc' ;
        }
       
        $Datas = DB::table('tb_ss')->whereIn('status_ss',$listdatass)     
        ->where(function($q) use ($search) {
            $q->where('nama','like','%'.$search.'%')
            ->orWhere('no_ss','like','%'.$search.'%')
              ->orWhere('nik','like','%'.$search.'%')
              ->orwhere('tema_ss','like','%'.$search.'%');
        })
        ->orderBy('no_ss',$fil)    
        ->skip($start)
        ->take($length)
        ->get();


        $count = DB::table('tb_ss')->whereIn('status_ss',$listdatass)
        ->where(function($q) use ($search) {
            $q->where('nama','like','%'.$search.'%')
            ->orWhere('no_ss','like','%'.$search.'%')
              ->orWhere('nik','like','%'.$search.'%')
              ->orwhere('tema_ss','like','%'.$search.'%');
            })
            ->orderBy('no_ss',$fil)
        ->count();
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function approve_point_ss(Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $id = $request->input('id_ss');

        $Datas = DB::table('tb_ss_nilai')->select('nik','penilai','poin','keterangan')->where('id_ss',$id)->get();
        $cou = DB::table('tb_ss_nilai')->select(DB::raw('count(nik)as cou'), DB::raw('sum(poin)as poin'))->where('id_ss',$id)->get();
        $poinreward = DB::select("select t1.poin, t1.coun, (t1.poin / t1.coun)as avg from (select sum (poin) as poin, count(penilai)as coun from tb_ss_nilai where id_ss='$id')t1");
        $p = $poinreward[0]->avg;

        $re=DB::table('tb_reward')->select('reward')->where('point','=',$p)->first();
        if(empty($re)){
            $re = (object) ['reward' => 0];
         }

        //$count = DB::table('tb_ss_nilai')->select('id_ss','nik','penilai','poin','keterangan')->where('id_ss',$id)->count();
        //dd($test);
       /* return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];*/

        return array('Datas'=>$Datas, "cou"=>$cou, "rew"=>$re);
    }

    public function ssnilai(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $unik = $user->nik;
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        //dd($status_ss);

        $Datas = DB::select("SELECT * FROM (
            select t1.id_ss, t1.no_ss as no_ss, t1.nik, t1.nama, t1.tema_ss, isnull((t2.poin),0) as poin from
                    (select id_ss, no_ss, status_ss, nik, nama, tema_ss from tb_ss where status_ss = 'ET2' and poin_ss is null)t1
                    left join
                    (select id_ss, poin from tb_ss_nilai where nik = '$unik')t2 on t1.id_ss = t2.id_ss)l WHERE poin = 0 order by no_ss asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");
        //dd($Datas);
        //order by t1.no_ss desc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY
       

        $count = DB::select("SELECT count(*) as total FROM (
            select t1.id_ss, t1.no_ss as no_ss, t1.nik, t1.nama, t1.tema_ss, isnull((t2.poin),0) as poin from
                    (select id_ss, no_ss, status_ss, nik, nama, tema_ss from tb_ss where status_ss = 'ET2' and poin_ss is null)t1
                    left join
                    (select id_ss, poin from tb_ss_nilai where nik = '$unik')t2 on t1.id_ss = t2.id_ss)a WHERE poin = 0")[0]->total;
        
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

  /*  public function editss (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            //DD($dept);
            $id = $request->input('id');
            $req = SSModel::find($id);
           //dd($req->departemen);
            if ($dept == "Admin" || $dept == 'SEKRETARIAT ISO' ) {
                //if ($dept == "Admin" || $dept == $req->departemen ) {
            $req->tema_ss = $request['tema'];
            $req->masalah = $request['masalah'];
            $req->ide_ss = $request['ide'];
            $req->tujuan_ss = $request['tujuan'];
            $req->status_ss = $request['status'];
            $req->keterangan = $request['keterangan'];
            $req->save();
    
              $status = true;
              $mess = "Update data berhasil";
            }else {
                $mess = "Update gagal, Edit SS";
                $status = false;
            }
    
            $details = [
                'id_ss' => $id,
                'tema_ss'=>$request['tema'],
                'masalah' => $request['masalah'],
                'ide_ss' => $request['ide'],
                'tujuan_ss' => $request['tujuan'],
                'status_ss' => $request['status'],
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
    } */

    public function editpoin (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $id = $request->input('id');
            $req = SSModel::find($id);
            $now = date('Y-m-d');

            
            $poinreward = DB::select("select t1.poin, t1.coun, (t1.poin / t1.coun)as avg from (select sum (poin) as poin, count(penilai)as coun from tb_ss_nilai where id_ss='$id')t1");
            $p = $poinreward[0]->avg;
    
            $r = 0;
            $re=DB::table('tb_reward')->select('reward')->where('point','=',$p)->first();
            if(empty($re)){
                $r = 0;
            } else {
                $r = $r + $re->reward;
            }

           
            if ($dept == "Admin" || $dept == "SEKRETARIAT ISO" ) {
                if ($r == 0 ){
                    $mess = "Update gagal, Reward tidak boleh Null";
                    $status = false;
                } else {
                    $req->poin_ss = $p;
                    $req->reward = $r;
                    $req->status_ss = 'Selesai';
                    $req->tgl_approve_poin = $now;
                $req->save();
        
                  $status = true;
                  $mess = "Update Poin berhasil";
                }
            }
    
            $details = [
                'id_ss' => $id,
                'poin_ss'=>$request['poin'],
                'reward' => $request['reward'],
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

    public function insentifpdf (Request $request){
        //dd($request->all());
        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $status_ss1 = $request->input("status_ss");
        $document_ss = $request->input("document_ss");

        $printdate = date('d-m-Y H:i:s');

        
        $insentif = DB::table('tb_ss')->get();
        
        $listinsentif= array();
        
        if ($status_ss1 == "All") {
            foreach ($insentif as $key) {
                array_push($listinsentif,$key->status_ss);
            }
        }else {
            foreach ($insentif as $key) {
                array_push($listinsentif, $status_ss1);
            }
        } 
        
        $peng = DB::table('tb_ss')->where('tgl_penyerahan','>=',$tgl_awal)->where('tgl_penyerahan','<=',$tgl_akhir)->whereIn('status_ss',$listinsentif)->orderBy('departemen','asc')->orderBy('no_ss','asc')->get();
        $insentif1 = DB::table('tb_ss')->where('tgl_penyerahan','>=',$tgl_awal)->where('tgl_penyerahan','<=',$tgl_akhir)->whereIn('status_ss',$listinsentif)->orderBy('no_ss','asc')->get();
        $karyawan = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama','nik','nama_jabatan','dept_section')->where('status_karyawan','<>','Off')->where('nama_jabatan','not like','%Manager')->get();
        
        $jumlahss = DB::select(DB::raw("select t1.NIK, t1. NAMA, t1.nama_jabatan, t7.seq_jabatan, t1.dept_section, t2.jmlh as Masuk, t3.jmlh as Pengerjaan, t4.jmlh as Ditolak, t5.jmlh as Tunda, t6.jmlh as Selesai, t8.jmlh as ET2, t9.jmlh as ET1 from
        (select nik, NAMA, nama_jabatan, dept_section from db_pgasystem.dbo.T_KARYAWAN where STATUS_KARYAWAN <> 'Off' and nama_jabatan <> 'Manager' and nama_jabatan <> 'Admin') t1
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'Masuk' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t2 on t1.NIK = t2.nik
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'Pengerjaan' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t3 on t1.NIK = t3.nik
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'Ditolak' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t4 on t1.NIK = t4.nik
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'Tunda' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t5 on t1.NIK = t5.nik
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'Selesai' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t6 on t1.NIK = t6.nik
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'ET2' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t8 on t1.NIK = t8.nik
        left join
        (select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'ET1' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss) t9 on t1.NIK = t9.nik
        left join
        (select seq_jabatan, nama_jabatan from db_pgasystem.dbo.t_jabatan) t7 on t1.nama_jabatan = t7.nama_jabatan order by t7.seq_jabatan DESC, t1.nik ASC"));

        //$jumlahss1 = DB::select("select nik, COUNT(status_ss) as jmlh, status_ss from tb_ss where status_ss = 'ET2' and tgl_penyerahan >= '$tgl_awal' and tgl_penyerahan <= '$tgl_akhir' group by nik, status_ss");
        //dd($jumlahss);
        
        //$jumlahss = DB::table( \DB::raw('db_pgasystem.dbo.t_karyawan as t1'))
        //->join(\DB::raw('db_produksi.dbo.tb_ss as t2'), 't1.nik', '=', 't2.nik')
        //->select('t1.nik', 't2.nama')->where('t1.status_karyawan','=','Off')->get();

        //$te[]=$insentif1;
        //return view ('/iso/insentifpdf',['insentif1'=>$insentif1]);
        if($document_ss == 'Insentif'){
            $pdf = PDF::loadview('/iso/insentifpdf',['insentif1'=>$insentif1, 'printdate'=>$printdate])->setPaper('A4','potrait');
            return $pdf->stream('List Insentif.pdf');
        } elseif ($document_ss == 'TandaTerimaInsentif') {
            $pdf1 = PDF::loadview('/iso/ttvoucerinsentif',['insentif1'=>$insentif1, 'printdate'=>$printdate])->setPaper('A4','potrait');
            return $pdf1->stream('List Voucher Insentif.pdf');
        } elseif ($document_ss == 'SSSelesai') {
            $pdf1 = PDF::loadview('/iso/ET2',['insentif1'=>$insentif1, 'printdate'=>$printdate])->setPaper('A4','potrait');
            return $pdf1->stream('SS Selesai Dikerjakan.pdf');
        } elseif ($document_ss == 'SSMasuk') {
            $pdf1 = PDF::loadview('/iso/ssmasukpdf',['jumlahss'=>$jumlahss,'tgl_awal'=>$tgl_awal, 'tgl_akhir'=>$tgl_akhir, 'printdate'=>$printdate])->setPaper('A4','potrait');
            return $pdf1->stream('SS Masuk.pdf');
        } elseif ($document_ss == 'Pengerjaan') {
            $pdf1 = PDF::loadview('/iso/pengerjaanpdf',['peng'=>$peng,'printdate'=>$printdate])->setPaper('A4','potrait');
            return $pdf1->stream('SS Tahap Pengerjaan.pdf');
        }
    }


    // =====================================================================================================================================

    public function ssgrafik (){
        return view ('iso/ssgrafik');
    }

    public function grafikpie(Request $request){
        $tgl1 = $request->input("tgl1");
        $tgl2 = $request->input('tgl2');

        //$totjam = DB::table('tb_ss')->select(DB::raw('departemen as departemen'),
        //DB::raw('count(*) as count'))->groupBy('departemen')->get();
        $dept = DB::select("select departemen as departemen, count (*) as count, count(distinct nik)as count_nik from tb_ss where tgl_penyerahan >='$tgl1' and tgl_penyerahan <= '$tgl2' group by departemen");
        //dd($dept);
        //$level = DB::select("select status_ss, count(*) as count from tb_ss where tgl_penyerahan >='$tgl1' and tgl_penyerahan <= '$tgl2' group by status_ss");
  
        //$totsslevel = DB::select("select count(*) as total from tb_ss where tgl_penyerahan >= '$tgl1' and tgl_penyerahan <= '$tgl2'");

        //return [$totssdept, $totsslevel];
        return $dept;
    }

    public function grafikbar(Request $request){
        $tgl1 = $request->input("tgl1");
        $tgl2 = $request->input('tgl2');

        //$totjam = DB::table('tb_ss')->select(DB::raw('departemen as departemen'),
        //DB::raw('count(*) as count'))->groupBy('departemen')->get();
        $level = DB::select("select status_ss, count(*) as count from tb_ss where tgl_penyerahan >='$tgl1' and tgl_penyerahan <= '$tgl2' group by status_ss");

        /*
        $masuk = 0;
        $tunda = 0;
        $ditolak = 0;
        $pengerjaan = 0;
        $selesai = 0;

        foreach ($level as $lev){
            if($lev->status_ss == 'Masuk'){
                $s = $lev->count + $masuk;
            } elseif ($lev->status_ss == 'Tunda'){
                $s = $lev->count + $tunda;
            } elseif ($lev->status_ss == 'Ditolak'){
                $s = $lev->count + $ditolak;
            } elseif ($lev->status_ss == 'Selesai'){
                $s = $lev->count + $selesai;
            } else {
                $s = $lev->count;
            }
            $hasil = array ('status_ss'=>$lev->status_ss, 'count'=>$s);
            $final[]=$hasil;
        }
*/
        return $level;
    }

    public function ssdetail ($id){
        $detail = SSModel::find($id);
        //dd($detail->no_ss);
        return view ('iso/ssdetail',['detail'=>$detail]);
    }

    public function ssdetailpoint ($id){
        $detail = SSModel::find($id);
        //dd($detail->no_ss);
        return view ('iso/ssdetailpoint',['detail'=>$detail]);
    }

    public function update_ss(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        
        $req = SSModel::find($request['id_ss']);
        $details =[
            'id_ss'=>$request['id_ss'],
        ];
       
        if ($dept == "Admin" || $dept == 'SEKRETARIAT ISO') {
                $req->tema_ss = $request['edit_tema_ss'];
                $req->masalah = $request['edit_masalah'];
                $req->ide_ss = $request['edit_ide_ss'];
                $req->tujuan_ss = $request['edit_tujuan_ss'];
                $req->status_ss = $request['edit_status_ss'];

            if ($req->isDirty('tema_ss')) {
                $details['tema_ss'] = $request['edit_tema_ss'];
            }
            if ($req->isDirty('masalah')) {
                $details['masalah']=$request['edit_masalah'];
            }

            if ($req->isDirty('ide_ss')) {
               $details['ide_ss'] = $request['edit_ide_ss'];
            }
            if ($req->isDirty('tujuan_ss')) {
                $details['tujuan_ss'] = $request['edit_tujuan_ss'];
             }
             if ($req->isDirty('status_ss')) {
                $details['status_ss'] = $request['edit_status_ss'];
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

    public function addfoto(Request $request){
        //dd($request->all());
        $user = UserModel::find(Session::get('id'));
        $ss = SSModel::find($request['id_ss']);
        
        //dd($tindakan);
       
       
         $stat = false;
         $mess = 'Update data gagal !';
        if ($user->departemen == 'Admin' || $user->departemen == 'SEKRETARIAT ISO') {
         //$tindakan->tgl_selesai = $request['tgl_selesai'];
 
 
         if ($request->hasFile('foto_after')) {
            
             $file_name = $ss->id_ss.'.'.$request->file('foto_after')->getClientOriginalExtension();
            $request->file('foto_after')->move(public_path("storage/img/ss/after/"),$file_name);
            
             $ss->foto_after = $file_name;
           
             $ss->save();
         }
         
 
 
           $stat = true;
           $mess = 'Update data berhasil !';
 
           $data = [
             'record_no' => Str::uuid(),
             'user_id' => $user->id,
             'activity' =>"update",
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

    public function addfotobefore(Request $request){
        //dd($request->all());
        $user = UserModel::find(Session::get('id'));
        $ss = SSModel::find($request['id_ss']);
        
        //dd($user->departemen);
       
       
         $stat = false;
         $mess = 'Update data gagal !';
        if ($user->departemen == 'Admin' || $user->departemen == 'SEKRETARIAT ISO') {
         //$tindakan->tgl_selesai = $request['tgl_selesai'];
 
 
         if ($request->hasFile('foto_before')) {
            
             $file_name = $ss->id_ss.'.'.$request->file('foto_before')->getClientOriginalExtension();
            $request->file('foto_before')->move(public_path("storage/img/ss/before/"),$file_name);
            
             $ss->foto_before = $file_name;
           
             $ss->save();
         }
         
 
 
           $stat = true;
           $mess = 'Update data berhasil !';
 
           $data = [
             'record_no' => Str::uuid(),
             'user_id' => $user->id,
             'activity' =>"update",
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

    public function del_ss(Request $request){
        //$token = $request->header('token_req');
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        //$id = Session::get('id');
        $req = SSModel::find($request['id']);
    
        
        if ($dept == "Admin" || $dept == 'SEKRETARIAT ISO') {
            $ss = SSModel::where('id_ss','=',$req->id_ss)->get();
            
            foreach ($ss as $p) {
              
               $file = $p->foto_before;
               if (!empty($file)) {
                $dir = public_path()."/storage/img/ss/before/";
                $path = $dir.$file;
                //fclose($path);
                unlink($path);
             }
             $file1 = $p->foto_after;
             if (!empty($file1)) {
              $dir1 = public_path()."/storage/img/ss/after/";
              $path1 = $dir1.$file1;
              //fclose($path);
              unlink($path1);
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

    public function ssET1 (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $id = $request->input('iddata');
            $rb3 = $request->input('rb3');
            $req = SSModel::find($id);
            //dd($rb3);
           
            if ($dept == "Admin" || $dept == "SEKRETARIAT ISO" ) {
                if($rb3 == 'Pengerjaan'){
                    $req->status_ss = $rb3;
                    $req->save();
        
                  $status = true;
                  $mess = "Updata status from ET 1";
                } else{
                    $req->status_ss = $rb3;
                    $req->keterangan = $request->input('edit_tolaktunda');
                    $req->save();
        
                  $status = true;
                  $mess = "Updata status from ET 1";
                }
                
            }
    
            $details = [
                'id_ss' => $id,
                'status_ss'=>$request['rb3'],
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

    public function addpoint(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $user_name = $user->user_name;
        $nikpenilai = $user->nik;
        $id_ss = $request->input('id_ss');
        $no_masalah = $request->input('no_masalah');
        $req = SSModel::find($id_ss);
        $id = Str::uuid();

        $cek = DB::table('tb_penilai')->select('nik','nama')->where('kategori','=','SS')->where('status','=','Aktif')->where('nik',$nikpenilai)->count();

        if ($cek < 1){
            $status = false;
            $mess = "User tidak dapat access untuk tambah Point SS !";
            } else {
                $insert = SSNilaiModel::create([
                    'id_ss_nilai'=>$id,
                    'id_ss'=>$id_ss,
                    'no_ss'=>$no_masalah,
                    'nik'=>$nikpenilai,
                    'penilai'=>$user_name,
                    'poin'=>$request->input('e_poin'),
                    'keterangan'=>$request->input('e_keterangan'),
                ]);
    
                if ($insert) {
                    $status = true;
                    $mess = "Updata point Success .";
                }
        }

        return array(
            'message' => $mess,
            'success'=>$status
        );
    }

    public function get_isoexcel (Request $request){
        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $status_ss2 = $request->input("status_ss2");
        //dd($status_ss2);

        $insentif = DB::table('tb_ss')->select('status_ss')->get();
        
        $listinsentif= array();
        
        if ($status_ss2 == "All") {
            foreach ($insentif as $key) {
                array_push($listinsentif,$key->status_ss);
            }
        }else {
            foreach ($insentif as $key) {
                array_push($listinsentif, $status_ss2);
            }
        } 
        
        $Datas = DB::table('tb_ss')->select('no_ss','tgl_penyerahan','nama','nik','departemen','kategori','tema_ss','masalah','ide_ss','poin_ss','reward','tgl_approve_poin')
        ->where('tgl_penyerahan','>=',$tgl_awal)->where('tgl_penyerahan','<=',$tgl_akhir)->whereIn('status_ss',$listinsentif)->get();

        if (count($Datas) > 0) {
       
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1','No');
            $sheet->setCellValue('B1','No SS');
            $sheet->setCellValue('C1','Tanggal');
            $sheet->setCellValue('D1','Nama');
            $sheet->setCellValue('E1','Nik');
            $sheet->setCellValue('F1','Departemen');
            $sheet->setCellValue('G1','Kategori');
            $sheet->setCellValue('H1','Tema SS');
            $sheet->setCellValue('I1','Masalah');
            $sheet->setCellValue('J1','Ide SS');
            $sheet->setCellValue('K1','Poin SS');
            $sheet->setCellValue('L1','Reward');
            $sheet->setCellValue('M1','Tgl Approve');
            
            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A'.$line,$no++);
                $sheet->setCellValue('B'.$line,$data->no_ss);
                $sheet->setCellValue('C'.$line,$data->tgl_penyerahan);
                $sheet->setCellValue('D'.$line,$data->nama);
                $sheet->setCellValue('E'.$line,$data->nik);
                $sheet->setCellValue('F'.$line,$data->departemen);
                $sheet->setCellValue('G'.$line,$data->kategori);
                $sheet->setCellValue('H'.$line,$data->tema_ss);
                $sheet->setCellValue('I'.$line,$data->masalah);
                $sheet->setCellValue('J'.$line,$data->ide_ss);
                $sheet->setCellValue('K'.$line,$data->poin_ss);
                $sheet->setCellValue('L'.$line,$data->reward);
                $sheet->setCellValue('M'.$line,$data->tgl_approve_poin);

            
                $line++;
            }
            
            $writer = new Xlsx($spreadsheet);
            $filename = "ISO_".$status_ss2."_".date('YmdHis').".xlsx";
            $writer->save(public_path("storage/excel/".$filename));
            return ["file"=>url("/")."/storage/excel/".$filename,
            "message"=>"Berhasil Export Data .",
                    "success"=>true];
            
                } else {
                    return ["message"=>"No Data", "success"=>false];
                }
    }
}