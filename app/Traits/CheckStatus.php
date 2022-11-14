<?php

namespace App\Traits;
use App\TindakanModel;

trait CheckStatus{
    Public function cekstatus($id_masalah){
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
}
