<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/login', function () {
 //   return view('login_page');
//});
//Route::get('/undermaintenance','PageController@under')->name('undermaintenance');
Route::get('/login', 'PageController@login')->name('login');
Route::post('/postlogin', 'Usercontroller@postlogin');
Route::post('/logout', 'Usercontroller@logout');
Route::get('/error','Usercontroller@error');

Route::middleware('CekLogin')->group(function () {
    Route::get('/','PageController@home')->name('home');
});


    Route::group(['middleware' => ['protect:Manager,Assisten Manager,Operator,Admin,Foreman,Supervisor,Administrasi,Leader,Staff,Assisten Supervisor']], function () {
       
        Route::get('/readnotif/{type}/{id}','PageController@readNotif')->name('readnotif');
        Route::get('/maintenance/schedule', 'PageController@schedule')->name('schedule');
        Route::get('/maintenance/perbaikan','PageController@list_perbaikan')->name('list_perbaikan');
        Route::get('/maintenance/input', 'PageController@perbaikan')->name('input-perbaikan');
        Route::get('/maintenance/completion/{id}', 'PageController@completion');
        Route::post('/maintenance/postcomplete', 'PerbaikanController@postcomplete');
        Route::post('/maintenance/pending', 'PerbaikanController@pending');

        Route::get('/maintenance/schedule', 'PageController@schedule');
        Route::get('/maintenance/perbaikan','PageController@list_perbaikan')->name('mtc_perbaikan');
        Route::get('/maintenance/laporan','PageController@laporan_mtc')->name('laporan_mtc');
        Route::get('/maintenance/input', 'PageController@perbaikan')->name('input-perbaikan');
        Route::get('/maintenance/mesin', 'PageController@mesin')->name('mesin');
        Route::post('/maintenance/postmesin', 'PerbaikanController@postmesin');
        Route::post('/maintenance/editmesin', 'PerbaikanController@editmesin');
        Route::post('/maintenance/delmesin', 'PerbaikanController@delmesin');
        Route::post('/maintenance/postreport', 'PerbaikanController@postreport');
        Route::get('/maintenance/history/{no_induk}', 'PageController@historymesin')->name('historymesin');
        Route::post('/maintenance/settarget', 'PerbaikanController@settarget');
        Route::post('/maintenance/addprogram', 'PerbaikanController@addprogram');

        Route::get('/produksi/input','PageController@input_produksi');
        Route::get('/produksi/report','PageController@report_produksi');
        Route::get('/produksi/NGreport','PageController@NGreport_produksi');
        Route::get('/produksi/perbaikan','PageController@req_perbaikan')->name('req_perbaikan');
        Route::get('/produksi/permintaan','PageController@permintaan')->name('req_permintaan');
        Route::post('/produksi/inputpermintaanproduksi','TechnicalController@inputpermintaanproduksi');
        Route::get('/produksi/formmasalah','MasalahController@formmasalah')->name('req_masalah');
        Route::post('/produksi/inputmasalah','MasalahController@inputmasalah');
        Route::get('/produksi/masalah/{id}','PageController@detailmasalah')->name('detailmasalah');
        Route::get('/produksi/lembur','PageController@lembur')->name('lembur');
        

        Route::post('/masalah/tindakan','MasalahController@addtindakan');
        Route::post('tindakan/update','MasalahController@updtindakan');
    
        Route::get('/ppic/target','PageController@input_target')->name('input_target');
        Route::get('/hapus/{id}','Usercontroller@hapus');
        Route::get('/test', 'PerbaikanController@testnotif');
        Route::post('/post_perbaikan', 'PerbaikanController@tambah');
        
        Route::post('/request_perbaikan','PerbaikanController@request');
        Route::post('/request_nonmesin','PerbaikanController@nonmesin');
        Route::post('/technical/inputpermintaan','TechnicalController@inputpermintaan');
        Route::get('/request/delete/{id}','PerbaikanController@del_req');

        Route::get('/technical/inquery-permintaan','TechnicalController@tampilpermintaan')->name('req_permintaan_tch');
        
        Route::get('/maintenance/listschedule', 'ScheduleController@listschedule');
        Route::get('/technical/update','TechnicalController@update')->name('tchupdate');
        Route::post('/technical/input','TechnicalController@input');
        Route::get('/technical/inquery-update','TechnicalController@inqueryupdate')->name('req_update_denpyou');
        Route::get('/technical/edit/{id_update}','TechnicalController@edit');
        //Route::post('/technical/update1','TechnicalController@update1');
        Route::get('/technical/permintaan','TechnicalController@updatepermintaan');

        Route::get('/technical/cetakpermintaan','TechnicalController@cetakpermintaan');
        Route::get('cetak_permintaan_tch/{id}', 'TechnicalController@cetak_permintaan_tch');
        Route::get('/technical/list_master','TechnicalController@list_master');

        Route::get('/ppic/workresult','PPICController@workresult')->name('update_denpyou');
        Route::get('/ppic/inqueryworkresult','PPICController@inqueryworkresult')->name('req_workresult');
        Route::get('/qa/inquery-permintaan','TechnicalController@tampilpermintaan');
        Route::get('/petunjuk','PageController@petunjuk')->name('petunjuk');
        Route::get('/userprofil','PageController@userprofil')->name('userprofil');
        Route::post('/pdfworkresult','PPICController@pdfworkresult');
        Route::get('/pga/appraisal','pgaController@appraisal')->name('list_appraisal');
        Route::get('/ppic/jam_kerusakan','PPICController@jam_kerusakan');
        Route::get('/ppic/f_calculation','PPICController@f_calculation')->name('f_calculation');

        Route::get('/pga/penilaian','DeptheadController@penilaian')->name('depthead_input_penilaian');
        Route::post('/depthead/input_penilaian','DeptheadController@input_penilaian');
        Route::get('/pga/listpenilaian','DeptheadController@listpenilaian')->name('listpenilaian');

        Route::get('/pga/listabsensi','pgaController@listabsensi');
        Route::get('/pga/employee','pgaController@employee');
        Route::get('/pga/bonus','DeptheadController@bonus')->name('depthead_input_bonus');
        Route::get('/pga/menupenilaian','DeptheadController@menupenilaian');
        Route::post('/depthead/input_bonus','DeptheadController@input_bonus');


        Route::get('/pga/PGABonus','pgaController@PGABonus')->name('list_PGABonus');
        Route::post('/ppic/input_target_produksi','PageController@input_target_produksi');

        Route::get('/pga/PGABonus','pgaController@PGABonus')->name('list_PGABonus');
        Route::post('/ppic/input_target_shikakari','PageController@input_target_shikakari');
        Route::get('/pga/absensi_upload','pgaController@absensi_upload')->name('upload');
        Route::post('/pga/import_absensi','pgaController@import_absensi');
        Route::get('/pga/template','pgaController@template');
        Route::get('/pga/skillmatrik','pgaController@skillmatrik');
        Route::get('/pga/listskillmatrik/{nik}/{nama}','pgaController@listskillmatrik')->name('listskillmatrik');
        Route::get('/pga/listnamasm','pgaController@listnamasm')->name('listnamasm');
        Route::get('/pga/lembarOJT/{id}', 'pgaController@lembarOJT');
        Route::get('/pga/listOJT', 'pgaController@listOJT')->name('listOJT');
        Route::post('/pga/upload_sertifikat','pgaController@upload_sertifikat');
        Route::get('/pga/lembar_laporan_eksternal/{id}', 'pgaController@lembar_laporan_eksternal');
        Route::get('/pga/lembar_laporan_eksternal_tiga_bulan/{id}', 'pgaController@lembar_laporan_eksternal_tiga_bulan');
        Route::get('/pga/listskilleksternal/{nik}/{nama}','pgaController@listskilleksternal')->name('listskilleksternal');
        Route::get('/pga/listpkwt','pgaController@listpkwt');
        Route::get('/pga/list_penilaian_pkwt','pgaController@list_penilaian_pkwt');
        Route::get('/pga/all_skillmatrik/{nik}/{nama}','pgaController@all_skillmatrik')->name('all_skillmatrik');

        Route::get('/iso/ssentry','ISOController@ss')->name('form_ss');
        Route::post('/iso/entryss','ISOController@entryss');
        Route::get('/iso/sslist','ISOController@sslist')->name('ss_list');
        Route::post('/insentifpdf','ISOController@insentifpdf');
        Route::get('iso/ssgrafik','ISOController@ssgrafik');
        Route::get('ssdetail/{id}','ISOController@ssdetail')->name('ss_detail');
        Route::post('/addfoto/after','ISOController@addfoto');
        Route::post('/addfoto/before','ISOController@addfotobefore');
        Route::get('/iso/sspoint','ISOController@sspoint')->name('ss_list_point');
        Route::get('ssdetailpoint/{id}','ISOController@ssdetailpoint');

        Route::get('/hse/f_hhky','HSEController@f_hhky')->name('form_hhky');
        Route::post('/hse/f_hhky','HSEController@entry_hhky');
        Route::get('/hse/hklist','HSEController@hklist')->name('hk_list');
        Route::get('hkdetail/{id}','HSEController@hhkydetail')->name('hk_detail');
        Route::post('/hse/tindakan','HSEController@addtindakan');
        Route::post('tindakanHH/update','HSEController@updtindakan');
        Route::get('hse/hhkygrafik','HSEController@hhkygrafik');
        Route::get('hse/hhkyrekap','HSEController@hhkyrekap');

        
        Route::get('/calendar','PageController@calendar')->name('calendar');

        Route::get('/produksi/menurequestjigu','JiguController@menujigu');
        Route::get('/jigu/requestjigu','JiguController@requestjigu')->name('requestjigu');
        Route::get('/produksi/formnomerinduk','JiguController@formnomerinduk')->name('formnomerinduk');
        Route::post('/produksi/tambahnomerinduk','JiguController@tambahnomerinduk');
        Route::get('cetak_permintaan_jigu/{id}', 'JiguController@permintaanpdf');
        Route::get('/qa/qamenu','JiguController@qamenu');
        Route::get('/qa/qajigu','JiguController@qajigu');
        Route::get('cetak_request_manual', 'JiguController@outofstockpdf');

        Route::post('qa/qarepair','JiguController@qarepair');
        Route::get('/qa/v_listdaichou','JiguController@v_listdaichou');
        Route::get('/qa/daichouprint','JiguController@daichouprint');

        Route::get('/produksi/inquery_report','ProduksiController@inquery_report');
        Route::get('/produksi/menu_hasil_produksi','ProduksiController@menu_hasil_produksi');
        Route::get('/produksi/grafik_hasil_produksi','LapGrafikController@grafik_hasil_produksi');
        

        Route::get('/ppic/f_master','PPICController@f_master');
        Route::post('/ppic/importexcelperhitunganbox','PPICController@importexcel_perhitunganbox');

        Route::get('/document/inquery_document','DocumentController@inquery_document');
});

Route::group(['middleware' => ['protect:Manager,Admin,Supervisor,Assisten Manager']], function () {

    Route::get('/pga/penilaianpimpinan','DeptheadController@penilaianpimpinan')->name('depthead_input_penilaian_pimpinan');
    Route::post('/depthead/input_penilaian_pimpinan','DeptheadController@input_penilaian_pimpinan');
    Route::post('/depthead/input_bonus_pimpinan','DeptheadController@input_bonus_pimpinan');
    Route::get('/pga/bonuspimpinan','DeptheadController@bonuspimpinan')->name('depthead_input_bonus_pimpinan');
});


Route::group(['middleware' => ['protect:Manager,Admin,Supervisor']], function () {
    Route::get('/admin/register','PageController@register')->name('register');
    Route::get('/admin/list-user','PageController@list_user')->name('list-user');
    Route::get('/admin/tools','PageController@tools')->name('tools');
    Route::post('/admin/deletefile','PageController@deletefile');
    Route::post('/postregister', 'Usercontroller@register');
    Route::get('/user-edit/edit/{id}','Usercontroller@edit');
    Route::post('/user-edit/update','Usercontroller@update');
    Route::get('/list-user', 'Usercontroller@listuser');
    Route::post('/technical/importexcel','TechnicalController@importexcel');
    Route::get('/admin/log', 'PageController@logs');
    Route::get('/manager/targetlembur', 'PageController@targetlembur');
    Route::post('/manager/postargetlembur', 'PageController@postargetlembur');
    Route::post('/maintenance/importmesin', 'PerbaikanController@importmesin');
    Route::post('/ss/importexcelss','ISOController@importexcel_ss');
    Route::post('/hh/importexcelhh','HSEController@importexcel_hh');
});

Route::get('/tes',function(){
    return view('tes');
});
Route::get('/about',function(){
    return view('about');
});
Route::get('/notifikasi', 'PageController@testevent');
//===========================mtc genba========================================================
Route::get('/mtc/splash','PageController@splash')->name('splash');
Route::get('/mtc/home','PageController@mtchome')->name('mtc');
Route::get('/mtc/completion/{id}', 'PageController@mtccompletion');

//===========================Produksi=========================================================
Route::get('/undermaintenance','LaporanController@undermaintenance');
Route::get('/produksi/menu_produksi','ProduksiController@menu_produksi');
Route::get('/produksi/frm_report_produksi/{tgl}/{id}/{shift}','ProduksiController@frm_report_produksi');
Route::post('/produksi/f_report_produksi', 'ProduksiController@update_laporan_produksi');
Route::get('/produksi/f_approve_jam_operator','ProduksiController@f_approve_jam_operator');

Route::get('/laporan/lap_shotkensa/{tgl}/{kode_line}/{shift}','LaporanController@lap_shotkensa');
Route::get('/laporan/lap_sozai/{tgl}/{kode_line}/{shift}','LaporanController@lap_sozai');
Route::get('/laporan/lap_kamu/{tgl}/{kode_line}/{shift}','LaporanController@lap_kamu');
Route::get('/laporan/lap_atari/{tgl}/{kode_line}/{shift}','LaporanController@lap_atari');
Route::get('/laporan/lap_gaikan/{tgl}/{kode_line}/{shift}','LaporanController@lap_gaikan');
Route::get('/laporan/lap_gsm/{tgl}/{kode_line}/{shift}','LaporanController@lap_gsm');
