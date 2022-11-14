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
use App\MasalahModel;
use App\LogModel;
use App\TindakanModel;


class MasalahController extends Controller
{
    public function formmasalah(){
        //$nomer = DB::connection('sqlsrv')->select('exec nomor_temuan ?,?', array($request['tgl']));
        return view ('produksi.formmasalah');
    }

    public function get_nomer (Request $request){
        $nomer = DB::connection('sqlsrv')->select('exec nomer_temuan ?', array($request['tgl']));
        return $nomer;
    }

    public function inputmasalah (Request $request){
      
        $id = Str::uuid();
        $id_user = Session::get('id');
        $insert = MasalahModel::create([
            'id_masalah'=>$id,
            'tanggal_ditemukan'=>$request['tanggal_ditemukan'],
            'informer'=>$id_user,
            'no_kartu'=>$request['no_kartu'],
            'klasifikasi'=>$request['klasifikasi'],
            'lokasi'=>$request['lokasi'],
            'masalah'=>$request['masalah'],
            'penyebab'=>$request['penyebab'],
            'lampiran'=>$request['lampiran'],
            'status_masalah'=>"Open"
        ]);
     
        if ($insert) {
            if ($request->hasFile('lampiran')) {
                $this->validate($request,['gambar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
                $file_name = $request->no_kartu.'.'.$request->file('lampiran')->getClientOriginalExtension();
               $request->file('lampiran')->move(public_path("storage/img/masalah/"),$file_name);
               
                MasalahModel::where('id_masalah',$id)
                      ->update(['lampiran'=>$file_name]);
              
            }
            Session::flash('success','Tambah Data berhasil !'); 
        }else {
          Session::flash('alert-danger','Tambah Data gagal !'); 
        }

        return redirect()->route('req_masalah');
    }

    public function inquerymasalah (Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $awal = $request->input("tgl_awal");
        $akhir = $request->input("tgl_akhir");
        /*
        $Datas = DB::table('tb_masalah')->join('tb_user','tb_user.id','=','tb_masalah.informer')
        ->select('tb_masalah.*','tb_user.user_name')
        ->where('tb_masalah.tanggal_ditemukan','>=',$awal)
        ->where('tb_masalah.tanggal_ditemukan','<=',$akhir)
        ->where(function($q) use ($search) {
            $q->where('tb_masalah.klasifikasi','like','%'.$search.'%')
            ->orwhere('tb_masalah.lokasi','like','%'.$search.'%')
            ->orwhere('tb_masalah.status_masalah','like','%'.$search.'%');
        })
        ->orderBy('no_kartu', 'asc')
        ->skip($start)->take($length)->get();

        $count = DB::table('tb_masalah')->join('tb_user','tb_user.id','=','tb_masalah.informer')
        ->select('tb_masalah.*','tb_user.user_name')
        ->where('tb_masalah.tanggal_ditemukan','>=',$awal)
        ->where('tb_masalah.tanggal_ditemukan','<=',$akhir)
        ->where(function($q) use ($search) {
            $q->where('tb_masalah.klasifikasi','like','%'.$search.'%')
            ->orwhere('tb_masalah.lokasi','like','%'.$search.'%')
            ->orwhere('tb_masalah.status_masalah','like','%'.$search.'%');
        })
        ->count();
        */

        $Datas = DB::select("select masalah.*, usere.user_name, ISNULL((100.0 * (CAST(ISNULL((tind2.clos),0) AS FLOAT) / CAST(tind1.tot AS FLOAT))),0) as progress from (
            select * from tb_masalah where tanggal_ditemukan >= '$awal' and tanggal_ditemukan <= '$akhir' and masalah LIKE '%$search%'
           )masalah
           left join
           (select id, user_name from tb_user ) usere on masalah.informer = usere.id
           left join
           (select count(id_tindakan) as tot, id_masalah from tb_tindakan group by id_masalah) tind1 on masalah.id_masalah = tind1.id_masalah
           left join
           (select count(id_tindakan) as clos, id_masalah from tb_tindakan where status_tindakan = 'close' group by id_masalah) tind2 on masalah.id_masalah = tind2.id_masalah order by masalah.no_kartu asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

        

        $count = DB::select("select count(*) as total from (
            select * from tb_masalah where tanggal_ditemukan >= '$awal' and tanggal_ditemukan <= '$akhir' and masalah LIKE '%$search%'
           )masalah
           left join
           (select id, user_name from tb_user ) usere on masalah.informer = usere.id
           left join
           (select count(id_tindakan) as tot, id_masalah from tb_tindakan group by id_masalah) tind1 on masalah.id_masalah = tind1.id_masalah
           left join
           (select count(id_tindakan) as clos, id_masalah from tb_tindakan where status_tindakan = 'close' group by id_masalah) tind2 on masalah.id_masalah = tind2.id_masalah")[0]->total;

        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }

    public function del_masalah(Request $request){
        //$token = $request->header('token_req');
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        //$id = Session::get('id');
        $req = MasalahModel::find($request['id']);

        
        if ($dept == "Admin") {
            $tindakan = TindakanModel::where('id_masalah','=',$req->id_masalah)->get();
            
            foreach ($tindakan as $p) {
              
               $file = $p->file_lampiran;
               if (!empty($file)) {
                $dir = public_path()."/storage/file/tindakan/";
                $path = $dir.$file;
                //fclose($path);
                unlink($path);
             }
            }
        
            $req->delete();
            
               
          $status = true;
          $mess = "Delete berhasil";
            //Session::flash('alert-success','Hapus Request berhasil !'); 
        }else if ($user->id == $req->informer) {
            $tindakan = TindakanModel::where('id_masalah','=',$req->id_masalah)->get();
            
            foreach ($tindakan as $p) {
              
               $file = $p->file_lampiran;
               if (!empty($file)) {
                $dir = public_path()."/storage/file/tindakan/";
                $path = $dir.$file;
                //fclose($path);
                unlink($path);
             }
            }
        
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
            'id_req' => $request['id'],
            'no_req' => $req->no_kartu,
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

    public function update_masalah(Request $request){
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dept = $user->departemen;
        
        $req = MasalahModel::find($request['id_masalah']);
        $details =[
            'id_masalah'=>$request['id_masalah'],
        ];
       
        if ($dept == "Admin" || $user->id == $req->informer) {

              
                $req->penyebab = $request['edit_penyebab'];
                $req->lokasi = $request['edit_lokasi'];
                $req->masalah = $request['edit_masalah'];

            if ($req->isDirty('penyebab')) {
                $details['penyebab'] = $request['edit_penyebab'];
            }
            if ($req->isDirty('lokasi')) {
                $details['lokasi']=$request['edit_lokasi'];
            }

            if ($req->isDirty('masalah')) {
               $details['masalah'] = $request['edit_masalah'];
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
/*
    public function complete_masalah(Request $request){
       
        $user = UserModel::find(Session::get('id'));
        $dept = $user->departemen;
        //$id = $request->input('id');
        $req = MasalahModel::find($request['edit_id']);
       
       $details = "id_masalah : ".$request["edit_id"];

        if ($dept == "Admin" || $user->id == $req->informer) {

               $req->status_masalah = $request['edit_status'];
                $req->penyebab = $request['edit-penyebab'];
                if ($req->isDirty('penyebab')) {
                    $details = $details.", penyebab: ".$request['edit-penyebab'];
                }
                if ($req->isDirty('status_masalah')) {
                    $details = $details.", status: ".$request['edit_status'];
                }

                $req->save();
        
                $status = true;
                $mess = "Data Sudah Complete";

        }else {
            $status = false;
            $mess = "Update gagal, Cek kolom penyebab harus sudah terisi.";
          
        }

        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"update",
            'message' => $details,
        ];
        LogModel::create($data);
        return array(
            'message' => $mess,
            'success'=>$status
        );
    }
*/

    public function masalahxlsx(Request $request){
        
       
        $awal = $request->input("tanggal_awal");
        $akhir = $request->input("tanggal_akhir");
        /*
        $Datas = DB::table('tb_masalah')->join('tb_user','tb_user.id','=','tb_masalah.informer')
        ->select('tb_masalah.*','tb_user.user_name')
        ->where('tb_masalah.tanggal_ditemukan','>=',$awal)
        ->where('tb_masalah.tanggal_ditemukan','<=',$akhir)
        ->get();
        */
        $Datas = DB::select("select masalah.*, usere.user_name, ISNULL((100.0 * (CAST(ISNULL((tind2.clos),0) AS FLOAT) / CAST(tind1.tot AS FLOAT))),0) as progress from (
            select * from tb_masalah where tanggal_ditemukan >= '$awal' and tanggal_ditemukan <= '$akhir'
           )masalah
           left join
           (select id, user_name from tb_user ) usere on masalah.informer = usere.id
           left join
           (select count(id_tindakan) as tot, id_masalah from tb_tindakan group by id_masalah) tind1 on masalah.id_masalah = tind1.id_masalah
           left join
           (select count(id_tindakan) as clos, id_masalah from tb_tindakan where status_tindakan = 'close' group by id_masalah) tind2 on masalah.id_masalah = tind2.id_masalah order by masalah.no_kartu asc");

        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','Tanggal Ditemukan');
        $sheet->setCellValue('C1','No. Kartu');
        $sheet->setCellValue('D1','Informer');
        $sheet->setCellValue('E1','Klasifikasi');
        $sheet->setCellValue('F1','Lokasi');
        $sheet->setCellValue('G1','Masalah');
        $sheet->setCellValue('H1','Penyebab');
        $sheet->setCellValue('I1','Status');
        $sheet->setCellValue('J1','Progress');
        $sheet->setCellValue('K1','Created At');
        $sheet->setCellValue('L1','Updatetd At');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->tanggal_ditemukan);
            $sheet->setCellValue('C'.$line,$data->no_kartu);
            $sheet->setCellValue('D'.$line,$data->user_name);
            $sheet->setCellValue('E'.$line,$data->klasifikasi);
            $sheet->setCellValue('F'.$line,$data->lokasi);
            $sheet->setCellValue('G'.$line,$data->masalah);
            $sheet->setCellValue('H'.$line,$data->penyebab);
            $sheet->setCellValue('I'.$line,$data->status_masalah);
            $sheet->setCellValue('J'.$line,$data->progress);
            $sheet->setCellValue('K'.$line,$data->created_at);
            $sheet->setCellValue('L'.$line,$data->updated_at);
           
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "masalah_".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
       
    }

   public function grafik(Request $request){
        $tgl1 = $request->input("tgl_awal");
        $tgl2 = $request->input("tgl_akhir");

        //$masalah = DB::connection('sqlsrv')->select("select klasifikasi, COUNT(klasifikasi) as jumlah from tb_masalah where tanggal_ditemukan >= '$tgl1' and tanggal_ditemukan <= '$tgl2' group by klasifikasi order by klasifikasi asc");
        $masalah = DB::connection('sqlsrv')->select("select kelas.klasifikasi, kelas.jumlah, selesai.closed from (select klasifikasi, COUNT(klasifikasi) as jumlah from tb_masalah where tanggal_ditemukan >= '$tgl1' and tanggal_ditemukan <= '$tgl2' group by klasifikasi) as kelas left join (select klasifikasi, COUNT(klasifikasi) as closed from tb_masalah where status_masalah = 'Close' and tanggal_ditemukan >= '$tgl1' and tanggal_ditemukan <= '$tgl2' group by klasifikasi) as selesai on kelas.klasifikasi = selesai.klasifikasi order by kelas.klasifikasi asc");
        return $masalah;
   }

   public function addtindakan(Request $request){
       
       $user = UserModel::find(Session::get('id'));
        $masalah = MasalahModel::find($request['id_masalah']);

        if ($user->id == $masalah->informer) {
           $id_tindakan = Str::uuid();
            $tindakan = TindakanModel::create([
                'id_tindakan'=>$id_tindakan,
                'id_masalah'=>$request['id_masalah'],
                'id_user'=>$user->id,
                'isi_tindakan'=>$request['isi_tindakan'],
                'tgl_deadline'=>$request['tgl_deadline'],
                'pic_tindakan'=>$request['pic'],
                'status_tindakan'=>'Open',
    
            ]);
            if ($tindakan) {
              $masalah->status_masalah = 'Open';
              $masalah->save();
            }

            $details = [
                'id_tindakan' => $id_tindakan,
                'id_masalah' =>$masalah->id_masalah,
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
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $tindakan = TindakanModel::find($id);

    if ($user->id == $tindakan->id_user) {
       
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
   public function deltindakan(Request $request){
    $token = apache_request_headers();
    $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
    $tindakan = TindakanModel::find($request['id']);
    $masalah = MasalahModel::find($tindakan->id_masalah);

    if ($user->id == $tindakan->id_user) {
        $file = $tindakan->file_lampiran;
        
        $tindakan->delete();
            if (!empty($file)) {
                $dir = public_path()."/storage/file/tindakan/";
                $path = $dir.$file;
                //fclose($path);
                unlink($path);
            }
        $setatus = $this->cekstatus($masalah->id_masalah);
        
        $masalah->status_masalah = $setatus['status'];
        $masalah->save();

        $details = [
            'id_tindakan' => $request['id'],
            'id_masalah' =>$masalah->id_masalah,
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

   function cekstatus($id_masalah){
        $total = TindakanModel::where('id_masalah','=',$id_masalah)->count();
        $status = 'Open';
        $persen = 0;
        $close = 0;
        if ($total > 0) {
           $close = TindakanModel::where('id_masalah','=',$id_masalah)->where('status_tindakan','=','Close')->count();
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

   public function updtindakan(Request $request){
       $tgl = date('Y-M-d');
       //dd($tgl);
       $user = UserModel::find(Session::get('id'));
       $tindakan = TindakanModel::find($request['id_tindakan']);
       $masalah = MasalahModel::find($tindakan->id_masalah);
       $id_m = $tindakan->id_masalah;
        $details =[
            'id_tindakan'=>$request['id_tindakan'],
        ];
      
      
        $stat = false;
        $mess = 'Update data gagal !';
       if ($user->id == $tindakan->id_user) {
          $tindakan->isi_tindakan = $request['edit_tindakan'];
          $tindakan->tgl_deadline = $request['edit_deadline'];
          $tindakan->pic_tindakan = $request['edit_pic'];
          $tindakan->status_tindakan = $request['status_tind'];
        //$tindakan->tgl_selesai = $request['tgl_selesai'];
          if($tindakan->isDirty('isi_tindakan')){
              $details['isi_tindakan'] = $request['edit_tindakan'];
          }
          if($tindakan->isDirty('tgl_deadline')){
             $details['tgl_deadline']= $request['edit_deadline'];
          }
          if($tindakan->isDirty('pic_tindakan')){
              $details['pic_tindakan']= $request['edit_pic'];
          }
          if($tindakan->isDirty('status_tindakan')){
              $details['status_tindakan']=  $request['status_tind'];
              
          }

          if ($request['status_tind'] == 'Close') {
           if ($request['tgl_selesai'] == null) {
             $tindakan->tgl_selesai = now();
           }else{

               $tindakan->tgl_selesai = $request['tgl_selesai'];
           }
        }else{
          $tindakan->tgl_selesai = null;
        }

        if ($request->hasFile('lampiran')) {
           
            $file_name = $tindakan->id_tindakan.'.'.$request->file('lampiran')->getClientOriginalExtension();
           $request->file('lampiran')->move(public_path("storage/file/tindakan/"),$file_name);
           
            $tindakan->file_lampiran = $file_name;
          
        }
        

          $tindakan->save();
          $setatus = $this->cekstatus($id_m);

          $masalah->status_masalah = $setatus['status'];

          if ($masalah->isDirty('status_masalah')) {
              $masalah->save();
              $details['id_masalah']= $id_m;
              $details['status_masalah']= $setatus['status'];
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
}
