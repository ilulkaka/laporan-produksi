<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\AcceptanceModel;

class WareHouseController extends Controller
{
    public function pemakaian(Request $request){

        $tanggal = $request->input("tgl_awal");
        $now = $request->input("tgl_akhir");
        $tgl2 = date_create($now);
        $tgl = date('Y-m');
        //$pemakaian = DB::connection("sqlsrv_pass")->select("select a.dept, sum (b.unit_price * a.qty) as total from tb_out a join tb_stock b on a.item_code = b.item_code where a.out_date <= '$now' and a.out_date >= '$tanggal' and a.remark is null group by a.dept");
        $pemakaian = DB::connection("sqlsrv_pass")->select("select tk.nama_kelompok, isnull((sum(t2.quota_amount)),0) as amount, sum(isnull((t3.total_out),0)* ISNULL((t2.unit_price),t4.moving_avg)) as pakai, sum(isnull((t2.quota_amount),0) - (isnull((t3.total_out),0)* ISNULL((t2.unit_price),t4.moving_avg))) as sisa from
        (select item_code, kelompok from tb_stock where lokasi = 'Warehouse' and laporan = 'Bulanan' and kelompok not in ('SC01','SUSZ','SZ01','SUFG') and item_code not in('RM0017')) t1
        left join
        (select * from tb_quota where DATEPART(YYYY,periode) = DATEPART(YYYY,'$tanggal') and DATEPART(MM,periode) = DATEPART(MM,'$tanggal'))t2 on t1.item_code = t2.item_code
        left join
        (select * from tb_kelompok)tk on t1.kelompok = tk.kode_kelompok
        left join
        (select item_code, moving_avg from v_bulanan)t4 on t1.item_code = t4.item_code
        left join
        (select item_code, sum(qty_out ) as total_out
                        from tb_transaction WHERE trans_date >= '$tanggal' AND trans_date <= '$now' AND no_trans NOT LIKE '%Adjust%' AND no_trans NOT LIKE '%RET%'
                        group by item_code)t3 on t1.item_code = t3.item_code group by tk.nama_kelompok");
       /*
        if ($tgl == $tgl2->format('Y-m')) {
           
            $pemakaian = DB::connection("sqlsrv_pass")->select("select a.dept, sum (b.unit_price * a.qty) as total from tb_out a join tb_stock b on a.item_code = b.item_code where a.out_date <= '$now' and a.out_date >= '$tanggal' and a.remark is null group by a.dept");
        }else{
            
            $pemakaian = DB::connection("sqlsrv_pass")->select("select a.dept, sum (b.moving_avg_up * a.qty) as total from tb_out a join tb_stock_bulanan b on a.item_code = b.item_code and datepart (yyyy,tgl_laporan) = DATEPART (yyyy, '$now') and DATEPART(MM, tgl_laporan) = DATEPART(MM,'$now')  where a.out_date <= '$now' and a.out_date >= '$tanggal' and a.remark is null group by a.dept");
        }
     */
    
        return $pemakaian;
    }
    
    public function detail_pakai(Request $request){
      
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        $dept = $request->input("jenis");
        $tanggal = $request->input("awal");
        $now = $request->input("akhir");
       $tgl_akhir = date_create($now);

       /*
       
        $Datas = DB::connection("sqlsrv_pass")->table("tb_out")
                                            ->leftjoin("tb_stock", "tb_out.item_code","=","tb_stock.item_code")
                                            ->select(DB::raw("tb_out.item_code, tb_out.item, tb_out.spesifikasi, sum(tb_out.qty) as qty, tb_out.uom, tb_out.class"))
                                            ->where("tb_out.out_date","<=", $now)
                                            ->where("tb_out.out_date",">=", $tanggal)
                                            ->where("tb_out.dept", "=", $dept)
                                            ->wherenull("tb_out.remark")
                                            ->where(function($q) use ($search) {
                                                $q->where("tb_out.item", "like","%".$search."%")
                                                  ->orWhere("tb_out.spesifikasi", "like","%".$search."%");
                                            })
                                            ->groupBy(DB::raw("tb_out.item_code, tb_out.item, tb_out.spesifikasi, tb_out.uom, tb_out.class"))
                                            ->skip($start)
                                            ->take($length)
                                            ->get();

         $row = DB::connection("sqlsrv_pass")->table("tb_out")
                    ->leftjoin("tb_stock", "tb_out.item_code","=","tb_stock.item_code")
                    ->select("tb_out.item_code")
                    ->where("tb_out.out_date","<=", $now)
                    ->where("tb_out.out_date",">=", $tanggal)
                    ->where("tb_out.dept", "=", $dept)
                    ->wherenull("tb_out.remark")
                    ->where(function($q) use ($search) {
                        $q->where("tb_out.item", "like","%".$search."%")
                          ->orWhere("tb_out.spesifikasi", "like","%".$search."%");
                    })
                    ->groupBy("tb_out.item_code")
                    ->get();
        
       */
  
                                    
      $Datas = DB::connection("sqlsrv_pass")->select("select t1.item_code, t2.item, t2.spesifikasi, isnull((t3.quota),0) as quota, isnull((t1.total_out),0) as pemakaian, isnull((t3.quota),0) - isnull((t1.total_out),0) as selisih, t2.uom from
      (select item_code, sum(qty_out ) as total_out
                      from tb_transaction WHERE trans_date >= '$tanggal' AND trans_date <= '$now' AND no_trans NOT LIKE '%Adjust%' AND no_trans NOT LIKE '%RET%' and item_code not in('RM0017')
                      group by item_code) t1
      left join
      (select item_code, item, spesifikasi, kelompok, uom from tb_stock where lokasi = 'Warehouse' and laporan = 'Bulanan' and kelompok not in ('SC01','SUSZ','SZ01','SUFG'))t2 on t1.item_code = t2.item_code
      left join
      (select * from tb_quota where DATEPART(YYYY,periode) = DATEPART(YYYY,'$tanggal') and DATEPART(MM,periode) = DATEPART(MM,'$tanggal')) t3 on t1.item_code = t3.item_code
      left join
      (select * from tb_kelompok)tk on t2.kelompok = tk.kode_kelompok
      left join
      (select item_code, moving_avg from v_bulanan) tp on t1.item_code = tp.item_code where tk.nama_kelompok like '$dept' and isnull((t1.total_out),0) > 0 order by selisih asc OFFSET ".$start." ROWS FETCH NEXT ".$length." ROWS ONLY");


      $row = DB::connection("sqlsrv_pass")->select("select t1.item_code, t2.item, t2.spesifikasi, isnull((t3.quota),0) as quota, isnull((t1.total_out),0) as pemakaian, isnull((t3.quota),0) - isnull((t1.total_out),0) as selisih, t2.uom from
      (select item_code, sum(qty_out ) as total_out
                      from tb_transaction WHERE trans_date >= '$tanggal' AND trans_date <= '$now' AND no_trans NOT LIKE '%Adjust%' AND no_trans NOT LIKE '%RET%' and item_code not in('RM0017')
                      group by item_code) t1
      left join
      (select item_code, item, spesifikasi, kelompok, uom from tb_stock where lokasi = 'Warehouse' and laporan = 'Bulanan' and kelompok not in ('SC01','SUSZ','SZ01','SUFG'))t2 on t1.item_code = t2.item_code
      left join
      (select * from tb_quota where DATEPART(YYYY,periode) = DATEPART(YYYY,'$tanggal') and DATEPART(MM,periode) = DATEPART(MM,'$tanggal')) t3 on t1.item_code = t3.item_code
      left join
      (select * from tb_kelompok)tk on t2.kelompok = tk.kode_kelompok
      left join
      (select item_code, moving_avg from v_bulanan) tp on t1.item_code = tp.item_code where tk.nama_kelompok like '$dept' and isnull((t1.total_out),0) > 0");
       
        
        $count = count($row);
     
        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];

    }
    public function pemakaianxlsx(Request $request){
        
        $dept = $request->input("dept");
        $awal = $request->input("tanggal_awal");
        $akhir = $request->input("tanggal_akhir");
        /*
        $Datas = DB::connection("sqlsrv_pass")->table("tb_out")
                                            ->leftjoin("tb_stock", "tb_out.item_code","=","tb_stock.item_code")
                                            ->leftjoin("tb_kelompok", "tb_stock.kelompok","=","tb_kelompok.kode_kelompok")
                                            ->leftjoin("tb_quota","tb_out.item_code","=","tb")
                                            ->select("tb_out.out_no", "tb_out.dept", "tb_out.item_code", "tb_out.item", "tb_out.spesifikasi", "tb_out.qty", "tb_out.uom", "tb_stock.unit_price", "tb_out.out_date", "tb_out.used",  "tb_out.pengguna")
                                            ->where("tb_out.out_date","<=", $akhir)
                                            ->where("tb_out.out_date",">=", $awal)
                                            ->where("tb_kelompok.nama_kelompok", "=", $dept)
                                            ->wherenull("tb_out.remark")
                                            ->get();

        */

        $Datas = DB::connection("sqlsrv_pass")->select("select t1.out_no, t1.dept, t1.item_code, t2.item, t2.spesifikasi, isnull((t1.qty),0) as qty, t2.uom, ISNULL((t3.unit_price),tp.moving_avg) as unit_price, t1.out_date, t1.used, t1.pengguna from
        (select item_code, qty, out_no, out_date, dept, used, pengguna
                        from tb_out WHERE out_date >= '$awal' AND out_date <= '$akhir' AND remark is null
                        ) t1
        left join
        (select item_code, item, spesifikasi, kelompok, uom from tb_stock where lokasi = 'Warehouse' and laporan = 'Bulanan' and kelompok not in ('SC01','SUSZ','SZ01','SUFG') and item_code not in('RM0017'))t2 on t1.item_code = t2.item_code
        left join
        (select * from tb_quota where DATEPART(YYYY,periode) = DATEPART(YYYY,'$awal') and DATEPART(MM,periode) = DATEPART(MM,'$awal')) t3 on t1.item_code = t3.item_code
        left join
        (select * from tb_kelompok)tk on t2.kelompok = tk.kode_kelompok
        left join
        (select item_code, moving_avg from v_bulanan) tp on t1.item_code = tp.item_code where tk.nama_kelompok like '$dept' and isnull((t1.qty),0) > 0 order by t1.out_date asc");
       

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','No');
        $sheet->setCellValue('B1','No. Out');
        $sheet->setCellValue('C1','Departemen');
        $sheet->setCellValue('D1','Kode Barang');
        $sheet->setCellValue('E1','Item');
        $sheet->setCellValue('F1','Spesifikasi');
        $sheet->setCellValue('G1','Qty');
        $sheet->setCellValue('H1','Uom');
        $sheet->setCellValue('I1','Unit Price');
        $sheet->setCellValue('J1','Tanggal Out');
        $sheet->setCellValue('K1','Keterangan');
        $sheet->setCellValue('L1','Pengguna');

        $line = 2;
        $no = 1;
        foreach ($Datas as $data) {
            $sheet->setCellValue('A'.$line,$no++);
            $sheet->setCellValue('B'.$line,$data->out_no);
            $sheet->setCellValue('C'.$line,$data->dept);
            $sheet->setCellValue('D'.$line,$data->item_code);
            $sheet->setCellValue('E'.$line,$data->item);
            $sheet->setCellValue('F'.$line,$data->spesifikasi);
            $sheet->setCellValue('G'.$line,$data->qty);
            $sheet->setCellValue('H'.$line,$data->uom);
            $sheet->setCellValue('I'.$line,$data->unit_price);
            $sheet->setCellValue('J'.$line,$data->out_date);
            $sheet->setCellValue('K'.$line,$data->used);
            $sheet->setCellValue('L'.$line,$data->pengguna);
            $line++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "pemakaian_".date('YmdHis').".xlsx";
        $writer->save(public_path("storage/excel/".$filename));
        return ["file"=>url("/")."/storage/excel/".$filename];
       
    }

    public function acp(){
        $items = AcceptanceModel::take(10)
        ->get();

    return $items;
    }

    public function stockgudang(Request $request){
        //dd($request->all());
        $draw = $request->input("draw");
        $search = $request->input("search")['value'];
        $start = (int) $request->input("start");
        $length = (int) $request->input("length");
        
        $Datas = DB::connection("sqlsrv_pass")->table("tb_stock")
            ->where("lokasi","=","Warehouse")
            ->where(function($q) use ($search) {
                $q->where('item','like','%'.$search.'%')
                  ->orWhere('spesifikasi','like','%'.$search.'%')
                  ->orwhere('item_code','like','%'.$search.'%');
            })
            ->skip($start)
            ->take($length)
            ->get();
        $count = DB::connection("sqlsrv_pass")->table("tb_stock")
                ->where("lokasi","=","Warehouse")
                ->where(function($q) use ($search) {
                    $q->where('item','like','%'.$search.'%')
                      ->orWhere('spesifikasi','like','%'.$search.'%')
                      ->orwhere('item_code','like','%'.$search.'%');
                })->count();

        return  [
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $Datas
        ];
    }
}
