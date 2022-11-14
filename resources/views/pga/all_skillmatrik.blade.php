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
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-address-book"></i>
                                Standart Kompetensi <b style="color: blue"> >>> INTERNAL </b>
                            </h3>
                            <h4 class="float-right">
                                <u>{{ $nik }} / {{ $nama }}</u>
                            </h4>
                        </div>
                        <!-- /.card-header -->

                        <blockquote class="quote-secondary">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-wrap" id="tb_listskillmatrik" style="size: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kategori</th>
                                            <th>Tema Pelatihan</th>
                                            <th>Lokasi Pelatihan</th>
                                            <th>Standar</th>
                                            <th>Level</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col col-md-3">

                                    <i style="font-size: small;"><b><a style="color:red;">Level 1</a> : Masih dalam
                                            pelatihan</i></b><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Belum memahami SOP dan standar
                                        lainnya</i><br>
                                </div>
                                <div class="col col-md-3">

                                    <i style="font-size: small;"><b><a style="color:red;">Level 2</a> : Dapat melakukan
                                            pekerjaan dengan mandiri</i></b><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Memahami SOP dan standar
                                        lainnya</i><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Memahami cara pemeriksaan
                                        produk</i>
                                </div>
                                <div class="col col-md-3">
                                    <i style="font-size: small;"><b><a style="color:red;">Level 3</a> : Dapat melakukan
                                            pekerjaan dengan mahir</i></b><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Memahami SOP dan standar
                                        lainnya</i><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Memahami cara pemeriksaan
                                        produk</i><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Dapat melakukan Set Up</i>
                                </div>
                                <div class="col col-md-3">
                                    <i style="font-size: small;"><b><a style="color:red;">Level 4</a> : Dapat mengajarkan
                                            kepada orang lain</i></b><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Memahami SOP dan standar
                                        lainnya</i><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Memahami cara pemeriksaan
                                        produk</i><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Dapat melakukan Set Up</i><br>
                                    <i style="font-size: small;"><a style="color:red;"></a> - Dapat mengajarkan kepada orang
                                        lain</i>
                                </div>


                            </div>

                        </blockquote>

                        <!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">


                <div class="col-md-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-address-book"></i>
                                Standart Kompetensi <b style="color: blue"> >>> EKSTERNAL </b>
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
                                        <th style="width: min-content;">Status</th>
                                        <!--<th style="width: min-content;">Report</th>
                                                                    <th style="width: min-content;">Sertifikat</th>-->
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

        var $star_rating = $('.star-rating .fa');

        var SetRatingStar = function() {
            return $star_rating.each(function() {
                if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data(
                        'rating'))) {
                    return $(this).removeClass('fa-star-o').addClass('fa-star');
                } else {
                    return $(this).removeClass('fa-star').addClass('fa-star-o');
                }
            });
        };

        $star_rating.on('click', function() {
            $star_rating.siblings('input.rating-value').val($(this).data('rating'));
            return SetRatingStar();
        });

        SetRatingStar();

        $(document).ready(function() {

            var key = localStorage.getItem('npr_token');

            var segments = window.location.href.split('/');
            var difsegment = segments.reverse()
            var nik = difsegment[1];
            var nama = difsegment[0];

            var inqueryskillmatrik = $('#tb_listskillmatrik').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/pga/inqueryskillmatrik',
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
                        targets: [5],
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.level_pelatihan == 4 && data.status_pelatihan == 'Rencana') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button> <button class='btn-warning'><i class='fa fa-star'>4</i></button>";
                            } else if (data.level_pelatihan == 3 && data.status_pelatihan ==
                                'Rencana') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button>";
                            } else if (data.level_pelatihan == 2 && data.status_pelatihan ==
                                'Rencana') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button>";
                            } else if (data.level_pelatihan == 1 && data.status_pelatihan ==
                                'Rencana') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button>";
                            } else if (data.level_pelatihan == 4 && data.status_pelatihan ==
                                'Belum Approve') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button> <button class='btn-warning'><i class='fa fa-star'>4</i></button>";
                            } else if (data.level_pelatihan == 3 && data.status_pelatihan ==
                                'Belum Approve') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button> <button class='btn-warning'><i class='fa fa-star'>3</i></button>";
                            } else if (data.level_pelatihan == 2 && data.status_pelatihan ==
                                'Belum Approve') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button> <button class='btn-warning'><i class='fa fa-star'>2</i></button>";
                            } else if (data.level_pelatihan == 1 && data.status_pelatihan ==
                                'Belum Approve') {
                                return "<button class='btn-warning'><i class='fa fa-star'>1</i></button>";
                            } else if (data.level_pelatihan == 4 && data.status_pelatihan ==
                                'Tercapai') {
                                return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button> <button class='btn-success'><i class='fa fa-star'>3</i></button> <button class='btn-success'><i class='fa fa-star'>4</i></button>";
                            } else if (data.level_pelatihan == 3 && data.status_pelatihan ==
                                'Tercapai') {
                                return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button> <button class='btn-success'><i class='fa fa-star'>3</i></button>";
                            } else if (data.level_pelatihan == 2 && data.status_pelatihan ==
                                'Tercapai') {
                                return "<button class='btn-success'><i class='fa fa-star'>1</i></button> <button class='btn-success'><i class='fa fa-star'>2</i></button>";
                            } else if (data.level_pelatihan == 1 && data.status_pelatihan ==
                                'Tercapai') {
                                return "<button class='btn-success'><i class='fa fa-star'>1</i></button>";
                            }
                        }
                    },
                ],

                columns: [{
                        data: 'id_rencana_pelatihan',
                        name: 'id_rencana_pelatihan'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'tema_pelatihan',
                        name: 'tema_pelatihan'
                    },
                    {
                        data: 'loc_pelatihan',
                        name: 'loc_pelatihan'
                    },
                    {
                        data: 'standar',
                        name: 'standar'
                    },
                    //{ data: 'level_pelatihan', name: 'level_pelatihan' },

                ],
            });

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
                            if (data.status_pelatihan == null || data.status_pelatihan == '') {
                                return "<i style='color:red';>Update Laporan</i>";
                            } else {
                                return data.status_pelatihan;
                            }
                        }
                    },
                    /*{
                        targets: [10],
                        data: null,
                        render: function (data, type, row, meta) {
                            if (data.lampiran_sertifikat == null || data.lampiran_sertifikat == '') {
                                return "<button class='btn btn-block btn-outline-secondary btn-xs'><i class='fa fa-upload'> Upload Sertifikat</i></button>";
                                //return "<a href='' class='link-black text-sm'><i class='fas fa-paperclip mr-1'>Upload Sertifikat</i>";
                            } else {
                                return "<button class='btn btn-block btn-outline-info btn-xs'><i class='fas fa-paperclip mr-2'> View</i></button>";
                            }
                        }
                    },
                    */
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



        });
    </script>
@endsection
