@extends('layout.main')
@section('content')

<style>
    @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
    @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);


    fieldset,
    label {
        margin: 0;
        padding: 0;
    }

    .btn:hover {
        color: darkred;
        background-color: white !important
    }
</style>


<div class="card card-outline-primary card-tabs">
    <div class="row">
        <div class="col-12" style="text-align: left; padding-left: 20px; padding-top: 5px;">
            <h5>
                <i class="fa fa-address-book"></i>
                <b><u> Standart Kompetensi & Skill Matrik </u></b>
            </h5>
        </div>
    </div>
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                    role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Lap. Internal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                    role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Internal Belum Approve</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-lapeksternal-tab" data-toggle="pill"
                    href="#custom-tabs-lapeksternal" role="tab" aria-controls="custom-tabs-one-profile"
                    aria-selected="false">Lap. Eksternal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-komeksternal-tab" data-toggle="pill"
                    href="#custom-tabs-komeksternal" role="tab" aria-controls="custom-tabs-one-profile"
                    aria-selected="false">Komentar Atasan</a>
            </li>

        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-wrap" id="tb_listojt" style="size: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Tema Pelatihan</th>
                                        <th>Lokasi</th>
                                        <th>Standar</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                aria-labelledby="custom-tabs-one-profile-tab">

                <div class="card-body table-responsive p-0">
                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_listojt_approve" style="size: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Tema Pelatihan</th>
                                        <th>Lokasi</th>
                                        <th>Standar</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>
                </div>
            </div>

            <div class="tab-pane fade" id="custom-tabs-lapeksternal" role="tabpanel"
                aria-labelledby="custom-tabs-lapeksternal-tab">

                <div class="card-body table-responsive p-0">
                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_lap_eksternal" style="size: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Materi Pelatihan</th>
                                        <th>Penyelenggara</th>
                                        <th>Lokasi Pelatihan</th>
                                        <th>Report</th>
                                        <th>Sertifikat</th>
                                        <th>Report 3 Bulan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>
                </div>
            </div>

            <div class="tab-pane fade" id="custom-tabs-komeksternal" role="tabpanel"
                aria-labelledby="custom-tabs-komeksternal-tab">

                <div class="card-body table-responsive p-0">
                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_kom_eksternal" style="size: 100%;">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th style="width: min-content;">Mulai Pelatihan</th>
                                        <th style="width: min-content;">Selesai Pelatihan</th>
                                        <th style="width: min-content;">NIK</th>
                                        <th style="width: min-content;">Nama</th>
                                        <th style="width: min-content;">Materi Pelatihan</th>
                                        <th style="width: min-content;">Penyelenggara</th>
                                        <th style="width: min-content;">Tempat Pelatihan</th>
                                        <th style="width: min-content;">Instruktur</th>
                                        <th style="width: min-content;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Approve OJT-->
<div class="modal fade" id="modal_approve_ojt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Approve Pelaksanaan OJT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_a_pelaksanaan_ojt">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-8">
                            <input type="hidden" id="a_id_rencana_pelatihan" name="a_id_rencana_pelatihan">
                            <input type="hidden" id="a_lok_pelatihan" name="a_lok_pelatihan">
                        </div>
                    </div>
                    @if(Session::get('level')=='Leader' || Session::get('level')=='Foreman' ||
                    Session::get('level')=='Ass Supervisor' || Session::get('level')=='Supervisor' ||
                    Session::get('level')=='Ass Manager')
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Diperiksa</label></div>
                        <div class="col col-md-8">
                            <input type="text" id="a_diperiksa" name="a_diperiksa" disabled>
                            <label id="a_dd" name="a_dd"></label>

                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Diperiksa</label></div>
                        <div class="col col-md-8">
                            <input type="text" id="a_diperiksa1" name="a_diperiksa1" disabled>
                            <label id="a_dd" name="a_dd" style="color: red;"> </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Disahkan</label></div>
                        <div class="col col-md-8">
                            <label for="">{{Session::get('name')}}</label>
                        </div>
                    </div>
                    @endif


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-flat" id="a_simpan" name="a_simpan"
                            value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Komentar atasan Laporan Eksternal (kale)-->
<div class="modal fade" id="modal_kale" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blue;">
                <h5 class="modal-title" id="exampleModalLongTitle" style="color:white;"><b>
                        Komentar Atasan</b>
                    (Lap. Eksternal)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_kale">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="kale_idpelatihan" name="kale_idpelatihan"
                        class="form-control rounded-0 col-md-7" placeholder="ID Pelatihan">
                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Mulai Pelatihan</strong>
                                <label style="padding-left:7%">Selesai Pelatihan</label>
                                <label style="padding-left:13%">NIK</label>
                                <label style="padding-left: 7%;"> Nama</label>
                            </div>
                            <div class="input-group">
                                <label id="kale_mulai" name="kale_mulai" style="color: green;"
                                    class="form-control rounded-0 col-md-2" placeholder="NIK"></label>
                                <label id="kale_selesai" name="kale_selesai" style="color: green;"
                                    class="form-control rounded-0 col-md-2" placeholder="NAMA"></label>
                                <label id="kale_nik" name="kale_nik" style="text-align: center; color: green;"
                                    class="form-control rounded-0 col-md-2" placeholder="NIK"></label>
                                <label id="kale_nama" name="kale_nama" style="color: green;"
                                    class="form-control rounded-0 col-md-8" placeholder="NAMA"></label>
                            </div>
                    </dir>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Penyelenggara Pelatihan</strong>
                                <label style="padding-left:43%"> Tempat Pelatihan</label>
                            </div>
                            <div class="input-group">
                                <label id="kale_penyelenggara" name="kale_penyelenggara" style="color: green;"
                                    class="form-control rounded-0 col-md-8"
                                    placeholder="Penyelenggara Pelatihan"></label>
                                <label id="kale_tempat" name="kale_tempat" style="color: green;"
                                    class="form-control rounded-0 col-md-5" placeholder="Instruktur Pelatihan"></label>
                            </div>
                        </div>
                    </dir>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Materi Pelatihan</strong>
                                <label style="padding-left:48%"> Instruktur Pelatihan</label>
                            </div>
                            <div class="input-group">
                                <label id="kale_materi" name="kale_materi" style="color: green;"
                                    class="form-control rounded-0 col-md-8"
                                    placeholder="Penyelenggara Pelatihan"></label>
                                <label id="kale_instruktur" name="kale_instruktur" style="color: green;"
                                    class="form-control rounded-0 col-md-5" placeholder="Instruktur Pelatihan"></label>
                            </div>
                        </div>
                    </dir>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col col-md-3"><label>Point Pelatihan</label></div>
                                    <label>:</label>
                                    <div class="col col-md-8">
                                        <label id="kale_poin" name="kale_poin" class="form-control rounded-0 col-md-12"
                                            style="color: green;"></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-md-3"><label>Kesan / Pendapat</label></div>
                                    <label>:</label>
                                    <div class="col col-md-8">
                                        <label id="kale_pendapat" name="kale_pendapat"
                                            class="form-control rounded-0 col-md-12" style="color: green;"></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-md-3"><label>Bentuk Pengayaan Pribadi</label></div>
                                    <label>:</label>
                                    <div class="col col-md-8">
                                        <label id="kale_bentuk_pengayaan" name="kale_bentuk_pengayaan"
                                            class="form-control rounded-0 col-md-12" style="color: green;"></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-md-3"><label>Diaplikasikan Untuk</label></div>
                                    <label>:</label>
                                    <div class="col col-md-8">
                                        <label id="kale_diaplikasikan_untuk" name="kale_diaplikasikan_untuk"
                                            class="form-control rounded-0 col-md-12" style="color: green;"></label>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </dir>
                    <hr>
                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong style="color: red;">Komentar Atasan *</strong>
                            </div>
                            <div class="input-group">
                                <!--<input type="text" id="ule_pendapat" name="ule_pendapat"
                                    class="form-control rounded-0 col-md-13"
                                    placeholder="Kesan/Pendapat tentang Pelatihan" required>-->
                                <textarea id="kale_komentar_atasan" name="kale_komentar_atasan" cols="30" rows="2"
                                    class="form-control rounded-0 col-md-13"></textarea>
                            </div>
                        </div>
                    </dir>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Sertifikat</strong>
                            </div>
                        </div>
                    </dir>

                    <hr>
                    <div class="col-md-12" style="padding-left: 83%;">
                        <button type="submit" class="btn btn-primary btn-flat" id="btn_kale_update"><i
                                class="fa fa-floppy-o"></i> Update</button>
                        <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                                class="fa fa-sign-out"></i> Close</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload sertifikat-->
<div class="modal fade" id="modal_us" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Upload Sertifikat</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form_us" enctype="multipart/form-data" name="form_us" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="form-control" id="file_us" name="file_us">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <input type="hidden" id="us_idpelatihan" name="us_idpelatihan" value="">

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="btn_update_us" name="btn_update_us"
                            value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Evaluasi setelah tiga bulan (estb)-->
<div class="modal fade" id="modal_estb" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blue;">
                <h5 class="modal-title" id="exampleModalLongTitle" style="color:white;"><b>
                        Evaluasi setelah tiga Bulan</b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_estb">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="estb_idpelatihan" name="estb_idpelatihan"
                        class="form-control rounded-0 col-md-7" placeholder="ID Pelatihan">
                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Mulai Pelatihan</strong>
                                <label style="padding-left:7%">Selesai Pelatihan</label>
                                <label style="padding-left:13%">NIK</label>
                                <label style="padding-left: 7%;"> Nama</label>
                            </div>
                            <div class="input-group">
                                <label id="estb_mulai" name="estb_mulai" style="color: green;"
                                    class="form-control rounded-0 col-md-2" placeholder="NIK"></label>
                                <label id="estb_selesai" name="estb_selesai" style="color: green;"
                                    class="form-control rounded-0 col-md-2" placeholder="NAMA"></label>
                                <label id="estb_nik" name="estb_nik" style="text-align: center; color: green;"
                                    class="form-control rounded-0 col-md-2" placeholder="NIK"></label>
                                <label id="estb_nama" name="estb_nama" style="color: green;"
                                    class="form-control rounded-0 col-md-8" placeholder="NAMA"></label>
                            </div>
                    </dir>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Penyelenggara Pelatihan</strong>
                                <label style="padding-left:43%"> Tempat Pelatihan</label>
                            </div>
                            <div class="input-group">
                                <label id="estb_penyelenggara" name="estb_penyelenggara" style="color: green;"
                                    class="form-control rounded-0 col-md-8"
                                    placeholder="Penyelenggara Pelatihan"></label>
                                <label id="estb_tempat" name="estb_tempat" style="color: green;"
                                    class="form-control rounded-0 col-md-5" placeholder="Instruktur Pelatihan"></label>
                            </div>
                        </div>
                    </dir>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Materi Pelatihan</strong>
                                <label style="padding-left:48%"> Instruktur Pelatihan</label>
                            </div>
                            <div class="input-group">
                                <label id="estb_materi" name="estb_materi" style="color: green;"
                                    class="form-control rounded-0 col-md-8"
                                    placeholder="Penyelenggara Pelatihan"></label>
                                <label id="estb_instruktur" name="estb_instruktur" style="color: green;"
                                    class="form-control rounded-0 col-md-5" placeholder="Instruktur Pelatihan"></label>
                            </div>
                        </div>
                    </dir>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b><i style="color: red;">*</i> Evaluasi Pelatihan setelah tiga bulan
                                    : </b></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Ada Peningkatan skill setelah mengikuti training ?
                                            <label></label><br>
                                        </td>

                                        <td style="width:60% ;">
                                            <select id="estb_ada_peningkatan" name="estb_ada_peningkatan"
                                                class="form-control rounded-0 col-md-5" required>
                                                <option value="">Pilih Jawaban...</option>
                                                <option value="Y">1. Ya</option>
                                                <option value="T">2. Tidak</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Skill kompetensi <b>Sebelum</b> mengikuti training ?
                                            <label></label><br>
                                        </td>

                                        <td style="width:22% ;">
                                            <textarea name="estb_skill_sebelum" id="estb_skill_sebelum" cols="110"
                                                rows="1" class="form-control rounded-0" required></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Skill kompetensi <b>Sesudah</b> mengikuti training ?
                                            <label></label><br>
                                        </td>

                                        <td style="width:22% ;">
                                            <textarea name="estb_skill_sesudah" id="estb_skill_sesudah" cols="110"
                                                rows="1" class="form-control rounded-0" required></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td style="font-size: 13px;">Apakah hasil pelatihan dapat bermanfaat untuk
                                            pekerjaan ? dan <br>
                                            Apakah dapat dijadikan referensi ilmu pengetahuan ?
                                            <label></label><br>
                                        </td>

                                        <td style="width:22% ;">
                                            <textarea name="estb_hasil_pelatihan" id="estb_hasil_pelatihan" cols="110"
                                                rows="1" class="form-control rounded-0" required></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Saran / Usulan ?
                                            <label></label><br>
                                        </td>

                                        <td style="width:22% ;">
                                            <textarea name="estb_usulan" id="estb_usulan" cols="110" rows="1"
                                                class="form-control rounded-0"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>
                    <div class="col-md-12" style="padding-left: 83%;">
                        <button type="submit" class="btn btn-primary btn-flat" id="btn_estb_update"><i
                                class="fa fa-floppy-o"></i> Update</button>
                        <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                                class="fa fa-sign-out"></i> Close</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    var $star_rating = $('.star-rating .fa');

    var SetRatingStar = function () {
        return $star_rating.each(function () {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };

    $star_rating.on('click', function () {
        $star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });

    SetRatingStar();

    $(document).ready(function () {

        var key = localStorage.getItem('npr_token');

        var listojt = $('#tb_listojt').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/pga/listojt_1',
                type: "POST",
                headers: { "token_req": key },
                //data: { 'nik': nik, 'nama': nama, },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [7],
                data: null,
                width: '17%',
                render: function (data, type, row, meta) {
                    if (data.level_pelatihan == 4 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button> <button class='btn-warning'><i class='fa fa-star'>4</i></button>";
                    } else if (data.level_pelatihan == 3 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button>";
                    } else if (data.level_pelatihan == 2 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button>";
                    } else if (data.level_pelatihan == 1 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button>";
                    } else if (data.level_pelatihan == 4 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button> <button class='btn-warning'><i class='fa fa-star'>4</i></button>";
                    } else if (data.level_pelatihan == 3 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button>";
                    } else if (data.level_pelatihan == 2 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button>";
                    } else if (data.level_pelatihan == 1 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button>";
                    } else if (data.level_pelatihan == 4 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button> <button class='btn-success'><i class='fa fa-star'>3</i></button> <button class='btn-success'><i class='fa fa-star'>4</i></button>";
                    } else if (data.level_pelatihan == 3 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button> <button class='btn-success'><i class='fa fa-star'>3</i></button>";
                    } else if (data.level_pelatihan == 2 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button>";
                    } else if (data.level_pelatihan == 1 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button>";
                    }
                }
            },
            {
                targets: [8],
                data: null,
                width: '3%',
                render: function (data, type, row, meta) {
                    if (data.status_pelatihan == 'Rencana') {
                        return "Evaluasi";
                    } else if (data.status_pelatihan == 'Tercapai') {
                        return "<button type='button' class='btn btn-block btn-outline-success btn-sm btn-flat'>OJT</button>";
                    } else if (data.status_pelatihan == 'Belum Approve') {
                        return "<button type='button' class='btn btn-block btn-info btn-sm btn-flat'>Approve</button>";
                    }
                }

            },
            ],

            columns: [
                { data: 'id_rencana_pelatihan', name: 'id_rencana_pelatihan' },
                { data: 'nik', name: 'nik', width: '2%' },
                { data: 'nama', name: 'nama', width: '15%' },
                { data: 'kategori', name: 'kategori', width: '12%' },
                { data: 'tema_pelatihan', name: 'tema_pelatihan' },
                { data: 'loc_pelatihan', name: 'loc_pelatihan', width: '15%' },
                { data: 'standar', name: 'standar', Text: 'center', width: '1%' },
                //{ data: 'level_pelatihan', name: 'level_pelatihan' },

            ],
        });

        var listojt_approve = $('#tb_listojt_approve').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            autoWidth: false,
            ajax: {
                url: APP_URL + '/api/pga/listojt_approve',
                type: "POST",
                headers: { "token_req": key },
                //data: { 'nik': nik, 'nama': nama, },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [7],
                data: null,
                width: '17%',
                render: function (data, type, row, meta) {
                    if (data.level_pelatihan == 4 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button> <button class='btn-warning'><i class='fa fa-star'>4</i></button>";
                    } else if (data.level_pelatihan == 3 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button>";
                    } else if (data.level_pelatihan == 2 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button>";
                    } else if (data.level_pelatihan == 1 && data.status_pelatihan == 'Rencana') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button>";
                    } else if (data.level_pelatihan == 4 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button> <button class='btn-warning'><i class='fa fa-star'>4</i></button>";
                    } else if (data.level_pelatihan == 3 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button>";
                    } else if (data.level_pelatihan == 2 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button>";
                    } else if (data.level_pelatihan == 1 && data.status_pelatihan == 'Belum Approve') {
                        return "<button class='btn-warning'><i class='fa fa-star'>1</i></button>";
                    } else if (data.level_pelatihan == 4 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button> <button class='btn-success'><i class='fa fa-star'>3</i></button> <button class='btn-success'><i class='fa fa-star'>4</i></button>";
                    } else if (data.level_pelatihan == 3 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button> <button class='btn-success'><i class='fa fa-star'>3</i></button>";
                    } else if (data.level_pelatihan == 2 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button>";
                    } else if (data.level_pelatihan == 1 && data.status_pelatihan == 'Tercapai') {
                        return "<button class='btn-success'><i class='fa fa-star'>1</i></button>";
                    }
                }
            },
            {
                targets: [8],
                data: null,
                width: '3%',
                render: function (data, type, row, meta) {
                    if (data.status_pelatihan == 'Rencana') {
                        return "Evaluasi";
                    } else if (data.status_pelatihan == 'Tercapai') {
                        return "<button type='button' class='btn btn-block btn-outline-success btn-sm btn-flat'>OJT</button>";
                    } else if (data.status_pelatihan == 'Belum Approve') {
                        return "<button type='button' class='btn btn-block btn-outline-info btn-sm btn-flat'>Approve</button>";
                    }
                }

            },
            ],

            columns: [
                { data: 'id_rencana_pelatihan', name: 'id_rencana_pelatihan' },
                { data: 'nik', name: 'nik', width: '2%' },
                { data: 'nama', name: 'nama', width: '12%' },
                { data: 'kategori', name: 'kategori', width: '12%' },
                { data: 'tema_pelatihan', name: 'tema_pelatihan' },
                { data: 'loc_pelatihan', name: 'loc_pelatihan', width: '15%' },
                { data: 'standar', name: 'standar', Text: 'center', width: '1%' },
                //{ data: 'level_pelatihan', name: 'level_pelatihan' },

            ],
        });

        var tglnow = (new Date()).toISOString().split('T')[0];
        //alert(tglnow);
        var list_lap_eksternal = $('#tb_lap_eksternal').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/pga/inquery_lap_eksternal',
                type: "POST",
                headers: { "token_req": key },
                //data: { 'nik': nik, 'nama': nama, },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [6],
                data: null,
                width: '3%',
                render: function (data, type, row, meta) {
                    /*if (data.status_pelatihan == 'Close') {
                        return "Evaluasi";
                    } else */
                    if (data.keterangan == 'cutoff' && data.status_pelatihan == 'Close' ) {
                        return "-";
                    } else {
                        return "<button type='button' class='btn btn-block btn-outline-success btn-xs btn-flat'>View</button>";
                    }
                }

            },
            {
                targets: [7],
                data: null,
                width: '3%',
                render: function (data, type, row, meta) {
                    if (data.lampiran_sertifikat == null || data.lampiran_sertifikat == '') {
                        return "<button class='btn btn-block btn-outline-secondary btn-xs btn-flat'><i class='fa fa-upload'> Upload Sertifikat</i></button>";
                    } else {
                        return "<button class='btn btn-block btn-outline-info btn-xs btn-flat'><i class='fas fa-paperclip mr-2'> View</i></button>";
                    }
                }

            },
            {
                targets: [8],
                data: null,
                width: '3%',
                render: function (data, type, row, meta) {
                    if (data.tri_wulan == 'Y') {
                        return "<button class='btn btn-block btn-outline-primary btn-xs btn-flat'> View</button>";
                    } else if (data.tri_wulan == 'N' && tglnow > data.tempo_tri_wulan) {
                        return "<button class='btn btn-block btn-outline-danger btn-xs btn-flat'> Evaluasi 3 bln</button>";
                    } else {
                        return "";
                    }
                }

            },
            ],

            columns: [
                { data: 'id_pelatihan_eksternal', name: 'id_pelatihan_eksternal' },
                { data: 'nik', name: 'nik', width: '2%' },
                { data: 'nama', name: 'nama', width: '15%' },
                { data: 'materi_pelatihan', name: 'materi_pelatihan' },
                { data: 'penyelenggara', name: 'penyelenggara' },
                { data: 'tempat_pelatihan', name: 'tempat_pelatihan', class: 'text-center' },
                //{ data: 'level_pelatihan', name: 'level_pelatihan' },

            ],
        });

        var list_kom_eksternal = $('#tb_kom_eksternal').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/pga/komentar_atasan_lap_eksternal',
                type: "POST",
                headers: { "token_req": key },
                //data: { 'nik': nik, 'nama': nama, },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [9],
                data: null,
                //defaultContent: "<button class='btn btn-success'>Complited</button>"
                render: function (data, type, row, meta) {
                    if (data.status_pelatihan == 'Komen Atasan') {
                        return "<button class='btn btn-primary btn-xs'>Komentar</button>";
                    }
                }
            },
            ],
            columns: [
                { data: 'id_pelatihan_eksternal', name: 'id_pelatihan_eksternal' },
                { data: 'tgl_pelatihan', name: 'tgl_pelatihan' },
                { data: 'sampai', name: 'sampai' },
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'materi_pelatihan', name: 'materi_pelatihan' },
                { data: 'penyelenggara', name: 'penyelenggara' },
                { data: 'tempat_pelatihan', name: 'tempat_pelatihan', class: 'text-center' },
                { data: 'instruktur', name: 'instruktur' },
            ],
        });

        $('#tb_lap_eksternal').on('click', '.btn-outline-success', function () {
            var data = list_lap_eksternal.row($(this).parents('tr')).data();
            window.open(APP_URL + "/pga/lembar_laporan_eksternal/" + data.id_pelatihan_eksternal, '_blank');
        });

        $("#tb_lap_eksternal").on('click', '.btn-outline-secondary', function () {
            var data = list_lap_eksternal.row($(this).parents('tr')).data();
            //alert(data.id_pelatihan_eksternal);
            $("#us_idpelatihan").val(data.id_pelatihan_eksternal)
            $("#modal_us").modal('show');
        });

        $("#tb_lap_eksternal").on('click', '.btn-outline-primary', function () {
            var data = list_lap_eksternal.row($(this).parents('tr')).data();
            window.open(APP_URL + "/pga/lembar_laporan_eksternal_tiga_bulan/" + data.id_pelatihan_eksternal, '_blank');
        });

        $("#tb_lap_eksternal").on('click', '.btn-outline-danger', function () {
            var data = list_lap_eksternal.row($(this).parents('tr')).data();
            //alert(data.id_pelatihan_eksternal);
            $("#estb_idpelatihan").val(data.id_pelatihan_eksternal)
            $("#estb_mulai").html(data.tgl_pelatihan);
            $("#estb_selesai").html(data.sampai);
            $("#estb_nik").html(data.nik);
            $("#estb_nama").html(data.nama);
            $("#estb_penyelenggara").html(data.penyelenggara);
            $("#estb_tempat").html(data.tempat_pelatihan);
            $("#estb_materi").html(data.materi_pelatihan);
            $("#estb_instruktur").html(data.instruktur);
            $("#modal_estb").modal('show');
        });

        $("#form_us").submit(function (e) {
            e.preventDefault();
            var datas = new FormData(this);
            $.ajax({
                type: "POST",
                url: APP_URL + "/pga/upload_sertifikat",

                data: datas,
                processData: false,
                contentType: false,
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert(resp.message);
                        $("#modal_us").modal('toggle');
                        list_lap_eksternal.ajax.reload();
                    } else {
                        list_lap_eksternal.ajax.reload();
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                });
        });

        $("#form_estb").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url: APP_URL + '/api/pga/form_estb_update',
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
                        //location.reload();
                        $('#modal_estb').modal('toggle');
                        list_lap_eksternal.ajax.reload();
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

        $("#tb_lap_eksternal").on('click', '.btn-outline-info', function () {
            var data = list_lap_eksternal.row($(this).parents('tr')).data();

            var fpath = APP_URL + "/storage/img/pga/sertifikat/" + data.lampiran_sertifikat;
            window.open(fpath, '_blank');
        });

        $('#tb_listojt_approve').on('click', '.btn-outline-info', function () {
            var data_approve = listojt_approve.row($(this).parents('tr')).data();
            $("#a_id_rencana_pelatihan").val(data_approve.id_rencana_pelatihan);
            $("#a_lok_pelatihan").val(data_approve.loc_pelatihan);
            $("#a_diperiksa").val('');
            $("#a_diperiksa1").val('');
            $("#a_dd").html('');

            if ((data_approve.diperiksa) == null || (data_approve.diperiksa) == '') {
                $("#a_dd").html('Kolom diperiksa Masih Kosong .');
            } else {
                $("#a_diperiksa").val(data_approve.diperiksa);
                $("#a_diperiksa1").val(data_approve.diperiksa);
            }

            $('#modal_approve_ojt').modal('show');
        });

        $("#form_a_pelaksanaan_ojt").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url: APP_URL + '/api/pga/approve_pelaksanaan_ojt',
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
                        //location.reload();
                        listojt_approve.ajax.reload();
                        $('#modal_approve_ojt').modal('toggle');
                    } else {
                        alert(resp.message);
                    }
                })

                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        $('#tb_listojt').on('click', '.btn-outline-success', function () {
            var data = listojt.row($(this).parents('tr')).data();
            window.open(APP_URL + "/pga/lembarOJT/" + data.id_rencana_pelatihan, '_blank');
        });

        $('#tb_kom_eksternal').on('click', '.btn-primary', function () {
            var kom_eksternal = list_kom_eksternal.row($(this).parents('tr')).data();
            $("#kale_idpelatihan").val(kom_eksternal.id_pelatihan_eksternal);
            $("#kale_mulai").html(kom_eksternal.tgl_pelatihan);
            $("#kale_selesai").html(kom_eksternal.sampai);
            $("#kale_nik").html(kom_eksternal.nik);
            $("#kale_nama").html(kom_eksternal.nama);
            $("#kale_penyelenggara").html(kom_eksternal.penyelenggara);
            $("#kale_tempat").html(kom_eksternal.tempat_pelatihan);
            $("#kale_materi").html(kom_eksternal.materi_pelatihan);
            $("#kale_instruktur").html(kom_eksternal.instruktur);
            $("#kale_poin").html(kom_eksternal.poin_pelatihan);
            $("#kale_pendapat").html(kom_eksternal.pendapat);
            $("#kale_bentuk_pengayaan").html(kom_eksternal.bentuk_pengayaan);
            $("#kale_diaplikasikan_untuk").html(kom_eksternal.diaplikasikan_untuk);
            /*$("#a_lok_pelatihan").val(data_approve.loc_pelatihan);
            $("#a_diperiksa").val('');
            $("#a_diperiksa1").val('');
            $("#a_dd").html('');*/

            $('#modal_kale').modal('show');
        });

        $("#form_kale").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var kale_komentar_atasan = $("#kale_komentar_atasan").val();
            if (kale_komentar_atasan == null || kale_komentar_atasan == '') {
                alert('Kolom Komentar harus terpenuhi !');
            } else {
                $.ajax({
                    url: APP_URL + '/api/pga/form_kale_update',
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
                            //location.reload();
                            $('#modal_kale').modal('toggle');
                            list_kom_eksternal.ajax.reload();
                            list_lap_eksternal.ajax.reload();
                        }
                        else
                            alert(resp.message);
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    })
                    .always(function () {
                    });
            }
        });


    });




</script>

@endsection