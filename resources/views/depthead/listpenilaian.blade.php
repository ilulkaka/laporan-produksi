@extends('layout.main')
@section('content')

<div class="card card-olive card-tabs">
    <div class="card-header p-0 pt-1">
        <!--  <h4 style="text-align: center;">List Penilaian Kinerja</h4> -->
        <div class="row">
            <div class="col-md-6"></div>
            <h5>LIST PENILAIAN</h5>

        </div>
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                    role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Karyawan Umum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                    role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Leader Up</a>
            </li>

        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">

                <div class="row align-center">
                    <div class="row text-center">
                        <label for="" class="col-md-3 ">Periode</label>
                        <input type="month" class="form-control col-md-7" id="periode" value="{{date('Y-m').'-01'}}">
                        <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
                <br>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_appraisal">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Periode</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>Dandori</th>
                                <th>Kecepatan</th>
                                <th>Ketelitian</th>
                                <th>Improvement</th>
                                <th>Sikap kerja</th>
                                <th>Penyelesaian Masalah</th>
                                <th>HO.REN.SO</th>
                                <th>Pengetahuan</th>
                                <th>Keputusan</th>
                                <th>Ekspresi</th>
                                <th>Perencanaan</th>
                                <th>Respon</th>
                                <th>Kedisiplinan</th>
                                <th>KerjaSama</th>
                                <th>Antusiasme</th>
                                <th>Tanggung Jawab</th>
                                <th>Penilai</th>
                                <th>Disetujui</th>
                                <th>Action</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                aria-labelledby="custom-tabs-one-profile-tab">

                <div class="row align-center">
                    <div class="row text-center">
                        <label for="" class="col-md-3 ">Periode</label>
                        <input type="month" class="form-control col-md-7" id="periode_1" value="{{date('Y-m').'-01'}}">
                        <button class="btn btn-primary" id="btn_reload_1"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
                <br>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_appraisal_1">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Periode</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>Keselamatan</th>
                                <th>Kualitas</th>
                                <th>Biaya</th>
                                <th>Pengiriman</th>
                                <th>Penjualan</th>
                                <th>Progres</th>
                                <th>Improvement</th>
                                <th>Prob Solv</th>
                                <th>Motivasi</th>
                                <th>HORENSO</th>
                                <th>Koordinasi</th>
                                <th>Pengetahuan</th>
                                <th>Keputusan</th>
                                <th>Perencanaan</th>
                                <th>Negosiasi</th>
                                <th>Respon</th>
                                <th>Kedisiplinan</th>
                                <th>KerjaSama</th>
                                <th>Antusiasme</th>
                                <th>tanggung_jawab</th>
                                <th>Penilai</th>
                                <th>Disetujui</th>
                                <th>Action</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-pink card-tabs">
    <div class="card-header p-0 pt-1">
        <!-- <h4 style="text-align: center;">List Penilaian BONUS</h4> -->
        <div class="row">
            <div class="col-md-6"></div>
            <h5>LIST PENILAIAN BONUS</h5>

        </div>
        <ul class="nav nav-tabs" id="custom-tabs-one-tab-bonus" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab-bonus" data-toggle="pill"
                    href="#custom-tabs-one-home-bonus" role="tab" aria-controls="custom-tabs-one-home"
                    aria-selected="true">Bonus Karyawan Umum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab-bonus" data-toggle="pill"
                    href="#custom-tabs-one-profile-bonus" role="tab" aria-controls="custom-tabs-one-profile"
                    aria-selected="false">Bonus Leader Up</a>
            </li>

        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent-bonus">
            <div class="tab-pane fade active show" id="custom-tabs-one-home-bonus" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">

                <div class="row align-center">
                    <div class="row text-center">
                        <label for="" class="col-md-3 ">Periode</label>
                        <input type="month" class="form-control col-md-7" id="periode_bonus" value="{{date('Y-m')}}">
                        <button class="btn btn-primary" id="btn_reload_bonus"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
                <br>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_appraisal_bonus">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Periode</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>Dandori</th>
                                <th>Kecepatan</th>
                                <th>Ketelitian</th>
                                <th>Improvement</th>
                                <th>Sikap kerja</th>
                                <th>Penyelesaian Masalah</th>
                                <th>HO.REN.SO</th>
                                <th>Kedisiplinan</th>
                                <th>KerjaSama</th>
                                <th>Antusiasme</th>
                                <th>Tanggung Jawab</th>
                                <th>Penilai</th>
                                <th>Disetujui</th>
                                <th>Action</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile-bonus" role="tabpanel"
                aria-labelledby="custom-tabs-one-profile-tab">

                <div class="row align-center">
                    <div class="row text-center">
                        <label for="" class="col-md-3 ">Periode</label>
                        <input type="month" class="form-control col-md-7" id="periode_bonus_1" value="{{date('Y-m')}}">
                        <button class="btn btn-primary" id="btn_reload_bonus_1"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
                <br>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_appraisal_bonus_1">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Periode</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Departemen</th>
                                <th>Keselamatan</th>
                                <th>Kualitas</th>
                                <th>Biaya</th>
                                <th>Pengiriman</th>
                                <th>Penjualan</th>
                                <th>Kedisiplinan</th>
                                <th>KerjaSama</th>
                                <th>Antusiasme</th>
                                <th>tanggung_jawab</th>
                                <th>Penilai</th>
                                <th>Disetujui</th>
                                <th>Action</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Edit Penilaian Karyawan Umum-->
<div class="modal fade" id="edit-modal-penilaian-karyawan-umum" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-appraisal">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit-appraisal" name="edit-appraisal">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="edit-nik" name="edit-nik"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="edit-nama" name="edit-nama"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="edit-departemen" name="edit-departemen"></label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Dandori :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-dandori" name="edit-dandori" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kecepatan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-kecepatan" name="edit-kecepatan" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Ketelitian :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-ketelitian" name="edit-ketelitian" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Improvement :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-improvement" name="edit-improvement" min="1" max="5" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Sikap kerja :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-sikap_kerja" name="edit-sikap_kerja" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Penyelesaian masalah :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-penyelesaian_masalah" name="edit-penyelesaian_masalah" min="1"
                                max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Horenso :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-horenso" name="edit-horenso" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Pengetahuan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-pengetahuan" name="edit-pengetahuan" min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Keputusan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-keputusan" name="edit-keputusan" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Ekspresi :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-ekspresi" name="edit-ekspresi" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Perencanaan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-perencanaan" name="edit-perencanaan" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Respon :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-respon" name="edit-respon" min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Kedisiplinan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-kedisiplinan" name="edit-kedisiplinan" min="1" max="5"
                                disabled>
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kerjasama :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-kerjasama" name="edit-kerjasama" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Antusiasme :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-antusiasme" name="edit-antusiasme" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Tanggung jawab :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-tanggung_jawab" name="edit-tanggung_jawab" min="1" max="5">
                        </div>
                    </div>



                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Approval Karyawan Umum-->
<div class="modal fade" id="modal-approval-karyawan-umum" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Approve Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-approval-appraisal">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="approve-appraisal" name="approve-appraisal">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="approve-nik" name="approve-nik"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="approve-nama" name="approve-nama"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="approve-departemen" name="approve-departemen"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div style=" color: maroon; font-weight: inherit; text-align: center; margin-top: 20px;"
                            class="col col-md-12">
                            <label>Grade</label>
                            <br>
                            <label style="font-size:60px; color: maroon; margin-top: 0px;" id="approve-grade"
                                name="approve-grade"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Edit Penilaian Leader Up-->
<div class="modal fade" id="edit-modal-penilaian-leaderup" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-appraisal-1">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit-appraisal-1" name="edit-appraisal-1">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="edit-nik-1" name="edit-nik-1"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="edit-nama-1" name="edit-nama-1"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="edit-departemen-1" name="edit-departemen-1"></label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Keselamatan :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-keselamatan-1" name="edit-keselamatan-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kualitas :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-kualitas-1" name="edit-kualitas-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Biaya :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-biaya-1" name="edit-biaya-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Pengiriman :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-pengiriman-1" name="edit-pengiriman-1" min="1" max="5">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Penjualan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-penjualan-1" name="edit-penjualan-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kontrol Progres :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-kontrol_progres-1" name="edit-kontrol_progres-1" min="1"
                                max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Improvement :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-improvement-1" name="edit-improvement-1" min="1" max="5"
                                disabled>
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Penyelesaian masalah :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-penyelesaian_masalah-1" name="edit-penyelesaian_masalah-1"
                                min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Motivasi Bawahan :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-motivasi_bawahan-1" name="edit-motivasi_bawahan-1" min="1"
                                max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Horenso :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-horenso-1" name="edit-horenso-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Koordinasi Pekerjaan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-koordinasi_pekerjaan-1" name="edit-koordinasi_pekerjaan-1"
                                min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Pengetahuan :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-pengetahuan-1" name="edit-pengetahuan-1" min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Keputusan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-keputusan-1" name="edit-keputusan-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Perencanaan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-perencanaan-1" name="edit-perencanaan-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Negosiasi :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-negosiasi-1" name="edit-negosiasi-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Respon :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-respon-1" name="edit-respon-1" min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Kedisiplinan :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="edit-kedisiplinan-1" name="edit-kedisiplinan-1" min="1" max="5"
                                disabled>
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kerjasama :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-kerjasama-1" name="edit-kerjasama-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Antusiasme :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-antusiasme-1" name="edit-antusiasme-1" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Tanggung jawab :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="edit-tanggung_jawab-1" name="edit-tanggung_jawab-1" min="1"
                                max="5">
                        </div>
                    </div>



                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Approval Leader Up-->
<div class="modal fade" id="modal-approval-leaderup" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Approve Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-approval-appraisal-1">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="approve-appraisal-1" name="approve-appraisal-1">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="approve-nik-1" name="approve-nik-1"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="approve-nama-1" name="approve-nama-1"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="approve-departemen-1" name="approve-departemen-1"></label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div style=" color: maroon; font-weight: inherit; text-align: center; margin-top: 20px;"
                            class="col col-md-12">
                            <label>Grade</label>
                            <br>
                            <label style="font-size:60px; color: maroon; margin-top: 0px;" id="approve-grade-1"
                                name="approve-grade-1"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Edit Penilaian Bonus Umum-->
<div class="modal fade" id="edit-modal-penilaian-bonus-umum" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-bonus">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="eb-appraisal-bonus" name="eb-appraisal-bonus">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="eb-nik" name="eb-nik"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="eb-nama" name="eb-nama"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="eb-departemen" name="eb-departemen"></label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Dandori :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-dandori" name="eb-dandori" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kecepatan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-kecepatan" name="eb-kecepatan" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Ketelitian :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-ketelitian" name="eb-ketelitian" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Improvement :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="eb-improvement" name="eb-improvement" min="1" max="5" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Sikap kerja :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-sikap_kerja" name="eb-sikap_kerja" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Penyelesaian masalah :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-penyelesaian_masalah" name="eb-penyelesaian_masalah" min="1"
                                max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Horenso :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-horenso" name="eb-horenso" min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Kedisiplinan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-kedisiplinan" name="eb-kedisiplinan" min="1" max="5" disabled>
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kerjasama :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-kerjasama" name="eb-kerjasama" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Antusiasme :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-antusiasme" name="eb-antusiasme" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Tanggung jawab :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="eb-tanggung_jawab" name="eb-tanggung_jawab" min="1" max="5">
                        </div>
                    </div>



                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Approval Bonus Umum-->
<div class="modal fade" id="modal-approval-bonus-umum" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Approve Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-approval-bonus">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="ab-appraisal" name="ab-appraisal">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="ab-nik" name="ab-nik"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="ab-nama" name="ab-nama"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="ab-departemen" name="ab-departemen"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div style=" color: maroon; font-weight: inherit; text-align: center; margin-top: 20px;"
                            class="col col-md-12">
                            <label>Grade</label>
                            <br>
                            <label style="font-size:60px; color: maroon; margin-top: 0px;" id="ab-grade"
                                name="ab-grade"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Edit Penilaian Bonus Leader-->
<div class="modal fade" id="edit-modal-penilaian-bonus-leader" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-bonus-leader">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="ebl-appraisal-bonus" name="ebl-appraisal-bonus">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="ebl-nik" name="ebl-nik"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="ebl-nama" name="ebl-nama"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="ebl-departemen" name="ebl-departemen"></label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Keselamatan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-keselamatan" name="ebl-keselamatan" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kualitas :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-kualitas" name="ebl-kualitas" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Biaya :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-biaya" name="ebl-biaya" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Pengiriman :</label></div>
                        <div class="col col-md-2">
                            <input type="number" id="ebl-pengiriman" name="ebl-pengiriman" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Penjualan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-penjualan" name="ebl-penjualan" min="1" max="5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-1" style="font-size: small;"><label>Kedisiplinan :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-kedisiplinan" name="ebl-kedisiplinan" min="1" max="5" disabled>
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Kerjasama :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-kerjasama" name="ebl-kerjasama" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Antusiasme :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-antusiasme" name="ebl-antusiasme" min="1" max="5">
                        </div>
                        <div class="col col-md-1" style="font-size: small;"><label>Tanggung jawab :</label></div>

                        <div class="col col-md-2">
                            <input type="number" id="ebl-tanggung_jawab" name="ebl-tanggung_jawab" min="1" max="5">
                        </div>
                    </div>



                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Approval Bonus Leader-->
<div class="modal fade" id="modal-approval-bonus-leader" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Approve Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-approval-bonus-leader">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="abl-appraisal" name="abl-appraisal">
                    <div class="row">
                        <div class="col col-md-3"><label>NIK</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="abl-nik" name="abl-nik"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Nama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="abl-nama" name="abl-nama"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Departemen</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="abl-departemen" name="abl-departemen"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div style=" color: maroon; font-weight: inherit; text-align: center; margin-top: 20px;"
                            class="col col-md-12">
                            <label>Grade</label>
                            <br>
                            <label style="font-size:60px; color: maroon; margin-top: 0px;" id="abl-grade"
                                name="abl-grade"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var list_penilaian = $('#tb_appraisal').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,

            ajax: {
                url: APP_URL + '/api/inquerypenilaian',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode = $("#periode").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [24],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null) {
                        return "<button class='btn btn-success'><i class='fa fa-edit'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            {
                targets: [25],
                data: null,
                render: function (data, type, row, meta) {

                    if (data.disetujui == null) {
                        return "<button class='btn btn-secondary'><i class='fa fa-check-circle'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            ],
            columns: [
                { data: 'id_appraisal', name: 'id_appraisal' },
                { data: 'periode', name: 'periode' },
                { data: 'nik', name: 'NIK' },
                { data: 'nama', name: 'nama' },
                { data: 'STATUS_KARYAWAN', name: 'STATUS_KARYAWAN' },
                { data: 'departemen', name: 'departemen' },
                { data: 'dandori', name: 'dandori' },
                { data: 'kecepatan', name: 'kecepatan' },
                { data: 'ketelitian', name: 'ketelitian' },
                { data: 'improvement', name: 'improvement' },
                { data: 'sikap_kerja', name: 'sikap_kerja' },
                { data: 'penyelesaian_masalah', name: 'penyelesaian_masalah' },
                { data: 'horenso', name: 'horenso' },
                { data: 'pengetahuan', name: 'pengetahuan' },
                { data: 'keputusan', name: 'keputusan' },
                { data: 'ekspresi', name: 'ekspresi' },
                { data: 'perencanaan', name: 'perencanaan' },
                { data: 'respon', name: 'respon' },
                { data: 'kedisiplinan', name: 'kedisiplinan' },
                { data: 'kerjasama', name: 'kerjasama' },
                { data: 'antusiasme', name: 'antusiasme' },
                { data: 'tanggung_jawab', name: 'tanggung_jawab' },
                { data: 'penilai', name: 'penilai' },
                { data: 'disetujui', name: 'disetujui' },
            ]
        });

        $("#btn_reload").click(function () {
            list_penilaian.ajax.reload();
        });

        $('#tb_appraisal').on('click', '.btn-success', function () {
            var data = list_penilaian.row($(this).parents('tr')).data();
            $("#edit-appraisal").val(data.id_appraisal);
            $("#edit-nik").html(data.nik);
            $("#edit-nama").html(data.nama);
            $("#edit-departemen").html(data.departemen);
            $("#edit-dandori").val(data.dandori);
            $("#edit-kecepatan").val(data.kecepatan);
            $("#edit-ketelitian").val(data.ketelitian);
            $("#edit-improvement").val(data.improvement);
            $("#edit-sikap_kerja").val(data.sikap_kerja);
            $("#edit-penyelesaian_masalah").val(data.penyelesaian_masalah);
            $("#edit-horenso").val(data.horenso);
            $("#edit-pengetahuan").val(data.pengetahuan);
            $("#edit-keputusan").val(data.keputusan);
            $("#edit-ekspresi").val(data.ekspresi);
            $("#edit-perencanaan").val(data.perencanaan);
            $("#edit-respon").val(data.respon);
            $("#edit-kedisiplinan").val(data.kedisiplinan);
            $("#edit-kerjasama").val(data.kerjasama);
            $("#edit-antusiasme").val(data.antusiasme);
            $("#edit-tanggung_jawab").val(data.tanggung_jawab);
            $('#edit-modal-penilaian-karyawan-umum').modal('show');
        });

        $("#form-edit-appraisal").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/edit_penilaian_umum',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                        $("#edit-modal-penilaian-karyawan-umum").modal('toggle');
                        list_penilaian.ajax.reload();
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $('#tb_appraisal').on('click', '.btn-secondary', function () {
            var data = list_penilaian.row($(this).parents('tr')).data();
            var grade1 = grade(data);
            $("#approve-appraisal").val(data.id_appraisal);
            $("#approve-nik").html(data.nik);
            $("#approve-nama").html(data.nama);
            $("#approve-departemen").html(data.departemen);
            $("#approve-grade").html(grade1);
            $('#modal-approval-karyawan-umum').modal('show');
        });


        $("#form-approval-appraisal").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/approval_penilaian_umum',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                        $("#modal-approval-karyawan-umum").modal('toggle');
                        list_penilaian.ajax.reload();
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });


        var key = localStorage.getItem('npr_token');
        var list_penilaian_1 = $('#tb_appraisal_1').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,

            ajax: {
                url: APP_URL + '/api/inquerypenilaianpimpinan',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode_1 = $("#periode_1").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [28],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null) {
                        return "<button class='btn btn-success'><i class='fa fa-edit'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            {
                targets: [29],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null) {
                        return "<button class='btn btn-secondary'><i class='fa fa-check-circle'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            ],
            columns: [
                { data: 'id_appraisal', name: 'id_appraisal' },
                { data: 'periode', name: 'periode' },
                { data: 'nik', name: 'NIK' },
                { data: 'nama', name: 'nama' },
                { data: 'STATUS_KARYAWAN', name: 'STATUS_KARYAWAN' },
                { data: 'departemen', name: 'departemen' },
                { data: 'keselamatan', name: 'keselamatan' },
                { data: 'kualitas', name: 'kualitas' },
                { data: 'biaya', name: 'biaya' },
                { data: 'pengiriman', name: 'pengiriman' },
                { data: 'penjualan', name: 'penjualan' },
                { data: 'kontrol_progres', name: 'kontrol_progres' },
                { data: 'improvement', name: 'improvement' },
                { data: 'penyelesaian_masalah', name: 'penyelesaian_masalah' },
                { data: 'motivasi_bawahan', name: 'motivasi_bawahan' },
                { data: 'horenso', name: 'horenso' },
                { data: 'koordinasi_pekerjaan', name: 'koordinasi_pekerjaan' },
                { data: 'pengetahuan', name: 'pengetahuan' },
                { data: 'keputusan', name: 'keputusan' },
                { data: 'perencanaan', name: 'perencanaan' },
                { data: 'negosiasi', name: 'negosiasi' },
                { data: 'respon', name: 'respon' },
                { data: 'kedisiplinan', name: 'kedisiplinan' },
                { data: 'kerjasama', name: 'kerjasama' },
                { data: 'antusiasme', name: 'antusiasme' },
                { data: 'tanggung_jawab', name: 'tanggung_jawab' },
                { data: 'penilai', name: 'penilai' },
                { data: 'disetujui', name: 'disetujui' },
            ]
        });

        $("#btn_reload_1").click(function () {
            list_penilaian_1.ajax.reload();
        });

        $('#tb_appraisal_1').on('click', '.btn-success', function () {
            var data = list_penilaian_1.row($(this).parents('tr')).data();
            $("#edit-appraisal-1").val(data.id_appraisal);
            $("#edit-nik-1").html(data.nik);
            $("#edit-nama-1").html(data.nama);
            $("#edit-departemen-1").html(data.departemen);
            $("#edit-keselamatan-1").val(data.keselamatan);
            $("#edit-kualitas-1").val(data.kualitas);
            $("#edit-biaya-1").val(data.biaya);
            $("#edit-pengiriman-1").val(data.pengiriman);
            $("#edit-penjualan-1").val(data.penjualan);
            $("#edit-kontrol_progres-1").val(data.kontrol_progres);
            $("#edit-improvement-1").val(data.improvement);
            $("#edit-penyelesaian_masalah-1").val(data.penyelesaian_masalah);
            $("#edit-motivasi_bawahan-1").val(data.motivasi_bawahan);
            $("#edit-horenso-1").val(data.horenso);
            $("#edit-koordinasi_pekerjaan-1").val(data.koordinasi_pekerjaan);
            $("#edit-pengetahuan-1").val(data.pengetahuan);
            $("#edit-keputusan-1").val(data.keputusan);
            $("#edit-perencanaan-1").val(data.perencanaan);
            $("#edit-negosiasi-1").val(data.negosiasi);
            $("#edit-respon-1").val(data.respon);
            $("#edit-kedisiplinan-1").val(data.kedisiplinan);
            $("#edit-kerjasama-1").val(data.kerjasama);
            $("#edit-antusiasme-1").val(data.antusiasme);
            $("#edit-tanggung_jawab-1").val(data.tanggung_jawab);
            $('#edit-modal-penilaian-leaderup').modal('show');
        });

        $("#form-edit-appraisal-1").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/edit_penilaian_leaderup',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                        $("#edit-modal-penilaian-leaderup").modal('toggle');
                        list_penilaian_1.ajax.reload();
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $('#tb_appraisal_1').on('click', '.btn-secondary', function () {
            var data = list_penilaian_1.row($(this).parents('tr')).data();
            var grade2 = grade_leader(data);
            $("#approve-appraisal-1").val(data.id_appraisal);
            $("#approve-nik-1").html(data.nik);
            $("#approve-nama-1").html(data.nama);
            $("#approve-departemen-1").html(data.departemen);
            $("#approve-grade-1").html(grade2);
            $('#modal-approval-leaderup').modal('show');
        });

        $("#form-approval-appraisal-1").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/approval_penilaian_leaderup',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        list_penilaian_1.ajax.reload();
                        $('#modal-approval-leaderup').modal('hide');
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        var list_penilaian_bonus = $('#tb_appraisal_bonus').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,

            ajax: {
                url: APP_URL + '/api/inquerypenilaianbonus',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode_bonus = $("#periode_bonus").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [19],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null || data.disetujui == "") {
                        return "<button class='btn btn-success'><i class='fa fa-edit'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            {
                targets: [20],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null || data.disetujui == "") {
                        return "<button class='btn btn-secondary'><i class='fa fa-check-circle'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            ],
            columns: [
                { data: 'id_appraisal', name: 'id_appraisal' },
                { data: 'periode', name: 'periode' },
                { data: 'nik', name: 'NIK' },
                { data: 'nama', name: 'nama' },
                { data: 'STATUS_KARYAWAN', name: 'STATUS_KARYAWAN' },
                { data: 'departemen', name: 'departemen' },
                { data: 'dandori', name: 'dandori' },
                { data: 'kecepatan', name: 'kecepatan' },
                { data: 'ketelitian', name: 'ketelitian' },
                { data: 'improvement', name: 'improvement' },
                { data: 'sikap_kerja', name: 'sikap_kerja' },
                { data: 'penyelesaian_masalah', name: 'penyelesaian_masalah' },
                { data: 'horenso', name: 'horenso' },
                { data: 'kedisiplinan', name: 'kedisiplinan' },
                { data: 'kerjasama', name: 'kerjasama' },
                { data: 'antusiasme', name: 'antusiasme' },
                { data: 'tanggung_jawab', name: 'tanggung_jawab' },
                { data: 'penilai', name: 'penilai' },
                { data: 'disetujui', name: 'disetujui' },
            ]
        });

        $('#tb_appraisal_bonus').on('click', '.btn-success', function () {
            var data = list_penilaian_bonus.row($(this).parents('tr')).data();
            $("#eb-appraisal-bonus").val(data.id_appraisal);
            $("#eb-nik").html(data.nik);
            $("#eb-nama").html(data.nama);
            $("#eb-departemen").html(data.departemen);
            $("#eb-dandori").val(data.dandori);
            $("#eb-kecepatan").val(data.kecepatan);
            $("#eb-ketelitian").val(data.ketelitian);
            $("#eb-improvement").val(data.improvement);
            $("#eb-sikap_kerja").val(data.sikap_kerja);
            $("#eb-penyelesaian_masalah").val(data.penyelesaian_masalah);
            $("#eb-horenso").val(data.horenso);
            $("#eb-kedisiplinan").val(data.kedisiplinan);
            $("#eb-kerjasama").val(data.kerjasama);
            $("#eb-antusiasme").val(data.antusiasme);
            $("#eb-tanggung_jawab").val(data.tanggung_jawab);
            $('#edit-modal-penilaian-bonus-umum').modal('show');
        });

        $("#form-edit-bonus").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/edit_bonus_umum',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        $("#edit-modal-penilaian-bonus-umum").modal('toggle');
                        list_penilaian_bonus.ajax.reload();
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $('#tb_appraisal_bonus_1').on('click', '.btn-success', function () {
            var data = list_penilaian_bonus_1.row($(this).parents('tr')).data();
            $("#ebl-appraisal-bonus").val(data.id_appraisal);
            $("#ebl-nik").html(data.nik);
            $("#ebl-nama").html(data.nama);
            $("#ebl-departemen").html(data.departemen);
            $("#ebl-keselamatan").val(data.keselamatan);
            $("#ebl-kualitas").val(data.kualitas);
            $("#ebl-biaya").val(data.biaya);
            $("#ebl-pengiriman").val(data.pengiriman);
            $("#ebl-penjualan").val(data.penjualan);
            $("#ebl-kedisiplinan").val(data.kedisiplinan);
            $("#ebl-kerjasama").val(data.kerjasama);
            $("#ebl-antusiasme").val(data.antusiasme);
            $("#ebl-tanggung_jawab").val(data.tanggung_jawab);
            $('#edit-modal-penilaian-bonus-leader').modal('show');
        });

        $('#tb_appraisal_bonus').on('click', '.btn-secondary', function () {
            var data = list_penilaian_bonus.row($(this).parents('tr')).data();
            var gradebonus = grade_bonus(data);
            $("#ab-appraisal").val(data.id_appraisal);
            $("#ab-nik").html(data.nik);
            $("#ab-nama").html(data.nama);
            $("#ab-departemen").html(data.departemen);
            $("#ab-grade").html(gradebonus);
            $('#modal-approval-bonus-umum').modal('show');
        });

        $("#form-approval-bonus").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/approval_bonus_umum',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        $("#modal-approval-bonus-umum").modal('toggle');
                        list_penilaian_bonus.ajax.reload();
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $('#tb_appraisal_bonus_1').on('click', '.btn-secondary', function () {
            var data = list_penilaian_bonus_1.row($(this).parents('tr')).data();
            var gradebonus = grade_bonus_leader(data);
            $("#abl-appraisal").val(data.id_appraisal);
            $("#abl-nik").html(data.nik);
            $("#abl-nama").html(data.nama);
            $("#abl-departemen").html(data.departemen);
            $("#abl-grade").html(gradebonus);
            $('#modal-approval-bonus-leader').modal('show');
        });

        $("#form-approval-bonus-leader").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/approval_bonus_leader',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        $("#modal-approval-bonus-leader").modal('toggle');
                        list_penilaian_bonus_1.ajax.reload();
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $("#btn_reload_bonus").click(function () {
            list_penilaian_bonus.ajax.reload();
        });

        var list_penilaian_bonus_1 = $('#tb_appraisal_bonus_1').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,

            ajax: {
                url: APP_URL + '/api/inquerybonuspimpinan',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode_bonus_1 = $("#periode_bonus_1").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [17],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null) {
                        return "<button class='btn btn-success'><i class='fa fa-edit'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            {
                targets: [18],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.disetujui == null) {
                        return "<button class='btn btn-secondary'><i class='fa fa-check-circle'></i></button>"
                    } else {
                        return " ";
                    }
                }
            },
            ],
            columns: [
                { data: 'id_appraisal', name: 'id_appraisal' },
                { data: 'periode', name: 'periode' },
                { data: 'nik', name: 'NIK' },
                { data: 'nama', name: 'nama' },
                { data: 'STATUS_KARYAWAN', name: 'STATUS_KARYAWAN' },
                { data: 'departemen', name: 'departemen' },
                { data: 'keselamatan', name: 'keselamatan' },
                { data: 'kualitas', name: 'kualitas' },
                { data: 'biaya', name: 'biaya' },
                { data: 'pengiriman', name: 'pengiriman' },
                { data: 'penjualan', name: 'penjualan' },
                { data: 'kedisiplinan', name: 'kedisiplinan' },
                { data: 'kerjasama', name: 'kerjasama' },
                { data: 'antusiasme', name: 'antusiasme' },
                { data: 'tanggung_jawab', name: 'tanggung_jawab' },
                { data: 'penilai', name: 'penilai' },
                { data: 'disetujui', name: 'disetujui' },
            ]
        });

        $("#form-edit-bonus-leader").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            //alert('tst');

            $.ajax({
                url: APP_URL + '/api/edit_bonus_leader',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        $("#edit-modal-penilaian-bonus-leader").modal('toggle');
                        list_penilaian_bonus_1.ajax.reload();
                        //window.location.href = APP_URL + '/pga/listpenilaian';
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $("#btn_reload_bonus_1").click(function () {
            list_penilaian_bonus_1.ajax.reload();
        });

    });

    function grade(data) {

        if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (40 / 100) * 20) + ((parseFloat(data.pengetahuan) / 1) * (10 / 100) * 20) + (((parseFloat(data.keputusan) + parseInt(data.ekspresi) + parseInt(data.perencanaan) + parseInt(data.respon)) / 4) * (10 / 100) * 20) + (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 86) {
            return "S";
        } else if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (40 / 100) * 20) + ((parseFloat(data.pengetahuan) / 1) * (10 / 100) * 20) + (((parseFloat(data.keputusan) + parseInt(data.ekspresi) + parseInt(data.perencanaan) + parseInt(data.respon)) / 4) * (10 / 100) * 20) + (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 71) {
            return "A";
        } else if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (40 / 100) * 20) + ((parseFloat(data.pengetahuan) / 1) * (10 / 100) * 20) + (((parseFloat(data.keputusan) + parseInt(data.ekspresi) + parseInt(data.perencanaan) + parseInt(data.respon)) / 4) * (10 / 100) * 20) + (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 51) {
            return "B";
        } else if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (40 / 100) * 20) + ((parseFloat(data.pengetahuan) / 1) * (10 / 100) * 20) + (((parseFloat(data.keputusan) + parseInt(data.ekspresi) + parseInt(data.perencanaan) + parseInt(data.respon)) / 4) * (10 / 100) * 20) + (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 35) {
            return "C";
        } else {
            return "D";
        }

        /*  if ((((parseFloat(data.dandori + data.kecepatan + data.ketelitian + data.improvement + data.sikap_kerja + data.penyelesaian_masalah + data.horenso) / 7) * (40 / 100) * 20) + ((parseFloat(data.pengetahuan) / 1) * (10 / 100) * 20) + ((parseFloat(data.keputusan + data.ekspresi + data.perencanaan + data.respon) / 4) * (10 / 100) * 20) + ((parseFloat(data.kedisiplinan + data.kerjasama + data.antusiasme + data.tanggung_jawab) / 4) * (40 / 100) * 20)) >= 15) {
              return "Lebih";
          } else {
              return "kurang";
          } */

        /* return (parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab));
          */
    }

    function grade_leader(data) {

        if ((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (30 / 100) * 20) +
            (((parseFloat(data.kontrol_progres) + parseInt(data.improvement) + parseInt(data.penyelesaian_masalah) + parseInt(data.motivasi_bawahan) + parseInt(data.horenso) + parseInt(data.koordinasi_pekerjaan)) / 6) * (25 / 100) * 20) +
            ((parseFloat(data.pengetahuan) / 1) * (5 / 100) * 20) +
            (((parseFloat(data.keputusan) + parseInt(data.perencanaan) + parseInt(data.negosiasi) + parseInt(data.respon)) / 4) * (10 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (30 / 100) * 20)
            >= 86) {
            return "S";
        } else if ((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (30 / 100) * 20) +
            (((parseFloat(data.kontrol_progres) + parseInt(data.improvement) + parseInt(data.penyelesaian_masalah) + parseInt(data.motivasi_bawahan) + parseInt(data.horenso) + parseInt(data.koordinasi_pekerjaan)) / 6) * (25 / 100) * 20) +
            ((parseFloat(data.pengetahuan) / 1) * (5 / 100) * 20) +
            (((parseFloat(data.keputusan) + parseInt(data.perencanaan) + parseInt(data.negosiasi) + parseInt(data.respon)) / 4) * (10 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (30 / 100) * 20)
            >= 71) {
            return "A";
        } else if ((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (30 / 100) * 20) +
            (((parseFloat(data.kontrol_progres) + parseInt(data.improvement) + parseInt(data.penyelesaian_masalah) + parseInt(data.motivasi_bawahan) + parseInt(data.horenso) + parseInt(data.koordinasi_pekerjaan)) / 6) * (25 / 100) * 20) +
            ((parseFloat(data.pengetahuan) / 1) * (5 / 100) * 20) +
            (((parseFloat(data.keputusan) + parseInt(data.perencanaan) + parseInt(data.negosiasi) + parseInt(data.respon)) / 4) * (10 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (30 / 100) * 20)
            >= 51) {
            return "B";
        } else if ((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (30 / 100) * 20) +
            (((parseFloat(data.kontrol_progres) + parseInt(data.improvement) + parseInt(data.penyelesaian_masalah) + parseInt(data.motivasi_bawahan) + parseInt(data.horenso) + parseInt(data.koordinasi_pekerjaan)) / 6) * (25 / 100) * 20) +
            ((parseFloat(data.pengetahuan) / 1) * (5 / 100) * 20) +
            (((parseFloat(data.keputusan) + parseInt(data.perencanaan) + parseInt(data.negosiasi) + parseInt(data.respon)) / 4) * (10 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (30 / 100) * 20)
            >= 35) {
            return "C";
        } else {
            return "D";
        }
    }

    function grade_bonus(data) {

        if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 86) {
            return "S";
        } else if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 71) {
            return "A";
        } else if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 51) {
            return "B";
        } else if (((((parseFloat(data.dandori) + parseInt(data.kecepatan) + parseInt(data.ketelitian) + parseInt(data.improvement) + parseInt(data.sikap_kerja) + parseInt(data.penyelesaian_masalah) + parseInt(data.horenso)) / 7) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 35) {
            return "C";
        } else {
            return "D";
        }
    }

    function grade_bonus_leader(data) {

        if (((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 86) {
            return "S";
        } else if (((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 71) {
            return "A";
        } else if (((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 51) {
            return "B";
        } else if (((((parseFloat(data.keselamatan) + parseInt(data.kualitas) + parseInt(data.biaya) + parseInt(data.pengiriman) + parseInt(data.penjualan)) / 5) * (60 / 100) * 20) +
            (((parseFloat(data.kedisiplinan) + parseInt(data.kerjasama) + parseInt(data.antusiasme) + parseInt(data.tanggung_jawab)) / 4) * (40 / 100) * 20)) >= 35) {
            return "C";
        } else {
            return "D";
        }
    }


</script>

@endsection