@extends('layout.main')

@section('content')

@if(Session::has('alert-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('alert-success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(Session::has('alert-danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{Session::get('alert-danger')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-md-6">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">

                </div>

                <h3 class="profile-username text-center" id="no_masalah">{{$detail->no_laporan}}</h3>
                <strong>
                    <h5 class="text-muted text-center">{{$detail->nama}} / {{$detail->nik}}</h5>
                    <p class="text-muted text-center">{{$detail->jenis_laporan}}</p>
                </strong>
                @foreach ($eval as $e)
                <tr>
                    <td><span class="badge" style="font-size: large;">{{$e->jenis_evaluasi}} :</span></td>
                    <td><span class="badge bg-success">S : {{$e->severity}}</span></td>
                    <td><span class="badge bg-success">F : {{$e->frekwensi}}</span></td>
                    <td><span class="badge bg-success">P : {{$e->possibility}}</span></td>
                    <td><span class="badge bg-warning">Point : {{$e->point}}</span></td>
                    <td><span class="badge bg-danger">Level : {{$e->level_resiko}}</span></td>
                </tr>
                @endforeach
                <br>
                <br>
                @if($detail->foto_kondisi != null)
                <a href="#" class="link-black text-sm link-fotokondisi" id="{{$detail->foto_kondisi}}"
                    name="{{$detail->foto_kondisi}}">
                    <img class="float-right img-fluid active" src="{{url('storage/img/hk/')}}/{{$detail->foto_kondisi}}"
                        style="width: 190px; height: auto; display: inline;">
                </a>

                @endif

                <div class="row">
                    <div class="col col-md-12">

                        <ul class="list-group list-group-unbordered mb-6">
                            <li class="list-group-item">
                                <b>Status </b>
                                @if($detail->status_laporan == 'Open')
                                <a class="float-right btn btn-warning btn-xs">{{$detail->status_laporan}}</a>
                                @else
                                <a class="float-right btn btn-success btn-xs">{{$detail->status_laporan}}</a>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Progress </b>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="70"
                                        aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{$status['persen'] * 100}}%">
                                        <span> <strong>{{number_format($status['persen'] * 100,2)}}%
                                                Complete</strong></span>
                                    </div>
                                </div>
                            </li>

                        </ul>
                        @foreach ($eval as $p)
                        @if(Session::get('dept') == 'HSE' || Session::get('dept') ==
                        'Admin')
                        <span class="float-left">
                            <a href="#" class="link-black text-sm btn-edit-1" id="{{$p->id_evaluasi}}">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </span>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class=" card card-primary">
            <div class="card-header">
                <h3 class="card-title">Detail</h3>
                @if(Session::get('dept') == 'HSE' || Session::get('dept') == 'Admin')
                <a href="#" class="float-right" id="edit_details"><i class="fa fa-edit"></i>
                    Edit</a>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat Kejadian</strong>
                <p class="text-muted" id="t_tempat_kejadian">{{$detail->tempat_kejadian}}
                </p>

                <hr>
                <strong><i class="fas fa-book mr-1"></i> Pada Saat</strong>
                <p class="text-muted" id="t_pada_saat">{{$detail->pada_saat}}</p>

                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Menjadi</strong>
                <p class="text-muted" id="t_menjadi">{{$detail->menjadi}}</p>

                <hr>
                <strong><i class="fas fa-pencil-alt mr-1"></i> Solusi Perbaikan</strong>
                <p class="text-muted" id="t_solusi_perbaikan">{{$detail->solusi_perbaikan}}
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @if($detail->status_laporan == 'Open')

        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-danger" id="btn_delete"><i class="fa fa-trash"></i>
                    Delete</button>
            </div>
        </div>
        @endif
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Tindakan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>

                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">

                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-10"></div>
                            @if(Session::get('dept') == 'HSE' || Session::get('dept') ==
                            'Admin')
                            <div class="col-md-2">
                                <button class="btn btn-success float-right" id="btn_tindakan"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            @endif
                        </div>

                        <!-- Post -->
                        @foreach ($tindakan as $item)

                        <div class="post">
                            <div class="user-block">
                                @if($item->status_laporan == 'Close')
                                <img class="img-circle" src="{{asset('/assets/img/check_icon.png')}}" alt="user image">
                                @else
                                <img class="img-circle" src="{{asset('/assets/img/info.png')}}" alt="user image">
                                @endif
                                <span class="username">
                                    <a href="#" id="pic_{{$item->id_tindakan}}">{{$item->evaluator}}</a>

                                </span>
                                <span class="description">Dibuat
                                    {{$item->created_at}}</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                {{$item->tindakan}}
                            </p>

                            <tr>
                                <td><span class="badge" style="font-size: large;">{{$item->jenis_evaluasi}}
                                        :</span>
                                </td>
                                <td><span class="badge bg-success">S :
                                        {{$item->severity}}</span></td>
                                <td><span class="badge bg-success">F :
                                        {{$item->frekwensi}}</span></td>
                                <td><span class="badge bg-success">P :
                                        {{$item->possibility}}</span></td>
                                <td><span class="badge bg-warning">Point :
                                        {{$item->point}}</span></td>
                                <td><span class="badge bg-danger">Level :
                                        {{$item->level_resiko}}</span></td>
                            </tr>

                            @if($item->lampiran != null)
                            <a href="#" class="link-black text-sm link-lampiran" id="{{$item->lampiran}}"
                                name="{{$item->lampiran}}">
                                <img class="float-right img-fluid active"
                                    src="{{url('storage/img/hk/')}}/{{$item->lampiran}}"
                                    style="width: 175px; height: auto; ">
                            </a>
                            @endif


                            <p>
                                @if($item->status_tindakan == 'Close')
                            <div class="text-sm btn btn-success btn-xs">
                                <i class="fas fa-star mr-1"></i> Close
                            </div>
                            <a href="#" class="link-black text-sm"><i class="far fa-calendar-check mr-1"></i>
                                Selesai
                                : {{$item->tgl_evaluasi}}</a>
                            @else
                            <div class="text-sm btn btn-warning btn-xs">
                                <i class="far fa-star mr-1"></i> Open
                            </div>
                            <a href="#" class="link-black text-sm col-md-4"><i class="far fa-calendar-check mr-1"></i>
                                Target
                                : {{$item->tgl_evaluasi}}</a>
                            @endif


                            <br>
                            <br>
                            @if(Session::get('dept') == 'HSE' || Session::get('dept') ==
                            'Admin')
                            <span class="float-left">
                                <a href="#" class="link-black text-sm btn-edit" id="{{$item->id_evaluasi}}">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </span>
                            @endif
                            </p>


                        </div>
                        <!-- /.post -->
                        @endforeach


                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <div class="timeline timeline-inverse">
                            <!-- timeline time label -->

                        </div>
                    </div>
                    <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>

<!-- Modal Tindakan -->
<div class="modal fade" id="modal_tindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tindakan">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Jenis Tindakan</label></div>
                        <div class="col col-md-5">
                            <input type="hidden" id="id_hhky" name="id_hhky" value="{{$detail->id_hhky}}">
                            <select class="form-control" name="jenis_evaluasi" id="jenis_evaluasi">
                                <option value="Temporary">Temporary</option>
                                <option value="After">After</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Tindakan</label></div>
                        <div class="col col-md-7">
                            <textarea class="form-control" name="tindakan" id="tindakan" cols="50" rows="3"
                                placeholder="Tindakan" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Tanggal Evaluasi</label></div>
                        <div class="col col-md-7">
                            <input type="date" id="tgl_evaluasi" name="tgl_evaluasi" class="form-control" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Evaluator</label></div>
                        <div class="col col-md-7">
                            <input type="text" id="evaluator" name="evaluator" class="form-control"
                                placeholder="Nama Penanggung Jawab" required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-5"><label>Severity/Keparahan</label></div>
                        <label> : </label>
                        <div class="col col-md-3">
                            <input type="hidden" id="severity1" name="severity1">
                            <select class="form-control" name="severity" id="severity" onchange="sum();" required>
                                <option value="">Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="6">6</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-5"><label for="frekwensi">
                                Frekwensi/Keseringan</label></div>
                        <label> : </label>
                        <div class="col col-md-3">
                            <input type="hidden" id="frekwensi1" name="frekwensi1">
                            <select class="form-control" name="frekwensi" id="frekwensi" onchange="sum();" required>
                                <option value="">Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-5"><label for="possibility">
                                Possibility/Kemungkinan</label>
                        </div>
                        <label> : </label>
                        <div class="col col-md-3">
                            <input type="hidden" id="possibility1" name="possibility1">
                            <select class="form-control" name="possibility" id="possibility" onchange="sum();" required>
                                <option value="">Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-2" style="text-align: right;">
                            <label for="poin"> Poin</label>
                        </div>
                        <div class="col col-md-2">
                            <input type="hidden" id="poin1" name="poin1">
                            <input type="text" id="poin" name="poin" class="form-control"
                                style="color:red; font-size:x-large; text-align: center;" disabled>
                        </div>

                        <div class="col col-md-2" style="text-align: right;">
                            <label for="rank"> Rank</label>
                        </div>
                        <div class="col col-md-2">
                            <input type="hidden" id="rank1" name="rank1">
                            <input type="text" name="rank" id="rank" class="form-control"
                                style="color: blue; font-size:x-large; text-align: center;" disabled>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="btn_simpan" name="btn_simpan" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal Tindakan-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLongTitle">Edit Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" enctype="multipart/form-data" name="form_edit" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Isi Tindakan</label></div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_evaluasi" name="id_evaluasi">
                            <textarea class="form-control" name="edit_evaluasi" id="edit_evaluasi" cols="60" rows="3"
                                placeholder="Tindakan" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-5"><label>Rencana Selesai</label>
                            <div class="col col-md-12">
                                <input type="date" id="edit_tgl_evaluasi" name="edit_tgl_evaluasi" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col col-md-4"><label>Penanggung Jawab</label>
                            <div class="col col-md-14">
                                <input type="text" id="edit_evaluator" name="edit_evaluator" class="form-control"
                                    placeholder="Nama Penanggung Jawab">

                            </div>
                        </div>

                        <div class="col col-md-3"><label>Status</label>
                            <div class="col col-md-12 id2" style="float: right;">
                                <select class="form-control" name="edit_status_tindakan" id="edit_status_tindakan">
                                    <option value="Open">Open</option>
                                    <option value="Close">Close</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group row">
                        <div class="col col-md-4"><label>Severity</label>
                            <div class="col col-md-12">
                                <select class="form-control" name="tseverity" id="tseverity" onchange="sum();" required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="6">6</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-4"><label for="frekwensi">
                                Frekwensi</label>
                            <div class="col col-md-12">
                                <select class="form-control" name="tfrekwensi" id="tfrekwensi" onchange="sum();"
                                    required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-4"><label for="possibility" style="float: center;">
                                Possibility</label>
                            <div class="col col-md-12" style="float: center;">
                                <select class="form-control" name="tpossibility" id="tpossibility" onchange="sum();"
                                    required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-2">
                            <label for="poin"> Poin</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="hidden" id="tpoin1" name="tpoin1">
                            <input type="text" id="tpoin" name="tpoin" class="form-control"
                                style="color:red; font-size:x-large; text-align: center;" disabled>
                        </div>

                        <div class="col col-md-2">
                            <label for="rank" style="float: right;"> Rank</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="hidden" id="trank1" name="trank1">
                            <input type="text" name="trank" id="trank" class="form-control"
                                style="color: blue; font-size:x-large; text-align: center;" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>File Lampiran</label></div>
                        <div class="col col-md-6">
                            <input type="file" class="form-control" id="lampiran" name="lampiran">
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <button type="button" id="btn_hapus" class="btn btn-danger"><i class="fa fa-trash"></i>
                                Delete</button>
                        </div>
                        <div class="col-md-4">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" id="edit_simpan" name="edit_simpan"
                                value="Update">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal point Tindakan Before-->
<div class="modal fade" id="modal_edit_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLongTitle">Edit Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_1" enctype="multipart/form-data" name="form_edit_1" method="POST">
                    @csrf
                    @foreach ($eval as $e)
                    <div class="form-group row">
                        <div class="col col-md-4"><label>{{ $e->jenis_evaluasi}}</label></div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_evaluasi2" name="id_evaluasi2">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Severity</label>
                            <div class="col col-md-12">
                                <select class="form-control" name="eseverity" id="eseverity" onchange="sum();" required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="6">6</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-4"><label for="frekwensi">
                                Frekwensi</label>
                            <div class="col col-md-12">
                                <select class="form-control" name="efrekwensi" id="efrekwensi" onchange="sum();"
                                    required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-4"><label for="possibility" style="float: center;">
                                Possibility</label>
                            <div class="col col-md-12" style="float: center;">
                                <select class="form-control" name="epossibility" id="epossibility" onchange="sum();"
                                    required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-2">
                            <label for="poin"> Poin</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="hidden" id="epoin1" name="epoin1">
                            <input type="text" id="epoin" name="epoin" class="form-control"
                                style="color:red; font-size:x-large; text-align: center;" disabled>
                        </div>

                        <div class="col col-md-2">
                            <label for="rank" style="float: right;"> Rank</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="hidden" id="erank1" name="erank1">
                            <input type="text" name="erank" id="erank" class="form-control"
                                style="color: blue; font-size:x-large; text-align: center;" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-3">
                            <label>File Lampiran</label>
                        </div>
                        <div class="col col-md-9">
                            <input type="file" class="form-control" id="lampiran" name="lampiran">
                        </div>

                    </div>
                    <div class="modal-footer">
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" id="edit_simpan_1" name="edit_simpan_1"
                                value="Update">
                        </div>
                    </div>
            </div>


            </form>
        </div>
    </div>
</div>

<!--Edit Modal HH KY-->
<div class="modal fade" id="edit_masalah_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit HH KY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_masalah">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Tempat Kejadian</label></div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_hhky" name="id_hhky" value="{{$detail->id_hhky}}">
                            <input type="text" class="form-control" name="edit_tempat_kejadian"
                                id="edit_tempat_kejadian" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Pada Saat</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="edit_pada_saat" name="edit_pada_saat" class="form-control" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Menjadi</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="edit_menjadi" name="edit_menjadi" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Solusi Perbaikan</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="edit_solusi_perbaikan" name="edit_solusi_perbaikan"
                                class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <input type="submit" class="btn btn-primary" id="edit_simpan" name="edit_simpan" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-img" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="img-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" id="link-fotokondisi" class="img-fluid" style="width:100%">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-img-lampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="img-title-1"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" id="link-lampiran" class="img-fluid" style="width:100%">
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

<script>


    function sum() {
        var severity = document.getElementById('severity').value;
        var frekwensi = document.getElementById('frekwensi').value;
        var possibility = document.getElementById('possibility').value;
        var result = parseInt(severity) + parseInt(frekwensi) + parseInt(possibility);

        var eseverity = document.getElementById('eseverity').value;
        var efrekwensi = document.getElementById('efrekwensi').value;
        var epossibility = document.getElementById('epossibility').value;
        var eresult = parseInt(eseverity) + parseInt(efrekwensi) + parseInt(epossibility);

        var tseverity = document.getElementById('tseverity').value;
        var tfrekwensi = document.getElementById('tfrekwensi').value;
        var tpossibility = document.getElementById('tpossibility').value;
        var tresult = parseInt(tseverity) + parseInt(tfrekwensi) + parseInt(tpossibility);

        if (!isNaN(result)) {
            document.getElementById('poin1').value = result;
            document.getElementById('poin').value = result;
        }
        if (result >= 19 && result <= 25) {
            document.getElementById('rank1').value = "V";
            document.getElementById('rank').value = "V";
        } else if (result >= 15 && result <= 18) {
            document.getElementById('rank1').value = "IV";
            document.getElementById('rank').value = "IV";
        } else if (result >= 8 && result <= 14) {
            document.getElementById('rank1').value = "III";
            document.getElementById('rank').value = "III";
        } else if (result >= 4 && result <= 7) {
            document.getElementById('rank1').value = "II";
            document.getElementById('rank').value = "II";
        } else {
            document.getElementById('rank1').value = "I";
            document.getElementById('rank').value = "I";
        }

        if (!isNaN(eresult)) {
            document.getElementById('epoin1').value = eresult;
            document.getElementById('epoin').value = eresult;
        }
        if (eresult >= 19 && eresult <= 25) {
            document.getElementById('erank1').value = "V";
            document.getElementById('erank').value = "V";
        } else if (eresult >= 15 && eresult <= 18) {
            document.getElementById('erank1').value = "IV";
            document.getElementById('erank').value = "IV";
        } else if (eresult >= 8 && eresult <= 14) {
            document.getElementById('erank1').value = "III";
            document.getElementById('erank').value = "III";
        } else if (eresult >= 4 && eresult <= 7) {
            document.getElementById('erank1').value = "II";
            document.getElementById('erank').value = "II";
        } else {
            document.getElementById('erank1').value = "I";
            document.getElementById('erank').value = "I";
        }

        if (!isNaN(tresult)) {
            document.getElementById('tpoin1').value = tresult;
            document.getElementById('tpoin').value = tresult;
        }
        if (eresult >= 19 && eresult <= 25) {
            document.getElementById('trank1').value = "V";
            document.getElementById('trank').value = "V";
        } else if (tresult >= 15 && tresult <= 18) {
            document.getElementById('trank1').value = "IV";
            document.getElementById('trank').value = "IV";
        } else if (tresult >= 8 && tresult <= 14) {
            document.getElementById('trank1').value = "III";
            document.getElementById('trank').value = "III";
        } else if (tresult >= 4 && tresult <= 7) {
            document.getElementById('trank1').value = "II";
            document.getElementById('trank').value = "II";
        } else {
            document.getElementById('trank1').value = "I";
            document.getElementById('trank').value = "I";
        }
    }

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        $("#btn_tindakan").click(function () {
            $("#modal_tindakan").modal("show");
        });

        $("#edit_details").click(function (e) {
            e.preventDefault();
            $("#edit_masalah").val($("#t_masalah").text());
            $("#edit_lokasi").val($("#t_lokasi").text());
            $("#edit_penyebab").val($("#t_penyebab").text());
            $("#edit_masalah_modal").modal("show");
        });

        $("#form_tindakan").submit(function (e) {
            e.preventDefault();
            var datas = $(this).serialize();
            var btn = $("#btn_simpan");

            btn.attr('disabled', true);
            $.ajax({
                type: "POST",
                url: APP_URL + "/hse/tindakan",

                data: datas,
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        //alert("Data Sudah Complete.");
                        location.reload();
                    }
                    else
                        location.reload();
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $(".btn-edit").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                type: "GET",
                url: APP_URL + "/api/tindakanHH/" + id,
                headers: {
                    "token_req": key
                },

                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        $("#id_evaluasi").val(resp.data.id_evaluasi);
                        $("#edit_evaluasi").html(resp.data.tindakan);
                        $("#edit_tgl_evaluasi").val(resp.data.tgl_evaluasi);
                        $("#edit_evaluator").val(resp.data.evaluator);
                        $("#div.id2 select").val(resp.data.status_tindakan);
                        $("#edit_jenis_tindakan").val(resp.data.jenis_evaluasi);
                        $("#tseverity").val(resp.data.severity);
                        $("#tfrekwensi").val(resp.data.frekwensi);
                        $("#tpossibility").val(resp.data.possibility);
                        $("#tpoin1").val(resp.data.point);
                        $("#trank1").val(resp.data.level_resiko);
                        $("#tpoin").val(resp.data.point);
                        $("#trank").val(resp.data.level_resiko);

                        $("#modal_edit").modal("show");
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $(".btn-edit-1").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                type: "GET",
                url: APP_URL + "/api/tindakanHH/" + id,
                headers: {
                    "token_req": key
                },

                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        $("#id_evaluasi2").val(resp.data.id_evaluasi);
                        $("#eseverity").val(resp.data.severity);
                        $("#efrekwensi").val(resp.data.frekwensi);
                        $("#epossibility").val(resp.data.possibility);
                        $("#epoin1").val(resp.data.point);
                        $("#erank1").val(resp.data.level_resiko);
                        $("#epoin").val(resp.data.point);
                        $("#erank").val(resp.data.level_resiko);

                        $("#modal_edit_1").modal("show");
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });


        $("#form_edit").submit(function (e) {
            e.preventDefault();
            var datas = new FormData(this);

            var c = confirm("Apakah anda akan merubah data ?");
            if (c) {
                var btn = $("#edit_simpan");

                btn.attr('disabled', true);
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/tindakanHH/update",

                    data: datas,
                    processData: false,
                    contentType: false,
                })
                    .done(function (resp) {
                        if (resp.success) {

                            location.reload();
                        } else {
                            location.reload();
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    });
            }
        });

        $("#form_edit_1").submit(function (e) {
            e.preventDefault();
            var datas = new FormData(this);

            var c = confirm("Apakah anda akan merubah data ?");
            if (c) {
                var btn = $("#edit_simpan_1");

                btn.attr('disabled', true);
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/tindakanHH/update",

                    data: datas,
                    processData: false,
                    contentType: false,
                })
                    .done(function (resp) {
                        if (resp.success) {

                            location.reload();
                        } else {
                            location.reload();
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    });
            }
        });

        $("#form_edit_masalah").submit(function (e) {
            e.preventDefault();
            var datas = $(this).serialize();
            var p = confirm("Apakah anda akan merubah data ini ?");

            if (p) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/update_hhky",
                    headers: { "token_req": key },
                    data: datas,
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        }
                        else {
                            alert(resp.message)
                            location.reload();
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            }
        });

        $("#edit_details").click(function (e) {
            e.preventDefault();
            $("#edit_tempat_kejadian").val($("#t_tempat_kejadian").text());
            $("#edit_pada_saat").val($("#t_pada_saat").text());
            $("#edit_menjadi").val($("#t_menjadi").text());
            $("#edit_solusi_perbaikan").val($("#t_solusi_perbaikan").text());
            $("#edit_masalah_modal").modal("show");
        });

        $(".link-lampiran").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $("#img-title-1").html($("#no_masalah").text());
            $("#link-lampiran").attr("src", '\{{url("storage/img/hk/")}}/' + id);
            $("#modal-img-lampiran").modal("show");
        });

        $(".link-fotokondisi").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');

            //var data = list_masalah.row($(this).parents('tr')).data();
            $("#img-title").html($("#no_masalah").text());
            $("#link-fotokondisi").attr("src", '\{{url("storage/img/hk/")}}/' + id);

            $("#modal-img").modal("show");
            //window.open(fpath, '_blank');
        });

        $("#btn_hapus").click(function () {
            var id_tindakan = $("#id_evaluasi").val();
            var r = confirm("Apakah akan menghapus data ini?")
            if (r) {

                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/tindakanHH/delete",
                    headers: {
                        "token_req": key
                    },
                    data: { id: id_tindakan },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            location.reload();
                        } else {
                            alert(resp.message);
                        }


                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            }
        });

        $("#btn_delete").click(function () {
            var data = $("#id_hhky").val();
            var nomer = $("#no_masalah").html();
            var conf = confirm("Apakah masalah No. " + nomer + " akan dihapus?");
            if (conf) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/hapus/hhky",
                    headers: { "token_req": key },
                    data: { "id": data },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert("Hapus HH KY berhasil");
                            window.location.href = "{{ route('hk_list')}}";
                        }
                        else {
                            alert(resp.message)
                            location.reload();
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            }
        });
    });
</script>

@endsection