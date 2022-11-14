<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('postlogin', 'Usercontroller@postlogin');
//Route::post('logout', 'Usercontroller@logout');


Route::get('acp', 'WareHouseController@acp');
Route::post('set_target', 'PPICController@set_produksi');
Route::post('updatedenpyou','TechnicalController@list_updatedenpyou');
Route::post('set_targetsales', 'PPICController@set_targetsales');
//Api for external app
Route::post('apilogin', 'UserController@apilogin');

Route::middleware('ApiToken')->group(function () {
    Route::post('detail_pakai', 'WareHouseController@detail_pakai');
    Route::post('inquerypermintaan','TechnicalController@inquerypermintaan');
    Route::post('spareparts', 'PerbaikanController@list_parts');
    Route::post('perbaikan', 'PerbaikanController@list_perbaikan');
    Route::post('history_perbaikan', 'PerbaikanController@hyst_perbaikan');
    Route::post('/produksi/pemaikain_excel','WareHouseController@pemakaianxlsx');
    Route::post('nomer_perbaikan', 'PerbaikanController@get_nomer');
    Route::get('user', 'Usercontroller@get_user');
    Route::post('pemakaian', 'WareHouseController@pemakaian');
    Route::post('req_perbaikan', 'PerbaikanController@req_perbaikan');
    Route::post('nomer_permintaan', 'TechnicalController@get_nomer');
    Route::post('hapus/perbaikan', 'PerbaikanController@del_req');
    Route::post('update_request', 'PerbaikanController@update_req');
    Route::post('list_req', 'PerbaikanController@list_req');
    Route::post('pelaksana', 'PerbaikanController@update_pelaksana');
    Route::post('update_permintaan', 'TechnicalController@update_permintaan');
    Route::post('hapus/permintaan', 'TechnicalController@del_permintaan');
    Route::post('perbaikan_selesai', 'PerbaikanController@perbaikan_selesai');
    Route::post('perbaikan/complete', 'PerbaikanController@perbaikan_complete');
    Route::post('perbaikan/ditolak', 'PerbaikanController@perbaikan_ditolak');
    Route::post('perbaikan/get_schedule', 'PerbaikanController@get_schedule');
    Route::post('nomer_masalah','MasalahController@get_nomer');
    Route::post('inquerymasalah','MasalahController@inquerymasalah');
    Route::post('hapus/masalah', 'MasalahController@del_masalah');
    Route::post('masalah/get_excel', 'MasalahController@masalahxlsx');
    Route::post('update_masalah', 'MasalahController@update_masalah');
    Route::post('grafiklembur', 'PageController@grafiklembur');
    Route::post('detail_lembur', 'PageController@detail_lembur');
    Route::post('dashboard/successrate', 'PageController@get_successrate');
    Route::post('/req_selesai', 'PerbaikanController@req_selesai');
    Route::post('/maintenance/jam_kerusakan', 'PerbaikanController@jam_kerusakan');
    Route::post('/maintenance/grafikjam', 'PerbaikanController@grafikjam');
    Route::post('/maintenance/historymesin', 'PerbaikanController@historymesin');
    Route::post('/maintenance/partlist', 'PerbaikanController@partlist');
    Route::post('/maintenance/detailjam', 'PerbaikanController@detailjam');
    Route::post('/maintenance/exceljam', 'PerbaikanController@exceljam');
    Route::post('/maintenance/mtbf', 'PerbaikanController@mtbf');
    
    Route::post('update_permintaan_tch', 'TechnicalController@update_permintaan_tch');
    Route::post('inquerypermintaan_tch','TechnicalController@inquerypermintaan_tch');
    Route::post('inquerypermintaan_all','TechnicalController@inquerypermintaan_all');
    Route::post('inquerypermintaan_tch_all','TechnicalController@inquerypermintaan_tch_all');
    Route::post('cetak_permintaan_tch', 'TechnicalController@cetak_permintaan_tch');
    Route::post('produksi/jiguselesai', 'TechnicalController@getselesai');
    Route::post('produksi/terimajigu', 'TechnicalController@terimajigu');
    Route::post('produksi/listselesai', 'TechnicalController@listselesai');
    Route::post('technical/list_master_tanegata', 'TechnicalController@list_master_tanegata');
    Route::post('technical/save_add_master', 'TechnicalController@save_add_master');
    Route::post('technical/save_edit_master', 'TechnicalController@save_edit_master');
    
    
    Route::post('grafikmasalah', 'MasalahController@grafik');
    Route::get('tindakan/{id}', 'MasalahController@get_tindakan');
    Route::post('listmesin', 'PerbaikanController@listmesin');
    Route::post('listprog', 'PerbaikanController@listprog');
    Route::post('getlist_prog', 'PerbaikanController@getlist_prog');
    Route::get('download-prog/{id}/{file}', 'PerbaikanController@download_prog');
    
    Route::post('edit_update_denpyou', 'TechnicalController@edit_update_denpyou');
    Route::post('updatedenpyou/get_excel', 'TechnicalController@updatexlsx');
    Route::post('update_workresult', 'PPICController@update_workresult');
    Route::post('listworkresult', 'PPICController@listworkresult');
    Route::post('workresult/get_excel', 'PPICController@workresultxlsx');
    Route::post('workresult/getbarcode', 'PPICController@getbarcode');
    Route::post('inquery_workresult', 'PPICController@inquery_workresult');
    Route::post('technical/selesai', 'TechnicalController@jiguselesai');
    Route::post('technical/listselesai', 'TechnicalController@excelterima');
    Route::post('technical/eksportpermintaan', 'TechnicalController@excel_permintaan');
    Route::post('hapus/workresult', 'PPICController@del_workresult');
    Route::post('listworkresultmasalah', 'PPICController@listworkresultmasalah');
    Route::post('/admin/listuser','PageController@listuser');
    Route::post('/admin/listlog','PageController@listlog');
    Route::post('/admin/hapususer','UserController@hapususer');
    Route::post('tindakan/delete','MasalahController@deltindakan');
    Route::post('gantipassword','UserController@gantipassword');
    Route::post('pdfworkresult', 'PPICController@pdfworkresult');
    Route::post('successrate','PageController@successrate');
    Route::post('listsuccessrate','PageController@listsuccessrate');
    Route::post('inquerypenilaian','DeptheadController@inquerypenilaian');
    Route::post('rekapappraisal','pgaController@rekapappraisal');
    Route::post('pga/rekappenilaian/get_excel', 'pgaController@excelrekappenilaian');
    Route::post('inquerypenilaianpimpinan','DeptheadController@inquerypenilaianpimpinan');
    Route::post('rekapappraisal_1','pgaController@rekapappraisal_1');
    Route::post('edit_poin_umum','pgaController@edit_poin_umum');
    Route::post('edit_poin_leaderup','pgaController@edit_poin_leaderup');
    Route::post('pga/rekappenilaian/get_excel_leaderup', 'pgaController@excelrekappenilaianleaderup');
    Route::post('countkaryawan','pgaController@countkaryawan');
    Route::post('countkaryawan_1','pgaController@countkaryawan_1');
    Route::post('detail_karyawan','pgaController@detail_karyawan');
    Route::post('detail_karyawan_list','pgaController@detail_karyawan_list');
    Route::post('inquerypenilaianbonus','DeptheadController@inquerypenilaianbonus');
    Route::post('inquerybonuspimpinan','DeptheadController@inquerybonuspimpinan');
    Route::post('rekapbonus','pgaController@rekapbonus');
    Route::post('rekapbonus_1','pgaController@rekapbonus_1');
    Route::post('pga/rekapbonus/get_excel', 'pgaController@excelrekapbonus');
    Route::post('edit_poin_bonus_umum','pgaController@edit_poin_bonus_umum');
    Route::post('edit_poin_bonus_leaderup','pgaController@edit_poin_bonus_leaderup');
    Route::post('pga/rekapbonus/get_excel_leaderup', 'pgaController@excelrekapbonusleaderup');

    Route::post('manager/getargetlembur', 'PageController@getargetlembur');
    Route::post('produksi/getreport_produksi', 'PageController@getreport_produksi');
    Route::post('edit_penilaian_umum','DeptheadController@edit_penilaian_umum');
    Route::post('edit_penilaian_leaderup','DeptheadController@edit_penilaian_leaderup');
    Route::post('approval_penilaian_umum','DeptheadController@approval_penilaian_umum');
    Route::post('approval_penilaian_leaderup','DeptheadController@approval_penilaian_leaderup');
    Route::post('getklas', 'DeptheadController@getCategory');
    Route::post('ambilnik', 'DeptheadController@get_nik');
    Route::post('getklas_bonus', 'DeptheadController@getCategory');
    Route::post('edit_bonus_umum','DeptheadController@edit_bonus_umum');
    Route::post('edit_bonus_leader','DeptheadController@edit_bonus_leader');
    Route::post('approval_bonus_umum','DeptheadController@approval_bonus_umum');
    Route::post('approval_bonus_leader','DeptheadController@approval_bonus_leader');
    
    Route::post('nomer_ss','ISOController@get_nomer');
    Route::post('listdatass','ISOController@ssinquery');
    Route::post('iso/editss','ISOController@editss');
    Route::post('iso/editpoin','ISOController@editpoin');
    Route::post('pga/inqueryabsensi','PGAController@inqueryabsensi');
    Route::post('/iso/grafikpie', 'ISOController@grafikpie');
    Route::post('/iso/grafikbar', 'ISOController@grafikbar');
    Route::post('update_ss', 'ISOController@update_ss');
    Route::post('hapus/ss', 'ISOController@del_ss');
    Route::post('ssET1', 'ISOController@ssET1');
    Route::post('listdatassnilai','ISOController@ssnilai');
    Route::post('iso/addpoint','ISOController@addpoint');
    Route::post('approve_point_ss','ISOController@approve_point_ss');
    Route::post('iso/get_isoexcel','ISOController@get_isoexcel');

    Route::post('calendar/create','CalendarController@create_event');
    Route::post('calendar/load','CalendarController@load');
    Route::post('calendar/update','CalendarController@update');
    Route::post('calendar/getevent','CalendarController@getevent');
    Route::post('calendar/delete','CalendarController@delete');
    Route::post('calendar/holiday','CalendarController@holiday');

    Route::post('nomer_hh','HSEController@get_nomer');
    Route::post('listdatahk','HSEController@hkinquery');
    Route::get('tindakanHH/{id}', 'HSEController@get_tindakan');
    Route::get('tindakanHHpoint/{id}', 'HSEController@get_tindakan_point');
    Route::post('update_hhky', 'HSEController@update_masalah');
    Route::post('tindakanHH/delete','HSEController@deltindakan');
    Route::post('hapus/hhky', 'HSEController@del_hhky');
    Route::post('/hse/grafikpie', 'HSEController@grafikpie');
    Route::post('/hse/grafikbar', 'HSEController@grafikbar');
    Route::post('/hse/grafikbar2', 'HSEController@grafikbar2');
    Route::post('hse/get_hseexcel','HSEController@get_hseexcel');
    Route::post('hse/hhkyrekapmonth','HSEController@hhkyrekapmonth');
    Route::post('hse/hhkyrekaplevel','HSEController@hhkyrekaplevel');
    Route::post('hse/closing_hhky','HSEController@closing_hhky');

    Route::post('nomer_induk_jigu','JiguController@get_nomer');
    Route::post('jigu/inquerynoinduk','JiguController@inquerynoinduk');
    Route::post('jigu/inquerynoinduk_warehouse','JiguController@inquerynoinduk_warehouse');
    Route::post('jigu/process','JiguController@process');
    Route::post('jigu/checkout','JiguController@checkout');
    Route::post('jigu/requestmanual','JiguController@requestmanual');

    Route::post('qa/inqueryjigu','JiguController@inqueryjigu');
    Route::post('qa/qaprocess','JiguController@qaprocess');
    Route::post('qa/getlokasi','JiguController@getlokasi');
    Route::post('qa/qarepair','JiguController@qarepair');
    Route::post('qa/getnomertch','JiguController@getnomertch');
    Route::post('qa/inrepair','JiguController@inrepair');
    Route::post('qa/listdaichou','JiguController@listdaichou');
    Route::post('qa/inqueryorder','JiguController@inqueryorder');
    Route::post('qa/noukimanual','JiguController@noukimanual');
    Route::post('qa/listdaichou/get_excel', 'JiguController@exceldaichou');


    Route::post('/mtc/listreq', 'MtcController@getrequest');
    Route::post('/mtc/listcompl', 'MtcController@getclose');

    Route::post('/produksi/getbarcode', 'ProduksiController@getbarcode');
    Route::post('update_laporan_produksi', 'ProduksiController@update_laporan_produksi');
    Route::post('master_ng', 'ProduksiController@master_ng');
    Route::post('hasilproduksi','ProduksiController@hasilproduksi');
    Route::post('inquery_report_detail','ProduksiController@detail_inquery_report');
    Route::post('detail_ng','ProduksiController@detail_ng');
    Route::post('hapus/hasilproduksi','ProduksiController@hapus_hasil_produksi');
    Route::post('produksi/get_excel_hasilproduksi','ProduksiController@get_excel_hasilproduksi');
    Route::post('produksi/tambahng','ProduksiController@tambahng');
    Route::post('produksi/deleteng','ProduksiController@deleteng');
    Route::post('produksi/listng','ProduksiController@listng');
    Route::post('produksi/listrekap','ProduksiController@listrekap');
    Route::post('hapus/lotno_hasilproduksi', 'ProduksiController@del_lotno');
    Route::post('produksi/ceklot','ProduksiController@ceklot');
    Route::post('produksi/ngperitem','ProduksiController@ngperitem');
    Route::post('produksi/perproses','ProduksiController@perproses');
    Route::post('produksi/shikakaricamu','ProduksiController@shikakaricamu');
    Route::post('config/ng','ProduksiController@config_ng');
    Route::post('config/get_monitoring','ProduksiController@get_monitoring');
    Route::post('config/monitoring_chart','ProduksiController@monitoring_chart');

    Route::post('/mtc/getdata', 'MtcController@getdata');
    Route::post('/mtc/postcomplete', 'MtcController@postcomplete');
    Route::post('/mtc/postpending', 'MtcController@postpending');
    Route::post('/mtc/editcomplete', 'MtcController@editcomplete');
    Route::post('/mtc/posteditp', 'MtcController@posteditp');
    Route::post('/mtc/posteditc', 'MtcController@posteditc');
    Route::post('/mtc/postbatal', 'MtcController@postbatal');
    Route::post('/mtc/posteditr', 'MtcController@posteditr');
    Route::post('/mtc/postprocess', 'MtcController@postprocess');
    Route::post('/mtc/stockgudang', 'WareHouseController@stockgudang');
    Route::post('/mtc/getjadwal', 'MtcController@get_jadwal');
    Route::post('/mtc/hitungjam', 'MtcController@hitung_jam');
    Route::post('/mtc/getparts', 'MtcController@getparts');
    Route::post('/mtc/sasaranmutu', 'MtcController@sasaranmutu');

    Route::post('produksi/groupchart','ProduksiController@groupchart');
    Route::post('produksi/itemng','ProduksiController@itemng');
    Route::post('produksi/graphmonth','ProduksiController@graph_month');
    Route::post('produksi/i_approve_jam_operator','ProduksiController@i_approve_jam_operator');
    Route::post('produksi/i_approve_jam_operator_1','ProduksiController@i_approve_jam_operator_1');
    Route::post('produksi/approve_jam_kerja','ProduksiController@approve_jam_kerja');
    Route::post('produksi/edit_jamkerjaoperator','ProduksiController@edit_jamkerjaoperator');
    Route::post('produksi/getscan','ProduksiController@getscan');

    Route::post('laporan/lap_kamu','LaporanController@lap_kamu');
    Route::post('laporan/get_lap_shotkensa','LaporanController@get_lap_shotkensa');
    Route::post('laporan/get_lap_sozai','LaporanController@get_lap_sozai');
    Route::post('laporan/get_lap_kamu','LaporanController@get_lap_kamu');
    Route::post('laporan/get_lap_atari','LaporanController@get_lap_atari');
    Route::post('laporan/get_lap_gsm','LaporanController@get_lap_gsm');
    Route::post('laporan/get_lap_gsm_2x','LaporanController@get_lap_gsm_2x');
    Route::post('laporan/get_lap_gaikan','LaporanController@get_lap_gaikan');
    Route::post('produksi/get_jamkerja','LaporanController@get_jamkerja');
    Route::post('laporan/entry_jam_operator','LaporanController@entry_jam_operator');

    Route::post('grafik_hasil_operator','LapGrafikController@grafik_hasil_operator');
    Route::post('detail_hasil_jam_produksi','LapGrafikController@detail_hasil_jam_produksi');
    Route::post('detail_hasil_fcr','LapGrafikController@detail_hasil_fcr');


    Route::post('/ppic/list_master_ppic','PPICController@list_master_ppic');
    Route::post('/ppic/save_add_master','PPICController@save_add_master');
    Route::post('/ppic/edit_master','PPICController@edit_master');
    Route::post('/ppic/calculation_box','PPICController@calculation_box');

    Route::post('dhhky', 'PageController@dhhky');
    Route::post('dlokasi_hhky', 'PageController@dlokasi_hhky');
    Route::post('get_encrypt', 'PageController@get_encrypt');

    Route::post('pga/inqueryskillkaryawanbaru','PGAController@inqueryskillkaryawanbaru');
    Route::post('pga/inquerytemapelatihan','PGAController@inquerytemapelatihan');
    Route::post('pga/ajukantemabaru','PGAController@ajukantemabaru');
    Route::post('pga/form_rpk','PGAController@form_rpk');
    Route::post('pga/form_rpke','PGAController@form_rpke');
    Route::post('pga/inquery_rpke','PGAController@inquery_rpke');
    Route::post('pga/inqueryskillmatrik','PGAController@inqueryskillmatrik');
    Route::post('pga/inquerynamaskillmatrik','PGAController@inquerynamaskillmatrik');
    Route::post('pga/form_pelaksanaanpelatihan','PGAController@form_pelaksanaanpelatihan');
    Route::post('pga/list_isitujuan','PGAController@list_isitujuan');
    Route::post('pga/get_instruktur','PGAController@get_instruktur');
    Route::post('pga/form_e_pelaksanaan_ojt','PGAController@form_e_pelaksanaan_ojt');
    Route::post('pga/inquerypengajuantema','PGAController@inquerypengajuantema');
    Route::post('pga/approvetemapelatihan','PGAController@approvetemapelatihan');
    Route::post('pga/listojt_1','PGAController@listojt_1');
    Route::post('pga/listojt_approve','PGAController@listojt_approve');
    Route::post('pga/approve_pelaksanaan_ojt','PGAController@approve_pelaksanaan_ojt');
    Route::post('pga/pp_update_eksternal','PGAController@pp_update_eksternal');
    Route::post('pga/inquerypenyelenggara','PGAController@inquerypenyelenggara');
    Route::post('pga/form_ule_update','PGAController@form_ule_update');
    Route::post('pga/form_kale_update','PGAController@form_kale_update');
    Route::post('pga/komentar_atasan_lap_eksternal','PGAController@komentar_atasan_lap_eksternal');
    Route::post('pga/inquery_lap_eksternal','PGAController@inquery_lap_eksternal');
    Route::post('pga/form_estb_update','PGAController@form_estb_update');
    Route::post('pga/inquery_ln_eksternal','PGAController@inquery_ln_eksternal');
    Route::post('pga/inquery_pkwt_perpanjangan','PGAController@inquery_pkwt_perpanjangan');
    Route::post('pga/inquery_pkwt_go','PGAController@inquery_pkwt_go');
    Route::post('pga/inquery_nlp','PGAController@inquery_nlp');
    Route::post('pga/form_pkwt_go','PGAController@form_pkwt_go');
    Route::post('pga/form_pkwt_perpanjangan','PGAController@form_pkwt_perpanjangan');
    Route::post('pga/btn_up_check','PGAController@btn_up_check');
    Route::post('pga/btn_pp_check','PGAController@btn_pp_check');
    Route::post('pga/excel_pkwt','PGAController@excel_pkwt');
    Route::post('pga/inquery_penilaian_pkwt','PGAController@inquery_penilaian_pkwt');
    Route::post('pga/form_ukp','PGAController@form_ukp');
    Route::post('pga/btn_upp_ambil','PGAController@btn_upp_ambil');
    Route::post('pga/form_upp','PGAController@form_upp');
    Route::post('pga/get_penilaian_view','PGAController@get_penilaian_view');
    Route::post('pga/inquery_all_skillmatrik','PGAController@inquery_all_skillmatrik');

    Route::post('notifskill','MainController@notifskill');
    Route::post('notifdocument','MainController@notifdocument');

    Route::post('doc/add_document','DocumentController@add_document');
    Route::post('doc/list_document','DocumentController@list_document');
    Route::post('doc/lampiran_open','DocumentController@lampiran_open');
    Route::post('doc/del_attachment','DocumentController@del_attachment');
    Route::post('doc/add_attachment','DocumentController@add_attachment');
    Route::post('doc/edit_document','DocumentController@edit_document');
    Route::post('doc/upd_document','DocumentController@upd_document');
    Route::post('doc/deactivate_document','DocumentController@deactivate_document');

});
Route::post('/tokenmtc','Usercontroller@tokenMTC');
Route::post('/gettoken','Usercontroller@token');
