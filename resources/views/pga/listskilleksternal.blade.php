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

    <section class="content">
        <div class="container-fluid">
            <div class="row">


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-address-book"></i>
                                Standart Kompetensi & Skill Matrik <b style="color: blue"> </b>
                            </h3>
                            <h4 class="float-right">
                                <u>{{ $nik }} / {{ $nama }}</u>
                            </h4>
                        </div>
                        <!-- /.card-header -->

                        <blockquote class="quote-secondary">
                            <div class="card-body table-responsive p-0">
                                <table id="tb_report_pelatihan_eksternal" class="table table-hover text-wrap"
                                    style="width:100%">
                                    <!--<table id="tb_listtema" class="table table-bordered table-hover text-nowrap ">-->
                                    <thead>
                                        <th>id</th>
                                        <th style="width: min-content;">Mulai Pelatihan</th>
                                        <th style="width: min-content;">Selesai Pelatihan</th>
                                        <th style="width: min-content;">NIK</th>
                                        <th style="width: min-content;">Nama</th>
                                        <th style="width: min-content;">Materi Pelatihan</th>
                                        <th style="width: min-content;">Penyelenggara</th>
                                        <th style="width: min-content;">Tempat Pelatihan</th>
                                        <th style="width: min-content;">Instruktur</th>
                                        <th style="width: min-content;">Report</th>
                                        <th style="width: min-content;">Sertifikat</th>
                                    </thead>
                                </table>
                            </div>

                        </blockquote>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>

            </div>
        </div>
    </section>

    <!-- Modal Update Laporan Eksternal (ule) -->
    <div class="modal fade" id="modal_ule" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle" style="color:blue;"><b> Update Laporan</b>
                        (Eksternal)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form id="form_ule" enctype="multipart/form-data">
                        @csrf

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">

                                <tbody>
                                    <tr>
                                        <td style="width:22% ;">

                                            <input type="hidden" id="ule_idpelatihan" name="ule_idpelatihan"
                                                class="form-control rounded-0 col-md-7"
                                                placeholder="Penyelenggara Pelatihan">
                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong>Mulai Pelatihan</strong>
                                                        <label style="padding-left:7%">Selesai Pelatihan</label>
                                                        <label style="padding-left:13%">NIK</label>
                                                        <label style="padding-left: 7%;"> Nama</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <label id="ule_mulai" name="ule_mulai" style="color: green;"
                                                            class="form-control rounded-0 col-md-2"
                                                            placeholder="NIK"></label>
                                                        <label id="ule_selesai" name="ule_selesai" style="color: green;"
                                                            class="form-control rounded-0 col-md-2"
                                                            placeholder="NAMA"></label>
                                                        <label id="ule_nik" name="ule_nik"
                                                            style="text-align: center; color: green;"
                                                            class="form-control rounded-0 col-md-2"
                                                            placeholder="NIK"></label>
                                                        <label id="ule_nama" name="ule_nama" style="color: green;"
                                                            class="form-control rounded-0 col-md-8"
                                                            placeholder="NAMA"></label>
                                                    </div>
                                            </dir>

                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong>Penyelenggara Pelatihan</strong>
                                                        <label style="padding-left:43%"> Tempat Pelatihan</label>
                                                    </div>
                                                    <div class="input-group">
                                                        <label id="ule_penyelenggara" name="ule_penyelenggara"
                                                            style="color: green;" class="form-control rounded-0 col-md-8"
                                                            placeholder="Penyelenggara Pelatihan"></label>
                                                        <label id="ule_tempat" name="ule_tempat" style="color: green;"
                                                            class="form-control rounded-0 col-md-5"
                                                            placeholder="Instruktur Pelatihan"></label>
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
                                                        <label id="ule_materi" name="ule_materi" style="color: green;"
                                                            class="form-control rounded-0 col-md-8"
                                                            placeholder="Penyelenggara Pelatihan"></label>
                                                        <label id="ule_instruktur" name="ule_instruktur"
                                                            style="color: green;" class="form-control rounded-0 col-md-5"
                                                            placeholder="Instruktur Pelatihan"></label>
                                                    </div>
                                                </div>
                                            </dir>

                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong style="color: red;">Point Pelatihan *</strong>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" id="ule_poin" name="ule_poin"
                                                            class="form-control rounded-0 col-md-13"
                                                            placeholder="Poin Pelatihan" required>
                                                    </div>
                                                </div>
                                            </dir>
                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong style="color: red;">Kesan / Pendapat *</strong>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" id="ule_pendapat" name="ule_pendapat"
                                                            class="form-control rounded-0 col-md-13"
                                                            placeholder="Kesan/Pendapat tentang Pelatihan" required>
                                                    </div>
                                                </div>
                                            </dir>
                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong style="color: red;">Bentuk Pengayaan Pribadi *</strong>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" id="ule_bentuk_pengayaan"
                                                            name="ule_bentuk_pengayaan"
                                                            class="form-control rounded-0 col-md-13"
                                                            placeholder="Bentuk Pengayaan Pribadi dengan Pelatihan yang anda ikuti ."
                                                            required>
                                                    </div>
                                                </div>
                                            </dir>
                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong style="color: red;">Diaplikasikan Untuk *</strong>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" id="ule_diaplikasikan_untuk"
                                                            name="ule_diaplikasikan_untuk"
                                                            class="form-control rounded-0 col-md-13"
                                                            placeholder="Trining yang dilakukan akan diaplikasikan untuk apa, siapa ?"
                                                            required>
                                                    </div>
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
                                <h3 class="card-title"><b>Evaluasi Pelatihan : </b>Pilih Jawaban yang sesuai</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Pelatihan yang diberikan sesuai dengan kebutuhan sehari-hari :
                                                <label></label><br>
                                            </td>

                                            <td style="width:22% ;">
                                                <select id="ule_kebutuhan" name="ule_kebutuhan"
                                                    class="form-control rounded-0 col-md-12" required>
                                                    <option value="">Pilih Jawaban...</option>
                                                    <option value="Sangat sesuai">1. Sangat sesuai</option>
                                                    <option value="Sesuai">2. Sesuai</option>
                                                    <option value="Kurang sesuai">3. Kurang sesuai</option>
                                                    <option value="Tidak sesuai">4. Tidak sesuai</option>
                                                    <option value="Sangat tidak sesuai">5. Sangat tidak sesuai</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Metode dan alat bantu pelatihan yang digunakan :
                                                <label></label><br>
                                            </td>

                                            <td style="width:22% ;">
                                                <select id="ule_metode" name="ule_metode"
                                                    class="form-control rounded-0 col-md-12" required>
                                                    <option value="">Pilih Jawaban...</option>
                                                    <option value="Sangat sesuai">1. Sangat sesuai</option>
                                                    <option value="Sesuai">2. Sesuai</option>
                                                    <option value="Kurang sesuai">3. Kurang sesuai</option>
                                                    <option value="Tidak sesuai">4. Tidak sesuai</option>
                                                    <option value="Sangat tidak sesuai">5. Sangat tidak sesuai</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Pemahaman pengajar terhadap materi yang diberikan :
                                                <label></label><br>
                                            </td>

                                            <td style="width:22% ;">
                                                <select id="ule_pemahaman" name="ule_pemahaman"
                                                    class="form-control rounded-0 col-md-12" required>
                                                    <option value="">Pilih Jawaban...</option>
                                                    <option value="Sangat sesuai">1. Sangat sesuai</option>
                                                    <option value="Sesuai">2. Sesuai</option>
                                                    <option value="Kurang sesuai">3. Kurang sesuai</option>
                                                    <option value="Tidak sesuai">4. Tidak sesuai</option>
                                                    <option value="Sangat tidak sesuai">5. Sangat tidak sesuai</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Cara pengajar mengajar/menjelaskan materi kepada peserta pelatihan :
                                                <label></label><br>
                                            </td>

                                            <td style="width:22% ;">
                                                <select id="ule_pengajar" name="ule_pengajar"
                                                    class="form-control rounded-0 col-md-12" required>
                                                    <option value="">Pilih Jawaban...</option>
                                                    <option value="Sangat sesuai">1. Sangat sesuai</option>
                                                    <option value="Sesuai">2. Sesuai</option>
                                                    <option value="Kurang sesuai">3. Kurang sesuai</option>
                                                    <option value="Tidak sesuai">4. Tidak sesuai</option>
                                                    <option value="Sangat tidak sesuai">5. Sangat tidak sesuai</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">

                                <tbody>
                                    <tr>
                                        <td style="width:22% ;">
                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong style="color: red;">5. Kelebihan dan kekurangan program
                                                            pelatihan : *</strong>
                                                    </div>
                                                    <div class="input-group" style="padding-left: 10%;">
                                                        <textarea name="ule_kelebihan" id="ule_kelebihan" cols="130" class="form-control rounded-0" rows="1"
                                                            placeholder="Kelebihan" required></textarea>
                                                    </div>
                                                    <div class="input-group" style="padding-left: 10%;">
                                                        <textarea name="ule_kekurangan" id="ule_kekurangan" cols="130" class="form-control rounded-0" rows="1"
                                                            placeholder="Kekurangan" required></textarea>
                                                    </div>
                                                </div>
                                            </dir>

                                            <dir class="form-group" style="padding-left: 1%;">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <strong style="color: red;">6. Saran - saran dari peserta untuk
                                                            perbaikan : *</strong>
                                                    </div>
                                                    <div class="input-group" style="padding-left: 10%;">
                                                        <textarea name="ule_saran" id="ule_saran" cols="130" class="form-control rounded-0" rows="1"
                                                            placeholder="Saran"></textarea>
                                                    </div>
                                                </div>
                                            </dir>
                                        </td>
                                    </tr>
                                </tbody>

                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="padding-left: 83%;">
                        <button type="submit" class="btn btn-primary btn-flat" id="btn_ule_update"><i
                                class="fa fa-floppy-o"></i> Update</button>
                        <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                                class="fa fa-sign-out"></i> Close</button>

                    </div>
                    </form>

                </div>
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
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });

        $(document).ready(function() {

            var key = localStorage.getItem('npr_token');

            var segments = window.location.href.split('/');
            var difsegment = segments.reverse()
            var nik = difsegment[1];
            var nama = difsegment[0];

            var list_rpke = $('#tb_report_pelatihan_eksternal').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/pga/inquery_rpke',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                    data: {
                        'nik': nik,
                        'nama': nama,
                    },
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
                        render: function(data, type, row, meta) {
                            if (data.keterangan == 'cutoff') {
                                return "-";
                            } else if (data.poin_pelatihan == null || data.poin_pelatihan == '') {
                                return "<button class='btn btn-primary btn-xs'>Update Laporan</button>";
                            } else if (data.status_pelatihan == 'Komen Atasan') {
                                return "<i style='font-size:14px; color:red;'>Komen Atasan</i>";
                            } else {
                                return "<button type='button' class='btn btn-block btn-outline-success btn-xs btn-flat'>View</button>";
                            }
                        }
                    },
                    {
                        targets: [10],
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.lampiran_sertifikat == null || data.lampiran_sertifikat ==
                                '') {
                                return "<button class='btn btn-block btn-outline-secondary btn-xs'><i class='fa fa-upload'> Upload Sertifikat</i></button>";
                                //return "<a href='' class='link-black text-sm'><i class='fas fa-paperclip mr-1'>Upload Sertifikat</i>";
                            } else {
                                return "<button class='btn btn-block btn-outline-info btn-xs'><i class='fas fa-paperclip mr-2'> View</i></button>";
                            }
                        }
                    },
                ],

                columns: [{
                        data: 'id_pelatihan_eksternal',
                        name: 'id_pelatihan_eksternal'
                    },
                    {
                        data: 'tgl_pelatihan',
                        name: 'tgl_pelatihan'
                    },
                    {
                        data: 'sampai',
                        name: 'sampai'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'materi_pelatihan',
                        name: 'materi_pelatihan'
                    },
                    {
                        data: 'penyelenggara',
                        name: 'penyelenggara'
                    },
                    {
                        data: 'tempat_pelatihan',
                        name: 'tempat_pelatihan',
                        class: 'text-center'
                    },
                    {
                        data: 'instruktur',
                        name: 'instruktur'
                    },
                ],
            });

            $('#modal_evaluasi_eks').modal('show');

            $("#tb_report_pelatihan_eksternal").on('click', '.btn-primary', function() {
                var data = list_rpke.row($(this).parents('tr')).data();
                //alert(data.id_pelatihan_eksternal);
                $("#ule_idpelatihan").val(data.id_pelatihan_eksternal)
                $("#ule_mulai").html(data.tgl_pelatihan)
                $("#ule_selesai").html(data.sampai)
                $("#ule_nik").html(data.nik)
                $("#ule_nama").html(data.nama)
                $("#ule_penyelenggara").html(data.penyelenggara)
                $("#ule_tempat").html(data.tempat_pelatihan)
                $("#ule_materi").html(data.materi_pelatihan)
                $("#ule_instruktur").html(data.instruktur)
                get_ule();
                $("#modal_ule").modal('show');
            });

            $("#tb_report_pelatihan_eksternal").on('click', '.btn-outline-secondary', function() {
                var data = list_rpke.row($(this).parents('tr')).data();
                //alert(data.id_pelatihan_eksternal);
                $("#us_idpelatihan").val(data.id_pelatihan_eksternal)
                $("#modal_us").modal('show');
            });

            $("#form_us").submit(function(e) {
                e.preventDefault();
                var datas = new FormData(this);
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/pga/upload_sertifikat",

                        data: datas,
                        processData: false,
                        contentType: false,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $("#modal_us").modal('toggle');
                            //$('#modal_evaluasi_eks').modal('show');
                            list_rpke.ajax.reload();
                        } else {
                            list_rpke.ajax.reload();
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );
                    });
            });

            $("#tb_report_pelatihan_eksternal").on('click', '.btn-outline-info', function() {
                var data = list_rpke.row($(this).parents('tr')).data();

                var fpath = APP_URL + "/storage/img/pga/sertifikat/" + data.lampiran_sertifikat;
                window.open(fpath, '_blank');
            });

            $('#tb_report_pelatihan_eksternal').on('click', '.btn-outline-success', function() {
                var data = list_rpke.row($(this).parents('tr')).data();
                window.open(APP_URL + "/pga/lembar_laporan_eksternal/" + data.id_pelatihan_eksternal,
                    '_blank');
            });

            $("#form_ule").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                        url: APP_URL + '/api/pga/form_ule_update',
                        headers: {
                            "token_req": key
                        },
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $("#modal_ule").modal('toggle');
                            $('#modal_evaluasi_eks').modal('show');
                            list_rpke.ajax.reload();
                        } else
                            alert(resp.message);
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );

                    })
                    .always(function() {});
            });



            $('#tb_listskillmatrik').on('click', '.btn-outline-success', function() {
                var data = inqueryskillmatrik.row($(this).parents('tr')).data();
                window.open(APP_URL + "/pga/lembarOJT/" + data.id_rencana_pelatihan, '_blank');
            });

        });

        function get_ule() {
            $("#ule_poin").val('');
            $("#ule_pendapat").val('');
            $("#ule_bentuk_pengayaan").val('');
            $("#ule_diaplikasikan_untuk").val('');
            $("#ule_kebutuhan").val($("#ule_kebutuhan").data("default-value"));
            $("#ule_metode").val($("#ule_metode").data("default-value"));
            $("#ule_pemahaman").val($("#ule_pemahaman").data("default-value"));
            $("#ule_pengajar").val($("#ule_pengajar").data("default-value"));
            $("#ule_kelebihan").val('');
            $("#ule_kekurangan").val('');
            $("#ule_saran").val('');
        }
    </script>
@endsection
