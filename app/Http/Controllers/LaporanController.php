<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\JamoperatorModel;

class LaporanController extends Controller
{

    public function undermaintenance (){
      return view ('undermaintenance');
    }

    public function lap_kamu ($tgl, $kode_line, $shift){
      $opr = DB::table('tb_hasil_produksi')->select('operator')->where('tgl_proses','=',$tgl)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->get();
      $line = DB::table('tb_line')->select('nama_line','kode_line')->where('kode_line','=',$kode_line)->first();
      return view ('laporan/lap_kamu',['tgl'=>$tgl, 'shift'=>$shift, 'line'=>$line,  'opr'=>$opr]);
    }
  
    public function get_lap_kamu (Request $request){
        //dd($request->all());
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $selectshift = $request->input('selectshift');
        $line = $request->input('line');

      if($selectshift == 'All'){
        $shiftq = '';
      }else{
        $shiftq = " and shift = '".$selectshift."'" ;
      }
      
     
      $strQuery = "select t1.*, t2.lot_no, convert(int, t2.total_cycle) as total_cycle, isnull((t3.jam_total),0) as jam_total, t3.status from
      (select nik, operator, no_mesin, isnull((BIRU),0) as BIRU, isnull((PUTIH),0) as PUTIH, isnull((KUNING),0) as KUNING, isnull((PINK),0) as PINK, isnull((PinkU),0) as PinkU, isnull((HijauNaishu),0) as HijauNaishu, isnull((HijauReguler),0) as HijauReguler, isnull((HijauUchicatto),0) as HijauUchicatto,   isnull((Lain),0) as Lain
            from
            (
              select nik, operator, no_mesin, grouping, sum(finish_qty) as finish_qty
              from tb_hasil_produksi where line_proses = '$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq."  group by nik, operator, no_mesin, grouping
            ) d
            pivot
            (
              max(finish_qty)
              for grouping in (PUTIH, BIRU, KUNING, PINK, PinkU, HijauNaishu, HijauReguler, HijauUchicatto,  Lain)
            ) piv) t1
      left join
      (select nik, operator, no_mesin, COUNT(lot_no) as lot_no, sum(total_cycle) as total_cycle from tb_hasil_produksi where line_proses = '$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." group by nik, operator, no_mesin)t2 on t1.nik = t2.nik and t1.no_mesin = t2.no_mesin
      left join
      (select no_mesin, nik, operator, status, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line' GROUP by no_mesin, nik, operator, status )t3 on t1.nik = t3.nik and t1.no_mesin = t3.no_mesin
      order by CONVERT(int, t1.no_mesin) asc";

      $hasil_kamu = DB::select($strQuery);

      $strQuerydandoriman = "SELECT t1.dandoriman, isnull((t2.dandori),0) as kosong , isnull((t3.dandori),0) as separuh, isnull((t4.dandori),0) as penuh  from
      (SELECT dandoriman from tb_hasil_produksi WHERE line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY dandoriman)t1
      LEFT JOIN 
      (SELECT dandoriman, count(dandori) as dandori from tb_hasil_produksi thp WHERE dandori = 'None' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY dandoriman)t2 on t1.dandoriman = t2.dandoriman
      LEFT JOIN 
      (SELECT dandoriman, count(dandori) as dandori from tb_hasil_produksi thp WHERE dandori = 'SEMI' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY dandoriman)t3 on t1.dandoriman = t3.dandoriman
      LEFT JOIN 
      (SELECT dandoriman, count(dandori) as dandori from tb_hasil_produksi thp WHERE dandori = 'FULL' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY dandoriman)t4 on t1.dandoriman = t4.dandoriman";
      $hasil_dandoriman = DB::select($strQuerydandoriman);

      //dd($hasil_dandoriman);
        return array ('hasil_kamu'=>$hasil_kamu, 'hasil_dandoriman'=>$hasil_dandoriman);
    }

    //GSM -----------------------------------------------------------------------------------------
    public function lap_gsm ($tgl, $kode_line, $shift){
      $opr = DB::table('tb_hasil_produksi')->select('operator')->where('tgl_proses','=',$tgl)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->get();
      $line = DB::table('tb_line')->select('nama_line','kode_line')->where('kode_line','=',$kode_line)->first();
      return view ('laporan/lap_gsm',['tgl'=>$tgl, 'shift'=>$shift, 'line'=>$line,  'opr'=>$opr]);
    }

    public function get_lap_gsm (Request $request){
      //dd($request->all());
      $tgl_awal = $request->input('tgl_awal');
      $tgl_akhir = $request->input('tgl_akhir');
      $selectshift = $request->input('selectshift');
      $line = $request->input('line');

      if($selectshift == 'All'){
        $shiftq = '';
      }else{
        $shiftq = " and shift = '".$selectshift."'" ;
      }

      //dd($shiftq);
    
      $strQuery = "SELECT t1.nik, t1.operator, t1.no_mesin, isnull((t2.finish_qty),0) as CompF, isnull((t3.finish_qty),0) as CompCr, isnull((t4.finish_qty),0) as OILF, isnull((t5.finish_qty),0) as OILCr, isnull((t6.lot_no),0) as lot_no, isnull((t7.jam_total),0) as jam_total, t7.status, isnull((t6.total_cycle),0) as total_cycle  from
      (SELECT nik, operator, no_mesin from tb_hasil_produksi WHERE remark = 'Reguler' and line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t1
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Reguler' and line_proses ='$line' and [type] = 'COMP' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t2 on t1.nik = t2.nik and t1.no_mesin = t2.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Reguler' and line_proses ='$line' and [type] = 'COMP' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t3 on t1.nik = t3.nik and t1.no_mesin = t3.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Reguler' and line_proses ='$line' and [type] = 'OIL' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t4 on t1.nik = t4.nik and t1.no_mesin = t4.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Reguler' and line_proses ='$line' and [type] = 'OIL' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t5 on t1.nik = t5.nik and t1.no_mesin = t5.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, count(lot_no) as lot_no, sum(total_cycle) as total_cycle from tb_hasil_produksi where remark = 'Reguler' and line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t6 on t1.nik = t6.nik and t1.no_mesin = t6.no_mesin
      LEFT JOIN 
      (select nik, operator, no_mesin, status, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line' GROUP by nik, operator, status, no_mesin)t7 on t1.nik = t7.nik and t1.no_mesin = t7.no_mesin
      order by CONVERT(int, t1.no_mesin) asc";
      $hasil_atari = DB::select($strQuery);

      return array ('hasil_atari'=>$hasil_atari);
    }

    public function get_lap_gsm_2x (Request $request){
      //dd($request->all());
      $tgl_awal = $request->input('tgl_awal');
      $tgl_akhir = $request->input('tgl_akhir');
      $selectshift = $request->input('selectshift');
      $line = $request->input('line');

      if($selectshift == 'All'){
        $shiftq = '';
      }else{
        $shiftq = " and shift = '".$selectshift."'" ;
      }

      //dd($shiftq);
    
      $strQuery = "SELECT t1.nik, t1.operator, t1.no_mesin, isnull((t2.finish_qty),0) as CompF, isnull((t3.finish_qty),0) as CompCr, isnull((t4.finish_qty),0) as OILF, isnull((t5.finish_qty),0) as OILCr, isnull((t6.lot_no),0) as lot_no, isnull((t7.jam_total),0) as jam_total, t7.status, isnull((t6.total_cycle),0) as total_cycle  from
      (SELECT nik, operator, no_mesin from tb_hasil_produksi WHERE remark = 'Proses2x' and line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t1
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Proses2x' and line_proses ='$line' and [type] = 'COMP' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t2 on t1.nik = t2.nik and t1.no_mesin = t2.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Proses2x' and line_proses ='$line' and [type] = 'COMP' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t3 on t1.nik = t3.nik and t1.no_mesin = t3.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Proses2x' and line_proses ='$line' and [type] = 'OIL' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t4 on t1.nik = t4.nik and t1.no_mesin = t4.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE remark = 'Proses2x' and line_proses ='$line' and [type] = 'OIL' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t5 on t1.nik = t5.nik and t1.no_mesin = t5.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, count(lot_no) as lot_no, sum(total_cycle) as total_cycle from tb_hasil_produksi where remark = 'Proses2x' and line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t6 on t1.nik = t6.nik and t1.no_mesin = t6.no_mesin
      LEFT JOIN 
      (select nik, operator, no_mesin, status, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line' GROUP by nik, operator, status, no_mesin)t7 on t1.nik = t7.nik and t1.no_mesin = t7.no_mesin
      order by CONVERT(int, t1.no_mesin) asc";
      $hasil_atari = DB::select($strQuery);

      return array ('hasil_atari'=>$hasil_atari);
    }


    //ATARI KENSA -----------------------------------------------------------------------------------------
    public function lap_atari ($tgl, $kode_line, $shift){
      $opr = DB::table('tb_hasil_produksi')->select('operator')->where('tgl_proses','=',$tgl)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->get();
      $line = DB::table('tb_line')->select('nama_line','kode_line')->where('kode_line','=',$kode_line)->first();
      return view ('laporan/lap_atari',['tgl'=>$tgl, 'shift'=>$shift, 'line'=>$line,  'opr'=>$opr]);
    }

    public function get_lap_atari (Request $request){
      //dd($request->all());
      $tgl_awal = $request->input('tgl_awal');
      $tgl_akhir = $request->input('tgl_akhir');
      $selectshift = $request->input('selectshift');
      $line = $request->input('line');

      if($selectshift == 'All'){
        $shiftq = '';
      }else{
        $shiftq = " and shift = '".$selectshift."'" ;
      }

      //dd($shiftq);
    
      $strQuery = "SELECT t1.nik, t1.operator, t1.no_mesin, isnull((t2.finish_qty),0) as CompF, isnull((t3.finish_qty),0) as CompCr, isnull((t4.finish_qty),0) as OILF, isnull((t5.finish_qty),0) as OILCr, isnull((t6.lot_no),0) as lot_no, isnull((t7.jam_total),0) as jam_total, t7.status, isnull((t6.total_cycle),0) as total_cycle  from
      (SELECT nik, operator, no_mesin from tb_hasil_produksi WHERE line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t1
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'COMP' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t2 on t1.nik = t2.nik and t1.no_mesin = t2.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'COMP' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t3 on t1.nik = t3.nik and t1.no_mesin = t3.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'OIL' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t4 on t1.nik = t4.nik and t1.no_mesin = t4.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'OIL' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t5 on t1.nik = t5.nik and t1.no_mesin = t5.no_mesin
      LEFT JOIN 
      (SELECT nik, operator, no_mesin, count(lot_no) as lot_no, sum(total_cycle) as total_cycle from tb_hasil_produksi where line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator, no_mesin)t6 on t1.nik = t6.nik and t1.no_mesin = t6.no_mesin
      LEFT JOIN 
      (select nik, operator, no_mesin, status, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line' GROUP by nik, operator, status, no_mesin)t7 on t1.nik = t7.nik and t1.no_mesin = t7.no_mesin
      order by CONVERT(int, t1.no_mesin) asc";
      $hasil_atari = DB::select($strQuery);

      return array ('hasil_atari'=>$hasil_atari);
    }

      //GAIKAN KENSA + PENGEMASAN -----------------------------------------------------------------------------------------
    public function lap_gaikan ($tgl, $kode_line, $shift){
      $opr = DB::table('tb_hasil_produksi')->select('operator')->where('tgl_proses','=',$tgl)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->get();
      $line = DB::table('tb_line')->select('nama_line','kode_line')->where('kode_line','=',$kode_line)->first();
      //dd($line->nama_line);
      return view ('laporan/lap_gaikan',['shift'=>$shift, 'line'=>$line, 'opr'=>$opr]);
    }

    public function get_lap_gaikan (Request $request){
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $selectshift = $request->input('selectshift');
        $line = $request->input('line');

      if($selectshift == 'All'){
        $shiftq = '';
      }else{
        $shiftq = " and shift = '".$selectshift."'" ;
      }
     
      $strQuery = "SELECT t1.nik, t1.operator, isnull((t2.finish_qty),0) as CompF, isnull((t3.finish_qty),0) as CompCr, isnull((t4.finish_qty),0) as OILF, isnull((t5.finish_qty),0) as OILCr, isnull((t6.jam_total),0) as jam_total, t6.status  from
      (SELECT nik, operator from tb_hasil_produksi WHERE line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator)t1
      LEFT JOIN 
      (SELECT nik, operator, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and  [type] = 'COMP' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator)t2 on t1.nik = t2.nik
      LEFT JOIN 
      (SELECT nik, operator, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and  [type] = 'COMP' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator)t3 on t1.nik = t3.nik
      LEFT JOIN 
      (SELECT nik, operator, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE  line_proses ='$line' and [type] = 'OIL' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator)t4 on t1.nik = t4.nik
      LEFT JOIN 
      (SELECT nik, operator, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and  [type] = 'OIL' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, operator)t5 on t1.nik = t5.nik
      LEFT JOIN 
      (select nik, operator, status, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line' GROUP by nik, operator, status)t6 on t1.nik = t6.nik ";
      
      $hasil_gaikan = DB::select($strQuery);
  
        return array ('hasil_gaikan'=>$hasil_gaikan);
    }

    //SHOTKENSA -------------------------------------------------------------------------------------------
          public function lap_shotkensa ($tgl, $kode_line, $shift){
            $opr = DB::table('tb_hasil_produksi')->select('operator')->where('tgl_proses','=',$tgl)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->get();
            $line = DB::table('tb_line')->select('nama_line','kode_line')->where('kode_line','=',$kode_line)->first();
            return view ('laporan/lap_shotkensa',['tgl'=>$tgl, 'shift'=>$shift, 'line'=>$line,  'opr'=>$opr]);
          }

          public function get_lap_shotkensa (Request $request){
            $tgl_awal = $request->input('tgl_awal');
            $tgl_akhir = $request->input('tgl_akhir');
            $selectshift = $request->input('selectshift');
            $line = $request->input('line');
      
            if($selectshift == 'All'){
              $shiftq = '';
            }else{
              $shiftq = " and shift = '".$selectshift."'" ;
            }

            $strQuery = "SELECT t1.nik, t1.operator, t1.no_mesin, isnull((t2.finish_qty),0) as CompF, isnull((t3.finish_qty),0) as CompCr, isnull((t4.finish_qty),0) as OILF, isnull((t5.finish_qty),0) as OILCr, isnull((t6.lot_no),0) as lot_no, isnull((t7.jam_total),0) as jam_total  from
            (SELECT nik, operator, no_mesin from tb_hasil_produksi WHERE line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t1
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'COMP' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t2 on t1.nik = t2.nik and t1.no_mesin = t2.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'COMP' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t3 on t1.nik = t3.nik and t1.no_mesin = t3.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'OIL' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t4 on t1.nik = t4.nik and t1.no_mesin = t4.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'OIL' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t5 on t1.nik = t5.nik and t1.no_mesin = t5.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, count(lot_no) as lot_no from tb_hasil_produksi where line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t6 on t1.operator = t6.operator and t1.no_mesin = t6.no_mesin
            LEFT JOIN 
            (select nik, operator, no_mesin, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line'  GROUP by nik, no_mesin, operator)t7 on t1.nik = t7.nik and t1.no_mesin = t7.no_mesin
            order by CONVERT(int, t1.no_mesin) asc";

            $hasil_shotkensa = DB::select($strQuery);
//dd($hasil_sozai);
          
            return array ('hasil_shotkensa'=>$hasil_shotkensa);
          }


    //SOZAI KENSA + NAIGAIKEN + DDG -----------------------------------------------------------------------------------------
          public function lap_sozai ($tgl, $kode_line, $shift){
            $opr = DB::table('tb_hasil_produksi')->select('operator')->where('tgl_proses','=',$tgl)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->get();
            $line = DB::table('tb_line')->select('nama_line','kode_line')->where('kode_line','=',$kode_line)->first();

            $item1 = DB::connection('sqlsrv_pass')->table('tb_masteritem')->select('item', 'spesifikasi')->where('class','=','Spare Parts')->groupBy('item', 'spesifikasi')->get();
            //dd($item1);
            return view ('laporan/lap_sozai',['tgl'=>$tgl, 'shift'=>$shift, 'line'=>$line,  'opr'=>$opr, 'item1'=>$item1]);
          }
      
          public function get_lap_sozai (Request $request){
            //dd($request->all());
            $tgl_awal = $request->input('tgl_awal');
            $tgl_akhir = $request->input('tgl_akhir');
            $selectshift = $request->input('selectshift');
            $line = $request->input('line');
      
            if($selectshift == 'All'){
              $shiftq = '';
            }else{
              $shiftq = " and shift = '".$selectshift."'" ;
            }
      

            $strQuery = "SELECT t1.nik, t1.operator, t1.no_mesin, isnull((t2.finish_qty),0) as CompF, isnull((t3.finish_qty),0) as CompCr, isnull((t4.finish_qty),0) as OILF, isnull((t5.finish_qty),0) as OILCr, isnull((t6.lot_no),0) as lot_no, isnull((t7.jam_total),0) as jam_total  from
            (SELECT nik, operator, no_mesin from tb_hasil_produksi WHERE line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t1
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'COMP' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t2 on t1.nik = t2.nik and t1.no_mesin = t2.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'COMP' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t3 on t1.nik = t3.nik and t1.no_mesin = t3.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'OIL' and crf = 'F' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t4 on t1.nik = t4.nik and t1.no_mesin = t4.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, sum(finish_qty) as finish_qty from tb_hasil_produksi thp WHERE line_proses ='$line' and [type] = 'OIL' and crf = 'CR' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t5 on t1.nik = t5.nik and t1.no_mesin = t5.no_mesin
            LEFT JOIN 
            (SELECT nik, operator, no_mesin, count(lot_no) as lot_no from tb_hasil_produksi where line_proses ='$line' and tgl_proses >= '$tgl_awal' and tgl_proses <= '$tgl_akhir' ".$shiftq." GROUP BY nik, no_mesin, operator)t6 on t1.operator = t6.operator and t1.no_mesin = t6.no_mesin
            LEFT JOIN 
            (select nik, operator, no_mesin, sum(jam_total)as jam_total from tb_jam_kerja tjk WHERE tgl_jam_kerja >='$tgl_awal' and tgl_jam_kerja <='$tgl_akhir' ".$shiftq." and line_proses ='$line'  GROUP by nik, no_mesin, operator)t7 on t1.nik = t7.nik and t1.no_mesin = t7.no_mesin
            order by CONVERT(int, t1.no_mesin) asc";
            $hasil_sozai = DB::select($strQuery);
          
            return array ('hasil_sozai'=>$hasil_sozai);
          }

          //Input Jam kerja -----------------------------------------------------------------------------------------
          public function entry_jam_operator (Request $request){
            //dd($request->all());
            $nik = $request->input('nik');
            $operator = $request->input('operator');
            $tgl_proses = $request->input('tgl_proses');
            $shift = $request->input('shift');
            $kode_line = $request->input('kode_line');
            $idjamkerja = Str::uuid();
            $no_mesin = $request->input('i_no_mesin');

            $jamtotal = $request->input('i_jam_total');

            $cek = DB::table('tb_jam_kerja')->select('jam_total')->where('nik','=',$nik)->where('tgl_jam_kerja','=',$tgl_proses)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->where('no_mesin','=',$no_mesin)->count();
            $status = DB::table('tb_jam_kerja')->select('status')->where('nik','=',$nik)->where('tgl_jam_kerja','=',$tgl_proses)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->where('no_mesin','=',$no_mesin)->get();
            $mess = "$operator  $shift  Already Exists and can't change data.";
            //dd($status[0]->status);

            if ($cek > 0 && $status[0]->status == 'Approve'){
              return array(
                'message' => $mess,
                'success' => false,
              );
            } elseif ($cek > 0 && $status[0]->status == null){
              $req = DB::table('tb_jam_kerja')->where('nik','=',$nik)->where('tgl_jam_kerja','=',$tgl_proses)->where('line_proses','=',$kode_line)->where('shift','=',$shift)->where('no_mesin','=',$no_mesin)->update([
                'jam_total' => $jamtotal,
                'ket'=> $request->i_keterangan,
                ]);
                
                return array(
                  'message' => $mess,
                  'success' => true,
                );

            }else{
              $insertjamoperator = JamoperatorModel::create([
                'id_jam_kerja'=>$idjamkerja,
                'tgl_jam_kerja'=>$tgl_proses,
                'nik'=>$nik,
                'operator'=>$operator,
                'line_proses'=>$kode_line,
                'jam_total'=>$request->i_jam_total,
                'jam_lain'=>$request->i_jam_lain,
                'ket'=>$request->i_keterangan,
                'shift'=>$shift,
                'no_mesin'=>$no_mesin,
              ]);

              return array(
                'message' => 'Insert data Successfull .',
                'success' => true,
              );

            }
          }

          public function get_jamkerja (Request $request){
            //dd($request->all());
            $nik = $request->input('nik');
            $kode_line = $request->input('kode_line');
            $tgl_proses = $request->input('tgl_proses');
            $shift = $request->input('shift');
            $no_mesin = $request->input('no_mesin');
            
            $data = DB::table('tb_jam_kerja')->select('jam_total','ket')
            ->where('nik',$nik)->where('line_proses',$kode_line)
            ->where('tgl_jam_kerja',$tgl_proses)->where('shift',$shift)->where('no_mesin',$no_mesin)->first();
            //dd($data->jam_total);
            if (empty($data)){
              return array(
                'message' =>"Update data berhasil !",
            );
            } else {
              return array(
                "jam_total"=>$data->jam_total,
                "ket"=>$data->ket
            );
            }
            //return $data;
          }

      

}
