@extends('layout.main')
@section('content')
    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-address-book"></i>
                        PKWT
                    </h3>
                </div>

                <blockquote class="quote-secondary">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="tb_pkwt_go">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tgl Masuk</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </blockquote>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-address-book"></i>
                        List PKWT
                    </h3>
                </div>

                <blockquote class="quote-secondary">
                    <div class="row">
                        <label class="col-md-2"> Tanggal Habis Kontrak</label>
                        <input type="month" class="form-control rounded-0 col-md-2" id="tgl_habiskontrak" value="">
                        <br>
                        <button class="btn btn-primary form-control rounded-0 col-md-1" id="btn_reload"><i
                                class="fa fa-sync"></i></button>
                    </div>
                    <hr>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-wrap" id="tb_pkwt_perpanjangan">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th style="width: 130px;">Mulai Kontrak</th>
                                    <th style="width: 130px;">Selesai Kontrak</th>
                                    <th style="width: 15px; text-align: center;">Lama Kontrak</th>
                                    <th style="width: 15px; text-align: center;">Kontrak Ke</th>
                                    <th style="width: 20px; text-align: center;">Kehadiran</th>
                                    <th style="width: 20px; text-align: center;">Keputusan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </blockquote>
                <div class="card-footer">
                    <button type="button" class="btn btn-success btn-flat" id="btn_excel">Download Excel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pkwt go -->
    <div class="modal fade" id="modal_pkwt_go" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Perjanjian Kerja Waktu Tertentu<b> (PKWT)</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_pkwt_go">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="hidden" id="up_nik" name="up_nik" class="form-control rounded-0 col-md-2">
                            <input type="text" id="up_nik1" name="up_nik1" class="form-control rounded-0 col-md-2"
                                style="color:red ; " disabled>

                            <input type="hidden" name="up_nama" id="up_nama" class="form-control rounded-0">
                            <input type="text" class="form-control col-md-10 rounded-0" name="up_nama1" id="up_nama1"
                                style="color:red ; " disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card card-secondary rounded-0">
                                    <div class="card-header rounded-0">
                                        <h3 class="card-title">Rencana Kontrak</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <strong class="col-md-3">Waktu --> Bulan</strong>
                                            <select name="up_kontrak" id="up_kontrak"
                                                style="width: 200px; border-color: crimson;"
                                                class="form-control rounded-0 select2" required>
                                                <option value="1">1 Bulan</option>
                                                <option value="3">3 Bulan</option>
                                                <option value="6">6 Bulan</option>
                                                <option value="12">12 Bulan</option>
                                                <option value="24">24 Bulan</option>
                                                <option value="36">36 Bulan</option>
                                            </select>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" id="btn_up_check"
                                                    name="btn_up_check">Check</button>
                                            </span>
                                        </div>
                                        <hr>

                                        <!-- Date range -->
                                        <div class="form-group">
                                            <label>Mulai Kontrak:</label>
                                            <label style="padding-left: 280px;">Selesai Kontrak:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="form-control rounded-0 col-md-6"
                                                    id="up_mulai" name="up_mulai">
                                                <input type="date" class="form-control rounded-0 col-md-6"
                                                    id="up_mulai1" name="up_mulai1" disabled>
                                                <input type="hidden" class="form-control rounded-0 col-md-6"
                                                    id="up_selesai" name="up_selesai" required>
                                                <input type="date" class="form-control rounded-0 col-md-6"
                                                    id="up_selesai1" name="up_selesai1"
                                                    style="color: red; font-size:large" disabled>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->


                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right btn-flat"
                                id="btn_up_update">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pkwt perpanjangan -->
    <div class="modal fade" id="modal_pkwt_perpanjangan" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Perjanjian Kerja Waktu Tertentu<b> (PKWT)</b>
                        Perpanjangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_pkwt_perpanjangan">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="hidden" id="pp_nik" name="pp_nik" class="form-control rounded-0 col-md-2">
                            <input type="text" id="pp_nik1" name="pp_nik1" class="form-control rounded-0 col-md-2"
                                style="color:red ; " disabled>

                            <input type="hidden" name="pp_nama" id="pp_nama" class="form-control rounded-0">
                            <input type="text" class="form-control col-md-10 rounded-0" name="pp_nama1"
                                id="pp_nama1" style="color:red ; " disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card card-secondary rounded-0">
                                    <div class="card-header rounded-0">
                                        <h3 class="card-title">Rencana Kontrak</h3>
                                    </div>
                                    <div class="card-body">
                                        <strong class="col-md-3">Waktu --> Bulan</strong>
                                        <strong class="col-md-3" style="padding-left: 287px;">Kontrak Lama
                                            Selesai</strong>
                                        <strong class="col-md-1" style="padding-left: 30px;">Kontrak Ke</strong>
                                        <div class="row" style="padding-left: 7px;">
                                            <select name="pp_kontrak" id="pp_kontrak"
                                                style="width: 200px; border-color: crimson; "
                                                class="form-control rounded-0 select2" required>
                                                <option value="1">1 Bulan</option>
                                                <option value="3">3 Bulan</option>
                                                <option value="6">6 Bulan</option>
                                                <option value="12">12 Bulan</option>
                                                <option value="24">24 Bulan</option>
                                                <option value="36">36 Bulan</option>
                                            </select>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" id="btn_pp_check"
                                                    name="btn_pp_check">Check</button>
                                            </span>
                                            <label for="" style="width: 150px;"> </label>
                                            <!--<input type="text" class="form-control rounded-0 col-md-3"
                                                                            name="pp_kontrak_lama" id="pp_kontrak_lama" disabled>-->
                                            <input type="date" class="form-control rounded-0 col-md-3"
                                                id="pp_kontrak_lama" name="pp_kontrak_lama"
                                                style="color: blue; font-size:large" disabled>
                                            <input type="hidden" class="form-control rounded-0 col-md-2"
                                                id="pp_kontrak_ke" name="pp_kontrak_ke"
                                                style="color: blue; font-size:large">
                                            <input type="text" class="form-control rounded-0 col-md-2"
                                                id="pp_kontrak_ke1" name="pp_kontrak_ke1"
                                                style="color: blue; font-size:large" disabled>
                                        </div>
                                        <hr>

                                        <!-- Date range -->
                                        <div class="form-group">
                                            <label>Mulai Kontrak Baru:</label>
                                            <label style="padding-left: 250px;">Selesai Kontrak Baru:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="form-control rounded-0 col-md-6"
                                                    id="pp_mulai" name="pp_mulai">
                                                <input type="date" class="form-control rounded-0 col-md-6"
                                                    id="pp_mulai1" name="pp_mulai1" style="color: red; font-size:large"
                                                    disabled>
                                                <input type="hidden" class="form-control rounded-0 col-md-6"
                                                    id="pp_selesai" name="pp_selesai" required>
                                                <input type="date" class="form-control rounded-0 col-md-6"
                                                    id="pp_selesai1" name="pp_selesai1"
                                                    style="color: red; font-size:large" disabled>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->


                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right btn-flat"
                                id="btn_pp_update">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal NIK List pkwt -->
    <div class="modal fade" id="modal_nlp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-address-book"></i> Detail NIK <b>
                            (PKWT)</b>
                    </h5>
                    <label style="padding-left: 500px; font-size: x-large; color: red;" id="nlp_nik1"
                        name="nlp_nik1"><b><u>
                                0</u></b></label>
                    <input type="hidden" id="nlp_nik" name="nlp_nik">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <blockquote class="quote-secondary">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-wrap" id="tb_nlp">
                                        <thead>
                                            <tr>
                                                <th>NIK</th>
                                                <th style="width: 250px;">Nama</th>
                                                <th style="width: 130px;">Mulai Kontrak</th>
                                                <th style="width: 130px;">Selesai Kontrak</th>
                                                <th style="width: 5px; text-align: center;">Lama Kontrak</th>
                                                <th style="width: 5px; text-align: center;">Kontrak Ke</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:center; ">Masa Kerja</th>
                                                <th colspan="2" style=" font-size: large;"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger btn-flat float-right"
                        data-dismiss="modal">Close</button>
                </div>
                <br>
            </div>
        </div>
    </div>

    <!-- Modal Update Kehadiran PKWT (ukp) -->
    <div class="modal fade" id="modal_ukp" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle" style="color:blue;"><b> Update Kehadiran
                        </b>
                        (PKWT)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form id="form_ukp" enctype="multipart/form-data">
                        @csrf

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">

                                <tbody>
                                    <tr>
                                        <td style="width:22% ;">
                                            <input type="hidden" id="ukp_idpkwt" name="ukp_idpkwt"
                                                class="form-control rounded-0 col-md-7"
                                                placeholder="Penyelenggara Pelatihan">
                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong>NIK</strong>
                                                        <label style="padding-left: 15%;"> Nama</label>
                                                        <label style="padding-left:46%">Mulai Kontrak</label>
                                                        <label style="padding-left:7%">Selesai Kontrak</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <label id="ukp_nik1" name="ukp_nik1"
                                                            style="text-align: center; color: green;"
                                                            class="form-control rounded-0 col-md-2"
                                                            placeholder="NIK"></label>
                                                        <label id="ukp_nama1" name="ukp_nama1" style="color: green;"
                                                            class="form-control rounded-0 col-md-8"
                                                            placeholder="NAMA"></label>
                                                        <label id="ukp_mulai1" name="ukp_mulai1" style="color: green;"
                                                            class="form-control rounded-0 col-md-2"
                                                            placeholder="NIK"></label>
                                                        <label id="ukp_selesai1" name="ukp_selesai1"
                                                            style="color: green;" class="form-control rounded-0 col-md-2"
                                                            placeholder="NAMA"></label>
                                                        <input type="hidden" id="ukp_nik" name="ukp_nik">
                                                        <input type="hidden" id="ukp_nama" name="ukp_nama">
                                                    </div>
                                            </dir>
                                        </td>
                                    </tr>
                                </tbody>
                            </div>
                        </div>

                        <hr>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><b>Unsur yang dinilai </b>(KPI)</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td><b>Absensi</b>
                                                <label></label><br>
                                            </td>
                                            <td
                                                style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                                <i> 5.
                                                    Tidak pernah absen <br>
                                                    4. 1 Hari <br>
                                                    3. 2 hari <br>
                                                    2. 3 sampai 4 hari <br>
                                                    1. > 5 Hari </i>
                                            </td>

                                            <td style="width:18% ;">
                                                <select id="ukp_absensi" name="ukp_absensi"
                                                    class="form-control rounded-0 col-md-10" required>
                                                    <option value="">Pilih Jawaban...</option>
                                                    <option value="5">1. Sangat Baik</option>
                                                    <option value="4">2. Baik</option>
                                                    <option value="3">3. Cukup</option>
                                                    <option value="2">4. Kurang</option>
                                                    <option value="1">5. Tidak Baik</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td><b>IMP / Telat</b>
                                                <label></label><br>
                                            </td>
                                            <td
                                                style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                                <i> 5.
                                                    Tidak pernah absen <br>
                                                    4. 1 kali karena darurat <br>
                                                    3. 2 kali karena darurat <br>
                                                    2. 3 kali karena darurat <br>
                                                    1. 4 kali karena darurat </i>
                                            </td>

                                            <td style="width:18% ;">
                                                <select id="ukp_imp" name="ukp_imp"
                                                    class="form-control rounded-0 col-md-10" required>
                                                    <option value="">Pilih Jawaban...</option>
                                                    <option value="5">1. Sangat Baik</option>
                                                    <option value="4">2. Baik</option>
                                                    <option value="3">3. Cukup</option>
                                                    <option value="2">4. Kurang</option>
                                                    <option value="1">5. Tidak Baik</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="padding-left: 83%;">
                        <button type="submit" class="btn btn-primary btn-flat" id="btn_ukp_update"><i
                                class="fa fa-floppy-o"></i> Update</button>
                        <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                                class="fa fa-sign-out"></i> Close</button>

                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                tags: true,

            })
        })

        $(document).ready(function() {

            var key = localStorage.getItem('npr_token');

            var list_pkwt_go = $('#tb_pkwt_go').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ordering: false,
                lengthChange: false,
                ajax: {
                    url: APP_URL + '/api/pga/inquery_pkwt_go',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                },
                columnDefs: [{
                    targets: [3],
                    data: null,
                    defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-flat btn-xs'>Update</button>"

                }],

                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                ],
            });

            //var tgl_sekarang = new Date();

            var list_pkwt_perpanjangan = $('#tb_pkwt_perpanjangan').DataTable({
                //destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/pga/inquery_pkwt_perpanjangan',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                    data: function(d) {
                        d.tgl_habiskontrak = $("#tgl_habiskontrak").val();
                    }
                },
                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [6],
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.nilai_kehadiran == 'Y') {
                                return "Y";
                            } else {
                                return "<button type='button' class='btn btn-block btn-outline-info btn-flat btn-xs'>Input</button>";
                            }
                        }
                    },
                    {
                        targets: [7],
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.nilai_kehadiran == 'Y') {
                                return data.keputusan;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        targets: [8],
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.keputusan == 'Lanjut') {
                                return "<button type='button' class='btn btn-outline-primary btn-flat btn-xs'>re-Contract</button> <button type='button' class='btn btn-outline-success btn-flat btn-xs'>Detail</button>";
                            } else if (data.keputusan == null || data.keputusan == '') {
                                return "<button type='button' class='btn btn-block btn-outline-success btn-flat btn-xs'>Detail</button>";
                            } else {
                                return '';
                            }
                        }
                    },
                ],

                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'mulai_kontrak',
                        name: 'mulai_kontrak'
                    },
                    {
                        data: 'selesai_kontrak',
                        name: 'selesai_kontrak'
                    },
                    {
                        data: 'lama_kontrak',
                        name: 'lama_kontrak',
                        className: 'text-center',
                    },
                    {
                        data: 'kontrak_ke',
                        name: 'kontrak_ke',
                        className: 'text-center',
                    },
                    //{ data: 'nilai_kehadiran', name: 'nilai_kehadiran', className: 'text-center', },
                    //{ data: 'keputusan', name: 'keputusan', className: 'text-center', },
                ],
                /*fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                    if (data.selesai_kontrak) {
                        $('td', nRow).css('background-color', '#ff9966');
                        $('td', nRow).css('color', 'White');
                    }
                },*/
            });

            $("#btn_reload").click(function() {
                list_pkwt_perpanjangan.ajax.reload();
            });

            $("#btn_excel").click(function() {
                var tgl_habiskontrak = $("#tgl_habiskontrak").val();
                if (tgl_habiskontrak == null || tgl_habiskontrak == '') {
                    alert('Masukkan Tanggal Habis Kontrak .');
                } else {
                    $.ajax({
                        url: APP_URL + '/api/pga/excel_pkwt',
                        headers: {
                            "token_req": key
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'tgl_habiskontrak': tgl_habiskontrak
                        },

                        success: function(response) {
                            if (response.file) {
                                var fpath = response.file;
                                window.open(fpath, '_blank');
                            } else {
                                alert(response.message);
                            }
                        }
                    })
                }
            });


            $('#tb_pkwt_go').on('click', '.btn-outline-primary', function() {
                var data = list_pkwt_go.row($(this).parents('tr')).data();
                $("#up_id").val(data.id_pkwt);
                $("#up_nik").val(data.nik);
                $("#up_nik1").val(data.nik);
                $("#up_nama").val(data.nama);
                $("#up_nama1").val(data.nama);
                $("#up_mulai").val(data.tanggal_masuk);
                $("#up_mulai1").val(data.tanggal_masuk);
                get_pkwt_go();
                $("#modal_pkwt_go").modal('show');
            });

            $('#tb_pkwt_perpanjangan').on('click', '.btn-outline-primary', function() {
                var data = list_pkwt_perpanjangan.row($(this).parents('tr')).data();
                //$("#up_id").val(data.id_pkwt);
                $("#pp_nik").val(data.nik);
                $("#pp_nik1").val(data.nik);
                $("#pp_nama").val(data.nama);
                $("#pp_nama1").val(data.nama);
                $("#pp_kontrak_lama").val(data.selesai_kontrak);
                $("#pp_kontrak_ke").val(data.kontrak_ke);
                $("#pp_kontrak_ke1").val(data.kontrak_ke);
                get_pkwt_perpanjangan();
                $("#modal_pkwt_perpanjangan").modal('show');
            });

            $('#tb_pkwt_perpanjangan').on('click', '.btn-outline-info', function() {
                var data = list_pkwt_perpanjangan.row($(this).parents('tr')).data();
                $("#ukp_idpkwt").val(data.id_pkwt);
                $("#ukp_nik1").html(data.nik);
                $("#ukp_nama1").html(data.nama);
                $("#ukp_mulai1").html(data.mulai_kontrak);
                $("#ukp_selesai1").html(data.selesai_kontrak);
                $("#ukp_nik").val(data.nik);
                $("#ukp_nama").val(data.nama);
                $("#modal_ukp").modal('show');
            });

            $('#tb_pkwt_perpanjangan').on('click', '.btn-outline-success', function() {
                var data = list_pkwt_perpanjangan.row($(this).parents('tr')).data();
                $("#nlp_nik1").html(data.nik);
                var nlp_nik = $("#nlp_nik").val(data.nik);
                get_nlp(data.nik, key);
                $("#modal_nlp").modal('show');

            });

            $("#btn_up_check").click(function() {
                //alert($("#up_kontrak").val());
                var up_kontrak = $("#up_kontrak").val();
                var up_mulai = $("#up_mulai").val();
                var up_nik = $("#up_nik").val();
                $.ajax({
                        url: APP_URL + '/api/pga/btn_up_check',
                        headers: {
                            "token_req": key
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'up_kontrak': up_kontrak,
                            'up_mulai': up_mulai,
                            'up_nik': up_nik
                        },
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            $("#up_selesai").val(resp.message);
                            $("#up_selesai1").val(resp.message);

                            $("#btn_up_update").prop('disabled', false);
                        } else {
                            alert(resp.message);
                            $("#up_selesai").val('');
                            $("#up_selesai1").val('');

                            $("#btn_up_update").prop('disabled', true);
                        }
                    })
            })

            $("#btn_pp_check").click(function() {
                //alert($("#up_kontrak").val());
                var pp_kontrak = $("#pp_kontrak").val();
                var pp_kontrak_lama = $("#pp_kontrak_lama").val();
                var pp_nik = $("#pp_nik").val();
                $.ajax({
                        url: APP_URL + '/api/pga/btn_pp_check',
                        headers: {
                            "token_req": key
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'pp_kontrak_lama': pp_kontrak_lama,
                            'pp_kontrak': pp_kontrak,
                            'pp_nik': pp_nik
                        },
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            $("#pp_selesai").val(resp.selesai);
                            $("#pp_selesai1").val(resp.selesai);

                            $("#pp_mulai").val(resp.mulai);
                            $("#pp_mulai1").val(resp.mulai);

                            $("#btn_pp_update").prop('disabled', false);
                        } else {
                            alert(resp.message);
                            $("#pp_selesai").val('');
                            $("#pp_selesai1").val('');

                            $("#btn_pp_update").prop('disabled', true);
                        }
                    })
            })

            $("#up_kontrak").on('select2:select', function() {
                $("#btn_up_update").prop('disabled', true);
            });

            $("#pp_kontrak").on('select2:select', function() {
                $("#btn_pp_update").prop('disabled', true);
            });

            $("#form_pkwt_go").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                var kontrak = $("#up_kontrak").val();
                if (kontrak == 0) {
                    alert('Masukkan Rencana Kontrak .');
                } else {
                    $.ajax({
                            url: APP_URL + '/api/pga/form_pkwt_go',
                            headers: {
                                "token_req": key
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                        })
                        .done(function(resp) {
                            if (resp.success) {

                                alert(resp.message);
                                //list_pkwt_go.ajax.reload();
                                location.reload();
                            } else {
                                alert(resp.message);
                            }
                        })
                        .fail(function() {
                            $("#error").html(
                                "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );

                        })
                        .always(function() {});
                }
            });

            $("#form_pkwt_perpanjangan").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                var kontrak = $("#pp_kontrak").val();
                if (kontrak == 0) {
                    alert('Masukkan Rencana Kontrak .');
                } else {
                    $.ajax({
                            url: APP_URL + '/api/pga/form_pkwt_perpanjangan',
                            headers: {
                                "token_req": key
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                $("#modal_pkwt_perpanjangan").modal('toggle');
                                list_pkwt_perpanjangan.ajax.reload(null, false);
                            } else {
                                alert(resp.message);
                            }
                        })
                        .fail(function() {
                            $("#error").html(
                                "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );

                        })
                        .always(function() {});
                }
            });

            $("#form_ukp").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                        url: APP_URL + '/api/pga/form_ukp',
                        headers: {
                            "token_req": key
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $("#modal_ukp").modal('toggle');
                            list_pkwt_perpanjangan.ajax.reload();
                        } else {
                            alert(resp.message);
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                        );

                    })
                    .always(function() {});
            });

        });

        function get_pkwt_go() {
            $("#up_kontrak").focus();
            $("#up_kontrak").val('').trigger('change');
            $("#up_selesai").val('');
            $("#up_selesai1").val('');
            $("#btn_up_update").prop('disabled', true);
        }

        function get_pkwt_perpanjangan() {
            $("#pp_kontrak").focus();
            $("#pp_kontrak").val('').trigger('change');
            $("#pp_mulai").val('');
            $("#pp_mulai1").val('');
            $("#pp_selesai").val('');
            $("#pp_selesai1").val('');
            $("#btn_pp_update").prop('disabled', true);
        }

        function get_nlp(nlp_nik, key) {
            var list_nlp = $('#tb_nlp').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: false,
                ordering: false,
                lengthChange: false,
                ajax: {
                    url: APP_URL + '/api/pga/inquery_nlp',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                    data: {
                        "nlp_nik": nlp_nik
                    },
                },
                columnDefs: [{
                    targets: [3],
                    data: null,
                    defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-flat btn-xs'>Update</button>"

                }, ],

                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'mulai_kontrak',
                        name: 'mulai_kontrak'
                    },
                    {
                        data: 'selesai_kontrak',
                        name: 'selesai_kontrak'
                    },
                    {
                        data: 'lama_kontrak',
                        name: 'lama_kontrak',
                        className: 'text-center'
                    },
                    {
                        data: 'kontrak_ke',
                        name: 'kontrak_ke',
                        className: 'text-center'
                    },
                ],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(1)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    Total_lama_kontrak = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    $(api.column(4).footer()).html(
                        Total_lama_kontrak.toLocaleString("en-US") + ' Bulan'
                    );

                }
            });
        }
    </script>
@endsection
