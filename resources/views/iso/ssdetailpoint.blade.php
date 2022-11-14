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
                            <a class="float-right btn btn-warning btn-xs" id="t_status_ss">{{$detail->status_ss}}</a>
                        </li>
                        @else
                        <li class="list-group-item">
                            <b>Status </b>
                            <a class="float-right btn btn-danger btn-xs" style="color:white;"
                                id="t_status_ss">{{$detail->status_ss}}</a>
                        </li>
                        @endif
                        <li class="list-group-item">
                            <b>Foto Sebelum </b>
                            @if($detail->foto_before != null)
                            <a href="#" class="link-black text-sm link-fotobefore float-right"
                                id="{{$detail->foto_before}}" name="{{$detail->foto_before}}"><i
                                    class="fas fa-paperclip mr-1">
                                </i>Lampiran
                            </a>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <b>Foto Setelah </b>
                            @if($detail->foto_after != null)
                            <a href="#" class="link-black text-sm link-fotoafter float-right"
                                id="{{$detail->foto_after}}" name="{{$detail->foto_after}}"><i
                                    class="fas fa-paperclip mr-1">
                                </i>Lampiran
                            </a>
                            @endif
                        </li>
                        <p></p>
                        <div class="row">
                            <div class="col col-md-8">
                                <label for="">Poin SS</label>
                            </div>
                            <!--<b>Poin SS </b><input type="number" class="float-right form-control col-md-3" id="e_poin" name="e_poin">-->
                            <div class="col col-md-4">
                                <select name="e_poin" id="e_poin" class="float-right form-control select2" required>
                                    <option selected value="">Choose...</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                    <option value="60">60</option>
                                    <option value="65">65</option>
                                    <option value="70">70</option>
                                    <option value="75">75</option>
                                    <option value="80">80</option>
                                    <option value="85">85</option>
                                    <option value="90">90</option>
                                    <option value="95">95</option>
                                    <option value="100">100</option>
                                </select>

                            </div>
                        </div>
                        <p></p>
                        <li class="list-group-item">
                            <textarea class="form-control col-md-12" name="e_keterangan" id="e_keterangan" cols="30"
                                rows="2" placeholder="Keterangan"></textarea>
                        </li>
                        <li class="list-group-item">
                            <button type="button" class="btn btn-success btn-flat col-md-12"
                                id="btn-simpan">Simpan</button>
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
                                style="width: 650px; height: 450px;">
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
                                style="width: 650px; height: 450px;">
                        </center>
                    </a>

                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>


@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script>
    $(function () {

        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');

        $("#btn-simpan").click(function () {
            var id_ss = $("#id_ss").val();
            var no_masalah = $("#no_masalah").html();
            var e_poin = $("#e_poin").val();
            var e_keterangan = $("#e_keterangan").val();
            if ($("#e_poin").val() == null || $("#e_poin").val() == '') {
                alert('Poin SS belum diisi .');
            } else {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/iso/addpoint",
                    headers: {
                        "token_req": key
                    },
                    data: {
                        "id_ss": id_ss,
                        "no_masalah": no_masalah,
                        "e_poin": e_poin,
                        "e_keterangan": e_keterangan,
                    },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert("Update Poin berhasil");
                            window.location.href = "{{ route('ss_list_point')}}";
                            //location.reload();
                        } else
                            alert(resp.message);

                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            }
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

    });

</script>

@endsection