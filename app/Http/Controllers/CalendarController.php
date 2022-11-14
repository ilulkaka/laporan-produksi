<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CalendarModel;
use App\UserModel;
use Carbon\Carbon;

class CalendarController extends Controller
{
   public function create_event(Request $request){
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $cal = CalendarModel::create([
         'title'=>$request->input('title'),
         'start_event'=>date_create($request->input('startDate')),
         'end_event'=>date_create($request->input('endDate')),
         'color'=>$request->input('color'),
         'text_color'=>$request->input('text_color'),
         'user_id'=>$user->id,
         'tag'=>$request->input('tag'),
      ]);

      if($cal){

         return array(
           'message' =>"Simpan event berhasil",
           'success'=>true
       );
      }else{
         return array(
            'message' => "Simpan event gagal",
            'success'=>false
        );
      }
   }
   public function load(Request $request){
      //dd($request->input("start")['startStr']);
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $awal = date_create($request->input("start")['startStr']);
      $akhir = date_create($request->input("start")['endStr']);
      $Datas = CalendarModel::where('start_event','>=',$awal)
                              ->where('end_event','<=',$akhir)
                              ->where(function($q) use ($user) {
                                 $q->where('tag','hol')
                                    ->orwhere('tag','public')
                                   ->orWhere('user_id',$user->id);  
                             })
                              ->get();
      return $Datas;
   }

   public function update(Request $request){
     
      $start = date_create($request['start']);
      $end = date_create($request['end']);
     //dd($start);
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      //$cal = CalendarModel::where('id_calendar',$request->input('id'))->first();
     
      $cal = CalendarModel::find($request['id']);
      if ($request->has('title') && $request->has('tag') && $request->has('color') && $request->has('text_color')) {
         if ($cal->user_id == $user->id) {
            if ($cal->tag != 'hol') {
               $cal->title = $request['title'];
               $cal->tag = $request['tag'];
               $cal->color = $request['color'];
               $cal->text_color = $request['text_color'];
               $cal->start_event = $start;
               $cal->end_event = $end;
               $cal->save();
            }
            return array(
             'message' => "Update event berhasil",
             'success'=>true
            );
            
          }else{
             return array(
                'message' => "Update event gagal",
                'success'=>false
            );
          }
      }else{
         
         if ($cal->user_id == $user->id) {
            if ($cal->tag != 'hol') {
             
               $cal->end_event = $end;
               $cal->save();
            }
           return array(
            'message' => "Update event berhasil",
            'success'=>true
        );
         }else{
            return array(
               'message' => "Anda tidak diijinkan mengubah event ini",
               'success'=>false
           );
         }
        
      }
   }

   public function getevent(Request $request){
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $cal = CalendarModel::find($request['id']);
     
         return array(
            'message' => "Select event berhasil",
            'success'=>true,
            'data'=>$cal,
        );
     
   }

   public function delete(Request $request){
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $cal = CalendarModel::find($request['id']);
      if ($cal->user_id == $user->id) {
        $cal->delete();
        return array(
         'message' => "Hapus event berhasil",
         'success'=>true
     );
      }else{
         return array(
            'message' => "Anda tidak diijinkan menghapus event ini",
            'success'=>false
        );
      }
   }
   public function holiday(Request $request){
      $token = apache_request_headers();
      $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      $start = new Carbon($request->input('holstart'));
      $akhir = new Carbon($request->input('holend'));
      $akhir = $akhir->addDays(1);
      $akhir = $akhir->addSecond(-1);
    
      $cal = CalendarModel::create([
         'title'=>'holiday',
         'start_event'=>date_create($start),
         'end_event'=>date_create($akhir),
         'color'=>'#F90632',
         'text_color'=>'#FFFFFF',
         'user_id'=>$user->id,
         'tag'=>'hol',
      ]);

      if($cal){

         return array(
           'message' =>"Simpan event berhasil",
           'success'=>true
         );
      }else{
         return array(
            'message' => "Simpan event gagal",
            'success'=>false
         );
      }
   }
}
