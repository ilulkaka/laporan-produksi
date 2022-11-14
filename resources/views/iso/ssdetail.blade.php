@extends('layout.main')

@section('content')

<div class="row">
    <div class="col-md-5">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">

                </div>

                <h3 class="profile-username text-center" id="no_masalah">{{$detail->no_ss}}</h3>
                <strong>
                    <h5 class="text-muted text-center" id="t_nama">{{$detail->nama}} / {{$detail->nik}}</h5>
                    <p class="text-muted text-center">{{$detail->bagian}}</p>
                </strong>

                <p></p>
                <ul class="list-group list-group-unbordered mb-3">
                    @if($detail->status_ss <> 'Selesai')
                        <li class="list-group-item">
                            <b>Status </b>
                            @if($detail->status_ss == 'Tunda')
                            <a href="#" class="float-right" id="alasan_tunda" style="font-size: 14px">
                            <u>  Alasan</u></a>
                            <label class="float-right"> </label>
                            <a class="float-right btn btn-warning btn-xs btn-flat" style="margin-right: 10px" id="t_status_ss">{{$detail->status_ss}}</a>
                            @else
                            <a class="float-right btn btn-warning btn-xs btn-flat" id="t_status_ss">{{$detail->status_ss}}</a>
                            @endif
                        </li>
                        @else
                        <li class="list-group-item">
                            <b>Status </b>
                            <a class="float-right btn btn-danger btn-xs" style="color:white;"
                                id="t_status_ss">{{$detail->status_ss}}</a>
                        </li>
                        @endif
                        <li class="list-group-item">
                            <b>Poin SS </b>
                            <a class="float-right btn btn-success btn-xs">{{$detail->poin_ss}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Reward </b>
                            <a class="float-right btn btn-success btn-xs">{{$detail->reward}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tanggal Penyerahan </b>
                            <a class="float-right">{{$detail->tgl_penyerahan}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Foto Sebelum </b>
                            @if($detail->foto_before != null)
                            <a href="#" class="link-black text-sm link-add-before float-right" id="addfotobefore"
                                name="addfotobefore"><i class="fas fa-edit mr-1">
                                </i>Edit
                            </a>
                            <label class="float-right col-md-1"> </label>
                            <a href="#" class="link-black text-sm link-fotobefore float-right"
                                id="{{$detail->foto_before}}" name="{{$detail->foto_before}}"><i
                                    class="fas fa-paperclip mr-1">
                                </i>Lampiran
                            </a>
                            @else
                            <a href="#" class="link-black text-sm link-add-before float-right" id="addfotobefore"
                                name="addfotobefore"><i class="fas fa-plus mr-1">
                                </i>Add
                            </a>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <b>Foto Setelah </b>
                            @if($detail->foto_after != null)
                            <a href="#" class="link-black text-sm link-add float-right" id="addfoto" name="addfoto"><i
                                    class="fas fa-edit mr-1">
                                </i>Edit
                            </a>
                            <label class="float-right col-md-1"> </label>
                            <a href="#" class="link-black text-sm link-fotoafter float-right"
                                id="{{$detail->foto_after}}" name="{{$detail->foto_after}}"><i
                                    class="fas fa-paperclip mr-1">
                                </i>Lampiran
                            </a>
                            @else
                            <a href="#" class="link-black text-sm link-add float-right" id="addfoto" name="addfoto"><i
                                    class="fas fa-plus mr-1">
                                </i>Add
                            </a>
                            @endif
                        </li>

                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col col-md-7">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$detail->kategori}}</h3>
                @if($detail->status_ss <> 'Selesai')
                    @if(Session::get('dept') == 'SEKRETARIAT ISO' || Session::get('dept') == 'Admin')
                    <a href="#" class="float-right" id="btn_delete" style="color:yellow"><i class="fas fa-trash"
                            style="color:yellow"></i>
                        <u>Delete</u></a>
                    <label class="float-right"> </label>
                    <a href="#" class="float-right" style="margin-right: 15px;" id="edit_details"><i
                            class="fa fa-edit"></i>
                        <u>Edit </u></a>
                    @endif
                    @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Tema SS</strong>
                <p class="text-muted" id="t_tema_ss">{{$detail->tema_ss}}</p>
                <input type="hidden" id="id_ss" name="id_ss" value="{{$detail->id_ss}}">
                <input type="hidden" id="no_masalah" name="no_masalah" value="{{$detail->no_ss}}">

                <hr>
                <strong><i class="fas fa-book mr-1"></i> Masalah yang ada</strong>
                <p class="text-muted" id="t_masalah">{{$detail->masalah}}</p>

                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Ide SS</strong>
                <p class="text-muted" id="t_ide_ss">{{$detail->ide_ss}}</p>

                <hr>
                <strong><i class="fas fa-pencil-alt mr-1"></i> Tujuan SS</strong>
                <p class="text-muted" id="t_tujuan_ss">{{$detail->tujuan_ss}}</p>

                @if($detail->status_ss == 'ET1')
                <hr>
                <p></p>
                <div class="icheck-danger d-inline">
                    <input type="radio" name="r3" id="r-dijalankan" value="Pengerjaan">
                    <label for="r-dijalankan" style="color: green;">
                        Dijalankan
                    </label>
                </div>
                <div class="icheck-danger d-inline">
                    <input type="radio" name="r3" id="r-ditolak" value="Ditolak">
                    <label for="r-ditolak" style="color: red;">
                        Ditolak
                    </label>
                </div>
                <div class="icheck-danger d-inline">
                    <input type="radio" name="r3" id="r-ditunda" value="Tunda">
                    <label for="r-ditunda" style="color:blueviolet;">
                        Ditunda
                    </label>
                </div>

                <a href="#" class="float-right" id="btn_et1" style="color:green"><i class="fas fa-save"
                        style="color:green"></i>
                    <u>Simpan</u></a>
                <label class="float-right"> </label>
                @endif
            </div>
            <!-- /.card-body -->

        </div>


    </div>


</div>

<div class="row">
    <div class="col-md-6">

        <!-- Profile Image -->
        <div class="card card-success card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center" id="f_before">Foto Before</h3>
                <ul>

                    <a href="#" class="link-black text-sm link-fotokondisi" id="{{$detail->foto_kondisi}}"
                        name="{{$detail->foto_before}}">
                        <center>
                            <img src="{{url('storage/img/ss/before')}}/{{$detail->foto_before}}"
                                style="width: 450px; height: 450px; display: inline;">
                        </center>
                    </a>

                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-6">

        <!-- Profile Image -->
        <div class="card card-success card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center" id="f_after">Foto After</h3>
                <ul>

                    <a href="#" class="link-black text-sm link-fotokondisi" id="{{$detail->foto_kondisi}}"
                        name="{{$detail->foto_after}}">
                        <center>
                            <img src="{{url('storage/img/ss/after')}}/{{$detail->foto_after}}"
                                style="width: 450px; height: 450px;">
                        </center>
                    </a>

                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<!-- /.col -->

<div class="modal fade" id="edit_masalah_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large;"><b>{{$detail->kategori}}</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="modal-body">
                    <form id="form_edit_ss">
                        @csrf

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Tema SS</strong>

                        <textarea id="edit_tema_ss" name="edit_tema_ss" class="form-control" rows="2"></textarea>
                        <input type="hidden" id="id_ss" name="id_ss" value="{{$detail->id_ss}}">

                        <hr>
                        <strong><i class="fas fa-book mr-1"></i> Masalah yang ada</strong>
                        <textarea id="edit_masalah" name="edit_masalah" class="form-control" rows="3"
                            required></textarea>

                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> Ide SS</strong>
                        <textarea id="edit_ide_ss" name="edit_ide_ss" class="form-control" rows="2"></textarea>

                        <hr>
                        <strong><i class="fas fa-pencil-alt mr-1"></i> Tujuan SS</strong>
                        <textarea type="text" id="edit_tujuan_ss" name="edit_tujuan_ss" class="form-control"
                            rows="3"></textarea>

                        <hr>
                        <div class="form-group row">
                            <strong><i class="fas fa-mouse-pointer mr-1"></i> Status SS</strong>
                            <div class="col col-md-6">
                                <select name="edit_status_ss" id="edit_status_ss" class="form-control col-md-8">
                                    <option value="Masuk">Masuk</option>
                                    <option value="ET1">ET1</option>
                                    <option value="Pengerjaan">Pengerjaan</option>
                                    <option value="ET2">ET2</option>
                                    <option value="Ditolak">Ditolak</option>
                                    <option value="Tunda">Tunda</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>

                        <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>

                <input type="submit" class="btn btn-primary btn-flat" id="edit_simpan" name="edit_simpan"
                    value="Simpan">
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Add foto after-->
<div class="modal fade" id="modal-addfoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Foto</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form_add" enctype="multipart/form-data" name="form_add" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="form-control" id="foto_after" name="foto_after">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_ss" name="id_ss" value="{{$detail->id_ss}}">
                            <input type="hidden" class="form-control" name="edit_no_ss" id="edit_no_ss">

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="edit_simpan" name="edit_simpan" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add foto before-->
<div class="modal fade" id="modal-addfoto-before" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Foto</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form_add_before" enctype="multipart/form-data" name="form_add_before" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="form-control" id="foto_before" name="foto_before">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_ss" name="id_ss" value="{{$detail->id_ss}}">
                            <input type="hidden" class="form-control" name="edit_no_ss1" id="edit_no_ss1">

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="edit_simpan1" name="edit_simpan1"
                            value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak / Tunda -->
<div class="modal fade" id="modal-tolaktunda" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large;"><b>Problem</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="modal-body">

                    <strong><i class="fa fa-list-ol mr-1"></i> Keterangan</strong>

                    <textarea id="edit_tolaktunda" name="edit_tolaktunda" class="form-control" rows="2"
                        placeholder="Berikan alasan anda, mengapa SS ini ditolak atau ditunda ?"></textarea>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-flat" id="btn_close" name="btn_close">Close</button>

                <input type="button" class="btn btn-primary btn-flat" id="btn_tolaktunda" name="btn_tolaktunda"
                    value="Simpan">
            </div>

        </div>
    </div>
</div>

<!-- Modal Alasan Tunda -->
<div class="modal fade" id="modal_alasan_tunda" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: x-large;"><b>Tunda</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="modal-body">

                    <strong><i class="fa fa-list-ol mr-1"></i> Keterangan</strong>
                    <textarea id="a_tunda" name="a_tunda" class="form-control" rows="3"
                        placeholder="Alasan ditunda ." disabled>{{ $detail->keterangan }}</textarea>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
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

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');


        $("#form_edit_ss").submit(function (e) {
            e.preventDefault();
            var datas = $(this).serialize();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/update_ss",
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

        });

        $("#edit_details").click(function (e) {
            e.preventDefault();
            $("#edit_tema_ss").val($("#t_tema_ss").text());
            $("#edit_masalah").val($("#t_masalah").text());
            $("#edit_ide_ss").val($("#t_ide_ss").text());
            $("#edit_tujuan_ss").val($("#t_tujuan_ss").text());
            $("#edit_status_ss").val($("#t_status_ss").text());
            $("#edit_masalah_modal").modal("show");
        });

        $("#alasan_tunda").click(function (e) {
            e.preventDefault();
            $("#modal_alasan_tunda").modal("show");
        });

        $(".link-fotobefore").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('name');
            var fpath = APP_URL + "/storage/img/ss/before/" + id;
            window.open(fpath, '_blank');
        });

        $(".link-fotoafter").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('name');
            var fpath = APP_URL + "/storage/img/ss/after/" + id;
            window.open(fpath, '_blank');
        });

        $(".link-add").click(function (e) {
            e.preventDefault();
            $("#edit_no_ss").val($("#no_masalah").text());
            $("#modal-addfoto").modal("show");
        });

        $(".link-add-before").click(function (e) {
            e.preventDefault();
            $("#edit_no_ss").val($("#no_masalah").text());
            $("#modal-addfoto-before").modal("show");
        });

        $("#form_add").submit(function (e) {
            e.preventDefault();
            var datas = new FormData(this);

            var btn = $("#edit_simpan");

            btn.attr('disabled', true);
            $.ajax({
                type: "POST",
                url: APP_URL + "/addfoto/after",

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
        });

        $("#form_add_before").submit(function (e) {
            e.preventDefault();
            var datas = new FormData(this);

            var btn = $("#edit_simpan1");

            btn.attr('disabled', true);
            $.ajax({
                type: "POST",
                url: APP_URL + "/addfoto/before",

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
        });

        $("#btn_delete").click(function () {
            var data = $("#id_ss").val();
            var nomer = $("#no_masalah").html();
            var conf = confirm("Apakah SS dengan No. " + nomer + " akan dihapus?");
            if (conf) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/hapus/ss",
                    headers: { "token_req": key },
                    data: { "id": data },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert("Hapus SS berhasil");
                            window.location.href = "{{ route('ss_list')}}";
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

        $("#btn_et1").click(function () {
            var iddata = $("#id_ss").val();
            var rb3 = $("input[name='r3']:checked").val();
            var nomer = $("#no_masalah").html();
            /*if ($('#r-dijalankan').is(':checked') || $('#r-ditolak').is(':checked') || $('#r-ditunda').is(':checked')) {
                if (rb3 == 'Pengerjaan') {
                    var conf = confirm("Apakah SS dengan No. " + nomer + " Lanjut ke Proses  " + rb3 + " ?");
                } else {
                    var edit_tolaktunda = $("#edit_tolaktunda").val();
                    $("#modal-tolaktunda").modal('show');
                    //var conf = confirm("Apakah SS dengan No. " + nomer + " Akan di  " + rb3 + " ?");
                }
                if (conf) {
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/ssET1",
                        headers: { "token_req": key },
                        data: { "iddata": iddata, "rb3": rb3 },
                        dataType: "json",
                    })
                        .done(function (resp) {
                            if (resp.success) {
                                alert("Update Data Success .");
                                window.location.href = "{{ route('ss_list')}}";
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
            } else {
                alert('Please fill in your choice .');
            }*/

            if ($('#r-dijalankan').is(':checked')) {
                var conf = confirm("Apakah SS dengan No. " + nomer + " Lanjut ke Proses  " + rb3 + " ?");
                if (conf) {
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/ssET1",
                        headers: { "token_req": key },
                        data: { "iddata": iddata, "rb3": rb3 },
                        dataType: "json",
                    })
                        .done(function (resp) {
                            if (resp.success) {
                                alert("Update Data Success .");
                                //window.location.href = "{{ route('ss_list')}}";
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
            } else if ($('#r-ditolak').is(':checked') || $('#r-ditunda').is(':checked')) {
                var edit_tolaktunda = $("#edit_tolaktunda").val();
                $("#modal-tolaktunda").modal('show');

                $("#btn_tolaktunda").click(function () {
                    var edit_tolaktunda = $("#edit_tolaktunda").val();
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/ssET1",
                        headers: { "token_req": key },
                        data: { "iddata": iddata, "rb3": rb3, "edit_tolaktunda": edit_tolaktunda },
                        dataType: "json",
                    })
                        .done(function (resp) {
                            if (resp.success) {
                                alert("Update Data Success .");
                                $("#modal-tolaktunda").modal('toggle');
                                location.reload();
                                //window.history.back();
                                //window.location.href = "{{url('iso/sslist')}}";

                            }
                            else {
                                alert(resp.message)
                                location.reload();
                            }
                        })
                        .fail(function () {
                            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                        });
                });

            } else {
                alert('Please fill in your choice .');
            }
        });

        $("#btn_close").click(function () {
            location.reload();
        });



    });

</script>

@endsection