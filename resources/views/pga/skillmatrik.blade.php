@extends('layout.main')
@section('content')

<head>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<style>
    @import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
    @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);


    fieldset,
    label {
        margin: 0;
        padding: 0;
    }

    /****** Style Star Rating Widget *****/

    .rating {
        border: 1px;
        margin-right: 50px;
    }

    .myratings {

        font-size: 30px;
        color: green;
    }

    .rating>[id^="star"] {
        display: none;
    }

    .rating>label:before {
        margin: 5px;
        font-size: 5em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
    }

    .rating>.half:before {
        content: "\f089";
        position: center;
    }

    .rating>label {
        color: #ddd;
        float: right;
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating>[id^="star"]:checked~label,
    /* show gold star when clicked */
    .rating:not(:checked)>label:hover,
    /* hover current star */
    .rating:not(:checked)>label:hover~label {
        color: orange;
    }

    /* hover previous stars in list */

    .rating>[id^="star"]:checked+label:hover,
    /* hover current star when changing rating */
    .rating>[id^="star"]:checked~label:hover,
    .rating>label:hover~[id^="star"]:checked~label,
    /* lighten current selection */
    .rating>[id^="star"]:checked~label:hover~label {
        color: rebeccapurple;
    }

    .btn:hover {
        color: darkred;
        background-color: white !important
    }

    .reset-option {
        display: none;
        font-family: FontAwesome;
    }

    .reset-button {
        margin: 6px 12px;
        background-color: rgb(255, 255, 255);
        text-transform: uppercase;
    }
</style>



<!--<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-text-width"></i>
                List Pelatihan
            </h3>
        </div>
        <!-- /.card-header -->
        <!--<div class="card-body clearfix">
            <blockquote class="quote-secondary">
                <button class="btn block btn-flat" id="btn-rencanapelatihan1" style="color:blue"><u><b
                            style="font-family: 'Courier New', Courier, monospace;">1. Rencana
                            Pelatihan Karyawan</b></u></button><br>
                <button class="btn btn-flat" id="btn_listskillmatrik1" style="color: blue;"><u><b
                            style="font-family: 'Courier New', Courier, monospace;">2. Standart
                            Kompetensi
                            & Skill Matrik</b></u></button>
                <br>
                <button class="btn btn-flat" id="btn_laporanpelaksanaanojt1" style="color: blue;"><u><b
                            style="font-family: 'Courier New', Courier, monospace;">3. Laporan
                            Pelaksanaan Training</b></u></button><br>
                <br>
                <br>
                <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
            </blockquote>
        </div>
    </div>
</div>
<!-- /.card-body -->
<!-- /.card -->

<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-play"></i></span>
                
                <div class="info-box-content">
                <button class="btn btn-block btn-outline" style="text-align: left" id="btn-rencanapelatihan">
                <span class="info-box-text">Rencana Pelatihan Karyawan </span>
                    <span class="info-box-number">
                        Internal Eksternal
                      <small></small>
                    </span>
                </button>
                </div>
                <!-- /.info-box-content -->
            </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>
    
            <div class="info-box-content">
                <button class="btn btn-block btn-outline" style="text-align: left" id="btn_listskillmatrik">
                    <span class="info-box-text">Standart Kompetensi & Skill Matrik </span>
                    <span class="info-box-number">Internal Eksternal</span>
                </button>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    
        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>
    
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>
    
            <div class="info-box-content">
                <button class="btn btn-block btn-outline" style="text-align: left" id="btn_laporanpelaksanaanojt">
                    <span class="info-box-text">Laporan Pelaksanaan Training </span>
                    <span class="info-box-number">Internal Eksternal</span>
                </button>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-secondary card-outline">
            <div class="card-header">
                <h5>
                    <i class="fa fa-address-book"></i>
                    <b><u> Standart Kompetensi & Skill Matrik </u></b>
                </h5>
            </div>

            <blockquote class="quote-secondary">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_all_sm">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tgl Masuk</th>
                                <th>Departemen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </blockquote>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
</div>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-address-book"></i>
                            Karyawan Baru untuk dilakukan Pelatihan
                        </h3>
                    </div>

                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_skillmatrik">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Dept</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" id="namasm" name="namasm">
                            <i class="fa fa-list"></i>
                            List Tema Pelatihan (<b>Pengajuan</b>)
                        </h3>
                    </div>
                    <!-- /.card-header -->

                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover" id="tb_ltp">
                                <thead>
                                    <tr>
                                        <th>id tema</th>
                                        <th>Kategori</th>
                                        <th>Tema Pelatihan</th>
                                        <th>Departemen</th>
                                        <th>Stan dar</th>
                                        <th>Pengaju</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            
        </div>

        <div class="row">


            

        </div>

    </div>
</section>

<!-- Modal Menu Internal Eksternal -->
<div class="modal fade" id="modal-menu-inteks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b> Rencana Pelatihan Karyawan</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <p></p>
            <h10 style="padding-left: 4%;">Pilih <code>Rencana Pelatihan</code> <code></code> :</h10>
            <div class="card-body align-items-center d-flex justify-content-center">
                <a class="btn btn-app">
                    <i class="fa fa-cloud-download" id="btn_internal"></i> INTERNAL
                </a>
                <a class="btn btn-app">
                    <i class="fa fa-cloud-upload" id="btn_eksternal"></i> EKSTERNAL
                </a>
                <!--<a class="btn btn-app  col-md-3">
                    <i class="fa fa-graduation-cap" id="btn_penyelenggara"></i> PENYELENGGARA
                </a>-->
                <a class="btn btn-app" data-dismiss="modal">
                    <i class="fa fa-sign-out"></i> CLOSE
                </a>
            </div>
            <hr>
        </div>
    </div>
</div>

<!-- Modal Pelatihan Karyawan -->
<div class="modal fade" id="modal-rencanapelatihankaryawan" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b> Rencana Pelatihan Karyawan</b> (Internal)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-rpk-pelatihan">
                @csrf
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="col-md-1" for="a">NIK</label>
                        <input type="hidden" id="id_t" name="id_t">
                        <select name="rpk-nama" id="rpk-nama" class="form-control rounded-0 select2" style="width: 2%;"
                            required>
                            <option value="">NIK</option>
                            @foreach($nomerinduk as $n)
                            <option value="{{$n->nama}}">{{$n->nik }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="rpk-nik" id="rpk-nik" class="form-control rounded-0">
                        <input type="text" class="form-control col-md-7 rounded-0" name="nama" id="nama"
                            placeholder="Nama Operator" style="width: max-content;" disabled>
                    </div>
                    <strong>Tema Pelatihan</strong>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control rounded-0" id="rpk-tema" name="rpk-tema"
                            placeholder="Tema Pelatihan" cols="30" rows="2" style="display: none;"></textarea>
                        <textarea type="hidden" class="form-control rounded-0" id="rpk-tema1" name="rpk-tema1"
                            placeholder="Tema Pelatihan" cols="30" rows="2" disabled></textarea>
                        <input type="hidden" name="rpk-idpelatihan" id="rpk-idpelatihan" class="form-control rounded-0">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-info btn-flat" id="btn-rpk-searching">?</button>
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-4">

                            <div class="row">
                                <div class="input-group mb-4">
                                    <strong class="col-md-4">Level</strong>
                                    <select name="rpk-level" id="rpk-level" class="form-control rounded-0  select2"
                                        required>
                                        <option value="" selected="selected">Pilih Level</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>

                                    <label class="col-md-4">Lokasi Pelatihan</label>
                                    <select name="rpk-lokasi" id="rpk-lokasi"
                                        class="form-control rounded-0 select2 col-md-3" required>
                                        <option value="">Pilih Lokasi</option>
                                        @foreach($dept_section as $d)
                                        <option value="{{$d->dept_section}}">{{$d->dept_section }}</option>
                                        @endforeach
                                        <option value="EKSTERNAL"><b> EKSTERNAL </b></option>
                                    </select>
                                </div>
                            </div>

                            <div class="card card-secondary rounded-0">
                                <div class="card-header rounded-0">
                                    <h3 class="card-title">Rencana Pelaksanaan</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Date range -->
                                    <div class="form-group">
                                        <label>Rencana Mulai:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control rounded-0 float-right" id="rpk-mulai"
                                                name="rpk-mulai" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->
                                    <div class="form-group">
                                        <label>Rencana Selesai:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control rounded-0 float-right"
                                                id="rpk-selesai" name="rpk-selesai" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <!-- /.form group -->

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="modal-body">

                                <strong>Isi dan Tujuan <label class="float-right" for="diffisi" id="diffisi"
                                        name="diffisi" style="color:brown;">
                                        0
                                    </label></strong>
                                <div class="input-group mb-3">
                                    <input type="text" name="rpk_isitujuan" id="rpk_isitujuan"
                                        class="form-control rounded-0" style="text-align: left; width: 200px;"
                                        placeholder="Detail Isi Pelatihan">
                                    <!--<select name="rpk_instruktur" id="rpk_instruktur"
                                        class="form-control select2 rounded-0" style="width: 10%; font-size: 3px;">
                                        <option value="">Instruktur</option>
                                        @foreach($inst as $in)
                                        <option value="{{$in->nama}}">{{$in->nama }}</option>
                                        @endforeach
                                    </select>-->

                                    <button type="button" class="btn btn-block btn-success rounded-0"
                                        style="text-align: center;  font-size: small; width: 10%;"
                                        id="btn_rpk_tambah"><i class="fa fa-plus-circle"></i></button>

                                </div>

                                <!-- Date range -->
                                <div class="form-group">
                                    <table class="table table-bordered" id="tb_isitujuan">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px;">Deskripsi</th>
                                                <!--<th style="width: 75px;">Instruktur</th>-->
                                                <th style="width: 4%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="width: 75px; font-size: small;">

                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary float-right btn-flat"
                            id="btn-rpk-update">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Penyelenggara -->
<div class="modal fade" id="modal_penyelenggara" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b> Penyelenggara Pelatihan</b> (Eksternal)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_pp_eksternal">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label>Date range:</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right rounded-0 col-md-6" id="daterange"
                                name="daterange" required />
                        </div>
                        <!-- /.input group -->
                    </div>

                    <dir class="form-group" style="padding-left: 1%;">
                        <div class="row">
                            <div class="input-group">
                                <strong>Penyelenggara Pelatihan</strong>
                                <label style="padding-left:37%"> Instruktur Pelatihan</label>
                            </div>
                            <div class="input-group">
                                <input type="text" id="pp_penyelenggara" name="pp_penyelenggara"
                                    class="form-control rounded-0 col-md-7" placeholder="Penyelenggara Pelatihan"
                                    required>
                                <input type="text" id="pp_instruktur" name="pp_instruktur"
                                    class="form-control rounded-0 col-md-4" placeholder="Instruktur Pelatihan" required>
                            </div>
                        </div>
                    </dir>

                    <strong>Tempat Pelatihan</strong>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control rounded-0" id="pp_tempat" name="pp_tempat"
                            placeholder="Tempat Pelatihan" cols="30" rows="1" required></textarea>
                    </div>

                    <strong>Materi Pelatihan</strong>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control rounded-0" id="pp_materi" name="pp_materi"
                            placeholder="Materi Pelatihan" cols="30" rows="2" required></textarea>
                    </div>


                    <hr>
                    <div class="col-md-12" style="padding-left: 80%;">
                        <button type="submit" class="btn btn-primary btn-flat" id="btn_pp_update">Update</button>
                        <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal List Penyelenggara -->
<div class="modal fade" id="modal_list_penyelenggara" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Penyelenggara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<table id="tb_listtema" class="table table-bordered table-striped dataTable">-->
                <div class="container-fluid">
                    <div class="col-md-12">
                    <table id="tb_listpenyelenggara" class="table table-hover text-wrap" width="100%" cellspacing="0">
                        <!--<table id="tb_listtema" class="table table-bordered table-hover text-nowrap ">-->
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Pilih</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Penyelenggara</th>
                                <th>Instruktur</th>
                                <th>Tempat</th>
                                <th>Materi</th>
                                <th>Input</th>
                            </tr>
                        </thead> 
                    </table>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-flat float-none" id="btn_tambah_penyelenggara"><i
                            class="fa fa-plus"></i>
                        Tambah Penyelenggara</button>
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-primary btn-flat" id="pilih_penyelenggara"><i
                            class="fa fa-check"></i>
                        Simpan</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Pelatihan Karyawan Eksternal -->
<div class="modal fade" id="modal-rencanapelatihankaryawaneksternal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><b> Rencana Pelatihan Karyawan</b> (Eksternal)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-rpk-pelatihan-eksternal">
                @csrf
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="col-md-1" for="a">NIK</label>
                        <input type="hidden" id="id_rpke_penyelenggara" name="id_rpke_penyelenggara">
                        <select name="rpke_nama" id="rpke_nama" class="form-control rounded-0 select2"
                            style="width: 2%;" required>
                            <option value="">NIK</option>
                            @foreach($nomerinduk as $n)
                            <option value="{{$n->nama}}">{{$n->nik }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="rpke_nik" id="rpke_nik" class="form-control rounded-0">
                        <input type="text" class="form-control col-md-7 rounded-0" name="rnama" id="rnama"
                            placeholder="Nama Operator" style="width: max-content;" disabled>
                    </div>
                    <strong>Materi Pelatihan</strong>
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control rounded-0" id="rpke_tema" name="rpke_tema"
                            placeholder="Tema Pelatihan" cols="30" rows="2" style="display: none;"></textarea>
                        <textarea type="hidden" class="form-control rounded-0" id="rpke_tema1" name="rpke_tema1"
                            placeholder="Tema Pelatihan" cols="30" rows="2" disabled></textarea>
                        <!--<input type="hidden" name="rpke-idpelatihan" id="rpke-idpelatihan"
                            class="form-control rounded-0">-->
                        <span class="input-group-append">
                            <button type="button" class="btn btn-info btn-flat" id="btn-rpke-searching">?</button>
                        </span>
                    </div>

                    <hr>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary btn-flat" id="btn_evaluasi_eks" disabled>Evaluasi
                            Eks</button>
                        <button type="submit" class="btn btn-primary btn-flat" id="btn-rpke-update">Update</button>
                        <button type="button" class="btn btn-danger btn-flat float-right"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tema Pelatihan -->
<div class="modal fade" id="modal-tema-pelatihan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Tema Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<table id="tb_listtema" class="table table-bordered table-striped dataTable">-->
                <div class="table-responsive">
                    <table id="tb_listtema" class="table table-hover text-wrap" style="width:100%">
                        <!--<table id="tb_listtema" class="table table-bordered table-hover text-nowrap ">-->
                        <thead>
                            <th>id</th>
                            <th>Pilih</th>
                            <th style="width: min-content;">Kategori</th>
                            <th style="width: max-content;">Tema Pelatihan</th>
                            <th style="width: min-content;">Standar</th>
                            <th style="width: 10%;">Departemen</th>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-flat float-none" id="btn-pengajuantemabaru"><i
                            class="fa fa-plus"></i>
                        Pengajuan
                        Tema Baru</button>
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-primary btn-flat" id="pilih-tema"><i class="fa fa-check"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tema Baru -->
<div class="modal fade" id="modal-tambahtemabaru" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pengajuan Tema Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>Kategori</strong>
                <div class="input-group mb-3">
                    <select name="ttb-kategori" id="ttb-kategori"
                        class="form-control rounded-0 select2 @error('kategori') is-invalid @enderror"
                        style="width: 100%;" required>
                        <option value="">Pilih Kategori ...</option>
                        @foreach($kategori as $k)
                        <option value="{{$k->kategori_ojt}}">{{$k->kategori_ojt }}</option>
                        @endforeach
                    </select>
                </div>

                <strong>Departemen</strong>
                <div class="input-group mb-3">
                    <select name="ttb-deptsection" id="ttb-deptsection"
                        class="form-control rounded-0 select2 @error('dept_section') is-invalid @enderror"
                        style="width: 100%;" required>
                        <option value="">Pilih Departemen ...</option>
                        @foreach($dept_section as $d)
                        <option value="{{$d->dept_section}}">{{$d->dept_section }}</option>
                        @endforeach
                    </select>
                </div>

                <strong>Tema Pelatihan</strong>
                <div class="input-group mb-3">
                    <input type="text" class="form-control rounded-0" id="ttb-temapelatihan"
                        placeholder="Tema Pelatihan">
                </div>

                <div class="input-group mb-3">

                    <div class="container d-flex justify-content-center mt-100">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <span class="myratings" id="ttb-standar">0</span>
                                        <h4 class="mt-1">Standar</h4>

                                        <fieldset class="rating">
                                            <input type="radio" id="star4" name="rating" value="4" /><label class="full"
                                                for="star4" title="Pretty good - 4 stars"></label>
                                            <input type="radio" id="star3" name="rating" value="3" /><label class="full"
                                                for="star3" title="Meh - 3 stars"></label>

                                            <input type="radio" id="star2" name="rating" value="2" /><label class="full"
                                                for="star2" title="Kinda bad - 2 stars"></label>

                                            <input type="radio" id="star1" name="rating" value="1" /><label class="full"
                                                for="star1" title="Sucks big time - 1 star"></label>

                                            <input type="radio" class="fa fa-refresh col-md-3" name="rating"
                                                value="0" />Reset
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary float-right btn-flat" id="btn-ajukan">Ajukan</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Evaluasi Eks -->
<div class="modal fade" id="modal_evaluasi_eks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Report Pelatihan Eksternal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--<table id="tb_listtema" class="table table-bordered table-striped dataTable">-->
                <div class="table-responsive">
                    <table id="tb_report_pelatihan_eksternal" class="table table-hover text-wrap" style="width:100%">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                                    <textarea name="ule_kelebihan" id="ule_kelebihan" cols="130"
                                                        class="form-control rounded-0" rows="1" placeholder="Kelebihan"
                                                        required></textarea>
                                                </div>
                                                <div class="input-group" style="padding-left: 10%;">
                                                    <textarea name="ule_kekurangan" id="ule_kekurangan" cols="130"
                                                        class="form-control rounded-0" rows="1" placeholder="Kekurangan"
                                                        required></textarea>
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
                                                    <textarea name="ule_saran" id="ule_saran" cols="130"
                                                        class="form-control rounded-0" rows="1"
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
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>


<script type="text/javascript">


    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
        })

        var start = moment();
        var end = moment();

        $('#daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        })
    })


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

        $("#rpk-nama").change(function () {
            var noinduk = $(this).children("option:selected").html();
            var namaoperator = $(this).children("option:selected").val();
            //    var dept = $(this).children("option:selected").val();
            var per = $("#periode").val();
            $("#rpk-nik").val(noinduk);
            $("#nama").val(namaoperator);
            //    $("#departemen").val(dept);

        });

        $("#rpke_nama").change(function () {
            var rpke_noinduk = $(this).children("option:selected").html();
            var rpke_namaoperator = $(this).children("option:selected").val();
            //    var dept = $(this).children("option:selected").val();
            $("#rpke_nik").val(rpke_noinduk);
            $("#rnama").val(rpke_namaoperator);
            //    $("#departemen").val(dept);

        });

        $("input[type='radio']").click(function () {
            var sim = $("input[type='radio']:checked").val();
            //alert(sim);
            //console.log(sim);
            if (sim < 3) {
                $('.myratings').css('color', 'red');
                $(".myratings").text(sim);
            } else {
                $('.myratings').css('color', 'green');
                $(".myratings").text(sim);
            }

        });

        var key = localStorage.getItem('npr_token');

        var insm = $('#tb_all_sm').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/pga/inquery_all_skillmatrik',
                type: "POST",
                headers: { "token_req": key },
            },
            columnDefs: [
                {
                    targets: [5],
                    data: null,
                    defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-sm btn-flat'>Detail</button>"

                },
            ],

            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'nama_jabatan', name: 'nama_jabatan' },
                { data: 'tanggal_masuk', name: 'tanggal_masuk' },
                { data: 'dept_section', name: 'dept_section' },

            ],
        });

        var list_ltp = $('#tb_ltp').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ordering: false,
            lengthChange: false,
            autoWidth: false,
            ajax: {
                url: APP_URL + '/api/pga/inquerypengajuantema',
                type: "POST",
                headers: { "token_req": key },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [6],
                data: null,
                defaultContent: "<button type='button' class='btn btn-outline-success btn-xs btn-flat'>Approve</button> <button type='button' class='btn btn-outline-danger btn-xs btn-flat'>Tolak</button>"

            },
            ],

            columns: [
                { data: 'id_tema_pelatihan', name: 'id_tema_pelatihan' },
                { data: 'kategori', name: 'kategori' },
                { data: 'tema_pelatihan', name: 'tema_pelatihan' },
                { data: 'dept_section', name: 'dept_section' },
                { data: 'standar', name: 'standar', width:'7px', text:'center' },
                { data: 'user_pengaju', name: 'user_pengaju' },

            ],
        });

        $('#tb_ltp').on('click', '.btn-outline-success', function () {
            var data = list_ltp.row($(this).parents('tr')).data();
            var idltp = data.id_tema_pelatihan;
            var a = 'Approve';
            var conf = confirm("Tema Pelatihan : " + data.tema_pelatihan + " \n" + "Standar             : " + data.standar + "\n" + "\n" + "Apakah anda akan Approve data diatas ?");
            if (conf) {
                get_approve(idltp, a);
            }
        });

        $('#tb_ltp').on('click', '.btn-outline-danger', function () {
            var data = list_ltp.row($(this).parents('tr')).data();
            var idltp = data.id_tema_pelatihan;
            var a = 'Tolak';
            var conf = confirm("Tema Pelatihan : " + data.tema_pelatihan + "\n" + "\n" + "Apakah data tsb akan diTolak ?");
            if (conf) {
                get_approve(idltp, a);
            }
        });


        var list_skb = $('#tb_skillmatrik').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            autoWidth: false,
            ajax: {
                url: APP_URL + '/api/pga/inqueryskillkaryawanbaru',
                type: "POST",
                headers: { "token_req": key },
            },
            columnDefs: [{

            },
                /*{
                    targets: [4],
                    data: null,
                    defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-sm btn-flat'>Pelatihan</button>"
    
                },*/
            ],

            columns: [
                { data: 'nik', name: 'nik', width:'7px' },
                { data: 'nama', name: 'nama' },
                { data: 'dept_section', name: 'dept_section', width:'20px' },

            ],
        });

        var list_temapelatihan = $('#tb_listtema').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            autoWidth: false,  
            ajax: {
                url: APP_URL + '/api/pga/inquerytemapelatihan',
                type: "POST",
                headers: { "token_req": key },
            },

            columnDefs: [
                {
                    targets: [0],
                    visible: false,
                    searchable: false
                },
                {
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    className: 'select-checkbox',
                    targets: 1,
                    width:'4%',
                },
            ],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },

            columns: [
                { data: 'id_tema_pelatihan', name: 'id_tema_pelatihan' },
                { data: null, name: 'check'},
                { data: 'kategori', name: 'kategori', width:'15%' },
                { data: 'tema_pelatihan', name: 'tema_pelatihan', width:'56%' },
                { data: 'standar', name: 'standar', class: 'text-center', width:'5%' },
                { data: 'dept_section', name: 'dept_section', width:'15px'},
            ],
        });

        var list_penyelenggara = $('#tb_listpenyelenggara').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            autoWidth: false,
            ajax: {
                url: APP_URL + '/api/pga/inquerypenyelenggara',
                type: "POST",
                headers: { "token_req": key },
            },

            columnDefs: [
                {
                    targets: [0],
                    visible: false,
                    searchable: false
                },
                {
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    className: 'select-checkbox',
                    targets: 1,
                    width:'4%',
                },
            ],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },

            columns: [
                { data: 'id_penyelenggara', name: 'id_penyelenggara' },
                { data: null, name: 'check' },
                { data: 'mulai_pelatihan', name: 'mulai_pelatihan' },
                { data: 'selesai_pelatihan', name: 'selesai_pelatihan' },
                { data: 'penyelenggara', name: 'penyelenggara' },
                { data: 'instruktur', name: 'instruktur' },
                { data: 'tempat', name: 'tempat', class: 'text-center' },
                { data: 'materi', name: 'materi' },
                { data: 'inputor', name: 'inputor', width:'5%' },
            ],
        });

        $('#pilih_penyelenggara').click(function () {
            var data_p = list_penyelenggara.row({ selected: true }).data();

            if (!data_p) {
                alert('Pilih Data Penyelenggara .');
            } else {
                $('#modal-rencanapelatihankaryawaneksternal').modal('show');
                $('#modal_list_penyelenggara').modal('toggle');
                $("#id_rpke_penyelenggara").val(data_p.id_penyelenggara);
                $("#rpke_tema").val(data_p.materi + "  " + data_p.tempat + "  " + data_p.mulai_pelatihan + " - " + data_p.selesai_pelatihan);
                $("#rpke_tema1").val(data_p.materi + "  " + data_p.tempat + "  " + data_p.mulai_pelatihan + " - " + data_p.selesai_pelatihan);
                /*$("#rpk-idpelatihan").val(data.id_tema_pelatihan);
                $("#rpk-tema").val(data.tema_pelatihan);
                $("#rpk-tema1").val(data.tema_pelatihan);
                */
            }
        });


        $('#tb_skillmatrik').on('click', '.btn-flat', function () {
            /*var data = list_skb.row($(this).parents('tr')).data();
            $("#id_t").val(data.id_rencana_pelatihan);
            $('#nama option[value=' + data.nik + ']').attr('selected', 'selected');
            $("#rpk-nik").val(data.nik);
            $("#rpk-nama").val(data.nama);
            $("#e-departemen").html(data.dept_pelatihan);
            /*
            get_rp();
            $('#modal-pelatihan').modal('show');          
*/
            /*   $('label[for=a]').hide();
               $("#rpk-nama option[value=' + data.nik + ']").hide();
   
               get_rpk();
               $('#modal-rencanapelatihankaryawan').modal('show');*/
        });

        $('#btn-rencanapelatihan').click(function () {
            $('#modal-menu-inteks').modal('show');
        });

        $('#btn_internal').click(function () {
            $("#modal-menu-inteks").modal('toggle');
            get_rpk();
            $('#modal-rencanapelatihankaryawan').modal('show');
        });

        $('#btn_eksternal').click(function () {
            $("#modal-menu-inteks").modal('toggle');
            $('#modal-rencanapelatihankaryawaneksternal').modal('show');
        });

        /*$('#btn_penyelenggara').click(function () {
            $("#modal-menu-inteks").modal('toggle');
            $('#modal_penyelenggara').modal('show');
        });*/

        $("#btn_tambah_penyelenggara").click(function () {
            $('#modal_list_penyelenggara').modal('toggle');
            $('#modal_penyelenggara').modal('show');
        });

        $('#btn-searching').click(function () {
            //get_temapelatihan();
            $('#modal-tema-pelatihan').modal('show');
        });

        $('#btn-rpk-searching').click(function () {

            $('#modal-tema-pelatihan').modal('show');
        });

        $('#btn-rpke-searching').click(function () {
            //$('#modal-rencanapelatihankaryawaneksternal').modal('toggle');
            $('#modal-rencanapelatihankaryawaneksternal').modal('hide');
            $('#modal_list_penyelenggara').modal('show');
        });

        $('#btn-pengajuantemabaru').click(function () {
            get_ttb();
            $('#modal-tambahtemabaru').modal('show');
            $('#modal-tema-pelatihan').modal('hide');
        });

        $('#btn_rpk_tambah').click(function () {
            var isitujuan = $("#rpk_isitujuan").val();
            //var instruktur = $("#rpk_instruktur").val();

            if (!isitujuan) {
                alert('isitujuan Belum diisi .');
                //} else if (!instruktur) {
                //    alert('Harap masukkan instruktur .')
            } else {
                var baris_baru = '<tr><td><input type ="hidden" name="rpk_isitujuan[]" value="' + isitujuan + '" />' + isitujuan + '</td><td><button type="button" class="btnSelect btn btn-xs btn-danger">Hapus</button></td></tr>';
                $('#tb_isitujuan tbody').append(baris_baru);
                $('#rpk_isitujuan').val('');
                //$('#rpk_instruktur').val('').trigger('change');

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

        $("#form-rpk-pelatihan").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var tema = $("#rpk-tema").val();
            var isi = $("#diffisi").html();
            if (tema == null || tema == '') {
                alert('Tema Pelatihan Belum diisi .')
            } else if (isi <= 0) {
                alert('Isi dan Tujuan Belum diisi .')
            } else {
                $.ajax({
                    url: APP_URL + '/api/pga/form_rpk',
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

        $("#form-rpk-pelatihan-eksternal").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var tema = $("#rpke_tema").val();
            if (tema == null || tema == '') {
                alert('Materi Pelatihan Belum diisi .')
            } else {
                $.ajax({
                    url: APP_URL + '/api/pga/form_rpke',
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


        $("#btn-ajukan").click(function () {
            var kategori = $("#ttb-kategori").val();
            var dept_section = $("#ttb-deptsection").val();
            var tema_pelatihan = $("#ttb-temapelatihan").val();
            var standar = $("#ttb-standar").html();
            var st = $("#ttb-sta").html();

            if (kategori == null || kategori == '' || dept_section == null || dept_section == '' || tema_pelatihan == null || tema_pelatihan == '') {
                alert('Terdapat isian yang Kosong .');
            } else if (standar == '0') {
                alert('Standar Pelatihan belum dipilih .')
            } else {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/pga/ajukantemabaru",
                    headers: {
                        "token_req": key
                    },
                    data: {
                        "kategori": kategori, "dept_section": dept_section, "tema_pelatihan": tema_pelatihan, "standar": standar, "st": st,
                    },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $('#modal-tambahtemabaru').modal('toggle');
                            //$('#modal-tema-pelatihan').modal('show');
                            //list_temapelatihan.ajax.reload();
                            location.reload();
                        } else
                            alert(resp.message);

                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    });
            }
        });

        $('#pilih-tema').click(function () {
            var data = list_temapelatihan.row({ selected: true }).data();

            if (!data) {
                alert('Pilih Data .');
            } else {
                $('#modal-tema-pelatihan').modal('toggle');
                $("#r-idpelatihan").val(data.id_tema_pelatihan);
                $("#r-temapelatihan").val(data.tema_pelatihan);

                $("#rpk-idpelatihan").val(data.id_tema_pelatihan);
                $("#rpk-tema").val(data.tema_pelatihan);
                $("#rpk-tema1").val(data.tema_pelatihan);
            }
        });

        $('#btn_listskillmatrik').click(function () {
            window.location.href = "{{ route('listnamasm')}}";
        });

        $('#btn_laporanpelaksanaanojt').click(function () {
            window.location.href = "{{ route('listOJT')}}";
        });

        $('#form_pp_eksternal').submit(function (e) {
            e.preventDefault();
            var datas = $(this).serialize();

            $.ajax({
                type: "POST",
                url: APP_URL + "/api/pga/pp_update_eksternal",
                headers: {
                    "token_req": key
                },
                data: datas,
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert(resp.message);
                        $('#modal_penyelenggara').modal('toggle');
                        $('#modal_list_penyelenggara').modal('show');
                        list_penyelenggara.ajax.reload();
                        //location.reload();
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                });

        });

        $("#btn_pp_list").click(function () {
            $('#modal_list_penyelenggara').modal('show');
        })

        $("#btn_evaluasi_eks").click(function () {

            var list_rpke = $('#tb_report_pelatihan_eksternal').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/pga/inquery_rpke',
                    type: "POST",
                    headers: { "token_req": key },
                },

                columnDefs: [
                    {
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [9],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function (data, type, row, meta) {
                            if (data.poin_pelatihan == null || data.poin_pelatihan == '') {
                                return "<button class='btn btn-primary btn-xs'>Update Laporan</button>";
                            } else if (data.status_pelatihan == 'Komen Atasan') {
                                return "<i style='font-size:14px; color:red;'>Komen Atasan</i>";
                            }
                        }
                    },
                    {
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

            $('#modal_evaluasi_eks').modal('show');

            $("#tb_report_pelatihan_eksternal").on('click', '.btn-primary', function () {
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

            $("#tb_report_pelatihan_eksternal").on('click', '.btn-outline-secondary', function () {
                var data = list_rpke.row($(this).parents('tr')).data();
                //alert(data.id_pelatihan_eksternal);
                $("#us_idpelatihan").val(data.id_pelatihan_eksternal)
                $("#modal_us").modal('show');
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
                            $('#modal_evaluasi_eks').modal('show');
                            list_rpke.ajax.reload();
                        } else {
                            list_rpke.ajax.reload();
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    });
            });

            $("#tb_report_pelatihan_eksternal").on('click', '.btn-outline-info', function () {
                var data = list_rpke.row($(this).parents('tr')).data();

                var fpath = APP_URL + "/storage/img/pga/sertifikat/" + data.lampiran_sertifikat;
                window.open(fpath, '_blank');
            });

            /*$("#form_ule").submit(function (e) {
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
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $("#modal_ule").modal('toggle');
                            $('#modal_evaluasi_eks').modal('show');
                            list_rpke.ajax.reload();
                        }
                        else
                            alert(resp.message);
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    })
                    .always(function () {
                    });
            });*/
        })

        $('#tb_all_sm').on('click', '.btn-flat', function () {
            var data = insm.row($(this).parents('tr')).data();
            $("#namasm").val(data.nik);
            //alert(data.nik);
            //window.location.href = APP_URL + "/pga/listskillmatrik/" + data.nik + "/" + data.nama;
            window.location.href = APP_URL + "/pga/all_skillmatrik/" + data.nik + "/" + data.nama;
        });





        /*function get_temapelatihan() {
            var key = localStorage.getItem('npr_token');
            var list_temapelatihan = $('#tb_listtema').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/pga/inquerytemapelatihan',
                    type: "POST",
                    headers: { "token_req": key },
                },

                columnDefs: [
                    {
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        className: 'select-checkbox',
                        targets: 1,
                    },
                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },

                columns: [
                    { data: 'id_tema_pelatihan', name: 'id_tema_pelatihan' },
                    { data: null, name: 'check' },
                    { data: 'kategori', name: 'kategori' },
                    { data: 'tema_pelatihan', name: 'tema_pelatihan' },
                    { data: 'standar', name: 'standar', class: 'text-center' },
                    { data: 'dept_section', name: 'dept_section' },
                ],
            });
        }
        */

        function get_ttb() {
            $("#ttb-kategori").val('').trigger('change');
            $("#ttb-deptsection").val('').trigger('change');
            $("#ttb-temapelatihan").val('');
            $("#ttb-standar").val('');
            $(".myratings").text(0);
        }

        function get_rp() {
            $("#r-temapelatihan").val('');
            $("#r-levelpelatihan").val($("#r-levelpelatihan").data("default-value")); //default select option
            $("#r-mulaipelatihan").val('');
            $("#r-selesaipelatihan").val('');
        }

        function get_rpk() {
            $("#rpk-nama").val('').trigger('change'); //default select2
            $("#rpk-nik").val('');
            $("#rpk-tema").val('');
            $("#rpk-tema1").val('');
            $("#rpk-level").val('').trigger('change');
            $("#rpk-lokasi").val('').trigger('change');
            $("#rpk-mulai").val('');
            $("#rpk-selesai").val('');
            $("#rpk-isitujuan").val('');
            $("#rpk-instruktur").val('').trigger('change');
        }

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

        function get_approve(idltp, a) {
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/pga/approvetemapelatihan",
                headers: {
                    "token_req": key
                },
                data: {
                    "idltp": idltp, "a": a,

                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert(resp.message);
                        location.reload();
                        //$('#modal-tambahtemabaru').modal('toggle');
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                });
        }


    });




</script>

@endsection