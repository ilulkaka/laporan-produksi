<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LapGrafikController extends Controller
{
    public function grafik_hasil_produksi(){
        //$line = DB::table('tb_line')->select('nama_line','kode_line')->get();
        $line = DB::select("select t2.kode_line as kode_line, t2.nama_line as nama_line from
        (select line_proses from tb_hasil_produksi group by line_proses)t1
        left join
        (select kode_line, nama_line from tb_line group by kode_line, nama_line)t2 on t1.line_proses = t2.kode_line order by t2.kode_line asc");
        return view ('lap_grafik/grafik_hasil_produksi',['line'=>$line]);
    }

    public function grafik_hasil_operator (Request $request){
        //dd($request->all());
        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $selectline = $request->input("selectline");

        $hasil_atari = DB::select("SELECT t1.operator, isnull((t1.finish_qty),0) as finish_qty, isnull((t7.jam_total),0) as jam_total, isnull((t1.finish_qty / t7.jam_total),0) as pcsjam, isnull((t1.total_cycle),0) as total_cycle, isnull((t1.total_cycle / t7.jam_total),0) as cyclejam  from
        (SELECT nik, operator, sum(finish_qty) as finish_qty, sum(total_cycle) as total_cycle from tb_hasil_produksi WHERE line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' GROUP BY nik, operator)t1
        left JOIN 
        (select nik, operator, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' and line_proses ='$selectline' and status = 'Approve' GROUP by nik, operator)t7 on t1.nik = t7.nik order by t1.finish_qty desc");
        //dd($hasil_atari);
  
        return array ('hasil_atari'=>$hasil_atari);
    }

    public function detail_hasil_jam_produksi (Request $request){

        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $selectline = $request->input("selectline");

        $Datas = DB::select("SELECT t1.operator, isnull((t1.finish_qty),0) as finish_qty, isnull((t7.jam_total),0) as jam_total, isnull((t1.finish_qty / t7.jam_total),0) as pcsjam, isnull((t1.total_cycle),0) as total_cycle, isnull((t1.total_cycle / t7.jam_total),0) as cyclejam  from
        (SELECT nik, operator, sum(finish_qty) as finish_qty, sum(total_cycle) as total_cycle from tb_hasil_produksi WHERE line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' GROUP BY nik, operator)t1
        left JOIN 
        (select nik, operator, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' and line_proses ='$selectline' GROUP by nik, operator)t7 on t1.nik = t7.nik order by t1.finish_qty desc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

          $count = DB::select("select count(*) as total from (SELECT t1.operator, isnull((t1.finish_qty),0) as finish_qty, isnull((t7.jam_total),0) as jam_total, isnull((t1.finish_qty / t7.jam_total),0) as pcsjam  from
          (SELECT nik, operator, sum(finish_qty) as finish_qty from tb_hasil_produksi WHERE line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' GROUP BY nik, operator)t1
          left JOIN 
          (select nik, operator, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' and line_proses ='$selectline' GROUP by nik, operator)t7 on t1.nik = t7.nik)a")[0]->total;

          return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];    
    }

    public function detail_hasil_fcr (Request $request){
//dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");

        $tgl_awal = $request->input("tgl_awal");
        $tgl_akhir = $request->input("tgl_akhir");
        $selectline = $request->input("selectline");

        $Datas = DB::select("select a.type, isnull((t1.finish_qty),0) as F, isnull((t2.finish_qty),0) as CR from 
        (select type from tb_hasil_produksi where line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' group by type)a
        left join
        (select type, sum(finish_qty)as finish_qty from tb_hasil_produksi where crf='F' and line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' group by type)t1 on a.type = t1.type
        left join
        (select type, sum(finish_qty)as finish_qty from tb_hasil_produksi where crf='CR' and line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' group by type)t2 on a.type = t2.type order by a.type asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");

        $count = DB::select("select count(*)as total from (select t1.type, t1.finish_qty as F, t2.finish_qty as CR from 
        (select type from tb_hasil_produksi where line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' group by type)a
        left join
        (select type, sum(finish_qty)as finish_qty from tb_hasil_produksi where crf='F' and line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' group by type)t1 on a.type = t1.type
        left join
        (select type, sum(finish_qty)as finish_qty from tb_hasil_produksi where crf='CR' and line_proses ='$selectline' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' group by type)t2 on a.type = t2.type)a")[0]->total;

          return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];    
    }

}
