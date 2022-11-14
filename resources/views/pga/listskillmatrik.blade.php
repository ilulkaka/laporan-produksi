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
                            <u>{{$nik}} / {{$nama}}</u>
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
                                        <th>Action</th>
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
                </div>
                <!-- /.card -->

            </div>

        </div>
    </div>
</section>

<!-- Modal Pelaksanaan Pelatihan -->
<div class="modal fade" id="modal_pelaksanaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b> Pelakasanaan Pelatihan</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_pelaksanaanpelatihan">
                @csrf
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div style="text-align: center;" class="col col-md-12">
                                <label style="font-family:'Courier New', Courier, monospace; font-size: x-large;"
                                    id="pp_nik"></label>
                                <label style="font-family:'Courier New', Courier, monospace; font-size: x-large;"
                                    for=""> /
                                </label>
                                <label style="font-family:'Courier New', Courier, monospace; font-size: x-large;"
                                    id="pp_nama"></label>
                                <label style="font-family:'Courier New', Courier, monospace; font-size: x-large;"
                                    for=""> -
                                </label>
                                <label style="font-family:'Courier New', Courier, monospace; font-size: x-large;"
                                    id="pp_departemen"></label>
                            </div>
                        </div>
                        <strong>Tema Pelatihan</strong>
                        <div class="input-group mb-3">
                            <textarea type="text" class="form-control rounded-0" id="pp_tema" name="pp_tema"
                                placeholder="Tema Pelatihan" cols="30" rows="2" disabled></textarea>
                            <input type="hidden" name="pp_idpelatihan" id="pp_idpelatihan"
                                class="form-control rounded-0">
                            <input type="hidden" name="pp_idtemapelatihan" id="pp_idtemapelatihan"
                                class="form-control rounded-0">

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row col-md-2 float-left">
                                    <label class="form-control rounded-0 col-md-9">Level : </label>
                                    <label class="form-control rounded-0 col-md-3" style="text-align: center;"
                                        id="pp_level">
                                    </label>
                                    <label for=""> </label>
                                </div>

                                <div class="row col-md-10 float-right">
                                    <strong class="form-control rounded-0 col-md-4"><b> Rencana Pelatihan :
                                        </b></strong>
                                    <label class="form-control rounded-0 col-md-3" name="pp_rencanamulai"
                                        id="pp_rencanamulai" style="text-align: center;"> </label>
                                    <label class="form-control rounded-0 col-md-3" name="pp_rencanaselesai"
                                        id="pp_rencanaselesai" style="text-align: center;"> </label>
                                    <label class="form-control rounded-0 col-md-2"
                                        style="text-align: center; color:red;" id="pp_dif"> 0
                                    </label>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="card border-info bg-light ">
                            <div class="card-header">

                                <div class="row">
                                    <div class="form-group col-md-6" style="color: green;">
                                        <label for="beginning">Aktual Mulai</label>
                                        <input type="date" class="form-control rounded-0" style="color:green;"
                                            id="pp_aktualmulai" name="pp_aktualmulai">
                                    </div>
                                    <div class="form-group col-md-6" style="color: green;">
                                        <label>Aktual Selesai</label>
                                        <input type="date" class="form-control rounded-0" id="pp_aktualselesai"
                                            style="color:green;" name="pp_aktualselesai">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                <!--<strong>Isi dan Tujuan <label class="float-right" for="diffisi" id="diffisi"
                                            name="diffisi" style="color:brown;">
                                            0
                                        </label></strong>
                                    <div class="input-group mb-3">
                                        <input type="text" name="pp_isitujuan" id="pp_isitujuan"
                                            class="form-control rounded-0" style="text-align: center; width: 200px;">
                                        <select name="pp_instruktur" id="pp_instruktur"
                                            class="form-control select2 rounded-0" style="width: 10%; font-size: 3px;">
                                            <option value="">Instruktur</option>
                                            @foreach($inst as $in)
                                            <option value="{{$in->nama}}">{{$in->nama }}</option>
                                            @endforeach
                                        </select>

                                        <button type="button" class="btn btn-block btn-success rounded-0"
                                            style="text-align: center;  font-size: small; width: 10%;"
                                            id="btn_pp_tambah"><i class="fa fa-plus-circle"></i></button>

                                    </div>-->

                                <!-- Date range -->
                                <!--<div class="form-group">
                                        <table class="table table-bordered" id="tb_isitujuan">
                                            <thead>
                                                <tr>
                                                    <th style="width: 200px;">Deskripsi</th>
                                                    <th style="width: 75px;">Instruktur</th>
                                                    <th style="width: 4%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody style="width: 75px; font-size: small;">

                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    </div>-->

                                <div class="card-body table-responsive p-0 ">
                                    <table class="table table-hover text-wrap" id="tb_listisitujuan">
                                        <thead>
                                            <tr>
                                                <th style="width: 900px;">Isi dan Tujuan</th>
                                                <th style="width: 210px;">Instruktur</th>
                                                <th style="width: 50px;">Evalu asi</th>
                                                <th style="width: 200px;">Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div>
                        </div>
                        <hr>

                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary float-right btn-flat"
                                id="btn_pp_update">Update</button>
                        </div>
                        <br>
                    </div>
                </section>
            </form>

        </div>
    </div>
</div>

<!-- Modal Edit Pelaksanaan OJT-->
<div class="modal fade" id="modal_edit_pelaksanaan_ojt" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b> Edit List Pelaksanaan OJT </b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_e_pelaksanaan_ojt">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Isi dan Tujuan</label></div>
                        <div class="col col-md-8">
                            <input type="hidden" id="e_ojt_id_ojt" name="e_ojt_id_ojt">
                            <input type="hidden" id="e_ojt_id_rencana_pelatihan" name="e_ojt_id_rencana_pelatihan">
                            <textarea name="e_ojt_isitujuan" id="e_ojt_isitujuan" cols="30" rows="2"
                                class="form-control rounded-0" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Instruktur</label></div>
                        <div class="col col-md-8">
                            <select name="e_ojt_instruktur" id="e_ojt_instruktur"
                                class="form-control select2 col-md-12 rounded-0" style="width: 74%; font-size: 3px;"
                                required>
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Evaluasi</label></div>
                        <div class="col col-md-4">
                            <select name="e_ojt_evaluasi" id="e_ojt_evaluasi" class="form-control rounded-0" required>
                                <option value="">Pilih Nilai ...</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <!--<option value="0">0</option>-->
                            </select>
                        </div>

                        <b style="font-size: small;"></b><small style="font-size: small; "></small>
                        <small style="font-size: small;float: right; padding-left: 35%;"><i style="color: red;"> 2 :
                                Dapat Melakukan
                                pekerjaan sendiri <br>
                                1 : Dapat melakukan pekerjaan dengan bertanya ke orang <br><i
                                    style="font-size: small;float: left; padding-left: 5%;"> lain </i><br>
                                <!--0 : Perlu dilakukan training kembali-->
                            </i></small>

                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Catatan</label></div>
                        <div class="col col-md-8">
                            <textarea name="e_ojt_catatan" id="e_ojt_catatan" cols="30" rows="2"
                                class="form-control rounded-0"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-flat" id="e_ojt_simpan" name="e_ojt_simpan"
                            value="Simpan">
                    </div>
                </form>
            </div>
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
                headers: { "token_req": key },
                data: { 'nik': nik, 'nama': nama, },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [5],
                data: null,
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
                targets: [6],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.status_pelatihan == 'Rencana') {
                        return "<button type='button' class='btn btn-block btn-outline-primary btn-sm btn-flat'>Evaluasi</button>";
                    } else if (data.status_pelatihan == 'Tercapai') {
                        return "<button type='button' class='btn btn-block btn-outline-success btn-sm btn-flat'>OJT</button>";
                    } else if (data.status_pelatihan == 'Belum Approve') {
                        //return "<button type='button' class='btn btn-block btn-info btn-sm btn-flat'>Approve</button>";
                        return "<i style='color:red;''> Perlu Approve </i>";
                    }
                }

            },
            ],

            columns: [
                { data: 'id_rencana_pelatihan', name: 'id_rencana_pelatihan' },
                { data: 'kategori', name: 'kategori' },
                { data: 'tema_pelatihan', name: 'tema_pelatihan' },
                { data: 'loc_pelatihan', name: 'loc_pelatihan' },
                { data: 'standar', name: 'standar' },
                //{ data: 'level_pelatihan', name: 'level_pelatihan' },

            ],
        });




        $('#tb_listskillmatrik').on('click', '.btn-outline-primary', function () {
            // $('#tb_listisitujuan').DataTable().clear().destroy();
            var data = inqueryskillmatrik.row($(this).parents('tr')).data();
            $("#pp_idpelatihan").val(data.id_rencana_pelatihan);
            $("#pp_nik").html(data.nik);
            $("#pp_nama").html(data.nama);
            $("#pp_departemen").html(data.loc_pelatihan);
            $("#pp_tema").val(data.tema_pelatihan);
            $("#pp_level").html(data.level_pelatihan);
            $("#pp_rencanamulai").html(data.rencana_mulai);
            $("#pp_rencanaselesai").html(data.rencana_selesai);
            $("#pp_dif").html(data.dif + ' Hari');
            $('#modal_pelaksanaan').modal('show');

            var t = {
                "id_rencana": data.id_rencana_pelatihan,
            }
            load_tb_list_isitujuan(key, t);

            /*            var listisitujuan = $('#tb_listisitujuan').DataTable({
                            destroy: true,
                            processing: true,
                            serverSide: true,
                            searching: false,
                            ordering: false,
                            ajax: {
                                url: APP_URL + '/api/pga/list_isitujuan',
                                type: "POST",
                                headers: { "token_req": key },
                                data: data,
                            },
                            columnDefs: [{
                                targets: [0],
                                visible: false,
                                searchable: false
                            },
                            {
                                targets: [5],
                                data: null,
                                render: function (data, type, row, meta) {
                                    return "<button type='button' class='btn btn-block btn-outline-info btn-flat'><u>Edit</u></button>";
                                }
            
                            },
                            ],
                            columns: [
                                //{ data: 'id_rencana_pelatihan', name: 'id_rencana_pelatihan' },
                                { data: 'id_ojt', name: 'id_ojt' },
                                { data: 'isi_tujuan', name: 'isi_tujuan' },
                                { data: 'instruktur', name: 'instruktur' },
                                { data: 'evaluasi', name: 'evaluasi' },
                                { data: 'catatan', name: 'catatan' },
            
                            ],
                        });
            
            $('#tb_listisitujuan').on('click', '.btn-outline-info', function () {
                var data1 = listisitujuan.row($(this).parents('tr')).data();
                //var data1 = listisitujuan.row($(this).parents('tr')).cell(0).data();
                //$("#e_ojt_id_ojt").val(data1.id_ojt);
                //$("#e_ojt_id_rencana_pelatihan").val(data1.id_rencana_pelatihan);
                //$("#e_ojt_isitujuan").val(data1.isi_tujuan);
                //$("#e_ojt_instruktur").val(data.instruktur);
                console.log(data1.id_ojt);
                var id_tema = data1.id_tema_pelatihan;

                $.ajax({
                    url: APP_URL + '/api/pga/get_instruktur',
                    headers: {
                        "token_req": key
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: { 'id_tema': id_tema },
                })
                    .done(function (resp) {
                        if (resp.success == true) {
                            var resultData = resp.inst;

                            var html = "";
                            for (var i = 0; i < resultData.length; i++) {
                                html = html + '<option value="' +
                                    resultData[i].nama + '">' + resultData[i].nama + '</option>';
                            }

                            /*for (var i in resp.inst) {
                                $("#e_ojt_instruktur").append(new Option(resp.inst[i].nama, resp.inst[i].nama));
                            }

                            $("#e_ojt_instruktur").html(html);
                            get_epo();
                            $('#modal_edit_pelaksanaan_ojt').modal('show');

                        } else {
                            var conf = confirm(resp.message + '\n' + '\n' + 'Pilih Manager untuk menjadi Instruktur .');

                            if (conf) {
                                var resultData = resp.mgr;

                                var html = "";
                                for (var i = 0; i < resultData.length; i++) {
                                    html = html + '<option value="' +
                                        resultData[i].nama + '">' + resultData[i].nama + '</option>';
                                }

                                /*for (var i in resp.inst) {
                                    $("#e_ojt_instruktur").append(new Option(resp.inst[i].nama, resp.inst[i].nama));
                                }

                                $("#e_ojt_instruktur").html(html);
                                get_epo();
                                $('#modal_edit_pelaksanaan_ojt').modal('show');
                            } else {
                                alert('Evaluasi Gagal Update .');
                            }
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    })
                    .always(function () {
                    });
            });

*/

        });



        $('#tb_listskillmatrik').on('click', '.btn-outline-success', function () {
            var data = inqueryskillmatrik.row($(this).parents('tr')).data();
            window.open(APP_URL + "/pga/lembarOJT/" + data.id_rencana_pelatihan, '_blank');
        });

        $('#btn_pp_tambah').click(function () {
            var isitujuan = $("#pp_isitujuan").val();
            var instruktur = $("#pp_instruktur").val();


            if (!isitujuan) {
                alert('isitujuan NG Belum diisi .');
            } else if (!instruktur) {
                alert('Harap masukkan instruktur .')
            } else {
                var baris_baru = '<tr><td><input type ="hidden" name="pp_isitujuan[]" value="' + isitujuan + '" />' + isitujuan + '</td><td><input type ="hidden"  name="pp_instruktur[]" value="' + instruktur + '" />' + instruktur + '</td><td><button type="button" class="btnSelect btn btn-xs btn-danger">Hapus</button></td></tr>';
                $('#tb_isitujuan tbody').append(baris_baru);
                $('#pp_isitujuan').val('');
                $('#pp_instruktur').val('').trigger('change');

                var count = $('#tb_isitujuan>tbody>tr').length;
                $('#diffisi').html(count);
                //$("#ko").select2('focus');
            }
        });


        $('#tb_isitujuan').on('click', '.btnSelect', function () {
            var currentRow = $(this).closest("tr");
            var count1 = $('#tb_isitujuan>tbody>tr').length;
            $('#diffisi').html(count1 - 1);
            currentRow.remove();
        });

        //$("#form_pelaksanaanpelatihan").submit(function (e) {
        $("#btn_pp_update").click(function () {
            //e.preventDefault();
            var datas = $("#form_pelaksanaanpelatihan").serializeArray();
            var diffisi = $('#diffisi').html();

            if ($("#pp_aktualmulai").val() == '' || $("#pp_aktualselesai").val() == '') {
                alert('Tanggal Aktual belum diisi .');
            }
            /* else if ($("#diffisi").html() == 0) {
                 alert('Mohon Masukkan Isi dan Tujuan Pelatihan .');
             } */
            else {
                $.ajax({
                    url: APP_URL + '/api/pga/form_pelaksanaanpelatihan',
                    headers: {
                        "token_req": key
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: datas,
                })
                    .done(function (resp) {
                        if (resp.success) {

                            alert(resp.message);
                            location.reload();
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

    function load_tb_list_isitujuan(key, data) {
        $.ajax({
            url: APP_URL + "/api/pga/list_isitujuan",
            method: "POST",
            data: data,
            dataType: "json",
            headers: { "token_req": key },

            success: function (data) {

                $("#tb_listisitujuan tbody").empty();
                $("#tb_listisitujuan tfoot").empty();

                $("#pp_idtemapelatihan").val(data.id_tema);
                for (var i in data.instruk) {
                    idt = (data.instruk[i].id_ojt);
                    isi = (data.instruk[i].isi_tujuan);
                    inst = (data.instruk[i].instruktur);
                    evaluasi = (data.instruk[i].evaluasi);
                    catatan = (data.instruk[i].catatan);

                    var newrow = '<tr><td><a href="#" id="' + idt + '" class="e_instruktur">' + isi + '</td><td><name="cf[]" value="/>' + inst + '</td><td><name="cf[]" value="/>' + evaluasi + '</td><td><name="cf[]" value="/>' + catatan + '</td></tr>';
                    $('#tb_listisitujuan tbody').append(newrow);
                }

                //$("#tb_listisitujuan tfoot").append('<tr><th colspan="2">Total :</th><th>' + totcf.toLocaleString("en-US") + '</th><th>' + totccr.toLocaleString("en-US") + '</th><th>' + totoif.toLocaleString("en-US") + '</th><th>' + totoicr.toLocaleString("en-US") + '</th><th class="jumlah">' + grandtotal.toLocaleString("en-US") + '</th><th class="total">' + jmllot.toLocaleString("en-US") + '</th><th class="">' + totjamopr.toLocaleString("en-US") + '</th><th class="">' + parseFloat(totpcsjam).toLocaleString("en-US") + '</th><th class="">' + totcycle.toLocaleString("en-US") + '</th></tr>')
            }

        });
    }


    $("#tb_listisitujuan").on("click", ".e_instruktur", function (e) {
        e.preventDefault();
        var key = localStorage.getItem('npr_token');
        var id_ojt = this.id;
        var currentRow = $(this).closest("tr");
        var id_tema = $("#pp_idtemapelatihan").val();

        $.ajax({
            url: APP_URL + '/api/pga/get_instruktur',
            headers: {
                "token_req": key
            },
            type: 'POST',
            dataType: 'json',
            data: { 'id_ojt': id_ojt, 'id_tema': id_tema },
        })
            .done(function (resp) {
                if (resp.success == true) {
                    var resultData = resp.inst;

                    var html = "";
                    for (var i = 0; i < resultData.length; i++) {
                        html = html + '<option value="' +
                            resultData[i].nama + '">' + resultData[i].nama + '</option>';
                    }

                    /*for (var i in resp.inst) {
                        $("#e_ojt_instruktur").append(new Option(resp.inst[i].nama, resp.inst[i].nama));
                    }*/

                    $("#e_ojt_instruktur").html(html);
                    $("#e_ojt_isitujuan").val(resp.isi[0].isi_tujuan);
                    $("#e_ojt_id_ojt").val(resp.isi[0].id_ojt);
                    $("#e_ojt_id_rencana_pelatihan").val(resp.isi[0].id_rencana_pelatihan);
                    get_epo();
                    $('#modal_edit_pelaksanaan_ojt').modal('show');

                } else {
                    var conf = confirm(resp.message + '\n' + '\n' + 'Pilih Manager untuk menjadi Instruktur .');

                    if (conf) {
                        var resultData = resp.mgr;

                        var html = "";
                        for (var i = 0; i < resultData.length; i++) {
                            html = html + '<option value="' +
                                resultData[i].instruktur + '">' + resultData[i].instruktur + '</option>';
                        }

                        /*for (var i in resp.inst) {
                            $("#e_ojt_instruktur").append(new Option(resp.inst[i].nama, resp.inst[i].nama));
                        }*/

                        $("#e_ojt_instruktur").html(html);
                        $("#e_ojt_isitujuan").val(resp.isi[0].isi_tujuan);
                        $("#e_ojt_id_ojt").val(resp.isi[0].id_ojt);
                        $("#e_ojt_id_rencana_pelatihan").val(resp.isi[0].id_rencana_pelatihan);
                        get_epo();
                        $('#modal_edit_pelaksanaan_ojt').modal('show');
                    } else {
                        alert('Evaluasi Gagal Update .');
                    }
                }
            })
            .fail(function () {
                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

            })
            .always(function () {
            });

    });

    $("#form_e_pelaksanaan_ojt").submit(function (e) {
        e.preventDefault();
        var key = localStorage.getItem('npr_token');
        var data = $(this).serialize();


        //alert(s);

        $.ajax({
            url: APP_URL + '/api/pga/form_e_pelaksanaan_ojt',
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
                    $('#modal_edit_pelaksanaan_ojt').modal('toggle');


                    //var t = {
                    //    "id_rencana": data.id_rencana_pelatihan,
                    // }
                    var s = $("#e_ojt_id_rencana_pelatihan").val();
                    var s1 = { "id_rencana": s };
                    //alert(s);
                    load_tb_list_isitujuan(key, s1);

                    //listisitujuan.ajax.reload();
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

    function get_epo() {
        $("#e_ojt_instruktur").val('').trigger('change');
        $("#e_ojt_evaluasi").val($("#e_ojt_evaluasi").data("default-value"));
        $("#e_ojt_catatan").val('');
    }




</script>

@endsection