<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\UserModel;
use App\LogModel;
use App\DocumentModel;
use App\UploadDocumentModel;

class DocumentController extends Controller
{
    public function inquery_document (){
        return view ('/document/inquerydocument');
    }

    public function add_document (Request $request){
        //dd($request->all());

        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $cek_doc_number = DocumentModel::select('doc_number')->where('doc_number','=',$request->ad_document_number)->count();
  
        if ($cek_doc_number >= 1){
            return array (
                'message' => 'Update Failed, Document Number already exist .',
                'success' => false,
            );
        } else {
            $iddocument = Str::uuid();
            $insert_document = DocumentModel::create([
                'id_manag_document' => $iddocument,
                'doc_number' => $request->ad_document_number,
                'doc_type' => $request->ad_type,
                'doc_name' => $request->ad_document_name,
                'doc_location' => $request->ad_document_location,
                'created_date' => $request->ad_document_created,
                'effective_date' => $request->ad_effective_date,
                'expired_date' => $request->ad_expired_date,
                'notif_date' => $request->ad_notif_date,
                'owner' => $user->departemen,
                'category' => $request->ad_category,
                'remark' => $request->ad_remark,
                'doc_status' => 'Running',
            ]);
        }

            if ($insert_document){
                $request->validate([
                    'filename' => 'required',
                    'filename.*' => 'mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:10000'
                ]);
                if ($request->hasfile('filename')) { 
                    $files = [];
                    foreach ($request->file('filename') as $file) {
                        if ($file->isValid()) {
                            $idlampiran = Str::uuid();
                            //$filename = round(microtime(true) * 100).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $filename = round(date('Ymdhis')).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('storage/document'), $filename);                    
                            $files[] = [
                                'id_lampiran_dokumen' => $idlampiran,
                                'id_manag_dokumen' => $iddocument,
                                'filename' => $filename,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                    }
                    UploadDocumentModel::insert($files);         
                    return array (
                        'message' => 'Update Success !',
                        'success' => true,
                    );
                }else{
                    echo'Upload lampiran Gagal';
                }
            } else {
                return array (
                    'message' => 'Update Failed !',
                    'success' => false,
                );
            }

        
    }

    public function list_document (Request $request){
        //dd($request->all());
            $draw = $request->input("draw");
            $search = $request->input("search")['value'];
            $start = (int) $request->input("start");
            $length = (int) $request->input("length");
            $doc_status1 = $request->input('doc_status');
            $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

            $data_doc = DB::table('tb_manag_document')->select('doc_status')->groupBy('doc_status')->get();
            //dd($data_doc);
            $listdatadoc= array();

            if ($doc_status1 == "All") {
                foreach ($data_doc as $key) {
                    array_push($listdatadoc,$key->doc_status);
                }
                }else {
                array_push($listdatadoc, $doc_status1);
            } 

            $cekinput = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('nama_departemen')->where('nik',$user->nik)->get();
        
        $listdept= array();
        
        foreach ($cekinput as $key) {
            array_push($listdept,$key->nama_departemen);  
        }
        
        $dept_trining = DB::connection('sqlsrv_pga')->table('t_karyawan')->select('dept_section')->whereIn('nama_departemen',$listdept)->get();
        $dept_1= array();
        
        foreach ($dept_trining as $key1) {
            array_push($dept_1,$key1->dept_section);  
        }


            $Datas = DB::table('tb_manag_document as a')->leftJoin('tb_lampiran_dokumen as b','b.id_manag_dokumen','=','a.id_manag_document')->select(DB::raw('a.id_manag_document, a.doc_type, a.doc_number, a.doc_name, a.doc_location, a.created_date, a.effective_date, a.expired_date, a.notif_date, a.doc_status, count(b.id_manag_dokumen)as count_manag, a.remark, a.category, a.owner'))
            ->whereIn('a.doc_status',$listdatadoc)->whereIn('a.owner',$dept_1)
            ->where(function($q) use ($search){
                $q->where('a.doc_number','like','%'.$search.'%')
                ->orwhere('a.doc_name','like','%'.$search.'%')
                ->orwhere('a.doc_location','like','%'.$search.'%');
            })    
            ->groupBy('a.id_manag_document', 'a.doc_type', 'a.doc_number', 'a.doc_name', 'a.doc_location', 'a.created_date', 'a.effective_date', 'a.expired_date', 'a.notif_date', 'a.doc_status', 'a.remark', 'a.category', 'a.owner')     
            ->orderBy('a.notif_date', 'asc', 'a.expired_date', 'asc') 
            ->skip($start)
            ->take($length)
            ->get();
                //dd($Datas);
            $count = DB::table('tb_manag_document as a')->leftJoin('tb_lampiran_dokumen as b','b.id_manag_dokumen','=','a.id_manag_document')->select(DB::raw('a.id_manag_document, a.doc_type, a.doc_number, a.doc_name, a.doc_location, a.created_date, a.effective_date, a.expired_date, a.notif_date, a.doc_status, count(b.id_manag_dokumen)as count_manag, a.remark, a.category, a.owner'))
            ->whereIn('a.doc_status',$listdatadoc)->whereIn('a.owner',$dept_1)
            ->distinct('a.id_manag_document')
            ->where(function($q) use ($search){
                $q->where('a.doc_number','like','%'.$search.'%')
                ->orwhere('a.doc_name','like','%'.$search.'%')
                ->orwhere('a.doc_location','like','%'.$search.'%');
            })    
            ->count();


                return  [
                    "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $Datas
                ];
    }

    public function lampiran_open (Request $request){
        //dd($request->all());
        $id_manag_document = $request->input('id_manag_document');

        $Datas = "select id_lampiran_dokumen, filename from tb_lampiran_dokumen where id_manag_dokumen = '$id_manag_document'";
        $hasil = DB::select($Datas);
        return array ('hasil'=>$hasil);
    }

    public function del_attachment (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dibuat = $user->user_name;
        $id_lampiran = $request->input('id_lampiran_dokumen');

        $filename = UploadDocumentModel::select('filename', 'id_manag_dokumen')->where('id_lampiran_dokumen',$id_lampiran)->get();
        $del = UploadDocumentModel::where('id_lampiran_dokumen',$id_lampiran)->delete();

        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"Deleted",
            'message' => " filename ".$filename[0]->filename. " || id_document-> ".$filename[0]->id_manag_dokumen,
        ];
        LogModel::create($data);

        return array(
            'message' => 'Delete attachment Success .',
            'success'=> true,
        );
    }

    public function add_attachment (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dibuat = $user->user_name;
        $id_lampiran = $request->input('aa_id');

        $request->validate([
            'filename' => 'required',
            'filename.*' => 'mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:10000'
        ]);
        if ($request->hasfile('filename')) { 
            $files = [];
            foreach ($request->file('filename') as $file) {
                if ($file->isValid()) {
                    $idlampiran = Str::uuid();
                    //$filename = round(microtime(true) * 100).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $filename = round(date('Ymdhis')).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('storage/document'), $filename);                    
                    $files[] = [
                        'id_lampiran_dokumen' => $idlampiran,
                        'id_manag_dokumen' => $id_lampiran,
                        'filename' => $filename,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            $add_attactment = UploadDocumentModel::insert($files);  

            return array (
                'message' => 'Add Attachment Success !',
                'success' => true,
            );

            if($add_attactment){
                $filename_log = UploadDocumentModel::select('filename', 'id_manag_dokumen')->where('id_lampiran_dokumen',$id_lampiran)->get();
                $data = [
                    'record_no' => Str::uuid(),
                    'user_id' => $user->id,
                    'activity' =>"Add Attachment",
                    'message' => " filename ".$filename_log[0]->filename. " || id_document-> ".$filename_log[0]->id_manag_dokumen,
                ];
                LogModel::create($data);
            }

        }else{
            return array (
                'message' => 'Add Attachment Failed .',
                'success' => false,
            );
        }

    }

    public function edit_document (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
        $dibuat = $user->user_name;
        $ed_id = $request->input('ed_id');
        $req = DocumentModel::find($ed_id);

        $req->category = $request['ed_category'];
        $req->doc_type = $request['ed_type'];
        $req->doc_number = $request['ed_document_number'];
        $req->doc_name = $request['ed_document_name'];
        $req->doc_location = $request['ed_document_location'];
        $req->created_date = $request['ed_document_created'];
        $req->effective_date = $request['ed_effective_date'];
        $req->expired_date = $request['ed_expired_date'];
        $req->notif_date = $request['ed_notif_date'];
        $req->remark = $request['ed_remark'];

        $req->save();

        $document_log = DocumentModel::select('doc_number', 'id_manag_document')->where('id_manag_document',$ed_id)->get();
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"Edit Document",
            'message' => " Doc Number ".$document_log[0]->doc_number. " || id_document-> ".$document_log[0]->id_manag_document,
        ];
        LogModel::create($data);

            return array (
                'message' => 'Edit Document Success !',
                'success' => true,
            );

    }

    public function upd_document (Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $cek_doc_number = DocumentModel::select('doc_number')->where('doc_number','=',$request->ud_document_number)->count();
  
        if ($cek_doc_number >= 1){
            return array (
                'message' => 'Update Failed, Document Number already exist .',
                'success' => false,
            );
        } else {
            $ud_id = Str::uuid();
            $insert_document = DocumentModel::create([
                'id_manag_document' => $ud_id,
                'doc_number' => $request->ud_document_number,
                'doc_type' => $request->ud_type,
                'doc_name' => $request->ud_document_name,
                'doc_location' => $request->ud_document_location,
                'created_date' => $request->ud_document_created,
                'effective_date' => $request->ud_effective_date,
                'expired_date' => $request->ud_expired_date,
                'notif_date' => $request->ud_notif_date,
                'owner' => $user->departemen,
                'category' => $request->ud_category,
                'remark' => $request->ud_remark,
                'doc_status' => 'Running',
            ]);
        }

            if ($insert_document){

                $ud_id = $request->input('ud_id');
                $req = DocumentModel::find($ud_id);
        
                $req->doc_status = 'Expired';
                $req->save();

                $request->validate([
                    'filename' => 'required',
                    'filename.*' => 'mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:10000'
                ]);
                if ($request->hasfile('filename')) { 
                    $files = [];
                    foreach ($request->file('filename') as $file) {
                        if ($file->isValid()) {
                            $idlampiran = Str::uuid();
                            //$filename = round(microtime(true) * 100).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $filename = round(date('Ymdhis')).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('storage/document'), $filename);                    
                            $files[] = [
                                'id_lampiran_dokumen' => $idlampiran,
                                'id_manag_dokumen' => $ud_id,
                                'filename' => $filename,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                    }
                    UploadDocumentModel::insert($files);         
                    return array (
                        'message' => 'Update Success !',
                        'success' => true,
                    );
                }else{
                    echo'Upload lampiran Gagal';
                }
            } else {
                return array (
                    'message' => 'Update Failed !',
                    'success' => false,
                );
            }

        
    }

    public function deactivate_document(Request $request){
        //dd($request->all());
        $token = apache_request_headers();
        $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();

        $dd_id = $request->input('dd_id');
        $req = DocumentModel::find($dd_id);

        $req->doc_status = 'Expired';
        $req->save();

        $document_log = DocumentModel::select('doc_number', 'id_manag_document')->where('id_manag_document',$dd_id)->get();
        $data = [
            'record_no' => Str::uuid(),
            'user_id' => $user->id,
            'activity' =>"Deactivate Document",
            'message' => " Doc Number ".$document_log[0]->doc_number. " || id_document-> ".$document_log[0]->id_manag_document,
        ];
        LogModel::create($data);

            return array (
                'message' => 'Document Status = Expired .',
                'success' => true,
            );

        
    }
}
