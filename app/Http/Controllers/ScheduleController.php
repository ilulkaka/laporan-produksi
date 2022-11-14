<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ScheduleModel;
use Illuminate\Support\Facades\Hash;

class ScheduleController extends Controller
{

    public function load (){
        $schedule = DB::table('tb_schedule')->get();
        dd($schedule->all());
    }
    public function listschedule (){
        $schedule = DB::table('tb_schedule')->get();
        return view ('maintenance.listschedule',['tb_schedule' => $schedule]);
    }    //
    //

    public function tambah(Request $request){
        $this->validate($request, [
            'description' =>'required',
            'lokasi'=>'required',
            'no_induk_mesin'=>'required',
            'nama_mesin'=>'required',
            'no_urut_mesin'=>'required',
            'tanggal_rencana_mulai'=>'required',
            'tanggal_rencana_selesai'=>'required',
            'operator'=>'required',
            'item_code'=>'required',
            'status'=>'required',
        ]);
        ScheduleModel::create([
            'description' => $request->description,
            'lokasi'=>$request->lokasi,
            'no_induk_mesin'=>$request->no_induk_mesin,
            'nama_mesin'=>$request->nama_mesin,
            'no_urut_mesin'=>$request->no_mesin,
            'tanggal_rencana_mulai'=>$request->start_date,
            'tanggal_rencana_selesai'=>$request->end_date,
            'operator'=>$request->operator,
            'item_code'=>$request->item_code,
            'status'=>$request->status,
        ]);
    
        return redirect('/maintenance/schedule')->with('alert-success','Register berhasil !');
        
       }
}